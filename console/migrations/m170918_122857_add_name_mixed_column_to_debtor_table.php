<?php

use yii\db\Migration;

/**
 * Handles adding name_mixed to table `debtor`.
 */
class m170918_122857_add_name_mixed_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'name_mixed', $this->string()->after('patronymic'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debtor', 'name_mixed');
    }
}
