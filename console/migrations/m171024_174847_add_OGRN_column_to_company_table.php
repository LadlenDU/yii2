<?php

use yii\db\Migration;

/**
 * Handles adding OGRN to table `company`.
 */
class m171024_174847_add_OGRN_column_to_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('company', 'OGRN', $this->string()->comment('ОГРН')->after('BIK'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('company', 'OGRN');
    }
}
