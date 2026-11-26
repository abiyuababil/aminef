            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">My Profile</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<form role="form" method="POST">
						<div class="form-group">
							<label>Name</label>
							<div><?php echo (isset($user->name)) ? $user->name : '' ?></div>
						</div>
						<div class="form-group">
							<label>Birth Date</label>
							<div><?php echo (isset($user->birth_date)) ? $user->birth_date : '' ?></div>
						</div>
						<div class="form-group">
							<label>Email</label>
							<div><?php echo (isset($user->email)) ? $user->email : '' ?></div>
						</div>
						<a href="<?php echo site_url('profile/edit') ?>" class="btn btn-primary">Edit</a>
						<a href="<?php echo site_url('profile/change_password') ?>" class="btn btn-primary">Change Password</a>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
