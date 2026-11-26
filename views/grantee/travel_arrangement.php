<style>
    .reject-flight-popup {
        width: 722px !important;
    }
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

    .eta-file-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .eta-row-value {
        padding: 8px;
        background: #f9f9f9;
        min-height: 34px;
        display: flex;
        align-items: center;
    }

    .eta-section {
        margin-bottom: 15px;
    }

    .eta-section-header {
        cursor: pointer;
        padding: 5px 15px;
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
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .eta-section-body {
        padding: 15px;
        background: #fff;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 4px 4px;
    }

    .eta-status-label {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .eta-status-label[data-status="4"] {
        background: #d1ecf1;
        color: #0c5460;
    }

    .eta-status-label[data-status="5"] {
        background: #17a2b8;
        color: #fff;
    }

    .tab-content table th {
        background: #f5f5f5;
        font-weight: 600;
        border-bottom: 2px solid #ddd;
    }

    .tab-content table td {
        padding: 10px 8px;
        vertical-align: middle;
    }

    .eta-return-date-header,
    .eta-return-date-col {
        display: none;
    }

    .eta-section[data-flight-type="Roundtrip"] .eta-return-date-header,
    .eta-section[data-flight-type="Roundtrip"] .eta-return-date-col {
        display: table-cell;
    }

    #eta_history .eta-return-date-header,
    #eta_history .eta-return-date-col {
        display: table-cell;
    }

    .nav-pills > li > a {
        border-radius: 0;
        color: #333;
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
        padding: 3px 8px;
        font-size: 11px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    #ticketFloatingMenu .btn-ticket-view:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }

    /* ===== Flight Itinerary Confirmation Modal ===== */
    #approvedFlightDetailModal .modal-dialog {
        max-width: 620px;
    }
    .fc-modal-card {
        background: #ffffff;
        border-radius: 8px;
        width: 100%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        border: none;
    }
    .fc-modal-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 16px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .fc-modal-title-group h3 {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .fc-modal-title-group p {
        font-size: 12px;
        color: #64748b;
        margin: 2px 0 0;
    }
    .fc-btn-close {
        background: none;
        border: none;
        font-size: 20px;
        color: #94a3b8;
        cursor: pointer;
        line-height: 1;
        padding: 0;
    }
    .fc-btn-close:hover {
        color: #0f172a;
    }
    .fc-modal-body {
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .fc-route-summary-box {
        background-color: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 6px;
        padding: 14px 16px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 16px;
    }
    .fc-summary-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
        min-width: 0;
    }
    .fc-summary-label {
        font-size: 11px;
        font-weight: 700;
        color: #0369a1;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .fc-summary-val {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        overflow-wrap: anywhere;
    }
    .fc-flight-info-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .fc-section-label {
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .fc-flight-itinerary-box {
        background: #fafbfc;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 12px 14px;
        font-size: 12.5px;
        line-height: 1.6;
        color: #1e293b;
        max-height: 220px;
        overflow: auto;
        overflow-wrap: anywhere;
    }
    .fc-flight-itinerary-box table {
        width: 100% !important;
        max-width: 100%;
        table-layout: auto;
    }
    .fc-meta-details-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 12px 16px;
        align-items: center;
    }
    .fc-price-display,
    .fc-attachment-display {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }
    .fc-price-value {
        font-size: 18px;
        font-weight: 800;
        color: #0284c7;
    }
    .fc-attachment-link {
        color: #0284c7;
        text-decoration: none;
        font-weight: 600;
        font-size: 12.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        overflow-wrap: anywhere;
    }
    .fc-attachment-link:hover {
        text-decoration: underline;
        color: #0369a1;
    }
    .fc-revision-panel {
        display: none;
        background-color: #fff7ed;
        border: 1px solid #fed7aa;
        border-radius: 6px;
        padding: 12px;
        flex-direction: column;
        gap: 6px;
    }
    .fc-revision-panel textarea {
        width: 100%;
        height: 70px;
        padding: 8px;
        border: 1px solid #fdba74;
        border-radius: 4px;
        font-family: inherit;
        font-size: 12.5px;
        outline: none;
        resize: vertical;
    }
    .fc-modal-footer {
        background-color: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 14px 22px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .fc-btn-modal {
        padding: 8px 18px;
        border-radius: 4px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }
    .fc-btn-confirm {
        background-color: #16a34a;
        color: #ffffff;
    }
    .fc-btn-confirm:hover {
        background-color: #15803d;
    }
    .fc-btn-reject {
        background-color: #dc2626;
        color: #ffffff;
    }
    .fc-btn-reject:hover {
        background-color: #b91c1c;
    }
    .fc-btn-cancel {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
    }
    .fc-btn-cancel:hover {
        background-color: #f1f5f9;
    }
    @media (max-width: 575px) {
        .fc-meta-details-row,
        .fc-route-summary-box {
            grid-template-columns: 1fr;
        }
    }

</style>

<div class="col-lg-12 text-center">
    <h2 style="color:#0089d1">Travel Arrangement</h2>
</div>

<?php
if (!function_exists('parse_eta_tickets')) {
    function parse_eta_tickets($raw) {
        if (empty($raw)) return [];
        if (is_array($raw)) return array_values(array_filter($raw));
        $raw_str = trim((string)$raw);
        if ($raw_str === '') return [];
        $decoded = json_decode($raw_str, true);
        if (is_array($decoded)) {
            return array_values(array_filter($decoded));
        }
        return [$raw_str];
    }
}

$tab_count = 0;
$first_active_tab = null;

if (!empty($international_flights)) {
    $tab_count++;
    if ($first_active_tab === null) $first_active_tab = 'international';
}
if (!empty($domestic_flights)) {
    $tab_count++;
    if ($first_active_tab === null) $first_active_tab = 'domestic';
}
if (!empty($accommodation_data)) {
    $tab_count++;
    if ($first_active_tab === null) $first_active_tab = 'accommodation';
}
$has_history = !empty($history_flights);
$use_tabs = ($tab_count > 1 || $has_history);

$requested_tab = $this->input->get('tab');
if (!empty($requested_tab)) {
    $tab_aliases = [
        'international' => 'international',
        'international_ticket' => 'international',
        'domestic' => 'domestic',
        'domestic_ticket' => 'domestic',
        'accommodation' => 'accommodation',
        'accommodation_venue' => 'accommodation',
        'history' => 'history',
        'eta_history' => 'history'
    ];
    if (isset($tab_aliases[$requested_tab])) {
        $first_active_tab = $tab_aliases[$requested_tab];
    }
}
?>

<?php if ($tab_count > 1 || $has_history): ?>
<ul class="nav nav-pills in mb-3" style="border-bottom:1px solid #ddd;">
    <?php if (!empty($international_flights)): ?>
        <li class="<?php if ($first_active_tab === 'international'): ?>active<?php endif; ?>">
            <a data-toggle="tab" href="#international_ticket" class="<?php if ($first_active_tab === 'international'): ?>active<?php endif; ?>">International Ticket</a>
        </li>
    <?php endif; ?>

    <?php if (!empty($domestic_flights)): ?>
        <li class="<?php if ($first_active_tab === 'domestic'): ?>active<?php endif; ?>">
            <a data-toggle="tab" href="#domestic_ticket" class="<?php if ($first_active_tab === 'domestic'): ?>active<?php endif; ?>">Domestic Ticket</a>
        </li>
    <?php endif; ?>

    <?php if (!empty($accommodation_data)): ?>
        <li class="<?php if ($first_active_tab === 'accommodation'): ?>active<?php endif; ?>">
            <a data-toggle="tab" href="#accommodation_venue" class="<?php if ($first_active_tab === 'accommodation'): ?>active<?php endif; ?>">Accommodation / Venue</a>
        </li>
    <?php endif; ?>

    <?php if ($has_history): ?>
        <li class="pull-right <?php if ($first_active_tab === 'history'): ?>active<?php endif; ?>">
            <a data-toggle="tab" href="#eta_history" class="btn btn-default <?php if ($first_active_tab === 'history'): ?>active<?php endif; ?>"><i class="fa fa-history"></i> History</a>
        </li>
    <?php endif; ?>
</ul>
<?php endif; ?>

<div class="tab-content">
    <?php if (empty($international_flights) && empty($domestic_flights) && empty($accommodation_data) && empty($history_flights)): ?>
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> No travel arrangement data available.
            </div>
        </div>
    <?php endif; ?>
    <?php if (!empty($international_flights)): ?>
        <div id="international_ticket" class="<?php if ($use_tabs): ?>tab-pane fade<?php endif; ?> <?php if ($first_active_tab === 'international'): ?>active in<?php endif; ?>">
            <?php foreach ($international_flights as $row): ?>
                <div class="eta-section" data-flight-type="<?= htmlspecialchars($row->flight_type ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <div class="eta-section-header">
                        <h5><?= htmlspecialchars($row->category_name ?? '', ENT_QUOTES, 'UTF-8') ?><?= isset($row->flight_type) ? ' - ' . htmlspecialchars($row->flight_type, ENT_QUOTES, 'UTF-8') : '' ?></h5>
                    </div>
                    <div class="eta-section-body">
                        <div class="eta-tables-wrapper">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">From (US)</th>
                                            <th style="width:20%">To (ID)</th>
                                            <th style="width:15%">Departure Date</th>
                                            <th style="width:15%" class="eta-return-date-header">Return Date</th>
                                            <th style="width:20%">Travel Agent</th>
                                            <th style="width:10%"><?= (!empty($row->ticket_file) || $row->status_travel != ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED) ? 'Ticket' : 'Detail Approved Flights' ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars(!empty($row->departure_airport_us) ? $row->departure_airport_us : ($grantee->nearest_international_airport ?? 'N/A'), ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars($row->arrival_airport_indonesia ?? 'Jakarta (CGK)', ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars($row->departure_date ? date('d M Y', strtotime($row->departure_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td class="eta-return-date-col">
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars($row->returning_date ? date('d M Y', strtotime($row->returning_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars($row->travel_agent_name ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php $tickets = parse_eta_tickets($row->ticket_file ?? ''); ?>
                                                <?php if (!empty($tickets)): ?>
                                                    <button type="button" class="btn-ticket-pill has-tickets" data-tickets="<?= htmlspecialchars(json_encode($tickets), ENT_QUOTES, 'UTF-8') ?>" title="View ticket files">
                                                        <span class="ticket-count-label"><?= count($tickets) ?> Ticket<?= count($tickets) > 1 ? 's' : '' ?></span> <i class="fa fa-caret-down" style="font-size:10px; margin-left:2px;"></i>
                                                    </button>
                                                <?php elseif($row->status_travel == ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED): ?>
                                                    <a href="javascript:;"
                                                        data-travel-id="<?= $row->travel_id ?>"
                                                        data-tab="international"
                                                        data-flight-type="<?= htmlspecialchars($row->flight_type ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-route-from="<?= htmlspecialchars(!empty($row->departure_airport_us) ? $row->departure_airport_us : ($grantee->nearest_international_airport ?? 'N/A'), ENT_QUOTES, 'UTF-8') ?>"
                                                        data-route-to="<?= htmlspecialchars($row->arrival_airport_indonesia ?? 'Jakarta (CGK)', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-travel-agent="<?= htmlspecialchars($row->travel_agent_name ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-departure-date="<?= htmlspecialchars($row->departure_date ? date('d M Y', strtotime($row->departure_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-return-date="<?= htmlspecialchars($row->returning_date ? date('d M Y', strtotime($row->returning_date)) : '', ENT_QUOTES, 'UTF-8') ?>"
                                                        class="btn btn-sm btn-primary lightbox btn-confirm-travel">
                                                        Confirmation
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No file</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($domestic_flights)): ?>
        <div id="domestic_ticket" class="<?php if ($use_tabs): ?>tab-pane fade<?php endif; ?> <?php if ($first_active_tab === 'domestic'): ?>active in<?php endif; ?>">
            <?php foreach ($domestic_flights as $row): ?>
                <div class="eta-section" data-flight-type="<?= htmlspecialchars($row->flight_type ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <div class="eta-section-header">
                        <h5><?= htmlspecialchars($row->category_name ?? '', ENT_QUOTES, 'UTF-8') ?><?= isset($row->flight_type) ? ' - ' . htmlspecialchars($row->flight_type, ENT_QUOTES, 'UTF-8') : '' ?></h5>
                    </div>
                    <div class="eta-section-body">
                        <div class="eta-tables-wrapper">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">From (ID)</th>
                                            <th style="width:20%">To (ID)</th>
                                            <th style="width:15%">Departure Date</th>
                                            <th style="width:15%" class="eta-return-date-header">Return Date</th>
                                            <th style="width:20%">Travel Agent</th>
                                            <th style="width:10%"><?= (!empty($row->domestic_ticket_file) || $row->status_travel != ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED) ? 'Ticket' : 'Detail Approved Flights' ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars($row->domestic_departure_airport ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars($row->domestic_arrival_airport ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars($row->departure_date ? date('d M Y', strtotime($row->departure_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td class="eta-return-date-col">
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars($row->returning_date ? date('d M Y', strtotime($row->returning_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="eta-row-value">
                                                    <?= htmlspecialchars($row->travel_agent_name ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php $tickets = parse_eta_tickets($row->domestic_ticket_file ?? ''); ?>
                                                <?php if (!empty($tickets)): ?>
                                                    <button type="button" class="btn-ticket-pill has-tickets" data-tickets="<?= htmlspecialchars(json_encode($tickets), ENT_QUOTES, 'UTF-8') ?>" title="View ticket files">
                                                        <span class="ticket-count-label"><?= count($tickets) ?> Ticket<?= count($tickets) > 1 ? 's' : '' ?></span> <i class="fa fa-caret-down" style="font-size:10px; margin-left:2px;"></i>
                                                    </button>
                                                <?php elseif($row->status_travel == ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED): ?>
                                                    <a href="javascript:;"
                                                        data-travel-id="<?= $row->travel_id ?>"
                                                        data-tab="domestic"
                                                        data-flight-type="<?= htmlspecialchars($row->flight_type ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-route-from="<?= htmlspecialchars($row->domestic_departure_airport ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-route-to="<?= htmlspecialchars($row->domestic_arrival_airport ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-travel-agent="<?= htmlspecialchars($row->travel_agent_name ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-departure-date="<?= htmlspecialchars($row->departure_date ? date('d M Y', strtotime($row->departure_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-return-date="<?= htmlspecialchars($row->returning_date ? date('d M Y', strtotime($row->returning_date)) : '', ENT_QUOTES, 'UTF-8') ?>"
                                                        class="btn btn-sm btn-primary lightbox btn-confirm-travel">
                                                        Confirmation
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No file</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($accommodation_data)): ?>
        <div id="accommodation_venue" class="<?php if ($use_tabs): ?>tab-pane fade<?php endif; ?> <?php if ($first_active_tab === 'accommodation'): ?>active in<?php endif; ?>">
            <?php 
            $accommodation_by_category = [];
            foreach ($accommodation_data as $row) {
                $cat_key = $row->category_name ?? 'General';
                if (!isset($accommodation_by_category[$cat_key])) {
                    $accommodation_by_category[$cat_key] = [];
                }
                $accommodation_by_category[$cat_key][] = $row;
            }
            ?>
            
            <?php foreach ($accommodation_by_category as $category_name => $accommodations): ?>
                <div class="eta-section">
                    <div class="eta-section-header">
                        <h5><?= htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8') ?></h5>
                    </div>
                    <div class="eta-section-body">
                        <div class="eta-tables-wrapper">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:180px">Check-in Date</th>
                                            <th style="width:180px">Checkout Date</th>
                                            <th style="width:180px">Voucher</th>
                                            <!-- <th style="width:180px">Proposed Accommodation</th>
                                            <th style="width:150px">Approval Status</th>
                                            <th style="width:150px">Invoice</th>
                                            <th style="width:150px">Proof of Payment</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($accommodations as $accom): ?>
                                            <tr>
                                                <td>
                                                    <div class="eta-row-value">
                                                        <?= htmlspecialchars($accom->checkin_date ? date('d M Y', strtotime($accom->checkin_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="eta-row-value">
                                                        <?= htmlspecialchars($accom->checkout_date ? date('d M Y', strtotime($accom->checkout_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if ($accom->voucher_accommodation): ?>
                                                        <a href="<?= base_url() . htmlspecialchars($accom->voucher_accommodation, ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn-sm btn-primary lightbox">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No file</span>
                                                    <?php endif; ?>
                                                </td>
                                                <!-- <td>
                                                    <?php if ($accom->accommodation_proposed_file): ?>
                                                        <a href="<?= base_url() . htmlspecialchars($accom->accommodation_proposed_file, ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn-sm btn-primary lightbox">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No file</span>
                                                    <?php endif; ?>
                                                </td> -->
                                                <!-- <td>
                                                    <div class="eta-row-value">
                                                        <?php if (!empty($accom->status)): ?>
                                                            <?php 
                                                            $st_lbl = eta_travel_status_label($accom->status, 'accommodation'); 
                                                            $bg_color = '';
                                                            $color = '';
                                                            if ($accom->status == ETA_TRAVEL_STATUS_ISSUED) { // Voucher Sent
                                                                $bg_color = '#d4edda'; $color = '#155724';
                                                            } elseif ($accom->status == ETA_TRAVEL_STATUS_REVISION) {
                                                                $bg_color = '#fff3cd'; $color = '#856404';
                                                            } elseif ($accom->status == ETA_TRAVEL_STATUS_NEW_REQUEST) {
                                                                $bg_color = '#cce5ff'; $color = '#004085';
                                                            } elseif ($accom->status == ETA_TRAVEL_STATUS_PENDING_REVIEW) {
                                                                $bg_color = '#d1ecf1'; $color = '#0c5460';
                                                            } elseif ($accom->status == ETA_TRAVEL_STATUS_BOOK_TICKET) {
                                                                $bg_color = '#0f6cbd'; $color = '#fff';
                                                            } else {
                                                                $bg_color = '#e7e7e7'; $color = '#666';
                                                            }
                                                            ?>
                                                            <span class="eta-status-label" style="background:<?= $bg_color ?>;color:<?= $color ?>">
                                                                <?= htmlspecialchars($st_lbl, ENT_QUOTES, 'UTF-8') ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="eta-status-label" style="background:<?= ($accom->accommodation_approval_status === 'Approve') ? '#d4edda;color:#155724' : (($accom->accommodation_approval_status === 'Reject') ? '#f8d7da;color:#721c24' : '#e7e7e7;color:#666') ?>">
                                                                <?= htmlspecialchars($accom->accommodation_approval_status ?? 'Pending', ENT_QUOTES, 'UTF-8') ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td> -->
                                                <!-- <td>
                                                    <?php if ($accom->accommodation_invoice_file): ?>
                                                        <a href="<?= base_url() . htmlspecialchars($accom->accommodation_invoice_file, ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn-sm btn-primary lightbox">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No file</span>
                                                    <?php endif; ?>
                                                </td> -->
                                                <!-- <td>
                                                    <?php if ($accom->accommodation_proof_of_payment_file): ?>
                                                        <a href="<?= base_url() . htmlspecialchars($accom->accommodation_proof_of_payment_file, ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn-sm btn-primary lightbox">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No file</span>
                                                    <?php endif; ?>
                                                </td> -->
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($history_flights)): ?>
        <div id="eta_history" class="<?php if ($use_tabs): ?>tab-pane fade<?php endif; ?> <?php if ($first_active_tab === 'history'): ?>active in<?php endif; ?>">
            <?php foreach ($history_flights as $row): ?>
                <?php $hist_tab = $row->tab ?? ''; ?>
                <div class="eta-section" data-flight-type="<?= htmlspecialchars($row->flight_type ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <div class="eta-section-header">
                        <h5><?= htmlspecialchars($row->category_name ?? '', ENT_QUOTES, 'UTF-8') ?><?= isset($row->flight_type) && $row->flight_type !== '' ? ' - ' . htmlspecialchars($row->flight_type, ENT_QUOTES, 'UTF-8') : '' ?></h5>
                        <?php if ((int)($row->status_travel ?? 0) === (int)ETA_TRAVEL_STATUS_CHANGE_FLIGHT): ?>
                            <span class="eta-status-label" style="background:#f8d7da;color:#721c24;">Change Flight</span>
                        <?php else: ?>
                            <span class="eta-status-label" data-status="<?= htmlspecialchars($row->status_travel ?? '', ENT_QUOTES, 'UTF-8') ?>" style="background:#e7e7e7;color:#333;"><?= htmlspecialchars(eta_travel_status_label($row->status_travel ?? null, $hist_tab), ENT_QUOTES, 'UTF-8') ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="eta-section-body">
                        <div class="eta-tables-wrapper">
                            <div class="table-responsive">
                                <?php if ($hist_tab === 'accommodation'): ?>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width:180px">Check-in Date</th>
                                                <th style="width:180px">Checkout Date</th>
                                                <th style="width:180px">Voucher</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="eta-row-value">
                                                        <?= htmlspecialchars($row->checkin_date ? date('d M Y', strtotime($row->checkin_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="eta-row-value">
                                                        <?= htmlspecialchars($row->checkout_date ? date('d M Y', strtotime($row->checkout_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!empty($row->voucher_accommodation)): ?>
                                                        <a href="<?= base_url() . htmlspecialchars($row->voucher_accommodation, ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn-sm btn-primary lightbox">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No file</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="eta-row-value">
                                                        <?= htmlspecialchars($row->note ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width:20%"><?= $hist_tab === 'domestic' ? 'From (ID)' : 'From (US)' ?></th>
                                                <th style="width:20%">To (ID)</th>
                                                <th style="width:15%">Departure Date</th>
                                                <th style="width:15%" class="eta-return-date-header">Return Date</th>
                                                <th style="width:20%">Travel Agent</th>
                                                <th style="width:10%">Ticket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="eta-row-value">
                                                        <?php if ($hist_tab === 'domestic'): ?>
                                                            <?= htmlspecialchars($row->domestic_departure_airport ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                        <?php else: ?>
                                                            <?= htmlspecialchars(!empty($row->departure_airport_us) ? $row->departure_airport_us : ($grantee->nearest_international_airport ?? 'N/A'), ENT_QUOTES, 'UTF-8') ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="eta-row-value">
                                                        <?php if ($hist_tab === 'domestic'): ?>
                                                            <?= htmlspecialchars($row->domestic_arrival_airport ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                        <?php else: ?>
                                                            <?= htmlspecialchars($row->arrival_airport_indonesia ?? 'Jakarta (CGK)', ENT_QUOTES, 'UTF-8') ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="eta-row-value">
                                                        <?= htmlspecialchars($row->departure_date ? date('d M Y', strtotime($row->departure_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                </td>
                                                <td class="eta-return-date-col">
                                                    <div class="eta-row-value">
                                                        <?= htmlspecialchars($row->returning_date ? date('d M Y', strtotime($row->returning_date)) : 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="eta-row-value">
                                                        <?= htmlspecialchars($row->travel_agent_name ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $hist_ticket_raw = $hist_tab === 'domestic' ? ($row->domestic_ticket_file ?? null) : ($row->ticket_file ?? null);
                                                    $tickets = parse_eta_tickets($hist_ticket_raw ?? '');
                                                    ?>
                                                    <?php if (!empty($tickets)): ?>
                                                        <button type="button" class="btn-ticket-pill has-tickets" data-tickets="<?= htmlspecialchars(json_encode($tickets), ENT_QUOTES, 'UTF-8') ?>" title="View ticket files">
                                                            <span class="ticket-count-label"><?= count($tickets) ?> Ticket<?= count($tickets) > 1 ? 's' : '' ?></span> <i class="fa fa-caret-down" style="font-size:10px; margin-left:2px;"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <span class="text-muted">No file</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="approvedFlightDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content fc-modal-card">
            <div class="fc-modal-header">
                <div class="fc-modal-title-group">
                    <h3>Flight Itinerary Confirmation</h3>
                    <p>Please review and confirm your proposed flight arrangement</p>
                </div>
                <button type="button" class="fc-btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="fc-modal-body">
                <div class="fc-route-summary-box">
                    <div class="fc-summary-item">
                        <span class="fc-summary-label">Route</span>
                        <span class="fc-summary-val" id="fc-route">-</span>
                    </div>
                    <div class="fc-summary-item">
                        <span class="fc-summary-label">Travel Agent</span>
                        <span class="fc-summary-val" id="fc-agent">-</span>
                    </div>
                    <div class="fc-summary-item">
                        <span class="fc-summary-label">Departure Date</span>
                        <span class="fc-summary-val" id="fc-departure">-</span>
                    </div>
                    <div class="fc-summary-item" id="fc-return-wrap">
                        <span class="fc-summary-label">Return Date</span>
                        <span class="fc-summary-val" id="fc-return">-</span>
                    </div>
                </div>

                <div class="fc-flight-info-group">
                    <span class="fc-section-label">Flight Itinerary Details</span>
                    <div class="fc-flight-itinerary-box" id="fc-itinerary"></div>
                </div>

                <div class="fc-meta-details-row">
                    <div class="fc-price-display">
                        <span class="fc-section-label">Confirmed Rate</span>
                        <span class="fc-price-value" id="fc-price">-</span>
                    </div>
                    <div class="fc-attachment-display">
                        <span class="fc-section-label">Supporting Document</span>
                        <span id="fc-attachment">-</span>
                    </div>
                </div>

                <div class="fc-revision-panel" id="fc-revision-panel">
                    <span class="fc-section-label" style="color:#9a3412;">Reason for Rejection / Revision Request *</span>
                    <textarea id="fc-revision-notes" placeholder="Explain why this flight itinerary cannot be accepted (e.g., date conflicts, transit hours)..."></textarea>
                </div>
            </div>
            <div class="fc-modal-footer">
                <button type="button" class="fc-btn-modal fc-btn-cancel" data-dismiss="modal">Close</button>
                <button type="button" class="fc-btn-modal fc-btn-cancel" id="fc-btn-cancel-reject" style="display: none;">Cancel</button>
                <button type="button" class="fc-btn-modal fc-btn-reject" id="fc-btn-reject">✕ Not Confirm</button>
                <button type="button" class="fc-btn-modal fc-btn-confirm" id="fc-btn-confirm">✓ Confirm</button>
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
