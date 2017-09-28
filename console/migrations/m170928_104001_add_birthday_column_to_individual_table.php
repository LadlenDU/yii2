<?php

use yii\db\Migration;

/**
 * Handles adding birthday to table `individual`.
 */
class m170928_104001_add_birthday_column_to_individual_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('individual', 'birthday', $this->datetime());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('individual', 'birthday');
    }
}
