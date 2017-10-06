<?php

namespace common\models;

use Yii;
use common\models\Fine;

/**
 * This is the model class for table "debtor".
 *
 * @property integer $id
 * @property string $phone
 * @property string $LS_EIRC
 * @property string $LS_IKU_provider
 * @property string $IKU
 * @property double $space_common
 * @property double $space_living
 * @property integer $privatized
 * @property integer $location_id
 * @property integer $name_id
 * @property string $expiration_start
 * @property string $debt_total
 *
 * @property DebtDetails[] $debtDetails
 * @property Location $location
 * @property Name $name
 * @property DebtorPublicService[] $debtorPublicServices
 * @property PublicService[] $publicServices
 */
class Debtor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debtor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['space_common', 'space_living', 'debt_total'], 'number'],
            [['privatized', 'location_id', 'name_id'], 'integer'],
            [['expiration_start'], 'safe'],
            [['phone', 'LS_EIRC', 'LS_IKU_provider', 'IKU'], 'string', 'max' => 255],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['name_id'], 'exist', 'skipOnError' => true, 'targetClass' => Name::className(), 'targetAttribute' => ['name_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone' => Yii::t('app', 'Телефон'),
            'LS_EIRC' => Yii::t('app', 'ЛС ЕИРЦ'),
            //'LS_IKU_provider' => Yii::t('app', 'ЛС ИКУ/поставщика'),
            // № лицевого счета
            'LS_IKU_provider' => Yii::t('app', '№ ЛС'),
            'IKU' => Yii::t('app', 'ИКУ'),
            'space_common' => Yii::t('app', 'Общая площадь'),
            'space_living' => Yii::t('app', 'Жилая площадь'),
            'privatized' => Yii::t('app', 'Приватизировано'),
            'location_id' => Yii::t('app', 'Location ID'),
            'name_id' => Yii::t('app', 'Name ID'),
            'expiration_start' => Yii::t('app', 'Начало просрочки'),
            'debt_total' => Yii::t('app', 'Сумма долга'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtDetails()
    {
        return $this->hasMany(DebtDetails::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id'])->inverseOf('debtors');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getName()
    {
        return $this->hasOne(Name::className(), ['id' => 'name_id'])->inverseOf('debtors');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtorPublicServices()
    {
        return $this->hasMany(DebtorPublicService::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicServices()
    {
        return $this->hasMany(PublicService::className(), ['id' => 'public_service_id'])->viaTable('debtor_public_service', ['debtor_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DebtorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DebtorQuery(get_called_class());
    }

    public function calcFine()
    {
        if ($this->expiration_start && $this->debt_total) {
            $dateStart = strtotime($this->expiration_start);
            $dateFinish = time() - 60 * 60 * 24;

            $fine = new Fine();
            $res = $fine->fineCalculator($this->debt_total, $dateStart, $dateFinish);

            $sum = 0;

            if (!empty($res[0]['data'])) {
                foreach ($res[0]['data'] as $r) {
                    $sum += (int)$r['data']['cost'];
                }
            }

            return $sum;
        }

        return 0;
    }
}
