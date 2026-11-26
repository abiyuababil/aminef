<?php
/**
 * ============================================================
 * REUSABLE VALIDATION RENDERER
 * ============================================================
 */
$render_validation = function (
    $title,
    $data,
    $validation_key,
    $note_key,
    $options = []
) use ($data_validation) {

    $is_file_only = isset($options['file_only']) ? $options['file_only'] : false;
    $full_label   = isset($options['full_label']) ? $options['full_label'] : false;
    ?>

    <div class="col-lg-8">
        <div class="form-group">
            <?php if ($title) : ?>
                <h3>
                    <label style="margin-right:20px">
                        <?= $title; ?>
                    </label>
                </h3>
                <br />
            <?php endif; ?>

            <?php if (!empty($data)) : ?>
                <?php foreach ($data as $group => $items) : ?>

                    <?php if (is_array($items)) : ?>
                        <?php if ($group !== 'section') : ?>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <h4>
                                        <strong>
                                            <?= htmlspecialchars($group); ?>
                                        </strong>
                                    </h4>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($items as $cf) : ?>

                            <?php
                            $values = $cf->value_custom_fields;

                            if (!is_array($values)) {
                                $values = [$values];
                            }
                            ?>


                            <?php if ($cf->type !== 'file') : ?>

                                <div class="row form-group">

                                    <?php if ($cf->type === 'separator') : ?>

                                        <div class="<?= $full_label ? 'col-md-12' : 'col-md-4'; ?> text-left">
                                            <b><?= $cf->name; ?></b>
                                        </div>

                                    <?php else : ?>

                                        <div class="<?= $full_label ? 'col-md-12' : 'col-md-4'; ?> text-left">
                                            <?= $cf->name; ?>
                                            <?= label_required($cf->is_required); ?>
                                        </div>

                                    <?php endif; ?>


                                    <div class="<?= in_array($cf->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">

                                        <?php foreach ($values as $value) : ?>

                                            <?php if ($value !== '' && $value !== null) : ?>

                                                <?= get_component($cf, 'disabled', $value); ?>

                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                    </div>

                                </div>


                            <?php else : ?>

                                <div class="row form-group">

                                    <div class="<?= $full_label ? 'col-lg-12' : 'col-lg-4'; ?>">
                                        <label>
                                            <?= $cf->name; ?>
                                        </label>
                                    </div>


                                    <div class="col-lg-8">

                                        <div class="row">

                                            <?php
                                            $total_files = count($values);
                                            ?>

                                            <?php foreach ($values as $index => $value) : ?>

                                                <?php
                                                $filename = get_filename_submission_element($value);
                                                $fileurl  = get_fileurl_sumbission_element($value);
                                                $strlen = $filename ? strlen($filename) : 0;
                                                $name_file = $filename;
                                                if ($strlen > 15) {
                                                    $name_file = substr($filename, 0, 15) . '....';
                                                }

                                                if (!$fileurl) {
                                                    continue;
                                                }
                                                ?>

                                                <div class="col-lg-6">

                                                    <?php if ($total_files > 1) : ?>
                                                        <p>
                                                            <strong>
                                                                Section <?= $index + 1; ?>
                                                            </strong>
                                                        </p>
                                                    <?php endif; ?>


                                                    <img
                                                        height="100"
                                                        width="100"
                                                        style="object-fit:contain;"
                                                        src="<?= get_preview($fileurl); ?>"
                                                    >

                                                    <a
                                                        href="<?= base_url($fileurl); ?>"
                                                        download
                                                        title="Click to download"
                                                        class="btn btn-primary btn-xs"
                                                        style="position:absolute;top:0;"
                                                    >
                                                        <i class="fa fa-download fa-fw text-white"></i>
                                                    </a>


                                                    <p
                                                        class="filename"
                                                        style="font-size:16px"
                                                        data-toggle="tooltip" data-placement="left" title="<?= $filename ?>"
                                                    >
                                                        <?= $name_file; ?>
                                                    </p>


                                                    <a
                                                        href="<?= base_url($fileurl); ?>"
                                                        class="btn btn-warning fileview lightbox"
                                                        style="color:#fff;display:inline-block;"
                                                        target="_blank"
                                                    >
                                                        <i class="fa fa-eye fa-fw"></i>
                                                        Preview
                                                    </a>

                                                    <hr>

                                                </div>

                                            <?php endforeach; ?>

                                        </div>

                                    </div>

                                </div>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <!--
                            Backward compatibility kalau masih ada
                            data lama yang bukan grouped.
                        -->
                        <?php $cf = $items; ?>

                    <?php endif; ?>

                <?php endforeach; ?>

            <?php endif; ?>


            <!-- VALIDATION -->
            <div class="form-group mt-3">

                <label>
                    <input
                        type="radio"
                        <?= $data_validation->$validation_key == 'valid' ? 'checked' : ''; ?>
                        class="grant-alumni"
                        name="<?= $validation_key; ?>"
                        style="margin-top:1px"
                        value="valid"
                    >
                    Valid
                </label>

                <label>
                    <input
                        type="radio"
                        <?= $data_validation->$validation_key == 'invalid' ? 'checked' : ''; ?>
                        class="grant-alumni"
                        name="<?= $validation_key; ?>"
                        style="margin-top:1px"
                        value="invalid"
                    >
                    Invalid
                </label>

            </div>


            <!-- NOTE -->
            <div class="row form-group mt-3">

                <div class="col-lg-4 text-left">
                    <label>Note</label>
                </div>

                <div class="col-lg-8">

                    <textarea
                        class="form-control"
                        name="<?= $note_key; ?>"
                    ><?= $data_validation->$note_key; ?></textarea>

                </div>

            </div>

        </div>

        <hr>
    </div>

<?php
};
?>

<div id="wrap-validation" class="warp-alumni-page">
    <div id="validation-item-0" class="validation-item" style="position:relative">
        <div class="panel-body">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> VALIDATION</p>
            <div class="col-lg-8">
                <div class="form-group">
                    <h3><label style="margin-right:20px">Academic Test</label></h3><br />
                        <?php $file = 0; ?>
                        <?php $row = "<div class='row form-group'>"; ?>
                        <?php 
                            $exitrow = "</div>"; 
                            $valid_academic_test = true;
                            $note_academic_test = '';
                            $test_type = '';
                            $score = 0;
                        ?>
                        <?php foreach ($toefl as $row => $cf) {
                            if($cf->type == 'element group'){
                                foreach($cf->sub_element as $kse => $vse){
                                    if ($vse->property_type == GRANTEE_CUSTOM_TEST_TYPE) {
                                        $test_type = get_row_db('am_user_grantee_period_score', ['test_type_id' => count($vse->value) > 0 ? $vse->value[0] : null, 'period_id' => $period_id]);
                                    }
                                    if ($vse->is_score_test) {
                                        $score = count($vse->value) > 0 ? $vse->value[0] : 0;
                                    }

                                }
                                    
                                if ($test_type->min_score > $score) {
                                    $valid_academic_test = false;
                                    $note_academic_test = 'Score under minimum requirement';
                                }

                            }else{
                                if ($cf->type == GRANTEE_CUSTOM_TEST_TYPE) {
                                    $test_type = get_row_db('am_user_grantee_period_score', ['test_type_id' => $cf->value_custom_fields, 'period_id' => $period_id]);
                                    $score = isset($test_score[$row]) ? $test_score[$row]->value_custom_fields : 0;
                                    
                                    if ($test_type->min_score > $score) {
                                        $valid_academic_test = false;
                                        $note_academic_test = 'Score under minimum requirement';
                                    }
                                }
                            }
                        ?>
                            <!-- template for others instead file template -->
                            <?php if ($cf->type != 'file') : ?>
                                <div class="row form-group">
                                    <?php if ($cf->type == 'separator') : ?>
                                        <div class="col-md-4 text-left"><b><?= $cf->name; ?></b></div>
                                    <?php else: ?>
                                        <div class="col-md-4 text-left"><?= $cf->name; ?><?= label_required($custom_fields->is_required); ?></div>
                                    <?php endif; ?>
                                    <div class="<?= in_array($cf->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                        <?php 
                                            echo get_component($cf, 'disabled', $cf->value_custom_fields);  
                                        ?> 
                                    </div>
                                </div>
                                                        
                                <?php if ($cf->is_multiple && $cf->type != 'radio group') { ?>
                                    <?php foreach ($cf->multiple_file as $kmf => $mf) { ?>
                                        
                                        <div class="multiple-item" style="margin-left: -15px;">
                                            <div class="<?= $cf->type == 'element group' ? 'col-md-12' : 'col-md-4' ?> text-left font-weight-bold">
                                                <?= url_text($mf->property_name); ?>
                                            </div>
                    
                                            <div class="<?php echo in_array($cf->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', NULL]) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                <!-- dapatkan data value dari customfield multiple -->
                                                <?php 
                                                $condition_custom_fields_value = [
                                                    'user_grantee_custom_fields_id' => $cf->id,
                                                    'user_grantee_grant_id' => $cf->user_grantee_grant_id,
                                                    'user_grantee_id' => $grantee_grant->user_grantee_id,
                                                    'user_grantee_period_id' => $grantee_grant->period_id,
                                                    'multiple_file_id' => $mf->id,
                                                    'grantee_grant_id' => $grantee_grant->id
                                                ];
                                                $value_custom_fields = get_all_db('am_user_grantee_submission', $condition_custom_fields_value);
                                                $sub_element = "";
                                                if ($cf->type == 'radio group' || $cf->type == 'element group'){
                                                    $sub_element = get_all_db('am_user_grantee_group_element', ['custom_fields_id' => $cf->id]);
                                                    $sub_element = array_map(function($data) use ($value_custom_fields){
                                                        $get_value = array_filter($value_custom_fields, function($value) use ($data){
                                                            return $value->group_element_id == $data->id;
                                                        });
                                                        $data->value = array_column($get_value, 'value');
                                                        $data->submission_id = array_column($get_value, 'id');
                                                        return $data;
                                                    }, $sub_element);
                                                    $value_custom_fields = array_filter($value_custom_fields, function ($value) { return $value->group_element_id == 0;});
                                                    $cf->sub_element = $sub_element;
                                                    $cf->multiple_file_id = $mf->id;
                                                }
                                                ?>
                                                <?= get_component($cf, 'disabled', $cf->value_custom_fields, true); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (isset($test_score[$row]) && $test_score[$row]->value_custom_fields) { ?>
                                    <div class="row form-group">
                                        <?php if ($test_score[$row]->type == 'separator') : ?>
                                            <div class="col-md-4 text-left"><b><?= $test_score[$row]->name; ?></b></div>
                                        <?php else: ?>
                                            <div class="col-md-4 text-left"><?= $test_score[$row]->name; ?><?= label_required($custom_fields->is_required); ?></div>
                                        <?php endif; ?>
                                        <div class="<?= in_array($test_score[$row]->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', 'radio', NULL, GRANTEE_CUSTOM_TEST_TYPE]) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                            <?php 
                                                echo get_component($test_score[$row], 'disabled', $test_score[$row]->value_custom_fields); 
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php else : ?>
                                <?php 
                                    if ($file == 3 || $toefl[$row + 1]->type == 'file') { 
                                        $file = 0; 
                                        $row="<div class='row form-group'>"; 
                                        $exitrow="</div>";
                                    }else{
                                        $row="<div class='row form-group'>"; 
                                        $exitrow="</div>";
                                    }
                                    $filename = get_filename_submission($cf); 
                                    $fileurl = get_fileurl_sumbission($cf); 
                                ?>
                                <?= $row; ?>
                                    <div class="col-lg-4">
                                        <label><?= $cf->name; ?></label>
                                        <div class="row">
                                            <?php if($fileurl != ''){ 
                                                    $display_file = 'inline-block'; 
                                                }else{
                                                    $display_file = 'none';
                                                }
                                            ?>
                                            <div class="col-lg-6">
                                                
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-lg-8">
                                        <p class="filename" style="font-size:16px"><?= $filename ?></p>
                                        <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:<?= $display_file ?>" target="_blank">
                                            <i class="fa fa-eye fa-fw"></i> Preview
                                        </a>
                                        <hr>
                                    </div>
                                <?= $exitrow; ?>
                            <?php $file++;endif; ?>
                        <?php } ?>
                    <div class="form-group">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->toefl ? ($data_validation->toefl == "valid" ? "checked" : "") : ($valid_academic_test ? "checked" : "" ) ?>
                                    class="grant-alumni" 
                                    name="toefl" 
                                    style="margin-top:1px" value="valid">
                                    Valid
                        </label>
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->toefl ? ($data_validation->toefl == "invalid" ? "checked" : "") : (!$valid_academic_test ? "checked" : "" ) ?>
                                    class="grant-alumni" 
                                    name="toefl" 
                                    style="margin-top:1px" 
                                    value="invalid">
                                    Invalid
                        </label>
                    </div>
                    
                    <div class="row form-group mt-3">
                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>
                        <div class="col-lg-8">
                            <textarea class="form-control" name="note_toefl"><?= $data_validation->note_toefl ? $data_validation->note_toefl : ( $note_academic_test ? $note_academic_test : '' )?></textarea>
                        </div>
                    </div>
                </div>  
                <hr>
            </div>
            <!-- <div class="col-lg-8">
                <div class="form-group">
                    <h3><label style="margin-right:20px">Essay (SO – PS)</label></h3><br />
                    <?php foreach ($essay as $row => $es) { ?>
                        <?php if ($es->type != 'file') : ?>
                            <div class="row form-group">
                                <?php if ($es->type == 'separator') : ?>
                                    <div class="col-md-4 text-left"><b><?= $es->name; ?></b></div>
                                <?php else: ?>
                                    <div class="col-md-4 text-left"><?= $es->name; ?><?= label_required($custom_fields->is_required); ?></div>
                                <?php endif; ?>
                                <div class="<?= in_array($es->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                    <?= get_component($es, 'disabled', $es->value_custom_fields); ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <?php 
                                if ($file == 3 || $toefl[$row + 1]->type == 'file') { 
                                    $file = 0; 
                                    $row="<div class='row form-group'>"; 
                                    $exitrow="</div>";
                                }else{
                                    $row="<div class='row form-group'>"; 
                                    $exitrow="</div>";
                                }
                                $filename = get_filename_submission($es); 
                                $fileurl = get_fileurl_sumbission($es); 
                            ?>
                            <?= $row; ?>
                                <div class="col-lg-4">
                                    <label><?= $es->name; ?></label>
                                    <div class="row">
                                        <?php if($fileurl != ''){ 
                                                $display_file = 'inline-block'; 
                                            }else{
                                                $display_file = 'none';
                                            }
                                        ?>
                                        <div class="col-lg-6">
                                            
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-lg-8">
                                    <p class="filename" style="font-size:16px"><?= $filename ?></p>
                                    <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:<?= $display_file ?>" target="_blank">
                                        <i class="fa fa-eye fa-fw"></i> Preview
                                    </a>
                                    <hr>
                                </div>
                            <?= $exitrow; ?>
                        <?php $file++;endif; ?>
                    <?php } ?>
                    <div class="radio d-inline mr-4">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->essay == "valid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="essay" 
                                    style="margin-top:1px" value="valid">
                                    Valid
                        </label>
                    </div>
                    <div class="radio d-inline">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->essay == "invalid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="essay" 
                                    style="margin-top:1px" 
                                    value="invalid">
                                    Invalid
                        </label>
                    </div>
                    <div class="row form-group mt-3">
                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>
                        <div class="col-lg-8">
                            <textarea class="form-control" name="note_essay"><?= $data_validation->note_essay?></textarea>
                        </div>
                    </div>
                </div>  
                <hr>
            </div> -->
            <!-- <div class="col-lg-8">
                <div class="form-group">
                    <h3><label style="margin-right:20px">Letter of Invitation/ Acceptance</label></h3><br />
                    <?php foreach ($letter_of_invitation as $row => $loa) { ?>
                        <?php if ($loa->type != 'file') : ?>
                            <div class="row form-group">
                                <?php if ($loa->type == 'separator') : ?>
                                    <div class="col-md-4 text-left"><b><?= $loa->name; ?></b></div>
                                <?php else: ?>
                                    <div class="col-md-4 text-left"><?= $loa->name; ?><?= label_required($custom_fields->is_required); ?></div>
                                <?php endif; ?>
                                <div class="<?= in_array($loa->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                    <?= get_component($loa, 'disabled', $loa->value_custom_fields); ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <?php 
                                if ($file == 3 || $toefl[$row + 1]->type == 'file') { 
                                    $file = 0; 
                                    $row="<div class='row form-group'>"; 
                                    $exitrow="</div>";
                                }else{
                                    $row="<div class='row form-group'>"; 
                                    $exitrow="</div>";
                                }
                                $filename = get_filename_submission($loa); 
                                $fileurl = get_fileurl_sumbission($loa); 
                            ?>
                            <?= $row; ?>
                                <div class="col-lg-4">
                                    <label><?= $loa->name; ?></label>
                                    <div class="row">
                                        <?php if($fileurl != ''){ 
                                                $display_file = 'inline-block'; 
                                            }else{
                                                $display_file = 'none';
                                            }
                                        ?>
                                        <div class="col-lg-6">
                                            
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-lg-8">
                                    <p class="filename" style="font-size:16px"><?= $filename ?></p>
                                    <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:<?= $display_file ?>" target="_blank">
                                        <i class="fa fa-eye fa-fw"></i> Preview
                                    </a>
                                    <hr>
                                </div>
                            <?= $exitrow; ?>
                        <?php $file++;endif; ?>
                    <?php } ?>
                    <div class="radio d-inline mr-4">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->letter_of_invitation == "valid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="loa" 
                                    style="margin-top:1px" value="valid">
                                    Valid
                        </label>
                    </div>
                    <div class="radio d-inline">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->letter_of_invitation == "invalid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="loa" 
                                    style="margin-top:1px" 
                                    value="invalid">
                                    Invalid
                        </label>
                    </div>
                    <div class="row form-group mt-3">
                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>
                        <div class="col-lg-8">
                            <textarea class="form-control" name="note_loa"><?= $data_validation->note_loa?></textarea>
                        </div>
                    </div>
                </div>  
                <hr>
            </div> -->

            <!-- =====================================================
                 TRANSCRIPT
                 ===================================================== -->

            <?php
            $render_validation(
                'Transcript',
                $transcript,
                'transcript',
                'note_transcript'
            );
            ?>


            <!-- =====================================================
                 DIPLOMA
                 ===================================================== -->

            <?php
            $render_validation(
                'Diploma',
                $diploma,
                'diploma',
                'note_diploma'
            );
            ?>

            <div class="col-lg-8">
                <div class="form-group">
                    <h3><label style="margin-right:20px">Domicile</label></h3><br />
                        <?php 
                            $user_grantee = current_grantee($grantee_grant->user_grantee_id); 
                            
                            $form_application_has_domicile = array_filter($domisili, function($domisili) {
                                return $domisili->validation_for == 'domisili' && $domisili->value_custom_fields;
                            });
                            
                            if (!$form_application_has_domicile) { 
                        ?>
                            <div class="row form-group mt-3">
                                <div class="col-lg-4 text-left">
                                    Country
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <select class="form-control" disabled>
                                            <option selected> 
                                                <?php 
                                                    $country_id = $user_grantee->residence_country ? $user_grantee->residence_country : $user_grantee->country;
                                                    $country = get_country_by_id($country_id);
                                                    echo $country ? $country->name : null; 
                                                ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mt-3">
                                <div class="col-lg-4 text-left">
                                    State
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <select class="form-control" disabled>
                                            <option selected> 
                                                <?php 
                                                    $state_id = $user_grantee->residence_country ? $user_grantee->residence_state : $user_grantee->provinci;
                                                    $state = get_state_by_id($state_id); 
                                                    echo $state ? $state->name : null;
                                                ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mt-3">
                                <div class="col-lg-4 text-left">
                                    City
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <select class="form-control" disabled>
                                            <option selected> 
                                                <?php 
                                                    $state_id = $user_grantee->residence_country ? $user_grantee->residence_city : $user_grantee->city;
                                                    $city = get_city_by_id($state_id);
                                                    echo $city ? $city->name : null; 
                                                ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mt-3">
                                <div class="col-lg-4 text-left">
                                    Street
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <input class="form-control" disabled value="<?php echo $user_grantee->residence_country ? $user_grantee->residence_street : $user_grantee->street; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mt-3">
                                <div class="col-lg-4 text-left">
                                    Postal Code
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <input class="form-control" disabled value="<?php echo $user_grantee->residence_country ? $user_grantee->residence_zipcode : $user_grantee->zipcode; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <?php $file = 0; ?>
                            <?php $row = "<div class='row form-group'>"; ?>
                            <?php $exitrow = "</div>"; ?>
                            <?php foreach ($domisili as $row => $cf) { ?>
                                <?php if ($cf->type != 'file') : ?>
                                    <div class="row form-group">
                                        <?php
                                                if ($cf->type == 'separator') : ?>
                                                <div class="col-md-4 text-left"><b><?php echo $cf->name; ?></b></div>
                                        <?php else: ?>
                                            <div class="col-md-4 text-left"><?php echo $cf->name; ?><?php echo label_required($custom_fields->is_required); ?></div>
                                        <?php endif; ?>
                                        <div class="<?php echo in_array($cf->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                            <?php 
                                                foreach($cf->value_custom_fields as $keyDom => $dom_value) { ?> 
                                                <?php if(count($cf->value_custom_fields) > 1) { ?>
                                                    <div class="row">
                                                        <div class="col-md-2 mt-3">Section <?php echo $keyDom + 1?></div>
                                                        <div class="col-md-10"><?php echo get_component($cf, 'disabled', $dom_value); ?> </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <?php echo get_component($cf, 'disabled', $dom_value); ?>
                                                        </div>
                                                    </div>
                                                    
                                                <?php } ?>
                                            <?php } ?> 
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php echo $row; ?>
                                        <div class="col-lg-4">
                                            <label><?php echo $cf->name; ?></label>
                                            <div class="row">
                                                <?php 
                                                    if($fileurl != ''){ 
                                                        $display_file = 'inline-block'; 
                                                    }else{
                                                        $display_file = 'none';
                                                    }
                                                ?>
                                                <div class="col-lg-6">
                                                    
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="col-lg-8">
                                        <?php 
                                            foreach($cf->value_custom_fields as $value) {
                                            $filename = get_filename_submission_element($value); 
                                            $fileurl = get_fileurl_sumbission_element($value); 
                                        ?>
                                        <div class="col-lg-6">
                                            <img height="100" width="100" style="object-fit:contain;" src="<?php echo get_preview($fileurl); ?>">
                                            <a href="<?php echo base_url($fileurl) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute;top:0; ">
                                                <i class="fa fa-download fa-fw text-white"></i>
                                            </a>
                                            <p class="filename" style="font-size:16px"><?php echo $filename ?></p>
                                            <a href="<?php echo base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:<?php echo $display_file ?>" target="_blank">
                                                <i class="fa fa-eye fa-fw"></i> Preview
                                            </a>
                                            <hr>
                                        </div>
                                        <?php } ?>
                                        </div>
                                    <?php echo $exitrow; ?>
                                <?php $file++;endif; ?>
                            <?php } ?>
                        <?php } ?>
                    <div class="form-group mt-3">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->domisili == "valid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="domisili" 
                                    style="margin-top:1px" value="valid">
                                    Valid
                        </label>
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->domisili == "invalid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="domisili" 
                                    style="margin-top:1px" 
                                    value="invalid">
                                    Invalid
                        </label>
                    </div>
                    <div class="row form-group mt-3">
                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>
                        <div class="col-lg-8">
                            <textarea class="form-control" name="note_domisili"><?= $data_validation->note_domisili?></textarea>
                        </div>
                    </div>
                </div>  
                <hr>
            </div>
            <div class="col-lg-8">
                <div class="form-group">
                    <h3><label style="margin-right:20px">GPA</label></h3><br />
                        <?php $index_separator = 1; foreach($gpa as $row) { ?>
                            <div class="row form-group">
                                <?php if ($row['custom_fields']->type == 'separator') { ?>
                                    <div class="col-md-12" <?php if ($index_separator > 1) { echo 'style="margin-top: 50px !important;"'; } ?>>
                                        <label><?php echo $row['custom_fields']->name . ' ' . $index_separator; ?></label>
                                        <?php $index_separator++; ?>
                                        <hr style="margin: 0px; padding: 0px;">
                                    </div>
                                <?php } else if ($row['custom_fields']->type != 'file') { ?>
                                    <div class="col-md-4 mt-3">
                                        <?php echo $row['custom_fields']->name; ?>
                                    </div>
                                    <div class="col-md-8"><?php echo get_component($row['custom_fields'], 'disabled', $row['value']); ?> </div>
                                <?php } else { ?>
                                    <?php 
                                        $row['custom_fields']->value_custom_fields = $row['value'];
                                        $filename = get_filename_submission($row['custom_fields']); 
                                        $fileurl = get_fileurl_sumbission($row['custom_fields']); 
                                    ?>
                                    <div class="col-lg-4">
                                        <?php echo $row['custom_fields']->name ?>
                                    </div>    
                                    <div class="col-lg-8">
                                        <img height="100" id="preview_image" style="margin-top:16px;" class="preview_image" src="<?php echo get_preview($fileurl); ?>">

                                        <p class="filename" style="font-size:16px"><?= $filename ?></p>
                                        <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:<?= $display_file ?>" target="_blank">
                                            <i class="fa fa-eye fa-fw"></i> Preview
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        
                        <!-- <?php //$file = 0; ?>
                        <?php //$row = "<div class='row form-group'>"; ?>
                        <?php //$exitrow = "</div>"; ?>
                        <?php //foreach ($gpa as $cf) {  ?>
                            <?php //if ($cf->type != 'file') : ?>
                                <div class="row form-group">
                                    <?php //if ($cf->type == 'separator') : ?>
                                        <div class="col-md-4 text-left"><b><?php // echo $cf->name; ?></b></div>
                                    <?php //else: ?>
                                        <div class="col-md-4 text-left"><?php // echo $cf->name; ?><?php // echo label_required($custom_fields->is_required); ?></div>
                                    <?php //endif; ?>
                                    <div class="<?= in_array($cf->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                        <div class="row">
                                            <div class="col-md-2 mt-3">Section <?php // echo $keyGpa + 1?></div>
                                            <div class="col-md-10"><?php // echo get_component($cf, 'disabled', $cf->value); ?> </div>
                                        </div>
                                    </div>
                                </div>
                            <?php // else : ?>
                                <?php 
                                    // if ($file == 3 || $gpa[$row + 1]->type == 'file') { 
                                    //     $file = 0; 
                                    //     $row="<div class='row form-group'>"; 
                                    //     $exitrow="</div>";
                                    // }else{
                                    //     $row="<div class='row form-group'>"; 
                                    //     $exitrow="</div>";
                                    // }
                                    // $filename = get_filename_submission($cf); 
                                    // $fileurl = get_fileurl_sumbission($cf); 
                                ?>
                                <?php //echo $row; ?>
                                    <div class="col-lg-4">
                                        <label><?php // echo $cf->name; ?></label>
                                        <div class="row">
                                            <?php 
                                            // if($fileurl != ''){ 
                                            //         $display_file = 'inline-block'; 
                                            //     }else{
                                            //         $display_file = 'none';
                                            //     }
                                            ?>
                                            <div class="col-lg-6">
                                                
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-lg-8">
                                        <?php //if(count($cf->value_custom_fields) > 1) { ?>
                                        <p>Section <?php // echo $keyrow + 1 ?></p>
                                        <?php //} ?>
                                        <p class="filename" style="font-size:16px"><?= $filename ?></p>
                                        <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:<?= $display_file ?>" target="_blank">
                                            <i class="fa fa-eye fa-fw"></i> Preview
                                        </a>
                                        <hr>
                                    </div>
                                <?php // echo $exitrow; ?>
                            <?php //$file++;endif; ?>
                        <?php //} ?> -->
                    <div class="form-group" style="margin-top: 50px !important;">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->gpa == "valid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="gpa" 
                                    style="margin-top:1px" value="valid">
                                    Valid
                        </label>
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->gpa == "invalid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="gpa" 
                                    style="margin-top:1px" 
                                    value="invalid">
                                    Invalid
                        </label>
                    </div>
                    <div class="row form-group mt-3">
                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>
                        <div class="col-lg-8">
                            <textarea class="form-control" name="note_gpa"><?= $data_validation->note_gpa?></textarea>
                        </div>
                    </div>
                </div>  
                <hr>
            </div>
            <div class="col-lg-8">
                <div class="form-group">
                    <h3><label style="margin-right:20px">Age</label></h3><br />
                    <div class="row form-group">
                        <div class="col-md-4 text-left">Age</div>
                        <div class="col-md-8 font-weight-bold">
                            <input type="text" class="form-control" value="<?= $age ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->age == "valid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="age" 
                                    style="margin-top:1px" value="valid">
                                    Valid
                        </label>
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->age == "invalid" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="age" 
                                    style="margin-top:1px" 
                                    value="invalid">
                                    Invalid
                        </label>
                    </div>
                    <div class="row form-group mt-3">
                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>
                        <div class="col-lg-8">
                            <textarea class="form-control" name="note_age"><?= $data_validation->note_age?></textarea>
                        </div>
                    </div>
                </div>  
                <hr>
            </div>
            
            <!-- =====================================================
                 LETTER OF REFERENCE
                 ===================================================== -->

            <?php
            $render_validation(
                'Letter of Reference',
                $lor,
                'letter_of_reference',
                'note_latter_of_reference'
            );
            ?>

            <div class="col-lg-8">
                <div class="form-group">
                    <h3><label style="margin-right:20px">Academic Status</label></h3><br />
                    <div class="radio d-inline mr-4">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->academic_status == "double_degree" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="academic_status" 
                                    style="margin-top:1px" value="double_degree">
                                    Double degree
                        </label>
                    </div>
                    <div class="radio d-inline mr-4">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->academic_status == "on_going_study" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="academic_status" 
                                    style="margin-top:1px" 
                                    value="on_going_study">
                                    On going Study
                        </label>
                    </div>
                    <div class="radio d-inline mr-4">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->academic_status == "high_school" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="academic_status" 
                                    style="margin-top:1px" 
                                    value="high_school">
                                    High School
                        </label>
                    </div>
                    <div class="radio d-inline mr-4">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->academic_status == "d3_completed" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="academic_status" 
                                    style="margin-top:1px" 
                                    value="d3_completed">
                                    D3 Completed
                        </label>
                    </div>
                    <div class="radio d-inline">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->academic_status == "s1_completed" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="academic_status" 
                                    style="margin-top:1px" 
                                    value="s1_completed">
                                    S1 Completed
                        </label>
                    </div>
                    <div class="radio d-inline">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->academic_status == "ss_completed" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="academic_status" 
                                    style="margin-top:1px" 
                                    value="ss_completed">
                                    S2 Completed
                        </label>
                    </div>
                    <div class="radio d-inline">
                        <label>
                            <input type="radio" 
                                    <?= $data_validation->academic_status == "s3_completed" ? "checked" : "" ?>
                                    class="grant-alumni" 
                                    name="academic_status" 
                                    style="margin-top:1px" 
                                    value="s3_completed">
                                    S3 Completed
                        </label>
                    </div>
                </div>  
            </div>
            <div class="col-lg-8">
                <div class="form-group">
                    <?php foreach($cv as $key => $letter) { ?>
                        <!-- template for others instead file template -->
                        <?php if ($letter->type != 'file') : ?>
                            <div class="row form-group">
                                <?php if ($letter->type == 'separator') : ?>
                                    <div class="col-md-12 text-left"><b><?= $letter->name; ?></b></div>
                                <?php else: ?>
                                    <div class="col-md-12 text-left"><?= $letter->name; ?><?= label_required($custom_fields->is_required); ?></div>
                                <?php endif; ?>
                                <div class="<?= in_array($letter->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                    <?php 
                                    foreach($cf->value_custom_fields as $dom_value) {
                                        echo get_component($cf, 'disabled', $dom_value);  
                                    }
                                    ?> 
                                </div>
                            </div>
                        <?php else : ?>
                            <?php 
                                if ($file == 3 || $toefl[$keyrow + 1]->type == 'file') { 
                                    $file = 0; 
                                    $row="<div class='row form-group'>"; 
                                    $exitrow="</div>";
                                }else{
                                    $row="<div class='row form-group'>"; 
                                    $exitrow="</div>";
                                }
                            ?>
                            <?= $row; ?>
                                <div class="col-lg-12">
                                    <label><?= $letter->name; ?></label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-lg-8">
                                    <?php 
                                        foreach($letter->value_custom_fields as $keyrowv => $value_transkrip) {
                                        $filename = get_filename_submission_element($value_transkrip); 
                                        $fileurl = get_fileurl_sumbission_element($value_transkrip); 
                                        
                                    ?>
                                    <div class="col-lg-6">
                                        <?php if(count($letter->value_custom_fields) > 1) { ?>
                                        <p>Section <?= $keyrowv + 1 ?></p>
                                        <?php } ?>
                                        <img height="100" width="100" style="object-fit:contain;" src="<?php echo get_preview($fileurl); ?>">
                                        <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute;top:0; ">
                                            <i class="fa fa-download fa-fw text-white"></i>
                                        </a>

                                        <p class="filename" style="font-size:16px"><?= $filename ?></p>
                                        <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:inline-block;" target="_blank">
                                            <i class="fa fa-eye fa-fw"></i> Preview
                                        </a>
                                        <hr>
                                    </div>
                                    <?php } ?>
                                </div>
                            <?= $exitrow; ?>
                        <?php $file++;endif; ?>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select id="status" class="form-control" style="width:100%" name="status_validation">
                        <option value="">-- Select Status -- </option>
                        <option value="1" <?= $grantee_grant->validation_status == 1 ? "selected" : "" ?>>Valid</option>
                        <option value="2" <?= $grantee_grant->validation_status == 2 ? "selected" : "" ?>>Invalid</option>
                    </select>
                    <!-- <input type="hidden" name="status_validation" id="status_validation"> -->
                </div>
                <div class="form-group">
                    <label>Note</label>
                    <textarea class="form-control" name="note_validation"><?= $data_validation->note_validation?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>