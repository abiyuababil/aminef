<div class="col-lg-12 text-center">
    <h2 style="color:#0089d1">Missing Document</h2>
    <h1 class="page-header"><?php echo $title ?></h1>
    <h3><?= $data_missing->category_name . ' - ' . $data_missing->step_name . ' - ' . $data_missing->question_name ?></>
</div>
<div class="row">
    <form role="form" method="POST" enctype="multipart/form-data" id="form_missing_doc">
        <input type="hidden" value="<?= $data_missing->id ?>" name="missing_id">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="text-left">Required Field or Error: </h4>
                <div class="alert alert-danger" role="alert" style="height:auto">
                    <h4 class="alert-heading text-justify"><?= $data_missing->note ?></h4>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-lg-6">
                    <h2>Current Data</h2>

                <?php if($question->type == 'element group' || $question->type == 'radio group') { 
                    $groupedData = grouped_data_missing($question->value_custom_fields);
                    
                    $index = 0;
                    foreach($groupedData as $multiple_id => $gd){
                        $where = [
                            'user_grantee_custom_fields_id' => $question->id,
                            'user_grantee_grant_id' => $question->user_grantee_grant_id,
                            'multiple_file_id' => $gd['multiple_file_id'],
                            'multiple_step_id' => $gd['multiple_step_id'],
                            'grantee_grant_id' => $grantee_grant->id,
                        ];
                        $value_custom_fields = $this->User_grantee_submission_model->get_all_from_table('am_user_grantee_submission', $where);
                        if ($question->type == 'radio group' || $question->type == 'element group'){
                            $data_element_parent = $this->User_grantee_submission_model->get_single_from_table('am_user_grantee_submission', [
                                'user_grantee_custom_fields_id' => $question->id,
                                'grantee_grant_id' => $grantee_grant->id,
                                'group_element_id' => 0,
                                'multiple_step_id' => $gd['multiple_step_id']
                            ]);
                            $where_element = ['custom_fields_id' => $question->id];
                            if($question->type == 'radio group' && $data_element_parent != null){
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
                                $question->sub_element = $sub_element;
                            }
                            $question->multiple_file_id = $gd['multiple_file_id'];
                        }
    
    
                        $which_group = 'element_group_' . $question->id;
                        $type_group = 'element';
                        $data_before_arr = json_decode($data_missing->data_before); 
                        if($index != 0){
                        echo "<hr />";
                        }
                        echo render_sub_element($question, $which_group, $type_group, 'disabled', $question->is_multiple, null, true, $data_before_arr, [], 'before');
                        $index++;
    
                    }
                ?>
                <?php } else { ?>
                <?php if ($question->type != 'file') : ?>
                <?php foreach($question->value_custom_fields as $row ) :
                    $class_col = in_array($question->type, get_question_type()) ? 'col-md-8' : 'col-md-12';
                    $component = get_component($question, 'disabled', $row->value);
                ?>
                    <div class="col-md-12">
                        <div class='form-group'>
                            <label><?= $question->name ?></label>
                            <div class='<?= $class_col ?>; font-weight-bold'>
                                <?= $component ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php else : ?>
                    <?php foreach($question->value_custom_fields as $row ) : 
                        $file = json_decode($row->value); 
                        $filename = $file->filename;
                        $fileurl = $file->filepath;
                    ?>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label><?= $question->name ?></label>
                                <div class="row"> 
                                <?php if($fileurl) { ?>
                                <div class="col-lg-8">
                                    <p class="filename" style="font-size:16px"><?= $filename ?></p>
                                    <a href="<?= base_url($fileurl) ?>" class="btn btn-warning fileview lightbox" style="color:#fff;display:$display_file" target="_blank">
                                        <i class="fa fa-eye fa-fw"></i> Preview
                                    </a>
                                    <hr>
                                </div>
                                <?php } else { ?>
                                <div class="col-lg-8">
                                    <p class="filename" style="font-size:16px">No File Uploaded</p>
                                </div>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php } ?>
                </div>
                <div class="col-lg-6">
                <h2>Submit Data</h2>
                
                <?php if($question->type == 'element group' || $question->type == 'radio group') { 

                    $groupedData = grouped_data_missing($question->value_custom_fields);
                    $index = 0;
                    foreach($groupedData as $multiple_id => $gd){
                        $where = [
                            'user_grantee_custom_fields_id' => $question->id,
                            'user_grantee_grant_id' => $question->user_grantee_grant_id,
                            'multiple_file_id' => $gd['multiple_file_id'],
                            'multiple_step_id' => $gd['multiple_step_id'],
                            'grantee_grant_id' => $grantee_grant->id,
                        ];
                        $value_custom_fields = $this->User_grantee_submission_model->get_all_from_table('am_user_grantee_submission', $where);
                        if ($question->type == 'radio group' || $question->type == 'element group'){
                            $data_element_parent = $this->User_grantee_submission_model->get_single_from_table('am_user_grantee_submission', [
                                'user_grantee_custom_fields_id' => $question->id,
                                'grantee_grant_id' => $grantee_grant->id,
                                'group_element_id' => 0,
                                'multiple_step_id' => $gd['multiple_step_id']
                            ]);
                            $where_element = ['custom_fields_id' => $question->id];
                            if($question->type == 'radio group' && $data_element_parent != null){
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
                                $question->sub_element = $sub_element;
                            }
                        }
    
    
                        $which_group = 'element_group_' . $question->id;
                        $type_group = 'element';

                        $data_for_content_before = $data_missing->data_before; 
                        $data_before_arr = $data_for_content_before ? json_decode($data_for_content_before) : []; 
                        $data_for_content_after = $data_missing->data_after; 
                        $data_after_arr = $data_for_content_after ? json_decode($data_for_content_after) : []; 
                        if($index != 0){
                        echo "<hr />";
                        }
                        echo render_sub_element($question, $which_group, $type_group, ($data_missing->status != REVISE ? 'disabled' : ''), $question->is_multiple, null, false, $data_before_arr, $data_after_arr);
                        $index++;
    
                    }
                ?>
                <?php }else{ ?>
                <?php if ($question->type != 'file') : ?>
                    <?php foreach($question->value_custom_fields as $row ) :
                        $class_col = in_array($question->type, get_question_type()) ? 'col-md-8' : 'col-md-12';
                        $component = get_component($question, '', '', false, $row->id);
                    ?>
                        <div class="col-md-12">
                            <div class='form-group'>
                                <label><?= $question->name ?></label>
                                <div class='<?= $class_col ?>; font-weight-bold'>
                                    <?= $component ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php foreach($question->value_custom_fields as $row ) : ?>
                        <div class="row form-group">
                            <div class="col-lg-9">
                                <label><?= $question->name ?></label>
                                <div class="row"> 
                                <div class="col-lg-12">
                                    <input type="file" class="form-control" name="<?= $row->id ?>" required>
                                    <small class="file-for-testing">File Size Max 5MB | Supported File: Jpg, Png, PDF</small>
                                    <hr>
                                </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php } ?>
                </div>

                <div class="col-lg-12" style="margin-bottom:10px;">
                    <div style="margin-bottom:10px;">
                    <?php if($data_missing->status == REVISE){ ?>
                        <button type="submit" id="btn-submit" class="btn btn-success btn-submit ml-2" name="btn-submit" style="float:right;">Submit</button>
                    <?php } ?>
                        <a href="<?= base_url('grantee/missing_document/'. $this->session->userdata('grantee_user_id')) ?>" class="btn btn-default" style="float:right;">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<script>
function submission_onblur(e){
    return true;
}
</script>