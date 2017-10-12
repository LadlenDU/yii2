<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 * Has foreign keys to the tables:
 *
 * - `debtor`
 */
class m171012_214620_create_payment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'debtor_id' => $this->integer(),
            'payment_date' => $this->datetime()->comment('Дата оплаты'),
            'amount' => $this->decimal(8,2)->comment('Сумма оплаты'),
        ]);

        $this->addCommentOnTable('payment', 'Оплата');

        // creates index for column `debtor_id`
        $this->createIndex(
            'idx-payment-debtor_id',
            'payment',
            'debtor_id'
        );

        // add foreign key for table `debtor`
        $this->addForeignKey(
            'fk-payment-debtor_id',
            'payment',
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
            'fk-payment-debtor_id',
            'payment'
        );

        // drops index for column `debtor_id`
        $this->dropIndex(
            'idx-payment-debtor_id',
            'payment'
        );

        $this->dropTable('payment');
    }
}
