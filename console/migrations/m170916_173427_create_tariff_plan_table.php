<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tariff_plan`.
 */
class m170916_173427_create_tariff_plan_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tariff_plan', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tariff_plan');
    }
}
