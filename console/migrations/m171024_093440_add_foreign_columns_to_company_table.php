<?php

use yii\db\Migration;

/**
 * Handles adding foreign to table `company`.
 * Has foreign keys to the tables:
 *
 * - `company_type`
 * - `OKOPF`
 * - `tax_system`
 */
class m171024_093440_add_foreign_columns_to_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('company', 'company_type_id', $this->integer()->notNull()->defaultValue(13)->comment('Тип организации'));
        $this->addColumn('company', 'OKOPF_id', $this->integer()->comment('ОКОПФ'));
        $this->addColumn('company', 'tax_system_id', $this->integer()->notNull()->defaultValue(1)->comment('Система налогообложения'));

        // creates index for column `company_type_id`
        $this->createIndex(
            'idx-company-company_type_id',
            'company',
            'company_type_id'
        );

        // add foreign key for table `company_type`
        $this->addForeignKey(
            'fk-company-company_type_id',
            'company',
            'company_type_id',
            'company_type',
            'id',
            'CASCADE'
        );

        // creates index for column `OKOPF_id`
        $this->createIndex(
            'idx-company-OKOPF_id',
            'company',
            'OKOPF_id'
        );

        // add foreign key for table `OKOPF`
        $this->addForeignKey(
            'fk-company-OKOPF_id',
            'company',
            'OKOPF_id',
            'OKOPF',
            'id',
            'CASCADE'
        );

        // creates index for column `tax_system_id`
        $this->createIndex(
            'idx-company-tax_system_id',
            'company',
            'tax_system_id'
        );

        // add foreign key for table `tax_system`
        $this->addForeignKey(
            'fk-company-tax_system_id',
            'company',
            'tax_system_id',
            'tax_system',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `company_type`
        $this->dropForeignKey(
            'fk-company-company_type_id',
            'company'
        );

        // drops index for column `company_type_id`
        $this->dropIndex(
            'idx-company-company_type_id',
            'company'
        );

        // drops foreign key for table `OKOPF`
        $this->dropForeignKey(
            'fk-company-OKOPF_id',
            'company'
        );

        // drops index for column `OKOPF_id`
        $this->dropIndex(
            'idx-company-OKOPF_id',
            'company'
        );

        // drops foreign key for table `tax_system`
        $this->dropForeignKey(
            'fk-company-tax_system_id',
            'company'
        );

        // drops index for column `tax_system_id`
        $this->dropIndex(
            'idx-company-tax_system_id',
            'company'
        );

        $this->dropColumn('company', 'company_type_id');
        $this->dropColumn('company', 'OKOPF_id');
        $this->dropColumn('company', 'tax_system_id');
    }
}
