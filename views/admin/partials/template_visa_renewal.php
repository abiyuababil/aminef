<script type="text/template" id="applicant-template-renewal">
<div class="panel panel-default renewal-item">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionVisaRenewalItem" href="#collapseItemRenewal{index}" aria-expanded="false" aria-controls="collapseItemRenewal{index}">
        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
            <h4 class="panel-title">
                Date not selected
                <div class="btn-group pull-right">
                    <button type="button" id="btn-reject-renewal-{visa_id}" class="btn btn-xs btn-danger btn-noaction btn-reject-renewal btn-reject mr-2" data-id="{visa_id}">
                        Reject
                    </button>
                    <button type="button" data-visa_id="{visa_id}" data-dependent="0" class="btn btn-xs btn-danger btn-noaction pull-right removeApplicant"><i class="fa fa-trash fa-fw text-white"></i></button>
                </div>
            </h4>
        </div>
    </a>
    <div id="collapseItemRenewal{index}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-body">
            <div class="panel-group" id="accordionTwo_{index}" role="tablist" aria-multiselectable="true">
                <?php if(has_permission('on_going', 'detail') || !$is_admin) { ?>
                <div class="panel">
                    <div class="panel-body">
                        <?php if($is_admin) { ?>
                        <div class="row mb-5">
                            <div class="col-lg-12">
                                <div class="TriSea-technologies-Switch">
                                    <input type="hidden" value="{visa_id}" name="renewal[{index}][visa_id]" id="visa_id_{index}">
                                    <span class="mr-2"> Enable Grantee</span>
                                    <input onclick="enable_toogle_grantee_ongoing(this, 'save_grantee', 0, {visa_id})" id="save_grantee_{index}" name="renewal[{index}][save_grantee_renewal]" type="checkbox" checked/>
                                    <label for="save_grantee_{index}" class="label-primary"></label>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- <div class="col-lg-8">
                            <div class="form-group">
                                <label>Visa Renewal Request Date</label>
                                <input type="text" name="renewal[{index}][visa_renewal_date]" id="visa_renewal_date_{index}" class="form-control datepicker" readonly style="background-color:#fff;">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div> -->
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Your visa interview appointment will be scheduled at the U.S. Consular Office located in</label>
                                <select class="form-control appointment_located_renewal" data-visa_id="{visa_id}" data-index="{index}" name="renewal[{index}][visa_renewal]" id="appointment_located_renewal_{index}">
                                    <option value="">-- Select --</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                </select>
                                <input type="hidden" name="renewal[{index}][visa_renewal_id]" id="visa_renewal_id_{index}" value="">
                            </div>
                        </div>
                        <!-- <div class="col-lg-8 visa-category" data-index="{index}">
                            <div class="form-group">
                                <select class="form-control" name="renewal[{index}][category_visa]" style="width:100%" id="category_visa_{index}">
                                    <option value="">-- Select Visa Interview --</option>
                                    <option value="Visa Waiver">Visa Waiver</option>
                                    <option value="Visa Interview">Visa Interview</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-lg-8" id="dependent-yes-{index}">
                            <div class="form-group">
                                <label>
                                    Please confirm the number of applicants of visa renewal (including dependent)
                                </label>
                                <input type="number" class="form-control input_number number_of_dependent_renewal" id="number_of_dependent_renewal_{index}" name="renewal[{index}][number_of_dependent_ongoing]" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default visa-jakarta-section-tab">
                    <a role="button" data-toggle="collapse" data-parent="#accordionTwo_{index}" href="#collapseOneVisa{index}" aria-expanded="true" aria-controls="collapseOneVisa{index}" onclick="return set_session('before_visa_{index}')">
                        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                            <h4 class="panel-title">
                                Before Visa Interview
                            </h4>
                        </div>
                    </a>
                    <div id="collapseOneVisa{index}" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa_{index}' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Visa Application Form</label>
                                <ul>
                                    <li>Complete the online visa application form:</li>
                                        <p>Form DS160: <a target="_blank" style="color:#337ab7" href="https://ceac.state.gov/GenNIV/">https://ceac.state.gov/GenNIV/</a></p>
                                    <li>Download the guideline on how to complete the visa application</li>
                                        <a href="<?= base_url($grantee_grant->guideline_ds160) ?>" download title="Click to Download" class="<?= $grantee_grant->guideline_ds160 ? '' : 'hide' ?> btn btn-primary mt-2 mb-4" style="color:#fff">
                                            <i class="fa fa-download fa-fw text-white"></i> Download Guideline DS160
                                        </a>
                                        <a href="<?= base_url($grantee_grant->dependent_guideline_ds160) ?>" download title="Click to Download" class="<?= $grantee_grant->dependent_guideline_ds160 ? '' : 'hide' ?> btn btn-primary mt-2 mb-4" style="color:#fff">
                                            <i class="fa fa-download fa-fw text-white"></i> Download Dependent Guideline DS160
                                        </a>
                                    <li>Save the form DS160 application form</li>
                                    <li>Print the application form confirmation page to bring to your interview.</li>
                                    <li>Photo: upload your photo while complete the online form DS160</li>
                                        <a href="<?= base_url($grantee_grant->visa_photo) ?>" download title="Click to Download" class="<?= $grantee_grant->visa_photo ? '' : 'hide' ?> btn btn-primary mt-2 mb-4" style="color:#fff">
                                            <i class="fa fa-download fa-fw text-white"></i> Download Visa Photo Requirement
                                        </a>
                                </ul>
                            </div>
                            <div class="form-group visa-jakarta-section-label-{index}">
                                <label>Hardcopy Documents</label>
                                <p>Mail the following hardcopy documents to AMINEF office:</p>
                                <ol class="m">
                                    <li>Recent valid passport</li>
                                    <li>Old Passport (if any)</li>
                                    <li>The valid original DS2019 that has been signed</li>
                                    <li>1 sheet of printed photo 5x5cm</li>
                                    <li>Printed visa application</li>
                                    <li>Printed DS160 Confirmation Page</li>
                                </ol>
                            </div>
                            <div class="form-group">
                                <label>Apply for U.S. Visa</label>
                                <ul>
                                    <li>Complete and submit the following information to schedule for an appointment to the U.S. Consular:</li>
                                        <a onclick="open_modal_validate_ongoing('list_appointment_renewal', 'form_add_appointment_ongoing', {index})" class="btn btn-primary my-2" style="color:#fff">Add New</a>
                                        <div class="table-responsive" style="overflow-x: auto;">
                                        <table class="table table-striped table-bordered table-appointment-{index} my-3">
                                            <thead>
                                                <tr>
                                                    <th class="sticky-col first-col">No</th>
                                                    <th class="sticky-col second-col">Surename/Last Name</th>
                                                    <th class="sticky-col third-col">Given Name/First Name</th>
                                                    <!-- <th class="visa-jakarta-section">Gender</th> -->
                                                    <th>Passport Number</th>
                                                    <th>Date of Birth</th>
                                                    <!-- <th>Place of Birth</th> -->
                                                    <th>Passport Type</th>
                                                    <th>Nationality</th>
                                                    <th>Visa Type</th>
                                                    <th>Email Address</th>
                                                    <th>DS-160 Confirmation Number</th>
                                                    <th>Program Number</th>
                                                    <th>SEVIS ID</th>
                                                    <th>Telephone Number</th>
                                                    <th>Travel Date</th>
                                                    <th>Interview Location</th>
                                                    <th>Action</th>
                                                    <th>Enable Edit</th>
                                                </tr>    
                                            </thead>
                                            <tbody id="list_appointment_renewal_{index}"></tbody>
                                        </table>
                                        </div>
                                    <li>Required Documents:</li>
                                        <!-- other required doc  -->
                                        <table class="table table-striped table-bordered table-responsive table-required-{index} my-3">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Surename/Last Name</th>
                                                    <th>Given Name/First Name</th>
                                                    <th>DS160 Visa Application</th>
                                                    <th>Photo 5x5</th>
                                                    <th>DS160 Confirmation Page</th>
                                                    <th>DS2019</th>
                                                    <th>Passport</th>
                                                    <th>Latest Visa</th>
                                                    <th>PDF Merge</th>
                                                    <th>Grantee Upload</th>
                                                </tr>
                                            </thead>
                                            <tbody id="list_required_doc_renewal_{index}"></tbody>
                                        </table>
                                        <p><b>Note:</b></p>
                                        <p>You need to upload the signed DS2019. <u><i>Do NOT alter the DS-2019 form in any way.</i></u></p>
                                        <div class="form-group">
                                            <label>Guideline for completing and signing your DS2019</label><br />
                                            <a href="<?= base_url($grantee_grant->guideline_ds2019) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_ds2019 ? '' : 'hide' ?>" style="color:#fff">
                                                <i class="fa fa-download fa-fw text-white"></i> Download Guideline DS2019
                                            </a>
                                        </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <?php } ?>
    
                <div class="panel panel-default visa-surabaya-section">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo_{index}" href="#collapseTwoVisaInterview{index}" aria-expanded="false" aria-controls="collapseTwoVisaInterview{index}" onclick="return set_session('interview_apointment_confirmation')">
                        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                            <h4 class="panel-title">
                                Visa Interview Appointment Confirmation
                            </h4>
                        </div>
                    </a>
                    <div id="collapseTwoVisaInterview{index}" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'interview_apointment_confirmation' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row my-5">
                                    <div class="col-lg-12">
                                        <div class="TriSea-technologies-Switch">
                                            <span class="mr-2"> Enable Visa Interview Appointment Confirmation</span>
                                            <input onclick="enable_toogle_ongoing(this, 0)" data-id="<?= $grantee_grant->id ?>" id="enable_visa_interview_appointment_renewal_{index}" name="renewal[{index}][enable_visa_interview_appointment_renewal]" type="checkbox" checked/>
                                            <label for="enable_visa_interview_appointment_renewal_{index}" class="label-primary"></label>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url($grantee_grant->ongoing_visa_interview_procedure) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->visa_interview_procedure ? '' : 'hide' ?>" style="color:#fff">
                                    <i class="fa fa-download fa-fw text-white"></i> Download Visa Interview Procedure
                                </a>
                                <p>Pay attention to the following information before attending your visa interview:</p>
                                <ul>
                                    <li>Official Visa Interview Invitation</li>
                                    <div class="panel-body mt-3">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input 
                                                    id="date_renewal_{index}" 
                                                    type="text" 
                                                    class="form-control datepicker" 
                                                    readonly 
                                                    style="background-color:#fff" 
                                                    readonly
                                                    placeholder="Date" 
                                                    name="renewal[{index}][date_renewal]"
                                                    value="">
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Time</label>
                                                <input
                                                    type="text" 
                                                    id="time_renewal_{index}" 
                                                    class="form-control input_time" 
                                                    name="renewal[{index}][time_renewal]" 
                                                    value="" 
                                                    placeholder="Time">
                                                    <a href="javascript:;" onclick="emptyValueTime(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <select class="form-control" id="location_renewal_{index}" name="renewal[{index}][location_renewal]" style="width:100%">
                                                    <option value="">-- Select --</option>
                                                    <option value="Jakarta">Jakarta</option>
                                                    <option value="Surabaya">Surabaya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Appointment Confirmation Letter</label>
                                                <input id="invitation_letter_renewal_{index}" type="file" class="form-control" name="invitation_letter_renewal_{index}">
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                            <hr />
                        </div>
                    </div>
                    </div>
                </div>
    
                <div class="panel panel-default visa-jakarta-section-tab">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo_{index}" href="#collapseTwoVisa{index}" aria-expanded="false" aria-controls="collapseTwoVisa{index}" onclick="return set_session('interview_apointment_{index}')">
                        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                            <h4 class="panel-title label-after-visa">
                                After Visa Interview
                            </h4>
                        </div>
                    </a>
                    <div id="collapseTwoVisa{index}" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment_{index}' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control"  name="renewal[{index}][status_visa_renewal]" style="width:100%" id="status_visa_renewal_{index}">
                                    <option value="">-- Select --</option>
                                    <option value="Refused">Refused</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Issued">Issued</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Submit/ access the following documents for you and AMINEF record:</label>
                                <ul>
                                    <!-- ds2019 & visa page  -->
                                    <table class="table table-striped table-bordered table-responsive table-sign-{index} my-3">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Surename/Last Name</th>
                                                <th>Given Name/First Name</th>
                                                <th>DS2019 (Signed)</th>
                                                <th>Visa Page</th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_ds2019sign_visapage_renewal_{index}"></tbody>
                                    </table>
                                </ul>
                            </div>
                            <hr />
                            
                            <div class="form-group section-obtaining-{index}">
                                <label>Obtaining Passport, Visa, and DS2019 Documents</label><br />
                                <label class="mt-5 together_with_dependent_{index} hide">Would you go to the US together with your dependent?</label>
                                <p class="mt-3">You can obtain the documents at:</p>
                                <div class="panel-body">
                                    <div class="panel-body">
                                        <div class="col-lg-8">
                                            <label>Grantee Pickup Document</label>
                                            <select id="obtaining_departur_document_renewal_{index}" class="form-control" name="renewal[{index}][obtaining_departur_document_renewal]" style="width:100%">
                                                <option value="">-- Select --</option>
                                                <option value="AMINEF Office">AMINEF Office</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body obtaining-section-{index}">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Hotel Name</label>
                                                <input class="form-control" type="input" name="renewal[{index}][hotel_name_renewal]" value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 obtaining-section-{index}">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="renewal[{index}][address_renewal]"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Appointment Date</label>
                                                <input id="appointment_date_renewal_{index}" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Date" name="renewal[{index}][appointment_date_renewal]" value="">
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Point of Contact</label>
                                                <select class="form-control point_of_contact_renewal" <?= $is_admin ? '' : 'disabled' ?> name="renewal[{index}][point_of_contact_renewal]" onchange="select_staff_ongoing(this, false, <?= $is_admin ? 1 : 0 ?>, {index})">
                                                    <option>-- Select --</option>
                                                    <?php foreach($staffs as $staff) { ?>
                                                        <option data-email="<?= $staff->email ?>" data-telephone="<?= $staff->telephone ?>" value="<?= $staff->id ?>"><?= $staff->full_name?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="input" id="email_renewal_{index}" name="renewal[{index}][email_renewal]" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Telephone</label>
                                                <input class="form-control" type="input" name="renewal[{index}][telephone_renewal]" id="telephone_renewal_{index}" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Receipt</label>
                                                <input id="receipt_renewal_{index}" type="file" class="form-control" name="receipt_renewal_{index}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <small class="section-obtaining"><i>No mailing service provided for this purpose to avoid any delivery risk which cause the lost document during shipment.</i></small>
                            <hr class="section-obtaining" />
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</script>