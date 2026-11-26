<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?= isset($this->User_grantee_grant_model->name) ? $this->User_grantee_grant_model->name : ''; ?></h1>
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
				  <?php if ($data) { ?>
					<div class="list-group sortable">
					  <?php
					  foreach ($data as $fo) {
						  $fo_val = $fo->id;
						  $label = $fo->name;
					  ?>
						<div class="list-group-item" style="cursor:move">
							<i class="fa fa-arrows"></i> &nbsp; <?php echo $label ?>
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
					<a href="<?php echo site_url('admin/manage_report/category_report/'.$this->User_grantee_grant_model->id) ?>" class="btn btn-warning">Back</a>
					<button type="submit" class="btn btn-primary">Save</button>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			</form>
			
