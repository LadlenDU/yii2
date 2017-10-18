<?php

use yii\db\Migration;

class m171018_011117_change_LS_IKU_provider_in_debtor_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('debtor', 'LS_IKU_provider', $this->string()->unique());
    }

    public function safeDown()
    {
        echo "m171018_011117_change_LS_IKU_provider_in_debtor_table cannot be reverted.\n";

        $this->alterColumn('debtor', 'LS_IKU_provider', $this->string());

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171018_011117_change_LS_IKU_provider_in_debtor_table cannot be reverted.\n";

        return false;
    }
    */
}
