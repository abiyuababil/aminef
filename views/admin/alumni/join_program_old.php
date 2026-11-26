            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">
						<a href="<?php echo site_url('admin/alumni/edit/'.$this->User_model->id) ?>">
							<?php echo $this->User_model->full_name() ?>
						</a>
					</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<form role="form" method="POST">
            <div class="row" style="margin-bottom:10px">
			  <?php if ($programs) { ?>
				<?php
				foreach ($programs as $program) {
				?>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
							<?php echo $program->name ?>
                        </div>
                        <div class="panel-body">
							<?php echo $program->short_desc ?><br><br>
							<?php if (isset($user_programs[$program->id])) { ?>
							  <?php if ($program->id == $this->User_model->active_program_id) { ?>
							<span class="btn btn-success">
								Current Active Grant
							</span>
							  <?php } else { ?>
							<a href="<?php echo site_url('admin/alumni/set_active_program/'.$this->User_model->id.'/'.$program->id) ?>" class="btn btn-info">
								Set as Active Grant
							</a>
							  <?php } ?>
							<a href="<?php echo site_url('admin/alumni/remove_program/'.$this->User_model->id.'/'.$program->id) ?>" class="btn btn-danger pull-right" onclick="return confirm('Are you sure to remove <?php echo $this->User_model->name ?> from this program?')">
								Remove from this Grant
							</a>
							<?php } else { ?>
							<a href="<?php echo site_url('admin/alumni/join_program/'.$this->User_model->id.'/'.$program->id) ?>" class="btn btn-success">
								<i class="fa fa-plus"></i> Add this Grant
							</a>
							<?php } ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
				<?php } ?>
			  <?php } ?>
				<div class="col-lg-12">
					<a href="<?php echo site_url('admin/alumni/edit/'.$this->User_model->id) ?>" class="btn btn-primary">Back</a>
				</div>
            </div>
            <!-- /.row -->
			</form>