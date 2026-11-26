<style>
    .tooltip-inner{
        background-color: black;
        word-wrap: break-word;
        text-align: left;
        white-space: pre-line;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Missing Document</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
    <div class="col-lg-4">
        <form role="form" method="POST" id="form">
            <div class="form-group">
                <label>Category</label>
                <?php if($data_missing) { ?>
                    <input type="hidden" value="<?= $data_missing->id ?>" name="missing_doc_id">
                <?php } ?>
                <select class="form-control select2" name="category_id" id="category_id" required>
                    <option value="">-- Select Category --</option>
                    <?php
                    if($categories)
                    {
                        foreach($categories as $category) {
                            $selected = '';
                            if (isset($category->id) && $category->id == $data_missing->category_id)
                                $selected = 'selected="selected"';
                    ?>
                        <option value="<?php echo $category->id ?>" <?php echo $selected ?>><?php echo $category->name ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Step</label>
                <img src="<?php echo base_url() ?>/img/loading.gif" id="load-step_id" style="display:none;">
                <select class="form-control select2" name="step_id" id="step_id" required>
                    <option value="">-- Select Step --</option>
                    <?php
                    if($steps)
                    {
                        foreach($steps as $step) {
                            $selected = '';
                            if (isset($step->id) && $step->id == $data_missing->step_id)
                                $selected = 'selected="selected"';
                    ?>
                        <option value="<?php echo $step->id ?>" <?php echo $selected ?>><?php echo $step->label ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Question</label>
                <img src="<?php echo base_url() ?>/img/loading.gif" id="load-question_id" style="display:none;">
                <select class="form-control select2" name="question_id" id="question_id" required>
                    <option value="">-- Select Question --</option>
                    <?php
                    if($questions)
                    {
                        foreach($questions as $question) {
                            $selected = '';
                            if (isset($question->id) && $question->id == $data_missing->question_id)
                                $selected = 'selected="selected"';
                    ?>
                        <option value="<?php echo $question->id ?>" <?php echo $selected ?>><?php echo $question->name ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Note</label>
                <textarea class="form-control" name="note" id="note" cols="30" rows="10"><?= $data_missing->note ?></textarea>
            </div>
            <?php
            if (isset($data_missing->id)) {
            ?>
            <input type="hidden" name="id" value="<?php echo $data_missing->id ?>">
            <?php } ?>
            <a href="<?php echo site_url('admin/missing_document/manage/'.$grantee_grant_id) ?>" class="btn btn-default">Back</a>
            <?php if($data_missing->status != APPROVE) { ?>
            <button type="submit" class="btn btn-primary" name="btn" value="save">Submit</button>
            <?php } ?>
            <?php if($data_missing->data_after && $data_missing->status != APPROVE) { ?>
                <button type="submit" value="approve" name="btn" class="btn btn-success">Approve</button>
            <?php } ?>
        </form>
    </div>
    <div class="col-lg-4" id="data_value">
        <?php if($data_missing->data_before) { ?>
            <h2>Old Data</h2><hr />
            <?php 
                $question_before = get_row_db("am_user_grantee_custom_fields", ["id" => $data_missing->question_id]);
            ?>
            <?php if($question_before->type == 'element group' || $question->type == 'radio group') { 
                $data = $this->Missing_document_model->get_all_from_table('am_user_grantee_submission', [
                    'user_grantee_custom_fields_id' => $question_before->id,
                    'grantee_grant_id' => $grantee_grant_id
                ]);

                $groupedData = grouped_data_missing($data);

                $index = 0;
                foreach($groupedData as $multiple_id => $gd){
                    $where = [
                        'user_grantee_custom_fields_id' => $question_before->id,
                        'user_grantee_grant_id' => $question_before->user_grantee_grant_id,
                        'multiple_file_id' => $gd['multiple_file_id'],
                        'multiple_step_id' => $gd['multiple_step_id'],
                        'grantee_grant_id' => $grantee_grant_id,
                    ];
                    $value_custom_fields = $this->User_grantee_submission_model->get_all_from_table('am_user_grantee_submission', $where);
                    if ($question_before->type == 'radio group' || $question_before->type == 'element group'){
                        $data_element_parent = $this->Missing_document_model->get_single_from_table('am_user_grantee_submission', [
                            'user_grantee_custom_fields_id' => $question_before->id,
                            'grantee_grant_id' => $grantee_grant_id,
                            'group_element_id' => 0,
                            'multiple_step_id' => $gd['multiple_step_id']
                        ]);
                        $where_element = ['custom_fields_id' => $question_before->id];
                        if($question_before->type == 'radio group' && $data_element_parent != null){
                            $where_element['which_option'] = $data_element_parent->value;
                        }
                        $sub_element = $this->User_grantee_submission_model->get_all_from_table('am_user_grantee_group_element', $where_element);
                        $sub_element = array_map(function($data) use ($value_custom_fields){
                            $get_value = array_filter($value_custom_fields, function($value) use ($data){
                                return $value->group_element_id == $data->id;
                            });
                            $data->value = array_column($get_value, 'value');
                            $data->submission_id = array_column($get_value, 'id');
                            return $data;
                        }, $sub_element);
                        $value_custom_fields = array_filter($value_custom_fields, function ($value) { return $value->group_element_id == 0;});
            
                        if($sub_element){
                            $question_before->sub_element = $sub_element;
                        }
                        $question_before->multiple_file_id = $gd['multiple_file_id'];
                    }


                    $which_group = 'element_group_' . $question_before->id;
                    $type_group = 'element';
                    $data_before_arr = json_decode($data_missing->data_before); 
                    if($index != 0){
                    echo "<hr />";
                    }
                    echo render_sub_element($question_before, $which_group, $type_group, 'disabled', $question_before->is_multiple, null, $data_missing->status != APPROVE, $data_before_arr, [], 'before');
                    $index++;

                }
                ?>
            <?php }else{ ?>
                <?php 
                    $data_before = json_decode($data_missing->data_before); 
                    foreach($data_before as $key => $row) :
                    $fileNameArr = $row->value ? explode('/', $row->value) : [];
                    $fileName = $fileNameArr ? end($fileNameArr) : '';
                ?>
                    <?php if($question_before->type == 'file') { ?>
                        <input type="hidden" name="type" form="form" value=<?= $question_before->type ?>>
                        <div class="row form-group">
                                <div class="col-lg-6">
                                    <label><?= $question_before->name ?></label>
                                    <div class="row"> 
                                    <?php if($row->value) { ?>
                                    <div class="col-lg-8">
                                        <p class="filename" style="font-size:16px" data-toggle="tooltip" data-placement="top" title="<?= $fileName ?>"><?= substr_file($fileName, 0, 35) ?></p>
                                        <a href="<?= base_url($row->value) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:$display_file" target="_blank">
                                            <i class="fa fa-eye fa-fw"></i> Preview
                                        </a>
                                        <hr>
                                    </div>
                                    <?php } else { ?>
                                    <div class="col-lg-8">
                                        <p class="filename" style="font-size:16px">No File Uploaded</p>
                                    </div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                    <?php }else{ 
                        $class_col = in_array($question_before->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', 'radio', NULL]) ? 'col-md-8' : 'col-md-12';
                        $component = get_component($question_before, 'disabled', $row->value);
                    ?>
                        <div class='row form-group'>
                            <div class='col-md-4 text-left'><?= $question_before->name ?></div>
                            <div class='<?= $class_col ?> font-weight-bold'>
                                <?= $component ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="col-lg-4">
        <?php if($data_missing->data_after) { ?>
            <h2>New Data</h2><hr />
            <?php 
                $question_after = get_row_db("am_user_grantee_custom_fields", ["id" => $data_missing->question_id]);
            ?>
            <?php if($question_after->type == 'element group' || $question->type == 'radio group') { 
                $data = $this->Missing_document_model->get_all_from_table('am_user_grantee_submission', [
                    'user_grantee_custom_fields_id' => $question_after->id,
                    'grantee_grant_id' => $grantee_grant_id
                ]);

                $groupedData = grouped_data_missing($data);
                $index = 0;
                foreach($groupedData as $multiple_id => $gd){
                    $where = [
                        'user_grantee_custom_fields_id' => $question_after->id,
                        'user_grantee_grant_id' => $question_after->user_grantee_grant_id,
                        'multiple_file_id' => $gd['multiple_file_id'],
                        'multiple_step_id' => $gd['multiple_step_id'],
                        'grantee_grant_id' => $grantee_grant_id,
                    ];
                    $value_custom_fields = $this->User_grantee_submission_model->get_all_from_table('am_user_grantee_submission', $where);
                    if ($question_after->type == 'radio group' || $question_after->type == 'element group'){
                        $data_element_parent = $this->Missing_document_model->get_single_from_table('am_user_grantee_submission', [
                            'user_grantee_custom_fields_id' => $question_before->id,
                            'grantee_grant_id' => $grantee_grant_id,
                            'group_element_id' => 0,
                            'multiple_step_id' => $gd['multiple_step_id']
                        ]);
                        $where_element = ['custom_fields_id' => $question_after->id];
                        if($question_after->type == 'radio group' && $data_element_parent != null){
                            $where_element['which_option'] = $data_element_parent->value;
                        }
                        $sub_element = $this->User_grantee_submission_model->get_all_from_table('am_user_grantee_group_element', $where_element);
                        $sub_element = array_map(function($data) use ($value_custom_fields){
                            $get_value = array_filter($value_custom_fields, function($value) use ($data){
                                return $value->group_element_id == $data->id;
                            });
                            $data->value = array_column($get_value, 'value');
                            $data->submission_id = array_column($get_value, 'id');
                            return $data;
                        }, $sub_element);
                        $value_custom_fields = array_filter($value_custom_fields, function ($value) { return $value->group_element_id == 0;});
            
                        if($sub_element){
                            $question_after->sub_element = $sub_element;
                        }
                        $question_after->multiple_file_id = $gd['multiple_file_id'];
                    }


                    $which_group = 'element_group_' . $question_after->id;
                    $type_group = 'element';
                    $data_after_arr = json_decode($data_missing->data_after); 
                    if($gd['multiple_file_id'] != 0){
                    echo "<hr />";
                    }
                    echo render_sub_element($question_after, $which_group, $type_group, 'disabled', false, null, false, $data_after_arr);
                    $index++;

                }
                ?>
            <?php }else{ ?>
                <?php 
                    $question_after = get_row_db("am_user_grantee_custom_fields", ["id" => $data_missing->question_id]);
                    // echo '<pre>';print_r($question_after);die;
                    $data_after = json_decode($data_missing->data_after); 
                    foreach($data_after as $key => $row) :
                        $fileNameArr = $row->value ? explode('/', $row->value) : [];
                        $fileName = $fileNameArr ? end($fileNameArr) : '';
                ?>
                <?php if($question_after->type == 'file') { ?>
                    <input type="hidden" name="type" form="form" value=<?= $question_after->type ?>>
                    <div class="row form-group">
                            <div class="col-lg-4">
                                <label><?= $question_after->name ?></label>
                                <div class="row"> 
                                <div class="col-lg-8">
                                    <p class="filename" style="font-size:16px" data-toggle="tooltip" data-placement="right" title="<?= $fileName ?>"><?= substr_file($fileName, 0, 35) ?></p>
                                    <a href="<?= base_url($row->value) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:$display_file" target="_blank">
                                        <i class="fa fa-eye fa-fw"></i> Preview
                                    </a>
                                    <hr>
                                </div>
                                </div>
                            </div>
                        </div>
                <?php }else{ 
                    $class_col = in_array($question_after->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', 'radio', NULL]) ? 'col-md-8' : 'col-md-12';
                    $component = get_component($question_after, 'disabled', $row->value);
                ?>
                    <div class='row form-group'>
                        <div class='col-md-4 text-left'><?= $question_after->name ?></div>
                        <div class='<?= $class_col ?> font-weight-bold'>
                            <?= $component ?>
                        </div>
                    </div>
                <?php } ?>
                <?php endforeach; ?>
            <?php } ?>
        <?php } ?>
    </div>
    </div>
</div>
