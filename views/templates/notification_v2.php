<style>
    .page-header { margin-top:20px; }

    /* Toolbar Utama: Select All, Bulk Actions, Filter Tabs */
    .toolbar-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        min-height: 38px;
        gap: 16px;
    }

    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
    }

    .select-all-box {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        user-select: none;
    }

    .select-all-box input {
        cursor: pointer;
        width: 16px;
        height: 16px;
    }

    /* Bulk Actions Bar */
    .bulk-actions-bar {
        display: none;
        align-items: center;
        gap: 8px;
        background-color: #f0f9ff;
        border: 1px solid #bae6fd;
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 12px;
    }

    .selected-count-label {
        font-weight: 700;
        color: #0369a1;
        margin-right: 4px;
    }

    .bulk-btn {
        background-color: #ffffff;
        color: #0284c7;
        border: 1px solid #bae6fd;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .bulk-btn:hover {
        background-color: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }

    .toolbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .filter-tabs {
        display: flex;
        gap: 6px;
    }

    .filter-tab-btn {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .filter-tab-btn.active {
        background-color: #0284c7;
        border-color: #0284c7;
        color: #ffffff;
    }

    /* Control & Pagination Row (Digunakan di Atas & Bawah) */
    .pagination-control-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12.5px;
        color: #64748b;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 12px;
    }

    .pagination-control-row.bottom {
        margin-top: 20px;
        margin-bottom: 0;
    }

    .control-left-group {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .entries-control {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #475569;
    }

    .entries-select {
        padding: 3px 8px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        font-size: 12.5px;
        outline: none;
        background: #fff;
    }

    .pagination-btns {
        display: flex;
        gap: 4px;
    }

    .page-btn {
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #0284c7;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .page-btn.active {
        background-color: #0284c7;
        border-color: #0284c7;
        color: #ffffff;
    }

    /* Notification List & Dragging Rules */
    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        user-select: none;
    }

    .notif-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: background-color 0.1s ease, border-color 0.1s ease;
        gap: 14px;
    }

    .notif-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    }

    .notif-card.unread {
        background-color: #f0f9ff;
        border-color: #bae6fd;
    }

    .notif-card.unread:hover {
        background-color: #e0f2fe;
    }

    .notif-card.selected {
        border-color: #0284c7;
    }

    /* Checkbox Area */
    .notif-check-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        padding: 4px;
        cursor: pointer;
    }

    .notif-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
        pointer-events: none;
    }

    .unread-dot {
        width: 8px;
        height: 8px;
        background-color: #0284c7;
        border-radius: 50%;
        flex-shrink: 0;
        visibility: hidden;
    }

    .notif-card.unread .unread-dot {
        visibility: visible;
    }

    .notif-clickable-body {
        flex: 1;
        cursor: pointer;
        min-width: 0;
    }

    .notif-program-tag {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .notif-message-text {
        font-size: 13px;
        color: #334155;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .notif-message-text strong {
        color: #0f172a;
    }

    .notif-right {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }

    .notif-time {
        font-size: 12px;
        color: #64748b;
    }
    .notif-time-full {
        font-size: 12px;
        color: #64748b;
        display: none;
    }

    .notif-card:hover .notif-time {
        display: none;
    }

    .notif-card:hover .notif-time-full {
        display: block;
    }

    .btn-single-toggle {
        background: none;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-single-toggle:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }

    .empty-state {
        padding: 48px;
        text-align: center;
        color: #94a3b8;
        background: #fff;
        border: 1px dashed #cbd5e1;
        border-radius: 6px;
    }

    p {
        margin: 0;
    }
</style>

<div class="row">
    <input type="hidden" id="is_admin" value="<?= $is_admin ?>">
    <input type="hidden" id="user_id" value="<?= $user_id ?>">

    <input type="hidden" id="count_all" value="<?php echo isset($count_all) ? $count_all : (isset($paging['total_rows']) ? $paging['total_rows'] : 0) ?>">
    <input type="hidden" id="count_unread" value="<?php echo ($count_unread) ?>">

    <div class="col-lg-12">
        <h1 class="page-header">
            Notification
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <?php if($is_admin) { ?>
                <div class="pull-left">
                    Fiscal Year
                    <select class="form-control input-sm" form="frm_manage" name="fiscal_year" onchange="document.forms.frm_manage.grant_id.value=''; document.forms.frm_manage.submit();">
                        <option value="" <?php echo $this->input->get('fiscal_year') ? '' : 'selected'; ?>>All</option>
                        <?php
                        $active_fiscal_year = $this->input->get('fiscal_year');
                        foreach ($fiscal_years as $fiscal_year) {
                            if (!is_numeric($fiscal_year->fiscal_year) || $fiscal_year->fiscal_year == 0) {
                                continue;
                            }
                            $selected = '';
                            if ($active_fiscal_year == $fiscal_year->fiscal_year) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?php echo $fiscal_year->fiscal_year ?>" <?php echo $selected; ?>><?php echo $fiscal_year->fiscal_year ?></option>
                        <?php } ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Program
                    <select class="form-control input-sm" form="frm_manage" name="grant_id" onchange="document.forms.frm_manage.submit()" style="width: 200px;" <?php echo $active_fiscal_year ? '' : 'disabled'; ?>>
                        <?php if (!$active_fiscal_year) { ?>
                            <option value="">Select fiscal year first</option>
                        <?php } else { ?>
                            <option value="" <?php echo $this->input->get('grant_id') ? '' : 'selected'; ?>>All</option>
                            <?php
                            $active_program = $this->input->get('grant_id');
                            foreach ($programs as $program) {
                                $selected = '';
                                if ($active_program == $program->grant_id) {
                                    $selected = 'selected';
                                }
        
                                ?>
                                <option value="<?php echo $program->grant_id ?>" <?php echo $selected ?>><?php echo $program->name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <?php } ?>
                <div class="pull-right">
                    Search : <input 
                                type="search" 
                                class="form-control input-sm" 
                                name="q" 
                                value="<?php echo isset($q) ? $q : '' ?>"
                                placeholder="" 
                                form="frm_manage"
                                onkeypress="return submitFilter(event)">
                </div>
            </div>


            <!-- Toolbar Atas: Select All, Bulk Actions, Filter Tabs -->
            <div class="toolbar-row">
              <div class="toolbar-left">
                <label class="select-all-box">
                  <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)">
                  <span>Select All</span>
                </label>
        
                <div class="bulk-actions-bar" id="bulkActionsBar">
                  <span class="selected-count-label" id="selectedCountText">0 selected</span>
                  <button type="button" class="bulk-btn" onclick="bulkMarkAs(true)">Mark as Read</button>
                  <button type="button" class="bulk-btn" onclick="bulkMarkAs(false)">Mark as Unread</button>
                </div>
              </div>
        
              <div class="toolbar-right">
                <div class="filter-tabs">
                  <button type="button" class="filter-tab-btn <?= (empty($status) || $status == 'all') ? 'active' : '' ?>" id="filterAllBtn" onclick="setFilter('ALL', this)">
                    All (<span id="totalCount"><?= isset($count_all) ? number_format($count_all) : (isset($paging['total_rows']) ? number_format($paging['total_rows']) : 0) ?></span>)
                  </button>
                  <button type="button" class="filter-tab-btn <?= (!empty($status) && $status == 'unread') ? 'active' : '' ?>" id="filterUnreadBtn" onclick="setFilter('UNREAD', this)">
                    Unread (<span id="unreadCount"><?= isset($count_unread) ? number_format($count_unread) : 0 ?></span>)
                  </button>
                </div>
              </div>
            </div>
        
            <!-- BARIS KONTROL DI ATAS TABEL (SESUAI GAMBAR) -->
            <form id="frm_manage" action="<?= base_url('notification/manage') ?>" method="GET">
            <input type="hidden" name="status" id="filter_status" value="<?php echo isset($status) ? htmlspecialchars($status, ENT_QUOTES, 'UTF-8') : '' ?>">
            <div class="pagination-control-row">
              <div class="control-left-group">
                <div class="entries-control">
                    Show :
                    <input type="hidden" name="is_admin" value="<?php echo isset($_GET['is_admin']) ? $_GET['is_admin'] : '' ?>">
                    <select class="entries-select" name="limit" onchange="document.forms.frm_manage.submit()">
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
                <div class="pagination-info-text">Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo number_format($paging['total_rows']) ?> entries</div>
              </div>
        
              <div class="pagination-btns" id="paginationBtnsTop">
                <?php echo $paging['html'] ?>
              </div>
            </div>
            </form>
        
            <!-- Notification List Container -->
            <div class="notif-list" id="notifListContainer">
                <?php foreach ($data_notifications as $notification) { ?>
                <div class="notif-card <?= $notification->status == 'unread' ? 'unread' : '' ?>" id="notif-card-<?= $notification->id ?>" data-id="<?= $notification->id ?>">
                    
                    <div class="notif-check-wrapper" 
                        onmousedown="handleCheckMouseDown(<?= $notification->id ?>, event)"
                        onmouseenter="handleCheckMouseEnter(<?= $notification->id ?>)">
                    <input type="checkbox" class="notif-checkbox">
                    <div class="unread-dot"></div>
                    </div>
        
                    <div class="notif-clickable-body" onclick="handleNotificationClick(<?= $notification->id ?>, '<?= base_url($notification->url) ?>')">
                    <div class="notif-message-text"><?= $notification->message ?></div>
                    </div>
        
                    <div class="notif-right" onclick="event.stopPropagation()">
                    <span class="notif-time"><?= time_ago($notification->created_at)?></span>
                    <span class="notif-time-full"><?= date('Y-m-d H:i:s', strtotime($notification->created_at))?></span>
                    <button type="button" class="btn-single-toggle" onclick="toggleSingleRead(<?= $notification->id ?>)">
                        <?= $notification->status == 'unread' ? 'Mark read' : 'Mark unread' ?>
                    </button>
                    </div>
        
                </div>
                <?php } ?>
            </div>
        
            <div class="empty-state" id="emptyState" style="<?= empty($data_notifications) ? 'display: block;' : 'display: none;' ?>">
              No notifications found.
            </div>
        
            <!-- BARIS KONTROL DI BAWAH TABEL -->
            <div class="pagination-control-row bottom">
              <div class="control-left-group">
                <div class="pagination-info-text">Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo number_format($paging['total_rows']) ?> entries</div>
              </div>
        
              <div class="pagination-btns" id="paginationBtnsBottom">
                <?php echo $paging['html'] ?>
              </div>
            </div>
        </div>
    </div>
</div>
