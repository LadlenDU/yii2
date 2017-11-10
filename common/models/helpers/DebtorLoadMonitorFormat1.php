<?php

namespace common\models\helpers;

use Yii;
use common\models\User;

/**
 * This is the model class for table "debtor_load_monitor_format_1".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $file_name
 * @property integer $total_rows
 * @property integer $last_added_string
 * @property string $started_at
 * @property string $finished_at
 *
 * @property User $user
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
            [['user_id', 'total_rows', 'last_added_string'], 'integer'],
            [['file_name'], 'required'],
            [['started_at', 'finished_at'], 'safe'],
            [['file_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'file_name' => Yii::t('app', 'Название файла'),
            'total_rows' => Yii::t('app', 'Кол-во строк в файле'),
            'last_added_string' => Yii::t('app', 'Последняя распарсенная и добавленная в БД строка'),
            'started_at' => Yii::t('app', 'Начало парсинга (первая попытка)'),
            'finished_at' => Yii::t('app', 'Когда парсинг закончен (не нулевое значение обозначает конец парсинга)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('debtorLoadMonitorFormat1s');
    }
}
