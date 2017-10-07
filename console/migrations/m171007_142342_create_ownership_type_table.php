<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ownership_type`.
 */
class m171007_142342_create_ownership_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ownership_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(40),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ownership_type');
    }
}
