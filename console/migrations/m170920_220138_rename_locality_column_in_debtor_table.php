<?php

use yii\db\Migration;

class m170920_220138_rename_locality_column_in_debtor_table extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170920_220138_rename_locality_column_in_debtor_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170920_220138_rename_locality_column_in_debtor_table cannot be reverted.\n";

        return false;
    }
    */
}
