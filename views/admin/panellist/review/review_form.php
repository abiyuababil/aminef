<style>
    .containt {
        margin: 0px auto 30px auto;
    }

    .progressbar {
        counter-reset: step;
        margin: 0px;
        padding: 0px;
    }

    .progressbar li {
        display: inline-block;
        list-style-type: none;
        width: 25%;
        /* float: left; */
        font-size: 12px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        color: #7d7d7d;
    }

    .progressbar li {
        width: 30px;
        height: 30px;
        line-height: 30px;
        background-color: #b5b5b5;
        /* display: block; */
        text-align: center;
        margin: auto 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .progressbar li a {
        color: white !important;
        text-decoration: none;
    }

    .progressbar li:after {
        width: 100%;
        height: 2px;
        content: '';
        position: absolute;
        background-color: #7d7d7d;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child:after {
        content: none;
    }

    .progressbar li.active {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.done {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.active+li:after {
        background-color: #55b776;
    }

    .btn_step {
        width: 150px;
    }

    .next {
        float: right;
    }

    .select2 {
        width:100% !important;
    }

    .display {
        display: none;
    }
</style>

<?php
$pid = $this->input->get('pid');
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}

?>

<input type="hidden" value="<?= $this->Grantee_ent_model->id ?>" id="grantee_id">
<input type="hidden" value="<?= $grantee_grant_id ?>" id="grantee_grant_id">
<div class="row">
    <div class="col-lg-12 mt-4 header-review">
        <h2><?= $this->Grantee_ent_model->first_name ?> <?= $this->Grantee_ent_model->middle_name ?>  <?= $this->Grantee_ent_model->last_name ?></h2>
        <ul class="nav nav-pills" style="border-bottom: 1px solid #ddd;">
            <li class="active">
                <a data-toggle="tab" href="#form-application" aria-expanded="true">
                    <?= !$is_pdf == 'form_application' ? 'Form Application' : 'PDF Application'; ?>
                </a>
            </li>
            <li><a data-toggle="tab" href="#contact" aria-expanded="true">Review</a></li>
        </ul>
    </div>

    <div class="tab-content">
        <div id="contact" class="tab-pane fade">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        
                    <?= $this->load->view('admin/panellist/review/review', [], true); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-12" style="margin-bottom:10px;">
                <div style="margin-bottom:10px;">

                    <?php
                    if ($this->Grantee_ent_model->id) {
                        ?>
                            <input type="hidden" name="id" id="uid" value="<?php echo $this->Grantee_ent_model->id ?>">
                    <?php } ?>

                </div>
            </div>
        </div>
        
        <?php if($is_pdf) { ?>
            <?php 
                $categories = $this->User_grantee_grant_category_model->get_data([
                    'user_grantee_grant_id' => $grantee_grant->grant_id,
                    'period_id'             => $grantee_grant->period_id,
                    'is_active'             => 1,
                    'sort'                  => 1,
                    'category_name'         => 'Application'
                ]);

                $params = [
                    'category_id' => $categories[0]->id,
                    'grants_id' => $grantee_grant->grant_id,
                    'country_id' => $grantee_grant->country_id,
                    'grantee_id' => $grantee_grant->user_grantee_id,
                    'grantee_grant_id' => $grantee_grant->id,
                ];

                $query_params = http_build_query($params);
                
            ?>
            <div id="form-application" class="tab-pane fade <?php echo (!$pid) ? 'active in' : ''; ?>">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <iframe style="width: 100%; height : 1000px;" frameborder="0"  id="pdf-iframe" src="<?= site_url('document/pdf/' . $grantee_grant->user_grantee_id . '/' . $grantee_grant->grant_id . '?' . $query_params); ?>#toolbar=0"></iframe>
                    </div>
                </div>
            </div>
        <?php }else{ ?>
            <?php  foreach ($submission as $key => $value) { ?>
            <div id="form-application" class="tab-pane fade <?php echo (!$pid && $select_section == $key) ? 'active in' : ''; ?>">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="page-header"><?php echo $submission['name']; ?></h1>
                        <h4 class="text-center"><?php echo $status->name; ?></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                    <div class="tabs">
                        <ul>
                            <?php
                            foreach ($value['grants_step'] as $index => $step): ?>
                                    <li>
                                        <a aria-expanded="true" data-toggle="tab" href="#<?= $key ?>_step_<?= $step->id; ?>" onclick="navigate_tab_admin('<?= $key ?>', <?= $step->id; ?>)" aria-expanded="true"><?= $step->label ?></a>
                                    </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="row">
                            <div class="col col-lg-12">
                                <div class="tab-content">
                                    <?php foreach ($value['grants_step'] as $index => $step):
                                            $index_of_country = $this->session->userdata('index_of_country') ? ($this->session->userdata('index_of_country')) + 1 : 1;
                                            $this->session->set_userdata('index_of_country', $index_of_country);
                                            $index_of_state_of_study = $this->session->userdata('index_of_state_of_study') ? ($this->session->userdata('index_of_state_of_study')) + 1 : 1;
                                            $this->session->set_userdata('index_of_state_of_study', $index_of_state_of_study);
                                            ?>
                                            <div id="<?= $key ?>_step_<?= $step->id; ?>" class="tab-pane fade <?php if ($index == 0) {
                                                    echo 'active in first_tab';
                                                } ?>">
                                                <div class="panel panel-default">
                                                    <?php if ($step->note_letter_of_reference) { ?>
                                                        <?= $step->note_letter_of_reference ?>
                                                    <?php } ?>
                                                    <?php if ($step->is_letter_of_reference) { ?>
                                                        <div class="panel-body">
                                                            <?= $step->note_letter_of_reference ?>
                                                            <div class="row form-group mt-4">
                                                                <div class="col-lg-4">
                                                                    <label>Letter of Reference</label>
                                                                    <div class="row"> 
                                                                    <div class="col-lg-8">
                                                                        <img height="100" width="100" style="object-fit:contain;" src="<?php echo get_preview($period->letter_of_reference); ?>">
                                                                        <br />
                                                                        <!-- <p class="filename" style="font-size:16px"><?= $filename ?></p> -->
                                                                        <hr>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="panel-body">
                                                        
                                                        <!-- ENDPRE DEPATURE ORIENTATION -->
                                                        <?php $file = 0; ?>
                                                        <?php $row = "<div class='row form-group'>"; ?>
                                                        <?php $exitrow = "</div>"; ?>
                                                        <?php 
                                                            foreach ($value['data'][$step->id] as $key_fields => $custom_fields) { 
                                                            if($custom_fields->type == 'radio group'){
                                                                $custom_fields->user_grantee_id = $this->Grantee_ent_model->id;
                                                                $custom_fields->grantee_grant_id = $grantee_grant_id;
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
                                                                    <div class="wrap-file-<?= $custom_fields->id ?>"> 
                                                                        <div class="row form-group">
                                                                            <?php if ($custom_fields->type == 'separator'): ?>
                                                                                <div class="col-lg-12 text-left font-weight-bold">
                                                                                    <!-- <b><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $custom_fields->name); ?></b> -->
                                                                                    <b><?= url_text($custom_fields->name) ?></b>
                                                                                    <?php if ($custom_fields->description_file != '') { ?>
                                                                                        <div class="mt-2">
                                                                                            <span style="font-size: 12px !important; margin-left: 15px;"><?= $custom_fields->description_file ?></span>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            <?php else: ?>
                                                                                <div class="<?= in_array($custom_fields->type, ['element group', 'education group']) ? 'col-md-12' : 'col-md-4' ?> text-left font-weight-bold">
                                                                                    <?php if(in_array($custom_fields->type, ['element group', 'education group'])) { ?>
                                                                                        <b><?= url_text($custom_fields->name); ?> <?= in_array($custom_fields->type, ['element group', 'radio group', 'education group']) ? null : label_required($custom_fields->is_required); ?></b>
                                                                                        <div style="margin-top:10px;">
                                                                                            <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                                                                        </div>
                                                                                    <?php } else {?>
                                                                                        <?= url_text($custom_fields->name); ?> <?= in_array($custom_fields->type, ['element group', 'radio group', 'education group']) ? null : label_required($custom_fields->is_required); ?>
                                                                                    <?php } ?>
                                                                                </div>
                                                                                
                                                                            <?php endif; ?>
                                                                            <div class="<?php echo in_array($custom_fields->type, get_question_type()) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                                <?php
                                                                                $disabled = ($key == $select_section) ? '' : 'disabled';
                                                                                if (in_array($grantee_grant->status, [STATUS_SELECTION_DECLINED, STATUS_CANDIDATE_DECLINED, STATUS_ON_GOING_REVISED])) {
                                                                                    $disabled = 'disabled';
                                                                                    $display = 'display';
                                                                                }
                                                                                echo get_component($custom_fields, 'disabled', $custom_fields->value_custom_fields); ?>
                                                                            </div>
                                                                            <?php if ($custom_fields->description_file != '' && !in_array($custom_fields->type, ['separator', 'element group', 'education group'])) { ?>
                                                                                <div class="col-lg-12" style="margin-top:-20px;">
                                                                                    <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                            
                                                                        <?php if ($custom_fields->is_multiple && !in_array($custom_fields->type, ['radio group', 'education group'])) { ?>
                                                                            <?php foreach ($custom_fields->multiple_file as $kmf => $mf) { ?>
                                                                                
                                                                                <div class="multiple-item" style="margin-left: -15px;">
                                                                                    <div class="<?= $custom_fields->type == 'element group' ? 'col-md-12' : 'col-md-4' ?> text-left font-weight-bold">
                                                                                        <b><?= url_text($mf->property_name); ?></b>
                                                                                        <div style="margin-top:10px;">
                                                                                            <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= $custom_fields->description_file ?></span>
                                                                                        </div>
                                                                                    </div>
                                                            
                                                                                    <div class="<?php echo in_array($custom_fields->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', NULL]) ? 'col-md-8' : 'col-md-12'; ?> font-weight-bold">
                                                                                        <!-- dapatkan data value dari customfield multiple -->
                                                                                        <?php 
                                                                                        $condition_custom_fields_value = [
                                                                                            'user_grantee_custom_fields_id' => $custom_fields->id,
                                                                                            'user_grantee_grant_id' => $custom_fields->user_grantee_grant_id,
                                                                                            'user_grantee_id' => $this->Grantee_ent_model->id,
                                                                                            'user_grantee_period_id' => $grantee_grant->period_id,
                                                                                            'multiple_file_id' => $mf->id,
                                                                                            'grantee_grant_id' => $grantee_grant_id
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
                                                                                        <?= get_component($custom_fields, 'disabled', $custom_fields->value_custom_fields, true); ?>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php else: ?>
                                                                        <?php
                                                                        $filename = get_filename_submission($custom_fields);
                                                                        $strlen = strlen($filename);
                                                                        $name_file = $filename;
                                                                        $display = ($key == $select_section) ? '' : 'display';
                                                                        if (in_array($grantee_grant->status, [STATUS_SELECTION_DECLINED, STATUS_CANDIDATE_DECLINED, STATUS_ON_GOING_REVISED])) {
                                                                            $display = 'display';
                                                                        }
                                                                        if ($strlen > 15) {
                                                                            $name_file = substr($filename, 0, 15) . '....';
                                                                        }
                                                                        $fileurl = get_fileurl_sumbission($custom_fields);
                                                                        if ($value['data'][$step->id][$key_fields + 1]->type == 'file') {
                                                                            $file = 0;
                                                                            $row = "";
                                                                            $exitrow = "";
                                                                            $style = "margin-left:-13px;";
                                                                        } else {
                                                                            $row = "<div class='row form-group'>";
                                                                            $exitrow = "</div>";
                                                                            $style = "";
                                                                        }
                                                                        ?>
                                                                        <?= $row; ?>
                                                                        <div class="wrap-file-<?= $custom_fields->id ?>"> 
                                                                            <div class="<?= $custom_fields->is_row ? 'col-md-12 is_row_class' : 'col-lg-4' ?>" style="<?= $style ?>">
                                                                                <label style="min-height: 25px;font-weight:100"><?= url_text($custom_fields->name) ?> <?= label_required($custom_fields->is_required) ?></label>
                                                                                <?php if ($custom_fields->description_file) { ?>
                                                                                <div>
                                                                                    <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                                </div>
                                                                                <?php } ?>
                                                                                <div class="row">
                                                                                    <div class="col-lg-6" style="height: 150px;">
                                                                                        <?php if ($fileurl) { ?>
                                                                                            <div style="position:relative; width:100px;">
                                                                                                <img style="margin-top: 16px; object-fit:contain;" height="100" width="100" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                                            </div>
                                                                                        <?php } else { ?>
                                                                                            <div id="preview_section_<?php echo $custom_fields->id; ?>">
                                                                                                <img onclick="add_file('my_file_' + <?= $custom_fields->id ?>);" data-trigger="my_file_<?= $custom_fields->id ?>" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id ?>" class="preview_image_<?= $custom_fields->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
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
                                                                                    <div class="col-lg-12">
                                                                                        <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style ="color:#fff;display:<?= $display_file ?>"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                                                    </div>
                                                                                </div>
                                                                                <small class="file-for-testing">File Size Max 5MB | Supported File: Jpg, Png, PDF</small>
                                                                                <input onchange="show_preview(this, <?= $custom_fields->id ?>);" type="file" data-category-id='<?= $custom_fields->user_grantee_category_id; ?>' data-category-type='<?= $custom_fields->user_grantee_category_type; ?>' data-grant-id='<?= $custom_fields->user_grantee_grant_id; ?>' data-step='<?= $custom_fields->user_grantee_step_id; ?>' data-id='<?= $custom_fields->id; ?>' data-period-id='<?= $custom_fields->period_id ?>' class="choosefile my_file_<?= $custom_fields->id ?> autosave" style="display: none;" <?= $required ?>>
                                                                                <hr>
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
                                                                                                <label style="min-height: 75px;font-weight:100"><?= url_text($custom_fields->name) ?>                         <?= label_required($custom_fields->is_required) ?></label>
                                                                                                <div style="margin-top:-80px;">
                                                                                                    <span style="font-size: 12px !important; margin-left: 15px; text-align: justify;word-wrap: break-word;"><?= !empty($custom_fields->description_file) ? $custom_fields->description_file : '&nbsp;' ?></span>
                                                                                                </div>
                                                                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="delete-multiple-spinner-<?= $mf->id ?>" style="display:none;">
                                                                                                <div class="row">
                                                                                                    <div class="col-lg-6" style="height: 150px;">
                                                                                                        <?php if ($fileurl) { ?>
                                                                                                                <div id="preview_section_<?php echo $custom_fields->id . $mf->id; ?>" style="position:relative; width:100px;">
                                                                                                                    <img style="margin-top:16px; object-fit:contain;" height="100" width="100" id="preview_image_<?= $custom_fields->id . $mf->id ?>" class="preview_image_<?= $custom_fields->id . $mf->id ?>" src="<?php echo get_preview($fileurl); ?>">
                                                                                                            </div>
                                                                                                        <?php } else { ?>
                                                                                                                <div id="preview_section_<?php echo $custom_fields->id . $mf->id; ?>" style="position:relative; width:100px;">
                                                                                                                    <img onclick="add_file('my_file_' + <?= $custom_fields->id . $mf->id ?>);" data-trigger="my_file_<?= $custom_fields->id . $mf->id ?>" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_<?= $custom_fields->id . $mf->id ?>" class="preview_image_<?= $custom_fields->id . $mf->id ?>" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">
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
                                                                                                    <div class="col-lg-12">
                                                                                                    <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style ="color:#fff;display:<?= $display_file ?>"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                                                                    </div>
                                                                                                </div>
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
                                                                        </div>
                                                                        <?= $exitrow; ?>
                                                                    <?php $file++; endif; ?>
                                                        <?php } ?>
                                                    </div>
                                
                                                    <div class="wrap-step-<?= $step->id ?>">
                                                        <?php if (!empty($step->multiple_fields_step)) { ?>
                                                                <?php foreach ($step->multiple_fields_step as $mfs) { ?>
                                                                        <?php
                                                                        $data_for_content['idx'] = $mfs->id;
                                                                        $data_for_content['data_custom_fields'] = $value['data'][$step->id];
                                                                        $data_for_content['disabled'] = $disabled;
                                                                        $data['is_admin'] = true;
                                                                        foreach ($value['data'][$step->id] as $kscf => $rowscf) {
                                                                            $condition_multiple_file = [
                                                                                'user_grantee_custom_fields_id' => $rowscf->id,
                                                                                'user_grantee_grant_id' => $rowscf->user_grantee_grant_id,
                                                                                'user_grantee_id' => $this->Grantee_ent_model->id,
                                                                                'user_grantee_period_id' => $grantee_grant->period_id,
                                                                                // 'multiple_file_id' => $mfs->id,
                                                                                'multiple_step_id' => $mfs->id,
                                                                                'grantee_grant_id' => $grantee_grant_id,
                                                                            ];
                                                                            $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_file);
                                                                            $arr_value_custom_fields = get_all_db('am_user_grantee_submission', $condition_multiple_file);
                                                                            // if type radio group then get sub element 
                                                                            $sub_element = "";
                                                                            if ($custom_fields->type == 'radio group' || $custom_fields->type == 'element group') {
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
    
                                                                            if ($rowscf->type == 'file' && $rowscf->is_multiple == true) {
                                                                                $multiple_file_for_file = get_all_db('am_user_grantee_multiple_file', [
                                                                                    'custom_fields_id' => $rowscf->id,
                                                                                    'grantee_grant_id' => $grantee_grant_id,
                                                                                    'user_grantee_step_id' => $mfs->id,
                                                                                ]);
                                                                                foreach ($multiple_file_for_file as $kmf => $mf) {
                                                                                    $condition_multiple_for_file = [
                                                                                        'user_grantee_custom_fields_id' => $rowscf->id,
                                                                                        'user_grantee_grant_id' => $rowscf->user_grantee_grant_id,
                                                                                        'user_grantee_id' => $this->Grantee_ent_model->id,
                                                                                        'user_grantee_period_id' => $grantee_grant->period_id,
                                                                                        'multiple_file_id' => $mf->id,
                                                                                        'multiple_step_id' => $mfs->id,
                                                                                        'grantee_grant_id' => $grantee_grant_id,
                                                                                    ];
                                                                                    $value_multiple_file = get_row_db('am_user_grantee_submission', $condition_multiple_for_file);
                                                                                    $mf->value = $value_multiple_file ? $value_multiple_file->value : '';
                                                                                }
                                                                                $rowscf->multiple_file = $multiple_file_for_file;
                                                                            }
                                                                        }
                                                                        echo $this->load->view('grantee/submission/multiple_fields_step', $data_for_content, true);
                                                                        ?>
                                                                <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endforeach; ?>
                                    <br><br>
                                    <hr>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <?php
                                        $note = 'note_' . $select_section;
                                        if ($note == 'note_on_going') {
                                            $note = 'note_ongoing';
                                        }
                                        ?>
                                        <textarea disabled name="note" id="<?= $key; ?>_note_submission" cols="30" rows="10" class="form-control" width="100%"><?= $grantee_grant->$note ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } ?>

    </div>

    <!-- <div class="col-lg-12" style="margin-bottom:50px">
        <a href="<?= site_url('admin/selection/manage') ?>" class="btn btn-primary btn-lg" style="width:150px;float:left;">Back</a>
    </div> -->
</div>
<?php $this->load->view('admin/partials/modal_confirm') ?>