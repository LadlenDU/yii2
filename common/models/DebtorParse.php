<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\components\ColumnNotFoundException;
use yii\base\UserException;

class DebtorParse extends Model
{
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
        if ($info['headers']) {
            //TODO: костыль - сделать сравнение пользователей
            DebtorExt::deleteAll();
            //TODO: кроме того, посмотреть корректность удаления
            DebtDetails::deleteAll();

            foreach ($info['colInfo'] as $rowInfo) {
                $debtor = new DebtorExt;
                $debtDetails = new DebtDetails();
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
                } else {
                    $err = print_r($debtor->getErrors(), true);
                    throw new UserException(Yii::t('app', "Данные не прошли валидацию: $err"));
                }
            }
        } else {
            throw new UserException(Yii::t('app', 'Не обнаружены заголовки.'));
        }
    }

    /**
     * Форматирование "сырого" формата первого csv файла ("2014.csv")
     *
     * @param array $sheetDataRaw
     */
    public function format_1(array $sheetDataRaw)
    {
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
            $sheetData[$key][15] = $street;
            $sheetData[$key][16] = $building;
        }

        return $sheetData;
    }
}
