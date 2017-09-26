<?php

use yii\db\Migration;

/**
 * Handles the creation of table `location`.
 */
class m170925_125255_create_location_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('location', [
            'id' => $this->primaryKey(),
            'region' => $this->string()->comment('регион (область)'),
            'regionId' => $this->string()->comment('код региона (области)'),
            'district' => $this->string()->comment('район'),
            'districtId' => $this->string()->comment('код района'),
            'city' => $this->string()->comment('город (населённый пункт)'),
            'cityId' => $this->string()->comment('код города (населённого пункта)'),
            'street' => $this->string()->comment('улица'),
            'streetId' => $this->string()->comment('код улицы'),
            'building' => $this->string()->comment('дом (строение)'),
            'buildingId' => $this->string()->comment('код дома (строения)'),
            'zip_code' => $this->string()->comment('почтовый индекс'),
            'arbitraty' => $this->string()->comment('произвольная строка адреса (если не дано разделение по элементам)'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('location');
    }
}
