            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header"><?php echo $title ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<?php if (isset($notif_success) && $notif_success != '') { ?>
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $notif_success ?>
			</div>
			<?php } ?>
			
			<form role="form" method="POST" enctype="multipart/form-data">
            <div class="row">
				<?php if (isset($user_properties) || isset($program_properties)) { ?>
				<div class="col-lg-12" style="margin-bottom:10px">
					<ul class="nav nav-pills">
						<li class="active"><a data-toggle="tab" href="#general-info" aria-expanded="true">General Info</a></li>
						<?php if (isset($user_properties)) { ?>
						<li class=""><a data-toggle="tab" href="#user-properties" aria-expanded="false">User Properties</a></li>
						<?php } ?>
						<?php if (isset($program_properties)) { ?>
						<li class=""><a data-toggle="tab" href="#program-properties" aria-expanded="false">Program Properties</a></li>
						<?php } ?>
					</ul>
				</div>
				<!-- /.col-lg-12 -->
				<?php } ?>
				<div class="tab-content">
					<div id="general-info" class="tab-pane fade active in">
						<div class="col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									Basic Info
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label>Gender</label>
										<select class="form-control" name="gender">
											<option value="">-- Select Gender --</option>
										<?php
										if($genders)
										{
											foreach($genders as $ge) {
												$selected = '';
												if (isset($user->gender) && $user->gender == $ge)
													$selected = 'selected="selected"';
										?>
											<option value="<?php echo $ge ?>" <?php echo $selected ?>><?php echo $ge ?></option>
										<?php
											}
										}
										?>
										</select>
									</div>
									<div class="form-group">
										<label>Name</label>
										<input class="form-control" name="name" value="<?php echo (isset($user->name)) ? $user->name : '' ?>">
									</div>
									<div class="form-group">
										<label>Place of Birth</label>
										<input class="form-control" name="birth_place" value="<?php echo (isset($user->birth_place)) ? $user->birth_place : '' ?>">
									</div>
									<div class="form-group">
										<label>Date of Birth</label>
										<input class="form-control datepicker" name="birth_date" value="<?php echo (isset($user->birth_date)) ? date('d M Y', strtotime($user->birth_date)) : '' ?>">
									</div>
									<div class="form-group">
										<label>Mobile Number</label>
										<input class="form-control" name="phone_mobile" value="<?php echo (isset($user->phone_mobile)) ? $user->phone_mobile : '' ?>">
									</div>
									<div class="form-group">
										<label>Phone Number (Home)</label>
										<input class="form-control" name="phone_home" value="<?php echo (isset($user->phone_home)) ? $user->phone_home : '' ?>">
									</div>
									<div class="form-group">
										<label>Email</label>
										<input class="form-control" name="email" value="<?php echo (isset($user->email)) ? $user->email : '' ?>">
									</div>
								</div>
								<!-- /.panel-body -->
							</div>
							<!-- /.panel -->
							<div class="panel panel-default">
								<div class="panel-heading">
									Address
								</div>
								<div class="panel-body">
									<textarea class="form-control" rows="3" name="address"><?php echo (isset($user->address)) ? $user->address : '' ?></textarea>
								</div>
								<!-- /.panel-body -->
							</div>
							<!-- /.panel -->
						</div>
						<!-- /.col-lg-6 -->
						<div class="col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									Passport
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label>Passport Number</label>
										<input class="form-control" name="passport_number" value="<?php echo (isset($user->passport_number)) ? $user->passport_number : '' ?>">
									</div>
									<div class="form-group">
										<label>Passport Date of Issue</label>
										<input class="form-control datepicker" name="passport_date_issue" value="<?php echo (isset($user->passport_date_issue)) ? date('d M Y', strtotime($user->passport_date_issue)) : '' ?>">
									</div>
									<div class="form-group">
										<label>Passport Expiry Date</label>
										<input class="form-control datepicker" name="passport_date_expired" value="<?php echo (isset($user->passport_date_expired)) ? date('d M Y', strtotime($user->passport_date_expired)) : '' ?>">
									</div>
								</div>
								<!-- /.panel-body -->
							</div>
							<!-- /.panel -->
							<div class="panel panel-default">
								<div class="panel-heading">
									Upload
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label>Photo</label>
										  <?php if ($user->img_photo != '') { ?>
										  <div style="margin-bottom:10px">
											<a href="<?php echo base_url() ?><?php echo $user->img_photo ?>" target="_blank">
												<img src="<?php echo base_url() ?><?php echo $user->img_photo ?>" width="100">
											</a>
										  </div>
										  <?php } ?>
										<input type="file" name="img_photo">
										<small class="file-for-testing">File Size Max 5MB</small>
									</div>
									<div class="form-group">
										<label>Passport</label>
										  <?php if ($user->img_passport != '') { ?>
										  <div style="margin-bottom:10px">
											<a href="<?php echo base_url() ?><?php echo $user->img_passport ?>" target="_blank">
												View file
											</a>
										  </div>
										  <?php } ?>
										<input type="file" name="img_passport">
										<small class="file-for-testing">File Size Max 5MB</small>
									</div>
									<div class="form-group">
										<label>Certificate</label>
										  <?php if ($user->img_certificate != '') { ?>
										  <div style="margin-bottom:10px">
											<a href="<?php echo base_url() ?><?php echo $user->img_certificate ?>" target="_blank">
												View file
											</a>
										  </div>
										  <?php } ?>
										<input type="file" name="img_certificate">
										<small class="file-for-testing">File Size Max 5MB</small>
									</div>
								</div>
								<!-- /.panel-body -->
							</div>
							<!-- /.panel -->
							<div class="panel panel-default">
								<div class="panel-heading">
									Bank Info
								</div>
								<div class="panel-body">
									<textarea class="form-control" rows="3" name="bank_info"><?php echo (isset($user->bank_info)) ? $user->bank_info : '' ?></textarea>
								</div>
								<!-- /.panel-body -->
							</div>
							<!-- /.panel -->
						</div>
						<!-- /.col-lg-6 -->
					</div>
					<?php if (isset($user_properties)) { ?>
					<div id="user-properties" class="tab-pane fade">
						<div class="col-lg-6">
						  <?php
						  if ($user_properties) {
							foreach ($user_properties as $property_id => $up) {
								$value = '';
								if (isset($user_property_values[$property_id]))
									$value = $user_property_values[$property_id]->property_value;
								if ($up->field_type == 'date' && $value != '')
									$value = date('d M Y', strtotime($value));
						  ?>
							<div class="form-group">
								<label><?php echo $up->field_name ?></label>
								<?php if ($up->field_type == 'date') { ?>
								<input class="form-control datepicker" name="user_properties[<?php echo $property_id ?>]" value="<?php echo $value ?>">
								<?php } elseif ($up->field_type == 'text') { ?>
								<textarea class="form-control" rows="3" name="user_properties[<?php echo $property_id ?>]"><?php echo $value ?></textarea>
								<?php } elseif ($up->field_type == 'file') { ?>
								<input type="file" name="user_properties|<?php echo $property_id ?>">
								<small class="file-for-testing">File Size Max 5MB</small>
								  <?php if ($value != '') { ?>
								  <a href="<?php echo base_url() ?><?php echo $value ?>" target="_blank">View File</a>
								  <?php } ?>
								<?php } else { ?>
								<input class="form-control" name="user_properties[<?php echo $property_id ?>]" value="<?php echo $value ?>">
								<?php } ?>
							</div>
						  <?php
							}
						  }
						  ?>
						</div>
						<!-- /.col-lg-6 -->
					</div>
					<?php } ?>
					<?php if (isset($program_properties)) { ?>
					<div id="program-properties" class="tab-pane fade">
						<div class="col-lg-6">
							<h3 class="page-header"><?php echo $this->Program_model->name ?></h3>
						  <?php
						  if ($program_properties) {
							foreach ($program_properties as $property_id => $pp) {
								$value = '';
								if (isset($user_program_properties[$pp->id]))
									$value = $user_program_properties[$pp->id]->property_value;
								if ($pp->field_type == 'date' && $value != '')
									$value = date('d M Y', strtotime($value));
						  ?>
							<div class="form-group">
								<label><?php echo $pp->field_name ?></label>
								<?php if ($pp->field_type == 'date') { ?>
								<input class="form-control datepicker" name="program_properties[<?php echo $property_id ?>]" value="<?php echo $value ?>">
								<?php } elseif ($pp->field_type == 'text') { ?>
								<textarea class="form-control" rows="3" name="program_properties[<?php echo $property_id ?>]"><?php echo $value ?></textarea>
								<?php } elseif ($pp->field_type == 'file') { ?>
								<input type="file" name="program_properties|<?php echo $property_id ?>">
								<small class="file-for-testing">File Size Max 5MB</small>
								  <?php if ($value != '') { ?>
								  <a href="<?php echo base_url() ?><?php echo $value ?>" target="_blank">View File</a>
								  <?php } ?>
								<?php } else { ?>
								<input class="form-control" name="program_properties[<?php echo $property_id ?>]" value="<?php echo $value ?>">
								<?php } ?>
							</div>
						  <?php
							}
						  }
						  ?>
						</div>
						<!-- /.col-lg-6 -->
					</div>
					<?php } ?>
				</div>
				
				<div class="col-lg-12" style="margin-bottom:10px">
					<div style="margin-bottom:10px;">
						<?php
						if (isset($user->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo (isset($user->id)) ? $user->id : '' ?>">
						<?php } ?>
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>
				<!-- /.col-lg-12 -->
				
            </div>
            <!-- /.row -->
			</form>