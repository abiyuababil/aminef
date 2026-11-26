<?php

$active_country = $this->session->userdata('active_country');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title ?>
            <?php if($active_country == INDONESIAN_DATABASE && $this->User_model->is_grantee_id): ?>
            <div class="pull-right">
                <button id="btn-migrate-grantee" class="btn btn-warning mb-5" data-user-id="<?php echo $this->User_model->id; ?>">
                    <i class="fa fa-replace"></i>Sync data
                </button>
            </div>
            <?php endif; ?>
        </h1>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>

<style>
    .html-section {
        max-height: 700px;
        overflow: scroll;
    }
</style>

<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px">
            <ul class="nav nav-pills">
                <li <?php echo $default_tab_active ?>><a data-toggle="tab" href="#personal" aria-expanded="true">Personal</a></li>
                <li><a data-toggle="tab" href="#home" aria-expanded="true">Home Address</a></li>
                <li><a data-toggle="tab" href="#office" aria-expanded="true">Current Institution</a></li>

                <?php
                foreach ($user_programs as $up) {
                    $program = $programs[$up->program_id];

                    $program_tab_active = '';
                    if ($pid && $pid == $up->id) {
                        $program_tab_active = 'active';
                    }
                    ?>
                    <li class="<?php echo $program_tab_active ?>">
                        <a data-toggle="tab" href="#user-program-<?php echo $up->id ?>" aria-expanded="false"><?php echo $program->name; echo trim($up->year_departure) !== '' ? " ($up->year_departure)" : ''; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="tab-content">
            <div id="personal" class="tab-pane fade <?php echo $default_content_active ?>">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Basic Info
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Title</label>
                                <select class="form-control" name="title">
                                    <option value="">-- Select Title --</option>
                                    <?php
                                    if ($titles) {
                                        foreach ($titles as $tt) {
                                            $selected = '';
                                            if ($this->User_model->title == $tt) {
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
                            <?php
                            // america start with last name
                            if ($active_country == 2) {
                                ?>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" name="last_name" value="<?php echo $this->User_model->last_name ?>">
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="form-control" name="first_name" value="<?php echo $this->User_model->first_name ?>">
                            </div>
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input class="form-control" name="midle_name" value="<?php echo $this->User_model->midle_name ?>">
                            </div>
                            <?php
                            // not america start with first name
                            if ($active_country != 2) {
                                ?>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" name="last_name" value="<?php echo $this->User_model->last_name ?>">
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="">-- Select Gender --</option>
                                    <?php
                                    if ($genders) {
                                        foreach ($genders as $ge) {
                                            $selected = '';
                                            if ($this->User_model->gender == $ge) {
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
                            <div class="form-group">
                                <label>Place of Birth</label>
                                <input class="form-control" name="birth_place" value="<?php echo $this->User_model->birth_place ?>">
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input class="form-control datepicker" name="birth_date" value="<?php echo ($this->User_model->birth_date) ? date(
                                                                                                    'd M Y',
                                                                                                    strtotime($this->User_model->birth_date)
                                                                                                ) : '' ?>">
                            </div>
                            <div class="form-group">
                                <label>Marital Status</label>
                                <select class="form-control" name="marital_status">
                                    <option value="">-- Select Status --</option>
                                    <?php
                                    if ($marital_stats) {
                                        foreach ($marital_stats as $ms) {
                                            $selected = '';
                                            if ($this->User_model->marital_status == $ms) {
                                                $selected = 'selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $ms ?>" <?php echo $selected ?>><?php echo $ms ?></option>
                                        <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Spouse Name</label>
                                <input class="form-control" name="spouse_name" value="<?php echo $this->User_model->spouse_name ?>">
                            </div>
                            <div class="form-group">
                                <label>Deceased</label>
                                <select class="form-control" name="deceased">
                                    <option value="0" <?php echo ($this->User_model->deceased == '0') ? 'selected="selected"' : '' ?>>No
                                    </option>
                                    <option value="1" <?php echo ($this->User_model->deceased == '1') ? 'selected="selected"' : '' ?>>Yes
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Show in Alumni Directory</label>
                                <select class="form-control" name="show_in_alumni_dir">
                                    <option value="0" <?php echo ($this->User_model->show_in_alumni_dir == '0') ? 'selected="selected"' : '' ?>>No
                                    </option>
                                    <option value="1" <?php echo ($this->User_model->show_in_alumni_dir == '1') ? 'selected="selected"' : '' ?>>Yes
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="panel-heading">
                            Publications
                        </div>
                        <div class="panel-body">
                            <div id="wrap-publications">
                                <?php
                                if ($info['publications']) {
                                    foreach ($info['publications'] as $key => $row) {
                                        $del_btn = '';
                                        if ($key > 0) {
                                            $del_btn = '<a href="javascript:;" onclick="del_item(this, \'pubs-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
                                        }
                                        ?>
                                        <div id="pubs-item-<?php echo $key ?>" class="row pubs-item" style="position:relative">
                                            <div class="col-md-4" style="padding-right:0">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input class="form-control" name="info[publications][<?php echo $key ?>][title]" value="<?php echo $row->title ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Hyperlink</label>
                                                    <input class="form-control" name="info[publications][<?php echo $key ?>][link]" value="<?php echo $row->link ?>">
                                                </div>
                                            </div>
                                            <?php echo $del_btn ?>
                                        </div>
                                    <?php
                                }
                            } else {
                                ?>
                                    <div id="pubs-item-0" class="row pubs-item">
                                        <div class="col-md-4" style="padding-right:0">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="info[publications][0][title]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Hyperlink</label>
                                                <input class="form-control" name="info[publications][0][link]" value="">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <a href="javascript:;" onclick="add_publication()" class="btn btn-success btn-sm pull-right">
                                <i class="fa fa-plus fa-fw"></i> Add more
                            </a>
                        </div>

                        <div class="panel-heading">
                            Other Updates
                        </div>
                        <div class="panel-body">
                            <div id="wrap-other-updates">
                                <?php
                                if ($info['other_updates']) {
                                    foreach ($info['other_updates'] as $key => $row) {
                                        $del_btn = '';
                                        if ($key > 0) {
                                            $del_btn = '<a href="javascript:;" onclick="del_item(this, \'opdt-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
                                        }
                                        ?>
                                        <div id="opdt-item-<?php echo $key ?>" class="row opdt-item" style="position:relative">
                                            <div class="col-md-4" style="padding-right:0">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input class="form-control" name="info[other_updates][<?php echo $key ?>][title]" value="<?php echo $row->title ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Hyperlink</label>
                                                    <input class="form-control" name="info[other_updates][<?php echo $key ?>][link]" value="<?php echo $row->link ?>">
                                                </div>
                                            </div>
                                            <?php echo $del_btn ?>
                                        </div>
                                    <?php
                                }
                            } else {
                                ?>
                                    <div id="opdt-item-0" class="row opdt-item">
                                        <div class="col-md-4" style="padding-right:0">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="info[other_updates][0][title]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Hyperlink</label>
                                                <input class="form-control" name="info[other_updates][0][link]" value="">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <a href="javascript:;" onclick="add_other_updates()" class="btn btn-success btn-sm pull-right">
                                <i class="fa fa-plus fa-fw"></i> Add more
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Passport
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Passport Number</label>
                                <input class="form-control" name="passport_number" value="<?php echo $this->User_model->passport_number ?>">
                            </div>
                            <div class="form-group">
                                <label>Passport Date of Issue</label>
                                <input class="form-control datepicker" name="passport_date_issue" value="<?php echo ($this->User_model->passport_date_issue) ? date(
                                                                                                                'd M Y',
                                                                                                                strtotime($this->User_model->passport_date_issue)
                                                                                                            ) : '' ?>">
                            </div>
                            <div class="form-group">
                                <label>Passport Expiry Date</label>
                                <input class="form-control datepicker" name="passport_date_expired" value="<?php echo ($this->User_model->passport_date_expired) ? date(
                                                                                                                'd M Y',
                                                                                                                strtotime($this->User_model->passport_date_expired)
                                                                                                            ) : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Upload
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Photo</label>
                                <?php if ($this->User_model->img_photo != '') { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo base_url() ?><?php echo $this->User_model->img_photo ?>" class="lightbox">
                                            <img id="preview_image_alumni" src="<?php echo base_url() ?><?php echo $this->User_model->img_photo ?>" width="100" style="min-height:60px;object-fit:contain;">
                                        </a>
                                        <a href="javascript:;" onclick="del_file(this, 'img_photo', 'Photo')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28px;">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                        <a href="<?php echo base_url() ?><?php echo $this->User_model->img_photo ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5" style="position:absolute; top:0; right:-28px;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div id="preview_section_alumni" style="margin-bottom: 10px; position:relative; width:100px; display:none;">
                                        <a>
                                            <img id="preview_image_alumni" width="100">
                                        </a>
                                    </div>
                                <?php } ?>
                                <input type="file" name="img_photo" onchange="show_preview(this, 'alumni');">
                                <small class="file-for-testing">File Size Max 5MB</small>
                            </div>
                            <div class="form-group">
                                <label>Passport</label>
                                <?php if ($this->User_model->img_passport != '') { 
                                    $file_passport = get_preview($this->User_model->img_passport);
                                ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo base_url() ?><?php echo $this->User_model->img_passport ?>" class="lightbox">
                                            <img id="preview_image_alumni" src="<?php echo $file_passport ?>" width="100">
                                        </a>
                                        <a href="javascript:;" onclick="del_file(this, 'img_passport', 'Passport')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28;">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                        <a href="<?php echo base_url() ?><?php echo $this->User_model->img_passport ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5" style="position:absolute; top:0; right:-28px;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                <?php } ?>
                                <input type="file" name="img_passport">
                                <small class="file-for-testing">File Size Max 5MB</small>
                            </div>
                            <?php if (false): ?>
                            <div class="form-group">
                                <label>Certificate</label>
                                <?php if ($this->User_model->img_certificate != '') { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo base_url() ?><?php echo $this->User_model->img_certificate ?>" target="_blank">
                                            View file
                                        </a>
                                        <a href="javascript:;" onclick="del_file(this, 'img_certificate', 'Certificate')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:0;"><i class="fa fa-trash fa-fw"></i></a>
                                    </div>
                                <?php } ?>
                                <input type="file" name="img_certificate">
                                <small class="file-for-testing">File Size Max 5MB</small>
                            </div>
                            <?php if ($active_country == 1) { ?>
                                <div class="form-group">
                                    <label>Bio Sketch</label>
                                    <?php if ($this->User_model->img_bio_sketch != '') { ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                            <a href="<?php echo base_url() ?><?php echo $this->User_model->img_bio_sketch ?>" target="_blank">
                                                View file
                                            </a>
                                            <a href="javascript:;" onclick="del_file(this, 'img_bio_sketch', 'Bio Sketch')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:0;"><i class="fa fa-trash fa-fw"></i></a>
                                        </div>
                                    <?php } ?>
                                    <input type="file" name="img_bio_sketch">
                                    <small class="file-for-testing">File Size Max 5MB</small>
                                </div>
                            <?php } ?>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Others
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Bank Info</label>
                                <textarea class="form-control" rows="3" name="bank_info"><?php echo $this->User_model->bank_info ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Red Flag</label>
                                <textarea class="form-control" rows="3" name="redflag" disabled><?php echo $redflag->comment ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php if ($active_country == 1 && false) { ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Selection Process
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Selection Comments</label>
                                    <textarea class="form-control" rows="3" name="selection_comments"><?php echo $this->User_model->selection_comments ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div id="home" class="tab-pane fade">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" rows="3" name="address"><?php echo $this->User_model->address ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select id="home_country" data-live-search="true" class="form-control selectpicker select-country" name="home_country_id" onchange="show_pcode('home_country', 'home_phone_code')" style="width:100%">
                                    <option value="">-- Select Country --</option>
                                    <?php
                                    if ($country_list) {
                                        foreach ($country_list as $cl) {
                                            $selected = '';
                                            if ($this->User_model->home_country_id == $cl->id) {
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
                            <div class="form-group pos-rel">
                                <label>State/Province</label>
                                <select id="home_state" data-live-search="true" class="form-control selectpicker select-state" name="home_state_id" style="width:100%">
                                    <option value="">-- Select State/Province --</option>
                                    <?php
                                    if ($home_states) {
                                        foreach ($home_states as $st) {
                                            $selected = '';
                                            if ($this->User_model->home_state_id == $st->id) {
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
                            <div class="form-group pos-rel">
                                <label>City</label>
                                <select id="home_city" class="form-control selectpicker" data-live-search="true" name="home_city_id" style="width:100%">
                                    <option value="">-- Select City --</option>
                                    <?php
                                    if ($home_cities) {
                                        foreach ($home_cities as $ct) {
                                            $selected = '';
                                            if ($this->User_model->home_city_id == $ct->id) {
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
                            <div class="form-group">
                                <label>Zip Code</label>
                                <input class="form-control" name="home_zipcode" value="<?php echo $this->User_model->home_zipcode ?>" onkeypress="return isNumber(event)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input class="form-control" name="phone_mobile" value="<?php echo $this->User_model->phone_mobile ?>">
                                <small class="text-danger">for multiple number, separate number by comma (,)</small>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Phone Number (Home)</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <input id="home_phone_code" class="form-control" value="" disabled>
                                    </div>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="phone_home" value="<?php echo $this->User_model->phone_home ?>">
                                    </div>
                                    <div class="col-lg-12">
                                        <small class="text-danger">for multiple number, separate number by comma (,)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fax</label>
                                <input class="form-control" name="home_fax" value="<?php echo $this->User_model->home_fax ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input id="email" class="form-control" name="email" value="<?php echo $this->User_model->email ?>">
                                <small class="text-danger">for multiple email, separate email by semi colon (;)</small>
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input class="form-control" name="home_website" value="<?php echo $this->User_model->home_website ?>">
                            </div>
                            <div class="form-group">
                                <label>Comments</label>
                                <textarea class="form-control" rows="3" name="home_comments"><?php echo $this->User_model->home_comments ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="office" class="tab-pane fade">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" rows="3" name="of_address"><?php echo $this->User_model->of_address ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select id="of_country" data-live-search="true" class="form-control selectpicker select-country" name="of_country_id" onchange="show_pcode('of_country', 'of_phone_code')" style="width:100%">
                                    <option value="">-- Select Country --</option>
                                    <?php
                                    if ($country_list) {
                                        foreach ($country_list as $cl) {
                                            $selected = '';
                                            if ($this->User_model->of_country_id == $cl->id) {
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
                            <div class="form-group pos-rel">
                                <label>State/Province</label>
                                <select id="of_state" data-live-search="true" class="form-control selectpicker select-state" name="of_state_id" style="width:100%">
                                    <option value="">-- Select State/Province --</option>
                                    <?php
                                    if ($of_states) {
                                        foreach ($of_states as $st) {
                                            $selected = '';
                                            if ($this->User_model->of_state_id == $st->id) {
                                                $selected = 'selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $st->id ?>" <?php echo $selected ?>><?php echo $st->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                                </select>
                                <img id="load-of_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                            </div>
                            <div class="form-group pos-rel">
                                <label>City</label>
                                <select id="of_city" class="form-control selectpicker" data-live-search="true" name="of_city_id" style="width:100%">
                                    <option value="">-- Select City --</option>
                                    <?php
                                    if ($of_cities) {
                                        foreach ($of_cities as $ct) {
                                            $selected = '';
                                            if ($this->User_model->of_city_id == $ct->id) {
                                                $selected = 'selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                                </select>
                                <img id="load-of_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                            </div>
                            <div class="form-group">
                                <label>Zip Code</label>
                                <input class="form-control" name="of_zipcode" value="<?php echo $this->User_model->of_zipcode ?>" onkeypress="return isNumber(event)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Position</label>
                                <input class="form-control" name="of_position" value="<?php echo $this->User_model->of_position ?>">
                            </div>
                            <div class="form-group">
                                <label>Organization / Institution</label>
                                <textarea class="form-control" rows="3" name="of_department"><?php echo $this->User_model->of_department ?></textarea>
                                <small class="text-danger">fill this info as complete as possible (used for mailing address)</small>
                            </div>
                            <div class="form-group">
                                <label>Additional positions or Duties</label>
                                <input class="form-control" name="of_additional" value="<?php echo $this->User_model->of_additional ?>">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Phone</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <input id="of_phone_code" class="form-control" value="" disabled>
                                    </div>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="of_phone" value="<?php echo $this->User_model->of_phone ?>">
                                    </div>
                                    <div class="col-lg-12">
                                        <small class="text-danger">for multiple number, separate number by comma (,)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fax</label>
                                <input class="form-control" name="of_fax" value="<?php echo $this->User_model->of_fax ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input id="of_email" class="form-control" name="of_email" value="<?php echo $this->User_model->of_email ?>">
                                <small class="text-danger">for multiple email, separate email by semi colon (;)</small>
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input class="form-control" name="of_website" value="<?php echo $this->User_model->of_website ?>">
                            </div>
                            <div class="form-group">
                                <label>Comments</label>
                                <textarea class="form-control" rows="3" name="of_comments"><?php echo $this->User_model->of_comments ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            foreach ($user_programs as $up) {
                $program_id = $up->id;
                $program = $programs[$up->program_id];

                $program_content_active = '';
                if ($pid && $pid == $program_id) {
                    $program_content_active = 'active in';
                }
                ?>
                <div id="user-program-<?php echo $program_id ?>" class="tab-pane tab-grants fade <?php echo $program_content_active ?>" data-pid="<?= $up->program_id; ?>" data-upid="<?= $up->id; ?>">
                    <?php if($active_country == 1 && $up->source == 2) { ?>
                    <div class="col-lg-12 my-3">
                        <a class="btn btn-primary" href="<?= base_url('admin/alumni/set_returning/' . $this->User_model->id . '/' . $up->id) ?>" onclick="return confirm('Are you sure?')">Set to Returning</a>
                    </div>
                    <?php } ?>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label><?= get_active_country() == 'Indonesian' ? 'Academic Year' : 'Fiscal Year' ?></label>
                                    <select class="form-control" name="user_program[<?php echo $program_id ?>][yeard]">
                                        <option value="">-- Select Year --</option>
                                        <?php
                                        // $current_year = date('Y');
                                        $current_year = date('Y', strtotime('+5 years'));
                                        //$limit_year = $current_year - 20;
                                        $limit_year = 1952;
                                        for ($year = $current_year; $year >= $limit_year; $year--) {
                                            $selected = '';
                                            if ($up->year_departure == $year) {
                                                $selected = 'selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Period of Stay</label>
                                            <input class="form-control datepicker" name="user_program[<?php echo $program_id ?>][perf]" value="<?php echo $up->period_stay_from != '' ? date(
                                                                                                                                                    'd M Y',
                                                                                                                                                    strtotime($up->period_stay_from)
                                                                                                                                                ) : '' ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>to</label>
                                            <input class="form-control datepicker" name="user_program[<?php echo $program_id ?>][pert]" value="<?php echo $up->period_stay_to != '' ? date(
                                                                                                                                                    'd M Y',
                                                                                                                                                    strtotime($up->period_stay_to)
                                                                                                                                                ) : '' ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if (!in_array($program->name, ['Fulbright English Teaching Assistant Program'])) { ?>
                                    <div class="form-group">
                                        <label>Project Title</label>
                                        <textarea class="form-control" rows="3" name="user_program[<?php echo $program_id ?>][dis]"><?php echo $up->dissertation_title != '' ? $up->dissertation_title : '' ?></textarea>
                                    </div>
                                <?php } ?>
                                <?php if (!in_array(
                                    $program->name,
                                    ['Fulbright FLTA Program', 'Fulbright Foreign Language Teaching Assistant (FLTA) Program']
                                )) {
                                    ?>
                                    <div class="form-group">
                                        <label>Field of Study</label>
                                        <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                            <?php if($up->is_final_placement) { ?>
                                            <select class="form-control selectpicker" data-live-search="true" name="user_program[<?php echo $program_id ?>][sf]" style="width:100%">
                                                <option value="">-- Select Field of Study --</option>
                                                <?php
                                                $data_study_fields = $this->User_model->source == 2 ? $study_fields2 : $study_fields;
                                                if ($data_study_fields) {
                                                    foreach ($data_study_fields as $sl) {
                                                        $selected = '';
                                                        if (isset($up->study_field_id) && $up->study_field_id == $sl->id) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $sl->id ?>" <?php echo $selected ?>><?php echo $sl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                            <?php } else { ?>
                                                <input class="form-control" name="user_program[<?php echo $program_id ?>][sfi]" value="<?php echo $up->study_field_input ?>">
                                            <?php } ?>
                                        <?php } else { ?>
                                            <select class="form-control selectpicker" data-live-search="true" name="user_program[<?php echo $program_id ?>][sf]" style="width:100%">
                                                <option value="">-- Select Field of Study --</option>
                                                <?php
                                                if ($study_fields) {
                                                    foreach ($study_fields as $sl) {
                                                        $selected = '';
                                                        if (isset($up->study_field_id) && $up->study_field_id == $sl->id) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $sl->id ?>" <?php echo $selected ?>><?php echo $sl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if (!in_array($program->name, ['Fulbright English Teaching Assistant Program'])) { ?>
                                    <div class="form-group">
                                        <label>Specialization</label>
                                        <input class="form-control" name="user_program[<?php echo $program_id ?>][spe]" value="<?php echo $up->specialization != '' ? $up->specialization : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Department</label>
                                        <input class="form-control" name="user_program[<?php echo $program_id ?>][dep]" value="<?php echo $up->department != '' ? $up->department : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input class="form-control" name="user_program[<?php echo $program_id ?>][pos]" value="<?php echo $up->position != '' ? $up->position : '' ?>">
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label>Country</label>
                                    <select id="up<?php echo $program_id ?>_country" data-live-search="true" class="form-control selectpicker select-country" name="user_program[<?php echo $program_id ?>][oid]" style="width:100%">
                                        <option value="">-- Select Country --</option>
                                        <?php
                                        if ($country_list) {
                                            foreach ($country_list as $cl) {
                                                $selected = '';
                                                if ($up->up_country_id == $cl->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $cl->id ?>" <?php echo $selected ?>><?php echo $cl->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group pos-rel">
                                    <label>State/Province</label>
                                    <select id="up<?php echo $program_id ?>_state" data-live-search="true" class="form-control selectpicker select-state" name="user_program[<?php echo $program_id ?>][sid]" style="width:100%">
                                        <option value="">-- Select State/Province --</option>
                                        <?php
                                        if ($up->states) {
                                            foreach ($up->states as $st) {
                                                $selected = '';
                                                if ($up->up_state_id == $st->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $st->id ?>" <?php echo $selected ?>><?php echo $st->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                    <img id="load-up<?php echo $program_id ?>_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                </div>
                                <div class="form-group pos-rel">
                                    <label>City</label>
                                    <select id="up<?php echo $program_id ?>_city" class="form-control selectpicker" data-live-search="true" name="user_program[<?php echo $program_id ?>][cid]" style="width:100%">
                                        <option value="">-- Select City --</option>
                                        <?php
                                        if ($up->cities) {
                                            foreach ($up->cities as $ct) {
                                                $selected = '';
                                                if ($up->up_city_id == $ct->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                    <img id="load-up<?php echo $program_id ?>_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Year Degree Obtained</label>
                                    <select class="form-control" name="user_program[<?php echo $program_id ?>][year]">
                                        <option value="">-- Select Year --</option>
                                        <?php
                                        $current_year = date('Y', strtotime('+5 years'));
                                        //$limit_year = $current_year - 20;
                                        $limit_year = 1952;
                                        for ($year = $current_year; $year >= $limit_year; $year--) {
                                            $selected = '';
                                            if ($up->year == $year) {
                                                $selected = 'selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <?php if ($active_country == 2) { ?>
                                    <div class="form-group">
                                        <label>Activity</label>
                                        <select class="form-control" name="user_program[<?php echo $program_id ?>][act]" id="chg_activity_<?= $up->program_id; ?>" data-program_id="<?= $up->program_id; ?>">
                                            <option value="">-- Select Activity --</option>
                                            <?php
                                            $opt = [1 => 'Teaching', 2 => 'Research', 3 => 'Research & Teaching'];
                                            foreach ($opt as $k => $v) {
                                                ?>
                                                <option value="<?= $k; ?>" <?= ($k == $up->activity ? 'selected' : null); ?>><?= $v; ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                        <img id="load-<?= $up->program_id; ?>" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner" style="position:static">
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label>Degree</label>
                                    <input class="form-control" name="user_program[<?php echo $program_id ?>][deg]" value="<?php echo $up->degree != '' ? $up->degree : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Home Institution</label>
                                    <input class="form-control" name="user_program[<?php echo $program_id ?>][hmi]" value="<?php echo $up->home_institution != '' ? $up->home_institution : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Host Institution</label>
                                    <input class="form-control" name="user_program[<?php echo $program_id ?>][hsi]" value="<?php echo $up->host_institution != '' ? $up->host_institution : '' ?>">
                                </div>
                                <div class="form-group hide">
                                    <label>University</label>
                                    <input class="form-control" name="user_program[<?php echo $program_id ?>][univ]" value="<?php echo $up->university != '' ? $up->university : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Length of Program</label>
                                    <?php if ($active_country == 1) { ?>
                                        <select class="form-control" name="user_program[<?php echo $program_id ?>][lop]">
                                            <option value="">-- Select One --</option>
                                            <?php
                                            $lops = ['1 semester', '2 semester', '2 years', '3 years'];
                                            foreach ($lops as $lop) {
                                                $selected = '';
                                                if (isset($up->length_program) && $up->length_program == $lop) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $lop ?>" <?php echo $selected ?>><?php echo $lop ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    <?php } elseif ($active_country == 2) { ?>
                                        <input class="form-control" name="user_program[<?php echo $program_id ?>][lop]" value="<?php echo $up->length_program != '' ? $up->length_program : '' ?>">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>Completion</label>
                                    <select class="form-control" name="user_program[<?php echo $program_id ?>][com]">
                                        <option value=""></option>
                                        <?php if ($active_country == 2): ?>
                                        <option value="Grant Declined" <?php echo (isset($up->completion) && $up->completion == 'Grant Declined') ? 'selected="selected"' : '' ?>>
                                            Grant Declined
                                        </option>
                                        <option value="Permit Rejected" <?php echo (isset($up->completion) && $up->completion == 'Permit Rejected') ? 'selected="selected"' : '' ?>>
                                            Permit Rejected
                                        </option>
                                        <?php endif ?>
                                        <option value="Successful" <?php echo (isset($up->completion) && $up->completion == 'Successful') ? 'selected="selected"' : '' ?>>
                                            Successful
                                        </option>
                                        <option value="Unsuccessful" <?php echo (isset($up->completion) && $up->completion == 'Unsuccessful') ? 'selected="selected"' : '' ?>>
                                            Unsuccessful
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" rows="3" name="user_program[<?php echo $program_id ?>][rea]"><?php echo $up->reason != '' ? $up->reason : '' ?></textarea>
                                </div>
                                <?php if (isset($up->grantee_grant_id) && $up->grantee_grant_id != '') { ?>
                                <div class="form-group">
                                    <?php 
                                    $url = base_url('admin/request_payment/view/'.$up->grantee_grant_id);
                                        if($this->session->userdata('active_country') == INDONESIAN_DATABASE){
                                            $url = base_url('admin/payment_record/payment/alumni/'.$up->grantee_grant_id);
                                        }
                                    ?>
                                    <a href="<?= $url ?>" target="_blank" class="btn btn-info" style="width:100%">List Payment</a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- APPLICATION DATA FROM GRANTEE -->
                    <?php if($this->User_model->is_grantee_id && isset($up->grantee_grant_id) && $up->source == 2) { ?>
                    <div class="col-lg-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <div class="row">
                                            <a class="col-md-12" data-toggle="collapse" href="#collapseApplicationParent<?= $up->id ?>" style="color:#fff">
                                                Application <?= $this->session->userdata('active_country') == INDONESIAN_DATABASE ? '' : 'Grantee' ?>
                                            </a>
                                        </div>
                                    </h4>
                                </div>
                                <div id="collapseApplicationParent<?= $up->id ?>" class="panel-collapse collapse">
                                    <?php
                                        $view_file = $this->session->userdata('active_country') == INDONESIAN_DATABASE ? 'admin/partials/app_grantee' : 'admin/partials/app_grantee_us'; 
                                        $this->load->view($view_file, ['up' => $up])?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END APPLICATION DATA FROM GRANTEE -->
                    <?php } ?>

                    <?php if($up->source != 2) { ?>
                    <div class="col-lg-12 warp-alumni-page" id="content_<?= $up->id; ?>"></div>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="col-lg-12" style="margin-bottom:10px">
                <div style="margin-bottom:10px;" class="pull-right">

                    <?php
                    if ($this->User_model->id) {
                        ?>
                        <input type="hidden" name="id" id="uid" value="<?php echo $this->User_model->id ?>">
                    <?php } ?>
                    <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/users/manage') ?>" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>

        </div>
</form>


<div class="toolbar" style="position:fixed; bottom:20px;">
    <button id="undo" type="button" class="btn btn-warning" disabled>
        <i class="fa fa-undo fa-fw"></i> Undo
    </button>
    <button id="redo" type="button" class="btn btn-warning" disabled>
        <i class="fa fa-undo fa-fw fa-flip-horizontal"></i> Redo
    </button>
    <button id="reset" type="button" class="btn btn-default" style="display:none">
        Reset
    </button>
    <span style="display:none">
        Action Count: <span id="cnt">0</span>
    </span>
</div>