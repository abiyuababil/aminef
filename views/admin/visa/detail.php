<style>
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
<div class="row">
    <div class="col-lg-12">
        <h1><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header"><?= $grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>

<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php 
    $this->session->unset_userdata('success');
    $status_visa = [
        STATUS_CANDIDATE_VERIFIED ,
        STATUS_RETURNING_SUCCESSFUL, 
        STATUS_NEW_RETURNING, 
        STATUS_RETURNING_REVISED,
        STATUS_SET_TO_ALUMNI
    ];
?>
<form id="form" method="POST" enctype="multipart/form-data">
<input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">
<input type="hidden" name="user_grantee_id" id="user_grantee_id" value="<?= $grantee_grant->user_grantee_id ?>">
<input type="hidden" name="departure_id" id="departure_id" value="<?= $departure->id ?>">
<input type="hidden" name="btn" id="btn_value">
<input type="hidden" id="interview_appointment" value="<?= $visa_interview->appointment_located ?>">

<input type="hidden" id="interview_appointment_renewal" value="<?= $visa_renewal->appointment_located ?>">
<input type="hidden" id="is_admin" value="<?= $is_admin ?>">

<div class="panel-group warp-alumni-page" id="accordionHeadParent" role="tablist" aria-multiselectable="true" style="margin-bottom:5px;">
    <div class="panel panel-default">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionHeadParent" href="#collapseHeadNominee" aria-expanded="false" aria-controls="collapseHeadNominee" onclick="return set_session('nominee')">
            <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                <h4 class="panel-title">
                    Nominee
                </h4>
            </div>
        </a>
        <div id="collapseHeadNominee" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'nominee' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">

            <?php if($is_admin) { ?>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="TriSea-technologies-Switch">
                                <span class="mr-2"> Show on Grantee Page</span>
                                <input onclick="show_hide_visa_nominee(this, <?= $grantee_grant->id ?>)" id="show_visa_nominee" name="dependent[<?= $kvb ?>][show_visa_nominee]" type="checkbox" <?= $grantee_grant->show_visa_nominee  ? 'checked' : '' ?>/>
                                <label for="show_visa_nominee" class="label-primary"></label>
                            </div>
                        </div>
                    </div>

                </div>
            <?php } ?>
            <div class="panel-body">
                <div class="panel-group" id="accordionParent" role="tablist" aria-multiselectable="true" style="margin-bottom:5px;">
                    <div class="panel panel-default">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionParent" href="#collapseInterview" aria-expanded="false" aria-controls="collapseInterview" onclick="return set_session('visa_interview')">
                            <div class="panel-heading-visa text-left" role="tab" id="submission_result">
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
    </div>
    <?php if(in_array($grantee_grant->status, $status_visa) && ( $is_alumni_page ? ($visa_renewals || $grantee_grant->show_visa_dependent) : true)){ ?>
    <div class="panel panel-default">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionHeadParent" href="#collapseHeadOngoing" aria-expanded="false" aria-controls="collapseHeadOngoing" onclick="return set_session('ongoing')">
            <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                <h4 class="panel-title">
                    Ongoing Grantees
                </h4>
            </div>
        </a>
        <div id="collapseHeadOngoing" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'ongoing' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
            <div class="panel-body">
                <?php if($grantee_grant->show_visa_renewal) { ?>
                    <?php $this->load->view('admin/partials/visa_renewal'); ?>
                <?php } ?>

                <?php $this->load->view('admin/partials/visa_dependent'); ?>
            </div>
        </div>
    </div>
    <?php } ?>
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
<?php $this->load->view('admin/partials/template_visa_dependent') ?>

<?php $this->load->view('admin/partials/modal_log') ?>


<div class="modal fade" id="mdl_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_reject">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Attachment</label>
                            <input type="text" name="reject_id" id="reject_id" class="fields_reject hide">
                            <input type="text" name="dependent_reject" id="dependent_reject" class="fields_reject hide">
                            <label for="temp_attachment" class="withdraw-attachment-area">
                                <input type="file" id="temp_attachment" name="temp_attachment" class="hide fields_reject" onchange="show_preview_reject(this, 'attachment_reject', 'attachment_reject');">
                                <input type="text" id="attachment_reject" name="attachment_reject" class="hide fields_reject">
                                <i class="fa fa-cloud-upload"></i>
                            </label>
                            <div class="col-md-12 text-center">
                                <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label>Note</label>
                            <textarea class="form-control fields_reject" name="note_reject" id="note_reject" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="btn-save-reject" class="btn btn-primary success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php $this->session->unset_userdata('last_tab_visa'); ?>
<?php $this->session->unset_userdata('last_list'); ?>
