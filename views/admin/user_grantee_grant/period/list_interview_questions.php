<div class="col-md-12">
    <?php if ($this->session->flashdata('success')) { ?>
        <div class="alert alert-success"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('success'); ?></div>
        <?php $this->session->set_flashdata('success', false); ?>
    <?php } ?>
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('error'); ?></div>
        <?php $this->session->set_flashdata('error', false); ?>
    <?php } ?>
</div>
<div class="col-md-12">
    <?php if (isset($interview_questions) && $interview_questions) { ?>
        <a class="btn btn-warning btn-sm add-interview-question pull-right" target="_blank" href="<?php echo site_url('panelist/interview/preview_data/' . $this->User_grantee_grant_period_model->id . '/' . $this->User_grantee_grant_period_model->user_grantee_grant_id . '?is_preview=1'); ?>">Preview</a>
    <?php } ?>
</div>

<div class="col-md-12">
    <ul class="nav nav-tabs">
        <li class="<?php echo $this->input->get('sub_pid') == 'interview_questions' || !$this->input->get('sub_pid') ? 'active' : ''; ?>"><a data-toggle="tab" href="#interview-questions">Interview Questions</a></li>
        <li class="<?php echo $this->input->get('sub_pid') == 'evaluation_questions' ? 'active' : ''; ?>"><a data-toggle="tab" href="#evaluation-questions">Interview Evaluation Questions</a></li>
    </ul>

    <div class="tab-content">
        <div id="interview-questions" class="tab-pane <?php echo $this->input->get('sub_pid') == 'interview_questions' || !$this->input->get('sub_pid') ? 'fade in active' : ''; ?>">
            <div class="col-md-12 mt-4 mb-2 p-0">
                <form action="<?php echo site_url('admin/user_grantee_grant/update_evaluation?' . 'sub_pid=interview_questions'); ?>" method="POST">
                    <div class="form-group">
                        <h4>Interview Information</h4>
                        <input type="hidden" name="id" value="<?php echo $period->id; ?>">
                        <textarea class="form-control editor" name="period_inverview_description" placeholder="Description"><?php echo $period->period_inverview_description; ?></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>

            <div class="col-md-12 p-0 mb-2 mt-4">
                <?php if($interview_questions) { ?>
                <div id="frm-action" class="btn-group pull-left mr-2" role="group">
                    <button type="button" class=" btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:;" data-action="copy_period_interview">Copy to Period</a></li>
                    </ul>
                    <input type="hidden" name="action" value="" disabled="disabled">
                </div>
                <?php } ?>
                <a class="btn btn-success btn-sm pull-right add-interview-question" data-toggle="modal" data-target="#mdl_interview_question">Add Question</a>
            </div>

            <div class="col-md-12 p-0">
                <?php if (isset($interview_questions)) { ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="sortable">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" class="chk-all"></th>
                                    <th>#</th>
                                    <th width="50%">Question</th>
                                    <th>Scoring Type</th>
                                    <th>Rate Score</th>
                                    <th>Weighting Score</th>
                                    <th>Status</th>
                                    <th>Allow Comment</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($interview_questions) { ?>
                                    <?php
                                    usort($interview_questions, function ($a, $b) {
                                        return $a->sort - $b->sort;
                                    });
                                    ?>
                                    <?php foreach ($interview_questions as $index => $interview_question) { ?>
                                        <tr class="sortable-row" data-id="<?php echo $interview_question->id; ?>" data-sort="<?php echo $interview_question->sort; ?>">
                                            <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $interview_question->id ?>"></td>
                                            <td width="10px"><?php echo $index + 1; ?></td>
                                            <td>
                                                <?php echo $interview_question->question; ?>
                                            </td>
                                            <td>
                                                <?php echo $interview_question->scoring_type == 1 ? '<span class="badge badge-success">Rating</span>' : '<span class="badge badge-info">Weighting</span>'; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $rate_scores = get_all_db('am_user_grantee_period_interview_rate_scores', ['interview_question_id' => $interview_question->id]);
                                                ?>
                                                <ul style="padding-left: 0px !important;">
                                                    <?php foreach ($rate_scores as $score) { ?>
                                                        <li class="rate_score" style="margin-bottom: 10px;" data-initial_rate="<?php echo $score->initial_rate; ?>" data-initial_score="<?php echo $score->initial_score; ?>">
                                                            Grade : <?php echo $score->initial_rate; ?><br>
                                                            Score : <?php echo $score->initial_score; ?>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </td>
                                            <td>
                                                
                                                <ul style="padding-left: 0px !important;">
                                                    <li style="margin-bottom: 10px;" data-initial_rate="<?php echo $score->initial_rate; ?>" data-initial_score="<?php echo $score->initial_score; ?>">
                                                        Weighting Score : <?php echo $interview_question->weighting_score; ?>
                                                    </li>
                                                    <li style="margin-bottom: 10px;" data-initial_rate="<?php echo $score->initial_rate; ?>" data-initial_score="<?php echo $score->initial_score; ?>">
                                                        Minimum Score : <?php echo $interview_question->min_score; ?>
                                                    </li>
                                                    <li style="margin-bottom: 10px;" data-initial_rate="<?php echo $score->initial_rate; ?>" data-initial_score="<?php echo $score->initial_score; ?>">
                                                        Maximum Score : <?php echo $interview_question->max_score; ?>
                                                    </li>
                                                </ul>         
                                            </td>
                                            <td>
                                                <?php
                                                if ($interview_question->status == 1) {
                                                    echo '<span class="badge badge-success">Active</span>';
                                                } else if ($interview_question->status == 0) {
                                                    echo '<span class="badge">Inactive</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $interview_question->able_to_comment ? 'Yes' : 'No'; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('admin/user_grantee_grant/delete_interview_question/' . $interview_question->id); ?>"
                                                    class="btn btn-danger btn-xs pull-right"
                                                    onclick="return confirm('Are you sure want to delete this ?');"><i class="fa fa-times-circle"></i> Delete</a>
                                                <a href="#"
                                                    data-id="<?php echo $interview_question->id; ?>"
                                                    data-question="<?php echo htmlspecialchars(json_encode($interview_question->question)); ?>"
                                                    data-weighting_score="<?php echo $interview_question->weighting_score; ?>"
                                                    data-min_score="<?php echo $interview_question->min_score; ?>"
                                                    data-max_score="<?php echo $interview_question->max_score; ?>"
                                                    data-status="<?php echo $interview_question->status; ?>"
                                                    data-able_to_comment="<?php echo $interview_question->able_to_comment; ?>"
                                                    data-scoring_type="<?php echo $interview_question->scoring_type; ?>"
                                                    data-toggle="modal" data-target="#mdl_interview_question"
                                                    class="btn btn-primary btn-xs pull-right mr-2 edit-interview-question"><i class="fa fa-edit"></i> Edit</a>
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
        <div id="evaluation-questions" class="tab-pane  <?php echo $this->input->get('sub_pid') == 'evaluation_questions' ? 'fade in active' : ''; ?>">
            <div class="col-md-12 p-0 mb-2 mt-4">
                <form action="<?php echo site_url('admin/user_grantee_grant/update_evaluation?' . 'sub_pid=evaluation_questions'); ?>" method="POST">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="hidden" name="id" value="<?php echo $period->id; ?>">
                        <input type="text" class="form-control" name="period_evaluation_title" value="<?php echo $period->period_evaluation_title; ?>" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control editor" name="period_evaluation_description" placeholder="Description"><?php echo $period->period_evaluation_description; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Template</label>
                        <div style="display: flex;">
                            <div class="evaluation_templates <?php echo $period->period_evaluation_template == 'block' ? 'active' : ''; ?>" data-value="block">
                                <i class="fa fa-file-text"></i>
                            </div>
                            <div class="evaluation_templates <?php echo $period->period_evaluation_template == 'table' || $period->period_evaluation_template == null ? 'active' : ''; ?>" data-value="table">
                                <i class="fa fa-table"></i>
                            </div>
                            <input type="hidden" name="period_evaluation_template" value="<?php echo empty($period->period_evaluation_template) ? 'table' : 'block'; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <select name="period_evaluation_country" class="form-control">
                            <option value="">All Countries</option>
                            <?php
                            $country_list = get_all_db('am_country', [], ['US', 'ID'], 'code');
                            if ($country_list) {
                                foreach ($country_list as $cl) {
                                    $selected = '';
                                    if ($period->period_evaluation_country == $cl->id) {
                                        $selected = 'selected="selected"';
                                    }
                            ?>
                                    <option value="<?php echo $cl->id ?>" <?php echo $selected ?>><?php echo $cl->name ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="alert alert-info mt-4"><i class="fa fa-info-circle"></i> Select which panelist country can fill this position.</div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-md-12 p-0 mt-4 mb-2">
                <?php if($evaluation_questions) { ?>
                <div id="frm-action" class="btn-group pull-left mr-2" role="group">
                    <button type="button" class=" btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:;" data-action="copy_period_interview_evaluation">Copy to Period</a></li>
                    </ul>
                    <input type="hidden" name="action" value="" disabled="disabled">
                </div>
                <?php } ?>
                <a class="btn btn-success btn-sm pull-right add-interview-question" data-toggle="modal" data-target="#mdl_evaluation_question">Add Question</a>
            </div>
            <div class="col-md-12 p-0">
                <?php if (isset($evaluation_questions)) { ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="evaluation_table">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" class="chk-all"></th>
                                    <th>#</th>
                                    <th width="50%">Question</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($evaluation_questions) { ?>
                                    <?php
                                    usort($evaluation_questions, function ($a, $b) {
                                        return $a->sort - $b->sort;
                                    });
                                    ?>
                                    <?php foreach ($evaluation_questions as $index => $evaluation_question) { ?>
                                        <tr class="sortable-row" data-id="<?php echo $evaluation_question->id; ?>" data-sort="<?php echo $evaluation_question->sort; ?>">
                                            <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $evaluation_question->id ?>"></td>
                                            <td width="10px"><?php echo $index + 1; ?></td>
                                            <td>
                                                <?php echo strip_tags($evaluation_question->question); ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-info" style="width: 100px;"><?php echo $evaluation_question->type; ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                if ($evaluation_question->status == 1) {
                                                    echo '<span class="badge badge-success">Active</span>';
                                                } else if ($evaluation_question->status == 0) {
                                                    echo '<span class="badge">Inactive</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo site_url('admin/user_grantee_grant/delete_evaluation_question/' . $evaluation_question->id); ?>"
                                                    class="btn btn-danger btn-xs pull-right"
                                                    onclick="return confirm('Are you sure want to delete this ?');"><i class="fa fa-times-circle"></i> Delete</a>
                                                <a href="#"
                                                    data-id="<?php echo $evaluation_question->id; ?>"
                                                    data-question="<?php echo htmlspecialchars(json_encode($evaluation_question->question)); ?>"
                                                    data-status="<?php echo $evaluation_question->status; ?>"
                                                    data-type="<?php echo $evaluation_question->type; ?>"
                                                    data-multiple="<?php echo $evaluation_question->multiple; ?>"
                                                    data-is_required="<?php echo $evaluation_question->is_required; ?>"
                                                    data-options='<?php echo htmlspecialchars(json_encode($evaluation_question->options, JSON_HEX_APOS | JSON_HEX_QUOT)); ?>'
                                                    data-toggle="modal" data-target="#mdl_evaluation_question"
                                                    class="btn btn-primary btn-xs pull-right mr-2 edit-evaluation-question"><i class="fa fa-edit"></i> Edit</a>
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
</div>

<div class="modal fade" id="mdl_interview_question" tabindex="-1" role="dialog" aria-labelledby="mdl_interview_question" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdl_interview_question_label">Question Interview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" id="form_interview_question" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/save_interview_question?sub_pid=interview_questions') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id">
                        <input type="hidden" name="period_id" value="<?php echo $this->User_grantee_grant_period_model->id; ?>">
                        <div class="form-group">
                            <label>Question</label>
                            <textarea class="form-control editor" id="interview-question" name="question"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Scoring Type</label>
                            <div>
                                <label><input type="radio" class="scoring_type" name="scoring_type" value="0" checked> Weighting</label>
                                <label><input type="radio" class="scoring_type" name="scoring_type" value="1"> Rating</label>
                            </div>
                        </div>
                        <div id="weighting_score_section" class="">
                            <div class="form-group">
                                <label>Weighting Score</label>
                                <input type="number" step="any" class="form-control" name="weighting_score">
                            </div>

                            <div class="form-group">
                                <label>Minimum Score</label>
                                <input type="number" step="any" class="form-control" name="min_score">
                            </div>

                            <div class="form-group">
                                <label>Maximum Score</label>
                                <input type="number" step="any" class="form-control" name="max_score">
                            </div>
                        </div>

                        <div id="rating_score_section" class="row mb-4 hide">
                            <div class="score-rating">

                            </div>
                            <div class="col-md-12">
                                <a class="btn btn-default add-score-rating"><i class="fa fa-plus-circle"></i> Add Rate Score</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="able_to_comment">
                                <input type="checkbox" name="able_to_comment" checked id="able_to_comment" value="1"> Able to provide comments
                            </label>
                            <div class="alert alert-info"><i class="fa fa-info-circle"></i> If selected, the panelist can provide comments.</div>
                        </div>

                        <div class="form-group">
                            <label for="interview_question_status">
                                <input type="checkbox" name="status" checked id="interview_question_status" value="1"> Is active
                            </label>
                            <div class="alert alert-info"><i class="fa fa-info-circle"></i> If selected, the panelist can see this question.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form_interview_question">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_evaluation_question" tabindex="-1" role="dialog" aria-labelledby="mdl_evaluation_question" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdl_evaluation_question_label">Question Evaluation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" id="form_evaluation_question" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/save_evaluation_question?sub_pid=evaluation_questions') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id">
                        <input type="hidden" name="period_id" value="<?php echo $this->User_grantee_grant_period_model->id; ?>">
                        <div class="form-group">
                            <label>Question</label>
                            <textarea class="form-control editor" id="evaluation-question" name="question"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="evaluation_question_status">
                                <input type="checkbox" name="status" checked id="evaluation_question_status" value="1"> Is active
                            </label>
                            <div class="alert alert-info"><i class="fa fa-info-circle"></i> If selected, the panelist can see this question.</div>
                        </div>
                        <?php if ($period->period_evaluation_template == 'block') { ?>
                            <div class="form-group">
                                <label for="evaluation_question_status">Type</label>
                                <select class="form-control" id="question_type" name="type">
                                    <option value="input">Input</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="separator">Separator</option>
                                </select>
                            </div>
                            <div class="form-group is_required">
                                <label for="is_required">
                                    <input type="checkbox" name="is_required" checked id="is_required" value="1"> Required
                                </label>
                            </div>
                            <div class="form-group">
                                <div id="options" class="hide">
                                    <label>Manage Options</label>
                                    <div class="list-options">
                                        <div class="row mb-2">
                                            <div class="col-md-11">
                                                <input type="text" name="options[]" id="select_options_input" class="form-control" placeholder="Enter new option">
                                            </div>
                                            <div class="col-md-1 p-0">
                                                <button class="btn btn-danger remove-option"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <button class="btn btn-outline-secondary" id="add_select_option_button" type="button">Add New Options</button>
                                    </div>

                                    <div class="mt-2">
                                        <label for="multiple">
                                            <input type="checkbox" id="multiple" name="multiple" value="0"> Can select multiple
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form_evaluation_question">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="mdl_select_period_interview">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" id="frm_manage_interview" action="<?php echo site_url('admin/user_grantee_grant/copy_interview/' . $this->User_grantee_grant_period_model->user_grantee_grant_id . '/' . $this->User_grantee_grant_period_model->id); ?>"></form>
                <div class="row">
                    <div class="form-group col-sm-12">

                        <label>Select Grant</label>
                        <select name="copy_period_id" class="form-control select2" id="copy_period_id" form="frm_manage_interview" required>
                            <option value="">--Choose one--</option>
                            <?php
                            foreach ($periods as $key => $per) {
                                $period = $per->fiscal_year;

                                echo "<option value='{$per->id}'>{$period}</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" name="action" form="frm_manage_interview" value="copy_grant">    
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" form="frm_manage_interview" class="btn btn-primary">Copy</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_select_period_interview_evaluation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" id="frm_manage_interview_evaluation" action="<?php echo site_url('admin/user_grantee_grant/copy_interview_evaluation/' . $this->User_grantee_grant_period_model->user_grantee_grant_id . '/' . $this->User_grantee_grant_period_model->id); ?>"></form>
                <div class="row">
                    <div class="form-group col-sm-12">

                        <label>Select Grant</label>
                        <select name="copy_period_id" class="form-control select2" id="copy_period_id" form="frm_manage_interview_evaluation" required>
                            <option value="">--Choose one--</option>
                            <?php
                            foreach ($periods as $key => $per) {
                                $period = $per->fiscal_year;

                                echo "<option value='{$per->id}'>{$period}</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" name="action" form="frm_manage_interview_evaluation" value="copy_grant">    
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" form="frm_manage_interview_evaluation" class="btn btn-primary">Copy</button>
            </div>
        </div>
    </div>
</div>