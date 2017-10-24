<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_company_files`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `company_files`
 */
class m171024_174500_create_junction_table_for_company_and_company_files_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company_company_files', [
            'company_id' => $this->integer(),
            'company_files_id' => $this->integer(),
            'PRIMARY KEY(company_id, company_files_id)',
        ]);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_company_files-company_id',
            'company_company_files',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_company_files-company_id',
            'company_company_files',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `company_files_id`
        $this->createIndex(
            'idx-company_company_files-company_files_id',
            'company_company_files',
            'company_files_id'
        );

        // add foreign key for table `company_files`
        $this->addForeignKey(
            'fk-company_company_files-company_files_id',
            'company_company_files',
            'company_files_id',
            'company_files',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `company`
        $this->dropForeignKey(
            'fk-company_company_files-company_id',
            'company_company_files'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_company_files-company_id',
            'company_company_files'
        );

        // drops foreign key for table `company_files`
        $this->dropForeignKey(
            'fk-company_company_files-company_files_id',
            'company_company_files'
        );

        // drops index for column `company_files_id`
        $this->dropIndex(
            'idx-company_company_files-company_files_id',
            'company_company_files'
        );

        $this->dropTable('company_company_files');
    }
}
