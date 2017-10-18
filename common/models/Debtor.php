<?php

namespace common\models;

use Yii;
use common\models\Fine;
use yii\web\UploadedFile;
use common\models\DebtorParse;

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
 *
 * @property Accrual[] $accruals
 * @property DebtDetails[] $debtDetails
 * @property Location $location
 * @property Name $name
 * @property OwnershipType $ownershipType
 * @property DebtorPublicService[] $debtorPublicServices
 * @property PublicService[] $publicServices
 * @property Payment[] $payments
 */
class Debtor extends \yii\db\ActiveRecord
{
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
            [['space_common', 'space_living', 'debt_total'], 'number'],
            [['ownership_type_id', 'location_id', 'name_id'], 'integer'],
            [['expiration_start'], 'safe'],
            [['phone', 'LS_EIRC', 'LS_IKU_provider', 'IKU', 'single', 'additional_adjustment', 'subsidies'], 'string', 'max' => 255],
            [['LS_IKU_provider'], 'unique'],
            [['name_id'], 'unique'],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['name_id'], 'exist', 'skipOnError' => true, 'targetClass' => Name::className(), 'targetAttribute' => ['name_id' => 'id']],
            [['ownership_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => OwnershipType::className(), 'targetAttribute' => ['ownership_type_id' => 'id']],
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
            'debt_total' => Yii::t('app', 'Сумма долга'),
            'single' => Yii::t('app', 'Разовые'),
            'additional_adjustment' => Yii::t('app', 'Доп. корректировка'),
            'subsidies' => Yii::t('app', 'Субсидии'),
            'accrualSum' => Yii::t('app', 'Начислено'),
            'paymentSum' => Yii::t('app', 'Оплачено'),
            'debtTotal' => Yii::t('app', 'Задолженность'),
            'fineTotal' => Yii::t('app', 'Пеня'),
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
    public function getDebtDetails()
    {
        return $this->hasMany(DebtDetails::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
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
            $sd = 123;
        }

        return $fineRes;
    }

    public function calcFines()
    {
        $elements = [];

        if ($fineRes = $this->getFineCalculatorResult()) {
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

    public static function calcAccrualSum(Accrual $acc)
    {
        return (float)$acc->accrual - (float)$acc->subsidies + (float)$acc->single + (float)$acc->additional_adjustment;
    }

    public function calcDebts($sortParams = false)
    {
        $loans = [];
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
        }

        $elements = [];

        if (!empty($fineRes)) {
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
        return $this->find()->from('accrual')->where(['debtor_id' => $this->id])->sum('accrual') ?: 0;
    }

    public function getPaymentSum()
    {
        return $this->find()->from('payment')->where(['debtor_id' => $this->id])->sum('amount') ?: 0;
    }

    /**
     * Вернуть общую задолженность.
     *
     */
    public function getDebtTotal()
    {
        $debt = 0;

        $calcDebts = $this->calcDebts();
        if ($calcDebts) {
            //TODO: что делать если значений несколько?
            $debt = $calcDebts[0]['debt'];
        }

        return $debt;
    }

    /**
     * Вернуть общую пеню.
     *
     */
    public function getFineTotal()
    {
        $fine = 0;

        $calcFines = $this->calcFines();
        if ($calcFines) {
            foreach ($calcFines as $fineElem) {
                $fine += (float)$fineElem['fine'];
            }
        }

        return $fine;
    }

    /**
     * Вернуть задолженность по дате.
     *
     * @param int $date Дата задолженности - unix timestamp
     * @return float
     */
    public static function getDebt($date)
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
    }

    /**
     * Расчет пошлины - новая редакция (действует на Oct.01.2017).
     *
     * @return float|int
     */
    public function calculateStateFee2()
    {
        $amount = $this->getDebtTotal();

        if ($amount <= 10000) {
            // до 10 000 рублей - 2 процента цены иска, но не менее 200 рублей;
            $fee = $amount / 100 * 2;
            $fee = ($fee < 200) ? 200 : $fee;
        } elseif ($amount <= 20000) {
            // до 20 000 рублей - 2 процента цены иска, но не менее 400 рублей;
            $fee = $amount / 100 * 2;
            $fee = ($fee < 400) ? 400 : $fee;
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

        return $fee;
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

    public static function handleDebtorsCsvFile(UploadForm $uploadModel)
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
                self::addDebtors($sheetData);

            } else {
                //TODO: логирование
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Не удался импорт из-за внутренней ошибки.'));
            }
        }
    }

    public static function addDebtors(array $sheetData)
    {
        try {
            $info = DebtorParse::scrapeDebtorsFromArray($sheetData);
            $saveResult = DebtorParse::saveDebtors($info);

            $msg = Yii::t('app', 'Успешно прошла операция добавления в БД.') . '<br><br>';

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
}
