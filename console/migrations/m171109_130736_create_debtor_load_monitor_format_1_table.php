<?php

use yii\db\Migration;

/**
 * Handles the creation of table `debtor_load_monitor_format_1`.
 */
class m171109_130736_create_debtor_load_monitor_format_1_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('debtor_load_monitor_format_1', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string()->notNull()->comment('Название файла'),
            'total_rows' => $this->integer()->comment('Кол-во строк в файле'),
            'last_added_string' => $this->integer()->comment('Последняя распарсенная и добавленная в БД строка'),
            'started_at' => $this->datetime()->comment('Начало парсинга (первая попытка)'),
            'finished_at' => $this->datetime()->null()->comment('Когда парсинг закончен (не нулевое значение обозначает конец парсинга)'),
        ],
            'COMMENT "Таблица, сохраняющая значения состояния парсинга файлов по формату 1"'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('debtor_load_monitor_format_1');
    }
}
