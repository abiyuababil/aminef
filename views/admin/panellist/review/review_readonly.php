<style>
    .readonly-score {
        border: 0px !important;
        font-size: 20px;
        font-weight: bold;
        display: inline-block;
        width: 100px;
        text-align: center;
    }
    .grade-label {
        font-weight: bold;
    }
    .review-questions td { vertical-align: middle; }
</style>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3>PRELIMINARY APPLICATION SELECTION SCORING SHEET</h3>
                <hr>
            </div>
        </div>
        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th style="background-color: white !important; border-top: solid #fff; border-left: solid #fff;" width="20%">Name Of Reviewer</th>
                    <th colspan="3"><?php echo isset($data_review->panellist_name) ? $data_review->panellist_name : '' ?></th>
                </tr>
                <tr>
                    <th style="background-color: white !important;" width="20%">Name Of Applicant</th>
                    <th colspan="3"><?php echo isset($data_review) ? get_full_name($data_review) : '' ?></th>
                </tr>
                <tr>
                    <th style="background-color: white !important;" width="20%">Home Institution</th>
                    <th colspan="3"><?php echo isset($data_review->home_institution) ? $data_review->home_institution : '' ?></th>
                </tr>
            </thead>
        </table>
        <div class="table-responsive">
            <table class="table table-bordered table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Eligibility Requirement</th>
                        <th>Meets Requirement</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if ($review_questions_eligibility) {
                            usort($review_questions_eligibility, function($a, $b) {
                                return $a->sort - $b->sort;
                            });
                    ?>
                        <?php $i=1; foreach($review_questions_eligibility as $question) { ?>
                            <tr class="scoring-row">
                                <td width="10px;"><?= $i++; ?></td>
                                <td><?= $question->question; ?></td>
                                <td width="200px;">
                                    <select class="form-control select_grade autosavepanelist <?= $able_to_input_scores ? '' : 'readonly-select-other' ?>" name="question[<?= $question->id ?>]" required <?= $able_to_input_scores ? '' : 'readonly' ?>>
                                        <option value="0">-- Select --</option>
                                        <?php if($question->scoring_type_review == 0) { ?>
                                        <?php 
                                            $grade_scores = get_all_db('am_user_grantee_period_review_grade_scores', ['review_question_id' => $question->id]);
                                            foreach($grade_scores as $grade_score) { 
                                            $selected = '';
                                            if($data_value['question'][$question->id] == $grade_score->initial_score) {
                                                $selected = 'selected';
                                            }
                                        ?>
                                        <option <?= $selected ?> value="<?= $grade_score->initial_score; ?>"><?= $grade_score->initial_grade; ?></option>
                                        <?php } ?>
                                        <?php } else {?>
                                            <option <?= $data_value['question'][$question->id] == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                            <option <?= $data_value['question'][$question->id] == 'No' ? 'selected' : '' ?> value="No">No</option>
                                        <?php } ?>
                                    </select>
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
        </div>
        <div class="table-responsive">
        <table class="table table-bordered table-stripped review-questions">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Selection Criteria</th>
                    <th>Grade</th>
                    <th class="text-center">Score</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_score = 0;
                if (!empty($review_questions)) {
                    usort($review_questions, function($a, $b) { return $a->sort - $b->sort; });
                    $i = 1;
                    foreach ($review_questions as $question) {
                        $selected = isset($data_value['question'][$question->id]) ? $data_value['question'][$question->id] : '';
                        $grade_scores = get_all_db('am_user_grantee_period_review_grade_scores', ['review_question_id' => $question->id]);
                        $grade_label = '-';
                        $grade_value = 0;
                        foreach ($grade_scores as $gs) {
                            $selected_str = (string)$selected;
                            $match = false;
                            if (isset($gs->initial_score) && (string)$gs->initial_score === $selected_str) {
                                $match = true;
                            }
                            if (!$match && isset($gs->id) && (string)$gs->id === $selected_str) {
                                $match = true;
                            }
                            if (!$match && isset($gs->initial_grade) && (string)$gs->initial_grade === $selected_str) {
                                $match = true;
                            }
                            if ($match) {
                                $grade_label = $gs->initial_grade;
                                $grade_value = is_numeric($gs->initial_score) ? floatval($gs->initial_score) : 0;
                                break;
                            }
                        }
                        $total_score += $grade_value;
                        $score_display = number_format($grade_value, 2, '.', ',');
                        ?>
                        <tr>
                            <td width="10px;" rowspan="2"><?php echo $i++; ?></td>
                            <td><?php echo $question->question; ?></td>
                            <td width="200px;"><span class="grade-label"><?php echo $grade_label; ?></span></td>
                            <td width="200px;" class="text-center"><span class="readonly-score"><?php echo $score_display; ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div><strong>Comments:</strong></div>
                                <div><?php echo isset($data_value['note_question'][$question->id]) && $data_value['note_question'][$question->id] !== '' ? $data_value['note_question'][$question->id] : '-' ?></div>
                            </td>
                        </tr>
                    <?php }
                }
                ?>
                <tr style="font-size: 20px;">
                    <td colspan="3" class="text-right">Total</td>
                    <td id="total" style="font-weight: bold; text-align:center"><?php echo number_format($total_score, 2, '.', ','); ?></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class="form-group">
            <label>Comment</label>
            <div><?php echo isset($data_value['note']) && $data_value['note'] !== '' ? $data_value['note'] : '-' ?></div>
        </div>
        <div class="form-group">
            <label>FINAL DECISION</label>
            <div>
                <?php
                $final_label = '-';
                if (isset($data_review->rank_recommendation) && $data_review->rank_recommendation !== '') {
                    $final = $data_review->rank_recommendation;
                    $full_map = [
                        HEIGHLY_RECOMMENDED => 'Highly Recommended',
                        RECOMMENDED => 'Recommended',
                        NOT_RECOMMENDED => 'Not Recommended',
                        'HR' => 'Highly Recommended',
                        'R'  => 'Recommended',
                        'NR' => 'Not Recommended'
                    ];
                    if (is_numeric($final)) {
                        $final_int = (int)$final;
                        $final_label = isset($full_map[$final_int]) ? $full_map[$final_int] : (string)$final;
                    } else {
                        $final_label = isset($full_map[$final]) ? $full_map[$final] : (string)$final;
                    }
                }
                echo html_escape($final_label);
                ?>
            </div>
        </div>
    </div>
</div>
