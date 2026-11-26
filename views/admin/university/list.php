<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage University
            <?php if(has_permission('university', 'view')) { ?>
            <a href="<?php echo site_url('admin/university/export') ?>" class="btn btn-primary btn-sm pull-right"
               title="Export Data University dalam format file excel">
                EXPORT TO EXCEL
            </a>
            <?php } ?>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if (isset($import_result) && is_array($import_result) && isset($import_result['error'])) { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $import_result['error'] ?>
    </div>
<?php } ?>

<?php if (isset($import_result) && is_array($import_result) && !isset($import_result['error'])) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Import successful: <?php echo $import_result['inserted'] ?> new data,
        <?php echo $import_result['updated'] ?> data updated.
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <?php if(has_permission('university', 'delete')) { ?>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul>
                        <?php } ?>
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
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>"
                                    placeholder="">
                    <?php if(has_permission('university', 'add')) { ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            ADD NEW
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?php echo site_url('admin/university/add') ?>">Add New</a></li>
                            <li><a href="javascript:;" onclick="open_import_modal()">Import</a></li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Name</th>
                            <th <?php echo sorting_attribute('country', $sort_by, $sort) ?>>Country</th>
                            <th>State/Province</th>
                            <th>Description</th>
                            <th width="150" class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk-row" name="ids[]"
                                               value="<?php echo $row->id ?>">
                                    </td>
                                    <td>
                                        <?php echo $no ?>
                                    </td>
                                    <td>
                                        <?php echo $row->name ?>
                                    </td>
                                    <td>
                                        <?php echo $row->country_name ?>
                                    </td>
                                    <td>
                                        <?php echo $row->state_name ?>
                                    </td>
                                    <td><?php echo $row->description ?></td>
                                    <td class="text-center">
                                        <?php if(has_permission('university', 'edit')) { ?>
                                        <a href="<?php echo site_url('admin/university/edit/' . $row->id) ?>"
                                           class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <?php } ?>
                                        <?php if(has_permission('university', 'delete')) { ?>
                                        <a href="<?php echo site_url('admin/university/delete/' . $row->id) ?>"
                                           class="btn btn-danger btn-xs confirm-del">
                                            <i class="fa fa-times-circle"></i> Delete
                                        </a>
                                        <?php } ?>
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
                of <?php echo $paging['total_rows'] ?> entries
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

<form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
    <input id="file-excel" type="file" name="file-excel" accept=".xls,.xlsx">
</form>

<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalImportLabel">Import University</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b>Download Template:</b></p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                Choose Template
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('admin/university/download_template/new') ?>">New Data</a></li>
                                <li><a href="<?php echo site_url('admin/university/download_template/update') ?>">Update Data</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <form action="#" class="dropzone" id="fileDropzone"></form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btn-cancel-import" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="btn-upload-import">
                    Import
                </button>
            </div>
        </div>
    </div>
</div>
