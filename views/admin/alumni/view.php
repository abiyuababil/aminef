<?php
$active_country = $this->session->userdata('active_country');
function get_field_value($value_array='', $value_search='', $field='')
{
    $idx =  array_search($value_search, array_map(function($e) {
        return is_object($e) ? $e->id : $e['id'];
    }, $value_array));

    return $value_search ? $value_array[$idx]->$field : '';
}
?>

<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-12">
        <h1 class="page-header" style="margin-bottom:10px"><?php echo $title ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12" style="margin-bottom:10px">
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="tab" href="#personal" aria-expanded="true">Personal</a></li>
            <li><a data-toggle="tab" href="#home" aria-expanded="true">Home Address</a></li>
            <li><a data-toggle="tab" href="#office" aria-expanded="true">Current Institution</a></li>
            <?php
            foreach ($user_programs as $up) {
                $program = $programs[$up->program_id];

                $program_tab_active = '';
                if ($pid && $pid == $up->id)
                    $program_tab_active = 'active';
                ?>
                <li class="<?php echo $program_tab_active ?>"><a data-toggle="tab" href="#user-program-<?php echo $up->id ?>" aria-expanded="false"><?php echo $program->name; echo isset($up->year_departure) && trim($up->year_departure) !== '' ? " ($up->year_departure)" : ''; ?></a></li>
            <?php } ?>
        </ul>
    </div>

    <div class="tab-content">
        <div id="personal" class="tab-pane fade in active">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Info
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control" name="title"
                                   value="<?php echo (isset($user->title)) ? $user->title : '' ?>" disabled>
                        </div>
                        <?php
                        // america start with last name
                        if ($active_country == 2) {
                            ?>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" name="last_name"
                                       value="<?php echo (isset($user->last_name)) ? $user->last_name : '' ?>" disabled>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control" name="first_name"
                                   value="<?php echo (isset($user->first_name)) ? $user->first_name : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input class="form-control" name="midle_name"
                                   value="<?php echo (isset($user->midle_name)) ? $user->midle_name : '' ?>" disabled>
                        </div>
                        <?php
                        // not america start with first name
                        if ($active_country != 2) {
                            ?>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" name="last_name"
                                       value="<?php echo (isset($user->last_name)) ? $user->last_name : '' ?>" disabled>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Gender</label>
                            <input class="form-control" name="gender"
                                   value="<?php echo (isset($user->gender)) ? $user->gender : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Place of Birth</label>
                            <input class="form-control" name="birth_place"
                                   value="<?php echo (isset($user->birth_place)) ? $user->birth_place : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input class="form-control datepicker" name="birth_date"
                                   value="<?php echo (isset($user->birth_date)) ? date('d M Y',
                                       strtotime($user->birth_date)) : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Marital Status</label>
                            <input class="form-control" name="marital_status"
                                   value="<?php echo (isset($user->marital_status)) ? $user->marital_status : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Spouse Name</label>
                            <input class="form-control" name="spouse_name"
                                   value="<?php echo (isset($user->spouse_name)) ? $user->spouse_name : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Deceased</label>
                            <input class="form-control" name="deceased"
                                   value="<?php echo (isset($user->deceased)) ? ($user->deceased == 0 ? 'No' : 'Yes') : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Show in Alumni Directory</label>
                            <input class="form-control" name="show_in_alumni_dir"
                                   value="<?php echo (isset($user->show_in_alumni_dir)) ? ($user->show_in_alumni_dir == 0 ? 'No' : 'Yes') : '' ?>" disabled>
                        </div>
                    </div>
                    <!-- /.panel-body -->

                    <div class="panel-heading">
                        Publications
                    </div>
                    <div class="panel-body">
                        <div id="wrap-publications">
                            <?php
                            if ($info['publications']) {
                                foreach ($info['publications'] as $key => $row) {
                                    ?>
                                    <div id="pubs-item-<?php echo $key ?>" class="row pubs-item" style="position:relative">
                                        <div class="col-md-4" style="padding-right:0">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="info[publications][<?php echo $key ?>][title]"
                                                       value="<?php echo $row->title ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Hyperlink</label>
                                                <input class="form-control" name="info[publications][<?php echo $key ?>][link]"
                                                       value="<?php echo $row->link ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="panel-heading">
                        Other Updates
                    </div>
                    <div class="panel-body">
                        <div id="wrap-other-updates">
                            <?php
                            if ($info['other_updates']) {
                                foreach ($info['other_updates'] as $key => $row) {
                                    ?>
                                    <div id="opdt-item-<?php echo $key ?>" class="row opdt-item" style="position:relative">
                                        <div class="col-md-4" style="padding-right:0">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="info[other_updates][<?php echo $key ?>][title]"
                                                       value="<?php echo $row->title ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Hyperlink</label>
                                                <input class="form-control" name="info[other_updates][<?php echo $key ?>][link]"
                                                       value="<?php echo $row->link ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>
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
                            <input class="form-control" name="passport_number"
                                   value="<?php echo (isset($user->passport_number)) ? $user->passport_number : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Passport Date of Issue</label>
                            <input class="form-control datepicker" name="passport_date_issue"
                                   value="<?php echo (isset($user->passport_date_issue)) ? date('d M Y',
                                       strtotime($user->passport_date_issue)) : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Passport Expiry Date</label>
                            <input class="form-control datepicker" name="passport_date_expired"
                                   value="<?php echo (isset($user->passport_date_expired)) ? date('d M Y',
                                       strtotime($user->passport_date_expired)) : '' ?>" disabled>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Upload
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Photo</label>
                            <?php if ($this->User_model->img_photo != '') { ?>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?php echo base_url() ?><?php echo $this->User_model->img_photo ?>" class="lightbox" target="_blank">
                                        <img src="<?php echo get_preview($this->User_model->img_photo) ?>" width="100">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Passport</label>
                            <?php if ($this->User_model->img_passport != '') { ?>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?php echo base_url() ?><?php echo $this->User_model->img_passport ?>" class="lightbox" target="_blank">
                                        <img src="<?php echo get_preview($this->User_model->img_passport) ?>" width="100">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (false): ?>
                        <div class="form-group">
                            <label>Certificate</label>
                            <?php if ($user->img_certificate != '') { ?>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?php echo base_url() ?><?php echo $user->img_certificate ?>" target="_blank">
                                        View file
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if ($active_country == 1) { ?>
                            <div class="form-group">
                                <label>Bio Sketch</label>
                                <?php if ($user->img_bio_sketch != '') { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo base_url() ?><?php echo $user->img_bio_sketch ?>" target="_blank">
                                            View file
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php endif ?>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Others
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Bank Info</label>
                            <textarea class="form-control" rows="3" name="bank_info"
                                      disabled><?php echo (isset($user->bank_info)) ? $user->bank_info : '' ?></textarea>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
                <?php if ($active_country == 1 && false) { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Selection Process
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Selection Comments</label>
                                <textarea class="form-control" rows="3" name="selection_comments"
                                          disabled><?php echo (isset($user->selection_comments)) ? $user->selection_comments : '' ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div id="office" class="tab-pane fade in">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" rows="3" name="of_address"
                                      disabled><?php echo (isset($user->of_address)) ? $user->of_address : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input class="form-control" name="of_country"
                                   value="<?=get_field_value($country_list, $user->of_country_id, 'name')?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>State/Province</label>
                            <input class="form-control" name="of_state"
                                   value="<?=get_field_value($of_states, $user->of_state_id, 'name')?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input class="form-control" name="of_city"
                                   value="<?=get_field_value($of_cities, $user->of_city_id, 'name')?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Zip Code</label>
                            <input class="form-control" name="of_zipcode"
                                   value="<?php echo (isset($user->of_zipcode)) ? $user->of_zipcode : '' ?>" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Position</label>
                            <input class="form-control" name="of_position"
                                   value="<?php echo (isset($user->of_position)) ? $user->of_position : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Organization / Institution</label>
                            <textarea class="form-control" rows="3" name="of_department"
                                      disabled><?php echo (isset($user->of_department)) ? $user->of_department : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Additional positions or Duties</label>
                            <input class="form-control" name="of_additional"
                                   value="<?php echo (isset($user->of_additional)) ? $user->of_additional : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Phone</label>
                                </div>
                                <div class="col-lg-3">
                                    <input id="of_phone_code" class="form-control" value="+<?=get_field_value($country_list, $user->of_country_id, 'phone_code')?>" disabled>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control" name="of_phone"
                                           value="<?php echo (isset($user->of_phone)) ? $user->of_phone : '' ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Fax</label>
                            <input class="form-control" name="of_fax"
                                   value="<?php echo (isset($user->of_fax)) ? $user->of_fax : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input id="of_email" class="form-control" name="of_email"
                                   value="<?php echo (isset($user->of_email)) ? $user->of_email : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Website</label>
                            <input class="form-control" name="of_website"
                                   value="<?php echo (isset($user->of_website)) ? $user->of_website : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Comments</label>
                            <textarea class="form-control" rows="3" name="of_comments"
                                      disabled><?php echo (isset($user->of_comments)) ? $user->of_comments : '' ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="home" class="tab-pane fade in">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" rows="3" name="address"
                                      disabled><?php echo (isset($user->address)) ? $user->address : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input class="form-control" name="home_country" value="<?=get_field_value($country_list, $user->home_country_id, 'name')?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>State/Province</label>
                            <input class="form-control" name="home_state" value="<?=get_field_value($home_states, $user->home_state_id, 'name')?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input class="form-control" name="city" value="<?=get_field_value($home_cities, $user->home_city_id, 'name')?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Zip Code</label>
                            <input class="form-control" name="home_zipcode"
                                   value="<?php echo (isset($user->home_zipcode)) ? $user->home_zipcode : '' ?>"
                                   onkeypress="return isNumber(event)" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input class="form-control" name="phone_mobile"
                                   value="<?php echo (isset($user->phone_mobile)) ? $user->phone_mobile : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Phone Number (Home)</label>
                                </div>
                                <div class="col-lg-3">
                                    <input id="home_phone_code" class="form-control" value="+<?=get_field_value($country_list, $user->home_country_id, 'phone_code')?>" disabled>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control" name="phone_home"
                                           value="<?php echo (isset($user->phone_home)) ? $user->phone_home : '' ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Fax</label>
                            <input class="form-control" name="home_fax"
                                   value="<?php echo (isset($user->home_fax)) ? $user->home_fax : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input id="email" class="form-control" name="email"
                                   value="<?php echo (isset($user->email)) ? $user->email : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Website</label>
                            <input class="form-control" name="home_website"
                                   value="<?php echo (isset($user->home_website)) ? $user->home_website : '' ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Comments</label>
                            <textarea class="form-control" rows="3" name="home_comments"
                                      disabled><?php echo (isset($user->home_comments)) ? $user->home_comments : '' ?></textarea>
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
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Fiscal Year</label>
                                    <select class="form-control" name="user_program[<?php echo $program_id ?>][yeard]">
                                        <option value="">-- Select Year --</option>
                                        <?php
                                        $current_year = date('Y');
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
                                        <?php if($up->is_final_placement) { ?>
                                        <select class="form-control select2" data-live-search="true" name="user_program[<?php echo $program_id ?>][sf]" style="width:100%">
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
                                    <select id="up<?php echo $program_id ?>_country" class="form-control select2 select-country" name="user_program[<?php echo $program_id ?>][oid]" style="width:100%">
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
                                    <select id="up<?php echo $program_id ?>_state" class="form-control select2 select-state" name="user_program[<?php echo $program_id ?>][sid]" style="width:100%">
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
                                    <select id="up<?php echo $program_id ?>_city" class="form-control select2" name="user_program[<?php echo $program_id ?>][cid]" style="width:100%">
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
                                        $current_year = date('Y');
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
                                <?php if (isset($program->grantee_grant_id) && $program->grantee_grant_id != '') { ?>
                                <div class="form-group">
                                    <?php 
                                    $url = base_url('admin/request_payment/view/'.$program->grantee_grant_id);
                                        if($this->session->userdata('active_country') == INDONESIAN_DATABASE){
                                            $url = base_url('admin/payment_record/payment/alumni/'.$program->grantee_grant_id);
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
                    
                    <?php if($up->source == 1) { ?>
                    <div class="col-lg-12" id="content_<?= $up->id; ?>"></div>
                    <?php } ?>
                </div>
            <?php } ?>
        <!-- <?php
        foreach ($user_programs as $up) {
            $program_id = $up->id;
            $program = $programs[$up->program_id];

            $program_content_active = '';
            if ($pid && $pid == $program_id) {
                $program_content_active = 'active in';
            }
            ?>
            <div id="user-program-<?php echo $program_id ?>" class="tab-pane fade ">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Fiscal Year</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][yard]"
                                       value="<?php echo $up->year_departure != '' ? $up->year_departure : '' ?>" disabled>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Period of Stay</label>
                                        <input class="form-control datepicker"
                                               name="user_program[<?php echo $program_id ?>][perf]"
                                               value="<?php echo $up->period_stay_from != '' ? date('d M Y',
                                                   strtotime($up->period_stay_from)) : '' ?>" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label>to</label>
                                        <input class="form-control datepicker"
                                               name="user_program[<?php echo $program_id ?>][pert]"
                                               value="<?php echo $up->period_stay_to != '' ? date('d M Y',
                                                   strtotime($up->period_stay_to)) : '' ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Project Title</label>
                                <textarea class="form-control" rows="3" name="user_program[<?php echo $program_id ?>][dis]"
                                          disabled><?php echo $up->dissertation_title != '' ? $up->dissertation_title : '' ?></textarea>
                            </div>
                            <?php if (!in_array($program->name,
                                ['Fulbright FLTA Program', 'Fulbright English Teaching Assistant', 'Fulbright Foreign Language Teaching Assistant (FLTA) Program'])
                            ) { ?>
                                <div class="form-group">
                                    <label>Field of Study</label>
                                    <select class="form-control" name="user_program[<?php echo $program_id ?>][sf]" disabled>
                                        <option value="">-- Select Field of Study --</option>
                                        <?php
                                        if ($study_fields) {
                                            foreach ($study_fields as $sl) {
                                                $selected = '';
                                                if (isset($up->study_field_id) && $up->study_field_id == $sl->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option
                                                    value="<?php echo $sl->id ?>" <?php echo $selected ?>><?php echo $sl->name ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label>Specialization</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][spe]"
                                       value="<?php echo $up->specialization != '' ? $up->specialization : '' ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Department</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][dep]"
                                       value="<?php echo $up->department != '' ? $up->department : '' ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][pos]"
                                       value="<?php echo $up->position != '' ? $up->position : '' ?>" disabled>
                            </div>
                            <?php
                                $country = '';
                                if ($country_list) {
                                    foreach ($country_list as $cl) {
                                        if ($up->up_country_id == $cl->id) {
                                            $country = $cl->name;
                                        }
                                    }
                                }
                            ?>
                            <div class="form-group">
                                <label>Country</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][country]"
                                       value="<?php echo $country != '' ? $country : '' ?>" disabled>
                            </div>
                            <?php
                                $state = '';
                                if ($up->states) {
                                    foreach ($up->states as $st) {
                                        if ($up->up_state_id == $st->id) {
                                            $state = $st->name;
                                        }
                                    }
                                }
                            ?>
                            <div class="form-group">
                                <label>State/Province</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][prov]"
                                       value="<?php echo $state != '' ? $state : '' ?>" disabled>
                            </div>
                            <?php
                                $city = '';
                                if ($up->cities) {
                                    foreach ($up->cities as $ct) {
                                        if ($up->up_city_id == $ct->id) {
                                            $city = $ct->name;
                                        }
                                    }
                                }
                            ?>
                            <div class="form-group">
                                <label>City</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][city]"
                                       value="<?php echo $city != '' ? $city : '' ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Year Degree Obtained</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][year]"
                                       value="<?php echo $up->year != '' ? $up->year : '' ?>" disabled>
                            </div>
                            <?php if ($active_country == 2) { ?>
                            <div class="form-group">
                                <label>Activity</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][act]"
                                       value="<?php echo $up->activity != '' ? $up->activity : '' ?>" disabled>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label>Degree</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][deg]"
                                       value="<?php echo $up->degree != '' ? $up->degree : '' ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Home Institution</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][hmi]"
                                       value="<?php echo $up->home_institution != '' ? $up->home_institution : '' ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Host Institution</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][hsi]"
                                       value="<?php echo $up->host_institution != '' ? $up->host_institution : '' ?>" disabled>
                            </div>
                            <div class="form-group hide">
                                <label>University</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][univ]"
                                       value="<?php echo $up->university != '' ? $up->university : '' ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Length of Program</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][lop]"
                                       value="<?php echo $up->length_program != '' ? $up->length_program : '' ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Completion</label>
                                <input class="form-control" name="user_program[<?php echo $program_id ?>][com]"
                                       value="<?php echo $up->completion != '' ? $up->completion : '' ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" rows="3" name="user_program[<?php echo $program_id ?>][rea]"
                                          disabled><?php echo $up->reason != '' ? $up->reason : '' ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <?php
                    $i = 0;
                    foreach ($program_properties[$program->id] as $arr) {
                        ?>
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse<?= $program_id . '_' . $i ?>"><?= $arr[0]->group_name; ?></a>
                                    </h4>
                                </div>
                                <div id="collapse<?= $program_id . '_' . $i ?>" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php
                                        foreach ($arr as $obj) {
                                            $value = '';
                                            if (isset($user_property_values[$obj->id]))
                                                $value = $user_property_values[$obj->id]->property_value;
                                            if ((isset($up->field_type) && $up->field_type == 'date') && $value != '')
                                                $value = date('d M Y', strtotime($value));
                                            ?>
                                            <div class="form-group col-md-4">
                                                <label><?= $obj->field_name; ?></label>
                                                <?php if ($obj->field_type == 'date') { ?>
                                                    <input class="form-control datepicker" name="program_properties[<?= $obj->id;  ?>]"
                                                           value="<?php echo $value ?>">
                                                <?php } elseif ($obj->field_type == 'text') { ?>
                                                    <textarea class="form-control" rows="3" name="program_properties[<?= $obj->id; ?>]"><?php echo $value ?></textarea>
                                                <?php } elseif ($obj->field_type == 'file') { ?>
                                                    <?php if ($value != '') { ?>
                                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                                            <a href="<?php echo base_url() ?><?php echo $value; ?>" target="_blank">
                                                                <img src="<?php echo base_url() ?><?php echo $value; ?>" width="100">
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <input type="file" name="program_poperties|<?= $obj->id; ?>|<?= $program->id; ?>">
                                                    <small class="file-for-testing">File Size Max 5MB</small>
                                                    <?php if ($value != '') { ?>
                                                        <a href="<?php echo base_url() ?><?php echo $value ?>" target="_blank">
                                                            View File
                                                        </a>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <input class="form-control" name="program_poperties[<?= $obj->id; ?>]"
                                                           value="<?php echo $value ?>">
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
                </div>
            </div>
        <?php } ?> -->

        <div class="col-lg-12" style="margin-bottom:10px">
            <div style="margin-bottom:10px;">
                <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/users/manage') ?>"
                   class="btn btn-default">Back</a>
                <button onclick="window.print();return false;" class="btn btn-default">Print</button>
            </div>
        </div>
    </div>
</div>