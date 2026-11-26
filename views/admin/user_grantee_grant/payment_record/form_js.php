<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>

<script>
    const SITE_URL = '<?php echo site_url(); ?>';

    var MEMO_BUDGET = [];

    <?php 
        if (isset($memo_budget) && $memo_budget) {
        foreach ($memo_budget as $memo_budget) { 
    ?>
        MEMO_BUDGET.push({ 
            id: parseInt(<?php echo $memo_budget->id; ?>, 10),
            is_active: "<?php echo $memo_budget->is_active; ?>",
            value : "<?php echo $memo_budget->file_name; ?>" 
        });
    <?php } } ?>

    function show_pcode(el_country, el_pcode) {
        var country_code = $('#' + el_country + ' option:selected').attr('data-pcode');
        if (country_code != undefined)
            $('#' + el_pcode).val('+' + country_code);
    }

    function del_item(el, item_class) {
        var deleted = $("#delete_detail_payment").val();
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('#' + item_class).remove();
            var id = $(el).attr('id');
            if(deleted == ''){
                $("#delete_detail_payment").val(id);
            }else{
                var join_id = deleted + ',' + id;
                $("#delete_detail_payment").val(join_id);
            }
    }

    function del_item_payment(el, item_class) {
        var grantee_id = $("#grantee_id").val();
        if (confirm("Are you sure want to delete this ?"))
            var id = $(el).data('id');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/request_payment/delete_payment') ?>',
                dataType: 'JSON',
                data:{id: id, grantee_id : grantee_id},
                success: function(r) {
                    if(r.success == true){
                        window.location.href = r.redirect;
                    }
                }
            });
    }

    function del_item_id(el, item_class) {
        var deleted = $("#delete_detail_payment_record_non_grantee").val();
        if (confirm("Are you sure want to delete this ?")) 
            $(el).closest('#' + item_class).remove();
            var id = $(el).data('id');
            if(deleted == ''){
                $("#delete_detail_payment_record_non_grantee").val(id);
            }else{
                var join_id = deleted + ',' + id;
                $("#delete_detail_payment_record_non_grantee").val(join_id);
            }
    }

    function add_item(i) {
        var name_class = '.request-item'+i;
        var warp_request = '#wrap-request'+i;
        var idx = $(name_class).length;
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_item') ?>?idx='+ idx + '&i=' + i,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
            }
        });
    }

    function add_item_record(i, change_category = false) {
        if (change_category) {
            $("#wrap-request-record0").html('');
        }

        var name_class = '.request-item-record'+i;
        var warp_request = '#wrap-request-record'+i;
        var category = 'select[name="add_record[category_id]"]';
        var thirt_party = '#third_party_payment_add_record';
        if($(thirt_party).val() == 0 && $(category).val() == ''){
            $(".category-validation-add_record ").removeClass('hide');
            return;
        }
        var idx = $(name_class).length;
        var category_value = $(category).val();
        if(category_value == undefined){
            category_value = 'Third Party';
        }
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_item_grant_record') ?>?idx='+ idx + '&i=' + i + '&category=' + category_value,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $(".select2").select2({
                templateResult: function (data) {
                    if (data.id === '__add_new__') {
                        return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> ' + data.text + '</span>');
                    }
                    return data.text;
                }
                });
            }
        });
    }

    function edit_item_record(i, change_category = false) {
        if (change_category) {
            $("[id^=btn_delete]").each(function() {
                var id = $(this).data("id");
                var $input = $("#delete_detail_payment_record"); 
                
                var deleted = $input.val();

                if (deleted === '' || deleted == undefined) {
                    $input.val(id);
                } else {
                    var ids = deleted.split(','); 
                    if (!ids.includes(String(id))) { 
                        ids.push(id);
                        $input.val(ids.join(','));
                    }
                }
            });
            $("#wrap-request-record-edit0").html('');
        }

        var name_class = '.request-item-record-edit';
        var warp_request = '#wrap-request-record-edit'+i;
        var category = 'select[name="edit_record[category_id]"]';
        var idx = $(name_class).length;
        var thirt_party = '#third_party_payment_edit_record';
        if($(thirt_party).val() == 0 && $(category).val() == ''){
            $(".category-validation-edit_record ").removeClass('hide');
            return;
        }
        var category_value = $(category).val();
        if(category_value == undefined){
            category_value = 'Third Party';
        }
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/edit_item_grant_record') ?>?idx='+ idx + '&i=' + i + '&category=' + category_value,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $(".select2").select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });
            }
        });
    }

    function ordinal_suffix_of(i) {
        var j = i % 10,
            k = i % 100;
        if (j == 1 && k != 11) {
            return i + "st";
        }
        if (j == 2 && k != 12) {
            return i + "nd";
        }
        if (j == 3 && k != 13) {
            return i + "rd";
        }
        return i + "th";
    }

    function add_payment() {
        var idx = $('.payment-item').length;
        var suffix = ordinal_suffix_of((idx+1));
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_payment') ?>?idx='+ idx + '&suffix=' + suffix,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-payment').append(html);
                $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd M yy",
                yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
                $('input[type="text"], input[type="email"]').attr('autocomplete','new-password');
            }
        });
    }

    function del_file(el, name, label,value='') {
        if (confirm("Are you sure want to delete " + label + " ?")) {
            var html = '<input type="hidden" name="' + name + '" value="' + value + '">';
            $(el).parent().replaceWith(html);
        }
    }

    function submit_payment() {
        $("#content").show();
        $("#btn-action").show();
        event.preventDefault();
    }

$("#grants").change(function() {
    var pid = $('#grants').val();
    $("#load-grantee").show();
    $('#grantee').html('');
    $('#grantee').append('<option value="">-- Choose Grantee --</option>');
    $.ajax({
        url: '<?= site_url('admin/grantee/ajx_get_by_grants') ?>' + '/' + pid,
        success: function(data) {
            $.each(data, function(id, val) {
                $('#grantee').append('<option value="' + val.id + '">' + val.first_name + ' ' + val.last_name + '</option>');
            });
            $("#load-grantee").hide();
        }
    });
});

    $("#btn-deleted").click(function(){
        $("#mdl_info").modal();    
        event.preventDefault();
    });

    // $("#btn-submit-record").click(function(){
    //     $('#hide-btn').prop( "disabled", false );
    //     $('#hide-btn-edit').prop( "disabled", true );
    //     $.ajax({
    //         type: 'POST',
    //         url: '<?php echo site_url('admin/request_payment/validate_payment') ?>',
    //         dataType: 'JSON',
    //         data:$("#form").serializeArray(),
    //         success: function(r) {
    //             if(r.success == true){
    //                 $("#mdl_validate").modal(); 
    //                 $("#mdl_add_record").modal('hide'); 
    //                 $("#validate_message").html(r.message); 
    //                 event.preventDefault();
    //             }else{
    //                 $("#btn-submit-record").prop("type", "submit");
    //                 $("#form").submit();
    //             }
    //         }
    //     });
        
    // })

    // $("#btn-submit-record-edit").click(function(){
    //     $('#hide-btn').prop( "disabled", true );
    //     $('#hide-btn-edit').prop( "disabled", false );
    //     $.ajax({
    //         type: 'POST',
    //         url: '<?php echo site_url('admin/request_payment/validate_payment') ?>',
    //         dataType: 'JSON',
    //         data:$("#form").serializeArray(),
    //         success: function(r) {
    //             if(r.success == true){
    //                 $("#mdl_validate").modal(); 
    //                 $("#mdl_edit_record").modal('hide'); 
    //                 $("#validate_message").html(r.message); 
    //                 event.preventDefault();
    //             }else{
    //                 $("#btn-submit-record").prop("type", "submit");
    //                 $("#form").submit();
    //             }
    //         }
    //     });
        
    // })

    $("#btn-calculate").click(function(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/request_payment/calculate_payment') ?>',
            dataType: 'JSON',
            data:$("#form").serializeArray(),
            success: function(r) {
                if(r.success == true){
                    $("#mdl_validate").modal(); 
                    $("#validate_message").html(r.message); 
                    event.preventDefault();
                }
            }
        });
        
    })

    $('#mdl_add_record, #mdl_add_record_bulk').on('show.bs.modal', function () {
        $.fn.modal.Constructor.prototype.enforceFocus = function () { };
        $('.modal-footer, .hide-view').removeClass('hide')
        <?php if (has_permission('payment_record', 'upload_proof_of_expense')) { ?>
            $('.additional-proof-of-expense').html('');
            $('.btn-add-proof-expense').trigger('click');
        <?php } else { ?>
            $('.additional-proof-of-expense').html('<a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> You do not have permission to upload proof of expense</label></a>');
        <?php } ?>
        
    });

    // write edit review
    $('#mdl_edit_record').on('show.bs.modal', function(event){
      $.fn.modal.Constructor.prototype.enforceFocus = function () { 

        var button = $(event.relatedTarget);
        var recordId = button.data('record_id');
        var mode = button.data('mode');
        $("#delete_detail_payment_record").val('');

        if(typeof currentPaymentGrant !== 'undefined'){
            var data = currentPaymentGrant[recordId];

            var baseUrl = window.location.origin;
            $('#payment_id').val(data.id);
            
            $('#payment_date').datepicker("setDate", new Date(data.payment_date));
            
            if (data.deadline_date != null) {
                $("#edit_record_deadline_date").datepicker("setDate", new Date(data.deadline_date));
            } else {
                $("#edit_record_deadline_date").val('');
            }
            
            if (data.user_grantee_id != null) {
                $("select[name='edit_record[user_grantee_id]']").val(data.user_grantee_id);
                //$(".select-category-section").removeClass('hide');
            } else {
                $("select[name='edit_record[user_grantee_id]']").val('');
                //$(".select-category-section").addClass('hide');
            }

            if (data.priority != null) {
                $("#edit_record_priority").val(data.priority)
            } else {
                $("#edit_record_priority").val("")
            }
            $('#description').val(data.description);
            $('#release_type').val(data.release_type);
            $('#admin_note').val(data.admin_note);
            $('#finance_note').val(data.finance_note);
            $('#record_status').val(data.status);
            $('#hide-total-payment-record').val(data.total_nominal);
            $('#third_party_payment_edit_record').val(data.third_party_payment);
            $('#vendor_id').val(data.vendor_id).trigger('change');
            var select_memo = $('select[name="edit_record[user_grantee_grant_memo_id]"]');
            select_memo.find('option.memo-budget-inactive').prop('hidden', true).prop('disabled', true).hide();
            var conMemoNull = data.user_grantee_grant_memo_id !== null && data.user_grantee_grant_memo_id !== undefined && data.user_grantee_grant_memo_id !== '' && data.user_grantee_grant_memo_id !== '0';
            if (conMemoNull) {
                var current_memo_opt = select_memo.find('option[value="' + data.user_grantee_grant_memo_id + '"]');
                current_memo_opt.prop('hidden', false).prop('disabled', false).show();
            }
            select_memo.val(conMemoNull ? data.user_grantee_grant_memo_id : '');
            $('select[name="edit_record[third_party_payment]"]').val(data.third_party_payment);
            $('select[name="edit_record[category_id]"]').val(data.category);
            $('#approve_by').val(data.approve_by);

            if (data.vendor_id == 0) {
                $('.section-edit-vendor-address').addClass('hide');
                $('.section-vendor-name').removeClass('hide');
                $('input[name="edit_record[third_party_vendor_name]"').val(data.third_party_vendor_name);
                $('input[name="edit_record[third_party_beneficiary_name]"').val(data.third_party_beneficiary_name);
                $('input[name="edit_record[third_party_bank_name]"').val(data.third_party_bank_name);
                $('textarea[name="edit_record[third_party_bank_address]"').val(data.third_party_bank_address);
                $('input[name="edit_record[third_party_account_number]"').val(data.third_party_account_number);
                $('input[name="edit_record[third_party_swift_code]"').val(data.third_party_swift_code);
                $('input[name="edit_record[third_party_routing_number]"').val(data.third_party_routing_number);
            } else {
                $('.section-edit-vendor-address').removeClass('hide');
                $('.section-vendor-name').addClass('hide');
            }

            if (data.third_party_payment == 1) {
                $(".edit-parent-vendor").removeClass('hide');
            } else {
                $(".edit-parent-vendor").addClass('hide');
            }
            
            
            if(data.third_party_payment == 1){
                $("#category_payment_edit").addClass("hide");
            }

            var panelist_id = data.payment_for == 'panellist' ? data.panellist_id : data.vendor_id;

            if(data.payment_for == 'vendor'){
                $("#radio-vendor").prop("checked", true).trigger('change');
                select_hotel(0,'edit', panelist_id);
                select_panellist(0, 'edit', panelist_id);
                $('#panellist_id_edit').val('');
                $('#hotel_id_edit').val(data.vendor_id).trigger('change');
            }else if(data.payment_for == 'panellist'){
                $("#radio-panellist").prop("checked", true).trigger('change');
                select_hotel(0,'edit', panelist_id);
                select_panellist(0, 'edit', panelist_id);
                $('#hotel_id_edit').val('');
                $('#panellist_id_edit').val(data.panellist_id).trigger('change');
            }else if(data.payment_for == 'grantee') {
            
            }else{
                $("#radio-grantee").prop("checked", false);
                $("#radio-panellist").prop("checked", false);
                $("#radio-vendor").prop("checked", false);
                $(".sec-vendor").addClass('hide')
                $(".sec-panellist").addClass('hide')
            }

            if(data.notify_finance == 1){
                $('#edit_notify_finance').val(data.notify_finance);
            }
            if(data.notify_admin == 1){
                $('#edit_notify_admin').val(data.notify_admin);
            }
            if(data.proof != null){
                $('#proof_btn').css("display", "block");
                $('#proof_btn').attr("href", "<?= site_url()?>" + data.proof)
            }else{
                $('#proof_btn').css("display", "none");
            }
            if(data.proof_expense != null){
                $('#proof_expense_btn').css("display", "block");
                $('#proof_expense_btn').attr("href", "<?= site_url()?>" + data.proof_expense)
            }else{
                $('#proof_expense_btn').css("display", "none");
            }
            
            if (data.proof != null) {
                    $("#preview-edit-uploaded-transfer-grant").removeClass('hide');
                    $("#preview-edit-not-uploaded-transfer-grant").addClass('hide');
                    $('#preview-edit-uploaded-transfer-grant').find('a').attr("href", SITE_URL + data.proof);
                } else {
                    $("#preview-edit-uploaded-transfer-grant").addClass('hide');
                    $("#preview-edit-not-uploaded-transfer-grant").removeClass('hide');
                }
                
                if (data.proof_expense != null) {
                    $("#preview-edit-uploaded-expense").removeClass('hide');
                    $('#preview-edit-uploaded-expense').find('a').attr("href", SITE_URL + data.proof_expense);
                    $('#preview-edit-not-uploaded-expense').addClass('hide');
                } else {
                    $('#preview-add-not-uploaded-transfer-grant').removeClass('hide');
                    $(".default-payment-attachment").addClass('hide');
                }

                if (data.proof_of_conversion != null) {
                    $("#preview-edit-uploaded-conversion-grant").removeClass('hide');
                    $("#preview-edit-not-uploaded-conversion-grant").addClass('hide');
                    $('#preview-edit-uploaded-conversion-grant').find('a').attr("href", SITE_URL + data.proof_of_conversion);
                } else {
                    $("#preview-edit-uploaded-conversion-grant").addClass('hide');
                    $("#preview-edit-not-uploaded-conversion-grant").removeClass('hide');
                    <?php if (has_permission('payment_record', 'upload_proof_of_expense')) { ?>
                        $('.additional-proof-of-expense').html('');
                        $('.btn-add-proof-expense-edit').trigger('click');
                    <?php } ?>
                }
            $('#wrap-request-record-edit0').html('');
            for (var i = 0; i < data.items.length; i++) {
                $('#request-item-record-edit-'+i).remove();
                var html = append_edit_record(i, recordId);
                $('#wrap-request-record-edit0').append(html);
                setoption('select_payment_item_edit'+i, false, data.items[i]);
            }
            $('.select2').select2({
                theme: 'bootstrap'
            });
            $.each( data.items, function( key, value ) {
                setoptionSubCategory('select_sub_category_edit'+key, false, data);
                $('#select_sub_category_edit'+key).val(value.payment_sub_category_id).trigger('change');
                // $('#select_payment_item_edit'+key).val(value.payment_item).trigger('change');
                $('#nominal_idr_edit'+key).val(value.nominal_idr);
                $('#nominal_edit'+key).val(value.nominal);
                $('#id'+key).val(value.id);
                $('#btn_delete'+key).attr('data-id', value.id);
            });
            do_format_input_currency();
            if(mode == 'view'){
                $('.form-control-view').prop('disabled', true)
                $('.modal-footer, .hide-view').addClass('hide')
                $('#modalLabelEdit').text('View Payment Record')
                if(data.bulk_id){
                    $('#modalLabelEdit').text('View Panelist Payment')
                }
            }else{
                $('.form-control-view').prop('disabled', false)
                $('.modal-footer, .hide-view').removeClass('hide')
                $('#modalLabelEdit').text('Edit Grant Payment Record')
                if(data.bulk_id){
                    $('.form-control-view').prop('disabled', true)
                    $('#modalLabelEdit').text('Edit Panelist Payment')
                    $('.record-payment-nominal-idr, .payment-detail-id, .proof_of_payment_bulk').prop('disabled', false)
                    $('.record-payment-nominal').prop('disabled', false)
                    $('.section-button-addnew-edit').addClass('hide')
                    $('.modal-footer, .proof_of_payment_bulk').removeClass('hide')
                }
            }
            <?php 
                $hide_upload_expense = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_expense')) {
                    $hide_upload_expense = '';
                }
            ?>

            let has_permission = '<?php echo $hide_upload_expense; ?>';
            let proof_of_expenses = currentPaymentProofOfExpenses.filter(item => item.relation_id == recordId);
            if (proof_of_expenses.length > 0) {
                $('.additional-proof-of-expense-edit').html('');
            } else {
                $('.additional-proof-of-expense-edit').html('<a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a>');
            }
            $.each(proof_of_expenses, function (index, proof_of_expense) {
                var html = `
                    <div class="mb-3 payment-attachment">
                        <button class="btn btn-danger btn-xs pull-right ${has_permission}" type="button" onclick="remove_attachment(this, 'edit_record[remove_expense_attachment_ids]', ${proof_of_expense.id}, 'form'); return false;">
                            <i class="fa fa-times"></i>
                        </button>
                        <div id="preview-edit-uploaded-expense-grant-${index}" class="attachment-uploaded">
                            <a href="${SITE_URL + proof_of_expense.filepath}" target="_blank" class="lightbox">
                                <label class="label label-primary" style="cursor:pointer;">View Proof</label>
                            </a>
                        </div>
                    </div>
                `;

                $('.additional-proof-of-expense-edit').append(html);
                $('.lightbox').topbox();
            });
            $('.selectpicker').selectpicker('refresh');
        }
      };
    });

    function setoption(ddlID, isFirstOptionEmpty, data) {
        // var arr = currentPaymentItemsGrant;
        var arr = function () {
            var tmp = null;
            $.ajax({
                'async': false,
                type: 'POST',
                url: '<?php echo site_url('admin/payment_item/get_payment_item') ?>',
                data: {
                    'category_type': data.category_type,
                    'sub_category': data.payment_sub_category_id,
                },
                dataType: 'html',
                success: function(data) {
                    tmp = data;
                }
            });
            return tmp;
        }();
        arr = JSON.parse(arr);
        let current_data = data;
        setDDLValues(ddlID, isFirstOptionEmpty, arr, data);
    }

    function setDDLValues(ddlID, isFirstOptionEmpty, arr, data = undefined) {
        clearDDL(ddlID);

        if (isFirstOptionEmpty) {
            $('#' + ddlID).append("<option value=''>All</option>");
        }
        
        for (var i = 0; i < arr.length; i++) {
            let selected = '';
            
            if (arr[i].id == data.payment_item) {
                selected = 'selected';
            }

            $('#' + ddlID).append("<option value='" + arr[i].id + "' "+ selected +">" + arr[i].payment_item + "</option>");
        }
    }

    function clearDDL(ddlID) {
        $("." + ddlID).prop('');
    }
    
    function update_to_release(event){
        var modal = $(event).data("modal");
        var active_country = <?= $this->session->userdata('active_country') ?>;
        var status = active_country == "1" ? "4" : "2";
        $("#"+modal+" .status").val(status);
    }

    function append_edit_record(i, recordId) {
        var name_class = '.request-item-record-edit'+i;
        var warp_request = '#wrap-request-record-edit'+i;
        var idx = $(name_class).length;
        var html = '';
        var active_country = <?= $this->session->userdata('active_country') ?>;
        let form = $("#edit_record_deadline_date");
        let form_name = 'form_payment';
        if (form.length > 0 && form.attr('form') == 'form') {
            form_name = 'form';
        }
        
        html = '<div id="request-item-record-edit-'+i+'" class="row request-item-record-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Sub Category</label>'
        html += '<select onchange="select_edit_payment_item_record(\''+i+'\', '+recordId+')"  form="'+form_name+'" id="select_sub_category_edit'+i+'" name="edit_record[items]['+i+'][sub_category]" class="record-payment-sub-category form-control form-control-view select2 select_sub_category_edit">'
        html += '</select>'
        html += '<div class="text-danger invalid-tooltip record-payment-sub-category-validation hide" style="display: block;">Sub Category is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select form="'+form_name+'" onchange="remove_error(' + "'" + 'record-payment-item-validation' + "'" +')" id="select_payment_item_edit'+i+'" name="edit_record[items]['+i+'][item]" class="record-payment-item form-control form-control-view select2 select_payment_item_edit">'
        html += '</select>'
        html += '<div class="text-danger invalid-tooltip record-payment-item-validation hide" style="display: block;">Payment Item is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal IDR</label>'
        html += '<input form="'+form_name+'" onchange="remove_error(' + "'" + 'record-payment-nominal-validation-idr' + "'" +')" type="text" id="nominal_idr_edit'+i+'" class="currency-idr record-payment-nominal-idr form-control form-control-view" name="edit_record[items]['+i+'][nominal_idr]">'
        html += '<div class="text-danger invalid-tooltip record-payment-nominal-validation-idr hide" style="display: block;">Nominal (IDR) is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal USD</label>'
        html += '<input form="'+form_name+'" onchange="remove_error(' + "'" + 'record-payment-nominal-validation' + "'" +')" type="text" id="nominal_edit'+i+'" class="currency-usd record-payment-nominal form-control form-control-view" name="edit_record[items]['+i+'][nominal]">'
        html += '<input form="'+form_name+'" type="hidden" id="id'+i+'" class="form-control" name="edit_record[items]['+i+'][id]">'
        html += '<div class="text-danger invalid-tooltip record-payment-nominal-validation hide" style="display: block;">Nominal (USD) is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '<a href="javascript:;" onclick="del_item_id(this, \'request-item-record-edit-'+i+'\')" class="btn btn-danger hide-view" id=btn_delete'+i+' style="position:absolute;right:15px;"><i class="fa fa-trash fa-fw"></i></a>'
        html += '</div>'

        return html;
        
    }
    
    function select_payment_item_record(i) {
        var sub_category = 'select_sub_category_record_'+i;
        var payment_item = 'select_payment_item_record_'+i;
        $('#' + payment_item).html('');
        $('#' + payment_item).append('<option value="">-- Select Item --</option>');

        if($('#' + sub_category).val() != '__add_new__' ){
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/request_payment/get_payment_item_by_sub_category') ?>/' + $('#' + sub_category).val(),
                dataType: 'JSON',
                success: function(r) {
                    $.each(r, function(id, val) {
                        if ($('#' + payment_item + ' option[value="' + val.id + '"]').length === 0) {
                            $('#' + payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                        }
                    });
                    $('#' + payment_item).append('<option value="__add_new__" data-type="payment_item" data-category="category_non_grantee" data-subcategory="select_sub_category_record_'+i+'"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
                }
            });
        }

        $("#" + sub_category).closest('div').find('.record-payment-sub-category-validation').addClass('hide');
    }
    
    function select_edit_payment_item_record(i, recordId) {
        var sub_category = 'select_sub_category_edit_'+i;
        var payment_item = 'select_payment_item_edit_'+i;
        $('#' + payment_item).empty();
        $('#' + payment_item).html('');
        $('#' + payment_item).append('<option value="">-- Select Item --</option>');
        if($('#' + sub_category).val() != '__add_new__' ){
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/request_payment/get_payment_item_by_sub_category') ?>/' + $('#' + sub_category).val(),
                dataType: 'JSON',
                success: function(r) {
                    $.each(r, function(id, val) {
                        var data = currentPaymentGrant[recordId];
                        $('#' + payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                        if(data){
                            $('#' + payment_item).val(data.items[i].payment_item).trigger('change');
                        }
                    });
                    $('#' + payment_item).append('<option value="__add_new__" data-type="payment_item" data-category="category_non_grantee" data-subcategory="select_sub_category_edit_'+i+'"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
                }
            });
        }
        $("#" + sub_category).closest('div').find('.record-payment-sub-category-validation').addClass('hide');
    }

    function setoptionSubCategory(ddlID, isFirstOptionEmpty, data) {
        // var arr = currentSubCategoryRecord;
        var category = data.category == '' || data.category == null ? 'Third Party' : data.category;
        var arr = function () {
            var tmp = null;
            $.ajax({
            'async': false,
            type: 'POST',
            url: '<?php echo site_url('admin/payment_item/get_sub_category') ?>',
            data: {
                'category_type': category
            },
            dataType: 'html',
            success: function(data) {
                tmp = data;
            }
        });
            return tmp;
        }();
        arr = JSON.parse(arr);
        setDDLValuesSubCategory(ddlID, isFirstOptionEmpty, arr);
    }

    function setDDLValuesSubCategory(ddlID, isFirstOptionEmpty, arr) {
        clearDDL(ddlID);

        if (isFirstOptionEmpty) {
            $('#' + ddlID).append("<option value=''>All</option>");
        }

        for (var i = 0; i < arr.length; i++) {
            $('#' + ddlID).append("<option value='" + arr[i].id + "'>" + arr[i].name + "</option>");
        }
    }

    function showVendor(el, active_country)
    {
        var active_country = <?= $this->session->userdata('active_country') ?>;
        if(active_country == 2){
            
            var hide_object = $(el).data('hide-object')
            if ($(el).val() == '1'){
                $("." + hide_object).removeClass("hide")
            } else {
                $("." + hide_object).addClass("hide")
            }
        }
    }

    $(document).ready(function() {
        $(".select2").select2({
          templateResult: function (data) {
              if (data.id === '__add_new__') {
                  return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> ' + data.text + '</span>');
              }
              return data.text;
          }
        });

        $(".datepicker-notification").datepicker({
            minDate: 1 // 1 = besok
        });

        $(".vendor").change(function(){
            var vendor_id = $(this).val();

            // for select other
            if (vendor_id == 0) {
                $(".edit-vendor-address").prop('disabled', false).val('');
                $(".edit-beneficiary-name").prop('disabled', false).val('');
                $(".edit-bank-name").prop('disabled', false).val('');
                $(".edit-bank-address").prop('disabled', false).val('');
                $(".edit-account-number").prop('disabled', false).val('');
                $(".edit-swift-code").prop('disabled', false).val('');
                $(".edit-routing-number").prop('disabled', false).val('');

                $(".section-edit-vendor-address").addClass('hide');
                $('.section-vendor-name').removeClass('hide');
                return false;
            } else {
                $('.section-edit-vendor-address').removeClass('hide');
                $('.section-vendor-name').addClass('hide');
            }

            var mode = $(this).data('mode');
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/vendor/get_data_ajax_by_id') ?>/',
                data: {id: vendor_id},
                dataType: 'JSON',
                success: function(r) {

                    let third_party_payment = $('select[name="edit_record[third_party_payment]"]').val();
                    if (r.account_number !== null){    
                        $(".edit-vendor-address").val(r.address).prop('disabled', true)
                        $(".edit-beneficiary-name").val(r.beneficiary_name).prop('disabled', true)
                        $(".edit-bank-name").val(r.bank_name).prop('disabled', true)
                        $(".edit-bank-address").val(r.bank_address).prop('disabled', true)
                        $(".edit-account-number").val(r.account_number).prop('disabled', true)
                        $(".edit-swift-code").val(r.swift_code).prop('disabled', true)
                        $(".edit-routing-number").val(r.routing_number).prop('disabled', true)
                    } 

                    if (third_party_payment == 1) {
                        $(".edit-parent-vendor").removeClass('hide');
                    } else {
                        $(".edit-parent-vendor").addClass('hide');
                    }
                }
            });
        })

        $('.tab-grants').each(function(i, obj) {
            var pid = $(this).data("pid");
            var upid = $(this).data("upid");
            var uid = $('#uid').val();
            var act_id = 0;
			if (pid == 10)
				act_id = $('#chg_activity_' + pid).val();
            var attr_content = $("#content_" + upid);

            $.ajax({
                url: '<?= site_url('admin/alumni/ajx_get_properties') ?>' + '/' + pid + '/' + uid + '/' + act_id + '/' + upid,
                success: function(data) {
                    attr_content.html(data);
                }
            });


            if (pid == 10) {
                if ($('#chg_activity_' + pid).length) {
                    $('#chg_activity_' + pid).on('change', function() {
                        var act_id = $(this).val();
                        var load_id = '#load-' + pid;
                        $(load_id).show();

                        if (act_id == undefined) {
                            act_id = 0;
                        }

                        $.ajax({
                            url: '<?= site_url('admin/alumni/ajx_get_properties') ?>' + '/' + pid + '/' + uid + '/' + act_id + '/' + upid,
                            success: function(data) {
                                attr_content.html(data);
                                $(load_id).hide();
                            }
                        });
                    })
                }
            }
        });

        //Payment International Travel Validation
        $("#btn-submit-record, #btn-submit-record-edit").on('click', function() {
            $('select[name="edit_record[user_grantee_grant_memo_id]"] option:selected').prop('disabled', false);
            $(this).addClass("hide");

            $(".btn-submit-record-disabled").each(function(){
                $(this).removeClass('hide');
            });
            var action = $(this).data('action');
            var payment_date = $(".payment-date-record").val();
            if (payment_date == '') {
                var dt = $("#payment_date").val();
                payment_date = dt;
            }
            
            var invalid = false;
            if (payment_date == '') {
                $(".payment-date-record-validation").removeClass('hide');
                invalid = true;
            }

            // if(action == 'create'){
            //     const isChecked = $('input[name="add_record[payment_for]"]:checked').length > 0;
            //     if (!isChecked) {
            //         $(".paymentfor-validation").removeClass('hide');
            //     }
            //     invalid = true;
            // }
            
            var payment_item_create = $('#wrap-request-record0');
            var paymnet_item_edit = $("#wrap-request-record-edit0");
            
            var payment_item = payment_item_create;
            if (action != 'create') {
                var payment_item = paymnet_item_edit;
                var status = $("#record_status").val();
                var action_category = "edit_record";
            }else{
                var action_category = "add_record";
                var status = $("#record_status_add").val();
            }

            var active_country = <?= $this->session->userdata('active_country') ?>;
            if(active_country = 1)
            {
                var category = 'select[name="'+action_category+'[category_id]"]';
                var third_party = $("#third_party_payment_" + action_category).val();
                if($(category).val() == '' && third_party == 0){
                    $(".category-validation-" + action_category).removeClass('hide');
                    invalid = true;
                }
            }
            
            var payment_sub_category = payment_item.find('.payment-item-section');
            payment_sub_category.each(function() {
                var payment_sub_category_value = $(this).find('.record-payment-sub-category').val();
        
                if (payment_sub_category_value == null) {
                    invalid = true;
                    $(this).closest('div').find(".record-payment-sub-category-validation").removeClass('hide');
                }else if (payment_sub_category_value != '') {
                    $(this).closest('div').find(".record-payment-sub-category-validation").addClass('hide');
                } else {
                    $(this).closest('div').find(".record-payment-sub-category-validation").removeClass('hide');
                    invalid = true;
                }
                
                var payment_item_list = $(this).find('.record-payment-item').val();
                
                if (payment_item_list != '') {
                    $(this).closest('div').find(".record-payment-item-validation").addClass('hide');
                } else {
                    $(this).closest('div').find(".record-payment-item-validation").removeClass('hide');
                    invalid = true;
                }

                var payment_item_nominal = $(this).find('.record-payment-nominal').val();
                var payment_item_nominal_idr = $(this).find('.record-payment-nominal-idr').val();
                if (payment_item_nominal_idr == '' || payment_item_nominal_idr == 0) {
                    //$(this).closest('div').find(".record-payment-nominal-validation-idr").removeClass('hide');
                    //invalid = true;
                } 

                
                // if (payment_item_nominal == '' || payment_item_nominal == 0) {
                //     $(this).closest('div').find(".record-payment-nominal-validation").removeClass('hide');
                //     invalid = true;
                // } 
                
            });

            if (invalid == true) {
                $(".btn-submit-record-disabled").each(function(){
                $(this).addClass('hide');
                });

                $(this).removeClass("hide");
                return false;
            }

        });

        $(".payment-date-record").on('change', function() {
            $(".payment-date-record-validation").addClass('hide');
        });

        $('.record-payment-sub-category').on('change', function() {
            $(this).closest('div').find('.record-payment-sub-category-validation').addClass('hide');
        });

        $('.record-payment-item').on('change', function() {
            $(this).closest('div').find('.record-payment-item-validation').addClass('hide');
        });

        $('.record-payment-nominal').on('change', function() {
            $(this).closest('div').find('.record-payment-nominal-validation').addClass('hide');
            $(this).closest('div').find('.record-payment-nominal-decimal-validation').addClass('hide');
        });

        $('#select_category_edit').on('change', function() {
            $(this).closest('div').find('.category-validation-edit_record').addClass('hide');
        });

        $('#select_category_add').on('change', function() {
            $(this).closest('div').find('.category-validation-add_record').addClass('hide');
        });

        $('input[name="add_record[payment_date]"]').on('change', function(){
            let val = $(this).val();
            if (val) {
                let date = new Date(val);
                date.setDate(date.getDate() + 7); 

                let options = { day: '2-digit', month: 'short', year: 'numeric' };
                let deadline = date.toLocaleDateString('en-GB', options).replace(',', '');

                $('input[name="add_record[deadline_date]"]').val(deadline);
            }
        });


        $('input[name="add_record_bulk[payment_for]"]').on('change', function(){
            $(".paymentfor-validation-bulk").addClass('hide');
        });

        $('input[name="edit_record[payment_date]"]').on('change', function(){
            let val = $(this).val();
            if (val) {
                let date = new Date(val);
                date.setDate(date.getDate() + 7); 

                let options = { day: '2-digit', month: 'short', year: 'numeric' };
                let deadline = date.toLocaleDateString('en-GB', options).replace(',', '');

                $('input[name="edit_record[deadline_date]"]').val(deadline);
            }
        });

        //End of Payment International Travel Validation
    });

    function remove_error(error_element) {
        $('.' + error_element).addClass('hide');
    }

    function select_panellist(el, mdl, panellist_id = null) { 
        var value_id = $(el).val();
        var panellist_id = panellist_id ? panellist_id : value_id;
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/selection_review/get_panellist') ?>/'+ panellist_id,
            dataType: 'JSON',
            success: function(r) {
                $('#field_of_study_'+mdl).val(r.field_of_study_name);
                $('#panellist_email_'+mdl).val(r.email);
                $('#panellist_telp_'+mdl).val(r.telp);
                $('#panellist_bank_info_'+mdl).val(r.bank_info);
                $('#panellist_beneficiary_'+mdl).val(r.beneficiary_name);
                $('#panellist_account_'+mdl).val(r.account_number);
                $('#panellist_status_'+mdl).val(r.status_panellist_name);
            }
        });
    }

    function select_hotel(el, mdl) {
        var id = $(el).val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/vendor/get_data_ajax_by_id') ?>/',
            data: {id: id},
            dataType: 'JSON',
            success: function(r) {
                $('#hotel_email_'+mdl).val(r.email);
                $('#hotel_telp_'+mdl).val(r.telp);
                $('#hotel_bank_info_name_'+mdl).val(r.bank_name);
                $('#hotel_bank_info_'+mdl).val(r.bank_address);
                $('#hotel_beneficiary_'+mdl).val(r.beneficiary_name);
                $('#hotel_account_'+mdl).val(r.account_number);
                $('#hotel_address_'+mdl).val(r.address);
            }
        });
    }
    
    $('input[type=radio]').change(function() {
        if (this.value == 'panellist') {
            $(".sec-panellist").removeClass('hide')
            $(".sec-grantee").addClass('hide')
            $(".sec-vendor").addClass('hide')
        }else if (this.value == 'grantee') {
            $(".sec-grantee").removeClass('hide')
            $(".sec-panellist").addClass('hide')
            $(".sec-vendor").addClass('hide')
        }
        else {
            $(".sec-vendor").removeClass('hide')
            $(".sec-grantee").addClass('hide')
            $(".sec-panellist").addClass('hide')
        }
    });

    $(".select-grantee").on('change', function(){
        let el = $(this);
        if (Number(el.val()) > 0) {
            //$('.select-category-section').removeClass('hide');
        } else {
            //$('.select-category-section').addClass('hide');
            $('.select-category').val(0).change();
        }
    });

    function remove_file(button, type = undefined, idx = undefined, form_name = undefined) {
        if (confirm("Are you sure you want to remove this file?")) {
            var file_input = button.closest('div').querySelector('input[type="file"]');
            
            if (file_input) {
                file_input.value = '';
            }

            if (type !== undefined) {
                $('.' + type + '-file').addClass('hide');
                $('.' + type + '-no-file').removeClass('hide');
            }

            let attr_form_name = '';
            if (form_name != undefined) {
                attr_form_name = 'form="'+ form_name +'"';
            }

            if (idx != undefined) {
                button.closest('div').insertAdjacentHTML('beforeend', '<input '+ attr_form_name +' type="hidden" name="remove_' + type + '['+idx+']" value="1">');
            } else {
                button.closest('div').insertAdjacentHTML('beforeend', '<input '+ attr_form_name +' type="hidden" name="remove_' + type + '" value="1">');
            }
            
        }
    }

    function remove_attachment(element, name = undefined, id = undefined, form_name = 'form')
    {
        if (confirm("Are you sure you want to remove this file?")) {
            let row = $(element);
            let form = form_name || row.data('form') || 'form';
            let attr_form = 'form="' + form + '"';
            row = row.closest('div');

            // for default field
            if (name == 'default_expense_attachment') {
                row.html('').addClass('hide');
                let html_id = '<input type="hidden" ' + attr_form + ' name="remove_expense" value="' + (id !== undefined ? id : 1) + '">';
                row.append(html_id);
            } else {
                // for add more    
                if (id == undefined) {
                    row.closest('div').remove();
                } else {
                    row.html('').addClass('hide');
                    let input_name = name.endsWith('[]') ? name : name + '[]';
                    let html_id = '<input type="hidden" ' + attr_form + ' name="' + input_name + '" value="' + id + '">';
                    row.append(html_id);
                }
            }
        }
    }

    function add_more_attachment(element) {
        let attachment_button = $(element);
        let attachment_section = attachment_button.data('type');
        let formName = attachment_button.data('form');

        let count = $('.additional-' + attachment_section + ' .payment-attachment').length; 
        
        if (count == 0) {
            $('.additional-' + attachment_section).html('');
        }

        let fileInputId = 'proof-of-expense-' + count;
        let previewId = 'preview-add-not-uploaded-transfer-grant-' + count;
        let atrForm = formName ? 'form="'+formName+'"' : '';

        let html = `
            <div class="mb-3 payment-attachment">
                <button class="btn btn-danger btn-xs pull-right" type="button" onclick="remove_attachment(this);">
                    <i class="fa fa-times"></i>
                </button>
                <input type="file" data-modal="mdl_add_record" id="${fileInputId}" name="${attachment_button.data('input_name')}" ${atrForm}>
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>`;
            
        $('.additional-' + attachment_section).append(html);
    }
    
    // $(document).on('click', '.add-more-grantee', function (e) {
    //     e.preventDefault();

    //     let row_number = $('.row-grantee').length;
    //     let period_id   = $('#period_id').val(),
    //         grant_id    = $('#grant_id').val(),
    //         status      = $('#select-status').val(),
    //         category    = $('.payment_category').val(),
    //         sub_category= $('#sub_category_bulk').val(),
    //         selectedOpt = $('#select-grantee option:selected'),
    //         user_id     = $('#select-grantee').val(),
    //         grantee_name= selectedOpt.data('grantee_name'),
    //         grantee_grant_id = selectedOpt.data('grantee_grant_id');

    //     // --- validation ---
    //     if (!user_id)   return alert('Please Select Grantee.');
    //     if (!category)  return alert('Please Select Category.');
    //     if (!sub_category) return alert('Please Select Sub Category.');

    //     // --- helper untuk ajax sync ---
    //     function getSyncData(url, data = {}) {
    //         let result = null;
    //         $.ajax({
    //             async: false,
    //             type: 'POST',
    //             url: url,
    //             data: data,
    //             dataType: 'html',
    //             success: d => result = d
    //         });
    //         return result;
    //     }

    //     let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
    //         category_type: category, sub_category, country_id: 2
    //     });

    //     let getOptionBankInfo = getSyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + user_id, {
    //         period_id, grant_id, status
    //     });

    //     // --- table header ---
    //     if (row_number === 0) {
    //         $('.table-list-grantee thead').html(`
    //             <tr>
    //                 <th>Grantee</th>
    //                 <th>Payment Item</th>
    //                 <th>Bank</th>
    //                 <th>Nominal IDR</th>
    //                 <th>Nominal USD</th>
    //             </tr>`);
    //     }

    //     // --- row baru ---
    //     let html = `
    //         <tr class="row-grantee">
    //             <td>
    //                 <label class="my-2">${grantee_name}</label>
    //                 <input type="hidden" name="add_record[grantee][${row_number}][user_grantee_id]" value="${user_id}">
    //             </td>
    //             <td>
    //                 <select class="form-control select2 grantee-payment-item" 
    //                         name="add_record[grantee][${row_number}][payment_item]" 
    //                         id="grantee-payment-item${row_number}">
    //                     <option></option>
    //                 </select>
    //             </td>
    //             <td>
    //                 <select class="form-control select2 grantee-bank-info" 
    //                         name="add_record[grantee][${row_number}][grantee_bank_id]" 
    //                         id="grantee-bank-info${row_number}">
    //                     <option></option>
    //                 </select>
    //                 <input type="hidden" class="grantee_grant_id" 
    //                     name="add_record[grantee][${row_number}][grantee_grant_id]" 
    //                     value="${grantee_grant_id}">
    //             </td>
    //             <td><input type="text" class="form-control currency-idr" name="add_record[grantee][${row_number}][nominal_idr]"></td>
    //             <td><input type="text" class="form-control currency-idr" name="add_record[grantee][${row_number}][nominal]"></td>
    //             <td><button type="button" class="btn btn-danger btn-sm remove-grantee"><i class="fa fa-times-circle"></i></button></td>
    //         </tr>`;
        
    //     $('.table-list-grantee tbody').append(html);
    //     $(".select2").select2();

    //     // --- isi dropdown Bank ---
    //     let $bankSelect = $('.list-grantee .row-grantee:last .grantee-bank-info').empty()
    //         .append("<option value=''>Select Bank Account</option>");
    //     if (getOptionBankInfo) {
    //         $.each(JSON.parse(getOptionBankInfo), (i, val) => {
    //             $bankSelect.append(`<option value="${val.id}">${val.bank_name} - ${val.account_number}</option>`);
    //         });
    //     }

    //     // --- isi dropdown Payment Item ---
    //     let $paymentSelect = $('.list-grantee .row-grantee:last .grantee-payment-item').empty()
    //         .append("<option value=''>Select Payment Item</option>");
    //     if (getPaymentItems) {
    //         $.each(JSON.parse(getPaymentItems), (i, val) => {
    //             $paymentSelect.append(`<option value="${val.id}">${val.payment_item}</option>`);
    //         });
    //     }

    //     // --- datepicker ---
    //     $(".datepicker").datepicker({
    //         changeMonth: true,
    //         changeYear: true,
    //         dateFormat: "dd M yy",
    //         yearRange: "<?= date('Y') - 150 ?>:<?= date('Y') + 20 ?>"
    //     });
    // });



    $('.payment_category').on('change', function() {
        var sub_category = 'select[name="add_record[sub_category]"]';
        var payment_item = 'select[name="add_record[payment_items]"]';

        $(sub_category).empty();
        $(sub_category).append('<option value="">-- Select Sub Category --</option>');
        // if($(this).val() != ''){
            get_sub_category($(this).val(),sub_category, payment_item, 'add_record');
        // }
        $(this).closest('div').find('.payment-category-record-validation').addClass('hide');
    });



    function get_sub_category(category_type,select_sub_category,payment_item,param) {
        if(param == 'add_record'){
            $('#wrap-request-record0').find('.request-item-record0').each(function(){
                if($(this).attr('id')!='request-item-record-0'){
                    $(this).remove();
                }
                
                $(payment_item).empty();
                $(payment_item).append('<option value="">-- Select Item --</option>');
            });
        }else if(param == 'edit_record'){
            $('#wrap-request-record-edit0').find('.request-item-record-edit').each(function(){
                if($(this).attr('id')!='request-item-record-edit-0'){
                    $(this).remove();
                }
                
                $(payment_item).empty();
                $(payment_item).append('<option value="">-- Select Item --</option>');
                $('input[name="edit_record[items][0][nominal]"]').val('');
                $('input[name="edit_record[items][0][nominal_idr]"]').val('');
            });
        }
        

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/payment_item/get_sub_category') ?>',
            data: {
                'category_type': category_type
            },
            dataType: 'JSON',
            success: function(r) {

                $.each(r, function(id, val) {
                    $(select_sub_category).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
        });
    }



    // $(document).on('click', '.remove-grantee', function(e) {
    //     e.preventDefault();
    //     var deleted = $("#delete_detail_payment_record_grantee").val();
    //     var deleted_payment = $("#delete_payment_record_grantee").val();
    //     if (confirm("Are you sure want to delete this ?")){
    //         var is_edit = $(this).data('is_edit');
    //         var classRow = is_edit ? '.row-grantee-edit' : '.row-grantee';
    //         $(this).closest(classRow).remove();
    //         var id = $(this).data('id');
    //         var payment_id = $(this).data('payment_id');
    //         if(id){
    //             if (deleted == '') {
    //                 $("#delete_detail_payment_record_grantee").val(id);
    //             } else {
    //                 var join_id = deleted + ',' + id;
    //                 var join_payment_id = deleted + ',' + id;
    //                 $("#delete_detail_payment_record_grantee").val(join_id);
    //             }
                
    //             if (deleted_payment == '') {
    //                 $("#delete_payment_record_grantee").val(payment_id);
    //             } else {
    //                 var join_payment_id = deleted + ',' + payment_id;
    //                 $("#delete_payment_record_grantee").val(join_payment_id);
    //             }
    //         }

    //     }

    // });



    $('.payment_sub_category').on('change', function() {
        var category_type = 'Grant Cost';
        var sub_category = $(this).val();
        var payment_item = '.setup-payment-item';
        
        $(payment_item).empty();
        $(payment_item).append('<option value="">-- Select Item --</option>');
        // if($(this).val() != ''){
            get_payment_item(category_type,sub_category,payment_item,'add_record');
        // }
        $(this).closest('div').find('.payment-sub-category-record-validation').addClass('hide');
    });



    function get_payment_item(category_type, sub_category, payment_item, param){
        $(payment_item).empty();
        $(payment_item).append('<option value="">Select Payment Item</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/payment_item/get_payment_item') ?>',
            data: {
                'category_type': category_type,
                'sub_category': sub_category,
            },
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $(payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                });

                $('.select2').select2({
                    theme: 'bootstrap'
                });
            }
        });
    }

    $(document).ready(function(){

        // function hideValidation(inputSelector, validationSelector) {
        //     $(document).on("change", inputSelector, function(){
        //         if ($(this).val().trim() !== "") {
        //             $(validationSelector).addClass("hide");
        //         }
        //     });
        // }

        // $("#form-payment-grantee").on("submit", function(e){
        //     const validations = [
        //         {input: ".payment-category-record", validation: ".payment-category-record-validation"},
        //         {input: ".payment_sub_category", validation: ".payment-sub-category-record-validation"},
        //         {input: "#record_status_grantee", validation: ".status-validation"},
        //         {input: "#add_from_date", validation: ".from-date-validation"},
        //         {input: "#add_to_date", validation: ".to-date-validation"},
        //         {input: "#disbursment", validation: ".disbursment-validation"},
        //     ];

        //     let valid = true;

        //     // loop setiap pasangan
        //     validations.forEach(v => {
        //         if ($(v.input).val() === "") {
        //             valid = false;
        //             $(v.validation).removeClass("hide");
        //         }
        //     });

        //     // if($(".table-list-grantee tbody tr").length === 0){
        //     //     valid = false;
        //     //     showSwal('warning', 'At least one Grantee must be added', false, true, 1500);
        //     // }

        //     if(!valid){
        //         e.preventDefault();
        //         return false;
        //     }
        // });


        // hideValidation(".payment-category-record", ".payment-category-record-validation");
        // hideValidation(".payment_sub_category", ".payment-sub-category-record-validation");
        // hideValidation("#record_status_grantee", ".status-validation");
        // hideValidation("#add_from_date", ".from-date-validation");
        // hideValidation("#add_to_date", ".to-date-validation");
        // hideValidation("#disbursment", ".disbursment-validation");
    });



    // PAYMENT BULK GRANTEE
    // $(document).ready(function(){
    //     // --- helper untuk ajax sync ---
    //     function getSyncData(url, data = {}) {
    //         let result = null;
    //         $.ajax({
    //             async: false,
    //             type: 'POST',
    //             url: url,
    //             data: data,
    //             dataType: 'html',
    //             success: d => result = d
    //         });
    //         return result;
    //     }

    //     // Template untuk grantee card
    //     function getGranteeCard(id, name, index, paymentOptions, bankOptions, granteeGrantId){
    //         return `
    //             <div class="panel panel-info grantee-card" data-index="${index}">
    //             <input type="hidden" name="add_record[grantee][${granteeGrantId}][items][${index}][user_id]" value="${id}">
    //             <input type="hidden" name="add_record[grantee][${granteeGrantId}][items][${index}][grantee_grant_id]" value="${granteeGrantId}">
    //             <div class="panel-heading">
    //                 <strong>Grantee: ${name}</strong>
    //                 <button type="button" class="hide-view btn btn-danger btn-xs pull-right remove-grantee">
    //                 <span class="glyphicon glyphicon-remove"></span> Remove
    //                 </button>
    //             </div>
    //             <div class="panel-body">
    //                 <div class="form-group">
    //                     <label>Bank</label>
    //                     <select class="form-control-view form-control select2 grantee-bank-info" name="add_record[grantee][${granteeGrantId}][bank_info_id]" >
    //                         <option value=''>Select Bank Info</option>
    //                         ${JSON.parse(bankOptions).map(v => `<option value="${v.id}">${v.bank_name} - ${v.account_number}</option>`).join('')}
    //                     </select>
    //                 </div>
    //                 <div class="table-responsive">
    //                     <table class="table table-bordered payment-table">
    //                         <thead>
    //                         <tr>
    //                             <th>Payment Item</th>
    //                             <th>Nominal IDR</th>
    //                             <th>Nominal USD</th>
    //                             <th>Action</th>
    //                         </tr>
    //                         </thead>
    //                         <tbody>
    //                         <tr class="tr-${granteeGrantId}">
    //                             <td>
    //                             <input type="hidden" name="add_record[grantee][${granteeGrantId}][items][${index}][item_id]" value="">
    //                             <input type="hidden" name="add_record[grantee][${granteeGrantId}][items][${index}][payment_id]" value="">
    //                             <select class="form-control-view form-control select2 grantee-payment-item"
    //                                 name="add_record[grantee][${granteeGrantId}][items][${index}][payment_item]" 
    //                                 id="grantee-payment-item${index}">
    //                                 <option value=''>Select Payment Item</option>
    //                                 ${JSON.parse(paymentOptions).map(v => `<option value="${v.id}">${v.payment_item}</option>`).join('')}
    //                             </select>
    //                             </td>
    //                             <td><input type="text" class="form-control-view form-control currency-idr" name="add_record[grantee][${granteeGrantId}][items][${index}][nominal_idr]"></td>
    //                             <td><input type="text" class="form-control-view form-control currency-usd" name="add_record[grantee][${granteeGrantId}][items][${index}][nominal]"></td>
    //                             <td class="text-center">
    //                             <button class="hide-view btn btn-danger btn-sm remove-item"><span class="glyphicon glyphicon-trash"></span></button>
    //                             </td>
    //                         </tr>
    //                         </tbody>
    //                     </table>
    //                 </div>
    //                 <button class="hide-view btn btn-primary btn-sm add-item" data-granteegrantid="${granteeGrantId}" type="button">
    //                     <span class="glyphicon glyphicon-plus"></span> Add Payment Item
    //                 </button>
    //                 <div class="subtotal text-right" style="margin-top:10px;">
    //                     <strong>Subtotal IDR:</strong> Rp <span class="subtotal-idr">0</span> |
    //                     <strong>Subtotal USD:</strong> $<span class="subtotal-usd">0</span>
    //                 </div>
    //             </div>
    //             </div>`;
    //     }

    //     // Template untuk payment row
    //     function getPaymentRow(paymentOptions, index, granteeGrantId){
    //     return `
    //         <tr class="tr-${granteeGrantId}">
    //         <td>
    //             <input type="hidden" name="add_record[grantee][${granteeGrantId}][items][${index}][item_id]" value="">
    //             <input type="hidden" name="add_record[grantee][${granteeGrantId}][items][${index}][payment_id]" value="">
    //             <select class="form-control-view form-control select2 grantee-payment-item" 
    //                 name="add_record[grantee][${granteeGrantId}][items][${index}][payment_item]" 
    //                 id="grantee-payment-item${index}">
    //                 <option value=''>Select Payment Item</option>
    //                 ${JSON.parse(paymentOptions).map(v => `<option value="${v.id}">${v.payment_item}</option>`).join('')}
    //             </select>
    //         </td>
    //         <td><input type="text" class="form-control-view form-control currency-idr" name="add_record[grantee][${granteeGrantId}][items][${index}][nominal_idr]"></td>
    //         <td><input type="text" class="form-control-view form-control currency-usd" name="add_record[grantee][${granteeGrantId}][items][${index}][nominal]"></td>
    //         <td class="text-center">
    //             <button class="hide-view btn btn-danger btn-sm remove-item" type="button">
    //             <span class="glyphicon glyphicon-trash"></span>
    //             </button>
    //         </td>
    //         </tr>`;
    //     }

    //     // Add Grantee
    //     $("#add-grantee").click(function(){

    //         let granteeIndex = 0;
    //         let period_id   = $('#period_id').val(),
    //             grant_id    = $('#grant_id').val(),
    //             status      = $('#select-status').val(),
    //             category    = 'Grant Cost',
    //             sub_category= $('#sub_category_bulk').val(),
    //             selectedOpt = $('#select-grantee option:selected'),
    //             user_id     = $('#select-grantee').val(),
    //             disbursment = $('#disbursment').val(),
    //             grantee_name= selectedOpt.data('grantee_name'),
    //             grantee_grant_id = selectedOpt.data('grantee_grant_id');

    //         // --- validation ---
    //         // return false
    //         if (!user_id)   return alert('Please Select Grantee.');
    //         if (!disbursment)  return alert('Please Select Disbursment.');
    //         // if (!category)  return alert('Please Select Category.');
    //         if (!sub_category) return alert('Please Select Sub Category.');

    //         // load Payment Items
    //         let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
    //             category_type: category, sub_category, country_id: 2
    //         });

    //         // load Bank Info khusus grantee
    //         let getOptionBankInfo = getSyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + user_id, {
    //             period_id, grant_id, status
    //         });

    //         if(user_id){

    //             let setupRows = $("#setup-payment-table tbody tr");
    //             let paymentRows = "";
    //             setupRows.each(function(idx, item){
    //                 let itemId = $(this).find(".setup-payment-item").val();
    //                 let itemText = $(this).find(".setup-payment-item option:selected").text();
    //                 let idr = $(this).find(".setup-idr").val();
    //                 let usd = $(this).find(".setup-usd").val();
    //                 paymentRows += `
    //                     <tr class="tr-${grantee_grant_id}">
    //                         <td>
    //                         <input type="hidden" name="add_record[grantee][${grantee_grant_id}][items][${idx}][item_id]" value="">
    //                         <input type="hidden" name="add_record[grantee][${grantee_grant_id}][items][${idx}][payment_id]" value="">
    //                         <select class="form-control-view form-control select2 grantee-payment-item"
    //                             name="add_record[grantee][${grantee_grant_id}][items][${idx}][payment_item]" 
    //                             id="grantee-payment-item${idx}">
    //                             <option value=''>Select Payment Item</option>
    //                             ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}" ${v.id == itemId ? "selected" : ""}>${v.payment_item}</option>`).join('')}
    //                         </select>
    //                         </td>
    //                         <td><input type="text" class="form-control-view form-control currency-idr" name="add_record[grantee][${grantee_grant_id}][items][${idx}][nominal_idr]" value="${idr}"></td>
    //                         <td><input type="text" class="form-control-view form-control currency-usd" name="add_record[grantee][${grantee_grant_id}][items][${idx}][nominal]" value="${usd}"></td>
    //                         <td class="text-center">
    //                         <button class="hide-view btn btn-danger btn-sm remove-item"><span class="glyphicon glyphicon-trash"></span></button>
    //                         </td>
    //                     </tr>`;
    //             });

    //             $("#grantee-container").append(
    //                 // getGranteeCard(user_id, grantee_name, granteeIndex, getPaymentItems, getOptionBankInfo, grantee_grant_id)
    //                 // function getGranteeCard(id, name, index, paymentOptions, bankOptions, granteeGrantId){
    //                 `
    //                     <div class="panel panel-info grantee-card" data-index="${granteeIndex}">
    //                     <input type="hidden" name="add_record[grantee][${grantee_grant_id}][items][${granteeIndex}][user_id]" value="${user_id}">
    //                     <input type="hidden" name="add_record[grantee][${grantee_grant_id}][items][${granteeIndex}][grantee_grant_id]" value="${grantee_grant_id}">
    //                     <div class="panel-heading">
    //                         <strong>Grantee: ${grantee_name}</strong>
    //                         <button type="button" class="hide-view btn btn-danger btn-xs pull-right remove-grantee">
    //                         <span class="glyphicon glyphicon-remove"></span> Remove
    //                         </button>
    //                     </div>
    //                     <div class="panel-body">
    //                         <div class="form-group">
    //                             <label>Bank</label>
    //                             <select class="form-control-view form-control select2 grantee-bank-info" name="add_record[grantee][${grantee_grant_id}][bank_info_id]" >
    //                                 <option value=''>Select Bank Info</option>
    //                                 ${JSON.parse(getOptionBankInfo).map(v => `<option value="${v.id}">${v.bank_name} - ${v.account_number}</option>`).join('')}
    //                             </select>
    //                         </div>
    //                         <div class="table-responsive">
    //                             <table class="table table-bordered payment-table">
    //                                 <thead>
    //                                 <tr>
    //                                     <th>Payment Item</th>
    //                                     <th>Nominal IDR</th>
    //                                     <th>Nominal USD</th>
    //                                     <th>Action</th>
    //                                 </tr>
    //                                 </thead>
    //                                 <tbody>
    //                                     ${paymentRows}
    //                                 </tbody>
    //                             </table>
    //                         </div>
    //                         <button class="hide-view btn btn-primary btn-sm add-item" data-granteegrantid="${grantee_grant_id}" type="button">
    //                             <span class="glyphicon glyphicon-plus"></span> Add Payment Item
    //                         </button>
    //                         <div class="subtotal text-right" style="margin-top:10px;">
    //                             <strong>Subtotal IDR:</strong> Rp <span class="subtotal-idr">0</span> |
    //                             <strong>Subtotal USD:</strong> $<span class="subtotal-usd">0</span>
    //                         </div>
    //                     </div>
    //                     </div>`
    //             );
    //             granteeIndex++;
    //             $(".select2").select2();
    //             let card = $(this).closest(".col-lg-12").find('.grantee-card')
    //             updateSubtotalGeneric(card);
    //         } else {
    //             alert("Please select a grantee first!");
    //         }
    //     });

    //     // Remove Grantee
    //     $(document).on("click", ".remove-grantee", function(){
    //         var paymentId = $(this).data('id');
    //         recordDeletePayment(paymentId);
    //         $(this).closest(".grantee-card").remove();
    //     });

    //     // Add Payment Item
    //     $(document).on("click", ".add-item", function(){
    //         let category    = 'Grant Cost',
    //             sub_category= $('#sub_category_bulk').val(),
    //             selectedOpt = $('#select-grantee option:selected'),
    //             grantee_grant_id = $(this).data('granteegrantid');

    //         let granteeIndex = $('.tr-' + grantee_grant_id).length;
    //         // load Payment Items
    //         let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
    //             category_type: category, sub_category, country_id: 2
    //         });
    //         $(this).closest(".panel-body").find("tbody").append(getPaymentRow(getPaymentItems, granteeIndex, grantee_grant_id));
    //         $(".select2").select2();
    //     });

    //     $(document).on("click", "#add-setup-item", function(){
    //         let category    = 'Grant Cost',
    //             sub_category= $('#sub_category_bulk').val(),
    //             selectedOpt = $('#select-grantee option:selected'),
    //             grantee_grant_id = $(this).data('granteegrantid');

    //         let granteeIndex = $('.tr-' + grantee_grant_id).length;
    //         // load Payment Items
    //         let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
    //             category_type: category, sub_category, country_id: 2
    //         });
    //         $(this).closest(".panel-body").find("tbody").append(`
    //             <tr>
    //                 <td>
    //                     <select class="form-control setup-payment-item select2" name="setup[${granteeIndex}][payment_item]">
    //                         <option value=''>Select Payment Item</option>
    //                         ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}">${v.payment_item}</option>`).join('')}
    //                     </select>
    //                 </td>
    //                 <td><input type="text" class="form-control setup-idr" name="setup[${granteeIndex}][nominal_idr]"></td>
    //                 <td><input type="text" class="form-control setup-usd" name="setup[${granteeIndex}][nominal_usd]"></td>
    //                 <td class="text-center">
    //                     <button class="hide-view btn btn-danger btn-sm remove-setup"><span class="glyphicon glyphicon-trash"></span></button>
    //                 </td>
    //             </tr>
    //         `);
    //         $(".select2").select2();
    //     });

    //     // Remove Payment Item
    //     $(document).on("click", ".remove-item", function(){
    //         let card = $(this).closest(".grantee-card, .cart-setup");
    //         let itemId = $(this).data('id');
    //         $(this).closest("tr").remove();
    //         recordDeletePaymentItem(itemId);
    //         updateSubtotalGeneric(card);
    //     });

    //     // Update subtotal when input changes
    //     $(document).on("input", ".currency-idr, .currency-usd, .setup-idr, .setup-usd", function(){
    //         let card = $(this).closest(".grantee-card, .cart-setup");
    //         updateSubtotalGeneric(card);
    //     });

    //     function updateSubtotalGeneric(card){
    //         let totalIDR = 0;
    //         let totalUSD = 0;
            

    //         card.find(".currency-idr, .setup-idr").each(function(){
    //             totalIDR += parseMoney($(this).val()) || 0;
    //         });

    //         card.find(".currency-usd, .setup-usd").each(function(){
    //             totalUSD += parseMoney($(this).val()) || 0;
    //         });

    //         if(card.hasClass("grantee-card")){
    //             card.find(".subtotal-idr").text(totalIDR.toLocaleString());
    //             card.find(".subtotal-usd").text(totalUSD.toLocaleString());
    //         } else if(card.hasClass("cart-setup")){
    //             card.find(".setup-subtotal-idr").text(totalIDR.toLocaleString());
    //             card.find(".setup-subtotal-usd").text(totalUSD.toLocaleString());
    //         }
    //     }

    //     function parseMoney(val){
    //         if(!val) return 0;
    //         val = val.replace(/[^0-9.,]/g, "");
    //         val = val.replace(",", ".");
    //         return Number(val) || 0;
    //     }

    //     $('#mdl_bulk_grantee').on('show.bs.modal', function(event) {
    //         var button = $(event.relatedTarget);
    //         var mode = button.data('mode');
    //         var grant_id = <?= $grant_id ?? '' ?>;
    //         console.log(mode)
            
    //         var $modal = $(this);
    //         $modal.find('input[type="text"], input[type="number"], input[type="hidden"], textarea').val('');
    //         $modal.find('select').val('').trigger('change');
    //         $modal.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
    //         $('#grantee-container').html('');
    //         $('#grant_id_bulk').val(grant_id);

    //         if(mode == 'view' || mode == 'edit') {
    //             var recordId = button.data('record_id');
    //             $("#delete_detail_payment_record_bulk").val('');
    //             $("#delete_payment_record_bulk").val('');

    //             if (typeof currentPaymentBulk !== 'undefined') {
    //                 var data = currentPaymentBulk[recordId];
    //                 var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    //                 var from_date = new Date(data.from_date);
    //                 var to_date = new Date(data.to_date);
    //                 var notify_date = data.notify_date ? new Date(data.notify_date) : '';

    //                 $('#disbursment').val(data.payment_name);
    //                 $('#sub_category_bulk').val(data.sub_category_id);
    //                 $('#add_from_date').val((from_date.getDate() < 10 ? '0' + from_date.getDate() : from_date.getDate()) + ' ' + monthNames[from_date.getMonth()] + ' ' + from_date.getFullYear());
    //                 $('#add_to_date').val((to_date.getDate() < 10 ? '0' + to_date.getDate() : to_date.getDate()) + ' ' + monthNames[to_date.getMonth()] + ' ' + to_date.getFullYear());
    //                 $('#add_notify_date').val( notify_date ? (notify_date.getDate() < 10 ? '0' + notify_date.getDate() : notify_date.getDate()) + ' ' + monthNames[notify_date.getMonth()] + ' ' + notify_date.getFullYear() : '');
    //                 $('#release_note').val(data.release_note);
    //                 $('#user_grantee_grant_memo_id').val(data.user_grantee_grant_memo_id);
    //                 $('#add_deadline_date').val(data.deadline_date);
    //                 $('#add_record_priority').val(data.priority);
    //                 $('#record_status_grantee').val(data.payment_status);
    //                 $('#grant_id_bulk').val(data.period_id);
                    

    //                 $('#grantee-container').html('');

    //                 $.each(data.items, function(granteeGrantId, items) {
    //                     if (!items || items.length === 0) return;
    //                     // return false

    //                     // ambil meta dasar dari item pertama
    //                     var first = items[0];
    //                     var userId   = first.user_grantee_id;
    //                     var fullName = data.full_name[granteeGrantId]; // ganti sesuai field yg memang nama grantee
    //                     let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
    //                         category_type: data.category, sub_category: data.sub_category_id, country_id: 2
    //                     });

    //                     let getOptionBankInfo = getSyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + first.user_grantee_id, {
    //                         period_id:null, grant_id:null, status:null
    //                     });

    //                     // render card grantee
    //                     var html = getGranteeCard(userId, fullName, 0, getPaymentItems, getOptionBankInfo, granteeGrantId);
    //                     $('#grantee-container').append(html);
    //                     $('#bulk_id').val(data.id);

    //                     var $card = $('#grantee-container .grantee-card').last();

    //                     // isi bank (kalau ada)
    //                     if (first.bank_info_id) {
    //                         $card.find('.grantee-bank-info')
    //                             .val(first.bank_info_id)
    //                             .trigger('change');
    //                     }

                        
    //                     // loop semua items
    //                     $.each(items, function(idx, item) {
    //                         if (idx == 0) {
    //                             $card.find('.remove-grantee').attr('data-id', item.payment_id);
    //                         }
    //                         if (idx > 0) {
    //                             $card.find('.add-item').trigger('click');
    //                         }

    //                         var $row = $card.find('tbody tr').eq(idx);
    //                         $row.find('input[name*="[item_id]"]').val(item.id);
    //                         $row.find('input[name*="[payment_id]"]').val(item.payment_id);
    //                         $row.find('.remove-item').attr('data-id', item.id);

    //                         // `item_name` biasanya ID untuk payment_item
    //                         $row.find('.grantee-payment-item')
    //                             .val(item.item_name)
    //                             .trigger('change');

    //                         $row.find('input[name*="[nominal_idr]"]').val(item.nominal_idr);
    //                         $row.find('input[name*="[nominal]"]').val(item.nominal);
    //                     });

    //                     updateSubtotalGeneric($card);
    //                 });

    //                 // for (var i = 0; i < data.items.length; i++) {
    //                 //     var html = append_edit_record_bulk(i, data.payment_for);
    //                 //     $('#grantee-container').append(html);
    //                 // }

    //                 // $.each(data.items, function(key, value) {
    //                 //     $('#payment-name-' + key).text(data.payment_name[key]);
    //                 //     // $('#select-grantee-input' + key).val(data.user_grantee_id[key]).attr('data-bank', data.bank_info_id[key]).trigger('change');
    //                 //     $('#payment-bulk-id-' + key).val(data.payment_grant_id_for[key]);
    //                 //     $('#payment-nominal-' + key).val(value.nominal);
    //                 //     $('#payment-nominal-idr-' + key).val(value.nominal_idr);
    //                 //     $('#payment_record_grant_id-' + key).val(value.payment_record_grant_id);
    //                 //     $('#payment_item_record_grant_id-' + key).val(value.id);
    //                 //     $('.remove-data-payment-edit' + key).attr('data-id', value.id).attr('data-payment_id', value.payment_record_grant_id);
    //                 //     if(data.proofs){
    //                 //         if(data.proofs[key] != null){
    //                 //             $('#proof_record_' + key).attr('href', SITE_URL + data.proofs[key]);
    //                 //         }else{
    //                 //             $('#proof_record_' + key).addClass('d-none')
    //                 //         }
    //                 //     }
    //                 //     if(data.proof_expenses){
    //                 //         if(data.proof_expenses[key] != null){
    //                 //             $('#proof_of_expense_' + key).attr('href', SITE_URL + data.proof_expenses[key]);
    //                 //         }else{
    //                 //             $('#proof_of_expense_' + key).addClass('d-none')
    //                 //         }
    //                 //     }
    //                 // });
    //                 $('.select2').select2({
    //                     theme: 'bootstrap'
    //                 });
    //             }

    //             do_format_input_currency();
    //             $('.lightbox').topbox();
    //             Swal.close(); 
                
    //             if(mode == 'view'){
    //                 $('.form-control-view').prop('disabled', true)
    //                 $('.modal-footer, .hide-view, .edit-add-more-data-payment').addClass('hide')
    //                 $('#exampleModalLabelGrantee').text('View Bulk Grantee')
    //             }else{
    //                 $('.form-control-view').prop('disabled', false)
    //                 $('.modal-footer, .hide-view, .edit-add-more-data-payment').removeClass('hide')
    //                 $('#exampleModalLabelGrantee').text('Edit Bulk Grantee')
    //                 $(".radio-for").prop('disabled', true);
    //             }
    //             $('.selectpicker').selectpicker('refresh');
    //             // $.fn.modal.Constructor.prototype.enforceFocus = function() {
    //             // };
    //         }else if(mode == 'add'){
    //             $('#disbursment').val('');
    //             $('#sub_category_bulk').val('');
    //             $('#release_note').val('');
    //             $('#user_grantee_grant_memo_id').val('');
    //             $('#add_deadline_date').val('');
    //             $('#add_record_priority').val('');
    //             $('#record_status_grantee').val('');

    //             // kosongkan wrap grantee
    //             $('#grantee-container').html('');
    //             $('#exampleModalLabelGrantee').text('Add Bulk Grantee')
    //             $('.form-control-view').prop('disabled', false)
    //             $('.modal-footer, .hide-view, .edit-add-more-data-payment').removeClass('hide')
    //         }
    //     });

    //     $(document).on("click", ".remove-setup", function(){
    //         let card = $(this).closest(".grantee-card, .cart-setup");
    //         $(this).closest("tr").remove();
    //         updateSubtotalGeneric(card);
    //     });


    // }); //end document read

    // function showLoadSpiner()
    // {
    //     Swal.fire({
    //         title: 'Loading...',
    //         text: 'Please wait while we process your request.',
    //         allowOutsideClick: false,
    //         allowEscapeKey: false,
    //         showConfirmButton: false, 
    //         didOpen: () => {
    //             Swal.showLoading(); 
    //         }
    //     });
    // }

    // function recordDeletePayment(id) {
    //     var deleted = $("#delete_payment").val();
    //     if(deleted == ''){
    //         $("#delete_payment").val(id);
    //     }else{
    //         var join_id = deleted + ',' + id;
    //         $("#delete_payment").val(join_id);
    //     }
    // }

    // function recordDeletePaymentItem(id) {
    //     var deleted = $("#delete_payment_item").val();
    //     if(deleted == ''){
    //         $("#delete_payment_item").val(id);
    //     }else{
    //         var join_id = deleted + ',' + id;
    //         $("#delete_payment_item").val(join_id);
    //     }
    // }

</script>