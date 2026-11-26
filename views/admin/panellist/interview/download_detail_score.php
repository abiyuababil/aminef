<?php
$panellist = get_row_db('am_panellist', ['id' => $interview->panellist_id]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Menambahkan CSS Bootstrap langsung di sini */
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #fff;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd !important;
            padding: 8px;
        }

        .thead-dark th {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        td, th {
            vertical-align: top;
            text-align: left;
        }
    </style>
    <title>Interview score <?= $grantee_grant->grant_name ?> of <?= get_full_name($grantee_grant) ?> by <?= $panellist->name ?> - <?= date('dmYHis') ?></title>
</head>

<body>
    <div class="row">
        <p style="font-weight: bold;text-align:center;"><?= $grantee_grant->grant_name ?></p>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php if (!empty($period->period_inverview_description)) { ?>
                <div class="alert alert-info"> 
                    <b><i class="fa fa-info-circle"></i> Information <br></b>
                    <div class="pl-4"><?php echo $period->period_inverview_description; ?> </div>
                </div>
            <?php } ?>
            <table class="table table-bordered table-stripped">
                <tr>
                    <td width="25%" style="font-weight: bold;">Name Of Interviewer</td>
                    <td style="background-color: #ebebeb !important;">
                        <?php
                        echo $panellist->name;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="25%" style="font-weight: bold;">Name Of Applicant</td>
                    <td style="background-color: #ebebeb !important;"><?= get_full_name($grantee_grant) ?></td>
                </tr>
                <tr>
                    <td width="25%" style="font-weight: bold;">Interview Date</td>
                    <td style="background-color: #ebebeb !important;">
                        <?php echo $grantee_grant->date_interview; ?>
                    </td>
                </tr>
            </table>
            <table class="table table-bordered table-stripped">
                <tr>
                    <td style="color:#7da2bd;font-weight: bold;text-align:center;">#</td>
                    <td style="color:#7da2bd;font-weight: bold;text-align:center;">Evaluation Criteria</td>
                    <td style="color:#7da2bd;font-weight: bold;text-align:center;" class="text-center">Score</td>
                    <td style="color:#7da2bd;font-weight: bold;text-align:center;" class="text-center">Total Score</td>
                </tr>
                <?php
                $total_score = 0;
                if ($interview_questions) {
                    usort($interview_questions, function ($a, $b) {
                        return $a->sort - $b->sort;
                    });
                ?>
                    <?php $i = 1;
                    foreach ($interview_questions as $key => $question) { ?>
                        <?php
                        $question_id = $question->id;
                        if (isset($interview_scores)) {
                            $interview_score = array_filter($interview_scores, function ($score) use ($question_id) {
                                return $score->interview_question_id === $question_id;
                            });
                            
                            if ($interview_score) {
                                $interview_score = array_shift($interview_score);
                            }
                        }
                        ?>
                        <tr>
                            <td width="100px;" rowspan="2"><?php echo $i++; ?></td>
                            <td><?php echo $question->question; ?></td>
                            <td width="20%;" style="text-align:center">
                                <?php 
                                    $value = isset($interview_score->score) && $interview_score->score ? round($interview_score->score, 2) : ""; 
                                    if ($interview_score->scoring_type == 1) {
                                        echo number_format($interview_score->rate, 2, '.','');
                                    } else {
                                        echo number_format($value, 2, '.', '');
                                    }
                                ?>
                            </td>

                            <td width="20%;" style="text-align:center">
                                <?php $value = isset($interview_score->total_score) && $interview_score->total_score ? round($interview_score->total_score, 2) : 0; ?>
                                <?php $total_score += round($interview_score->total_score, 2); ?>
                                <?php echo number_format($value, 2, '.', ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Comment</td>
                            <td colspan="2">
                                <?php $value = isset($interview_score->comments) && $interview_score->comments ? $interview_score->comments : ""; ?>
                                <?php echo $value; ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr style="font-size: 20px;">
                        <td colspan="3" class="text-right">
                            Total
                        </td>
                        <td id="total" style="font-weight: bold;text-align:center;"><?php echo number_format($total_score, 2, '.', ''); ?></td>
                    </tr>
                <?php } ?>
            </table>
            <br/>
            <?php if ($period->period_evaluation_template == 'table') { ?>
                <div class="col-md-12">
                    <hr>
                </div>
                <?php if ($evaluation_questions) { ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" style="text-align: center; margin-bottom:20px;">
                                <b><?php echo $period->period_evaluation_title; ?></b>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo $period->period_evaluation_description; ?>
                        </div>
                    </div>

                    <table class="table table-bordered table-stripped">
                        <thead>
                            <tr>
                                <th style="color:#7da2bd;font-weight: bold;text-align:center;">#</th>
                                <th style="color:#7da2bd;font-weight: bold;text-align:center;">Evaluation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($evaluation_questions) {
                                usort($evaluation_questions, function ($a, $b) {
                                    return $a->sort - $b->sort;
                                });
                            ?>
                                <?php $i = 1;
                                foreach ($evaluation_questions as $key => $question) { ?>
                                    <?php
                                    $question_id = $question->id;
                                    if (isset($evaluation_scores)) {
                                        $evaluation_score = array_filter($evaluation_scores, function ($score) use ($question_id) {
                                            return $score->evaluation_question_id === $question_id;
                                        });
                                        if ($evaluation_score) {
                                            $evaluation_score = array_shift($evaluation_score);
                                        }
                                    }
                                    ?>
                                    <tr class="scoring-row">
                                        <td width="10px;"><?php echo $i++; ?></td>
                                        <td>
                                            <p><?php echo $question->question; ?></p>
                                            <hr>
                                            <p>Comment : <?php echo isset($evaluation_score->comment) && $evaluation_score->comment ? $evaluation_score->comment : ""; ?></p>
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
                
            <?php } ?>
            <br />
                <br />
                <div class="form-group">
                    <table class="table table-bordered table-stripped">
                        <tr>
                            <td style="font-weight: bold;text-align:center;">Comment</td>
                        </tr>
                        <tr>
                            <td><?php echo $interview->note; ?></td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-stripped">
                        <tr>
                            <?php
                            switch ($interview->rank_recommendation) {
                                case 0:
                                    $rankrecom = 'Not Recommended';
                                    break;
                                case 1:
                                    $rankrecom = 'Recommended';
                                    break;
                                case 2:
                                    $rankrecom = 'Highly Recommended';
                                    break;
                            }
                            ?>
                            <td style="font-weight: bold;">Based on the result of the interview, applicant is</td>
                            <td><?= $rankrecom ?></td>
                        </tr>
                    </table>
                </div>
        </div>
</body>

</html>