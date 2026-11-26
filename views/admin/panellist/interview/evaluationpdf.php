<?php
if (!isset($interview) || !isset($interview->panellist_id)) {
    die("Error: Interview data or panellist ID is missing.");
}

$panellist = get_row_db('am_panellist', ['id' => $interview->panellist_id]);

if (!$panellist) {
    die("Error: Panellist not found.");
}

if (!isset($grantee_grant)) {
    die("Error: Grantee grant data is missing.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Evaluation <?= $grantee_grant->grant_name ?> of <?php echo get_full_name($grantee_grant) ?> by <?php echo $panellist->name ?> - <?= date('dmYHis') ?></title>
</head>

<body>
    <div style="position: absolute; top:0; right:0;">
        <img width="225px" src="<?php echo FCPATH . 'img/header-pdf-evaluation.png'; ?>">
    </div>
    <div style="margin-left: 50px; margin-bottom: 100px;">
        <img width="120px" src="<?php echo FCPATH . 'img/logo-aminef-color.png'; ?>">
        <img width="185px" src="<?php echo FCPATH . 'img/logo-fulbright-color.png'; ?>" style="margin-left: 25px; margin-top: -25px;">
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="font-size: 11pt; text-align: center; font-weight:bold;"><?php echo $period->period_evaluation_title; ?></td>
        </tr>
        <tr>
            <td style="font-size: 11pt; text-align: center; font-weight:bold; padding-top: 20px;"><?php echo $period->period_evaluation_description; ?></td>
        </tr>
    </table>
    <table style="width: 100%; margin-left: 20px; margin-right: 15px; border:1px solid black; margin-top:20px;">
        <tr>
            <td style="font-size: 10pt; padding: 5px; line-height: 20px;">
                <br>
                APPLICANT'S FULL NAME : <?= strtoupper(get_full_name($grantee_grant)) ?><br>
                COUNTRY : <span style="border-bottom: 1px solid black;">INDONESIA</span><br>
                LANGUAGE : <span style="border-bottom: 1px solid black;">INDONESIAN</span><br>
            </td>
        </tr>
    </table>
    <?php
    if (isset($evaluation_questions) && !empty($evaluation_questions)) {
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
            $question_type = $question->type;
            $value = isset($evaluation_score->value) && $evaluation_score->value ? $evaluation_score->value : "";
            ?>
            <?php if (in_array($question_type, ['textarea', null])) {  ?>
                <table style="width: 100%; margin-left: 20px; margin-right: 15px; margin-top:30px; border:1px solid black; page-break-inside: avoid; page-break-before: auto; font-size:10pt;">
                    <tr style="font-size: 10pt;">
                        <td style="font-size: 10pt;"><?php echo $question->question; ?></td>
                    </tr>
                    <tr style="font-size: 10pt;">
                        <td style="font-size: 10pt; padding-top: 10px; font-style:italic;">
                            <?php echo strip_tags($evaluation_score->value ?? ""); ?>
                        </td>
                    </tr>
                </table>
            <?php } ?>
            <?php if (in_array($question_type, ['input'])) {  ?>
                <table style="width: 100%; margin-left: 20px; margin-right: 15px; margin-top:20px;">
                    <tr style="font-size: 10pt !important;">
                        <td style="font-size: 10pt;"><?php echo strip_tags($question->question ?? ""); ?> <span style="border-bottom: 2px dashed black;"><?php echo strip_tags($evaluation_score->value ?? ""); ?> </span></td>
                    </tr>
                </table>
            <?php } ?>
            <?php if (in_array($question_type, ['checkbox'])) {  ?>
                <table style="width: 100%; margin-left: 20px; margin-right: 15px; margin-top:20px;">
                    <tr style="font-size: 10pt !important;">
                        <td style="font-size: 10pt;"><?php echo $question->question; ?></td>
                    </tr>
                    
                    <tr style="font-size: 10pt;">
                        <td style="font-size: 10pt; font-weight:bold;">
                            <?php
                            $options = $question->options;
                            $options = json_decode($options, true);
                            $values = json_decode($value, true);
                            foreach ($options as $option) {
                                $checked = false;
                                if (is_array($values) && in_array($option, $values)) {
                                    $checked = true;
                                }
                            ?>
                                <div style="display: flex;">
                                    <?php if ($checked) { ?>
                                        <img width="15px" src="<?php echo FCPATH . 'img/checked.png'; ?>" />
                                    <?php } else { ?>
                                        <img width="15px" src="<?php echo FCPATH . 'img/unchecked.png'; ?>" />
                                    <?php } ?>
                                    <?php echo $option; ?>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            <?php } ?>
            <?php if (in_array($question_type, ['separator'])) { ?>
                <table style="width: 100%; margin-left: 20px; margin-right: 15px; margin-top:20px;">
                    <tr style="font-size: 10pt;">
                        <td style="font-size: 10pt; <?php echo (strpos($question->question, 'text-align: center') !== false) ? 'text-align: center;' : ''; ?>"><?php echo $question->question; ?></td>
                    </tr>
                </table>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <p>Error: No evaluation questions found.</p>
    <?php } ?>
    <table style="width: 100%; margin-left: 20px; margin-right: 15px; border:1px solid black; margin-top:20px;">
        <tr>
            <td style="font-size: 10pt; font-weight:bold;">EVALUATION AND REPORT PREPARED BY:</td>
        </tr>
        <tr>
            <td style="font-size: 10pt; padding: 5px; line-height: 30px;">
                NAME (print) : <?php echo strtoupper($panellist->name); ?><br>
                EMAIL ADDRESS : <?php echo $panellist->email; ?><br>
                TITLE : <?php echo $panellist->prefix; ?><br>
                <!-- SIGNATURE : <br> -->
                DATE : <?php echo date('F d, Y'); ?><br>
            </td>
        </tr>
    </table>
</body>

</html>
