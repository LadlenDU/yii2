<?php

namespace common\models;

use common\models\debtor_parse\Format_csv_1;
use Yii;
//use common\models\Fine;
use yii\web\UploadedFile;
use common\models\debtor_parse\DebtorParse;
use common\models\helpers\DebtorLoadMonitorFormat1;
use common\helpers\FormatHelper;
use common\models\info\Company;

//use common\models\debtor_parse\DebtorParse;
//use morphos\Russian\inflectName;

/**
 * This is the model class for table "debtor".
 *
 * @property integer $id
 * @property string $phone
 * @property string $LS_EIRC
 * @property string $LS_IKU_provider
 * @property string $IKU
 * @property double $space_common
 * @property double $space_living
 * @property integer $ownership_type_id
 * @property integer $location_id
 * @property integer $name_id
 * @property string $expiration_start
 * @property string $debt_total
 * @property string $single
 * @property string $additional_adjustment
 * @property string $subsidies
 * @property integer $company_id
 * @property integer $status_id
 * @property string $debt
 * @property string $fine
 * @property string $cost_of_claim
 * @property string $state_fee
 *
 * @property Accrual[] $accruals
 * @property ApplicationPackageToTheContractDebtor[] $applicationPackageToTheContractDebtors
 * @property ApplicationPackageToTheContract[] $applicationPackageToTheContracts
 * @property DebtDetails[] $debtDetails
 * @property Company $company
 * @property Location $location
 * @property Name $name
 * @property OwnershipType $ownershipType
 * @property DebtorStatus $status
 * @property DebtorCohabitant[] $debtorCohabitants
 * @property DebtorPublicService[] $debtorPublicServices
 * @property PublicService[] $publicServices
 * @property Indebtedness[] $indebtednesses
 * @property Payment[] $payments
 */
class Debtor extends \yii\db\ActiveRecord
{
    public $location_street;
    public $location_building;
    public $claim_sum_from;
    public $claim_sum_to;
    public $status_status;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debtor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LS_IKU_provider', 'company_id'], 'required'],
            [['space_common', 'space_living', 'debt_total', 'debt', 'fine', 'cost_of_claim', 'state_fee'], 'number'],
            [['ownership_type_id', 'location_id', 'name_id', 'company_id', 'status_id'], 'integer'],
            [['expiration_start', 'location_street', 'location_building', 'claim_sum_from', 'claim_sum_to', 'status_status'], 'safe'],
            [['phone', 'LS_EIRC', 'LS_IKU_provider', 'IKU', 'single', 'additional_adjustment', 'subsidies'], 'string', 'max' => 255],
            [['name_id'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['name_id'], 'exist', 'skipOnError' => true, 'targetClass' => Name::className(), 'targetAttribute' => ['name_id' => 'id']],
            [['ownership_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => OwnershipType::className(), 'targetAttribute' => ['ownership_type_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => DebtorStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone' => Yii::t('app', 'Телефон'),
            'LS_EIRC' => Yii::t('app', 'ЛС ЕИРЦ'),
            //'LS_IKU_provider' => Yii::t('app', 'ЛС ИКУ/поставщика'),
            // № лицевого счета
            'LS_IKU_provider' => Yii::t('app', '№ ЛС'),
            'IKU' => Yii::t('app', 'ИКУ'),
            'space_common' => Yii::t('app', 'Общая площадь'),
            'space_living' => Yii::t('app', 'Жилая площадь'),
            'ownership_type_id' => Yii::t('app', 'Форма собственности'),
            'location_id' => Yii::t('app', 'Location ID'),
            'name_id' => Yii::t('app', 'Name ID'),
            'expiration_start' => Yii::t('app', 'Начало просрочки'),
            //TODO: Как это соотносится с полем 'debt'? Похоже это лишнее поле теперь
            'debt_total' => Yii::t('app', 'Сумма долга'),
            'single' => Yii::t('app', 'Разовые'),
            //TODO: похоже, это лишнее поле. Посмотреть другие лишние поля и удалить.
            'additional_adjustment' => Yii::t('app', 'Доп. корректировка'),
            'subsidies' => Yii::t('app', 'Субсидии'),
            'accrualSum' => Yii::t('app', 'Начислено'),
            'paymentSum' => Yii::t('app', 'Оплачено'),
            'debtTotal' => Yii::t('app', 'Задолженность'),
            'fineTotal' => Yii::t('app', 'Пеня'),
            'company_id' => Yii::t('app', 'ID компании'),
            'status_id' => Yii::t('app', 'ID cтатуса'),
            'debt' => Yii::t('app', 'Задолженность'),
            'fine' => Yii::t('app', 'Пеня'),
            'cost_of_claim' => Yii::t('app', 'Цена иска (задолженность + пеня)'),
            'state_fee' => Yii::t('app', 'Пошлина'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccruals()
    {
        return $this->hasMany(Accrual::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPackageToTheContractDebtors()
    {
        return $this->hasMany(ApplicationPackageToTheContractDebtor::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPackageToTheContracts()
    {
        return $this->hasMany(ApplicationPackageToTheContract::className(), ['id' => 'application_package_to_the_contract_id'])->viaTable('application_package_to_the_contract_debtor', ['debtor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtDetails()
    {
        return $this->hasMany(DebtDetails::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->inverseOf('debtors');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id'])->inverseOf('debtors');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getName()
    {
        return $this->hasOne(Name::className(), ['id' => 'name_id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnershipType()
    {
        return $this->hasOne(OwnershipType::className(), ['id' => 'ownership_type_id'])->inverseOf('debtors');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(DebtorStatus::className(), ['id' => 'status_id'])->inverseOf('debtors');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtorCohabitants()
    {
        return $this->hasMany(DebtorCohabitant::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtorPublicServices()
    {
        return $this->hasMany(DebtorPublicService::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicServices()
    {
        return $this->hasMany(PublicService::className(), ['id' => 'public_service_id'])->viaTable('debtor_public_service', ['debtor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndebtednesses()
    {
        return $this->hasMany(Indebtedness::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @inheritdoc
     * @return DebtorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DebtorQuery(get_called_class());
    }

    //TODO: что с этим не так?
    /* public function init()
     {
         parent::init();
         if (!$this->status) {
             $status = new DebtorStatus();
             $status->save();
             $this->link('status', $status);
             $this->save();
         }
     }*/

    public function init()
    {
        parent::init();

        /*if ($this->debt === null || $this->fine === null || $this->cost_of_claim === null || $this->state_fee === null) {
            $this->recalculateAllTotalValues();
        }*/
    }

    public function getFineCalculatorResult()
    {
        $fineRes = false;

        $loans = [];
        $payments = [];

        $fine = new Fine();

        $accruals = Accrual::find()->where(['debtor_id' => $this->id])->all();
        foreach ($accruals as $acc) {
            $date = strtotime($acc->accrual_date);
            $loans[] = [
                'sum' => $acc->getAccrualRecount(), //$this->calcAccrualSum($acc),
                'date' => $date,
            ];
        }

        $paymentsRes = Payment::find()->where(['debtor_id' => $this->id])->all();
        foreach ($paymentsRes as $pm) {
            $date = strtotime($pm->payment_date);
            $payments[] = [
                'date' => $date,
                'payFor' => null,
                'sum' => $pm->amount,
            ];
        }

        $dateFinish = $this->getDebtDateEnd();

        try {
            $fineRes = $fine->fineCalculator($dateFinish, $loans, $payments);
        } catch (\Exception $e) {
            //TODO: что-то с этим делать
            $ex = 'here is exception';
        }

        return $fineRes;
    }

    protected function getDebtDateEnd()
    {
        return time() - 60 * 60 * 24;
    }

    public function calcFines()
    {
        $elements = [];

        if ($fineRes = $this->getFineCalculatorResult()) {
            foreach ($fineRes as $res) {
                if (!empty($res['data'])) {
                    /*foreach ($res['data'] as $data) {
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
                    }*/
                    $totalFine = 0;
                    foreach ($res['data'] as $data) {
                        if ($data['type'] == Fine::DATA_TYPE_INFO) {
                            $totalFine += $data['data']['cost'];
                        }
                    }
                    $elements[] = [
                        'dateStart' => $res['dateStart'],
                        'fine' => $totalFine,
                    ];
                }
            }
        }

        return $elements;

        /*if ($this->expiration_start && $this->debt_total) {
            $dateStart = strtotime($this->expiration_start);
            $dateFinish = time() - 60 * 60 * 24;

            $fine = new Fine();
            $res = $fine->fineCalculator($this->debt_total, $dateStart, $dateFinish);

            $sum = 0;

            if (!empty($res[0]['data'])) {
                foreach ($res[0]['data'] as $r) {
                    $sum += (int)$r['data']['cost'];
                }
            }

            return $sum;
        }

        return 0;*/
    }

    /*public static function calcAccrualSum(Accrual $acc)
    {
        $accrual = $acc->accrual ?: null;
        if (empty($_GET['dis_sub'])) {
            $subsidies = $acc->subsidies ?: null;
            $single = $acc->single ?: null;
            $additional_adjustment = $acc->additional_adjustment ?: null;
            return (float)$accrual - (float)$subsidies + (float)$single + (float)$additional_adjustment;
        } else {
            return (float)$accrual;
        }
    }*/

    public function calcDebts($sortParams = false, &$endSum = null)
    {
        /*$loans = [];
        $payments = [];

        $fine = new Fine();

        $accruals = Accrual::find()->where(['debtor_id' => $this->id])->all();
        foreach ($accruals as $acc) {
            $date = strtotime($acc->accrual_date);
            $loans[] = [
                'sum' => $this->calcAccrualSum($acc),
                'date' => $date,
            ];
        }

        $paymentsRes = Payment::find()->where(['debtor_id' => $this->id])->all();
        foreach ($paymentsRes as $pm) {
            $date = strtotime($pm->payment_date);
            $payments[] = [
                'date' => $date,
                'payFor' => null,
                'sum' => $pm->amount,
            ];
        }

        $dateFinish = time() - 60 * 60 * 24;

        try {
            $fineRes = $fine->fineCalculator($dateFinish, $loans, $payments);
        } catch (\Exception $e) {
            //TODO: что-то с этим делать
        }*/

        $fineRes = $this->getFineCalculatorResult();

        $elements = [];

        if (!empty($fineRes)) {
            if ($endSum !== null) {
                $fine = new Fine();
                $endSum = $fine->getEndSum($fineRes);
            }
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
        }

        if ($sortParams) {

        }

        return $elements;
    }

    public function getAccrualSum()
    {
        //$this::find()->sum('amount');
        //$this->accruals::find()->sum('accrual');
        //TODO: может, оптимизировать?
        //return $this->find()->from('accrual')->where(['debtor_id' => $this->id])->sum('accrual') ?: 0;

        $accrualSum = $this->getAccruals()->sum('accrual_recount') ?: 0;

        if (!$accrualSum) {
            #$debtor->recalculateAllTotalValues();
            foreach ($this->accruals as $acc) {
                $acc->recountAccrual();
                $this->recalculateAllTotalValues();
                /*foreach ($this->accruals->debtor as $debtor) {
                    $debtor->recalculateAllTotalValues();
                }*/
            }
        }

        $accrualSum = $this->getAccruals()->sum('accrual_recount') ?: 0;

        return $accrualSum;

        //TODO: оптимизировать
        /*$sum = 0;
        $accruals = Accrual::find()->where(['debtor_id' => $this->id])->all();
        foreach ($accruals as $acc) {
            $sum += $acc->accrual_recount; //$this->calcAccrualSum($acc);
        }
        return $sum;*/
    }

    public function getPaymentSum()
    {
        //return $this->find()->from('payment')->where(['debtor_id' => $this->id])->sum('amount') ?: 0;
        return $this->getPayments()->sum('amount') ?: 0;
    }

    /**
     * Вернуть общую задолженность.
     */
    public function getDebt()
    {
        if ($this->debt === null) {
            $this->calculateDebt();
        }
        return $this->debt;
    }

    public function calculateDebt($save = true)
    {
        $debt = 0;
        $this->calcDebts(false, $debt);
        $this->debt = $debt;
        $this->calculateCostOfClaim(false);
        if ($save) {
            $this->save(true, ['debt', 'cost_of_claim']);
        }
        return $debt;
    }

    /**
     * Вернуть общую пеню.
     */
    public function getFine()
    {
        if ($this->fine === null) {
            $this->calculateFine();
        }
        return $this->fine;
    }

    public function calculateFine($save = true)
    {
        $fine = 0;
        $calcFines = $this->calcFines();
        if ($calcFines) {
            foreach ($calcFines as $fineElem) {
                $fine += (float)$fineElem['fine'];
            }
        }
        $this->fine = $fine;
        $this->calculateCostOfClaim(false);
        if ($save) {
            $this->save(false, ['fine', 'cost_of_claim']);
        }
        return $this->fine;
    }

    public function getCostOfClaim()
    {
        if ($this->cost_of_claim === false) {
            $this->calculateCostOfClaim();
        }
        return $this->cost_of_claim;
    }

    public function getStateFee()
    {
        if ($this->state_fee === false) {
            $this->calculateStateFee2();
        }
        return $this->state_fee;
    }

    public function calculateCostOfClaim($save = true)
    {
        $this->cost_of_claim = (float)$this->debt + (float)$this->fine;
        if ($save) {
            $this->save(false, ['cost_of_claim']);
        }
    }

    /**
     * @return false|int unix timestamp - начало периода задолженности
     */
    public function getDebtPeriodStart($case = false)
    {
        $date = $this->getAccruals()->orderBy('accrual_date ASC')->one()->accrual_date;
        /*if ($date && $case) {
                $date = inflectName($date, $case);
        }*/
        return strtotime($date);
    }

    /**
     * @return false|int unix timestamp - конец периода задолженности
     */
    public function getDebtPeriodEnd()
    {
        return $this->getDebtDateEnd();
    }

    /**
     * Перерасчет всех технических значений (суммы данных)
     */
    public function recalculateAllTotalValues()
    {
        if ($this->accruals) {
            foreach ($this->accruals as $acc) {
                $acc->recountAccrual();
            }
        }
        $this->calculateDebt(true);
        $this->calculateFine(true);
        $this->calculateStateFee2(true);
        $this->save(true, ['debt', 'fine', 'cost_of_claim', 'state_fee']);
    }

    /**
     * Вернуть задолженность по дате.
     *
     * @param int $date Дата задолженности - unix timestamp
     * @return float
     */
    /*public static function getDebt($date)
    {
        $debt = 0;

        //Mymodel::find()->select('sorting_value')->where('sorting_val‌​ue' > ':sort1', [':sort1' => $sort1])->min('sorting_value');

        $year = date('Y', $date);
        $month = date('n', $date);

        //accrual_date
        $accrual = \common\models\Accrual::find()
            //->select(['year(accrual_date) AS year', 'month(accrual_date) AS month'])//TODO: универсализировать "AS"
            ->where(['=', 'YEAR(accrual_date)', $year])
            ->andWhere(['=', 'MONTH(accrual_date)', $month])
            ->one();
        $payment = \common\models\Payment::find()
            //->select('year(payment_date) AS year', 'month(payment_date) AS month')//TODO: универсализировать "AS"
            ->where(['=', 'YEAR(payment_date)', $year])
            ->andWhere(['=', 'MONTH(payment_date)', $month])
            ->one();

        if ($accrual) {
            $debt = (int)$accrual->accrual;
        }
        if ($payment) {
            $debt -= $payment->amount;
        }
        //$debt = $accrual->accrual - $payment->amount;

        return $debt;
        //$searchModel->debtor_id = $debtor_id;
        #$searchModel = new \common\models\AccrualSearch();
        #$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //return $this->find()->from('payment')->where(['debtor_id' => $this->id])->sum('amount') ?: 0;
    }*/

    /**
     * Расчет пошлины - новая редакция (действует на Oct.01.2017).
     *
     * @return float|int
     */
    public function calculateStateFee2($save = true)
    {
        //$amount = $this->getDebtTotal();
        //$amount = $this->getDebt();
        //$amount += $this->getFineTotal();
        //$amount += $this->getFine();
        $amount = $this->cost_of_claim ?: 0;

        if ($amount <= 10000) {
            // до 10 000 рублей - 2 процента цены иска, но не менее 200 рублей;
            $fee = $amount / 100 * 2;
            $fee = ($fee < 200) ? 200 : $fee;
        } elseif ($amount <= 20000) {
            // до 20 000 рублей - 2 процента цены иска, но не менее 400 рублей;
            $fee = $amount / 100 * 2;
            //$fee = ($fee < 400) ? 400 : $fee;
        } elseif ($amount <= 100000) {
            // от 20 001 рубля до 100 000 рублей - 400 рублей плюс 1,5 процента суммы, превышающей 20 000 рублей;
            $fee = 400 + ($amount - 20000) / 100 * 1.5;
        } elseif ($amount <= 200000) {
            // от 100 001 рубля до 200 000 рублей - 800 рублей плюс 1 процента суммы, превышающей 100 000 рублей;
            $fee = 800 + ($amount - 20000) / 100 * 1;
        } elseif ($amount <= 1000000) {
            // от 200 001 рубля до 1 000 000 рублей - 1700 рублей плюс 1 процент суммы, превышающей 200 000 рублей;
            $fee = 1700 + ($amount - 20000) / 100 * .5;
        } else {
            // свыше 1 000 000 рублей - 4150 рублей плюс 0,5 процента суммы, превышающей 1 000 000 рублей, но не более 30 000 рублей;
            $fee = 4150 + ($amount - 20000) / 100 * .25;
            $fee = ($fee > 30000) ? 30000 : $fee;
        }

        $this->state_fee = $fee;
        if ($save) {
            $this->save(false, ['state_fee']);
        }
    }

    public static function handleDebtorsExcelFileAUser(UploadForm $uploadModel)
    {
        $uploadModel->excelFileForAUser = UploadedFile::getInstance($uploadModel, 'excelFileForAUser');
        if ($fileName = $uploadModel->uploadExcel('excelFileForAUser')) {
            // file is uploaded successfully
            $objPHPExcel = \PHPExcel_IOFactory::load($fileName);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, false, false, false);
            self::addDebtsForAUser($sheetData);
        }
    }

    public static function handleDebtorsExcelFile(UploadForm $uploadModel)
    {
        $uploadModel->excelFile = UploadedFile::getInstance($uploadModel, 'excelFile');
        if ($fileName = $uploadModel->uploadExcel()) {
            // file is uploaded successfully
            $objPHPExcel = \PHPExcel_IOFactory::load($fileName);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, false, false, false);
            self::addDebtors($sheetData);
        }
    }

    /*public static function handleDebtorsExcelType1(UploadForm $uploadModel)
    {
        $uploadModel->excelFileType1 = UploadedFile::getInstance($uploadModel, 'debtorsExcelType1');
        if ($fileName = $uploadModel->uploadExcel()) {
            // file is uploaded successfully
            $objPHPExcel = \PHPExcel_IOFactory::load($fileName);
            $sheetDataRaw = $objPHPExcel->getActiveSheet()->toArray(null, false, false, false);
            //self::addDebtors($sheetData);
            $sheetData = Format_DebtorsExcelType1::format($sheetDataRaw);
            unset($sheetDataRaw);
            self::addDebtors($sheetData);
        }
    }*/

    public static function handleDebtorsCsvFile(UploadForm $uploadModel)
    {
        $uploadModel->csvFiles = UploadedFile::getInstances($uploadModel, 'csvFiles');

        if ($allFileNames = $uploadModel->uploadCsv()) {
            foreach ($allFileNames as $fileNameInfo) {

                $fileName = $fileNameInfo['name_on_disk'];
                $realFileName = $fileNameInfo['real_name'];

                //TODO: пока сделаем так, пока не пойдет другая загрузка
                if ($fileMonitor = Yii::$app->user->identity->getDebtorLoadMonitorFormat1s()->where(['file_name' => $realFileName])->one()) {
                    try {
                        DebtorParse::verifyFileMonitorFinish($fileMonitor);
                    } catch (\Exception $e) {
                        Yii::$app->getSession()->setFlash('error', $e->getMessage());
                        return;
                    }
                } else {
                    $fileMonitor = new DebtorLoadMonitorFormat1();
                    //$fileMonitor->user_id = Yii::$app->user->identity->getId();
                    //TODO: может не самый лучший способ: сохраняет здесь? Здесь не лучшее место если парсинг не начнется
                    $fileMonitor->file_name = $realFileName;
                    $fileMonitor->link('user', Yii::$app->user->identity);
                }

                if ($handle = fopen($fileName, 'r')) {
                    $sheetDataRaw = [];
                    $count = 0;
                    while (($data = fgetcsv($handle, 0, ';')) !== false) {
                        $sheetDataRaw[] = $data;
                    }
                    fclose($handle);

                    $sheetData = Format_csv_1::format($sheetDataRaw);
                    unset($sheetDataRaw);
                    self::addDebtors($sheetData, $fileMonitor);

                } else {
                    //TODO: логирование
                    Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Не удался импорт из-за внутренней ошибки.'));
                }
            }
        }
    }

    public static function addDebtors(array $sheetData, DebtorLoadMonitorFormat1 $fileMonitor = null)
    {
        try {
            $info = DebtorParse::scrapeDebtorsFromArray($sheetData);
            unset($sheetData);
            $saveResult = DebtorParse::saveDebtors($info, $fileMonitor);

            $msg = Yii::t('app', 'Успешно прошла операция добавления в БД.') . '<br>';
            $finishedAtTz = FormatHelper::convertDatetimeToTimezone($fileMonitor->finished_at);
            $msg .= Yii::t('app', 'Файл: {fName}. Время завершения: {fDateTime}',
                    ['fName' => $fileMonitor->file_name, 'fDateTime' => $finishedAtTz]) . '<br><br>';

            $addedNumber = empty($saveResult['debtors']['added']) ? 0 : $saveResult['debtors']['added'];
            $updatedNumber = empty($saveResult['debtors']['updated']) ? 0 : $saveResult['debtors']['updated'];
            $msg .= "Должников добавлено: $addedNumber<br><br>";
            //TODO: рассмотреть возможность установить
            //. "Должников обновлено: $updatedNumber<br><br>";

            $addedNumber = empty($saveResult['accruals']['added']) ? 0 : $saveResult['accruals']['added'];
            $updatedNumber = empty($saveResult['accruals']['updated']) ? 0 : $saveResult['accruals']['updated'];
            $msg .= "Начислений добавлено: $addedNumber<br>"
                . "Начислений обновлено: $updatedNumber<br><br>";

            $addedNumber = empty($saveResult['payments']['added']) ? 0 : $saveResult['payments']['added'];
            $updatedNumber = empty($saveResult['payments']['updated']) ? 0 : $saveResult['payments']['updated'];
            $msg .= "Оплат добавлено: $addedNumber<br>"
                . "Оплат обновлено: $updatedNumber";

            //TODO: yii логирование

            Yii::$app->getSession()->setFlash('success', $msg);
        } catch (\Exception $e) {
            Yii::$app->getSession()->setFlash('error', $e->getMessage());
        }
    }

    public static function addDebtsForAUser(array $sheetDataRaw)
    {
        try {
            $sheetData = DebtorParse::format_2($sheetDataRaw);
            self::addDebtors($sheetData);
        } catch (\Exception $e) {
            Yii::$app->getSession()->setFlash('error', $e->getMessage());
        }
    }

    public function getLocationCity()
    {
        $city = '';
        if ($this->location && $this->location->city) {
            $city = $this->location->city;
        } else {
            if (Yii::$app->user->identity->userInfo
                && Yii::$app->user->identity->userInfo->primaryCompany
                && Yii::$app->user->identity->userInfo->primaryCompany->actualAddressLocation
            ) {
                $city = Yii::$app->user->identity->userInfo->primaryCompany->actualAddressLocation->city;
            }
        }
        return $city;
    }

    public function getReportInfo(): array
    {
        //TODO: перенести в таблицу или как-то ещё иначе сделать
        $timeNow = new \DateTime('now');
        $timeStart = (new \DateTime('now'))->modify('-3 years -1 month');

        $arr['name'] = $this->name->createFullName();
        $arr['LS'] = $this->LS_IKU_provider;
        $arr['address'] = $this->location->createFullAddress(['zip_code', 'region', 'district', 'city', 'street']);
        $arr['building'] = $this->location->building;
        $arr['housing'] = '';
        $arr['appartment'] = $this->location->appartment;
        $arr['debt_period'] = $timeStart->format('m.Y') . ' - ' . $timeNow->format('m.Y');
        $arr['debt_total_months'] = 36;
        $arr['total_debt_regarding_UK'] = $this->debt;
        $arr['total_debt_primary'] = $this->debt;
        $arr['total_fine'] = $this->fine;
        $arr['cost_of_claim'] = $this->cost_of_claim;
        $arr['state_fee'] = $this->state_fee;

        return $arr;
    }

    /**
     * Возвращает информацию для "Свод начислений по лицевому счету"
     */
    public function getSubscriptionAccrualsInfo()
    {
        $info = [];

        $allDebtorAccruals = $this->getAccruals()->orderBy(['accrual_date' => SORT_ASC])->all();

        if ($allDebtorAccruals) {
            $realAccrualsCounter = 0;
            for (; ;) {
                $lastAccrual = $allDebtorAccruals[$realAccrualsCounter];
                $info[] = $this->getSubscriptionAccrualsInfoElement($lastAccrual);

                $currMonthDateStr = FormatHelper::setDateToMonthStart($lastAccrual->accrual_date);
                $nextMonthDateStr = FormatHelper::addIntervalToDateTimeString($currMonthDateStr, '1 month');

                ++$realAccrualsCounter;

                if (isset($allDebtorAccruals[$realAccrualsCounter])) {
                    $nextAccrual = $allDebtorAccruals[$realAccrualsCounter];
                    $nextAvailableMonthDate = FormatHelper::setDateToMonthStart($nextAccrual->accrual_date);
                    while ($nextAvailableMonthDate != $nextMonthDateStr) {
                        $info[] = $this->getSubscriptionAccrualsInfoElement(null, $nextMonthDateStr);
                        $nextMonthDateStr = FormatHelper::addIntervalToDateTimeString($nextMonthDateStr, '1 month');
                    }
                } else {
                    break;
                }
            }
        }

        return $info;
    }

    protected function getSubscriptionAccrualsInfoElement($accrual = false, string $accrualDateOnEmptyAccrual = null): array
    {
        $info = [];

        if ($accrual) {
            //TODO: косяк с поиском, надо искать по месяцу
            $payment = $this->getPayments()
                ->where(['payment_date' => FormatHelper::setDateToMonthStart($accrual->accrual_date)])->one();
            $paymentAmount = $payment ? $payment->amount : '0.00';
            //TODO: проверить правильность
            $debt = (float)$accrual->accrual_recount - (float)$paymentAmount;
            $info = [
                'accrual_date' => strtotime($accrual->accrual_date),
                'initial_balance' => null,
                'accrual' => $accrual->accrual_recount,
                'payment' => $paymentAmount,
                'debt' => $debt,
                'final_balance' => $debt,
                'overdue_debt' => $debt,
            ];
        } else {
            $info = [
                'accrual_date' => strtotime($accrualDateOnEmptyAccrual),
                'initial_balance' => null,
                'accrual' => '0.00',
                'payment' => '0.00',
                'debt' => '0.00',
                'final_balance' => '0.00',
                'overdue_debt' => '0.00',
            ];
        }

        return $info;
    }
}
