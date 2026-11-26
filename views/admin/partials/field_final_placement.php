<style>
    .panel-default .panel-heading-placement{
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
</style>
<div class="col-lg-12">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php if($is_admin || $collage_placement->university_id) { ?>
        <div class="panel panel-default">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <div class="panel-heading panel-heading-placement  text-left" role="tab" id="submission_plan">
                    <h4 class="panel-title">
                        <?php 
                            $label_select = $grantee_grant->submission_result_flag == 'submission_plan' ? 'Submission Plan' : 'Direct Application';
                            if($grantee_grant->is_final_placement || !$check_menu_nominee){
                                $label_select = 'Final Placement';

                            }
                        ?>
                        Selected <?= $label_select ?>
                    </h4>
                </div>
            </a>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="submission_plan">
            <div class="panel-body">
                <div class="panel-body" style="margin-top:10px;">  
                    <div class="<?= $grantee_grant->is_final_placement || !$check_menu_nominee ? 'col-lg-12' : 'col-lg-6' ?>">
                        <?php if($grantee_grant->is_final_placement || !$check_menu_nominee) { ?>
                            <div class="form-group">
                                <?php if($is_admin) { ?>
                                <label>University <span class="text-danger">*</span></label>
                                <select id="university_id_select" class="form-control select2" name="university_id" style="width:100%">
                                    <option value="">-- Select University --</option>
                                    <?php foreach ($universities as $university) : ?>
                                        <?php $selected = $collage_placement->university_id == $university->id ? 'selected' : ''; ?>
                                        <option value="<?= $university->id?>" <?= $selected ?>><?= $university->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php } else { ?>
                                    <label>University</label>
                                    <input type="hidden" id="id_univ_grantee" value="<?= $collage_placement->university_id ?>">
                                    <input type="text" class="form-control" value="<?= $collage_placement->university_id ? get_university_by_id($collage_placement->university_id)->name : '' ?>" readonly>
                                <?php } ?>
                            </div>
                        <?php }else { ?>
                            <div class="form-group">
                                <label>University</label>
                                <input type="hidden" name="university_id" value="<?= $final_placement->university_id ?>">
                                <input type="text" class="form-control" value="<?= $final_placement->university_id ? $final_placement->university_name : '' ?>" readonly>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" id="country" class="form-control" value="<?= $final_placement->country ? get_country_by_id((int) $final_placement->country)->name : '' ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" id="state" class="form-control" value="<?= $final_placement->state ? get_state_by_id((int) $final_placement->state)->name : '' ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" id="city" class="form-control" value="<?= $final_placement->city ? get_city_by_id((int) $final_placement->city)->name : '' ?>" readonly>
                        </div>

                        <?php if(!$grantee_grant->is_final_placement || ($check_menu_nominee && !$is_grantee_non_degree_result) ) { ?>
                        <div class="form-group">
                            <label>Degree Level</label>
                            <input class="form-control" readonly name="degree_level" value="<?= $final_placement->degree_level ? $final_placement->degree_level : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Major</label>
                            <input class="form-control" readonly name="major" value="<?= $final_placement->major ? $final_placement->major : '' ?>">
                        </div>
                        <?php } ?>
                    </div>
                    <?php if(!$grantee_grant->is_final_placement || ($check_menu_nominee && !$is_grantee_non_degree_result) ) { ?>
                    <div class="col-lg-6">
                        <div class="form-group"> 
                            <label>Department</label>
                            <input class="form-control" readonly name="department" value="<?= $final_placement->department ? $final_placement->department : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Specialization</label>
                            <input class="form-control" readonly name="specialization" value="<?= $final_placement->specialization ? $final_placement->specialization : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Credits</label>
                            <input class="form-control" readonly name="credits" value="<?= $final_placement->credits ? $final_placement->credits : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Program Duration</label>
                            <input class="form-control" readonly name="program_duration" value="<?= $final_placement->program_duration ? $final_placement->program_duration : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>University Website</label>
                            <input class="form-control" readonly name="link" value="<?= $final_placement->link ? $final_placement->link : '' ?>">
                        </div>
                        <div class="form-group">
                            <label><?= $final_placement->type == 'submission_plan' ? 'Submission Plan' : 'Support Letter' ?></label>
                            <?php $tagFile = $final_placement->type == 'submission_plan' ? $final_placement->submission_plan : $final_placement->support_letter ?>
                            <?php if ($tagFile != '') { ?>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?php echo base_url() ?><?php echo $tagFile ?>" class="lightbox"><img height="100" src="<?php echo get_preview($tagFile); ?>"></a>
                                    <a href="<?= base_url($tagFile) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0;">
                                        <i class="fa fa-download fa-fw text-white"></i>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            </div>
        </div>
        <?php } ?>

        <?php if($is_admin || !$grantee_grant->is_final_placement || $check_menu_nominee ) { ?>
        <div class="panel panel-default">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <div class="panel-heading panel-heading-placement text-left" role="tab" id="submission_result">
                    <h4 class="panel-title">
                        Selected Submission Result
                    </h4>
                </div>
            </a>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="submission_result">
            <div class="panel-body">
                <div class="panel-body" style="margin-top:10px">  
                    <div class="col-lg-12">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>University</th>
                                <!-- <th>Program Duration</th> -->
                                <th>Status</th>
                                <th>Total Cost $ (This Year)</th>
                                <th>Cost-sharing Status</th>
                                <!-- <th>Saving $ (Per Year)</th> -->
                                <th>Shortfall $ (Per Year)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($choosed_data) { ?>
                            <tr>
                                <td><?php echo $final_placement->university_name ?></td>
                                <!-- <td><?php echo $final_placement->program_duration ?></td> -->
                                <td>
                                    <?php 
                                        if($choosed_data->status == 'Rejected'){
                                            $span = 'text-danger';
                                        }else if($choosed_data->status == 'Pending Decision' || $choosed_data->status == ''){
                                            $span = '';
                                        }else{
                                            $span = 'text-primary';
                                        }
                                    ?>
                                    <span class="<?= $span ?>">
                                        <?= $choosed_data->status ?? 'Pending Decision'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-primary">
                                        <?= $choosed_data->final_cost_university ? 
                                        (($grantee_grant->grant_award > $choosed_data->final_cost_university) || $choosed_data->sortfall_covered  ? 
                                            'Within the Grant' : number_format($choosed_data->final_cost_university)) : '' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-primary">
                                        <?= $choosed_data->cost_sharing; ?>
                                    </span>
                                </td>
                                <!-- <td>
                                    <?= $choosed_data->final_cost_university ? ($grantee_grant->grant_award > $choosed_data->final_cost_university  ? 
                                    '<span class="text-primary">'.number_format($grantee_grant->grant_award - $choosed_data->final_cost_university).'</span>' : '')
                                    : '' 
                                    ?>
                                </td> -->
                                <td>
                                    <?= $choosed_data->final_cost_university ? (($grantee_grant->grant_award > $choosed_data->final_cost_university) || $choosed_data->sortfall_covered ? '' :
                                    '<span class="text-danger">'.number_format($choosed_data->final_cost_university - $grantee_grant->grant_award).'</span>')
                                    : '' 
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <?php } ?>
        <?php if($is_admin || $loa_files || $corespondance_file || $collage_placement->final_placement_detail != '' || $final_placement_detail_file || $is_grantee_non_degree_result) { ?>
        <div class="panel panel-default">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <div class="panel-heading panel-heading-placement text-left" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        Supporting Documents
                    </h4>
                </div>
            </a>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <div class="panel-body" style="margin-top:10px">
                    <?php if(!$grantee_grant->is_final_placement || ($check_menu_nominee && !$is_grantee_non_degree_result) ){ ?>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Letter of Admission</label>
                            <?php //if ($final_placement->loa_result != '') { ?>
                                <table class="table table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>Extension</th>
                                                <th>Upload Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($loa_files as $key => $fileCores) {
                                                $detail_file = explode('.', $fileCores->filename);
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="<?= base_url($fileCores->file) ?>" class="lightbox" style="cursor: pointer;">
                                                        <?= $detail_file[0] ?>
                                                    </a>
                                                </td>
                                                <td><?= end($detail_file) ?></td>
                                                <td><?= $fileCores->created_date ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                </table>

                                <!-- <div class="img-final_placement_detail" style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?php echo base_url() ?><?php echo $final_placement->loa_result ?>" class="lightbox"><img height="100" src="<?php echo get_preview($final_placement->loa_result); ?>"></a>
                                    <a href="<?= base_url($final_placement->loa_result) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                        <i class="fa fa-download fa-fw text-white"></i>
                                    </a>
                                </div> -->
                            <?php //} ?>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if($grantee_grant->final_placement_detail_visibility){ ?>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label><?= $grantee_grant->final_placement_detail == '' ? 'Final Placement Detail' : $grantee_grant->final_placement_detail ?></label>
                            <br />
                            <?php if(!$is_alumni_page) { ?>
                            <?php if($is_admin && !$is_grantee_non_degree_result) { ?>
                            <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#final_placement_detail">Add <?= $grantee_grant->final_placement_detail == '' ? 'Final Placement Detail' : $grantee_grant->final_placement_detail ?></button>
                            <?php } ?>
                            <?php } ?>
                            <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>Extension</th>
                                            <th>Upload Date</th>
                                            <?php if($is_admin){ ?>
                                            <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="list_final_placement_detail">
                                        <?php if($is_grantee_non_degree_result) : ?>
                                            <?php 
                                                foreach($submission_result_non_degree as $sub_result) : 
                                                if ($sub_result->status != 'Approved' || empty($sub_result->loi_file)) {
                                                    continue;
                                                }
                                                $detail_file = explode('.', $sub_result->loi_file);
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="<?= base_url($sub_result->loi_file) ?>" class="lightbox" style="cursor: pointer;">
                                                        <?= basename($sub_result->loi_file) ?>
                                                    </a>
                                                </td>
                                                <td><?= end($detail_file) ?></td>
                                                <td><?= $sub_result->created_at ?></td>
                                                <?php if($is_admin) { ?>
                                                <td></td>
                                                <?php } ?>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                        <?php foreach($final_placement_detail_file as $key => $fileFPD) {
                                            $detail_file = explode('.', $fileFPD->filename);
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url($fileFPD->file) ?>" class="lightbox" style="cursor: pointer;">
                                                    <?= $detail_file[0] ?>
                                                </a>
                                            </td>
                                            <td><?= end($detail_file) ?></td>
                                            <td><?= $fileFPD->created_date ?></td>
                                            <?php if($is_admin) { ?>
                                            <td>
                                                <?php if($is_admin) { ?>
                                                <!-- <button type="button" class="btn btn-primary btn-xs final_placement_detail_<?= $collage_placement->id ?>" data-id="<?= $collage_placement->id ?>" data-toggle="modal" data-target="#final_placement_detail">Upload</button> -->
                                                
                                                <?php if($fileFPD->file != '') { ?>
                                                <a href="<?= base_url($fileFPD->file) ?>" download title="Click to download" class="btn btn-primary btn-xs download-final-placement">
                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                </a>
                                                <?php } ?>
                                                <?php if($fileFPD->file != '') { ?>
                                                <a href="javascript:;" onclick="delete_file_placement(this, 'img-final_placement_detail', <?= $fileFPD->id ?>, 'final_placement_detail')" class="btn btn-danger btn-xs del-final-placement">
                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                </a>
                                                <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
                                        <?php endif; ?>

                                    </tbody>
                            </table>
                            <?php if ($collage_placement->final_placement_detail != '') { ?>
                                <!-- <div class="img-final_placement_detail" style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?php echo base_url() ?><?php echo $collage_placement->final_placement_detail ?>" class="lightbox"><img height="100" src="<?php echo get_preview($collage_placement->final_placement_detail); ?>"></a>
                                    <?php if($is_admin) { ?>
                                    <a href="javascript:;" onclick="delete_file_placement(this, 'img-final_placement_detail', <?= $collage_placement->id ?>, 'final_placement_detail')" class="btn btn-danger btn-xs" style="position:absolute; top:25px;">
                                        <i class="fa fa-trash fa-fw text-white"></i>
                                    </a>
                                    <?php } ?>
                                    <a href="<?= base_url($collage_placement->final_placement_detail) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                        <i class="fa fa-download fa-fw text-white"></i>
                                    </a>
                                    <?php 
                                        $len = explode('/', $collage_placement->final_placement_detail);
                                        $fileName = end($len);
                                        // if(strlen($fileName) > 15){
                                        //     $fileName = substr($fileName, 0, 15) . '....';
                                        // }
                                    ?>
                                    <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $fileName ?>"><?= $fileName ?></p>
                                </div> -->
                            <?php } ?>
                            <!-- <?php if($is_admin) { ?>
                            <input type="file" name="final_placement_detail" id="final_placement_detail">
                            <small class="file-for-testing">File Size Max 5MB</small>
                            <?php } ?> -->
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($grantee_grant->university_cores_visibility) { ?>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label><?= $grantee_grant->university_cores == '' ? 'University Corespondence' : $grantee_grant->university_cores ?></label>
                            <br />
                            <?php if(!$is_alumni_page) { ?>
                            <?php if($is_admin) { ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#corespondence_file">Add <?= $grantee_grant->university_cores == '' ? 'University Corespondence' : $grantee_grant->university_cores ?></button>
                            <?php } ?>
                            <?php } ?>
                            <!-- <input type="file" name="university_cores[]" id="university_cores" multiple>
                            <small class="file-for-testing">File Size Max 5MB</small> -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="wrap-corespondance">
                            <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>Extension</th>
                                            <th>Upload Date</th>
                                            <?php if($is_admin){ ?>
                                            <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="list_corespondance">
                                        <?php foreach($corespondance_file as $key => $fileCores) {
                                            $detail_file = explode('.', $fileCores->filename);
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url($fileCores->file) ?>" class="lightbox" style="cursor: pointer;">
                                                    <?= $detail_file[0] ?>
                                                </a>
                                            </td>
                                            <td><?= end($detail_file) ?></td>
                                            <td><?= $fileCores->created_date ?></td>
                                            <?php if($is_admin) { ?>
                                            <td>
                                                <a href="<?= base_url($fileCores->file) ?>" download title="Click to download" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                </a>
                                                <a href="javascript:;" onclick="del_cores_file(this, 'img-col', <?= $fileCores->id ?>)" class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                </a>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                            </table>


                            <?php foreach($corespondance_file as $key => $fileCores) { 
                                    if(strlen($fileCores->filename) > 15){
                                        $fileName = substr($fileCores->filename, 0, 15) . '....';
                                    }
                            ?>
                            <!-- <div class="col-lg-3 img-col" style="height: 150px;">
                                <a href="<?= base_url($fileCores->file) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($fileCores->file); ?>"></a>
                                <?php if($is_admin) { ?>
                                <a href="javascript:;" onclick="del_cores_file(this, 'img-col', <?= $fileCores->id ?>)" class="btn btn-danger btn-xs" style="position:absolute; top:25px;">
                                    <i class="fa fa-trash fa-fw text-white"></i>
                                </a>
                                <?php } ?>
                                <a href="<?= base_url($fileCores->file) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                    <i class="fa fa-download fa-fw text-white"></i>
                                </a> -->
                                <!-- <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $fileCores->filename ?>"><?= $fileName ?></p> -->
                            <!-- </div> -->
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php $this->load->view('admin/partials/modal_log') ?>


