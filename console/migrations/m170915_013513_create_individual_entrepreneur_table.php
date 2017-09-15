<?php

use yii\db\Migration;

/**
 * Индивидуальный предприниматель - данные.
 *
 * Handles the creation of table `individual_entrepreneur`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m170915_013513_create_individual_entrepreneur_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('individual_entrepreneur', [
            'id' => $this->primaryKey(),
            'user_info_id' => $this->integer()->notNull(),
            'full_name' => $this->string()->comment('ФИО'),
            'OGRN' => $this->string(40)->comment('ОГРН'),
            'INN' => $this->string(40)->comment('ИНН'),
            'BIC' => $this->string(40)->comment('БИК'),
            'checking_account_num' => $this->string(40)->comment('№ расчетного счета'),
        ]);

        // creates index for column `user_info_id`
        $this->createIndex(
            'idx-individual_entrepreneur-user_info_id',
            'individual_entrepreneur',
            'user_info_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-individual_entrepreneur-user_info_id',
            'individual_entrepreneur',
            'user_info_id',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-individual_entrepreneur-user_info_id',
            'individual_entrepreneur'
        );

        // drops index for column `user_info_id`
        $this->dropIndex(
            'idx-individual_entrepreneur-user_info_id',
            'individual_entrepreneur'
        );

        $this->dropTable('individual_entrepreneur');
    }
}
