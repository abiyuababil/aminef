<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $title ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?php
        if (!function_exists('format_admin_travel_date')) {
            function format_admin_travel_date($date)
            {
                if (empty($date)) {
                    return '-';
                }

                $timestamp = strtotime($date);
                if ($timestamp === false) {
                    return '-';
                }

                return date('d F Y', $timestamp);
            }
        }
        if (!function_exists('format_admin_travel_datetime')) {
            function format_admin_travel_datetime($date)
            {
                if (empty($date)) {
                    return '-';
                }

                $timestamp = strtotime($date);
                if ($timestamp === false) {
                    return '-';
                }

                return date('d F Y H:i', $timestamp);
            }
        }
        ?>

        <?php
        $tba_flight_proposals = isset($tba_flight_proposals) && is_array($tba_flight_proposals) ? $tba_flight_proposals : [];
        $filter_tba_flight_proposals = array_filter($tba_flight_proposals, function ($proposal) {
            return $proposal->ref_type !== 'tba_car_rental_proposal' && $proposal->ref_type !== 'tba_accommodation_proposal';
        });

        $tba_flight_proposals_car = array_filter($tba_flight_proposals, function ($proposal) {
            return $proposal->ref_type === 'tba_car_rental_proposal';
        });

        $tba_flight_proposals_accommodation = array_filter($tba_flight_proposals, function ($proposal) {
            return $proposal->ref_type === 'tba_accommodation_proposal';
        });
        
        $tba_international_proposals = [];
        $tba_other_proposals = [];
        $tba_car_rental_proposals = [];
        $tba_accommodation_proposals = [];
        $tba_proposal_count = count($filter_tba_flight_proposals);
        $has_submitted_tba_selection = false;
        $has_submitted_tba_selection_car = false;
        $has_submitted_tba_selection_accommodation = false;

        foreach ($tba_flight_proposals as $proposal) {
            if ((int)$proposal->is_selected === 1) {
                $has_submitted_tba_selection = true;
                break;
            }
        }

        foreach ($tba_flight_proposals_car as $proposal) {
            if ((int)$proposal->is_selected === 1) {
                $has_submitted_tba_selection_car = true;
                break;
            }
        }

        foreach ($tba_flight_proposals_accommodation as $proposal) {
            if ((int)$proposal->is_selected === 1) {
                $has_submitted_tba_selection_accommodation = true;
                break;
            }
        }

        foreach ($tba_flight_proposals as $proposal) {
            if ($proposal->ref_type === 'tba_international_flight_proposal') {
                $tba_international_proposals[] = $proposal;
                continue;
            }

            if ($proposal->ref_type === 'tba_other_flight_proposal') {
                $tba_other_proposals[] = $proposal;
            }

            if ($proposal->ref_type === 'tba_car_rental_proposal') {
                $tba_car_rental_proposals[] = $proposal;
            }

            if ($proposal->ref_type === 'tba_accommodation_proposal') {
                $tba_accommodation_proposals[] = $proposal;
            }
        }

        $ticket_international = [];
        $ticket_domestic = [];
        $ticket_accommodation = [];

        foreach ($tickets as $ticket) {
            if ($ticket->type === 'international') {
                $ticket_international[] = $ticket;
                continue;
            }

            if ($ticket->type === 'domestic') {
                $ticket_domestic[] = $ticket;
            }

            if ($ticket->type === 'accommodation') {
                $ticket_accommodation[] = $ticket;
            }
        }

        $tba_car_rental_count = count($tba_car_rental_proposals);
        $tba_accommodation_count = count($tba_accommodation_proposals);
        $can_manage_tba = has_permission('travel_arrangement', 'tba_eta_travel_arrangement');
        $is_aminef_staff_permission = has_permission('travel_arrangement', 'internal_travel_arrangement');
        
        $has_tba_selection = false;
        foreach ($tba_flight_proposals as $p) {
            if ((int)($p->is_selected ?? 0) === 1) {
                $has_tba_selection = true;
                break;
            }
        }

        $currency_international = 'USD';
        foreach ($tba_international_proposals as $proposal) {
            if ((int)$proposal->is_selected === 1) {
                $currency_international = !empty($proposal->currency) ? $proposal->currency : 'USD';
                break;
            }
        }

        $currency_domestic = 'IDR';
        foreach ($tba_other_proposals as $proposal) {
            if ((int)$proposal->is_selected === 1) {
                $currency_domestic = !empty($proposal->currency) ? $proposal->currency : 'IDR';
                break;
            }
        }

        $currency_accommodation = 'IDR';
        foreach ($tba_accommodation_proposals as $proposal) {
            if ((int)$proposal->is_selected === 1) {
                $currency_accommodation = !empty($proposal->currency) ? $proposal->currency : 'IDR';
                break;
            }
        }
        ?>

        <style>
            .nav-pills > li > a {
                color: #333;
                border-radius: 0;
                background-color: #f0f2f4;
                margin-right: 8px;
            }
            .nav-pills > li.active > a,
            .nav-pills > li.active > a:focus,
            .nav-pills > li.active > a:hover {
                background-color: #013473;
                color: #fff;
            }
            .tab-content {
                padding: 20px;
                background: #fff;
                border: 1px solid #e3e7ea;
                border-radius: 2px;
            }
            .flight-detail-item {
                margin-bottom: 12px;
            }
            .flight-detail-item strong {
                display: block;
                margin-bottom: 2px;
                color: #2f3a44;
            }
            .aminef-info {
                border: 1px solid #e3e7ea;
                background: #fff;
                padding: 15px;
                margin-bottom: 15px;
            }
            .aminef-travel-purpose p {
                margin: 0;
            }
            .tba-section {
                margin-bottom: 28px;
            }
            .tba-section-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 12px;
            }
            .tba-table td {
                vertical-align: top !important;
            }
            .tba-table .proposal-description {
                white-space: pre-wrap;
                min-width: 280px;
            }
            .tba-table tr.is-selected td {
                background-color: #EDF9F0;
                color: #1F7A34;
                border-color: #28a745 !important;
            }
            /* Card style similar to grantee view */
            .tba-proposal-card {
                background: #fff;
                border: 1px solid #dfe7ef;
                border-radius: 6px;
                padding: 16px;
                margin-bottom: 0;
                position: relative;
                width: calc((100% - 32px) / 3);
                min-width: 0;
                display: flex;
                flex-direction: column;
            }
            .tba-proposal-card:last-child { margin-bottom: 0; }
            .tba-proposal-description { white-space: pre-wrap; color: #4f5f6f; margin-bottom: 10px; font-weight: 400; border-left: 3px solid #dfe7ef; padding-left: 10px; }
            .tba-proposal-description.is-clamped { display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; line-clamp: 2; overflow: hidden; white-space: normal; }
            .tba-proposal-description-toggle { display: none; margin-top: -4px; margin-bottom: 10px; padding: 0; border: 0; background: transparent; color: #0e6ba8; font-size: 12px; font-weight: 400; text-decoration: underline; }
            .tba-proposal-description-toggle:focus, .tba-proposal-description-toggle:hover { color: #0a537f; outline: none; }
            .tba-proposal-price { color: #0e6ba8; font-weight: 400; }
            .tba-proposal-time-limit { margin-top: 8px; color: #6b7783; font-size: 13px; }
            .tba-proposal-time-limit strong { font-weight: 400; }
            .tba-proposal-card .tba-proposal-actions {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                margin-left: auto;
                flex-shrink: 0;
            }
            .tba-proposal-card.is-selected { border-color: #28a745; background: #edf9f0; box-shadow: inset 0 0 0 1px #b9e3c4; }
            .tba-proposal-card.is-selected .tba-proposal-price { color: #1f7a34; }
            .tba-proposal-card.is-selected .tba-proposal-description { border-left-color: #7bc48d; }
            .tba-proposal-header { display: flex; align-items: flex-start; gap: 6px; flex-wrap: wrap; margin-bottom: 6px; }
            .tba-proposal-header strong { display: inline-flex; align-items: center; line-height: 20px; }
            .tba-proposal-selected-note { display: inline-flex; align-items: center; gap: 4px; color: #1f7a34; font-weight: 600; font-size: 13px; line-height: 20px; }
            .tba-proposals-list {
                display: flex;
                flex-wrap: wrap;
                gap: 16px;
                align-items: stretch;
            }
            .tba-proposal-meta {
                display: flex;
                align-items: baseline;
                gap: 6px;
                flex-wrap: wrap;
                min-width: 0;
            }
            @media (max-width: 991px) {
                .tba-proposal-card {
                    width: calc((100% - 16px) / 2);
                }
            }
            @media (max-width: 767px) {
                .tba-proposal-card {
                    width: 100%;
                }
            }

            .tba-proposal-option {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
            }
            .tba-proposal-option input[type="radio"] {
                display: none;
            }
            .tba-proposal-option > span {
                flex: 1;
            }

            /* Cards */
            .card {
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-bottom: 20px;
                background: #fff;
            }
            .card-body {
                padding: 20px;
            }
            
            /* Grid Layout */
            .grid-2-col {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 20px;
            }

            /* Field Styling */
            .field {
                margin-bottom: 15px;
            }
            .field:last-child {
                margin-bottom: 0;
            }
            .label-card {
                font-weight: bold;
                font-size: 14px;
                margin-bottom: 4px;
                color: #333;
            }
            .value {
                font-size: 14px;
                color: #333;
            }

            /* Links (Passport) */
            .passport-link {
                color: #337ab7;
                text-decoration: none;
                cursor: pointer;
                display: inline-block;
            }
            .passport-link:hover {
                text-decoration: underline;
            }

            /* Multiple Dependents List */
            .dependent-list {
                display: flex;
                flex-direction: column;
                gap: 8px; /* Jarak antar dokumen dependen */
            }

            /* Card Footer */
            .card-footer {
                padding: 15px 20px;
                background-color: #f9f9f9;
                border-top: 1px solid #ddd;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .status-container {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 14px;
                font-weight: bold;
            }



            /* Section Header dengan Tombol Notify di Kanan Atas */
            .section-header-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .section-title {
                font-size: 16px;
                font-weight: 700;
                color: #0f172a;
            }

            .btn-notify {
                background-color: #16a34a;
                color: #ffffff;
                border: none;
                padding: 7px 16px;
                border-radius: 4px;
                font-size: 12.5px;
                font-weight: 600;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: background-color 0.15s ease;
            }

            .btn-notify:hover {
                background-color: #15803d;
            }

            /* Table Style */
            .ticket-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 13px;
            }

            .ticket-table th {
                background-color: #f1f5f9;
                color: #475569;
                font-weight: 600;
                padding: 10px 14px;
                border: 1px solid #e2e8f0;
                text-align: left;
            }

            .ticket-table td {
                padding: 10px 14px;
                border: 1px solid #e2e8f0;
                vertical-align: middle;
            }

            .ticket-table tr:hover {
                background-color: #fafbfc;
            }

            .file-preview-cell {
                display: flex;
                align-items: center;
                gap: 8px;
                font-weight: 500;
            }

            .file-preview-cell a {
                color: #0284c7;
                text-decoration: none;
                word-break: break-all;
            }

            .file-preview-cell a:hover {
                text-decoration: underline;
            }

            .table-input-note {
                width: 100%;
                padding: 6px 10px;
                border: 1px solid #cbd5e1;
                border-radius: 4px;
                font-size: 12.5px;
                outline: none;
            }

            .table-input-note:focus {
                border-color: #0284c7;
            }

            /* Table Action Buttons */
            .table-action-group {
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .btn-upload-direct {
                background-color: #0284c7;
                color: #ffffff;
                border: none;
                padding: 5px 12px;
                border-radius: 4px;
                font-size: 11.5px;
                font-weight: 600;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 4px;
            }

            .btn-upload-direct:hover {
                background-color: #0369a1;
            }

            .btn-delete-row {
                background-color: #dc2626;
                color: #ffffff;
                border: none;
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 11.5px;
                font-weight: 600;
                cursor: pointer;
            }

            .btn-delete-row:hover {
                background-color: #b91c1c;
            }

            /* Bawah Tabel: Tombol Tambah Row */
            .table-bottom-bar {
                display: flex;
                justify-content: flex-start;
                margin-top: 8px;
            }

            .btn-add-row {
                background-color: #ffffff;
                border: 1px dashed #0284c7;
                color: #0284c7;
                padding: 6px 14px;
                border-radius: 4px;
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: all 0.15s ease;
            }

            .btn-add-row:hover {
                background-color: #f0f9ff;
                border-color: #0369a1;
            }

            /* Car Rental Plain Container */
            .car-rental-direct-text {
                font-size: 13.5px;
                color: #1e293b;
                margin-top: 4px;
                font-family: inherit;
                white-space: pre-wrap;
                word-break: break-word;
            }
            
            /* ================= ACTION BANNER TERINTEGRASI (MEMO BUDGET & ACTIVITY) ================= */
            .action-banner-approval {
                background-color: #fefce8;
                border: 1px solid #fef08a;
                border-radius: 4px;
                padding: 14px 18px;
                margin-bottom: 20px;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .banner-top-text {
                font-size: 13px;
                color: #854d0e;
                border-bottom: 1px dashed #fde047;
                padding-bottom: 10px;
            }
            .banner-top-text strong {
                color: #713f12;
            }

            .banner-controls-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 16px;
            }

            .budget-inputs-group {
                display: flex;
                align-items: center;
                gap: 16px;
                flex-wrap: wrap;
            }

            .input-inline-item {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .input-inline-item label {
                font-size: 12.5px;
                font-weight: 700;
                color: #713f12;
                white-space: nowrap;
            }

            .control-select, .control-text {
                padding: 6px 10px;
                border: 1px solid #cbd5e1;
                border-radius: 4px;
                font-size: 12.5px;
                background-color: #ffffff;
                color: #0f172a;
                outline: none;
            }

            .control-select:focus, .control-text:focus {
                border-color: #0284c7;
            }

            .control-select { min-width: 220px; }
            .control-text { min-width: 200px; }
            .control-select:disabled { background-color: #eee; }
            .control-text:disabled { background-color: #eee; }

            .banner-btns {
                display: flex;
                gap: 8px;
            }
        </style>

        <?php
        // $active_tab = 'flight-details';
        $active_tab = 'flight-details';
        if (isset($_GET['pid'])) {
            if ($_GET['pid'] === 'tba-flight-proposal') {
                $active_tab = 'tba-flight-proposal';
            } elseif ($_GET['pid'] === 'ticket') {
                $active_tab = 'ticket';
            }
        }
        if ($application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL) {
            $active_tab = 'tba-flight-proposal';
        }
        $is_approved = $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED || $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT;
        $tickets = isset($tickets) ? $tickets : [];
        ?>

        <?php if ($application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_SUBMITTED): ?>
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> This AMINEF-arranged travel application is currently in progress.
            </div>
        <?php endif; ?>

        <div class="card" style="position:relative;">
            <div class="pull-right" style="position:absolute;top:12px;right:20px;z-index:5;">
                <?php
                    $del_total = isset($total_payments) ? (int) $total_payments : 0;
                    $delete_with_url = site_url("admin/travel_arrangement_non_eta/delete/".$application->id."?mode=with_payments");
                    $delete_keep_url = site_url("admin/travel_arrangement_non_eta/delete/".$application->id."?mode=keep_payments");
                    $delete_plain_url = site_url("admin/travel_arrangement_non_eta/delete/".$application->id);
                ?>
                <a href="<?php echo $delete_plain_url ?>" class="btn btn-danger btn-delete-travel <?= $is_aminef_staff_permission || $can_manage_tba ? '' : 'hide' ?>" data-payments="<?php echo $del_total ?>" data-with-url="<?php echo $delete_with_url ?>" data-keep-url="<?php echo $delete_keep_url ?>">
                    <i class="fa fa-trash"></i> Delete
                </a>
            </div>
            <div class="card-body grid-2-col">
                <div>
                    <div class="field">
                        <div class="label-card">Grantee Name:</div>
                        <div class="value"><?= get_full_name($grantee_grant, 'US') ?></div>
                    </div>
                    <div class="field">
                        <div class="label-card">Application Type:</div>
                        <div class="value">Arranged by AMINEF</div>
                    </div>
                    <div class="field">
                        <div class="label-card">Email:</div>
                        <div class="value"><?= $grantee_grant->primary_email ?></div>
                    </div>
                    <div class="field">
                        <div class="label-card">Cell Phone Number:</div>
                        <div class="value"><?= $grantee_grant->phone_number ?></div>
                    </div>
                    <div class="field">
                        <div class="label-card">Home Phone Number:</div>
                        <div class="value"><?= $grantee_grant->home_phone_number ?></div>
                    </div>
                </div>
                
                <div>
                    <div class="field">
                        <div class="label-card">Created At:</div>
                        <div class="value"><?= $application->created_at ? date('d F Y H:i', strtotime($application->created_at)) : '-' ?></div>
                    </div>
                    <div class="field">
                        <div class="label-card">Updated At:</div>
                        <div class="value"><?= $application->updated_at ? date('d F Y H:i', strtotime($application->updated_at)) : '-' ?></div>
                    </div>
                    
                    <div class="field">
                        <div class="label-card">Passport:</div>
                        <div class="value">
                            <?php if($grantee_grant->img_passport) { ?>
                                <a href="<?= $grantee_grant->img_passport ? base_url($grantee_grant->img_passport) : '#' ?>" class="passport-link lightbox"><?= $grantee_grant->img_passport ? 'View Main Passport' : 'No Main Passport Uploaded' ?></a>
                            <?php } else { ?>
                                <span class="text-muted">No main passport uploaded.</span>
                            <?php } ?>
                        </div>
                    </div>

                    <?php if($flight_details->with_dependent) : ?>
                    <div class="field">
                        <div class="label-card">Passport Dependent:</div>
                        <div class="value dependent-list">
                            <?php if (!empty($passport_dependent) && is_array($passport_dependent)) : ?>
                                <?php foreach ($passport_dependent as $index => $dependent) : ?>
                                    <a class="passport-link lightbox" href="<?= $dependent['value'] ? base_url(get_fileurl_sumbission_multiple($dependent)) : '#' ?>" class="passport-link lightbox">View Dependent <?= $index + 1 ?></a>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <span class="text-muted">No dependent passports uploaded.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div>
                    <?php if ($application->approved_at && in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT])): ?>
                        <p><strong>Approved by:</strong><br><?php  $staff = get_staff($application->approved_by, false); echo $staff ? $staff->full_name : ''; ?></p>
                        <p><strong>Approved at:</strong><br><?= date('d F Y H:i', strtotime($application->approved_at)) ?></p>
                    <?php endif; ?>
                    <?php if ($application->rejected_at && in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_DECLINED])): ?>
                        <p><strong>Rejected by:</strong><br><?php  $staff = get_staff($application->rejected_by, false); echo $staff ? $staff->full_name : ''; ?></p>
                        <p><strong>Rejected at:</strong><br><?= date('d F Y H:i', strtotime($application->rejected_at)) ?></p>
                    <?php endif; ?>
                    <?php if ($application->rejected_at && in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_REJECTED_TBA])): ?>
                        <p><strong>Rejected by:</strong><br><?php  $staff = get_staff($application->rejected_by, false); echo $staff ? $staff->full_name : ''; ?></p>
                        <p><strong>Rejected at:</strong><br><?= date('d F Y H:i', strtotime($application->rejected_at)) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card-footer">
                <div class="status-container">
                    Status: <?= format_status_travel_arrangement_non_eta($application->status, $application->type) ?>
                </div>
                <a 
                    href="#" 
                    data-grantname="<?php echo $grantee_grant->grant_name ?>" 
                    data-period="<?php echo $grantee_grant->fiscal_year ?>" 
                    data-name="<?= get_full_name($grantee_grant, 'US') ?>" 
                    data-id="<?= $application->id ?>" 
                    data-category="<?php echo ucfirst(str_replace('_', ' ', $application->type)) ?>"
                    data-ajax_url="<?php echo site_url('admin/notes/get_list_ajax/non_eta_travel/' . $grantee_grant->id . '/'); ?><?= $application->id ?>"  
                    class="open-offcanvas-note btn btn-warning btn-chat">
                        <i class="fa fa-comments"></i> Chat
                        <span class="note-total-<?= $application->id ?> span-note-travel" data-total="<?= $application->total_notes ?>">
                            <span class="badge"><?= $application->total_notes ?></span>
                        </span>
                    </a>
            </div>
        </div>

        <div class="aminef-info hide">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Grantee Name:</strong><br><?= get_full_name($grantee_grant, 'US') ?></p>
                    <p><strong>Application Type:</strong><br>Arranged by AMINEF</p>
                    <p><strong>Status:</strong><br><?= format_status_travel_arrangement_non_eta($application->status, $application->type) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Created At:</strong><br><?= $application->created_at ? date('d F Y H:i', strtotime($application->created_at)) : '-' ?></p>
                    <p><strong>Updated At:</strong><br><?= !empty($application->updated_at) ? date('d F Y H:i', strtotime($application->updated_at)) : '-' ?></p>
                    <?php if ($application->approved_at && in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT])): ?>
                        <p><strong>Approved by:</strong><br><?php  $staff = get_staff($application->approved_by, false); echo $staff ? $staff->full_name : ''; ?></p>
                        <p><strong>Approved at:</strong><br><?= date('d F Y H:i', strtotime($application->approved_at)) ?></p>
                    <?php endif; ?>
                    <?php if ($application->rejected_at && in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_DECLINED])): ?>
                        <p><strong>Rejected by:</strong><br><?php  $staff = get_staff($application->rejected_by, false); echo $staff ? $staff->full_name : ''; ?></p>
                        <p><strong>Rejected at:</strong><br><?= date('d F Y H:i', strtotime($application->rejected_at)) ?></p>
                    <?php endif; ?>
                    <?php if ($application->rejected_at && in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_REJECTED_TBA])): ?>
                        <p><strong>Rejected by:</strong><br><?php  $staff = get_staff($application->rejected_by, false); echo $staff ? $staff->full_name : ''; ?></p>
                        <p><strong>Rejected at:</strong><br><?= date('d F Y H:i', strtotime($application->rejected_at)) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="aminef-info aminef-travel-purpose">
            <strong>Travel Purpose</strong>
            <div style="margin-top:6px; line-height: 1.6;"><?php
                $travel_purpose_text = isset($application->travel_purposes) ? trim((string)$application->travel_purposes) : '';
                if ($travel_purpose_text !== '') {
                    echo html_escape($travel_purpose_text);
                    if (in_array(strtolower($travel_purpose_text), ['other', 'others'], true) && !empty($application->travel_purposes_other)) {
                        echo '<div style="margin-top: 6px; padding: 6px 10px; background: #f8fafc; border-left: 3px solid #0e6ba8; border-radius: 4px; font-weight: normal;"><strong>Specified:</strong> ' . nl2br(html_escape($application->travel_purposes_other)) . '</div>';
                    }
                } else {
                    echo '<em class="text-muted">No travel purpose provided.</em>';
                }
            ?></div>
        </div>

        <?php //if ($is_aminef_staff_permission && $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL): ?>
            <!-- <div class="alert alert-warning" style="margin-bottom:15px; overflow:hidden;">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:15px;flex-wrap:wrap;">
                    <span><strong>Flight Proposal selected by grantee.</strong> Book ticket or find other flight this proposal.</span>
                    <div style="display:flex;gap:8px;flex-shrink:0;">
                        <button type="button" class="btn btn-primary btn-process-book-tba" data-id="<?php //(int)$application->id ?>">
                            <i class="fa fa-shopping-cart"></i> Book Ticket
                        </button>
                        <button type="button" class="btn btn-danger btn-reject-tba" data-id="<?php //(int)$application->id ?>">
                            <i class="fa fa-times"></i> Find other Flight
                        </button>
                    </div>
                </div>
            </div> -->
        <?php //endif; ?>

        <?php if ( 
            (
                ($is_aminef_staff_permission && $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL) || 
                $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT || 
                $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED
            )
            ) : ?>
            <div class="action-banner-approval">
                <?php if($application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL) : ?>
                <div class="banner-top-text">
                    <strong>Flight Proposal selected by grantee.</strong> Please assign Memo Budget and Activity before proceeding.
                </div>
                <?php endif; ?>

                <div class="banner-controls-row">
                    <!-- Input Tambahan: Memo Budget & Activity -->
                    <div class="budget-inputs-group">
                        <div class="input-inline-item">
                            <label for="memoBudgetSelect">Memo Budget *</label>
                            <select id="memoBudgetSelect" class="control-select" <?= $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL ? '' : 'disabled' ?> name="memo_budget" style="max-width:220px;">
                                <option value="">- Select Memo Budget -</option>
                                <?php foreach($memo_budget as $memo) { ?>
                                    <option <?= $memo->is_active == 'Yes' ? '' : 'class="memo-budget-inactive" disabled' ?> <?= $memo->id == (int)$application->memo_budget_id ? 'selected' : '' ?> value="<?php echo $memo->id; ?>" data-is-active="<?= $memo->is_active ?>"><?php echo $memo->file_name; ?><?= $memo->is_active == 'Yes' ? '' : ' (Inactive)' ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="input-inline-item">
                            <label for="activityInput">Activity *</label>
                            <input type="text" id="activityInput" class="control-text" <?= $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL ? '' : 'disabled' ?> name="activity" placeholder="e.g. Orientation / Research" value="<?= $application->activity ?>">
                        </div>
                    </div>

                    <!-- Tombol Aksi Sesuai Gambar -->
                    <div class="banner-btns">
                        <?php if($application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL) : ?>
                        <button type="button" class="btn btn-success btn-approve-tba" data-id="<?= (int)$application->id ?>">
                            <i class="fa fa-check"></i> Proceed to Issue
                        </button>
                        <button type="button" class="btn btn-danger btn-reject-tba" data-id="<?= (int)$application->id ?>">
                            <i class="fa fa-times"></i> Find other Flight
                        </button>
                      <?php else: ?>
                        
                        <button type="button" class="<?= $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL || !$is_aminef_staff_permission ? 'hide' : '' ?> btn btn-info btn-enable-memo">
                            Edit Memo
                        </button>
                        <button type="button" class="<?= $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL ? '' : 'hide' ?> btn btn-primary btn-save-memo" data-id="<?= (int)$application->id ?>">
                            Save Memo
                        </button>
                      <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php //if ($can_manage_tba && $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_PROCEED_TO_BOOKED): ?>
            <!-- <div class="alert alert-warning" style="margin-bottom:15px; overflow:hidden;">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:15px;flex-wrap:wrap;">
                    <span><strong>Flight Proposal selected by grantee.</strong> Booked or find other flight this proposal.</span>
                    <div style="display:flex;gap:8px;flex-shrink:0;">
                        <button type="button" class="btn btn-primary btn-booked-tba" data-id="<?php //(int)$application->id ?>">
                            <i class="fa fa-check"></i> Booked
                        </button>
                        <button type="button" class="btn btn-danger btn-reject-tba" data-id="<?php //(int)$application->id ?>">
                            <i class="fa fa-times"></i> Find other Flight
                        </button>
                    </div>
                </div>
            </div> -->
        <?php //endif; ?>

        <?php if (!empty($flight_details)): ?>
            <?php $is_roundtrip = isset($flight_details->roundtrip) && (int)$flight_details->roundtrip === 1; ?>
            <ul class="nav nav-pills" role="tablist" data-active-tab="<?= $active_tab ?>" style="margin-bottom:12px;">
                <li role="presentation" class="<?= $active_tab === 'flight-details' ? 'active' : '' ?>">
                    <a href="#tab-flight-details" aria-controls="tab-flight-details" role="tab" data-toggle="tab">
                        <i class="fa fa-plane"></i> Flight Details
                    </a>
                </li>
                <li role="presentation" class="<?= $active_tab === 'tba-flight-proposal' ? 'active' : '' ?>">
                    <a href="#tab-tba-flight-proposal" aria-controls="tab-tba-flight-proposal" role="tab" data-toggle="tab">
                        <i class="fa fa-list-alt"></i> Flight Proposal
                    </a>
                </li>
                <?php if ($is_approved): ?>
                <li role="presentation" class="<?= $active_tab === 'ticket' ? 'active' : '' ?>">
                    <a href="#tab-ticket" aria-controls="tab-ticket" role="tab" data-toggle="tab">
                        <i class="fa fa-ticket"></i> Travel Document
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($can_manage_tba && $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_SUBMITTED): ?>
                    <button type="button" class="btn btn-danger pull-right btn-reject-tba" data-id="<?= (int)$application->id ?>">Reject Request</button>
                <?php endif; ?>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade <?= $active_tab === 'flight-details' ? 'active in' : '' ?>" id="tab-flight-details">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="flight-detail-item"><strong>Travelling with your dependents?</strong><?= isset($flight_details->with_dependent) ? ((int)$flight_details->with_dependent === 1 ? 'Yes' : 'No') : '-' ?></div>
                        </div>
                    </div>

                    <?php
                    $has_international_flight = !empty($flight_details->departure_from);
                    if ($has_international_flight):
                    ?>
                        <hr>
                        <h4 style="margin-top:0;"><strong>International Flights</strong></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="flight-detail-item"><strong>Departure From</strong><?= !empty($flight_details->departure_from) ? html_escape($flight_details->departure_from) : '-' ?></div>
                                <div class="flight-detail-item"><strong>Departure Date</strong><?= format_admin_travel_date($flight_details->departure_date ?? null) ?></div>
                                <div class="flight-detail-item"><strong>Arrival</strong><?= !empty($flight_details->arival) ? html_escape($flight_details->arival) : '-' ?></div>
                                <div class="flight-detail-item"><strong>Roundtrip</strong><?= isset($flight_details->roundtrip) ? ((int)$flight_details->roundtrip === 1 ? 'Yes' : 'No') : '-' ?></div>
                            </div>
                            <?php if ($is_roundtrip): ?>
                                <div class="col-md-6">
                                    <div class="flight-detail-item"><strong>Return Departure From</strong><?= !empty($flight_details->return_departure_from) ? html_escape($flight_details->return_departure_from) : '-' ?></div>
                                    <div class="flight-detail-item"><strong>Return Departure Date</strong><?= format_admin_travel_date($flight_details->return_departure_date ?? null) ?></div>
                                    <div class="flight-detail-item"><strong>Return Arrival</strong><?= !empty($flight_details->return_arrival) ? html_escape($flight_details->return_arrival) : '-' ?></div>
                                    <div class="flight-detail-item"><strong>Note</strong><?= isset($flight_details->note) && $flight_details->note !== '' ? html_escape($flight_details->note) : '-' ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!$is_roundtrip): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="flight-detail-item"><strong>Note</strong><?= isset($flight_details->note) && $flight_details->note !== '' ? html_escape($flight_details->note) : '-' ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                    <?php
                    $has_other_flight = !empty($flight_details->other_departure_from);
                    if ($has_other_flight):
                    ?>
                        <hr>
                        <h4><strong>Domestic Flights</strong></h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="flight-detail-item"><strong>From</strong><?= !empty($flight_details->other_departure_from) ? html_escape($flight_details->other_departure_from) : '-' ?></div>
                            </div>
                            <div class="col-md-4">
                                <div class="flight-detail-item"><strong>Departure Date</strong><?= format_admin_travel_date($flight_details->other_departure_date ?? null) ?></div>
                            </div>
                            <div class="col-md-4">
                                <div class="flight-detail-item"><strong>To</strong><?= !empty($flight_details->other_arrival) ? html_escape($flight_details->other_arrival) : '-' ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $has_car_rental = !empty($flight_details->pickup_point);
                    if ($has_car_rental):
                    ?>
                        <hr>
                        <h4><strong>Car Rental</strong></h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="flight-detail-item"><strong>Pickup Point</strong><?= !empty($flight_details->pickup_point) ? html_escape($flight_details->pickup_point) : '-' ?></div>
                            </div>
                            <div class="col-md-4">
                                <div class="flight-detail-item"><strong>Departure Date</strong><?= format_admin_travel_date($flight_details->car_departure_date ?? null) ?></div>
                            </div>
                            <div class="col-md-4">
                                <div class="flight-detail-item"><strong>Drop off Point</strong><?= !empty($flight_details->drop_off_point) ? html_escape($flight_details->drop_off_point) : '-' ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $has_accommodation = !empty($flight_details->location);
                    if ($has_accommodation):
                    ?>
                        <hr>
                        <h4><strong>Accommodation</strong></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="flight-detail-item"><strong>Location</strong><?= !empty($flight_details->location) ? html_escape($flight_details->location) : '-' ?></div>
                                <div class="flight-detail-item"><strong>Check-in Date</strong><?= format_admin_travel_date($flight_details->checkin_date ?? null) ?></div>
                                <div class="flight-detail-item"><strong>Check-out Date</strong><?= format_admin_travel_date($flight_details->checkout_date ?? null) ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="flight-detail-item"><strong>Room</strong><?= !empty($flight_details->room) ? html_escape($flight_details->room) : '-' ?></div>
                                <div class="flight-detail-item"><strong>Note</strong><?= !empty($flight_details->note_accommodation) ? html_escape($flight_details->note_accommodation) : '-' ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div role="tabpanel" class="tab-pane fade <?= $active_tab === 'tba-flight-proposal' ? 'active in' : '' ?>" id="tab-tba-flight-proposal">
                    <?php if ($this->session->flashdata('tba_flight_proposal_success')): ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> <?= html_escape($this->session->flashdata('tba_flight_proposal_success')) ?>
                        </div>
                    <?php endif; ?>
                    <?php $this->session->unset_userdata('tba_flight_proposal_success');?>

                    <?php if ($this->session->flashdata('tba_flight_proposal_error')): ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-times-circle"></i> <?= html_escape($this->session->flashdata('tba_flight_proposal_error')) ?>
                        </div>
                    <?php endif; ?>
                    <?php $this->session->unset_userdata('tba_flight_proposal_error');?>

                    <?php if (!$has_tba_selection): ?>
                        <div class="alert alert-info" style="margin-bottom:12px;">
                            <i class="fa fa-info-circle"></i> Flight proposals on this tab are provided by the Travel Booking Assistant (TBA).
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success" style="margin-bottom:12px;">
                            <i class="fa fa-check-circle"></i> The grantee has already selected a flight proposal; add, edit, delete, and notification actions are disabled.
                        </div>
                    <?php endif; ?>

                    <?php if ($tba_proposal_count > 0 && !$has_tba_selection): ?>
                        <?php $has_grantee_notification = !empty($application->flight_proposal_grantee_notified_at); ?>
                        <div class="alert <?= $has_grantee_notification ? 'alert-info' : 'alert-warning' ?>" style="margin-bottom:20px;overflow:hidden;">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:15px;">
                                <div>
                                    <strong>Notify Grantee</strong><br>
                                    <span>
                                        <?php if ($has_grantee_notification): ?>
                                            Last notified to grantee on <?= html_escape(format_admin_travel_datetime($application->flight_proposal_grantee_notified_at)) ?>.
                                        <?php else: ?>
                                            Grantee has not been notified yet.
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <?php if ($can_manage_tba && !$has_tba_selection): ?>
                                    <a
                                        href="<?= site_url('admin/travel_arrangement_non_eta/notify_flight_proposal_to_grantee/' . $application->id) ?>"
                                        class="btn btn-success pull-right"
                                        style="align-self:center;"
                                        onclick="return confirm('Notify this grantee about the available flight proposal(s)?');"
                                    >
                                        <i class="fa fa-paper-plane"></i> Notify Grantee
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($tba_proposal_count == 0 && $tba_car_rental_count > 0 && !$has_tba_selection && $can_manage_tba): ?>
                        <div class="alert <?= $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL ? 'alert-info' : 'alert-warning' ?>" style="margin-bottom:20px;overflow:hidden;">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:15px;">
                                <div>
                                    <strong>Notify Admin</strong><br>
                                    <span>
                                        <?php if ($application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL): ?>
                                            Admin has been notified.
                                        <?php else: ?>
                                            Admin has not been notified yet.
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <?php if ($can_manage_tba): ?>
                                    <a
                                        href="<?= site_url('admin/travel_arrangement_non_eta/notify_car_rental_to_admin/' . $application->id) ?>"
                                        class="btn btn-success pull-right"
                                        style="align-self:center;"
                                        onclick="return confirm('Notify this admin about the available car rental proposal(s) & update status to Travel Approval?');"
                                    >
                                        <i class="fa fa-paper-plane"></i> Notify Admin
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($tba_proposal_count == 0 && $tba_accommodation_count > 0 && !$has_tba_selection && $can_manage_tba): ?>
                        <div class="alert <?= $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL ? 'alert-info' : 'alert-warning' ?>" style="margin-bottom:20px;overflow:hidden;">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:15px;">
                                <div>
                                    <strong>Notify Admin</strong><br>
                                    <span>
                                        <?php if ($application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL): ?>
                                            Admin has been notified.
                                        <?php else: ?>
                                            Admin has not been notified yet.
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <?php if ($can_manage_tba): ?>
                                    <a
                                        href="<?= site_url('admin/travel_arrangement_non_eta/notify_accommodation_to_admin/' . $application->id) ?>"
                                        class="btn btn-success pull-right"
                                        style="align-self:center;"
                                        onclick="return confirm('Notify this admin about the available accommodation proposal(s) & update status to Travel Approval?');"
                                    >
                                        <i class="fa fa-paper-plane"></i> Notify Admin
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($has_international_flight) : ?>
                        <div class="tba-section">
                            <div class="tba-section-header">
                                <h4 style="margin:0;"><strong>International Flight</strong></h4>
                                    <?php if ($can_manage_tba && !$has_tba_selection): ?>
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm btn-open-tba-modal"
                                        data-mode="create"
                                        data-ref-type="tba_international_flight_proposal"
                                        data-ref-type-label="International Flight"
                                    >
                                        <i class="fa fa-plus"></i> Add International Flight Proposal
                                    </button>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($tba_international_proposals)): ?>
                                <div class="tba-proposals-list">
                                    <?php foreach ($tba_international_proposals as $index => $proposal): ?>
                                        <?php $is_selected = ((int)$proposal->is_selected === 1); ?>
                                        <div class="tba-proposal-card <?= $is_selected ? 'is-selected' : '' ?>">
                                            <div class="tba-proposal-header">
                                                <div class="tba-proposal-meta">
                                                    <strong>Option <?= $index + 1 ?></strong>
                                                    <?php if ($is_selected): ?>
                                                        <span class="tba-proposal-selected-note"><i class="fa fa-check-circle"></i> Selected</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="tba-proposal-actions">
                                                    <?php if ($can_manage_tba && !$has_tba_selection): ?>
                                                        <button
                                                            type="button"
                                                            class="btn btn-primary btn-xs btn-open-tba-modal"
                                                            data-mode="edit"
                                                            data-id="<?= (int)$proposal->id ?>"
                                                            data-description="<?= htmlspecialchars($proposal->description, ENT_QUOTES, 'UTF-8') ?>"
                                                            data-price="<?= html_escape((string)$proposal->price) ?>"
                                                            data-currency="<?= html_escape($proposal->currency) ?>"
                                                            data-time-limit="<?= !empty($proposal->time_limit) ? date('Y-m-d\TH:i', strtotime($proposal->time_limit)) : '' ?>"
                                                            data-ref-type="<?= html_escape($proposal->ref_type) ?>"
                                                            data-ref-type-label="International Flight"
                                                        >
                                                            <i class="fa fa-pencil"></i> Edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs btn-delete-tba-proposal" data-id="<?= (int)$proposal->id ?>" data-application-id="<?= (int)$application->id ?>">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="tba-proposal-description is-clamped"><?= nl2br(html_escape($proposal->description)) ?></div>
                                            <button type="button" class="tba-proposal-description-toggle">Read more</button>
                                            <div class="tba-proposal-price"><?= html_escape(format_money($proposal->price, $proposal->currency)) ?></div>
                                            <?php if (!empty($proposal->time_limit)): ?>
                                                <div class="tba-proposal-time-limit"><strong>Time Limit:</strong> <?= html_escape(format_admin_travel_datetime($proposal->time_limit ?? null)) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning" style="margin-bottom:0;">
                                    <i class="fa fa-warning"></i> No international flight proposal has been created yet.
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($has_other_flight): ?>
                        <div class="tba-section">
                            <div class="tba-section-header">
                                <h4 style="margin:0;"><strong>Domestic Flight</strong></h4>
                                <?php if ($can_manage_tba && !$has_tba_selection): ?>
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm btn-open-tba-modal"
                                        data-mode="create"
                                        data-ref-type="tba_other_flight_proposal"
                                        data-ref-type-label="Other Flight"
                                    >
                                        <i class="fa fa-plus"></i> Add Other Flight Proposal
                                    </button>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($tba_other_proposals)): ?>
                                <div class="tba-proposals-list">
                                    <?php foreach ($tba_other_proposals as $index => $proposal): ?>
                                        <?php $is_selected = ((int)$proposal->is_selected === 1); ?>
                                        <div class="tba-proposal-card <?= $is_selected ? 'is-selected' : '' ?>">
                                            <div class="tba-proposal-header">
                                                <div class="tba-proposal-meta">
                                                    <strong>Option <?= $index + 1 ?></strong>
                                                    <?php if ($is_selected): ?>
                                                        <span class="tba-proposal-selected-note"><i class="fa fa-check-circle"></i> Selected</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="tba-proposal-actions">
                                                    <?php if ($can_manage_tba && !$has_tba_selection): ?>
                                                        <button
                                                            type="button"
                                                            class="btn btn-primary btn-xs btn-open-tba-modal"
                                                            data-mode="edit"
                                                            data-id="<?= (int)$proposal->id ?>"
                                                        data-description="<?= htmlspecialchars($proposal->description, ENT_QUOTES, 'UTF-8') ?>"
                                                        data-price="<?= html_escape((string)$proposal->price) ?>"
                                                        data-currency="<?= html_escape($proposal->currency) ?>"
                                                        data-time-limit="<?= !empty($proposal->time_limit) ? date('Y-m-d\TH:i', strtotime($proposal->time_limit)) : '' ?>"
                                                        data-ref-type="<?= html_escape($proposal->ref_type) ?>"
                                                        data-ref-type-label="Other Flight"
                                                    >
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-xs btn-delete-tba-proposal" data-id="<?= (int)$proposal->id ?>" data-application-id="<?= (int)$application->id ?>">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="tba-proposal-description is-clamped"><?= nl2br(html_escape($proposal->description)) ?></div>
                                            <button type="button" class="tba-proposal-description-toggle">Read more</button>
                                            <div class="tba-proposal-price"><?= html_escape(format_money($proposal->price, $proposal->currency)) ?></div>
                                            <?php if (!empty($proposal->time_limit)): ?>
                                                <div class="tba-proposal-time-limit"><strong>Time Limit:</strong> <?= html_escape(format_admin_travel_datetime($proposal->time_limit ?? null)) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning" style="margin-bottom:0;">
                                    <i class="fa fa-warning"></i> No other-flight TBA proposal has been created yet.
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($has_car_rental): ?>
                        <div class="tba-section" style="margin-bottom:0;" id="form-tba-flight-selection">
                            <div class="tba-section-header">
                                <h4 style="margin:0;"><strong>Car Rental</strong></h4>
                                <?php if ($can_manage_tba && !$has_tba_selection): ?>
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm btn-open-tba-modal"
                                        data-mode="create"
                                        data-ref-type="tba_car_rental_proposal"
                                        data-ref-type-label="Car Rental"
                                    >
                                        <i class="fa fa-plus"></i> Add Car Rental Proposal
                                    </button>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($tba_car_rental_proposals)): ?>

                                <?php if($is_aminef_staff_permission) : ?>
                                    <?php if(!$has_submitted_tba_selection_car) : ?>
                                    <div class="alert alert-info" style="margin-bottom:12px;">
                                        <i class="fa fa-info-circle"></i> Please select one of the car rental options below for the grantee.
                                    </div>
                                    <?php endif; ?>
                                    <div class="flight-section" style="margin-bottom:20px;">
                                        <div class="tba-proposals-list">
                                            <?php foreach ($tba_car_rental_proposals as $index => $proposal): ?>
                                                <?php $is_other_checked = (int)$proposal->is_selected === 1; ?>
                                                <div class="tba-proposal-card <?= $is_other_checked ? 'is-selected' : '' ?> <?= $has_submitted_tba_selection_car ? 'is-locked' : '' ?>">
                                                    <label class="tba-proposal-option">
                                                        <input
                                                            type="radio"
                                                            name="tba_other_selection"
                                                            value="<?= (int)$proposal->id ?>"
                                                            <?= $is_other_checked ? 'checked' : '' ?>
                                                            <?= $has_submitted_tba_selection_car ? 'disabled' : '' ?>
                                                        >
                                                        <span>
                                                            <div class="tba-proposal-header">
                                                                <strong>Option <?= $index + 1 ?></strong>
                                                                <?php if ($is_other_checked): ?>
                                                                    <span class="tba-proposal-selected-note">
                                                                        <i class="fa fa-check-circle"></i> Selected
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="tba-proposal-description is-clamped"><?= nl2br(html_escape($proposal->description)) ?></div>
                                                            <button type="button" class="tba-proposal-description-toggle">Read more</button>
                                                            <div class="tba-proposal-price"><?= html_escape(format_money($proposal->price, $proposal->currency)) ?></div>
                                                            <?php if (!empty($proposal->time_limit)): ?>
                                                                <div class="tba-proposal-time-limit"><strong>Time Limit:</strong> <?= html_escape(format_grantee_tba_time_limit($proposal->time_limit)) ?></div>
                                                            <?php endif; ?>
                                                        </span>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="tba-proposals-list">
                                        <?php foreach ($tba_car_rental_proposals as $index => $proposal): ?>
                                            <?php $is_selected = ((int)$proposal->is_selected === 1); ?>
                                            <div class="tba-proposal-card <?= $is_selected ? 'is-selected' : '' ?>">
                                                <div class="tba-proposal-header">
                                                    <div class="tba-proposal-meta">
                                                        <strong>Option <?= $index + 1 ?></strong>
                                                        <?php if ($is_selected): ?>
                                                            <span class="tba-proposal-selected-note"><i class="fa fa-check-circle"></i> Selected</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="tba-proposal-actions">
                                                        <?php if ($can_manage_tba && !$has_tba_selection): ?>
                                                            <button
                                                                type="button"
                                                                class="btn btn-primary btn-xs btn-open-tba-modal"
                                                                data-mode="edit"
                                                                data-id="<?= (int)$proposal->id ?>"
                                                            data-description="<?= htmlspecialchars($proposal->description, ENT_QUOTES, 'UTF-8') ?>"
                                                            data-price="<?= html_escape((string)$proposal->price) ?>"
                                                            data-currency="<?= html_escape($proposal->currency) ?>"
                                                            data-time-limit="<?= !empty($proposal->time_limit) ? date('Y-m-d\TH:i', strtotime($proposal->time_limit)) : '' ?>"
                                                            data-ref-type="<?= html_escape($proposal->ref_type) ?>"
                                                            data-ref-type-label="Car Rental"
                                                        >
                                                            <i class="fa fa-pencil"></i> Edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs btn-delete-tba-proposal" data-id="<?= (int)$proposal->id ?>" data-application-id="<?= (int)$application->id ?>">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="tba-proposal-description is-clamped"><?= nl2br(html_escape($proposal->description)) ?></div>
                                                <button type="button" class="tba-proposal-description-toggle">Read more</button>
                                                <div class="tba-proposal-price"><?= html_escape(format_money($proposal->price, $proposal->currency)) ?></div>
                                                <?php if (!empty($proposal->time_limit)): ?>
                                                    <div class="tba-proposal-time-limit"><strong>Time Limit:</strong> <?= html_escape(format_admin_travel_datetime($proposal->time_limit ?? null)) ?></div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="alert alert-warning" style="margin-bottom:0;">
                                    <i class="fa fa-warning"></i> No car rental TBA proposal has been created yet.
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($has_accommodation): ?>
                        <div class="tba-section" style="margin-bottom:0;" id="form-tba-accommodation-selection">
                            <div class="tba-section-header">
                                <h4 style="margin:0;"><strong>Accommodation</strong></h4>
                                <?php if ($can_manage_tba && !$has_tba_selection): ?>
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm btn-open-tba-modal"
                                        data-mode="create"
                                        data-ref-type="tba_accommodation_proposal"
                                        data-ref-type-label="Accommodation"
                                    >
                                        <i class="fa fa-plus"></i> Add Accommodation Proposal
                                    </button>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($tba_accommodation_proposals)): ?>

                                <?php if($is_aminef_staff_permission) : ?>
                                    <?php if(!$has_submitted_tba_selection_accommodation) : ?>
                                    <div class="alert alert-info" style="margin-bottom:12px;">
                                        <i class="fa fa-info-circle"></i> Please select one of the accommodation options below for the grantee.
                                    </div>
                                    <?php endif; ?>
                                    <div class="flight-section" style="margin-bottom:20px;">
                                        <div class="tba-proposals-list">
                                            <?php foreach ($tba_accommodation_proposals as $index => $proposal): ?>
                                                <?php $is_other_checked = (int)$proposal->is_selected === 1; ?>
                                                <div class="tba-proposal-card <?= $is_other_checked ? 'is-selected' : '' ?> <?= $has_submitted_tba_selection_accommodation ? 'is-locked' : '' ?>">
                                                    <label class="tba-proposal-option">
                                                        <input
                                                            type="radio"
                                                            name="tba_other_selection"
                                                            value="<?= (int)$proposal->id ?>"
                                                            <?= $is_other_checked ? 'checked' : '' ?>
                                                            <?= $has_submitted_tba_selection_accommodation ? 'disabled' : '' ?>
                                                        >
                                                        <span>
                                                            <div class="tba-proposal-header">
                                                                <strong>Option <?= $index + 1 ?></strong>
                                                                <?php if ($is_other_checked): ?>
                                                                    <span class="tba-proposal-selected-note">
                                                                        <i class="fa fa-check-circle"></i> Selected
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="tba-proposal-description is-clamped"><?= nl2br(html_escape($proposal->description)) ?></div>
                                                            <button type="button" class="tba-proposal-description-toggle">Read more</button>
                                                            <div class="tba-proposal-price"><?= html_escape(format_money($proposal->price, $proposal->currency)) ?></div>
                                                            <?php if (!empty($proposal->time_limit)): ?>
                                                                <div class="tba-proposal-time-limit"><strong>Time Limit:</strong> <?= html_escape(format_admin_travel_datetime($proposal->time_limit)) ?></div>
                                                            <?php endif; ?>
                                                        </span>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="tba-proposals-list">
                                        <?php foreach ($tba_accommodation_proposals as $index => $proposal): ?>
                                            <?php $is_selected = ((int)$proposal->is_selected === 1); ?>
                                            <div class="tba-proposal-card <?= $is_selected ? 'is-selected' : '' ?>">
                                                <div class="tba-proposal-header">
                                                    <div class="tba-proposal-meta">
                                                        <strong>Option <?= $index + 1 ?></strong>
                                                        <?php if ($is_selected): ?>
                                                            <span class="tba-proposal-selected-note"><i class="fa fa-check-circle"></i> Selected</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="tba-proposal-actions">
                                                        <?php if ($can_manage_tba && !$has_tba_selection): ?>
                                                            <button
                                                                type="button"
                                                                class="btn btn-primary btn-xs btn-open-tba-modal"
                                                                data-mode="edit"
                                                                data-id="<?= (int)$proposal->id ?>"
                                                            data-description="<?= htmlspecialchars($proposal->description, ENT_QUOTES, 'UTF-8') ?>"
                                                            data-price="<?= html_escape((string)$proposal->price) ?>"
                                                            data-currency="<?= html_escape($proposal->currency) ?>"
                                                            data-time-limit="<?= !empty($proposal->time_limit) ? date('Y-m-d\TH:i', strtotime($proposal->time_limit)) : '' ?>"
                                                            data-ref-type="<?= html_escape($proposal->ref_type) ?>"
                                                            data-ref-type-label="Car Rental"
                                                        >
                                                            <i class="fa fa-pencil"></i> Edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs btn-delete-tba-proposal" data-id="<?= (int)$proposal->id ?>" data-application-id="<?= (int)$application->id ?>">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="tba-proposal-description is-clamped"><?= nl2br(html_escape($proposal->description)) ?></div>
                                                <button type="button" class="tba-proposal-description-toggle">Read more</button>
                                                <div class="tba-proposal-price"><?= html_escape(format_money($proposal->price, $proposal->currency)) ?></div>
                                                <?php if (!empty($proposal->time_limit)): ?>
                                                    <div class="tba-proposal-time-limit"><strong>Time Limit:</strong> <?= html_escape(format_admin_travel_datetime($proposal->time_limit ?? null)) ?></div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="alert alert-warning" style="margin-bottom:0;">
                                    <i class="fa fa-warning"></i> No accommodation rental TBA proposal has been created yet.
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($is_approved): ?>
                <div role="tabpanel" class="tab-pane fade <?= $active_tab === 'ticket' ? 'active in' : '' ?>" id="tab-ticket">
                    <?php if ($this->session->flashdata('ticket_success')): ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> <?= html_escape($this->session->flashdata('ticket_success')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('ticket_error')): ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-times-circle"></i> <?= html_escape($this->session->flashdata('ticket_error')) ?>
                        </div>
                    <?php endif; ?>
                    <?php $this->session->unset_userdata('ticket_success') ?>
                    <?php $this->session->unset_userdata('ticket_error') ?>

                    <?php if ($can_manage_tba): ?>
                        <div class="pull-right">
                            <button type="button" class="btn-notify btn-notify-ticket"
                                data-url="<?= site_url('admin/travel_arrangement_non_eta/notify_ticket_to_grantee/' . $application->id) ?>">
                            <i class="fa fa-paper-plane"></i> Notify Grantee
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if ($tba_proposal_count > 0): ?>
                        <?php if($has_international_flight) : ?>
                            <div class="ticket-international mb-3">
                                <div class="section-header-row">
                                    <h2 class="section-title">International Flight</h2>
                                </div>
                                
                                <table class="ticket-table table-international">
                                    <thead>
                                        <tr>
                                            <th style="width: 44px; text-align: center;">#</th>
                                            <th>File</th>
                                            <th style="width: 250px;">Final Price</th>
                                            <th style="width: 250px;">Note</th>
                                            <th style="width: 180px;">Uploaded At</th>
                                            <?php if ($can_manage_tba): ?>
                                            <th style="width: 170px; text-align: center;">Action</th>
                                            <?php endif; ?>
                                        </tr>
                                        </thead>
                                    <tbody id="ticketTbody-international" data-application-id="<?= $application->id ?>">
                                        <?php if(!empty($ticket_international)) : ?>
                                            <?php $i = 1; ?>
                                            <?php foreach($ticket_international as $key => $ticket) : ?>
                                            <tr class="tr-international" data-id="<?= $ticket->id ?>" data-application-id="<?= $application->id ?>">
                                                <td style="text-align: center;"><?= $i++ ?></td>
                                                <td class="td-row-file">
                                                    <?php if(!empty($ticket->filepath)) : ?>
                                                    <div class="file-preview-cell">
                                                        <a href="<?= base_url($ticket->filepath) ?>" class="lightbox">
                                                            <i class="fa fa-file"></i> <?= html_escape(basename($ticket->filepath)) ?>
                                                        </a>
                                                        <a href="<?= base_url($ticket->filepath) ?>" download class="btn btn-primary btn-xs"><i class="fa fa-download"></i></a>
                                                    </div>
                                                    <?php else: ?>
                                                        <span style="color: #94a3b8; font-style: italic;" id="fileNameRow<?= $ticket->id ?>">
                                                            No ticket uploaded
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($can_manage_tba && $key == 0) :?>
                                                        <input type="text" class="form-control final_price_ticket final_price_ticket_international" data-currency="<?= html_escape($currency_international) ?>" placeholder="Final Price" value="<?= isset($ticket->final_price) && $ticket->final_price !== '' && $ticket->final_price !== null ? html_escape(format_money($ticket->final_price, $currency_international, false)) : '' ?>">
                                                    <?php else : ?>
                                                        <?= $key == 0 ? (isset($ticket->final_price) && $ticket->final_price !== '' && $ticket->final_price !== null ? html_escape(format_money($ticket->final_price, $currency_international, true)) : '-') : '-' ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($can_manage_tba) :?>
                                                        <textarea name="note" class="form-control ticket_note" rows="3" placeholder="Add a note about these tickets..."><?= !empty($ticket->note) ? html_escape($ticket->note) : '' ?></textarea>
                                                    <?php else : ?>
                                                        <?= !empty($ticket->note) ? html_escape($ticket->note) : '-' ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="td-row-date"><?= !empty($ticket->filepath) ? date('d F Y H:i', strtotime($ticket->created_at)) : '-' ?></td>

                                                <?php if ($can_manage_tba): ?>
                                                <td style="text-align: center;">
                                                    <div class="table-action-group" style="justify-content: center;">
                                                        <input type="file" id="fileRow<?= $ticket->id ?>" style="display: none;" onchange="handleFileRowChange(<?= $ticket->id ?>, this, 'international')">
                                                        <button type="button" class="btn-upload-direct" onclick="document.getElementById('fileRow<?= $ticket->id ?>').click()">
                                                            Upload
                                                        </button>
                                                        <button 
                                                            data-url="<?= site_url('admin/travel_arrangement_non_eta/delete_ticket/' . $ticket->id) ?>"
                                                            type="button" 
                                                            class="btn-delete-row btn-delete-ticket"
                                                        >
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php elseif ($can_manage_tba) : ?>
                                            <tr class="tr-international" data-id="" data-application-id="<?= $application->id ?>">
                                                <td style="text-align: center;">1</td>
                                                <td class="td-row-file">
                                                    <span style="color: #94a3b8; font-style: italic;">
                                                        No ticket uploaded
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control final_price_ticket final_price_ticket_international" data-currency="<?= html_escape($currency_international) ?>" placeholder="Final Price">
                                                </td>
                                                <td>
                                                    <textarea name="note" class="form-control ticket_note" rows="3" placeholder="Add a note about these tickets..."></textarea>
                                                </td>
                                                <td class="td-row-date">-</td>
                                                <td style="text-align: center;">
                                                    <div class="table-action-group" style="justify-content: center;">
                                                        <input type="file" id="fileRowInternational_init" style="display: none;" onchange="handleFileRowChange('', this, 'international')">
                                                        <button type="button" class="btn-upload-direct" onclick="document.getElementById('fileRowInternational_init').click()">
                                                            Upload
                                                        </button>
                                                        <button 
                                                            type="button" 
                                                            class="btn-delete-row"
                                                            onclick="deleteRow(this, 'international')"
                                                        >
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php else : ?>
                                            <tr class="tr-empty-international">
                                                <td class="text-center td-empty" colspan="6">No tickets have been uploaded yet.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
            
                                <?php if ($can_manage_tba): ?>
                                <div class="table-bottom-bar">
                                    <button type="button" class="btn-add-row" onclick="addTicketRow('international')">
                                    + Add Row
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($has_other_flight)) : ?>
                            <div class="ticket-domestic mb-3">
                                <div class="section-header-row">
                                    <h2 class="section-title">Domestic Flight</h2>
                                </div>
                                
                                <table class="ticket-table table-domestic">
                                    <thead>
                                        <tr>
                                            <th style="width: 44px; text-align: center;">#</th>
                                            <th>File</th>
                                            <th style="width: 250px;">Final Price</th>
                                            <th style="width: 250px;">Note</th>
                                            <th style="width: 180px;">Uploaded At</th>
                                            <?php if ($can_manage_tba): ?>
                                            <th style="width: 170px; text-align: center;">Action</th>
                                            <?php endif; ?>
                                        </tr>
                                        </thead>
                                    <tbody id="ticketTbody-domestic" data-application-id="<?= $application->id ?>">
                                        <?php if(!empty($ticket_domestic)) : ?>
                                            <?php $i = 1; ?>
                                            <?php foreach($ticket_domestic as $key => $ticket) : ?>
                                            <tr class="tr-domestic" data-id="<?= $ticket->id ?>" data-application-id="<?= $application->id ?>">
                                                <td style="text-align: center;"><?= $i++ ?></td>
                                                <td class="td-row-file">
                                                    <?php if(!empty($ticket->filepath)) : ?>
                                                    <div class="file-preview-cell">
                                                        <a href="<?= base_url($ticket->filepath) ?>" class="lightbox">
                                                            <i class="fa fa-file"></i> <?= html_escape(basename($ticket->filepath)) ?>
                                                        </a>
                                                        <a href="<?= base_url($ticket->filepath) ?>" download class="btn btn-primary btn-xs" style="color:#fff;"><i class="fa fa-download"></i></a>
                                                    </div>
                                                    <?php else: ?>
                                                        <span style="color: #94a3b8; font-style: italic;" id="fileNameRow<?= $ticket->id ?>">
                                                            No ticket uploaded
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($can_manage_tba && $key == 0) :?>
                                                        <input type="text" class="form-control final_price_ticket final_price_ticket_domestic" data-currency="<?= html_escape($currency_domestic) ?>" placeholder="Final Price" value="<?= isset($ticket->final_price) && $ticket->final_price !== '' && $ticket->final_price !== null ? html_escape(format_money($ticket->final_price, $currency_domestic, false)) : '' ?>">
                                                    <?php else : ?>
                                                        <?= $key == 0 ? (isset($ticket->final_price) && $ticket->final_price !== '' && $ticket->final_price !== null ? html_escape(format_money($ticket->final_price, $currency_domestic, true)) : '-') : '-' ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($can_manage_tba) :?>
                                                        <textarea name="note" class="form-control ticket_note" rows="3" placeholder="Add a note about these tickets..."><?= !empty($ticket->note) ? html_escape($ticket->note) : '' ?></textarea>
                                                    <?php else : ?>
                                                        <?= !empty($ticket->note) ? html_escape($ticket->note) : '-' ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="td-row-date"><?= !empty($ticket->filepath) ? date('d F Y H:i', strtotime($ticket->created_at)) : '-' ?></td>

                                                <?php if ($can_manage_tba): ?>
                                                <td style="text-align: center;">
                                                    <div class="table-action-group" style="justify-content: center;">
                                                        <input type="file" id="fileRow<?= $ticket->id ?>" style="display: none;" onchange="handleFileRowChange(<?= $ticket->id ?>, this, 'domestic')">
                                                        <button type="button" class="btn-upload-direct" onclick="document.getElementById('fileRow<?= $ticket->id ?>').click()">
                                                            Upload
                                                        </button>
                                                        <button 
                                                            data-url="<?= site_url('admin/travel_arrangement_non_eta/delete_ticket/' . $ticket->id) ?>"
                                                            type="button" 
                                                            class="btn-delete-row btn-delete-ticket"
                                                        >
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php elseif ($can_manage_tba) : ?>
                                            <tr class="tr-domestic" data-id="" data-application-id="<?= $application->id ?>">
                                                <td style="text-align: center;">1</td>
                                                <td class="td-row-file">
                                                    <span style="color: #94a3b8; font-style: italic;">
                                                        No ticket uploaded
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control final_price_ticket final_price_ticket_domestic" data-currency="<?= html_escape($currency_domestic) ?>" placeholder="Final Price">
                                                </td>
                                                <td>
                                                    <textarea name="note" class="form-control ticket_note" rows="3" placeholder="Add a note about these tickets..."></textarea>
                                                </td>
                                                <td class="td-row-date">-</td>
                                                <td style="text-align: center;">
                                                    <div class="table-action-group" style="justify-content: center;">
                                                        <input type="file" id="fileRowDomestic_init" style="display: none;" onchange="handleFileRowChange('', this, 'domestic')">
                                                        <button type="button" class="btn-upload-direct" onclick="document.getElementById('fileRowDomestic_init').click()">
                                                            Upload
                                                        </button>
                                                        <button 
                                                            type="button" 
                                                            class="btn-delete-row"
                                                            onclick="deleteRow(this, 'domestic')"
                                                        >
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php else : ?>
                                            <tr class="tr-empty-domestic">
                                                <td class="text-center td-empty" colspan="6">No tickets have been uploaded yet.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
            
                                <?php if ($can_manage_tba): ?>
                                <div class="table-bottom-bar">
                                    <button type="button" class="btn-add-row" onclick="addTicketRow('domestic')">
                                    + Add Row
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>


                        <div style="display:none;align-items:center;justify-content:space-between;margin-bottom:15px;">
                            <h4 style="margin:0;"><strong>Uploaded Tickets</strong></h4>
                            <?php if ($can_manage_tba): ?>
                            <button type="button" class="btn btn-primary btn-open-ticket-upload">
                                <i class="fa fa-upload"></i> Upload Tickets
                            </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($tickets)): ?>
                        <div class="table-responsive hide" style="margin-bottom:20px;">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>File</th>
                                        <th>Note</th>
                                        <th>Uploaded At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($tickets as $ticket): ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td>
                                                <a href="<?= base_url($ticket->filepath) ?>" class="lightbox">
                                                    <i class="fa fa-file"></i> <?= html_escape(basename($ticket->filepath)) ?>
                                                </a>
                                            </td>
                                            <td><?= !empty($ticket->note) ? html_escape($ticket->note) : '-' ?></td>
                                            <td><?= date('d F Y H:i', strtotime($ticket->created_at)) ?></td>
                                            <td>
                                                <?php if ($can_manage_tba): ?>
                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-xs btn-delete-ticket"
                                                    data-url="<?= site_url('admin/travel_arrangement_non_eta/delete_ticket/' . $ticket->id) ?>"
                                                >
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($can_manage_tba): ?>
                        <button
                            type="button"
                            class="btn btn-success btn-notify-ticket hide"
                            data-url="<?= site_url('admin/travel_arrangement_non_eta/notify_ticket_to_grantee/' . $application->id) ?>"
                        >
                            <i class="fa fa-paper-plane"></i> Notify Grantee
                        </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if($tba_proposal_count > 0) { ?>
                        <div class="alert alert-info hide">
                            <i class="fa fa-info-circle"></i> No tickets have been uploaded yet.
                        </div>
                        <?php } ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($tba_car_rental_proposals)): ?>

                        <div>
                            <h2 class="section-title">Car Rental</h2>
                            <div class="car-rental-direct-text">Car Details :</div>

                            <?php foreach ($tba_car_rental_proposals as $index => $proposal): if($proposal->is_selected != 1) {continue;} ?>
                                <?php $is_other_checked = (int)$proposal->is_selected === 1; ?>
                                <div class="car-rental-direct-text"><?= nl2br(html_escape($proposal->description)) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($tba_accommodation_proposals)): ?>
                        <div class="ticket-accommodation mb-3">
                            <div class="section-header-row">
                                <h2 class="section-title">Accommodation</h2>
                            </div>
                            
                            <table class="ticket-table table-accommodation">
                                <thead>
                                    <tr>
                                        <th style="width: 44px; text-align: center;">#</th>
                                        <th>File</th>
                                        <th style="width: 250px;">Final Price</th>
                                        <th style="width: 250px;">Note</th>
                                        <th style="width: 180px;">Uploaded At</th>
                                        <?php if ($can_manage_tba): ?>
                                        <th style="width: 170px; text-align: center;">Action</th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                <tbody id="ticketTbody-accommodation" data-application-id="<?= $application->id ?>">
                                    <?php if(!empty($ticket_accommodation)) : ?>
                                        <?php $i = 1; ?>
                                        <?php foreach($ticket_accommodation as $key => $ticket) : ?>
                                        <tr class="tr-accommodation" data-id="<?= $ticket->id ?>" data-application-id="<?= $application->id ?>">
                                            <td style="text-align: center;"><?= $i++ ?></td>
                                            <td class="td-row-file">
                                                <?php if(!empty($ticket->filepath)) : ?>
                                                <div class="file-preview-cell">
                                                    <a href="<?= base_url($ticket->filepath) ?>" class="lightbox">
                                                        <i class="fa fa-file"></i> <?= html_escape(basename($ticket->filepath)) ?>
                                                    </a>
                                                    <a href="<?= base_url($ticket->filepath) ?>" download class="btn btn-primary btn-xs" style="color:#fff;"><i class="fa fa-download"></i></a>
                                                </div>
                                                <?php else: ?>
                                                    <span style="color: #94a3b8; font-style: italic;" id="fileNameRow<?= $ticket->id ?>">
                                                        No voucher uploaded
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($can_manage_tba && $key == 0) :?>
                                                    <input type="text" class="form-control final_price_ticket final_price_ticket_accommodation" data-currency="<?= html_escape($currency_accommodation) ?>" placeholder="Final Price" value="<?= isset($ticket->final_price) && $ticket->final_price !== '' && $ticket->final_price !== null ? html_escape(format_money($ticket->final_price, $currency_accommodation, false)) : '' ?>">
                                                <?php else : ?>
                                                    <?= $key == 0 ? (isset($ticket->final_price) && $ticket->final_price !== '' && $ticket->final_price !== null ? html_escape(format_money($ticket->final_price, $currency_accommodation, true)) : '-') : '-' ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($can_manage_tba) :?>
                                                    <textarea name="note" class="form-control ticket_note" rows="3" placeholder="Add a note about these tickets..."><?= !empty($ticket->note) ? html_escape($ticket->note) : '' ?></textarea>
                                                <?php else : ?>
                                                    <?= !empty($ticket->note) ? html_escape($ticket->note) : '-' ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="td-row-date"><?= !empty($ticket->filepath) ? date('d F Y H:i', strtotime($ticket->created_at)) : '-' ?></td>

                                            <?php if ($can_manage_tba): ?>
                                            <td style="text-align: center;">
                                                <div class="table-action-group" style="justify-content: center;">
                                                    <input type="file" id="fileRow<?= $ticket->id ?>" style="display: none;" onchange="handleFileRowChange(<?= $ticket->id ?>, this, 'accommodation')">
                                                    <button type="button" class="btn-upload-direct" onclick="document.getElementById('fileRow<?= $ticket->id ?>').click()">
                                                        Upload
                                                    </button>
                                                    <button 
                                                        data-url="<?= site_url('admin/travel_arrangement_non_eta/delete_ticket/' . $ticket->id) ?>"
                                                        type="button" 
                                                        class="btn-delete-row btn-delete-ticket"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php elseif ($can_manage_tba) : ?>
                                        <tr class="tr-accommodation" data-id="" data-application-id="<?= $application->id ?>">
                                            <td style="text-align: center;">1</td>
                                            <td class="td-row-file">
                                                <span style="color: #94a3b8; font-style: italic;">
                                                    No ticket uploaded
                                                </span>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control final_price_ticket final_price_ticket_accommodation" data-currency="<?= html_escape($currency_accommodation) ?>" placeholder="Final Price">
                                            </td>
                                            <td>
                                                <textarea name="note" class="form-control ticket_note" rows="3" placeholder="Add a note about these tickets..."></textarea>
                                            </td>
                                            <td class="td-row-date">-</td>
                                            <td style="text-align: center;">
                                                <div class="table-action-group" style="justify-content: center;">
                                                    <input type="file" id="fileRowaccommodation_init" style="display: none;" onchange="handleFileRowChange('', this, 'accommodation')">
                                                    <button type="button" class="btn-upload-direct" onclick="document.getElementById('fileRowaccommodation_init').click()">
                                                        Upload
                                                    </button>
                                                    <button 
                                                        type="button" 
                                                        class="btn-delete-row"
                                                        onclick="deleteRow(this, 'accommodation')"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else : ?>
                                        <tr class="tr-empty-accommodation">
                                            <td class="text-center td-empty" colspan="6">No tickets have been uploaded yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
        
                            <?php if ($can_manage_tba): ?>
                            <div class="table-bottom-bar">
                                <button type="button" class="btn-add-row" onclick="addTicketRow('accommodation')">
                                + Add Row
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" style="margin-bottom:0;">
                <i class="fa fa-warning"></i> Flight details record is not available.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($can_manage_tba || $is_aminef_staff_permission): ?>
    <div class="modal fade" id="mdl_tba_flight_proposal" tabindex="-1" role="dialog" aria-labelledby="mdlTbaFlightProposalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="<?= site_url('admin/travel_arrangement_non_eta/save_tba_flight_proposal/' . $application->id) ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="mdlTbaFlightProposalLabel">Create Flight Proposal</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="proposal_id" id="tba_proposal_id" value="0">
                        <input type="hidden" name="ref_type" id="tba_ref_type" value="tba_international_flight_proposal">

                        <input type="hidden" name="title" value="">

                        <div class="form-group">
                            <label id="label-tba-description" for="tba_description">Itinerary</label>
                            <textarea name="description" id="tba_description" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="row upload-group">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tba_price">Price</label>
                                    <input type="text" name="price" id="tba_price" class="form-control tba_price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tba_currency">Currency</label>
                                    <select name="currency" id="tba_currency" class="form-control tba_currency" required>
                                        <option value="USD">USD</option>
                                        <option value="IDR">IDR</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group section-time-limit">
                            <label for="tba_time_limit">Time Limit</label>
                            <input type="text" name="time_limit" id="tba_time_limit" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var $ = window.jQuery;

            if (!$) {
                return;
            }

            $(document).ready(function () {
                // Reveal the currently selected inactive memo option so it is visible
                var $memoBudgetSel = $('#memoBudgetSelect');
                $memoBudgetSel.find('option.memo-budget-inactive').prop('hidden', true).hide();
                var selectedMemoBudget = $memoBudgetSel.val();
                if (selectedMemoBudget) {
                    $memoBudgetSel.find('option[value="' + selectedMemoBudget + '"]').prop('hidden', false).prop('disabled', false).show();
                }

                const openChat = new URLSearchParams(window.location.search).get('open_chat');
    
                if (openChat) {
                    const $chatButton = $('.btn-chat');
    
                    if ($chatButton.length) {
                        $chatButton.trigger('click');
                    }
                }
            });

            // initialize flatpickr on the time limit input with 24-hour format
            if (typeof flatpickr !== 'undefined') {
                try {
                    window.tbaTimePicker = flatpickr('#tba_time_limit', {
                        enableTime: true,
                        time_24hr: true,
                        dateFormat: 'Y-m-d H:i',
                        allowInput: true
                    });
                } catch (e) {
                    // ignore initialization errors
                }
            }

            $('.btn-open-tba-modal').on('click', function () {
                var button = $(this);
                var mode = button.data('mode');
                var proposalId = button.data('id') || 0;
                var refType = button.data('ref-type') || 'tba_international_flight_proposal';
                var refTypeLabel = button.data('ref-type-label') || 'International Flight';

                $('#tba_proposal_id').val(proposalId);
                $('#tba_ref_type').val(refType);
                $('#tba_description').val(button.data('description') || '');
                $('#tba_price').val(button.data('price') || '');
                $('#tba_currency').val(button.data('currency') || 'USD');
                var timeLimit = button.data('time-limit') || '';
                if (window.tbaTimePicker) {
                    if (timeLimit) {
                        try { window.tbaTimePicker.setDate(timeLimit); } catch (e) { window.tbaTimePicker.clear(); }
                    } else {
                        window.tbaTimePicker.clear();
                    }
                } else {
                    $('#tba_time_limit').val(timeLimit);
                }
                $('#mdlTbaFlightProposalLabel').text((mode === 'edit' ? 'Edit ' : 'Create ') + refTypeLabel + ' Proposal');

                if(refType === 'tba_car_rental_proposal') {
                    $('#label-tba-description').text('Car Rental Details');
                    $('.section-time-limit').addClass('hide');
                } else {
                    $('#label-tba-description').text('Itinerary');
                    $('.section-time-limit').removeClass('hide');
                }

                $('#mdl_tba_flight_proposal').modal('show');
            });

            $('#mdl_tba_flight_proposal').on('hidden.bs.modal', function () {
                $('#tba_proposal_id').val(0);
                $('#tba_ref_type').val('tba_international_flight_proposal');
                $('#tba_description').val('');
                $('#tba_price').val('');
                $('#tba_currency').val('USD');
                if (window.tbaTimePicker) {
                    window.tbaTimePicker.clear();
                } else {
                    $('#tba_time_limit').val('');
                }
                $('#mdlTbaFlightProposalLabel').text('Create Flight Proposal');
            });

            $(document).on('click', '.btn-delete-tba-proposal', function (e) {
                e.preventDefault();
                var $btn = $(this);
                var proposalId = $btn.data('id');
                var applicationId = $btn.data('application-id');

                if (!proposalId || !applicationId) {
                    alert('Invalid proposal');
                    return;
                }

                if (!confirm('Are you sure you want to delete this proposal? This action cannot be undone.')) {
                    return;
                }

                var url = '<?= site_url('admin/travel_arrangement_non_eta/delete_tba_flight_proposal') ?>/' + applicationId + '/' + proposalId;

                $.post(url, function () {
                    // reload to reflect changes
                    location.reload();
                }).fail(function () {
                    alert('Failed to delete the proposal.');
                });
            });

            $(document).on('click', '.btn-booked-tba', function () {
                var id = $(this).data('id');

                Swal.fire({
                    icon: 'question',
                    title: 'Confirm Booked',
                    text: 'Are you sure you want to mark this flight proposal as booked?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Mark as Booked',
                    cancelButtonText: 'Cancel',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        updateTbaStatus(id, 'booked');
                    }
                });
            });

            $(document).on('click', '.btn-approve-tba', function () {
                const $carProposal = $('#form-tba-flight-selection');
                const $memoBudget = $('#memoBudgetSelect');
                const $activity = $('#activityInput');
                if (
                    !$memoBudget.val() ||
                    !$memoBudget.val().trim() ||
                    !$activity.val() ||
                    !$activity.val().trim()
                ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please complete all required fields before approving.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if ($carProposal.length) {
                    const $selectedProposal = $('#form-tba-flight-selection input[name="tba_other_selection"]:checked');
                    if ($selectedProposal.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Select at least one car rental proposal before approving.',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }

                const $accommodationProposal = $('#form-tba-accommodation-selection');
                var selectProposalId = $('#form-tba-flight-selection input[name="tba_other_selection"]:checked').val();
                if ($accommodationProposal.length) {
                    const $selectedProposal = $('#form-tba-accommodation-selection input[name="tba_other_selection"]:checked');
                    selectProposalId = $('#form-tba-accommodation-selection input[name="tba_other_selection"]:checked').val();
                    if ($selectedProposal.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please select at least one accommodation proposal before approving.',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }
                
                var id = $(this).data('id');
                var memoBudgetId = $memoBudget.val();
                var activity = $activity.val()

                Swal.fire({
                    icon: 'question',
                    title: 'Confirm Processing',
                    text: 'Are you sure you want to process this flight proposal?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Process',
                    cancelButtonText: 'Cancel',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        updateTbaStatus(id, 'approve', selectProposalId, null, memoBudgetId, activity);
                    }
                });
            });

            $(document).on('click', '.btn-enable-memo', function () {
                const $btnMemo = $('.btn-save-memo');
                const $memoBudget = $('#memoBudgetSelect');
                const $activity = $('#activityInput');

                $btnMemo.removeClass('hide');
                $memoBudget.prop('disabled', false);
                $activity.prop('disabled', false);
                $(this).addClass('hide')
            });

            $(document).on('click', '.btn-save-memo', function () {
                const $memoBudget = $('#memoBudgetSelect');
                const $activity = $('#activityInput');
                if (
                    !$memoBudget.val() ||
                    !$memoBudget.val().trim() ||
                    !$activity.val() ||
                    !$activity.val().trim()
                ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please complete all required fields before approving.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                
                var id = $(this).data('id');
                var memoBudgetId = $memoBudget.val();
                var activity = $activity.val()

                Swal.fire({
                    icon: 'question',
                    title: 'Confirm Processing',
                    text: 'Are you sure you want to save?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Process',
                    cancelButtonText: 'Cancel',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        updateTbaStatus(id, 'save_memo', null, null, memoBudgetId, activity);
                    }
                });
            });

            // $(document).on('click', '.btn-approve-tba', function () {
            //     console.log('check');
            //     var id = $(this).data('id');

            //     Swal.fire({
            //         icon: 'question',
            //         title: 'Confirm Approval',
            //         text: 'Are you sure you want to approve this flight proposal?',
            //         showCancelButton: true,
            //         confirmButtonText: 'Yes, Approve',
            //         cancelButtonText: 'Cancel',
            //     }).then(function (result) {
            //         if (result.isConfirmed) {
            //             updateTbaStatus(id, 'approve');
            //         }
            //     });
            // });

            $(document).on('click', '.btn-reject-tba', function () {
                var id = $(this).data('id');

                Swal.fire({
                    icon: 'warning',
                    title: 'Rejected',
                    width: '700px',
                    html: `
                        <div style="text-align:center;width:100%;">
                            <label for="reject_note"><strong>Note</strong></label>
                            <textarea id="reject_note"></textarea>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#22598aff',

                    didOpen: () => {
                        tinymce.init({
                            selector: '#reject_note',
                            width: 662,
                            height: 200,
                            menubar: false,
                            branding: false,
                            plugins: 'lists link',
                            toolbar: 'undo redo | bold italic underline | bullist numlist | link'
                        });
                    },

                    preConfirm: () => {
                        const content = tinymce.get('reject_note').getContent();

                        if (!content || content.replace(/<[^>]*>/g, '').trim() === '') {
                            Swal.showValidationMessage('Rejection note is required.');
                            return false;
                        }

                        return content;
                    },

                    willClose: () => {
                        const editor = tinymce.get('reject_note');
                        if (editor) {
                            editor.remove();
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateTbaStatus(id, 'reject_tba', null, result.value);
                    }
                });

                // Swal.fire({
                //     icon: 'question',
                //     title: 'Confirm Rejection',
                //     text: 'Are you sure you want to reject this flight proposal?',
                //     showCancelButton: true,
                //     confirmButtonText: 'Yes, Reject',
                //     cancelButtonText: 'Cancel',
                //     confirmButtonColor: '#dc3545',
                // }).then(function (result) {
                //     if (result.isConfirmed) {
                //         updateTbaStatus(id, 'reject');
                //     }
                // });
            });

            function updateTbaStatus(id, action, selectProposalId = null, note = null, memoBudgetId = null, activity = null) {
                var form_data = {
                    id: id,
                    action: action,
                    selectProposalId: selectProposalId,
                    note: note,
                    memo_budget_id: memoBudgetId,
                    activity: activity
                };
                var icon = (action === 'reject_tba') ? 'error' : 'success';
                var title = (action === 'reject_tba') ? 'Rejected' : 'Success';

                $.ajax({
                    url: '<?= site_url('admin/travel_arrangement_non_eta/update_status') ?>',
                    type: 'POST',
                    data: form_data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: icon,
                                title: title,
                                text: response.message,
                                confirmButtonText: 'close',
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to update status',
                                confirmButtonText: 'close',
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while updating the status',
                            confirmButtonText: 'close',
                        });
                    }
                });
            }

            $(document).on('change', '#form-tba-flight-selection input[type="radio"]', function() {
                const group_name = $(this).attr('name');
                const $form = $('#form-tba-flight-selection');
    
                $form.find('input[name="' + group_name + '"]').closest('.tba-proposal-card').removeClass('is-selected');
                $(this).closest('.tba-proposal-card').addClass('is-selected');
            });
            
            $(document).on('change', '#form-tba-accommodation-selection input[type="radio"]', function() {
                const group_name = $(this).attr('name');
                const $form = $('#form-tba-accommodation-selection');
    
                $form.find('input[name="' + group_name + '"]').closest('.tba-proposal-card').removeClass('is-selected');
                $(this).closest('.tba-proposal-card').addClass('is-selected');
            });
        });

    </script>
<?php endif; ?>

<?php if ($is_approved): ?>
<div class="modal fade" id="mdl_upload_ticket" tabindex="-1" role="dialog" aria-labelledby="mdlUploadTicketLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= site_url('admin/travel_arrangement_non_eta/upload_ticket/' . $application->id) ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mdlUploadTicketLabel">Upload Tickets</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ticket_files">Select Files</label>
                        <input type="file" name="ticket_files[]" id="ticket_files" class="form-control" multiple required>
                        <small class="text-muted">Allowed types: <?= str_replace('|', ', ', ALLOWED_UPLOAD_FILETYPE) ?></small>
                    </div>
                    <div class="form-group">
                        <label for="ticket_note">Note</label>
                        <textarea name="note" id="ticket_note" class="form-control" rows="3" placeholder="Add a note about these tickets..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var $ = window.jQuery;

    if (!$) {
        return;
    }

    function syncTbaProposalDescriptionToggles() {
        $('.tba-proposal-description').each(function () {
            var $description = $(this);
            var $toggle = $description.siblings('.tba-proposal-description-toggle');

            if (!$toggle.length) {
                return;
            }

            if (this.scrollHeight <= this.clientHeight + 1) {
                $toggle.hide().text('Read more');
                return;
            }

            $toggle.show();
            $toggle.text($description.hasClass('is-clamped') ? 'Read more' : 'Show less');
        });
    }

    syncTbaProposalDescriptionToggles();

    // Re-measure when switching tabs: hidden tab panes report zero heights.
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function () {
        syncTbaProposalDescriptionToggles();
    });

    $(document).on('click', '.tba-proposal-description-toggle', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $toggle = $(this);
        var $description = $toggle.siblings('.tba-proposal-description');

        if (!$description.length) {
            return;
        }

        if ($description.hasClass('is-clamped')) {
            $description.removeClass('is-clamped');
            $toggle.text('Show less');
            return;
        }

        $description.addClass('is-clamped');
        $toggle.text('Read more');
    });

    $(document).on('click', '.btn-open-ticket-upload', function () {
        $('#mdl_upload_ticket').modal('show');
    });

    $(document).on('click', '.btn-notify-ticket', function () {
        var url = $(this).data('url');

        Swal.fire({
            icon: 'question',
            title: 'Notify Grantee',
            text: 'Notify the grantee about the uploaded tickets? The ticket files will be attached to the email.',
            showCancelButton: true,
            confirmButtonText: 'Yes, Notify',
            cancelButtonText: 'Cancel',
        }).then(function (result) {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });

    $(document).on('click', '.btn-delete-ticket', function () {
        var url = $(this).data('url');

        Swal.fire({
            icon: 'warning',
            title: 'Delete Ticket',
            text: 'Are you sure you want to delete this ticket? This action cannot be undone.',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc3545',
        }).then(function (result) {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });


    // $(".ticket_note").not(".dateRangePicker").blur(function() {
    $(document).on('blur', '.ticket_note', function () {
        update_note_ticket(this);
    });

    $(document).on('blur', '.final_price_ticket', function () {
        update_final_price_ticket(this);
    });
});


function addTicketRow(type) {
    const $tbody = $('#ticketTbody-' + type);
    var rowCounter = $tbody.find('.tr-' + type).length + 1;
    let trEmpty = $tbody.find('.tr-empty-' + type);
    var application_id = $tbody.data('application-id');
    
    var form_data = {
        application_id: application_id,
        type: type
    };
    showSwal('loading', 'Please wait while we process your request.');

    $.ajax({
        url: '<?= site_url('admin/travel_arrangement_non_eta/add_row_ticket_ajax') ?>',
        type: 'POST',
        data: form_data,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                Swal.close(); 
                show_toast_message(response.message);
                if(trEmpty.length){
                    trEmpty.remove();
                }

                var final_price = '<td>-</td>';
                if(rowCounter === 1){
                    final_price = `
                        <td>
                            <input type="text" class="form-control final_price_ticket final_price_ticket_${type}" data-currency="${currency}" placeholder="Final Price">
                        </td>`;

                }
                
                const currency = (type === 'international') ? '<?= $currency_international ?>' : (type === 'accommodation' ? '<?= $currency_accommodation ?>' : '<?= $currency_domestic ?>');

                const html = `
                    <tr class="tr-${type}" data-id="${response.id}" data-application-id="${application_id}">
                        <td style="text-align: center;">${rowCounter}</td>
                        <td class="td-row-file">
                            <span style="color: #94a3b8; font-style: italic;" id="fileNameRow${response.id}">
                                No ticket uploaded
                            </span>
                        </td>
                        ${final_price}
                        <td>
                            <textarea name="note" class="form-control ticket_note" rows="3" placeholder="Add a note about these tickets..."></textarea>
                        </td>
                        <td class="td-row-date">-</td>
                        <td style="text-align: center;">
                            <div class="table-action-group" style="justify-content: center;">
                                <input 
                                    type="file" 
                                    id="fileRow${response.id}" 
                                    style="display: none;"
                                    onchange="handleFileRowChange(${response.id}, this, '${type}')"
                                >

                                <button 
                                    onclick="document.getElementById('fileRow${response.id}').click()"
                                    type="button" 
                                    class="btn-upload-direct"
                                >
                                    Upload
                                </button>
                                <button 
                                    data-url="<?= site_url('admin/travel_arrangement_non_eta/delete_ticket/') ?>/${response.id}"
                                    type="button" 
                                    class="btn-delete-row btn-delete-ticket"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                $tbody.append(html);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to update status',
                    confirmButtonText: 'close',
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating the status',
                confirmButtonText: 'close',
            });
        }
    });
}

function handleFileRowChange(index, input, flightType) {
    const file = $(input).prop('files')[0];
    const BASEURL = '<?= base_url() ?>';

    if (!file) {
        return;
    }

    const $row = $(input).closest('tr');
    const $tbody = $row.closest('tbody');
    const $tdFile = $row.find('.td-row-file');
    const $tdDate = $row.find('.td-row-date');
    const id = $row.data('id') || index || '';
    const application_id = $row.data('application-id') || $tbody.data('application-id');
    const type = flightType || ($row.hasClass('tr-international') ? 'international' : ($row.hasClass('tr-accommodation') ? 'accommodation' : 'domestic'));
    const note = $row.find('.ticket_note').val() || '';
    const final_price = $row.find('.final_price_ticket').val() || '';
    const currency = $row.find('.final_price_ticket').data('currency') || (type === 'international' ? '<?= $currency_international ?>' : (type === 'accommodation' ? '<?= $currency_accommodation ?>' : '<?= $currency_domestic ?>'));

    const formData = new FormData();
    formData.append('id', id);
    formData.append('application_id', application_id);
    formData.append('type', type);
    formData.append('note', note);
    formData.append('final_price', final_price);
    formData.append('currency', currency);
    formData.append('file', file);

    $(input).prop('disabled', true);

    $.ajax({
        url: '<?= site_url('admin/travel_arrangement_non_eta/upload_ticket_ajax') ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,

        success: function(response) {
            if (response.success) {
                show_toast_message(response.message);

                const newId = response.id || id;
                $row.attr('data-id', newId);
                $row.data('id', newId);

                $tdFile.html(`
                    <div class="file-preview-cell">
                        <a href="${BASEURL + response.file.path}" class="lightbox">
                            <i class="fa fa-file"></i> ${file.name}
                        </a>
                        <a href="${BASEURL + response.file.path}" download class="btn btn-primary btn-xs" style="color:#fff;"><i class="fa fa-download"></i></a>
                    </div>
                `);

                $row.find('.td-row-date').text(response.created_at);

                if (newId) {
                    const deleteUrl = '<?= site_url('admin/travel_arrangement_non_eta/delete_ticket/') ?>/' + newId;
                    $(input).attr('id', 'fileRow' + newId).attr('onchange', `handleFileRowChange(${newId}, this, '${type}')`);
                    $row.find('.btn-upload-direct').attr('onclick', `document.getElementById('fileRow${newId}').click()`);
                    const $delBtn = $row.find('.btn-delete-row');
                    $delBtn.removeAttr('onclick')
                           .addClass('btn-delete-ticket')
                           .attr('data-url', deleteUrl);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to upload file',
                    confirmButtonText: 'Close'
                });

                $(input).val('');
            }
        },

        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while uploading the file',
                confirmButtonText: 'Close'
            });

            $(input).val('');
        },

        complete: function() {
            $(input).prop('disabled', false);
        }
    });
}

function deleteRow(btn, type) {
    const $tbody = $('#ticketTbody-' + type);
    const row = btn.closest('tr');
    const table = '.table-' + type;
    if (confirm('Delete this ticket row?')) {
        showSwal('loading', 'Please wait while we process your request.');
        row.remove();
        updateOrderAfterDelete(table);
        if ($tbody.find('.tr-' + type).length === 0) {
            $tbody.html(`
                <tr class="tr-empty-${type}">
                    <td class="text-center td-empty" colspan="6">No tickets have been uploaded yet.</td>
                </tr>
            `);
        }
    }
}

function updateOrderAfterDelete(table) {
    $(table + " tbody").find('tr').each(function(index) {
        let row = $(this);
        if (!row.hasClass('tr-empty-international') && !row.hasClass('tr-empty-domestic') && !row.hasClass('tr-empty-accommodation')) {
            row.find('td:first').text(index + 1);
        }
    });
}

function update_note_ticket(element, value = null, extraData = {}) {
    var $element = $(element);
    const $row = $(element).closest('tr');
    const $tbody = $row.closest('tbody');
    const id = $row.data('id') || '';
    const application_id = $row.data('application-id') || $tbody.data('application-id');
    const type = $row.hasClass('tr-international') ? 'international' : ($row.hasClass('tr-accommodation') ? 'accommodation' : 'domestic');

    var data = {
        value: value !== null ? value : $element.val(),
        id: id,
        application_id: application_id,
        type: type
    };

    $.ajax({
        url: "<?= base_url(); ?>admin/travel_arrangement_non_eta/update_note_ticket",
        method: "POST",
        dataType: 'json',
        data: data
    }).done(function(data) {
        show_toast_message('Successfully Update!');
        if (data && data.id && !id) {
            const newId = data.id;
            $row.attr('data-id', newId).data('id', newId);
            const $fileInput = $row.find('input[type="file"]');
            $fileInput.attr('id', 'fileRow' + newId).attr('onchange', `handleFileRowChange(${newId}, this, '${type}')`);
            $row.find('.btn-upload-direct').attr('onclick', `document.getElementById('fileRow${newId}').click()`);
            const deleteUrl = '<?= site_url('admin/travel_arrangement_non_eta/delete_ticket/') ?>/' + newId;
            $row.find('.btn-delete-row').removeAttr('onclick').addClass('btn-delete-ticket').attr('data-url', deleteUrl);
        }
    });
}

function update_final_price_ticket(element, value = null, extraData = {}) {
    var $element = $(element);
    const $row = $(element).closest('tr');
    const $tbody = $row.closest('tbody');
    const id = $row.data('id') || '';
    const application_id = $row.data('application-id') || $tbody.data('application-id');
    const type = $row.hasClass('tr-international') ? 'international' : ($row.hasClass('tr-accommodation') ? 'accommodation' : 'domestic');
    const currency = $element.data('currency') || (type === 'international' ? '<?= $currency_international ?>' : (type === 'accommodation' ? '<?= $currency_accommodation ?>' : '<?= $currency_domestic ?>'));

    var data = {
        value: value !== null ? value : $element.val(),
        id: id,
        application_id: application_id,
        type: type,
        currency: currency
    };

    $.ajax({
        url: "<?= base_url(); ?>admin/travel_arrangement_non_eta/update_final_price_ticket",
        method: "POST",
        dataType: 'json',
        data: data
    }).done(function(data) {
        show_toast_message('Successfully Update!');
        if (data && data.id && !id) {
            const newId = data.id;
            $row.attr('data-id', newId).data('id', newId);
            const $fileInput = $row.find('input[type="file"]');
            $fileInput.attr('id', 'fileRow' + newId).attr('onchange', `handleFileRowChange(${newId}, this, '${type}')`);
            $row.find('.btn-upload-direct').attr('onclick', `document.getElementById('fileRow${newId}').click()`);
            const deleteUrl = '<?= site_url('admin/travel_arrangement_non_eta/delete_ticket/') ?>/' + newId;
            $row.find('.btn-delete-row').removeAttr('onclick').addClass('btn-delete-ticket').attr('data-url', deleteUrl);
        }
    });
}
</script>
<?php endif; ?>

<script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
<script>
    $(document).ready(function() {
        initCurrencyFormatter('.tba_price', '.tba_currency');
        initCurrencyFormatter('.final_price_ticket_international', '<?= $currency_international ?>');
        initCurrencyFormatter('.final_price_ticket_domestic', '<?= $currency_domestic ?>');
        initCurrencyFormatter('.final_price_ticket_accommodation', '<?= $currency_accommodation ?>');
    });
</script>

<div class="modal fade" id="mdl_delete_payment_choice" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Travel Arrangement</h4>
            </div>
            <div class="modal-body">
                <p><span id="delete_payment_choice_text"></span></p>
            </div>
            <div class="modal-footer">
                <a href="#" id="btn_with_payments" class="btn btn-danger" onclick="return confirm('Delete the travel arrangement together with all of its linked payments? This action cannot be undone.')">
                    <i class="fa fa-trash"></i> Delete with payments
                </a>
                <a href="#" id="btn_keep_payments" class="btn btn-warning" onclick="return confirm('Delete the travel arrangement only? The linked payment(s) will be kept and unlinked.')">
                    <i class="fa fa-times"></i> Delete travel arrangement only
                </a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
(function () {
    function showPaymentChoice(count, withUrl, keepUrl) {
        document.getElementById('delete_payment_choice_text').textContent =
            'This travel arrangement has ' + count + ' linked payment(s). Please choose how to proceed.';
        document.getElementById('btn_with_payments').setAttribute('href', withUrl);
        document.getElementById('btn_keep_payments').setAttribute('href', keepUrl);
        var timer = setInterval(function () {
            if (window.jQuery) {
                clearInterval(timer);
                jQuery('#mdl_delete_payment_choice').modal('show');
            }
        }, 50);
        setTimeout(function () { clearInterval(timer); }, 5000);
    }
    document.addEventListener('click', function (e) {
        var btn = e.target && e.target.closest ? e.target.closest('.btn-delete-travel') : null;
        if (!btn) {
            return;
        }
        var count = parseInt(btn.getAttribute('data-payments') || '0', 10);
        if (count > 0) {
            e.preventDefault();
            showPaymentChoice(count, btn.getAttribute('data-with-url'), btn.getAttribute('data-keep-url'));
        } else if (!confirm('Are you sure you want to delete this travel arrangement and all of its related data? This action cannot be undone.')) {
            e.preventDefault();
        }
    });
})();
</script>
