<?php

    $pid = $this->input->get('pid');
    $default_tab_active = 'class="active"';
    $default_content_active = 'active in';

    if ($pid != '') {
        $default_tab_active = '';
        $default_content_active = '';
    }

?>
<style>
    h3{
        margin-top: 10px;
    }
    .action-button{
        float:right;
        margin-bottom:20px;
        width:100px;
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

</style>
<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Selection</h2>
        <h1 class="page-header"><?php echo $title ?></h1>
        <!-- <h2><?= $grantee_grant->status_name ?></h2> -->
    </div>
</div>
<div class="row">
    <?php //if (empty($selection_review)) : ?>
        <!-- <div class="alert alert-danger">You're not ready for this stage yet!</div> -->
    <?php //endif; ?>

    <?php if ($error = $this->session->flashdata('error')) : ?>
        <?= show_alert('danger', $error); ?>
    <?php endif; ?>

    <?php if ($success = $this->session->flashdata('success')) : ?>
        <?= show_alert('success', $success); ?>
    <?php endif; ?>
</div>
<!-- /.row -->


<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="<?= $this->Grantee_ent_model->id ?>" id="grantee_id">
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px">
            <ul class="nav nav-pills">
                <?php 
                    $section_nominee_menu = $grantee_grant->section_nominee_menu ? explode(',', $grantee_grant->section_nominee_menu) : ['validation','review','interview'];
                ?>
                <?php //if($selection_validation && in_array('validation', $section_nominee_menu)) { ?>
                    <!-- <li id="li_validation" <?php echo $default_tab_active ?>><a data-toggle="tab" href="#validation" aria-expanded="true">Validation</a></li> -->
                <?php //} ?>
                <?php //if($selection_review && $grantee_grant->validation_status == VALID && in_array('review', $section_nominee_menu)) { ?>
                    <!-- <li id="li_review"><a data-toggle="tab" href="#review" aria-expanded="true">Selection Review</a></li> -->
                <?php //} ?>
                <?php //if($interview_selection && $grantee_grant->validation_status == VALID && in_array('interview', $section_nominee_menu)) { ?>
                <?php if($interview_selection && in_array('interview', $section_nominee_menu)) { ?>
                    <li <?= $pid == 'interview' || $pid == 'interviewbio' ? 'class="active"' : '' ?> id="li_interview" <?= $default_tab_active ?>><a data-toggle="tab" href="#interview" aria-expanded="true">Interview Selection</a></li>
                <?php } ?>
            </ul>
        </div>

        <div class="tab-content mb-5">
            <?php if($selection_review) { ?>
            <div id="review" class="tab-pane fade">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-5">
                                <?php if($grantee_grant->selection_review_status) { ?>
                                <?php $bgcolor = $grantee_grant->selection_review_status != NOT_RECOMMENDED ? 'success' : 'danger'; ?>
                                    <div 
                                        class="p-3 bg-<?= $bgcolor ?> text-<?= $bgcolor ?> my-5 text-center" 
                                        style="border-radius:5px;">
                                        Status Selection Review : <b><?= $grantee_grant->selection_review_status != NOT_RECOMMENDED ? 'COMPLETE' : 'FAILED' ?></b>
                                    </div>
                                <?php } else { ?>
                                    <div 
                                        class="p-3 bg-warning text-warning my-5 text-center" 
                                        style="border-radius:5px;">
                                        Status Selection Review : <b>IN PROGRESS</b>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php foreach($selection_review as $ksr => $row) : ?>
                        <!-- <div class="panel-body">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Selection Review</p>
                            <div class="col-lg-6">
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>PIC</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="<?= $row->pic ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Name of Panelist</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="<?= $row->panellist_name ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Field of Study</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="<?= $row->field_of_study_name ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="email" class="form-control" value="<?= $row->panellist_email ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Telp</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="tel" class="form-control" value="<?= $row->panellist_telp ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Home Institution</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="form-control" value="<?= $row->home_institution ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Bank Info</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="form-control" value="<?= $row->bank_info ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Beneficiary Name</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="form-control" value="<?= $row->beneficiary_name ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Account Number</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="form-control" value="<?= $row->account_number ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Date</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="form-control datepicker" value="<?= $row->date ? date('d M Y', strtotime($row->date)) : '' ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Score</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="form-control" value="<?= $row->score ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Status Panelist</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="form-control" value="<?= get_status_panellist($row->status_panellist_id) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <?php endforeach; ?>

                        <!-- <div class="panel-body" style="margin-top:-20px;">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Scoring sheet</label>
                                    <?php if ($grantee_grant->scoring_sheet != '') { ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                            <a href="<?php echo base_url() ?><?php echo $grantee_grant->scoring_sheet ?>" target="_blank"><label class="btn btn-primary" style="cursor:pointer">View</label></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <?php } ?>

            <div id="validation" class="tab-pane fade">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-5">
                                <?php if($grantee_grant->validation_status) { ?>
                                <?php $bgcolor = $grantee_grant->validation_status == VALID ? 'success' : 'danger'; ?>
                                <div 
                                    class="p-3 bg-<?= $bgcolor ?> text-<?= $bgcolor ?> my-5 text-center" 
                                    style="border-radius:5px;">
                                    Status Selection Validation : <b><?= $grantee_grant->validation_status == VALID ? 'COMPLETE' : 'FAILED' ?></b>
                                </div>
                                <?php } else { ?>
                                    <div 
                                        class="p-3 bg-warning text-warning my-5 text-center" 
                                        style="border-radius:5px;">
                                        Status Selection Review : <b>IN PROGRESS</b>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="interview" class="tab-pane fade <?= $default_content_active ?> <?= $pid == 'interview' || $pid == 'interviewbio' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <ul class="nav nav-pills ml-5">
                                    <li <?php echo $default_tab_active ?>><a data-toggle="tab" href="#info" aria-expanded="true">Interview Info</a></li>
                                    <li <?= $pid == 'interview' ? 'class="active"' : '' ?>><a data-toggle="tab" href="#bank" aria-expanded="true">Bank Info</a></li>
                                    <li <?= $pid == 'interviewbio' ? 'class="active"' : '' ?>><a data-toggle="tab" href="#biosketch" aria-expanded="true">Biosketch</a></li>
                                <ul>
                            </div>
                            <div class="tab-content">  
                                <div id="info" class="tab-pane fade <?= $default_content_active ?>">
                                    <div class="panel-body">
                                        <div class="col-lg-5">
                                            <?php if($grantee_grant->interview_selection_status) { ?>
                                            <?php $bgcolor = $grantee_grant->interview_selection_status != NOT_RECOMMENDED ? 'success' : 'danger'; ?>
                                            <!-- <div 
                                                class="p-3 bg-<?= $bgcolor ?> text-<?= $bgcolor ?> my-5 text-center" 
                                                style="border-radius:5px;">
                                                Status Interview Selection : <b><?= $grantee_grant->interview_selection_status != NOT_RECOMMENDED ? 'COMPLETE' : 'FAILED' ?></b>
                                            </div> -->
                                            <?php } else { ?>
                                                <!-- <div 
                                                    class="p-3 bg-warning text-warning my-5 text-center" 
                                                    style="border-radius:5px;">
                                                    Status Selection Review : <b>IN PROGRESS</b>
                                                </div> -->
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php //foreach ($interview_selection as $key => $interview) : ?>
                                    <?php //if($key > 0) { echo "<hr>"; } ?>
                                    <div class="panel-body">
                                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Interview Selection</p>
                                        <div class="col-lg-6">
                                            <div class="row form-group">
                                                <div class="col-lg-4">
                                                    <label>Date</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" value="<?= $grantee_grant->date_interview ? date('d M Y', strtotime($grantee_grant->date_interview)) : '' ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-4">
                                                    <label>Time</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input class="form-control datepicker" value="<?= $grantee_grant->date_interview ? date('H:i', strtotime($grantee_grant->date_interview)) : '' ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-4">
                                                    <label>Venue</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <!-- <input type="text" class="form-control" value="<?= $grantee_grant->location ?>" readonly> -->
                                                    <textarea class="form-control" cols="30" rows="5" readonly><?= $grantee_grant->location ?></textarea>
                                                </div>
                                            </div>
                                            <!-- <div class="row form-group">
                                                <div class="col-lg-4">
                                                    <label>Status Panelist</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" value="<?= get_status_panellist($grantee_grant->status_panellist_id) ?>" readonly>
                                                </div>
                                            </div> -->
                                            <!-- <div class="row form-group">
                                                <div class="col-lg-4">
                                                    <label>Score</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" value="<?= $grantee_grant->score ?>" readonly>
                                                </div>
                                            </div> -->
                                            <div class="row form-group">
                                                <div class="col-lg-4">
                                                    <label>Interview Format</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" value="<?= $grantee_grant->interview_format ? strtoupper($grantee_grant->interview_format) : '' ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input id="show_transportation" class="select_show hide " value="<?= $grantee_grant->show_transportation_interview ?>" onchange="show_hide_transportation(this, 'interview', 0)">
                                    <input id="show_accomodation" class="select_show hide " value="<?= $grantee_grant->show_accomodation_interview ?>" onchange="show_hide_accomodation(this, 'interview', 0)">

                                    <div class="panel-body section-transportation-interview-0">
                                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                                        <div class="panel-body">
                                            <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                                                <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Departure City</label>
                                                <input type="text" class="form-control" placeholder="Departure City" name="origin_city" value="<?= $grantee_grant->origin_city?>" <?= $grantee_grant->show_transportation_interview == 'Reimbursement' ? '' : 'disabled' ?>>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Destination City</label>
                                                <input type="text" class="form-control" placeholder="Destination City" name="destination_city" value="<?= $grantee_grant->destination_city ?>" <?= $grantee_grant->show_transportation_interview == 'Reimbursement' ? '' : 'disabled' ?>>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Departure Date</label>
                                                <input type="text" class="form-control datepicker" placeholder="Departure Date" name="departure_date" value="<?= $grantee_grant->departure_date ? date('d M Y', strtotime($grantee_grant->departure_date)) : '' ?>" <?= $grantee_grant->show_transportation_interview == 'Reimbursement' ? '' : 'disabled' ?>>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Returning Date</label>
                                                <input type="text" class="form-control datepicker" placeholder="Returning Date" name="returning_date" value="<?= $grantee_grant->returning_date ? date('d M Y', strtotime($grantee_grant->returning_date)) : '' ?>" <?= $grantee_grant->show_transportation_interview == 'Reimbursement' ? '' : 'disabled' ?>>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label id="label_eticket_interview_0">E-Ticket</label>
                                                <input type="file" class="form-control <?= $grantee_grant->show_transportation_interview == 'Reimbursement' ? '' : 'hide' ?>" name="eticket">
                                                <!-- <small class="file-for-testing">File Size Max 5MB</small> -->
                                                <?php if($grantee_grant->eticket) { ?>
                                                    <br>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                        <a href="<?php echo site_url($grantee_grant->eticket); ?>" class="lightbox" aria-haspopup="dialog">
                                                            <img id="preview_image_profile" data-old="<?php echo site_url($grantee_grant->eticket); ?>" src="<?php echo get_preview($grantee_grant->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                        </a>
                                                        <a href="<?php echo base_url($grantee_grant->eticket) ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($grantee_grant->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
                                                            <i class="fa fa-download fa-fw"></i>
                                                        </a>
                                                    </div>
                                                    <!-- <a href="<?= base_url($grantee_grant->eticket) ?>" class="btn btn-primary lightbox">View</a> -->
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-body section-accomodation-interview-0">
                                        <div class="col-lg-12">
                                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Check In Date</label>
                                                <input type="text" class="form-control datepicker" placeholder="Check In Date" name="checkin_date" value="<?= $grantee_grant->checkin_date ? date('d M Y', strtotime($grantee_grant->checkin_date)) : '' ?>" <?= $grantee_grant->show_accomodation_interview == 'Reimbursement' ? '' : 'disabled' ?>>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Check Out Date</label>
                                                <input type="text" class="form-control datepicker" placeholder="heck Out Date" name="checkout_date" value="<?= $grantee_grant->checkout_date ? date('d M Y', strtotime($grantee_grant->checkout_date)) : '' ?>" <?= $grantee_grant->show_accomodation_interview == 'Reimbursement' ? '' : 'disabled' ?>>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label id="label_voucher_hotel_interview_0">Hotel Voucher</label>
                                                <input id="voucher_hotel_<?= $key ?>" type="file" class="form-control <?= $grantee_grant->show_accomodation_interview == 'Reimbursement' ? '' : 'hide' ?>" name="voucher_hotel">
                                                <?php if($grantee_grant->voucher_hotel) { ?>
                                                    <br>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                        <a href="<?php echo site_url($grantee_grant->voucher_hotel); ?>" class="lightbox" aria-haspopup="dialog">
                                                            <img id="preview_image_profile" data-old="<?php echo site_url($grantee_grant->voucher_hotel); ?>" src="<?php echo get_preview($grantee_grant->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                        </a>
                                                        <a href="<?php echo base_url($grantee_grant->voucher_hotel) ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($grantee_grant->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
                                                            <i class="fa fa-download fa-fw"></i>
                                                        </a>
                                                    </div>
                                                    <!-- <a href="<?= base_url($grantee_grant->voucher_hotel) ?>" class="btn btn-primary lightbox">View</a> -->
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body pull-right <?= $grantee_grant->show_transportation_interview == 'Reimbursement' || $grantee_grant->show_accomodation_interview == 'Reimbursement' ? '' : 'hide' ?>">
                                        <button type="submit" class="btn btn-success" name="btn" value="btn-save-info" id="btn-save-biosketch">Save</button>
                                    </div>

                                    <div class="panel-body hide">
                                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Payment</p>
                                        <?php foreach($payment_items as $p_item) { ?>
                                            <?php if($p_item->proof_of_payment) { ?>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label><?= $p_item->payment_item_name ?></label>
                                                    <?php if($p_item->proof_of_payment) { ?>
                                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                                            <a href="<?php echo site_url($p_item->proof_of_payment); ?>" class="lightbox" aria-haspopup="dialog">
                                                                <img id="preview_image_profile" data-old="<?php echo site_url($p_item->proof_of_payment); ?>" src="<?php echo get_preview($p_item->proof_of_payment); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                            </a>
                                                            <a href="<?php echo base_url($p_item->proof_of_payment) ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($p_item->proof_of_payment) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
                                                                <i class="fa fa-download fa-fw"></i>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <?php //endforeach; ?>

                                    <!-- <div class="panel-body" style="margin-top:-20px;">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Scoring sheet</label>
                                                <?php if ($grantee_grant->scoring_sheet_interview != '') { ?>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                        <a href="<?php echo base_url() ?><?php echo $grantee_grant->scoring_sheet_interview ?>" target="_blank"><label class="btn btn-primary" style="cursor:pointer">View</label></a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <div id="bank" class="tab-pane fade <?= $pid == 'interview' ? 'active in' : '' ?>">
                                    <form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
                                    <div id="wrap-bank">
                                    <?php if(empty($bank_info)) { ?>
                                    <div id="bank-item-0" class="bank-item" style="position:relative">
                                        <div class="panel-body mt-3">
                                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BANK INFO</p>
                                            <div class="col-lg-12">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <div class="checkbox checbox-switch switch-primary">
                                                            <label style="margin-left: -15px;">
                                                                <input type="checkbox" name="bank_info[0][check_default]" checked class="check_default" />
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
                                                    <input type="text" class="form-control bank-name" name="bank_info[0][bank_name]" id="bank_name" placeholder="Bank Name">
                                                    <div class="text-danger invalid-tooltip bank-name-validation hide" style="display: block;">Bank Name is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Bank Address</label>
                                                    <input type="text" class="form-control bank-address" name="bank_info[0][bank_address]" id="bank_address" placeholder="Bank Address">
                                                    <div class="text-danger invalid-tooltip bank-address-validation hide" style="display: block;">Bank Address is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Beneficiary Name</label>
                                                    <input type="text" class="form-control beneficiary-name" name="bank_info[0][beneficiary_name]" placeholder="Beneficiary Name">
                                                    <div class="text-danger invalid-tooltip beneficiary-name-validation hide" style="display: block;">Beneficiary Name is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Account Number</label>
                                                    <input type="text" class="form-control account-number" name="bank_info[0][account_number]" id="account_number" placeholder="Account Number">
                                                    <div class="text-danger invalid-tooltip account-number-validation hide" style="display: block;">Account Number is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Routing Number</label>
                                                    <input type="text" class="form-control" name="bank_info[0][routing_number]" id="routing_number" placeholder="Routing Number">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Swift Code</label>
                                                    <input type="text" class="form-control" name="bank_info[0][swift_code]" id="swift_code" placeholder="Swift Code">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Currency</label>
                                                    <select class="form-control" name="bank_info[0][currency]" id="currency">
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
                                                    <label>Note</label>
                                                    <textarea class="form-control" rows="2" name="bank_info[0][note_bank]"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>First page of bank account information (buku tabungan halaman pertama)</label>
                                                    <input type="file" name="account_book_0" id="account_book" onchange="show_preview(this, 'void_check');">
                                                    <small>File Size Max 5MB</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <?php
                                        $notselect = true;
                                        $checkselect = array_column($bank_info, 'is_selected');
                                        if(in_array(1, $checkselect)){$notselect = false;}
                                        foreach($bank_info as $key => $bank) : 
                                    ?>
                                    <div id="bank-item-<?= $key ?>" class="bank-item" style="position:relative">
                                        <div class="panel-body <?= $key == 0 ? 'mt-3' : '' ?>">
                                            <?php if($key == 0) { ?>
                                                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> BANK INFO</p>
                                            <?php } ?>
                                            <?php if($key > 0) { ?>
                                                <hr>
                                            <?php } ?>
                                            <div class="col-lg-12">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <div class="checkbox checbox-switch switch-primary">
                                                            <label style="margin-left: -15px;">
                                                                <input type="checkbox" name="bank_info[<?= $key ?>][check_default]" <?= $bank->is_selected == 1 || ($notselect && $key == 0) ? 'checked' : '' ?> class="check_default" />
                                                                <span></span>
                                                                Select as Default
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if($key > 0) { ?>
                                                    <div class="col-lg-6">
                                                        <a href="javascript:;" onclick="del_item_db(this, 'bank-item', <?= $bank->id ?>)" class="btn btn-danger" style="float:right;"><i class="fa fa-trash fa-fw"></i></a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <input type="text" class="form-control bank-name" name="bank_info[<?= $key ?>][bank_name]" id="bank_name" placeholder="Bank Name" value="<?= $bank->bank_name ?>">
                                                    <input type="hidden" name="bank_info[<?= $key ?>][id]" value="<?= $bank->id ?>">
                                                    <div class="text-danger invalid-tooltip bank-name-validation hide" style="display: block;">Bank Name is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Bank Address</label>
                                                    <input type="text" class="form-control bank-address" name="bank_info[<?= $key ?>][bank_address]" id="bank_address" placeholder="Bank Address"  value="<?= $bank->bank_address ?>">
                                                    <div class="text-danger invalid-tooltip bank-address-validation hide" style="display: block;">Bank Address is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Beneficiary Name</label>
                                                    <input type="text" class="form-control beneficiary-name" name="bank_info[<?= $key ?>][beneficiary_name]" placeholder="Beneficiary Name"  value="<?= $bank->beneficiary_name ?>">
                                                    <div class="text-danger invalid-tooltip beneficiary-name-validation hide" style="display: block;">Beneficiary Name is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Account Number</label>
                                                    <input type="text" class="form-control account-number" name="bank_info[<?= $key ?>][account_number]" id="account_number" placeholder="Account Number" value="<?= $bank->account_number ?>">
                                                    <div class="text-danger invalid-tooltip account-number-validation hide" style="display: block;">Account Number is Required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Routing Number</label>
                                                    <input type="text" class="form-control" name="bank_info[<?= $key ?>][routing_number]" id="routing_number" placeholder="Routing Number" value="<?= $bank->routing_number ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Swift Code</label>
                                                    <input type="text" class="form-control" name="bank_info[<?= $key ?>][swift_code]" id="swift_code" placeholder="Swift Code" value="<?= $bank->swift_code ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Currency</label>
                                                    <select class="form-control" name="bank_info[<?= $key ?>][currency]" id="currency">
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
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Note</label>
                                                    <textarea class="form-control" rows="2" name="bank_info[<?= $key ?>][note_bank]"><?= $bank->note_bank ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>First page of bank account information (buku tabungan halaman pertama)</label>
                                                    <?php if ($bank->account_book != '') { ?>
                                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                                            <a href="<?php echo base_url() ?><?php echo $bank->account_book ?>" class="lightbox" aria-haspopup="dialog">
                                                                <img id="preview_image_void_check" src="<?php echo get_preview($bank->account_book) ?>" width="100">
                                                            </a>
                                                            <a href="javascript:;" onclick="del_file(this, 'account_book', 'First page of bank account information (buku tabungan halaman pertama)')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28px;">
                                                                <i class="fa fa-trash fa-fw"></i>
                                                            </a>
                                                            <a href="<?php echo base_url() ?><?php echo $bank->account_book ?>" download title="Click to download" class="btn btn-primary btn-xs mt-5" style="position:absolute; top:0; right:-28px;">
                                                                <i class="fa fa-download fa-fw"></i>
                                                            </a>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div id="preview_section_void_check" style="margin-bottom: 10px; position:relative; width:100px; display:none;">
                                                            <a>
                                                                <img id="preview_image_void_check" width="100">
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <input type="file" name="account_book_<?= $key ?>" id="account_book" onchange="show_preview(this, 'void_check');">
                                                    <small>File Size Max 5MB</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                    <?php } ?>
                                    </div>
                                    <div class="panel-body">
                                        <button type="button" class="btn btn-primary" onclick="add_new_bank()">Add New</button>
                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load" style="display:none;">
                                    </div>
                                    <div class="panel-body pull-right">
                                        <button type="submit" class="btn btn-success" id="btn-save-bank" value="btn-save-bank" name="btn">Save</button>
                                    </div>
                                    </form>
                                </div>
                                <div id="biosketch" class="tab-pane fade <?= $pid == 'interviewbio' ? 'active in' : '' ?>">
                                    <form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
                                        <div class="panel-body mt-3">
                                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Biosketch</p>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <!-- <label>Biosketch</label> -->
                                                    <textarea rows="8" name="biosketch" id="biosketch" class="form-control" <?= $grantee_grant->enable_biosketch ? '' : 'disabled' ?>><?= $grantee_grant->short_bio_field ?></textarea>
                                                    <div class="text-danger invalid-tooltip biosketch-validation hide" style="display: block;">Biosketch is Required</div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($grantee_grant->enable_biosketch) { ?>
                                        <div class="panel-body pull-right">
                                            <button type="submit" class="btn btn-success" name="btn" value="btn-save-biosketch" id="btn-save-biosketch">Save</button>
                                        </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>