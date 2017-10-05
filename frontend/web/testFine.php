<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../common/models/Fine.php';

use common\models\Fine;

$loanAmount = empty($_GET['loanAmount']) ? 500 : $_GET['loanAmount'];
$dateStartRaw = empty($_GET['dateStart']) ? '01.03.2011' : $_GET['dateStart'];
$dateFinishRaw = empty($_GET['dateFinish']) ? '03.10.2017' : $_GET['dateFinish'];

$dateStart = strtotime($dateStartRaw);
$dateFinish = strtotime($dateFinishRaw);

$fine = new Fine();
$fine->fineCalculator($loanAmount, $dateStart, $dateFinish);
//print_r($fine);
