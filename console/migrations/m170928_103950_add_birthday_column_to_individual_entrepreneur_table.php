<?php

use yii\db\Migration;

/**
 * Handles adding birthday to table `individual_entrepreneur`.
 */
class m170928_103950_add_birthday_column_to_individual_entrepreneur_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('individual_entrepreneur', 'birthday', $this->datetime());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('individual_entrepreneur', 'birthday');
    }
}
