<?php
$display_name = $this->session->userdata('role') == 'panellist'
    ? $this->session->userdata('name')
    : $this->session->userdata('full_name');

if (!$display_name) {
    $display_name = $this->session->userdata('role') == 'panellist'
        ? $this->session->userdata('name')
        : $this->session->userdata('username');
}

$display_name = trim((string) $display_name);
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
    $initials = 'U';
}
?>

<style>
    .admin-navbar-main {
        align-items: center;
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        min-height: 71px;
        padding: 0 15px;
    }

    .admin-navbar-main .navbar-header {
        align-items: center;
        display: flex;
        flex: 0 0 auto;
        float: none;
        min-height: 0;
    }

    .admin-navbar-main .navbar-brand {
        display: inline-flex;
        align-items: center;
        float: none;
        height: auto;
        padding: 0;
    }

    .admin-navbar-main .navbar-brand img {
        display: block;
        height: 46px;
        max-width: 100%;
        position: static;
        width: auto;
    }

    .admin-navbar-main .navbar-toggle {
        margin: 0 12px 0 0;
    }

    .admin-navbar-main .database-label {
        color: #fff;
        flex: 1 1 240px;
        font-size: 24px;
        line-height: 1.2;
        min-width: 0;
    }

    .admin-navbar-main .navbar-top-links {
        align-items: center;
        display: flex;
        flex: 0 0 auto;
        float: none !important;
        margin: 0 0 0 auto;
    }

    .admin-navbar-main .navbar-top-links > li {
        display: flex;
        align-items: center;
    }

    .navbar-top-links .user-menu-toggle {
        align-items: center;
        border-radius: 8px;
        display: flex;
        gap: 12px;
        padding: 10px 0 10px 14px;
        transition: background-color 0.2s ease;
    }

    .navbar-top-links .user-menu-toggle .fa-caret-down {
        transition: transform 0.2s ease;
    }

    .navbar-top-links .dropdown.open .user-menu-toggle .fa-caret-down {
        transform: rotate(180deg);
    }

    .navbar-top-links .user-menu-copy {
        color: #fff;
        line-height: 1.2;
        text-align: right;
    }

    .navbar-top-links .user-menu-copy strong {
        display: block;
        font-size: 15px;
        font-weight: 600;
    }

    .navbar-top-links .user-role-label {
        color: rgba(255, 255, 255, 0.72);
        display: block;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.04em;
        margin-top: 4px;
        text-transform: uppercase;
    }

    .navbar-top-links .user-avatar {
        align-items: center;
        background: #fff;
        border: 2px solid #5bc0de;
        border-radius: 999px;
        color: #5bc0de;
        display: inline-flex;
        font-size: 14px;
        font-weight: 700;
        height: 38px;
        justify-content: center;
        transition: border-color 0.2s ease, transform 0.2s ease;
        width: 38px;
    }

    .navbar-top-links .dropdown-user {
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

    .navbar-top-links .dropdown.open > .dropdown-menu {
        animation: dropdownFadeIn 0.15s ease forwards;
    }

    .navbar-top-links .dropdown-user .user-dropdown-summary {
        align-items: center;
        background: #f5f8fc;
        border-bottom: 1px solid #d6e1ee;
        display: flex;
        gap: 12px;
        padding: 16px 18px;
    }

    .navbar-top-links .dropdown-user .user-dropdown-summary:hover {
        background: #f5f8fc;
    }

    .navbar-top-links .dropdown-user .user-dropdown-avatar {
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

    .navbar-top-links .dropdown-user .user-dropdown-meta {
        min-width: 0;
    }

    .navbar-top-links .dropdown-user .user-dropdown-name {
        color: #16385f;
        display: block;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.3;
    }

    .navbar-top-links .dropdown-user .user-dropdown-role {
        color: #5c738b;
        display: block;
        font-size: 12px;
        letter-spacing: 0.04em;
        margin-top: 4px;
        text-transform: uppercase;
    }

    .navbar-top-links .dropdown-user .user-dropdown-actions {
        padding: 8px;
    }

    .navbar-top-links .dropdown-user .user-dropdown-actions li {
        margin: 0;
    }

    .navbar-top-links .dropdown-user .user-dropdown-actions li a {
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

    .navbar-top-links .dropdown-user .user-dropdown-actions li a:hover,
    .navbar-top-links .dropdown-user .user-dropdown-actions li a:focus {
        background: #e7eef7;
        color: #013473;
        text-decoration: none;
    }

    .navbar-top-links .dropdown-user .user-dropdown-actions .fa {
        color: #2f7fbd;
        font-size: 15px;
        text-align: center;
        width: 18px;
    }

    .navbar-top-links .dropdown-user .user-dropdown-divider {
        background: #d6e1ee;
        height: 1px;
        margin: 0;
    }

    @media (max-width: 767px) {
        .admin-navbar-main {
            align-items: flex-start;
            gap: 10px;
            padding: 10px 15px;
        }

        .admin-navbar-main .navbar-header {
            width: 100%;
            justify-content: space-between;
        }

        .admin-navbar-main .database-label {
            flex-basis: 100%;
            font-size: 18px;
            order: 3;
        }

        .admin-navbar-main .navbar-top-links {
            margin-left: 0;
            width: 100%;
            justify-content: flex-end;
        }

        .navbar-top-links .user-menu-copy {
            display: none;
        }

        .navbar-top-links .user-menu-toggle {
            padding-left: 10px;
        }
    }
</style>

<div class="admin-navbar-main">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo site_url('admin/dashboard/view') ?>"><img class="img-responsive" src="<?php echo base_url('css/images/logo.png') ?>"></a>
    </div>

    <?php if($this->session->userdata('role') != 'panellist'){ ?>
    <div class="database-label">
        <?php if ($this->session->userdata('active_country') == INDONESIAN_DATABASE) : ?>
            <span class="aminef-context-pill aminef-context-pill--indo"><span class="ctx-dot"></span>Indonesian Database</span>
        <?php elseif ($this->session->userdata('active_country') == AMERICAN_DATABASE) : ?>
            <span class="aminef-context-pill aminef-context-pill--us"><span class="ctx-dot"></span>American Database</span>
        <?php endif; ?>
    </div>
    <?php } ?>

    <ul class="nav navbar-top-links navbar-right">
        <?php $this->load->view('admin/component/notification') ?>
        <li class="dropdown">
            <a class="dropdown-toggle user-menu-toggle" data-toggle="dropdown" href="#">
                <span class="user-menu-copy">
                    <strong>Welcome <?php echo $display_name; ?></strong>
                    <span class="user-role-label"><?php echo ucwords($this->session->userdata('role')); ?></span>
                </span>
                <span class="user-avatar"><?php echo $initials; ?></span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li class="user-dropdown-summary">
                    <span class="user-dropdown-avatar"><?php echo $initials; ?></span>
                    <span class="user-dropdown-meta">
                        <span class="user-dropdown-name"><?php echo $display_name; ?></span>
                        <span class="user-dropdown-role"><?php echo ucwords($this->session->userdata('role')); ?></span>
                    </span>
                </li>
                <li class="user-dropdown-divider"></li>
                <li>
                    <ul class="user-dropdown-actions">
                        <li><a href="<?php echo $this->session->userdata('role') == 'panellist' ? site_url('panellist/profile/form') : site_url('admin/profile/view') ?>"><i class="fa fa-user fa-fw"></i> My Profile</a></li>
                        <li><a href="<?php echo $this->session->userdata('role') == 'panellist' ? site_url('panellist/logout') : site_url('admin/staff/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
                <?php /*
                            <li><a href="<?php echo site_url('admin/settings/view') ?>"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
						*/
                ?>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
</div>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            
            <?= display_menu_admin(0, 1); ?>
            <!-- hardcoded panellist menu -->
            <?php if ($this->session->userdata('panellist_id')) { ?>
                <?php //echo display_menu_panellist($this->session->userdata('panellist_id')); ?>
            <?php } ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
