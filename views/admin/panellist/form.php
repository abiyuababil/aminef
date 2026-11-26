<style>
    .select2-container .select2-selection {
        height: 60px;
        overflow: auto;
    } 
</style>
<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';

if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>
<div class="row">
    <?php if($is_edit){ ?>
    <div class="col-lg-12" style="margin-bottom:10px">  
        <ul class="nav nav-pills">
            <li id="li_info" <?php echo $default_tab_active ?>><a data-toggle="tab" href="#info" aria-expanded="true">Panelist Info</a></li>
            <li id="li_grantee_list"><a data-toggle="tab" href="#grantee_list" aria-expanded="true">Grantee List</a></li>
        </ul>
    </div>
    <?php } ?>

    <div class="tab-content">
        <div id="info" class="tab-pane fade <?= $default_content_active ?>">
            <form role="form" method="POST">
                <div class="col-lg-8">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Prefix</label>
                            <select class="form-control" name="prefix">
                                <option value="">-- Select Prefix --</option>
                                <?php
                                if ($titles) {
                                    foreach ($titles as $tt) {
                                        $selected = '';
                                        if ($this->Panellist_model->prefix == $tt) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?php echo $tt ?>" <?php echo $selected ?>><?php echo $tt ?></option>
                                    <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name <small class="text-danger">*</small></label>
                            <input class="form-control" name="name" value="<?php echo (isset($this->Panellist_model->name)) ? $this->Panellist_model->name : '' ?>" <?php //echo (isset($this->Panellist_model->name) && !$is_panellist) ? 'readonly' : '' ?> placeholder="Name Panelist" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Email <small class="text-danger">*</small></label>
                            <input type="email" class="form-control" name="email" value="<?php echo (isset($this->Panellist_model->email)) ? $this->Panellist_model->email : '' ?>" placeholder="eg: example@aminef.com" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Mobile Phone Number <small class="text-danger"><?= $is_panellist ? '*' : '' ?></small></label>
                            <input type="tel" class="form-control" id="mobile" name="telp" value="<?php echo (isset($this->Panellist_model->telp)) ? $this->Panellist_model->telp : '' ?>" placeholder="" <?= $is_panellist ? 'required' : '' ?>>
                            <input type="hidden" name="country_code" id="mobile_code" vaalue="<?php echo (isset($this->Panellist_model->country_code)) ? $this->Panellist_model->country_code : '' ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Home Institution</label>
                            <input class="form-control" name="home_institution" value="<?php echo (isset($this->Panellist_model->home_institution)) ? $this->Panellist_model->home_institution : '' ?>" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Country of Origin </label>
                            <select id="origin_country" class="form-control select2 select-country-origin" name="origin_country" id="origin_country">
                                <option value="">-- Select Country --</option>
                                <?php
                                if ($country_list) {
                                    foreach ($country_list as $cl) {
                                        $selected = '';
                                        if ($this->Panellist_model->origin_country == $cl->id) {
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
                            <label>State of Origin</small></label>
                            <select id="origin_state" class="form-control select2 select-state-origin" name="origin_state" id="origin_state">
                                <option value="">-- Select State --</option>
                                <?php
                                
                                if ($origin_states) {
                                    foreach ($origin_states as $bt) {
                                        $selected = '';
                                        if ($this->Panellist_model->origin_state == $bt->id) {
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
                            <label>City of Origin</small></label>
                            <select id="origin_city" class="form-control select2 select-city-origin" name="origin_city" id="origin_city">
                                <option value="">-- Select City --</option>
                                <?php
                                
                                if ($origin_cities) {
                                    foreach ($origin_cities as $bc) {
                                        $selected = '';
                                        if ($this->Panellist_model->origin_city == $bc->id) {
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
                            <label>Level of Study</label>
                            <select name="level_of_study" id="level_of_study" class="form-control select2" style="width: 100%;">
                                <option value="">-- Select Level of Study --</option>
                                <?php
                                foreach ($study_levels as $level_of_study) {
                                    echo "<option value='" . $level_of_study->id . "' " . ( (isset($this->Panellist_model) && $this->Panellist_model->level_of_study == $level_of_study->id) ? 'selected' : '') . ">" . $level_of_study->name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Field of Study</label>
                            <?php
                                // if(isset($this->Panellist_model->field_of_study_id) && $this->Panellist_model->field_of_study_id != '' && !$is_panellist) :
                                // $study_fields_name = '';
                                // foreach ($study_fields as $field_of_study) {
                                //     if($this->Panellist_model->field_of_study_id == $field_of_study->id){
                                //         $study_fields_name = strtolower($field_of_study->name);
                                //     }
                                // }
                            
                            ?>
                                <!-- <input class="form-control" <?= isset($this->Panellist_model->field_of_study_id) && $this->Panellist_model->field_of_study_id != '' ? 'readonly' : '' ?> value="<?= $study_fields_name == 'other' || $this->Panellist_model->field_of_study_id == 0 ? $this->Panellist_model->other_sof : ucwords($study_fields_name) ?>">
                                <input type="hidden" class="form-control" name="field_of_study_id" <?= isset($this->Panellist_model->field_of_study_id) && $this->Panellist_model->field_of_study_id != '' ? 'readonly' : '' ?> value="<?= $this->Panellist_model->field_of_study_id ?>">
                            <?php //else: ?> -->
                            <?php $data_studyfield = $this->Panellist_model->field_of_study_id ? explode(',', $this->Panellist_model->field_of_study_id) : []; ?>
                            <select name="field_of_study_id[]" id="field_of_study_id" class="form-control select2 multiple" multiple='multiple' style="width: 100%;">
                                <option value="">-- Select Field of Study --</option>
                                <?php
                                foreach ($study_fields as $field_of_study) {
                                    echo "<option value='" . $field_of_study->id . "' " . (in_array($field_of_study->id, $data_studyfield) ? 'selected' : '') . ">" . $field_of_study->name . "</option>";
                                }
                                ?>
                                <option value="other">Other</option>
                            </select>
                            <?php //endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 hide other-sof">
                        <div class="form-group">
                            <label>Other Field of Study <small class="text-danger">*</small></label>
                            <input class="form-control" name="other_sof" id="other_sof" value="<?php echo (isset($this->Panellist_model->other_sof)) ? $this->Panellist_model->other_sof : '' ?>" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mt-5">
                    <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Biosketch <small class="text-danger"><?= $is_panellist ? '*' : '' ?></small></label>
                            <textarea name="description" class="form-control" id="" rows="4" <?= $is_panellist ? 'required' : '' ?>><?php echo (isset($this->Panellist_model->description)) ? $this->Panellist_model->description : '' ?></textarea>
                        </div>
                    </div>
                    <?php if(!$is_panellist) { ?>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Final Biosketch <small class="text-danger"><?= $is_panellist ? '*' : '' ?></small></label>
                            <textarea name="final_biosketch" class="form-control" id="" rows="4" <?= $is_panellist ? 'required' : '' ?>><?php echo (isset($this->Panellist_model->final_biosketch)) ? $this->Panellist_model->final_biosketch : '' ?></textarea>
                        </div>
                    </div>
                    <?php } ?>
                    <?php 
                        $display_bank_info = !$is_panellist ;
                        if($is_panellist){
                           $display_bank_info = $this->Panellist_model->with_bank_info;
                        }
                        $show_bank_info =  true;
                        $required_bank_info =  false;
                        $status_not_show = [DOS, CURRENT_GRANTEE_PANELLIST];
                        
				        if(in_array($this->Panellist_model->status_panellist_id, $status_not_show) && $is_panellist){
                            $show_bank_info = false;
                        }

                        if($this->Panellist_model->status_panellist_id == FULBRIGHT_ALUMNI && $is_panellist){
                            $required_bank_info =  true;
                        }

                    ?>
                    <?php //if($display_bank_info) { ?>
                    <?php if(!$is_panellist) { ?>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status_panellist_id" id="status_panellist_id_0" class="form-control">
                                <option value="">-- Select Status Panelist --</option>
                                <?php foreach($status_panellist as $key => $status) : ?>
                                    <option value="<?= $key ?>" <?= $this->Panellist_model->status_panellist_id == $key ? 'selected' : '' ?>><?= $status ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($show_bank_info){ ?>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Bank Info <small class="text-danger"><?= $required_bank_info ? '*' : '' ?></small></label>
                            <input class="form-control" name="bank_info" value="<?php echo (isset($this->Panellist_model->bank_info)) ? $this->Panellist_model->bank_info : '' ?>" <?= $required_bank_info ? 'required' : '' ?>>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Beneficiary Name <small class="text-danger"><?= $required_bank_info ? '*' : '' ?></small></small></label>
                            <input class="form-control" name="beneficiary_name" value="<?php echo (isset($this->Panellist_model->beneficiary_name)) ? $this->Panellist_model->beneficiary_name : '' ?>" <?= $required_bank_info ? 'required' : '' ?>>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Account Number <small class="text-danger"><?= $required_bank_info ? '*' : '' ?></small></small></label>
                            <input class="form-control" name="account_number" value="<?php echo (isset($this->Panellist_model->account_number)) ? $this->Panellist_model->account_number : '' ?>" <?= $required_bank_info ? 'required' : '' ?>>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Bank Address <small class="text-danger"><?= $required_bank_info ? '*' : '' ?></small></label>
                            <input class="form-control" name="bank_address" value="<?php echo (isset($this->Panellist_model->bank_address)) ? $this->Panellist_model->bank_address : '' ?>" <?= $required_bank_address ? 'required' : '' ?>>
                        </div>
                    </div>
                    <div class="col-lg-6 routing_number_form">
                        <div class="form-group">
                            <label>Routing Number / Swift Code <small class="text-danger"><?= $required_bank_info ? '*' : '' ?></small></label>
                            <input class="form-control" name="routing_number" value="<?php echo (isset($this->Panellist_model->routing_number)) ? $this->Panellist_model->routing_number : '' ?>" <?= $required_routing_number ? 'required' : '' ?>>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php if(!$is_panellist) { ?>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label> Is Active </label>
                            <input type="checkbox" value="1" name="is_active" <?= $this->Panellist_model->is_active == 1 ? "checked" : "" ?>>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($is_panellist) { ?>
                        <div class="col-lg-12">
                            <hr />
                            <p style="color:red">Do not fill in if you do not want to change the password</p>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" autocomplete="new-password">
                            </div>
                        </div>
                    <?php } ?>
                    <?php //if (isset($this->Panellist_model->id) && $this->Panellist_model->created_by == 0 && !$is_panellist) { ?>
                    <!-- <div class="col-lg-6">
                        <div class="form-group pull-right">
                            <label style="cursor:pointer;" class="form-check-label" for="chck"> Need to input Bank Information</label>
                            <input type="checkbox" style="cursor:pointer;" form="form-email" class="form-check-input" id="chck" value="1" name="with_bank_info">
                        </div>
                    </div> -->
                    <?php //} ?>
                    <div class="col-lg-12 mb-5">
                        <?php if(!$is_panellist) { ?>
                        <a href="<?php echo site_url('admin/panelist/manage') ?>" class="btn btn-default">Back</a>
                        <?php } ?>
                        <button type="submit" class="btn btn-success">Save</button>
                        <?php
                        if (isset($this->Panellist_model->id)) {
                        ?>
                            <input type="hidden" name="id" value="<?php echo $this->Panellist_model->id ?>">
                        <?php } ?>
                        <?php if (isset($this->Panellist_model->id) && $this->Panellist_model->created_by == 0 && !$is_panellist) { ?>
                                <!-- <a href="<?= base_url('admin/panelist/send_email_edit/'. $this->Panellist_model->id) ?>" class="btn btn-warning pull-right">Send Email Edit Data</a> -->
                                <!-- <button type="submit" form="form-email" class="btn btn-warning pull-right">Send Email Edit Data</button> -->
                        <?php } ?>

                        <?php if(!$is_panellist) { ?>
                        <button type="submit" class="btn btn-primary pull-right" value="email_password" name="btn-email">Save & Send Email Password</button>
                        <?php } ?>
                    </div>
                </div>
            </form>
            <form action="<?= base_url('admin/panelist/send_email_edit/'. $this->Panellist_model->id) ?>" id="form-email" id="form-email" method="post"></form>
        </div>
        <div id="grantee_list" class="tab-pane fade">
            <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th>Name</th>
                            <th>Grantee Program</th>
                            <th>University</th>
                            <th>Period</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($list_grantee as $key => $row) { ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= get_full_name($row, 'ID') ?></td>
                            <td><?= $row->grant_name ?></td>
                            <td><?= isset($row->university_name) ? $row->university_name : '' ?></td>
                            <td><?= $row->fiscal_year ?></td>
                        </tr>    
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>