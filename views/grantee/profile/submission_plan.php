<!-- <div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Submission Plan</h2>
        <h1 class="page-header"><?php echo $grantee_grant->grant_name ?></h1>
    </div>
</div> -->
<div class="row">
<!-- <div id="submission-plan" class="tab-pane fade"> -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php if($grantee_grant->iie_comment != '') { ?>
                    <div class="alert alert-info mt-4">
                        <strong>IIE Comment</strong> <hr>
                        <?= $grantee_grant->iie_comment ?>
                    </div>
                <?php } ?>
                <?php if($grantee_grant->lock_submission_plan && !$grantee_grant->submission_result_id){ ?>
                    <div class="pull-right mb-2">
                        <a href="<?= site_url('grantee/submission_plan/manage_rank/'.$grantee_grant->user_grantee_id)?>" class="btn btn-success btn-sm">
                            MANAGE RANK
                        </a>
                    </div>
                <?php } ?>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>University</th>
                            <th>Status</th>
                            <th>Rank</th>
                            <th>Reply Deadlines</th>
                            <th width="200" class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submission_plans as $submission_plan) : ?>
                            <tr>
                                <td><?= $submission_plan->university_name; ?></td>
                                <td><?= badge_submission_plan($submission_plan->status); ?></td>
                                <td><?= $submission_plan->rank ?? '' ?></td>
                                <td><?= $submission_plan->reply_deadline ? date('d F, Y', strtotime($submission_plan->reply_deadline)) : '' ?></td>
                                <td class="text-right">
                                    <input data-id="<?= $submission_plan->id ?>" data-toggle="modal" data-target="#modal-detail" type="button" class="btn-xs btn btn-primary view-detail" value="Detail">
                                    <input data-type="record" data-log="<?= $submission_plan->id ?>" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default payment-log" value="Open Log">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- </div> -->
</div>

<form id="form_sp" role="form" method="POST" enctype="multipart/form-data">
<div class="modal fade text-center" id="modal-detail" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detail</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div id="show_data">

                        </div>                       
                    </div>
                    <div class="col-lg-6">
                        <div id="show_data2">

                        </div>                
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="button_approve">Approve</button>
                <input type="hidden" name="btn-submit" id="hidden_submit">
                <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#mdl_note_decline" id="button_decline">Reject</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal" data-toggle="modal" data-target="#mdl_note_decline" id="button_revise">Revise</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_note_decline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Reason & Add New Data</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="submission_plan_id" id="submission_plan_id">
                <div class="row" id="section_reason_rejection">
                    <div class="col-lg-12">
                        <div class="form-group">
				            <label>Reason of Rejection <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reason_rejection" id="note_rejection" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Add New Data</p>
                    </div>
		            <?php $this->load->view('admin/nominee/submission_plan/form_input_grantee') ?>
                </div>
                <div class="row" id="section_reason">
                    <div class="col-lg-12">
                        <div class="form-group">
				            <label>Reason for proposing this university <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reason_decline" id="note_decline" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" id="btn-save-note" name="btn-submit" value="decline" class="btn btn-primary success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
            </div>
        </div>
    </div>
</div>
</form>


<?php $this->load->view('admin/partials/modal_log') ?>