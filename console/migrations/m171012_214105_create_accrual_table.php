<?php

use yii\db\Migration;

/**
 * Handles the creation of table `accrual`.
 * Has foreign keys to the tables:
 *
 * - `debtor`
 */
class m171012_214105_create_accrual_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('accrual', [
            'id' => $this->primaryKey(),
            'debtor_id' => $this->integer(),
            'accrual_date' => $this->datetime()->comment('Дата начисления'),
            'accrual' => $this->decimal(8,2)->comment('Начислено'),
            'single' => $this->decimal(8,2)->comment('Разовые'),
            'additional_adjustment' => $this->decimal(8,2)->comment('Доп. корректировка'),
            'subsidies' => $this->decimal(8,2)->comment('Субсидии'),
        ]);

        $this->addCommentOnTable('accrual', 'Начисления');

        // creates index for column `debtor_id`
        $this->createIndex(
            'idx-accrual-debtor_id',
            'accrual',
            'debtor_id'
        );

        // add foreign key for table `debtor`
        $this->addForeignKey(
            'fk-accrual-debtor_id',
            'accrual',
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
            'fk-accrual-debtor_id',
            'accrual'
        );

        // drops index for column `debtor_id`
        $this->dropIndex(
            'idx-accrual-debtor_id',
            'accrual'
        );

        $this->dropTable('accrual');
    }
}
