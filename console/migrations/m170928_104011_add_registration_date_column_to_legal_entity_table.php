<?php

use yii\db\Migration;

/**
 * Handles adding registration_date to table `legal_entity`.
 */
class m170928_104011_add_registration_date_column_to_legal_entity_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('legal_entity', 'registration_date', $this->datetime());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('legal_entity', 'registration_date');
    }
}
