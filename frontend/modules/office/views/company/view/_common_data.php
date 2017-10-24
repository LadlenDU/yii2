<?php

/* @var $this yii\web\View */
/* @var $model common\models\info\Company */

use kartik\detail\DetailView;
use common\models\info\CompanyType;
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\info\OKOPF;
use common\models\info\TaxSystem;
use common\models\Location;

$attributes = [
    [
        'group' => true,
        'label' => Yii::t('app', 'Название'),
        'rowOptions' => ['class' => 'info'],
    ],
    'full_name',
    'short_name',
    [
        'group' => true,
        'label' => Yii::t('app', '----'),
        'rowOptions' => ['class' => 'info'],
    ],
    [
        'attribute' => 'company_type_id',
        'label' => Yii::t('app', 'Тип организации'),
        //'format'=>['decimal', 2],
        //'inputContainer' => ['class' => 'col-sm-6'],
        'format' => 'raw',
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => ArrayHelper::map(CompanyType::find()->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => Yii::t('app', 'Выберите тип ...')],
            //'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
        ],
        //'valueColOptions' => ['style' => 'width:30%']
    ],
    [
        'attribute' => 'OKOPF_id',
        'label' => Yii::t('app', 'ОКОПФ'),
        'format' => 'raw',
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => ArrayHelper::map(OKOPF::find()->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => Yii::t('app', 'Выберите ОКОПФ ...')],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'attribute' => 'tax_system_id',
        'label' => Yii::t('app', 'Система налогообложения'),
        'format' => 'raw',
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => ArrayHelper::map(TaxSystem::find()->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => Yii::t('app', 'Выберите систему ...')],
        ],
    ],
    [
        'group' => true,
        'label' => Yii::t('app', 'Контакты'),
        'rowOptions' => ['class' => 'info'],
    ],
    'phone',
    'fax',
    'email:email',
    'site',
    [
        'group' => true,
        'label' => Yii::t('app', 'Адреса'),
        'rowOptions' => ['class' => 'info'],
    ],
    [
        'attribute' => 'legal_address_location_id',
        'label' => Yii::t('app', 'Юридический адрес'),
        'format' => 'raw',
        'type' => DetailView::INPUT_TEXT,
        'widgetOptions' => [
            'data' => $model->legalAddressLocation ? $model->legalAddressLocation->createFullAddress() : '',
        ],
    ],
    [
        'attribute' => 'actual_address_location_id',
        'label' => Yii::t('app', 'Фактический адрес'),
        'format' => 'raw',
        'type' => DetailView::INPUT_TEXT,
        'widgetOptions' => [
            'data' => $model->actualAddressLocation ? $model->actualAddressLocation->createFullAddress() : '',
        ],
    ],
    [
        'attribute' => 'postal_address_location_id',
        'label' => Yii::t('app', 'Почтовый адрес'),
        'format' => 'raw',
        'type' => DetailView::INPUT_TEXT,
        'widgetOptions' => [
            'data' => $model->postalAddressLocation ? $model->postalAddressLocation->createFullAddress() : '',
        ],
    ],
    [
        'group' => true,
        'label' => Yii::t('app', '----'),
        'rowOptions' => ['class' => 'info'],
    ],
    'INN',
    'KPP',
    [
        'group' => true,
        'label' => Yii::t('app', 'ОГРН / ОГРНИП'),
        'rowOptions' => ['class' => 'info'],
    ],
    [
        'attribute' => 'OGRN_IP_type',
        'label' => Yii::t('app', 'Тип'),
        'format' => 'raw',
        'type' => DetailView::INPUT_RADIO_BUTTON_GROUP,
        'items' => [0 => 'ОГРН', 1 => 'ОГРНИП'],
    ],
    [
        'attribute' => 'OGRN_IP_number',
        'label' => Yii::t('app', 'Номер'),
    ],
    [
        'attribute' => 'OGRN_IP_date',
        'label' => Yii::t('app', 'Дата регистрации'),
        'format' => 'date',
        'type' => DetailView::INPUT_DATE,
        'widgetOptions' => [
            'pluginOptions' => ['format' => 'yyyy-mm-dd']
        ],
        //'valueColOptions' => ['style' => 'width:30%']
    ],
    [
        'attribute' => 'OGRN_IP_registered_company',
        'label' => Yii::t('app', 'Наименование зарегистрировавшей организации'),
    ],
    //'BIK',
    //'OGRN',
    //'checking_account',
    //'correspondent_account',
    //'full_bank_name',
    //'CEO',
    //'operates_on_the_basis_of',

];

echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => DetailView::MODE_VIEW,
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => true,
    'hover' => true,
    'hAlign' => 'right',
    'vAlign' => 'middle',
    'panel' => [
        'heading' => 'Общие данные организации',
        'type' => DetailView::TYPE_INFO,
    ],
    'buttons1' => '{update}',
    'container' => ['id' => 'company-common-data'],
]);
