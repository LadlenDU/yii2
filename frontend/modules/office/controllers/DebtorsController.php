<?php

namespace frontend\modules\office\controllers;

use common\helpers\DebtHelper;
use common\models\DebtDetails;
use common\models\Debtor;
use common\models\DebtDetailsSearch;
use common\models\DebtorSearch;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\UploadForm;
use common\models\debtor_parse\DebtorParse;
//use common\components\ColumnNotFoundException;
//use yii\data\ActiveDataProvider;
//use yii\data\ArrayDataProvider;
//use common\models\UserInfo;

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

    public function actionDocument($debtorId)
    {
        if ($debtor = DebtDetails::findOne($debtorId)) {
            //$court = DebtHelper::findCourtAddressForDebtor($debtor, 'common\models\Court');
        } else {
            throw new \Exception(Yii::t('app', 'Не найден должник.'));
        }

        //TODO: use Yii::$app->getResponse()->sendContentAsFile(...)->send();
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=document.pdf");

        // Выводим содержимое файла
        #$objWriter = new \PHPExcel_Writer_Excel5($xls);
        #$objWriter->save('php://output');

        exit;
    }

    protected function handleDebtorsExcelFile(UploadForm $uploadModel)
    {
        $uploadModel->excelFile = UploadedFile::getInstance($uploadModel, 'excelFile');
        if ($fileName = $uploadModel->uploadExcel()) {
            // file is uploaded successfully
            $objPHPExcel = \PHPExcel_IOFactory::load($fileName);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $this->addDebtors($sheetData);
        }
    }

    protected function handleDebtorsCsvFile(UploadForm $uploadModel)
    {
        $uploadModel->csvFile = UploadedFile::getInstance($uploadModel, 'csvFile');
        if ($fileName = $uploadModel->uploadCsv()) {
            if ($handle = fopen($fileName, 'r')) {
                $sheetDataRaw = [];
                $count = 0;
                while (($data = fgetcsv($handle, 0, ';')) !== false) {
                    $sheetDataRaw[] = $data;
                }
                fclose($handle);

                $sheetData = DebtorParse::format_1($sheetDataRaw);
                $this->addDebtors($sheetData);

            } else {
                //TODO: логирование
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Не удался импорт из-за внутренней ошибки.'));
            }
        }
    }

    protected function addDebtors($sheetData)
    {
        try {
            $info = DebtorParse::scrapeDebtorsFromArray($sheetData);
            $saveResult = DebtorParse::saveDebtors($info);
            $msg = Yii::t('app', 'Успешно прошла операция добавления в БД.') . "\n";
            $addedNumber = empty($saveResult['added']) ? 0 : $saveResult['added'];
            $updatedNumber = empty($saveResult['updated']) ? 0 : $saveResult['updated'];
            $msg .= "Должников добавлено: $addedNumber\n"
                . "Должников обновлено: $updatedNumber\n";
            Yii::$app->getSession()->setFlash('success', $msg);
        } catch (\Exception $e) {
            Yii::$app->getSession()->setFlash('error', $e->getMessage());
        }
    }

    public function actionDebtVerification()
    {
        $uploadModel = new UploadForm();

        //$sheetData = '';

        if (Yii::$app->request->isPost) {
            switch (Yii::$app->request->post('action')) {
                case 'upload_debtors_excel': {
                    $this->handleDebtorsExcelFile($uploadModel);
                    break;
                }
                case 'upload_debtors_csv': {
                    $this->handleDebtorsCsvFile($uploadModel);
                    break;
                }
                default: {
                    break;
                }
            }
        }

        /*$dataProvider = new ActiveDataProvider([
            //'allModels' => Debtor::find()->with('debtDetails')->all(),
            'query' => Debtor::find()->with(['debtDetails']),
        ]);

        $searchModel = new DebtorSearch(Yii::$app->request->post);*/

        //TODO: debtorDetails выбираются каждый раз - оптимизировать (также проверить pagination)
        #$searchModel = new DebtorSearch();
        #$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel = new DebtDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //$userInfoModel = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();

        return $this->render('debt-verification',
            [
                'uploadModel' => $uploadModel,
                //'sheetData' => $sheetData,
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                //'userInfoModel' => $userInfoModel,
            ]);
    }

    public function actionStatement($debtorId)
    {
        $this->layout = 'statement';
        $this->view->title = \Yii::t('app', 'Заявление в суд');

        $debtDetails = DebtDetails::findOne($debtorId);
        if (!$debtDetails) {
            throw new \yii\web\NotFoundHttpException();
        }
        $court = DebtHelper::findCourtAddressForDebtor($debtDetails, 'common\models\Court');

        return $this->render('statement',
            [
                'debtDetails' => $debtDetails,
                'court' => $court,
                'userInfo' => Yii::$app->user->identity->userInfo,
            ]
        );
    }

    public function actionPrintDocuments()
    {
        $this->layout = 'print_fine';
        $this->view->title = \Yii::t('app', 'Пакет документов');
        $debtorIds = Yii::$app->request->post('debtorIds');
        $this->getStatementHtml($debtorIds[0]);
    }

    protected function getFullReportFineDataHtml($debtorId)
    {
        $html = '';

        if ($debtor = Debtor::findOne($debtorId)) {
            $periods = $debtor->getFineCalculatorResult();

            $fine = new \common\models\Fine();
            //$html = $fine->getBuhHtml($periods);
            $html = $fine->getClassicHtml($periods);
        }

        $data = [
            'html' => $html,
            'debtorId' => $debtorId,
            'debtorLS' => $debtor->LS_IKU_provider,
            'debtorName' => $debtor->name->full_name,
            'debtorAddress' => $debtor->location->full_address,
        ];

        //TODO: костыль - не в том месте
        set_time_limit(300);
        $html = $this->renderPartial('_full_report_fine_data', $data);
        return $html;
    }

    protected function getStatementHtml($debtorId)
    {
        $params = [];
        $debtor = Debtor::findOne($debtorId);
        if ($debtor) {
            $court = DebtHelper::findCourtAddressForDebtor($debtor, 'common\models\Court');
            $company = DebtHelper::findCompanyAddressForDebtor($debtor);
            $params = [
                'debtor' => $debtor,
                'court' => $court,
                'company' => $company,
            ];
        }
        return $this->renderPartial('statement', $params);
    }

    public function actionStatements()
    {
        #$debtorIds = $_POST['debtorIds'];
        $debtorIds = Yii::$app->request->post('debtorIds');

        $this->layout = 'statement';
        $this->view->title = \Yii::t('app', 'Заявления в суд');

        $debts = [];

        //TODO: оптимизировать
        foreach ($debtorIds as $dId) {
            //$debtDetails = DebtDetails::findOne($dId);
            $debtor = Debtor::findOne($dId);
            if ($debtor) {
                $court = DebtHelper::findCourtAddressForDebtor($debtor, 'common\models\Court');
                $company = DebtHelper::findCompanyAddressForDebtor($debtor);
                $debts[] = [
                    //'debtDetails' => $debtDetails,
                    'debtor' => $debtor,
                    'court' => $court,
                    'company' => $company,
                ];
            }
        }

        if (!$debts) {
            throw new \yii\web\NotFoundHttpException();
        }

        return $this->render('statements',
            [
                'debts' => $debts,
                //'userInfo' => Yii::$app->user->identity->userInfo,
            ]
        );

        //Yii::$app->html2pdf->convert($html)->send('Debts.pdf');
    }

    public function actionInvoicePrev(array $debtorIds)
    {
        $fileName = \Yii::getAlias('@common/data/sber_pd4.xls');
        $xls = \PHPExcel_IOFactory::load($fileName);

        foreach ($debtorIds as $key => $id) {
            //TODO: лажа - переделать (заодно переименовывать первую страницу)
            if ($key) {
                $newSheet = clone $sheet;
                $newSheet->setTitle('Должник ' . $id);
                $xls->addSheet($newSheet);
            }

            $xls->setActiveSheetIndex($key);
            $sheet = $xls->getActiveSheet();
            #$sheet->setTitle();

            if ($debtor = DebtDetails::findOne($id)) {
                $court = DebtHelper::findCourtAddressForDebtor($debtor, 'common\models\Court');
            } else {
                throw new \Exception(Yii::t('app', 'Не найден должник.'));
            }

            DebtHelper::fillInvoiceBlank($debtor, $court, $sheet);
        }

        //TODO: use Yii::$app->getResponse()->sendContentAsFile(...)->send();
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=pd4.xls");

        // Выводим содержимое файла
        $objWriter = new \PHPExcel_Writer_Excel5($xls);
        $objWriter->save('php://output');

        exit;

        /*return $this->renderPartial('invoice-prev',
            [
                'debtorId' => $debtorId,
                'debtor' => $debtor,
                'court' => $court,
            ]);*/
    }
}
