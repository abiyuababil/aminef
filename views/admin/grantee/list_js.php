
<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
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
    var url = "<?php echo site_url('admin/grantee/download_excel?section=all') ?>" + params;
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
            section: 'all'
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
    form_data.append('section', 'all');

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
