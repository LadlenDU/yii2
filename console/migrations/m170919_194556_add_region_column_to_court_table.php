<?php

use yii\db\Migration;

/**
 * Handles adding region to table `court`.
 */
class m170919_194556_add_region_column_to_court_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('court', 'region', $this->string()->comment('регион (область)')->after('address'));
        $this->addColumn('court', 'regionId', $this->string()->comment('код региона (области)')->after('region'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('court', 'region');
        $this->dropColumn('court', 'regionId');
    }
}
