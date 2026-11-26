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
				<?php 
					if(isset($user_properties)){
						if ($user_properties == NULL) { 
							$user_properties = array();
						}
					}
					else{
						$user_properties;
					}
				 ?>
				<div class="col-lg-12" style="margin-bottom:10px">
					<ul class="nav nav-pills">
						<li class="active"><a data-toggle="tab" href="#general-info" aria-expanded="true">General Info</a></li>
					
						<li class=""><a data-toggle="tab" href="#user-properties" aria-expanded="false">User Properties</a></li>
						
						<?php if ($program_properties) {?>
						<li class=""><a data-toggle="tab" href="#program-properties" aria-expanded="false">Program Properties</a></li>
						<?php } ?>
						
						<?php
						foreach ($user_programs as $up) {
							$program = $programs[$up->program_id];
						?>
						<li class=""><a data-toggle="tab" href="#user-program-<?php echo $up->program_id ?>" aria-expanded="false"><?php echo $program->name ?></a></li>
						<?php } ?>
					</ul>
				</div>
				<!-- /.col-lg-12 -->
				<?php  ?>
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
										<label>First Name</label>
										<input class="form-control" name="first_name" value="<?php echo (isset($user->first_name)) ? $user->first_name : '' ?>">
									</div>
									<div class="form-group">
										<label>Middle Name</label>
										<input class="form-control" name="midle_name" value="<?php echo (isset($user->midle_name)) ? $user->midle_name : '' ?>">
									</div>
									<div class="form-group">
										<label>Last Name</label>
										<input class="form-control" name="last_name" value="<?php echo (isset($user->last_name)) ? $user->last_name : '' ?>">
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
									Detail Address
								</div>
								<?php $idcountry = $this->session->userdata('active_country'); 
								if($idcountry == 1){
								?>
									<div class="form-group" style="margin-top:20px;">
										<label>Provinsi</label>
										<select class="form-control" name="provinci">
										<?php
											
											if($provinci)
											{
												foreach($provinci as $q) {
													$selected = '';
													
													
													if (isset($this->User_model->provinci) && $this->User_model->provinci == $q->id)
														$selected = 'selected="selected"';
											?>
												<option value="<?php echo $q->id ?>" <?php echo $selected ?>><?php echo $q->name_provinci ?></option>
											<?php
												}
											}
											?>
										</select> 
									</div>
									<div class="form-group">
										<label>City</label>
										<input class="form-control" name="city" value="<?php echo (isset($user->city)) ? $user->city : '' ?>">
									</div>
								<?php } ?>
								<div class="form-group">
									<label>Address</label>
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
							<div class="panel panel-default">
								<div class="panel-heading">
									User Status
								</div>
								<div class="panel-body">
									<div class="form-group" style="margin-top:20px;">
										<label>Status</label>
										<select class="form-control" name="status">
										<?php
											if($status)
											{
												foreach($status as $q) {
													$selected = '';
													
													
													if (isset($this->User_model->status) && $this->User_model->status == $q->id)
														$selected = 'selected="selected"';
											?>
												<option value="<?php echo $q->id ?>" <?php echo $selected ?>><?php echo $q->name ?></option>
											<?php
												}
											}
											?>
										</select> 
									</div>
								</div>
								<!-- /.panel-body -->
							</div>
						</div>
						<!-- /.col-lg-6 -->
					</div>
					<?php 
					//var_dump($user_properties);
					if (isset($user_properties)) { ?>
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
					
					<?php
					foreach ($user_programs as $up) {
						$program_id = $up->program_id;
						$program = $programs[$program_id];
					?>
					<div id="user-program-<?php echo $program_id ?>" class="tab-pane fade">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Is Alumni?</label>
								<select class="form-control" name="user_program[<?php echo $program_id ?>][isal]">
									<option value="1" <?php echo $up->is_alumny == '1' ? 'selected="selected"' : '' ?>>Yes</option>
									<option value="0" <?php echo $up->is_alumny == '0' ? 'selected="selected"' : '' ?>>No</option>
								</select>
							</div>
							<div class="form-group">
								<label>Year</label>
								<select class="form-control" name="user_program[<?php echo $program_id ?>][year]">
									<option value="">-- Select Year --</option>
								<?php
								$current_year = date('Y');
								$limit_year = $current_year - 20;
								for ($year=$current_year; $year>$limit_year; $year--) {
									$selected = '';
									if ($up->year == $year)
										$selected = 'selected="selected"';
								?>
									<option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
								<?php
								}
								?>
								</select>
							</div>
							<div class="form-group">
								<label>Home Institution</label>
								<input class="form-control" name="user_program[<?php echo $program_id ?>][hmi]" value="<?php echo $up->home_institution != '' ? $up->home_institution : '' ?>">
							</div>
							<div class="form-group">
								<label>Host Institution</label>
								<input class="form-control" name="user_program[<?php echo $program_id ?>][hsi]" value="<?php echo $up->host_institution != '' ? $up->host_institution : '' ?>">
							</div>
							<div class="form-group">
								<label>University</label>
								<input class="form-control" name="user_program[<?php echo $program_id ?>][univ]" value="<?php echo $up->university != '' ? $up->university : '' ?>">
							</div>
							<?php if ($active_cid == '1') { ?>
							<div class="form-group">
								<label>Study Fields</label>
								<select class="form-control" name="user_program[<?php echo $program_id ?>][sf]">
									<option value="">-- Select Study Fields --</option>
								<?php
								if($study_fields)
								{
									foreach($study_fields as $sl) {
										$selected = '';
										if (isset($up->study_field_id) && $up->study_field_id == $sl->id)
											$selected = 'selected="selected"';
								?>
									<option value="<?php echo $sl->id ?>" <?php echo $selected ?>><?php echo $sl->name ?></option>
								<?php
									}
								}
								?>
								</select>
							</div>
							<?php } ?>
						</div>
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
						<a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/users/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>
				<!-- /.col-lg-12 -->
				
            </div>
            <!-- /.row -->
			</form>