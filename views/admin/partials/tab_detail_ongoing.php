<style>
    .ui-datepicker {
        z-index: 9999 !important;
    }
    ol.m {list-style-type: lower-latin;}
    .panel-default .panel-heading-ongoing{
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

    .sticky-col {
    position: sticky;
    background-color: #f9f9f9;
    z-index: 2;
    }

    .first-col {
        left: 2px;
        z-index: 3;
    }

    .second-col {
        left: 42px;
    }

    .third-col {
        left: 158px;
    }

    .needdatepicker {
        background-color: #fff !important;
    }
</style>
<form id="form" method="POST" enctype="multipart/form-data">
<input type="hidden" name="btn" id="btn_value">
<input type="hidden" id="interview_appointment_renewal" value="<?= $visa_renewal->appointment_located ?>">
<input type="hidden" id="is_admin" value="<?= $is_admin ?>">
<div class="row warp-alumni-page">
    <div class="col-lg-12">
        <div class="tabs">
            <ul>
                <li onclick="navigate_tab('general_information')">
                    <a aria-expanded="true" data-toggle="tab" href="#general_information">General Information</a>
                </li>
                <?php
                    if (
                        $grantee_grant->is_degree &&
                        $grantee_grant->show_study_information &&
                        (has_permission('on_going', 'detail') || !$is_admin)
                    ) {
                ?>
                <li onclick="navigate_tab('study_information')">
                    <a aria-expanded="true" data-toggle="tab" href="#study_information">Study Information</a>
                </li>
                <?php } ?>
                <?php if((has_permission('on_going', 'detail') && $grantee_grant->show_visa_renewal) || (!$is_admin && $grantee_grant->show_visa_renewal)) { ?>
                <!-- <li onclick="navigate_tab('visa')">
                    <a aria-expanded="true" data-toggle="tab" href="#visa">Visa</a>
                </li> -->
                <?php } ?>
                <!-- <li onclick="navigate_tab('visa_dependent')">
                    <a aria-expanded="true" data-toggle="tab" href="#visa_dependent">Visa</a>
                </li> -->
                <!-- <li onclick="navigate_tab('post_degree')">
                    <a aria-expanded="true" data-toggle="tab" href="#post_degree">Post-Degree Academic Training</a>
                </li> -->
                <?php if($is_admin) { ?>
                <li onclick="navigate_tab('case')">
                    <a aria-expanded="true" data-toggle="tab" href="#case">Special Case</a>
                </li>
                <?php } ?>
                <?php if($grantee_grant->is_degree) { ?>
                <li onclick="navigate_tab('work_uthorization')">
                    <a aria-expanded="true" data-toggle="tab" href="#work_uthorization">Work Authorization Request</a>
                </li>
                <?php } ?>
            </ul>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content">
                        <?php $this->load->view('admin/partials/general_information'); ?>
                        
                        <?php
                            if (
                                $grantee_grant->is_degree &&
                                $grantee_grant->show_study_information &&
                                (has_permission('on_going', 'detail') || !$is_admin)
                            ) {
                        ?>
                            <?php $this->load->view('admin/partials/study_information'); ?>
                        <?php } ?>


                        <!-- VISA -->
                        <?php //if((has_permission('on_going', 'detail') && $grantee_grant->show_visa_renewal) || (!$is_admin && $grantee_grant->show_visa_renewal)) { ?>
                        <!-- <div id="visa" class="active in first_tab">
                        </div> -->
                        <?php //} ?>

                        <!-- VISA DEPENDENT & VISA RENEWAL -->
                        <?php //$this->load->view('admin/partials/visa_ongoing'); ?>

                        <!-- POST DEGREE -->
                        <?php //$this->load->view('admin/partials/post_degree'); ?>

                        <?php if($is_admin) { ?>
                        <!-- CASE -->
                        <?php $this->load->view('admin/partials/case'); ?>
                        <?php } ?>
                        
                        <!-- Work Authorization -->
                        <?php if($grantee_grant->is_degree) { ?>
                        <?php $this->load->view('admin/partials/work_uthorization'); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<?php $this->session->unset_userdata('last_tab'); ?>
<?php $this->session->unset_userdata('last_list'); ?>
<?php $this->load->view('admin/partials/form_appointment_ongoing') ?>
<?php $this->load->view('admin/partials/form_appointment_ongoing_dependent') ?>

<div class="modal fade" id="upload_sign_toa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleMedical">Add Signed TOA Renewal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <input name="id_sign_toa" id="id_sign_toa" type="hidden">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label id="labelTitle">Academic Year</label>
                        <select class="form-control" name="year" id="year">
                            <option value="">-- Select Year --</option>
                            <?php
                            $current_year = $grantee_grant->fiscal_year_period;
                            $limit_year = $current_year + 4;
                            for ($year=$current_year; $year <= $limit_year; $year++) { ?>
                                <option value="<?php echo $year ?> - <?php echo $year+1 ?>"><?php echo $year ?> - <?php echo $year+1 ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label id="labelTitle">Signed TOA Renewal</label>
                        <input type="file" id="upload_sign_toa_file" name="file_toa">
                        <small class="file-for-testing">File Size Max 1MB</small>
                    </div>
                </div>
                <div class="col-md-6 <?= $is_admin ? '' : 'hide' ?>">
                    <div class="form-group">
                        <label id="labelTitle">Total Cost</label>
                        <input type="text" id="total_cost" name="total_cost" class="form-control">
                    </div>
                </div>
                <?php if($is_admin) { ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label id="labelTitle">Detail Cost</label>
                        <input type="file" id="upload_sign_toa_detail_cost" name="detail_cost">
                        <small class="file-for-testing">File Size Max 1MB</small>
                    </div>
                </div>
                <?php } ?>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-sign-toa-renewal" data-is_admin="<?= $is_admin ?>" data-grant_award="<?= $grantee_grant->grant_award ?>" data-is_admin="<?= $is_admin ?>">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_case" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleCase">Add Special Case</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_case" enctype="multipart/form-data">
            <div class="form-group">
                <label>Type</label>
                <select name="type" id="type_case" class="form-control">
                    <option value="">-- Select --</option>
                    <option value="Transfer of Visa Sponsorship">Transfer of Visa Sponsorship</option>
                    <option value="2-Years Home Residency Waiver ">2-Years Home Residency Waiver </option>
                    <option value="Exceptional Extension">Exceptional Extension</option>
                    <option value="Travel Support for Emergency Situation (the death of immediate family members—such as parents or spouses)">Travel Support for Emergency Situation (the death of immediate family members—such as parents or spouses)</option>
                </select>
            </div>
            <div class="form-group">
                <label id="labelTitleDeadline">Summary</label>
                <textarea id="summary" name="summary" cols="30" rows="10" class="form-control fields_case editor"></textarea>
                <!-- <input type="text" class="form-control fields_case" id="summary" name="summary"> -->
                <input type="hidden" name="case_id" id="case_id" class="fields_case">
                <input type="hidden" class="fields_case index_case" name="index_case">
            </div>
            <div class="form-group">
                <label id="labelTitle">File</label>
                <input type="file" id="file_case" name="file_case" class="fields_case">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="form_case" class="btn btn-primary" id="btn-add-case">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_work" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitleDeadline">Add Work Authorization Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" id="form_work">
            <input type="hidden" class="fields_work work_id" name="work_id" id="work_id">
            <input type="hidden" class="fields_work index_work" name="index_work">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Type <?= label_required(true) ?></label>
                            <select name="type" id="type" class="form-control fields_work" required>
                                <option value="">-- Select --</option>
                                <option value="Work Authorization">Work Authorization</option>
                                <option value="Pre-Degree AT">Pre-Degree AT</option>
                                <option value="Post-Degree AT">Post-Degree AT</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Request Date to IIE <?= label_required(true) ?></label>
                            <input class="form-control fields_work request_date datepicker" name="request_date" required>
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:100px; right:15px;">X</a>
                        </div>
                        <div class="form-group">
                            <label>Start Date <?= label_required(true) ?></label>
                            <input class="form-control fields_work datepicker start_date_work" name="start_date_work" required>
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:175px; right:15px;">X</a>
                        </div>
                        <div class="form-group">
                            <label>End Date <?= label_required(true) ?></label>
                            <input class="form-control fields_work datepicker end_date_work" name="end_date_work" required>
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:250px; right:15px;">X</a>
                        </div>
                        <?php //if($is_admin) { ?>
                        <!-- <div class="form-group">
                            <label>Status</label>
                            <select name="status_work" id="status_work" class="form-control fields_work">
                                <option value="">Submitted</option>
                                <option value="approve">Approve</option>
                                <option value="revise">Revise</option>
                            </select>
                        </div> -->
                        <?php //} ?>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>File <?= label_required(true) ?></label>
                            <input type="file" class="form-control fields_work file_work" name="file_work" required>
                            <span id="file-name-work"></span>
                        </div>
                        <?php if($is_admin) { ?>
                        <div class="form-group">
                            <label>Request Email</label>
                            <input type="file" class="form-control fields_work email_work" name="email_work">
                            <span id="file-name-email-work"></span>
                        </div>
                        <!-- <div class="form-group">
                            <label>Decision</label>
                            <select class="form-control fields_work decision" name="decision" style="width:100%">
                                <option value="">-- Select --</option>
                                <option value="Approve">Approve</option>
                                <option value="Reject">Reject</option>
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label>Decision Email</label>
                            <input type="file" class="form-control fields_work decision_email_work" name="decision_email_work">
                            <span id="file-name-decision-work"></span>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" form="form_work" class="btn btn-primary" id="btn-add-work">Save</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_post_degree" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleDeadline">Add Post-Degree Academic Training</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_post_degree" enctype="multipart/form-data">
            <div class="form-group">
                <label id="labelTitle">Document</label>
                <input type="file" id="file_post_degree" name="file_post_degree" class="fields_post_degree" required>
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="post_degree_id" id="post_degree_id" class="fields_post_degree">
                <input type="hidden" class="fields_post_degree index_post_degree" name="index_post_degree">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="form_post_degree" class="btn btn-primary" id="btn-add-post_degree">Save</button>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/partials/modal_log') ?>

<?php $this->load->view('admin/partials/modal_upload_ds2019_ongoing') ?>

<div class="modal fade" id="upload_academic_transcript" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleMedical">Add Academic Transcript</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label id="labelTitle">Academic Year</label>
                        <select class="form-control" name="year" id="year_academic_transcript">
                            <option value="">-- Select Year --</option>
                            <?php
                            $current_year = $grantee_grant->fiscal_year_period;
                            $limit_year = $current_year + 4;
                            for ($year=$current_year; $year <= $limit_year; $year++) { ?>
                                <option value="<?php echo $year ?> - <?php echo $year+1 ?>"><?php echo $year ?> - <?php echo $year+1 ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label id="labelTitle">Academic Transcript</label>
                        <input type="file" id="upload_academic_transcript_file" name="file">
                        <small class="file-for-testing">File Size Max 1MB</small>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-is_admin="<?= $is_admin ?>" id="btn-upload-academic-transcript">Save</button>
      </div>
    </div>
  </div>
</div>