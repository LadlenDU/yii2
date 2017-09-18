<?php

use yii\db\Migration;

/**
 * Handles adding balance to table `debtor`.
 */
class m170918_114233_add_balance_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'locality', $this->string()->after('address'));
        $this->addColumn('debtor', 'street', $this->string()->after('locality'));
        $this->addColumn('debtor', 'house', $this->string()->after('street'));
        $this->addColumn('debtor', 'appartment', $this->string()->after('house'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debtor', 'locality');
        $this->dropColumn('debtor', 'street');
        $this->dropColumn('debtor', 'house');
        $this->dropColumn('debtor', 'appartment');
    }
}
