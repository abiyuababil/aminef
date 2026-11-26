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

    /* Main Form Card */
    .form-card {
        background: #ffffff;
        /* border: 1px solid #dcdfe6; */
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        padding: 24px;
        margin-bottom: 20px;
    }

    .grid-docs-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }

    .doc-upload-column {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .doc-title-label {
        font-size: 13px;
        font-weight: bold;
        color: #1e293b;
    }

    .btn-green-download {
        background-color: #449d44;
        color: #ffffff;
        border: none;
        padding: 7px 14px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        align-self: flex-start;
    }

    .btn-green-download:hover {
        background-color: #398439;
    }

    .upload-input-row {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 3px;
        padding: 4px 8px;
        background: #fff;
        max-width: 320px;
    }

    .upload-input-row input[type="file"] {
        font-size: 12px;
        color: #64748b;
        width: 100%;
    }

    .file-hint-text {
        font-size: 11px;
        color: #64748b;
    }

    .locked-notice-text {
        font-size: 12px;
        color: #166534;
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 6px 10px;
        border-radius: 3px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
        max-width: 320px;
    }

    .uploaded-pdf-widget {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-top: 6px;
    }

    .pdf-icon-card {
        width: 52px;
        height: 64px;
        background-color: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 3px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #dc2626;
        font-weight: bold;
        font-size: 11px;
        position: relative;
    }

    .pdf-icon-card::before {
        content: "📄";
        font-size: 20px;
    }

    .pdf-action-btns {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .btn-icon-square {
        width: 24px;
        height: 24px;
        background-color: #337ab7;
        color: white;
        border: none;
        border-radius: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
    }

    .btn-icon-square.delete {
        background-color: #d9534f;
    }

    .btn-save-bottom {
        background-color: #5cb85c;
        color: white;
        border: none;
        padding: 7px 22px;
        border-radius: 3px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        float: right;
        margin-top: 10px;
    }

    .btn-save-bottom:hover {
        background-color: #4cae4c;
    }

    /* Status Banner Box */
    .status-overview-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    .status-box-banner {
        border-radius: 4px;
        padding: 12px 16px;
        font-size: 13px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .status-box-banner.accepted {
        background-color: #eaf8ee;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .status-box-banner.revised {
        background-color: #fffdf0;
        border: 1px solid #fef08a;
        color: #854d0e;
    }

    .status-box-banner.rejected {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .badge-status-pill {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
    }
    
    .badge-status-pill.accepted { background-color: #dcfce7; color: #15803d; }
    .badge-status-pill.revised { background-color: #fef08a; color: #854d0e; }
    .badge-status-pill.rejected { background-color: #fee2e2; color: #b91c1c; }
    .badge-status-pill.pending { background-color: #e0f2fe; color: #0369a1; }
</style>

<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">AMINEF T&C</h2>
        <h1 class="page-header"><?php echo $grantee_grant->grant_name ?></h1>
    </div>
</div>
<?php if ($this->session->flashdata('update_tnc')) { ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('update_tnc'); ?></div>
    <?php $this->session->set_flashdata('update_tnc', false); ?>
<?php } ?>
<?php $this->session->unset_userdata('update_tnc');?>
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


<div class="status-overview-grid">
    <?php 
        if($grantee_grant->tnc_approver == 1){
            $class = 'accepted';
            $status = 'Accepted';
            $label = 'Your T&C document has been verified and accepted by AMINEF.';
        }else if($grantee_grant->tnc_approver == 2){
            $class = 'revised';
            $status = 'Needs Revision';
            $label = '<strong>Note:</strong> ' . $grantee_grant->note_tnc;
        }else if($grantee_grant->tnc_approver == 3){
            $class = 'rejected';
            $status = 'Rejected';
            $label = '<strong>Note:</strong> ' . $grantee_grant->note_tnc;
        }

        if($grantee_grant->consent_approver == 1){
            $classConsent = 'accepted';
            $statusConsent = 'Accepted';
            $labelConsent = 'Your Consent Letter document has been verified and accepted by AMINEF.';
        }else if($grantee_grant->consent_approver == 2){
            $classConsent = 'revised';
            $statusConsent = 'Needs Revision';
            $labelConsent = '<strong>Note:</strong> ' . $grantee_grant->note_consent;
        }else if($grantee_grant->consent_approver == 3){
            $classConsent = 'rejected';
            $statusConsent = 'Rejected';
            $labelConsent = '<strong>Note:</strong> ' . $grantee_grant->note_consent;
        }
    ?>
    <!-- Status T&C -->
    <?php if($grantee_grant->tnc_approver) { ?>
    <div class="status-box-banner <?= $class ?>" id="granteeBannerTC">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <strong>AMINEF T&C Status:</strong>
            <span class="badge-status-pill <?= $class ?>" id="granteePillTC"><?= $status ?></span>
        </div>
        <div style="font-size: 12px; margin-top: 2px;" id="granteeNoteTC">
            <?= $label ?>
        </div>
    </div>
    <?php } ?>

    <!-- Status Consent Letter -->
    <?php if($grantee_grant->consent_approver) { ?>
    <div class="status-box-banner <?= $classConsent ?>" id="granteeBannerConsent">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <strong>Consent Letter Status:</strong>
            <span class="badge-status-pill <?= $classConsent ?>" id="granteePillConsent"><?= $statusConsent ?></span>
        </div>
        <div style="font-size: 12px; margin-top: 2px;" id="granteeNoteConsent">
            <?= $labelConsent ?>
        </div>
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
                                    <!-- MAIN FORM CARD (GRANTEE UPLOAD) -->
                                    <div class="form-card">
                                        <div class="grid-docs-2">
                                            <?php 
                                                $field_tnc = $grantee_grant->field_tnc ? explode(',', $grantee_grant->field_tnc) : [];
                                            ?>
                                            <?php if(in_array('upload_tnc', $field_tnc)) { ?>
                                            <!-- COLUMN 1: AMINEF T&C -->
                                            <div class="doc-upload-column" id="granteeColumnTC">
                                                <div class="doc-title-label">Upload AMINEF T&C</div>
                                                <a download href="<?= base_url($data_period->tnc) ?>" class="btn-green-download" style="margin-bottom: 10px;" target="_blank"<?= $is_preview ? 'disabled="disabled"' : '' ?>>Download AMINEF T&C</a>

                                                <?php if($grantee_grant->tnc_approver != 1) { ?>
                                                <div class="upload-input-row">
                                                    <input type="file" name="tnc" id="tnc">
                                                </div>
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
                                            <?php } ?>

                                            <?php if(in_array('upload_consent_letter', $field_tnc)) { ?>
                                            <!-- COLUMN 2: AMINEF CONSENT LETTER -->
                                            <div class="doc-upload-column" id="granteeColumnConsent">
                                                <div class="doc-title-label">Upload AMINEF Consent Letter</div>
                                                <a download href="<?= base_url($data_period->consent_letter) ?>" class="btn-green-download" style="margin-bottom: 10px;" target="_blank"<?= $is_preview ? 'disabled="disabled"' : '' ?>>Download AMINEF Consent Letter</a>
                                                <?php if($grantee_grant->consent_approver != 1) { ?>
                                                <div class="upload-input-row">
                                                    <input type="file" name="consent_letter" id="consent_letter">
                                                </div>
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
                                                    <?php if($grantee_grant->consent_approver != 1) { ?>
                                                    <a href="<?= base_url('grantee/consent/delete/'.$grantee_grant->user_grantee_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')" style="position:absolute;top:25px;">
                                                        <i class="fa fa-trash fa-fw text-white"></i>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                                <?php if(in_array($grantee_grant->tnc_approver, [0,2]) || in_array($grantee_grant->consent_approver, [0,2])) { ?>
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