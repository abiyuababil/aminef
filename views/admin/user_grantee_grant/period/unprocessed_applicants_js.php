<script>
var delete_process_cancelled = false;
var current_delete_request = null;
var cancelled_users = null;
var cancelled_index = 0;
var cancelled_period_id = null;

$(document).on('click', '.btn-delete-files', function(e) {
    e.preventDefault();
    var url = $(this).data('url');

    if (!confirm('Are you sure you want to delete? Deleted files cannot be undone.')) return;

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        beforeSend: function() {
            $('.btn-delete-files').prop('disabled', true);
        },
        success: function(response) {
            if (response.status) {
                alert(response.message);
                location.reload();
            } else {
                alert('Failed to delete files.');
            }
        },
        error: function(xhr, status, error) {
            alert('Error occurred while deleting files: ' + error);
        },
        complete: function() {
            $('.btn-delete-files').prop('disabled', false);
        }
    });
});

$(document).on('click', '#btn_delete_all', function(e) {
    e.preventDefault();
    
    var $btn = $(this);
    var periodId = $btn.data('period-id') || $btn.attr('href').match(/\/(\d+)$/)[1];

    if (!confirm('Are you sure you want to delete all documents for this period? This process will delete files from each user individually to avoid timeout.')) return;

    delete_process_cancelled = false;
    cancelled_users = null;
    cancelled_index = 0;
    cancelled_period_id = periodId;
    
    $('#deleteProgressModal').modal('show');
    $('#btnCancelDelete').show();
    $('#btnCloseModal').hide();
    
    $.ajax({
        url: '<?php echo site_url('admin/user_grantee_grant/get_users_count_for_deletion'); ?>' + '/' + periodId,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status && response.total_users > 0) {
                $('#totalUsers').text(response.total_users);
                process_users_sequentially(response.users, 0);
            } else {
                $('#deleteProgressModal').modal('hide');
                alert('No users with files found to delete.');
            }
        },
        error: function(xhr) {
            $('#deleteProgressModal').modal('hide');
            alert('Error getting users list: ' + xhr.status + ' ' + xhr.statusText);
        }
    });
});

$(document).on('click', '#btnCancelDelete', function(e) {
    e.preventDefault();
    
    delete_process_cancelled = true;
    if (current_delete_request) {
        current_delete_request.abort();
    }
    
    $('#currentUser').text('Process cancelled by user');
    $('#btnCancelDelete').hide();
    $('#btnCloseModal').show();
});

$(document).on('click', '#btnCloseModal', function(e) {
    e.preventDefault();
    $('#deleteProgressModal').modal('hide');
});

function process_users_sequentially(users, index) {
    cancelled_users = users;
    cancelled_index = index;
    cancelled_period_id = cancelled_period_id || $('#btn_delete_all').data('period-id');
    
    if (delete_process_cancelled) {
        return;
    }
    
    if (index >= users.length) {
        $('#progressText').text(users.length);
        $('#deleteProgressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');
        $('#currentUser').text('Completed');
        $('#btnCancelDelete').hide();
        cancelled_users = null;
        cancelled_index = 0;
        delete_process_cancelled = false;
        
        setTimeout(function() {
            $('#deleteProgressModal').modal('hide');
            alert('All files have been successfully deleted from ' + users.length + ' users.');
            location.reload();
        }, 1500);
        return;
    }

    var current_user = users[index];
    var progress_percent = Math.round((index / users.length) * 100);
    
    $('#progressText').text(index + 1);
    $('#currentUser').text(current_user.name + ' (' + current_user.total_files + ' files)');
    $('#deleteProgressBar').css('width', progress_percent + '%').attr('aria-valuenow', progress_percent).text(progress_percent + '%');

    current_delete_request = $.ajax({
        url: '<?php echo site_url('admin/user_grantee_grant/delete_user_files'); ?>',
        type: 'POST',
        data: {
            user_grantee_id: current_user.user_grantee_id,
            grant_id: current_user.grant_id,
            grantee_grant_id: current_user.grantee_grant_id,
            period_id : current_user.period_id
        },
        dataType: 'json',
        success: function(response) {
            current_delete_request = null;
            
            if (delete_process_cancelled) {
                cancelled_index = index + 1;
                return;
            }
            
            if (response.status) {
                cancelled_index = index + 1;
                setTimeout(function() {
                    process_users_sequentially(users, index + 1);
                }, 500);
            } else {
                $('#deleteProgressModal').modal('hide');
                $('#btnCancelDelete').hide();
                alert('Error deleting files for user: ' + current_user.name);
            }
        },
        error: function(xhr) {
            current_delete_request = null;
            
            if (delete_process_cancelled || xhr.statusText === 'abort') {
                cancelled_index = index;
                return;
            }
            
            $('#deleteProgressModal').modal('hide');
            $('#btnCancelDelete').hide();
            alert('Error deleting files for user ' + current_user.name + ': ' + xhr.status + ' ' + xhr.statusText);
        }
    });
}
</script>
