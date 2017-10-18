<?php

use yii\db\Migration;

class m171018_021816_change_name_id_in_debtor_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('debtor', 'name_id', $this->integer()->unique());
    }

    public function safeDown()
    {
        echo "m171018_021816_change_name_id_in_debtor_table cannot be reverted.\n";

        $this->alterColumn('debtor', 'name_id', $this->integer());

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171018_021816_change_name_id_in_debtor_table cannot be reverted.\n";

        return false;
    }
    */
}
