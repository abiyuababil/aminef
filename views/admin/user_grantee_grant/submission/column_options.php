<div class="property-column_options hide form-group">
    <label>Column Option</label>
    <div class="parents-column_option" style="position:relative">
        <div class="col-lg-12 opdt-item" id="opdt-item-1" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
            <div class="property-column_option">
                <div style="display: flex; gap: 6px; align-items: center;">
                    <input type="text" name="column_options[]" class="form-control" value="<?= ($column_options && is_array($column_options)) ? htmlspecialchars($column_options[0], ENT_QUOTES, 'UTF-8') : "" ?>">
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

        <?php $max_column_option = 1;
        if ($column_options) { ?>
            <?php for ($i = 1; $i < count($column_options); $i++) : ?>
                <div class="col-lg-12 opdt-item" id="opdt-item-<?php echo $i + 1; ?>" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
                    <div class="property-column_option">
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <input type="text" name="column_options[]" class="form-control" value="<?= htmlspecialchars($column_options[$i], ENT_QUOTES, 'UTF-8'); ?>">
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
            <?php $max_column_option++;
            endfor; ?>
        <?php } ?>
    </div>
    <button type="button" class="btn-primary btn add-column_option" style="margin-top: 5px;">Add</button>
</div>

<div class="sample-column_option hide">
	<div class="col-lg-12 opdt-item" style="padding-left: 0; padding-right: 0; margin-bottom: 8px;">
		<div class="property-column_option">
            <div style="display: flex; gap: 6px; align-items: center;">
                <input type="text" name="column_options[]" class="form-control">
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