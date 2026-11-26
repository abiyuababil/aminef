<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="tab-content">
        <div id="info" class="tab-pane fade active in">
            <form role="form" method="POST">
                <div class="col-lg-8">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Name <small class="text-danger">*</small></label>
                            <input class="form-control" name="name" <?= isset($data_panellist) ? 'readonly' : '' ?> placeholder="Name Panelist" value="<?= isset($data_panellist) ? $data_panellist->name : '' ?>" required>
                            <input class="form-control" name="is_active" value="1" type="hidden">
                            <?php if(isset($data_panellist)) { ?>
                                <input class="form-control" name="id" value="<?= $data_panellist->id ?>" type="hidden">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Email <small class="text-danger">*</small></label>
                            <input type="email" class="form-control" name="email" placeholder="eg: example@aminef.com" value="<?= $data_panellist->email ? $data_panellist->email : $email?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Mobile Phone Number <small class="text-danger">*</small></label>
                            <input type="tel" id="mobile" class="form-control" name="telp" placeholder="" value="<?= isset($data_panellist) ? $data_panellist->telp : '' ?>" required>
                            <input type="hidden" name="country_code" id="mobile_code">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Home Institution</label>
                            <input class="form-control" name="home_institution" placeholder="" value="<?= isset($data_panellist) ? $data_panellist->home_institution : '' ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Country of Origin <small class="text-danger">*</small></label>
                            <select id="origin_country" class="form-control select2 select-country-origin" name="origin_country" id="origin_country" required>
                                <option value="">-- Select Country --</option>
                                <?php
                                if ($country_list) {
                                    foreach ($country_list as $cl) {
                                        $selected = '';
                                        if ($data_panellist->origin_country == $cl->id) {
                                            $selected = 'selected="selected"';
                                        }
                                ?>
                                        <option value="<?php echo $cl->id ?>" data-pcode="<?php echo $cl->phone_code ?>" <?php echo $selected ?>><?php echo $cl->name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>State of Origin <small class="text-danger">*</small></label>
                            <select id="origin_state" class="form-control select2 select-state-origin" name="origin_state" id="origin_state" required>
                                <option value="">-- Select State --</option>
                                <?php
                                
                                if ($origin_states) {
                                    foreach ($origin_states as $bt) {
                                        $selected = '';
                                        if ($data_panellist->origin_state == $bt->id) {
                                            $selected = 'selected="selected"';
                                        }
                                ?>
                                        <option value="<?php echo $bt->id ?>" <?php echo $selected ?>><?php echo $bt->name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>City of Origin <small class="text-danger">*</small></label>
                            <select id="origin_city" class="form-control select2 select-city-origin" name="origin_city" id="origin_city" required>
                                <option value="">-- Select City --</option>
                                <?php
                                
                                if ($origin_cities) {
                                    foreach ($origin_cities as $bc) {
                                        $selected = '';
                                        if ($data_panellist->origin_city == $bc->id) {
                                            $selected = 'selected="selected"';
                                        }
                                ?>
                                        <option value="<?php echo $bc->id ?>" <?php echo $selected ?>><?php echo $bc->name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Level of Study <small class="text-danger">*</small></label>
                            <select name="level_of_study" id="level_of_study" class="form-control select2" style="width: 100%;" required>
                                <option value="">-- Select Level of Study --</option>
                                <?php
                                foreach ($study_levels as $level_of_study) {
                                    echo "<option value='" . $level_of_study->id . "' " . ( (isset($data_panellist) && $data_panellist->level_of_study == $level_of_study->id) ? 'selected' : '') . ">" . $level_of_study->name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Field of Study <small class="text-danger">*</small></label>
                            <?php
                                if(isset($data_panellist)) :
                                $study_fields_name = '';
                                foreach ($study_fields as $field_of_study) {
                                    if($data_panellist->field_of_study_id == $field_of_study->id){
                                        $study_fields_name = strtolower($field_of_study->name);
                                    }
                                }
                            
                            ?>
                            
                                <input class="form-control" <?= isset($data_panellist) ? 'readonly' : '' ?> value="<?= $study_fields_name == 'other' || $data_panellist->field_of_study_id == 0 ? $data_panellist->other_sof : ucwords($study_fields_name) ?>">
                                <input type="hidden" class="form-control" name="field_of_study_id" <?= isset($data_panellist) ? 'readonly' : '' ?> value="<?= $data_panellist->field_of_study_id ?>">
                            <?php else: ?>
                                <select name="field_of_study_id" id="field_of_study_id" class="form-control select2" style="width: 100%;" required>
                                    <option value="">-- Select Field of Study --</option>
                                    <?php
                                    foreach ($study_fields as $field_of_study) {
                                        echo "<option value='" . $field_of_study->id . "' " . ( (isset($data_panellist) && $data_panellist->field_of_study_id == $field_of_study->id) ? 'selected' : '') . ">" . $field_of_study->name . "</option>";
                                    }
                                    ?>
                                    <option value="other">Other</option>
                                </select>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 hide other-sof">
                        <div class="form-group">
                            <label>Other Field of Study <small class="text-danger">*</small></label>
                            <input class="form-control" name="other_sof" id="other_sof" value="<?php echo (isset($this->Panellist_model->other_sof)) ? $this->Panellist_model->other_sof : '' ?>" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Biosketch  <small class="text-danger">*</small></label>
                            <textarea required name="description" class="form-control" id="" rows="4"><?= isset($data_panellist) ? $data_panellist->description : '' ?></textarea>
                        </div>
                    </div>
                    <?php if($with_bank_info) { ?>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Bank Info <small class="text-danger">*</small></label>
                            <input class="form-control" name="bank_info" placeholder="" value="<?= isset($data_panellist) ? $data_panellist->bank_info : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Beneficiary Name <small class="text-danger">*</small></label>
                            <input class="form-control" name="beneficiary_name" value="<?= isset($data_panellist) ? $data_panellist->beneficiary_name : '' ?>" placeholder="" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Account Number <small class="text-danger">*</small></label>
                            <input type="number" class="form-control" name="account_number" value="<?= isset($data_panellist) ? $data_panellist->account_number : '' ?>" placeholder="" required>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure ?')">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>