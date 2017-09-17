<?php

namespace frontend\modules\office\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\UserInfo;
use common\models\info\LegalEntity;
use common\models\info\IndividualEntrepreneur;
use common\models\info\Individual;


/**
 * Default controller for the `office` module
 */
class DebtorsController extends Controller
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

    public function actionDebtVerification()
    {
        $params = [];
        return $this->render('debt-verification', $params);
    }
}
