            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $title ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
					<form role="form" method="POST">
						<div class="form-group">
							<label>Study Level</label>
							<input class="form-control" name="name" value="<?php echo (isset($this->Study_level_model->name)) ? $this->Study_level_model->name : '' ?>" placeholder="eg: S2" required>
						</div>
						<?php
						if (isset($this->Study_level_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->Study_level_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/study_levels/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
