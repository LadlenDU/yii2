<?php

use yii\db\Migration;

/**
 * Handles adding IKU to table `debtor`.
 */
class m170918_143446_add_IKU_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'IKU', $this->string()->after('LS_IKU_provider'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debtor', 'IKU');
    }
}
