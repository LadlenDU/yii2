<?php

use yii\db\Migration;

/**
 * Handles the creation of table `individual`.
 * Has foreign keys to the tables:
 *
 * - `user_info`
 */
class m170915_053239_create_individual_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('individual', [
            'id' => $this->primaryKey(),
            'user_info_id' => $this->integer()->notNull(),
            'full_name' => $this->string()->comment('ФИО'),
            'INN' => $this->string(40)->comment('ИНН'),
            'checking_account_num' => $this->string(40)->comment('№ расчетного счета'),
        ]);

        // creates index for column `user_info_id`
        $this->createIndex(
            'idx-individual-user_info_id',
            'individual',
            'user_info_id'
        );

        // add foreign key for table `user_info`
        $this->addForeignKey(
            'fk-individual-user_info_id',
            'individual',
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
            'fk-individual-user_info_id',
            'individual'
        );

        // drops index for column `user_info_id`
        $this->dropIndex(
            'idx-individual-user_info_id',
            'individual'
        );

        $this->dropTable('individual');
    }
}
