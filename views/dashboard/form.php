            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $form_detail->name; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<form role="form" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-lg-8">
						<div class="panel panel-default">
							<div class="panel-heading" style="font-size: 20px; padding: 20px;">
								<?php if (isset($this->Generates_form_model->name)) { echo $this->Generates_form_model->name; }?>
							</div>
							<div class="panel-body">
								<?php 
									
									if ($this->Generates_form_model->field_order) { ?>
									<div class="list-group">
									<?php
									foreach ($this->Generates_form_model->field_order as $fo) {
										  //echo'<pre>';var_dump($fo, $user_property_values);exit;
										
										$property_id = $fo[1];

										$fo_vala = implode('|', $fo);
										$fo_val = "";
										$label = '';
										
										$typetext	= "";
										if ($fo[0] == 'ud'){
											$label 		= $user_fields[$fo[1]];
											$typetext	= "text";
																					
											$alig 		= $fo[1];
											$fo_valid 	= $alig;
											
											foreach ($update_user as $usernma) { 
												$fo_val =  $usernma->$alig;		
												
												?>
													<div class="form-group">
														<label><?php echo $label ?></label>
														<input type="<?php echo $typetext; ?>" class="form-control" name="<?php echo $fo_valid; ?>" value="<?php echo $fo_val ?>">
													</div>
													<?php
											}

										}
											
										if ($fo[0] == 'up'){
											$label = $user_properties[$fo[1]]->field_name;
											$typetext	= $user_properties[$fo[1]]->field_type;
											
											$value = '';
											if (isset($user_property_values['user_property_values'][$fo[1]]))
												$value = $user_property_values['user_property_values'][$fo[1]]->property_value;
											
											?>
											<div class="form-group">
												<label><?php echo $label ?></label>
												<?php if ($typetext == 'date') { ?>
												<input class="form-control datepicker" name="user_properties[<?php echo $property_id ?>]" value="<?php echo $value ?>">
												<?php } elseif ($typetext == 'text') { ?>
												<textarea class="form-control" rows="3" name="user_properties[<?php echo $property_id ?>]"><?php echo $value ?></textarea>
												<?php } elseif ($typetext == 'file') { ?>
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
											
										if ($fo[0] == 'pp'){
											$label = $program_properties[$fo[1]]->field_name;
											$typetext	= $program_properties[$fo[1]]->field_type;
											
											$value = '';
											if (isset($user_program_properties['user_program_properties'][$fo[1]]))
												$value = $user_program_properties['user_program_properties'][$fo[1]]->property_value;
											
											?>
											<div class="form-group">
												<label><?php echo $label ?></label>
												<?php if ($typetext == 'date') { ?>
												<input class="form-control datepicker" name="program_properties[<?php echo $property_id ?>]" value="<?php echo $value ?>">
												<?php } elseif ($typetext == 'text') { ?>
												<textarea class="form-control" rows="3" name="program_properties[<?php echo $property_id ?>]"><?php echo $value ?></textarea>
												<?php } elseif ($typetext == 'file') { ?>
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
								  <?php } ?>

							</div>
							<!-- /.panel-body -->
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12">
						<div class="panel panel-green">
							<div class="panel-headings" style="padding-left:20px;padding-right:20px;">
								<div class="row">
									
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="row" style="padding-bottom:30px">
					<div class="col-lg-12">
						<?php
						if (isset($this->Generates_form_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->Generates_form_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('dashboard/view/'.$this->Program_model->id) ?>" class="btn btn-warning">Back</a>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<!-- /.col-lg-12 -->
				</div>
			</form>
            <!-- /.row -->
