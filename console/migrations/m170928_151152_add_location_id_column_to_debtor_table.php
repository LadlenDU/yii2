<?php

use yii\db\Migration;

/**
 * Handles adding location_id to table `debtor`.
 * Has foreign keys to the tables:
 *
 * - `location`
 */
class m170928_151152_add_location_id_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'location_id', $this->integer());

        // creates index for column `location_id`
        $this->createIndex(
            'idx-debtor-location_id',
            'debtor',
            'location_id'
        );

        // add foreign key for table `location`
        $this->addForeignKey(
            'fk-debtor-location_id',
            'debtor',
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
            'fk-debtor-location_id',
            'debtor'
        );

        // drops index for column `location_id`
        $this->dropIndex(
            'idx-debtor-location_id',
            'debtor'
        );

        $this->dropColumn('debtor', 'location_id');
    }
}
