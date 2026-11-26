<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    const is_admin = <?= $is_admin && $this->session->userdata('role') != 'travel-booking-assistant' ? 1 : 0 ?>;
    var grantee_grant_id = <?= $grantee_grant_id ?>;

    $(document).ready(function(){
        $('#bank_info_id').trigger('change')
        
        const selected = $('.radio-completed-study:checked').val();
        if (selected) {
            toggleSection(selected);
        } else {
            $('.section-yes, .section-no').addClass('hide');
        }


        $(document).on('change', 'select.form-control, input.form-control, input.autosave, select.select2, select.autosave, textarea.autosave, textarea.form-control', function() {
            let currentElement = $(this);

            let is_required = false;
            if ($(this).prop('required')) {
                is_required = true;
            }

            if (currentElement.is('input') && is_required) {
                let not_allowed_input_value = [null, '', undefined];
                if (not_allowed_input_value.includes($(this).val())) {
                    const has_warning = $(this).closest('div').find('p.text-required');
                    if (has_warning.length == 0) {
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                } else {
                    $(this).closest('div').find('.text-required').remove();
                }
            } else if (currentElement.is('select') && is_required) {
                
                let first_value = $(this).find("option:first").val();
                
                if ($(this).val() == '' || $(this).val() == null) {
                    const has_warning = $(this).closest('div').find('p.text-required');
                    if (has_warning.length == 0) {
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                } else {
                    $(this).closest('div').find('.text-required').remove();
                }

            } else if (currentElement.is('textarea') && is_required) {
                let invalid_values = [null, ''];
                if (invalid_values.includes($(this).val())) {
                    const has_warning = $(this).closest('div').find('p.text-required');
                    if (has_warning.length == 0) {
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                } else {
                    $(this).closest('div').find('.text-required').remove();
                }
            }
        });
    });
    
    function set_session(sessionValue)
    {
        $.ajax({
            url: '<?= base_url('world/set_session') ?>',
            type: 'POST',
            data: { sessionKey: 'last_list', sessionValue: sessionValue }
            // success: function (response) {
            //     alert('Session saved: ' + response.success);
            // },
            // error: function () {
            //     alert('Error saving session.');
            // }
        });

    }

    $(".upload_departure_item").click(function() {
        var data_value = $(this).data('file-value');
        var document = $(this).data('document');
        $('.' + data_value).click();
        $('.' + data_value).change(function(e){
            var file = e.target.files[0];
            let currentTd = $(this).closest("td");
            
            if (file) {
                if(is_admin) {
                    urlAjax =  "<?= base_url(); ?>admin/returning/upload_file_returning";
                }else{
                    urlAjax =  "<?= base_url(); ?>grantee/submission/upload_file_returning";
                }

                showSwal('loading', 'Please wait while we process your request.');
                var formData = new FormData();
                formData.append("file", e.target.files[0]);
                formData.append("grantee_grant_id", grantee_grant_id);
                formData.append("document", document);
                formData.append("is_admin", is_admin);
                $.ajax({
                    url: urlAjax,
                    type: 'POST',
                    data: formData, // The form with the file inputs.
                    processData: false,
                    dataType: 'JSON',
                    contentType: false // Using FormData, no need to process data.
                }).done(function(r) {
                    if(r.success){
                        if(is_admin){
                            currentTd.find('.show-button').removeClass('hide')
                        }else{
                            currentTd.find('.show-button').addClass('hide')
                            currentTd.find('.upload_departure_item').addClass('hide')
                        }
                        currentTd.prev("td").text('');
                        currentTd.prev("td").append(r.created_date); 
                        currentTd.prev("td").prev("td").text('');
                        currentTd.prev("td").prev("td").text(r.status);
                        currentTd.prev("td").prev("td").prev("td").text('')
                        currentTd.prev("td").prev("td").prev("td").append(r.filename);
                        $('.lightbox').topbox();
                        showSwal('success', 'Successfully upload the file', false, true, 1500);
                    }else{
                        showSwal('error', r.message, false, true, 2000);
                    }
                })
                .fail(function() {
                    showSwal('error', 'Failed to upload the file', false, true, 1500);
                });
        
                $(this).val('');

                // VALIDASI UNTUK TYPE FILE
                // var fileType = file.type;
                // if (fileType !== 'application/pdf') {
                //     showSwal('error', 'Only PDF files are allowed.', false, true, 1500);
                //     $(this).val('');
                //     return false
                // }else{
                // }
            }
        });
    })

    function del_file_returning(el, grantee_grant_id, document) {
        if (confirm("Are you sure want to delete this ?")){
            if(is_admin) {
                urlAjax =  '<?php echo site_url('admin/returning/delete_file_returning') ?>/'+ grantee_grant_id + '/' + document;
            }else{
                urlAjax =  '<?php echo site_url('grantee/submission/delete_file_returning') ?>/'+ grantee_grant_id + '/' + document
            }
            let currentTd = $(el).closest("td");
            $.ajax({
                type: 'GET',
                url: urlAjax,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        currentTd.find('.show-button').addClass('hide')
                        currentTd.prev("td").text('');
                        currentTd.prev("td").prev("td").text('');
                        currentTd.prev("td").prev("td").prev("td").text('')
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
        }

    }

    function update_status_file_returning(el, grantee_grant_id, status, field, id = 0) {
        if (confirm("Are you sure want to "+status+" this ?"))
            if(status == 'revise'){
                $('#mdl_note_revise').modal()
                $('#btn-save-note').attr("onclick","update_status_file_returning_action("+ grantee_grant_id +", '"+ status +"', '"+ field +"', '"+ id +"')"); 
            }else{
                update_status_file_returning_action(grantee_grant_id, status, field, id);
            }
    }

    function update_status_file_returning_action(grantee_grant_id, status, field, id=0) {
        var note = $('#note_revise').val();
        var modal = $('#mdl_note_revise');
        var fileInput = modal.find('input[type="file"][name="temp_attachment_revise"]')[0] || modal.find('#temp_attachment_revise')[0];
        var btnSave = $('#btn-save-note');

        var doSave = function(attachment_revise) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/returning/update_status_file_returning') ?>',
                data: {
                    grantee_grant_id: grantee_grant_id,
                    status: status,
                    note: note,
                    field: field,
                    attachment_revise: attachment_revise,
                    id: id
                },
                dataType: 'JSON',
                success: function(r) {
                    if (r.success) {
                        location.reload();
                    } else {
                        btnSave.html('Save').prop('disabled', false);
                    }
                },
                error: function() {
                    btnSave.html('Save').prop('disabled', false);
                }
            });
        };

        if (status == 'revise' && fileInput && fileInput.files && fileInput.files.length > 0) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            let formData = new FormData();
            formData.append('attachment_revise', fileInput.files[0]);
            formData.append('type', 'attachment_revise');

            $.ajax({
                url: SITE_URL + 'admin/grantee/save_file',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response.status) {
                        let paths = [];
                        if (response.files && response.files.length > 0) {
                            response.files.forEach(function(f) {
                                paths.push(f.filepath);
                            });
                        } else if (response.filepath) {
                            paths.push(response.filepath);
                        }
                        let paths_json = JSON.stringify(paths);
                        $('#attachment_revise').val(paths_json);
                        doSave(paths_json);
                    } else {
                        btnSave.html('Save').prop('disabled', false);
                        alert(response.message || 'Failed to upload your file, please try again');
                    }
                },
                error: function(xhr, status, error) {
                    btnSave.html('Save').prop('disabled', false);
                    console.error(error);
                    alert('Failed to upload your file, please try again');
                }
            });
        } else {
            var attachment_revise = $('#attachment_revise').val();
            doSave(attachment_revise);
        }
    }
    
    function show_preview_attch(element, type, upload_type) {
        const file = element.files[0];
        let modal = $(element).closest('.modal');
        let previewEl = modal.find('.uploaded_attachment_admin, .uploaded_attachment');

        if (!file) {
            previewEl.addClass('hide').html('');
            modal.find("input[name='" + upload_type + "']").val('');
            return;
        }

        let file_url = URL.createObjectURL(file);
        if (previewEl.is('a')) {
            previewEl.attr('href', file_url)
                     .removeClass('hide')
                     .html('<b><i class="fa fa-paperclip"></i> ' + file.name + '</b>');
        } else {
            previewEl.removeClass('hide').html(`
                <div>
                    <a href="${file_url}" target="_blank">
                        <b><i class="fa fa-paperclip"></i> ${file.name}</b>
                    </a>
                </div>
            `);
        }
    }

    $('#mdl_note_revise').on('hidden.bs.modal', function () {
        $(this).find('input[type="file"]').val('');
        $(this).find('input[name="attachment_revise"]').val('');
        $(this).find('.uploaded_attachment_admin, .uploaded_attachment').addClass('hide').html('');
        $(this).find('#note_revise').val('');
        $('#btn-save-note').html('Save').prop('disabled', false);
    });

    // $('.span-note').click(function(){
    //     var note = $(this).data('note');
    //     var attach = $(this).data('attach');
    //     $('.note-note').val(note)
    //     if(attach){
    //         $('#attach_revise').attr('href', SITE_URL + attach)
    //         $('#attach_revise').removeClass('hide')
    //     }else{
    //         $('#attach_revise').addClass('hide')
    //     }
    // })


    $(".modal-log").click(function(e){
        var data_id = $(this).data('log')
        var type = $(this).data('type')
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/returning/get_log') ?>',
            dataType: 'JSON',
            data:{
                id: data_id,
                table: 'am_' + type
            },
            success: function(r) {
                $("#model-payment-log tbody").html("");
                if (r.status){
                    for (let i = 0; i<r.data.length;i++){
                        var checkData = JSON.parse(r.data[i].old_values); 
                        if (checkData && checkData.hasOwnProperty('revise_from')) {
                            
                        } else {
                            var action = r.data[i].old_values != null || r.data[i].new_values != null 
                                            ? "<a data-old_data='"+ JSON.stringify(r.data[i].old_values).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' data-new_data='"+ JSON.stringify(r.data[i].new_values).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>" 
                                            : '';

                            var created_at = "<td>" + r.data[i].created_at + "</td>"; 
                            var event = "<td>" + r.data[i].event + "</td>"; 
                            var created_by = "<td>" + r.data[i].created_name + "</td>"; 
                            var pAction = "<td>" + action + "</td>"; 
                            
                            $("#model-payment-log tbody").append(`<tr>${created_at}${event}${created_by}${pAction}</tr>`)
                        }
                    }
                }
            }
        })
    });

    $(document).on('click', '.view-detail-log', function(e){
        let element = $(this);
        let old_data = JSON.parse(element.data('old_data'));
        let new_data = JSON.parse(element.data('new_data'));
        old_data = JSON.parse(old_data);
        new_data = JSON.parse(new_data);
        // old data
        let element_old_data = '';
        if (old_data != null) {

            element_old_data += '<table class="table table-striped">';
            $.each(old_data, function(key, value) {
                if(key == 'file' || key == 'file_grantee' || key == 'file_admin' || key == 'attachment_revise'){
                    if(value != ''){
                        // value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                        let files;
    
                        try {
                            files = JSON.parse(value);
                        } catch {
                            value = value.replace(/^\[|\]$/g,'').replace(/"/g,'');
                            files = value.includes(',') ? value.split(',') : [value];
                        }
    
                        files = Array.isArray(files) ? files : [files];
    
                        value = files.map(f =>
                            `<a href="${SITE_URL + f.trim()}" class="lightbox btn btn-primary btn-xs me-1">View</a>`
                        ).join('');
                    }
                }
                if(key == 'grantee_grant_id' || key == 'filename' || key == 'filename_grantee' || key == 'departure_id'){
                    return true;
                }

                if(key == 'file_admin'){
                    key = 'Template File'
                }
                element_old_data += '<tr>';
                    element_old_data += '<td class="text-left" width="35%">';
                        element_old_data += formatText(key);
                    element_old_data += '</td>';
                    element_old_data += '<td class="text-left">';
                        element_old_data += ': ' + value;
                    element_old_data += '</td>';
                element_old_data += '</tr>';
            });
            element_old_data += '</table>';
        }

        // new data
        let element_new_data = '';
        if (new_data != null) {

            element_new_data += '<table class="table table-striped">';
            $.each(new_data, function(key, value) {
                if(key == 'file' || key == 'file_grantee' || key == 'file_admin' || key == 'attachment_revise'){
                    if(value != ''){
                        // value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                        let files;
    
                        try {
                            files = JSON.parse(value);
                        } catch {
                            value = value.replace(/^\[|\]$/g,'').replace(/"/g,'');
                            files = value.includes(',') ? value.split(',') : [value];
                        }
    
                        files = Array.isArray(files) ? files : [files];
    
                        value = files.map(f =>
                            `<a href="${SITE_URL + f.trim()}" class="lightbox btn btn-primary btn-xs me-1">View</a>`
                        ).join('');
                    }
                }
                if(key == 'grantee_grant_id' || key == 'filename' || key == 'filename_grantee' || key == 'departure_id'){
                    return true;
                }

                if(key == 'file_admin'){
                    key = 'Template File'
                }
                element_new_data += '<tr>';
                    element_new_data += '<td class="text-left" width="35%">';
                        element_new_data += formatText(key);
                    element_new_data += '</td>';
                    element_new_data += '<td class="text-left">';
                        element_new_data += ': ' + value;
                    element_new_data += '</td>';
                element_new_data += '</tr>';
            });
            element_new_data += '</table>';
        }

        $("#old-data").html(element_old_data);
        $("#new-data").html(element_new_data);
        $("#modal-payment-log").modal('hide');
        $("#mdl_detail_log").modal('show');
        $('.lightbox').topbox();
        
    });

    $('#bank_info_id').change(function(){
        var id = $(this).val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/bank_info') ?>/'+ id,
            dataType: 'JSON',
            success: function(r) {
                if(r){
                    $('#bank_name').val(r.bank_name)
                    $('#bank_address').val(r.bank_address)
                    $('#beneficiary_name').val(r.beneficiary_name)
                    $('#account_number').val(r.account_number)
                    $('#routing_number').val(r.routing_number)
                    $('#swift_code').val(r.swift_code)
                    $('#currency').val(r.currency)
                    if(r.account_book){
                        var url = '<?= base_url(); ?>' + r.account_book;
                        var previewImage = r.preview_image;
                        $('.aimage, #preview_image_account_book, #button_download_account_book, #button_preview_account_book').removeClass('hide').attr('src', previewImage).attr('href', url);
                    }else{
                        $('.aimage, #preview_image_account_book, #button_download_account_book, #button_preview_account_book').addClass('hide');
                    }
                }else{
                    $('#bank_name').val('')
                    $('#bank_address').val('')
                    $('#beneficiary_name').val('')
                    $('#account_number').val('')
                    $('#routing_number').val('')
                    $('#swift_code').val('')
                    $('#currency').val('')
                    $('.aimage, #preview_image_account_book, #button_download_account_book, #button_preview_account_book').addClass('hide')
                }
            }
        });
    })
    

    const fieldShowDomesticTransportation = $('#show_transportation_domestic');
    const fieldShowDomesticAccomodation = $('#show_accommodation_domestic');

    fieldShowDomesticTransportation.change(function(){
        if($(this).val() == 'No' || $(this).val() == ''){
            $('.section-transportation-domestic, .section-domestic').addClass('hide');
        }else{
            $('.section-transportation-domestic, .section-domestic').removeClass('hide');
        }

        if($(this).val() == 'Yes' || fieldShowDomesticAccomodation.val() == 'Yes' || $(this).val() == 'Reimbursement' || fieldShowDomesticAccomodation.val() == 'Reimbursement'){
            $('.section-domestic').removeClass('hide');
        }else{
            $('.section-domestic').addClass('hide');
        }

        if($(this).val() == 'Reimbursement'){
            $('#label_eticket_domestic').html('Receipt')
        }else{
            $('#label_eticket_domestic').html('E-Ticket')
        }

        // if(fieldShowDomesticAccomodation.val() == 'No'){
        //     $('.section-domestic').addClass('hide');
        // }
    })

    fieldShowDomesticAccomodation.change(function(){
        if($(this).val() == 'No' || $(this).val() == ''){
            $('.section-accomodation-domestic, .section-domestic').addClass('hide');
        }else{
            $('.section-accomodation-domestic, .section-domestic').removeClass('hide');
        }

        if($(this).val() == 'Yes' || fieldShowDomesticTransportation.val() == 'Yes' || $(this).val() == 'Reimbursement' || fieldShowDomesticTransportation.val() == 'Reimbursement'){
            $('.section-domestic').removeClass('hide');
        }else{
            $('.section-domestic').addClass('hide');
        }

        if($(this).val() == 'Reimbursement'){
            $('#label_voucher_hotel_domestic').html('Receipt')
        }else{
            $('#label_voucher_hotel_domestic').html('Hotel Voucher')
        }

        // if(fieldShowDomesticTransportation.val() == 'No'){
        //     $('.section-domestic').addClass('hide');
        // }
    })

    $(document).ready(function(){
        if(is_admin){
            if(fieldShowDomesticTransportation.val() == 'Yes' || fieldShowDomesticAccomodation.val() == 'Yes' || fieldShowDomesticTransportation.val() == 'Reimbursement' || fieldShowDomesticAccomodation.val() == 'Reimbursement'){
                $('.section-domestic').removeClass('hide');
            }else{
                $('.section-domestic').addClass('hide');
            }
        }
    });
    
    function show_preview_certificate(element) {
        const file = element.files[0];
        const filetype = file.name.split('.').pop();
        const allowed_extensions = ['jpg', 'jpeg', 'png', ['pdf']];

        const is_valid_extension = allowed_extensions.some(function(extension) {
            return filetype.toLowerCase().endsWith(extension);
        });

        var urlAjax =  "<?= base_url(); ?>grantee/submission/upload_certificate";

        if(is_admin) {
            urlAjax =  "<?= base_url(); ?>admin/returning/upload_certificate";
        }

        if (is_valid_extension > 0) {
            showSwal('loading', 'Please wait while we process your request.');
            let formData = new FormData();
            formData.append('file', file);
            formData.append('grantee_grant_id', grantee_grant_id);

            $.ajax({
                url: urlAjax,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response.status) {
                        let file_url = SITE_URL + response.filepath;
                        $('#preview_certificate').attr('src', response.previewImage);
                        $('.link-image').attr('href', file_url);
                        $('#button_delete_certificate, #button_download_certificate').removeClass('hide');
                        showSwal('success', 'Successfully upload the file', false, true, 1500);
                        setTimeout(function(){ location.reload() }, 1000);
                    } else {
                        alert('Failed to upload your file, please try again');
                    }

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            showSwal('error', 'Failed to upload the file', false, true, 1500);
        }
    }

    function delete_certificate(element, grantee_grant_id)
    {
        if (confirm("Are you sure want to delete this ?")){

            var urlAjax =  "<?= base_url(); ?>grantee/submission/delete_certificate/" + grantee_grant_id;

            if(is_admin) {
                urlAjax =  SITE_URL + 'admin/returning/delete_certificate/' + grantee_grant_id;
            }
            $.ajax({
                url: urlAjax,
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    if (response.status) {
                        showSwal('success', 'Successfully delete the file', false, true, 1500);
                        setTimeout(function(){ location.reload() }, 1000);
                    } else {
                        alert('Failed to upload your file, please try again');
                    }

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

    }
    
    function delete_file_returning(el, field, is_admin) {
        if (confirm("Are you sure want to delete this ?")){
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/returning/delete_file_transport_returning') ?>/'+ grantee_grant_id + '/' + field;
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/delete_file_transport_returning') ?>/'+ grantee_grant_id + '/' + field;
            }
            $.ajax({
                type: 'GET',
                url: urlAjax,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        if(field == 'ds2019'){
                            $('.delete-ds2019').addClass('hide');
                            $('.fileview-ds2019').addClass('hide');
                            $('#preview_image').attr('src', '<?= site_url('assets/images/icons/add-file.png')?>');
                        }else{
                            $('#file_'+field).remove();
                        }
                        showSwal('success', 'Successfully delete the file', false, true, 1500);
                    }
                }
            });
        }
    }

    $('.radio-completed-study').on('change', function() {
        const value = $(this).val();
        toggleSection(value);
    });

    function toggleSection(value) {
        $('.section-yes, .section-no').addClass('hide');
        
        if (value === 'Yes') {
            $('.section-yes').removeClass('hide');
            $('.section-no').addClass('hide');
        } else if (value === 'No') {
            $('.section-no').removeClass('hide');
            $('.section-yes').addClass('hide');
        }
    }



    $("#btn-upload-ds2019-ongoing").click(function(){
        var fd = new FormData();
        var year = $('#year_ds2019_ongoing').val();
        var files = $('#upload_ds2019_file_ongoing')[0].files;
        var input_file = document.getElementById('upload_ds2019_file_ongoing'); 
        var totalfiles = input_file.files.length;
        var is_admin = '<?= $is_admin ?>';
        var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
        var order = $('#table-ds2019-ongoing tbody tr').length + 1;
        if(is_admin){
            var urlAjax = '<?php echo site_url('admin/on_going/add_ds2019') ?>';
        }else{
            var urlAjax = '<?php echo site_url('grantee/submission/add_ds2019_on_going') ?>';
        }
        $('#btn-upload-ds2019-ongoing').prop('disabled', true);


        // validate dependent
        var numberofDependent = $('#number_of_dependent_renewal').val();
        if($('#have_dependent_ongoing').val() == 'No'){
            numberofDependent = 0;
        }
        var countList = $("#ds2019_list_ongoing tr").length - 1;
        var totalCountList = countList + totalfiles

        if(totalCountList > numberofDependent){
            $("#upload_ds2019_ongoing").modal('hide');  
            $('#btn-upload-ds2019-ongoing').prop('disabled', false);
            $('#upload_ds2019_file_ongoing').val('');
            showSwal('error', 'The amount you entered exceeds the dependent value. Please adjust accordingly.', false, true, 2500);
            return false
        }


        // Check file selected or not
        if(totalfiles > 0 ){
            for (var i = 0; i < totalfiles; i++) {
                fd.append("file_"+i, input_file.files[i]);
            }
            fd.append("year", year);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('is_admin',is_admin);
            fd.append('order',order);
            fd.append('is_returning',true);
            $.ajax({
                url: urlAjax,
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-upload-ds2019-ongoing').prop('disabled', false);
                    $('#upload_ds2019_file_ongoing').val('');
                    $("#upload_ds2019_ongoing").modal('hide');   
                    $('#ds2019_list_ongoing').append(response.html);
                    $('#departure_id').val(response.departure_id);
                    $('.lightbox').topbox();
                    updateOrderAfterDelete();
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-upload-ds2019-ongoing').prop('disabled', false);
        }
    });



    function del_data_ds2019(el, id, is_admin) {
        if (confirm("Are you sure want to delete this ?")){
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/on_going/delete_data_ds2019/') ?>';
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/delete_data_ds2019_on_going/') ?>';
            }
            $.ajax({
                type: 'GET',
                url: urlAjax + id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                        updateOrderAfterDelete();
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
        }

    }

    function enable_delete_file(element, section) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        var id = $(element).data('id')
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/on_going/enable_delete/') ?>'+ section + '/' + id + '/' + isChacked,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }
    
    function updateOrderAfterDelete() {
        let order = [];
        $("#table-ds2019-ongoing tbody tr").each(function(index) {
            order.push({ id: $(this).data("id"), order: index + 1 });
        });
                
        let sorted_ids = [];
        $("#table-ds2019-ongoing tbody").find('tr').each(function(index) {
            let row = $(this);
            let row_number = index + 1;
            row.find('td:first').text(row_number);
        });

    }



    // ========================= TRANSCRIP DIPLOMA =================
        $("#form_transcript_diploma").on("submit", function (e) {
            e.preventDefault();

            if (this.checkValidity()) {
                var form = document.getElementById('form_transcript_diploma');
                var formData = new FormData(form);

                var is_admin = $('#is_admin').val();
                var urlAjax = '<?php echo site_url('admin/returning/add_transcript_diploma') ?>';
                if(!is_admin){
                    urlAjax = '<?php echo site_url('grantee/submission/add_transcript_diploma') ?>'
                }
                var index = $('#transcript_diploma_list tr').length;
                var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
                formData.append('index', (index + 1));
                formData.append('grantee_grant_id', grantee_grant_id);
                formData.append('is_admin', is_admin);

                $('#btn-add-transcript_diploma').prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: urlAjax,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $('#btn-add-transcript_diploma').prop('disabled', false);
                        $('.fields_transcript_diploma').val('');
                        $("#add_transcript_diploma").modal('hide');  
                        if(response.is_edit){
                            $('#index-transcript_diploma-'+response.index+ ' td').remove();
                            $('#index-transcript_diploma-'+response.index).append(response.html);
                            showSwal('success', 'Successfully edit the data', false, true, 1500);
                        }else{ 
                            $('#transcript_diploma_list').append(response.html);
                            showSwal('success', 'Successfully add the data', false, true, 1500);
                        }
                        $('.lightbox').topbox();

                        if($('#transcript_diploma_list tr').length >= 2){
                            $('.add_transcript_diploma').addClass('hide')
                        }else{
                            $('.add_transcript_diploma').removeClass('hide')
                        }
                    }
                });
            } else {
                alert("Please fill out all required fields correctly.");
            }
        });

        function del_data_transcript_diploma(el, id, index) {
            var is_admin = $('#is_admin').val();
            var urlAjax = '<?php echo site_url('admin/returning/delete_transcript_diploma') ?>/'+ id;
            if(!is_admin){
                urlAjax = '<?php echo site_url('grantee/submission/delete_transcript_diploma') ?>/'+ id;
            }
            if (confirm("Are you sure want to delete this ?"))
                $.ajax({
                    type: 'GET',
                    url: urlAjax,
                    dataType: 'JSON',
                    success: function(r) {
                        if(r.success){
                            $(el).closest('tr').remove();

                            if($('#transcript_diploma_list tr').length >= 2){
                                $('.add_transcript_diploma').addClass('hide')
                            }else{
                                $('.add_transcript_diploma').removeClass('hide')
                            }
                            showSwal('success', 'Successfully delete the data', false, true, 1500);
                        }
                    }
                });
        }

        function edit_data_transcript_diploma(el, id, index)
        {
            const modal = $("#add_transcript_diploma");
            var is_admin = $('#is_admin').val();
            var urlAjax = '<?php echo site_url('admin/returning/get_transcript_diploma') ?>/'+ id;
            if(!is_admin){
                urlAjax = '<?php echo site_url('grantee/submission/get_transcript_diploma') ?>/'+ id;
            }
            showSwal('loading', 'Please wait while we process your request.');
            $.ajax({
                type: 'GET',
                url: urlAjax,
                dataType: 'JSON',
                success: function(r) {
                    Swal.close(); 
                    modal.modal('show');  
                    $('#type').val(r.data.type)
                    $('#transcript_diploma_id').val(r.data.id)
                    $('.index_transcript_diploma').val(index)

                    if(r.data.file != null){
                        $('.file_transcript_diploma').prop('required', false);
                        $('#file-name-transcript_diploma').html(`<a href="${SITE_URL + r.data.file}" target="_blank">${r.data.filename}</a>`);
                    }else{
                        $('.file_transcript_diploma').prop('required', true);
                        $('#file-name-transcript_diploma ').html('');
                    }
                    // $('#status_transcript_diploma').val(r.data.status)
                }
            });

        }

        $(document).on('click', '.add_transcript_diploma', function() {
            if ($('#transcript_diploma_list tr').length >= 2) {
                showSwal('warning', 'You can only add 2 Transcript/Diploma records.', false, true, 2000);
                e.preventDefault();
                return false;
            }

            $('#add_transcript_diploma').modal('show');
        })
    // ========================= END TRANSCRIP DIPLOMA REQUEST =============


    // VALIDATION GRANTEE SUBMIT
    function validate_all_input(tab) {

        $(".text-required").remove();
        var validated = true;

        // check for element input
        $("#" + tab).find("input.form-control,input.choosefile").each(function() {
            
            let invalid_values = [null, ''];
            let is_required = $(this).prop('required');
            if (invalid_values.includes($(this).val()) && is_required) {
                const parent = $(this).closest('div');
                const has_warning = parent.find('p.text-required');

                if (has_warning.length == 0) {
                    validated = false;

                    const warning = '<p class="text-required text-danger">This field is required</p>';
                    const hr = parent.find('hr').first();

                    if (hr.length) {
                        hr.before(warning);
                    } else {
                        parent.append(warning);
                    }
                }
            }
        });

        // check for radio input type (plain radio, not radio group)
        $("#" + tab).find('input[type="radio"]').each(function() {

            let is_required = $(this).prop('required');
            if (!is_required) {
                return;
            }

            const $group = $('input[type="radio"][name="' + $(this).attr('name') + '"]');
            const hasChecked = $group.is(':checked');

            const $container = $(this).closest('div');
            const has_warning = $container.find('p.text-required');

            if (!hasChecked) {
                if (has_warning.length == 0) {
                    validated = false;
                    $container.append('<p class="text-required text-danger">This field is required</p>');
                }
            } else {
                $container.find('p.text-required').remove();
            }
        });

        return validated;
    }
    
    var is_submit = false;
    $("#submit_returning").click(function(e) {
        e.preventDefault();
        
        is_submit = true;
        let first_invalid_tab = '';
        let valid = validate_all_input('upon_your_return');
        if (!valid && first_invalid_tab == '') {
            first_invalid_tab = 'upon_your_return';
        }

        if (first_invalid_tab != '') {
            validate_all_input(first_invalid_tab);
            Swal.fire({
                title: "Incomplete Input",
                text: "Kindly complete this section with the required details",
                icon: "warning",
                customClass: 'swal-custom'
            }).then(() => {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            });
            $('#collapseArrivalReport').collapse('show');
            return false;
        }
        
        $('#btn_value').val('save_upon_return')
        $('#btn_save_and_send').val(0)
        Swal.fire({
            title: "Are you sure you want to submit?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, submit",
            customClass: 'swal-custom'
            }).then((result) => {
				if (result.isConfirmed) {
					$('#form').submit();
				}
        });

    });
</script>