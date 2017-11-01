<?php

use yii\db\Migration;

/**
 * Handles the creation of table `debtor_cohabitant`.
 * Has foreign keys to the tables:
 *
 * - `debtor`
 * - `name`
 */
class m171101_202447_create_debtor_cohabitant_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('debtor_cohabitant', [
            'id' => $this->primaryKey(),
            'debtor_id' => $this->integer()->comment('Должник'),
            'name_id' => $this->integer()->unique()->comment('ФИО'),
        ],
            'COMMENT "Прописанные вместе с должником"'
        );

        // creates index for column `debtor_id`
        $this->createIndex(
            'idx-debtor_cohabitant-debtor_id',
            'debtor_cohabitant',
            'debtor_id'
        );

        // add foreign key for table `debtor`
        $this->addForeignKey(
            'fk-debtor_cohabitant-debtor_id',
            'debtor_cohabitant',
            'debtor_id',
            'debtor',
            'id',
            'CASCADE'
        );

        // creates index for column `name_id`
        $this->createIndex(
            'idx-debtor_cohabitant-name_id',
            'debtor_cohabitant',
            'name_id'
        );

        // add foreign key for table `name`
        $this->addForeignKey(
            'fk-debtor_cohabitant-name_id',
            'debtor_cohabitant',
            'name_id',
            'name',
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
            'fk-debtor_cohabitant-debtor_id',
            'debtor_cohabitant'
        );

        // drops index for column `debtor_id`
        $this->dropIndex(
            'idx-debtor_cohabitant-debtor_id',
            'debtor_cohabitant'
        );

        // drops foreign key for table `name`
        $this->dropForeignKey(
            'fk-debtor_cohabitant-name_id',
            'debtor_cohabitant'
        );

        // drops index for column `name_id`
        $this->dropIndex(
            'idx-debtor_cohabitant-name_id',
            'debtor_cohabitant'
        );

        $this->dropTable('debtor_cohabitant');
    }
}
