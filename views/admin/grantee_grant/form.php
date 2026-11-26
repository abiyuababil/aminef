<?php

$active_country = $this->session->userdata('active_country');
$number_alfa = range('a', 'z');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
    td {
        height: 80px;
        vertical-align: top;
        padding:10px;
        font-weight:bold;
    }
    tr {
        margin-top:20px;
    }
</style>

<div class="modal"></div>

<div class="row">
    <div class="col-lg-12">
        <?php 
            $explode = explode('/', current_url());
            $url = end($explode);
            if($url != 'add'){
        ?>
        <a href="#" id="btn-deleted" class="btn btn-danger" style="float:right;margin: 20px 0;">Delete Grantee</a>
        <?php } ?>
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
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

<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px">
            <ul class="nav nav-pills">
                <li <?php echo $default_tab_active ?>><a data-toggle="tab" href="#personal" aria-expanded="true">Personal Information</a></li>
                <li><a data-toggle="tab" href="#contact" aria-expanded="true">Contact Information</a></li>
                <?php
                foreach ($user_programs as $up) {
                    $program = $programs[$up->grant_id];
                    ?>
                    <li>
                        <a data-toggle="tab" href="#user-program-<?php echo $up->id ?>" aria-expanded="false"><?php echo $program->name; echo trim($up->year_departure) !== '' ? " ($up->year_departure)" : ''; ?></a>
                    </li>
                <?php } ?>
                <li><a data-toggle="tab" href="#upload" aria-expanded="true">Upload Document</a></li>
                <li><a data-toggle="tab" href="#report" aria-expanded="true">Grantee Report</a></li>

            </ul>
        </div>

        <div class="tab-content">
            <div id="personal" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-5">
                                <div class="form-group">    
                                    <label>Choose Grants</label>
                                    <select class="form-control" name="grants">
                                        <option value="">-- Choose Grants --</option>
                                        <?php
                                        if ($program_available) {
                                            foreach ($program_available as $program) {
                                                $selected = '';
                                                if ($user_programs[0]->grant_id == $program->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option value="<?= $program->id ?>" <?= $selected ?>><?= $program->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="panel-body">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> NAME</p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Prefix</label>
                                    <input class="form-control" name="prefix_name" value="<?php echo $this->Grantee_ent_model->prefix_name ?>" placeholder="Prefix">
                                </div>
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input class="form-control" name="middle_name" value="<?php echo $this->Grantee_ent_model->middle_name ?>" placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label>Suffix (Jr./Sr.I/II/II)</label>
                                    <input class="form-control" name="suffix_ame" value="<?php echo $this->Grantee_ent_model->suffix_ame ?>" placeholder="Suffix">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>First/Given Name</label>
                                    <input class="form-control" name="first_name" value="<?php echo $this->Grantee_ent_model->first_name ?>" placeholder="First/Given Name">
                                </div>
                                <div class="form-group">
                                    <label>Last/Family Name</label>
                                    <input class="form-control" name="last_name" value="<?php echo $this->Grantee_ent_model->last_name ?>" placeholder="Last/Family Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Photo</label>
                                    <?php if ($this->Grantee_ent_model->img_photo != '') { ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                            <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_photo ?>" target="_blank">
                                                <img src="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->img_photo ?>" width="100">
                                            </a>
                                            <a href="javascript:;" onclick="del_file(this, 'img_photo', 'Photo')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <input type="file" name="img_photo">
                                    <small class="file-for-testing">File Size Max 5MB</small>
                                </div>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> NAME ON PREVIOUS RECORD<br />
                            <small>Please provide your name if listed on previous records differently than above.</small></p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>First/Given Name</label>
                                    <input class="form-control" name="previous_first_name" value="<?php echo $this->Grantee_ent_model->previous_first_name ?>" placeholder="First/Given Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input class="form-control" name="previous_middle_name" value="<?php echo $this->Grantee_ent_model->previous_middle_name ?>" placeholder="Middle Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Last/Family Name</label>
                                    <input class="form-control" name="previous_last_name" value="<?php echo $this->Grantee_ent_model->previous_last_name ?>" placeholder="Last/Family Name">
                                </div>
                            </div>
                        </div>
                        
                        <hr>

                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BIOGRAPHICAL INFORMATION</p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input class="form-control datepicker" name="birth_date" value="<?php echo ($this->Grantee_ent_model->birth_date) ? date('d M Y', strtotime($this->Grantee_ent_model->birth_date)) : '' ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country of Birth</label>
                                    <select id="birth_country" class="form-control select2 select-country-birth" name="birth_country" onchange="show_pcode('birth_country', 'home_phone_code')" style="width:100%">
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
                                    <label>City of Birth</label>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="load-city-birth" style="display:none;">
                                    <select id="birth_city" class="form-control select2 select-city-birth" name="birth_city" style="width:100%">
                                        <option value="">-- Select City --</option>
                                        <?php
                                        if ($home_cities) {
                                            foreach ($home_cities as $ct) {
                                                $selected = '';
                                                if ($this->Grantee_ent_model->birth_city == $ct->id) {
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
                        <div class="panel-body" style="margin-top:-25px;">
                            <div class="col-lg-4">
                                <div class="form-group">    
                                    <label>Sex (male/female)</label>
                                    <select class="form-control" name="gender">
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
                                    
                                    <input class="form-control" name="birth_place" value="<?php echo $this->Grantee_ent_model->birth_place ?>" placeholder="Physical Impairment">
                                </div>
                            </div>
                        </div>
                        
                        <?php if($this->session->userdata('active_country') == 2) { ?>

                        <hr>

                        <div class="panel-body mt-3" style="margin-bottom:-30px;">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> ACADEMIC BACKGROUND</p>
                        </div>
                        <div id="wrap-institution">
                            <?php if($academic) { 
                                foreach ($academic as $key => $row) {
                                    $del_btn = '';
                                    if ($key > 0) {
                                        $del_btn = '<a href="javascript:;" onclick="del_item(this, \'institution-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
                                    }?>
                                    <div id="institution-item-<?php echo $key ?>" class="institution-item" style="position:relative">
                                        <div class="panel-body">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Institution Name</label>
                                                    <input class="form-control" name="info[institution][<?= $key ?>][name]" value="<?= $row->name ?>" placeholder="Institution Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-25px;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Level of Study</label>
                                                    <input type="text" class="form-control" name="info[institution][<?= $key ?>][level_study]" placeholder="Level of Study" value="<?= $row->level_study ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select id="institution_country" class="form-control select2 select-country-academic" name="info[institution][<?= $key ?>][country]" onchange="show_pcode('institution_country', 'home_phone_code')" style="width:100%">
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
                                                    <label>City</label>
                                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="load-city-academic" style="display:none;">
                                                    <select id="institution_city" class="form-control select2 select-city-academic" name="info[institution][<?= $key ?>][city]" style="width:100%">
                                                        <option value="">-- Select City --</option>
                                                        <?php
                                                        if ($home_cities) {
                                                            foreach ($home_cities as $ct) {
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
                                                    <input class="form-control" name="info[institution][<?= $key ?>][degree_actual]" value="<?php echo $row->degree_actual ?>" placeholder="Actual Name of Degree or Diploma">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Discipline</label>
                                                    <input class="form-control" name="info[institution][<?= $key ?>][discipline]" value="<?php echo $row->discipline ?>" placeholder="Discipline">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-25px;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Enrolled From</label>
                                                    <input class="form-control datepicker" name="info[institution][<?= $key ?>][endrolled_from]" value="<?=  ($row->endroll_from) ? date('d M Y', strtotime($row->endrolled_from)) : '' ?>" placeholder="Enrolled From">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Enrolled To</label>
                                                    <input class="form-control datepicker" name="info[institution][<?= $key ?>][endrolled_to]" value="<?=  ($row->endroll_to) ? date('d M Y', strtotime($row->endrolled_to)) : '' ?>" placeholder="Enrolled To">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Date Degree Received</label>
                                                    <input type="text" class="form-control datepicker" name="info[institution][<?= $key ?>][degree_date]" placeholder="Date Degree Received" value="<?= $row->degree_date ? date('d M Y', strtotime($row->degree_date)) : '' ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo $del_btn ?>
                                    </div>
                            <?php }} else { ?>
                                    <div id="institution-item-0" class="institution-item" style="position:relative">
                                        <div class="panel-body">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Institution Name</label>
                                                    <input class="form-control" name="info[institution][0][name]" placeholder="Institution Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-25px;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Level of Study</label>
                                                    <input type="text" class="form-control" name="info[institution][0][level_study]" placeholder="Level of Study">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select id="institution_country" class="form-control select2 select-country" name="info[institution][0][country]" onchange="show_pcode('institution_country', 'home_phone_code')" style="width:100%">
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
                                                    <label>City</label>
                                                    <select id="institution_city" class="form-control select2" name="info[institution][0][city]" style="width:100%">
                                                        <option value="">-- Select City --</option>
                                                        <?php
                                                        if ($home_cities) {
                                                            foreach ($home_cities as $ct) {
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
                                                    <input class="form-control" name="info[institution][0][degree_actual]" placeholder="Actual Name of Degree or Diploma">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Discipline</label>
                                                    <input class="form-control" name="info[institution][0][discipline]" placeholder="Discipline">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-20px;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Enrolled From</label>
                                                    <input class="form-control datepicker" name="info[institution][0][endrolled_from]" placeholder="Enrolled From">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Enrolled To</label>
                                                    <input class="form-control datepicker" name="info[institution][0][endrolled_to]" placeholder="Enrolled To">
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
                        <?php } ?>

                        <hr>

                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> CITIZENSHIP INFORMATION</p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country of Citizenship</label>
                                    <select id="citizen_country" class="form-control select2 select-country" name="citizen_country" onchange="show_pcode('citizen_country', 'home_phone_code')" style="width:100%">
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
                                    <label>National Identification Number</label>
                                    <input class="form-control" name="number_identity" value="<?php echo $this->Grantee_ent_model->number_identity ?>" placeholder="National Identification Number">
                                    <small class="text-danger">(KTP/Passport)</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="panel-body">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BANK INFO</p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input class="form-control" name="bank_name" value="<?php echo $this->Grantee_ent_model->bank_name ?>" placeholder="Bank Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Bank Address</label>
                                    <input class="form-control" name="bank_address" value="<?php echo $this->Grantee_ent_model->bank_address ?>" placeholder="Bank Address">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Beneficiary Name</label>
                                    <input class="form-control" name="beneficiary_name" value="<?php echo $this->Grantee_ent_model->beneficiary_name ?>" placeholder="Beneficiary Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input class="form-control" name="account_number" value="<?php echo $this->Grantee_ent_model->account_number ?>" placeholder="Account Number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Routing Number</label>
                                    <input class="form-control" name="routing_number" value="<?php echo $this->Grantee_ent_model->routing_number ?>" placeholder="Routing Number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Swift Code</label>
                                    <input class="form-control" name="swift_code" value="<?php echo $this->Grantee_ent_model->swift_code ?>" placeholder="Swift Code">
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
                        <a href="<?= site_url('admin/grantee/manage') ?>" class="btn btn-primary" style="float:left;">Back</a>
                        <button id="btn-submit" class="btn btn-success" style="float:right;">Save</button>
                    </div>
                </div>
            </div>

            <div id="contact" class="tab-pane fade">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> ADDRESS<br />
                            <small>Permanent Address (DO NOT TRANSLATE the address into English)</small> </p>
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
                                    <input class="form-control" id="street" name="street" value="<?php echo $this->Grantee_ent_model->street ?>" placeholder="Street">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>Province</label>
                                    <select id="address_state" class="form-control select2 select-state" name="home_state" style="width:100%">
                                        <option value="">-- Select Province --</option>
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
                                    <input class="form-control" name="zipcode" value="<?php echo $this->Grantee_ent_model->zipcode ?>" placeholder="Postal Code">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>City</label>
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
                                    <img id="load-home_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> TELEPHONE NUMBERS<br />
                            <small>Please be sure to include the local code along with your number</small> </p>
                            <div class="col-lg-4">
                                <div id="wrap-phone">
                                            <?php
                                            $phone_number = explode(',', $this->Grantee_ent_model->phone_number);
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
                                                            <input class="form-control" name="phone_number[]" value="<?= $row ?>">
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
                                                        <input class="form-control" name="phone_number[]" value="">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>Home Phone Number</label>
                                    <input class="form-control" name="home_phone_number" value="<?php echo $this->Grantee_ent_model->home_phone_number ?>" placeholder="Home Phone Numbe">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <a href="javascript:;" onclick="add_mobile_number()" class="btn btn-primary" style="margin-top:24px;">
                                        <i class="fa fa-plus fa-fw"></i> Add Number
                                    </a>
                                </div>
                                <div class="form-group">
                                    <label>Work Phone Number</label>
                                    <input class="form-control" name="work_phone_number" value="<?php echo $this->Grantee_ent_model->work_phone_number ?>" placeholder="Work Phone Number">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> E-MAIL<br />
                            <small>Please provide a primary and secondary e-mail address (e.g. professional, university, etc.) in case we have difficulties contacting you at the primary e-mail address. Please note that all system-generated messages will be sent to the primary e-mail address.</small> </p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Primary</label>
                                    <input id="primary_email" class="form-control" name="primary_email" value="<?php echo $this->Grantee_ent_model->primary_email ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                    <!-- <i class="fa fa-eye password-show"></i> -->
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <a href="javascript:;" onclick="generate_pass()" class="btn btn-primary" style="margin-top:24px;">
                                        Generate
                                    </a>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="generate-load" style="display:none;">
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="margin-top:-20px;">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Secondary Email</label>
                                    <input class="form-control" name="secondary_email" value="<?php echo $this->Grantee_ent_model->secondary_email ?>" placeholder="Secondary Email">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> EMERGENCY CONTACT INFORMATION<br />
                            <small>The individuals listed below may be contacted in the event of an emergency while undertaking activities related to this grant opportunity, including any possible travel required for interviews in Indonesia.</small> </p>
                        </div>
                        <div id="wrap-label">
                            <?php if($emergency) { 
                                foreach ($emergency as $key => $row) {
                                    $del_btn = '';
                                    if ($key > 0) {
                                        $del_btn = '<a href="javascript:;" onclick="del_item(this, \'label-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
                                    }?>
                                    <div id="label-item-<?php echo $key ?>" class="label-item" style="position:relative">
                                        <div class="panel-body">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Label Name</label>
                                                    <input class="form-control" name="info[emergency][<?= $key ?>][label_name]" value="<?= $row->label_name ?>" placeholder="Label Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-20px;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Firs/Given Name</label>
                                                    <input type="text" class="form-control" name="info[emergency][<?= $key ?>][firs_name_temp]" placeholder="Firs/Given Name" value="<?= $row->first_name ?>">
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
                                                    <input class="form-control" name="info[emergency][<?= $key ?>][street_temp]" value="<?php echo $row->street ?>" placeholder="Street">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group pos-rel">
                                                    <label>Province</label>
                                                    <select id="temp_state" class="form-control select2 select-state" name="info[emergency][<?= $key ?>][provinci_temp]" style="width:100%">
                                                        <option value="">-- Select Province --</option>
                                                        <?php
                                                        if ($home_states) {
                                                            foreach ($home_states as $st) {
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
                                                    <input class="form-control" name="info[emergency][<?= $key ?>][zipcode_tmep]" value="<?php echo $row->zipcode ?>" placeholder="Postal Code">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group pos-rel">
                                                    <label>City</label>
                                                    <select id="temp_city" class="form-control select2" name="info[emergency][<?= $key ?>][city_temp]" style="width:100%">
                                                        <option value="">-- Select City --</option>
                                                        <?php
                                                        if ($home_cities) {
                                                            foreach ($home_cities as $ct) {
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
                            <?php }} else { ?>
                                <div id="label-item-0" class="label-item" style="position:relative">
                                    <div class="panel-body">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Label Name</label>
                                                <input class="form-control" name="info[emergency][0][label_name]" value="<?php echo $this->Grantee_ent_model->name_temp ?>" placeholder="Label Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="margin-top:-20px;">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Firs/Given Name</label>
                                                <input type="text" class="form-control" name="info[emergency][0][firs_name_temp]" placeholder="Firs/Given Name">
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
                                                <input class="form-control" name="info[emergency][0][street_temp]" value="<?php echo $this->Grantee_ent_model->street_temp ?>" placeholder="Street">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group pos-rel">
                                                <label>Province</label>
                                                <select id="temp_state" class="form-control select2 select-state" name="info[emergency][0][provinci_temp]" style="width:100%">
                                                    <option value="">-- Select Province --</option>
                                                    <?php
                                                    if ($home_states) {
                                                        foreach ($home_states as $st) {
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
                                                <input class="form-control" name="info[emergency][0][zipcode_tmep]" value="<?php echo $this->Grantee_ent_model->zipcode_tmep ?>" placeholder="Postal Code">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group pos-rel">
                                                <label>City</label>
                                                <select id="temp_city" class="form-control select2" name="info[emergency][0][city_temp]" style="width:100%">
                                                    <option value="">-- Select City --</option>
                                                    <?php
                                                    if ($home_cities) {
                                                        foreach ($home_cities as $ct) {
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
                                <a href="javascript:;" onclick="add_label()" class="btn btn-primary">
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
                        <a href="<?= site_url('admin/grantee/manage') ?>" class="btn btn-primary" style="float:left;">Back</a>
                        <button id="btn-submit" class="btn btn-success" style="float:right;">Save</button>
                    </div>
                </div>
            </div>

            <div id="upload" class="tab-pane fade">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-left">
                            PRE-DEPATURE
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-4">
                                <label>ToA of Gateway/Pre-Academic/Summer Program</label>
                                <p id="file_name1" style="font-size:16px">No file chosen</p>
                                <a href="javascript:;" class="btn btn-primary" id="btn-upload1">Upload</a>
                                <input type="file" id="my_file1" style="display: none;">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <a class="btn btn-success">save</a>
                                <hr>
                            </div>
                            <div class="col-lg-4">
                                <label>ToA of Academic Program </label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p id="file_name2" style="font-size:16px">IMG_PHOTO_1.JPEG</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#"><i class="fa fa-trash fa-fw fa-2x"></i></a>
                                        <a href="#"><i class="fa fa-eye fa-fw fa-2x"></i></a>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-primary" id="btn-upload2" disabled="disabled">Upload</a>
                                <input type="file" id="my_file2" style="display: none;">
                                <a class="btn btn-success">save</a>
                                <hr>
                            </div>
                            <div class="col-lg-4">
                                <label>Grant Document (for Visiting Scholars)</label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p id="file_name2" style="font-size:16px">IMG_PHOTO_1.JPEG</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#"><i class="fa fa-trash fa-fw fa-2x"></i></a>
                                        <a href="#"><i class="fa fa-eye fa-fw fa-2x"></i></a>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-primary" id="btn-upload2" disabled="disabled">Upload</a>
                                <input type="file" id="my_file3" style="display: none;">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <a class="btn btn-success">save</a>
                                <hr>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12 mb-3">
                                <a id="btn-" class="btn btn-success" style="float:right;">Verified</a>
                                <a id="btn-" class="btn btn-danger" style="float:right;margin-right:5px;">Not Verified</a>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea class="form-control" rows="4" name="admin_note"><?php echo $this->User_model->admin_note ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="report" class="tab-pane fade">
                <div class="col-lg-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="min-height:300px;">
                        <div class="panel panel-default">
                            <div class="panel-heading text-left" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Mid Term Reports
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <h3 class="text-center"><?= $programs[$user_programs[0]->grant_id]->name ?></h3>
                                    <p style="font-weight:bold;"><?= $report_mid[0]['information'] ?></p>
                                    <div class="mt-5">
                                        <?php 
                                            if($report_mid) { 
                                            foreach($report_mid as $key => $row) {    
                                        ?>
                                            <?php if(empty($row['sub'])) { ?>
                                                <table style="vertical-align:top;" width="100%">
                                                    <tr>
                                                        <td width="3%"><?= ($key+1) ?>.</td>
                                                        <td width="27%"><?= $row['description'] ?></td>
                                                        <td width="3%" colspan="2"></td>
                                                        <td><textarea disabled="disabled" class="form-control" rows="6" name="answer"><?php echo $this->User_model->admin_note ?></textarea></td>
                                                    </tr>
                                                </table>
                                            <?php }else{?>
                                                <table width="100%">
                                                    <tr>
                                                        <td width="3%"><?= ($key+1) ?>.</td>
                                                        <td width="27%" colspan="2">
                                                            <?= $row['description'] ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <?php foreach($row['sub'] as $k => $v) { ?>
                                                    <tr>
                                                        <td width="3%"></td>
                                                        <td width="3%"><?= $number_alfa[$k] ?>.</td>
                                                        <td width="27%"><?= $v['sub_description'] ?></td>
                                                        <td><textarea disabled="disabled" class="form-control" rows="6" name="answer"><?php echo $this->User_model->admin_note ?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            <?php } ?>

                                        <?php } } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading text-left" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Final Reports
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <h3 class="text-center"><?= $programs[$user_programs[0]->grant_id]->name ?></h3>
                                    <p style="font-weight:bold;"><?= $report_final[0]['information'] ?></p>
                                    <div class="mt-5">
                                        <?php if($report_final) { 
                                            foreach($report_final as $key => $row) {
                                        ?>
                                            <?php if(empty($row['sub'])) { ?>
                                                <table style="vertical-align:top;" width="100%">
                                                    <tr>
                                                        <td width="3%"><?= ($key+1) ?>.</td>
                                                        <td width="27%"><?= $row['description'] ?></td>
                                                        <td width="3%" colspan="2"></td>
                                                        <td><textarea disabled="disabled" class="form-control" rows="6" name="answer"><?php echo $this->User_model->admin_note ?></textarea></td>
                                                    </tr>
                                                </table>
                                            <?php }else{?>
                                                <table width="100%">
                                                    <tr>
                                                        <td width="3%"><?= ($key+1) ?>.</td>
                                                        <td width="27%" colspan="2">
                                                            <?= $row['description'] ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <?php foreach($row['sub'] as $k => $v) { ?>
                                                    <tr>
                                                        <td width="3%"></td>
                                                        <td width="3%"><?= $number_alfa[$k] ?>.</td>
                                                        <td width="27%"><?= $v['sub_description'] ?></td>
                                                        <td><textarea disabled="disabled" class="form-control" rows="6" name="answer"><?php echo $this->User_model->admin_note ?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            <?php } ?>

                                        <?php } } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12 mb-3">
                            <a id="btn-" class="btn btn-success" style="float:right;">Accept</a>
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

                    <div class="col-lg-12" id="content_<?= $up->id; ?>">

                    </div>
                </div>
            <?php } ?>
        </div>
</form>


<!-- <div class="toolbar" style="position:fixed; bottom:20px; right:20px;">
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
</div> -->