<?php

use yii\db\Migration;

/**
 * Handles adding user_id to table `debtor`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m171103_173555_add_user_id_column_to_debtor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('debtor', 'user_id', $this->integer()->comment('ID пользователя'));

        // creates index for column `user_id`
        $this->createIndex(
            'idx-debtor-user_id',
            'debtor',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-debtor-user_id',
            'debtor',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-debtor-user_id',
            'debtor'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-debtor-user_id',
            'debtor'
        );

        $this->dropColumn('debtor', 'user_id');
    }
}
