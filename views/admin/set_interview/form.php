<style>
    .table-primary {
        background-color : #d6d8db;
    }

    .detail-rank {
        padding: 0px;
        margin: 0px;
    }

    .detail-rank > li {
        list-style: none;
        padding: 0px;
    }

    .TriSea-technologies-Switch > input[type="checkbox"] {
        display: none;   
    }

    .TriSea-technologies-Switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .TriSea-technologies-Switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .TriSea-technologies-Switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
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
</style>
<div class="row">
    <div class="col-lg-12">
        <h1><?=$title ?></h1>
        <h3 class="page-header"><?=$active_grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>
<?php
$disabled_form = !has_permission('selection', 'interview') ? 'disabled' : '';
?>
<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>
<form id="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="section" value="interview_selection_status">
    <input type="hidden" name="delete_interview" id="delete_interview">
    <?php if(has_permission('selection', 'interview')) { ?>
    <div class="row">
        <div class="panel-body" style="margin-top:-20px">
        <?php foreach ($test_type as $item) { ?>
        <div class="col-lg-3">
            <table class="table table-bordered">
                <tr>
                    <td width="30%" class="table-primary">Test Type</td>
                    <td><?= get_test_type_name($item['test_type_value']) ?></td>
                </tr>
                <tr>
                    <td class="table-primary">Score</td>
                    <td><?= $item['input_value'] ?></td>
                </tr>
            </table>
        </div>
        <?php } ?>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <?php $this->load->view('admin/set_interview/form_section_interview') ?>

        <?php if(has_permission('selection', 'interview')) { ?>
        <div class="panel-body" style="margin-top:-20px">
            <div class="col-lg-12">
                <a href="javascript:;" onclick="add_interview()" class="btn btn-primary">
                    <i class="fa fa-plus fa-fw"></i> Add New
                </a>
                <img src="<?=base_url() ?>/img/loading.gif" class="add-load" style="display:none;">
            </div>
        </div>
        <?php } ?>

        <div class="panel-body">
            <hr>
            <!-- <div class="col-lg-4">
                <div class="form-group">
                    <label>Scoring sheet</label>
                    <?php if ($grantee_grant->scoring_sheet_interview != '') { ?>
                        <div style="margin-bottom:10px; position:relative; width:100px;">
                            <a href="<?=base_url() ?><?=$grantee_grant->scoring_sheet_interview ?>" class="lightbox" target="_blank"><label class="btn btn-primary" style="cursor:pointer">View</label></a>
                        </div>
                    <?php } ?>
                    <input type="file" name="scoring_sheet" id="scoring_sheet_0">
                    <small class="file-for-testing">File Size Max 5MB</small>
                </div>
            </div> -->
            <?php if(has_permission('selection', 'interview')) { ?>
                <?php 
                   $params['grant_id'] = $grantee_grant->grant_id;
                   $params['period_id'] = $grantee_grant->period_id;
                   $all_data = get_grantee_by_params($params);
                   
                   $current_grantee = array_filter($all_data, function($grantee) use ($grantee_grant) {
                       return $grantee->id == $grantee_grant->id;
                   });
                   
                   $current_grantee = array_values($current_grantee);
                   
                   if (!empty($current_grantee)) {
                       $current_grantee = $current_grantee[0];
                       
                       $interview_date = $current_grantee->interview_date == null ? null : date('d M Y', strtotime($current_grantee->interview_date));
                       $daily_rank = get_grantee_rank($all_data, $current_grantee, 'score_interview', $interview_date, $grantee_grant->pic, $grantee_grant->status_interview == 'A');
                       $current_grantee->daily_rank = $daily_rank;
                       $final_rank = get_grantee_rank($all_data, $current_grantee, 'score_interview', null, null, $grantee_grant->status_interview == 'A', true);
                   } else {
                       $daily_rank = 0;
                       $final_rank = 0;
                   }
                
                ?>
                <div class="col-lg-4">
                    <div class="form-group ">
                        <label>Status</label>
                        <select name="status_interview" class="form-control" id="status_interview" data-daily_rank="<?php echo $daily_rank > 0 ? $daily_rank : 0; ?>" data-final_rank="<?php echo $final_rank > 0 ? $final_rank : 0; ?>">
                            <option value="">-- Select --</option>
                            <option <?= $grantee_grant->status_interview == 'P' ? 'selected' : '' ?> value="P">Principal</option>
                            <option <?= $grantee_grant->status_interview == 'A' ? 'selected' : '' ?> value="A">Alternate</option>
                        </select>
                        <!-- <label class="col-lg-2 col-form-label">Status</label>
                        <div class="col-lg-10">
                            <div class="radio d-inline mr-4">
                                <label>
                                    <input type="radio" 
                                    <?= $grantee_grant->status_interview == 'P' ? 'checked' : '' ?>
                                    class="grant-alumni" 
                                    <?= $disabled_form ?>
                                    name="status_interview" 
                                    style="margin-top:1px" 
                                    value="P">
                                    Principal
                                </label>
                            </div>
                            <div class="radio d-inline mr-4">
                                <label>
                                    <input type="radio" 
                                    <?= $grantee_grant->status_interview == 'A' ? 'checked' : '' ?>
                                    class="grant-alumni" 
                                    <?= $disabled_form ?>
                                    name="status_interview" 
                                    style="margin-top:1px" 
                                    value="A">
                                    Alternate
                                </label>
                            </div>
                        </div> -->
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="daily_rank_lock" id="daily_rank_lock" value="1" <?php echo $current_grantee->daily_rank_lock ? 'checked' : '';?>> Lock Rank</label>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> If the Rank is locked, it will not be affected by changes to the interview status or score updates.
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="alert alert-success">
                            <ul class="detail-rank">
                                <li>Rank : <?php echo $daily_rank > 0 ? format_daily_rank_status($current_grantee) : '-' ; ?></li>
                                <li>Final Rank : <?php echo $grantee_grant->status_interview == 'A' ? 'ALT ' . $final_rank : $final_rank; ?></li>
                            </ul>
                        </div>
                        <input type="hidden" name="daily_rank" value="<?php echo $daily_rank; ?>">
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php if(has_permission('selection', 'interview_payment')) { ?>
    <!-- table payment -->
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
                                            <option value="<?=$rs->id ?>" <?=$selected ?>><?=$rs->name ?></option>
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
                                        foreach ($limit['limit_options'] as $lo) {
                                            $selected = '';
                                            if ($lo == $paging['limit']) $selected = 'selected';
                                        ?>
                                            <option value="<?=$lo ?>" <?=$selected ?>><?=$lo ?></option>
                                        <?php } ?>
                                    </select>
                                    entries
                                </div>
                                <div class="pull-right">
                                    <a href="#" data-toggle="modal" data-target="#mdl_add_record" <?=$disabled; ?> class="<?=$disabled; ?> btn btn-success btn-sm "  id="btn-add">
                                        ADD NEW PAYMENT
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
                                            <th>Proof</th>
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
                                                    <td><?= $row->payment_date ? date('d M Y', strtotime($row->payment_date)) : '' ?></td>
                                                    <td><?=$row->description; ?></td>
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
                                                            <a href="<?=base_url($row->proof) ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof Of Transfer</label></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $row->payment_status ?></td>
                                                    <td class="text-center">
                                                        <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs <?=$disabled; ?>">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <a href="<?= site_url('admin/request_payment/delete_record/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del <?=$disabled; ?>">
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
                                Showing <?=$paging['start_row'] ?> to <?=$paging['end_row'] ?> of <?=$paging['total_rows'] ?> entries
                            </div>
                            <!-- /.pagination info -->
                            <?=$paging['html'] ?>
                            <!-- /.pagination -->
                            <input type="hidden" name="sort_by" value="<?=$sort_by ?>">
                            <input type="hidden" name="sort" value="<?=$sort ?>">
                            <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="row">
        <div class="panel-body" >
            <a href="<?= site_url('admin/interview/manage')?>" type="button" class="btn btn-default">Back </a>
            <?php if(has_permission('selection', 'interview')) { ?>
                <button type="button" name="btn" value="save_interview" onclick="submit_form(this)" class="btn btn-success pull-right">Save</button>
            <?php } else { ?>
                <button type="submit" name="btn" value="save_interview_payment" class="btn btn-success pull-right">Save</button>
            <?php } ?>
            
            <input type="hidden" id="buttonValue" name="buttonValue" value="">
            <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                <button type="submit" name="btn" value="save_send_tba" class="btn btn-primary pull-right mr-2">Save & Send Transportation</button>
                <button type="submit" name="btn" value="save_send_tba_accommodation" class="btn btn-primary pull-right mr-2">Save & Send Accommodation</button>
            <?php } ?>
            <?php if(has_permission('selection', 'interview')) { ?>
                <button type="submit" name="btn" value="sent_to_tba" class="btn btn-primary pull-right mr-2">Send Email to TBA</button>
                <button type="button" name="btn" value="save_send_interview" onclick="submit_form(this)" class="btn btn-success pull-right mr-2">Save & Send Email</button>
            <?php } ?>
            <?php if(has_permission('selection', 'reject')) { ?>
                <button type="button" name="btn" data-id="<?= $grantee_grant_id ?>" data-section="set_interview" class="btn btn-danger pull-right mr-2 reject">Reject</button>
            <?php } ?>
            <?php if(has_permission('selection', 'withdraw')) { ?>
                <button type="button" name="btn" data-id="<?= $grantee_grant_id ?>" data-section="set_interview" class="btn btn-warning pull-right mr-2 withdraw">Withdraw</button>
            <?php } ?>
            <!-- <button type="button" name="btn" value="not_recommended" onclick="notRecommended()" class="change btn btn-danger pull-right ml-1">Not Recommended</button>
            <button type="button" name="btn" value="recommended" onclick="recommended()" class="change btn btn-success pull-right ml-1">Recommended</button>
            <button type="button" name="btn" value="heighly_recommended" onclick="heighlyRecommended()" class="change btn btn-success pull-right">Highly Recommended</button> -->
        </div>
    </div>
</form>

<!-- Modal -->

<?php $this->load->view('admin/partials/modal_add_payment_record') ?>
<?php $this->load->view('admin/partials/modal_edit_payment_record') ?>
<?php $this->load->view('admin/partials/modal_reject_selection') ?>
<?php $this->load->view('admin/partials/modal_confirm') ?>

<div class="modal fade" id="modal-score" tabindex="-1" role="dialog" aria-labelledby="modal-score-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="modal-score-title">
            Detail Score Interview
            <a type="button" class="btn btn-default pull-right mb-4" data-dismiss="modal" aria-label="Close" style="margin-top: -5px;">
                <span aria-hidden="true"><i class="fa fa-times"></i></span>
            </a>
            <a href="" target="_blank" class="btn btn-success btn-download-score pull-right mb-4 mr-2" style="margin-top: -5px;">
                <span aria-hidden="true">Download</span>
            </a>
        </h5>
        
      </div>
      <div class="modal-body" id="detail-score">
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
        var currentUserReviews = JSON.parse(`<?=safe_parse_json(json_encode($final_record)); ?>`);
    </script>
<?php endif; ?>