            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header"><?php echo $title ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <form method="POST" enctype="multipart/form-data">
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
                        <?php if($submission_plans) { ?>
                            <div class="panel-body" style="margin-top:-30px">
                                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> SUBMISSION PLAN</p>
                            </div>
                        
                            <?php foreach($submission_plans as $key => $row) { ?>
                                <div id="submission-plant-item-<?= $key ?>" class="submission-plant-item" style="position:relative">
                                    <?php if($key > 0) { echo"<hr style='border: 6px solid #eee;'>"; }?>
                                    <input type="hidden" name="submission_plant[<?= $key ?>][submission_plan_id]" value="<?= $row->id ?>">
                                    <div class="panel-body" style="margin-top:-30px">   
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>University Name</label>
                                                <select id="university_plan_<?= $key ?>" class="form-control select2" name="submission_plant[<?= $key ?>][university_plan]" style="width:100%">
                                                    <option value="">-- Select University Name --</option>
                                                    <?php
                                                    if ($university_list) {
                                                        foreach ($university_list as $ul) {
                                                            $selected = '';
                                                            if ($row->university_id == $ul->id) {
                                                                $selected = 'selected="selected"';
                                                            }
                                                            ?>
                                                            <option value="<?php echo $ul->id ?>" <?php echo $selected ?>><?php echo $ul->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Field of Study</label>
                                                <select id="field_of_study_plan" class="form-control select2" name="submission_plant[<?= $key ?>][field_of_study_plan]" style="width:100%">
                                                    <option value="">-- Select Field of Study --</option>
                                                    <?php
                                                    if ($field_of_study) {
                                                        foreach ($field_of_study as $fos) {
                                                            $selected = '';
                                                            if ($row->field_of_study_id == $fos->id) {
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
                                                <input type="text" class="form-control" name="submission_plant[<?= $key ?>][dagree_plant]" placeholder="Dagree" value="<?= $row->dagree ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Total Cost</label>
                                                <input type="text" style="background-color:#fff" class="form-control" placeholder="Total Cost" name="submission_plant[<?= $key ?>][total_cost_plant]" value="<?= $row->total_cost ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Upload File (Total Cost)</label>
                                                <?php if ($row->file_total_cost != '') { ?>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                        <a href="<?php echo base_url() ?><?php echo $row->file_total_cost ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                    </div>
                                                <?php } ?>
                                                <input type="file" name="file_total_cost_plant_<?= $key ?>" id="file_total_cost_plant_<?= $key ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Note</label>
                                                <textarea class="form-control" rows="2" name="submission_plant[<?= $key ?>][note_plant]"><?= $row->note ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select id="status_plant_<?= $key ?>" class="form-control status_plan" name="submission_plant[<?= $key ?>][status_plant]" style="width:100%" onchange="get_university(this, <?= $key ?>)">
                                                    <option value="">-- Select Status --</option>
                                                    <option <?= $row->status == 'accept' ? 'selected' : '' ?> value="accept">Accept</option>
                                                    <option <?= $row->status == 'reject' ? 'selected' : '' ?> value="reject">Reject</option>
                                                    <option <?= $row->status == 'waiting' ? 'selected' : '' ?> value="waiting">Waiting</option>
                                                </select>
                                            </div>  
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Upload LoA</label>
                                                <?php if ($row->loa != '') { ?>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                        <a href="<?php echo base_url() ?><?php echo $row->loa ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                    </div>
                                                <?php } ?>
                                                <input type="file" name="loa_plant_<?= $key ?>" id="loa_plant_<?= $key ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div id="submission-plant-item-0" class="submission-plant-item" style="position:relative">
                                <div class="panel-body" style="margin-top:-30px">
                                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> SUBMISSION PLAN</p>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>University Name</label>
                                            <select id="university_plan_0" class="form-control select2" name="submission_plant[0][university_plan]" style="width:100%">
                                                <option value="">-- Select University Name --</option>
                                                <?php
                                                if ($university_list) {
                                                    foreach ($university_list as $ul) {
                                                        $selected = '';
                                                        if ($submission_plans->university_id == $ul->id) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $ul->id ?>" <?php echo $selected ?>><?php echo $ul->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Field of Study</label>
                                            <select id="field_of_study_plan" class="form-control select2" name="submission_plant[0][field_of_study_plan]" style="width:100%">
                                                <option value="">-- Select Field of Study --</option>
                                                <?php
                                                if ($field_of_study) {
                                                    foreach ($field_of_study as $fos) {
                                                        $selected = '';
                                                        if ($submission_plans->university_id == $fos->id) {
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
                                            <input type="text" class="form-control" name="submission_plant[0][dagree_plant]" placeholder="Dagree" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Total Cost</label>
                                            <input type="text" style="background-color:#fff" class="form-control" placeholder="Total Cost" name="submission_plant[0][total_cost_plant]" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Upload File (Total Cost)</label>
                                            <?php if ($this->Grantee_ent_model->img_passport != '') { ?>
                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                    <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_passport ?>" class="lightbox" aria-haspopup="dialog">
                                                        <img src="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_passport ?>" width="100">
                                                    </a>
                                                    <a href="javascript:;" onclick="del_file(this, 'file_total_cost_plant', 'Upload File (Total Cost)')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28px;">
                                                        <i class="fa fa-trash fa-fw"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <input type="file" name="file_total_cost_plant_0" id="file_total_cost_plant_0">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea class="form-control" rows="2" name="submission_plant[0][note_plant]"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select id="status_plant_0" class="form-control status_plan" name="submission_plant[0][status_plant]" style="width:100%" onchange="get_university(this, 0)">
                                                <option value="">-- Select Status --</option>
                                                <option value="accept">Accept</option>
                                                <option value="reject">Reject</option>
                                                <option value="waiting">Waiting</option>
                                            </select>
                                        </div>  
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Upload LoA</label>
                                            <?php if ($this->Grantee_ent_model->img_passport != '') { ?>
                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                    <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_passport ?>" class="lightbox" aria-haspopup="dialog">
                                                        <img src="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_passport ?>" width="100">
                                                    </a>
                                                    <a href="javascript:;" onclick="del_file(this, 'loa_plant', 'Upload LoA')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28px;">
                                                        <i class="fa fa-trash fa-fw"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <input type="file" name="loa_plant_0" id="loa_plant_0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="panel-body" style="margin-top:-20px">
                        <div class="col-lg-12">
                            <a href="javascript:;" onclick="add_submission_plant()" class="btn btn-primary">
                                <i class="fa fa-plus fa-fw"></i> Add New
                            </a>
                            <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load" style="display:none;">
                        </div>
                    </div>
                    <!-- SUBMISSION PLANT END -->
                </div>

                <div class="row">
                    <div class="panel-body" >
                        <?php if($submission_plans != null){ ?>
                            <button type="submit" name="btn" value="edit" class="btn btn-success">Save</button>
                        <?php } else { ?>
                            <button type="submit" name="btn" value="submit" class="btn btn-success">Save</button>
                        <?php } ?>
                        <a href="<?= site_url('admin/nominee/manage')?>" type="button" class="btn btn-default">Back </a>
                        <a href="<?= site_url('admin/final_placement/form/'.$grantee_grant_id) ?>" class="btn btn-primary" style="float:right;">View Final Placement </a>
                        <!-- <button type="button" id="btn-present" class="btn btn-primary" style="float:right;">Present </button>
                        <button type="button" id="btn-decline" class="btn btn-danger" style="float:right;margin-right:5px;">Decline</button> -->
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
