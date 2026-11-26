<script>

    const is_admin = '<?php echo isset($is_admin) ? 1 : 0 ?>';
    const SITE_URL = '<?php echo site_url(); ?>';

    $(document).ready(function(){
        $(".select_show, .show_international_ticket").trigger("change");
        $('.select2').select2({
            theme: 'bootstrap'
        });

        var role = '<?= isset($is_grantee) ? $is_grantee : false ?>';
        var form_control = $('.form-control, .radio-nominee');
        var form_control_grantee = $('.form-control-grantee');
        if(role){
            form_control.prop('disabled', true).css('background-color', '#eee');
            form_control_grantee.prop('disabled', false).css('background-color', '#fff');
        }
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 1 ?>:<?php echo date('Y') + 20 ?>"
        });

        $('.arrival_city_pre_academic').each(function () {
            var el = this;
            var index = $(this).attr('onkeyup').match(/\d+/)[0]; // ambil index dari onkeyup
            rewrite(el, index, true);
        });
    });

    function change_show_international(el, index, section){
        let val = $(el).val();
        if(val == 'No' || val == ''){
            $('.section-' + section + '-' + index).addClass('hide');
        } else if(val == 'Yes'){
            $('.section-' + section + '-' + index).removeClass('hide');
            $('.section-receipt-academic-program_' + index).addClass('hide');
            $('.section-eticket-academic-program_' + index).removeClass('hide');
            $('.label-eticket-pre-academic-' + index).text('E-Ticket');
        } else if(val == 'Third Party'){
            $('.section-' + section + '-' + index).removeClass('hide');
            $('.section-receipt-academic-program_' + index).addClass('hide');
            $('.section-eticket-academic-program_' + index).removeClass('hide');
        }else{
            $('.section-' + section + '-' + index).removeClass('hide');
            $('.section-receipt-academic-program_' + index).removeClass('hide');
            $('.section-eticket-academic-program_' + index).addClass('hide');
            $('.label-eticket-pre-academic-' + index).text('Receipt');
        }
        const showHeader = $('.select-departure-' + index).is(function () {
            return $(this).val() === 'Yes' || $(this).val() === 'Reimbursement' || $(this).val() === 'Departure Reimbursement' || $(this).val() === 'Return Reimbursement';
        });
        $('.header-international-departure-' + index).toggleClass('hide', !showHeader);
    };

    $(document).on('click', '#addTravelArrangement', function() {

        saveTravelArrangement({
            name_travel: $('#name_travel').val(),
            category_travel: $('#category_travel').val(),
            grantee_grant_id: is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>'
        });

        // let i = $('.travelArrangement-item').length;
        // var grantee_grant_id = is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>';
        // var name_travel = $('#name_travel').val();
        // var category_travel = $('#category_travel').val();

        // if(name_travel ===''){
        //     return showSwal('warning', 'Please input name!', false, true, 2500);
        // }

        // if(!category_travel){
        //     return showSwal('warning', 'Please select category!', false, true, 2500);
        // }
        // showSwal('loading', 'Please wait while we process your request.');
        
        // $.ajax({
        //     type: 'POST',
        //     url: '<?php echo site_url('admin/travel_arrangement/add_travel_arrangement') ?>',
        //     dataType: 'JSON',
        //     data: {
        //         grantee_grant_id : grantee_grant_id,
        //         name : name_travel,
        //         category : category_travel
        //     },
        //     success: function(r) {
        //         Swal.close(); 
        //         if(r.success){
        //             let template = '';
        //             if(category_travel == 'Domestic Ticket'){
        //                 template = $('#applicant-template-domestic').html();
        //             }else if(category_travel == 'International Ticket'){
        //                 template = $('#applicant-template-international').html();
        //             }else if(category_travel == 'Parent Travel Arrangement'){
        //                 template = $('#applicant-template-parent').html();
        //             }else if(category_travel == 'US Departure'){
        //                 template = $('#applicant-template-us-departure').html();
        //             }else{
        //                 template = $('#applicant-template-returning').html();
        //             }
                    
        //             if(!template){
        //                 return showSwal('error', 'Template not found for category: ' + category_travel, false, true, 2500);
        //             }

        //             const replacements = {
        //                 '{index}': i,
        //                 '{travel_id}': r.id,
        //                 '{label_name}': name_travel,
        //                 '{category_travel}': category_travel,
        //                 '{university_name}': r.data.university_name ?? '',
        //                 '{university_id}': r.data.university_id ?? '',
        //                 '{start_date}': r.data.start_date ?? '',
        //                 '{end_date}': r.data.end_date ?? '',
        //                 '{dep_date}': r.data.dep_date ?? '',
        //                 '{arr_date}': r.data.arr_date ?? '',
        //             };

        //             for (const key in replacements) {
        //                 template = template.replaceAll(key, replacements[key]);
        //             }
                    
        //             $('#accordionTravel0').append(template);
        //             setTimeout(() => {
        //                 $('#accordionTravel0 .datepicker').datepicker({
        //                     changeMonth: true,
        //                     changeYear: true,
        //                     dateFormat: "dd M yy"
        //                 });
        //                 $('#accordionTravel0 .select2').select2({
        //                     theme: 'bootstrap'
        //                 });
        //             }, 50);
        //             $('#show_transportation_' + i).trigger('change');
        //             $('#show_accomodation_' + i).trigger('change');
        //             $('#name_travel').val('');
        //             $('#category_travel').val('');
        //             showSwal('success', 'Successfully added', false, true, 1500);
        //         }else{
        //             showSwal('error', 'Failed add visa.', false, true, 1500);
        //         }

        //     }
        // });
        // $(".datepicker").datepicker({
        //     changeMonth: true,
        //     changeYear: true,
        //     dateFormat: "dd M yy",
        //     yearRange: "<?php echo date('Y') - 1 ?>:<?php echo date('Y') + 20 ?>"
        // });
        // $('.select2').select2({
        //     theme: 'bootstrap'
        // });
        
    });
    
    $(document).on('click', '.removeApplicant', function() {
        if (confirm("Are you sure want to delete this ?")){
            var travel_id = $(this).data('travel_id');
            var $element = $(this).closest('.travelArrangement-item')
            
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/travel_arrangement/delete_travel/') ?>' + travel_id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $element.remove();
                        showSwal('success', 'Successfully delete', false, true, 1500);
                    }
                }
            });
        }
    });

    $(document).on('click', '.btn-noaction', function(e) {
        e.stopPropagation();
        e.preventDefault();

    });

    function set_session(sessionValue)
    {
        $.ajax({
            url: '<?= base_url('world/set_session') ?>',
            type: 'POST',
            data: { sessionKey: 'last_list', sessionValue: sessionValue }
        });

    }


    function show_hide_transportation(obj, section, index){
        $element = $(obj).val();
        $isreturning = $(obj).data('isreturning');
        if($element == 'No' || $element == ''){
            $('.section-transportation-'+section+'-'+index).addClass('hide');
            if (section === 'domestic') {
                $('.procedure_domestic').addClass('hide');
            }
        }else{
            $('.section-transportation-'+section+'-'+index).removeClass('hide');
            if (section === 'domestic') {
                $('.procedure_domestic').removeClass('hide');
            }
        }

        if($element == 'Reimbursement'){
            $('#label_eticket_'+section+'_'+index).html('Receipt')
            $('.returing_section_'+section+'_'+index).addClass('hide')
            $('#returning_date_'+section+'_'+index).removeClass('hide')
            $('#travel_agen_general_'+section+'_'+index).removeClass('hide')
            $('.label-transport-'+section+'-'+index).addClass('hide')
        }else if($element == 'Third Party'){
            $('#label_eticket_'+section+'_'+index).html('E-ticket')
            $('.returing_section_'+section+'_'+index).addClass('hide')
            $('#returning_date_'+section+'_'+index).removeClass('hide')
            $('#travel_agen_general_'+section+'_'+index).removeClass('hide')
            $('.label-transport-'+section+'-'+index).addClass('hide')
        }else if($element == 'Departure Reimbursement'){
            $('#label_eticket_'+section+'_'+index).html('Receipt')
            $('.returing_section_'+section+'_'+index).removeClass('hide')
            $('#returning_date_'+section+'_'+index).addClass('hide')
            $('#travel_agen_general_'+section+'_'+index).addClass('hide')
            $('#travel_agen_returning_'+section+'_'+index).removeClass('hide')
            $('.label-transport-'+section+'-'+index).removeClass('hide')
        }else if($element == 'Return Reimbursement'){
            $('#label_eticket_'+section+'_'+index).html('Departure E-ticket')
            $('#label_eticket_returning_'+section+'_'+index).html('Receipt')
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
        if ($isreturning) {
            const showHeader = $('.select-transport-returning-' + index).is(function () {
                return $(this).val() === 'Yes' || $(this).val() === 'Reimbursement' || $(this).val() === 'Departure Reimbursement' || $(this).val() === 'Return Reimbursement' || $(this).val() === 'Third Party';
            });
            $('.header-transport-' + index).toggleClass('hide', !showHeader);
        }

        // cek label international
        if(section === 'international'){
            const isDegree = <?= $grantee_grant->is_degree ? 'true' : 'false' ?>;

            if($element === 'Third Party'){
                $('.label-international-' + index).removeClass('hide');
            }else if($element === 'Yes' || $element == 'Reimbursement'){
                // if(!isDegree){
                //     $('.label-international-' + index).addClass('hide');
                // }else{
                // }
                $('.label-international-' + index).removeClass('hide');
            }else{
                // if(!isDegree){
                // }
                $('.label-international-' + index).addClass('hide');
            }
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


    $(document).on('click', '.edit_name', function(e){
        $('#edit_name').val(null);
        var id = $(this).data('id');
        var name = $(this).data('name');
        $("#mdl_edit_name").modal();   
        $('#id_for_edit_name').val(id);
        $('#edit_name').val(name); 
        event.preventDefault();
    });


    $("#form_edit_name").on("submit", function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var form = document.getElementById('form_edit_name');
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function(response){
                if(response){
                    $('#label_name_' + response.id).html(response.name);
                    $("#mdl_edit_name").modal('hide');   
                    $('#id_for_edit_name').val('');
                    $('#edit_name').val(''); 
                    showSwal('success', 'Successed update name', false, true, 2500);
                }else{
                    showSwal('danger', 'Failed update name', false, true, 2500);
                }
            }
        });
    });


    function enable_toogle(element, fields) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        var id = $(element).data('id')
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/travel_arrangement/enable_toogle_travel/') ?>'+ id + '/' + isChacked + '/' + fields,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }
    
    function delete_file_visa(el, field, is_admin) {
        if (confirm("Are you sure want to delete this ?")){
            var id = $(el).data('id');
            if(is_admin){
                var urlAjax = '<?php echo site_url('admin/travel_arrangement/delete_file_visa') ?>';
            }else{
                var urlAjax = '<?php echo site_url('grantee/submission/delete_file_travel_arrangement') ?>';
            }
            $.ajax({
                type: 'POST',
                url: urlAjax,
                data:{
                    id:id,
                    field:field
                },
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $('#file_'+field+'_'+id).remove();
                        showSwal('success', 'Successfully delete the file', false, true, 1500);
                    }
                }
            });
        }

    }

    $('#btn-migrate-grantee').on('click', function(e){
        e.preventDefault();
        var id = $(this).data('grantee-id');
        // if (!confirm('Migrate travel arrangement for grantee '+id+'?')) return;

        var $btn = $(this);
        $btn.prop('disabled', true).text('Starting...');
        // $('#migrate-output').text('Starting...');

        // for testing result
        // $.ajax({
        //     url: '<?php echo site_url("admin/travel_arrangement/migrate_grantee/"); ?>' + id,
        //     method: 'POST',
        //     dataType: 'json',
        //     success: function(res){
        //         $btn.prop('disabled', false).text('Migrate Travel for this Grantee');
        //         $('#migrate-output').text(JSON.stringify(res, null, 2));
        //     },
        //     error: function(xhr, s, e){
        //         $btn.prop('disabled', false).text('Migrate Travel for this Grantee');
        //         $('#migrate-output').text('Error: '+xhr.responseText);
        //     }
        // });


        // actual migration
        Swal.fire({
            title: "Syncing Please Wait...",
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '<?php echo site_url("admin/travel_arrangement/migrate_grantee/"); ?>' + id,
            method: 'POST',
            data: {is_button:true},
            dataType: 'json',
            success: function(res) {

                const report = res.report;
                Swal.fire({
                    icon: "success",
                    title: "Sync Complete!",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                Swal.fire("Error", "Failed to sync data", "error");
            }
        });
    });

    $('.add_child').on('click', function(){
        var parentName = $(this).data('parentname');
        var parentId = $(this).data('parentid');
        var currentKey = $(this).data('currentkey');var d = new Date();
        var name_travel = parentName + ' test on ' + 
            d.toLocaleDateString('id-ID', { month: 'long' }) + ' ' +
            d.toLocaleDateString('id-ID', { day: '2-digit' }) + ', ' +
            d.toLocaleDateString('id-ID', { year: 'numeric' });

        // $('.modal-title-child').html('Add ' + parentName);

        // $('.btnSaveChild').off().on('click', function() {
            saveTravelArrangement({
                name_travel: name_travel,
                category_travel: 'Domestic Ticket',
                parent_id: parentId,
                grantee_grant_id: is_admin ? '<?= $grantee_grant_id ?>' : '<?= $this->session->userdata('grantee_grant_id') ?>',
                append_to: '.panel-parent-' + parentId + currentKey,
                currentKey: currentKey
            });
        // });
    });

    function saveTravelArrangement({ 
        name_travel, 
        category_travel, 
        grantee_grant_id,
        parent_id = 0,
        append_to = '#accordionTravel0',
        currentKey = ''
    }) {
        if (!name_travel) {
            return showSwal('warning', 'Please input name!', false, true, 2500);
        }
        if (!category_travel) {
            return showSwal('warning', 'Please select category!', false, true, 2500);
        }

        showSwal('loading', 'Please wait while we process your request.');

        let i = $('.travelArrangement-item').length;
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/travel_arrangement/add_travel_arrangement') ?>',
            dataType: 'JSON',
            data: {
                grantee_grant_id : grantee_grant_id,
                name : name_travel,
                category : category_travel,
                parent_id : parent_id
            },
            success: function(r) {
                Swal.close(); 
                if(r.success){
                    let template = '';
                    if(category_travel == 'Domestic Ticket'){
                        template = $('#applicant-template-domestic').html();
                    }else if(category_travel == 'International Ticket'){
                        template = $('#applicant-template-international').html();
                    }else if(category_travel == 'Parent Travel Arrangement'){
                        template = $('#applicant-template-parent').html();
                    }else if(category_travel == 'US Departure'){
                        template = $('#applicant-template-us-departure').html();
                    }else{
                        template = $('#applicant-template-returning').html();
                    }
                    
                    if(!template){
                        return showSwal('error', 'Template not found for category: ' + category_travel, false, true, 2500);
                    }

                    const replacements = {
                        '{index}': i,
                        '{travel_id}': r.id,
                        '{label_name}': name_travel,
                        '{category_travel}': category_travel,
                        '{university_name}': r.data.university_name ?? '',
                        '{university_id}': r.data.university_id ?? '',
                        '{start_date}': r.data.start_date ?? '',
                        '{end_date}': r.data.end_date ?? '',
                        '{dep_date}': r.data.dep_date ?? '',
                        '{arr_date}': r.data.arr_date ?? '',
                    };

                    for (const key in replacements) {
                        template = template.replaceAll(key, replacements[key]);
                    }
                    
                    $(append_to).append(template);
                    setTimeout(() => {
                        $('#accordionTravel0 .datepicker').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "dd M yy"
                        });
                        $('#accordionTravel0 .select2').select2({
                            theme: 'bootstrap'
                        });
                    }, 50);
                    $('#show_transportation_' + i).trigger('change');
                    $('#show_accomodation_' + i).trigger('change');
                    $('#name_travel').val('');
                    $('#category_travel').val('');
                    // showSwal('success', 'Successfully added', false, true, 1500);
                    Swal.fire({
                        icon: "success",
                        title: "Successfully added",
                        confirmButtonText: "OK"
                    }).then(() => {
                        if(parent_id > 0){
                            $('#mdl_add_child').modal('hide');
                            $('#name_child').val('');
                            $('#category_travel_child').val('');
                            location.reload();
                        }
                    });
                }else{
                    showSwal('error', 'Failed add visa.', false, true, 1500);
                }

            }
        });
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 1 ?>:<?php echo date('Y') + 20 ?>"
        });
        $('.select2').select2({
            theme: 'bootstrap'
        });
    }


    tinymce.init({
        selector: '.editor_grantee',
        plugins: 'link table',
        // toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | fontsizeselect',
        contenteditable: true,
        spellchecker: false,
        readonly: true
    });

    function rewrite(el, index, firstLoad = false) {
        var text = $(el).val();
        var target = $('#departure_city_academic_program_' + index);

        // hanya isi kalau target masih kosong
        if (!firstLoad) {
            target.val(text);
        }

    }

    // LETTER GRADUATE SCHOOL
    $(document).on('click', '.js-upload-graduate-school', function (e) {
        e.preventDefault();

        const grantId = $(this).data('id');
        $('#upload_graduate_school_' + grantId).trigger('click');
    });

    $(document).on('change', '[id^="upload_graduate_school_"]', function () {
        const input = this;
        if (!input.files.length) return;

        const grantId = input.id.replace('upload_graduate_school_', '');
        const session = $(this).data('keysession');
        const button = $('.js-upload-graduate-school[data-id="' + grantId + '"]');
        const data = new FormData();

        data.append('file', input.files[0]);
        data.append('grantee_grant_id', grantId);
        data.append('session', session);

        $.ajax({
            url: button.data('url'),
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json'
        }).done(function (response) {
            if (!response.success) {
                show_toast_message(response.message || 'Failed to upload', 'error');
                return;
            }

            const grantId = button.data('id');
            const uploadBtn = $('.js-upload-graduate-school');
            const deleteBtn = $('.btn-del-letter_from_graduate_school');
            const tbody = $('#letter_from_graduate_school_list_' + grantId);
            const row = tbody.find('tr').first();
            const cells = row.children('td');

            const fileLink = $('<a>', {
                href: response.url,
                class: 'lightbox',
                text: response.filename
            }).css('color', '#337ab7');


            if (row.find('.js-file-cell').length) {
                row.find('.js-file-cell').empty().append(fileLink);
                row.find('.js-status-cell').text(response.status);
                row.find('.js-date-cell').text(response.created_date);
            } else if (cells.length > 4) {
                cells.eq(1).empty().append(fileLink);
                cells.eq(2).text(response.status);
                cells.eq(3).text(response.created_date);
            } else {
                cells.eq(0).empty().append(fileLink);
                cells.eq(1).text(response.status);
                cells.eq(2).text(response.created_date);
            }

            const recordId = Number(response.id);
            const isAdmin = String(tbody.data('is-admin')) === '1';

            if (isAdmin) {
                row.find('.js-approve-graduate-school')
                    .attr('onclick', `update_status_graduate_school(this, ${recordId}, 'approve')`)
                    .removeClass('hide');

                row.find('.js-revise-graduate-school')
                    .attr('onclick', `update_status_graduate_school(this, ${recordId}, 'revise')`)
                    .removeClass('hide');

                row.find('.modal-log')
                    .attr('data-log', recordId)
                    .removeClass('hide');
            }

            row.find('.btn-del-letter_from_graduate_school')
                .attr('onclick', `del_file_graduate_school(this, ${recordId})`);

            if (isAdmin) {
                row.find('.btn-del-letter_from_graduate_school').removeClass('hide');
            }
            uploadBtn.addClass('hide')
            deleteBtn.addClass('hide')
            $('.lightbox').topbox();
            show_toast_message('Successfully uploaded.');


        }).fail(function () {
            show_toast_message('Upload failed. Please try again.');
        }).always(function () {
            input.value = '';
        });
    });

    function update_status_graduate_school(el, id, status) {
        if (confirm("Are you sure want to "+status+" this ?"))
            if(status == 'revise'){
                $('#mdl_note_revise').modal()
                $('#btn-save-note').attr("onclick","update_status_graduate_school_action("+ id +", '"+ status +"')"); 
            }else{
                update_status_graduate_school_action(id, status);
            }
    }

    function update_status_graduate_school_action(id, status) {
        var note = $('#note_revise').val();
        var modal = $('#mdl_note_revise');
        var fileInput = modal.find('input[type="file"][name="temp_attachment_revise"]')[0] || modal.find('#temp_attachment_revise')[0];
        var btnSave = $('#btn-save-note');

        var doSave = function(attachment_revise) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/travel_arrangement/update_status_graduate_school') ?>',
                data: {
                    id: id,
                    status: status,
                    note: note,
                    attachment_revise: attachment_revise
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
                url: '<?= site_url('admin/grantee/save_file')?>',
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



    $(document).on('click', '.modal-log', function(e){
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

    function del_file_graduate_school(button, id) {
        if (!window.confirm('Are you sure?')) return;

        const $button = $(button);
        $button.prop('disabled', true);

        $.ajax({
            url: $button.data('url'),
            type: 'POST',
            dataType: 'json',
            data: { id: id }
        }).done(function (response) {
            if (!response.success) {
                alert(response.message || 'Failed delete data.');
                return;
            }

            const $row = $button.closest('tr');
            if ($row.find('.js-file-cell').length) {
                $row.find('.js-file-cell').empty();
                $row.find('.js-status-cell').empty();
                $row.find('.js-date-cell').empty();
            } else if ($row.children('td').length > 4) {
                $row.children('td').eq(1).empty();
                $row.children('td').eq(2).empty();
                $row.children('td').eq(3).empty();
            } else {
                $row.children('td').eq(0).empty();
                $row.children('td').eq(1).empty();
                $row.children('td').eq(2).empty();
            }
            $row.find('.show-button').addClass('hide');
            $row.find('.js-upload-graduate-school').removeClass('hide');
            show_toast_message('Successfully deleted.');
        }).fail(function () {
            alert('Something wrong.');
        }).always(function () {
            $button.prop('disabled', false);
        });
    }

    // ADDITIONAL HEALTH INSURANCE
    $(document).on('click', '.js-upload-health-insurance', function (e) {
        e.preventDefault();

        const grantId = $(this).data('id');
        $('#upload_health_insurance_' + grantId).trigger('click');
    });

    $(document).on('change', '[id^="upload_health_insurance_"]', function () {
        const input = this;
        if (!input.files.length) return;

        const grantId = input.id.replace('upload_health_insurance_', '');
        const session = $(this).data('keysession');
        const button = $('.js-upload-health-insurance[data-id="' + grantId + '"]');
        const data = new FormData();

        data.append('file', input.files[0]);
        data.append('grantee_grant_id', grantId);
        data.append('session', session);

        $.ajax({
            url: button.data('url'),
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json'
        }).done(function (response) {
            if (!response.success) {
                show_toast_message(response.message || 'Failed to upload', 'error');
                return;
            }

            const row = $('#row_health_insurance_' + grantId);
            const fileLink = $('<a>', {
                href: response.url,
                class: 'lightbox',
                text: response.filename
            }).css('color', '#337ab7');

            row.find('.js-file-cell-health-insurance').empty().append(fileLink);
            row.find('.js-status-cell-health-insurance').text(response.status);
            row.find('.js-date-cell-health-insurance').text(response.created_date);

            const recordId = Number(response.id);
            const isAdmin = row.closest('tbody').data('is-admin') === 1 || String(row.closest('tbody').data('is-admin')) === '1';

            if (isAdmin) {
                row.find('.js-approve-health-insurance')
                    .attr('onclick', `update_status_health_insurance(this, ${recordId}, 'approve')`)
                    .removeClass('hide');

                row.find('.js-revise-health-insurance')
                    .attr('onclick', `update_status_health_insurance(this, ${recordId}, 'revise')`)
                    .removeClass('hide');

                row.find('.js-log-health-insurance')
                    .attr('data-log', recordId)
                    .removeClass('hide');
            }

            row.find('.btn-del-health_insurance')
                .attr('onclick', `del_file_health_insurance(this, ${recordId})`);

            if (isAdmin) {
                row.find('.btn-del-health_insurance').removeClass('hide');
            }
            row.find('.js-upload-health-insurance').addClass('hide');
            row.find('.btn-del-health_insurance').addClass('hide');
            $('.lightbox').topbox();
            show_toast_message('Successfully uploaded.');

        }).fail(function () {
            show_toast_message('Upload failed. Please try again.');
        }).always(function () {
            input.value = '';
        });
    });

    function update_status_health_insurance(el, id, status) {
        if (confirm("Are you sure want to "+status+" this ?"))
            if(status == 'revise'){
                $('#mdl_note_revise').modal()
                $('#btn-save-note').attr("onclick","update_status_health_insurance_action("+ id +", '"+ status +"')"); 
            }else{
                update_status_health_insurance_action(id, status);
            }
    }

    function update_status_health_insurance_action(id, status) {
        var note = $('#note_revise').val();
        var modal = $('#mdl_note_revise');
        var fileInput = modal.find('input[type="file"][name="temp_attachment_revise"]')[0] || modal.find('#temp_attachment_revise')[0];
        var btnSave = $('#btn-save-note');

        var doSave = function(attachment_revise) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/travel_arrangement/update_status_health_insurance') ?>',
                data: {
                    id: id,
                    status: status,
                    note: note,
                    attachment_revise: attachment_revise
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
                url: '<?= site_url('admin/grantee/save_file')?>',
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

    function del_file_health_insurance(button, id) {
        if (!window.confirm('Are you sure?')) return;

        const $button = $(button);
        $button.prop('disabled', true);

        $.ajax({
            url: $button.data('url'),
            type: 'POST',
            dataType: 'json',
            data: { id: id }
        }).done(function (response) {
            if (!response.success) {
                alert(response.message || 'Failed delete data.');
                return;
            }

            const $row = $button.closest('tr');
            $row.find('.js-file-cell-health-insurance').empty();
            $row.find('.js-status-cell-health-insurance').empty();
            $row.find('.js-date-cell-health-insurance').empty();
            $row.find('.show-button').addClass('hide');
            $row.find('.js-upload-health-insurance').removeClass('hide');
            show_toast_message('Successfully deleted.');
        }).fail(function () {
            alert('Something wrong.');
        }).always(function () {
            $button.prop('disabled', false);
        });
    }

</script>