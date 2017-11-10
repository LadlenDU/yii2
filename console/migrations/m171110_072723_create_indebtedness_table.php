<?php

use yii\db\Migration;

/**
 * Handles the creation of table `indebtedness`.
 * Has foreign keys to the tables:
 *
 * - `debtor`
 */
class m171110_072723_create_indebtedness_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('indebtedness', [
            'id' => $this->primaryKey(),
            'debtor_id' => $this->integer(),
            'date' => $this->datetime()->comment('Дата задолженности'),
            'amount' => $this->decimal(8, 2)->comment('Сумма задолженности'),
        ],
            'COMMENT "Данные о задолженности (accruals - начисления, не задолженность)"'
        );

        // creates index for column `debtor_id`
        $this->createIndex(
            'idx-indebtedness-debtor_id',
            'indebtedness',
            'debtor_id'
        );

        // add foreign key for table `debtor`
        $this->addForeignKey(
            'fk-indebtedness-debtor_id',
            'indebtedness',
            'debtor_id',
            'debtor',
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
            'fk-indebtedness-debtor_id',
            'indebtedness'
        );

        // drops index for column `debtor_id`
        $this->dropIndex(
            'idx-indebtedness-debtor_id',
            'indebtedness'
        );

        $this->dropTable('indebtedness');
    }
}
