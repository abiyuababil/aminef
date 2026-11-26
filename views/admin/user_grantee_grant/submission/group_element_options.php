<?php
$detail_grant = isset($detail_grant) && is_object($detail_grant) ? $detail_grant : (object)['alumni_grant' => 0];
$program_properties = isset($program_properties) && is_array($program_properties) ? $program_properties : [];
$categories_eta = isset($categories_eta) && is_array($categories_eta) ? $categories_eta : [];
$basic_fields = isset($basic_fields) && is_array($basic_fields) ? $basic_fields : [];
$vendor_fields = isset($vendor_fields) && is_array($vendor_fields) && !empty($vendor_fields) ? $vendor_fields : [
    'name' => 'Vendor Name',
    'beneficiary_name' => 'Beneficiary Name',
    'address' => 'Address / Beneficiary Address',
    'bank_name' => 'Bank Name',
    'account_number' => 'Account Number',
    'bank_address' => 'Bank Address',
    'swift_code' => 'SWIFT Code',
    'routing_number' => 'Routing Number',
    'telp' => 'Telephone',
    'note' => 'Other Bank Details / Note'
];
?>
<div class="property-element-group-options hide form-group">
    <div class="parents-element-group-options" style="position:relative">
        <?php if (empty($radio_group_data)) { ?>
            <div class="element-item" data-index="1">
                <fieldset style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px; background: #fafafa;">
                    <!-- <legend style="padding: 5px; font-size: 14px; font-weight: bold; border-bottom: 1px solid #eee; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                    </legend> -->
                    <div style="display: flex; gap: 6px; justify-content:space-between">
                        <label class="element-title">Element 1</label>
                        <div class="element-actions" style="display: inline-flex; align-items: center; gap: 6px;">
                            <button type="button" data-tooltip="Move up" title="Move up" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_element_group_up(this)"><i class="fa fa-solid fa-arrow-up"></i></button>
                            <button type="button" data-tooltip="Move down" title="Move down" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_element_group_down(this)"><i class="fa fa-solid fa-arrow-down"></i></button>
                        </div>
                    </div>
                    <hr style="margin-top:10px !important;"/>

                    <div class="form-group col-md-6">
                        <label>Property Name</label>
                        <input class="form-control property-name" name="element_group_options[0][property_name]" placeholder="eg: Consulate / Airport">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Property Type</label>
                        <select class="form-control property-type" name="element_group_options[0][property_type]" onchange="propertyTypeChanged(this, '.element-item')">
                            <?php if ($property_types) { ?>
                                <?php
                                foreach ($property_types as $pt) {

                                    if (get_active_country() != 'Indonesian' && $pt == 'test type') {
                                        continue;
                                    }
                                ?>

                                    <?php if ($pt != 'radio group' && $pt != 'multiple choice grid' && $pt != 'element group') : ?>
                                        <option value="<?php echo $pt ?>"><?php echo $pt ?></option>
                                    <?php endif; ?>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row col-lg-12">
                        <div class="sub-element-options hide form-group">
                            <div class="sub-element-parent-options" style="position:relative">
                                <div class="col-lg-12 opdt-item" id="sub-element-option-1" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                                    <div class="form-group property-option" style="margin-bottom: 0;">
                                        <div style="display: flex; gap: 6px; align-items: center;">
                                            <input type="text" name="element_group_options[0][options][]" class="form-control option-sub-element">
                                            <!-- Move Up -->
                                            <button 
                                                type="button" 
                                                data-tooltip="Move up" 
                                                title="Move up"
                                                class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                onclick="move_option_up(this, 'opdt-item')">
                                                <i class="fa fa-solid fa-arrow-up"></i>
                                            </button>
                                            <!-- Move Down -->
                                            <button 
                                                type="button" 
                                                data-tooltip="Move down" 
                                                title="Move down"
                                                class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                onclick="move_option_down(this, 'opdt-item')">
                                                <i class="fa fa-solid fa-arrow-down"></i>
                                            </button>
                                            <!-- Delete -->
                                            <button 
                                                type="button" 
                                                data-tooltip="Delete" 
                                                title="Delete" 
                                                onclick="del_option(this, 'opdt-item')" 
                                                class="btn btn-danger rounded" 
                                                style="height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary add-sub-element-option" onclick="addSubElementOption(this)">Add</button>
                        </div>
                        <div class="form-group checkbox-inline">
                            <label>
                                Required?
                                <input type="checkbox" value="1" name="element_group_options[0][required]" class="required ml-2 mr-0 pr-0">
                            </label>
                        </div>
                        <div class="sub-element-other hide form-group checkbox-inline">
                            <label>
                                Have Other?
                                <input type="checkbox" value="1" name="element_group_options[0][have_other]" class="have_other ml-2 mr-0 pr-0">
                            </label>
                        </div>
                        <?php if (get_active_country() == 'American') { ?>
                        <div class="sub-element-trigger-notify form-group checkbox-inline">
                            <label>
                                Trigger Notify Finance?
                                <input type="checkbox" value="1" name="element_group_options[0][trigger_notify_finance]" class="trigger_notify_finance ml-2 mr-0 pr-0">
                            </label>
                        </div>
                        <div class="sub-element-trigger-ticket form-group checkbox-inline">
                            <label>
                                Trigger Ticket?
                                <input type="checkbox" value="1" name="element_group_options[0][trigger_notify_ticket]" class="trigger_notify_ticket_element ml-2 mr-0 pr-0" onchange="showCategoryEta(this, 0)">
                            </label>
                        </div>
                        <!-- <div class="sub-element-trigger-alumni form-group checkbox-inline">
                            <label>
                                Trigger Set to Alumni?
                                <input type="checkbox" value="1" name="element_group_options[0][trigger_set_to_alumni]" class="trigger_set_to_alumni ml-2 mr-0 pr-0">
                            </label>
                        </div> -->
                        <?php } ?>
                        <div class="sub-element-number checkbox-inline">
                            <label>
                                Is Number Only?
                                <input type="checkbox" value="1" name="element_group_options[0][is_number]" class="is_number_element ml-2 mr-0 pr-0">
                            </label>
                        </div>
                        <?php if (get_active_country() == 'Indonesian') { ?>
                            <div class="sub-element-validation checkbox-inline">
                                <label>
                                    Is Validation Score Test?
                                    <input type="checkbox" value="1" name="element_group_options[0][is_score_test]" class="is_score_test_element ml-2 mr-0 pr-0">
                                </label>
                            </div>
                        <?php } ?>
                        <div class="sub-element-limit form-group checkbox-inline">
                            <label>Is Limit?</label>
                            <input type="checkbox" value="1" name="element_group_options[0][is_limit]" class="mrl is_limit_element mr-2" onchange="showLimitChar(this, 0)">
                        </div>
                        <div class="sub-element-eta-category-0 hide form-group col-md-12">
                            <br />
                            <label class="label-category-eta">Select Category ETA Travel</label>
                            <select class="form-control" name="element_group_options[0][eta_category]" id="eta_category_0" style="width:30%">
                                <option value="">- Select -</option>
                                <?php if (!empty($categories_eta)): ?>
                                    <?php foreach ($categories_eta as $cat): ?>
                                        <option <?= $row->eta_category == $cat->id ? 'selected' : '' ?> value="<?= $cat->id ?>"><?= ucfirst(htmlspecialchars($cat->type ?? '', ENT_QUOTES, 'UTF-8')) ?> - <?= htmlspecialchars($cat->name ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="sub-element-note hide form-group col-md-12">
                            <label>Note</label>
                            <textarea class="form-control editor" name="element_group_options[0][note]"></textarea>
                        </div>
                        <!-- <div class="sub-element-validation-selection hide form-group col-md-8">
                            <label>Is fields in Validation Selection?</label>
                            <select name="element_group_options[0][validation_for_selection]" id="is_validation_element ml-2 mr-0 pr-0" class="form-control">
                                <option value="">-- Select --</option>
                                <option value="transcript">Transcript</option>
                                <option value="diploma">Diploma</option>
                            </select>
                        </div> -->
                        <div class="sub-element-limit-char-0 hide form-group col-md-12">
                            <br />
                            <label class="label-limit-element">Select Type Limit</label>
                            <select class="form-control" name="element_group_options[0][type_limit_char]" id="type_limit_char_0" style="width:30%">
                                <option value="Character" <?= $row->type_limit_char == 'Character' ? 'selected' : '' ?>>Character</option>
                                <option value="Word" <?= $row->type_limit_char == 'Word' ? 'selected' : '' ?>>Word</option>
                            </select><br />
                            <input type="text" value="<?= $row->min_limit_char ?>" name="element_group_options[0][min_limit_char]" id="min_limit_char_0" class="form-control" placeholder="Input Min Limit Characters" style="width:30%"><br />
                            <input type="text" value="<?= $row->limit_char ?>" name="element_group_options[0][limit_char]" id="limit_char_0" class="form-control" placeholder="Input Limit Characters" style="width:30%">
                        </div>
                    </div>
                    <?php if (get_active_country() == 'Indonesian') { ?>
                    <div class="col-md-12 element-group-validation-item">
                        <hr>
                        <div class="form-group">
                            <label class="label-check" for="group_element_available_validation_0">Is the field available in Selection Validation?</label>
                            <input type="checkbox" value="1" id="group_element_available_validation_0" name="element_group_options[0][group_element_available_validation]" <?= isset($row) && isset($row->group_element_available_validation) && $row->group_element_available_validation == 1 ? "checked" : "" ?> class="mrl group_element_available_validation_element">
                        </div>
                        <div class="form-group element-group-validation-field hide">
                            <label>Validation For</label>
                            <?php $group_element_validation_for = isset($this->User_grantee_property_model->group_element_validation_for) ? $this->User_grantee_property_model->group_element_validation_for : ''; ?>
                            <select class="form-control property-from-validation" name="element_group_options[0][group_element_validation_for]">
                                <option value="">-- Select Field --</option>
                                <option <?= $group_element_validation_for == "toefl" ? "selected"  : ""?> value="toefl">Academic Test</option>
                                <option <?= $group_element_validation_for == "test_score" ? "selected"  : ""?> value="test_score">Score Test</option>
                                <option <?= $group_element_validation_for == "transcript" ? "selected"  : ""?> value="transcript">Transcript</option>
                                <option <?= $group_element_validation_for == "diploma" ? "selected"  : ""?> value="diploma">Diploma</option>
                                <option <?= $group_element_validation_for == "domisili" ? "selected"  : ""?> value="domisili">Domicile</option>
                                <option <?= $group_element_validation_for == "gpa" ? "selected"  : ""?> value="gpa">GPA</option>
                                <option <?= $group_element_validation_for == "institution" ? "selected"  : ""?> value="institution">Home Institution</option>
                                <option <?= $group_element_validation_for == "host_institution" ? "selected"  : ""?> value="host_institution">Host Institution</option>
                                <option <?= $group_element_validation_for == "city" ? "selected"  : ""?> value="city">Office City</option>
                                <option <?= $group_element_validation_for == "fos" ? "selected"  : ""?> value="fos">Field of Study</option>
                                <option <?= $group_element_validation_for == "lor" ? "selected"  : ""?> value="lor">Letter of Reference</option>
                                <option <?= $group_element_validation_for == "major" ? "selected"  : ""?> value="major">Major</option>
                                <option <?= $group_element_validation_for == "project_title" ? "selected"  : ""?> value="project_title">Project Title</option>
                                <option <?= $group_element_validation_for == "cv" ? "selected"  : ""?> value="cv">Curriculum Vitae</option>
                                <option <?= $group_element_validation_for == "email_recommendation" ? "selected"  : ""?> value="email_recommendation">Email Recommendation</option>
                                <option <?= in_array($group_element_validation_for, ["prefix", "recommendation_prefix"]) ? "selected"  : ""?> value="prefix">Prefix</option>
                                <option <?= in_array($group_element_validation_for, ["full_name", "recommendation_full_name"]) ? "selected"  : ""?> value="full_name">Full Name</option>
                                <option <?= in_array($group_element_validation_for, ["relationship", "recommendation_relationship"]) ? "selected"  : ""?> value="relationship">Relationship</option>
                                <option <?= in_array($group_element_validation_for, ["position", "position_title", "recommendation_position"]) ? "selected"  : ""?> value="position">Position / Title</option>
                                <option <?= in_array($group_element_validation_for, ["contact", "recommendation_contact"]) ? "selected"  : ""?> value="contact">Contact</option>
                                <option <?= in_array($group_element_validation_for, ["institution_recommendation", "recommendation_institution"]) ? "selected"  : ""?> value="institution_recommendation">Institution Recommendation</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if (!empty($detail_grant->alumni_grant)) : ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label style="margin-right:15px">Is the field available in alumni?</label>
                            <input class="available_alumni_element" name="element_group_options[0][available_alumni]" type="radio" value="yes" onchange="toggleAlumniFields(this)"> Yes
                            <input class="available_alumni_element" name="element_group_options[0][available_alumni]" type="radio" value="no" checked onchange="toggleAlumniFields(this)"> No
                        </div>
                        <div class="alumni-fields-container">
                            <div class="form-group">
                                <label>Is Basic Information</label>
                                <input type="checkbox" name="element_group_options[0][is_basic]" class="is_basic_element" value="1" checked onchange="toggleBasicAlumniFields(this)">
                            </div>
                            <div class="form-group basic-field-select-container">
                                <label>Property Alumni (Basic)</label>
                                <select class="form-control basic-fields-element" name="element_group_options[0][basic_fields]">
                                    <?php foreach($basic_fields as $kbf => $vbf) : ?>
                                        <option value="<?= $kbf;?>"><?= ucwords(str_replace("_", " ", $kbf)); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group custom-field-select-container hide">
                                <label>Property Alumni</label>
                                <select class="form-control user-property-id-element" name="element_group_options[0][user_property_id]">
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
                    <div class="col-md-12">
                        <hr>
                        <div class="form-group">
                            <label style="margin-right:15px">Mapping to Master Data Vendor?</label>
                            <input class="available_vendor_element" name="element_group_options[0][available_vendor]" type="radio" value="yes" onchange="toggleVendorFields(this)"> Yes
                            <input class="available_vendor_element" name="element_group_options[0][available_vendor]" type="radio" value="no" checked onchange="toggleVendorFields(this)"> No
                        </div>
                        <div class="vendor-fields-container hide">
                            <div class="form-group">
                                <label>Target Vendor Field (Master Data)</label>
                                <select class="form-control vendor-field-element" name="element_group_options[0][vendor_field]">
                                    <option value="">- Select Target Field -</option>
                                    <?php foreach ($vendor_fields as $kvf => $vvf) : ?>
                                        <option value="<?= $kvf ?>"><?= $vvf ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        <?php } else { ?>
            <?php foreach ($radio_group_data as $key => $row) : ?>
                <?php $element_options = json_decode($row->options); ?>
                <div class="element-item mt-5" data-index="<?= $key + 1 ?>" id="field-element-<?= $key ?>">
                    <fieldset style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px; background: #fafafa;">
                        <!-- <legend style="padding: 5px; font-size: 14px; font-weight: bold; border-bottom: 1px solid #eee; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                        </legend> -->
                        <div style="display: flex; gap: 6px; justify-content:space-between">
                            <label class="element-title">Element <?= $key + 1 ?></label>
                            <div class="element-actions" style="display: inline-flex; align-items: center; gap: 6px;">
                                <button type="button" data-tooltip="Move up" title="Move up" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_element_group_up(this)"><i class="fa fa-solid fa-arrow-up"></i></button>
                                <button type="button" data-tooltip="Move down" title="Move down" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_element_group_down(this)"><i class="fa fa-solid fa-arrow-down"></i></button>
                                <a href='javascript:;' class='btn btn-danger btn-xs remove-fieldset' data-id='<?= $row->id ?>' data-fieldset='field-element-<?= $key ?>' style="height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; border-radius: 4px;"><i class='fa fa-trash'></i></a>
                            </div>
                        </div>
                        <hr style="margin-top:10px !important;"/>

                        <div class="form-group col-md-6">
                            <label>Property Name</label>
                            <input class="form-control property-name" name="element_group_options[<?= $key ?>][property_name]" placeholder="eg: Consulate / Airport" value="<?= $row->property_name ?>">
                            <input type="hidden" class="form-control property-name" name="element_group_options[<?= $key ?>][property_id]" placeholder="eg: Consulate / Airport" value="<?= $row->id ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Property Type</label>
                            <select class="form-control property-type" name="element_group_options[<?= $key ?>][property_type]" onchange="propertyTypeChanged(this, '.element-item')">
                                <?php if ($property_types) { ?>
                                    <?php
                                    foreach ($property_types as $pt) {
                                        if (get_active_country() != 'Indonesian' && $pt == 'test type') {
                                            continue;
                                        }
                                    ?>
                                        <?php $selected = $pt == $row->property_type ? 'selected' : ''; ?>
                                        <?php if ($pt != 'radio group' && $pt != 'multiple choice grid' && $pt != 'element group') : ?>
                                            <option value="<?php echo $pt ?>" <?= $selected ?>><?php echo $pt ?></option>
                                        <?php endif; ?>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="row col-lg-12">
                            <?php if ($element_options) { ?>
                                <div class="sub-element-options form-group">
                                    <div class="sub-element-parent-options" style="position:relative">
                                        <?php foreach ($element_options as $index_option => $element_option) { ?>
                                            <div class="col-lg-12 opdt-item" id="sub-element-option-1" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                                                <div class="form-group property-option" style="margin-bottom: 0;">
                                                    <div style="display: flex; gap: 6px; align-items: center;">
                                                        <input type="text" name="element_group_options[<?= $key ?>][options][]" class="form-control option-sub-element" value="<?= htmlspecialchars($element_option, ENT_QUOTES, 'UTF-8') ?>">
                                                        <!-- Move Up -->
                                                        <button 
                                                            type="button" 
                                                            data-tooltip="Move up" 
                                                            title="Move up"
                                                            class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                            onclick="move_option_up(this, 'opdt-item')">
                                                            <i class="fa fa-solid fa-arrow-up"></i>
                                                        </button>
                                                        <!-- Move Down -->
                                                        <button 
                                                            type="button" 
                                                            data-tooltip="Move down" 
                                                            title="Move down"
                                                            class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                            onclick="move_option_down(this, 'opdt-item')">
                                                            <i class="fa fa-solid fa-arrow-down"></i>
                                                        </button>
                                                        <!-- Delete -->
                                                        <button 
                                                            type="button" 
                                                            data-tooltip="Delete" 
                                                            title="Delete" 
                                                            onclick="del_option(this, 'opdt-item')" 
                                                            class="btn btn-danger rounded" 
                                                            style="height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center;">
                                                            <i class="fa fa-trash fa-fw"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <button type="button" class="btn btn-primary add-sub-element-option" onclick="addSubElementOption(this)">Add</button>
                                </div>
                            <?php } else { ?>
                                <div class="sub-element-options hide form-group">
                                    <div class="sub-element-parent-options" style="position:relative">
                                        <div class="col-lg-12 opdt-item" id="sub-element-option-1" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                                            <div class="form-group property-option" style="margin-bottom: 0;">
                                                <div style="display: flex; gap: 6px; align-items: center;">
                                                    <input type="text" name="element_group_options[<?= $key ?>][options][]" class="form-control option-sub-element">
                                                    <!-- Move Up -->
                                                    <button 
                                                        type="button" 
                                                        data-tooltip="Move up" 
                                                        title="Move up"
                                                        class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                        onclick="move_option_up(this, 'opdt-item')">
                                                        <i class="fa fa-solid fa-arrow-up"></i>
                                                    </button>
                                                    <!-- Move Down -->
                                                    <button 
                                                        type="button" 
                                                        data-tooltip="Move down" 
                                                        title="Move down"
                                                        class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                        onclick="move_option_down(this, 'opdt-item')">
                                                        <i class="fa fa-solid fa-arrow-down"></i>
                                                    </button>
                                                    <!-- Delete -->
                                                    <button 
                                                        type="button" 
                                                        data-tooltip="Delete" 
                                                        title="Delete" 
                                                        onclick="del_option(this, 'opdt-item')" 
                                                        class="btn btn-danger rounded" 
                                                        style="height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center;">
                                                        <i class="fa fa-trash fa-fw"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary add-sub-element-option" onclick="addSubElementOption(this)">Add</button>
                                </div>
                            <?php } ?>
                            <div class="form-group checkbox-inline">
                                <label for="reg<?= $key ?>" class="label-check">Required?</label>
                                <input type="checkbox" value="1" id="reg<?= $key ?>" name="element_group_options[<?= $key ?>][required]" class="mrl required" <?= $row->is_required == 1 ? "checked" : "" ?>>
                            </div>
                            <div class="form-group checkbox-inline">
                                <label for="reg_other<?= $key ?>" class="label-check">Have Other?</label>
                                <input type="checkbox" value="1" id="reg_other<?= $key ?>" name="element_group_options[<?= $key ?>][have_other]" class="mrl have_other" <?= $row->have_other == 1 ? "checked" : "" ?>>
                            </div>
                            <div class="sub-element-trigger-notify <?= $row->property_type == 'file' ? '' : 'hide' ?> form-group checkbox-inline">
                                <label for="trigger_notify_finance<?= $key ?>" class="label-check">Trigger Notify Finance?</label>
                                <input type="checkbox" value="1" id="trigger_notify_finance<?= $key ?>" name="element_group_options[<?= $key ?>][trigger_notify_finance]" class="mrl trigger_notify_finance" <?= $row->trigger_notify_finance == 1 ? "checked" : "" ?>>
                            </div>
                            <div class="sub-element-trigger-ticket <?= $row->property_type == 'file' ? '' : 'hide' ?> form-group checkbox-inline">
                                <label for="trigger_notify_ticket<?= $key ?>" class="label-check">Trigger Ticket?</label>
                                <input type="checkbox" value="1" id="trigger_notify_ticket<?= $key ?>" name="element_group_options[<?= $key ?>][trigger_notify_ticket]" class="mrl trigger_notify_ticket_element" <?= $row->trigger_notify_ticket == 1 ? "checked" : "" ?> onchange="showCategoryEta(this, <?= $key ?>)">
                            </div>
                            <div class="sub-element-passport-dependent <?= $row->property_type == 'file' ? '' : 'hide' ?> form-group checkbox-inline">
                                <label for="passport_dependent<?= $key ?>" class="label-check">Passport Dependent?</label>
                                <input type="checkbox" value="1" id="passport_dependent<?= $key ?>" name="element_group_options[<?= $key ?>][passport_dependent]" class="mrl passport_dependent_element" <?= $row->passport_dependent == 1 ? "checked" : "" ?>>
                            </div>
                            <div class="sub-element-trigger-alumni <?= $row->property_type == 'file' ? '' : 'hide' ?> form-group checkbox-inline">
                                <label for="trigger_set_to_alumni<?= $key ?>" class="label-check">Trigger Set to Alumni?</label>
                                <input type="checkbox" value="1" id="trigger_set_to_alumni<?= $key ?>" name="element_group_options[<?= $key ?>][trigger_set_to_alumni]" class="mrl trigger_set_to_alumni" <?= $row->trigger_set_to_alumni == 1 ? "checked" : "" ?>>
                            </div>
                            <div class="sub-element-number <?= $row->property_type == 'input' ? '' : 'hide' ?> checkbox-inline">
                                <label class="label-check" for="ino<?= $key ?>">Is Number Only?</label>
                                <input type="checkbox" value="1" id="ino<?= $key ?>" name="element_group_options[<?= $key ?>][is_number]" <?= $row->is_number == 1 ? "checked" : "" ?> class="mrl is_number_element">
                            </div>
                            <?php if (get_active_country() == 'Indonesian') { ?>
                            <div class="sub-element-validation <?= $row->property_type == 'input' ? '' : 'hide' ?> checkbox-inline">
                                <label class="label-check" for="ivs<?= $key ?>">Is Validation Score Test?</label>
                                <input type="checkbox" value="1" id="ivs<?= $key ?>" name="element_group_options[<?= $key ?>][is_score_test]" <?= $row->is_score_test == 1 ? "checked" : "" ?> class="mrl is_score_test_element">
                            </div>
                            <?php } ?>
                            <div class="sub-element-eta-category-<?= $key ?> <?= ($row->property_type == 'file' && $row->trigger_notify_ticket == 1) ? '' : 'hide' ?> form-group col-md-12">
                                <br />
				                <label class="label-category-eta">Select Category ETA Travel</label>
                                <select class="form-control" name="element_group_options[<?= $key ?>][eta_category]" id="eta_category_<?= $key ?>" style="width:30%">
                                    <option value="">- Select -</option>
                                    <?php if (!empty($categories_eta)): ?>
                                        <?php foreach ($categories_eta as $cat): ?>
                                            <option <?= $row->eta_category == $cat->id ? 'selected' : '' ?> value="<?= $cat->id ?>"><?= ucfirst(htmlspecialchars($cat->type ?? '', ENT_QUOTES, 'UTF-8')) ?> - <?= htmlspecialchars($cat->name ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="sub-element-note <?= $row->property_type == 'file' ? '' : 'hide' ?> form-group col-md-12">
                                <label>Note</label>
                                <textarea class="form-control editor" name="element_group_options[<?= $key ?>][note]"><?= $row->note ?></textarea>
                            </div>
                            <!-- <div class="sub-element-validation-selection <?= $row->property_type == 'input' ? '' : 'hide' ?> form-group col-md-8">
                                <label>Is fields in Validation Selection?</label>
                                <select name="element_group_options[<?= $key ?>][validation_for_selection]" id="is_validation_element ml-2 mr-0 pr-0" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="transcript" <?= $row->validation_for_selection == 'transcript' ? 'selected' : '' ?>>Transcript</option>
                                    <option value="diploma" <?= $row->validation_for_selection == 'diploma' ? 'selected' : '' ?>>Diploma</option>
                                </select>
                            </div> -->
                            <div class="sub-element-limit <?= $row->property_type == 'text' ? '' : 'hide' ?> form-group checkbox-inline">
                                <label class="label-check" for="il<?= $key ?>">Is Limit?</label>
                                <input type="checkbox" id="il<?= $key ?>" value="1" name="element_group_options[<?= $key ?>][is_limit]" <?= $row->is_limit == 1 ? "checked" : "" ?> class="mrl is_limit_element mr-2" onchange="showLimitChar(this, <?= $key ?>)">
                            </div>
                            <div class="sub-element-limit-char-<?= $key ?> <?= ($row->property_type == 'text' && $row->is_limit == 1) ? '' : 'hide' ?> form-group col-md-12">
                                <br />
                                <label class="label-limit-element">Select Type Limit</label>
                                <select class="form-control" name="element_group_options[<?= $key ?>][type_limit_char]" id="type_limit_char_<?= $key ?>" style="width:30%">
                                    <option value="Character" <?= $row->type_limit_char == 'Character' ? 'selected' : '' ?>>Character</option>
                                    <option value="Word" <?= $row->type_limit_char == 'Word' ? 'selected' : '' ?>>Word</option>
                                </select><br />
                                <input type="text" value="<?= $row->min_limit_char ?>" name="element_group_options[<?= $key ?>][min_limit_char]" id="min_limit_char_<?= $key ?>" class="form-control" placeholder="Input Min Limit Characters" style="width:30%"><br />
                                <input type="text" value="<?= $row->limit_char ?>" name="element_group_options[<?= $key ?>][limit_char]" id="limit_char_<?= $key ?>" class="form-control" placeholder="Input Max Limit Characters" style="width:30%">
                            </div>
                        </div>
                        <?php if (get_active_country() == 'Indonesian') { ?>
                        <div class="col-md-12 element-group-validation-item">
                            <hr>
                            <div class="form-group">
                                <label class="label-check" for="group_element_available_validation_<?= $key ?>">Is the field available in Selection Validation?</label>
                                <input type="checkbox" value="1" id="group_element_available_validation_<?= $key ?>" name="element_group_options[<?= $key ?>][group_element_available_validation]" <?= $row->group_element_available_validation == 1 ? "checked" : "" ?> class="mrl group_element_available_validation_element">
                            </div>
                            <div class="form-group element-group-validation-field <?php echo $row->group_element_available_validation == 1 ? '' : 'hide' ?>">
                                <label>Validation For</label>
                                <select class="form-control property-from-validation" name="element_group_options[<?= $key ?>][group_element_validation_for]">
                                    <option value="">-- Select Field --</option>
                                    <option <?= $row->group_element_validation_for == "toefl" ? "selected"  : ""?> value="toefl">Academic Test</option>
                                    <option <?= $row->group_element_validation_for == "test_score" ? "selected"  : ""?> value="test_score">Score Test</option>
                                    <option <?= $row->group_element_validation_for == "transcript" ? "selected"  : ""?> value="transcript">Transcript</option>
                                    <option <?= $row->group_element_validation_for == "diploma" ? "selected"  : ""?> value="diploma">Diploma</option>
                                    <option <?= $row->group_element_validation_for == "domisili" ? "selected"  : ""?> value="domisili">Domicile</option>
                                    <option <?= $row->group_element_validation_for == "gpa" ? "selected"  : ""?> value="gpa">GPA</option>
                                    <option <?= $row->group_element_validation_for == "institution" ? "selected"  : ""?> value="institution">Home Institution</option>
                                    <option <?= $row->group_element_validation_for == "host_institution" ? "selected"  : ""?> value="host_institution">Host Institution</option>
                                    <option <?= $row->group_element_validation_for == "city" ? "selected"  : ""?> value="city">Office City</option>
                                    <option <?= $row->group_element_validation_for == "fos" ? "selected"  : ""?> value="fos">Field of Study</option>
                                    <option <?= $row->group_element_validation_for == "lor" ? "selected"  : ""?> value="lor">Letter of Reference</option>
                                    <option <?= $row->group_element_validation_for == "major" ? "selected"  : ""?> value="major">Major</option>
                                    <option <?= $row->group_element_validation_for == "project_title" ? "selected"  : ""?> value="project_title">Project Title</option>
                                    <option <?= $row->group_element_validation_for == "email_recommendation" ? "selected"  : ""?> value="email_recommendation">Email Recommendation</option>
                                    <option <?= in_array($row->group_element_validation_for, ["prefix", "recommendation_prefix"]) ? "selected"  : ""?> value="prefix">Prefix</option>\n                                    <option <?= in_array($row->group_element_validation_for, ["full_name", "recommendation_full_name"]) ? "selected"  : ""?> value="full_name">Full Name</option>
                                    <option <?= in_array($row->group_element_validation_for, ["relationship", "recommendation_relationship"]) ? "selected"  : ""?> value="relationship">Relationship</option>
                                    <option <?= in_array($row->group_element_validation_for, ["position", "position_title", "recommendation_position"]) ? "selected"  : ""?> value="position">Position / Title</option>
                                    <option <?= in_array($row->group_element_validation_for, ["contact", "recommendation_contact"]) ? "selected"  : ""?> value="contact">Contact</option>
                                    <option <?= in_array($row->group_element_validation_for, ["institution_recommendation", "recommendation_institution"]) ? "selected"  : ""?> value="institution_recommendation">Institution Recommendation</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-12">
                            <?php if (!empty($detail_grant->alumni_grant)) : ?>
                            <hr>
                            <div class="form-group">
                                <label style="margin-right:15px">Is the field available in alumni?</label>
                                <input class="available_alumni_element" type="radio" name="element_group_options[<?= $key ?>][available_alumni]" value="yes" <?= $row->available_alumni == "yes" ? "checked" : "" ?> onchange="toggleAlumniFields(this)"> Yes
                                <input class="available_alumni_element" type="radio" name="element_group_options[<?= $key ?>][available_alumni]" value="no" <?= $row->available_alumni == "no" || $row->available_alumni == "" ? "checked" : "" ?> onchange="toggleAlumniFields(this)"> No
                            </div>
                            <div class="alumni-fields-container <?= ($row->available_alumni == "yes") ? "" : "hide" ?>">
                                <div class="form-group">
                                    <label>Is Basic Information</label>
                                    <input type="checkbox" class="is_basic_element" value="1" name="element_group_options[<?= $key ?>][is_basic]" <?= (!isset($row->is_basic)) || $row->is_basic == 1 ? "checked" : "" ?> onchange="toggleBasicAlumniFields(this)">
                                </div>
                                <div class="form-group basic-field-select-container <?= (!isset($row->is_basic)) || $row->is_basic == 1 ? "" : "hide" ?>">
                                    <label>Property Alumni (Basic)</label>
                                    <select class="form-control basic-fields-element" name="element_group_options[<?= $key ?>][basic_fields]">
                                        <?php foreach($basic_fields as $kbf => $vbf) : 	
                                            $selected = (isset($row->basic_fields) && $row->basic_fields == $kbf) ? 'selected="selected"' : '';
                                        ?>
                                            <option value="<?= $kbf;?>" <?= $selected ?>><?= ucwords(str_replace("_", " ", $kbf)); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group custom-field-select-container <?= (isset($row->is_basic) && $row->is_basic == 0) ? "" : "hide" ?>">
                                    <label>Property Alumni</label>
                                    <select class="form-control user-property-id-element" name="element_group_options[<?= $key ?>][user_property_id]">
                                        <option value="">- Select -</option>
                                        <?php if ($program_properties) : ?>
                                            <?php foreach ($program_properties as $pp) : ?>
                                                <?php $selected = (isset($row->user_property_id) && $row->user_property_id == $pp->id) ? 'selected="selected"' : ''; ?>
                                                <option value="<?= $pp->id ?>" <?= $selected ?>><?= $pp->field_name ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="form-group">
                                <label style="margin-right:15px">Mapping to Master Data Vendor?</label>
                                <input class="available_vendor_element" type="radio" name="element_group_options[<?= $key ?>][available_vendor]" value="yes" <?= (isset($row->available_vendor) && $row->available_vendor == "yes") ? "checked" : "" ?> onchange="toggleVendorFields(this)"> Yes
                                <input class="available_vendor_element" type="radio" name="element_group_options[<?= $key ?>][available_vendor]" value="no" <?= (!isset($row->available_vendor) || $row->available_vendor == "no" || $row->available_vendor == "") ? "checked" : "" ?> onchange="toggleVendorFields(this)"> No
                            </div>
                            <div class="vendor-fields-container <?= (isset($row->available_vendor) && $row->available_vendor == "yes") ? "" : "hide" ?>">
                                <div class="form-group">
                                    <label>Target Vendor Field (Master Data)</label>
                                    <select class="form-control vendor-field-element" name="element_group_options[<?= $key ?>][vendor_field]">
                                        <option value="">- Select Target Field -</option>
                                        <?php foreach ($vendor_fields as $kvf => $vvf) : 
                                            $selected_vendor = (isset($row->vendor_field) && $row->vendor_field == $kvf) ? 'selected="selected"' : '';
                                        ?>
                                            <option value="<?= $kvf ?>" <?= $selected_vendor ?>><?= $vvf ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            <?php endforeach; ?>
        <?php } ?>
    </div>
    <button type="button" class="btn-primary btn add-element-group">Add Element</button>
    <input type="hidden" name="delete_element_group_options" id="delete_element_group_options">
</div>


<!-- hidden element -->
<div class="sample-element-group-element hide">
    <hr>
    <div class="element-item">
        <fieldset style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px; background: #fafafa;">
            <!-- <legend style="padding: 5px; font-size: 14px; font-weight: bold; border-bottom: 1px solid #eee; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
            </legend> -->
            <div style="display: flex; gap: 6px; justify-content:space-between">
                <label class="element-title"></label>
                <div class="element-actions" style="display: inline-flex; align-items: center; gap: 6px;">
                    <button type="button" data-tooltip="Move up" title="Move up" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_element_group_up(this)"><i class="fa fa-solid fa-arrow-up"></i></button>
                    <button type="button" data-tooltip="Move down" title="Move down" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_element_group_down(this)"><i class="fa fa-solid fa-arrow-down"></i></button>
                    <a href="javascript:;" class="btn btn-danger btn-xs remove-fieldset" style="height: 34px; line-height: 24px; padding: 4px 10px;"><i class="fa fa-trash"></i></a>
                </div>
            </div>
            <hr style="margin-top:10px !important;"/>

            <div class="form-group col-md-6">
                <label>Property Name</label>
                <input class="form-control property-name" placeholder="eg: Consulate / Airport">
            </div>
            <div class="form-group col-md-6">
                <label>Property Type</label>
                <select class="form-control property-type" onchange="propertyTypeChanged(this, '.element-item')">
                    <?php if ($property_types) { ?>
                        <?php
                        foreach ($property_types as $pt) {
                            if (get_active_country() != 'Indonesian' && $pt == 'test type') {
                                continue;
                            }
                        ?>
                            <?php if ($pt != 'radio group' && $pt != 'multiple choice grid' && $pt != 'element group') : ?>
                                <option value="<?php echo $pt ?>"><?php echo $pt ?></option>
                            <?php endif; ?>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="sub-element-options hide form-group">
                <div class="sub-element-parent-options" style="position:relative">
                    <div class="col-lg-12 opdt-item" id="sub-element-option-1" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                        <div class="form-group property-option" style="margin-bottom: 0;">
                            <label>Option</label>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                <input type="text" class="form-control option-sub-element">
                                <!-- Move Up -->
                                <button 
                                    type="button" 
                                    data-tooltip="Move up" 
                                    title="Move up"
                                    class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                    onclick="move_option_up(this, 'opdt-item')">
                                    <i class="fa fa-solid fa-arrow-up"></i>
                                </button>
                                <!-- Move Down -->
                                <button 
                                    type="button" 
                                    data-tooltip="Move down" 
                                    title="Move down"
                                    class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                    onclick="move_option_down(this, 'opdt-item')">
                                    <i class="fa fa-solid fa-arrow-down"></i>
                                </button>
                                <!-- Delete -->
                                <a href="javascript:;" onclick="del_option(this, 'opdt-item')" class="btn btn-danger" style="height: 34px; line-height: 20px; padding: 6px 12px;"><i class="fa fa-trash fa-fw"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary add-sub-element-option" onclick="addSubElementOption(this)">Add</button>
            </div>
            <div class="form-group checkbox-inline">
                <label>Required?</label>
                <input type="checkbox" value="1" class="mrl required mr-2">
            </div>
            <div class="sub-element-other checkbox-inline">
                <label>Have Other?</label>
                <input type="checkbox" value="1" class="mrl mr-2m other">
            </div>
            <div class="sub-element-trigger-notify checkbox-inline">
                <label>Trigger Notify Finance?</label>
                <input type="checkbox" value="1" class="mrl mr-2m trigger_notify_finance">
            </div>
            <div class="sub-element-trigger-ticket checkbox-inline">
                <label>Trigger Ticket?</label>
                <input type="checkbox" value="1" class="mrl mr-2m trigger_notify_ticket_element">
            </div>
            <div class="sub-element-passport-dependent checkbox-inline">
                <label>Passport Dependent?</label>
                <input type="checkbox" value="1" class="mrl mr-2m passport_dependent_element">
            </div>
            <div class="sub-element-trigger-alumni checkbox-inline">
                <label>Trigger Set to Alumni?</label>
                <input type="checkbox" value="1" class="mrl mr-2m trigger_set_to_alumni">
            </div>
            <div class="sub-element-number checkbox-inline">
                <label>Is Number Only?</label>
                <input type="checkbox" value="1" class="mrl is_number_element">
            </div>
            <?php if (get_active_country() == 'Indonesian') { ?>
                <div class="sub-element-validation checkbox-inline">
                    <label>Is Validation Score Test?</label>
                    <input type="checkbox" value="1" class="mrl is_score_test_element">
                </div>
            <?php } ?>
            <div class="sub-element-limit hide form-group checkbox-inline">
                <label>Is Limit?</label>
                <input type="checkbox" value="1" class="mrl is_limit_element mr-2">
            </div>
            <div class="sub-element-note hide form-group col-md-12">
                <label>Note</label>
                <textarea class="form-control note"></textarea>
            </div>
            <!-- <div class="sub-element-validation-selection hide form-group col-md-8">
                <label>Is fields in Validation Selection?</label>
                <select class="form-control is_validation_selection">
                    <option value="">-- Select --</option>
                    <option value="transcript">Transcript</option>
                    <option value="diploma">Diploma</option>
                </select>
            </div> -->
            <div class="is_limit_char hide form-group col-md-12">
                <br />
                <label class="label-limit-element">Select Type Limit</label>
                <select class="form-control" style="width:30%">
                    <option value="Character">Character</option>
                    <option value="Word">Word</option>
                </select><br />
                <input type="text" class="form-control min_limit_char" placeholder="Input Min Limit Characters" style="width:30%"><br />
                <input type="text" class="form-control limit_char" placeholder="Input Max Limit Characters" style="width:30%">
            </div>
            <?php if (get_active_country() == 'Indonesian') { ?>
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
                        <option value="prefix">Prefix</option>\n                        <option value="full_name">Full Name</option>
                        <option value="relationship">Relationship</option>
                        <option value="position">Position / Title</option>
                        <option value="contact">Contact</option>
                    </select>
                </div>
            </div>
            <?php } ?>
            <?php if (!empty($detail_grant->alumni_grant)) : ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label style="margin-right:15px">Is the field available in alumni?</label>
                    <input class="available_alumni_element" type="radio" value="yes" onchange="toggleAlumniFields(this)"> Yes
                    <input class="available_alumni_element" type="radio" value="no" checked onchange="toggleAlumniFields(this)"> No
                </div>
                <div class="alumni-fields-container">
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
            <div class="col-md-12">
                <hr>
                <div class="form-group">
                    <label style="margin-right:15px">Mapping to Master Data Vendor?</label>
                    <input class="available_vendor_element" type="radio" value="yes" onchange="toggleVendorFields(this)"> Yes
                    <input class="available_vendor_element" type="radio" value="no" checked onchange="toggleVendorFields(this)"> No
                </div>
                <div class="vendor-fields-container hide">
                    <div class="form-group">
                        <label>Target Vendor Field (Master Data)</label>
                        <select class="form-control vendor-field-element">
                            <option value="">- Select Target Field -</option>
                            <?php foreach ($vendor_fields as $kvf => $vvf) : ?>
                                <option value="<?= $kvf ?>"><?= $vvf ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>