<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\UserInfo;
use common\models\info\LegalEntity;
use common\models\info\IndividualEntrepreneur;
use common\models\info\Individual;

class ManagerController extends \yii\web\Controller
{
    public $layout = 'manager/main';

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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionInfo()
    {
        $params = [];
        $viewName = 'index';

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
                    if ($model->validate()) {
                        $model->user_info_id = $infoModel->id;
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

        return $this->render($viewName, $params);
    }
}
