<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    const interview_appointment = $('#interview_appointment').val();
    const is_admin = <?= $is_admin && $this->session->userdata('role') != 'travel-booking-assistant' ? 1 : 0 ?>;
    const save_grantee = <?= (isset($visa_interview) && !empty($visa_interview->save_grantee)) ? 1 : 0 ?>;
    const user_grantee_id = $('#user_grantee_id').val();


    // END ELEMENT

    let isFirstLoad = true;
    function updateTravelArrangement() {
        const isChecked = $('#set_to_travel_arrangement').is(':checked');

        if (isFirstLoad) {
            const defaultEnable = <?= $visa_interview ? $visa_interview->enable_international_ticket : 1 ?> == 1;
            $('#enable_international_ticket').prop('checked', isChecked ? defaultEnable : false);
            isFirstLoad = false;
        } else {
            $('#enable_international_ticket').prop('checked', isChecked);
        }
    }

    $('#set_to_travel_arrangement').change(updateTravelArrangement);
    updateTravelArrangement();

    let isFirstLoadVisa = true;
    function updateVisaToogle() {
        const isChecked = $('#set_to_visa_interview').is(':checked');
        var grantee_grant_id = is_admin ? '<?= isset($grantee_grant_id) ? $grantee_grant_id : '' ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
        
        if (isFirstLoadVisa) {
            const defaultEnable = <?= $visa_interview ? $visa_interview->enable_visa_interview_appointment : 1 ?> == 1;
            // $('#enable_visa_interview_appointment').prop('checked', isChecked ? defaultEnable : false);
            isFirstLoadVisa = false;
        } else {
            $('#enable_visa_interview_appointment').prop('checked', isChecked);
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/departure/set_togle_view/set_to_visa_interview/') ?>' + (isChecked ? 1 : 0) + '/' + grantee_grant_id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        showSwal('success', 'Successfully changed', false, true, 1500);
                    }
                }
            });
        }
        
    }

    $('#set_to_visa_interview').change(updateVisaToogle);
    updateVisaToogle();
    
    let isFirstBankInfo = true;
    function updateBankInfo() {
        const isChecked = $('#set_to_pre_departure_allowance').is(':checked');
        
        if (isFirstBankInfo) {
            const defaultEnable = <?= $visa_interview ? $visa_interview->enable_bank_info : 1 ?> == 1;
            $('#enable_bank_info').prop('checked', defaultEnable ? defaultEnable : false);
            isFirstBankInfo = false;
        } else {
            $('#enable_bank_info').prop('checked', isChecked);
        }
    }

    $('#set_to_pre_departure_allowance').change(updateBankInfo);
    updateBankInfo();


    // END ELEMENT TOOGLE

    $(document).ready(function(){
        if (!is_admin) {
            $('.label-location').append(' <span class="text-danger required-star">*</span>');
        }
        $('.lightbox').topbox({
            effect: 'fade',
            keyboardNav: false
        });
        $(".select_show").trigger("change");
        $('#interview_location_add, #location').val(interview_appointment);

        $('#bank_info_id, #bank_info_id_returning').trigger('change')
        $('#number_of_dependent, #appointment_located, .point_of_contact, #have_dependent').trigger('change')
        $('#arrival_city_pre_academic').trigger('blur')

        $("#table-ds2019 tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                let $originals = tr.children();
                let $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function(event, ui) {
                updateOrderAfterDelete();
            }
        }).disableSelection();
    });

    function updateOrderAfterDelete() {
        let order = [];
        $("#table-ds2019 tbody tr").each(function(index) {
            order.push({ id: $(this).data("id"), order: index + 1 });
        });

        $.ajax({
            url: "<?= base_url('admin/departure/sort_ds2019') ?>",
            type: "POST",
            data: { order: order },
            success: function(response) {
                console.log("Order updated", response);
                showSwal('success', 'Successfully updated data', false, true, 1500)
            },
            error: function(xhr, status, error) {
                showSwal('error', 'Failed to update data', false, true, 1500);
                console.log("Error: " + error);
            }
        });
                
        let sorted_ids = [];
        $("#table-ds2019 tbody").find('tr').each(function(index) {
            let row = $(this);
            let row_number = index + 1;
            row.find('td:first').text(row_number);
        });

    }

    const fieldShowDomesticTransportation = $('#show_transportation_domestic');
    const fieldShowDomesticAccomodation = $('#show_accomodation_domestic');
    let isFirstLoadDomesticTransport = true;
    let isFirstLoadAcommodationTransport = true;

    fieldShowDomesticTransportation.change(function(){
        if($(this).val() == 'No' || $(this).val() == ''){
            $('.section-transportation-domestic, .section-domestic').addClass('hide');
        }else{
            $('.section-transportation-domestic, .section-domestic').removeClass('hide');
        }

        if($(this).val() == 'Yes' || fieldShowDomesticAccomodation.val() == 'Yes' || $(this).val() == 'Reimbursement' || fieldShowDomesticAccomodation.val() == 'Reimbursement'){
            $('.section-domestic').removeClass('hide');
            
            const isChecked = $(this).val() == 'Yes' || $(this).val() == 'Reimbursement';
            if (isFirstLoadDomesticTransport) {
                const valueTransport = <?= $visa_interview ? ($visa_interview->show_transportation_domestic == '' ? 1 : $visa_interview->enable_transportation_domestic) : 1 ?>;
                $('#enable_transportation_domestic').prop('checked', isChecked ? valueTransport : false);
                isFirstLoadDomesticTransport = false;
            } else {
                $('#enable_transportation_domestic').prop('checked', isChecked);
            }
        }else{
            $('.section-domestic').addClass('hide');
            $('#enable_transportation_domestic').prop('checked', false);
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
            
            const isChecked = $(this).val() == 'Yes' || $(this).val() == 'Reimbursement';
            if (isFirstLoadAcommodationTransport) {
                const valueAccomodation = <?= $visa_interview ? ($visa_interview->show_accomodation_domestic == '' ? 1 : $visa_interview->enable_accommodation_domestic) : 1 ?>;
                $('#enable_accommodation_domestic').prop('checked', isChecked ? valueAccomodation : false);
                isFirstLoadAcommodationTransport = false;
            } else {
                $('#enable_accommodation_domestic').prop('checked', isChecked);
            }
        }else{
            $('.section-domestic').addClass('hide');
            $('#enable_accommodation_domestic').prop('checked', false);
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

    const fieldShowTransportation = $('#show_transportation');
    const fieldShowAccomodation = $('#show_accomodation');

    fieldShowTransportation.change(function(){
        if($(this).val() == 'No' || $(this).val() == ''){
            $('.section-transportation, .section-reminder').addClass('hide');
        }else{
            $('.section-transportation, .section-reminder').removeClass('hide');
        }

        if($(this).val() == 'Yes' || fieldShowAccomodation.val() == 'Yes' || $(this).val() == 'Reimbursement' || fieldShowAccomodation.val() == 'Reimbursement'){
            $('.section-reminder').removeClass('hide');
        }else{
            $('.section-reminder').addClass('hide');
        }

        if($(this).val() == 'Reimbursement'){
            $('#label_eticket').html('Receipt')
        }else{
            $('#label_eticket').html('E-Ticket')
        }

        // if(fieldShowAccomodation.val() == 'No'){
        //     $('.section-reminder').addClass('hide');
        // }
    })

    fieldShowAccomodation.change(function(){
        if($(this).val() == 'No' ||  $(this).val() == ''){
            $('.section-accomodation, .section-reminder').addClass('hide');
        }else{
            $('.section-accomodation, .section-reminder').removeClass('hide');
        }

        if($(this).val() == 'Yes' || fieldShowTransportation.val() == 'Yes' || $(this).val() == 'Reimbursement' || fieldShowTransportation.val() == 'Reimbursement'){
            $('.section-reminder').removeClass('hide');
        }else{
            $('.section-reminder').addClass('hide');
        }

        if($(this).val() == 'Reimbursement'){
            $('#label_voucher_hotel').html('Receipt')
        }else{
            $('#label_voucher_hotel').html('Hotel Voucher')
        }

        // if(fieldShowTransportation.val() == 'No'){
        //     $('.section-reminder').addClass('hide');
        // }
    })

    $(document).ready(function(){
        if(is_admin){
            if(fieldShowTransportation.val() == 'Yes' || fieldShowAccomodation.val() == 'Yes' || $(this).val() == 'Reimbursement' || fieldShowTransportation.val() == 'Reimbursement'){
                $('.section-reminder').removeClass('hide');
            }else{
                $('.section-reminder').addClass('hide');
            }
        }
    });

    // $('#together_with_dependent').change(function(){
    //     if($(this).val() != 'Yes'){
    //         $('.dependent-section').removeClass('hide');
    //     }else{
    //         $('.dependent-section').addClass('hide');
    //     }
    // })
    $('#obtaining_departur_document').change(function(){
        if($(this).val() != 'AMINEF Office'){
            $('.obtaining-section').removeClass('hide');
            if($('#appointment_date').val() == ''){
                $('#appointment_date').val($('#checkin_date_domestic').val())
            }
        }else{
            $('.obtaining-section').addClass('hide');
            $('#appointment_date').val('')
        }

        
    })
    $('#obtaining_departur_document_dependent').change(function(){
        if($(this).val() != 'AMINEF Office'){
            $('.obtaining-dependent-section').removeClass('hide');
            if($('#appointment_date_dependent').val() == ''){
                $('#appointment_date_dependent').val($('#checkin_date_domestic').val())
            }
        }else{
            $('.obtaining-dependent-section').addClass('hide');
            $('#appointment_date_dependent').val('')
        }
    })

    // $('#number_of_dependent').change(function(){
    //     if($(this).val() == '' || $(this).val() == '0'){
    //         $('.together_with_dependent').addClass('hide')
    //     }else{
    //         $('.together_with_dependent').removeClass('hide')
    //     }
        // if(!is_admin){
        //     if($(this).val() == '' || $(this).val() == '0'){
        //         $('.together_with_dependent').addClass('hide')
        //     }else{
        //         $('.together_with_dependent').removeClass('hide')
        //     }
        // }else{
        //     $('.together_with_dependent').removeClass('hide')
        // }
    // })

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

    $('#bank_info_id_returning').change(function(){
        var id = $(this).val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/bank_info') ?>/'+ id,
            dataType: 'JSON',
            success: function(r) {
                if(r){
                    $('#bank_name_returning').val(r.bank_name)
                    $('#bank_address_returning').val(r.bank_address)
                    $('#beneficiary_name_returning').val(r.beneficiary_name)
                    $('#account_number_returning').val(r.account_number)
                    $('#routing_number_returning').val(r.routing_number)
                    $('#swift_code_returning').val(r.swift_code)
                    $('#currency_returning').val(r.currency)
                    if(r.account_book){
                        var url = '<?= base_url(); ?>' + r.account_book;
                        var previewImage = r.preview_image;
                        $('.aimage_returning, #preview_image_account_book_returning, #button_download_account_book_returning, #button_preview_account_book_returning').removeClass('hide').attr('src', previewImage).attr('href', url);
                    }else{
                        $('.aimage_returning, #preview_image_account_book_returning, #button_download_account_book_returning, #button_preview_account_book_returning').addClass('hide');
                    }
                }else{
                    $('#bank_name_returning').val('')
                    $('#bank_address_returning').val('')
                    $('#beneficiary_name_returning').val('')
                    $('#account_number_returning').val('')
                    $('#routing_number_returning').val('')
                    $('#swift_code_returning').val('')
                    $('#currency_returning').val('')
                    $('.aimage_returning, #preview_image_account_book_returning, #button_download_account_book_returning, #button_preview_account_book_returning').addClass('hide')
                }
            }
        });
    })

    $('#support_letter').change(function(){
        var value = $(this).val();
        if(value == 'Yes'){
            $('#section-yes').removeClass('hide');
            $('.section-add-new').removeClass('hide');
            $('#no-support-letter').addClass('hide');
        }else if(value == 'No'){
            $('#section-yes').addClass('hide');
            $('#no-support-letter').removeClass('hide');
            $('.section-add-new').addClass('hide');
        }else{
            $('#section-yes').addClass('hide');
            $('#no-support-letter').addClass('hide');
            $('.section-add-new').addClass('hide');
        }
    });

    $('.upload_departure').click(function(){
        var title = $(this).data('section');
        var getclass = $(this).data('getclass');
        
        $('#modalTitle, #labelTitle').text(title);
        $('#getclass').val(getclass);
    });

    $('.add_deadline_departure_item, .add_deadline_departure_item_passport').click(function(){
        var id = $(this).data('id');
        var type = $(this).data('type')
        $('#deadline_medical_id').val(id);
        $('#deadline_medical_type').val(type);
        if(type == 'passport'){
            $('#modalTitleDeadline').text('Add Deadline Date Passport')
            $('#labelTitleDeadline').text('Deadline Date Passport')
        }else{
            $('#modalTitleDeadline').text('Add Deadline Date Medical Form')
            $('#labelTitleDeadline').text('Deadline date Medical Form')
        }
    });


    
    $("#btn-upload-departure").click(function(){
        var fd = new FormData();
        var files = $('#upload_to_grantee_file')[0].files;
        var id = $('#departure_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        var getclass = $('#getclass').val();
        $('#btn-upload-departure').prop('disabled', true)
        let currentTd = $('.' + getclass).closest("td");

        var fileId = '';
        var deleteBtn = '';
        if(getclass == 'upload_medical_departure'){
            fileId = $('#medical_departure_id').val();
            deleteBtn = 'medical';
        }else{
            fileId = $('#passport_departure_id').val();
            deleteBtn = 'passport';
        }


        // Check file selected or not
        if(files.length > 0 ){
            fd.append('file',files[0]);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('id',id);
            fd.append('document',getclass);
            fd.append('file_id',fileId);
            $.ajax({
                url: '<?php echo site_url('grantee/submission/upload_data_departure') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('.delete_file_'+deleteBtn).remove()
                    // currentTd.append(response.html)
                    currentTd.prev("td").text(response.created_date);
                    currentTd.prev("td").prev("td").text('');
                    currentTd.prev("td").prev("td").text(response.status);
                    currentTd.prev("td").prev("td").prev("td").text('')
                    currentTd.prev("td").prev("td").prev("td").append(response.filename);
                    $('#btn-upload-departure').prop('disabled', false);
                    $('#upload_to_grantee_file').val('');
                    $("#upload_departure").modal('hide');   
                    $('.lightbox').topbox();
                    $('#departure_id').val(response.departure_id);
                    if(getclass == 'upload_medical_departure'){
                        fileId = $('#medical_departure_id').val(response.file_id);
                    }else{
                        fileId = $('#passport_departure_id').val(response.file_id);
                    }
                    showSwal('success', 'Successfully upload the file', false, true, 1500)
                    // Swal.fire({
                    //     icon: "success",
                    //     title: "Successfully upload the file",
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // });
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-upload-departure').prop('disabled', false);
        }
    });

    $("#btn-upload-support-letter").click(function(){
        var fd = new FormData();
        var files = $('#upload_letter_for_supervisor_file')[0].files;
        var id = $('#departure_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        $('#btn-upload-support-letter').prop('disabled', true)
        let currentTd = $('.upload_letter_for_supervisor').closest("td");


        // Check file selected or not
        if(files.length > 0 ){
            fd.append('file',files[0]);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('id',id);
            $.ajax({
                // url: '<?php echo site_url('grantee/submission/upload_support_letter_departure') ?>',
                url: '<?php echo site_url('admin/departure/upload_support_letter_departure') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    // currentTd.append(response.html)
                    currentTd.prev("td").text(response.created_date);
                    currentTd.prev("td").prev("td").text('');
                    currentTd.prev("td").prev("td").append(response.ext);
                    currentTd.prev("td").prev("td").prev("td").text('');
                    currentTd.prev("td").prev("td").prev("td").append(response.filename);
                    $('#btn-upload-support-letter').prop('disabled', false);
                    $('#upload_letter_for_supervisor_file').val('');
                    $("#upload_letter_for_supervisor").modal('hide');   
                    $('.lightbox').topbox();
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-upload-support-letter').prop('disabled', false);
        }
    });


    function add_new() {
        var idx = $('.support-letter-item').length;
        $('.add-load').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/add_new_support_letter') ?>/' + idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-yes-support-letter').append(html);
                $('.select2').select2({
                    theme: 'bootstrap'
                });
                $('.add-load').hide();
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "d M Y",
                    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
            }
        });
    }

    function del_item_support_letter(el, item_class, support_id) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
        var delete_field = $("#delete_support_letter").val(); 
        if (delete_field == '') {
            $("#delete_support_letter").val(support_id);
        } else {
            $("#delete_support_letter").val(delete_field + "," + support_id);
        }
    }

    function delete_file_departure(el, field, id) {
        if (confirm("Are you sure want to delete this ?"))
            var currentTd = $('.delete_file_'+field).closest("td");
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('grantee/submission/delete_file') ?>/'+ id + '/' + field,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        currentTd.prev("td").text('');
                        currentTd.prev("td").prev("td").text('');
                        currentTd.prev("td").prev("td").prev("td").text('');
                        $('.delete_file_'+field).remove()
                        showSwal('success', 'Successfully delete the file', false, true, 1500);
                    }
                }
            });
    }




    $(".modal-log-departure").click(function(e){
        var data_id = $(this).data('log')
        var type = $(this).data('type')
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/departure/get_log_departure') ?>',
            dataType: 'JSON',
            data:{
                id: data_id,
                table: type == 'medical' ? 'am_medical_departure' : 'am_passport_departure'
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
                        // value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
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

    $('#upload_to_grantee_file').on('change', function() {
        var file = this.files[0];
        if (file) {
            var fileType = file.type;
            if (fileType !== 'application/pdf') {
                showSwal('error', 'Only PDF files are allowed', false, true, 1500);
                $(this).val(''); // Menghapus file yang tidak valid
            }
        }
    });

    $('#appointment_located').on('change', function() {
        var value = $(this).val();
        if(value == 'Surabaya'){
            $('.section-obtaining').addClass('hide')
            // $('.toggle-pre-departure').removeClass('hide')
        }else{
            // $('.toggle-pre-departure').addClass('hide')
            $('.section-obtaining').removeClass('hide')
        }

        $('#location').val(value);
    });



    function update_status_file_departure(el, id, status, field) {
        if (confirm("Are you sure want to "+status+" this ?"))
            if(status == 'revise'){
                $('#mdl_note_revise').modal()
                $('#btn-save-note').attr("onclick","update_status_file_departure_action("+ id +", '"+ status +"', '"+ field +"')"); 
            }else{
                update_status_file_departure_action(id, status, field);
            }
    }

    function update_status_file_departure_action(id, status, field) {
        var note = $('#note_revise').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        var modal = $('#mdl_note_revise');
        var fileInput = modal.find('input[type="file"][name="temp_attachment_revise"]')[0] || modal.find('#temp_attachment_revise')[0];
        var btnSave = $('#btn-save-note');

        var doSave = function(attachment_revise) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/departure/update_status_file_departure') ?>',
                data: {
                    id: id,
                    status: status,
                    note: note,
                    field: field,
                    attachment_revise: attachment_revise,
                    grantee_grant_id: grantee_grant_id
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

    // DS160
    $("#form_ds160").on("submit", function (e) {
        e.preventDefault();

        if (this.checkValidity()) {
            var form = document.getElementById('form_ds160');
            var formData = new FormData(form);

            var index = $('.edit-ds160').length;
            var grantee_grant_id = $('#grantee_grant_id').val();
            var departure_id = $('#departure_id').val();
            formData.append('grantee_grant_id', grantee_grant_id);
            formData.append('departure_id', departure_id);
            formData.append('index', (index + 1));

            $('#btn-save-ds160').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/departure/add_ds160') ?>',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-save-ds160').prop('disabled', false);
                    $('.fields_ds160').val('');
                    $("#form_add_ds160").modal('hide');   
                    $('#list_ds160').append(response.html);
                    $('#list_appointment').append(response.html_appointment);
                    $('#list_required_doc').append(response.html_required);
                    $('#list_ds2019sign_visapage').append(response.html_sign);
                    $('#departure_id').val(response.departure_id);
                    showSwal('success', 'Successfully add the data', false, true, 1500);
                }
            });
        } else {
            alert("Please fill out all required fields correctly.");
        }
    });

    $("#edit_form_ds160").on("submit", function (e) {
        e.preventDefault();

        if (this.checkValidity()) {
            var form = document.getElementById('edit_form_ds160');
            var formData = new FormData(form);

            var grantee_grant_id = $('#grantee_grant_id').val();
            var departure_id = $('#departure_id').val();
            formData.append('grantee_grant_id', grantee_grant_id);
            formData.append('departure_id', departure_id);

            $('#btn-edit-ds160').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/departure/add_ds160') ?>',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-edit-ds160').prop('disabled', false);
                    $('.fields_ds160').val('');
                    $("#form_edit_ds160").modal('hide');   
                    $('#index-'+response.index+ ' td').remove();
                    $('#index-'+response.index).append(response.html);
                    $('#index-appointment-'+response.index).find('td:nth-child(2)').text(response.post.first_name);
                    $('#index-appointment-'+response.index).find('td:nth-child(3)').text(response.post.last_name);
                    $('#index-appointment-'+response.index).find('td:nth-child(11)').text(response.post.sevis_id);
                    $('#index-appointment-'+response.index).find('td:nth-child(12)').text(response.post.interview_location);
                    $('#index-appointment-'+response.index).find('td:nth-child(13)').text(response.post.propose_date ? formatDate(response.post.propose_date) : '');
                    $('#index-required-'+response.index).find('td:nth-child(2)').text(response.post.first_name);
                    $('#index-required-'+response.index).find('td:nth-child(3)').text(response.post.last_name);
                    $('#index-sign-'+response.index).find('td:nth-child(2)').text(response.post.first_name);
                    $('#index-sign-'+response.index).find('td:nth-child(3)').text(response.post.last_name);
                    
                    $("#list_ds160 tr td:nth-child(5)").text(response.post.program_number);
                    $("#list_ds160 tr td:nth-child(6)").text(response.post.start_date ? formatDate(response.post.start_date) : '');
                    $("#list_ds160 tr td:nth-child(7)").text(response.post.end_date ? formatDate(response.post.end_date) : '');
                    showSwal('success', 'Successfully edit the data', false, true, 1500);
                }
            });
        } else {
            alert("Please fill out all required fields correctly.");
        }
    });

    // $("#btn-save-ds160").on("submit", )(function() {
    //     var form = document.getElementById('form_ds160');
    //     var formData = new FormData(form);

    //     var index = $('.edit-ds160').length;
    //     var grantee_grant_id = $('#grantee_grant_id').val();
    //     var departure_id = $('#departure_id').val();
    //     formData.append('grantee_grant_id', grantee_grant_id);
    //     formData.append('departure_id', departure_id);
    //     formData.append('index', (index + 1));

    //     $('#btn-save-ds160').prop('disabled', true);
    //     $.ajax({
    //         type: 'POST',
    //         url: '<?php echo site_url('admin/departure/add_ds160') ?>',
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function(response){
    //             console.log(response)
    //             $('#btn-save-ds160').prop('disabled', false);
    //             $('.fields_ds160').val('');
    //             $("#form_add_ds160").modal('hide');   
    //             $('#list_ds160').append(response.html);
    //             $('#departure_id').val(response.departure_id);
    //             showSwal('success', 'Successfully add the data', false, true, 1500);
    //         }
    //     });
    // })

    // $("#btn-edit-ds160").click(function() {
    //     var form = document.getElementById('edit_form_ds160');
    //     var formData = new FormData(form);

    //     var grantee_grant_id = $('#grantee_grant_id').val();
    //     var departure_id = $('#departure_id').val();
    //     formData.append('grantee_grant_id', grantee_grant_id);
    //     formData.append('departure_id', departure_id);

    //     $('#btn-edit-ds160').prop('disabled', true);
    //     $.ajax({
    //         type: 'POST',
    //         url: '<?php echo site_url('admin/departure/add_ds160') ?>',
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function(response){
    //             $('#btn-edit-ds160').prop('disabled', false);
    //             $('.fields_ds160').val('');
    //             $("#form_edit_ds160").modal('hide');   
    //             $('#index-'+response.index+ ' td').remove();
    //             $('#index-'+response.index).append(response.html);
    //             showSwal('success', 'Successfully edit the data', false, true, 1500);
    //         }
    //     });
    // })

    function del_data_ds160(el, id, index) {
        if (confirm("Are you sure want to delete this ?"))
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/departure/delete_ds160') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                        $('#index-appointment-'+index+ ' td').remove();
                        $('#index-required-'+index+ ' td').remove();
                        $('#index-sign-'+index+ ' td').remove();
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
    }

    function edit_data_ds160(el, id, index)
    {

        if(index == 1){
            $('#program_number, #start_date, #end_date').prop('readonly', true).datepicker('destroy');
            $('#program_number, #start_date, #end_date').prop('readonly', false);
            $('#program_number, #start_date, #end_date, #propose_date').prop('readonly', true).css('background-color', '#fff');
        }else{
            $('#program_number, #start_date, #end_date').prop('readonly', true).datepicker('destroy');
            $('#program_number, #start_date, #end_date').prop('readonly', true).css('background-color', '#eee');
            $('#propose_date').prop('readonly', true).css('background-color', '#fff');
        }
        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "mm/dd/y",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
        showSwal('loading', 'Please wait while we process your request.');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/departure/get_ds160') ?>/'+ id,
            dataType: 'JSON',
            success: function(r) {
                Swal.close(); 
                $("#form_edit_ds160").modal('show');  
                $('#ds160_id').val(r.data.id)
                $('#index').val(index)
                $('#first_name').val(r.data.first_name)
                $('#last_name').val(r.data.last_name)
                $('#program_number').val(r.data.program_number)
                $('#sevis_id').val(r.data.sevis_id)
                $('#interview_location').val(r.data.interview_location)
                $('#propose_date').val(r.data.propose_date ? formatDate(r.data.propose_date) : '')
                $('#start_date').val(r.data.start_date ? formatDate(r.data.start_date) : '')
                $('#end_date').val(r.data.end_date ? formatDate(r.data.end_date) : '')
                let dontHave = (r.data.dont_have_first_name == 1);
                if(dontHave){
                    $('#dont_have_first_nameds160')
                        .prop('checked', dontHave)
                        .trigger('change');
                }else{
                    $('#dont_have_first_nameds160')
                        .prop('checked', dontHave)
                        .trigger('change');
                    $('#first_name').val(r.data.first_name)
                }
            }
        });

    }
    // END DS160



    // APPOINTMENT

    $("#form_appointment").on("submit", function (e) {
        e.preventDefault();

        if (this.checkValidity()) {
            var form = document.getElementById('form_appointment');
            var formData = new FormData(form);
            var is_admin = $(this).data('is_admin');
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/departure/add_appointment') ?>';
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/add_appointment') ?>';
            }

            var index = $('.edit-appointment').length;
            var grantee_grant_id = $('#grantee_grant_id').val();
            var departure_id = $('#departure_id').val();
            formData.append('grantee_grant_id', grantee_grant_id);
            formData.append('departure_id', departure_id);
            formData.append('index', (index + 1));

            $('#btn-save-appointment').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: urlAjax,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response)
                    $('#btn-save-appointment').prop('disabled', false);
                    $('.fields_appointment').val('');
                    $("#form_add_appointment").modal('hide');   
                    $('#list_appointment').append(response.html);
                    $('#departure_id').val(response.departure_id);
                    showSwal('success', 'Successfully add the data', false, true, 1500);
                }
            });
        } else {
            alert("Please fill out all required fields correctly.");
        }
    });

    $("#edit_form_appointment").on("submit", function (e) {
        e.preventDefault();

        if (this.checkValidity()) {
            var form = document.getElementById('edit_form_appointment');
            var formData = new FormData(form);
            var is_admin = $('#btn-edit-appointment').data('is_admin');
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/departure/add_appointment') ?>';
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/add_appointment') ?>';
            }

            var grantee_grant_id = $('#grantee_grant_id').val();
            var departure_id = $('#departure_id').val();
            formData.append('grantee_grant_id', grantee_grant_id);
            formData.append('departure_id', departure_id);
            formData.append('is_admin', is_admin);

            $('#btn-edit-appointment').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: urlAjax,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-edit-appointment').prop('disabled', false);
                    $('.fields_appointment').val('');
                    $("#form_edit_appointment").modal('hide');   
                    $('#index-appointment-'+response.index+ ' td').remove();
                    $('#index-appointment-'+response.index).append(response.html);
                    $('#deadlinedate').val(response.deadline_date);
                    showSwal('success', 'Successfully edit the data', false, true, 1500);
                }
            });
        } else {
            alert("Please fill out all required fields correctly.");
        }
    });

    // $("#btn-save-appointment").click(function() {
    //     var form = document.getElementById('form_appointment');
    //     var formData = new FormData(form);
    //     var is_admin = $(this).data('is_admin');
    //     if(is_admin){
    //         var urlAjax = '<?php echo site_url('admin/departure/add_appointment') ?>';
    //     }else{
    //         var urlAjax = '<?php echo site_url('grantee/submission/add_appointment') ?>';
    //     }

    //     var index = $('.edit-appointment').length;
    //     var grantee_grant_id = $('#grantee_grant_id').val();
    //     var departure_id = $('#departure_id').val();
    //     formData.append('grantee_grant_id', grantee_grant_id);
    //     formData.append('departure_id', departure_id);
    //     formData.append('index', (index + 1));

    //     $('#btn-save-appointment').prop('disabled', true);
    //     $.ajax({
    //         type: 'POST',
    //         url: urlAjax,
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function(response){
    //             console.log(response)
    //             $('#btn-save-appointment').prop('disabled', false);
    //             $('.fields_appointment').val('');
    //             $("#form_add_appointment").modal('hide');   
    //             $('#list_appointment').append(response.html);
    //             $('#departure_id').val(response.departure_id);
    //             showSwal('success', 'Successfully add the data', false, true, 1500);
    //         }
    //     });
    // })

    // $("#btn-edit-appointment").click(function() {
    //     var form = document.getElementById('edit_form_appointment');
    //     var formData = new FormData(form);
    //     var is_admin = $(this).data('is_admin');
    //     if(is_admin){
    //         var urlAjax = '<?php echo site_url('admin/departure/add_appointment') ?>';
    //     }else{
    //         var urlAjax = '<?php echo site_url('grantee/submission/add_appointment') ?>';
    //     }

    //     var grantee_grant_id = $('#grantee_grant_id').val();
    //     var departure_id = $('#departure_id').val();
    //     formData.append('grantee_grant_id', grantee_grant_id);
    //     formData.append('departure_id', departure_id);
    //     formData.append('is_admin', is_admin);

    //     $('#btn-edit-appointment').prop('disabled', true);
    //     $.ajax({
    //         type: 'POST',
    //         url: urlAjax,
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function(response){
    //             $('#btn-edit-appointment').prop('disabled', false);
    //             $('.fields_appointment').val('');
    //             $("#form_edit_appointment").modal('hide');   
    //             $('#index-appointment-'+response.index+ ' td').remove();
    //             $('#index-appointment-'+response.index).append(response.html);
    //             showSwal('success', 'Successfully edit the data', false, true, 1500);
    //         }
    //     });
    // })

    function del_data_appointment(el, id, is_admin) {
        if (confirm("Are you sure want to delete this ?"))
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/departure/delete_appointment/') ?>';
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/delete_appointment/') ?>';
            }
            $.ajax({
                type: 'GET',
                url: urlAjax + id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
    }

    function edit_data_appointment(el, id, index, is_admin)
    {
        showSwal('loading', 'Please wait while we process your request.');
        let deadlineDate = $('#deadlinedate').val();
        if(is_admin){
            var urlAjax = '<?php echo site_url('admin/departure/get_appointment/') ?>';
        }else{
            var urlAjax = '<?php echo site_url('grantee/submission/get_appointment/') ?>';
        }
        $.ajax({
            type: 'GET',
            url: urlAjax + id,
            dataType: 'JSON',
            success: function(r) {
                Swal.close(); 
                $("#form_edit_appointment").modal('show');  
                $('#appointment_id').val(r.data.id)
                $('#index_appointment').val(index)
                $('#first_name_appointment').val(r.data.first_name ?? 'FNU')
                $('#last_name_appointment').val(r.data.last_name)
                $('#deadline').val(deadlineDate ? formatDate(deadlineDate) : '')
                $('#date_of_birth').val(r.data.date_of_birth ? formatDate(r.data.date_of_birth) : '')
                $('#passport').val(r.data.passport)
                $('#passport_type').val(r.data.passport_type)
                $('#nationality').val(r.data.nationality)
                $('#visa_type').val(r.data.visa_type)
                $('#email_app').val(r.data.email)
                $('#ds160').val(r.data.ds160)
                $('#sevis_id_app').val(r.data.sevis_id)
                $('#interview_location_app_select').val(r.data.interview_location)
                $('#interview_location_app_input').val(r.data.interview_location)
                $('#propose_date_app').val(r.data.propose_date ? formatDate(r.data.propose_date) : '')
                $('#travel_plan_app').val(r.data.travel_plan ? formatDate(r.data.travel_plan) : '')
                $('#telephone_app').val(r.data.telephone)
            }
        });

    }
    // END APPOINTMENT


    function formatDate(dateStr) {
        // const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
        // let date = new Date(dateStr);
        // let day = date.getDate();
        // let month = monthNames[date.getMonth()];
        // let year = date.getFullYear();
        // return `${day} ${month} ${year}`;
        let date = new Date(dateStr);
        let day = String(date.getDate()).padStart(2, '0');     // 01 - 31
        let month = String(date.getMonth() + 1).padStart(2, '0'); // 01 - 12
        let year = String(date.getFullYear()).slice(-2);  
        return `${month}/${day}/${year}`;
    }


    $(document).on('click', '.upload-button', function() {
    // $(".upload-button").click(function() {
        var data_value = $(this).data('file-value');
        var currentRow = $(this).closest('tr');
        $('.' + data_value).click();
        $('.' + data_value).off('change').on('change', function(e){
            var table_save = $(this).data('table_save');
            var doc_type = $(this).data('doc');
            var is_admin = $(this).data('is_admin') ? 1 : 0;
            var data_default = $(this).data('default') == undefined ? 0 : 1;
            var data_id = $(this).data('id') == undefined ? '' : $(this).data('id');
            var file = e.target.files[0];
            var grantee_grant_id = $('#grantee_grant_id').val();
            var departure_id = $('#departure_id').val();
            let currentTd = $('.btn-' + doc_type + '-' + data_id).closest("td");
            var id = 1;
            var function_name = table_save == 'save_ds2019_sign' ? 'save_ds2019_sign' : 'save_required_document';
            if(is_admin){
                var urlAjax = "<?= base_url(); ?>admin/departure/" + function_name;
            }else{
                var urlAjax = "<?= base_url(); ?>grantee/submission/" + function_name
            }
            showSwal('loading', 'Please wait while we process your request.');
    
    
            var formData = new FormData();
            formData.append("file", e.target.files[0]);
            formData.append("doc_type", doc_type);
            formData.append("data_id", data_id);
            formData.append("default", data_default);
            formData.append("grantee_grant_id", grantee_grant_id);
            formData.append("departure_id", departure_id);
            formData.append("table_save", table_save);
            formData.append("is_admin", is_admin);
            $.ajax({
                url: urlAjax,
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                contentType: false, // Using FormData, no need to process data.
                dataType: 'JSON'
            }).done(function(r) {
                if(r.success){
                    currentTd.html('');
                    $('.btn-del-req-'+doc_type).remove();
                    $('.upload_require_doc_'+doc_type+'_'+data_id).remove();
                    $('.btn-'+doc_type+'-'+data_id).remove();
                    currentTd.append(r.filename)
                    currentTd.append(r.download)
                    currentTd.append(r.upload)
                    currentTd.append(r.input)
                    currentTd.append(r.delete)
                    // currentTd.prev("td").text('');
                    // currentTd.prev("td").append(r.filename); 
                    $('.lightbox').topbox();
                    if(r.complete){
                        currentRow.find('.hide-complete').addClass('hide');
                    }else{
                        currentRow.find('.hide-complete').removeClass('hide');
                    }
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                }
            })
            .fail(function() {
                showSwal('error', 'Failed to upload the file', false, true, 1500);
            });
    
            $(this).val('');
        });
    })


    $(".upload-ds2019").click(function() {
        var data_value = $(this).data('file-value');
        $('.' + data_value).click();
        $('.' + data_value).change(function(e){
            var doc_type = 'ds2019';
            var file = e.target.files[0];
            var grantee_grant_id = $('#grantee_grant_id').val();
            var departure_id = $('#departure_id').val();
            let currentTd = $('.btn-' + doc_type).closest("td");
            var id = 1;
            showSwal('loading', 'Please wait while we process your request.');
    
    
            var formData = new FormData();
            formData.append("file", e.target.files[0]);
            formData.append("doc_type", doc_type);
            formData.append("grantee_grant_id", grantee_grant_id);
            formData.append("departure_id", departure_id);
            $.ajax({
                url: "<?= base_url(); ?>admin/departure/save_required_document",
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                dataType: 'JSON',
                contentType: false // Using FormData, no need to process data.
            }).done(function(r) {
                if(r.success){
                    $('.lightbox').topbox();
                    $('.delete-ds2019').removeClass('hide');
                    $('.fileview-ds2019').removeClass('hide').attr('href', r.file);
                    $('#departure_id').val(r.departure_id);
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                }
            })
            .fail(function() {
                showSwal('error', 'Failed to upload the file', false, true, 1500);
            });
    
            $(this).val('');
    
    
            console.log(file)
        });
    })

    $(".upload-lfs").click(function() {
        var data_value = $(this).data('file-value');
        $('.' + data_value).click();
        $('.' + data_value).change(function(e){
            var file = e.target.files[0];
            var grantee_grant_id = $('#grantee_grant_id').val();
            var departure_id = $('#departure_id').val();
            showSwal('loading', 'Please wait while we process your request.');
    
    
            var formData = new FormData();
            formData.append("file", e.target.files[0]);
            formData.append("grantee_grant_id", grantee_grant_id);
            formData.append("departure_id", departure_id);
            formData.append("user_grantee_id", user_grantee_id);
            $.ajax({
                url: "<?= base_url(); ?>admin/departure/save_lfs",
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                dataType: 'JSON',
                contentType: false // Using FormData, no need to process data.
            }).done(function(r) {
                
                if(r.success){
                    $('.lightbox').topbox();
                    $('.delete-lfs').removeClass('hide');
                    $('.fileview-lfs').removeClass('hide').attr('href', r.file);
                    $('#departure_id').val(r.departure_id);
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                }else{
                    showSwal('error', r.message, false, true, 2000);
                }
            })
            .fail(function() {
                showSwal('error', 'Failed to upload the file', false, true, 1500);
            });
    
            $(this).val('');
        });
    })

    function show_preview(element, filetype = '') {
        const file = element.files[0];
        var fileSize = file.size;
        var maxSize = 5 * 1024 * 1024;
        if (file) {
            let reader = new FileReader();
            let filename = file.name;
            let ext = filename.split('.').pop();
            let pdf_icon = '<?php echo base_url('assets/images/icons/pdf.svg'); ?>';
            let download_icon = '<?php echo base_url('assets/images/icons/download icon.png'); ?>';
            reader.onload = function(event) {
                if(fileSize < maxSize){
                    if (ext == 'jpg' || ext == 'png' || ext == 'jpeg') {
                        $('#preview_image' + filetype).attr('src', event.target.result);
                        $('#preview_image' + filetype).attr('height', 100);
                        $('#preview_image' + filetype).css('margin-top', "-5px");
                    } else if (ext == 'pdf') {
                        $('#preview_image' + filetype).attr('src', pdf_icon);
                    } else {
                        $('#preview_image' + filetype).attr('src', download_icon);
                    }
                }else{
                    $(element).val(''); // Hapus file yang dipilih
                }

            }

            reader.readAsDataURL(file);
        }
    }

    function del_data_required(el, id, doc, fucntion_name, is_admin)
    {
        if (confirm("Are you sure want to delete this ?")){
            let currentTd = $(el).closest("td");
            showSwal('loading', 'Please wait while we process your request.');
            if(is_admin){
                var urlAjax = "<?= base_url(); ?>admin/departure/" + fucntion_name + '/' + id + '/' + doc
            }else{
                var urlAjax = "<?= base_url(); ?>grantee/submission/" + fucntion_name + '/' + id + '/' + doc
            }
            $.ajax({
                type: 'GET',
                url: urlAjax,
                dataType: 'JSON',
                success: function(r) {
                    Swal.close(); 
                    $(el).remove();
                    currentTd.find('.btn-view-req-'+doc).remove();
                    currentTd.find('.btn-download-req-'+doc).remove();
                    // currentTd.prev("td").text('');
                }
            });
        }
    }

    $("#btn-upload-required-doc").click(function(){
        var fd = new FormData();
        var file_passport = $('#upload_file_passport')[0].files;
        var file_photo= $('#upload_file_photo')[0].files;
        var grantee_grant_id = $('#grantee_grant_id').val();
        var departure_id = $('#departure_id').val();

        // Check file selected or not
        if(file_passport.length > 0 && file_photo.length > 0){
            fd.append('file_passport',file_passport[0]);
            fd.append('file_photo',file_photo[0]);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('departure_id',departure_id);
            $.ajax({
                url: '<?php echo site_url('admin/departure/upload_data_required') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#upload_file_photo').val('');
                    $('#upload_file_passport').val('');
                    $("#form_require_doc").modal('hide');   
                    $('#departure_id').val(response.departure_id);
                    $('#list_required_doc').append(response.html);
                    $('.lightbox').topbox();
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-upload-required-doc').prop('disabled', false);
        }
    });

    function del_data_required_doc(el, id) {
        if (confirm("Are you sure want to delete this ?"))
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/departure/delete_data_required') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
    }

    function delete_lfs(el) {
        if (confirm("Are you sure want to delete this ?")){
            var grantee_grant_id = $('#grantee_grant_id').val();
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/departure/delete_lfs') ?>/'+ grantee_grant_id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $('.delete-lfs').addClass('hide');
                        $('.fileview-lfs').addClass('hide');
                        $('#preview_image_lfs').attr('src', '<?= site_url('assets/images/icons/add-file.png')?>');
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
        }

    }

    function delete_file_visa(el, field, is_admin) {
        if (confirm("Are you sure want to delete this ?")){
            var grantee_grant_id = $('#grantee_grant_id').val();
        if(is_admin){
            var urlAjax = '<?php echo site_url('admin/departure/delete_file_visa') ?>/'+ grantee_grant_id + '/' + field;
        }else{
            var urlAjax = '<?php echo site_url('grantee/submission/delete_file_visa') ?>/'+ grantee_grant_id + '/' + field;
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

    $("#btn-upload-medical").click(function(){
        var fd = new FormData();
        var files = $('#upload_medical_file')[0].files;
        var departure_id = $('#departure_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        var deadline_date = $('#upload_medical_deadline_date').val();
        $('#btn-upload-medical').prop('disabled', true);


        // Check file selected or not
        if(files.length > 0 && deadline_date != ''){
            fd.append('file',files[0]);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('departure_id',departure_id);
            fd.append("deadline_date", deadline_date);
            fd.append("user_grantee_id", user_grantee_id);
            $.ajax({
                url: '<?php echo site_url('admin/departure/add_file_medical') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response.success){
                        $('#btn-upload-medical').prop('disabled', false);
                        $('#upload_medical_file').val('');
                        $("#upload_medical").modal('hide');   
                        $('#medical_list').append(response.html);
                        $('#departure_id').val(response.departure_id);
                        $('.lightbox').topbox();
                        $('#upload_medical_deadline_date').val('');
                        showSwal('success', 'Successfully upload the file', false, true, 1500);
                    }else{
                        $('#btn-upload-medical').prop('disabled', false);
                        showSwal('error', response.message, false, true, 2000);
                    }
                },
            });
        }else{
            if(files.length == 0){
                alert("Please select a file.");
            } else if(deadline_date == '') {
                alert("Deadline is not null.");
            }
            $('#btn-upload-medical').prop('disabled', false);
        }
    });

    $("#btn-upload-leave-approval").click(function(){
        var fd = new FormData();
        var files = $('#upload_leave_approval_file')[0].files;
        var departure_id = $('#departure_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        var is_admin = $(this).data('is_admin');
        if(is_admin){
            var urlAjax = '<?php echo site_url('admin/departure/add_file_leave_approval') ?>';
        }else{
            var urlAjax = '<?php echo site_url('grantee/submission/add_file_leave_approval') ?>';
        }
        $('#btn-upload-leave-approval').prop('disabled', true);


        // Check file selected or not
        if(files.length > 0 ){
            fd.append('file',files[0]);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('departure_id',departure_id);
            fd.append('is_admin',is_admin);
            $.ajax({
                url: urlAjax,
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response.success){
                        $('#btn-upload-leave-approval').prop('disabled', false);
                        $('#upload_leave_approval_file').val('');
                        $("#upload_leave_approval").modal('hide');   
                        $('#leave_approval_list').append(response.html);
                        $('#departure_id').val(response.departure_id);
                        $('.lightbox').topbox();
                        showSwal('success', 'Successfully upload the file', false, true, 1500)
                    }else{
                        showSwal('error', response.message, false, true, 2000);
                        $('#btn-upload-leave-approval').prop('disabled', false);
                    }
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-upload-leave-approval').prop('disabled', false);
        }
    });



    $("#btn-upload-ds2019").click(function(){
        var fd = new FormData();
        var files = $('#upload_ds2019_file')[0].files;
        var input_file = document.getElementById('upload_ds2019_file'); 
        var totalfiles = input_file.files.length;
        var departure_id = $('#departure_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        var is_admin = $(this).data('is_admin');
        var order = $('#table-ds2019 tbody tr').length + 1;
        if(is_admin){
            var urlAjax = '<?php echo site_url('admin/departure/add_ds2019') ?>';
        }else{
            var urlAjax = '<?php echo site_url('grantee/submission/add_ds2019') ?>';
        }
        $('#btn-upload-ds2019').prop('disabled', true);


        // validate dependent
        var numberofDependent = $('#number_of_dependent').val();
        if($('#have_dependent').val() == 'No'){
            numberofDependent = 0;
        }
        var countList = $("#ds2019_list tr").length - 1;
        var totalCountList = countList + totalfiles

        if(totalCountList > numberofDependent){
            $("#upload_ds2019").modal('hide');  
            $('#btn-upload-ds2019').prop('disabled', false);
            $('#upload_ds2019_file').val('');
            showSwal('error', 'The amount you entered exceeds the dependent value. Please adjust accordingly.', false, true, 2500);
            return false
        }


        // Check file selected or not
        if(totalfiles > 0 ){
            for (var i = 0; i < totalfiles; i++) {
                fd.append("file_"+i, input_file.files[i]);
            }
            // fd.append('file',files[0]);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('departure_id',departure_id);
            fd.append('is_admin',is_admin);
            fd.append('order',order);
            fd.append("user_grantee_id", user_grantee_id);
            $.ajax({
                url: urlAjax,
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-upload-ds2019').prop('disabled', false);
                    $('#upload_ds2019_file').val('');
                    $("#upload_ds2019").modal('hide');   
                    $('#ds2019_list').append(response.html);
                    $('#departure_id').val(response.departure_id);
                    $('.lightbox').topbox();
                    updateOrderAfterDelete();
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-upload-ds2019').prop('disabled', false);
        }
    });

    function del_data_medical(el, id) {
        if (confirm("Are you sure want to delete this ?")){
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/departure/delete_data_medical') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
        }

    }

    function del_data_leave_approval(el, id, is_admin) {
        if (confirm("Are you sure want to delete this ?")){
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/departure/delete_data_leave_approval/') ?>';
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/delete_data_leave_approval/') ?>';
            }
            $.ajax({
                type: 'GET',
                url: urlAjax + id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
        }

    }

    function del_data_ds2019(el, id, is_admin) {
        if (confirm("Are you sure want to delete this ?")){
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/departure/delete_data_ds2019/') ?>';
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/delete_data_ds2019/') ?>';
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

    $(".upload_departure_item").click(function() {
        var data_value = $(this).data('file-value');
        var departure_id = $('#departure_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        $('.' + data_value).click();
        $('.' + data_value).change(function(e){
            var medical_id = $(this).data('id');
            var file = e.target.files[0];
            let currentTd = $(this).closest("td");
            
            if (file) {
                var fileType = file.type;
                if (fileType !== 'application/pdf') {
                    showSwal('error', 'Only PDF files are allowed.', false, true, 1500);
                    $(this).val('');
                    return false
                }else{
                    showSwal('loading', 'Please wait while we process your request.');
            
            
                    var formData = new FormData();
                    formData.append("file", e.target.files[0]);
                    formData.append("medical_id", medical_id);
                    formData.append("departure_id", departure_id);
                    formData.append("grantee_grant_id", grantee_grant_id);
                    $.ajax({
                        url: "<?= base_url(); ?>grantee/submission/upload_medical",
                        type: 'POST',
                        data: formData, // The form with the file inputs.
                        processData: false,
                        dataType: 'JSON',
                        contentType: false // Using FormData, no need to process data.
                    }).done(function(r) {
                        // currentTd.append('ini')
                        if(r.success){
                            currentTd.prev("td").text('');
                            currentTd.prev("td").append(r.created_date); 
                            currentTd.prev("td").prev("td").text('');
                            currentTd.prev("td").prev("td").text(r.status);
                            currentTd.prev("td").prev("td").prev("td").text('')
                            currentTd.prev("td").prev("td").prev("td").append(r.filename);
                            $('.lightbox').topbox();
                            showSwal('success', 'Successfully upload the file', false, true, 1500);
                        }
                    })
                    .fail(function() {
                        showSwal('error', 'Failed to upload the file', false, true, 1500);
                    });
            
                    $(this).val('');

                }
            }
        });
    })

    $("#btn-add-deadline-medical").click(function() {
        var departure_id = $('#departure_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        var medical_id = $('#deadline_medical_id').val();
        var deadline_date = $('#deadline_date_medical').val();
        var type = $('#deadline_medical_type').val();
        let currentTd = type == 'passport' ? $('.add_deadline_departure_item_passport').closest("td") : $('.add_deadline_departure_item').closest("td");

        if(deadline_date){
            showSwal('loading', 'Please wait while we process your request.');
            var formData = new FormData();
            formData.append("medical_id", medical_id);
            formData.append("departure_id", departure_id);
            formData.append("grantee_grant_id", grantee_grant_id);
            formData.append("deadline_date", deadline_date);
            formData.append("type", type);
            $.ajax({
                url: "<?= base_url(); ?>admin/departure/add_deadline_date_medical",
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                dataType: 'JSON',
                contentType: false // Using FormData, no need to process data.
            }).done(function(r) {
                // currentTd.append('ini')
                // currentTd.prev("td").text('');
                // currentTd.prev("td").append(r.created_date); 
                // currentTd.prev("td").prev("td").text('');
                // currentTd.prev("td").prev("td").text(r.status);
                // currentTd.prev("td").prev("td").prev("td").text('')
                if(r.success){
                    $('#departure_id').val(r.departure_id);
                    currentTd.prev("td").prev("td").prev("td").prev("td").text(r.deadline_date);
                    $("#add_deadline_medical").modal('hide'); 
                    $('.lightbox').topbox();
                    showSwal('success', 'Successfully update the data', false, true, 1500);
                }
            })
            .fail(function() {
                showSwal('error', 'Failed to process the file', false, true, 1500);
            });
        }else{
            alert("Deadline Date is not null.");
            $('#btn-add-deadline-medical').prop('disabled', false);
        }
        $('#deadline_date_medical').val('')
        
    })

    // $('.span-note').click(function(){
    //     var note = $(this).data('note');
    //     var attach = $(this).data('attach');
    //     $('.note-note').val(note)


    //     if (typeof attach === 'string') {
    //         try {
    //             attach = JSON.parse(attach);
    //         } catch (e) {
    //         }
    //     }
        
    //     if (Array.isArray(attach)) {
            
    //         let html = '';
    //         attach.forEach(function (file, i) {
    //             $('#attach_revise').attr('href', SITE_URL + file)
    //             $('#attach_revise').removeClass('hide')
    //         });

    //     // ==== SINGLE FILE ====
    //     } else {
    //         $('#attach_revise').attr('href', SITE_URL + attach)
    //         $('#attach_revise').removeClass('hide')
    //     }
    //     // if(attach){
    //     //     $('#attach_revise').attr('href', SITE_URL + attach)
    //     //     $('#attach_revise').removeClass('hide')
    //     // }else{
    //     //     $('#attach_revise').addClass('hide')
    //     // }
    // })


    function open_modal_validate(list_id, modal_id){
        var numberofDependent = $('#number_of_dependent').val();
        if($('#have_dependent').val() == 'No'){
            numberofDependent = 0;
        }
        var countList = $("#" +list_id+ " tr").length - 1;
        if(countList >= numberofDependent){
            showSwal('error', 'The amount you entered exceeds the dependent value. Please adjust accordingly.', false, true, 2500);
        }else {
            $('#' + modal_id).modal('show');
        }

        if(modal_id == 'form_add_ds160' && countList > -1){
            $('.datepicker').datepicker('destroy');
            $('#program_number_add, #start_date_add, #end_date_add').prop('readonly', true).datepicker('destroy');
            var program_number = $("#"+list_id+" tr:eq(0) td:eq(4)").text()
            var start_date_add = $("#"+list_id+" tr:eq(0) td:eq(5)").text()
            var end_date_add = $("#"+list_id+" tr:eq(0) td:eq(6)").text()

            $('#program_number_add').val(program_number)
            $('#start_date_add').val(start_date_add)
            $('#end_date_add').val(end_date_add)
            $('#' + modal_id).find(".datepicker").prop('readonly', true).css('background-color', '#eee');
            $("#propose_date_add").prop('readonly', true).css('background-color', '#fff');
        }else{
            $('.datepicker').datepicker('destroy');
            $('#program_number_add, #start_date_add, #end_date_add').prop('readonly', false).val('');
            $('#' + modal_id).find(".datepicker").prop('readonly', true).css('background-color', '#fff');
        }

        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "mm/dd/y",
            yearRange: "<?php echo date('Y') - 1 ?>:<?php echo date('Y') + 20 ?>"
        });
    }
    
    $('#have_dependent').change(function(){
        var value = $(this).val();
        // var number_of_dependent = $('#number_of_dependent').val()
        if(value == 'Yes'){
            $('#dependent-yes').removeClass('hide');
        }else if(value == 'No'){
            $('#dependent-yes').addClass('hide');
            $('#number_of_dependent').val('')
        }else{
            $('#dependent-yes').addClass('hide');
        }


        if($(this).val() == 'Yes'){
            $('.dependent-section').removeClass('hide');
        }else{
            $('.dependent-section').addClass('hide');
        }
    });

    $('#add_new_required').click(function(){
        var numberofDependent = $('#number_of_dependent').val();
        if($('#have_dependent').val() == 'No'){
            numberofDependent = 0;
        }
        var countList = $(".table-required").length - 1;

        if(countList >= numberofDependent){
            showSwal('error', 'The amount you entered exceeds the dependent value. Please adjust accordingly.', false, true, 2500);
        }else {
            var idx = $('.required-item').length;
            var departure_id = $('#departure_id').val();
            var grantee_grant_id = $('#grantee_grant_id').val();
            $.ajax({
                type: 'GET',
                url:  '<?= base_url('admin/departure/add_new_required_table') ?>/' + idx + '/' + grantee_grant_id + '/' + departure_id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        // $(el).closest('tr').remove();
                        // Swal.fire({
                        //     icon: "success",
                        //     title: "Successfully delete the data",
                        //     showConfirmButton: false,
                        //     timer: 1500
                        // });
                        $('.wrap-required').append(r.html)
                    }
                }
            });
        }
    })

    function del_item(el, item_class, id = null) {
        if (confirm("Are you sure want to delete this ?"))
            if(id){
                $.ajax({
                    type: 'GET',
                    url:  '<?= base_url('admin/departure/delete_required') ?>/' + id,
                    dataType: 'JSON',
                    success: function(r) {
                        if(r.success){
                            // $(el).closest('tr').remove();
                            // Swal.fire({
                            //     icon: "success",
                            //     title: "Successfully delete the data",
                            //     showConfirmButton: false,
                            //     timer: 1500
                            // });
                            $('.wrap-required').append(r.html)
                        }
                    }
                });
            }
            $(el).closest('.' + item_class).remove();
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

    // $('.input_time').timepicker({
    //     timeFormat: 'hh:mm p', // 12-hour format
    //     interval: 15, // Interval antara waktu
    //     dynamic: true,
    //     dropdown: true,
    //     scrollbar: true
    // });
    $('.input_time').timepicker({
        timeFormat: 'h:mm p',
        interval: 15,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    function emptyValue(object) {
        $(object).closest('.form-group').find('.datepicker').val('');
    }

    function emptyValueTime(object) {
        $(object).closest('.form-group').find('.input_time').val('');
    }

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

    function get_visa()
    {
        var grantee_grant_id = $('#grantee_grant_id').val();
        var departure_id = $('#departure_id').val();
        $('.show-visa-passport').html('');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/get_visa') ?>/'+ grantee_grant_id + '/' + departure_id,
            dataType: 'JSON',
            success: function(r) {
                if(r){
                    $('.show-visa-passport').html(r);
                    $('.lightbox').topbox();
                }
            }
        })
    }

    $('#arrival_city_pre_academic').blur(function(){
        $('#departure_city_academic_program').val($(this).val());
    })

    function select_staff(element, id_dependent) {
        var selectedOption = $(element).find(":selected");
        var email = selectedOption.data("email");
        var telephone = selectedOption.data("telephone");

        if(id_dependent){
            $('#email_dependent').val(email)
            $('#telephone_dependent').val(telephone)
        }else{
            $('#email').val(email)
            $('#telephone').val(telephone)
        }

    }

    $(document).on('click', '.btn-download-merge', function(e){
        const progress_dialog = $("#progress-dialog");
        e.preventDefault();
        progress_dialog.modal('show');
        $.ajax({
            url : $(this).attr('href'),
            type : 'GET',
            dataType : 'JSON',
            success : function(response) {
                var link = document.createElement('a');
                link.href = response.fileurl;
                link.download = response.filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                progress_dialog.modal('hide');
            }, error : function(response) {
                progress_dialog.modal('hide');
                
                Swal.fire({
                    title: "Failed to download the document",
                    text: response.responseText,
                    icon: "warning",
                    customClass: 'swal-custom'
                });
                
            }
        });
    });

    $('#show_international_ticket').change(function(){
        if($(this).val() == 'Yes'){
            $('.section-receipt-academic-program').addClass('hide');
        }else{
            $('.section-receipt-academic-program').removeClass('hide');
        }
    });

    function grantee_edit_required(element, table) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        var id = $(element).data('id')
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/departure/change_grantee_edit/') ?>'+ id + '/' + isChacked + '/' + table,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }

    function enable_toogle(element) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        var id = $(element).data('id')
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/departure/enable_visa_interview_appointment/') ?>'+ id + '/' + isChacked,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }

    function enable_toogle_allowance(element, field, table) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        var id = $(element).data('id')

        if(!id){
            showSwal('error', 'Data not found', false, true, 1500);
            return false

        }

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/allowance/enable_toogle') ?>',
            dataType: 'JSON',
            data: {
                id:id,
                value:isChacked,
                field:field,
                table:table,

            },
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }
    
    function enable_toggle_support_passport(element, field) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        var grantee_grant_id = $(element).data('granteegrantid') != undefined ? $(element).data('granteegrantid') : 0;
        var id = $(element).data('departureid') != undefined ? $(element).data('departureid') : 0;
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/departure/enable_toggle_support_passport/') ?>'+ id + '/' + isChacked + '/' + field + '/' + grantee_grant_id,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }
    
    function delete_support_letter_passport(el, id) {
        if (confirm("Are you sure want to delete this ?")){
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/departure/delete_file_support_letter_passport') ?>';
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/delete_file_support_letter_passport') ?>';
            }
            $.ajax({
                type: 'POST',
                url: urlAjax,
                data:{
                    id:id
                },
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $('#file_support_letter_passport').remove();
                        showSwal('success', 'Successfully delete the file', false, true, 1500);
                    }
                }
            });
        }

    }

    function validateVisaRenewal(section) {
        let isValid = true;
        let firstError = null;

        if (is_admin){
            return true;
        }

        $location = section == 'renewal' ? $('.appointment_located_renewal') : $('.appointment_located_dependent');
        $message = section == 'renewal' ? 'Please select appointment location and fill number of applicants.' : 'Please select appointment location and fill number of dependent.';

        // reset error
        $('.form-group').removeClass('has-error');
        $location.each(function () {
            let $select = $(this);

            if ($select.is(':disabled')) {
                return true;
            }

            let index = $select.data('index');
            let location = $select.val();
            let $dependent = section == 'renewal' ? $('#number_of_dependent_renewal_' + index) : $('#new_number_of_dependent_' + index);
            let dependentVal = $dependent.val();

            // validasi location
            if (location === '') {
                isValid = false;
                $select.closest('.form-group').addClass('has-error');
                if (!firstError) firstError = $select;
            }

            if (
                !$dependent.is(':disabled') &&
                (dependentVal === '' || parseInt(dependentVal) <= 0)
            ) {
                isValid = false;
                $dependent.closest('.form-group').addClass('has-error');
                if (!firstError) firstError = $dependent;
            }
        });

        if (!isValid) {
            showSwal('warning', $message, false, true, 2000);
            if (firstError) {
                firstError.focus();
            }
        }

        return isValid;
    }

    function toggle_enable_grantee_pickup(element) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        var id = $(element).data('id')
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/departure/enable_grantee_pickup/') ?>'+ id + '/' + isChacked,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }
    
    // function show_preview_attachment(element, type, upload_type) {
    //     const file = element.files[0];
    //     $('#btn-save-note-withdraw').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
    //     let formData = new FormData();
    //     formData.append(upload_type, file);
    //     formData.append('type', upload_type);

    //     $.ajax({
    //         url: SITE_URL + 'admin/grantee/save_file', 
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         dataType : 'JSON',
    //         success: function(response) {
    //             if (response.status) {
    //                 render_data_upload_attach(response, upload_type);
    //             } else {
    //                 $(".uploaded_attachment").addClass('hide');
    //                 alert('Failed to upload your file, please try again');
    //             }

    //             $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
    //         },
    //         error: function(xhr, status, error) {
    //             $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
    //             console.error(error); 
    //         }
    //     });
    // }

    function validateAndSubmit() {
        if(is_admin){
            return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_support_letter')
        }else{
            var reason = $('#reason').val();
            var support_letter = $('#support_letter').val();
            if(reason == '' && support_letter == 'No'){
                showSwal('warning', '', 'Please provide a statement to explain your reason for not returning to your home institution after completion of the program.', true, 5000);
                $('#reason').focus();
                return false;
            }else{
                return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_support_letter')
            }
        }
    }

    function setToDepartureDocument(element, id) {
        var isChecked = $(element).is(':checked') ? 1 : 0;
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/departure/set_to_departure_document/') ?>' + id,
            data: { 
                value: isChecked,
                grantee_grant_id: id
             },
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });
    }

    function setEnableSupportLetter(element, id) {
        var isChecked = $(element).is(':checked') ? 0 : 1;
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/departure/set_enable_support_letter/') ?>' + id,
            data: { 
                value: isChecked,
                id: id
             },
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });
    }

</script>