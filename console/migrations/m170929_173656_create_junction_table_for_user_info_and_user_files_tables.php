<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_info_user_files`.
 * Has foreign keys to the tables:
 *
 * - `user_info`
 * - `user_files`
 */
class m170929_173656_create_junction_table_for_user_info_and_user_files_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_info_user_files', [
            'user_info_id' => $this->integer(),
            'user_files_id' => $this->integer(),
            'PRIMARY KEY(user_info_id, user_files_id)',
        ]);

        // creates index for column `user_info_id`
        $this->createIndex(
            'idx-user_info_user_files-user_info_id',
            'user_info_user_files',
            'user_info_id'
        );

        // add foreign key for table `user_info`
        $this->addForeignKey(
            'fk-user_info_user_files-user_info_id',
            'user_info_user_files',
            'user_info_id',
            'user_info',
            'id',
            'CASCADE'
        );

        // creates index for column `user_files_id`
        $this->createIndex(
            'idx-user_info_user_files-user_files_id',
            'user_info_user_files',
            'user_files_id'
        );

        // add foreign key for table `user_files`
        $this->addForeignKey(
            'fk-user_info_user_files-user_files_id',
            'user_info_user_files',
            'user_files_id',
            'user_files',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user_info`
        $this->dropForeignKey(
            'fk-user_info_user_files-user_info_id',
            'user_info_user_files'
        );

        // drops index for column `user_info_id`
        $this->dropIndex(
            'idx-user_info_user_files-user_info_id',
            'user_info_user_files'
        );

        // drops foreign key for table `user_files`
        $this->dropForeignKey(
            'fk-user_info_user_files-user_files_id',
            'user_info_user_files'
        );

        // drops index for column `user_files_id`
        $this->dropIndex(
            'idx-user_info_user_files-user_files_id',
            'user_info_user_files'
        );

        $this->dropTable('user_info_user_files');
    }
}
