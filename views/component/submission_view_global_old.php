<style>
    .span-note {
        word-wrap: break-word;
        font-size: 12px !important; 
        text-align: justify;
        word-wrap: break-word;
    }

    .submission-description {
        display: flex;
        flex-direction: column;
    }

    .min-height-description-us{
        min-height: 120px;
    }

    .col-style-us {
        display: flex;
        flex-direction: column;
        padding-bottom: 10px;
        position: relative;
        margin-bottom:40px;
    }

    .col-style-us::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 15px;
        right: 15px;
        height: 1px;
        background: #ccc;
    }

    .col-style-us > p.text-danger.text-required {
        position: absolute;
        bottom: 15px;
    }

    .note-file-us {
        height: auto;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .text-required {
        position: absolute;
        font-size: 10pt;
        color: orangered;
        font-weight: bold;
    }

    .text-hint {
        position: absolute;
        font-size: 10pt;
        color: orangered;
        font-weight: bold;
    }

    .tooltip-inner{
        word-wrap: break-word !important;
    }
</style>
<?php if($show_note_period){ ?>
    <div class="alert alert-danger mt-4 text-center">
    The registration for this program period has been closed. You can check the programs we are currently opening <a href="<?= base_url('grantee/grants') ?>">here</a>.
    </div>
<?php } ?>
<div class="row">
    <div class="tabs">
        <?php echo $status_info; ?>
        
        <?php
            $category_status = get_row_db('am_grantee_grant_category_status', ['category_id' => $category->id, 'grantee_grant_id' => $grantee_grant->id]);
            if ($category_status) {
                $note_document = $category_status->note;
            }
    
            if (!is_admin()) {
                $document_status = null;
                if ($category_status) {
                    $document_status = $category_status->status;
                } else {
                    if (in_array($category->name, ['Grant Information', 'Grant Profile'])){
                        $document_status = $grantee_grant->grant_document_status;
                    } elseif (in_array($category->name, ['Permit Application','Pre Arrival Documents','Pre-Arrival Documents'])) {
                        $document_status = $grantee_grant->pre_arrival_document_status;
                    } elseif (in_array($category->name, ['Indonesian Host Information'])) {
                        $document_status = $grantee_grant->indonesian_host_information_status;
                    }
                }
                if ($document_status == DOCUMENT_NEED_REVISION && !empty($note_document)) {          
        ?>  
            <div class="alert alert-warning mt-4">
                <b><i class="fa fa-info-circle"></i> Note : <?php echo $note_document; ?></b>
            </div>
        <?php 
                }
            }  
        ?>
        
        <ul>
            <?php foreach ($data_step as $index => $step): ?>
                    <li>
                        <a aria-expanded="true" data-toggle="tab" href="#step_<?= $step->id ?>" onclick="navigate_tab(<?= $step->id ?>)"><?= $step->label; ?></a>
                    </li>
            <?php endforeach; ?>
        </ul>
        <div class="row">
            <form action="" id="form-submission" method="POST">
                <input type="hidden" name="is_form" value="is_form">
                <input type="hidden" id="current_active_grant" value="<?= $current_active_grant ?>">
                <div class="tab-content">
                    <?php foreach ($data_step as $index => $step):
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
                                        <?php if ($step->is_letter_of_reference && (!$step->not_show_grantee || $is_admin)) { ?>
                                        <div class="row form-group mt-4">
                                            <div class="col-lg-4">
                                                <label>Letter of Reference</label>
                                                <div class="row"> 
                                                <div class="col-lg-8">
                                                    <img height="100" width="100" style="object-fit:contain;" src="<?php echo get_preview($grantee_period->letter_of_reference); ?>">
                                                    <br />
                                                    <!-- <p class="filename" style="font-size:16px"><?= $filename ?></p> -->
                                                    <a href="<?= base_url($grantee_period->letter_of_reference) ?>" download class="btn btn-info mt-3" style="color:#fff;" target="_blank">
                                                        <i class="fa fa-download fa-fw"></i> Download
                                                    </a>
                                                    <hr>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="panel-body multiple-step-<?= $step->id ?>">
                                        <!-- ENDPRE DEPATURE ORIENTATION -->
                                        <?php $file = 0; ?>
                                        <?php $row = "<div class='row form-group'>"; ?>
                                        <?php $exitrow = "</div>"; ?>
                                        <?php 
                                            foreach ($step->custom_fields as $key_fields => $custom_fields) { 
                                            if(($custom_fields->not_show_grantee && !$is_admin)) { continue; }
                                            if(in_array($custom_fields->type,['radio group', 'checkbox'])){
                                                $custom_fields->user_grantee_id = $userGranteeId;
                                                $custom_fields->grantee_grant_id = $granteeGrantId;
                                            }
                                        ?>
                                                <?php if ($custom_fields->type == 'table schedule'): ?>

                                                    <script>
                                                        window.tableScheduleData = window.tableScheduleData || {};
                                                        window.tableScheduleData[<?= $custom_fields->id ?>] = <?= json_encode($custom_fields->value_custom_fields ?? []) ?>;

                                                        window.tableScheduleConfig = window.tableScheduleConfig || {};
                                                        window.tableScheduleConfig[<?= $custom_fields->id ?>] = <?= json_encode($custom_fields->sub_element) ?>;
                                                    </script>
                                                    

                                                <?php endif; ?>
                                                <!-- template for others instead file template -->
                                                <?php if ($custom_fields->type != 'file'): ?>
                                                    <div class="wrap-file-<?= $custom_fields->id ?>"
                                                         data-conditional-parent-id="<?= (int)$custom_fields->conditional_parent_id ?? '' ?>"
                                                         data-conditional-parent-value="<?= htmlspecialchars($custom_fields->conditional_parent_value ?? '', ENT_QUOTES) ?>"> 
                                                        <div class="row form-group multiple-cf-<?= $custom_fields->id ?> <?php echo (int) $custom_fields->parent_id > 0 && $custom_fields->is_advanced_checkbox ? 'hide ml-4' : ''; ?>" data-parent="<?php echo (int) $custom_fields->parent_id; ?>">
                                                            <?php if ($custom_fields->type == 'separator'): ?>
                                                                <?php if ((int) $custom_fields->parent_section_id > 0 ) { ?>
                                                                    <div class="col-lg-12 text-left">
                                                                        <?= url_text($custom_fields->name) ?>
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
                                                                        <b><?= url_text($custom_fields->name) ?></b>
                                                                        <?php if ($custom_fields->description_file != '') { ?>
                                                                            <div class="mt-2">
                                                                                <span style="font-size: 12px !important; margin-left: 15px;"><?= $custom_fields->description_file ?></span>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php elseif ($custom_fields->type == 'highlight'): ?>
                                                                <hr style="border-top:2px solid #eee" class="p-0 mt-1 mb-1" />
                                                            <?php else: ?>
                                                                    <div style="display:flex;<?= in_array($custom_fields->type, ['element group', 'table schedule', 'education group']) ? 'flex-direction: column;' : 'flex-direction: column;' ?>" class="<?= in_array($custom_fields->type, ['element group', 'table schedule', 'education group']) || $custom_fields->is_row  ? 'col-md-12' : 'col-md-4' ?> <?php echo (int) $custom_fields->parent_id > 0 && $custom_fields->is_advanced_checkbox ? 'ml-4' : ''; ?> text-left font-weight-bold <?php echo $custom_fields->hide_question_label ? 'hide' : ''; ?>">
                                                                        <?php if(in_array($custom_fields->type, ['element group', 'table schedule', 'education group'])) { ?>
                                                                            <b><?= get_label_form($custom_fields) ?></b>
                                                                            <div style="margin-top:-15px;">
                                                                                <span class="span-note" style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                                                            </div>
                                                                        <?php } else {?>
                                                                            <?= get_label_form($custom_fields) ?>
                                                                            <?php if (in_array($custom_fields->type, ['text']) && $custom_fields->under_question) { ?>
                                                                                <div>
                                                                                    <span class="span-note" style="font-size: 12px !important; text-align: justify;"><?= $custom_fields->description_file ?></span>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </div>
                                                            <?php endif; ?>
                                                            <div class="<?php echo in_array($custom_fields->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                <?= get_component($custom_fields, $disabled, $custom_fields->value_custom_fields); ?>
                                                            </div>
                                                            <?php if ($custom_fields->description_file != '' && !in_array($custom_fields->type, ['separator', 'element group', 'table schedule', 'education group']) && !$custom_fields->under_question) { ?>
                                                                <div class="<?= $activeCountry == AMERICAN_DATABASE ? 'col-lg-4' : 'col-lg-12' ?> mt-2">
                                                                    <span class="span-note" style="font-size: 12px !important; text-align: justify;"><?= $custom_fields->description_file ?></span>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        
                                                        <?php if ($custom_fields->is_multiple && !in_array($custom_fields->type, ['radio group', 'education group'])) { ?>
                                                            <?php foreach ($custom_fields->multiple_file as $kmf => $mf) { ?>
                                                                
                                                                <div class="multiple-item multiple-cf-<?= $custom_fields->id ?>" style="margin-left: -15px;">
                                                                <div class="<?= $custom_fields->type == 'element group' || $custom_fields->type == 'table schedule' ? 'col-md-' : 'col-md-4' ?> text-left font-weight-bold">
                                                                    <b><?= url_text($mf->property_name); ?></b>
                                                                    <a href="javascript:;" data-multiple-id="<?= $mf->id ?>" onclick="del_multiple(this, 'multiple-item')" class="btn btn-danger mt-2 pull-right" style="color:white;"><i class="fa fa-trash fa-fw"></i></a>
                                                                    <div style="margin-top:10px;">
                                                                        <span class="span-note" style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                                                    </div>
                                                                </div>
                                        
                                                                <div class="<?php echo in_array($custom_fields->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', NULL]) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                    <!-- dapatkan data value dari customfield multiple -->
                                                                    <?php 
                                                                    $condition_custom_fields_value = [
                                                                        'user_grantee_custom_fields_id' => $custom_fields->id,
                                                                        'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                        'user_grantee_id' => $userGranteeId,
                                                                        'user_grantee_period_id' => $custom_fields->period_id,
                                                                        'multiple_file_id' => $mf->id,
                                                                        'grantee_grant_id' => $granteeGrantId
                                                                    ];
                                                                    $value_custom_fields = get_all_db('am_user_grantee_submission', $condition_custom_fields_value);
                                                                    $sub_element = "";
                                                                    if ($custom_fields->type == 'radio group' || $custom_fields->type == 'element group' || $custom_fields->type == 'table schedule'){
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
                                                                data-max_multiple="<?= $custom_fields->max_multiple; ?>"
                                                            >
                                                            Add New
                                                            </a>
                                                        </div>
                                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id ?>" style="display:none;">
                                                    <?php } ?>
                                                <?php else: ?>
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
                                                        <?php 
                                                        if ($step->custom_fields[$key_fields + 1]->type == 'file') {
                                                            $file = 0;
                                                            $row = "";
                                                            $exitrow = "";
                                                            $style = "margin-left:-10px;";
                                                            $mr = "";
                                                        } else {
                                                            $row = "<div class='row form-group " . ($file < 3 && $file != 1 ? '' : '') . "'>";
                                                            $exitrow = "</div>";
                                                            $style = "";
                                                            $mr = "margin-right:25px;";
                                                        } ?>
                                                        
                                                        <?= $row; ?>
                                                        <div class="wrap-file-<?= $custom_fields->id ?>"
                                                            data-conditional-parent-id="<?= (int)$custom_fields->conditional_parent_id ?? '' ?>"
                                                            data-conditional-parent-value="<?= htmlspecialchars($custom_fields->conditional_parent_value ?? '', ENT_QUOTES) ?>"> 
                                                            <div class="<?= $custom_fields->is_row ? 'col-lg-12 is_row_class' : 'col-lg-4' ?> <?= $activeCountry == AMERICAN_DATABASE ? 'col-style-us' : '' ?>" style="<?= $style ?>">
                                                                <!-- <label style="font-weight:100;<?= $activeCountry == AMERICAN_DATABASE ? 'min-height: 45px;' : '' ?>"><?= url_text($custom_fields->name) ?> <?= label_required($custom_fields->is_required) ?></label>
                                                                <div 
                                                                    style="margin-top: -25px;<?= $mr ?>" 
                                                                    class="<?= $activeCountry == AMERICAN_DATABASE ? 'note-file-us' : '' ?>" 
                                                                    <?php if(text_length($custom_fields->description_file) > 300) { ?>
                                                                    data-toggle="tooltip" 
                                                                    data-placement="right" 
                                                                    title="<?= !empty($custom_fields->description_file) ? strip_tags($custom_fields->description_file) : '&nbsp;' ?>"
                                                                    <?php } ?>
                                                                >
                                                                    <span class="span-note"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                </div> -->
                                                                <div class="submission-description <?= $activeCountry == AMERICAN_DATABASE ? 'min-height-description-us' : '' ?>">
                                                                    <label style="font-weight:400;display:flex;"><?= strip_tags(url_text($custom_fields->name)) ?> <?= label_required($custom_fields->is_required) ?></label>
                                                                    <?php if ($custom_fields->file) { ?>
                                                                        <div class="mb-2">
                                                                            <?php
                                                                                $file_url = site_url($custom_fields->file);
                                                                                $applicant_file = get_row_db('am_user_grantee_custom_field_files', [
                                                                                    'user_grantee_custom_field_id' => $custom_fields->id,
                                                                                    'user_grantee_grant_id' => $grantee_grant->id,
                                                                                    'user_grantee_id' => $grantee_grant->user_grantee_id
                                                                                ]);
                                                                                
                                                                                if ($applicant_file) {
                                                                                    $file_url = site_url() . $applicant_file->filepath;
                                                                                }
                                                                                
                                                                            ?>
                                                                            
                                                                            <?php if ((bool) $custom_fields->read_only == 1) { ?>
                                                                                <?php
                                                                                $url = site_url($custom_fields->file);
                                                                                $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                                                                $file_extendsions = strtolower(pathinfo($custom_fields->file, PATHINFO_EXTENSION));

                                                                                if (in_array($file_extendsions, $image_extensions)) {
                                                                                    $url = site_url('assets/fileicons/image.png?v=' . VERSION);
                                                                                } else {
                                                                                    switch ($file_extendsions) {
                                                                                        case 'pdf':
                                                                                            $url = site_url('assets/fileicons/pdf.png?v=' . VERSION);
                                                                                            break;
                                                                                        case 'xls':
                                                                                        case 'xlsx':
                                                                                            $url = site_url('assets/fileicons/excel.png?v=' . VERSION);
                                                                                            break;
                                                                                        case 'doc':
                                                                                        case 'docx':
                                                                                            $url = site_url('assets/fileicons/doc.png?v=' . VERSION);
                                                                                            break;
                                                                                        case 'zip':
                                                                                            $url = site_url('assets/fileicons/zip.png?v=' . VERSION);
                                                                                            break;
                                                                                        default:
                                                                                            $url = site_url('assets/fileicons/file.png?=' . VERSION);
                                                                                            break;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <?php if ($custom_fields->file) { ?>
                                                                                    <div class="pointer mb-2">
                                                                                        <img src="<?php echo $url; ?>" style="height:100px; margin-left:-5px; margin-top:100px;">
                                                                                    </div>
                                                                                <?php } ?>
                                                                                <a href="<?php echo $file_url; ?>" class="btn btn-info btn-sm mt-4 mb-4 button-download-file-guide-<?php echo $custom_fields->id; ?>" target="_blank" download style="color: white;"><i class="fa fa-download"></i> Download Document</a>
                                                                            <?php } else { ?>
                                                                                <a href="<?php echo $file_url; ?>" class="btn btn-info btn-sm button-download-file-guide-<?php echo $custom_fields->id; ?>" target="_blank" download style="color: white;"><i class="fa fa-download"></i> Download Document</a>
                                                                            <?php } ?>
                                                                            <?php if (!is_grantee()) { ?>
                                                                                <label class="btn btn-primary btn-sm button-upload-guide-file-applicant button-upload-guide-<?php echo $custom_fields->id; ?>" for="file-guide-applicant-<?php echo $custom_fields->id; ?>"><i class="fa fa-upload"></i></label> 
                                                                                <input class="upload-guide-file-applicant hide" type="file" data-user_grantee_custom_field_id="<?php echo $custom_fields->id; ?>" data-user_grantee_id="<?php echo $grantee_grant->user_grantee_id; ?>" data-user_grantee_grant_id="<?php echo $grantee_grant->id; ?>" id="file-guide-applicant-<?php echo $custom_fields->id; ?>">
                                                                            <?php } ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($custom_fields->description_file) { ?>
                                                                        <div
                                                                            class="<?= $activeCountry == AMERICAN_DATABASE ? 'note-file-us' : '' ?>" 
                                                                            <?php if(text_length($custom_fields->description_file) > 300) { ?>
                                                                                data-toggle="tooltip" 
                                                                                data-placement="right" 
                                                                                title="<?= !empty($custom_fields->description_file) ? strip_tags($custom_fields->description_file) : '&nbsp;' ?>"
                                                                            <?php } ?>
                                                                            >
                                                                            <span class="span-note"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>

                                                                <!-- for preview and upload from admin readonly wiht no uploaded files -->
                                                                <?php if ($custom_fields->read_only && empty($custom_fields->file)) { ?>
                                                                    <?php 
                                                                        $hide_unuploaded = '';
                                                                        if (empty($custom_fields->value_custom_fields)) {
                                                                            $fileurl = 'assets/images/icons/add-file.png';
                                                                            $hide_unuploaded = 'hide';
                                                                        }
                                                                    ?>
                                                                    <div id="preview_section_<?php echo $custom_fields->id; ?>" style="position:relative; width:100px;">
                                                                        <img height="125" width="100" style="margin-top:16px; object-fit:contain;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                        <a href="javascript:;" onclick="del_file(this, 'img_photo', '<?= $custom_fields->name ?>', <?= $custom_fields->id ?>, <?= $custom_fields->submission_id ?>)" class="btn btn-danger btn-xs <?php echo $hide_unuploaded; ?> <?= $display ?>" style="position:absolute; top:25px;display: <?= $display_upload ?>">
                                                                            <i class="fa fa-trash fa-fw text-white"></i>
                                                                        </a>
                                                                        <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="btn btn-primary btn-xs <?php echo $hide_unuploaded; ?>" style="position:absolute; top:0;">
                                                                            <i class="fa fa-download fa-fw text-white"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <!-- gap if file is not uploaded yet -->
                                                                            <?php if (is_grantee() && $hide_unuploaded == 'hide') { ?>
                                                                                <div class="mt-2">&nbsp;</div>
                                                                            <?php } ?>
                                                                            <a href="javascript:;" id="my_file_<?= $custom_fields->id ?>" style="color: white;" class="btn btn-primary upload-button text-white <?php echo is_grantee() ? 'hide' : ''; ?>" data-file-value="my_file_<?= $custom_fields->id ?>">Upload</a>
                                                                            <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox <?php echo $hide_unuploaded; ?>" style="color:white;"><i class="fa fa-eye fa-fw"></i> Preview</a>
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
                                                                                    data-max_multiple="<?= $custom_fields->max_multiple; ?>"
                                                                                >
                                                                                <i class="fa fa-plus fa-fw"></i>
                                                                                </a>
                                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id ?>" style="display:none;">
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php if (is_grantee()) { ?>
                                                                    <?php if(empty($custom_fields->value_custom_fields)) { ?>
                                                                        <small class="file-for-testing">This file will be uploaded soon by the administrator.</small>
                                                                    <?php } else { ?>
                                                                        <small class="file-for-testing">This file has been uploaded by the administrator</small>
                                                                    <?php } ?>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php if (!empty($custom_fields->file) && !is_grantee() && (bool) $custom_fields->read_only) { 
                                                                        $hide = 'hide';
                                                                    } ?>
                                                                    <div class="row <?php echo $hide; ?>">
                                                                        
                                                                        <div class="col-lg-6" style="height: 150px;">
                                                                            <?php if ($fileurl)  { ?>
                                                                                    <div id="preview_section_<?php echo $custom_fields->id; ?>" style="position:relative; width:100px;"> 
                                                                                        <img height="100" width="100" style="margin-top:16px; object-fit:contain;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo get_preview($fileurl); ?>">
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
                                                                                                        <img onclick="add_file('my_file_' + <?= $custom_fields->id ?>);" data-trigger="my_file_<?= $custom_fields->id ?>" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
                                                                                                <?php } else { ?>
                                                                                                        <img data-trigger="my_file_<?= $custom_fields->id ?>" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
                                                                                                <?php } ?>
                                                                                                <a href="javascript:;" onclick="del_file(this, 'img_photo', '<?= $custom_fields->name ?>', <?= $custom_fields->id ?>, 'subid')" class="hide btn btn-danger btn-xs btn-delete<?= $custom_fields->id ?> <?= $display ?>" style="position:absolute; top:25px;display: <?= $display_upload ?>">
                                                                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                                                                </a>
                                                                                                <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="hide btn btn-primary btn-xs btn-download<?= $custom_fields->id ?>" style="position:absolute; top:0;">
                                                                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                                                                </a>
                                                                                        <?php } else { ?>
                                                                                                <img data-trigger="my_file_<?= $custom_fields->id ?>" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
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
                                                                    <div class="row <?php echo $hide; ?>">
                                                                        <div class="col-md-12" style="min-height: 35px;">
                                                                        <a href="javascript:;" id="my_file_<?= $custom_fields->id ?>" class="btn btn-primary upload-button <?= $display ?>" data-file-value="my_file_<?= $custom_fields->id ?>" style ="color:#fff;display:<?= $display_upload ?>">Upload</a>
                                                                         <a href="<?= $fileurl ? base_url($fileurl) : 'javascript:;' ?>" class="btn btn-warning fileview lightbox <?= $fileurl ? '' : 'disabled' ?>" style ="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
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
                                                                                data-max_multiple="<?= $custom_fields->max_multiple; ?>"
                                                                            >
                                                                            <i class="fa fa-plus fa-fw"></i>
                                                                            </a>
                                                                            <img src="<?php echo base_url() ?>/img/loading.gif" class="add-multiple-file-spinner-<?= $custom_fields->id ?>" style="display:none;">
                                                                        <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                
                                                                <small class="file-for-testing <?php echo $hide; ?>">File Size Max 5MB | Supported File: Jpg, Png, PDF</small>
                                                                <input onchange="show_preview(this, <?= $custom_fields->id ?>);" type="file" data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' data-step='<?= $custom_fields->user_grantee_step_id; ?>' data-id='<?= $custom_fields->id; ?>' data-period-id='<?= $custom_fields->period_id ?>' class="choosefile my_file_<?= $custom_fields->id ?>" style="display: none;" <?= $required ?>>
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
                                                                            <div class="<?= $custom_fields->is_row ? 'col-lg-12 is_row_class' : 'col-lg-4' ?> <?= $activeCountry == AMERICAN_DATABASE ? 'col-style-us' : '' ?> multiple-item multiple-cf-<?= $custom_fields->id ?>">
                                                                                <!-- <label style="<?= $activeCountry == AMERICAN_DATABASE ? 'min-height: 100px;' : 'min-height: 75px;' ?>;font-weight:100"><?= url_text($mf->property_name); ?></label> -->
                                                                                <!-- <div 
                                                                                    style="margin-top:-80px;"
                                                                                        class="<?= $activeCountry == AMERICAN_DATABASE ? 'note-file-us' : '' ?>" 
                                                                                       <?php if(text_length($custom_fields->description_file) > 300) { ?>
                                                                                    data-toggle="tooltip" 
                                                                                    data-placement="right" 
                                                                                    title="<?= !empty($custom_fields->description_file) ? strip_tags($custom_fields->description_file) : '&nbsp;' ?>"
                                                                                    <?php } ?>
                                                                                >   
                                                                                    <span class="span-note" style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                                </div> -->
                                                                                <div class="submission-description <?= $activeCountry == AMERICAN_DATABASE ? 'min-height-description-us' : '' ?>">
                                                                                    <label style="<?= $activeCountry == AMERICAN_DATABASE ? '' : 'min-height: 75px;' ?>;font-weight:400;display:flex;"><?= strip_tags(url_text($mf->property_name)); ?></label>
                                                                                    <?php if ($custom_fields->file) { ?>
                                                                                        <div class="mb-2">
                                                                                            <?php
                                                                                                $file_url = site_url($custom_fields->file);

                                                                                                $applicant_file = get_row_db('am_user_grantee_custom_field_files', [
                                                                                                    'user_grantee_custom_field_id' => $custom_fields->id,
                                                                                                    'user_grantee_grant_id' => $grantee_grant->id,
                                                                                                    'user_grantee_id' => $grantee_grant->user_grantee_id
                                                                                                ]);

                                                                                                if ($applicant_file) {
                                                                                                    $file_url = site_url() . $applicant_file->filepath;
                                                                                                }
                                                                                            ?>
                                                                                            <a href="<?php echo $file_url; ?>" class="btn btn-info btn-sm button-download-file-guide-<?php echo $custom_fields->id; ?>" target="_blank" style="color: white;"><i class="fa fa-download"></i> Download Document</a>
                                                                                            <?php if (!is_grantee()) { ?>
                                                                                                <label class="btn btn-primary btn-sm button-upload-guide-file-applicant button-upload-guide-<?php echo $custom_fields->id; ?>" for="file-guide-applicant-<?php echo $custom_fields->id; ?>"><i class="fa fa-upload"></i></label> 
                                                                                                <input class="upload-guide-file-applicant hide" type="file" data-user_grantee_custom_field_id="<?php echo $custom_fields->id; ?>" data-user_grantee_id="<?php echo $grantee_grant->user_grantee_id; ?>" data-user_grantee_grant_id="<?php echo $grantee_grant->id; ?>" id="file-guide-applicant-<?php echo $custom_fields->id; ?>">
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <div 
                                                                                        style="margin-top:-20px;"
                                                                                        class="<?= $activeCountry == AMERICAN_DATABASE ? 'note-file-us' : '' ?>" 
                                                                                        <?php if(text_length($custom_fields->description_file) > 300) { ?>
                                                                                        data-toggle="tooltip" 
                                                                                        data-placement="right" 
                                                                                        title="<?= !empty($custom_fields->description_file) ? strip_tags($custom_fields->description_file) : '&nbsp;' ?>"
                                                                                        <?php } ?>
                                                                                    >
                                                                                    
                                                                                    
                                                                                        <span class="span-note" style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                                    </div>
                                                                                </div>
                                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="delete-multiple-spinner-<?= $mf->id ?>" style="display:none;">
                                                                                <div class="row <?php echo $hide; ?>">
                                                                                    <div class="col-lg-6" style="height: 150px;">
                                                                                        <?php if ($fileurl) { ?>
                                                                                                <img height="100" width="100" style="margin-top: 16px; object-fit:contain;" id="preview_image_<?= $custom_fields->id . $mf->id ?>" class="preview_image_<?= $custom_fields->id . $mf->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                                                <a href="<?= base_url($fileurl) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                                                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                                                                </a>
                                                                                        <?php } else { ?>
                                                                                                <div id="preview_section_<?php echo $custom_fields->id . $mf->id; ?>" style="position:relative; width:100px;">
                                                                                                    <img onclick="add_file('my_file_' + <?= $custom_fields->id . $mf->id ?>);" data-trigger="my_file_<?= $custom_fields->id . $mf->id ?>" height="100" style="margin-top: 11px; cursor: pointer;" id="preview_image_<?= $custom_fields->id . $mf->id ?>" class="preview_image_<?= $custom_fields->id . $mf->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
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
                                                                                <div class="row  <?php echo $hide; ?>">
                                                                                    <div class="col-md-12">
                                                                                    <a href="javascript:;" id="my_file_<?= $custom_fields->id . $mf->id ?>" class="btn btn-primary upload-button <?= $display ?>" data-file-value="my_file_<?= $custom_fields->id . $mf->id ?>" style ="color:#fff;">Upload</a>
                                                                                    <a href="<?= $fileurl ? base_url($fileurl) : 'javascript:;' ?>" class="btn btn-warning fileview lightbox <?= $fileurl ? '' : 'disabled' ?>" style ="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                                                    <a href="javascript:;" data-multiple-id="<?= $mf->id ?>" onclick="del_multiple(this, 'multiple-item')" class="btn btn-danger" style="color:white;"><i class="fa fa-trash fa-fw"></i></a>
                                                                                    </div>
                                                                                </div>
                                                                                <small class="file-for-testing <?php echo $hide; ?>">File Size Max 5MB | Supported File: Jpg, Png, PDF</small>
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
                                                            'user_grantee_id' => $userGranteeId,
                                                            'user_grantee_period_id' => $rowscf->period_id,
                                                            // 'multiple_file_id' => $mfs->id,
                                                            'multiple_step_id' => $mfs->id
                                                        ];
                                                        $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_file);
                                                        $arr_value_custom_fields = get_all_db('am_user_grantee_submission', $condition_multiple_file);
                                                        // if type radio group then get sub element 
                                                        $sub_element = "";
                                                        if ($rowscf->type == 'radio group' || $rowscf->type == 'element group' || $rowscf->type == 'table schedule') {
                                                            $sub_element = get_all_db('am_user_grantee_group_element', ['custom_fields_id' => $rowscf->id]);
                                                            $sub_element = array_map(function ($data) use ($arr_value_custom_fields) {
                                                                $get_value = array_filter($arr_value_custom_fields, function ($value) use ($data) {
                                                                    return $value->group_element_id == $data->id;
                                                                });
                                                                $data->value = array_column($get_value, 'value');
                                                                $data->submission_id = array_column($get_value, 'id');
                                                                return $data;
                                                            }, $sub_element);

                                                        }
                                                        $multiple_file = get_row_db('am_user_grantee_multiple_file', ['user_grantee_step_id' => $mfs->id, 'property_name' => $rowscf->name]);
                                                        $rowscf->submission_id = $value_multiple_file->id;
                                                        $rowscf->value_custom_fields = $value_multiple_file->value;
                                                        $rowscf->other_value = $value_multiple_file->other_value;
                                                        $rowscf->multiple_step_id = $mfs->id;
                                                        $rowscf->multiple_file_id = $multiple_file->id;
                                                        $rowscf->sub_element = $sub_element;

                                                        if ($rowscf->is_multiple == true) {
                                                            $multiple_file_for_file = get_all_db('am_user_grantee_multiple_file', [
                                                                'custom_fields_id' => $rowscf->id,
                                                                'grantee_grant_id' => $granteeGrantId,
                                                                'user_grantee_step_id' => $mfs->id,
                                                            ]);
                                                            foreach ($multiple_file_for_file as $kmf => $mf) {
                                                                $condition_multiple_for_file = [
                                                                    'user_grantee_custom_fields_id' => $rowscf->id,
                                                                    'user_grantee_grant_id' => $step->user_grantee_grant_id,
                                                                    'user_grantee_id' => $userGranteeId,
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
                                                    $data_for_content['grantee_grant'] = $grantee_grant;
                                                    $data_for_content['step_id'] = $step->id;
                                                    // echo '<pre>';print_r($data_for_content);die;
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
                                                    data-max_multiple="<?= $step->max_multiple ?>" 
                                                    class="btn btn-primary <?= $display ?>" 
                                                    style="color:white">Add New
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if(!$is_admin) { ?>
                                    <?php if ((!isset($is_preview) || !$is_preview) && $detail_data['detail_grantee_grant']->status != STATUS_SET_TO_ALUMNI) { ?>
                                        <div class="progressbar">
                                            <?php if ($index + 1 == count($data_step)): ?>
                                                <?php 
                                                        $end_date = $detail_data['grantee_period']->end_date ? strtotime($detail_data['grantee_period']->end_date) : 0;
                                                        $today = strtotime(date('Y-m-d H:i'));
                                                        $disabledEndDate = false;
                                                        if ($end_date) {
                                                            $disabledEndDate = $end_date < $today;
                                                        }
                                                        
                                                        $end_offline_date = $detail_data['detail_grantee_grant']->end_offline_date ? strtotime($detail_data['detail_grantee_grant']->end_offline_date) : 0;
                                                        
                                                        $is_ended = false;
                                                        if ($end_offline_date) {
                                                            $is_ended = $end_offline_date < $today;
                                                        }

                                                        $isRelease = ($detail_data['detail_grantee_grant']->status == STATUS_SELECTION_REVISED && $detail_data['detail_grantee_grant']->is_release);

                                                        $canSubmit = false;

                                                        // Case 1: belum lewat end_date dan bukan release
                                                        if (!$disabledEndDate && !$isRelease) {
                                                            $canSubmit = true;
                                                        }

                                                        // Case 2: status revise dan is_release true, walaupun sudah lewat end_date
                                                        if ($detail_data['detail_grantee_grant']->status == STATUS_SELECTION_REVISED && $detail_data['detail_grantee_grant']->is_release) {
                                                            $canSubmit = true;
                                                        }

                                                        // Case 3: is_release true dan belum lewat end_date
                                                        if ($isRelease && !$disabledEndDate) {
                                                            $canSubmit = true;
                                                        }
                                                    ?>

                                                    <?php if ($canSubmit): ?>
                                                        <a 
                                                            href="#submit" 
                                                            data-submit="form-submission" 
                                                            class="btn btn-success submit-submission" 
                                                            <?= $disabled ?> 
                                                            style="color:#fff;float:right; <?= isset($disabled) && $disabled == 'disabled' ? 'display:none !important;' : '' ?>">
                                                            Submit
                                                        </a>
                                                        <a 
                                                            href="javascript:;" 
                                                            class="btn btn-primary save-submission" 
                                                            <?= $disabled ?> 
                                                            style="color:#fff;float:right;margin-right:10px; <?= isset($disabled) && $disabled == 'disabled' ? 'display:none !important;' : '' ?>">
                                                            Save
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php //if(!$disabledEndDate && !$isRelease) { ?>
                                                    <!-- <a 
                                                        href="#submit" 
                                                        data-submit="form-submission" 
                                                        class="btn btn-success submit-submission" 
                                                        <?= $disabled ?> 
                                                        <?= ($disabledEndDate && $detail_data['detail_grantee_grant']->status == STATUS_WAITING_DOCUMENT && $detail_data['detail_grantee_grant']->is_offline == 0) ? 'disabled' : (($detail_data['detail_grantee_grant']->is_offline == 1 && $is_ended) ? 'disabled' : (!$detail_data['detail_grantee_grant']->is_offline && $disabledEndDate ? 'disabled' : '')) ?>
                                                        style="color:#fff;float:right; <?php echo isset($disabled) && $disabled == 'disabled' ? 'display:none !important;' : '' ?>">
                                                    Submit
                                                    </a> -->
                                                    <?php //} ?>
                                                    <?php //if($detail_data['detail_grantee_grant']->status == STATUS_SELECTION_REVISED && !$isRelease){ ?>
                                                        <!-- <a 
                                                            href="#submit" 
                                                            data-submit="form-submission" 
                                                            class="btn btn-success submit-submission" 
                                                            <?= $disabled ?> 
                                                            style="color:#fff;float:right; <?php echo isset($disabled) && $disabled == 'disabled' ? 'display:none !important;' : '' ?>">">
                                                        Submit
                                                        </a> -->
                                                    <?php //} ?>
                                                    <?php //if($isRelease && !$disabledEndDate){ ?>
                                                        <!-- <a 
                                                            href="#submit" 
                                                            data-submit="form-submission" 
                                                            class="btn btn-success submit-submission" 
                                                            <?= $disabled ?> 
                                                            style="color:#fff;float:right; <?php echo isset($disabled) && $disabled == 'disabled' ? 'display:none !important;' : '' ?>">
                                                        Submit
                                                        </a> -->
                                                    <?php //} ?>
                                            <?php elseif ($index == 0): ?>
                                                    <a aria-expanded="true" data-toggle="tab" data-index="step_<?= $data_step[1]->id; ?>" class="btn btn-success next" <?php echo isset($disabled) && $disabled == 'disabled' ? $disabled . ' style="display:none !important;"' : 'style="color:#fff;float:right;margin-bottom:20px;"'; ?>>Save & Continue</a>
                                            <?php else: ?>
                                                    <a aria-expanded="true" data-toggle="tab" href="#step_<?= $data_step[$index - 1]->id; ?>" class="btn btn-primary previous" style="color:#fff;float:left;">Back</a>
                                                    <a aria-expanded="true" data-toggle="tab" data-index="step_<?= $data_step[$index + 1]->id; ?>" class="btn btn-success next" <?php echo isset($disabled) && $disabled == 'disabled' ? $disabled . ' style="display:none !important;"' : 'style="color:#fff;float:right;margin-bottom:20px;"'; ?>>Save & Continue</a>
                                            <?php endif; ?>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="progressbar">
                                        <?php if (count($grants_step) == 1) : ?>
                                            <div class="col-md-12 text-right">
                                                <?php if(in_array($category->is_new_grantee, [1,2,3,4,5])) { ?>
                                                    <a 
                                                        href="javascript:;" 
                                                        data-submit="form-submission" 
                                                        onclick="revise_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                        class="btn btn-warning revise-submission" 
                                                        id="btn-revise-submission" 
                                                        style="color:#fff;margin-right:5px;">
                                                        <i class="fa fa-pencil fa-fw"></i> Revise
                                                    </a>
                                                    <a 
                                                        href="javascript:;" 
                                                        data-submit="form-submission" 
                                                        onclick="accept_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                        class="btn btn-success submit-submission" 
                                                        id="btn-accept-submission" 
                                                        style="color:#fff;margin-right:5px;">
                                                        <i class="fa fa-check fa-fw"></i> Complete
                                                    </a>
                                                    <a 
                                                        href="javascript:;" 
                                                        data-submit="form-submission" 
                                                        onclick="withdraw_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                        class="btn btn-primary withdraw-submission" 
                                                        id="btn-withdraw-submission" 
                                                        style="color:#fff;margin-right:5px;">
                                                        <i class="fa fa-undo fa-fw"></i> Withdraw
                                                    </a>
                                                <?php } ?>
                                                <?php if ($category->name == 'Permit Application' || $category->name == 'Pre Arrival Documents') { ?>
                                                    <a 
                                                        href="javascript:;" 
                                                        data-submit="form-submission" 
                                                        onclick="permit_reject_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                        class="btn btn-danger permit-reject-submission"
                                                        id="btn-permit-reject-
                                                        submission" style="color:#fff;margin-right:5px;">
                                                        <i class="fa fa-ban fa-fw"></i> Permit Rejected
                                                    </a>
                                                <?php } ?>
                                                
                                                <?php if ($category->name == 'Visa Application') { ?>
                                                    <a
                                                        href="javascript:;" 
                                                        data-submit="form-submission" 
                                                        onclick="arrived_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                        class="btn btn-info arrived-submission" 
                                                        id="btn-arrived-submission" 
                                                        style="color:#fff;margin-right:5px;">
                                                        <i class="fa fa-inbox fa-fw"></i> Arrived
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        <?php elseif ($index == 0) : ?>
                                            <a 
                                                aria-expanded="true" 
                                                data-toggle="tab" 
                                                data-index="step_<?= $data_step[1]->id; ?>"
                                                class="btn btn-success next" 
                                                style="color:#fff;float:right;">
                                                Next <i class="fa fa-arrow-right fa-fw"></i>
                                            </a>
                                        <?php elseif ($index + 1 == count($grants_step)) : ?>
                                            <a 
                                                aria-expanded="true" 
                                                data-toggle="tab" 
                                                data-index="step_<?= $data_step[$index - 1]->id; ?>"
                                                class="btn btn-default previous" 
                                                style="float:left;">
                                                <i class="fa fa-arrow-left fa-fw"></i> Back
                                            </a>
                                            <?php if ($category->name == 'Permit Application' || $category->name == 'Pre Arrival Documents') { ?>
                                                <a 
                                                    href="javascript:;" 
                                                    data-submit="form-submission" 
                                                    onclick="permit_reject_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                    class="btn btn-danger permit-reject-submission"
                                                    id="btn-permit-reject-submission"
                                                    style="color:#fff;float:right;margin-bottom:20px;width:auto;margin-right:5px;">
                                                    <i class="fa fa-ban fa-fw"></i> Permit Rejected
                                                </a>
                                                <a 
                                                    href="javascript:;" 
                                                    data-submit="form-submission" 
                                                    onclick="withdraw_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                    class="btn btn-primary withdraw-submission" 
                                                    id="btn-withdraw-submission" 
                                                    style="color:#fff;float:right;margin-right:5px;">
                                                    <i class="fa fa-undo fa-fw"></i> Withdraw
                                                </a>
                                            <?php } ?>
                                            <?php if(in_array($category->is_new_grantee, [1,2,3,4,5])) { ?>
                                            <a 
                                                href="javascript:;" 
                                                data-submit="form-submission" 
                                                onclick="accept_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                class="btn btn-success submit-submission" 
                                                id="btn-accept-submission" 
                                                style="color:#fff;float:right;margin-right:5px;">
                                                <i class="fa fa-check fa-fw"></i> Complete
                                            </a>
                                            <a 
                                                href="javascript:;" 
                                                data-submit="form-submission" 
                                                onclick="revise_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                class="btn btn-warning revise-submission" 
                                                id="btn-revise-submission" 
                                                style="color:#fff;float:right;margin-right:5px;">
                                                <i class="fa fa-pencil fa-fw"></i> Revise
                                            </a>
                                            <?php } ?>
                                            
                                            <?php if ($category->name == 'Visa Application') { ?>
                                                <a 
                                                    href="javascript:;" 
                                                    data-submit="form-submission" 
                                                    onclick="arrived_submission_document(<?= $grantee_grant->user_grantee_id ?>, <?= $grantee_grant->id ?>, <?= $grantee_grant->grant_id ?>, <?= $category->id; ?>)" 
                                                    class="btn btn-info arrived-submission" 
                                                    id="btn-arrived-submission" 
                                                    style="color:#fff;float:right;margin-right:5px;">
                                                    <i class="fa fa-inbox fa-fw"></i> Arrived
                                                </a>
                                            <?php } ?>
                                        <?php else : ?>
                                            <a 
                                                aria-expanded="true" 
                                                data-toggle="tab" 
                                                data-index="step_<?= $data_step[$index - 1]->id; ?>"
                                                class="btn btn-primary previous" 
                                                style="color:#fff;float:left;">
                                                <i class="fa fa-arrow-left fa-fw"></i> Back
                                            </a>
                                            <a 
                                                aria-expanded="true" 
                                                data-toggle="tab" 
                                                data-index="step_<?= $data_step[$index + 1]->id; ?>"
                                                class="btn btn-success next"
                                                style="color:#fff;float:right;">
                                                Next <i class="fa fa-arrow-right fa-fw"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php } ?>
                            </div>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>
        <?php if($is_admin){ ?>
            <br><br>
            <hr>
            <div class="form-group">
                <label>Note</label>
                <textarea name="note" id="note_document" cols="30" rows="10" class="form-control" width="100%"><?= $note_document ?></textarea>
            </div>
        <?php } ?>
    </div>
</div>
<!-- /.row -->