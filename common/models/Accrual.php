<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "accrual".
 *
 * @property integer $id
 * @property integer $debtor_id
 * @property string $accrual_date
 * @property string $accrual
 * @property string $single
 * @property string $additional_adjustment
 * @property string $subsidies
 * @property string $accrual_recount
 *
 * @property Debtor $debtor
 */
class Accrual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accrual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debtor_id'], 'integer'],
            [['accrual_date'], 'safe'],
            [['accrual', 'single', 'additional_adjustment', 'subsidies', 'accrual_recount'], 'number'],
            [['debtor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Debtor::className(), 'targetAttribute' => ['debtor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'debtor_id' => Yii::t('app', 'ID должника'),
            'accrual_date' => Yii::t('app', 'Дата начисления'),
            'accrual' => Yii::t('app', 'Начислено'),
            'single' => Yii::t('app', 'Разовые'),
            'additional_adjustment' => Yii::t('app', 'Доп. корректировка'),
            'subsidies' => Yii::t('app', 'Субсидии'),
            'accrual_recount' => Yii::t('app', 'Конечная перерасчитанная задолженность (с учетом пени, корректировок и пр.)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtor()
    {
        return $this->hasOne(Debtor::className(), ['id' => 'debtor_id'])->inverseOf('accruals');
    }

    /**
     * @inheritdoc
     * @return AccrualQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccrualQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = NULL)
    {
        if ($this->accrual_date) {
            //$this->accrual_date .= '-01 00:00:00';
            /*$parts = explode('-', $this->accrual_date);
            if (!empty($parts[0]) && !empty($parts[1])) {
                $this->accrual_date = $this->accrual_date;
            }*/
            $this->accrual_date = strtotime($this->accrual_date);
            $this->accrual_date = date('Y-m-d G:i:s', $this->accrual_date);
        }

        parent::save($runValidation, $attributeNames);
    }

    //TODO: $save = true - напрягает, но пока используем учитывая приоритет надежности
    protected function recountAccrual($save = true)
    {
        $accrual = $this->accrual ?: 0;
        $subsidies = $this->subsidies ?: 0;
        $single = $this->single ?: 0;
        $additional_adjustment = $this->additional_adjustment ?: 0;
        $this->accrual_recount = (float)$accrual - (float)$subsidies + (float)$single + (float)$additional_adjustment;
        if ($save) {
            $this->save(false, ['accrual_recount']);
        }
    }

    public function setAccrual($val)
    {
        $this->accrual = $val;
        $this->recountAccrual();
    }

    public function setSubsidies($val)
    {
        $this->subsidies = $val;
        $this->recountAccrual();
    }

    public function setSingle($val)
    {
        $this->single = $val;
        $this->recountAccrual();
    }

    public function setAdditionalAdjustment($val)
    {
        $this->additional_adjustment = $val;
        $this->recountAccrual();
    }

    public function getAccrualRecount()
    {
        if ($this->accrual_recount === null) {
            $this->recountAccrual();
        }
        return $this->accrual_recount;
    }
}
