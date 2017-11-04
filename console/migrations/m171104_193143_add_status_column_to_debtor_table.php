<?php

use yii\db\Migration;

/**
 * Handles adding status to table `debtor`.
 */
class m171104_193143_add_status_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'status', $this->string()->defaultValue('new')->comment('Статус должника'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debtor', 'status');
    }
}
