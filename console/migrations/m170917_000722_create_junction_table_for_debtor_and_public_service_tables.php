<?php

use yii\db\Migration;

/**
 * Handles the creation of table `debtor_public_service`.
 * Has foreign keys to the tables:
 *
 * - `debtor`
 * - `public_service`
 */
class m170917_000722_create_junction_table_for_debtor_and_public_service_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('debtor_public_service', [
            'debtor_id' => $this->integer(),
            'public_service_id' => $this->integer(),
            'PRIMARY KEY(debtor_id, public_service_id)',
        ]);

        // creates index for column `debtor_id`
        $this->createIndex(
            'idx-debtor_public_service-debtor_id',
            'debtor_public_service',
            'debtor_id'
        );

        // add foreign key for table `debtor`
        $this->addForeignKey(
            'fk-debtor_public_service-debtor_id',
            'debtor_public_service',
            'debtor_id',
            'debtor',
            'id',
            'CASCADE'
        );

        // creates index for column `public_service_id`
        $this->createIndex(
            'idx-debtor_public_service-public_service_id',
            'debtor_public_service',
            'public_service_id'
        );

        // add foreign key for table `public_service`
        $this->addForeignKey(
            'fk-debtor_public_service-public_service_id',
            'debtor_public_service',
            'public_service_id',
            'public_service',
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
            'fk-debtor_public_service-debtor_id',
            'debtor_public_service'
        );

        // drops index for column `debtor_id`
        $this->dropIndex(
            'idx-debtor_public_service-debtor_id',
            'debtor_public_service'
        );

        // drops foreign key for table `public_service`
        $this->dropForeignKey(
            'fk-debtor_public_service-public_service_id',
            'debtor_public_service'
        );

        // drops index for column `public_service_id`
        $this->dropIndex(
            'idx-debtor_public_service-public_service_id',
            'debtor_public_service'
        );

        $this->dropTable('debtor_public_service');
    }
}
