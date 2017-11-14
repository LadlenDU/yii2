<?php

use yii\db\Migration;

/**
 * Handles the creation of table `application_package_to_the_contract_debtor`.
 * Has foreign keys to the tables:
 *
 * - `application_package_to_the_contract`
 * - `debtor`
 */
class m171114_115510_create_junction_table_for_application_package_to_the_contract_and_debtor_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('application_package_to_the_contract_debtor', [
            'application_package_to_the_contract_id' => $this->integer(),
            'debtor_id' => $this->integer(),
            'PRIMARY KEY(application_package_to_the_contract_id, debtor_id)',
        ]);

        // creates index for column `application_package_to_the_contract_id`
        $this->createIndex(
            'idx-app_pack_contract_debtor-appl_pack_to_the_contract_id',
            'application_package_to_the_contract_debtor',
            'application_package_to_the_contract_id'
        );

        // add foreign key for table `application_package_to_the_contract`
        $this->addForeignKey(
            'fk-appl_pack_contract_debtor-appl_pack_to_the_contract_id',
            'application_package_to_the_contract_debtor',
            'application_package_to_the_contract_id',
            'application_package_to_the_contract',
            'id',
            'CASCADE'
        );

        // creates index for column `debtor_id`
        $this->createIndex(
            'idx-application_package_to_the_contract_debtor-debtor_id',
            'application_package_to_the_contract_debtor',
            'debtor_id'
        );

        // add foreign key for table `debtor`
        $this->addForeignKey(
            'fk-application_package_to_the_contract_debtor-debtor_id',
            'application_package_to_the_contract_debtor',
            'debtor_id',
            'debtor',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops foreign key for table `application_package_to_the_contract`
        $this->dropForeignKey(
            'fk-appl_pack_contract_debtor-appl_pack_to_the_contract_id',
            'application_package_to_the_contract_debtor'
        );

        // drops index for column `application_package_to_the_contract_id`
        $this->dropIndex(
            'idx-app_pack_contract_debtor-appl_pack_to_the_contract_id',
            'application_package_to_the_contract_debtor'
        );

        // drops foreign key for table `debtor`
        $this->dropForeignKey(
            'fk-application_package_to_the_contract_debtor-debtor_id',
            'application_package_to_the_contract_debtor'
        );

        // drops index for column `debtor_id`
        $this->dropIndex(
            'idx-application_package_to_the_contract_debtor-debtor_id',
            'application_package_to_the_contract_debtor'
        );

        $this->dropTable('application_package_to_the_contract_debtor');
    }
}
