<style>
    td {
        height: 40px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Finalist Grantee
            <a href="<?php echo site_url('admin/finalist_grantee/download_pdf?' . $params) ?>" class="btn btn-primary btn-sm pull-right" title="Export New Grantee dalam format file pdf">
                DOWNLOAD PDF
            </a>
            <a href="javascript:;" style="margin-right: 5px;" onclick="show_download_modal_grantee('<?=http_build_query($_GET)?>')"
               class="btn btn-primary btn-sm pull-right" title="Export Data Grantee dalam format file excel">
                DOWNLOAD EXCEL
            </a>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

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
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <th width="35" class="text-center">#</th>
                    <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                    <th>Grants</th>
                    <th>Fiscal Year</th>
                    <th>Status</th>
                    <th class="text-left">Section</th>
                    <th class="text-right" width="10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data) {
                    $no = $paging['start_row'];
                    foreach ($data as $row) {
                ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td class="text-left"><a href="<?= site_url('admin/grantee/edit/' . $row->user_grantee_id . '/' . $row->grant_id) ?>"><?= $row->fullname; ?></a></td>
                            <td class="text-left"><a href="<?= site_url('admin/user_grantee_grant/category/' . $row->grant_id) ?>"><?= $row->program_name ?></a></td>
                            <td class="text-left"><?= $row->fiscal_year ?></td>
                            <td class="text-left"><?= $row->status_name ?></td>
                            <td class="text-left">
                                <?php foreach ($row->category as $key => $val) {  ?>
                                    <?php 
                                        $document_status = null;
                                        $category_status = get_row_db('am_grantee_grant_category_status', ['category_id' => $val->id, 'grantee_grant_id' => $row->id_grantee_grant]);
                                        if ($category_status) {
                                            $document_status = $category_status->status;
                                        } else {
                                            if (in_array($val->name, ['Grant Information', 'Grant Profile'])){
                                                $document_status = $row->grant_document_status;
                                            } elseif (in_array($val->name, ['Permit Application','Pre Arrival Documents','Pre-Arrival Documents'])) {
                                                $document_status = $row->pre_arrival_document_status;
                                            } elseif (in_array($val->name, ['Indonesian Host Information'])) {
                                                $document_status = $row->indonesian_host_information_status;
                                            }
                                        }
                                        
                                        $document_statuses = get_document_statuses($document_status);
                                    ?>
                                    <a style="margin-bottom: 5px;" href="<?= site_url('admin/finalist_grantee/submission/' . $row->id_grantee_grant . '/' . $val->id) ?>" class="btn <?php echo $document_statuses['class']; ?> btn-xs">
                                        <?php echo $document_statuses['icon']; ?>
                                        <?= $val->name ?>
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-right">
                                <span title="<?= $row->is_locked ? $row->is_locked['date_modified'] . " - " . $row->is_locked['name'] : "" ?>">
                                <a class="btn btn-primary btn-xs mb-1" <?= $row->is_locked ? "disabled" : ""; ?> href="<?php echo site_url('admin/request_payment/edit/' . $row->id . '/' . $row->id_grantee_grant) ?>"><i class="fa fa-money fa-fw"></i> Payment</a>
                                <span title="<?= $row->is_locked ? $row->is_locked['date_modified'] . " - " . $row->is_locked['name'] : "" ?>"></span>
                                <a href="<?php echo site_url('admin/grantee/download_all_document/' . $row->id_grantee_grant) ?>" target="_blank" class="btn btn-xs btn-primary mb-1"><i class="fa fa-download fa-fw"></i> Download All Document</a>
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

<!-- Modal Download -->
<?php $this->load->view('admin/partials/modal_download_excel_us') ?>