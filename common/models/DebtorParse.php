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
            'ЛС ИКУ/ поставщика',
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

    /*protected static $FIELDS_DEBTOR_SPECIAL_CARE = [
        'privatized' => function() {

        },
    ];*/

    protected static $FIELDS_DEBT_DETAILS = [
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
                if ($col = trim($col)) {
                    if ($firstRow) {
                        $colPrepared = self::prepareStringToCompare($col);
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
                        $rowInfo[$key] = $col;
                    }
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
            /*Debtor::()->joinWith('pages')->andWhere([$levelName => $level])
                ->select(['tree.id', 'tree.name', 'page.alias'])->all();*/

            foreach ($info['colInfo'] as $rowInfo) {
                $debtor = new Debtor;
                foreach ($rowInfo as $key => $colInfo) {
                    if (!empty($info['headers'][$key])) {
                        if ($info['headers'][$key][0] == 'debtor') {
                            $debtor->{$info['headers'][$key][1]} = $colInfo;
                        }
                    }
                }
                if ($debtor->validate()) {
                    $debtor->save();
                } else {
                    $err = print_r($debtor->getErrors(), true);
                    throw new UserException(Yii::t('app', "Данные не прошли валидацию: $err"));
                }
            }
        } else {
            throw new UserException(Yii::t('app', 'Не обнаружены заголовки.'));
        }
    }
}
