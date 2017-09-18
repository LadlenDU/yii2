<?php

use yii\db\Migration;

/**
 * Handles adding phone to table `debtor`.
 */
class m170918_121909_add_phone_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'phone', $this->string()->after('appartment'));
        $this->addColumn('debtor', 'LS_EIRC', $this->string()->after('phone')->comment('ЛС ЕИРЦ'));
        $this->addColumn('debtor', 'LS_IKU_provider', $this->string()->after('LS_EIRC')->comment('ЛС ИКУ/поставщика'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debtor', 'phone');
        $this->dropColumn('debtor', 'LS_EIRC');
        $this->dropColumn('debtor', 'LS_IKU_provider');
    }
}
