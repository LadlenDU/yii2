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
$downloadReportUrl = json_encode(Url::to('/office/debtor/get-report-file/?'));

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
        if (totalSelected >= 10 && totalSelected <= 50) {
            debtorsChangeStatusLink.show();
        } else {
            debtorsChangeStatusLink.hide();
        }
    };
    
    function prepareEvents() {
        txtElem1 = $("#dynagrid-debtors-selected-debtors-msg-1");
        txtElem2 = $("#dynagrid-debtors-selected-debtors-msg-2");
        dynagridDebtors = $("#dynagrid-debtors");
        debtorsChangeStatusLink = $("#dynagrid-debtors-change-status");
        msgElem = $("#dynagrid-debtors-selected-debtors");
    
        $('.view').click(function(e){
           e.preventDefault();
           var pModal = $('#pModal');
           pModal.find('.modal-content').html('$loading');
           pModal.modal('show').find('.modal-content').load($(this).attr('href'));
        });
        
        dynagridDebtors.find(".select-on-check-all").change(function(){
            eventAllDebtorsSelected();
        });
        dynagridDebtors.find(".sgkh-debtor-check").change(function(){
            debtorSeletionChanged();
            // При любом изменении обычного чекбокса - сбрасываем глобальное выделение
            msgElem.fadeOut();
            hiddenSelectedAll.val(0);
        });
        txtElem2.click(function(){
            eventAllDebtorsSelectedTotal();
        });
        
        $("#get_debtor_report").click(function(e) {
            e.preventDefault();
            var all = +hiddenSelectedAll.val();
            if (all) {
                window.location.href = $downloadReportUrl + $.param({debtorIds:['all']});
            } else {
                var keys = getDebtorsSelected();
                if (keys) {
                    window.location.href = $downloadReportUrl + $.param({debtorIds:keys});
                }
            }
            return false;
        });
    }
    
    prepareEvents();
    
    /*dynagridDebtors.find(".select-on-check-all").change(function(){
        eventAllDebtorsSelected();
    });
    
    dynagridDebtors.find(".sgkh-debtor-check").change(function(){
        debtorSeletionChanged();
    });
    
    $("#dynagrid-debtors-selected-debtors-msg-2").click(function(){
        eventAllDebtorsSelectedTotal();
    });*/
    
    /*debtorsChangeStatusLink.click(function(){
        //var tempHtml = $("#debtor-status-temp").html();
        //$("#statusesModal").find('.modal-body').html(tempHtml).modal('show');
        $("#statusesModal-temp").modal('show');
    });*/
        
JS
);