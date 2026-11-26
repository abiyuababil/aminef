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
        <h1 class="page-header">
            <?= isset($this->User_grantee_grant_model->name) ? $this->User_grantee_grant_model->name : ''; ?> <?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? ' - ' . $this->User_grantee_grant_model->year : '' ?>
        </h1>
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
                            <li><a href="javascript:;" data-action="copy_grant">Copy to Grant</a></li>
                        </ul>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>

                    <a href="<?php echo $link_sort; ?>" class="btn btn-info btn-sm">
                        <i class="fa fa-arrows"></i> SORTING
                    </a> 

                    <?php
                    $first_category_id = 0;
                    foreach ($data as $row) {
                        $first_category_id = $row->id;
                        break;
                    }
                    ?>
                    <a href="<?php echo site_url('grantee/preview/data/' . $first_category_id . '?grants_id=' . $this->User_grantee_grant_model->id)?>" class="btn btn-warning btn-sm" target="_blank">
                        <i class="fa fa-eye"></i> PREVIEW
                    </a>
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
                    <a href="<?php echo $link_add; ?>" class="btn btn-success btn-sm">
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
                            <th>Category Name</th>
                            <?php if($this->session->userdata('active_country') == 2){ ?>
                            <th>Category Menu</th>
                            <?php } ?>
                            <th width="50">Status</th>
                            <th width="300" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                        ?>
                                <tr>
                                    <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
                                    <td><?php echo $no ?></td>
                                    <td><?php echo $row->name ?></td>
                                    <?php if($this->session->userdata('active_country') == 2) { ?>
                                    <td> <?php echo get_category_grant_page_name($row->is_new_grantee); ?></td>
                                    <?php } ?>
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
                                        <a href="<?php echo site_url('admin/user_grantee_grant/step/' . (isset($this->User_grantee_grant_model->id) ? $this->User_grantee_grant_model->id : '') . '/' . $row->id) ?>" class="btn btn-info btn-xs" style="background:#4da6ff">
                                            <i class="fa fa-<?= get_active_country(true) == AMERICAN_DATABASE ? "edit" : "gear"; ?>"></i> <?= get_active_country(true) == AMERICAN_DATABASE ? "Manage Content" : "Edit Content"; ?>
                                        </a>
                                        <a href="<?php echo $link_edit . $row->id ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-<?= get_active_country(true) == AMERICAN_DATABASE ? "gear" : "edit"; ?>"></i> <?= get_active_country(true) == AMERICAN_DATABASE ? "Setting" : "Edit"; ?>
                                        </a>
                                        <a href="<?php echo $link_delete . $row->id ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')">
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
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="modal fade" id="mdl_select_grant">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input name="user_id" type="hidden" value="<?= $this->User_model->id; ?>"/>
                        <input name="country_id" type="hidden" value="<?= $country_id; ?>"/>
                        <input name="program_id" type="hidden" id="ex_program_id"/>

                        <label>Select Grant</label>
                        <select name="copy_grant_id" class="form-control select2" id="copy_grant_id" form="frm_manage">
                            <option value="">--Choose one--</option>
                            <?php foreach ($grants as $key => $prgm) { ?>
                                <option value='<?= $prgm->id ?>'><?= $prgm->name ?></option>";
                            <?php } ?>
                        </select>
                        <input type="hidden" name="action" form="frm_manage" value="copy_grant">
                    </div>
                    <div class="form-group col-sm-12 select-period-section">
                        <label>Select Period</label>
                        <select name="period_id" class="form-control select2" id="period_id" form="frm_manage">
                            <option value="">-- Select Period --</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" form="frm_manage" class="btn btn-primary">Copy</button>
            </div>
        </div>
    </div>
</div>