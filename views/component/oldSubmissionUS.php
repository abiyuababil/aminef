
                    <div class="row">
                        <div class="tabs">
                            <ul>
                                <?php
                                foreach ($grants_step as $index => $step) : ?>
                                    <li>
                                        <a data-toggle="tab" href="#step_<?= $index; ?>" aria-expanded="true"><?= $step->label ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="row">
                                <div class="col col-lg-12">
                                    <div class="tab-content">
                                        <?php foreach ($grants_step as $index => $step) : ?>
                                            <div id="step_<?= $index; ?>" class="tab-pane fade <?php if ($index == 0) { echo 'active in'; } ?>">
                                                <div class="panel panel-default">
                                                   <?php 
                                                    $disabled = '';
                                                    $display = '';
                                                    if ($category->name == 'Grant Information' && $grantee_grant->grant_document_status == DOCUMENT_COMPLETED) {
                                                        $disabled = 'disabled';
                                                        $display = 'none';
                                                    }
                                                    if ($category->name == 'Grant Profile' && $grantee_grant->grant_document_status == DOCUMENT_COMPLETED) {
                                                        $disabled = 'disabled';
                                                        $display = 'none';
                                                    }
                                                   ?>
                                                    <?php if($step->is_multiple_fields && $disabled == '') { ?>
                                                    <div class="panel-body">
                                                        <div class="pull-right">
                                                            <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-step-spinner-<?= $step->id ?>" style="display:none;">
                                                            <a 
                                                                href="javascript:;" 
                                                                onclick="add_more_step_fields(this)" 
                                                                data-id="<?= $step->id ?>" 
                                                                data-user_grantee_category_id="<?= $step->user_grantee_category_id ?>" 
                                                                data-user_grantee_grant_id="<?= $step->user_grantee_grant_id ?>" 
                                                                data-period_id="<?= $grantee_grant->fiscal_year ?>" 
                                                                class="btn btn-primary <?= $display ?>" 
                                                                style="color:white">Add New
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="panel-body">
                                                        <?php
                                                        $file = 0;
                                                        ?>
                                                        <?php $row = "<div class='row form-group'>"; ?>
                                                        <?php $exitrow = "</div>"; ?>
                                                        <?php foreach ($custom_fields[$grantee_grant->grant_id][$step->id] as $key_fields => $cf) { ?>
                                                            <!-- template for others instead file template -->
                                                            <?php if ($cf->type != 'file') : ?>
                                                                <div class="row form-group">
                                                                    <?php if ($cf->type == 'separator') : ?>
                                                                        <div class="col-md-4 font-weight-bold">
                                                                            <b><?= url_text($cf->name); ?></b>
                                                                            <?php if($cf->description_file != '' ) { ?>
                                                                            <div class="row mt-2 text-danger">
                                                                                <em style="font-size: 12px !important; margin-left: 15px;"><?= url_text($cf->description_file) ?></em>
                                                                            </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <div class="col-md-4 font-weight-bold">
                                                                            <?= url_text($cf->name); ?><?= label_required($cf->is_required); ?>
                                                                            <?php if($cf->description_file != '' ) { ?>
                                                                            <div class="row mt-2 text-danger">
                                                                                <em style="font-size: 12px !important; margin-left: 15px;"><?= url_text($cf->description_file) ?></em>
                                                                            </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                    
                                                                    <div class="<?php echo in_array($custom_field->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', NULL]) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                        <?= get_component($cf, $disabled, $cf->value_custom_fields); ?>
                                                                    </div>
                                                                </div>
                                                            <?php else : ?>
                                                                <?php
                                                                $filename = get_filename_submission($cf);
                                                                $strlen = strlen($filename);
                                                                $name_file = $filename;
                                                                if ($strlen > 15) {
                                                                    $name_file = substr($filename, 0, 15) . '....';
                                                                }
                                                                $fileurl = get_fileurl_sumbission($cf);
                                                                ?>
                                                                <?php if ($file == 3 || $custom_fields[$grantee_grant->grant_id][$step->id][$key_fields+1]->type == 'file') {
                                                                    $file = 0;
                                                                    $row = "";
                                                                    $exitrow = "";
                                                                } else {
                                                                    $row = "<div class='row form-group'>";
                                                                    $exitrow = "</div>";
                                                                } ?>
                                                                <?= $row; ?>
                                                                <div class="wrap-file-<?= $cf->id ?>">
                                                                    <div class="col-md-4">
                                                                        <label style="min-height: 75px;"><?= url_text($cf->name); ?></label>
                                                                        <div class="row">
                                                                            <div class="col-lg-6" style="min-height: 150px !important;">
                                                                                <?php if($fileurl) { ?>
                                                                                    <img height="100" id="preview_image_<?= $cf->id ?>" class="preview_image_<?= $cf->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                                    <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                                                                        <i class="fa fa-download fa-fw text-white"></i>
                                                                                    </a>
                                                                                <?php } else { ?>
                                                                                    <div id="preview_section_<?= $cf->id ?>; ?>" style="margin-bottom: 10px; position:relative; width:100px;">
                                                                                        <img onclick="add_file('my_file_' + <?= $cf->id ?>);" data-trigger="my_file_<?= $cf->id ?>" height="65" style="margin-bottom: 17px; margin-top: 16px; cursor: pointer;" id="preview_image_<?= $cf->id ?>" class="preview_image_<?= $cf->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
                                                                                    </div>
                                                                                <?php } ?>
                                                                                <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $filename ?>"><?= $name_file ?></p>
                                                                            </div>
                                                                            <?php if ($fileurl != '') {
                                                                                $display_file = 'inline-block';
                                                                            } else {
                                                                                $display_file = 'none';
                                                                            }
                                                                            ?>
                                                                            <div class="col-lg-6" style="min-height: 150px !important;">
                                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="submission-spinner" style="display:none;">
                                                                            </div>
                                                                        </div>
                                                                        <a href="javascript:;" class="btn btn-primary upload-button" data-file-value="my_file_<?= $cf->id ?>" style="color:#fff" >Upload</a>
                                                                        <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:<?= $display_file ?>">
                                                                            <i class="fa fa-eye fa-fw"></i> Preview
                                                                        </a>
                                                                        <?php if($cf->is_multiple) { ?>
                                                                        <a 
                                                                            href="javascript:;" 
                                                                            onclick="add_more_submission(this)" 
                                                                            class="btn btn-info <?= $display ?>" 
                                                                            style ="color:#fff;" 
                                                                            data-category-id="<?= $cf->user_grantee_category_id; ?>" 
                                                                            data-category-type="<?= $cf->user_grantee_category_type; ?>" 
                                                                            data-grant-id="<?= $cf->user_grantee_grant_id; ?>" 
                                                                            data-step="<?= $cf->user_grantee_step_id; ?>" 
                                                                            data-label="<?= url_text($cf->name); ?>"
                                                                            data-period-id="<?= $cf->period_id ?>"
                                                                            data-id="<?= $cf->id; ?>"
                                                                        >
                                                                        <i class="fa fa-plus fa-fw"></i>
                                                                        </a>
                                                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id ?>" style="display:none;">
                                                                        <?php } ?>
                                                                        <div class="row mt-2 text-danger">
                                                                            <em style="font-size: 12px !important; margin-left: 15px;"><?= !empty($cf->description_file) ? $cf->description_file : '&nbsp;'  ?></em>
                                                                        </div>
                                                                        <input onchange="show_preview(this, <?= $cf->id ?>);" type="file" data-category-id='<?= $cf->user_grantee_category_id; ?>' data-category-type='<?= $cf->user_grantee_category_type; ?>' data-grant-id='<?= $cf->user_grantee_grant_id; ?>' data-step='<?= $cf->user_grantee_step_id; ?>' data-id='<?= $cf->id; ?>' data-period-id='<?= $cf->period_id ?>' class="choosefile my_file_<?= $cf->id ?>" style="display: none;">
                                                                        <small class="file-for-testing">File Size Max 5MB</small>
                                                                        <hr>
                                                                    </div>

                                                                    <?php if($cf->is_multiple) { ?>
                                                                        <?php foreach ($cf->multiple_file as $kmf => $mf) { ?>
                                                                            <?php
                                                                                $filename_multiple = get_filename_submission_multiple($mf);
                                                                                $strlen = strlen($filename_multiple);
                                                                                $name_file_multiple = $filename_multiple;
                                                                                if ($strlen > 15) {
                                                                                    $name_file_multiple = substr($filename_multiple, 0, 15) . '....';
                                                                                }
                                                                                $fileurl = get_fileurl_sumbission_multiple($mf);
                                                                            ?>
                                                                            <div class="col-md-4 multiple-item">
                                                                                <label style="min-height: 75px;"><?= url_text($mf->property_name); ?></label>
                                                                                <a href="javascript:;" data-multiple-id="<?= $mf->id ?>" onclick="del_multiple(this, 'multiple-item')" class="btn btn-danger" style="color:white;margin-left:10px;"><i class="fa fa-trash fa-fw"></i></a>
                                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="delete-multiple-spinner-<?= $mf->id ?>" style="display:none;">
                                                                                <div class="row">
                                                                                    <div class="col-lg-6" style="height: 150px;">
                                                                                        <?php if($fileurl) { ?>
                                                                                            <img height="100" id="preview_image_<?= $cf->id.$mf->id ?>" class="preview_image_<?= $cf->id.$mf->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                                            <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                                                                                <i class="fa fa-download fa-fw text-white"></i>
                                                                                            </a>
                                                                                        <?php } else { ?>
                                                                                            <div id="preview_section_<?php echo $cf->id.$mf->id; ?>" style="margin-bottom: 50px; margin-bottom: 30px; position:relative; width:100px;">
                                                                                                <img onclick="add_file('my_file_' + <?= $cf->id.$mf->id ?>);" data-trigger="my_file_<?= $cf->id.$mf->id ?>" height="65" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $cf->id.$mf->id ?>" class="preview_image_<?= $cf->id.$mf->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                        <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $filename_multiple ?>"><?= $name_file_multiple ?></p>
                                                                                    </div>
                                                                                    <?php 
                                                                                    if ($fileurl != '') {
                                                                                        $display_file = 'inline-block';
                                                                                    } else {
                                                                                        $display_file = 'none';
                                                                                    }

                                                                                    if($cf->is_required){
                                                                                        $required = 'required';
                                                                                        if($fileurl != ''){
                                                                                            $required = '';
                                                                                        }
                                                                                    }else{
                                                                                        $required = '';
                                                                                    }
                                                                                    ?>
                                                                                    <div class="col-lg-6">
                                                                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="submission-spinner" style="display:none;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                    <a href="javascript:;" id="my_file_<?= $cf->id.$mf->id ?>" class="btn btn-primary upload-button <?= $display ?>" data-file-value="my_file_<?= $cf->id.$mf->id ?>" style ="color:#fff;">Upload</a>
                                                                                    <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style ="color:#fff;display:<?= $display_file ?>"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mt-2 text-danger">
                                                                                    <em style="font-size: 12px !important; margin-left: 15px;"><?= !empty($cf->description_file) ? $cf->description_file : '&nbsp;'  ?></em>
                                                                                </div>
                                                                                <input 
                                                                                    onchange="show_preview(this, <?= $cf->id.$mf->id ?>);" 
                                                                                    type="file" 
                                                                                    data-multiple-id='<?= $mf->id ?>'
                                                                                    data-category-id='<?= $cf->user_grantee_category_id; ?>' 
                                                                                    data-category-type='<?= $cf->user_grantee_category_type; ?>' 
                                                                                    data-grant-id='<?= $cf->user_grantee_grant_id; ?>' 
                                                                                    data-step='<?= $cf->user_grantee_step_id; ?>' 
                                                                                    data-id='<?= $cf->id; ?>' 
                                                                                    data-period-id='<?= $cf->period_id ?>' 
                                                                                    class="choosefile my_file_<?= $cf->id.$mf->id ?> autosave" 
                                                                                    style="display: none;" <?= $required ?>
                                                                                >
                                                                                <small class="file-for-testing">File Size Max 5MB</small>
                                                                                <hr>
                                                                            </div>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                                <?= $exitrow; ?>
                                                            <?php $file++;
                                                            endif; ?>
                                                        <?php } ?>
                                                    </div>
                                    
                                                    <div class="wrap-step-<?= $step->id ?>">

                                                    <!-- jika ada data multiple step -->
                                                    <?php if(!empty($step->multiple_fields_step)) { ?>
                                                        <?php foreach($step->multiple_fields_step as $key => $mfs ) { ?>
                                                            <?php
                                                                $data_for_content['idx'] = $mfs->id;
                                                                $data_for_content['is_grantee'] = true;
                                                                $data_for_content['disabled'] = $disabled;
                                                                foreach($custom_fields[$grantee_grant->grant_id][$step->id] as $kscf => $rowscf) {
                                                                    $condition_multiple_file = [
                                                                        'user_grantee_custom_fields_id' => $rowscf->id,
                                                                        'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                        'user_grantee_id' => $grantee_grant->user_grantee_id,
                                                                        'user_grantee_period_id' => $rowscf->period_id,
                                                                        // 'multiple_file_id' => $mfs->id,
                                                                        'multiple_step_id' => $mfs->id,
                                                                        'grantee_grant_id' => $grantee_grant->id
                                                                    ];
                                                                    $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_file);
                                                                    $arr_value_custom_fields = get_all_db('am_user_grantee_submission', $condition_multiple_file);
                                                                    // if type radio group then get sub element 
                                                                    $sub_element = "";
                                                                    if ($rowscf->type == 'radio group' || $rowscf->type == 'element group'){
                                                                        $sub_element = get_all_db('am_user_grantee_group_element', ['custom_fields_id' => $rowscf->id]);
                                                                        $sub_element = array_map(function($data) use ($arr_value_custom_fields){
                                                                            $get_value = array_filter($arr_value_custom_fields, function($value) use ($data){
                                                                                return $value->group_element_id == $data->id;
                                                                            });
                                                                            $data->value = array_column($get_value, 'value');
                                                                            return $data;
                                                                        }, $sub_element);

                                                                    }
                                                                    $multiple_file = get_row_db('am_user_grantee_multiple_file', ['user_grantee_step_id' => $mfs->id, 'property_name' => $rowscf->name]);
                                                                    $rowscf->value_custom_fields = $value_multiple_file->value;
                                                                    $rowscf->other_value         = $value_multiple_file->other_value;
                                                                    $rowscf->multiple_step_id = $mfs->id;
                                                                    $rowscf->multiple_file_id = $multiple_file->id;
                                                                    $rowscf->sub_element = $sub_element;

                                                                    if ($rowscf->type == 'file' && $rowscf->is_multiple == true){
                                                                        $multiple_file_for_file = get_all_db('am_user_grantee_multiple_file', [
                                                                            'custom_fields_id' => $rowscf->id,
                                                                            'grantee_grant_id' => $grantee_grant->id,
                                                                            'user_grantee_step_id' => $mfs->id,
                                                                        ]);
                                                                        foreach($multiple_file_for_file as $kmf => $mf){

                                                                            $condition_multiple_for_file = [
                                                                                'user_grantee_custom_fields_id' => $rowscf->id,
                                                                                'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                                'user_grantee_id' => $grantee_grant->user_grantee_id,
                                                                                'user_grantee_period_id' => $rowscf->period_id,
                                                                                'multiple_file_id' => $mf->id,
                                                                                'multiple_step_id' => $mfs->id,
                                                                                'grantee_grant_id' => $grantee_grant->id,
                                                                            ];
                                                                            $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_for_file);
                                                                            $mf->value = $value_multiple_file ? $value_multiple_file->value : '';
                                                                        }
                                                                        $rowscf->multiple_file = $multiple_file_for_file;
                                                                    }
                                                                }
                                                                $data_for_content['data_custom_fields'] = $custom_fields[$grantee_grant->grant_id][$step->id];
                                                                echo $this->load->view('grantee/submission/multiple_fields_step', $data_for_content, true); 
                                                            ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="progressbar">
                                                    <?php if (count($grants_step) == 1) : ?>
                                                        <!-- <a aria-expanded="true" data-toggle="tab" href="#step_<?= $step->name - 1; ?>" onclick="back_step(<?= $step->name - 1; ?>, <?= $grantee_grant->grant_id ?>)" class="btn btn-primary previous" style="color:#fff;float:left;margin-bottom:20px;width:100px;">Back</a> -->

                                                        <?php //if($grantee_grant->grant_document_status != DOCUMENT_COMPLETED){ 
                                                        ?>
                                                        <?php if ($category->name == 'Permit Application' || $category->name == 'Pre Arrival Documents') { ?>
                                                            <a 
                                                                href="javascript:;" 
                                                                data-submit="form-submission" 
                                                                onclick="permit_reject_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                                class="btn btn-danger permit-reject-submission"
                                                                 id="btn-permit-reject-
                                                                 submission" style="color:#fff;float:right;margin-bottom:20px;margin-right:5px;">
                                                                 Permit Rejected
                                                            </a>
                                                            <a 
                                                                href="javascript:;" 
                                                                data-submit="form-submission" 
                                                                onclick="withdraw_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                                class="btn btn-primary withdraw-submission" 
                                                                id="btn-withdraw-submission" 
                                                                style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                                Withdraw
                                                            </a>
                                                            <a 
                                                                href="javascript:;" 
                                                                data-submit="form-submission" 
                                                                onclick="arrived_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                                class="btn btn-info arrived-submission" 
                                                                id="btn-arrived-submission" 
                                                                style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                                Arrived
                                                            </a>
                                                        <?php } ?>
                                                        <?php if($category->is_new_grantee == 1) { ?>
                                                        <a 
                                                            href="javascript:;" 
                                                            data-submit="form-submission" 
                                                            onclick="accept_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                            class="btn btn-success submit-submission" 
                                                            id="btn-accept-submission" 
                                                            style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                            Complete
                                                        </a>
                                                        <a 
                                                            href="javascript:;" 
                                                            data-submit="form-submission" 
                                                            onclick="revise_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                            class="btn btn-warning revise-submission" 
                                                            id="btn-revise-submission" 
                                                            style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                            Revise
                                                        </a>
                                                        <?php } ?>
                                                    <?php elseif ($index == 0) : ?>
                                                        <a 
                                                            aria-expanded="true" 
                                                            data-toggle="tab" 
                                                            href="#step_<?= $index + 1; ?>" 
                                                            class="btn btn-success next" 
                                                            onclick="next_step(<?= $index + 1; ?>, <?= $grantee_grant->grant_id ?>)" 
                                                            style="color:#fff;float:right;margin-bottom:20px;width:100px;">Next
                                                        </a>
                                                    <?php elseif ($index + 1 == count($grants_step)) : ?>
                                                        <a 
                                                            aria-expanded="true" 
                                                            data-toggle="tab" 
                                                            href="#step_<?= $index - 1; ?>" 
                                                            onclick="back_step(<?= $index - 1; ?>, <?= $grantee_grant->grant_id ?>)" 
                                                            class="btn btn-primary previous" 
                                                            style="color:#fff;float:left;margin-bottom:20px;width:100px;">
                                                            Back
                                                        </a>

                                                        <?php //if($grantee_grant->grant_document_status != DOCUMENT_COMPLETED){ 
                                                        ?>
                                                        <?php if ($category->name == 'Permit Application' || $category->name == 'Pre Arrival Documents') { ?>
                                                            <a 
                                                                href="javascript:;" 
                                                                data-submit="form-submission" 
                                                                onclick="permit_reject_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                                class="btn btn-danger permit-reject-submission"
                                                                 id="btn-permit-reject-submission"
                                                                  style="color:#fff;float:right;margin-bottom:20px;width:auto;margin-right:5px;">
                                                                  Permit Rejected
                                                            </a>
                                                            <a 
                                                                href="javascript:;" 
                                                                data-submit="form-submission" 
                                                                onclick="withdraw_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                                class="btn btn-primary withdraw-submission" 
                                                                id="btn-withdraw-submission" 
                                                                style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                                Withdraw
                                                            </a>
                                                            <a 
                                                                href="javascript:;" 
                                                                data-submit="form-submission" 
                                                                onclick="arrived_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                                class="btn btn-info arrived-submission" 
                                                                id="btn-arrived-submission" 
                                                                style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                                Arrived
                                                            </a>
                                                        <?php } ?>
                                                        <?php if($category->is_new_grantee == 1) { ?>
                                                        <a 
                                                            href="javascript:;" 
                                                            data-submit="form-submission" 
                                                            onclick="accept_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                            class="btn btn-success submit-submission" 
                                                            id="btn-accept-submission" 
                                                            style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                            Complete
                                                        </a>
                                                        <a 
                                                            href="javascript:;" 
                                                            data-submit="form-submission" 
                                                            onclick="revise_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>)" 
                                                            class="btn btn-warning revise-submission" 
                                                            id="btn-revise-submission" 
                                                            style="color:#fff;float:right;margin-bottom:20px;width:100px;margin-right:5px;">
                                                            Revise
                                                        </a>
                                                        <?php } ?>
                                                    <?php else : ?>
                                                        <a 
                                                            aria-expanded="true" 
                                                            data-toggle="tab" 
                                                            href="#step_<?= $index - 1; ?>" 
                                                            onclick="back_step(<?= $index - 1; ?>, <?= $grantee_grant->grant_id ?>)" 
                                                            class="btn btn-primary previous" 
                                                            style="color:#fff;float:left;margin-bottom:20px;width:100px;">
                                                            Back
                                                        </a>
                                                        <a 
                                                            aria-expanded="true" 
                                                            data-toggle="tab" 
                                                            href="#step_<?= $index + 1; ?>" 
                                                            onclick="next_step(<?= $step->name + 1; ?>, <?= $grantee_grant->grant_id ?>)" 
                                                            class="btn btn-success next"
                                                            style="color:#fff;float:right;margin-bottom:20px;width:100px;">
                                                            Next
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <br><br>
                                        <hr>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea name="note" id="note_document" cols="30" rows="10" class="form-control" width="100%"><?= $note_document ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>