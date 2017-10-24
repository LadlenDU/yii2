<?php

use yii\db\Migration;

class m171024_085617_insert_default_values_into_tax_system_table extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `tax_system` AUTO_INCREMENT=0');
        $this->batchInsert('tax_system', ['name'], [
                ['Общая система налогообложения'],
                ['Упрощённая система налогообложения'],
            ]
        );
    }

    public function safeDown()
    {
        echo "tax_system will be cleaned up.\n";

        $this->delete('tax_system');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171024_085617_insert_default_values_into_tax_system_table cannot be reverted.\n";

        return false;
    }
    */
}
