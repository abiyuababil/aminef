
        <div class="row">
            <div class="tabs">
                <ul>
                    <?php foreach ($detail_data['step'] as $index => $step): ?>
                            <li>
                                <a aria-expanded="true" data-toggle="tab" href="#step_<?= $step->id ?>" onclick="navigate_tab(<?= $step->id ?>)"><?= $step->label; ?></a>
                            </li>
                    <?php endforeach; ?>
                </ul>
                <div class="row">
                    <form action="" id="form-submission" method="POST">
                        <input type="hidden" name="is_form" value="is_form">
                        <div class="tab-content">
                            <?php foreach ($detail_data['step'] as $index => $step): 
                                    $index_of_country = $this->session->userdata('index_of_country') ? ($this->session->userdata('index_of_country')) + 1 : 1;
                                    $this->session->set_userdata('index_of_country', $index_of_country);
                                    $index_of_state_of_study = $this->session->userdata('index_of_state_of_study') ? ($this->session->userdata('index_of_state_of_study')) + 1 : 1;
                                    $this->session->set_userdata('index_of_state_of_study', $index_of_state_of_study);
                                    ?>
                                    <div id="step_<?= $step->id; ?>" class="tab-pane fade <?php if ($index == 0) {
                                          echo 'active in first_tab';
                                      } ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <?php if ($step->note_letter_of_reference) { ?>
                                                    <?= $step->note_letter_of_reference ?>
                                                <?php } ?>
                                                <?php if ($step->is_letter_of_reference) { ?>
                                                <div class="row form-group mt-4">
                                                    <div class="col-lg-4">
                                                        <label>Letter of Reference</label>
                                                        <div class="row"> 
                                                        <div class="col-lg-8">
                                                            <img height="100" width="100" style="object-fit:contain;" src="<?php echo get_preview($detail_data['grantee_period']->letter_of_reference); ?>">
                                                            <br />
                                                            <!-- <p class="filename" style="font-size:16px"><?= $filename ?></p> -->
                                                            <a href="<?= base_url($detail_data['grantee_period']->letter_of_reference) ?>" download class="btn btn-info mt-3" style="color:#fff;" target="_blank">
                                                                <i class="fa fa-download fa-fw"></i> Download
                                                            </a>
                                                            <hr>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="panel-body">
                                                <!-- COLLEGEE PLACEMENT CANDIDATE -->
                                                <?php //if ($step->label == 'College Placement') { ?>
                                                    <!-- <div class="row">
                                                <div class="panel-body" style="margin-top:-30px">
                                                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> COLLEGE PLACEMENT</p>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>University</label>
                                                            <input type="text" disabled class="form-control" placeholder="University" name="department" value="<?php // echo $collage_placement->university_name ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Department</label>
                                                            <input type="text" disabled class="form-control" placeholder="Department" name="department" value="<?php // echo $collage_placement->department ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Estimated Cost</label>
                                                            <input type="text" disabled class="form-control" name="estimate_cost" placeholder="Estimated Cost" value="<?php // echo $collage_placement->total_cost ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Shortfails</label>
                                                            <textarea placeholder="Shortfails" name="shortfails" disabled cols="10" rows="3" class="form-control" width="100%"><?php // echo $collage_placement->shortfails ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Bank Statement</label>
                                                            <input type="text" disabled class="form-control" name="bank_statement" placeholder="Bank Statement" value="<?php // echo $collage_placement->bank_statement ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Start Date</label>
                                                            <input type="text" disabled class="form-control datepicker" placeholder="Start Date" name="start_date" value="<?php // echo $collage_placement->start_date ? date('d M Y', strtotime($collage_placement->start_date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body" style="margin-top:-30px">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Note</label>
                                                            <textarea placeholder="Note" name="note" disabled cols="10" rows="3" class="form-control" width="100%"><?php // echo $collage_placement->note ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Time of Arrival (TOA)</label><br/>
                                                            <?php //if ($collage_placement->toa != '') { ?>
                                                                <a href="<?php // echo base_url($collage_placement->toa) ?>" class="btn btn-primary lightbox" style="color:white">View</a>
                                                                <a href="<?php // echo base_url($collage_placement->toa) ?>" class="btn btn-primary" download><i class="fa fa-download fa-fw text-white"></i></a>
                                                            <?php // } ?>
                                                            <textarea placeholder="Time of Arrival (TOA)" name="toa" disabled cols="10" rows="3" class="form-control" width="100%"><?php // echo $collage_placement->toa ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                                    <!-- <hr> -->
                                                <?php //} ?>
                                                <!-- END COLLAGEE PLACEMENT CANDIDATE -->

                                                <!-- PRE DEPATURE ORIENTATION -->
                                                <?php //if ($step->label == 'Pre-Departure Orientation') { ?>
                                                    <!-- <div class="row">
                                                <div class="panel-body" style="margin-top:-30px">
                                                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Pre Departure Orientation</p>
                                                    <div class="col-lg-4">
                                                        <?php //if ($pre_depature->id) { ?>
                                                            <input type="hidden" name="pre_depature_id" value="<?php //echo $pre_depature->id ?>">
                                                        <?php //} ?>
                                                        <div class="form-group">
                                                            <label>Participant</label>
                                                            <input type="text" disabled class="form-control" placeholder="Participant" name="participant" value="<?php // echo $pre_depature->participant ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Speakers</label>
                                                            <input type="text" disabled class="form-control" name="speakers" placeholder="Speakers" value="<?php // echo $pre_depature->speakers ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Agenda</label>
                                                            <textarea disabled name="agenda" cols="10" rows="3" class="form-control" width="100%" placeholder="Agenda"><?php //echo $pre_depature->agenda ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Location</label>
                                                            <input type="text" disabled class="form-control" name="location" placeholder="Location" value="<?php //echo $pre_depature->location ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Date</label>
                                                            <input type="text" disabled class="form-control datepicker" placeholder="Date" name="date" value="<?php // echo $pre_depature->date ? date('d M Y', strtotime($pre_depature->date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Note</label>
                                                            <textarea disabled name="note" cols="10" rows="3" class="form-control" width="100%" placeholder="Note"><?php //echo $pre_depature->note ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                                <?php //} ?>
                                                <!-- ENDPRE DEPATURE ORIENTATION -->
                                                <?php $file = 0; ?>
                                                <?php $row = "<div class='row form-group'>"; ?>
                                                <?php $exitrow = "</div>"; ?>
                                                <?php 
                                                    foreach ($step->custom_fields as $key_fields => $custom_fields) { 
                                                    if($custom_fields->type == 'radio group'){
                                                        $custom_fields->user_grantee_id = $this->session->userdata('grantee_user_id');
                                                        $custom_fields->grantee_grant_id = $this->session->userdata('grantee_grant_id');
                                                    }
                                                ?>
                                                        <!-- template for others instead file template -->
                                                        <?php if ($custom_fields->type != 'file'): ?>
                                                            <div class="wrap-file-<?= $custom_fields->id ?>"> 
                                                                <div class="row form-group">
                                                                    <?php if ($custom_fields->type == 'separator'): ?>
                                                                            <div class="col-md-12 text-left font-weight-bold">
                                                                                <!-- <b><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $custom_fields->name); ?></b> -->
                                                                                <hr style="border-top:2px solid #eee" />
                                                                                <b><?= url_text($custom_fields->name); ?></b>
                                                                            </div>
                                                                            <?php if ($custom_fields->description_file != '') { ?>
                                                                                <div class="col-md-12 mt-2">
                                                                                    <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;"><?= $custom_fields->description_file ?></span>
                                                                                </div>
                                                                            <?php } ?>
                                                                    <?php else: ?>
                                                                            <div class="<?= $custom_fields->type == 'element group' ? 'col-md-12' : 'col-md-4' ?> text-left font-weight-bold">
                                                                                <?php if($custom_fields->type == 'element group') { ?>
                                                                                    <b><?= url_text($custom_fields->name); ?> <?= in_array($custom_fields->type, ['element group', 'radio group']) ? null : label_required($custom_fields->is_required); ?></b>
                                                                                    <div style="margin-top:10px;">
                                                                                        <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;"><?= $custom_fields->description_file ?></span>
                                                                                    </div>
                                                                                <?php } else {?>
                                                                                    <?= url_text($custom_fields->name); ?> <?= in_array($custom_fields->type, ['element group', 'radio group']) ? null : label_required($custom_fields->is_required); ?>
                                                                                <?php } ?>
                                                                            </div>
                                                                    <?php endif; ?>
                                                                    <div class="<?php echo in_array($custom_fields->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                        <?= get_component($custom_fields, $disabled, $custom_fields->value_custom_fields); ?>
                                                                    </div>
                                                                    <?php if ($custom_fields->description_file != '' && !in_array($custom_fields->type, ['separator', 'element group'])) { ?>
                                                                        <div class="col-lg-12" style="margin-top:-20px;">
                                                                            <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;"><?= $custom_fields->description_file ?></span>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                
                                                                <?php if ($custom_fields->is_multiple && $custom_fields->type != 'radio group') { ?>
                                                                    <?php foreach ($custom_fields->multiple_file as $kmf => $mf) { ?>
                                                                        
			                                                            <div class="multiple-item" style="margin-left: -15px;">
                                                                        <div class="<?= $custom_fields->type == 'element group' ? 'col-md-12' : 'col-md-4' ?> text-left font-weight-bold">
                                                                            <b><?= url_text($mf->property_name); ?></b>
                                                                            <a href="javascript:;" data-multiple-id="<?= $mf->id ?>" onclick="del_multiple(this, 'multiple-item')" class="btn btn-danger mt-2 pull-right" style="color:white;"><i class="fa fa-trash fa-fw"></i></a>
                                                                            <div style="margin-top:10px;">
                                                                                <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;"><?= $custom_fields->description_file ?></span>
                                                                            </div>
                                                                        </div>
                                                
                                                                        <div class="<?php echo in_array($custom_fields->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', NULL]) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                            <!-- dapatkan data value dari customfield multiple -->
                                                                            <?php 
                                                                            $condition_custom_fields_value = [
                                                                                'user_grantee_custom_fields_id' => $custom_fields->id,
                                                                                'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                                'user_grantee_id' => $this->session->userdata('grantee_user_id'),
                                                                                'user_grantee_period_id' => $custom_fields->period_id,
                                                                                'multiple_file_id' => $mf->id,
                                                                                'grantee_grant_id' => $this->session->userdata('grantee_grant_id')
                                                                            ];
                                                                            $value_custom_fields = get_all_db('am_user_grantee_submission', $condition_custom_fields_value);
                                                                            $sub_element = "";
                                                                            if ($custom_fields->type == 'radio group' || $custom_fields->type == 'element group'){
                                                                                $sub_element = get_all_db('am_user_grantee_group_element', ['custom_fields_id' => $custom_fields->id]);
                                                                                $sub_element = array_map(function($data) use ($value_custom_fields){
                                                                                    $get_value = array_filter($value_custom_fields, function($value) use ($data){
                                                                                        return $value->group_element_id == $data->id;
                                                                                    });
                                                                                    $data->value = array_column($get_value, 'value');
                                                                                    $data->submission_id = array_column($get_value, 'id');
                                                                                    return $data;
                                                                                }, $sub_element);
                                                                                $value_custom_fields = array_filter($value_custom_fields, function ($value) { return $value->group_element_id == 0;});
                                                                                $custom_fields->sub_element = $sub_element;
                                                                                $custom_fields->multiple_file_id = $mf->id;
                                                                            }
                                                                            ?>
                                                                            <?= get_component($custom_fields, $disabled, $custom_fields->value_custom_fields, true); ?>
                                                                        </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                            <?php if ($custom_fields->is_multiple && $custom_fields->type != 'radio group') { ?>
                                                                <div class="row col-md-12 mb-5">
                                                                    <a 
                                                                        href="javascript:;" 
                                                                        onclick="add_more_submission(this)" 
                                                                        class="btn btn-info <?= $display ?> mt-2 pull-right" 
                                                                        style ="color:#fff;display:<?= $display_upload ?>" 
                                                                        data-category-id="<?= $custom_fields->user_grantee_category_id; ?>" 
                                                                        data-category-type="<?= $custom_fields->user_grantee_category_type; ?>" 
                                                                        data-grant-id="<?= $custom_fields->user_grantee_grant_id; ?>" 
                                                                        data-step="<?= $custom_fields->user_grantee_step_id; ?>" 
                                                                        data-label="<?= url_text($custom_fields->name); ?>"
                                                                        data-period-id="<?= $custom_fields->period_id ?>"
                                                                        data-id="<?= $custom_fields->id; ?>"
                                                                        data-type="<?= $custom_fields->type; ?>"
                                                                    >
                                                                    Add New
                                                                    </a>
                                                                </div>
                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id ?>" style="display:none;">
                                                            <?php } ?>
                                                        <?php else: ?>
                                                                <?php
                                                                $display_upload = '';
                                                                if ($custom_fields->read_only == true) {
                                                                    $display_upload = 'none';
                                                                }
                                                                $filename = get_filename_submission($custom_fields);
                                                                $strlen = strlen($filename);
                                                                $name_file = $filename;
                                                                if ($strlen > 15) {
                                                                    $name_file = substr($filename, 0, 15) . '....';
                                                                }
                                                                $fileurl = get_fileurl_sumbission($custom_fields);
                                                                ?>
                                                                <?php 
                                                                if ($step->custom_fields[$key_fields + 1]->type == 'file') {
                                                                    $file = 0;
                                                                    $row = "";
                                                                    $exitrow = "";
                                                                    $style = "margin-left:-13px;";
                                                                    $mr = "";
                                                                } else {
                                                                    $row = "<div class='row form-group " . ($file < 3 && $file != 1 ? '' : '') . "'>";
                                                                    $exitrow = "</div>";
                                                                    $style = "";
                                                                    $mr = "margin-right:25px;";
                                                                } ?>
                                                                <?= $row; ?>
                                                                <div class="wrap-file-<?= $custom_fields->id ?>"> 
                                                                    <div class="<?= $custom_fields->is_row ? 'col-lg-12 is_row_class' : 'col-lg-4' ?>" style="<?= $style ?>">
                                                                        <label style="font-weight:400"><?= url_text($custom_fields->name) ?> <?= label_required($custom_fields->is_required) ?></label>
                                                                        <div style="margin-top: -25px;<?= $mr ?>">
                                                                            <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6" style="height: 151px;">
                                                                                <?php if ($fileurl) { ?>
                                                                                        <div id="preview_section_<?php echo $custom_fields->id; ?>" style="position:relative; width:100px;">
                                                                                            <img height="100" width="100" style="object-fit:contain;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                                            <a href="javascript:;" onclick="del_file(this, 'img_photo', '<?= $custom_fields->name ?>', <?= $custom_fields->id ?>, <?= $custom_fields->submission_id ?>)" class="btn btn-danger btn-xs <?= $display ?>" style="position:absolute; top:25px;display: <?= $display_upload ?>">
                                                                                                <i class="fa fa-trash fa-fw text-white"></i>
                                                                                            </a>
                                                                                            <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0;">
                                                                                                <i class="fa fa-download fa-fw text-white"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                <?php } else { ?>
                                                                                        <div id="preview_section_<?php echo $custom_fields->id; ?>" style="position:relative; width:100px;">
                                                                                            <?php if ($disabled == '') { ?>
                                                                                                    <?php if ($display_upload == '') { ?>
                                                                                                            <img onclick="add_file('my_file_' + <?= $custom_fields->id ?>);" data-trigger="my_file_<?= $custom_fields->id ?>" height="65" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
                                                                                                    <?php } else { ?>
                                                                                                            <img data-trigger="my_file_<?= $custom_fields->id ?>" height="65" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
                                                                                                    <?php } ?>
                                                                                                    <a href="javascript:;" onclick="del_file(this, 'img_photo', '<?= $custom_fields->name ?>', <?= $custom_fields->id ?>, 'subid')" class="hide btn btn-danger btn-xs btn-delete<?= $custom_fields->id ?> <?= $display ?>" style="position:absolute; top:25px;display: <?= $display_upload ?>">
                                                                                                        <i class="fa fa-trash fa-fw text-white"></i>
                                                                                                    </a>
                                                                                                    <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="hide btn btn-primary btn-xs btn-download<?= $custom_fields->id ?>" style="position:absolute; top:0;">
                                                                                                        <i class="fa fa-download fa-fw text-white"></i>
                                                                                                    </a>
                                                                                            <?php } else { ?>
                                                                                                    <img data-trigger="my_file_<?= $custom_fields->id ?>" height="65" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                <?php } ?>
                                                                                <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $filename ?>"><?= $name_file ?></p>
                                                                            </div>
                                                                            <?php
                                                                            if ($fileurl != '') {
                                                                                $display_file = 'inline-block';
                                                                            } else {
                                                                                $display_file = 'none';
                                                                            }

                                                                            if ($custom_fields->is_required) {
                                                                                $required = 'required';
                                                                                if ($fileurl != '') {
                                                                                    $required = '';
                                                                                }
                                                                            } else {
                                                                                $required = '';
                                                                            }
                                                                            ?>
                                                                            <div class="col-lg-6">
                                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="submission-spinner" style="display:none;">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                            <a href="javascript:;" id="my_file_<?= $custom_fields->id ?>" class="btn btn-primary upload-button <?= $display ?>" data-file-value="my_file_<?= $custom_fields->id ?>" style ="color:#fff;display:<?= $display_upload ?>">Upload</a>
                                                                            <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style ="color:#fff;display:<?= $display_file ?>"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                                            <?php if ($custom_fields->is_multiple) { ?>
                                                                                <a 
                                                                                    href="javascript:;" 
                                                                                    onclick="add_more_submission(this)" 
                                                                                    class="btn btn-info <?= $display ?>" 
                                                                                    style ="color:#fff;display:<?= $display_upload ?>" 
                                                                                    data-category-id="<?= $custom_fields->user_grantee_category_id; ?>" 
                                                                                    data-category-type="<?= $custom_fields->user_grantee_category_type; ?>" 
                                                                                    data-grant-id="<?= $custom_fields->user_grantee_grant_id; ?>" 
                                                                                    data-step="<?= $custom_fields->user_grantee_step_id; ?>" 
                                                                                    data-label="<?= url_text($custom_fields->name); ?>"
                                                                                    data-period-id="<?= $custom_fields->period_id ?>"
                                                                                    data-id="<?= $custom_fields->id; ?>"
                                                                                    data-type="<?= $custom_fields->type; ?>"
                                                                                >
                                                                                <i class="fa fa-plus fa-fw"></i>
                                                                                </a>
                                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id ?>" style="display:none;">
                                                                            <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                        <small class="file-for-testing">File Size Max 5MB | Supported File: Jpg, Png, PDF</small>
                                                                        <input onchange="show_preview(this, <?= $custom_fields->id ?>);" type="file" data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' data-step='<?= $custom_fields->user_grantee_step_id; ?>' data-id='<?= $custom_fields->id; ?>' data-period-id='<?= $custom_fields->period_id ?>' class="choosefile my_file_<?= $custom_fields->id ?> autosave" style="display: none;" <?= $required ?>>
                                                                        <hr style="<?= $mr ?>">
                                                                    </div>

                                                                    <?php if ($custom_fields->is_multiple) { ?>
                                                                            <?php foreach ($custom_fields->multiple_file as $kmf => $mf) { ?>
                                                                                    <?php
                                                                                    $filename_multiple = get_filename_submission_multiple($mf);
                                                                                    $strlen = strlen($filename_multiple);
                                                                                    $name_file_multiple = $filename_multiple;
                                                                                    if ($strlen > 15) {
                                                                                        $name_file_multiple = substr($filename_multiple, 0, 15) . '....';
                                                                                    }
                                                                                    $fileurl = get_fileurl_sumbission_multiple($mf);
                                                                                  ?>
                                                                                      <div class="<?= $custom_fields->is_row ? 'col-lg-12 is_row_class' : 'col-lg-4' ?> multiple-item">
                                                                                        <label style="min-height: 75px;font-weight:100"><?= url_text($mf->property_name); ?></label>
                                                                                        <a href="javascript:;" data-multiple-id="<?= $mf->id ?>" onclick="del_multiple(this, 'multiple-item')" class="btn btn-danger" style="color:white;margin-left:10px;margin-top:-20px;"><i class="fa fa-trash fa-fw"></i></a>
                                                                                        <div style="margin-top:-80px;">
                                                                                            <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                                        </div>
                                                                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="delete-multiple-spinner-<?= $mf->id ?>" style="display:none;">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-6" style="height: 150px;">
                                                                                                <?php if ($fileurl) { ?>
                                                                                                        <img height="100" width="100" style="object-fit:contain;" id="preview_image_<?= $custom_fields->id . $mf->id ?>" class="preview_image_<?= $custom_fields->id . $mf->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                                                        <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                                                                                            <i class="fa fa-download fa-fw text-white"></i>
                                                                                                        </a>
                                                                                                <?php } else { ?>
                                                                                                        <div id="preview_section_<?php echo $custom_fields->id . $mf->id; ?>" style="position:relative; width:100px;">
                                                                                                            <img onclick="add_file('my_file_' + <?= $custom_fields->id . $mf->id ?>);" data-trigger="my_file_<?= $custom_fields->id . $mf->id ?>" height="65" style="margin-top: 11px; cursor: pointer;" id="preview_image_<?= $custom_fields->id . $mf->id ?>" class="preview_image_<?= $custom_fields->id . $mf->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
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

                                                                                            if ($custom_fields->is_required) {
                                                                                                $required = 'required';
                                                                                                if ($fileurl != '') {
                                                                                                    $required = '';
                                                                                                }
                                                                                            } else {
                                                                                                $required = '';
                                                                                            }
                                                                                            ?>
                                                                                            <div class="col-lg-6">
                                                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="submission-spinner" style="display:none;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                            <a href="javascript:;" id="my_file_<?= $custom_fields->id . $mf->id ?>" class="btn btn-primary upload-button <?= $display ?>" data-file-value="my_file_<?= $custom_fields->id . $mf->id ?>" style ="color:#fff;">Upload</a>
                                                                                            <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style ="color:#fff;display:<?= $display_file ?>"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <small class="file-for-testing">File Size Max 5MB | Supported File: Jpg, Png, PDF</small>
                                                                                        <input 
                                                                                            onchange="show_preview(this, <?= $custom_fields->id . $mf->id ?>);" 
                                                                                            type="file" 
                                                                                            data-multiple-id='<?= $mf->id ?>'                                                                      data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' 
                                                                                            data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' 
                                                                                            data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' 
                                                                                            data-step='<?= $custom_fields->user_grantee_step_id; ?>' 
                                                                                            data-id='<?= $custom_fields->id; ?>' 
                                                                                            data-period-id='<?= $custom_fields->period_id ?>' 
                                                                                            class="choosefile my_file_<?= $custom_fields->id . $mf->id ?> autosave" 
                                                                                            style="display: none;" <?= $required ?>>
                                                                                        
                                                                                        <hr>
                                                                                    </div>
                                                                            <?php } ?>
                                                                    <?php } ?>
                                                                </div> <!-- endwrap -->
                                                                <?= $exitrow; ?>

                                                            <?php
                                                            $file++;
                                                        endif;
                                                        ?>
                                                <?php } ?>
                                            </div>
                                    
                                            <div class="wrap-step-<?= $step->id ?>">

                                            <!-- jika ada data multiple step -->
                                            <?php if (!empty($step->multiple_fields_step)) { ?>
                                                    <?php foreach ($step->multiple_fields_step as $key => $mfs) { ?>
                                                            <?php
                                                            $data_for_content['idx'] = $mfs->id;
                                                            $data_for_content['is_grantee'] = true;
                                                            foreach ($step->custom_fields as $kscf => $rowscf) {
                                                                $condition_multiple_file = [
                                                                    'user_grantee_custom_fields_id' => $rowscf->id,
                                                                    'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                    'user_grantee_id' => $this->session->userdata('grantee_user_id'),
                                                                    'user_grantee_period_id' => $rowscf->period_id,
                                                                    // 'multiple_file_id' => $mfs->id,
                                                                    'multiple_step_id' => $mfs->id
                                                                ];
                                                                $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_file);
                                                                $arr_value_custom_fields = get_all_db('am_user_grantee_submission', $condition_multiple_file);
                                                                // if type radio group then get sub element 
                                                                $sub_element = "";
                                                                if ($rowscf->type == 'radio group' || $rowscf->type == 'element group') {
                                                                    $sub_element = get_all_db('am_user_grantee_group_element', ['custom_fields_id' => $rowscf->id]);
                                                                    $sub_element = array_map(function ($data) use ($arr_value_custom_fields) {
                                                                        $get_value = array_filter($arr_value_custom_fields, function ($value) use ($data) {
                                                                            return $value->group_element_id == $data->id;
                                                                        });
                                                                        $data->value = array_column($get_value, 'value');
                                                                        return $data;
                                                                    }, $sub_element);

                                                                }
                                                                $multiple_file = get_row_db('am_user_grantee_multiple_file', ['user_grantee_step_id' => $mfs->id, 'property_name' => $rowscf->name]);
                                                                $rowscf->value_custom_fields = $value_multiple_file->value;
                                                                $rowscf->other_value = $value_multiple_file->other_value;
                                                                $rowscf->multiple_step_id = $mfs->id;
                                                                $rowscf->multiple_file_id = $multiple_file->id;
                                                                $rowscf->sub_element = $sub_element;

                                                                if ($rowscf->is_multiple == true) {
                                                                    $multiple_file_for_file = get_all_db('am_user_grantee_multiple_file', [
                                                                        'custom_fields_id' => $rowscf->id,
                                                                        'grantee_grant_id' => $this->session->userdata('grantee_grant_id'),
                                                                        'user_grantee_step_id' => $mfs->id,
                                                                    ]);
                                                                    foreach ($multiple_file_for_file as $kmf => $mf) {
                                                                        $condition_multiple_for_file = [
                                                                            'user_grantee_custom_fields_id' => $rowscf->id,
                                                                            'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                            'user_grantee_id' => $this->session->userdata('grantee_user_id'),
                                                                            'user_grantee_period_id' => $rowscf->period_id,
                                                                            'multiple_file_id' => $mf->id,
                                                                            'multiple_step_id' => $mfs->id,
                                                                        ];
                                                                        $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_for_file);
                                                                        $mf->value = $value_multiple_file ? $value_multiple_file->value : '';
                                                                    }
                                                                    $rowscf->multiple_file = $multiple_file_for_file;
                                                                }
                                                            }
                                                            $data_for_content['data_custom_fields'] = $step->custom_fields;
                                                            echo $this->load->view('grantee/submission/multiple_fields_step', $data_for_content, true);
                                                            ?>
                                                    <?php } ?>
                                            <?php } ?>
                                            </div>
                                            <?php if ($step->is_multiple_fields ) { ?>
                                                <div class="panel-body">
                                                    <div class="pull-left">
                                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-step-spinner-<?= $step->id ?>" style="display:none;">
                                                        <a 
                                                            href="javascript:;" 
                                                            onclick="add_more_step_fields(this)" 
                                                            data-id="<?= $step->id ?>" 
                                                            data-user_grantee_category_id="<?= $step->user_grantee_category_id ?>" 
                                                            data-user_grantee_grant_id="<?= $step->user_grantee_grant_id ?>" 
                                                            data-period_id="<?= $step->custom_fields[0]->period_id ?>" 
                                                            class="btn btn-primary <?= $display ?>" 
                                                            style="color:white">Add New
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php if ((!isset($is_preview) || !$is_preview) && $detail_data['detail_grantee_grant']->status != STATUS_SET_TO_ALUMNI) { ?>
                                            <div class="progressbar">
                                                <?php if ($index + 1 == count($detail_data['step'])): ?>
                                                        <a href="#submit" data-submit="form-submission" class="btn btn-success submit-submission" <?= $disabled ?> style="color:#fff;float:right;margin-bottom:20px;width:100px;">Submit</a>
                                                <?php elseif ($index == 0): ?>
                                                        <a aria-expanded="true" data-toggle="tab" data-index="step_<?= $detail_data['step'][1]->id; ?>" class="btn btn-success next" style="color:#fff;float:right;margin-bottom:20px;">Save & Continue</a>
                                                <?php else: ?>
                                                        <a aria-expanded="true" data-toggle="tab" href="#step_<?= $detail_data['step'][$index - 1]->id; ?>" class="btn btn-primary previous" style="color:#fff;float:left;margin-bottom:20px;width:100px;">Back</a>
                                                        <a aria-expanded="true" data-toggle="tab" data-index="step_<?= $detail_data['step'][$index + 1]->id; ?>" class="btn btn-success next" style="color:#fff;float:right;margin-bottom:20px;">Save & Continue</a>
                                                <?php endif; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->