<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
</div>

<?php if($this->session->flashdata('success_placement')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success_placement') ?>
    </div>
<?php } ?>

<form method="POST" enctype="multipart/form-data" style="margin-top: 30px;">
    <div class="row">
        <div class="panel-body" style="margin-top:-30px">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> GRANTEE INFORMATION</p>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" disabled="disabled" class="form-control" name="bank_name" value="<?= get_full_name($this->Grantee_ent_model) ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Grant</label>
                    <input type="text" disabled="disabled" class="form-control" name="bank_address" value="<?= $this->User_grantee_grant_model->name ?>">
                </div>  
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Period</label>
                    <input type="text" disabled="disabled" class="form-control" name="beneficiary_name" value="<?= $this->User_grantee_grant_period_model->fiscal_year ?>">
                </div>  
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" disabled="disabled" class="form-control" name="account_number" value="<?= $this->Grantee_ent_model->primary_email ?>">
                </div>  
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" disabled="disabled" class="form-control" name="routing_number" value="<?= $this->Grantee_ent_model->phone_number ?>">
                </div>  
            </div>
        </div>
        <!-- SUBMISSION PLANT -->
        <div id="wrap-submission-plant">
            <div class="panel-body" style="margin-top:-30px">
                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> FINAL PLACEMENT</p>
            </div>
            <?php if(isset($final_placement->id)){ ?>
                <input type="hidden" name="placement_id" value="<?= $final_placement->id ?>">
            <?php } ?>
            <div class="panel-body" style="margin-top:-30px">   
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>University Name</label>
                        <input type="hidden" name="university_id" value="<?= $final_placement->university_id ?>">
                        <input type="text" class="form-control" value="<?= $final_placement->university_name ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Field of Study</label>
                        <select id="field_of_study_plan" class="form-control select2" name="field_of_study_id" style="width:100%">
                            <option value="">-- Select Field of Study --</option>
                            <?php
                            if ($field_of_study) {
                                foreach ($field_of_study as $fos) {
                                    $selected = '';
                                    if ($final_placement->field_of_study_id == $fos->id) {
                                        $selected = 'selected="selected"';
                                    }
                                    ?>
                                    <option value="<?php echo $fos->id ?>" <?php echo $selected ?>><?php echo $fos->name ?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>  
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Dagree</label>
                        <input type="text" class="form-control" name="dagree" placeholder="Dagree" value="<?= $final_placement->dagree ?>" <?= $final_placement->dagree ? 'readonly' : '' ?>>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Total Cost</label>
                        <input type="text" style="background-color:#fff" class="form-control" placeholder="Total Cost" name="total_cost" value="<?= $final_placement->total_cost ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" class="form-control" placeholder="Department" name="department" value="<?= $final_placement->department ?>" <?= $final_placement->department ? 'readonly' : '' ?>>
                    </div>  
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Bank Statement</label>
                        <input type="text" class="form-control" name="bank_statement" placeholder="Bank Statement" value="<?= $final_placement->bank_statement ?>">
                    </div>
                </div>
            </div>
            <div class="panel-body" style="margin-top:-20px">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="text" readonly style="background-color:#fff" class="form-control datepicker" placeholder="Start Date" name="start_date" value="<?= $final_placement->start_date ? date('d M Y', strtotime($final_placement->start_date)) : '' ?>">
                    </div>  
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Shortfails</label>
                        <textarea name="shortfails" cols="10" rows="2" class="form-control" width="100%"><?= $final_placement->shortfails ?></textarea>
                    </div>  
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Note</label>
                        <textarea class="form-control" rows="2" name="note"><?= $final_placement->note ?></textarea>
                    </div>
                </div>
            </div>
            <div class="panel-body" style="margin-top:-20px">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Upload File (Total Cost)</label>
                        <?php if ($final_placement->file_total_cost != '') { ?>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                <a href="<?php echo base_url() ?><?php echo $final_placement->file_total_cost ?>" class="lightbox"><img height="100" src="<?php echo get_preview($final_placement->file_total_cost); ?>"></a>
                            </div>
                        <?php } ?>
                        <input type="file" name="file_total_cost" id="file_total_cost">
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Upload LoA</label>
                        <?php if ($final_placement->loa != '') { ?>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                <a href="<?php echo base_url() ?><?php echo $final_placement->loa ?>" class="lightbox"><img height="100" src="<?php echo get_preview($final_placement->loa); ?>"></a>
                            </div>
                        <?php } ?>
                        <input type="file" name="loa" id="loa">
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Terms of Arrival (ToA)</label>
                        <?php if ($final_placement->toa != '') { ?>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                <a href="<?php echo base_url() ?><?php echo $final_placement->toa ?>" class="lightbox"><img height="100" src="<?php echo get_preview($final_placement->toa); ?>"></a>
                            </div>
                        <?php } ?>
                        <input type="file" name="toa" id="toa">
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- SUBMISSION PLANT END -->
    </div>

    <div class="row">
        <div class="panel-body" >
            <a href="<?= site_url('admin/nominee/manage')?>" type="button" class="btn btn-default">Back </a>
            <?php if($final_placement){ ?>
                <button type="submit" name="btn" value="submit" class="btn btn-success">Save</button>
            <?php } ?>
        </div>
    </div>
</form>

<div class="modal fade text-center" id="mdl_info_decline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to Decline?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('admin/set_interview/decline/' . $this->Grantee_ent_model->id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade text-center" id="mdl_info_present" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to Present?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('admin/set_interview/present/' . $this->Grantee_ent_model->id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
