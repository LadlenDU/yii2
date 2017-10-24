<?php

use yii\db\Migration;

/**
 * Handles the creation of table `OKOPF`.
 */
class m171024_045410_create_OKOPF_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('OKOPF', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->unique(),
            'name' => $this->string()->unique()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('OKOPF');
    }
}
