<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Review</h1>
        <?php if ($this->session->flashdata('success_submitted')) : ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success_submitted') ?></div>
        <?php endif; ?>
        <?php $this->session->unset_userdata('success_submitted'); ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>
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
                        <?php if(has_permission('panelist', 'delete')) { ?>
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
                            if ($lo == $paging['limit']) $selected = 'selected';
                        ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Email</th>
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Name of Panelist</th>
                            <th <?php echo sorting_attribute('field_of_study_name', $sort_by, $sort) ?>>Field of Study</th>
                            <th <?php echo sorting_attribute('home_institution', $sort_by, $sort) ?>>Home Institution</th>
                            <th <?php echo sorting_attribute('is_active', $sort_by, $sort) ?>>Status</th>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                            $sof_name = $row->field_of_study_name ? strtolower($row->field_of_study_name) : '';
                        ?>
                                <tr>
                                    <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
                                    <td><?php echo $no ?></td>
                                    <td><?php echo $row->email ?></td>
                                    <td><?php echo $row->name ?></td>
                                    <td><?php echo $sof_name == 'other' || $row->field_of_study_id == 0 ? $row->other_sof : $row->field_of_study_name ?></td>
                                    <td><?php echo $row->home_institution ?></td>
                                    <td>
                                        <?php
                                        if ($row->is_active == 1) {
                                            echo '<span class="badge badge-success">Active</span>';
                                        } else if ($row->is_active == 0) {
                                            echo '<span class="badge">Inactive</span>';
                                        } else if ($row->is_active == 2) {
                                            echo '<span class="badge badge-danger">Rejected</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if(isset($row->data_form)) { ?>
                                            <a href="<?php echo site_url('admin/panellist/view_form_register/' . $row->id) ?>" class="btn btn-warning btn-xs">
                                                <i class="fa fa-eye"></i> Form Register
                                            </a>
                                        <?php } ?>
                                        <?php if(has_permission('panelist', 'edit')) { ?>
                                        <a href="<?php echo site_url('admin/panellist/edit/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <?php } ?>
                                        <?php if(has_permission('panelist', 'delete')) { ?>
                                        <a href="<?php echo site_url('admin/panellist/delete/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del">
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