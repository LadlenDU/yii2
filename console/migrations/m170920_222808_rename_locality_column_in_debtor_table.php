<?php

use yii\db\Migration;

class m170920_222808_rename_locality_column_in_debtor_table extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('debtor', 'locality', 'city');
    }

    public function safeDown()
    {
        echo "m170920_222808_rename_locality_column_in_debtor_table cannot be reverted.\n";

        $this->renameColumn('debtor', 'city', 'locality');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170920_222808_rename_locality_column_in_debtor_table cannot be reverted.\n";

        return false;
    }
    */
}
