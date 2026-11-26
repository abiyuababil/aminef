<style>
    .readonly-select {
        pointer-events: none;
        background: #eee;
    }
    .readonly-select-other {
        pointer-events: none;
        background: #eee;
    }
</style>
<?php 

$able_to_input_scores  = false;
$able_to_input_comment = false;

$review_date = $data_review->date ? date('Y-m-d', strtotime($data_review->date)) : null;
$end_date   = $data_review->end_date ? date('Y-m-d', strtotime($data_review->end_date)) : null;
$today       = date('Y-m-d');

$h_minus_2 = $review_date ? date('Y-m-d', strtotime('-2 days', strtotime($review_date))) : null;

// if ($today >= $h_minus_2 && $today < $review_date) {
//     $able_to_input_comment = true;

// } elseif ($today >= $review_date) {
//     $able_to_input_comment = true;
//     $able_to_input_scores  = true;
// }

if ($today >= $h_minus_2 && $today <= $end_date) {
    $able_to_input_comment = true;
    $able_to_input_scores  = true;
}

if ($today >= $start_date && $today <= $end_date) {
    $able_to_input_comment = true;
}

if($data_review->lock_review){
    $able_to_input_scores  = true;
}else{
    $able_to_input_scores  = false;
}

?>
<div class="row">
    <input type="hidden" value="<?= $able_to_input_comment ? 1 : 0 ?>" id="able_to_input_comment">
    <div class="col-md-12 mb-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2><?= $this->session->userdata('role') == 'panellist' ? $user_programs[0]->name : $active_grant[0]->name ?></h2>
                <h3>PRELIMINARY APPLICATION SELECTION SCORING SHEET</h3>
                <hr>
            </div>
        </div>
        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th colspan="2" style="background-color: white !important; border-top: solid #fff; border-left: solid #fff;" width="20%"></th>
                    <th style="background-color: white !important; border-top: solid #fff; border-left: solid #fff;" class="text-right">Date</th>
                    <th width="<?= $is_preview ? '15%' : '10%' ?>" class="text-center"><?= $data_review->date != '' ? date('d M Y', strtotime($data_review->date)) : '-' ?></th>
                </tr>
                <tr>
                    <th style="background-color: white !important;" width="20%">Name Of Reviewer</th>
                    <th colspan="3"><?= $data_review->panellist_name ?></th>
                </tr>
                <tr>
                    <th style="background-color: white !important;" width="20%">Name Of Applicant</th>
                    <th colspan="3"><?= $data_review ? get_full_name($data_review) : '' ?></th>
                </tr>
                <tr>
                    <th style="background-color: white !important;" width="20%">Home Institution</th>
                    <th colspan="3"><?= $data_review->home_institution ?></th>
                </tr>
            </thead>
        </table>
        <form action="" method="post">
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

        <table class="table table-bordered table-stripped">
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
                    if ($review_questions) {
                        usort($review_questions, function($a, $b) {
                            return $a->sort - $b->sort;
                        });
                ?>
                <?php $i=1; foreach($review_questions as $question) { ?>
                    <tr class="scoring-row">
                        <td width="10px;" rowspan="2"><?= $i++; ?></td>
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
                        <td width="200px;" style="vertical-align:middle;" class="text-center">
                            <input 
                                class="total_score"
                                type="number" 
                                style="border: 1px solid #ddd; height: 50px; font-size : 20px; width: 100px; padding: 5px; border: 0px !important; text-align:center;" 
                                value="0" 
                                readonly>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <button type="button" class="btn <?= isset($data_value) && $data_value['note_question'][$question->id] != '' ? 'btn-success' : 'btn-default' ?> btn-sm" data-toggle="collapse" data-target="#comments-<?= $question->id; ?>" style="border-radius: 5px;"><i class="fa fa-pencil"></i> Comments</button>
                                <div id="comments-<?= $question->id; ?>" class="collapse">
                                    <textarea class="editor_panelist autosavepanelist" name="note_question[<?= $question->id ?>]"><?= isset($data_value) ? $data_value['note_question'][$question->id] : '' ?></textarea>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <tr style="font-size: 20px;">
                    <td colspan="3" class="text-right">
                        Total
                    </td>
                    <td id="total" style="font-weight: bold;" class="text-center"></td>
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
            <textarea class="editor_panelist" name="note"><?= $data_value['note'] ?></textarea>
        </div>
        <div class="form-group">
        <!-- <div class="alert bg-info"> -->
            <!-- <b>FINAL DECISSION : </b> -->
            <label>FINAL DECISSION</label>
            <select name="rank_recommendation" id="rank_recommendation" class="form-control autosavepanelist <?= $able_to_input_scores ?  '' : 'readonly-select-other' ?>" <?= $able_to_input_scores ? '' : 'readonly' ?>>
                <option value="">- Select -</option>
                <option <?= $data_review->rank_recommendation == 'HR' ? 'selected' : '' ?> value="HR">Highly Recommended</option>
                <option <?= $data_review->rank_recommendation == 'R' ? 'selected' : '' ?> value="R">Recommended</option>
                <option <?= $data_review->rank_recommendation == 'NR' ? 'selected' : '' ?> value="NR">Not Recommended</option>
            </select>
            <input type="hidden" name="review_id" value="<?= $data_review->id ?>">
        </div>
        <?php if(!$is_preview) { ?>
        <div class="form-group">
            <?php if($able_to_input_scores) { ?>
            <button type="submit" class="btn btn-success pull-right" id="submit-score" name="btn" value="btn-update-score">Submit</button>
            <?php } ?>
            <button type="button" class="btn btn-warning pull-right mr-2" id="btn-save">Save</button>
        </div>
        <?php } ?>
        </form>
    </div>
</div>

