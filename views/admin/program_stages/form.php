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
							<label>Program Stage</label>
							<input class="form-control" name="stage_name" value="<?php echo (isset($this->Program_stage_model->stage_name)) ? $this->Program_stage_model->stage_name : '' ?>" placeholder="eg: Submission">
						</div>
						<?php
						if (isset($this->Program_stage_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->Program_stage_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/program_stages/manage/'. $this->Program_model->id) ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
