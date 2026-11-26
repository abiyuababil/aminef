<?php
$education_tabs = [
    'S1/D4' => [
        'slug' => 'S1_D4',
        'title' => 'S1 / D4',
        'study_level' => 'Bachelor',
        'badge_class' => 'label-info',
        'border_color' => '#17a2b8'
    ],
    'S2' => [
        'slug' => 'S2',
        'title' => 'S2',
        'study_level' => 'Master',
        'badge_class' => 'label-primary',
        'border_color' => '#337ab7'
    ],
    'S3' => [
        'slug' => 'S3',
        'title' => 'S3',
        'study_level' => 'Doctor',
        'badge_class' => 'label-success',
        'border_color' => '#28a745'
    ]
];
$education_group_data = isset($education_group_data) ? $education_group_data : [];
?>

<div class="property-education-group-options hide form-group" style="margin-top: 15px;">
    <!-- Hidden input to track deleted element IDs -->
    <input type="hidden" name="delete_education_group_options" id="delete_education_group_options" value="">

    <!-- Header & Quick Presets Toolbar -->
    <div class="panel panel-info" style="margin-bottom: 20px;">
        <div class="panel-heading" style="padding: 12px 15px;">
            <div class="row" style="display: flex; align-items: center; justify-content: space-between;">
                <div class="col-md-7">
                    <h4 style="margin: 0; font-size: 15px; font-weight: bold;">
                        Education Levels Configuration
                    </h4>
                    <p class="text-muted" style="margin: 4px 0 0 0; font-size: 12px;">
                        Configure fields for S1/D4 (Bachelor), S2 (Master), and S3 (Doctor). If applicant chooses S3, S1-S3 appear. If S2, S1-S2 appear. All shown groups are mandatory.
                    </p>
                </div>
                <div class="col-md-5 text-right">
                    <button type="button" class="btn btn-success btn-sm btn-load-standard-education" title="Pre-populate standard university fields across all degrees">
                        <i class="fa fa-magic"></i> Load Standard Fields
                    </button>
                    <button type="button" class="btn btn-default btn-sm btn-copy-s1-to-others" title="Copy all S1/D4 fields to S2 and S3">
                        <i class="fa fa-copy"></i> Copy S1 to S2 & S3
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body" style="padding: 15px;">
            <!-- Degree Tabs -->
            <ul class="nav nav-tabs" role="tablist" id="education-degree-tabs" style="margin-bottom: 15px;">
                <?php $tab_idx = 0; foreach ($education_tabs as $lvl_key => $lvl_meta): ?>
                    <li role="presentation" class="<?= $tab_idx === 0 ? 'active' : ''; ?>">
                        <a href="#edu-tab-<?= $lvl_meta['slug']; ?>" aria-controls="edu-tab-<?= $lvl_meta['slug']; ?>" role="tab" data-toggle="tab" style="font-weight: 600;">
                            <?= $lvl_meta['title']; ?>
                            <span class="label <?= $lvl_meta['badge_class']; ?>" style="margin-left: 5px; font-size: 10px;">
                                Level: <?= $lvl_meta['study_level']; ?>
                            </span>
                        </a>
                    </li>
                <?php $tab_idx++; endforeach; ?>
            </ul>

            <!-- Tab Panes -->
            <div class="tab-content">
                <?php $tab_idx = 0; foreach ($education_tabs as $lvl_key => $lvl_meta): ?>
                    <div role="tabpanel" class="tab-pane <?= $tab_idx === 0 ? 'active' : ''; ?>" id="edu-tab-<?= $lvl_meta['slug']; ?>">
                        <div class="alert alert-warning" style="padding: 8px 12px; margin-bottom: 15px; font-size: 12px;">
                            <i class="fa fa-info-circle"></i> Degree: <strong><?= $lvl_meta['title']; ?> (Level of Study: <?= $lvl_meta['study_level']; ?>)</strong>. Configure the fields that appear when this level is displayed to applicants.
                        </div>

                        <div class="education-group-element-items" id="education-element-items-<?= $lvl_meta['slug']; ?>" data-level="<?= $lvl_key; ?>">
                            <?php 
                            $no = 1;
                            foreach ($education_group_data as $idx_elem => $elem_data): 
                                if ($elem_data->which_option == $lvl_key):
                                    $element_options = json_decode($elem_data->options);
                            ?>
                                <fieldset id="edu-fieldset-<?= $lvl_meta['slug']; ?>-<?= $no; ?>" data-index="<?= $no; ?>" class="sub-education-group-element-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px; background: #fafafa;">
                                    <legend style="padding: 5px; font-size: 14px; font-weight: bold; border-bottom: 1px solid #eee; margin-bottom: 12px;">
                                        Element <?= $no; ?> 
                                        <a href="javascript:;" style="margin-left: 10px;" class="btn btn-danger btn-xs remove-education-fieldset" data-id="<?= $elem_data->id; ?>" data-fieldset="edu-fieldset-<?= $lvl_meta['slug']; ?>-<?= $no; ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </legend>

                                    <div class="form-group">
                                        <label>Property Name <span class="text-danger">*</span></label>
                                        <input class="form-control property-name" placeholder="eg: University Name / Major / GPA" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][property_name]" value="<?= htmlspecialchars($elem_data->property_name); ?>" required>
                                        <input type="hidden" class="property-id" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][property_id]" value="<?= $elem_data->id; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Property Type</label>
                                        <select class="form-control property-type" onchange="propertyTypeChanged(this, '.education-group-element-items')" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][property_type]">
                                            <?php if ($property_types): ?>
                                                <?php foreach ($property_types as $pt): 
                                                    if (get_active_country() != 'Indonesian' && $pt == 'test type') {
                                                        continue;
                                                    }
                                                    if (in_array($pt, ['radio group', 'multiple choice grid', 'element group', 'education group', 'declare', 'table schedule'])) {
                                                        continue;
                                                    }
                                                    $selected = ($pt == $elem_data->property_type) ? 'selected' : '';
                                                ?>
                                                    <option <?= $selected; ?> value="<?= $pt; ?>"><?= $pt; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <!-- Sub-element options (for select, radio, etc.) -->
                                    <div class="sub-element-options form-group <?= (!empty($element_options)) ? '' : 'hide'; ?>">
                                        <label>Options</label>
                                        <div class="sub-element-parent-options" style="position:relative">
                                            <?php if (!empty($element_options)): ?>
                                                <?php foreach ($element_options as $elem_opt): ?>
                                                    <div class="col-lg-12 opdt-education-group-item" style="padding-left:0; margin-bottom:5px;">
                                                        <div class="form-group property-option" style="position:relative; margin-bottom:5px;">
                                                            <input type="text" class="form-control option-sub-element" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][options][]" value="<?= htmlspecialchars($elem_opt); ?>">
                                                            <a href="javascript:;" onclick="del_option(this, 'opdt-education-group-item')" class="btn btn-danger btn-sm" style="position:absolute; top:0; right:0;"><i class="fa fa-trash fa-fw"></i></a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="col-lg-12 opdt-education-group-item" style="padding-left:0; margin-bottom:5px;">
                                                    <div class="form-group property-option" style="position:relative; margin-bottom:5px;">
                                                        <input type="text" class="form-control option-sub-element" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][options][]" value="">
                                                        <a href="javascript:;" onclick="del_option(this, 'opdt-education-group-item')" class="btn btn-danger btn-sm" style="position:absolute; top:0; right:0;"><i class="fa fa-trash fa-fw"></i></a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="btn btn-info btn-xs add-sub-element-option" onclick="addSubElementOption(this)"><i class="fa fa-plus"></i> Add Option</button>
                                    </div>

                                    <div class="row">
                                        <div class="form-group checkbox-inline">
                                            <label>Required?</label>
                                            <input class="required ml-2 mr-0 pr-0" type="checkbox" value="1" class="required" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][required]" <?= $elem_data->is_required == 1 ? "checked" : ""; ?>>
                                        </div>
                                        <div class="sub-element-other form-group checkbox-inline <?= ($elem_data->property_type == 'select') ? '' : 'hide'; ?>">
                                            <label>Have Other?</label>
                                            <input type="checkbox" value="1" class="other ml-2 mr-0 pr-0" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][have_other]" <?= $elem_data->have_other == 1 ? "checked" : ""; ?>>
                                        </div>
                                        <?php if (get_active_country() == 'Indonesian'): ?>
                                        <div class="sub-element-number form-group checkbox-inline <?= ($elem_data->property_type == 'input') ? '' : 'hide'; ?>">
                                            <label>Is Number Only?</label>
                                            <input type="checkbox" value="1" class="is_number_element ml-2 mr-0 pr-0" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][is_number]" <?= $elem_data->is_number == 1 ? "checked" : ""; ?>>
                                        </div>
                                        <div class="sub-element-validation form-group checkbox-inline <?= ($elem_data->property_type == 'input') ? '' : 'hide'; ?>">
                                            <label>Is Validation Score Test?</label>
                                            <input type="checkbox" value="1" class="is_score_test_element ml-2 mr-0 pr-0" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][is_score_test]" <?= !empty($elem_data->is_score_test) ? "checked" : ""; ?>>
                                        </div>
                                        <?php endif; ?>
                                        <div class="sub-element-trigger-notify form-group checkbox-inline <?= ($elem_data->property_type == 'file') ? '' : 'hide'; ?>">
                                            <label>Trigger Notify Finance?</label>
                                            <input type="checkbox" value="1" class="trigger_notify_finance ml-2 mr-0 pr-0" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][trigger_notify_finance]" <?= !empty($elem_data->trigger_notify_finance) ? "checked" : ""; ?>>
                                        </div>
                                        <div class="sub-element-trigger-ticket form-group checkbox-inline <?= ($elem_data->property_type == 'file') ? '' : 'hide'; ?>">
                                            <label>Trigger Ticket?</label>
                                            <input type="checkbox" value="1" class="trigger_notify_ticket_element ml-2 mr-0 pr-0" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][trigger_notify_ticket]" <?= !empty($elem_data->trigger_notify_ticket) ? "checked" : ""; ?> onchange="showCategoryEtaInFieldset(this)">
                                        </div>
                                        <div class="sub-element-trigger-alumni form-group checkbox-inline <?= ($elem_data->property_type == 'file') ? '' : 'hide'; ?>">
                                            <label>Trigger Set to Alumni?</label>
                                            <input type="checkbox" value="1" class="trigger_set_to_alumni ml-2 mr-0 pr-0" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][trigger_set_to_alumni]" <?= !empty($elem_data->trigger_set_to_alumni) ? "checked" : ""; ?>>
                                        </div>
                                        <div class="sub-element-limit form-group checkbox-inline <?= ($elem_data->property_type == 'text') ? '' : 'hide'; ?>">
                                            <label>Is Limit?</label>
                                            <input type="checkbox" value="1" class="is_limit_element ml-2 mr-0 pr-0" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][is_limit]" <?= $elem_data->is_limit == 1 ? "checked" : ""; ?> onchange="showLimitCharInFieldset(this)">
                                        </div>
                                    </div>

                                    <div class="sub-element-eta-category <?= ($elem_data->property_type == 'file' && !empty($elem_data->trigger_notify_ticket)) ? '' : 'hide'; ?> form-group col-md-12">
                                        <label class="label-category-eta">Select Category ETA Travel</label>
                                        <select class="form-control eta_category" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][eta_category]" style="width:30%">
                                            <option value="">- Select -</option>
                                            <?php if (!empty($categories_eta)): ?>
                                                <?php foreach ($categories_eta as $cat): ?>
                                                    <option <?= (!empty($elem_data->eta_category) && $elem_data->eta_category == $cat->id) ? 'selected' : ''; ?> value="<?= $cat->id ?>"><?= ucfirst(htmlspecialchars($cat->type ?? '', ENT_QUOTES, 'UTF-8')) ?> - <?= htmlspecialchars($cat->name ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="sub-element-note form-group col-md-12 <?= ($elem_data->property_type == 'file') ? '' : 'hide'; ?>" style="margin-left: -10px !important; margin-top:5px;">
                                        <label>Note / Helper Text</label>
                                        <textarea class="form-control editor" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][note]"><?= $elem_data->note; ?></textarea>
                                    </div>
                                    <!-- <div class="sub-element-validation-selection <?= in_array($elem_data->property_type, ['input', 'file']) ? '' : 'hide'; ?> form-group col-md-8" style="margin-left: -10px !important; margin-top:5px;">
                                        <label>Is fields in Validation Selection?</label>
                                        <select name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][validation_for_selection]" class="form-control is_validation_selection">
                                            <option value="">-- Select --</option>
                                            <option value="transcript" <?= (!empty($elem_data->validation_for_selection) && $elem_data->validation_for_selection == 'transcript') ? 'selected' : ''; ?>>Transcript</option>
                                            <option value="diploma" <?= (!empty($elem_data->validation_for_selection) && $elem_data->validation_for_selection == 'diploma') ? 'selected' : ''; ?>>Diploma</option>
                                        </select>
                                    </div> -->
                                    <div class="is_limit_char <?= ($elem_data->property_type == 'text' && $elem_data->is_limit == 1) ? '' : 'hide'; ?> form-group col-md-12" style="margin-left: -10px !important; margin-top:5px;">
                                        <label class="label-limit-element">Select Type Limit</label>
                                        <select class="form-control type_limit_char" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][type_limit_char]" style="width:30%">
                                            <option value="Character" <?= (!empty($elem_data->type_limit_char) && $elem_data->type_limit_char == 'Character') ? 'selected' : ''; ?>>Character</option>
                                            <option value="Word" <?= (!empty($elem_data->type_limit_char) && $elem_data->type_limit_char == 'Word') ? 'selected' : ''; ?>>Word</option>
                                        </select><br />
                                        <input type="text" value="<?= $elem_data->min_limit_char ?? ''; ?>" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][min_limit_char]" class="form-control min_limit_char" placeholder="Input Min Limit Characters" style="width:30%"><br />
                                        <input type="text" value="<?= $elem_data->limit_char ?? ''; ?>" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][limit_char]" class="form-control limit_char" placeholder="Input Max Limit Characters" style="width:30%">
                                    </div>
                                    <div class="col-md-12 element-group-validation-item" style="padding-left:0; padding-right:0;">
                                        <hr>
                                        <div class="form-group">
                                            <label class="label-check" for="edu_group_element_available_validation_<?= $lvl_meta['slug']; ?>_<?= $idx_elem; ?>">Is the field available in Selection Validation?</label>
                                            <input type="checkbox" value="1" id="edu_group_element_available_validation_<?= $lvl_meta['slug']; ?>_<?= $idx_elem; ?>" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][group_element_available_validation]" <?= !empty($elem_data->group_element_available_validation) ? "checked" : ""; ?> class="mrl group_element_available_validation_element">
                                        </div>
                                        <div class="form-group element-group-validation-field <?= !empty($elem_data->group_element_available_validation) ? '' : 'hide'; ?>">
                                            <label>Validation For</label>
                                            <select class="form-control property-from-validation" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][group_element_validation_for]">
                                                <option value="">-- Select Field --</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "toefl") ? "selected"  : ""?> value="toefl">Academic Test</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "test_score") ? "selected"  : ""?> value="test_score">Score Test</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "transcript") ? "selected"  : ""?> value="transcript">Transcript</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "diploma") ? "selected"  : ""?> value="diploma">Diploma</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "domisili") ? "selected"  : ""?> value="domisili">Domicile</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "gpa") ? "selected"  : ""?> value="gpa">GPA</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "institution") ? "selected"  : ""?> value="institution">Home Institution</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "host_institution") ? "selected"  : ""?> value="host_institution">Host Institution</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "city") ? "selected"  : ""?> value="city">Office City</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "fos") ? "selected"  : ""?> value="fos">Field of Study</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "lor") ? "selected"  : ""?> value="lor">Letter of Reference</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "major") ? "selected"  : ""?> value="major">Major</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "project_title") ? "selected"  : ""?> value="project_title">Project Title</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "cv") ? "selected"  : ""?> value="cv">Curriculum Vitae</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && $elem_data->group_element_validation_for == "email_recommendation") ? "selected"  : ""?> value="email_recommendation">Email Recommendation</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && in_array($elem_data->group_element_validation_for, ["prefix", "recommendation_prefix"])) ? "selected"  : ""?> value="prefix">Prefix</option>\n                                                <option <?= (!empty($elem_data->group_element_validation_for) && in_array($elem_data->group_element_validation_for, ["full_name", "recommendation_full_name"])) ? "selected"  : ""?> value="full_name">Full Name</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && in_array($elem_data->group_element_validation_for, ["relationship", "recommendation_relationship"])) ? "selected"  : ""?> value="relationship">Relationship</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && in_array($elem_data->group_element_validation_for, ["position", "position_title", "recommendation_position"])) ? "selected"  : ""?> value="position">Position / Title</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && in_array($elem_data->group_element_validation_for, ["contact", "recommendation_contact"])) ? "selected"  : ""?> value="contact">Contact</option>
                                                <option <?= (!empty($elem_data->group_element_validation_for) && in_array($elem_data->group_element_validation_for, ["institution_recommendation", "recommendation_institution"])) ? "selected"  : ""?> value="institution_recommendation">Institution Recommendation</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if (!empty($detail_grant->alumni_grant)) : ?>
                                    <div class="col-md-12" style="padding-left:0; padding-right:0;">
                                        <hr>
                                        <div class="form-group">
                                            <label style="margin-right:15px">Is the field available in alumni?</label>
                                            <input class="available_alumni_element" type="radio" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][available_alumni]" value="yes" <?= (!empty($elem_data->available_alumni) && $elem_data->available_alumni == "yes") ? "checked" : ""; ?> onchange="toggleAlumniFields(this)"> Yes
                                            <input class="available_alumni_element" type="radio" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][available_alumni]" value="no" <?= (empty($elem_data->available_alumni) || $elem_data->available_alumni == "no") ? "checked" : ""; ?> onchange="toggleAlumniFields(this)"> No
                                        </div>
                                        <div class="alumni-fields-container <?= (!empty($elem_data->available_alumni) && $elem_data->available_alumni == "yes") ? "" : "hide"; ?>">
                                            <div class="form-group">
                                                <label>Is Basic Information</label>
                                                <input type="checkbox" class="is_basic_element" value="1" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][is_basic]" <?= (!isset($elem_data->is_basic)) || $elem_data->is_basic == 1 ? "checked" : ""; ?> onchange="toggleBasicAlumniFields(this)">
                                            </div>
                                            <div class="form-group basic-field-select-container <?= (!isset($elem_data->is_basic)) || $elem_data->is_basic == 1 ? "" : "hide"; ?>">
                                                <label>Property Alumni (Basic)</label>
                                                <select class="form-control basic-fields-element" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][basic_fields]">
                                                    <?php foreach($basic_fields as $kbf => $vbf) :
                                                        $selected = (isset($elem_data->basic_fields) && $elem_data->basic_fields == $kbf) ? 'selected="selected"' : '';
                                                    ?>
                                                        <option value="<?= $kbf;?>" <?= $selected ?>><?= ucwords(str_replace("_", " ", $kbf)); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group custom-field-select-container <?= (isset($elem_data->is_basic) && $elem_data->is_basic == 0) ? "" : "hide"; ?>">
                                                <label>Property Alumni</label>
                                                <select class="form-control user-property-id-element" name="element_education_group_options[<?= $lvl_key; ?>][<?= $idx_elem; ?>][user_property_id]">
                                                    <option value="">- Select -</option>
                                                    <?php if ($program_properties) : ?>
                                                        <?php foreach ($program_properties as $pp) : ?>
                                                            <?php $selected = (isset($elem_data->user_property_id) && $elem_data->user_property_id == $pp->id) ? 'selected="selected"' : ''; ?>
                                                            <option value="<?= $pp->id ?>" <?= $selected ?>><?= $pp->field_name ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div style="clear:both;"></div>
                                </fieldset>
                            <?php 
                                    $no++;
                                endif;
                            endforeach; 
                            ?>
                        </div>

                        <div class="form-group" style="margin-top: 15px;">
                            <button class="btn btn-primary add-element-education-group" data-level="<?= $lvl_key; ?>" data-target="education-element-items-<?= $lvl_meta['slug']; ?>" type="button">
                                <i class="fa fa-plus"></i> Add Element to <?= $lvl_meta['title']; ?>
                            </button>
                        </div>
                    </div>
                <?php $tab_idx++; endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Template for adding an element dynamically -->
<div class="sample-education-group-element hide">
    <fieldset class="sub-education-group-element-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px; background: #fafafa;">
        <legend style="padding: 5px; font-size: 14px; font-weight: bold; border-bottom: 1px solid #eee; margin-bottom: 12px;">
            <span class="element-number">Element</span>
            <a href="javascript:;" style="margin-left: 10px;" class="btn btn-danger btn-xs remove-education-fieldset">
                <i class="fa fa-trash"></i>
            </a>
        </legend>
        <div class="form-group">
            <label>Property Name <span class="text-danger">*</span></label>
            <input class="form-control property-name" placeholder="eg: University Name / Major / GPA">
            <input type="hidden" class="property-id" value="">
        </div>
        <div class="form-group">
            <label>Property Type</label>
            <select class="form-control property-type" onchange="propertyTypeChanged(this, '.education-group-element-items')">
                <?php if ($property_types): ?>
                    <?php foreach ($property_types as $pt): 
                        if (get_active_country() != 'Indonesian' && $pt == 'test type') {
                            continue;
                        }
                        if (in_array($pt, ['radio group', 'multiple choice grid', 'element group', 'education group', 'declare', 'table schedule'])) {
                            continue;
                        }
                    ?>
                        <option value="<?= $pt; ?>"><?= $pt; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="sub-element-options hide form-group">
            <label>Options</label>
            <div class="sub-element-parent-options" style="position:relative">
                <div class="col-lg-12 opdt-education-group-item" style="padding-left:0; margin-bottom:5px;">
                    <div class="form-group property-option" style="position:relative; margin-bottom:5px;">
                        <input type="text" class="form-control option-sub-element" placeholder="Option value">
                        <a href="javascript:;" onclick="del_option(this, 'opdt-education-group-item')" class="btn btn-danger btn-sm" style="position:absolute; top:0; right:0;"><i class="fa fa-trash fa-fw"></i></a>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-info btn-xs add-sub-element-option" onclick="addSubElementOption(this)"><i class="fa fa-plus"></i> Add Option</button>
        </div>
        <div class="row">
            <div class="form-group checkbox-inline">
                <label>Required?</label>
                <input type="checkbox" value="1" class="required ml-2 mr-0 pr-0">
            </div>
            <div class="sub-element-other hide form-group checkbox-inline">
                <label>Have Other?</label>
                <input type="checkbox" value="1" class="other ml-2 mr-0 pr-0">
            </div>
            <?php if (get_active_country() == 'Indonesian'): ?>
            <div class="sub-element-number form-group checkbox-inline">
                <label>Is Number Only?</label>
                <input type="checkbox" value="1" class="is_number_element ml-2 mr-0 pr-0">
            </div>
            <div class="sub-element-validation form-group checkbox-inline">
                <label>Is Validation Score Test?</label>
                <input type="checkbox" value="1" class="is_score_test_element ml-2 mr-0 pr-0">
            </div>
            <?php endif; ?>
            <div class="sub-element-trigger-notify hide form-group checkbox-inline">
                <label>Trigger Notify Finance?</label>
                <input type="checkbox" value="1" class="trigger_notify_finance ml-2 mr-0 pr-0">
            </div>
            <div class="sub-element-trigger-ticket hide form-group checkbox-inline">
                <label>Trigger Ticket?</label>
                <input type="checkbox" value="1" class="trigger_notify_ticket_element ml-2 mr-0 pr-0" onchange="showCategoryEtaInFieldset(this)">
            </div>
            <div class="sub-element-trigger-alumni hide form-group checkbox-inline">
                <label>Trigger Set to Alumni?</label>
                <input type="checkbox" value="1" class="trigger_set_to_alumni ml-2 mr-0 pr-0">
            </div>
            <div class="sub-element-limit hide form-group checkbox-inline">
                <label>Is Limit?</label>
                <input type="checkbox" value="1" class="is_limit_element ml-2 mr-0 pr-0" onchange="showLimitCharInFieldset(this)">
            </div>
        </div>
        <div class="sub-element-eta-category hide form-group col-md-12">
            <label class="label-category-eta">Select Category ETA Travel</label>
            <select class="form-control eta_category" style="width:30%">
                <option value="">- Select -</option>
                <?php if (!empty($categories_eta)): ?>
                    <?php foreach ($categories_eta as $cat): ?>
                        <option value="<?= $cat->id ?>"><?= ucfirst(htmlspecialchars($cat->type ?? '', ENT_QUOTES, 'UTF-8')) ?> - <?= htmlspecialchars($cat->name ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="sub-element-note hide form-group col-md-12" style="margin-left: -10px !important; margin-top:5px;">
            <label>Note / Helper Text</label>
            <textarea class="form-control note"></textarea>
        </div>
        <!-- <div class="sub-element-validation-selection hide form-group col-md-8" style="margin-left: -10px !important; margin-top:5px;">
            <label>Is fields in Validation Selection?</label>
            <select class="form-control is_validation_selection">
                <option value="">-- Select --</option>
                <option value="transcript">Transcript</option>
                <option value="diploma">Diploma</option>
            </select>
        </div> -->
        <div class="is_limit_char hide form-group col-md-12">
            <label class="label-limit-element">Select Type Limit</label>
            <select class="form-control type_limit_char" style="width:30%">
                <option value="Character">Character</option>
                <option value="Word">Word</option>
            </select><br />
            <input type="text" class="form-control min_limit_char" placeholder="Input Min Limit Characters" style="width:30%"><br />
            <input type="text" class="form-control limit_char" placeholder="Input Max Limit Characters" style="width:30%">
        </div>
        <div class="col-md-12 element-group-validation-item">
            <hr>
            <div class="form-group">
                <label class="label-check">Is the field available in Selection Validation?</label>
                <input type="checkbox" value="1" class="mrl group_element_available_validation_element">
            </div>
            <div class="form-group element-group-validation-field hide">
                <label>Validation For</label>
                <select class="form-control property-from-validation">
                    <option value="">-- Select Field --</option>
                    <option value="toefl">Academic Test</option>
                    <option value="test_score">Score Test</option>
                    <option value="transcript">Transcript</option>
                    <option value="diploma">Diploma</option>
                    <option value="domisili">Domicile</option>
                    <option value="gpa">GPA</option>
                    <option value="institution">Home Institution</option>
                    <option value="host_institution">Host Institution</option>
                    <option value="city">Office City</option>
                    <option value="fos">Field of Study</option>
                    <option value="lor">Letter of Reference</option>
                    <option value="major">Major</option>
                    <option value="project_title">Project Title</option>
                    <option value="cv">Curriculum Vitae</option>
                    <option value="email_recommendation">Email Recommendation</option>
                    <option value="prefix">Prefix</option>\n                    <option value="full_name">Full Name</option>
                    <option value="relationship">Relationship</option>
                    <option value="position">Position / Title</option>
                    <option value="contact">Contact</option>
                </select>
            </div>
        </div>
        <?php if (!empty($detail_grant->alumni_grant)) : ?>
        <div class="col-md-12">
            <div class="form-group">
                <label style="margin-right:15px">Is the field available in alumni?</label>
                <input class="available_alumni_element" type="radio" value="yes" onchange="toggleAlumniFields(this)"> Yes
                <input class="available_alumni_element" type="radio" value="no" checked onchange="toggleAlumniFields(this)"> No
            </div>
            <div class="alumni-fields-container hide">
                <div class="form-group">
                    <label>Is Basic Information</label>
                    <input type="checkbox" class="is_basic_element" value="1" checked onchange="toggleBasicAlumniFields(this)">
                </div>
                <div class="form-group basic-field-select-container">
                    <label>Property Alumni (Basic)</label>
                    <select class="form-control basic-fields-element">
                        <?php foreach($basic_fields as $kbf => $vbf) : ?>
                            <option value="<?= $kbf;?>"><?= ucwords(str_replace("_", " ", $kbf)); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group custom-field-select-container hide">
                    <label>Property Alumni</label>
                    <select class="form-control user-property-id-element">
                        <option value="">- Select -</option>
                        <?php if ($program_properties) : ?>
                            <?php foreach ($program_properties as $pp) : ?>
                                <option value="<?= $pp->id ?>"><?= $pp->field_name ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div style="clear:both;"></div>
    </fieldset>
</div>
