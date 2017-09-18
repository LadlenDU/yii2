<?php

use yii\db\Migration;

/**
 * Handles adding amount_additional_services to table `debt_details`.
 */
class m170918_125158_add_amount_additional_services_column_to_debt_details_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debt_details', 'amount_additional_services', $this->decimal(8,2)->after('amount'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debt_details', 'amount_additional_services');
    }
}
