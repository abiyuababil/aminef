<style>
    .notification-toggle {
        border-radius: 8px;
        padding: 8px 10px;
        position: relative;
        transition: background-color 0.2s ease;
    }
    .notification-toggle .notification-badge {
        top: 4px;
        right: 2px;
    }
    .notification-toggle:hover,
    .notification-toggle:focus {
        background: rgba(255, 255, 255, 0.1);
        text-decoration: none;
    }
    .notification-toggle .fa-bell {
        color: rgba(255, 255, 255, 0.85);
        font-size: 18px;
        transition: color 0.2s ease;
    }
    .notification-toggle:hover .fa-bell,
    .notification-toggle:focus .fa-bell {
        color: #fff;
    }
    @keyframes notifFadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .navbar-top-links .dropdown-menu-notification {
        border: 0;
        border-radius: 8px;
        box-shadow: 0 10px 24px rgba(1, 52, 115, 0.16);
        font-size: 12px;
        margin-top: 12px;
        max-height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 0;
        width: 350px;
    }
    .navbar-top-links .dropdown.open > .dropdown-menu-notification {
        animation: notifFadeIn 0.15s ease forwards;
    }
    .dropdown-menu-notification .dropdown-header {
        color: #6b7c93;
        font-size: 12px;
        font-weight: 600;
        padding: 12px 18px 8px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .dropdown-menu-notification .dropdown-divider-notification {
        background: #d6e1ee;
        height: 1px;
        margin: 0;
    }
    .dropdown-menu-notification .item-notif {
        background: #fff;
        border-bottom: 1px solid #eef2f7;
        color: #16385f;
        padding: 0;
        transition: background-color 0.2s ease;
    }
    .dropdown-menu-notification .item-notif:hover,
    .dropdown-menu-notification .item-notif:focus-within {
        background: #f7f9fc;
    }
    .dropdown-menu-notification .item-notif:last-child {
        border-bottom: none;
    }
    .navbar-top-links .dropdown-menu-notification .item-notif a {
        color: inherit;
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding: 10px 18px;
        text-decoration: none;
        white-space: normal;
    }
    .dropdown-menu-notification .item-notif a:hover,
    .dropdown-menu-notification .item-notif a:focus {
        text-decoration: none;
    }
    .navbar-top-links .dropdown-menu-notification .item-notif .small {
        color: #5c738b;
        font-size: 11px;
    }
    .dropdown-menu-notification .item-notif .notif-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .dropdown-menu-notification .item-notif:hover .notif-text,
    .dropdown-menu-notification .item-notif:focus-within .notif-text {
        overflow: visible;
        white-space: normal;
    }
    .dropdown-menu-notification .item-notif.unread {
        background: #fff;
        border-left: 3px solid #2f7fbd;
        border-bottom:1px solid #ddd;
        padding: 0;
    }
    .dropdown-menu-notification .dropdown-item.text-center {
        border-top: 1px solid #d6e1ee;
        color: #2f7fbd;
        display: block;
        font-size: 13px;
        font-weight: 600;
        padding: 12px 18px;
        text-align: center;
        transition: background-color 0.2s ease, color 0.2s ease;
    }
    .dropdown-menu-notification .dropdown-item.text-center:hover,
    .dropdown-menu-notification .dropdown-item.text-center:focus {
        background: #e7eef7;
        color: #013473;
        text-decoration: none;
    }
    .dropdown-menu-notification .empty-state {
        color: #5c738b;
        font-size: 13px;
        padding: 24px 18px;
        text-align: center;
    }
</style>

<li class="nav-item dropdown">
    <a class="dropdown-toggle notification-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell"></i>
        <?php if($count_unread_notifications){ ?>
        <span id="notificationCount" class="notification-badge"><?= $count_unread_notifications ?></span>
        <?php } ?>
    </a>
    
    <ul class="dropdown-menu dropdown-menu-notification" aria-labelledby="notificationDropdown">
        <li><h6 class="dropdown-header">Notification</h6></li>
        <li class="dropdown-divider-notification"></li>
        <?php if($notifications) { ?>
            <?php foreach ($notifications as $notification) { ?>
            <li class="item-notif <?= $notification->status == 'unread' ? 'unread' : '' ?>" data-id="<?= $notification->id ?>" data-is_admin="<?= isset($is_grantee) ? 0 : 1 ?>">
                <a href="<?= base_url($notification->url) ?>">
                    <span class="notif-text"><?= notification_teaser($notification->message) ?></span>
                    <div class="small text-muted" title="<?= date('F j, Y H:i', strtotime($notification->created_at)) ?>"><?= time_ago($notification->created_at)?></div>
                </a>
            </li>
            <?php } ?>
        <?php } else { ?>
            <li class="empty-state">
                You don't have any new notifications.
            </li>
        <?php } ?>
        <li><a class="dropdown-item text-center text-primary" href="<?= base_url('notification/manage')?><?= isset($is_grantee) ? '' : '?is_admin=1'?>">Show All Notification</a></li>
    </ul>
</li>
