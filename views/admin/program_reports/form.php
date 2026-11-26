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
			
			<form role="form" method="POST">
			
            <div class="row">
                <div class="col-lg-6">
					<div class="form-group">
						<label>Report Name</label>
						<input class="form-control" name="report_name" value="<?php echo (isset($this->Program_report_model->report_name)) ? $this->Program_report_model->report_name : '' ?>" placeholder="eg: Permit Status">
					</div>
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
			
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            User Data
                        </div>
                        <div class="panel-body">
							<div class="form-group">
							  <?php
							  if ($user_fields) {
								foreach ($user_fields as $field => $label) {
									$checked = '';
									if (isset($this->Program_report_model->user_data) && in_array($field, $this->Program_report_model->user_data))
										$checked = 'checked="checked"';
							  ?>
								<div class="checkbox">
									<label>
										<input name="user_data[]" value="<?php echo $field ?>" type="checkbox" <?php echo $checked ?>><?php echo $label ?>
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
							  <?php
							  if ($user_properties) {
								foreach ($user_properties as $up) {
									$checked = '';
									if (isset($this->Program_report_model->user_properties) && in_array($up->id, $this->Program_report_model->user_properties))
										$checked = 'checked="checked"';
							  ?>
								<div class="checkbox">
									<label>
										<input name="user_properties[]" value="<?php echo $up->id ?>|<?php echo $up->field_slug ?>" type="checkbox" <?php echo $checked ?>><?php echo $up->field_name ?>
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
							  <?php
							  if ($program_properties) {
								foreach ($program_properties as $pp) {
									$checked = '';
									if (isset($this->Program_report_model->program_properties) && in_array($pp->id, $this->Program_report_model->program_properties))
										$checked = 'checked="checked"';
							  ?>
								<div class="checkbox">
									<label>
										<input name="program_properties[]" value="<?php echo $pp->id ?>|<?php echo $pp->field_slug ?>" type="checkbox" <?php echo $checked ?>><?php echo $pp->field_name ?>
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
					<?php
					if (isset($this->Program_report_model->id)) {
					?>
					<input type="hidden" name="id" value="<?php echo $this->Program_report_model->id ?>">
					<?php } ?>
					<a href="<?php echo site_url('admin/program_reports/manage/'.$this->Program_model->id) ?>" class="btn btn-default">Back</a>
					<button type="submit" class="btn btn-success">Submit</button>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			</form>
			
