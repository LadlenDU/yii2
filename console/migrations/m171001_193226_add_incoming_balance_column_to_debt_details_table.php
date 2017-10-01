<?php

use yii\db\Migration;

/**
 * Handles adding incoming_balance to table `debt_details`.
 */
class m171001_193226_add_incoming_balance_column_to_debt_details_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debt_details', 'incoming_balance_debit', $this->decimal(8,2)->null()->comment('Входящее сальдо (дебет)'));
        $this->addColumn('debt_details', 'incoming_balance_credit', $this->decimal(8,2)->null()->comment('Входящее сальдо (кредит)'));
        $this->addColumn('debt_details', 'charges_permanent', $this->decimal(8,2)->null()->comment('Начисления постоянные'));
        $this->addColumn('debt_details', 'accrued_subsidies', $this->decimal(8,2)->null()->comment('Начисленные субсидии'));
        $this->addColumn('debt_details', 'one_time_charges', $this->decimal(8,2)->null()->comment('Начисления разовые'));
        $this->addColumn('debt_details', 'paid', $this->decimal(8,2)->null()->comment('Оплачено'));
        $this->addColumn('debt_details', 'paid_insurance', $this->decimal(8,2)->null()->comment('Оплачено страховки'));
        $this->addColumn('debt_details', 'grants_paid', $this->decimal(8,2)->null()->comment('Оплачено субсидий'));
        $this->addColumn('debt_details', 'outgoing_balance_debit', $this->decimal(8,2)->null()->comment('Исходящее сальдо (дебет)'));
        $this->addColumn('debt_details', 'outgoing_balance_credit', $this->decimal(8,2)->null()->comment('Исходящее сальдо (кредит)'));
        $this->addColumn('debt_details', 'overdue_debts', $this->decimal(8,2)->null()->comment('Просроченная задолженность'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debt_details', 'incoming_balance_debit');
        $this->dropColumn('debt_details', 'incoming_balance_credit');
        $this->dropColumn('debt_details', 'charges_permanent');
        $this->dropColumn('debt_details', 'accrued_subsidies');
        $this->dropColumn('debt_details', 'one_time_charges');
        $this->dropColumn('debt_details', 'paid');
        $this->dropColumn('debt_details', 'paid_insurance');
        $this->dropColumn('debt_details', 'grants_paid');
        $this->dropColumn('debt_details', 'outgoing_balance_debit');
        $this->dropColumn('debt_details', 'outgoing_balance_credit');
        $this->dropColumn('debt_details', 'overdue_debts');
    }
}
