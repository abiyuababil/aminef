<style>
        #wrap-filter .select2 {
            border-radius: 0px !important;
            width: 250px !important;
            height: 35px !important;
            padding-top: 2px !important;
            /* border: 1px solid #ccc; */
        }

        #wrap-filter span.select2.select2-container{
            border-radius: 0px !important;
            width: 250px !important;
            height: 34px !important;
            padding-top: 2px !important;
            /* border: 1px solid #ccc; */
        }

        #wrap-filter .select2-selection.select2-selection--single {
            border-radius: 0px !important;
            width: 250px !important;
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
        <h1 class="page-header">Application
            <a href="<?php echo site_url('/admin/application/download_documents/'); ?>" class="btn btn-primary btn-sm pull-right ml-2">
                DOWNLOAD DOCUMENTS
            </a>
            <a href="javascript:;" onclick="show_download_modal('<?=http_build_query($_GET)?>')"
               class="btn btn-primary btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                DOWNLOAD EXCEL
            </a>
            
        </h1> 
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
                    <!-- <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <?php if(has_permission('selection', 'delete')) { ?>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul>
                        <?php } ?>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div> -->

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
                    <div class="form-group">
                        Status
                        <select class="form-control" name="status_section" onchange="document.forms.frm_manage.submit()">
                            <option value="">All</option>
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
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?php echo isset($q[0]) ? $q[0] : '' ?>"
                                     placeholder="" onkeypress="return submitFilter(event)">
                    <a href="javascript:;" onclick="add_filter()" class="btn btn-success btn-sm"><i
                            class="fa fa-plus fa-fw"></i></a>
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
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('grantee_name', $sort_by, $sort) ?>>Name</th>
                            <th <?php echo sorting_attribute('grants_name', $sort_by, $sort) ?>>Grants</th>
                            <th <?php echo sorting_attribute('period', $sort_by, $sort) ?>>Period</th>
                            <th <?php echo sorting_attribute('submited_date', $sort_by, $sort) ?>>Submission Date</th>
                            <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
                            <th width="200">Note</th>
                            <th width="200" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {

                            // $no = $paging['start_row'];
                            $no = $paging['start_row'];
                            foreach ($data as $row) {

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
                                    <td><a target="_BLANK" href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id); ?>" class="<?= $row->blacklist ? 'text-danger font-weight-bold' : '' ?>"><?php echo $fullname ?></a></td>
                                    <td><?php echo $row->program_name; ?></td>
                                    <td><?php echo $row->fiscal_year; ?></td>
                                    <td><?php echo $row->submission_date ? format_date_time($row->submission_date) : ''; ?></td>
                                    <td><?php echo $row->status_name; ?></td>
                                    <td>
                                        <a target="_BLANK" class="text-danger" href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id); ?>">
                                        <?php 
                                            if($row->other_account){
                                                if ($row->other_account->status == STATUS_SELECTION_DECLINED) {
                                                    echo strlen($row->other_account->note_selection) > 50 ? substr($row->other_account->note_selection, 0, 50) . '....' : $row->other_account->note_selection;
                                                }else if($row->other_account->status == STATUS_CANDIDATE_DECLINED){
                                                    echo strlen($row->other_account->note_candidate) > 50 ? substr($row->other_account->note_candidate, 0, 50) . '....' : $row->other_account->note_candidate;
                                                }else if($row->other_account->status == STATUS_ON_GOING_DECLINED){
                                                    echo strlen($row->other_account->note_ongoing) > 50 ? substr($row->other_account->note_ongoing, 0, 50) . '....' : $row->other_account->note_ongoing;
                                                }
                                            }
                                        ?>
                                        </a>
                                    </td>
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
                                        <?php if($row->status_name == 'Selection Verified' || $row->status_name == 'Waiting For Interview' || $row->status_name == 'Interview') { ?>
                                            <a href="<?= site_url('admin/set_interview/form/'. $row->grantee_grant_id) ?>" class="btn btn-success btn-xs">
                                                <i class="fa fa-file-text"></i> Set Interview
                                            </a>
                                        <?php } ?>
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-gear fa-fw"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <?php if(has_permission('submitted', 'payment')) { ?>
                                            <li>
                                                <a href="<?php echo site_url('admin/payment_record/payment/application/' . $row->id) ?>">Payment</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('submitted', 'verify')) { ?>
                                            <li>
                                                <a href="<?= site_url('admin/application/verify/' . $row->grantee_grant_id) ?>">Verify</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('submitted', 'reject')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="selection" class="reject">Reject</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('submitted', 'drop')) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="selection" class="drop">Drop</a>
                                            </li>
                                            <?php } ?>
                                            <?php if($row->status_id == STATUS_SELECTION_DECLINED) { ?>
                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="selection" class="submitted">Set to Submitted</a>
                                            </li>
                                            <?php } ?>
                                            <!-- <li>
                                                <a href="#" data-id="<?= $row->grantee_id ?>" class="succesfully">Set to Candidate</a>
                                            </li> -->
                                            <?php if(has_permission('submitted', 'missing_document')) { ?>
                                            <li>
                                                <a href="<?= site_url('admin/missing_document/manage/'. $row->grantee_grant_id) ?>" data-id="<?= $row->grantee_grant_id ?>" data-section="selection" class="missing_document">Missing Document</a>
                                            </li>

                                            <li>
                                                <a href="#" data-id="<?= $row->grantee_grant_id ?>" data-section="selection" class="send_email_recommendation">Notify Recommenders</a>
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
<?php $this->load->view('admin/partials/modal_confirm') ?>
<?php $this->load->view('admin/partials/form_filter') ?>
<!-- Modal Download -->
<?php $this->load->view('admin/partials/modal_download_excel') ?>
<?php $this->load->view('admin/partials/modal_send_email_recommendation') ?>