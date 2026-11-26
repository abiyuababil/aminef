<?php
$display_name = trim((string) $this->session->userdata('grantee_full_name'));
$initials = '';

if ($display_name !== '') {
    $name_parts = preg_split('/\s+/', $display_name);
    $name_parts = array_values(array_filter($name_parts));

    foreach (array_slice($name_parts, 0, 2) as $name_part) {
        $initials .= strtoupper(substr($name_part, 0, 1));
    }

    if ($initials === '') {
        $initials = strtoupper(substr($display_name, 0, 2));
    }
}

if ($initials === '') {
    $initials = 'G';
}
?>
<style>
    .grantee-navbar-main {
        align-items: center;
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        min-height: 71px;
        padding: 0 15px;
    }

    .grantee-navbar-main .navbar-header {
        align-items: center;
        display: flex;
        flex: 0 0 auto;
        float: none;
        min-height: 0;
    }

    .grantee-navbar-main .navbar-toggle {
        margin: 0 12px 0 0;
    }

    .grantee-navbar-main .grantee-branding {
        align-items: center;
        display: inline-flex;
        gap: 22px;
        margin-left: 18px;
    }

    .grantee-navbar-main .grantee-branding img {
        display: block;
        height: auto;
        position: static;
    }

    .grantee-navbar-main .grantee-branding img:first-child {
        width: 120px;
    }

    .grantee-navbar-main .grantee-branding img:last-child {
        width: 170px;
    }

    .grantee-navbar-main .navbar-top-links {
        align-items: center;
        display: flex;
        flex: 0 0 auto;
        float: none !important;
        margin: 0 0 0 auto;
    }

    .grantee-navbar-main .navbar-top-links > li {
        align-items: center;
        display: flex;
    }

    .grantee-navbar-main .user-menu-toggle {
        align-items: center;
        border-radius: 8px;
        display: flex;
        gap: 12px;
        padding: 10px 0 10px 14px;
        transition: background-color 0.2s ease;
    }

    .grantee-navbar-main .user-menu-toggle .fa-caret-down {
        transition: transform 0.2s ease;
    }

    .grantee-navbar-main .dropdown.open .user-menu-toggle .fa-caret-down {
        transform: rotate(180deg);
    }

    .grantee-navbar-main .user-menu-copy {
        color: #fff;
        line-height: 1.2;
        text-align: right;
    }

    .grantee-navbar-main .user-menu-copy strong {
        display: block;
        font-size: 15px;
        font-weight: 600;
    }

    .grantee-navbar-main .user-avatar {
        align-items: center;
        background: #fff;
        border: 2px solid #2f7fbd;
        border-radius: 999px;
        color: #2f7fbd;
        display: inline-flex;
        font-size: 14px;
        font-weight: 700;
        height: 38px;
        justify-content: center;
        transition: border-color 0.2s ease, transform 0.2s ease;
        width: 38px;
    }

    .grantee-navbar-main .dropdown-user {
        border: 0;
        border-radius: 8px;
        box-shadow: 0 10px 24px rgba(1, 52, 115, 0.16);
        margin-top: 12px;
        min-width: 250px;
        overflow: hidden;
        padding: 0;
    }

    @keyframes dropdownFadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .grantee-navbar-main .dropdown.open > .dropdown-menu {
        animation: dropdownFadeIn 0.15s ease forwards;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-summary {
        align-items: center;
        background: #f5f8fc;
        border-bottom: 1px solid #d6e1ee;
        display: flex;
        gap: 12px;
        padding: 16px 18px;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-summary:hover {
        background: #f5f8fc;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-avatar {
        align-items: center;
        background: #fff;
        border: 2px solid #2f7fbd;
        border-radius: 999px;
        color: #2f7fbd;
        display: inline-flex;
        flex: 0 0 44px;
        font-size: 15px;
        font-weight: 700;
        height: 44px;
        justify-content: center;
        width: 44px;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-meta {
        min-width: 0;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-name {
        color: #16385f;
        display: block;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.3;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-actions {
        padding: 8px;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-actions li {
        margin: 0;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-actions li a {
        align-items: center;
        border-radius: 6px;
        color: #16385f;
        display: flex;
        font-size: 14px;
        font-weight: 400;
        gap: 10px;
        padding: 11px 12px;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-actions li a:hover,
    .grantee-navbar-main .dropdown-user .user-dropdown-actions li a:focus {
        background: #e7eef7;
        color: #013473;
        text-decoration: none;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-actions .fa {
        color: #2f7fbd;
        font-size: 15px;
        text-align: center;
        width: 18px;
    }

    .grantee-navbar-main .dropdown-user .user-dropdown-divider {
        background: #d6e1ee;
        height: 1px;
        margin: 0;
    }

    @media (max-width: 767px) {
        .grantee-navbar-main {
            align-items: flex-start;
            gap: 10px;
            padding: 10px 15px;
        }

        .grantee-navbar-main .navbar-header {
            justify-content: space-between;
            width: 100%;
        }

        .grantee-navbar-main .grantee-branding {
            gap: 14px;
            margin-left: 8px;
        }

        .grantee-navbar-main .grantee-branding img:first-child {
            width: 100px;
        }

        .grantee-navbar-main .grantee-branding img:last-child {
            width: 140px;
        }

        .grantee-navbar-main .navbar-top-links {
            justify-content: flex-end;
            margin-left: 0;
            width: 100%;
        }

        .grantee-navbar-main .user-menu-copy {
            display: none;
        }

        .grantee-navbar-main .user-menu-toggle {
            padding-left: 10px;
        }
    }

    .pleft {
        padding-left: 50px !important;
    }
</style>

<div class="grantee-navbar-main">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="grantee-branding">
            <img class="img-responsive" src="<?php echo base_url('css/images/logo-aminef-2.png') ?>" alt="AMINEF">
            <img class="img-responsive" src="<?php echo base_url('css/images/logo-fulbright-2.png') ?>" alt="Fulbright Indonesia">
        </div>
    </div>

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle user-menu-toggle" data-toggle="dropdown" href="#">
                <span class="user-menu-copy">
                    <strong><?php echo $display_name; ?></strong>
                </span>
                <span class="user-avatar"><?php echo $initials; ?></span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li class="user-dropdown-summary">
                    <span class="user-dropdown-avatar"><?php echo $initials; ?></span>
                    <span class="user-dropdown-meta">
                        <span class="user-dropdown-name"><?php echo $display_name; ?></span>
                    </span>
                </li>
                <li class="user-dropdown-divider"></li>
                <li>
                    <ul class="user-dropdown-actions">
                        <li><a href="<?php echo site_url('grantee/profile/form/'.$this->session->userdata('grantee_user_id')) ?>"><i class="fa fa-user fa-fw"></i> My Profile</a></li>
                        <li><a href="<?php echo site_url('grantee/auth/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>
<div class="navbar-default sidebar" role="navigation" style="background-color:#fff">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <?php 
                $data_grantee = get_row_db('am_user_grantee', ['id' => $this->session->userdata('grantee_user_id')]);
                $data_missing = get_row_db('am_missing_document', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);
                $data_submission_plan = get_row_db('am_nominee_submission_plan', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);
            ?>
            <li>
                <a href="<?php echo site_url('grantee/profile/form/'.$this->session->userdata('grantee_user_id')) ?>"><i class="fa fa-home fa-fw"></i> My Profile</a>
            </li>
            <?php if ($this->session->userdata('grantee_active_country') == 1 && $this->session->userdata('active_grant') != '' && count($data_grant) > 1){ ?>
            <li>
                <a href="<?php echo site_url('grantee/programs/list/'.$this->session->userdata('grantee_user_id')) ?>"><i class="fa fa-book fa-fw"></i> All Grants</a>
            </li>
            <?php } ?>
            <?php if ($this->session->userdata('grantee_active_country') == 1 && $data_grantee->complete_profile) : ?>
                <li>
                    <a href="<?php echo site_url('grantee/grants'); ?>"><i class="fa fa-book fa-fw"></i> Grants</a>
                </li>
            <?php endif; ?>
            <?php //if (!$this->session->userdata('grants') && $data_grantee->complete_profile) : ?>
            <?php if($this->session->userdata('grantee_active_country') == AMERICAN_DATABASE) { ?>
                <?php 
                    $user_grantee_grant = get_row_db('am_user_grantee_grant', ['id' => $get_grantee_grant->grant_id]);
                ?>
                <?php foreach ($get_category as $key => $value) { ?>
                    <?php if (has_access_section($value, $get_grantee_grant)) { ?>
                    <li>
                        <a href="<?php echo site_url('grantee/submission/category/'.$value['id']) ?>"><i class="fa fa-files-o fa-fw"></i> <?= $value['name']?></a>
                    </li>
                    <?php } ?>
                <?php } ?>
                <?php if ($get_grantee_grant->status == CURRENT_GRANTEE) { ?>
                <li>
                    <a href="<?php echo site_url('grantee/leaves/list/'.$this->session->userdata('grantee_user_id')) ?>">
                        <i class="fa fa-file-text-o fa-fw"></i> 
                        <?php if ($user_grantee_grant->category_grant == ETA) { ?>
                            Personal Leave Request
                        <?php } else { ?>
                            Leave Request
                        <?php } ?>
                    </a>
                </li>
                <?php } ?>
                <li>
                    <a href="<?php echo site_url('grantee/travel_arrangement') ?>"><i class="fa fa-plane fa-fw"></i> Travel Arrangement</a>
                </li>
               
                <?php if (!in_array($get_grantee_grant->status , [STATUS_FINALIST, STATUS_NEW_GRANTEE, STATUS_VISA_APPLICATION])) { ?>
                <li>
                    <a href="<?php echo site_url('grantee/report/form/'.$this->session->userdata('grantee_user_id')) ?>"><i class="fa fa-file-text fa-fw"></i> AMINEF Report</a>
                </li>
                <?php } ?>
                <?php if ($user_grantee_grant->show_resources) { ?>
                    <li>
                        <a href="<?php echo site_url('grantee/resources/'); ?>"><i class="fa fa-files-o fa-fw"></i> Resources</a>
                    </li>
                <?php } ?>
                <?php if ($user_grantee_grant->show_eta_resources) { ?>
                    <li>
                        <a href="<?php echo site_url('grantee/eta_resources/'); ?>"><i class="fa fa-files-o fa-fw"></i> ETA Resources</a>
                    </li>
                <?php } ?>
                <?php if($hide_payment == false && (in_array($get_grantee_grant->status , [CURRENT_GRANTEE]) && get_grantee_setting()->show_payment_schedule)) {  ?>
                <li>
                    <a href="<?php echo site_url('grantee/payment/schedule/'.$this->session->userdata('grantee_user_id')) ?>"><i class="fa fa-usd fa-fw"></i> Payment Schedule</a>
                </li>
                <?php } ?>
            <?php } ?>
            <?php if ($this->session->userdata('grants')) : ?>
                <?php if ($this->session->userdata('grantee_active_country') == INDONESIAN_DATABASE){ 
                    $status_for_menu = [
                        STATUS_SELECTION_VERIFIED, 
                        STATUS_NEW_SELECTION, 
                        STATUS_SELECTION_REVISED, 
                        STATUS_SELECTION_DECLINED, 
                        STATUS_WAITING_FOR_INTERVIEW, 
                        STATUS_INTERVIEW, 
                        STATUS_SELECTION_SUCCESSFUL
                    ];
                    $status_candidate = [
                        STATUS_SELECTION_SUCCESSFUL, 
                        STATUS_NEW_CANDIDATE, 
                        STATUS_CANDIDATE_REVISED, 
                        STATUS_CANDIDATE_DECLINED, 
                        STATUS_CANDIDATE_SUCCESSFUL, 
                        STATUS_CANDIDATE_VERIFIED, 
                        STATUS_ON_GOING_RESIGN, 
                        STATUS_ON_GOING_REVISED, 
                        STATUS_RETURNING_SUCCESSFUL, 
                        STATUS_NEW_RETURNING, 
                        STATUS_RETURNING_REVISED, 
                        STATUS_APPLICATION_WITHDRAW,
                        STATUS_NOMINEE_WITHDRAW,
                        STATUS_NOMINEE_DROP,
                        STATUS_SET_TO_ALUMNI,
                        STATUS_ON_GOING_DROP
                    ];
                    $status_ongoing = [
                        // STATUS_CANDIDATE_SUCCESSFUL, 
                        STATUS_CANDIDATE_VERIFIED, 
                        STATUS_ON_GOING_RESIGN, 
                        STATUS_ON_GOING_REVISED, 
                        STATUS_RETURNING_SUCCESSFUL, 
                        STATUS_NEW_RETURNING, 
                        STATUS_RETURNING_REVISED,
                        STATUS_ON_GOING_DROP,
                        STATUS_SET_TO_ALUMNI
                    ];
                    $status_visa = [
                        STATUS_SELECTION_SUCCESSFUL,
                        STATUS_CANDIDATE_VERIFIED ,
                        STATUS_RETURNING_SUCCESSFUL, 
                        STATUS_NEW_RETURNING, 
                        STATUS_RETURNING_REVISED,
                        STATUS_SET_TO_ALUMNI
                    ];
                    $status_travel = [
                        STATUS_SELECTION_VERIFIED, 
                        STATUS_NEW_SELECTION, 
                        STATUS_SELECTION_REVISED, 
                        STATUS_SELECTION_DECLINED, 
                        STATUS_WAITING_FOR_INTERVIEW, 
                        STATUS_INTERVIEW,
                        STATUS_SELECTION_SUCCESSFUL,
                        STATUS_CANDIDATE_VERIFIED ,
                        STATUS_RETURNING_SUCCESSFUL, 
                        STATUS_NEW_RETURNING, 
                        STATUS_RETURNING_REVISED,
                        STATUS_SET_TO_ALUMNI
                    ];
                    $status_returning = [
                        STATUS_RETURNING_SUCCESSFUL, 
                        STATUS_NEW_RETURNING, 
                        STATUS_RETURNING_REVISED,
                        STATUS_SET_TO_ALUMNI
                    ];
                    $status_selection = [
                        STATUS_SELECTION_VERIFIED, 
                        STATUS_SELECTION_SUCCESSFUL, 
                        STATUS_NEW_CANDIDATE, 
                        STATUS_CANDIDATE_REVISED, 
                        STATUS_CANDIDATE_SUCCESSFUL, 
                        STATUS_CANDIDATE_VERIFIED, 
                        STATUS_ON_GOING_RESIGN, 
                        STATUS_ON_GOING_REVISED, 
                        STATUS_RETURNING_SUCCESSFUL, 
                        STATUS_NEW_RETURNING, 
                        STATUS_RETURNING_REVISED, 
                        STATUS_NOMINEE_WITHDRAW, 
                        STATUS_NOMINEE_DROP,
                        STATUS_SET_TO_ALUMNI,
                        STATUS_SELECTION_EEC
                    ];
                ?>
                    <?php foreach ($get_category_selection as $key => $value) { ?>
                        <li>
                            <a href="<?php echo site_url('grantee/submission/category/'.$value['id']) ?>"><i class="fa fa-files-o fa-fw"></i> <?= $value['name']?></a>
                        </li>
                    <?php } ?>
                    <?php if(in_array($get_grantee_grant->status, $status_selection) && !empty($get_grantee_interview) ) { ?>
                        <li>
                            <a href="<?php echo site_url('grantee/submission/selection'); ?>"><i class="fa fa-files-o fa-fw"></i> Selection</a>
                        </li>
                    <?php } ?>

                    <?php 
                        $nominee_menu = $active_grant->nominee_menu ? explode(",", $active_grant->nominee_menu) : [];
                        if($get_grantee_grant->is_eec && in_array($get_grantee_grant->status, $status_selection) && in_array('tnc', $nominee_menu)) { 
                    ?>
                    <li>
                        <a href="<?php echo site_url('grantee/tc/form/'.$this->session->userdata('grantee_user_id')) ?>" class="pleft"> AMINEF T&C</a>
                    </li>
                    <?php } ?>
                    
                    <?php //if($get_grantee_interview) { ?>
                        <!-- <li>
                            <a href="<?php echo site_url('grantee/submission/interview'); ?>"><i class="fa fa-calendar fa-fw"></i> Inteviews</a>
                        </li> -->
                    <?php //} ?>
                    <?php if(in_array($get_grantee_grant->status, $status_candidate)){ ?>
                        <?php foreach ($get_category_candidate as $key => $value) { ?>
                            <li>
                                <a href="<?php echo site_url('grantee/submission/category/'.$value['id']) ?>"><i class="fa fa-files-o fa-fw"></i> <?= $value['name']?></a>
                            </li>
                        <?php } ?>
                        <?php if(in_array($get_grantee_grant->status, $status_selection)) { ?>

                            <?php 
                                $nominee_menu = $active_grant->nominee_menu ? explode(",", $active_grant->nominee_menu) : [];
                                $period = get_row_db('am_user_grantee_period', ['id' => $get_grantee_grant->period_id]);
                                // if($get_grantee_grant->tnc_approver == false){
                                //     $nominee_menu = ['tnc'];
                                // }
                                if(empty($nominee_menu)){
                                    $nominee_menu = array_keys($nominee_menu_master);
                                }
                                $menu_for_grantee = [];
                                foreach($nominee_menu as $nmg) { 
                                    if($nmg == 'mentoring' || $nmg == 'test_preparation'){ $nmg = 'test_section'; }
                                    if($nmg == 'direct_application' || $nmg == 'submission_result' || $nmg == 'placement'){ $nmg = 'submission_plan'; }
                                    if(!in_array($nmg, $menu_for_grantee)){
                                        array_push($menu_for_grantee, $nmg);
                                    }
                                }

                                // check data data for show menu
                                $ceheck_mentoring = get_row_db('am_mentoring', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);
                                $ceheck_submission_plant = get_row_db('am_nominee_submission_plan', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);
                                $ceheck_direck_application = get_row_db('am_nominee_direct_application', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);
                                $other_doc = get_row_db('am_nominee_other_documents', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);
                                $pre_depature = get_row_db('am_pre_depature', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);


                                $keyPre = array_search("pre_departure", $menu_for_grantee);
                                if($keyPre){
                                    $pre_departure = array_splice($menu_for_grantee, $keyPre, 1);
                                    
                                    $insert_pos = array_search("test_section", $menu_for_grantee) + 1;
                                    array_splice($menu_for_grantee, $insert_pos, 0, $pre_departure);
                                }
                                foreach($menu_for_grantee as $nm) { 
                                    if($nm == 'eec' || $nm == 'fsb' || $nm == 'placement' || $nm == 'tnc'){ continue; } 
                                    // if($nm == 'test_section' && empty($ceheck_mentoring)) { continue;}
                                    // if($nm == 'submission_plan' && empty($ceheck_submission_plant) && $get_grantee_grant->hide_menu_submission_plan) { continue;}
                                    // if($nm == 'direct_application' && empty($ceheck_submission_plant) && $get_grantee_grant->hide_menu_submission_plan) { continue;}
                                    // if($nm == 'submission_result' && (empty($ceheck_submission_plant)) && $get_grantee_grant->hide_menu_submission_plan) { continue;}
                                    if($nm == 'pre_departure' && empty($pre_depature)) { continue;}
                                    if($nm == 'other_documents' && empty($other_doc)) { continue;}
                                    if($nm == 'departure' && !$get_grantee_grant->is_departure) { continue;}
                                    if($nm == 'submission_plan' && !$get_grantee_grant->show_direct_application && (!$data_submission_plan && !$get_grantee_grant->is_final_placement)) { continue;}


                                    // if($nm == 'submission_plan' && $get_grantee_grant->hide_menu_submission_plan) { continue;}
                                    // if($nm == 'direct_application' && $get_grantee_grant->hide_menu_direct_application) { continue;}
                                    // if($nm == 'submission_result' && $get_grantee_grant->hide_menu_submission_result) { continue;}
                            ?>
                                <li>
                                    <?php 
                                        $label_menu = $nominee_menu_master[$nm]['label'];
                                        if($nominee_menu_master[$nm]['label'] == 'Test Section'){
                                            $label_menu = 'Pre-Placement';
                                        }else if($nominee_menu_master[$nm]['label'] == 'Submission Plan'){
                                            $label_menu = 'Placement';
                                        }
                                    ?>
                                    <a href="<?php echo site_url($nominee_menu_master[$nm]['url_grantee'].$this->session->userdata('grantee_user_id')) ?>" class="pleft"> <?= $label_menu ?></a>
                                </li>
                            <?php } ?>



                            <!-- <?php if($period->tnc != '') { ?>
                            <li>
                                <a href="<?php echo site_url('grantee/tc/form/'.$this->session->userdata('grantee_user_id')) ?>" class="pleft"> T&C</a>
                            </li>
                            <?php } ?> -->


                            <!-- <li>
                                <a href="<?php echo site_url('grantee/testing/form/'.$this->session->userdata('grantee_user_id')) ?>" class="pleft"> Testing </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('grantee/submission_plan/list/'.$this->session->userdata('grantee_user_id')) ?>" class="pleft"> Submission Plan</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('grantee/direct_application/list/'.$this->session->userdata('grantee_user_id')) ?>" class="pleft"> Direct Application</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('grantee/submission_result/list/'.$this->session->userdata('grantee_user_id')) ?>" class="pleft"> Submission Result</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('grantee/pre_departure/form/'.$this->session->userdata('grantee_user_id')) ?>" class="pleft"> Pre Departure Orientation</a>
                            </li>
                            <?php 
                                $other_doc = get_row_db('am_nominee_other_documents', ['grantee_grant_id' => $this->session->userdata('grantee_grant_id')]);
                                $period = get_row_db('am_user_grantee_period', ['id' => $get_grantee_grant->period_id]);
                            ?>
                            <?php if($other_doc) { ?>
                            <li>
                                <a href="<?php echo site_url('grantee/other_document/form/'.$this->session->userdata('grantee_user_id')) ?>" class="pleft"> Other Documents</a>
                            </li>


                            
                            <?php } ?> -->
                        <?php } ?>
                    <?php } ?>
                    <?php if($get_grantee_grant->status == STATUS_CANDIDATE_SUCCESSFUL) { ?>
                        <!-- <li>
                            <a href="<?php echo site_url('grantee/submission/departure'); ?>"><i class="fa fa-files-o fa-fw"></i> Departure</a>
                        </li> -->
                    <?php } ?>
                    <?php //if(in_array($get_grantee_grant->status, $status_ongoing)){ ?>
                        <?php //foreach ($get_category_ongoing as $key => $value) { ?>
                            <!-- <li>
                                <a href="<?php echo site_url('grantee/submission/category/'.$value['id']) ?>"><i class="fa fa-files-o fa-fw"></i> <?= $value['name']?></a>
                            </li> -->
                        <?php //} ?>
                    <?php //} ?>
                    <?php if(in_array($get_grantee_grant->status, $status_ongoing)){ ?>
                        <li>
                            <a href="<?php echo site_url('grantee/submission/ongoing') ?>"><i class="fa fa-files-o fa-fw"></i> Ongoing</a>
                        </li>
                    <?php } ?>
                    <?php //if(in_array($get_grantee_grant->status, $status_returning)){ ?>
                        <?php //foreach ($get_category_returning as $key => $value) { ?>
                            <!-- <li>
                                <a href="<?php echo site_url('grantee/submission/category/'.$value['id']) ?>"><i class="fa fa-files-o fa-fw"></i> <?= $value['name']?></a>
                            </li> -->
                        <?php //} ?>
                    <?php //} ?>
                    <?php if(in_array($get_grantee_grant->status, $status_returning)){ ?>
                        <li>
                            <a href="<?php echo site_url('grantee/submission/returning') ?>"><i class="fa fa-files-o fa-fw"></i> Returning</a>
                        </li>
                    <?php } ?>
                    <?php if(in_array($get_grantee_grant->status, $status_visa) || in_array($get_grantee_grant->status, $status_travel)){ ?>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw" class="pleft"></i> Grant Support</a>
                        </li>
                        <?php if(in_array($get_grantee_grant->status, $status_visa)) { ?>
                        <li>
                            <a href="<?php echo site_url('grantee/submission/visa') ?>" class="pleft"> Visa</a>
                        </li>
                        <?php } ?>
                        <?php if(in_array($get_grantee_grant->status, $status_travel)) { ?>
                            <li>
                                <a href="<?php echo site_url('grantee/submission/travel_arrangement') ?>" class="pleft"> Travel Arrangement</a>
                            </li>
                        <?php } ?>
                        <?php $show_allowance_menu = false; ?>
                        
                        <?php if(is_admin() || (!is_admin() && $get_grantee_grant->set_to_pre_departure_allowance)) { 
                            $show_allowance_menu = true;
                        } ?>
                        
                        <?php 
                        
                        $user_grantee_grant = get_row_db('am_user_grantee_grant', ['id' => $get_grantee_grant->grant_id]);
                        
                        $status_returning = [
                            STATUS_RETURNING_SUCCESSFUL, 
                            STATUS_NEW_RETURNING, 
                            STATUS_RETURNING_REVISED,
                            STATUS_SET_TO_ALUMNI
                        ];
                        if (is_admin() || (in_array($get_grantee_grant->status, $status_returning) && $user_grantee_grant->is_degree)) {
                            $show_allowance_menu = true;
                        } ?>

                        <?php if ($show_allowance_menu) { ?>
                        <li>
                            <a href="<?php echo site_url('grantee/submission/allowance') ?>" class="pleft"> Allowance</a>
                        </li>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($this->session->userdata('grantee_active_country') == 1 && $data_missing){ ?>
                        <li>
                            <a href="<?php echo site_url('grantee/missing_document/' . $this->session->userdata('grantee_user_id')); ?>"><i class="fa fa-files-o fa-fw"></i> Missing Document</a>
                        </li>
                    <?php } ?>
                    <?php //if(!in_array($get_grantee_grant->status, $status_for_menu)){ ?>
                        <!-- <li>
                            <a href="<?php echo site_url('grantee/report/form/'.$this->session->userdata('grantee_user_id')) ?>"><i class="fa fa-file-text fa-fw"></i> AMINEF Report</a>
                        </li> -->
                    <?php //} ?>
                <?php } ?>
            <?php endif; ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
