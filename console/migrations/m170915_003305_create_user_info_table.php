<?php

use yii\db\Migration;

/**
 * Таблица, связывающая пользователя и регистрационную информацию (варианты регистрации).
 *
 * Handles the creation of table `user_info`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `registration_type`
 */
class m170915_003305_create_user_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_info', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'complete' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Завершен ли процесс заполнения информации'),
            'registration_type_id' => $this->integer()->comment('Вариант регистрации'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_info-user_id',
            'user_info',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_info-user_id',
            'user_info',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `registration_type_id`
        $this->createIndex(
            'idx-user_info-registration_type_id',
            'user_info',
            'registration_type_id'
        );

        // add foreign key for table `registration_type`
        $this->addForeignKey(
            'fk-user_info-registration_type_id',
            'user_info',
            'registration_type_id',
            'registration_type',
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
            'fk-user_info-user_id',
            'user_info'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_info-user_id',
            'user_info'
        );

        // drops foreign key for table `registration_type`
        $this->dropForeignKey(
            'fk-user_info-registration_type_id',
            'user_info'
        );

        // drops index for column `registration_type_id`
        $this->dropIndex(
            'idx-user_info-registration_type_id',
            'user_info'
        );

        $this->dropTable('user_info');
    }
}
