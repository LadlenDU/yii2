<?php

use yii\db\Migration;

/**
 * Handles the creation of table `debt_details`.
 * Has foreign keys to the tables:
 *
 * - `debtor`
 * - `public_service`
 */
class m170917_000706_create_debt_details_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('debt_details', [
            'id' => $this->primaryKey(),
            'debtor_id' => $this->integer(),
            'amount' => $this->decimal(8,2),
            'date' => $this->datetime(),
            'payment_date' => $this->timestamp(),
            'public_service_id' => $this->integer(),
        ]);

        // creates index for column `debtor_id`
        $this->createIndex(
            'idx-debt_details-debtor_id',
            'debt_details',
            'debtor_id'
        );

        // add foreign key for table `debtor`
        $this->addForeignKey(
            'fk-debt_details-debtor_id',
            'debt_details',
            'debtor_id',
            'debtor',
            'id',
            'CASCADE'
        );

        // creates index for column `public_service_id`
        $this->createIndex(
            'idx-debt_details-public_service_id',
            'debt_details',
            'public_service_id'
        );

        // add foreign key for table `public_service`
        $this->addForeignKey(
            'fk-debt_details-public_service_id',
            'debt_details',
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
            'fk-debt_details-debtor_id',
            'debt_details'
        );

        // drops index for column `debtor_id`
        $this->dropIndex(
            'idx-debt_details-debtor_id',
            'debt_details'
        );

        // drops foreign key for table `public_service`
        $this->dropForeignKey(
            'fk-debt_details-public_service_id',
            'debt_details'
        );

        // drops index for column `public_service_id`
        $this->dropIndex(
            'idx-debt_details-public_service_id',
            'debt_details'
        );

        $this->dropTable('debt_details');
    }
}
