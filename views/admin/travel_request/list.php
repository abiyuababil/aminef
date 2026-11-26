<style>
    .program-filter-section {
        display: flex;
    }

    .program-filter-section > .form-group {
        width: 350px;
        margin-left: 12px;
    }

    label {
        font-weight: normal !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Leave Request
            <a href="<?php echo site_url('admin/travel_request/download_excel'); ?>" style="margin-right: 5px;" class="btn btn-primary btn-sm pull-right" title="Export Leave">
                DOWNLOAD EXCEL
            </a>
        </h1>
    </div>
</div>
<?php
if ($this->session->flashdata('error')) :
    echo show_alert('danger', $this->session->flashdata('error'));
endif;
?>
<?php if($this->session->flashdata('success_leave')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success_leave') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success_leave');?>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>
        <form id="frm_manage" method="GET">
            <div class="row mb-4 program-filter-section">
                <div class="form-group select-program">
                    <label for="">Fiscal Year</label>
                    <select class="form-control input-sm mr-2" name="fiscal_year" onchange="document.forms.frm_manage.program.value=''; document.forms.frm_manage.submit();">
                        <option value="" <?php echo $this->input->get('fiscal_year') ? '' : 'selected'; ?>>All</option>
                        <?php
                        $active_fiscal_year = $this->input->get('fiscal_year');
                        foreach ($fiscal_years as $fiscal_year) {
                            if (!is_numeric($fiscal_year->fiscal_year) || $fiscal_year->fiscal_year == 0) {
                                continue;
                            }
                            $selected = $active_fiscal_year == $fiscal_year->fiscal_year ? 'selected' : '';
                            ?>
                            <option value="<?php echo $fiscal_year->fiscal_year ?>" <?php echo $selected; ?>><?php echo $fiscal_year->fiscal_year ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group select-program">
                    <label for="">Grant</label>
                    <select class="form-control input-sm mr-2" name="program" onchange="document.forms.frm_manage.submit()" <?php echo $active_fiscal_year ? '' : 'disabled'; ?>>
                        <?php if (!$active_fiscal_year) { ?>
                            <option value="">Select fiscal year first</option>
                        <?php } else { ?>
                            <option value="">-- Select Grant --</option>
                            <?php foreach($grants as $grant) { ?>
                            <option value="<?= $grant->id ?>" <?= $this->input->get('program') == $grant->id ? 'selected' : ''?>><?php echo $grant->name; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group select-program">
                    <label for="">Leave Category</label>
                    <select class="form-control input-sm mr-2" name="leave_category" onchange="document.forms.frm_manage.submit()">
                        <option value="">-- Select Leave Category --</option>
                        <option value="<?= PERSONAL_TRAVEL ?>" <?= $this->input->get('leave_category') == PERSONAL_TRAVEL ? 'selected' : ''?>>Personal Travel</option>
                        <option value="<?= SICK_LEAVE ?>" <?= $this->input->get('leave_category') == SICK_LEAVE ? 'selected' : ''?>>Sick Leave</option>
                        <option value="<?= EMERGENCY_LEAVE ?>" <?= $this->input->get('leave_category') == EMERGENCY_LEAVE ? 'selected' : ''?>>Emergency Leave</option>
                        <option value="<?= RESEARCH_TRAVEL ?>" <?= $this->input->get('leave_category') == RESEARCH_TRAVEL ? 'selected' : ''?>>International Research Travel</option>
                    </select>
                </div>
                <div class="form-group select-program">
                    <label for="">Status</label> 
                    <?php $get_status = $this->input->get('status')?>
                    <select class="form-control input-sm mr-2" name="status" onchange="document.forms.frm_manage.submit()">
                        <option value="">-- Select Status --</option>
                        <option value="<?= LEAVE_PENDING ?>" <?= isset($get_status) && $this->input->get('status') == LEAVE_PENDING && $this->input->get('status') != '' ? 'selected' : ''?>>PENDING</option>
                        <option value="<?= LEAVE_APPROVE ?>" <?= isset($get_status) && $this->input->get('status') == LEAVE_APPROVE ? 'selected' : ''?>>APPROVE</option>
                        <option value="<?= LEAVE_REJECT ?>" <?= isset($get_status) && $this->input->get('status') == LEAVE_REJECT ? 'selected' : ''?>>REJECT</option>
                    </select>
                </div>
            </div>
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit']) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <div class="pull-right">
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
                                        <option value="<?= $field ?>" <?= $selected; ?>><?= $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?= $q[$i] ?>" placeholder="" onkeypress="return submitFilter(event)">
                            <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-fw"></i></a>
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
                            <th width="10" class="text-center">#</th>
                            <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                            <th>Grants</th>
                            <th>Fiscal Year</th>
                            <th>Leave Category</th>
                            <th>Leave (day)</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th class="text-center" width="10px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                $join = [
                                    ['am_user_grantee_grant', 'am_user_grantee_grant.id = am_grantee_grant.grant_id', 'LEFT']
                                ];
                                $grantee_grant = get_row_db('am_grantee_grant', ['am_grantee_grant.id' => $row->grantee_grant_id], null, $join);
                                $leave_applications = get_available_leave($row->grantee_grant_id);
                                $active_grant = get_row_db('am_grantee_grant', ['am_grantee_grant.id' => $row->grantee_grant_id], ['am_grantee_grant.personal_travel', 'am_grantee_grant.sick_leave','am_grantee_grant.emergency_leave', 'am_grantee_grant.research_leave'], $join);

                                $personal_travel = [];
                                $sick_leave = [];
                                $emergency_leave = [];
                                $research_leave = [];
                                foreach($leave_applications as $kla => $la) {
                                    $end = strtotime($la->end_date);
                                    $start = strtotime($la->start_date);
                                    $this_year = date('Y');
                                    if($la->leave_category == PERSONAL_TRAVEL){
                                        array_push($personal_travel, $la->total_request);
                                    }
                                    if($la->leave_category == SICK_LEAVE){
                                        array_push($sick_leave, $la->total_request);
                                    }
                                    if($la->leave_category == EMERGENCY_LEAVE){
                                        array_push($emergency_leave, $la->total_request);
                                    }
                                    if($la->leave_category == RESEARCH_TRAVEL){
                                        array_push($research_leave, $la->total_request);
                                    }
                                }

                                $remainig_leave = '';
                                switch($row->leave_category) {
                                    case PERSONAL_TRAVEL :
                                        $max_personal_travel = $grantee_grant->personal_travel;
                                        if ((int) $max_personal_travel <= 0) {
                                            $max_personal_travel = $active_grant->personal_travel;
                                        }
                                        $remainig_leave = $max_personal_travel - array_sum($personal_travel) . ' day(s) remaining out of ' . $max_personal_travel . ' days of Personal Travel ';
                                        break;
                                    case SICK_LEAVE : 
                                        $max_sick_leave = $grantee_grant->sick_leave;
                                        if ((int) $max_sick_leave <= 0) {
                                            $max_sick_leave = $active_grant->sick_leave;
                                        }
                                        $remainig_leave = $max_sick_leave - array_sum($sick_leave) . ' day(s) remaining out of ' . $max_sick_leave . ' days of Sick Leave ';
                                        break;
                                    case EMERGENCY_LEAVE :
                                        $max_emergency_leave = $grantee_grant->emergency_leave;
                                        if ((int) $max_emergency_leave <= 0) {
                                            $max_emergency_leave = $active_grant->emergency_leave;
                                        }
                                        $remainig_leave = $max_emergency_leave - array_sum($emergency_leave) . ' day(s) remaining out of ' . $max_emergency_leave . ' days of Emergency Leave ';
                                        break;
                                    case RESEARCH_TRAVEL :
                                        $max_research_leave = $grantee_grant->research_leave;
                                        if ((int) $max_research_leave <= 0) {
                                            $max_research_leave = $active_grant->research_leave;
                                        }
                                        $remainig_leave = $max_research_leave - array_sum($research_leave) . ' day(s) remaining out of ' . $max_research_leave . ' days of International Research Travel';
                                        break;
                                }
                                
                                $now = strtotime($row->end_date);
                                $your_date = strtotime($row->start_date);
                                $datediff = $now - $your_date;
                                $leave_day = total_day_leave($row->start_date, $row->end_date);
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><a target="_blank" href="<?php echo site_url('admin/grantee/edit/' . $grantee_grant->user_grantee_id . '/' . $grantee_grant->id . '?pid=leave'); ?>" class="text-primary" style="cursor: pointer;" title="<?php echo $remainig_leave; ?>"><?= get_full_name($row, 'US')?></a></td>
                            <td><?= $row->grant_name ?></td>
                            <td><?= $row->fiscal_year ?></td>
                            <td><?= get_label_leave_category($row->leave_category) ?></td>
                            <td><?= $row->total_request ?> Day</td>
                            <td><?= date('d M Y', strtotime($row->start_date))?></td>
                            <td><?= date('d M Y', strtotime($row->end_date))?></td>
                            <td><?= date('d M Y H:i:s', strtotime($row->date_insert))?></td>
                            <td><?= get_label_status_leave($row->status) ?></td>
                            <td>
                                <!-- <a href="javascript:;" data-toggle="modal" data-target="#mdl_detail_leave" data-leave-id="<?= $row->id ?>" data-gratee-grant-id="<?= $row->grantee_grant_id ?>" class="btn btn-primary btn-xs">Action</a> -->
                                <a href="<?= base_url('admin/travel_request/detail/' . $row->id ) ?>" class="btn btn-primary btn-xs mb-2">Action</a>
                                <input data-log="<?= $row->id ?>" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default modal-log-leave" value="Open Log" style="font-size:12px;">
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
                Showing <?= $paging['start_row'] ?> to <?= $paging['end_row'] ?>
                of <?= number_format($paging['total_rows']) ?> entries
            </div>
            <!-- /.pagination info -->
            <?= $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?= $sort_by ?>">
            <input type="hidden" name="sort" value="<?= $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div id="template-filter" style="display:none">
    <div class="pull-right" style="margin-top:5px; clear:both;">
        <div class="form-group">
            <select class="form-control" name="cnj[]">
                <option value="AND">AND</option>
                <option value="OR">OR</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="search_by[]">
                <?php
                foreach ($filters as $field => $val) {
                ?>
                    <option value="<?= $field ?>"><?= $val ?></option>
                <?php } ?>
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        Keyword : <input type="search" class="form-control input-sm" name="q[]" value="" placeholder="" onkeypress="return submitFilter(event)">
        <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-fw"></i></a>
    </div>
</div>

<!-- modal detail leave -->
<div class="modal fade" id="mdl_detail_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Detail Grantee Travel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form autocomplete="new-password" role="form" id="form_status_leave" method="POST" enctype="multipart/form-data" action="">
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label>Travel Category</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="leave_category" value="" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label>Travel (day)</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="leave_day" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="destination_form">
                    <div class="col-lg-4">
                        <label>Destination</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="destination" value="" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label id="label_start">Date of Departure from Site</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="start_date" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="section_departure_indo_date">
                    <div class="col-lg-4">
                        <label>Date of Departure from Indonesia</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="departure_indo_date" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="section_arrival_indo_date">
                    <div class="col-lg-4">
                        <label>Date of Arrival in Indonesia</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="arrival_indo_date" value="" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label id="label_end">Date of Arrival at Site</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="end_date" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="section_departure_time">
                    <div class="col-lg-4">
                        <label>Departure Time</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="departure_time" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="destination_purpose_form">
                    <div class="col-lg-4">
                        <label>Destination Purpose</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="destination_purpose" value="" readonly>
                    </div>
                </div>
                <!-- <div class="row form-group" id="section_departure_site_date">
                    <div class="col-lg-4">
                        <label>Date of Departure from Site</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="departure_site_date" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="section_arrival_site_date">
                    <div class="col-lg-4">
                        <label>Date of Arrival from Site</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="arrival_site_date" value="" readonly>
                    </div>
                </div> -->
                
                <div class="row form-group" id="form_upload">
                    <div class="col-lg-4">
                        <label>Form Upload</label>
                    </div>
                    <div class="col-lg-6">
                        <a href="" class="btn btn-primary lightbox" id="form_upload_file">Preview</a>
                    </div>
                </div>
                
                <div class="row form-group" id="section_research_travel">
                    <div class="col-lg-4">
                        <label>International Research Travel Activities</label>
                    </div>
                    <div class="col-lg-6">
                        <!-- <textarea type="text" class="form-control" id="research_travel" style="resize: none;" rows="6" readonly></textarea> -->
                        <div id="research_travel" class="form-control" style="resize: none; white-space: pre-wrap; word-wrap: break-word; min-height: 200px; overflow-y: auto;" readonly></div>
                         
                    </div>
                </div>
                <!-- <div class="row form-group" id="boarding_pass_form">
                    <div class="col-lg-4">
                        <label>Borading Pass</label>
                    </div>
                    <div class="col-lg-6">
                        <a href="" class="btn btn-primary lightbox" id="borading_pass_file">Preview</a>
                    </div>
                </div> -->
                <div class="row form-group hide" id="telephone">
                    <div class="col-lg-4">
                        <label>Telephone</label>
                    </div>
                    <div class="col-lg-6">
                    <input type="text" class="form-control" id="telephone_val" value="" readonly>
                    </div>
                </div>
                <div class="row form-group hide" id="email">
                    <div class="col-lg-4">
                        <label>Email</label>
                    </div>
                    <div class="col-lg-6">
                    <input type="text" class="form-control" id="email_val" value="" readonly>
                    </div>
                </div>
                <div class="row form-group hide" id="address">
                    <div class="col-lg-4">
                        <label>Address</label>
                    </div>
                    <div class="col-lg-6">
                    <textarea class="form-control" id="address_val" readonly></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label>Status</label>
                    </div>
                    <div class="col-lg-6" id="status-ddown">
                        <select class="form-control" id="status" name="status">
                            <option value="<?= LEAVE_PENDING ?>">Pending</option>
                            <option value="<?= LEAVE_APPROVE ?>">Approve</option>
                            <option value="<?= LEAVE_REJECT ?>">Reject</option>
                        </select>
                        <input type="hidden" name="id" id="leave_id" value="">
                    </div>
                    <div class="col-lg-6 hide" id="status-cancel">
                        <input type="text" class="form-control" id="v_status" disabled>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label>Note</label>
                    </div>
                    <div class="col-lg-6">
                        <textarea class="form-control" name="note" id="note"></textarea>
                    </div>
                </div>
                <div id="data_table"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-save" form="form_status_leave">Save</button>
            </div>
        </div>
    </div>
</div>
<?php
if (!empty($data)) :
    $final_leave = [];
    foreach ($data as $row) {
        $now = strtotime($row->end_date);
        $your_date = strtotime($row->start_date);
        $datediff = $now - $your_date;
        $leave_day = total_day_leave($row->start_date, $row->end_date);
        $row->leave_day = $leave_day;
        $row->category_name = get_label_leave_category($row->leave_category);
        $final_leave[$row->id] = $row;
    }
?>
    <script>
        var currentLeaveApps = JSON.parse(`<?php echo safe_parse_json(json_encode($final_leave)); ?>`);
    </script>
<?php endif; ?>


<?php $this->load->view('admin/partials/modal_log') ?>