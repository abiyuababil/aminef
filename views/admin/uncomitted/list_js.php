<script>
    $('.select2').select2({
        theme: 'bootstrap'
    });    

    $('#select-all').click(function() {
            $('.bulk-checkbox').prop('checked', this.checked);
            toggle_bulk_action();
        });

        $('.bulk-checkbox').click(function() {
            if (!$(this).prop('checked')) {
                $('#select-all').prop('checked', false);
            }

            if ($('.bulk-checkbox:checked').length === $('.bulk-checkbox').length) {
                $('#select-all').prop('checked', true);
            }
            toggle_bulk_action();
        });

        var selected_values = [];

        $('#bulk-action').click(function() {
            selected_values = $('.bulk-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selected_values.length > 0) {
                $('#confirm-set-to-uncommited').modal('show');
            } else {
                alert('No items selected.');
            }
        });

        $('#confirm-submit').click(function() {
            let element = $(this);
            let original_text = element.html();
            element.prop('disabled', true);
            element.html('<i class="fa fa-spinner spin"></i> Please wait...');
            $.ajax({
                url: '<?php echo site_url('admin/uncomitted/remove_from_uncommited') ?>',
                type: 'POST',
                data: {
                    ids: selected_values
                },
                success: function(response) {
                    element.prop('disabled', false);
                    element.html(original_text);
                    window.location.href = '';
                },
                error: function(xhr, status, error) {
                    element.html(original_text);
                    element.prop('disabled', false);
                    alert('An error occurred: ' + error);
                }
            });
            $('#confirmModal').modal('hide');
        });

        function toggle_bulk_action() {
            if ($('.bulk-checkbox:checked').length > 0) {
                $('#bulk-action').removeClass('hide');
            } else {
                $('#bulk-action').addClass('hide');
            }
        }

	function formSubmit(e) {
		$('#loading_data').css('display', 'block');
		$('#frm_manage').submit();
	}
	
	function submitFilter(e) {
		if (e.keyCode == 13) {
			$('#loading_data').css('display', 'block');
			$('#frm_manage').submit();
			return false;
		}
	}

    function sync_data(){
        $('#sync-dialog').modal('show');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/uncomitted/sync_data_balance') ?>',
            dataType: 'JSON',
            success : function(response) {
                $('#sync-dialog').modal('hide');
                location.reload();
            }, error : function(response) {
                $('#sync-dialog').modal('hide');
                
                Swal.fire({
                    title: "Failed to sync data",
                    text: response.responseText,
                    icon: "warning",
                    customClass: 'swal-custom'
                });
                
            }
        });

    }
</script>