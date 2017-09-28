<?php

namespace common\models\info;

use Yii;
use common\models\UserInfo;

/**
 * This is the model class for table "individual_entrepreneur".
 *
 * @property integer $id
 * @property integer $user_info_id
 * @property string $full_name
 * @property string $OGRN
 * @property string $INN
 * @property string $BIC
 * @property string $checking_account_num
 * @property string $birthday
 *
 * @property UserInfo $userInfo
 */
class IndividualEntrepreneur extends \yii\db\ActiveRecord
{
    public $user_info_document_1;
    public $user_info_document_2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'individual_entrepreneur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['user_info_id'], 'required'],
            //[['user_info_id'], 'integer'],
            [['user_info_id'], 'safe'],
            [['user_info_document_1', 'user_info_document_2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
            [['birthday'], 'safe'],
            [['full_name'], 'string', 'max' => 255],
            [['OGRN', 'INN', 'BIC', 'checking_account_num'], 'string', 'max' => 40],
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
            'full_name' => Yii::t('app', 'ФИО'),
            'OGRN' => Yii::t('app', 'ОГРН'),
            'INN' => Yii::t('app', 'ИНН'),
            'BIC' => Yii::t('app', 'БИК'),
            'checking_account_num' => Yii::t('app', '№ расчетного счета'),
            'birthday' => Yii::t('app', 'День рождения'),
            'user_info_document_1' => Yii::t('app', 'Pdf документ 1'),
            'user_info_document_2' => Yii::t('app', 'Pdf документ 2'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'user_info_id'])->inverseOf('individualEntrepreneur');
    }
}
