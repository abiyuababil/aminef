<style>
    .table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #ebebeb;
        color: #7da2bd;
    }
</style>
<div class="row">
	<div class="col-lg-12">
        <h1><?= get_full_name($grantee_grant) ?></h1>
		<h3 class="page-header"><?= $page_title ?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<form role="form" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Grant Award</label>
                        <input class="form-control" id="grant_reward" readonly value="<?php echo (isset($grantee_grant->grant_award)) ? number_format($grantee_grant->grant_award) : 0 ?>" >
                        <input type="checkbox" value="1" autocomplete="off" name="sortfall_covered" id="sortfall_covered" <?= $this->Submission_result_model->sortfall_covered == 1 ? "checked" : "" ?>>
                        <label class="is_unlimited_label" for="sortfall_covered">Shortfall Covered by AMINEF</label>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Total Cost</label>
                        <input class="form-control" id="final_cost_university" name="final_cost_university" value="<?php echo (isset($this->Submission_result_model->final_cost_university)) ? number_format($this->Submission_result_model->final_cost_university) : '' ?>" >
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Saving</label>
                        <?php
                            $final_cost_university = ($this->Submission_result_model->final_cost_university ?? 0);
                            $calculate_cost_saving = $final_cost_university ? $grantee_grant->grant_award - $final_cost_university : 0;

                        ?>
                        <input class="form-control" name="saving" id="saving" value="<?= $calculate_cost_saving && ($grantee_grant->grant_award >= $final_cost_university) ? number_format($calculate_cost_saving) : 0 ?>">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Shortfall</label>
                        <?php
                            $final_cost_university = ($this->Submission_result_model->final_cost_university ?? 0);
                            $calculate_cost_sortfall = $grantee_grant->grant_award - $final_cost_university;

                        ?>
                        <input class="form-control" name="sortfall" id="sortfall" value="<?= $calculate_cost_sortfall && ($grantee_grant->grant_award <= $final_cost_university) ? number_format($calculate_cost_sortfall) : 0 ?>">
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Degree</label>
                        <input class="form-control" name="degree" id="degree" value="<?= $this->Submission_result_model->degree ?>">
                    </div>
                    <div class="form-group">
                        <label>Major</label>
                        <input class="form-control" name="major" id="major" value="<?= $this->Submission_result_model->major ?>">
                    </div>
                    <div class="form-group">
                        <label>Specialization</label>
                        <input class="form-control" name="specialization" id="specialization" value="<?= $this->Submission_result_model->specialization ?>">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Credits</label>
                        <input class="form-control" name="credits" value="<?= $this->Submission_result_model->credits ?>">
                    </div>
                    <div class="form-group">
                        <label>Program Duration</label>
                        <input class="form-control" name="program_duration" value="<?= $this->Submission_result_model->program_duration ?>">
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#submission_result_file">Add Submission Result</button>
                    </div>
                    <table class="table">
                        <tr>
                            <th>File Upload</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                        <tbody id="list_data">
                            <?php foreach($submission_result_files as $submission_result_file): ?>
                            <tr>
                                <td><a href="<?= site_url($submission_result_file->file); ?>" target="_blank"><?= $submission_result_file->filename ?></a></td>
                                <td><?= format_date_time($submission_result_file->created_at) ?></td>
                                <td><a href="<?= base_url('admin/nominee/submission_result/delete_file/'.$submission_result_file->id) ?>" onclick="return confirm('Are you sure want to delete this ?')" class="btn btn-danger">Delete</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control status">
                            <?php foreach ($status as $stat) : ?>
                                <?php $selected = $stat == $this->Submission_result_model->status ? "selected" : ""; $stat_value = $stat; if($stat == 'Pending Decision'){ $stat = 'Pending'; }?>
                                <option value="<?= $stat_value ?>" <?= $selected ?>><?= $stat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group sec-cost-sharing">
                        <label>Cost-sharing Status</label>
                        <select name="cost_sharing" class="form-control">
                            <option value="">-- Select --</option>
                            <option <?= $this->Submission_result_model->cost_sharing == "Pending Decision" ? "selected" : "" ?> value="Pending Decision">Pending Decision</option>
                            <option <?= $this->Submission_result_model->cost_sharing == "Granted" ? "selected" : "" ?> value="Granted">Granted</option>
                            <option <?= $this->Submission_result_model->cost_sharing == "Not Granted" ? "selected" : "" ?> value="Not Granted">Not Granted</option>
                        </select>
                    </div>
                    <div class="form-group sec-reply-deadline">
                        <label>Reply Deadline</label>
                        <input type="text" name="replay_deadline" class="form-control datepicker" value="<?= $this->Submission_result_model->replay_deadline ? date('d M Y', strtotime($this->Submission_result_model->replay_deadline)) : '' ?>">
                    </div>
                    <!-- <div class="form-group hide admitted">
                        <label>Final Status</label>
                        <select name="final_status" class="form-control">
                            <option value="1" <?= $this->Submission_result_model->final_status == "1" ? "selected" : "" ?> >Accepted</option>
                            <option value="0" <?= $this->Submission_result_model->final_status == "0" ? "selected" : "" ?>>Declined</option>
                        </select>
                    </div> -->
                    <div class="form-group loa-upload">
                        <label>LoA</label>
                        <br />
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upload-loa">Add LoA</button>
                        <?php if($this->Submission_result_model->loa != '') { ?>
                        <!-- <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?= base_url($this->Submission_result_model->loa)?>" class="lightbox"><img height="100" src="<?php echo get_preview($this->Submission_result_model->loa); ?>"></a>
                        <a href="<?= base_url($this->Submission_result_model->loa) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0; right:-10px;">
                            <i class="fa fa-download fa-fw text-white"></i>
                        </a>
                        </div> -->
                        <?php } ?>
                        <!-- <input type="file" name="loa" class="form-control">
                        <small class="file-for-testing">File Size Max 5MB</small> -->
                    </div>
                    <div class="col-lg-12 loa-upload">
                        <div class="form-group">
                                <table class="table table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>Extension</th>
                                                <th>Upload Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_loa">
                                            <?php foreach($loa_files as $key => $fileCores) {
                                                $detail_file = explode('.', $fileCores->filename);
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="<?= base_url($fileCores->file) ?>" class="lightbox" style="cursor: pointer;">
                                                        <?= $detail_file[0] ?>
                                                    </a>
                                                </td>
                                                <td><?= end($detail_file) ?></td>
                                                <td><?= $fileCores->created_date ?></td>
                                                <td>
                                                    <a href="<?= base_url($fileCores->file) ?>" download title="Click to download" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-download fa-fw text-white"></i>
                                                    </a>
                                                    <a href="javascript:;" onclick="del_loa_file(this, 'img-col', <?= $fileCores->id ?>)" class="btn btn-danger btn-xs">
                                                        <i class="fa fa-trash fa-fw text-white"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                </table>
                        </div>
                    </div>


                    <div class="form-group rejection-letter hide">
                        <label>Rejection Letter </label><br />
                        <?= generate_view_file($this->Submission_result_model->rejection_letter, "Rejection Letter"); ?>
                        <a class="btn btn-danger <?= $this->Submission_result_model->rejection_letter ? '' : 'hide' ?>" onclick="delete_rejection_letter(this, <?= $this->Submission_result_model->id ?>)" id="rejection_letter_delete">Delete</a>
                        <input type="file" name="rejection_letter" class="form-control mt-3" >
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                    <?php if($this->Submission_result_model->type == 'direct_application') { ?>
                    <div class="form-group">
                        <label>Nominee can select University from Direct Application?</label>
                        <select name="is_authorize" class="form-control">
                            <option value="1" <?= $this->Submission_result_model->is_authorize == "1" ? "selected" : "" ?> >Yes</option>
                            <option value="0" <?= $this->Submission_result_model->is_authorize == "0" ? "selected" : "" ?>>No</option>
                        </select>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Admission Conditions</label>
                        <textarea name="note" id="note" class="form-control" rows="4"><?= $this->Submission_result_model->note ?></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Cost Sharing Details</label>
                        <textarea name="cost_sharing_detail" id="cost_sharing_detail" class="form-control" rows="4"><?= $this->Submission_result_model->cost_sharing_detail ?></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Bank Statement</label>

                        <table class="table table-striped table-bordered table-responsive mt-4">
                            <thead>
                                <tr>
                                    <th>File Upload</th>
                                    <th>Status</th>
                                    <th>Upload Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="<?= base_url($this->Submission_result_model->bank_statement) ?>" class="lightbox" style="color:#337ab7"><?= $this->Submission_result_model->bank_statement != '' ? file_name($this->Submission_result_model->bank_statement) : '' ?></a></td>
                                    <td>
                                        <?= $this->Submission_result_model->status_bank_statement ?>
                                        <?php if($this->Submission_result_model->status_bank_statement == 'Revise') { ?>
                                            <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-placement="top" data-note="<?= $this->Submission_result_model->note_bank_statement ?>" data-attach='<?= $this->Submission_result_model->attachment_revise_bank_statement ?>'>i</span>
                                        <?php } ?>
                                        <?php if($this->Submission_result_model->status_bank_statement == 'Rejected') { ?>
                                            <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-note="<?= $this->Submission_result_model->note_bank_statement ?>">i</span>
                                        <?php } ?>
                                    </td>
                                    <td><?= $this->Submission_result_model->upload_date_bank_statement ?></td>
                                    <td>
                                        <?php if($this->Submission_result_model->status_bank_statement != 'Approve') { ?>
                                        <a class="btn btn-primary btn-xs upload_bank_statement" style="color:#fff">Upload</a>
                                        <?php } ?>

                                        <?php if($this->Submission_result_model->bank_statement) { ?>
                                        <a href="javascript:;" onclick="update_status_bank_statement(this, <?= $this->Submission_result_model->id ?>, 'approve')" class="btn btn-success btn-xs" style="color:#fff">
                                            Approve
                                        </a>
                                        <a href="javascript:;" onclick="update_status_bank_statement(this, <?= $this->Submission_result_model->id ?>, 'revise')" class="btn btn-warning btn-xs" style="color:#fff">
                                            Revise
                                        </a>
                                        <!-- <input 
                                            data-id="<?= $this->Submission_result_model->id_parent ?>"
                                            data-type="<?= $this->Submission_result_model->type ?>"
                                            data-toggle="modal"
                                            data-target="#viewLog"
                                            type="button"
                                            class="btn-xs btn btn-default view-log" value="Open Log" style="font-size:12px;"> -->
                                        <?php } ?>
                                        
                                        <?php if($this->Submission_result_model->bank_statement != '') { ?>
                                        <a href="javascript:;" onclick="delete_doc_result_admin(this, <?= $this->Submission_result_model->id ?>, <?= $this->Submission_result_model->id_parent ?>, '<?= $this->Submission_result_model->type ?>', 'bank_statement')" class="btn btn-danger btn-xs bank_statement_file" data-id="<?= $this->Submission_result_model->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php //} ?>
                            </tbody>
                        </table>

                        
                        <?php if($this->Submission_result_model->bank_statement != '') { ?>
                        <!-- <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?= base_url($this->Submission_result_model->bank_statement)?>" class="lightbox bank_statement_file"><img height="100" src="<?php echo get_preview($this->Submission_result_model->bank_statement); ?>"></a>
                        <a href="javascript:;" onclick="delete_doc_result_admin(this, <?= $this->Submission_result_model->id ?>, <?= $this->Submission_result_model->id_parent ?>, '<?= $this->Submission_result_model->type ?>', 'bank_statement')" class="btn btn-danger btn-xs bank_statement_file" style="position:absolute; top:25px;">
                            <i class="fa fa-trash fa-fw text-white"></i>
                        </a>
                        <a href="<?= base_url($this->Submission_result_model->bank_statement) ?>" download title="Click to Download" class="btn btn-primary btn-xs bank_statement_file" style="position:absolute; top:0;">
                            <i class="fa fa-download fa-fw text-white"></i>
                        </a>
                        </div> -->
                        <?php } ?>
                        <input 
                            data-is_admin="1"
                            data-id="<?= $this->Submission_result_model->id ?>"
                            data-id_parent="<?= $this->Submission_result_model->id_parent ?>"
                            data-type="<?= $this->Submission_result_model->type ?>"
                            type="file" 
                            name="bank_statement" 
                            class="form-control hide bank_statement_file_upload">
                        <!-- <small class="file-for-testing">File Size Max 5MB</small> -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Guarantor Letter</label>
                        <?php if($this->Submission_result_model->guarantor_letter != '') { ?>
                        <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?= base_url($this->Submission_result_model->guarantor_letter)?>" class="lightbox guarantor_letter_file"><img height="100" src="<?php echo get_preview($this->Submission_result_model->guarantor_letter); ?>"></a>
                        <a href="javascript:;" onclick="delete_doc_result_admin(this, <?= $this->Submission_result_model->id ?>, <?= $this->Submission_result_model->id_parent ?>, '<?= $this->Submission_result_model->type ?>', 'guarantor_letter')" class="btn btn-danger btn-xs guarantor_letter_file" style="position:absolute; top:25px;">
                            <i class="fa fa-trash fa-fw text-white"></i>
                        </a>
                        <a href="<?= base_url($this->Submission_result_model->guarantor_letter) ?>" download title="Click to Download" class="btn btn-primary btn-xs guarantor_letter_file" style="position:absolute; top:0;">
                            <i class="fa fa-download fa-fw text-white"></i>
                        </a>
                        </div>
                        <?php } ?>
                        <input type="file" name="guarantor_letter" class="form-control">
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
            </div>

            <div class="row hide">
                <hr>
                <div class="col-lg-6">
                    <div class="form-group invoice">
                        <label>Upload Proof of Transfer</label>
                        <input type="file" id="input-file" name="invoice_allowance[]" multiple class="form-control">
                        <small class="file-for-testing">File Size Max 5MB</small>
                        <button class="btn btn-primary mt-2" type="button" id="btn-invoice">Upload Proof of Transfer</button>
                        <img src="<?php echo base_url() ?>/img/loading.gif" id="load-upload" style="display:none;">
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:20px">
                <!-- upload invoice  -->
                <div class="col-lg-12">
                    <div class="wrap-invoice">
                        <?php foreach($data_invoice as $key => $d_i) { 
                                $nameFile = end(explode('/', $d_i->file));
                                $fileName = end(explode('/', $d_i->file));
                                if(strlen($fileName) > 15){
                                    $fileName = substr($fileName, 0, 15) . '....';
                                }
                        ?>
                        <div class="col-lg-3 img-col" style="height: 150px;">
                            <a href="<?= base_url($d_i->file) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($d_i->file); ?>"></a>
                            <a href="javascript:;" onclick="del_item(this, 'img-col', <?= $d_i->id ?>)" class="btn btn-danger btn-xs" style="position:absolute; top:25px;">
                                <i class="fa fa-trash fa-fw text-white"></i>
                            </a>
                            <a href="<?= base_url($d_i->file) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                <i class="fa fa-download fa-fw text-white"></i>
                            </a>
                            <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $nameFile ?>"><?= $fileName ?></p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel pull-right">
                        <a href="<?php echo site_url('admin/nominee/submission_result/manage/' . $grantee_grant_id) ?>" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
		</form>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php $this->load->view('admin/nominee/submission_result/submission_result_file'); ?>
<?php $this->load->view('admin/nominee/submission_result/view_log') ?>

<div class="modal fade" id="upload-loa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Upload Letter of Acceptance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label>Letter of Acceptance</label>
                <input type="file" id="upload_loa_input_file" name="upload-loa[]" multiple>
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="submission_result_id_loa" id="submission_result_id_loa" value="<?= $this->Submission_result_model->id ?>">
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant_id ?>">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-loa-upload">Save</button>
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
                            <textarea class="form-control" name="note_revise" id="note_revise" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-save-note" name="btn-submit" value="decline" class="btn btn-primary success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_note" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <textarea class="form-control note-note" disabled rows="6" style="resize: none;"></textarea>
            </div>
            <div class="mt-2 text-center">
                <a target="_blank" class="btn btn-primary" id="attach_revise">Attachment</a>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>