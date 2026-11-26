<script>
    let selectedIds = new Set();
    let isDragging = false;
    let dragState = false;
    let currentFilter = '<?= (!empty($status) && strtolower($status) == "unread") ? "UNREAD" : "ALL" ?>';

    function toggleSelectAll(masterCheckbox) {
        const isChecked = $(masterCheckbox).is(':checked');
        const $visibleCards = $('.notif-card:visible');

        $visibleCards.each(function () {
            const id = $(this).data('id') || parseInt($(this).attr('id').replace('notif-card-', ''));
            if (id) {
                if (isChecked) {
                    selectedIds.add(id);
                    $(this).addClass('selected');
                    $(this).find('.notif-checkbox').prop('checked', true);
                } else {
                    selectedIds.delete(id);
                    $(this).removeClass('selected');
                    $(this).find('.notif-checkbox').prop('checked', false);
                }
            }
        });

        updateBulkBar();
    }

    function handleCheckMouseDown(id, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        const $card = $('#notif-card-' + id);
        const isSelected = selectedIds.has(id);

        if (isSelected) {
            selectedIds.delete(id);
            $card.removeClass('selected');
            $card.find('.notif-checkbox').prop('checked', false);
            dragState = false;
        } else {
            selectedIds.add(id);
            $card.addClass('selected');
            $card.find('.notif-checkbox').prop('checked', true);
            dragState = true;
        }

        isDragging = true;
        updateBulkBar();
    }

    function handleCheckMouseEnter(id) {
        if (!isDragging) return;

        const $card = $('#notif-card-' + id);
        if (!$card.is(':visible')) return;

        if (dragState) {
            selectedIds.add(id);
            $card.addClass('selected');
            $card.find('.notif-checkbox').prop('checked', true);
        } else {
            selectedIds.delete(id);
            $card.removeClass('selected');
            $card.find('.notif-checkbox').prop('checked', false);
        }

        updateBulkBar();
    }

    $(document).on('mouseup', function () {
        isDragging = false;
    });

    function updateBulkBar() {
        const $bar = $('#bulkActionsBar');
        const $text = $('#selectedCountText');

        if (selectedIds.size > 0) {
            $bar.css('display', 'inline-flex');
            $text.text(`${selectedIds.size} selected`);
        } else {
            $bar.hide();
        }

        const $visibleCards = $('.notif-card:visible');
        if ($visibleCards.length > 0) {
            let allChecked = true;
            $visibleCards.each(function () {
                const id = $(this).data('id') || parseInt($(this).attr('id').replace('notif-card-', ''));
                if (id && !selectedIds.has(id)) {
                    allChecked = false;
                    return false;
                }
            });
            $('#selectAllCheckbox').prop('checked', allChecked);
        } else {
            $('#selectAllCheckbox').prop('checked', false);
        }
    }

    function setUnreadCount(newCount) {
        newCount = Math.max(0, parseInt(newCount) || 0);
        $('#count_unread').val(newCount);
        $('#unreadCount').text(newCount);

        const $badge = $('#notificationCount');
        if (newCount > 0) {
            if ($badge.length) {
                $badge.text(newCount).show();
            } else {
                $('#notificationDropdown').append('<span id="notificationCount" class="notification-badge">' + newCount + '</span>');
            }
        } else {
            if ($badge.length) {
                $badge.hide().text('0');
            }
        }
    }

    function adjustUnreadCount(delta) {
        const currentUnread = parseInt($('#count_unread').val()) || parseInt($('#unreadCount').text()) || 0;
        setUnreadCount(currentUnread + delta);
    }

    function bulkMarkAs(isRead) {
        if (selectedIds.size === 0) return;

        const ids = Array.from(selectedIds);
        const status = isRead ? 'read' : 'unread';
        const isAdmin = $('#is_admin').val() || 0;
        const userId = $('#user_id').val();

        let changedCount = 0;
        ids.forEach(function (id) {
            const $card = $('#notif-card-' + id);
            if (isRead && $card.hasClass('unread')) {
                changedCount++;
            } else if (!isRead && !$card.hasClass('unread')) {
                changedCount++;
            }
        });

        $.ajax({
            url: '<?php echo base_url('notification/bulk_mark_ajax'); ?>',
            method: 'POST',
            data: {
                ids: ids,
                status: status,
                is_admin: isAdmin,
                user_id: userId
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    ids.forEach(function (id) {
                        const $card = $('#notif-card-' + id);
                        const $btn = $card.find('.btn-single-toggle');
                        if (isRead) {
                            $card.removeClass('unread');
                            $btn.text('Mark unread');
                        } else {
                            $card.addClass('unread');
                            $btn.text('Mark read');
                        }
                        $card.removeClass('selected');
                        $card.find('.notif-checkbox').prop('checked', false);
                    });

                    selectedIds.clear();
                    $('#selectAllCheckbox').prop('checked', false);
                    updateBulkBar();

                    if (isRead) {
                        adjustUnreadCount(-changedCount);
                    } else {
                        adjustUnreadCount(changedCount);
                    }

                    if (currentFilter === 'UNREAD') {
                        applyFilter();
                    }

                    if (typeof show_toast_message === 'function') {
                        show_toast_message(isRead ? 'Notification marked as read' : 'Notification marked as unread');
                    }
                } else {
                    if (typeof show_toast_message === 'function') {
                        show_toast_message(response.message || 'Failed to update status', 'error');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
                if (typeof show_toast_message === 'function') {
                    show_toast_message('Failed to update status', 'error');
                }
            }
        });
    }

    function toggleSingleRead(id) {
        const $card = $('#notif-card-' + id);
        const isCurrentlyUnread = $card.hasClass('unread');
        const isAdmin = $('#is_admin').val() || 0;
        const userId = $('#user_id').val();

        const url = isCurrentlyUnread
            ? '<?php echo base_url('notification/mark_as_read_ajax_item'); ?>/' + id + '/' + isAdmin + '/' + userId
            : '<?php echo base_url('notification/mark_as_unread_ajax_item'); ?>/' + id + '/' + isAdmin + '/' + userId;

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const $btn = $card.find('.btn-single-toggle');
                    if (isCurrentlyUnread) {
                        $card.removeClass('unread');
                        $btn.text('Mark unread');
                        adjustUnreadCount(-1);
                        if (typeof show_toast_message === 'function') {
                            show_toast_message('Notification marked as read');
                        }
                    } else {
                        $card.addClass('unread');
                        $btn.text('Mark read');
                        adjustUnreadCount(1);
                        if (typeof show_toast_message === 'function') {
                            show_toast_message('Notification marked as unread');
                        }
                    }

                    if (currentFilter === 'UNREAD') {
                        applyFilter();
                    }
                } else {
                    if (typeof show_toast_message === 'function') {
                        show_toast_message(response.message || 'Failed to update status', 'error');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }

    function handleNotificationClick(id, url) {
        const $card = $('#notif-card-' + id);
        const isAdmin = $('#is_admin').val() || 0;

        if ($card.hasClass('unread')) {
            adjustUnreadCount(-1);
            $.ajax({
                url: '<?php echo base_url('notification/mark_as_read_ajax'); ?>/' + id + '/' + isAdmin,
                method: 'GET',
                dataType: 'json',
                complete: function () {
                    if (url && url !== '#' && url !== 'javascript:;') {
                        window.location.href = url;
                    }
                }
            });
        } else {
            if (url && url !== '#' && url !== 'javascript:;') {
                window.location.href = url;
            }
        }
    }

    function setFilter(filter, btn) {
        const newStatus = (filter === 'UNREAD') ? 'unread' : '';
        const currentVal = $('#filter_status').val() || '';
        if (newStatus === currentVal) {
            return;
        }
        $('#filter_status').val(newStatus);
        $('#loading_data').css('display', 'block');
        $('#frm_manage').submit();
    }

    function applyFilter() {
        if (currentFilter === 'UNREAD') {
            $('.notif-card').each(function () {
                if ($(this).hasClass('unread')) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        } else {
            $('.notif-card').show();
        }

        const visibleCount = $('.notif-card:visible').length;
        if (visibleCount === 0) {
            $('#emptyState').show();
        } else {
            $('#emptyState').hide();
        }

        updateBulkBar();
    }

    $(document).on('click', '#mark-all-read', function (e) {
        e.preventDefault();
        const isAdmin = $('#is_admin').val() || 0;
        const userId = $('#user_id').val();

        $.ajax({
            url: '<?php echo base_url('notification/mark_all_as_read_ajax'); ?>/' + isAdmin + '/' + userId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('.notif-card').removeClass('unread');
                    $('.btn-single-toggle').text('Mark unread');
                    setUnreadCount(0);

                    if (currentFilter === 'UNREAD') {
                        applyFilter();
                    }

                    if (typeof show_toast_message === 'function') {
                        show_toast_message('All notifications marked as read');
                    }
                } else {
                    if (typeof show_toast_message === 'function') {
                        show_toast_message('Failed to mark all notifications as read', 'error');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });

    $(document).ready(function () {
        if ($('#filter_status').length && $('#filter_status').val() === 'unread') {
            currentFilter = 'UNREAD';
        }
        const totalCount = $('#count_all').val() || '0';
        const unreadCount = parseInt($('#count_unread').val()) || 0;
        $('#totalCount').text(totalCount);
        setUnreadCount(unreadCount);
    });

	
	function submitFilter(e) {
		if (e.keyCode == 13) {
			$('#loading_data').css('display', 'block');
			$('#frm_manage').submit();
			return false;
		}
	}
</script>