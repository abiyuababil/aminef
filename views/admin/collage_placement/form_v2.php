<style>
    .TriSea-technologies-Switch > input[type="checkbox"] {
        display: none;   
    }

    .TriSea-technologies-Switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .TriSea-technologies-Switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .TriSea-technologies-Switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }
</style>
<?php if(!$is_alumni_page) { ?>
<div class="row">
    <div class="col-lg-12">
        <h1><?php echo $title ?></h1>
        <h3 class="page-header"><?=$grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>
<?php } ?>

<?php if($this->session->flashdata('success_placement')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success_placement') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success_placement');?>

<form method="POST" enctype="multipart/form-data" style="margin-top: 30px;" id="form_placement" class="warp-alumni-page">
    <?php if(!$is_alumni_page) { ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="TriSea-technologies-Switch">
                <span class="mr-2">Final Placement Without Submission</span>
                <input id="is_final_placement" name="is_final_placement" type="checkbox" <?= $grantee_grant->is_final_placement || !$check_menu_nominee  ? 'checked' : '' ?>/>
                <label for="is_final_placement" class="label-primary"></label>
            </div>
        </div>
    </div>
    <?php } ?>
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
            <?php if($collage_placement){ ?>
                <input type="hidden" name="placement_id" value="<?= $collage_placement->id ?>">
            <?php } ?>
            <?php $this->load->view('admin/partials/field_final_placement') ?>
            
            
            <div class="panel-body" style="margin-top:-30px">
                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> GRANT DOCUMENT</p>
            </div>
            <?php $this->load->view('admin/partials/field_final_placement_grant_document') ?>
        </div>
        <!-- SUBMISSION PLANT END -->
    </div>

    <?php if(!$is_alumni_page) { ?>
    <!-- <div class="row">
        <div class="panel-body pull-right">
            <button type="button" name="btn" value="cancel" id="btn-cancel" class="btn btn-danger">Cancel Final Placement</button>
            <button type="button" name="btn" value="departure" id="btn-departure" class="btn btn-primary">Set to Departure</button>
        </div>
    </div> -->
    <!-- <div class="row">
        <div class="panel-body pull-right">
            <button type="button" name="btn" value="cancel" id="btn-cancel" class="btn btn-danger">Cancel Final Placement</button>
            <button type="button" name="btn" value="departure" id="btn-departure" class="btn btn-primary">Set to Departure</button>
        </div>
    </div> -->
    
    <div class="row">
        <div class="panel-body pull-right">
            <a href="<?= $back_url ?>" type="button" class="btn btn-primary">Back </a>
            <button type="button" name="btn" value="cancel" id="btn-cancel" class="btn btn-danger">Cancel Final Placement</button>
            <a href="#" data-id="<?= $grantee_grant->id ?>" data-section="candidate" class="btn btn-warning withdraw">Withdraw</a>
            <a href="#" data-id="<?= $grantee_grant->id ?>" data-section="candidate" class="btn btn-danger drop">Drop</a>
            <button type="button" name="btn" value="departure" id="btn-departure" class="btn btn-primary">Set to Departure</button>
            <button type="submit" name="btn" value="submit" form="form_placement" class="btn btn-success">Save</button>
            <input type="hidden" id="data_section" value="final_placement">
        </div>
    </div>
    <?php } ?>
</form>


<?php $this->load->view('admin/partials/modal_confirm') ?>

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

<div class="modal fade" id="corespondence_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Upload <?= $grantee_grant->university_cores == '' ? 'University Corespondence' : $grantee_grant->university_cores ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label><?= $grantee_grant->university_cores == '' ? 'University Corespondence' : $grantee_grant->university_cores ?></label>
                <input type="file" id="corespondence_file_input_file" name="corespondence_file" multiple>
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="collage_placement_id" id="collage_placement_id" value="<?= $collage_placement->id ?>">
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-corespondence">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="toa_pre_academic_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Upload Term of Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label>Term of Appointment</label>
                <input type="file" id="toa_pre_academic_file_input_file" name="toa_pre_academic_file">
                <!-- <small class="file-for-testing">File Size Max 5MB</small> -->
                <input type="hidden" name="collage_placement_id" id="collage_placement_id" value="<?= $collage_placement->id ?>">
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">
            </div>
            <div class="form-group">
              <label>Deadline Date <span style='color:red'> *</span></label>
              <input type="text" class="form-control datetime" name="deadline_date" id="deadline_date_toa_pre_academic">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-toa_pre_academic">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="toa_placement_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"><?= $grantee_grant->toa == '' ? 'ToA (Terms of Appointment)' : $grantee_grant->toa ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label><?= $grantee_grant->toa == '' ? 'ToA (Terms of Appointment)' : $grantee_grant->toa ?></label>
                <input type="file" id="toa_placement_input_file" name="toa_placement_file">
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="collage_placement_id" id="collage_placement_id" value="<?= $collage_placement->id ?>">
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">
            </div>
            <div class="form-group">
              <label>Deadline Date <span style='color:red'> *</span></label>
              <input type="text" class="form-control datetime" name="deadline_date" id="deadline_date_toa_placement">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-toa_placement">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="final_placement_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"><?= $grantee_grant->final_placement_detail == '' ? 'Final Placement Detail' : $grantee_grant->final_placement_detail ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label><?= $grantee_grant->final_placement_detail == '' ? 'Final Placement Detail' : $grantee_grant->final_placement_detail ?></label>
                <input type="file" id="final_placement_detail_file" name="final_placement_detail" multiple>
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="collage_placement_id" id="collage_placement_id" value="<?= $collage_placement->id ?>">
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-final_placement_detail">Save</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="mdl_note_revise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Note</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="submission_plan_id" id="submission_plan_id">
                <div class="row" id="section_reason_rejection">
                    <div class="col-md-12">
                        <label>Attachment</label>
                        <label for="temp_attachment_revise" class="withdraw-attachment-area">
                            <input type="file" id="temp_attachment_revise" name="temp_attachment_revise" class="hide" onchange="show_preview_attch(this, 'attachment_revise', 'attachment_revise');">
                            <input type="text" id="attachment_revise" name="attachment_revise" class="hide">
                            <i class="fa fa-cloud-upload"></i>
                        </label>
                        <div class="col-md-12 text-center">
                            <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
				                    <label>Note</label>
                            <textarea class="form-control" name="note_revise_toa_pre" id="note_revise_toa_pre" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-save-note-pre" name="btn-submit" value="decline" class="btn btn-primary success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_note_revise_placement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Note</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="submission_plan_id" id="submission_plan_id">
                <div class="row" id="section_reason_rejection">
                    <div class="col-md-12">
                        <label>Attachment</label>
                        <label for="temp_attachment_revise_placement" class="withdraw-attachment-area">
                            <input type="file" id="temp_attachment_revise_placement" name="temp_attachment_revise" class="hide" onchange="show_preview_attch(this, 'attachment_revise', 'attachment_revise');">
                            <input type="text" id="attachment_revise_placement" name="attachment_revise" class="hide">
                            <i class="fa fa-cloud-upload"></i>
                        </label>
                        <div class="col-md-12 text-center">
                            <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
				                    <label>Note</label>
                            <textarea class="form-control" name="note_revise_toa_placement" id="note_revise_toa_placement" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-save-note-placement" name="btn-submit" value="decline" class="btn btn-primary success">Save</button>
            </div>
        </div>
    </div>
</div>
