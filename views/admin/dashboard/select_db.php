
			<?php if ($this->session->userdata('country_id') == 999) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Select Database</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 text-center">
									<a href="<?php echo site_url('admin/dashboard/set_db/1') ?>" style="color:#fff">
										<i class="fa fa-users fa-5x"></i>
									</a>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url('admin/dashboard/set_db/1') ?>">
                            <div class="panel-footer">
                                <span class="pull-left">Indonesian Database</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 text-center">
									<a href="<?php echo site_url('admin/dashboard/set_db/2') ?>" style="color:#fff">
										<i class="fa fa-users fa-5x"></i>
									</a>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url('admin/dashboard/set_db/2') ?>">
                            <div class="panel-footer">
                                <span class="pull-left">American Database</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
			<?php } ?>
