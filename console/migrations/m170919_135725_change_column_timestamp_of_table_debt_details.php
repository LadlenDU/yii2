<?php

use yii\db\Migration;

class m170919_135725_change_column_timestamp_of_table_debt_details extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('debt_details', 'payment_date', 'datetime');
    }

    public function safeDown()
    {
        echo "m170919_135725_change_column_timestamp_of_table_debt_details cannot be reverted.\n";
        $this->alterColumn('debt_details', 'payment_date', 'timestamp');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170919_135725_change_column_timestamp_of_table_debt_details cannot be reverted.\n";

        return false;
    }
    */
}
