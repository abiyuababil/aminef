<?php
$active_country = $this->session->userdata('active_country');
$is_admin = is_admin() && $is_grantee_page == false;
if ($is_grantee_page) {
    $active_country = $this->session->userdata('grantee_active_country');
}
$number_alfa = range('a', 'z');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';

if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}

$checkbox_current_residence = true;
 
if ($this->Grantee_ent_model->country != $this->Grantee_ent_model->residence_country && $checkbox_current_residence == true) {
    $checkbox_current_residence = false;
}

if ($this->Grantee_ent_model->street != $this->Grantee_ent_model->residence_street && $checkbox_current_residence == true) {
    $checkbox_current_residence = false;
}

if ($this->Grantee_ent_model->provinci != $this->Grantee_ent_model->residence_state && $checkbox_current_residence == true) {
    $checkbox_current_residence = false;
}

if ($this->Grantee_ent_model->zipcode != $this->Grantee_ent_model->residence_zipcode && $checkbox_current_residence == true) {
    $checkbox_current_residence = false;
}

if ($this->Grantee_ent_model->city != $this->Grantee_ent_model->residence_city && $checkbox_current_residence == true) {
    $checkbox_current_residence = false;
}

?>

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

    #table-report td {
        height: 80px;
        vertical-align: top;
        padding: 10px;
        font-weight: bold;
    }

    #table-report tr {
        margin-top: 20px;
    }

    .invalid-tooltip {
        position: absolute;
        top: auto;
        z-index: 5;
        display: none;
        max-width: 100%;
        padding: 0.5rem;
        margin-top: 0.1rem;
        font-size: 12px;
        line-height: 1;
        color: #fff;
        background-color: rgba(220, 53, 69, .8);
        border-radius: 0.2rem;
    }

    #success-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }
    .checkbox.checbox-switch {
        padding-left: 0;
    }

    .checkbox.checbox-switch label,
    .checkbox-inline.checbox-switch {
        display: inline-block;
        position: relative;
        padding-left: 0;
    }
    .checkbox.checbox-switch label input,
    .checkbox-inline.checbox-switch input {
        display: none;
    }
    .checkbox.checbox-switch label span,
    .checkbox-inline.checbox-switch span {
        width: 35px;
        border-radius: 20px;
        height: 18px;
        border: 1px solid #dbdbdb;
        background-color: rgb(255, 255, 255);
        border-color: rgb(223, 223, 223);
        box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset;
        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }
    .checkbox.checbox-switch label span:before,
    .checkbox-inline.checbox-switch span:before {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: rgb(255,255,255);
        content: " ";
        top: 0;
        position: relative;
        left: 0;
        transition: all 0.3s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.4);
    }
    .checkbox.checbox-switch label > input:checked + span:before,
    .checkbox-inline.checbox-switch > input:checked + span:before {
        left: 17px;
    }


    /* Switch Default */
    .checkbox.checbox-switch label > input:checked + span,
    .checkbox-inline.checbox-switch > input:checked + span {
        background-color: rgb(180, 182, 183);
        border-color: rgb(180, 182, 183);
        box-shadow: rgb(180, 182, 183) 0px 0px 0px 8px inset;
        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
    }
    .checkbox.checbox-switch label > input:checked:disabled + span,
    .checkbox-inline.checbox-switch > input:checked:disabled + span {
        background-color: rgb(220, 220, 220);
        border-color: rgb(220, 220, 220);
        box-shadow: rgb(220, 220, 220) 0px 0px 0px 8px inset;
        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
    }
    .checkbox.checbox-switch label > input:disabled + span,
    .checkbox-inline.checbox-switch > input:disabled + span {
        background-color: rgb(232,235,238);
        border-color: rgb(255,255,255);
    }
    .checkbox.checbox-switch label > input:disabled + span:before,
    .checkbox-inline.checbox-switch > input:disabled + span:before {
        background-color: rgb(248,249,250);
        border-color: rgb(243, 243, 243);
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }

    /* Switch Primary */
    .checkbox.checbox-switch.switch-primary label > input:checked + span,
    .checkbox-inline.checbox-switch.switch-primary > input:checked + span {
        background-color: rgb(0, 105, 217);
        border-color: rgb(0, 105, 217);
        box-shadow: rgb(0, 105, 217) 0px 0px 0px 8px inset;
        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
    }
    .checkbox.checbox-switch.switch-primary label > input:checked:disabled + span,
    .checkbox-inline.checbox-switch.switch-primary > input:checked:disabled + span {
        background-color: rgb(109, 163, 221);
        border-color: rgb(109, 163, 221);
        box-shadow: rgb(109, 163, 221) 0px 0px 0px 8px inset;
        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
    }
</style>

<div class="alert alert-success" id="success-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Autosave <strong>Success! </strong>
</div>

<div class="modal"></div>

<div class="row">
    <?php if ($is_admin) { ?>
        <div class="col-lg-12">
            <?php
            $explode = explode('/', current_url());
            $url = end($explode);
            if ($url != 'add') {
            ?>
                <a href="#" id="btn-deleted" class="btn btn-danger" data-id="<?= $this->Grantee_ent_model->id ?>" style="float:right;margin: 20px 0;">Delete Grantee</a>
            <?php } ?>
            <a href="<?= base_url('admin/grantee/history_file/' . $this->Grantee_ent_model->id) ?>" class="btn btn-primary" style="float:right;margin: 20px 3px;">History File</a>
            <h1 class="page-header"><?php echo $title ?></h1>
        </div>
    <?php } else { ?>
        <div class="col-lg-12 text-center">
            <h2 style="color:#0089d1">Form</h2>
            <h1 class="page-header"><?php echo $title ?></h1>
        </div>
    <?php } ?>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>
<?php if(!empty($other_account['data_grantee'])) { ?>
<div class="row">
    <div class="col-lg-12">
        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Other Account</p>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="35" class="text-center">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>KTP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($other_account['data_grantee'] as $grantee) : ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><a target="_BLANK" href="<?php echo base_url('admin/grantee/edit/' . $grantee->id); ?>"><?= get_full_name($grantee) ?></a></td>
                        <td><?= $grantee->primary_email ?></td>
                        <td><?= $grantee->number_identity ?></td>
                    </tr>
                    <?php $no++; endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php //if($other_account['data_grantee_grant']) { ?>
        <!-- <h4 class="text-left">Note Rejected: </h4> -->
        <!-- <div class="alert alert-danger" role="alert" style="height:auto">
            <?php
                if ($other_account['data_grantee_grant']->status == STATUS_SELECTION_DECLINED) {
                    $note_reject = $other_account['data_grantee_grant']->note_selection;
                }else if($other_account['data_grantee_grant']->status == STATUS_CANDIDATE_DECLINED){
                    $note_reject = $other_account['data_grantee_grant']->note_candidate;
                }else if($other_account['data_grantee_grant']->status == STATUS_ON_GOING_DECLINED){
                    $note_reject = $other_account['data_grantee_grant']->note_ongoing;
                } 
            
            ?>
            <h4 class="alert-heading text-justify"><?= $note_reject ?></h4>
        </div> -->
        <?php //} ?>
    </div>
</div>
<?php } ?>

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="<?= $this->Grantee_ent_model->id ?>" id="grantee_id">
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px">
            <ul class="nav nav-pills">
                <li <?php echo $default_tab_active ?>><a data-toggle="tab" href="#personal" aria-expanded="true">Personal Information</a></li>
                <li><a data-toggle="tab" href="#contact" aria-expanded="true">Contact Information</a></li>
                <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE){ ?>
                    <li><a data-toggle="tab" href="#us_address" aria-expanded="true">US Address</a></li>
                <?php } ?>
                <li><a data-toggle="tab" href="#history" aria-expanded="true">Previous Scholarship</a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div id="personal" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> NAME</p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Prefix</label>
                                    <select class="form-control" id="prefix_name" name="prefix_name" <?php echo disable_if_filled($this->Grantee_ent_model->prefix_name); ?>>
                                        <option value="">-- Select Prefix --</option>
                                        <?php
                                        if ($titles) {
                                            foreach ($titles as $tt) {
                                                $selected = '';
                                                if ($this->Grantee_ent_model->prefix_name == $tt) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $tt ?>" <?php echo $selected ?>><?php echo $tt ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <input type="text" class="form-control mt-2" name="prefix_other" id="prefix_other" placeholder="Enter prefix" value="<?= $this->Grantee_ent_model->prefix_other ?>" <?php echo disable_if_filled($this->Grantee_ent_model->prefix_name); ?> style="display: none;">
                                    <!-- <input type="text" class="form-control" name="prefix_name" value="<?php echo $this->Grantee_ent_model->prefix_name ?>" placeholder="Prefix"> -->
                                </div>
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control auto-capitalize" name="middle_name" value="<?php echo $this->Grantee_ent_model->middle_name ?>" placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label>Suffix (Jr./Sr.I/II/II)</label>
                                    <input type="text" class="form-control" name="suffix_ame" value="<?php echo $this->Grantee_ent_model->suffix_ame ?>" placeholder="Suffix">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>First/Given Name</label>
                                    <input type="text" class="form-control auto-capitalize" name="first_name" value="<?php echo $this->Grantee_ent_model->first_name ?>" placeholder="First/Given Name">
                                    <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE){ ?>
                                    <input type="checkbox" value="1" autocomplete="off" name="dont_have_first_name" class="dont_have_first_name" id="dont_have_first_name5" <?= $this->Grantee_ent_model->dont_have_first_name == 1 ? "checked" : "" ?>>
                                    <label class="is_unlimited_label" for="dont_have_first_name5">I do not have a first/given name</label>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>Last/Family Name</label>
                                    <input type="text" class="form-control auto-capitalize" name="last_name" value="<?php echo $this->Grantee_ent_model->last_name ?>" placeholder="Last/Family Name">
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
                                            <a href="javascript:;" title="Click to Delete Photo" onclick="del_file(this, 'img_photo', 'Photo')" class="btn btn-danger btn-xs btn-d-none" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_photo ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5" style="position:absolute; top:0; right:-28px;">
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
                                    <input type="file" name="img_photo" accept="<?php foreach(ALLOWED_PROFILE_FILETYPE as $filetype) { echo "image/" . $filetype . ","; } ?>" onchange="show_preview(this, 'profile');" id="input_photo">
                                    <small class="file-for-testing">
                                        File Size Max 5MB 
                                        <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                        <b>
                                        | Supported File <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')) ; ?> 
                                        </b>
                                        <?php } ?>
                                    </small>
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
                                    <input type="text" class="form-control" name="previous_first_name" value="<?php echo $this->Grantee_ent_model->previous_first_name ?>" placeholder="First/Given Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control" name="previous_middle_name" value="<?php echo $this->Grantee_ent_model->previous_middle_name ?>" placeholder="Middle Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Last/Family Name</label>
                                    <input type="text" class="form-control" name="previous_last_name" value="<?php echo $this->Grantee_ent_model->previous_last_name ?>" placeholder="Last/Family Name">
                                </div>
                            </div>
                        </div>


                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BIOGRAPHICAL INFORMATION</p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input type="text" class="form-control datepicker" name="birth_date" value="<?php echo ($this->Grantee_ent_model->birth_date) ? date('d M Y', strtotime($this->Grantee_ent_model->birth_date)) : '' ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country of Birth</label><?= $required_label ?>
                                    <select id="birth_country" class="form-control select2 select-country-birth" name="birth_country" id="birth_country">
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
                                    <div id="invalid_birth_country" class="text-danger invalid-tooltip">
                                        Country of Birth is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>State of Birth</label><?= $required_label ?>
                                    <select id="birth_state" class="form-control select2 select-state-birth" name="birth_state" id="birth_state">
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
                                    <div id="invalid_birth_country" class="text-danger invalid-tooltip">
                                        Country of Birth is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>City of Birth</label><?= $required_label ?>
                                    <select id="birth_city" class="form-control select2 select-city-birth" name="birth_city" id="birth_city">
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
                                    <div id="invalid_birth_country" class="text-danger invalid-tooltip">
                                        Country of Birth is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Gender</label><?= $required_label ?>
                                    <select class="form-control" name="gender" id="gender">
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
                                    <div id="invalid_gender" class="text-danger invalid-tooltip">
                                        Gender is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>
                                        Physical Impairment
                                        <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="The Fulbright Program complies with the Americans with Disabilities Act (the “ADA”) and is committed to diversity and inclusion. If you have any form of limitation that requires accommodation, please indicate that here. This information is gathered only for statistical purposes and to ensure appropriate accommodation at a prospective host institution.">i</span>
                                    </label>

                                    <input type="text" class="form-control" name="physical_impairment" value="<?php echo $this->Grantee_ent_model->physical_impairment ?>" placeholder="Physical Impairment">
                                </div>
                            </div>
                            <!-- <div class="col-lg-4">
                                <div class="form-group">
                                    <label>City of Birth</label>
                                    <input type="text" class="form-control" name="birth_city" value="<?= $this->Grantee_ent_model->birth_city ?>">
                                </div>
                            </div> -->
                        </div>
                        
                        <?php /*
                        <div class="panel-body mt-3" style="margin-bottom:-30px;">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> ACADEMIC BACKGROUND</p>
                        </div>
                        <div id="wrap-institution">
                            <?php if ($academic) {
                                foreach ($academic as $key => $row) {
                                    $del_btn = '';
                                    $separator = '';
                                    if ($key > 0) {
                                        $del_btn = '<a href="javascript:;" onclick="del_item(this, \'institution-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
                                        $separator = '<hr>';
                                    } ?>
                                    <div id="institution-item-<?php echo $key ?>" class="institution-item" style="position:relative;margin-top:-25px;">
                                        <?= $separator ?>
                                        <div class="panel-body">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Institution Name</label>
                                                    <input type="text" class="form-control" name="info[institution][<?= $key ?>][name]" value="<?= $row->name ?>" placeholder="Institution Name">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Level of Study</label>
                                                    <!-- <input type="text" class="form-control" name="info[institution][<?= $key ?>][level_study]" placeholder="Level of Study" value="<?= $row->level_study ?>"> -->
                                                    <select class="form-control" name="info[institution][<?= $key ?>][level_study]">
                                                        <option value="">-- Select Level of Study --</option>
                                                        <?php
                                                        if ($level_study) {
                                                            foreach ($level_study as $ls) {
                                                                $selected = '';
                                                                if ($row->level_study == $ls) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                        ?>
                                                                <option value="<?php echo $ls ?>" <?php echo $selected ?>><?php echo $ls ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-25px;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select id="institution_country<?= $key ?>" class="form-control select2" onchange="select_country(<?= $key ?>)" name="info[institution][<?= $key ?>][country]" style="width:100%">
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
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>State/Province</label>
                                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="load-province-academic<?= $key ?>" style="display:none;">
                                                    <select id="institution_state<?= $key ?>" class="form-control select2" onchange="select_state(<?= $key ?>)" name="info[institution][<?= $key ?>][province]" style="width:100%">
                                                        <option value="">-- Select State/Province --</option>
                                                        <?php
                                                        if ($academic_states) {
                                                            foreach ($academic_states[$key] as $ct) {
                                                                $selected = '';
                                                                if ($row->province == $ct->id) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                        ?>
                                                                <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="load-city-academic<?= $key ?>" style="display:none;">
                                                    <select id="institution_city<?= $key ?>" class="form-control select2" name="info[institution][<?= $key ?>][city]" style="width:100%">
                                                        <option value="">-- Select City --</option>
                                                        <?php
                                                        if ($academic_cities) {
                                                            foreach ($academic_cities[$key] as $ct) {
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-20px">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Name of Diploma or Degree Equivalent</label>
                                                    <input type="text" class="form-control" name="info[institution][<?= $key ?>][degree_name]" placeholder="Name of Diploma or Degree Equivalent" value="<?= $row->degree_name ?>">
                                                    <small class="text-danger">(e.g. BA/MA/MFA)</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Actual Name of Degree or Diploma</label>
                                                    <input type="text" class="form-control" name="info[institution][<?= $key ?>][degree_actual]" value="<?php echo $row->degree_actual ?>" placeholder="Actual Name of Degree or Diploma">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Discipline</label>
                                                    <input type="text" class="form-control" name="info[institution][<?= $key ?>][discipline]" value="<?php echo $row->discipline ?>" placeholder="Discipline">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-25px;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Enrolled From</label>
                                                    <input type="text" class="form-control datepicker" name="info[institution][<?= $key ?>][endrolled_from]" value="<?= ($row->endrolled_from) ? date('d M Y', strtotime($row->endrolled_from)) : '' ?>" placeholder="Enrolled From">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Enrolled To</label>
                                                    <input type="text" class="form-control datepicker" name="info[institution][<?= $key ?>][endrolled_to]" value="<?= ($row->endrolled_to) ? date('d M Y', strtotime($row->endrolled_to)) : '' ?>" placeholder="Enrolled To">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Date Degree Received</label>
                                                    <input type="text" class="form-control datepicker" name="info[institution][<?= $key ?>][degree_date]" placeholder="Date Degree Received" value="<?= ($row->degree_date) ? date('d M Y', strtotime($row->degree_date)) : '' ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo $del_btn ?>
                                    </div>
                                <?php }
                            } else { ?>
                                <div id="institution-item-0" class="institution-item" style="position:relative">
                                    <div class="panel-body">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Institution Name</label>
                                                <input type="text" class="form-control" name="info[institution][0][name]" placeholder="Institution Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Level of Study</label>
                                                <input type="text" class="form-control" name="info[institution][0][level_study]" placeholder="Level of Study">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="margin-top:-25px;">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <select id="institution_country" class="form-control select2 select-country" name="info[institution][0][country]" style="width:100%">
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
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>State/Province</label>
                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="load-province-academic" style="display:none;">
                                                <select id="institution_state" class="form-control select2 select-province-academic" name="info[institution][<?= $key ?>][province]" style="width:100%">
                                                    <option value="">-- Select State/Province --</option>
                                                    <?php
                                                    if ($academic_states) {
                                                        foreach ($academic_states[$key] as $ct) {
                                                            $selected = '';
                                                            if ($row->province == $ct->id) {
                                                                $selected = 'selected="selected"';
                                                            }
                                                    ?>
                                                            <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="load-city-academic" style="display:none;">
                                                <select id="institution_city" class="form-control select2 select-city-academic" name="info[institution][0][city]" style="width:100%">
                                                    <option value="">-- Select City --</option>
                                                    <?php
                                                    if ($academic_cities) {
                                                        foreach ($academic_cities[$key] as $ct) {
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="margin-top:-20px">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Name of Diploma or Degree Equivalent</label>
                                                <input type="text" class="form-control" name="info[institution][0][degree_name]" placeholder="Name of Diploma or Degree Equivalent">
                                                <small class="text-danger">(e.g. BA/MA/MFA)</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Actual Name of Degree or Diploma</label>
                                                <input type="text" class="form-control" name="info[institution][0][degree_actual]" placeholder="Actual Name of Degree or Diploma">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Discipline</label>
                                                <input type="text" class="form-control" name="info[institution][0][discipline]" placeholder="Discipline">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="margin-top:-20px;">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Enrolled From</label>
                                                <input type="text" class="form-control datepicker" name="info[institution][0][endrolled_from]" placeholder="Enrolled From">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Enrolled To</label>
                                                <input type="text" class="form-control datepicker" name="info[institution][0][endrolled_to]" placeholder="Enrolled To">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Date Degree Received</label>
                                                <input type="text" class="form-control datepicker" name="info[institution][0][degree_date]" placeholder="Date Degree Received">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="panel-body" style="margin-top:-20px">
                            <div class="col-lg-12">
                                <a href="javascript:;" onclick="add_institution()" class="btn btn-primary">
                                    <i class="fa fa-plus fa-fw"></i> Add Institution
                                </a>
                                <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load" style="display:none;">
                            </div>
                        </div>
                        */ ?>

                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> CITIZENSHIP INFORMATION</p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country of Citizenship</label>
                                    <select id="citizen_country" class="form-control select2 select-country" name="citizen_country" onchange="show_pcode('citizen_country', 'home_phone_code')" style="width:100%">
                                        <option value="">-- Select Country --</option>
                                        <?php
                                        if ($citizen_country_list) {
                                            foreach ($citizen_country_list as $cl) {
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
                                    <input type="text" class="form-control" name="number_identity" value="<?php echo $this->Grantee_ent_model->number_identity ?>" placeholder="KTP">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Passport Number</label>
                                    <input type="text" class="form-control" name="number_passport" value="<?php echo $this->Grantee_ent_model->number_passport ?>" placeholder="Passport Number">
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

                                            <a href="javascript:;" onclick="del_file(this, 'img_passport', 'Passport')" class="btn btn-danger btn-xs btn-d-none" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_passport ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5" style="position:absolute; top:0; right:-28px;">
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
                                    <input type="file" name="img_passport" accept="<?php foreach(ALLOWED_PROFILE_FILETYPE as $filetype) { echo "image/" . $filetype . ","; } ?>" id="img_passport" onchange="show_preview(this, 'ktp');">
                                    <small class="file-for-testing">
                                        File Size Max 5MB 
                                        <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                        <b>
                                        | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')) ; ?> 
                                        </b>
                                        <?php } ?>
                                    </small>
                                    <div id="invalid_img_passport" class="text-danger invalid-tooltip">
                                        Please Choose File.
                                    </div>
                                    <div id="invalid_img_passport_size" class="text-danger invalid-tooltip">
                                        Max File Size 5Mb.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Passport (Follow the guide <a href="<?= site_url('img/passport_photo_sample.jpg') ?>" class="lightbox">here</a>)</label>
                                    <?php if ($this->Grantee_ent_model->img_passport_id != '') { ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                            <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_passport_id ?>" class="lightbox" aria-haspopup="dialog">
                                                <?php 
                                                    $fileextension = get_file_extension($this->Grantee_ent_model->img_passport_id); 
                                                    if (in_array($fileextension, ALLOWED_PROFILE_FILETYPE)) { 
                                                ?>
                                                    <img id="preview_image_passport" src="<?php echo get_preview($this->Grantee_ent_model->img_passport_id) ?>" width="100">
                                                <?php } else if ($fileextension == 'pdf') { ?>
                                                    <img id="preview_image_passport" src="<?php echo base_url('assets/images/icons/pdf.svg'); ?>" width="100">
                                                <?php } else { ?>
                                                    <img id="preview_image_passport" src="<?php echo base_url('assets/images/icons/document-filetype.png'); ?>" width="100">
                                                <?php } ?>
                                            </a>

                                            <a href="javascript:;" onclick="del_file(this, 'img_passport_id', 'Passport')" class="btn btn-danger btn-xs btn-d-none" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_passport_id ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5" style="position:absolute; top:0; right:-28px;">
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
                                    <input type="file" name="img_passport_id" accept="<?php foreach(ALLOWED_PROFILE_FILETYPE as $filetype) { echo "image/" . $filetype . ","; } ?>" id="img_passport_id" onchange="show_preview(this, 'ktp');">
                                    <small class="file-for-testing">
                                        File Size Max 5MB 
                                        <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                        <b>
                                        | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')) ; ?> 
                                        </b>
                                        <?php } ?>
                                    </small>
                                    <div id="invalid_img_passport_id" class="text-danger invalid-tooltip">
                                        Please Choose File.
                                    </div>
                                    <div id="invalid_img_passport_id_size" class="text-danger invalid-tooltip">
                                        Max File Size 5Mb.
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BANK INFO</p>
                            <?php if($this->Grantee_ent_model->country_id == AMERICAN_DATABASE) { ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <input type="text" class="form-control" name="bank_name" value="<?php echo $this->Grantee_ent_model->bank_name ?>" placeholder="Bank Name">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Bank Address</label>
                                        <input type="text" class="form-control" name="bank_address" value="<?php echo $this->Grantee_ent_model->bank_address ?>" placeholder="Bank Address">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Beneficiary Name</label>
                                        <input type="text" class="form-control" name="beneficiary_name" value="<?php echo $this->Grantee_ent_model->beneficiary_name ?>" placeholder="Beneficiary Name">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Void Check</label>
                                        <input type="text" class="form-control" name="account_number" value="<?php echo $this->Grantee_ent_model->account_number ?>" placeholder="Void Check">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Routing Number</label>
                                        <input type="text" class="form-control" name="routing_number" value="<?php echo $this->Grantee_ent_model->routing_number ?>" placeholder="Routing Number">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Swift Code</label>
                                        <input type="text" class="form-control" name="swift_code" value="<?php echo $this->Grantee_ent_model->swift_code ?>" placeholder="Swift Code">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Currency</label>
                                        <!-- <input type="text" class="form-control" name="currency" value="<?php //echo $this->Grantee_ent_model->currency 
                                                                                                            ?>" placeholder="Currency"> -->
                                        <select class="form-control" name="currency" id="currency">
                                            <option value="">-- Select Currency --</option>
                                            <?php
                                            if ($currency) {
                                                foreach ($currency as $cr) {
                                                    $selected = '';
                                                    if ($this->Grantee_ent_model->currency == $cr) {
                                                        $selected = 'selected="selected"';
                                                    }
                                            ?>
                                                    <option value="<?php echo $cr ?>" <?php echo $selected ?>><?php echo $cr ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Account Book</label>
                                        <?php if ($this->Grantee_ent_model->account_book != '') { ?>
                                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                                <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->account_book ?>" class="lightbox" aria-haspopup="dialog">
                                                    <img id="preview_image_account_book" src="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->account_book ?>" width="100">
                                                </a>
                                                <a href="javascript:;" onclick="del_file(this, 'account_book', 'Account Book')" class="btn btn-danger btn-xs btn-d-none" style="position:absolute; top:0; right:-28px;">
                                                    <i class="fa fa-trash fa-fw"></i>
                                                </a>
                                                <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->account_book ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5" style="position:absolute; top:0; right:-28px;">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <div id="preview_section_account_book" style="margin-bottom: 10px; position:relative; width:100px; display:none;">
                                                <a>
                                                    <img id="preview_image_account_book" width="100">
                                                </a>
                                            </div>
                                        <?php } ?>
                                        <input type="file" name="account_book" onchange="show_preview(this, 'account_book');">
                                        <small class="file-for-testing">File Size Max 5MB</small>
                                    </div>
                                </div>
                            <?php }else{ ?>
                                <?php 
                                    if($this->Grantee_ent_model->bank_name) { 
                                        $select_bank = $bank_info ? array_column($bank_info, 'is_selected') : [];
                                        $default_bank_info = !in_array(1, $select_bank);
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="checkbox checbox-switch switch-primary">
                                                    <label style="margin-left: -15px;">
                                                        <input type="checkbox" name="check_default" class="check_default" <?= $default_bank_info ? 'checked' : '' ?> />
                                                        <span></span>
                                                        Select as Default
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Bank Name</label><?= $required_label ?>
                                            <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $this->Grantee_ent_model->bank_name ?>" placeholder="Bank Name">
                                            <div id="invalid_bank_name" class="text-danger invalid-tooltip">
                                                Bank Name is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Bank Address</label><?= $required_label ?>
                                            <input type="text" class="form-control" name="bank_address" id="bank_address" value="<?php echo $this->Grantee_ent_model->bank_address ?>" placeholder="Bank Address">
                                            <div id="invalid_bank_address" class="text-danger invalid-tooltip">
                                                Bank Address is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Beneficiary Name</label><?= $required_label ?>
                                            <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name" value="<?php echo $this->Grantee_ent_model->beneficiary_name ?>" placeholder="Full Name">
                                            <div id="invalid_beneficiary_name" class="text-danger invalid-tooltip">
                                                Full Name is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Account Number</label><?= $required_label ?>
                                            <input type="text" class="form-control" name="account_number" id="account_number" value="<?php echo $this->Grantee_ent_model->account_number ?>" placeholder="Account Number">
                                            <div id="invalid_account_number" class="text-danger invalid-tooltip">
                                                Account Number is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Routing Number</label><?= $required_label ?>
                                            <input type="text" class="form-control" name="routing_number" id="routing_number" value="<?php echo $this->Grantee_ent_model->routing_number ?>" placeholder="Routing Number">
                                            <div id="invalid_routing_number" class="text-danger invalid-tooltip">
                                                Routing Number is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Swift Code</label><?= $required_label ?>
                                            <input type="text" class="form-control" name="swift_code" id="swift_code" value="<?php echo $this->Grantee_ent_model->swift_code ?>" placeholder="Swift Code">
                                            <input type="hidden" id="swift_code_checking_filler" value="<?php echo $this->Grantee_ent_model->swift_code ?>">
                                            <div id="invalid_swift_code" class="text-danger invalid-tooltip">
                                                Swift Code is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Currency</label><?= $required_label ?>
                                            <!-- <input type="text" class="form-control" name="currency" id="currency" value="<?php echo $this->Grantee_ent_model->currency ?>" placeholder="Currency"> -->
                                            <select class="form-control" name="currency" id="currency">
                                                <option value="">-- Select Currency --</option>
                                                <?php
                                                if ($currency) {
                                                    foreach ($currency as $cr) {
                                                        $selected = '';
                                                        if ($this->Grantee_ent_model->currency == $cr) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                ?>
                                                        <option value="<?php echo $cr ?>" <?php echo $selected ?>><?php echo $cr ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div id="invalid_currency" class="text-danger invalid-tooltip">
                                                Currency is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label><?= $active_country == AMERICAN_DATABASE ? 'Void Check' : 'First page of bank account information (buku tabungan halaman pertama)' ?> <?php echo $active_country == AMERICAN_DATABASE ? '(optional)' : ''; ?></label>
                                            <?php 
                                                $account_book = user_grantee_file_url($user_grantee, 'account_book');
                                            ?>
                                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                                <a href="<?php echo site_url($account_book); ?>" class="lightbox" aria-haspopup="dialog">
                                                    <img id="preview_image_account_book" data-old="<?php echo site_url($account_book); ?>" src="<?php echo get_preview($account_book); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                </a>
                                                <a href="javascript:;" onclick="del_file(this, 'account_book', 'Account Book')" id="button_delete_account_book" class="btn btn-danger btn-xs <?php echo empty($this->Grantee_ent_model->account_book) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                    <i class="fa fa-trash fa-fw"></i>
                                                </a>
                                                <a href="<?php echo base_url($account_book) ?>" id="button_download_account_book" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($this->Grantee_ent_model->account_book) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                            </div>
                                            <input type="file" class="custom-file-input hide" accept="<?php foreach(ALLOWED_PROFILE_FILETYPE as $filetype) { echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ","; } ?>" id="account_book" onchange="show_preview(this, 'account_book', 'account_book');">
                                            <input type="hidden" name="account_book" value="<?php echo $this->Grantee_ent_model->account_book; ?>">
                                            <label class="btn btn-primary upload-button" for="account_book"> Choose file </label> 
                                            <a href="<?php echo site_url($account_book) ?>" id="button_preview_account_book" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                            <div>
                                                <small class="file-for-testing">
                                                    File Size Max 5MB 
                                                    <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                    | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')) ; ?> 
                                                    <?php } ?>
                                                </small>
                                                <div id="invalid_photo" class="text-danger invalid-tooltip">
                                                    Max File Size 5Mb.
                                                </div>
                                                <div id="invalid_photo_required" class="text-danger invalid-tooltip">
                                                    Please Choose File.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <?php } ?>

                                <?php foreach($bank_info as $kb => $bi) { ?>
                                <div class="row">
                                    <?= $kb > 0 ? '<hr>' : '' ?>
                                    <div class="col-lg-12">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="checkbox checbox-switch switch-primary">
                                                    <label style="margin-left: -15px;">
                                                        <input type="checkbox" name="other_bank_info[<?php echo $kb; ?>][check_default]" <?= $bi->is_selected ? 'checked' : '' ?> class="check_default" />
                                                        <span></span>
                                                        Select as Default
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Bank Name</label>
                                            <input type="hidden" class="form-control" name="other_bank_info[<?php echo $kb; ?>][id]" value="<?php echo $bi->id; ?>" placeholder="Bank Name">
                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $kb; ?>][bank_name]" value="<?php echo $bi->bank_name ?>" placeholder="Bank Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Bank Address</label>
                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $kb; ?>][bank_address]" value="<?php echo $bi->bank_address ?>" placeholder="Bank Address">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Beneficiary Name</label>
                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $kb; ?>][beneficiary_name]" value="<?php echo $bi->beneficiary_name ?>" placeholder="Beneficiary Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Account Number</label>
                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $kb; ?>][account_number]" value="<?php echo $bi->account_number ?>" placeholder="Account Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Routing Number</label>
                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $kb; ?>][routing_number]" value="<?php echo $bi->routing_number ?>" placeholder="Routing Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Swift Code</label>
                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $kb; ?>][swift_code]" value="<?php echo $bi->swift_code ?>" placeholder="Swift Code">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Currency</label>
                                            <select class="form-control" name="other_bank_info[<?php echo $kb; ?>][currency]" id="currency">
                                                <option value="">-- Select Currency --</option>
                                                <?php
                                                if ($currency) {
                                                    foreach ($currency as $cr) {
                                                        $selected = '';
                                                        if ($bi->currency == $cr) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                ?>
                                                        <option value="<?php echo $cr ?>" <?php echo $selected ?>><?php echo $cr ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>First page of bank account information (buku tabungan halaman pertama)</label>
                                            <?php 
                                                $account_book = user_grantee_file_url($bi, 'account_book');
                                            ?>
                                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                                <a href="<?php echo site_url($account_book); ?>" class="lightbox" aria-haspopup="dialog">
                                                    <img id="preview_image_account_book-<?php echo $kb; ?>" data-old="<?php echo site_url($account_book); ?>" src="<?php echo get_preview($account_book); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                </a>
                                                <a href="javascript:;" onclick="del_other_bank_attachment(this, 'account_book-<?php echo $kb; ?>', 'Account Book')" id="button_delete_account_book-<?php echo $kb; ?>" class="btn btn-danger btn-xs <?php echo empty($bi->account_book) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                    <i class="fa fa-trash fa-fw"></i>
                                                </a>
                                                <a href="<?php echo base_url($account_book) ?>" id="button_download_account_book-<?php echo $kb; ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($bi->account_book) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                            </div>
                                            <input type="file" class="custom-file-input hide" id="account_book-<?php echo $kb; ?>" onchange="show_preview(this, 'account_book-<?php echo $kb; ?>', 'account_book-<?php echo $kb; ?>');">
                                            <input type="hidden" name="other_bank_info[<?php echo $kb; ?>][account_book]" class="account_book-<?php echo $kb; ?>" value="<?php echo $bi->account_book; ?>">
                                            <label class="btn btn-primary upload-button" for="account_book-<?php echo $kb; ?>"> Choose file </label> 
                                            <a href="<?php echo site_url($account_book) ?>" id="button_preview_account_book-<?php echo $kb; ?>" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                            <div>
                                                <small class="file-for-testing">
                                                    File Size Max 5MB 
                                                    <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                    | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')) ; ?> 
                                                    <?php } ?>
                                                </small>
                                                <div id="invalid_photo" class="text-danger invalid-tooltip">
                                                    Max File Size 5Mb.
                                                </div>
                                                <div id="invalid_photo_required" class="text-danger invalid-tooltip">
                                                    Please Choose File.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            <?php } ?>
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
                        <?php if (is_admin()) { ?>
                            <a href="<?= site_url('admin/grantee/manage') ?>" class="btn btn-primary" style="float:left;">Back</a>
                        <?php } ?>
                        <button type="submit" id="btn-submit" class="btn btn-success btn-submit btn-d-none" name="btn-submit" value="save_profile" style="float:right;">Save</button>
                    </div>
                </div>
            </div>

            <div id="contact" class="tab-pane fade">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> ADDRESS ON ID<br />
                                <small>Permanent Address (DO NOT TRANSLATE the address into English)</small>
                            </p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select id="address_country" class="form-control select2 select-country" name="country" onchange="show_pcode('country', 'street')" style="width:100%">
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
                                    <input type="text" class="form-control" id="street" name="street" value="<?php echo $this->Grantee_ent_model->street ?>" placeholder="Street">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>State/Province</label>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_state" style="display:none;">
                                    <select id="address_state" class="form-control select2 select-state" name="home_state" style="width:100%">
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
                                </div>
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="text" class="form-control" name="zipcode" value="<?php echo $this->Grantee_ent_model->zipcode ?>" placeholder="Postal Code">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>City</label>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_city" style="display:none;">
                                    <select id="address_city" class="form-control select2" name="city" style="width:100%">
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

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>
                                    <input name="current_residence" id="current-residence" type="checkbox" <?php echo $checkbox_current_residence ? 'checked' : ''; ?> /> 
                                        <?= $this->Grantee_ent_model->country_id == AMERICAN_DATABASE ? ' This is my current address.' : 
                                        'This address is my current residence and will be used for domicile verification' ?>
                                    </label>
                                    <div class="p-0 mt-0 ml-4">
                                        <i class="fa fa-info-circle"></i> Current address information will be the same as this address
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="current-residence-section" class="panel-body mt-3 <?php echo $checkbox_current_residence ? 'hide' : ''; ?>">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> CURRENT ADDRESS<br />
                                <small>This address will be used for domicile verification</small> 
                            </p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select id="residence_country" class="form-control select2 select-residence-country" name="residence_country" style="width:100%" data-old="<?php echo $this->Grantee_ent_model->residence_country; ?>">
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
                                    <input type="text" class="form-control" id="residence_street" name="residence_street" value="<?php echo $this->Grantee_ent_model->residence_street ?>" placeholder="Street"  data-old="<?php echo $this->Grantee_ent_model->residence_street; ?>">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>State/Province</label>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_state" style="display:none;">
                                    <select id="residence_state" class="form-control select2 select-residence-state" name="residence_state" style="width:100%" data-old="<?php echo $this->Grantee_ent_model->residence_state; ?>">
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
                                    <input type="number" class="form-control" name="residence_zipcode" value="<?php echo $this->Grantee_ent_model->residence_zipcode ?>" placeholder="Postal Code"  data-old="<?php echo $this->Grantee_ent_model->residence_zipcode; ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>City</label>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_city" style="display:none;">
                                    <select id="residence_city" class="form-control select2 select-residence-city" name="residence_city" style="width:100%" data-old="<?php echo $this->Grantee_ent_model->residence_city; ?>">
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
                                            $del_btn = '';
                                            if ($key > 0) {
                                                $del_btn = '<a href="javascript:;" onclick="del_item(this, \'opdt-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:0px;"><i class="fa fa-trash fa-fw"></i></a>';
                                            }
                                    ?>
                                            <div id="opdt-item-<?= $key ?>" class="opdt-item" style="position:relative">
                                                <div class="form-group">
                                                    <label>Cell Phone Number</label>
                                                    <input type="text" class="form-control input_number" name="phone_number[]" value="<?= $row ?>">
                                                </div>
                                                <?php echo $del_btn ?>
                                            </div>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div id="opdt-item-0" class="opdt-item">
                                            <div class="form-group">
                                                <label>Cell Phone Number</label>
                                                <input type="text" class="form-control input_number" name="phone_number[]" value="">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>Home Phone Number</label>
                                    <input type="text" class="form-control input_number" name="home_phone_number" value="<?php echo $this->Grantee_ent_model->home_phone_number ?>" placeholder="Home Phone Numbe">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <a href="javascript:;" onclick="add_mobile_number()" class="btn btn-primary btn-d-none" style="margin-top:24px;">
                                        <i class="fa fa-plus fa-fw"></i> Add Number
                                    </a>
                                </div>
                                <div class="form-group">
                                    <label>Work Phone Number</label>
                                    <input type="text" class="form-control input_number" name="work_phone_number" value="<?php echo $this->Grantee_ent_model->work_phone_number ?>" placeholder="Work Phone Number">
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
                                        <input type="email" id="primary_email" class="form-control" name="primary_email" value="<?php echo $this->Grantee_ent_model->primary_email ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Secondary Email</label>
                                        <input type="email" class="form-control" name="secondary_email" value="<?php echo $this->Grantee_ent_model->secondary_email ?>" placeholder="Secondary Email">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <a href="javascript:;" id="btn-reset-password" onclick="reset_password(<?= $this->Grantee_ent_model->id ?>)" class="btn btn-primary" style="margin-top:24px;">
                                            Reset Password
                                        </a>
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
                                        <input type="email" id="primary_email" class="form-control" name="primary_email" value="<?php echo $this->Grantee_ent_model->primary_email ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="margin-top:-20px;">
                                <p class="ml-4" style="color:red">Do not fill in if you do not want to change the password</p>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        <i class="fa fa-eye password-show"></i>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                                        <i class="fa fa-eye password-show"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="margin-top:-20px;">
                                <p style="border:1px solid #efefef"></p>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Secondary Email</label>
                                        <input type="email" class="form-control" name="secondary_email" value="<?php echo $this->Grantee_ent_model->secondary_email ?>" placeholder="Secondary Email">
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
                                                    <input type="text" class="form-control" name="info[emergency][<?= $key ?>][firs_name_temp]" placeholder="First/Given Name" value="<?= $row->first_name ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Middle Name</label>
                                                    <input type="text" class="form-control" name="info[emergency][<?= $key ?>][middle_name_temp]" placeholder="Middle Name" value="<?= $row->middle_name ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Last/Family Name</label>
                                                    <input type="text" class="form-control" name="info[emergency][<?= $key ?>][last_name_temp]" placeholder="Last/Family Name" value="<?= $row->last_name ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select id="temp_country" class="form-control select2 select-country" name="info[emergency][<?= $key ?>][country_temp]" onchange="show_pcode('country_temp', 'home_phone_code')" style="width:100%">
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
                                                    <input type="text" class="form-control" name="info[emergency][<?= $key ?>][street_temp]" value="<?php echo $row->street ?>" placeholder="Street">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group pos-rel">
                                                    <label>State/Province</label>
                                                    <select id="temp_state" class="form-control select2 select-state" name="info[emergency][<?= $key ?>][provinci_temp]" style="width:100%">
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
                                                    <!-- <img id="load-home_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner"> -->
                                                </div>
                                                <div class="form-group">
                                                    <label>Postal Code</label>
                                                    <input type="text" class="form-control" name="info[emergency][<?= $key ?>][zipcode_tmep]" value="<?php echo $row->zipcode ?>" placeholder="Postal Code">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group pos-rel">
                                                    <label>City</label>
                                                    <select id="temp_city" class="form-control select2" name="info[emergency][<?= $key ?>][city_temp]" style="width:100%">
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
                                                    <input type="text" class="form-control" name="info[emergency][<?= $key ?>][phone_temp]" placeholder="Phone Number" value="<?= $row->phone_number ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" name="info[emergency][<?= $key ?>][email_temp]" placeholder="Email" value="<?= $row->email ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Relationship to You</label>
                                                    <input type="text" class="form-control" name="info[emergency][<?= $key ?>][relation]" placeholder="Relationship to You" value="<?= $row->relation ?>">
                                                </div>
                                                <input type="hidden" name="info[emergency][<?= $key ?>][emergency_id]" value="<?= $row->id ?>">
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
                                                <input type="text" class="form-control" name="info[emergency][0][firs_name_temp]" placeholder="First/Given Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input type="text" class="form-control" name="info[emergency][0][middle_name_temp]" placeholder="Middle Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Last/Family Name</label>
                                                <input type="text" class="form-control" name="info[emergency][0][last_name_temp]" placeholder="Last/Family Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <select id="temp_country" class="form-control select2 select-country" name="info[emergency][0][country_temp]" onchange="show_pcode('country_temp', 'home_phone_code')" style="width:100%">
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
                                                <input type="text" class="form-control" name="info[emergency][0][street_temp]" value="<?php echo $this->Grantee_ent_model->street_temp ?>" placeholder="Street">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group pos-rel">
                                                <label>State/Province</label>
                                                <select id="temp_state" class="form-control select2 select-state" name="info[emergency][0][provinci_temp]" style="width:100%">
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
                                                <!-- <img id="load-home_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner"> -->
                                            </div>
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="text" class="form-control" name="info[emergency][0][zipcode_tmep]" value="<?php echo $this->Grantee_ent_model->zipcode_tmep ?>" placeholder="Postal Code">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group pos-rel">
                                                <label>City</label>
                                                <select id="temp_city" class="form-control select2" name="info[emergency][0][city_temp]" style="width:100%">
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
                                                <input type="text" class="form-control" name="info[emergency][0][phone_temp]" placeholder="Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" name="info[emergency][0][email_temp]" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Relationship to You</label>
                                                <input type="text" class="form-control" name="info[emergency][0][relation]" placeholder="Relationship to You">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="panel-body" style="margin-top:-20px">
                            <div class="col-lg-12">
                                <a href="javascript:;" onclick="add_label()" class="btn btn-primary btn-d-none">
                                    <i class="fa fa-plus fa-fw"></i> Add Label
                                </a>
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
                        <?php if (is_admin()) { ?>
                            <a href="<?= site_url('admin/grantee/manage') ?>" class="btn btn-primary" style="float:left;">Back</a>
                        <?php } ?>
                        <button type="submit" id="btn-submit" class="btn btn-success btn-submit btn-d-none" name="btn-submit" value="save_profile" style="float:right;">Save</button>
                    </div>
                </div>
            </div>
            <div id="history" class="tab-pane fade">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Period</th>
                                            <th>Grants</th>
                                            <th>Status</th>
                                            <th>Note</th>
                                            <th class="text-right">Attachment</th>
                                            <th  class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status_selection     = [STATUS_APPLICATION_WITHDRAW, STATUS_NEW_SELECTION, STATUS_SELECTION_REVISED, STATUS_SELECTION_DECLINED, STATUS_SELECTION_VERIFIED, STATUS_WAITING_FOR_INTERVIEW, STATUS_INTERVIEW, STATUS_NEW_SELECTION_DECLINED, STATUS_NEW_SELECTION_WITHDRAW, STATUS_REVIEW_REJECT, STATUS_INTERVIEW_REJECT, STATUS_NEW_SELECTION_DECLINED, STATUS_SELECTION_EEC, STATUS_REJECT_EEC, STATUS_WITHDRAW_EEC, STATUS_REJECT_FSB, STATUS_WITHDRAW_FSB];
                                        $status_candidate     = [STATUS_SELECTION_SUCCESSFUL, STATUS_NEW_CANDIDATE, STATUS_CANDIDATE_REVISED, STATUS_CANDIDATE_DECLINED, STATUS_CANDIDATE_VERIFIED, STATUS_WITHDRAW_DEPARTURE, STATUS_DROP_DEPARTURE];
                                        $status_on_going     = [STATUS_CANDIDATE_SUCCESSFUL, STATUS_ON_GOING_RESIGN, STATUS_ON_GOING_REVISED, STATUS_ON_GOING_DECLINED];
                                        $status_returning     = [STATUS_RETURNING_SUCCESSFUL, STATUS_NEW_RETURNING, STATUS_RETURNING_REVISED, STATUS_SET_TO_ALUMNI];

                                        foreach ($history as $key => $value) {
                                            if (in_array($value['status'], $status_selection)) {
                                                $section_name = 'selection';
                                                $note = 'note_selection';
                                            } else if (in_array($value['status'], $status_candidate)) {
                                                $section_name = 'candidate';
                                                $note = 'note_candidate';
                                            } else if (in_array($value['status'], $status_on_going)) {
                                                $section_name = 'on_going';
                                                $note = 'note_ongoing';
                                            } else if (in_array($value['status'], $status_returning)) {
                                                $section_name = 'returning';
                                                $note = 'note_returning';
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $value['fiscal_year'] ?></td>
                                                <td><?= $value['grant_name'] ?></td>
                                                <td><?= $value['status_name'] ?></td>
                                                <td><?= $value[$note] ?></td>
                                                <td class="text-right">
                                                    <?php if (!empty($value['attachment_withdraw'])) {
                                                        render_attachments($value['attachment_withdraw']);
                                                    } ?>

                                                    <?php if (!empty($value['attachment_candidate'])) {
                                                        render_attachments($value['attachment_candidate']);
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php //if($value['status'] != STATUS_WAITING_DOCUMENT) { ?>
                                                    <!-- <a class="btn btn-info btn-xs" href="<?php //echo site_url('admin/' . $section_name . '/verify/' . $value['id']); ?>">Submisison Form & Report</a> -->
                                                    <?php //} ?>
                                                    <a class="btn btn-primary btn-xs" href="<?php echo site_url('admin/payment_record/payment/' . $section_name . '/' . $value['id']); ?>">List Payment</a>
                                                    <?php if($value['status'] != STATUS_WAITING_DOCUMENT) { ?>
                                                    <a class="btn btn-default btn-xs" href="<?php echo site_url('admin/missing_document/manage/' . $value['id']); ?>">Missing Document</a>
                                                    <?php } ?>
                                                    <a target="_blank" class="btn btn-primary btn-xs" href="<?php echo site_url('admin/application/verify/' . $value['id']); ?>">Edit Submisison Application</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE){ ?>
                <?php $this->load->view('admin/partials/us_address'); ?>
            <?php } ?>
        </div>
    </div>
</form>