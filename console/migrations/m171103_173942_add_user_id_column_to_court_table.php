<?php

use yii\db\Migration;

/**
 * Handles adding user_id to table `court`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m171103_173942_add_user_id_column_to_court_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('court', 'user_id', $this->integer()->comment('ID пользователя'));

        // creates index for column `user_id`
        $this->createIndex(
            'idx-court-user_id',
            'court',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-court-user_id',
            'court',
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
            'fk-court-user_id',
            'court'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-court-user_id',
            'court'
        );

        $this->dropColumn('court', 'user_id');
    }
}
