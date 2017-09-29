<?php

use yii\db\Migration;

class m170929_162945_change_file_column_for_user_info_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('user_info', 'document_1', 'mediumblob');
        $this->alterColumn('user_info', 'document_2', 'mediumblob');
    }

    public function safeDown()
    {
        echo "m170929_162945_change_file_column_for_user_info_table cannot be reverted.\n";

        $this->alterColumn('user_info', 'document_2', 'blob');
        $this->alterColumn('user_info', 'document_1', 'blob');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170929_162945_change_file_column_for_user_info_table cannot be reverted.\n";

        return false;
    }
    */
}
