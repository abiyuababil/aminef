<style>
    .status_inactive{
        color: red;
        font-size: 20px;
        vertical-align: middle;
        padding-right: 10px;
    }

    .status_active{
        color: green;
        font-size: 20px;
        vertical-align: middle;
        padding-right: 10px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Applicants of <?= $data_form->title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
                    <a href="<?= base_url('admin/eta_host_school_application/download_excel/' . $form_id)?>"
                    class="btn btn-primary btn-sm pull-right ml-2" title="Export Data format file excel">
                        DOWNLOAD EXCEL
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <!-- <th>Email</th> -->
                            <?php foreach($table_column as $tCol) { ?>
                                <th><?= $tCol->name ?></th>
                            <?php } ?>
                            <th>Created Date</th>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'] == 0 ? 1 : $paging['start_row'];
                            foreach ($data as $row) {
                        ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>">
                                    </td>
                                    <td><?php echo $no ?></td>
                                    <!-- <td><?php echo $row->email ?></td> -->
                                    <?php foreach($table_column as $tCol) { ?>
                                        <td><?= $row->submission[$tCol->id] ?></td>
                                    <?php } ?>
                                    <td><?php echo $row->created_date ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url('admin/eta_host_school_application/view_form_application/' . $row->id . '/' . $row->eta_host_school_application_id) ?>" class="btn btn-warning btn-xs">
                                            <i class="fa fa-eye"></i> View Application
                                        </a>
                                        <!-- <a href="<?= base_url('admin/eta_host_school_application/delete_list_form/'. $row->eta_host_school_application_id . '/' .$row->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')">
                                            <i class="fa fa-times-circle"></i> Delete
                                        </a> -->
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
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->