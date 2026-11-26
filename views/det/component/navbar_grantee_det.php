<?php
$data_grantee = get_row_db('am_user_grantee_det', ['id' => $this->session->userdata('user_det_id')]);
// $applications = get_all_db('am_user_application_det', ['user_id' => $this->session->userdata('user_det_id')]);

$display_name = trim((string) $this->session->userdata('user_det_name'));
$display_role = 'DET';
$initials = '';
$avatar_url = '';

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

if (!empty($data_grantee->img_photo)) {
    $avatar_path = ltrim((string) $data_grantee->img_photo, '/');

    if ($avatar_path !== '' && preg_match('#^https?://#i', $avatar_path)) {
        $avatar_url = $avatar_path;
    } elseif ($avatar_path !== '' && defined('FCPATH') && is_file(FCPATH . $avatar_path)) {
        $image_info = @getimagesize(FCPATH . $avatar_path);

        if ($image_info !== false && !empty($image_info['mime']) && strpos($image_info['mime'], 'image/') === 0) {
            $avatar_url = base_url($avatar_path);
        }
    }
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
        display: flex;
        gap: 12px;
        padding: 10px 0 10px 14px;
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

    .grantee-navbar-main .user-role-label {
        color: rgba(255, 255, 255, 0.72);
        display: block;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.04em;
        margin-top: 4px;
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
        width: 38px;
    }

    .grantee-navbar-main .user-avatar img,
    .grantee-navbar-main .user-dropdown-avatar img {
        border-radius: 999px;
        display: block;
        height: 100%;
        object-fit: cover;
        width: 100%;
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

    .grantee-navbar-main .dropdown-user .user-dropdown-summary {
        align-items: center;
        background: #f5f8fc;
        border-bottom: 1px solid #d6e1ee;
        display: flex;
        gap: 12px;
        padding: 16px 18px;
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

    .grantee-navbar-main .dropdown-user .user-dropdown-role {
        color: #5c738b;
        display: block;
        font-size: 12px;
        letter-spacing: 0.04em;
        margin-top: 4px;
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
    .sidebar ul li a.active .fa-check-circle,
    .sidebar ul li a:hover .fa-check-circle {
        color: #fff !important;
    }
    li.nav-col > a {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    li.nav-col > a .arrow {
        float: none;
        margin-left: 10px;
        flex-shrink: 0;
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
                    <strong>Welcome <?php echo $display_name; ?></strong>
                    <span class="user-role-label"><?php echo $display_role; ?></span>
                </span>
                <span class="user-avatar"><?php if ($avatar_url) { ?><img src="<?php echo $avatar_url; ?>" alt="<?php echo htmlspecialchars($display_name); ?>"><?php } else { ?><?php echo $initials; ?><?php } ?></span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li class="user-dropdown-summary">
                    <span class="user-dropdown-avatar"><?php if ($avatar_url) { ?><img src="<?php echo $avatar_url; ?>" alt="<?php echo htmlspecialchars($display_name); ?>"><?php } else { ?><?php echo $initials; ?><?php } ?></span>
                    <span class="user-dropdown-meta">
                        <span class="user-dropdown-name"><?php echo $display_name; ?></span>
                        <span class="user-dropdown-role"><?php echo $display_role; ?></span>
                    </span>
                </li>
                <li class="user-dropdown-divider"></li>
                <li>
                    <ul class="user-dropdown-actions">
                        <li>
                            <a href="<?php echo site_url('det/auth/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div class="navbar-default sidebar" role="navigation" style="background-color:#fff;margin-top: 1px;">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="<?php echo site_url('det/profile/form/'.$this->session->userdata('user_det_id')) ?>"><i class="fa fa-home fa-fw"></i> My Profile</a>
            </li>
            <li>
                <a href="<?php echo site_url('det/registration'); ?>"><i class="fa fa-book fa-fw"></i> Duolingo English Test</a>
            </li>
            <?php if($applications) { ?>
                <?php foreach($applications as $application) { ?>
                    <li class="nav-col">
                        <a href="#">
                            Duolingo English Test -  <?= $application->year ?> <br /> 
                            <?= $application->term_name ?> <span class="fa arrow"></span>
                            <!-- <?php // date('d M Y', strtotime($application->start_date)) ?> - <?php // date('d M Y', strtotime($application->end_date)) ?> <span class="fa arrow"></span> -->
                        </a>
                        <ul class="nav nav-second-level 2 collapse" aria-expanded="true"><li class="menuhassub" style="background-color:#fff">
                            <li>
                                <a href="<?php echo site_url('det/application/form/' . $application->period_id . '/' . $application->id); ?>"><i class="fa fa-book fa-fw"></i> Application</a>
                            </li>
                            <?php if($application->status == STATUS_DET_COMPLETE){ ?>
                            <li>
                                <a href="<?php echo site_url('det/application/agreement/' . $application->id); ?>"><i class="fa fa-file fa-fw"></i> Agreement</a>
                            </li>
                            <?php } ?>
                            <?php if($application->coupon != ''){ ?>
                            <li>
                                <a href="<?php echo site_url('det/application/coupon/' . $application->id); ?>"><i class="fa fa-ticket"></i> Coupon Code</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('det/application/score_report/' . $application->id); ?>"><i class="fa fa-graduation-cap "></i> Score Report</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }?>
            <?php }?>
        </ul>
    </div>
</div>
