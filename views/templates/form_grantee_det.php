<?php 
$required_label = "<span style='color:red'> *</span>";
// echo '<pre>';print_r($user);die;
?>
<style>
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
        top: 42px;
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

    .has-error {
        border: 2px solid #a94442 !important;
    }

    .select2-container--default .select2-selection--single.has-error {
        border: 1px solid #a94442 !important;
    }

    .select2-container--default .select2-selection--multiple.has-error {
        border: 1px solid #a94442 !important;
    }

    /* .submission-description {
        min-height: 100px;
    } */

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
    .form-group-name{
        position: relative;
        padding-bottom:28px;
    }

    .form-group-name .checkbox-holder{
        position:absolute;
        left:0;
        bottom:0;
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
                <a href="<?= site_url('admin/grantee/delete/' . $user->id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 <?= isset($is_admin) ? '' : 'text-center'?>">
        <h1 class="page-header">
            <?= isset($is_admin) ? get_full_name($user) : $title ?>
            <a class="btn btn-danger pull-right btn-deleted" data-id="<?= $user->id ?>" href="javascript:;"><i class="fa fa-trash"></i> Delete</a> 
        </h1>
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

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="<?= $user->id ?>" id="grantee_id">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> NAME</p>
                    <div class="col-lg-4">
                        <div class="form-group form-group-name">
                            <label>Prefix</label>
                            <select class="form-control" name="prefix_name" id="prefix_name">
                                <option value="">-- Select Prefix --</option>
                                <?php
                                if ($titles) {
                                    foreach ($titles as $tt) {
                                        $selected = '';
                                        if ($user->prefix == $tt) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?php echo $tt ?>" <?php echo $selected ?>><?php echo $tt ?></option>
                                    <?php
                                }
                            }
                            ?>
                            </select>
                            <input type="text" class="form-control mt-2" name="prefix_other" id="prefix_other" placeholder="Enter prefix" value="<?= $user->prefix_other ?>" style="display: none;">
                            <!-- <input type="text" class="form-control" name="prefix_name" value="<?php echo $user->prefix ?>" placeholder="Prefix"> -->
                        </div>
                        <div class="form-group form-group-name">
                            <label>Last/Family Name</label><?= $required_label ?>
                            <input type="text" class="form-control auto-capitalize" name="last_name" id="last_name" value="<?php echo $user->last_name ?>" placeholder="Last/Family Name">
                            <div id="invalid_last_name" class="text-danger invalid-tooltip">
                                Last Name is not null.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group form-group-name">
                            <label>First/Given Name</label><?= $required_label ?>
                            <input type="text" class="form-control auto-capitalize" name="first_name" id="first_name" value="<?php echo $user->first_name ?>" placeholder="First/Given Name">
                            <div class="checkbox-holder">
                                <input type="checkbox"
                                    value="1"
                                    name="dont_have_first_name"
                                    id="dont_have_first_name5"
                                    <?= $user->dont_have_first_name == 1 ? 'checked' : '' ?>>
    
                                <label for="dont_have_first_name5">
                                    I do not have a first/given name
                                </label>
                            </div>
                            <div id="invalid_first_name" class="text-danger invalid-tooltip">
                                First Name is not null.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group form-group-name">
                            <label>Middle Name</label>
                            <input type="text" class="form-control auto-capitalize" name="middle_name" value="<?php echo $user->middle_name ?>" placeholder="Middle Name">
                        </div>
                    </div>
                </div>
    
                <div class="panel-body mt-3">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BIOGRAPHICAL INFORMATION</p>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Birthdate</label><?= $required_label ?>
                            <input type="text" class="form-control datepicker-birthdate" readonly name="date_of_birth" id="date_of_birth" placeholder="Birthdate" value="<?php echo ($user->date_of_birth) ? date('d M Y', strtotime($user->date_of_birth)) : '' ?>">
                            <div id="invalid_date_of_birth" class="text-danger invalid-tooltip">
                                Birthdate is not null.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Country of Birth</label><?= $required_label ?>
                            <select id="country_of_birth" class="form-control select2 select-country-birth" name="country_of_birth">
                                <option value="">-- Select Country --</option>
                                <?php
                                if ($country_list) {
                                    foreach ($country_list as $cl) {
                                        $selected = '';
                                        if ($user->country_of_birth == $cl->id) {
                                            $selected = 'selected="selected"';
                                        }
                                ?>
                                        <option value="<?php echo $cl->id ?>" data-pcode="<?php echo $cl->phone_code ?>" <?php echo $selected ?>><?php echo $cl->name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <div id="invalid_country_of_birth" class="text-danger invalid-tooltip">
                                Country of Birth is not null.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>State of Birth</label><?= $required_label ?>
                            <select id="state_of_birth" class="form-control select2 select-state-birth" name="state_of_birth">
                                <option value="">-- Select Country --</option>
                                <?php
    
                                if ($birth_states) {
                                    foreach ($birth_states as $bt) {
                                        $selected = '';
                                        if ($user->state_of_birth == $bt->id) {
                                            $selected = 'selected="selected"';
                                        }
                                ?>
                                        <option value="<?php echo $bt->id ?>" <?php echo $selected ?>><?php echo $bt->name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <div id="invalid_state_of_birth" class="text-danger invalid-tooltip">
                                State of Birth is not null.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>City of Birth</label><?= $required_label ?>
                            <select id="city_of_birth" class="form-control select2 select-city-birth" name="city_of_birth" id="city_of_birth">
                                <option value="">-- Select City --</option>
                                <?php
                                if ($birth_cities) {
                                    foreach ($birth_cities as $bc) {
                                        $selected = '';
                                        if ($user->city_of_birth == $bc->id) {
                                            $selected = 'selected="selected"';
                                        }
                                ?>
                                        <option value="<?php echo $bc->id ?>" <?php echo $selected ?>><?php echo $bc->name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <div id="invalid_city_of_birth" class="text-danger invalid-tooltip">
                                City of Birth is not null.
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
                                        if ($user->gender == $ge) {
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
                </div>
    
                <div class="panel-body mt-3">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> CITIZENSHIP INFORMATION</p>
                    <div class="col-md-8 p-0">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country of Citizenship</label><?= $required_label ?>
                                <select id="country_of_citizenship" class="form-control select2 select-country" name="country_of_citizenship" style="width:100%">
                                    <option value="">-- Select Country --</option>
                                    <?php
                                    if ($citizen_country_list) {
                                        foreach ($citizen_country_list as $cl) {
                                            $selected = '';
                                            if ($user->country_of_citizenship == $cl->id) {
                                                $selected = 'selected="selected"';
                                            }
                                    ?>
                                            <option value="<?php echo $cl->id ?>" data-pcode="<?php echo $cl->phone_code ?>" <?php echo $selected ?>><?php echo $cl->name ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div id="invalid_country_of_citizenship" class="text-danger invalid-tooltip">
                                    Country of Citizenship is not null.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Identity Card Number</label><?= $required_label ?>
                                <input type="text" class="form-control" name="identity_card_number" id="identity_card_number" maxlength="16" value="<?php echo $user->identity_card_number ?>" placeholder="Identity Card Number">
                                <div id="invalid_identity_card_number_length" class="text-danger invalid-tooltip">
                                    Min 16 Digit.
                                </div>
                                <div id="invalid_identity_card_number" class="text-danger invalid-tooltip">
                                    Identity Card Number is not null.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label id="label-identity_card_file">
                                Identity Card (Follow the guide <a href="<?= site_url('img/passport_photo_samplev2.png') ?>" class="lightbox">here)</a>
                            </label><?= $required_label ?>
                            <?php
                            $profile_photo = user_grantee_file_url($user, 'identity_card_file');
                            ?>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                <a href="<?php echo site_url($profile_photo); ?>" class="lightbox" aria-haspopup="dialog">
                                    <img id="preview_image_identity_card_file" data-old="<?php echo site_url($profile_photo); ?>" src="<?php echo get_preview($profile_photo); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                </a>
                                <a href="javascript:;" onclick="del_file(this, 'identity_card_file', 'Identity Card File')" id="button_delete_identity_card_file" class="btn btn-danger btn-xs <?php echo empty($user->identity_card_file) ? 'hide' : ''; ?>" style="position:absolute; top:25px; right:-28px;">
                                    <i class="fa fa-trash fa-fw"></i>
                                </a>
                                
                                <a href="<?php echo base_url($profile_photo) ?>" id="button_download_identity_card_file" download title="Click to download" class="btn btn-primary btn-xs <?php echo empty($user->identity_card_file) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                                    <i class="fa fa-download fa-fw"></i>
                                </a>
                            </div>
                            <input type="file" class="custom-file-input hide" accept="<?php foreach (ALLOWED_PROFILE_FILETYPE as $filetype) {
                                                                                            echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ",";
                                                                                        } ?>" id="identity_card_file" onchange="show_preview(this, 'identity_card_file', 'identity_card_file');">
                            <input type="hidden" name="identity_card_file" value="<?php echo $user->identity_card_file; ?>">
                            <label class="btn btn-primary upload-button" for="identity_card_file"> Choose file </label>
                            <a href="<?php echo site_url($profile_photo) ?>" id="button_preview_identity_card_file" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
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
                </div>
    
                <div class="panel-body mt-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input class="form-control" placeholder="Phone Number" name="phone_number" type="text" value="<?php echo $user->phone_number ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" placeholder="Email" name="email" type="text" value="<?php echo $user->email ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> Leave the password field blank if you do not want to change the password.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group password-group">
                                <label>New Password</label>
                                <input class="form-control" placeholder="New Password" name="password" type="password" value="">
                                <i class="fa fa-eye password-show"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group password-group">
                                <label>Confirm New Password</label>
                                <input class="form-control" placeholder="Confirm New Password" name="confirm_password" type="password" value="">
                                <i class="fa fa-eye password-show"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-lg-12" style="margin-bottom:10px;">
            <div style="margin-bottom:10px;">
    
                <?php
                if ($user->id) {
                ?>
                    <input type="hidden" name="id" id="uid" value="<?php echo $user->id ?>">
                <?php } ?>
                <button type="submit" id="btn-submit" class="btn btn-success btn-submit" name="btn-submit" value="save_profile" style="float:right;">Save</button>
            </div>
        </div>
    </div>
    
</form>

<script>
    var identity_card_file = `<?= $user->identity_card_file ?>`;
</script>