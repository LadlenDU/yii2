<?php

use yii\db\Migration;

/**
 * Юридическое лицо - данные.
 * 
 * Handles the creation of table `legal_entity`.
 * Has foreign keys to the tables:
 *
 * - `user_info`
 */
class m170915_005746_create_legal_entity_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('legal_entity', [
            'id' => $this->primaryKey(),
            'user_info_id' => $this->integer()->notNull(),
            'company_name' => $this->string(),
            'INN' => $this->string(40)->comment('ИНН'),
            'KPP' => $this->string(40)->comment('КПП'),
            'OGRN' => $this->string(40)->comment('ОГРН'),
            'BIC' => $this->string(40)->comment('БИК'),
            'checking_account_num' => $this->string(40)->comment('№ расчетного счета'),
            'CEO_name' => $this->string()->comment('ФИО Генерального директора'),
        ]);

        // creates index for column `user_info_id`
        $this->createIndex(
            'idx-legal_entity-user_info_id',
            'legal_entity',
            'user_info_id'
        );

        // add foreign key for table `user_info`
        $this->addForeignKey(
            'fk-legal_entity-user_info_id',
            'legal_entity',
            'user_info_id',
            'user_info',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user_info`
        $this->dropForeignKey(
            'fk-legal_entity-user_info_id',
            'legal_entity'
        );

        // drops index for column `user_info_id`
        $this->dropIndex(
            'idx-legal_entity-user_info_id',
            'legal_entity'
        );

        $this->dropTable('legal_entity');
    }
}
