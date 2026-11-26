            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">Edit Profile</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<form role="form" method="POST">
						<div class="form-group">
							<label>Name</label>
							<input class="form-control" name="full_name" value="<?php echo (isset($staff->full_name)) ? $staff->full_name : '' ?>">
						</div>
						<div class="form-group">
							<label>Birth Date</label>
							<input class="form-control" name="birth_date" value="<?php echo (isset($staff->birth_date)) ? $staff->birth_date : '' ?>">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" name="email" value="<?php echo (isset($staff->email)) ? $staff->email : '' ?>">
						</div>
						<button type="submit" class="btn btn-success">Submit</button>
						<a href="<?php echo site_url('admin/profile/view') ?>" class="btn btn-default">Back</a>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
