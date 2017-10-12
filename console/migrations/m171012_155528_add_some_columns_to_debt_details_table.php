<?php

use yii\db\Migration;

/**
 * Handles adding some to table `debt_details`.
 */
class m171012_155528_add_some_columns_to_debt_details_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        //$this->addColumn('debt_details', 'paid', $this->decimal(8,2)->comment('Оплачено'));
        $this->addColumn('debt_details', 'debt', $this->decimal(8,2)->comment('Задолженность'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        //$this->dropColumn('debt_details', 'paid');
        $this->dropColumn('debt_details', 'debt');
    }
}
