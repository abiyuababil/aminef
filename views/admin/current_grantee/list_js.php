
<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
function not_completion(user_id, grantee_grant_id, grant_id) {
    if (confirm("Are you sure ?")){
        var note = $('#note_submission'+grant_id).val();
        var document = $('#document').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/current_grantee/not_completion') ?>',
            data: {
                note    : note,
                user_id : user_id,
                grantee_grant_id : grantee_grant_id,
                grant_id : grant_id,
                document : document,
            },
            success: function(r) {
                if(r.err_message == false){
                    location.href=r.redirect;
                }
            }
        });
    }

}

function completion(user_id, grantee_grant_id, grant_id) {
    var date = $("#completion_date").val();
    var search_alumni = $("#search_alumni").val();
    var without_notif = $("#without_notif").is(':checked') ;
    var update_alumni_data = $("#update_alumni_data").is(':checked') ;
    var sendEmail = without_notif ? 0 : 1; 
    var updateAlumni = update_alumni_data ? 1 : 0; 

    $("#btn-yes").html('<img src="<?php echo base_url() ?>/img/loading.gif">');
    $(".btn-disabled").prop("disabled", true);
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('admin/current_grantee/completion') ?>',
        data: {
            user_id : user_id,
            grantee_grant_id : grantee_grant_id,
            grant_id : grant_id,
            date : date,
            send_mail : sendEmail,
            update_alumni : updateAlumni,
            alumni_id : search_alumni
        },
        success: function(r) {
            if(r.err_message == false){
                location.href=r.redirect;
            }
        }
    });

}
$(".completed").click(function(){
    var id = $(this).data('id');
    var grantee_grant_id = $(this).data('id-grantee-grant');
    var grant_id = $(this).data('grant-id');
    var period_to = $(this).data('periodto');
    var sourceId = $(this).data('source');
    var format_date = '';
    format_date = new Date(period_to).toLocaleString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
    if(format_date == 'Invalid Date'){
        format_date = '';
    }
    
    $("#mdl_date").modal();   
    $("#btn-completed").attr('data-id', id);
    $("#btn-completed").attr('data-grantee_grant_id', grantee_grant_id);
    $("#btn-completed").attr('data-grant_id', grant_id);
    $("#btn-completed").attr('data-source', sourceId);
    $(".btn-disabled").prop("disabled", true);
    $("#completion_date").val(format_date);

    $("#search_alumni").val(sourceId);
    $("#search_alumni").selectpicker('refresh');

    event.preventDefault();
});

$('#btn-completed').click(function(){
    var id = $(this).data('id');
    var grantee_grant_id = $(this).data('grantee_grant_id');
    var grant_id = $(this).data('grant_id');
    $("#mdl_confirm").modal();
    $("#mdl_date").modal('hide');
    $('#btn-yes').attr("onclick","completion("+ id +","+ grantee_grant_id+","+ grant_id +")"); 
    setTimeout( function(){ 
        $(".btn-disabled").prop("disabled", false);
    }  , 5000 );
})

$(document).ready(function(){
    $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
        });
    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
        yearRange: "<?php echo date('Y') - 100 ?>:<?php echo date('Y') + 20 ?>",
        onClose: function() {
            $(this).trigger('blur');
        }
    });
});
	
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

function show_download_modal_grantee(params) {
    var url = "<?php echo site_url('admin/grantee/download_excel?section=current') ?>" + params;
    $('.field-alumni').prop('checked', true);
    $('.text-validation').removeClass('d-block');
    $('.text-validation').addClass('d-none');
    $('#form-download-excel').attr('action', url);
    $('#modalDownload').modal('show');
}

$('#filter_year').change(function(){
    var year = $('#filter_year').val();
    $('#period_value').val(year);
    if (year == '') {
        $('#filter_program').html('<option value="">Select fiscal year first</option>');
    } else {
        $('#filter_program').html('<option value="">-- Select Program --</option>');
    }
    $('.selectpicker').selectpicker('refresh');
    $('.add_fields').html('');
    $('.field_row').addClass('hide');
    if (year == '') {
        return;
    }
    $.ajax({
        url: '<?php echo site_url('admin/current_grantee/get_program_filter') ?>',
        type: 'POST',
        data: {
            year: year,
            section: 'current'
        },
        dataType: 'JSON',
        success: function(response) {
            $('#text-validation-year').removeClass('d-block');
            $('#text-validation-year').addClass('d-none');
            if (response.data.length) {
                $.each(response.data, function(id, val) {
                    $('#filter_program').append('<option value="' + val.grant_id + '">' + val.name + '</option>');
                });
                $('.selectpicker').selectpicker('refresh');
            }
        }
    });
});

$('#filter_program').change(function(){
    var grantId = $('#filter_program').val();
    $('.add_fields').html('');
    if (grantId == '') {
        return;
    }
    $.ajax({
        async: false,
        type: 'GET',
        url: '<?php echo site_url('admin/current_grantee/get_all_field/') ?>'+grantId,
        dataType: 'JSON',
        success: function(data) {
            $('#text-validation-program').removeClass('d-block');
            $('#text-validation-program').addClass('d-none');
            $('.field_row').removeClass('hide');
            $('.add_fields').append(data.html);
        }
    });
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

    if($('#filter_year').val() == ''){
        $('#text-validation-year').removeClass('d-none');
        $('#text-validation-year').addClass('d-block');
        e.preventDefault();
    }
    else {
        $('#text-validation-year').removeClass('d-block');
        $('#text-validation-year').addClass('d-none');
    }

    if($('#filter_program').val() == ''){
        $('#text-validation-program').removeClass('d-none');
        $('#text-validation-program').addClass('d-block');
        e.preventDefault();
    }
    else {
        $('#text-validation-program').removeClass('d-block');
        $('#text-validation-program').addClass('d-none');
    }
});
	
$('#sel-all').click (function () {
    $('.field-alumni').prop('checked', this.checked);
});



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
</script>