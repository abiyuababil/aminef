<div class="col-md-12">
    <?php if ($this->session->flashdata('submission_ongoing_success')) { ?>
        <div class="alert alert-success"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('submission_ongoing_success'); ?></div>
        <?php $this->session->set_flashdata('submission_ongoing_success', false); ?>
    <?php } ?>
    <?php if ($this->session->flashdata('submission_ongoing_error')) { ?>
        <div class="alert alert-danger"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('submission_ongoing_error'); ?></div>
        <?php $this->session->set_flashdata('submission_ongoing_error', false); ?>
    <?php } ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6" style="display: flex;">
                        <?php if (isset($submission_ongoing)) { ?>
                        <div class="form-group mr-2">
                            <div id="frm-action" class="btn-group" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:;" data-action="delete_submission_ongoing">Delete</a></li>
                                    <li><a href="javascript:;" data-action="copy_submission_ongoing">Copy to Grant</a></li>
                                </ul>
                                <input type="hidden" name="action" value="" disabled="disabled">
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-2">
                        <a class="btn btn-success btn-sm pull-right add-submission-ongoing" data-toggle="modal" data-target="#mdl_submission_ongoing">Add New</a>
                    </div>
                </div>
                <?php if (isset($submission_ongoing)) { ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="submission_ongoing_table">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" class="chk-all"></th>
                                    <th>#</th>
                                    <th width="50%">Semester</th>
                                    <th>Type of Document</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($submission_ongoing) { ?>
                                    <?php
                                    usort($submission_ongoing, function ($a, $b) {
                                        return $a->sort - $b->sort;
                                    });
                                    ?>
                                    <?php foreach ($submission_ongoing as $index => $submission) { ?>
                                        <tr class="sortable-row" data-id="<?php echo $submission->id; ?>" data-sort="<?php echo $submission->sort; ?>">
                                            <td><input type="checkbox" form="frm_copy_submission_ongoing" class="chk-row" name="ids[]" value="<?php echo $submission->id ?>"></td>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <?php echo $submission->semester; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $type_of_document = get_all_db('am_type_of_document_submission_ongoing', ['submission_ongoing_id' => $submission->id]);
                                                ?>
                                                <ul style="padding-left: 0px !important;">
                                                    <?php foreach ($type_of_document as $document) { ?>
                                                        <li style="margin-bottom: 10px;" data-type_of_document="<?php echo $document->type_of_document; ?>" data-deadline="<?php echo $document->deadline; ?>">
                                                            Type of Document : <?php echo $document->type_of_document; ?><br>
                                                            Deadline : <?php echo $document->deadline; ?>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </td>
                                            <td>
                                                <a href="<?php echo site_url('admin/user_grantee_grant/delete_submission_ongoing/' . $submission->id . '/' . $grant_id . '/' . $period_id); ?>"
                                                    class="btn btn-danger btn-xs pull-right"
                                                    onclick="return confirm('Are you sure want to delete this ?');"><i class="fa fa-times-circle"></i> Delete</a>
                                                <a href="#"
                                                    data-id="<?php echo $submission->id; ?>"
                                                    data-semester="<?php echo htmlspecialchars(json_encode($submission->semester)); ?>"
                                                    data-toggle="modal" data-target="#mdl_submission_ongoing"
                                                    class="btn btn-primary btn-xs pull-right mr-2 edit-submission-ongoing"><i class="fa fa-edit"></i> Edit</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="7">Submission Ongoing is not available</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_submission_ongoing" tabindex="-1" role="dialog" aria-labelledby="mdl_submission_ongoing" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdl_submission_ongoing_label">Submission Ongoing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" id="form_submission_ongoing" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/save_submission_ongoing') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <input type="hidden" name="period_id" value="<?php echo $this->User_grantee_grant_period_model->id; ?>">
                    <div class="form-group">
                        <label>Semester</label>
                        <textarea class="form-control editor" id="semester" name="semester"></textarea>
                    </div>

                    <div class="row">
                        <div class="initial_submission_ongoing">

                        </div>
                        <div class="col-md-12">
                            <a class="btn btn-default add-type-document"><i class="fa fa-plus-circle"></i> Add Type Of Document</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form_submission_ongoing">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="mdl_select_grant_submission_ongoing">
    <form id="frm_copy_submission_ongoing" method="GET"></form>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input name="user_id" type="hidden" value="<?= $this->User_model->id; ?>"/>
                        <input name="country_id" type="hidden" value="<?= $country_id; ?>"/>
                        <input name="program_id" type="hidden" id="ex_program_id"/>

                        <label>Select Grant</label>
                        <select name="copy_submission_ongoing_id" class="form-control select2" id="copy_submission_ongoing_id" form="frm_copy_submission_ongoing">
                            <option value="">--Choose one--</option>
                            <?php foreach ($grants as $key => $prgm) { ?>
                                <option value='<?= $prgm->id ?>'><?= $prgm->name ?> <?= get_active_country(true) == AMERICAN_DATABASE ? '- '.$prgm->year : '' ?></option>";
                            <?php } ?>
                        </select>
                        <input type="hidden" name="action" form="frm_copy_submission_ongoing" value="copy_submission_ongoing">
                    </div>
                    <div class="form-group col-sm-12 select-period-sub-ongoing-section hide">
                        <label>Select Period</label>
                        <select name="period_id_submission_ongoing" class="form-control select2" id="period_id_submission_ongoing" form="frm_copy_submission_ongoing">
                            <option value="">-- Select Period --</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" form="frm_copy_submission_ongoing" class="btn btn-primary">Copy</button>
            </div>
        </div>
    </div>
</div>