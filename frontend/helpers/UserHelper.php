<?php

namespace frontend\helpers;

use common\models\info\LegalEntity;
use common\models\info\IndividualEntrepreneur;
use common\models\info\Individual;

class UserHelper
{
    public static function getViewByRelatedModel($relModel)
    {
        $viewName = null;

        if ($relModel instanceof LegalEntity) {
            $viewName = 'legal_entity';
        } elseif ($relModel instanceof IndividualEntrepreneur) {
            $viewName = 'individual_entrepreneur';
        } elseif ($relModel instanceof Individual) {
            $viewName = 'individual';
        }

        return $viewName;
    }
}