<?php

namespace common\models;

use Yii;

class DebtorExt extends Debtor
{
    /*public function calculateStateFee()
    {
        //TODO: косяк - в таблице надо использовать не Debtor, a DebtDetails класс (и текущцю функцию вызывать из него напрямую)
        $fee = $this->getDebtDetails()->one()->calculateStateFee();
        return $fee;
    }*/

    /**
     * @param int|null $caseNum номер падежа (0-based)
     * @return string
     */
    public function getFIOName($case = null)
    {
        if ($this->name_mixed) {
            $fio = $this->name_mixed;
        } else {


            /*$fio = $this->second_name;
            if ($this->first_name) {
                $fio .= ' ';
            }
            $fio .= $this->first_name;
            if ($this->patronymic) {
                $fio .= ' ';
            }
            $fio .= $this->patronymic;*/

            $fio = trim(implode(' ', [$this->second_name, $this->first_name, $this->patronymic]));
        }

        if ($fio) {
            /*$nc = new \NCLNameCaseRu();
            if ($caseNum !== null) {
                $fio = $nc->q($fio, $caseNum);
            }*/
            if ($case) {
                $fio = \morphos\Russian\inflectName($fio, $case);
            }
        } else {
            $fio = '(Нет имени)';
        }

        return $fio;
    }

    public function getFullAddress()
    {
        return "$this->city $this->street $this->building $this->appartment";
    }

    public function getShortName()
    {
        $name = '';
        /*if ($this->generalManager) {
            if ($this->generalManager->second_name) {
                $name .= "{$this->generalManager->second_name} ";
            }
            if ($this->generalManager->first_name) {
                $name .= mb_substr($this->generalManager->first_name, 0, 1, Yii::$app->charset) . '.';
            }
            if ($this->generalManager->patronymic) {
                $name .= mb_substr($this->generalManager->patronymic, 0, 1, Yii::$app->charset) . '.';
            }
        }*/

        return $name;
        //return $name ?: Yii::t('app', 'Нет имени');
    }
}
