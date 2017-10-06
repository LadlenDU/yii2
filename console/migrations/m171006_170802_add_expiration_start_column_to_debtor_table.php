<?php

use yii\db\Migration;

/**
 * Handles adding expiration_start to table `debtor`.
 */
class m171006_170802_add_expiration_start_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'expiration_start', $this->datetime()->comment('Начало просрочки'));
        $this->addColumn('debtor', 'debt_total', $this->decimal()->comment('Сумма долга'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debtor', 'expiration_start');
        $this->dropColumn('debtor', 'debt_total');
    }
}
