<style>


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
<div class="row warp-alumni-page">
    <div class="panel-body">
        <div class="col-lg-4">
            <div class="form-group">
                <label>PIC</label>
                <!-- <input type="text" class="form-control" name="selection_review[<?= $key ?>][pic]" placeholder="PIC" value="<?= $row->pic ?>"> -->
                <select name="pic" class="form-control <?= $is_alumni_page ? '' : 'select2'?>">
                    <option value="">-- Select --</option>
                    <?php foreach($pics as $pic) { 
                        $selected = '';
                        if ($grantee_grant->pic_review == $pic->id) {
                            $selected = 'selected="selected"';
                        }?>
                        <option value="<?php echo $pic->id ?>" <?php echo $selected ?>><?php echo $pic->name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Interview Status</label>
                <select name="selected_interview_status" class="form-control <?= $is_alumni_page ? '' : 'select2'?>">
                    <option value="">-- Select --</option>
                    <option value="yes" <?= $grantee_grant->selected_interview_status == 'yes' ? 'selected="selected"' : '' ?>>Selected for Interview</option>
                    <option value="no" <?= $grantee_grant->selected_interview_status == 'no' ? 'selected="selected"' : '' ?>>Not Selected for Interview</option>
                </select>
            </div>
        </div>
        <!-- <div class="col-lg-4">
            <div class="form-group">
                <label>Start Date</label>
                <input id="date" class="form-control datepicker" readonly style="background-color:#fff" name="date" value="<?= $grantee_grant->review_date ? date('d M Y', strtotime($grantee_grant->review_date)) : '' ?>" placeholder="Date">
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>End Date</label>
                <input id="end_date" class="form-control datepicker" readonly style="background-color:#fff" name="end_date" value="<?= $grantee_grant->review_end_date ? date('d M Y', strtotime($grantee_grant->review_end_date)) : '' ?>" placeholder="Date">
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
            </div>
        </div> -->
    </div>
</div>
<div class="row warp-alumni-page">
    <?php if(has_permission('selection', 'review')) { ?>
    <div id="wrap-selection-review">
        <?php if($selection_reviews) { ?>
            <?php foreach($selection_reviews as $key => $row) { ?>
                <?php 
                    $del_btn = '';
                    if ($key > 0) {
                        $del_btn = '<a href="javascript:;" onclick="del_item_selection_review(this, \'selection-review-item\','.$row->id.')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
                    } 
                ?>
                <input type="hidden" value="<?= $row->id?>" name="selection_review[<?= $key ?>][payment_record_id]">
                <div id="selection-review-item-<?= $key ?>" class="selection-review-item" style="position:relative">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> SELECTION REVIEW</p>
                    <div class="panel-body" style="margin-top:-20px">
                        <div class="col-lg-12 mb-3 <?= $is_alumni_page ? 'hide' : '' ?>">
                            <label>Allow Score Editing</label>
                            <label class="switch">
                            <input  data-id="<?= $row->id ?>" type="checkbox" id="lock_review_<?= $key ?>" class="lock_review_check" name="selection_review[<?= $key ?>][lock_review]" <?= $row->lock_review  ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                            </label>

                            <?php if($row->submitted_at) { ?>
                            <u style="display:inline-block; margin-left:20px;">Submitted on <?= date('F j, Y H:i:s', strtotime($row->submitted_at)) ?></u>
                            <?php } ?>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Name of Panelist</label>
                                <select id="panellis_<?= $key ?>" class="form-control select2" name="selection_review[<?= $key ?>][panellist]" style="width:100%" onchange="get_panellist(<?= $key ?>)">
                                    <option value="0">-- Select Panelist Name --</option>
                                    <?php
                                    if ($panellist) {
                                        foreach ($panellist as $pl) {
                                            $selected = '';
                                            if ($row->panellist_id == $pl->id) {
                                                $selected = 'selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $pl->id ?>" <?php echo $selected ?>><?php echo $pl->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Field of Study</label>
                                <input id="field_of_study_<?= $key ?>" type="text" class="form-control" placeholder="Field of Study" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input id="email_<?= $key ?>" type="email" class="form-control" placeholder="eg: example@aminef.com" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Telp</label>
                                <input id="tel_<?= $key ?>" type="tel" class="form-control" placeholder="Telp" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">

                            <div class="form-group">
                                <label>Home Institution</label>
                                <input id="home_institution_<?= $key ?>" class="form-control" placeholder="Home Institution" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">

                            <div class="form-group">
                                <label>Bank Info</label>
                                <input id="bank_info_<?= $key ?>" class="form-control" placeholder="Bank Info" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Beneficiary Name</label>
                                <input id="beneficiary_name_<?= $key ?>" class="form-control" placeholder="Beneficiary Name" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input id="account_number_<?= $key ?>" class="form-control" placeholder="Account Number" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Status Panelist</label>
                                <input id="status_panellist_id_<?= $key ?>" class="form-control" placeholder="Status Panelist" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="margin-top:-20px">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input id="date_<?= $key ?>" class="form-control datepicker" readonly style="background-color:#fff" name="selection_review[<?= $key ?>][date]" value="<?= $row->date ? date('d M Y', strtotime($row->date)) : '' ?>" placeholder="Date">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>End Date</label>
                                <input id="end_date_<?= $key ?>" class="form-control datepicker" readonly style="background-color:#fff" name="selection_review[<?= $key ?>][end_date]" value="<?= $row->end_date ? date('d M Y', strtotime($row->end_date)) : '' ?>" placeholder="Date">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Score</label>
                                <input id="score_<?= $key ?>" class="form-control" name="selection_review[<?= $key ?>][score]" value="<?= $row->panelist_submited == 1 ? $row->score : '' ?>" placeholder="Score">
                                <?php //if($row->detail_score != '') { ?>
                                    <button type="button" class="btn btn-primary btn-xs mt-1" data-toggle="modal" data-id="<?= $row->id ?>" data-period_id="<?php echo $grantee_grant->period_id; ?>" onclick="showDetailScore(this)" data-target="#view-detail-modal">View Detail Score</button>
                                <?php //} ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Participation Mode</label>
                                <select name="selection_review[<?= $key ?>][participation_mode]" id="participation_mode" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option <?= $row->participation_mode == "online" ? "selected" : "" ?> value="online">Online</option>
                                    <option <?= $row->participation_mode == "offline" ? "selected" : "" ?> value="offline">Offline</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Scoring sheet</label>
                                <input type="file" name="scoring_sheet_<?= $key ?>" id="scoring_sheet_<?= $key ?>">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <?php if ($row->scoring_sheet != '') { ?>
                                    <br />
                                    <div style="margin-bottom:10px; position:relative; width:100px;" class="d-inline">
                                        <a href="<?php echo base_url() ?><?php echo $row->scoring_sheet ?>" class="lightbox" target="_blank"><label class="btn btn-primary" style="cursor:pointer">View</label></a>
                                        <a href="<?=base_url('admin/selection_review/delete_scoreing/'.$row->id.'/'.$grantee_grant_id) ?>"><label class="btn btn-danger" onclick="return confirm('Are you sure?')" style="cursor:pointer"><i class="fa fa-trash fa-fw"></i></label></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                        <div class="panel-body" style="margin-top:-30px">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Rank Recommendation</label>
                                    <select name="selection_review[<?= $key ?>][rank_recommendation]" id="rank_recommendation" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option <?= $row->rank_recommendation == "HR" ? "selected" : "" ?>  value="HR">Highly Recommended</option>
                                        <option <?= $row->rank_recommendation == "R" ? "selected" : "" ?> value="R">Recommended</option>
                                        <option <?= $row->rank_recommendation == "NR" ? "selected" : "" ?> value="NR">Not Recommended</option>
                                    </select>
                                    <!-- <p>
                                        <div class="radio d-inline mr-4">
                                            <label>
                                                <input type="radio" 
                                                        <?= $row->rank_recommendation == "NR" ? "checked" : "" ?>
                                                        class="grant-alumni" 
                                                        name="selection_review[<?= $key ?>][rank_recommendation]" 
                                                        style="margin-top:1px" 
                                                        value="NR">
                                                        Not Recommended
                                            </label>
                                        </div>
                                        <div class="radio d-inline mr-4">
                                            <label>
                                                <input type="radio" 
                                                        <?= $row->rank_recommendation == "R" ? "checked" : "" ?>
                                                        class="grant-alumni" 
                                                        name="selection_review[<?= $key ?>][rank_recommendation]" 
                                                        style="margin-top:1px" 
                                                        value="R">
                                                        Recommended
                                            </label>
                                        </div>
                                        <div class="radio d-inline">
                                            <label>
                                                <input type="radio" 
                                                        <?= $row->rank_recommendation == "HR" ? "checked" : "" ?>
                                                        class="grant-alumni" 
                                                        name="selection_review[<?= $key ?>][rank_recommendation]" 
                                                        style="margin-top:1px" 
                                                        value="HR">
                                                        Highly Recommended
                                            </label>
                                        </div>
                                    </p> -->
                                </div>
                            </div>
                        </div>
                    <?php echo $del_btn ?>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div id="selection-review-item-0" class="selection-review-item" style="position:relative">
                <div class="panel-body" style="margin-top:-20px">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> SELECTION REVIEW</p>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Name of Panelist</label>
                            <select id="panellis_0" class="form-control select2" name="selection_review[0][panellist]" style="width:100%" onchange="get_panellist(0)">
                                <option value="0">-- Select Panelist Name --</option>
                                <?php
                                if ($panellist) {
                                    foreach ($panellist as $pl) {
                                        $selected = '';
                                        if ($submission_plans->university_id == $pl->id) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?php echo $pl->id ?>" <?php echo $selected ?>><?php echo $pl->name ?></option>
                                    <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Field of Study</label>
                            <input id="field_of_study_0" type="text" class="form-control" placeholder="Field of Study" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input id="email_0" type="email" class="form-control" placeholder="eg: example@aminef.com" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Telp</label>
                            <input id="tel_0" type="tel" class="form-control" placeholder="Telp" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            <label>Home Institution</label>
                            <input id="home_institution_0" class="form-control" placeholder="Home Institution" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            <label>Bank Info</label>
                            <input id="bank_info_0" class="form-control" placeholder="Bank Info" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Beneficiary Name</label>
                            <input id="beneficiary_name_0" class="form-control" placeholder="Beneficiary Name" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Account Number</label>
                            <input id="account_number_0" class="form-control" placeholder="Account Number" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status Panelist</label>
                            <input id="status_panellist_id_0" class="form-control" placeholder="Status Panelist" readonly>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="margin-top:-20px">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input id="date_0" class="form-control datepicker" readonly style="background-color:#fff" name="selection_review[0][date]" value="" placeholder="Date">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>End Date</label>
                            <input id="end_date_0" class="form-control datepicker" readonly style="background-color:#fff" name="selection_review[0][end_date]" value="" placeholder="End Date">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Score</label>
                            <input id="score_0" class="form-control" name="selection_review[0][score]" value="" placeholder="Score">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Participation Mode</label>
                            <select name="selection_review[0][participation_mode]" id="participation_mode" class="form-control">
                                <option value="">-- Select --</option>
                                <option <?= $row->participation_mode == "online" ? "selected" : "" ?> value="online">Online</option>
                                <option <?= $row->participation_mode == "offline" ? "selected" : "" ?> value="offline">Offline</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Scoring sheet</label>
                            <input type="file" name="scoring_sheet_0" id="scoring_sheet_0">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="margin-top:-30px">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Rank Recommendation</label>
                            <select name="selection_review[0][rank_recommendation]" id="rank_recommendation" class="form-control">
                                <option value="">-- Select --</option>
                                <option <?= $row->rank_recommendation == "HR" ? "selected" : "" ?>  value="HR">Highly Recommended</option>
                                <option <?= $row->rank_recommendation == "R" ? "selected" : "" ?> value="R">Recommended</option>
                                <option <?= $row->rank_recommendation == "NR" ? "selected" : "" ?> value="NR">Not Recommended</option>
                            </select>
                            <!-- <p>
                                <div class="radio d-inline mr-4">
                                    <label>
                                        <input type="radio" 
                                                class="grant-alumni" 
                                                name="selection_review[0][rank_recommendation]" 
                                                style="margin-top:1px" 
                                                value="NR">
                                                Not Recommended
                                    </label>
                                </div>
                                <div class="radio d-inline mr-4">
                                    <label>
                                        <input type="radio" 
                                                class="grant-alumni" 
                                                name="selection_review[0][rank_recommendation]" 
                                                style="margin-top:1px" 
                                                value="R">
                                                Recommended
                                    </label>
                                </div>
                                <div class="radio d-inline">
                                    <label>
                                        <input type="radio" 
                                                class="grant-alumni" 
                                                name="selection_review[0][rank_recommendation]" 
                                                style="margin-top:1px" 
                                                value="HR">
                                                Highly Recommended
                                    </label>
                                </div>
                            </p> -->
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <div class="panel-body <?= $is_alumni_page ? 'hide' : '' ?>" style="margin-top:-20px">
        <div class="col-lg-12">
            <a href="javascript:;" onclick="add_selection_review()" class="btn btn-primary">
                <i class="fa fa-plus fa-fw"></i> Add New
            </a>
            <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load" style="display:none;">
        </div>
    </div>

    <hr />
    <?php } ?>

    <?php if(has_permission('selection', 'review_payment')) { ?>
    <!-- table payment -->
    <div class="tab-content <?= $is_alumni_page ? 'hide' : '' ?>">
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
                                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                                        <?php } ?>
                                    </select>
                                    entries
                                </div>
                                <div class="pull-right">
                                    <a href="#" data-toggle="modal" data-target="#mdl_add_record" <?php echo $disabled; ?> class="<?php echo $disabled; ?> btn btn-success btn-sm "  id="btn-add">
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
                                            <!-- <th>Description</th> -->
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
                                                    <td><?= date('d M Y', strtotime($row->payment_date)) ?></td>
                                                    <!-- <td><?php echo $row->description; ?></td> -->
                                                    <td>
                                                        <?php
                                                        $total_payment_idr = [];
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment_idr, $item->nominal_idr);
                                                        }
                                                        ?>
                                                        IDR <?= number_format(array_sum($total_payment_idr)) ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $total_payment = [];
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment, $item->nominal);
                                                        }
                                                        ?>
                                                        USD <?= number_format(array_sum($total_payment)) ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($row->proof)) { ?>
                                                            <a href="<?php echo base_url($row->proof) ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof Of Transfer</label></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $row->payment_status ?></td>
                                                    <td class="text-center">
                                                        <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs <?php echo $disabled; ?>">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <a href="<?= site_url('admin/request_payment/delete_record/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del <?php echo $disabled; ?>">
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
                            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
                            <input type="hidden" name="sort" value="<?php echo $sort ?>">
                            <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>