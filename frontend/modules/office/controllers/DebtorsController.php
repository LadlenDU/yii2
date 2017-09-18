<?php

namespace frontend\modules\office\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\UploadForm;

#use common\models\UserInfo;
#use common\models\info\LegalEntity;
#use common\models\info\IndividualEntrepreneur;
#use common\models\info\Individual;


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
        $uploadModel = new UploadForm();

        $sheetData = '';

        if (Yii::$app->request->isPost) {
            $uploadModel->excelFile = UploadedFile::getInstance($uploadModel, 'excelFile');
            if ($fileName = $uploadModel->upload()) {
                // file is uploaded successfully
                $objPHPExcel = \PHPExcel_IOFactory::load($fileName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                #print_r($sheetData);
                #return;
            }
        }

        return $this->render('debt-verification',
            [
                'uploadModel' => $uploadModel,
                'sheetData' => $sheetData
            ]);
    }
}
