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
        <h1 class="page-header"><?= $data_form->title ?></h1>
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

                    <a href="<?= site_url('admin/panelist/form/sort_list_form/' . $form_id) ?>" class="btn btn-info btn-sm">
                        <i class="fa fa-arrows"></i> SORTING
                    </a>
                    <a href="<?= base_url('grantee/preview/form_panellist/'.$form_id) ?>" class="btn btn-warning btn-sm" target="_blank">
                        <i class="fa fa-eye"></i> PREVIEW
                    </a>
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
                    <a href="<?= base_url('admin/panelist/form/add_list_form/'.$form_id) ?>" class="btn btn-success btn-sm">
                        ADD NEW
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th>Property Name</th>
                            <th>Question Type</th>
                            <th>Required</th>
                            <th width="50">Status</th>
                            <th width="150" class="text-center">Action</th>
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
                                        <?php if(!isset($row->hide_action)) { ?>
                                        <input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>">
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $no ?></td>
                                    <td><?php echo $row->name ?></td>
                                    <td><?php echo ucfirst($row->type) ?></td>
                                    <td><?php echo $row->is_required ? 'Yes' : 'No' ?></td>
                                    <td>
                                        <?php 
                                            if($row->is_active == 1){
                                                echo '<span class="badge badge-success">Active</span>';
                                            }else if($row->is_active == 0){
                                                echo '<span class="badge">Inactive</span>';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if(!isset($row->hide_action)) { ?>
                                        <a href="<?= base_url( 'admin/panelist/form/edit_list_form/'. $row->form_panellist_id . '/' .$row->id) ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= base_url('admin/panelist/form/delete_list_form/'. $row->form_panellist_id . '/' .$row->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')">
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
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->