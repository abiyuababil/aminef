<script>
    $('select[name="add_record[category]"]').on('change', function() {
        var sub_category = 'select[name="add_record[sub_category]"]';
        var payment_item = 'select[name="add_record[items][0][item]"]';

        $(sub_category).empty();
        $(sub_category).append('<option value="">-- Select Sub Category --</option>');
        // if($(this).val() != ''){
        get_sub_category($(this).val(), sub_category, payment_item, 'add_record');
        // }
    });

    function get_sub_category(category_type, select_sub_category, payment_item, param) {
        if (param == 'add_record') {
            $('#wrap-request-record0').find('.request-item-record0').each(function() {
                if ($(this).attr('id') != 'request-item-record-0') {
                    $(this).remove();
                }

                $(payment_item).empty();
                $(payment_item).append('<option value="">-- Select Item --</option>');
            });
        } else if (param == 'edit_record') {
            $('#wrap-request-record-edit0').find('.request-item-record-edit').each(function() {
                if ($(this).attr('id') != 'request-item-record-edit-0') {
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

    function select_payment_item_record(i) {
        var sub_category = 'select_sub_category_record_' + i;
        var payment_item = 'select_payment_item_record_' + i;
        $('#' + payment_item).html('');
        $('#' + payment_item).append('<option value="">-- Select Item --</option>');
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

    function add_item_record(i) {
        var name_class = '.request-item-record' + i;
        var warp_request = '#wrap-request-record' + i;

        var sub_category = $('select[name="add_record[sub_category]"]').val();
        var category = $('select[name="add_record[category]"]').val();

        if (sub_category == '') {
            alert('Please Select Sub Category');
            return false;
        }

        var idx = $(name_class).length;
        // console.log(idx)
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/payment_item/add_item_record') ?>',
            data: {
                'idx': idx,
                'i': i,
                'category_type': category,
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

    // write edit review
    $('#mdl_edit_record').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {

            var button = $(event.relatedTarget);
            var recordId = button.data('record_id');
            $("#delete_detail_payment_record").val('');

            if (typeof currentUserReviews !== 'undefined') {
                var data = currentUserReviews[recordId];
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                var payment_date = new Date(data.payment_date);
                $('#payment_id').val(data.id);
                $('#payment_date').val((payment_date.getDate() < 10 ? '0' + payment_date.getDate() : payment_date.getDate()) + ' ' + monthNames[payment_date.getMonth()] + ' ' + payment_date.getFullYear()).attr('autocomplete', 'off');
                $('#description').val(data.description);
                $('#category').val(data.category);
                $('#memo_budget').val(data.user_grantee_grant_memo_id);
                // Hide inactive memo options, but keep the currently assigned one visible & enabled so it POSTs
                var selectMemo = $('#memo_budget');
                selectMemo.find('option.memo-budget-inactive').prop('hidden', true).prop('disabled', true).hide();
                if (data.user_grantee_grant_memo_id) {
                    var currentMemoOpt = selectMemo.find('option[value="' + data.user_grantee_grant_memo_id + '"]');
                    currentMemoOpt.prop('hidden', false).prop('disabled', true).show();
                }
                selectMemo.val(data.user_grantee_grant_memo_id);

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
                $('#bulk_id').val(data.bulk_id);
                $('#admin_note').val(data.admin_note);
                $('#finance_note').val(data.finance_note);
                $('#record_status').val(data.status);
                $('#bank_info_id').val(data.bank_info_id);
                $('#hide-total-payment-record').val(data.total_nominal);
                if (data.proof != null) {
                    $('#btn_proof').attr('href', '<?php echo base_url() ?>' + data.proof).show();
                } else {
                    $('#btn_proof').attr('href', '').hide();
                }
                if (data.invoice != null) {
                    $('#btn_invoice').attr('href', '<?php echo base_url() ?>' + data.invoice).show();
                } else {
                    $('#btn_invoice').attr('href', '').hide();
                }
                if (data.notify_finance == 1) {
                    $('#edit_notify_finance').attr('checked', 'checked');
                }
                if (data.notify_admin == 1) {
                    $('#edit_notify_admin').attr('checked', 'checked');
                }
                if (data.notify_grantee == 1) {
                    $('#edit_notify_grantee').attr('checked', 'checked');
                }

                console.log(data)
                $("#edit_record_priority").val(data.priority);

                if (data.deadline_date != null) {
                    $('#edit_record_deadline_date').datepicker("setDate", new Date(data.deadline_date));
                } else {
                    $('#edit_record_deadline_date').val('');
                }
                $('#wrap-request-record-edit0').find('.request-item-record-edit').each(function() {
                    $(this).remove();
                });

                for (var i = 0; i < data.items.length; i++) {
                    var html = append_edit_record(i);
                    $('#wrap-request-record-edit0').append(html);
                }
                // var html = append_edit_record(i);
                // $('#wrap-request-record-edit0').append(html);

                setoption('select_payment_item_edit', false, data);

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
        };
    });

    function append_edit_record(i) {
        var name_class = '.request-item-record-edit' + i;
        var warp_request = '#wrap-request-record-edit' + i;
        var idx = $(name_class).length;
        var html = '';

        html = '<div id="request-item-record-edit-' + i + '" class="row request-item-record-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select id="select_payment_item_edit' + i + '" name="edit_record[items][' + i + '][item]" form="form" class="form-control select2 select_payment_item_edit">'
        html += '</select>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal IDR</label>'
        html += '<input type="text" form="form" id="nominal_idr_edit' + i + '" class="form-control currency-idr" name="edit_record[items][' + i + '][nominal_idr]">'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal USD</label>'
        html += '<input type="text" form="form" id="nominal_edit' + i + '" class="form-control currency-usd" name="edit_record[items][' + i + '][nominal]">'
        html += '<input type="hidden" form="form" id="id' + i + '" class="form-control" name="edit_record[items][' + i + '][id]">'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Proof of Expense</label>'
        html += '<input type="file" name="proof_of_payment_'+ i +'" class="form-control" style="display: inline;" form="form">'
        html += '<a class="btn btn-xs btn-primary mt-1" id="proof_of_payment_'+ i +'" target="_blank">View</a>'
        html += '<a class="btn btn-xs btn-danger mt-1" id="delete_proof_of_payment_'+ i +'" onclick="remove_payment_item_proof(this, '+ i +', 1);return false;"><i class="fa fa-times"></i></a>'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '<a href="javascript:;" onclick="del_item_id(this, \'request-item-record-edit-' + i + '\')" class="btn btn-danger btn-xs" id=btn_delete' + i + ' style="position:absolute;right:15px;"><i class="fa fa-trash fa-fw"></i></a>'
        html += '</div>'

        return html;

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

    function setoption(ddlID, isFirstOptionEmpty, data) {
        // var arr = currentPaymentItems;
        var arr = function() {
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

        var sub_category = $('select[name="edit_record[sub_category]"]').val();
        var category = $('select[name="edit_record[category]"]').val();

        if (sub_category == '') {
            alert('Please Select Sub Category');
            return false;
        }

        var idx = $(name_class).length;
        // console.log(idx)
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/payment_item/add_edit_item_record') ?>',
            data: {
                'idx': idx,
                'i': i,
                'category_type': category,
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
</script>