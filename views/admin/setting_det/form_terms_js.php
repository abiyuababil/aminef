<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    tinymce.init({
        selector: '.editor',
        plugins: 'link table',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link',
        contenteditable: true,
        spellchecker: false
    });
    
    // Add block period di dalam modal
    $('#add-period-block').on('click', function() {
        var i = $('.period-row').length;
        var block = `<div class="period-row">
            <a class="remove-period-block text-danger pull-right" style="font-size: 18px;cursor:pointer"><i class="fa fa-trash"></i></a>
            <div class="row my-5">
                <div class="col-md-4">
                    <label class="small fw-bold">Cycle</label>
                    <input type="text" class="form-control form-control-sm" name="data_period[${i}][cycle]" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold">Start Date & Time</label>
                    <input type="text" class="flatpicker form-control form-control-sm" name="data_period[${i}][period_start]" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold">End Date & Time</label>
                    <input type="text" class="flatpicker form-control form-control-sm" name="data_period[${i}][period_end]" required>
                </div>
            </div>
        </div>`;
        $('#period-container').append(block);
        tinymce.init({
            selector: '.editor',
            plugins: 'link',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link',
            contenteditable: true,
            spellchecker: false
        });
        $(".flatpicker").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            allowInput: true
        });
        $('.text-empty').addClass('hide');
    });


    $(document).on('click', '.remove-period-block', function() {
        if(confirm('Are you sure you want to remove this period?')) {
            $(this).closest('.period-row').remove();

            if($('.period-row').length < 1) {
                $('.text-empty').removeClass('hide');
            }

            var id = $(this).data('id');
            if(id) {
                $.ajax({
                    url: '<?= site_url('admin/settings_det/delete_period') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function(response) {
                        if(response.status) {
                            showSwal('success', 'Period deleted successfully.', false, true, 2000);
                        } else {
                            showSwal('error', response.message || 'Failed to delete period.', false, true, 2000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting period:', error);
                    }
                });
            }
        }
        // if($('.period-row').length > 1) {
        // }
    });

    $(".flatpicker").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        allowInput: true
    });

    $('.delete_agreement_template').on('click', function() {
        if (confirm('Are you sure you want to delete the agreement template?')) {
            $('#agreement_template_delete').val(1);
            $('.agreement_template').remove();
            $(this).remove();
        }
    });
</script>