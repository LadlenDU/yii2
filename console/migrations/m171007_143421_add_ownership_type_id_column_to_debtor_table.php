<?php

use yii\db\Migration;

/**
 * Handles adding ownership_type_id to table `debtor`.
 * Has foreign keys to the tables:
 *
 * - `ownership_type`
 */
class m171007_143421_add_ownership_type_id_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'ownership_type_id', $this->integer()->after('space_living')->comment('Форма собственности'));

        // creates index for column `ownership_type_id`
        $this->createIndex(
            'idx-debtor-ownership_type_id',
            'debtor',
            'ownership_type_id'
        );

        // add foreign key for table `ownership_type`
        $this->addForeignKey(
            'fk-debtor-ownership_type_id',
            'debtor',
            'ownership_type_id',
            'ownership_type',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `ownership_type`
        $this->dropForeignKey(
            'fk-debtor-ownership_type_id',
            'debtor'
        );

        // drops index for column `ownership_type_id`
        $this->dropIndex(
            'idx-debtor-ownership_type_id',
            'debtor'
        );

        $this->dropColumn('debtor', 'ownership_type_id');
    }
}
