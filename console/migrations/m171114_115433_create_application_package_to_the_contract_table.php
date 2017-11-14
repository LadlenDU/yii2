<?php

use yii\db\Migration;

/**
 * Handles the creation of table `application_package_to_the_contract`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m171114_115433_create_application_package_to_the_contract_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('application_package_to_the_contract', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'number' => $this->integer()->unsigned()->notNull()->comment('Номер по порядку'),
            'name' => $this->string()->notNull()->comment('Название пакета приложений'),
        ],
            'COMMENT "Пакет приложений к договору оказания юридических услуг"'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-application_package_to_the_contract-user_id',
            'application_package_to_the_contract',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-application_package_to_the_contract-user_id',
            'application_package_to_the_contract',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-application_package_to_the_contract-user_id',
            'application_package_to_the_contract'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-application_package_to_the_contract-user_id',
            'application_package_to_the_contract'
        );

        $this->dropTable('application_package_to_the_contract');
    }
}
