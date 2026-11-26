<script type="text/template" id="applicant-template-dependent">
    <div class="panel panel-default dependent-item">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionVisaDependentlItem" href="#collapseItemDependentl{index}" aria-expanded="false" aria-controls="collapseItemDependentl{index}">
            <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                <h4 class="panel-title">
                    Date not selected
                    <div class="btn-group pull-right">
                        <button 
                            type="button" 
                            id="btn-reject-renewal-{visa_id}" 
                            class="btn btn-xs btn-noaction btn-danger btn-reject-renewal btn-reject mr-2" 
                            data-dependent="1"
                            data-notereject="" 
                            data-attachment="" 
                            data-id="{visa_id}">
                            Reject
                        </button>
                        <button type="button" data-visa_id="{visa_id}" data-dependent="1" class="btn btn-noaction btn-danger btn-xs pull-right removeApplicant">
                            <i class="fa fa-trash fa-fw text-white"></i>
                        </button>
                    </div>
                </h4>
            </div>
        </a>
        <div id="collapseItemDependentl{index}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="submission_result">
            <div class="panel-body"> 
                <div class="panel-group" id="accordionThree{index}" role="tablist" aria-multiselectable="true">
                    <?php if(has_permission('on_going', 'detail') || !$is_admin) { ?>
                    <div class="panel">
                        <div class="panel-body">
                            <?php if($is_admin) { ?>
                            <div class="row mb-5">
                                <div class="col-lg-12">
                                    <div class="TriSea-technologies-Switch">
                                        <span> Enable Grantee</span>
                                        <input onclick="enable_toogle_grantee_ongoing(this, 'save_grantee', 1, {visa_id})" id="save_grantee_dependent_{index}" name="dependent[{index}][save_grantee_dependent]" type="checkbox" checked/>
                                        <label for="save_grantee_dependent_{index}" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Visa Dependent Date</label>
                                    <input type="text" name="dependent[{index}][visa_dependent_date]" id="visa_dependent_date_{index}" class="form-control datepicker" readonly style="background-color:#fff;">
                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                </div>
                            </div> -->
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Your visa interview appointment will be scheduled at the U.S. Consular Office located in</label>
                                    <select class="form-control appointment_located_dependent" data-index="{index}" data-visa_id="{visa_id}" name="dependent[{index}][visa_dependent]" style="width:100%" id="appointment_located_dependent_{index}">
                                        <option value="">-- Select --</option>
                                        <option value="Jakarta">Jakarta</option>
                                        <option value="Surabaya">Surabaya</option>
                                    </select>
                                    <input type="hidden" name="dependent[{index}][visa_dependent_id]" id="visa_dependent_id_{index}" value="{visa_id}">
                                </div>
                            </div>
                            <div class="col-lg-8" id="dependent-yes">
                                <div class="form-group">
                                    <label>
                                        Please confirm the number of dependent
                                    </label>
                                    <input type="number" class="form-control input_number new_number_of_dependent" id="new_number_of_dependent_{index}" name="dependent[{index}][new_number_of_dependent]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <a role="button" data-toggle="collapse" data-parent="#accordionThree{index}" href="#collapseOneVisaDependent{index}" aria-expanded="true" aria-controls="collapseOneVisaDependent{index}" onclick="return set_session('before_visa_dependent')">
                            <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                                <h4 class="panel-title">
                                    Before Visa Interview
                                </h4>
                            </div>
                        </a>
                        <div id="collapseOneVisaDependent{index}" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa_dependent' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Visa Application Form</label>
                                    <ul>
                                        <li>Complete the online visa application form:</li>
                                            <p>Form DS160: <a target="_blank" style="color:#337ab7" href="https://ceac.state.gov/GenNIV/">https://ceac.state.gov/GenNIV/</a></p>
                                        <li>Complete the information below while completing the form DS160</li>
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
                                <div class="form-group">
                                    <label>Apply for U.S. Visa</label>
                                    <ul>
                                        <li>Complete and submit the following information to schedule for an appointment to the U.S. Consular:</li>
                                            <?php //if($is_admin) { ?>
                                            <a onclick="open_modal_validate_ongoing('list_appointment_dependent_{index}', 'form_add_appointment_dependent', {index})" class="btn btn-primary my-2" style="color:#fff">Add New</a>
                                            <?php //} ?>
                                            <div class="table-responsive" style="overflow-x: auto;">
                                            <table class="table table-striped table-bordered table-appointment my-3">
                                                <thead>
                                                    <tr>
                                                        <th class="sticky-col first-col">No</th>
                                                        <th class="sticky-col second-col">Surename/Last Name</th>
                                                        <th class="sticky-col third-col">Given Name/First Name</th>
                                                        <th>Date of Birth</th>
                                                        <th>Passport Number</th>
                                                        <th>Passport Type</th>
                                                        <th>Nationality</th>
                                                        <th>Visa Type</th>
                                                        <th>Email</th>
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
                                                <tbody id="list_appointment_dependent_{index}"></tbody>
                                            </table>
                                            </div>
                                        <li>Required Documents:</li>
                                            <!-- other required doc  -->
                                            <table class="table table-striped table-bordered table-responsive table-required my-3">
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
                                                        <th>PDF Merge</th>
                                                        <th>Grantee Upload</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="list_required_doc_dependent_{index}"></tbody>
                                            </table>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <?php } ?>
            
                    <div class="panel panel-default">
                        <a role="button" data-toggle="collapse" data-parent="#accordionThree{index}" href="#collapseRequestDependent{index}" aria-expanded="true" aria-controls="collapseRequestDependent{index}" onclick="return set_session('appointment_confirmation_dependent')">
                            <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                                <h4 class="panel-title">
                                    Visa Interview Appointment Confirmation
                                </h4>
                            </div>
                        </a>
                        <div id="collapseRequestDependent{index}" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'appointment_confirmation_dependent' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="row my-5">
                                        <div class="col-lg-12">
                                            <div class="TriSea-technologies-Switch">
                                                <span class="mr-2"> Enable Visa Interview Appointment Confirmation</span>
                                                <input onclick="enable_toogle_ongoing(this, 1)" data-id="<?= $grantee_grant->id ?>" id="enable_visa_interview_appointment_dependent_{index}" name="dependent[{index}][enable_visa_interview_appointment_dependent]" type="checkbox" checked/>
                                                <label for="enable_visa_interview_appointment_dependent_{index}" class="label-primary"></label>
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
                                                        id="date_dependent_{index}" 
                                                        type="text" 
                                                        class="form-control datepicker"  
                                                        style="background-color:#fff" 
                                                        readonly
                                                        placeholder="Date" 
                                                        name="dependent[{index}][date_dependent]"
                                                    >
                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Time</label>
                                                    <input 
                                                        type="text" 
                                                        id="time_dependent_{index}" 
                                                        class="form-control input_time" 
                                                        name="dependent[{index}][time_dependent]"
                                                        placeholder="Time">
                                                        <a href="javascript:;" onclick="emptyValueTime(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Location</label>
                                                    <select class="form-control" id="location_dependent_{index}" name="dependent[{index}][location_dependent]" style="width:100%">
                                                        <option value="">-- Select --</option>
                                                        <option value="Jakarta">Jakarta</option>
                                                        <option value="Surabaya">Surabaya</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Appointment Confirmation Letter</label>
                                                    <input id="invitation_letter_dependent_{index}" type="file" class="form-control" name="invitation_letter_dependent_{index}">
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
                    <?php if($has_permission || !$is_admin) { ?>
                    <div class="panel panel-default">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionThree{index}" href="#collapseTwoVisaDependent{index}" aria-expanded="false" aria-controls="collapseTwoVisaDependent{index}" onclick="return set_session('interview_apointment_dependent')">
                            <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                                <h4 class="panel-title">
                                    After Visa Interview
                                </h4>
                            </div>
                        </a>
                        <div id="collapseTwoVisaDependent{index}" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment_dependent' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control"  name="dependent[{index}][status_visa_dependent]" style="width:100%" id="status_visa_dependent">
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
                                        <table class="table table-striped table-bordered table-responsive table-sign my-3">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Surename/Last Name</th>
                                                    <th>Given Name/First Name</th>
                                                    <th>DS2019 (Signed)</th>
                                                    <th>Visa Page</th>
                                                </tr>
                                            </thead>
                                            <tbody id="list_ds2019sign_visapage_dependent_{index}"></tbody>
                                        </table>
                                    </ul>
                                </div>
                                <hr />
                                <div class="form-group section-obtaining-dependent">
                                    <label>Obtaining Passport, Visa, and DS2019 Documents</label><br />
                                    <label class="mt-5 together_with_dependent hide">Would you go to the US together with your dependent?</label>
                                    <p class="mt-3">You can obtain the documents at:</p>
                                    <div class="panel-body">
                                        <div class="panel-body">
                                            <div class="col-lg-8">
                                                <label>Grantee Pickup Document</label>
                                                <select id="obtaining_departur_document_dependent_{index}" class="form-control" name="dependent[{index}][obtaining_departur_document_dependent]" style="width:100%">
                                                    <option value="">-- Select --</option>
                                                    <option value="AMINEF Office">AMINEF Office</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel-body obtaining-section-dependent">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Hotel Name</label>
                                                    <input class="form-control" type="input" name="dependent[{index}][hotel_name_dependent]">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 obtaining-section-dependent">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea class="form-control" name="dependent[{index}][address_dependent]"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Appointment Date</label>
                                                    <input id="appointment_date_dependent" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Date" name="dependent[{index}][appointment_date_dependent]">
                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Point of Contact</label>
                                                    <select class="form-control point_of_contact_dependent" <?= $is_admin ? '' : 'disabled' ?> name="dependent[{index}][point_of_contact_dependent]" onchange="select_staff_ongoing(this, true, <?= $is_admin ? 1 : 0 ?>, {index})">
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
                                                    <input class="form-control" type="input" id="email_dependent_ongoing_{index}" name="dependent[{index}][email_dependent]" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_dependent->email ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Telephone</label>
                                                    <input class="form-control" type="input" name="dependent[{index}][telephone_dependent_ongoing]" id="telephone_dependent_ongoing_{index}" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_dependent->telephone ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Receipt</label>
                                                    <input id="receipt" type="file" class="form-control" name="receipt_dependent_{index}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="section-obtaining-dependent"><i>No mailing service provided for this purpose to avoid any delivery risk which cause the lost document during shipment.</i></small>
                                <hr class="section-obtaining-dependent" />
                            </div>
                        </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</script>