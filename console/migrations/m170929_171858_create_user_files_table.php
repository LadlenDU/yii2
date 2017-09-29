<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_files`.
 */
class m170929_171858_create_user_files_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_files', [
            'id' => $this->primaryKey(),
            //'content' => $this->binary(8388608 * 1024),
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
        $this->dropTable('user_files');
    }
}
