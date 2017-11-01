<?php
/**
 * @var yii\web\View $this
 * @var common\models\Debtor $debtor
 * @var common\models\Court $court
 * @var common\models\info\Company $company
 */

use yii\helpers\Html;

?>

<table style="width: 100%">
    <tr>
        <td style="text-align: center; width:30%">
            <strong><?= Html::encode($company->short_name) ?></strong><br>
            ИНН <?= Html::encode($company->INN) ?><br>
            ОГРН <?= Html::encode($company->OGRN) ?><br>
            ***<br>
            адрес: <?= Html::encode($company->legalAddressLocation->createFullAddress()) ?>
        </td>
        <td>
            <table style="float: right">
                <tr>
                    <td>&nbsp;</td>
                    <td style="text-align: left">
                        <strong>
                            <!--Мировому судье судебного участка № 281-->
                            <? /*= Html::encode("$court->district, $court->region") */ ?>
                            <?= Html::encode($court->name) ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;font-weight: bold;text-decoration: underline;padding:0 1.5em 0 2em;">
                        Взыскатель
                    </td>
                    <td style="text-align: left">
                        <strong><?= Html::encode($company->short_name) ?></strong><br>
                        <?= Html::encode($company->legalAddressLocation->createFullAddress()) ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;text-decoration: underline;padding:0 1.5em 0 2em;">Должник</td>
                    <td style="text-align: left">
                        <strong><?= Html::encode($debtor->name->createFullName()) ?></strong><br>
                        <?= Html::encode($debtor->location->createFullAddress()) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>
<br>

№ _______ от ______________<br><br>

<div style="text-align: center;width: 60%;font-weight: bold;margin: auto">Заявление о выдаче судебного приказа
    <br>о взыскании задолженности за жилищно-коммунальные услуги
</div>

<br>

<p><strong><?= Html::encode($debtor->name->createFullName()) ?></strong> обладает правом пользования жилого помещения,
    расположенного по адресу: <?= Html::encode($debtor->location->createFullAddress()) ?></p>
<p>Согласно п. 3 ст. 30, п. 1 ст. 39, ст. 153, п.п. 2, 4 ст. 154, п.п. 1, 7, 8, 10, 11 ст. 155 ЖК РФ, а также абз. г, д
    п. 19 Правил пользования жилыми помещениями (утв. постановлением Правительства РФ от 21 января 2006 г. N 25)
    собственник обязан своевременно вносить плату за жилое помещение и коммунальные услуги (плата за наём; плата за
    содержание и ремонт жилого помещения, включающая в себя плату за услуги и работы по управлению многоквартирным
    домом, содержанию и текущему ремонту общего имущества в многоквартирном доме; плата за коммунальные услуги) с
    момента приобретения права собственности на указанное жилое помещение.</p>
<p>Кроме того, согласно п. 1 ст. 155 ЖК РФ плата за жилое помещение и коммунальные услуги вносится ежемесячно до
    десятого числа месяца, следующего за истекшим месяцем.</p>
<p>В соответствие с п. 3 ст. 31 ЖК РФ члены семьи собственника жилого помещения имеют равные с собственником права и
    обязанности. Дееспособные и ограниченные судом в дееспособности члены семьи собственника жилого помещения несут
    солидарную с собственником ответственность по обязательствам.</p>
<p>Согласно п. 1 ст. 323 ГК РФ при солидарной обязанности должников кредитор вправе требовать исполнения как от всех
    должников совместно, так и от любого из них в отдельности, притом как полностью, так и в части долга.</p>
<p>Ответчик систематически уклоняется от внесения указанных платежей, будучи от них не освобожденным.</p>
<p>Таким образом, размер задолженность ответчиков перед <?= Html::encode($company->short_name) ?> за период с мая
    2016г. по июнь 2017г. составляет
    30865,36руб.Неустойка за просрочку платежа на дату подачи заявления составляет 5006,02руб.</p>
<p>Руководствуясь п. 3 ст. 382 Гражданского кодекса РФ, и в соответствии с договором уступки прав (цессии) № 2706/2017
    от «27» июня 2017 года, МП ГПЩ «ДЕЗ ЖКХ» уступило, а ООО «Альфа» ИНН 5050130861, приняло право требования
    задолженности жителей по жилищно-коммунальным услугам.</p>
<p>На основании вышеизложенного и в соответствии с ст.ст. 8, 11, 12, 307, 309 ГК РФ, ст.ст. 153-157 ЖК РФ, ст.ст. 3, 4
    ГПК РФ</p>

<div style="text-align: center;font-weight: bold">ПРОШУ СУД:</div>

<p>Вынести судебный приказ о взыскании с
    <strong><?= Html::encode($debtor->name->createFullName('родительный')) ?></strong> 14.08.1983 года рождения место
    рождения: г.
    Мытищи Московской области, зарегистрированного по адресу: 141100, МО, г. Щелково, 1-й Советский пер. д.19,к.2,
    кв.47, в пользу ООО «Альфа», ИНН/КПП 5050130861/505001001, ОГРН 1175050002313,на р/сч 40702810700001007864,
    к/сч30101810645250000801, Инвестиционный Банк "ВЕСТА", БИК: 044525801</p>
<ul>
    <li>плату за жилищно-коммунальные услуги (электроснабжение ОДН, Водоотведение, Холодное в/с, Содержание ж/ф)
        запериод смай 2016г. по июнь 2017г.в размере30865,36руб.;
    </li>
    <li>неустойку за просрочку платежа в размере 5006,02руб.</li>
    <li>расходы по оплате государственной пошлины по иску в размере 638,00 руб..</li>
</ul>
<br>
<strong>Приложение:</strong><br>
<ol>
    <li>Выписка из домовой книги</li>
    <li>История начислений за период</li>
    <li>Расчет пени за коммунальные услуги;</li>
    <li>Справка с сайта реформа ЖКХ об управлении домами УК МП ГПЩ «ДЕЗ ЖКХ».</li>
    <li>Копия договора уступки прав (цессии) № 2706/2017 от 27.06.2017 г. с приложениями.</li>
    <li>Платежное поручение об оплате госпошлины</li>
</ol>
<br>
<br>
Генеральный директор ________________ Мукин В.И.<?= '' //Html::encode($company->manager_name->createShortName())  ?>
