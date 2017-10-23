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
use common\components\HelpersDebt;

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
            switch (Yii::$app->request->post('action')) {
                case 'upload_debtors_excel': {
                    Debtor::handleDebtorsExcelFile($uploadModel);
                    break;
                }
                case 'upload_debtors_excel_a_user': {
                    Debtor::handleDebtorsExcelFileAUser($uploadModel);
                    break;
                }
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadModel' => $uploadModel,
        ]);
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

            $locationModel = Location::find()->where(['location_id' => $this->location->id])->one();
            $locationModel->link('location', $model);

            $nameModel = Name::find()->where(['name_id' => $this->name->id])->one();
            $nameModel->link('name', $model);

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

    public function actionInfoForDebtOld($debtor_id)
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
            $court = HelpersDebt::findCourtAddressForDebtor($debtor, 'common\models\Court');
            $company = HelpersDebt::findCompanyAddressForDebtor($debtor);
            $params = [
                'debtor' => $debtor,
                'court' => $court,
                'company' => $company,
            ];
        }
        return $this->renderPartial('statement', $params);
    }

    public function actionPrintDocuments()
    {
        $documents = [];

        $this->layout = 'print_fine';
        $this->view->title = \Yii::t('app', 'Пакет документов');

        $debtorIds = Yii::$app->request->post('debtorIds');
        $doc['statement'] = $this->getStatementHtml($debtorIds[0]);
        $doc['full_fine_report'] = $this->getFullReportFineDataHtml($debtorIds[0]);

        $documents[] = $doc;

        return $this->render('print_documents',
            [
                'documents' => $documents,
            ]
        );
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
            'debtorAddress' => $debtor->location->full_address,
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
            //return $html;
            //$tt = print_r(Yii::$app->html2pdf->convert($html)); exit;
            Yii::$app->html2pdf->convert($html)->send('Debts.pdf');
            /*try {
            Yii::$app->html2pdf->loadHtml($html)
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
}
