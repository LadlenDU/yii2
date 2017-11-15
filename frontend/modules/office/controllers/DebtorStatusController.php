<?php

namespace frontend\modules\office\controllers;

use common\models\DebtorStatusFiles;
use Yii;
use common\models\DebtorStatus;
use yii\web\NotFoundHttpException;
use common\models\Debtor;
use yii\web\UploadedFile;
use common\helpers\FileUploadHelper;

class DebtorStatusController extends \yii\web\Controller
{
    public function actionStatusFiles($id, $action = false)
    {
        $model = $this->findDebtorStatusFilesModel($id);
        FileUploadHelper::handleAction($model, $action);
    }

    protected function findDebtorStatusFilesModel($id)
    {
        if (($model = DebtorStatusFiles::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException();
    }

    public function actionIndex(array $debtorIds, $redirect)
    {
        $needRedirect = false;

        $debtorIds = (array)$debtorIds;

        //TODO: !!! вынести $debtorIds в actionUpdate, вроде того
        if ($debtorIds[0] == 'all') {
            $debtorIds = [];
            $dCount = Yii::$app->user->identity->userInfo->primaryCompany->getDebtors()->select('id')->all();
            //TODO: использовать ArrayMap, вроде того
            foreach ($dCount as $el) {
                $debtorIds[] = $el['id'];
            }
        }

        foreach ($debtorIds as $debtorId) {
            $debtorStatus = $this->findModel($debtorId);
            if ($debtorStatus->load(Yii::$app->request->post()) && $debtorStatus->save()) {
                if ($debtorStatus->validate()) {
                    if ($uploadedFiles = UploadedFile::getInstances($debtorStatus, 'debtorStatusFiles')) {
                        foreach ($uploadedFiles as $upFile) {
                            $dsFiles = new DebtorStatusFiles();
                            $dsFiles->content = file_get_contents($upFile->tempName);
                            $dsFiles->name = $upFile->name;
                            $dsFiles->mime_type = $upFile->type;
                            $dsFiles->save();
                            $debtorStatus->link('debtorStatusFiles', $dsFiles);
                        }
                    }

                    if (!$debtorStatus->save()) {
                        //TODO: обработка ошибок (какой-нибудь попап)
                    }
                    $needRedirect = true;
                } else {
                    //TODO: обработка ошибок
                }
            }
        }

        if ($needRedirect) {
            return $this->redirect($redirect ?: ['/office/debtor']);
        }

        if (count($debtorIds) > 1) {
            // меняем для нескольких должников - выдаем пустую форму
            $debtorStatus = new DebtorStatus();
        }

        $fileUpload = new FileUploadHelper('/office/debtor-status/status-files');
        $fileUploadConfig = $fileUpload->fileUploadConfig(empty($debtorStatus->debtorStatusFiles) ? [] : $debtorStatus->debtorStatusFiles);

        //allowedFileExtensions: [jpeg, png, pdf, doc, docx, xls, xlsx],
        //$fileUploadConfig['options']['accept'] = ['application/pdf', 'image/jpeg', 'image/png'];
        $fileUploadConfig['pluginOptions']['initialPreviewConfig'][0]['width'] = '50px';

        $fileUploadConfig['options']['allowedFileExtensions'] = ['jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $fileUploadConfig['options']['initialPreview'] = [
            'other' => 'width:50px;height:50px;'
        ];

        $config = [
            'debtorIds' => $debtorIds,
            'redirect' => $redirect,
            'debtorStatus' => $debtorStatus,
            'fileUploadConfig' => $fileUploadConfig,
        ];

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_status_info', $config);
        } else {
            return $this->render('_status_info', $config);
        }
    }

    /*public function actionSave($debtorId)
    {
        $debtorStatus = $this->findModel($debtorId);

        if ($debtorStatus->load(Yii::$app->request->post()) && $debtorStatus->save()) {

            return $this->redirect(['/office/debtor']);
        }
    }*/

    protected function findModel($id)
    {
        if (($model = Debtor::findOne($id)) !== null) {

            //TODO: попробовать перенести в модель этот костыль
            if (!$model->status) {
                $status = new DebtorStatus();
                $status->save();
                $model->link('status', $status);
                $model->save();
            }

            return $model->status;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
