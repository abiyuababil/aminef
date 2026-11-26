<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $document_title; ?></title>
</head>

<body>
    <?php if (isset($include_cover) && $include_cover) {
        $this->load->view('grantee/pdf/partials/cover');
    }
    ?>
    <?php if (!$hide_personal_and_contact) { ?>
        <table style="width: 100%;">
            <tr>
                <div style="position:absolute; right: 100px; top: 115px;">
                    <?php
                    $photo_url = FCPATH . $this->Grantee_ent_model->img_photo;
                    $path_info = pathinfo($photo_url);
                    $file_extension = isset($path_info['extension']) ? strtolower($path_info['extension']) : '';

                    if (in_array($file_extension, ['pdf']) || !file_exists($photo_url)) {
                        $photo_url = FCPATH . 'img/pass-foto.jpeg';
                    }
                    ?>
                    <img style="width: 3cm; height: 4cm; margin-left: -2000px !important;" src="<?php echo $photo_url; ?>">
                </div>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table style="width: 100%; text-align: center; padding-left: 100px; padding-right: 130px;">
            <tr>
                <td style="width: 100%; text-align: center;">
                    <h3 style="font-size: 16pt; text-transform: uppercase; margin-left: 1000px;">
                        <b>
                            FULBRIGHT <br> PRELIMINARY APPLICATION FORM
                        </b>
                    </h3>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; text-align: center; font-size:10pt;">
                    (PLEASE TYPE, DO NOT WRITE)
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
    <?php } ?>

    <table style="width: 100%;">
        <tr>
            <td style="border-bottom: 1px solid black; font-weight: bold; font-size: 12pt;">&nbsp; PERSONAL INFORMATION</td>
        </tr>
    </table>
    <br>
    <table style="width: 100%;">
        <tr style="padding: 0px;">
            <td style="background-color: #ddd; border: 1px solid black;" colspan="3">&nbsp; NAME</td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid black; font-size: 10pt; font-weight:bold;" colspan="3">&nbsp; Please provide your name as it appears on your ID (KTP/Passport)</td>
        </tr>
        <?php if (!$hide_personal_and_contact) { ?>
            <tr>
                <td width="25%" style="font-weight: bold;">&nbsp; Prefix</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:76%;"><?php echo $this->Grantee_ent_model->prefix_name ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td width="25%" style="font-weight: bold;">&nbsp; First/Given Name</td>
            <td>:</td>
            <td style="border-bottom: 1px solid black; width:76%;"><?php echo $this->Grantee_ent_model->first_name ?></td>
        </tr>
        <tr>
            <td width="25%" style="font-weight: bold;">&nbsp; Middle Name(s)</td>
            <td>:</td>
            <td style="border-bottom: 1px solid black; width:76%;"><?php echo $this->Grantee_ent_model->middle_name ?></td>
        </tr>
        <tr>
            <td width="25%" style="font-weight: bold;">&nbsp; Last/Family Name(s)</td>
            <td>:</td>
            <td style="border-bottom: 1px solid black; width:76%;"><?php echo $this->Grantee_ent_model->last_name ?></td>
        </tr>
    </table>
    <br>
    <?php if (!$hide_personal_and_contact) { ?>
        <table style="width: 100%;">
            <tr style="padding: 0px;">
                <td style="background-color: #ddd; border: 1px solid black;" colspan="3">&nbsp; BIOGRAPHICAL INFORMATION</td>
            </tr>
            <tr>
                <td width="35%">&nbsp; <b>Birthdate</b> (e.g. 01 May 1980) </td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:72%;"><?php echo ($this->Grantee_ent_model->birth_date) ? date('d M Y', strtotime($this->Grantee_ent_model->birth_date)) : '' ?></td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; City of Birth</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;">
                    <?php
                    if ($birth_cities) {
                        foreach ($birth_cities as $bc) {
                            $selected = '';
                            if ($this->Grantee_ent_model->birth_city == $bc->id) {
                                echo $bc->name;
                            }
                        }
                    }
                    ?></td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; State of Birth</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;">
                    <?php
                    if ($birth_states) {
                        foreach ($birth_states as $bt) {
                            $selected = '';
                            if ($this->Grantee_ent_model->birth_state == $bt->id) {
                                echo $bt->name;
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Country of Birth</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;">
                    <?php
                    if ($country_list) {
                        foreach ($country_list as $cl) {
                            $selected = '';
                            if ($this->Grantee_ent_model->birth_country == $cl->id) {
                                echo $cl->name;
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Sex</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black;">
                    <?php
                    if ($genders) {
                        foreach ($genders as $ge) {
                            $selected = '';
                            if ($this->Grantee_ent_model->gender == $ge) {
                                echo $ge;
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Physical Impairment </td>
                <td>:</td>
                <td style="border-bottom: 1px solid black;"><?php echo $this->Grantee_ent_model->physical_impairment ?></td>
            </tr>
            <tr>
                <td colspan="3">
                    &nbsp; The Fulbright Program complies with the Americans with Disabilities Act (the “ADA”) and is committed to
                    <br>
                    &nbsp; diversity and inclusion.
                    <br>
                    &nbsp; If you have any form of limitation that requires accommodation, please indicate that here. This information
                    <br>
                    &nbsp; is gathered only for statistical purposes and to ensure appropriate accommodation at a prospective
                    <br>
                    &nbsp; host institution.
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <table style="width: 100%;">
            <tr style="padding: 0px;">
                <td style="background-color: #ddd; border: 1px solid black;" colspan="3">&nbsp; CITIZENSHIP INFORMATION</td>
            </tr>
            <tr>
                <td width="60%">&nbsp; <b>Country of Citizenship</b></td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:40%;">
                    <?php
                    if ($country_list) {
                        foreach ($country_list as $cl) {
                            $selected = '';
                            if ($this->Grantee_ent_model->citizen_country == $cl->id) {
                                echo $cl->name;
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="60%">&nbsp; <b>National Identification Number</b> (KTP/Passport) </td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:40%;">KTP <?php echo $this->Grantee_ent_model->number_identity ?> / Passport <?php echo empty($this->Grantee_ent_model->number_passport) ? '-' : $this->Grantee_ent_model->number_passport ?></td>
            </tr>
        </table>
        <br>
        <br>
        <table style="width: 100%;">
            <tr>
                <td style="border-bottom: 1px solid black; font-weight: bold; font-size: 10pt;">&nbsp; CONTACT INFORMATION</td>
            </tr>
        </table>
        <br>
        <table style="width: 100%;">
            <tr style="padding: 0px;">
                <td style="background-color: #ddd; border: 1px solid black;">&nbsp; ADDRESSES</td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="border-bottom: 1px solid black; font-size: 10pt; font-weight:bold;">&nbsp; Permanent Address (DO NOT TRANSLATE the address into English)</td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Country</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;">
                    <?php
                    if ($country_list) {
                        foreach ($country_list as $cl) {
                            $selected = '';
                            if ($this->Grantee_ent_model->country == $cl->id) {
                                echo $cl->name;
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Street</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black;"><?php echo $this->Grantee_ent_model->street ?></td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Province</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;">
                    <?php
                    if ($states) {
                        foreach ($states as $bt) {
                            $selected = '';
                            if ($this->Grantee_ent_model->provinci == $bt->id) {
                                echo $bt->name;
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; City</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;">
                    <?php
                    if ($cities) {
                        foreach ($cities as $bc) {
                            $selected = '';
                            if ($this->Grantee_ent_model->city == $bc->id) {
                                echo $bc->name;
                            }
                        }
                    }
                    ?></td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Postal Code</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black;"><?php echo $this->Grantee_ent_model->zipcode ?></td>
            </tr>
        </table>
        <br>
        <table style="width: 100%;">
            <tr style="padding: 0px;">
                <td style="background-color: #ddd; border: 1px solid black;">&nbsp; CURRENT STAY</td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="border-bottom: 1px solid black; font-size: 10pt; font-weight:bold;">&nbsp; Current Residence (DO NOT TRANSLATE the address into English)</td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Country</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;">
                    <?php
                    if ($country_list) {
                        foreach ($country_list as $cl) {
                            $selected = '';
                            if ($this->Grantee_ent_model->residence_country == $cl->id) {
                                echo $cl->name;
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Street</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black;"><?php echo $this->Grantee_ent_model->residence_street ?></td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Province</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;">
                    <?php
                    if ($residence_states) {
                        foreach ($residence_states as $bt) {
                            $selected = '';
                            if ($this->Grantee_ent_model->residence_state == $bt->id) {
                                echo $bt->name;
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; City</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;">
                    <?php
                    if ($residence_cities) {
                        foreach ($residence_cities as $bc) {
                            $selected = '';
                            if ($this->Grantee_ent_model->residence_city == $bc->id) {
                                echo $bc->name;
                            }
                        }
                    }
                    ?></td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Postal Code</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black;"><?php echo $this->Grantee_ent_model->residence_zipcode ?></td>
            </tr>
        </table>
        <br>
        <table style="width: 100%;">
            <tr style="padding: 0px;">
                <td style="background-color: #ddd; border: 1px solid black;">&nbsp; TELEPHONE NUMBERS</td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="border-bottom: 1px solid black; font-size: 10pt; font-weight:bold;" colspan="3">&nbsp; Please be sure to include the local code along with your number</td>
            </tr>
            <?php
            $phone_number = explode(',', $this->Grantee_ent_model->phone_number);
            if ($phone_number) {
                $i = 1;
                foreach ($phone_number as $key => $row) { ?>
                    <tr>
                        <td width="27%" style="font-weight: bold;">&nbsp; Cell Phone Number <?php echo $i; ?></td>
                        <td>:</td>
                        <td style="border-bottom: 1px solid black; width:71%;"><?php echo $row; ?></td>
                    </tr>

            <?php
                    $i++;
                }
            }
            ?>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Home Phone Number</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;"><?php echo $this->Grantee_ent_model->home_phone_number ?></td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Work Phone Number</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black;"><?php echo $this->Grantee_ent_model->work_phone_number ?></td>
            </tr>
        </table>
        <br>
        <table style="width: 100%;">
            <tr style="padding: 0px;">
                <td style="background-color: #ddd; border: 1px solid black;" colspan="3">&nbsp; EMAIL</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid black; font-size: 10pt;" colspan="3">
                    &nbsp; Please provide a primary and secondary e-mail address (e.g. professional, university, etc.) in case we <br>
                    &nbsp; have difficulties contacting you at the primary e-mail address. Please note that all system-generated <br>
                    &nbsp; messages will be sent to the primary e-mail address.
                </td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Primary</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black; width:71%;"><?php echo $this->Grantee_ent_model->primary_email ?></td>
            </tr>
            <tr>
                <td width="27%" style="font-weight: bold;">&nbsp; Secondary</td>
                <td>:</td>
                <td style="border-bottom: 1px solid black;"><?php echo $this->Grantee_ent_model->secondary_email ?></td>
            </tr>
        </table>
        <br>

        <?php if ($emergency) { ?>
            <table style="width: 100%;">
                <tr style="padding: 0px;">
                    <td style="background-color: #ddd; border: 1px solid black;">&nbsp; EMERGENCY CONTACT INFORMATION</td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td style="border-bottom: 1px solid black; font-size: 10pt;">
                        &nbsp; The individuals listed below may be contacted in the event of an emergency while undertaking <br>
                        &nbsp; activities related to this grant opportunity, including any possible travel required for interviews in <br>
                        &nbsp; Indonesia
                    </td>
                </tr>
            </table>
            <?php
            $i = 1;
            foreach ($emergency as $key => $row) { ?>
                <table style="width: 100%;">
                    <tr>
                        <td style="border-bottom: 1px solid black; font-size: 10pt;">
                            &nbsp; <b>Contact <?php echo $i;
                                                $i++; ?></b>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%;">
                    <tr>
                        <td width="27%" style="font-weight: bold;vertical-align:top;">&nbsp; First/Given Name</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black; width:71%;vertical-align:top;"><?= $row->first_name ?></td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold;">&nbsp; Middle Name</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black; width:71%;vertical-align:top;"><?= $row->middle_name ?></td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold;vertical-align:top;">&nbsp; Last/Family Name</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black;vertical-align:top;"><?= $row->last_name ?></td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold;vertical-align:top;">&nbsp; Country</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black; width:71%;vertical-align:top;">
                            <?php
                            if ($country_list) {
                                foreach ($country_list as $cl) {
                                    $selected = '';
                                    if ($row->country == $cl->id) {
                                        echo $cl->name;
                                    }
                                }
                            }
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold; vertical-align:top;">&nbsp; Street</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black; vertical-align:top;"><?= $row->street; ?></td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold; vertical-align:top;">&nbsp; City</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black; width:71%; vertical-align:top;">
                            <?php
                            if ($emergency_cities) {
                                foreach ($emergency_cities[$key] as $ct) {
                                    $selected = '';
                                    if ($row->city == $ct->id) {
                                        echo $ct->name;
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold;vertical-align:top;">&nbsp; Province</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black;vertical-align:top;">
                            <?php if ($emergency_states) {
                                foreach ($emergency_states[$key] as $st) {
                                    $selected = '';
                                    if ($row->provinci == $st->id) {
                                        echo $st->name;
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold; vertical-align:top;">&nbsp; Postal Code</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black; width:71%; vertical-align:top;"><?= $row->zipcode; ?></td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold; vertical-align:top;">&nbsp; Phone Number</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black; vertical-align:top;"><?= $row->phone_number ?></td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold; vertical-align:top;">&nbsp; E-Mail</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black; width:71%; vertical-align:top;"><?= $row->email ?></td>
                    </tr>
                    <tr>
                        <td width="27%" style="font-weight: bold; vertical-align:top;">&nbsp; Relationship to You</td>
                        <td style="vertical-align:top;">:</td>
                        <td style="border-bottom: 1px solid black; vertical-align:top;"><?= $row->relation ?></td>
                    </tr>
                </table>
                <br>
        <?php }
        } ?>
        <!-- end condition show or hide personal & contact info -->
    <?php } ?>

    <?php foreach ($submission_contents as $submission_content) { ?>

        <?php
        $has_text_question = array_reduce($submission_content['fields'], function ($carry, $field) {
            return $carry || ($field['type'] != 'file');
        }, false);
        ?>

        <?php if ($has_text_question) { ?>
            <table style="width: 100%;">
                <tr>
                    <td style="background-color: #ddd; border: 1px solid black; font-size: 10pt; padding-left: 10px; padding-top:2px; padding-bottom: 2px;"><?php echo $submission_content['section_label']; ?></td>
                </tr>
            </table>
            <?php if (!empty($submission_content['section_notes'])) { ?>
                <div style="font-size: 10pt; padding-left: 10px; padding-right: 10px; margin-top: -10px;"><?php echo $submission_content['section_notes']; ?></div>
            <?php } ?>

            <table style="width: 100%;">
                <?php  foreach ($submission_content['fields'] as $field) { ?>
                    <?php if($field['type'] == 'highlight') { continue; } ?>
                    <?php
                    $is_advanced_checkbox = false;
                    if (isset($field['is_advanced_checkbox']) && $field['is_advanced_checkbox']) {
                        $is_advanced_checkbox = true;
                    }

                    ?>
                    <?php if ($is_advanced_checkbox) { ?>
                        <?php
                        $has_parent = get_parent($field['parent_id']);
                        $has_child = has_child($field['id']);
                        ?>
                        <?php
                        $value = null;
                        if (!empty($field['value'])) {
                            $decoded = json_decode($field['value'], true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                $value = human_readable_list($decoded);
                            } else {
                                $value = $field['value'];
                            }
                        } 
                        
                        ?>
                        <?php if ($field['type'] == 'separator') { ?>
                            <?php
                            $childs = has_child_section($field['id']);
                            $child_has_value = false;
                            if ($childs) {
                                foreach ($childs as $child) {
                                    $has_value = array_filter($submission_content['fields'], function ($item) use ($child) {
                                        return $item['id'] == $child->id && !empty($item['value']);
                                    });
                                    if ($has_value) {
                                        $child_has_value = true;
                                    }
                                }
                            }

                            if ($child_has_value) {
                            ?>
                                <tr>
                                    <td style="border-bottom: 1px solid black; font-size: 10pt; font-weight: bold; padding-left: 10px;" colspan="3">
                                        <?php echo $field['name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding-left: 10px;">
                                        <h3 style="font-size: 10pt; font-weight: 500; padding-top: 2px;">
                                            <?php echo $field['notes']; ?>
                                        </h3>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($value) { ?>
                            <tr>
                                <td colspan="3" style="<?php echo $has_child && !$has_parent ? 'font-weight: bold;' : ''; ?> font-size: 10pt; padding-left:10px;">
                                    <?php echo $field['name'];  ?>
                                    <?php if (!empty($field['other_value_checkbox'])) {
                                        echo ' (' . $field['other_value_checkbox'] . ')';
                                    } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($field['type'] != 'file') { ?>
                            <?php if ($field['type'] == 'separator') { ?>
                                <!-- add space for second and next separator element  -->
                                <?php if (!$field['is_first_element']) { ?>
                                    <tr>
                                        <td style="font-size: 10pt; font-weight: bold;" colspan="3">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td style="border-bottom: 1px solid black; font-size: 10pt; font-weight: bold;" colspan="3">&nbsp; <?php echo $field['name']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding-left: 10px;">
                                        <h3 style="font-size: 10pt; font-weight: 500; padding-left: 10px; padding-top:2px; padding-bottom: 2px;"><?php echo $field['notes']; ?></h3>
                                    </td>
                                </tr>
                            <?php } else if($field['type'] == 'table schedule') {  ?>
                                <table style="width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 10px;">
                                    <tr>
                                        <?php foreach ($field['header'] as $header) { ?>
                                            <th style="border: 1px solid black; padding: 5px; text-align: left; background-color: #ddd;"><?php echo $header; ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php 
                                        $total_minutes_all = 0; 
                                        foreach ($field['value'] as $row) { ?>
                                        <tr>
                                            <?php 
                                                $header_keys = array_keys((array)$field['value'][0]); 

                                                $length_index = array_search('Length of Class (minutes)', $field['header']);
                                                $days_index   = array_search('Day(s) of the Week', $field['header']);

                                                $length_key = $header_keys[$length_index] ?? null;
                                                $days_key   = $header_keys[$days_index] ?? null;


                                                foreach ($row as $keycell => $cell) { 
                                            ?>
                                                <td style="border: 1px solid black; padding: 5px;"><?php echo is_array($cell) ? implode(', ', $cell) : $cell; ?></td>
                                            <?php } ?>
                                        </tr>

                                        <?php
                                            $minutes = ($length_key && isset($row->$length_key)) 
                                                ? (int)$row->$length_key 
                                                : 0;

                                            $days_count = ($days_key && isset($row->$days_key) && is_array($row->$days_key)) 
                                                ? count($row->$days_key) 
                                                : 0;

                                            $total_minutes_all += ($minutes * $days_count);
                                        ?>
                                    <?php } ?>
                                    <?php
                                        $total_hours = floor($total_minutes_all / 60);
                                        $remaining_minutes = $total_minutes_all % 60;
                                    ?>
                                    <tr>
                                        <td colspan="100%" style="border: 1px solid black; padding: 5px; text-align: center;"> Total : <?php echo $total_hours; ?> hours, <?php echo $remaining_minutes; ?> minutes</td>
                                    </tr>
                                </table>
                            <?php } else { ?>
                                <tr>
                                    <td width="27%" style="font-weight: bold; vertical-align:top;">
                                        <table>
                                            <tr>
                                                <td></td>
                                                <td style="font-weight: bold; font-size: 10pt;"><b><?php echo wordwrap($field['name'], 30, "\n", true); ?></b></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="1%" style="vertical-align:top;">:</td>
                                    <td style="border-bottom: 1px solid black; width:71%; font-size: 10pt; vertical-align:top;">
                                        <?php
                                        switch ($field['type']) {
                                            case 'input':
                                                $value = $field['value'];
                                                break;
                                            case 'city':
                                                $value = get_name_field_value($field['type'], $field['value']);
                                                break;
                                            case 'country':
                                                $value = get_name_field_value($field['type'], $field['value']);
                                                break;
                                            case 'state':
                                                $value = get_name_field_value($field['type'], $field['value']);
                                                break;
                                            case 'field of study':
                                                $value = get_name_field_value('study_fields_2', $field['value']);
                                                break;
                                            case 'parent field of study':
                                                $value = get_name_field_value('study_fields_2', $field['value']);
                                                break;
                                            case 'multiselect':
                                                if (!empty($field['value'])) {
                                                    $field_value = json_decode($field['value'], true);
                                                    $value = human_readable_list($field_value);
                                                } else {
                                                    $value = null;
                                                }

                                                break;
                                            case 'datetime':

                                                if (!empty($field['value']) && strtotime($field['value'])) {
                                                    $field_value = strtotime($field['value']);
                                                    $value = date('d M Y H:i:s', $field_value);
                                                } else {
                                                    $value = null;
                                                }
                                                break;
                                            case 'file':
                                                if (!empty($field['value'])) {
                                                    $file = json_decode($field['value'], true);
                                                    $value = str_replace('/', ' ', $field['name']) . ' - ' . $file['filename'];
                                                } else {
                                                    $value = null;
                                                }

                                                break;
                                            case 'checkbox':
                                                if (!empty($field['value'])) {
                                                    $field_values = json_decode($field['value'], true);
                                                    $value = human_readable_list($field_values);
                                                } else {
                                                    $value = null;
                                                }
                                                break;
                                            case 'radio group':
                                                if (!empty($field['value'])) {
                                                    $file = json_decode($field['value'], true);
                                                    if ($file && isset($file['filename'])) {
                                                        $value = str_replace('/', ' ', $field['name']) . ' - ' . $file['filename'];
                                                    } else {
                                                        $value = $field['value'];
                                                    }
                                                } else {
                                                    $value = $field['value'];
                                                }
                                                break;
                                            case 'test type':
                                                if (!empty($field['value'])) {
                                                    $value = get_test_type_name($field['value']);
                                                } else {
                                                    $value = null;
                                                }

                                                break;
                                            default:
                                                $value = $field['value'];
                                                break;
                                        }

                                        if (isset($field['have_other']) && $field['have_other'] && $field['other_value']) {
                                            $value = $field['other_value'];
                                        }

                                        echo $value;
                                        ?>
                                    </td>
                                </tr>
                                <?php if (!empty($field['notes'])) { ?>
                                    <tr>
                                        <td colspan="3" style="padding-left: 10px;">
                                            <h3 style="font-size: 10pt; font-weight: 500; padding-left: 10px; padding-top:2px; padding-bottom: 2px;"><?php echo $field['notes']; ?></h3>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        <?php } ?>
    <?php } ?>
</body>

</html>