<?php
    if(count($options) > 0)
        $options_value = isset($options[0]->element) ? $options[0]->element : $options[0];
    //$field_type = ['element group', 'radio group']; if (!in_array($this->User_grantee_property_model->type, $field_type)) : 
?>
    <div class="property-options hide form-group">
    <label>Option</label>
    <div class="parents-option" style="position:relative">
        <div class="col-lg-12 opdt-item" id="opdt-item-1" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
            <div class="property-option">
                <div style="display: flex; gap: 6px; align-items: center;">
                    <input type="text" name="options[]" class="form-control" value="<?= count($options) > 0 ? htmlspecialchars($options_value, ENT_QUOTES, 'UTF-8') : "" ?>">
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

        <?php $max_option = 1;
        if (count($options) > 1) { ?>
            <?php for ($i = 1; $i < count($options); $i++) : 
                $options_value = isset($options[$i]->element) ? $options[$i]->element : $options[$i];
            ?>
                <div class="col-lg-12 opdt-item" id="opdt-item-<?php echo $i + 1; ?>" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                    <div class="property-option">
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <input type="text" name="options[]" class="form-control" value="<?= $options_value ? htmlspecialchars($options_value, ENT_QUOTES, 'UTF-8') : '' ?>">
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

            <?php $max_option++;
            endfor; ?>
        <?php } ?>
    </div>
    <button type="button" class="btn-primary btn add-option" style="margin-top: 5px;">Add</button>
    <div class="form-group" id="have_other" style="margin-top: 15px;">
        <label>Have Other?</label>
        <!-- <input type="checkbox" name="have_other" value="1" <?= (!isset($this->User_grantee_property_model->id)) || $this->User_grantee_property_model->have_other == 1 || (!isset($this->Form_list_panellists_model->id)) || $this->Form_list_panellists_model->have_other == 1 ? "checked" : "" ?>> -->
        <input type="checkbox" name="have_other" id="have_other_option" value="1" <?= $this->User_grantee_property_model->have_other == 1 || $this->Form_list_panellists_model->have_other == 1 || $this->Eta_host_school_application_fields_model->have_other ? "checked" : "" ?>>
    </div>
</div>

<div class="sample-option hide">
	<div class="col-lg-12 opdt-item" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
		<div class="property-option">
            <div style="display: flex; gap: 6px; align-items: center;">
                <input type="text" name="options[]" class="form-control">
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
<?php //endif; ?>