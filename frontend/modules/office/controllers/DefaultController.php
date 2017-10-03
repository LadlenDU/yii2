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
use yii\filters\VerbFilter;
use common\models\info\CompanySearch;

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
    }

    public function actionMyOrganization()
    {
        $params = [];
        $viewName = 'index';

        //TODO: код переместить в модель
        //TODO: также проверить корректно ли работает  UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()
        //if ($infoModel = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()) {
        if ($infoModel = Yii::$app->user->identity->userInfo) {
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
                                $userFiles = new UserFilesExt();
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

        // Компании пользователя
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
}
