<?php

use yii\db\Migration;

class m171107_054003_change_LS_IKU_provider_in_debtor_table extends Migration
{
    public function safeUp()
    {
        //$this->alterColumn('debtor', 'LS_IKU_provider', $this->string()->unique->notNull()->comment('Номер ЛС'));
        $this->dropIndex('LS_IKU_provider', 'debtor');
    }

    public function safeDown()
    {
        echo "m171107_054003_change_LS_IKU_provider_in_debtor_table cannot be reverted.\n";

        echo "Nothing done";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171107_054003_change_LS_IKU_provider_in_debtor_table cannot be reverted.\n";

        return false;
    }
    */
}
