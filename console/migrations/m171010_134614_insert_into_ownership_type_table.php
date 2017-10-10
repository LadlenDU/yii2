<?php

use yii\db\Migration;

class m171010_134614_insert_into_ownership_type_table extends Migration
{
    public function safeUp()
    {
        $this->insert('ownership_type', [
            'id' => 1,
            'name' => 'Приватизированное',
        ]);
        $this->insert('ownership_type', [
            'id' => 2,
            'name' => 'Муниципальное',
        ]);
    }

    public function safeDown()
    {
        echo "m171010_134614_insert_into_ownership_type_table cannot be reverted.\n";

        $this->delete('ownership_type', ['id' => 2]);
        $this->delete('ownership_type', ['id' => 1]);

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171010_134614_insert_into_ownership_type_table cannot be reverted.\n";

        return false;
    }
    */
}
