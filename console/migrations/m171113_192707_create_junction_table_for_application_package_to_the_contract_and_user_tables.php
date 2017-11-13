<?php

use yii\db\Migration;

/**
 * Handles the creation of table `application_package_to_the_contract_user`.
 * Has foreign keys to the tables:
 *
 * - `application_package_to_the_contract`
 * - `user`
 */
class m171113_192707_create_junction_table_for_application_package_to_the_contract_and_user_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('application_package_to_the_contract_user', [
            'application_package_to_the_contract_id' => $this->integer(),
            'user_id' => $this->integer(),
            'PRIMARY KEY(application_package_to_the_contract_id, user_id)',
        ]);

        // creates index for column `application_package_to_the_contract_id`
        $this->createIndex(
            'idx-app_pack_contract_user-app_pack_contract_id',
            'application_package_to_the_contract_user',
            'application_package_to_the_contract_id'
        );

        // add foreign key for table `application_package_to_the_contract`
        $this->addForeignKey(
            'fk-app_pack_contract_user-app_pack_contract_id',
            'application_package_to_the_contract_user',
            'application_package_to_the_contract_id',
            'application_package_to_the_contract',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-application_package_to_the_contract_user-user_id',
            'application_package_to_the_contract_user',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-application_package_to_the_contract_user-user_id',
            'application_package_to_the_contract_user',
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
        // drops foreign key for table `application_package_to_the_contract`
        $this->dropForeignKey(
            'fk-appl_pack_contract_user-app_pack_contract_id',
            'application_package_to_the_contract_user'
        );

        // drops index for column `application_package_to_the_contract_id`
        // Сократил название
        $this->dropIndex(
            'idx-app_pack_contract_user-application_p_to_contract_id',
            'application_package_to_the_contract_user'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-application_package_to_the_contract_user-user_id',
            'application_package_to_the_contract_user'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-application_package_to_the_contract_user-user_id',
            'application_package_to_the_contract_user'
        );

        $this->dropTable('application_package_to_the_contract_user');
    }
}
