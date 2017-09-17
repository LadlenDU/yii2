<?php

use yii\db\Migration;

/**
 * Handles the creation of table `debtor`.
 * Has foreign keys to the tables:
 *
 * - `general_manager`
 */
class m170917_000644_create_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('debtor', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'second_name' => $this->string(),
            'patronymic' => $this->string(),
            'address' => $this->string(),
            'space_common' => $this->float(),
            'space_living' => $this->float(),
            'privatized' => $this->smallInteger()->defaultValue(null),
            'general_manager_id' => $this->integer(),
        ]);

        // creates index for column `general_manager_id`
        $this->createIndex(
            'idx-debtor-general_manager_id',
            'debtor',
            'general_manager_id'
        );

        // add foreign key for table `general_manager`
        $this->addForeignKey(
            'fk-debtor-general_manager_id',
            'debtor',
            'general_manager_id',
            'general_manager',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `general_manager`
        $this->dropForeignKey(
            'fk-debtor-general_manager_id',
            'debtor'
        );

        // drops index for column `general_manager_id`
        $this->dropIndex(
            'idx-debtor-general_manager_id',
            'debtor'
        );

        $this->dropTable('debtor');
    }
}
