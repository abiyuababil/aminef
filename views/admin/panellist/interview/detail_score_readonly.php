<div class="row">
    <div class="col-lg-12">
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
                            echo isset($panellist->name) ? $panellist->name : '';
                        ?>
                    </th>
                </tr>
                <tr>
                    <th style="background-color: white !important;" width="20%">Name Of Applicant</th>
                    <th colspan="3" style="background-color: #ebebeb !important;"><?php echo isset($grantee->first_name) ? $grantee->first_name . ' ' . $grantee->middle_name . ' ' . $grantee->last_name : ''; ?></th>
                </tr>
                <tr>
                    <th style="background-color: white !important;" width="20%">Interview Date</th>
                    <th colspan="3" style="background-color: #ebebeb !important;">
                        <?php echo isset($grantee_grant->date_interview) ? $grantee_grant->date_interview : ''; ?>
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
                            usort($interview_questions, function($a, $b) { return $a->sort - $b->sort; });
                    ?>
                    <?php $i = 1; foreach($interview_questions as $key => $question) { 
                        $question_id = $question->id;
                        $interview_score = null;
                        if (isset($interview_scores)) {
                            $matched = array_filter($interview_scores, function($score) use($question_id) {
                                return isset($score->interview_question_id) && $score->interview_question_id === $question_id;
                            });
                            if ($matched) {
                                $interview_score = array_shift($matched);
                            }
                        }
                        $display_score = '';
                        $display_total = 0;
                        if ($interview_score) {
                            $display_total = isset($interview_score->total_score) ? round($interview_score->total_score, 2) : 0;
                            $total_score += $display_total;
                            if ($question->scoring_type == 0) {
                                $display_score = isset($interview_score->score) ? number_format((float)$interview_score->score, 2, '.', ',') : '';
                            } else {
                                // find rate label
                                $rate_scores = get_all_db('am_user_grantee_period_interview_rate_scores', ['interview_question_id' => $question->id]);
                                $rate_label = '';
                                if ($rate_scores && isset($interview_score->rate)) {
                                    foreach($rate_scores as $rs) {
                                        if ((string)$rs->initial_rate === (string)$interview_score->rate) {
                                            $rate_label = $rs->initial_rate;
                                            break;
                                        }
                                    }
                                }
                                $display_score = $rate_label ?: (isset($interview_score->score) ? number_format((float)$interview_score->score, 2, '.', ',') : '');
                            }
                        }
                    ?>
                    <tr class="scoring-row">
                        <td width="10px;" rowspan="2"><?php echo $i++; ?></td>
                        <td><?php echo $question->question; ?></td>
                        <td width="200px;" class="text-center"><span style="font-size:20px; font-weight:bold;"><?php echo $display_score !== '' ? $display_score : '-'; ?></span></td>
                        <td width="200px;" style="vertical-align:middle;" class="text-center"><span style="font-size:20px; font-weight:bold;"><?php echo number_format($display_total, 2, '.', ','); ?></span></td>
                    </tr>
                    <?php if (isset($interview_score->comments) && $interview_score->comments !== '') { ?>
                    <tr>
                        <td colspan="3">
                            <div><strong>Comments:</strong></div>
                            <div><?php echo $interview_score->comments; ?></div>
                        </td>
                    </tr>
                    <?php } else { ?>
                    <tr><td colspan="3">&nbsp;</td></tr>
                    <?php } ?>
                    <?php } // foreach questions ?>
                    <tr style="font-size: 20px;">
                        <td colspan="3" class="text-right">Total</td>
                        <td id="total" style="font-weight: bold; text-align:center"><?php echo number_format($total_score, 2, '.', ','); ?></td>
                    </tr>
                    <?php } else { ?>
                    <tr><td colspan="4">Question is not available</td></tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php if (!empty($evaluation_questions)) { ?>
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
                            usort($evaluation_questions, function($a,$b){ return $a->sort - $b->sort; });
                            $j = 1;
                            foreach($evaluation_questions as $key => $question) {
                                $evaluation_score = null;
                                if (isset($evaluation_scores)) {
                                    $matched = array_filter($evaluation_scores, function($score) use($question) {
                                        return isset($score->evaluation_question_id) && $score->evaluation_question_id === $question->id;
                                    });
                                    if ($matched) $evaluation_score = array_shift($matched);
                                }
                        ?>
                        <tr>
                            <td width="10px;" rowspan="2"><?php echo $j++; ?></td>
                            <td><?php echo $question->question; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <?php if (isset($evaluation_score->comment) && $evaluation_score->comment !== '') { ?>
                                    <div><?php echo $evaluation_score->comment; ?></div>
                                <?php } else { ?>
                                    &nbsp;
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

            <div class="form-group">
                <label>Comment</label>
                <div><?php echo isset($interview->note) && $interview->note !== '' ? $interview->note : '-'; ?></div>
            </div>

            <div class="form-group">
                <label>Based on the result of the interview, applicant is</label>
                <div>
                    <?php
                        $final_label = '-';
                        if (isset($interview->rank_recommendation) && $interview->rank_recommendation !== '') {
                            $final = $interview->rank_recommendation;
                            $full_map = [
                                HEIGHLY_RECOMMENDED => 'Highly Recommended',
                                RECOMMENDED => 'Recommended',
                                NOT_RECOMMENDED => 'Not Recommended',
                                'HR' => 'Highly Recommended',
                                'R' => 'Recommended',
                                'NR' => 'Not Recommended'
                            ];
                            if (is_numeric($final)) {
                                $final_label = isset($full_map[(int)$final]) ? $full_map[(int)$final] : (string)$final;
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
</div>
