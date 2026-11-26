<style>
    .pleft {
        padding-left: 50px !important;
    }
</style>

<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>
<!-- /.navbar-header -->

<div style="float: left;margin: 6px 0 0 70px;color: #fff;font-size: 24px;">
    <img class="img-responsive" width="120" src="<?php echo base_url('css/images/logo-aminef-2.png') ?>" style="position: absolute;top: 10px;">
</div>
<div style="float: left;margin: 6px 0 0 150px;color: #fff;font-size: 24px;">
    <img class="img-responsive" width="170" src="<?php echo base_url('css/images/logo-fulbright-2.png') ?>" style="position: absolute;top: 10px;">
</div>

<ul class="nav navbar-top-links navbar-right">
    <li class="whitetext">
        Welcome <?php echo $this->session->userdata('host_institution_name') ?>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li>
                <a href="<?php echo site_url('host/auth/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->
<div class="navbar-default sidebar" role="navigation" style="background-color:#fff">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="<?php echo site_url('host/profile/form/'.$this->session->userdata('host_user_id')) ?>"><i class="fa fa-home fa-fw"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->