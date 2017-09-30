<?php

namespace frontend\modules\office\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\UserInfo;
use common\models\info\LegalEntity;
use common\models\info\IndividualEntrepreneur;
use common\models\info\Individual;
use yii\web\UploadedFile;
use common\models\info\UserFilesExt;

/**
 * Default controller for the `office` module
 */
class DefaultController extends Controller
{
    //TODO: перенести правило в модуль ???
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUserFile($id, $action = false)
    {
        switch ($action) {
            case 'download': {
                UserFilesExt::outputFile($id);
                break;
            }
            case 'remove': {
                UserFilesExt::remove($id);
                break;
            }
            default: {
                // inline
                UserFilesExt::outputInline($id);
                break;
            }
        }
        //if ($infoModel = UserFiles::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()) {
        /*if ($infoModel = UserFiles::findOne($id)) {
            header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-type: " . $infoModel->mime_type);
            //header("Content-Disposition: attachment; filename=" . $infoModel->name);
            header("Content-Disposition: inline");

            echo $infoModel->content;
            exit;
        }*/
    }

    public function actionMyOrganization()
    {
        $params = [];
        $viewName = 'index';

        //TODO: код переместить в модель
        if ($infoModel = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()) {
            switch ($infoModel->attributes['registration_type_id']) {
                case 1: {
                    // юридическое лицо
                    if (!$model = LegalEntity::find()->where(['user_info_id' => $infoModel->id])->one()) {
                        $model = new LegalEntity();
                    }
                    $viewName = 'legal_entity';
                    break;
                }
                case 2: {
                    // индивидуальный предприниматель
                    if (!$model = IndividualEntrepreneur::find()->where(['user_info_id' => $infoModel->id])->one()) {
                        $model = new IndividualEntrepreneur();
                    }
                    $viewName = 'individual_entrepreneur';
                    break;
                }
                case 3: {
                    // физическое лицо
                    if (!$model = Individual::find()->where(['user_info_id' => $infoModel->id])->one()) {
                        $model = new Individual();
                    }
                    $viewName = 'individual';
                    break;
                }
                default: {
                    break;
                }
            }

            if (!empty($model)) {
                if ($model->load(Yii::$app->request->post())) {
                    //$model->birthday = date('Y-m-d H:i:s', strtotime($model->birthday));
                    if ($model->validate()) {
                        $model->user_info_id = $infoModel->id;

                        if ($uploadedFiles = UploadedFile::getInstances($model->userInfo, 'user_files')) {
                            foreach ($uploadedFiles as $upFile) {
                                //$infoModel->link(= file_get_contents($upFile->tempName);
                                $userFiles = new UserFiles();
                                //$userFiles = $model->userInfo->userFiles;
                                $userFiles->content = file_get_contents($upFile->tempName);
                                $userFiles->name = $upFile->name;
                                $userFiles->mime_type = $upFile->type;
                                $userFiles->save();
                                $infoModel->link('userFiles', $userFiles);
                                $infoModel->save(false);
                            }
                        }

                        /*$document_1 = UploadedFile::getInstance($model, 'user_info_document_1');
                        $document_2 = UploadedFile::getInstance($model, 'user_info_document_2');

                        if ($document_1) {
                            $infoModel->document_1 = file_get_contents($document_1->tempName);
                        }
                        if ($document_2) {
                            $infoModel->document_2 = file_get_contents($document_2->tempName);
                        }*/

                        if ($model->save()) {
                            /*if ($document_1 || $document_2) {
                                //TODO: add transaction - https://stackoverflow.com/questions/32522404/yii2-saving-file-to-oracle-blob
                                $infoModel->save(false);
                            }*/
                            /*if ($model->upload()) {
                                // file is uploaded successfully
                                // TODO обработка неудачной загрузки
                            }*/
                            // form inputs are valid, do something here
                            Yii::$app->session->setFlash('success', Yii::t('app', 'Форма успешно сохранена.'));
                            //return;
                        } else {
                            Yii::$app->session->setFlash('danger', Yii::t('app', 'Не удалось сохранить форму.'));
                        }
                    } else {
                        Yii::$app->session->setFlash('error', Yii::t('app', 'Форма не прошла валидацию.'));
                    }
                }

                $params['model'] = $model;
            }
        }

        return $this->render($viewName, $params);
    }
}
