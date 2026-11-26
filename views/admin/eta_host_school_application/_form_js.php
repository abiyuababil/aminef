<script>
    $(".flatpickrDateTime").flatpickr({
        altInput: true,
        altFormat: "F j, Y H:i",
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });


	$(document).on('click', '.download-pdf', function(e){
		e.preventDefault();
		$("#progress-dialog").modal('show');
		let url = $(this).attr('href');
		$.ajax({
			url : url,
			type : 'GET',
			dataType : 'JSON',
			success : function(response) {
				
				var link = document.createElement('a');
				link.href = response.fileurl;
				link.download = response.filename;
				document.body.appendChild(link);
				link.click();
				document.body.removeChild(link);
				$("#progress-dialog").modal('hide');
			}, error : function(response) {
				$("#progress-dialog").modal('hide');
			   
				Swal.fire({
					title: "Failed to download the document",
					text: response.responseText,
					icon: "warning",
					customClass: 'swal-custom'
				});
				
			}
		});
	});

	$(document).ready(function() {
		$('#form_application').on('submit', function(e) {
			e.preventDefault(); // cegah submit langsung
			
			var title = $('#title').val();
			let id = $('#id').val();
			console.log(id)

			if (typeof id !== 'undefined' && id !== '') {
				this.submit();
			}else{
				$.ajax({
					url: '<?= base_url('admin/eta_host_school_application/check_slug/')?>' + title, // endpoint validasi
					method: 'GET',
					dataType: 'json',
					success: function(response) {
						if (response.status) {
							// validasi ok, submit manual
                    		$('#form_application')[0].submit();
						} else {
							Swal.fire({
								title: "Host School Application name title already exists",
								icon: "warning",
								customClass: 'swal-custom'
							});
						}
					},
					error: function() {
						alert('Failed Submit.');
					}
				});
			}
		});
	});
</script>