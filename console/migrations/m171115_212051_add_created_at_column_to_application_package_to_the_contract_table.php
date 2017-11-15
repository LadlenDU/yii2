<?php

use yii\db\Migration;

/**
 * Handles adding created_at to table `application_package_to_the_contract`.
 */
class m171115_212051_add_created_at_column_to_application_package_to_the_contract_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('application_package_to_the_contract', 'created_at', $this->datetime()->comment('Время создания'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('application_package_to_the_contract', 'created_at');
    }
}
