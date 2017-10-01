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
        'first_name' => [
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
        ],
        'address' => [
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
        ],
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
        'privatized' => [
            'приватизировано',
            'приватизирован',
            'приватизирована',
            'форма собственности',
        ],
    ];

    /*protected static $FIELDS_DEBTOR_FILTER = [
        'privatized' => function($val) {

        }
    ];*/

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
        /*'payment_date' => [
            'дата оплаты',
        ],*/
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
                        if ($debtDetailsColName = self::findColumName(self::$FIELDS_DEBT_DETAILS, $col)) {
                            $headers[$key] = ['debt_details', $debtDetailsColName, $col];
                        } else {
                            //TODO: Не распознанные колонки игнорируем (пока)
                            /*$exception = new ColumnNotFoundException(Yii::t('app', "Колонка '$col' не найдена."));
                            $exception->setWrongColumnName($col);
                            throw $exception;*/
                        }
                    }
                } else {

                    if (!empty($headers[$key])) {

                        //TODO: исправить костыль(и)
                        if ($headers[$key][1] == 'amount' || $headers[$key][1] == 'amount_additional_services') {
                            //TODO: цифровой формат может иметь запятую в качестве разделителя разрядов (1,336.44)
                            //в то время как в оригинале будет 1336,44 (1 336,44)
                            //выяснить почему и как обойтись без потенциальных ошибок
                            $col = str_replace([' ', ','], '', $colPrepared);
                        } elseif ($headers[$key][1] == 'privatized') {
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
                    $debtDetails = $debtor->debtDetails[0];
                } else {
                    $debtor = new DebtorExt;
                    $debtDetails = new DebtDetails();
                }

                //$debtor = new DebtorExt;
                //$debtDetails = new DebtDetails();
                foreach ($rowInfo as $key => $colInfo) {
                    if (!empty($info['headers'][$key])) {
                        if ($info['headers'][$key][0] == 'debtor') {
                            $debtor->{$info['headers'][$key][1]} = $colInfo;
                        } else {    // $info['headers'][$key][0] == 'debt_details'
                            $debtDetails->{$info['headers'][$key][1]} = $colInfo;
                            //$debtDetails->save();
                            //$debtor->link('debtDetails', $debtDetails);
                            #$debtor->debtDetails[$info['headers'][$key][1]] = $colInfo;
                            #$debtor->getDebtDetails()->{$info['headers'][$key][1]} = $colInfo;
                            #$debtDetails = $debtor->getDebtDetails();
                            #$debtDetails->{$info['headers'][$key][1]} = $colInfo;
                        }
                    }
                }
                if ($debtor->validate()) {
                    $debtor->save();
                    $debtor->link('debtDetails', $debtDetails);

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
    public function format_1(array $sheetDataRaw)
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
        }

        return $sheetData;
    }
}
