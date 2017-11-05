<?php

use yii\db\Migration;

/**
 * Handles the creation of table `debtor_status_files`.
 * Has foreign keys to the tables:
 *
 * - `debtor_status`
 */
class m171105_065839_create_debtor_status_files_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('debtor_status_files',
            [
                'id' => $this->primaryKey(),
                'debtor_status_id' => $this->integer()->notNull()->comment('ID статуса должника, которому принадлежит файл'),
                'content' => 'MEDIUMBLOB',    //$this->mediumblob(),
                'name' => $this->string(),
                'mime_type' => $this->string(),
            ],
            'COMMENT "Файлы статуса должника"'
        );

        // creates index for column `debtor_status_id`
        $this->createIndex(
            'idx-debtor_status_files-debtor_status_id',
            'debtor_status_files',
            'debtor_status_id'
        );

        // add foreign key for table `debtor_status`
        $this->addForeignKey(
            'fk-debtor_status_files-debtor_status_id',
            'debtor_status_files',
            'debtor_status_id',
            'debtor_status',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `debtor_status`
        $this->dropForeignKey(
            'fk-debtor_status_files-debtor_status_id',
            'debtor_status_files'
        );

        // drops index for column `debtor_status_id`
        $this->dropIndex(
            'idx-debtor_status_files-debtor_status_id',
            'debtor_status_files'
        );

        $this->dropTable('debtor_status_files');
    }
}
