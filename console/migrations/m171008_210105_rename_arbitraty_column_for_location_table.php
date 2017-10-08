<?php

use yii\db\Migration;

class m171008_210105_rename_arbitraty_column_for_location_table extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('location', 'arbitraty', 'full_address');
    }

    public function safeDown()
    {
        echo "m171008_210105_rename_arbitraty_column_for_location_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171008_210105_rename_arbitraty_column_for_location_table cannot be reverted.\n";

        return false;
    }
    */
}
