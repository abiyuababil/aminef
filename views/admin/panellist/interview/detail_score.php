<div class="row">
                <div class="col-lg-12">
                    <form action="<?php echo site_url('admin/set_interview/submit_score'); ?>" method="post" id="form-interview">
                    <div class="p-4">
                        <?php if (!empty($period->period_inverview_description)) { ?>
                        <div class="alert alert-info"> 
                            <b><i class="fa fa-info-circle"></i> Information <br></b>
                            <div class="pl-4"><?php echo $period->period_inverview_description; ?> </div>
                        </div>
                        <?php } ?>
                        <table class="table table-bordered table-stripped">
                            <tr>
                                <th style="background-color: white !important;" width="20%">Name Of Interviewer</th>
                                <th colspan="3" style="background-color: #ebebeb !important;">
                                    <?php 
                                        $panellist = get_row_db('am_panellist', ['id' => $interview->panellist_id]);
                                        echo $panellist->name;
                                    ?>
                                </th>
                            </tr>
                            <tr>
                                <th style="background-color: white !important;" width="20%">Name Of Applicant</th>
                                <th colspan="3" style="background-color: #ebebeb !important;"><?= $this->Grantee_ent_model->first_name ?> <?= $this->Grantee_ent_model->middle_name ?>  <?= $this->Grantee_ent_model->last_name ?></th>
                            </tr>
                            <tr>
                                <th style="background-color: white !important;" width="20%">Interview Date</th>
                                <th colspan="3" style="background-color: #ebebeb !important;">
                                    <?php echo $grantee_grant->date_interview; ?>
                                </th>
                            </tr>
                        </table>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Evaluation Criteria</th>
                                    <th class="text-center">Score</th>
                                    <th class="text-center">Total Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $total_score = 0;
                                    if ($interview_questions) {
                                        usort($interview_questions, function($a, $b) {
                                            return $a->sort - $b->sort;
                                        });
                                 ?>
                                    <?php $i=1; foreach($interview_questions as $key => $question) { ?>
                                        <?php 
                                            $question_id = $question->id;
                                            if (isset($interview_scores)) {
                                                $interview_score = array_filter($interview_scores, function($score) use($question_id) {
                                                    return $score->interview_question_id === $question_id;
                                                });
                                                if ($interview_score) {
                                                    $interview_score = array_shift($interview_score);
                                                }
                                            }
                                        ?>
                                        <tr class="scoring-row">
                                            <td width="10px;" rowspan="2"><?php echo $i++; ?></td>
                                            <td><?php echo $question->question; ?></td>
                                            <td width="200px;" class="text-center">
                                            <?php if ($question->scoring_type == 0) { ?>
                                                    <?php $value = isset($interview_score->score) && $interview_score->score ? round($interview_score->score,2) : ""; ?>
                                                    <input 
                                                        name="interview_score[<?php echo $key; ?>][score]"
                                                        class="score"
                                                        type="text"
                                                        pattern="[0-9]+(\.[0-9]{1,2})?" 
                                                        min="<?php echo round($question->min_score, 2); ?>" 
                                                        max="<?php echo round($question->max_score, 2); ?>" 
                                                        required 
                                                        data-weighting_score="<?php echo round($question->weighting_score,2); ?>"
                                                        step="0.01" 
                                                        style="border: 1px solid #ddd; height: 50px; font-size : 20px; width: 100px; padding: 5px; text-align:center; <?= $bgc ?>" 
                                                        <?php echo $disabled_input_scores; ?> 
                                                        value="<?php echo $value; ?>">
                                                    <?php $value = isset($interview_score->weighting_score) && $interview_score->weighting_score ? round($interview_score->weighting_score,2) : round($question->weighting_score,2); ?>
                                                    <input type="hidden" name="interview_score[<?php echo $key; ?>][weighting_score]" value="<?php echo $value; ?>">
                                                    <br>
                                                    <p class="text-primary"><i class="fa fa-info-circle"></i> Between <?php echo round($question->min_score,2); ?> & <?php echo round($question->max_score,2); ?></p>
                                                <?php } else { ?>
                                                    <select class="form-control rate-score" name="interview_score[<?php echo $key; ?>][rate]" required>
                                                        <option value="" data-initial_score="0">Choose Rating</option>
                                                        <?php
                                                            $rate_scores = get_all_db('am_user_grantee_period_interview_rate_scores', ['interview_question_id' => $question->id]);
                                                        ?>
                                                        <?php foreach($rate_scores as $score) { ?>
                                                            <option value="<?php echo $score->initial_rate; ?>" data-initial_score="<?php echo $score->initial_score; ?>" <?php echo $score->initial_rate == $interview_score->rate ? 'selected' : ''; ?>><?php echo $score->initial_rate; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php $value = isset($interview_score->score) && $interview_score->score ? round($interview_score->score,2) : ""; ?>
                                                    <input 
                                                        name="interview_score[<?php echo $key; ?>][score]"
                                                        class="score hide"
                                                        type="text"
                                                        pattern="[0-9]+(\.[0-9]{1,2})?" 
                                                        min="<?php echo round($question->min_score, 2); ?>" 
                                                        max="<?php echo round($question->max_score, 2); ?>" 
                                                        required 
                                                        data-weighting_score="<?php echo round($question->weighting_score,2); ?>"
                                                        step="0.01" 
                                                        style="border: 1px solid #ddd; height: 50px; font-size : 20px; width: 100px; padding: 5px; text-align:center; <?= $bgc ?>" 
                                                        <?php echo $disabled_input_scores; ?> 
                                                        value="<?php echo $value; ?>">
                                                <?php } ?>
                                                <input type="hidden" name="interview_score[<?php echo $key; ?>][interview_question_id]" value="<?php echo $question->id; ?>">
                                                <input type="hidden" name="interview_score[<?php echo $key; ?>][grantee_interview_id]" value="<?php echo $interview_id; ?>">
                                            </td>
                                            <td width="200px;" style="vertical-align:middle;" class="text-center">
                                                <?php $value = isset($interview_score->total_score) && $interview_score->total_score ? round($interview_score->total_score, 2) : 0; ?>
                                                <?php $total_score += $interview_score->total_score ? round($interview_score->total_score, 2) : 0; ?>
                                                <input 
                                                    name="interview_score[<?php echo $key; ?>][total_score]""
                                                    class="total_score"
                                                    type="number" 
                                                    style="border: 1px solid #ddd; height: 50px; font-size : 20px; width: 100px; padding: 5px; border: 0px !important; text-align:center;" 
                                                    value="<?php echo $value; ?>" 
                                                    readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <a class="btn <?php echo isset($interview_score->comments) && !empty($interview_score->comments) ? 'btn-success' : 'btn-default'; ?> btn-sm" data-toggle="collapse" data-target="#comments-<?php echo $question->id; ?>" style="border-radius: 5px;"><i class="fa fa-pencil"></i> Comments</a>
                                                    <div id="comments-<?php echo $question->id; ?>" class="collapse">
                                                        <label>Comments</label>
                                                        <?php $value = isset($interview_score->comments) && $interview_score->comments ? $interview_score->comments : ""; ?>
                                                        <textarea name="interview_score[<?php echo $key; ?>][comments]" class="editor"><?php echo $value; ?></textarea>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr style="font-size: 20px;">
                                        <td colspan="3" class="text-right">
                                            Total
                                        </td>
                                        <td id="total" style="font-weight: bold;" class="text-center"><?php echo $total_score; ?></td>
                                        <input type="hidden" name="score" id="total_score">
                                        <input type="hidden" name="interview_id" value="<?php echo $interview_id; ?>">
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="4">Question is not available</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea class="editor" name="note"><?php echo $interview->note; ?></textarea>
                        </div>
                        <?php 
                            $class = 'bg-warning';
                            switch($interview->rank_recommendation) {
                                case 0 : 
                                    $class = 'bg-danger';
                                    break;
                                case 1 : 
                                    $class = 'bg-info';
                                    break;
                                case 2 : 
                                    $class = 'bg-success';
                                    break;
                            }
                        ?>
                        <div class="form-group">
                            <label>Based on the result of the interview, applicant is</label>
                            <select name="rank_recommendation" id="rank_recommendation" class="form-control" required>
                                <option value="">- Select -</option>
                                <option <?= $interview->rank_recommendation == '2' ? 'selected' : '' ?> value="2">Highly Recommended</option>
                                <option <?= $interview->rank_recommendation == '1' ? 'selected' : '' ?> value="1">Recommended</option>
                                <option <?= $interview->rank_recommendation == '0' ? 'selected' : '' ?> value="0">Not Recommended</option>
                            </select>
                            <input type="hidden" name="review_id" value="<?= $data_review->id ?>">
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <?php $panellist = get_row_db('am_panellist', ['id' => $interview->panellist_id]); ?>

                        <?php if (empty($period->period_evaluation_country) || $panellist->origin_country == $period->period_evaluation_country) { ?>
                            <?php if ($period->period_evaluation_template == 'table' || empty($period->period_evaluation_template)) { ?>
                                <?php if ($evaluation_questions) { ?>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title text-center" style="margin-bottom: 20px;">
                                            <b><?php echo $period->period_evaluation_title; ?></b>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php echo $period->period_evaluation_description; ?>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Evaluation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($evaluation_questions) {
                                                usort($evaluation_questions, function($a, $b) {
                                                    return $a->sort - $b->sort;
                                                });
                                        ?>
                                            <?php $i=1; foreach($evaluation_questions as $key => $question) { ?>
                                                <?php 
                                                    $question_id = $question->id;
                                                    if (isset($evaluation_scores)) {
                                                        $evaluation_score = array_filter($evaluation_scores, function($score) use($question_id) {
                                                            return $score->evaluation_question_id === $question_id;
                                                        });
                                                        if ($evaluation_score) {
                                                            $evaluation_score = array_shift($evaluation_score);
                                                        }
                                                    }
                                                ?>
                                                <tr class="scoring-row">
                                                    <td width="10px;" rowspan="2"><?php echo $i++; ?></td>
                                                    <td><?php echo $question->question; ?></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <a class="btn <?php echo isset($evaluation_score->comment) && !empty($evaluation_score->comment) ? 'btn-success' : 'btn-default'; ?> btn-sm" data-toggle="collapse" data-target="#comments-<?php echo $question->id; ?>" style="border-radius: 5px;"><i class="fa fa-pencil"></i> Comments</a>
                                                            <div id="comments-<?php echo $question->id; ?>" class="collapse">
                                                                <label>Comments</label>
                                                                <?php $value = isset($evaluation_score->comment) && $evaluation_score->comment ? $evaluation_score->comment : ""; ?>
                                                                <textarea name="evaluations[<?php echo $key; ?>][comment]"" class="editor"><?php echo $value; ?></textarea>
                                                                <input type="hidden" name="evaluations[<?php echo $key; ?>][evaluation_question_id]" value="<?php echo $question->id; ?>">
                                                                <input type="hidden" name="evaluations[<?php echo $key; ?>][grantee_interview_id]" value="<?php echo $interview_id; ?>">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="4">Question is not available</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="text-right">
                                    <a href="<?php echo site_url('admin/set_interview/evaluation_pdf/' . $interview_id . '/' . $period->id); ?>" target="_blank" class="btn btn-success mb-4 mr-2" style="margin-top: -5px;">
                                        <span aria-hidden="true">Download</span>
                                    </a>
                                </div>
                                <div class="text-center">
                                    <b style="margin-bottom: 20px; font-size: 14pt;"><?php echo $period->period_evaluation_title; ?><br><?php echo $period->period_evaluation_description; ?></b>
                                </div>
                                <br>
                                <?php
                                    if ($evaluation_questions) {
                                        usort($evaluation_questions, function($a, $b) {
                                            return $a->sort - $b->sort;
                                        });
                                    ?>
                                    <?php $i=1; foreach($evaluation_questions as $key => $question) { ?>
                                        <?php 
                                            $question_id = $question->id;
                                            if (isset($evaluation_scores)) {
                                                $evaluation_score = array_filter($evaluation_scores, function($score) use($question_id) {
                                                    return $score->evaluation_question_id === $question_id;
                                                });
                                                if ($evaluation_score) {
                                                    $evaluation_score = array_shift($evaluation_score);
                                                }
                                            }
                                            $question_type = $question->type;
                                        ?>
                                        <?php $value = isset($evaluation_score->value) && $evaluation_score->value ? $evaluation_score->value : ""; ?>
                                        <?php if (in_array($question_type, ['textarea', null])) {  ?>
                                            <div class="mt-4">
                                                <?php echo $question->question; ?>
                                                <textarea name="evaluations[<?php echo $key; ?>][value]"" class="editor"  <?php echo $question->is_required ? 'required' : ''; ?>><?php echo $value; ?></textarea>
                                                <small class="mb-2 error-field hide"style="color: red !important; font-weight:bold;">This field is required.</small>
                                            </div>
                                        <?php } ?>
                                        <?php if (in_array($question_type, ['input'])) {  ?>
                                            <div class="mt-4">
                                                <?php echo $question->question; ?>
                                                <input name="evaluations[<?php echo $key; ?>][value]" class="form-control" value="<?php echo $value; ?>" <?php echo (bool) $question->is_required ? 'required' : ''; ?>>
                                                <small class="mb-2 error-field hide"style="color: red !important; font-weight:bold;">This field is required.</small>
                                            </div>
                                        <?php } ?>
                                        <?php if (in_array($question_type, ['checkbox'])) {  ?>
                                            <div class="mt-4 checkbox-list <?php echo (bool) $question->is_required ? 'required' : ''; ?>">
                                                <?php echo $question->question; ?>
                                                
                                                <?php
                                                    $options = $question->options;
                                                    if (!empty($options)) {
                                                        $options = json_decode($options, true);
                                                    }

                                                    $multiple = (bool) $question->multiple;

                                                    // Ambil nilai dari $value dan decode hanya sekali
                                                    $values = json_decode($value, true);

                                                    foreach($options as $index => $option) { 
                                                        $checked = '';
                                                        if (is_array($values) && in_array($option, $values)) {
                                                            $checked = 'checked';
                                                        }
                                                ?>
                                                        <label for="checkbox-<?php echo $index . $key; ?>">
                                                            <input <?php echo $checked; ?> type="<?php echo $question_type; ?>" class="<?php echo $multiple ? '' : 'single-checkbox'; ?>" id="checkbox-<?php echo $index . $key; ?>" name="evaluations[<?php echo $key; ?>][value][]"" value="<?php echo $option; ?>"> <?php echo $option; ?>
                                                        </label> 
                                                        <br>
                                                <?php } ?>
                                                <small class="mb-2 error-field hide"style="color: red !important; font-weight:bold;">Please choose one or more options from the checklist before continuing.</small>
                                            </div>
                                        <?php } ?>
                                        <?php if (in_array($question_type, ['separator'])) { ?>
                                            <div class="mt-4">
                                                <?php echo $question->question; ?>
                                            </div>
                                        <?php } ?>
                                        <input type="hidden" name="evaluations[<?php echo $key; ?>][type]" value="<?php echo $question_type; ?>">
                                        <input type="hidden" name="evaluations[<?php echo $key; ?>][evaluation_question_id]" value="<?php echo $question->id; ?>">
                                        <input type="hidden" name="evaluations[<?php echo $key; ?>][grantee_interview_id]" value="<?php echo $interview_id; ?>">
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success pull-right" id="submit-score">Submit</button>
                        </div>
                    </div>
                    <input type="hidden" name="grantee_grant_id" value="<?php echo $grantee_grant->id; ?>">
                    </form>
                </div>
            </div>