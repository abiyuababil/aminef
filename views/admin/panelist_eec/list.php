<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage EEC Member </h1>
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
                        <?php if(has_permission('panelist_eec', 'delete')) { ?>
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
                    <?php if(has_permission('panelist_eec', 'add')) { ?>
                    <a href="<?php echo site_url('admin/panelist_eec/add') ?>" class="btn btn-success btn-sm">
                        Add New
                    </a>
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
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Email</th>
                            <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
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
                                    <td><?php echo $row->prefix ?? '' ?> <?php echo $row->name ?></td>
                                    <td><?php echo $row->email ?></td>
                                    <td>
                                        <?php
                                        if ($row->status == 1) {
                                            echo '<span class="badge badge-success">Active</span>';
                                        } else if ($row->status == 0) {
                                            echo '<span class="badge">Inactive</span>';
                                        } else if ($row->status == 2) {
                                            echo '<span class="badge badge-danger">Rejected</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if(has_permission('panelist_eec', 'edit')) { ?>
                                            <?php if($row->status != 0 || !isset($row->data_form)) { ?>
                                            <a href="<?php echo site_url('admin/panelist_eec/edit/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if(has_permission('panelist_eec', 'delete')) { ?>
                                        <a href="<?php echo site_url('admin/panelist_eec/delete/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del">
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