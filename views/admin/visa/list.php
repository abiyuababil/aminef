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
            Visa
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
                                    value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val == 'On Going' ? 'Ongoing' : $val; ?></option>
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
                            <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
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
                                    <td><?php  echo str_ireplace('On Going', 'Ongoing', $row->status_name); ?></td>
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
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-xs" href="<?= base_url('admin/visa/detail/' . $row->grantee_grant_id) ?>">Detail</a>
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
                            <select name="pic" class="form-control selectpicker" id="selectpickerPic" data-live-search="true" required>
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