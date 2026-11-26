<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage <?= $this->session->userdata('active_country') == INDONESIAN_DATABASE ? 'Panelist' : 'Reviewer' ?> 
        
        <a href="<?php echo site_url('admin/panellist/download_excel?' . ($this->input->get() ? http_build_query($this->input->get()) : '')) ?>" class="btn btn-primary btn-sm pull-right mr-2" title="Menambahkan data alumni baru">
            DOWNLOAD EXCEL
        </a>
        <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
        <a href="<?php echo site_url('admin/panellist/summary'); ?>" class="btn btn-success btn-sm pull-right mr-2" title="Menambahkan data alumni baru">
            SUMMARY
        </a>
        <?php } ?>
        </h1>
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
                    <option value="all" <?php echo 'all' == $paging['limit'] ? 'selected' : '' ?>>All</option>
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
                    <?php //if(has_permission('panelist', 'add_by_email')) { ?>
                    <!-- <a href="<?php echo site_url('admin/panelist/add_by_email') ?>" class="btn btn-warning btn-sm">
                        Add New by Email
                    </a> -->
                    <?php //} ?>
                    <?php if(has_permission('panelist', 'add')) { ?>
                    <a href="<?php echo site_url('admin/panelist/add') ?>" class="btn btn-success btn-sm">
                        Add New
                    </a>
                    <?php } ?>
                    <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                    <a href="<?php echo site_url('admin/panelist/form') ?>" class="btn btn-info btn-sm">
                        Form
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
                            <th <?php echo sorting_attribute('email', $sort_by, $sort) ?>>Email</th>
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Name of Panelist</th>
                            <th <?php echo sorting_attribute('origin_country', $sort_by, $sort) ?>>Country of Origin</th>
                            <th <?php echo sorting_attribute('field_of_study_name', $sort_by, $sort) ?>>Field of Study</th>
                            <th <?php echo sorting_attribute('home_institution', $sort_by, $sort) ?>>Home Institution</th>
                            <th <?php echo sorting_attribute('is_active', $sort_by, $sort) ?>>Status</th>
                            <th <?php echo sorting_attribute('is_active', $sort_by, $sort) ?>>Registration Time</th>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging ? $paging['start_row'] : 1;
                            foreach ($data as $row) {
                            $sof_name = $row->field_of_study_name ? strtolower($row->field_of_study_name) : '';
                        ?>
                                <tr>
                                    <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
                                    <td><?php echo $no ?></td>
                                    <td><?php echo $row->email ?></td>
                                    <td><?php echo $row->prefix ?? '' ?> <?php echo $row->name ?></td>
                                    <td><?php echo $row->origin_country ? get_country_by_id($row->origin_country)->name : '' ?></td>
                                    <td>
                                        <?php echo $sof_name == 'other' || $row->field_of_study_id == 0 ? $row->other_sof : 
                                        join_multi_select_pivot('am_panellist', ['id' => $row->id], 'field_of_study_id', 'name', 'am_study_fields_2')
                                        ?>
                                    </td>
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
                                    <td><?= isset($row->register_date) ? date('d M Y H:i', strtotime($row->register_date)) : '' ?></td>
                                    <td class="text-center">
                                        <?php if(isset($row->data_form)) { ?>
                                            <a href="<?php echo site_url('admin/panelist/view_form_register/' . $row->id) ?>" class="btn btn-warning btn-xs">
                                                <i class="fa fa-eye"></i> Form Register
                                            </a>
                                        <?php } ?>
                                        <?php if(has_permission('panelist', 'edit')) { ?>
                                            <?php if($row->is_active != 0 || !isset($row->data_form)) { ?>
                                            <a href="<?php echo site_url('admin/panelist/edit/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if(has_permission('panelist', 'delete')) { ?>
                                        <a href="<?php echo site_url('admin/panelist/delete/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del">
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
             <?php if(isset($paging)){?>
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
            <?php } ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->