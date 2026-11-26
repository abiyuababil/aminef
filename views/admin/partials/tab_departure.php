<style>
    .panel-default .panel-heading-departure{
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
</style>
<form id="form" method="POST" enctype="multipart/form-data">
<input type="hidden" name="user_grantee_id" id="user_grantee_id" value="<?= $grantee_grant->user_grantee_id ?>">
<input type="hidden" name="departure_id" id="departure_id" value="<?= $departure->id ?>">
<input type="hidden" name="btn" id="btn_value">
<input type="hidden" id="interview_appointment" value="<?= $visa_interview->appointment_located ?>">
<div class="row warp-alumni-page">
    <div class="col-lg-12">
        <div class="tabs">
            <ul>
                <?php if(has_permission('nominee', 'departure') || (!$is_admin && $grantee_grant->set_to_departure_document)) { ?>
                <li onclick="navigate_tab('departure_documents')">
                    <a aria-expanded="true" data-toggle="tab" href="#departure_documents">Departure Documents</a>
                </li>
                <?php } ?>
                <?php //if($is_admin || (!$is_admin && $grantee_grant->set_to_visa_interview)) { ?>
                <!-- <li onclick="navigate_tab('visa_interview')">
                    <a aria-expanded="true" data-toggle="tab" href="#visa_interview">Visa Interview</a>
                </li> -->
                <?php //} ?>
                <?php //if(($grantee_grant->set_to_travel_arrangement)) { ?>
                <!-- <li onclick="navigate_tab('travel_arrangement')">
                    <a aria-expanded="true" data-toggle="tab" href="#travel_arrangement">Travel Arrangement</a>
                </li> -->
                <?php //} ?>
                <?php //if($is_admin || (!$is_admin && $grantee_grant->set_to_departure_package)) { ?>
                <!-- <li onclick="navigate_tab('departure_package')" class="section-obtaining">
                    <a aria-expanded="true" data-toggle="tab" href="#departure_package">Departure Package</a>
                </li> -->
                <?php //} ?>
                <?php //if($is_admin || (!$is_admin && $grantee_grant->set_to_pre_departure_allowance)) { ?>
                <!-- <li onclick="navigate_tab('pre_departure_allowance')">
                    <a aria-expanded="true" data-toggle="tab" href="#pre_departure_allowance">Pre-Departure Allowance</a>
                </li> -->
                <?php //} ?>
            </ul>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content">

                        <?php if($is_admin || (!$is_admin && $grantee_grant->set_to_departure_document)) { ?>
                        <?php if(has_permission('nominee', 'departure') || !$is_admin) { ?>
                        <div id="departure_documents" class="active in first_tab">
                            <?php if($is_admin) { ?>
                            <?php if(!$is_alumni_page) { ?>
                            <div class="row mb-5">
                                <div class="col-lg-12">
                                    <div class="TriSea-technologies-Switch">
                                        <span class="mr-2"> Set to Departure Documents</span>
                                        <input id="set_to_departure_document" onchange="setToDepartureDocument(this, <?= $grantee_grant->id ?>)" name="set_to_departure_document" type="checkbox" <?= $grantee_grant->set_to_departure_document  ? 'checked' : '' ?>/>
                                        <label for="set_to_departure_document" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } ?>
                            <div class="panel-group" id="accordionOne" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Leave Approval Letter from Home Institution
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseOne" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'support_letter' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <input type="hidden" name="delete_support_letter" id="delete_support_letter">
                                        <?php if($is_admin){ ?>
                                        <?php if(!$is_alumni_page) { ?>
                                        <div class="col-lg-12 mb-4">
                                            <div class="TriSea-technologies-Switch">
                                                <span class="mr-2" style="font-weight: 700;">Enable Support Letter for Supervisor</span>
                                                <input onchange="setEnableSupportLetter(this, <?= $departure->id ?>)" id="disabled_support_letter" name="disabled_support_letter" type="checkbox" <?= !$departure->disabled_support_letter ? 'checked' : '' ?>/>
                                                <label for="disabled_support_letter" class="label-primary"></label>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php } ?>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label>Do you need a support letter to request for a leave approval letter from your employer/home institution to participate in the program?</label>
                                                <select id="support_letter" class="form-control" name="need_support_letter" style="width:100%" <?= $departure->disabled_support_letter == 'on' && !$is_admin ? 'disabled' : '' ?>>
                                                    <option value="">-- Select --</option>
                                                    <option <?= $departure->support_letter_departure == 'Yes' ? 'selected' : ''?> value="Yes">Yes</option>
                                                    <option <?= $departure->support_letter_departure == 'No' ? 'selected' : ''?> value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="section-yes" class="col-lg-8 <?= $departure->support_letter_departure == 'No' || $departure->support_letter_departure == '' ? 'hide' : ''?>">
                                            <div id="wrap-yes-support-letter">
                                                <?php if($data_support_letter) : ?>
                                                    <?php foreach($data_support_letter as $key => $row) { ?>
                                                        <div id="support-letter-item-<?= $key ?>" class="support-letter-item">
                                                            <?php if($key != 0) { ?>
                                                                <hr style="border: 1px solid #eee;">
                                                                <?php if($is_admin || $departure->disabled_support_letter == '' ) { ?>
                                                                <div class="form-group mb-1">
                                                                    <a href="javascript:;" onclick="del_item_support_letter(this, 'support-letter-item', <?= $row->id ?>)" class="btn btn-danger" style="float:right;color:#fff;"><i class="fa fa-trash fa-fw"></i></a>
                                                                </div>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <div class="form-group">
                                                                <label>Name of Supervisor</label>
                                                                <input <?= $departure->disabled_support_letter == 'on' && !$is_admin ? 'disabled' : '' ?> type="text" id="name_supervisior" class="form-control" name="support_letter[<?= $key ?>][name_supervisior]" value="<?= $row->name ?>">
                                                                <input type="hidden" name="support_letter[<?= $key ?>][support_letter_departure_id]" value="<?= $row->id ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Position</label>
                                                                <input <?= $departure->disabled_support_letter == 'on' && !$is_admin ? 'disabled' : '' ?> type="text" id="position" class="form-control" name="support_letter[<?= $key ?>][position]" value="<?= $row->position ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Institution</label>
                                                                <input <?= $departure->disabled_support_letter == 'on' && !$is_admin ? 'disabled' : '' ?> type="text" id="institution" class="form-control" name="support_letter[<?= $key ?>][institution]" value="<?= $row->institution ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <textarea <?= $departure->disabled_support_letter == 'on' && !$is_admin ? 'disabled' : '' ?> id="address" class="form-control" name="support_letter[<?= $key ?>][address]"><?= $row->address ?></textarea>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php else : ?>
                                                    <div id="support-letter-item-0" class="support-letter-item">
                                                        <div class="form-group">
                                                            <label>Name of Supervisor</label>
                                                            <input <?= $departure->disabled_support_letter == 'on' && !$is_admin ? 'disabled' : '' ?> type="text" id="name_supervisior" class="form-control" name="support_letter[0][name_supervisior]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Position</label>
                                                            <input <?= $departure->disabled_support_letter == 'on' && !$is_admin ? 'disabled' : '' ?> type="text" id="position" class="form-control" name="support_letter[0][position]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Institution</label>
                                                            <input <?= $departure->disabled_support_letter == 'on' && !$is_admin ? 'disabled' : '' ?> type="text" id="institution" class="form-control" name="support_letter[0][institution]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <textarea <?= $departure->disabled_support_letter == 'on' && !$is_admin ? 'disabled' : '' ?> id="address" class="form-control" name="support_letter[0][address]"></textarea>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 section-add-new <?= $departure->support_letter_departure == 'No' || $departure->support_letter_departure == '' ? 'hide' : ''?>">
                                            <?php if(($departure->disabled_support_letter != 'on' && !$is_admin) || $is_admin) { ?>
                                            <?php if(!$is_alumni_page) { ?>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" onclick="add_new()">Add New <img src="<?=base_url() ?>/img/loading.gif" class="add-load" style="display:none;"></button>
                                            </div>
                                            <?php } ?>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-8 <?= $departure->support_letter_departure == 'Yes' || $departure->support_letter_departure == '' ? 'hide' : ''?>" id="no-support-letter">
                                            <div class="form-group">
                                                <label>Please provide a statement to explain your reason for not returning to your home institution after completion of the program. <span class="text-danger">*</span></label>
                                                <textarea <?= !$is_admin && $departure->disabled_support_letter ? 'disabled' : '' ?> id="reason" name="reason_support_letter" class="form-control"><?= $departure->reason_support_letter ?></textarea>
                                            </div>
                                        </div>
                                        <?php //if($grantee_grant->letter_for_supervisor) { ?>
                                        <div class="col-lg-12 section-add-new <?= $departure->support_letter_departure == 'No' || $departure->support_letter_departure == '' ? 'hide' : ''?>">
                                            <div class="form-group">
                                                <?php if($is_admin || $departure->letter_for_supervisor) { ?>
                                                <label>Letter for Supervisor</label><br />
                                                <?php } ?>
                                                <?php if($is_admin) { ?>
                                                        <img data-trigger="my_file_lfs" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_lfs" class="preview_image_lfs lightbox" src="<?php echo $departure->letter_for_supervisor ? get_preview($departure->letter_for_supervisor) : base_url('assets/images/icons/add-file.png'); ?>">
                                                        <br />
                                                        <?php if(!$is_alumni_page) { ?>
                                                        <a href="javascript:;" id="my_file_lfs" class="btn btn-primary upload-lfs mt-3" data-file-value="upload_letter_for_supervisor_template" style ="color:#fff;">Upload</a>
                                                        <?php } ?>
                                                        <a href="<?= base_url($departure->letter_for_supervisor) ?>" class="btn btn-warning fileview-lfs lightbox mt-3 <?= $departure->letter_for_supervisor ? '' : 'hide' ?>" style ="color:#fff;"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                        <?php if(!$is_alumni_page) { ?>
                                                        <a href="javascript:;" onclick="delete_lfs(this)" class="btn btn-danger delete-lfs mt-3 <?= $departure->letter_for_supervisor ? '' : 'hide' ?>" style ="color:#fff;"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php } ?>
                                                        <input onchange="show_preview(this, '_lfs')" type="file" data-doc="letter_for_supervisor" class="upload_letter_for_supervisor_template hide">
                                                <?php } else { ?>
                                                    <?php if($departure->letter_for_supervisor) { ?>
                                                    <a href="<?= base_url($departure->letter_for_supervisor) ?>" download title="Click to Download" class="btn btn-primary" style="color:#fff">
                                                        <i class="fa fa-download fa-fw text-white"></i> Download Letter for Supervisor
                                                    </a>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php //} ?>
                                        <?php if($is_admin || $departure->letter_for_supervisor) { ?>
                                        <div class="col-lg-12 section-add-new <?= $departure->support_letter_departure == 'No' || $departure->support_letter_departure == '' ? 'hide' : ''?>">
                                            <div class="form-group">
                                                <label>Leave Approval Letter</label>
                                                <br />
                                                <?php if(!$is_alumni_page) { ?>
                                                <button type="button" class="btn btn-primary upload_leave_approval" data-toggle="modal" data-target="#upload_leave_approval">Add Leave Approval Letter</button>
                                                <?php } ?>
                                            </div>
                                            <table class="table table-striped table-bordered table-responsive mt-4">
                                                <thead>
                                                    <tr>
                                                        <th>Leave Approval Letter</th>
                                                        <th>Extension</th>
                                                        <th>Upload Date</th>
                                                        <?php //if($is_admin) { ?>
                                                        <?php if(!$is_alumni_page) { ?>
                                                        <th>Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody id="leave_approval_list">
                                                    <?php
                                                        foreach($data_am_leave_approval_letter as $leave_approval_letter) { 
                                                        $detail_file = [];
                                                        $file_letter_for_supervisor = '';
                                                        if($leave_approval_letter->file){
                                                            $approval_letter = explode('/', $leave_approval_letter->file);
                                                            $file_letter_for_supervisor = $approval_letter ? end($approval_letter) : '';
                                                            $detail_file = $approval_letter ? explode('.', $file_letter_for_supervisor) : '';
                                                        }

                                                    ?>
                                                    <tr>
                                                        <td><a href="<?= base_url($leave_approval_letter->file) ?>" class="lightbox" style="color:#337ab7"><?= $file_letter_for_supervisor ?></a></td>
                                                        <td><?= end($detail_file) ?></td>
                                                        <td><?= $departure->upload_date_leave_approval_letter ?></td>
                                                        <?php //if($is_admin) { ?>
                                                        <?php if(!$is_alumni_page) { ?>
                                                        <td>
                                                            <!-- <a 
                                                                class="btn btn-primary btn-xs upload_departure upload_letter_for_supervisor" 
                                                                data-id="33" 
                                                                data-toggle="modal" 
                                                                data-target="#upload_letter_for_supervisor"
                                                                data-section="Leave Approval Letter"
                                                                style="color:#fff"
                                                            >
                                                                Upload
                                                            </a> -->
                                                            
                                                            <a href="javascript:;" onclick="del_data_leave_approval(this, <?= $leave_approval_letter->id ?>, <?= $is_admin ?>)" class="btn btn-danger btn-xs" style="color:#fff">
                                                                <i class="fa fa-trash fa-fw text-white"></i>
                                                            </a>
                                                        </td>
                                                        <?php 
                                                            } 
                                                        }
                                                        ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Medical Form 
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseTwo" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'medical' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>
                                                    As medical checkup is still part of the selection process, you are responsible for paying the costs incurred <br />
                                                    Complete and submit the Medical Form in a single .pdf file and do not separate each page into different files (the maximum file size is 1 Mb).
                                                </label>
                                                <!-- <input type="file" class="form-control"> -->

                                                <?php if($is_admin) { ?>
                                                <?php if(!$is_alumni_page) { ?>
                                                <br />
                                                <button type="button" class="btn btn-primary upload_medical" data-toggle="modal" data-target="#upload_medical">Add Medical Clearance</button>
                                                <?php } ?>
                                                <?php } ?>
                                                <table class="table table-striped table-bordered table-responsive mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th>Template File</th>
                                                            <th>Extension</th>
                                                            <th>Deadline Date</th>
                                                            <th>File Upload</th>
                                                            <th>Status</th>
                                                            <th>Upload Date</th>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="medical_list">

                                                        <!-- DATA TEMPLATE MEDICAL -->
                                                        <?php 
                                                            if($grantee_grant->medical_departure) {
                                                                $medical_file = explode('/', $grantee_grant->medical_departure);
                                                                $fileMedical = $medical_file ? end($medical_file) : '';
                                                                $detail_file = $medical_file ? explode('.', $fileMedical) : '';
                                                        ?>

                                                        <tr>
                                                            <td>
                                                                <a href="<?= base_url($grantee_grant->medical_departure) ?>" class="lightbox" style="color:#337ab7">
                                                                    <?= $fileMedical ?>
                                                                </a>
                                                            </td>
                                                            <td><?= end($detail_file) ?></td>
                                                            <td class="text-danger"><?= $file_medical_template->deadline_date ? date('Y-m-d H:i', strtotime($file_medical_template->deadline_date)) : '' ?></td>
                                                            <td>
                                                                <a href="<?= base_url($file_medical_template->file) ?>" class="lightbox" style="color:#337ab7"><?= $file_medical_template->filename ?></a>
                                                                <a href="<?= base_url($file_medical_template->file) ?>" download="<?= get_full_name($grantee_grant) ?>_Medical Form" class="btn btn-info btn-xs" style="color:#fff"><i class="fa fa-download fa-fw text-white"></i></a>
                                                            </td>
                                                            <td>
                                                                <?= $file_medical_template->status ?>
                                                                <?php if($file_medical_template->status == 'Revise') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-placement="top" data-note="<?= $file_medical_template->note ?>" data-attach='<?= $file_medical_template->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                                <?php if($file_medical_template->status == 'Rejected') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-placement="top" data-note="<?= $file_medical_template->note_reject ?>" data-attach='<?= $file_medical_template->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $file_medical_template->created_date ?></td>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <td>
                                                                <input type="hidden" name="medical_departure_id" id="medical_departure_id" value="<?= $file_medical_template->id ?>">
                                                                <!-- <a href="<?= base_url($grantee_grant->medical_departure) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="color:#fff">
                                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                                </a> -->

                                                                <?php if(!$is_admin && $file_medical_template->status != 'Approve') { ?>
                                                                <input type="file" data-id="<?= $file_medical_template->id ?>" class="upload_medical_<?= $file_medical_template->id ?> hide">
                                                                <a class="btn btn-primary btn-xs upload_departure_item" data-id="<?= $file_medical_template->id ?>" style="color:#fff" data-file-value="upload_medical_<?= $file_medical_template->id ?>">Upload</a>
                                                                <?php } ?>

                                                                <?php if($is_admin) { ?>
                                                                <?php if($file_medical_template->file) { ?>
                                                                <a href="javascript:;" onclick="update_status_file_departure(this, <?= $file_medical_template->id ?>, 'approve', 'medical')" class="btn btn-success btn-xs" style="color:#fff">
                                                                    Approve
                                                                </a>
                                                                <a href="javascript:;" onclick="update_status_file_departure(this, <?= $file_medical_template->id ?>, 'revise', 'medical')" class="btn btn-warning btn-xs" style="color:#fff">
                                                                    Revise
                                                                </a>
                                                                <?php } ?>
                                                                <a class="btn btn-primary btn-xs add_deadline_departure_item" data-type="medical" data-id="<?= $file_medical_template->id ?>" style="color:#fff" data-toggle="modal" data-target="#add_deadline_medical">Add Deadline Date</a>
                                                                <input data-log="<?= $file_medical_template->id ?>" data-type="medical" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default modal-log-departure" value="Open Log" style="font-size:12px;">
                                                                <?php } ?>
                                                            </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php } ?>
                                                        <!-- END DATA TEMPLATE MEDICAL -->



                                                        <?php
                                                        foreach($file_medicals as $file_medical) { 
                                                            $fileMedical = '';
                                                            if($file_medical->file_admin){
                                                                $medical_file = explode('/', $file_medical->file_admin);
                                                                $fileMedical = $medical_file ? end($medical_file) : '';
                                                                $detail_file = $medical_file ? explode('.', $fileMedical) : '';
                                                            }

                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?= base_url($file_medical->file_admin) ?>" class="lightbox" style="color:#337ab7">
                                                                    <?= $fileMedical ?>
                                                                </a>
                                                            </td>
                                                            <td><?= end($detail_file) ?></td>
                                                            <td class="text-danger"><?= $file_medical->deadline_date ? date('Y-m-d H:i', strtotime($file_medical->deadline_date)) : '' ?></td>
                                                            <td>
                                                                <a href="<?= base_url($file_medical->file) ?>" class="lightbox" style="color:#337ab7"><?= $file_medical->filename ?></a>
                                                                <a href="<?= base_url($file_medical->file) ?>" download="<?= get_full_name($grantee_grant) ?>_Medical Form" class="btn btn-primary ml-3 btn-xs" style="color:#fff"><i class="fa fa-download fa-fw text-white"></i></a>
                                                            </td>
                                                            <td>
                                                                <?= $file_medical->status ?>
                                                                <?php if($file_medical->status == 'Revise') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $file_medical->note ?>" data-attach='<?= $file_medical->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                                <?php if($file_medical->status == 'Rejected') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $file_medical->note_reject ?>" data-attach='<?= $file_medical->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $file_medical->created_date ?></td>
                                                            <td>
                                                                <input type="hidden" name="medical_departure_id" id="medical_departure_id" value="<?= $file_medical->id ?>">
                                                                <!-- <a href="<?= base_url($file_medical->file_admin) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="color:#fff">
                                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                                </a> -->

                                                                <?php if(!$is_admin && $file_medical->status != 'Approve') { ?>
                                                                <!-- <a 
                                                                    class="btn btn-primary btn-xs upload_departure upload_medical_departure" 
                                                                    data-id="33" 
                                                                    data-toggle="modal" 
                                                                    data-target="#upload_departure"
                                                                    data-section="Medical Form"
                                                                    data-getclass="upload_medical_departure"
                                                                    style="color:#fff"
                                                                >
                                                                    Upload
                                                                </a> -->
                                                                <input type="file" data-id="<?= $file_medical->id ?>" class="upload_medical_<?= $file_medical->id ?> hide">
                                                                <a class="btn btn-primary btn-xs upload_departure_item" data-id="<?= $file_medical->id ?>" style="color:#fff" data-file-value="upload_medical_<?= $file_medical->id ?>">Upload</a>
                                                                <?php } ?>

                                                                <?php if($is_admin) { ?>
                                                                <?php if($file_medical->file) { ?>
                                                                <a href="javascript:;" onclick="update_status_file_departure(this, <?= $file_medical->id ?>, 'approve', 'medical')" class="btn btn-success btn-xs" style="color:#fff">
                                                                    Approve
                                                                </a>
                                                                <a href="javascript:;" onclick="update_status_file_departure(this, <?= $file_medical->id ?>, 'revise', 'medical')" class="btn btn-warning btn-xs" style="color:#fff">
                                                                    Revise
                                                                </a>
                                                                <?php } ?>
                                                                <input data-log="<?= $file_medical->id ?>" data-type="medical" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default modal-log-departure" value="Open Log" style="font-size:12px;">
                                                                <a href="javascript:;" onclick="del_data_medical(this, <?= $file_medical->id ?>)" class="btn btn-danger btn-xs" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                                <?php } ?>
                                                                <?php //if($file_medical->file){ ?>
                                                                <!-- <a href="javascript:;" onclick="delete_file_departure(this, 'medical', <?= $file_medical->id ?>)" class="btn btn-danger btn-xs delete_file_medical" style="color:#fff">
                                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                                </a> -->
                                                                <?php //} ?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <a href="<?= base_url($grantee_grant->guideline_medical) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_medical ? '' : 'hide' ?>" style="color:#fff">
                                                    <i class="fa fa-download fa-fw text-white"></i> Download Guideline Medical Form
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Passport
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseThree" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'passport' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <?php if($is_admin && !$is_alumni_page) { ?>
                                            <div class="col-lg-12 mb-5">
                                                <div class="TriSea-technologies-Switch">
                                                    <span class="mr-2"> Show Support Letter for Passport</span>
                                                    <input data-granteegrantid="<?= $grantee_grant->id ?>" data-departureid="<?= $departure->id ?>" onchange="enable_toggle_support_passport(this, 'show_support_letter_passport')" id="show_support_letter_passport" name="show_support_letter_passport" type="checkbox" <?= $file_passport->show_support_letter_passport  ? 'checked' : '' ?>/>
                                                    <label for="show_support_letter_passport" class="label-primary"></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-5">
                                                <div class="TriSea-technologies-Switch">
                                                    <span class="mr-2"> Enable Support Letter for Passport</span>
                                                    <input data-granteegrantid="<?= $grantee_grant->id ?>" data-departureid="<?= $departure->id ?>" onchange="enable_toggle_support_passport(this, 'enable_support_letter_passport')" id="enable_support_letter_passport" name="enable_support_letter_passport" type="checkbox" <?= $file_passport->enable_support_letter_passport  ? 'checked' : '' ?>/>
                                                    <label for="enable_support_letter_passport" class="label-primary"></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if($is_admin || (!$is_admin && $file_passport->show_support_letter_passport)) { ?>
                                        <div class="col-lg-8 mb-5 section-support-letter-passport">
                                            <div class="form-group">
                                                <label>Name of Immigration Office</label>
                                                <input <?= !$file_passport->enable_support_letter_passport && !$is_admin ? 'disabled' : '' ?> type="text" id="name_of_immigration" class="form-control" name="name_of_immigration" value="<?= $file_passport->name_of_immigration ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Address of Immigration Office</label>
                                                <textarea <?= !$file_passport->enable_support_letter_passport && !$is_admin ? 'disabled' : '' ?> id="address_of_immigration" class="form-control" name="address_of_immigration"><?= $file_passport->address_of_immigration ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Candidate Full Name</label>
                                                <input <?= !$file_passport->enable_support_letter_passport && !$is_admin ? 'disabled' : '' ?> type="text" id="candidate_full_name" class="form-control" name="candidate_full_name" value="<?= $file_passport->candidate_full_name ?? get_full_name($grantee_grant, 'ID') ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Candidate Address</label>
                                                <input <?= !$file_passport->enable_support_letter_passport && !$is_admin ? 'disabled' : '' ?> type="text" id="candidate_address" class="form-control" name="candidate_address" value="<?= $file_passport->candidate_address ?? $grantee_grant->street ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>No Passport</label>
                                                <input <?= !$file_passport->enable_support_letter_passport && !$is_admin ? 'disabled' : '' ?> type="text" id="no_passport" class="form-control" name="no_passport" value="<?= $file_passport->no_passport ?? $grantee_grant->number_passport ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Date of Passport Validity</label>
                                                <input <?= !$file_passport->enable_support_letter_passport && !$is_admin ? 'disabled' : '' ?> type="text" id="date_of_passport_validity" class="datepicker form-control" name="date_of_passport_validity" value="<?= $file_passport->date_of_passport_validity ?>">
                                            </div>
                                            <div class="form-group <?= !$is_admin && $file_passport->support_letter_passport == '' ? 'hide' : '' ?>">
                                                <label>Support letter for passport</label>
                                                <input type="file" id="support_letter_passport" class="form-control <?= !$is_admin ? 'hide' : '' ?>" name="support_letter_passport">
                                                <?php if ($file_passport->support_letter_passport != '') { ?>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_support_letter_passport" class="mt-4">
                                                        <a href="<?=base_url() ?><?=$file_passport->support_letter_passport ?>" class="lightbox" aria-haspopup="dialog">
                                                            <img id="preview_image_profile" data-old="<?php echo site_url($file_passport->support_letter_passport); ?>" src="<?php echo get_preview($file_passport->support_letter_passport); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                        </a>
                                                        <a href="<?=base_url() ?><?=$file_passport->support_letter_passport ?>" id="button_download_img_photo" title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($file_passport->support_letter_passport) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                            <i class="fa fa-download fa-fw"></i>
                                                        </a>
                                                        <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer" class="<?= !$is_admin ? 'hide' : '' ?>">
                                                            <label class="btn btn-xs btn-danger" onclick="delete_support_letter_passport(this, <?= $file_passport->id ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <hr />
                                        </div>
                                        <?php } ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Submit your valid passport data page (the first four pages from passport data page until endorsement page) in PDF format (the maximum file size is 1 Mb. It must be valid through at least 6 months after the program end dates.</label>
                                                <!-- <input type="file" class="form-control"> -->

                                                <table class="table table-striped table-bordered table-responsive mt-4">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th>Template File</th>
                                                            <th>Extension</th> -->
                                                            <th>Deadline Date</th>
                                                            <th>File Upload</th>
                                                            <th>Status</th>
                                                            <th>Upload Date</th>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            // if($grantee_grant->passport_departure) {
                                                            // $medical_file = explode('/', $grantee_grant->passport_departure);
                                                            // $fileMedical = $medical_file ? end($medical_file) : '';
                                                            // $detail_file = $medical_file ? explode('.', $fileMedical) : '';

                                                        ?>
                                                        <tr>
                                                            <td class="text-danger"><?= $file_passport->deadline_date ? date('Y-m-d H:i', strtotime($file_passport->deadline_date)) : '' ?></td>
                                                            <td>
                                                                <?php if($file_passport->filename != '') { ?>
                                                                    <a href="<?= base_url($file_passport->file) ?>" class="lightbox" style="color:#337ab7"><?= $file_passport->filename ?></a>
                                                                    <a href="<?= base_url($file_passport->file) ?>" download="<?= get_full_name($grantee_grant) ?>_Passport" class="btn btn-primary ml-3 btn-xs" style="color:#fff"><i class="fa fa-download fa-fw text-white"></i></a>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?= $file_passport->status ?>
                                                                <?php if($file_passport->status == 'Revise') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-placement="top" data-note="<?= $file_passport->note ?>" data-attach='<?= $file_passport->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                                <?php if($file_passport->status == 'Rejected') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-note="<?= $file_passport->note_reject ?>" data-attach='<?= $file_passport->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $file_passport->created_date ?></td>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <td>
                                                                <input type="hidden" name="passport_departure_id" id="passport_departure_id" value="<?= $file_passport->id ?>">
                                                                <!-- <a href="<?= base_url($grantee_grant->passport_departure) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="color:#fff">
                                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                                </a> -->

                                                                <?php if(!$is_admin && $file_passport->status != 'Approve') { ?>
                                                                <a 
                                                                    class="btn btn-primary btn-xs upload_departure upload_passport_departure" 
                                                                    data-id="33" 
                                                                    data-toggle="modal" 
                                                                    data-target="#upload_departure"
                                                                    data-section="Passport"
                                                                    data-getclass="upload_passport_departure"
                                                                    style="color:#fff"
                                                                >
                                                                    Upload
                                                                </a>
                                                                <?php } ?>

                                                                <?php if($is_admin && $file_passport) { ?>
                                                                <?php if($is_admin && $file_passport->filename != '') { ?>
                                                                    <a href="javascript:;" onclick="update_status_file_departure(this, <?= $file_passport->id ?>, 'approve', 'passport')" class="btn btn-success btn-xs" style="color:#fff">
                                                                        Approve
                                                                    </a>
                                                                    <a href="javascript:;" onclick="update_status_file_departure(this, <?= $file_passport->id ?>, 'revise', 'passport')" class="btn btn-warning btn-xs" style="color:#fff">
                                                                        Revise
                                                                    </a>
                                                                <?php } ?>
                                                                <input data-log="<?= $file_passport->id ?>" data-type="passport" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default modal-log-departure" value="Open Log" style="font-size:12px;">
                                                                <?php } ?>
                                                                <?php //if($file_passport->file){ ?>
                                                                <!-- <a href="javascript:;" onclick="delete_file_departure(this, 'passport', <?= $file_passport->id ?>)" class="btn btn-danger btn-xs delete_file_passport" style="color:#fff">
                                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                                </a> -->
                                                                <?php //} ?>
                                                                <?php if($is_admin){ ?>
                                                                    <a class="btn btn-primary btn-xs add_deadline_departure_item_passport" data-type="passport" data-id="<?= $file_passport->id ?>" style="color:#fff" data-toggle="modal" data-target="#add_deadline_medical">Add Deadline Date</a>
                                                                <?php } ?>
                                                            </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php //} ?>
                                                    </tbody>
                                                </table>
                                                <a href="<?= base_url($grantee_grant->guideline_passport) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_passport ? '' : 'hide' ?>" style="color:#fff">
                                                    <i class="fa fa-download fa-fw text-white"></i> Download Guideline Passport
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(!$is_alumni_page) { ?>
                            <div class="panel-body">
                                <div class="pull-right">
                                    <?php if($is_admin) { ?>
                                    <a href="<?= $back_url ?>" class="btn btn-primary" style="color:#fff;">Back</a>
                                    <?php } ?>
                                    <button 
                                            type="button" 
                                            name="btn" 
                                            value="save_support_letter" 
                                            onclick="return validateAndSubmit()" 
                                            class="btn btn-success <?= 
                                                (
                                                    ($departure->disabled_support_letter == 'on' 
                                                    && !$file_passport->enable_support_letter_passport)
                                                    && !$is_admin
                                                ) ? 'hide' : '' 
                                            ?>">
                                        Save
                                    </button>
                                    <?php if($is_admin) { ?>
                                    <a href="#" data-id="<?= $grantee_grant->id ?>" data-section="departure" style="color:#fff;" class="btn btn-warning withdraw">Withdraw</a>
                                    <a href="#" data-id="<?= $grantee_grant->id ?>" data-section="departure" style="color:#fff;" class="btn btn-danger drop">Drop</a>
                                    <?php } ?>

                                    <!-- <button type="button" name="btn" value="save_support_letter" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_support_letter')" class="btn btn-success <?= !$file_passport->enable_support_letter_passport && !$is_admin ? 'hide' : '' ?>">Save</button> -->
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <?php } ?>

                        <?php //if($is_admin || (!$is_admin && $grantee_grant->set_to_visa_interview)) { ?>
                        <!-- VISA INTERVIEW -->
                        <!-- <div id="visa_interview" class="active in first_tab"> -->
                            <?php //$this->load->view('admin/partials/visa_interview'); ?>
                        <!-- </div> -->
                        <?php //} ?>

                        <!-- Travel Arrangement -->
                        <?php //if(($grantee_grant->set_to_travel_arrangement )) { ?>
                        <?php //} ?>

                        <!-- Departure Package -->
                        <?php //if($is_admin || (!$is_admin && $grantee_grant->set_to_departure_package)) { ?>
                        <!-- <div id="departure_package" class="active in first_tab section-obtaining">
                            <?php //if($is_admin) { ?>
                            <div class="row mb-5">
                                <div class="col-lg-12">
                                    <div class="TriSea-technologies-Switch">
                                        <span class="mr-2"> Set to Departure Package </span>
                                        <input id="set_to_departure_package" name="set_to_departure_package" type="checkbox" <?= $grantee_grant->set_to_departure_package  ? 'checked' : '' ?>/>
                                        <label for="set_to_departure_package" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <?php //} ?>
                            <div class="panel-group" id="accordionFour" role="tablist" aria-multiselectable="true">
                                <?php //$this->load->view('admin/partials/departure_package'); ?>
                            </div>
                            <?php //if($is_admin) { ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="pull-right">
                                        <button type="button" name="btn" value="save_visa_interview" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_visa_interview')" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div> -->
                            <?php //} ?>
                        </div>
                        <?php //} ?>

                        <!-- Pre-Departure Allowance -->
                        <?php if($is_admin || (!$is_admin && $grantee_grant->set_to_pre_departure_allowance)) { ?>
                        <div id="pre_departure_allowance" class="active in first_tab hide">
                            <?php if($is_admin) { ?>
                            <?php if(!$is_alumni_page) { ?>
                            <div class="row mb-5 toggle-pre-departure"> 
                                <div class="col-lg-12">
                                    <div class="TriSea-technologies-Switch">
                                        <span class="mr-2"> Set to Pre-Departure Allowance</span>
                                        <input id="set_to_pre_departure_allowance" name="set_to_pre_departure_allowance" type="checkbox" <?= $grantee_grant->set_to_pre_departure_allowance  ? 'checked' : '' ?>/>
                                        <label for="set_to_pre_departure_allowance" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } ?>
                            <div class="panel-group" id="accordionFive" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionFive" href="#collapseFivePDA" aria-expanded="false" aria-controls="collapseFivePDA" onclick="set_session('pd_allowance'); return get_visa(this);">
                                        <div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Pre-Departure Allowance
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseFivePDA" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'pd_allowance' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <?php if(has_permission('nominee', 'departure') || !$is_admin) { ?>
                                            <div class="form-group">
                                                <p>Your pre-departure allowance consist of:</p>
                                                <div class="panel-body">
                                                    <?php if($grantee_grant->visibility_travel_allowance) { ?>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Travel Allowance</label>
                                                            <input type="text" id="travel_allowance" class="form-control" name="travel_allowance" disabled value="<?= number_format($grantee_grant->travel_allowance) ?>">
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>

                                                <?php if($grantee_grant->visibility_settling_allowance || $grantee_grant->visibility_technology_allowance) { ?>
                                                <div class="panel-body" style="margin-bottom:-30px;">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Settling-in and Equipment Allowances</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>

                                                <?php if($grantee_grant->visibility_settling_allowance || $grantee_grant->visibility_technology_allowance) { ?>
                                                <div class="panel-body">
                                                <?php } ?>
                                                    <?php if($grantee_grant->visibility_settling_allowance) { ?>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Settling in Allowance</label>
                                                            <input type="text" id="settling_allowance" class="form-control" name="settling_allowance" disabled value="<?= number_format($grantee_grant->settling_allowance) ?>">
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php if($grantee_grant->visibility_technology_allowance) { ?>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Equipment Allowance</label>
                                                            <input type="text" id="technology_allowance" class="form-control" name="technology_allowance" disabled value="<?= number_format($grantee_grant->technology_allowance) ?>">
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                <?php if($grantee_grant->visibility_settling_allowance || $grantee_grant->visibility_technology_allowance) { ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="panel-body">
                                                    <p>AMINEF will transfer the allowances in US Dollar (USD) to your local account in Indonesia in a Rupiah (IDR) or US Dollar account (USD) account.
                                                    <br /><b><u>Note: AMINEF will NOT be held responsible for the exchange rate fluctuation upon receiving the fund in your account.</u></b></p>
                                                    <p>Please select of the available local bank account that you have included in your page at AMINEF Portal for us to transfer the allowances.</p>

                                                    <?php if($is_admin){ ?>
                                                    <div class="row my-5">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Bank Info</span>
                                                                <input id="enable_bank_info" name="enable_bank_info" type="checkbox" <?= $visa_interview->enable_bank_info  ? 'checked' : '' ?>/>
                                                                <label for="enable_bank_info" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="panel-body">
                                                        <div class="col-lg-8">
                                                            <div class="form-group">
                                                                <label>Bank Info</label>
                                                                <select id="bank_info_id" class="form-control select2" style="width:100%" form="form" name="bank_info_id" <?= $is_admin || (!$is_admin && $visa_interview->enable_bank_info) ? '' : 'disabled' ?>>
                                                                    <option value=''>-- Select --</option>
                                                                    <?php foreach ($bank_info as $kb => $bi) { ?>
                                                                        <option <?= $visa_interview->bank_info_id == $bi->id ? 'selected' : '' ?> value="<?= $bi->id ?>"><?= $bi->beneficiary_name ?> (<?= $bi->account_number ?>) - <?= $bi->bank_name ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Bank Name</label>
                                                                <input type="text" class="form-control" name="bank_name" id="bank_name" readonly placeholder="Bank Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Bank Address</label>
                                                                <input type="text" class="form-control" name="bank_address" id="bank_address" readonly placeholder="Bank Address">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Beneficiary Name</label>
                                                                <input type="text" class="form-control" name="beneficiary_name" id="beneficiary_name" readonly placeholder="Beneficiary Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Account Number</label>
                                                                <input type="text" class="form-control" name="account_number" id="account_number" readonly placeholder="Account Number">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Routing Number</label>
                                                                <input type="text" class="form-control" name="routing_number" id="routing_number" readonly placeholder="Routing Number">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Swift Code</label>
                                                                <input type="text" class="form-control" name="swift_code" id="swift_code" readonly placeholder="Swift Code">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Currency</label>
                                                                <input type="text" class="form-control" name="currency" id="currency" readonly placeholder="Currency">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>First page of bank account information (buku tabungan halaman pertama)</label>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                    <a href="" class="lightbox aimage hide" aria-haspopup="dialog">
                                                                        <img id="preview_image_account_book" src="" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="" id="button_download_account_book" download title="Click to download" class="btn btn-primary btn-xs mt-5 hide" style="position:absolute; top:-30px; right:-28px;color:#fff">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                </div>
                                                                <a href="" id="button_preview_account_book" class="btn btn-warning fileview lightbox preview-profile hide" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p><b>Note : </b><i>If you prefer to use a new bank account to receive the allowances which is not available in your application, you should input this information in the system. Go the “My Profile” page, click the “Personal Information” section, and then complete the required information in the “bank info” sub-section. </i></p>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(!$is_alumni_page) { ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="pull-right">
                                        <button type="button" name="btn" value="save_visa_interview_allowance" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_visa_interview_allowance')" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>


<div class="modal fade" id="upload_departure" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label id="labelTitle"></label>
                <input type="file" id="upload_to_grantee_file" name="file">
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">
                <input type="hidden" name="getclass" id="getclass">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-upload-departure">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_deadline_medical" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleDeadline">Add Deadline Date Medical</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label id="labelTitleDeadline">Deadline date Medical <span style='color:red'> *</span></label>
                <input type="text" class="form-control datetime" id="deadline_date_medical">
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">
                <input type="hidden" name="deadline_medical_id" id="deadline_medical_id">
                <input type="hidden" name="deadline_medical_type" id="deadline_medical_type">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-add-deadline-medical">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="upload_medical" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleMedical">Add Medical Clearance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label id="labelTitle">Medical Clearance</label>
                <input type="file" id="upload_medical_file" name="file">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
            <div class="form-group">
                <label id="labelTitle">Deadline date Medical <span style='color:red'> *</span></label>
                <input type="text" class="form-control datetime" id="upload_medical_deadline_date">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-upload-medical">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="upload_leave_approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleMedical">Add Leave Approval Letter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label id="labelTitle">Leave Approval Letter</label>
                <input type="file" id="upload_leave_approval_file" name="file">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-is_admin="<?= $is_admin ?>" id="btn-upload-leave-approval">Save</button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('admin/partials/modal_ds2019_departure'); ?>

<div class="modal fade" id="upload_letter_for_supervisor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label id="labelTitle"></label>
                <input type="file" id="upload_letter_for_supervisor_file" name="file">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-upload-support-letter">Save</button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('admin/partials/modal_log') ?>

<div class="modal fade" id="mdl_note_revise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Note</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="submission_plan_id" id="submission_plan_id">
                <div class="row" id="section_reason_rejection">
                    <div class="col-md-12">
                        <label>Attachment</label>
                        <label for="temp_attachment_revise" class="withdraw-attachment-area">
                            <input type="file" id="temp_attachment_revise" name="temp_attachment_revise" class="hide" onchange="show_preview_attch(this, 'attachment_revise', 'attachment_revise');">
                            <input type="text" id="attachment_revise" name="attachment_revise" class="hide">
                            <i class="fa fa-cloud-upload"></i>
                        </label>
                        <div class="col-md-12 text-center">
                            <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
				            <label>Note</label>
                            <textarea class="form-control" name="note_revise" id="note_revise" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-save-note" name="btn-submit" value="decline" class="btn btn-primary success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form_require_doc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Upload Required Documents</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label id="labelTitle">Passport</label>
                <input type="file" id="upload_file_passport" name="file">
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">
                <input type="hidden" name="getclass" id="getclass">
            </div>
            <div class="form-group">
                <label id="labelTitle">Phooto 5x5</label>
                <input type="file" id="upload_file_photo" name="file">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-upload-required-doc">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_note" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <textarea class="form-control note-note" disabled rows="6" style="resize: none;"></textarea>
            </div>
            <div class="mt-2 text-center">
                <a target="_blank" class="btn btn-primary" id="attach_revise">Attachment</a>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php $this->session->unset_userdata('last_tab'); ?>
<?php $this->session->unset_userdata('last_list'); ?>
<?php $this->load->view('admin/partials/form_appointment') ?>

<div class="modal fade" id="mdl_note_drop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reason Drop</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Attachment</label>
                        <label for="temp_attachment" class="withdraw-attachment-area">
                            <input type="file" id="temp_attachment" name="temp_attachment[]" multiple class="hide fields_reject" onchange="show_preview_attach(this, 'attachment_drop', 'attachment_drop');">
                            <input type="text" id="attachment_drop" name="attachment_drop" class="hide fields_reject">
                            <i class="fa fa-cloud-upload"></i>
                        </label>
                        <div class="col-md-12 text-center">
                            <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <textarea class="form-control" name="note_drop" id="note_drop" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn-save-note-drop" class="btn btn-primary success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>