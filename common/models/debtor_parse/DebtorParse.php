<?php

namespace common\models\debtor_parse;

use Yii;
use yii\base\Model;
use common\components\ColumnNotFoundException;
use yii\base\UserException;
use common\models\Fine;
use common\models\Debtor;
use common\models\DebtorExt;
use common\models\DebtDetails;
use common\models\Name;
use common\models\Location;
use common\models\Accrual;
use common\models\Payment;

class DebtorParse extends Model
{
    protected static $resultInfo = [
        'debtors' => [
            'added' => 0,
            'updated' => 0,
        ],
        'payments' => [
            'added' => 0,
            'updated' => 0,
        ],
        'accruals' => [
            'added' => 0,
            'updated' => 0,
        ],
    ];

    protected static $FIELDS_DEBTOR = [
        /*'first_name' => [
            'имя',
        ],
        'second_name' => [
            'фамилия',
        ],
        'patronymic' => [
            'отчество',
        ],
        'name_mixed' => [
            'ФИО',
            'фамилия,имя,отчество',
            'фамилия, имя, отчество',
            'ФИО квартиросъемщика',
        ],*/
        /*'address' => [
            'адрес',
        ],
        'city' => [
            'населённый пункт',
        ],
        'street' => [
            'улица',
        ],
        'building' => [
            'дом',
        ],
        'appartment' => [
            'кв.',
            'квартира',
            '№ кв.',
        ],*/
        'phone' => [
            'телефон',
        ],
        'LS_EIRC' => [
            'ЛС ЕИРЦ',
        ],
        // Предлагается использовать это поле как уникальный ID (один из)
        'LS_IKU_provider' => [
            'ЛС ИКУ/поставщика',
            'ЛС ИКУ/ поставщика',
            '№ ЛС',
            '№ лицевого счета',
        ],
        'IKU' => [
            'ИКУ',
        ],
        'space_common' => [
            'общая площадь',
        ],
        'space_living' => [
            'жилая площадь',
        ],
        //'privatized' => [
        'ownership_type_id' => [
            'приватизировано',
            'приватизирован',
            'приватизирована',
            'форма собственности',
        ],
    ];

    /*protected static $FIELDS_DEBTOR_FILTER = [
        'ownership_type_id' => function($val) {

        }
    ];*/

    protected static $FIELDS_NAME = [
        'first_name' => [
            'имя',
        ],
        'second_name' => [
            'фамилия',
        ],
        'patronymic' => [
            'отчество',
        ],
        'full_name' => [
            'ФИО',
            'фамилия,имя,отчество',
            'фамилия, имя, отчество',
            'ФИО квартиросъемщика',
        ],
    ];

    protected static $FIELDS_LOCATION = [
        'city' => [
            'населённый пункт',
        ],
        'street' => [
            'улица',
        ],
        'building' => [
            'дом',
        ],
        'appartment' => [
            '№ кв.',
        ],
    ];

    protected static $FIELDS_PAYMENT = [
        'payment_date' => [
            //'Месяц последней оплаты',   //TODO: После модификации должен содержать полную дату - сделать с этим что-то
            'Дата оплаты',  // Искусственная колонка
        ],
        'amount' => [
            'Оплачено',
            'Оплаты',
        ],
    ];

    protected static $FIELDS_ACCRUAL = [
        'accrual_date' => [
            'Период учета',
            'Дата начисления',  // Искусственная колонка
        ],
        'accrual' => [
            //'Исходящее сальдо (дебет)',
            'Просроченная задолженность',
            'Начисления',
        ],
        'single' => [
            'Начисления разовые',
            'Разовые',
        ],
        'additional_adjustment' => [
            'Начисления постоянные',    //TODO: рассмотреть "Начисления разовые" и пр.
            'Доп.корректировка',
            'Доп. корректировка',
        ],
        'subsidies' => [
            'Начисленные субсидии', //TODO: "Оплачено субсидий" - рассмотреть
            'Субсидии',
        ],
    ];

    protected static $FIELDS_DEBT_DETAILS = [
        /*'amount' => [
            'сумма долга',
            'исходящее сальдо (кредит)'
        ],
        'amount_additional_services' => [
            'сумма долга с допуслугами',
        ],
        'date' => [
            'дата',
        ],
        'payment_date' => [
            'дата оплаты',
            'Месяц последней оплаты',
        ],
        'incoming_balance_debit' => [
            'Входящее сальдо (дебет)',
        ],
        'incoming_balance_credit' => [
            'Входящее сальдо (кредит)',
        ],
        'charges_permanent' => [
            'Начисления постоянные',
        ],
        'accrued_subsidies' => [
            'Начисленные субсидии',
        ],
        'one_time_charges' => [
            'Начисления разовые',
        ],
        'paid' => [
            'Оплачено',
            'Оплаты',
        ],
        'paid_insurance' => [
            'Оплачено страховки',
        ],
        'grants_paid' => [
            'Оплачено субсидий',
        ],
        'outgoing_balance_debit' => [
            'Исходящее сальдо (дебет)',
        ],
        'outgoing_balance_credit' => [
            'Исходящее сальдо (кредит)',
        ],
        'overdue_debts' => [
            'Просроченная задолженность',
        ],*/
    ];

    // Должны быть в lowercase
    protected static $FIELDS_IGNORE = [
        'долг (мес.)',
        'вх. сальдо',
        'вх.сальдо',
        'перерасчет',
        'исх.сальдо',
        'исх. сальдо',
        //'доп.корректировка',
        'субсидии перерасчет',
        //'начисления',
        'входящее сальдо (дебет)',
        'входящее сальдо (кредит)',
        'оплачено страховки',
        'оплачено субсидий',
        'исходящее сальдо (дебет)',
        'исходящее сальдо (кредит)',
        'месяц последней оплаты',
    ];

    protected static function prepareStringToCompare($str)
    {
        $strMod = mb_strtolower($str, Yii::$app->charset);
        $strMod = preg_replace('/\s+/', ' ', trim($strMod));
        return $strMod;
    }

    protected static function findColumName(array $source, $name)
    {
        $nameFiltered = self::prepareStringToCompare($name);

        foreach ($source as $colName => $values) {
            foreach ($values as $val) {
                $valFiltered = self::prepareStringToCompare($val);
                if ($valFiltered == $nameFiltered) {
                    return $colName;
                }
            }
        }

        return false;
    }

    public static function scrapeDebtorsFromArray(array $list)
    {
        $colInfo = [];
        $headers = [];

        $firstRow = true;
        foreach ($list as $row) {
            $rowInfo = [];
            foreach ($row as $key => $col) {
                $col = trim($col);
                $colPrepared = self::prepareStringToCompare($col);
                if ($firstRow && $col) {
                    if (in_array($colPrepared, self::$FIELDS_IGNORE)) {
                        continue;
                    }
                    if ($debtorColName = self::findColumName(self::$FIELDS_DEBTOR, $col)) {
                        $headers[$key] = ['debtor', $debtorColName, $col];
                    } else {
                        if ($accrualColName = self::findColumName(self::$FIELDS_ACCRUAL, $col)) {
                            $headers[$key] = ['accrual', $accrualColName, $col];
                        } elseif ($nameColName = self::findColumName(self::$FIELDS_NAME, $col)) {
                            $headers[$key] = ['name', $nameColName, $col];
                        } elseif ($locationColName = self::findColumName(self::$FIELDS_LOCATION, $col)) {
                            $headers[$key] = ['location', $locationColName, $col];
                        } elseif ($paymentColName = self::findColumName(self::$FIELDS_PAYMENT, $col)) {
                            $headers[$key] = ['payment', $paymentColName, $col];
                        } elseif ($debtDetailsColName = self::findColumName(self::$FIELDS_DEBT_DETAILS, $col)) {
                            $headers[$key] = ['debt_details', $debtDetailsColName, $col];
                        } else {
                            $exception = new ColumnNotFoundException(Yii::t('app', "Колонка '$col' не найдена."));
                            $exception->setWrongColumnName($col);
                            throw $exception;
                        }
                    }
                } else {

                    if (!empty($headers[$key])) {

                        //TODO: исправить костыль(и)
                        if ($headers[$key][1] == 'amount' || $headers[$key][1] == 'amount_additional_services') {
                            $col = self::convertNumberForSql($colPrepared);
                            //} elseif ($headers[$key][1] == 'privatized') {
                        } elseif ($headers[$key][1] == 'ownership_type_id') {
                            $col = ($colPrepared == 'приватизированное') ? 1 : 0;
                        } elseif ($headers[$key][1] == 'date' || $headers[$key][1] == 'payment_date') {
                            if ($colPrepared) {
                                $col = date("Y-m-d H:i:s", strtotime($colPrepared));
                            } else {
                                $col = null;
                            }
                        }

                        $rowInfo[$key] = $col;
                    }

                    //$rowInfo[$key] = $col;
                }
            }

            if ($firstRow) {
                $firstRow = false;
            } else {
                $colInfo[] = $rowInfo;
            }
        }

        return ['headers' => $headers, 'colInfo' => $colInfo];
    }

    public static function mergeResultInfo(array $info1, array $info2)
    {
        foreach ($info1 as $key => $val) {
            foreach ($val as $key2 => $val2) {
                $info1[$key][$key2] += $info2[$key][$key2];
            }
        }
        return $info1;
    }

    public static function saveDebtors(array $info)
    {
        $saveResult = self::$resultInfo;

        if ($info['headers']) {
            //TODO: костыль - сделать сравнение пользователей
            //DebtorExt::deleteAll();
            //TODO: кроме того, посмотреть корректность удаления
            //DebtDetails::deleteAll();

            // Найдем индекс, по которому искать уникальность пользователя
            $uniqueIndex = false;
            $accrualDateIndex = false;
            $paymentDateIndex = false;
            foreach ($info['headers'] as $key => $elem) {
                if ($elem[0] == 'debtor' && $elem[1] == 'LS_IKU_provider') {
                    $uniqueIndex = $key;
                    if ($accrualDateIndex !== false && $paymentDateIndex !== false) {
                        break;
                    }
                }
                if ($elem[0] == 'accrual' && $elem[1] == 'accrual_date') {
                    $accrualDateIndex = $key;
                    if ($uniqueIndex !== false && $paymentDateIndex !== false) {
                        break;
                    }
                }
                if ($elem[0] == 'payment' && $elem[1] == 'payment_date') {
                    $paymentDateIndex = $key;
                    if ($uniqueIndex !== false && $accrualDateIndex !== false) {
                        break;
                    }
                }
            }

            if (!$paymentDateIndex) {
                $paymentDateIndex = $accrualDateIndex;
            }

            if ($accrualDateIndex === false) {
                throw new \Exception(Yii::t('app', 'Не найдено поле с датой начисления.'));
            }

            #$fine = new Fine;

            $userId = Yii::$app->user->getId();

            foreach ($info['colInfo'] as $rowInfo) {
                #$accuralDateTimestamp = strtotime($rowInfo[$accrualDateIndex]);
                #$rowInfo[$accrualDateIndex] = date('Y-m-d H:i:s', $fine->checkVacationInput(false, $accuralDateTimestamp, true));

                $tmpResultInfo = self::$resultInfo;

                $whetherUpdate = false;

                $debtor = false;
                $debtDetails = false;
                $name = false;
                $location = false;
                $accrual = false;
                $payment = false;

                //TODO: add LS_IKU_provider, user_id index

                // Поиск уникального
                if ($debtor = Debtor::find()->with(['name', 'location', 'debtDetails', 'accruals', 'payments'])
                    ->where(['LS_IKU_provider' => $rowInfo[$uniqueIndex], 'user_id' => $userId])->one()
                ) {
                    //++$tmpResultInfo['debtors']['updated'];

                    // Обновляем
                    $whetherUpdate = true;
                    //TODO: косяк - должник может иметь несколько долгов (пока оставим)
                    if (isset($debtor->debtDetails[0])) {
                        $debtDetails = $debtor->debtDetails[0];
                    }
                    if (isset($debtor->name)) {
                        $name = $debtor->name;
                    }
                    if (isset($debtor->location)) {
                        $location = $debtor->location;
                    }
                    if (isset($debtor->accruals)) {
                        // Найдем на ту же дату
                        foreach ($debtor->accruals as $key => $acc) {
                            if ($acc['accrual_date'] == $rowInfo[$accrualDateIndex]) {
                                $accrual = $acc;
                                ++$tmpResultInfo['accruals']['updated'];
                                break;
                            }
                        }
                    }
                    if (isset($debtor->payments)) {
                        foreach ($debtor->payments as $key => $pm) {
                            if ($pm['payment_date'] == $rowInfo[$paymentDateIndex]) {
                                $payment = $pm;
                                ++$tmpResultInfo['payments']['updated'];
                                break;
                            }
                        }
                    }
                }

                if (empty($debtor)) {
                    $debtor = new DebtorExt;
                    ++$tmpResultInfo['debtors']['added'];
                    $debtor->user_id = $userId;
                }
                if (empty($debtDetails)) {
                    $debtDetails = new DebtDetails;
                }
                if (empty($name)) {
                    $name = new Name;
                }
                if (empty($location)) {
                    $location = new Location;
                }
                if (empty($accrual)) {
                    $accrual = new Accrual;
                    ++$tmpResultInfo['accruals']['added'];
                }
                if (empty($payment)) {
                    $payment = new Payment;
                    ++$tmpResultInfo['payments']['added'];
                }

                $savePayment = true;
                $saveAccrual = true;

                //$debtor = new DebtorExt;
                //$debtDetails = new DebtDetails();
                foreach ($rowInfo as $key => $colInfo) {
                    if (!empty($info['headers'][$key])) {
                        if ($info['headers'][$key][0] == 'debtor') {
                            $debtor->{$info['headers'][$key][1]} = $colInfo;
                        } elseif ($info['headers'][$key][0] == 'debt_details') {    //TODO: get rid of debt_details or change it
                            $debtDetails->{$info['headers'][$key][1]} = $colInfo;
                            //$debtDetails->save();
                            //$debtor->link('debtDetails', $debtDetails);
                            #$debtor->debtDetails[$info['headers'][$key][1]] = $colInfo;
                            #$debtor->getDebtDetails()->{$info['headers'][$key][1]} = $colInfo;
                            #$debtDetails = $debtor->getDebtDetails();
                            #$debtDetails->{$info['headers'][$key][1]} = $colInfo;
                        } elseif ($info['headers'][$key][0] == 'name') {
                            $name->{$info['headers'][$key][1]} = $colInfo;
                        } elseif ($info['headers'][$key][0] == 'location') {
                            $location->{$info['headers'][$key][1]} = $colInfo;
                        } elseif ($info['headers'][$key][0] == 'accrual') {
                            if ($info['headers'][$key][1] == 'accrual' && !$colInfo) {
                                $saveAccrual = false;
                                --$tmpResultInfo['accruals']['added'];
                            } else {
                                if (in_array($info['headers'][$key][1], ['accrual', 'additional_adjustment', 'subsidies', 'single'])) {
                                    $accrual->{$info['headers'][$key][1]} = self::convertNumberForSql($colInfo);
                                } else {
                                    if ($info['headers'][$key][1] == 'accrual_date') {
                                        $accrual->{$info['headers'][$key][1]} = $colInfo;
                                    }
                                }
                            }
                        } elseif ($info['headers'][$key][0] == 'payment') {
                            // Оплата не велась - не сохраняем
                            if ($info['headers'][$key][1] == 'amount' && !$colInfo) {
                                $savePayment = false;
                                --$tmpResultInfo['payments']['added'];
                            } else {
                                $payment->{$info['headers'][$key][1]} = $colInfo;
                            }
                        }
                    }
                }
                if ($debtor->validate()) {
                    $transaction = \Yii::$app->db->beginTransaction();

                    try {
                        $debtor->save();

                        //TODO: можно оптимизировать? (двойные запросы при перезаписи не будут??)
                        $debtDetails->save();
                        $debtDetails->link('debtor', $debtor);

                        $name->save();
                        $name->link('debtor', $debtor);

                        $location->save();
                        $location->link('debtors', $debtor);

                        if ($saveAccrual) {
                            $accrual->save();
                            $accrual->link('debtor', $debtor);
                        }

                        if ($savePayment) {
                            $payment->save();
                            $payment->link('debtor', $debtor);
                        }

                        $transaction->commit();

                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }

                    /*$debtor->link('debtDetails', $debtDetails);
                    $debtor->link('name', $name);
                    $debtor->link('location', $location);
                    $debtor->link('accruals', $accrual);
                    $debtor->link('payments', $payment);*/

                    //$whetherUpdate ? ++$saveResult['updated'] : ++$saveResult['added'];
                    /*array_walk_recursive($tmpResultInfo, function($item, $key) use (&$saveResult){
                        if ($saveResult[$key])
                        $saveResult[$key] = isset($saveResult[$key]) ?  $item + $saveResult[$key] : $item;
                    });*/
                    $saveResult = self::mergeResultInfo($saveResult, $tmpResultInfo);

                } else {
                    $err = print_r($debtor->getErrors(), true);
                    throw new UserException(Yii::t('app', "Данные не прошли валидацию: $err"));
                }
            }
        } else {
            throw new UserException(Yii::t('app', 'Не обнаружены заголовки.'));
        }

        return $saveResult;
    }

    public static function convertNumberForSql($number)
    {
        //TODO: цифровой формат может иметь запятую в качестве разделителя разрядов (1,336.44)
        //в то время как в оригинале будет 1336,44 (1 336,44)
        //выяснить почему и как обойтись без потенциальных ошибок
        //TODO 2: в CSV запятая разделяет копейки. Попробуем искать точку, если она есть, то действуем
        //как прежде.
        if (strpos($number, '.') !== false) {
            $number = str_replace([' ', ','], '', $number);
        } else {
            $number = str_replace([' ', ','], ['', '.'], $number);
        }

        return $number;
    }

    /**
     * Форматирование "сырого" формата (отсканированного) excel файла (3130428789 - Соколов Александр Геннадьевич )
     *
     * @param array $sheetDataRaw
     */
    public static function format_2(array $sheetDataRaw)
    {
        //TODO: ужасный костыль - исправить
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 100000);

        $sheetData = [];

        $sheetDataRaw = array_values($sheetDataRaw);
        foreach ($sheetDataRaw as $key => $val) {
            $sheetDataRaw[$key] = array_values($val);
        }

        if (!isset($sheetDataRaw[0][0])) {
            throw new \Exception(Yii::t('app', 'Пустая таблица'));
        }

        $LS_IKU_provider = trim($sheetDataRaw[0][0]);
        $full_name = trim($sheetDataRaw[0][1]);

        $fine = new Fine;

        foreach ($sheetDataRaw as $key => $row) {
            if ($key < 1) {
                continue;
            }

            if ($key == 1) {
                $sheetData[1] = $row;
                //$sheetData[1][9] = 'Исходящее сальдо (дебет)';
                // Отсутствующие поля
                $sheetData[1][10] = '№ ЛС';
                $sheetData[1][11] = 'ФИО';
                $sheetData[1][12] = 'Месяц последней оплаты';
                continue;
            }


            foreach ($row as $k => $val) {
                $val = str_replace(',', '.', $val);
                $row[$k] = preg_replace('/\s+/', '', $val);
            }

            // дата
            if (!$row[0]) {
                continue;
            }

            $sheetData[$key] = $row;

            // Добавляем перерасчет
            //TODO: раскомментировать после теста
            $sheetData[$key][2] += $sheetData[$key][3];

            list($monthNumber, $year) = explode('.', $sheetData[$key][0]);
            $monthNumber = (int)$monthNumber;
            if ($monthNumber < 10) {
                $monthNumber = '0' . $monthNumber;
            }
            $year = self::fixYearBug($year);
            //$sheetData[$key][0] = "01.$monthNumber.$year";
            $sheetData[$key][0] = "$year-$monthNumber-01 00:00:00";
            //$dateOfAccrual = "$year-$monthNumber-01 00:00:00";
            //$sheetData[$key][0] = date('Y-m-d H:i:s', strtotime("+1 month", strtotime($dateOfAccrual)));

            $accuralDateTimestamp = strtotime($sheetData[$key][0]);
            $sheetData[$key][0] = date('Y-m-d H:i:s', $fine->checkVacationInput(false, $accuralDateTimestamp, true));

            $sheetData[$key][10] = $LS_IKU_provider;
            $sheetData[$key][11] = $full_name;
            $sheetData[$key][12] = $sheetData[$key][0];
        }

        return $sheetData;
    }

    /**
     * TODO: костыль, исправляет ошибку когда их Excel файла берутся значения вроде 9.200799999999999 вместо 9.2008
     * @param string $year - год типа 200799999999999 (200900000000001)
     */
    protected static function fixYearBug($year)
    {
        if (strlen($year) > 4) {
            $increase = $year[4] == '9';
            $year = substr($year, 0, 4);
            if ($increase) {
                $year += 1;
            }
        }
        return $year;
    }
}
