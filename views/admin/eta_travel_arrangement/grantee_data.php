<ul class="nav nav-pills in">
    <li class="active">
        <a data-toggle="tab" href="#international_ticket" aria-expanded="false" aria-expanded="true"
            class="active">International Ticket</a>
    </li>
    <li>
        <a data-toggle="tab" href="#domestic_ticket">Domestic Ticket</a>
    </li>
    <li class="li">
        <a data-toggle="tab" href="#accommodation_venue">Accommodation / Venue</a>
    </li>
</ul>
<style>
    .flight-content {
        background: #f9f9f9;
        border-radius: 3px;
        padding: 10px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .flight-selection-checkbox {
        cursor: pointer;
        flex-shrink: 0;
        margin-top: 3px;
    }

    .flight-description {
        flex: 1;
        min-width: 0;
        overflow-x: auto;
    }

    /* Table dari description */
    .flight-description table {
        width: 100% !important;
        max-width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    .flight-description td,
    .flight-description th {
        max-width: none;
        word-break: normal;
        overflow-wrap: break-word;
        vertical-align: middle;
    }

    /* Hilangkan width inline seperti width: 944px */
    .flight-description table td,
    .flight-description table th {
        box-sizing: border-box;
    }

    /* Mobile */
    @media (max-width: 768px) {
        .flight-description {
            overflow-x: auto;
        }

        .flight-description table {
            min-width: 700px;
        }
    }
    .eta-tables-wrapper table {
        table-layout: auto !important;
    }

    .eta-tables-wrapper th {
        white-space: nowrap;
    }

    .eta-tables-wrapper td {
        white-space: normal;
    }

    .eta-tables-wrapper .form-control {
        min-width: 140px;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Hide Return Date column by default */
    .eta-return-date-header,
    .eta-return-date-col {
        display: none;
    }

    /* Show Return Date column for Roundtrip sections */
    .eta-section[data-flight-type="Roundtrip"] .eta-return-date-header,
    .eta-section[data-flight-type="Roundtrip"] .eta-return-date-col {
        display: table-cell;
    }

    .eta-tables-wrapper input[type=file].form-control {
        min-width: 120px;
    }

    .eta-tables-wrapper .datepicker {
        min-width: 160px;
    }

    .eta-file-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .eta-file-placeholder {
        display: inline-block;
        margin-left: 6px;
    }

    .eta-section {
        margin-bottom: 15px;
    }

    .eta-section-header {
        cursor: pointer;
        padding: 10px 15px;
        background: #013473;
        color: #fff;
        border-radius: 4px 4px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .eta-section-header h5 {
        margin: 0;
        color: #fff;
    }

    .eta-section-header .btn-remove-section {
        color: #fff;
        border-color: rgba(255,255,255,0.5);
        flex-shrink: 0;
        margin-left: 10px;
    }

    .eta-edit-category,
    .eta-edit-flight-type {
        color: #333;
        background-color: #fff;
        padding: 4px 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    .eta-section-body {
        padding: 15px;
        border-radius: 0 0 4px 4px;
    }

    .eta-section.collapsed .eta-section-body {
        display: none;
    }

    .eta-section.collapsed .eta-collapse-icon {
        transform: rotate(-90deg);
    }

    .eta-collapse-icon {
        transition: transform 0.2s ease;
        margin-right: 8px;
    }

    .eta-status-label {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .eta-status-label[data-status="1"] {
        background: #cce5ff;
        color: #004085;
    }

    .eta-status-label[data-status="2"] {
        background: #fff3cd;
        color: #856404;
    }

    .eta-status-label[data-status="3"] {
        background: #d4edda;
        color: #155724;
    }

    .eta-status-label[data-status="4"] {
        background: #d1ecf1;
        color: #0c5460;
    }

    .eta-status-label[data-status="5"] {
        background: #17a2b8;
        color: #fff;
    }

    .eta-status-label[data-status="6"] {
        background: #f8d7da;
        color: #721c24;
    }

    .eta-status-label[data-status="7"] {
        background: #0f6cbd;
        color: #fff;
    }

    .eta-status-label[data-status="8"] {
        background: #e67e22;
        color: #fff;
    }
    .eta-status-label[data-status="9"] { background: #578e9bff; color: #fff; }
    .eta-status-label[data-status="10"] { background: #cd4f46; color: #fff; }

    /* Hide Action column */
    .eta-tables-wrapper .eta-action-col {
        display: none;
    }

    .eta-tables-wrapper .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .eta-tables-wrapper table thead th:nth-child(1),
    .eta-tables-wrapper table tbody td:nth-child(1) {
        position: sticky;
        left: 0;
        background-color: #fff;
        z-index: 1000;
        overflow: hidden;
    }

    .eta-tables-wrapper table thead th:nth-child(1) {
        z-index: 1001;
    }

    /* Freeze second column (Grantee Name) */
    .eta-tables-wrapper table thead th:nth-child(2),
    .eta-tables-wrapper table tbody td:nth-child(2) {
        position: sticky;
        left: <?php echo has_permission('eta_travel_arrangement', 'tba_eta_travel_arrangement') ? '0px' : '25px'; ?>;
        background-color: #fff;
        z-index: 1000;
        overflow: hidden;
    }

    .eta-tables-wrapper table thead th:nth-child(2) {
        z-index: 1001;
    }

    /* Sticky table headers vertically */
    .eta-tables-wrapper table thead th {
        position: sticky;
        top: 0;
        z-index: 1002;
        background-color: #ebebeb !important;
    }
    .eta-tables-wrapper table thead th:nth-child(1),
    .eta-tables-wrapper table thead th:nth-child(2) {
        z-index: 1003;
    }

    /* Add box-shadow to frozen columns for visual separation */
    .eta-tables-wrapper table thead th:nth-child(1),
    .eta-tables-wrapper table tbody td:nth-child(1),
    .eta-tables-wrapper table thead th:nth-child(2),
    .eta-tables-wrapper table tbody td:nth-child(2) {
        box-shadow: 1px 0 3px rgba(0, 0, 0, 0.1);
    }

    .eta-tba-na {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .eta-tba-na:hover {
        opacity: 0.7;
    }

    .eta-file-label-loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .fa-circle-notch {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .cell-flex {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* BUTTON PILL TIKET */
    .btn-ticket-pill {
        background-color: #e0f2fe;
        color: #0284c7;
        border: 1px solid #bae6fd;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        transition: all 0.15s ease;
    }
    .btn-ticket-pill:hover { background-color: #bae6fd; }
    .btn-ticket-pill.has-tickets {
        background-color: #dcfce7;
        color: #15803d;
        border-color: #86efac;
    }
    .btn-ticket-pill.has-tickets:hover { background-color: #bbf7d0; }

    .btn-add-mini {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        border-radius: 4px;
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        padding: 0;
        line-height: 1;
        transition: all 0.15s ease;
    }
    .btn-add-mini:hover { background: #f1f5f9; border-color: #94a3b8; color: #0284c7; }

    /* FLOATING MENU DROPDOWN */
    #ticketFloatingMenu {
        display: none;
        position: fixed;
        width: 320px;
        max-width: 90vw;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.16), 0 4px 10px rgba(0, 0, 0, 0.08);
        z-index: 999;
        padding: 0;
        overflow: hidden;
    }
    #ticketFloatingMenu .ticket-menu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 9px 12px;
    }
    #ticketFloatingMenu .ticket-menu-header strong {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    #ticketFloatingMenu .ticket-menu-header .close-ticket-menu {
        border: none;
        background: transparent;
        font-size: 16px;
        line-height: 1;
        color: #64748b;
        cursor: pointer;
        padding: 2px 5px;
        border-radius: 4px;
        transition: all 0.15s ease;
    }
    #ticketFloatingMenu .ticket-menu-header .close-ticket-menu:hover {
        color: #0f172a;
        background: #e2e8f0;
    }
    #ticketFloatingMenu #ticketMenuList {
        max-height: 220px;
        overflow-y: auto;
        padding: 4px 0;
    }
    #ticketFloatingMenu .ticket-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 7px 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
        transition: background-color 0.15s ease;
    }
    #ticketFloatingMenu .ticket-item-row:hover {
        background-color: #f8fafc;
    }
    #ticketFloatingMenu .ticket-item-row:last-child {
        border-bottom: none;
    }
    #ticketFloatingMenu .ticket-item-info {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow: hidden;
        flex: 1;
        min-width: 0;
        margin-right: 8px;
    }
    #ticketFloatingMenu .ticket-item-icon {
        font-size: 13px;
        flex-shrink: 0;
    }
    #ticketFloatingMenu .ticket-item-name {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #0284c7;
        font-weight: 500;
        font-size: 12px;
        text-decoration: none;
        flex: 1;
        min-width: 0;
    }
    #ticketFloatingMenu .ticket-item-name:hover {
        text-decoration: underline;
        color: #0369a1;
    }
    #ticketFloatingMenu .ticket-item-actions {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-shrink: 0;
    }
    #ticketFloatingMenu .btn-ticket-view {
        background: #f0f9ff;
        color: #0284c7;
        border: 1px solid #bae6fd;
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 11px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    #ticketFloatingMenu .btn-ticket-view:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }
    #ticketFloatingMenu .btn-ticket-delete {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 11px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    #ticketFloatingMenu .btn-ticket-delete:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    /* ============================================================
       Finance-style UI alignment (UI only, no layout/columns changed)
       Mirrors admin/finance_eta_travel_arrangement accents:
       sky-blue #0284c7, light panels #f8fafc, borders #e2e8f0
       ============================================================ */

    /* Tabs (mirror finance .tabs-header / .tab-btn) */
    #grantees_wrap .nav.nav-pills {
        display: flex;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 20px;
        gap: 8px;
        flex-wrap: wrap;
        padding-left: 0;
        list-style: none;
    }
    #grantees_wrap .nav-pills > li {
        margin: 0;
        display: block;
    }
    #grantees_wrap .nav-pills > li > a {
        background: none;
        border: none;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 400;
        color: #0284c7;
        cursor: pointer;
        border-radius: 4px 4px 0 0;
        transition: all .15s ease;
        text-decoration: none;
        display: inline-block;
    }
    #grantees_wrap .nav-pills > li > a:hover,
    #grantees_wrap .nav-pills > li > a:focus {
        background-color: #e0f2fe;
        color: #0284c7;
    }
    #grantees_wrap .nav-pills > li.active > a,
    #grantees_wrap .nav-pills > li.active > a:focus,
    #grantees_wrap .nav-pills > li.active > a:hover {
        background-color: #0284c7;
        color: #fff;
    }

    /* Section panels (mirror finance .accordion-item / .accordion-header) */
    #grantees_wrap .eta-section {
        background: #fff;
        border: 1px solid #dcdfe6;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .02);
        overflow: hidden;
        margin-bottom: 16px;
    }
    #grantees_wrap .eta-section-header {
        background: #f8fafc;
        color: #1e293b;
        border-bottom: 1px solid transparent;
        padding: 14px 20px;
    }
    #grantees_wrap .eta-section:not(.collapsed) .eta-section-header {
        background: #f1f5f9;
        border-bottom-color: #e2e8f0;
    }
    #grantees_wrap .eta-section-header h5 {
        color: #1e293b;
        font-size: 15px;
        font-weight: 700;
    }
    #grantees_wrap .eta-section-header .eta-collapse-icon {
        color: #64748b;
    }
    #grantees_wrap .eta-section-body {
        background: #fff;
        padding: 16px;
    }
    #grantees_wrap .eta-section-header .btn-download-section {
        background: #16a34a;
        color: #fff;
        border: none;
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        font-family: inherit;
        line-height: 1.42857143;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    #grantees_wrap .eta-section-header .btn-download-section:hover,
    #grantees_wrap .eta-section-header .btn-download-section:focus {
        background: #15803d;
        color: #fff;
    }

    /* Tables (mirror finance .data-table) */
    #grantees_wrap .eta-tables-wrapper table.table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        text-align: left;
        margin-bottom: 0;
    }
    #grantees_wrap .eta-tables-wrapper table.table thead th {
        background-color: #f8fafc !important;
        color: #475569;
        font-weight: 600;
        padding: 10px 12px;
        border-top: none;
        border-bottom: 2px solid #e2e8f0;
        vertical-align: middle;
    }
    #grantees_wrap .eta-tables-wrapper table.table tbody td {
        padding: 12px;
        border-top: none;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    #grantees_wrap .eta-tables-wrapper table.table tbody tr:hover {
        background: #f8fafc;
    }
    #grantees_wrap .eta-tables-wrapper table.table tbody tr:hover td:nth-child(1),
    #grantees_wrap .eta-tables-wrapper table.table tbody tr:hover td:nth-child(2) {
        background-color: #f8fafc;
    }

    /* Status badges (mirror finance pill dimensions) */
    #grantees_wrap .eta-status-label {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
    }

</style>

<div class="eta-tables-wrapper">
    <div class="tab-content">
        <div id="international_ticket" class="tab-pane fade active in">
            <!-- Category + Flight Type selectors -->
            
            <div class="row mt-3 mb-3">
                <?php if (has_permission('eta_travel_arrangement','internal_travel_arrangement')) { ?>
                    <div class="col-md-3">
                        <label><strong>Category</strong></label>
                        <div style="display:flex; gap:6px;">
                            <select class="form-control eta-section-category" data-tab="international">
                                <option value="">- Select -</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <?php if ($cat->type === 'international'): ?>
                                            <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->name ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <button type="button" class="btn btn-sm btn-success btn-cat-add" data-tab="international" title="Add new category"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label><strong>Flight Type</strong></label>
                        <select class="form-control eta-section-flight-type" data-tab="international">
                            <option value="">- Select -</option>
                            <option value="Roundtrip">Roundtrip</option>
                            <option value="One Way">One Way</option>
                        </select>
                    </div>
                    <div class="col-md-2" style="padding-top:24px;">
                        <button type="button" class="btn btn-primary btn-add-section" data-tab="international">
                            <i class="fa fa-plus"></i> Add Section
                        </button>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                <?php } ?>  
            </div>
                                      
            <!-- Sections container -->
            <div class="eta-sections-container" data-tab="international"></div>

            <!-- Hidden template for grantee table -->
            <div id="eta_intl_tpl" class="hide">
            <div class="table-responsive" style="max-height:520px; overflow:auto;">
                <table class="table table-border mt-4" style="table-layout:auto;">
                    <thead>
                        <tr>
                            <th style="width:40px"><input type="checkbox" class="eta-select-all"></th>
                            <th style="width:200px">Grantee Name</th>
                            <th style="width:120px">Status</th>
                            <!-- <th style="width:220px">Name</th> -->
                            <th style="width:120px">Passport</th>
                            <th style="width:150px">From (US)</th>
                            <th style="width:150px">To (ID)</th>
                            <th style="width:120px">Departure Date</th>
                            <th style="width:120px" class="eta-return-date-header">Return Date</th>
                            <th style="width:150px">Proposed Flight</th>
                            <th style="width:150px">Approved Flights</th>
                            <th style="width:120px">Proposed Rate</th>
                            <th style="width:120px">Final Rate</th>
                            <th style="width:150px">Travel Agent</th>
                            <th style="width:150px">Ticket</th>
                            <th style="width:150px">Invoice</th>
                            <th style="width:150px">Proof of Payment</th>
                            <th class="eta-action-col" style="width:100px">Action</th>
                            <th style="width:220px">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($grantees) && is_array($grantees)): ?>
                            <?php foreach ($grantees as $grantee): ?>
                                <?php $t = isset($grantee->travel) ? $grantee->travel : null; ?>
                                <tr data-grantee="<?= $grantee->id ?>" data-profile-passport="<?= !empty($grantee->img_passport) ? htmlspecialchars($grantee->img_passport ?? '', ENT_QUOTES, 'UTF-8') : '' ?>">
                                    <td><input type="checkbox" class="eta-row-checkbox" data-grantee="<?= $grantee->id ?>" data-travel-id="<?= $t ? $t->id : 0 ?>"></td>
                                    <td class="td-name">
                                        <?= get_full_name($grantee, 'US') ?><br />
                                        <a 
                                            href="#" 
                                            data-grantname="<?php echo $grantee->program_name ?>" 
                                            data-period="<?php echo $grantee->fiscal_year ?>" 
                                            data-name="<?= get_full_name($grantee, 'US') ?>" 
                                            data-id="<?= $grantee->id ?>" 
                                            data-ajax_url="<?php echo site_url('admin/notes/get_list_ajax/eta_travel/' . $grantee->id . '/'); ?><?= $t ? $t->id : 0 ?>"  
                                            class="open-offcanvas-note btn btn-xs btn-warning btn-chat">
                                                <i class="fa fa-comments"></i> Chat
                                                <span class="span-note-travel" data-total="<?= $t->total_notes ?>">
                                                    <span class="badge"><?= $t->total_notes ?></span>
                                                </span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="eta-status-label text-muted" data-status="" data-grantee="<?= $grantee->id ?>"></span>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_passport_file" type="file"
                                                class="hide eta-file-input" data-field="passport_file"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_passport_file"
                                                class="btn btn-sm btn-success mb-0 hide">Choose File</label>
                                            <?php if ($t && !empty($t->passport_file)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->passport_file) ?>" title="<?= 'Passport - ' . get_full_name($grantee, 'US') ?>"><i
                                                        class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="passport_file" data-grantee="<?= $grantee->id ?>" title="Remove"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php elseif (!empty($grantee->img_passport)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($grantee->img_passport) ?>" title="<?= 'Passport - ' . get_full_name($grantee, 'US') ?>"><i
                                                        class="fa fa-eye"></i></a>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control eta-autosave" data-field="departure_airport_us"
                                            data-grantee="<?= $grantee->id ?>"
                                            value="<?= htmlspecialchars(!empty($t->departure_airport_us) ? $t->departure_airport_us : ($grantee->nearest_international_airport ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                    </td>
                                    <td><input type="text" class="form-control eta-autosave"
                                            data-field="arrival_airport_indonesia" data-grantee="<?= $grantee->id ?>"
                                            value="<?php echo empty($t->arrival_airport_indonesia) ? 'Jakarta (CGK)' : $t->arrival_airport_indonesia; ?>">
                                    </td>
                                    <td><input type="text" class="form-control datepicker eta-autosave"
                                            data-field="departure_date" data-grantee="<?= $grantee->id ?>"
                                            value="">
                                    </td>
                                    <td class="eta-return-date-col"><input type="text" class="form-control datepicker eta-autosave"
                                            data-field="returning_date" data-grantee="<?= $grantee->id ?>"
                                            value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info btn-proposed-flight" 
                                            data-travel-id="<?= $t ? $t->id : 0 ?>" 
                                            data-grantee="<?= $grantee->id ?>">
                                            <i class="fa <?= has_permission('eta_travel_arrangement', 'tba_eta_travel_arrangement') ? 'fa-plus' : 'fa-list' ?>"></i> Propose Flight
                                        </button>
                                    </td>
                                    <td>
                                        <span class="approved-flight-label" style="display: inline-block; padding: 4px 8px; background: #e7f3ff; border-radius: 3px; color: #004085; font-size: 12px;">
                                            <span data-grantee="<?= $grantee->id ?>" data-travel-id="<?= $t ? $t->id : 0 ?>">No selection</span>
                                        </span>
                                        <a class="btn btn-sm btn-primary approved-flight-attachment lightbox hide" data-grantee="<?= $grantee->id ?>" data-travel-id="<?= $t ? $t->id : 0 ?>
                                            href="#" title="<?= 'Approve Flight Attachmment - ' . get_full_name($grantee, 'US') ?>"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                        <td><input type="text" class="form-control eta-autosave" data-field="rate_in_usd"
                                            data-grantee="<?= $grantee->id ?>" readonly
                                            value="<?= htmlspecialchars($t && !empty($t->rate_in_usd) ? $t->rate_in_usd : '', ENT_QUOTES, 'UTF-8') ?>">
                                        </td>
                                        <td>
                                        <input type="text" class="form-control eta-autosave" data-field="final_rate"
                                            data-grantee="<?= $grantee->id ?>" <?php if (!has_permission('eta_travel_arrangement','tba_eta_travel_arrangement')) { echo 'readonly'; } ?>
                                            value="<?= htmlspecialchars($t && !empty($t->final_rate) ? $t->final_rate : '', ENT_QUOTES, 'UTF-8') ?>">
                                        </td>
                                    <td>
                                        <div style="display:flex; gap:6px; align-items:center;">
                                            <select class="form-control eta-autosave eta-travel-agent" data-field="travel_agent_id"
                                                data-grantee="<?= $grantee->id ?>"
                                                data-section="intl">
                                                <option value="">-- Select Agent --</option>
                                            </select>
                                            <?php if (has_permission('eta_travel_arrangement','tba_eta_travel_arrangement')) { ?>
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-add-travel-agent" title="Add travel agent"><i class="fa fa-plus"></i></button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap eta-ticket-wrap">
                                            <div class="cell-flex">
                                                <button type="button" class="btn-ticket-pill" data-field="ticket_file" data-grantee="<?= $grantee->id ?>" title="View uploaded tickets">
                                                    <span class="ticket-count-label">0 Tickets</span> <i class="fa fa-caret-down" style="font-size:10px; margin-left:2px;"></i>
                                                </button>
                                                <?php if (has_permission('eta_travel_arrangement','tba_eta_travel_arrangement')) { ?>
                                                    <button type="button" class="btn-add-mini" title="Add another ticket" data-field="ticket_file" data-grantee="<?= $grantee->id ?>">
                                                        +
                                                    </button>
                                                <?php } ?>
                                            </div>
                                            <input id="eta_file_<?= $grantee->id ?>_ticket_file" type="file"
                                                class="hide eta-file-input eta-ticket-file-input" data-field="ticket_file"
                                                data-grantee="<?= $grantee->id ?>" multiple>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_invoice_file" type="file"
                                                class="hide eta-file-input" data-field="invoice_file"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_invoice_file"
                                                class="btn btn-sm btn-success mb-0">Choose File</label>
                                            <?php if ($t && !empty($t->invoice_file)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->invoice_file) ?>" title="<?= 'Invoice - ' . get_full_name($grantee, 'US') ?>"><i
                                                        class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="invoice_file" data-grantee="<?= $grantee->id ?>" title="Remove"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_proof_of_payment_file" type="file"
                                                class="hide eta-file-input" data-field="proof_of_payment_file"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_proof_of_payment_file"
                                                class="btn btn-sm btn-success mb-0">Choose File</label>
                                            <?php if ($t && !empty($t->proof_of_payment_file)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->proof_of_payment_file) ?>"
                                                    title="<?= 'Proof of Payment - ' . get_full_name($grantee, 'US') ?>"><i class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="proof_of_payment_file" data-grantee="<?= $grantee->id ?>"
                                                    title="Remove"><i class="fa fa-trash"></i></button>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="eta-action-col">
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-eta"
                                            data-id="<?= $grantee->id ?>"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td>
                                        <textarea class="form-control eta-autosave" data-field="note" data-grantee="<?= $grantee->id ?>" rows="2" placeholder="Add note..."></textarea>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="18">No grantees found for the selected period.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            </div><!-- /eta_intl_tpl -->
        </div>

        <div id="domestic_ticket" class="tab-pane fade">
            <!-- Category + Flight Type selectors -->
            <div class="row mt-3 mb-3">
                <?php if (has_permission('eta_travel_arrangement','internal_travel_arrangement')) { ?>
                <div class="col-md-3">
                    <label><strong>Category</strong></label>
                    <div style="display:flex; gap:6px;">
                        <select class="form-control eta-section-category" data-tab="domestic">
                            <option value="">- Select -</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <?php if ($cat->type === 'domestic'): ?>
                                        <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->name ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <button type="button" class="btn btn-sm btn-success btn-cat-add" data-tab="domestic" title="Add new category"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label><strong>Flight Type</strong></label>
                    <select class="form-control eta-section-flight-type" data-tab="domestic">
                        <option value="">- Select -</option>
                        <option value="Roundtrip">Roundtrip</option>
                        <option value="One Way">One Way</option>
                    </select>
                </div>
                <div class="col-md-2" style="padding-top:24px;">
                    <button type="button" class="btn btn-primary btn-add-section" data-tab="domestic">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
                <?php } ?>
            </div>

            <!-- Sections container -->
            <div class="eta-sections-container" data-tab="domestic"></div>

            <!-- Hidden template for grantee table -->
            <div id="eta_dom_tpl" class="hide">
            <div class="table-responsive" style="max-height:520px; overflow:auto;">
                <table class="table table-border mt-4" style="table-layout:auto;">
                    <thead>
                        <tr>
                            <th style="width:40px"><input type="checkbox" class="eta-select-all"></th>
                            <th style="width:200px">Grantee Name</th>
                            <th style="width:120px">Status</th>
                            <!-- <th style="width:220px">Name</th> -->
                            <th style="width:120px">Passport</th>
                            <th style="width:150px">From (ID)</th>
                            <th style="width:150px">To (ID)</th>
                            <th style="width:120px"> Departure Date</th>
                            <th style="width:120px" class="eta-return-date-header">Return Date</th>
                            <!-- <th style="width:120px">Date of Arrival</th> -->
                            <th style="width:150px">Proposed Flight</th>
                            <th style="width:150px">Approved Flights</th>
                            <th style="width:120px">Proposed Rate</th>
                            <th style="width:120px">Final Rate</th>
                            <th style="width:150px">Travel Agent</th>
                            <th style="width:150px">Ticket</th>
                            <th style="width:150px">Invoice</th>
                            <th style="width:150px">Proof of Payment</th>
                            <th class="eta-action-col" style="width:100px">Action</th>
                            <th style="width:220px">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($grantees) && is_array($grantees)): ?>
                            <?php foreach ($grantees as $grantee): ?>
                                <?php $t = isset($grantee->travel) ? $grantee->travel : null; ?>
                                <tr data-grantee="<?= $grantee->id ?>" data-profile-passport="<?= !empty($grantee->img_passport) ? htmlspecialchars($grantee->img_passport ?? '', ENT_QUOTES, 'UTF-8') : '' ?>">
                                    <td><input type="checkbox" class="eta-row-checkbox" data-grantee="<?= $grantee->id ?>" data-travel-id="<?= $t ? $t->id : 0 ?>"></td>
                                    <td class="td-name">
                                        <?= get_full_name($grantee, 'US') ?><br />
                                        <a 
                                            href="#" 
                                            data-grantname="<?php echo $grantee->program_name ?>" 
                                            data-period="<?php echo $grantee->fiscal_year ?>" 
                                            data-name="<?= get_full_name($grantee, 'US') ?>" 
                                            data-id="<?= $grantee->id ?>" 
                                            data-ajax_url="<?php echo site_url('admin/notes/get_list_ajax/eta_travel/' . $grantee->id . '/'); ?><?= $t ? $t->id : 0 ?>"  
                                            class="open-offcanvas-note btn btn-xs btn-warning btn-chat">
                                                <i class="fa fa-comments"></i> Chat
                                                <span class="span-note-travel" data-total="<?= $t->total_notes ?>">
                                                    <span class="badge"><?= $t->total_notes ?></span>
                                                </span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="eta-status-label text-muted" data-status="" data-grantee="<?= $grantee->id ?>"></span>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_domestic_passport_file" type="file"
                                                class="hide eta-file-input" data-field="passport_file"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_domestic_passport_file"
                                                class="btn btn-sm btn-success mb-0 hide">Choose File</label>
                                            <?php if ($t && !empty($t->passport_file)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->passport_file) ?>" title="<?= 'Passport - ' . get_full_name($grantee, 'US') ?>"><i
                                                        class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="passport_file" data-grantee="<?= $grantee->id ?>" title="Remove"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php elseif (!empty($grantee->img_passport)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($grantee->img_passport) ?>" title="<?= 'Passport - ' . get_full_name($grantee, 'US') ?>"><i
                                                        class="fa fa-eye"></i></a>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control eta-autosave"
                                            data-field="domestic_departure_airport" data-grantee="<?= $grantee->id ?>"
                                            value="">
                                    </td>
                                    <td><input type="text" class="form-control eta-autosave"
                                            data-field="domestic_arrival_airport" data-grantee="<?= $grantee->id ?>"
                                            value="">
                                    </td>
                                    <td><input type="text" class="form-control datepicker eta-autosave"
                                            data-field="departure_date" data-grantee="<?= $grantee->id ?>"
                                            value="">
                                    </td>
                                    <td class="eta-return-date-col"><input type="text" class="form-control datepicker eta-autosave"
                                            data-field="returning_date" data-grantee="<?= $grantee->id ?>"
                                            value="">
                                    </td>
                                    <!-- <td><input type="text" class="form-control datepicker eta-autosave"
                                            data-field="arrival_date" data-grantee="<?= $grantee->id ?>"
                                            value="">
                                    </td> -->
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info btn-proposed-flight" 
                                            data-travel-id="<?= $t ? $t->id : 0 ?>" 
                                            data-grantee="<?= $grantee->id ?>">
                                            <i class="fa <?= has_permission('eta_travel_arrangement', 'tba_eta_travel_arrangement') ? 'fa-plus' : 'fa-list' ?>"></i> Propose Flight
                                        </button>
                                    </td>
                                    <td>
                                        <span class="approved-flight-label" style="display: inline-block; padding: 4px 8px; background: #e7f3ff; border-radius: 3px; color: #004085; font-size: 12px;">
                                            <span data-grantee="<?= $grantee->id ?>" data-travel-id="<?= $t ? $t->id : 0 ?>">No selection</span>
                                        </span>
                                        <a class="btn btn-sm btn-primary approved-flight-attachment lightbox hide mt-2" data-grantee="<?= $grantee->id ?>" data-travel-id="<?= $t ? $t->id : 0 ?>
                                            href="#" title="<?= 'Approve Flight Attachmment - ' . get_full_name($grantee, 'US') ?>"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                        <td><input type="text" class="form-control eta-autosave" data-field="rate_in_usd"
                                            data-grantee="<?= $grantee->id ?>" readonly 
                                            value="<?= htmlspecialchars($t && !empty($t->rate_in_usd) ? $t->rate_in_usd : '', ENT_QUOTES, 'UTF-8') ?>">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control eta-autosave" data-field="final_rate"
                                                data-grantee="<?= $grantee->id ?>" <?php if (!has_permission('eta_travel_arrangement','tba_eta_travel_arrangement')) { echo 'readonly'; } ?>
                                                value="<?= htmlspecialchars($t && !empty($t->final_rate) ? $t->final_rate : '', ENT_QUOTES, 'UTF-8') ?>">
                                        </td>
                                    <td>
                                        <div style="display:flex; gap:6px; align-items:center;">
                                            <select class="form-control eta-autosave eta-travel-agent" data-field="travel_agent_id"
                                                data-grantee="<?= $grantee->id ?>"
                                                data-section="domestic">
                                                <option value="">-- Select Agent --</option>
                                            </select>
                                            <?php if (has_permission('eta_travel_arrangement','tba_eta_travel_arrangement')) { ?>
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-add-travel-agent" title="Add travel agent"><i class="fa fa-plus"></i></button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap eta-ticket-wrap">
                                            <div class="cell-flex">
                                                <button type="button" class="btn-ticket-pill" data-field="domestic_ticket_file" data-grantee="<?= $grantee->id ?>" title="View uploaded tickets">
                                                    <span class="ticket-count-label">0 Tickets</span> <i class="fa fa-caret-down" style="font-size:10px; margin-left:2px;"></i>
                                                </button>
                                                <?php if (has_permission('eta_travel_arrangement','tba_eta_travel_arrangement')) { ?>
                                                    <button type="button" class="btn-add-mini" title="Add another ticket" data-field="domestic_ticket_file" data-grantee="<?= $grantee->id ?>">
                                                        +
                                                    </button>
                                                <?php } ?>
                                            </div>
                                            <input id="eta_file_<?= $grantee->id ?>_domestic_ticket_file" type="file"
                                                class="hide eta-file-input eta-ticket-file-input" data-field="domestic_ticket_file"
                                                data-grantee="<?= $grantee->id ?>" multiple>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_domestic_invoice_file" type="file"
                                                class="hide eta-file-input" data-field="domestic_invoice_file"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_domestic_invoice_file"
                                                class="btn btn-sm btn-success mb-0">Choose File</label>
                                            <?php if ($t && !empty($t->domestic_invoice_file)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->domestic_invoice_file) ?>"
                                                    title="<?= 'Invoice - ' . get_full_name($grantee, 'US') ?>"><i class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="domestic_invoice_file" data-grantee="<?= $grantee->id ?>"
                                                    title="Remove"><i class="fa fa-trash"></i></button>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_domestic_proof_of_payment_file" type="file"
                                                class="hide eta-file-input" data-field="domestic_proof_of_payment_file"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_domestic_proof_of_payment_file"
                                                class="btn btn-sm btn-success mb-0">Choose File</label>
                                            <?php if ($t && !empty($t->domestic_proof_of_payment_file)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->domestic_proof_of_payment_file) ?>"
                                                    title="<?= 'Proof of Payment - ' . get_full_name($grantee, 'US') ?>"><i class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="domestic_proof_of_payment_file" data-grantee="<?= $grantee->id ?>"
                                                    title="Remove"><i class="fa fa-trash"></i></button>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="eta-action-col">
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-eta"
                                            data-id="<?= $grantee->id ?>"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td>
                                        <textarea class="form-control eta-autosave" data-field="note" data-grantee="<?= $grantee->id ?>" rows="2" placeholder="Add note..."></textarea>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="18">No grantees found for the selected period.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            </div><!-- /eta_dom_tpl -->
        </div>

        <div id="accommodation_venue" class="tab-pane fade">
            <div class="row mt-3 mb-3">
                <?php if (has_permission('eta_travel_arrangement','internal_travel_arrangement')) { ?>
                <div class="col-md-3">
                    <label><strong>Category</strong></label>
                    <div style="display:flex; gap:6px;">
                        <select class="form-control eta-section-category" data-tab="accommodation">
                            <option value="">- Select -</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <?php if ($cat->type === 'accommodation'): ?>
                                        <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->name ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <button type="button" class="btn btn-sm btn-success btn-cat-add" data-tab="accommodation" title="Add new category"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-2" style="padding-top:24px;">
                    <button type="button" class="btn btn-primary btn-add-section" data-tab="accommodation">
                        <i class="fa fa-plus"></i> Add Section
                    </button>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
                <?php } ?>
            </div>

            <div class="eta-sections-container" data-tab="accommodation"></div>

            <div id="eta_accom_tpl" class="hide">
            <div class="table-responsive" style="max-height:520px; overflow:auto;">
                <table class="table table-border mt-4" style="table-layout:auto;">
                    <thead>
                        <tr>
                            <th style="width:40px"><input type="checkbox" class="eta-select-all"></th>
                            <th style="width:200px">Grantee Name</th>
                            <th style="width:200px">Status</th>
                            <th style="width:120px">Check-in Date</th>
                            <th style="width:120px">Checkout Date</th>
                            <th style="width:180px">Proposed Accommodation</th>
                            <th style="width:120px">Approval Status</th>
                            <th style="width:120px">Voucher</th>
                            <th style="width:150px">Invoice</th>
                            <th style="width:150px">Proof of Payment</th>
                            <th class="eta-action-col" style="width:100px">Action</th>
                            <th style="width:220px">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($grantees) && is_array($grantees)): ?>
                            <?php foreach ($grantees as $grantee): ?>
                                <?php $t = isset($grantee->travel) ? $grantee->travel : null; ?>
                                <tr data-grantee="<?= $grantee->id ?>">
                                    <td><input type="checkbox" class="eta-row-checkbox" data-grantee="<?= $grantee->id ?>" data-travel-id="<?= $t ? $t->id : 0 ?>"></td>
                                    <td class="td-name">
                                        <?= get_full_name($grantee, 'US') ?><br />
                                        <a 
                                            href="#" 
                                            data-grantname="<?php echo $grantee->program_name ?>" 
                                            data-period="<?php echo $grantee->fiscal_year ?>" 
                                            data-name="<?= get_full_name($grantee, 'US') ?>" 
                                            data-id="<?= $grantee->id ?>" 
                                            data-ajax_url="<?php echo site_url('admin/notes/get_list_ajax/eta_travel/' . $grantee->id . '/'); ?><?= $t ? $t->id : 0 ?>"  
                                            class="open-offcanvas-note btn btn-xs btn-warning btn-chat">
                                                <i class="fa fa-comments"></i> Chat
                                                <span class="span-note-travel" data-total="<?= $t->total_notes ?? 0 ?>">
                                                    <span class="badge"><?= $t->total_notes ?? 0 ?></span>
                                                </span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="eta-status-label text-muted" data-status="" data-grantee="<?= $grantee->id ?>"></span>
                                    </td>
                                    <td><input type="text" class="form-control datepicker eta-autosave"
                                            data-field="checkin_date" data-grantee="<?= $grantee->id ?>"
                                            value="">
                                    </td>
                                    <td><input type="text" class="form-control datepicker eta-autosave"
                                            data-field="checkout_date" data-grantee="<?= $grantee->id ?>"
                                            value="">
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_accommodation_proposed_file" type="file"
                                                class="hide eta-file-input" data-field="accommodation_proposed_file"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_accommodation_proposed_file"
                                                class="btn btn-sm btn-success mb-0">Choose File</label>
                                            <?php if ($t && !empty($t->accommodation_proposed_file)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->accommodation_proposed_file) ?>"
                                                    title="<?= 'Proposed Accommodation - ' . get_full_name($grantee, 'US') ?>"><i class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="accommodation_proposed_file" data-grantee="<?= $grantee->id ?>"
                                                    title="Remove"><i class="fa fa-trash"></i></button>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="form-control eta-autosave" data-field="accommodation_approval_status"
                                            data-grantee="<?= $grantee->id ?>">
                                            <option value="">- Select -</option>
                                            <option value="Approve">Approve</option>
                                            <option value="Reject">Reject</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_voucher_accommodation" type="file"
                                                class="hide eta-file-input" data-field="voucher_accommodation"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_voucher_accommodation"
                                                class="btn btn-sm btn-success mb-0">Choose File</label>
                                            <?php if ($t && !empty($t->voucher_accommodation)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->voucher_accommodation) ?>"
                                                    title="<?= 'Voucher Accommodation - ' . get_full_name($grantee, 'US') ?>"><i class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="voucher_accommodation" data-grantee="<?= $grantee->id ?>"
                                                    title="Remove"><i class="fa fa-trash"></i></button>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_accommodation_invoice_file" type="file"
                                                class="hide eta-file-input" data-field="accommodation_invoice_file"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_accommodation_invoice_file"
                                                class="btn btn-sm btn-success mb-0">Choose File</label>
                                            <?php if ($t && !empty($t->accommodation_invoice_file)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->accommodation_invoice_file) ?>"
                                                    title="<?= 'Invoice - ' . get_full_name($grantee, 'US') ?>"><i class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="accommodation_invoice_file" data-grantee="<?= $grantee->id ?>"
                                                    title="Remove"><i class="fa fa-trash"></i></button>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eta-file-wrap">
                                            <input id="eta_file_<?= $grantee->id ?>_accommodation_proof_of_payment_file"
                                                type="file" class="hide eta-file-input"
                                                data-field="accommodation_proof_of_payment_file"
                                                data-grantee="<?= $grantee->id ?>">
                                            <label for="eta_file_<?= $grantee->id ?>_accommodation_proof_of_payment_file"
                                                class="btn btn-sm btn-success mb-0">Choose File</label>
                                            <?php if ($t && !empty($t->accommodation_proof_of_payment_file)): ?>
                                                <a class="btn btn-sm btn-primary eta-file-download lightbox"
                                                    href="<?= base_url($t->accommodation_proof_of_payment_file) ?>"
                                                    title="<?= 'Proof of Payment - ' . get_full_name($grantee, 'US') ?>"><i class="fa fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger eta-file-remove"
                                                    data-field="accommodation_proof_of_payment_file"
                                                    data-grantee="<?= $grantee->id ?>" title="Remove"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php else: ?>
                                                <span class="eta-file-placeholder text-muted small">No file</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="eta-action-col">
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-eta"
                                            data-id="<?= $grantee->id ?>"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td>
                                        <textarea class="form-control eta-autosave" data-field="note" data-grantee="<?= $grantee->id ?>" rows="2" placeholder="Add note..."></textarea>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10">No grantees found for the selected period.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Travel Agent -->
<div class="modal fade" id="modalAddTravelAgent" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Travel Agent</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Agent Name</label>
                    <input type="text" class="form-control" id="travel_agent_name" placeholder="Enter travel agent name">
                </div>
                <div class="form-group">
                    <label>Email (optional)</label>
                    <input type="text" class="form-control" id="travel_agent_email" placeholder="Enter email">
                </div>
                <p class="text-muted small">New agent will be added to all Travel Agent selects.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_save_travel_agent">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Category -->
<div class="modal fade" id="modalAddCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Category</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="add_cat_tab">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" class="form-control" id="add_cat_name" placeholder="Enter category name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_save_cat">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- JS handlers moved to manage_js.php -->

<!-- Modal Change Flight -->
<div class="modal fade" id="modalChangeFlight" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Flight</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="change_flight_section_id" value="">
                <div class="form-group">
                    <label>Note</label>
                    <textarea id="change_flight_note" class="form-control" rows="3" placeholder="Enter note for Change Flight"></textarea>
                </div>
                <p class="text-muted small">The selected grantees' current records will be marked as Change Flight and new Pending Review entries will be created.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_submit_change_flight">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Menu for Uploaded Tickets -->
<div id="ticketFloatingMenu">
    <div class="ticket-menu-header">
        <strong><i class="fa fa-ticket text-primary"></i> Uploaded Tickets</strong>
        <button type="button" class="close-ticket-menu" id="btnCloseTicketMenu" title="Close">&times;</button>
    </div>
    <div id="ticketMenuList">
        <div class="text-muted text-center" style="padding:16px 12px; font-size:12px; font-style:italic;">No tickets uploaded</div>
    </div>
</div>