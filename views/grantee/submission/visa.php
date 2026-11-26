
<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Visa</h2>
        <h1 class="page-header"><?php echo $title ?></h1>
        <!-- <h2><?= $grantee_grant->status_name ?></h2> -->
    </div>
</div>
<div class="row">
    <?php if ($success = $this->session->flashdata('success')) : ?>
        <?= show_alert('success', $success); ?>
    <?php endif; ?>
</div>
<?php 
    $this->session->unset_userdata('success');
    $status_visa = [
        STATUS_CANDIDATE_VERIFIED ,
        STATUS_RETURNING_SUCCESSFUL, 
        STATUS_NEW_RETURNING, 
        STATUS_SELECTION_SUCCESSFUL,
        STATUS_CANDIDATE_SUCCESSFUL,
        STATUS_RETURNING_SUCCESSFUL,
        STATUS_RETURNING_REVISED,
        STATUS_SET_TO_ALUMNI
    ];
?>

<style>
    .panel-default .panel-heading{
        background-color: rgb(236 240 244);
        color: #000;
        /* border-radius: 8px;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important; */
        padding: 20px;
    }
    .panel-default .panel-heading-visa{
        background-color: rgb(236 240 244);
        color: #000;
        /* border-radius: 8px;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important; */
        padding: 20px;
    }

    .panel-collapse{
        border: 1px solid rgb(236 240 244);
    }

    th {
        /* text-align: center; */
        vertical-align: top !important;
    }
    .table-appointment th {
        /* text-align: center; */
        vertical-align: top !important;
    }
    .table-required th {
        /* text-align: center; */
        vertical-align: top !important;
    }

    .span-note:hover {
        background-color: #df7401;
        cursor: pointer;
    }
    .TriSea-technologies-Switch > input[type="checkbox"] {
        display: none;   
    }

    .TriSea-technologies-Switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .TriSea-technologies-Switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .TriSea-technologies-Switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }

    .needdatepicker {
        background-color: #fff !important;
    }
</style>
<form id="form" method="POST" enctype="multipart/form-data">
<input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">
<input type="hidden" name="user_grantee_id" id="user_grantee_id" value="<?= $grantee_grant->user_grantee_id ?>">
<input type="hidden" name="departure_id" id="departure_id" value="<?= $departure->id ?>">
<input type="hidden" name="btn" id="btn_value">
<input type="hidden" id="interview_appointment" value="<?= $visa_interview->appointment_located ?>">

<input type="hidden" id="interview_appointment_renewal" value="<?= $visa_renewal->appointment_located ?>">
<input type="hidden" id="is_admin" value="<?= $is_admin ?>">

<div class="panel panel-body">
    <div class="panel-group" id="accordionHeadParent" role="tablist" aria-multiselectable="true" style="margin-bottom:5px;">
        <?php if($grantee_grant->show_visa_nominee){ ?>
        <div class="panel panel-default">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionHeadParent" href="#collapseHeadNominee" aria-expanded="false" aria-controls="collapseHeadNominee" onclick="return set_session('nominee')">
                <div class="panel-heading text-left" role="tab" id="submission_result">
                    <h4 class="panel-title">
                        Nominee
                    </h4>
                </div>
            </a>
            <div id="collapseHeadNominee" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'nominee' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                <div class="panel-body">
                    <div class="panel-group" id="accordionParent" role="tablist" aria-multiselectable="true" style="margin-bottom:5px;">
                        <div class="panel panel-default">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionParent" href="#collapseInterview" aria-expanded="false" aria-controls="collapseInterview" onclick="return set_session('visa_interview')">
                                <div class="panel-heading text-left" role="tab" id="submission_result">
                                    <h4 class="panel-title">
                                        Visa Application (New)
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseInterview" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'visa_interview' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                <div class="panel-body">
                                    <?php $this->load->view('admin/partials/visa_interview'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><?php } ?>

        <?php if($grantee_grant->status >= STATUS_SELECTION_SUCCESSFUL && ($visa_renewals || $grantee_grant->show_visa_dependent)){ ?>
        <div class="panel panel-default">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionHeadParent" href="#collapseHeadOngoing" aria-expanded="false" aria-controls="collapseHeadOngoing" onclick="return set_session('ongoing')">
                <div class="panel-heading text-left" role="tab" id="submission_result">
                    <h4 class="panel-title">
                        Ongoing Grantees
                    </h4>
                </div>
            </a>
            <div id="collapseHeadOngoing" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'ongoing' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                <div class="panel-body">
                    <?php $this->load->view('admin/partials/visa_renewal'); ?>
    
                    <?php $this->load->view('admin/partials/visa_dependent'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</form>



<!-- MODAL -->
<?php $this->load->view('admin/partials/modal_ds2019_departure'); ?>
<?php $this->load->view('admin/partials/form_ds160') ?>
<?php $this->load->view('admin/partials/form_appointment') ?>


<?php $this->load->view('admin/partials/form_appointment_ongoing') ?>
<?php $this->load->view('admin/partials/form_appointment_ongoing_dependent') ?>
<!-- END MODAL -->


<!-- TEMPLTE FORM -->
<?php $this->load->view('admin/partials/template_visa_renewal') ?>


<?php $this->session->unset_userdata('last_tab_visa'); ?>
<?php $this->session->unset_userdata('last_list'); ?>
