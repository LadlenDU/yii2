<?php

use yii\db\Migration;

class m170929_134100_delete_general_manager_table extends Migration
{
    public function safeUp()
    {
        // drops foreign key for table `general_manager`
        $this->dropForeignKey(
            'fk-debtor-general_manager_id',
            'debtor'
        );

        // drops index for column `general_manager_id`
        $this->dropIndex(
            'idx-debtor-general_manager_id',
            'debtor'
        );

        $this->dropColumn('debtor', 'general_manager_id');

        $this->dropTable('general_manager');
    }

    public function safeDown()
    {
        echo "m170929_134100_delete_general_manager_table cannot be reverted.\n";

        /*$this->createTable('general_manager', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'second_name' => $this->string(),
            'patronymic' => $this->string(),
        ]);*/

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170929_134100_delete_general_manager_table cannot be reverted.\n";

        return false;
    }
    */
}
