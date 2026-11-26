<?php if (!empty($options)){ $options = (array) $options; } ?>
<div class="property-declare-options hide form-group">
    <div class="parents-declare-option" style="position:relative">
        <?php if (empty($options)) { ?>
            <div class="row opdt-declare-item">
                    <div class="col-lg-12" id="opdt-declare-item-0">
                        <div class="form-group property-option">
                            <label>Declare</label>
                            <input type="text" name="declare_options[0][element]" data-index="0" class="form-control" value="Declare">
                        </div>
                    </div>
                <div class="col-lg-12 declare-element-item" id="declare-element-item-1"></div>
                <div class="col-lg-12 form-group property-option">
                    <button class="btn-primary btn add-element-declare" data-which-option="opdt-declare-item-0" data-which-element="declare-element-item-1" type="button">Add Element</button>
                </div>
            </div>
        <?php } else { ?>
            <?php foreach($options as $key => $option) { ?>
                <div class="row opdt-declare-item">
                            <div class="col-lg-12" id="opdt-declare-item-<?= $key; ?>">
                                <div class="form-group property-option">
                                    <label>Declare</label>
                                    <input type="text" name="declare_options[<?= $key ?>][element]" data-index="<?= $key ?>" class="form-control" value="<?= $option->element ? $option->element : 'Declare'; ?>">
                                </div>
                            </div>
                    <div class="col-lg-12 declare-element-item" id="declare-element-item-<?= $key; ?>">
                        <?php $no = 1; ?>
                        <?php foreach($declare_data as $index_element => $element_data) { ?>
                            <?php $element_options = json_decode($element_data->options); ?>
                            <?php if ($element_data->which_option == $option->element){ ?>
                                <fieldset id="fieldset-declare-<?= $key; ?>-<?= $no; ?>" data-index="<?= $no; ?>" class="sub-declare-element-item">
                                    <legend style="padding-bottom: 5px;">Element <?= $no; ?> <a href='#' style='margin-left: 10px;' class='btn btn-danger btn-xs remove-fieldset' data-id='<?= $element_data->id ?>' data-fieldset='fieldset-declare-<?= $key; ?>-<?= $no; ?>'><i class='fa fa-trash'></i></a></legend>
                                    <div class="form-group">
                                        <label>Property Name</label>
                                        <input class="form-control property-name" placeholder="eg: Consulate / Airport" name="element_declare_options[<?=$key;?>][<?= $index_element; ?>][property_name]" value="<?= $element_data->property_name; ?>">
                                        <input type="hidden" class="form-control property-name" name="element_declare_options[<?= $key ?>][<?= $index_element; ?>][property_id]" placeholder="eg: Consulate / Airport" value="<?= $element_data->id ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Property Type</label>
                                        <select class="form-control property-type" onchange="propertyTypeChanged(this)" name="element_declare_options[<?=$key;?>][<?= $index_element; ?>][property_type]">
                                            <?php if ($property_types){ ?>
                                                <?php 
                                                    foreach ($property_types as $pt) { 
                                                    if (get_active_country() != 'Indonesian' && $pt == 'test type') {
                                                        continue;
                                                    } 
                                                ?>
                                                    <?php $selected = $pt == $element_data->property_type ? 'selected' : ''; ?>
                                                    <?php if ($pt != 'radio group' && $pt != 'multiple choice grid' && $pt != 'element group' && $pt != 'declare') : ?>
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
                                                        <div class="col-lg-12 opdt-declare-item" >
                                                            <div class="form-group property-option">
                                                                <label>Option</label>
                                                                <input type="text" class="form-control option-sub-element" name="element_declare_options[<?=$key;?>][<?= $index_element; ?>][options][]" value="<?= $element_option?>">
                                                                <a href="javascript:;" onclick="del_option(this, 'opdt-declare-item')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                            </div>
                                            <button type="button" class="btn btn-primary add-sub-element-option" onclick="addSubElementOption(this)">Add</button>
                                        </div>
                                    <?php } else { ?>
                                        <div class="sub-element-options form-group hide">
                                            <div class="sub-element-parent-options" style="position:relative">
                                                <div class="col-lg-12 opdt-declare-item" >
                                                    <div class="form-group property-option">
                                                        <label>Option</label>
                                                        <input type="text" class="form-control option-sub-element" name="element_declare_options[<?=$key;?>][<?= $index_element; ?>][options][]" value="">
                                                        <a href="javascript:;" onclick="del_option(this, 'opdt-declare-item')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary add-sub-element-option" onclick="addSubElementOption(this)">Add</button>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group col-md-2">
                                        <label>Required?</label>
                                        <input type="checkbox" value="1" class="required" name="element_declare_options[<?=$key;?>][<?= $index_element; ?>][required]" <?= $element_data->is_required == 1 ? "checked" : "" ?>>
                                    </div>
                                    <div class="sub-element-other hide form-group col-md-2" style="margin-left:-105px;">
                                        <label>Have Other?</label>
                                        <input type="checkbox" value="1" class="other" name="element_declare_options[<?=$key;?>][<?= $index_element; ?>][have_other]" <?= $element_data->have_other == 1 ? "checked" : "" ?>>
                                    </div>
                                    <?php if (get_active_country() == 'Indonesian') { ?>
                                    <div class="sub-element-number col-md-2" style="margin-left:-105px;">
                                        <label>Is Number Only?</label>
                                        <input type="checkbox" value="1" class="is_number_element" name="element_declare_options[<?=$key;?>][<?= $index_element; ?>][is_number]" <?= $element_data->is_number == 1 ? "checked" : "" ?>>
                                    </div>
                                    <?php } ?>
                                    <div class="sub-element-limit col-md-2" style="margin-left:-105px;">
                                        <label>Is Limit?</label>
                                        <input type="checkbox" value="1" class="is_limit_element" name="element_declare_options[<?=$key;?>][<?= $index_element; ?>][is_limit]" <?= $element_data->is_limit == 1 ? "checked" : "" ?>>
                                    </div>
                                    <div class="sub-element-note hide form-group col-md-12">
                                        <label>Note</label>
                                        <textarea class="form-control editor" name="element_declare_options[<?=$key;?>][<?= $index_element; ?>][note]"><?= $element_data->note ?></textarea>
                                    </div>
                                    <hr>
                                </fieldset>
                                <?php $no++; ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12 form-group property-option">
                        <button class="btn-primary btn add-element-declare" data-which-option="opdt-declare-item-<?= $key; ?>" data-which-element="declare-element-item-<?= $key; ?>" type="button">Add Element</button>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <!-- Add Options hidden for declare type (only one Declare allowed) -->
</div>


<div class="sample-declare-option hide">
    <div class="row opdt-declare-item">
        <div class="col-lg-12">
            <div class="form-group property-option">
                <label>Declare</label>
                <input type="text" class="form-control" value="Declare">
            </div>
        </div>
        <div class="col-lg-12 declare-element-item"></div>
        <div class="col-lg-12 form-group property-option">
            <button class="btn-primary btn add-element-declare" type="button">Add Element</button>
        </div>
    </div>
</div>

<div class="sample-declare-element hide">
    <fieldset class="sub-declare-element-item">
        <legend style="padding-bottom: 5px;"></legend>
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
                        <?php if ($pt != 'radio group' && $pt != 'multiple choice grid' && $pt != 'element group' && $pt != 'declare') : ?>
                        <option value="<?php echo $pt ?>" ><?php echo $pt ?></option>
                        <?php endif; ?>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
        <div class="sub-element-options hide form-group">
            <div class="sub-element-parent-options" style="position:relative">
                <div class="col-lg-12 opdt-declare-item" id="sub-element-option-1">
                    <div class="form-group property-option">
                        <label>Option</label>
                        <input type="text" class="form-control option-sub-element">
                        <a href="javascript:;" onclick="del_option(this, 'opdt-declare-item')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary add-sub-element-option" onclick="addSubElementOption(this)">Add</button>
        </div>
        <div class="form-group col-md-2">
            <label>Required?</label>
            <input type="checkbox" value="1" class="required">
        </div>
        <div class="sub-element-other hide col-md-2" style="margin-left:-105px;">
            <label>Have Other?</label>
            <input type="checkbox" value="1" class="other">
        </div>
        <?php if (get_active_country() == 'Indonesian') { ?>
        <div class="sub-element-number col-md-2" style="margin-left:-105px;">
            <label>Is Number Only?</label>
            <input type="checkbox" value="1" class="is_number_element">
        </div>
        <?php } ?>
        <div class="sub-element-limit col-md-2" style="margin-left:-105px;">
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
