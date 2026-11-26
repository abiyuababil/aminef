<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage ETA Host School Application</h1>
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
                        <?php if(has_permission('eta_host_school_application', 'delete')) { ?>
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
                    <a href="<?php echo site_url('admin/eta_host_school_application/add') ?>" class="btn btn-success btn-sm">
                        Add New
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Title</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th <?php echo sorting_attribute('is_active', $sort_by, $sort) ?>>Status</th>
                            <th width="300" class="text-center">Action</th>
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
                                    <td><?php echo $row->title ?></td>
                                    <td><?php echo $row->start_date ? date('F j, Y H:i', strtotime($row->start_date)) : '' ?></td>
                                    <td><?php echo $row->end_date ? date('F j, Y H:i', strtotime($row->end_date)) : '' ?></td>
                                    <td>
                                        <?php
                                        if ($row->is_active == 1) {
                                            echo '<span class="badge badge-success">Active</span>';
                                        } else if ($row->is_active == 0) {
                                            echo '<span class="badge">Inactive</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url('admin/eta_host_school_application/list_application/' . $row->id) ?>" class="btn btn-info btn-xs">
                                            View Applicants
                                        </a>
                                        <button type="button" data-url="<?= base_url('eta_host_school_application/'. $row->slug) ?>" class="btn btn-warning btn-xs" onclick="copyURL(this)">
                                            Copy URL
                                        </button>
                                        <a href="<?php echo site_url('admin/eta_host_school_application/list_form/' . $row->id) ?>" class="btn btn-info btn-xs">
                                            Edit Question
                                        </a>
                                        <button type="button" class="btn btn-xs btn-warning" onclick="copyForm(<?= $row->id ?>)"><i class="fa fa-book"></i> Copy Form</button>
                                        <?php if(has_permission('eta_host_school_application', 'edit')) { ?>
                                        <a href="<?php echo site_url('admin/eta_host_school_application/edit/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit Page
                                        </a>
                                        <?php } ?>
                                        <?php if(has_permission('eta_host_school_application', 'delete')) { ?>
                                        <a href="#" data-id="<?= $row->id ?>" data-url="<?php echo site_url('admin/eta_host_school_application/delete/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del-form">
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