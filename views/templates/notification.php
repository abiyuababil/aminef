<style>
    .page-header { margin-top:20px; }
    .notif-item {
        border:1px solid rgba(15,23,42,0.06);
        border-radius:8px;
        padding:14px;
        box-shadow: 0 1px 0 rgba(15,23,42,0.03);
        margin-bottom:12px;
    }
    .notif-item:hover{
        background: #ebf2f5;
    }
    .notif-left {
        width:56px;
        height:56px;
        border-radius:10px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:18px;
        color:#fff;
        margin-right:12px;
    }
    .notif-body .title {
        margin-bottom:4px;
    }
    .notif-body .meta {
        font-size:16px;
    }
    .notif-body .notif-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .notif-link:hover .notif-body .notif-text {
        overflow: visible;
        white-space: normal;
    }
    .notif-action { font-weight:600; color:#1f6feb; text-decoration:none; }
    .notif-action:hover { text-decoration:underline; }

    /* badge variants */
    .badge-placement { background:#e6f0ff; color:#0b57d0; padding:4px 8px; border-radius:12px; font-size:12px; }
    .badge-result    { background:#e9fbef; color:#0d8a3e; padding:4px 8px; border-radius:12px; font-size:12px; }
    .badge-testing   { background:#fff4e5; color:#b75800; padding:4px 8px; border-radius:12px; font-size:12px; }
    .badge-mentoring { background:#f6eeff; color:#7a30e6; padding:4px 8px; border-radius:12px; font-size:12px; }

    .notif-right { text-align:right; min-width:110px; }
    .small-muted { 
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        color:#94a3b8; 
        font-size:13px;     
    }
    .notif-link { text-decoration:none; color: #333 !important; }
    .notif-link:hover { text-decoration:none; color: #333 !important;}

    /* floating action button */
    .fab {
        position: fixed;
        right: 20px;
        bottom: 20px;
        width:56px;
        height:56px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(180deg,#0b63d6,#0748a8);
        color:#fff;
        box-shadow: 0 10px 30px rgba(11,63,150,0.15);
        border:none;
        z-index:1000;
    }

    /* responsive tweak for small screens */
    @media (max-width:480px) {
        .notif-right { text-align:left; margin-top:8px; }
        .notif-flex { display:block; }
    }

    /* controls */
    .controls-row { margin-bottom:18px; }
    .controls-row .form-control { height:34px; }
</style>

<div class="row">
    <input type="hidden" id="is_admin" value="<?= $is_admin ?>">
    <input type="hidden" id="user_id" value="<?= $user_id ?>">

    <div class="col-lg-12">
        <h1 class="page-header">
            Notification
            <a class="btn btn-primary pull-right" id="mark-all-read">
                <i class="fa fa-check" aria-hidden="true"></i> Mark all as read
            </a>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
 <div class="row">
 </div>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <form id="frm_manage" method="GET">
                <input type="hidden" name="is_admin" value="<?php echo isset($_GET['is_admin']) ? $_GET['is_admin'] : '' ?>">
                <div id="wrap-filter" class="clearfix form-inline" style="margin:0px 15px 10px;">
                    <div class="pull-left">
                        Show :
                        <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                            <?php
                            foreach ($limit_options as $lo) {
                                $selected = '';
                                if ($lo == $_GET['limit']) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                            <?php } ?>
                        </select>
                        entries
                    </div>
                </div>
            </form>
        </div>
        <div class="panel-body">
            <?php 
                $no = $paging['start_row'];
                if($data_notifications) { 
            ?>
                <div class="col-lg-12">
                    <div id="notification-list" class="d-grid gap-3">
                    <?php foreach ($data_notifications as $notification) { ?>

                        <a class="notif-link" href="<?= base_url($notification->url) ?>">
                            <div class="notif-item clearfix notification-item <?= $notification->status == 'unread' ? 'unread' : '' ?>" data-id="<?= $notification->id ?>">
                                <div class="notif-body">
                                    <div class="title">
                                        <div class="small-muted pull-right">
                                            <?= time_ago($notification->created_at)?>
                                            <a class="btn btn-default pull-right btn-xs mark-read <?= $notification->status == 'unread' ? '' : 'hide' ?>">
                                                <i class="fa fa-check" aria-hidden="true"></i> Mark as read
                                            </a>
                                        </div>
                                    </div>
                                    <div class="meta notif-text">
                                        <?= $notification->message ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php $no++; } ?>
                    </div>
                </div>

                <?php } else { ?>
                    <div class="text-center">You don't have any new notifications.</div>
                <?php } ?>
        </div>
    </div>    
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?>
                of <?php echo number_format($paging['total_rows']) ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
