<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    $(".select_show").trigger("change");
});
function add_new_bank() {
    var idx = $('.bank-item').length;
    $('.add-load').show();
    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('grantee/submission/get_partial_bank') ?>/'+ idx,
        dataType: 'JSON',
        success: function(r) {
            var html = r;
            $('#wrap-bank').append(html);
            $('.add-load').hide();
            $('input.check_default').on('change', function() {
                $('input.check_default').not(this).prop('checked', false);  
            });
            $('.bank-name').on('change', function() {
                $(this).closest('div').find('.bank-name-validation').addClass('hide');
            });
            $('.bank-address').on('change', function() {
                $(this).closest('div').find('.bank-address-validation').addClass('hide');
            });
            $('.beneficiary-name').on('change', function() {
                $(this).closest('div').find('.beneficiary-name-validation').addClass('hide');
            });
            $('.account-number').on('change', function() {
                $(this).closest('div').find('.account-number-validation').addClass('hide');
            });
        }
    });
}

function del_item(el, item_class) {
    if (confirm("Are you sure want to delete this ?"))
        $(el).closest('.' + item_class).remove();
}

function del_item_db(el, item_class, id) {
    if (confirm("Are you sure want to delete this ?"))
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('grantee/submission/delete_bank_info') ?>/'+ id,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    $(el).closest('.' + item_class).remove();
                }
            }
        });
}

$('input.check_default').on('change', function() {
     if ($("input[type='checkbox']:checked").length){
        $('input.check_default').not(this).prop('checked', false);  
     }else{
        alert ('Please select one Bank Info as default');
        $(this).prop('checked', true);
     }
});

$("#btn-save-bank").on('click', function() {
    var wrap_bank = $('#wrap-bank');
    var bank_item = wrap_bank;

    var bank_information = bank_item.find('.bank-item');
    var invalid = false;

    bank_information.each(function() {

        var bank_item_name = $(this).find('.bank-name').val();
        if (bank_item_name != '') {
            $(this).closest('div').find(".bank-name-validation").addClass('hide');
        } else {
            $(this).closest('div').find(".bank-name-validation").removeClass('hide');
            invalid = true;
        }

        var bank_item_address = $(this).find('.bank-address').val();
        if (bank_item_address != '') {
            $(this).closest('div').find(".bank-address-validation").addClass('hide');
        } else {
            $(this).closest('div').find(".bank-address-validation").removeClass('hide');
            invalid = true;
        }

        var bank_item_beneficiary = $(this).find('.beneficiary-name').val();
        if (bank_item_beneficiary != '') {
            $(this).closest('div').find(".beneficiary-name-validation").addClass('hide');
        } else {
            $(this).closest('div').find(".beneficiary-name-validation").removeClass('hide');
            invalid = true;
        }

        var bank_item_account = $(this).find('.account-number').val();
        if (bank_item_account != '') {
            $(this).closest('div').find(".account-number-validation").addClass('hide');
        } else {
            $(this).closest('div').find(".account-number-validation").removeClass('hide');
            invalid = true;
        }

    });
    if (invalid == true) {
        $(".btn-submit-travel-disabled").each(function(){
            $(this).addClass('hide');
        });
        $(this).removeClass("hide");
        return false;
    }
});

$('.bank-name').on('change', function() {
    $(this).closest('div').find('.bank-name-validation').addClass('hide');
});
$('.bank-address').on('change', function() {
    $(this).closest('div').find('.bank-address-validation').addClass('hide');
});
$('.beneficiary-name').on('change', function() {
    $(this).closest('div').find('.beneficiary-name-validation').addClass('hide');
});
$('.account-number').on('change', function() {
    $(this).closest('div').find('.account-number-validation').addClass('hide');
});

function show_hide_transportation(obj, section, index){
    if($(obj).val() == 'No' || $(obj).val() == ''){
        $('.section-transportation-'+section+'-'+index).addClass('hide');
    }else{
        $('.section-transportation-'+section+'-'+index).removeClass('hide');
    }

    if($(obj).val() == 'Reimbursement'){
        $('#label_eticket_'+section+'_'+index).html('Receipt')
    }else{
        $('#label_eticket_'+section+'_'+index).html('E-Ticket')
    }

}

function show_hide_accomodation(obj, section, index){
    if($(obj).val() == 'No' || $(obj).val() == ''){
        $('.section-accomodation-'+section+'-'+index).addClass('hide');
    }else{
        $('.section-accomodation-'+section+'-'+index).removeClass('hide');
    }

    if($(obj).val() == 'Reimbursement'){
        $('#label_voucher_hotel_'+section+'_'+index).html('Receipt')
    }else{
        $('#label_voucher_hotel_'+section+'_'+index).html('Hotel Voucher')
    }

}
$(".datepicker").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: "dd M yy",
    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
});
</script>