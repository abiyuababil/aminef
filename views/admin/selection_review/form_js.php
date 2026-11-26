<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2({
            theme: 'bootstrap'
});
		$( ".datepicker" ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat: "dd M yy",
		  yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
		});
        // if($('.datepicker').val() == ''){
        //     $('.datepicker').datepicker('setDate', new Date());
        // }

        var countSelectionReview = <?= count($selection_reviews) ?>;
        if(countSelectionReview > 0){
            for (var i = 0; i < countSelectionReview; i++){
                get_panellist(i);
            }
        }
        // $('.change').prop("disabled", false);
    });
    
    $("#btn-decline").click(function(){
        $("#mdl_info_decline").modal();    
        event.preventDefault();
    });

    $("#btn-present").click(function(){
        $("#mdl_info_present").modal();    
        event.preventDefault();
    });

    function get_panellist(key) {
        var idx = $('#panellis_'+key).val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/selection_review/get_panellist') ?>/'+ idx,
            dataType: 'JSON',
            success: function(r) {
                $('#field_of_study_'+key).val(r.field_of_study_name);
                $('#email_'+key).val(r.email);
                $('#tel_'+key).val(r.telp);
                $('#home_institution_'+key).val(r.home_institution);
                $('#bank_info_'+key).val(r.bank_info);
                $('#beneficiary_name_'+key).val(r.beneficiary_name);
                $('#account_number_'+key).val(r.account_number);
                $('#status_panellist_id_'+key).val(r.status_panellist_name);
                if (r.status_panellist_name == null) {
                    $('#status_panellist_id_'+key).attr('placeholder', '');
                }
            }
        });
    }

    function add_selection_review() {
        var idx = $('.selection-review-item').length;
        $('.add-load').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/selection_review/getPartial') ?>/'+ idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-selection-review').append(html);
                $('.select2').select2({
            theme: 'bootstrap'
});
                $('.add-load').hide();
                $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd M yy",
                yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
            }
        });
    }

    function del_item(el, item_class) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
    }

    function get_university(select, index)
    {
        if(select.value == 'accept'){
            var status_arr = [];
            var field_status = $(".status_plan").length;
            console.log(field_status)
            for(let i = 0; i < field_status; i++) {
                status_arr.push($("#status_plant_"+i+"").val());
            }
            status_arr.splice(index,1);
            if(jQuery.inArray("accept", status_arr) !== -1) {
                alert('There is already an accepted status in other submissions')
                $("#status_plant_"+index+"").val('waiting')
            } 
        }
    }
    
    function select_payment_item_record(i) {
        var sub_category = 'select_sub_category_record_'+i;
        var payment_item = 'select_payment_item_record_'+i;
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
        
        if(sub_category == ''){
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
                'category_type': 'Third Party',
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

    function del_item_selection_review(el, item_class, id) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
            var delete_field = $("#delete_selection_review").val();
            if(delete_field == ''){
                $("#delete_selection_review").val(id);
            }else{
                $("#delete_selection_review").val(delete_field + "," + id);
            }
    }

    function heighlyRecommended() {
        event.preventDefault();
        if (confirm("Are you sure want to Highly Recommended this ?")){
            var btn = $("<input>").attr("type", "hidden").attr("name", "btn").val("heighly_recommended");
            $( "#form" ).append(btn);
            $( "#form" ).submit();
        }

    }

    function recommended() {
        event.preventDefault();
        if (confirm("Are you sure want to Recommended this ?")){
            var btn = $("<input>").attr("type", "hidden").attr("name", "btn").val("recommended");
            $( "#form" ).append(btn);
            $( "#form" ).submit();
        }

    }

    function notRecommended() {
        event.preventDefault();
        if (confirm("Are you sure want to Non Recommended this ?")){
            var btn = $("<input>").attr("type", "hidden").attr("name", "btn").val("not_recommended");
            $( "#form" ).append(btn);
            $( "#form" ).submit();
        }

    }

    // write edit review
    $('#mdl_edit_record').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {

            var button = $(event.relatedTarget);
            var recordId = button.data('record_id');
            $("#delete_detail_payment_record").val('');

            if (typeof currentUserReviews !== 'undefined') {
                var data = currentUserReviews[recordId];
                console.log(data)
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                var payment_date = new Date(data.payment_date);
                $('#payment_id').val(data.id);
                $('#payment_date').val((payment_date.getDate() < 10 ? '0' + payment_date.getDate() : payment_date.getDate()) + ' ' + monthNames[payment_date.getMonth()] + ' ' + payment_date.getFullYear()).attr('autocomplete', 'off');
                $('#description').val(data.description);
                $('#category').val(data.category);
                $('#memo_budget').val(data.user_grantee_grant_memo_id);
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
                });
                $('.select2').select2({
                    theme: 'bootstrap'
                });

                do_format_input_currency();
            }
        };
    });

    function append_edit_record(i) {
        var name_class = '.request-item-record-edit' + i;
        var warp_request = '#wrap-request-record-edit' + i;
        var idx = $(name_class).length;
        var html = '';

        html = '<div id="request-item-record-edit-' + i + '" class="row request-item-record-edit mt-3" style="padding:10px">'
        html += '<div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">'
        html += '<div class="col-lg-4">'
        html += '<div class="form-group">'
        html += '<label>Payment Item</label>'
        html += '<select id="select_payment_item_edit' + i + '" name="edit_record[items][' + i + '][item]" form="form" class="form-control select2 select_payment_item_edit">'
        html += '</select>'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-4">'
        html += '<div class="form-group">'
        html += '<label>Nominal IDR</label>'
        html += '<input type="number" form="form" id="nominal_idr_edit' + i + '" class="form-control" name="edit_record[items][' + i + '][nominal_idr]">'
        html += '</div>'
        html += '</div>'
        html += '<div class="col-lg-4">'
        html += '<div class="form-group">'
        html += '<label>Nominal USD</label>'
        html += '<input type="text" form="form" id="nominal_edit' + i + '" class="form-control currency-usd" name="edit_record[items][' + i + '][nominal]">'
        html += '<input type="hidden" form="form" id="id' + i + '" class="form-control" name="edit_record[items][' + i + '][id]">'
        html += '</div>'
        html += '</div>'
        html += '</div>'
        html += '<a href="javascript:;" onclick="del_item_id(this, \'request-item-record-edit-' + i + '\')" class="btn btn-danger" id=btn_delete' + i + ' style="position:absolute;right:15px;"><i class="fa fa-trash fa-fw"></i></a>'
        html += '</div>'

        return html;

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
        
        var sub_category = $('select[name="edit_record[sub_category]"]').val();
        
        if(sub_category == ''){
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
                'category_type': 'Third Party',
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

    function submit_form()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/selection_review/get_rank_recomendation') ?>',
            data: $("#form").serialize(),
            dataType: 'JSON',
            success: function(r) {
                console.log(r)
                if(r == <?= NOT_RECOMMENDED ?>){
                    $("#mdl_note_reject_selection").modal();  
                }else{
                    $( "#form" ).submit();
                }
            }
        });
    }
    

    function emptyValue(object){
        $(object).closest('.form-group').find('.datepicker').val('');
    }

    
    function showDetailScore(object) {
        $(".render-view").html('');
        var review_id = $(object).data('id');
        var period_id = $(object).data('period_id');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/selection_review/get_detail_score') ?>/'+ review_id,
            dataType: 'JSON',
            success: function(r) {
                $(".render-view").html(r);
                $('.btn-download-score').attr("href", "<?= site_url('admin/selection_review/download_review_score/') ?>"+review_id+"/"+period_id)
                tinymce.init({
                    selector: '.editor_panelist',
                    plugins: 'link table',
                    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link',
                    contenteditable: true,
                    spellchecker: false,
                    // readonly: true
                });

                recalculate_score();

                $('.select_grade').on('change', function(){
                    recalculate_score();
                });
            }
        });
    }

    function recalculate_score()
    {
        var total_score = 0;
        let select = $(document).find('.select_grade');
        select.each(function(){
            let grade_score = $(this).val();
            if (isNaN(grade_score)) {
                grade_score = 0;
            }
            let total_score_input = $(this).closest('tr').find('input.total_score');
                total_score_input.val(grade_score);
                total_score += parseFloat(grade_score);
        });

        $("#total").text(total_score.toFixed(2));
    }



    $('.lock_review_check').change(function() {
        var isChacked = 0;
        var id = $(this).data('id');
        if($(this).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,  // Menghilangkan tombol "OK"
            didOpen: () => {
                Swal.showLoading();  // Memunculkan loading spinner
        }
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/selection_review/set_lock_review') ?>',
            dataType: 'JSON',
            data:{
                lock_review: isChacked,
                id: id
            },
            success: function(r) {
                location.reload();
            }
        });
    });
</script>