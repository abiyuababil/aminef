<?php

$active_country = $this->session->userdata('active_country');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$tab_active = '';
$content_active = '';

if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';

    $tab_active = 'class="active"';
    $content_active = 'active in';
}

$all_total_payment = 0;
$total_schedule = $total_record = $total_travel =[];
foreach ($grantee_payment as $key => $payment) {
	array_push($total_schedule, $payment['total_nominal']);
}
foreach ($payment_record as $key => $payment) {
	array_push($total_record, $payment->total_nominal);
}
foreach ($payment_travel as $key => $travel) {
	array_push($total_travel, $travel->total_nominal);
}
$all_total_schedule = array_sum($total_schedule);
$all_total_record = array_sum($total_record);
$all_total_travel = array_sum($total_travel);
$all_total_payment = $all_total_schedule;
$all_total_payment_record = $all_total_record;
$all_total_payment_travel = $all_total_travel;
?>

<style>
    
    #success-alert{
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display:none;
    }

    .datepicker{
        background-color:#fff !important;
    }
</style>

<div class="alert alert-success" id="success-alert" style="width:200px">
  <button type="button" class="close" data-dismiss="alert">x</button>
  Autosave <strong>Success! </strong>
</div>

<div class="row">
    <div class="col-lg-12">
        <!-- <a href="<?= base_url()?>admin/request_payment/print/<?= $this->Grantee_ent_model->id ?>" target="_blank" class="btn btn-info" style="float:right;margin: 20px 0;">Download PDF</a> -->
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
</div>


<form id="frm_manage" method="GET"></form>
<form id="frm_manage_travel" method="GET"></form>
<input type="hidden" value="<?= $this->Grantee_ent_model->id ?>" id="user_id">
<input type="hidden" value="<?= $grantee_grant_id ?>" id="grantee_grant_id">
<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <input type="hidden" value="<?= !empty($last_idx->temp_id) ? ($last_idx->temp_id) : 1 ?>" id="last_payment">
            <div class="panel-body" style="margin-top:-20px;">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant</label>
                        <input type="text" disabled="disabled" class="form-control" name="grant" placeholder="Grant" value="<?= $grantee_grant->grant_name?>">
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
            <div class="panel-body" style="margin-top:-30px">
                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET INFORMATION</p>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant Cost Total</label>
                        <input type="text" disabled="disabled" class="form-control" name="grant_total" placeholder="Grant Cost Total" value="$ <?= $grantee_grant->total_grant ? number_format($grantee_grant->total_grant) : 0 ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant Cost Payment</label>
                        <input type="text" disabled="disabled" class="form-control" name="grant_total" placeholder="Grant Cost Payment" value="$ <?= number_format($all_total_payment) ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant Cost Balance</label>
                        <?php 
                            $remaining = $grantee_grant->total_grant - $all_total_payment;
                        ?>
                        <input type="text" disabled="disabled" class="form-control" name="remaining" placeholder="Grant Cost Balance" value="$ <?= number_format($remaining)?>">
                        <input type="hidden" id="all_total_record" name="all_total_record" value="<?= $all_total_record ?>">
                        <input type="hidden" id="all_total_schedule" name="all_total_schedule" value="<?= $all_total_schedule ?>">
                    </div>  
                </div>
            </div>
            <div class="panel-body" style="margin-top:-20px">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant Support Total</label>
                        <input type="text" disabled="disabled" class="form-control" name="grant_total" placeholder="Grant Support Total" value="$ <?= $grantee_grant->grant_support ? number_format($grantee_grant->grant_support) : 0 ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant Support Payment</label>
                        <input type="text" disabled="disabled" class="form-control" name="grant_total" placeholder="Grant Support Payment" value="$ <?= number_format($all_total_payment_record) ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant Support Balance</label>
                        <?php 
                            $remaining_support = $grantee_grant->grant_support - $all_total_payment_record;
                        ?>
                        <input type="text" disabled="disabled" class="form-control" name="remaining" placeholder="Grant Support Balance" value="$ <?= number_format($remaining_support)?>">
                    </div>  
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>International Travel Total</label>
                        <input type="text" disabled="disabled" class="form-control" name="grant_total" placeholder="International Travel Total" value="$ <?= $grantee_grant->international_travel ? number_format($grantee_grant->international_travel) : 0 ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>International Travel Payment</label>
                        <input type="text" disabled="disabled" class="form-control" name="grant_total" placeholder="International Travel Payment" value="$ <?= number_format($all_total_payment_travel) ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>International Travel Balance</label>
                        <?php 
                            $remaining_travel = $grantee_grant->international_travel - $all_total_payment_travel;
                        ?>
                        <input type="text" disabled="disabled" class="form-control" name="remaining" placeholder="International Travel Balance" value="$ <?= number_format($remaining_travel)?>">
                    </div>  
                </div>

                <!-- Grand Total -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Total</label>
                        <input type="text" disabled="disabled" class="form-control" name="total" placeholder="Total" value="<?= '$ ' . number_format($grantee_grant->total_grant+$grantee_grant->grant_support+$grantee_grant->international_travel) ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Total Payment</label>
                        <input type="text" disabled="disabled" class="form-control" name="total_payment" placeholder="Total Payment" value="<?= '$ ' . number_format($all_total_payment+$all_total_payment_record+$all_total_payment_travel) ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Total Balance</label>
                        <input type="text" disabled="disabled" class="form-control" name="total_balance" placeholder="Total Balance" value="<?= '$ ' . number_format($remaining+$remaining_support+$remaining_travel) ?>">
                    </div>
                </div>
            </div>
            <div class="panel-body" style="margin-top:-30px">
                <div class="row">
                    <p class="col-lg-2" style="display: initial;font-weight:bold;margin-bottom:25px;width: auto;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BANK INFORMATION </p>
                    <div style="display: -webkit-box;"><p style="width: 90%;height: 1px;background-color: black;/* display: inline-block; */margin: 35px 10px;/* vertical-align: middle; */">&nbsp;</p><div style="margin-top: 26px;"><a href="javascript:void(0)" style="text-decoration: none;height: auto;" id="show_hide_bank" value="0"><i class="fa fa-eye"></i> Show</a></div></div>
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
                            <?php if($this->Grantee_ent_model->account_book != ''){?>
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
            
            <ul class="nav nav-pills mb-5">
                <li <?php echo $default_tab_active ?>><a data-toggle="tab" href="#schedule" aria-expanded="true">Payment Schedule</a></li>
                <li <?= $pid == 'travel' ? 'class="active"' : '' ?>><a data-toggle="tab" href="#travel" aria-expanded="true">International Travel</a></li>
                <li <?= $pid == 'support' ? 'class="active"' : '' ?>><a data-toggle="tab" href="#record" aria-expanded="true">Grant Support</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div id="schedule" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div id="wrap-payment">
                                <?php if($grantee_payment) { 
                                    foreach ($grantee_payment as $key => $row) {
                                            $del_btn ='';
                                        ?>
                                        <div id="payment-item-<?= $key ?>'" class="payment-item">
                                            <?php if($key > 0) { ?>
                                            <hr style="margin-top:0; border-color:gray;">
                                            <?php } ?>
                                            <?php 
                                                $prefix = 'th';
                                                if(($key+1) == 1){
                                                    $prefix = 'st';
                                                }else if(($key+1) == 2){
                                                    $prefix = 'nd';
                                                }else if(($key+1) == 3){
                                                    $prefix = 'rd';
                                                }
                                            ?>
                                            <div class="panel-body">
                                                <h1 id="payment_label" style="margin-top:-20px"><?= $key+1 ?><?= $prefix ?> Disbursement <?= $del_btn ?></h1>
                                                <input type="hidden" name="payment[<?= $key ?>][payment_name]" value="<?= $row['payment_name'] ?>">
                                                <input type="hidden" name="payment[<?= $key ?>][order]" value="<?= $row['order_payment'] ?>">
                                                <input type="hidden" name="payment[<?= $key ?>][temp_id]" value="<?= $row['temp_id'] ?>">
                                                <input type="hidden" id="delete_temp_<?= $key ?>" name="payment[<?= $key ?>][delete_detail_temp_id]">
                                                <?php if($row['id']) { ?>
                                                    <input type="hidden" name="payment[<?= $key ?>][payment_id]" value="<?= $row['id'] ?>">
                                                <?php } ?>
                                            </div>
                                            <div class="panel-body" style="margin-top:-30px">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Date Period</label>
                                                        <input autocomplete="new-password" disabled type="text" class="form-control datepicker" name="payment[<?= $key ?>][from_date]" placeholder="Date Period" value="<?php echo ($row['from_date']) ? date('d M Y', strtotime($row['from_date'])) : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>To</label>
                                                        <input autocomplete="new-password" disabled type="text" class="form-control datepicker" name="payment[<?= $key ?>][to_date]" placeholder="To" value="<?php echo ($row['to_date']) ? date('d M Y', strtotime($row['to_date'])) : '' ?>">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Release Type</label>
                                                        <select disabled class="form-control" name="payment[<?= $key ?>][method]">
                                                            <option value="">-- Select Release Type --</option>
                                                            <option value="Manual" <?= $row['method'] == 'Manual' ? 'selected="selected"' : '' ?>>Manual</option>
                                                            <option value="MRI" <?= $row['method'] == 'MRI' ? 'selected="selected"' : '' ?>>MRI</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="panel-body" style="margin-top:-30px">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>To be Release</label>
                                                        <input autocomplete="new-password" disabled type="text" class="form-control datepicker" name="payment[<?= $key ?>][toberelease_date]" placeholder="To be Release" value="<?php echo ($row['toberelease_date']) ? date('d M Y', strtotime($row['toberelease_date'])) : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>To be Released Note</label>
                                                        <textarea disabled class="form-control" rows="2" name="payment[<?= $key ?>][release_note]"><?= $row['release_note'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Payment Status</label>
                                                        <select disabled <?= is_admin() ? '' : '' ?> class="form-control" name="payment[<?= $key ?>][payment_status]">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body" style="margin-top:-30px">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Released Date</label>
                                                        <input autocomplete="new-password" disabled type="text" <?= is_admin() ? '' : '' ?> class="form-control datepicker" name="payment[<?= $key ?>][release_date]" placeholder="Release Date" value="<?php echo ($row['release_date']) ? date('d M Y', strtotime($row['release_date'])) : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Total Nominal Item</label>
                                                        <input type="text" class="form-control" readonly placeholder="Total Payment Item" value="<?= $row['total_nominal']?>">
                                                    </div>
                                                </div>
                                                <?php if ($this->session->userdata('role') == 'finance') { ?>
                                                <div class="col-lg-4">
                                                    <div class="custom-file">
                                                        <label class="custom-file-label">Proof of Transfer</label>
                                                        <input style="display:<?= is_admin() ? 'none': 'block' ?>" type="file" class="custom-file-input" id="proof" name="proof|<?= $row['id']?>">
                                                        <?php if ($row['proof'] != '') { ?>
                                                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                <a href="<?php echo base_url() ?><?php echo $row['proof'] ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php }else{ ?>
                                                    <?php if($row['proof'] != '') {?>
                                                        <div class="col-lg-4">
                                                            <div class="custom-file">
                                                                <label class="custom-file-label">Proof of Transfer</label>
                                                                <input style="display:<?= is_admin() ? 'none': 'block' ?>" type="file" class="custom-file-input" id="proof" name="proof|<?= $row['id']?>">
                                                                <?php if ($row['proof'] != '') { ?>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                        <a href="<?php echo base_url() ?><?php echo $row['proof'] ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="panel-body" style="margin-top:-30px">
                                                <p style="font-weight:bold;margin-bottom:20px;"><i class="fa fa-circle mt-4" style="color:#4da6ff;margin-right:5px;"></i> PAYMENT ITEMS</p>
                                                <div id="wrap-request<?= $key ?>">
                                                    <?php if($row['items']) { 
                                                        foreach ($row['items'] as $num => $value) {
                                                            $btn_del = '';
                                                            ?>

                                                        <div id="request-item-<?= $num ?>'" class="row mt-3 request-item<?= $key ?>">
                                                            <div class="col-lg-12" style="background-color:#e9eef4;padding:10px 10px 0 10px;">
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Payment Sub Category</label>
                                                                        <input type="text" readonly class="form-control" value="<?= $value['sub_category_name'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Payment Item</label>
                                                                        <input type="hidden" name="payment[<?= $key ?>][items][<?= $num ?>][temp_id]" value="<?= $value['temp_id']?>">
                                                                        <input type="text" readonly class="form-control" value="<?= $value['payment_item'] ?>">
                                                                        <input type="hidden" class="form-control" name="payment[<?= $key ?>][items][<?= $num ?>][item]" value="<?= $value['item_name'] ?>">

                                                                        <?php if($value['id']) { ?>
                                                                            <input type="hidden" name="payment[<?= $key ?>][items][<?= $num ?>][detail_payment_id]" value="<?= $value['id'] ?>">
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Nominal USD</label>
                                                                        <input type="number" readonly class="form-control" name="payment[<?= $key ?>][items][<?= $num ?>][nominal]" value="<?= $value['nominal']?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?= $btn_del ?>
                                                        </div>
                                                    <?php }} ?>
                                                </div>
                                            </div>
                                        </div>
                                <?php }} ?>
                            </div>
                            <div class="panel-body" style="padding-top: 0;">
								<hr style="margin-top:0; border-color:gray;">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Note from Admin</label>
                                        <textarea disabled class="form-control" <?= $this->session->userdata('role') == 'finance' ? '' : '' ?> rows="4" name="admin_note"><?= $grantee_payment[0]['admin_note']?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Note from Finance</label>
                                        <textarea disabled class="form-control" <?= is_admin() ? '' : '' ?> rows="4" name="finance_note"><?= $grantee_payment[0]['finance_note']?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                        Search : <input type="search" class="form-control input-sm" form="frm_manage_travel" name="search" value="<?= $paging['search'] ?>" placeholder="">
                                    
                                        Status : 
                                        <select class="form-control input-sm" name="status" form="frm_manage_travel" onchange="document.forms.frm_manage_travel.submit()">
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
                                        <select class="form-control input-sm" name="year" form="frm_manage_travel" onchange="document.forms.frm_manage_travel.submit()">
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
                                        <select class="form-control input-sm" name="limit" form="frm_manage_travel" onchange="document.forms.frm_manage_travel.submit()">
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
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th>Payment Date</th>
                                                <th>Description</th>
                                                <th>Total Payment</th>
                                                <th>Proof of Transfer</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($payment_travel)
                                        {
                                            $no = $paging['start_row'];
                                            foreach($payment_travel as $row) {
                                            ?>
                                            <tr>
                                                <td><?= $no+1 ?></td>
                                                <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                <td><?= $row->description ?></td>
                                                <td>
                                                    <?php 
                                                        $total_payment = [];
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment, $item->nominal);
                                                        }
                                                    ?>
                                                    $<?= number_format(array_sum($total_payment))?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($row->proof)) { ?>
                                                    <a href="<?php echo base_url($row->proof) ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $row->payment_status ?></td>
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
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th>Payment Date</th>
                                                <th>Description</th>
                                                <th>Total Payment</th>
                                                <th>Proof of Transfer</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($payment_record)
                                        {
                                            $no = $paging['start_row'];
                                            foreach($payment_record as $row) {
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                <td><?= $row->description ?></td>
                                                <td>
                                                    <?php 
                                                        $total_payment = [];
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment, $item->nominal);
                                                        }
                                                    ?>
                                                    $<?= number_format(array_sum($total_payment))?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($row->proof)) { ?>
                                                    <a href="<?php echo base_url($row->proof) ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $row->payment_status ?></td>
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
</form>