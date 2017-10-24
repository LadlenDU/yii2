<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_type`.
 */
class m171024_045308_create_company_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('company_type');
    }
}
