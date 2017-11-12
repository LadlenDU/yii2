<?php

use yii\db\Migration;

/**
 * Handles the creation of table `debtor_common_recalculate_monitor`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m171112_190857_create_debtor_common_recalculate_monitor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('debtor_common_recalculate_monitor', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователь, должники которого пересчитываются'),
            'total_debtors' => $this->integer()->comment('Кол-во должников на момент старта перерасчета'),
            'last_recounted_debtor_id' => $this->integer()->comment('ID последнего перерасчитанного должника'),
            'started_at' => $this->datetime()->comment('Начало перерасчета (первая попытка)'),
            'continued_at' => $this->datetime()->comment('Продолжение перерасчета (последнее после прерывания)'),
            'finished_at' => $this->datetime()->null()->comment('Завершение перерасчета (не нулевое значение обозначает конец перерасчета)'),
        ],
            'COMMENT "Информация о групповом перерасчете пользователей (общая). Пользователи должны быть отсортированы по ID для возможности корректного возобновления перерасчета."'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-debtor_common_recalculate_monitor-user_id',
            'debtor_common_recalculate_monitor',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-debtor_common_recalculate_monitor-user_id',
            'debtor_common_recalculate_monitor',
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
            'fk-debtor_common_recalculate_monitor-user_id',
            'debtor_common_recalculate_monitor'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-debtor_common_recalculate_monitor-user_id',
            'debtor_common_recalculate_monitor'
        );

        $this->dropTable('debtor_common_recalculate_monitor');
    }
}
