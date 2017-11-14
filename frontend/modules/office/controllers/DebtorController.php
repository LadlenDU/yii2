<?php

namespace frontend\modules\office\controllers;

use common\models\AccrualSearch;
use Yii;
use common\models\Debtor;
use common\models\DebtorSearch;
use common\models\Location;
use common\models\Name;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Fine;
use common\models\Accrual;
use common\models\Payment;
use common\models\UploadForm;
use yii\data\ArrayDataProvider;
use common\helpers\DebtHelper;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\DebtorStatus;
use common\models\helpers\DebtorCommonRecalculateMonitor;

//use kartik\mpdf\Pdf;

/**
 * DebtorController implements the CRUD actions for Debtor model.
 */
class DebtorController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all Debtor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $uploadModel = new UploadForm();

        if (Yii::$app->request->isPost) {

            //TODO: костыль - исправить
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 100000);
            ignore_user_abort(true);

            switch (Yii::$app->request->post('action')) {
                case 'upload_debtors_excel': {
                    Debtor::handleDebtorsExcelFile($uploadModel);
                    break;
                }
                case 'upload_debtors_excel_a_user': {
                    Debtor::handleDebtorsExcelFileAUser($uploadModel);
                    break;
                }
                /*case 'upload_debtors_excel_type_1': {
                    Debtor::handleDebtorsExcelType1($uploadModel);
                    break;
                }*/
                case 'upload_debtors_csv': {
                    Debtor::handleDebtorsCsvFile($uploadModel);
                    break;
                }
                default: {
                    break;
                }
            }
        }

        $searchModel = new DebtorSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadModel' => $uploadModel,
            'showSearchPane' => Yii::$app->request->queryParams['search'] ?? false,
            'showReportHandleButtons' => $searchModel->application_package,
        ]);
    }

    public function actionRemoveDebtorsFromReport($debtorIds)
    {
        foreach ($debtorIds as $dId) {
            if ($debtor = $this->findModel($dId)) {
                $debtor->status->status = 'new';
                $debtor->status->save();
                //TODO: рассмотреть удаление (unlink($name, $model, true))
                \Yii::$app->user->identity->applicationPackageToTheContract->unlink('debtors', $debtor);
            }
        }
        return '';
    }

    /**
     * Displays a single Debtor model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Debtor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Debtor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //$locationModel = Location::find()->where(['location_id' => $model->location->id])->one();
            $locationModel = new Location();
            $locationModel->load(Yii::$app->request->post());
            $locationModel->save();
            $model->link('location', $locationModel);

            //$nameModel = Name::find()->where(['name_id' => $this->name->id])->one();
            $nameModel = new Name();
            $nameModel->load(Yii::$app->request->post());
            $nameModel->save();
            $model->link('name', $nameModel);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Debtor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //$locationModel = Location::find()->where(['location_id' => $this->location->id])->one();
            $locationModel = $model->location ? $model->location : new Location;
            //TODO: проверить, рефакторинг
            $locationModel->save();
            //$locationModel->link('debtor', $model);
            $model->link('location', $locationModel);
            $locationModel->load(Yii::$app->request->post());
            $locationModel->save();

            //$nameModel = Name::find()->where(['name_id' => $this->name->id])->one();
            $nameModel = $model->name ? $model->name : new Name;
            //TODO: проверить, рефакторинг
            $nameModel->save();
            $nameModel->link('debtor', $model);
            $nameModel->load(Yii::$app->request->post());
            $nameModel->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Debtor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Debtor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Debtor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
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

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInfoForFine($debtor_id)
    {
        $elements = [];

        if ($debtor = Debtor::findOne($debtor_id)) {
            $elements = $debtor->calcFines();
            /*if ($periods = $debtor->getFineCalculatorResult()) {
                foreach ($periods as $p) {
                    $totalFine = 0;
                    foreach ($p['data'] as $data) {
                        if ($data['type'] == Fine::DATA_TYPE_INFO) {
                            $totalFine += $data['data']['cost'];
                        }
                    }
                    $elements[] = [
                        'dateStart' => $p['dateStart'],
                        'fine' => $totalFine,
                    ];
                }
            }*/
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $elements,
            /*'sort' => [
                'attributes' => ['date'],
            ],*/
            /*'pagination' => [
                'pageSize' => 100,
            ],*/
        ]);

        $data = [
            'dataProvider' => $dataProvider,
            'debtorId' => $debtor_id,
        ];

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_fine_list', $data);
        } else {
            return $this->render('_fine_list', $data);
        }
    }

    /*public function actionInfoForDebtOld($debtor_id)
    {
        $elements = [];

        $accruals = Accrual::find()->where(['debtor_id' => $debtor_id])->all();
        foreach ($accruals as $acc) {
            $elem['debt'] = Debtor::getDebt(strtotime($acc->accrual_date));
            $elem['date'] = $acc->accrual_date;
            $elements[] = $elem;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $elements,
        ]);

        $data = [
            'dataProvider' => $dataProvider,
        ];

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_debt_list', $data);
        } else {
            return $this->render('_debt_list', $data);
        }
    }*/

    public function actionInfoForDebt($debtor_id)
    {
        $elements = [];

        if ($debtor = Debtor::findOne($debtor_id)) {
            $elements = $debtor->calcDebts(['order' => 'dateStart', 'direction' => 'asc']);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $elements,
            /*'sort' => [
                'attributes' => ['date'],
            ],*/
            /*'pagination' => [
                'pageSize' => 100,
            ],*/
        ]);

        $data = [
            'dataProvider' => $dataProvider,
        ];

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_debt_list', $data);
        } else {
            return $this->render('_debt_list', $data);
        }
    }

    protected function getFullReportFineDataHtml(Debtor $debtor)
    {
        $html = '';

        if ($debtor) {
            $periods = $debtor->getFineCalculatorResult();

            $fine = new \common\models\Fine();
            //$html = $fine->getBuhHtml($periods);
            $html = $fine->getClassicHtml($periods);
        }

        $data = [
            'html' => $html,
            'debtorId' => $debtor->id,
            'debtorLS' => $debtor->LS_IKU_provider,
            'debtorName' => $debtor->name ? $debtor->name->full_name : '',
            'debtorAddress' => $debtor->location ? $debtor->location->createFullAddress() : '',
        ];

        //TODO: костыль - не в том месте
        //set_time_limit(300);
        $html = $this->renderPartial('_full_report_fine_data', $data);
        return $html;
    }

    protected function getStatementHtml(Debtor $debtor)
    {
        $params = [];
        //$debtor = Debtor::findOne($debtorId);
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

    /*public function actionPrintDocumentsPdf()
    {
        if (Yii::$app->user->identity->canPrint()) {
            $debtorIds = Yii::$app->request->get('debtorIds');

            try {
                $pdfTempPath = Yii::$app->html2pdf
                    //->loadResource(Url::to(['/office/debtor/print-documents', 'debtorIds' => $debtorIds, 'primaryCompany' => \Yii::$app->user->identity->userInfo->getPrimaryCompany()->one()->id], true))
                    ->loadResource(Url::to(['/office/debtor/print-documents', 'debtorIds' => $debtorIds], true))
                    ->execute()
                    ->getFile();

                Yii::$app->user->identity->printOperationStart();

                return Yii::$app->getResponse()->sendFile(
                    $pdfTempPath,
                    'DebtorInfo.pdf',
                    ['mimeType' => 'application/pdf', 'inline' => true]
                );
            } catch (\junqi\pdf\PdfException $e) {
                //TODO: дорабоать
                echo $e->getMessage();
            }
        } else {
            die('low_balance');
        }

        return '';
    }*/

    public function createPdfForDebtor($debtorId)
    {
        $debtor = Debtor::findOne($debtorId);

        $doc['statement'] = $this->getStatementHtml($debtor);
        $doc['full_fine_report'] = $this->getFullReportFineDataHtml($debtor);

        $rContent = Yii::$app->html2pdf->render('@frontend/modules/office/views/debtor/print_documents', ['doc' => $doc]);

        //TODO: проверять файл на принадлежность к формату pdf
        $tempFNameResult = tempnam(sys_get_temp_dir(), 'pdf_fine_') . '.pdf';

        $commandTail = '';

        $tempFNamePdf = false;
        $tempFNamePdfHouses = false;

        if (!empty(Yii::$app->user->identity->userInfo->primaryCompany->companyFiles)) {
            $tempFNamePdf = tempnam(sys_get_temp_dir(), 'pdf_fine_') . '.pdf';
            file_put_contents(
                $tempFNamePdf,
                Yii::$app->user->identity->userInfo->primaryCompany->companyFiles[0]->content
            );
            $commandTail .= " $tempFNamePdf ";
        }

        if (!empty(Yii::$app->user->identity->userInfo->primaryCompany->companyFilesHouses[0])) {
            $tempFNamePdfHouses = tempnam(sys_get_temp_dir(), 'pdf_fine_') . '.pdf';
            file_put_contents(
                $tempFNamePdfHouses,
                Yii::$app->user->identity->userInfo->primaryCompany->companyFilesHouses[0]->content
            );
            $commandTail .= " $tempFNamePdfHouses ";
        }

        //TODO: надо ли удалять $rContent->name ?

        $command = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=$tempFNameResult $rContent->name $commandTail 2>&1";
        $outputLines = [];
        exec($command, $outputLines, $exitCode);
        if ($exitCode !== 0) {
            //TODO: грамотное логирование
            throw new \Exception("Ошибка склеивания файлов': " . implode("\n", $outputLines));
        }

        //TODO: !!!! эти файлы пригодятся позже для других пользователей - вынести их за функцию
        $tempFNamePdf && unlink($tempFNamePdf);
        $tempFNamePdfHouses && unlink($tempFNamePdfHouses);

        return $tempFNameResult;
    }

    public function actionShowSubscriptionForAccruals($debtorId)
    {
        $this->layout = 'print_fine';
        $debtor = $this->findModel($debtorId);
        return $this->render('_template_subsription_accruals', ['debtor' => $debtor]);
    }

    public function actionPrintDocuments()
    {
        //TODO: move to model
        if (Yii::$app->user->identity->canPrint()) {

            //TODO: непонятной природы и вроде бессмысленное дублирование (может использовать xSendFile?)
            //TODO: это костыль чтобы исправить это дублирование
            if (!empty($_SERVER['HTTP_RANGE'])) {
                return '';
            }

            set_time_limit(400);

            //$documents = [];

            //$this->layout = 'print_fine';
            $this->view->title = \Yii::t('app', 'Пакет документов');

            $debtorIds = Yii::$app->request->get('debtorIds');

            Yii::$app->user->identity->printOperationStart();

            $tempFNameResults = [];

            foreach ($debtorIds as $dId) {

                $pdfItem = $this->createPdfForDebtor($dId);

                $tempFNameResult = tempnam(sys_get_temp_dir(), 'pdf_fine_1_') . '.pdf';

                $tempFNameResults[] = $tempFNameResult;

                $command = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=$tempFNameResult $pdfItem $pdfItem $pdfItem 2>&1";
                $outputLines = [];
                exec($command, $outputLines, $exitCode);
                if ($exitCode !== 0) {
                    //TODO: грамотное логирование
                    throw new \Exception("Ошибка склеивания файлов': " . implode("\n", $outputLines));
                }

                unlink($pdfItem);
            }

            $finalResultName = tempnam(sys_get_temp_dir(), 'pdf_fine_2_') . '.pdf';

            $pdfItemsQueryTail = implode(' ', $tempFNameResults);

            $command = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=$finalResultName $pdfItemsQueryTail 2>&1";
            $outputLines = [];
            exec($command, $outputLines, $exitCode);
            if ($exitCode !== 0) {
                //TODO: грамотное логирование
                throw new \Exception("Ошибка склеивания файлов': " . implode("\n", $outputLines));
            }

            foreach ($tempFNameResults as $item) {
                unlink($item);
            }

            //TODO: unlink $finalResultName

            //return Yii::$app->getResponse()->xSendFile(
            return Yii::$app->getResponse()->sendFile(
                $finalResultName,
                'DebtorInfo.pdf',
                [
                    'mimeType' => 'application/pdf',
                    'inline' => true,
                ]
            );


            $debtor = Debtor::findOne($debtorIds[0]);

            $doc['statement'] = $this->getStatementHtml($debtor);
            $doc['full_fine_report'] = $this->getFullReportFineDataHtml($debtor);

            /*if (!empty(Yii::$app->user->identity->userInfo->primaryCompany->companyFiles)) {
                $tempFNamePdf = tempnam(sys_get_temp_dir(), 'pdf_fine_') . '.pdf';
                file_put_contents(
                    $tempFNamePdf,
                    Yii::$app->user->identity->userInfo->primaryCompany->companyFiles[0]->content
                );
//                $pdf = new \Gufy\PdfToHtml\Pdf($tempFNamePdf);
//                $doc['EGRUL'] = $pdf->html();

                $tempImagePdf = tempnam(sys_get_temp_dir(), 'img_fine_') . '.jpg';

                $pdf = new \Spatie\PdfToImage\Pdf($tempFNamePdf);
                $pdf->saveImage($tempImagePdf);
                $imgData = $pdf->getImageData($tempImagePdf);

                unlink($tempImagePdf);
                unlink($tempFNamePdf);
            }*/

            $documents[] = $doc;

            //return $this->render('@frontend/modules/office/views/debtor/print_documents', ['documents' => $documents]);

            $rContent = Yii::$app->html2pdf->render('@frontend/modules/office/views/debtor/print_documents', ['documents' => $documents]);

            /*if (empty(Yii::$app->user->identity->userInfo->primaryCompany->companyFiles)
                && empty(Yii::$app->user->identity->userInfo->primaryCompany->companyFilesHouses)
            ) {
                Yii::$app->user->identity->printOperationStart();
                return $rContent->send('DebtorInfo.pdf', ['mimeType' => 'application/pdf', 'inline' => true]);
            }*/

            //TODO: проверять файл на принадлежность к формату pdf
            //TODO: склеивать множественные файлы pdf
            $tempFNameResult = tempnam(sys_get_temp_dir(), 'pdf_fine_') . '.pdf';

            $commandTail = '';

            if (!empty(Yii::$app->user->identity->userInfo->primaryCompany->companyFiles)) {
                $tempFNamePdf = tempnam(sys_get_temp_dir(), 'pdf_fine_') . '.pdf';
                file_put_contents(
                    $tempFNamePdf,
                    Yii::$app->user->identity->userInfo->primaryCompany->companyFiles[0]->content
                );
                $commandTail .= " $tempFNamePdf ";
            }

            if (!empty(Yii::$app->user->identity->userInfo->primaryCompany->companyFilesHouses[0])) {
                $tempFNamePdfHouses = tempnam(sys_get_temp_dir(), 'pdf_fine_') . '.pdf';
                file_put_contents(
                    $tempFNamePdfHouses,
                    Yii::$app->user->identity->userInfo->primaryCompany->companyFilesHouses[0]->content
                );
                $commandTail .= " $tempFNamePdfHouses ";
            }

            $command = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=$tempFNameResult $rContent->name $commandTail 2>&1";
            $outputLines = [];
            exec($command, $outputLines, $exitCode);
            if ($exitCode !== 0) {
                throw new \Exception("Ошибка склеивания файлов': " . implode("\n", $outputLines));
            }

            @file_put_contents('/tmp/look_for_pdf.txt', print_r($outputLines, true), FILE_APPEND);

            if (!empty($tempFNamePdf)) {
                unlink($tempFNamePdf);
            }
            if (!empty($tempFNamePdfHouses)) {
                unlink($tempFNamePdfHouses);
            }

            //TODO: unlink $tempFNameResult

            Yii::$app->user->identity->printOperationStart();

            //return Yii::$app->getResponse()->xSendFile(
            return Yii::$app->getResponse()->sendFile(
                $tempFNameResult,
                'DebtorInfo.pdf',
                ['mimeType' => 'application/pdf', 'inline' => true]
            );

            /*return $this->render('print_documents',
                [
                    'documents' => $documents,
                ]
            );*/
        } else {
            die('low_balance');
        }

        return '';
    }

    public function actionFullReportFineDataPdf($debtor_id)
    {
        try {
            Yii::$app->html2pdf->loadResource(Url::to(['/office/debtor/full-report-fine-data', 'debtor_id' => $debtor_id], true))
                ->execute()
                ->sendFile('Debts.pdf');
        } catch (\junqi\pdf\PdfException $e) {
            //TODO: дорабоать
            echo $e->getMessage();
        }
    }

    public function actionFullReportFineData($debtor_id)
    {
        $html = '';

        if ($debtor = Debtor::findOne($debtor_id)) {
            $periods = $debtor->getFineCalculatorResult();

            $fine = new Fine();
            //$html = $fine->getBuhHtml($periods);
            $html = $fine->getClassicHtml($periods);
        }

        $data = [
            'html' => $html,
            'debtorId' => $debtor_id,
            'debtorLS' => $debtor->LS_IKU_provider,
            'debtorName' => $debtor->name->full_name,
            'debtorAddress' => $debtor->location->createFullAddress(),
        ];

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_full_report_fine_data', $data);
        } else {
            set_time_limit(300);
            #error_reporting(E_ALL);
            #ini_set('display_errors', 1);
            $this->layout = 'print_fine';   //"@app/views/layouts/mainLayout";
            $html = $this->render('_full_report_fine_data', $data);
            //$content = $this->renderPartial('_full_report_fine_data', $data);
            return $html;
            //$tt = print_r(Yii::$app->html2pdf->convert($html)); exit;
            //Yii::$app->html2pdf->convert($html)->send('Debts.pdf');
            /*try {
                Yii::$app->html2pdf->loadResource($html)
                    ->execute()
                    ->sendFile('Debts.pdf');
            } catch (\junqi\pdf\PdfException $e) {
                echo $e->getMessage();
            }*/
            //exit;
            //->saveAs(fopen('php://stdout', 'w'));

            // setup kartik\mpdf\Pdf component
            /*$pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_CORE,
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
                'destination' => Pdf::DEST_BROWSER,
                // your html content input
                'content' => $content,
                // format content from your own css file if needed or use the
                // enhanced bootstrap css built by Krajee for mPDF formatting
                //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                'cssFile' => '@frontend/web/css/fine-style.css',
                #'cssFile' => '@frontend/web/css/fine-style.css',
                #$this->registerCssFile('/css/fine-style.css');
                #$this->registerCssFile('/css/fine-common.css');
                #$this->registerCssFile('/css/fine-bookkeeping.css');

                // any css to be embedded if required
                //'cssInline' => '.kv-heading-1{font-size:18px}',
                // set mPDF properties on the fly
                'options' => ['title' => Yii::t('app', 'Печать пени')],
                // call mPDF methods on the fly
                'methods' => [
                    'SetHeader' => ['Krajee Report Header'],
                    'SetFooter' => ['{PAGENO}'],
                ]
            ]);

            // return the pdf output as per the destination setting
            return $pdf->render();*/
        }
    }

    public function actionRecalculateTotalValueForADebtor($debtorId)
    {
        $debtor = Debtor::findOne($debtorId);
        $debtor->recalculateAllTotalValues();
        echo 'DONE';
    }

    /**
     * TODO: костыльная функция, надо перенести в админку
     */
    public function actionRecalculateAllTotalValues()
    {
        //TODO: костыль
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 10000);
        ignore_user_abort(true);

        if ($rMonitor = Yii::$app->user->identity->debtorCommonRecalculateMonitors) {
            $rMonitor = $rMonitor[count($rMonitor) - 1];
            //TODO: временный косытль чтобы перерасчитать на скорую руку. Надо смотреть не перерасчитан ли следующий месяц.
            if ($rMonitor->finished_at) {
                return 'Должник перерасчитан';
            }
            $rMonitor->continued_at = date('Y-m-d H:i:s');
        } else {
            $rMonitor = new DebtorCommonRecalculateMonitor();
            $rMonitor->total_debtors = count(Yii::$app->user->identity->debtors);
            $rMonitor->started_at = date('Y-m-d H:i:s');
            $rMonitor->link('user', Yii::$app->user->identity);
        }

        $rMonitor->save(false);

        if ($rMonitor->last_recounted_debtor_id) {
            $debtors = Yii::$app->user->identity->getDebtors()
                ->andWhere(['>', 'id', $rMonitor->last_recounted_debtor_id])->orderBy(['id' => SORT_ASC])->all();
        } else {
            $debtors = Yii::$app->user->identity->getDebtors()->orderBy(['id' => SORT_ASC])->all();
        }

        foreach ($debtors as $debtor) {
            $debtor->recalculateAllTotalValues();
            $rMonitor->last_recounted_debtor_id = $debtor->id;
            $rMonitor->save();
        }

        $rMonitor->finished_at = date('Y-m-d H:i:s');
        $rMonitor->save();

        //3130139485

        /*if (!empty($_GET['all_empty'])) {
            $debtors = Yii::$app->user->identity->getDebtors()->where(['state_fee' => null])->all();
            foreach ($debtors as $debtor) {
                $debtor->recalculateAllTotalValues();
            }
        } else {
            if (empty($_GET['backwards'])) {
                foreach (Yii::$app->user->identity->debtors as $debtor) {
                    $debtor->recalculateAllTotalValues();
                }
            } else {
                $debtorCount = count(Yii::$app->user->identity->debtors);
                for ($i = $debtorCount - 1; $i >= 0; --$i) {
                    $debtor = Yii::$app->user->identity->debtors[$i];
                    $debtor->recalculateAllTotalValues();
                }
            }
        }*/

        return 'Должники перерасчитаны';
    }

    public function actionGetReportFile(array $debtorIds)
    {
        //TODO: костыль - исправить
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 20000);
        ignore_user_abort(true);

        //TODO: вынести в модель
        $fName = Yii::getAlias('@common/data/DebtorsReportTemplate.xlsx');
        $objPHPExcel = \PHPExcel_IOFactory::load($fName);
        $sheet = $objPHPExcel->setActiveSheetIndex(0);

        $startRow = 11;

        $totals = [
            'total_debt_regarding_UK' => 0,
            'total_debt_primary' => 0,
            'total_fine' => 0,
            'cost_of_claim' => 0,
            'state_fee' => 0,
        ];

        if ($debtorIds[0] == 'all') {
            $debtorIds = [];
            $dCount = Yii::$app->user->identity->getDebtors()->select('id')->all();
            //TODO: использовать ArrayMap, вроде того
            foreach ($dCount as $el) {
                $debtorIds[] = $el['id'];
            }
        }

        // Вносим поля отчета о должниках
        $dCount = count($debtorIds);

        if (!$dCount) {
            //TODO: как-то это улучшить
            throw new \Exception('Нет должников');
        }

        $appPackagesCount = (int)\Yii::$app->user->identity->getApplicationPackageToTheContracts()->count();
        $appPackageNumber = $appPackagesCount + 1;
        $appPackage = new \common\models\ApplicationPackageToTheContract();
        $appPackage->number = $appPackageNumber;
        $appPackage->name = '';
        $appPackage->link('user', \Yii::$app->user->identity);

        for ($i = $dCount - 1; $i >= 0; --$i) {
            //TODO: запрос с ['id' => $dId] не выглядит достаточно корректным
            $debtor = Yii::$app->user->identity->getDebtors()->where(['id' => $debtorIds[$i]])->one();
            if ($debtor) {
                $sheet->insertNewRowBefore($startRow, 1);
                $sheet->getRowDimension($startRow)->setRowHeight(-1);

                $sheet->setCellValueByColumnAndRow(0, $startRow, $i + 1);

                $info = $debtor->getReportInfo();

                $j = 1;
                foreach ($info as $key => $row) {
                    $sheet->setCellValueByColumnAndRow($j++, $startRow, $row);
                    if (isset($totals[$key])) {
                        $totals[$key] += $row;
                    }
                }

                $debtor->status->status = 'to_work';
                $debtor->status->save();

                $debtor->link('applicationPackageToTheContracts', $appPackage);
            }
        }

        $appPackage->save();

        // Заносим текстовую информацию
        //$sheet->setCellValueByColumnAndRow(, 1, $row);
        $sheet->setCellValue('N2', Yii::t('app', "Приложение № $appPackageNumber"));
        //TODO: проверить date на timezone
        $sheet->setCellValue('N3', Yii::t('app', 'от {date}', ['date' => date('d.m.Y')]));
        $company = \Yii::$app->user->identity->userInfo->primaryCompany;
        $sheet->setCellValue('B' . ($dCount + 17), $company->short_name);
        $sheet->setCellValue('B' . ($dCount + 19), '______________________________ ' . $company->cEO->createShortName());

        //TODO: бардак какой-то с формулой
        //$sumFormula = '=SUM(INDIRECT(ADDRESS(11;COLUMN())&":"&ADDRESS(ROW()-1;COLUMN())))';
        //$sheet->setCellValueByColumnAndRow(9, $startRow + $dCount, $sumFormula);
        $sheet->setCellValueByColumnAndRow(9, $startRow + $dCount, $totals['total_debt_regarding_UK']);
        $sheet->setCellValueByColumnAndRow(10, $startRow + $dCount, $totals['total_debt_primary']);
        $sheet->setCellValueByColumnAndRow(11, $startRow + $dCount, $totals['total_fine']);
        $sheet->setCellValueByColumnAndRow(12, $startRow + $dCount, $totals['cost_of_claim']);
        $sheet->setCellValueByColumnAndRow(13, $startRow + $dCount, $totals['state_fee']);

        //$objPHPExcel = $debtor->getReportExcel();
        //another MIME type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
        //return Yii::$app->response->sendContentAsFile($content, 'DebtorsReport.xlsx', ['mimeType' => 'application/vnd.ms-excel']);

        //TODO: выдавать нормально
        header('Content-Type: application/vnd.ms-excel');
        $filename = "DebtorsReport_" . date("d-m-Y-His") . ".xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /*public function actionDebtVerification()
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
    }*/

    /*public function actionStatusInfo($debtorId)
    {
        $debtor = $this->findModel($debtorId);

        if ($debtor->load(Yii::$app->request->post()) && $debtor->save()) {



            return $this->redirect(['/office/debtor']);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_status_info',
                [
                    'debtor' => $debtor,
                    //'debtorStatus' => $debtor->getStatus(),
                    'debtorStatus' => $debtor->status,
                ]
            );
        } else {
            return $this->render('_status_info',
                [
                    'debtor' => $debtor,
                    'debtorStatus' => $debtor->status,
                ]
            );
        }
    }*/
}
