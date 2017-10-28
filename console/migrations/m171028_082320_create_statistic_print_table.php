<?php

use yii\db\Migration;

/**
 * Handles the creation of table `statistic_print`.
 * Has foreign keys to the tables:
 *
 * - `company`
 */
class m171028_082320_create_statistic_print_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('statistic_print', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'date' => $this->datetime()->notNull(),
            'price' => $this->decimal(8,2)->comment('Стоимость распечатки'),
            'original_balance' => $this->decimal(8,2)->comment('Начальный баланс (до распечатки)'),
        ],
            'COMMENT "Статистика по печати"'
        );

        // creates index for column `company_id`
        $this->createIndex(
            'idx-statistic_print-company_id',
            'statistic_print',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-statistic_print-company_id',
            'statistic_print',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `company`
        $this->dropForeignKey(
            'fk-statistic_print-company_id',
            'statistic_print'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-statistic_print-company_id',
            'statistic_print'
        );

        $this->dropTable('statistic_print');
    }
}
