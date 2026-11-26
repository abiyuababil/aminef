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
	
	// SET TO ALUMNI
	$(".set_to_alumni").click(function(){
		var grantee_grant_id = $(this).data('grantee_grant_id');
		var user_grantee_id = $(this).data('user_grantee_id');
    	var grant_id = $(this).data('grant-id');
		var sourceId = $(this).data('source');
		
		$("#mdl_date").modal();   
		$("#btn-completed").attr('data-id', user_grantee_id);
		$("#btn-completed").attr('data-grantee_grant_id', grantee_grant_id);
		$("#btn-completed").attr('data-grant_id', grant_id);
		$("#btn-completed").attr('data-source', sourceId);
		$(".btn-disabled").prop("disabled", true);

		$("#search_alumni").val(sourceId);
		$("#search_alumni").selectpicker('refresh');

		event.preventDefault();
		// $("#mdl_info").modal();   
		// $('#btn-successful').attr('onclick','set_to_alumni('+ grantee_grant_id +', ' + user_grantee_id + ', ' + source + ')'); 
		// event.preventDefault();
	});
	
	$('#btn-completed').click(function(){
		var id = $(this).data('id');
		var grantee_grant_id = $(this).data('grantee_grant_id');
		var grant_id = $(this).data('grant_id');
		$("#mdl_info").modal();
		$("#mdl_date").modal('hide');
		$('#btn-successful').attr("onclick","set_to_alumni("+ grantee_grant_id +","+ id+","+ grant_id +")"); 
		setTimeout( function(){ 
			$(".btn-disabled").prop("disabled", false);
		}  , 5000 );
	})

	function set_to_alumni(grantee_grant_id, user_id, grant_id, force = 0)
	{
		var search_alumni = $("#search_alumni").val();
		var update_alumni_data = $("#update_alumni_data").is(':checked') ;
		var updateAlumni = update_alumni_data ? 1 : 0; 

		$('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
		$.ajax({
			url: "<?= base_url(); ?>admin/returning/set_to_alumni",
			method: "POST",
			dataType: 'JSON',
			data: {
				user_id : user_id,
				grantee_grant_id : grantee_grant_id,
				grant_id : grant_id,
				update_alumni : updateAlumni,
				alumni_id : search_alumni,
				force : force
			},
			success: function(r) {
				if(r.success){
					location.href=r.redirect;
				}else{
					$("#mdl_info").modal('hide');
					// muncul confirm
					if (r.confirm) {

						Swal.fire({
							title: 'Program Already Exists',
							html: r.message,
							icon: 'warning',
							showCancelButton: true,
							confirmButtonText: 'Yes, Continue',
							cancelButtonText: 'Cancel',
							position: 'top'
						}).then((result) => {

							if (result.isConfirmed) {

								// ulang ajax dengan force = 1
								set_to_alumni(
									grantee_grant_id,
									user_id,
									grant_id,
									1
								);

							} else {

								$('#btn-successful')
									.html('Submit')
									.prop('disabled', false);
							}
						});

					} else {

						showSwal('warning', r.message, false, true, 2000);

						$('#btn-successful')
							.html('Submit')
							.prop('disabled', false);

						$("#mdl_info").modal('hide');
					}
				}
			}
		});
	}

    $(".btn-deleted").click(function(e) {
        e.preventDefault();

        var id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This grantee data will be deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then(function(result) {

            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: "<?= base_url('admin/users_det/delete_ajax/'); ?>" + id,
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: "Deleting...",
                        text: "Please wait.",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: function() {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {

                    if (response.success) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Grantee data successfully deleted.",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href =
                                "<?= base_url('admin/users_det/manage'); ?>";
                        });

                    } else {
                        Swal.fire({
                            title: "Failed",
                            text: response.message || "Failed delete data grantee.",
                            icon: "error"
                        });
                    }
                },
                error: function(xhr) {
                    var message = "Failed delete data grantee.";

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: "Error",
                        text: message,
                        icon: "error"
                    });
                }
            });
        });
    });
</script>