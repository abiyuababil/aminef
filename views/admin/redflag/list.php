<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Red Flag
            <a href="<?php echo site_url('admin/redflag/add') ?>" class="btn btn-success btn-sm pull-right">
                ADD NEW
            </a>
            <a href="<?php echo site_url('admin/redflag/download_excel?' . ($this->input->get() ? http_build_query($this->input->get()) : '')) ?>"
               class="btn btn-primary btn-sm pull-right mr-2" title="Export Data Alumni dalam format file excel">
                DOWNLOAD EXCEL
            </a>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    Grants :
                    <select class="form-control input-sm selectpicker" data-live-search="true" name="program" onchange="document.forms.frm_manage.submit()" style="width:250px">
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
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="search" value="<?php echo $paging['search'] ?>" placeholder="" onkeypress="return submitFilter(event)">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="chk-all"></th>
                            <th class="text-center">#</th>
                            <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                            <th>Grant</th>
                            <th>Author</th>
                            <th>Academic Year</th>
                            <th>Comment</th>
                            <th <?= sorting_attribute('created_at', $sort_by, $sort) ?>>Create Date</th>
                            <th <?= sorting_attribute('updated_at', $sort_by, $sort) ?>>Update Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            $grantee_ids = [];
                            foreach ($data as $row) {
                                if(!in_array($row->id,$grantee_ids)){
                                    $grantee_ids[] = $row->id;
                                    $format = 'ID';
                                    if ($country_id == '2') {
                                        $format = 'US';
                                    }
                            ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="chk-row" name="ids[]" value="<?= $row->user_id ?>">
                                        </td>
                                        <td><?= $no ?></td>
                                        <td><?= get_full_name($row, $format) ?></td>
                                        <td><?= $row->grant_name ?></td>
                                        <td><?php echo $row->staff_name ?></td>
                                        <td><?= $row->year_departure ?></td>
                                        <td><?= $row->comment ?></td>
                                        <td><?= $row->created_at ? date('d M Y H:i:s', strtotime($row->created_at)) : '-' ?></td>
                                        <td><?= $row->updated_at ? date('d M Y H:i:s', strtotime($row->updated_at)) : '-' ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo site_url('admin/redflag/edit/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                                Edit
                                            </a>
                                            <a href="<?php echo site_url('admin/redflag/delete/' . $row->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure ?')">
                                                Delete
                                            </a>
                                            </ul>
                                        </td>
                                    </tr>
                            <?php
                                    $no++;
                                }
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
                        <?php foreach (array_split($all_field, 4) as $key_a_f => $a_f) : ?>
                            <div class="col-md-3">
                                <ul class="list-style-none">
                                    <?php foreach ($a_f as $key => $value) : ?>
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" name="field_alumni[]" class="form-check-input field-alumni" id="field_alumni_check<?= $key ?>" value="<?= "$key *-* $value" ?>" checked>
                                                <label class="form-check-label font-weight-normal d-inline" for="field_alumni_check<?= $key ?>"><?= $value ?></label>
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