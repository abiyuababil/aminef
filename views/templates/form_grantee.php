<?php
$active_country = $this->session->userdata('active_country');
$is_admin = $is_admin && $is_grantee_page == false;
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

$required_label = "<span style='color:red'> *</span>";

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

$user_grantee = current_grantee($this->Grantee_ent_model->id);

$user_grantee_grant = get_row_db('am_user_grantee_grant', ['id' => $grantee_grant->grant_id]);

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

    .progressbar.flex-right {
        display: flex;
        justify-content: flex-end;
        gap: 6px;
        flex-wrap: nowrap;
        align-items: center;
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

    .select2 {
        width: 100% !important
    }

    .password-show {
        right: 13px;
    }

    .ui-datepicker {
        z-index: 9 !important;
    }

    .note-file-us {
        height: auto;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
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
        background: rgb(255, 255, 255);
        content: " ";
        top: 0;
        position: relative;
        left: 0;
        transition: all 0.3s ease;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
    }

    .checkbox.checbox-switch label>input:checked+span:before,
    .checkbox-inline.checbox-switch>input:checked+span:before {
        left: 17px;
    }


    /* Switch Default */
    .checkbox.checbox-switch label>input:checked+span,
    .checkbox-inline.checbox-switch>input:checked+span {
        background-color: rgb(180, 182, 183);
        border-color: rgb(180, 182, 183);
        box-shadow: rgb(180, 182, 183) 0px 0px 0px 8px inset;
        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
    }

    .checkbox.checbox-switch label>input:checked:disabled+span,
    .checkbox-inline.checbox-switch>input:checked:disabled+span {
        background-color: rgb(220, 220, 220);
        border-color: rgb(220, 220, 220);
        box-shadow: rgb(220, 220, 220) 0px 0px 0px 8px inset;
        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
    }

    .checkbox.checbox-switch label>input:disabled+span,
    .checkbox-inline.checbox-switch>input:disabled+span {
        background-color: rgb(232, 235, 238);
        border-color: rgb(255, 255, 255);
    }

    .checkbox.checbox-switch label>input:disabled+span:before,
    .checkbox-inline.checbox-switch>input:disabled+span:before {
        background-color: rgb(248, 249, 250);
        border-color: rgb(243, 243, 243);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    /* Switch Primary */
    .checkbox.checbox-switch.switch-primary label>input:checked+span,
    .checkbox-inline.checbox-switch.switch-primary>input:checked+span {
        background-color: rgb(0, 105, 217);
        border-color: rgb(0, 105, 217);
        box-shadow: rgb(0, 105, 217) 0px 0px 0px 8px inset;
        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
    }

    .checkbox.checbox-switch.switch-primary label>input:checked:disabled+span,
    .checkbox-inline.checbox-switch.switch-primary>input:checked:disabled+span {
        background-color: rgb(109, 163, 221);
        border-color: rgb(109, 163, 221);
        box-shadow: rgb(109, 163, 221) 0px 0px 0px 8px inset;
        transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
    }

    .has-error {
        border: 2px solid #a94442 !important;
    }

    .select2-container--default .select2-selection--single.has-error {
        border: 1px solid #a94442 !important;
    }

    .select2-container--default .select2-selection--multiple.has-error {
        border: 1px solid #a94442 !important;
    }

    input[type='radio'] {
        -webkit-appearance: none;
        width: 15px;
        height: 15px;
        border: 1px solid #b455fb;
        border-radius: 50%;
        outline: none;
    }

    input[type='radio']:hover {
        box-shadow: 0 0 5px 0px orange inset;
    }

    input[type='radio']:before {
        content: '';
        display: block;
        width: 55%;
        height: 55%;
        margin: 25% auto;
        border-radius: 50%;
    }

    input[type='radio']:checked:before {
        background: blue;
    }



    .submission-description {
        /* min-height: 150px; */
        display: flex;
        flex-direction: column;
    }

    .col-style-us {
        display: flex;
        flex-direction: column;
        padding-bottom: 10px;
        position: relative;
    }

    .col-style-us::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 15px;
        right: 15px;
        height: 1px;
        background: #ccc;
    }

    .col-style-us > p.text-danger.text-required {
        position: absolute;
        bottom: 15px;
    }

    .span-note {
        word-wrap: break-word;
        font-size: 12px !important;
        text-align: justify;
        word-wrap: break-word;
    }

    .text-white {
        color: white;
    }


    .nav.nav-pills {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        scrollbar-width: thin;
    }

    .nav.nav-pills li {
        flex: 0 0 auto;
        margin-right: 5px;
    }

    .nav.nav-pills::-webkit-scrollbar {
        height: 6px;
    }

    .nav.nav-pills::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }

    .nav.nav-pills::-webkit-scrollbar-track {
        background: transparent;
    }
</style>

<div class="alert alert-success" id="success-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Autosave <strong>Success! </strong>
</div>

<div class="modal fade text-center" id="mdl_info_grantee" tabindex="-1" role="dialog" aria-labelledby="mdl_info_grantee" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to delete <b><?= $title ?></b>?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('admin/grantee/delete/' . $this->Grantee_ent_model->id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php if ($is_admin) { ?>
        <div class="col-lg-12">
            <?php
            $explode = explode('/', current_url());
            $url = end($explode);
            if ($url != 'add') {
            ?>
                <a href="#" id="delete_grantee" class="btn btn-danger" style="float:right;margin: 20px 0;">Delete Grantee</a>
                    <?php
                    $payment_url = base_url('admin/request_payment/view/' . $grantee_grant->id . '/' . $grantee_grant->grant_id);
                    if ($this->session->userdata('active_country') != AMERICAN_DATABASE) {
                        $payment_url = base_url('admin/payment_record/payment/alumni/' . $grantee_grant->id);
                    }
                    ?>
                    <?php if ($this->session->userdata('active_country') == AMERICAN_DATABASE) {
                        if (count($user_programs) <= 1) { ?>
                            <?php if ($this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
                                <a href="<?= $payment_url ?>" class="btn btn-info" style="float:right;margin: 20px 3px;"><span class="fa fa-money fa-fw"></span> Payment</a>
                            <?php } ?>
                            <a href="<?= base_url('admin/grantee/setting/' . $grantee_grant->id) ?>" class="btn btn-primary" style="float:right;margin: 20px 10px;"><span class="fa fa-gear"></span> Grantee Setting</a>
                            <a href="<?= base_url('admin/grantee/report_setting/' . $grantee_grant->id) ?>" class="btn btn-primary" style="float:right;margin: 20px 3px;"><span class="fa fa-file-text"></span> Report Setting</a>
                        <?php } else { ?>
                            <div style="float:right;margin: 20px 10px;display:inline-block;position:relative;">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fa fa-gears"></span> Grantee Settings <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" style="top:auto">
                                    <li class="dropdown-header">Grant Setting</li>
                                    <?php foreach ($user_programs as $up) {
                                        $name = isset($programs[$up->grant_id]) ? $programs[$up->grant_id]->name : $up->name; ?>
                                        <li><a href="<?= base_url('admin/grantee/setting/' . $up->id) ?>"><?= $name ?> <?= is_numeric($up->fiscal_year) ? ' - ' . $up->fiscal_year : ''; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div style="float:right;margin: 20px 3px;display:inline-block;position:relative;">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fa fa-file-text"></span> Report Setting <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" style="top:auto">
                                    <li class="dropdown-header">Report Setting</li>
                                    <?php foreach ($user_programs as $up) {
                                        $name = isset($programs[$up->grant_id]) ? $programs[$up->grant_id]->name : $up->name; ?>
                                        <li><a href="<?= base_url('admin/grantee/report_setting/' . $up->id) ?>"><?= $name ?> <?= is_numeric($up->fiscal_year) ? ' - ' . $up->fiscal_year : ''; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div style="float:right;margin: 20px 10px;display:inline-block;position:relative;">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fa fa-money fa-fw"></span> Payment <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" style="top:auto">
                                    <li class="dropdown-header">Payment</li>
                                    <?php foreach ($user_programs as $up) {
                                        $name = isset($programs[$up->grant_id]) ? $programs[$up->grant_id]->name : $up->name; 
                                        $payment_url = base_url('admin/request_payment/view/' . $up->id . '/' . $up->grant_id);
                                    ?>
                                        <li><a href="<?= $payment_url ?>"><?= $name ?> <?= is_numeric($up->fiscal_year) ? ' - ' . $up->fiscal_year : ''; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php }
                    } ?>
                    <a href="<?= base_url('admin/grantee/history_file/' . $this->Grantee_ent_model->id) ?>" class="btn btn-primary" style="float:right;margin: 20px 3px;">History File</a>
                <?php } ?>
                <h1 class="page-header"><?php echo $title ?></h1>
        </div>
    <?php } else { ?>
        <div class="col-lg-12 text-center">
            <!-- <h2 style="color:#0089d1">Form</h2> -->
            <h1 class="page-header"><?php echo $title ?></h1>
            <?php if (!$this->Grantee_ent_model->complete_profile && $this->Grantee_ent_model->country_id == INDONESIAN_DATABASE) { ?>
                <h4 class="text-danger">To submit your application, please complete your profile</h4>
            <?php } ?>
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

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="<?= $this->Grantee_ent_model->id ?>" id="grantee_id">
    <?php if (!$is_admin && $this->Grantee_ent_model->country_id == INDONESIAN_DATABASE) { ?>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary pull-right" href="<?php echo base_url('/grantee/profile/preview_download/' . $this->Grantee_ent_model->id); ?>" target="_blank"> Download My Documents</a>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px">
            <ul class="nav nav-pills">
                <li id="li_personal" <?php echo $default_tab_active ?>><a data-toggle="tab" href="#personal" aria-expanded="true">Personal Information</a></li>
                <li id="li_contact" <?= $pid == 'contact' ? 'class="active"' : '' ?> class="<?= $this->session->userdata('active_country') == AMERICAN_DATABASE && !$is_admin ? 'hide' : '' ?>"><a data-toggle="tab" href="#contact" aria-expanded="true">Contact Information</a></li>
                <?php
                if ($active_country == AMERICAN_DATABASE
                    && !in_array($grantee_grant->status, [STATUS_FINALIST, STATUS_NEW_GRANTEE])
                    && (isset($user_grantee_grant->show_aspe) && $user_grantee_grant->show_aspe == 1)
                ) { ?>
                    <li class="<?php echo $pid == 'aspe' ? 'active' : ''; ?>"><a data-toggle="tab" href="#aspe" aria-expanded="true">ASPE Health Benefit</a></li>
                <?php } ?>
                <?php if($is_admin && $active_country == INDONESIAN_DATABASE) { ?>
                    <li><a data-toggle="tab" href="#us_address" aria-expanded="true">US Address</a></li>
                <?php } ?>
                <li><a data-toggle="tab" href="#history" aria-expanded="true">Scholarship</a></li>
                <?php if ($is_admin && !isset($params['is_current'])) { ?>
                    <?php
                    foreach ($user_programs as $up) {
                        $program = $programs[$up->grant_id];
                    ?>
                        <li <?= $pid == $up->grant_id  ? 'class="active"' : '' ?>>
                            <a data-toggle="tab" href="#user-program-<?php echo $up->id ?>" aria-expanded="false">
                                <?php echo $program->name; ?>
                                <?php

                                if (($up->status == STATUS_SET_TO_ALUMNI || $up->status == STATUS_SELECTION_DECLINED || $up->status == STATUS_CANDIDATE_DECLINED || $up->status == STATUS_ON_GOING_DECLINED) && $grantee_grant->country_id == AMERICAN_DATABASE) {
                                    echo !empty($up->fiscal_year) ? '(' . $up->fiscal_year . ')' : '';
                                }
                                if ($grantee_grant->country_id == INDONESIAN_DATABASE) {
                                    echo !empty($up->fiscal_year) ? '(' . $up->fiscal_year . ')' : '';
                                }
                                ?>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($grantee_grant) { ?>
                        <li <?= $pid == 'report' ? 'class="active"' : '' ?>><a data-toggle="tab" href="#report" aria-expanded="true">Aminef Report</a></li>
                        <!-- <li <?= $pid == 'setting' ? 'class="active"' : '' ?>><a data-toggle="tab" href="#setting" aria-expanded="true">Setting</a></li> -->
                    <?php } ?>
                <?php } ?>
                <?php if ($is_admin && $this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
                    <li <?= $pid == 'leave' ? 'class="active"' : '' ?>>
                        <a data-toggle="tab" href="#leave_application" aria-expanded="true">
                            Leave Request
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="tab-content">
            <div id="personal" class="tab-pane fade <?= $default_content_active ?>">
                <?php if ($active_country == INDONESIAN_DATABASE && !is_admin()) { ?>
                    <div class="col-md-12">
                        <div class="alert alert-warning"><i class="fa fa-info-circle"></i> You can only fill in the Name, Biographical Information, and Citizenship Information sections once. These fields cannot be changed afterwards.</div>
                    </div>
                <?php } ?>
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
                                    <!-- <input type="text" class="form-control" name="prefix_name" value="<?php echo $this->Grantee_ent_model->prefix_name ?>" <?php echo disable_if_filled($this->Grantee_ent_model->prefix_name); ?> placeholder="Prefix"> -->
                                </div>
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control auto-capitalize" name="middle_name" value="<?php echo $this->Grantee_ent_model->middle_name ?>" <?php echo disable_if_filled($this->Grantee_ent_model->middle_name); ?> placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label>Suffix (Jr./Sr.I/II/II)</label>
                                    <input type="text" class="form-control" name="suffix_ame" value="<?php echo $this->Grantee_ent_model->suffix_ame ?>" <?php echo disable_if_filled($this->Grantee_ent_model->suffix_ame); ?> placeholder="Suffix">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>First/Given Name</label><?= $required_label ?>
                                    <input type="text" class="form-control auto-capitalize" name="first_name" id="first_name" value="<?php echo $this->Grantee_ent_model->first_name ?>" <?php echo disable_if_filled($this->Grantee_ent_model->first_name); ?> placeholder="First/Given Name">
                                    <?php if ($this->session->userdata('active_country') == INDONESIAN_DATABASE || $this->session->userdata('grantee_country_id') == INDONESIAN_DATABASE) { ?>
                                        <input type="checkbox" value="1" autocomplete="off" name="dont_have_first_name" class="dont_have_first_name" id="dont_have_first_name5" <?= $this->Grantee_ent_model->dont_have_first_name == 1 ? "checked" : "" ?>>
                                        <label class="is_unlimited_label" for="dont_have_first_name5">I do not have a first/given name</label>
                                    <?php } ?>
                                    <div id="invalid_first_name" class="text-danger invalid-tooltip">
                                        First Name is not null.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Last/Family Name</label><?= $required_label ?>
                                    <input type="text" class="form-control auto-capitalize" name="last_name" id="last_name" value="<?php echo $this->Grantee_ent_model->last_name ?>" <?php echo disable_if_filled($this->Grantee_ent_model->last_name); ?> placeholder="Last/Family Name">
                                    <div id="invalid_last_name" class="text-danger invalid-tooltip">
                                        Last Name is not null.
                                    </div>
                                </div>
                            </div>
                            <?php if ($active_country == INDONESIAN_DATABASE) { ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label id="label-img_photo">Photo (See some examples and follow the guide <a href="<?php echo site_url('img/photo_sample.jpg'); ?>" class="lightbox">here</a>) </label><?= $required_label ?>
                                        <?php
                                        $profile_photo = user_grantee_file_url($user_grantee, 'profile_photo');
                                        ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                            <a href="<?php echo site_url($profile_photo); ?>" class="lightbox" aria-haspopup="dialog">
                                                <img id="preview_image_profile" data-old="<?php echo site_url($profile_photo); ?>" src="<?php echo get_preview($profile_photo); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                            </a>
                                            <?php if (disable_if_filled($user_grantee->img_photo) != 'disabled') { ?>
                                                <a href="javascript:;" onclick="del_file(this, 'img_photo', 'Photo')" id="button_delete_img_photo" class="btn btn-danger btn-xs <?php echo empty($this->Grantee_ent_model->img_photo) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                    <i class="fa fa-trash fa-fw"></i>
                                                </a>
                                            <?php } ?>
                                            <a href="<?php echo base_url($profile_photo) ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs <?php echo disable_if_filled($user_grantee->img_photo) != 'disabled' ? 'mt-5' : ''; ?> <?php echo empty($this->Grantee_ent_model->img_photo) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                        </div>
                                        <input type="file" class="custom-file-input hide" accept="<?php foreach (ALLOWED_PROFILE_FILETYPE as $filetype) {
                                                                                                        echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ",";
                                                                                                    } ?>" id="img_photo" onchange="show_preview(this, 'profile', 'img_photo');">
                                        <input type="hidden" name="img_photo" value="<?php echo $this->Grantee_ent_model->img_photo; ?>">
                                        <?php //if (disable_if_filled($user_grantee->img_photo) != 'disabled') { ?>
                                            <label class="btn btn-primary upload-button" for="img_photo"> Choose file </label>
                                        <?php //} ?>
                                        <a href="<?php echo site_url($profile_photo) ?>" id="button_preview_img_photo" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                        <div>
                                            <small>
                                                The applicant's photograph to be included in the Application Form should be taken within six months of submission to reflect your current appearance, in color, and sized 2x2 inches (51x51 mm) or 3.5x4.5 cm. It should be taken against a plain white or off-white background. Please see the attached requirement for details.
                                            </small><br />
                                            <small class="file-for-testing">
                                                File Size Max 5MB
                                                <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                    | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
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
                            <?php } else { ?>
                                <!-- <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Photo (Headshot) </label><?= $required_label ?>
                                    <?php
                                    $headshot = user_grantee_file_url($user_grantee, 'headshot');
                                    ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo site_url($headshot); ?>" class="lightbox" aria-haspopup="dialog">
                                            <img id="preview_image_headshot" data-old="<?php echo site_url($headshot); ?>" src="<?php echo get_preview($headshot); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                        </a>
                                        <a href="javascript:;" onclick="del_file(this, 'headshot', 'headshot')" id="button_delete_headshot" class="btn btn-danger btn-xs <?php echo empty($this->Grantee_ent_model->headshot) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                        <a href="<?php echo base_url($headshot) ?>" id="button_download_headshot" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($this->Grantee_ent_model->headshot) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                    <input type="file" class="custom-file-input hide" accept="<?php foreach (ALLOWED_PROFILE_FILETYPE as $filetype) {
                                                                                                    echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ",";
                                                                                                } ?>" id="headshot" onchange="show_preview(this, 'headshot', 'headshot');">
                                    <input type="hidden" name="headshot" value="<?php echo $this->Grantee_ent_model->headshot; ?>">
                                    <label class="btn btn-primary upload-button" for="headshot"> Choose file </label> 
                                    <a href="<?php echo site_url($headshot) ?>" id="button_preview_headshot" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                    <div>
                                        <small class="file-for-testing">
                                            File Size Max 5MB 
                                            <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                            | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?> 
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
                            </div> -->
                            <?php } ?>
                        </div>
                        <?php if ($active_grant && $active_grant->allow_dependents) { ?>
                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> DEPENDENT INFORMATION</p>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>AMINEF needs to know if you will bring any dependents (spouse and/or child)?</label>
                                    <div class="radio-group">
                                        <label class="radio-inline">
                                            <input type="radio" name="has_dependents" value="1" <?php echo $this->Grantee_ent_model->has_dependents == 1 ? 'checked' : '' ?> required>
                                            Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="has_dependents" value="0" <?php echo $this->Grantee_ent_model->has_dependents == 0 ? 'checked' : '' ?> required>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="dependent_fields_section" class="panel-body mt-3" style="<?php echo $this->Grantee_ent_model->has_dependents == 1 ? '' : 'display:none;' ?>">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Number of dependents?</label><?= $required_label ?>
                                        <input type="number" class="form-control" name="number_of_dependents" id="number_of_dependents" value="<?php echo $this->Grantee_ent_model->number_of_dependents ?>" min="0" placeholder="Number of dependent">
                                        <div id="invalid_number_of_dependents" class="text-danger invalid-tooltip">
                                            Number of dependent is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Number of school age dependents?</label><?= $required_label ?>
                                        <input type="number" class="form-control" name="number_of_school_age_dependents" id="number_of_school_age_dependents" value="<?php echo $this->Grantee_ent_model->number_of_school_age_dependents ?>" min="0" placeholder="Number of school age dependent">
                                        <div id="invalid_number_of_school_age_dependents" class="text-danger invalid-tooltip">
                                            Number of school age dependent is required.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BIOGRAPHICAL INFORMATION</p>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Birthdate</label><?= $required_label ?>
                                    <input type="text" class="form-control datepicker-birthdate" readonly name="birth_date" id="birth_date" <?php echo disable_if_filled($this->Grantee_ent_model->birth_date); ?> placeholder="Birthdate" value="<?php echo ($this->Grantee_ent_model->birth_date) ? date('d M Y', strtotime($this->Grantee_ent_model->birth_date)) : '' ?>">
                                    <div id="invalid_birth_date" class="text-danger invalid-tooltip">
                                        Birthdate is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country of Birth</label><?= $required_label ?>
                                    <select id="birth_country" class="form-control select2 select-country-birth" name="birth_country" id="birth_country" <?php echo disable_if_filled($this->Grantee_ent_model->birth_country, true); ?>>
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
                                    <select id="birth_state" class="form-control select2 select-state-birth" name="birth_state" id="birth_state" <?php echo disable_if_filled($this->Grantee_ent_model->birth_state, true); ?>>
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
                                    <div id="invalid_birth_state" class="text-danger invalid-tooltip">
                                        State of Birth is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>City of Birth</label><?= $required_label ?>
                                    <select id="birth_city" class="form-control select2 select-city-birth" name="birth_city" id="birth_city" <?php echo disable_if_filled($this->Grantee_ent_model->birth_city, true); ?>>
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
                                    <div id="invalid_birth_city" class="text-danger invalid-tooltip">
                                        City of Birth is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Gender</label><?= $required_label ?>
                                    <select class="form-control" name="gender" id="gender" <?php echo disable_if_filled($this->Grantee_ent_model->gender); ?>>
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

                                    <input type="text" class="form-control" name="physical_impairment" value="<?php echo $this->Grantee_ent_model->physical_impairment ?>" <?php echo disable_if_filled($this->Grantee_ent_model->physical_impairment); ?> placeholder="Physical Impairment">
                                </div>
                            </div>
                            <?php if ($active_country == AMERICAN_DATABASE) { ?>
                                <div class="col-lg-12 mt-5">
                                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> AMINEF acknowledges the participants of our programs in our website. Your photo and shortbio (150-300 words) will be uploaded after you have your visa and permits.
                                        See samples in our <a class="text-warning" target="_blank" href="https://www.aminef.or.id/grantee-stories/current-grantees-alumni/american/"><b>website</b></a>.</div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label id="label-bio">Bio <span style="color:red"> *</span></label>
                                        <textarea class="form-control" rows="7" id="bio" name="bio"><?php echo $this->Grantee_ent_model->bio ?></textarea>
                                        <div id="invalid_bio_required" class="text-danger invalid-tooltip">
                                            Bio is not null
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label id="label-bio_photo">Photo <span style="color:red"> *</span></label>
                                        <?php
                                        $bio_photo = user_grantee_file_url($user_grantee, 'bio_photo');
                                        ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                            <a href="<?php echo site_url($bio_photo); ?>" class="lightbox" aria-haspopup="dialog">
                                                <img id="preview_image_bio_photo" data-old="<?php echo site_url($bio_photo); ?>" src="<?php echo get_preview($bio_photo); ?>" height="100" style="min-height:60px;object-fit:contain;">
                                            </a>
                                            <a href="javascript:;" onclick="del_file(this, 'bio_photo', 'Curriculum Vitae')" id="button_delete_bio_photo" class="btn btn-danger btn-xs <?php echo empty($this->Grantee_ent_model->bio_photo) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            <a href="<?php echo base_url($bio_photo) ?>" id="button_download_bio_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($this->Grantee_ent_model->bio_photo) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                        </div>
                                        <input type="file" class="custom-file-input hide" accept="<?php foreach (ALLOWED_PROFILE_FILETYPE as $filetype) {
                                                                                                        echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ",";
                                                                                                    } ?>" id="bio_photo" onchange="show_preview(this, 'bio_photo', 'bio_photo');">
                                        <input type="hidden" name="bio_photo" value="<?php echo $this->Grantee_ent_model->bio_photo; ?>">
                                        <label class="btn btn-primary upload-button" for="bio_photo"> Choose file </label>
                                        <a href="<?php echo site_url($bio_photo) ?>" id="button_preview_bio_photo" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                        <div>
                                            <small class="file-for-testing">
                                                File Size Max 5MB
                                                <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                    | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
                                                <?php } ?>
                                            </small>
                                            <div id="invalid_photo_bio" class="text-danger invalid-tooltip">
                                                Please Choose File.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label id="label-cv">Curriculum Vitae
                                            <?php if ($active_grant && (isset($active_grant->example_cv) && !empty($active_grant->example_cv))) { ?>
                                                (<a class="btn-link" download href="<?php echo site_url($active_grant->example_cv); ?>"> Download & Use this template </a>)
                                            <?php } ?>
                                            <span style="color:red"> *</span>
                                        </label>
                                        <?php
                                        $cv = user_grantee_file_url($user_grantee, 'cv');
                                        ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                            <a href="<?php echo site_url($cv); ?>" class="lightbox" aria-haspopup="dialog">
                                                <img id="preview_image_cv" data-old="<?php echo site_url($cv); ?>" src="<?php echo get_preview($cv); ?>" width="100" style="min-height:80px;object-fit:contain;">
                                            </a>
                                            <a href="javascript:;" onclick="del_file(this, 'cv', 'Curriculum Vitae')" id="button_delete_cv" class="btn btn-danger btn-xs <?php echo empty($this->Grantee_ent_model->cv) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            <a href="<?php echo base_url($cv) ?>" id="button_download_cv" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($this->Grantee_ent_model->cv) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                        </div>
                                        <input type="file" class="custom-file-input hide" accept="<?php foreach (ALLOWED_PROFILE_FILETYPE as $filetype) {
                                                                                                        echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ",";
                                                                                                    } ?>" id="cv" onchange="show_preview(this, 'cv', 'cv');">
                                        <input type="hidden" id="cv" name="cv" value="<?php echo $this->Grantee_ent_model->cv; ?>">
                                        <label class="btn btn-primary upload-button" for="cv"> Choose file </label>
                                        <a href="<?php echo site_url($cv) ?>" id="button_preview_cv" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>

                                        <div>
                                            <small class="file-for-testing">
                                                File Size Max 5MB
                                                <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                    | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
                                                <?php } ?>
                                            </small>
                                            <div id="invalid_cv" class="text-danger invalid-tooltip">
                                                Please Choose File.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>
                                            Dietary Restrictions <span style="color:red"> *</span>
                                        </label>
                                        <input type="text" class="form-control" name="dietary_restrictions" id="dietary_restrictions" value="<?php echo $this->Grantee_ent_model->dietary_restrictions ?>" placeholder="Dietary Restrictions">
                                        <div id="invalid_dietary_restrictions" class="text-danger invalid-tooltip">
                                            Dietary Restrictions
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- <div class="col-lg-4">
                                <div class="form-group">
                                    <label>City of Birth</label><?= $required_label ?>
                                    <input type="text" class="form-control" name="birth_city" id="birth_city" value="<?= $this->Grantee_ent_model->birth_city ?>">
                                    <div id="invalid_birth_city" class="text-danger invalid-tooltip">
                                        City of Birth is not null.
                                    </div>
                                </div>
                            </div> -->
                        </div>


                        <?php /*
                        <div class="panel-body mt-3" style="margin-bottom:-30px;">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> ACADEMIC BACKGROUND<br />
                                <small>Please list your academic background starting from the highest degree.</small>
                            </p>
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
                                        <input type="hidden" class="form-control" name="info[institution][<?= $key ?>][temp_id]" value="<?= $row->temp_id ?>">
                                        <div class="panel-body">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Institution Name</label><?= $required_label ?>
                                                    <input type="text" class="form-control" id="institute_name<?= $key ?>" name="info[institution][<?= $key ?>][name]" value="<?= $row->name ?>" placeholder="Institution Name">
                                                    <div id="invalid_institute_name<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Institution Name is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Level of Study</label><?= $required_label ?>
                                                    <!-- <input type="text" class="form-control" name="info[institution][<?= $key ?>][level_study]" placeholder="Level of Study" value="<?= $row->level_study ?>"> -->
                                                    <select class="form-control" id="level_study<?= $key ?>" name="info[institution][<?= $key ?>][level_study]">
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
                                                    <div id="invalid_level_study<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Level of Study is not null.
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Country</label><?= $required_label ?>
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
                                                        <div id="invalid_institution_country<?= $key ?>" class="text-danger invalid-tooltip">
                                                            Country is not null.
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-25px;">
                                            
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>State/Province</label><?= $required_label ?>
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
                                                    <div id="invalid_institution_state<?= $key ?>" class="text-danger invalid-tooltip">
                                                        State/Province is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>City</label><?= $required_label ?>
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
                                                    <div id="invalid_institution_city<?= $key ?>" class="text-danger invalid-tooltip">
                                                        City is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>
                                                        Degree
                                                        <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="Please provide your most recently completed or in-progress degree">i</span>
                                                    </label><?= $required_label ?>
                                                    <!-- <input type="text" class="form-control" id="degree_name<?= $key ?>" name="info[institution][<?= $key ?>][degree_name]" placeholder="Degree" value="<?= $row->degree_name ?>"> -->
                                                    <select class="form-control" name="info[institution][<?= $key ?>][degree_name]" id="degree_name<?= $key ?>">
                                                        <option value="">-- Select Degree --</option>
                                                        <?php
                                                        if ($degree_name) {
                                                            foreach ($degree_name as $dn) {
                                                                $selected = '';
                                                                if ($row->degree_name == $dn) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                        ?>
                                                                <option value="<?php echo $dn ?>" <?php echo $selected ?>><?php echo $dn ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <!-- <small class="text-danger">(e.g. BA/MA/MFA)</small> -->
                                                    <div id="invalid_degree_name<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Degree is not null.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="margin-top:-20px">
                                            <div class="col-lg-4" style="display:<?= $row->degree_name == 'Other' && $row->other_degree ? 'block' : 'none' ?>;" id="other_degree_col<?= $key ?>">
                                                <div class="form-group">
                                                    <label>Other Degree</label>
                                                    <input type="text" class="form-control" name="info[institution][<?= $key ?>][other_degree]" id="other_degree<?= $key ?>" placeholder="Other Degree" value="<?= $row->other_degree ?>">
                                                    <div id="invalid_other_degree" class="text-danger invalid-tooltip">
                                                        Other Degree is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Field of Study </label> <?= $required_label ?>
                                                    <input type="text" class="form-control" id="discipline<?= $key ?>" name="info[institution][<?= $key ?>][discipline]" value="<?php echo $row->discipline ?>" placeholder="Field of Study ">
                                                    <div id="invalid_discipline<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Field of Study is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Enrolled From</label><?= $required_label ?>
                                                    <input type="text" class="form-control datepicker" readonly style="background-color:#fff" id="endrolled_from<?= $key ?>" name="info[institution][<?= $key ?>][endrolled_from]" value="<?= ($row->endrolled_from) ? date('d M Y', strtotime($row->endrolled_from)) : '' ?>" placeholder="Enrolled From">
                                                    <div id="invalid_endrolled_from<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Enrolled From is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Enrolled To</label>
                                                    <input type="text" class="form-control datepicker" readonly style="background-color:#fff" id="endrolled_to<?= $key ?>" name="info[institution][<?= $key ?>][endrolled_to]" value="<?= ($row->endrolled_to) ? date('d M Y', strtotime($row->endrolled_to)) : '' ?>" placeholder="Enrolled To">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Degree Received/Expected</label>
                                                    <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="If you haven't received your degree, please indicate the date you will expected to receive.">i</span></label>
                                                    <input type="text" class="form-control datepicker" readonly style="background-color:#fff" name="info[institution][<?= $key ?>][degree_date]" placeholder="Degree Received/Expected" value="<?= ($row->degree_date) ? date('d M Y', strtotime($row->degree_date)) : '' ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo $del_btn ?>
                                    </div>
                                <?php }
                            } else { ?>
                                <div id="institution-item-0" class="institution-item" style="position:relative">
                                    <input type="hidden" class="form-control" name="info[institution][0][temp_id]" value="1">
                                    <div class="panel-body">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Institution Name</label><?= $required_label ?>
                                                <input type="text" class="form-control" name="info[institution][0][name]" id="institute_name" placeholder="Institution Name">
                                                <div id="invalid_institute_name" class="text-danger invalid-tooltip">
                                                    Institution Name is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Level of Study</label><?= $required_label ?>
                                                <!-- <input type="text" class="form-control" name="info[institution][0][level_study]" id="level_study" placeholder="Level of Study"> -->
                                                <select class="form-control" name="info[institution][0][level_study]" id="level_study">
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
                                                <div id="invalid_level_study" class="text-danger invalid-tooltip">
                                                    Level of Study is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Country</label><?= $required_label ?>
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
                                                <div id="invalid_institution_country" class="text-danger invalid-tooltip">
                                                    Country is not null.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="margin-top:-25px;">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>State/Province</label><?= $required_label ?>
                                                <img src="<?php echo base_url() ?>/img/loading.gif" id="load-institution_state" style="display:none;">
                                                <select id="institution_state" class="form-control select2 select-state" name="info[institution][0][province]" style="width:100%">
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
                                                <div id="invalid_institution_state" class="text-danger invalid-tooltip">
                                                    State/Province is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>City</label><?= $required_label ?>
                                                <img src="<?php echo base_url() ?>/img/loading.gif" id="load-institution_city" style="display:none;">
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
                                                <div id="invalid_institution_city" class="text-danger invalid-tooltip">
                                                    City is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>
                                                    Degree
                                                    <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="Please provide your most recently completed or in-progress degree">i</span>
                                                </label><?= $required_label ?>
                                                <!-- <input type="text" class="form-control" name="info[institution][0][degree_name]" id="degree_name" placeholder="Degree"> -->
                                                <select class="form-control" name="info[institution][0][degree_name]" id="degree_name">
                                                    <option value="">-- Select Degree --</option>
                                                    <?php
                                                    if ($degree_name) {
                                                        foreach ($degree_name as $dn) {
                                                            $selected = '';
                                                            if ($row->degree_name == $dn) {
                                                                $selected = 'selected="selected"';
                                                            }
                                                    ?>
                                                            <option value="<?php echo $dn ?>" <?php echo $selected ?>><?php echo $dn ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <!-- <small class="text-danger">(e.g. BA/MA/MFA)</small> -->
                                                <div id="invalid_degree_name" class="text-danger invalid-tooltip">
                                                    Degree is not null.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="margin-top:-20px">
                                        <div class="col-lg-4" style="display:none;" id="other_degree_col">
                                            <div class="form-group">
                                                <label>Other Degree</label>
                                                <input type="text" class="form-control" name="info[institution][0][other_degree]" id="other_degree" placeholder="Other Degree">
                                                <div id="invalid_other_degree" class="text-danger invalid-tooltip">
                                                    Other Degree is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Field of Study </label><?= $required_label ?>
                                                <input type="text" class="form-control" name="info[institution][0][discipline]" id="discipline" placeholder="Field of Study ">
                                                <div id="invalid_discipline" class="text-danger invalid-tooltip">
                                                    Field of Study is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Enrolled From</label><?= $required_label ?>
                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" name="info[institution][0][endrolled_from]" id="endrolled_from" placeholder="Enrolled From">
                                                <div id="invalid_endrolled_from" class="text-danger invalid-tooltip">
                                                    Enrolled From is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Enrolled To</label>
                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" name="info[institution][0][endrolled_to]" id="endrolled_to" placeholder="Enrolled To">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="margin-top:-20px;">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>
                                                    Degree Received / Expected
                                                    <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="If you haven't received your degree, please indicate the date you will expected to receive.">i</span>
                                                </label>
                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" name="info[institution][0][degree_date]" placeholder="Degree Received / Expected">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="panel-body" style="margin-top:-20px">
                            <div class="col-lg-12">
                                <a href="javascript:;" onclick="add_institution()" class="btn btn-primary">
                                    <i class="fa fa-plus fa-fw"></i> Add More Academic Background
                                </a>
                                <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load" style="display:none;">
                            </div>
                        </div>
                         */ ?>
                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> CITIZENSHIP INFORMATION</p>
                            <div class="col-md-8 p-0">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Country of Citizenship</label><?= $required_label ?>
                                        <select id="citizen_country" class="form-control select2 select-country" name="citizen_country" style="width:100%" <?php echo disable_if_filled($this->Grantee_ent_model->citizen_country, true); ?>>
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
                                        <div id="invalid_citizen_country" class="text-danger invalid-tooltip">
                                            Country of Citizenship is not null.
                                        </div>
                                    </div>
                                </div>
                                <?php if ($active_country == INDONESIAN_DATABASE) { ?>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>KTP</label><?= $required_label ?>
                                            <input type="text" class="form-control" name="number_identity" id="number_identity" maxlength="16" value="<?php echo $this->Grantee_ent_model->number_identity ?>" placeholder="KTP" <?php echo disable_if_filled($this->Grantee_ent_model->number_identity); ?>>
                                            <div id="invalid_number_identity_length" class="text-danger invalid-tooltip">
                                                Min 16 Digit.
                                            </div>
                                            <div id="invalid_number_identity" class="text-danger invalid-tooltip">
                                                KTP is not null.
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Passport Number</label>
                                        <?php if ($active_country == AMERICAN_DATABASE) { ?><?= $required_label ?> <?php } ?>
                                    <input type="text" class="form-control" name="number_passport" id="number_passport" value="<?php echo $this->Grantee_ent_model->number_passport ?>" placeholder="Passport Number" <?php echo disable_if_filled($this->Grantee_ent_model->number_passport); ?>>
                                    <?php if ($active_country == AMERICAN_DATABASE) { ?>
                                        <div id="invalid_number_passport" class="text-danger invalid-tooltip">
                                            Passport is not null.
                                        </div>
                                    <?php } ?>
                                    </div>
                                    <?php if ($active_country == INDONESIAN_DATABASE) { ?>
                                        <div class="form-group">
                                            <label id="label-img_passport_id">Passport</label><br />
                                            <small class="file-for-testing mb-3">Please submit the first four pages of your passport</small>
                                            <?php
                                            $profile_photo = user_grantee_file_url($user_grantee, 'passport_id');
                                            ?>
                                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                                <a href="<?php echo site_url($profile_photo); ?>" class="lightbox" aria-haspopup="dialog">
                                                    <img id="preview_image_passport_id" data-old="<?php echo site_url($profile_photo); ?>" src="<?php echo get_preview($profile_photo); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                </a>
                                                <?php if (disable_if_filled($user_grantee->img_passport_id) != 'disabled') { ?>
                                                    <a href="javascript:;" onclick="del_file(this, 'img_passport_id', 'Passport Id')" id="button_delete_img_passport_id" class="btn btn-danger btn-xs <?php echo empty($this->Grantee_ent_model->img_passport_id) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                        <i class="fa fa-trash fa-fw"></i>
                                                    </a>
                                                <?php } ?>
                                                <a href="<?php echo base_url($profile_photo) ?>" id="button_download_img_passport_id" download title="Click to download" class="btn btn-primary btn-xs <?php echo disable_if_filled($user_grantee->img_passport_id) != 'disabled' ? 'mt-5' : ''; ?> <?php echo empty($this->Grantee_ent_model->img_passport_id) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                            </div>
                                            <input type="file" class="custom-file-input hide" accept="<?php foreach (ALLOWED_PROFILE_FILETYPE as $filetype) {
                                                                                                            echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ",";
                                                                                                        } ?>" id="img_passport_id" onchange="show_preview(this, 'passport_id', 'img_passport_id');">
                                            <input type="hidden" name="img_passport_id" value="<?php echo $this->Grantee_ent_model->img_passport_id; ?>">
                                            <?php //if (disable_if_filled($user_grantee->img_passport_id) != 'disabled') { ?>
                                                <label class="btn btn-primary upload-button" for="img_passport_id"> Choose file </label>
                                            <?php //} ?>
                                            <a href="<?php echo site_url($profile_photo) ?>" id="button_preview_img_passport_id" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                            <div>
                                                <small class="file-for-testing">
                                                    File Size Max 5MB
                                                    <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                        | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
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
                                    <?php } ?>
                                </div>

                                <?php if ($active_country == AMERICAN_DATABASE) { ?>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Passport Expiry Date <?= $required_label ?></label>
                                            <input
                                                type="text"
                                                id="passport_expiry_date"
                                                name="passport_expiry_date"
                                                value="<?php
                                                        echo $this->Grantee_ent_model->passport_expiry_date && $this->Grantee_ent_model->passport_expiry_date != '0000-00-00'  ?
                                                            date('d M Y', strtotime($this->Grantee_ent_model->passport_expiry_date)) : date('d M Y') ?>"
                                                class="form-control datepicker" readonly style="background-color:#fff">
                                            <div id="invalid_passport_expiry_date" class="text-danger invalid-tooltip">
                                                Passport Expiry Date is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Passport Date of Issue <?= $required_label ?></label>
                                            <input class="form-control datepicker" readonly style="background-color:#fff" id="passport_date_issue" name="passport_date_issue" value="<?php echo ($this->Grantee_ent_model->passport_date_issue) ? date('d M Y', strtotime($this->Grantee_ent_model->passport_date_issue)) : '' ?>">
                                            <div id="invalid_passport_date_issue" class="text-danger invalid-tooltip">
                                                Passport Date of Issue is not null.
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label id="label-img_passport">
                                        <?php echo ($active_country == 1 ? "KTP" : 'Passport (Follow the guide <a href="' . site_url('img/passport_photo_samplev2.png') . '" class="lightbox">here</a>)'); ?>
                                    </label><?= $required_label ?>
                                    <?php
                                    $profile_photo = user_grantee_file_url($user_grantee, 'passport');
                                    ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo site_url($profile_photo); ?>" class="lightbox" aria-haspopup="dialog">
                                            <img id="preview_image_passport" data-old="<?php echo site_url($profile_photo); ?>" src="<?php echo get_preview($profile_photo); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                        </a>
                                        <?php if (disable_if_filled($user_grantee->img_passport) == 'disabled') { ?>
                                            <a href="javascript:;" onclick="del_file(this, 'img_passport', 'Passport')" id="button_delete_img_passport" class="btn btn-danger btn-xs <?php echo empty($this->Grantee_ent_model->img_passport) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                        <?php } ?>
                                        <a href="<?php echo base_url($profile_photo) ?>" id="button_download_img_passport" download title="Click to download" class="btn btn-primary btn-xs <?php echo disable_if_filled($user_grantee->img_passport) != 'disabled' ? 'mt-5' : ''; ?> <?php echo empty($this->Grantee_ent_model->img_passport) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                    <input type="file" class="custom-file-input hide" accept="<?php foreach (ALLOWED_PROFILE_FILETYPE as $filetype) {
                                                                                                    echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ",";
                                                                                                } ?>" id="img_passport" onchange="show_preview(this, 'passport', 'img_passport');">
                                    <input type="hidden" name="img_passport" value="<?php echo $this->Grantee_ent_model->img_passport; ?>">
                                    <?php if (disable_if_filled($user_grantee->img_passport) != 'disabled') { ?>
                                        <label class="btn btn-primary upload-button" for="img_passport"> Choose file </label>
                                    <?php } ?>
                                    <a href="<?php echo site_url($profile_photo) ?>" id="button_preview_img_passport" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                    <div>
                                        <small class="file-for-testing">
                                            File Size Max 5MB
                                            <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
                                            <?php } ?>
                                        </small>
                                        <div id="invalid_photo" class="text-danger invalid-tooltip">
                                            Max File Size 5Mb.
                                        </div>
                                        <div id="invalid_passport_required" class="text-danger invalid-tooltip">
                                            Please Choose File.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($active_country == AMERICAN_DATABASE) { ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label id="label-img_photo">
                                            Photo for visa and other permits. <br />
                                            <small>(See this <a href="<?php echo site_url('img/Guideline photo for visa and other permits.pdf'); ?>" class="lightbox">guideline</a> to make sure your submission complies with the Indonesian government regulation)</small>
                                        </label><?= $required_label ?>
                                        <?php
                                        $profile_photo = user_grantee_file_url($user_grantee, 'profile_photo');
                                        ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                            <a href="<?php echo site_url($profile_photo); ?>" class="lightbox" aria-haspopup="dialog">
                                                <img id="preview_image_profile" data-old="<?php echo site_url($profile_photo); ?>" src="<?php echo get_preview($profile_photo); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                            </a>
                                            <a href="javascript:;" onclick="del_file(this, 'img_photo', 'Photo')" id="button_delete_img_photo" class="btn btn-danger btn-xs <?php echo empty($this->Grantee_ent_model->img_photo) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            <a href="<?php echo base_url($profile_photo) ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($this->Grantee_ent_model->img_photo) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                        </div>
                                        <input type="file" class="custom-file-input hide" accept="<?php foreach (ALLOWED_PROFILE_FILETYPE as $filetype) {
                                                                                                        echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ",";
                                                                                                    } ?>" id="img_photo" onchange="show_preview(this, 'profile', 'img_photo');">
                                        <input type="hidden" name="img_photo" value="<?php echo $this->Grantee_ent_model->img_photo; ?>">
                                        <label class="btn btn-primary upload-button" for="img_photo"> Choose file </label>
                                        <a href="<?php echo site_url($profile_photo) ?>" id="button_preview_img_photo" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                        <div>
                                            <small class="file-for-testing">
                                                File Size Max 5MB
                                                <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                    | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
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
                            <?php } ?>
                        </div>

                        <?php if (($this->Grantee_ent_model->country_id == AMERICAN_DATABASE && get_grantee_setting()->require_bank_info) || is_admin())  { ?>
                            <?php if ($grantee_setting->sumber_dana == 'aminef' || $grantee_setting->sumber_dana == null)  { ?>
                                <div class="panel-body mt-3">
                                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BANK INFO</p>
                                    <?php if(($this->Grantee_ent_model->bank_name != '' && $this->Grantee_ent_model->country_id == INDONESIAN_DATABASE) || $this->Grantee_ent_model->country_id == AMERICAN_DATABASE) { ?>
                                        <div class="panel panel-info setup-block-support">
                                            <div class="panel-heading" style="border-top-left-radius:5px !important;border-top-right-radius:5px !important;">
                                                <p class="panel-title">
                                                    Default
                                                </p>
                                            </div>
                                            <div id="setupSupport" class="collapse-payment-support panel-collapse collapse in" data-panelid="" style="border:1px solid #eee;">
                                                <div class="panel-body">
                                                    <!-- <div class="col-md-12">
                                                        <div class="alert alert-info">Default</div>
                                                    </div> -->
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Beneficiary Name (As listed on the bank account)</label><?= $required_label ?>
                                                            <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name" value="<?php echo $this->Grantee_ent_model->beneficiary_name ?>" placeholder="Beneficiary Name">
                                                            <div id="invalid_beneficiary_name" class="text-danger invalid-tooltip">
                                                                Beneficiary Name is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Bank Name</label><?= $required_label ?>
                                                            <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $this->Grantee_ent_model->bank_name ?>" placeholder="Bank Name">
                                                            <div id="invalid_bank_name" class="text-danger invalid-tooltip">
                                                                Bank Name is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Beneficiary Address: [Building/Street, City, State/Province + Postal Code, Country]</label><?= $required_label ?>
                                                            <input type="text" class="form-control" name="beneficiary_address" id="beneficiary_address" value="<?php echo $this->Grantee_ent_model->beneficiary_address ?>" placeholder="Bank Address">
                                                            <div id="invalid_beneficiary_address" class="text-danger invalid-tooltip">
                                                                Bank Address is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Bank Address: [Building/Street, City, State/Province + Postal Code, Country]</label><?= $required_label ?>
                                                            <input type="text" class="form-control" name="bank_address" id="bank_address" value="<?php echo $this->Grantee_ent_model->bank_address ?>" placeholder="Bank Address">
                                                            <div id="invalid_bank_address" class="text-danger invalid-tooltip">
                                                                Bank Address is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Account Number</label><?= $required_label ?>
                                                            <input type="text" class="form-control" name="account_number" id="account_number" value="<?php echo $this->Grantee_ent_model->account_number ?>" placeholder="Account Number">
                                                            <div id="invalid_account_number" class="text-danger invalid-tooltip">
                                                                Account Number is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Routing or ABA Number (for U.S. Banks)</label><?= $required_label ?>
                                                            <input type="text" class="form-control" name="routing_number" id="routing_number" value="<?php echo $this->Grantee_ent_model->routing_number ?>" placeholder="Routing or ABA Number (for U.S. Banks)">
                                                            <div id="invalid_routing_number" class="text-danger invalid-tooltip">
                                                                Routing or ABA Number (for U.S. Banks) is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>SWIFT Code</label><?= $required_label ?>
                                                            <input type="text" class="form-control" name="swift_code" id="swift_code" value="<?php echo $this->Grantee_ent_model->swift_code ?>" placeholder="SWIFT Code">
                                                            <input type="hidden" id="swift_code_checking_filler" value="<?php echo $this->Grantee_ent_model->swift_code ?>">
                                                            <div id="invalid_swift_code" class="text-danger invalid-tooltip">
                                                                SWIFT Code is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Other Bank Details (Intermediary Bank, etc.)</label>
                                                            <textarea class="form-control" rows="2" name="note_bank"><?php echo $this->Grantee_ent_model->note_bank ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
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
                                                    <!-- <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Void Check <?php echo $active_country == AMERICAN_DATABASE ? '(optional)' : ''; ?></label>
                                                            <?php if ($this->Grantee_ent_model->account_book != '') { ?>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                    <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->account_book ?>" class="lightbox" aria-haspopup="dialog">
                                                                        <img id="preview_image_void_check" src="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->account_book ?>" width="100" style="min-height:60px !important; object-fit:contain;">
                                                                    </a>
                                                                    <a href="javascript:;" onclick="del_file(this, 'account_book', 'Void Check')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28px;">
                                                                        <i class="fa fa-trash fa-fw"></i>
                                                                    </a>
                                                                    <a href="<?php echo base_url() ?><?php echo $this->Grantee_ent_model->account_book ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5" style="position:absolute; top:0; right:-28px;">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div id="preview_section_void_check" style="margin-bottom: 10px; position:relative; width:100px;">
                                                                    <a>
                                                                        <img id="preview_image_void_check" width="100px">
                                                                    </a>
                                                                </div>
                                                            <?php } ?>
                                                            <input type="file" name="account_book" id="account_book" class="hide" onchange="show_preview(this, 'void_check');">
                                                            <div>
                                                                <label class="btn btn-primary upload-button" for="account_book"> Choose file </label>
                                                            </div>
                                                            
                                                            <div>
                                                                <small>File Size Max 5MB</small>
                                                                <div id="invalid_account_book" class="text-danger invalid-tooltip">
                                                                    Please Choose File.
                                                                </div>
                                                                <div id="invalid_account_book_size" class="text-danger invalid-tooltip">
                                                                    Max File Size 5Mb.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-lg-6">
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
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- <div class="col-md-12 other-bank-info <?php //echo (is_array($other_bank_info) && count($other_bank_info) > 0) ? '' : 'hide'; ?>">
                                        <div class="alert alert-info">Other Bank</div>
                                    </div> -->
                                    <div class="panel panel-info setup-block-support <?= $other_bank_info ? '' : 'hide' ?>">
                                        <div class="panel-heading" style="border-top-left-radius:5px !important;border-top-right-radius:5px !important;">
                                            <p class="panel-title">
                                                Other Bank
                                            </p>
                                        </div>
                                        <div id="setupSupport" class="collapse-payment-support panel-collapse collapse in" data-panelid="" style="border:1px solid #eee;">
                                            <div class="panel-body">
                                                <div id="list-other-bank">
                                                    <?php 
                                                        if (is_array($other_bank_info) && count($other_bank_info) > 0) {
                                                            foreach($other_bank_info as $index => $bank){
                                                    ?> 
                                                                <?php if($index != 0 ) : ?>
                                                                    <div class="col-md-12">
                                                                        <hr>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="other-bank">
                                                                    <div class="col-md-12">
                                                                        <a class="btn btn-remove btn-remove-other-bank btn-danger pull-right" data-id="<?php echo $bank->id; ?>"><i class="fa fa-trash"></i></a>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>Beneficiary Name (As listed on the bank account)</label><?= $required_label ?>
                                                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][beneficiary_name]" value="<?php echo $bank->beneficiary_name; ?>" placeholder="Full Name">
                                                                            <div id="invalid_beneficiary_name" class="text-danger invalid-tooltip">
                                                                                Full Name is not null.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>Bank Name</label><?= $required_label ?>
                                                                            <input type="hidden" class="form-control" name="other_bank_info[<?php echo $index; ?>][id]" value="<?php echo $bank->id; ?>" placeholder="Bank Name">
                                                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][bank_name]" value="<?php echo $bank->bank_name; ?>" placeholder="Bank Name">
                                                                            <div id="invalid_bank_name" class="text-danger invalid-tooltip">
                                                                                Bank Name is not null.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>Beneficiary Address: [Building/Street, City, State/Province + Postal Code, Country]</label><?= $required_label ?>
                                                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][beneficiary_address]" value="<?php echo $bank->beneficiary_address; ?>" placeholder="Beneficiary Address">
                                                                            <div id="invalid_beneficiary_address" class="text-danger invalid-tooltip">
                                                                                Beneficiary Address is not null.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>Bank Address: [Building/Street, City, State/Province + Postal Code, Country]</label><?= $required_label ?>
                                                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][bank_address]" value="<?php echo $bank->bank_address; ?>" placeholder="Bank Address">
                                                                            <div id="invalid_bank_address" class="text-danger invalid-tooltip">
                                                                                Bank Address is not null.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>Account Number</label><?= $required_label ?>
                                                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][account_number]" value="<?php echo $bank->account_number; ?>" placeholder="Account Number">
                                                                            <div id="invalid_account_number" class="text-danger invalid-tooltip">
                                                                                Account Number is not null.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>Routing or ABA Number (for U.S. Banks)</label><?= $required_label ?>
                                                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][routing_number]" value="<?php echo $bank->routing_number; ?>" placeholder="Routing or ABA Number (for U.S. Banks)">
                                                                            <div id="invalid_routing_number" class="text-danger invalid-tooltip">
                                                                                Routing or ABA Number (for U.S. Banks) is not null.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>SWIFT Code</label><?= $required_label ?>
                                                                            <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][swift_code]" value="<?php echo $bank->swift_code; ?>" placeholder="SWIFT Code">
                                                                            <inbank" value="<?php echo $bank->swift_code; ?>">
                                                                            <div id="invalid_swift_code" class="text-danger invalid-tooltip">
                                                                                SWIFT Code is not null.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>Other Bank Details (Intermediary Bank, etc.)</label>
                                                                            <textarea class="form-control" rows="2" name="other_bank_info[<?php echo $index; ?>][note_bank]"><?php echo $bank->note_bank; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>Currency</label><?= $required_label ?>
                                                                            <select class="form-control" name="other_bank_info[<?php echo $index; ?>][currency]">
                                                                                <option value="">-- Select Currency --</option>
                                                                                <?php
                                                                                if ($currency) {
                                                                                    foreach ($currency as $cr) {
                                                                                        $selected = '';
                                                                                        if ($bank->currency == $cr) {
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
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label><?= $active_country == AMERICAN_DATABASE ? 'Void Check' : 'First page of bank account information (buku tabungan halaman pertama)' ?> <?php echo $active_country == AMERICAN_DATABASE ? '(optional)' : ''; ?></label>
                                                                            <?php 
                                                                                $account_book = user_grantee_file_url($bank, 'account_book');
                                                                            ?>
                                                                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                                <a href="<?php echo site_url($account_book); ?>" class="lightbox" aria-haspopup="dialog">
                                                                                    <img id="preview_image_account_book-<?php echo $index; ?>" data-old="<?php echo site_url($account_book); ?>" src="<?php echo get_preview($account_book); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                                </a>
                                                                                <a href="javascript:;" onclick="del_other_bank_attachment(this, 'account_book-<?php echo $index; ?>', 'Account Book')" id="button_delete_account_book-<?php echo $index; ?>" class="btn btn-danger btn-xs <?php echo empty($bank->account_book) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                                                    <i class="fa fa-trash fa-fw"></i>
                                                                                </a>
                                                                                <a href="<?php echo base_url($account_book) ?>" id="button_download_account_book-<?php echo $index; ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($bank->account_book) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                                                    <i class="fa fa-download fa-fw"></i>
                                                                                </a>
                                                                            </div>
                                                                            <input type="file" class="custom-file-input hide" id="account_book-<?php echo $index; ?>" onchange="show_preview(this, 'account_book-<?php echo $index; ?>', 'account_book-<?php echo $index; ?>');">
                                                                            <input type="hidden" name="other_bank_info[<?php echo $index; ?>][account_book]" class="account_book-<?php echo $index; ?>" value="<?php echo $bank->account_book; ?>">
                                                                            <label class="btn btn-primary upload-button" for="account_book-<?php echo $index; ?>"> Choose file </label> 
                                                                            <a href="<?php echo site_url($account_book) ?>" id="button_preview_account_book-<?php echo $index; ?>" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
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
                                    </div>
                                    <?php if ($this->Grantee_ent_model->country_id == AMERICAN_DATABASE) { ?>
                                    <div class="col-md-12">
                                        <a class="btn btn-primary" onclick="add_other_bank()"><i class="fa fa-plus"></i> Add Another Bank</a>
                                    </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } else { 

                            $status_candidate = [
                                STATUS_SELECTION_SUCCESSFUL,
                                STATUS_NEW_CANDIDATE,
                                STATUS_CANDIDATE_REVISED,
                                STATUS_CANDIDATE_DECLINED,
                                STATUS_CANDIDATE_SUCCESSFUL,
                                STATUS_CANDIDATE_VERIFIED
                            ];
                            if (in_array($grantee_grant->status, $status_candidate)) {
                            ?>
                                <div class="panel-body mt-3">
                                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BANK INFO</p>


                                    <?php if ($other_bank_info) { ?>
                                        <div id="list-other-bank">
                                            <?php
                                            if (is_array($other_bank_info) && count($other_bank_info) > 0) {
                                                foreach ($other_bank_info as $index => $bank) {
                                            ?>
                                                    <div class="other-bank">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="checkbox checbox-switch switch-primary">
                                                                        <label style="margin-left: -15px;">
                                                                            <input type="checkbox" name="other_bank_info[<?php echo $index; ?>][check_default]" <?= $bank->is_selected ? 'checked' : '' ?> class="check_default" />
                                                                            <span></span>
                                                                            Select as Default
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <a class="btn btn-remove btn-remove-other-bank btn-danger pull-right" data-id="<?php echo $bank->id; ?>"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Bank Name</label>
                                                                <input type="hidden" class="form-control" name="other_bank_info[<?php echo $index; ?>][id]" value="<?php echo $bank->id; ?>" placeholder="Bank Name">
                                                                <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][bank_name]" value="<?php echo $bank->bank_name; ?>" placeholder="Bank Name">
                                                                <div id="invalid_bank_name" class="text-danger invalid-tooltip">
                                                                    Bank Name is not null.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Bank Address</label>
                                                                <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][bank_address]" value="<?php echo $bank->bank_address; ?>" placeholder="Bank Address">
                                                                <div id="invalid_bank_address" class="text-danger invalid-tooltip">
                                                                    Bank Address is not null.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Beneficiary Name</label>
                                                                <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][beneficiary_name]" value="<?php echo $bank->beneficiary_name; ?>" placeholder="Beneficiary Name">
                                                                <div id="invalid_beneficiary_name" class="text-danger invalid-tooltip">
                                                                    Beneficiary Name is not null.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Account Number</label>
                                                                <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][account_number]" value="<?php echo $bank->account_number; ?>" placeholder="Account Number">
                                                                <div id="invalid_account_number" class="text-danger invalid-tooltip">
                                                                    Account Number is not null.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Routing Number</label>
                                                                <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][routing_number]" value="<?php echo $bank->routing_number; ?>" placeholder="Routing Number">
                                                                <div id="invalid_routing_number" class="text-danger invalid-tooltip">
                                                                    Routing Number is not null.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Swift Code</label>
                                                                <input type="text" class="form-control" name="other_bank_info[<?php echo $index; ?>][swift_code]" value="<?php echo $bank->swift_code; ?>" placeholder="Swift Code">
                                                                <inbank" value="<?php echo $bank->swift_code; ?>">
                                                                    <div id="invalid_swift_code" class="text-danger invalid-tooltip">
                                                                        Swift Code is not null.
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Currency</label>
                                                                <select class="form-control" name="other_bank_info[<?php echo $index; ?>][currency]">
                                                                    <option value="">-- Select Currency --</option>
                                                                    <?php
                                                                    if ($currency) {
                                                                        foreach ($currency as $cr) {
                                                                            $selected = '';
                                                                            if ($bank->currency == $cr) {
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
                                                                <label>Note</label>
                                                                <textarea class="form-control" rows="2" name="other_bank_info[<?php echo $index; ?>][note_bank]"><?php echo $bank->note_bank; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label><?= $active_country == AMERICAN_DATABASE ? 'Void Check' : 'First page of bank account information (buku tabungan halaman pertama)' ?> <?php echo $active_country == AMERICAN_DATABASE ? '(optional)' : ''; ?></label>
                                                                <?php
                                                                $account_book = user_grantee_file_url($bank, 'account_book');
                                                                ?>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                    <a href="<?php echo site_url($account_book); ?>" class="lightbox" aria-haspopup="dialog">
                                                                        <img id="preview_image_account_book-<?php echo $index; ?>" data-old="<?php echo site_url($account_book); ?>" src="<?php echo get_preview($account_book); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="javascript:;" onclick="del_other_bank_attachment(this, 'account_book-<?php echo $index; ?>', 'Account Book')" id="button_delete_account_book-<?php echo $index; ?>" class="btn btn-danger btn-xs <?php echo empty($bank->account_book) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                                        <i class="fa fa-trash fa-fw"></i>
                                                                    </a>
                                                                    <a href="<?php echo base_url($account_book) ?>" id="button_download_account_book-<?php echo $index; ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($bank->account_book) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                </div>
                                                                <input type="file" class="custom-file-input hide" id="account_book-<?php echo $index; ?>" onchange="show_preview(this, 'account_book-<?php echo $index; ?>', 'account_book-<?php echo $index; ?>');">
                                                                <input type="hidden" name="other_bank_info[<?php echo $index; ?>][account_book]" class="account_book-<?php echo $index; ?>" value="<?php echo $bank->account_book; ?>">
                                                                <label class="btn btn-primary upload-button" for="account_book-<?php echo $index; ?>"> Choose file </label>
                                                                <a href="<?php echo site_url($account_book) ?>" id="button_preview_account_book-<?php echo $index; ?>" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                                <div>
                                                                    <small class="file-for-testing">
                                                                        File Size Max 5MB
                                                                        <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                                            | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
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
                                                    <div class="col-md-12">
                                                        <hr>
                                                    </div>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <div class="other-bank">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Bank Name</label>
                                                            <input type="text" class="form-control" name="other_bank_info[0][bank_name]" value="" placeholder="Bank Name">
                                                            <div id="invalid_bank_name" class="text-danger invalid-tooltip">
                                                                Bank Name is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Bank Address</label>
                                                            <input type="text" class="form-control" name="other_bank_info[0][bank_address]" value="" placeholder="Bank Address">
                                                            <div id="invalid_bank_address" class="text-danger invalid-tooltip">
                                                                Bank Address is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Beneficiary Name</label>
                                                            <input type="text" class="form-control" name="other_bank_info[0][beneficiary_name]" value="" placeholder="Beneficiary Name">
                                                            <div id="invalid_beneficiary_name" class="text-danger invalid-tooltip">
                                                                Beneficiary Name is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Account Number</label>
                                                            <input type="text" class="form-control" name="other_bank_info[0][account_number]" value="" placeholder="Account Number">
                                                            <div id="invalid_account_number" class="text-danger invalid-tooltip">
                                                                Account Number is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Routing Number</label>
                                                            <input type="text" class="form-control" name="other_bank_info[0][routing_number]" value="" placeholder="Routing Number">
                                                            <div id="invalid_routing_number" class="text-danger invalid-tooltip">
                                                                Routing Number is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Swift Code</label>
                                                            <input type="text" class="form-control" name="other_bank_info[0][swift_code]" value="" placeholder="Swift Code">
                                                            <input type="hidden" id="swift_code_checking_filler" value="<?php echo $this->Grantee_ent_model->swift_code ?>">
                                                            <div id="invalid_swift_code" class="text-danger invalid-tooltip">
                                                                Swift Code is not null.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Currency</label>
                                                            <select class="form-control" name="other_bank_info[0][currency]" id="currency">
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
                                                            <label>Note</label>
                                                            <textarea class="form-control" rows="2" name="other_bank_info[0][note_bank]"><?php echo $this->Grantee_ent_model->note_bank ?></textarea>
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
                                                                    <img id="preview_image_account_book-0" data-old="<?php echo site_url($account_book); ?>" src="<?php echo get_preview($account_book); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                </a>
                                                                <a href="javascript:;" onclick="del_other_bank_attachment(this, 'account_book-0', 'Account Book')" id="button_delete_account_book-0" class="btn btn-danger btn-xs hide" style="position:absolute; top:0; right:-28px;">
                                                                    <i class="fa fa-trash fa-fw"></i>
                                                                </a>
                                                                <a href="<?php echo base_url($account_book) ?>" id="button_download_account_book-0" download title="Click to download" class="btn btn-primary btn-xs mt-5 hide" style="position:absolute; top:0; right:-28px;">
                                                                    <i class="fa fa-download fa-fw"></i>
                                                                </a>
                                                            </div>
                                                            <input type="file" class="custom-file-input hide" id="account_book-0" onchange="show_preview(this, 'account_book-0', 'account_book-0');">
                                                            <input type="hidden" name="other_bank_info[0][account_book]" class="account_book-0" value="">
                                                            <label class="btn btn-primary upload-button" for="account_book-0"> Choose file </label>
                                                            <a href="<?php echo site_url($account_book) ?>" id="button_preview_account_book-0" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                            <div>
                                                                <small class="file-for-testing">
                                                                    File Size Max 5MB
                                                                    <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                                        | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
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
                                        </div>
                                        <?php if ($this->Grantee_ent_model->country_id == AMERICAN_DATABASE) { ?>
                                        <div class="col-md-12">
                                            <a class="btn btn-primary" onclick="add_other_bank()"><i class="fa fa-plus"></i> Add Another Bank</a>
                                        </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="col-lg-12">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="checkbox checbox-switch switch-primary">
                                                        <label style="margin-left: -15px;">
                                                            <input type="checkbox" name="other_bank_info[0][check_default]" checked class="check_default" />
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
                                                <input type="text" class="form-control" name="other_bank_info[0][bank_name]" value="" placeholder="Bank Name">
                                                <div id="invalid_bank_name" class="text-danger invalid-tooltip">
                                                    Bank Name is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Bank Address</label><?= $required_label ?>
                                                <input type="text" class="form-control" name="other_bank_info[0][bank_address]" value="" placeholder="Bank Address">
                                                <div id="invalid_bank_address" class="text-danger invalid-tooltip">
                                                    Bank Address is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Beneficiary Name</label><?= $required_label ?>
                                                <input type="text" class="form-control" name="other_bank_info[0][beneficiary_name]" value="" placeholder="Beneficiary Name">
                                                <div id="invalid_beneficiary_name" class="text-danger invalid-tooltip">
                                                    Beneficiary Name is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Account Number</label><?= $required_label ?>
                                                <input type="text" class="form-control" name="other_bank_info[0][account_number]" value="" placeholder="Account Number">
                                                <div id="invalid_account_number" class="text-danger invalid-tooltip">
                                                    Account Number is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Routing Number</label><?= $required_label ?>
                                                <input type="text" class="form-control" name="other_bank_info[0][routing_number]" value="" placeholder="Routing Number">
                                                <div id="invalid_routing_number" class="text-danger invalid-tooltip">
                                                    Routing Number is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Swift Code</label><?= $required_label ?>
                                                <input type="text" class="form-control" name="other_bank_info[0][swift_code]" value="" placeholder="Swift Code">
                                                <input type="hidden" id="swift_code_checking_filler" value="<?php echo $this->Grantee_ent_model->swift_code ?>">
                                                <div id="invalid_swift_code" class="text-danger invalid-tooltip">
                                                    Swift Code is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Currency</label><?= $required_label ?>
                                                <select class="form-control" name="other_bank_info[0][currency]" id="currency">
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
                                                <label>Note</label>
                                                <textarea class="form-control" rows="2" name="other_bank_info[0][note_bank]"><?php echo $this->Grantee_ent_model->note_bank ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label><?= $active_country == AMERICAN_DATABASE ? 'Void Check' : 'First page of bank account information (buku tabungan halaman pertama)' ?> <?php echo $active_country == AMERICAN_DATABASE ? '(optional)' : ''; ?></label>
                                                <?php
                                                $account_book = user_grantee_file_url($grantee, 'account_book');
                                                ?>
                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                    <a href="<?php echo site_url($account_book); ?>" class="lightbox" aria-haspopup="dialog">
                                                        <img id="preview_image_account_book-0" data-old="<?php echo site_url($account_book); ?>" src="<?php echo get_preview($account_book); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                    </a>
                                                    <a href="javascript:;" onclick="del_other_bank_attachment(this, 'account_book-0', 'Account Book')" id="button_delete_account_book-0" class="btn btn-danger btn-xs hide" style="position:absolute; top:0; right:-28px;">
                                                        <i class="fa fa-trash fa-fw"></i>
                                                    </a>
                                                    <a href="<?php echo base_url($account_book) ?>" id="button_download_account_book-0" download title="Click to download" class="btn btn-primary btn-xs mt-5 hide" style="position:absolute; top:0; right:-28px;">
                                                        <i class="fa fa-download fa-fw"></i>
                                                    </a>
                                                </div>
                                                <input type="file" class="custom-file-input hide" id="account_book-0" onchange="show_preview(this, 'account_book-0', 'account_book-0');">
                                                <input type="hidden" name="other_bank_info[0][account_book]" class="account_book-0" value="">
                                                <label class="btn btn-primary upload-button" for="account_book-0"> Choose file </label>
                                                <a href="<?php echo site_url($account_book) ?>" id="button_preview_account_book-0" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                <div>
                                                    <small class="file-for-testing">
                                                        File Size Max 5MB
                                                        <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                            | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
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
                                    <?php } ?>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>

                <div class="col-lg-12" style="margin-bottom:10px;">
                    <div style="margin-bottom:10px;">

                        <?php
                        if ($this->Grantee_ent_model->id) {
                        ?>
                            <input type="hidden" name="id" id="uid" value="<?php echo $this->Grantee_ent_model->id ?>">
                        <?php } ?>
                        <!-- <a href="<?= $this->session->userdata('active_caountry') == AMERICAN_DATABASE ? $this->session->userdata('redirect_url') : base_url('admin/users_grantee/manage') ?>" class="btn btn-primary" style="float:left;">Back</a> -->
                        <button type="submit" id="btn-submit" class="btn btn-success btn-submit" name="btn-submit" value="save_profile" style="float:right;">Save</button>
                    </div>
                </div>
            </div>
            <?php
            if ($active_country == AMERICAN_DATABASE
                && !in_array($grantee_grant->status, [STATUS_FINALIST, STATUS_NEW_GRANTEE])
            ) { ?>
            <div id="aspe" class="tab-pane fade <?= $pid == 'aspe' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label id="label-aspe">Accident and Sickness Program for Exchange</label>
                                    <?php
                                    $aspe_file = user_grantee_file_url($user_grantee, 'aspe');
                                    ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php echo site_url($aspe_file); ?>" class="lightbox" aria-haspopup="dialog">
                                            <img id="preview_image_aspe" data-old="<?php echo site_url($aspe_file); ?>" src="<?php echo get_preview($aspe_file); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                        </a>
                                        <?php //if ($is_admin && disable_if_filled($user_grantee->aspe) != 'disabled') { ?>
                                            <a href="javascript:;" onclick="del_file(this, 'aspe', 'aspe')" id="button_delete_aspe" class="btn btn-danger btn-xs <?php echo empty($this->Grantee_ent_model->aspe) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                        <?php //} ?>
                                        <a href="<?php echo base_url($aspe_file) ?>" id="button_download_aspe" download title="Click to download" class="btn btn-primary btn-xs <?php echo disable_if_filled($user_grantee->aspe) != 'disabled' ? 'mt-5' : ''; ?> <?php echo empty($this->Grantee_ent_model->aspe) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                    <input type="file" class="custom-file-input hide" accept="<?php foreach (ALLOWED_PROFILE_FILETYPE as $filetype) {
                                                                                                            echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ",";
                                                                                                        } ?>" id="aspe_file" onchange="show_preview(this, 'aspe', 'aspe');">
                                    <input type="hidden" name="aspe" value="<?php echo $this->Grantee_ent_model->aspe; ?>">
                                    <?php //if ($is_admin && disable_if_filled($user_grantee->aspe) != 'disabled') { ?>
                                        <label class="btn btn-primary upload-button" for="aspe_file"> Choose file </label>
                                    <?php //} ?>
                                    <?php //if ($is_admin) { ?>
                                        <a href="<?php echo site_url($aspe_file) ?>" id="button_preview_aspe" class="btn btn-warning fileview lightbox preview-profile <?php echo empty($this->Grantee_ent_model->aspe) ? 'hide' : ''; ?>" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                        <div>
                                            <small class="file-for-testing">
                                                File Size Max 5MB
                                                <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                                                    | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?>
                                                <?php } ?>
                                            </small>
                                            <div id="invalid_aspe" class="text-danger invalid-tooltip">
                                                Max File Size 5Mb.
                                            </div>
                                            <div id="invalid_aspe_required" class="text-danger invalid-tooltip">
                                                Please Choose File.
                                            </div>
                                        </div>
                                    <?php //} else { ?>
                                        <!-- grantee: hide preview/upload controls, only show nothing or could show a placeholder -->
                                    <?php //} ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php //if ($is_admin) { ?>
                        <button type="submit" id="btn-submit-aspe" class="btn btn-success btn-submit pull-right" name="btn-submit" value="aspe">Save</button>
                    <?php //} ?>
                </div>
            </div>
            <?php } ?>
    
            <div id="contact" class="tab-pane fade <?= $pid == 'contact' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> ADDRESS ON ID<br />
                                <!-- <small>Permanent Address (DO NOT TRANSLATE the address into English)</small> </p> -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country<?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                    <select id="address_country" class="form-control select2 select-country" name="country" style="width:100%">
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
                                    <div id="invalid_address_country" class="text-danger invalid-tooltip">
                                        Country is not null.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Street<?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                    <input type="text" class="form-control" id="street" name="street" value="<?php echo $this->Grantee_ent_model->street ?>" placeholder="Street">
                                    <div id="invalid_street" class="text-danger invalid-tooltip">
                                        Street is not null.
                                    </div>
                                </div>

                                <?php if (isset($user_grantee_grant) && isset($user_grantee_grant->show_nearest_int_airport) && $user_grantee_grant->show_nearest_int_airport == 1) { ?>
                                <div class="form-group">
                                    <label>Nearest International Airport<?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                    <input type="text" class="form-control" id="nearest_international_airport" name="nearest_international_airport" value="<?php echo isset($this->Grantee_ent_model->nearest_international_airport) ? $this->Grantee_ent_model->nearest_international_airport : '' ?>" placeholder="Nearest International Airport">
                                    <div id="invalid_nearest_international_airport" class="text-danger invalid-tooltip">
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>State/Province<?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
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
                                    <img id="load-home_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                    <div id="invalid_address_state" class="text-danger invalid-tooltip">
                                        State/Province is not null.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Postal Code<?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                    <input type="text" class="form-control input_number" name="zipcode" id="zipcode" value="<?php echo $this->Grantee_ent_model->zipcode ?>" placeholder="Postal Code">
                                    <div id="invalid_zipcode" class="text-danger invalid-tooltip">
                                        Postal Code is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>City<?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
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
                                    <img id="load-home_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                    <div id="invalid_address_city" class="text-danger invalid-tooltip">
                                        City is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>
                                        <input name="current_residence" id="current-residence" type="checkbox" <?php echo $checkbox_current_residence ? 'checked' : ''; ?> />
                                        <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? ' This is my current address.' :
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
                                    <label>Country <?php echo $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
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
                                    <div id="invalid_residence_country" class="text-danger invalid-tooltip">
                                        Country is not null.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Street <?php echo $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                    <input type="text" class="form-control" id="residence_street" name="residence_street" value="<?php echo $this->Grantee_ent_model->residence_street ?>" placeholder="Street" data-old="<?php echo $this->Grantee_ent_model->residence_street; ?>">
                                    <div id="invalid_residence_street" class="text-danger invalid-tooltip">
                                        Street is not null.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>State/Province <?php echo $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
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
                                    <div id="invalid_residence_state" class="text-danger invalid-tooltip">
                                        State/Province is not null.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Postal Code <?php echo $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                    <input type="text" class="form-control input_number" name="residence_zipcode" id="residence_zipcode" value="<?php echo $this->Grantee_ent_model->residence_zipcode ?>" placeholder="Postal Code" data-old="<?php echo $this->Grantee_ent_model->residence_zipcode; ?>">
                                    <div id="invalid_residence_zipcode" class="text-danger invalid-tooltip">
                                        Postal Code is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>City <?php echo $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
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
                                    <div id="invalid_residence_city" class="text-danger invalid-tooltip">
                                        City is not null.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($this->session->userdata('grantee_active_country') == INDONESIAN_DATABASE  && $show_us_address) { ?>
                            <div id="us-address-section" class="panel-body mt-3">
                                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> US ADDRESS<br />
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select id="us_country" class="form-control select2 us-address-country" name="us_country" style="width:100%">
                                                <option value="">-- Select Country --</option>
                                                <?php
                                                if ($country_list) {
                                                    foreach ($country_list as $cl) {
                                                        $selected = '';
                                                        if ($grantee_grant->us_country == $cl->id) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                ?>
                                                        <option value="<?php echo $cl->id ?>" data-pcode="<?php echo $cl->phone_code ?>" <?php echo $selected ?>><?php echo $cl->name ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div id="invalid_us_country" class="text-danger invalid-tooltip">
                                                Country is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group pos-rel">
                                            <label>State/Province</label>
                                            <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_state" style="display:none;">
                                            <select id="us_state" class="form-control select2 us-address-state" name="us_state" style="width:100%" data-old="<?php echo $grantee_grant->us_state; ?>">
                                                <option value="">-- Select State/Province --</option>
                                                <?php
                                                if ($us_states) {
                                                    foreach ($us_states as $st) {
                                                        $selected = '';
                                                        if ($grantee_grant->us_state == $st->id) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                ?>
                                                        <option value="<?php echo $st->id ?>" <?php echo $selected ?>><?php echo $st->name ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <img id="load-us_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                            <div id="invalid_us_state" class="text-danger invalid-tooltip">
                                                State/Province is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group pos-rel">
                                            <label>City</label>
                                            <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_city" style="display:none;">
                                            <select id="us_city" class="form-control select2 us-address-city" name="us_city" style="width:100%" data-old="<?php echo $grantee_grant->us_city; ?>">
                                                <option value="">-- Select City --</option>
                                                <?php
                                                if ($us_cities) {
                                                    foreach ($us_cities as $ct) {
                                                        $selected = '';
                                                        if ($grantee_grant->us_city == $ct->id) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                ?>
                                                        <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <img id="load-us_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                            <div id="invalid_us_city" class="text-danger invalid-tooltip">
                                                City is not null.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Street</label>
                                            <input type="text" class="form-control" id="us_street" name="us_street" value="<?php echo $grantee_grant->us_street ?>" placeholder="Street" data-old="<?php echo $grantee_grant->us_street; ?>">
                                            <div id="invalid_us_street" class="text-danger invalid-tooltip">
                                                Street is not null.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Postal Code</label>
                                            <input type="text" class="form-control input_number" name="us_zipcode" id="us_zipcode" value="<?php echo $grantee_grant->us_zipcode ?>" placeholder="Postal Code" data-old="<?php echo $grantee_grant->us_zipcode; ?>">
                                            <div id="invalid_us_zipcode" class="text-danger invalid-tooltip">
                                                Postal Code is not null.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>

                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> TELEPHONE NUMBERS<br />
                                <small>Please be sure to include the local code along with your number</small>
                            </p>
                            <div class="row">
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
                                                        <label>Cell Phone Number <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                        <input type="twxt" class="form-control input_number" name="phone_number[]" id="phone_number_<?= $key ?>" value="<?= $row ?>">
                                                        <div id="invalid_phone_number_<?= $key ?>" class="text-danger invalid-tooltip">
                                                            Phone Number is not null.
                                                        </div>
                                                    </div>
                                                    <?php echo $del_btn ?>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div id="opdt-item-0" class="opdt-item">
                                                <div class="form-group">
                                                    <label>Cell Phone Number <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <input type="text" class="form-control input_number" id="phone_number_0" name="phone_number[]" value="">
                                                    <div id="invalid_phone_number_0" class="text-danger invalid-tooltip">
                                                        Phone Number is not null.
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <a href="javascript:;" onclick="add_mobile_number()" class="btn btn-primary" style="margin-top:24px;">
                                            <i class="fa fa-plus fa-fw"></i> Add Number
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Home Phone Number <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                        <input type="text" id="home_phone_number" class="form-control input_number" name="home_phone_number" value="<?php echo $this->Grantee_ent_model->home_phone_number ?>" placeholder="Home Phone Number">
                                        <div id="invalid_home_phone_number" class="text-danger invalid-tooltip">
                                            Home Phone Number is not null.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Work Phone Number</label>
                                        <input type="text" class="form-control input_number" name="work_phone_number" value="<?php echo $this->Grantee_ent_model->work_phone_number ?>" placeholder="Work Phone Number">
                                    </div>
                                </div>
                                <?php if ($this->session->userdata('grantee_active_country') == INDONESIAN_DATABASE  && $show_us_address) { ?>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>US Phone Number</label>
                                            <input type="text" class="form-control input_number" name="us_phone_number" id="us_phone_number" value="<?php echo $grantee_grant->us_phone_number ?>" placeholder="US Phone Number">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <?php if (!$is_grantee_page) { ?>
                            <div class="panel-body mt-3">
                                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> E-MAIL<br />
                                    <small>Please provide a primary and secondary e-mail address (e.g. professional, university, etc.) in case we have difficulties contacting you at the primary e-mail address. Please note that all system-generated messages will be sent to the primary e-mail address.</small>
                                </p>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Primary <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                        <input type="email" id="primary_email" class="form-control" name="primary_email" value="<?php echo $this->Grantee_ent_model->primary_email ?>" <?php echo disable_if_filled($this->Grantee_ent_model->primary_email); ?>>
                                        <div id="invalid_primary_email" class="text-danger invalid-tooltip">
                                            Primary Email is not null.
                                        </div>
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
                                        <label>Primary <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                        <input type="email" id="primary_email" class="form-control" name="primary_email" value="<?php echo $this->Grantee_ent_model->primary_email ?>" <?php echo disable_if_filled($this->Grantee_ent_model->primary_email); ?>>
                                        <div id="invalid_primary_email" class="text-danger invalid-tooltip">
                                            Primary Email is not null.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="margin-top:-20px;">
                                <p class="ml-4" style="color:red">Do not fill in if you do not want to change the password</p>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="new-password">
                                        <i class="fa fa-eye password-show"></i>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" autocomplete="new-password">
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
                                <?php if ($this->session->userdata('grantee_active_country') == INDONESIAN_DATABASE && $show_us_address) { ?>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>University Email</label>
                                            <input type="email" class="form-control" name="university_email" id="university_email" value="<?php echo $grantee_grant->university_email ?>" placeholder="University Email">
                                        </div>
                                    </div>
                                <?php } ?>
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
                                                    <label>First/Given Name <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <input type="text" id="firs_name_temp<?= $key ?>" class="form-control" name="info[emergency][<?= $key ?>][firs_name_temp]" placeholder="First/Given Name" value="<?= $row->first_name ?>">
                                                    <div id="invalid_firs_name_temp<?= $key ?>" class="text-danger invalid-tooltip">
                                                        First/Given Name is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Middle Name</label>
                                                    <input type="text" class="form-control" id="middle_name_temp<?= $key ?>" name="info[emergency][<?= $key ?>][middle_name_temp]" placeholder="Middle Name" value="<?= $row->middle_name ?>">
                                                    <div id="invalid_middle_name_temp<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Middle Name is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Last/Family Name <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <input type="text" id="last_name_temp<?= $key ?>" class="form-control" name="info[emergency][<?= $key ?>][last_name_temp]" placeholder="Last/Family Name" value="<?= $row->last_name ?>">
                                                    <div id="invalid_last_name_temp<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Last/Family Name is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Country <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <select id="<?= $key ?>temp_country" class="form-control select2 select-country" name="info[emergency][<?= $key ?>][country_temp]" style="width:100%">
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
                                                    <div id="invalid_temp_country<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Country is not null.
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Street <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <input type="text" id="street_temp<?= $key ?>" class="form-control" name="info[emergency][<?= $key ?>][street_temp]" value="<?php echo $row->street ?>" placeholder="Street">
                                                    <div id="invalid_street_temp<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Street is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group pos-rel">
                                                    <label>State/Province <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <select id="<?= $key ?>temp_state" class="form-control select2 select-state" name="info[emergency][<?= $key ?>][provinci_temp]" style="width:100%">
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
                                                    <div id="invalid_temp_state<?= $key ?>" class="text-danger invalid-tooltip">
                                                        State/Province is not null.
                                                    </div>
                                                    <img id="load-home_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                                </div>
                                                <div class="form-group">
                                                    <label>Postal Code <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <input type="text" id="zipcode_tmep<?= $key ?>" class="form-control input_number" name="info[emergency][<?= $key ?>][zipcode_temp]" value="<?php echo $row->zipcode ?>" placeholder="Postal Code">
                                                    <div id="invalid_zipcode_tmep<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Postal Code is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group pos-rel">
                                                    <label>City <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <select id="<?= $key ?>temp_city" class="form-control select2" name="info[emergency][<?= $key ?>][city_temp]" style="width:100%">
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
                                                    <div id="invalid_temp_city<?= $key ?>" class="text-danger invalid-tooltip">
                                                        City is not null.
                                                    </div>
                                                    <img id="load-home_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Phone Number <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <input type="text" id="phone_temp<?= $key ?>" class="form-control" name="info[emergency][<?= $key ?>][phone_temp]" placeholder="Phone Number" value="<?= $row->phone_number ?>">
                                                    <div id="invalid_phone_temp<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Phone Number is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Email <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <input type="text" id="email_temp<?= $key ?>" class="form-control" name="info[emergency][<?= $key ?>][email_temp]" placeholder="Email" value="<?= $row->email ?>">
                                                    <div id="invalid_email_temp<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Email is not null.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Relationship to You <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                    <input type="text" id="relation<?= $key ?>" class="form-control" name="info[emergency][<?= $key ?>][relation]" placeholder="Relationship to You" value="<?= $row->relation ?>">
                                                    <div id="invalid_relation<?= $key ?>" class="text-danger invalid-tooltip">
                                                        Relationship to You is not null.
                                                    </div>
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
                                                <label>First/Given Name <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <input type="text" id="firs_name_temp0" class="form-control" name="info[emergency][0][firs_name_temp]" placeholder="First/Given Name">
                                                <div id="invalid_firs_name_temp0" class="text-danger invalid-tooltip">
                                                    First/Given Name is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input type="text" id="middle_name_temp0" class="form-control" name="info[emergency][0][middle_name_temp]" placeholder="Middle Name">
                                                <div id="invalid_middle_name_temp0" class="text-danger invalid-tooltip">
                                                    Middle Name is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Last/Family Name <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <input type="text" id="last_name_temp0" class="form-control" name="info[emergency][0][last_name_temp]" placeholder="Last/Family Name">
                                                <div id="invalid_last_name_temp0" class="text-danger invalid-tooltip">
                                                    Last/Family Name is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Country <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <select id="0temp_country" class="form-control select2 select-country-emergency" name="info[emergency][0][country_temp]" style="width:100%">
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
                                                <div id="invalid_temp_country0" class="text-danger invalid-tooltip">
                                                    Country is not null.
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Street <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <input type="text" id="street_temp0" class="form-control" name="info[emergency][0][street_temp]" value="<?php echo $this->Grantee_ent_model->street_temp ?>" placeholder="Street">
                                                <div id="invalid_street_temp<?= $key ?>" class="text-danger invalid-tooltip">
                                                    Street is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group pos-rel">
                                                <label>State/Province <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <select id="0temp_state" class="form-control select2 select-state-emergency" name="info[emergency][0][provinci_temp]" style="width:100%">
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
                                                <div id="invalid_temp_state0" class="text-danger invalid-tooltip">
                                                    State/Province is not null.
                                                </div>
                                                <img id="load-home_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                            </div>
                                            <div class="form-group">
                                                <label>Postal Code <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <input type="text" id="zipcode_tmep0" class="form-control" name="info[emergency][0][zipcode_temp]" value="<?php echo $this->Grantee_ent_model->zipcode_tmep ?>" placeholder="Postal Code">
                                                <div id="invalid_zipcode_tmep0" class="text-danger invalid-tooltip">
                                                    Postal Code is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group pos-rel">
                                                <label>City <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <select id="0temp_city" class="form-control select2" name="info[emergency][0][city_temp]" style="width:100%">
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
                                                <div id="invalid_temp_city0" class="text-danger invalid-tooltip">
                                                    City is not null.
                                                </div>
                                                <img id="load-home_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Phone Number <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <input type="text" id="phone_temp0" class="form-control input_number" name="info[emergency][0][phone_temp]" placeholder="Phone Number">
                                                <div id="invalid_phone_temp0" class="text-danger invalid-tooltip">
                                                    Phone Number is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Email <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <input type="text" id="email_temp0" class="form-control" name="info[emergency][0][email_temp]" placeholder="Email">
                                                <div id="invalid_email_temp0" class="text-danger invalid-tooltip">
                                                    Email is not null.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Relationship to You <?= $this->session->userdata('grantee_active_country') == AMERICAN_DATABASE || (isset($grantee_grant) && $grantee_grant->country_id == AMERICAN_DATABASE) ? $required_label : '' ?></label>
                                                <input type="text" id="relation0" class="form-control" name="info[emergency][0][relation]" placeholder="Relationship to You">
                                                <div id="invalid_relation0" class="text-danger invalid-tooltip">
                                                    Relationship to You is not null.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="panel-body" style="margin-top:-20px">
                            <div class="col-lg-12">
                                <a href="javascript:;" onclick="add_label()" class="btn btn-primary">
                                    <i class="fa fa-plus fa-fw"></i> Add More Emergency Contact Information
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
                            <a href="<?= $this->session->userdata('redirect_url') ?>" class="btn btn-primary" style="float:left;">Back</a>
                        <?php } ?>
                        <button type="submit" id="btn-submit-contact" class="btn btn-success btn-submit" name="btn-submit" value="save_profile_contact" style="float:right;">Save</button>
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
                                            <th width="50%">Grants</th>
                                            <th>Status</th>
                                            <?php if ($is_admin) { ?>
                                                <th>Note</th>
                                                <th class="text-right">Attachment</th>
                                            <?php } ?>
                                            <?php if ($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <th class="text-center">Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status_reject = [
                                            STATUS_NEW_SELECTION_DECLINED,
                                            STATUS_NEW_SELECTION_WITHDRAW,
                                            STATUS_REVIEW_REJECT,
                                            STATUS_INTERVIEW_REJECT,
                                            STATUS_APPLICATION_WITHDRAW
                                        ];

                                        foreach ($history as $key => $value) {
                                            $info    = getStatusInfo($value['status']);
                                            $note    = $info['note'] ?? 'note_candidate';
                                            $section = $info['section'];
                                        ?>
                                            <tr>
                                                <td><?= $value['fiscal_year'] ?></td>
                                                <td><?= $value['grant_name'] ?></td>
                                                <td><?= get_status_name($value['status_name'], $is_admin) ?></td>
                                                <?php if ($is_admin) { ?>
                                                    <td><?php if (!in_array($value['status'], $status_reject)) { ?><?= $value[$note] ?> <?php } ?></td>
                                                    <td class="text-right">
                                                        <?php if (!in_array($value['status'], $status_reject)) { ?>
                                                            <?php if (!empty($value['attachment_withdraw'])) {
                                                                render_attachments($value['attachment_withdraw']);
                                                            } ?>

                                                            <?php if (!empty($value['attachment_candidate'])) {
                                                                render_attachments($value['attachment_candidate']);
                                                            } ?>
                                                        <?php } ?>
                                                    </td>
                                                <?php } ?>
                                                <?php if ($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('admin/payment_record/payment/' . $section . '/' . $value['id']) ?>" class="btn btn-xs btn-info"><span class="fa fa-money fa-fw"></span> Payment</a>

                                                        <?php if (!in_array($value['status'], $status_reject) && $is_admin) { ?>
                                                            <a href="#" data-id="<?= $value['id'] ?>" data-section="candidate" data-type="<?= !empty($value['attachment_withdraw']) ? 'withdraw' : 'drop' ?>" class="btn btn-xs btn-primary btn-edit-note">Edit Note</a>
                                                        <?php } ?>
                                                    </td>
                                                <?php } ?>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="report" class="tab-pane fade <?= $pid == 'report' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="min-height:300px;">
                        <input type="hidden" value="<?= $grantee_grant->grant_id ?>" id="grant_id">
                        <input type="hidden" value="<?= $grantee_grant->fiscal_year ?>" id="fiscal_year">
                        <?php
                        if (isset($category_report) && $category_report) {
                            foreach ($category_report as $key => $categoryR) {
                                $dateNow = date('Y/m/d');
                                $report_date = isset($categoryR->report_date) && $categoryR->report_date ? date('Y/m/d', strtotime($categoryR->report_date)) : '';

                        ?>
                                <div class="panel panel-default" <?= $report_date > $dateNow ? 'style="display:none"' : '' ?>>
                                    <div class="panel-heading text-left" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $categoryR->id ?>" aria-expanded="true" aria-controls="collapse<?= $categoryR->id ?>">
                                                <?php
                                                if ($categoryR->status == 'submited') {
                                                    $status = 'Submited';
                                                } elseif ($categoryR->status == 'accept') {
                                                    $status = '<i class="fa fa-check-circle"></i> Accept';
                                                } elseif ($categoryR->status == 'revisi') {
                                                    $status = 'Revisi';
                                                } else {
                                                    $status = '';
                                                }
                                                ?>
                                                <?= $categoryR->name ?> <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span> <span style="float:right"><?= $status ?></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse<?= $categoryR->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <?php if (!empty($categoryR->report_date)) { ?>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <?php if ($categoryR->report_file != '') { ?>
                                                                <label>Upload Report</label>
                                                                <br>
                                                                <img
                                                                    height="100"
                                                                    src="<?php echo get_preview($categoryR->report_file); ?>">
                                                                <a href="<?= base_url($categoryR->report_file) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute;">
                                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                                </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <a href="<?= base_url('admin/grantee/download_report/' . $grantee_grant->id . '/' . $categoryR->id) ?>" target="_blank" class="btn btn-info" style="float:right">Download PDF</a>
                                                </div>
                                                <h3 class="text-center"><?= $programs[$user_programs[0]->grant_id]->name ?></h3>
                                                <div style="font-weight:bold;"><?= $categoryR->information ?></div>
                                                <div class="mt-5">
                                                    <?php
                                                    $no = 1;
                                                    $file = 1;
                                                    foreach ($categoryR->custom_field_report as $key => $cf) {
                                                    ?>
                                                        <!-- template for others instead file template -->
                                                        <?php if ($cf->type != 'file') : ?>
                                                            <div class="row form-group">
                                                                <?php if ($cf->type == 'separator') : ?>
                                                                    <div class="col-md-5 text-left"><b><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?></b></div>
                                                                <?php else : ?>
                                                                    <div class="col-md-1 text-left" style="font-weight:bold"><?= $no ?>.</div>
                                                                    <div class="col-md-4 text-left"><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?><?= label_required($cf->is_required); ?></div>
                                                                    <?php $no++; ?>
                                                                <?php endif; ?>
                                                                <div class="col-md-7">
                                                                    <?= get_component($cf, 'disabled', $cf->value_custom_fields); ?>
                                                                </div>
                                                            </div>
                                                        <?php else : ?>
                                                            <?php
                                                            if ($file == 3 || $categoryR->custom_field_report[$key + 1]->type == 'file') {
                                                                $file = 0;
                                                                $row = "";
                                                                $exitrow = "";
                                                            } else {
                                                                $row = "<div class='row form-group'>";
                                                                $exitrow = "</div>";
                                                            }
                                                            ?>

                                                            <?= $row; ?>
                                                            <div class="col-lg-4">
                                                                <label style="min-height: 75px;"><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?></label>
                                                                <p id="file_name1" style="font-size:16px">No file chosen</p>
                                                                <input type="file" id="my_file1" style="display: none;">
                                                                <small class="file-for-testing">File Size Max 5MB</small>
                                                                <a class="btn btn-success">save</a>
                                                                <hr>
                                                            </div>
                                                            <?= $exitrow; ?>
                                                        <?php $file++;
                                                        endif; ?>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-lg-12 mb-3">
                                                    <div class="form-group">
                                                        <label>Note</label>
                                                        <textarea class="form-control" rows="4" id="note<?= $categoryR->report_id ?>"><?= $categoryR->note ?></textarea>
                                                    </div>
                                                </div>
                                                <?php if ($categoryR->status == 'submited' ||  $categoryR->status == 'revisi') { ?>
                                                    <div class="col-lg-12 mb-3">
                                                        <button type="button" onclick="accept_report(<?= $categoryR->report_id ?>, <?= $this->Grantee_ent_model->id ?>)" class="btn btn-success" style="float:right;">Accept</button>
                                                        <button type="button" onclick="revisi_report(<?= $categoryR->report_id ?>, <?= $this->Grantee_ent_model->id ?>)" class="btn btn-warning" style="float:right;margin-right: 10px;">Revised</button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } else { ?>
                                            <div style="padding:10px;">
                                                <p><?= $categoryR->name ?> is not available now</p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div id="leave_application" class="tab-pane fade <?= $pid == 'leave' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <table width="100%" class="text-left">
                                    <tbody>
                                        <?php
                                        $personal_travel = 0;
                                        if (isset($personal_travel_day) && is_array($personal_travel_day)) {
                                            $personal_travel = array_sum($personal_travel_day);
                                        }

                                        $personal_travel_grant = $grantee_grant->personal_travel;

                                        $personal_travel_program = $programs[$grant_id]->personal_travel;

                                        $remaining_personal_travel = 0;
                                        if ((int) $personal_travel_grant > 0) {
                                            $remaining_personal_travel = $personal_travel_grant - $personal_travel;
                                        } else {
                                            $remaining_personal_travel = $personal_travel_program - $personal_travel;
                                        }
                                        ?>
                                        <tr style="<?php echo $remaining_personal_travel <= 0 ? 'color:orangered;' : ''; ?>">
                                            <td width="30%">Personal Travel</td>
                                            <td width="2%">:</td>
                                            <td><?= $remaining_personal_travel; ?> days</td>
                                            <td><a href="javascript:;" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#mdl_leave">Edit Leave</a></td>
                                        </tr>

                                        <?php if ($programs[$grant_id]->category_grant == TEACHING) { ?>

                                            <?php
                                            $emergency_leave = 0;
                                            if (isset($emergency_leave_day) && is_array($emergency_leave_day)) {
                                                $emergency_leave = array_sum($emergency_leave_day);
                                            }

                                            $emergency_leave_grant = $grantee_grant->emergency_leave;

                                            $emergency_leave_program = $programs[$grant_id]->emergency_leave;

                                            $remaining_emergency_leave = 0;
                                            if ((int) $emergency_leave_grant > 0) {
                                                $remaining_emergency_leave = $emergency_leave_grant - $emergency_leave;
                                            } else {
                                                $remaining_emergency_leave = $emergency_leave_program - $emergency_leave;
                                            }
                                            ?>
                                            <tr style="<?php echo $remaining_emergency_leave <= 0 ? 'color:orangered;' : ''; ?>">
                                                <td width="30%">Emergency Leave</td>
                                                <td>:</td>
                                                <td><?= $remaining_emergency_leave; ?> days</td>
                                            </tr>
                                        <?php } ?>

                                        <?php if ($programs[$grant_id]->category_grant == RESEARCH) { ?>
                                            <?php
                                            $research_leave = 0;
                                            if (isset($research_leave_day) && is_array($research_leave_day)) {
                                                $research_leave = array_sum($research_leave_day);
                                            }
                                            $research_leave_grant = $grantee_grant->research_leave;

                                            $research_leave_program = $programs[$grant_id]->research_leave;

                                            $remaining_research_leave = 0;
                                            if ((int) $research_leave_grant > 0) {
                                                $remaining_research_leave = $research_leave_grant - $research_leave;
                                            } else {
                                                $remaining_research_leave = $research_leave_program - $research_leave;
                                            }
                                            ?>
                                            <tr style="<?php echo $remaining_research_leave <= 0 ? 'color:orangered;' : ''; ?>">
                                                <td>International Research Travel</td>
                                                <td>:</td>
                                                <td><?= $remaining_research_leave; ?> days</td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (in_array($programs[$grant_id]->category_grant, [ETA, TEACHING, RESEARCH])) { ?>
                                            <?php if ($programs[$grant_id]->category_grant != RESEARCH) { ?>
                                                    <?php
                                                    $sick_leave = 0;
                                                    if (isset($sick_leave_day) && is_array($sick_leave_day)) {
                                                        $sick_leave = array_sum($sick_leave_day);
                                                    }
                                                    $sick_leave_grant = $grantee_grant->sick_leave;

                                                    $sick_leave_program = $programs[$grant_id]->sick_leave;

                                                    $remaining_sick_leave = 0;
                                                    if ((int) $sick_leave_grant > 0) {
                                                        $remaining_sick_leave = $sick_leave_grant - $sick_leave;
                                                    } else {
                                                        $remaining_sick_leave = $sick_leave_program - $sick_leave;
                                                    }
                                                    ?>
                                                    <tr style="<?php echo $remaining_sick_leave <= 0 ? 'color:orangered;' : ''; ?>">
                                                    <td>Sick Leave</td>
                                                    <td>:</td>
                                                    <td><?= $remaining_sick_leave; ?> days</td>
                                                    </tr>
                                                <?php } ?>
                                                <?php
                                                $emergency_leave = 0;
                                                if (isset($emergency_leave_day) && is_array($emergency_leave_day)) {
                                                    $emergency_leave = array_sum($emergency_leave_day);
                                                }

                                                $emergency_leave_grant = $grantee_grant->emergency_leave;

                                                $emergency_leave_program = $programs[$grant_id]->emergency_leave;

                                                $remaining_emergency_leave = 0;
                                                if ((int) $emergency_leave_grant > 0) {
                                                    $remaining_emergency_leave = $emergency_leave_grant - $emergency_leave;
                                                } else {
                                                    $remaining_emergency_leave = $emergency_leave_program - $emergency_leave;
                                                }
                                                ?>
                                                <tr style="<?php echo $remaining_emergency_leave <= 0 ? 'color:orangered;' : ''; ?>">
                                                    <td width="30%">Emergency Leave</td>
                                                    <td>:</td>
                                                    <td><?= $remaining_emergency_leave; ?> days</td>
                                                </tr>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12 mb-2 p-0 text-right">
                                <a class="btn btn-primary" href="<?php echo site_url('admin/grantee/add_new_leave/' . $grantee_grant->user_grantee_id . '/' . $grantee_grant->grant_id . '/' . $grantee_grant->id); ?>">Add New Leave</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Leave Category</th>
                                            <th>Leave (day)</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Create Date</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (isset($leave_applications)) {
                                            foreach ($leave_applications as $row) {
                                                $now = strtotime($row->end_date);
                                                $your_date = strtotime($row->start_date);
                                                $datediff = $now - $your_date;
                                                $leave_day = total_day_leave($row->start_date, $row->end_date);
                                        ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= get_label_leave_category($row->leave_category) ?></td>
                                                    <td><?= $row->total_request ?> Day</td>
                                                    <td><?= date('d M Y', strtotime($row->start_date)) ?></td>
                                                    <td><?= date('d M Y', strtotime($row->end_date)) ?></td>
                                                    <td><?= date('d M Y H:i:s', strtotime($row->date_insert)) ?></td>
                                                    <td><?= get_label_status_leave($row->status) ?></td>
                                                    <td><a href="javascript:;" data-toggle="modal" data-target="#mdl_detail_leave" data-leave-id="<?= $row->id ?>" class="btn btn-primary btn-xs">Detail</a></td>
                                                </tr>
                                        <?php
                                                $no++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($is_admin) { ?>
                <?php
                foreach ($user_programs as $up) {
                    $info    = getStatusInfo($up->status);
                    $note    = $info['note'];
                    $section = $info['section'];
                    $text_color = "";

                    if ($up->status == STATUS_NEED_VERIFICATION) {
                        $text_color = "text-primary";
                    } elseif ($up->status == CURRENT_GRANTEE) {
                        $text_color = "text-success";
                    } elseif ($up->status == STATUS_REVISE) {
                        $text_color = "text-warning";
                    }
                ?>

                    <div id="user-program-<?= $up->id ?>" class="tab-pane fade <?= $pid == $up->grant_id ? 'active in' : '' ?>">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <h1 class="page-header"><?= $up->name ?></h1>
                                            <h3 class="<?= $text_color ?>"><?php echo $up->status_name ?></h3>
                                            <?php //if($up->status == STATUS_SELECTION_DECLINED || $up->status == STATUS_CANDIDATE_DECLINED || $up->status == STATUS_ON_GOING_DECLINED || $up->status == STATUS_NEW_SELECTION_DECLINED) { 
                                            ?>
                                            <!-- <h4 class="text-left">Note Rejected: </h4>
                                        <div class="alert alert-danger" role="alert" style="height:auto">
                                            <?php
                                            if ($up->status == STATUS_SELECTION_DECLINED || $up->status == STATUS_NEW_SELECTION_DECLINED) {
                                                $note_reject = $up->note_selection;
                                            } else if ($up->status == STATUS_CANDIDATE_DECLINED) {
                                                $note_reject = $up->note_candidate;
                                            } else if ($up->status == STATUS_ON_GOING_DECLINED) {
                                                $note_reject = $up->note_ongoing;
                                            }

                                            ?>
                                            <h4 class="alert-heading text-justify"><?= $note_reject ?></h4>
                                        </div> -->
                                            <?php //} 
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <ul class="nav nav-pills">
                                            <?php $first = true;
                                            foreach ($grants_step[$up->id] as $index => $category) : ?>
                                                <li <?php echo $first ? $default_tab_active : '' ?>><a data-toggle="tab" href="#<?= $category->id ?>" aria-expanded="true"><?= $category->name ?></a></li>
                                            <?php $first = false;
                                            endforeach; ?>
                                            <ul>
                                    </div>
                                    <div class="tab-content">
                                        <?php $firstTab = true;
                                        foreach ($grants_step[$up->id] as $index => $category) : ?>
                                            <div id="<?= $category->id ?>" class="tab-pane fade <?= $firstTab ? 'active in' : '' ?>">
                                                <?php if ($category->name != 'Selection') { ?>
                                                    <div class="panel-body">
                                                        <div class="pull-right text-right">
                                                            <?php if ($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                                <a href="<?= base_url('admin/payment_record/payment/' . $section . '/' . $up->id) ?>" class="btn btn-info mr-2"><span class="fa fa-money fa-fw"></span> Payment</a>
                                                            <?php } ?>
                                                            <?php if ($this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
                                                                <?php $procedure = str_replace(' ', '_', strtolower($up->status_name)); ?>
                                                                <a target="_blank" href="<?= base_url() . 'admin/' . $procedure . '/submission/' . $up->id . '/' . $category->id ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Submission <?= $category->name ?></a>
                                                            <?php } else { ?>
                                                                <a target="_blank" href="<?= base_url() . 'admin/application/verify/' . $grantee_grant->id ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Submission <?= $category->name ?></a>
                                                                <!-- <a target="_blank" href="<?= base_url() . 'admin/grantee/edit_submission/' . $up->id . '/' . $category->id ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Submission <?= $category->name ?></a> -->
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="tabs">
                                                            <ul>
                                                                <?php foreach ($category->step as $isep => $step): ?>
                                                                    <li>
                                                                        <a aria-expanded="true" data-toggle="tab" href="#<?= str_replace(' ', '_', $category->name) ?>_step_<?= $step->id; ?>"><?= $step->label ?></a>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                            <div class="row">
                                                                <div class="col col-lg-12">
                                                                    <?php if ($category->step) { ?>
                                                                        <div class="tab-content">
                                                                            <?php foreach ($category->step as $index => $step):
                                                                                $index_of_country = $this->session->userdata('index_of_country') ? ($this->session->userdata('index_of_country')) + 1 : 1;
                                                                                $this->session->set_userdata('index_of_country', $index_of_country);
                                                                                $index_of_state_of_study = $this->session->userdata('index_of_state_of_study') ? ($this->session->userdata('index_of_state_of_study')) + 1 : 1;
                                                                                $this->session->set_userdata('index_of_state_of_study', $index_of_state_of_study);
                                                                            ?>
                                                                                <div id="<?= str_replace(' ', '_', $category->name) ?>_step_<?= $step->id; ?>" class="tab-pane fade <?php if ($index == 0) {
                                                                                                                                            echo 'active in first_tab';
                                                                                                                                        } ?>">
                                                                                    <div class="panel panel-default">
                                                                                        <div class="panel-body">
                                                                                            <?php if ($step->note_letter_of_reference) { ?>
                                                                                                <?= $step->note_letter_of_reference ?>
                                                                                            <?php } ?>
                                                                                            <?php if ($step->is_letter_of_reference && (!$step->not_show_grantee || $is_admin)) { ?>
                                                                                                <div class="row form-group mt-4">
                                                                                                    <div class="col-lg-4">
                                                                                                        <label>Letter of Reference</label>
                                                                                                        <div class="row">
                                                                                                            <div class="col-lg-8">
                                                                                                                <img height="100" width="100" style="object-fit:contain;" src="<?php echo get_preview($detail_data['grantee_period']->letter_of_reference); ?>">
                                                                                                                <br />
                                                                                                                <!-- <p class="filename" style="font-size:16px"><?= $filename ?></p> -->
                                                                                                                <a href="<?= base_url($detail_data['grantee_period']->letter_of_reference) ?>" download class="btn btn-info mt-3" style="color:#fff;" target="_blank">
                                                                                                                    <i class="fa fa-download fa-fw"></i> Download
                                                                                                                </a>
                                                                                                                <hr>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                        <div class="panel-body multiple-step-<?= $step->id ?>">
                                                                                            <!-- ENDPRE DEPATURE ORIENTATION -->
                                                                                            <?php $file = 0; ?>
                                                                                            <?php $row = "<div class='row form-group'>"; ?>
                                                                                            <?php $exitrow = "</div>"; ?>
                                                                                            <?php
                                                                                            foreach ($step->custom_fields as $key_fields => $custom_fields) {
                                                                                                // if ($custom_fields->not_show_grantee) {
                                                                                                //     continue;
                                                                                                // }
                                                                                                if (in_array($custom_fields->type, ['radio group', 'checkbox'])) {
                                                                                                    $custom_fields->user_grantee_id = $userGranteeId;
                                                                                                    $custom_fields->grantee_grant_id = $granteeGrantId;
                                                                                                }
                                                                                            ?>
                                                                                                <!-- template for others instead file template -->
                                                                                                <?php if ($custom_fields->type != 'file'): ?>
                                                                                                    <div class="wrap-file-<?= $custom_fields->id ?>">
                                                                                                        <div class="row form-group multiple-cf-<?= $custom_fields->id ?> <?php echo (int) $custom_fields->parent_id > 0 && $custom_fields->is_advanced_checkbox ? 'hide ml-4' : ''; ?>" data-parent="<?php echo (int) $custom_fields->parent_id; ?>">
                                                                                                            <?php if ($custom_fields->type == 'separator'): ?>
                                                                                                                <?php if ((int) $custom_fields->parent_section_id > 0) { ?>
                                                                                                                    <div class="col-lg-12 text-left">
                                                                                                                        <?= url_text($custom_fields->name) ?>
                                                                                                                        <?php if ($custom_fields->description_file != '') { ?>
                                                                                                                            <div class="mt-2">
                                                                                                                                <span style="font-size: 12px !important; margin-left: 15px;"><?= $custom_fields->description_file ?></span>
                                                                                                                            </div>
                                                                                                                        <?php } ?>
                                                                                                                    </div>
                                                                                                                <?php } else { ?>
                                                                                                                    <div class="col-lg-12 text-left font-weight-bold">
                                                                                                                        <!-- <b><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $custom_fields->name); ?></b> -->
                                                                                                                        <hr style="border-top:2px solid #eee" class="p-0 mt-1 mb-1" />
                                                                                                                        <b><?= url_text($custom_fields->name) ?></b>
                                                                                                                        <?php if ($custom_fields->description_file != '') { ?>
                                                                                                                            <div class="mt-2">
                                                                                                                                <span style="font-size: 12px !important; margin-left: 15px;"><?= $custom_fields->description_file ?></span>
                                                                                                                            </div>
                                                                                                                        <?php } ?>
                                                                                                                    </div>
                                                                                                                <?php } ?>
                                                                                                            <?php else: ?>
                                                                                                                <div class="<?= $custom_fields->type == 'element group' ? 'col-md-12' : 'col-md-4' ?> <?php echo (int) $custom_fields->parent_id > 0 && $custom_fields->is_advanced_checkbox ? 'ml-4' : ''; ?> text-left font-weight-bold <?php echo $custom_fields->hide_question_label ? 'hide' : ''; ?>">
                                                                                                                    <?php if ($custom_fields->type == 'element group') { ?>
                                                                                                                        <b><?= url_text($custom_fields->name); ?> <?= in_array($custom_fields->type, ['element group', 'radio group']) ? null : label_required($custom_fields->is_required); ?></b>
                                                                                                                        <div style="margin-top:10px;">
                                                                                                                            <span class="span-note" style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                                                                                                        </div>
                                                                                                                    <?php } else { ?>
                                                                                                                        <?= url_text($custom_fields->name); ?> <?= in_array($custom_fields->type, ['element group']) ? null : label_required($custom_fields->is_required); ?>
                                                                                                                        <?php if (in_array($custom_fields->type, ['text']) && $custom_fields->under_question) { ?>
                                                                                                                            <div>
                                                                                                                                <span class="span-note" style="font-size: 12px !important; text-align: justify;"><?= $custom_fields->description_file ?></span>
                                                                                                                            </div>
                                                                                                                        <?php } ?>
                                                                                                                    <?php } ?>
                                                                                                                </div>
                                                                                                            <?php endif; ?>
                                                                                                            <div class="<?php echo in_array($custom_fields->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                                                                <?= get_component($custom_fields, 'disabled', $custom_fields->value_custom_fields); ?>
                                                                                                            </div>
                                                                                                            <?php if ($custom_fields->description_file != '' && !in_array($custom_fields->type, ['separator', 'element group']) && !$custom_fields->under_question) { ?>
                                                                                                                <div class="<?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? 'col-lg-4' : 'col-lg-12' ?> mt-2">
                                                                                                                    <span class="span-note" style="font-size: 12px !important; text-align: justify;"><?= $custom_fields->description_file ?></span>
                                                                                                                </div>
                                                                                                            <?php } ?>
                                                                                                        </div>

                                                                                                        <?php if ($custom_fields->is_multiple && $custom_fields->type != 'radio group') { ?>
                                                                                                            <?php foreach ($custom_fields->multiple_file as $kmf => $mf) { ?>

                                                                                                                <div class="multiple-item multiple-cf-<?= $custom_fields->id ?>" style="margin-left: -15px;">
                                                                                                                    <div class="<?= $custom_fields->type == 'element group' ? 'col-md-12' : 'col-md-4' ?> text-left font-weight-bold">
                                                                                                                        <b><?= url_text($mf->property_name); ?></b>
                                                                                                                        <a href="javascript:;" data-multiple-id="<?= $mf->id ?>" onclick="del_multiple(this, 'multiple-item')" class="btn btn-danger mt-2 pull-right" style="color:white;"><i class="fa fa-trash fa-fw"></i></a>
                                                                                                                        <div style="margin-top:10px;">
                                                                                                                            <span class="span-note" style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <div class="<?php echo in_array($custom_fields->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', NULL]) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                                                                        <!-- dapatkan data value dari customfield multiple -->
                                                                                                                        <?php
                                                                                                                        $condition_custom_fields_value = [
                                                                                                                            'user_grantee_custom_fields_id' => $custom_fields->id,
                                                                                                                            'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                                                                            'user_grantee_id' => $userGranteeId,
                                                                                                                            'user_grantee_period_id' => $custom_fields->period_id,
                                                                                                                            'multiple_file_id' => $mf->id,
                                                                                                                            'grantee_grant_id' => $granteeGrantId
                                                                                                                        ];
                                                                                                                        $value_custom_fields = get_all_db('am_user_grantee_submission', $condition_custom_fields_value);
                                                                                                                        $sub_element = "";
                                                                                                                        if ($custom_fields->type == 'radio group' || $custom_fields->type == 'element group') {
                                                                                                                            $sub_element = get_all_db('am_user_grantee_group_element', ['custom_fields_id' => $custom_fields->id]);
                                                                                                                            $sub_element = array_map(function ($data) use ($value_custom_fields) {
                                                                                                                                $get_value = array_filter($value_custom_fields, function ($value) use ($data) {
                                                                                                                                    return $value->group_element_id == $data->id;
                                                                                                                                });
                                                                                                                                $data->value = array_column($get_value, 'value');
                                                                                                                                $data->submission_id = array_column($get_value, 'id');
                                                                                                                                return $data;
                                                                                                                            }, $sub_element);
                                                                                                                            $value_custom_fields = array_filter($value_custom_fields, function ($value) {
                                                                                                                                return $value->group_element_id == 0;
                                                                                                                            });
                                                                                                                            $custom_fields->sub_element = $sub_element;
                                                                                                                            $custom_fields->multiple_file_id = $mf->id;
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                        <?= get_component($custom_fields, 'disabled', $custom_fields->value_custom_fields, true); ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <?php } ?>
                                                                                                        <?php } ?>
                                                                                                    </div>
                                                                                                    <?php if ($custom_fields->is_multiple && $custom_fields->type != 'radio group') { ?>
                                                                                                        <div class="row col-md-12 mb-5">
                                                                                                            <a
                                                                                                                href="javascript:;"
                                                                                                                onclick="add_more_submission(this)"
                                                                                                                class="btn btn-info <?= $display ?> mt-2 pull-right"
                                                                                                                style="color:#fff;display:<?= $display_upload ?>"
                                                                                                                data-category-id="<?= $custom_fields->user_grantee_category_id; ?>"
                                                                                                                data-category-type="<?= $custom_fields->user_grantee_category_type; ?>"
                                                                                                                data-grant-id="<?= $custom_fields->user_grantee_grant_id; ?>"
                                                                                                                data-step="<?= $custom_fields->user_grantee_step_id; ?>"
                                                                                                                data-label="<?= url_text($custom_fields->name); ?>"
                                                                                                                data-period-id="<?= $custom_fields->period_id ?>"
                                                                                                                data-id="<?= $custom_fields->id; ?>"
                                                                                                                data-type="<?= $custom_fields->type; ?>"
                                                                                                                data-max_multiple="<?= $custom_fields->max_multiple; ?>">
                                                                                                                Add New
                                                                                                            </a>
                                                                                                        </div>
                                                                                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id ?>" style="display:none;">
                                                                                                    <?php } ?>
                                                                                                <?php else: ?>
                                                                                                    <?php
                                                                                                    $display_upload = '';
                                                                                                    $hide = '';

                                                                                                    if ($custom_fields->read_only == true && is_grantee()) {
                                                                                                        $display_upload = 'none';
                                                                                                        // $hide = 'hide';
                                                                                                    }

                                                                                                    $filename = get_filename_submission($custom_fields);
                                                                                                    $strlen = $filename ? strlen($filename) : 0;
                                                                                                    $name_file = $filename;
                                                                                                    if ($strlen > 15) {
                                                                                                        $name_file = substr($filename, 0, 15) . '....';
                                                                                                    }
                                                                                                    $fileurl = get_fileurl_sumbission($custom_fields);
                                                                                                    ?>
                                                                                                    <?php
                                                                                                    if ($step->custom_fields[$key_fields + 1]->type == 'file') {
                                                                                                        $file = 0;
                                                                                                        $row = "";
                                                                                                        $exitrow = "";
                                                                                                        $style = "margin-left:-10px;";
                                                                                                        $mr = "";
                                                                                                    } else {
                                                                                                        $row = "<div class='row form-group " . ($file < 3 && $file != 1 ? '' : '') . "'>";
                                                                                                        $exitrow = "</div>";
                                                                                                        $style = "";
                                                                                                        $mr = "margin-right:25px;";
                                                                                                    } ?>

                                                                                                    <div class="wrap-file-<?= $custom_fields->id ?>"
                                                                                                        data-conditional-parent-id="<?= !empty($custom_fields->conditional_parent_id) ? (int)$custom_fields->conditional_parent_id : '' ?>"
                                                                                                        data-conditional-parent-value="<?= htmlspecialchars($custom_fields->conditional_parent_value ?? '', ENT_QUOTES) ?>"> 
                                                                                                        <div class="doc-section-item" id="doc-2">
                                                                                                            <div class="sub-item">
                                                                                                                <div class="item-sub">
                                                                                                                    <div class="doc-label"><?= get_label_form($custom_fields) ?></div>
                                                                                                                    <!-- DESCRIPTION -->
                                                                                                                    <?php if ($custom_fields->description_file) : ?>
                                                                                                                        <div class="doc-hint-box">
                                                                                                                            <?= $custom_fields->description_file ?>
                                                                                                                        </div>
                                                                                                                    <?php endif; ?>
                                                                                                                    <!-- FILE ADMIN -->
                                                                                                                    <?php if ($custom_fields->file) { ?>
                                                                                                                        <div class="mb-2">
                                                                                                                            <?php
                                                                                                                                $file_url = site_url($custom_fields->file);
                                                                                                                                $applicant_file = get_row_db('am_user_grantee_custom_field_files', [
                                                                                                                                    'user_grantee_custom_field_id' => $custom_fields->id,
                                                                                                                                    'user_grantee_grant_id' => $grantee_grant->id,
                                                                                                                                    'user_grantee_id' => $grantee_grant->user_grantee_id
                                                                                                                                ]);
                                                                                                                                
                                                                                                                                if ($applicant_file) {
                                                                                                                                    $file_url = site_url() . $applicant_file->filepath;
                                                                                                                                }
                                                                                                                                $filename_temp = file_name($file_url);
                                                                                                                                
                                                                                                                            ?>
                                                                                                                            
                                                                                                                            <?php if ((bool) $custom_fields->read_only == 1) { ?>
                                                                                                                                <?php if ($custom_fields->file) { ?>
                                                                                                                                    <div class="upload-bar uploaded">
                                                                                                                                        <div class="bar-left">
                                                                                                                                            <svg class="icon-svg file-icon" viewBox="0 0 24 24">
                                                                                                                                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                                                                                                                                <polyline points="13 2 13 9 20 9"></polyline>
                                                                                                                                            </svg>
                                                                                                                                            <div>
                                                                                                                                                <span class="file-name-text"><?= $filename_temp ?></span>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="bar-right">
                                                                                                                                            <a href="<?php echo $file_url; ?>" class="btn btn-info btn-sm button-download-file-guide-<?php echo $custom_fields->id; ?>" target="_blank" download style="color: white;"><i class="fa fa-download"></i> Download Document</a>
                                                                                                                                            <?php if (!is_grantee()) { ?>
                                                                                                                                                <label class="btn btn-primary btn-sm button-upload-guide-file-applicant button-upload-guide-<?php echo $custom_fields->id; ?>" for="file-guide-applicant-<?php echo $custom_fields->id; ?>"><i class="fa fa-upload"></i></label> 
                                                                                                                                                <input class="upload-guide-file-applicant hide" type="file" data-user_grantee_custom_field_id="<?php echo $custom_fields->id; ?>" data-user_grantee_id="<?php echo $grantee_grant->user_grantee_id; ?>" data-user_grantee_grant_id="<?php echo $grantee_grant->id; ?>" id="file-guide-applicant-<?php echo $custom_fields->id; ?>">
                                                                                                                                            <?php } ?>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                <?php } ?>
                                                                                                                            <?php } else { ?>
                                                                                                                                <a href="<?php echo $file_url; ?>" class="btn btn-info btn-sm button-download-file-guide-<?php echo $custom_fields->id; ?>" target="_blank" download style="color: white;"><i class="fa fa-download"></i> Download Document</a>
                                                                                                                            <?php } ?>
                                                                                                                        </div>
                                                                                                                    <?php } ?>
                                                                                                                    <!-- ITEM BAR -->
                                                                                                                    <div class="upload-bar uploaded">
                                                                                                                        <!-- for preview and upload from admin readonly wiht no uploaded files -->
                                                                                                                        <?php if ($custom_fields->read_only && empty($custom_fields->file)) : ?>
                                                                                                                            <?php 
                                                                                                                                $hide_unuploaded = '';
                                                                                                                                if (empty($custom_fields->value_custom_fields)) {
                                                                                                                                    $fileurl = 'assets/images/icons/add-file.png';
                                                                                                                                    $hide_unuploaded = 'hide';
                                                                                                                                }
                                                                                                                            ?>
                                                    
                                                                                                                            <div class="bar-left">
                                                                                                                                <?php if(empty($custom_fields->value_custom_fields)) : ?>
                                                                                                                                    <svg class="icon-svg" viewBox="0 0 24 24" style="color: #94a3b8; stroke-width: 1.5;">
                                                                                                                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                                                                                        <polyline points="17 8 12 3 7 8"></polyline>
                                                                                                                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                                                                                                                    </svg>
                                                                                                                                    <div>
                                                                                                                                        <span style="color: #64748b; font-size: 13px;">No file selected yet...</span>
                                                                                                                                    </div>
                                                                                                                                <?php else : ?>
                                                                                                                                    <svg class="icon-svg file-icon" viewBox="0 0 24 24">
                                                                                                                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                                                                                                                        <polyline points="13 2 13 9 20 9"></polyline>
                                                                                                                                    </svg>
                                                                                                                                    <div>
                                                                                                                                        <span class="file-name-text"><?= file_name($fileurl) ?></span>
                                                                                                                                    </div>
                                                                                                                                <?php endif; ?>
                                                                                                                            </div>
                                                                                                                            <div class="bar-right">
                                                                                                                                <a href="<?= $custom_fields->value_custom_fields ? base_url($fileurl) : 'javascript:;' ?>" download title="Click to download" class="btn-download<?= $custom_fields->id ?> action-icon-btn primary <?php echo $hide_unuploaded; ?>">
                                                                                                                                    <i class="fa fa-download fa-fw"></i>
                                                                                                                                </a>
                                                                                                                                <a href="<?= $custom_fields->value_custom_fields ? base_url($fileurl) : 'javascript:;' ?>" class="fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                                                                                                                    <i class="fa fa-eye fa-fw"></i>
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                        <?php else : ?>
                                                                                                                            <div class="bar-left">
                                                                                                                                <?php if ($fileurl)  : ?>
                                                                                                                                    <svg class="icon-svg file-icon" viewBox="0 0 24 24">
                                                                                                                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                                                                                                                        <polyline points="13 2 13 9 20 9"></polyline>
                                                                                                                                    </svg>
                                                                                                                                    <div>
                                                                                                                                        <span class="file-name-text"><?= $filename ?></span>
                                                                                                                                    </div>
                                                                                                                                <?php else : ?>
                                                                                                                                    <svg class="icon-svg" viewBox="0 0 24 24" style="color: #94a3b8; stroke-width: 1.5;">
                                                                                                                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                                                                                        <polyline points="17 8 12 3 7 8"></polyline>
                                                                                                                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                                                                                                                    </svg>
                                                                                                                                    <div>
                                                                                                                                        <span style="color: #64748b; font-size: 13px;">No file selected yet...</span>
                                                                                                                                    </div>
                                                                                                                                <?php endif; ?>
                                                                                                                            </div>
                                                                                                                            <div class="bar-right">
                                                                                                                                <?php if ($fileurl)  : ?>
                                                                                                                                    <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="action-icon-btn primary btn-download btn-download<?= $custom_fields->id ?>">
                                                                                                                                        <i class="fa fa-download fa-fw"></i>
                                                                                                                                    </a>
                                                                                                                                    <a href="<?= base_url($fileurl) ?>" class="fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                                                                                                                        <i class="fa fa-eye fa-fw"></i>
                                                                                                                                    </a>
                                                                                                                                    <a href="javascript:;" onclick="del_file(this, 'img_photo', '<?= strip_tags($custom_fields->name) ?>', <?= $custom_fields->id ?>, <?= $custom_fields->submission_id ?>)" class="action-icon-btn hide danger btn-delete<?= $custom_fields->id ?> <?php echo $hide_unuploaded; ?> <?= $display ?>" style="display: <?= $display_upload ?>">
                                                                                                                                        <i class="fa fa-trash fa-fw"></i>
                                                                                                                                    </a>
                                                                                                                                <?php else: ?>
                                                                                                                                    <?php if ($disabled == '') { ?>
                                                                                                                                        <a href="javascript:;" download title="Click to download" class="hide btn action-icon-btn primary btn-download btn-download<?= $custom_fields->id ?>">
                                                                                                                                            <i class="fa fa-download fa-fw text-white"></i>
                                                                                                                                        </a>
                                                                                                                                        <a href="javascript:;" class="hide fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                                                                                                                            <i class="fa fa-eye fa-fw"></i>
                                                                                                                                        </a>
                                                                                                                                        <a href="javascript:;" onclick="del_file(this, 'img_photo', '<?= strip_tags($custom_fields->name) ?>', <?= $custom_fields->id ?>, 'subid')" class="hide action-icon-btn hide danger btn-delete<?= $custom_fields->id ?> <?= $display ?>" style="display: <?= $display_upload ?>">
                                                                                                                                            <i class="fa fa-trash fa-fw text-danger"></i>
                                                                                                                                        </a>
                                                                                                                                    <?php } ?>
                                                                                                                                <?php endif; ?>
                                                                                                                                <a href="javascript:;" id="my_file_<?= $custom_fields->id ?>" class="btn btn-primary upload-button hide <?= $display ?>" data-file-value="my_file_<?= $custom_fields->id ?>" style ="color:#fff;display:<?= $display_upload ?>">Upload</a>
                                                                                                                            </div>
                                                                                                                        <?php endif; ?>
                                                                                                                    </div>
                                                                                                                    <?php if ($custom_fields->read_only && empty($custom_fields->file)) : ?>
                                                                                                                        <?php if (is_grantee()) { ?>
                                                                                                                            <?php if(empty($custom_fields->value_custom_fields)) { ?>
                                                                                                                                <div class="file-limit-hint">This file will be uploaded soon by the administrator.</small>
                                                                                                                            <?php } else { ?>
                                                                                                                                <div class="file-limit-hint">This file has been uploaded by the administrator</small>
                                                                                                                            <?php } ?>
                                                                                                                        <?php } ?>
                                                                                                                    <?php else : ?>
                                                                                                                        <div class="file-limit-hint">File Size Max 5MB | Supported File: Jpg, Png, PDF</div>
                                                                                                                    <?php endif; ?>
                                                                                                                    <?php
                                                                                                                    if ($custom_fields->is_required) {
                                                                                                                        $required = 'required';
                                                                                                                        if ($fileurl != '') {
                                                                                                                            $required = '';
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        $required = '';
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                    <input 
                                                                                                                        onchange="show_preview(this, <?= $custom_fields->id ?>);" 
                                                                                                                        type="file" 
                                                                                                                        data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' 
                                                                                                                        data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' 
                                                                                                                        data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' 
                                                                                                                        data-step='<?= $custom_fields->user_grantee_step_id; ?>' 
                                                                                                                        data-id='<?= $custom_fields->id; ?>' 
                                                                                                                        data-period-id='<?= $custom_fields->period_id ?>' 
                                                                                                                        data-type-group='file'
                                                                                                                        data-upload-id='<?= $custom_fields->id; ?>'
                                                                                                                        class="choosefile my_file_<?= $custom_fields->id ?>" 
                                                                                                                        style="display: none;" <?= $required ?>
                                                                                                                    >
                                                                                                                </div>


                                                                                                                <!-- MULTIPLE FILE -->
                                                                                                                <?php if ($custom_fields->is_multiple) { ?>
                                                                                                                    <?php foreach ($custom_fields->multiple_file as $kmf => $mf) { ?>
                                                                                                                        <?php
                                                                                                                            $filename_multiple = get_filename_submission_multiple($mf);
                                                                                                                            $strlen = strlen($filename_multiple);
                                                                                                                            $name_file_multiple = $filename_multiple;
                                                                                                                            if ($strlen > 15) {
                                                                                                                                $name_file_multiple = substr($filename_multiple, 0, 15) . '....';
                                                                                                                            }
                                                                                                                            $fileurl = get_fileurl_sumbission_multiple($mf);
                                                                                                                        ?>
                                                                                                                        <div class="item-sub multiple-item mt-5 multiple-cf-<?= $custom_fields->id ?>">
                                                                                                                            <div class="upload-bar uploaded">
                                                                                                                                <div class="bar-left">
                                                                                                                                    <?php if ($fileurl)  : ?>
                                                                                                                                        <svg class="icon-svg file-icon" viewBox="0 0 24 24">
                                                                                                                                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                                                                                                                            <polyline points="13 2 13 9 20 9"></polyline>
                                                                                                                                        </svg>
                                                                                                                                        <div>
                                                                                                                                            <span class="file-name-text"><?= $filename_multiple ?></span>
                                                                                                                                        </div>
                                                                                                                                    <?php else : ?>
                                                                                                                                        <svg class="icon-svg" viewBox="0 0 24 24" style="color: #94a3b8; stroke-width: 1.5;">
                                                                                                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                                                                                            <polyline points="17 8 12 3 7 8"></polyline>
                                                                                                                                            <line x1="12" y1="3" x2="12" y2="15"></line>
                                                                                                                                        </svg>
                                                                                                                                        <div>
                                                                                                                                            <span style="color: #64748b; font-size: 13px;">No file selected yet...</span>
                                                                                                                                        </div>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </div>
                                                                                                                                <div class="bar-right">
                                                                                                                                    <?php if ($fileurl)  : ?>
                                                                                                                                        <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="action-icon-btn primary btn-download btn-download<?= $custom_fields->id . $mf->id ?>">
                                                                                                                                            <i class="fa fa-download fa-fw"></i>
                                                                                                                                        </a>
                                                                                                                                        <a href="<?= base_url($fileurl) ?>" class="fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                                                                                                                            <i class="fa fa-eye fa-fw"></i>
                                                                                                                                        </a>
                                                                                                                                    <?php else: ?>
                                                                                                                                        <?php if ($disabled == '') { ?>
                                                                                                                                            <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="hide btn action-icon-btn primary btn-download btn-download<?= $custom_fields->id . $mf->id ?>">
                                                                                                                                                <i class="fa fa-download fa-fw"></i>
                                                                                                                                            </a>
                                                                                                                                            <a href="javascript:;" class="hide fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                                                                                                                                <i class="fa fa-eye fa-fw"></i>
                                                                                                                                            </a>
                                                                                                                                        <?php } ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                    <?php if (!is_grantee() || (is_grantee() && !$custom_fields->read_only)) : ?>
                                                                                                                                        <a href="javascript:;" data-multiple-id="<?= $mf->id ?>" onclick="del_multiple(this, 'multiple-item')" class="hide action-icon-btn danger btn-delete<?= $custom_fields->id . $mf->id ?> <?= $display ?>" style="display: <?= $display_upload ?>" title="Delete">
                                                                                                                                            <i class="fa fa-trash fa-fw"></i>
                                                                                                                                        </a>
                                                                                                                                    <?php endif; ?>
                                                                                                                                    <a href="javascript:;" id="my_file_<?= $custom_fields->id . $mf->id ?>" class="hide btn btn-primary upload-button <?= $display ?>" data-file-value="my_file_<?= $custom_fields->id . $mf->id ?>" style ="color:#fff;display:<?= $display_upload ?>">Upload</a>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <?php if ($custom_fields->read_only && empty($custom_fields->file)) : ?>
                                                                                                                                <?php if (is_grantee()) { ?>
                                                                                                                                    <?php if(!$fileurl) { ?>
                                                                                                                                        <small class="file-limit-hint">This file will be uploaded soon by the administrator.</small>
                                                                                                                                    <?php } else { ?>
                                                                                                                                        <small class="file-limit-hint">This file has been uploaded by the administrator</small>
                                                                                                                                    <?php } ?>
                                                                                                                                <?php } ?>
                                                                                                                            <?php else : ?>
                                                                                                                                <small class="file-limit-hint">File Size Max 5MB | Supported File: Jpg, Png, PDF</small>
                                                                                                                            <?php endif; ?>
                                                                                                                            <?php
                                                                                                                            if ($custom_fields->is_required) {
                                                                                                                                $required = 'required';
                                                                                                                                if ($fileurl != '') {
                                                                                                                                    $required = '';
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                $required = '';
                                                                                                                            }
                                                                                                                            ?>
                                                                                                                            <input 
                                                                                                                                onchange="show_preview(this, <?= $custom_fields->id . $mf->id ?>);" 
                                                                                                                                type="file" 
                                                                                                                                data-multiple-id='<?= $mf->id ?>'                                                                      
                                                                                                                                data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' 
                                                                                                                                data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' 
                                                                                                                                data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' 
                                                                                                                                data-step='<?= $custom_fields->user_grantee_step_id; ?>' 
                                                                                                                                data-id='<?= $custom_fields->id; ?>' 
                                                                                                                                data-period-id='<?= $custom_fields->period_id ?>' 
                                                                                                                                data-type-group='file'
                                                                                                                                data-upload-id='<?= $custom_fields->id . $mf->id ?>'
                                                                                                                                class="choosefile my_file_<?= $custom_fields->id . $mf->id ?> autosave" 
                                                                                                                                style="display: none;" <?= $required ?>>
                                                                                                                        </div>
                                                                                                                    <?php } ?>
                                                                                                                <?php } ?>
                                                                                                            </div>   
                                                                                                            <?php if ($custom_fields->is_multiple) { ?>
                                                                                                                <a 
                                                                                                                    href="javascript:;" 
                                                                                                                    onclick="add_more_submission(this)" 
                                                                                                                    class="mt-2 btn btn-info hide <?= $display ?>" 
                                                                                                                    style ="color:#fff;display:<?= $display_upload ?>" 
                                                                                                                    data-category-id="<?= $custom_fields->user_grantee_category_id; ?>" 
                                                                                                                    data-category-type="<?= $custom_fields->user_grantee_category_type; ?>" 
                                                                                                                    data-grant-id="<?= $custom_fields->user_grantee_grant_id; ?>" 
                                                                                                                    data-step="<?= $custom_fields->user_grantee_step_id; ?>" 
                                                                                                                    data-label="<?= strip_tags($custom_fields->name); ?>"
                                                                                                                    data-period-id="<?= $custom_fields->period_id ?>"
                                                                                                                    data-id="<?= $custom_fields->id; ?>"
                                                                                                                    data-type="<?= $custom_fields->type; ?>"
                                                                                                                    data-max_multiple="<?= $custom_fields->max_multiple; ?>"
                                                                                                                >
                                                                                                                <i class="fa fa-plus fa-fw"></i>
                                                                                                                </a>
                                                                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id . $mf->id ?>" style="display:none;">
                                                                                                            <?php } ?>
                                                                                                        </div>
                                                                                                    </div> <!-- endwrap -->

                                                                                                <?php
                                                                                                    $file++;
                                                                                                endif;
                                                                                                ?>
                                                                                            <?php } ?>
                                                                                        </div>

                                                                                        <div class="wrap-step-<?= $step->id ?>">

                                                                                            <!-- jika ada data multiple step -->
                                                                                            <?php if (!empty($step->multiple_fields_step)) { ?>
                                                                                                <?php foreach ($step->multiple_fields_step as $key => $mfs) { ?>
                                                                                                    <?php
                                                                                                    $data_for_content['idx'] = $mfs->id;
                                                                                                    foreach ($step->custom_fields as $kscf => $rowscf) {
                                                                                                        $condition_multiple_file = [
                                                                                                            'user_grantee_custom_fields_id' => $rowscf->id,
                                                                                                            'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                                                            'user_grantee_id' => $this->Grantee_ent_model->id,
                                                                                                            'user_grantee_period_id' => $rowscf->period_id,
                                                                                                            // 'multiple_file_id' => $mfs->id,
                                                                                                            'multiple_step_id' => $mfs->id
                                                                                                        ];
                                                                                                        $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_file);
                                                                                                        $arr_value_custom_fields = get_all_db('am_user_grantee_submission', $condition_multiple_file);
                                                                                                        // if type radio group then get sub element 
                                                                                                        $sub_element = "";
                                                                                                        if ($rowscf->type == 'radio group' || $rowscf->type == 'element group') {
                                                                                                            $sub_element = get_all_db('am_user_grantee_group_element', ['custom_fields_id' => $rowscf->id]);
                                                                                                            $sub_element = array_map(function ($data) use ($arr_value_custom_fields) {
                                                                                                                $get_value = array_filter($arr_value_custom_fields, function ($value) use ($data) {
                                                                                                                    return $value->group_element_id == $data->id;
                                                                                                                });
                                                                                                                $data->value = array_column($get_value, 'value');
                                                                                                                return $data;
                                                                                                            }, $sub_element);

                                                                                                        }
                                                                                                        $multiple_file = get_row_db('am_user_grantee_multiple_file', ['user_grantee_step_id' => $mfs->id, 'property_name' => $rowscf->name]);
                                                                                                        $rowscf->value_custom_fields = $value_multiple_file->value;
                                                                                                        $rowscf->other_value = $value_multiple_file->other_value;
                                                                                                        $rowscf->multiple_step_id = $mfs->id;
                                                                                                        $rowscf->multiple_file_id = $multiple_file->id;
                                                                                                        $rowscf->sub_element = $sub_element;

                                                                                                        if ($rowscf->is_multiple == true) {
                                                                                                            $multiple_file_for_file = get_all_db('am_user_grantee_multiple_file', [
                                                                                                                'custom_fields_id' => $rowscf->id,
                                                                                                                'grantee_grant_id' => $grantee_grant_id,
                                                                                                                'user_grantee_step_id' => $mfs->id,
                                                                                                            ]);
                                                                                                            foreach ($multiple_file_for_file as $kmf => $mf) {
                                                                                                                $condition_multiple_for_file = [
                                                                                                                    'user_grantee_custom_fields_id' => $rowscf->id,
                                                                                                                    'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                                                                    'user_grantee_id' => $this->Grantee_ent_model->id,
                                                                                                                    'user_grantee_period_id' => $rowscf->period_id,
                                                                                                                    'multiple_file_id' => $mf->id,
                                                                                                                    'multiple_step_id' => $mfs->id,
                                                                                                                ];
                                                                                                                $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_for_file);
                                                                                                                $mf->value = $value_multiple_file ? $value_multiple_file->value : '';
                                                                                                            }
                                                                                                            $rowscf->multiple_file = $multiple_file_for_file;
                                                                                                        }
                                                                                                    }
                                                                                                    $data_for_content['data_custom_fields'] = $step->custom_fields;
                                                                                                    $data_for_content['disabled'] = 'disabled';
                                                                                                    $data_for_content['display'] = 'd-none';
                                                                                                    $data_for_content['activeCountry'] = $this->session->userdata('active_country');
                                                                                                    echo $this->load->view('grantee/submission/multiple_fields_step', $data_for_content, true);
                                                                                                    ?>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                        <?php if ($step->is_multiple_fields) { ?>
                                                                                            <div class="panel-body">
                                                                                                <div class="pull-left">
                                                                                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-step-spinner-<?= $step->id ?>" style="display:none;">
                                                                                                    <a
                                                                                                        href="javascript:;"
                                                                                                        onclick="add_more_step_fields(this)"
                                                                                                        data-id="<?= $step->id ?>"
                                                                                                        data-user_grantee_category_id="<?= $step->user_grantee_category_id ?>"
                                                                                                        data-user_grantee_grant_id="<?= $step->user_grantee_grant_id ?>"
                                                                                                        data-period_id="<?= $step->custom_fields[0]->period_id ?>"
                                                                                                        data-max_multiple="<?= $step->max_multiple ?>"
                                                                                                        class="hide btn btn-primary <?= $display ?>"
                                                                                                        style="color:white">Add New
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                    <?php if (!$is_admin) { ?>
                                                                                        <?php if ((!isset($is_preview) || !$is_preview) && $detail_data['detail_grantee_grant']->status != STATUS_SET_TO_ALUMNI) { ?>
                                                                                            <div class="progressbar flex-right" style="display:flex;justify-content:flex-end;gap:6px;flex-wrap:nowrap;align-items:center;">
                                                                                                <?php if ($index + 1 == count($data_step)): ?>
                                                                                                    <?php
                                                                                                    $end_date = $detail_data['grantee_period']->end_date ? strtotime($detail_data['grantee_period']->end_date) : 0;
                                                                                                    $today = strtotime(date('Y-m-d H:i'));
                                                                                                    $disabledEndDate = false;
                                                                                                    if ($end_date) {
                                                                                                        $disabledEndDate = $end_date < $today;
                                                                                                    }

                                                                                                    $end_offline_date = $detail_data['detail_grantee_grant']->end_offline_date ? strtotime($detail_data['detail_grantee_grant']->end_offline_date) : 0;

                                                                                                    $is_ended = false;
                                                                                                    if ($end_offline_date) {
                                                                                                        $is_ended = $end_offline_date < $today;
                                                                                                    }

                                                                                                    $isRelease = ($detail_data['detail_grantee_grant']->status == STATUS_SELECTION_REVISED && $detail_data['detail_grantee_grant']->is_release);

                                                                                                    $canSubmit = false;

                                                                                                    // Case 1: belum lewat end_date dan bukan release
                                                                                                    if (!$disabledEndDate && !$isRelease) {
                                                                                                        $canSubmit = true;
                                                                                                    }

                                                                                                    // Case 2: status revise dan is_release true, walaupun sudah lewat end_date
                                                                                                    if ($detail_data['detail_grantee_grant']->status == STATUS_SELECTION_REVISED && $detail_data['detail_grantee_grant']->is_release) {
                                                                                                        $canSubmit = true;
                                                                                                    }

                                                                                                    // Case 3: is_release true dan belum lewat end_date
                                                                                                    if ($isRelease && !$disabledEndDate) {
                                                                                                        $canSubmit = true;
                                                                                                    }
                                                                                                    ?>

                                                                                                    <?php if ($canSubmit): ?>
                                                                                                        <a
                                                                                                            href="#submit"
                                                                                                            data-submit="form-submission"
                                                                                                            class="btn btn-success submit-submission"
                                                                                                            <?= $disabled ?>
                                                                                                            style="color:#fff;float:right;margin-bottom:20px;width:100px; <?= isset($disabled) && $disabled == 'disabled' ? 'display:none !important;' : '' ?>">
                                                                                                            Submit
                                                                                                        </a>
                                                                                                    <?php endif; ?>

                                                                                                    <?php //if(!$disabledEndDate && !$isRelease) { 
                                                                                                    ?>
                                                                                                    <!-- <a 
                                                    href="#submit" 
                                                    data-submit="form-submission" 
                                                    class="btn btn-success submit-submission" 
                                                    <?= $disabled ?> 
                                                    <?= ($disabledEndDate && $detail_data['detail_grantee_grant']->status == STATUS_WAITING_DOCUMENT && $detail_data['detail_grantee_grant']->is_offline == 0) ? 'disabled' : (($detail_data['detail_grantee_grant']->is_offline == 1 && $is_ended) ? 'disabled' : (!$detail_data['detail_grantee_grant']->is_offline && $disabledEndDate ? 'disabled' : '')) ?>
                                                    style="color:#fff;float:right;margin-bottom:20px;width:100px; <?php echo isset($disabled) && $disabled == 'disabled' ? 'display:none !important;' : '' ?>">
                                                Submit
                                                </a> -->
                                                                                                    <?php //} 
                                                                                                    ?>
                                                                                                    <?php //if($detail_data['detail_grantee_grant']->status == STATUS_SELECTION_REVISED && !$isRelease){ 
                                                                                                    ?>
                                                                                                    <!-- <a 
                                                        href="#submit" 
                                                        data-submit="form-submission" 
                                                        class="btn btn-success submit-submission" 
                                                        <?= $disabled ?> 
                                                        style="color:#fff;float:right;margin-bottom:20px;width:100px; <?php echo isset($disabled) && $disabled == 'disabled' ? 'display:none !important;' : '' ?>">">
                                                    Submit
                                                    </a> -->
                                                                                                    <?php //} 
                                                                                                    ?>
                                                                                                    <?php //if($isRelease && !$disabledEndDate){ 
                                                                                                    ?>
                                                                                                    <!-- <a 
                                                        href="#submit" 
                                                        data-submit="form-submission" 
                                                        class="btn btn-success submit-submission" 
                                                        <?= $disabled ?> 
                                                        style="color:#fff;float:right;margin-bottom:20px;width:100px; <?php echo isset($disabled) && $disabled == 'disabled' ? 'display:none !important;' : '' ?>">
                                                    Submit
                                                    </a> -->
                                                                                                    <?php //} 
                                                                                                    ?>
                                                                                                <?php elseif ($index == 0): ?>
                                                                                                    <a aria-expanded="true" data-toggle="tab" data-index="step_<?= $data_step[1]->id; ?>" class="btn btn-success next" <?php echo isset($disabled) && $disabled == 'disabled' ? $disabled . ' style="display:none !important;"' : 'style="color:#fff;float:right;margin-bottom:20px;"'; ?>>Save & Continue</a>
                                                                                                <?php else: ?>
                                                                                                    <a aria-expanded="true" data-toggle="tab" href="#step_<?= $data_step[$index - 1]->id; ?>" class="btn btn-primary previous" style="color:#fff;float:left;margin-bottom:20px;width:100px;">Back</a>
                                                                                                    <a aria-expanded="true" data-toggle="tab" data-index="step_<?= $data_step[$index + 1]->id; ?>" class="btn btn-success next" <?php echo isset($disabled) && $disabled == 'disabled' ? $disabled . ' style="display:none !important;"' : 'style="color:#fff;float:right;margin-bottom:20px;"'; ?>>Save & Continue</a>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    <?php } else { ?>
                                                                                        <div class="progressbar flex-right" style="display:flex;justify-content:flex-end;gap:6px;flex-wrap:nowrap;align-items:center;">
                                                                                            <?php if (count($grants_step) == 1) : ?>
                                                                                                <!-- <a aria-expanded="true" data-toggle="tab" href="#step_<?= $step->name - 1; ?>" onclick="back_step(<?= $step->name - 1; ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" class="btn btn-primary previous" style="color:#fff;float:left;margin-bottom:20px;width:100px;">Back</a> -->

                                                                                                <?php //if($grantee_grant->grant_document_status != DOCUMENT_COMPLETED){ 
                                                                                                ?>
                                                                                                <?php // For Permit/Visa sections: render buttons left-to-right using flexbox ?>
                                                                                                <div style="display:flex;justify-content:flex-end;gap:8px;align-items:center;margin-bottom:20px;">
                                                                                                    <?php if (in_array($category->is_new_grantee, [1, 2, 3, 4, 5])) { ?>
                                                                                                        <a
                                                                                                            href="javascript:;"
                                                                                                            data-submit="form-submission"
                                                                                                            onclick="revise_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                            class="btn btn-warning revise-submission"
                                                                                                            id="btn-revise-submission"
                                                                                                            style="color:#fff;width:100px;">
                                                                                                            Revise
                                                                                                        </a>

                                                                                                        <a
                                                                                                            href="javascript:;"
                                                                                                            data-submit="form-submission"
                                                                                                            onclick="accept_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                            class="btn btn-success submit-submission"
                                                                                                            id="btn-accept-submission"
                                                                                                            style="color:#fff;width:100px;">
                                                                                                            Complete
                                                                                                        </a>

                                                                                                        <a
                                                                                                            href="javascript:;"
                                                                                                            data-submit="form-submission"
                                                                                                            onclick="withdraw_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                            class="btn btn-primary withdraw-submission"
                                                                                                            id="btn-withdraw-submission"
                                                                                                            style="color:#fff;width:100px;">
                                                                                                            Withdraw
                                                                                                        </a>
                                                                                                    <?php } ?>

                                                                                                    <?php if ($category->name == 'Visa Application') { ?>
                                                                                                        <a
                                                                                                            href="javascript:;"
                                                                                                            data-submit="form-submission"
                                                                                                            onclick="arrived_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                            class="btn btn-info arrived-submission"
                                                                                                            id="btn-arrived-submission"
                                                                                                            style="color:#fff;width:100px;">
                                                                                                            Arrived
                                                                                                        </a>
                                                                                                    <?php } ?>

                                                                                                    <?php if ($category->name == 'Permit Application' || $category->name == 'Pre Arrival Documents') { ?>
                                                                                                        <a
                                                                                                            href="javascript:;"
                                                                                                            data-submit="form-submission"
                                                                                                            onclick="permit_reject_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                            class="btn btn-danger permit-reject-submission"
                                                                                                            id="btn-permit-reject-submission"
                                                                                                            style="color:#fff;">
                                                                                                            Permit Rejected
                                                                                                        </a>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            <?php elseif ($index == 0) : ?>
                                                                                                <a
                                                                                                    aria-expanded="true"
                                                                                                    data-toggle="tab"
                                                                                                    data-index="step_<?= $data_step[1]->id; ?>"
                                                                                                    class="btn btn-success next"
                                                                                                    style="color:#fff;float:right;margin-bottom:20px;width:100px;">Next
                                                                                                </a>
                                                                                            <?php elseif ($index + 1 == count($grants_step)) : ?>
                                                                                                <a
                                                                                                    aria-expanded="true"
                                                                                                    data-toggle="tab"
                                                                                                    data-index="step_<?= $data_step[$index - 1]->id; ?>"
                                                                                                    class="btn btn-primary previous"
                                                                                                    style="color:#fff;float:left;margin-bottom:20px;width:100px;">
                                                                                                    Back
                                                                                                </a>

                                                                                                <?php //if($grantee_grant->grant_document_status != DOCUMENT_COMPLETED){ 
                                                                                                ?>
                                                                                                <?php // For Permit/Visa sections: show Revise -> Complete -> Withdraw -> (Permit Rejected / Arrived)
                                                                                                if (in_array($category->is_new_grantee, [1, 2, 3, 4, 5])) { ?>

                                                                                                    <a
                                                                                                        href="javascript:;"
                                                                                                        data-submit="form-submission"
                                                                                                        onclick="revise_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                        class="btn btn-warning revise-submission"
                                                                                                        id="btn-revise-submission"
                                                                                                        style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                                                                        Revise
                                                                                                    </a>

                                                                                                    <a
                                                                                                        href="javascript:;"
                                                                                                        data-submit="form-submission"
                                                                                                        onclick="accept_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                        class="btn btn-success submit-submission"
                                                                                                        id="btn-accept-submission"
                                                                                                        style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                                                                        Complete
                                                                                                    </a>

                                                                                                    <a
                                                                                                        href="javascript:;"
                                                                                                        data-submit="form-submission"
                                                                                                        onclick="withdraw_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                        class="btn btn-primary withdraw-submission"
                                                                                                        id="btn-withdraw-submission"
                                                                                                        style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                                                                        Withdraw
                                                                                                    </a>
                                                                                                <?php } ?>

                                                                                                <?php if ($category->name == 'Permit Application' || $category->name == 'Pre Arrival Documents') { ?>
                                                                                                    <a
                                                                                                        href="javascript:;"
                                                                                                        data-submit="form-submission"
                                                                                                        onclick="permit_reject_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                        class="btn btn-danger permit-reject-submission"
                                                                                                        id="btn-permit-reject-submission"
                                                                                                        style="color:#fff;float:right;margin-bottom:20px;width:auto;margin-right:5px;">
                                                                                                        Permit Rejected
                                                                                                    </a>
                                                                                                <?php } ?>

                                                                                                <?php if ($category->name == 'Visa Application') { ?>
                                                                                                    <a
                                                                                                        href="javascript:;"
                                                                                                        data-submit="form-submission"
                                                                                                        onclick="arrived_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)"
                                                                                                        class="btn btn-info arrived-submission"
                                                                                                        id="btn-arrived-submission"
                                                                                                        style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                                                                        Arrived
                                                                                                    </a>
                                                                                                <?php } ?>
                                                                                            <?php else : ?>
                                                                                                <a
                                                                                                    aria-expanded="true"
                                                                                                    data-toggle="tab"
                                                                                                    data-index="step_<?= $data_step[$index - 1]->id; ?>"
                                                                                                    class="btn btn-primary previous"
                                                                                                    style="color:#fff;float:left;margin-bottom:20px;width:100px;">
                                                                                                    Back
                                                                                                </a>
                                                                                                <a
                                                                                                    aria-expanded="true"
                                                                                                    data-toggle="tab"
                                                                                                    data-index="step_<?= $data_step[$index + 1]->id; ?>"
                                                                                                    class="btn btn-success next"
                                                                                                    style="color:#fff;float:right;margin-bottom:20px;width:100px;">
                                                                                                    Next
                                                                                                </a>
                                                                                            <?php endif; ?>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    <?php } else { ?>
                                                                        <div class="alert alert-info mt-2"><i class="fa fa-info-circle"></i> This category does not have any submission content yet.</div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php $firstTab = false;
                                        endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
                <?php if($is_admin && $active_country == INDONESIAN_DATABASE) { ?>
                    <?php $this->load->view('admin/partials/us_address'); ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</form>

<!-- modal leave -->
<div class="modal fade" id="mdl_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Leave Grantee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form autocomplete="new-password" role="form" id="form_leave" method="POST" enctype="multipart/form-data" action="<?= base_url('admin/grantee/edit_leave/' . $grantee_grant->id) ?>">
                    <div class="row form-group">
                        <div class="col-lg-3">
                            <label>Personal Travel</label>
                        </div>
                        <div class="col-lg-6">
                            <input
                                type="number"
                                class="form-control"
                                name="personal_travel"
                                value="<?= $grantee_grant->personal_travel != 0 ? ($grantee_grant->personal_travel) : ($programs[$grant_id]->personal_travel) ?>">
                        </div>
                    </div>
                    <?php if ($programs[$grant_id]->category_grant == RESEARCH) { ?>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>International Research Travel</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" class="form-control" name="research_leave" value="<?= $grantee_grant->research_leave != 0 ? ($grantee_grant->research_leave) : ($programs[$grant_id]->research_leave) ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($programs[$grant_id]->category_grant == ETA) { ?>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Sick Leave</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" class="form-control" name="sick_leave" value="<?= $grantee_grant->sick_leave != 0 ? ($grantee_grant->sick_leave) : ($programs[$grant_id]->sick_leave) ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (in_array($programs[$grant_id]->category_grant, [ETA, TEACHING, RESEARCH])) { ?>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Emergency Leave</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" class="form-control" name="emergency_leave" value="<?= $grantee_grant->emergency_leave != 0 ? ($grantee_grant->emergency_leave) : ($programs[$grant_id]->emergency_leave) ?>">
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" form="form_leave">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- modal detail leave -->
<div class="modal fade" id="mdl_detail_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Detail Leave Grantee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form autocomplete="new-password" role="form" id="form_status_leave" method="POST" enctype="multipart/form-data" action="<?= base_url('admin/grantee/edit_status_leave/' . $grantee_grant->id) ?>">
                    <div class="row form-group">
                        <div class="col-lg-4">
                            <label>Leave Category</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="leave_category" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            <label>Leave (day)</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="leave_day" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            <label id="label_start">Start Date</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="start_date" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            <label id="label_end">End Date</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="end_date" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group" id="section_departure_time">
                        <div class="col-lg-4">
                            <label>Departure Time</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="departure_time" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group" id="destination_form">
                        <div class="col-lg-4">
                            <label>Destination</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="destination" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group" id="destination_purpose_form">
                        <div class="col-lg-4">
                            <label>Destination Purpose</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="destination_purpose" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group" id="section_departure_indo_date">
                        <div class="col-lg-4">
                            <label>Date of Departure from Indonesia</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="departure_indo_date" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group" id="section_arrival_indo_date">
                        <div class="col-lg-4">
                            <label>Date of Arrival from Indonesia</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="arrival_indo_date" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group" id="form_upload">
                        <div class="col-lg-4">
                            <label>Form Upload</label>
                        </div>
                        <div class="col-lg-6">
                            <a href="" class="btn btn-primary lightbox" id="form_upload_file">Preview</a>
                        </div>
                    </div>
                    <!-- <div class="row form-group" id="boarding_pass_form">
                    <div class="col-lg-4">
                        <label>Borading Pass</label>
                    </div>
                    <div class="col-lg-6">
                        <a href="" class="btn btn-primary lightbox" id="borading_pass_file">Preview</a>
                    </div>
                </div> -->
                    <div class="row form-group hide" id="telephone">
                        <div class="col-lg-4">
                            <label>Telephone</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="telephone_val" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group hide" id="email">
                        <div class="col-lg-4">
                            <label>Email</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="email_val" value="" readonly>
                        </div>
                    </div>
                    <div class="row form-group hide" id="address">
                        <div class="col-lg-4">
                            <label>Address</label>
                        </div>
                        <div class="col-lg-6">
                            <textarea class="form-control" id="address_val" readonly></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            <label>Status</label>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-control" id="status" name="status">
                                <option value="<?= LEAVE_PENDING ?>">Pending</option>
                                <option value="<?= LEAVE_APPROVE ?>">Approve</option>
                                <option value="<?= LEAVE_REJECT ?>">Reject</option>
                                <option value="<?= LEAVE_CANCEL ?>">Cancel</option>
                            </select>
                            <input type="hidden" name="id" id="leave_id" value="">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            <label>Note</label>
                        </div>
                        <div class="col-lg-6">
                            <textarea class="form-control" name="note" id="note"></textarea>
                        </div>
                    </div>
                    <div id="data_table"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" form="form_status_leave">Save</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/modal_confirm') ?>

<script>
    var data_photo = `<?= $this->Grantee_ent_model->img_photo ?>`;
    var account_book = `<?= $this->Grantee_ent_model->account_book ?>`;
    var img_passport = `<?= $this->Grantee_ent_model->img_passport ?>`;
</script>

<?php if ($academic) { ?>
    <script>
        var academic_form = JSON.parse(`<?php echo safe_parse_json(json_encode($academic)); ?>`);
    </script>
<?php } else { ?>
    <script>
        var academic_form = '';
    </script>
<?php } ?>
<?php
if (!empty($leave_applications)) :
    $final_leave = [];
    foreach ($leave_applications as $row) {
        $now = strtotime($row->end_date);
        $your_date = strtotime($row->start_date);
        $datediff = $now - $your_date;
        $leave_day = total_day_leave($row->start_date, $row->end_date);
        $row->leave_day = $leave_day;
        $row->category_name = get_label_leave_category($row->leave_category);
        $final_leave[$row->id] = $row;
    }
?>
    <script>
        var currentLeaveApps = JSON.parse(`<?php echo safe_parse_json(json_encode($final_leave)); ?>`);
    </script>
<?php endif; ?>