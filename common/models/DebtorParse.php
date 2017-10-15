<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\components\ColumnNotFoundException;
use yii\base\UserException;

class DebtorParse extends Model
{
    protected static $MONTHS = [
        'янв' => 1,
        'фев' => 2,
        'мар' => 3,
        'апр' => 4,
        'май' => 5,
        'июн' => 6,
        'июл' => 7,
        'авг' => 8,
        'сен' => 9,
        'окт' => 10,
        'ноя' => 11,
        'дек' => 12,
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
            'Месяц последней оплаты',   //TODO: После модификации должен содержать полну дату - сделать с этим что-то
        ],
        'amount' => [
            'Оплачено',
        ],
    ];

    protected static $FIELDS_ACCRUAL = [
        'accrual_date' => [
            'Дата начисления',  // Искусственная колонка
        ],
        'accrual' => [
            'Исходящее сальдо',
        ],
        'single' => [
            'Начисления разовые',
        ],
        'additional_adjustment' => [
            'Начисления постоянные',    //TODO: рассмотреть "Начисления разовые" и пр.
        ],
        'subsidies' => [
            'Начисленные субсидии', //TODO: "Оплачено субсидий" - рассмотреть
        ],
    ];

    protected static $FIELDS_DEBT_DETAILS = [
        'amount' => [
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
        ],
    ];

    protected static $FIELDS_IGNORE = [
        'долг (мес.)',
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
                            //TODO: цифровой формат может иметь запятую в качестве разделителя разрядов (1,336.44)
                            //в то время как в оригинале будет 1336,44 (1 336,44)
                            //выяснить почему и как обойтись без потенциальных ошибок
                            //TODO 2: в CSV запятая разделяет копейки. Попробуем искать точку, если она есть, то действуем
                            //как прежде.
                            if (strpos($colPrepared, '.') !== false) {
                                $col = str_replace([' ', ','], '', $colPrepared);
                            } else {
                                $col = str_replace([' ', ','], ['', '.'], $colPrepared);
                            }
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

    public static function saveDebtors(array $info)
    {
        $saveResult = [
            'added' => 0,
            'updated' => 0,
        ];

        if ($info['headers']) {
            //TODO: костыль - сделать сравнение пользователей
            //DebtorExt::deleteAll();
            //TODO: кроме того, посмотреть корректность удаления
            //DebtDetails::deleteAll();

            // Найдем индекс, по которому искать уникальность пользователя
            $uniqueIndex = '';
            foreach ($info['headers'] as $key => $elem) {
                if ($elem[1] == 'LS_IKU_provider') {
                    $uniqueIndex = $key;
                    break;
                }
            }

            foreach ($info['colInfo'] as $rowInfo) {

                $whetherUpdate = false;

                // Поиск уникального
                if ($debtor = Debtor::find()->where(['LS_IKU_provider' => $rowInfo[$uniqueIndex]])->one()) {
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
                    if (isset($debtor->accruals[0])) {
                        $accrual = $debtor->accruals[0];    //TODO: косяк - должник может иметь несколько accruals (пока оставим)
                    }
                    if (isset($debtor->payments[0])) {
                        $payment = $debtor->payments[0];    //TODO: косяк - должник может иметь несколько payments (пока оставим)
                    }
                }

                if (empty($debtor)) {
                    $debtor = new DebtorExt;
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
                }
                if (empty($payment)) {
                    $payment = new Payment;
                }

                //$debtor = new DebtorExt;
                //$debtDetails = new DebtDetails();
                foreach ($rowInfo as $key => $colInfo) {
                    if (!empty($info['headers'][$key])) {
                        if ($info['headers'][$key][0] == 'debtor') {
                            $debtor->{$info['headers'][$key][1]} = $colInfo;
                        } elseif ($info['headers'][$key][0] == 'debt_details') {
                            $debtDetails->{$info['headers'][$key][1]} = $colInfo;
                            //$debtDetails->save();
                            //$debtor->link('debtDetails', $debtDetails);
                            #$debtor->debtDetails[$info['headers'][$key][1]] = $colInfo;
                            #$debtor->getDebtDetails()->{$info['headers'][$key][1]} = $colInfo;
                            #$debtDetails = $debtor->getDebtDetails();
                            #$debtDetails->{$info['headers'][$key][1]} = $colInfo;
                        } elseif ($info['headers'][$key][0] == 'name') {
                            $name->{$info['headers'][$key][1]} = $colInfo;
                        }elseif ($info['headers'][$key][0] == 'location') {
                            $location->{$info['headers'][$key][1]} = $colInfo;
                        }elseif ($info['headers'][$key][0] == 'accrual') {
                            $accrual->{$info['headers'][$key][1]} = $colInfo;
                        }elseif ($info['headers'][$key][0] == 'payment') {
                            $payment->{$info['headers'][$key][1]} = $colInfo;
                        }
                    }
                }
                if ($debtor->validate()) {
                    $debtor->save();
                    $debtor->link('debtDetails', $debtDetails);
                    $debtor->link('name', $name);
                    $debtor->link('location', $location);
                    $debtor->link('accruals', $accrual);
                    $debtor->link('payments', $payment);

                    $whetherUpdate ? ++$saveResult['updated'] : ++$saveResult['added'];

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

    /**
     * Форматирование "сырого" формата первого csv файла ("2014.csv")
     *
     * @param array $sheetDataRaw
     */
    public static function format_1(array $sheetDataRaw)
    {
        //TODO: ужасный костыль - исправить
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 1000);

        $sheetData = [];

        $startPart = 0;
        $street = '';
        $building = 0;

        foreach ($sheetDataRaw as $key => $row) {
            if ($key < 9) {
                continue;
            }

            //$sheetData[$key] = $row;

            if ($key == 9) {
                $sheetData[$key] = $row;
                $sheetData[9][3] = 'Входящее сальдо (дебет)';
                $sheetData[9][4] = 'Входящее сальдо (кредит)';
                $sheetData[9][11] = 'Исходящее сальдо (дебет)';
                $sheetData[9][12] = 'Исходящее сальдо (кредит)';
                // Отсутствующие поля
                $sheetData[9][15] = 'Улица';
                $sheetData[9][16] = 'Дом';
                $sheetData[9][17] = 'Дата начисления';
                //$sheetData[9][18] = 'Дата оплаты';
                continue;
            }

            if (!$row[0]) {
                // Начало части "улица-дом"
                $startPart = 1;
                continue;
            }

            // Вычисляем конец части "улица-дом"
            $itogo = mb_strtolower(mb_substr($row[0], 0, 5, 'UTF-8'), 'UTF-8');
            if ($itogo == 'итого') {
                /*if ('Итого по всем домам' == $sheetData[$key][0]) {
                }*/
                continue;
            }

            if ($startPart == 1) {
                list($street, $building) = explode('д.', $row[0]);
                //list($street, $building) = explode('ул.', $sheetData[$key][0]);
                /*$parts = explode('ул.', $sheetData[$key][0]);
                if (empty($parts[1])) {
                }*/
                $street = trim($street);
                $building = trim(str_replace('д.', '', $building));
                $startPart = 2;
                continue;
            }

            $sheetData[$key] = $row;

            // дата
            $sheetData[$key][14] = trim($sheetData[$key][14]);
            if ($sheetData[$key][14]) {
                list($month, $year) = explode('.', $sheetData[$key][14]);
                $monthShortName = mb_substr(trim($month), 0, 3, 'UTF-8');
                $year = '20' . trim($year);
                $monthNumber = isset(self::$MONTHS[$monthShortName]) ? self::$MONTHS[$monthShortName] : 1;
                if ($monthNumber < 10) {
                    $monthNumber = '0' . $monthNumber;
                }
                $sheetData[$key][14] = "01/$monthNumber/$year";
            }

            $sheetData[$key][15] = $street;
            $sheetData[$key][16] = $building;
            $sheetData[$key][17] = '2017-08-29 00:00:00';    //'29.08.2017';    //TODO: тупо ввод вручную
            //$sheetData[$key][18] = '';
        }

        return $sheetData;
    }
}
