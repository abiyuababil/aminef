<style>
    .containt {
        margin: 0px auto 30px auto;
    }

    .progressbar {
        counter-reset: step;
        margin: 0px;
        padding: 0px;
    }

    .select2-container {
        width: 100% !important;
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

    .progressbar li.done {
        color: white;
        background-color: #0089d1;
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

    .progressbar li.active+li:after {
        background-color: #55b776;
    }

    .display {
        display: none;
    }

    .no-padding{
        padding: 0px !important;
    }

    .text-white {
        color: white;
    }

    .btn-download-guide {
        position: absolute;
        top: 106px;
        right : 0;
        width : 150px;
    }

    /* .btn-recommended {
        position: absolute;
        top: 106px;
        right : 155px;
        width : 150px;
    }

    .btn-download-form {
        position: absolute;
        top: 147px;
        right : 0;
        width : 150px;
    } */

    input[type='radio'] {
        -webkit-appearance:none;
        width:15px;
        height:15px;
        border:1px solid #b455fb;
        border-radius:50%;
        outline:none;
    }
    input[type='radio']:hover {
        box-shadow:0 0 5px 0px orange inset;
    }
    input[type='radio']:before {
        content:'';
        display:block;
        width: 55%;
        height: 55%;
        margin: 25% auto;
        border-radius: 50%;    
    }
    input[type='radio']:checked:before {
        background:blue;
    }
    .font-weight-bold {
        margin-top: 5px;
    }

    .span-note a {
        color: #0000ff;
    }
</style>
<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1"><?= $detail_data['detail']->name ?></h2>
        <h1 class="page-header"><?php echo $title ?></h1>
        <?php 
            $grantee_setting = get_row_db('am_grantee_setting', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);
        ?>
        <?php if ($grantee_setting && !empty($grantee_setting->home_institution)) { ?>
            <div class="text-center"><h4>Home Institution : <?php echo $grantee_setting->home_institution; ?></h4></div>
        <?php } ?>
        <?php if (isset($detail_data['grantee_setting']) && $this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
            <div class="text-center text-sm-center">Grant Period : <?= $detail_data['grantee_setting']->start_date ? date('d M Y', strtotime($detail_data['grantee_setting']->start_date)) : '' ?> - <?= $detail_data['grantee_setting']->end_date ? date('d M Y', strtotime($detail_data['grantee_setting']->end_date)) : '' ?></div>
        <?php } ?>
        <?php
        $document_status = '';
        $note_document = '';
        if ($category->name == 'Grant Information' || $category->name == 'Grant Profile') {
            $document_status = $detail_data['detail_grantee_grant']->grant_document_status_name;
            $note_document = $detail_data['detail_grantee_grant']->note_grant_document;
        } elseif ($category->name == 'Permit Application' || $category->name == 'Pre Arrival Documents') {
            $document_status = $detail_data['detail_grantee_grant']->pre_arrival_document_status_name;
            $note_document = $detail_data['detail_grantee_grant']->note_pre_arrival_document;
        } elseif ($category->name == 'Permit Documents') {
            $document_status = $detail_data['detail_grantee_grant']->permit_papers_status_name;
            $note_document = $detail_data['detail_grantee_grant']->note_permit;
        } elseif ($category->name == 'Indonesian Host Information') {
            $document_status = $detail_data['detail_grantee_grant']->indonesian_host_information_status_name;
            $note_document = $detail_data['detail_grantee_grant']->note_indonesian_host_information;
        } elseif ($category->name == 'Application') {
            $document_status = $detail_data['detail_grantee_grant']->status;
            if ($document_status == STATUS_SELECTION_REVISED || $document_status == STATUS_SELECTION_DECLINED) {
                $document_status = 'Need revision';
            } else {
                $document_status = '';
            }
            $note_document = $detail_data['detail_grantee_grant']->note_selection;
        } elseif ($category->name == 'Nominee') {
            $document_status = $detail_data['detail_grantee_grant']->status;
            if ($document_status == STATUS_CANDIDATE_REVISED || $document_status == STATUS_CANDIDATE_DECLINED) {
                $document_status = 'Need revision';
            } else {
                $document_status = '';
            }
            $note_document = $detail_data['detail_grantee_grant']->note_candidate;
        } elseif ($category->name == 'On Going') {
            $document_status = $detail_data['detail_grantee_grant']->status;
            if ($document_status == STATUS_ON_GOING_REVISED) {
                $document_status = 'Need revision';
            } else {
                $document_status = '';
            }
            $note_document = $detail_data['detail_grantee_grant']->note_ongoing;
        } elseif ($category->name == 'Returning') {
            $document_status = $detail_data['detail_grantee_grant']->status;
            if ($document_status == STATUS_RETURNING_REVISED) {
                $document_status = 'Need revision';
            } else {
                $document_status = '';
            }
            $note_document = $detail_data['detail_grantee_grant']->note_returning;
        } else {
            $document_status = $detail_data['detail_grantee_grant']->report_status_name;
            $note_document = $detail_data['detail_grantee_grant']->note_report;
        }
        ?>
        <?php 
            $status_reject = [
                STATUS_NEW_SELECTION_DECLINED,
                STATUS_NEW_SELECTION_WITHDRAW,
                STATUS_REVIEW_REJECT,
                STATUS_INTERVIEW_REJECT];
            if(!in_array($detail_data['detail_grantee_grant']->status, $status_reject)) {
        ?>
        <?php 
            $status_name = $detail_data['detail_grantee']->status_name;
            $is_hidden = ($status_name == 'Revise' && $detail_data['detail_grantee_grant']->is_release) ? 'hide' : '';
            
            // Transform status name display
            if ($status_name == 'In Progress') {
                $display_status = 'In Progress';
            } elseif ($status_name == 'On Going') {
                $display_status = 'Ongoing';
            } else {
                $display_status = $status_name;
            }
        ?>
        <!-- <h2 class="<?= $is_hidden ?>"><?= $display_status ?></h2> -->
        <?php } ?>

        <?php if($grantee_grant->country_id == INDONESIAN_DATABASE) : ?>
        <div class="text-right" style="margin-bottom: 5px;">
            <?php if(!empty($recommenders)) { ?>
            <button type="button" data-id="<?= $grantee_grant->id ?>" class="btn btn-primary btn-recommended" href="<?= base_url($active_grant->guide) ?>">Recommender Status</button>
            <?php } ?>
            <?php if($active_grant->guide != '') { ?>
                <a class="btn btn-info btn-guide" download title="Click to Download" href="<?= base_url($active_grant->guide) ?>">Download Guide</a>
            <?php } ?>
        </div>
        <?php endif; ?>
        <?php if($active_grant->form_ofline != '') { ?>
        <!-- <a class="btn btn-info btn-download-form" download itle="Click to Download" href="<?= base_url($active_grant->form_ofline) ?>">Download Form</a> -->
        <?php } ?>
        <?php
        $check_submission = get_row_db('am_user_grantee_submission', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);
        if ($detail_data['detail_grantee_grant']->status == STATUS_NEW_SELECTION && $check_submission) { ?>
                <h3 class="alert alert-success">Submitted</h3>
        <?php } ?>
        <?php if ($document_status == 'Need revision' && !$detail_data['detail_grantee_grant']->is_release && $grantee_grant->country_id == INDONESIAN_DATABASE) { ?>
                <h4 class="text-left">Note : </h4>
                <div class="alert alert-warning" role="alert" style="height:auto">
                    <h4 class="alert-heading text-left"><?= $note_document ?></h4>
                </div>
        <?php } ?>
    </div>
</div>

<?php if ($block_access) { ?>
        <!-- ALERT -->
        <div class="row">
            <div class="alert alert-danger text-center" role="alert" style="height:200px">
                <?php if (isset($block_message)) { ?> 
                    <h4 class="alert-heading" style="margin-top:70px;"><?= $block_message ?></h4>
                <?php } else { ?>
                    <h4 class="alert-heading" style="margin-top:70px;">You do not have access to this page yet.</h4>
                <?php } ?>
                <?php if (isset($link_helper)) { ?>
                    <a href="<?= $link_helper ?>" class="btn btn-primary">
                        <?php if (isset($link_helper_text)) { ?>
                            <?= $link_helper_text ?>
                        <?php } else { ?>
                            Click Here
                        <?php } ?>
                    </a>
                <?php } ?>
            </div>
        </div>
        <!-- END ALERT -->
<?php } else { ?>
        <!-- Submission view render conponent -->
        <?= $this->load->view('component/submission_view_global', [
            'data_step' => $detail_data['step'],
            'is_admin' => false,
            'userGranteeId' => $this->session->userdata('grantee_user_id'),
            'granteeGrantId' => $this->session->userdata('grantee_grant_id'),
            'activeCountry' => $is_preview ? $this->session->userdata('active_country') : $this->session->userdata('grantee_active_country')
        ], true); ?>
<?php } ?>


<?php $this->load->view('admin/partials/modal_recommendation_status') ?>
