<?php

namespace common\models\info;

use Yii;
use common\models\UserInfo;

/**
 * This is the model class for table "legal_entity".
 *
 * @property integer $id
 * @property integer $user_info_id
 * @property string $company_name
 * @property string $INN
 * @property string $KPP
 * @property string $OGRN
 * @property string $BIC
 * @property string $checking_account_num
 * @property string $CEO_name
 * @property string $registration_date
 *
 * @property UserInfo $userInfo
 */
class LegalEntity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'legal_entity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_info_id'], 'required'],
            [['user_info_id'], 'integer'],
            [['registration_date'], 'safe'],
            [['company_name', 'CEO_name'], 'string', 'max' => 255],
            [['INN', 'KPP', 'OGRN', 'BIC', 'checking_account_num'], 'string', 'max' => 40],
            [['user_info_id'], 'unique'],
            [['user_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['user_info_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_info_id' => Yii::t('app', 'User Info ID'),
            'company_name' => Yii::t('app', 'Наименование компании, форма собственности'),
            'INN' => Yii::t('app', 'ИНН'),
            'KPP' => Yii::t('app', 'КПП'),
            'OGRN' => Yii::t('app', 'ОГРН'),
            'BIC' => Yii::t('app', 'БИК'),
            'checking_account_num' => Yii::t('app', '№ расчетного счета'),
            'CEO_name' => Yii::t('app', 'ФИО Генерального директора'),
            'registration_date' => Yii::t('app', 'Дата регистрации'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'user_info_id'])->inverseOf('legalEntity');
    }
}
