<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `location_and_name_fields_from_debtor`.
 */
class m171006_104337_drop_location_and_name_fields_from_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('debtor', 'first_name');
        $this->dropColumn('debtor', 'second_name');
        $this->dropColumn('debtor', 'patronymic');
        $this->dropColumn('debtor', 'name_mixed');
        $this->dropColumn('debtor', 'address');
        $this->dropColumn('debtor', 'region');
        $this->dropColumn('debtor', 'regionId');
        $this->dropColumn('debtor', 'district');
        $this->dropColumn('debtor', 'districtId');
        $this->dropColumn('debtor', 'city');
        $this->dropColumn('debtor', 'cityId');
        $this->dropColumn('debtor', 'street');
        $this->dropColumn('debtor', 'streetId');
        $this->dropColumn('debtor', 'building');
        $this->dropColumn('debtor', 'buildingId');
        $this->dropColumn('debtor', 'appartment');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

    }
}
