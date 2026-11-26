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


$cost = $periods[$user_program[0]->period_id];
$all_grant_cost_total_payment =  array_sum($total_record_grant_cost);
$all_grant_supporting_total_payment = array_sum($total_record_grant_supporting);
$all_international_travel_total_payment = array_sum($total_record_international_travel);
$url_bulk = site_url('admin/user_grantee_grant/edit_period/'.$cost->user_grantee_grant_id.'/'.$cost->id.'?pid=payment_grantee');



?>

<style>
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
</style>

<div class="row">
    <div class="col-lg-12">
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
<?php }  $this->session->unset_userdata('notif_payment');?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>
<input type="hidden" id="url_bulk" value="<?= $url_bulk ?>" >

<form id="frm_manage" method="GET"></form>
<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
        <div class="panel-body" style="margin-top:15px;">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant</label>
                        <input type="text" disabled="disabled" class="form-control" name="grant" placeholder="Grant" value="<?= $programs[$user_program[0]->grant_id]->name ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>Period From</label>
                        <input type="text" disabled="disabled" class="form-control" name="periode_from" placeholder="Period From" value="<?= ($cost->start_date) ? date('d M Y', strtotime($cost->start_date)) : '' ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>Period To</label>
                        <input type="text" disabled="disabled" class="form-control" name="periode_to" placeholder="Period To" value="<?= ($cost->end_date) ? date('d M Y', strtotime($cost->end_date)) : '' ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>Academic Year</label>
                        <input type="text" disabled="disabled" class="form-control" name="fisccal" placeholder="Fiscal Year" value="<?= $cost->fiscal_year ?>">
                    </div>
                </div>
            </div>
            <div class="panel-body" style="margin-top:-20px">
                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> 
                    BUDGET INFORMATION
                    <a target="_blank" href="<?= site_url('admin/grantee/setting/' . $grantee_grant_id); ?>" class="btn btn-primary btn-sm"><span class="fa fa-gear"></span> Edit Budget</a href="<?= site_url('admin/grantee/setting/' . $grantee_grant_id); ?>">
                </p>
                <!-- grant Cost -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant Allocation</label>
                        <?php if($grantee_setting->is_unlimited_grant_total == TRUE) { ?>
                            <input type="text" disabled="disabled" class="form-control" name="grant_cost_total" placeholder="Grant Cost Total" value="Unlimited">
                        <?php }else{ ?>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="grant_cost_total" class="form-control currency-usd" value="<?= isset($setting->total_grant) && is_numeric($setting->total_grant) ? ($setting->total_grant) : 0 ?>">
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Actual Grant Cost</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="grant_cost_total_payment" class="form-control currency-usd" value="<?= isset($all_grant_cost_total_payment) && is_numeric($all_grant_cost_total_payment) ? ($all_grant_cost_total_payment) : "" ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grant Cost Balance</label>
                        <?php
                        $remaining_total = $grantee_setting->is_unlimited_grant_total ? 'Unlimited' : abs($setting->total_grant - $all_grant_cost_total_payment);
                        ?>
                        <?php
                        if ($grantee_setting->is_unlimited_grant_total == TRUE) { ?>
                            <input type="text" disabled="disabled" class="form-control" name="remaining" placeholder="Remaining" value="Unlimited">
                        <?php } else { ?>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="grant_cost_total_payment" class="form-control currency-usd" value="<?= isset($remaining_total) && is_numeric($remaining_total) ? ($remaining_total) : "" ?>">
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Grant Supporting -->
                <div class="col-lg-12" style="padding: 0px;">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Grant Supporting Allocation</label>
                            <?php if($grantee_setting->is_unlimited_grant_support == TRUE) { ?>
                                <input type="text" disabled="disabled" class="form-control" name="grant_supporting_total" placeholder="Grant Cost Total" value="Unlimited">
                            <?php }else{ ?>
                                <div class="input-group">
                                    <div class="input-group-addon">USD</div>
                                    <input disabled style="z-index: 0" type="text" name="grant_supporting_total" class="form-control currency-usd" value="<?= isset($setting->grant_support) && is_numeric($setting->grant_support) ? ($setting->grant_support) : "" ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Actual Grant Supporting</label>
                            <div class="input-group">
                                <div class="input-group-addon">USD</div>
                                <input disabled style="z-index: 0" type="text" name="grant_supporting_total_payment" class="form-control currency-usd" value="<?= isset($all_grant_supporting_total_payment) && is_numeric($all_grant_supporting_total_payment) ? ($all_grant_supporting_total_payment) : "" ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Grant Supporting Balance</label>
                            <?php
                                $remaining_support = $grantee_setting->is_unlimited_grant_support ? "Unlimited" : abs($setting->grant_support - $all_grant_supporting_total_payment);
                            ?>
                            <?php
                            if ($grantee_setting->is_unlimited_grant_support == TRUE) { ?>
                                <input type="text" disabled="disabled" class="form-control" name="remaining" placeholder="Remaining" value="Unlimited">
                            <?php } else { ?>
                            <div class="input-group">
                                <div class="input-group-addon">USD</div>
                                <input disabled style="z-index: 0" type="text" name="remaining" class="form-control currency-usd" value="<?= $remaining_support ?>">
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- international transpost total -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>International Travel Allocation</label>
                        <?php if($grantee_setting->is_unlimited_international_travel == TRUE) { ?>
                            <input type="text" disabled="disabled" class="form-control" name="international_travel_total" placeholder="Grant Cost Total" value="Unlimited">
                        <?php }else{ ?>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="international_travel_total" class="form-control currency-usd" value="<?= isset($setting->international_travel) && is_numeric($setting->international_travel) ? ($setting->international_travel) : "" ?>">
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Actual International Travel</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="international_travel_total" class="form-control currency-usd" value="<?= isset($all_international_travel_total_payment) && is_numeric($all_international_travel_total_payment) ? ($all_international_travel_total_payment) : "" ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>International Travel Balance</label>
                            <?php
                            $remaining_international_travel = $grantee_setting->is_unlimited_international_travel ? 'Unlimited' : $setting->international_travel - $all_international_travel_total_payment;
                            ?>
                        <?php
                        if ($grantee_setting->is_unlimited_international_travel == TRUE) { ?>
                            <input type="text" disabled="disabled" class="form-control" name="remaining" placeholder="Remaining" value="Unlimited">
                        <?php } else { ?>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input disabled style="z-index: 0" type="text" name="remaining" class="form-control currency-usd" value="<?= isset($remaining_international_travel) && is_numeric($remaining_international_travel) ? ($remaining_international_travel) : "" ?>">
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Grand Total -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Total Allocation</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input 
                                disabled 
                                style="z-index: 0" 
                                type="text" 
                                name="total" 
                                class="form-control currency-usd" 
                                value="<?= 
                                    (($setting->total_grant) + 
                                    ($setting->grant_support) + 
                                    ($setting->international_travel)) 
                                    ?>"
                            >
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Total Actual</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <input 
                                disabled 
                                style="z-index: 0" 
                                type="text" 
                                name="total_payment" 
                                class="form-control currency-usd" 
                                value="<?= 
                                    ($all_grant_cost_total_payment + 
                                    $all_grant_supporting_total_payment + 
                                    $all_international_travel_total_payment) 
                                    ?>"
                            >
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Total Balance</label>
                        <div class="input-group">
                            <div class="input-group-addon">USD</div>
                            <?php
                                $total = 0;
                                if (is_numeric($remaining_total)) {
                                    $total += $remaining_total;
                                }

                                if (is_numeric($remaining_support)) {
                                    $total += $remaining_support;
                                }

                                if (is_numeric($remaining_international_travel)) {
                                    $total += $remaining_international_travel;
                                }
                            ?>
                            <input 
                                disabled 
                                style="z-index: 0" 
                                type="text" 
                                name="total_balance" 
                                class="form-control currency-usd" 
                                value="<?= $total; ?>"
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body" style="margin-top:-30px">
                <div class="row">
                    <p class="col-lg-2" style="display: initial;font-weight:bold;margin-bottom:25px;width: auto;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BANK INFORMATION </p>
                    <div style="display: -webkit-box;"><p style="width: 90%;height: 1px;background-color: black;/* display: inline-block; */margin: 35px 10px;/* vertical-align: middle; */">&nbsp;</p><div style="margin-top: 26px;"><a href="javascript:void(0)" style="text-decoration: none;height: auto;" id="show_hide_bank" value="0"><i class="fa fa-eye"></i> Show</a></div></div>
                </div>    
                <div id="tab_bank" style="display:none">
                    <?php if($bank_info) { ?>
                    <?php foreach($bank_info as $kb =>  $bank) : ?>
                    <div class="row">
                        <?= $kb > 0 ? '<hr>' : '' ?>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Beneficiary Name</label>
                                <input type="text" disabled="disabled" class="form-control" name="beneficiary_name" placeholder="Beneficiary Name" value="<?= $bank->beneficiary_name ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" disabled="disabled" class="form-control" name="bank_name" placeholder="Name of Bank" value="<?= $bank->bank_name ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Branch Office</label>
                                <input type="text" disabled="disabled" class="form-control" name="bank_address" placeholder="Address of Bank" value="<?= $bank->bank_address ?>">
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" disabled="disabled" class="form-control" name="account_number" placeholder="Account Number" value="<?= $bank->account_number ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Currency</label>
                                <input type="text" disabled="disabled" class="form-control" name="currency" placeholder="Currency" value="<?= $bank->currency ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Swift Code</label>
                                <input type="text" disabled="disabled" class="form-control" name="swift_code" placeholder="Swift Code" value="<?= $bank->swift_code ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Routing Number</label>
                                <input type="text" disabled="disabled" class="form-control" name="routing_number" placeholder="Routing Number" value="<?= $bank->routing_number ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Account Book</label>
                                <?php if($bank->account_book != ''){?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo base_url() ?><?php echo $bank->account_book ?>" class="lightbox btn btn-primary" aria-haspopup="dialog">View</a>
                                    </div>
                                <?php } else { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">-</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php }else { ?>
                    <p class="text-danger">This person haven't add their bank account yet.</p>  
                    <?php } ?>
                </div>
            </div>

            <ul class="nav nav-pills mb-5">
                <li class="active"><a data-toggle="tab" href="#record" aria-expanded="true">Payment Record</a></li>
            </ul>
        </div>
        <div class="tab-content">

            <div id="record" class="tab-pane fade active in">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-left">
                                        Search : <input type="search" class="form-control input-sm" form="frm_manage" name="search" value="<?= $paging['search'] ?>" placeholder="Description">

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
                                        
                                        Category :
                                        <select class="form-control input-sm" name="category" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <option value="">-- Select Category --</option>
                                            <option <?php echo $paging['category'] == 'Grant Cost' ? 'selected' : ''; ?> value="Grant Cost">Grant Cost</option>
                                            <option <?php echo $paging['category'] == 'Grant Supporting' ? 'selected' : ''; ?> value="Grant Supporting">Grant Supporting</option>
                                            <option <?php echo $paging['category'] == 'International Travel' ? 'selected' : ''; ?> value="International Travel">International Travel</option>
                                        </select>

                                        Sub Category :
                                        <select class="form-control input-sm" name="sub_category" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <option value="">-- Select Sub Category --</option>
                                            <?php foreach ($sub_category as  $sub_category) {
                                                echo "<option ".($sub_category->id == $paging['sub_category'] ? 'selected' : '')." value='".$sub_category->id."' >".$sub_category->name."</option>";
                                            }; ?>
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

                                        <br />
                                        <br />
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
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record" <?php echo $disabled; ?> class="<?php echo $disabled; ?> btn btn-success btn-sm "  id="btn-add">
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
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Payment Item</th>
                                                <!-- <th>Sub Category</th> -->
                                                <!-- <th>Description</th> -->
                                                <th>Total Payment (IDR)</th>
                                                <th>Total Payment (USD)</th>
                                                <th>Proof Of Transfer</th>
                                                <th>Status</th>
                                                <th width="150" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($payment_record) {
                                                $no = $paging['start_row'];
                                                foreach ($payment_record as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                        <td><?php echo $row->category; ?></td>
                                                        <td><?php echo $row->sub_category_name; ?></td>
                                                        <!-- <td><?php echo $row->description; ?></td> -->
                                                        <td>
                                                            <ul style="margin-left: -25px;">
                                                            <?php foreach ($row->items as $key => $item) { ?>
                                                                <li><?= $item->item_name ?></li>
                                                            <?php } ?>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                $total_payment_idr = [];
                                                                $nominal_idr = '';
                                                                $nominal_idr .= '<ul style="margin-left: -25px;">';
                                                                foreach ($row->items as $key => $item) {
                                                                    array_push($total_payment_idr, $item->nominal_idr);
                                                                    $nominal_idr .= '<li>'.format_money($item->nominal_idr, 'IDR').'</li>';
                                                                }
                                                                $nominal_idr .= '</ul>';
                                                            ?>
                                                            <?= $nominal_idr ?>
                                                            <b><u>Total : <?= format_money(array_sum($total_payment_idr), 'IDR')?></u></b>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                $total_payment = [];
                                                                $nominal = '';
                                                                $nominal .= '<ul style="margin-left: -25px;">';
                                                                foreach ($row->items as $key => $item) {
                                                                    array_push($total_payment, $item->nominal);
                                                                    $nominal .= '<li>'.format_money($item->nominal, 'USD').'</li>';
                                                                }
                                                                $nominal .= '</ul>';
                                                            ?>
                                                            <?= $nominal ?>
                                                            <b><u>Total : <?= format_money(array_sum($total_payment), 'USD')?></u></b>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($row->proof)) { ?>
                                                                <a href="<?php echo base_url($row->proof) ?>" class="lightbox"><label class="label label-primary" style="cursor:pointer">View Proof Of Transfer</label></a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $row->payment_status ?></td>
                                                        <td class="text-center">
                                                            <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-mode="view" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>
                                                            <?php if($row->bulk_id): ?>
                                                                <a href="<?= $url_bulk . '&open_modal=1&record_id=' . $row->bulk_id ?>" target="_blank" class="btn btn-primary btn-xs <?php echo $disabled; ?>"><i class="fa fa-edit"></i> Edit</a>
                                                            <?php else : ?>
                                                                <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-mode="edit" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs <?php echo $disabled; ?>">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            <?php endif; ?>
                                                            <a href="<?= site_url('admin/request_payment/delete_record/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del <?php echo $disabled; ?>">
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
        <input type="hidden" name="total_grant_cost_payment" value="<?= $all_grant_cost_total_payment ?>">
        <input type="hidden" name="total_international_travel_payment" value="<?= $all_international_travel_total_payment ?>">
        <input type="hidden" name="total_grant_cost" value="<?= $setting->total_grant ?>">
        <input type="hidden" name="total_international_travel" value="<?= $setting->international_travel ?>">
        <input type="hidden" name="is_unlimited_grant_cost" value="<?= $cost->is_unlimited_grant_cost ?>">
        <input type="hidden" name="is_unlimited_grant_supporting" value="<?= $cost->is_unlimited_grant_supporting ?>">
        <input type="hidden" name="is_unlimited_international_travel" value="<?= $cost->is_unlimited_international_travel ?>">
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

<?php $this->load->view('admin/request_payment/modal_payment_log'); ?>
<?php $this->load->view('admin/partials/modal_add_payment_record') ?>
<?php $this->load->view('admin/partials/modal_edit_payment_record') ?>
<?php //$this->load->view('admin/partials/modal_payment_indo_old') ?>

<div class="modal fade text-center" id="mdl_detail_log" tabindex="-1" role="dialog" >
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
if (!empty($payment_item)) :
    $final_item = [];
    foreach ($payment_item as $row) {
        $final_item[] = $row;
    }
?>
    <script>
        var currentPaymentItems = JSON.parse(`<?php echo safe_parse_json(json_encode($final_item)); ?>`);
    </script>
<?php endif; ?>