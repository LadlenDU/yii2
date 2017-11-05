<?php

use yii\db\Migration;

/**
 * Handles the creation of table `debtor_status`.
 */
class m171104_230740_create_debtor_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('debtor_status',
            [
                'id' => $this->primaryKey(),
                'status' => $this->string()->notNull()->defaultValue('new')->comment('Тип статуса'),
                'submitted_to_court_start' => $this->datetime()->comment('Начало суда'),
                'adjudicated_result' => $this->string()->comment('Результат суда'),
                'adjudicated_decision' => $this->text()->comment('Решение суда'),
                'application_withdrawn_reason' => $this->text()->comment('Причина отзыва заявления'),
            ],
            'COMMENT "Статус пользователя"'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('debtor_status');
    }
}
