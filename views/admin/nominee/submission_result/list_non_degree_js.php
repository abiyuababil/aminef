<script>
    const SITE_URL = '<?php echo site_url(); ?>';

    $(document).ready(function() {
        // Initialize select2 inside modal
        $('#university_id_non_degree').select2({
            dropdownParent: $('#modalNonDegree'),
            placeholder: '-- Select University --',
            allowClear: true
        });

        // Check all checkboxes
        $('.chk-all').change(function() {
            $('.chk-row').prop('checked', $(this).is(':checked'));
        });

        // Bulk action handler
        $('#frm-action .dropdown-menu a').click(function() {
            var action = $(this).data('action');
            if (action == 'delete') {
                if ($('.chk-row:checked').length == 0) {
                    alert('Please select at least one item to delete.');
                    return false;
                }
                if (confirm('Are you sure you want to delete selected data?')) {
                    $('input[name="action"]').prop('disabled', false).val(action);
                    $('#frm_manage').submit();
                }
            }
        });

        // Add New Modal
        $('.btn-add-non-degree').click(function() {
            $('#submissionFormNonDegree')[0].reset();
            $('#non_degree_id').val('');
            $('#university_id_non_degree').val('').trigger('change');
            $('#status_non_degree').val('Pending').trigger('change');
            $('#modalNonDegreeLabel').text('Add Submission Result');
            $('#modalAlertNonDegree').addClass('hide').html('');
            $('#currentLoiFile').html('');
            $('#currentIrfFile').html('');
            $('#btnDeleteLoiModal').addClass('hide').removeData('id');
            $('#btnDeleteIrfModal').addClass('hide').removeData('id');
            $('#loiRequiredStar').show();
            $('#irfRequiredStar').show();
            // $('#loiFile').prop('required', true);
            //$('#irfFile').prop('required', true);
            $('#modalNonDegree').modal('show');
        });

        // Edit Modal
        $(document).on('click', '.btn-edit-non-degree', function() {
            var id = $(this).data('id');
            $('#submissionFormNonDegree')[0].reset();
            $('#non_degree_id').val(id);
            $('#modalNonDegreeLabel').text('Edit Submission Result');
            $('#modalAlertNonDegree').addClass('hide').html('');
            $('#currentLoiFile').html('');
            $('#currentIrfFile').html('');
            $('#btnDeleteLoiModal').addClass('hide').removeData('id');
            $('#btnDeleteIrfModal').addClass('hide').removeData('id');
            $('#loiRequiredStar').hide();
            $('#irfRequiredStar').hide();
            // $('#loiFile').prop('required', false);
            // $('#irfFile').prop('required', false);

            $.ajax({
                type: 'GET',
                url: SITE_URL + 'admin/nominee/submission_result/get_detail_non_degree/' + id,
                dataType: 'JSON',
                success: function(res) {
                    if (res.status && res.data) {
                        var d = res.data;
                        $('#university_id_non_degree').val(d.university_id).trigger('change');
                        $('#status_non_degree').val(d.status).trigger('change');
                        
                        if (d.loi_file) {
                            // var loiFilename = d.loi_file.split('/').pop();
                            var loiFilename = basename(d.loi_file);
                            $('#currentLoiFile').html('<small class="text-info"><i class="fa fa-paperclip"></i> Current file: <a href="' + SITE_URL + d.loi_file + '" target="_blank">' + loiFilename + '</a></small>');
                            $('#btnDeleteLoiModal').removeClass('hide').data('id', id);
                        } else {
                            $('#currentLoiFile').html('');
                            $('#btnDeleteLoiModal').addClass('hide').removeData('id');
                        }
                        if (d.irf_file) {
                            // var irfFilename = d.irf_file.split('/').pop();
                            var irfFilename = basename(d.irf_file);
                            $('#currentIrfFile').html('<small class="text-info"><i class="fa fa-paperclip"></i> Current file: <a href="' + SITE_URL + d.irf_file + '" target="_blank">' + irfFilename + '</a></small>');
                            $('#btnDeleteIrfModal').removeClass('hide').data('id', id);
                        } else {
                            $('#currentIrfFile').html('');
                            $('#btnDeleteIrfModal').addClass('hide').removeData('id');
                        }

                        $('#modalNonDegree').modal('show');
                    } else {
                        alert(res.message || 'Failed to load details.');
                    }
                },
                error: function() {
                    alert('An error occurred while loading data.');
                }
            });
        });

        // Submit Add/Edit Form
        $('#submissionFormNonDegree').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(form);
            var $btn = $('#btnSubmitNonDegree');

            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            $('#modalAlertNonDegree').addClass('hide').html('');

            $.ajax({
                type: 'POST',
                url: SITE_URL + 'admin/nominee/submission_result/save_non_degree',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(res) {
                    $btn.prop('disabled', false).html('Save');
                    if (res.status) {
                        $('#modalNonDegree').modal('hide');
                        location.reload();
                    } else {
                        $('#modalAlertNonDegree').removeClass('hide').html(res.message || 'Failed to save data.');
                    }
                },
                error: function(xhr, status, error) {
                    $btn.prop('disabled', false).html('Save');
                    $('#modalAlertNonDegree').removeClass('hide').html('Server error: ' + error);
                }
            });
        });

        // Open Log
        $(document).on('click', '.payment-log', function(e) {
            var data_id = $(this).data('log');
            $('#email-recommendation-loading').show();
            $('#model-payment-log').hide();
            $.ajax({
                type: 'POST',
                url: SITE_URL + 'admin/nominee/submission_result/get_log_non_degree',
                dataType: 'JSON',
                data: { id: data_id },
                success: function(r) {
                    $("#model-payment-log tbody").html("");
                    if (r.status && r.data) {
                        for (let i = 0; i < r.data.length; i++) {
                            var oldData = r.data[i].old_values ? JSON.stringify(r.data[i].old_values).replace(/"/g, '&quot;').replace(/'/g, '&#39;') : null;
                            var newData = r.data[i].new_values ? JSON.stringify(r.data[i].new_values).replace(/"/g, '&quot;').replace(/'/g, '&#39;') : null;

                            var action = (r.data[i].old_values != null || r.data[i].new_values != null)
                                ? "<a data-old_data='" + oldData + "' data-new_data='" + newData + "' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>"
                                : '';

                            var created_at = "<td>" + (r.data[i].created_at || '') + "</td>";
                            var event = "<td><span class='label label-info'>" + (r.data[i].event || '') + "</span></td>";
                            var created_by = "<td>" + (r.data[i].created_name || 'System') + "</td>";
                            var pAction = "<td>" + action + "</td>";

                            $("#model-payment-log tbody").append(`<tr>${created_at}${event}${created_by}${pAction}</tr>`);
                        }
                    } else {
                        $("#model-payment-log tbody").html('<tr><td colspan="4" class="text-center text-muted">No logs recorded yet.</td></tr>');
                    }

                    $('#model-payment-log').show();
                    $('#email-recommendation-loading').hide();
                }
            });
        });

        // View Log Detail
        $(document).on('click', '.view-detail-log', function(e) {
            let element = $(this);
            let raw_old = element.data('old_data');
            let raw_new = element.data('new_data');
            let old_data = raw_old ? JSON.parse(raw_old) : null;
            let new_data = raw_new ? JSON.parse(raw_new) : null;

            if (typeof old_data === 'string') {
                try { old_data = JSON.parse(old_data); } catch (e) {}
            }
            if (typeof new_data === 'string') {
                try { new_data = JSON.parse(new_data); } catch (e) {}
            }

            console.log(old_data);
            console.log(new_data);
            // Old data table
            let element_old_data = '';
            if (old_data != null) {
                element_old_data += '<table class="table table-striped table-bordered">';
                $.each(old_data, function(key, value) {
                    if (key == 'university_id') key = 'University Name';
                    if (key == 'loi_file') {
                        key = 'Letter of Invitation File';
                        value = '<a href="'+SITE_URL+value+'" class="lightbox" target="_blank">' + basename(value) + '</a>';
                    }
                    if (key == 'irf_file') {
                        key = 'Institution Reply Form File';
                        value = '<a href="'+SITE_URL+value+'" class="lightbox" target="_blank">' + basename(value) + '</a>';
                    }
                    if (key == 'reject_note') key = 'Reject Note';
                    if (key == 'enable_upload_loi') {
                        key = 'Enable upload LOI';
                        value = value == 1 ? 'Yes' : 'No';
                    }
                    if (key == 'grantee_grant_id' || key == 'updated_by') return;

                    element_old_data += '<tr>';
                    element_old_data += '<td class="text-left" width="40%"><b>' + formatLogText(key) + '</b></td>';
                    element_old_data += '<td class="text-left">' + (value !== null ? value : '-') + '</td>';
                    element_old_data += '</tr>';
                });
                element_old_data += '</table>';
            } else {
                element_old_data = '<p class="text-muted">No previous data.</p>';
            }

            // New data table
            let element_new_data = '';
            if (new_data != null) {
                element_new_data += '<table class="table table-striped table-bordered">';
                $.each(new_data, function(key, value) {
                    if (key == 'university_id') key = 'University Name';
                    if (key == 'loi_file') {
                        key = 'Letter of Invitation File';
                        value = '<a href="'+SITE_URL+value+'" class="lightbox" target="_blank">' + basename(value) + '</a>';
                    }
                    if (key == 'irf_file') {
                        key = 'Institution Reply Form File';
                        value = '<a href="'+SITE_URL+value+'" class="lightbox" target="_blank">' + basename(value) + '</a>';
                    }
                    if (key == 'reject_note') key = 'Reject Note';
                    if (key == 'enable_upload_loi') {
                        key = 'Enable upload LOI';
                        value = value == 1 ? 'Yes' : 'No';
                    }
                    if (key == 'grantee_grant_id' || key == 'updated_by') return;

                    element_new_data += '<tr>';
                    element_new_data += '<td class="text-left" width="40%"><b>' + formatLogText(key) + '</b></td>';
                    element_new_data += '<td class="text-left">' + (value !== null ? value : '-') + '</td>';
                    element_new_data += '</tr>';
                });
                element_new_data += '</table>';
            } else {
                element_new_data = '<p class="text-muted">No new data.</p>';
            }

            $("#old-data").html(element_old_data);
            $("#new-data").html(element_new_data);
            $("#modal-payment-log").modal('hide');
            $("#mdl_detail_log").modal('show');
        });

        $('#mdl_detail_log').on('hidden.bs.modal', function () {
            $("#modal-payment-log").modal('show');
        });

        function formatLogText(text) {
            return text.replace(/_/g, ' ')
                .replace(/\b\w/g, function(char) {
                    return char.toUpperCase();
                });
        }

        // ---- Delete file helpers ----
        function deleteNdFile(id, field, onSuccess) {
            if (!confirm('Are you sure you want to delete this file?')) return;
            $.ajax({
                type: 'POST',
                url: SITE_URL + 'admin/nominee/submission_result/delete_non_degree_file',
                data: { id: id, field: field },
                dataType: 'JSON',
                success: function(r) {
                    if (r.success) {
                        if (typeof onSuccess === 'function') onSuccess();
                        else location.reload();
                    } else {
                        alert(r.message || 'Failed to delete file.');
                    }
                },
                error: function() {
                    alert('Server error while deleting file.');
                }
            });
        }

        // Delete file button in table row
        $(document).on('click', '.btn-delete-nd-file', function() {
            var id    = $(this).data('id');
            var field = $(this).data('field');
            deleteNdFile(id, field);
        });

        // Delete file button inside Edit modal
        $(document).on('click', '.btn-delete-nd-file-modal', function() {
            var field = $(this).data('field');
            var id    = $(this).data('id');
            var $btn  = $(this);
            deleteNdFile(id, field, function() {
                if (field === 'loi_file') {
                    $('#currentLoiFile').html('');
                    $btn.addClass('hide');
                } else {
                    $('#currentIrfFile').html('');
                    $btn.addClass('hide');
                }
            });
        });
    });
    
    function enable_toggle_upload_loi(element, field) {
        var isChacked = 0;
        if($(element).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        
        var id = $(element).data('id');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/nominee/submission_result/enable_toggle_upload_loi/') ?>'+ id + '/' + isChacked,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            }
        });

    }
</script>
