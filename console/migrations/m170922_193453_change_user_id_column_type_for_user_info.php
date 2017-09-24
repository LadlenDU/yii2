<?php

use yii\db\Migration;

class m170922_193453_change_user_id_column_type_for_user_info extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('user_info', 'user_id', $this->integer()->notNull()->unique());
    }

    public function safeDown()
    {
        echo "m170922_193453_change_user_id_column_type_for_user_info cannot be reverted.\n";

        $this->alterColumn('user_info', 'user_id', $this->integer()->notNull());

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170922_193453_change_user_id_column_type_for_user_info cannot be reverted.\n";

        return false;
    }
    */
}
