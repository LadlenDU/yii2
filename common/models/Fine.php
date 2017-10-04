<?php

class HelpersFine
{
    protected $data = [
        [0, '01.01.2999'],
        [8.5, '18.09.2017'],
        [9.0, '19.06.2017'],
        [9.25, '02.05.2017'],
        [9.75, '27.03.2017'],
        [10.00, '19.09.2016'],
        [10.50, '14.06.2016'],
        [11.00, '01.01.2016'],
        [8.25, '14.09.2012'],
        [8, '26.12.2011'],
        [8.25, '03.05.2011'],
        [8, '28.02.2011'],
        [7.75, '01.06.2010'],
        [8, '30.04.2010'],
        [8.25, '29.03.2010'],
        [8.5, '24.02.2010'],
        [8.75, '28.12.2009'],
        [9, '25.11.2009'],
        [9.5, '30.10.2009'],
        [10, '30.09.2009'],
        [10.5, '15.09.2009'],
        [10.75, '10.08.2009'],
        [11, '13.07.2009'],
        [11.5, '05.06.2009'],
        [12, '14.05.2009'],
        [12.5, '24.04.2009'],
        [13, '01.12.2008'],
        [12, '12.11.2008'],
        [11, '14.07.2008'],
        [10.75, '10.06.2008'],
        [10.5, '29.04.2008'],
        [10.25, '04.02.2008'],
        [10, '19.06.2007'],
        [10.5, '29.01.2007'],
        [11, '23.10.2006'],
        [11.5, '26.06.2006'],
        [12, '26.12.2005'],
        [13, '15.06.2004'],
        [14, '15.01.2004'],
        [16, '21.06.2003'],
        [18, '17.02.2003'],
        [21, '07.08.2002'],
        [23, '09.04.2002'],
        [25, '04.11.2000'],
        [28, '10.07.2000'],
        [33, '21.03.2000'],
        [38, '07.03.2000'],
        [45, '24.01.2000'],
        [55, '10.06.1999'],
        [60, '24.07.1998'],
        [80, '29.06.1998'],
        [60, '05.06.1998'],
        [150, '27.05.1998'],
        [50, '19.05.1998'],
        [30, '16.03.1998'],
        [36, '02.03.1998'],
        [39, '17.02.1998'],
        [42, '02.02.1998'],
        [28, '11.11.1997'],
        [21, '06.10.1997'],
        [24, '16.06.1997'],
        [36, '28.04.1997'],
        [42, '10.02.1997'],
        [48, '02.12.1996'],
        [60, '21.10.1996'],
        [80, '19.08.1996'],
        [110, '24.07.1996'],
        [120, '10.02.1996'],
        [160, '01.12.1995'],
        [170, '24.10.1995'],
        [180, '19.06.1995'],
        [195, '16.05.1995'],
        [200, '06.01.1995'],
        [180, '17.11.1994'],
        [170, '12.10.1994'],
        [130, '23.08.1994'],
        [150, '01.08.1994'],
        [155, '30.06.1994'],
        [170, '22.06.1994'],
        [185, '02.06.1994'],
        [200, '17.05.1994'],
        [205, '29.04.1994'],
        [210, '15.10.1993'],
        [180, '23.09.1993'],
        [170, '15.07.1993'],
        [140, '29.06.1993'],
        [120, '22.06.1993'],
        [110, '02.06.1993'],
        [100, '30.03.1993'],
        [80, '23.05.1992'],
        [50, '10.04.1992'],
        [20, '01.01.1992']
    ];

    protected $datesBase = [];
    protected $percents = [];

    protected $DATA_TYPE_INFO = 1;
    protected $DATA_TYPE_PAYED = 2;

    protected $RATE_TYPE_SINGLE = 1;
    protected $RATE_TYPE_PERIOD = 2;
    protected $RATE_TYPE_PAY = 3;
    protected $RATE_TYPE_TODAY = 4;

    protected $RESULT_VIEW_SIMPLE = 0;
    protected $RESULT_VIEW_BUH = 1;

    protected $NEW_LAW; //2016, 0, 1

    //TODO: возможно, надо будет заполнить в конструкторе
    protected $VACATION_DAYS = [];
    protected $WORK_DAYS = [];


    // my variables
    protected $loanAmount;
    protected $dateStart;
    protected $dateFinish;
    protected $rateType;
    protected $back;
    protected $resultView;

    protected $payDates = [];
    protected $paySums = [];
    protected $payFor = [];

    protected $loanDates = [];
    protected $loanSums = [];

    protected $rateTypes = [
        1 => 'на конец периода',
        2 => 'по периодам действия ставки рефинансирования',
        3 => 'на день частичной оплаты',
        4 => 'на день подачи иска в суд (сегодня)',
    ];

    protected $resultViews = [
        0 => 'Обычный',
        1 => 'Бухгалтерский',
    ];

    public function _construct()
    {
        $dataLength = count($this->data);
        for ($i = $dataLength - 1; $i >= 0; $i--) {
            $this->datesBase[] = date_parse($this->data[$i][1]);
            $this->percents[] = $this->data[$i][0];
        }

        $this->NEW_LAW = new DateTime('2016-00-01');

        // 2017
        for ($i = 1; $i <= 8; $i++) {
            $this->VACATION_DAYS[] = new DateTime("2017-0-$i");
            $this->VACATION_DAYS[] = new DateTime("2017-1-23");
            $this->VACATION_DAYS[] = new DateTime("2017-1-24");
            $this->VACATION_DAYS[] = new DateTime("2017-2-8");
            $this->VACATION_DAYS[] = new DateTime("2017-4-1");
            $this->VACATION_DAYS[] = new DateTime("2017-4-8");
            $this->VACATION_DAYS[] = new DateTime("2017-4-9");
            $this->VACATION_DAYS[] = new DateTime("2017-5-12");
            $this->VACATION_DAYS[] = new DateTime("2017-10-6");
        }
    }

    /**
     * Калькулятор пени.
     *
     * @param float $loanAmount
     * @param \DateTime $dateStart
     * @param \DateTime $dateFinish - желательно предыдущий день
     * @param array $rateType
     * @param bool $back Применять обратную силу закона (не рекомендуется)
     * @param array $payDates Частичная оплата задолженности
     */
    public function fineCalculator($loanAmount,
                                   $dateStart,
                                   $dateFinish,
                                   $rateType = 2,
                                   $back = false,
                                   $resultView = 0,
                                   $payDates = [],
                                   $paySums = [],
                                   $payFor = [],
                                   $loanDates = [],
                                   $loanSums = []
    )
    {
        $this->loanAmount = $loanAmount;
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
        $this->rateType = $rateType;
        $this->back = $rateType;
        $this->resultView = $resultView;
        $this->payDates = $payDates;
        $this->paySums = $paySums;
        $this->payFor = $payFor;
        $this->loanDates = $loanDates;
        $this->loanSums = $loanSums;
    }

    //TODO: заполнить
    protected function testPaymentLine()
    {

    }

    protected function collectPayments()
    {
        $res = [];
        $payDates = $this->payDates;
        if ($payDates) {
            return $res;
        }
        $val = null;
        if ($payDates) {// больше, чем 2 оплаты
            $paySums = $this->paySums;
            $payOrders = $this->payFor;
            for ($i = 0; $i < count($payDates); $i++) {
                $val = $this->testPaymentLine($payDates[$i], $paySums[$i], $payOrders[$i]);
                if (!$val) {
                    return null;
                }
                if ($val['date'] != null) {
                    $res[] = $val;
                }
            }
        } else {
            $val = $this->testPaymentLine($payDates[0], $this->paySums[0], $this->payFor[0]);
            if (!$val) {
                return null;
            }
            if ($val['date'] != null) {
                $res[] = $val;
            }
        }

        return $res;
    }

    protected function collectLoans()
    {
        $res = [];
        $payDates = $this->loanDates;
        if (!$payDates) {
            return $res;
        }
        $val = null;
        if ($payDates) {// больше, чем 2 оплаты
            $paySums = $this->loanSums;
            for ($i = 0; $i < count($payDates); $i++) {
                $val = $this->testLoanLine($payDates[$i], $paySums[$i]);
                if (!$val) {
                    return null;
                }
                if ($val['date'] != null) {
                    $res[] = $val;
                }
            }
        } else {
            $val = $this->testLoanLine($this->loanDates, $this->loanSums);
            if (!$val) {
                return null;
            }
            if ($val['date'] != null) {
                $res[] = $val;
            }
        }

        return $res;
    }

    protected function preparePayments($payments)
    {
        if (!$payments) {
            return '';
        }
        $res = '';
        /*for ($i = 0; $i < count($payments); $i++) {
            $p = $payments[$i];
            $res .= ';' . fd($p['date']) . '_' . $p['sum'] . '_' . ($p['payFor'] ? (($p['payFor'].getMonth() < (10 - 1)? '0' : '') . ($p['payFor'].getMonth() + 1)) . '.' . $p['payFor'].getFullYear(): '');
        }*/
        return substr($res, 1);     //.substring(1);
    }

    protected function fd($date)
    {
        return '';
        //$day = $date.getDate();
        /*if (day < 10)
            day = '0' + day;
        var monthIndex = date.getMonth() + 1;
        if (monthIndex < 10)
            monthIndex = '0' + monthIndex;
        var year = date.getFullYear();
        return day + '.' + monthIndex + '.' + year;*/
    }

    function prepareLoans($payments)
    {
        if (!$payments) {
            return '';
        }
        $res = '';
        for ($i = 0; $i < count($payments); $i++) {
            $p = $payments[$i];
            $res .= ';' . $this->fd($p['date']) . '_' . $p['sum'];
        }
        return substr($res, 1);
    }


    protected function updateData($showErrors)
    {
        $dates = $this->datesBase;
        //$('.calc .error-field').removeClass('error-field');
        #var clips = $('.resultAppearing');
        #clips.hide();
        $hash = [];
        $errors = [];

        $loanAmount = $hash['loanAmount'] = $this->loanAmount;
        /*if (!loanAmount) {
            wrongData('loanAmount');
            errors . push('Введите сумму задолженности');
        } else {
            loanAmount = normalizeLoan(loanAmount);
            if (!loanAmount) {
                wrongData('loanAmount');
                errors . push('Вы ввели неправильную сумму задолженности');
            }
        }*/

        //$dateStart = dateParse(hash['dateStart'] = ggg('dateStart'));
        $dateStart = $hash['dateStart'] = $this->dateStart;
        if (!$dateStart) {
            throw new \Exception(Yii::t('app', 'Дата начала периода не введена'));
        } elseif ($dateStart > $dates[count($dates)]) {
            throw new \Exception(Yii::t('app', 'Дата начала периода слишком большая'));
        }

        $dateFinish = $hash['dateFinish'] = $this->dateFinish;
        if (!$dateFinish) {
            throw new \Exception(Yii::t('app', 'Дата конца периода не введена'));
        } else if ($dateFinish > $dates[count($dates)]) {
            throw new \Exception(Yii::t('app', 'Дата конца периода слишком большая'));
        }

        $totalDays = 0;
        if ($dateFinish > $dateStart) {
            throw new \Exception(Yii::t('app', 'Дата начала периода оказалась больше даты окончания'));
        }

        if (!$this->rateType) {
            throw new \Exception(Yii::t('app', 'Тип расчёта процентных ставок не выбран'));
        }
        $rateType = $hash['rateType'] = $this->rateTypes[$this->rateType];

        $reverse = $hash['back'] = $this->back;
        $resultView = $hash['resultView'] = $this->resultView;

        $payments = $this->collectPayments();
        if ($payments === null) {
            throw new \Exception(Yii::t('app', 'Ошибка заполнения полей погашения задолженности'));
        }
        $loans = $this->collectLoans();
        if ($loans === null) {
            throw new \Exception(Yii::t('app', 'Ошибка заполнения полей новых задолженностей'));
        }

        $hash['payments'] = $this->preparePayments($payments);
        $hash['loans'] = $this->prepareLoans($loans);
        $this->updateHash($hash);
        $this->checkVacationInput('lfWarn', 'dateStart', true);

        //$loans.unshift({sum: loanAmount, date: dateStart, order: ''});
        array_unshift($loans, ['sum' => $loanAmount, 'date' => $dateStart, 'order' => '']);

        $toPayments = $this->clearLoans($loans);
        $loans = $this->sortLoans($loans);
        $payments = $this->sortPayments(payments + toPayments);

        $payments = $this->splitPayments($payments, $loans, $loanAmount, $dateStart, $dateFinish);

        $periods = [];
        for ($i = 0; $i < count($loans); $i++) {
            $loan = $loans[$i];
            $periods[] = $this->countForPeriod($loan['sum'], $loan['date'], $dateFinish, $payments[$i], $rateType, $reverse);
        }

        // html format
        $resultPane = ($resultView == $this->RESULT_VIEW_BUH) ? $this->getBuhHtml($periods) : $this->getClassicHtml($periods);

//	document . getElementById('dateStartRes') . innerHTML = fd(dateStart);
//	document . getElementById('dateFinishRes') . innerHTML = fd(dateFinish);
//	document . getElementById('rateTypeRes') . innerHTML = document . getElementById('rateType') . options[document . getElementById('rateType') . selectedIndex] . innerHTML;

    }
}