<?php
$default_tab_active = 'active';
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
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $title ?></h1>
        </div>
    <?php }else{ ?>
        <div class="col-lg-12 text-center">
            <h2 style="color:#0089d1">Placement</h2>
            <h1 class="page-header"><?= $grantee_grant->grant_name  . ' (' . $grantee_grant->fiscal_year_period.')' ?></h1>
            <!-- <h2><?= $grantee_grant->status_name ?></h2> -->
        </div>
    <?php } ?>
</div>
<?php //echo '<pre>';print_r($this->session->userdata());die;?>
<!-- <form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data"> -->
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px">
            <?php if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success alert-dismissable text-justify">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php } ?>
            <?php $this->session->unset_userdata('success');?>
            <ul class="nav nav-pills">
                <?php 
                    $nomine_menu_grantee = $grantee_grant->nominee_menu ? explode(",", $grantee_grant->nominee_menu) : [];
                    if(empty($nomine_menu_grantee)){
                        $nomine_menu_grantee = array_keys($nominee_menu_master);
                    }

                    // show hide tab 
                    $submission_plan_display = $submission_result_display = in_array("submission_plan", $nomine_menu_grantee) && $submission_plans;
                    // $is_grantee_non_degree_result = in_array("submission_result", $nomine_menu_grantee) && !$grantee_grant->is_degree;
                    // $direct_application_display = in_array("direct_application", $nomine_menu_grantee) && $direct_applications;
                    // echo '<pre>';print_r($grantee_grant);die;
 
                ?>
                <?php if($submission_plan_display && !$grantee_grant->hide_menu_submission_plan) { ?>
                    <li class="li-final <?= $this->session->userdata('last_tab_placement') == '' ? ($grantee_grant->is_final_placement ? ($submission_plans ? $default_tab_active : '') : $default_tab_active) : '' ?>" id="li-submission_plan"><a data-toggle="tab" href="#submission_plan" aria-expanded="true">Submission Plan</a></li>
                <?php } ?>
                <?php if((in_array("direct_application", $nomine_menu_grantee) && $submission_plan_display && !$grantee_grant->hide_menu_direct_application) || $grantee_grant->show_direct_application) { ?>
                    <li class="li-final <?= $grantee_grant->hide_menu_submission_plan || ($grantee_grant->show_direct_application && !$submission_plan_display) ? $default_tab_active : ''; ?>" id="li-direct_application" <?= in_array("direct_application", $nomine_menu_grantee) ?>><a data-toggle="tab" href="#direct_application" aria-expanded="true">Direct Application</a></li>
                <?php } ?>
                <?php if((in_array("submission_result", $nomine_menu_grantee) && !$grantee_grant->hide_menu_submission_result) || $grantee_grant->show_direct_application) { ?>
                    <?php if(!$grantee_grant->is_degree || $submission_plans || $grantee_grant->show_direct_application) { ?>
                        <?php
                            $is_active_sub_result = $this->session->userdata('last_tab_placement') == 'submission_result' || (!$grantee_grant->is_degree && empty($this->session->userdata('last_tab_placement')));
                        ?>
                        <li class="li-final <?= $is_active_sub_result ? $default_tab_active : '' ?>" id="li-submission_result"><a data-toggle="tab" href="#submission_result" aria-expanded="true">Submission Result</a></li>
                    <?php } ?>
                <?php } ?>
                <?php if($grantee_grant->submission_result_id || $grantee_grant->is_final_placement) { ?>
                    <li class="li-final <?= (($grantee_grant->is_final_placement && !$is_grantee_non_degree_result) && !$submission_plan_display) || $this->session->userdata('last_tab_placement') == 'final_placement' ? $default_tab_active : '' ?>" id="li-final_placement"><a data-toggle="tab" href="#final_placement" aria-expanded="true">Final Placement</a></li>
                <?php } ?>
                <?php if($grantee_grant->submission_result_id || $grantee_grant->is_final_placement  || $toa_pre_academic_file || $toa_placement_file) { ?>
                    <li class="li-final <?= $this->session->userdata('last_tab_placement') == 'grant_document' ? $default_tab_active : '' ?>" id="li-grant_document"><a data-toggle="tab" href="#grant_document" aria-expanded="true">Grant Document</a></li>
                <?php } ?>
            </ul>
        </div>

        <div class="tab-content">
            <?php if($submission_plan_display && !$grantee_grant->hide_menu_submission_plan) { ?>
            <div id="submission_plan" class="tab-pane first fade <?= $submission_plan_display && !$grantee_grant->hide_menu_submission_plan && $this->session->userdata('last_tab_placement') == '' ? $default_content_active : '' ?>">
                <?php $this->load->view('grantee/profile/submission_plan') ?>
            </div>
            <?php } ?>

            <?php if((in_array("direct_application", $nomine_menu_grantee) && $submission_plan_display && !$grantee_grant->hide_menu_direct_application) || $grantee_grant->show_direct_application) { ?>
            <div id="direct_application" class="tab-pane fade <?= $grantee_grant->hide_menu_submission_plan || ($grantee_grant->show_direct_application && !$submission_plan_display) ? $default_content_active : '' ?>">
                <?php $this->load->view('grantee/profile/direct_application') ?>
            </div>
            <?php } ?>

            <?php if((in_array("submission_result", $nomine_menu_grantee) && !$grantee_grant->hide_menu_submission_result) || $grantee_grant->show_direct_application) { ?>
            <?php if(!$grantee_grant->is_degree || $submission_plans || $grantee_grant->show_direct_application) { ?>
            <?php
                $is_active_sub_result_content = $this->session->userdata('last_tab_placement') == 'submission_result' || (!$grantee_grant->is_degree && empty($this->session->userdata('last_tab_placement')));
            ?>
            <div id="submission_result" class="tab-pane fade <?= $is_active_sub_result_content ? $default_content_active : '' ?>">
                <?php 
                if (!$grantee_grant->is_degree) {
                    $this->load->view('grantee/profile/submission_result_non_degree');
                } else {
                    $this->load->view('grantee/profile/submission_result_v2');
                }
                ?>
            </div>
            <?php } ?>
            <?php } ?>

            <?php if($grantee_grant->submission_result_id || $grantee_grant->is_final_placement) { ?>
            <div id="final_placement" class="tab-pane fade <?= (($grantee_grant->is_final_placement && !$is_grantee_non_degree_result) && !$submission_plan_display) || $this->session->userdata('last_tab_placement') == 'final_placement' ? $default_content_active : '' ?>">
                <?php $this->load->view('grantee/profile/final_placement') ?>
            </div>
            <?php } ?>

            <?php if($grantee_grant->submission_result_id || $grantee_grant->is_final_placement || $toa_pre_academic_file || $toa_placement_file) { ?>
            <div id="grant_document" class="tab-pane fade <?= $this->session->userdata('last_tab_placement') == 'grant_document' ? $default_content_active : '' ?>">
                <?php $this->load->view('grantee/profile/final_placement_grant_document') ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px;">
            <div style="margin-bottom:10px;">
                <?php if (!isset($is_grantee)) { ?>
                    <a href="<?= site_url('admin/grantee/manage') ?>" class="btn btn-primary" style="float:left;">Back</a>
                    <button type="submit" id="btn-submit" class="btn btn-success btn-submit" name="btn-submit" value="save" style="float:right;">Save</button>
                <?php } ?>
            </div>
        </div>
    </div>
<!-- </form> -->

<?php $this->session->unset_userdata('last_tab_placement'); ?>
<?php $this->session->unset_userdata('last_list_placement'); ?>
