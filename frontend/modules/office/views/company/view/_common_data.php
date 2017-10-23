<?php

/* @var $this yii\web\View */
/* @var $model common\models\info\Company */

use yii\widgets\DetailView;

?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'full_name',
        'short_name',
        'legal_address_location_id',
        'actual_address_location_id',
        'INN',
        'KPP',
        'BIK',
        'OGRN',
        'checking_account',
        'correspondent_account',
        'full_bank_name',
        'CEO',
        'operates_on_the_basis_of',
        'phone',
        'fax',
        'email:email',
    ],
]) ?>