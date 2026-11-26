<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $this->User_grantee_grant_model->name ?>
            <span class="pull-right">&nbsp;</span>
            <a href="<?php echo site_url('admin/user_grantee_grant/download_excel/' . $grant_id) ?>"
               class="btn btn-primary btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                DOWNLOAD EXCEL
            </a>
        </h1>
    </div>
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
            <div class="data-header clearfix form-inline">
                <div class="row">
                    <div class="col-lg-6">
                        <table width="100%" style="padding:5px">
                            <tr>
                                <td width="15%" height="40px">
                                    <label for="">Start Year</label>
                                </td>
                                <td width="20%">
                                    <select name="start_year" class="form-control" onchange="document.forms.frm_manage.submit()">
                                        <option value="">All</option>
                                        <?php for ($i = date('Y'); $i > 1900; $i--) : ?>
                                            <?php
                                            $selected = '';
                                            if ($i == $paging['start_year']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td width="15%">
                                    <label for="">End Year</label>
                                </td>
                                <td>
                                    <select name="end_year" class="form-control" onchange="document.forms.frm_manage.submit()">
                                        <?php for ($i = date('Y'); $i > 1900; $i--) : ?>
                                            <?php
                                            $selected = '';
                                            if ($i == $paging['end_year']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" style="padding:5px">
                            <tr>
                                <td width="15%"><label for="">Search</label></td>
                                <td><input type="text" name="search" id="search" class="form-control" placeholder="Search" onkeypress="return submitFilter(event)" value="<?= $paging['search'] ?>"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table width="100%" class="text-right">
                            <tr>
                                <td><label for="">Grant Total Payment (USD)</label></td>
                                <td>:</td>
                                <td><?= number_format($grant_total_payment) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center" width="100%">
                    <thead>
                        <tr>
                            <th width="15%">Date</th>
                            <th>Item</th>
                            <th width="15%" class="text-right">Payment (USD)</th>
                            <th width="15%" class="text-right">Total Payment (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($payment_record) {
                            $no = $paging['start_row'];
                            foreach ($payment_record as $row) {
                        ?>
                                <tr>
                                    <td rowspan="<?= count($row->items) ?>" style="vertical-align:middle"><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                    <td class="text-left"><?= $row->items[0]->payment_name ?></td>
                                    <td class="text-right"><?= number_format($row->items[0]->nominal) ?></td>
                                    <td rowspan="<?= count($row->items) ?>" style="vertical-align:middle" class="text-right">
                                        <a href="<?= base_url('admin/user_grantee_grant/payment_grant/'.$row->grant_id) ?>"><?= number_format($row->total_nominal) ?></a>
                                    </td>
                                </tr>
                                
                                <?php if (count($row->items) > 1) {
                                    for ($i = 1; $i < count($row->items); $i++) {
                                ?>
                                <tr>
                                    <td class="text-left"><?= $row->items[$i]->payment_name ?></td>
                                    <td class="text-right"><?= number_format($row->items[$i]->nominal) ?></td>
                                </tr>
                                <?php } } ?>
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