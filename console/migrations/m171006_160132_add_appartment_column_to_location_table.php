<?php

use yii\db\Migration;

/**
 * Handles adding appartment to table `location`.
 */
class m171006_160132_add_appartment_column_to_location_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('location', 'appartment', $this->string()->after('buildingId')->comment('Квартира'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('location', 'appartment');
    }
}
