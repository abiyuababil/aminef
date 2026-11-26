<?php if (!empty($options)){ $options = (array) $options; } 
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
<div class="property-radio-group-options hide form-group">
    <div class="parents-radio-group-option" style="position:relative">
        <?php if (empty($options)) { ?>
        <div class="card-element-option">
            <div class="opdt-radio-group-item">
                <div class="col-lg-12" id="opdt-radio-group-item-0" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                    <div class="form-group property-option" style="margin-bottom: 0;">
                        <label>Option</label>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <input type="text" name="radio_group_options[0][element]" data-index="0" class="form-control" value="">
                            <!-- Move Up -->
                            <button 
                                type="button" 
                                data-tooltip="Move up" 
                                title="Move up"
                                class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                onclick="move_radio_group_option_up(this)">
                                <i class="fa fa-solid fa-arrow-up"></i>
                            </button>
                            <!-- Move Down -->
                            <button 
                                type="button" 
                                data-tooltip="Move down" 
                                title="Move down"
                                class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                onclick="move_radio_group_option_down(this)">
                                <i class="fa fa-solid fa-arrow-down"></i>
                            </button>
                            <!-- Delete -->
                            <button 
                                type="button" 
                                data-tooltip="Delete" 
                                title="Delete" 
                                onclick="del_option(this, 'opdt-radio-group-item')" 
                                class="btn btn-danger rounded" 
                                style="height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa fa-trash fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="radio-group-element-item" id="element-item-1"></div>
                <div class="property-option">
                    <button class="btn-primary btn add-element-radio-group" data-which-option="opdt-radio-group-item-0" data-which-element="element-item-1" type="button">Add Element</button>
                </div>
            </div>
        </div><!-- /.card-element-option -->
        <?php } else { ?>
            <?php foreach($options as $key => $option) { ?>
                <div class="card-element-option">
                    <div class="opdt-radio-group-item">
                        <div class="col-lg-12" id="opdt-radio-group-item-<?= $key; ?>" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                            <div class="form-group property-option" style="margin-bottom: 0;">
                                <label>Option</label>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <input type="text" name="radio_group_options[<?= $key ?>][element]" data-index="<?= $key ?>" class="form-control" value="<?= $option->element ? htmlspecialchars($option->element, ENT_QUOTES, 'UTF-8') : ''; ?>">
                                    <!-- Move Up -->
                                    <button 
                                        type="button" 
                                        data-tooltip="Move up" 
                                        title="Move up"
                                        class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                        onclick="move_radio_group_option_up(this)">
                                        <i class="fa fa-solid fa-arrow-up"></i>
                                    </button>
                                    <!-- Move Down -->
                                    <button 
                                        type="button" 
                                        data-tooltip="Move down" 
                                        title="Move down"
                                        class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                        onclick="move_radio_group_option_down(this)">
                                        <i class="fa fa-solid fa-arrow-down"></i>
                                    </button>
                                    <!-- Delete -->
                                    <button 
                                        type="button" 
                                        data-tooltip="Delete" 
                                        title="Delete" 
                                        onclick="del_option(this, 'opdt-radio-group-item')" 
                                        class="btn btn-danger rounded" 
                                        style="height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-trash fa-fw"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="radio-group-element-item" id="element-item-<?= $key; ?>">
                            <?php $no = 1; ?>
                            <?php foreach($radio_group_data as $index_element => $element_data) { ?>
                                <?php $element_options = json_decode($element_data->options); ?>
                                <?php if ($element_data->which_option == $option->element){ ?>
                                    <fieldset id="fieldset-<?= $key; ?>-<?= $no; ?>" data-index="<?= $no; ?>" class="sub-radio-group-element-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px; background: #fff;">
                                        <!-- <legend style="padding: 5px; font-size: 14px; font-weight: bold; border-bottom: 1px solid #eee; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                                        </legend> -->
                                        <div style="display: flex; gap: 6px; justify-content:space-between">
                                            <label class="sub-element-title" style="display: flex;align-items: center;flex-direction: column-reverse;">Element <?= $no; ?></label>
                                            <div class="sub-element-actions" style="display: inline-flex; align-items: center; gap: 6px;">
                                                <button type="button" data-tooltip="Move up" title="Move up" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_sub_element_up(this)"><i class="fa fa-solid fa-arrow-up"></i></button>
                                                <button type="button" data-tooltip="Move down" title="Move down" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_sub_element_down(this)"><i class="fa fa-solid fa-arrow-down"></i></button>
                                                <a href='javascript:;' class='btn btn-danger btn-xs remove-fieldset' data-id='<?= $element_data->id ?>' data-fieldset='fieldset-<?= $key; ?>-<?= $no; ?>' style="height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; border-radius: 4px;"><i class='fa fa-trash'></i></a>
                                            </div>
                                        </div>
                                        <hr style="margin-top:10px !important;"/>
                                        
                                        <div class="form-group">
                                            <label>Property Name</label>
                                            <input class="form-control property-name" placeholder="eg: Consulate / Airport" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][property_name]" value="<?= $element_data->property_name; ?>">
                                            <input type="hidden" class="form-control property-name" name="element_radio_group_options[<?= $key ?>][<?= $index_element; ?>][property_id]" placeholder="eg: Consulate / Airport" value="<?= $element_data->id ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Property Type</label>
                                            <select class="form-control property-type" onchange="propertyTypeChanged(this)" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][property_type]">
                                                <?php if ($property_types){ ?>
                                                    <?php 
                                                        foreach ($property_types as $pt) { 
                                                        if (get_active_country() != 'Indonesian' && $pt == 'test type') {
                                                            continue;
                                                        } 
                                                    ?>
                                                        <?php $selected = $pt == $element_data->property_type ? 'selected' : ''; ?>
                                                        <?php if ($pt != 'radio group' && $pt != 'multiple choice grid' && $pt != 'element group') : ?>
                                                        <option <?= $selected; ?> value="<?php echo $pt ?>" ><?php echo $pt ?></option>
                                                        <?php endif; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                        <?php if ($element_options) { ?>
                                            <div class="sub-element-options form-group">
                                                <div class="sub-element-parent-options" style="position:relative">
                                                        <?php foreach($element_options as $index_option => $element_option) { ?>
                                                            <div class="col-lg-12 opdt-item opdt-radio-group-item" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                                                                <div class="form-group property-option" style="margin-bottom: 0;">
                                                                    <div style="display: flex; gap: 6px; align-items: center;">
                                                                        <input type="text" class="form-control option-sub-element" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][options][]" value="<?= htmlspecialchars($element_option, ENT_QUOTES, 'UTF-8') ?>">
                                                                        <!-- Move Up -->
                                                                        <button 
                                                                            type="button" 
                                                                            data-tooltip="Move up" 
                                                                            title="Move up"
                                                                            class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                                            onclick="move_option_up(this, 'opdt-radio-group-item')">
                                                                            <i class="fa fa-solid fa-arrow-up"></i>
                                                                        </button>
                                                                        <!-- Move Down -->
                                                                        <button 
                                                                            type="button" 
                                                                            data-tooltip="Move down" 
                                                                            title="Move down"
                                                                            class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                                            onclick="move_option_down(this, 'opdt-radio-group-item')">
                                                                            <i class="fa fa-solid fa-arrow-down"></i>
                                                                        </button>
                                                                        <!-- Delete -->
                                                                        <button 
                                                                            type="button" 
                                                                            data-tooltip="Delete" 
                                                                            title="Delete" 
                                                                            onclick="del_option(this, 'opdt-radio-group-item')" 
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
                                            <div class="sub-element-options form-group hide">
                                                <div class="sub-element-parent-options" style="position:relative">
                                                    <div class="col-lg-12 opdt-item opdt-radio-group-item" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                                                        <div class="form-group property-option" style="margin-bottom: 0;">
                                                            <div style="display: flex; gap: 6px; align-items: center;">
                                                                <input type="text" class="form-control option-sub-element" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][options][]" value="">
                                                                <!-- Move Up -->
                                                                <button 
                                                                    type="button" 
                                                                    data-tooltip="Move up" 
                                                                    title="Move up"
                                                                    class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                                    onclick="move_option_up(this, 'opdt-radio-group-item')">
                                                                    <i class="fa fa-solid fa-arrow-up"></i>
                                                                </button>
                                                                <!-- Move Down -->
                                                                <button 
                                                                    type="button" 
                                                                    data-tooltip="Move down" 
                                                                    title="Move down"
                                                                    class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                                                    onclick="move_option_down(this, 'opdt-radio-group-item')">
                                                                    <i class="fa fa-solid fa-arrow-down"></i>
                                                                </button>
                                                                <!-- Delete -->
                                                                <button 
                                                                    type="button" 
                                                                    data-tooltip="Delete" 
                                                                    title="Delete" 
                                                                    onclick="del_option(this, 'opdt-radio-group-item')" 
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
                                            <label>Required?</label>
                                            <input type="checkbox" value="1" class="required ml-2 mr-0 pr-0" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][required]" <?= $element_data->is_required == 1 ? "checked" : "" ?>>
                                        </div>
                                        <div class="sub-element-other hide form-group checkbox-inline">
                                            <label>Have Other?</label>
                                            <input type="checkbox" value="1" class="other ml-2 mr-0 pr-0" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][have_other]" <?= $element_data->have_other == 1 ? "checked" : "" ?>>
                                        </div>
                                        <?php if (get_active_country() == 'American') { ?>
                                        <div class="sub-element-trigger-notify checkbox-inline">
                                            <label>Trigger Notify Finance?</label>
                                            <input type="checkbox" value="1" class="trigger_notify_finance_element ml-2 mr-0 pr-0" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][trigger_notify_finance]" <?= $element_data->trigger_notify_finance == 1 ? "checked" : "" ?>>
                                        </div>
                                        <div class="sub-element-trigger-ticket checkbox-inline">
                                            <label>Trigger Ticket?</label>
                                            <input type="checkbox" value="1" class="trigger_notify_ticket_element ml-2 mr-0 pr-0" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][trigger_notify_ticket]" <?= $element_data->trigger_notify_ticket == 1 ? "checked" : "" ?>>
                                        </div>
                                        <div class="sub-element-passport-dependent checkbox-inline">
                                            <label>Passport Dependents?</label>
                                            <input type="checkbox" value="1" class="passport_dependent_element ml-2 mr-0 pr-0" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][passport_dependent]" <?= $element_data->passport_dependent == 1 ? "checked" : "" ?>>
                                        </div>
                                        <!-- <div class="sub-element-trigger-alumni col-md-2">
                                            <label>Trigger Set to Alumni?</label>
                                            <input type="checkbox" value="1" class="trigger_set_to_alumni_element" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][trigger_set_to_alumni]" <?= $element_data->trigger_set_to_alumni == 1 ? "checked" : "" ?>>
                                        </div> -->
                                        <?php if ($detail_grant->alumni_grant) : ?>
                                        <div class="col-md-12 element-alumni-options-container">
                                            <div class="form-group" style="display: block; margin-bottom: 10px;">
                                                <label style="margin-right:15px">Is the field available in alumni?</label>
                                                <input class="available_alumni_element" type="radio" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][available_alumni]" value="yes" <?= $element_data->available_alumni == "yes" || $element_data->available_alumni == "" ? "checked" : "" ?> onchange="toggleAlumniFields(this)"> Yes
                                                <input class="available_alumni_element" type="radio" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][available_alumni]" value="no" <?= $element_data->available_alumni == "no" ? "checked" : "" ?> onchange="toggleAlumniFields(this)"> No
                                            </div>
                                            <div class="alumni-fields-container <?= ($element_data->available_alumni == "yes" || $element_data->available_alumni == "") ? "" : "hide" ?>">
                                                <div class="form-group" style="display: block; margin-bottom: 10px;">
                                                    <label>Is Basic Information</label>
                                                    <input type="checkbox" class="is_basic_element ml-2 mr-0 pr-0" value="1" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][is_basic]" <?= (!isset($element_data->is_basic)) || $element_data->is_basic == 1 ? "checked" : "" ?> onchange="toggleBasicAlumniFields(this)">
                                                </div>
                                                <div class="form-group basic-field-select-container <?= (!isset($element_data->is_basic)) || $element_data->is_basic == 1 ? "" : "hide" ?>" style="width: 300px;">
                                                    <label>Property Alumni (Basic)</label>
                                                    <select class="form-control basic-fields-element" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][basic_fields]">
                                                        <?php foreach($basic_fields as $kbf => $vbf) : 	
                                                            $selected = (isset($element_data->basic_fields) && $element_data->basic_fields == $kbf) ? 'selected="selected"' : '';
                                                        ?>
                                                            <option value="<?= $kbf;?>" <?= $selected ?>><?= ucwords(str_replace("_", " ", $kbf)); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group custom-field-select-container <?= (isset($element_data->is_basic) && $element_data->is_basic == 0) ? "" : "hide" ?>" style="width: 300px;">
                                                    <label>Property Alumni</label>
                                                    <select class="form-control user-property-id-element" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][user_property_id]">
                                                        <option value="">- Select -</option>
                                                        <?php if ($program_properties) : ?>
                                                            <?php foreach ($program_properties as $pp) : ?>
                                                                <?php $selected = (isset($element_data->user_property_id) && $element_data->user_property_id == $pp->id) ? 'selected="selected"' : ''; ?>
                                                                <option value="<?= $pp->id ?>" <?= $selected ?>><?= $pp->field_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-md-12 element-vendor-options-container">
                                            <div class="form-group" style="display: block; margin-bottom: 10px;">
                                                <label style="margin-right:15px">Mapping to Master Data Vendor?</label>
                                                <input class="available_vendor_element" type="radio" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][available_vendor]" value="yes" <?= (isset($element_data->available_vendor) && $element_data->available_vendor == "yes") ? "checked" : "" ?> onchange="toggleVendorFields(this)"> Yes
                                                <input class="available_vendor_element" type="radio" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][available_vendor]" value="no" <?= (!isset($element_data->available_vendor) || $element_data->available_vendor == "no" || $element_data->available_vendor == "") ? "checked" : "" ?> onchange="toggleVendorFields(this)"> No
                                            </div>
                                            <div class="vendor-fields-container <?= (isset($element_data->available_vendor) && $element_data->available_vendor == "yes") ? "" : "hide" ?>">
                                                <div class="form-group" style="width: 300px;">
                                                    <label>Target Vendor Field (Master Data)</label>
                                                    <select class="form-control vendor-field-element" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][vendor_field]">
                                                        <option value="">- Select Target Field -</option>
                                                        <?php foreach ($vendor_fields as $kvf => $vvf) : 
                                                            $selected_v = (isset($element_data->vendor_field) && $element_data->vendor_field == $kvf) ? 'selected="selected"' : '';
                                                        ?>
                                                            <option value="<?= $kvf ?>" <?= $selected_v ?>><?= $vvf ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="sub-element-number checkbox-inline">
                                            <label>Is Number Only?</label>
                                            <input type="checkbox" value="1" class="is_number_element ml-2 mr-0 pr-0" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][is_number]" <?= $element_data->is_number == 1 ? "checked" : "" ?>>
                                        </div>
                                        <?php if (get_active_country() == 'Indonesian') { ?>
                                        <?php } ?>
                                        <div class="sub-element-limit col-md-2">
                                            <label>Is Limit?</label>
                                            <input type="checkbox" value="1" class="is_limit_element" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][is_limit]" <?= $element_data->is_limit == 1 ? "checked" : "" ?>>
                                        </div>
                                        <div class="sub-element-note hide form-group col-md-12">
                                            <label>Note</label>
                                            <textarea class="form-control editor" name="element_radio_group_options[<?=$key;?>][<?= $index_element; ?>][note]"><?= $element_data->note ?></textarea>
                                        </div>
                                        <hr>
                                    </fieldset>
                                    <?php $no++; ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="property-option">
                            <button class="btn-primary btn add-element-radio-group" data-which-option="opdt-radio-group-item-<?= $key; ?>" data-which-element="element-item-<?= $key; ?>" type="button">Add Element</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <button type="button" class="btn-primary btn add-radio-group-option">Add Options</button>
</div>


<div class="sample-radio-group-option hide">
    <div class="card-element-option">
        <div class="opdt-radio-group-item">
            <div class="col-lg-12" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                <div class="form-group property-option" style="margin-bottom: 0;">
                    <label>Option</label>
                    <div style="display: flex; gap: 6px; align-items: center;">
                        <input type="text" name="options[]" class="form-control">
                        <!-- Move Up -->
                        <button 
                            type="button" 
                            data-tooltip="Move up" 
                            title="Move up"
                            class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                            onclick="move_radio_group_option_up(this)">
                            <i class="fa fa-solid fa-arrow-up"></i>
                        </button>
                        <!-- Move Down -->
                        <button 
                            type="button" 
                            data-tooltip="Move down" 
                            title="Move down"
                            class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                            onclick="move_radio_group_option_down(this)">
                            <i class="fa fa-solid fa-arrow-down"></i>
                        </button>
                        <!-- Delete -->
                        <button 
                            type="button" 
                            data-tooltip="Delete" 
                            title="Delete" 
                            onclick="del_option(this, 'opdt-radio-group-item')" 
                            class="btn btn-danger rounded" 
                            style="height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fa fa-trash fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="radio-group-element-item"></div>
            <div class="property-option">
                <button class="btn-primary btn add-element-radio-group" type="button">Add Element</button>
            </div>
        </div>
    </div>
</div>

<div class="sample-radio-group-element hide">
    <fieldset class="sub-radio-group-element-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px; background: #fff;">
        <!-- <legend style="padding: 5px; font-size: 14px; font-weight: bold; border-bottom: 1px solid #eee; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
        </legend> -->
        <div style="display: flex; gap: 6px; justify-content:space-between">
            <label class="sub-element-title" style="display: flex;align-items: center;flex-direction: column-reverse;"></label>
            <div class="sub-element-actions" style="display: inline-flex; align-items: center; gap: 6px;">
                <button type="button" data-tooltip="Move up" title="Move up" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_sub_element_up(this)"><i class="fa fa-solid fa-arrow-up"></i></button>
                <button type="button" data-tooltip="Move down" title="Move down" class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors" onclick="move_sub_element_down(this)"><i class="fa fa-solid fa-arrow-down"></i></button>
                <a href='javascript:;' class='btn btn-danger btn-xs remove-fieldset' style='height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; border-radius: 4px;'><i class='fa fa-trash'></i></a>
            </div>
        </div>
        <hr style="margin-top:10px !important;"/>
        
        <div class="form-group">
            <label>Property Name</label>
            <input class="form-control property-name" placeholder="eg: Consulate / Airport">
        </div>
        <div class="form-group">
            <label>Property Type</label>
            <select class="form-control property-type" onchange="propertyTypeChanged(this)">
                <?php if ($property_types){ ?>
                    <?php 
                        foreach ($property_types as $pt) { 
                        if (get_active_country() != 'Indonesian' && $pt == 'test type') {
                            continue;
                        } 
                    ?>
                        <?php if ($pt != 'radio group' && $pt != 'multiple choice grid' && $pt != 'element group') : ?>
                        <option value="<?php echo $pt ?>" ><?php echo $pt ?></option>
                        <?php endif; ?>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
        <div class="sub-element-options hide form-group">
            <div class="sub-element-parent-options" style="position:relative">
                <div class="col-lg-12 opdt-item opdt-radio-group-item" id="sub-element-option-1" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                    <div class="form-group property-option" style="margin-bottom: 0;">
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <input type="text" class="form-control option-sub-element">
                            <!-- Move Up -->
                            <button 
                                type="button" 
                                data-tooltip="Move up" 
                                title="Move up"
                                class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                onclick="move_option_up(this, 'opdt-radio-group-item')">
                                <i class="fa fa-solid fa-arrow-up"></i>
                            </button>
                            <!-- Move Down -->
                            <button 
                                type="button" 
                                data-tooltip="Move down" 
                                title="Move down"
                                class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                                onclick="move_option_down(this, 'opdt-radio-group-item')">
                                <i class="fa fa-solid fa-arrow-down"></i>
                            </button>
                            <!-- Delete -->
                            <button 
                                type="button" 
                                data-tooltip="Delete" 
                                title="Delete" 
                                onclick="del_option(this, 'opdt-radio-group-item')" 
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
            <label>Required?</label>
            <input type="checkbox" value="1" class="required ml-2 mr-0 pr-0">
        </div>
        <div class="sub-element-other hide checkbox-inline">
            <label>Have Other?</label>
            <input type="checkbox" value="1" class="other ml-2 mr-0 pr-0">
        </div>
        <?php if (get_active_country() == 'American') { ?>
        <div class="sub-element-trigger-notify checkbox-inline">
            <label>Trigger Notify Finance?</label>
            <input type="checkbox" value="1" class="trigger_notify_finance_element ml-2 mr-0 pr-0">
        </div>
        <div class="sub-element-trigger-ticket checkbox-inline">
            <label>Trigger Ticket?</label>
            <input type="checkbox" value="1" class="trigger_notify_ticket_element ml-2 mr-0 pr-0">
        </div>
        <div class="sub-element-passport-dependent checkbox-inline">
            <label>Passport Dependent?</label>
            <input type="checkbox" value="1" class="passport_dependent_element ml-2 mr-0 pr-0">
        </div>
        <!-- <div class="sub-element-trigger-alumni col-md-2">
            <label>Trigger Set to Alumni?</label>
            <input type="checkbox" value="1" class="trigger_set_to_alumni_element">
        </div> -->
        <?php if ($detail_grant->alumni_grant) : ?>
        <div class="col-md-12 element-alumni-options-container">
            <div class="form-group" style="display: block; margin-bottom: 10px;">
                <label style="margin-right:15px">Is the field available in alumni?</label>
                <input class="available_alumni_element" type="radio" value="yes" checked onchange="toggleAlumniFields(this)"> Yes
                <input class="available_alumni_element" type="radio" value="no" onchange="toggleAlumniFields(this)"> No
            </div>
            <div class="alumni-fields-container">
                <div class="form-group" style="display: block; margin-bottom: 10px;">
                    <label>Is Basic Information</label>
                    <input type="checkbox" class="is_basic_element" value="1" checked onchange="toggleBasicAlumniFields(this)">
                </div>
                <div class="form-group basic-field-select-container" style="width: 300px;">
                    <label>Property Alumni (Basic)</label>
                    <select class="form-control basic-fields-element">
                        <?php foreach($basic_fields as $kbf => $vbf) : ?>
                            <option value="<?= $kbf;?>"><?= ucwords(str_replace("_", " ", $kbf)); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group custom-field-select-container hide" style="width: 300px;">
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
        <div class="col-md-12 element-vendor-options-container">
            <div class="form-group" style="display: block; margin-bottom: 10px;">
                <label style="margin-right:15px">Mapping to Master Data Vendor?</label>
                <input class="available_vendor_element" type="radio" value="yes" onchange="toggleVendorFields(this)"> Yes
                <input class="available_vendor_element" type="radio" value="no" checked onchange="toggleVendorFields(this)"> No
            </div>
            <div class="vendor-fields-container hide">
                <div class="form-group" style="width: 300px;">
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
        <?php } ?>
        <?php //if (get_active_country() == 'Indonesian') { ?>
        <div class="sub-element-number checkbox-inline">
            <label>Is Number Only?</label>
            <input type="checkbox" value="1" class="is_number_element ml-2 mr-0 pr-0">
        </div>
        <?php //} ?>
        <div class="sub-element-limit col-md-2">
            <label>Is limit?</label>
            <input type="checkbox" value="1" class="is_limit_element">
        </div>
        <div class="sub-element-note hide form-group col-md-12">
            <label>Note</label>
            <textarea class="form-control note"></textarea>
        </div>
        <hr>
    </fieldset>
</div>


<div class="sample-option-sub-element hide">
	<div class="col-lg-12 opdt-item opdt-radio-group-item" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
		<div class="form-group property-option" style="margin-bottom: 0;">
            <div style="display: flex; gap: 6px; align-items: center;">
                <input type="text" name="" class="form-control option-sub-element">
                <!-- Move Up -->
                <button 
                    type="button" 
                    data-tooltip="Move up" 
                    title="Move up"
                    class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                    onclick="move_option_up(this, 'opdt-radio-group-item')">
                    <i class="fa fa-solid fa-arrow-up"></i>
                </button>
                <!-- Move Down -->
                <button 
                    type="button" 
                    data-tooltip="Move down" 
                    title="Move down"
                    class="btn-move-custom rounded px-2.5 h-9 text-xs transition-colors"
                    onclick="move_option_down(this, 'opdt-radio-group-item')">
                    <i class="fa fa-solid fa-arrow-down"></i>
                </button>
                <!-- Delete -->
                <button 
                    type="button" 
                    data-tooltip="Delete" 
                    title="Delete" 
                    onclick="del_option(this, 'opdt-radio-group-item')" 
                    class="btn btn-danger rounded" 
                    style="height: 34px; padding: 0 12px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa fa-trash fa-fw"></i>
                </button>
            </div>
		</div>
	</div>
</div>