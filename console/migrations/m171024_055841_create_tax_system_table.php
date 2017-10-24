<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tax_system`.
 */
class m171024_055841_create_tax_system_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tax_system', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tax_system');
    }
}
