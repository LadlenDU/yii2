<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_info_company`.
 * Has foreign keys to the tables:
 *
 * - `user_info`
 * - `company`
 */
class m170929_142909_create_junction_table_for_user_info_and_company_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_info_company', [
            'user_info_id' => $this->integer(),
            'company_id' => $this->integer(),
            'PRIMARY KEY(user_info_id, company_id)',
        ]);

        // creates index for column `user_info_id`
        $this->createIndex(
            'idx-user_info_company-user_info_id',
            'user_info_company',
            'user_info_id'
        );

        // add foreign key for table `user_info`
        $this->addForeignKey(
            'fk-user_info_company-user_info_id',
            'user_info_company',
            'user_info_id',
            'user_info',
            'id',
            'CASCADE'
        );

        // creates index for column `company_id`
        $this->createIndex(
            'idx-user_info_company-company_id',
            'user_info_company',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-user_info_company-company_id',
            'user_info_company',
            'company_id',
            'company',
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
            'fk-user_info_company-user_info_id',
            'user_info_company'
        );

        // drops index for column `user_info_id`
        $this->dropIndex(
            'idx-user_info_company-user_info_id',
            'user_info_company'
        );

        // drops foreign key for table `company`
        $this->dropForeignKey(
            'fk-user_info_company-company_id',
            'user_info_company'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-user_info_company-company_id',
            'user_info_company'
        );

        $this->dropTable('user_info_company');
    }
}
