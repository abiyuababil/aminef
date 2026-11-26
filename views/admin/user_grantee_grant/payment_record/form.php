<?php

$active_country = $this->session->userdata('active_country');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$tab_active = '';
$content_active = '';
$pid = $this->input->get('pid');
if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
    /* biar tetap bisa scroll walaupun 2 modal */
    body.modal-open {
        overflow: auto !important;
    }

    /* modal kedua lebih atas */
    /* #modalAddSubCategoryPayment {
        z-index: 1065;
    } */

    /* backdrop kedua */
    /* .modal-backdrop.show:nth-of-type(2) {
        z-index: 1040;
    } */
        /* Atur z-index backdrop */
    .modal-backdrop {
        z-index: 1040 !important;
    }

    /* Modal kedua lebih tinggi */
    #modalAddSubCategoryPayment {
        z-index: 1050 !important;
    }

    /* biar isi modal bisa scroll */
    #modalAddSubCategoryPayment .modal-body {
        max-height: 70vh;
        overflow-y: auto;
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

    .payment-attachment {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .default-payment-attachment {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
    
    .readonly-selectpicker + .dropdown-toggle {
        pointer-events: none;  /* Tidak bisa diklik */
        opacity: 0.8;          /* Efek visual seperti disable */
    }
    .readonly-select {
        pointer-events: none;
        background: #eee;
    }

    .grantee-card-diff {
        border: 2px solid #5bc0de !important;
        border-radius: 4px;
        margin-bottom: 12px;
    }
    .grantee-card-diff .panel-heading {
        background-color: #d9edf7;
        padding: 8px 12px;
    }
    .grantee-card-diff .panel-heading .panel-title {
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .grantee-card-diff .panel-heading .panel-title > a {
        flex: 1;
    }
    .grantee-card-diff .panel-body {
        padding: 12px;
    }

</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $this->User_grantee_grant_model->name ?> - <?= $this->User_grantee_grant_model->year ?></h1>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>

<form id="frm_manage" name="frm_manage" method="GET">
    <?php if ($pid == 'non_grantee') { ?>
        <input type="hidden" name="pid" value="non_grantee">
    <?php } ?>
    <input type="hidden" name="sort_by" value="<?php echo html_escape(isset($sort_by_non_grantee) ? $sort_by_non_grantee : (isset($sort_by) ? $sort_by : '')); ?>">
    <input type="hidden" name="sort" value="<?php echo html_escape(isset($sort_non_grantee) ? $sort_non_grantee : (isset($sort) ? $sort : '')); ?>">
</form>
<form id="frm_bulk_non_grantee_filter" name="frm_bulk_non_grantee_filter" method="GET">
    <input type="hidden" name="pid" value="bulk_non_grantee">
    <input type="hidden" name="sort_by" value="<?php echo html_escape(isset($sort_by_bulk) ? $sort_by_bulk : ''); ?>">
    <input type="hidden" name="sort" value="<?php echo html_escape(isset($sort_bulk) ? $sort_bulk : ''); ?>">
</form>
<form id="form_filter_payment_grantee" name="form_filter_payment_grantee" method="GET">
    <input type="hidden" name="pid" value="payment_grantee">
    <input type="hidden" name="sort_by" value="<?php echo html_escape(isset($sort_by_grantee) ? $sort_by_grantee : ''); ?>">
    <input type="hidden" name="sort" value="<?php echo html_escape(isset($sort_grantee) ? $sort_grantee : ''); ?>">
</form>
<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px">  
            <ul class="nav nav-pills">
                <li id="li_non_grantee" <?php echo $default_tab_active ?>><a data-toggle="tab" href="#non_grantee" aria-expanded="true">Non-Grantee Payments</a></li>
                <li <?= $pid == 'bulk_non_grantee' ? 'class="active"' : '' ?> id="li_bulk_non_grantee" class=""><a data-toggle="tab" href="#bulk_non_grantee" aria-expanded="true">Bulk Non-Grantee Payments</a></li>
                <li <?= $pid == 'payment_grantee' ? 'class="active"' : '' ?> id="li_payment_grantee"><a data-toggle="tab" href="#payment_grantee" aria-expanded="true">Bulk Grantee Payments</a></li>
                <li <?= $pid == 'payment_support' ? 'class="active"' : '' ?> id="li_payment_support"><a data-toggle="tab" href="#payment_support" aria-expanded="true">Bulk Grant Support & International Travel Payments</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div id="non_grantee" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-left">
                                        Search : <input type="search" class="form-control input-sm" form="frm_manage" name="search" value="<?= $paging['search'] ?>" placeholder="Search" onkeydown="if(event.key === 'Enter'){ event.preventDefault(); document.forms.frm_manage.submit(); }">
                                    
                                        Status : 
                                        <select class="form-control input-sm" name="status" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <option value="">-- Select Status --</option>
                                        <?php
                                        foreach($record_status as $rs) {
                                            $selected = '';
                                            if ($rs->id == $paging['status']) $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $rs->id ?>" <?php echo $selected ?>><?php echo $rs->name ?></option>
                                        <?php } ?>
                                        </select> 
                                    
                                        Year : 
                                        <select class="form-control input-sm" name="year" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <option value="">-- Select Year --</option>
                                            <?php for ($i=date('Y', strtotime('+5 years')); $i > 1900; $i--) : ?>
                                                <?php 
                                                    $selected = '';
                                                    if ($i == $paging['year']) {
                                                        $selected = 'selected';
                                                    }    
                                                ?>
                                                <option <?= $selected ?> value="<?= $i; ?>"><?= $i;?></option>
                                            <?php endfor; ?>
                                        </select> 
                                        
                                        Show : 
                                        <select class="form-control input-sm" name="limit" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                        <?php
                                        foreach($limit['limit_options'] as $lo) {
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
                                                <th>Entry Date</th>
                                                <th>Vendor Name</th>
                                                <th>Beneficiary name</th>
                                                <th>Description</th>
                                                <!-- <th>Description</th> -->
                                                <?php //if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <th>Total Payment (IDR)</th>
                                                <?php //} ?>
                                                <th>Total Payment (USD)</th>
                                                <th>Proof</th>
                                                <th>Status</th>
                                                <th data-form="frm_manage" <?php echo sorting_attribute('created_at', isset($sort_by_non_grantee) ? $sort_by_non_grantee : (isset($sort_by) ? $sort_by : ''), isset($sort_non_grantee) ? $sort_non_grantee : (isset($sort) ? $sort : '')) ?>>Created At</th>
                                                <th width="150" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($payment_record)
                                        {
                                            $no = $paging['start_row'];
                                            foreach($payment_record as $row) {
                                                $vendor = get_row_db('am_vendor', ['id' => $row->vendor_id]);
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= !empty($row->payment_date) ? date('d-M-Y', strtotime($row->payment_date)) : '-' ?></td>
                                                <td><?= $vendor ? $vendor->name : ($row->vendor_id == '0' && $row->third_party_vendor_name ? $row->third_party_vendor_name : 'Other Vendor') ?></td>
                                                <td><?= $vendor ? $vendor->beneficiary_name : ($row->vendor_id == '0' && $row->third_party_payment ? $row->third_party_beneficiary_name : '') ?></td>
                                                <td><?= $row->description ?></td>
                                                <?php //if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <td>
                                                <?php 
                                                    $total_payment_idr = [];
                                                    foreach ($row->items as $key => $item) {
                                                        array_push($total_payment_idr, $item->nominal_idr);
                                                    }
                                                ?>
                                                <?= format_money(array_sum($total_payment_idr), 'IDR')?>
                                                </td>
                                                <?php //} ?>
                                                <td>
                                                    <?php 
                                                        $total_payment = [];
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment, $item->nominal);
                                                        }
                                                    ?>
                                                    <?= format_money(array_sum($total_payment), 'USD')?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($row->proof)) { ?>
                                                    <a href="<?php echo base_url($row->proof) ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $row->payment_status ?></td>
                                                <td><?= date('d M Y H:i:s', strtotime($row->created_at)); ?></td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a href="<?= site_url('admin/user_grantee_grant/delete_record/'.$row->id) ?>" class="btn btn-danger btn-xs confirm-del">
                                                        <i class="fa fa-times-circle"></i> Delete
                                                    </a>
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
                            </div>
                            <div class="panel-body">
                                
                            <a href="<?= base_url('admin/user_grantee_grant/manage')?>" class="btn btn-info" > Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="bulk_non_grantee" class="tab-pane fade <?= $pid == 'bulk_non_grantee' ? 'active in' : '' ?>">
                <?php $this->load->view('admin/partials/payment_bulk_non_grantee') ?>
            </div>

            <div id="payment_grantee" class="tab-pane fade <?= $pid == 'payment_grantee' ? 'active in' : '' ?>">
                <?php $this->load->view('admin/partials/payment_bulk_grantee_us')?>
            </div>

            <div id="payment_support" class="tab-pane fade <?= $pid == 'payment_support' ? 'active in' : '' ?>">
                <?php $this->load->view('admin/partials/payment_bulk_support')?>
            </div>

        </div>
        <input type="hidden" id="delete_detail_payment" name="delete_detail_payment">
        <input type="hidden" id="delete_detail_payment_record_non_grantee" name="edit_record[delete_detail_payment_record]">
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

<div class="modal fade" id="mdl_add_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="exampleModalLabel">Add Grant Payment Record</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body record-payment-add">
        <div class="form-group">
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Entry Date</label>
                <input type="text" class="payment-date-record form-control datepicker" name="add_record[payment_date]" placeholder="Entry Date" value="<?php echo date('d M Y'); ?>"> 
                <div class="text-danger invalid-tooltip payment-date-record-validation hide" style="display: block;">Entry Date is Required</div>        
            </div>
            <div class="col-lg-6">
                <label>Description</label>
                <input type="text" class="form-control" name="add_record[description]" placeholder="Description">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Payment Deadline</label>
                <input type="text" form="form" class="form-control datepicker" id="add_record_deadline_date" name="add_record[deadline_date]" placeholder="Payment Deadline" value="<?php echo date('d M Y', strtotime('+7 days')); ?>">
            </div>
            <div class="col-lg-6">
                <label>Priority</label>
                <select class="form-control" id="add_record_priority" name="add_record[priority]">
                    <option value="">Select Priority</option>
                    <option value="1">Normal</option>
                    <option value="2">Urgent</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Note From Admin</label>
                <textarea type="text" form="form" class="form-control" name="add_record[admin_note]" placeholder="Note From Admin"></textarea>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Memo Budget</label>
                    <select class="form-control" name="add_record[user_grantee_grant_memo_id]">
                        <option value="">Select Memo Budget</option>
                        <?php foreach($memo_budget as $memo) { ?>
                            <?php if ($memo->is_active == 'Yes') { ?>
                                <option data-grant-id="<?php echo $memo->user_grantee_grant_id ?>" value="<?php echo $memo->id; ?>"><?php echo $memo->file_name; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">3rd Party Payment</label>
                <select name="add_record[third_party_payment]" data-hide-object="parent-vendor" onchange="showVendor(this, <?= $this->session->userdata('active_country') ?>)" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <?php 
                $hide_upload_expense = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_expense')) {
                    $hide_upload_expense = '';
                }
            ?>
            <div class="col-lg-6">
                <label>Proof of Expense</label>
                <div class="additional-proof-of-expense">
                    
                </div>
                <div class="form-group <?php echo $hide_upload_expense; ?>">
                    <a class="btn btn-primary pull-right btn-xs btn-add-proof-expense" data-form="form" data-type="proof-of-expense" data-input_name="proof_of_expenses[]" onclick="add_more_attachment(this);"><i class="fa fa-plus"></i> Add More</a>
                </div>
            </div>
            <!-- <div class="col-lg-6">
            <?php if ($this->session->userdata('role') == 'finance') { ?>    
                <label>Notify Admin via Email</label>
                <select class="form-control" name="add_record[notify_admin]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            <?php } else { ?>
                <label>Notify Finance via Email</label>
                <select class="form-control" name="add_record[notify_finance]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            <?php } ?>
            </div> -->
        </div>
        
        <div class="parent-vendor hide">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Vendor Name</label>
                    <select name="add_record[vendor_id]" data-mode="add" class="vendor form-control">
                        <option value="">-- Select Vendor --</option>
                        <?php foreach($vendors as $vendor) { ?>
                            <option value="<?= $vendor->id; ?>"><?= $vendor->name; ?></option>
                        <?php } ?>
                        <option value="0">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group row section-vendor-name">
                <div class="col-lg-6">
                    <label>Vendor Name</label>
                    <input type="text" class="edit-vendor-name form-control" name="add_record[third_party_vendor_name]">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Beneficiary Name (As listed on the bank account)</label>
                    <input type="text" disabled class="edit-beneficiary-name form-control" name="add_record[third_party_beneficiary_name]">
                </div>
            </div>
            <div class="form-group row section-edit-vendor-address">
                <div class="col-lg-12">
                    <label>Beneficiary Address: [Building/Street, City, State/Province + Postal Code, Country]</label>
                    <textarea disabled rows="3" class="edit-vendor-address form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Bank Name</label>
                    <input type="text" disabled class="edit-bank-name form-control" name="add_record[third_party_bank_name]">
                </div>
                <div class="col-lg-6">
                    <label>Account Number</label>
                    <input type="text" disabled class="edit-account-number form-control" name="add_record[third_party_account_number]">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Bank Address: [Building/Street, City, State/Province + Postal Code, Country]</label>
                    <textarea disabled rows="3" class="edit-bank-address form-control" name="add_record[third_party_bank_address]"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>SWIFT Code</label>
                    <input type="text" disabled class="edit-swift-code form-control" name="add_record[third_party_swift_code]">
                </div>
                <div class="col-lg-6">
                    <label>Routing or ABA Number (for U.S. Banks)</label>
                    <input type="text" disabled class="edit-routing-number form-control" name="add_record[third_party_routing_number]">
                </div>
            </div>
        </div>
        <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PANELIST</p>
        <div class="row mt-3" style="padding:0 15px 15px">
            <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Panelist</label>
                        <select name="add_record[panellist_id]" id="panellist_id" class="form-control select2" onchange="select_panellist(this, 'add')" style="width:100%">
                            <option value="">-- Select Panelist --</option>
                            <?php foreach ($panellist as $p) { ?>
                            <option value="<?= $p->id ?>"><?= $p->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Field of Study</label>
                        <input type="text" id="field_of_study_add" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Email</label>
                        <input type="text" id="panellist_email_add" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Telp</label>
                        <input type="text" id="panellist_telp_add" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Bank Info</label>
                        <input type="text" id="panellist_bank_info_add" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Beneficiary Name</label>
                        <input type="text" id="panellist_beneficiary_add" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Account</label>
                        <input type="text" id="panellist_account_add" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Status Panelist</label>
                        <input type="text" id="panellist_status_add" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> HOTEL</p>
        <div class="row mt-3" style="padding:0 15px 15px">
            <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Hotel</label>
                        <select name="add_record[hotel_id]" id="hotel_id" class="form-control select2" onchange="select_hotel(this, 'add')" style="width:100%">
                            <option value="">-- Select Hotel --</option>
                            <?php foreach ($hotels as $h) { ?>
                            <option value="<?= $h->id ?>"><?= $h->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Email</label>
                        <input type="text" id="hotel_email_add" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Telp</label>
                        <input type="text" id="hotel_telp_add" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Bank Info</label>
                        <input type="text" id="hotel_bank_info_add" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Beneficiary Name</label>
                        <input type="text" id="hotel_beneficiary_add" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Account</label>
                        <input type="text" id="hotel_account_add" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Address</label>
                        <textarea type="text" form="form" class="form-control" id="hotel_address_add" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Status</label>
                <select form="form" class="form-control status" id="record_status_add" name="add_record[record_status]">
                    <!-- <option value="">-- Select Record Status --</option> -->
                    <?php
                    if ($record_status) {
                        foreach ($record_status as $ps) {
                            ?>
                            <option value="<?= $ps->id ?>" <?php echo  $this->User_grantee_grant_model->default_payment_record_status == $ps->id ? 'selected' : ''; ?>><?= $ps->name ?></option>
                        <?php
                            }
                        }
                        ?>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Proof of Conversion</label>
                    <?php 
                        $hide_upload_conversion = 'hide';
                        if (has_permission('payment_record', 'upload_proof_of_conversion')) {
                            $hide_upload_conversion = '';
                        }
                    ?>
                    <div class="<?php echo $hide_upload_conversion; ?>">
                        <button class="btn btn-danger btn-xs pull-right mr-4 <?php echo $hide_upload_conversion; ?>" type="button" onclick="remove_file(this); return false;"><i class="fa fa-times"></i></button>
                        <input type="file" data-modal="mdl_add_record" id="proof-of-conversion" name="add_proof_of_conversion">
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <label>Grantee</label>
                    <select class="form-control select2 select-grantee" name="add_record[user_grantee_id]">
                        <option value="">Select Grantee</option>
                        <?php foreach($user_grantee as $grantee) { ?>
                            <option value="<?php echo $grantee->user_id; ?>"><?php echo get_full_name($grantee, $grantee->country_id == AMERICAN_DATABASE ? 'US' : 'ID'); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group select-category-section" style="margin-top: 100px;">
                <div class="col-lg-12">
                    <label>Payment Category</label>
                    <select id="category_non_grantee" class="form-control select2 select-category" onchange="add_item_record(0, true)" name="add_record[category_id]">
                        <option value="">Select Payment Category</option>
                        <?php foreach($payment_item_categories as $category) { ?>
                            <option value="<?php echo $category->category_type; ?>"><?php echo $category->category_type; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PAYMENT ITEMS</p>
        <div id="wrap-request-record0">
            <div id="request-item-record-0'" class="row mt-3 request-item-record0" style="padding:0 15px 15px">
                <div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">
                    <div class="col-lg-3">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Sub Category</label>
                            <select id="select_sub_category_record_0" onchange="select_payment_item_record('0')" class="record-payment-sub-category form-control select2" style="width:100%" form="form" name="add_record[items][0][sub_category]">
                                <option value="">-- Select Sub Category --</option>
                                <?php foreach ($payment_sub_support as $kpsp => $psp) { ?>
                                    <option value="<?= $psp->id ?>"><?= $psp->name ?></option>
                                <?php } ?>
                                <option value="__add_new__" data-category="category_non_grantee" data-select="select_sub_category_record_0" title="sub"> <span class="glyphicon glyphicon-plus"></span> Add Sub Category</option>
                            </select>
                            <div class="text-danger invalid-tooltip record-payment-sub-category-validation hide" style="display: block;">Sub Category</div>  
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Payment Item</label>
                            <select onchange="remove_error('record-payment-item-validation');" id="select_payment_item_record_0" class="record-payment-item form-control select2" style="width:100%" form="form" name="add_record[items][0][item]">
                                <option value="">-- Select Item --</option>
                            </select>
                            <div class="text-danger invalid-tooltip record-payment-item-validation hide" style="display: block;">Payment Item is Required</div>  
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Nominal IDR</label>
                            <input onchange="remove_error('record-payment-nominal-validation-idr');" type="text" form="form" class="currency-idr record-payment-nominal-idr form-control" name="add_record[items][0][nominal_idr]">
                            <div class="text-danger invalid-tooltip record-payment-nominal-validation-idr hide" style="display: block;">Nominal IDR is Required</div>  
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Nominal USD</label>
                            <input onchange="remove_error('record-payment-nominal-validation');" type="text" form="form" class="currency-usd record-payment-nominal form-control" name="add_record[items][0][nominal]">
                            <div class="text-danger invalid-tooltip record-payment-nominal-validation hide" style="display: block;">Nominal is Required</div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:0;">
            <a href="javascript:;" onclick="add_item_record(0)" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add Item</a>
            <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-record" style="display:none;">
        </div>
        <div class="form-group mt-4">
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Note From Finance</label>
                <textarea type="text" form="form" class="form-control" name="add_record[finance_note]" placeholder="Note From Finance"></textarea>
            </div>
            <?php 
                $hide_upload_transfer = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                    $hide_upload_transfer = '';
                }
            ?>
            <div class="col-lg-6">
                <label>Proof of Transfer</label>
                <div class="<?php echo $hide_upload_transfer; ?>">
                    <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this); return false;"><i class="fa fa-times"></i></button>
                    <input type="file" onchange="update_to_release(this)" data-modal="mdl_add_record" id="proof-of-transfer" name="add_proof_record">
                    <small class="file-for-testing">File Size Max 5MB</small>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button class="btn-submit-record-disabled btn btn-success hide" disabled>Saving Data...</button>
        <button type="submit" id="btn-submit-record" data-action="create" name="btn" value="save_rec" class="btn btn-success">Save</button>
        <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="mdl_edit_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="exampleModalLabel">Edit Grant Payment Record</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
            <label class="text-center">Entry Date</label>
                <input type="text" form="form" id="payment_date" class="payment-date-record form-control datepicker" name="edit_record[payment_date]" placeholder="Entry Date">
                <input type="hidden" id="payment_id" name="edit_record[payment_id]">
                <div class="text-danger invalid-tooltip payment-date-record-validation hide" style="display: block;">Entry Date is Required</div>        
            </div>
            <div class="col-lg-6">
                <label class="text-center">Description</label>
                <input type="text" class="form-control" id="description" name="edit_record[description]" placeholder="Description">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Payment Deadline</label>
                <input type="text" form="form" class="form-control datepicker" id="edit_record_deadline_date" name="edit_record[deadline_date]" placeholder="Payment Deadline">
            </div>
            <div class="col-lg-6">
                <label>Priority</label>
                <select class="form-control" id="edit_record_priority" name="edit_record[priority]">
                    <option value="">Select Priority</option>
                    <option value="1">Normal</option>
                    <option value="2">Urgent</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <!-- <div class="col-lg-6">
                <label class="text-center">Release Type</label>
                <select class="form-control" form="form" id="release_type" name="edit_record[release_type]">
                    <option value="">-- Select Release Type --</option>
                    <option value="Manual">Manual</option>
                    <option value="MRI">MRI</option>
                </select>
            </div> -->
            <div class="col-lg-6">
                <label class="text-center">Note From Admin</label>
                <textarea type="text" form="form" id="admin_note" class="form-control" name="edit_record[admin_note]" placeholder="Note From Admin"></textarea>
            </div>
            <?php if (!is_null($memo_budget)) { ?>
                <div class="col-lg-6">
                    <label class="col-form-label">Memo Budget</label>
                    <select class="form-control" name="edit_record[user_grantee_grant_memo_id]">
                        <option value="">Select Memo Budget</option>
                        <?php foreach($memo_budget as $memo) { ?>
                            <option data-grant-id="<?php echo $memo->user_grantee_grant_id ?>" <?= $memo->is_active == 'Yes' ? '' : 'disabled class="memo-budget-inactive"' ?> value="<?php echo $memo->id; ?>" data-is-active="<?php echo $memo->is_active; ?>"><?php echo $memo->file_name; ?> <?= $memo->is_active == 'Yes' ? '' : '(Inactive)' ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
        </div>
        <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PANELIST</p>
        <div class="row mt-3" style="padding:0 15px 15px">
            <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Panelist</label>
                        <select name="edit_record[panellist_id]" id="panellist_id_edit" class="form-control select2" onchange="select_panellist(this, 'edit')" style="width:100%">
                            <option value="">-- Select Panelist --</option>
                            <?php foreach ($panellist as $p) { ?>
                            <option value="<?= $p->id ?>"><?= $p->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Field of Study</label>
                        <input type="text" id="field_of_study_edit" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Email</label>
                        <input type="text" id="panellist_email_edit" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Telp</label>
                        <input type="text" id="panellist_telp_edit" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Bank Info</label>
                        <input type="text" id="panellist_bank_info_edit" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Beneficiary Name</label>
                        <input type="text" id="panellist_beneficiary_edit" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Account</label>
                        <input type="text" id="panellist_account_edit" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Status Panelist</label>
                        <input type="text" id="panellist_status_edit" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> HOTEL</p>
        <div class="row mt-3" style="padding:0 15px 15px">
            <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Hotel</label>
                        <select name="edit_record[hotel_id]" id="hotel_id_edit" class="form-control select2" onchange="select_hotel(this, 'edit')" style="width:100%">
                            <option value="">-- Select Hotel --</option>
                            <?php foreach ($hotels as $h) { ?>
                            <option value="<?= $h->id ?>"><?= $h->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Email</label>
                        <input type="text" id="hotel_email_edit" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Telp</label>
                        <input type="text" id="hotel_telp_edit" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Bank Info</label>
                        <input type="text" id="hotel_bank_info_edit" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Beneficiary Name</label>
                        <input type="text" id="hotel_beneficiary_edit" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Account</label>
                        <input type="text" id="hotel_account_edit" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Address</label>
                        <textarea type="text" form="form" class="form-control" id="hotel_address_edit" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">3rd Party Payment</label>
                <select name="edit_record[third_party_payment]" data-hide-object="edit-parent-vendor" onchange="showVendor(this)" id="third-party-payment" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <?php 
                $hide_upload_expense = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_expense')) {
                    $hide_upload_expense = '';
                }
            ?>
            <div class="col-lg-6">
                <label>Proof of Expense</label>
                <div class="default-payment-attachment">
                    <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_expense; ?>" type="button" onclick="remove_attachment(this, 'default_expense_attachment'); return false;"><i class="fa fa-times"></i></button>
                    <input type="file" data-modal="mdl_add_record" id="proof-of-expense" name="proof_expense" class="hide">
                    <div id="preview-edit-not-uploaded-expense">
                        <a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a>
                    </div>
                    <div id="preview-edit-uploaded-expense" class="expense-file">
                        <a onclick="return false;" id="expense-preview-file" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                    </div>
                </div>
                <div class="additional-proof-of-expense-edit"></div>
                <div class="form-group <?php echo $hide_upload_expense; ?>">
                    <a class="btn btn-primary pull-right btn-xs btn-add-proof-expense-edit" data-form="form" data-type="proof-of-expense-edit" data-input_name="proof_of_expenses[]" onclick="add_more_attachment(this);"><i class="fa fa-plus"></i> Add More</a>
                </div>
            </div>
            <!-- <div class="col-lg-6">
                <?php if ($this->session->userdata('role') == 'finance') { ?>    
                    <label>Notify Admin</label>
                    <select class="form-control" id="edit_notify_admin" name="edit_record[notify_admin]">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                <?php } else { ?>
                    <label>Notify Finance</label>
                    <select class="form-control" id="edit_notify_finance" name="edit_record[notify_finance]">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                <?php } ?>
            </div> -->
        </div>
        <div class="edit-parent-vendor hide">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Vendor Name</label>
                    <select name="edit_record[vendor_id]" id="vendor_id" data-mode="edit" class="vendor form-control">
                        <option value="">-- Select Vendor --</option>
                        <?php foreach($vendors as $vendor) { ?>
                            <option value="<?= $vendor->id; ?>"><?= $vendor->name; ?></option>
                        <?php } ?>
                        <option value="0">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group row section-vendor-name">
                <div class="col-lg-6">
                    <label>Vendor Name</label>
                    <input type="text" class="edit-vendor-name form-control" name="edit_record[third_party_vendor_name]">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Beneficiary Name (As listed on the bank account)</label>
                    <input type="text" disabled class="edit-beneficiary-name form-control" name="edit_record[third_party_beneficiary_name]">
                </div>
            </div>
            <div class="form-group row section-edit-vendor-address">
                <div class="col-lg-12">
                    <label>Beneficiary Address: [Building/Street, City, State/Province + Postal Code, Country]</label>
                    <textarea disabled rows="3" class="edit-vendor-address form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Bank Name</label>
                    <input type="text" disabled class="edit-bank-name form-control" name="edit_record[third_party_bank_name]">
                </div>
                <div class="col-lg-6">
                    <label>Account Number</label>
                    <input type="text" disabled class="edit-account-number form-control" name="edit_record[third_party_account_number]">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Bank Address: [Building/Street, City, State/Province + Postal Code, Country]</label>
                    <textarea disabled rows="3" class="edit-bank-address form-control" name="edit_record[third_party_bank_address]"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>SWIFT Code</label>
                    <input type="text" disabled class="edit-swift-code form-control" name="edit_record[third_party_swift_code]">
                </div>
                <div class="col-lg-6">
                    <label>Routing or ABA Number (for U.S. Banks)</label>
                    <input type="text" disabled class="edit-routing-number form-control" name="edit_record[third_party_routing_number]">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">Status</label>
                <select <?= is_admin() ? '' : '' ?> form="form" id="record_status" class="form-control status" name="edit_record[record_status]">
                    <option value="">-- Select Record Status --</option>
                    <?php
                    if ($record_status) {
                        foreach ($record_status as $ps) {
                            ?>
                            <option value="<?= $ps->id ?>"><?= $ps->name ?></option>
                        <?php
                            }
                        }
                        ?>
                </select>
            </div>
            <div class="col-lg-6">
                <label>Proof of Conversion</label>
                <?php 
                    $hide_upload_conversion = 'hide';
                    if (has_permission('payment_record', 'upload_proof_of_conversion')) {
                        $hide_upload_conversion = '';
                    }
                ?>
                <div class="<?php echo $hide_upload_conversion; ?>">
                    <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_conversion; ?>" type="button" onclick="remove_file(this, 'conversion'); return false;"><i class="fa fa-times"></i></button>
                    <input type="file" data-modal="mdl_add_record" id="proof-of-conversion" name="proof_of_conversion">
                    <small class="file-for-testing">File Size Max 5MB</small>
                </div>
                <div id="preview-edit-uploaded-conversion-grant" class="conversion-file">
                    <a onclick="return false;" id="conversion-preview-file" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <label>Grantee</label>
                    <select class="form-control select2 select-grantee" name="edit_record[user_grantee_id]">
                        <option value="0">Select Grantee</option>
                        <?php foreach($user_grantee as $grantee) { ?>
                            <option value="<?php echo $grantee->user_id; ?>"><?php echo get_full_name($grantee, $grantee->country_id == AMERICAN_DATABASE ? 'US' : 'ID'); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group select-category-section" style="margin-top: 170px !important;">
                <div class="col-lg-12">
                    <label>Payment Category</label>
                    <select id="category_non_grantee_edit" class="form-control select2 select-category" onchange="edit_item_record(0, true)" name="edit_record[category_id]">
                        <option value="">Select Payment Category</option>
                        <?php foreach($payment_item_categories as $category) { ?>
                            <option value="<?php echo $category->category_type; ?>"><?php echo $category->category_type; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET INFORMATION</p>
        <div id="wrap-request-record-edit0">
        </div>
        <div class="form-group">
            <a href="javascript:;" onclick="edit_item_record(0)" class="btn btn-primary" style="margin-top:24px;"><i class="fa fa-plus fa-fw"></i> Add Item</a>
            <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-record-edit" style="display:none;">
        </div>
        <div class="form-group">
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">Note From Finance</label>
                <textarea type="text" form="form" id="finance_note" <?= is_admin() ? '' : '' ?> class="form-control" name="edit_record[finance_note]" placeholder="Note From Finance"></textarea>
            </div>
            <?php 
                $hide_upload_transfer = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                    $hide_upload_transfer = '';
                }
            ?>
            <div class="col-lg-6">
                <label>Proof of Transfer</label>
                <div class="<?php echo $hide_upload_transfer; ?>">
                    <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this, 'transfer'); return false;"><i class="fa fa-times"></i></button>
                    <input type="file" onchange="update_to_release(this)" data-modal="mdl_edit_record" id="proof-of-transfer" name="proof_record">
                    <small class="file-for-testing">File Size Max 5MB</small>
                </div>
                <div id="preview-edit-uploaded-transfer-grant" class="transfer-file">
                    <a onclick="return false;" id="transfer-preview-file" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button class="btn-submit-record-disabled btn btn-success hide" disabled>Saving Data...</button>
        <button type="submit" id="btn-submit-record-edit" name="btn" value="edit_rec" class="btn btn-success">Save</button>
        <input id="hide-btn-edit" type="hidden" disabled="disabled" name="btn" value="edit_rec">
        <input id="hide-total-payment-record" type="hidden" name="total_paymen_record" form="form" value="">
      </div>
    </div>
  </div>
</div>


<?php //$this->load->view('admin/partials/modal_bulk_payment_grant_us')?>
<?php $this->load->view('admin/partials/modal_bulk_payment_grant_us_v2')?>
<?php $this->load->view('admin/partials/modal_bulk_payment_non_grantee')?>
<?php $this->load->view('admin/partials/modal_bulk_payment_support')?>
<?php $this->load->view('admin/partials/modal_add_subcategory')?>
<?php $this->load->view('admin/partials/modal_add_payment_item')?>



<?php 
if(!empty($payment_record)):
$final_record = [];
foreach($payment_record as $record){
    $final_record[$record->id] = $record;
}
?>
<script>
    var currentPaymentGrant = JSON.parse(`<?php echo safe_parse_json(json_encode($final_record)); ?>`);
</script>
<?php endif; ?>

<?php if(!empty($payment_item)): ?>
<script>
    var currentPaymentItemsGrant = JSON.parse(`<?php echo safe_parse_json(json_encode($payment_item)); ?>`);
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

    <script>
        var currentPaymentProofOfExpenses = JSON.parse(`<?php echo safe_parse_json(json_encode($proof_of_expenses)); ?>`);
    </script>
<?php endif; ?>