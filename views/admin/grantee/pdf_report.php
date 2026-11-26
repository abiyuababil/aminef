<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    

    <link href="<?php echo base_url() ?>css/bootstrap.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-4-utilities.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet">
    <style>
        td, th {
            padding:5px;
            vertical-align: top;
        }

        td.answer {
            height: 200px;
        }

        .table {
            border: 2px solid #ebebeb;
        }

        .table td {
            border-bottom: 2px solid #ebebeb;
            font-weight: bold;
        }
    </style>
</head>
<body>   
    <table width="100%" class="mb-5">
        <tr>
            <td><h4 style="font-weight:bold"><?= $report->name ?></h4></td>
            <td class="text-right"><img width=280 src="img/logo_pdf.png" alt=""></td>
        </tr>
    </table>

    <table width="100%" style="vertical-align: top;">
        <tr>
            <td>
                <table class="table table-bordered" width="100%" style="background-color: #fff">
                    <tr>
                        <td width=10% style="background-color:#ebebeb">Name</td>
                        <td><?= $grantee_full_name; ?></td>
                    </tr>
                    <tr>
                        <td style="background-color:#ebebeb">Grant</td>
                        <td><?= $report->grant_name?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table class="table text-justify" style="background-color: #fff;">
        <?php $no=1 ;foreach($custom_fields as $key => $row) { ?>
        <tr>
            <?php if ($row->type == 'separator') { ?>
                <td colspan="2"><?= $row->name?></td>
            <?php } else { ?>
                <!-- <td width="5%"><?php echo $no; ?>.</td> -->
                <td><?= $row->name?></td>
            <?php } ?>
        </tr>
        <?php if ($row->type != 'separator') { ?>
            <tr>
                <?php
                    $data_report = array_filter($submission_report['category_report']->custom_field_report, function($report) use($row) {
                        return $report->id == $row->id;
                    });
                    $cf_value = array_values($data_report);
                    $value = $cf_value[0]->value_custom_fields;

                    if($row->type == 'multiselect') {
                        $decoded = json_decode($cf_value[0]->value_custom_fields, true);
                        $value = is_array($decoded) ? implode(', ', $decoded) : '';
                    }else if($row->type == 'multiple choice grid'){
                        $values = $cf_value[0]->value_custom_fields ? json_decode($cf_value[0]->value_custom_fields) : [];

                        $value = "";
                        $value.= "<table class='table' border='1'>";
                    
                        // creating header
                        $value.="<tr style='border: 2px solid #000'>";
                        $value.="<th></th>";
                    
                        // loop header based on custom fields variable 
                        $decode_column = $row->column_options ? json_decode($row->column_options) : [];
                        if($decode_column){
                            foreach($decode_column as $column_options){
                                $value.="<th style='text-align:center;'>$column_options</th>";
                            }
                        }
                        // end loop
                    
                        $value.="</tr>";

                        $decode_options = json_decode($row->options);
                        foreach ($decode_options as $options) {
                            $value.="<tr style='border: 2px solid #000'>";
                            $value.="<th>$options</th>";
                            // loop for radio button 
                            if($decode_column){
                                for($i=0;$i<count($decode_column);$i++){
                                    $data_column = $decode_column[$i];
                                    $checked = (is_array($values) && in_array("$options|$data_column", $values)) ? "checked" : "";
                            
                                    $is_in_group = "autosave";
                                    $onblur = $is_multiple ? "onblur='submission_onblur(this)' data-multiple-id='$options->multiple_file_id' data-multiple-step-id='$options->multiple_step_id'" : "";
                                    if($onblur){
                                        $is_in_group = "";
                                    }
                                    $name_options = $is_multiple ? 'options_'.$options.'_'.$options->multiple_file_id : 'options_'.$options;
                                    $class_name = $is_multiple ? 'multiple-choice-grid-multi' : 'multiple-choice-grid';

                                    $value.="<td style='text-align: center;'>";
                                    $value.= $checked ? "<span style='font-size:24px;color:#3a31e1;text-shadow:-1px -1px 0 #5b009f, 1px -1px 0 #5b009f,-1px  1px 0 #5b009f, 1px  1px 0 #5b009f;'>&#9899;</span>" : "";
                                    $value.="</td>";
                                }
                            }
                            $value.="</tr>";   
                        }

                        $value.= "</table>";
                        // echo '<pre>';print_r($value);die;
                    }
                ?>
                <!-- <td></td> -->
                <td class="answer" style="font-weight:normal;"><?= $value ?></td>
            </tr>
            <?php $no++; } ?>
        <?php } ?>
        
    </table>
    

    <script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
</body>

</html>