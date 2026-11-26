<div class="col-md-12">
    <?php if ($this->session->flashdata('question_review_success')) { ?>
        <div class="alert alert-success"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('question_review_success'); ?></div>
        <?php $this->session->set_flashdata('question_review_success', false); ?>
    <?php } ?>
    <?php if ($this->session->flashdata('question_review_error')) { ?>
        <div class="alert alert-danger"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('question_review_error'); ?></div>
        <?php $this->session->set_flashdata('question_review_error', false); ?>
    <?php } ?>
</div>
<div class="col-md-12">
    <?php if (isset($review_questions) && $review_questions) { ?>
        <a class="btn btn-warning btn-sm pull-right add-interview-question" target="_blank" href="<?php echo site_url('panelist/review/preview_data/' . $this->User_grantee_grant_period_model->id . '/' . $this->User_grantee_grant_period_model->user_grantee_grant_id . '?is_preview=1'); ?>">Preview</a>
    <?php } ?>
</div>
<div class="col-md-12 mb-2">
    <ul class="nav nav-tabs">
        <li class="<?php echo $this->input->get('sub_pid') == 'review_questions_grade' || !$this->input->get('sub_pid') ? 'active' : ''; ?>"><a data-toggle="tab" href="#grade-questions">Grade Questions</a></li>
        <li class="<?php echo $this->input->get('sub_pid') == 'eligibility' ? 'active' : ''; ?>"><a data-toggle="tab" href="#eligibility-questions">Eligibility Questions</a></li>
    </ul>
</div>

<div class="tab-content">
    <div id="grade-questions" class="tab-pane <?php echo $this->input->get('sub_pid') == 'review_questions_grade' || !$this->input->get('sub_pid') ? 'fade in active' : ''; ?>">
        <div class="col-md-12">
            <?php if($review_questions) { ?>
            <div id="frm-action" class="btn-group pull-left mr-2" role="group">
                <button type="button" class=" btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:;" data-action="copy_period">Copy to Period</a></li>
                </ul>
                <input type="hidden" name="action" value="" disabled="disabled">
            </div>
            <?php } ?>
            <a class="btn btn-success btn-sm pull-right add-review-question mb-3" data-toggle="modal" data-section="grade" data-target="#mdl_review_question">Add Questions</a>
            <?php if (isset($review_questions)) { ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="review_table">
                        <thead>
                            <tr>
                                <th width="30"><input type="checkbox" class="chk-all"></th>
                                <th>#</th>
                                <th width="50%">Question</th>
                                <th>Initial Grade and Score</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($review_questions) { ?>
                                <?php
                                usort($review_questions, function ($a, $b) {
                                    return $a->sort - $b->sort;
                                });
                                ?>
                                <?php foreach ($review_questions as $index => $review_question) { ?>
                                    <tr class="sortable-row" data-id="<?php echo $review_question->id; ?>" data-sort="<?php echo $review_question->sort; ?>">
                                        <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $review_question->id ?>"></td>
                                        <td><?php echo $index + 1; ?></td>
                                        <td>
                                            <?php echo $review_question->question; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $grade_scores = get_all_db('am_user_grantee_period_review_grade_scores', ['review_question_id' => $review_question->id]);
                                            ?>
                                            <ul style="padding-left: 0px !important;">
                                                <?php foreach ($grade_scores as $score) { ?>
                                                    <li style="margin-bottom: 10px;" data-initial_grade="<?php echo $score->initial_grade; ?>" data-initial_score="<?php echo $score->initial_score; ?>">
                                                        Grade : <?php echo $score->initial_grade; ?><br>
                                                        Score : <?php echo $score->initial_score; ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <?php
                                            if ($review_question->status == 1) {
                                                echo '<span class="badge badge-success">Active</span>';
                                            } else if ($review_question->status == 0) {
                                                echo '<span class="badge">Inactive</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('admin/user_grantee_grant/delete_review_question/' . $review_question->id); ?>"
                                                class="btn btn-danger btn-xs pull-right"
                                                onclick="return confirm('Are you sure want to delete this ?');"><i class="fa fa-times-circle"></i> Delete</a>
                                            <a href="#"
                                                data-id="<?php echo $review_question->id; ?>"
                                                data-question="<?php echo htmlspecialchars(json_encode($review_question->question)); ?>"
                                                data-status="<?php echo $review_question->status; ?>"
                                                data-toggle="modal" data-target="#mdl_review_question"
                                                data-section="grade"
                                                class="btn btn-primary btn-xs pull-right mr-2 edit-review-question"><i class="fa fa-edit"></i> Edit</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="7">Questions is not available</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>

    <div id="eligibility-questions" class="tab-pane <?php echo $this->input->get('sub_pid') == 'eligibility' ? 'fade in active' : ''; ?>">
        <div class="col-md-12">
            <?php if($review_egibility_questions) { ?>
            <div id="frm-action" class="btn-group pull-left mr-2" role="group">
                <button type="button" class=" btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:;" data-action="copy_period">Copy to Period</a></li>
                </ul>
                <input type="hidden" name="action" value="" disabled="disabled">
            </div>
            <?php } ?>
            <a class="btn btn-success btn-sm pull-right add-review-question mb-3" data-toggle="modal" data-section="eligibility" data-target="#mdl_review_question">Add Questions</a>
            <?php if (isset($review_egibility_questions)) { ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="review_table">
                        <thead>
                            <tr>
                                <th width="30"><input type="checkbox" class="chk-all"></th>
                                <th>#</th>
                                <th width="50%">Question</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($review_egibility_questions) { ?>
                                <?php
                                usort($review_egibility_questions, function ($a, $b) {
                                    return $a->sort - $b->sort;
                                });
                                ?>
                                <?php foreach ($review_egibility_questions as $index => $review_question) { ?>
                                    <tr class="sortable-row" data-id="<?php echo $review_question->id; ?>" data-sort="<?php echo $review_question->sort; ?>">
                                        <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $review_question->id ?>"></td>
                                        <td><?php echo $index + 1; ?></td>
                                        <td>
                                            <?php echo $review_question->question; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($review_question->status == 1) {
                                                echo '<span class="badge badge-success">Active</span>';
                                            } else if ($review_question->status == 0) {
                                                echo '<span class="badge">Inactive</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('admin/user_grantee_grant/delete_review_question/' . $review_question->id); ?>"
                                                class="btn btn-danger btn-xs pull-right"
                                                onclick="return confirm('Are you sure want to delete this ?');"><i class="fa fa-times-circle"></i> Delete</a>
                                            <a href="#"
                                                data-id="<?php echo $review_question->id; ?>"
                                                data-question="<?php echo htmlspecialchars(json_encode($review_question->question)); ?>"
                                                data-status="<?php echo $review_question->status; ?>"
                                                data-toggle="modal" data-target="#mdl_review_question"
                                                data-section="eligibility"
                                                class="btn btn-primary btn-xs pull-right mr-2 edit-review-question"><i class="fa fa-edit"></i> Edit</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="7">Questions is not available</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_review_question" tabindex="-1" role="dialog" aria-labelledby="mdl_review_question" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdl_review_question_label">Question Reviews</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" id="form_review_question" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/save_review_question') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <input type="hidden" name="period_id" value="<?php echo $this->User_grantee_grant_period_model->id; ?>">
                    <input type="hidden" name="scoring_type_review" id="scoring_type_review">
                    <div class="form-group">
                        <label>Question</label>
                        <textarea class="form-control editor" id="review-question" name="question"></textarea>
                    </div>
                        

                    <div id="grade_score_section" class="row">
                        <div class="initial_scores">

                        </div>
                        <div class="col-md-12">
                            <a class="btn btn-default add-grade-score"><i class="fa fa-plus-circle"></i> Add Grade Score</a>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <label for="review_question_status"><input type="checkbox" name="status" checked id="review_question_status" value="1"> Is active </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form_review_question">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_select_period">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" id="frm_manage" action="<?php echo site_url('admin/user_grantee_grant/copy_review/' . $this->User_grantee_grant_period_model->user_grantee_grant_id . '/' . $this->User_grantee_grant_period_model->id); ?>"></form>
                <div class="row">
                    <div class="form-group col-sm-12">

                        <label>Select Grant</label>
                        <select name="copy_period_id" class="form-control select2" id="copy_period_id" form="frm_manage" required>
                            <option value="">--Choose one--</option>
                            <?php
                            foreach ($periods as $key => $per) {
                                $period = $per->fiscal_year;

                                echo "<option value='{$per->id}'>{$period}</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" name="action" form="frm_manage" value="copy_grant">    
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" form="frm_manage" class="btn btn-primary">Copy</button>
            </div>
        </div>
    </div>
</div>