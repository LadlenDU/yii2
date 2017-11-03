<?php

use yii\db\Migration;

class m171103_113625_alter_table_company extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('company', 'full_name', $this->string()->notNull()->defaultValue('')->comment('Полное название'));
        $this->alterColumn('company', 'short_name', $this->string()->notNull()->defaultValue('')->comment('Сокращенное название'));
    }

    public function safeDown()
    {
        echo "m171103_113625_alter_table_company cannot be reverted.\n";

        echo "Nothing done";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171103_113625_alter_table_company cannot be reverted.\n";

        return false;
    }
    */
}
