            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Requirements</h1>
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
			<form role="form" method="POST">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            User Data
                        </div>
                        <div class="panel-body">
							<div class="form-group">
								<div class="checkbox">
									<label class="checkall">
										<input name="user_data[]" value="Chek All" id="UserData" type="checkbox"> Chek All
									</label>
								</div>
							  <?php
							  if ($user_fields) {
								foreach ($user_fields as $field => $label) {
									$checked = '';
									if (in_array($field, $this->Stage_requirement_model->user_requirements))
										$checked = 'checked="checked"';
							  ?>
								<div class="checkbox">
									<label>
										<input name="user_data[]" value="<?php echo $field ?>" class="UserData" type="checkbox" <?php echo $checked ?>><?php echo $label ?>
									</label>
								</div>
								<?php } ?>
							  <?php } ?>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            User Properties
                        </div>
                        <div class="panel-body">
							<div class="form-group">
								<div class="checkbox">
									<label class="checkall">
										<input name="user_data[]" value="Chek All" id="UserProperties" type="checkbox"> Chek All
									</label>
								</div>
							  <?php
							  if ($user_properties) {
								foreach ($user_properties as $up) {
									$checked = '';
									if (in_array($up->id, $this->Stage_requirement_model->user_properties))
										$checked = 'checked="checked"';
							  ?>
								<div class="checkbox">
									<label>
										<input name="user_properties[]" class="UserProperties" value="<?php echo $up->id ?>" type="checkbox" <?php echo $checked ?>><?php echo $up->field_name ?>
									</label>
								</div>
								<?php } ?>
							  <?php } ?>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Program Properties
                        </div>
                        <div class="panel-body">
							<div class="form-group">
								<div class="checkbox">
									<label class="checkall">
										<input name="user_data[]" value="Chek All" id="ProgramProperties" type="checkbox"> Chek All
									</label>
								</div>
							  <?php
							  if ($program_properties) {
								foreach ($program_properties as $pp) {
									$checked = '';
									if (!empty($this->Stage_requirement_model->program_properties) && in_array($pp->id, $this->Stage_requirement_model->program_properties))
									  $checked = 'checked="checked"';

									//if (is_array($pp->id, $this->Stage_requirement_model->program_properties))
										
							  ?>
								<div class="checkbox">
									<label>
										<input name="program_properties[]" class="ProgramProperties" value="<?php echo $pp->id ?>" type="checkbox" <?php echo $checked ?>><?php echo $pp->field_name ?>
									</label>
								</div>
								<?php } ?>
							  <?php } ?>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
			
            <div class="row" style="margin-bottom:10px">
                <div class="col-lg-12">
					<a href="<?php echo site_url('admin/program_stages/manage/'.$this->Program_model->id) ?>" class="btn btn-default">Back</a>
					<button type="submit" class="btn btn-success">Submit</button>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			</form>
			