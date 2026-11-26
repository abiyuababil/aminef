<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage Vendor</h1>
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?= $this->session->flashdata('message') ?>
            </div>
        <?php endif; ?>
        <?php $this->session->unset_userdata('message');?>
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
                        <!-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button> -->
                        <!-- <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul> -->
                        <!-- <input type="hidden" name="action" value="" disabled="disabled"> -->
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
                    <?php if(has_permission('vendor', 'add') || has_permission('vendor', 'edit')) { ?>
                    <a href="<?php echo site_url('admin/vendor/sync') ?>" class="btn btn-info btn-sm">
                        <i class="fa fa-refresh"></i> SYNC
                    </a>
                    <?php } ?>
                    <?php if(has_permission('vendor', 'add')) { ?>
                    <a href="<?php echo site_url('admin/vendor/add') ?>" class="btn btn-success btn-sm">
                        ADD NEW
                    </a>
                    <?php } ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <!-- <th width="30"><input type="checkbox" class="chk-all"></th> -->
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('grantee_name', $sort_by, $sort) ?>>Grantee Name</th>
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Vendor Name</th>
                            <th <?php echo sorting_attribute('beneficiary_name', $sort_by, $sort) ?>>Beneficiary Name</th>
                            <th <?php echo sorting_attribute('bank_name', $sort_by, $sort) ?>>Bank Name</th>
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
                                    <!-- <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td> -->
                                    <td><?php echo $no ?></td>
                                    <td><?php echo !empty($row->grantee_name) ? htmlspecialchars($row->grantee_name) : '-' ?></td>
                                    <td><?php echo $row->name ?></td>
                                    <td><?php echo $row->beneficiary_name ?></td>
                                    <td><?php echo $row->bank_name ?></td>
                                    <td class="text-center">
                                        <?php if(has_permission('vendor', 'edit')) { ?>
                                        <a href="<?php echo site_url('admin/vendor/edit/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <?php } ?>
                                        <a href="<?php echo site_url('admin/vendor/delete/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del">
                                            <i class="fa fa-times-circle"></i> Delete
                                        </a>
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