<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    const uploadBankStatement = '<?= isset($upload_bank) ? true : false ?>';
    $(document).ready(function() {
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
        $('#final_cost_university').on('keyup', function(e){
            let grant_reward = $('#grant_reward').val();
            grant_reward = grant_reward.replace(/\D/g, ''); // Menghapus semua karakter non-digit
            grant_reward = parseInt(grant_reward) || 0; 

            let value = $(this).val() == '' ? '0' : $(this).val();
            value = value.replace(/\D/g, ''); // Hanya menyisakan angka
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Menambahkan koma setiap ribuan
            $(this).val(value == '0' ? '' : value );

            // console.log(value.replace(/\D/g, ''))
            var total = grant_reward - parseInt(value.replace(/\D/g, ''));
            var totalFinal = total;
            if(totalFinal == grant_reward){
                totalFinal = 0
            }
            if (totalFinal < 0) {
                $('#sortfall').val(totalFinal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                $('#saving').val('0')
            } else {
                $('#sortfall').val('0')
                $('#saving').val(totalFinal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            }
        });

        $(".status").change(function() {
            var _value = $(this).val();
            if (_value == "Admitted"){
                $(".admitted").removeClass("hide");
            }else{
                $(".admitted").addClass("hide");
            }

            var data_loa = ['Admitted', 'Departmental', 'Waitlisted', 'Conditional', 'Unofficial Admitted'];
            if (data_loa.includes(_value)){
                $(".loa-upload, .sec-cost-sharing, .sec-reply-deadline").removeClass("hide");
            }else{
                $(".loa-upload, .sec-cost-sharing, .sec-reply-deadline").addClass("hide");
            }

            if (_value == "Rejected"){
                $(".rejection-letter").removeClass("hide");
            }else{
                $(".rejection-letter").addClass("hide");
            }
        });

        $(".status").trigger("change");
        $("#btn-submission-result").click(function(){
            var fd = new FormData();
            var files = $('#submission_result_input_file')[0].files;
            var id = $('#submission_result_id').val();
            var type = $('#type').val();


            // Check file selected or not
            if(files.length > 0 ){
            fd.append('submission_result_file',files[0]);
            fd.append('id', id);
            fd.append('type', type);
                $.ajax({
                    url: '<?php echo site_url('admin/nominee/submission_result/save_submission_result_file') ?>',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $('#list_data').append(response.html);
                        $('.lightbox').topbox();
                        $('#submission_result_file').modal('hide')
                        $('#submission_result_input_file').val('')
                        Swal.fire({
                            icon: "success",
                            title: "Successfully upload the file",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // location.reload();
                    },
                });
            }else{
                alert("Please select a file.");
            }
        })
    });
    
    $("#btn-invoice").click(function(){ 
        var icon = $("#load-upload"); 
        var input_file = document.getElementById('input-file'); 
        var base_url   = "<?= base_url()?>";
        var grantee_grant_id = <?= $grantee_grant_id ?>;
        var university_id = <?= $id ?>;
        
        // define value form data
        var formData = new FormData();
        var totalfiles = input_file.files.length;
        console.log(totalfiles)
        if(totalfiles == 0){
            return false
        }
        icon.css('display', 'inline-block')
        $("#btn-invoice").prop('disabled', true)
        for (var i = 0; i < totalfiles; i++) {
            formData.append("file_"+i, input_file.files[i]);
        }
        formData.append("grantee_grant_id", grantee_grant_id)
        formData.append("university_id", university_id)

        // autosave
        $.ajax({
            url: "<?= base_url(); ?>admin/nominee/submission_result/add_invoice_allowance", 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false
        }).done(function(r){
            var result = $.parseJSON(r);
            console.log(result.data)
            $("#btn-invoice").prop('disabled', false)
            for (var i = 0; i < result.data.length; i++) {
                var nameFile = result.data[i].file_name;
                var urlFile = result.data[i].file_url;
                var formatFile = result.data[i].file_format;
                var idInvoice = result.data[i].id;
                if(formatFile == 'pdf'){
                    urlFile = 'assets/images/icons/pdf.svg'
                }
                if(nameFile.length > 15){
                    nameFile = nameFile.substring(0, 15) + '...';
                }
                var html = '';
                    html += '<div class="col-lg-3 img-col" style="height: 150px;">';
                    html += '<a href="<?= base_url() ?>'+urlFile+'" class="lightbox"><img height="100" src="<?= base_url()?>'+urlFile+'"></a>';
                    html += '<a href="javascript:;" class="btn btn-danger btn-xs" style="position:absolute; top:25px;" onclick="del_item(this, \'img-col\', '+idInvoice+')">';
                    html += '<i class="fa fa-trash fa-fw text-white"></i>';
                    html += '</a>';
                    html += '<a href="<?= base_url()?>'+urlFile+'" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">';
                    html += '<i class="fa fa-download fa-fw text-white"></i>';
                    html += '</a>';
                    html += '<p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="'+result.data[i].file_name+'">'+nameFile+'</p>';
                    html += '</div>';

                $(".wrap-invoice").append(html);
                $("#input-file").val('');
                icon.css('display', 'none')
            }
            $('.lightbox').topbox();
        });
    });
    function del_item(el, item_class, id) {
        if (confirm("Are you sure want to delete this ?"))
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/nominee/submission_result/delete_invoice_allowance') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('.' + item_class).remove();
                    }
                }
            });
    }

    function delete_doc_result(el, id, id_parent, type, field)
    {
    if (confirm("Are you sure want to delete this ?"))
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('grantee/profile/delete_doc_result') ?>/'+ id + '/' + id_parent  + '/' + type  + '/' + field,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    location.href=r.redirect;
                    $('#btn-submit-bank-statement').attr('data-bank', '');
                    $('#bank_statement_uploaded').val('');
                }
            }
        });
    }

    function delete_doc_result_admin(el, id, id_parent, type, field, is_admin = 1)
    {
        if (confirm("Are you sure want to delete this ?")){
            if(is_admin){
                urlAjax = '<?php echo site_url('admin/nominee/submission_result/delete_doc_result') ?>/'+ id + '/' + id_parent  + '/' + type  + '/' + field
            }else{
                urlAjax = '<?php echo site_url('grantee/submission/delete_doc_result') ?>/'+ id + '/' + id_parent  + '/' + type  + '/' + field
            }
            let currentTd = $('.upload_bank_statement').closest("td");
            $.ajax({
                type: 'GET',
                url: urlAjax,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).remove();
                        $('.' + field + '_file').remove();
                        currentTd.prev("td").prev("td").text('');
                        currentTd.prev("td").prev("td").prev("td").text('');
                        currentTd.prev("td").text('');
                        $('#btn-submit-bank-statement').attr('data-bank', '');
                        $('#bank_statement_uploaded').val('');
                    }
                }
            });
        }
    }



    $("#btn-loa-upload").click(function(){
        var fd = new FormData();
        var files = $('#upload_loa_input_file')[0].files;
        var is_grantee = $(this).data('is_grantee');
        var id = $('#submission_result_id_loa').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        var input_file = document.getElementById('upload_loa_input_file'); 
        var totalfiles = input_file.files.length;
        $('#btn-loa-upload').prop('disabled', true)

        var urlAjax = null;
        if(is_grantee){
            urlAjax = '<?php echo site_url('grantee/profile/save_loa') ?>'
        }else{
            urlAjax = '<?php echo site_url('admin/nominee/submission_result/save_loa') ?>'
        }


        // Check file selected or not
        if(totalfiles > 0 ){
            for (var i = 0; i < totalfiles; i++) {
                fd.append("upload_loa_input_file_"+i, input_file.files[i]);
            }
            // fd.append('upload_loa_input_file',files[0]);
            fd.append('id',id);
            fd.append('grantee_grant_id',grantee_grant_id);
            $.ajax({
                url: urlAjax,
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-loa-upload').prop('disabled', false);
                    $('#upload_loa_input_file').val('');
                    $("#upload-loa").modal('hide');   
                    $('#list_loa').append(response.html);
                    $('.lightbox').topbox();
                },
            });
        }else{
            $('#btn-loa-upload').prop('disabled', false);
            alert("Please select a file.");
        }
    })

    function del_loa_file(el, item_class, id, is_grantee = 0) {
        if (confirm("Are you sure want to delete this ?"))
            var urlAjax = null;
            if(is_grantee){
                urlAjax = '<?php echo site_url('grantee/profile/delete_loa_academic') ?>/'+ id
            }else{
                urlAjax = '<?php echo site_url('admin/nominee/submission_result/delete_loa_academic') ?>/'+ id
            }
            $.ajax({
                type: 'GET',
                url: urlAjax,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                    }
                }
            });
    }

    function delete_rejection_letter(el, id) {
        if (confirm("Are you sure want to delete this ?")) 
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/nominee/submission_result/delete_rejection_letter') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $('#rejection_letter_delete, .btn-file').remove();
                    }
                }
            });
    }


    $(document).on('click', '.upload_bank_statement', function() {
        $('.bank_statement_file_upload').click();
        $('.bank_statement_file_upload').off('change').change(function(e){
            var is_admin = $(this).data('is_admin') ? 1 : 0;
            var id = $(this).data('id');
            var id_parent = $(this).data('id_parent');
            var type = $(this).data('type');
            let currentTd = $('.upload_bank_statement').closest("td");
            if(is_admin){
                var urlAjax = "<?= base_url(); ?>admin/nominee/submission_result/upload_bank_statement";
            }else{
                var urlAjax = "<?= base_url(); ?>grantee/submission/upload_bank_statement";
            }
            showSwal('loading', 'Please wait while we process your request.');
    
    
            var formData = new FormData();
            formData.append("file", e.target.files[0]);
            formData.append("is_admin", is_admin);
            formData.append("id", id);
            formData.append("id_parent", id_parent);
            formData.append("type", type);
            $.ajax({
                url: urlAjax,
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                contentType: false // Using FormData, no need to process data.
            }).done(function(r) {
                    Swal.close(); 
                    $('.bank_statement_file').remove();
                    currentTd.append(r.delete);
                    currentTd.prev("td").text(r.created_date);
                    currentTd.prev("td").prev("td").text('');
                    currentTd.prev("td").prev("td").text(r.status);
                    currentTd.prev("td").prev("td").prev("td").text('')
                    currentTd.prev("td").prev("td").prev("td").append(r.filename);
                    $('.bank_statement_file_upload').val('');
                    $('.lightbox').topbox();
                    $('#btn-submit-bank-statement').attr('data-bank', r.file);
                    $('#bank_statement_uploaded').val(r.file);
                    showSwal('success', 'Successfully upload the file', false, true, 1500)
            })
            .fail(function() {
                showSwal('error', 'Failed to upload the file', false, true, 1500);
            });
    
            $(this).val('');
        });
    })

    function update_status_bank_statement(el, id, status, field) {
        if (confirm("Are you sure want to "+status+" this ?"))
            if(status == 'revise'){
                $('#mdl_note_revise').modal()
                $('#btn-save-note').attr("onclick","update_status_bank_statement_action("+ id +", '"+ status +"', '"+ field +"')"); 
            }else{
                update_status_bank_statement_action(id, status, field);
            }
    }

    function update_status_bank_statement_action(id, status, field) {
        var note = $('#note_revise').val();
        var modal = $('#mdl_note_revise');
        var fileInput = modal.find('input[type="file"][name="temp_attachment_revise"]')[0] || modal.find('#temp_attachment_revise')[0];
        var btnSave = $('#btn-save-note');

        var doSave = function(attachment_revise) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/nominee/submission_result/update_status_bank_statement') ?>',
                data: {
                    id: id,
                    status: status,
                    note: note,
                    field: field,
                    attachment_revise: attachment_revise,
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

    $(".view-log").click(function(e){
        var id_parent = $(this).data('id')
        var type = $(this).data('type')
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/nominee/submission_result/get_status_log') ?>',
            dataType: 'JSON',
            data:{
                id_parent: id_parent,
                type: type,
                is_bank_statement: true
            },
            success: function(r) {
                $("#viewLog tbody").html("");
                if (r.status){
                    for (let i = 0; i<r.data.length;i++){
                        var action = r.data[i].status_before != null || r.data[i].status_after != null 
                                        ? "<a data-old_data='"+ JSON.stringify(r.data[i].status_before).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' data-new_data='"+ JSON.stringify(r.data[i].status_after).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>" 
                                        : '';
                                        
                                        
                        var created_at = "<td>" + r.data[i].created_at + "</td>"; 
                        var event = "<td>" + r.data[i].event + "</td>"; 
                        var created_by = "<td>" + r.data[i].created_by + "</td>";     
                        var pAction = "<td>" + action + "</td>"; 

                        $("#viewLog tbody").append(`<tr>${created_at}${event}${created_by}${pAction}</tr>`)
                    }
                }
            }
        })
    })

    $(document).on('click', '#btn-submit-bank-statement', function(){
        if (uploadBankStatement) {
            const bankStatement = $('#bank_statement_uploaded').val().trim();

            if (!bankStatement) {
                showSwal(
                    'warning',
                    'Please upload the bank statement before clicking the submit button',
                    false,
                    true,
                    2000
                );
                return;
            }
        }

        $('#form-submission').submit();
        // var bank_statement = $(this).attr('bank');

        // var bank_statement = $('#bank_statement_uploaded').val();
        // if(bank_statement){
        //     $('#form-submission').submit();
        // }else{
        //     showSwal('warning', 'Please upload the bank statement before clicking the submit button', false, true, 2000);
        // }
        
    })
</script>