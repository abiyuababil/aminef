
<?php if($is_admin) { ?>
<div class="row mb-5 hide">
    <div class="col-lg-12">
        <div class="TriSea-technologies-Switch">
            <span class="mr-2"> Set to Visa Interview</span>
            <input id="set_to_visa_interview" name="set_to_visa_interview" type="checkbox" <?= $grantee_grant->set_to_visa_interview  ? 'checked' : '' ?>/>
            <label for="set_to_visa_interview" class="label-primary"></label>
        </div>
    </div>
</div>
<?php } ?>
<div class="panel-group" id="accordionInterview" role="tablist" aria-multiselectable="true">
    <?php if(has_permission('nominee', 'departure') || !$is_admin) { ?>
    <div class="panel">
        <div class="panel-body">
            <div class="col-lg-8">
                <div class="form-group">
                    <label>Your visa interview appointment will be scheduled at the U.S. Consular Office located in</label>
                    <select class="form-control"  name="visa" style="width:100%" <?= $is_admin ? '' : 'disabled' ?> id="appointment_located">
                        <option value="">-- Select --</option>
                        <option <?= $visa_interview->appointment_located == 'Jakarta' ? 'selected' : '' ?> value="Jakarta">Jakarta</option>
                        <option <?= $visa_interview->appointment_located == 'Surabaya' ? 'selected' : '' ?> value="Surabaya">Surabaya</option>
                    </select>
                    <input type="hidden" name="visa_interview_id" value="<?= $visa_interview->id ?>">
                </div>
            </div>
            <?php if($is_admin) { ?>
            <div class="col-lg-8">
                <div class="form-group">
                    <label>
                        Does the grant recipient have any dependents?
                    </label>
                    <select class="form-control" id="have_dependent" name="have_dependent" style="width:100%" <?= $is_admin ? '' : 'disabled' ?>>
                        <option value="">-- Select --</option>
                        <option <?= $visa_interview->have_dependent == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                        <option <?= $visa_interview->have_dependent == 'No' ? 'selected' : '' ?> value="No">No</option>
                    </select>
                </div>
            </div>
            <?php } else { ?>
                <input id="have_dependent" class="select_show hidden" value="<?= $visa_interview->have_dependent ?>">
            <?php } ?>
            <div class="col-lg-8 <?= $visa_interview->have_dependent == 'Yes' ? '' : 'hide' ?>" id="dependent-yes">
                <div class="form-group">
                    <label>
                        Please confirm the number of dependent
                    </label>
                    <input type="number" class="form-control input_number" id="number_of_dependent" name="number_of_dependent" value="<?= $visa_interview->number_of_dependent ?>" <?= !$is_admin &&  $visa_interview->save_grantee ? 'disabled' : '' ?>>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <a role="button" data-toggle="collapse" data-parent="#accordionInterview" href="#collapseOneInterview" aria-expanded="true" aria-controls="collapseOneInterview" onclick="return set_session('before_visa')">
            <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                <h4 class="panel-title">
                    Before Visa Interview
                </h4>
            </div>
        </a>
        <div id="collapseOneInterview" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-body">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>DS2019</label><br />
                    <?php if(!$is_admin) { ?>
                        <?php if($visa_interview->ds2019) { ?>
                        <!-- <a href="<?= base_url($visa_interview->ds2019) ?>" download title="Click to Download" class="btn btn-primary" style="color:#fff">
                            <i class="fa fa-download fa-fw text-white"></i> Download DS2019
                        </a><br /> -->
                        <?php } ?>
                        <small>Print in color and sign the document. <u><i>Do NOT alter the DS-2019 form in any way.</i></u></small>
                    <?php } else { ?>
                        <!-- <img data-trigger="my_file" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image" class="preview_image lightbox" src="<?php echo $visa_interview->ds2019 ? get_preview($visa_interview->ds2019) : base_url('assets/images/icons/add-file.png'); ?>">
                        <br />
                        <a href="javascript:;" id="my_file" class="btn btn-primary upload-ds2019 mt-3" data-file-value="upload_ds2019" style ="color:#fff;">Upload</a>
                        <a href="<?= base_url($visa_interview->ds2019) ?>" class="btn btn-warning fileview-ds2019 lightbox mt-3 <?= $visa_interview->ds2019 ? '' : 'hide' ?>" style ="color:#fff;"><i class="fa fa-eye fa-fw"></i> Preview</a>
                        <a href="javascript:;" onclick="delete_file_visa(this)" class="btn btn-danger delete-ds2019 mt-3 <?= $visa_interview->ds2019 ? '' : 'hide' ?>" style ="color:#fff;"><i class="fa fa-trash fa-fw text-white"></i></a>
                        <input onchange="show_preview(this)" type="file" data-doc="ds2019" class="upload_ds2019 hide"> -->
                    <?php } ?>


                    <?php if($is_admin){ ?>
                    <a class="btn btn-primary my-2" onclick="open_modal_validate('ds2019_list', 'upload_ds2019')" style="color:#fff">Add New</a>
                    <?php } ?>
                    <table id="<?= $is_admin ? 'table-ds2019' : '' ?>" class="table table-striped table-bordered table-responsive my-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File Name</th>
                                <th>Extension</th>
                                <th>Upload Date</th>
                                <?php if($is_admin){ ?>
                                <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="ds2019_list">
                            <?php
                                foreach($data_ds2019 as $index => $ds2019) { 
                                $detail_file = [];
                                $file_ds2019 = '';
                                if($ds2019->file){
                                    $data_ds = explode('/', $ds2019->file);
                                    $file_ds2019 = $data_ds ? end($data_ds) : '';
                                    $detail_file = $data_ds ? explode('.', $file_ds2019) : '';
                                }

                            ?>
                            <tr data-id="<?= $ds2019->id ?>">
                                <td><?= $index + 1 ?></td>
                                <td><a href="<?= base_url($ds2019->file) ?>" class="lightbox" style="color:#337ab7"><?= $file_ds2019 ?></a></td>
                                <td><?= end($detail_file) ?></td>
                                <td><?= $ds2019->created_date ?></td>
                                <?php if($is_admin){ ?>
                                <td>
                                    <a href="javascript:;" onclick="del_data_ds2019(this, <?= $ds2019->id ?>, <?= $is_admin ?>)" class="btn btn-danger btn-xs" style="color:#fff">
                                        <i class="fa fa-trash fa-fw text-white"></i>
                                    </a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php if($is_admin) { ?>
                    <div class="alert alert-info mt-4"><i class="fa fa-info-circle"></i> Drag & Drop Row to sort Order</div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label>Guideline for completing and signing your DS2019</label><br />
                    <a href="<?= base_url($grantee_grant->guideline_ds2019) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_ds2019 ? '' : 'hide' ?>" style="color:#fff">
                        <i class="fa fa-download fa-fw text-white"></i> Download Guideline DS2019
                    </a>
                </div>
                <div class="form-group">
                    <label>Visa Application Form</label>
                    <ul>
                        <li>Complete the online visa application form:</li>
                            <p>Form DS160: <a target="_blank" style="color:#337ab7" href="https://ceac.state.gov/GenNIV/">https://ceac.state.gov/GenNIV/</a></p>
                        <li>Pay attention to the information below while completing the form DS160:</li>
                            <?php if($is_admin) { ?>
                            <a onclick="open_modal_validate('list_ds160', 'form_add_ds160')" class="btn btn-primary my-2" style="color:#fff">Add New</a>
                            <?php } ?>
                            <table class="table table-striped table-bordered table-responsive table-ds160 my-3">
                                <thead>   
                                    <tr>
                                        <th>No</th>
                                        <th>Surename/Last Name</th>
                                        <th>Given Name/First Name</th>
                                        <th>SEVIS ID</th>
                                        <th>Program Number</th>
                                        <th>Program Starting Date</th>
                                        <th>Program End Date</th>
                                        <th>Interview Location</th>
                                        <!-- <th>Proposed Visa Interview Date</th> -->
                                        <?php if($is_admin) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                    </tr>    
                                </thead>
                                <tbody id="list_ds160">
                                    <?php foreach($data_ds160 as $index => $ds160) { ?>
                                        <tr id="index-<?= $index + 1 ?>">
                                            <td><?= $index + 1 ?> </td>
                                            <td><?= $ds160->last_name ?></td>
                                            <td><?= $ds160->first_name ?? 'FNU' ?></td>
                                            <td><?= $ds160->sevis_id ?></td>
                                            <td><?= $ds160->program_number ?></td>
                                            <td><?= $ds160->start_date ? date('m/d/y', strtotime($ds160->start_date)) : '' ?></td>
                                            <td><?= $ds160->end_date ? date('m/d/y', strtotime($ds160->end_date)) : '' ?></td>
                                            <td><?= $ds160->interview_location ?></td>
                                            <!-- <td><?= $ds160->propose_date ? date('m/d/y', strtotime($ds160->propose_date)) : '' ?></td> -->
                                            <?php if($is_admin) { ?>
                                            <td>
                                                <a onclick="edit_data_ds160(this, <?= $ds160->id ?>, <?= $index + 1 ?>)" class="btn btn-primary btn-xs edit-ds160" style="color:#fff">
                                                    Edit
                                                </a>
                                                <a href="javascript:;" onclick="del_data_ds160(this, <?= $ds160->id ?>, <?= $index + 1 ?>)" class="btn btn-danger btn-xs" style="color:#fff">
                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                </a>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <a href="<?= base_url($grantee_grant->guideline_ds160) ?>" download title="Click to Download" class="btn btn-primary mt-2 mb-3 <?= $grantee_grant->guideline_ds160 ? '' : 'hide' ?>" style="color:#fff">
                                <i class="fa fa-download fa-fw text-white"></i> Download Guideline DS160
                            </a>
                            <a href="<?= base_url($grantee_grant->dependent_guideline_ds160) ?>" download title="Click to Download" class="<?= $grantee_grant->dependent_guideline_ds160 ? '' : 'hide' ?> btn btn-primary mt-2 mb-3" style="color:#fff">
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
                            <!-- <a onclick="open_modal_validate('list_appointment', 'form_add_appointment')" class="btn btn-primary my-2" style="color:#fff">Add New</a> -->
                            <?php //} ?>
                            <div class="table-responsive" style="overflow-x: auto;">
                            <input type="hidden" value="<?= $data_appointment ? $data_appointment[0]->deadline : '' ?>" id="deadlinedate">
                            <table class="table table-striped table-bordered table-appointment my-3">
                                <thead>   
                                    <?php 
                                    $showAction = false;
                                    if($data_appointment){
                                        $showAction = array_reduce($data_appointment, function($carry, $item) {
                                            return $carry || !empty($item->grantee_edit);
                                        }, false);
                                    }
                                    ?>
                                    <tr>
                                        <th>No</th>
                                        <th>Surename/Last Name</th>
                                        <th>Given Name/First Name</th>
                                        <!-- <th>Deadline</th> -->
                                        <th>Date of Birth</th>
                                        <th>Passport</th>
                                        <th>Passport Type</th>
                                        <th>Nationality</th>
                                        <th>Visa Type</th>
                                        <th>Email</th>
                                        <th>DS-160 Confirmation Number</th>
                                        <th>SEVIS ID</th>
                                        <th>Interview Location</th>
                                        <!-- <th>Visa Interview Date</th> -->
                                        <th>Travel Plan</th>
                                        <th>Telephone Number</th>
                                        <?php if($is_admin || (!$is_admin && $showAction)){ ?>
                                        <th>Action</th>
                                        <?php } ?>
                                        <?php if($is_admin) { ?>
                                            <th>Enable Edit</th>
                                        <?php } ?>
                                    </tr>    
                                </thead>
                                <tbody id="list_appointment">
                                    <?php foreach($data_appointment as $index => $appointment) { ?>
                                        <tr id="index-appointment-<?= $index + 1 ?>">
                                            <td><?= $index + 1 ?> </td>
                                            <td><?= $appointment->last_name ?></td>
                                            <td><?= $appointment->first_name ?? 'FNU' ?></td>
                                            <!-- <td><?= $appointment->deadline ? date('m/d/y', strtotime($appointment->deadline)) : '' ?></td> -->
                                            <td><?= $appointment->date_of_birth ? date('m/d/y', strtotime($appointment->date_of_birth)) : '' ?></td>
                                            <td><?= $appointment->passport ?></td>
                                            <td><?= $appointment->passport_type ?></td>
                                            <td><?= $appointment->nationality ?></td>
                                            <td><?= $appointment->visa_type ?></td>
                                            <td><?= $appointment->email ?></td>
                                            <td><?= $appointment->ds160 ?></td>
                                            <td><?= $appointment->sevis_id ?></td>
                                            <td><?= $appointment->interview_location ?></td>
                                            <!-- <td><?= $appointment->propose_date ? date('m/d/y', strtotime($appointment->propose_date)) : '' ?></td> -->
                                            <td><?= $appointment->travel_plan ? date('m/d/y', strtotime($appointment->travel_plan)) : '' ?></td>
                                            <td><?= $appointment->telephone ?></td>
                                            <?php if($is_admin || (!$is_admin && $showAction)){ ?>
                                            <td>
                                                <?php if($is_admin || $appointment->grantee_edit ){ ?>
                                                <a onclick="edit_data_appointment(this, <?= $appointment->id ?>, <?= $index + 1 ?>, <?= $is_admin ?>)" class="btn btn-primary btn-xs edit-appointment" style="color:#fff">
                                                    Edit
                                                </a>
                                                <?php } ?>
                                                <?php if($is_admin) { ?>
                                                    <a href="javascript:;" onclick="del_data_appointment(this, <?= $appointment->id ?>, <?= $is_admin ?>)" class="btn btn-danger btn-xs" style="color:#fff">
                                                        <i class="fa fa-trash fa-fw text-white"></i>
                                                    </a>
                                                    <?php } ?>
                                            </td>
                                            <?php } ?>
                                            <?php if($is_admin) { ?>
                                            <td>
                                                <div class="TriSea-technologies-Switch" style="margin-left:15px;">
                                                    <input onchange="grantee_edit_required(this, 'appointment')" data-id="<?= $appointment->id ?>" name="grantee_edit" id="grantee_edit_appointment<?= $appointment->id ?>" type="checkbox" <?= $appointment->grantee_edit  ? 'checked' : '' ?>/>
                                                    <label for="grantee_edit_appointment<?= $appointment->id ?>" class="label-primary"></label>
                                                </div>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        <li>Required Documents:</li>

                            <!-- <a class="btn btn-primary my-2" style="color:#fff" data-toggle="modal" data-target="#form_require_doc">Add New</a> -->
                            <!-- <a class="btn btn-primary my-2" style="color:#fff" id="add_new_required">Add New</a> -->
                            <!-- default grantee table  -->
                            <!-- <div class="wrap-required">
                                <table class="table table-striped table-responsive table-required my-3">
                                    <thead>
                                        <tr>
                                            <th>Document Name</th>
                                            <th>File</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Visa Application</td>
                                            <td>
                                                <?php if($data_required_doc_default->visa) { ?>
                                                    <a href="<?= base_url($data_required_doc_default->visa) ?>" class="lightbox" style="color:#337ab7"><?= file_name($data_required_doc_default->visa) ?></a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="javascript:;" class="btn mr-2 btn-primary upload-button btn-xs btn-visa-" data-file-value="upload_require_doc_visa" style="color:#fff;">Upload</a>
                                                <input type="file" data-doc="visa" data-default="1" class="upload_require_doc_visa hide">
                                                <?php if($data_required_doc_default->visa) { ?>
                                                    <a href="javascript:;" onclick="del_data_required(this, <?= $grantee_grant->id ?>, 'visa')" class="btn btn-danger btn-xs btn-del-req-visa" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">DS160 Confirmation Page</td>
                                            <td>
                                                <?php if($data_required_doc_default->ds160) { ?>
                                                    <a href="<?= base_url($data_required_doc_default->ds160) ?>" class="lightbox" style="color:#337ab7"><?= file_name($data_required_doc_default->ds160) ?></a>
                                                <?php } ?>
                                            </td>
                                            <td width="30%">
                                                <a href="javascript:;" class="btn mr-2 btn-primary upload-button btn-xs btn-ds160-" data-file-value="upload_require_doc_ds160" style="color:#fff;">Upload</a>
                                                <input type="file" data-doc="ds160" data-default="1" class="upload_require_doc_ds160 hide">
                                                <?php if($data_required_doc_default->ds160) { ?>
                                                    <a href="javascript:;" onclick="del_data_required(this, <?= $grantee_grant->id ?>, 'ds160')" class="btn btn-danger btn-xs btn-del-req-ds160" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Passport</td>
                                            <td>
                                                <?php if($data_required_doc_default->passport) { ?>
                                                    <a href="<?= base_url($data_required_doc_default->passport) ?>" class="lightbox" style="color:#337ab7"><?= file_name($data_required_doc_default->passport) ?></a>
                                                <?php } ?>
                                            </td>
                                            <td width="30%">
                                                <a href="javascript:;" class="btn mr-2 btn-primary upload-button btn-xs btn-passport-" data-file-value="upload_require_doc_passport" style="color:#fff;">Upload</a>
                                                <input type="file" data-doc="passport" data-default="1" class="upload_require_doc_passport hide">
                                                <?php if($data_required_doc_default->passport) { ?>
                                                    <a href="javascript:;" onclick="del_data_required(this, <?= $grantee_grant->id ?>, 'passport')" class="btn btn-danger btn-xs btn-del-req-passport" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Photo 5x5</td>
                                            <td>
                                                <?php if($data_required_doc_default->photo) { ?>
                                                    <a href="<?= base_url($data_required_doc_default->photo) ?>" class="lightbox" style="color:#337ab7"><?= file_name($data_required_doc_default->photo) ?></a>
                                                <?php } ?>
                                            </td>
                                            <td width="30%">
                                                <a href="javascript:;" class="btn mr-2 btn-primary upload-button btn-xs btn-photo-" data-file-value="upload_require_doc_photo" style="color:#fff;">Upload</a>
                                                <input type="file" data-doc="photo" data-default="1" class="upload_require_doc_photo hide">
                                                <?php if($data_required_doc_default->photo) { ?>
                                                    <a href="javascript:;" onclick="del_data_required(this, <?= $grantee_grant->id ?>, 'photo')" class="btn btn-danger btn-xs btn-del-req-photo" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> -->

                                <!-- other required doc  -->
                                <table class="table table-striped table-bordered table-responsive table-required my-3">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Surename/Last Name</th>
                                            <th>Given Name/First Name</th>
                                            <th>DS160 Visa Application</th>
                                            <th>DS160 Confirmation Page</th>
                                            <th>Signed DS2019</th>
                                            <th>Passport</th>
                                            <th>Photo 5x5</th>
                                            <?php if($is_admin) { ?>
                                            <th>PDF Merge</th>
                                            <th>Enable Upload</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="list_required_doc">
                                        <?php 
                                            foreach($data_required_doc as $key => $data_required){ 
                                            $required_fields = ['visa', 'ds160', 'ds2019', 'passport', 'photo'];
                                            $complete = !array_filter($required_fields, fn($f) => empty($data_required->$f));
                                            $data_required->first_name = $data_required->first_name ?: 'FNU';
                                        ?>
                                        <tr id="index-required-<?= $key + 1 ?>">
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $data_required->last_name ?></td>
                                            <td><?= $data_required->first_name ?? 'FNU' ?></td>
                                            <td>
                                                <?php if($data_required->visa) { ?>
                                                    <a href="<?= base_url($data_required->visa) ?>" class="lightbox btn btn-warning btn-xs btn-xs btn-view-req-visa" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->visa) ?>" download="<?= get_full_name($data_required) ?>_DS160 Complete Application" class="btn btn-info btn-xs btn-download-req-visa" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary upload-button <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-xs btn-visa-<?= $data_required->id ?>" data-file-value="upload_require_doc_visa_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="visa" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_visa_<?= $data_required->id ?> hide">
                                                <?php if($data_required->visa) { ?>
                                                    <a href="javascript:;" onclick="del_data_required(this, <?= $data_required->id ?>, 'visa', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-del-req-visa-<?= $data_required->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($data_required->ds160) { ?>
                                                    <a href="<?= base_url($data_required->ds160) ?>" class="lightbox btn btn-warning btn-xs btn-view-req-ds160" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->ds160) ?>" download="<?= get_full_name($data_required) ?>_DS160 Confirmation Page" class="btn btn-info btn-xs btn-download-req-ds160" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary upload-button <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-xs btn-ds160-<?= $data_required->id ?>" data-file-value="upload_require_doc_ds160_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="ds160" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_ds160_<?= $data_required->id ?> hide">
                                                <?php if($data_required->ds160) { ?>
                                                    <a href="javascript:;" onclick="del_data_required(this, <?= $data_required->id ?>, 'ds160', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-del-req-ds160-<?= $data_required->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($data_required->ds2019) { ?>
                                                    <a href="<?= base_url($data_required->ds2019) ?>" class="lightbox btn btn-warning btn-xs btn-view-req-ds2019" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->ds2019) ?>" download="<?= get_full_name($data_required) ?>_Signed DS2019" class="btn btn-info btn-xs btn-download-req-ds2019" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary upload-button <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-xs btn-ds2019-<?= $data_required->id ?>" data-file-value="upload_require_doc_ds2019_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="ds2019" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_ds2019_<?= $data_required->id ?> hide">
                                                <?php if($data_required->ds2019) { ?>
                                                    <a href="javascript:;" onclick="del_data_required(this, <?= $data_required->id ?>, 'ds2019', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-del-req-ds2019-<?= $data_required->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($data_required->passport) { ?>
                                                    <a href="<?= base_url($data_required->passport) ?>" class="lightbox btn btn-warning btn-xs btn-view-req-passport" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->passport) ?>" download="<?= get_full_name($data_required) ?>_Passport" class="btn btn-info btn-xs btn-download-req-passport" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary upload-button <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-xs btn-passport-<?= $data_required->id ?>" data-file-value="upload_require_doc_passport_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="passport" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_passport_<?= $data_required->id ?> hide">
                                                <?php if($data_required->passport) { ?>
                                                    <a href="javascript:;" onclick="del_data_required(this, <?= $data_required->id ?>, 'passport', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-del-req-passport-<?= $data_required->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($data_required->photo) { ?>
                                                    <a href="<?= base_url($data_required->photo) ?>" class="lightbox btn btn-warning btn-xs btn-xs btn-view-req-photo" style="color:#fff">View</a>
                                                    <a href="<?= base_url($data_required->photo) ?>" download="<?= get_full_name($data_required) ?>_Photo 5x5" class="btn btn-info btn-xs btn-download-req-photo" style="color:#fff">Download</a>
                                                <?php } ?>
                                                <a href="javascript:;" class="btn btn-primary upload-button <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-xs btn-photo-<?= $data_required->id ?>" data-file-value="upload_require_doc_photo_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                <input type="file" data-table_save="save_required_document" data-doc="photo" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_required->id ?>" class="upload_require_doc_photo_<?= $data_required->id ?> hide">
                                                <?php if($data_required->photo) { ?>
                                                    <a href="javascript:;" onclick="del_data_required(this, <?= $data_required->id ?>, 'photo', 'delete_required_document', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs <?= ($complete && !$is_admin && !$data_required->grantee_edit) ? 'hide' : '' ?> hide-complete btn-del-req-photo-<?= $data_required->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                <?php } ?>
                                            </td>
                                            <?php if($is_admin) { ?>
                                            <td>
                                                <?php 
                                                    $url_download = $is_admin ? base_url('admin/departure/download_merge/' . $data_required->id . '/' . ($key)) : base_url('grantee/submission/download_merge/' . $data_required->id . '/' . ($key)) ;
                                                ?>
                                                <a href="<?= $url_download ?>" class="btn btn-primary btn-download-merge btn-xs" style="color:#fff;">Download</a>
                                            </td>
                                            <td>
                                                <div class="TriSea-technologies-Switch" style="margin-left:35px;">
                                                    <input onchange="grantee_edit_required(this, 'visa_required_document')" data-id="<?= $data_required->id ?>" name="grantee_edit" id="grantee_edit_required_<?= $data_required->id ?>" type="checkbox" <?= $data_required->grantee_edit  ? 'checked' : '' ?>/>
                                                    <label for="grantee_edit_required_<?= $data_required->id ?>" class="label-primary"></label>
                                                </div>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php //foreach($data_required_doc as $key => $data_required){ ?>
                                    <!-- <div class="required-item">
                                        <a href="javascript:;" onclick="del_item(this, 'required-item', <?= $data_required->id ?>)" class="mt-5 btn btn-danger" style="float:right;color:#fff"><i class="fa fa-trash fa-fw"></i></a>
                                        <table class="table table-striped table-responsive table-required my-3">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Given Name/First Name</th>
                                                    <th>Surename/Last Name</th>
                                                    <th>Document Name</th>
                                                    <th>File</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Visa Application</td>
                                                    <td>
                                                        <?php if($data_required->visa) { ?>
                                                            <a href="<?= base_url($data_required->visa) ?>" class="lightbox" style="color:#337ab7"><?= file_name($data_required->visa) ?></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" class="btn mr-2 btn-primary upload-button btn-xs btn-visa-<?= $data_required->id ?>" data-file-value="upload_require_doc_visa_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                        <input type="file" data-doc="visa" data-id="<?= $data_required->id ?>" class="upload_require_doc_visa_<?= $data_required->id ?> hide">
                                                        <?php if($data_required->visa) { ?>
                                                            <a href="javascript:;" onclick="del_data_required(this, <?= $data_required->id ?>, 'visa')" class="btn btn-danger btn-xs btn-del-req-visa" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">DS160 Confirmation Page</td>
                                                    <td>
                                                        <?php if($data_required->ds160) { ?>
                                                            <a href="<?= base_url($data_required->ds160) ?>" class="lightbox" style="color:#337ab7"><?= file_name($data_required->ds160) ?></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="30%">
                                                        <a href="javascript:;" class="btn mr-2 btn-primary upload-button btn-xs btn-ds160-<?= $data_required->id ?>" data-file-value="upload_require_doc_ds160_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                        <input type="file" data-doc="ds160" data-id="<?= $data_required->id ?>" class="upload_require_doc_ds160_<?= $data_required->id ?> hide">
                                                        <?php if($data_required->ds160) { ?>
                                                            <a href="javascript:;" onclick="del_data_required(this, <?= $data_required->id ?>, 'ds160')" class="btn btn-danger btn-xs btn-del-req-ds160" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">Passport</td>
                                                    <td>
                                                        <?php if($data_required->passport) { ?>
                                                            <a href="<?= base_url($data_required->passport) ?>" class="lightbox" style="color:#337ab7"><?= file_name($data_required->passport) ?></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="30%">
                                                        <a href="javascript:;" class="btn mr-2 btn-primary upload-button btn-xs btn-passport-<?= $data_required->id ?>" data-file-value="upload_require_doc_passport_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                        <input type="file" data-doc="passport" data-id="<?= $data_required->id ?>" class="upload_require_doc_passport_<?= $data_required->id ?> hide">
                                                        <?php if($data_required->passport) { ?>
                                                            <a href="javascript:;" onclick="del_data_required(this, <?= $data_required->id ?>, 'passport')" class="btn btn-danger btn-xs btn-del-req-passport" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">Photo 5x5</td>
                                                    <td>
                                                        <?php if($data_required->photo) { ?>
                                                            <a href="<?= base_url($data_required->photo) ?>" class="lightbox" style="color:#337ab7"><?= file_name($data_required->photo) ?></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="30%">
                                                        <a href="javascript:;" class="btn mr-2 btn-primary upload-button btn-xs btn-photo-<?= $data_required->id ?>" data-file-value="upload_require_doc_photo_<?= $data_required->id ?>" style="color:#fff;">Upload</a>
                                                        <input type="file" data-doc="photo" data-id="<?= $data_required->id ?>" class="upload_require_doc_photo_<?= $data_required->id ?> hide">
                                                        <?php if($data_required->photo) { ?>
                                                            <a href="javascript:;" onclick="del_data_required(this, <?= $data_required->id ?>, 'photo')" class="btn btn-danger btn-xs btn-del-req-photo" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> -->
                                <?php //} ?>
                                <!-- end other required doc  -->
                            <!-- </div> -->

                            <!-- <a class="btn btn-primary my-2" style="color:#fff" data-toggle="modal" data-target="#form_require_doc">Add New</a> -->
                            <!-- <table class="table table-striped table-responsive table-appointment my-3">
                                <thead>
                                    <th>Passport</th>
                                    <th>Photo 5x5</th>
                                    <th>Upload Date</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="list_required_doc">
                                    <?php foreach($data_required_doc as $key => $row_req) { 
                                        $filenamePassport = explode('/', $row_req->passport);
                                        $filenamePhoto = explode('/', $row_req->photo);
                                        
                                    ?>
                                        <tr>
                                            <td><a href="<?= base_url($row_req->passport) ?>" class="lightbox" style="color:#337ab7"><?= end($filenamePassport) ?></a></td>
                                            <td><a href="<?= base_url($row_req->photo) ?>" class="lightbox" style="color:#337ab7"><?= end($filenamePhoto) ?></a></td>
                                            <td><?= date('d-M-Y H:i:s', strtotime($row_req->created_date)) ?></td>
                                            <td>
                                            <a href="javascript:;" onclick="del_data_required_doc(this, <?= $row_req->id ?>)" class="btn btn-danger btn-xs" style="color:#fff">
                                                <i class="fa fa-trash fa-fw text-white"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table> -->
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </div>
    <?php } ?>
    <?php if($has_permission || !$is_admin) { ?>
    <div class="panel panel-default">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionInterview" href="#collapseTwoInterview" aria-expanded="false" aria-controls="collapseTwoInterview" onclick="return set_session('interview_apointment')">
            <div class="panel-heading-visa text-left" role="tab" id="submission_result">
                <h4 class="panel-title">
                    Visa Interview Appointment Confirmation
                </h4>
            </div>
        </a>
        <div id="collapseTwoInterview" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-body">
            <div class="col-lg-12">
                <?php 
                $required_fields = [
                    'date',
                    'location',
                    'invitation_letter',
                    // 'departure_date',
                    // 'returning_date',
                    // 'departure_city',
                    // 'arrival_city',
                ];
                // if($visa_interview->show_transportation == 'Reimbursement'){
                //     $required_fields[] = 'eticket';
                // }
                // if($grantee_grant->show_digital_grant_packet) {
                //     $required_fields[] = 'digital_grant_packet';
                // }

                $visa_interview_appointment_status = evaluate_transportation($visa_interview, $is_admin, $required_fields, null, 'enable_visa_interview_appointment');



                $required_fields_accomodation = [
                    'checkin_date',
                    'checkout_date',
                ];
                // if($visa_interview->show_accomodation == 'Reimbursement'){
                //     $required_fields_accomodation[] = 'voucher_hotel';
                // }
                $visa_interview_appointment_accomodation_status = evaluate_transportation($visa_interview, $is_admin, $required_fields_accomodation, 'show_accomodation', 'enable_visa_interview_appointment');
                if($is_admin) { 
                ?>
                <div class="row my-5">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Visa Interview Appointment Confirmation</span>
                            <input onclick="enable_toogle(this)" data-id="<?= $grantee_grant->id ?>" id="enable_visa_interview_appointment" name="enable_visa_interview_appointment" type="checkbox" <?= $visa_interview->enable_visa_interview_appointment  ? 'checked' : '' ?>/>
                            <label for="enable_visa_interview_appointment" class="label-primary"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="form-group">
                    <a href="<?= base_url($grantee_grant->visa_interview_procedure) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->visa_interview_procedure ? '' : 'hide' ?>" style="color:#fff">
                        <i class="fa fa-download fa-fw text-white"></i> Download Visa Interview Procedure
                    </a>

                    <p>Pay attention to the following information before attending your visa interview:</p>
                    <ul>
                        <li><b>Official Visa Interview Invitation</b></li>
                        <div class="panel-body mt-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input 
                                        id="date" 
                                        type="text" 
                                        class="form-control datepicker" 
                                        readonly 
                                        style="background-color:<?= $visa_interview_appointment_status['style_transportation'] ?>"
                                        <?= $this->session->userdata('role') == 'travel-booking-assistant' ? 'disabled' : '' ?> 
                                        <?= $visa_interview_appointment_status['disable_transportation'] ?>
                                        placeholder="Visa Interview Date" 
                                        name="date" 
                                        value="<?= $visa_interview  ? ($visa_interview->date != '' ? date('d M Y', strtotime($visa_interview->date)) : '') : '' ?>">
                                        <?php if(($this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                            <?php if($visa_interview_appointment_status['show_transportation']){ ?>
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            <?php } ?>
                                        <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Time</label>
                                    <input 
                                        <?= $this->session->userdata('role') == 'travel-booking-assistant' ? 'disabled' : '' ?> 
                                        <?= $visa_interview_appointment_status['disable_transportation'] ?>
                                        type="text" 
                                        id="time" 
                                        class="form-control input_time" 
                                        name="time" 
                                        value="<?= $visa_interview  ? ($visa_interview->date != '' ? (date('H:i', strtotime($visa_interview->date)) == '00:00' ? '' : date('h:i A', strtotime($visa_interview->date)) ) : '') : '' ?>" 
                                        placeholder="Time">
                                        <?php if(($this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                            <?php if($visa_interview_appointment_status['show_transportation']){ ?>
                                                <a href="javascript:;" onclick="emptyValueTime(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            <?php } ?>
                                        <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Location</label>
                                    <!-- <input type="text" class="form-control" <?= !$is_admin ? 'readonly' : '' ?> name="location" id="location" value="<?= $visa_interview->location ?>"> -->
                                    <select class="form-control" id="location" name="location" style="width:100%" <?= $this->session->userdata('role') == 'travel-booking-assistant' ? 'disabled' : '' ?> <?= $visa_interview_appointment_status['disable_transportation'] ?>>
                                        <option value="">-- Select --</option>
                                        <option <?= $visa_interview->location == 'Jakarta' ? 'selected' : '' ?> value="Jakarta">Jakarta</option>
                                        <option <?= $visa_interview->location == 'Surabaya' ? 'selected' : '' ?> value="Surabaya">Surabaya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Appointment Confirmation Letter</label>
                                    <?php if(($this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                        <?php if($visa_interview_appointment_status['show_transportation']){ ?>
                                            <input id="invitation_letter" type="file" class="form-control" name="invitation_letter">
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($grantee_grant && $visa_interview->invitation_letter != '') { ?>
                                        <br>
                                        <div style="margin-bottom:10px; position:relative; width:100px;" id="file_invitation_letter">
                                            <a href="<?=base_url() ?><?=$visa_interview->invitation_letter ?>" class="lightbox" aria-haspopup="dialog">
                                                <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->invitation_letter); ?>" src="<?php echo get_preview($visa_interview->invitation_letter); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                            </a>
                                            <a href="<?=base_url() ?><?=$visa_interview->invitation_letter ?>" id="button_download_img_photo" download="<?= get_full_name($grantee_grant) ?>_Appointment Confirmation Letter" title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->invitation_letter) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                            <?php if($is_admin) { ?>
                                                <?php if($visa_interview_appointment_status['show_transportation']){ ?>
                                                    <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                        <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'invitation_letter', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                    </a>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if($grantee_grant->show_digital_grant_packet) { ?>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?php if($is_admin || (!$is_admin && $visa_interview->digital_grant_packet != '')) { ?>
                                    <label>Digital Grant Package</label>
                                    <?php } ?>
                                    <?php if($is_admin) { ?>
                                    <input id="digital_grant_packet" type="file" class="form-control" name="digital_grant_packet">
                                    <?php } ?>
                                    <?php if ($grantee_grant && $visa_interview->digital_grant_packet != '') { ?>
                                        <br>
                                        <div style="margin-bottom:10px; position:relative; width:100px;" id="file_digital_grant_packet">
                                            <a href="<?=base_url() ?><?=$visa_interview->digital_grant_packet ?>" class="lightbox" aria-haspopup="dialog">
                                                <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->digital_grant_packet); ?>" src="<?php echo get_preview($visa_interview->digital_grant_packet); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                            </a>
                                            <a href="<?=base_url() ?><?=$visa_interview->digital_grant_packet ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->digital_grant_packet) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                            <?php if($is_admin) { ?>
                                            <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'digital_grant_packet', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                            </a>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </ul>
                    <div class="panel-body" style="margin-left:30px;">
                        <p><b>IMPORTANT</b>: Please print the first two pages of the attached Digital Package, which contain your Fulbright selection letters, and bring them with you as supporting documents for your visa interview and when departing to the U.S.</p>
                    </div>
                    <?php if($visa_interview_appointment_status['show_transportation'] && !$is_admin){ ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="pull-right">
                                <button type="button" name="btn" value="save_visa_interview_appointment" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_visa_interview_appointment')" class="btn btn-success">Save</button>
                            </div>
                        </div>

                    </div>
                    <?php } ?>


                    <?php //$this->load->view('admin/partials/transport_visa_interview'); ?>
                </div>
            </div>
        </div>
        </div>
    </div>
    <?php } ?>

    <?php $this->load->view('admin/partials/departure_package'); ?>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="pull-right">
            <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                <button type="button" name="btn" value="save_visa_interview" onclick="return showSwal('confirm_submit', 'Are you sure you want to save and send email?', false, false, false, '#form', 'save_visa_interview_transportation')" class="btn btn-primary">Send Visa Transportation</button>
                <button type="button" name="btn" value="save_visa_interview" onclick="return showSwal('confirm_submit', 'Are you sure you want to save and send email?', false, false, false, '#form', 'save_visa_interview_accommodation')" class="btn btn-primary">Send Visa Accommodation</button>
            <?php } ?>
            <?php if($is_admin) { ?>
            <button type="button" name="btn" value="save_visa_interview" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_visa_interview')" class="btn btn-success">Save</button>
            <?php } ?>
        </div>
    </div>
</div>