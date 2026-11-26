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
							<label>Study Field</label>
							<input class="form-control" name="name" value="<?php echo (isset($this->Study_field_model->name)) ? $this->Study_field_model->name : '' ?>" placeholder="eg: Computer Science" required>
						</div>
						<?php
						if (isset($this->Study_field_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->Study_field_model->id ?>">
						<?php } ?>
						<a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/study_fields/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
