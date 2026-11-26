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
    <title>Review Score <?= $data_review->grant_name ?> of <?= get_full_name($data_review) ?> by <?= $data_review->panellist_name ?> - <?= date('dmYHis') ?></title>
</head>
<body>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 style="font-weight: bold;text-align:center;"><?= $data_review->grant_name ?></h2>
                <p style="font-weight: bold;text-align:center;">PRELIMINARY APPLICATION SELECTION SCORING SHEET</p>
            </div>
        </div>
        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <td width="25%" style="font-weight: bold;">Date</td>
                    <td style="background-color: #ebebeb !important;"><?= $data_review->date != '' ? date('d M Y', strtotime($data_review->date)) : '-' ?></td>
                </tr>
                <tr>
                    <td width="25%" style="font-weight: bold;">Name Of Reviewer</td>
                    <td style="background-color: #ebebeb !important;"><?= $data_review->panellist_name ?></td>
                </tr>
                <tr>
                    <td width="25%" style="font-weight: bold;">Name Of Applicant</td>
                    <td style="background-color: #ebebeb !important;"><?= $data_review ? get_full_name($data_review) : '' ?></td>
                </tr>
                <tr>
                    <td width="25%" style="font-weight: bold;">Home Institution</td>
                    <td style="background-color: #ebebeb !important;"><?= $data_review->home_institution ?></td>
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
                            <td>
                                <?= $data_value['question'][$question->id] != 0  ? $data_value['question'][$question->id] :  '' ?> 
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
                        <td width="100px;" rowspan="2"><?= $i++; ?></td>
                        <td width="50%"><?= $question->question; ?></td>
                        <td>
                            <?= get_initial_score($question->id, $data_value['question'][$question->id]) ?>
                        </td>
                        <td style="vertical-align:middle;text-align:center">
                            <?= $data_value['question'][$question->id] ?> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1">Comments </td>
                        <td colspan="2"><?= $data_value['note_question'][$question->id] ?></td>
                    </tr>
                <?php } ?>
                <tr style="font-size: 20px;">
                    <td colspan="3" class="text-right">
                        Total
                    </td>
                    <?php $total = array_sum($data_value['question']); ?>
                    <td id="total" style="font-weight: bold;text-align:center" class="text-center"><?= number_format($total, 2, '.', '')?></td>
                </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="4">Question is not available</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        
        <br/>
            <br/>
            <div class="form-group">
                <table class="table table-bordered table-stripped">
                    <tr>
                        <td style="font-weight: bold;text-align:center;">Comment</td>
                    </tr>
                    <tr>
                        <td><?= $data_value['note'] ?></td>
                    </tr>
                </table>
                <table class="table table-bordered table-stripped">
                    <tr>
                        <?php 
                            switch($data_review->rank_recommendation) {
                                case 'NR' : 
                                    $rankrecom = 'Not Recommended';
                                    break;
                                case 'R' : 
                                    $rankrecom = 'Recommended';
                                    break;
                                case 'HR' : 
                                    $rankrecom = 'Highly Recommended';
                                    break;
                            }
                        ?>
                        <td style="font-weight: bold;">FINAL DECISSION</td>
                        <td><?= $rankrecom ?></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>


</body>
</html>