<style>
    .containt {
        margin: 0px auto 30px auto;
    }

    .progressbar {
        counter-reset: step;
        margin: 0px;
        padding: 0px;
    }

    .progressbar li {
        display: inline-block;
        list-style-type: none;
        width: 25%;
        /* float: left; */
        font-size: 12px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        color: #7d7d7d;
    }

    .progressbar li {
        width: 30px;
        height: 30px;
        line-height: 30px;
        background-color: #b5b5b5;
        /* display: block; */
        text-align: center;
        margin: auto 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .progressbar li a {
        color: white !important;
        text-decoration: none;
    }

    .progressbar li:after {
        width: 100%;
        height: 2px;
        content: '';
        position: absolute;
        background-color: #7d7d7d;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child:after {
        content: none;
    }

    .progressbar li.active {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.done {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.active+li:after {
        background-color: #55b776;
    }

    .btn_step {
        width: 150px;
    }

    .next {
        float: right;
    }

    .select2 {
        width:100% !important;
    }

    .display {
        display: none;
    }
</style>

<?php
$pid = $this->input->get('pid');
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}

?>

<input type="hidden" value="<?= $this->Grantee_ent_model->id ?>" id="grantee_id">
<input type="hidden" value="<?= $grantee_grant_id ?>" id="grantee_grant_id">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $grantee['title']; ?> 

            <?php if ($select_section == 'returning'): ?>
                    <a href="<?= base_url('admin/returning/set_to_alumni/' . $grantee['user']->id . '/' . $grantee['grantee_grant']->id); ?>" class="btn btn-success" style="float:right" target="_blank">Set to Alumni</a>
            <?php endif; ?>
            
        </h1>
        
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12" style="margin-bottom:10px">
        <ul class="nav nav-pills">
            <li><a data-toggle="tab" href="#personal" aria-expanded="true">Personal Information</a></li>
            <li><a data-toggle="tab" href="#contact" aria-expanded="true">Contact Information</a></li>
            <?php foreach ($submission as $key => $row) { ?>
                    <li <?php echo (!$pid && $select_section == $key) ? 'class="active"' : ''; ?>><a data-toggle="tab" href="#<?php echo $key; ?>" aria-expanded="true"><?= $row['name']; ?></a></li>
            <?php } ?>
            <?php if ($grantee_grant->status == STATUS_CANDIDATE_SUCCESSFUL || $grantee_grant->status == STATUS_ON_GOING_RESIGN || $grantee_grant->status == STATUS_ON_GOING_REVISED) { ?>
                <li <?= $pid == 'report' ? 'class="active"' : '' ?>><a data-toggle="tab" href="#report" aria-expanded="true">Grantee Report</a></li>
            <?php } ?>
        </ul>
    </div>

    <div class="tab-content">
        <div id="personal" class="tab-pane fade ">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> NAME</p>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Prefix</label>
                                <input type="text" class="form-control" name="prefix_name" value="<?php echo $this->Grantee_ent_model->prefix_name ?>" placeholder="Prefix" disabled>
                            </div>
                            <div class="form-group">
                                <label>First/Given Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo $this->Grantee_ent_model->first_name ?>" placeholder="First/Given Name" disabled>
                            </div>
                            <div class="form-group">
                                <label>Suffix (Jr./Sr.I/II/II)</label>
                                <input type="text" class="form-control" name="suffix_ame" value="<?php echo $this->Grantee_ent_model->suffix_ame ?>" placeholder="Suffix" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="middle_name" value="<?php echo $this->Grantee_ent_model->middle_name ?>" placeholder="Middle Name" disabled>
                            </div>
                            <div class="form-group">
                                <label>Last/Family Name</label>
                                <input type="text" class="form-control" name="last_name" value="<?php echo $this->Grantee_ent_model->last_name ?>" placeholder="Last/Family Name" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Photo</label>
                                    <?php if ($this->Grantee_ent_model->img_photo != '') { ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                            <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_photo ?>" class="lightbox" aria-haspopup="dialog">
                                                <img id="preview_image_profile" src="<?php echo get_preview($this->Grantee_ent_model->img_photo) ?>" width="100">
                                            </a>
                                            <!-- <a href="javascript:;" title="Click to Delete Photo" onclick="del_file(this, 'img_photo', 'Photo')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a> -->
                                            <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_photo ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                        </div>
                                    <?php } else { ?>
                                        <div id="preview_section_profile" style="margin-bottom: 10px; position:relative; width:100px; display:none;">
                                            <a>
                                                <img id="preview_image_profile" width="100">
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                        </div>
                    </div>


                    <div class="panel-body mt-3">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> NAME ON PREVIOUS RECORD<br />
                            <small>Please provide your name if listed on previous records differently than above.</small>
                        </p>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>First/Given Name</label>
                                <input type="text" class="form-control" name="previous_first_name" value="<?php echo $this->Grantee_ent_model->previous_first_name ?>" placeholder="First/Given Name" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="previous_middle_name" value="<?php echo $this->Grantee_ent_model->previous_middle_name ?>" placeholder="Middle Name" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Last/Family Name</label>
                                <input type="text" class="form-control" name="previous_last_name" value="<?php echo $this->Grantee_ent_model->previous_last_name ?>" placeholder="Last/Family Name" disabled>
                            </div>
                        </div>
                    </div>


                    <div class="panel-body mt-3">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BIOGRAPHICAL INFORMATION</p>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Birthdate</label><?= $required_label ?>
                                <input type="text" class="form-control" readonly name="birth_date" id="birth_date" placeholder="Birthdate" value="<?php echo ($this->Grantee_ent_model->birth_date) ? date('d M Y', strtotime($this->Grantee_ent_model->birth_date)) : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Country of Birth</label><?= $required_label ?>
                                <select id="birth_country" class="form-control select2 select-country-birth" name="birth_country" id="birth_country" disabled>
                                    <option value="">-- Select Country --</option>
                                    <?php
                                    if ($country_list) {
                                        foreach ($country_list as $cl) {
                                            $selected = '';
                                            if ($this->Grantee_ent_model->birth_country == $cl->id) {
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>State of Birth</label><?= $required_label ?>
                                <select id="birth_state" class="form-control select2 select-state-birth" name="birth_state" id="birth_state" disabled>
                                    <option value="">-- Select Country --</option>
                                    <?php
                                    
                                    if ($birth_states) {
                                        foreach ($birth_states as $bt) {
                                            $selected = '';
                                            if ($this->Grantee_ent_model->birth_state == $bt->id) {
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>City of Birth</label><?= $required_label ?>
                                <select id="birth_city" class="form-control select2 select-city-birth" name="birth_city" id="birth_city" disabled>
                                    <option value="">-- Select City --</option>
                                    <?php if (!is_numeric($this->Grantee_ent_model->birth_city)) { ?>
                                        <option value="<?php echo $this->Grantee_ent_model->birth_city; ?>" selected><?php echo $this->Grantee_ent_model->birth_city; ?></option>
                                    <?php } ?>
                                    <?php
                                    
                                    if ($birth_cities) {
                                        foreach ($birth_cities as $bc) {
                                            $selected = '';
                                            if ($this->Grantee_ent_model->birth_city == $bc->id) {
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Gender</label><?= $required_label ?>
                                <select class="form-control" name="gender" id="gender" disabled>
                                    <option value="">-- Select Gender --</option>
                                    <?php
                                    if ($genders) {
                                        foreach ($genders as $ge) {
                                            $selected = '';
                                            if ($this->Grantee_ent_model->gender == $ge) {
                                                $selected = 'selected="selected"';
                                            }
                                    ?>
                                            <option value="<?php echo $ge ?>" <?php echo $selected ?>><?php echo $ge ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>
                                    Physical Impairment
                                    <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="The Fulbright Program complies with the Americans with Disabilities Act (the “ADA”) and is committed to diversity and inclusion. If you have any form of limitation that requires accommodation, please indicate that here. This information is gathered only for statistical purposes and to ensure appropriate accommodation at a prospective host institution.">i</span>
                                </label>

                                <input type="text" class="form-control" name="physical_impairment" value="<?php echo $this->Grantee_ent_model->physical_impairment ?>" placeholder="Physical Impairment" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body mt-3">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> CITIZENSHIP INFORMATION</p>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Country of Citizenship</label>
                                <select id="citizen_country" class="form-control select2 select-country" name="citizen_country" onchange="show_pcode('citizen_country', 'home_phone_code')" style="width:100%" disabled>
                                    <option value="">-- Select Country --</option>
                                    <?php
                                    if ($country_list) {
                                        foreach ($country_list as $cl) {
                                            $selected = '';
                                            if ($this->Grantee_ent_model->citizen_country == $cl->id) {
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>KTP</label>
                                <input type="text" class="form-control" name="number_identity" value="<?php echo $this->Grantee_ent_model->number_identity ?>" placeholder="KTP" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Passport</label>
                                <input type="text" class="form-control" name="number_passport" value="<?php echo $this->Grantee_ent_model->number_passport ?>" placeholder="Passport" disabled>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Softcopy KTP</label><span style='color:red'> *</span>
                                <?php if ($this->Grantee_ent_model->img_passport != '') { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_passport ?>" class="lightbox" aria-haspopup="dialog">
                                            <?php 
                                                $fileextension = get_file_extension($this->Grantee_ent_model->img_passport); 
                                                if (in_array($fileextension, ALLOWED_PROFILE_FILETYPE)) { 
                                            ?>
                                                <img id="preview_image_passport" src="<?php echo get_preview($this->Grantee_ent_model->img_passport) ?>" width="100">
                                            <?php } else if ($fileextension == 'pdf') { ?>
                                                <img id="preview_image_passport" src="<?php echo base_url('assets/images/icons/pdf.svg'); ?>" width="100">
                                            <?php } else { ?>
                                                <img id="preview_image_passport" src="<?php echo base_url('assets/images/icons/document-filetype.png'); ?>" width="100">
                                            <?php } ?>
                                        </a>

                                        <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_passport ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; right:-28px;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div id="preview_section_ktp" style="margin-bottom: 10px; position:relative; width:100px; display:none;">
                                        <a>
                                            <img id="preview_image_ktp" width="100">
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12" style="margin-bottom:10px;">
                <div style="margin-bottom:10px;">

                    <?php
                    if ($this->Grantee_ent_model->id) {
                        ?>
                            <input type="hidden" name="id" id="uid" value="<?php echo $this->Grantee_ent_model->id ?>">
                    <?php } ?>
                </div>
            </div>
        </div>

        <div id="contact" class="tab-pane fade">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> ADDRESS<br />
                            <small>Permanent Address (DO NOT TRANSLATE the address into English)</small>
                        </p>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Country</label>
                                <select id="address_country" class="form-control select2 select-country" name="country" onchange="show_pcode('country', 'street')" style="width:100%" disabled>
                                    <option value="">-- Select Country --</option>
                                    <?php
                                    if ($country_list) {
                                        foreach ($country_list as $cl) {
                                            $selected = '';
                                            if ($this->Grantee_ent_model->country == $cl->id) {
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
                            <div class="form-group">
                                <label>Street</label>
                                <input type="text" class="form-control" id="street" name="street" value="<?php echo $this->Grantee_ent_model->street ?>" placeholder="Street" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group pos-rel">
                                <label>State/Province</label>
                                <select id="address_state" class="form-control select2 select-state" name="home_state" style="width:100%" disabled>
                                    <option value="">-- Select State/Province --</option>
                                    <?php
                                    if ($home_states) {
                                        foreach ($home_states as $st) {
                                            $selected = '';
                                            if ($this->Grantee_ent_model->provinci == $st->id) {
                                                $selected = 'selected="selected"';
                                            }
                                            ?>
                                                    <option value="<?php echo $st->id ?>" <?php echo $selected ?>><?php echo $st->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <img id="load-home_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                            </div>
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input type="text" class="form-control" name="zipcode" value="<?php echo $this->Grantee_ent_model->zipcode ?>" placeholder="Postal Code" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group pos-rel">
                                <label>City</label>
                                <select id="address_city" class="form-control select2" name="city" style="width:100%" disabled>
                                    <option value="">-- Select City --</option>
                                    <?php
                                    if ($home_cities) {
                                        foreach ($home_cities as $ct) {
                                            $selected = '';
                                            if ($this->Grantee_ent_model->city == $ct->id) {
                                                $selected = 'selected="selected"';
                                            }
                                            ?>
                                                    <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <img id="load-home_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                            </div>
                        </div>
                    </div>
                    <div id="current-residence-section" class="panel-body mt-3 <?php echo $checkbox_current_residence ? 'hide' : ''; ?>">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> CURRENT ADDRESS<br />
                            <small>This address will be used for domicile verification</small> </p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select readonly id="residence_country" class="form-control select2 select-residence-country" name="residence_country" style="width:100%" data-old="<?php echo $this->Grantee_ent_model->residence_country; ?>">
                                        <option value="">-- Select Country --</option>
                                        <?php
                                        if ($country_list) {
                                            foreach ($country_list as $cl) {
                                                $selected = '';
                                                if ($this->Grantee_ent_model->residence_country == $cl->id) {
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
                                <div class="form-group">
                                    <label>Street</label>
                                    <input readonly type="text" class="form-control" id="residence_street" name="residence_street" value="<?php echo $this->Grantee_ent_model->residence_street ?>" placeholder="Street"  data-old="<?php echo $this->Grantee_ent_model->residence_street; ?>">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>State/Province</label>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_state" style="display:none;">
                                    <select readonly id="residence_state" class="form-control select2 select-residence-state" name="residence_state" style="width:100%" data-old="<?php echo $this->Grantee_ent_model->residence_state; ?>">
                                        <option value="">-- Select State/Province --</option>
                                        <?php
                                        if ($residence_states) {
                                            foreach ($residence_states as $st) {
                                                $selected = '';
                                                if ($this->Grantee_ent_model->residence_state == $st->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                        ?>
                                                <option value="<?php echo $st->id ?>" <?php echo $selected ?>><?php echo $st->name ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <img id="load-residence_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                </div>
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input readonly type="number" class="form-control" name="residence_zipcode" value="<?php echo $this->Grantee_ent_model->residence_zipcode ?>" placeholder="Postal Code"  data-old="<?php echo $this->Grantee_ent_model->residence_zipcode; ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>City</label>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_city" style="display:none;">
                                    <select readonly id="residence_city" class="form-control select2 select-residence-city" name="residence_city" style="width:100%" data-old="<?php echo $this->Grantee_ent_model->residence_city; ?>">
                                        <option value="">-- Select City --</option>
                                        <?php
                                        if ($residence_cities) {
                                            foreach ($residence_cities as $ct) {
                                                $selected = '';
                                                if ($this->Grantee_ent_model->residence_city == $ct->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                        ?>
                                                <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <img id="load-residence_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                </div>
                            </div>
                        </div>

                    <div class="panel-body mt-3">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> TELEPHONE NUMBERS<br />
                            <small>Please be sure to include the local code along with your number</small>
                        </p>
                        <div class="col-lg-4">
                            <div id="wrap-phone">
                                <?php
                                $phone_number = $this->Grantee_ent_model->phone_number ? explode(',', $this->Grantee_ent_model->phone_number) : [];
                                if ($phone_number) {
                                    foreach ($phone_number as $key => $row) {
                                        ?>
                                                <div id="opdt-item-<?= $key ?>" class="opdt-item" style="position:relative">
                                                    <div class="form-group">
                                                        <label>Cell Phone Number</label>
                                                        <input type="text" class="form-control" name="phone_number[]" value="<?= $row ?>" disabled>
                                                    </div>
                                                </div>
                                            <?php
                                    }
                                } else {
                                    ?>
                                        <div id="opdt-item-0" class="opdt-item">
                                            <div class="form-group">
                                                <label>Cell Phone Number</label>
                                                <input type="text" class="form-control" name="phone_number[]" value="" disabled>
                                            </div>
                                        </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label>Home Phone Number</label>
                                <input type="text" class="form-control" name="home_phone_number" value="<?php echo $this->Grantee_ent_model->home_phone_number ?>" placeholder="Home Phone Numbe" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <br><br><br>
                            </div>
                            <div class="form-group">
                                <label>Work Phone Number</label>
                                <input type="text" class="form-control" name="work_phone_number" value="<?php echo $this->Grantee_ent_model->work_phone_number ?>" placeholder="Work Phone Number" disabled>
                            </div>
                        </div>
                    </div>

                    <?php if (is_admin()) { ?>
                            <div class="panel-body mt-3">
                                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> E-MAIL<br />
                                    <small>Please provide a primary and secondary e-mail address (e.g. professional, university, etc.) in case we have difficulties contacting you at the primary e-mail address. Please note that all system-generated messages will be sent to the primary e-mail address.</small>
                                </p>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Primary</label>
                                        <input type="email" id="primary_email" class="form-control" name="primary_email" value="<?php echo $this->Grantee_ent_model->primary_email ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Secondary Email</label>
                                        <input type="email" class="form-control" name="secondary_email" value="<?php echo $this->Grantee_ent_model->secondary_email ?>" placeholder="Secondary Email" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                    
                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="reset-load" style="display:none;">
                                    </div>
                                </div>
                            </div>
                    <?php } else { ?>
                            <div class="panel-body mt-3">
                                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> E-MAIL<br />
                                    <small>Please provide a primary and secondary e-mail address (e.g. professional, university, etc.) in case we have difficulties contacting you at the primary e-mail address. Please note that all system-generated messages will be sent to the primary e-mail address.</small>
                                </p>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Primary</label>
                                        <input type="email" id="primary_email" class="form-control" name="primary_email" value="<?php echo $this->Grantee_ent_model->primary_email ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="margin-top:-20px;">
                                <p class="ml-4" style="color:red">Do not fill in if you do not want to change the password</p>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" disabled>
                                        <i class="fa fa-eye password-show"></i>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" disabled>
                                        <i class="fa fa-eye password-show"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="margin-top:-20px;">
                                <p style="border:1px solid #efefef"></p>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Secondary Email</label>
                                        <input type="email" class="form-control" name="secondary_email" value="<?php echo $this->Grantee_ent_model->secondary_email ?>" placeholder="Secondary Email" disabled>
                                    </div>
                                </div>
                            </div>
                    <?php } ?>


                    <div class="panel-body mt-3">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> EMERGENCY CONTACT INFORMATION<br />
                            <small>The individuals listed below may be contacted in the event of an emergency while undertaking activities related to this grant opportunity, including any possible travel required for interviews in Indonesia.</small>
                        </p>
                    </div>
                    <div id="wrap-label">
                        <?php if ($emergency) {
                            foreach ($emergency as $key => $row) {
                                $del_btn = '';
                                if ($key > 0) {
                                    $del_btn = '<a href="javascript:;" onclick="del_item(this, \'label-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
                                } ?>
                                        <div id="label-item-<?php echo $key ?>" class="label-item" style="position:relative">
                                            <div class="panel-body" style="margin-top:-20px;">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>First/Given Name</label>
                                                        <input type="text" class="form-control" name="info[emergency][<?= $key ?>][firs_name_temp]" placeholder="First/Given Name" value="<?= $row->first_name ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Middle Name</label>
                                                        <input type="text" class="form-control" name="info[emergency][<?= $key ?>][middle_name_temp]" placeholder="Middle Name" value="<?= $row->middle_name ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Last/Family Name</label>
                                                        <input type="text" class="form-control" name="info[emergency][<?= $key ?>][last_name_temp]" placeholder="Last/Family Name" value="<?= $row->last_name ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <select id="temp_country" class="form-control select2 select-country" name="info[emergency][<?= $key ?>][country_temp]" onchange="show_pcode('country_temp', 'home_phone_code')" style="width:100%" disabled>
                                                            <option value="">-- Select Country --</option>
                                                            <?php
                                                            if ($country_list) {
                                                                foreach ($country_list as $cl) {
                                                                    $selected = '';
                                                                    if ($row->country == $cl->id) {
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
                                                    <div class="form-group">
                                                        <label>Street</label>
                                                        <input type="text" class="form-control" name="info[emergency][<?= $key ?>][street_temp]" value="<?php echo $row->street ?>" placeholder="Street" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group pos-rel">
                                                        <label>State/Province</label>
                                                        <select id="temp_state" class="form-control select2 select-state" name="info[emergency][<?= $key ?>][provinci_temp]" style="width:100%" disabled>
                                                            <option value="">-- Select State/Province --</option>
                                                            <?php
                                                            if ($emergency_states) {
                                                                foreach ($emergency_states[$key] as $st) {
                                                                    $selected = '';
                                                                    if ($row->provinci == $st->id) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                    ?>
                                                                            <option value="<?php echo $st->id ?>" <?php echo $selected ?>><?php echo $st->name ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <img id="load-home_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Postal Code</label>
                                                        <input type="text" class="form-control" name="info[emergency][<?= $key ?>][zipcode_tmep]" value="<?php echo $row->zipcode ?>" placeholder="Postal Code" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group pos-rel">
                                                        <label>City</label>
                                                        <select id="temp_city" class="form-control select2" name="info[emergency][<?= $key ?>][city_temp]" style="width:100%" disabled>
                                                            <option value="">-- Select City --</option>
                                                            <?php
                                                            if ($emergency_cities) {
                                                                foreach ($emergency_cities[$key] as $ct) {
                                                                    $selected = '';
                                                                    if ($row->city == $ct->id) {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                    ?>
                                                                            <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <img id="load-home_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Phone Number</label>
                                                        <input type="text" class="form-control" name="info[emergency][<?= $key ?>][phone_temp]" placeholder="Phone Number" value="<?= $row->phone_number ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control" name="info[emergency][<?= $key ?>][email_temp]" placeholder="Email" value="<?= $row->email ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Relationship to You</label>
                                                        <input type="text" class="form-control" name="info[emergency][<?= $key ?>][relation]" placeholder="Relationship to You" value="<?= $row->relation ?>" disabled>
                                                    </div>
                                                    <input type="hidden" name="info[emergency][<?= $key ?>][emergency_id]" value="<?= $row->id ?>" disabled>
                                                </div>
                                            </div>
                                            <?php echo $del_btn ?>
                                        </div>
                                <?php }
                        } else { ?>
                                <div id="label-item-0" class="label-item" style="position:relative">
                                    <div class="panel-body" style="margin-top:-20px;">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>First/Given Name</label>
                                                <input type="text" class="form-control" name="info[emergency][0][firs_name_temp]" placeholder="First/Given Name" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input type="text" class="form-control" name="info[emergency][0][middle_name_temp]" placeholder="Middle Name" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Last/Family Name</label>
                                                <input type="text" class="form-control" name="info[emergency][0][last_name_temp]" placeholder="Last/Family Name" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <select id="temp_country" class="form-control select2 select-country" name="info[emergency][0][country_temp]" onchange="show_pcode('country_temp', 'home_phone_code')" style="width:100%" disabled>
                                                    <option value="">-- Select Country --</option>
                                                    <?php
                                                    if ($country_list) {
                                                        foreach ($country_list as $cl) {
                                                            $selected = '';
                                                            if ($this->Grantee_ent_model->country_temp == $cl->id) {
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
                                            <div class="form-group">
                                                <label>Street</label>
                                                <input type="text" class="form-control" name="info[emergency][0][street_temp]" value="<?php echo $this->Grantee_ent_model->street_temp ?>" placeholder="Street" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group pos-rel">
                                                <label>State/Province</label>
                                                <select id="temp_state" class="form-control select2 select-state" name="info[emergency][0][provinci_temp]" style="width:100%" disabled>
                                                    <option value="">-- Select State/Province --</option>
                                                    <?php
                                                    if ($emergency_states) {
                                                        foreach ($emergency_states[$key] as $st) {
                                                            $selected = '';
                                                            if ($this->Grantee_ent_model->provinci_temp == $st->id) {
                                                                $selected = 'selected="selected"';
                                                            }
                                                            ?>
                                                                    <option value="<?php echo $st->id ?>" <?php echo $selected ?>><?php echo $st->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <img id="load-home_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                            </div>
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="text" class="form-control" name="info[emergency][0][zipcode_tmep]" value="<?php echo $this->Grantee_ent_model->zipcode_tmep ?>" placeholder="Postal Code" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group pos-rel">
                                                <label>City</label>
                                                <select id="temp_city" class="form-control select2" name="info[emergency][0][city_temp]" style="width:100%" disabled>
                                                    <option value="">-- Select City --</option>
                                                    <?php
                                                    if ($emergency_cities) {
                                                        foreach ($emergency_cities[$key] as $ct) {
                                                            $selected = '';
                                                            if ($this->Grantee_ent_model->city_temp == $ct->id) {
                                                                $selected = 'selected="selected"';
                                                            }
                                                            ?>
                                                                    <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <img id="load-home_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" class="form-control" name="info[emergency][0][phone_temp]" placeholder="Phone Number" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" name="info[emergency][0][email_temp]" placeholder="Email" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Relationship to You</label>
                                                <input type="text" class="form-control" name="info[emergency][0][relation]" placeholder="Relationship to You" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php } ?>
                    </div>
                    <div class="panel-body" style="margin-top:-20px">
                        <div class="col-lg-12">
                            <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load-label" style="display:none;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12" style="margin-bottom:10px;">
                <div style="margin-bottom:10px;">

                    <?php
                    if ($this->Grantee_ent_model->id) {
                        ?>
                            <input type="hidden" name="id" id="uid" value="<?php echo $this->Grantee_ent_model->id ?>">
                    <?php } ?>

                </div>
            </div>
        </div>
        <?php $this->load->view('admin/selection/submission_section'); ?>
    </div>
</div>
<?php $this->load->view('admin/partials/modal_confirm') ?>