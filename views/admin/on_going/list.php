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
        <h1 class="page-header">Ongoing</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
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
                        <select class="form-control" name="status_section" onchange="document.forms.frm_manage.submit()">
                            <?php
                            $search_by = $_GET['status_section'];
                            foreach ($filter_status as $field => $val) {
                                $selected = '';
                                if (isset($search_by) && $search_by == $field) {
                                    $selected = 'selected="selected"';
                                }
                                ?>
                                <option
                                    value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo str_ireplace('On Going', 'Ongoing', $val);?></option>
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
                            <th>Final Placement</th>
                            <th>Field of Study</th>
                            <th <?php echo sorting_attribute('fiscal_year', $sort_by, $sort) ?>>Period</th>
                            <th <?php echo sorting_attribute('pic_nominee', $sort_by, $sort) ?>>PIC</th>
                            <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                    <td><?php echo $row->university_name; ?></td>
                                    <td><?php echo $row->field_of_study_input ?? ($row->field_of_study_id ? get_field_of_study_by_id($row->field_of_study_id)->name : '') ?></td>
                                    <td><?php echo $row->fiscal_year; ?></td>
                                    <td><?php echo $row->pic_nominee_name; ?></td>
                                    <td><?php  echo str_ireplace('On Going', 'Ongoing', $row->status_name); ?></td>
                                    <td class="text-center" style="position:relative;">
                                        <button type="button" class="btn btn-primary btn-xs select_pic" data-selected="<?= $row->pic_nominee ?>" data-grantee_grant_id ="<?= $row->grantee_grant_id ?>" title="Select PIC"><i class="fa fa-user"></i></button>
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
                                        <a class="btn btn-primary btn-xs" href="<?= base_url('admin/on_going/detail/' . $row->grantee_grant_id) ?>">Detail</a>
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-gear fa-fw"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <?php if(has_permission('on_going', 'payment')) { ?>
                                            <li>
                                                <a href="<?php  echo site_url('admin/payment_record/payment/on_going/' . $row->id) ?>">Payment</a> 
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('on_going', 'verify')) { ?>
                                            <li>
                                                <a href="<?php  echo site_url('admin/on_going/verify/' . $row->grantee_grant_id) ?>">Verify</a> 
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('on_going', 'verify')) { ?>
                                            <li>
                                                <a href="<?php  echo site_url('admin/grantee/view_procedures/' . $row->grantee_grant_id) ?>">View All Procedures</a> 
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('on_going', 'set_to_nominee')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="on_going" class="previous_status">Set to Nominee</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('on_going', 'set_to_returning')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" class="succesfully">Set to Returning</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('on_going', 'reject')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="on_going" class="reject">Reject</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('on_going', 'drop')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="on_going" class="drop">Drop</a>
                                            </li>
                                            <?php } ?>
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

<div class="modal fade" id="mdl_note_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <textarea class="form-control" name="note_reject" id="note_reject" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn-save-note" class="btn btn-primary success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_note_drop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <textarea class="form-control" name="note_drop" id="note_drop" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn-save-note-drop" class="btn btn-primary success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/form_filter') ?>

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