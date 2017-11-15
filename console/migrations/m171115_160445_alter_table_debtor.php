<?php

use yii\db\Migration;

class m171115_160445_alter_table_debtor extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('debtor', 'user_id', $this->integer()->notNull());
        $this->renameColumn('debtor', 'user_id', 'company_id');

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-debtor-user_id',
            'debtor'
        );
        // drops index for column `user_id`
        $this->dropIndex(
            'idx-debtor-user_id',
            'debtor'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-debtor-company_id',
            'debtor',
            'company_id'
        );
        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-debtor-company_id',
            'debtor',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        echo "m171115_160445_alter_table_debtor cannot be reverted.\n";

        echo "Nothing done\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171115_160445_alter_table_debtor cannot be reverted.\n";

        return false;
    }
    */
}
