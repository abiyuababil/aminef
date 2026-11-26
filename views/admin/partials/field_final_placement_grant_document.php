<style>
    .panel-default .panel-heading-placement{
        background-color: rgb(236 240 244);
        color: #000;
        /* border-radius: 8px;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important; */
        padding: 20px;
    }
    .span-note:hover {
        background-color: #df7401;
        cursor: pointer;
    }
</style>
<div class="col-lg-12">
    <div class="panel-group" id="accordion_grant" role="tablist" aria-multiselectable="true">
        <?php if($grantee_grant->academic_program_visibility) { ?>
        <?php if($is_admin || $toa_placement_file || $collage_placement->field_of_study_input != '' || $final_placement->specialization != '') { ?>
        <div class="panel panel-default">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_grant" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <div class="panel-heading panel-heading-placement text-left" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <?= $grantee_grant->academic_program == '' ? 'Academic Program' : $grantee_grant->academic_program ?>
                    </h4>
                </div>
            </a>
            <div id="collapseThree" class="panel-collapse collapse <?= $this->session->userdata('last_list_placement') == 'grant_doc' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <?php 
                    $disabled = '';
                    if(!$is_admin){
                        if(empty($toa_placement_file)){
                            $disabled = 'disabled';
                        } else if($collage_placement->grantee_update) {
                            $disabled = 'disabled';
                        }
                    }
                    ?>
                <div class="panel-body" style="margin-top:10px">  
                    <div class="col-lg-12">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Complete the information from your Grant Document</p>
                    </div>
                    <?php if($is_admin) { ?>
                    <div class="col-lg-12 mb-5">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2">Enable <?= $grantee_grant->academic_program == '' ? 'Academic Program' : $grantee_grant->academic_program ?></span>
                            <input onchange="change_grantee_update(this, <?= $collage_placement->id ?>)" id="grantee_update" name="grantee_update" type="checkbox" <?= !$collage_placement->grantee_update  ? 'checked' : '' ?>/>
                            <label for="grantee_update" class="label-primary"></label>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(!$grantee_grant->hide_fos_placement) { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Field of Study <?= !$is_admin ? '<span style="color:red"> *</span>' : '' ?></label>
                            <?php if($is_admin) { ?>
                                <?php if($grantee_grant->is_final_placement) { ?>
                                    <?php if($grantee_grant->field_of_study_input) { ?>
                                        <input type="text" class="form-control" name="field_of_study_input" value="<?= $collage_placement->field_of_study_input ?>">
                                    <?php } else { ?>
                                        <select id="field_of_study_plan" class="form-control select2" name="field_of_study_id" style="width:100%">
                                            <option value="">-- Select Field of Study --</option>
                                            <?php
                                            if ($field_of_study) {
                                                foreach ($field_of_study as $fos) {
                                                    $selected = '';
                                                    if ($collage_placement->field_of_study_id == $fos->id) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $fos->id ?>" <?php echo $selected ?>><?php echo $fos->name ?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php } ?>
                                <?php } else{ ?>
                                    <input type="text" class="form-control" name="field_of_study_input" value="<?= $collage_placement->field_of_study_input ?>">
                                <?php } ?>
                            <?php } else { ?>
                                <?php if($grantee_grant->is_final_placement) { ?>
                                    <?php if($grantee_grant->field_of_study_input) { ?>
                                        <input type="text" <?= $disabled ? 'disabled' : '' ?> class="form-control" form="form_placement" name="field_of_study_input" value="<?= $collage_placement->field_of_study_input ?>" required>
                                    <?php } else { ?>
                                        <select class="form-control select2" name="field_of_study_id" style="width:100%" form="form_placement" <?= $disabled ? 'disabled' : '' ?>>
                                            <option value="">-- Select Field of Study --</option>
                                            <?php
                                            if ($field_of_study) {
                                                foreach ($field_of_study as $fos) {
                                                    $selected = '';
                                                    if ($collage_placement->field_of_study_id == $fos->id) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $fos->id ?>" <?php echo $selected ?>><?php echo $fos->name ?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php } ?>
                                    <!-- <input type="text" class="form-control" value="<?= $collage_placement->field_of_study_id ? get_field_of_study_by_id($collage_placement->field_of_study_id)->name : '' ?>"> -->
                                <?php }else { ?>
                                    <input type="text" <?= $disabled ? 'disabled' : '' ?> class="form-control" form="form_placement" name="field_of_study_input" value="<?= $collage_placement->field_of_study_input ?>" required>
                                <?php } ?>
                            <?php } ?>
                        </div>  
                    </div>
                    <?php } ?>
                    <?php //if($is_admin) { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Start Date <?= (!$is_admin && $grantee_grant->required_date_grant_doc_placement) ? '<span style="color:red"> *</span>' : '' ?></label>
                            <input <?= (!$is_admin && $grantee_grant->required_date_grant_doc_placement) ? 'form="form_placement"' : '' ?> <?= $disabled ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= $disabled ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="Start Date" name="start_date" value="<?= $collage_placement->start_date ? date('d M Y', strtotime($collage_placement->start_date)) : '' ?>" <?= (!$is_admin && $grantee_grant->required_date_grant_doc_placement) ? 'required' : '' ?>>
                            <?php if($is_admin){ ?>
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            <?php } ?>
                        </div>  
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>End Date <?= (!$is_admin && $grantee_grant->required_date_grant_doc_placement) ? '<span style="color:red"> *</span>' : '' ?></label>
                            <input <?= (!$is_admin && $grantee_grant->required_date_grant_doc_placement) ? 'form="form_placement"' : '' ?> <?= $disabled ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= $disabled ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="End Date" name="end_date" value="<?= $collage_placement->end_date ? date('d M Y', strtotime($collage_placement->end_date)) : '' ?>" <?= (!$is_admin && $grantee_grant->required_date_grant_doc_placement) ? 'required' : '' ?>>
                            <?php if($is_admin){ ?>
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            <?php } ?>
                        </div>  
                    </div>
                    <?php //} else {?>
                    <!-- <div class="col-lg-4">
                        <div class="form-group">
                            <label>Start - End Date</label>
                            <input disabled type="text" class="form-control" placeholder="End Date" name="end_date" value="<?= $collage_placement->start_date ? date('d M Y', strtotime($collage_placement->start_date)) : '' ?> - <?= $collage_placement->end_date ? date('d M Y', strtotime($collage_placement->end_date)) : '' ?>">
                        </div>  
                    </div> -->
                    <?php //} ?>
                    <?php if($is_admin) { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Note</label>
                            <textarea <?= !$is_admin ? 'disabled' : '' ?> class="form-control" rows="2" name="note"><?= $collage_placement->note ?></textarea>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($grantee_grant->toa_visibility) { ?>
                    
                    <div class="col-lg-12">
                        <div class="alert alert-info" role="alert">
                            The <?= $grantee_grant->toa == '' ? 'Terms of Appointment' : $grantee_grant->toa ?> and Special Instructions document describes the benefits and conditions of your Fulbright grant.
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label><?= $grantee_grant->toa == '' ? 'ToA (Terms of Appointment)' : $grantee_grant->toa ?></label>
                            <br />
                            <?php if(!$is_alumni_page) { ?>
                            <?php if($is_admin) { ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#toa_placement_file">Add <?= $grantee_grant->toa == '' ? 'ToA (Terms of Appointment)' : $grantee_grant->toa ?></button>
                            <?php } ?>
                            <?php } ?>
                        




                            <!-- <?php if ($collage_placement->toa != '') { ?>
                                <div class="img-toa" style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?php echo base_url() ?><?php echo $collage_placement->toa ?>" class="lightbox"><img height="100" src="<?php echo get_preview($collage_placement->toa); ?>"></a>
                                    <?php if($is_admin) { ?>
                                    <a href="javascript:;" onclick="delete_file_placement(this, 'img-toa', <?= $collage_placement->id ?>, 'toa')" class="btn btn-danger btn-xs" style="position:absolute; top:25px;">
                                        <i class="fa fa-trash fa-fw text-white"></i>
                                    </a>
                                    <?php } ?>
                                    <a href="<?= base_url($collage_placement->toa) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                        <i class="fa fa-download fa-fw text-white"></i>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if($is_admin) { ?>
                            <input type="file" name="toa" id="toa">
                            <small class="file-for-testing">File Size Max 5MB</small>
                            <?php } ?> -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="wrap-toa_placement_file">
                            <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>Extension</th>
                                            <th>Deadline Date</th>
                                            <th>Status</th>
                                            <th>File Upload</th>
                                            <th>Upload Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_toa_placement">
                                        <?php foreach($toa_placement_file as $key => $fileCores) {
                                            $detail_file = explode('.', $fileCores->filename);
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url($fileCores->file) ?>" class="lightbox">
                                                    <?= $detail_file[0] ?>
                                                </a>
                                            </td>
                                            <td><?= end($detail_file) ?></td>
                                            <td><?= $fileCores->deadline_date != '' ? date('d-M-Y H:i', strtotime($fileCores->deadline_date)) : ''?></td>
                                            <td>
                                                <?= $fileCores->status ?>
                                                <?php //if($fileCores->status == 'Revise') { ?>
                                                    <!-- <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="<?= $fileCores->note ?>">i</span> -->
                                                <?php //} ?>
                                                <?php if($fileCores->status == 'Revise') { ?>
                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-placement="top" data-note="<?= $fileCores->note ?>" data-attach='<?= $fileCores->attachment_revise ?>'>i</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url($fileCores->file_grantee) ?>" class="lightbox"><?= $fileCores->filename_grantee ?></a>
                                                <?php if($is_admin) { ?>
                                                <a href="<?= base_url($fileCores->file_grantee) ?>" title="Click to download" download="<?= get_full_name($grantee_grant) ?>_<?= $grantee_grant->toa == '' ? 'ToA (Terms of Appointment)' : $grantee_grant->toa ?>" class="btn btn-primary btn-xs ml-2">
                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                </a>
                                                <?php } ?>
                                            </td>
                                            <td><?= $fileCores->created_date_grantee ?></td>
                                            <td>
                                                <a href="<?= base_url($fileCores->file) ?>" download title="Click to download" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                </a>
                                                <?php if(!$is_admin && $fileCores->status != 'Approve') { ?>
                                                <button type="button" class="btn btn-primary btn-xs upload_grantee_toa_placement_<?= $fileCores->id ?>" data-id="<?= $fileCores->id ?>" data-toggle="modal" data-target="#upload_grantee_toa_placement">Upload</button>
                                                <?php } ?>
                                                <?php if($is_admin) { ?>
                                                <a href="javascript:;" onclick="update_status_toa_placement_file(this, <?= $fileCores->id ?>, 'approve')" class="btn btn-success btn-xs">
                                                    Approve
                                                </a>
                                                <a href="javascript:;" onclick="update_status_toa_placement_file(this, <?= $fileCores->id ?>, 'revise')" class="btn btn-warning btn-xs">
                                                    Revise
                                                </a>
                                                <a href="javascript:;" onclick="del_toa_placement_file(this, 'img-col', <?= $fileCores->id ?>)" class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                </a>
                                                <input data-log="<?= $fileCores->id ?>" data-type="placement" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default modal-log-toa-placement" value="Open Log">
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a href="<?= base_url($grantee_grant->guideline_toa) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_toa ? '' : 'hide' ?>" style="color:#fff">
                            <i class="fa fa-download fa-fw text-white"></i> Download Guideline
                        </a>
                    </div>
                    <?php } ?>
                    <?php if(!$is_admin && !$disabled){ ?>
                    <div class="col-lg-12">
                        <form method="POST" enctype="multipart/form-data" id="form_placement">
                            <button type="button" class="btn btn-success pull-right" id="btn-placement">Save</button>
                            <input type="hidden" name="placement_id" value="<?= $collage_placement->id ?>">
                            <input type="hidden" name="update_placement" value="<?= $collage_placement->id ?>">
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>

        <?php if($grantee_grant->pre_academic_visibility) { ?>
        <?php if($is_admin || $collage_placement->test_type != '') { ?>
        <div class="panel panel-default">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_grant" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                <div class="panel-heading panel-heading-placement text-left" role="tab" id="headingThree">
                    <h4 class="panel-title">
                    <?= $grantee_grant->pre_academic == '' ? 'Pre-Academic Program/ Long-Term English/ Gateway Orientation' : $grantee_grant->pre_academic ?>
                    <div class="pull-right">
                        <?php if(!$is_admin && ($collage_placement->status_pre_academic == '')){ ?>
                            <?php if(!in_array($collage_placement->status_pre_academic, ['Approve', 'Rejected'])) { ?>
                                <button type="button" onclick="grantee_update_status_pre_academic(this, <?= $collage_placement->id ?>, 'Approve')" class="btn-noaction btn btn-success btn-xs">Approve</button>
                                <button type="button" onclick="grantee_update_status_pre_academic(this, <?= $collage_placement->id ?>, 'Reject')" class="btn-noaction btn btn-danger btn-xs">
                                    Reject
                                </button>
                            <?php } ?>
                        <?php } ?>
                        <?php if($collage_placement->status_pre_academic == 'Approve' && !$is_admin) { ?>
                            <span class="badge badge-success">Approved</span>
                        <?php } else if($collage_placement->status_pre_academic == 'Reject' && !$is_admin) { ?>
                            <span class="badge badge-danger">Rejected</span>
                        <?php } ?>
                    </div>
                    </h4>
                </div>
            </a>
            <div id="collapseFive" class="panel-collapse collapse <?= $this->session->userdata('last_list_placement') == 'pre-academic' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingThree">

            <?php if(!$is_admin){ ?>
            <form method="POST" enctype="multipart/form-data" id="form_placement_preac">
            <?php } ?>
            <div class="panel-body">
                <div class="panel-body" style="margin-top:10px">
                    <!-- <div class="col-lg-12 mb-4">
                        <b>Pre-Academic Program/ Long-Term English/ Gateway Orientation Assignment:</b>
                    </div> -->
                    <?php if($is_admin) { ?>
                    <div class="col-lg-12 mb-5">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2">Enable Pre-Academic Program/ Long-Term English/ Gateway Orientation Assignment</span>
                            <input onchange="change_update_preact(this, <?= $collage_placement->id ?>)" id="update_preact" name="update_preact" type="checkbox" <?= !$collage_placement->update_preact  ? 'checked' : '' ?>/>
                            <label for="update_preact" class="label-primary"></label>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="status_pre_academic">Status Pre-Academic Program/ Long-Term English/ Gateway Orientation Assignment</label>
                            <select name="status_pre_academic" id="status_pre_academic" class="form-control">
                                <option value="">-- Select Status --</option>
                                <option <?= $collage_placement->status_pre_academic == 'Approve' ? 'selected' : '' ?> value="Approve">Approve</option>
                                <option <?= $collage_placement->status_pre_academic == 'Reject' ? 'selected' : '' ?> value="Reject">Reject</option>
                            </select>
                            <?php if($collage_placement->status_pre_academic == 'Reject') { ?>
                                <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-placement="top" data-note="<?= $collage_placement->note_pre_academic ?>" data-attach="">Show Note</span>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Pre-Academic Program/ Long-Term English/ Gateway Orientation Assignment</label>
                            <?php if($is_admin) { ?>
                            <select name="test_type" id="test_type" class="form-control">
                                <option value="">-- Select --</option>
                                <option <?= $collage_placement->test_type == 'Long Term English' ? 'selected' : '' ?> value="Long Term English">Long Term English</option>
                                <option <?= $collage_placement->test_type == 'Pre-Academic Training' ? 'selected' : '' ?> value="Pre-Academic Training">Pre-Academic Training</option>
                                <option <?= $collage_placement->test_type == 'Gateway Orientation' ? 'selected' : '' ?> value="Gateway Orientation">Gateway Orientation</option>
                            </select>
                            <?php } else { ?>
                                <input type="text" disabled value="<?= $collage_placement->test_type ?>" class="form-control">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php //if($is_admin) { ?>
                            <label>University</label>
                            <select id="university_id_select_pre_academic" class="form-control select2" name="university_id_pre_academic" style="width:100%" <?= !$is_admin && ($collage_placement->update_preact || $disable_field_reject || $collage_placement->status_pre_academic !== 'Approve') ? 'disabled' : '' ?>>
                                <option value="">-- Select --</option>
                                <?php foreach ($universities as $university) : ?>
                                    <?php $selected = $collage_placement->university_id_pre_academic == $university->id ? 'selected' : ''; ?>
                                    <option value="<?= $university->id?>" <?= $selected ?>><?= $university->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php //} else { ?>
                                <!-- <label>University</label> -->
                                <!-- <input type="hidden" id="id_univ_grantee" value="<?= $collage_placement->university_id_pre_academic ?>">
                                <input type="text" class="form-control" value="<?= $collage_placement->university_id_pre_academic ? get_university_by_id($collage_placement->university_id_pre_academic)->name : '' ?>" readonly> -->
                            <?php //} ?>
                        </div>
                    </div>
                    <!-- <div class="col-lg-4">
                        <div class="form-group">
                            <label>Duration</label>
                            <div class="input-group" style="width: 100%;">
                            <div class="input-group-btn" style="width: 70%;">
                            <input type="text" class="form-control" name="duration_input" <?= $is_admin ? '' : 'readonly' ?> value="<?= $collage_placement->duration_input ?>">
                            </div>
                            <?php if($is_admin) { ?>
                            <select id="duration_select" class="form-control" name="duration_select" style="width:100%">
                                <option <?= $collage_placement->duration_select == 'Days' ? 'selected' : '' ?> value="Days">Days</option>
                                <option <?= $collage_placement->duration_select == 'Weeks' ? 'selected' : '' ?> value="Weeks">Weeks</option>
                                <option <?= $collage_placement->duration_select == 'Months' ? 'selected' : '' ?> value="Months">Months</option>
                            </select>
                            <?php } else { ?>
                                <input type="text" class="form-control" name="duration_input" readonly value="<?= $collage_placement->duration_select ?>">
                            <?php } ?>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="text" readonly style="background-color:<?= $is_admin ? '#fff' : ($collage_placement->update_preact || $disable_field_reject || $collage_placement->status_pre_academic !== 'Approve' ? '#eee' : '#fff') ?>" class="form-control datepicker" placeholder="Start Date" name="start_date_pre_academic" value="<?= $collage_placement->start_date_pre_academic ? date('d M Y', strtotime($collage_placement->start_date_pre_academic)) : '' ?>" <?= (!$is_admin && $collage_placement->update_preact) || $disable_field_reject || $collage_placement->status_pre_academic !== 'Approve' ? 'disabled' : '' ?>>
                            <?php if($is_admin || (!$is_admin && !$collage_placement->update_preact && $collage_placement->status_pre_academic == 'Approve')){ ?>
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            <?php } ?>
                        </div>  
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="text" readonly style="background-color:<?= $is_admin ? '#fff' : ($collage_placement->update_preact || $disable_field_reject || $collage_placement->status_pre_academic !== 'Approve' ? '#eee' : '#fff') ?>" class="form-control datepicker" placeholder="End Date" name="end_date_pre_academic" value="<?= $collage_placement->end_date_pre_academic ? date('d M Y', strtotime($collage_placement->end_date_pre_academic)) : '' ?>" <?= $collage_placement->update_preact ? 'readonly' : '' ?> <?= (!$is_admin && $collage_placement->update_preact) || $disable_field_reject || $collage_placement->status_pre_academic !== 'Approve' ? 'disabled' : '' ?>>
                            <?php if($is_admin || (!$is_admin && !$collage_placement->update_preact && $collage_placement->status_pre_academic == 'Approve')){ ?>
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            <?php } ?>
                        </div>  
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Term of Appointment</label>
                            <br />
                            <?php if(!$is_alumni_page) { ?>
                            <?php if($is_admin) { ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#toa_pre_academic_file">Add Term of Appointment</button>
                            <?php } ?>
                            <?php } ?>
                            <!-- <input type="file" name="university_cores[]" id="university_cores" multiple>
                            <small class="file-for-testing">File Size Max 5MB</small> -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="wrap-toa_pre_academic">
                            <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>Extension</th>
                                            <th>Deadline Date</th>
                                            <th>Status</th>
                                            <th>File Upload</th>
                                            <th>Upload Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_toa">
                                        <?php foreach($toa_pre_academic_file as $key => $fileCores) {
                                            $detail_file = explode('.', $fileCores->filename);
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url($fileCores->file) ?>" class="lightbox">
                                                    <?= $detail_file[0] ?>
                                                </a>
                                            </td>
                                            <td><?= end($detail_file) ?></td>
                                            <td><?= $fileCores->deadline_date != '' ? date('d-M-Y H:i', strtotime($fileCores->deadline_date)) : ''?></td>
                                            <td>
                                                <?= $fileCores->status ?>
                                                <?php //if($fileCores->status == 'Revise') { ?>
                                                    <!-- <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="<?= $fileCores->note ?>">i</span> -->
                                                <?php //} ?>
                                                <?php if($fileCores->status == 'Revise') { ?>
                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-placement="top" data-note="<?= $fileCores->note ?>" data-attach='<?= $fileCores->attachment_revise ?>'>i</span>
                                                <?php } ?>
                                                <?php if($fileCores->status == 'Rejected') { ?>
                                                    <span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="<?= $fileCores->note_reject ?>">i</span>
                                                <?php } ?>
                                            </td>
                                            <td><a href="<?= base_url($fileCores->file_grantee) ?>" class="lightbox"><?= $fileCores->filename_grantee ?></a></td>
                                            <td><?= $fileCores->created_date_grantee ?></td>
                                            <td>
                                                <a href="<?= base_url($fileCores->file) ?>" download title="Click to download" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                </a>
                                                <?php if(
                                                    (!$is_admin && $fileCores->status != 'Approve' && $collage_placement->status_pre_academic == 'Approve' && !$collage_placement->update_preact) ||
                                                    (!$is_admin && $fileCores->status == 'Revise' && $collage_placement->status_pre_academic == 'Approve')
                                                ) { ?>
                                                <button type="button" class="btn btn-primary btn-xs upload_grantee_toa_<?= $fileCores->id ?>" data-id="<?= $fileCores->id ?>" data-toggle="modal" data-target="#upload_grantee_toa">Upload</button>
                                                <?php } ?>
                                                <?php if($is_admin) { ?>
                                                <a href="javascript:;" onclick="update_status_toa_pre_file(this, <?= $fileCores->id ?>, 'approve')" class="btn btn-success btn-xs">
                                                    Approve
                                                </a>
                                                <a href="javascript:;" onclick="update_status_toa_pre_file(this, <?= $fileCores->id ?>, 'revise')" class="btn btn-warning btn-xs">
                                                    Revise
                                                </a>
                                                <a href="javascript:;" onclick="del_toa_pre_file(this, 'img-col', <?= $fileCores->id ?>)" class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                </a>
                                                <input data-log="<?= $fileCores->id ?>" data-type="pre-academic" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default modal-log-toa-placement" value="Open Log">
                                                <?php } ?>
                                                <?php if(!$is_admin && ($fileCores->status == '' || $fileCores->status == 'Admin Uploaded')){ ?>
                                                    <?php if(!in_array($fileCores->status, ['Approve', 'Rejected'])) { ?>
                                                        <!-- <button type="button" class="btn btn-success btn-xs upload_grantee_toa_<?= $fileCores->id ?>" data-id="<?= $fileCores->id ?>" data-toggle="modal" data-target="#upload_grantee_toa">Approve</button>
                                                        <a href="javascript:;" onclick="grantee_update_status_toa_pre_file(this, <?= $fileCores->id ?>, 'reject')" class="btn btn-danger btn-xs btn-reject-toa-preact-<?= $fileCores->id ?>">
                                                            Reject
                                                        </a> -->
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                            </table>
                            <!-- <div class="col-lg-3 img-col" style="height: 150px;">
                                <a href="<?= base_url($fileCores->file) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($fileCores->file); ?>"></a>
                                <?php if($is_admin) { ?>
                                <a href="javascript:;" onclick="del_toa_pre_file(this, 'img-col', <?= $fileCores->id ?>)" class="btn btn-danger btn-xs" style="position:absolute; top:25px;">
                                    <i class="fa fa-trash fa-fw text-white"></i>
                                </a>
                                <?php } ?>
                                <a href="<?= base_url($fileCores->file) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                    <i class="fa fa-download fa-fw text-white"></i>
                                </a>
                                <p class="mt-4">Status : <b><span class="badge bg-secondary"><?= $fileCores->status ?></span></b></p>
                                <?php if($is_admin) { ?>
                                <a href="javascript:;" onclick="update_status_toa_pre_file(this, <?= $fileCores->id ?>, 'approve')" class="btn btn-success btn-xs">
                                    Approve
                                </a>
                                <a href="javascript:;" onclick="update_status_toa_pre_file(this, <?= $fileCores->id ?>, 'revise')" class="btn btn-warning btn-xs">
                                    Revise
                                </a>
                                <?php } ?>
                            </div> -->
                        </div>
                    </div>
                </div>
                <?php if(!$is_admin){ ?>
                <div class="col-lg-12">
                <?php if($collage_placement->status_pre_academic == 'Approve' && !$collage_placement->update_preact) { ?>
                <button type="button" class="btn btn-success pull-right" id="btn-placement-preac">Save</button>
                <?php } ?>
                <input type="hidden" name="submit_preac" value="1">
                <input type="hidden" name="placement_id" value="<?= $collage_placement->id ?>">
                <input type="hidden" name="update_preact" value="<?= $collage_placement->id ?>">
                </div>
                <?php } ?>
            </div>
            <?php if(!$is_admin){ ?>
            </form>
            <?php } ?>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="upload_grantee_toa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Upload Term of Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label>Term of Appointment</label>
                <input type="file" id="upload_to_grantee_file" name="toa_pre_academic_file">
                <!-- <small class="file-for-testing">File Size Max 5MB</small> -->
                <input type="hidden" name="toa_id" id="toa_id" value="">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-upload_toa_grantee">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="upload_grantee_toa_placement" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Upload <?= $grantee_grant->toa == '' ? 'ToA (Terms of Appointment)' : $grantee_grant->toa ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label><?= $grantee_grant->toa == '' ? 'ToA (Terms of Appointment)' : $grantee_grant->toa ?></label>
                <input type="file" id="upload_to_grantee_file_placement" name="toa_placement_file">
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="toa_placement_id" id="toa_placement_id" value="">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-upload_toa_grantee_placement">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mdl_note_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
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
                    <div class="col-lg-12">
                        <div class="form-group">
				                    <label>Note</label>
                            <textarea class="form-control" name="note_reject_toa_pre" id="note_reject_toa_pre" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-save-note-reject" name="btn-submit" value="decline" class="btn btn-primary success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
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
                <a target="_blank" class="btn btn-primary" id="attach_revise">Attach</a>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>