<?php 

if($is_alumni_page){
    $disabled = 'disabled';
    $display = 'd-none';
}
?>

<div class="multiple-step">
<hr>
<div class="panel-body">
    <?php if($disabled == '') { ?>
    <div class="pull-right">
        <img src="<?php echo base_url() ?>/img/loading.gif" class="delete-multiple-step-spinner-<?= $idx ?>" style="display:none;">
        <a 
            href="javascript:;" 
            data-id="<?= $idx ?>"
            onclick="del_multiple_step(this, 'multiple-step')"
            class="btn btn-danger <?= $display?>" 
            style="color:white">
            <i class="fa fa-trash fa-fw"></i>
        </a>
    </div>
    <?php } ?>
</div>
<div class="panel-body multiple-step-<?= $step_id ?>" style="margin-top:-25px;">
    <?php $file = 0; ?>
    <?php $row = "<div class='row form-group'>"; ?>
    <?php $exitrow = "</div>"; ?>
    <?php foreach ($data_custom_fields as $key_fields => $custom_fields) { ?>
        <?php if($custom_fields->not_show_grantee && !$is_admin) { continue; } ?>
        <!-- template for others instead file template -->
        <?php if ($custom_fields->type != 'file') : ?>
            <div class="wrap-file-<?= $custom_fields->id ?> wrap-file-step-<?= $custom_fields->id ?>" data-conditional-parent-id="<?= !empty($custom_fields->conditional_parent_id) ? (int)$custom_fields->conditional_parent_id : '' ?>" data-conditional-parent-value="<?= htmlspecialchars($custom_fields->conditional_parent_value ?? '', ENT_QUOTES) ?>"> 
                <div class="row form-group multiple-cf-<?= $custom_fields->id.$custom_fields->multiple_step_id ?>">
                    <?php if ($custom_fields->type == 'separator') : ?>
                        <?php if ((int) $custom_fields->parent_section_id > 0 ) { ?>
                            <div class="col-lg-12 text-left">
                                <?= get_label_form($custom_fields) ?>
                                <?php if ($custom_fields->description_file != '') { ?>
                                    <div class="mt-2">
                                        <span style="font-size: 12px !important; margin-left: 15px;"><?= $custom_fields->description_file ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-12 text-left font-weight-bold">
                                <!-- <b><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $custom_fields->name); ?></b> -->
                                <hr style="border-top:2px solid #eee" class="p-0 mt-1 mb-1" />
                                <?= get_label_form($custom_fields) ?>
                                <?php if ($custom_fields->description_file != '') { ?>
                                    <div class="mt-2">
                                        <span style="font-size: 12px !important; margin-left: 15px;"><?= $custom_fields->description_file ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php elseif ($custom_fields->type == 'highlight'): ?>
                        <hr style="border-top:2px solid #eee" class="p-0 mt-1 mb-1" />
                    <?php else : ?>
                        <div style="display:flex;<?= in_array($custom_fields->type, ['element group', 'table schedule', 'education group']) ? 'flex-direction: column;' : 'flex-direction: column;' ?>" class="<?= in_array($custom_fields->type, ['element group', 'table schedule', 'education group']) || $custom_fields->is_row  ? 'col-md-12' : 'col-md-4' ?> <?php echo (int) $custom_fields->parent_id > 0 && $custom_fields->is_advanced_checkbox ? 'ml-4' : ''; ?> text-left font-weight-bold <?php echo $custom_fields->hide_question_label ? 'hide' : ''; ?>">
                            <?php if (in_array($custom_fields->type, ['element group', 'table schedule', 'education group'])) { ?>
                                <b><?= get_label_form($custom_fields) ?></b>
                                <div style="margin-top:-15px;">
                                    <span class="span-note" style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                </div>
                            <?php } else { ?>
                                <?= get_label_form($custom_fields) ?>
                                <?php if (in_array($custom_fields->type, ['text']) && $custom_fields->under_question) { ?>
                                    <div>
                                        <span class="span-note" style="font-size: 12px !important; text-align: justify;"><?= $custom_fields->description_file ?></span>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php if ($custom_fields->description_file != ''  && in_array($custom_fields->type, ['element group', 'education group'])) { ?>
                            <div class="col-md-12" style="margin-top: -10px;">
                                <span class="span-note" style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                            </div>
                        <?php } ?>
                    <?php endif; ?>
                    
                    <div class="<?php echo in_array($custom_fields->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                        <?= get_component($custom_fields, $disabled, $custom_fields->value_custom_fields, true); ?>
                    </div>
                    <?php if ($custom_fields->description_file != '' && !in_array($custom_fields->type, ['separator', 'element group', 'education group']) && !$custom_fields->under_question) { ?>
                        <div class="<?= $activeCountry == AMERICAN_DATABASE ? 'col-lg-4' : 'col-lg-12' ?>" style="margin-top: -10px;">
                            <span class="span-note" style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if ($custom_fields->is_multiple && !in_array($custom_fields->type, ['radio group', 'education group']) && $disabled == '') { ?>
                <div class="row col-md-12">
                    <a 
                        href="javascript:;" 
                        onclick="add_more_submission(this, <?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>)" 
                        class="btn btn-info <?= $display ?> mt-2 pull-right" 
                        style ="color:#fff;display:<?= $display_upload ?>" 
                        data-category-id="<?= $custom_fields->user_grantee_category_id; ?>" 
                        data-category-type="<?= $custom_fields->user_grantee_category_type; ?>" 
                        data-grant-id="<?= $custom_fields->user_grantee_grant_id; ?>" 
                        data-step="<?= $custom_fields->user_grantee_step_id; ?>" 
                        data-label="<?= strip_tags($custom_fields->name); ?>"
                        data-period-id="<?= $custom_fields->period_id ?>"
                        data-id="<?= $custom_fields->id; ?>"
                        data-type="<?= $custom_fields->type; ?>"
                        data-multiple-step-id='<?= $custom_fields->multiple_step_id ?>' 
                        data-max_multiple="<?= $custom_fields->max_multiple; ?>"
                    >
                    Add New
                    </a>
                </div>
                <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id ?>" style="display:none;">
            <?php } ?>
        <?php else : ?>
            <?php
            $display_upload = '';
            $hide = '';

            if ($custom_fields->read_only == true && is_grantee()) {
                $display_upload = 'none';
                // $hide = 'hide';
            }
            $filename = get_filename_submission($custom_fields);
            $strlen = $filename ? strlen($filename) : 0;
            $name_file = $filename;
            if ($strlen > 15) {
                $name_file = substr($filename, 0, 15) . '....';
            }
            $fileurl = get_fileurl_sumbission($custom_fields);
            ?>
            <?php if ($file == 3 || $data_custom_fields[$key_fields + 1]->type == 'file') {
                $file = 0;
                $row = "";
                $exitrow = "";
            } else {
                // $row = "<div class='row form-group multiple-cf-$custom_fields->id " . ( $file < 3 && $file != 1 ? 'p-4' : '' ) . "'>";
                // $exitrow = "</div>";
            } ?>
            <?= $row; ?>
            <div class="wrap-file-step-<?= $custom_fields->id ?>" style="<?= $custom_fields->is_row ? '' : '' ?>;">
                <div class="doc-section-item" id="doc-2">
                    <div class="sub-item">
                        <div class="item-sub">
                            <div class="doc-label"><?= get_label_form($custom_fields) ?></div>
                            <!-- DESCRIPTION -->
                            <?php if ($custom_fields->description_file) : ?>
                                <div class="doc-hint-box">
                                    <?= $custom_fields->description_file ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- ITEM BAR -->
                            <div class="upload-bar uploaded">
                                <!-- for preview and upload from admin readonly wiht no uploaded files -->
                                <?php if ($custom_fields->read_only && empty($custom_fields->file)) : ?>
                                    <?php 
                                        $hide_unuploaded = '';
                                        if (empty($custom_fields->value_custom_fields)) {
                                            $fileurl = 'assets/images/icons/add-file.png';
                                            $hide_unuploaded = 'hide';
                                        }
                                    ?>

                                    <div class="bar-left">
                                        <?php if(empty($custom_fields->value_custom_fields)) : ?>
                                            <svg class="icon-svg" viewBox="0 0 24 24" style="color: #94a3b8; stroke-width: 1.5;">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="17 8 12 3 7 8"></polyline>
                                                <line x1="12" y1="3" x2="12" y2="15"></line>
                                            </svg>
                                            <div>
                                                <span style="color: #64748b; font-size: 13px;">No file selected yet...</span>
                                            </div>
                                        <?php else : ?>
                                            <svg class="icon-svg file-icon" viewBox="0 0 24 24">
                                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                                <polyline points="13 2 13 9 20 9"></polyline>
                                            </svg>
                                            <div>
                                                <span class="file-name-text"><?= file_name($fileurl) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="bar-right">
                                        <a href="<?= $custom_fields->value_custom_fields ? base_url($fileurl) : 'javascript:;' ?>" download title="Click to download" class="btn-download<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?> action-icon-btn primary <?php echo $hide_unuploaded; ?>">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                        <a href="<?= $custom_fields->value_custom_fields ? base_url($fileurl) : 'javascript:;' ?>" class="fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                        <a href="javascript:;" onclick="del_file(this, 'img_photo', '<?= strip_tags($custom_fields->name) ?>', <?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>, <?= $custom_fields->submission_id ?>)" class="action-icon-btn danger btn-delete<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?> <?php echo $hide_unuploaded; ?> <?= $display ?>" style="display: <?= $display_upload ?>">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                        <a href="javascript:;" id="my_file_<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>" style="color: white;" class="btn btn-primary upload-button text-white <?php echo is_grantee() ? 'hide' : ''; ?>" data-file-value="my_file_<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>">Upload</a>
                                    </div>
                                <?php else : ?>
                                    <div class="bar-left">
                                        <?php if ($fileurl)  : ?>
                                            <svg class="icon-svg file-icon" viewBox="0 0 24 24">
                                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                                <polyline points="13 2 13 9 20 9"></polyline>
                                            </svg>
                                            <div>
                                                <span class="file-name-text"><?= $filename ?></span>
                                            </div>
                                        <?php else : ?>
                                            <svg class="icon-svg" viewBox="0 0 24 24" style="color: #94a3b8; stroke-width: 1.5;">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="17 8 12 3 7 8"></polyline>
                                                <line x1="12" y1="3" x2="12" y2="15"></line>
                                            </svg>
                                            <div>
                                                <span style="color: #64748b; font-size: 13px;">No file selected yet...</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="bar-right">
                                        <?php if ($fileurl)  : ?>
                                            <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="action-icon-btn primary btn-download btn-download<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                            <a href="<?= base_url($fileurl) ?>" class="fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                                <i class="fa fa-eye fa-fw"></i>
                                            </a>
                                            <a href="javascript:;" onclick="del_file(this, 'img_photo', '<?= strip_tags($custom_fields->name) ?>', <?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>, <?= $custom_fields->submission_id ?>)" class="action-icon-btn danger btn-delete<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?> <?php echo $hide_unuploaded; ?> <?= $display ?>" style="display: <?= $display_upload ?>">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                        <?php else: ?>
                                            <?php if ($disabled == '') { ?>
                                                <a href="javascript:;" download title="Click to download" class="hide btn action-icon-btn primary btn-download btn-download<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>">
                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                </a>
                                                <a href="javascript:;" class="hide fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                                    <i class="fa fa-eye fa-fw"></i>
                                                </a>
                                                <a href="javascript:;" onclick="del_file(this, 'img_photo', '<?= strip_tags($custom_fields->name) ?>', <?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>, 'subid')" class="hide action-icon-btn danger btn-delete<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?> <?= $display ?>" style="display: <?= $display_upload ?>">
                                                    <i class="fa fa-trash fa-fw text-danger"></i>
                                                </a>
                                            <?php } ?>
                                        <?php endif; ?>
                                        <a href="javascript:;" id="my_file_<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>" class="btn btn-primary upload-button <?= $display ?>" data-file-value="my_file_<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>" style ="color:#fff;display:<?= $display_upload ?>">Upload</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($custom_fields->read_only && empty($custom_fields->file)) : ?>
                                <?php if (is_grantee()) { ?>
                                    <?php if(empty($custom_fields->value_custom_fields)) { ?>
                                        <div class="file-limit-hint">This file will be uploaded soon by the administrator.</small>
                                    <?php } else { ?>
                                        <div class="file-limit-hint">This file has been uploaded by the administrator</small>
                                    <?php } ?>
                                <?php } ?>
                            <?php else : ?>
                                <div class="file-limit-hint">File Size Max 5MB | Supported File: Jpg, Png, PDF</div>
                            <?php endif; ?>
                            <?php 
                            if($custom_fields->is_required){
                                $required = 'required';
                                if($fileurl != ''){
                                    $required = '';
                                }
                            }else{
                                $required = '';
                            }
                            ?>
                            <input 
                                onchange="show_preview(this, <?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>);" 
                                type="file" 
                                data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' 
                                data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' 
                                data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' 
                                data-step='<?= $custom_fields->user_grantee_step_id; ?>' 
                                data-id='<?= $custom_fields->id; ?>' 
                                data-period-id='<?= $custom_fields->period_id ?>' 
                                data-multiple-id='<?= $custom_fields->multiple_file_id ?>' 
                                data-multiple-step-id='<?= $custom_fields->multiple_step_id ?>' 
                                class="choosefile my_file_<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?> autosave" 
                                style="display: none;" <?= $required ?>
                                data-upload-id="<?= $custom_fields->id.$custom_fields->user_grantee_step_id.$custom_fields->multiple_step_id.$custom_fields->multiple_file_id ?>"
                            >
                        </div>

                        <?php if($custom_fields->is_multiple) { ?>
                            <?php 
                                unset($custom_fields->multiple_file[0]); 
                                foreach ($custom_fields->multiple_file as $kmf => $mf) { ?>
                                <?php
                                    $filename_multiple = get_filename_submission_multiple($mf);
                                    $strlen = strlen($filename_multiple);
                                    $name_file_multiple = $filename_multiple;
                                    if ($strlen > 15) {
                                        $name_file_multiple = substr($filename_multiple, 0, 15) . '....';
                                    }
                                    $fileurl = get_fileurl_sumbission_multiple($mf);
                                ?>
                                <div class="item-sub multiple-item mt-5 multiple-cf-<?= $custom_fields->id ?>">
                                    <div class="upload-bar uploaded">
                                        <div class="bar-left">
                                            <?php if ($fileurl)  : ?>
                                                <svg class="icon-svg file-icon" viewBox="0 0 24 24">
                                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                                    <polyline points="13 2 13 9 20 9"></polyline>
                                                </svg>
                                                <div>
                                                    <span class="file-name-text"><?= $filename_multiple ?></span>
                                                </div>
                                            <?php else : ?>
                                                <svg class="icon-svg" viewBox="0 0 24 24" style="color: #94a3b8; stroke-width: 1.5;">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="17 8 12 3 7 8"></polyline>
                                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                                </svg>
                                                <div>
                                                    <span style="color: #64748b; font-size: 13px;">No file selected yet...</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="bar-right">
                                            <?php if ($fileurl)  : ?>
                                                <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="action-icon-btn primary btn-download btn-download<?= $custom_fields->id . $mf->id ?>">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                                <a href="<?= base_url($fileurl) ?>" class="fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                                    <i class="fa fa-eye fa-fw"></i>
                                                </a>
                                            <?php else: ?>
                                                <?php if ($disabled == '') { ?>
                                                    <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="hide btn action-icon-btn primary btn-download btn-download<?= $custom_fields->id . $mf->id ?>">
                                                        <i class="fa fa-download fa-fw"></i>
                                                    </a>
                                                    <a href="javascript:;" class="hide fileview lightbox <?php echo $hide_unuploaded; ?> action-icon-btn" title="Preview File">
                                                        <i class="fa fa-eye fa-fw"></i>
                                                    </a>
                                                <?php } ?>
                                            <?php endif; ?>
                                            <?php if (!is_grantee() || (is_grantee() && !$custom_fields->read_only)) : ?>
                                                <a href="javascript:;" data-multiple-id="<?= $mf->id ?>" onclick="del_multiple(this, 'multiple-item')" class="action-icon-btn danger btn-delete<?= $custom_fields->id . $mf->id ?> <?= $display ?>" style="display: <?= $display_upload ?>" title="Delete">
                                                    <i class="fa fa-trash fa-fw"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="javascript:;" id="my_file_<?= $custom_fields->id . $mf->id ?>" class="btn btn-primary upload-button <?= $display ?>" data-file-value="my_file_<?= $custom_fields->id . $mf->id ?>" style ="color:#fff;display:<?= $display_upload ?>">Upload</a>
                                        </div>
                                    </div>
                                    <?php if ($custom_fields->read_only && empty($custom_fields->file)) : ?>
                                        <?php if (is_grantee()) { ?>
                                            <?php if(!$fileurl) { ?>
                                                <small class="file-limit-hint">This file will be uploaded soon by the administrator.</small>
                                            <?php } else { ?>
                                                <small class="file-limit-hint">This file has been uploaded by the administrator</small>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php else : ?>
                                        <small class="file-limit-hint">File Size Max 5MB | Supported File: Jpg, Png, PDF</small>
                                    <?php endif; ?>
                                    <?php
                                    if ($custom_fields->is_required) {
                                        $required = 'required';
                                        if ($fileurl != '') {
                                            $required = '';
                                        }
                                    } else {
                                        $required = '';
                                    }
                                    ?>
                                    <input 
                                        onchange="show_preview(this, <?= $custom_fields->id . $mf->id ?>);" 
                                        type="file" 
                                        data-multiple-id='<?= $mf->id ?>'                                                                      
                                        data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' 
                                        data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' 
                                        data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' 
                                        data-step='<?= $custom_fields->user_grantee_step_id; ?>' 
                                        data-id='<?= $custom_fields->id; ?>' 
                                        data-period-id='<?= $custom_fields->period_id ?>' 
                                        data-type-group='file'
                                        data-upload-id='<?= $custom_fields->id . $mf->id ?>'
                                        data-multiple-step-id='<?= $custom_fields->multiple_step_id ?>' 
                                        class="choosefile my_file_<?= $custom_fields->id . $mf->id ?> autosave" 
                                        style="display: none;" <?= $required ?>>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <?php if($custom_fields->is_multiple) { ?>
                    <a 
                        href="javascript:;" 
                        onclick="add_more_submission(this, true)" 
                        class="btn btn-info mt-2 <?= $display ?>" 
                        style ="color:#fff;" 
                        data-category-id="<?= $custom_fields->user_grantee_category_id; ?>" 
                        data-category-type="<?= $custom_fields->user_grantee_category_type; ?>" 
                        data-grant-id="<?= $custom_fields->user_grantee_grant_id; ?>" 
                        data-step="<?= $custom_fields->user_grantee_step_id; ?>" 
                        data-label="<?= strip_tags($custom_fields->name); ?>"
                        data-period-id="<?= $custom_fields->period_id ?>"
                        data-multiple-step-id='<?= $custom_fields->multiple_step_id ?>' 
                        data-id="<?= $custom_fields->id; ?>"
                        data-type="<?= $custom_fields->type; ?>"
                    >
                    <i class="fa fa-plus fa-fw"></i>
                    </a>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id ?>" style="display:none;">
                    <?php } ?>
                </div>
            </div> <!-- endwrap -->
            <?= $exitrow; ?>

        <?php $file++;
        endif; ?>
    <?php } ?>
</div>
</div>