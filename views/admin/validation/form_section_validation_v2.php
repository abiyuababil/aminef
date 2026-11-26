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

                    <?php
                    /*
                     * Kalau data dari get_validation_submission()
                     * sudah menggunakan:
                     *
                     * section -> S3 -> S2 -> S1/D4
                     */
                    ?>

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
                            /*
                             * Karena satu ID sudah digabung oleh
                             * get_validation_submission(), maka
                             * value_custom_fields berisi semua value.
                             */
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


                                                    <div style="position:relative;">

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

                                                    </div>


                                                    <p
                                                        class="filename"
                                                        style="font-size:16px"
                                                    >
                                                        <?= $filename; ?>
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

    <div
        id="validation-item-0"
        class="validation-item"
        style="position:relative"
    >

        <div class="panel-body">

            <p style="font-weight:bold;margin-bottom:25px;">
                <i
                    class="fa fa-circle mt-5"
                    style="color:#4da6ff;margin-right:5px;"
                ></i>
                VALIDATION
            </p>


            <!-- =====================================================
                 ACADEMIC TEST / TOEFL
                 ===================================================== -->

            <div class="col-lg-8">

                <div class="form-group">

                    <h3>
                        <label style="margin-right:20px">
                            Academic Test
                        </label>
                    </h3>

                    <br />

                    <?php
                    $valid_academic_test = true;
                    $note_academic_test  = '';
                    $test_type           = null;
                    $score               = 0;
                    ?>

                    <?php foreach ($toefl as $index => $cf) : ?>

                        <?php

                        /*
                         * Element group
                         */
                        if ($cf->type === 'element group') {

                            foreach ($cf->sub_element as $vse) {

                                if ($vse->property_type == GRANTEE_CUSTOM_TEST_TYPE) {

                                    $test_type = get_row_db(
                                        'am_user_grantee_period_score',
                                        [
                                            'test_type_id' => !empty($vse->value)
                                                ? $vse->value[0]
                                                : null,
                                            'period_id' => $period_id
                                        ]
                                    );
                                }

                                if ($vse->is_score_test) {
                                    $score = !empty($vse->value)
                                        ? $vse->value[0]
                                        : 0;
                                }
                            }


                            if ($test_type && $test_type->min_score > $score) {

                                $valid_academic_test = false;
                                $note_academic_test = 'Score under minimum requirement';
                            }


                        /*
                         * Normal field
                         */
                        } elseif ($cf->type == GRANTEE_CUSTOM_TEST_TYPE) {

                            $test_type = get_row_db(
                                'am_user_grantee_period_score',
                                [
                                    'test_type_id' => $cf->value_custom_fields,
                                    'period_id' => $period_id
                                ]
                            );

                            $score = isset($test_score[$index])
                                ? $test_score[$index]->value_custom_fields
                                : 0;


                            if ($test_type && $test_type->min_score > $score) {

                                $valid_academic_test = false;
                                $note_academic_test = 'Score under minimum requirement';
                            }
                        }

                        ?>


                        <?php if ($cf->type != 'file') : ?>

                            <div class="row form-group">

                                <?php if ($cf->type == 'separator') : ?>

                                    <div class="col-md-4 text-left">
                                        <b><?= $cf->name; ?></b>
                                    </div>

                                <?php else : ?>

                                    <div class="col-md-4 text-left">
                                        <?= $cf->name; ?>
                                        <?= label_required($cf->is_required); ?>
                                    </div>

                                <?php endif; ?>


                                <div class="<?= in_array($cf->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">

                                    <?= get_component(
                                        $cf,
                                        'disabled',
                                        $cf->value_custom_fields
                                    ); ?>

                                </div>

                            </div>


                            <?php if ($cf->is_multiple && $cf->type != 'radio group') : ?>

                                <?php foreach ($cf->multiple_file as $mf) : ?>

                                    <?php
                                    $conditions = [
                                        'user_grantee_custom_fields_id' => $cf->id,
                                        'user_grantee_grant_id' => $cf->user_grantee_grant_id,
                                        'user_grantee_id' => $grantee_grant->user_grantee_id,
                                        'user_grantee_period_id' => $grantee_grant->period_id,
                                        'multiple_file_id' => $mf->id,
                                        'grantee_grant_id' => $grantee_grant->id
                                    ];

                                    $multiple_values = get_all_db(
                                        'am_user_grantee_submission',
                                        $conditions
                                    );
                                    ?>


                                    <div
                                        class="multiple-item"
                                        style="margin-left:-15px;"
                                    >

                                        <div class="col-md-4 text-left font-weight-bold">
                                            <?= url_text($mf->property_name); ?>
                                        </div>

                                        <div class="col-md-8 font-weight-bold">

                                            <?= get_component(
                                                $cf,
                                                'disabled',
                                                $cf->value_custom_fields,
                                                true
                                            ); ?>

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            <?php endif; ?>


                            <?php if (
                                isset($test_score[$index]) &&
                                $test_score[$index]->value_custom_fields
                            ) : ?>

                                <?php $score_field = $test_score[$index]; ?>

                                <div class="row form-group">

                                    <div class="col-md-4 text-left">
                                        <?= $score_field->name; ?>
                                    </div>

                                    <div class="col-md-8 font-weight-bold">

                                        <?= get_component(
                                            $score_field,
                                            'disabled',
                                            $score_field->value_custom_fields
                                        ); ?>

                                    </div>

                                </div>

                            <?php endif; ?>


                        <?php else : ?>

                            <?php
                            $filename = get_filename_submission($cf);
                            $fileurl  = get_fileurl_sumbission($cf);
                            ?>

                            <div class="row form-group">

                                <div class="col-lg-4">
                                    <label><?= $cf->name; ?></label>
                                </div>

                                <div class="col-lg-8">

                                    <?php if ($filename) : ?>

                                        <p
                                            class="filename"
                                            style="font-size:16px"
                                        >
                                            <?= $filename; ?>
                                        </p>

                                    <?php endif; ?>


                                    <?php if ($fileurl) : ?>

                                        <a
                                            href="<?= base_url($fileurl); ?>"
                                            class="btn btn-warning fileview lightbox"
                                            style="color:#fff;"
                                            target="_blank"
                                        >
                                            <i class="fa fa-eye fa-fw"></i>
                                            Preview
                                        </a>

                                    <?php endif; ?>

                                    <hr>

                                </div>

                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>


                    <!-- Academic Test Validation -->
                    <?php
                    $saved_test_validation = $data_validation->toefl;
                    $is_test_valid = $saved_test_validation
                        ? $saved_test_validation == 'valid'
                        : $valid_academic_test;

                    $is_test_invalid = $saved_test_validation
                        ? $saved_test_validation == 'invalid'
                        : !$valid_academic_test;
                    ?>


                    <div class="form-group">

                        <label>
                            <input
                                type="radio"
                                <?= $is_test_valid ? 'checked' : ''; ?>
                                class="grant-alumni"
                                name="toefl"
                                style="margin-top:1px"
                                value="valid"
                            >
                            Valid
                        </label>

                        <label>
                            <input
                                type="radio"
                                <?= $is_test_invalid ? 'checked' : ''; ?>
                                class="grant-alumni"
                                name="toefl"
                                style="margin-top:1px"
                                value="invalid"
                            >
                            Invalid
                        </label>

                    </div>


                    <div class="row form-group mt-3">

                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>

                        <div class="col-lg-8">

                            <textarea
                                class="form-control"
                                name="note_toefl"
                            ><?= $data_validation->note_toefl ?: $note_academic_test; ?></textarea>

                        </div>

                    </div>

                </div>

                <hr>

            </div>


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


            <!-- =====================================================
                 DOMICILE
                 ===================================================== -->

            <div class="col-lg-8">

                <div class="form-group">

                    <h3>
                        <label style="margin-right:20px">
                            Domicile
                        </label>
                    </h3>

                    <br />

                    <?php
                    $user_grantee = current_grantee(
                        $grantee_grant->user_grantee_id
                    );

                    $has_domicile_submission = false;

                    foreach ($domisili as $group => $items) {

                        if (!is_array($items)) {
                            continue;
                        }

                        foreach ($items as $item) {

                            if (!empty($item->value_custom_fields)) {
                                $has_domicile_submission = true;
                                break 2;
                            }
                        }
                    }
                    ?>


                    <?php if (!$has_domicile_submission) : ?>

                        <?php
                        $country_id = $user_grantee->residence_country
                            ?: $user_grantee->country;

                        $state_id = $user_grantee->residence_country
                            ? $user_grantee->residence_state
                            : $user_grantee->provinci;

                        $city_id = $user_grantee->residence_country
                            ? $user_grantee->residence_city
                            : $user_grantee->city;

                        $country = get_country_by_id($country_id);
                        $state   = get_state_by_id($state_id);
                        $city    = get_city_by_id($city_id);

                        $street = $user_grantee->residence_country
                            ? $user_grantee->residence_street
                            : $user_grantee->street;

                        $zipcode = $user_grantee->residence_country
                            ? $user_grantee->residence_zipcode
                            : $user_grantee->zipcode;
                        ?>


                        <?php
                        $domicile_fields = [
                            'Country' => $country ? $country->name : '',
                            'State' => $state ? $state->name : '',
                            'City' => $city ? $city->name : '',
                            'Street' => $street,
                            'Postal Code' => $zipcode,
                        ];
                        ?>


                        <?php foreach ($domicile_fields as $label => $value) : ?>

                            <div class="row form-group mt-3">

                                <div class="col-lg-4 text-left">
                                    <?= $label; ?>
                                </div>

                                <div class="col-lg-8">

                                    <input
                                        class="form-control"
                                        disabled
                                        value="<?= htmlspecialchars($value); ?>"
                                    >

                                </div>

                            </div>

                        <?php endforeach; ?>


                    <?php else : ?>

                        <?php
                        $render_validation(
                            null,
                            $domisili,
                            'domisili',
                            'note_domisili'
                        );
                        ?>

                    <?php endif; ?>


                    <div class="form-group mt-3">

                        <label>
                            <input
                                type="radio"
                                <?= $data_validation->domisili == 'valid' ? 'checked' : ''; ?>
                                class="grant-alumni"
                                name="domisili"
                                style="margin-top:1px"
                                value="valid"
                            >
                            Valid
                        </label>

                        <label>
                            <input
                                type="radio"
                                <?= $data_validation->domisili == 'invalid' ? 'checked' : ''; ?>
                                class="grant-alumni"
                                name="domisili"
                                style="margin-top:1px"
                                value="invalid"
                            >
                            Invalid
                        </label>

                    </div>


                    <div class="row form-group mt-3">

                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>

                        <div class="col-lg-8">

                            <textarea
                                class="form-control"
                                name="note_domisili"
                            ><?= $data_validation->note_domisili; ?></textarea>

                        </div>

                    </div>

                </div>

                <hr>

            </div>


            <!-- =====================================================
                 GPA
                 ===================================================== -->

            <div class="col-lg-8">

                <div class="form-group">

                    <h3>
                        <label style="margin-right:20px">
                            GPA
                        </label>
                    </h3>

                    <br />

                    <?php
                    $separator_index = 1;
                    ?>

                    <?php foreach ($gpa as $gpa_row) : ?>

                        <?php
                        $cf    = $gpa_row['custom_fields'];
                        $value = $gpa_row['value'];
                        ?>


                        <?php if ($cf->type == 'separator') : ?>

                            <div
                                class="col-md-12"
                                style="<?= $separator_index > 1 ? 'margin-top:50px !important;' : ''; ?>"
                            >

                                <label>
                                    <?= $cf->name . ' ' . $separator_index; ?>
                                </label>

                                <hr style="margin:0;padding:0;">

                            </div>

                            <?php $separator_index++; ?>


                        <?php elseif ($cf->type != 'file') : ?>

                            <div class="row form-group">

                                <div class="col-md-4 mt-3">
                                    <?= $cf->name; ?>
                                </div>

                                <div class="col-md-8">

                                    <?= get_component(
                                        $cf,
                                        'disabled',
                                        $value
                                    ); ?>

                                </div>

                            </div>


                        <?php else : ?>

                            <?php
                            $cf->value_custom_fields = $value;

                            $filename = get_filename_submission($cf);
                            $fileurl  = get_fileurl_sumbission($cf);
                            ?>

                            <div class="row form-group">

                                <div class="col-lg-4">
                                    <?= $cf->name; ?>
                                </div>

                                <div class="col-lg-8">

                                    <?php if ($fileurl) : ?>

                                        <img
                                            height="100"
                                            style="margin-top:16px;"
                                            src="<?= get_preview($fileurl); ?>"
                                        >

                                        <p
                                            class="filename"
                                            style="font-size:16px"
                                        >
                                            <?= $filename; ?>
                                        </p>

                                        <a
                                            href="<?= base_url($fileurl); ?>"
                                            class="btn btn-warning fileview lightbox"
                                            style="color:#fff;"
                                            target="_blank"
                                        >
                                            <i class="fa fa-eye fa-fw"></i>
                                            Preview
                                        </a>

                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>


                    <div
                        class="form-group"
                        style="margin-top:50px !important;"
                    >

                        <label>
                            <input
                                type="radio"
                                <?= $data_validation->gpa == 'valid' ? 'checked' : ''; ?>
                                class="grant-alumni"
                                name="gpa"
                                style="margin-top:1px"
                                value="valid"
                            >
                            Valid
                        </label>

                        <label>
                            <input
                                type="radio"
                                <?= $data_validation->gpa == 'invalid' ? 'checked' : ''; ?>
                                class="grant-alumni"
                                name="gpa"
                                style="margin-top:1px"
                                value="invalid"
                            >
                            Invalid
                        </label>

                    </div>


                    <div class="row form-group mt-3">

                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>

                        <div class="col-lg-8">

                            <textarea
                                class="form-control"
                                name="note_gpa"
                            ><?= $data_validation->note_gpa; ?></textarea>

                        </div>

                    </div>

                </div>

                <hr>

            </div>


            <!-- =====================================================
                 AGE
                 ===================================================== -->

            <div class="col-lg-8">

                <div class="form-group">

                    <h3>
                        <label style="margin-right:20px">
                            Age
                        </label>
                    </h3>

                    <br />

                    <div class="row form-group">

                        <div class="col-md-4 text-left">
                            Age
                        </div>

                        <div class="col-md-8 font-weight-bold">

                            <input
                                type="text"
                                class="form-control"
                                value="<?= $age; ?>"
                                readonly
                            >

                        </div>

                    </div>


                    <div class="form-group mt-3">

                        <label>
                            <input
                                type="radio"
                                <?= $data_validation->age == 'valid' ? 'checked' : ''; ?>
                                class="grant-alumni"
                                name="age"
                                style="margin-top:1px"
                                value="valid"
                            >
                            Valid
                        </label>

                        <label>
                            <input
                                type="radio"
                                <?= $data_validation->age == 'invalid' ? 'checked' : ''; ?>
                                class="grant-alumni"
                                name="age"
                                style="margin-top:1px"
                                value="invalid"
                            >
                            Invalid
                        </label>

                    </div>


                    <div class="row form-group mt-3">

                        <div class="col-lg-4 text-left">
                            <label>Note</label>
                        </div>

                        <div class="col-lg-8">

                            <textarea
                                class="form-control"
                                name="note_age"
                            ><?= $data_validation->note_age; ?></textarea>

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


            <!-- =====================================================
                 ACADEMIC STATUS
                 ===================================================== -->

            <div class="col-lg-8">

                <div class="form-group">

                    <h3>
                        <label style="margin-right:20px">
                            Academic Status
                        </label>
                    </h3>

                    <br />

                    <?php
                    $academic_statuses = [
                        'double_degree'  => 'Double degree',
                        'on_going_study' => 'On going Study',
                        'high_school'    => 'High School',
                        'd3_completed'   => 'D3 Completed',
                        's1_completed'  => 'S1 Completed',
                        'ss_completed'  => 'S2 Completed',
                        's3_completed'  => 'S3 Completed',
                    ];
                    ?>


                    <?php foreach ($academic_statuses as $value => $label) : ?>

                        <div class="radio d-inline mr-4">

                            <label>

                                <input
                                    type="radio"
                                    <?= $data_validation->academic_status == $value ? 'checked' : ''; ?>
                                    class="grant-alumni"
                                    name="academic_status"
                                    style="margin-top:1px"
                                    value="<?= $value; ?>"
                                >

                                <?= $label; ?>

                            </label>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>


            <!-- =====================================================
                 CV
                 ===================================================== -->

            <?php
            $render_validation(
                null,
                $cv,
                'cv',
                'note_cv',
                [
                    'full_label' => true
                ]
            );
            ?>


            <!-- =====================================================
                 FINAL STATUS
                 ===================================================== -->

            <div class="col-lg-8">

                <div class="form-group">

                    <label>Status</label>

                    <select
                        id="status"
                        class="form-control"
                        style="width:100%"
                        name="status_validation"
                    >

                        <option value="">
                            -- Select Status --
                        </option>

                        <option
                            value="1"
                            <?= $grantee_grant->validation_status == 1 ? 'selected' : ''; ?>
                        >
                            Valid
                        </option>

                        <option
                            value="2"
                            <?= $grantee_grant->validation_status == 2 ? 'selected' : ''; ?>
                        >
                            Invalid
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>Note</label>

                    <textarea
                        class="form-control"
                        name="note_validation"
                    ><?= $data_validation->note_validation; ?></textarea>

                </div>

            </div>

        </div>

    </div>

</div>