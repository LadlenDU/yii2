<?php

use yii\db\Migration;

/**
 * Handles adding user_id to table `load_monitor_format_1`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m171110_090713_add_user_id_column_to_load_monitor_format_1_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor_load_monitor_format_1', 'user_id', $this->integer()->after('id'));

        // creates index for column `user_id`
        $this->createIndex(
            'idx-debtor_load_monitor_format_1-user_id',
            'debtor_load_monitor_format_1',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-debtor_load_monitor_format_1-user_id',
            'debtor_load_monitor_format_1',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-debtor_load_monitor_format_1-user_id',
            'debtor_load_monitor_format_1'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-debtor_load_monitor_format_1-user_id',
            'debtor_load_monitor_format_1'
        );

        $this->dropColumn('debtor_load_monitor_format_1', 'user_id');
    }
}
