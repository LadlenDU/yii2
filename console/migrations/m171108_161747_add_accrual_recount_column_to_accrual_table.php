<?php

use yii\db\Migration;

/**
 * Handles adding accrual_recount to table `accrual`.
 */
class m171108_161747_add_accrual_recount_column_to_accrual_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('accrual', 'accrual_recount', $this->decimal(8,2)->comment('Конечная перерасчитанная задолженность (с учетом пени, корректировок и пр.)'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('accrual', 'accrual_recount');
    }
}
