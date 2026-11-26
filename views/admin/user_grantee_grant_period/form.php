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
							<label> Period Name</label>
							<input class="form-control" name="name" value="<?php echo (isset($this->User_grantee_grant_period_model->name)) ? $this->User_grantee_grant_period_model->name : '' ?>" placeholder="eg: Fullbright Master">
						</div>
						<div class="form-group">
							<label> Start Date </label>
							<input class="form-control datepicker" name="start_date" value="<?php echo (isset($this->User_grantee_grant_period_model->start_date)) ? $this->User_grantee_grant_period_model->start_date : '' ?>">
						</div>
						<div class="form-group">
							<label> End Date </label>
							<input class="form-control datepicker" name="end_date" value="<?php echo (isset($this->User_grantee_grant_period_model->end_date)) ? $this->User_grantee_grant_period_model->end_date : '' ?>">
						</div>
						
						<div class="form-group">
							<label> Is Active </label>
							<input type="checkbox" value="1" name="is_active" <?= $this->User_grantee_grant_period_model->is_active == 1 ? "checked" : "" ?>	 >
						</div>
						<?php
						if (isset($this->User_grantee_grant_period_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->User_grantee_grant_period_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/user_grantee_grant_category/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->