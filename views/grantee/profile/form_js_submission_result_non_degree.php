<script>
    $(document).ready(function() {
        const SITE_URL = '<?php echo site_url(); ?>';

        // Approve submission
        $(document).on('click', '.btn-approve-non-degree', function() {
            var id = $(this).data('id');
            var university = $(this).data('university');

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Approve Submission',
                    html: 'Are you sure you want to approve <b>' + university + '</b> as your placement?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approve',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        processApproveNonDegree(id);
                    }
                });
            } else {
                if (confirm('Are you sure you want to approve ' + university + ' as your placement?')) {
                    processApproveNonDegree(id);
                }
            }
        });

        function processApproveNonDegree(id) {
            $.ajax({
                type: 'POST',
                url: SITE_URL + 'grantee/placement/approve_submission_non_degree',
                data: { id: id },
                dataType: 'JSON',
                success: function(res) {
                    if (res.status) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            alert(res.message);
                            location.reload();
                        }
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error', res.message || 'Failed to approve submission.', 'error');
                        } else {
                            alert(res.message || 'Failed to approve submission.');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error', 'Server error: ' + error, 'error');
                    } else {
                        alert('Server error: ' + error);
                    }
                }
            });
        }

        // Open reject modal
        $(document).on('click', '.btn-reject-non-degree', function() {
            var id = $(this).data('id');
            var university = $(this).data('university');

            $('#reject_submission_id').val(id);
            $('#reject_university_name').text(university);
            $('#reject_note').val('');
            $('#modalAlertRejectNonDegree').addClass('hide').html('');
            $('#modalRejectNonDegree').modal('show');
        });

        // Submit reject form
        $('#formRejectNonDegree').on('submit', function(e) {
            e.preventDefault();
            var id = $('#reject_submission_id').val();
            var note = $('#reject_note').val().trim();
            var $btn = $('#btnSubmitRejectNonDegree');

            if (!note) {
                $('#modalAlertRejectNonDegree').removeClass('hide').html('Please enter a reason for rejection.');
                return false;
            }

            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            $('#modalAlertRejectNonDegree').addClass('hide').html('');

            $.ajax({
                type: 'POST',
                url: SITE_URL + 'grantee/placement/reject_submission_non_degree',
                data: {
                    id: id,
                    reject_note: note
                },
                dataType: 'JSON',
                success: function(res) {
                    $btn.prop('disabled', false).html('<i class="fa fa-times"></i> Reject Submission');
                    if (res.status) {
                        $('#modalRejectNonDegree').modal('hide');
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Rejected',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            alert(res.message);
                            location.reload();
                        }
                    } else {
                        $('#modalAlertRejectNonDegree').removeClass('hide').html(res.message || 'Failed to reject submission.');
                    }
                },
                error: function(xhr, status, error) {
                    $btn.prop('disabled', false).html('<i class="fa fa-times"></i> Reject Submission');
                    $('#modalAlertRejectNonDegree').removeClass('hide').html('Server error: ' + error);
                }
            });
        });
    });
</script>
