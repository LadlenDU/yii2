<?php

use yii\db\Migration;

/**
 * Handles adding some to table `debtor`.
 */
class m171012_151210_add_some_columns_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'single', $this->string()->comment('Разовые'));
        $this->addColumn('debtor', 'additional_adjustment', $this->string()->comment('Доп. корректировка'));
        $this->addColumn('debtor', 'subsidies', $this->string()->comment('Субсидии'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debtor', 'single');
        $this->dropColumn('debtor', 'additional_adjustment');
        $this->dropColumn('debtor', 'subsidies');
    }
}
