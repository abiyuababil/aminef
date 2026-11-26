<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>

<script>

    function show_pcode(el_country, el_pcode) {
        var country_code = $('#' + el_country + ' option:selected').attr('data-pcode');
        if (country_code != undefined)
            $('#' + el_pcode).val('+' + country_code);
    }

    function del_item(el, item_class, key) {
        var deleted = $("#delete_detail_payment").val();
        var deleted_temp = $("#delete_temp_"+key).val();
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
            var id = $(el).attr('id');
            var temp_id = $(el).attr('temp_id');

            if(deleted == ''){
                $("#delete_detail_payment").val(id);
            }else{
                var join_id = deleted + ',' + id;
                $("#delete_detail_payment").val(join_id);
            }

            if(deleted_temp == ''){
                $("#delete_temp_"+key).val(temp_id);
            }else{
                var temp_join_id = deleted_temp + ',' + temp_id;
                $("#delete_temp_"+key).val(temp_join_id);
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
        var deleted = $("#delete_detail_payment_record").val();
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('#' + item_class).remove();
            var id = $(el).data('id');
            if(deleted == ''){
                $("#delete_detail_payment_record").val(id);
            }else{
                var join_id = deleted + ',' + id;
                $("#delete_detail_payment_record").val(join_id);
            }
    }

    function del_item_id_travel(el, item_class) {
        var deleted = $("#delete_detail_payment_travel").val();
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('#' + item_class).remove();
            var id = $(el).data('id');
            console.log(id)
            if(deleted == ''){
                $("#delete_detail_payment_travel").val(id);
            }else{
                var join_id = deleted + ',' + id;
                $("#delete_detail_payment_travel").val(join_id);
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
                $('.select2').select2({
            theme: 'bootstrap'
});
            }
        });
    }

    function add_item_record(i) {
        var name_class = '.request-item-record'+i;
        var warp_request = '#wrap-request-record'+i;
        var idx = $(name_class).length;
        console.log(idx)
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_item_record') ?>?idx='+ idx + '&i=' + i,
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

    function add_item_travel(i) {
        var name_class = '.request-item-travel'+i;
        var warp_request = '#wrap-request-travel'+i;
        var idx = $(name_class).length;
        console.log(idx)
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_item_travel') ?>?idx='+ idx + '&i=' + i,
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

    function edit_item_record(i) {
        var name_class = '.request-item-record-edit';
        var warp_request = '#wrap-request-record-edit'+i;
        var idx = $(name_class).length;
        console.log(idx)
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_edit_item_record') ?>?idx='+ idx + '&i=' + i,
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

    function edit_item_travel(i) {
        var name_class = '.request-item-travel-edit';
        var warp_request = '#wrap-request-travel-edit'+i;
        var idx = $(name_class).length;
        console.log(idx)
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_edit_item_travel') ?>?idx='+ idx + '&i=' + i,
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
        var suffix = ordinal_suffix_of((idx+1));
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/add_payment') ?>?idx='+ idx + '&suffix=' + suffix + '&last=' + last,
            dataType: 'JSON',
            success: function(r) {
                console.log(r.last)
                var html = r.html;
                $('#wrap-payment').append(html);
                $('#last_payment').val(r.last);
                $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd M yy",
                yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
                $('input[type="text"], input[type="email"]').attr('autocomplete','new-password');
                $('.select2').select2({
            theme: 'bootstrap'
});
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
            console.log(data)
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

    $("#btn-submit").click(function(){
        $('#hide-btn').prop( "disabled", true );
        $('#hide-btn-edit').prop( "disabled", true );
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/request_payment/validate_payment') ?>',
            dataType: 'JSON',
            data:$("#form").serializeArray(),
            success: function(r) {
                if(r.success == true){
                    $("#mdl_validate").modal(); 
                    $("#validate_message").html(r.message); 
                    event.preventDefault();
                }else{
                    $("#form").submit();
                }
            }
        });
        
    })

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

    $('#mdl_add_record').on('show.bs.modal', function () {
        $.fn.modal.Constructor.prototype.enforceFocus = function () { };
    });

    // write edit support
    $('#mdl_edit_record').on('show.bs.modal', function(event){
      $.fn.modal.Constructor.prototype.enforceFocus = function () { 

        var button = $(event.relatedTarget);
        var recordId = button.data('record_id');
        $("#delete_detail_payment_record").val('');

        if(typeof currentUserReviews !== 'undefined'){
            var data = currentUserReviews[recordId];
            var baseUrl = window.location.origin;
            $('#payment_id').val(data.id);
            $('#payment_date').val(data.payment_date);
            $('#description').val(data.description);
            $('#release_type').val(data.release_type);
            $('#admin_note').val(data.admin_note);
            $('#finance_note').val(data.finance_note);
            $('#record_status').val(data.status);
            $('#hide-total-payment-record').val(data.total_nominal);
            if(data.notify_finance == 1){
                $('#edit_notify_finance').attr('checked', 'checked');
            }
            if(data.notify_admin == 1){
                $('#edit_notify_admin').attr('checked', 'checked');
            }
            if(data.notify_grantee == 1){
                $('#edit_notify_grantee').attr('checked', 'checked');
            }

            if(data.proof != null){
                $('#proof_btn').css("display", "block");
                $('#proof_btn').attr("href", baseUrl +'/aminef-db/'+data.proof)
            }else{
                $('#proof_btn').css("display", "none");
            }

            for (var i = 0; i < data.items.length; i++) {
                $('#request-item-record-edit-'+i).remove();
                var html = append_edit_record(i);
                $('#wrap-request-record-edit0').append(html);
            }
            setoption('select_payment_item_edit', false);
            $('.select2').select2({
            theme: 'bootstrap'
});
            $.each( data.items, function( key, value ) {
                $('#select_payment_item_edit'+key).val(value.payment_item).trigger('change');
                $('#nominal_edit'+key).val(value.nominal);
                $('#id'+key).val(value.id);
                $('#btn_delete'+key).attr('data-id', value.id);
            });
        }
      };
    });

    

    $('#mdl_add_travel').on('show.bs.modal', function () {
        $.fn.modal.Constructor.prototype.enforceFocus = function () { };
    });

    // write edit travel
    $('#mdl_edit_travel').on('show.bs.modal', function(event){
      $.fn.modal.Constructor.prototype.enforceFocus = function () { 

        var button = $(event.relatedTarget);
        var recordId = button.data('record_id');
        $("#delete_detail_payment_travel").val('');

        if(typeof currentPaymentTravel !== 'undefined'){
            var data = currentPaymentTravel[recordId];
            var baseUrl = window.location.origin;
            $('#payment_id_travel').val(data.id);
            $('#payment_date_travel').val(data.payment_date);
            $('#description_travel').val(data.description);
            $('#release_type_travel').val(data.release_type);
            $('#admin_note_travel').val(data.admin_note);
            $('#finance_note_travel').val(data.finance_note);
            $('#record_status_travel').val(data.status);
            $('#hide-total-payment-record_travel').val(data.total_nominal);
            if(data.notify_finance == 1){
                $('#edit_notify_finance_travel').attr('checked', 'checked');
            }
            if(data.notify_admin == 1){
                $('#edit_notify_admin_travel').attr('checked', 'checked');
            }
            if(data.notify_grantee == 1){
                $('#edit_notify_grantee_travel').attr('checked', 'checked');
            }

            if(data.proof != null){
                $('#proof_btn_travel').css("display", "block");
                $('#proof_btn_travel').attr("href", baseUrl +'/aminef-db/'+data.proof)
            }else{
                $('#proof_btn_travel').css("display", "none");
            }

            for (var i = 0; i < data.items.length; i++) {
                $('#request-item-travel-edit-'+i).remove();
                var html = append_edit_travel(i);
                $('#wrap-request-travel-edit0').append(html);
            }
            setoptiontravel('select_payment_item_edit_travel', false);

            $('.select2').select2({
                theme: 'bootstrap'
            });
            
            $.each( data.items, function( key, value ) {
                console.log(data)
                $('#select_payment_item_edit_travel'+key).val(value.payment_item).trigger('change');
                $('#nominal_edit_travel'+key).val(value.nominal);
                $('#id_travel'+key).val(value.id);
                $('#btn_delete_travel'+key).attr('data-id', value.id);
            });
        }
      };
    });

    function setoption(ddlID, isFirstOptionEmpty) {
        var arr = currentPaymentItems;
        setDDLValues(ddlID, isFirstOptionEmpty, arr);
    }

    function setoptiontravel(ddlID, isFirstOptionEmpty) {
        var arr = currentPaymentItemsTravel;
        setDDLValues(ddlID, isFirstOptionEmpty, arr);
    }

    function setDDLValues(ddlID, isFirstOptionEmpty, arr) {
        clearDDL(ddlID);

        if (isFirstOptionEmpty) {
            $('.' + ddlID).append("<option value=''>All</option>");
        }
        console.log(arr)

        for (var i = 0; i < arr.length; i++) {
            $('.' + ddlID).append("<option value='" + arr[i].id + "'>" + arr[i].payment_item + "</option>");
        }
    }

    function clearDDL(ddlID) {
        $("." + ddlID).prop('');
    }

    function append_edit_record(i) {
        var name_class = '.request-item-record-edit'+i;
        var warp_request = '#wrap-request-record-edit'+i;
        var idx = $(name_class).length;
        var html = '';
        
        html = '<div id="request-item-record-edit-'+i+'" class="row request-item-record-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">'
        html += '<div class="col-lg-6">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select id="select_payment_item_edit'+i+'" name="edit_record[items]['+i+'][item]" class="form-control select2 select_payment_item_edit">'
        html += '</select>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-6">'
        html += '<div class="form-group">'
        html += '<label>Nominal </label>'
        html += '<input type="text" id="nominal_edit'+i+'" class="form-control currency-usd" name="edit_record[items]['+i+'][nominal]">'
        html += '<input type="hidden" id="id'+i+'" class="form-control" name="edit_record[items]['+i+'][id]">'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '<a href="javascript:;" onclick="del_item_id(this, \'request-item-record-edit-'+i+'\')" class="btn btn-danger" id=btn_delete'+i+' style="position:absolute;right:15px;"><i class="fa fa-trash fa-fw"></i></a>'
        html += '</div>'

        return html;
        
    }

    function append_edit_travel(i) {
        var name_class = '.request-item-travel-edit'+i;
        var warp_request = '#wrap-request-travel-edit'+i;
        var idx = $(name_class).length;
        var html = '';
        
        html = '<div id="request-item-travel-edit-'+i+'" class="row request-item-travel-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">'
        html += '<div class="col-lg-6">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select id="select_payment_item_edit_travel'+i+'" name="edit_travel[items]['+i+'][item]" class="form-control select2 select_payment_item_edit_travel">'
        html += '</select>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-6">'
        html += '<div class="form-group">'
        html += '<label>Nominal </label>'
        html += '<input type="text" id="nominal_edit_travel'+i+'" class="form-control currency-usd" name="edit_travel[items]['+i+'][nominal]">'
        html += '<input type="hidden" id="id_travel'+i+'" class="form-control" name="edit_travel[items]['+i+'][id]">'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '<a href="javascript:;" onclick="del_item_id_travel(this, \'request-item-travel-edit-'+i+'\')" class="btn btn-danger" id=btn_delete_travel'+i+' style="position:absolute;right:15px;"><i class="fa fa-trash fa-fw"></i></a>'
        html += '</div>'

        return html;
        
    }

    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap'
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
    $('#show_hide_bank').on('click', function(){
        val_ =$(this).html();
        if(val_ == '<i class="fa fa-eye"></i> Show'){
            $(this).attr('value','1').html('<i class="fa fa-eye-slash"></i> Hide');
            $('#tab_bank').show();
        }else{
            $(this).attr('value','0').html('<i class="fa fa-eye"></i> Show')
            $('#tab_bank').hide();
        }
    });
</script>