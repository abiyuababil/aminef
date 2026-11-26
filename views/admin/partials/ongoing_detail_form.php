<?php if($grantee_grant->is_degree){ ?>
<div class="panel panel-default">
    <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseAdditionalHealth" aria-expanded="true" aria-controls="collapseAdditionalHealth" onclick="return set_session('health')">
        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
            <h4 class="panel-title">
                Additional Health Insurance
            </h4>
        </div>
    </a>
    <div id="collapseAdditionalHealth" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'health' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-body">
            <div class="form-group">
                <!-- <label>Additional health insurance if you stay in the U.S. longer beyond the end date of the program stated in your DS2019</label> -->
                <table class="table table-striped table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th width="30%">File Upload</th>
                            <th>Status</th>
                            <th>Upload Date</th>
                            <?php if(!$is_alumni_page) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="health_insurance_list">
                        <?php // FOR MULTIPLE DATA
                        // foreach($file_health_insurance as $health_insurance) { 
                        //     $fileDs2019 = '';
                        //     if($health_insurance->file_admin){
                        //         $health_insurance_file = explode('/', $health_insurance->file_admin);
                        //         $fileDs2019 = $health_insurance_file ? end($health_insurance_file) : '';
                        //         $detail_file = $health_insurance_file ? explode('.', $fileDs2019) : '';
                        //     }
                        ?>
                        <tr>
                            <td><a href="<?= base_url($health_insurance->file) ?>" class="lightbox" style="color:#337ab7"><?= $health_insurance->filename ?></a></td>
                            <td>
                                <?= $health_insurance->status ?>
                                <?php if($health_insurance->status == 'Revise') { ?>
                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $health_insurance->note ?>" data-attach='<?= $health_insurance->attachment_revise ?>'>i</span>
                                <?php } ?>
                                <?php if($health_insurance->status == 'Rejected') { ?>
                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $health_insurance->note_reject ?>" data-attach='<?= $health_insurance->attachment_revise ?>'>i</span>
                                <?php } ?>
                            </td>
                            <td><?= $health_insurance->created_date ?></td>
                            <?php if(!$is_alumni_page) { ?>
                            <td>
                                <input type="hidden" name="health_insurance_id" id="health_insurance_id" value="<?= $grantee_grant->id ?>">
                                <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_health_insurance_<?= $grantee_grant->id ?> hide">
                                <a class="btn btn-primary btn-xs upload_departure_item <?= (!$is_admin && $health_insurance->status == 'Revise') || $is_admin || $health_insurance->file == '' ? '' : 'hide' ?>" data-id="<?= $grantee_grant->id ?>" style="color:#fff" data-document="health_insurance" data-file-value="upload_health_insurance_<?= $grantee_grant->id ?>">Upload</a>

                                <?php if($is_admin) { ?>
                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'health_insurance')" class="btn btn-success <?= $health_insurance->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                        Approve
                                    </a>
                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'health_insurance')" class="btn btn-warning <?= $health_insurance->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                        Revise
                                    </a>
                                    <input data-log="<?= $health_insurance->id ?>" data-type="health_insurance" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $health_insurance->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                <?php } ?>
                                <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'health_insurance')" class="btn btn-danger show-button btn-xs btn-del-health_insurance <?= (!$is_admin && $health_insurance->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= $health_insurance->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php //} ?>
                    </tbody>
                </table>
                <em>If you plan to stay in the U.S. beyond your DS-2019 end date, you must secure additional health insurance coverage.</em>
                <hr />
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseProofStudy" aria-expanded="true" aria-controls="collapseProofStudy" onclick="return set_session('proof_study')">
        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
            <h4 class="panel-title">
                Proof of Study Completion
            </h4>
        </div>
    </a>
    <div id="collapseProofStudy" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'proof_study' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-body">
            <div class="form-group">
                <!-- <label>Proof of Study Completion from university</label> -->
                <em><?= $grantee_grant->is_degree ? 'Diploma' : 'Letter from Graduate School or Diploma' ?></em>
                <table class="table table-striped table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th width="30%">File Upload</th>
                            <th>Status</th>
                            <th>Upload Date</th>
                            <?php if(!$is_alumni_page) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="proof_of_study_completion_list">
                        <?php // FOR MULTIPLE DATA
                        // foreach($file_proof_of_study_completion as $proof_of_study_completion) { 
                        //     $fileDs2019 = '';
                        //     if($proof_of_study_completion->file_admin){
                        //         $proof_of_study_completion_file = explode('/', $proof_of_study_completion->file_admin);
                        //         $fileDs2019 = $proof_of_study_completion_file ? end($proof_of_study_completion_file) : '';
                        //         $detail_file = $proof_of_study_completion_file ? explode('.', $fileDs2019) : '';
                        //     }
                        ?>
                        <tr>
                            <td><a href="<?= base_url($proof_of_study_completion->file) ?>" class="lightbox" style="color:#337ab7"><?= $proof_of_study_completion->filename ?></a></td>
                            <td>
                                <?= $proof_of_study_completion->status ?>
                                <?php if($proof_of_study_completion->status == 'Revise') { ?>
                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $proof_of_study_completion->note ?>" data-attach='<?= $proof_of_study_completion->attachment_revise ?>'>i</span>
                                <?php } ?>
                                <?php if($proof_of_study_completion->status == 'Rejected') { ?>
                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $proof_of_study_completion->note_reject ?>" data-attach='<?= $proof_of_study_completion->attachment_revise ?>'>i</span>
                                <?php } ?>
                            </td>
                            <td><?= $proof_of_study_completion->created_date ?></td>
                            <?php if(!$is_alumni_page) { ?>
                            <td>
                                <input type="hidden" name="proof_of_study_completion_id" id="proof_of_study_completion_id" value="<?= $grantee_grant->id ?>">
                                <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_proof_of_study_completion_<?= $grantee_grant->id ?> hide">
                                <a class="btn btn-primary btn-xs upload_departure_item <?= (!$is_admin && $proof_of_study_completion->status == 'Revise') || $is_admin || $proof_of_study_completion->file == '' ? '' : 'hide' ?>" data-id="<?= $grantee_grant->id ?>" style="color:#fff" data-document="proof_of_study_completion" data-file-value="upload_proof_of_study_completion_<?= $grantee_grant->id ?>">Upload</a>

                                <?php if($is_admin) { ?>
                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'proof_of_study_completion')" class="btn btn-success <?= $proof_of_study_completion->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                        Approve
                                    </a>
                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'proof_of_study_completion')" class="btn btn-warning <?= $proof_of_study_completion->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                        Revise
                                    </a>
                                    <input data-log="<?= $proof_of_study_completion->id ?>" data-type="proof_of_study_completion" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $proof_of_study_completion->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                <?php } ?>
                                <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'proof_of_study_completion')" class="btn btn-danger show-button btn-xs btn-del-proof_of_study_completion <?= (!$is_admin && $proof_of_study_completion->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= $proof_of_study_completion->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php //} ?>
                    </tbody>
                </table>
                <hr />
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php if(!$grantee_grant->is_degree) { ?>
<div class="panel panel-default">
    <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseCopyUpdated" aria-expanded="true" aria-controls="collapseCopyUpdated" onclick="return set_session('copy_updated')">
        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
            <h4 class="panel-title">
                Copy of Updated Return International Ticket
            </h4>
        </div>
    </a>
    <div id="collapseCopyUpdated" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'copy_updated' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-body">
            <div class="form-group">
                <!-- <label>Copy of your updated return international ticket</label> -->
                <table class="table table-striped table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th width="30%">File Upload</th>
                            <th>Status</th>
                            <th>Upload Date</th>
                            <?php if(!$is_alumni_page) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="return_international_ticket_list">
                        <?php // FOR MULTIPLE DATA
                        // foreach($file_return_international_ticket as $return_international_ticket) { 
                        //     $fileDs2019 = '';
                        //     if($return_international_ticket->file_admin){
                        //         $return_international_ticket_file = explode('/', $return_international_ticket->file_admin);
                        //         $fileDs2019 = $return_international_ticket_file ? end($return_international_ticket_file) : '';
                        //         $detail_file = $return_international_ticket_file ? explode('.', $fileDs2019) : '';
                        //     }]
                                $return_international_ticket_file = $return_international_ticket->file;
                                    // $travel_arrangement
                                    // ? $travel_arrangement->eticket
                                    // : $return_international_ticket->file;

                                $return_international_ticket_filename = $return_international_ticket->filename;
                                    // $travel_arrangement->eticket
                                    // ? basename($travel_arrangement->eticket)
                                    // : $return_international_ticket->filename;

                                $return_international_ticket_status = $return_international_ticket->status;
                                    // $travel_arrangement->eticket
                                    // ? $return_international_ticket->status 
                                    // : '';

                                $return_international_ticket_created_date = $return_international_ticket->created_date;
                                    // $travel_arrangement->eticket
                                    // ? $travel_arrangement->created_date
                                    // : $return_international_ticket->created_date;

                        ?>
                        <tr>
                            <td><a href="<?= base_url($return_international_ticket_file) ?>" class="lightbox" style="color:#337ab7"><?= $return_international_ticket_filename ?></a></td>
                            <td>
                                <?= $return_international_ticket_status ?>
                                <?php if($return_international_ticket_status == 'Revise') { ?>
                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $return_international_ticket->note ?>" data-attach='<?= $return_international_ticket->attachment_revise ?>'>i</span>
                                <?php } ?>
                                <?php if($return_international_ticket->status == 'Rejected') { ?>
                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $return_international_ticket->note_reject ?>" data-attach='<?= $return_international_ticket->attachment_revise ?>'>i</span>
                                <?php } ?>
                            </td>
                            <td><?= $return_international_ticket_created_date ?></td>
                            <?php if(!$is_alumni_page) { ?>
                            <td>
                                <input type="hidden" name="return_international_ticket_id" id="return_international_ticket_id" value="<?= $grantee_grant->id ?>">
                                <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_return_international_ticket_<?= $grantee_grant->id ?> hide">
                                <a class="btn btn-primary btn-xs upload_departure_item <?= (!$is_admin && $return_international_ticket_status == 'Revise') || $return_international_ticket_file == '' ? '' : 'hide' ?>" data-id="<?= $grantee_grant->id ?>" style="color:#fff" data-document="return_international_ticket" data-file-value="upload_return_international_ticket_<?= $grantee_grant->id ?>">Upload</a>

                                <?php if($is_admin) { ?>
                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'return_international_ticket')" class="btn btn-success <?= $return_international_ticket->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                        Approve
                                    </a>
                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'return_international_ticket')" class="btn btn-warning <?= $return_international_ticket->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                        Revise
                                    </a>
                                    <input data-log="<?= $return_international_ticket->id ?>" data-type="return_international_ticket" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $return_international_ticket->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                <?php } ?>
                                <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'return_international_ticket')" class="btn btn-danger show-button btn-xs btn-del-return_international_ticket <?= (!$is_admin && $return_international_ticket->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= $return_international_ticket->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php //} ?>
                    </tbody>
                </table>
                <em>Check with your airline for any updates or changes to your return ticket.</em>
                <hr />
            </div>
        </div>
    </div>
</div>
<?php } ?>