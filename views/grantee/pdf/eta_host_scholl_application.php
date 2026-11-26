<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($document_title) ? $document_title : 'ETA Host School Application'; ?></title>
</head>

<body>
    <?php if (!isset($hide_personal_and_contact) || !$hide_personal_and_contact) { ?>
        <table style="width: 100%; text-align: center; padding-left: 100px; padding-right: 130px;">
            <tr>
                <td style="width: 100%; text-align: center;">
                    <h3 style="font-size: 16pt; text-transform: uppercase; margin-left: 1000px;">
                        <b>
                            AMINEF ETA HOST SCHOOL APPLICATION
                        </b>
                    </h3>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; text-align: center; font-size:10pt;">
                    <h3 style="font-size: 16pt; text-transform: uppercase; margin-left: 1000px;"><?= $data_form->title ?>
                    </h3>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
    <?php } ?>

    <table style="width: 100%;">
        <tr>
            <td style="font-weight: bold; font-size: 12pt;">&nbsp; <?= $data_form->description ?></td>
        </tr>
    </table>
    <br>
    <table style="width: 100%;">
        <?php foreach ($data as $question) { ?>
            <?php if ($question->type == 'file') {
                continue;
            } ?>
            
            <?php if ($question->type == 'separator') { ?>
                <tr>
                    <td style="border-bottom: 1px solid black; font-size: 10pt; font-weight:bold;" colspan="3">&nbsp;
                        <?= strip_tags($question->name) ?></td>
                </tr>
            <?php } elseif ($question->type == 'radio group') { ?>
                <?php 
                    $selected_option = isset($data_submission[$question->id]) ? $data_submission[$question->id] : '';
                ?>
                <tr>
                    <td width="25%" style="vertical-align: top;"><?= strip_tags($question->name) ?></td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px solid black; vertical-align: top;">
                        <?= $selected_option ?>
                    </td>
                </tr>
                <?php if (isset($question->sub_element) && is_array($question->sub_element) && !empty($selected_option)) { ?>
                    <?php foreach ($question->sub_element as $sub) { ?>
                        <?php if (isset($sub->which_option) && $sub->which_option == $selected_option) { ?>
                            <tr>
                                <td width="25%" style="vertical-align: top; padding-left: 20px;"><?= strip_tags(isset($sub->property_name) ? $sub->property_name : $sub->name) ?></td>
                                <td style="vertical-align: top;">:</td>
                                <td style="border-bottom: 1px solid black; vertical-align: top;">
                                    <?= isset($sub->value) ? $sub->value : '' ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } elseif ($question->type == 'element group') { ?>
                <tr>
                    <td colspan="3" style="vertical-align: top; font-weight: bold; padding-top: 10px;"><?= strip_tags($question->name) ?></td>
                </tr>
                <?php if (isset($question->sub_element) && is_array($question->sub_element)) { 
                    $num_entries = 1;
                    foreach ($question->sub_element as $sub) {
                        $val = $sub->value ?? null;
                        if (is_array($val)) {
                            $num_entries = max($num_entries, count($val));
                        }
                    }
                    for ($entry_idx = 0; $entry_idx < $num_entries; $entry_idx++) {
                        if ($num_entries > 1) { ?>
                            <tr>
                                <td colspan="3" style="vertical-align: top; font-weight: bold; padding-left: 10px; padding-top: 6px; color: #555;">#<?= ($entry_idx + 1) ?></td>
                            </tr>
                        <?php }
                        foreach ($question->sub_element as $sub) { ?>
                            <tr>
                                <td width="25%" style="vertical-align: top; padding-left: 20px;"><?= strip_tags(isset($sub->property_name) ? $sub->property_name : $sub->name) ?></td>
                                <td style="vertical-align: top;">:</td>
                                <td style="border-bottom: 1px solid black; vertical-align: top;">
                                    <?php
                                    $sub_ans = is_array($sub->value ?? null) ? ($sub->value[$entry_idx] ?? '') : ($entry_idx === 0 ? ($sub->value ?? '') : '');
                                    if (is_array($sub_ans)) {
                                        echo implode(', ', $sub_ans);
                                    } elseif (is_string($sub_ans) && !empty($sub_ans)) {
                                        $decoded = json_decode($sub_ans, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            echo implode(', ', $decoded);
                                        } else {
                                            echo $sub_ans;
                                        }
                                    } else {
                                        echo $sub_ans;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php }
                    }
                } ?>
            <?php } elseif ($question->type == 'declare') { ?>
                <?php 
                    $selected_declarations = isset($data_submission[$question->id]) ? $data_submission[$question->id] : [];
                    if (is_string($selected_declarations) && !empty($selected_declarations)) {
                        $decoded = json_decode($selected_declarations, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $selected_declarations = $decoded;
                        } else {
                            $selected_declarations = [$selected_declarations];
                        }
                    }
                    if (!is_array($selected_declarations)) {
                        $selected_declarations = [];
                    }
                ?>
                <tr>
                    <td width="25%" style="vertical-align: top;"><?= strip_tags($question->name) ?></td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px solid black; vertical-align: top;">
                        <?= implode(', ', $selected_declarations) ?>
                    </td>
                </tr>
                <?php if (isset($question->sub_element) && is_array($question->sub_element) && !empty($selected_declarations)) { ?>
                    <?php foreach ($question->sub_element as $sub) { ?>
                        <?php if (isset($sub->which_option) && in_array($sub->which_option, $selected_declarations)) { ?>
                            <tr>
                                <td width="25%" style="vertical-align: top; padding-left: 20px;"><?= strip_tags(isset($sub->property_name) ? $sub->property_name : $sub->name) ?></td>
                                <td style="vertical-align: top;">:</td>
                                <td style="border-bottom: 1px solid black; vertical-align: top;">
                                    <?= isset($sub->value) ? $sub->value : '' ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } elseif ($question->type == 'checkbox') { ?>
                <tr>
                    <td width="25%" style="vertical-align: top;"><?= strip_tags($question->name) ?></td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px solid black; vertical-align: top;">
                        <?php
                        $answer = isset($data_submission[$question->id]) ? $data_submission[$question->id] : '';
                        if (is_array($answer)) {
                            echo implode(', ', $answer);
                        } elseif (is_string($answer) && !empty($answer)) {
                            $decoded = json_decode($answer, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                echo implode(', ', $decoded);
                            } else {
                                echo $answer;
                            }
                        }
                        ?>
                    </td>
                </tr>
            <?php } elseif ($question->type == 'multiselect') { ?>
                <tr>
                    <td width="25%" style="vertical-align: top;"><?= strip_tags($question->name) ?></td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px solid black; vertical-align: top;">
                        <?php
                        $answer = isset($data_submission[$question->id]) ? $data_submission[$question->id] : '';
                        if (is_array($answer)) {
                            echo implode(', ', $answer);
                        } elseif (is_string($answer) && !empty($answer)) {
                            $decoded = json_decode($answer, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                echo implode(', ', $decoded);
                            } else {
                                echo $answer;
                            }
                        }
                        ?>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td width="25%" style="vertical-align: top;"><?= strip_tags($question->name) ?></td>
                    <td style="vertical-align: top;">:</td>
                    <td style="border-bottom: 1px solid black; vertical-align: top;">
                        <?php
                        $answer = isset($data_submission[$question->id]) ? $data_submission[$question->id] : '';
                        if (is_array($answer)) {
                            echo implode(', ', $answer);
                        } else {
                            echo $answer;
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>

    <br>
</body>

</html>