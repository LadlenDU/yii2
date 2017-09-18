<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\components\ColumnNotFoundException;

class Debtor extends Model
{
    const FIELDS_DEBTOR = [
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
        ],
        'address' => [
            'адрес',
        ],
        'locality' => [
            'населённый пункт',
        ],
        'street' => [
            'улица',
        ],
        'house' => [
            'дом',
        ],
        'appartment' => [
            'кв.',
            'квартира',
        ],
        'phone' => [
            'телефон',
        ],
        'LS_EIRC' => [
            'ЛС ЕИРЦ',
        ],
        'LS_IKU_provider' => [
            'ЛС ИКУ/поставщика',
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

    const FIELDS_DEBT_DETAILS = [
        'amount' => [
            'сумма долга',
        ],
        'amount_additional_services' => [
            'сумма долга с допуслугами',
        ],
        'date' => [
            'дата',
        ],
        'payment_date' => [
            'дата оплаты',
        ],
    ];

    protected static function prepareStringToCompare($str)
    {
        $strMod = mb_strtolower($str, Yii::$app->charset);
        $strMod = preg_replace('/\s+/', ' ', $strMod);
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
            foreach ($row as $col) {
                if ($firstRow) {
                    if ($debtorColName = self::findColumName(self::FIELDS_DEBTOR, $col)) {
                        $headers[] = ['debtor', $debtorColName, $col];
                    } else {
                        if ($debtDetailsColName = self::findColumName(self::FIELDS_DEBT_DETAILS, $col)) {
                            $headers[] = ['debt_details', $debtDetailsColName, $col];
                        } else {
                            $exception = new ColumnNotFoundException("Колонка $col не найдена.");
                            $exception->setWrongColumnName($col);
                            throw $exception;
                        }
                    }
                } else {
                    $rowInfo[] = $col;
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

    }
}
