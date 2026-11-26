<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
?>

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

    #table-report td {
        height: 80px;
        vertical-align: top;
        padding: 10px;
        font-weight: bold;
    }

    #table-report tr {
        margin-top: 20px;
    }

    .invalid-tooltip {
        position: absolute;
        top: auto;
        z-index: 5;
        display: none;
        max-width: 100%;
        padding: 0.5rem;
        margin-top: 0.1rem;
        font-size: 12px;
        line-height: 1;
        color: #fff;
        background-color: rgba(220, 53, 69, .8);
        border-radius: 0.2rem;
    }

    #delete-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }

    #success-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }
    
    .selected-preparation-n {
        display:none;
    }
    
    .selected-preparation-b {
        display:block;
    }

    .d-none-testing {
        display: none !important;
    }
</style>

<div class="row">
    <?php if(!isset($is_grantee)){ ?>
        <?php if(!$is_alumni_page) { ?>
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $title ?></h1>
        </div>
        <?php } ?>
    <?php }else{ ?>
        <div class="col-lg-12 text-center">
            <h2 style="color:#0089d1">Testing Score</h2>
            <h1 class="page-header"><?= $grantee_grant->grant_name ?></h1>
            <h2><?= $grantee_grant->status_name ?></h2>
        </div>
    <?php } ?>
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
<div class="alert alert-success" id="success-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Delete <strong>Success! </strong>
</div>
<div class="alert alert-danger" id="delete-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Delete <strong>Failed! </strong>
</div>

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">

    <?php if($is_admin) { ?>
    <div class="row warp-alumni-page">
        <div class="tab-content">
            <div id="general" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- <div class="panel-body">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>EEC Approval field</label><br />
                                    <a 
                                        href="<?= base_url($user_grantee_grant_period->eec_approval) ?>" 
                                        class="btn btn-success fileview lightbox" 
                                        style="color:#FFF;" 
                                        <?= $user_grantee_grant_period->eec_approval ? '' : 'disabled' ?>
                                    >
                                        <i class="fa fa-eye fa-fw"></i> Preview
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label>Short Bio Field</label>
                                    <textarea class="form-control" name="short_bio_field" rows="3"><?= $grantee_grant->short_bio_field ?></textarea>
                                </div>
                            </div>
                        </div> -->
                        <div class="panel-body">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>FSB Approval</label><br />
                                    <a 
                                        href="<?= base_url($user_grantee_grant_period->fsb_approval) ?>" 
                                        class="btn btn-success fileview lightbox" 
                                        style="color:#FFF;" 
                                        <?= $user_grantee_grant_period->fsb_approval ? '' : 'disabled' ?>
                                    >
                                        <i class="fa fa-eye fa-fw"></i> Preview
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Final Online Application IIE</label>
                                    <?php if($grantee_grant->final_online_application_iie) : ?>
                                        <a href=<?= base_url($grantee_grant->final_online_application_iie) ?> class="btn btn-success lightbox" style="margin-bottom:3px">View</a>
                                        <a href=<?= base_url('admin/nominee/general_nominee/delete_file/eec/'.$grantee_grant->id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
                                    <?php endif; ?>
                                    <input type="file" name="final_online_application" class="form-control file-for-testing">
                                    <small class="file-for-testing">File Size Max 5MB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>


    <?php if(!$is_alumni_page) { ?>
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px;">
            <div style="margin-bottom:10px;" class="pull-right">
                <?php if (!isset($is_grantee)) { ?>
                    <a href="<?= $back_url ?>" class="btn btn-primary mr-2" style="float:left;">Back</a>
                <?php } ?>
                <button type="submit" id="btn-submit" class="btn btn-success btn-submit" name="btn-submit" value="save">Save</button>
            </div>
        </div>
    </div>
    <?php } ?>
</form>
