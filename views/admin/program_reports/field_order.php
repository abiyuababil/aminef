            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $this->Program_report_model->report_name ?></h1>
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
				  <?php if ($this->Program_report_model->field_order) { ?>
					<div class="list-group sortable">
					  <?php
					  foreach ($this->Program_report_model->field_order as $fo) {
						  $fo_val = implode('|', $fo);
						  $label = '';
						  if ($fo[0] == 'ud')
							 $label = $user_fields[$fo[1]];
						  if ($fo[0] == 'up')
							 $label = $user_properties[$fo[1]]->field_name;
						  if ($fo[0] == 'pp')
							 $label = $program_properties[$fo[1]]->field_name;
					  ?>
						<div class="list-group-item" style="cursor:n-resize">
							<i class="fa fa-arrows-v fa-fw"></i> <?php echo $label ?>
							<input type="hidden" name="field_order[]" value="<?php echo $fo_val ?>">
						</div>
					  <?php } ?>
					</div>
				  <?php } ?>
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->

            <div class="row" style="margin-bottom:10px">
                <div class="col-lg-12">
					<?php
					if (isset($this->Program_report_model->id)) {
					?>
					<input type="hidden" name="id" value="<?php echo $this->Program_report_model->id ?>">
					<?php } ?>
					<a href="<?php echo site_url('admin/program_reports/manage/'.$this->Program_model->id) ?>" class="btn btn-warning">Back</a>
					<button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			</form>
			
