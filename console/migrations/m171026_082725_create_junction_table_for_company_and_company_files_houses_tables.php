<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_company_files_houses`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `company_files_houses`
 */
class m171026_082725_create_junction_table_for_company_and_company_files_houses_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company_company_files_houses', [
            'company_id' => $this->integer(),
            'company_files_houses_id' => $this->integer(),
            'PRIMARY KEY(company_id, company_files_houses_id)',
        ]);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_company_files_houses-company_id',
            'company_company_files_houses',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_company_files_houses-company_id',
            'company_company_files_houses',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `company_files_houses_id`
        $this->createIndex(
            'idx-company_company_files_houses-company_files_houses_id',
            'company_company_files_houses',
            'company_files_houses_id'
        );

        // add foreign key for table `company_files_houses`
        $this->addForeignKey(
            'fk-company_company_files_houses-company_files_houses_id',
            'company_company_files_houses',
            'company_files_houses_id',
            'company_files_houses',
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
            'fk-company_company_files_houses-company_id',
            'company_company_files_houses'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_company_files_houses-company_id',
            'company_company_files_houses'
        );

        // drops foreign key for table `company_files_houses`
        $this->dropForeignKey(
            'fk-company_company_files_houses-company_files_houses_id',
            'company_company_files_houses'
        );

        // drops index for column `company_files_houses_id`
        $this->dropIndex(
            'idx-company_company_files_houses-company_files_houses_id',
            'company_company_files_houses'
        );

        $this->dropTable('company_company_files_houses');
    }
}
