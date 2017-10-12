<?php

use yii\db\Migration;

/**
 * Handles adding some to table `debt_details`.
 */
class m171012_161400_add_some_columns_to_debt_details_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debt_details', 'сharged', $this->decimal(8,2)->comment('Начислено'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debt_details', 'сharged');
    }
}
