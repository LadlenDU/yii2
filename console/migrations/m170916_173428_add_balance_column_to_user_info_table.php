<?php

use yii\db\Migration;

/**
 * Handles adding balance to table `user_info`.
 * Has foreign keys to the tables:
 *
 * - `tariff_plan`
 */
class m170916_173428_add_balance_column_to_user_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_info', 'balance', $this->decimal(8,2)->default(0));
        $this->addColumn('user_info', 'tariff_plan_id', $this->integer()->null());

        // creates index for column `tariff_plan_id`
        $this->createIndex(
            'idx-user_info-tariff_plan_id',
            'user_info',
            'tariff_plan_id'
        );

        // add foreign key for table `tariff_plan`
        $this->addForeignKey(
            'fk-user_info-tariff_plan_id',
            'user_info',
            'tariff_plan_id',
            'tariff_plan',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `tariff_plan`
        $this->dropForeignKey(
            'fk-user_info-tariff_plan_id',
            'user_info'
        );

        // drops index for column `tariff_plan_id`
        $this->dropIndex(
            'idx-user_info-tariff_plan_id',
            'user_info'
        );

        $this->dropColumn('user_info', 'balance');
        $this->dropColumn('user_info', 'tariff_plan_id');
    }
}
