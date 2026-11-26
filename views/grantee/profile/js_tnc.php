<script>
    $("#form").on("submit", function (e) {
        e.preventDefault();
        var file_tnc = $('#tnc')[0]?.files || [];
        var file_consent = $('#consent_letter')[0]?.files || [];
        
        if (file_tnc.length === 0) {
            if(file_consent.length === 1){
                this.submit();
            }else{
                showSwal('error', 'Please choose file.', false, true, 1500);
            }
        } else {
            this.submit();
        }
    });

    $('#tnc').on('change', function () {

        if (this.files.length > 0) {

            var file = this.files[0];

            $('#selected-file').show();

            $('.file-name').text(file.name);

        }

    });

    $('.remove-file').on('click', function () {

        $('#tnc').val('');

        $('#selected-file').hide();

    });
    
    function copyCouponCode() {
        const code = $('#couponText').text().trim();

        const textarea = $('<textarea>');
        textarea
            .val(code)
            .css({
                position: 'fixed',
                opacity: 0
            })
            .appendTo('body');

        textarea[0].select();

        try {
            document.execCommand('copy');
            alert(`Coupon Code "${code}" copied to clipboard!`);
        } catch (err) {
            console.error('Failed to copy:', err);
        }

        textarea.remove();
    }
    
    $(".upload_departure_item").click(function() {
        var application_id = $(this).data('id') || null;
        $('#tnc').click();
        $('#tnc').off('change').on('change', function(e) {
            var file = e.target.files[0];
            let currentTd = $(this).closest("td");
            
            if (file) {
                showSwal('loading', 'Please wait while we process your request.');
        
                var formData = new FormData();
                formData.append("file", e.target.files[0]);
                formData.append("application_id", application_id);
                $.ajax({
                    url: "<?= base_url(); ?>det/application/upload_agreement",
                    type: 'POST',
                    data: formData, // The form with the file inputs.
                    processData: false,
                    dataType: 'JSON',
                    contentType: false // Using FormData, no need to process data.
                }).done(function(r) {
                    if(r.success){
                        currentTd.prev("td").text('');
                        currentTd.prev("td").append(r.created_date); 
                        currentTd.prev("td").prev("td").text('');
                        currentTd.prev("td").prev("td").text(r.status);
                        currentTd.prev("td").prev("td").prev("td").text('')
                        currentTd.prev("td").prev("td").prev("td").append(r.filename);
                        $('.upload_departure_item').addClass('hide')
                        $('.lightbox').topbox();
                        showSwal('success', 'Successfully upload the file', false, true, 1500);
                    }else{
                        showSwal('error', r.message, false, true, 1500);
                    }
                })
                .fail(function() {
                    showSwal('error', 'Failed to upload the file', false, true, 1500);
                });
        
                $(this).val('');
            }
        });
    });

    function handleFileChange(event) {
      const file = event.target.files[0];
      const display = document.getElementById('fileNameDisplay');
      if (file) {
        display.innerText = 'Selected file: ' + file.name;
      } else {
        display.innerText = '';
      }
    }
    

    function handleSubmit(event) {
        event.preventDefault();

        let fileInput = document.getElementById('score_file');

        // Validasi jika file belum dipilih
        if (fileInput.files.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'File Required',
                text: 'Please upload your Score Report before submitting.',
                confirmButtonText: 'OK'
            });

            return false;
        }

        var application_id = $('#application_id').val().trim();
        var overall_score = $('#overall_score').val().trim();
        var test_date = $('#test_date').val().trim();

        var formData = new FormData();
        formData.append('application_id', application_id);
        formData.append('overall_score', overall_score);
        formData.append('test_date', test_date);

        if (fileInput.files.length > 0) {
            formData.append('file_score', fileInput.files[0]);
        }

        showSwal('loading', 'Please wait while we process your request.');

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('det/application/update_score_report'); ?>',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                Swal.close();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Submit Score Successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Failed', text: response.message || 'Failed to process submit.' });
                }
            },
            error: function () {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Error', text: 'Server error. Please try again.' });
            }
        });
    }

    function approveRequirement() {
        if (confirm("Are you sure want to " + status + " this ?")){
            const section = document.getElementById('contentSection');
            section.classList.remove('is-disabled');
        }
    }



    function update_status_agreement(el, id, status) {
        if (confirm("Are you sure want to "+status+" this ?"))
            if(status == 'Reject'){
                $('#mdl_note_reject').modal()
                $('#btn-save-note-reject').attr("onclick","update_status_agreement_action("+ id +", '"+ status +"')"); 
            }else{
                update_status_agreement_action(id, status);
            }
    }

    function update_status_agreement_action(id, status) {
        var note = $('#note_reject_argeement').val()
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('det/application/update_status_agreement') ?>',
            data: {
                id:id,
                status:status,
                note:note
            },
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    location.reload();
                }
            }
        });
    }
    
</script>