<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>
<script src="<?php echo base_url() ?>js/undoredo.js"></script>

<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    function add_item_record(i) {
        var name_class = '.request-item-record' + i;
        var warp_request = '#wrap-request-record' + i;

        var category_type = $('select[name="add_record[category]"]').val();
        var sub_category = $('select[name="add_record[sub_category]"]').val();
        
        if(category_type == ''){
            alert('Please Select Category');
            return false;
        }else if(sub_category == ''){
            alert('Please Select Sub Category');
            return false;
        }

        var idx = $(name_class).length;
        // console.log(idx)
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/payment_item/add_item_record') ?>',
            data:{
                'idx':idx,
                'i':i,
                'category_type': category_type,
                'sub_category': sub_category,
            },
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $('.select2').select2({
            theme: 'bootstrap'
});
            }
        });
    }

    function del_item(el, item_class) {
        var deleted = $("#delete_detail_payment").val();
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
        var id = $(el).attr('id');
        if (deleted == '') {
            $("#delete_detail_payment").val(id);
        } else {
            var join_id = deleted + ',' + id;
            $("#delete_detail_payment").val(join_id);
        }
    }

    $("#btn-submit-record, #btn-submit-record-edit").click(function() {
        // $('#hide-btn').prop("disabled", false);
        // $('#hide-btn-edit').prop("disabled", true);
        // $.ajax({
        //     type: 'POST',
        //     url: '<?php echo site_url('admin/request_payment/validate_payment_period') ?>',
        //     dataType: 'JSON',
        //     data: $("#form").serializeArray(),
        //     success: function(r) {
        //         if (r.success == true) {
        //             $("#mdl_validate").modal();
        //             $("#mdl_add_record").modal('hide');
        //             $("#validate_message").html(r.message);
        //             event.preventDefault();
        //         } else {
        //             $("#btn-submit-record").prop("type", "submit");
        //             $("#form").submit();
        //         }
        //     }
        // });

        
        $(this).addClass("hide");

        $(".btn-submit-record-disabled").each(function(){
            $(this).removeClass('hide');
        });
        
        var action = $(this).data('action');
        var payment_date = $(".payment-date-record").val();
        var payment_category = $(".payment-category-record").val();
        var payment_sub_category = $(".payment-sub-category-record").val();
        if (payment_date == '') {
            var dt = $("#payment_date").val();
            payment_date = dt;
        }
        if (payment_category == '') {
            var pc = $("#category").val();
            payment_category = pc;
        }
        if (payment_sub_category == '') {
            var psc = $("#sub_category").val();
            payment_sub_category = psc;
        }
        var invalid = false;
        if (payment_date == '') {
            $(".payment-date-record-validation").removeClass('hide');
            invalid = true;
        }
        if (payment_category == '') {
            $(".payment-category-record-validation").removeClass('hide');
            invalid = true;
        }
        if (payment_sub_category == '') {
            $(".payment-sub-category-record-validation").removeClass('hide');
            invalid = true;
        }
        
        var payment_item_create = $('#wrap-request-record0');
        var paymnet_item_edit = $("#wrap-request-record-edit0");
        
        var payment_item = payment_item_create;
        if (action != 'create') {
            var payment_item = paymnet_item_edit;
            var status = $("#record_status").val();
        }else{
            var status = $("#record_status_add").val();
        }
        
        var payment_sub_category = payment_item.find('.payment-item-section');
        
        payment_sub_category.each(function() {
            var payment_item_list = $(this).find('.record-payment-item').select2('val');
            if (payment_item_list != '') {
                $(this).closest('div').find(".record-payment-item-validation").addClass('hide');
            } else {
                $(this).closest('div').find(".record-payment-item-validation").removeClass('hide');
                invalid = true;
            }

            var payment_item_nominal = $(this).find('.record-payment-nominal').val();
            var payment_item_nominal_idr = $(this).find('.record-payment-nominal-idr').val();
            if (payment_item_nominal_idr == '' || payment_item_nominal_idr == 0) {
                //$(this).closest('div').find(".record-payment-nominal-idr-validation").removeClass('hide');
                //invalid = true;
            } 

            if(payment_item_nominal != '' || payment_item_nominal != 0){
                if(payment_item_nominal % 1 == 0){
                    $(this).closest('div').find(".record-payment-nominal-validation").addClass('hide');
                }else{
                    // $(this).closest('div').find(".record-payment-nominal-decimal-validation").removeClass('hide');
                    // invalid = true;
                }
            }
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
    $(".payment-category-record").on('change', function() {
        $(".payment-category-record-validation").addClass('hide');
    });
    $(".payment-sub-category-record").on('change', function() {
        $(".payment-sub-category-record-validation").addClass('hide');
    });
    $('.record-payment-item').on('change', function() {
        $(this).closest('div').find('.record-payment-item-validation').addClass('hide');
    });
    $('.record-payment-nominal').on('change', function() {
        $(this).closest('div').find('.record-payment-nominal-validation').addClass('hide');
    });
    $('.record-payment-nominal-idr').on('change', function() {
        //$(this).closest('div').find('.record-payment-nominal-idr-validation').addClass('hide');
    });

    // $("#btn-submit-record-edit").click(function() {
    //     $('#hide-btn').prop("disabled", true);
    //     $('#hide-btn-edit').prop("disabled", false);
    //     $.ajax({
    //         type: 'POST',
    //         url: '<?php echo site_url('admin/request_payment/validate_payment_period') ?>',
    //         dataType: 'JSON',
    //         data: $("#form").serializeArray(),
    //         success: function(r) {
    //             if (r.success == true) {
    //                 $("#mdl_validate").modal();
    //                 $("#mdl_edit_record").modal('hide');
    //                 $("#validate_message").html(r.message);
    //                 event.preventDefault();
    //             } else {
    //                 $("#btn-submit-record").prop("type", "submit");
    //                 $("#form").submit();
    //             }
    //         }
    //     });

    // });

    $('#mdl_add_record').on('show.bs.modal', function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            $('.select2').select2({
                theme: 'bootstrap'
            });
            let is_finance = '<?php echo $this->session->userdata('role') == 'finance' ? true : false; ?>';
            // if (is_finance) {
            //     $('.proof-of-transfer').removeClass('hide');
            //     $('.upload-invoice').removeClass('hide');  
            //     $('input[name="add_proof_record"').removeClass('hide');
            //     $('input[name="add_invoice"').removeClass('hide');
            // } else {
            //     $('.proof-of-transfer').addClass('hide');
            //     $('.upload-invoice').addClass('hide');
            //     $('input[name="add_proof_record"').addClass('hide');
            //     $('input[name="add_invoice"').addClass('hide');
            // }

            $('#add_payment_date').attr('autocomplete', 'off');
            $('.modal-footer').removeClass('hide')
        };
    });

    // write edit review
    $('#mdl_edit_record').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {

            var button = $(event.relatedTarget);
            var recordId = button.data('record_id');
            var mode = button.data('mode');
            var urlBulk = $("#url_bulk").val();
            $("#delete_detail_payment_record").val('');

            if (typeof currentUserReviews !== 'undefined') {
                var data = currentUserReviews[recordId];
                console.log(data)
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                var payment_date = new Date(data.payment_date);
                $('#payment_id').val(data.id);
                $('#bulk_id').val(data.bulk_id);
                $('#payment_date').val((payment_date.getDate() < 10 ? '0' + payment_date.getDate() : payment_date.getDate()) + ' ' + monthNames[payment_date.getMonth()] + ' ' + payment_date.getFullYear()).attr('autocomplete', 'off');
                $('#description').val(data.description);
                $('#category').val(data.category);
                $('#memo_budget').val(data.user_grantee_grant_memo_id);
                // Hide inactive memo options, but keep the currently assigned one visible & enabled so it POSTs
                var selectMemoPR = $('#memo_budget');
                selectMemoPR.find('option.memo-budget-inactive').prop('hidden', true).prop('disabled', true).hide();
                if (data.user_grantee_grant_memo_id) {
                    var currentMemoPR = selectMemoPR.find('option[value="' + data.user_grantee_grant_memo_id + '"]');
                    currentMemoPR.prop('hidden', false).prop('disabled', true).show();
                }
                selectMemoPR.val(data.user_grantee_grant_memo_id);
                $('#bank_info_id').val(data.bank_info_id);
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('admin/payment_item/get_sub_category') ?>',
                    data: {
                        'category_type': data.category
                    },
                    dataType: 'JSON',
                    success: function(r) {
                         $('#sub_category').empty();
                         $('#sub_category').append('<option value="">-- Select Sub Category --</option>');
                        $.each(r, function(id, val) {
                            $('#sub_category').append('<option value="' + val.id + '">' + val.name + '</option>');
                        });
                        $('#sub_category').val(data.sub_category_id);
                    }
                });


                $('#release_type').val(data.release_type);
                $('#admin_note').val(data.admin_note);
                $('#finance_note').val(data.finance_note);
                $('#record_status').val(data.status);
                $('#hide-total-payment-record').val(data.total_nominal);
                $("#edit_record_priority").val(data.priority);

                if(data.category == 'Grant Cost' || data.category == 'International Travel'){
                    $('#departure_date_edit').removeClass('hide')
                }else{
                    $('#departure_date_edit').addClass('hide')
                }
                if (data.departure_date != null) {
                    $('#edit_record_departure_date').datepicker("setDate", new Date(data.departure_date));
                } else {
                    $('#edit_record_departure_date').val('');
                }

                if (data.deadline_date != null) {
                    $('#edit_record_deadline_date').datepicker("setDate", new Date(data.deadline_date));
                } else {
                    $('#edit_record_deadline_date').val('');
                }

                if (data.proof != null) {
                    $('#btn_proof').attr('href', '<?php echo base_url() ?>' + data.proof).show();
                } else {
                    $('#btn_proof').attr('href', '').hide();
                }

                let is_finance = '<?php echo $this->session->userdata('role') == 'finance' ? true : false; ?>';
                if (is_finance || data.proof !== null) {
                    $('.proof-of-transfer').removeClass('hide');    
                } else {
                    $('.proof-of-transfer').addClass('hide');
                }

                if (is_finance || data.invoice !== null) {
                    $('.upload-invoice').removeClass('hide');    
                } else {
                    $('.upload-invoice').addClass('hide');
                }

                // if (is_finance) { 
                //     $('input[name="proof_record"').removeClass('hide');
                //     $('input[name="invoice"').removeClass('hide');
                //     $('.file-for-testing').removeClass('hide');
                // } else {
                //     $('input[name="proof_record"').addClass('hide');
                //     $('input[name="invoice"').addClass('hide');
                //     $('.file-for-testing').addClass('hide');
                // }

                if (data.invoice != null) {
                    $('#btn_invoice').attr('href', '<?php echo base_url() ?>' + data.invoice).show();
                } else {
                    $('#btn_invoice').attr('href', '').hide();
                }
                if(data.notify_finance == 1){
                    $('#edit_notify_finance').attr('checked', 'checked');
                }
                if(data.notify_admin == 1){
                    $('#edit_notify_admin').attr('checked', 'checked');
                }
                if(data.notify_grantee == 1){
                    $('#edit_notify_grantee').attr('checked', 'checked');
                }

                
                $('#wrap-request-record-edit0').find('.request-item-record-edit').each(function(){
                    $(this).remove();
                });

                for (var i = 0; i < data.items.length; i++) {
                    var html = append_edit_record(i);
                    $('#wrap-request-record-edit0').append(html);
                }
                // var html = append_edit_record(i);
                // $('#wrap-request-record-edit0').append(html);

                setoption('select_payment_item_edit', false,data);

                $.each(data.items, function(key, value) {
                    $('#select_payment_item_edit' + key).val(value.payment_item).trigger('change');
                    // $('#select_payment_item_edit' + key).html('');
                    $('#nominal_edit' + key).val(value.nominal);
                    $('#nominal_idr_edit' + key).val(value.nominal_idr);
                    $('#id' + key).val(value.id);
                    $('#btn_delete' + key).attr('data-id', value.id);
                    if(value.proof_of_payment){
                        $('#proof_of_payment_' + key).attr('href', SITE_URL + value.proof_of_payment);
                    }else{
                        $('#proof_of_payment_' + key).addClass('d-none')
                    }
                });
                $('.select2').select2({
                    theme: 'bootstrap'
                });
            }
            do_format_input_currency();
            if(mode == 'view'){
                $('.form-control-view').prop('disabled', true)
                $('.modal-footer, .hide-view').addClass('hide')
                $('#modalLabelEdit').text('View Payment Record')
                if(data.bulk_id){
                    $('#modalLabelEdit').text('Edit Payment Record')
                    $('.record-payment-nominal-idr, .payment-detail-id').prop('disabled', false)
                    $('.record-payment-nominal').prop('disabled', false)
                    $('.section-button-addnew-edit').addClass('hide')
                    $('.modal-footer').removeClass('hide')
                    $('.modal-footer, .hide-view').addClass('hide')
                }
            }else{
                $('.form-control-view').prop('disabled', false)
                $('.modal-footer, .hide-view').removeClass('hide')
                $('#modalLabelEdit').text('Edit Payment Record')
                $('.section-button-addnew-edit').removeClass('hide')
                if(data.bulk_id){
                    // window.open(urlBulk + '&open_modal=1&record_id=' + data.bulk_id, '_blank');
                    $('.form-control-view').prop('disabled', true)
                    $('#modalLabelEdit').text('Edit Payment Record')
                    $('.record-payment-nominal-idr, .payment-detail-id, .proof_of_payment_bulk, .select_payment_item_edit').prop('disabled', false)
                    $('.record-payment-nominal').prop('disabled', false)
                    $('.section-button-addnew-edit').addClass('hide')
                    $('.modal-footer, .proof_of_payment_bulk').removeClass('hide')
                    $('.modal-footer, .hide-view').addClass('hide')
                }
            }
        };
    });
    $('select[name="add_record[category]"]').on('change', function() {
        var sub_category = 'select[name="add_record[sub_category]"]';
        var payment_item = 'select[name="add_record[items][0][item]"]';
        let value = $(this).val();
        if(value == 'Grant Cost' || value == 'International Travel'){
            $('#departure_date_add').removeClass('hide')
        }else{
            $('#departure_date_add').addClass('hide')
        }

        $(sub_category).empty();
        $(sub_category).append('<option value="">-- Select Sub Category --</option>');
        // if($(this).val() != ''){
            get_sub_category($(this).val(),sub_category,payment_item,'add_record');
        // }
    });

    $('select[name="add_record[sub_category]"]').on('change', function() {
        var category_type = $('select[name="add_record[category]"]').val();
        var sub_category = $(this).val();
        var payment_item = 'select[name="add_record[items][0][item]"]';
        
        $(payment_item).empty();
        $(payment_item).append('<option value="">-- Select Item --</option>');
        // if($(this).val() != ''){
            get_payment_item(category_type,sub_category,payment_item,'add_record');
        // }
    });

    $('select[name="edit_record[category]"]').on('change', function() {
        var sub_category = 'select[name="edit_record[sub_category]"]';
        var payment_item = 'select[name="edit_record[items][0][item]"]';
        let value = $(this).val();
        if(value == 'Grant Cost' || value == 'International Travel'){
            $('#departure_date_edit').removeClass('hide')
        }else{
            $('#departure_date_edit').addClass('hide')
        }

        $(sub_category).empty();
        $(sub_category).append('<option value="">-- Select Sub Category --</option>');
        // if($(this).val() != ''){
            get_sub_category($(this).val(),sub_category,payment_item,'edit_record');
        // }
    });

    $('select[name="edit_record[sub_category]"]').on('change', function() {
        var category_type = $('select[name="edit_record[category]"]').val();
        var sub_category = $(this).val();
        var payment_item = 'select[name="edit_record[items][0][item]"]';
        
        $(payment_item).empty();
        $(payment_item).append('<option value="">-- Select Item --</option>');
        // if($(this).val() != ''){
            get_payment_item(category_type,sub_category,payment_item,'edit_record');
        // }
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

    function get_payment_item(category_type,sub_category,payment_item,param){
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
            url: '<?php echo site_url('admin/payment_item/get_payment_item') ?>',
            data: {
                'category_type': category_type,
                'sub_category': sub_category,
            },
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    if ($(payment_item + ' option[value="' + val.id + '"]').length === 0) {
                        $(payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                    }
                });
            }
        });
    }

    function append_edit_record(i) {
        var name_class = '.request-item-record-edit' + i;
        var warp_request = '#wrap-request-record-edit' + i;
        var idx = $(name_class).length;
        var html = '';

        html = '<div id="request-item-record-edit-' + i  +'" class="row request-item-record-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select id="select_payment_item_edit' + i + '" name="edit_record[items][' + i + '][item]" class="record-payment-item form-control form-control-view select2 select_payment_item_edit">'
        html += '</select>'
        html += '<div class="text-danger invalid-tooltip record-payment-item-validation hide" style="display: block;">Payment Item is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal IDR</label>'
        html += '<input type="text" id="nominal_idr_edit' + i + '" class="form-control form-control-view record-payment-nominal-idr currency-idr" name="edit_record[items][' + i + '][nominal_idr]">'
        html += '<div class="text-danger invalid-tooltip record-payment-nominal-idr-validation hide" style="display: block;">Nominal is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal USD</label>'
        html += '<input type="text" id="nominal_edit' + i + '" class="record-payment-nominal form-control form-control-view currency-usd" name="edit_record[items][' + i + '][nominal]">'
        html += '<input type="hidden" id="id' + i + '" class="form-control form-control-view payment-detail-id" name="edit_record[items][' + i + '][id]">'
        html += '<div class="text-danger invalid-tooltip record-payment-nominal-validation hide" style="display: block;">Nominal is Required</div>'
        html += '<div class="text-danger invalid-tooltip record-payment-nominal-decimal-validation hide" style="display: block;">Please enter a valid value. The two nearest valid values are 0 and 1.</div>  '
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Proof of Expense</label>'
        html += '<input type="file" name="proof_of_payment_'+ i +'" class="form-control form-control-view hide-view proof_of_payment_bulk" style="display: inline;" form="form">'
        html += '<br /><a class="btn btn-xs btn-primary mt-1" id="proof_of_payment_'+ i +'" target="_blank">View</a>'
        html += '<a class="hide-view btn btn-xs btn-danger mt-1" id="delete_proof_of_payment_'+ i +'" onclick="remove_payment_item_proof(this, '+ i +', 1);return false;"><i class="fa fa-times"></i></a>'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '<a href="javascript:;" onclick="del_item_id(this, \'request-item-record-edit-' + i + '\')" class="hide-view btn btn-danger btn-xs" id=btn_delete' + i + ' style="position:absolute;right:15px;"><i class="fa fa-trash fa-fw"></i></a>'
        html += '</div>'

        return html;

    }

    function change_status_paid(key)
    {
        $("#record_status").val("4").trigger('change');
    }

    function remove_payment_item_proof(element, idx, edit = 0)
    {
        if (confirm("Are you sure you want to remove this file?")) {
            var file_input = element.closest('div').querySelector('input[type="file"]');
            
            if (file_input) {
                file_input.value = '';
            }
            $("#proof_of_payment_" + idx).remove();

            if (idx != undefined) {
                element.closest('div').insertAdjacentHTML('beforeend', '<input form="form" type="hidden" name="edit_record[items]['+idx+'][remove_proof]" value="1">');
            }
        }
    }

    function setoption(ddlID, isFirstOptionEmpty,data) {
        // var arr = currentPaymentItems;
        var arr = function () {
            var tmp = null;
            $.ajax({
                'async': false,
                type: 'POST',
                url: '<?php echo site_url('admin/payment_item/get_payment_item') ?>',
                data: {
                    'category_type': data.category,
                    'sub_category': data.sub_category_id,
                },
                dataType: 'html',
                success: function(data) {
                    tmp = data;
                }
            });
            return tmp;
        }();
        arr = JSON.parse(arr);
        setDDLValues(ddlID, isFirstOptionEmpty, arr);
    }

    function setDDLValues(ddlID, isFirstOptionEmpty, arr) {
        clearDDL(ddlID);

        if (isFirstOptionEmpty) {
            $('.' + ddlID).append("<option value=''>All</option>");
        }
        // console.log(arr)

        for (var i = 0; i < arr.length; i++) {
            $('.' + ddlID).append("<option value='" + arr[i].id + "'>" + arr[i].payment_item + "</option>");
        }
    }

    function clearDDL(ddlID) {
        $("." + ddlID).prop('');
    }

    function edit_item_record(i) {
        var name_class = '.request-item-record-edit';
        var warp_request = '#wrap-request-record-edit' + i;

        var category_type = $('select[name="edit_record[category]"]').val();
        var sub_category = $('select[name="edit_record[sub_category]"]').val();

        if(category_type == ''){
            alert('Please Select Category');
            return false;
        }else if(sub_category == ''){
            alert('Please Select Sub Category');
            return false;
        }
        
        var idx = $(name_class).length;
        // console.log(idx)
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/payment_item/add_edit_item_record') ?>',
            data:{
                'idx':idx,
                'i':i,
                'category_type': category_type,
                'sub_category': sub_category,
            },
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $('.select2').select2({
                    theme: 'bootstrap'
                });
            }
        });
    }

    function del_item_id(el, item_class) {
        var deleted = $("#delete_detail_payment_record").val();
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('#' + item_class).remove();
        var id = $(el).data('id');
        if (deleted == '') {
            $("#delete_detail_payment_record").val(id);
        } else {
            var join_id = deleted + ',' + id;
            $("#delete_detail_payment_record").val(join_id);
        }
    }
    $('#show_hide_bank').on('click', function(){
        val_ =$(this).html();
        if(val_ == '<i class="fa fa-eye"></i> Show'){
            $(this).attr('value','1').html('<i class="fa fa-eye-slash"></i> Hide');
            $('#tab_bank').show(400);
        }else{
            $(this).attr('value','0').html('<i class="fa fa-eye"></i> Show')
            $('#tab_bank').hide(500);
        }
    });


    function select_payment_item_record(i) {
        var sub_category = 'select_sub_category_record_' + i;
        var payment_item = 'select_payment_item_record_' + i;
        $('#' + payment_item).html('').append('<option value="">-- Select Item --</option>');
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
            }
        });
    }
    
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
</script>