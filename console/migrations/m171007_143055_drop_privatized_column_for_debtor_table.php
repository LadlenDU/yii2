<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `privatized_column_for_debtor`.
 */
class m171007_143055_drop_privatized_column_for_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('debtor', 'privatized');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    }
}
