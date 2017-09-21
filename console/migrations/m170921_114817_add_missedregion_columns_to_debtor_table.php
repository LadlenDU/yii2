<?php

use yii\db\Migration;

/**
 * Handles adding missedregion to table `debtor`.
 */
class m170921_114817_add_missedregion_columns_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'region', $this->string()->after('address'));
        $this->addColumn('debtor', 'regionId', $this->string()->after('region'));
        $this->addColumn('debtor', 'district', $this->string()->after('regionId'));
        $this->addColumn('debtor', 'districtId', $this->string()->after('district'));
        $this->addColumn('debtor', 'cityId', $this->string()->after('city'));
        $this->addColumn('debtor', 'streetId', $this->string()->after('street'));
        $this->addColumn('debtor', 'buildingId', $this->string()->after('building'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('debtor', 'region');
        $this->dropColumn('debtor', 'regionId');
        $this->dropColumn('debtor', 'district');
        $this->dropColumn('debtor', 'districtId');
        $this->dropColumn('debtor', 'cityId');
        $this->dropColumn('debtor', 'streetId');
        $this->dropColumn('debtor', 'buildingId');
    }
}
