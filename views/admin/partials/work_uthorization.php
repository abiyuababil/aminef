<div id="work_uthorization" class="active in first_tab">
    <div class="panel-body">
        <div class="col-lg-12">
            <div class="form-group">
                <p>Your primary purpose in the U.S. is to complete the program of study for which you were selected. In some cases, you may be eligible for on-or off-campus employment or training. Please review the Fulbright Online Resource and contact your IIE Advisor for more information.</p>
                <p>Note: You must obtain a work authorization letter from IIE before beginning any on- or off-campus employment.</p>
                <label class="my-5">WORK AUTHORIZATION REQUEST</label>

                <?php //if($is_admin) { ?>
                <br />
                <button type="button" class="btn btn-primary add_work" data-toggle="modal" data-target="#add_work">Add New</button>
                <?php //} ?>
                <table class="table table-striped table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Request Date to IIE</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>File</th>
                            <?php if($is_admin) { ?>
                            <th>Request Email</th>
                            <!-- <th>Decision </th> -->
                            <th>Decision Email</th>
                            <?php } ?>
                            <th>Status</th>
                            <?php //if($is_admin){ ?>
                            <th <?= $is_admin ? 'width="250"' : '' ?>>Action</th>
                            <?php //} ?>
                        </tr>
                    </thead>
                    <tbody id="list_work">
                        <?php foreach($data_works as $index => $work) { ?>
                        <tr id="index-work-<?= $index + 1 ?>">
                            <td><?= $work->type ?></td>
                            <td><?= $work->request_date ? date('Y-m-d', strtotime($work->request_date)) : '' ?></td>
                            <td><?= $work->start_date ? date('Y-m-d', strtotime($work->start_date)) : '' ?></td>
                            <td><?= $work->end_date ? date('Y-m-d', strtotime($work->end_date)) : '' ?></td>
                            <td><?= $work->file_work ? '<a class="lightbox" style="color:#337ab7" href="'.base_url($work->file_work).'">'.file_name($work->file_work).'</a>' : '' ?></td>
                            <?php if($is_admin) { ?>
                            <td><?= $work->request_email ? '<a class="lightbox" style="color:#337ab7" href="'.base_url($work->request_email).'">'.file_name($work->request_email).'</a>' : '' ?></td>
                            <!-- <td><?= $work->decision ?></td> -->
                            <td><?= $work->decision_email ? '<a class="lightbox" style="color:#337ab7" href="'.base_url($work->decision_email).'">'.file_name($work->decision_email).'</a>' : '' ?></td>
                            <?php } ?>
                            <?php //if($is_admin) { ?>
                            <td>
                                <?= $work->status ? '<span class="badge badge-'.($work->status == 'Approve' ? 'success' : ($work->status == 'Revise' ? 'warning' : 'info')).'">'.ucfirst($work->status).'</span>' : '<span class="badge badge-info">Submitted</span>' ?>
                                <?php if($work->status == 'Revise') { ?>
                                    <span 
                                        class="label label-primary span-note" 
                                        style="width: 350px;" 
                                        data-toggle="modal" 
                                        style="cursor:pointer;" 
                                        data-target="#modal_note" 
                                        data-placement="top" 
                                        data-note="<?= $work->note ?>" 
                                        data-attach='<?= $work->attachment_revise ?>'>i</span>
                                <?php } ?>
                            </td>
                            <?php if($is_admin || (!$is_admin && $work->status == 'Revise')){ ?>
                            <td>
                                <?php if($is_admin){ ?>
                                <a href="javascript:;" onclick="update_status_war(this, <?= $work->id ?>, 'approve')" class="btn btn-success btn-xs" style="color:#fff">
                                    Approve
                                </a>
                                <a href="javascript:;" onclick="update_status_war(this, <?= $work->id ?>, 'revise')" class="btn btn-warning btn-xs" style="color:#fff">
                                    Revise
                                </a>
                                <?php } ?>
                                <a onclick="edit_data_work(this, <?= $work->id ?>, <?= $index + 1 ?>)" class="btn btn-primary btn-xs edit-work" style="color:#fff">
                                    Edit
                                </a>
                                <a href="javascript:;" onclick="del_data_work(this, <?= $work->id ?>)" class="btn btn-danger btn-xs" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                            </td>
                            <?php } else { ?>
                                <td></td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
                <a target="_blank" class="btn btn-primary" id="attach_revise" style="color:#fff;">Attachment</a>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>