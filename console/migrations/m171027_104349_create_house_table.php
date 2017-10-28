<?php

use yii\db\Migration;

/**
 * Handles the creation of table `house`.
 * Has foreign keys to the tables:
 *
 * - `location`
 */
class m171027_104349_create_house_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('house', [
            'id' => $this->primaryKey(),
            'location_id' => $this->integer()->comment('Адрес'),
        ]);

        // creates index for column `location_id`
        $this->createIndex(
            'idx-house-location_id',
            'house',
            'location_id'
        );

        // add foreign key for table `location`
        $this->addForeignKey(
            'fk-house-location_id',
            'house',
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
            'fk-house-location_id',
            'house'
        );

        // drops index for column `location_id`
        $this->dropIndex(
            'idx-house-location_id',
            'house'
        );

        $this->dropTable('house');
    }
}
