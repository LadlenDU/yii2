<?php

use yii\db\Migration;

/**
 * Handles adding name_id to table `debtor`.
 * Has foreign keys to the tables:
 *
 * - `name`
 */
class m171006_104036_add_name_id_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'name_id', $this->integer());

        // creates index for column `name_id`
        $this->createIndex(
            'idx-debtor-name_id',
            'debtor',
            'name_id'
        );

        // add foreign key for table `name`
        $this->addForeignKey(
            'fk-debtor-name_id',
            'debtor',
            'name_id',
            'name',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `name`
        $this->dropForeignKey(
            'fk-debtor-name_id',
            'debtor'
        );

        // drops index for column `name_id`
        $this->dropIndex(
            'idx-debtor-name_id',
            'debtor'
        );

        $this->dropColumn('debtor', 'name_id');
    }
}
