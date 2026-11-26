            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"> <?php if(isset($program_name)) { foreach ($program_name as $programname) {  echo $programname->name; } } ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo count($user_programs) ?></div>
                                    <div>Total Join Programs</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url('program/view') ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
								
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				<?php
				if (isset($generate_form)) {
				?>
				<div class="col-lg-12 col-md-6">
				Please Complete This Form :
				</div>
				<?php
					foreach ($generate_form as $progr) {
				?>			
					<div class="col-lg-12 col-md-6" style="margin-top:10px">
						<a href="<?php echo site_url('dashboard/generateform/'.$progr->id) ?>" class="btn btn-success" style="background:#013473;border:none;">
							<i class="fa fa-arrow-circle-right"></i> <?php echo $progr->name; ?>
						</a>
					</div>
				<?php 
					}
				}
				?>
            </div>
            <!-- /.row -->
