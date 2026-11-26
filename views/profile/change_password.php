            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">Change Password</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<?php if (isset($success_message)) { ?>
					<div class="alert alert-success">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						<?php echo $success_message ?>
					</div>
					<?php } ?>
					<?php if (isset($err_message)) { ?>
					<div class="alert alert-danger">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						<?php echo $err_message ?>
					</div>
					<?php } ?>
					<form role="form" method="POST">
						<div class="form-group">
							<label>Current Password</label>
							<input class="form-control" placeholder="Current Password" name="current_password" type="password" value="">
						</div>
						<div class="form-group">
							<label>New Password</label>
							<input class="form-control" placeholder="New Password" name="new_password" type="password" value="">
						</div>
						<div class="form-group">
							<label>New Password Confirm</label>
							<input class="form-control" placeholder="New Password Confirm" name="new_password_confirm" type="password" value="">
						</div>
						<a href="<?php echo site_url('profile/view') ?>" class="btn btn-warning">Back</a>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
