<script>

    let offset = 10; // Offset awal, karena 10 data pertama sudah dimuat

    $('#load-more-btn').on('click', function(){
        // Kirim permintaan AJAX untuk data berikutnya
        $.ajax({
            url: '<?php echo base_url('notification/load_more'); ?>',
            method: 'GET',
            data: { offset: offset },
            dataType: 'json',
            success: function(response){
                if(response.status === 'success' && response.data.length > 0){
                    response.data.forEach(function(notification){
                        const item = `
                        <a class="notif-link" href="#">
                            <div class="notif-item notification-item ${notification.status === 'unread' ? 'unread' : ''}" data-id="${notification.id}">
                                <div class="notif-body">
                                    <div class="meta notif-text">${notification.message}</div>
                                    <div class="small-muted">${timeAgo(notification.created_at)}</div>
                                </div>
                            </div>
                        </a>
                        `;
                        $('#notification-list').append(item);
                    });

                    // Tambahkan offset untuk permintaan berikutnya
                    offset += response.data.length;

                    // Sembunyikan tombol jika tidak ada lagi data yang bisa dimuat
                    if (response.count < 10) {
                        $('#load-more-btn').hide();
                    }
                } else {
                    // Jika tidak ada data lagi, sembunyikan tombol "Load More"
                    $('#load-more-btn').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });

    function timeAgo(timestamp) {
        const formattedTimestamp = timestamp.replace(/-/g, '/');
        const date = new Date(formattedTimestamp);

        if (isNaN(date.getTime())) {
            return 'Invalid Date';
        }
        const seconds = Math.round((new Date() - date) / 1000);
    
        let interval = seconds / 31536000;
        if (interval > 1) return Math.round(interval) + " years ago";
        interval = seconds / 2592000;
        if (interval > 1) return Math.round(interval) + " months ago";
        interval = seconds / 86400;
        if (interval > 1) return Math.round(interval) + " days ago";
        interval = seconds / 3600;
        if (interval > 1) return Math.round(interval) + " hours ago";
        interval = seconds / 60;
        if (interval > 1) return Math.round(interval) + " minutes ago";
        return Math.round(seconds) + " seconds ago";
    }

    $(document).on('click', '.mark-read', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $button = $(this);
        const countNotificationNumber = $('#notificationCount').text();
        const countNotification = $('#notificationCount');
        const notificationId = $(this).closest('.notification-item').data('id');
        const isAdmin = $('#is_admin').val() || 0;
        const userId = $('#user_id').val();

        $.ajax({
            url: '<?php echo base_url('notification/mark_as_read_ajax_item'); ?>/' + notificationId + '/' + isAdmin + '/' + userId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $(`.notification-item[data-id="${notificationId}"]`).removeClass('unread');
                    $button.addClass('hide');
                    const newCount = Math.max(0, parseInt(countNotificationNumber) - 1);
                    countNotification.text(newCount);
                    show_toast_message('Notification marked as read');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });

    $(document).on('click', '#mark-all-read', function(e) {
        e.preventDefault();
        const isAdmin = $('#is_admin').val() || 0;
        const userId = $('#user_id').val();
        const countNotification = $('#notificationCount');

        $.ajax({
            url: '<?php echo base_url('notification/mark_all_as_read_ajax'); ?>/' + isAdmin + '/' + userId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('.notification-item').removeClass('unread');
                    $('.notification-item').find('.mark-read').addClass('hide');
                    countNotification.addClass('hide');
                    show_toast_message('All notifications marked as read');
                } else {
                    show_toast_message('Failed to mark all notifications as read', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });

</script>