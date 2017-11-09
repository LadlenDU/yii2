<?php

use yii\db\Migration;

/**
 * Handles adding debt_fine_cost_of_claim_state_fee to table `debtor`.
 */
class m171108_175304_add_debt_fine_cost_of_claim_state_fee_columns_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'debt', $this->decimal(8,2)->comment('Задолженность'));
        $this->addColumn('debtor', 'fine', $this->decimal(8,2)->comment('Пеня'));
        $this->addColumn('debtor', 'cost_of_claim', $this->decimal(8,2)->comment('Цена иска (задолженность + пеня)'));
        $this->addColumn('debtor', 'state_fee', $this->decimal(8,2)->comment('Пошлина'));

        $this->createIndex(
            'idx-debtor-cost_of_claim',
            'debtor',
            'cost_of_claim'
        );

        $this->createIndex(
            'idx-debtor-debt',
            'debtor',
            'debt'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-debtor-debt',
            'debt'
        );

        $this->dropIndex(
            'idx-debtor-cost_of_claim',
            'debtor'
        );

        $this->dropColumn('debtor', 'debt');
        $this->dropColumn('debtor', 'fine');
        $this->dropColumn('debtor', 'cost_of_claim');
        $this->dropColumn('debtor', 'state_fee');
    }
}
