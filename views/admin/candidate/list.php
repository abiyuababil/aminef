<style>
    .tr-active{
        background-color: #5395e6 !important;
        color: white;
    }

    .tr-active a{
        color: white;
    }
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu > .dropdown-menu {
    top: 0;
    right: 100%;
    left: auto;
    margin-top: -6px;
    display: none; /* hidden dulu */
    }

    .dropdown-submenu:hover > .dropdown-menu {
    display: block; /* muncul saat hover */
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
        <h1 class="page-header">
            <?= $page_title; ?>
            <a href="javascript:;" onclick="show_download_modal()" class="btn btn-primary btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                DOWNLOAD EXCEL
            </a>
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
                <div class="form-group">
                    <label>PIC</label>
                    <select class="form-control select2" name="pic_ids[]" onchange="document.forms.frm_manage.submit()" multiple>
                        <option value="">&nbsp;</option>
                        <?php $_pic = isset($_GET['pic_ids']) ? $_GET['pic_ids'] : ''; ?>
                        <?php foreach($pics as $pic) { ?>
                            <option value="<?= $pic->id ?>" <?php echo (!empty($_pic) && is_array($_pic) && in_array($pic->id, $_pic)) ? 'selected' : ''; ?>><?= $pic->full_name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <!-- <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul> -->
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>

                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit']) $selected = 'selected';
                        ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <div class="pull-right">
                    <div class="form-group mr-5">
                        Status
                        <select class="form-control" name="status_nominee" onchange="document.forms.frm_manage.submit()">
                            <option value="">-- Select --</option>
                            <?php
                            $search_by = $_GET['status_nominee'];
                            foreach ($filter_status_nominee as $field => $val) {
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
                    <div class="form-group mr-5">
                        Step
                        <select class="form-control" name="status_step" onchange="document.forms.frm_manage.submit()">
                            <option value="">-- Select --</option>
                            <?php
                            $search_by = $_GET['status_step'];
                            foreach ($filter_status_nominee_step as $field => $val) {
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
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?php echo isset($q[0]) ? $q[0] : '' ?>"
                                     placeholder="" onkeypress="return submitFilter(event)">
                    <a href="javascript:;" onclick="add_filter()" class="btn btn-success btn-sm"><i
                            class="fa fa-plus fa-fw"></i></a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('grantee_name', $sort_by, $sort) ?>>Name</th>
                            <th <?php echo sorting_attribute('grants_name', $sort_by, $sort) ?>>Grants</th>
                            <th <?php echo sorting_attribute('fiscal_year', $sort_by, $sort) ?>>Period</th>
                            <th <?php echo sorting_attribute('pic_nominee', $sort_by, $sort) ?>>PIC</th>
                            <th>Final Placement</th>
                            <th>Field of Study</th>
                            <th>Total Cost</th>
                            <th <?php echo sorting_attribute('final_rank_interview', $sort_by, $sort) ?>>Rank</th>
                            <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
                            <?php //if ($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                <!-- <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status PDO</th> -->
                            <?php //} ?>
                            <th width="200" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-nominee">
                        <?php
                        if ($data) {
                            
                            // $no = 1;
                            $no = $paging['start_row'];

                            foreach ($data as $row) {

                                $format = 'ID';
                                if ($country_id == '2') {
                                    $format = 'US';
                                }
                                $fullname = $this->Grantee_ent_model->get_full_name($row, $format);
                        ?>
                                <tr>
                                    <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php // echo $row->staff_id ?>"></td>
                                    <td><?php  echo $no++ ?></td>
                                    <td><a target="_BLANK" href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id);?>" class="<?= $row->blacklist ? 'text-danger font-weight-bold' : '' ?>"><?php  echo $fullname ?></a></td>
                                    <td><?php echo $row->program_name; ?></td>
                                    <td><?php echo $row->fiscal_year; ?></td>
                                    <td><?php echo $row->pic_nominee_name; ?></td>
                                    <td><?php echo $row->university_name; ?></td>
                                    <td><?php echo $row->field_of_study_input ?? ($row->field_of_study_id ? get_field_of_study_by_id($row->field_of_study_id)->name : '') ?></td>
                                    <td><?php echo $row->final_cost_university ? number_format($row->final_cost_university) : '' ?></td>
                                    <td><?php echo format_final_rank_status_list($row); ?></td>
                                    <td>
                                        <?php  echo $row->status_name; ?><br />
                                        <?php if(stripos($row->status_name, 'Withdraw') !== false || stripos($row->status_name, 'drop') !== false) { ?>
                                        <button type="button" data-attach='<?= $row->attachment_candidate ?? $row->attachment_withdraw ?>' data-note="<?= $row->note_candidate ?>" onclick="showReason(this)" class="btn btn-primary btn-xs mt-2">View</button>
                                        <?php } ?>
                                    </td>
                                    <?php //if ($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                        <!-- <td>
                                        Transportation : <?= $row->status_tba_pdo == 'done' ? '<span class="badge badge-success">Done</span>' : '<span class="badge badge-danger">Not Done</span>' ?><br />
                                        Accommodation : <?= $row->status_accomodation_tba_pdo == 'done' ? '<span class="badge badge-success">Done</span>' : '<span class="badge badge-danger">Not Done</span>' ?>
                                        </td> -->
                                    <?php //} ?>
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
                                        <?php if ($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                        <button 
                                            type="button"
                                            class="btn btn-xs btn-primary" 
                                            data-toggle="modal"
                                            style="cursor:pointer;"
                                            data-target="#modal_status"
                                            data-pdot="<?= $row->status_tba_pdo ?>"
                                            data-pdoa="<?= $row->status_accomodation_tba_pdo ?>"
                                            data-visat="<?= $row->status_transportation_visa_interview ?>"
                                            data-visaa="<?= $row->status_accommodation_visa_interview ?>"
                                            data-domestict="<?= $row->status_transportation_domestic ?>"
                                            data-domestica="<?= $row->status_accommodation_domestic ?>"
                                            data-intera="<?= $row->status_transportation_academic_program ?>"
                                        >
                                        Status
                                        </button>
                                        <?php } ?>

                                        
                                        <!-- <a href="<?= site_url('admin/nominee/general_nominee/form/'. $row->grantee_grant_id) ?>" class="btn btn-success btn-xs">
                                            General Nominee
                                        </a>
                                        <a href="<?= site_url('admin/nominee/submission_plan/manage/'. $row->grantee_grant_id) ?>" class="btn btn-warning btn-xs">
                                            <i class=""></i> Submission Plan
                                        </a>
                                        <a href="<?= site_url('admin/nominee/direct_application/manage/'. $row->grantee_grant_id) ?>" class="btn btn-primary btn-xs">
                                            <i class=""></i> Direct Application
                                        </a>
                                        <a href="<?= site_url('admin/nominee/submission_result/manage/'. $row->grantee_grant_id) ?>" class="btn btn-primary btn-xs">
                                            <i class=""></i> Submission Result
                                        </a>
                                        <a href="<?= site_url('admin/nominee/placement/form/'. $row->grantee_grant_id) ?>" class="btn btn-success btn-xs">
                                            <i class="fa fa-file-text"></i> Placement
                                        </a>
                                        <a href="<?= site_url('admin/pre_depature/form/'. $row->grantee_grant_id) ?>" class="btn btn-warning btn-xs">
                                            <i class="fa fa-file-text"></i> Pre Departure Orientation
                                        </a>
                                        <a href="<?= site_url('admin/nominee/other_documents/forms/'. $row->grantee_grant_id) ?>" class="btn btn-primary btn-xs">
                                            <i class=""></i> Other Documents
                                        </a> -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs mr-2 select_pic" data-selected="<?= $row->pic_nominee ?>" data-grantee_grant_id ="<?= $row->grantee_grant_id ?>" title="Select PIC"><i class="fa fa-user"></i></button>
                                            <button class="btn btn-primary btn-xs dropdown-toggle btn-section" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Section <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <!-- <li><a href="<?= site_url('admin/nominee/eec/form/'. $row->grantee_grant_id) ?>">EEC & FSB</a></li>
                                                <li><a href="<?= site_url('admin/nominee/mentoring/form/'. $row->grantee_grant_id) ?>">Mentoring</a></li>
                                                <li><a href="<?= site_url('admin/nominee/test_preparation/form/'. $row->grantee_grant_id) ?>">Test Preparation</a></li>
                                                <li><a href="<?= site_url('admin/nominee/test_section/form/'. $row->grantee_grant_id) ?>">Test Section</a></li>
                                                <li><a href="<?= site_url('admin/nominee/testing_score/form/'. $row->grantee_grant_id) ?>">Testing Score</a></li>
                                                <li><a href="<?= site_url('admin/nominee/submission_plan/manage/'. $row->grantee_grant_id) ?>">Submission Plan</a></li>
                                                <li><a href="<?= site_url('admin/nominee/direct_application/manage/'. $row->grantee_grant_id) ?>">Direct Application</a></li>
                                                <li><a href="<?= site_url('admin/nominee/submission_result/manage/'. $row->grantee_grant_id) ?>">Submission Result</a></li>
                                                <li><a href="<?= site_url('admin/nominee/placement/form/'. $row->grantee_grant_id) ?>">Placement</a></li>
                                                <li><a href="<?= site_url('admin/pre_depature/form/'. $row->grantee_grant_id) ?>">Pre Departure Orientation</a></li>
                                                <li><a href="<?= site_url('admin/nominee/other_documents/forms/'. $row->grantee_grant_id) ?>">Other Documents</a></li>
                                                <li><a href="<?= site_url('admin/nominee/tnc/forms/'. $row->grantee_grant_id) ?>">T&C</a></li>
                                                <li><a href="<?= site_url($row->tnc) ?>" class="lightbox">T&C</a></li> -->
                                                <!-- <li><a data-grantee_grant_id ="<?= $row->grantee_grant_id ?>" class="select_pic" data-selected=<?= $row->pic_nominee ?>>Select PIC</a></li> -->
                                                <?php 
                                                    $menu_section = $row->nominee_menu ? explode(",", $row->nominee_menu) : [];
                                                    if(empty($menu_section)){
                                                        $menu_section = array_keys($menu_nominee_master);
                                                    }
                                                    foreach($menu_section as $ms) :
                                                    if($ms == 'tnc' || $ms == 'direct_application'){ continue; } 
                                                    $slugNominee = $menu_nominee_master[$ms]['label'] ? str_replace('-', '_', str_slug($menu_nominee_master[$ms]['label'])) : '';
                                                    $condition = has_permission('nominee', $slugNominee);
                                                    if($slugNominee == 'test_preparation_section') {
                                                        $condition = has_permission('nominee', $slugNominee) || has_permission('nominee', 'accomodation_test_preparation') || has_permission('nominee', 'transportation_test_preparation');
                                                    }else if($slugNominee == 'pre_departure_orientation') {
                                                        $condition = has_permission('nominee', $slugNominee) || has_permission('nominee', 'domestic_ticket') || has_permission('nominee', 'accomodation_pdo') || has_permission('nominee', 'meal_allowance_pdo');
                                                    }else if($slugNominee == 'departure') {
                                                        $condition = has_permission('nominee', $slugNominee) || has_permission('nominee', 'accomodation_visa_interview') || has_permission('nominee', 'transportation_visa_interview') || has_permission('nominee', 'accomodation_visa_interview_domestic') || has_permission('nominee', 'transportation_visa_interview_domestic');
                                                    }
                                                ?>
                                                    <?php if($condition) { ?>
                                                    <li><a href="<?= site_url($menu_nominee_master[$ms]['url'] . $row->grantee_grant_id) ?>"><?= $menu_nominee_master[$ms]['label'] == 'Placement' ? 'Final Placement' : $menu_nominee_master[$ms]['label'] ?></a></li>
                                                    <?php } ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-gear fa-fw"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <?php if(has_permission('nominee', 'payment')) { ?>
                                            <li>
                                                <a href="<?php  echo site_url('admin/payment_record/payment/nominee/' . $row->id) ?>">Payment</a>
                                            </li>
                                            <?php } ?>
                                            <?php //if(has_permission('nominee', 'verify')) { ?>
                                            <!-- <li>
                                                <a href="<?= site_url('admin/nominee/verify/' . $row->grantee_grant_id) ?>">Verify</a>
                                            </li> -->
                                            <?php //} ?>
                                            <?php if (has_permission('nominee', 'verify')) { ?>
                                                <li>
                                                    <a href="<?php  echo site_url('admin/grantee/view_procedures/' . $row->grantee_grant_id) ?>" target="_blank">View All Procedures</a> 
                                                </li>
                                            <?php } ?>
                                            <?php if(has_permission('nominee', 'set_to_selection')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="candidate" class="previous_status">Set to Selection</a>
                                            </li>
                                            <?php } ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="candidate" class="default_status">Set to Nominee</a>
                                            </li>
                                            <?php if(has_permission('nominee', 'set_to_on_going')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" class="succesfully">Set to On Going</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('nominee', 'reject')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="candidate" class="reject">Reject</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('nominee', 'drop')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="candidate" class="drop">Drop</a>
                                            </li>
                                            <?php } ?>
                                            <li class="dropdown-submenu">
                                                <a href="#">Other</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" data-section="hide_menu_submission_plan" data-id="<?= $row->grantee_grant_id ?>" data-value="<?= $row->hide_menu_submission_plan ? 0 : 1 ?> " class="hide_menu"><?= $row->hide_menu_submission_plan ? 'Show' : 'Hide' ?> Submission Plan Menu</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-section="hide_menu_direct_application" data-id="<?= $row->grantee_grant_id ?>" data-value="<?= $row->hide_menu_direct_application ? 0 : 1 ?> " class="hide_menu"><?= $row->hide_menu_direct_application ? 'Show' : 'Hide' ?> Direct Application Menu</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-section="hide_menu_submission_result" data-id="<?= $row->grantee_grant_id ?>" data-value="<?= $row->hide_menu_submission_result ? 0 : 1 ?> " class="hide_menu"><?= $row->hide_menu_submission_result ? 'Show' : 'Hide' ?>  Submission Result Menu</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-section="show_direct_application" data-id="<?= $row->grantee_grant_id ?>" data-value="<?= $row->show_direct_application ? 0 : 1 ?> " class="hide_menu"> Instanly Show Direct Application Menu <?= $row->show_direct_application ? '(Active)' : '(Inactive)' ?> </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
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
<?php $this->load->view('admin/partials/modal_download_excel') ?>


<div class="modal fade" id="modal_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <ul id="status_list" class="list-group"></ul>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDownloadNominee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form-download-excel" action="<?= base_url('admin/candidate/download_excel') ?>">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Download Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label><b>Select Program(s)</b></label>
                            <select name="program_ids[]" id="filter-programs" class="form-control select2" multiple>
                                <?php
                                    $program_ids = isset($_GET['program_ids']) ? (array) $_GET['program_ids'] : [];
                                ?>
                                <?php foreach($program_available as $program) { ?>
                                    <option value="<?php echo $program->id; ?>" <?= (!empty($program_ids) && is_array($program_ids) && in_array($program->id, $program_ids)) ? 'selected' : '' ?>
                                    ><?php echo $program->name; ?></option>
                                <?php } ?>
                            </select>
                            <small class="text-danger d-none text-validation-program" id="text-validation-program">Please select at least one program</small>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <label><b>Select Period</b></label>
                            <select name="period" class="form-control selectpicker" data-live-search="true">
                                <option value="">-- Select Period --</option>
                                <?php foreach($available_period as $period) { ?>
                                    <?php if (empty($period->fiscal_year) || $period->fiscal_year <= 0) continue; ?>
                                    <option value="<?php echo $period->fiscal_year; ?>" <?php echo date('Y') == $period->fiscal_year ? 'selected' : ''; ?>><?php echo $period->fiscal_year; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="field_row hide">
                            <div class="col-md-12">
                                <ul class="list-style-none p-0">
                                    <li>
                                        <div class="form-check">
                                            <label><input id="sel-all" type="checkbox" checked> Select All </label> 
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <b>Personal Information</b>
                                </div>
                            </div>
                            <div class="row pr-4">
                            
                            <?php foreach (array_split($all_field, 4) as $key_a_f => $a_f) : ?>
                                <div class="col-md-3">
                                    <ul class="list-style-none pl-4">
                                        <?php foreach ($a_f as $key => $value) : ?>
                                            <?php
                                                $current_key = explode('_', $key);
                                                $field_property = '';
                                                if ($current_key[0] == 'emergency') {
                                                    $field_property = 'emergency_contact_field';
                                                }
                                            ?>
                                            <li>
                                                <div class="form-check">
                                                    <table>
                                                        <tr>
                                                            <td style="vertical-align: top !important;">
                                                                <input type="checkbox" name="field_alumni[]" class="form-check-input field-alumni mr-1" id="field_alumni_check<?= $key ?>" value="<?= "$key *-* $value" ?><?php echo !empty($field_property) ? " *-* " . $field_property : ""; ?>">
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
                            <div class="col-md-12 d-none text-center text-validation mb-4" id="text-validation-field">
                                <small class="text-danger">Select at least one field</small>
                            </div>
                        </div>
                        <div class="col-md-12 hide">
                            <div class="radio d-inline mr-4">
                                <label><input type="radio" class="grant-alumni" name="grant_option" style="margin-top:1px" value="single_grant" checked>Single Grant</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-success">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select PIC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('admin/candidate/set_pic')?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="grantee_grant_id_for_pic" id="grantee_grant_id_for_pic">
                            <select name="pic" class="form-control selectpicker" id="selectpickerPic" data-live-search="true">
                            <option value="">-- Select PIC --</option>
                                <?php foreach($pics as $pic) { ?>
                                    <option value="<?= $pic->id ?>"><?= $pic->full_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>