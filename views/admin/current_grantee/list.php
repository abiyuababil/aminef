<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Current Grantee
            <a href="<?php echo site_url('admin/current_grantee/download_pdf?' . $params) ?>" class="btn btn-primary btn-sm pull-right" title="Export Current Grantee dalam format file pdf">
                DOWNLOAD PDF
            </a>
            <a href="javascript:;" style="margin-right: 5px;" onclick="show_download_modal_grantee('<?=http_build_query($_GET)?>')"
               class="btn btn-primary btn-sm pull-right" title="Export Data Grantee dalam format file excel">
                DOWNLOAD EXCEL
            </a>
            <!-- <a href="<?php echo site_url('admin/current_grantee/download_excel?' . $params) ?>" style="margin-right: 5px;" class="btn btn-primary btn-sm pull-right" title="Export New Grantee dalam format file pdf">
                DOWNLOAD EXCEL
            </a> -->
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<?php if (isset($import_success) && is_numeric($import_success)) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Sukses melakukan import sebanyak total <?= $import_success ?> data Alumni.
    </div>
<?php } ?>

<?php
if ($this->session->flashdata('error')) :
    echo show_alert('danger', $this->session->flashdata('error'));
endif;
?>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <!-- <table width="100%" style="border-spacing: 10px;">
                    <tbody>
                        <tr>
                            <td width="20%"><label>Permit Papers Status</label></td>
                            <td>
                                <select class="form-control input-sm" name="permit_papers_status" onchange="document.forms.frm_manage.submit()">
                                    <option value="">All</option>
                                    <?php foreach ($permit_papers_status as $option_permit_papers_status) { ?>
                                        <?php $selected = $option_permit_papers_status->id == $paging["permit_papers_status"] ? "selected" : ""; ?>
                                        <option <?= $selected ?> value="<?= $option_permit_papers_status->id ?>"><?= $option_permit_papers_status->name; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Report Status</label></td>
                            <td>
                                <select class="form-control input-sm" name="report_status" onchange="document.forms.frm_manage.submit()">
                                    <option value="">All</option>
                                    <?php foreach ($report_status as $option_report_status) { ?>
                                        <?php $selected = $option_report_status->id == $paging["report_status"] ? "selected" : ""; ?>
                                        <option <?= $selected ?> value="<?= $option_report_status->id ?>"><?= $option_report_status->name; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Grants</label></td>
                            <td>
                                <select class="form-control input-sm" name="program" onchange="document.forms.frm_manage.submit()" style="width:250px">
                                    <option value="">All</option>
                                    <?php
                                    foreach ($program_available as $pa) {
                                        $selected = '';
                                        if ($pa->id == $paging['program']) {
                                            $selected = 'selected';
                                        }
                                    ?>
                                        <option value="<?= $pa->id ?>" <?= $selected ?>><?= $pa->name ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Search</label></td>
                            <td><input class="form-control input-sm" type="text" name="search" value="<?= $paging['search'] ?>"></td>
                        </tr>
                    </tbody>
                </table> -->
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
                    entries &nbsp; &nbsp;
                    
                    Fiscal Year
                    <select class="form-control input-sm" name="fiscal_year" onchange="document.forms.frm_manage.grant_id.value=''; document.forms.frm_manage.submit();">
                        <option value="" <?php echo $this->input->get('fiscal_year') ? '' : 'selected'; ?>>All</option>
                        <?php
                        $active_fiscal_year = $this->input->get('fiscal_year');
                        foreach ($fiscal_years as $fiscal_year) {
                            if (!is_numeric($fiscal_year->fiscal_year) || $fiscal_year->fiscal_year == 0) {
                                continue;
                            }
                            $selected = '';
                            if ($active_fiscal_year == $fiscal_year->fiscal_year) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?php echo $fiscal_year->fiscal_year ?>" <?php echo $selected; ?>><?php echo $fiscal_year->fiscal_year ?></option>
                        <?php } ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Program
                    <select class="form-control input-sm" name="grant_id" onchange="document.forms.frm_manage.submit()" style="width: 200px;" <?php echo $active_fiscal_year ? '' : 'disabled'; ?>>
                        <?php if (!$active_fiscal_year) { ?>
                            <option value="">Select fiscal year first</option>
                        <?php } else { ?>
                            <option value="" <?php echo $this->input->get('grant_id') ? '' : 'selected'; ?>>All</option>
                            <?php
                            $active_program = $this->input->get('grant_id');
                            foreach ($programs as $program) {
                                $selected = '';
                                if ($active_program == $program->grant_id) {
                                    $selected = 'selected';
                                }

                                ?>
                                <option value="<?php echo $program->grant_id ?>" <?php echo $selected ?>><?php echo $program->name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
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
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th width="10" class="text-center">#</th>
                            <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                            <th>Grants</th>
                            <th>Fiscal Year</th>
                            <th>Status</th>
                            <th class="text-left">Section</th>
                            <!-- <th class="text-center">Permit Papers Status</th> -->
                            <th class="text-left">Report Status</th>
                            <th width="200" class="text-left">Payment Status</th>
                            <th class="text-left">Completion Status</th>
                            <th class="text-right" width="10px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                $join_program = '';
                                $join_program .= '<ul>';

                                $available_program = [];
                                foreach ($row->programs as $key => $value) {
                                    $year_departure = '';
                                    if ($value['year_departure']) {
                                        $year_departure = " ({$value['year_departure']})";
                                    }

                                    if (!isset($available_program[$value['user_program_id']])) {
                                        $available_program[$value['user_program_id']] = 'Avail';
                                        $join_program .= '<li>' . $value['program_name'] . $year_departure . '</li>';
                                    }
                                }
                                $join_program .= '</ul>';

                                // echo '<pre>';print_r($row);die;
                        ?>
                                <tr>
                                    <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" style="vertical-align:middle"><?= $no ?></td>
                                    <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" style="vertical-align:middle" class="text-left"><a href="<?= site_url('admin/grantee/edit/' . $row->user_grantee_id . '/' . $row->grant_id); ?>"><?= $row->fullname ?></a></td>
                                    <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" style="vertical-align:middle" class="text-left"><a href="<?= site_url('admin/user_grantee_grant/category/' . $row->grant_id) ?>"><?= $row->program_name ?></a></td>
                                    <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" style="vertical-align:middle" class="text-left"><?= $row->fiscal_year ?></td>
                                    <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" style="vertical-align:middle" class="text-left"><?= $row->status_name ?></td>
                                    <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" style="vertical-align:middle" class="text-left">
                                        <?php foreach ($row->category as $key => $val) {  ?>
                                            <?php 
                                                $document_status = null;
                                                $submit_date = null;
                                                $category_status = get_row_db('am_grantee_grant_category_status', ['category_id' => $val->id, 'grantee_grant_id' => $row->id_grantee_grant]);
                                                if ($category_status) {
                                                    $document_status = $category_status->status;
                                                    $submit_date = $category_status->status == DOCUMENT_SUBMITTED ? $category_status->submitted_date : $category_status->completed_date;
                                                } else {
                                                    if (in_array($val->name, ['Grant Information', 'Grant Profile'])){
                                                        $document_status = $row->grant_document_status;
                                                    } elseif (in_array($val->name, ['Permit Application', 'Pre Arrival Documents','Pre-Arrival Documents'])) {
                                                        $document_status = $row->pre_arrival_document_status;
                                                    } elseif (in_array($val->name, ['Indonesian Host Information'])) {
                                                        $document_status = $row->indonesian_host_information_status;
                                                    }
                                                }
                                                
                                                $document_statuses = get_document_statuses($document_status, $submit_date);
                                            ?>
                                            <a style="margin-bottom: 5px;" href="<?= site_url('admin/incoming_grantee/submission/' . $row->id_grantee_grant . '/' . $val->id) ?>" class="btn <?php echo $document_statuses['class']; ?> btn-xs">
                                                <?php echo $document_statuses['icon']; ?>
                                                <?= $val->name ?>
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <!-- <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" style="vertical-align:middle" class="text-left"><span class="<?= get_document_status_badge($row->permit_papers_status) ?>"><?= $row->permit_papers_status_name ? $row->permit_papers_status_name : '-' ?></span></td> -->
                                    <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" style="vertical-align:middle" class="text-left"><span class="<?= get_document_status_badge($row->report_status) ?>"><?= $row->report_status_name ? $row->report_status_name : '-' ?></span></td>
                                    <td class="text-left"><?= $row->payment[0]['payment_name'] ?> <span class="text-info" style="float:right"><?= $row->payment[0]['status_name'] ?></span></td>
                                    <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" class="text-left"><?= $row->completion_status_name ?></td>
                                    <td rowspan="<?php echo count($row->payment) == 0 ? 1 : count($row->payment) ?>" class="text-right">
                                        <button type="button" class="btn btn-info btn-xs dropdown-toggle mb-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Change Status
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" style="top:auto">
                                            <li><a href="javascript:;" onclick="not_completion(<?= $row->id ?>, <?= $row->id_grantee_grant ?>, <?= $row->grant_id ?>)">Not Completed</a></li>
                                            <!-- <li><a href="javascript:;" onclick="completion(<?= $row->id ?>, <?= $row->id_grantee_grant ?>, <?= $row->grant_id ?>)">Completed </a></li> -->
                                            <li><a href="javascript:;" data-id="<?= $row->id ?>" data-id-grantee-grant="<?= $row->id_grantee_grant ?>" data-grant-id="<?= $row->grant_id ?>" data-periodto="<?= $row->period_to ?>" data-source="<?= $row->source_id ?>" class="completed">Completed </a></li>
                                        </ul>
                                        <span title="<?= $row->is_locked ? $row->is_locked['date_modified'] . " - " . $row->is_locked['name'] : "" ?>"><a class="btn btn-primary btn-xs" <?= $row->is_locked ? "disabled" : ""; ?> href="<?php echo site_url('admin/request_payment/edit/' . $row->id . '/' . $row->id_grantee_grant) ?>"><i class="fa fa-money fa-fw"></i>  Payment</a></span>
                                        <a href="<?php echo site_url('admin/grantee/download_all_document/' . $row->id_grantee_grant) ?>" target="_blank" class="btn btn-xs btn-primary mt-1"><i class="fa fa-download fa-fw"></i> Download All Document</a>
                                    </td>
                                </tr>
                                <?php if (count($row->payment) > 1) {
                                    for ($i = 1; $i < count($row->payment); $i++) {
                                ?>
                                        <tr>
                                            <td class="text-left"><?= $row->payment[$i]['payment_name'] ?> <span class="text-info" style="float:right"><?= $row->payment[$i]['status_name'] ?></span></td>
                                        </tr>
                                <?php }
                                } ?>

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

<div class="modal fade bs-example-modal-sm" id="mdl_date" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Completion Date</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="search_alumni">Search & Select Alumni</label>
                    <select name="search_alumni" id="search_alumni" class="form-control selectpicker" data-live-search="true">
                        <option value="">Search Alumni</option>
                        <?php foreach($alumni as $al) { ?>
                            <option value="<?= $al->id ?>"><?= get_full_name($al, 'US') ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="completion_date">Completion Date</label>
                    <input readonly style="background-color:#fff" type="text" class="form-control datepicker" id="completion_date">
                </div>
                <div class="form-group mt-2">
                    <input type="checkbox" value="1" name="without_notif" id="without_notif">
                    <label for="without_notif"> Completed without notification</label>
                </div>
                <div class="form-group mt-2">
                    <input type="checkbox" value="1" name="update_alumni_data" id="update_alumni_data" checked>
                    <label for="update_alumni_data"> Update alumni profile with new grantee data</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn-completed">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="mdl_confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="text-center">Are you sure to set this Grantee to Alumni ?</h4>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger btn-disabled" data-dismiss="modal" disabled>No</button>
                <button type="button" class="btn btn-success btn-disabled" id="btn-yes" disabled>Yes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Download  -->
<?php $this->load->view('admin/partials/modal_download_excel_us') ?>