<script>

    const SITE_URL = '<?php echo site_url(); ?>';
    $(document).ready(function(){
        $(".select_show, .select-panelis-mentoring").trigger("change");
        $('.select2').select2({
            theme: 'bootstrap'
        });
        var countDataMentoring = <?= count($data_mentoring) ?>;
        if(countDataMentoring > 0){
            for (var i = 0; i < countDataMentoring; i++){
                // get_panellist(i);
            }
        }

        var form_control = $('.form-control, .radio-nominee');
        var non_disabled = $('.non-disabled');
        var form_control_grantee = $('.form-control-grantee');
        var role = '<?= isset($is_grantee) ? $is_grantee : false ?>';
        var select_status_mentoring = $('.select_status_mentoring');
        var status_mentoring = $('.hide_status_mentoring').val();
        if(role){
            $(".select_status_mentoring").trigger("change");
            form_control.prop('disabled', true).css('background-color', '#eee');
            $('.btn-for-add, .file-for-testing, .btn-delete-nominee').addClass('d-none-testing');
            non_disabled.prop('disabled', false).removeClass('d-none-testing');
            $('.active-grantee').prop('disabled', false).css('background-color', '#fff');
            $('.button-for-grantee').css('display', 'inline-block');
            form_control_grantee.prop('disabled', false).css('background-color', '#fff');
            if(status_mentoring == 'Completed'){
                select_status_mentoring.prop('disabled', true).css('background-color', '#eee');
            }else{
                select_status_mentoring.prop('disabled', false).css('background-color', '#fff');
            }
        }

        if($('#preparation_section').val() == 'gre'){
            $('.selected-preparation').css('display', 'block');
            $('.selected-preparation-section').css('display', 'block');
            $('#tab-gre-preparation').removeClass('hide');
            $('#tab-toefl-preparation').addClass('hide');

            $('#li-gre').addClass('ui-tabs-active ui-state-active');
            $('#li-toefl').removeClass('ui-tabs-active ui-state-active');
            
            $('#gre').addClass('active in').css('display', 'block');
            $('#toeft').removeClass('active in').css('display', 'none').addClass('hide');
        }

        if($('#preparation_section').val() == 'toefl_gre'){
            $('.selected-preparation').css('display', 'block');
            $('.selected-preparation-section').css('display', 'block');

            $('#tab-toefl-gre-preparation').removeClass('hide');
            $('#tab-toefl-preparation').addClass('hide');
            $('#tab-gre-preparation').addClass('hide');

            $('#li-toefl-gre').addClass('ui-tabs-active ui-state-active');
            $('#li-toefl').removeClass('ui-tabs-active ui-state-active');
            $('#li-gre').removeClass('ui-tabs-active ui-state-active');
            
            $('#toefl_gre').addClass('active in').css('display', 'block');
            $('#toeft').removeClass('active in').css('display', 'none').addClass('hide');
            $('#gre').removeClass('active in').css('display', 'none').addClass('hide');
        }

        $(document).ready(function() {
            $("#tab-test-section li:first-child a").trigger("click");
        });
    });

    function triger_dispay_tab() {
        var preparation_section = `<?= $data_preparation->preparation_section ?>`;
        if(preparation_section == 'gre')
        {
            $('#toeft').removeClass('active in').css('display', 'none');
            $('#gre').addClass('active in').css('display', 'block');
        }
    }

    function del_file(el, name, label,value='') {
        if (confirm("Are you sure want to delete " + label + " ?")) {
            var html = '<input type="hidden" name="' + name + '" value="' + value + '">';
            $(el).parent().replaceWith(html);
        }
    }

    function add_mentoring() {
        var idx = $('.mentoring-item').length;
        $('.add-load').show();
        
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/nominee/general_nominee/partialMentor') ?>/'+ idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-mentoring').append(html);
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
    
    function del_item(el, item_class, id, section) {
        if (confirm("Are you sure want to delete this ?")){
            $('.delete-load-'+section).css('display', 'block');
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/nominee/general_nominee/delete_partial') ?>?section='+ section+'&id='+ id,
                dataType: 'JSON',
                success: function(r) {
                    console.log(r)
                    if(r.success == true){
                        console.log('success')
                        $('.delete-load-'+section).css('display', 'none');
                        $("#success-alert").fadeTo(1000, 500).slideUp(500, function() {
                            $("#success-alert").slideUp(500);
                        });
                        $(el).closest('.' + item_class).remove();
                    }else{
                        console.log('failed')
                        $('.delete-load-'+section).css('display', 'none');
                        $("#delete-alert").fadeTo(1000, 500).slideUp(500, function() {
                            $("#delete-alert").slideUp(500);
                        });
                    }
                }
            });
        }
    }
    
    $('.status_preparation').change(function() {
        if (this.value == 'selected') {
            $('.selected-preparation').css('display', 'block');
            $('.selected-preparation-section').css('display', 'block');
        }
        else {
            $('.selected-preparation').css('display', 'none');
            $('.selected-preparation-section').css('display', 'none');
        }
    });

    $('.format_preparation').change(function() {
        if (this.value == 'In-Person') {
            $('.selected-preparation-format').css('display', 'block');
        }
        else {
            $('.selected-preparation-format').css('display', 'none');
        }
    });

    $('#preparation_section').change(function() {
        $('#tabs_preparation').removeClass('hide');
        if (this.value == 'toefl') {
            $('.selected-preparation').css('display', 'block');
            $('.selected-preparation-section').css('display', 'block');
            $('#tab-toefl-preparation').removeClass('hide');
            $('#tab-gre-preparation').addClass('hide');
            $('#tab-toefl-gre-preparation').addClass('hide');

            $('#li-toefl').addClass('ui-tabs-active ui-state-active');
            $('#li-gre').removeClass('ui-tabs-active ui-state-active');
            $('#li-toefl-gre').removeClass('ui-tabs-active ui-state-active');

            $('#toeft').addClass('active in').css('display', 'block');
            $('#gre').removeClass('active in').css('display', 'none');
            $('#toefl_gre').removeClass('active in').css('display', 'none');

            
            // $('#tab-toefl-preparation').css('display', 'block');
            // $('#tab-gre-preparation').css('display', 'none');
        }
        else if (this.value == 'gre'){
            $('.selected-preparation').css('display', 'block');
            $('.selected-preparation-section').css('display', 'block');
            $('#tab-gre-preparation').removeClass('hide');
            $('#tab-toefl-preparation').addClass('hide');
            $('#tab-toefl-gre-preparation').addClass('hide');

            $('#li-gre').addClass('ui-tabs-active ui-state-active');
            $('#li-toefl').removeClass('ui-tabs-active ui-state-active');
            $('#li-toefl-gre').removeClass('ui-tabs-active ui-state-active');
            
            $('#gre').addClass('active in').css('display', 'block');
            $('#toeft').removeClass('active in').css('display', 'none');
            $('#toefl_gre').removeClass('active in').css('display', 'none');
        }
        else if (this.value == 'toefl_gre'){
            $('.selected-preparation').css('display', 'block');
            $('.selected-preparation-section').css('display', 'block');
            $('#tab-toefl-gre-preparation').removeClass('hide');
            $('#tab-gre-preparation').addClass('hide');
            $('#tab-toefl-preparation').addClass('hide');

            $('#li-toefl-gre').addClass('ui-tabs-active ui-state-active');
            $('#li-toefl').removeClass('ui-tabs-active ui-state-active');
            $('#li-gre').removeClass('ui-tabs-active ui-state-active');

            $('#toefl_gre').addClass('active in').css('display', 'block');
            $('#toeft').removeClass('active in').css('display', 'block');
            $('#gre').removeClass('active in').css('display', 'none');

        }
        else  {
            // $('#tabs_preparation').addClass('hide');
            // $('#tab-gre-preparation').addClass('hide');
            // $('#tab-toefl-preparation').addClass('hide');
            // $('#li-toefl').addClass('ui-tabs-active ui-state-active');
            // $('#li-gre').addClass('ui-tabs-active ui-state-active');
            // $('#toeft').addClass('active in').css('display', 'none');
            // $('#gre').addClass('active in').css('display', 'none');
        }
    });

    function add_section(section) {
        var idx = $('.'+section+'-item').length;
        $('.add-load-'+section).show();
        
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/nominee/general_nominee/partial_') ?>'+section+'/'+ idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-'+section).append(html);
                $('.select2').select2({
            theme: 'bootstrap'
});
                $('.add-load-'+section).hide();
                $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd M yy",
                yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
            }
        });

    }

    function get_panellist(key) {
        var idx = $('#panellis_'+key).val();
        var url = '<?php echo site_url('admin/selection_review/get_panellist') ?>/'+ idx;
        var role = '<?= $this->session->userdata('role') ?>';
        if(role == ''){
            url ='<?php echo site_url('grantee/testing/get_panellist') ?>/'+ idx;
        }
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'JSON',
            success: function(r) {
                $('#field_of_study_'+key).val(r.field_of_study_name);
                $('#email_'+key).val(r.email);
                $('#tel_'+key).val(r.telp);
                var role = '<?= isset($is_grantee) ? $is_grantee : false ?>';
                if(role){
                    $('#panellis_'+key).next(".select2-container").hide();
                    $('#text_panellis_'+key).attr('type', 'text')
                    $('#text_panellis_'+key).val(r.name);
                }
            }
        });
    }

    function emptyValue(object){
        $(object).closest('.form-group').find('.datepicker').val('');
    }

    function set_value_buton_revise(param) {
        $('#btn-save-note').attr('value', param);
    }
    
    function show_preview(element, type, upload_type) {
        const file = element.files[0];
        $('#btn-save-note-withdraw').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
        let formData = new FormData();
        formData.append(upload_type, file);
        formData.append('type', upload_type);

        $.ajax({
            url: SITE_URL + 'admin/grantee/save_file', 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType : 'JSON',
            success: function(response) {
                if (response.status) {
                    render_data_upload_attach(response, upload_type);
                    // let file_url = SITE_URL + response.filepath;
                    // $(".uploaded_attachment").attr('href', file_url).removeClass('hide').html('<b> <i class="fa fa-paperclip"></i> ' + response.filename) + '</b>';
                    // $("input[name='" + upload_type +"']").val(response.filepath);
                } else {
                    $(".uploaded_attachment").addClass('hide');
                    alert('Failed to upload your file, please try again');
                }

                $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
            },
            error: function(xhr, status, error) {
                $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
                console.error(error); 
            }
        });
    }

    function show_hide_transportation(obj, section, index){
        $element = $(obj).val();
        if($element == 'No' || $element == ''){
            $('.section-transportation-'+section+'-'+index).addClass('hide');
        }else{
            $('.section-transportation-'+section+'-'+index).removeClass('hide');
        }

        if($element == 'Reimbursement'){
            $('#label_eticket_'+section+'_'+index).html('Receipt')
            $('.returing_section_'+section+'_'+index).addClass('hide')
            $('#returning_date_'+section+'_'+index).removeClass('hide')
            $('#travel_agen_general_'+section+'_'+index).removeClass('hide')
            $('.label-transport-'+section+'-'+index).addClass('hide')
        }else if($element == 'Departure Reimbursement'){
            $('#label_eticket_'+section+'_'+index).html('Departure E-ticket')
            $('.returing_section_'+section+'_'+index).removeClass('hide')
            $('#returning_date_'+section+'_'+index).addClass('hide')
            $('#travel_agen_general_'+section+'_'+index).addClass('hide')
            $('#travel_agen_returning_'+section+'_'+index).removeClass('hide')
            $('.label-transport-'+section+'-'+index).removeClass('hide')
        }else if($element == 'Return Reimbursement'){
            $('#label_eticket_'+section+'_'+index).html('Departure E-ticket')
            $('.returing_section_'+section+'_'+index).removeClass('hide')
            $('#returning_date_'+section+'_'+index).addClass('hide')
            $('#travel_agen_general_'+section+'_'+index).removeClass('hide')
            $('#travel_agen_returning_'+section+'_'+index).addClass('hide')
            $('.label-transport-'+section+'-'+index).removeClass('hide')
        }else{
            $('#returning_date_'+section+'_'+index).removeClass('hide')
            $('.returing_section_'+section+'_'+index).addClass('hide')
            $('#label_eticket_'+section+'_'+index).html('E-Ticket')
            $('#travel_agen_general_'+section+'_'+index).removeClass('hide')
            $('.label-transport-'+section+'-'+index).addClass('hide')
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

    function delete_file_mentoring(el, id, is_admin)
    {
        var url = '<?php echo site_url('admin/nominee/general_nominee/delete_file_mentoring/') ?>' + id;
        if(is_admin == 0) {
            url = '<?php echo site_url('grantee/submission/delete_file_mentoring/') ?>' + id;
        }
        
        if (confirm("Are you sure want to delete this ?")){
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success == true){
                        $(el).closest('tr').remove();
                        showSwal('success', 'Successfully delete the file', false, true, 1500);
                    }else{
                    }
                }
            });
        }

    }

    $(document).on('click', '.upload-button', function() {
        var data_value = $(this).data('file-value');
        console.log(data_value)
        $('#' + data_value).click();
        $('#' + data_value).change(function(e){
            showSwal('loading', 'Please wait while we process your request.');
            $('#form').submit()
        })
        //     var table_save = $(this).data('table_save');
        //     var doc_type = $(this).data('doc');
        //     var is_admin = $(this).data('is_admin') ? 1 : 0;
        //     var data_default = $(this).data('default') == undefined ? 0 : 1;
        //     var data_id = $(this).data('id') == undefined ? '' : $(this).data('id');
        //     var file = e.target.files[0];
        //     var grantee_grant_id = $('#grantee_grant_id').val();
        //     var departure_id = $('#departure_id').val();
        //     let currentTd = $('.btn-' + doc_type + '-' + data_id).closest("td");
        //     var id = 1;
        //     var function_name = table_save == 'save_ds2019_sign' ? 'save_ds2019_sign' : 'save_required_document';
        //     if(is_admin){
        //         var urlAjax = "<?= base_url(); ?>admin/departure/" + function_name;
        //     }else{
        //         var urlAjax = "<?= base_url(); ?>grantee/submission/" + function_name
        //     }
        //     showSwal('loading', 'Please wait while we process your request.');
    
    
        //     var formData = new FormData();
        //     formData.append("file", e.target.files[0]);
        //     formData.append("doc_type", doc_type);
        //     formData.append("data_id", data_id);
        //     formData.append("default", data_default);
        //     formData.append("grantee_grant_id", grantee_grant_id);
        //     formData.append("departure_id", departure_id);
        //     formData.append("table_save", table_save);
        //     formData.append("is_admin", is_admin);
        //     $.ajax({
        //         url: urlAjax,
        //         type: 'POST',
        //         data: formData, // The form with the file inputs.
        //         processData: false,
        //         contentType: false // Using FormData, no need to process data.
        //     }).done(function(r) {
        //         $('.btn-del-req-'+doc_type).remove();
        //         $('.upload_require_doc_'+doc_type+'_'+data_id).remove();
        //         $('.btn-'+doc_type+'-'+data_id).remove();
        //         currentTd.append(r.filename)
        //         currentTd.append(r.upload)
        //         currentTd.append(r.input)
        //         currentTd.append(r.delete)
        //         // currentTd.prev("td").text('');
        //         // currentTd.prev("td").append(r.filename); 
        //         $('.lightbox').topbox();
        //         showSwal('success', 'Successfully upload the file', false, true, 1500);
        //     })
        //     .fail(function() {
        //         showSwal('error', 'Failed to upload the file', false, true, 1500);
        //     });
    
        //     $(this).val('');
        // });
    })

    $(document).on('click', '.upload-mentoring', function() {
        var data_value = $(this).data('file-value');
        $('.' + data_value).click();

        $('.' + data_value).off('change').on('change', function(e){
            var grantee_grant_id = $(this).data('grantee_grant_id');
            var mentoring_id = $(this).data('mentoring');
            var id = $(this).data('id');
            var is_admin = $(this).data('is_admin') ? 1 : 0;
            var status = $('.select_status_mentoring').val();
            

            let currentTd = $('.btn-mentoring-' + mentoring_id).closest("td");
            if(is_admin){
                var urlAjax = "<?= base_url(); ?>admin/nominee/general_nominee/upload_mentoring";
            }else{
                var urlAjax = "<?= base_url(); ?>grantee/submission/upload_mentoring"
            }
            showSwal('loading', 'Please wait while we process your request.');
    
    
            var formData = new FormData();
            formData.append("file", e.target.files[0]);
            formData.append("grantee_grant_id", grantee_grant_id);
            formData.append("mentoring_id", mentoring_id);
            formData.append("is_admin", is_admin);
            formData.append("status", status);
            formData.append("id", id);
            $.ajax({
                url: urlAjax,
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                dataType: 'JSON',
                contentType: false // Using FormData, no need to process data.
            }).done(function(r) {
                if(r.success){
                    $('.btn-mentoring-' + mentoring_id).addClass('hide')
                    currentTd.append(r.filename)
                    currentTd.append('<i class="fa fa-circle-o-notch fa-spin download-spinner hide"></i>')
                    currentTd.closest('tr').find('.action-mentoring-' + mentoring_id).append(r.download).append(r.delete);
                    updateActionHeader(currentTd.closest('table'));
                    currentTd.prev("td").append(r.created_date); 
                    $('.lightbox').topbox();
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                    // checkAllMentoringComplete();
                }
            })
            .fail(function() {
                showSwal('error', 'Failed to upload the file', false, true, 1500);
            });
    
            $(this).val('');
        });
    });


    function updateActionHeader(table) {
        var count = table.find('tbody a.lightbox').length;
        table.find('.action-col').toggleClass('hide', count === 0);
        table.find('.action-label').toggleClass('hide', count > 1);
        table.find('.btn-download-mentoring').toggleClass('hide', count <= 1);
    }

    function del_mentoring(el, id, is_admin)
    {
        if (confirm("Are you sure want to delete this ?")){
            let currentTd = $(el).closest("td");
            showSwal('loading', 'Please wait while we process your request.');
            if(is_admin){
                var urlAjax = "<?= base_url(); ?>admin/nominee/general_nominee/delete_mentoring/" + id;
            }else{
                var urlAjax = "<?= base_url(); ?>grantee/submission/delete_mentoring/" + id;
            }
            $.ajax({
                type: 'GET',
                url: urlAjax,
                dataType: 'JSON',
                success: function(r) {
                    Swal.close(); 
                    $(el).remove();
                    $('.data-mentoring-' + id).remove();
                    var fileTd = currentTd.prev('td');
                    fileTd.find('.upload-mentoring').removeClass('hide');
                    fileTd.find('.download-spinner').remove();
                    fileTd.prev("td").html(''); 
                    currentTd.html('');
                    $('.btn-download-mentoring').each(function() {
                        updateActionHeader($(this).closest('table'));
                    });
                    showSwal('success', 'Successfully delete the file', false, true, 1500);
                    // checkAllMentoringComplete()
                }
            });
        }
    }

    $(document).on('click', '.btn-download-mentoring', function() {
        var btn = $(this);
        var links = btn.closest('table').find('tbody a.lightbox').toArray();
        if (!links.length) {
            showSwal('warning', 'No files to download', false, true, 2000);
            return;
        }
        btn.prop('disabled', true);

        var items = links.map(function(link) {
            return {
                link: link,
                spinner: $(link).closest('td').find('.download-spinner').removeClass('hide')
            };
        });

        Promise.all(items.map(function(item) {
            return fetch(item.link.href)
                .then(function(response) {
                    if (!response.ok) throw new Error('Invalid response');
                    return response.blob().then(function(blob) { item.blob = blob; });
                })
                .catch(function() { item.spinner.addClass('hide'); });
        })).then(function() {
            var i = 0;
            function downloadNext() {
                if (i >= items.length) {
                    btn.prop('disabled', false);
                    return;
                }
                var item = items[i++];
                if (item.blob) {
                    item.spinner.addClass('hide');
                    var url = URL.createObjectURL(item.blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = item.link.getAttribute('data-filename') || decodeURIComponent(item.link.href.split('/').pop());
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    setTimeout(function() { URL.revokeObjectURL(url); }, 1000);
                }
                setTimeout(downloadNext, 800);
            }
            downloadNext();
        });
    });

    $(document).on('click', '.btn-download-file', function() {
        var btn = $(this);
        var row = btn.closest('tr');
        var link = row.find('a.lightbox')[0];
        if (!link) return;
        var spinner = row.find('.download-spinner').removeClass('hide');
        btn.prop('disabled', true);

        fetch(link.href)
            .then(function(response) {
                if (!response.ok) throw new Error('Invalid response');
                return response.blob();
            })
            .then(function(blob) {
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = link.getAttribute('data-filename') || decodeURIComponent(link.href.split('/').pop());
                document.body.appendChild(a);
                a.click();
                a.remove();
                setTimeout(function() { URL.revokeObjectURL(url); }, 1000);
            })
            .catch(function() {
                showSwal('error', 'Failed to download the file', false, true, 2000);
            })
            .finally(function() {
                spinner.addClass('hide');
                btn.prop('disabled', false);
            });
    });

    function checkAllMentoringComplete() {
        var allComplete = true;

        $('tr').each(function() {
            if ($(this).hasClass('mentoring-row')) {
                if ($(this).find('a.lightbox').length === 0) {
                    allComplete = false;
                }
            }
        });
        return allComplete;
    }
    
    $('#btn-submit-mentoring').on('click', function() {
        const status = $('.select_status_mentoring').val();

        if(status == 'Completed'){
            if (!checkAllMentoringComplete()) {
                showSwal('warning', 'Please Complete Final Essays', false, true, 2000);
            }else{
                $('#form').submit();
            }
        } else {
            $('#form').submit();
        }
    });

    $('.select_status_mentoring').on('change', function() {
        const status = $(this).val();
        const is_admin = <?= $is_admin ? 1 : 0 ?>;

        $('.hide_status_mentoring').val(status);

        if(!is_admin){
            if(status == 'Completed'){
                $('.panel-file-mentoring').removeClass('hide')
            }else{
                $('.panel-file-mentoring').addClass('hide')
            }
        }

    });

</script>