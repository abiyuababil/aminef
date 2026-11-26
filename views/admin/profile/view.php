            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">My Profiles</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<form role="form" method="POST">
						<div class="form-group">
							<label>Name</label>
							<div><?php echo (isset($staff->full_name)) ? $staff->full_name : '' ?></div>
						</div>
						<div class="form-group">
							<label>Birth Date</label>
							<div><?php echo (isset($staff->birth_date)) ? $staff->birth_date : '' ?></div>
						</div>
						<div class="form-group">
							<label>Email</label>
							<div><?php echo (isset($staff->email)) ? $staff->email : '' ?></div>
						</div>
						<a href="<?php echo site_url('admin/profile/edit') ?>" class="btn btn-primary">Edit</a>
						<a href="<?php echo site_url('admin/profile/change_password') ?>" class="btn btn-primary">Change Password</a>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
