<?php

$active_country = $this->session->userdata('active_country');

$default_content_active = 'active in';

if ($pid) {
    $default_content_active = '';
}

$all_total_payment = 0;
$total_schedule = $total_record = $total_travel = $total_clea = [];
foreach ($grantee_payment as $key => $payment) {
    if ($payment['payment_status'] == RELEASED_PAYMENT) {
        array_push($total_schedule, $payment['total_nominal']);
    }
    
}

foreach ($payment_record as $key => $payment) {
    if ($payment->payment_status == 'Released') {
        array_push($total_record, $payment->total_nominal);
    }
}

foreach ($payment_travel as $key => $travel) {
    if ($travel->payment_status == 'Released') {
        array_push($total_travel, $travel->total_nominal);
    }
}

foreach ($payment_clea as $key => $clea) {
    if ($clea->payment_status == 'Released') {
        array_push($total_clea, $clea->total_nominal);
    }
}

$all_total_schedule = abs(array_sum($total_schedule));
$all_total_record = abs(array_sum($total_record));
$all_total_travel = abs(array_sum($total_travel));
$all_total_clea = abs(array_sum($total_clea));
$all_total_payment = $all_total_schedule;
$all_total_payment_record = $all_total_record;
$all_total_payment_travel = $all_total_travel;
$all_total_payment_clea = $all_total_clea;

// $payment_record = array_filter($payment_record, function($payment_record) {
//     return !isset($payment_record->is_payment_grant);
// });

$payment_record = array_values($payment_record);

// $payment_travel = array_filter($payment_travel, function($payment_travel) {
//     return !isset($payment_travel->is_payment_grant);
// });

$payment_travel = array_values($payment_travel);

// $payment_clea = array_filter($payment_clea, function($payment_clea) {
//     return !isset($payment_clea->is_payment_grant);
// });

$payment_clea = array_values($payment_clea);

$payment_status_map = [];
if (isset($select_status_payment)) {
    foreach ($select_status_payment as $ps) {
        $payment_status_map[$ps->id] = $ps->name;
    }
}

$badge_map = [
    NEW_PAYMENT => 'new',
    NEED_APPROVAL => 'waiting',
    RELEASED_PAYMENT => 'released',
    WAITING_FOR_APPROVAL => 'waiting',
    APPROVE_EXECUTIVE => 'waiting',
    ONHOLD => 'pending',
];

?>

<style>
    #success-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }

    .datepicker {
        background-color: #fff !important;
    }

    .invalid-tooltip {
        position: absolute;
        top: auto;
        z-index: 5;
        display: none;
        max-width: 100%;
        padding: 0.5rem;
        margin-top: 0.1rem;
        font-size: 12px;
        line-height: 1;
        color: #fff;
        background-color: rgba(220, 53, 69, .8);
        border-radius: 0.2rem;
    }
    label {
        font-size: 14px;
        margin-bottom: 5px;
        position: relative;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .payment-attachment > .col-md-12 > .form-group {
        height: 45px;
        border-bottom: 1px solid #ddd;
    }

    .payment-attachment > .col-md-12 > .form-group > .btn-action-remove-uploaded {
        position: absolute;
        right: 15px;
        top: 10px;
    }
    .payment-attachment > .col-md-12 > .form-group > .btn-action-remove-unuploaded {
        position: absolute;
        right: 15px;
        top: 0px;
    }

    .switch {
    position: relative;
    display: inline-block;
    width: 55px;
    height: 20px;
    }

    .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
    }

    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 30px;
    width: 30px;
    left: 0;
    bottom: -5px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    box-shadow: inset 0px 0px 1px rgba(0, 0, 0, 0.5);
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }

    .dropdown-menu-right {
        right: 13px;
        left: auto;
        top: 52px;
    }

    .payment-schedule-list {
        border:1px solid #ddd !important;
    }

    .payment-schedule-list.panel .panel-title .payment-collapse-toggle {
        cursor: pointer;
        color: inherit;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
    }

    .payment-schedule-list.panel > .panel-heading.payment-panel-heading {
        cursor: pointer;
        background-color: #f8fafc;
    }

    .payment-schedule-list.panel .payment-collapse-arrow {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #334155;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 4px 8px;
        line-height: 1;
        cursor: pointer;
        text-decoration: none;
    }

    .payment-schedule-list.panel .payment-collapse-arrow:hover {
        background: #f1f5f9;
    }

    .payment-schedule-list.panel .payment-collapse-arrow .collapse-icon {
        transition: transform .2s ease;
        transform: rotate(0deg);
    }

    .payment-schedule-list.panel .payment-panel-heading.open .payment-collapse-arrow .collapse-icon {
        transform: rotate(180deg);
    }

    .payment-schedule-list.panel .panel-heading .switch {
        vertical-align: middle;
    }

    .payment-schedule-list.panel .accordion-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin-right: 14px;
    }

    .payment-schedule-list.panel .accordion-amount {
        font-size: 13px;
        font-weight: 700;
        color: #0284c7;
        background: #f0f9ff;
        border: 1px solid #e0f2fe;
        padding: 3px 8px;
        border-radius: 4px;
        margin-right: 14px;
    }

    .payment-schedule-list.panel .badge-status {
        padding: 3px 9px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
        margin-right: 14px;
    }

    .payment-schedule-list.panel .badge-status.released { background: #dcfce7; color: #15803d; }
    .payment-schedule-list.panel .badge-status.pending { background: #fef3c7; color: #b45309; }
    .payment-schedule-list.panel .badge-status.waiting { background: #e0f2fe; color: #0369a1; }
    .payment-schedule-list.panel .badge-status.new { background: #f1f5f9; color: #475569; }

    .payment-schedule-list.panel .payment-actions {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .payment-schedule-list.panel .btn-proof-preview {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
    }

    .payment-schedule-list.panel .btn-proof-preview:hover {
        background: #f1f5f9;
    }

    .payment-auto-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background: #f8fafc;
        padding: 10px 14px;
        margin-bottom: 10px;
    }

    .payment-auto-card .payment-auto-card-left {
        display: inline-flex;
        align-items: center;
    }

    .payment-auto-card .payment-auto-card-right {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

</style>

<div class="alert alert-success" id="success-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Autosave <strong>Success! </strong>
</div>

<div class="row">
    <div class="col-lg-12">
        <!-- <a href="<?= base_url() ?>admin/request_payment/print/<?= $this->Grantee_ent_model->id ?>/<?= $grantee_grant->id ?>" target="_blank" class="btn btn-info" style="float:right;margin: 20px 0;">Download PDF</a> -->
        <button type="button" class="btn btn-info dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right;margin: 20px 0;">
            Download PDF
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
                <a href="<?= base_url() ?>admin/request_payment/print/<?= $this->Grantee_ent_model->id ?>/<?= $grantee_grant->id ?>/cost" target="_blank">Download PDF Grant Disbursement</a>
            </li>
            <li>
                <a href="<?= base_url() ?>admin/request_payment/print/<?= $this->Grantee_ent_model->id ?>/<?= $grantee_grant->id ?>/travel" target="_blank">Download PDF International Travel</a>
            </li>
            <li>
                <a href="<?= base_url() ?>admin/request_payment/print/<?= $this->Grantee_ent_model->id ?>/<?= $grantee_grant->id ?>/support" target="_blank">Download PDF Grant Support</a>
            </li>
            <?php if ((bool) $grantee_grant->is_clea){ ?>
            <li>
                <a href="<?= base_url() ?>admin/request_payment/print/<?= $this->Grantee_ent_model->id ?>/<?= $grantee_grant->id ?>/clea" target="_blank">Download PDF CLEA</a>
            </li>
            <?php } ?>
        </ul>
        <h1 class="page-header"><?php echo $title ?></h1> 
    </div>
</div>
<?php
$notif = $this->session->userdata('notif_payment');
if (isset($notif) && $notif != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif ?>
    </div>
<?php }
$this->session->unset_userdata('notif_payment'); ?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>


<form id="frm_manage" method="GET"></form>
<form id="frm_manage_travel" method="GET"></form>
<input type="hidden" value="<?= $this->Grantee_ent_model->id ?>" id="user_id">
<input type="hidden" value="<?= $grantee_grant_id ?>" id="grantee_grant_id">
<input type="hidden" value="<?= $grant_id ?>" id="grant_id">
<input type="hidden" value="<?= $grantee_grant->fiscal_year ?>" id="fiscal_year">
<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <input type="hidden" value="<?= !empty($last_idx->temp_id) ? ($last_idx->temp_id) : 1 ?>" id="last_payment">
            <div class="panel-body"  style="margin-top:-30px">
                <p style="font-weight:bold;margin-bottom:25px;">
                    <i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> GRANT INFORMATION
                </p>
            </div>
            <div class="panel-body" style="margin-top:-50px;">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant</label>
                        <input type="text" disabled="disabled" class="form-control" name="grant" placeholder="Grant" value="<?= $grantee_grant->grant_name ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>Period From</label>
                        <input type="text" disabled="disabled" class="form-control" name="periode_from" placeholder="Period From" value="<?= ($grantee_grant->start_date) ? date('d M Y', strtotime($grantee_grant->start_date)) : '' ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>Period To</label>
                        <input type="text" disabled="disabled" class="form-control" name="periode_to" placeholder="Period To" value="<?= ($grantee_grant->end_date) ? date('d M Y', strtotime($grantee_grant->end_date)) : '' ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>Fiscal Year</label>
                        <input type="text" disabled="disabled" class="form-control" name="fisccal" placeholder="Fiscal Year" value="<?= $grantee_grant->fiscal_year ?>">
                    </div>
                </div>
            </div>
            <div class="panel-body"  style="margin-top:-30px">
                <p style="font-weight:bold;margin-bottom:25px;">
                    <i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET INFORMATION
                    <?php if ($is_current_grantee) : ?>
                        <a target="_blank" href="<?= site_url('admin/grantee/setting/' . $grantee_grant_id); ?>" class="btn btn-primary btn-sm"><span class="fa fa-gear"></span> Edit Budget</a href="<?= site_url('admin/grantee/setting/' . $grantee_grant_id); ?>">
                    <?php endif; ?>
                </p>
            </div>

            <!-- grant cost  -->
            <div class="panel-body" style="margin-top:-50px">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label title="Grant Cost Allocation" data-toggle='tooltip'>Grant Cost Allocation</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="grant_total" class="form-control currency-usd" value="<?= $grantee_grant->total_grant ? ($grantee_grant->total_grant) : 0 ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label title="Actual Grant Cost" data-toggle='tooltip'>Actual Grant Cost</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="grant_total" class="form-control currency-usd" value="<?= $all_total_payment ? ($all_total_payment) : 0 ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label title="Grant Cost Balance" data-toggle='tooltip'>Grant Cost Balance</label>
                        <?php
                        $remaining = abs($grantee_grant->total_grant - $all_total_payment);
                        ?>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="remaining" class="form-control currency-usd" value="<?= $remaining ? ($remaining) : 0 ?>">
                        </div>
                        <input type="hidden" id="all_total_record" name="all_total_record" value="<?= $all_total_record ?>">
                        <input type="hidden" id="all_total_schedule" name="all_total_schedule" value="<?= $all_total_schedule ?>">
                    </div>
                </div>
            </div>

            <!-- international travel  -->
            <div class="panel-body" style="margin-top:-20px">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label title="International Travel Allocation" data-toggle='tooltip'>International Travel Allocation</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="grant_total" class="form-control currency-usd" value="<?= $grantee_grant->international_travel ? ($grantee_grant->international_travel) : 0 ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label title="Actual International Travel" data-toggle='tooltip'>Actual International Travel</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="grant_total" class="form-control currency-usd" value="<?= ($all_total_payment_travel) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label title="International Travel Balance" data-toggle='tooltip'>International Travel Balance</label>
                        <?php
                        $remaining_travel = abs($grantee_grant->international_travel - $all_total_payment_travel);
                        ?>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="remaining" class="form-control currency-usd" value="<?= ($remaining_travel) ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body" style="margin-top:-20px">
                <!-- Grand Total -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="text-primary" title="Total Grant Allocation" data-toggle='tooltip'>Total Grant Allocation</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="total" class="form-control currency-usd" value="<?= ($grantee_grant->total_grant + $grantee_grant->international_travel) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="text-primary" title="Total Actual Grant" data-toggle='tooltip'>Total Actual Grant</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="total_payment" class="form-control currency-usd" value="<?= ($all_total_payment + $all_total_payment_travel) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="text-primary" title="Total Grant Balance" data-toggle='tooltip'>Total Grant Balance</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="total_balance" class="form-control currency-usd" value="<?= ($remaining + $remaining_travel) ?>">
                        </div>
                    </div>
                </div>
            </div>

            

            <!-- clea  -->
            <?php if ((bool) $grantee_grant->is_clea){ ?>
                <!-- separator -->
                <div class="panel-body" style="margin-top:-20px">
                    <div class="col-lg-12">
                        <hr>
                    </div>
                </div>
                <div class="panel-body" style="margin-top:-20px">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label title="Critical Language Enhancement Award Allocation" data-toggle='tooltip'>Critical Language Enhancement Award Allocation</label>
                            <div class="input-group">
                                <div class="input-group-addon">USD</div>
                                <input disabled style="z-index: 0" type="text" name="grant_total" class="form-control currency-usd" value="<?= $grantee_grant->clea ? ($grantee_grant->clea) : 0 ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label title="Actual Critical Language Enhancement Award" data-toggle='tooltip'>Actual Critical Language Enhancement Award</label>
                            <div class="input-group">
                                <div class="input-group-addon">USD</div>
                                <input disabled style="z-index: 0" type="text" name="grant_total" class="form-control currency-usd" value="<?= ($all_total_payment_clea) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label title="Critical Language Enhancement Award Balance" data-toggle='tooltip'>Critical Language Enhancement Award Balance</label>
                            <?php
                                $remaining_clea = abs($grantee_grant->clea - $all_total_payment_clea);
                            ?>
                            <div class="input-group">
                                <div class="input-group-addon">USD</div>
                                <input disabled style="z-index: 0" type="text" name="remaining" class="form-control currency-usd" value="<?= ($remaining_clea) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            

            <!-- separator -->
            <div class="panel-body" style="margin-top:-20px">
                <div class="col-lg-12">
                    <hr>
                </div>
            </div>

            <!-- grant support  -->
            <div class="panel-body" style="margin-top:-20px">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label title="Grant Support Allocation" data-toggle='tooltip'>Grant Support Allocation</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="grant_total" class="form-control <?php echo (bool) $grantee_setting->is_unlimited_grant_support ? '' : 'currency-usd'; ?>" value="<?= (bool) $grantee_setting->is_unlimited_grant_support ? 'To be Proposed' : ($grantee_grant->grant_support); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label title="Actual Grant Support" data-toggle='tooltip'>Actual Grant Support</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="grant_total" class="form-control currency-usd" value="<?= $all_total_record ? ($all_total_record) : 0 ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label title="Grant Support Balance" data-toggle='tooltip'>Grant Support Balance</label>
                        <?php
                        $remaining_support = (bool) $grantee_setting->is_unlimited_grant_support ? 'To be Proposed' : abs($grantee_grant->grant_support - $all_total_payment_record);
                        ?>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="remaining" class="form-control <?php echo is_numeric($remaining_support) ? 'currency-usd' : ''; ?>" value="<?= $remaining_support ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- separator -->
            <div class="panel-body" style="margin-top:-20px">
                <div class="col-lg-12">
                    <hr>
                </div>
            </div>

            <!-- total summary  -->
            <div class="panel-body" style="margin-top:-20px">
                <!-- Grand Total -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="text-primary" title="Total Grant & Grant Support Allocation" data-toggle='tooltip'>Total Grant & Grant Support Allocation</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="total" class="form-control currency-usd" value="<?= ($grantee_grant->total_grant + $grantee_grant->grant_support + $grantee_grant->international_travel + $grantee_grant->clea) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="text-primary" title="Total Actual Grant & Grant Support" data-toggle='tooltip'>Total Actual Grant & Grant Support</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="total_payment" class="form-control currency-usd" value="<?= ($all_total_payment + $all_total_payment_record + $all_total_payment_travel + $all_total_clea) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="text-primary" title="Total Actual Grant & Grant Support" data-toggle='tooltip'>Total Actual Grant & Grant Support</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="total_balance" class="form-control currency-usd" value="<?= ($remaining + (is_numeric($remaining_support) ? $remaining_support : 0) + $remaining_travel + $remaining_clea) ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel-body" style="margin-top:-30px">
                <div class="row">
                    <p class="col-lg-2" style="display: initial;font-weight:bold;margin-bottom:25px;width: auto;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BANK INFORMATION </p>
                    <div style="display: -webkit-box;">
                        <p style="width: 90%;height: 1px;background-color: black;/* display: inline-block; */margin: 35px 10px;/* vertical-align: middle; */">&nbsp;</p>
                        <div style="margin-top: 26px;"><a href="javascript:void(0)" style="text-decoration: none;height: auto;" id="show_hide_bank" value="0"><i class="fa fa-eye"></i> Show</a></div>
                    </div>
                </div>
                <div id="tab_bank" style="display:none">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Beneficiary Name</label>
                            <input type="text" disabled="disabled" class="form-control" name="beneficiary_name" placeholder="Beneficiary Name" value="<?= $this->Grantee_ent_model->beneficiary_name ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Bank Name</label>
                            <input type="text" disabled="disabled" class="form-control" name="bank_name" placeholder="Name of Bank" value="<?= $this->Grantee_ent_model->bank_name ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Branch Office</label>
                            <input type="text" disabled="disabled" class="form-control" name="bank_address" placeholder="Address of Bank" value="<?= $this->Grantee_ent_model->bank_address ?>">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" disabled="disabled" class="form-control" name="account_number" placeholder="Account Number" value="<?= $this->Grantee_ent_model->account_number ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Currency</label>
                            <input type="text" disabled="disabled" class="form-control" name="currency" placeholder="Currency" value="<?= $this->Grantee_ent_model->currency ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Swift Code</label>
                            <input type="text" disabled="disabled" class="form-control" name="swift_code" placeholder="Swift Code" value="<?= $this->Grantee_ent_model->swift_code ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Routing Number</label>
                            <input type="text" disabled="disabled" class="form-control" name="routing_number" placeholder="Routing Number" value="<?= $this->Grantee_ent_model->routing_number ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Account Book</label>
                            <?php if ($this->Grantee_ent_model->account_book != '') { ?>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->account_book ?>" class="lightbox" aria-haspopup="dialog">
                                        <i class="fa fa-eye fa-fw fa-2x"></i>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <div style="margin-bottom:10px; position:relative; width:100px;">-</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills mb-5 pr-4 pl-4">
                <li data-category="Grant Cost" class="li-payment <?= $pid ? '' : 'active' ?>"><a data-toggle="tab" href="#schedule" aria-expanded="true">Grant Disbursement</a></li>
                <li data-category="International Travel" class="li-payment <?= $pid == 'travel' ? 'active' : '' ?>"><a data-toggle="tab" href="#travel" aria-expanded="true">International Travel</a></li>
                <?php if ($grantee_setting->is_clea) { ?>
                    <li data-category="Critical Language Enhancement Award" class="li-payment <?= $pid == 'clea' ? 'active' : '' ?>"><a data-toggle="tab" href="#clea" aria-expanded="true">Critical Language Enhancement Award</a></li>
                <?php } ?>
                <li data-category="Grant Supporting" class="li-payment <?= $pid == 'support' ? 'active' : '' ?>"><a data-toggle="tab" href="#record" aria-expanded="true">Grant Support</a></li>

                <input type="hidden" id="add_sub_cat_tab" value="Grant Cost">
            </ul>
        </div>
        <div class="tab-content">
            <div id="schedule" class="tab-pane fade <?= $default_content_active ?> pr-4 pl-4">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div id="wrap-payment">
                                <?php if ($grantee_payment) {
                                    foreach ($grantee_payment as $key => $row) {
                                        $del_btn = '';
                                        if ($row['payment_status'] == 1 || $row['payment_status'] == 2 || $row['payment_status'] == 5) {
                                            $del_btn = '<a href="javascript:;" data-id="' . $row['id'] . '" onclick="del_item_payment(this, \'payment-item\')" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></a>';
                                        }
                                        $prefix = 'th';
                                        if (($key + 1) == 1) {
                                            $prefix = 'st';
                                        } else if (($key + 1) == 2) {
                                            $prefix = 'nd';
                                        } else if (($key + 1) == 3) {
                                            $prefix = 'rd';
                                        }
                                        $total_amount = isset($row['total_nominal']) ? (float) $row['total_nominal'] : 0;
                                        $badge_class = isset($badge_map[$row['payment_status']]) ? $badge_map[$row['payment_status']] : 'pending';
                                        $status_name = isset($payment_status_map[$row['payment_status']]) ? $payment_status_map[$row['payment_status']] : '';
                                ?>
                                        <div id="payment-item-<?= $key ?>'" class="payment-item payment-schedule-list panel panel-default">
                                            <div class="panel-heading payment-panel-heading">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <span class="payment-collapse-toggle pull-left">
                                                            <span class="accordion-title"><?= $key + 1 ?><?= $prefix ?> Disbursement</span>
                                                            <span class="accordion-amount">$<?= number_format(abs($total_amount), 2) ?></span>
                                                            <?php if ($status_name) { ?>
                                                                <span class="badge-status <?= $badge_class ?>"><?= $status_name ?></span>
                                                            <?php } ?>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="payment-actions pull-right">
                                                            <?php if (!empty($row['proof'])) { ?>
                                                                <a href="<?php echo base_url() . $row['proof'] ?>" class="btn btn-default btn-xs btn-proof-preview lightbox" title="View Proof of Transfer"><i class="fa fa-eye"></i> View Proof</a>
                                                            <?php } else { ?>
                                                                <a href="javascript:void(0);" onclick="return false;" class="btn btn-default btn-xs btn-proof-preview disabled" title="No Proof of Transfer"><i class="fa fa-eye"></i> No Proof</a>
                                                            <?php } ?>
                                                            <span class="payment-collapse-arrow" title="Expand / Collapse">
                                                                <i class="fa fa-chevron-down collapse-icon"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapse-payment-<?= $key ?>" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="col-md-12">
                                                        <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="payment-auto-card">
                                                            <span class="payment-auto-card-left">
                                                                <label style="margin:0 10px 0 0;">Auto Disbursement?</label>
                                                                <label class="switch" style="margin:0;">
                                                                    <input data-index="<?= $key ?>" data-id="<?= $row['id'] ?>" onchange="toggleAutoNotification(this)" type="checkbox" id="auto_notification" class="auto_notification" name="payment[<?= $key ?>][auto_notification]" <?= $row['auto_notification'] ? 'checked' : '' ?>>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </span>
                                                            <span class="payment-auto-card-right">
                                                                <a class="btn btn-default btn-xs fw-bold" onclick="copy_payment(this, 'payment-schedule-list'); return false;"><i class="fa fa-copy"></i> Copy Payment</a>
                                                                <?= $del_btn ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="payment[<?= $key ?>][payment_name]" value="<?= $row['payment_name'] ?>">
                                                    <input type="hidden" name="payment[<?= $key ?>][order]" value="<?= $row['order_payment'] ?>">
                                                    <input type="hidden" name="payment[<?= $key ?>][temp_id]" value="<?= $row['temp_id'] ?>">
                                                    <input type="hidden" id="delete_temp_<?= $key ?>" name="payment[<?= $key ?>][delete_detail_temp_id]">
                                                    <?php if ($row['id']) { ?>
                                                        <input type="hidden" name="payment[<?= $key ?>][payment_id]" value="<?= $row['id'] ?>">
                                                    <?php } ?>
                                                </div>
                                                <div class="panel-body" style="margin-top:-30px">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Pay Period Starts <span style="color:red; font-size: 12pt;">*</span></label>
                                                        <input onchange="remove_error('validation-error-date-periode');" autocomplete="new-password" readonly <?php // $row['payment_status'] == 3 || $row['payment_status'] == 4  ? 'disabled' : '' 
                                                                                                                                                                ?> type="text" class="date-periode form-control datepicker" data-payment_index="<?php echo $key; ?>" name="payment[<?= $key ?>][from_date]" placeholder="Pay Period Starts" value="<?php echo ($row['from_date']) ? date('d M Y', strtotime($row['from_date'])) : '' ?>" required>
                                                        <div class="text-danger invalid-tooltip validation-error-date-periode hide" style="display: block;">Pay Period Starts is Required</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Coverage</label>
                                                        <select class="form-control coverage-select" name="payment[<?= $key ?>][coverage_month]">
                                                            <option value="">-- Select Coverage --</option>
                                                            <?php $cov_selected = isset($row['coverage_month']) ? (int) $row['coverage_month'] : 0; ?>
                                                            <?php for ($c = 1; $c <= 12; $c++) { ?>
                                                                <option value="<?= $c ?>" <?= $cov_selected === $c ? 'selected' : '' ?>><?= $c ?> Month<?= $c > 1 ? 's' : '' ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Pay Period Ends <span style="color:red; font-size: 12pt;">*</span></label>
                                                        <input onchange="remove_error('validation-error-to');" autocomplete="new-password" readonly type="text" <?php // $row['payment_status'] == 3 || $row['payment_status'] == 4 ? 'disabled' : '' 
                                                                                                                                                                 ?> class="to form-control datepicker" name="payment[<?= $key ?>][to_date]" placeholder="To" value="<?php echo ($row['to_date']) ? date('d M Y', strtotime($row['to_date'])) : '' ?>">
                                                        <div class="text-danger invalid-tooltip validation-error-to hide" style="display: block;">To is Required</div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-lg-4 notification_section_<?= $key ?> <?= $row['auto_notification'] ? '' : 'hide' ?>">
                                                    <div class="form-group">
                                                        <label>Notification Date <span style="color:red; font-size: 12pt;">*</span></label>
                                                        <input onchange="remove_error('validation-error-notification-date');" autocomplete="new-password" type="text" class="notification-date form-control datepicker notification-date-<?php echo $key; ?>" name="payment[<?= $key ?>][notify_date]" placeholder="Notification Date" value="<?php echo ($row['notify_date']) ? date('d M Y', strtotime($row['notify_date'])) : '' ?>">
                                                        <div class="text-danger invalid-tooltip validation-error-notification-date hide" style="display: block;">Notification Date is Required</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 reminder_section_<?= $key ?> <?= $row['auto_notification'] ? 'hide' : '' ?>">
                                                    <div class="form-group">
                                                        <label>Reminder Date <span style="color:red; font-size: 12pt;">*</span></label>
                                                        <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="Reminder email will be sent day -1 from reminder date">i</span>
                                                        <input onchange="remove_error('validation-error-reminder-date');" autocomplete="new-password" type="text" <?php // $row['payment_status'] == 3 || $row['payment_status'] == 4 ? 'disabled' : '' 
                                                                                                                                                                    ?> class="reminder-date form-control datepicker reminder-date-<?php echo $key; ?>" name="payment[<?= $key ?>][toberelease_date]" placeholder="Reminder Date" value="<?php echo ($row['toberelease_date']) ? date('d M Y', strtotime($row['toberelease_date'])) : '' ?>">
                                                        <div class="text-danger invalid-tooltip validation-error-reminder-date hide" style="display: block;">Reminder Date is Required</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>To be released on</label>
                                                        <input type="text" class="form-control datepicker tobe-released-on deadline-date-<?php echo $key; ?>" name="payment[<?php echo $key; ?>][deadline_date]" placeholder="To be released on" value="<?php echo ($row['deadline_date']) ? date('d M Y', strtotime($row['deadline_date'])) : '' ?>">
                                                    </div>
                                                </div>
                                                <?php if (!is_null($memo_budget)) {  ?>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Memo Budget</label>
                                                            <select class="form-control memo-budget" name="payment[<?php echo $key; ?>][user_grantee_grant_memo_id]">
                                                                <option value="1">Select Memo Budget</option>
                                                                <?php foreach ($memo_budget as $memo) { ?>
                                                                    <option <?= $memo->is_active == 'Yes' ? '' : 'class="memo-budget-inactive" disabled' ?> value="<?php echo $memo->id; ?>" data-is-active="<?= $memo->is_active ?>" <?php echo isset($row['user_grantee_grant_memo_id']) && $row['user_grantee_grant_memo_id'] == $memo->id ? 'selected' : ''; ?>><?php echo $memo->file_name; ?><?= $memo->is_active == 'Yes' ? '' : ' (Inactive)' ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Bank</label>
                                                        <select class="form-control bank" name="payment[<?php echo $key; ?>][bank_info_id]">
                                                            <option value="">Select Bank Account</option>
                                                            <?php foreach ($bank_info as $bank) { ?>
                                                                <option value="<?php echo $bank->id; ?>" <?php echo $row['bank_info_id'] != null && $row['bank_info_id'] == $bank->id ? 'selected' : ''; ?>><?php echo $bank->bank_name . ' (' . $bank->currency . ')' . ' - ' . $bank->account_number; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Priority</label>
                                                        <select class="form-control priority" name="payment[<?php echo $key; ?>][priority]">
                                                            <option value="">Select Priority</option>
                                                            <option value="1" <?php echo $row['priority'] == 1 ? 'selected' : ''; ?>>Normal</option>
                                                            <option value="2" <?php echo $row['priority'] == 2 ? 'selected' : ''; ?>>Urgent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Payment Status <span style="color:red; font-size: 12pt;">*</span></label>
                                                        <select <?php // $row['payment_status'] == 3 || $row['payment_status'] == 4 ? 'disabled' : '' 
                                                                ?> <?= is_admin() ? '' : '' ?> class="payment-status form-control" name="payment[<?= $key ?>][payment_status]" id="payment_status_<?= $key ?>">
                                                            <option value="">-- Select Payment Status --</option>
                                                            <?php
                                                            if ($select_status_payment) {
                                                                foreach ($select_status_payment as $ps) {
                                                                    $selected = '';
                                                                    if ($row['payment_status'] == $ps->id) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                            ?>
                                                                    <option value="<?= $ps->id ?>" <?= $selected ?>><?= $ps->name ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger invalid-tooltip validation-error-payment-status hide" style="display: block;">Payment Status is Required</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body" style="margin-top:-30px">
                                                <!-- <div class="col-lg-4">
                                                    <div class="custom-file">
                                                        <label class="custom-file-label">Proof of Expense</label>
                                                        <?php 
                                                            $hide_upload_expense = 'hide';
                                                            // if (has_permission('payment_record', 'upload_proof_of_expense')) {
                                                            //     $hide_upload_expense = '';
                                                            // }
                                                        ?>

                                                        <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_expense; ?>" type="button" onclick="remove_file(this, 'expense', <?= $row['id'] ?>); return false;"><i class="fa fa-times"></i></button>
                                                        <input type="file" class="<?php echo $hide_upload_expense; ?>" id="proof" name="proof_expense|<?= $row['id'] ?>">
                                                        <?php if ($row['proof_expense'] != '') { ?>
                                                            <div style="margin-bottom:10px; position:relative; width:100px;" class="expense-file">
                                                                <a href="<?php echo base_url() ?><?php echo $row['proof_expense'] ?>" class="lightbox"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div style="margin-bottom:10px; position:relative;" class="expense-no-file">
                                                                <a onclick="return false;" class="lightbox"><label class="label label-default" disabled>Not Uploaded yet</label></a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="panel-body" style="margin-top:-30px">
                                                <div class="row" style="margin: 0px">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Total Nominal Item</label>
                                                            <input type="text" class="form-control currency-usd" placeholder="Total Payment Item" value="<?= $row['total_nominal'] ?>">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <div class="form-check">    
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input notify-grantee" type="checkbox" name="payment[<?= $key ?>][notify_grantee]" value="1" <?php echo (bool) $row['notify_grantee'] ? 'checked' : ''; ?>> Notify Grantee upon Released
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-lg-4 mt-2" style="padding-top:24px;">
                                                        <input style="display:block" data-type="schedule" data-log="<?= $row['id'] ?>" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn btn-default payment-log" value="Open Log">
                                                    </div>       
                                                </div>

                                                <div class="row" style="margin: 0px">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>To be Released Note</label>
                                                            <textarea <?php // $row['payment_status'] == 3 || $row['payment_status'] == 4 ? 'disabled' : '' 
                                                                        ?> class="form-control tobe-release-note" rows="2" name="payment[<?= $key ?>][release_note]" placeholder="Note to finance or release details..."><?= $row['release_note'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin:0px;">
                                                    <div class="col-lg-4 hide">
                                                        <div class="form-group">
                                                            <div class="custom-file">
                                                                <label class="custom-file-label">Proof of Conversion</label>
                                                                <?php 
                                                                    $hide_upload_conversion = 'hide';
                                                                    if (has_permission('payment_record', 'upload_proof_of_conversion')) {
                                                                        $hide_upload_conversion = '';
                                                                    }
                                                                ?>
                                                                <input type="file" class="<?php echo $hide_upload_conversion; ?>" id="proof_of_conversion" name="proof_of_conversion|<?= $row['id'] ?>" onchange="update_to_release_payment(<?= $key ?>)">
                                                                <?php if ($row['proof_of_conversion'] != '') { ?>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                        <a href="<?php echo base_url() ?><?php echo $row['proof_of_conversion'] ?>" class="lightbox"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div style="margin-bottom:10px; position:relative;">
                                                                        <a onclick="return false;" class="lightbox"><label class="label label-default" disabled>Not Uploaded yet</label></a>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel-body" style="margin-top:-30px">
                                                <div class="col-lg-12">
                                                <p style="font-weight:bold;margin-bottom:20px;">PAYMENT ITEMS</p>
                                                <div class="table-responsive">
                                                <table class="table table-bordered payment-items-table" style="margin-bottom:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Payment Sub Category <span style="color:red; font-size: 12pt;">*</span></th>
                                                            <th>Payment Item <span style="color:red; font-size: 12pt;">*</span></th>
                                                            <th>Nominal IDR</th>
                                                            <th>Nominal USD</th>
                                                            <th style="width:60px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                <?php
                                                    $subtotal_idr = 0;
                                                    $subtotal_usd = 0;
                                                    if (!empty($row['items'])) {
                                                        foreach ($row['items'] as $item_val) {
                                                            $raw_idr = isset($item_val['nominal_idr']) ? $item_val['nominal_idr'] : 0;
                                                            $clean_idr = preg_replace('/[^\d.,-]/', '', (string)$raw_idr);
                                                            if ($clean_idr !== '') {
                                                                if (strpos($clean_idr, ',') !== false) {
                                                                    $clean_idr = str_replace('.', '', $clean_idr);
                                                                    $clean_idr = str_replace(',', '.', $clean_idr);
                                                                } elseif (preg_match('/^\d+\.\d{1,2}$/', $clean_idr)) {
                                                                    // Raw DB float
                                                                } else {
                                                                    $clean_idr = str_replace('.', '', $clean_idr);
                                                                }
                                                                $subtotal_idr += (float)$clean_idr;
                                                            }

                                                            $raw_usd = isset($item_val['nominal']) ? $item_val['nominal'] : 0;
                                                            $clean_usd = preg_replace('/[^\d.,-]/', '', (string)$raw_usd);
                                                            if ($clean_usd !== '') {
                                                                $clean_usd = str_replace(',', '', $clean_usd);
                                                                $subtotal_usd += (float)$clean_usd;
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <tbody id="wrap-request<?= $key ?>">
                                                    <?php if ($row['items']) {
                                                        foreach ($row['items'] as $num => $value) {
                                                            $btn_del = '';
                                                            // if ($num > 0 && $row['payment_status'] == 1 || $row['payment_status'] == 2 || $row['payment_status'] == 5) {
                                                                $btn_del = '<a href="javascript:;" temp_id="' . $value['temp_id'] . '" id="' . $value['id'] . '" onclick="del_item(this, \'request-item' . $key . '\', ' . $key . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></a>';
                                                            // }
                                                    ?>

                                                            <tr id="request-item-<?= $num ?>" class="request-item<?= $key ?> payment-item-section">
                                                                    <td>
                                                                            <?php // if ($row['payment_status'] == 1 || $row['payment_status'] == 2 || $row['payment_status'] == 5 || $row['payment_status'] == 0) {  
                                                                            ?>
                                                                            <select id="sub_category_<?= $key ?><?= $num ?>" onchange="select_payment_item('<?= $key ?><?= $num ?>')" class="payment-sub-category form-control select2" style="width:100%" name="payment[<?= $key ?>][items][<?= $num ?>][sub_category]">
                                                                                <option value="">-- Select Payment Sub Category --</option>
                                                                                <?php foreach ($payment_sub_cost as $kpsc => $psc) {
                                                                                    $selected = '';
                                                                                    if ($value['payment_sub_category_id'] == $psc->id) {
                                                                                        $selected = 'selected="selected"';
                                                                                    }
                                                                                ?>
                                                                                    <option value="<?= $psc->id ?>" <?= $selected ?>><?= $psc->name ?></option>
                                                                                <?php } ?>
                                                                                <option value="__add_new__" data-type="sub_category" data-category="payment_category_support" title="sub" data-subcategory="sub_category_0"> <span class="glyphicon glyphicon-plus"></span> Add Sub Category</option>
                                                                            </select>
                                                                            <div class="text-danger invalid-tooltip validation-error-payment-sub-category hide" style="display: block;">Payment Sub Category is Required</div>
                                                                            <?php // } else { 
                                                                            ?>
                                                                            <!-- <input type="text" class="form-control" value="<?= $value['sub_category_name'] ?>">
                                                                                    <input type="hidden" class="form-control" name="payment[<?= $key ?>][items][<?= $num ?>][sub_category]" value="<?= $value['item_name'] ?>"> -->
                                                                            <?php // } 
                                                                            ?>
                                                                    </td>
                                                                    <td>
                                                                            <?php //if ($row['payment_status'] == 1 || $row['payment_status'] == 2 || $row['payment_status'] == 5 || $row['payment_status'] == 0) {  
                                                                            ?>
                                                                            <input type="hidden" name="payment[<?= $key ?>][items][<?= $num ?>][temp_id]" value="<?= $value['temp_id'] ?>">
                                                                            <select id="payment_item_<?= $key ?><?= $num ?>" class="payment-item-list form-control select2" style="width:100%" name="payment[<?= $key ?>][items][<?= $num ?>][item]">
                                                                                <option value="">-- Select Item --</option>
                                                                                <?php
                                                                                if ($payment_item) {
                                                                                    foreach ($payment_item[$value['payment_sub_category_id']] as $kpi => $pi) {
                                                                                        $selected = '';
                                                                                        if ($value['item_name'] == $pi->id) {
                                                                                            $selected = 'selected="selected"';
                                                                                        }
                                                                                ?>
                                                                                        <option value="<?= $pi->id ?>" <?= $selected ?>><?= $pi->payment_item ?></option>
                                                                                <?php
                                                                                    }
                                                                                } ?>
                                                                            </select>
                                                                            <div class="text-danger invalid-tooltip validation-error-payment-item-list hide" style="display: block;">Payment Item is Required</div>
                                                                            <!-- <?php // } else { 
                                                                                    ?>
                                                                                    <input type="hidden" name="payment[<?= $key ?>][items][<?= $num ?>][temp_id]" value="<?= $value['temp_id'] ?>">
                                                                                    <input type="text" class="form-control" value="<?= $value['payment_item'] ?>">
                                                                                    <input type="hidden" class="form-control" name="payment[<?= $key ?>][items][<?= $num ?>][item]" value="<?= $value['item_name'] ?>">

                                                                                <?php // } 
                                                                                ?> -->

                                                                            <?php if ($value['id']) { ?>
                                                                                <input type="hidden" name="payment[<?= $key ?>][items][<?= $num ?>][detail_payment_id]" value="<?= $value['id'] ?>">
                                                                            <?php } ?>
                                                                    </td>
                                                                    <td>
                                                                            <input type="text" <?php // ($row['payment_status'] == 3) ? 'readonly' : '' 
                                                                                                                    ?> class="currency-idr payment-item-nominal_idr form-control" name="payment[<?= $key ?>][items][<?= $num ?>][nominal_idr]" value="<?= $value['nominal_idr'] ?>">
                                                                            <div class="text-danger invalid-tooltip validation-error-payment-nominal_idr hide" style="display: block;">Nominal is Required</div>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                            <input type="text" <?php // ($row['payment_status'] == 3) ? 'readonly' : '' 
                                                                                                                    ?> class="currency-usd payment-item-nominal form-control" name="payment[<?= $key ?>][items][<?= $num ?>][nominal]" value="<?= $value['nominal'] ?>">
                                                                            <div class="text-danger invalid-tooltip validation-error-payment-nominal hide" style="display: block;">Nominal is Required</div>
                                                                    </td>
                                                                    <!-- <td>
                                                                    <div class="form-group">
                                                                        <label>images</label>
                                                                        <input type="file" class="form-control" name="payment[0][items][0][file]">
                                                                    </div>
                                                                </td> -->
                                                                    <td style="text-align:center;vertical-align:top;">
                                                                                <?= $btn_del ?>
                                                                    </td>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="payment-items-subtotal-row" style="background-color: #f9f9f9; font-weight: bold;">
                                                        <td colspan="2" class="text-right" style="vertical-align: middle; font-weight: bold; background-color: #f9f9f9;">Sub Total:</td>
                                                        <td class="subtotal-idr" style="vertical-align: middle; font-weight: bold; background-color: #f9f9f9; color: #0f172a;"><?= 'Rp ' . number_format($subtotal_idr, 2, ',', '.') ?></td>
                                                        <td class="subtotal-usd" style="vertical-align: middle; font-weight: bold; background-color: #f9f9f9; color: #0f172a;"><?= '$' . number_format($subtotal_usd, 2, '.', ',') ?></td>
                                                        <td style="background-color: #f9f9f9;"></td>
                                                    </tr>
                                                </tfoot>
                                                </table>
                                                </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group" style="margin-bottom:0">
                                                        <?php //if ($row['payment_status'] != 3) { 
                                                        ?>
                                                        <a href="javascript:;" onclick="add_item(<?= $key ?>)" class="btn btn-primary btn-add-item"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                                                        <?php //} 
                                                        ?>
                                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="custom-file">
                                                        <label class="custom-file-label">Proof of Transfer</label>
                                                        <?php 
                                                            $hide_upload_transfer = 'hide';
                                                            if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                                                                $hide_upload_transfer = '';
                                                            }
                                                        ?>
                                                        
                                                        <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this, 'transfer', <?php echo $row['id']; ?>); return false;"><i class="fa fa-times"></i></button>
                                                        <input type="file" class="<?php echo $hide_upload_transfer; ?>" id="proof" name="proof|<?= $row['id'] ?>" onchange="update_to_release_payment(<?= $key ?>)">
                                                        <?php if ($row['proof'] != '') { ?>
                                                            <div style="margin-bottom:10px; position:relative; width:100px;" class="transfer-file">
                                                                <a href="<?php echo base_url() ?><?php echo $row['proof'] ?>" class="lightbox"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div style="margin-bottom:10px; position:relative;" class="transfer-no-file">
                                                                <a onclick="return false;" class="lightbox"><label class="label label-default" disabled>Not Uploaded yet</label></a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Released Date</label>
                                                        <input autocomplete="new-password" readonly type="text" <?php // $row['payment_status'] == 3 || $row['payment_status'] == 4 ? 'disabled' : '' 
                                                                                                                ?> <?= is_admin() ? '' : '' ?> class="form-control release-date datepicker" name="payment[<?= $key ?>][release_date]" placeholder="Release Date" value="<?php echo ($row['release_date']) ? date('d M Y', strtotime($row['release_date'])) : '' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div id="payment-item-0'" class="payment-item payment-schedule-list panel panel-default">
                                        <div class="panel-heading payment-panel-heading">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <span class="payment-collapse-toggle pull-left">
                                                        <span class="accordion-title">1st Disbursement</span>
                                                        <span class="accordion-amount">$0.00</span>
                                                    </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="payment-actions pull-right">
                                                        <a href="javascript:void(0);" onclick="return false;" class="btn btn-default btn-xs btn-proof-preview disabled" title="No Proof of Transfer"><i class="fa fa-eye"></i> No Proof</a>
                                                        <span class="payment-collapse-arrow" title="Expand / Collapse">
                                                            <i class="fa fa-chevron-down collapse-icon"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse-payment-0" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="payment-auto-card">
                                                        <span class="payment-auto-card-left">
                                                            <label style="margin:0 10px 0 0;">Auto Disbursement?</label>
                                                            <label class="switch" style="margin:0;">
                                                                <input data-index="0" onchange="toggleAutoNotification(this)" type="checkbox" id="auto_notification" class="auto_notification" name="payment[0][auto_notification]">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </span>
                                                        <a class="btn btn-default btn-xs fw-bold" onclick="copy_payment(this, 'payment-schedule-list'); return false;"><i class="fa fa-copy"></i> Copy Payment</a>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="payment[0][payment_name]" value="1st Disbursement">
                                                <input type="hidden" name="payment[0][order]" value="1">
                                                <input type="hidden" name="payment[0][temp_id]" value="1">
                                                <input type="hidden" id="delete_temp_0" name="payment[0][delete_detail_temp_id]">
                                            </div>
                                            <div class="panel-body" style="margin-top:-30px">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Pay Period Starts <span style="color:red; font-size: 12pt;">*</span></label>
                                                    <input onchange="remove_error('validation-error-date-periode');" autocomplete="new-password" readonly type="text" class="date-periode form-control datepicker" data-payment_index="0" name="payment[0][from_date]" placeholder="Pay Period Starts" value="<?php echo ($this->Grantee_ent_model->from_date) ? date('d M Y', strtotime($this->Grantee_ent_model->from_date)) : '' ?>" required>
                                                    <div class="text-danger invalid-tooltip validation-error-date-periode hide" style="display: block;">Pay Period Starts is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Coverage</label>
                                                    <select class="form-control coverage-select" name="payment[0][coverage_month]">
                                                        <option value="">-- Custom / Flexible --</option>
                                                        <?php for ($c = 1; $c <= 12; $c++) { ?>
                                                            <option value="<?= $c ?>"><?= $c ?> Month<?= $c > 1 ? 's' : '' ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Pay Period Ends <span style="color:red; font-size: 12pt;">*</span></label>
                                                    <input onchange="remove_error('validation-error-to');" autocomplete="new-password" readonly type="text" class="to form-control datepicker" name="payment[0][to_date]" placeholder="To" value="<?php echo ($this->Grantee_ent_model->to_date) ? date('d M Y', strtotime($this->Grantee_ent_model->to_date)) : '' ?>">
                                                    <div class="text-danger invalid-tooltip validation-error-to hide" style="display: block;">To is Required</div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Reminder Date <span style="color:red; font-size: 12pt;">*</span></label>
                                                    <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="Reminder email will be sent day -1 from reminder date">i</span>
                                                    <input onchange="remove_error('validation-error-reminder-date');" autocomplete="new-password" readonly type="text" class="reminder-date form-control datepicker reminder-date-0" name="payment[0][toberelease_date]" placeholder="Reminder Date" value="<?php echo ($row['release_date']) ? date('d M Y', strtotime($row['release_date'])) : '' ?>">
                                                    <div class="text-danger invalid-tooltip validation-error-reminder-date hide" style="display: block;">Reminder Date is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>To be released on</label>
                                                    <input type="text" class="form-control datepicker deadline-date-0" name="payment[0][deadline_date]" placeholder="To be released on">
                                                </div>
                                            </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Memo Budget</label>
                                                        <select class="form-control" name="payment[0][user_grantee_grant_memo_id]">
                                                            <option value="1">Select Memo Budget</option>
                                                            <?php foreach ($memo_budget as $memo) { ?>
                                                                <?php if ($memo->is_active == 'Yes') { ?>
                                                                <option value="<?php echo $memo->id; ?>"><?php echo $memo->file_name; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="clearfix"></div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Bank</label>
                                                        <select class="form-control" name="payment[0][bank_info_id]">
                                                            <option value="">Select Bank Account</option>
                                                            <?php foreach ($bank_info as $bank) { ?>
                                                                <option value="<?php echo $bank->id; ?>" <?php echo $bank->id == 0 ? 'selected' : ''; ?>><?php echo $bank->bank_name . ' (' . $bank->currency . ')' . ' - ' . $bank->account_number; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Priority</label>
                                                        <select class="form-control" name="payment[0][priority]">
                                                            <option value="">Select Priority</option>
                                                            <option value="1">Normal</option>
                                                            <option value="2">Urgent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Payment Status <span style="color:red; font-size: 12pt;">*</span></label>
                                                        <select class="form-control" name="payment[0][payment_status]">
                                                            <?php
                                                            if ($select_status_payment) {
                                                                foreach ($select_status_payment as $ps) {
                                                            ?>
                                                                    <option value="<?= $ps->id ?>"><?= $ps->name ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger invalid-tooltip validation-error-payment-status hide" style="display: block;">Payment Status is Required</div>
                                                    </div>
                                                </div>
                                            <div class="clearfix"></div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>To be Released Note</label>
                                                        <textarea class="form-control" rows="2" name="payment[0][release_note]" placeholder="Note to finance or release details..."><?= $row['release_note'] ?></textarea>
                                                    </div>
                                                </div>
                                            <!-- <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Release Type</label>
                                                        <select class="form-control" name="payment[0][method]">
                                                            <option value="">-- Select Release Type --</option>
                                                            <option value="Manual">Manual</option>
                                                            <option value="MRI">Automatic</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                        </div>
                                        <div class="panel-body" style="margin-top:-30px">
                                            <!-- <div class="col-lg-4">
                                                <div class="custom-file">
                                                    <label class="custom-file-label">Proof of Expense</label>
                                                    <?php 
                                                        $hide_upload_expense = 'hide';
                                                        // if (has_permission('payment_record', 'upload_proof_of_expense')) {
                                                        //     $hide_upload_expense = '';
                                                        // }
                                                    ?>
                                                    <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_expense; ?>" type="button" onclick="remove_file(this, 'expense', 0); return false;"><i class="fa fa-times"></i></button>
                                                    <input type="file" class="<?php echo $hide_upload_expense; ?>" id="proof" name="payment[0][proof_of_expense]">
                                                    <div style="margin-bottom:10px; position:relative;">
                                                        <a onclick="return false;" class="lightbox"><label class="label label-default" disabled>Not Uploaded yet</label></a>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <div class="form-check">    
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" name="payment[0][notify_grantee]" value="1"> Notify Grantee upon Released
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="panel-body" style="margin-top:-30px">
                                            
                                            <!-- <div class="row hide" style="margin:0px;">
                                                    <div class="col-lg-4 hide">
                                                        <div class="form-group">
                                                            <div class="custom-file">
                                                                <label class="custom-file-label">Proof of Conversion</label>
                                                                <?php 
                                                                    $hide_upload_expense = 'hide';
                                                                    // if (has_permission('payment_record', 'upload_proof_of_expense')) {
                                                                    //     $hide_upload_expense = '';
                                                                    // }
                                                                ?>
                                                                <input type="file" class="<?php echo $hide_upload_conversion; ?>" id="proof_of_conversion" name="payment[0][proof_of_conversion]">
                                                                <div style="margin-bottom:10px; position:relative;">
                                                                    <a onclick="return false;" class="lightbox"><label class="label label-default" disabled>Not Uploaded yet</label></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                        </div>
                                        <div class="panel-body" style="margin-top:-30px">
                                            <div class="col-lg-12">
                                            <p style="font-weight:bold;margin-bottom:20px;">PAYMENT ITEMS</p>
                                            <div class="table-responsive">
                                            <table class="table table-bordered payment-items-table" style="margin-bottom:10px;">
                                                <thead>
                                                    <tr>
                                                        <th>Payment Sub Category <span style="color:red; font-size: 12pt;">*</span></th>
                                                        <th>Payment Item <span style="color:red; font-size: 12pt;">*</span></th>
                                                        <th>Nominal IDR</th>
                                                        <th>Nominal USD</th>
                                                        <th style="width:60px;">Action</th>
                                                    </tr>
                                                </thead>
                                            <tbody id="wrap-request0">
                                                <tr id="request-item-0" class="request-item0 payment-item-section">
                                                    <td>
                                                            <select id="sub_category_0" onchange="select_payment_item('0')" class="payment-sub-category form-control select2" style="width:100%" name="payment[0][items][0][sub_category]">
                                                                <option value="">-- Select Payment Sub Category --</option>
                                                                <?php foreach ($payment_sub_cost as $kpsc => $psc) {
                                                                    $selected = '';
                                                                    if ($value['payment_sub_category_id'] == $psc->id) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                ?>
                                                                    <option value="<?= $psc->id ?>" <?= $selected ?>><?= $psc->name ?></option>
                                                                <?php } ?>
                                                                <option value="__add_new__" data-type="sub_category" data-category="payment_category_support" title="sub" data-subcategory="sub_category_0"> <span class="glyphicon glyphicon-plus"></span> Add Sub Category</option>
                                                            </select>
                                                            <div class="text-danger invalid-tooltip validation-error-payment-sub-category hide" style="display: block;">Payment Sub Category is Required</div>
                                                    </td>
                                                    <td>
                                                            <input type="hidden" name="payment[0][items][0][temp_id]" value="1">
                                                            <select onchange="remove_error('validation-error-payment-item-list');" id="payment_item_0" class="payment-item-list form-control select2" style="width:100%" name="payment[0][items][0][item]">
                                                                <option value="">-- Select Item --</option>
                                                            </select>
                                                            <div class="text-danger invalid-tooltip validation-error-payment-item-list hide" style="display: block;">Payment Item is Required</div>
                                                    </td>
                                                    <td>
                                                            <input onchange="remove_error('validation-error-payment-nominal-idr');" type="text" class="currency-idr payment-item-nominal-idr form-control" name="payment[0][items][0][nominal_idr]">
                                                            <div class="text-danger invalid-tooltip validation-error-payment-nominal-idr hide" style="display: block;">Nominal IDR is Required</div>
                                                    </td>
                                                    <td>
                                                            <input onchange="remove_error('validation-error-payment-nominal');" type="text" class="currency-usd payment-item-nominal form-control" name="payment[0][items][0][nominal]">
                                                            <div class="text-danger invalid-tooltip validation-error-payment-nominal hide" style="display: block;">Nominal USD is Required</div>
                                                    </td>
                                                    <td style="text-align:center;vertical-align:top;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="payment-items-subtotal-row" style="background-color: #f9f9f9; font-weight: bold;">
                                                    <td colspan="2" class="text-right" style="vertical-align: middle; font-weight: bold; background-color: #f9f9f9;">Sub Total:</td>
                                                    <td class="subtotal-idr" style="vertical-align: middle; font-weight: bold; background-color: #f9f9f9; color: #0f172a;">Rp 0,00</td>
                                                    <td class="subtotal-usd" style="vertical-align: middle; font-weight: bold; background-color: #f9f9f9; color: #0f172a;">$0.00</td>
                                                    <td style="background-color: #f9f9f9;"></td>
                                                </tr>
                                            </tfoot>
                                            </table>
                                            </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group" style="margin-bottom:0">
                                                    <a href="javascript:;" onclick="add_item(0)" class="btn btn-primary btn-add-item"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top: -30px;">
                                            <div class="col-md-12">
                                                <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="custom-file">
                                                    <label class="custom-file-label">Proof of Transfer</label>
                                                    <?php 
                                                        $hide_upload_transfer = 'hide';
                                                        if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                                                            $hide_upload_transfer = '';
                                                        }
                                                    ?>
                                                    <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this, 'transfer', 0); return false;"><i class="fa fa-times"></i></button>
                                                    <input type="file" class="<?php echo $hide_upload_transfer; ?>" id="proof" name="payment[0][proof]" onchange="update_to_release_payment(0)">
                                                    <div style="margin-bottom:10px; position:relative;">
                                                        <a onclick="return false;" class="lightbox"><label class="label label-default" disabled>Not Uploaded yet</label></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Released Date</label>
                                                    <input autocomplete="new-password" readonly type="text" class="form-control datepicker" name="payment[0][release_date]" placeholder="Release Date">
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
                <div class="panel-body" style="padding-top: 0;">
                                <hr style="margin-top:0; border-color:gray;">
                                <div class="col-lg-12 bg-info">
                                    <div class="form-group mt-4">
                                        <a href="javascript:;" onclick="add_payment()" class="btn btn-primary add-grant-disburstment"><i class="fa fa-plus fa-fw"></i> Add Grant Disbursement</a>
                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;">
                                    </div>
                                </div>
                                <div class="col-lg-12 p-0 mt-4">
                                    <div class="form-group">
                                        <label>Note from Admin</label>
                                        <textarea class="form-control" <?= $this->session->userdata('role') == 'finance' ? '' : '' ?> rows="4" name="admin_note"><?= $grantee_payment[0]['admin_note'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 p-0">
                                    <div class="form-group">
                                        <label>Note from Finance</label>
                                        <textarea class="form-control" <?= is_admin() ? '' : '' ?> rows="4" name="finance_note"><?= $grantee_payment[0]['finance_note'] ?></textarea>
                                    </div>
                                </div>
                            </div>

                <div class="col-lg-12" style="margin-bottom:10px;" id="btn-action">
                    <div style="margin-bottom:10px;">

                        <?php
                        if ($this->Grantee_ent_model->id) {
                        ?>
                            <input type="hidden" name="id" id="uid" value="<?php echo $this->Grantee_ent_model->id ?>">
                        <?php } ?>
                        <!-- <button type="button" id="btn-calculate" name="btn-calculate" class="btn btn-warning" style="float:right;">Calculate</button> -->
                        <button type="button" id="btn-submit" name="btn-submit" class="btn btn-success" style="float:right;margin-right:5px;">Save</button>
                        <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/users/manage') ?>" class="btn btn-danger" style="float:right;margin-right:5px;">Cancel</a>
                    </div>
                </div>
            </div>

            <div id="travel" class="tab-pane fade <?= $pid == 'travel' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-left">
                                        <input type="hidden" name="pid" value="travel" form="frm_manage_travel">
                                        Search : <input type="search" class="form-control input-sm" form="frm_manage_travel" name="search" value="<?= $paging_travel['search'] ?>" placeholder="">

                                        Status :
                                        <select class="form-control input-sm" name="status" form="frm_manage_travel" onchange="document.forms.frm_manage_travel.submit()">
                                            <option value="">-- Select Status --</option>
                                            <?php
                                            foreach ($record_status as $rs) {
                                                $selected = '';
                                                if ($rs->id == $paging_travel['status']) $selected = 'selected';
                                            ?>
                                                <option value="<?php echo $rs->id ?>" <?php echo $selected ?>><?php echo $rs->name ?></option>
                                            <?php } ?>
                                        </select>

                                        Year :
                                        <select class="form-control input-sm" name="year" form="frm_manage_travel" onchange="document.forms.frm_manage_travel.submit()">
                                            <option value="">-- Select Year --</option>
                                            <?php for ($i = date('Y', strtotime('+5 years')); $i > 1900; $i--) : ?>
                                                <?php
                                                $selected = '';
                                                if ($i == $paging_travel['year']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
                                            <?php endfor; ?>
                                        </select>

                                        Show :
                                        <select class="form-control input-sm" name="limit" form="frm_manage_travel" onchange="document.forms.frm_manage_travel.submit()">
                                            <?php
                                            foreach ($limit['limit_options'] as $lo) {
                                                $selected = '';
                                                if ($lo == $paging_travel['limit']) $selected = 'selected';
                                            ?>
                                                <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                                            <?php } ?>
                                        </select>
                                        entries
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_travel" class="btn btn-success btn-sm" id="btn-add">
                                            ADD NEW
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th>Payment Date</th>
                                                <th>Description</th>
                                                <th>Total Payment (IDR)</th>
                                                <th>Total Payment (USD)</th>
                                                <th>Proof of Transfer</th>
                                                <th>Status</th>
                                                <th width="300" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($payment_travel) {
                                                $no = 1;
                                                foreach ($payment_travel as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                        <td><?= $row->description ?></td>
                                                        <td>
                                                            <?php
                                                            $total_payment_idr = [];
                                                            foreach ($row->items as $key => $item) {
                                                                array_push($total_payment_idr, $item->nominal_idr);
                                                            }
                                                            ?>
                                                            <?= format_money(array_sum($total_payment_idr), 'IDR') ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $total_payment = [];
                                                            foreach ($row->items as $key => $item) {
                                                                array_push($total_payment, $item->nominal);
                                                            }
                                                            ?>
                                                            <?= format_money(array_sum($total_payment), 'USD') ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($row->proof)) { ?>
                                                                <a href="<?php echo base_url($row->proof) ?>" class="lightbox"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $row->payment_status ?></td>
                                                        <td class="text-center">
                                                            <a href="#" data-toggle="modal" data-target="#mdl_view_travel" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>
                                                            <?php //if ($row->status == 1 || $row->status == 2 || $row->status == 7 || $row->status == 6 || $row->status == 9) { 
                                                            ?>
                                                            <a href="#" data-toggle="modal" data-target="#mdl_edit_travel" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <?php //} 
                                                            ?>
                                                            <a href="<?= site_url((!empty($row->is_payment_grant) ? 'admin/user_grantee_grant/delete_record/' : 'admin/request_payment/delete_record/') . $row->payment_record_id . '?pid=travel') ?>" class="btn btn-danger btn-xs confirm-del">
                                                                <i class="fa fa-times-circle"></i> Delete
                                                            </a>
                                                            <input data-type="<?php echo $row->category == 'International Travel' ? 'travel' : 'record'; ?>" data-log="<?= $row->id ?>" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default payment-log" value="Open Log">
                                                        </td>
                                                    </tr>
                                            <?php
                                                    $no++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                <div class="pull-left">
                                    Showing <?php echo $paging_travel['start_row'] ?> to <?php echo $paging_travel['end_row'] ?> of <?php echo $paging_travel['total_rows'] ?> entries
                                </div>
                                <!-- /.pagination info -->
                                <?php echo $paging_travel['html'] ?>
                                <!-- /.pagination -->
                                <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
                                <input type="hidden" name="sort" value="<?php echo $sort ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($grantee_setting->is_clea) { ?>                                
            <div id="clea" class="tab-pane fade <?= $pid == 'clea' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-left">
                                        <input type="hidden" name="pid" value="clea" form="frm_manage_clea">
                                        Search : <input type="search" class="form-control input-sm" form="frm_manage_clea" name="search" value="<?= $paging_clea['search'] ?>" placeholder="">
                                        Status :
                                        <select class="form-control input-sm" name="status" form="frm_manage_clea" onchange="document.forms.frm_manage_clea.submit()">
                                            <option value="">-- Select Status --</option>
                                            <?php
                                            foreach ($record_status as $rs) {
                                                $selected = '';
                                                if ($rs->id == $paging_clea['status']) $selected = 'selected';
                                            ?>
                                                <option value="<?php echo $rs->id ?>" <?php echo $selected ?>><?php echo $rs->name ?></option>
                                            <?php } ?>
                                        </select>

                                        Year :
                                        <select class="form-control input-sm" name="year" form="frm_manage_clea" onchange="document.forms.frm_manage_clea.submit()">
                                            <option value="">-- Select Year --</option>
                                            <?php for ($i = date('Y', strtotime('+5 years')); $i > 1900; $i--) : ?>
                                                <?php
                                                $selected = '';
                                                if ($i == $paging_clea['year']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
                                            <?php endfor; ?>
                                        </select>

                                        Show :
                                        <select class="form-control input-sm" name="limit" form="frm_manage_clea" onchange="document.forms.frm_manage_clea.submit()">
                                            <?php
                                            foreach ($limit['limit_options'] as $lo) {
                                                $selected = '';
                                                if ($lo == $paging_clea['limit']) $selected = 'selected';
                                            ?>
                                                <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                                            <?php } ?>
                                        </select>
                                        entries
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_clea" class="btn btn-success btn-sm" id="btn-add">
                                            ADD NEW
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th>Payment Date</th>
                                                <th>Description</th>
                                                <th>Total Payment (IDR)</th>
                                                <th>Total Payment (USD)</th>
                                                <th>Proof of Transfer</th>
                                                <th>Status</th>
                                                <th width="300" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($payment_clea) {
                                                $no = 1;
                                                foreach ($payment_clea as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                        <td><?= $row->description ?></td>
                                                        <td>
                                                            <?php
                                                            $total_payment_idr = [];
                                                            foreach ($row->items as $key => $item) {
                                                                array_push($total_payment_idr, $item->nominal_idr);
                                                            }
                                                            ?>
                                                            <?= format_money(array_sum($total_payment_idr), 'IDR') ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $total_payment = [];
                                                            foreach ($row->items as $key => $item) {
                                                                array_push($total_payment, $item->nominal);
                                                            }
                                                            ?>
                                                            <?= format_money(array_sum($total_payment), 'USD') ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($row->proof)) { ?>
                                                                <a href="<?php echo base_url($row->proof) ?>" class="lightbox"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $row->payment_status ?></td>
                                                        <td class="text-center">
                                                            <a href="#" data-toggle="modal" data-target="#mdl_view_clea" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>
                                                            <?php //if ($row->status == 1 || $row->status == 2 || $row->status == 7 || $row->status == 6 || $row->status == 9) { 
                                                            ?>
                                                            <a href="#" data-toggle="modal" data-target="#mdl_edit_clea" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <?php //} 
                                                            ?>
                                                            <a href="<?= site_url((!empty($row->is_payment_grant) ? 'admin/user_grantee_grant/delete_record/' : 'admin/request_payment/delete_record/') . $row->payment_record_id . '?pid=clea') ?>" class="btn btn-danger btn-xs confirm-del">
                                                                <i class="fa fa-times-circle"></i> Delete
                                                            </a>
                                                            <input data-type="<?php echo $row->category == 'International Travel' ? 'travel' : 'record'; ?>" data-log="<?= $row->id ?>" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default payment-log" value="Open Log">
                                                        </td>
                                                    </tr>
                                            <?php
                                                    $no++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                <div class="pull-left">
                                    Showing <?php echo $paging_clea['start_row'] ?> to <?php echo $paging_clea['end_row'] ?> of <?php echo $paging_clea['total_rows'] ?> entries
                                </div>
                                <!-- /.pagination info -->
                                <?php echo $paging_clea['html'] ?>
                                <!-- /.pagination -->
                                <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
                                <input type="hidden" name="sort" value="<?php echo $sort ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div id="record" class="tab-pane fade <?= $pid == 'support' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-left">
                                        <input type="hidden" name="pid" value="support" form="frm_manage">
                                        Search : <input type="search" class="form-control input-sm" form="frm_manage" name="search" value="<?= $paging['search'] ?>" placeholder="">

                                        Status :
                                        <select class="form-control input-sm" name="status" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <option value="">-- Select Status --</option>
                                            <?php
                                            foreach ($record_status as $rs) {
                                                $selected = '';
                                                if ($rs->id == $paging['status']) $selected = 'selected';
                                            ?>
                                                <option value="<?php echo $rs->id ?>" <?php echo $selected ?>><?php echo $rs->name ?></option>
                                            <?php } ?>
                                        </select>

                                        Year :
                                        <select class="form-control input-sm" name="year" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <option value="">-- Select Year --</option>
                                            <?php for ($i = date('Y', strtotime('+5 years')); $i > 1900; $i--) : ?>
                                                <?php
                                                $selected = '';
                                                if ($i == $paging['year']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
                                            <?php endfor; ?>
                                        </select>

                                        Show :
                                        <select class="form-control input-sm" name="limit" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <?php
                                            foreach ($limit['limit_options'] as $lo) {
                                                $selected = '';
                                                if ($lo == $paging['limit']) $selected = 'selected';
                                            ?>
                                                <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                                            <?php } ?>
                                        </select>
                                        entries
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record" class="btn btn-success btn-sm" id="btn-add">
                                            ADD NEW
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th>Payment Date</th>
                                                <th>Description</th>
                                                <th>Total Payment (IDR)</th>
                                                <th>Total Payment (USD)</th>
                                                <th>Proof of Transfer</th>
                                                <th>Status</th>
                                                <th width="300" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($payment_record) {
                                                $no = 1;
                                                foreach ($payment_record as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                        <td><?= $row->description ?></td>
                                                        <td>
                                                            <?php
                                                            $total_payment_idr = [];
                                                            foreach ($row->items as $key => $item) {
                                                                array_push($total_payment_idr, $item->nominal_idr);
                                                            }
                                                            ?>
                                                            <?= format_money(array_sum($total_payment_idr), 'IDR') ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $total_payment = [];
                                                            foreach ($row->items as $key => $item) {
                                                                array_push($total_payment, $item->nominal);
                                                            }
                                                            ?>
                                                            <?= format_money(array_sum($total_payment), 'USD') ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($row->proof)) { ?>
                                                                <a href="<?php echo base_url($row->proof) ?>" class="lightbox"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $row->payment_status ?></td>
                                                        <td class="text-center">
                                                            <a href="#" data-toggle="modal" data-target="#mdl_view_record" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>
                                                            <?php //if ($row->status == 1 || $row->status == 2  || $row->status == 7 || $row->status == 6 || $row->status == 9) { 
                                                            ?>
                                                            <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <?php //} 
                                                            ?>
                                                            <a href="<?= site_url((!empty($row->is_payment_grant) ? 'admin/user_grantee_grant/delete_record/' : 'admin/request_payment/delete_record/') . $row->payment_record_id . '?pid=support') ?>" class="btn btn-danger btn-xs confirm-del">
                                                                <i class="fa fa-times-circle"></i> Delete
                                                            </a>
                                                            <input data-type="record" data-log="<?= $row->id ?>" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default payment-log" value="Open Log">
                                                        </td>
                                                    </tr>
                                            <?php
                                                    $no++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                <div class="pull-left">
                                    Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
                                </div>
                                <!-- /.pagination info -->
                                <?php echo $paging['html'] ?>
                                <!-- /.pagination -->
                                <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
                                <input type="hidden" name="sort" value="<?php echo $sort ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="delete_detail_payment" name="delete_detail_payment">
        <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
        <input type="hidden" id="delete_detail_payment_travel" name="edit_travel[delete_detail_payment_travel]">
        <input type="hidden" name="total_grant" value="<?= $grantee_setting->total_grant ?>">
        <input type="hidden" name="grantee_id" id="grantee_id" value="<?= $grantee_id ?>">
</form>

<div class="modal fade text-center" id="mdl_validate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="top:30%">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p id="validate_message"></p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-center" id="mdl_detail_log" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-lg-6" id="old_data_section">
                        <div class="alert alert-warning">Old Data</div>
                    </div>
                    <div class="col-lg-6" id="new_data_section">
                        <div class="alert alert-info">New Data</div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6" id="old_data_section">
                        <div id="old-data">

                        </div>
                    </div>
                    <div class="col-lg-6" id="new_data_section">
                        <div id="new-data">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddSubPayment" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Sub Payment </h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Sub Payment Name</label>
                    <input type="text" class="form-control" id="add_sub_category_name" placeholder="Enter sub payment name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_save_sub_category">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAddPaymentItem" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Payment Item</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- <input type="hidden" id="add_sub_cat_tab"> -->
                <div class="form-group">
                    <label> Payment Item Name</label>
                    <input type="text" class="form-control" id="add_payment_item_name" placeholder="Enter payment item name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_save_payment_item">Save</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/request_payment/modal_payment_grant_support_add') ?>
<?php $this->load->view('admin/request_payment/modal_payment_grant_support_edit') ?>
<?php $this->load->view('admin/request_payment/modal_payment_grant_support_view') ?>
<?php $this->load->view('admin/request_payment/modal_payment_clea_add') ?>
<?php $this->load->view('admin/request_payment/modal_payment_clea_edit') ?>
<?php $this->load->view('admin/request_payment/modal_payment_clea_view') ?>
<?php $this->load->view('admin/request_payment/modal_payment_international_add') ?>
<?php $this->load->view('admin/request_payment/modal_payment_international_edit') ?>
<?php $this->load->view('admin/request_payment/modal_payment_international_view') ?>
<?php $this->load->view('admin/request_payment/modal_payment_log'); ?>

<?php
if (!empty($payment_record)) :
    $final_record = [];
    foreach ($payment_record as $record) {
        $final_record[$record->id] = $record;
    }
?>
    <script>
        var currentUserReviews = JSON.parse(`<?php echo safe_parse_json(json_encode($final_record)); ?>`);
    </script>
<?php endif; ?>

<?php
if (!empty($payment_travel)) :
    $final_travel = [];
    foreach ($payment_travel as $travel) {
        $final_travel[$travel->id] = $travel;
    }
?>
    <script>
        var currentPaymentTravel = JSON.parse(`<?php echo safe_parse_json(json_encode($final_travel)); ?>`);
    </script>
<?php endif; ?>

<?php
if (!empty($payment_item_support)) : ?>
    <script>
        var currentPaymentItems = JSON.parse(`<?php echo safe_parse_json(json_encode($payment_item_support)); ?>`);
    </script>
<?php endif; ?>


<?php
if (!empty($payment_item_travel)) : ?>
    <script>
        var currentPaymentItemsTravel = JSON.parse(`<?php echo safe_parse_json(json_encode($payment_item_travel)); ?>`);
    </script>
<?php endif; ?>

<?php
if (!empty($payment_sub_travel)) :
    $final_sub_travel = [];
    foreach ($payment_sub_travel as $row) {
        $final_sub_travel[] = $row;
    }
?>
    <script>
        var currentSubCategoryTravel = JSON.parse(`<?php echo safe_parse_json(json_encode($final_sub_travel)); ?>`);
    </script>
<?php endif; ?>

<?php
if (!empty($payment_sub_support)) :
    $final_sub_record = [];
    foreach ($payment_sub_support as $row) {
        $final_sub_record[] = $row;
    }
?>
    <script>
        var currentSubCategoryRecord = JSON.parse(`<?php echo safe_parse_json(json_encode($final_sub_record)); ?>`);
    </script>
<?php endif; ?>

<?php
if (!empty($payment_clea)) :
    $final_clea = [];
    foreach ($payment_clea as $clea) {
        $final_clea[$clea->id] = $clea;
    }
?>
    <script>
        var currentPaymentClea = JSON.parse(`<?php echo safe_parse_json(json_encode($final_clea)); ?>`);
    </script>
<?php endif; ?>

<?php
if (!empty($payment_sub_clea)) :
    $sub_clea = [];
    foreach ($payment_sub_clea as $row) {
        $sub_clea[] = $row;
    }
?>
    <script>
        var currentSubCategoryClea = JSON.parse(`<?php echo safe_parse_json(json_encode($sub_clea)); ?>`);
    </script>

    <script>
        var currentPaymentProofOfExpenses = JSON.parse(`<?php echo safe_parse_json(json_encode($proof_of_expenses)); ?>`);
    </script>
<?php endif; ?>