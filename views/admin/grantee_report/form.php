    <?php

$active_country = $this->session->userdata('active_country');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
    td {
        height: 80px;
        vertical-align: top;
        padding:10px;
        font-weight:bold;
    }
    tr {
        margin-top:20px;
    }
</style>

<div class="modal"></div>

<div class="row">
    <div class="col-lg-12">
        <?php 
            $disabled = '';
            $display  = 'none';
            $explode = explode('/', current_url());
            $url = end($explode);
            if($url != 'add'){
                $disabled = 'disabled';
                $display = 'block';
            }
        ?>
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>

<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="col-lg-12">
        <div class="panel-body">
            <div class="col-lg-4">
                <div class="form-group">    
                    <label>Choose Grants</label>
                    <select class="form-control" id="grants" name="grants" onchange="submit_report()" <?= $disabled ?>>
                        <option value="">-- Choose Grants --</option>
                        <?php
                        if ($program_available) {
                            foreach ($program_available as $program) {
                                $selected = '';
                                if ($report_mid[0]['grant_id'] == $program->id) {
                                    $selected = 'selected="selected"';
                                }
                                ?>
                                <option value="<?= $program->id ?>" <?= $selected ?>><?= $program->name ?></option>
                            <?php
                        }
                    }
                    ?>
                    </select>
                    <?php if($report_mid[0]['grant_id']) { ?>
                        <input type="hidden" value="<?= $report_mid[0]['grant_id'] ?>" name="grants">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="display:<?= $display ?>" id="content_">
        <div class="col-lg-12" style="margin-bottom:10px">
            <ul class="nav nav-pills">
                <li <?php echo $default_tab_active ?>><a data-toggle="tab" href="#mid" aria-expanded="true">Mid Term Report</a></li>
                <li><a data-toggle="tab" href="#final" aria-expanded="true">Final Term Report</a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div id="mid" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Information</label>
                                    <textarea class="form-control" rows="4" name="information_mid"><?= $report_mid[0]['information'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="wrap-description">
                                <?php if($report_mid) { 

                                    foreach ($report_mid as $key => $value) {
                                        $delete_desc = '<a href="javascript:;" id="'.$value['id'].'" onclick="del_item(this, \'description-item\')"><i class="fa fa-trash fa-fw fa-1x"></i></a>';
                                ?>
                                    <div id="description-item-0" class="description-item">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>
                                                    Description <?= ($key+1) ?>
                                                    <?= $delete_desc ?>
                                                    <a href="javascript:;" onclick="add_sub_description(<?= $key ?>)" class="btn btn-primary btn-xs"><i class="fa fa-plus fa-fw fa-1x"></i> add sub</a>
                                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;">
                                                </label>
                                                <textarea class="form-control" rows="4" name="description_mid[<?= $key ?>][desc]"><?= $value['description'] ?></textarea>
                                                <input type="hidden" value="<?= $value['id'] ?>" name="description_mid[<?= $key ?>][desc_id]">
                                                <input type="hidden" value="<?= $value['is_mid'] ?>" name="description_mid[<?= $key ?>][is_mid]">
                                            </div>
                                        </div>
                                        <div id="wrap-sub-description<?= $key ?>">
                                        <?php if(!empty($value['sub'])) { 
                                            foreach ($value['sub'] as $k => $val) {
                                                $delete_sub  = '<a href="javascript:;" id="'.$val['id'].'" onclick="del_item_sub(this, \'sub-description-item\')"><i class="fa fa-trash fa-fw fa-1x"></i></a>';
                                        ?>
                                            <div id="sub-description-item-<?= $k ?>" class="sub-description-item mt-3" style="margin-bottom:5px;">
                                                <div class="col-lg-11 col-lg-offset-1">
                                                    <label>
                                                        Sub Description
                                                        <?= $delete_sub ?>
                                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;">
                                                    </label>
                                                    <textarea class="form-control" rows="4" name="description_mid[<?= $key ?>][sub][<?= $k ?>][sub_description]"><?= $val['sub_description'] ?></textarea>
                                                    <input type="hidden" value="<?= $val['id'] ?>" name="description_mid[<?= $key ?>][sub][<?= $k ?>][sub_desc_id]">
                                                </div>
                                            </div>
                                        <?php } } ?>
                                        </div>
                                    </div>
                                <?php }}?>
                            </div>
                        </div>
                        <div class="panel-body" style="margin-top:-30px;">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="javascript:;" onclick="add_description()" class="btn btn-primary" style="margin-top:24px;"><i class="fa fa-plus fa-fw"></i> Add Description</a>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="radio d-inline mr-4">
                                    <label><input type="radio" class="grant-alumni" name="status_mid" style="margin-top:1px" value="1" checked>Active</label>
                                </div>
                                <div class="radio d-inline">
                                    <label><input type="radio" class="grant-alumni" name="status_mid" style="margin-top:1px" value="0">Non Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="final" class="tab-pane fade">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Information</label>
                                    <textarea class="form-control" rows="4" name="information_final"><?= $report_final[0]['information'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="wrap-description-final">
                                <?php if($report_final) { 
                                    foreach ($report_final as $key => $value) {
                                        $delete_desc = '<a href="javascript:;" id="'.$value['id'].'" onclick="del_item(this, \'description-item\')"><i class="fa fa-trash fa-fw fa-1x"></i></a>';
                                ?>
                                    <div id="description-final-item-0" class="description-final-item">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>
                                                    Description <?= ($key+1) ?> 
                                                    <?= $delete_desc ?>
                                                    <a href="javascript:;" onclick="add_sub_description_final(<?= $key ?>)" class="btn btn-primary btn-xs"><i class="fa fa-plus fa-fw fa-1x"></i> add sub</a>
                                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;">
                                                </label>
                                                <textarea class="form-control" rows="4" name="description_final[<?= $key ?>][desc]"><?= $value['description'] ?></textarea>
                                                <input type="hidden" value="<?= $value['id'] ?>" name="description_final[<?= $key ?>][desc_id]">
                                                <input type="hidden" value="<?= $value['is_mid'] ?>" name="description_final[<?= $key ?>][is_mid]">
                                            </div>
                                        </div>
                                        <div id="wrap-sub-description-final<?= $key ?>">
                                        <?php if(!empty($value['sub'])) { 
                                            foreach ($value['sub'] as $k => $val) {   
                                                $delete_sub  = '<a href="javascript:;" id="'.$val['id'].'" onclick="del_item_sub(this, \'sub-description-item\')"><i class="fa fa-trash fa-fw fa-1x"></i></a>';
                                        ?>
                                            <div id="sub-description-item-<?= $k ?>" class="sub-description-item mt-3" style="margin-bottom:5px;">
                                                <div class="col-lg-11 col-lg-offset-1">
                                                    <label>
                                                        Sub Description
                                                        <?= $delete_sub ?>
                                                        <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;">
                                                    </label>
                                                    <textarea class="form-control" rows="4" name="description_final[<?= $key ?>][sub][<?= $k ?>][sub_description]"><?= $val['sub_description'] ?></textarea>
                                                    <input type="hidden" value="<?= $value['id'] ?>" name="description_final[<?= $key ?>][sub][<?= $k ?>][sub_desc_id]">
                                                </div>
                                            </div>
                                        <?php }} ?>
                                        </div>
                                    </div>
                                <?php }}?>
                            </div>
                        </div>
                        <div class="panel-body" style="margin-top:-30px;">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="javascript:;" onclick="add_description_final()" class="btn btn-primary" style="margin-top:24px;"><i class="fa fa-plus fa-fw"></i> Add Description</a>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="radio d-inline mr-4">
                                    <label><input type="radio" class="grant-alumni" name="status_final" style="margin-top:1px" value="1" checked>Active</label>
                                </div>
                                <div class="radio d-inline">
                                    <label><input type="radio" class="grant-alumni" name="status_final" style="margin-top:1px" value="0">Non Active</label>
                                </div>
                            </div>
                        </div>
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
                    <a href="<?= site_url('admin/grantee/manage') ?>" class="btn btn-primary" style="float:left;">Back</a>
                    <button id="btn-submit" class="btn btn-success" style="float:right;">Save</button>
                </div>
            </div>

        </div>
    </div>
</form>
<input type="hidden" name="delete_desc" id="delete_desc">
<input type="hidden" name="delete_sub" id="delete_sub">