<?php

namespace common\models\helpers;

use Yii;

/**
 * This is the model class for table "debtor_load_monitor_format_1".
 *
 * @property integer $id
 * @property string $file_name
 * @property integer $total_rows
 * @property integer $last_added_string
 * @property string $started_at
 * @property string $finished_at
 */
class DebtorLoadMonitorFormat1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debtor_load_monitor_format_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_name'], 'required'],
            [['total_rows', 'last_added_string'], 'integer'],
            [['started_at', 'finished_at'], 'safe'],
            [['file_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_name' => Yii::t('app', 'Название файла'),
            'total_rows' => Yii::t('app', 'Кол-во строк в файле'),
            'last_added_string' => Yii::t('app', 'Последняя распарсенная и добавленная в БД строка'),
            'started_at' => Yii::t('app', 'Начало парсинга (первая попытка)'),
            'finished_at' => Yii::t('app', 'Когда парсинг закончен (не нулевое значение обозначает конец парсинга)'),
        ];
    }
}
