<?php

use yii\db\Migration;

/**
 * Handles the creation of table `general_manager`.
 */
class m170917_000629_create_general_manager_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('general_manager', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'second_name' => $this->string(),
            'patronymic' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('general_manager');
    }
}
