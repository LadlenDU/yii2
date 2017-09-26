<?php

use yii\db\Migration;

/**
 * Handles adding location_id to table `user_info`.
 * Has foreign keys to the tables:
 *
 * - `location`
 */
class m170925_134617_add_location_id_column_to_user_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_info', 'location_id', $this->integer());

        // creates index for column `location_id`
        $this->createIndex(
            'idx-user_info-location_id',
            'user_info',
            'location_id'
        );

        // add foreign key for table `location`
        $this->addForeignKey(
            'fk-user_info-location_id',
            'user_info',
            'location_id',
            'location',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `location`
        $this->dropForeignKey(
            'fk-user_info-location_id',
            'user_info'
        );

        // drops index for column `location_id`
        $this->dropIndex(
            'idx-user_info-location_id',
            'user_info'
        );

        $this->dropColumn('user_info', 'location_id');
    }
}
