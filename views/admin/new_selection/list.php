<style>
    #wrap-filter .custom-swal-width {
        width: 30% !important;
        /* Ubah lebar sesuai kebutuhan Anda */
    }
    #wrap-filter .select2 {
        border-radius: 0px !important;
        width: 200px !important;
        height: 35px !important;
        padding-top: 2px !important;
        /* border: 1px solid #ccc; */
    }

    #wrap-filter span.select2.select2-container{
        border-radius: 0px !important;
        width: 200px !important;
        height: 34px !important;
        padding-top: 2px !important;
        /* border: 1px solid #ccc; */
    }

    #wrap-filter .select2-selection.select2-selection--single {
        border-radius: 0px !important;
        width: 200px !important;
        height: 34px !important;
        padding-top: 2px !important;
        border: 1px solid #ccc;
    }

    #wrap-filter .select2-selection__arrow {
        margin-top: 5px !important;
    }

</style>

<style>
    .select2-container .select2-selection {
        max-height: 60px;
        overflow: auto;
    }

    .data-header {
        padding-top: 10px !important;
    }

    .program-filter-section {
        display: flex;
    }

    .program-filter-section > .form-group {
        width: 350px;
        margin-left: 12px;
    }

    .select2-container--bootstrap .select2-selection {
        border-radius: 0px !important;
    }

    .select2-selection--single > .select2-selection__rendered {
        margin-top: 5px !important;
    }

    .select2-selection--single {
        overflow: hidden !important;
    }

    label {
        font-weight: normal !important;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Selection <?= $_GET['section'] ?>
            <?php if (has_permission('selection', 'interview')) { ?>
                <?php if($_GET['section'] == 'Review'){ ?>
                <a href="javascript:;" onclick="show_download_modal_selection('<?= http_build_query($_GET) ?>', 'review')"
                    class="btn btn-primary btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                    DOWNLOAD EXCEL REVIEW
                </a>
                <?php } ?>
                <?php if($_GET['section'] == 'Interview'){ ?>
                <a href="javascript:;" onclick="show_download_modal_selection('<?= http_build_query($_GET) ?>', 'interview')"
                    class="btn btn-primary btn-sm pull-right  mr-2" title="Export Data Alumni dalam format file excel">
                    DOWNLOAD EXCEL INTERVIEW
                </a>
                <a href="<?= base_url('admin/selection/manage_ranks') ?>"
                    class="btn btn-info btn-sm pull-right mr-2">
                    MANAGE SELECTION RANK
                </a>
                <a href="<?= base_url('admin/selection/score_page') ?>"
                    class="btn btn-success btn-sm pull-right mr-2">
                    SCORE PAGE
                </a>
                <?php } ?>
            <?php } ?>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <?php if ($this->session->flashdata('not_found')) { ?>
            <div class="alert alert-warning"><?php echo $this->session->flashdata('not_found'); ?></div>
            <?php $this->session->flashdata('not_found', false); ?>
            <?php $this->session->unset_userdata('not_found');?>
        <?php } ?>
        <form id="frm_manage" method="GET">
            <div class="row mb-4 program-filter-section">
                <div class="form-group select-program">
                    <label>Program</label>
                    <select class="form-control select2" id="filter-program" name="program_ids[]" multiple>
                        <?php 
                            $program_ids = isset($_GET['program_ids']) ? (array) $_GET['program_ids'] : [];
                        ?>
                        <?php foreach($program_available as $program) { ?>
                            <option value="<?php echo $program->id; ?>" <?= (!empty($program_ids) && is_array($program_ids) && in_array($program->id, $program_ids)) ? 'selected' : '' ?>
><?php echo $program->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Period</label>
                    <select class="form-control select2" name="period[]" onchange="document.forms.frm_manage.submit()" multiple>
                        <option value="">&nbsp;</option>
                        <?php $_period = isset($_GET['period']) ? $_GET['period'] : ''; ?>
                        <?php foreach($available_period as $period) { ?>
                            <?php if (empty($period->fiscal_year) || $period->fiscal_year <= 0) continue; ?>
                            <option value="<?php echo $period->fiscal_year; ?>" <?php echo (!empty($_period) && is_array($_period) && in_array($period->fiscal_year, $_period)) ? 'selected' : ''; ?>><?php echo $period->fiscal_year; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="form-group hide">
                    Section
                    <select class="form-control" name="section" onchange="document.forms.frm_manage.submit()" style="width:150px">
                        <option value="">All</option>
                        <option value="Review" <?= (isset($_GET['section']) && $_GET['section'] == 'Review') ? 'selected' : '' ?>>Review</option>
                        <option value="Interview" <?= (isset($_GET['section']) && $_GET['section'] == 'Interview') ? 'selected' : '' ?>>Interview</option>
                    </select>
                </div>
                <div class="pull-right">
                    <div class="form-group mr-2">
                        <?= $_GET['section'] == 'Review' ? 'Review' : 'Interview' ?> Date
                        <input type="text" class="form-control dateWithRange" name="filter_date" placeholder="Select Date" readonly style="background-color:#fff;" value="<?= $filter_date ?>">
                    </div>
                    <div class="form-group">
                        Status
                        <select class="form-control" name="status_section" onchange="document.forms.frm_manage.submit()" style="width:150px">
                            <?php
                            $search_by = $_GET['status_section'];
                            foreach ($filter_status as $field => $val) {
                                $selected = '';
                                if (isset($search_by) && $search_by == $field) {
                                    $selected = 'selected="selected"';
                                }
                            ?>
                                <option
                                    value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        Search By
                        <select class="form-control" name="search_by[]">
                            <?php
                            $search_by = $_GET['search_by'][0];
                            foreach ($filters as $field => $val) {
                                $selected = '';
                                if (isset($search_by) && $search_by == $field) {
                                    $selected = 'selected="selected"';
                                }
                            ?>
                                <option
                                    value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?php echo isset($q[0]) ? $q[0] : '' ?>"
                            placeholder="" onkeypress="return submitFilter(event)">
                        <a href="javascript:;" onclick="add_filter()" class="btn btn-success btn-sm"><i
                                class="fa fa-plus fa-fw"></i></a>
                    </div>
                </div>
                <?php
                $total_filter = isset($_GET['search_by']) ? count($_GET['search_by']) : 0;
                if ($total_filter > 1) {
                    for ($i = 1; $i < $total_filter; $i++) {
                ?>
                        <div class="pull-right" style="margin-top:5px; clear:both;">
                            <div class="form-group">
                                <select class="form-control" name="cnj[]">
                                    <option value="AND" <?= $_GET['cnj'][$i - 1] == 'AND' ? 'selected' : null ?>>AND</option>
                                    <option value="OR" <?= $_GET['cnj'][$i - 1] == 'OR' ? 'selected' : null ?>>OR</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="search_by[]">
                                    <?php
                                    $search_by = $_GET['search_by'][$i];
                                    foreach ($filters as $field => $val) {
                                        $selected = '';
                                        if (isset($search_by) && $search_by == $field) {
                                            $selected = 'selected="selected"';
                                        }
                                    ?>
                                        <option
                                            value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Keyword : <input type="search" class="form-control input-sm" name="q[]"
                                value="<?php echo $q[$i] ?>" placeholder=""
                                onkeypress="return submitFilter(event)">
                            <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i
                                    class="fa fa-minus fa-fw"></i></a>
                        </div>
                <?php
                    }
                }
                ?>
            Show :
                <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                    <?php
                    foreach ($limit_options as $lo) {
                        $selected = '';
                        if ($lo == $paging['limit']) $selected = 'selected';
                    ?>
                        <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo == 1000 ? 'All' : $lo; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('grantee_name', $sort_by, $sort) ?>>Name</th>
                            <th width="150" <?php echo sorting_attribute('grants_name', $sort_by, $sort) ?>>Grants</th>
                            <th <?php echo sorting_attribute('period', $sort_by, $sort) ?>>Period</th>
                            <?php if (has_permission('selection', 'validation')) { ?>
                                <th class="text-center">Validation</th>
                            <?php } ?>
                            <th>PIC</th>
                            <th <?php echo sorting_attribute('interview_date', $sort_by, $sort) ?>><?= $_GET['section'] == 'Review' ? 'Review Start ' : 'Interview' ?> Date</th>
                            <?php if ($_GET['section'] == 'Review') { ?>
                                <th <?php echo sorting_attribute('interview_date', $sort_by, $sort) ?>>Review End Date</th>
                            <?php } ?>
                            <?php if (has_permission('selection', 'validation')) { ?>
                                <th class="text-center"><?= $_GET['section'] == 'Review' ? 'Review' : 'Interview' ?> Status</th>
                            <?php } ?>
                            <?php if ($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                <th>Status</th>
                            <?php } ?>
                            <th <?php echo $_GET['section'] == 'Review' ? sorting_attribute('score_review', $sort_by, $sort) : sorting_attribute('score_interview', $sort_by, $sort) ?>>Score</th>
                            <?php $filter_key = $_GET['section'] == 'Review' ? 'review_daily_rank' : 'rank_interview_date'; ?>
                            <th <?php echo sorting_attribute($filter_key, $sort_by, $sort) ?>>Rank</th>
                            <?php if (has_permission('selection', 'validation') && $_GET['section'] != 'Review') { ?>
                                <th <?php echo sorting_attribute('final_rank_interview', $sort_by, $sort) ?>>Final Rank</th>
                            <?php } ?>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //  echo "<pre>";print_r($data); echo "</pre>";
                        if ($data) {

                            $no = $paging['start_row'];
                            // $no = 1;
                            foreach ($data as $row) {
                                // echo '<pre>';print_r($row);die;
                                $format = 'ID';
                                if ($country_id == '2') {
                                    $format = 'US';
                                }
                                $fullname = $this->Grantee_ent_model->get_full_name($row, $format);
                        ?>
                                <tr style="<?= $row->blacklist ? 'background-color:#f59494' : '' ?>">
                                    <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php // echo $row->staff_id 
                                                                                                    ?>"></td>
                                    <td><?php echo $no++ ?></td>
                                    <td>
                                        <a target="_BLANK" href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id); ?>"><?php echo $fullname ?></a>
                                        <?php if ($row->selection_reviews && count($row->selection_reviews) > 0 && has_permission('selection', 'interview') && ($_GET['section'] == 'Interview' || $_GET['section'] == '')) { ?>
                                            <div>
                                                Review Status :
                                                <?php foreach ($row->selection_reviews as $review) { ?>
                                                    <?php if ($review->rank_recommendation != '') { ?>
                                                        <span class="badge <?= $review->rank_recommendation ? get_badge_status($review->rank_recommendation) : '' ?>" data-toggle="tooltip" data-placement="right" title="<?= $review->panellist_name ?>" style="cursor:default;">
                                                            <?= $review->rank_recommendation != '' ? $review->rank_recommendation : '-' ?>
                                                        </span>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $row->program_name; ?></td>
                                    <td><?php echo $row->fiscal_year; ?></td>
                                    <?php if (has_permission('selection', 'interview')) { ?>
                                        <td class="text-center">
                                            <span class="<?= $row->validation_status != '' ? get_badge_status_validation($row->validation_status) : '' ?>">
                                                <?= $row->validation_status != '' ? get_msg_status_validation($row->validation_status) : '-' ?>
                                            </span>
                                        </td>
                                    <?php } ?>
                                    <td><?php echo $_GET['section'] == 'Review' ? $row->pic_review_name : $row->pic_name; ?></td>
                                    <?php if ($_GET['section'] == 'Interview' || $_GET['section'] == '') { ?>
                                        <td><?= $row->interview_date ? date('d M Y h:i A', strtotime($row->interview_date)) : '-' ?></td>
                                    <?php } else {?>
                                        <td><?= $row->start_date_review ? date('d M Y h:i A', strtotime($row->start_date_review)) : '-' ?></td>
                                    <?php } ?>
                                    <?php if ($_GET['section'] == 'Review') { ?>
                                        <td><?= $row->end_date_review ? date('d M Y h:i A', strtotime($row->end_date_review)) : '-' ?></td>
                                    <?php } ?>
                                    <?php if (has_permission('selection', 'interview')) { ?>
                                        <td class="text-center">
                                            <?php $status_reject = [STATUS_NEW_SELECTION_WITHDRAW, STATUS_REVIEW_REJECT, STATUS_INTERVIEW_REJECT, STATUS_NEW_SELECTION_DECLINED];
                                            if (in_array($row->status_id, $status_reject)) { ?>
                                                <button type="button" data-attach='<?= $row->attachment_withdraw ?>' data-note="<?= $row->note_selection ?>" onclick="showReason(this)" class="btn btn-primary btn-xs mt-2">View</button>
                                            <?php } else { ?>
                                                <?php if($_GET['section'] == 'Interview' || $_GET['section'] == '') { ?>
                                                    <?php foreach ($row->data_interview as $interview) { ?>
                                                        <?php if ($interview->rank_recommendation != '') { ?>
                                                            <span class="<?= $interview->rank_recommendation ? 'badge badge-success' : 'badge badge-danger' ?>" data-toggle="tooltip" data-placement="right" title="<?= $interview->panellist_name ?>" style="cursor:default;">
                                                                <?= $interview->rank_recommendation != '' ? get_msg_status($interview->rank_recommendation) : '-' ?>
                                                            </span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } else {?>
                                                    <?php foreach ($row->selection_reviews as $review) { ?>
                                                        <?php if ($review->rank_recommendation != '') { ?>
                                                            <span class="badge <?= $review->rank_recommendation ? get_badge_status($review->rank_recommendation) : '' ?>" data-toggle="tooltip" data-placement="right" title="<?= $review->panellist_name ?>" style="cursor:default;">
                                                                <?= $review->rank_recommendation != '' ? $review->rank_recommendation : '-' ?>
                                                            </span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                    <?php if ($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                        <td>
                                            Transportation : <?= $row->status_tba == 'done' ? '<span class="badge badge-success">Done</span>' : '<span class="badge badge-danger">Not Done</span>' ?><br />
                                            Accommodation : <?= $row->status_tba_accommodation == 'done' ? '<span class="badge badge-success">Done</span>' : '<span class="badge badge-danger">Not Done</span>' ?>
                                        </td>
                                    <?php } ?>
                                    <?php 
                                        $show_score = true;
                                        $panelist_submited = $_GET['section'] == 'Review' ? 
                                            ($row->selection_reviews ? array_column($row->selection_reviews, 'panelist_submited') : []) : 
                                            ($row->data_interview ? array_column($row->data_interview, 'panelist_submited') : []);
                                        if(in_array('0', $panelist_submited)) {
                                            $show_score = false;
                                        }
                                        $score = $_GET['section'] == 'Review' ? $row->score_review : $row->score_interview;
                                    ?>
                                    <td><?= $show_score ? $score : '-' ?></td>
                                    <?php if (has_permission('selection', 'interview') && $_GET['section'] == 'Review') { ?>
                                        <td><?= $row->review_daily_rank ? $row->review_daily_rank : '-' ?></td>
                                    <?php } ?>
                                    <?php if (has_permission('selection', 'interview') && $_GET['section'] != 'Review') { ?>
                                        <td><?= $row->rank_interview_date ? $row->rank_interview_date : '-' ?></td>
                                        <td><?= $row->final_rank_interview ? $row->final_rank_interview : '-' ?></td>
                                    <?php } ?>
                                    <?php 
								        $section_nominee_menu = $row->section_nominee_menu ? explode(',', $row->section_nominee_menu) : ['validation','review','interview'];
                                    ?>
                                    <td class="text-center" style="position:relative;">
                                        <a 
                                            href="#" 
                                            data-grantname="<?php echo $row->program_name ?>" 
                                            data-period="<?php echo $row->fiscal_year ?>" 
                                            data-name="<?php echo $fullname ?>" 
                                            data-id="<?= $row->grantee_grant_id ?>" 
                                            data-ajax_url="<?php echo site_url('admin/notes/get_list_ajax/submitted/' . $row->id); ?>"  
                                            class="open-offcanvas-note btn btn-xs btn-warning">
                                                Note 
                                                <span class="note-total-<?= $row->id ?>" data-total="<?= $row->total_notes ?>">
                                                    <?php if($row->total_notes) { ?>
                                                    <span class="badge"><?= $row->total_notes ?></span>
                                                    <?php } ?>
                                                </span>
                                        </a>
                                        <?php if($_GET['section'] == 'Review') { ?>
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn-section">
                                            Section
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="btn-section" style="top:29px;right:15%;">
                                            <?php if (has_permission('selection', 'validation')) { ?>
                                                <li>
                                                    <a href="<?php echo site_url('admin/selection/validation/form/' . $row->id) ?>">Validation</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (has_permission('selection', 'review') || has_permission('selection', 'review_payment')) { ?>
                                                <?php if ($row->validation_status == VALID) { ?>
                                                    <li>
                                                        <a href="<?php echo site_url('admin/selection/selection_review/form/' . $row->id) ?>">Selection Review</a>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php //if (has_permission('selection', 'interview') || has_permission('selection', 'interview_payment') || has_permission('selection', 'accomodation_interview') || has_permission('selection', 'transportation_interview')) { ?>
                                                <?php //if ($row->validation_status == VALID) { ?>
                                                    <!-- <li>
                                                        <a href="<?php echo site_url('admin/selection/interview/form/' . $row->id) ?>">Interview Selection</a>
                                                    </li> -->
                                                <?php //} ?>
                                            <?php //} ?>
                                        </ul>
                                        <?php } ?>
                                        <?php if($_GET['section'] == 'Interview') { ?>
                                            <?php if (has_permission('selection', 'interview') || has_permission('selection', 'interview_payment') || has_permission('selection', 'accomodation_interview') || has_permission('selection', 'transportation_interview')) { ?>
                                                <?php if ($row->validation_status == VALID) { ?>
                                                    <a class="btn btn-primary btn-xs" href="<?php echo site_url('admin/selection/interview/form/' . $row->id) ?>">Detail</a>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <div class="btn-group">
                                            <?php if (has_permission('selection', 'payment') || has_permission('selection', 'set_to_application') || has_permission('selection', 'set_to_nominee') || has_permission('selection', 'reject') || has_permission('selection', 'drop') || has_permission('selection', 'reset_data')) { ?>
                                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-gear fa-fw"></i> <span class="caret"></span>
                                                </button>
                                            <?php } ?>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <?php if (has_permission('selection', 'payment')) { ?>
                                                    <li><a href="<?php echo site_url('admin/payment_record/payment/selection/' . $row->id) ?>">Payment</a></li>
                                                <?php } ?>
                                                <?php if (has_permission('selection', 'interview')) { ?>
                                                    <li>
                                                        <a href="<?php  echo site_url('admin/grantee/view_procedures/' . $row->grantee_grant_id) ?>" target="_blank">View All Procedures</a> 
                                                    </li>
                                                <?php } ?>
                                                <?php if (has_permission('selection', 'set_to_application')) { ?>
                                                    <li>
                                                        <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="new_selection" class="previous_status">Set to Application</a>
                                                    </li>
                                                <?php } ?>
                                                <?php if (has_permission('selection', 'set_to_nominee')) { ?>
                                                    <li>
                                                        <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-grantee_id="<?php echo $row->grantee_id; ?>" class="succesfully">Set to Nominee</a>
                                                    </li>
                                                <?php } ?>
                                                <?php if (has_permission('selection', 'reject')) { ?>
                                                    <li>
                                                        <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="new_selection" class="reject">Reject</a>
                                                    </li>
                                                <?php } ?>
                                                <?php //if(has_permission('selection', 'withdraw')) { 
                                                ?>
                                                <li>
                                                    <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="new_selection" class="withdraw">Withdraw</a>
                                                </li>
                                                <?php //} 
                                                ?>
                                                <?php if (has_permission('selection', 'reset_data')) { ?>
                                                    <li>
                                                        <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="new_selection" class="reset">Reset Data</a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

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
        </form>

    </div>
</div>
<?php $this->load->view('admin/partials/modal_confirm') ?>
<?php $this->load->view('admin/partials/form_filter') ?>


<div class="modal fade" id="modalDownloadSelection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form-download-excel-selection">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Download Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <div class="col-lg-6 filter-daterange">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control dateRangePicker" name="interview_date">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select PIC</label>
                                <select name="pic" id="pic" class="form-control select2">
                                    <option value="">-- Select PIC --</option>
                                    <?php $pics = get_all_db('am_pic', [], [], '', null, [], ['field' => 'name', 'order' => 'ASC']); ?>
                                    <?php foreach ($pics as $pic) { ?>
                                        <option value="<?= $pic->id ?>"><?= $pic->name ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger d-none text-validation-activegrant" id="text-validation-active-grant">Choose Active Grant</small>
                            </div>
                        </div>
                        <div class="col-lg-12 filter-grant">
                            <div class="form-group">
                                <label>Select Active Grant</label>
                                <select data-selection="1" name="grant_id[]" id="active_grant_id" class="form-control select2" multiple style="border-radius: 0px !important; width:100%!important;">
                                    <?php foreach ($program_available as $key_p_a => $p_a) { ?>
                                        <option value="<?= $p_a->id ?>"><?= $p_a->name ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger d-none text-validation-activegrant" id="text-validation-active-grant">Choose Active Grant</small>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Period</label>
                                <select name="year" id="select_period" class="form-control selectpicker" data-live-search="true" style="border-radius: 0px !important; width:100%!important;">
                                    <?php foreach ($available_period as $key => $period) { ?>
                                        <option value="<?= $period->fiscal_year ?>"><?= $period->fiscal_year ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger d-none text-validation-activegrant" id="text-validation-active-grant">Choose Active Grant</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <b>Personal Information</b>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label><input id="sel-all-field" type="checkbox"> Select All </label>
                        </div>
                        <div class="row pr-4">
                            <?php foreach (array_split($all_field, 3) as $key_a_f => $a_f) : ?>
                                <div class="col-md-4">
                                    <ul class="list-style-none pl-4">
                                        <?php foreach ($a_f as $key => $value) : ?>
                                            <?php


                                            $current_key = explode('_', $key);
                                            $field_property = '';
                                            if ($current_key[0] == 'emergency') {
                                                $field_property = 'emergency_contact_field';
                                            }

                                            $is_checked = false;
                                            if (in_array($key, [
                                                'name',
                                                'gender',
                                                'country',
                                                'state',
                                                'city',
                                                'phone_number',
                                                'primary_email',
                                                'grant_name',
                                                'home_institution',
                                                'host_institution',
                                                'office_city',
                                                'field_of_study',
                                                'major',
                                                'project_title',
                                                'period_fiscal_year',
                                                'test_type',
                                                'test_score'
                                            ])) {
                                                $is_checked = true;
                                            }
                                            ?>
                                            <li>
                                                <div class="form-check">
                                                    <table>
                                                        <tr>
                                                            <td style="vertical-align: top !important;">
                                                                <input type="checkbox" name="field_alumni[]" class="form-check-input mr-1 field" <?php echo $is_checked ? 'checked' : ''; ?> id="field_alumni_check<?= $key ?>" value="<?= "$key *-* $value" ?><?php echo !empty($field_property) ? " *-* " . $field_property : ""; ?>">
                                                            </td>
                                                            <td>
                                                                <label class="form-check-label font-weight-normal d-inline" for="field_alumni_check<?= $key ?>"><?= $value ?></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="row add_fields pr-4"></div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" name="download_type" value="daily" class="btn btn-success">Download</button>
                    <button type="submit" name="download_type" value="resume" class="btn btn-success">Download Resume</button>
                </div>
            </form>
        </div>
    </div>
</div>