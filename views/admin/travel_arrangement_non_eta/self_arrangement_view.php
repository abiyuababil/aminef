<style>
    .nav-pills > li > a {
        color: #333;
        border-radius: 4px;
        background-color: #f5f5f5;
        margin-right: 5px;
    }
    .nav-pills > li.active > a,
    .nav-pills > li.active > a:focus,
    .nav-pills > li.active > a:hover {
        background-color: #013473;
        color: #fff;
    }
    .tab-content {
        padding: 20px;
    }
    .flight-option.disabled {
        cursor: not-allowed;
    }
    /* .flight-option {
        background: #fff;
        border: 1px solid #dfe7ef;
        border-radius: 6px;
        border-left-width: 1px;
        box-shadow: none;
        transform: none;
    } */
    .flight-option:hover {
        box-shadow: none;
        transform: none;
    }
    .flight-option.is-selected {
        background: #edf9f0;
        border-color: #28a745;
        /* box-shadow: inset 0 0 0 1px #b9e3c4; */
    }
    .flight-option-header {
        display: flex;
        align-items: baseline;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 6px;
    }
    .flight-option-header label {
        display: inline-flex;
        align-items: center;
        line-height: 20px;
        margin-bottom: 0;
    }
    .flight-option-selected-note {
        display: none;
        align-items: center;
        gap: 4px;
        color: #1f7a34;
        line-height: 20px;
    }
    .flight-option.is-selected .flight-option-selected-note {
        display: inline-flex;
    }
    .flight-option-summary {
        background: transparent;
        border: 0;
        border-radius: 0;
        padding: 0;
        margin-top: 0;
    }
    .flight-option-price-text {
        font-weight: 400;
        color: #0e6ba8;
    }
    .flight-option-description-text {
        display: block;
        margin-top: 0;
        margin-bottom: 10px;
        padding-left: 10px;
        border-left: 3px solid #dfe7ef;
        color: #4f5f6f;
        font-weight: 400;
        white-space: pre-wrap;
    }
    .flight-option-description-text.is-clamped {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        white-space: normal;
    }
    .flight-option-description-toggle {
        display: none;
        margin-top: -4px;
        margin-bottom: 10px;
        padding: 0;
        border: 0;
        background: transparent;
        color: #0e6ba8;
        font-size: 12px;
        font-weight: 400;
        text-decoration: underline;
    }
    .flight-option-description-toggle:hover,
    .flight-option-description-toggle:focus {
        color: #0a537f;
        outline: none;
    }
    .flight-option.is-selected .flight-option-price-text,
    .flight-option.is-selected .flight-option-selected-note {
        color: #1f7a34;
    }
    .flight-option.is-selected .flight-option-description-text {
        border-left-color: #7bc48d;
        color: #4f5f6f;
    }
    .flight-option-preview {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
    }
    .flight-option-thumb-wrap {
        width: auto;
        height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .flight-option-thumb {
        width: 100px;
        min-height: 60px;
        object-fit: contain;
        display: block;
    }
    /* .upload-container {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: stretch;
    } */
    /* .flight-option {
        width: calc((100% - 32px) / 3);
        min-width: 0;
        max-width: none;
        padding: 0 !important;
        display: flex;
        flex-direction: column;
    } */
    .flight-option .form-group {
        width: 100%;
        display: flex;
        flex-direction: column;
        height: 100%;
        flex: 1;
        padding: 14px;
    }
    /* @media (max-width: 991px) {
        .flight-option {
            width: calc((100% - 16px) / 2);
        }
    }
    @media (max-width: 767px) {
        .flight-option {
            width: 100%;
        }
    } */

    /* Activity Timeline Styles */
    .activity-timeline {
        position: relative;
        padding: 20px 0 20px 40px;
    }

    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e0e0e0;
    }

    .activity-step {
        margin-bottom: 25px;
        position: relative;
    }

    .activity-step::before {
        content: '';
        position: absolute;
        left: -32px;
        top: 3px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid #e0e0e0;
        z-index: 1;
    }

    .activity-step.completed::before {
        background-color: #013473;
        border-color: #013473;
        left:-30px;
    }

    .activity-step.active::before {
        background-color: #013473;
        border-color: #013473;
        left:-30px;
    }

    .activity-step-content {
        padding: 10px 0;
    }

    .activity-step-action {
        font-weight: 600;
        color: #333;
        font-size: 14px;
        margin-bottom: 3px;
    }

    .activity-step-info {
        color: #666;
        font-size: 13px;
        line-height: 1.4;
    }

    .activity-step-user {
        color: #013473;
        font-weight: 500;
    }

    .activity-step-date {
        color: #999;
        font-size: 12px;
    }
    .summary-info {
        border: 1px solid #e3e7ea;
        background: #fff;
        padding: 15px;
        margin-bottom: 15px;
    }
    .travel-purpose-info {
        display: block;
        width: 100%;
        max-width: 100%;
        text-align: left;
    }
    .travel-purpose-content {
        margin-top: 6px;
        white-space: normal;
        line-height: 1.6;
        color: #333;
        text-align: left;
    }
    .travel-purpose-content p {
        margin: 0;
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



    /* Category Section Styling */
    .category-block {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        margin-bottom: 24px;
        overflow: hidden;
        background: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    /* Red Border on Validation Error */
    .category-block.validation-error {
        border: 1px solid #ef4444;
        box-shadow: 0 0 0 1px #ef4444;
    }

    .category-title {
        background-color: #f8fafc;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: bold;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category-badge-count {
        font-size: 12px;
        font-weight: normal;
        color: #64748b;
    }

    /* Table */
    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    th,
    td {
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
        text-align: left;
    }

    th {
        background-color: #ffffff;
        color: #64748b;
        font-weight: 600;
        font-size: 12px;
    }

    tr:last-child td {
        border-bottom: none;
    }

    /* Row Selection States */
    tr.option-row {
        cursor: pointer;
        user-select: none;
        transition: background-color 0.15s ease;
    }

    tr.option-row:hover {
        background-color: #f8fafc;
    }

    tr.option-row.is-selected {
        background-color: #f0fdf4;
    }

    .price-text {
        font-weight: bold;
        color: #1e293b;
    }

    tr.option-row.is-selected .price-text {
        color: #15803d;
    }

    .doc-link {
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
    }

    .doc-link:hover {
        text-decoration: underline;
    }

    .pref-cell {
        font-weight: 600;
    }

    .pref-cell.is-selected {
        color: #15803d;
    }

    .pref-cell.unselected {
        color: #94a3b8;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $title ?></h1>
    </div>
</div>

<?php
// Categorize attachments by type
$international_attachments = [];
$domestic_attachments = [];
$other_attachments = [];
$accommodation_attachments = [];
$receipt_attachments = [];

if (isset($attachments) && is_array($attachments)) {
    foreach ($attachments as $att) {
        if (strpos($att->ref_type, 'flight_proposal_international') !== false) {
            $international_attachments[] = $att;
        } elseif (strpos($att->ref_type, 'flight_proposal_domestic') !== false) {
            $domestic_attachments[] = $att;
        } elseif (strpos($att->ref_type, 'flight_proposal_other') !== false) {
            $other_attachments[] = $att;
        } elseif (strpos($att->ref_type, 'flight_proposal_accommodation') !== false) {
            $accommodation_attachments[] = $att;
        } elseif (strpos($att->ref_type, 'flight_reimbursement_request') !== false) {
            $receipt_attachments[] = $att;
        }
    }
}

$all_attachments = array_merge(
    $international_attachments ?? [],
    $domestic_attachments ?? [],
    $other_attachments ?? [],
    $accommodation_attachments ?? [],
    $receipt_attachments ?? []
);

$active_tab = 'flight-proposal';
if (
    isset($application) && 
    in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_PAYMENT_IN_PROGRESS, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_PAYMENT_RELEASE])
    && ($application->type_flight != 'Other' && $application->type_flight != 'Accommodation')
) {
    $active_tab = 'flight-reimbursement';
}

if (isset($payments) && !empty($payments)) {
    $active_tab = 'payment';
}
?>

<div class="row">
    <div class="col-lg-12">
    <div class="col-md-12">

        <div class="card" style="position:relative;">
            <div class="pull-right" style="position:absolute;top:12px;right:20px;z-index:5;">
                <?php
                    $del_total = isset($total_payments) ? (int) $total_payments : 0;
                    $delete_with_url = site_url("admin/travel_arrangement_non_eta/delete/".$application->id."?mode=with_payments");
                    $delete_keep_url = site_url("admin/travel_arrangement_non_eta/delete/".$application->id."?mode=keep_payments");
                    $delete_plain_url = site_url("admin/travel_arrangement_non_eta/delete/".$application->id);
                ?>
                <a href="<?php echo $delete_plain_url ?>" class="btn btn-danger btn-delete-travel" data-payments="<?php echo $del_total ?>" data-with-url="<?php echo $delete_with_url ?>" data-keep-url="<?php echo $delete_keep_url ?>">
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
                        <div class="value">Self Arrangement</div>
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
                </div>
            </div>
            
            <div class="card-footer">
                <div class="status-container">
                    Status: <?= format_status_travel_arrangement_non_eta($application->status, $application->type) ?>
                    <?php if(in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_SUBMITTED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED])) : ?>
                    <a class="btn btn-outline-danger btn-cancelled" data-id="<?= $application->id ?>">Cancel Request</a>
                    <?php endif; ?>
                    <?php if($application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_CANCELLED) : ?>
                        <a class="btn btn-xs btn-outline-warning btn-cancelled-note" onclick="showReason(this)" data-note="<?= strip_tags($application->note) ?>">Note</a>
                    <?php endif; ?>
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
        <div class="summary-info hide">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Grantee Name:</strong><br><?= get_full_name($grantee_grant, 'US') ?></p>
                    <p><strong>Application Type:</strong><br><?= ucfirst(str_replace('_', ' ', $application->type)) ?></p>
                    <p><strong>Status:</strong><br><?= format_status_travel_arrangement_non_eta($application->status, $application->type) ?></p>
                    <a 
                        href="#" 
                        data-grantname="<?php echo $grantee_grant->grant_name ?>" 
                        data-period="<?php echo $grantee_grant->fiscal_year ?>" 
                        data-name="<?= get_full_name($grantee_grant, 'US') ?>" 
                        data-id="<?= $application->id ?>" 
                        data-category="<?php echo ucfirst(str_replace('_', ' ', $application->type)) ?>"
                        data-ajax_url="<?php echo site_url('admin/notes/get_list_ajax/non_eta_travel/' . $grantee_grant->id . '/'); ?><?= $application->id ?>"  
                        class="open-offcanvas-note btn btn-xs btn-warning btn-chat">
                            <i class="fa fa-comments"></i> Chat
                            <span class="note-total-<?= $application->id ?> span-note-travel" data-total="<?= $application->total_notes ?>">
                                <span class="badge"><?= $application->total_notes ?></span>
                            </span>
                    </a>
                </div>
                <div class="col-md-6">
                    <p><strong>Created At:</strong><br><?= date('d F Y H:i', strtotime($application->created_at)) ?></p>
                    <p><strong>Updated At:</strong><br><?= !empty($application->updated_at) ? date('d F Y H:i', strtotime($application->updated_at)) : '-' ?></p>
                    <?php if ($application->approved_at && in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT])): ?>
                        <p><strong>Approved by:</strong><br><?php  $staff = get_staff($application->approved_by, false); echo $staff ? $staff->full_name : ''; ?></p>
                        <p><strong>Approved at:</strong><br><?= date('d F Y H:i', strtotime($application->approved_at)) ?></p>
                    <?php endif; ?>
                    <?php if ($application->rejected_at && in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_DECLINED])): ?>
                        <p><strong>Rejected by:</strong><br><?php  $staff = get_staff($application->rejected_by, false); echo $staff ? $staff->full_name : ''; ?></p>
                        <p><strong>Rejected at:</strong><br><?= date('d F Y H:i', strtotime($application->rejected_at)) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="summary-info travel-purpose-info">
            <strong>Travel Purpose</strong>
            <div class="travel-purpose-content"><?php
                $travel_purpose_text = isset($application->travel_purposes) ? trim((string)$application->travel_purposes) : '';
                if ($travel_purpose_text !== '') {
                    echo html_escape($travel_purpose_text);
                    if (in_array(strtolower($travel_purpose_text), ['other', 'others'], true) && !empty($application->travel_purposes_other)) {
                        echo '<div style="margin-top: 6px; padding: 6px 10px; background: #f8fafc; border-left: 3px solid #0e6ba8; border-radius: 4px; font-weight: normal;"><strong>Specified:</strong> ' . nl2br(html_escape($application->travel_purposes_other)) . '</div>';
                    }
                } else {
                    echo '<em style="color: #999;">No travel purpose provided</em>';
                }
            ?></div>
        </div>
    </div>

    <div class="col-lg-12">
        <ul class="nav nav-pills" data-active-tab="<?= $active_tab ?>">
            <li class="<?= $active_tab == 'flight-proposal' ? 'active' : '' ?>"><a style="border-radius:0px;" data-toggle="tab" href="#flight-proposal" aria-expanded="false"><i class="fa fa-plane"></i> Travel Proposal</a></li>
            <?php if (in_array($application->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_PAYMENT_IN_PROGRESS, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_PAYMENT_RELEASE]) || (isset($payments) && !empty($payments))) { ?>
                <?php if(!in_array($application->type_flight, ['Other', 'Accommodation'])) : ?>
                <li class="<?= $active_tab == 'flight-reimbursement' ? 'active' : '' ?>"><a style="border-radius:0px;" data-toggle="tab" href="#flight-reimbursement" aria-expanded="false"><i class="fa fa-money"></i> Travel Reimbursement</a></li>
                <?php endif; ?>
                <li class="<?= $active_tab == 'payment' ? 'active' : '' ?>"><a style="border-radius:0px;" data-toggle="tab" href="#payment" aria-expanded="false"><i class="fa fa-credit-card"></i> Payment</a></li>
            <?php } ?>
            <!-- <li><a style="border-radius:0px;" data-toggle="tab" href="#activity" aria-expanded="false"><i class="fa fa-history"></i> Activity</a></li> -->
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade <?= $active_tab == 'flight-proposal' ? 'active in' : '' ?>" id="flight-proposal">
            <?php if($application->type_flight == 'International') { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="category-block" id="cat-international">
                        <div class="category-title">
                            <span>International Travel</span>
                            <?php if(!empty($international_attachments)) : ?>
                            <span class="category-badge-count"><?= count($international_attachments)?> Options Submitted</span>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 160px;">Description</th>
                                        <th style="width: 130px;">Price</th>
                                        <th style="width: 150px;">Attachment</th>
                                        <th style="width: 50px;">Preference</th>
                                    </tr>
                                </thead>
                                <tbody class="upload-container" data-application-status="<?= $application->status ?>">
                                    <?php if (!empty($international_attachments)): ?>
                                        <?php foreach($international_attachments as $index => $attachment):
                                            $preview_url = base_url(preg_match('/\.(jpg|jpeg|png)$/i', $attachment->file_path) ? $attachment->file_path : 'assets/images/icons/pdf.svg');
                                            $file_url = base_url($attachment->file_path);
                                            $is_previewable = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $attachment->file_path);
                                            $option_currency = isset($attachment->currency) ? strtoupper(trim($attachment->currency)) : 'USD';
                                            if (!in_array($option_currency, ['IDR', 'USD'], true)) {
                                                $option_currency = 'USD';
                                            }
                                            $option_price_raw = isset($attachment->price) ? $attachment->price : null;
                                            $option_price_normalized = function_exists('unformat_money') ? unformat_money($option_price_raw) : (is_numeric($option_price_raw) ? (float)$option_price_raw : null);
                                            $option_price_text = $option_price_normalized !== null
                                                ? (function_exists('format_money') ? format_money($option_price_normalized, $option_currency) : number_format($option_price_normalized, 2))
                                                : '-';
                                            $option_description = isset($attachment->description) && $attachment->description !== '' ? $attachment->description : '-';
                                        ?>
                                            <tr class="option-row flight-option flight-option-intl <?= $attachment->is_selected ? 'is-selected' : '' ?>" data-attachment-id="<?= $attachment->id ?>" data-ref-type="flight_proposal_international" style="cursor: pointer;">
                                                <td>
                                                    <?= html_escape($option_description) ?>
                                                    <input type="checkbox" class="attachment-checkbox" name="international_attachment" value="<?= $attachment->id ?>" <?= $attachment->is_selected ? 'checked' : '' ?> style="display: none;">
                                                </td>
                                                <td><span class="price-text"><?= html_escape($option_price_text) ?></span></td>
                                                <td>
                                                    <?php 
                                                    $opt_files = function_exists('parse_flight_option_files') ? parse_flight_option_files($attachment) : [];
                                                    if (!empty($opt_files)):
                                                        foreach ($opt_files as $opt_file):
                                                            $opt_f_url = base_url($opt_file['file_path']);
                                                            $opt_f_name = !empty($opt_file['file_name']) ? $opt_file['file_name'] : file_name($opt_f_url);
                                                            $opt_is_prev = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $opt_file['file_path']);
                                                    ?>
                                                        <div style="display:flex; align-items:center; gap:6px; margin-bottom:4px;">
                                                            <a href="<?= $opt_f_url ?>" target="_blank" <?= $opt_is_prev ? 'class="lightbox" aria-haspopup="dialog"' : '' ?> onclick="event.stopPropagation();">
                                                                <?= html_escape($opt_f_name) ?>
                                                            </a>
                                                            <a href="<?= $opt_f_url ?>" target="_blank" class="btn btn-primary btn-xs ml-2" download onclick="event.stopPropagation();">
                                                                <i class="fa fa-download fa-fw"></i>
                                                            </a>
                                                        </div>
                                                    <?php 
                                                        endforeach;
                                                    else: 
                                                    ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="pref-cell unselected"><span class="flight-option-selected-note"><i class="fa fa-check-circle"></i> Selected</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> International flight documents is not uploaded yet.
                                        </div>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if($application->type_flight == 'Domestic') { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="category-block" id="cat-domestic">
                        <div class="category-title">
                            <span>Domestic Travel</span>
                            <?php if(!empty($domestic_attachments)) : ?>
                            <span class="category-badge-count"><?= count($domestic_attachments)?> Options Submitted</span>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 160px;">Description</th>
                                        <th style="width: 130px;">Price</th>
                                        <th style="width: 150px;">Attachment</th>
                                        <th style="width: 50px;">Preference</th>
                                    </tr>
                                </thead>
                                <tbody class="upload-container" data-application-status="<?= $application->status ?>">
                                    <?php if (!empty($domestic_attachments)): ?>
                                        <?php foreach($domestic_attachments as $index => $attachment):
                                            $preview_url = base_url(preg_match('/\.(jpg|jpeg|png)$/i', $attachment->file_path) ? $attachment->file_path : 'assets/images/icons/pdf.svg');
                                            $file_url = base_url($attachment->file_path);
                                            $is_previewable = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $attachment->file_path);
                                            $option_currency = isset($attachment->currency) ? strtoupper(trim($attachment->currency)) : 'USD';
                                            if (!in_array($option_currency, ['IDR', 'USD'], true)) {
                                                $option_currency = 'USD';
                                            }
                                            $option_price_raw = isset($attachment->price) ? $attachment->price : null;
                                            $option_price_normalized = function_exists('unformat_money') ? unformat_money($option_price_raw) : (is_numeric($option_price_raw) ? (float)$option_price_raw : null);
                                            $option_price_text = $option_price_normalized !== null
                                                ? (function_exists('format_money') ? format_money($option_price_normalized, $option_currency) : number_format($option_price_normalized, 2))
                                                : '-';
                                            $option_description = isset($attachment->description) && $attachment->description !== '' ? $attachment->description : '-';
                                        ?>
                                            <tr class="option-row flight-option flight-option-dom <?= $attachment->is_selected ? 'is-selected' : '' ?>" data-attachment-id="<?= $attachment->id ?>" data-ref-type="flight_proposal_domestic" style="cursor: pointer;">
                                                <td>
                                                    <?= html_escape($option_description) ?>
                                                    <input type="checkbox" class="attachment-checkbox" name="domestic_attachment" value="<?= $attachment->id ?>" <?= $attachment->is_selected ? 'checked' : '' ?> style="display: none;">
                                                </td>
                                                <td><span class="price-text"><?= html_escape($option_price_text) ?></span></td>
                                                <td>
                                                    <?php 
                                                    $opt_files = function_exists('parse_flight_option_files') ? parse_flight_option_files($attachment) : [];
                                                    if (!empty($opt_files)):
                                                        foreach ($opt_files as $opt_file):
                                                            $opt_f_url = base_url($opt_file['file_path']);
                                                            $opt_f_name = !empty($opt_file['file_name']) ? $opt_file['file_name'] : file_name($opt_f_url);
                                                            $opt_is_prev = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $opt_file['file_path']);
                                                    ?>
                                                        <div style="display:flex; align-items:center; gap:6px; margin-bottom:4px;">
                                                            <a href="<?= $opt_f_url ?>" target="_blank" <?= $opt_is_prev ? 'class="lightbox" aria-haspopup="dialog"' : '' ?> onclick="event.stopPropagation();">
                                                                <?= html_escape($opt_f_name) ?>
                                                            </a>
                                                            <a href="<?= $opt_f_url ?>" target="_blank" class="btn btn-primary btn-xs ml-2" download onclick="event.stopPropagation();">
                                                                <i class="fa fa-download fa-fw"></i>
                                                            </a>
                                                        </div>
                                                    <?php 
                                                        endforeach;
                                                    else: 
                                                    ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="pref-cell unselected"><span class="flight-option-selected-note"><i class="fa fa-check-circle"></i> Selected</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> Domestic flight documents is not uploaded yet.
                                        </div>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if($application->type_flight == 'Other') { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="category-block" id="cat-other">
                        <div class="category-title">
                            <span>Other Transportation (Bus, Train, Etc)</span>
                            <?php if(!empty($other_attachments)) : ?>
                            <span class="category-badge-count"><?= count($other_attachments)?> Options Submitted</span>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <!-- <th style="width: 160px;">Description</th> -->
                                        <th style="width: 130px;">Price</th>
                                        <th style="width: 150px;">Attachment</th>
                                        <th style="width: 50px;">Preference</th>
                                    </tr>
                                </thead>
                                <tbody class="upload-container" data-application-status="<?= $application->status ?>">
                                    <?php if (!empty($other_attachments)): ?>
                                        <?php foreach($other_attachments as $index => $attachment):
                                            $preview_url = base_url(preg_match('/\.(jpg|jpeg|png)$/i', $attachment->file_path) ? $attachment->file_path : 'assets/images/icons/pdf.svg');
                                            $file_url = base_url($attachment->file_path);
                                            $is_previewable = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $attachment->file_path);
                                            $option_currency = isset($attachment->currency) ? strtoupper(trim($attachment->currency)) : 'USD';
                                            if (!in_array($option_currency, ['IDR', 'USD'], true)) {
                                                $option_currency = 'USD';
                                            }
                                            $option_price_raw = isset($attachment->price) ? $attachment->price : null;
                                            $option_price_normalized = function_exists('unformat_money') ? unformat_money($option_price_raw) : (is_numeric($option_price_raw) ? (float)$option_price_raw : null);
                                            $option_price_text = $option_price_normalized !== null
                                                ? (function_exists('format_money') ? format_money($option_price_normalized, $option_currency) : number_format($option_price_normalized, 2))
                                                : '-';
                                            $option_description = isset($attachment->description) && $attachment->description !== '' ? $attachment->description : '-';
                                        ?>
                                            <tr class="option-row flight-option flight-option-intl <?= $attachment->is_selected ? 'is-selected' : '' ?>" data-attachment-id="<?= $attachment->id ?>" data-ref-type="flight_proposal_other" style="cursor: pointer;">
                                                <!-- <td>
                                                    <?php //html_escape($option_description) ?>
                                                    <input type="checkbox" class="attachment-checkbox" name="other_attachment" value="<?php //$attachment->id ?>" <?php //$attachment->is_selected ? 'checked' : '' ?> style="display: none;">
                                                </td> -->
                                                <td><span class="price-text"><?= html_escape($option_price_text) ?></span></td>
                                                <td>
                                                    <?php 
                                                    $opt_files = function_exists('parse_flight_option_files') ? parse_flight_option_files($attachment) : [];
                                                    if (!empty($opt_files)):
                                                        foreach ($opt_files as $opt_file):
                                                            $opt_f_url = base_url($opt_file['file_path']);
                                                            $opt_f_name = !empty($opt_file['file_name']) ? $opt_file['file_name'] : file_name($opt_f_url);
                                                            $opt_is_prev = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $opt_file['file_path']);
                                                    ?>
                                                        <div style="display:flex; align-items:center; gap:6px; margin-bottom:4px;">
                                                            <a href="<?= $opt_f_url ?>" target="_blank" <?= $opt_is_prev ? 'class="lightbox" aria-haspopup="dialog"' : '' ?> onclick="event.stopPropagation();">
                                                                <?= html_escape($opt_f_name) ?>
                                                            </a>
                                                            <a href="<?= $opt_f_url ?>" target="_blank" class="btn btn-primary btn-xs ml-2" download onclick="event.stopPropagation();">
                                                                <i class="fa fa-download fa-fw"></i>
                                                            </a>
                                                        </div>
                                                    <?php 
                                                        endforeach;
                                                    else: 
                                                    ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="pref-cell unselected"><span class="flight-option-selected-note"><i class="fa fa-check-circle"></i> Selected</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> Other Transportation (Bus, Train, Etc) documents is not uploaded yet.
                                        </div>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if($application->type_flight == 'Accommodation') { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="category-block" id="cat-accommodation">
                        <div class="category-title">
                            <span>Accommodation</span>
                            <?php if(!empty($accommodation_attachments)) : ?>
                            <span class="category-badge-count"><?= count($accommodation_attachments)?> Options Submitted</span>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <!-- <th style="width: 160px;">Accommodation Detail</th> -->
                                        <th style="width: 130px;">Price</th>
                                        <th style="width: 150px;">Attachment</th>
                                        <th style="width: 50px;">Preference</th>
                                    </tr>
                                </thead>
                                <tbody class="upload-container" data-application-status="<?= $application->status ?>">
                                    <?php if (!empty($accommodation_attachments)): ?>
                                        <?php foreach($accommodation_attachments as $index => $attachment):
                                            $preview_url = base_url(preg_match('/\.(jpg|jpeg|png)$/i', $attachment->file_path) ? $attachment->file_path : 'assets/images/icons/pdf.svg');
                                            $file_url = base_url($attachment->file_path);
                                            $is_previewable = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $attachment->file_path);
                                            $option_currency = isset($attachment->currency) ? strtoupper(trim($attachment->currency)) : 'USD';
                                            if (!in_array($option_currency, ['IDR', 'USD'], true)) {
                                                $option_currency = 'USD';
                                            }
                                            $option_price_raw = isset($attachment->price) ? $attachment->price : null;
                                            $option_price_normalized = function_exists('unformat_money') ? unformat_money($option_price_raw) : (is_numeric($option_price_raw) ? (float)$option_price_raw : null);
                                            $option_price_text = $option_price_normalized !== null
                                                ? (function_exists('format_money') ? format_money($option_price_normalized, $option_currency) : number_format($option_price_normalized, 2))
                                                : '-';
                                            $option_description = isset($attachment->description) && $attachment->description !== '' ? $attachment->description : '-';
                                        ?>
                                            <tr class="option-row flight-option flight-option-intl <?= $attachment->is_selected ? 'is-selected' : '' ?>" data-attachment-id="<?= $attachment->id ?>" data-ref-type="flight_proposal_accommodation" style="cursor: pointer;">
                                                <!-- <td>
                                                    <?php //html_escape($option_description) ?>
                                                    <input type="checkbox" class="attachment-checkbox" name="accommodation_attachment" value="<?php //$attachment->id ?>" <?php //$attachment->is_selected ? 'checked' : '' ?> style="display: none;">
                                                </td> -->
                                                <td><span class="price-text"><?= html_escape($option_price_text) ?></span></td>
                                                <td>
                                                    <?php 
                                                    $opt_files = function_exists('parse_flight_option_files') ? parse_flight_option_files($attachment) : [];
                                                    if (!empty($opt_files)):
                                                        foreach ($opt_files as $opt_file):
                                                            $opt_f_url = base_url($opt_file['file_path']);
                                                            $opt_f_name = !empty($opt_file['file_name']) ? $opt_file['file_name'] : file_name($opt_f_url);
                                                            $opt_is_prev = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $opt_file['file_path']);
                                                    ?>
                                                        <div style="display:flex; align-items:center; gap:6px; margin-bottom:4px;">
                                                            <a href="<?= $opt_f_url ?>" target="_blank" <?= $opt_is_prev ? 'class="lightbox" aria-haspopup="dialog"' : '' ?> onclick="event.stopPropagation();">
                                                                <?= html_escape($opt_f_name) ?>
                                                            </a>
                                                            <a href="<?= $opt_f_url ?>" target="_blank" class="btn btn-primary btn-xs ml-2" download onclick="event.stopPropagation();">
                                                                <i class="fa fa-download fa-fw"></i>
                                                            </a>
                                                        </div>
                                                    <?php 
                                                        endforeach;
                                                    else: 
                                                    ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="pref-cell unselected"><span class="flight-option-selected-note"><i class="fa fa-check-circle"></i> Selected</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> Accommodation documents is not uploaded yet.
                                        </div>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="tab-pane fade <?= $active_tab == 'flight-reimbursement' ? 'active in' : '' ?>" id="flight-reimbursement">
            <div class="row">
                <div class="col-lg-12">
                    <div class="category-block" id="cat-receipt-ticket">
                        <div class="category-title">
                            <span>Receipt and Ticket</span>
                            <?php if(!empty($receipt_attachments)) : ?>
                            <span class="category-badge-count"><?= count($receipt_attachments)?> Options Submitted</span>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 160px;">Final Price</th>
                                        <th style="width: 130px;">Receipt and Ticket</th>
                                        <th style="width: 50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="upload-container">
                                <?php if (!empty($receipt_attachments)): ?>
                                    <?php foreach($receipt_attachments as $index => $attachment):
                                        $preview_url = base_url(preg_match('/\.(jpg|jpeg|png)$/i', $attachment->file_path) ? $attachment->file_path : 'assets/images/icons/pdf.svg');
                                        $file_url = base_url($attachment->file_path);
                                        $is_previewable = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $attachment->file_path);
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="flight-option-price-text" style="margin-bottom: 10px;">
                                                <?= isset($attachment->price) && $attachment->price !== null ? html_escape(function_exists('format_money') ? format_money($attachment->price, $attachment->currency) : number_format($attachment->price, 2) . ' ' . $attachment->currency) : '-' ?>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?= $file_url ?>" target="_blank" class="lightbox" aria-haspopup="dialog" onclick="event.stopPropagation();">
                                                <?= file_name($attachment->file_path)?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($is_previewable): ?>
                                                <a href="<?= $file_url ?>" target="_blank" class="lightbox btn btn-primary btn-xs m-0" aria-haspopup="dialog" title="Preview file" onclick="event.stopPropagation();">
                                                    <i class="fa fa-eye fa-fw"></i> Preview
                                                </a>
                                                <a href="<?= $file_url ?>" target="_blank" class="btn btn-default btn-xs" download title="Download file" onclick="event.stopPropagation();">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= $file_url ?>" target="_blank" class="btn btn-primary btn-xs" download title="Download file" onclick="event.stopPropagation();">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="tr-empty">
                                        <td colspan="5" style="text-align:center; color:#94a3b8; font-style:italic; padding:20px;">
                                            Grantee is not uploaded receipt and ticket documents yet.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- <h4 style="margin-bottom: 20px;"><strong>Receipt and Ticket</strong></h4>
                    <?php //if (!empty($receipt_attachments)): ?>
                        <div class="upload-container" style="display: flex; flex-wrap: wrap; gap: 20px;">
                            <?php //foreach($receipt_attachments as $index => $attachment):
                                $preview_url = base_url(preg_match('/\.(jpg|jpeg|png)$/i', $attachment->file_path) ? $attachment->file_path : 'assets/images/icons/pdf.svg');
                                $file_url = base_url($attachment->file_path);
                                $is_previewable = preg_match('/\.(jpg|jpeg|png|pdf)$/i', $attachment->file_path);
                            ?>
                            <div class="upload-group" style="padding: 15px; border-radius: 4px; min-width: 150px; border: 2px solid transparent;">
                                <div class="form-group" style="margin: 0;">
                                    <label style="margin-bottom: 10px;"><strong>Receipt and Ticket <?= $index + 1 ?></strong></label>
                                    <div class="flight-option-thumb-wrap" style="margin-bottom:10px; position:relative;">
                                        <img src="<?= $preview_url ?>" class="flight-option-thumb" style="pointer-events: none;">
                                    </div>
                                    <div class="flight-option-price-text" style="margin-bottom: 10px;">
                                        <strong>Final Price:</strong> <?= isset($attachment->price) && $attachment->price !== null ? html_escape(function_exists('format_money') ? format_money($attachment->price, $attachment->currency) : number_format($attachment->price, 2) . ' ' . $attachment->currency) : '-' ?>
                                    </div>
                                    <div style="margin-bottom: 10px;">
                                        <?php //if ($is_previewable): ?>
                                            <a href="<?= $file_url ?>" target="_blank" class="lightbox btn btn-primary btn-xs m-0" aria-haspopup="dialog" title="Preview file" onclick="event.stopPropagation();">
                                                <i class="fa fa-eye fa-fw"></i> Preview
                                            </a>
                                            <a href="<?= $file_url ?>" target="_blank" class="btn btn-default btn-xs" download title="Download file" onclick="event.stopPropagation();">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                        <?php //else: ?>
                                            <a href="<?= $file_url ?>" target="_blank" class="btn btn-primary btn-xs" download title="Download file" onclick="event.stopPropagation();">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                        <?php //endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php //endforeach; ?>
                        </div>
                    <?php //else: ?>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Grantee is not uploaded receipt and ticket documents yet.
                        </div>
                    <?php //endif; ?> -->
                </div>
            </div>
        </div>

        <div class="tab-pane fade <?= $active_tab == 'payment' ? 'active in' : '' ?>" id="payment">
            <div class="row">
                <div class="col-lg-12">
                    <div style="margin-bottom: 20px;">
                        <h4 style="margin-bottom: 20px;"><strong>Payment</strong></h4>
                        <?php if ($application && $application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED): ?>
                            <button type="button" class="btn btn-primary mb-4 pull-right btn-create-payment" data-application-id="<?= $application->id ?>" data-grantee-grant-id="<?= $grantee_grant->id ?>" data-user-id="<?= $grantee_grant->user_grantee_id ?? '' ?>">
                                <i class="fa fa-plus"></i> Create Payment
                            </button>
                        <?php endif; ?>
                    </div>
                    <div style="clear: both;"></div>

                    <?php if (isset($payments) && !empty($payments)): ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Amount (USD)</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($payments as $payment): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($payment->description) ?></td>
                                        <td><?= htmlspecialchars($payment->category) ?></td>
                                        <td>
                                            <span class="label label-<?= $payment->status == 4 ? 'success' : 'info' ?>">
                                                <?= $payment->payment_status ?? 'Pending' ?>
                                            </span>
                                        </td>
                                        <td><?= format_money($payment->total_amount ?? 0, 'USD') ?></td>
                                        <td><?= date('d M Y', strtotime($payment->date_insert)) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-xs btn-info btn-view-payment" data-cat="<?= $payment->category ?>" data-payment-id="<?= $payment->id ?>" data-user-id="<?= $payment->user_grantee_id ?>" data-grantee-grant-id="<?= $payment->grantee_grant_id ?>" title="View Payment Record">
                                                <i class="fa fa-eye"></i> Edit Payment Record
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No payment has been created yet.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade <?= $active_tab == 'activity' ? 'active in' : '' ?>" id="activity">
            <div class="row">
                <div class="col-lg-12">
                    <h4 style="margin-bottom: 30px;"><strong>Activity Timeline</strong></h4>
                    <div class="activity-timeline">
                        <div class="activity-step completed">
                            <div class="activity-step-content">
                                <div class="activity-step-action">Grantee Submit Travel Proposal</div>
                                <div class="activity-step-info">
                                    <span class="activity-step-user">John Doe</span><br>
                                    <span class="activity-step-date">08 Feb 2026, 09:45</span>
                                </div>
                            </div>
                        </div>

                        <div class="activity-step completed">
                            <div class="activity-step-content">
                                <div class="activity-step-action">Admin Approve Travel Proposal</div>
                                <div class="activity-step-info">
                                    <span class="activity-step-user">Admin User</span><br>
                                    <span class="activity-step-date">10 Feb 2026, 10:15</span>
                                </div>
                            </div>
                        </div>

                        <div class="activity-step active">
                            <div class="activity-step-content">
                                <div class="activity-step-action">Grantee Upload Reimbursement</div>
                                <div class="activity-step-info">
                                    <span class="activity-step-user">John Doe</span><br>
                                    <span class="activity-step-date">Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_SUBMITTED): ?>
            <div class="alert alert-secondary" style="margin-bottom:15px;overflow:hidden;">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:15px;flex-wrap:wrap;">
                    <span><strong>Travel proposal has been selected by grantee.</strong> Issue this flight selected.</span>
                    <div style="display:flex;gap:8px;flex-shrink:0;">
                        <button type="button" class="btn btn-success btn-approve" data-id="<?= $application->id ?>">
                            <i class="fa fa-check"></i> Proceed to issue
                        </button>
                        <button type="button" class="btn btn-danger btn-reject" data-id="<?= $application->id ?>">
                            <i class="fa fa-times"></i> Reject
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="flight-option-detail-modal" tabindex="-1" role="dialog" aria-labelledby="flightOptionDetailModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="flightOptionDetailModalLabel">Travel Option Detail</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div style="font-weight: 600; margin-bottom: 4px;">Price</div>
                        <div id="flight-option-detail-price" style="padding:10px 12px; background:#f8fbff; border:1px solid #e5eef6; border-radius:4px;"></div>
                    </div>
                    <div class="form-group">
                        <div style="font-weight: 600; margin-bottom: 4px;">Currency</div>
                        <div id="flight-option-detail-currency" style="padding:10px 12px; background:#f8fbff; border:1px solid #e5eef6; border-radius:4px;"></div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <div style="font-weight: 600; margin-bottom: 4px;">Description</div>
                        <div id="flight-option-detail-description" style="padding:10px 12px; min-height:90px; background:#f8fbff; border:1px solid #e5eef6; border-radius:4px; white-space:pre-wrap;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script>
var receiptAttachmentsData = <?= !empty($all_attachments) ? json_encode(array_map(function($att) {
    return [
        'file_path' => $att->file_path,
        'file_url'  => base_url($att->file_path),
        'file_name' => isset($att->file_name) && !empty($att->file_name) ? $att->file_name : basename($att->file_path),
    ];
}, $all_attachments)) : '[]' ?>;
</script>

<?php $this->load->view('admin/travel_arrangement_non_eta/modal_payment_add'); ?>
<?php $this->load->view('admin/partials/modal_add_subcategory')?>
<?php $this->load->view('admin/partials/modal_add_payment_item')?>

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
