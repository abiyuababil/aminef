<script>
    $(".succesfully").click(function () {
        var id = $(this).data('id');
        $("#mdl_info").modal();
        $('#btn-successful').attr("onclick", "succesfully(" + id + ")");
        event.preventDefault();
    });

    function succesfully(grantee_grant_id) {
        $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        $.ajax({
            url: "<?= base_url(); ?>admin/on_going/successfully",
            method: "POST",
            dataType: 'JSON',
            data: {
                grantee_grant_id: grantee_grant_id,
            }
        })
            .success(function (data) {
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
        var url = "<?php echo site_url('admin/grantee/download_excel?is_inprogress=1&') ?>" + params;
        $('.field-alumni').prop('checked', true);
        $('.text-validation').removeClass('d-block');
        $('.text-validation').addClass('d-none');
        $('#form-download-excel').attr('action', url);
        $('#modalDownload').modal('show');
    }

    $('#modalDownload').on('show.bs.modal', function () {
        $.fn.modal.Constructor.prototype.enforceFocus = function () {
            $('.select2').select2({
                theme: 'bootstrap'
            });
        };
    });

    $('#active_grant_id, #select_period').change(function () {
        let grantId = $('#active_grant_id').val();
        let periodId = $('#select_period').val();
        let selectedOptionText = $('#active_grant_id option:selected').text();
        $("#selected-active-grant").text("List Fields of " + selectedOptionText);
        $('.add_fields').html('');
        $.ajax({
            async: false,
            type: 'GET',
            url: '<?php echo site_url('admin/selection/get_all_field/') ?>' + grantId + '/' + periodId,
            dataType: 'JSON',
            success: function (data) {
                $('#text-validation-active-grant').removeClass('d-block');
                $('#text-validation-active-grant').addClass('d-none');
                $('.field_row').removeClass('hide');
                $('.add_fields').append(data.html);

                $('#select_period').html('');
                $('#select_period').append('<option value="">-- Select Period --</option>');
                $.each(data.periods, function (id, val) {
                    var selected = '';
                    if (val.id == periodId) {
                        selected = 'selected';
                    }
                    $('#select_period').append('<option ' + selected + ' value="' + val.id + '">' + val.fiscal_year + '</option>');
                    $('.selectpicker').selectpicker('refresh');
                });
            }
        });
    });

    $('#form-download-excel').submit(function (e) {
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

        if ($('#active_grant_id').val() == '') {
            $('#text-validation-active-grant').removeClass('d-none');
            $('#text-validation-active-grant').addClass('d-block');
            e.preventDefault();
        }
        else {
            $('#text-validation-active-grant').removeClass('d-block');
            $('#text-validation-active-grant').addClass('d-none');
        }
    });

    $('#sel-all').click(function () {
        $('.field-alumni').prop('checked', this.checked);
    });

    const form_download_excel = $("#form-download-excel");
    const progress_dialog = $("#progress-dialog");
    form_download_excel.on('submit', (e) => {
        e.preventDefault();
        progress_dialog.modal('show');
        $('#modalDownload').modal('hide');

        const form_data = new FormData(form_download_excel[0]);
        form_data.append('is_inprogress', '1');

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

    $('.select2').select2({
        theme: 'bootstrap',
        placeholder: 'Select Active Grant',
        maximumSelectionLength: 2,
        width: '100%'
    });
</script>