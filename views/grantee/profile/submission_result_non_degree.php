<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body table">
                <p style="font-weight:bold;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Submission Result</p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <?php 
                            $has_irf_file = !empty(array_filter($submission_results_non_degree, function($item) {
                                return !empty($item->irf_file);
                            }));
                            ?>
                            <tr style="background-color: #f5f5f5;">
                                <th width="5%" class="text-center">No</th>
                                <th width="27%">University</th>
                                <th width="19%" class="text-center">LOI</th>
                                <?php if($has_irf_file) : ?>
                                <th width="19%" class="text-center">IRF</th>
                                <?php endif; ?>
                                <th width="15%" class="text-center">Status</th>
                                <th width="15%" class="text-center">Action <?= $has_irf_file ? 'on IRF' : '' ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($submission_results_non_degree)) { ?>
                                <?php $no = 1; foreach ($submission_results_non_degree as $row) { ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <?= $row->university_name ? $row->university_name : '-' ?>
                                        </td>
                                        <td class="<?= empty($row->loi_file) && $is_grantee ? 'text-center' : '' ?>">
                                            <?php if ($row->loi_file) { ?>
                                                <a href="<?= base_url($row->loi_file) ?>" target="_blank" class="file-pill lightbox"><i class="fa fa-file-text-o"></i> <span class="text-ellipsis"><?= basename($row->loi_file) ?></span></a>
                                                <a href="<?= base_url($row->loi_file) ?>" download title="Download LOI" class="btn btn-primary btn-xs"><i class="fa fa-download"></i></a>
                                            <?php } ?>
                                            <?php if($is_grantee && $row->enable_upload_loi) : ?>
                                                <button class="btn btn-xs btn-primary btn-upload-loi <?= $row->status == 'Approved' || $row->status == 'Admitted' ? '' : '' ?>" data-id="<?= $row->id ?>"><?= $row->loi_file ? 'Re-upload' : 'Upload' ?></button>
                                            <?php endif; ?>
                                        </td>
                                        <?php if($has_irf_file) : ?>
                                        <td>
                                            <?php if ($row->irf_file) { ?>
                                                <a href="<?= base_url($row->irf_file) ?>" target="_blank" class="file-pill lightbox"><i class="fa fa-file-text-o"></i> <span class="text-ellipsis"><?= basename($row->irf_file) ?></span></a>
                                                <a href="<?= base_url($row->irf_file) ?>" download title="Download IRF" class="btn btn-primary btn-xs"><i class="fa fa-download"></i></a>
                                            <?php } else { ?>
                                                <span class="text-muted">-</span>
                                            <?php } ?>
                                        </td>
                                        <?php endif; ?>
                                        <td>
                                            <?php 
                                                if ($row->status == 'Approved' || $row->status == 'Admitted') {
                                                    echo "<span class='badge badge-success'>Approved by Grantee</span>";
                                                } else if ($row->status == 'Rejected') {
                                                    echo "<span class='badge badge-danger'>Rejected by Grantee</span>";
                                                } else {
                                                    echo "<span class='badge badge-warning'>Pending Review Grantee</span>";
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row->status == 'Approved' || $row->status == 'Admitted') { ?>
                                                <b class="text-success"><i class="fa fa-check"></i> Approved</b>
                                            <?php } else if ($row->status == 'Rejected') { ?>
                                                <b class="text-danger"><i class="fa fa-times"></i> Rejected</b>
                                            <?php } else { ?>
                                                <?php if (!empty($has_approved_non_degree)) { ?>
                                                    <span class="text-muted">-</span>
                                                <?php } else { ?>
                                                    <button type="button" 
                                                        class="btn btn-xs btn-success btn-approve-non-degree" 
                                                        data-id="<?= $row->id ?>" 
                                                        data-university="<?= htmlspecialchars($row->university_name, ENT_QUOTES, 'UTF-8') ?>">
                                                        <i class="fa fa-check"></i> Approve
                                                    </button>
                                                    <button type="button" 
                                                        class="btn btn-xs btn-danger btn-reject-non-degree" 
                                                        data-id="<?= $row->id ?>" 
                                                        data-university="<?= htmlspecialchars($row->university_name, ENT_QUOTES, 'UTF-8') ?>">
                                                        <i class="fa fa-times"></i> Reject
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php if ($row->status == 'Rejected' && !empty($row->reject_note)) { ?>
                                        <tr style="background-color: #fff9f9;">
                                            <td></td>
                                            <td colspan="5">
                                                <small class="text-danger">
                                                    <b>Rejection Note:</b> <?= nl2br(htmlspecialchars($row->reject_note, ENT_QUOTES, 'UTF-8')) ?>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No submission results available yet.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info" role="alert" style="margin-top: 15px; font-size: 13px;">
                    <i class="fa fa-info-circle"></i> <strong>Note:</strong> Please review your submission results and decide whether to approve or reject. If you reject a submission, a reason/note is required.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reject Non-Degree -->
<div class="modal fade" id="modalRejectNonDegree" tabindex="-1" role="dialog" aria-labelledby="modalRejectNonDegreeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalRejectNonDegreeLabel">Reject Submission</h4>
            </div>
            <form id="formRejectNonDegree">
                <input type="hidden" name="id" id="reject_submission_id" value="">
                <div class="modal-body">
                    <p>Are you sure you want to reject the submission for <strong id="reject_university_name"></strong>?</p>
                    <div id="modalAlertRejectNonDegree" class="alert alert-danger hide"></div>
                    <div class="form-group">
                        <label>Reason / Note for Rejection <span class="text-danger">*</span></label>
                        <textarea name="reject_note" id="reject_note" class="form-control" rows="4" placeholder="Enter reason for rejecting this submission..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="btnSubmitRejectNonDegree">
                        <i class="fa fa-times"></i> Reject Submission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
