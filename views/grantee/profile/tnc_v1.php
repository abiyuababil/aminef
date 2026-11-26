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
    .select2 {
        width:100% !important;
    }
</style>

<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">AMINEF T&C</h2>
        <h1 class="page-header"><?php echo $grantee_grant->grant_name ?></h1>
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
<div class="row">
<?php if($grantee_grant->tnc_approver == 1) { ?>
    <div class="col-lg-12">
        <div class="alert alert-success">Status T&C : <b>Accepted</b></div>
    </div>
<?php } ?>
<?php if($grantee_grant->tnc_approver == 2) { ?>
<div class="col-lg-12">
    <label>Need to be revised with note: </label>
    <div class="alert alert-warning mt-4"><?= $grantee_grant->note_tnc ?></div>
</div>
<?php } ?>
</div>
<div class="row">
<!-- <div id="submission-plan" class="tab-pane fade"> -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <form id="form" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if($data_period->tnc != '') { ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-justify"><?= $data_period->tnc_wording ?></div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <?php 
                                        $field_tnc = $grantee_grant->field_tnc ? explode(',', $grantee_grant->field_tnc) : [];
                                    ?>
                                    <?php if(in_array('upload_tnc', $field_tnc)) { ?>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Upload AMINEF T&C</label>
                                                <br />
                                                <a download href="<?= base_url($data_period->tnc) ?>" class="btn btn-success" style="margin-bottom: 10px;" target="_blank"<?= $is_preview ? 'disabled="disabled"' : '' ?>>Download AMINEF T&C</a>
                                                <?php if($grantee_grant->tnc_approver != 1) { ?>
                                                <input type="file" class="form-control" name="tnc" id="tnc">
                                                <small class="file-for-testing">File Size Max 5MB</small>
                                                <?php } ?>
                                                <?php if($grantee_grant->tnc != '') { ?>
                                                <div style="margin-bottom:25px; position:relative; width:100px; margin-top: 25px;">
                                                    <a href="<?php echo base_url() ?><?php echo $grantee_grant->tnc ?>" class="lightbox" aria-haspopup="dialog">
                                                        <img height="100" src="<?php echo get_preview($grantee_grant->tnc); ?>">
                                                    </a>
                                                    <a href="<?= base_url($grantee_grant->tnc) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute;top:0;">
                                                        <i class="fa fa-download fa-fw text-white"></i>
                                                    </a>
                                                    <?php if($grantee_grant->tnc_approver != 1) { ?>
                                                    <a href="<?= base_url('grantee/tc/delete/'.$grantee_grant->user_grantee_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')" style="position:absolute;top:25px;">
                                                        <i class="fa fa-trash fa-fw text-white"></i>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if(in_array('upload_consent_letter', $field_tnc)) { ?>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Upload AMINEF Consent Letter</label>
                                                <br />
                                                <a download href="<?= base_url($data_period->consent_letter) ?>" class="btn btn-success" style="margin-bottom: 10px;" target="_blank"<?= $is_preview ? 'disabled="disabled"' : '' ?>>Download AMINEF Consent Letter</a>
                                                <?php if($grantee_grant->tnc_approver != 1) { ?>
                                                <input type="file" class="form-control" name="consent_letter" id="consent_letter">
                                                <small class="file-for-testing">File Size Max 5MB</small>
                                                <?php } ?>
                                                <?php if($grantee_grant->consent_letter != '') { ?>
                                                <div style="margin-bottom:25px; position:relative; width:100px; margin-top: 25px;">
                                                    <a href="<?php echo base_url() ?><?php echo $grantee_grant->consent_letter ?>" class="lightbox" aria-haspopup="dialog">
                                                        <img height="100" src="<?php echo get_preview($grantee_grant->consent_letter); ?>">
                                                    </a>
                                                    <a href="<?= base_url($grantee_grant->consent_letter) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute;top:0;">
                                                        <i class="fa fa-download fa-fw text-white"></i>
                                                    </a>
                                                    <?php if($grantee_grant->tnc_approver != 1) { ?>
                                                    <a href="<?= base_url('grantee/consent/delete/'.$grantee_grant->user_grantee_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')" style="position:absolute;top:25px;">
                                                        <i class="fa fa-trash fa-fw text-white"></i>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php if($grantee_grant->tnc_approver == 0 || $grantee_grant->tnc_approver == 2) { ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-success pull-right">Save</button>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>