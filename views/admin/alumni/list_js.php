	<script>
	
	$(document).ready(function() {
		
		$('#file-excel').change(function() {
			
			var ext = $(this).val().replace(/^.*\./, '');
			if (ext == $(this).val()) {
				ext = '';
			} else {
				ext = ext.toLowerCase();
			}
			
			switch (ext) {
				case 'xls':
				case 'xlsx':
					$('#frm-import-excel').submit();
					break;

				default:
					alert('Sorry, only .xls / .xlsx file has allowed to be uploaded');
			}
			
		});
		
        $('.select2').select2({
            theme: 'bootstrap'
        });
		
	});

	function formSubmit(e) {
		$('#loading_data').css('display', 'block');
		$('#frm_manage').submit();
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
			$('#loading_data').css('display', 'block');
			$('#frm_manage').submit();
			return false;
		}
	}
	
	function import_excel() {
		$('#file-excel').trigger('click');
	}

	function show_download_modal(params) {
		var url = "<?php echo site_url('admin/alumni/download_excel?') ?>" + params;
		$('.field-alumni').prop('checked', true);
		$('.text-validation').removeClass('d-block');
		$('.text-validation').addClass('d-none');
		$('#form-download-excel').attr('action', url);
		$('#modalDownload').modal('show');
	}

	function show_download_modal_grantee(params) {
		var url = "<?php echo site_url('admin/grantee/download_excel?') ?>" + params;
		$('.field-alumni').prop('checked', true);
		$('.text-validation').removeClass('d-block');
		$('.text-validation').addClass('d-none');
		$('#form-download-excel').attr('action', url);
		$('#modalDownload').modal('show');
	}
	
	$('#sel-all').click (function () {
	  $('.field-alumni').prop('checked', this.checked);
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

	// modal payment
	$('#mdl_payment').on('show.bs.modal', function(event) {
		$.fn.modal.Constructor.prototype.enforceFocus = function() {

			var button = $(event.relatedTarget);
			var userId = button.data('id');

			if (typeof currentUsers !== 'undefined') {
				var data = currentUsers[userId];
				var baseUrl = '<?php echo base_url() ?>';
				$('.wrap-payment').html('');
				var isNull = false;
				for (let index = 0; index < Object.keys(data.programs).length; index++) {
					if(data.programs[index].grantee_grant_id == null){
						isNull = true;
					}
				}
				
				if(isNull == false){
					$.each(data.programs, function(key, value) {
						if(data.country_id == 1){
							var url = baseUrl+'admin/payment_record/payment/alumni/'+value.grantee_grant_id;
						}else{
							var url = baseUrl+'admin/request_payment/edit/'+value.user_grant_id+'/'+value.grantee_grant_id+'?source=alumni';
						}
						var html = '<li><a href="'+ url +'" style="font-size:14px">'+ value.program_name+' ('+value.year_departure+')</a></li> <br>';
						$('.wrap-payment').append(html)
					});
				}else{
					$("#load-mdl").css('display', 'block');
					// get disabled date
					var exportToGrantee = function() {
						var grantee_grant_id = [];
						$.ajax({
							async: false,
							type: 'GET',
							url: '<?php echo site_url('admin/alumni/move_to_grantees/') ?>'+userId,
							success: function(data) {
								grantee_grant_id = data;
							}
						});
						return grantee_grant_id;
					}();
					if(exportToGrantee){
						$.each(exportToGrantee, function(key, value) {
							if(data.country_id == 1){
								var html = '<li><a href="'+baseUrl+'admin/payment_record/payment/alumni/'+value.grantee_grant_id+'" style="font-size:14px">'+ value.program_name+' ('+value.year_departure+')</a></li> <br>';
								$('.wrap-payment').append(html)
							}else {
								var html = '<li><a href="'+baseUrl+'admin/request_payment/edit/'+value.user_grantee_id+'/'+value.grantee_grant_id+'?source=alumni'+'" style="font-size:14px">'+ value.program_name+' ('+value.year_departure+')</a></li> <br>';
								$('.wrap-payment').append(html)
							}
						});
						$("#load-mdl").css('display', 'none');
					}

				}
			}
		};
	});

	$('#active_grant_id').change(function(){
		var grantId = $('#active_grant_id').val();
		var selectedOptionText = $('#active_grant_id option:selected').text();
        $("#selected-active-grant").text("List Fields of " + selectedOptionText);
		$('.add_fields').html('');
		$.ajax({
			async: false,
			type: 'GET',
			url: '<?php echo site_url('admin/grantee/get_all_field/') ?>'+grantId,
            dataType: 'JSON',
			success: function(data) {
				$('#text-validation-active-grant').removeClass('d-block');
				$('#text-validation-active-grant').addClass('d-none');
				$('.field_row').removeClass('hide');
				$('.add_fields').append(data.html);
			}
		});
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
                url: '<?php echo site_url('admin/uncomitted/sync_data_balance') ?>',
                type: 'POST',
                data: {
                    grantee_grant_ids: selected_values
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
	</script>
