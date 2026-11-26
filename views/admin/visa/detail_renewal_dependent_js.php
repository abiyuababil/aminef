<script>
    $(document).ready(function(){
        const interview_appointment_renewal = $('#interview_appointment_renewal').val();
        $('#interview_location_add_renewal, #location_renewal').val(interview_appointment_renewal);
        $('#number_of_dependent_renewal, #appointment_located_renewal, .point_of_contact_renewal, .point_of_contact_dependent, .visa-category').trigger('change')
    });

    function updateNo(tbodyId) {
        $('#' + tbodyId + ' tr').each(function (index) {
            $(this).find('td:first').text(index + 1);
        });
    }

    function select_staff_ongoing(element, is_dependent, is_admin) {
        var selectedOption = $(element).find(":selected");
        var email = selectedOption.data("email");
        var telephone = selectedOption.data("telephone");
        if(!is_admin){
            selectedOption = $(element).find(":selected");
            email = selectedOption.data("email");
            telephone = selectedOption.data("telephone");
        }

        if(is_dependent){
            $('#email_dependent_ongoing').val(email)
            $('#telephone_dependent_ongoing').val(telephone)
        }else{
            $('#email_renewal').val(email)
            $('#telephone_renewal').val(telephone)
        }

    }

    // ========================= SIGNED TOA RENEWAL =========================
        
        $('#total_cost').on('keyup', function(e) {
            let value = $(this).val() == '' ? '0' : $(this).val();
            value = value.replace(/\D/g, '');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            $(this).val(value == '0' ? '' : value );
        });

        function del_data_ongoing(el, id, tbodyId, is_admin) {
            if (confirm("Are you sure want to delete this ?"))
                var urlAjax = '<?php echo site_url('admin/on_going/delete_file') ?>/'+ id + '/' + tbodyId;
                if(!is_admin){
                    var urlAjax = '<?php echo site_url('grantee/submission/delete_file_ongoing') ?>/'+ id + '/' + tbodyId;
                }
                $.ajax({
                    type: 'GET',
                    url: urlAjax,
                    dataType: 'JSON',
                    success: function(r) {
                        if(r.success){
                            $(el).closest('tr').remove();
                            showSwal('success', 'Successfully delete the data', false, true, 1500);
                            updateNo(tbodyId)
                        }
                    }
                });
        }
    // ========================= END SIGNED TOA RENEWAL =====================

    // ========================= VISA RENEWAL ===============================
        function open_modal_validate_ongoing(list_id, modal_id){
            // $('.fields_appointment, .fields_appointment_dependent').val('')
            var appointment_located = $('#appointment_located_renewal').val();
            var appointment_located_dependent = $('#appointment_located_dependent').val();
            var numberofDependent = modal_id == 'form_add_appointment_ongoing' ? $('#number_of_dependent_renewal').val() : $('#new_number_of_dependent').val();
            // if($('#have_dependent_ongoing').val() == 'No'){
            //     numberofDependent = 0;
            // }


            var countList = $("#" +list_id+ " tr").length;
            if(countList >= numberofDependent){
                showSwal('error', 'The amount you entered exceeds the dependent value. Please adjust accordingly.', false, true, 2500);
            }else {
                $('#' + modal_id).modal('show');
            }

            // if(modal_id == 'form_add_appointment'){
            //     var countList = $("#" +list_id+ " tr").length - 1;
            //     if(countList >= numberofDependent){
            //         showSwal('error', 'The amount you entered exceeds the dependent value. Please adjust accordingly.', false, true, 2500);
            //     }else {
            //         $('#' + modal_id).modal('show');
            //     }
            // }else if(modal_id == 'form_add_appointment_dependent'){
            //     var countList = $("#" +list_id+ " tr").length;
            //     if(countList >= numberofDependent){
            //         showSwal('error', 'The amount you entered exceeds the dependent value. Please adjust accordingly.', false, true, 2500);
            //     }else {
            //         $('#' + modal_id).modal('show');
            //     }
            // }
            if(modal_id == 'form_add_appointment_dependent'){
                $('.visa_type_ongoing').val('J2')
                $('#appointment_located_dependent').trigger('change')
                if(appointment_located_dependent == '' || appointment_located_dependent == null){
                    Swal.fire("Please select visa interview location");
                    return false
                }
            }
            if(modal_id == 'form_add_appointment_ongoing'){
                if(appointment_located == '' || appointment_located == null){
                    Swal.fire("Please select visa renewal location");
                    return false
                }
                $('#appointment_located_renewal').trigger('change')
            }
            return false


            if(modal_id == 'form_add_appointment_ongoing' && countList > 0){
                $('.program_number_ongoing').prop('readonly', true);
                var program_number_ongoing = $("#"+list_id+" tr:eq(0) td:eq(12)").text()

                $('.program_number_ongoing').val(program_number_ongoing)

            }else if(modal_id == 'form_add_appointment_dependent' && countList > 0){
                $('.program_number_ongoing').prop('readonly', true);
                var program_number_ongoing = $("#"+list_id+" tr:eq(0) td:eq(10)").text()

                $('.program_number_ongoing').val(program_number_ongoing)
            }else{
                $('.program_number_ongoing, #start_date_add_ongoing, #end_date_add_ongoing').prop('readonly', false).val('');
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "mm/dd/y",
                    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
            }
        }

        $('#appointment_located_renewal').on('change', function() {
            var value = $(this).val();
            var $form = $('#form_add_appointment_ongoing').find('#form_appointment_renewal');
            $(".needdatepicker").removeClass('datepicker').removeClass('hasDatepicker')

            if(value == 'Surabaya'){
                $('.visa-jakarta-section').addClass('hide')
                $('.visa-jakarta-section-tab').removeClass('hide')
                $('.visa-surabaya-section').removeClass('hide')
                $('.visa-jakarta-section-label').addClass('hide')
                $form.html($('.field-appointment-surabaya').html())
                // $('#interview_location').val('Surabaya')
                $('.visa-category').addClass('hide')
                $('.label-after-visa').html('After Visa Interview')
            } else if(value == 'Jakarta'){
                // $('.visa-surabaya-section').addClass('hide')
                // $('.visa-jakarta-section, .visa-jakarta-section-tab, .visa-category').removeClass('hide')
                $('.visa-category').removeClass('hide')
                $('.label-after-visa').html('After Visa Renewal')
                $('.visa-surabaya-section, .visa-jakarta-section').removeClass('hide')
                $('.visa-surabaya-section, .visa-jakarta-section-tab').addClass('hide')
                $form.html($('.field-appointment-surabaya').html())
                $('.visa-category').trigger('change')
            } else {
                $('.visa-jakarta-section-label').addClass('hide')
                $('.visa-surabaya-section, .visa-jakarta-section').removeClass('hide')
                $('.visa-surabaya-section, .visa-jakarta-section-tab, .visa-category').addClass('hide')
                $form.html('')
            }
            $('#location_renewal').val(value)
            $('#interview_location_renewal').val(value)

            $(".needdatepicker").addClass('datepicker')
            $form.find('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "mm/dd/y",
                yearRange: "1900:2050",
                appendTo: 'body'
            });
        });

        $(document).on('click', '.visa-category', function() {
        // $('.visa-category').on('change', function() {
            var appointment_located = $('#appointment_located_renewal').val();
            var $form = $('#form_add_appointment_ongoing').find('#form_appointment_renewal');
            $(".needdatepicker").removeClass('datepicker').removeClass('hasDatepicker')
            var value = $('#category_visa').val();

            if(appointment_located == 'Jakarta'){
                if(value == 'Visa Interview'){
                    $('.visa-surabaya-section').removeClass('hide')
                    $('.visa-jakarta-section, .visa-jakarta-section-tab').removeClass('hide')
                    $('.label-after-visa').html('After Visa Renewal')
                    $('.visa-jakarta-section-label').addClass('hide')
                    $form.html($('.field-appointment-surabaya').html())
                }else{
                    $('.visa-jakarta-section-label').removeClass('hide')
                    $('.visa-surabaya-section').addClass('hide')
                    $('.label-after-visa').html('After Visa Renewal')
                    $('.visa-jakarta-section, .visa-jakarta-section-tab').removeClass('hide')
                    $form.html($('.field-appointment-surabaya').html())
                }
            }

            $(".needdatepicker").addClass('datepicker')
            $form.find('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "mm/dd/y",
                yearRange: "1900:2050",
                appendTo: 'body'
            });
        });

        $("#form_appointment_renewal").on("submit", function (e) {
            e.preventDefault();

            if (this.checkValidity()) {
                var form = document.getElementById('form_appointment_renewal');
                var formData = new FormData(form);

                var is_admin = $('#is_admin').val();
                var index = $('#list_appointment_renewal tr').length;
                var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
                var appointment_located = $('#appointment_located_renewal').val();
                var urlAjax = '<?php echo site_url('admin/on_going/add_appointment') ?>';
                if(!is_admin){
                    urlAjax = '<?php echo site_url('grantee/submission/add_appointment_on_going') ?>'
                }

                formData.append('appointment_located', appointment_located);
                formData.append('grantee_grant_id', grantee_grant_id);
                formData.append('index', (index + 1));
                formData.append('is_admin', is_admin);

                $('#btn-save-appointment').prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: urlAjax,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $('#btn-save-appointment').prop('disabled', false);
                        $('.fields_appointment').val('');
                        $("#form_add_appointment_ongoing").modal('hide');
                        if(response.is_edit){
                            $('#index-appointment-ongoing'+response.index+ ' td').remove();
                            $('#index-appointment-ongoing'+response.index).append(response.html);
                            $('#index-required-'+response.index).find('td:nth-child(2)').text(response.post.last_name);
                            $('#index-required-'+response.index).find('td:nth-child(3)').text(response.post.first_name);
                            $('#index-sign-'+response.index).find('td:nth-child(2)').text(response.post.last_name);
                            $('#index-sign-'+response.index).find('td:nth-child(3)').text(response.post.first_name);
                            
                            $("#list_appointment_renewal tr:not(:first-child) td:nth-child(13)").text(response.post.program_number);
                            showSwal('success', 'Successfully edit the data', false, true, 1500);
                        }else{ 
                            $('#list_appointment_renewal').append(response.html);
                            $('#list_required_doc_renewal').append(response.html_required);
                            $('#list_ds2019sign_visapage_renewal').append(response.html_sign);
                            showSwal('success', 'Successfully add the data', false, true, 1500);
                        }
                    }
                });
            } else {
                alert("Please fill out all required fields correctly.");
            }
        });

        function del_data_appointment_ongoing(el, id, index, is_dependent = 0) {

            var is_admin = $('#is_admin').val();
            var urlAjax = '<?php echo site_url('admin/on_going/delete_appointment') ?>/'+ id
            if(!is_admin){
                urlAjax = '<?php echo site_url('grantee/submission/delete_appointment_on_going') ?>/'+ id
            }
            var dependentId = is_dependent ? 'dependent-' : '';
            var dependent = is_dependent ? '_dependent' : '';
            if (confirm("Are you sure want to delete this ?"))
                $.ajax({
                    type: 'GET',
                    url: urlAjax,
                    dataType: 'JSON',
                    success: function(r) {
                        if(r.success){
                            $(el).closest('tr').remove();
                            $('#index-required-'+ dependentId + index).remove();
                            $('#index-sign-'+ dependentId + index).remove();
                            updateNo('list_appointment_renewal' + dependent)
                            updateNo('list_required_doc_renewal' + dependent)
                            updateNo('list_ds2019sign_visapage_renewal' + dependent)
                            showSwal('success', 'Successfully delete the data', false, true, 1500);
                        }
                    }
                });
        }

        function edit_data_appointment_ongoing(el, id, index, is_admin, is_dependent = 0)
        {
            var is_admin = $('#is_admin').val();
            var urlAjax = '<?php echo site_url('admin/on_going/get_appointment') ?>/'+ id
            if(!is_admin){
                urlAjax = '<?php echo site_url('grantee/submission/get_appointment_on_going') ?>/'+ id
            }
            if(index == 1){
                $('.program_number').prop('readonly', false);
            }else{
                $('.program_number').prop('readonly', true);
            }

            const modal = is_dependent ? $("#form_add_appointment_dependent") : $("#form_add_appointment_ongoing");
            const checkBox = is_dependent ? $("#dont_have_first_name") : $("#dont_have_first_name2");
            showSwal('loading', 'Please wait while we process your request.');
            $.ajax({
                type: 'GET',
                url: urlAjax,
                dataType: 'JSON',
                success: function(r) {
                    console.log(r)
                    Swal.close(); 
                    modal.modal('show');  
                    $('.appointment_id').val(r.data.id)
                    $('.index_appointment').val(index)
                    $('.first_name').val(r.data.first_name)
                    $('.last_name').val(r.data.last_name)
                    $('.gender').val(r.data.gender)
                    $('.date_of_birth').val(r.data.date_of_birth ? formatDate(r.data.date_of_birth) : '')
                    $('.place_of_birth').val(r.data.place_of_birth)
                    $('.passport').val(r.data.passport)
                    $('.program_number').val(r.data.program_number)
                    $('.ds160').val(r.data.ds160)
                    $('.sevis_id').val(r.data.sevis_id)
                    $('.interview_location').val(r.data.interview_location)
                    $('.propose_date').val(r.data.propose_date ? formatDate(r.data.propose_date) : '')
                    $('.travel_plan').val(r.data.travel_plan ? formatDate(r.data.travel_plan) : '')
                    $('.telephone').val(r.data.telephone)
                    $('.nationality').val(r.data.nationality)
                    $('.visa_type_ongoing').val(r.data.visa_type)
                    $('.passport_type').val(r.data.passport_type)
                    $('.email').val(r.data.email)
                    let dontHave = (r.data.dont_have_first_name == 1);
                    if(dontHave){
                        $(checkBox)
                            .prop('checked', dontHave)
                            .trigger('change');
                    }else{
                        $(checkBox)
                            .prop('checked', dontHave)
                            .trigger('change');
                        $('.first_name').val(r.data.first_name)
                    }
                }
            });

        }

        $(document).on('click', '.upload-button-ongoing', function() {
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
                var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
                let currentTd = $('.btn-' + doc_type + '-' + data_id).closest("td");
                var id = 1;
                var function_name = table_save == 'save_ds2019_sign' ? 'save_ds2019_sign' : 'save_required_document';
                if(is_admin){
                    var urlAjax = "<?= base_url(); ?>admin/on_going/" + function_name;
                }else{
                    var urlAjax = "<?= base_url(); ?>grantee/submission/" + function_name + '_on_going'
                }
                showSwal('loading', 'Please wait while we process your request.');
        
        
                var formData = new FormData();
                formData.append("file", e.target.files[0]);
                formData.append("doc_type", doc_type);
                formData.append("data_id", data_id);
                formData.append("default", data_default);
                formData.append("grantee_grant_id", grantee_grant_id);
                formData.append("table_save", table_save);
                formData.append("is_admin", is_admin);
                $.ajax({
                    url: urlAjax,
                    type: 'POST',
                    data: formData, // The form with the file inputs.
                    processData: false,
                    contentType: false // Using FormData, no need to process data.
                }).done(function(r) {
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
                })
                .fail(function() {
                    showSwal('error', 'Failed to upload the file', false, true, 1500);
                });
        
                $(this).val('');
            });
        })

        function del_data_required_ongoing(el, id, doc, fucntion_name, is_admin)
        {
            if (confirm("Are you sure want to delete this ?")){
                let currentTd = $(el).closest("td");
                showSwal('loading', 'Please wait while we process your request.');
                if(is_admin){
                    var urlAjax = "<?= base_url(); ?>admin/on_going/" + fucntion_name + '/' + id + '/' + doc
                }else{
                    var urlAjax = "<?= base_url(); ?>grantee/submission/" + fucntion_name + '_on_going' + '/' + id + '/' + doc
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
                $('.obtaining-section-dependent').removeClass('hide');
                if($('#appointment_date').val() == ''){
                    $('#appointment_date').val($('#checkin_date_domestic').val())
                }
            }else{
                $('.obtaining-section-dependent').addClass('hide');
                $('#appointment_date').val('')
            }

            
        })

        function delete_file_visa_ongoing(el, field, is_admin, is_dependent = 0) {
            var dependent = is_dependent ? '_dependent' : '';
            if (confirm("Are you sure want to delete this ?")){
                var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
                if(is_admin){
                    var urlAjax = '<?php echo site_url('admin/on_going/delete_file_visa') ?>'+ dependent + '/' + grantee_grant_id + '/' + field;
                }else{
                    var urlAjax = '<?php echo site_url('grantee/submission/delete_file_visa_ongoing') ?>'+ dependent + '/' + grantee_grant_id + '/' + field;
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

        function grantee_edit_toa(element, table) {
            var isChacked = 0;
            if($(element).is(':checked')) {
                isChacked = 1;
            } else {
                isChacked = 0;
            }
            
            var id = $(element).data('id')
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/on_going/change_grantee_edit/') ?>'+ id + '/' + isChacked + '/' + table,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        showSwal('success', 'Successfully changed', false, true, 1500);
                    }
                }
            });

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

        $(".modal-log-toa").click(function(e){
            var data_id = $(this).data('log')
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/on_going/get_log_toa') ?>',
                dataType: 'JSON',
                data:{
                    id: data_id,
                    table: 'am_signed_toa_renewal'
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
                    if(key == 'file' || key == 'signed_toa' || key == 'detail_cost'){
                        if(value != ''){
                            value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                        }
                    }
                    if( key == 'filename' || key == 'filename_grantee' || key == 'departure_id'){
                        return true;
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
                    if(key == 'file' || key == 'signed_toa' || key == 'detail_cost'){
                        if(value != ''){
                            value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                        }
                    }
                    if( key == 'filename' || key == 'filename_grantee' || key == 'departure_id'){
                        return true;
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
    // ========================= END VISA RENEWAL ===========================

    // ========================= VISA DEPENDENT =============================

        $("#appointment_located_dependent").on("change", function (e) {
            var value = $(this).val();
            $('#interview_location_dependent').val(value)
            $('#location_dependent').val(value)
        })


        $("#form_appointment_dependent").on("submit", function (e) {
            e.preventDefault();

            if (this.checkValidity()) {
                var form = document.getElementById('form_appointment_dependent');
                var formData = new FormData(form);
                var is_admin = '<?= $is_admin ?>';
                var urlAjax = '<?php echo site_url('grantee/submission/add_appointment_on_going') ?>';
                
                if(is_admin){
                    urlAjax = '<?php echo site_url('admin/on_going/add_appointment') ?>';
                }

                var index = $('#list_appointment_dependent tr').length;
                var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
                var appointment_located = $('#appointment_located_dependent').val();
                formData.append('appointment_located', appointment_located);
                formData.append('grantee_grant_id', grantee_grant_id);
                formData.append('index', (index + 1));
                formData.append('is_dependent', 1);
                formData.append('is_admin', is_admin);

                $('#btn-save-appointment-dependent').prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: urlAjax,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $('#btn-save-appointment-dependent').prop('disabled', false);
                        $('.fields_appointment_dependent').val('');
                        $("#form_add_appointment_dependent").modal('hide');  
                        if(response.is_edit){
                            $('#index-appointment-dependent-'+response.index+ ' td').remove();
                            $('#index-appointment-dependent-'+response.index).append(response.html);
                            $('#index-required-dependent-'+response.index).find('td:nth-child(2)').text(response.post.last_name);
                            $('#index-required-dependent-'+response.index).find('td:nth-child(3)').text(response.post.first_name);
                            $('#index-sign-dependent-'+response.index).find('td:nth-child(2)').text(response.post.last_name);
                            $('#index-sign-dependent-'+response.index).find('td:nth-child(3)').text(response.post.first_name);
                            
                            $("#list_appointment_dependent tr td:nth-child(11)").text(response.post.program_number);
                            showSwal('success', 'Successfully edit the data', false, true, 1500);
                        }else{ 
                            $('#list_appointment_dependent').append(response.html);
                            $('#list_required_doc_dependent').append(response.html_required);
                            $('#list_ds2019sign_visapage_dependent').append(response.html_sign);
                            showSwal('success', 'Successfully add the data', false, true, 1500);
                        }
                    }
                });
            } else {
                alert("Please fill out all required fields correctly.");
            }
        });
    // ========================= END VISA DEPENDENT =========================

    // ========================= CASE =======================================
        $("#form_case").on("submit", function (e) {
            e.preventDefault();

            if (this.checkValidity()) {
                tinymce.triggerSave();
                var form = document.getElementById('form_case');
                var formData = new FormData(form);

                var index = $('#list_case tr').length;
                var grantee_grant_id = '<?= $grantee_grant_id ?>';
                formData.append('index', (index + 1));
                formData.append('grantee_grant_id', grantee_grant_id);

                $('#btn-add-case').prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('admin/on_going/add_case') ?>',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $('#btn-add-case').prop('disabled', false);
                        $('.fields_case').val('');
                        $("#add_case").modal('hide');  
                        if(response.is_edit){
                            $('#index-case-'+response.index+ ' td').remove();
                            $('#index-case-'+response.index).append(response.html);
                            showSwal('success', 'Successfully edit the data', false, true, 1500);
                        }else{ 
                            $('#list_case').append(response.html);
                            showSwal('success', 'Successfully add the data', false, true, 1500);
                        }
                        $('.lightbox').topbox();
                    }
                });
            } else {
                alert("Please fill out all required fields correctly.");
            }
        });

        function del_data_case(el, id, index) {
            if (confirm("Are you sure want to delete this ?"))
                $.ajax({
                    type: 'GET',
                    url: '<?php echo site_url('admin/on_going/delete_case') ?>/'+ id,
                    dataType: 'JSON',
                    success: function(r) {
                        if(r.success){
                            $(el).closest('tr').remove();
                            showSwal('success', 'Successfully delete the data', false, true, 1500);
                        }
                    }
                });
        }

        function edit_data_case(el, id, index)
        {
            const modal = $("#add_case");
            $('#modalTitleCase').text('Edit Special Case')
            showSwal('loading', 'Please wait while we process your request.');
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/on_going/get_case') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    Swal.close(); 
                    modal.modal('show');  
                    $('#case_id').val(r.data.id)
                    $('#type_case').val(r.data.type)
                    $('.index_case').val(index)
                    // $('#summary').val(r.data.summary)
                    let editor = tinymce.get('summary');
                    if (editor) {
                        editor.setContent(r.data.summary);
                    } 
                }
            });

        }

        $(document).on('click', '.add_case', function() {
            $('.fields_case').val('');
            $('#modalTitleCase').text('Add Special Case');
            let editor = tinymce.get('summary');
            if (editor) {
                editor.setContent('');
            } 
        })
    // ========================= END CASE ===================================

    // ========================= POST DEGREE =================
        $("#form_post_degree").on("submit", function (e) {
            e.preventDefault();

            if (this.checkValidity()) {
                var form = document.getElementById('form_post_degree');
                var formData = new FormData(form);

                var index = $('#list_post_degree tr').length;
                var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
                var is_admin = '<?= $is_admin ?>';
                formData.append('index', (index + 1));
                formData.append('grantee_grant_id', grantee_grant_id);
            
                var urlAjax = '<?php echo site_url('admin/on_going/add_post_degree') ?>'
                if(!is_admin){
                    var urlAjax = '<?php echo site_url('grantee/submission/add_post_degree') ?>'
                }

                $('#btn-add-post_degree').prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: urlAjax,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $('#btn-add-post_degree').prop('disabled', false);
                        $('.fields_post_degree').val('');
                        $("#add_post_degree").modal('hide');  
                        if(response.is_edit){
                            $('#index-post_degree-'+response.index+ ' td').remove();
                            $('#index-post_degree-'+response.index).append(response.html);
                            showSwal('success', 'Successfully edit the data', false, true, 1500);
                        }else{ 
                            $('#list_post_degree').append(response.html);
                            showSwal('success', 'Successfully add the data', false, true, 1500);
                        }
                        $('.lightbox').topbox();
                    }
                });
            } else {
                alert("Please fill out all required fields correctly.");
            }
        });

        function del_data_post_degree(el, id, index) {
            var is_admin = '<?= $is_admin ?>';
            var urlAjax = '<?php echo site_url('admin/on_going/delete_post_degree') ?>/'+ id;
            if(!is_admin){
                var urlAjax = '<?php echo site_url('grantee/submission/delete_post_degree') ?>/'+ id
            }

            if (confirm("Are you sure want to delete this ?"))
                $.ajax({
                    type: 'GET',
                    url: urlAjax,
                    dataType: 'JSON',
                    success: function(r) {
                        if(r.success){
                            $(el).closest('tr').remove();
                            showSwal('success', 'Successfully delete the data', false, true, 1500);
                        }
                    }
                });
        }

        function edit_data_post_degree(el, id, index)
        {
            const modal = $("#add_post_degree");
            showSwal('loading', 'Please wait while we process your request.');
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/on_going/get_post_degree') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    Swal.close(); 
                    modal.modal('show');  
                    $('#post_degree_id').val(r.data.id)
                    $('.index_post_degree').val(index)
                    $('.request_date').val(r.data.request_date ? formatDate(r.data.request_date) : '')
                    $('.start_date_post_degree').val(r.data.start_date ? formatDate(r.data.start_date) : '')
                    $('.end_date_post_degree').val(r.data.end_date ? formatDate(r.data.end_date) : '')
                    $('.decision').val(r.data.decision)
                }
            });

        }

        $(document).on('click', '.add_post_degree', function() {
            $('.fields_post_degree').val('');
        })
    // ========================= END POST DEGREE =============

    // ========================= WORK AUTHORIZATION REQUEST =================
        $("#form_work").on("submit", function (e) {
            e.preventDefault();

            if (this.checkValidity()) {
                var form = document.getElementById('form_work');
                var formData = new FormData(form);

                var is_admin = $('#is_admin').val();
                var urlAjax = '<?php echo site_url('admin/on_going/add_work') ?>';
                if(!is_admin){
                    urlAjax = '<?php echo site_url('grantee/submission/add_work') ?>'
                }
                var index = $('#list_work tr').length;
                var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
                formData.append('index', (index + 1));
                formData.append('grantee_grant_id', grantee_grant_id);
                formData.append('is_admin', is_admin);

                $('#btn-add-work').prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: urlAjax,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $('#btn-add-work').prop('disabled', false);
                        $('.fields_work').val('');
                        $("#add_work").modal('hide');  
                        if(response.is_edit){
                            $('#index-work-'+response.index+ ' td').remove();
                            $('#index-work-'+response.index).append(response.html);
                            showSwal('success', 'Successfully edit the data', false, true, 1500);
                        }else{ 
                            $('#list_work').append(response.html);
                            showSwal('success', 'Successfully add the data', false, true, 1500);
                        }
                        $('.lightbox').topbox();
                    }
                });
            } else {
                alert("Please fill out all required fields correctly.");
            }
        });

        function del_data_work(el, id, index) {
            var is_admin = $('#is_admin').val();
            var urlAjax = '<?php echo site_url('admin/on_going/delete_work') ?>/'+ id;
            if(!is_admin){
                urlAjax = '<?php echo site_url('grantee/submission/delete_work') ?>/'+ id;
            }
            if (confirm("Are you sure want to delete this ?"))
                $.ajax({
                    type: 'GET',
                    url: urlAjax,
                    dataType: 'JSON',
                    success: function(r) {
                        if(r.success){
                            $(el).closest('tr').remove();
                            showSwal('success', 'Successfully delete the data', false, true, 1500);
                        }
                    }
                });
        }

        function edit_data_work(el, id, index)
        {
            const modal = $("#add_work");
            var is_admin = $('#is_admin').val();
            var urlAjax = '<?php echo site_url('admin/on_going/get_work') ?>/'+ id;
            if(!is_admin){
                urlAjax = '<?php echo site_url('grantee/submission/get_work') ?>/'+ id;
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
                    $('#work_id').val(r.data.id)
                    $('.index_work').val(index)
                    $('.request_date').val(r.data.request_date ? formatDate(r.data.request_date) : '')
                    $('.start_date_work').val(r.data.start_date ? formatDate(r.data.start_date) : '')
                    $('.end_date_work').val(r.data.end_date ? formatDate(r.data.end_date) : '')
                    $('.decision').val(r.data.decision)
                }
            });

        }

        $(document).on('click', '.add_work', function() {
            $('.fields_work').val('');
        })
    // ========================= END WORK AUTHORIZATION REQUEST =============

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
                    updateOrderAfterDeleteOngoing();
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-upload-ds2019-ongoing').prop('disabled', false);
        }
    });

    function del_data_ds2019_ongoing(el, id, is_admin) {
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
                        updateOrderAfterDeleteOngoing();
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
        }

    }

    function updateOrderAfterDeleteOngoing() {
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



    $("#btn-upload-academic-transcript").click(function(){
        var fd = new FormData();
        var year = $('#year_academic_transcript').val();
        var files = $('#upload_academic_transcript_file')[0].files;
        var input_file = document.getElementById('upload_academic_transcript_file'); 
        var totalfiles = input_file.files.length;
        var is_admin = '<?= $is_admin ?>';
        var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
        var order = $('#table-academic-transcript tbody tr').length + 1;
        if(is_admin){
            var urlAjax = '<?php echo site_url('admin/on_going/add_academic_transcript') ?>';
        }else{
            var urlAjax = '<?php echo site_url('grantee/submission/add_academic_transcript_on_going') ?>';
        }
        $('#btn-upload-academic-transcript').prop('disabled', true);


        // validate dependent
        var numberofDependent = $('#number_of_dependent_renewal').val();
        if($('#have_dependent_ongoing').val() == 'No'){
            numberofDependent = 0;
        }
        var countList = $("#academic_transcript_list tr").length - 1;
        var totalCountList = countList + totalfiles

        if(totalCountList > numberofDependent){
            $("#upload_academic_transcript").modal('hide');  
            $('#btn-upload-academic-transcript').prop('disabled', false);
            $('#upload_academic_transcript_file').val('');
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
            $.ajax({
                url: urlAjax,
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-upload-academic-transcript').prop('disabled', false);
                    $('#upload_academic_transcript_file').val('');
                    $("#upload_academic_transcript").modal('hide');   
                    $('#academic_transcript_list').append(response.html);
                    $('#departure_id').val(response.departure_id);
                    $('.lightbox').topbox();
                    updateOrderAfterDeleteOngoing();
                    showSwal('success', 'Successfully upload the file', false, true, 1500);
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-upload-academic-transcript').prop('disabled', false);
        }
    });


    function del_data_academic_transcript(el, id, is_admin) {
        if (confirm("Are you sure want to delete this ?")){
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/on_going/delete_data_academic_transcript/') ?>';
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/delete_data_academic_transcript_on_going/') ?>';
            }
            $.ajax({
                type: 'GET',
                url: urlAjax + id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                        updateOrderAfterDeleteOngoing();
                        showSwal('success', 'Successfully delete the data', false, true, 1500);
                    }
                }
            });
        }

    }
    
    $('#enable_delete_ds2019').change(function(event, isTriggered) {
        var isChacked = 0;
        var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
        if($(this).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        if(!isTriggered){
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
            }
            });
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/on_going/set_delete_ds2019') ?>',
            dataType: 'JSON',
            data:{
                enable_delete_ds2019: isChacked,
                grantee_grant_id: grantee_grant_id
            },
            success: function(r) {
                if(!isTriggered){
                    location.reload();
                }
            }
        });
    });

    function enable_toogle_ongoing(element, dependent) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        var id = $(element).data('id')
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/on_going/enable_visa_interview_appointment/') ?>'+ id + '/' + isChacked + '/' + dependent,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }

    function enable_toogle_grantee_ongoing(element, field, dependent, id) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/on_going/enable_toogle_grantee/') ?>'+ dependent + '/' + id + '/' + isChacked + '/' + field,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }


    $(document).on('click', '#addVisaRenewal', function() {
        let i = $('.renewal-item').length;
        // let clone = $('#applicant-template-renewal').children().first().clone();
        // clone.html().replaceAll('{index}', i);
        let template = $('#applicant-template-renewal').html().replaceAll('{index}', i);
        
        $('#visa-renewal-wrapper').append(template);
    });



</script>