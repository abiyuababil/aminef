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
        display:inline-block;
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
    .progressbar li a{
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
    
</style>
<?php 
$text_color = "";
if($grantee_grant->status == STATUS_NEED_VERIFICATION){
    $text_color = "text-primary";
}elseif($grantee_grant->status == CURRENT_GRANTEE){
    $text_color = "text-success";
}elseif($grantee_grant->status == STATUS_REVISE){
    $text_color = "text-warning";
}
?>
<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header"><?php echo $title ?></h1>
        <h3 class="page-header <?= $text_color ?>"><strong><?php echo $grantee_grant->status_name ?></strong></h3>
    </div>
</div>
<div class="row">
    <div class="containt text-center">
        <ul class="progressbar">
            <?php foreach ($grants_step as $index => $step) : ?>
                <li id="li_step_<?= $index+1; ?>" onclick="reset_done(<?=$index+1; ?>, this)" data-id="step_<?= $index+1; ?>" class="<?php if($index == 0) {echo 'active done';} ?> stepper-list"><a data-toggle="tab" href="#step_<?= $index+1; ?>" aria-expanded="true" ><?= $step->name ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php if($grantee_grant->status == STATUS_REVISE){ ?>
        <div class="form-group mt-5">
            <label>Note</label>
            <textarea name="note" disabled id="note_submission" rows="5" class="form-control" width="100%"><?= $grantee_grant->note_submission ?></textarea>
        </div>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="tab-content">
        <?php foreach ($grants_step as $index => $step) : ?>
            <div id="step_<?= $index+1; ?>" class="tab-pane fade <?php if ($index == 0){echo 'active in';} ?>">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><?= $step->label; ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php foreach ($custom_fields[$step->id] as $row => $cf) { 
                                $disabled = '';
                                $display_upload = '';
                                if($this->Grantee_ent_model->status == CURRENT_GRANTEE){
                                    $disabled = 'disabled';
                                    $display_upload = 'none';
                                }    
                        ?>
                            <!-- template for others instead file template -->
                            <?php if ($cf->type != 'file') : ?>
                                <div class="row form-group">
                                    
                                    <?php if ($cf->type == 'separator') : ?>
                                        <div class="col-md-4 text-left"><b><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?></b></div>
                                    <?php elseif (in_array($cf->type, ['element group', 'education group', 'table schedule'])) : ?>
                                        <div class="col-md-12 text-left"><b><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?></b></div>
                                    <?php else: ?>
                                        <div class="col-md-4 text-left"><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?><?= label_required($cf->is_required); ?></div>
                                    <?php endif; ?>
                                    <div class="<?php echo in_array($cf->type, ['input', 'date', 'datetime', 'select', 'text', 'multiselect', NULL]) ? 'col-md-8' : 'col-md-12'; ?>">
                                        <?= get_component($cf, $disabled, $cf->value_custom_fields); ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <?php 
                                    $filename = get_filename_submission($cf); 
                                    $fileurl = get_fileurl_sumbission($cf); 
                                ?>
                                    <div class="col-lg-4">
                                        <label><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?></label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p class="filename" style="font-size:16px"><?= $filename ?></p>
                                            </div>
                                            <?php if($fileurl != ''){ 
                                                    $display_file = 'block'; 
                                                }else{
                                                    $display_file = 'none';
                                                }
                                            ?>
                                            <div class="col-lg-6">
                                                <img src="<?php echo base_url() ?>/img/loading.gif" class="submission-spinner" style="display:none;">
                                                <a href="<?= base_url($fileurl) ?>" class="fileview lightbox" style="display:<?= $display_file ?>">
                                                    <i class="fa fa-eye fa-fw fa-2x"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- <p class="filename" style="font-size:16px"><?= $filename ?></p> -->
                                        <?php if($this->Grantee_ent_model->status != $this->Grantee_ent_model->status_db->need_verification){ ?>
                                        <a href="javascript:;" class="btn btn-danger upload-button" data-file-value="my_file_<?= $cf->id?>" style="display:<?= $display_upload ?>">Upload</a>
                                        <?php } ?>
                                        <input type="file" data-category-id='<?= $cf->user_grantee_category_id; ?>' data-category-type='<?= $cf->user_grantee_category_type; ?>' data-grant-id='<?= $cf->user_grantee_grant_id; ?>' data-step='<?= $cf->user_grantee_step_id; ?>' data-id='<?= $cf->id; ?>' class="choosefile my_file_<?=$cf->id ?>" style="display: none;">
                                        <small class="file-for-testing">File Size Max 5MB</small>
                                        <hr>
                                    </div>
                            <?php endif; ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="progressbar">
                    <?php if ($index == 0): ?> 
                        <a aria-expanded="true" data-toggle="tab" href="#step_<?= $step->name + 1; ?>" class="btn btn-success next" onclick="next_step(<?= $step->name + 1; ?>)" style="float:right;margin-bottom:20px;width:100px;">Next</a>
                    <?php elseif ($index+1 == count($grants_step)): ?>
                        <a aria-expanded="true" data-toggle="tab" href="#step_<?= $step->name - 1; ?>" onclick="back_step(<?= $step->name - 1; ?>)" class="btn btn-primary" style="float:left;margin-bottom:20px;width:100px;">Back</a>
                        <?php if($this->Grantee_ent_model->status != $this->Grantee_ent_model->status_db->need_verification) { ?>
                        <a href="#submit" data-submit="form-submission" class="btn btn-success submit-submission" id="btn-submit" style="float:right;margin-bottom:20px;width:100px;display:<?= $display_upload ?>">Submit</a>
                        <?php } ?>
                    <?php else: ?>
                        <a aria-expanded="true" data-toggle="tab" href="#step_<?= $step->name - 1; ?>" onclick="back_step(<?= $step->name - 1; ?>)" class="btn btn-primary" style="float:left;margin-bottom:20px;width:100px;">Back</a>
                        <a aria-expanded="true" data-toggle="tab" href="#step_<?= $step->name + 1; ?>" onclick="next_step(<?= $step->name + 1; ?>)" class="btn btn-success next" style="float:right;margin-bottom:20px;width:100px;">Next</a>
                    <?php endif;?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- /.row -->


<div class="modal fade text-center" id="mdl_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to save?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('grantee/submission/save_submission/' . $this->Grantee_ent_model->id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>