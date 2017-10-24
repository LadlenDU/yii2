<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_files`.
 */
class m171024_174449_create_company_files_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company_files', [
            'id' => $this->primaryKey(),
            //'content' => $this->mediumblob(),
            'content' => 'MEDIUMBLOB',
            'name' => $this->string(),
            'mime_type' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('company_files');
    }
}
