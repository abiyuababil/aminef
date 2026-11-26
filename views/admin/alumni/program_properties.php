<?php
$active_country = $this->session->userdata('active_country');
?>

<?php
$i = 0;
foreach ($program_properties[$program_id] as $arr) {
    ?>
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="row">
                        <a class="col-md-12" data-toggle="collapse" href="#collapse<?= $user_program_id . '_' . $i ?>" style="color:#fff">
                            <?= $arr[0]->group_name; ?>
                        </a>
                    </div>
                </h4>
            </div>
            <div id="collapse<?= $user_program_id . '_' . $i ?>" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php
                    foreach ($arr as $obj) {
                        $value = '';
                        if (isset($user_program_property[$obj->id])) {
                            if ($user_program_property[$obj->id]->user_program_id == $user_program_id) {
                                $value = $user_program_property[$obj->id]->property_value;
                            }
                        }
                        if ($obj->field_type == 'date' && $value != '') {
                            $value = date('d M Y', strtotime($value));
                        }
                        ?>
                        <div class="form-group col-md-4">
                            <label><?= $obj->field_name; ?></label>
                            <?php if ($obj->field_type == 'date') { ?>
                                <input class="form-control datepicker" name="program_properties[<?= $obj->id; ?>]" value="<?php echo $value ?>">
                            <?php } elseif ($obj->field_type == 'text') { ?>
                                <textarea class="form-control" rows="3" name="program_properties[<?= $obj->id; ?>]"><?php echo $value ?></textarea>
                            <?php } elseif ($obj->field_type == 'file') { ?>
                                <?php if ($value != '') { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <?php /*
										<a href="<?php echo base_url() ?><?php echo $value; ?>" target="_blank">
											<img src="<?php echo base_url() ?><?php echo $value; ?>" width="100">
										</a>
										*/ ?>

                                    </div>
                                <?php } ?>
                                <?php if ($value != '') { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo base_url() ?><?php echo $value ?>" class="lightbox">
                                            <img src="<?php echo get_preview($value) ?>" width="100">
                                        </a>
                                        <?php if (!$this->input->get('readonly')) { ?>
                                        <a href="javascript:;" onclick="del_file(this, 'program_properties_delete[<?= $user_program_id; ?>][<?= $obj->id; ?>]', '<?= $obj->field_name; ?> Document', '<?php echo $value ?>')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28px;">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                        <?php } ?>
                                    </div>
                                <?php //} else { ?>
                                    <!-- <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <img id="preview_image_void_check" src="<?php echo base_url('assets/images/icons/add-file.png') ?>" width="100">
                                    </div> -->
                                <?php } ?>
                                <?php if (!$this->input->get('readonly')) { ?>
                                    <input type="file" name="program_poperties|<?= $obj->id; ?>|<?= $user_program_id; ?>">
                                    <small class="file-for-testing">File Size Max 5MB</small>
                                <?php } else if ($this->input->get('readonly') && empty($value)) { ?>
                                    <br>
                                    <small class="file-for-testing">No files have been uploaded</small>
                                <?php } ?>
                            <?php } else { ?>
                                <input class="form-control" name="program_poperties[<?= $obj->id; ?>]" value="<?php echo $value ?>">
                            <?php } ?>
                        </div>
                    <?php
                }
                ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $i++;
}
?>