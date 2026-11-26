<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Request Payment
            <a href="<?= site_url('admin/request_payment/add') ?>" class="btn btn-success btn-sm pull-right"
               title="Menambahkan data alumni baru">
                ADD NEW
            </a>
            <!-- <span class="pull-right">&nbsp;</span> -->
            <!-- <a href="javascript:;" onclick="show_download_modal('<?=http_build_query($_GET)?>')"
               class="btn btn-primary btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                DOWNLOAD EXCEL
            </a>
            <span class="pull-right">&nbsp;</span>
            <a href="javascript:;" onclick="import_excel()" class="btn btn-primary btn-sm pull-right"
               title="Import Alumni data dari file excel">
                IMPORT EXCEL
            </a> -->
            <!-- <span class="pull-right">&nbsp;</span>
            <a href="<?= base_url('uploads/Template-import-alumni-v1.xlsx') ?>"
               class="btn btn-primary btn-sm btn-circle pull-right" title="Download template excel untuk di import"
               style="border-radius:15px;">
                <i class="fa fa-file fa-fw"></i>
            </a> -->
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
        Sukses melakukan import sebanyak total <?= $import_success ?> data Alumni.
    </div>
<?php } ?>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    <!-- <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div> -->

                    Grants :
                    <select class="form-control input-sm" name="program" onchange="document.forms.frm_manage.submit()">
                        <option value="">All</option>
                        <?php
                        foreach ($program_available as $pa) {
                            $selected = '';
                            if ($pa == $paging['program']) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?= $pa->id ?>" <?= $selected ?>><?= $pa->name ?></option>
                        <?php } ?>
                    </select>

                    
                    Status :
                    <select class="form-control input-sm" name="status" onchange="document.forms.frm_manage.submit()">
                        <option value="">All</option>
                        <?php
                        foreach ($status as $st) {
                            $selected = '';
                            if ($st == $paging['status']) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?= $st->id ?>" <?= $selected ?>><?= $st->name ?></option>
                        <?php } ?>
                    </select>

                    
                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit']) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?= $lo ?>" <?= $selected ?>><?= $lo ?></option>
                        <?php } ?>
                    </select>
                    
                    Disbursement :
                    <select class="form-control input-sm" name="disbursement" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['disbursement']) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?= $lo ?>" <?= $selected ?>><?= $lo ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!-- <div class="pull-right">
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
                                    value="<?= $field ?>" <?= $selected; ?>><?= $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?= isset($q[0]) ? $q[0] : '' ?>"
                                     placeholder="" onkeypress="return submitFilter(event)">
                    <a href="javascript:;" onclick="add_filter()" class="btn btn-success btn-sm"><i
                            class="fa fa-plus fa-fw"></i></a>
                </div> -->
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
                                            value="<?= $field ?>" <?= $selected; ?>><?= $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Keyword : <input type="search" class="form-control input-sm" name="q[]"
                                             value="<?= $q[$i] ?>" placeholder=""
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
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                            <th class="text-center">Grants</th>
                            <th class="text-center">To be Release</th>
                            <th class="text-center">Disbursement</th>
                            <th class="text-center">Status</th>
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
                                        $year_departure = " ({$value['year_departure']})";
                                    }

                                    if (!isset($available_program[$value['user_program_id']])) {
                                        $available_program[$value['user_program_id']] = 'Avail';
                                        $join_program .= '<li>' . $value['program_name'] . $year_departure . '</li>';
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
                                        <input type="checkbox" class="chk-row" name="ids[]" value="<?= $row->user_id ?>">
                                    </td>
                                    <td><?= $no ?></td>
                                    <td class="text-left">
                                        <a href="<?= site_url('admin/request_payment/view/' . $row->id) ?>">
                                            <?= $fullname ?>
                                        </a>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><?= $join_program ?></td>
                                    <td><?= $row->status_name ?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url('admin/request_payment/edit/' . $row->id)?>" class="btn btn-warning btn-xs">Detail</a>
                                        <span class="label label-success">Arrive Indonesia</span>
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
                                    <input type="checkbox" name="field_alumni[]" class="form-check-input field-alumni" id="field_alumni_check<?=$key?>" value="<?= "$key *-* $value" ?>" checked>
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