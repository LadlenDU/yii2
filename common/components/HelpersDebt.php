<?php

namespace common\components;

use \yii\db\ActiveRecord;
use common\models\Debtor;
use common\models\Court;

class HelpersDebt
{
    /**
     * Найти адрес.
     *
     * @param ActiveRecord $sourceRecord источник адреса
     * @param string $targetModel модель, в которой искать совпадающий адрес
     */
    public static function findCourtAddressForDebtor(ActiveRecord $sourceRecord, $targetModel)
    {
        return $targetModel::find()->one();
    }

    public static function fillInvoiceBlank(Debtor $debtor, Court $court)
    {

    }
}