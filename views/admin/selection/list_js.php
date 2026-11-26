<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(document).ready(function () {
        
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
        $( ".dateWithRange" ).daterangepicker({
            autoUpdateInput: false,
            locale: {
                // format: 'DD-MMM-YYYY',
                cancelLabel: 'Clear'
            }
        });

        $('.dateWithRange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            document.forms.frm_manage.submit()
        });

        $('.dateWithRange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            document.forms.frm_manage.submit()
        });

        $( ".dateRangePicker" ).daterangepicker({
            autoUpdateInput: false,
            locale: {
                // format: 'DD-MMM-YYYY',
                cancelLabel: 'Clear'
            }
        });

        $('.dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('.dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    })

    $(".succesfully").click(function(){
        var id = $(this).data('id');
        var grantee_id = "";
        if ($(this).data('grantee_id') != undefined) {
            grantee_id = $(this).data('grantee_id');
        }
        $("#mdl_info").modal();   
        $('#btn-successful').attr("onclick","succesfully("+ id +","+ grantee_id +")"); 
        event.preventDefault();
    });

    $(".submitted").click(function(){
        var id = $(this).data('id');
        var grantee_id = "";
        if ($(this).data('grantee_id') != undefined) {
            grantee_id = $(this).data('grantee_id');
        }
        $("#mdl_info").modal();   
        $('#btn-successful').attr("onclick","submitted("+ id +","+ grantee_id +")"); 
        event.preventDefault();
    });

    function succesfully(grantee_grant_id, grantee_id = "")
    {
        $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
        $.ajax({
                url: "<?= base_url(); ?>admin/selection/successfully",
                method: "POST",
                dataType: 'JSON',
                data: {
                    grantee_grant_id: grantee_grant_id,
                    grantee_id : grantee_id
                }
            })
            .success(function(data){
                window.location.href = data.redirect;
            })
    }

    function submitted(grantee_grant_id, grantee_id = "")
    {
        $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
        $.ajax({
                url: "<?= base_url(); ?>admin/selection/set_to_submitted",
                method: "POST",
                dataType: 'JSON',
                data: {
                    grantee_grant_id: grantee_grant_id,
                    grantee_id : grantee_id
                }
            })
            .success(function(data){
                window.location.href = data.redirect;
            })
    }
	
	function add_filter() {
		var html = $('#template-filter').html();
		$('#wrap-filter').append(html);
	}
	
	function remove_filter(el) {
		$(el).parent().remove();
	}
	
	function submitFilter(e) {
		if (e.keyCode == 13) {
			$('#frm_manage').submit();
			return false;
		}
	}

    function show_download_modal(params) {
        var url = "<?php echo site_url('admin/grantee/download_excel?') ?>" + params;
        $('.field-alumni').prop('checked', true);
        $('.text-validation').removeClass('d-block');
        $('.text-validation').addClass('d-none');
        $('#form-download-excel').attr('action', url);
        $('#modalDownload').modal('show');
    }

    $('#modalDownload').on('show.bs.modal', function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            $('.select2').select2({
                theme: 'bootstrap'
            });
        };
    });

    function show_download_modal_selection(params, section) {
        var addParam = '';
        var label = 'Download Excel Invterview'
        if(section == 'review'){
            label = 'Download Excel Review'
        }

        if(params == ''){
            if(section == 'interview'){
                addParam = 'section=interview'
            }else{
                addParam = 'section=review'
            }
        }else{
            if(section == 'interview'){
                addParam = '&section=interview'
            }else{
                addParam = '&section=review' 
            }
        }

        if(section == 'review'){
            $('.filter-daterange').addClass('hide')
            $('.filter-grant').removeClass('col-lg-12').addClass('col-lg-6');
        }else{
            $('.filter-grant').addClass('col-lg-12').removeClass('col-lg-6');
            $('.filter-daterange').removeClass('hide')
        }
        var url = "<?php echo site_url('admin/grantee/download_excel_selection?') ?>" + params + addParam ;
        $('.field-alumni').prop('checked', true);
        $('.text-validation').removeClass('d-block');
        $('.text-validation').addClass('d-none');
        $('#form-download-excel-selection').attr('action', url);
        $('#modalDownloadSelection').modal('show');
        $('#exampleModalLabel').text(label);
    }

    $('#active_grant_id, #select_period').change(function(){
        let selection = $('#active_grant_id').data('selection') ?? 0;
        let grantId = $('#active_grant_id').val();
        let periodId = $('#select_period').val();
        let selectedOptionText = $('#active_grant_id option:selected').text();
        $("#selected-active-grant").text("List Fields of " + selectedOptionText);
        $('.add_fields').html('');

        if(!selection){
            $.ajax({
                async: false,
                type: 'GET',
                url: '<?php echo site_url('admin/selection/get_all_field/') ?>' + grantId + '/' + periodId,
                dataType: 'JSON',
                success: function(data) {
                    $('#text-validation-active-grant').removeClass('d-block');
                    $('#text-validation-active-grant').addClass('d-none');
                    $('.field_row').removeClass('hide');
                    $('.add_fields').append(data.html);
    
    
    
    
                    $('#select_period').html('');
                    $('#select_period').append('<option value="">-- Select Period --</option>');
                    $.each(data.periods, function(id, val) {
                        var selected = '';
                        if(val.id == periodId) {
                            selected = 'selected';
                        }
                        $('#select_period').append('<option '+selected+' value="' + val.id + '">' + val.fiscal_year + '</option>');
                        $('.selectpicker').selectpicker('refresh');
                    });
                }
            });
        }else{
            $.ajax({
                async: false,
                type: 'GET',
                url: '<?php echo site_url('admin/new_selection/get_main_teaching/') ?>' + grantId + '/' + periodId,
                dataType: 'JSON',
                success: function(data) {
                    $('#text-validation-active-grant').removeClass('d-block');
                    $('#text-validation-active-grant').addClass('d-none');
                    $('.field_row').removeClass('hide');
                    $('.add_fields').append(data.html);
                }
            });

        }
    });

    $('#form-download-excel').submit(function(e) {
        if ($('.grant-alumni:checked').size() == 0) {
            $('#text-validation-grant').removeClass('d-none');
            $('#text-validation-grant').addClass('d-block');
            e.preventDefault();
        }
        else {
            $('#text-validation-grant').removeClass('d-block');
            $('#text-validation-grant').addClass('d-none');
        }

        if ($('.field-alumni:checked').size() == 0) {
            $('#text-validation-field').removeClass('d-none');
            e.preventDefault();
        }
        else {
            $('#text-validation-field').addClass('d-none');
        }

        if($('#active_grant_id').val() == ''){
            $('#text-validation-active-grant').removeClass('d-none');
            $('#text-validation-active-grant').addClass('d-block');
            e.preventDefault();
        }
        else {
            $('#text-validation-active-grant').removeClass('d-block');
            $('#text-validation-active-grant').addClass('d-none');
        }
    });

    $('#form-download-excel-selection').submit(function(e) {
        if($('#active_grant_id').val() == ''){
            $('#text-validation-active-grant').removeClass('d-none');
            $('#text-validation-active-grant').addClass('d-block');
            e.preventDefault();
        }
        else {
            $('#text-validation-active-grant').removeClass('d-block');
            $('#text-validation-active-grant').addClass('d-none');
        }
    });
	
    $('#sel-all').click (function () {
        $('.field-alumni').prop('checked', this.checked);
    });

    $('#sel-all-field').click (function () {
        $('.field').prop('checked', this.checked);
    });

    $( ".sortable" ).sortable();
	function submitFilter(e) {
		if (e.keyCode == 13) {
			$('#loading_data').css('display', 'block');
			$('#frm_manage').submit();
			return false;
		}
	}

    function formSubmit(e) {
        $('#loading_data').css('display', 'block');
        $('#frm_manage').submit();
    }

    const form_download_excel = $("#form-download-excel");
    const progress_dialog = $("#progress-dialog");
    form_download_excel.on('submit', (e) => {
        e.preventDefault();
        progress_dialog.modal('show');
        $('#modalDownload').modal('hide');

        const form_data = new FormData(form_download_excel[0]);

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/grantee/download_excel/'); ?>',
            data: form_data,
            processData: false,
            contentType: false,
            success: function (response) {
                const file = JSON.parse(response);
                if (file.fileurl === null) {
                    progress_dialog.modal('hide');
                    alert('Data not available');
                    return false;
                }

                var link = document.createElement('a');
                link.href = file.fileurl;
                link.download = file.filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                progress_dialog.modal('hide');
            },
            error: function (error) {
                progress_dialog.modal('hide');
                alert('Download failed');
            }
        });
    });

    // for confirm reject
    $(".reset").click(function(){
        var id = $(this).data('id');
        var section = $(this).data('section');
        $("#mdl_info").modal();   
        $('#btn-successful').attr("onclick","reset_data_validation_review("+ id +")"); 
        event.preventDefault();
    });

    $('.select2').select2({
        theme: 'bootstrap',
        placeholder : 'Select Active Grant',
        maximumSelectionLength:2,
        width: '100%'
    });

    function reset_data_validation_review (id) {
        $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
        $.ajax({
                url: "<?= base_url(); ?>admin/new_selection/reset_data_validation_review",
                method: "POST",
                dataType: 'JSON',
                data: {
                    grantee_grant_id: id,
                    redirect: '<?= current_full_url() ?>'
                }
            })
            .success(function(data){
                window.location.href = data.redirect;
            })
    }

    function show_preview(element, type, upload_type) {
        const file = element.files[0];
        // const filetype = file.name.split('.').pop();
        // const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc'];

        // const is_valid_extension = allowed_extensions.some(function(extension) {
        //     return filetype.toLowerCase().endsWith(extension);
        // });

        // if (is_valid_extension > 0) {
           
        // } else {
        //     let current_src = $('#preview_image_' + type).attr('src');
        //     $('#preview_image_' + type).attr('src', current_src);
        // }
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

    // function showReason(element) {
    //     var note = $(element).data('note')
    //     var attach = $(element).data('attach')
    //     var url = '';
    //     var show = 'd-none';
    //     if(attach){
    //         url = '<?= base_url() ?>'+attach
    //         show = ''
    //     }
    //     Swal.fire({
    //         title: 'View Note',
    //         html: `
    //             <div>
    //                 <textarea class="form-control" readonly rows="6" style="resize: none;">`+note+`</textarea>    
    //             </div>
    //             <div class="mt-2">
    //                 <a href="`+url+`" target="_blank" class="btn btn-primary `+show+`">Attachment</a>
    //             </div>
    //         `,
    //         width: '600px',
    //         showConfirmButton: false, 
    //         showCancelButton: false,
    //         cancelButtonText: 'Close',
    //         customClass: {
    //             popup: 'custom-swal-width'
    //         }
    //     });
    // }
    
    $(document).on('click', '.send_email_recommendation', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var section = $(this).data('section');

        // Reset modal
        $('#email-recommendation-loading').show();
        $('#email-recommendation-content').hide();
        $('#email-recommendation-error').hide().text('');
        $('#email-recommendation-cards').empty();

        $('#btn-send-email-recommendation')
            .prop('disabled', true)
            .text('Trigger & Send Emails');

        // Simpan data untuk tombol Send Email
        $('#send-email-recommendation-modal')
            .data('id', id)
            .data('section', section)
            .modal('show');

        // Get recipient list
        $.ajax({
            url: "<?= base_url(); ?>admin/selection/get_email_recommendation_list",
            method: "POST",
            dataType: "JSON",
            data: {
                grantee_grant_id: id,
                section: section
            }
        })
        .done(function(data) {

            $('#email-recommendation-loading').hide();

            if (!data.status) {
                $('#email-recommendation-error')
                    .text(data.message || 'Failed to get recipient list.')
                    .show();
                return;
            }

            // Populate Grantee Info
            if (data.grantee) {
                $('#rec-grantee-name').text(data.grantee.name || '-');
                $('#rec-grantee-program').text(data.grantee.program || '-');
                $('#rec-grantee-period').text(data.grantee.period || '-');
                $('#rec-grantee-status').text(data.grantee.status || '-');
                // $('#rec-template-link').attr('href', '/admin/email-templates?program=' + encodeURIComponent(data.grantee.program || '') + '&period=' + encodeURIComponent(data.grantee.period || ''));
                var urlTemplate = "<?= base_url(); ?>admin/user_grantee_grant/edit_period/"+data.grantee.grant_id+"/"+data.grantee.period_id+"?pid=email_template";
                $('#rec-template-link').attr('href', urlTemplate);
            }

            var recommenders = data.recommenders || data.data || [];
            var count = recommenders.length;
            $('#rec-recipient-count').text('Target Recipients (' + count + ' Recommender' + (count > 1 ? 's' : '') + ')');

            var cardsHtml = '';
            $.each(recommenders, function(index, rec) {
                var contactHtml = '';
                if (rec.phone) {
                    contactHtml += '<span>Phone: ' + $('<div>').text(rec.phone).html() + '</span>';
                }
                if (rec.phone && rec.email) {
                    contactHtml += ' &bull; ';
                }
                if (rec.email) {
                    contactHtml += '<a href="mailto:' + $('<div>').text(rec.email).html() + '" style="color: #20639b;">' + $('<div>').text(rec.email).html() + '</a>';
                }
                if (!rec.phone && !rec.email && rec.contact) {
                    contactHtml += '<span>' + $('<div>').text(rec.contact).html() + '</span>';
                }
                if (!contactHtml) {
                    contactHtml = '-';
                }

                var statusBadge = '';
                var fileUpload = '';
                var resendButton = '';
                if (rec.status === 'submitted') {
                    statusBadge = '<span class="label label-success" style="font-size:10px;padding:3px 7px;">Submitted</span>';
                } else if (rec.status === 'excluded') {
                    statusBadge = '<span class="label label-default" style="font-size:10px;padding:3px 7px;">Excluded</span>';
                } else if (rec.status === 'sent' || rec.status === 'draft') {
                    statusBadge = '<span class="label label-info" style="font-size:10px;padding:3px 7px;">Email Sent</span>';
                } else {
                    statusBadge = '<span class="label label-default" style="font-size:10px;padding:3px 7px;">Not Sent</span>';
                }
                if (rec.file_name) {
                    fileUpload += '<tr>' +
                        '<td class="lbl">File</td>' +
                        '<td class="val" colspan="3">' +
                            '<div style="display: flex; gap: 4px;">' +
                                '<a href="<?= base_url() ?>' + $('<div>').text(rec.file_path).html() + '" target="_blank" style="color:#4480ae;font-size:11px;font-weight:600;">' +
                                    '<i class="fa fa-paperclip"></i> ' +
                                    $('<div>').text(rec.file_name).html() +
                                '</a>' +
                            '</div>' +
                        '</td>' +
                    '</tr>';
                }

                if(rec.status === 'submitted' || rec.status === 'sent') {
                    resendButton += '<div class="recommender-card-footer">'+
                                        '<button data-id="' + $('<div>').text(rec.id_recommender).html() +'" type="button" class="btn btn-warning btn-xs pull-right btn-resend-recommender">Resend and Reset</button>'+
                                    '</div>';
                }

                cardsHtml += `
                    <div class="recommender-card">
                        <div class="recommender-card-head">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="rec-badge">RECOMMENDER #${rec.index}</span>
                                ${statusBadge}
                            </div>
                            <span style="color: #666; font-size: 11px;">Token: <code>${rec.token}</code></span>
                        </div>
                        <table class="table-rec">
                            <tr>
                                <td class="lbl">Full Name</td>
                                <td class="val"><b>${$('<div>').text(rec.full_name || '-').html()}</b></td>
                                <td class="lbl">Relationship</td>
                                <td class="val">${$('<div>').text(rec.relationship || '-').html()}</td>
                            </tr>
                            <tr>
                                <td class="lbl">Institution</td>
                                <td class="val">${$('<div>').text(rec.institution || '-').html()}</td>
                                <td class="lbl">Position / Title</td>
                                <td class="val">${$('<div>').text(rec.position || '-').html()}</td>
                            </tr>
                            <tr>
                                <td class="lbl">Contact</td>
                                <td class="val" colspan="3">${contactHtml}</td>
                            </tr>
                            <tr>
                                <td class="lbl">Form Link</td>
                                <td class="val" colspan="3">
                                    <div style="display: flex; gap: 4px;">
                                        <input type="text" readonly value="${$('<div>').text(rec.form_link).html()}" class="link-input">
                                        <button type="button" class="btn-copy" onclick="copyLink(this)">Copy</button>
                                    </div>
                                </td>
                            </tr>
                            ${fileUpload}
                        </table>
                        ${resendButton}
                    </div>
                `;
            });

            $('#email-recommendation-cards').html(cardsHtml);
            $('#email-recommendation-content').show();
            $('#btn-send-email-recommendation').prop('disabled', false);

        })
        .fail(function() {
            $('#email-recommendation-loading').hide();
            $('#email-recommendation-error')
                .text('Failed to get recipient list.')
                .show();
        });
    });

    $(document).on('click', '#btn-send-email-recommendation', function(e) {
        e.preventDefault();
        var id = $('#send-email-recommendation-modal').data('id');
        var $btn = $(this);

        if (!confirm('Are you sure you want to send recommendation emails?')) {
            return;
        }

        $btn.prop('disabled', true).text('Sending...');

        $.ajax({
            url: "<?= base_url(); ?>admin/selection/send_email_recommendation",
            method: "POST",
            dataType: "JSON",
            data: {
                grantee_grant_id: id
            }
        })
        .done(function(res) {
            $btn.prop('disabled', false).text('Trigger & Send Emails');
            if (res.status) {
                show_toast_message(res.message || 'Notification emails with private entry links have been dispatched to all registered recommenders.');
                $('#send-email-recommendation-modal').modal('hide');
            } else {
                alert(res.message || 'Failed to send emails to recommenders.');
            }
        })
        .fail(function() {
            $btn.prop('disabled', false).text('Trigger & Send Emails');
            alert('An error occurred while sending emails.');
        });
    });

    function copyLink(btn) {
        var input = $(btn).closest('div').find('.link-input')[0];
        if (!input) {
            console.log('URL not found');
            return;
        }

        var text = input.value;
        if (!text) {
            console.log('URL null');
            return;
        }

        input.focus();
        input.select();
        input.setSelectionRange(0, input.value.length);

        var success = false;
        try {
            success = document.execCommand('copy');
        } catch (e) {
            console.error('Copy error:', e);
        }

        if (success) {
            var $btn = $(btn);
            var originalText = $btn.text();

            $btn.text('Copied!');

            setTimeout(function() {
                $btn.text(originalText);
            }, 2000);
        } else {
            alert('Failed copy URL');
        }
    }

    $(document).on('click', '.btn-resend-recommender', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var id = $btn.data('id');

        if (!confirm('Are you sure you want to Resend and Reset recommendation emails?')) {
            return;
        }

        $btn.prop('disabled', true).text('Sending...');

        $.ajax({
            url: "<?= base_url(); ?>admin/selection/resend_email_recommendation",
            method: "POST",
            dataType: "JSON",
            data: {
                id: id
            }
        })
        .done(function(res) {
            $btn.prop('disabled', false).text('Resend and Reset');
            if (res.status) {
                show_toast_message(res.message || 'Notification emails with private entry links have been dispatched to all registered recommenders.');
                $('#send-email-recommendation-modal').modal('hide');
            } else {
                alert(res.message || 'Failed to send emails to recommenders.');
            }
        })
        .fail(function() {
            $btn.prop('disabled', false).text('Resend and Reset');
            alert('An error occurred while sending emails.');
        });

        
    });
</script>