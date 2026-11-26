<?php

$active_country = $this->session->userdata('active_country');
$number_alfa = range('a', 'z');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
    .select2 {
        width:100% !important;
    }
</style>

<div class="modal"></div>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center"><?php echo $title ?></h1>
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

<?php if($category_report) { ?>
<form id="form" method="POST" enctype="multipart/form-data">
    <div class="row">

        <div class="tab-content">
            <div id="report" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <input type="hidden" name="user_grantee_category_report_id" id="user_grantee_category_report_id">
                        <?php 
                        
                            foreach($category_report as $key => $categoryR) { 
                                $dateNow = date('Y/m/d');
                                $report_date = isset($categoryR->report_date) && $categoryR->report_date ? date('Y/m/d', strtotime($categoryR->report_date)) : '';
                                $report_end_date = isset($categoryR->report_end_date) ? date('Y/m/d', strtotime($categoryR->report_end_date)) : '';
                                $disabled = $report_end_date < $dateNow ? 'disabled' : '';
                            
                                if($report_date > $dateNow || $categoryR->status == 'accept' || $categoryR->status == 'submited') {
                                    $disabled = 'disabled';
                                }
                        ?>
                        <div class="panel panel-default" <?= $report_date > $dateNow ? 'style="display:none"' : '' ?>>
                            <div class="panel-heading text-left" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $categoryR->id?>" aria-expanded="true" aria-controls="collapse<?= $categoryR->id?>">
                                        <?php 
                                            if($categoryR->status == 'submited'){
                                                $status = 'Waiting for Accept';
                                                $text_color = 'text-warning';
                                            }elseif($categoryR->status == 'accept'){
                                                $status = '<i class="fa fa-check-circle"></i> Accepted';
                                                $text_color = 'text-success';
                                            }elseif($categoryR->status == 'revisi'){
                                                $status = 'Revise';
                                                $text_color = 'text-danger';
                                            }else{
                                                $status = '';
                                            }
                                        ?>
                                        <?= $categoryR->name ?> <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span> <span style="float:right;font-weight:bold;" class="<?= $text_color ?>"><?= $status ?></span> 
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?= $categoryR->id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <?php if(!empty($categoryR->report_date) || $is_preview) { ?>
                                    <?php if($categoryR->is_template == 1 && !empty($categoryR->custom_field_report) ) { ?>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Upload Report</label>
                                                    <?php if(!$disabled) { ?>
                                                    <input type="file" class="form-control" name="file_report_<?= $categoryR->id ?>">
                                                    <small class="file-for-testing">File Size Max 5MB</small>
                                                    <?php } ?>
                                                    <?php if($categoryR->report_file != '') { ?>
                                                        <br>
                                                        <img 
                                                            height="100"
                                                            src="<?php echo get_preview($categoryR->report_file); ?>"
                                                        >
                                                        <a href="<?= base_url($categoryR->report_file) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute;">
                                                            <i class="fa fa-download fa-fw text-white"></i>
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <a 
                                                        href="<?= base_url('grantee/report/download_report/'.$grantee->id.'/'.$categoryR->id) ?>" 
                                                        class="btn btn-success" 
                                                        style="float:right;"
                                                        target="_blank"
                                                        <?= $is_preview ? 'disabled="disabled"' : '' ?>
                                                    >
                                                        Download Template Report
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="panel-body" style="border:0px;">
                                        <h3 class="text-center"><?= $programs[$grantee_grant->grant_id]->name ?></h3>
                                        <div style="font-weight:bold;"><?= $categoryR->information ?></div>
                                        <div class="mt-5">
                                            <?php 
                                                $no = 1;
                                                foreach($categoryR->custom_field_report as $key => $cf) {    
                                                    // echo '<pre>';print_r($cf);die;
                                            ?>
                                            <!-- template for others instead file template -->
                                            <?php if ($cf->type != 'file') : ?>
                                                <div class="row form-group">
                                                    <?php if ($cf->type == 'separator') : ?>
                                                        <div class="col-md-5 text-left">
                                                            <b><?= url_text($cf->name); ?></b>
                                                            <?php if($cf->description_file != '' ) { ?>
                                                            <div class="row mt-2 text-danger pl-4">
                                                                <em style="font-size: 12px !important; margin-left: 25px;"><?= url_text($cf->description_file) ?></em>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <!-- <div class="col-md-1 text-left" style="font-weight:bold"><?= $no ?>.</div> -->
                                                        <div class="col-md-4 text-left custom-field-section-<?php echo $cf->id; ?>">
                                                            <?= url_text($cf->name); ?><?= label_required($cf->is_required); ?>
                                                            <?php if($cf->description_file != '' ) { ?>
                                                            <div class="row mt-2 text-danger pl-4">
                                                                <em style="font-size: 12px !important; margin-left: 25px;"><?= url_text($cf->description_file) ?></em>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <?php $no++; ?>
                                                    <?php endif; ?>
                                                    <div class="col-md-7">
                                                        <?= get_component($cf, $disabled, $cf->value_custom_fields); ?>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="col-lg-4">
                                                    <label><?= url_text($cf->name); ?></label>
                                                    <p id="file_name1" style="font-size:16px">No file chosen</p>
                                                    <a href="javascript:;" class="btn btn-danger" id="btn-upload1">Upload</a>
                                                    <input type="file" id="my_file1" style="display: none;">
                                                    <small class="file-for-testing">File Size Max 5MB</small>
                                                    <hr>
                                                </div>
                                            <?php endif; ?>

                                            <input <?= $disabled ?> type="hidden" name="user_grantee_grant_id" value="<?= $cf->user_grantee_grant_id ?>">
                                            <input <?= $disabled ?> type="hidden" name="user_grantee_category_type" value="<?= $cf->user_grantee_category_type ?>">

                                            <?php } ?>
                                        </div>
                                        <hr>
                                        <div class="panel-body">
                                            <?php if($categoryR->note != '') { ?>
                                            <div class="col-lg-12 mb-3">
                                                <div class="form-group">
                                                    <label>Note</label>
                                                    <textarea disabled class="form-control" rows="4" id="note<?= $categoryR->report_id ?>"><?= $categoryR->note ?></textarea>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if(!empty($categoryR->custom_field_report)) { ?>
                                            <?php if($categoryR->status == 'not_submit' ||  $categoryR->status == 'revisi' ||  $categoryR->status == '') { ?>
                                            <div class="col-lg-12" style="margin-bottom:10px;">
                                                <div style="margin-bottom:10px;float:right;">
                                                    <!-- <button type="submit" id="btn-save" class="btn btn-success" name="btn" value="save">Save</button> -->
                                                    <button type="button" id="btn-submit" data-category_id="<?= $cf->user_grantee_category_report_id ?>" data-form_id="collapse<?= $categoryR->id?>" class="btn btn-primary btn-submit" <?= $is_preview ? 'disabled="disabled"' : '' ?> name="btn" value="submit">Submit</button>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php }else{ ?>
                                    <div style="padding:10px;">
                                        <p><?= $categoryR->name?> is not available now</p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php }else{ ?>
<!-- ALERT -->
<div class="row">
    <div class="alert alert-danger text-center" role="alert" style="height:200px">
        <h4 class="alert-heading" style="margin-top:70px;">You do not have access to this page yet.</h4>
    </div>
</div>
<!-- END ALERT -->
<?php } ?>




<div class="modal fade text-center" id="mdl_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to Submit Report ?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <button type="button" id="btn-yes" class="btn btn-success success">Yes</button>
            </div>
        </div>
    </div>
</div>