<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Edit Submission Result</h2>
        <h1 class="page-header"><?php echo $grantee_grant->grant_name ?></h1>
    </div>
</div>
<div class="row">
<!-- <div id="submission-plan" class="tab-pane fade"> -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <form role="form" method="POST" enctype="multipart/form-data" id="form-submission">
            <div class="panel-body">
                <!-- /.row -->
                <div class="row">
                    <?php if(!isset($upload_bank)) { ?>
                    <div class="col-lg-12 mb-3">
                        <h3 class="page-header"><?= get_university_name($submission->university_id) ?></h3>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Grant Award</label>
                                    <input class="form-control" id="grant_reward" readonly value="<?php echo (isset($grantee_grant->grant_award)) ? number_format($grantee_grant->grant_award) : 0 ?>" >
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Total Cost</label>
                                    <input class="form-control" id="final_cost_university" name="final_cost_university" value="<?php echo (isset($submission_result->final_cost_university)) ? number_format($submission_result->final_cost_university) : '' ?>" >
                                </div>
                            </div>
                            <!-- <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Saving</label>
                                    <?php
                                        $final_cost_university = ($submission_result->final_cost_university ?? 0);
                                        $calculate_cost_saving = $grantee_grant->grant_award - $final_cost_university;

                                    ?>
                                    <input class="form-control" name="saving" id="saving" value="<?= $calculate_cost_saving && ($grantee_grant->grant_award >= $final_cost_university) ? number_format($calculate_cost_saving) : '' ?>">
                                </div>
                            </div> -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Shortfall</label>
                                    <?php
                                        $final_cost_university = ($submission_result->final_cost_university ?? 0);
                                        $calculate_cost_sortfall = $grantee_grant->grant_award - $final_cost_university;

                                    ?>
                                    <input class="form-control" name="sortfall" id="sortfall" value="<?= $calculate_cost_sortfall && ($grantee_grant->grant_award <= $final_cost_university) ? number_format($calculate_cost_sortfall) : '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control status">
                                        <?php foreach ($status as $stat) : ?>
                                            <?php $selected = $stat == $submission_result->status ? "selected" : ""; ?>
                                            <option value="<?= $stat ?>" <?= $selected ?>><?= $stat ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group sec-cost-sharing">
                                    <label>Cost-sharing Status</label>
                                    <select name="cost_sharing" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option <?= $submission_result->cost_sharing == "Pending Decision" ? "selected" : "" ?> value="Pending Decision">Pending Decision</option>
                                        <option <?= $submission_result->cost_sharing == "Granted" ? "selected" : "" ?> value="Granted">Granted</option>
                                        <option <?= $submission_result->cost_sharing == "Not Granted" ? "selected" : "" ?> value="Not Granted">Not Granted</option>
                                    </select>
                                </div>
                                <!-- <div class="form-group hide admitted">
                                    <label>Final Status</label>
                                    <select name="final_status" class="form-control">
                                        <option value="1" <?= $submission_result->final_status == "1" ? "selected" : "" ?> >Accepted</option>
                                        <option value="0" <?= $submission_result->final_status == "0" ? "selected" : "" ?>>Declined</option>
                                    </select>
                                </div> -->
                                <div class="form-group loa-upload">
                                    <label>LoA</label>
                                    <br />
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upload-loa">Add LoA</button>
                                    <?php //if($submission_result->loa != '') { ?>
                                    <!-- <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?= base_url($submission_result->loa)?>" class="lightbox"><img height="100" src="<?php echo get_preview($submission_result->loa); ?>"></a> -->
                                    <!-- <a href="<?= base_url($submission_result->loa) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0; right:-10px;">
                                        <i class="fa fa-download fa-fw text-white"></i>
                                    </a> -->
                                    <!-- </div> -->
                                    <?php //} ?>
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
                                                                <a href="javascript:;" onclick="del_loa_file(this, 'img-col', <?= $fileCores->id ?>, 1)" class="btn btn-danger btn-xs">
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
                                    <label>Rejection Letter <?= generate_view_file($submission_result->rejection_letter, "Rejection Letter"); ?></label>
                                    <input type="file" name="rejection_letter" class="form-control">
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
                    </div>
                    <?php } else { ?>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Bank Statement <span class="text-danger">*</span></label>

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
                                                    <td><a href="<?= base_url($submission_result->bank_statement) ?>" class="lightbox" style="color:#337ab7"><?= $submission_result->bank_statement != '' ? file_name($submission_result->bank_statement) : '' ?></a></td>
                                                    <td>
                                                        <?= $submission_result->status_bank_statement ?>
                                                        <?php if($submission_result->status_bank_statement == 'Revise') { ?>
                                                            <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-placement="top" data-note="<?= $submission_result->note_bank_statement ?>" data-attach='<?= $submission_result->attachment_revise_bank_statement ?>'>i</span>
                                                        <?php } ?>
                                                        <?php if($submission_result->status_bank_statement == 'Rejected') { ?>
                                                            <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-note="<?= $submission_result->note_reject ?>">i</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $submission_result->upload_date_bank_statement ?></td>
                                                    <td>
                                                        <?php if($submission_result->status_bank_statement != 'Approve') { ?>
                                                        <a class="btn btn-primary btn-xs upload_bank_statement" style="color:#fff">Upload</a>
                                                        <?php if($submission_result->bank_statement != '') { ?>
                                                        <a href="javascript:;" onclick="delete_doc_result_admin(this, <?= $submission_result->id ?>, <?= $submission_result->id_parent ?>, '<?= $submission_result->type ?>', 'bank_statement', 0)" class="btn btn-danger btn-xs bank_statement_file" data-id="<?= $submission_result->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php } ?>
                                                        <?php } ?>
                                                        
                                                    </td>
                                                </tr>
                                                <?php //} ?>
                                            </tbody>
                                        </table>
                                        <?php if($submission_result->bank_statement != '') { ?>
                                        <!-- <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?= base_url($submission_result->bank_statement)?>" class="lightbox"><img height="100" src="<?php echo get_preview($submission_result->bank_statement); ?>"></a>
                                        <a href="javascript:;" onclick="delete_doc_result(this, <?= $submission_result->id ?>, <?= $submission_result->id_parent ?>, '<?= $submission_result->type ?>', 'bank_statement')" class="btn btn-danger btn-xs" style="position:absolute; top:25px;">
                                            <i class="fa fa-trash fa-fw text-white"></i>
                                        </a>
                                        <a href="<?= base_url($submission_result->bank_statement) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0;">
                                            <i class="fa fa-download fa-fw text-white"></i>
                                        </a>
                                        </div> -->
                                        <?php } ?>
                                        <input 
                                            data-is_admin="0"
                                            data-id="<?= $submission_result->id ?>"
                                            data-id_parent="<?= $submission_result->id_parent ?>"
                                            data-type="<?= $submission_result->type ?>"
                                            type="file" 
                                            name="bank_statement" 
                                            class="bank_statement_file_upload form-control hide">
                                        <!-- <small class="file-for-testing">File Size Max 5MB</small> -->
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Guarantor Letter </label>
                                        <?php if($submission_result->guarantor_letter != '') { ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?= base_url($submission_result->guarantor_letter)?>" class="lightbox"><img height="100" src="<?php echo get_preview($submission_result->guarantor_letter); ?>"></a>
                                        <a href="javascript:;" onclick="delete_doc_result(this, <?= $submission_result->id ?>, <?= $submission_result->id_parent ?>, '<?= $submission_result->type ?>', 'guarantor_letter')" class="btn btn-danger btn-xs" style="position:absolute; top:25px;">
                                            <i class="fa fa-trash fa-fw text-white"></i>
                                        </a>
                                        <a href="<?= base_url($submission_result->guarantor_letter) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0;">
                                            <i class="fa fa-download fa-fw text-white"></i>
                                        </a>
                                        </div>
                                        <?php } ?>
                                        <input type="file" name="guarantor_letter" class="form-control">
                                        <small class="file-for-testing">File Size Max 5MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- /.col-lg-12 -->
                     <div class="col-lg-12">
                        <a href="<?php echo site_url('grantee/placement/list/' . $this->session->userdata('grantee_user_id')) ?>" class="btn btn-default">Back</a>
                        <button type="button" class="btn btn-success" id="btn-submit-bank-statement" data-bank="<?= $submission_result->bank_statement ?>">Submit</button>
                        <input type="hidden" id="bank_statement_uploaded" value="<?= $submission_result->bank_statement != '' ? $submission_result->bank_statement : '' ?>" >
                     </div>
                </div>
                <!-- /.row -->
                <?php $this->load->view('admin/nominee/submission_result/submission_result_file'); ?>
            </div>
            </form>
        </div>
    </div>
</div>


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
                <input type="hidden" name="submission_result_id_loa" id="submission_result_id_loa" value="<?= $submission_result->id ?>">
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant_id ?>">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-loa-upload" data-is_grantee="1">Save</button>
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