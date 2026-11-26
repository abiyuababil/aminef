<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage Resource Categories</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <?php if ($this->session->flashdata('info')) { ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('info'); ?></div>
        <?php }
        $this->session->set_flashdata('info', false); ?>
    </div>
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div class="data-header clearfix form-inline">
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
                    entries
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>"
                        placeholder="">
                    <?php if (has_permission('resource_categories', 'add')) { ?>
                    <a class="btn btn-success btn-sm form" data-action="create" data-toggle="modal" data-target="#mdl_form_resource_category" data-title="Add Resource Category">
                        ADD NEW
                    </a>
                    <?php } ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="sortable">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Name</th>
                            <th>Is active</th>
                            <th width="250" class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                        ?>
                                <tr data-id="<?php echo $row->id; ?>">
                                    <td>
                                        <?php echo $no ?>
                                    </td>
                                    <td>
                                        <?php echo $row->name ?>
                                    </td>
                                    <td>
                                        <?php if ((bool) $row->is_active) { ?>
                                            <span class="badge badge-success">Active</span>
                                        <?php } else { ?>
                                            <span class="badge badge-default">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-right">
                                    <?php if (has_permission('resource_categories', 'edit')) { ?>
                                        <a data-toggle="modal" data-target="#mdl_form_resource_category" data-id="<?php echo $row->id; ?>" data-is_active="<?php echo $row->is_active; ?>" data-name="<?php echo $row->name; ?>" data-action="edit" data-title="Edit Resource Category" class="btn btn-primary btn-xs form">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    <?php } ?>
                                    <?php if (has_permission('resource_categories', 'delete')) { ?>
                                        <a href="<?php echo site_url('admin/resource_categories/delete/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del">
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

<div class="modal fade" id="mdl_form_resource_category" tabindex="-1" role="dialog" aria-labelledby="mdl_form_resource_category" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdl_form_resource_category_label">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" id="form_evaluation_question" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="name" class="form-control" name="name" placeholder="Category Name" required>
                    </div>
                    <div class="form-group">
                        <label for="is_active"><input type="checkbox" id="is_active" name="is_active" value="1" checked> Is active</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form_evaluation_question">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>