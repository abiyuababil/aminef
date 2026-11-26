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
</style>

<div class="row">
    <div class="col-lg-12">
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

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="<?= $grantee_grant->user_grantee_id ?>" id="grantee_id">
    <input type="hidden" value="<?= $category->name ?>" id="document">
    <div class="row">


        <div class="tab-content warp-alumni-page">
            <div id="user-program-<?= $up->id ?>" class="tab-pane fade active in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12" style="margin-bottom:10px">
                            <h2 class="text-center"><?= $category->name ?></h2>
                            <?php 
                                $grantee_setting = get_row_db('am_grantee_setting', ['grantee_grant_id' => $grantee_grant->id]);
                            ?>
                            <?php if ($grantee_setting && !empty($grantee_setting->home_institution)) { ?>
                                <div class="text-center"><h4>Home Institution : <?php echo $grantee_setting->home_institution; ?></h4></div>
                            <?php } ?>
                            <div class="text-center text-sm-center">Grant Period : <?= $grantee_grant->start_date ? date('d M Y', strtotime($grantee_grant->start_date)) : '' ?> - <?= $grantee_grant->end_date ? date('d M Y', strtotime($grantee_grant->end_date)) : '' ?></div>
                            <?php
                            $permit_papers_status_name = $grantee_grant->permit_papers_status_name != '' ? ' - ' . $grantee_grant->permit_papers_status_name : '';
                            $report_status_name = $grantee_grant->report_status_name != '' ? ' - ' . $grantee_grant->report_status_name : '';
                            $note_document = $category->name == 'Permit Documents' ? $grantee_grant->note_permit : $grantee_grant->note_report;
                            ?>
                            <h3 class="text-center"><?= $grantee_grant->status_name ?> <?= $category->name == 'Post Arrival Documents' ? $permit_papers_status_name : $report_status_name ?></h3>
                        </div>
                    </div>

                    <!-- Submission view render conponent -->
                    <?= $this->load->view('component/submission_view_global', [
                        'data_step' => $grants_step,
                        'is_admin' => true,
                        'userGranteeId' => $grantee_grant->user_grantee_id,
                        'granteeGrantId' => $grantee_grant->id,
                        'activeCountry' => $this->session->userdata('active_country')
                    ], true); ?>
                </div>
            </div>
        </div>
    </div>
</form>