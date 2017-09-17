<?php

use yii\db\Migration;

/**
 * Handles the creation of table `public_service`.
 */
class m170917_000655_create_public_service_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('public_service', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('public_service');
    }
}
