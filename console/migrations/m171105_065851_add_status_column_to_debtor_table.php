<?php

use yii\db\Migration;

/**
 * Handles adding status to table `debtor`.
 * Has foreign keys to the tables:
 *
 * - `debtor_status`
 */
class m171105_065851_add_status_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'status_id', $this->integer()->comment('ID cтатуса'));

        // creates index for column `status_id`
        $this->createIndex(
            'idx-debtor-status_id',
            'debtor',
            'status_id'
        );

        // add foreign key for table `debtor_status`
        $this->addForeignKey(
            'fk-debtor-status_id',
            'debtor',
            'status_id',
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
            'fk-debtor-status_id',
            'debtor'
        );

        // drops index for column `status_id`
        $this->dropIndex(
            'idx-debtor-status_id',
            'debtor'
        );

        $this->dropColumn('debtor', 'status_id');
    }
}
