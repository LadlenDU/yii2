<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_house`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `house`
 */
class m171027_104715_create_junction_table_for_company_and_house_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company_house', [
            'company_id' => $this->integer(),
            'house_id' => $this->integer(),
            'PRIMARY KEY(company_id, house_id)',
        ],
            'COMMENT "Обслуживаемые дома"'
        );

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_house-company_id',
            'company_house',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_house-company_id',
            'company_house',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `house_id`
        $this->createIndex(
            'idx-company_house-house_id',
            'company_house',
            'house_id'
        );

        // add foreign key for table `house`
        $this->addForeignKey(
            'fk-company_house-house_id',
            'company_house',
            'house_id',
            'house',
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
            'fk-company_house-company_id',
            'company_house'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_house-company_id',
            'company_house'
        );

        // drops foreign key for table `house`
        $this->dropForeignKey(
            'fk-company_house-house_id',
            'company_house'
        );

        // drops index for column `house_id`
        $this->dropIndex(
            'idx-company_house-house_id',
            'company_house'
        );

        $this->dropTable('company_house');
    }
}
