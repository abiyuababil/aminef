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
							<input class="form-control" name="name" value="<?php echo (isset($user->name)) ? $user->name : '' ?>">
						</div>
						<div class="form-group">
							<label>Birth Date</label>
							<input class="form-control datepicker" name="birth_date" value="<?php echo (isset($user->birth_date)) ? date('d M Y', strtotime($user->birth_date)) : '' ?>">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" name="email" value="<?php echo (isset($user->email)) ? $user->email : '' ?>">
						</div>
						<a href="<?php echo site_url('profile/view') ?>" class="btn btn-warning">Back</a>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
