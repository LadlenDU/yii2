<?php

use yii\db\Migration;

class m170928_102709_add_drop_column_from_user_info_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('user_info', 'birthday');
    }

    public function safeDown()
    {
        echo "m170928_102709_add_drop_column_from_user_info_table cannot be reverted.\n";

        $this->addColumn('user_info', 'birthday', $this->datetime()->after('location_id'));

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170928_102709_add_drop_column_from_user_info_table cannot be reverted.\n";

        return false;
    }
    */
}
