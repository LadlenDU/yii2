<?php

namespace common\models\stat;

use Yii;
use common\models\info\Company;

/**
 * This is the model class for table "statistic_print".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $date
 * @property string $price
 * @property string $original_balance
 *
 * @property Company $company
 */
class StatisticPrint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statistic_print';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['date'], 'required'],
            [['date'], 'safe'],
            [['price', 'original_balance'], 'number'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'date' => Yii::t('app', 'Дата распечатки'),
            'price' => Yii::t('app', 'Стоимость распечатки'),
            'original_balance' => Yii::t('app', 'Начальный баланс (до распечатки)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->inverseOf('statisticPrints');
    }

    public static function decreaseBalance($price, $originalBalance, $companyId)
    {
        $model = new StatisticPrint;
        $model->company_id = $companyId;
        $model->date = date('Y-m-d H:i:s');
        $model->price = $price;
        $model->original_balance = $originalBalance;
        $model->save();
    }
}
