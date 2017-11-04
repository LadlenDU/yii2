<?php

use yii\db\Migration;

/**
 * Handles the creation of table `debtor_status_files`.
 * Has foreign keys to the tables:
 *
 * - `debtor`
 */
class m171104_191439_create_debtor_status_files_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('debtor_status_files',
            [
                'id' => $this->primaryKey(),
                'debtor_id' => $this->integer()->notNull()->comment('ID должника, которому принадлежит файл'),
                'content' => 'MEDIUMBLOB',  //$this->mediumblob(),
                'name' => $this->string(),
                'mime_type' => $this->string(),
            ],
            'COMMENT "Файлы статуса должника"'
        );

        // creates index for column `debtor_id`
        $this->createIndex(
            'idx-debtor_status_files-debtor_id',
            'debtor_status_files',
            'debtor_id'
        );

        // add foreign key for table `debtor`
        $this->addForeignKey(
            'fk-debtor_status_files-debtor_id',
            'debtor_status_files',
            'debtor_id',
            'debtor',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `debtor`
        $this->dropForeignKey(
            'fk-debtor_status_files-debtor_id',
            'debtor_status_files'
        );

        // drops index for column `debtor_id`
        $this->dropIndex(
            'idx-debtor_status_files-debtor_id',
            'debtor_status_files'
        );

        $this->dropTable('debtor_status_files');
    }
}
