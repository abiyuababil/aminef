<div class="panel panel-default dependent-item">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionVisaDependentlItem" href="#collapseItemDependentl<?= $kvb ?>" aria-expanded="false" aria-controls="collapseItemDependentl<?= $kvb ?>">
        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
            <h4 class="panel-title">
                <?= $visa_dependent->visa_dependent_date ? date("F j, Y", strtotime($visa_dependent->visa_dependent_date)) : 'Date not selected' ; ?>
                <span class="badge badge-danger ml-3 <?= $visa_dependent->status_reject_dependent == 'Rejected' ? '' : 'hide'?>" id="label_reject_<?= $visa_dependent->id ?>">Rejected</span>
                <?php if($is_admin) { ?>
                <div class="btn-group pull-right">
                    <input data-type="record" data-log="<?= $visa_dependent->id ?>" data-dependent="1" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default btn-noaction payment-log mr-2" value="Open Log">
                    <button 
                        type="button" 
                        id="btn-reject-renewal-<?= $visa_dependent->id ?>" 
                        class="btn btn-xs btn-noaction btn-danger btn-reject-renewal btn-reject mr-2" 
                        data-dependent="1"
                        data-notereject="<?= $visa_dependent->note_reject ?>" 
                        data-attachment="<?= $visa_dependent->attachment_reject ?>" 
                        data-id="<?= $visa_dependent->id ?>">
                        Reject
                    </button>
                    <button type="button" data-visa_id="<?= $visa_dependent->id ?>" data-dependent="1" class="btn btn-noaction btn-danger btn-xs pull-right removeApplicant">
                        <i class="fa fa-trash fa-fw text-white"></i>
                    </button>
                </div>
                <?php } ?>
            </h4>
        </div>
    </a>
    <div id="collapseItemDependentl<?= $kvb ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-body"> 
            <div class="panel-group" id="accordionThree<?= $kvb ?>" role="tablist" aria-multiselectable="true">
                <?php if(has_permission('on_going', 'detail') || !$is_admin) { ?>
                <div class="panel">
                    <div class="panel-body">
                        <?php if($is_admin) { ?>
                        <div class="row mb-5">
                            <div class="col-lg-12">
                                <div class="TriSea-technologies-Switch">
                                    <!-- <span class="mr-2"> Show Visa for Dependent</span>
                                    <input onclick="show_hide_visa_dependent(this, <?= $visa_dependent->id ?>)" id="show_visa_dependent" name="dependent[<?= $kvb ?>][show_visa_dependent]" type="checkbox" <?= $visa_dependent->show_visa_dependent  ? 'checked' : '' ?>/>
                                    <label for="show_visa_dependent" class="label-primary"></label>
         -->
                                    <span> Enable Grantee</span>
                                    <input onclick="enable_toogle_grantee_ongoing(this, 'save_grantee', 1, <?= $visa_dependent->id ?>)" id="save_grantee_dependent_<?= $kvb ?>" name="dependent[<?= $kvb ?>][save_grantee_dependent]" type="checkbox" <?= !$visa_dependent->save_grantee  ? 'checked' : '' ?>/>
                                    <label for="save_grantee_dependent_<?= $kvb ?>" class="label-primary"></label>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- <div class="col-lg-8">
                            <div class="form-group">
                                <label>Visa Dependent Date</label>
                                <input type="text" name="dependent[<?= $kvb ?>][visa_dependent_date]" id="visa_dependent_date_<?= $kvb ?>" <?= !$is_admin && $visa_dependent->save_grantee ? 'disabled' : '' ?> class="form-control datepicker" value="<?= $visa_dependent->visa_dependent_date ? date('m/d/y', strtotime($visa_dependent->visa_dependent_date)) : '' ?>">
                                <?php if($is_admin) { ?>
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                <?php } ?>
                            </div>
                        </div> -->
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="label-location">Your visa interview appointment will be scheduled at the U.S. Consular Office located in</label>
                                <select class="form-control appointment_located_dependent" data-idxv="<?= $kvb ?>" data-index="<?= $kvb ?>" data-visa_id="<?= $visa_dependent->id ?>" name="dependent[<?= $kvb ?>][visa_dependent]" style="width:100%" <?= !$is_admin &&  $visa_dependent->save_grantee ? 'disabled' : '' ?> id="appointment_located_dependent_<?= $kvb ?>">
                                    <option value="">-- Select --</option>
                                    <option <?= $visa_dependent->appointment_located == 'Jakarta' ? 'selected' : '' ?> value="Jakarta">Jakarta</option>
                                    <option <?= $visa_dependent->appointment_located == 'Surabaya' ? 'selected' : '' ?> value="Surabaya">Surabaya</option>
                                </select>
                                <input type="hidden" name="dependent[<?= $kvb ?>][visa_dependent_id]" id="visa_dependent_id_<?= $kvb ?>" value="<?= $visa_dependent->id ?>">
                            </div>
                        </div>
                        <div class="col-lg-8" id="dependent-yes">
                            <div class="form-group">
                                <label class="label-location">
                                    Please confirm the number of dependent
                                </label>
                                <input type="number" class="form-control input_number new_number_of_dependent" id="new_number_of_dependent_<?= $kvb ?>" name="dependent[<?= $kvb ?>][new_number_of_dependent]" value="<?= $visa_dependent->number_of_dependent ?>" <?= !$is_admin &&  $visa_dependent->save_grantee ? 'disabled' : '' ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <a role="button" data-toggle="collapse" data-parent="#accordionThree<?= $kvb ?>" href="#collapseOneVisaDependent<?= $kvb ?>" aria-expanded="true" aria-controls="collapseOneVisaDependent<?= $kvb ?>" onclick="return set_session('before_visa_dependent')">
                        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                            <h4 class="panel-title">
                                Before Visa Interview
                            </h4>
                        </div>
                    </a>
                    <div id="collapseOneVisaDependent<?= $kvb ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa_dependent' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
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
                                        <a onclick="open_modal_validate_ongoing('list_appointment_dependent_<?= $kvb ?>', 'form_add_appointment_dependent', <?= $kvb ?>)" class="btn btn-primary my-2" style="color:#fff">Add New</a>
                                        <?php //} ?>
                                        <div class="table-responsive" style="overflow-x: auto;">
                                        <table class="table table-striped table-bordered table-appointment my-3">
                                            <thead>    
                                                <?php 
                                                    $final_appointment_data_dependent = $data_appointment_dependent[$visa_dependent->id];
                                                    $showAction = false;
                                                    if($final_appointment_data_dependent){
                                                        $showAction = array_reduce($final_appointment_data_dependent, function($carry, $item) {
                                                            return $carry || !empty($item->grantee_edit);
                                                        }, false);
                                                    }else{
                                                        $showAction = true;
                                                    }
                                                ?>
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
                                                    <!-- <th>Visa Interview Date</th> -->
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
                                            <tbody id="list_appointment_dependent_<?= $kvb ?>">
                                                <?php foreach($final_appointment_data_dependent as $index => $appointment) { ?>
                                                    <tr id="index-appointment-dependent-<?= $kvb ?>-<?= $index + 1 ?>">
                                                        <td class="sticky-col first-col"><?= $index + 1 ?> </td>
                                                        <td class="sticky-col second-col"><?= $appointment->last_name ?></td>
                                                        <td class="sticky-col third-col"><?= $appointment->first_name ?? 'FNU' ?></td>
                                                        <td><?= $appointment->date_of_birth ? date('m/d/y', strtotime($appointment->date_of_birth)) : '' ?></td>
                                                        <td><?= $appointment->passport ?></td>
                                                        <td><?= $appointment->passport_type ?></td>
                                                        <td><?= $appointment->nationality ?></td>
                                                        <td><?= $appointment->visa_type ?></td>
                                                        <td><?= $appointment->email ?></td>
                                                        <td><?= $appointment->ds160 ?></td>
                                                        <td><?= $appointment->program_number ?></td>
                                                        <td><?= $appointment->sevis_id ?></td>
                                                        <td><?= $appointment->telephone ?></td>
                                                        <!-- <td><?= $appointment->propose_date ? date('m/d/y', strtotime($appointment->propose_date)) : '' ?></td> -->
                                                        <td><?= $appointment->travel_plan ? date('m/d/y', strtotime($appointment->travel_plan)) : '' ?></td>
                                                        <td><?= $appointment->interview_location ?></td>
                                                        <?php if($is_admin || (!$is_admin && $showAction)){ ?>
                                                        <td>
                                                            <?php if($is_admin || $appointment->grantee_edit) { ?>
                                                            <a onclick="edit_data_appointment_ongoing(this, <?= $appointment->id ?>, <?= $index + 1 ?>, <?= $is_admin ? 1 : 0 ?>, true)" data-idxv="<?= $kvb ?>" data-visa_id="<?= $visa_dependent->id ?>" class="btn btn-primary btn-xs edit-appointment" style="color:#fff">
                                                                Edit
                                                            </a>
                                                            <a href="javascript:;" onclick="del_data_appointment_ongoing(this, <?= $appointment->id ?>, <?= $index+ 1  ?>, 1, <?= $kvb ?>)" class="btn btn-danger btn-xs" style="color:#fff">
                                                                <i class="fa fa-trash fa-fw text-white"></i>
                                                            </a>
                                                            <?php } ?>
                                                        </td>
                                                        <?php } ?>
                                                        <?php if($is_admin) { ?>
                                                        <td>
                                                            <div class="TriSea-technologies-Switch" style="margin-left:15px;">
                                                                <input onchange="grantee_edit_toa(this, 'appointment_on_going')" data-id="<?= $appointment->id ?>" name="dependent[<?= $kvb ?>][grantee_edit]" id="grantee_edit_apoin<?= $appointment->id ?>" type="checkbox" <?= $appointment->grantee_edit  ? 'checked' : '' ?>/>
                                                                <label for="grantee_edit_apoin<?= $appointment->id ?>" class="label-primary"></label>
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
                                                    <th>DS160 Visa Application</th>
                                                    <th>Photo 5x5</th>
                                                    <th>DS160 Confirmation Page</th>
                                                    <th>DS2019</th>
                                                    <th>Passport</th>
                                                    <!-- <th>Latest Visa</th> -->
                                                    <?php if($is_admin) { ?>
                                                    <th>PDF Merge</th>
                                                    <th>Grantee Upload</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody id="list_required_doc_dependent_<?= $kvb ?>">
                                                <?php 
                                                    $final_required_data_dependent = $data_required_doc_dependent[$visa_dependent->id];
                                                    foreach($final_required_data_dependent as $key => $data_required){
                                                    $required_fields = ['visa', 'ds160', 'ds2019', 'passport', 'photo'];
                                                    $complete = !array_filter($required_fields, fn($f) => empty($data_required->$f));
                                                    $data_required->first_name = $data_required->first_name ?: 'FNU';
                                                ?>
                                                <tr id="index-required-dependent-<?= $kvb ?>-<?= $key + 1 ?>">
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $data_required->last_name ?></td>
                                                    <td><?= $data_required->first_name ?? 'FNU' ?></td>
                                                    <td>
                                                        <?php if($data_required->visa) { ?>
                                                            <a href="<?= base_url($data_required->visa) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-visa" style="color:#fff">View</a>
                                                            <a href="<?= base_url($data_required->visa) ?>" download="<?= get_full_name($data_required) ?>_DS160 Complete Application" class="btn btn-info btn-xs btn-download-req-visa" style="color:#fff">Download</a>
                                                        <?php } ?>
                                                        <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-visa-<?= $data_required->id ?>" data-file-value="upload_require_doc_visa_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                        <input type="file" data-table_save="save_required_document" data-doc="visa" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_visa_<?= $data_required->id ?> hide">
                                                        <?php if($data_required->visa) { ?>
                                                            <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'visa', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-visa-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if($data_required->photo) { ?>
                                                            <a href="<?= base_url($data_required->photo) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-photo" style="color:#fff">View</a>
                                                            <a href="<?= base_url($data_required->photo) ?>" download="<?= get_full_name($data_required) ?>_Photo 5x5" class="btn btn-info btn-xs btn-download-req-photo" style="color:#fff">Download</a>
                                                        <?php } ?>
                                                        <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-photo-<?= $data_required->id ?>" data-file-value="upload_require_doc_photo_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                        <input type="file" data-table_save="save_required_document" data-doc="photo" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_photo_<?= $data_required->id ?> hide">
                                                        <?php if($data_required->photo) { ?>
                                                            <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'photo', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-photo-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if($data_required->ds160) { ?>
                                                            <a href="<?= base_url($data_required->ds160) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-ds160" style="color:#fff">View</a>
                                                            <a href="<?= base_url($data_required->ds160) ?>" download="<?= get_full_name($data_required) ?>_DS160 Confirmation Page" class="btn btn-info btn-xs btn-download-req-ds160" style="color:#fff">Download</a>
                                                        <?php } ?>
                                                        <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-ds160-<?= $data_required->id ?>" data-file-value="upload_require_doc_ds160_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                        <input type="file" data-table_save="save_required_document" data-doc="ds160" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_ds160_<?= $data_required->id ?> hide">
                                                        <?php if($data_required->ds160) { ?>
                                                            <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'ds160', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-ds160-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if($data_required->ds2019) { ?>
                                                            <a href="<?= base_url($data_required->ds2019) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-ds2019" style="color:#fff">View</a>
                                                            <a href="<?= base_url($data_required->ds2019) ?>" download="<?= get_full_name($data_required) ?>_DS2019" class="btn btn-info btn-xs btn-download-req-ds2019" style="color:#fff">Download</a>
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
                                                            <a href="<?= base_url($data_required->passport) ?>" download="<?= get_full_name($data_required) ?>_Passport" class="btn btn-info btn-xs btn-download-req-passport" style="color:#fff">Download</a>
                                                        <?php } ?>
                                                        <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-passport-<?= $data_required->id ?>" data-file-value="upload_require_doc_passport_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                        <input type="file" data-table_save="save_required_document" data-doc="passport" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_passport_<?= $data_required->id ?> hide">
                                                        <?php if($data_required->passport) { ?>
                                                            <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'passport', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-passport-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- <td>
                                                        <?php //if($data_required->lates_visa) { ?>
                                                            <a href="<?= base_url($data_required->lates_visa) ?>" class="btn btn-warning btn-xs lightbox btn-view-req-lates_visa" style="color:#fff">View</a>
                                                            <a href="<?= base_url($data_required->lates_visa) ?>" download="<?= get_full_name($data_required) ?>_Lates Visa" class="btn btn-info btn-xs btn-download-req-lates_visa" style="color:#fff">Download</a>
                                                        <?php //} ?>
                                                        <a href="javascript:;" class="btn btn-primary btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> upload-button-ongoing btn-lates_visa-<?= $data_required->id ?>" data-file-value="upload_require_doc_lates_visa_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                        <input type="file" data-table_save="save_required_document" data-doc="lates_visa" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_lates_visa_<?= $data_required->id ?> hide">
                                                        <?php //if($data_required->lates_visa) { ?>
                                                            <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_required->id ?>, 'lates_visa', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs hide-complete <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> btn-del-req-lates_visa-<?= $data_required->id ?>" style="color:#fff">Delete</a>
                                                        <?php //} ?>
                                                    </td> -->
        
                                                    <?php if($is_admin) { ?>
                                                    <td>
                                                        <?php 
                                                            $url_download = $is_admin ? base_url('admin/on_going/download_merge/' . $data_required->appointment_id) : base_url('grantee/submission/download_merge_ongoing/' . $data_required->appointment_id) ;
                                                        ?>
                                                        <a href="<?= $url_download ?>" class="btn btn-primary btn-xs btn-download-merge" style="color:#fff;">Download</a>
                                                    </td>
                                                    <td>
                                                        <div class="TriSea-technologies-Switch" style="margin-left:35px;">
                                                            <input onchange="grantee_edit_toa(this, 'visa_required_document_on_going')" data-id="<?= $data_required->id ?>" name="dependent[<?= $kvb ?>][grantee_edit]" id="grantee_edit_req_<?= $data_required->id ?>" type="checkbox" <?= $data_required->grantee_edit  ? 'checked' : '' ?>/>
                                                            <label for="grantee_edit_req_<?= $data_required->id ?>" class="label-primary"></label>
                                                        </div>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <?php } ?>
        
                <div class="panel panel-default">
                    <a role="button" data-toggle="collapse" data-parent="#accordionThree<?= $kvb ?>" href="#collapseRequestDependent<?= $kvb ?>" aria-expanded="true" aria-controls="collapseRequestDependent<?= $kvb ?>" onclick="return set_session('appointment_confirmation_dependent')">
                        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                            <h4 class="panel-title">
                                Visa Interview Appointment Confirmation
                            </h4>
                        </div>
                    </a>
                    <div id="collapseRequestDependent<?= $kvb ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'appointment_confirmation_dependent' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
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
                                            <input onclick="enable_toogle_ongoing(this, 1)" data-id="<?= $grantee_grant->id ?>" id="enable_visa_interview_appointment_dependent_<?= $kvb ?>" name="dependent[<?= $kvb ?>][enable_visa_interview_appointment_dependent]" type="checkbox" <?= $visa_dependent->enable_visa_interview_appointment_dependent  ? 'checked' : '' ?>/>
                                            <label for="enable_visa_interview_appointment_dependent_<?= $kvb ?>" class="label-primary"></label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
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
                                                    id="date_dependent_<?= $kvb ?>" 
                                                    type="text" 
                                                    class="form-control datepicker"  
                                                    style="background-color:#<?= $is_admin || ($visa_dependent->enable_visa_interview_appointment_dependent && !$is_admin) ? 'fff' : 'eee' ?>" 
                                                    <?= $is_admin || ($visa_dependent->enable_visa_interview_appointment_dependent && !$is_admin) ? 'readonly' : 'disabled' ?>
                                                    placeholder="Date" 
                                                    name="dependent[<?= $kvb ?>][date_dependent]"
                                                    value="<?= $visa_dependent  ? ($visa_dependent->date != '' ? date('d M Y', strtotime($visa_dependent->date)) : '') : '' ?>">
                                                <?php //if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                                <?php if($is_admin || ($visa_dependent->enable_visa_interview_appointment_dependent && !$is_admin)) { ?>
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Time</label>
                                                <input 
                                                    type="text" 
                                                    id="time_dependent_<?= $kvb ?>" 
                                                    class="form-control input_time" 
                                                    name="dependent[<?= $kvb ?>][time_dependent]"
                                                    <?= $is_admin || ($visa_dependent->enable_visa_interview_appointment_dependent && !$is_admin) ? '' : 'disabled' ?>
                                                    value="<?= $visa_dependent  ? ($visa_dependent->date != '' ? (date('H:i', strtotime($visa_dependent->date)) == '00:00' ? '' : date('h:i A', strtotime($visa_dependent->date)) ) : '') : '' ?>" 
                                                    placeholder="Time">
                                                    <?php if($is_admin || ($visa_dependent->enable_visa_interview_appointment_dependent && !$is_admin)) { ?>
                                                    <a href="javascript:;" onclick="emptyValueTime(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                    <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <!-- <input type="text" class="form-control" <?= !$is_admin ? 'readonly' : '' ?> name="location" id="location" value="<?= $visa_dependent->location ?>"> -->
                                                <select class="form-control" id="location_dependent_<?= $kvb ?>" name="dependent[<?= $kvb ?>][location_dependent]" style="width:100%" <?= $is_admin || ($visa_dependent->enable_visa_interview_appointment_dependent && !$is_admin) ? '' : 'disabled' ?>>
                                                    <option value="">-- Select --</option>
                                                    <option <?= $visa_dependent->location == 'Jakarta' ? 'Selected' : '' ?> value="Jakarta">Jakarta</option>
                                                    <option <?= $visa_dependent->location == 'Surabaya' ? 'Selected' : '' ?> value="Surabaya">Surabaya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Appointment Confirmation Letter</label>
                                                <?php if($is_admin || ($visa_dependent->enable_visa_interview_appointment_dependent && !$is_admin)) { ?>
                                                <input id="invitation_letter_dependent_<?= $kvb ?>" type="file" class="form-control" name="invitation_letter_dependent_<?= $kvb ?>">
                                                <?php } ?>
                                                <?php if ($grantee_grant && $visa_dependent->invitation_letter != '') { ?>
                                                    <br>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_invitation_letter_dependent_<?= $kvb ?>">
                                                        <a href="<?=base_url() ?><?=$visa_dependent->invitation_letter ?>" class="lightbox" aria-haspopup="dialog">
                                                            <img id="preview_image_profile" data-old="<?php echo site_url($visa_dependent->invitation_letter); ?>" src="<?php echo get_preview($visa_dependent->invitation_letter); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                        </a>
                                                        <a href="<?=base_url() ?><?=$visa_dependent->invitation_letter ?>" id="button_download_img_photo" download="<?= get_full_name($grantee_grant) ?>_Dependent_Appointment Confirmation Letter" title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_dependent->invitation_letter) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                            <i class="fa fa-download fa-fw"></i>
                                                        </a>
                                                        <?php if($is_admin || ($visa_dependent->enable_visa_interview_appointment_dependent && !$is_admin)) { ?>
                                                        <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                            <label class="btn btn-xs btn-danger" onclick="delete_file_visa_dependent(this, 'invitation_letter', <?= $is_admin ? 1 : 0 ?>, true, <?= $kvb ?>)"><i class="fa fa-trash fa-fw"></i></label>
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
                <div class="panel panel-default">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionThree<?= $kvb ?>" href="#collapseTwoVisaDependent<?= $kvb ?>" aria-expanded="false" aria-controls="collapseTwoVisaDependent<?= $kvb ?>" onclick="return set_session('interview_apointment_dependent')">
                        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                            <h4 class="panel-title">
                                After Visa Interview
                            </h4>
                        </div>
                    </a>
                    <div id="collapseTwoVisaDependent<?= $kvb ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment_dependent' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control"  name="dependent[<?= $kvb ?>][status_visa_dependent]" style="width:100%" <?= !$is_admin &&  $visa_dependent->save_grantee && $visa_dependent->status_visa_dependent == 'Issued' ? 'disabled' : '' ?> id="status_visa_dependent">
                                    <option value="">-- Select --</option>
                                    <option <?= $visa_dependent->status_visa_dependent == 'Refused' ? 'selected' : '' ?> value="Refused">Refused</option>
                                    <option <?= $visa_dependent->status_visa_dependent == 'Approved' ? 'selected' : '' ?> value="Approved">Approved</option>
                                    <option <?= $visa_dependent->status_visa_dependent == 'Issued' ? 'selected' : '' ?> value="Issued">Issued</option>
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
                                        <tbody id="list_ds2019sign_visapage_dependent_<?= $kvb ?>">
                                            <?php 
                                                $final_ds2019_sign_data_dependent = $data_ds2019_sign_dependent[$visa_dependent->id];
                                                foreach($final_ds2019_sign_data_dependent as $key => $data_sign){ 
                                                    $data_sign->dont_have_first_name = $data_sign->first_name ? false : true;
                                            ?>
                                            <tr id="index-sign-dependent-<?= $kvb ?>-<?= $key + 1 ?>">
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $data_sign->last_name ?></td>
                                                <td><?= $data_sign->first_name ?? 'FNU' ?></td>
                                                <td>
                                                    <?php if($data_sign->ds2019_sign) { ?>
                                                        <a href="<?= base_url($data_sign->ds2019_sign) ?>" class="lightbox btn btn-warning btn-xs btn-xs btn-view-req-ds2019_sign" style="color:#fff">View</a>
                                                        <a href="<?= base_url($data_sign->ds2019_sign) ?>" download="<?= get_full_name($data_sign) . '_Dependent_Signed DS2019' ?>" class="btn btn-info btn-download-req-ds2019_sign btn-xs" style="color:#fff">Download</a>
                                                    <?php } ?>
                                                    <?php //if($is_admin) { ?>
                                                    <a href="javascript:;" class="btn btn-primary upload-button-ongoing btn-xs btn-ds2019_sign-<?= $data_sign->id ?>" data-file-value="upload_require_doc_ds2019_sign_<?= $data_sign->id ?>" style="color:#fff;">Upload</a>
                                                    <?php //} ?>
                                                    <input type="file" data-table_save="save_ds2019_sign" data-doc="ds2019_sign" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_sign->id ?>" class="upload_require_doc_ds2019_sign_<?= $data_sign->id ?> hide">
                                                    <?php if($data_sign->ds2019_sign) { ?>
                                                        <?php //if($is_admin) { ?>
                                                        <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_sign->id ?>, 'ds2019_sign', 'delete_save_ds2019_sign', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs btn-del-req-ds2019_sign-<?= $data_sign->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php //} ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if($data_sign->visa_page) { ?>
                                                        <a href="<?= base_url($data_sign->visa_page) ?>" class="lightbox btn btn-warning btn-xs btn-view-req-visa_page" style="color:#fff">View</a>
                                                        <a href="<?= base_url($data_sign->visa_page) ?>" download="<?= get_full_name($data_sign) . '_Dependent_Visa' ?>" class="btn btn-info btn-download-req-visa_page btn-xs" style="color:#fff">Download</a>
                                                    <?php } ?>
                                                    <?php //if($is_admin) { ?>
                                                    <a href="javascript:;" class="btn btn-primary upload-button-ongoing btn-xs btn-visa_page-<?= $data_sign->id ?>" data-file-value="upload_require_doc_visa_page_<?= $data_sign->id ?>" style="color:#fff;">Upload</a>
                                                    <?php //} ?>
                                                    <input type="file" data-table_save="save_ds2019_sign" data-doc="visa_page" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_sign->id ?>" class="upload_require_doc_visa_page_<?= $data_sign->id ?> hide">
                                                    <?php if($data_sign->visa_page) { ?>
                                                        <?php //if($is_admin) { ?>
                                                        <a href="javascript:;" onclick="del_data_required_ongoing(this, <?= $data_sign->id ?>, 'visa_page', 'delete_save_ds2019_sign', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs btn-del-req-visa_page-<?= $data_sign->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php //} ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </ul>
                            </div>
                            <hr />
                            <?php if($is_admin || (!$is_admin && $visa_dependent->appointment_located == 'Jakarta')) { ?>
                            <div class="form-group section-obtaining-dependent">
                                <label>Obtaining Passport, Visa, and DS2019 Documents</label><br />
                                <label class="mt-5 together_with_dependent hide">Would you go to the US together with your dependent?</label>
                                <?php if($visa_dependent->obtaining_departur_document_dependent || $is_admin) { ?>
                                <p class="mt-3">You can obtain the documents at:</p>
                                <?php } ?>
                                <div class="panel-body">
                                    <div class="panel-body">
                                        <div class="col-lg-8">
                                            <label>Grantee Pickup Document</label>
                                            <select onchange="toggleObtainingSectionDependent(<?= $kvb ?>)" id="obtaining_departur_document_dependent_<?= $kvb ?>" class="form-control" name="dependent[<?= $kvb ?>][obtaining_departur_document_dependent]" style="width:100%" <?= !$is_admin ? 'disabled' : '' ?>>
                                                <option value="">-- Select --</option>
                                                <option <?= $visa_dependent->obtaining_departur_document == 'AMINEF Office' ? 'selected' : ''?> value="AMINEF Office">AMINEF Office</option>
                                                <option <?= $visa_dependent->obtaining_departur_document == 'Self Collection' ? 'selected' : '' ?> value="Self Collection">Self Collection</option>
                                                <!-- <option <?= $visa_dependent->obtaining_departur_document == 'Hotel' ? 'selected' : ''?> value="Hotel">Hotel arranged by AMINEF</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body obtaining-section-dependent-<?= $kvb ?> <?= $visa_dependent->obtaining_departur_document == 'AMINEF Office' || $visa_dependent->obtaining_departur_document == '' ? 'hide' : '' ?>">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Hotel Name</label>
                                                <input class="form-control" type="input" name="dependent[<?= $kvb ?>][hotel_name_dependent]" <?= !$is_admin ? 'disabled' : '' ?> value="<?= $visa_dependent->hotel_name ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 obtaining-section-dependent-<?= $kvb ?> <?= $visa_dependent->obtaining_departur_document == '' || $visa_dependent->obtaining_departur_document == 'AMINEF Office' ? 'hide' : '' ?>">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" <?= !$is_admin ? 'disabled' : '' ?> name="dependent[<?= $kvb ?>][address_dependent]"><?= $visa_dependent->address ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 obtaining-section-dependent-<?= $kvb ?>">
                                            <div class="form-group">
                                                <label>Appointment Date</label>
                                                <input id="appointment_date_dependent_<?= $kvb ?>" type="text" class="form-control datepicker" readonly style="background-color:#<?= $is_admin ? 'fff' : 'eee' ?>" placeholder="Date" name="dependent[<?= $kvb ?>][appointment_date_dependent]" <?= !$is_admin ? 'disabled' : '' ?> value="<?= $visa_dependent  ? ($visa_dependent->appointment_date != '' ? date('d M Y', strtotime($visa_dependent->appointment_date)) : '') : '' ?>">
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
                                                <select class="form-control point_of_contact_dependent" <?= $is_admin ? '' : 'disabled' ?> name="dependent[<?= $kvb ?>][point_of_contact_dependent]" onchange="select_staff_ongoing(this, true, <?= $is_admin ? 1 : 0 ?>, <?= $kvb ?>)">
                                                    <option>-- Select --</option>
                                                    <?php foreach($staffs as $staff) { ?>
                                                        <option <?= $visa_dependent->point_of_contact == $staff->id ? 'selected' : ''?> data-email="<?= $staff->email ?>" data-telephone="<?= $staff->telephone ?>" value="<?= $staff->id ?>"><?= $staff->full_name?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="input" id="email_dependent_ongoing_<?= $kvb ?>" name="dependent[<?= $kvb ?>][email_dependent]" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_dependent->email ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Telephone</label>
                                                <input class="form-control" type="input" name="dependent[<?= $kvb ?>][telephone_dependent_ongoing]" id="telephone_dependent_ongoing_<?= $kvb ?>" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_dependent->telephone ?>">
                                            </div>
                                        </div>
                                        <?php if (($visa_dependent && $visa_dependent->receipt != '') || $is_admin) { ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Receipt</label>
                                                <?php if($is_admin) { ?>
                                                <input id="receipt" type="file" class="form-control" name="receipt_dependent_<?= $kvb ?>">
                                                <?php } ?>
                                                <?php if ($visa_dependent && $visa_dependent->receipt != '') { ?>
                                                    <br>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_receipt_<?= $kvb ?>">
                                                        <a href="<?=base_url() ?><?=$visa_dependent->receipt ?>" class="lightbox" aria-haspopup="dialog">
                                                            <img id="preview_image_profile" data-old="<?php echo site_url($visa_dependent->receipt); ?>" src="<?php echo get_preview($visa_dependent->receipt); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                        </a>
                                                        <a href="<?=base_url() ?><?=$visa_dependent->receipt ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_dependent->receipt) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                            <i class="fa fa-download fa-fw"></i>
                                                        </a>
                                                        <?php if($is_admin) { ?>
                                                        <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                            <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'receipt', <?= $is_admin ?>, true, <?= $kvb ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                        </a>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <small class="section-obtaining-dependent"><i>No mailing service provided for this purpose to avoid any delivery risk which cause the lost document during shipment.</i></small>
                            <hr class="section-obtaining-dependent" />
                            <?php } ?>
                        </div>
                    </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>