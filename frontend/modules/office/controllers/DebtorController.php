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
            //$locationModel->link('debtors', $model);
            $model->link('location', $locationModel);
            $locationModel->load(Yii::$app->request->post());
            $locationModel->save();

            //$nameModel = Name::find()->where(['name_id' => $this->name->id])->one();
            $nameModel = $model->name ? $model->name : new Name;
            //TODO: проверить, рефакторинг
            $nameModel->save();
            $nameModel->link('debtors', $model);
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
        //TODO: вынести в модель

        $loans = [];
        $payments = [];

        $fine = new Fine();

        $accruals = Accrual::find()->where(['debtor_id' => $debtor_id])->all();
        foreach ($accruals as $acc) {
            $date = strtotime($acc->accrual_date);
            $loans[] = [
                'sum' => $acc->accrual,
                'date' => $date,
            ];
        }

        $paymentsRes = Payment::find()->where(['debtor_id' => $debtor_id])->all();
        foreach ($paymentsRes as $pm) {
            $date = strtotime($pm->payment_date);
            $payments[] = [
                'date' => $date,
                'payFor' => null,
                'sum' => $pm->amount,
            ];
        }

        $dateFinish = time() - 60 * 60 * 24;

        $fineRes = $fine->fineCalculator($dateFinish, $loans, $payments);

        $elements = [];

        foreach ($fineRes as $res) {
            if (!empty($res['data'])) {
                foreach ($res['data'] as $data) {
                    if ($data['type'] == 1) {
                        $elements[] = [
                            'fine' => $data['data']['cost'],
                            //'cost' => $data['data']['sum'],
                            //'dateStart' => date('Y-m-d H:i:s', $data['data']['dateStart']),
                            //'dateFinish' => date('Y-m-d H:i:s', $data['data']['dateFinish']),
                            'dateStart' => $data['data']['dateStart'],
                            'dateFinish' => $data['data']['dateFinish'],
                        ];
                    }
                }
            }
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
        //TODO: вынести в модель

        $loans = [];
        $payments = [];

        $fine = new Fine();

        $accruals = Accrual::find()->where(['debtor_id' => $debtor_id])->all();
        foreach ($accruals as $acc) {
            $date = strtotime($acc->accrual_date);
            $loans[] = [
                'sum' => $acc->accrual,
                'date' => $date,
            ];
        }

        $paymentsRes = Payment::find()->where(['debtor_id' => $debtor_id])->all();
        foreach ($paymentsRes as $pm) {
            $date = strtotime($pm->payment_date);
            $payments[] = [
                'date' => $date,
                'payFor' => null,
                'sum' => $pm->amount,
            ];
        }

        $dateFinish = time() - 60 * 60 * 24;

        $fineRes = $fine->fineCalculator($dateFinish, $loans, $payments);

        $elements = [];

        foreach ($fineRes as $res) {
            if (!empty($res['data'])) {
                foreach ($res['data'] as $data) {
                    /*if ($data['type'] == 2) {
                        $elements[] = [
                            'debt' => $data['data']['sum'],
                            'date' => date('Y-m-d H:i:s', $data['data']['date']),
                        ];
                    }*/
                    if ($data['type'] == 1) {
                        $elements[] = [
                            'debt' => $data['data']['sum'],
                            //'date' => date('Y-m-d H:i:s', $data['data']['date']),
                            'dateStart' => $data['data']['dateStart'],
                            'dateFinish' => $data['data']['dateFinish'],
                        ];
                    }
                }
            }
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

    public function actionFullReportFineData($debtor_id)
    {
        $loans = [];
        $payments = [];

        $fine = new Fine();

        $accruals = Accrual::find()->where(['debtor_id' => $debtor_id])->all();
        foreach ($accruals as $acc) {
            $date = strtotime($acc->accrual_date);
            $loans[] = [
                'sum' => $acc->accrual,
                'date' => $date,
            ];
        }

        $paymentsRes = Payment::find()->where(['debtor_id' => $debtor_id])->all();
        foreach ($paymentsRes as $pm) {
            $date = strtotime($pm->payment_date);
            $payments[] = [
                'date' => $date,
                'payFor' => null,
                'sum' => $pm->amount,
            ];
        }

        $dateFinish = time() - 60 * 60 * 24;
        $periods = $fine->fineCalculator($dateFinish, $loans, $payments);
        $html = $fine->getBuhHtml($periods);

        $data = [
            'html' => $html,
            'debtorId' => $debtor_id,
        ];

        $this->layout = 'print_fine';   //"@app/views/layouts/mainLayout";
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_full_report_fine_data', $data);
        } else {
            Yii::$app->html2pdf
                ->render('_full_report_fine_data', $data)
                ->saveAs('/path/to/output.pdf');
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
