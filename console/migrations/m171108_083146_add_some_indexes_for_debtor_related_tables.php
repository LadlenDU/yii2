<?php

use yii\db\Migration;

class m171108_083146_add_some_indexes_for_debtor_related_tables extends Migration
{
    public function safeUp()
    {
        $this->createIndex(
            'idx-accrual-accrual_date',
            'accrual',
            'accrual_date'
        );
        $this->createIndex(
            'idx-payment-payment_date',
            'payment',
            'payment_date'
        );
        $this->createIndex(
            'idx-debtor-LS_IKU_provider',
            'debtor',
            'LS_IKU_provider'
        );
    }

    public function safeDown()
    {
        echo "m171108_083146_add_some_indexes_for_debtor_related_tables cannot be reverted.\n";

        $this->dropIndex(
            'idx-debtor-LS_IKU_provider',
            'debtor'
        );
        $this->dropIndex(
            'idx-payment-payment_date',
            'payment'
        );
        $this->dropIndex(
            'idx-accrual-accrual_date',
            'accrual'
        );

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171108_083146_add_some_indexes_for_debtor_related_tables cannot be reverted.\n";

        return false;
    }
    */
}
