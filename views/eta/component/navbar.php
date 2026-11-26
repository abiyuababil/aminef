<?php
$display_name = trim((string) $this->session->userdata('eta_school_name'));
$display_role = 'ETA Host School';
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
    $initials = 'E';
}
?>

<style>
    .eta-navbar-main {
        align-items: center;
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        min-height: 71px;
        padding: 0 15px;
    }

    .eta-navbar-main .navbar-header {
        align-items: center;
        display: flex;
        flex: 0 0 auto;
        float: none;
        min-height: 0;
    }

    .eta-navbar-main .navbar-toggle {
        margin: 0 12px 0 0;
    }

    .eta-navbar-main .eta-branding {
        align-items: center;
        display: inline-flex;
        gap: 22px;
    }

    .eta-navbar-main .eta-branding img {
        display: block;
        height: auto;
        position: static;
    }

    .eta-navbar-main .eta-branding img:first-child {
        width: 120px;
    }

    .eta-navbar-main .eta-branding img:last-child {
        width: 170px;
    }

    .eta-navbar-main .navbar-top-links {
        align-items: center;
        display: flex;
        flex: 0 0 auto;
        float: none !important;
        margin: 0 0 0 auto;
    }

    .eta-navbar-main .navbar-top-links > li {
        align-items: center;
        display: flex;
    }

    .eta-navbar-main .user-menu-toggle {
        align-items: center;
        border-radius: 8px;
        display: flex;
        gap: 12px;
        padding: 10px 0 10px 14px;
        transition: background-color 0.2s ease;
    }

    .eta-navbar-main .user-menu-toggle .fa-caret-down {
        transition: transform 0.2s ease;
    }

    .eta-navbar-main .dropdown.open .user-menu-toggle .fa-caret-down {
        transform: rotate(180deg);
    }

    .eta-navbar-main .user-menu-copy {
        color: #fff;
        line-height: 1.2;
        text-align: right;
    }

    .eta-navbar-main .user-menu-copy strong {
        display: block;
        font-size: 15px;
        font-weight: 600;
    }

    .eta-navbar-main .user-role-label {
        color: rgba(255, 255, 255, 0.72);
        display: block;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.04em;
        margin-top: 4px;
        text-transform: uppercase;
    }

    .eta-navbar-main .user-avatar {
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

    .eta-navbar-main .dropdown-user {
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

    .eta-navbar-main .dropdown.open > .dropdown-menu {
        animation: dropdownFadeIn 0.15s ease forwards;
    }

    .eta-navbar-main .dropdown-user .user-dropdown-summary {
        align-items: center;
        background: #f5f8fc;
        border-bottom: 1px solid #d6e1ee;
        display: flex;
        gap: 12px;
        padding: 16px 18px;
    }

    .eta-navbar-main .dropdown-user .user-dropdown-summary:hover {
        background: #f5f8fc;
    }

    .eta-navbar-main .dropdown-user .user-dropdown-avatar {
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

    .eta-navbar-main .dropdown-user .user-dropdown-name {
        color: #16385f;
        display: block;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.3;
    }

    .eta-navbar-main .dropdown-user .user-dropdown-role {
        color: #5c738b;
        display: block;
        font-size: 12px;
        letter-spacing: 0.04em;
        margin-top: 4px;
        text-transform: uppercase;
    }

    .eta-navbar-main .dropdown-user .user-dropdown-actions {
        padding: 8px;
    }

    .eta-navbar-main .dropdown-user .user-dropdown-actions li {
        margin: 0;
    }

    .eta-navbar-main .dropdown-user .user-dropdown-actions li a {
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

    .eta-navbar-main .dropdown-user .user-dropdown-actions li a:hover,
    .eta-navbar-main .dropdown-user .user-dropdown-actions li a:focus {
        background: #e7eef7;
        color: #013473;
        text-decoration: none;
    }

    .eta-navbar-main .dropdown-user .user-dropdown-actions .fa {
        color: #2f7fbd;
        font-size: 15px;
        text-align: center;
        width: 18px;
    }

    .eta-navbar-main .dropdown-user .user-dropdown-divider {
        background: #d6e1ee;
        height: 1px;
        margin: 0;
    }

    @media (max-width: 767px) {
        .eta-navbar-main {
            align-items: flex-start;
            gap: 10px;
            padding: 10px 15px;
        }

        .eta-navbar-main .navbar-header {
            justify-content: space-between;
            width: 100%;
        }

        .eta-navbar-main .eta-branding {
            gap: 14px;
        }

        .eta-navbar-main .eta-branding img:first-child {
            width: 100px;
        }

        .eta-navbar-main .eta-branding img:last-child {
            width: 140px;
        }

        .eta-navbar-main .navbar-top-links {
            justify-content: flex-end;
            margin-left: 0;
            width: 100%;
        }

        .eta-navbar-main .user-menu-copy {
            display: none;
        }

        .eta-navbar-main .user-menu-toggle {
            padding-left: 10px;
        }
    }
</style>

<div class="eta-navbar-main">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="eta-branding">
            <img class="img-responsive" src="<?php echo base_url('css/images/logo-aminef-2.png') ?>" alt="AMINEF">
            <img class="img-responsive" src="<?php echo base_url('css/images/logo-fulbright-2.png') ?>" alt="Fulbright Indonesia">
        </div>
    </div>

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle user-menu-toggle" data-toggle="dropdown" href="#">
                <span class="user-menu-copy">
                    <strong>Selamat Datang <?php echo $display_name; ?></strong>
                    <span class="user-role-label"><?php echo $display_role; ?></span>
                </span>
                <span class="user-avatar"><?php echo $initials; ?></span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li class="user-dropdown-summary">
                    <span class="user-dropdown-avatar"><?php echo $initials; ?></span>
                    <span class="user-dropdown-meta">
                        <span class="user-dropdown-name"><?php echo $display_name; ?></span>
                        <span class="user-dropdown-role"><?php echo $display_role; ?></span>
                    </span>
                </li>
                <li class="user-dropdown-divider"></li>
                <li>
                    <ul class="user-dropdown-actions">
                        <li><a href="<?php echo site_url('eta/profile/form/'.$this->session->userdata('eta_user_id')) ?>"><i class="fa fa-user fa-fw"></i> Akun Sekolah</a></li>
                        <li><a href="<?php echo site_url('eta/auth/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>
<div class="navbar-default sidebar" role="navigation" style="background-color:#fff">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="<?php echo site_url('eta/profile/form/'.$this->session->userdata('eta_user_id')) ?>"><i class="fa fa-home fa-fw"></i> Akun Sekolah</a>
            </li>
            <li>
                <a href="<?php echo site_url('eta/application') ?>"><i class="fa fa-file-text-o"></i>&nbsp; Formulir Pengajuan</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->