<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>
<!-- /.navbar-header -->

<div style="float: left;margin: 6px 0 0 70px;color: #fff;font-size: 24px; height: 44px;">
    <img class="img-responsive" width="120" src="<?php echo base_url('css/images/logo-aminef-2.png') ?>" style="position: absolute;top: 10px;">
</div>
<div style="float: left;margin: 6px 0 0 150px;color: #fff;font-size: 24px;">
        <img class="img-responsive" width="170" src="<?php echo base_url('css/images/logo-fulbright-2.png') ?>" style="position: absolute;top: 10px;">
</div>

<div class="navbar-default sidebar" role="navigation" style="background-color:#fff">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
        <?php if($is_report == false) { ?>
		<?php foreach ($grantee_grant_categories as $key => $value) { ?>
			<li>
                <?php 
                    $url = site_url('grantee/preview/data/' . $value->id . '?grants_id=' . $grants_id);
                    if (isset($period_id) && $period_id) {
                        $url .= '&period_id=' . $period_id; 
                    }
                ?>
				<a href="<?php echo $url; ?>"><i class="fa fa-files-o fa-fw"></i> <?= $value->name ?></a>
			</li>
        <?php } ?>
        <?php } else { ?>
                <li>
                    <a href=""><i class="fa fa-file-text fa-fw"></i> Aminef Report</a>
                </li>
        <?php } ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
