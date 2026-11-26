<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage Alumni
            <?php if(has_permission('alumni', 'add')) { ?>
            <a href="<?php echo site_url('admin/alumni/add') ?>" class="btn btn-success btn-sm pull-right"
               title="Menambahkan data alumni baru">
                ADD NEW
            </a>
            <?php } ?>
            <span class="pull-right">&nbsp;</span>
            <a href="javascript:;" onclick="show_download_modal('<?=http_build_query($_GET)?>')"
               class="btn btn-primary btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                DOWNLOAD EXCEL
            </a>
            <span class="pull-right">&nbsp;</span>
            <a href="javascript:;" onclick="import_excel()" class="btn btn-primary btn-sm pull-right"
               title="Import Alumni data dari file excel">
                IMPORT EXCEL
            </a>
            <span class="pull-right">&nbsp;</span>
            <a href="<?php echo base_url('uploads/Template-import-alumni-v2.xlsx') ?>"
               class="btn btn-primary btn-sm btn-circle pull-right" title="Download template excel untuk di import"
               style="border-radius:15px;">
                <i class="fa fa-file fa-fw"></i>
            </a>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<?php if (isset($import_success) && $import_success === false) { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        File Excel tidak dapat di import, pastikan anda menggunakan template excel yang valid.
    </div>
<?php } ?>

<?php if (isset($import_success) && is_numeric($import_success)) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Sukses melakukan import sebanyak total <?php echo $import_success ?> data Alumni.
    </div>
<?php } ?>
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
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>
        <form id="frm_manage" method="GET">
            <div class="row mb-4 program-filter-section">
                <div class="form-group select-program">
                    <label>Program</label>
                    <select class="form-control select2" id="filter-program" name="program_ids[]" multiple>
                        <?php 
                            $program_ids = isset($_GET['program_ids']) ? (array) $_GET['program_ids'] : [];
                        ?>
                        <?php foreach($available_program as $program) { ?>
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
                            <?php if (empty($period->year_departure) || $period->year_departure <= 0) continue; ?>
                            <option value="<?php echo $period->year_departure; ?>" <?php echo (!empty($_period) && is_array($_period) && in_array($period->year_departure, $_period)) ? 'selected' : ''; ?>><?php echo $period->year_departure; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                            <!-- <li><a href="javascript:;" data-action="export-to-grantee">Export to Grantee</a></li> -->
                        </ul>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>

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
                            <th <?php echo sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                            <!-- <th <?php echo sorting_attribute('study_field', $sort_by, $sort) ?>>Field of Study</th> -->
                            <th <?php echo sorting_attribute('home_institution', $sort_by, $sort) ?>>Current Institution</th>
                            <th class="text-center">Grant Detail</th>
                            <th <?php echo sorting_attribute('date_modified', $sort_by, $sort) ?>>Updated</th>
                            <!-- <th <?php echo sorting_attribute('available_grantee', $sort_by, $sort) ?>>Grantee</th> -->
                            <th class="text-center">Action</th>
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
                                        $year_departure = " {$value['year_departure']}";
                                    }

                                    if (!isset($available_program[$value['user_program_id']])) {
                                        $available_program[$value['user_program_id']] = 'Avail';
                                        $labelFiscal = get_active_country() == 'Indonesian' ? 'Academic Year' : 'Fiscal Year';
                                        $join_program .= '<li style="margin-bottom: 10px;">' . 'Grant : ' . $value['program_name'] . '<br />' . 'Host : ' .$value['host_institution'] . '<br />' . 'Field of Study : ' .$value['sf_name'] . '<br />' . $labelFiscal . ' : ' . $year_departure . '</li>';
                                    }
                                }
                                $join_program .= '</ul>';

                                $format = 'ID';
                                if ($country_id == '2') {
                                    $format = 'US';
                                }
                                $fullname = $this->User_model->get_full_name($row, $format);
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->user_id ?>">
                                    </td>
                                    <td><?php echo $no ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/alumni/view/' . $row->user_id) ?>">
                                            <?php echo $fullname ?>
                                        </a>
                                    </td>
                                    <!-- <td><?php echo $row->sf_name ?></td> -->
                                    <td><?php echo $row->home_institution ?></td>
                                    <td><?php echo $join_program ?></td>
                                    <td><?php echo $row->date_modified ? date('m/d/Y',
                                            strtotime($row->date_modified)) : '' ?></td>
                                    <!-- <td><?php echo get_badge_available_grantee($row->available_grantee); ?></td> -->
                                    <td class="text-center" style="position:absolute;">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-gear fa-fw"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <?php if(has_permission('alumni', 'edit')) { ?>
                                            <li>
                                                <a href="<?php echo site_url('admin/alumni/edit/' . $row->user_id) ?>">Edit</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('alumni', 'grant_edit')) { ?>
                                            <li>
                                                <a href="<?php echo site_url('admin/alumni/available_program/' . $row->user_id) ?>">Grants</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('alumni', 'payment')) { ?>
                                            <li>
                                                <a href="javascript:;" data-toggle="modal" data-target="#mdl_payment" data-id="<?= $row->id ?>">Payment</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(has_permission('alumni', 'delete')) { ?>
                                            <li><a href="<?php echo site_url('admin/alumni/delete/' . $row->user_id) ?>"
                                                   class="confirm-del" data-value="<?php echo $fullname ?>">Delete</a>
                                            </li>
                                            <?php } ?>
                                        </ul>
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
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?>
                of <?php echo number_format($paging['total_rows']) ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
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
                    <option value="<?php echo $field ?>"><?php echo $val ?></option>
                <?php } ?>
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        Keyword : <input type="search" class="form-control input-sm" name="q[]" value="" placeholder=""
                         onkeypress="return submitFilter(event)">
        <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i
                class="fa fa-minus fa-fw"></i></a>
    </div>
</div>

<!-- Modal Download -->
<div class="modal fade" id="modalDownload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form-download-excel">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Download Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="row">
					<div class="col-md-12">
						<center>
							<b>List of Fields</b> ( <label>Select All <input id="sel-all" type="checkbox" checked></label> )<br><br>
						</center>
					</div>
                    <?php foreach (array_split($all_field, 4) as $key_a_f => $a_f): ?>
                    <div class="col-md-3">
                        <ul class="list-style-none">
                        <?php foreach ($a_f as $key => $value): ?>
                            <li>
                                <div class="form-check">
                                    <input type="checkbox" name="field_alumni[]" class="form-check-input field-alumni" id="field_alumni_check<?=$key?>" value="<?php echo "$key *-* $value" ?>" checked>
                                    <label class="form-check-label font-weight-normal d-inline" for="field_alumni_check<?=$key?>"><?=$value?></label>
                                </div>
                            </li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                    <?php endforeach ?>
                    <div class="col-md-12 d-none text-center text-validation mb-4" id="text-validation-field">
                        <small class="text-danger">Select at least one field</small>
                    </div>					
                    <div class="col-md-12">
						<hr>
                        <center>
							<b>Show Grant</b><br><br>
                        </center>
                        <center>
                            <div class="radio d-inline mr-4">
                                <label><input type="radio" class="grant-alumni" name="grant_option" style="margin-top:1px" value="single_grant" checked>Single Grant</label>
                            </div>
                            <div class="radio d-inline">
                                <label><input type="radio" class="grant-alumni" name="grant_option" style="margin-top:1px" value="all_grant">All Grants</label>
                            </div>
                            <small class="text-danger d-none text-validation" id="text-validation-grant">Choose one between single grant or all grants</small>
                        </center>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="submit" class="btn btn-success">Download</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal payment -->
<?php if(has_permission('alumni', 'payment')) { ?>
<div class="modal fade" id="mdl_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Select Grant</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="<?php echo base_url() ?>/img/loading.gif" style="display:none;margin-left: 50%;" id="load-mdl">
                <div class="wrap-payment"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php
if (!empty($data)) :
    $final_record = [];
    foreach ($data as $user) {
        $final_record[$user->id] = $user;
    }
?>
    <script>
        
        function escapeJSON(jsonString) {
            return jsonString.replace(/[\b\f\n\r\t\\]/g, function (char) {
                switch (char) {
                    case '\b': return '\\b';
                    case '\f': return '\\f';
                    case '\n': return '\\n';
                    case '\r': return '\\r';
                    case '\t': return '\\t';
                    case '\\': return '\\\\';
                }
            });
        }
        var arrCurrentUsers = escapeJSON(`<?php echo safe_parse_json(json_encode($final_record)); ?>`);
        var currentUsers = JSON.parse(arrCurrentUsers);

    </script>
<?php endif; ?>