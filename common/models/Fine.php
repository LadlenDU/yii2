<?php

class HelpersFine
{
    public $data = [
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

    public $datesBase = [];
    public $percents = [];

    public $DATA_TYPE_INFO = 1;
    public $DATA_TYPE_PAYED = 2;

    public $RATE_TYPE_SINGLE = 1;
    public $RATE_TYPE_PERIOD = 2;
    public $RATE_TYPE_PAY = 3;
    public $RATE_TYPE_TODAY = 4;

    public $RESULT_VIEW_SIMPLE = 0;
    public $RESULT_VIEW_BUH = 1;

    public $NEW_LAW; //2016, 0, 1

    //TODO: возможно, надо будет заполнить в конструкторе
    public $VACATION_DAYS = [];
    public $WORK_DAYS = [];


    // my variables
    public $loanAmount;
    public $dateStart;
    public $dateFinish;


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
     * @param \DateTime $dateFinish
     */
    public function fineCalculator($loanAmount, $dateStart, $dateFinish)
    {
        $this->loanAmount = $loanAmount;
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
    }


    public function updateData($showErrors)
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

        var
        rateType = hash['rateType'] = document . getElementById('rateType') . options[document . getElementById('rateType') . selectedIndex] . value;
        if (!rateType) {
            wrongData('rateType');
            errors . push('Тип расчёта процентных ставок не выбран');
        }

        var
        reverse = hash['back'] = document . getElementById('back') . checked;
        var
        resultView = hash['resultView'] = parseInt($('form[name=calcTable] input[name=resultView]:checked') . val());

        var
        payments = collectPayments();
        if (payments === null) {
            errors . push('Ошибка заполнения полей погашения задолженности');
        }
        var
        loans = collectLoans();
        if (loans === null) {
            errors . push('Ошибка заполнения полей новых задолженностей');
        }


        var
        el = $('#error-pane');
        if (errors . length) {
            if (showErrors) {
                var
                html = '<ul>';
                for (var i = 0; i < errors . length; i++)
				html += '<li>' + errors[i] + '</li>';
			html += '</ul>';
			el . html(html);
			el . show();
			document . location . hash = '';
			document . location . hash = 'calc-error';
		}
            return;
        }
        el . hide();

        hash['payments'] = preparePayments(payments);
        hash['loans'] = prepareLoans(loans);
        updateHash(hash);
        checkVacationInput('lfWarn', 'dateStart', true);

        loans . unshift({sum: loanAmount, date: dateStart, order: ''});

	var toPayments = clearLoans(loans);
	loans = sortLoans(loans);
	payments = sortPayments(payments . concat(toPayments));

	payments = splitPayments(payments, loans, loanAmount, dateStart, dateFinish);

	var periods = [];
	for (var i = 0; i < loans . length; i++) {
        var
        loan = loans[i];
        periods . push(countForPeriod(loan . sum, loan . date, dateFinish, payments[i], rateType, reverse));
    }


	document . getElementById('resultPane') . innerHTML =
        resultView == RESULT_VIEW_BUH ? getBuhHtml(periods) : getClassicHtml(periods);

	document . getElementById('dateStartRes') . innerHTML = fd(dateStart);
	document . getElementById('dateFinishRes') . innerHTML = fd(dateFinish);
	document . getElementById('rateTypeRes') . innerHTML = document . getElementById('rateType') . options[document . getElementById('rateType') . selectedIndex] . innerHTML;

	var href = document . location . href;
	$('#djuLink') . html(href);
	var aHref = $('#djuHref');
	aHref . attr('href', href);
	aHref . html(cutLink(href));

	clips . show();
}
}