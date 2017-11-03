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
use common\models\info\UserFiles;
use yii\filters\VerbFilter;
use common\models\info\CompanySearch;
use common\helpers\FileUploadHelper;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $model = $this->findUserFilesModel($id);
        FileUploadHelper::handleAction($model, $action);
        /*switch ($action) {
            case 'download': {
                $model->outputFile();
                break;
            }
            case 'remove': {
                $model->remove();
                break;
            }
            default: {
                // inline
                $model->outputInline();
                break;
            }
        }*/
    }

    public function actionMyOrganization()
    {
        //Yii::$app->user->identity->userInfo->primaryCompany->id;
        ///office/company/view?id=6
        if (!empty(Yii::$app->user->identity->userInfo->primaryCompany)) {
            $this->redirect(['/office/my-organization/view', 'id' => Yii::$app->user->identity->userInfo->primaryCompany->id]);
        }
        //TODO: add error code of something
        return $this->render('no_default_organization');

        $params = [];
        $viewName = 'index';

        $fileUpload = new FileUploadHelper('/office/user-file');

        //TODO: код переместить в модель
        //TODO: также проверить корректно ли работает  UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()
        //if ($infoModel = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()) {
        if ($infoModel = Yii::$app->user->identity->userInfo) {
            $model = $infoModel->getRelatedModel();
            $viewName = \frontend\helpers\UserHelper::getViewByRelatedModel($model);

            if ($model) {
                if ($model->load(Yii::$app->request->post())) {
                    //$model->birthday = date('Y-m-d H:i:s', strtotime($model->birthday));
                    if ($model->validate()) {
                        $model->user_info_id = $infoModel->id;

                        if ($uploadedFiles = UploadedFile::getInstances($model->userInfo, 'user_files')) {
                            foreach ($uploadedFiles as $upFile) {
                                $userFiles = new UserFiles();
                                $userFiles->content = file_get_contents($upFile->tempName);
                                $userFiles->name = $upFile->name;
                                $userFiles->mime_type = $upFile->type;
                                $userFiles->save();
                                $infoModel->link('userFiles', $userFiles);
                                //$infoModel->save(false);
                            }
                        }

                        //TODO: оптимизировать
                        if ($infoModel->load(Yii::$app->request->post())) {
                            if (!$infoModel->validate() || !$infoModel->save()) {
                                Yii::$app->session->setFlash('danger', Yii::t('app', 'Произошла ошибка при сохранении формы.'));
                            }
                        }

                        if ($model->save()) {
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

        $params['fileUploadConfig'] = $fileUpload->fileUploadConfig(empty($model->userInfo->userFiles) ? [] : $model->userInfo->userFiles);

        // Организации пользователя
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $params['companies'] = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];

        //$dataProvider = $infoModel->companies->search(Yii::$app->request->queryParams);
        //$params['companies'] = $infoModel->companies;
        /*$params['companies'] = [
            'searchModel' => $infoModel->companies,
            'dataProvider' => $dataProvider,
        ];*/

        return $this->render($viewName, $params);
    }

    protected function findUserFilesModel($id)
    {
        if (($model = UserFiles::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException();
    }
}
