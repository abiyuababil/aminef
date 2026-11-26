            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $title ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<form role="form" method="POST">
						<div class="form-group">
							<label>Group Name</label>
							<input class="form-control" name="group_name" value="<?php echo (isset($this->Program_group_model->name)) ? $this->Program_group_model->name : '' ?>" placeholder="eg: Fulbright Scholarships">
						</div>
						<?php
						if (isset($this->Program_group_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->Program_group_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/program_groups/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
