<?php

namespace common\models;

use Yii;
use yii\base\Model;

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

    protected function prepareStringToCompare($str)
    {
        $strMod = mb_strtolower($str, Yii::$app->charset);
        $strMod = preg_replace('/\s+/', ' ', $strMod);
        return $strMod;
    }

    protected function findColumName($source, $name)
    {
        $nameFiltered = $this->prepareStringToCompare($name);

        foreach ($source as $colName => $values) {
            foreach ($values as $val) {
                $valFiltered = $this->prepareStringToCompare($val);
                if ($valFiltered == $nameFiltered) {
                    return $colName;
                }
            }
        }

        return false;
    }

    public function putDebtorsFromArray(array $list)
    {
        $headers = [];

        $firstRow = true;
        foreach ($list as $row) {
            foreach ($row as $col) {
                if ($firstRow) {
                    $debtDetailsColName = false;
                    if (!$debtorColName = $this->findColumName(self::FIELDS_DEBTOR, $col)) {
                        if (!$debtDetailsColName = $this->findColumName(self::FIELDS_DEBT_DETAILS, $col)) {
                            //throw ;
                        }
                    }
                } else {

                }
            }

            if ($firstRow) {
                $firstRow = false;
            }
        }
    }
}
