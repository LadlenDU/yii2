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

    public function actionMyOrganization()
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
                    //$model->birthday = date('Y-m-d H:i:s', strtotime($model->birthday));
                    if ($model->validate()) {
                        $model->user_info_id = $infoModel->id;

                        $document_1 = UploadedFile::getInstance($model, 'user_info_document_1');
                        $document_2 = UploadedFile::getInstance($model, 'user_info_document_2');

                        if ($document_1) {
                            $infoModel->document_1 = file_get_contents($document_1->tempName);
                        }
                        if ($document_2) {
                            $infoModel->document_2 = file_get_contents($document_2->tempName);
                        }

                        if ($model->save()) {
                            if ($document_1 || $document_2) {
                                //TODO: add transaction - https://stackoverflow.com/questions/32522404/yii2-saving-file-to-oracle-blob
                                $infoModel->save(false);
                            }
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
