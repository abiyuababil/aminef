<?php 
$last_grant = reset($data);
?>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-12">
        <h1 class="page-header">
            <a href="<?php echo site_url('admin/users_grantee/edit/' . $this->Grantee_ent_model->id) ?>">
                Edit Grants - <?php echo get_full_name($this->Grantee_ent_model) ?>
            </a>
        </h1>
    </div>
</div>
<!-- Error Alert -->
<div class="alert alert-danger hide">
    Can not add new grant, since Grant <strong id="grant_name">Error!</strong>  still active
</div>
<?php
    if ($this->session->flashdata('success')) { ?>
<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
<?php $this->session->flashdata('success', false); } ?>
<?php
    if ($this->session->flashdata('danger')) { ?>
<div class="alert alert-danger"><?php echo $this->session->flashdata('danger'); ?></div>
<?php $this->session->flashdata('danger', false); } ?>
<form id="form-submit" action="<?= base_url() ?>admin/grantee/join_new_grant" method="POST"
      style="background: #dfdfdf;padding: 20px 20px 5px 20px;border-radius: 10px;margin-bottom: 20px;">
    <div class="row">
        <input name="user_id" type="hidden" value="<?= $this->Grantee_ent_model->id ?>"/>
        <input name="country_id" type="hidden" value="<?= $country_id ?>"/>

        <div class="form-group col-sm-6">
            <label>Grant Name</label>
            <?php if(get_active_country(true) == AMERICAN_DATABASE) { ?>
                <input type="hidden" name="fiscal_year" id="year">
            <?php } ?>
            <select name="program_id" class="form-control select_multiselect" id="program_id" required>
                <option value="">--Choose one--</option>
                <?php foreach ($available_programs as $key => $prgm) { ?>
                    <option data-year="<?= $prgm->year ?>" value='<?= $prgm->id ?>'><?= $prgm->name ?> <?= get_active_country(true) == AMERICAN_DATABASE ? '- ' . $prgm->year : '' ?></option>
                <?php } ?>
            </select>
        </div>
        <?php if ($country_id == INDONESIAN_DATABASE) { ?>
            <div class="form-group col-sm-4">
                <label><?= get_active_country() == 'Indonesian' ? 'Academic Year' : 'Fiscal Year' ?></label>
                <input type="number" name="fiscal_year" class="form-control" required>
                <!-- <select name="period_id" class="form-control" id="period_id" required>
                    <option value="">--Choose one--</option>
                </select> -->
            </div>
        <?php } ?>
        <div class="form-group col-sm-2">
            <label>&nbsp;</label><br/>
            <input class="btn btn-primary" type="submit" value="Add Grant"/>
        </div>
        <?php if ($country_id == INDONESIAN_DATABASE) { ?>
            <!-- <div class="form-group col-sm-4">
                <label for="is_offline">Form Offline </label>
                <input type="checkbox" value="1" name="is_offline" id="is_offline" style="cursor:pointer;">
            </div> -->
        <?php } ?>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="35" class="text-center">#</th>
                <th>Grant Name</th>
                <th><?= get_active_country() == 'Indonesian' ? 'Academic Year' : 'Fiscal Year' ?></th>
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
                        <td><?php echo $row->fiscal_year ?></td>
                        <td><?php echo $row->status_name ?></td>
                        <td class="text-center">
                            <?php if ($country_id == INDONESIAN_DATABASE) { ?>
                                <a class="btn btn-warning btn-xs" target="_blank" href="<?php echo site_url('admin/payment_record/payment/application/' . $row->id) ?>">List Payment</a>
                            <?php } ?>
                            <?php 
                            $status_reject = [STATUS_SET_TO_ALUMNI, STATUS_SELECTION_DECLINED, STATUS_CANDIDATE_DECLINED, STATUS_ON_GOING_DECLINED]; 
                            if(!in_array($row->status, $status_reject)) { ?>
                            <a href="#" class="btn btn-info btn-xs btn_change" data-toggle="modal" data-target="#mdl_edit" data-granteegrantid="<?= $row->id ?>" data-id="<?= $row->grant_id; ?>">
                                <i class="fa fa-exchange"></i> Change
                            </a>
                            <!-- <a href="<?php echo site_url('admin/grantee/edit/' . $this->Grantee_ent_model->id . '?pid=' . $row->grant_id) ?>"
                               class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> Edit Data
                            </a> -->
                            <!-- <a href="<?php echo site_url('admin/grantee/remove_grant/' . $this->Grantee_ent_model->id . '/' . $row->id) ?>"
                               class="btn btn-danger btn-xs confirm-del" data-value="<?php echo $row->name ?>">
                                <i class="fa fa-times-circle"></i> Delete
                            </a> -->
                            <?php } ?>
                            <?php if (isset($grantee_statuses)) { ?>
                                <a href="#" class="btn btn-primary btn-xs btn_change_status" data-toggle="modal" data-target="#mdl_update_status" data-id="<?= $row->id; ?>" data-status="<?= $row->status; ?>">
                                    <i class="fa fa-exchange"></i> Change Status
                                </a>
                            <?php } ?>
                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-gear fa-fw"></i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" style="top:auto">
                                <!-- <li><a href="<?php echo site_url('admin/grantee/edit/' . $this->Grantee_ent_model->id . '/' . $row->grant_id) ?>">Edit Data</a></li> -->
                                <?php //if ($country_id == AMERICAN_DATABASE) { ?>
                                <li><a href="<?php echo site_url('admin/grantee/setting/' . $row->id) ?>">Setting</a></li>
                                <?php //} ?>
                                <li><a href="<?php echo site_url('admin/grantee/remove_grant/' . $this->Grantee_ent_model->id . '/' . $row->id) ?>" class="confirm-del" data-value="<?php echo $row->name ?>">Delete</a></li>
                                <?php if($row->status != STATUS_WAITING_DOCUMENT) { ?>
                                <li><a href="<?php echo site_url('admin/missing_document/manage/' . $row->id); ?>">Missing Document</a></li>
                                <?php } ?>
                                <?php if ($country_id == INDONESIAN_DATABASE) { ?>
                                <li>
                                    <a href="<?php  echo site_url('admin/grantee/view_procedures/' . $row->id) ?>" target="_blank">View All Procedures</a> 
                                </li>
                                <?php } ?>
                            </ul>
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
                        <input name="grant_id" type="hidden" id="ex_program_id"/>
                        <input name="grantee_grant_id" type="hidden" id="grantee_grant_id"/>

                        <label>Grant Name</label>
                        <select name="new_program_id" class="form-control select2" id="new_program_id" required>
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