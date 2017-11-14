<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Url;
use yii\helpers\Html;

$getStatusInfoUrl = json_encode(Url::to('/office/debtor-status/?', true));
$ajaxLoader = json_encode(\common\helpers\HtmlHelper::getCenteredAjaxLoadImg());
$loading = '<div style="text-align: center">' . Html::img('/img/loading.gif', [
        'alt' => Yii::t('app', 'Загрузка...'),
        'style' => 'margin:1em',
    ]) . '</div>';
$totalDebtors = (int)$dataProvider->getTotalCount();
$downloadReportUrl = json_encode(Url::to('/office/debtor/get-report-file/?', true));
$removeDebtorsFromReport = json_encode(Url::to('/office/debtor/remove-debtors-from-report/?', true));
$showSubscriptionForAccruals = json_encode(Url::to('/office/debtor/show-subscription-for-accruals/?', true));

$this->registerJs(<<<JS
    $('#statusesModal').on('show.bs.modal', function(e) {
        
        //TODO: не очень уверен в правильности решения
        if (e.namespace != 'bs.modal') {
            return;
        }
        
        $(e.currentTarget).find('.modal-body').html($ajaxLoader);
        
        //TODO: почему-то происходит редирект при 404
        var debtorIds = [];
        if ($(e.relatedTarget).data('type') == 'change_selected') {
            debtorIds = $('#dynagrid-debtors-options').yiiGridView('getSelectedRows');
        } else {
            debtorIds = $(e.relatedTarget).data('debtor-id');
        }
        //debtorIds = $(e.relatedTarget).data('debtor-id');
        var url;
        //if (+$("#debtors-selected-all-total").val()) {
        if (0) {
            url = $getStatusInfoUrl + $.param({debtorIds:['all'],redirect:window.location.href});
        } else {
            url = $getStatusInfoUrl + $.param({debtorIds:debtorIds,redirect:window.location.href});
        }
        $(e.currentTarget).find('.modal-body').load(url,
            function(response, status, xhr) {
                if (status == "error") {
                    var msg = "Произошла ошибка: ";
                    $(this).html(msg + xhr.status + " " + xhr.statusText);
                }
                return true;
            }
        );
    });

    $("#statusesModal .submit").click(function() {
        $("#debtor-status-form").submit();
    });
    
    //------------------------------------------
    
    var msgElem;
    var txtElem1;
    var txtElem2;
    var dynagridDebtors;
    var debtorsChangeStatusLink;
    var hiddenSelectedAll = $("#debtors-selected-all-total");
    
    $(document).on('ready pjax:success', function() {  // 'pjax:success' use if you have used pjax
    
        prepareEvents();
    
        if (+hiddenSelectedAll.val()) {
           hiddenSelectedAll.val(0);
           checkAllDebtors();
           //debtorSeletionChanged();
           eventAllDebtorsSelected();
           eventAllDebtorsSelectedTotal();
        }
      
    });
    
    var debtorsSelectedText = function(num) {
        return 'Выбрано должников: %s.'.replace('%s', num);
    };
    
    var debtorsSelectedTextSelectAll = function(num) {
        return 'Выбрать всех должников (%s).'.replace('%s', num);
    };
    
    var setSelectedOnCurrentPageOnly = function() {
        var keys = $('#dynagrid-debtors-options').yiiGridView('getSelectedRows');
        txtElem1.text(debtorsSelectedText(keys.length));
    };
    
    var uncheckAllDebtors = function() {
        dynagridDebtors.find(".select-on-check-all").prop('checked', false);
        dynagridDebtors.find(".sgkh-debtor-check").prop('checked', false);
        $("#dynagrid-debtors-options-container > table tr").removeClass('danger');
    };
    
    var checkAllDebtors = function() {
        dynagridDebtors.find(".select-on-check-all").prop('checked', true);
        dynagridDebtors.find(".sgkh-debtor-check").prop('checked', true);
    };
    
    var eventAllDebtorsSelected = function() {
        var checked = dynagridDebtors.find(".select-on-check-all").is(':checked');
        if (checked) {
            setSelectedOnCurrentPageOnly();
            txtElem2.text(debtorsSelectedTextSelectAll($totalDebtors));
            msgElem.fadeIn();
        } else {
            msgElem.fadeOut();
        }
        debtorSeletionChanged();
    };
    
    var eventAllDebtorsSelectedTotal = function() {
        var selected = +hiddenSelectedAll.val();
        hiddenSelectedAll.val(+!selected);
        var txt2;
        if (selected) {
            txt2 = debtorsSelectedTextSelectAll($totalDebtors);
            //setSelectedOnCurrentPageOnly();
            uncheckAllDebtors();
            $("#dynagrid-debtors-selected-debtors").fadeOut();
        } else {
            txtElem1.text(debtorsSelectedText($totalDebtors));
            txt2 = 'Снять выделение со всех должников.';
        }
        debtorSeletionChanged();
        txtElem2.text(txt2);
        
    };
    
    var debtorSeletionChanged = function() {
        var totalSelected;
        if (+hiddenSelectedAll.val()) {
            totalSelected = $totalDebtors;
        } else {
            totalSelected = $('#dynagrid-debtors-options').yiiGridView('getSelectedRows').length;
        }
        if (totalSelected >= 10 && totalSelected <= 200) {
            debtorsChangeStatusLink.fadeIn();
        } else {
            debtorsChangeStatusLink.fadeOut();
        }
    };
    
    function prepareEvents() {
        txtElem1 = $("#dynagrid-debtors-selected-debtors-msg-1");
        txtElem2 = $("#dynagrid-debtors-selected-debtors-msg-2");
        dynagridDebtors = $("#dynagrid-debtors");
        debtorsChangeStatusLink = $("#dynagrid-debtors-change-status");
        msgElem = $("#dynagrid-debtors-selected-debtors");
    
        dynagridDebtors.find('.view').unbind('click').click(function(e){
           e.preventDefault();
           var pModal = $('#pModal');
           pModal.find('.modal-content').html('$loading');
           pModal.modal('show').find('.modal-content').load($(this).attr('href'));
        });
        
        dynagridDebtors.find(".select-on-check-all").unbind('change').change(function(){
            eventAllDebtorsSelected();
        });
        
        dynagridDebtors.find(".sgkh-debtor-check").unbind('change').change(function(){
            debtorSeletionChanged();
            // При любом изменении обычного чекбокса - сбрасываем глобальное выделение
            msgElem.fadeOut();
            hiddenSelectedAll.val(0);
        });
        
        txtElem2.unbind('click').click(function(){
            eventAllDebtorsSelectedTotal();
        });
        
        $("#get_debtor_report").unbind('click').click(function(e) {
            e.preventDefault();
            
            var url;
            
            var all = +hiddenSelectedAll.val();
            if (all) {
                url = $downloadReportUrl + $.param({debtorIds:['all']});
            } else {
                var keys = getDebtorsSelected();
                if (keys) {
                    url = $downloadReportUrl + $.param({debtorIds:keys});
                }
            }
            
            if (url) {
                $("#debtor-report-download-frame").attr('src', url);
                //TODO: временный костыль, костыльный костыль, ОБЯЗАТЕЛЬНО ИСПРАВИТЬ!!!
                var maxVal = 1;
                $.map($("#debtorsearch-application_package option"), function(option) {
                    if (maxVal < parseInt(option.value)) {
                        maxVal = parseInt(option.value);
                    }
                });
                maxVal++;
                $("#debtorsearch-application_package").append('<option value="' + maxVal + '">' + maxVal + '</option>');
            }
            
            return false;
        });
        
        $("#remove_debtors_from_report").unbind('click').click(function(e) {
            e.preventDefault();
            var debtorIds = getDebtorsSelected();
            if (debtorIds) {
                // Удаление из бд TODO: обработка ошибок
                $.post($removeDebtorsFromReport + $.param({debtorIds:debtorIds}));
                // Удаление из таблицы
                for (var id in debtorIds) {
                    $("#dynagrid-debtors-options-container").find("input[value=" + debtorIds[id] + "]").parent().parent().fadeOut();
                }
            }
        });
        
        $("#show_subscription_for_accruals").unbind('click').click(function() {
            var debtorIds = getDebtorsSelected();
            if (debtorIds) {
                window.open($showSubscriptionForAccruals + $.param({debtorId:debtorIds[0]}), "_blank");
            }
        });
        
    }
    
    prepareEvents();
       
JS
);
