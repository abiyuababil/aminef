<div class="panel-body renewal-item">
    <div class="panel-group" id="accordionTwo" role="tablist" aria-multiselectable="true">
        <?php if(has_permission('on_going', 'detail') || !$is_admin) { ?>
        <div class="panel">
            <div class="panel-body">
                <?php if($is_admin) { ?>
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Grantee</span>
                            <input onclick="enable_toogle_grantee_ongoing(this, 'save_grantee', 0)" id="save_grantee" name="save_grantee_renewal" type="checkbox" <?= !$visa_renewal->save_grantee  ? 'checked' : '' ?>/>
                            <label for="save_grantee" class="label-primary"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-lg-8">
                    <div class="form-group">
                        <label>Your visa renewal will be submitted at the U.S. Consular Office located in</label>
                        <select class="form-control"  name="visa_renewal" style="width:100%" <?= !$is_admin &&  $visa_renewal->save_grantee ? 'disabled' : '' ?> id="appointment_located_renewal">
                            <option value="">-- Select --</option>
                            <option <?= $visa_renewal->appointment_located == 'Jakarta' ? 'selected' : '' ?> value="Jakarta">Jakarta</option>
                            <option <?= $visa_renewal->appointment_located == 'Surabaya' ? 'selected' : '' ?> value="Surabaya">Surabaya</option>
                        </select>
                        <input type="hidden" name="visa_renewal_id" id="visa_renewal_id" value="<?= $visa_renewal->id ?>">
                    </div>
                </div>
                <div class="col-lg-8 visa-category">
                    <div class="form-group">
                        <select class="form-control" name="category_visa" style="width:100%" <?= !$is_admin &&  $visa_renewal->save_grantee ? 'disabled' : '' ?> id="category_visa">
                            <option value="">-- Select Visa Interview --</option>
                            <option <?= $visa_renewal->category_visa == 'Visa Waiver' ? 'selected' : '' ?> value="Visa Waiver">Visa Waiver</option>
                            <option <?= $visa_renewal->category_visa == 'Visa Interview' ? 'selected' : '' ?> value="Visa Interview">Visa Interview</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-8" id="dependent-yes">
                    <div class="form-group">
                        <label>
                            Please confirm the number of applicants of visa renewal (including dependent)
                        </label>
                        <input type="number" class="form-control input_number" id="number_of_dependent_renewal" name="number_of_dependent_ongoing" value="<?= $visa_renewal->number_of_dependent ?>" <?= !$is_admin &&  $visa_renewal->save_grantee ? 'disabled' : '' ?>>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default visa-jakarta-section-tab">
            <a role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseOneVisa" aria-expanded="true" aria-controls="collapseOneVisa" onclick="return set_session('before_visa')">
                <div class="panel-heading text-left" role="tab" id="submission_result">
                    <h4 class="panel-title">
                        Before Visa Interview
                    </h4>
                </div>
            </a>
            <div id="collapseOneVisa" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
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
                    <div class="form-group visa-jakarta-section-label">
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
                        <label>Request for a Visa Renewal Appointment</label>
                        <ul>
                            <li>Complete and submit the following information to schedule for an appointment to the U.S. Consular:</li>
                                <?php //if($is_admin) { ?>
                                <a onclick="open_modal_validate_ongoing('list_appointment_renewal', 'form_add_appointment_ongoing')" class="btn btn-primary my-2" style="color:#fff">Add New</a>
                                <?php //} ?>
                                <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table table-striped table-bordered table-appointment my-3">
                                    <thead>   
                                        <?php 
                                            $showAction = false;
                                            if($data_appointment_renewal){
                                                $showAction = array_reduce($data_appointment_renewal, function($carry, $item) {
                                                    return $carry || !empty($item->grantee_edit);
                                                }, false);
                                            }
                                        ?>
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
                                            <th>Visa Interview Date</th>
                                            <th>Travel Date</th>
                                            <th>Interview Location</th>
                                            <?php if($is_admin || (!$is_admin && $showAction)){ ?>
                                            <th>Action</th>
                                            <?php } ?>
                                            <?php if($is_admin) { ?>
                                                <th>Enable Edit</th>
                                            <?php } ?>
                                        </tr>    
                                    </thead>
                                    <tbody id="list_appointment_renewal">
                                        <?php foreach($data_appointment_renewal as $index => $appointment) { ?>
                                            <tr id="index-appointment-ongoing<?= $index + 1 ?>">
                                                <td class="sticky-col first-col"><?= $index + 1 ?> </td>
                                                <td class="sticky-col second-col"><?= $appointment->last_name ?></td>
                                                <td class="sticky-col third-col"><?= $appointment->first_name ?? 'FNU' ?></td>
                                                <!-- <td class="visa-jakarta-section"><?= $appointment->gender ?></td> -->
                                                <td><?= $appointment->passport ?></td>
                                                <td><?= $appointment->date_of_birth ? date('m/d/y', strtotime($appointment->date_of_birth)) : '' ?></td>
                                                <!-- <td><?= $appointment->place_of_birth ?></td> -->
                                                <td><?= $appointment->passport_type ?></td>
                                                <td><?= $appointment->nationality ?></td>
                                                <td><?= $appointment->visa_type ?></td>
                                                <td><?= $appointment->email ?></td>
                                                <td><?= $appointment->ds160 ?></td>
                                                <td><?= $appointment->program_number ?></td>
                                                <td><?= $appointment->sevis_id ?></td>
                                                <td><?= $appointment->telephone ?></td>
                                                <td><?= $appointment->propose_date ? date('m/d/y', strtotime($appointment->propose_date)) : '' ?></td>
                                                <td><?= $appointment->travel_plan ? date('m/d/y', strtotime($appointment->travel_plan)) : '' ?></td>
                                                <td><?= $appointment->interview_location ?></td>
                                                <?php if($is_admin || (!$is_admin && $showAction)){ ?>
                                                <td>
                                                    <?php if($is_admin || $appointment->grantee_edit) { ?>
                                                    <a onclick="edit_data_appointment_ongoing(this, <?= $appointment->id ?>, <?= $index + 1 ?>, <?= $is_admin ? 1 : 0 ?>)" class="btn btn-primary btn-xs edit-appointment" style="color:#fff">
                                                        Edit
                                                    </a>
                                                    <a href="javascript:;" onclick="del_data_appointment_ongoing(this, <?= $appointment->id ?>, <?= $index + 1 ?>, 0)" class="btn btn-danger btn-xs" style="color:#fff">
                                                        <i class="fa fa-trash fa-fw text-white"></i>
                                                    </a>
                                                    <?php } ?>
                                                </td>
                                                <?php } ?>
                                                <?php if($is_admin) { ?>
                                                <td>
                                                    <div class="TriSea-technologies-Switch" style="margin-left:15px;">
                                                        <input onchange="grantee_edit_toa(this, 'appointment_on_going')" data-id="<?= $appointment->id ?>" name="grantee_edit_renewal" id="grantee_edit_appointment_renwal_<?= $appointment->id ?>" type="checkbox" <?= $appointment->grantee_edit  ? 'checked' : '' ?>/>
                                                        <label for="grantee_edit_appointment_renwal_<?= $appointment->id ?>" class="label-primary"></label>
                                                    </div>
                                                </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
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
                                            <th>Visa Application</th>
                                            <th>Photo 5x5</th>
                                            <th>DS160 Confirmation Page</th>
                                            <th>DS2019</th>
                                            <th>Passport</th>
                                            <th>Latest Visa</th>
                                            <?php if($is_admin) { ?>
                                            <th>PDF Merge</th>
                                            <th>Grantee Upload</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="list_required_doc_renewal">
                                        <?php 
                                            foreach($data_required_doc_renewal as $key => $data_required){
                                            $required_fields = ['visa', 'ds160', 'ds2019', 'passport', 'photo', 'lates_visa'];
                                            $complete = !array_filter($required_fields, fn($f) => empty($data_required->$f));
                                        ?>
                                        <tr id="index-required-<?= $key + 1 ?>">
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $data_required->last_name ?></td>
                                            <td><?= $data_required->first_name ?? 'FNU' ?></td>
                                            <td>
                                                <?php if($data_required->visa) { ?>
                                                    <a href="<?= base_url($data_required->visa) ?>" class="lightbox btn-view-req-visa btn btn-warning btn-xs" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->visa) ?>" download="<?= get_full_name($grantee_grant) ?>_DS160 Complete Application" class="btn btn-info btn-xs btn-download-req-visa" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-visa-<?= $data_required->id ?>" data-file-value="upload_require_doc_visa_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="visa" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_visa_<?= $data_required->id ?> hide">
                                                <?php if($data_required->visa) { ?>
                                                    <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'visa', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs text-danger hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-visa-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($data_required->photo) { ?>
                                                    <a href="<?= base_url($data_required->photo) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-photo" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->photo) ?>" download="<?= get_full_name($grantee_grant) ?>_Photo 5x5" class="btn btn-info btn-xs btn-download-req-photo" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-photo-<?= $data_required->id ?>" data-file-value="upload_require_doc_photo_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="photo" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_photo_<?= $data_required->id ?> hide">
                                                <?php if($data_required->photo) { ?>
                                                    <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'photo', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs text-danger hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-photo-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($data_required->ds160) { ?>
                                                    <a href="<?= base_url($data_required->ds160) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-ds160" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->ds160) ?>" download="<?= get_full_name($grantee_grant) ?>_DS160 Confirmation Page" class="btn btn-info btn-xs btn-download-req-ds160" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-ds160-<?= $data_required->id ?>" data-file-value="upload_require_doc_ds160_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="ds160" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_ds160_<?= $data_required->id ?> hide">
                                                <?php if($data_required->ds160) { ?>
                                                    <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'ds160', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs text-danger hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-ds160-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($data_required->ds2019) { ?>
                                                    <a href="<?= base_url($data_required->ds2019) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-ds2019" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->ds2019) ?>" download="<?= get_full_name($grantee_grant) ?>_DS2019" class="btn btn-info btn-xs btn-download-req-ds2019" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-ds2019-<?= $data_required->id ?>" data-file-value="upload_require_doc_ds2019_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="ds2019" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_ds2019_<?= $data_required->id ?> hide">
                                                <?php if($data_required->ds2019) { ?>
                                                    <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'ds2019', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-ds2019-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($data_required->passport) { ?>
                                                    <a href="<?= base_url($data_required->passport) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-passport" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->passport) ?>" download="<?= get_full_name($grantee_grant) ?>_Passport" class="btn btn-info btn-xs btn-download-req-passport" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-passport-<?= $data_required->id ?>" data-file-value="upload_require_doc_passport_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="passport" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_passport_<?= $data_required->id ?> hide">
                                                <?php if($data_required->passport) { ?>
                                                    <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'passport', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-passport-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($data_required->lates_visa) { ?>
                                                    <a href="<?= base_url($data_required->lates_visa) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-lates_visa" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->lates_visa) ?>" download="<?= get_full_name($grantee_grant) ?>_Lates Visa" class="btn btn-info btn-xs btn-download-req-lates_visa" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-lates_visa-<?= $data_required->id ?>" data-file-value="upload_require_doc_lates_visa_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="lates_visa" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_lates_visa_<?= $data_required->id ?> hide">
                                                <?php if($data_required->lates_visa) { ?>
                                                    <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'lates_visa', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-lates_visa-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                <?php } ?>
                                            </td>
                                            <?php if($is_admin) { ?>
                                            <td>
                                                <?php 
                                                    $url_download = $is_admin ? base_url('admin/on_going/download_merge/' . $data_required->appointment_id) : base_url('grantee/submission/download_merge_ongoing/' . $data_required->appointment_id) ;
                                                ?>
                                                <a href="<?= $url_download ?>" class="btn btn-primary btn-xs btn-download-merge" style="color:#fff;">Download</a>
                                            </td>
                                            <td>
                                                <div class="TriSea-technologies-Switch" style="margin-left:35px;">
                                                    <input onchange="grantee_edit_toa(this, 'visa_required_document_on_going')" data-id="<?= $data_required->id ?>" name="grantee_edit_renewal" id="grantee_edit_required_renewal_<?= $data_required->id ?>" type="checkbox" <?= $data_required->grantee_edit  ? 'checked' : '' ?>/>
                                                    <label for="grantee_edit_required_renewal_<?= $data_required->id ?>" class="label-primary"></label>
                                                </div>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
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
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseTwoVisaInterview" aria-expanded="false" aria-controls="collapseTwoVisaInterview" onclick="return set_session('interview_apointment_confirmation')">
                <div class="panel-heading text-left" role="tab" id="submission_result">
                    <h4 class="panel-title">
                        Visa Interview Appointment Confirmation
                    </h4>
                </div>
            </a>
            <div id="collapseTwoVisaInterview" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'interview_apointment_confirmation' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="form-group">
                        <?php 
                        $required_fields = [
                            'date',
                            'location',
                            'invitation_letter'
                        ];
                        if($is_admin) { 
                        ?>
                        <div class="row my-5">
                            <div class="col-lg-12">
                                <div class="TriSea-technologies-Switch">
                                    <span class="mr-2"> Enable Visa Interview Appointment Confirmation</span>
                                    <input onclick="enable_toogle_ongoing(this, 0)" data-id="<?= $grantee_grant->id ?>" id="enable_visa_interview_appointment_renewal" name="enable_visa_interview_appointment_renewal" type="checkbox" <?= $visa_renewal->enable_visa_interview_appointment  ? 'checked' : '' ?>/>
                                    <label for="enable_visa_interview_appointment_renewal" class="label-primary"></label>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <a href="<?= base_url($grantee_grant->visa_interview_procedure) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->visa_interview_procedure ? '' : 'hide' ?>" style="color:#fff">
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
                                            id="date_renewal" 
                                            type="text" 
                                            class="form-control datepicker" 
                                            readonly 
                                            style="background-color:#<?= $is_admin || ($visa_renewal->enable_visa_interview_appointment && !$is_admin) ? 'fff' : 'eee' ?>" 
                                            <?= $is_admin || ($visa_renewal->enable_visa_interview_appointment && !$is_admin) ? 'readonly' : 'disabled' ?>
                                            placeholder="Date" 
                                            name="date_renewal"
                                            value="<?= $visa_renewal  ? ($visa_renewal->date != '' ? date('d M Y', strtotime($visa_renewal->date)) : '') : '' ?>">
                                        <?php //if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || $visa_renewal->appointment_located == 'Jakarta') { ?>
                                        <?php if($is_admin || ($visa_renewal->enable_visa_interview_appointment && !$is_admin)) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input 
                                            <?php // (!$is_admin && $visa_renewal->appointment_located == 'Surabaya') || $this->session->userdata('role') == 'travel-booking-assistant' ? 'disabled' : '' ?> 
                                            <?= $is_admin || ($visa_renewal->enable_visa_interview_appointment && !$is_admin) ? '' : 'disabled' ?>
                                            type="text" 
                                            id="time_renewal" 
                                            class="form-control input_time" 
                                            name="time_renewal" 
                                            value="<?= $visa_renewal  ? ($visa_renewal->date != '' ? (date('H:i', strtotime($visa_renewal->date)) == '00:00' ? '' : date('h:i A', strtotime($visa_renewal->date)) ) : '') : '' ?>" 
                                            placeholder="Time">
                                            <?php if($is_admin || ($visa_renewal->enable_visa_interview_appointment && !$is_admin)) { ?>
                                            <a href="javascript:;" onclick="emptyValueTime(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <!-- <input type="text" class="form-control" <?= !$is_admin ? 'readonly' : '' ?> name="location" id="location" value="<?= $visa_renewal->location ?>"> -->
                                        <select class="form-control" id="location_renewal" name="location_renewal" style="width:100%" <?= $is_admin || ($visa_renewal->enable_visa_interview_appointment && !$is_admin) ? '' : 'disabled' ?>>
                                            <option value="">-- Select --</option>
                                            <option <?= $visa_renewal->location == 'Jakarta' ? 'Selected' : '' ?> value="Jakarta">Jakarta</option>
                                            <option <?= $visa_renewal->location == 'Surabaya' ? 'Selected' : '' ?> value="Surabaya">Surabaya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Appointment Confirmation Letter</label>
                                        <?php  if(($is_admin || ($visa_renewal->enable_visa_interview_appointment && !$is_admin))) { ?>
                                        <input id="invitation_letter_renewal" type="file" class="form-control" name="invitation_letter_renewal">
                                        <?php  } ?>
                                        <?php if ($grantee_grant && $visa_renewal->invitation_letter != '') { ?>
                                            <br>
                                            <div style="margin-bottom:10px; position:relative; width:100px;" id="file_invitation_letter_renewal">
                                                <a href="<?=base_url() ?><?=$visa_renewal->invitation_letter ?>" class="lightbox" aria-haspopup="dialog">
                                                    <img id="preview_image_profile" data-old="<?php echo site_url($visa_renewal->invitation_letter); ?>" src="<?php echo get_preview($visa_renewal->invitation_letter); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                </a>
                                                <a href="<?=base_url() ?><?=$visa_renewal->invitation_letter ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_renewal->invitation_letter) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                                <?php if($is_admin || ($visa_renewal->enable_visa_interview_appointment && !$is_admin)) { ?>
                                                <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                    <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'invitation_letter', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                </a>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
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
        <div class="panel panel-default visa-jakarta-section-tab">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseTwoVisa" aria-expanded="false" aria-controls="collapseTwoVisa" onclick="return set_session('interview_apointment')">
                <div class="panel-heading text-left" role="tab" id="submission_result">
                    <h4 class="panel-title label-after-visa">
                        After Visa Renewal
                    </h4>
                </div>
            </a>
            <div id="collapseTwoVisa" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control"  name="status_visa_renewal" style="width:100%" <?= !$is_admin &&  $visa_renewal->save_grantee && $visa_renewal->status_visa_renewal == 'Issued' ? 'disabled' : '' ?> id="status_visa_renewal">
                            <option value="">-- Select --</option>
                            <option <?= $visa_renewal->status_visa_renewal == 'Refused' ? 'selected' : '' ?> value="Refused">Refused</option>
                            <option <?= $visa_renewal->status_visa_renewal == 'Approved' ? 'selected' : '' ?> value="Approved">Approved</option>
                            <option <?= $visa_renewal->status_visa_renewal == 'Issued' ? 'selected' : '' ?> value="Issued">Issued</option>
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
                                <tbody id="list_ds2019sign_visapage_renewal">
                                    <?php foreach($data_ds2019_sign_renewal as $key => $data_sign){ ?>
                                    <tr id="index-sign-<?= $key + 1 ?>">
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $data_sign->last_name ?></td>
                                        <td><?= $data_sign->first_name ?? 'FNU' ?></td>
                                        <td>
                                            <?php if($data_sign->ds2019_sign) { ?>
                                                <a href="<?= base_url($data_sign->ds2019_sign) ?>" class="lightbox btn btn-warning btn-xs btn-xs btn-view-req-ds2019_sign" style="color:#fff">View</a>
                                            <?php } ?>
                                            <?php if($is_admin || ($visa_interview->appointment_located == 'Surabaya' && !$is_admin)) { ?>
                                            <a href="javascript:;" class="btn btn-primary upload-button-ongoing btn-xs btn-ds2019_sign-<?= $data_sign->id ?>" data-file-value="upload_require_doc_ds2019_sign_<?= $data_sign->id ?>" style="color:#fff;">Upload</a>
                                            <?php } ?>
                                            <input type="file" data-table_save="save_ds2019_sign" data-doc="ds2019_sign" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_sign->id ?>" class="upload_require_doc_ds2019_sign_<?= $data_sign->id ?> hide">
                                            <?php if($data_sign->ds2019_sign) { ?>
                                                <?php if($is_admin || ($visa_interview->appointment_located == 'Surabaya' && !$is_admin)) { ?>
                                                <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_sign->id ?>, 'ds2019_sign', 'delete_save_ds2019_sign', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs btn-del-req-ds2019_sign-<?= $data_sign->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if($data_sign->visa_page) { ?>
                                                <a href="<?= base_url($data_sign->visa_page) ?>" class="lightbox btn btn-warning btn-xs btn-view-req-visa_page" style="color:#fff">View</a>
                                            <?php } ?>
                                            <?php if($is_admin || ($visa_interview->appointment_located == 'Surabaya' && !$is_admin)) { ?>
                                            <a href="javascript:;" class="btn btn-primary upload-button-ongoing btn-xs btn-visa_page-<?= $data_sign->id ?>" data-file-value="upload_require_doc_visa_page_<?= $data_sign->id ?>" style="color:#fff;">Upload</a>
                                            <?php } ?>
                                            <input type="file" data-table_save="save_ds2019_sign" data-doc="visa_page" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_sign->id ?>" class="upload_require_doc_visa_page_<?= $data_sign->id ?> hide">
                                            <?php if($data_sign->visa_page) { ?>
                                                <?php if($is_admin || ($visa_interview->appointment_located == 'Surabaya' && !$is_admin)) { ?>
                                                <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_sign->id ?>, 'visa_page', 'delete_save_ds2019_sign', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs btn-del-req-visa_page-<?= $data_sign->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </ul>
                    </div>
                    <hr />
                    <?php if($is_admin || (!$is_admin && $visa_renewal->appointment_located == 'Jakarta')) { ?>
                    <div class="form-group section-obtaining">
                        <label>Obtaining Passport, Visa, and DS2019 Documents</label><br />
                        <label class="mt-5 together_with_dependent hide">Would you go to the US together with your dependent?</label>
                        <?php if($visa_renewal->obtaining_departur_document || $is_admin) { ?>
                        <p class="mt-3">You can obtain the documents at:</p>
                        <?php } ?>
                        <?php if($visa_renewal->obtaining_departur_document || $is_admin) { ?>
                        <div class="panel-body">
                            <div class="panel-body">
                                <div class="col-lg-8">
                                    <label>Grantee Pickup Document</label>
                                    <select id="obtaining_departur_document_renewal" class="form-control" name="obtaining_departur_document_renewal" style="width:100%" <?= !$is_admin ? 'disabled' : '' ?>>
                                        <option value="">-- Select --</option>
                                        <option <?= $visa_renewal->obtaining_departur_document == 'AMINEF Office' ? 'selected' : ''?> value="AMINEF Office">AMINEF Office</option>
                                        <!-- <option <?= $visa_renewal->obtaining_departur_document == 'Hotel' ? 'selected' : ''?> value="Hotel">Hotel arranged by AMINEF</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body obtaining-section <?= $visa_renewal->obtaining_departur_document == 'AMINEF Office' || $visa_renewal->obtaining_departur_document == '' ? 'hide' : '' ?>">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Hotel Name</label>
                                        <input class="form-control" type="input" name="hotel_name_renewal" <?= !$is_admin ? 'disabled' : '' ?> value="<?= $visa_renewal->hotel_name ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4 obtaining-section <?= $visa_renewal->obtaining_departur_document == '' || $visa_renewal->obtaining_departur_document == 'AMINEF Office' ? 'hide' : '' ?>">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" <?= !$is_admin ? 'disabled' : '' ?> name="address_renewal"><?= $visa_renewal->address ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Appointment Date</label>
                                        <input id="appointment_date_renewal" type="text" class="form-control datepicker" readonly style="background-color:#<?= $is_admin ? 'fff' : 'eee' ?>" placeholder="Date" name="appointment_date_renewal" <?= !$is_admin ? 'disabled' : '' ?> value="<?= $visa_renewal  ? ($visa_renewal->appointment_date != '' ? date('d M Y', strtotime($visa_renewal->appointment_date)) : '') : '' ?>">
                                        <?php if($is_admin) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Point of Contact</label>
                                        <select class="form-control point_of_contact_renewal" <?= $is_admin ? '' : 'disabled' ?> name="point_of_contact_renewal" onchange="select_staff_ongoing(this, false, <?= $is_admin ?>)">
                                            <option>-- Select --</option>
                                            <?php foreach($staffs as $staff) { ?>
                                                <option <?= $visa_renewal->point_of_contact == $staff->id ? 'selected' : ''?> data-email="<?= $staff->email ?>" data-telephone="<?= $staff->telephone ?>" value="<?= $staff->id ?>"><?= $staff->full_name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="input" id="email_renewal" name="email_renewal" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_renewal->email ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Telephone</label>
                                        <input class="form-control" type="input" name="telephone_renewal" id="telephone_renewal" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_renewal->telephone ?>">
                                    </div>
                                </div>
                                <?php if (($visa_renewal && $visa_renewal->receipt != '') || $is_admin) { ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Receipt</label>
                                        <?php if($is_admin) { ?>
                                        <input id="receipt_renewal" type="file" class="form-control" name="receipt_renewal">
                                        <?php } ?>
                                        <?php if ($visa_renewal && $visa_renewal->receipt != '') { ?>
                                            <br>
                                            <div style="margin-bottom:10px; position:relative; width:100px;" id="file_receipt_renewal">
                                                <a href="<?=base_url() ?><?=$visa_renewal->receipt ?>" class="lightbox" aria-haspopup="dialog">
                                                    <img id="preview_image_profile" data-old="<?php echo site_url($visa_renewal->receipt); ?>" src="<?php echo get_preview($visa_renewal->receipt); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                </a>
                                                <a href="<?=base_url() ?><?=$visa_renewal->receipt ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_renewal->receipt) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                                <?php if($is_admin) { ?>
                                                <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                    <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'receipt', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                </a>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <small class="section-obtaining"><i>No mailing service provided for this purpose to avoid any delivery risk which cause the lost document during shipment.</i></small>
                    <hr class="section-obtaining" />
                    <?php } ?>
                </div>
            </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-right">
                <button type="button" name="btn" value="save_visa_renewal" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_visa_renewal')" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>