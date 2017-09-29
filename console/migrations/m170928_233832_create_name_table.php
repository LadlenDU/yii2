<?php

use yii\db\Migration;

/**
 * Handles the creation of table `name`.
 */
class m170928_233832_create_name_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('name', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'second_name' => $this->string(),
            'patronymic' => $this->string(),
            'full_name' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('name');
    }
}
