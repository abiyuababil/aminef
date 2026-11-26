<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Hidden Grants List
        </h1>
    </div>
</div>
<?php
    if ($this->session->flashdata('success')) { ?>
<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
<?php $this->session->flashdata('success', false); } ?>
<?php
    if ($this->session->flashdata('danger')) { ?>
<div class="alert alert-danger"><?php echo $this->session->flashdata('danger'); ?></div>
<?php $this->session->flashdata('danger', false); } ?>
<form id="form-submit" action="" method="POST"
      style="background: #dfdfdf;padding: 20px 20px 5px 20px;border-radius: 10px;margin-bottom: 20px;">
    <div class="row">
        <div class="form-group col-sm-6">
            <label for="">Grant Name</label>
            <select name="program_id[]" class="form-control selectpicker" id="program_id" data-live-search="true" required multiple>
                <option value="">--Choose one--</option>
                <?php foreach ($available_programs as $key => $prgm) { ?>
                    <option data-year="<?= $prgm->year ?>" value='<?= $prgm->id ?>'><?= $prgm->name ?> <?= get_active_country(true) == AMERICAN_DATABASE ? '- ' . $prgm->year : '' ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-sm-2">
            <label>&nbsp;</label><br/>
            <input class="btn btn-primary" type="submit" value="Add Grant"/>
        </div>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="35" class="text-center">#</th>
                <th>Grant Name</th>
                <th>Category Type</th>
                <th>Status</th>
                <th width="250" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($data) {
                $no = 1;
                foreach ($data as $row) {
                    ?>
                    <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $row->name ?></td>
                        <td><?php echo label_category_type($row->category_grant) ?></td>
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
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-gear fa-fw"></i> List
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" <?= get_active_country(true) == INDONESIAN_DATABASE ? 'style="right: 145px;top: auto;left: auto;"' : '' ?>>
                                <?php if(has_permission('active_grants', 'list_period')) { ?>
                                <li>
                                    <a href="<?php echo site_url('admin/user_grantee_grant/period/'.$row->id) ?>">List Period</a>
                                </li>
                                <?php } ?>
                                <?php if(has_permission('active_grants', 'list_category')) { ?>
                                <li>
                                    <a href="<?php echo site_url('admin/user_grantee_grant/category/'.$row->id) ?>">List Category</a>
                                </li>
                                <?php } ?>
                                <?php if(has_permission('active_grants', 'list_category_report')) { ?>
                                <li>
                                    <a href="<?php echo site_url('admin/user_grantee_grant/category_report/'.$row->id) ?>">List Category Report</a>
                                </li>
                                <?php } ?>
                                <?php if(has_permission('active_grants', 'copy_active_grant')) { ?>
                                <li>
                                    <a href="<?php echo site_url('admin/user_grantee_grant/copy_grant/'.$row->id) ?>">Copy Active Grant</a>
                                </li>
                                <?php } ?>
                                <li>
                                    <a href="<?php echo site_url('admin/user_grantee_grant/submission_log/'.$row->id) ?>">Submission Log</a>
                                </li>
                                <?php if(has_permission('active_grants', 'sort_pdf_document')) { ?>
                                <li>
                                    <a href="<?php echo site_url('admin/user_grantee_grant/sorting_pdf_documents/'.$row->id) ?>">Sorting Documents (PDF)</a>
                                </li>
                                <?php } ?>
                            </ul>
                            
                            <?php if(get_active_country(true) == INDONESIAN_DATABASE && has_permission('active_grants', 'report')) { ?>
                            <a href="<?php echo site_url('admin/user_grantee_grant/report_payment/'.$row->id) ?>" class="btn btn-success btn-xs">
                                <i class="fa fa-file-text"></i> Report
                            </a>
                            <?php } ?>

                            <?php if(has_permission('active_grants', 'edit')) { ?>
                            <a href="<?php echo site_url('admin/user_grantee_grant/edit/'.$row->id) ?>" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php } ?>

                            <?php if(has_permission('active_grants', 'delete')) { ?>
                            <a href="<?php echo site_url('admin/user_grantee_grant/delete/'.$row->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs">
                                <i class="fa fa-times-circle"></i> Delete
                            </a>
                            <?php } ?>
                            <a href="<?= base_url('admin/user_grantee_grant/unhide_grant/' . $row->id) ?>" onclick="return confirm('Are you sure you want to unhide this grant?');" class="btn btn-warning btn-xs btn_change">
                                Unhide
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

<div class="modal fade" id="mdl_edit">
    <div class="modal-dialog">
        <form action="<?= base_url(); ?>admin/grantee/rejoin_grant/<?= $this->Grantee_ent_model->id; ?>" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Grants</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input name="user_id" type="hidden" value="<?= $this->Grantee_ent_model->id; ?>"/>
                        <input name="country_id" type="hidden" value="<?= $country_id; ?>"/>
                        <input name="grant_id" type="hidden" id="grant_id"/>

                        <label>Grant Name</label>
                        <select name="new_program_id" class="form-control select_multiselect" id="new_program_id" required>
                            <option value="">--Choose one--</option>
                            <?php
                            foreach ($available_programs as $key => $prgm) {
                                $label_year = get_active_country(true) == AMERICAN_DATABASE ? '- ' . $prgm->year : '';
                                echo "<option value='{$prgm->id}'>{$prgm->name} {$label_year}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        </form>
    </div>
</div>

<?php if (isset($grantee_statuses)) { ?>

<div class="modal fade" id="mdl_update_status">
    <div class="modal-dialog">
        <form action="<?= base_url(); ?>admin/grantee/update_status/" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Grant Status</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input name="id" type="hidden" id="id"/>
                        <label>Status</label>
                        <select name="status" class="form-control select2" id="status" required>
                            <option value="">--Choose one--</option>
                            <?php
                            foreach ($grantee_statuses as $key => $status) {
                                echo '<option value="' . $status->id . '">' . $status->name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        </form>
    </div>
</div>
<?php } ?>