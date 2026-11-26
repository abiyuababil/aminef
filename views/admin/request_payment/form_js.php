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
            is_active: '<?php echo $memo_budget->is_active; ?>',
            value : `<?php echo $memo_budget->file_name; ?>`
        });
    <?php } } ?>

    function parseIDRVal(val) {
        if (!val) return 0;
        val = String(val).trim().replace(/[^\d.,-]/g, '');
        if (!val) return 0;
        if (val.indexOf(',') !== -1) {
            val = val.replace(/\./g, '').replace(',', '.');
        } else if (/^\d+\.\d{1,2}$/.test(val)) {
            // Raw float like 15000.00
        } else {
            val = val.replace(/\./g, '');
        }
        return parseFloat(val) || 0;
    }

    function parseUSDVal(val) {
        if (!val) return 0;
        val = String(val).trim().replace(/[^\d.,-]/g, '');
        if (!val) return 0;
        val = val.replace(/,/g, '');
        return parseFloat(val) || 0;
    }

    function updatePaymentItemsSubtotal($table) {
        if (!$table || !$table.length) return;

        let totalIDR = 0;
        let totalUSD = 0;

        $table.find('tbody tr').each(function() {
            let $idrInput = $(this).find('input.payment-item-nominal-idr, input.payment-item-nominal_idr, input.currency-idr').first();
            let $usdInput = $(this).find('input.payment-item-nominal, input.currency-usd').first();

            if ($idrInput.length) {
                totalIDR += parseIDRVal($idrInput.val());
            }
            if ($usdInput.length) {
                totalUSD += parseUSDVal($usdInput.val());
            }
        });

        let formattedIDR = (typeof formatIDR === 'function')
            ? formatIDR(totalIDR)
            : ('Rp ' + totalIDR.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        let formattedUSD = (typeof formatUSD === 'function')
            ? formatUSD(totalUSD)
            : ('$' + totalUSD.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

        $table.find('tfoot .subtotal-idr').text(formattedIDR);
        $table.find('tfoot .subtotal-usd').text(formattedUSD);

        let $scheduleCard = $table.closest('.payment-schedule-list');
        if ($scheduleCard.length) {
            $scheduleCard.find('.accordion-amount').first().text(formattedUSD);
        }
    }

    $(document).on('input change blur keyup', '.payment-items-table input.payment-item-nominal-idr, .payment-items-table input.payment-item-nominal_idr, .payment-items-table input.currency-idr, .payment-items-table input.payment-item-nominal, .payment-items-table input.currency-usd', function() {
        var $table = $(this).closest('.payment-items-table');
        updatePaymentItemsSubtotal($table);
    });

    function show_pcode(el_country, el_pcode) {
        var country_code = $('#' + el_country + ' option:selected').attr('data-pcode');
        if (country_code != undefined)
            $('#' + el_pcode).val('+' + country_code);
    }

    function del_item(el, item_class, key) {
        var deleted = $("#delete_detail_payment").val();
        var deleted_temp = $("#delete_temp_" + key).val();
        var $table = $(el).closest('.payment-items-table');
        if (confirm("Are you sure want to delete this ?")) {
            $(el).closest('.' + item_class).remove();
            $('#' + item_class).remove();
            if ($table.length) {
                updatePaymentItemsSubtotal($table);
            }
        }
            
        var id = $(el).attr('id');
        var temp_id = $(el).attr('temp_id');

        if (deleted == '') {
            $("#delete_detail_payment").val(id);
        } else {
            var join_id = deleted + ',' + id;
            $("#delete_detail_payment").val(join_id);
        }

        if (deleted_temp == '') {
            $("#delete_temp_" + key).val(temp_id);
        } else {
            var temp_join_id = deleted_temp + ',' + temp_id;
            $("#delete_temp_" + key).val(temp_join_id);
        }
    }

    function del_item_inline(el, row_id) {
        if (confirm("Are you sure want to delete this ?")) {
            var $row = row_id ? $('#' + row_id) : $();
            if (!$row.length) {
                $row = $(el).closest('.row');
            }
            $row.remove();
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
            data: {
                id: id,
                grantee_id: grantee_id
            },
            success: function(r) {
                if (r.success == true) {
                    window.location.href = r.redirect;
                }
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

    function del_item_id_travel(el, item_class) {
        var deleted = $("#delete_detail_payment_travel").val();
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('#' + item_class).remove();
        var id = $(el).data('id');
        if (deleted == '') {
            $("#delete_detail_payment_travel").val(id);
        } else {
            var join_id = deleted + ',' + id;
            $("#delete_detail_payment_travel").val(join_id);
        }
    }

    function add_item(i) {
        var name_class = '.request-item' + i;
        var warp_request = '#wrap-request' + i;
        var idx = $(name_class).length;
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_item') ?>?idx=' + idx + '&i=' + i,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });
                updatePaymentItemsSubtotal($(warp_request).closest('.payment-items-table'));
            }
        });
    }

    function add_item_record(i) {
        var name_class = '.request-item-record';
        var warp_request = '#wrap-request-record' + i;
        var idx = $(name_class).length;

        var fiscalyear = $('#fiscal_year').val();
        var grant_id = $('#grant_id').val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_item_record') ?>?idx=' + idx + '&i=' + i + '&grant_id=' + grant_id + '&fiscal_year=' + fiscalyear,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });
                updatePaymentItemsSubtotal($(warp_request).closest('.payment-items-table'));
            }
        });
    }

    function add_item_travel(i) {
        var name_class = '.request-item-travel' + i;
        var warp_request = '#wrap-request-travel' + i;
        var idx = $(name_class).length;
        
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_item_travel') ?>?idx=' + idx + '&i=' + i,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });
                updatePaymentItemsSubtotal($(warp_request).closest('.payment-items-table'));
            }
        });
    }

    function edit_item_record(i) {
        var name_class = '.request-item-record-edit';
        var warp_request = '#wrap-request-record-edit' + i;
        var idx = $(name_class).length;
        var fiscalyear = $('#fiscal_year').val();
        var grant_id = $('#grant_id').val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_edit_item_record') ?>?idx=' + idx + '&i=' + i + '&grant_id=' + grant_id + '&fiscal_year=' + fiscalyear,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });
                updatePaymentItemsSubtotal($(warp_request).closest('.payment-items-table'));
            }
        });
    }

    function edit_item_travel(i) {
        var name_class = '.request-item-travel-edit';
        var warp_request = '#wrap-request-travel-edit' + i;
        var idx = $(name_class).length;
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_edit_item_travel') ?>?idx=' + idx + '&i=' + i,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });
                updatePaymentItemsSubtotal($(warp_request).closest('.payment-items-table'));
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
        var last = $('#last_payment').val();
        var suffix = ordinal_suffix_of((idx + 1));
        var fiscalyear = $('#fiscal_year').val();
        var grant_id = $('#grant_id').val();
        var grantee_id = $("#grantee_id").val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_payment') ?>?idx=' + idx + '&suffix=' + suffix + '&last=' + last + '&fiscal_year=' + fiscalyear + '&grant_id=' + grant_id + '&user_grantee_id=' + grantee_id,
            dataType: 'JSON',
            success: function(r) {
                // Period Start disbursement baru = H+1 dari Period End disbursement sebelumnya.
                var $existing = $('#wrap-payment').find('.payment-schedule-list');
                var prevEndVal = $existing.length ? $existing.last().find('input.to').val() : '';
                var html = r.html;
                $('#wrap-payment').append(html);
                $('#last_payment').val(r.last);
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd M yy",
                    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
                $('input[type="text"], input[type="email"]').attr('autocomplete', 'new-password');
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });
                var $newSchedule = $('#wrap-payment').find('.payment-schedule-list').last();
                var prevEnd = parse_period_start(prevEndVal);
                if (prevEnd) {
                    prevEnd.setDate(prevEnd.getDate() + 1);
                    $newSchedule.find('input.date-periode').val($.datepicker.formatDate('dd M yy', prevEnd));
                    auto_fill_schedule_dates($newSchedule);
                }
                $newSchedule.find('.panel-collapse').collapse('show');
                updatePaymentItemsSubtotal($newSchedule.find('.payment-items-table'));
            }
        });
    }

    function del_file(el, name, label, value = '') {
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



    $("#btn-deleted").click(function() {
        $("#mdl_info").modal();
        event.preventDefault();
    });


    $("#btn-submit").click(function() {
        $(this).prop('disabled', true);
        $('#hide-btn').prop("disabled", true);
        $('#hide-btn-edit').prop("disabled", true);

        var invalid = false;

        $("#wrap-payment").find('.payment-schedule-list').each(function() {
            var date_periode = $(this).find('.panel-body').eq(1)
                .find('input.date-periode').val();

            if (date_periode != '') {
                $(this).closest('div').find(".validation-error-date-periode").addClass('hide');
            } else {
                $(this).closest('div').find(".validation-error-date-periode").removeClass('hide');
                invalid = true;
            }

            var to = $(this).find('.panel-body').eq(1)
                .find('input.to').val();

            if (to != '') {
                $(this).closest('div').find(".validation-error-to").addClass('hide');
            } else {
                $(this).closest('div').find(".validation-error-to").removeClass('hide');
                invalid = true;
            }

            var to = $(this).find('.panel-body').eq(2)
                .find('input.reminder-date').val();
            if (to != '') {
                $(this).closest('div').find(".validation-error-reminder-date").addClass('hide');
            } else {
                $(this).closest('div').find(".validation-error-reminder-date").removeClass('hide');
                invalid = true;
            }

            var payment_item = $(this).find('.panel-body').eq(4);
            var payment_sub_category = payment_item.find('.payment-item-section');

            payment_sub_category.each(function() {
                var payment_sub_category_value = $(this).find('.payment-sub-category').select2('val');
                if (payment_sub_category_value != '') {
                    $(this).closest('div').find(".validation-error-payment-sub-category").addClass('hide');
                } else {
                    $(this).closest('div').find(".validation-error-payment-sub-category").removeClass('hide');
                    invalid = true;
                }

                var payment_item_list = $(this).find('.payment-item-list').select2('val');
                if (payment_item_list != '') {
                    $(this).closest('div').find(".validation-error-payment-item-list").addClass('hide');
                } else {
                    $(this).closest('div').find(".validation-error-payment-item-list").removeClass('hide');
                    invalid = true;
                }

                // var payment_item_nominal = $(this).find('.payment-item-nominal').val();

                // if (payment_item_nominal.length == 0) {
                //     $(this).closest('div').find(".validation-error-payment-nominal").text("Nominal is Required");
                //     $(this).closest('div').find(".validation-error-payment-nominal").removeClass('hide');
                //     invalid = true;
                // } else if (Number(payment_item_nominal) == Number(0)) {
                //     $(this).closest('div').find(".validation-error-payment-nominal").text("Nominal must be greater than zero");
                //     $(this).closest('div').find(".validation-error-payment-nominal").removeClass('hide');
                //     invalid = true;
                // } else {
                //     $(this).closest('div').find(".validation-error-payment-nominal").addClass('hide');
                // }
            });



        });





        // var reminder_date = $(".reminder-date").val();
        // if(reminder_date.length == 0) {
        //     $(".validation-error-reminder-date").removeClass('hide');
        //     invalid = true;
        // }

        // var payment_status = $(".payment-status").val();
        // if(payment_status.length == 0) {
        //     $(".validation-error-payment-status").removeClass('hide');
        //     invalid = true;
        // }

        // var payment_sub_category = $(".payment-sub-category").select2('val');
        // if(payment_sub_category.length == 0) {
        //     $(".validation-error-payment-sub-category").removeClass('hide');
        //     invalid = true;
        // }

        // var payment_item = $(".payment-item").val();
        // if(payment_item.length == 0) {
        //     $(".validation-error-payment-item").removeClass('hide');
        //     invalid = true;
        // }

        // var payment_nominal = $(".payment-nominal").val();
        // if(payment_nominal.length == 0) {
        //     $(".validation-error-payment-nominal").removeClass('hide');
        //     invalid = true;
        // }
        // console.log(date_periode_id);
        if (invalid == true) {
            $(this).prop('disabled', false);
            // Tampilkan error yang tersembunyi di panel tertutup:
            // buka semua panel disbursement yang masih ada error validasi,
            // lalu scroll ke panel error paling atas.
            var $errorPanels = $("#wrap-payment").find('.payment-schedule-list').filter(function() {
                return $(this).find('[class*="validation-error-"]:not(.hide)').length > 0;
            });
            $errorPanels.find('.panel-collapse').collapse('show');
            if ($errorPanels.length) {
                $('html, body').animate({ scrollTop: $errorPanels.first().offset().top - 100 }, 400);
            }
            return false;
        }

        // Enable any inactive memo budget options that are currently selected so they POST
        $('select.memo-budget option:selected').prop('disabled', false);

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/request_payment/validate_payment') ?>',
            dataType: 'JSON',
            data: $("#form").serializeArray(),
            success: function(r) {
                if (r.success == true) {
                    $("#mdl_validate").modal();
                    $("#validate_message").html(r.message);
                    event.preventDefault();
                } else {
                    $("#form").submit();
                }
            }
        });

    });



    $('#dp1671421107903').on('change', function() {
        alert($(this).val())
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

    $("#btn-calculate").click(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/request_payment/calculate_payment') ?>',
            dataType: 'JSON',
            data: $("#form").serializeArray(),
            success: function(r) {
                if (r.success == true) {
                    $("#mdl_validate").modal();
                    $("#validate_message").html(r.message);
                    event.preventDefault();
                }
            }
        });

    })

    $('#mdl_add_record').on('show.bs.modal', function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        let modal = $('#mdl_add_record');
        modal.find('.form-control').prop('disabled', false);
        <?php if (has_permission('payment_record', 'upload_proof_of_expense')) { ?>
            modal.find('.additional-proof-of-expense').html('');
            modal.find('.btn-add-proof-expense').trigger('click');
        <?php } else { ?>
            modal.find('.additional-proof-of-expense').html('<div class="col-md-9"><a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> You do not have permission to upload proof of expense</label></a></div>');
        <?php } ?>
    });

    // write edit support
    $('#mdl_edit_record').on('show.bs.modal', function(event) {
        $('#add_sub_cat_tab').val('Grant Supporting');
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            var button = $(event.relatedTarget);
            var recordId = button.data('record_id');
            $("#delete_detail_payment_record").val('');

            if (typeof currentUserReviews !== 'undefined') {
                var data = currentUserReviews[recordId];
                var baseUrl = window.location.origin;
                $('#payment_id').val(data.id);
                $('#payment_date').datepicker("setDate", new Date(data.payment_date));

                if (data.release_date != null) {
                    $('#edit_record_release_date').datepicker("setDate", new Date(data.release_date));
                } else {
                    $('#edit_record_release_date').val('');
                }

                $('#description').val(data.description);
                $('#release_type').val(data.release_type);
                $('#admin_note').val(data.admin_note);
                $('#finance_note').val(data.finance_note);
                $('#record_status').val(data.status);
                $('#hide-total-payment-record').val(data.total_nominal);

                $("#edit_record_bank_info").val(data.bank_info_id);

                let selected = data.user_grantee_grant_memo_id;
                let option = '<option>Select Memo Budget</option>';
                let is_selected = false;
                for(let i = 0; i<MEMO_BUDGET.length; i++) {
                    if (selected == MEMO_BUDGET[i].id) {
                        is_selected = true;
                    }
                    // Don't disable the currently selected memo (disabled options don't POST)
                    var disabledMemo = (MEMO_BUDGET[i].is_active == 'Yes' || MEMO_BUDGET[i].id == selected) ? '' : 'disabled';
                    option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" '+ (MEMO_BUDGET[i].id == selected ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + (MEMO_BUDGET[i].is_active == 'Yes' ? '' : ' (Inactive)') + '</option>';
                }

                $('select[name="edit_record[user_grantee_grant_memo_id]"]').prop('disabled', false);
                $('select[name="edit_record[user_grantee_grant_memo_id]"]').html(option);
                
                if (is_selected) {
                    $(".memo-budget-payment-record-edit").removeClass('hide');
                }

                if (data.notify_admin == 1) {
                    $('#edit_record_notify_admin').attr('checked', 'checked');
                }
                
                if (data.notify_finance == 1) {
                    $('#edit_record_notify_finance').attr('checked', 'checked');
                }

                if (data.notify_grantee == 1) {
                    $('#edit_record_notify_grantee').attr('checked', 'checked');
                }

                if (data.proof != null) {
                    $("#preview-edit-uploaded-transfer-grant").removeClass('hide');
                    $("#preview-edit-not-uploaded-transfer-grant").addClass('hide');
                    $('#preview-edit-uploaded-transfer-grant').find('a').attr("href", SITE_URL + data.proof)
                } else {
                    $("#preview-edit-uploaded-transfer-grant").addClass('hide');
                    $("#preview-edit-not-uploaded-transfer-grant").removeClass('hide');
                }

                if (data.proof_expense != null) {
                    $("#preview-edit-uploaded-expense-grant").removeClass('hide');
                    $("#preview-edit-not-uploaded-expense-grant").addClass('hide');
                    $('#preview-edit-uploaded-expense-grant').find('a').attr("href", SITE_URL + data.proof_expense);
                    $('.expense-file').removeClass('hide');
                } else {
                    $("#preview-edit-uploaded-expense-grant").addClass('hide');
                    $("#preview-edit-not-uploaded-expense-grant").removeClass('hide');
                    $('.expense-file').addClass('hide');
                }

                if (data.proof_of_conversion != null) {
                    $("#preview-edit-uploaded-conversion-grant").removeClass('hide');
                    $("#preview-edit-not-uploaded-conversion-grant").addClass('hide');
                    $('#preview-edit-uploaded-conversion-grant').find('a').attr("href", SITE_URL + data.proof_of_conversion)
                } else {
                    $("#preview-edit-uploaded-conversion-grant").addClass('hide');
                    $("#preview-edit-not-uploaded-conversion-grant").removeClass('hide');
                }

                for (var i = 0; i < data.items.length; i++) {
                    $('#request-item-record-edit-' + i).remove();
                    let value = data.items[i].memo_budget_id;
                    var html = append_edit_record(i, recordId, value);
                    $('#wrap-request-record-edit0').append(html);
                    setoption('select_payment_item_edit' + i, false, data.items[i]);
                }

                setoptionSubCategory('select_sub_category_edit', false, true, 'Grant Supporting');
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });

                if (data.deadline_date != null) {
                    $('#edit_record_deadline_date').datepicker("setDate", new Date(data.deadline_date));
                } else {
                    $('#edit_record_deadline_date').val('');
                }
                
                $("#edit_record_priority").val(data.priority);

                $.each(data.items, function(key, value) {
                    $('#select_sub_category_edit' + key).val(value.payment_sub_category_id).trigger('change');
                    $("#select_payment_memo_budget_item_edit-" + key).val(value.memo_budget_id).change();
                    // $('#select_payment_item_edit'+key).val(value.payment_item).trigger('change');
                    $('#nominal_idr_edit' + key).val(value.nominal_idr);
                    $('#nominal_edit' + key).val(value.nominal);
                    $('#id' + key).val(value.id);
                    $('#btn_delete' + key).attr('data-id', value.id);
                });

                do_format_input_currency();

                let proof_of_expense_section = $('#mdl_edit_record').find('.additional-proof-of-expense');
                    proof_of_expense_section.html('');
                let proof_of_expenses = currentPaymentProofOfExpenses.filter(item => item.relation_id == recordId);
                
                append_proof_of_expense_element(proof_of_expenses, proof_of_expense_section, 'edit_record[remove_expense_attachment_ids]');

                if(data.bulk_id != null) {
                    $('#mdl_edit_record .form-control').prop('disabled', true);
                    $('#mdl_edit_record .btn').addClass('hide');
                }else{
                    $('#mdl_edit_record .form-control').prop('disabled', false);
                    $('#mdl_edit_record .btn').removeClass('hide');

                }
            }
        };
    });

    $('#mdl_view_record').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {

            var button = $(event.relatedTarget);
            var recordId = button.data('record_id');
            $("#delete_detail_payment_record").val('');

            if (typeof currentUserReviews !== 'undefined') {
                var data = currentUserReviews[recordId];
                var baseUrl = window.location.origin;
                
                $('#payment_id_record_view').val(data.id);
                $('#payment_date_record_view').datepicker("setDate", new Date(data.payment_date)).removeClass('datepicker');;
                $('#release_date_record_view').datepicker("setDate", new Date(data.release_date)).removeClass('datepicker');;
                
                $('#description_record_view').val(data.description);
                $('#release_type_record_view').val(data.release_type);
                $('#admin_note_record_view').val(data.admin_note);
                $('#finance_note_record_view').val(data.finance_note);
                $('#record_status_record_view').val(data.status);
                
                let selected = data.user_grantee_grant_memo_id;
                let option = '<option>-- Select Item --</option>';

                let is_selected = false; 
                for(let i = 0; i<MEMO_BUDGET.length; i++) {
                    // if (MEMO_BUDGET[i].is_active == 'No' && MEMO_BUDGET[i].id != selected) {
                    //     continue;
                    // } 
                    
                    if (selected == MEMO_BUDGET[i].id) {
                        is_selected = true;
                    }

                    var disabledMemo = MEMO_BUDGET[i].is_active == 'Yes' ? '' : 'disabled';
                    option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" '+ (MEMO_BUDGET[i].id == selected ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + '</option>';
                }

                if (is_selected) {
                    $(".memo-budget-payment-record-view").removeClass('hide');
                }
            
                $('select[name="edit_record[user_grantee_grant_memo_id]"]').prop('disabled', true);
                $('select[name="edit_record[user_grantee_grant_memo_id]"]').html(option);

                if (data.notify_admin == 1) {
                    $('#view_record_notify_admin').attr('checked', 'checked').prop('disabled', true);
                }
                
                if (data.notify_finance == 1) {
                    $('#view_record_notify_finance').attr('checked', 'checked').prop('disabled', true);
                }

                if (data.notify_grantee == 1) {
                    $('#view_record_notify_grantee').attr('checked', 'checked').prop('disabled', true);
                }

                $('#hide-total-payment-record_record_view').val(data.total_nominal);

                if (data.proof != null) {
                    $("#preview-view-uploaded-transfer-grant").removeClass('hide');
                    $("#preview-view-not-uploaded-transfer-grant").addClass('hide');
                    $('#preview-view-uploaded-transfer-grant').find('a').attr("href", SITE_URL + data.proof)
                } else {
                    $("#preview-view-uploaded-transfer-grant").addClass('hide');
                    $("#preview-view-not-uploaded-transfer-grant").removeClass('hide');
                }

                if (data.proof_expense != null) {
                    $("#preview-view-uploaded-expense-grant").removeClass('hide');
                    $("#preview-view-not-uploaded-expense-grant").addClass('hide');
                    $('#preview-view-uploaded-expense-grant').find('a').attr("href", SITE_URL + data.proof_expense);
                    $('.expense-file').removeClass('hide');
                } else {
                    $("#preview-view-uploaded-expense-grant").addClass('hide');
                    $("#preview-view-not-uploaded-expense-grant").removeClass('hide');
                    $('.expense-file').addClass('hide');
                }

                if (data.proof_of_conversion != null) {
                    $("#preview-view-uploaded-conversion-grant").removeClass('hide');
                    $("#preview-view-not-uploaded-conversion-grant").addClass('hide');
                    $('#preview-view-uploaded-conversion-grant').find('a').attr("href", SITE_URL + data.proof_of_conversion)
                } else {
                    $("#preview-view-uploaded-conversion-grant").addClass('hide');
                    $("#preview-view-not-uploaded-conversion-grant").removeClass('hide');
                }
                
                $("#view_record_bank_info").val(data.bank_info_id);
                
                for (var i = 0; i < data.items.length; i++) {
                    $('#request-item-record-view-' + i).remove();
                    let value = data.items[i].memo_budget_id;
                    var html = append_view_record(i, value);
                    $('#wrap-request-record-view0').append(html);
                    setoption('select_payment_item_view_record' + i, false, data.items[i]);
                }

                setoptionSubCategory('select_sub_category_view_record', false);
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });

                if (data.deadline_date != null) {
                    $('#view_record_deadline_date').datepicker("setDate", new Date(data.deadline_date));
                } else {
                    $('#view_record_deadline_date').val('');
                }
                
                $("#view_record_priority").val(data.priority);

                $.each(data.items, function(key, value) {
                    $('#select_sub_category_view_record' + key).val(value.payment_sub_category_id).trigger('change');
                    $('#select_payment_item_view_record' + key).val(value.payment_item).trigger('change');
                    $('#nominal_idr_view_record' + key).val(value.nominal_idr);
                    $('#nominal_view_record' + key).val(value.nominal);
                    $('#id_record_view' + key).val(value.id);
                    $('#btn_delete_record_view' + key).attr('data-id', value.id);
                });

                do_format_input_currency();

                let proof_of_expense_section = $('#mdl_view_record').find('.additional-proof-of-expense');
                    proof_of_expense_section.html('');
                let proof_of_expenses = currentPaymentProofOfExpenses.filter(item => item.relation_id == recordId);
                
                append_proof_of_expense_element(proof_of_expenses, proof_of_expense_section, undefined, true);
            }
        };
    });



    $('#mdl_add_travel').on('show.bs.modal', function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        let modal = $('#mdl_add_travel');
        // pastikan tidak ada field yang masih disabled (mis. sisa state bulk edit)
        modal.find('.form-control').prop('disabled', false);
        <?php if (has_permission('payment_record', 'upload_proof_of_expense')) { ?>
            modal.find('.additional-proof-of-expense').html('');
            modal.find('.btn-add-proof-expense').trigger('click');
        <?php } else { ?>
            modal.find('.additional-proof-of-expense').html('<div class="col-md-9"><a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> You do not have permission to upload proof of expense</label></a></div>');
        <?php } ?>
    });

    // write edit travel
    $('#mdl_edit_travel').on('show.bs.modal', function(event) {
        $('#add_sub_cat_tab').val('International Travel');
        $.fn.modal.Constructor.prototype.enforceFocus = function() {

            var button = $(event.relatedTarget);
            var recordId = button.data('record_id');
            $("#delete_detail_payment_travel").val('');

            if (typeof currentPaymentTravel !== 'undefined') {
                var data = currentPaymentTravel[recordId];
                var baseUrl = window.location.origin;
                $('#payment_id_travel').val(data.id);
                $('#payment_date_travel').datepicker("setDate", new Date(data.payment_date));
                if (data.deadline_date != null) {
                    $('#edit_travel_deadline_date').datepicker("setDate", new Date(data.deadline_date));
                } else {
                    $('#edit_travel_deadline_date').val('');
                }
                if (data.release_date != null) {
                    $('#edit_travel_release_date').datepicker("setDate", new Date(data.release_date));
                } else {
                    $('#edit_travel_release_date').val('');
                }
                $('#description_travel').val(data.description);
                $('#release_type_travel').val(data.release_type);
                $('#admin_note_travel').val(data.admin_note);
                $('#finance_note_travel').val(data.finance_note);
                $('#record_status_travel').val(data.status);
                $('#hide-total-payment-record_travel').val(data.total_nominal);

                let selected = data.user_grantee_grant_memo_id;

                let option = '<option>Select Memo Budget</option>';
                for(let i = 0; i<MEMO_BUDGET.length; i++) {
                    // Don't disable the currently selected memo (disabled options don't POST)
                    var disabledMemo = (MEMO_BUDGET[i].is_active == 'Yes' || MEMO_BUDGET[i].id == selected) ? '' : 'disabled';
                    option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" '+ (MEMO_BUDGET[i].id == selected ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + (MEMO_BUDGET[i].is_active == 'Yes' ? '' : ' (Inactive)') + '</option>';
                }

                $('select[name="edit_travel[user_grantee_grant_memo_id]"]').prop('disabled', false);
                $('select[name="edit_travel[user_grantee_grant_memo_id]"]').html(option);
                $("#edit_travel_priority").val(data.priority);

                if (data.notify_admin == 1) {
                    $('#edit_travel_notify_admin').attr('checked', 'checked');
                }
                
                if (data.notify_finance == 1) {
                    $('#edit_travel_notify_finance').attr('checked', 'checked');
                }

                if (data.notify_grantee == 1) {
                    $('#edit_travel_notify_grantee').attr('checked', 'checked');
                }
                
                if (data.proof != null) {
                    $("#preview-edit-uploaded-transfer").removeClass('hide');
                    $("#preview-edit-not-uploaded-transfer").addClass('hide');
                    $('#preview-edit-uploaded-transfer').find('a').attr("href", SITE_URL + data.proof)
                } else {
                    $("#preview-edit-uploaded-transfer").addClass('hide');
                    $("#preview-edit-not-uploaded-transfer").removeClass('hide');
                }

                if (data.proof_expense != null) {
                    $("#preview-edit-uploaded-expense").removeClass('hide');
                    $("#preview-edit-not-uploaded-expense").addClass('hide');
                    $('#preview-edit-uploaded-expense').find('a').attr("href", SITE_URL + data.proof_expense)
                } else {
                    $("#preview-edit-uploaded-expense").addClass('hide');
                    $("#preview-edit-not-uploaded-expense").removeClass('hide');
                }

                if (data.proof_of_conversion != null) {
                    $("#preview-edit-uploaded-conversion").removeClass('hide');
                    $("#preview-edit-not-uploaded-conversion").addClass('hide');
                    $('#preview-edit-uploaded-conversion').find('a').attr("href", SITE_URL + data.proof_of_conversion);
                    $('.expense-file').removeClass('hide');
                } else {
                    $("#preview-edit-uploaded-conversion").addClass('hide');
                    $("#preview-edit-not-uploaded-conversion").removeClass('hide');
                    $('.expense-file').addClass('hide');
                }
                
                $("#edit_travel_bank_info").val(data.bank_info_id);

                for (var i = 0; i < data.items.length; i++) {
                    $('#request-item-travel-edit-' + i).remove();
                    var html = append_edit_travel(i, recordId);
                    $('#wrap-request-travel-edit0').append(html);
                    setoptiontravel('select_payment_item_edit_travel' + i, false, data.items[i]);
                }

                setoptionSubCategorytravel('select_sub_category_edit_travel', false, true, 'International Travel');

                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });

                $.each(data.items, function(key, value) {
                    // $('#select_payment_item_edit_travel'+key).val(value.payment_item).trigger('change');
                    $('#select_sub_category_edit_travel' + key).val(value.payment_sub_category_id).trigger('change');;
                    $('#nominal_idr_edit_travel' + key).val(value.nominal_idr);
                    $('#nominal_edit_travel' + key).val(value.nominal);
                    $('#id_travel' + key).val(value.id);
                    $('#btn_delete_travel' + key).attr('data-id', value.id);
                });

                do_format_input_currency();

                let proof_of_expense_section = $('#mdl_edit_travel').find('.additional-proof-of-expense');
                    proof_of_expense_section.html('');
                let proof_of_expenses = currentPaymentProofOfExpenses.filter(item => item.relation_id == recordId);
                
                append_proof_of_expense_element(proof_of_expenses, proof_of_expense_section, 'edit_travel[remove_expense_attachment_ids]');
            }
        };
    });

    $('#mdl_view_travel').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {

            var button = $(event.relatedTarget);
            var recordId = button.data('record_id');
            $("#delete_detail_payment_travel").val('');

            if (typeof currentPaymentTravel !== 'undefined') {
                var data = currentPaymentTravel[recordId];
                var baseUrl = window.location.origin;
                $('#payment_id_travel_view').val(data.id);
                $('#payment_date_travel_view').datepicker("setDate", new Date(data.payment_date)).removeClass('datepicker');
                $('#release_date_travel_view').datepicker("setDate", new Date(data.release_date)).removeClass('datepicker');
                $('#description_travel_view').val(data.description);
                $('#release_type_travel_view').val(data.release_type);
                $('#admin_note_travel_view').val(data.admin_note);
                $('#finance_note_travel_view').val(data.finance_note);
                $('#record_status_travel_view').val(data.status);
                
                let selected = data.user_grantee_grant_memo_id;
                let option = '<option>Select Memo Budget</option>';
                for(let i = 0; i<MEMO_BUDGET.length; i++) {
                    // if (MEMO_BUDGET[i].is_active == 'No' && MEMO_BUDGET[i].id != selected) {
                    //     continue;
                    // } 

                    var disabledMemo = MEMO_BUDGET[i].is_active == 'Yes' ? '' : 'disabled';
                    option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" '+ (MEMO_BUDGET[i].id == selected ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + '</option>';
                }

                $('select[name="edit_record[user_grantee_grant_memo_id]"]').prop('disabled', true);
                
                $('select[name="edit_record[user_grantee_grant_memo_id]"]').html(option);
                
                if (data.notify_admin == 1) {
                    $('#view_travel_notify_admin').attr('checked', 'checked').prop('disabled', true);
                }
                
                if (data.notify_finance == 1) {
                    $('#view_travel_notify_finance').attr('checked', 'checked').prop('disabled', true);
                }

                if (data.notify_grantee == 1) {
                    $('#view_travel_notify_grantee').attr('checked', 'checked').prop('disabled', true);
                }

                $('#hide-total-payment-record_travel_view').val(data.total_nominal);

                if (data.proof != null) {
                    $("#preview-view-uploaded-transfer").removeClass('hide');
                    $("#preview-view-not-uploaded-transfer").addClass('hide');
                    $('#preview-view-uploaded-transfer').find('a').attr("href", SITE_URL + data.proof)
                } else {
                    $("#preview-view-uploaded-transfer").addClass('hide');
                    $("#preview-view-not-uploaded-transfer").removeClass('hide');
                }

                if (data.proof_expense != null) {
                    $("#preview-view-uploaded-expense").removeClass('hide');
                    $("#preview-view-not-uploaded-expense").addClass('hide');
                    $('#preview-view-uploaded-expense').find('a').attr("href", SITE_URL + data.proof_expense);
                    $('.uploaded-file').removeClass('hide');
                } else {
                    $("#preview-view-uploaded-expense").addClass('hide');
                    $("#preview-view-not-uploaded-expense").removeClass('hide');
                    $('.uploaded-file').addClass('hide');
                }

                if (data.proof_of_conversion != null) {
                    $("#preview-view-uploaded-conversion").removeClass('hide');
                    $("#preview-view-not-uploaded-conversion").addClass('hide');
                    $('#preview-view-uploaded-conversion').find('a').attr("href", SITE_URL + data.proof_of_conversion)
                } else {
                    $("#preview-view-uploaded-conversion").addClass('hide');
                    $("#preview-view-not-uploaded-conversion").removeClass('hide');
                }

                $("#view_travel_bank_info").val(data.bank_info_id);

                for (var i = 0; i < data.items.length; i++) {
                    $('#request-item-travel-view-' + i).remove();
                    var html = append_view_travel(i);
                    $('#wrap-request-travel-view0').append(html);
                    setoptiontravel('select_payment_item_view_travel' + i, false, data.items[i]);
                }

                setoptionSubCategorytravel('select_sub_category_view_travel', false);

                if (data.deadline_date != null) {
                    $('#view_travel_deadline_date').datepicker("setDate", new Date(data.deadline_date));
                } else {
                    $('#view_travel_deadline_date').val('');
                }
                
                $("#view_travel_priority").val(data.priority);

                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });

                $.each(data.items, function(key, value) {
                    $('#select_sub_category_view_travel' + key).val(value.payment_sub_category_id).trigger('change');
                    $('#select_payment_item_view_travel' + key).val(value.payment_item).trigger('change');
                    $('#nominal_idr_view_travel' + key).val(value.nominal_idr);
                    $('#nominal_view_travel' + key).val(value.nominal);
                    $('#id_travel_view' + key).val(value.id);
                    $('#btn_delete_travel_view' + key).attr('data-id', value.id);
                });

                do_format_input_currency();

                let proof_of_expense_section = $('#mdl_view_travel').find('.additional-proof-of-expense');
                    proof_of_expense_section.html('');
                let proof_of_expenses = currentPaymentProofOfExpenses.filter(item => item.relation_id == recordId);
                
                append_proof_of_expense_element(proof_of_expenses, proof_of_expense_section, undefined, true);
            }
        };
    });

    $('input[name="add_travel[payment_date]"]').on('change', function(){
        let val = $(this).val();
        if (val) {
            let date = new Date(val);
            date.setDate(date.getDate() + 7); 

            let options = { day: '2-digit', month: 'short', year: 'numeric' };
            let deadline = date.toLocaleDateString('en-GB', options).replace(',', '');

            $('input[name="add_travel[deadline_date]"]').val(deadline);
        }
    });


    $('input[name="edit_travel[payment_date]"]').on('change', function(){
        let val = $(this).val();
        if (val) {
            let date = new Date(val);
            date.setDate(date.getDate() + 7); 

            let options = { day: '2-digit', month: 'short', year: 'numeric' };
            let deadline = date.toLocaleDateString('en-GB', options).replace(',', '');

            $('input[name="edit_travel[deadline_date]"]').val(deadline);
        }
    });

    $('input[name="add_clea[payment_date]"]').on('change', function(){
        let val = $(this).val();
        if (val) {
            let date = new Date(val);
            date.setDate(date.getDate() + 7); 

            let options = { day: '2-digit', month: 'short', year: 'numeric' };
            let deadline = date.toLocaleDateString('en-GB', options).replace(',', '');

            $('input[name="add_clea[deadline_date]"]').val(deadline);
        }
    });


    $('input[name="edit_clea[payment_date]"]').on('change', function(){
        let val = $(this).val();
        if (val) {
            let date = new Date(val);
            date.setDate(date.getDate() + 7); 

            let options = { day: '2-digit', month: 'short', year: 'numeric' };
            let deadline = date.toLocaleDateString('en-GB', options).replace(',', '');

            $('input[name="edit_clea[deadline_date]"]').val(deadline);
        }
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

    function setoption(ddlID, isFirstOptionEmpty, data) {
        // var arr = currentPaymentItems;
        var arr = function() {
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
        setDDLValues(ddlID, isFirstOptionEmpty, arr);
    }

    function setoptiontravel(ddlID, isFirstOptionEmpty, data) {
        // var arr = currentPaymentItemsTravel;
        var arr = function() {
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
        setDDLValues(ddlID, isFirstOptionEmpty, arr);
    }

    function setDDLValues(ddlID, isFirstOptionEmpty, arr) {
        clearDDL(ddlID);

        if (isFirstOptionEmpty) {
            $('#' + ddlID).append("<option value=''>All</option>");
        }
        for (var i = 0; i < arr.length; i++) {
            $('#' + ddlID).append("<option value='" + arr[i].id + "'>" + arr[i].payment_item + "</option>");
        }
    }

    function setoptionSubCategorytravel(ddlID, isFirstOptionEmpty, withAddNew, category) {
        var arr = currentSubCategoryTravel;
        setDDLValuesSubCategory(ddlID, isFirstOptionEmpty, arr, withAddNew, category);
    }

    function setoptionSubCategory(ddlID, isFirstOptionEmpty, withAddNew, category) {
        var arr = currentSubCategoryRecord;
        setDDLValuesSubCategory(ddlID, isFirstOptionEmpty, arr, withAddNew, category);
    }

    function setoptionSubCategoryClea(ddlID, isFirstOptionEmpty, withAddNew, category) {
        var arr = currentSubCategoryClea;
        setDDLValuesSubCategory(ddlID, isFirstOptionEmpty, arr, withAddNew, category);
    }

    function setDDLValuesSubCategory(ddlID, isFirstOptionEmpty, arr, withAddNew, category) {
        clearDDL(ddlID);

        if (isFirstOptionEmpty) {
            $('.' + ddlID).append("<option value=''>All</option>");
        }

        for (var i = 0; i < arr.length; i++) {
            $('.' + ddlID).append("<option value='" + arr[i].id + "'>" + arr[i].name + "</option>");
        }

        if (withAddNew) {
            var addNewLabel = '<span class="glyphicon glyphicon-plus"></span> Add Sub Category';
            $('.' + ddlID).each(function() {
                var $sel = $(this);
                if ($sel.find('option[value="__add_new__"]').length === 0) {
                    $sel.append('<option value="__add_new__" data-category="' + (category || '') + '" title="sub_category"> ' + addNewLabel + '</option>');
                }
            });
        }
    }

    function clearDDL(ddlID) {
        $("." + ddlID).prop('');
    }

    function append_edit_record(i, recordId, value) {
        var name_class = '.request-item-record-edit' + i;
        var warp_request = '#wrap-request-record-edit' + i;
        var idx = $(name_class).length;
        var html = '';
        let option = '<option value="" '+ (value == null ? 'selected' : '') +'>Select Memo Budget</option>';
        for(let i = 0; i<MEMO_BUDGET.length; i++) {
            // if (MEMO_BUDGET[i].is_active == 'No' && MEMO_BUDGET[i].id != value) {
            //      continue;
            // } 
            var disabledMemo = MEMO_BUDGET[i].is_active == 'Yes' ? '' : 'disabled';
            option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" ' + (MEMO_BUDGET[i].id == value ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + '</option>';
        }
        
        let memo_budget = '<div class="col-lg-12">' +
                                '<div class="form-group" style="margin-bottom:0;">' +
                                    '<label>Memo Budget</label>' +
                                    '<select onchange="select_edit_payment_item_record(\'' + i + '\', ' + recordId + ')" id="select_payment_memo_budget_item_edit-' + i + '" class="record-payment-memo-budget form-control" style="width:100%" form="form" name="edit_record[items]['+i+'][memo_budget_id]">' +
                                         option +
                                    '</select>'+
                                    '<div class="text-danger invalid-tooltip record-payment-item-validation hide" style="display: block;">Payment Item is Required</div>' +
                                '</div>' +
                            '</div>';
        html = '<div id="request-item-record-edit-' + i + '" class="row request-item-record-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">'
        html += memo_budget
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Sub Category</label>'
        html += '<select id="select_sub_category_edit' + i + '" name="edit_record[items][' + i + '][sub_category]" class="record-payment-sub-category form-control select2 select_sub_category_edit">'
        html += '</select>'
        html += '<div class="text-danger invalid-tooltip record-payment-sub-category-validation hide" style="display: block;">Sub Category is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select onchange="remove_error(' + "'" + 'record-payment-item-validation' + "'" +')" id="select_payment_item_edit' + i + '" name="edit_record[items][' + i + '][item]" class="record-payment-item form-control select2 select_payment_item_edit">'
        html += '</select>'
        html += '<div class="text-danger invalid-tooltip record-payment-item-validation hide" style="display: block;">Payment Item is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal IDR</label>'
        html += '<input onchange="remove_error(' + "'" + 'record-payment-nominal-idr-validation' + "'" +')" type="text" id="nominal_idr_edit' + i + '" class="currency-idr record-payment-nominal-idr form-control" name="edit_record[items][' + i + '][nominal_idr]">'
        html += '<div class="text-danger invalid-tooltip record-payment-nominal-idr-validation hide" style="display: block;">Nominal is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal USD</label>'
        html += '<input onchange="remove_error(' + "'" + 'record-payment-nominal-validation' + "'" +')" type="text" id="nominal_edit' + i + '" class="currency-usd record-payment-nominal form-control" name="edit_record[items][' + i + '][nominal]">'
        html += '<input type="hidden" id="id' + i + '" class="form-control" name="edit_record[items][' + i + '][id]">'
        html += '<div class="text-danger invalid-tooltip record-payment-nominal-validation hide" style="display: block;">Nominal is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '<a href="javascript:;" onclick="del_item_id(this, \'request-item-record-edit-' + i + '\')" class="btn btn-danger" id=btn_delete' + i + ' style="position:absolute;right:15px;"><i class="fa fa-trash fa-fw"></i></a>'
        html += '</div>'

        return html;

    }

    function append_edit_clea(i, recordId, value) {
        var name_class = '.request-item-clea-edit' + i;
        var warp_request = '#wrap-request-clea-edit' + i;
        var idx = $(name_class).length;
        var html = '';
        let option = '<option value="" '+ (value == null ? 'selected' : '') +'>Select Memo Budget</option>';
        for(let i = 0; i<MEMO_BUDGET.length; i++) {
            // if (MEMO_BUDGET[i].is_active == 'No' && MEMO_BUDGET[i].id != value) {
            //      continue;
            // } 
            var disabledMemo = MEMO_BUDGET[i].is_active == 'Yes' ? '' : 'disabled';
            option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" ' + (MEMO_BUDGET[i].id == value ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + '</option>';
        }
        
        let memo_budget = '<div class="col-lg-12">' +
                                '<div class="form-group" style="margin-bottom:0;">' +
                                    '<label>Memo Budget</label>' +
                                    '<select id="select_payment_memo_budget_item_edit-' + i + '" class="clea-payment-memo-budget form-control select2" style="width:100%" form="form" name="edit_clea[items]['+i+'][memo_budget_id]">' +
                                         option +
                                    '</select>'+
                                    '<div class="text-danger invalid-tooltip clea-payment-memo-budget-validation hide">Memo Budget is Required</div>' +
                                '</div>' +
                            '</div>';
        html = '<div id="request-item-clea-edit-' + i + '" class="row request-item-clea-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">'
        html += memo_budget
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Sub Category</label>'
        html += '<select onchange="select_edit_payment_item_clea(\'' + i + '\', ' + recordId + ')" id="select_sub_category_edit_clea' + i + '" name="edit_clea[items][' + i + '][sub_category]" class="clea-payment-sub-category form-control select2 select_sub_category_edit_clea">'
        html += '</select>'
        html += '<div class="text-danger invalid-tooltip clea-payment-sub-category-validation hide" style="display: block;">Sub Category is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select onchange="remove_error(' + "'" + 'clea-payment-item-validation' + "'" +')" id="select_payment_item_edit_clea' + i + '" name="edit_clea[items][' + i + '][item]" class="clea-payment-item form-control select2 select_payment_item_edit_clea">'
        html += '</select>'
        html += '<div class="text-danger invalid-tooltip clea-payment-item-validation hide" style="display: block;">Payment Item is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal IDR</label>'
        html += '<input onchange="remove_error(' + "'" + 'clea-payment-nominal-idr-validation' + "'" +')" type="text" id="nominal_idr_edit' + i + '" class="currency-idr clea-payment-nominal-idr form-control" name="edit_clea[items][' + i + '][nominal_idr]">'
        html += '<div class="text-danger invalid-tooltip clea-payment-nominal-idr-validation hide" style="display: block;">Nominal is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal USD</label>'
        html += '<input onchange="remove_error(' + "'" + 'clea-payment-nominal-validation' + "'" +')" type="text" id="nominal_edit' + i + '" class="currency-usd clea-payment-nominal form-control" name="edit_clea[items][' + i + '][nominal]">'
        html += '<input type="hidden" id="id' + i + '" class="form-control" name="edit_clea[items][' + i + '][id]">'
        html += '<div class="text-danger invalid-tooltip clea-payment-nominal-validation hide" style="display: block;">Nominal is Required</div>'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '<a href="javascript:;" onclick="del_item_id(this, \'request-item-clea-edit-' + i + '\')" class="btn btn-danger" id=btn_delete' + i + ' style="position:absolute;right:15px;"><i class="fa fa-trash fa-fw"></i></a>'
        html += '</div>'

        return html;

    }

    function append_edit_travel(i, recordId) {
        var name_class = '.request-item-travel-edit' + i;
        var warp_request = '#wrap-request-travel-edit' + i;
        var idx = $(name_class).length;
        var html = '';

        html = '<div id="request-item-travel-edit-' + i + '" class="row request-item-travel-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Sub Category</label>'
        html += '<select id="select_sub_category_edit_travel' + i + '" onchange="select_edit_payment_item_travel(\'' + i + '\', ' + recordId + ')" name="edit_travel[items][' + i + '][sub_category]" class="travel-payment-sub-category form-control select2 select_sub_category_edit_travel">'
        html += '</select>'
        html += '<div class="text-danger invalid-tooltip travel-payment-sub-category-validation hide" style="display: block;">Sub Category is Required</div>';
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select onchange="remove_error(' + "'" + 'travel-payment-item-validation' + "'" +')" id="select_payment_item_edit_travel' + i + '" name="edit_travel[items][' + i + '][item]" class="travel-payment-item form-control select2 select_payment_item_edit_travel">'
        html += '</select>'
        html += '<div class="text-danger invalid-tooltip travel-payment-item-validation hide" style="display: block;">Payment Item is Required</div>';
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal IDR</label>'
        html += '<input onchange="remove_error(' + "'" + 'travel-payment-nominal-idr-validation' + "'" +')" type="text" id="nominal_idr_edit_travel' + i + '" class="currency-idr travel-payment-nominal-idr form-control" name="edit_travel[items][' + i + '][nominal_idr]">'
        html += '<div class="text-danger invalid-tooltip travel-payment-nominal-idr-validation hide" style="display: block;">Nominal is Required</div>';
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal USD</label>'
        html += '<input onchange="remove_error(' + "'" + 'travel-payment-nominal-validation' + "'" +')" type="text" id="nominal_edit_travel' + i + '" class="currency-usd travel-payment-nominal form-control" name="edit_travel[items][' + i + '][nominal]">'
        html += '<input type="hidden" id="id_travel' + i + '" class="form-control" name="edit_travel[items][' + i + '][id]">'
        html += '<div class="text-danger invalid-tooltip travel-payment-nominal-validation hide" style="display: block;">Nominal is Required</div>';
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '<a href="javascript:;" onclick="del_item_id_travel(this, \'request-item-travel-edit-' + i + '\')" class="btn btn-danger" id=btn_delete_travel' + i + ' style="position:absolute;right:15px;"><i class="fa fa-trash fa-fw"></i></a>'
        html += '</div>'

        return html;

    }

    function append_view_travel(i) {
        var name_class = '.request-item-travel-view' + i;
        var warp_request = '#wrap-request-travel-view' + i;
        var idx = $(name_class).length;
        var html = '';

        html = '<div id="request-item-travel-view-' + i + '" class="row request-item-travel-view mt-3" style="padding:10px">'
        html += '<div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Sub Category</label>'
        html += '<select id="select_sub_category_view_travel' + i + '" class="form-control select2 select_sub_category_view_travel" disabled>'
        html += '</select>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select id="select_payment_item_view_travel' + i + '" class="form-control select2 select_payment_item_view_travel" disabled>'
        html += '</select>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal </label>'
        html += '<input type="text" id="nominal_idr_view_travel' + i + '" class="currency-idr form-control" disabled>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal </label>'
        html += '<input type="text" id="nominal_view_travel' + i + '" class="currency-usd form-control" disabled>'
        html += '<input type="hidden" id="id_travel' + i + '" class="form-control" disabled>'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '</div>'

        return html;

    }


    function append_view_record(i, value) {

        var name_class = '.request-item-record-view' + i;
        var warp_request = '#wrap-request-record-view' + i;
        var idx = $(name_class).length;
        let option = '<option value="" '+ (value == null ? 'selected' : '') +'>Select Memo Budget</option>';
        for(let i = 0; i<MEMO_BUDGET.length; i++) {
            // if (MEMO_BUDGET[i].is_active == 'No' && MEMO_BUDGET[i].id != value) {
            //      continue;
            // } 
            var disabledMemo = MEMO_BUDGET[i].is_active == 'Yes' ? '' : 'disabled';
            option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" ' + (MEMO_BUDGET[i].id == value ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + '</option>';
        }
        
        let memo_budget = '<div class="col-lg-12">' +
                                '<div class="form-group" style="margin-bottom:0;">' +
                                    '<label>Memo Budget</label>' +
                                    '<select disabled id="select_payment_memo_budget_item_edit-' + i + '" class="record-payment-memo-budget form-control" style="width:100%" form="form" name="edit_record[items]['+i+'][memo_budget_id]">' +
                                         option +
                                    '</select>'+
                                    '<div class="text-danger invalid-tooltip record-payment-item-validation hide" style="display: block;">Payment Item is Required</div>' +
                                '</div>' +
                            '</div>';
        html = '<div id="request-item-record-edit-' + i + '" class="row request-item-record-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">'
        html += memo_budget
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Sub Category</label>'
        html += '<select id="select_sub_category_view_record' + i + '" class="record-payment-sub-category form-control select2 select_sub_category_view_record" disabled>'
        html += '</select>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select id="select_payment_item_view_record' + i + '" class="record-payment-item form-control select2 select_payment_item_view_record" disabled>'
        html += '</select>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal IDR</label>'
        html += '<input type="text" id="nominal_idr_view_record' + i + '" class="currency-idr form-control" disabled>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-3">'
        html += '<div class="form-group">'
        html += '<label>Nominal </label>'
        html += '<input type="text" id="nominal_view_record' + i + '" class="currency-usd form-control" disabled>'
        html += '<input type="hidden" id="id_record' + i + '" class="record-payment-nominal form-control" disabled>'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '</div>'

        return html;

    }

    function append_view_clea(i, value) {

        var name_class = '.request-item-clea-view' + i;
        var warp_request = '#wrap-request-clea-view' + i;
        var idx = $(name_class).length;
        let option = '<option value="" '+ (value == null ? 'selected' : '') +'>Select Memo Budget</option>';
        for(let i = 0; i<MEMO_BUDGET.length; i++) {
            // if (MEMO_BUDGET[i].is_active == 'No' && MEMO_BUDGET[i].id != value) {
            //     continue;
            // } 
            var disabledMemo = MEMO_BUDGET[i].is_active == 'Yes' ? '' : 'disabled';
            option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" ' + (MEMO_BUDGET[i].id == value ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + '</option>';
        }

        let memo_budget = '<div class="col-lg-12">' +
                                '<div class="form-group" style="margin-bottom:0;">' +
                                    '<label>Memo Budget</label>' +
                                    '<select disabled id="select_payment_memo_budget_item_edit-' + i + '" class="clea-payment-memo-budget form-control" style="width:100%" form="form" name="edit_clea[items]['+i+'][memo_budget_id]">' +
                                        option +
                                    '</select>'+
                                    '<div class="text-danger invalid-tooltip clea-payment-item-validation hide" style="display: block;">Payment Item is Required</div>' +
                                '</div>' +
                            '</div>';
            html = '<div id="request-item-clea-edit-' + i + '" class="row request-item-clea-edit mt-3" style="padding:10px">'
            html += '<div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">'
            html += memo_budget
            html += '<div class="col-lg-3">'
            html += '<div class="form-group">'
            html += '<label>Sub Category</label>'
            html += '<select id="select_sub_category_view_clea' + i + '" class="clea-payment-sub-category form-control select2 select_sub_category_view_clea" disabled>'
            html += '</select>'
            html += '</div>'
            html += '</div>'
            html += '<div class="col-lg-3">'
            html += '<div class="form-group">'
            html += '<label>Payment Item</label>'
            html += '<select id="select_payment_item_view_clea' + i + '" class="clea-payment-item form-control select2 select_payment_item_view_clea" disabled>'
            html += '</select>'
            html += '</div>'
            html += '</div>'
            html += '<div class="col-lg-3">'
            html += '<div class="form-group">'
            html += '<label>Nominal IDR</label>'
            html += '<input type="text" id="nominal_idr_view_clea' + i + '" class="currency-idr form-control" disabled>'
            html += '</div>'
            html += '</div>'
            html += '<div class="col-lg-3">'
            html += '<div class="form-group">'
            html += '<label>Nominal </label>'
            html += '<input type="text" id="nominal_view_clea' + i + '" class="currency-usd form-control" disabled>'
            html += '<input type="hidden" id="id_clea' + i + '" class="clea-payment-nominal form-control" disabled>'
            html += '</div>'
            html += '</div>'
            html += '</div>'
            html += '</div>'

        return html;

        }

    // autosave
    function save() {
        //     setTimeout( function(){ 
        //     var user_id = $('#user_id').val();
        //     var grantee_grant_id = $('#grantee_grant_id').val();
        //     var data_post = $("#form").serializeArray();
        //     data_post.push({
        //         name: 'user_id', value: user_id
        //     });
        //     data_post.push({
        //         name: 'grantee_grant_id', value: grantee_grant_id
        //     });
        //     $.ajax({
        //         type: 'POST',
        //         url: '<?php echo site_url('admin/request_payment/autosave_payment') ?>',
        //         dataType: 'JSON',
        //         data: data_post,
        //         success: function(r) {
        //         if(r.success == false){
        //             $("#mdl_validate").modal(); 
        //             $("#validate_message").html(r.message); 
        //             event.preventDefault();
        //         }else{
        //             $("#success-alert").fadeTo(15000, 500).slideUp(500, function() {
        //             $("#success-alert").slideUp(500);
        //             });
        //             for (var i = 0; i < r.index; i++) {
        //                 $('#delete_temp_'+i).val('');
        //             }
        //         }
        //         }
        //     });
        // }  , 300000 ); // in ms
        // backsave();
    }

    function backsave() {
        //     setTimeout( function(){ 
        //         save();
        // }  , 300000 ); // in ms

    }

    $(document).ready(function() {
        save();
        $('.payment-items-table').each(function() {
            updatePaymentItemsSubtotal($(this));
        });
        $('.select2').select2({
            theme: 'bootstrap',
            templateResult: function (data) {
                if (data.id === '__add_new__') {
                    return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                }
                return data.text;
            }
        });

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

        $("#success-alert").hide();
    });
    $('#show_hide_bank').on('click', function() {
        val_ = $(this).html();
        if (val_ == '<i class="fa fa-eye"></i> Show') {
            $(this).attr('value', '1').html('<i class="fa fa-eye-slash"></i> Hide');
            $('#tab_bank').show();
        } else {
            $(this).attr('value', '0').html('<i class="fa fa-eye"></i> Show')
            $('#tab_bank').hide();
        }
    });

    function update_to_release(event) {
        var modal = $(event).data("modal");
        
        $("#" + modal + " .status").val("2");
    }

    function update_to_release_payment(key) {
        $("#payment_status_" + key).val("3");
    }

    function select_payment_item(i) {
        var sub_category = 'sub_category_' + i;
        var payment_item = 'payment_item_' + i;
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
                $('#' + payment_item).append('<option value="__add_new__" data-type="payment_item" data-category="payment_category_support" data-subcategory="sub_category_'+i+'"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
            }
        });

        $("#" + sub_category).closest('div').find('.validation-error-payment-sub-category').addClass('hide');
    }

    function select_payment_item_travel(i) {
        var sub_category = 'select_sub_category_travel_' + i;
        var payment_item = 'select_payment_item_travel_' + i;
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
                $('#' + payment_item).append('<option value="__add_new__" data-type="payment_item" data-category="payment_category_support" data-subcategory="select_sub_category_travel_'+i+'"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
            }
        });
        $("#" + sub_category).closest('div').find('.travel-payment-sub-category-validation').addClass('hide');
    }

    function select_edit_payment_item_travel(i, recordId) {
        var sub_category = 'select_sub_category_edit_travel' + i;
        var payment_item = 'select_payment_item_edit_travel' + i;
        $('#' + payment_item).html('');
        $('#' + payment_item).append('<option value="">-- Select Item --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/get_payment_item_by_sub_category') ?>/' + $('#' + sub_category).val(),
            dataType: 'JSON',
            success: function(r) {
                var data = currentPaymentTravel[recordId];
                $.each(r, function(id, val) {
                    if ($('#' + payment_item + ' option[value="' + val.id + '"]').length === 0) {
                        $('#' + payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                    }
                    if (data) {
                        $('#' + payment_item).val(data.items[i].payment_item).trigger('change');
                    }
                });
                $('#' + payment_item).append('<option value="__add_new__" data-type="payment_item" data-category="payment_category_support" data-subcategory="select_sub_category_edit_travel'+i+'"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
            }
        });
        $("#" + sub_category).closest('div').find('.travel-payment-sub-category-validation').addClass('hide');
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
                $('#' + payment_item).append('<option value="__add_new__" data-type="payment_item" data-category="category_non_grantee" data-subcategory="select_sub_category_record_'+i+'"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
            }
        });
        $("#" + sub_category).closest('div').find('.record-payment-sub-category-validation').addClass('hide');
    }

    function select_edit_payment_item_record(i, recordId) {
        var sub_category = 'select_sub_category_edit' + i;
        var payment_item = 'select_payment_item_edit' + i;
        $('#' + payment_item).empty();
        $('#' + payment_item).html('');
        $('#' + payment_item).append('<option value="">-- Select Item --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/get_payment_item_by_sub_category') ?>/' + $('#' + sub_category).val(),
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    var data = currentUserReviews[recordId];
                    if ($('#' + payment_item + ' option[value="' + val.id + '"]').length === 0) {
                        $('#' + payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                    }
                    if (data) {
                        $('#' + payment_item).val(data.items[i].payment_item).trigger('change');
                    }
                });
                $('#' + payment_item).append('<option value="__add_new__" data-type="payment_item" data-category="payment_category_support" data-subcategory="select_sub_category_edit'+i+'"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
            }
        });
        $("#" + sub_category).closest('div').find('.record-payment-sub-category-validation').addClass('hide'); 
    }

    //Payment International Travel Validation
    $("#btn-submit-travel, #btn-submit-travel-edit").on('click', function() {
        $(this).addClass("hide");
        $(".btn-submit-travel-disabled").each(function(){
            $(this).removeClass('hide');
        });
        var action = $(this).data('action');
        var payment_date = $(".payment-date-international-input").val();
        if (payment_date == '') {
            var dt = $("#payment_date_travel").val();
            payment_date = dt;
        }

        var invalid = false;
        if (payment_date == '') {
            $(".payment-date-international-travel").removeClass('hide');
            invalid = true;
        }
        var payment_item_create = $('#wrap-request-travel0');
        var paymnet_item_edit = $("#wrap-request-travel-edit0");



        var payment_item = payment_item_create;
        if (action != 'create') {
            var payment_item = paymnet_item_edit;
            var status = $("#record_status_travel").val();
        }else{
            var status = $("#status").val();
        }

        var payment_sub_category = payment_item.find('.payment-item-section');

        payment_sub_category.each(function() {
            var payment_sub_category_value = $(this).find('.travel-payment-sub-category').select2('val');

            if (payment_sub_category_value == null) {
                invalid = true;
                $(this).closest('div').find(".travel-payment-sub-category-validation").removeClass('hide');
            }else if (payment_sub_category_value != '') {
                $(this).closest('div').find(".travel-payment-sub-category-validation").addClass('hide');
            } else {
                $(this).closest('div').find(".travel-payment-sub-category-validation").removeClass('hide');
                invalid = true;
            }

            var payment_item_list = $(this).find('.travel-payment-item').select2('val');
            if (payment_item_list != '') {
                $(this).closest('div').find(".travel-payment-item-validation").addClass('hide');
            } else {
                $(this).closest('div').find(".travel-payment-item-validation").removeClass('hide');
                invalid = true;
            }

            // var payment_item_nominal = $(this).find('.travel-payment-nominal').val();
            // if (payment_item_nominal == '' || payment_item_nominal == 0) {
            //     if(status == 3){
            //         $(this).closest('div').find(".travel-payment-nominal-validation").addClass('hide');
            //     }else{
            //         $(this).closest('div').find(".travel-payment-nominal-validation").removeClass('hide');
            //         invalid = true;
            //     }
            // } else {
            //     $(this).closest('div').find(".travel-payment-nominal-validation").addClass('hide');
            // }

        });
        if (invalid == true) {
            $(".btn-submit-travel-disabled").each(function(){
                $(this).addClass('hide');
            });
            $(this).removeClass("hide");
            return false;
        }
    });

    $(".payment-date-international-input").on('change', function() {
        $(".payment-date-international-travel").addClass('hide');
    });

    $('.travel-payment-sub-category').on('change', function() {
        $(this).closest('div').find('.travel-payment-sub-category-validation').addClass('hide');
    });

    $('.travel-payment-item').on('change', function() {
        $(this).closest('div').find('.travel-payment-item-validation').addClass('hide');
    });

    $('.travel-payment-nominal').on('change', function() {
        $(this).closest('div').find('.travel-payment-nominal-validation').addClass('hide');
    });

    //End of Payment International Travel Validation

    //Payment International Travel Validation
    $("#btn-submit-record, #btn-submit-record-edit").on('click', function() {
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
            var payment_sub_category_value = $(this).find('.record-payment-sub-category').select2('val');
            if (payment_sub_category_value == null) {
                invalid = true;
                $(this).closest('div').find(".record-payment-sub-category-validation").removeClass('hide');
            }else if (payment_sub_category_value != '') {
                $(this).closest('div').find(".record-payment-sub-category-validation").addClass('hide');
            } else {
                $(this).closest('div').find(".record-payment-sub-category-validation").removeClass('hide');
                invalid = true;
            }

            var payment_item_list = $(this).find('.record-payment-item').select2('val');
            if (payment_item_list != '') {
                $(this).closest('div').find(".record-payment-item-validation").addClass('hide');
            } else {
                $(this).closest('div').find(".record-payment-item-validation").removeClass('hide');
                invalid = true;
            }

            // var payment_item_nominal = $(this).find('.record-payment-nominal').val();
            // if (payment_item_nominal == '' || payment_item_nominal == 0) {
            //     if(status == 3){
            //         $(this).closest('div').find(".record-payment-nominal-validation").addClass('hide');
            //     }else{
            //         $(this).closest('div').find(".record-payment-nominal-validation").removeClass('hide');
            //         invalid = true;
            //     }
            // } else {
            //     $(this).closest('div').find(".record-payment-nominal-validation").addClass('hide');
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
    });

    //End of Payment International Travel Validation


    $(document).on('change', '.date-periode', function(){
        var $block = $(this).closest('.payment-schedule-list');
        recalc_period_end($block);
        auto_fill_schedule_dates($block);
    });

    $("#mdl_add_clea").on('show.bs.modal', function(event) {
        let modal = $('#mdl_add_clea');
        // pastikan tidak ada field yang masih disabled (mis. sisa state bulk edit)
        modal.find('.form-control').prop('disabled', false);
        <?php if (has_permission('payment_record', 'upload_proof_of_expense')) { ?>
            modal.find('.additional-proof-of-expense').html('');
            modal.find('.btn-add-proof-expense').trigger('click');
        <?php } else { ?>
            modal.find('.additional-proof-of-expense').html('<div class="col-md-9"><a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> You do not have permission to upload proof of expense</label></a></div>');
        <?php } ?>
    });

    $('#mdl_edit_clea').on('show.bs.modal', function(event) {
        $('#add_sub_cat_tab').val('Critical Language Enhancement Award');
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            var button = $(event.relatedTarget);
            var cleaId = button.data('record_id');
            $("#delete_detail_payment_clea").val('');
            
            if (typeof currentPaymentClea !== 'undefined') {
                var data = currentPaymentClea[cleaId];
                var baseUrl = window.location.origin;
                $('#clea_payment_id').val(data.id);
                $('#clea_payment_date').datepicker("setDate", new Date(data.payment_date));
                if (data.release_date != null) {
                    $('#edit_clea_release_date').datepicker("setDate", new Date(data.release_date));
                } else {
                    $('#edit_clea_release_date').val('');
                }
                $('#clea_description').val(data.description);
                $('#clea_release_type').val(data.release_type);
                $('#clea_admin_note').val(data.admin_note);
                $('#clea_finance_note').val(data.finance_note);
                $('#clea_status').val(data.status);
                $('#clea_hide-total-payment-clea').val(data.total_nominal);

                $("#edit_clea_bank_info").val(data.bank_info_id);

                let selected = data.user_grantee_grant_memo_id;
                let option = '<option>Select Memo Budget</option>';
                let is_selected = false;
                for(let i = 0; i<MEMO_BUDGET.length; i++) {
                    // Don't disable the currently selected memo (disabled options don't POST)
                    var disabledMemo = (MEMO_BUDGET[i].is_active == 'Yes' || MEMO_BUDGET[i].id == selected) ? '' : 'disabled';
                    if (selected == MEMO_BUDGET[i].id) {
                        is_selected = true;
                    }
                    option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" '+ (MEMO_BUDGET[i].id == selected ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + (MEMO_BUDGET[i].is_active == 'Yes' ? '' : ' (Inactive)') + '</option>';
                }

                $('select[name="edit_clea[user_grantee_grant_memo_id]"]').prop('disabled', false);
                $('select[name="edit_clea[user_grantee_grant_memo_id]"]').html(option);
                
                if (is_selected) {
                    $(".memo-budget-payment-clea-edit").removeClass('hide');
                }
                
                if (data.notify_finance == 1) {
                    $('#clea_edit_notify_finance').attr('checked', 'checked');
                }
                
                if (data.notify_admin == 1) {
                    $('#clea_edit_notify_admin').attr('checked', 'checked');
                }

                if (data.notify_grantee == 1) {
                    $('#clea_edit_notify_grantee').attr('checked', 'checked');
                }

                if (data.proof != null) {
                    $("#preview-edit-uploaded-transfer-clea").removeClass('hide');
                    $("#preview-edit-not-uploaded-transfer-clea").addClass('hide');
                    $('#preview-edit-uploaded-transfer-clea').find('a').attr("href", SITE_URL + data.proof)
                } else {
                    $("#preview-edit-uploaded-transfer-clea").addClass('hide');
                    $("#preview-edit-not-uploaded-transfer-clea").removeClass('hide');
                }

                if (data.proof_expense != null) {
                    $("#preview-edit-uploaded-expense-clea").removeClass('hide');
                    $("#preview-edit-not-uploaded-expense-clea").addClass('hide');
                    $('#preview-edit-uploaded-expense-clea').find('a').attr("href", SITE_URL + data.proof_expense)
                } else {
                    $("#preview-edit-uploaded-expense-clea").addClass('hide');
                    $("#preview-edit-not-uploaded-expense-clea").removeClass('hide');
                }

                if (data.proof_of_conversion != null) {
                    $("#preview-edit-uploaded-conversion-clea").removeClass('hide');
                    $("#preview-edit-not-uploaded-conversion-clea").addClass('hide');
                    $('#preview-edit-uploaded-conversion-clea').find('a').attr("href", SITE_URL + data.proof_of_conversion);
                    $('.expense-file').removeClass('hide');
                } else {
                    $("#preview-edit-uploaded-conversion-clea").addClass('hide');
                    $("#preview-edit-not-uploaded-conversion-clea").removeClass('hide');
                    $('.expense-file').addClass('hide');
                }

                $('#wrap-request-clea-edit0').empty();
                for (var i = 0; i < data.items.length; i++) {
                    
                    $('#request-item-clea-edit' + i).remove();
                    let value = data.items[i].memo_budget_id;
                    var html = append_edit_clea(i, cleaId, value);

                    $('#wrap-request-clea-edit0').append(html);
                    setoption('select_payment_item_edit_clea' + i, false, data.items[i]);
                }
                
                setoptionSubCategoryClea('select_sub_category_edit_clea', false, true, 'Critical Language Enhancement Award');
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });

                if (data.deadline_date != null) {
                    $('#edit_clea_deadline_date').datepicker("setDate", new Date(data.deadline_date));
                } else {
                    $('#edit_clea_deadline_date').val('');
                }
                
                $("#edit_clea_priority").val(data.priority);

                $.each(data.items, function(key, value) {
                    $('#select_sub_category_edit_clea' + key).val(value.payment_sub_category_id).trigger('change');
                    $("#select_payment_memo_budget_item_edit-" + key).val(value.memo_budget_id).change();
                    // $('#select_payment_item_edit'+key).val(value.payment_item);
                    $('#nominal_idr_edit' + key).val(value.nominal_idr);
                    $('#nominal_edit' + key).val(value.nominal);
                    $('#id' + key).val(value.id);
                    $('#btn_delete' + key).attr('data-id', value.id);
                });

                do_format_input_currency();

                let proof_of_expense_section = $('#mdl_edit_clea').find('.additional-proof-of-expense');
                    proof_of_expense_section.html('');
                let proof_of_expenses = currentPaymentProofOfExpenses.filter(item => item.relation_id == cleaId);
                
                append_proof_of_expense_element(proof_of_expenses, proof_of_expense_section, 'edit_clea[remove_expense_attachment_ids]');
            }
        };
    });

    $('#mdl_view_clea').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            var button = $(event.relatedTarget);
            var cleaId = button.data('record_id');
            $("#delete_detail_payment_clea").val('');

            if (typeof currentPaymentClea !== 'undefined') {
                var data = currentPaymentClea[cleaId];
                var baseUrl = window.location.origin;
                
                $('#payment_id_clea_view').val(data.id);
                $('#payment_date_clea_view').datepicker("setDate", new Date(data.payment_date)).removeClass('datepicker');;
                $('#release_date_clea_view').datepicker("setDate", new Date(data.release_date)).removeClass('datepicker');;
                $('#description_clea_view').val(data.description);
                $('#release_type_clea_view').val(data.release_type);
                $('#admin_note_clea_view').val(data.admin_note);
                $('#finance_note_clea_view').val(data.finance_note);
                $('#clea_status_clea_view').val(data.status);
                
                let selected = data.user_grantee_grant_memo_id;
                let option = '<option>-- Select Item --</option>';

                let is_selected = false; 
                for(let i = 0; i<MEMO_BUDGET.length; i++) {
                    // if (MEMO_BUDGET[i].is_active == 'No' && MEMO_BUDGET[i].id != selected) {
                    //     continue;
                    // } 
                    
                    if (selected == MEMO_BUDGET[i].id) {
                        is_selected = true;
                    }

                    var disabledMemo = MEMO_BUDGET[i].is_active == 'Yes' ? '' : 'disabled';
                    option += '<option '+ disabledMemo +' value="' + MEMO_BUDGET[i].id + '" '+ (MEMO_BUDGET[i].id == selected ? 'selected' : '') +'>' + MEMO_BUDGET[i].value + '</option>';
                }

                if (is_selected) {
                    $(".memo-budget-payment-clea-view").removeClass('hide');
                }
            
                $('select[name="edit_clea[user_grantee_grant_memo_id]"]').prop('disabled', true);
                $('select[name="edit_clea[user_grantee_grant_memo_id]"]').html(option);

                if (data.notify_admin == 1) {
                    $('#clea_view_notify_admin').attr('checked', 'checked').prop('disabled', true);
                }

                if (data.notify_finance == 1) {
                    $('#clea_view_notify_finance').attr('checked', 'checked').prop('disabled', true);
                }
                
                if (data.notify_grantee == 1) {
                    $('#clea_view_notify_grantee').attr('checked', 'checked').prop('disabled', true);
                }

                $('#hide-total-payment-clea_clea_view').val(data.total_nominal);

                if (data.proof != null) {
                    $("#preview-view-uploaded-transfer-clea").removeClass('hide');
                    $("#preview-view-not-uploaded-transfer-clea").addClass('hide');
                    $('#preview-view-uploaded-transfer-clea').find('a').attr("href", SITE_URL + data.proof)
                } else {
                    $("#preview-view-uploaded-transfer-clea").addClass('hide');
                    $("#preview-view-not-uploaded-transfer-clea").removeClass('hide');
                }

                if (data.proof_expense != null) {
                    $("#preview-view-uploaded-expense-clea").removeClass('hide');
                    $("#preview-view-not-uploaded-expense-clea").addClass('hide');
                    $('#preview-view-uploaded-expense-clea').find('a').attr("href", SITE_URL + data.proof_expense)
                } else {
                    $("#preview-view-uploaded-expense-clea").addClass('hide');
                    $("#preview-view-not-uploaded-expense-clea").removeClass('hide');
                }

                if (data.proof_of_conversion != null) {
                    $("#preview-view-uploaded-conversion-clea").removeClass('hide');
                    $("#preview-view-not-uploaded-conversion-clea").addClass('hide');
                    $('#preview-view-uploaded-conversion-clea').find('a').attr("href", SITE_URL + data.proof_of_conversion)
                } else {
                    $("#preview-view-uploaded-conversion-clea").addClass('hide');
                    $("#preview-view-not-uploaded-conversion-clea").removeClass('hide');
                }
                
                $("#view_clea_bank_info").val(data.bank_info_id);
                
                for (var i = 0; i < data.items.length; i++) {
                    $('#request-item-clea-view-' + i).remove();
                    let value = data.items[i].memo_budget_id;
                    var html = append_view_clea(i, value);
                    $('#wrap-request-clea-view0').append(html);
                    setoption('select_payment_item_view_clea' + i, false, data.items[i]);
                }

                setoptionSubCategoryClea('select_sub_category_view_clea', false);
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });

                if (data.deadline_date != null) {
                    $('#view_clea_deadline_date').datepicker("setDate", new Date(data.deadline_date));
                } else {
                    $('#view_clea_deadline_date').val('');
                }
                
                $("#view_clea_priority").val(data.priority);

                $.each(data.items, function(key, value) {
                    $('#select_sub_category_view_clea' + key).val(value.payment_sub_category_id).trigger('change');
                    $('#select_payment_item_view_clea' + key).val(value.payment_item).trigger('change');
                    $('#nominal_idr_view_clea' + key).val(value.nominal_idr);
                    $('#nominal_view_clea' + key).val(value.nominal);
                    $('#id_clea_view' + key).val(value.id);
                    $('#btn_delete_clea_view' + key).attr('data-id', value.id);
                });

                do_format_input_currency();

                let proof_of_expense_section = $('#mdl_view_clea').find('.additional-proof-of-expense');
                    proof_of_expense_section.html('');
                let proof_of_expenses = currentPaymentProofOfExpenses.filter(item => item.relation_id == cleaId);
                
                append_proof_of_expense_element(proof_of_expenses, proof_of_expense_section, undefined, true);
            }
        };
    });

    $("#btn-submit-clea, #btn-submit-clea-edit").on('click', function() {
       
        $(this).addClass("hide");

        $(".btn-submit-clea-disabled").each(function(){
            $(this).removeClass('hide');
        });
        
        var action = $(this).data('action');

        var payment_date = $(".payment-date-clea-" + action).val();
       
        var invalid = false;
        if (payment_date == '') {
            $(".payment-date-clea-validation").removeClass('hide');
            invalid = true;
        }
        
        var payment_item_create = $('#wrap-request-clea0');
        var paymnet_item_edit = $("#wrap-request-clea-edit0");
        
        var payment_item = payment_item_create;
        if (action != 'create') {
            var payment_item = paymnet_item_edit;
            var status = $("#clea_status").val();
        }else{
            var status = $("#clea_status_add").val();
        }
        
        var payment_sub_category = payment_item.find('.payment-item-section');
  
        payment_sub_category.each(function() {
            var payment_sub_category_value = $(this).find('.clea-payment-sub-category').select2('val');
            if (payment_sub_category_value == null) {
                invalid = true;
                $(this).closest('div').find(".clea-payment-sub-category-validation").removeClass('hide');
            }else if (payment_sub_category_value != '') {
                $(this).closest('div').find(".clea-payment-sub-category-validation").addClass('hide');
            } else {
                $(this).closest('div').find(".clea-payment-sub-category-validation").removeClass('hide');
                invalid = true;
            }

            var payment_item_list = $(this).find('.clea-payment-item').select2('val');
            if (payment_item_list != '') {
                $(this).closest('div').find(".clea-payment-item-validation").addClass('hide');
            } else {
                $(this).closest('div').find(".clea-payment-item-validation").removeClass('hide');
                invalid = true;
            }

            // var payment_item_nominal = $(this).find('.clea-payment-nominal').val();
            // if (payment_item_nominal == '' || payment_item_nominal == 0) {
            //     if(status == 3){
            //         $(this).closest('div').find(".clea-payment-nominal-validation").addClass('hide');
            //     }else{
            //         $(this).closest('div').find(".clea-payment-nominal-validation").removeClass('hide');
            //         invalid = true;
            //     }
            // } else {
            //     $(this).closest('div').find(".clea-payment-nominal-validation").addClass('hide');
            // }
        });
        
        if (invalid == true) {
            $(".btn-submit-clea-disabled").each(function(){
                $(this).addClass('hide');
            });

            $(this).removeClass("hide");

            return false;
        }

    });

    function select_payment_item_clea(i) {
        var sub_category = 'select_sub_category_clea_' + i;
        var payment_item = 'select_payment_item_clea_' + i;
        $('#' + payment_item).html('');
        $('#' + payment_item).append('<option value="">-- Select Item --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/get_payment_item_by_sub_category') ?>/' + $('#' + sub_category).val(),
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('#' + payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                });
                $('#' + payment_item).append('<option value="__add_new__" data-type="payment_item" data-category="payment_category_support" data-subcategory="select_sub_category_clea_'+i+'"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
            }
        });
        $("#" + sub_category).closest('div').find('.clea-payment-sub-category-validation').addClass('hide');
    }

    function add_item_clea(i) {
        var name_class = '.request-item-clea';
        var warp_request = '#wrap-request-clea' + i;
        var idx = $(name_class).length;

        var fiscalyear = $('#fiscal_year').val();
        var grant_id = $('#grant_id').val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_item_clea') ?>?idx=' + idx + '&i=' + i + '&grant_id=' + grant_id + '&fiscal_year=' + fiscalyear,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $(warp_request).append(html);
                $('.select2').select2({
                    theme: 'bootstrap',
                    templateResult: function (data) {
                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+ data.text+'</span>');
                        }
                        return data.text;
                    }
                });
                updatePaymentItemsSubtotal($(warp_request).closest('.payment-items-table'));
            }
        });
    }

    function edit_item_clea(i) {
        var name_class = '.request-item-clea-edit';
        var warp_request = '#wrap-request-clea-edit' + i;
        var idx = $(name_class).length;
        var fiscalyear = $('#fiscal_year').val();
        var grant_id = $('#grant_id').val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_edit_item_clea') ?>?idx=' + idx + '&i=' + i + '&grant_id=' + grant_id + '&fiscal_year=' + fiscalyear,
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

    function select_edit_payment_item_clea(i, recordId) {
        var sub_category = 'select_sub_category_edit_clea' + i;
        var payment_item = 'select_payment_item_edit_clea' + i;
        $('#' + payment_item).empty();
        $('#' + payment_item).html('');
        $('#' + payment_item).append('<option value="">-- Select Item --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/get_payment_item_by_sub_category') ?>/' + $('#' + sub_category).val(),
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    var data = currentPaymentClea[recordId];
                    if ($('#' + payment_item + ' option[value="' + val.id + '"]').length === 0) {
                        $('#' + payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                    }
                    if (data) {
                        $('#' + payment_item).val(data.items[i].payment_item).trigger('change');
                    }
                });
                $('#' + payment_item).append('<option value="__add_new__" data-type="payment_item" data-category="payment_category_support" data-subcategory="select_sub_category_edit_clea'+i+'"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
            }
        });
        $("#" + sub_category).closest('div').find('.clea-payment-sub-category-validation').addClass('hide'); 
    }

    function remove_error(error_element) {
        $('.' + error_element).addClass('hide');
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

    function add_more_attachment(element) {
        let attachment_button = $(element);
        let attachment_section = attachment_button.data('type');

        let count = $('.additional-' + attachment_section + ' .payment-attachment').length; // Hitung jumlah elemen
        let fileInputId = 'proof-of-expense-' + count;
        let previewId = 'preview-add-not-uploaded-transfer-grant-' + count;

        let html = `
            <div class="payment-attachment">
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-danger btn-xs pull-right btn-action-remove-unuploaded" type="button" onclick="remove_attachment(this);">
                            <i class="fa fa-times"></i>
                        </button>
                        <input type="file" data-modal="mdl_add_record" id="${fileInputId}" name="${attachment_button.data('input_name')}">
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
            </div>`;
            
        $('.additional-' + attachment_section).append(html);
    }

    function remove_attachment(element, name = undefined, id = undefined)
    {
        if (confirm("Are you sure you want to remove this file?")) {
            let row = $(element);
                row = row.closest('.payment-attachment');
            if (id == undefined) {
                row.remove();
            } else {
                row.html('').addClass('hide');
                let html_id = '<input type="hidden" ' + (name == 'edit_clea[remove_expense_attachment_ids]' ? 'form="form"' : '') + ' name="' + name + '[]" value="' + id + '">';
                row.append(html_id);
            }
        }
    }

    function append_proof_of_expense_element(data, container, input_delete_name = undefined, is_readonly = false)
    {
        <?php 
            $hide_upload_expense = 'hide';
            if (has_permission('payment_record', 'upload_proof_of_expense')) {
                $hide_upload_expense = '';
            }
        ?>

        let has_permission = '<?php echo $hide_upload_expense; ?>';
        if (is_readonly) {
            has_permission = 'hide';
        }
        
        $.each(data, function (index, item) {
            let html = `
            <div class="payment-attachment">
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-danger btn-action-remove-uploaded btn-xs pull-right ${has_permission}" type="button" onclick="remove_attachment(this, '${input_delete_name}', ${item.id}); return false;" style="margin-top:-10px;">
                            <i class="fa fa-times"></i>
                        </button>
                        <div id="preview-edit-uploaded-expense-grant-${index}">
                            <a href="${SITE_URL + item.filepath}" target="_blank" class="lightbox">
                                <label class="label label-primary" style="cursor:pointer;">View Proof</label>
                            </a>
                        </div>
                    </div>
                </div>
            </div>`;

            container.append(html);
            $('.lightbox').topbox();
        });

        if (data.length <= 0) {
            container.html('<div class="payment-attachment"><div class="col-md-12"><div class="form-group"><a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a></div></div></div>');
        }
    }

    function parse_period_start(val) {
        try {
            return $.datepicker.parseDate('dd M yy', $.trim(val || ''));
        } catch (e) {
            return null;
        }
    }

    function calc_coverage_end(startDate, months) {
        var y = startDate.getFullYear();
        var m = startDate.getMonth();
        var d = startDate.getDate();
        var targetIndex = m + months;
        var targetYear = y + Math.floor(targetIndex / 12);
        var targetMonth = ((targetIndex % 12) + 12) % 12;
        var lastDay = new Date(targetYear, targetMonth + 1, 0).getDate();
        var end = new Date(targetYear, targetMonth, Math.min(d, lastDay));
        end.setDate(end.getDate() - 1);
        return end;
    }

    function recalc_period_end(block) {
        if (!block || !block.length) return;
        var startVal = block.find('input.date-periode').val();
        var cov = parseInt(block.find('select.coverage-select').val(), 10);
        if (!startVal || isNaN(cov) || cov < 1 || cov > 12) return;
        var start = parse_period_start(startVal);
        if (!start) return;
        var end = calc_coverage_end(start, cov);
        block.find('input.to').val($.datepicker.formatDate('dd M yy', end));
        if (typeof remove_error === 'function') {
            remove_error('validation-error-to');
        }
    }

    $(document).on('change', '#wrap-payment input.date-periode, #wrap-payment select.coverage-select', function() {
        recalc_period_end($(this).closest('.payment-schedule-list'));
    });

    if ($.datepicker && !$.datepicker._coveragePatched) {
        $.datepicker._coveragePatched = true;
        var _origSelectDate = $.datepicker._selectDate;
        $.datepicker._selectDate = function(id, dateStr) {
            _origSelectDate.apply(this, arguments);
            var $input = $(id);
            if ($input.hasClass('date-periode')) {
                var $block = $input.closest('.payment-schedule-list');
                recalc_period_end($block);
                auto_fill_schedule_dates($block);
            }
        };
    }

    // Auto-set tanggal turunan dari Pay Period Starts (selalu timpa saat Start berubah):
    // Reminder Date & Notification Date = Start - PAYMENT_REMINDER_DAYS_OFFSET (14 hari),
    // To be released on = Start - PAYMENT_DEADLINE_DAYS_OFFSET (5 hari).
    function auto_fill_schedule_dates(block) {
        if (!block || !block.length) return;
        var start = parse_period_start(block.find('input.date-periode').val());
        if (!start) return;
        var reminder = new Date(start.getTime());
        reminder.setDate(reminder.getDate() - <?php echo PAYMENT_REMINDER_DAYS_OFFSET; ?>);
        var deadline = new Date(start.getTime());
        deadline.setDate(deadline.getDate() - <?php echo PAYMENT_DEADLINE_DAYS_OFFSET; ?>);
        block.find('input.reminder-date').val($.datepicker.formatDate('dd M yy', reminder));
        block.find('input.tobe-released-on').val($.datepicker.formatDate('dd M yy', deadline));
        block.find('input.notification-date').val($.datepicker.formatDate('dd M yy', reminder));
        if (typeof remove_error === 'function') {
            remove_error('validation-error-reminder-date');
        }
    }

    function copy_payment(element, parent_class) {
        let el = $(element);
        let default_text = el.html();
        el.html('<i class="fa fa-circle-o-notch fa-spin"></i> Copying...');
        el.addClass('text-warning');
        let current_section = el.closest('.' + parent_class);

        if (current_section.length > 0) {
            let payment_period_start_date = current_section.find('input.date-periode').val();
            let payment_period_end_date = current_section.find('input.to').val();
            let coverage_month = current_section.find('select.coverage-select').val();
            let reminder_date = current_section.find('input.reminder-date').val();
            let tobe_released_note = current_section.find('textarea.tobe-release-note').val();
            let memo_budget = current_section.find('select.memo-budget').val();
            let bank = current_section.find('select.bank').val();
            let tobe_released_on = current_section.find('input.tobe-released-on').val();
            let priority = current_section.find('select.priority').val();
            let payment_status = current_section.find('select.payment-status').val();
            let notify_grantee = current_section.find('input.notify-grantee').prop('checked');
            let release_date = current_section.find('input.release-date').val();

            let payment_item_section = current_section.find('.payment-item-section');
            let payment_items = [];
            payment_item_section.each(function () {
                let item = {
                    category: $(this).find('select.payment-sub-category').val(),
                    sub_category: $(this).find('select.payment-item-list').val(),
                    nominal: $(this).find('input.currency-idr').val(),
                    nominal_usd: $(this).find('input.currency-usd').val()
                };
                payment_items.push(item);
            });

            var scheduleCount = $('.payment-schedule-list').length;
            $('.add-grant-disburstment').click();
            wait_for_new_schedule(scheduleCount, 0);
        }

        function wait_for_new_schedule(scheduleCount, attempts) {
            var $schedules = $('.payment-schedule-list');
            if ($schedules.length > scheduleCount) {
                fill_copied_schedule($schedules.eq(scheduleCount));
                return;
            }
            if (attempts >= 50) {
                if (typeof show_toast === 'function') {
                    show_toast('Failed to add new disbursement for copy', 'error');
                }
                el.html(default_text);
                el.removeClass('text-warning');
                return;
            }
            setTimeout(function() { wait_for_new_schedule(scheduleCount, attempts + 1); }, 100);
        }

        async function fill_copied_schedule(last_payment_schedule) {
            try {
                last_payment_schedule.addClass('hide');
                last_payment_schedule.find('input.date-periode').val(payment_period_start_date);
                last_payment_schedule.find('select.coverage-select').val(coverage_month);
                last_payment_schedule.find('input.to').val(payment_period_end_date);
                last_payment_schedule.find('input.reminder-date').val(reminder_date);
                last_payment_schedule.find('textarea.tobe-release-note').val(tobe_released_note);
                last_payment_schedule.find('select.memo-budget').val(memo_budget);
                last_payment_schedule.find('select.bank').val(bank);
                last_payment_schedule.find('input.tobe-released-on').val(tobe_released_on);
                last_payment_schedule.find('select.priority').val(priority);
                last_payment_schedule.find('select.payment-status').val(payment_status);
                last_payment_schedule.find('input.notify-grantee').prop('checked', notify_grantee);
                last_payment_schedule.find('input.release-date').val(release_date);

                let new_payment_item_section = last_payment_schedule.find('.payment-item-section');
                let added_items = payment_items.length - 1;

                for (let n = 1; n <= added_items; n++) {
                    await new Promise(function(resolve) {
                        var settled = false;
                        var timer = setTimeout(function() { if (!settled) { settled = true; resolve(); } }, 8000);
                        last_payment_schedule.find('.btn-add-item').click();
                        $(document).one('ajaxComplete', function() {
                            if (!settled) { settled = true; clearTimeout(timer); resolve(); }
                        });
                    });
                }

                setTimeout(() => {
                    new_payment_item_section = last_payment_schedule.find('.payment-item-section');

                    new_payment_item_section.each(function (index) {
                        if (payment_items[index]) {
                            let current_element = $(this);
                            current_element.find('select.payment-sub-category').val(payment_items[index].category).trigger('change');

                            setTimeout(function() {
                                current_element.find('input.currency-idr').val(payment_items[index].nominal);
                                current_element.find('input.currency-usd').val(payment_items[index].nominal_usd);
                                current_element.find('select.payment-item-list').val(payment_items[index].sub_category).trigger('change');
                                updatePaymentItemsSubtotal(current_element.closest('.payment-items-table'));
                            }, 500);
                        }
                    });

                    el.html('<i class="fa fa-check-circle text-success"></i> Payment Copied');
                    setTimeout(() => {
                        el.html(default_text);
                        el.removeClass('text-warning');
                    }, 2000);
                }, 1000);
            } catch (err) {
                if (typeof show_toast === 'function') {
                    show_toast('Failed to copy payment', 'error');
                }
                el.html(default_text);
            } finally {
                last_payment_schedule.removeClass('hide');
                last_payment_schedule.find('.panel-collapse').collapse('show');
                el.removeClass('text-warning');
            }
        }
    }

    function toggleAutoNotification(element) {
        let checkbox = $(element);
        let paymentIndex = checkbox.data('index');
        let paymentId = checkbox.data('id');
        let isChecked = checkbox.prop('checked');

        let date_period_val = $('.date-periode[data-payment_index="'+paymentIndex+'"]').val();

        let formatted_reminder_date = '';
        let start_date = parse_period_start(date_period_val);
        if (start_date) {
            start_date.setDate(start_date.getDate() - <?php echo PAYMENT_REMINDER_DAYS_OFFSET; ?>);
            formatted_reminder_date = $.datepicker.formatDate('dd M yy', start_date);
        }

        if(isChecked) {
            $('.notification_section_' + paymentIndex).removeClass('hide');
            $('.reminder_section_' + paymentIndex).addClass('hide');
            $('.notification-date-' + paymentIndex).val(formatted_reminder_date);
        } else {
            $('.notification_section_' + paymentIndex).addClass('hide');
            $('.reminder_section_' + paymentIndex).removeClass('hide');
            $('.reminder-date-' + paymentIndex).val(formatted_reminder_date);
        }

        if(paymentId){
            $.ajax({
                url: '<?php echo site_url('admin/request_payment/toggle_auto_notification') ?>',
                method: 'POST',
                data: {
                    payment_id: paymentId,
                    auto_notification: isChecked ? 1 : 0
                },
                success: function(response) {
                    showSwal('success', 'Successfully updated data', false, true, 1500)
                },
                error: function() {
                    showSwal('error', 'Failed to update data', false, true, 1500)
                    checkbox.prop('checked', !isChecked); // Revert checkbox state on error
                }
            });
        }

    }


    // =========== PAYMENT DISBURSEMENT ACCORDION ================
    $(document).on('click', '.payment-schedule-list > .panel-heading.payment-panel-heading', function(e) {
        if ($(e.target).closest('.btn-proof-preview').length) return;
        $(this).closest('.payment-schedule-list').find('.panel-collapse').collapse('toggle');
    });

    $(document).on('shown.bs.collapse hidden.bs.collapse', '.payment-schedule-list .panel-collapse', function(e) {
        $(this).closest('.payment-schedule-list').find('.panel-heading').toggleClass('open', e.type === 'shown');
    });

    // =========== PAYMENT ITEM ================
    function show_toast(msg, type = 'success') {
        if (window.Swal && Swal.fire) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                icon: type === 'error' ? 'error' : 'success',
                title: msg,
                showClass: { popup: '' },
                hideClass: { popup: '' }
            });
            return;
        }
        console.log((type || 'info') + ': ' + msg);
    }

    $(document).on('select2:select', '.select2', function (e) {
        let $select = $(this);
        let data = e.params.data;
        let type = e.params.data.title ?? 'item';
        const parentModal = $(this).closest('.modal').attr('id');

        

        if (data.id === '__add_new__') {

            let $option = $(data.element);

            let category = $option.data('category');
            let subcategory = $option.data('subcategory');

            // simpan reference select yg aktif
            
            $select.val(null).trigger('change');
            
            if(type == 'sub_category') {
                // $('#add_sub_cat_tab').val(category);
                $('#modalAddSubPayment').data('select', $select);
                $('#modalAddSubPayment').data('subcategory', subcategory);
                $('#modalAddSubPayment').data('type', type);

                $('#modalAddSubPayment').data('parent-modal', parentModal);

                if(parentModal) {
                    $('#' + parentModal).css('z-index', '1040');
                }
                $('#add_sub_category_name').val('');
                $('#modalAddSubPayment').modal('show');
            } else {
                // $('#add_sub_cat_tab').val(category);
                $('#modalAddPaymentItem').data('select', $select);
                $('#modalAddPaymentItem').data('subcategory', subcategory);
                $('#modalAddPaymentItem').data('type', type);

                $('#modalAddPaymentItem').data('parent-modal', parentModal);

                if(parentModal) {
                    $('#' + parentModal).css('z-index', '1040');
                }


                $('#add_payment_item_name').val('');
                $('#modalAddPaymentItem').modal('show');
            }

        }
    });

    $('#btn_save_sub_category').on('click', function () {
        let name = $('#add_sub_category_name').val().trim();
        let $select = $('#modalAddSubPayment').data('select');

        // let $category = 'Grant Cost';
        let $category = $('#add_sub_cat_tab').val();

        if (!name) {
            alert('Name cannot be empty');
            $('#add_category_name').focus();
            return;
        }

        let $btn = $(this)
        $btn.prop('disabled', true);

        $.ajax({
            url: '<?= base_url() ?>admin/grantee/add_sub_category', // endpoint lo
            type: 'POST',
            dataType: 'json',
            data: { 
                name: name,
                category: $category
            },
            success: function (res) {
                if (res && res.success) {
                    let $subTargets;
                    if ($select.hasClass('travel-payment-sub-category')) {
                        $subTargets = $('select.travel-payment-sub-category');
                    } else if ($select.hasClass('clea-payment-sub-category')) {
                        $subTargets = $('select.clea-payment-sub-category');
                    } else {
                        $subTargets = $('select.record-payment-sub-category');
                    }
                    $subTargets.not($select).each(function() {
                        let $t = $(this);
                        if ($t.find('option[value="' + res.data.id + '"]').length === 0) {
                            let opt = new Option(res.data.name, res.data.id, false, false);
                            let addOpt = $t.find('option[value="__add_new__"]');
                            if (addOpt.length) {
                                $(opt).insertBefore(addOpt);
                            } else {
                                $t.append(opt);
                            }
                        }
                    });

                    let newOption = new Option(res.data.name, res.data.id, true, true);
    
                    let addOption = $select.find('option[value="__add_new__"]');
                    if (addOption.length) {
                        $(newOption).insertBefore(addOption);
                    } else {
                        $select.append(newOption);
                    }
    
                    $select.trigger('change');
    
                    $('#modalAddSubPayment').modal('hide');
                    show_toast(res.message || 'Successfully added payment item', 'success');
                }else {
                    show_toast(res.message || 'Failed to add payment item', 'error');
                }
            },
            complete: function () {
                $btn.prop('disabled', false);
            },
            error: function () {
                show_toast('Error adding payment item', 'error');
            }
        });
    });



    $('#btn_save_payment_item').on('click', function () {
        let name = $('#add_payment_item_name').val().trim();
        let subcategory = $('#modalAddPaymentItem').data('subcategory');
        let $select = $('#modalAddPaymentItem').data('select');

        // let $category = 'Grant Cost';
        let $category = $('#add_sub_cat_tab').val();
        let $subcategory = $('#' + subcategory).val();

        if (!name) {
            alert('Name cannot be empty');
            $('#add_payment_item_name').focus();
            return;
        }

        let $btn = $(this)
        $btn.prop('disabled', true);

        $.ajax({
            url: '<?= base_url() ?>admin/grantee/add_payment_item', // endpoint lo
            type: 'POST',
            dataType: 'json',
            data: { 
                name: name,
                category: $category,
                subcategory: $subcategory
            },
            success: function (res) {
                if (res && res.success) {
                    let $itemTargets, subSel;
                    if ($select.hasClass('travel-payment-item')) {
                        $itemTargets = $('select.travel-payment-item');
                        subSel = 'select.travel-payment-sub-category';
                    } else if ($select.hasClass('clea-payment-item')) {
                        $itemTargets = $('select.clea-payment-item');
                        subSel = 'select.clea-payment-sub-category';
                    } else {
                        $itemTargets = $('select.record-payment-item');
                        subSel = 'select.record-payment-sub-category';
                    }
                    $itemTargets.not($select).each(function() {
                        let $t = $(this);
                        let $rowSub = $t.closest('.row').find(subSel);
                        if ($rowSub.length && String($rowSub.val()) === String($subcategory)
                            && $t.find('option[value="' + res.data.id + '"]').length === 0) {
                            let opt = new Option(res.data.name, res.data.id, false, false);
                            let addOpt = $t.find('option[value="__add_new__"]');
                            if (addOpt.length) {
                                $(opt).insertBefore(addOpt);
                            } else {
                                $t.append(opt);
                            }
                        }
                    });

                    let newOption = new Option(res.data.name, res.data.id, true, true);
    
                    let addOption = $select.find('option[value="__add_new__"]');
                    if (addOption.length) {
                        $(newOption).insertBefore(addOption);
                    } else {
                        $select.append(newOption);
                    }
    
                    $select.trigger('change');
    
                    $('#modalAddPaymentItem').modal('hide');
                    show_toast(res.message || 'Successfully added payment item', 'success');
                }else {
                    show_toast(res.message || 'Failed to add payment item', 'error');
                }
            },
            complete: function () {
                $btn.prop('disabled', false);
            },
            error: function () {
                show_toast('Error adding payment item', 'error');
            }
        });
    });

    $('#modalAddPaymentItem').on('hidden.bs.modal', function () {
        
        const parentModalId = $(this).data('parent-modal');
        if(parentModalId) {
            $('body').addClass('modal-open');
            $('#' + parentModalId).css('z-index', '1050');
        }
    });

    $('#modalAddSubPayment').on('hidden.bs.modal', function () {
        
        const parentModalId = $(this).data('parent-modal');
        if(parentModalId) {
            $('body').addClass('modal-open');
            $('#' + parentModalId).css('z-index', '1050');
        }
    });

    $('.li-payment').on('click', function() {
        var category = $(this).data('category')
        $('#add_sub_cat_tab').val(category);
    });

    // Samakan kategori inline-add dengan tab aktif — dukung deep-link ?pid=... (tanpa klik tab)
    (function init_add_sub_cat_tab() {
        var pidToCategory = {
            'travel': 'International Travel',
            'support': 'Grant Supporting',
            'clea': 'Critical Language Enhancement Award'
        };
        try {
            var pid = new URLSearchParams(window.location.search).get('pid');
            if (pid && pidToCategory[pid]) {
                $('#add_sub_cat_tab').val(pidToCategory[pid]);
            } else {
                var activeCat = $('.li-payment.active').data('category');
                if (activeCat) {
                    $('#add_sub_cat_tab').val(activeCat);
                }
            }
        } catch (e) { /* abaikan, fallback ke default Grant Cost */ }
    })();

    $(window).on('load', function() {
        try {
            var urlParams = new URLSearchParams(window.location.search);
            var pid = urlParams.get('pid');
            var paymentId = urlParams.get('payment_id');

            if ((pid === 'travel' || pid === 'support') && paymentId) {
                var btn = $('a[data-record_id="' + paymentId + '"][data-mode="view"]').first();
                if (btn.length) {
                    btn.trigger('click');
                    return;
                }

                var btn2 = $('a[data-record_id="' + paymentId + '"][data-target="#mdl_view_travel"]').first();
                if (btn2.length) {
                    btn2.trigger('click');
                    return;
                }

                var fake = $('<a/>', {
                    href: '#',
                    style: 'display:none',
                    'data-toggle': 'modal',
                    'data-target': '#mdl_edit_record',
                    'data-mode': 'view',
                    'data-record_id': paymentId
                });
                $('body').append(fake);
                fake.trigger('click');
                setTimeout(function() { fake.remove(); }, 1500);
            }
        } catch (e) {
            console.error('Auto-open payment modal error', e);
        }
    });


</script>