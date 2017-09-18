<?php

namespace frontend\modules\office\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\UploadForm;
use common\models\DebtorParse;
use common\components\ColumnNotFoundException;

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

                try {
                    $info = DebtorParse::scrapeDebtorsFromArray($sheetData);
                    DebtorParse::saveDebtors($info);
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Должники успешно добавлены в БД.'));
                } catch (\Exception $e) {
                    Yii::$app->getSession()->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('debt-verification',
            [
                'uploadModel' => $uploadModel,
                'sheetData' => $sheetData,
            ]);
    }
}
