<style>
    .containt {
        margin: 0px auto 30px auto;
    }

    .progressbar {
        counter-reset: step;
        margin: 0px;
        padding: 0px;
    }

    .progressbar li {
        display: inline-block;
        list-style-type: none;
        width: 25%;
        /* float: left; */
        font-size: 12px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        color: #7d7d7d;
    }

    .progressbar li {
        width: 30px;
        height: 30px;
        line-height: 30px;
        background-color: #b5b5b5;
        /* display: block; */
        text-align: center;
        margin: auto 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .progressbar li a {
        color: white !important;
        text-decoration: none;
    }

    .progressbar li:after {
        width: 100%;
        height: 2px;
        content: '';
        position: absolute;
        background-color: #7d7d7d;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child:after {
        content: none;
    }

    .progressbar li.active {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.done {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.active+li:after {
        background-color: #55b776;
    }

    .btn_step {
        width: 150px;
    }

    .next {
        float: right;
    }

    .select2 {
        width:100% !important;
    }

    .display {
        display: none;
    }

    .select2-selection.select2-selection--single {
        border-radius: 0px !important;
        width: 100% !important;
        height: 29px !important;
        padding-top: 2px !important;
        border: 1px solid #ccc;
        border-top-color: rgb(204, 204, 204);
        border-right-color: rgb(204, 204, 204);
        border-bottom-color: rgb(204, 204, 204);
        border-left-color: rgb(204, 204, 204);
    }
</style>

<?php
date_default_timezone_set('Asia/Jakarta');
$pid = $this->input->get('pid');
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}

$able_to_input_scores = $able_to_input_comment = $able_to_save = false;
$disabled_input_scores = $bgc = '';
$show_button = true;
if (!empty($grantee_grant->date_interview)) {
    $date_interview = new DateTime($grantee_grant->date_interview);
    $current_date = new DateTime(); 
                    
    $date_interview_formatted = $date_interview->format('Y-m-d');
    $current_date_formatted = $current_date->format('Y-m-d');
                    
    $able_button = $current_date_formatted <= $date_interview_formatted;

    $interval_days = (int)$current_date->diff($date_interview)->format('%r%a');
    if ($interval_days < 3) {
        $able_to_input_comment = $able_to_save = true;
    }

    
    if ($current_date_formatted === $date_interview_formatted) {
        // if ($current_date >= $date_interview) {
        //     $able_to_input_scores = true;
        // }
        if (date('Y-m-d', strtotime($grantee_grant->date_interview)) >= date('Y-m-d')) {
            $able_to_input_scores = $able_to_input_comment = true;
        }
    }
    
    if (!$able_to_input_scores) {
        $disabled_input_scores = 'disabled';
        $bgc = 'background-color:#eee';
        $show_button = !$able_button ? true : false;
    }
    
}

if($interview->lock_interview) {
    $disabled_input_scores = '';
    $bgc = 'background-color:#fff';
    $show_button = true;
}else{
    $disabled_input_scores = 'disabled';
    $bgc = 'background-color:#eee';
    $show_button = true;

}



?>

<input type="hidden" value="<?= $this->Grantee_ent_model->id ?>" id="grantee_id">
<input type="hidden" value="<?= $grantee_grant_id ?>" id="grantee_grant_id">
<input type="hidden" value="<?= $able_to_input_comment ? 1 : 0 ?>" id="able_to_input_comment">
<div class="row">
    <div class="col-lg-12 mt-4 header-interview">
        <table class="table table-bordered table-stripped">
            <tr>
                <th style="background-color: white !important;" width="20%">Name Of Interviewer</th>
                <th colspan="3" style="background-color: #ebebeb !important;"><?php echo $this->session->userdata('name'); ?></th>
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
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php $this->session->set_flashdata('success', false); ?>
        <?php } ?>

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
            <?php $this->session->set_flashdata('error', false); ?>
        <?php } ?>
        <ul class="nav nav-pills" style="border-bottom: 1px solid #ddd;">
            <?php if (!$_GET['is_preview']) { ?>
                <li class="active">
                    <a data-toggle="tab" href="#form-application" aria-expanded="true">
                        <?php echo $view_type == 'form_application' ? 'Form Application' : 'PDF Application'; ?>
                    </a>
                </li>
            <?php } ?>
            <li class="<?php echo isset($_GET['is_preview']) ? 'active':''; ?>"><a data-toggle="tab" href="#interview" aria-expanded="true">Interview</a></li>
        </ul>
    </div>

    <div class="tab-content" style="margin-bottom: 100px;">
        <div id="interview" class="tab-pane fade <?php echo isset($_GET['is_preview']) ? 'active in' : ''; ?>"">
            <div class="row">
                <div class="col-lg-12">
                    
                    <form action="<?php echo site_url('panellist/interview/submit_score'); ?>" method="post" id="form-interview">
                    <div class="p-4">
                        <?php if (!empty($period->period_inverview_description)) { ?>
                        <div class="alert alert-info"> 
                            <b><i class="fa fa-info-circle"></i> Information <br></b>
                            <div class="pl-4"><?php echo $period->period_inverview_description; ?> </div>
                        </div>
                        <?php } ?>
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
                                                        class="score autosavepanelist"
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
                                                    <select class="form-control rate-score rate-score autosavepanelist" name="interview_score[<?php echo $key; ?>][rate]" required <?php echo $disabled_input_scores ?> <?php echo $disabled_input_scores == 'disabled' ? 'style="pointer-events: none;"' : ''; ?> >
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
                                                        class="score autosavepanelist hide"
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
                                                <?php $value = isset($interview_score->total_score) && $interview_score->total_score ? round($interview_score->total_score,2) : 0; ?>
                                                <input 
                                                    name="interview_score[<?php echo $key; ?>][total_score]""
                                                    class="total_score"
                                                    type="text" 
                                                    style="border: 1px solid #ddd; height: 50px; font-size : 20px; width: 100px; padding: 5px; border: 0px !important; text-align:center; cursor: default; background-color: #f9f9f9;" 
                                                    value="<?php echo $value; ?>" 
                                                    <?php echo $disabled_input_scores; ?> 
                                                    readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <a class="btn <?php echo isset($interview_score->comments) && !empty($interview_score->comments) ? 'btn-success' : 'btn-default'; ?> btn-sm" data-toggle="collapse" data-target="#comments-<?php echo $question->id; ?>" style="border-radius: 5px;"><i class="fa fa-pencil"></i> Comments</a>
                                                    <div id="comments-<?php echo $question->id; ?>" class="collapse">
                                                        <label>Comments</label>
                                                        <?php $value = isset($interview_score->comments) && $interview_score->comments ? $interview_score->comments : ""; ?>
                                                        <textarea name="interview_score[<?php echo $key; ?>][comments]"" class="editor autosavepanelist"><?php echo $value; ?></textarea>
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
                                        <input type="hidden" name="score" id="total_score" <?php echo $disabled_input_scores; ?> >
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
                            <textarea class="editor autosavepanelist" name="note"><?php echo $interview->note; ?></textarea>
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
                            <select name="rank_recommendation" id="rank_recommendation" class="form-control autosavepanelist" <?php echo $disabled_input_scores; ?> <?= $disabled_input_scores == 'disabled' ? 'style="pointer-events: none;"' : '' ?>>
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
                        <?php $panellist = get_row_db('am_panellist', ['id' => $this->session->userdata('panellist_id')]); ?>

                        <?php if ((empty($period->period_evaluation_country) || isset($_GET['is_preview'])) || $panellist->origin_country == $period->period_evaluation_country) { ?>
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
                                                                <textarea name="evaluations[<?php echo $key; ?>][comment]" class="editor autosavepanelist"><?php echo $value; ?></textarea>
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
                                                <textarea name="evaluations[<?php echo $key; ?>][value]" class="editor autosavepanelist" <?php echo (bool) $question->is_required ? 'required' : ''; ?>><?php echo $value; ?></textarea>
                                            </div>
                                        <?php } ?>
                                        <?php if (in_array($question_type, ['input'])) {  ?>
                                            <div class="mt-4">
                                                <?php echo $question->question; ?>
                                                <input name="evaluations[<?php echo $key; ?>][value]" class="form-control autosavepanelist" value="<?php echo $value; ?>"  <?php echo (bool) $question->is_required ? 'required' : ''; ?>>
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
                                                            <input <?php echo $checked; ?> type="<?php echo $question_type; ?>" class="autosavepanelist <?php echo $multiple ? '' : 'single-checkbox'; ?>" id="checkbox-<?php echo $index . $key; ?>" name="evaluations[<?php echo $key; ?>][value][]" value="<?php echo $option; ?>"> <?php echo $option; ?>
                                                        </label> <br>
                                                <?php } ?>
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
                        
                        <?php //if(!$interview->lock_interview) { ?>
                        <div class="form-group mt-4">
                            <?php if($show_button) { ?>
                                <button type="submit" class="btn btn-success pull-right" id="submit-score" <?php echo isset($_GET['is_preview']) ? 'disabled' : ''; ?>>Submit</button> 
                            <?php } ?>
                            <?php if($able_to_save) { ?>
                            <button type="button" class="btn btn-warning pull-right mr-2" id="btn-save">Save</button>
                            <?php } ?>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php foreach ($submission as $key => $value) { ?>
                <div id="form-application" class="tab-pane fade <?php echo !isset($_GET['is_preview']) ? 'active in' : ''; ?>">
                    <?php if ($view_type == 'form_application') { ?>
                    <div>
                        <div class="col-lg-12 mt-4">
                            <div class="tabs">
                                <ul>
                                    <?php
                                    foreach ($value['grants_step'] as $index => $step): ?>
                                            <li>
                                                <a aria-expanded="true" data-toggle="tab" href="#<?= $key ?>_step_<?= $step->id; ?>" aria-expanded="true"><?= $step->label ?></a>
                                            </li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="row">
                                    <div class="col col-lg-12">
                                        <div class="tab-content">
                                            <?php foreach ($value['grants_step'] as $index => $step):
                                                    $index_of_country = $this->session->userdata('index_of_country') ? ($this->session->userdata('index_of_country')) + 1 : 1;
                                                    $this->session->set_userdata('index_of_country', $index_of_country);
                                                    $index_of_state_of_study = $this->session->userdata('index_of_state_of_study') ? ($this->session->userdata('index_of_state_of_study')) + 1 : 1;
                                                    $this->session->set_userdata('index_of_state_of_study', $index_of_state_of_study);
                                                    ?>
                                                    <div id="<?= $key ?>_step_<?= $step->id; ?>" class="tab-pane fade <?php if ($index == 0) {
                                                            echo 'active in first_tab';
                                                        } ?>">
                                                        <div class="panel panel-default">
                                                            <?php if ($step->note_letter_of_reference) { ?>
                                                            <?= $step->note_letter_of_reference ?>
                                                        <?php } ?>
                                                        <div class="panel-body">
                                                           
                                                            <!-- ENDPRE DEPATURE ORIENTATION -->
                                                            <?php $file = 0; ?>
                                                            <?php $row = "<div class='row form-group'>"; ?>
                                                            <?php $exitrow = "</div>"; ?>
                                                            <?php 
                                                                foreach ($value['data'][$step->id] as $key_fields => $custom_fields) { 
                                                                if($custom_fields->type == 'radio group'){
                                                                    $custom_fields->user_grantee_id = $this->Grantee_ent_model->id;
                                                                    $custom_fields->grantee_grant_id = $grantee_grant_id;
                                                                }
                                                            ?>
                                                                    <!-- template for others instead file template -->
                                                                    <?php if ($custom_fields->type != 'file'): ?>
                                                                        <div class="wrap-file-<?= $custom_fields->id ?>"> 
                                                                            <div class="row form-group">
                                                                                <?php if ($custom_fields->type == 'separator'): ?>
                                                                                    <div class="col-lg-12 text-left font-weight-bold">
                                                                                        <!-- <b><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $custom_fields->name); ?></b> -->
                                                                                        <b><?= url_text($custom_fields->name) ?></b>
                                                                                        <?php if ($custom_fields->description_file != '') { ?>
                                                                                            <div class="mt-2">
                                                                                                <span style="font-size: 12px !important; margin-left: 15px;"><?= $custom_fields->description_file ?></span>
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                <?php else: ?>
                                                                                    <div class="<?= $custom_fields->type == 'element group' ? 'col-md-12' : 'col-md-4' ?> text-left font-weight-bold">
                                                                                        <?php if($custom_fields->type == 'element group') { ?>
                                                                                            <b><?= url_text($custom_fields->name); ?> <?= in_array($custom_fields->type, ['element group', 'radio group']) ? null : label_required($custom_fields->is_required); ?></b>

                                                                                            <div style="margin-top:10px;">
                                                                                                <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                                                                            </div>
                                                                                        <?php } else {?>
                                                                                            <?= url_text($custom_fields->name); ?> <?= in_array($custom_fields->type, ['element group', 'radio group']) ? null : label_required($custom_fields->is_required); ?>
                                                                                            
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                    
                                                                                <?php endif; ?>
                                                                                <div class="<?php echo in_array($custom_fields->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                                    <?php
                                                                                    $disabled = 'disabled';
                                                                                    $display = 'display';
                                                                                    echo get_component($custom_fields, $disabled, $custom_fields->value_custom_fields); ?>
                                                                                </div>
                                                                                <?php if ($custom_fields->description_file != '' && !in_array($custom_fields->type, ['separator', 'element group'])) { ?>
                                                                                    <div class="col-lg-12" style="margin-top:-20px;">
                                                                                        <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                
                                                                            <?php if ($custom_fields->is_multiple && $custom_fields->type != 'radio group') { ?>
                                                                                <?php foreach ($custom_fields->multiple_file as $kmf => $mf) { ?>
                                                                                    <div class="multiple-item" style="margin-left: -15px;">
                                                                                        <div class="<?php echo in_array($custom_fields->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', NULL]) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                                            <!-- dapatkan data value dari customfield multiple -->
                                                                                            <?php 
                                                                                            $condition_custom_fields_value = [
                                                                                                'user_grantee_custom_fields_id' => $custom_fields->id,
                                                                                                'user_grantee_grant_id' => $custom_fields->user_grantee_grant_id,
                                                                                                'user_grantee_id' => $this->Grantee_ent_model->id,
                                                                                                'user_grantee_period_id' => $grantee_grant->period_id,
                                                                                                'multiple_file_id' => $mf->id,
                                                                                                'grantee_grant_id' => $grantee_grant_id
                                                                                            ];
                                                                                            $value_custom_fields = get_all_db('am_user_grantee_submission', $condition_custom_fields_value);
                                                                                            $sub_element = "";
                                                                                            if ($custom_fields->type == 'radio group' || $custom_fields->type == 'element group'){
                                                                                                $sub_element = get_all_db('am_user_grantee_group_element', ['custom_fields_id' => $custom_fields->id]);
                                                                                                $sub_element = array_map(function($data) use ($value_custom_fields){
                                                                                                    $get_value = array_filter($value_custom_fields, function($value) use ($data){
                                                                                                        return $value->group_element_id == $data->id;
                                                                                                    });
                                                                                                    $data->value = array_column($get_value, 'value');
                                                                                                    $data->submission_id = array_column($get_value, 'id');
                                                                                                    return $data;
                                                                                                }, $sub_element);
                                                                                                $value_custom_fields = array_filter($value_custom_fields, function ($value) { return $value->group_element_id == 0;});
                                                                                                $custom_fields->sub_element = $sub_element;
                                                                                                $custom_fields->multiple_file_id = $mf->id;
                                                                                            }
                                                                                            ?>
                                                                                            <?= get_component($custom_fields, $disabled, $custom_fields->value_custom_fields, true); ?>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                            <?php
                                                                            $filename = get_filename_submission($custom_fields);
                                                                            $strlen = strlen($filename);
                                                                            $name_file = $filename;
                                                                            $display = ($key == $select_section) ? '' : 'display';
                                                                            if (in_array($grantee_grant->status, [STATUS_SELECTION_DECLINED, STATUS_CANDIDATE_DECLINED, STATUS_ON_GOING_REVISED])) {
                                                                                $display = 'display';
                                                                            }
                                                                            if ($strlen > 15) {
                                                                                $name_file = substr($filename, 0, 15) . '....';
                                                                            }
                                                                            $fileurl = get_fileurl_sumbission($custom_fields);
                                                                            if ($value['data'][$step->id][$key_fields + 1]->type == 'file') {
                                                                                $file = 0;
                                                                                $row = "";
                                                                                $exitrow = "";
                                                                                $style = "margin-left:-13px;";
                                                                            } else {
                                                                                $row = "<div class='row form-group'>";
                                                                                $exitrow = "</div>";
                                                                                $style = "";
                                                                            }
                                                                            ?>
                                                                            <?= $row; ?>
                                                                            <div class="wrap-file-<?= $custom_fields->id ?>"> 
                                                                                <div class="<?= $custom_fields->is_row ? 'col-md-12 is_row_class' : 'col-lg-4' ?>" style="<?= $style ?>">
                                                                                    <label style="min-height: 25px;font-weight:100"><?= url_text($custom_fields->name) ?> <?= label_required($custom_fields->is_required) ?></label>
                                                                                    <?php if ($custom_fields->description_file) { ?>
                                                                                    <div>
                                                                                        <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                                    </div>
                                                                                    <?php } ?>
                                                                                    <div class="row">
                                                                                        <div class="col-lg-6" style="height: 150px;">
                                                                                            <?php if ($fileurl) { ?>
                                                                                                <div style="position:relative; width:100px;">
                                                                                                    <img style="margin-top: 16px; object-fit:contain;" height="100" width="100" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                                                    
                                                                                                </div>
                                                                                            <?php } else { ?>
                                                                                                <div id="preview_section_<?php echo $custom_fields->id; ?>">
                                                                                                    <img onclick="add_file('my_file_' + <?= $custom_fields->id ?>);" data-trigger="my_file_<?= $custom_fields->id ?>" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
                                                                                                   
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                            <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $filename ?>"><?= $name_file ?></p>
                                                                                        </div>
                                                                                        <?php
                                                                                        if ($fileurl != '') {
                                                                                            $display_file = 'inline-block';
                                                                                        } else {
                                                                                            $display_file = 'none';
                                                                                        }

                                                                                        if ($custom_fields->is_required) {
                                                                                            $required = 'required';
                                                                                            if ($fileurl != '') {
                                                                                                $required = '';
                                                                                            }
                                                                                        } else {
                                                                                            $required = '';
                                                                                        }
                                                                                        ?>
                                                                                        <div class="col-lg-6">
                                                                                            <img src="<?php echo base_url() ?>/img/loading.gif" class="submission-spinner" style="display:none;">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12">
                                                                                            <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style ="color:#fff;display:<?= $display_file ?>"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <small class="file-for-testing">File Size Max 5MB | Supported File: Jpg, Png, PDF</small>
                                                                                    <input onchange="show_preview(this, <?= $custom_fields->id ?>);" type="file" data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' data-step='<?= $custom_fields->user_grantee_step_id; ?>' data-id='<?= $custom_fields->id; ?>' data-period-id='<?= $custom_fields->period_id ?>' class="choosefile my_file_<?= $custom_fields->id ?> autosave" style="display: none;" <?= $required ?>>
                                                                                    <hr>
                                                                                </div>

                                                                                <?php if ($custom_fields->is_multiple) { ?>
                                                                                        <?php foreach ($custom_fields->multiple_file as $kmf => $mf) { ?>
                                                                                                <?php
                                                                                                $filename_multiple = get_filename_submission_multiple($mf);
                                                                                                $strlen = strlen($filename_multiple);
                                                                                                $name_file_multiple = $filename_multiple;
                                                                                                if ($strlen > 15) {
                                                                                                    $name_file_multiple = substr($filename_multiple, 0, 15) . '....';
                                                                                                }
                                                                                                $fileurl = get_fileurl_sumbission_multiple($mf);
                                                                                                ?>
                                                                                                <div class="<?= $custom_fields->is_row ? 'col-lg-12 is_row_class' : 'col-lg-4' ?> multiple-item">
                                                                                                    <label style="min-height: 75px;font-weight:100"><?= url_text($custom_fields->name) ?>                         <?= label_required($custom_fields->is_required) ?></label>
                                                                                                    <div style="margin-top:-80px;">
                                                                                                        <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                                                    </div>
                                                                                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="delete-multiple-spinner-<?= $mf->id ?>" style="display:none;">
                                                                                                    <div class="row">
                                                                                                        <div class="col-lg-6" style="height: 150px;">
                                                                                                            <?php if ($fileurl) { ?>
                                                                                                                    <div id="preview_section_<?php echo $custom_fields->id . $mf->id; ?>" style="position:relative; width:100px;">
                                                                                                                        <img style="margin-top:16px; object-fit:contain;" height="100" width="100" id="preview_image_<?= $custom_fields->id . $mf->id ?>" class="preview_image_<?= $custom_fields->id . $mf->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                                                                        
                                                                                                                </div>
                                                                                                            <?php } else { ?>
                                                                                                                    <div id="preview_section_<?php echo $custom_fields->id . $mf->id; ?>" style="position:relative; width:100px;">
                                                                                                                        <img onclick="add_file('my_file_' + <?= $custom_fields->id . $mf->id ?>);" data-trigger="my_file_<?= $custom_fields->id . $mf->id ?>" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id . $mf->id ?>" class="preview_image_<?= $custom_fields->id . $mf->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
                                                                                                                    </div>
                                                                                                            <?php } ?>
                                                                                                            <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $filename_multiple ?>"><?= $name_file_multiple ?></p>
                                                                                                        </div>
                                                                                                        <?php
                                                                                                        if ($fileurl != '') {
                                                                                                            $display_file = 'inline-block';
                                                                                                        } else {
                                                                                                            $display_file = 'none';
                                                                                                        }

                                                                                                        if ($custom_fields->is_required) {
                                                                                                            $required = 'required';
                                                                                                            if ($fileurl != '') {
                                                                                                                $required = '';
                                                                                                            }
                                                                                                        } else {
                                                                                                            $required = '';
                                                                                                        }
                                                                                                        ?>
                                                                                                        <div class="col-lg-6">
                                                                                                            <img src="<?php echo base_url() ?>/img/loading.gif" class="submission-spinner" style="display:none;">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-lg-12">
                                                                                                        <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style ="color:#fff;display:<?= $display_file ?>"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <input 
                                                                                                        onchange="show_preview(this, <?= $custom_fields->id . $mf->id ?>);" 
                                                                                                        type="file" 
                                                                                                        data-multiple-id='<?= $mf->id ?>'                                                                      data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' 
                                                                                                        data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' 
                                                                                                        data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' 
                                                                                                        data-step='<?= $custom_fields->user_grantee_step_id; ?>' 
                                                                                                        data-id='<?= $custom_fields->id; ?>' 
                                                                                                        data-period-id='<?= $custom_fields->period_id ?>' 
                                                                                                        class="choosefile my_file_<?= $custom_fields->id . $mf->id ?> autosave" 
                                                                                                        style="display: none;" <?= $required ?>>
                                                                                                    <hr>
                                                                                                </div>
                                                                                        <?php } ?>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <?= $exitrow; ?>
                                                                        <?php $file++; endif; ?>
                                                            <?php } ?>
                                                        </div>
                                    
                                                        <div class="wrap-step-<?= $step->id ?>">
                                                            <?php if (!empty($step->multiple_fields_step)) { ?>
                                                                    <?php foreach ($step->multiple_fields_step as $mfs) { ?>
                                                                            <?php
                                                                            $data_for_content['idx'] = $mfs->id;
                                                                            $data_for_content['data_custom_fields'] = $value['data'][$step->id];
                                                                            $data_for_content['disabled'] = 'disabled';
                                                                            $data_for_content['is_admin'] = true;
                                                                            foreach ($value['data'][$step->id] as $kscf => $rowscf) {
                                                                                $condition_multiple_file = [
                                                                                    'user_grantee_custom_fields_id' => $rowscf->id,
                                                                                    'user_grantee_grant_id' => $rowscf->user_grantee_grant_id,
                                                                                    'user_grantee_id' => $this->Grantee_ent_model->id,
                                                                                    'user_grantee_period_id' => $grantee_grant->period_id,
                                                                                    // 'multiple_file_id' => $mfs->id,
                                                                                    'multiple_step_id' => $mfs->id,
                                                                                    'grantee_grant_id' => $grantee_grant_id,
                                                                                ];
                                                                                $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_file);
                                                                                $arr_value_custom_fields = get_all_db('am_user_grantee_submission', $condition_multiple_file);
                                                                                // if type radio group then get sub element 
                                                                                $sub_element = "";
                                                                                if ($custom_fields->type == 'radio group' || $custom_fields->type == 'element group') {
                                                                                    $sub_element = get_all_db('am_user_grantee_group_element', ['custom_fields_id' => $rowscf->id]);
                                                                                    $sub_element = array_map(function ($data) use ($arr_value_custom_fields) {
                                                                                        $get_value = array_filter($arr_value_custom_fields, function ($value) use ($data) {
                                                                                            return $value->group_element_id == $data->id;
                                                                                        });
                                                                                        $data->value = array_column($get_value, 'value');
                                                                                        return $data;
                                                                                    }, $sub_element);

                                                                                }
                                                                                $multiple_file = get_row_db('am_user_grantee_multiple_file', ['user_grantee_step_id' => $mfs->id, 'property_name' => $rowscf->name]);
                                                                                $rowscf->value_custom_fields = $value_multiple_file->value;
                                                                                $rowscf->other_value = $value_multiple_file->other_value;
                                                                                $rowscf->multiple_step_id = $mfs->id;
                                                                                $rowscf->multiple_file_id = $multiple_file->id;
                                                                                $rowscf->sub_element = $sub_element;

                                                                                if ($rowscf->type == 'file' && $rowscf->is_multiple == true) {
                                                                                    $multiple_file_for_file = get_all_db('am_user_grantee_multiple_file', [
                                                                                        'custom_fields_id' => $rowscf->id,
                                                                                        'grantee_grant_id' => $grantee_grant_id,
                                                                                        'user_grantee_step_id' => $mfs->id,
                                                                                    ]);
                                                                                    foreach ($multiple_file_for_file as $kmf => $mf) {
                                                                                        $condition_multiple_for_file = [
                                                                                            'user_grantee_custom_fields_id' => $rowscf->id,
                                                                                            'user_grantee_grant_id' => $rowscf->user_grantee_grant_id,
                                                                                            'user_grantee_id' => $this->Grantee_ent_model->id,
                                                                                            'user_grantee_period_id' => $grantee_grant->period_id,
                                                                                            'multiple_file_id' => $mf->id,
                                                                                            'multiple_step_id' => $mfs->id,
                                                                                            'grantee_grant_id' => $grantee_grant_id,
                                                                                        ];
                                                                                        $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_for_file);
                                                                                        $mf->value = $value_multiple_file ? $value_multiple_file->value : '';
                                                                                    }
                                                                                    $rowscf->multiple_file = $multiple_file_for_file;
                                                                                }
                                                                            }
                                                                            echo $this->load->view('grantee/submission/multiple_fields_step', $data_for_content, true);
                                                                            ?>
                                                                    <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                        
                                                    </div>
                                        
                                                    <div class="progressbar">
                                                        <?php if ($index + 1 == count($value['grants_step'])): ?>
                                                                <?php if (count($value['grants_step']) > 1) { ?>
                                                                        <!-- <a aria-expanded="true" 
                                                                            data-toggle="tab" 
                                                                            href="#<?php echo $key; ?>_step_<?= $value['grants_step'][$index - 1]->id; ?>" 
                                                                            class="btn btn-primary previous" 
                                                                            style="float:left;margin-bottom:20px;width:100px;color:white;">
                                                                            Back
                                                                        </a> -->
                                                                <?php } ?>
                                                                
                                                        <?php elseif ($index == 0): ?> 
                                                                <a aria-expanded="true" 
                                                                    data-toggle="tab" 
                                                                    href="#<?php echo $key; ?>_step_<?= $value['grants_step'][1]->id; ?>" 
                                                                    class="btn btn-success next" 
                                                                    style="float:right;margin-bottom:20px;width:100px;color:white;"
                                                                    data-index="<?php echo $key; ?>_step_<?= $value['grants_step'][1]->id; ?>">
                                                                    Next
                                                                </a>
                                                        <?php else: ?>
                                                                <!-- <a aria-expanded="true" 
                                                                    data-toggle="tab" 
                                                                    href="#<?php echo $key; ?>_step_<?= $value['grants_step'][$index - 1]->id; ?>" 
                                                                    class="btn btn-primary previous" 
                                                                    style="float:left;margin-bottom:20px;width:100px;color:white;">
                                                                    Back
                                                                </a> -->
                                                                <a aria-expanded="true" 
                                                                    data-toggle="tab" 
                                                                    href="#<?php echo $key; ?>_step_<?= $value['grants_step'][$index + 1]->id; ?>" 
                                                                    class="btn btn-success next" 
                                                                    style="float:right;margin-bottom:20px;width:100px;color:white;"
                                                                    data-index="<?php echo $key; ?>_step_<?= $value['grants_step'][$index + 1]->id; ?>">
                                                                    Next
                                                                </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                        <?php endforeach; ?>
                                        <br><br>
                                        <hr>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <?php
                                            $note = 'note_' . $select_section;
                                            if ($note == 'note_on_going') {
                                                $note = 'note_ongoing';
                                            }
                                            ?>
                                            <textarea <?php echo (($key == $select_section && $is_active) ? '' : 'disabled'); ?> name="note" id="<?= $key; ?>_note_submission" cols="30" rows="10" class="form-control" width="100%"><?= $grantee_grant->$note ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <?php } else { ?>
                        <div>
                            <div class="col-lg-12 mt-4">    
                                <div class="col-md-12 p-0">
                                    <iframe src="<?php echo $pdf_url; ?>#toolbar=0" frameborder="0" style="width: 100%; height: 1000px;"></iframe>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
        <?php } ?>

        <div id="report" class="tab-pane fade <?= $pid == 'report' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="min-height:300px;">
                        <?php

                        foreach ($category_report as $key => $categoryR) {
                            $dateNow = date('Y/m/d');
                            $report_date = date('Y/m/d', strtotime($categoryR->start_date));

                            ?>
                            <div class="panel panel-default" <?= $report_date > $dateNow ? 'style="display:none"' : '' ?>>
                                <div class="panel-heading text-left" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $categoryR->id ?>" aria-expanded="true" aria-controls="collapse<?= $categoryR->id ?>">
                                            <?php
                                            if ($categoryR->status == 'submited') {
                                                $status = 'Waiting for Accept';
                                                $text_color = 'text-warning';
                                            } elseif ($categoryR->status == 'accept') {
                                                $status = '<i class="fa fa-check-circle"></i> Accepted';
                                                $text_color = 'text-success';
                                            } elseif ($categoryR->status == 'revisi') {
                                                $status = 'Revise';
                                                $text_color = 'text-danger';
                                            } else {
                                                $status = '';
                                            }
                                            ?>
                                            <?= $categoryR->name ?> <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span> <span style="float:right;font-weight:bold;" class="<?= $text_color ?>"><?= $status ?></span> 
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse<?= $categoryR->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <?php if (!empty($categoryR->start_date)) { ?>
                                        <div class="panel-body">
                                            <h3 class="text-center"><?= $this->User_grantee_grant_model->name ?></h3>
                                            <div style="font-weight:bold;"><?= $categoryR->information ?></div>
                                            <div class="mt-5">
                                                <?php
                                                $no = 1;
                                                $file = 1;
                                                foreach ($categoryR->custom_field_report as $key => $custom_fields) {
                                                    ?>
                                                    <!-- template for others instead file template -->
                                                    <?php if ($custom_fields->type != 'file'): ?>
                                                            <div class="row form-group">
                                                                <?php if ($custom_fields->type == 'separator'): ?>
                                                                        <div class="col-md-5 text-left"><b><?= $custom_fields->name; ?></b></div>
                                                                <?php else: ?>
                                                                        <div class="col-md-1 text-left" style="font-weight:bold"><?= $no ?>.</div>
                                                                        <div class="col-md-4 text-left"><?= $custom_fields->name; ?><?= label_required($custom_fields->is_required); ?></div>
                                                                <?php endif; ?>
                                                                <div class="col-md-7">
                                                                    <?= get_component($custom_fields, 'disabled', $custom_fields->value_custom_fields); ?>
                                                                </div>
                                                            </div>
                                                    <?php else: ?>
                                                            <?php
                                                            if ($file == 3 || $categoryR->custom_field_report[$key + 1]->type == 'file') {
                                                                $file = 0;
                                                                $row = "";
                                                                $exitrow = "";
                                                            } else {
                                                                $row = "<div class='row form-group'>";
                                                                $exitrow = "</div>";
                                                            }
                                                            ?>
                                            
                                                            <?= $row; ?>
                                                            <div class="col-lg-4">
                                                                <label><?= $custom_fields->name; ?></label>
                                                                <p id="file_name1" style="font-size:16px">No file chosen</p>
                                                                <a href="javascript:;" class="btn btn-danger" id="btn-upload1">Upload</a>
                                                                <input type="file" id="my_file1" style="display: none;">
                                                                <a class="btn btn-success">save</a>
                                                                <hr>
                                                            </div>
                                                            <?= $exitrow; ?>
                                                        <?php $file++; endif; ?>

                                                    <?php $no++;
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-lg-12 mb-3">
                                                <div class="form-group">
                                                    <label>Note</label>
                                                    <textarea class="form-control" rows="4" id="note<?= $categoryR->report_id ?>"><?= $categoryR->note ?></textarea>
                                                </div>
                                            </div>
                                            <?php if ($categoryR->status == 'submited' || $categoryR->status == 'revisi') { ?>
                                                <div class="col-lg-12 mb-3">
                                                    <button type="button" onclick="accept_report(<?= $categoryR->report_id ?>, <?= $this->Grantee_ent_model->id ?>)" class="btn btn-success" style="float:right;">Accept</button>
                                                    <button type="button" onclick="revisi_report(<?= $categoryR->report_id ?>, <?= $this->Grantee_ent_model->id ?>)" class="btn btn-warning" style="float:right;margin-right: 10px;">Revised</button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } else { ?>
                                            <div style="padding:10px;">
                                                <p><?= $categoryR->name ?> is not available now</p>
                                            </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

    </div>

    <!-- <div class="col-lg-12" style="margin-bottom:50px">
        <a href="<?= site_url('admin/selection/manage') ?>" class="btn btn-primary btn-lg" style="width:150px;float:left;">Back</a>
    </div> -->
</div>

<?php $this->load->view('admin/partials/modal_confirm') ?>