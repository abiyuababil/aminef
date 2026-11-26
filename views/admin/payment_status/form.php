            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header"><?php echo $title ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
					<form role="form" method="POST">
						<div class="form-group">
							<label>Payment Status</label>
							<input class="form-control" name="name" value="<?php echo (isset($this->Payment_status_model->name)) ? $this->Payment_status_model->name : '' ?>" placeholder="eg: New Payment" required>
						</div>
						<?php
						if (isset($this->Payment_status_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->Payment_status_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/payment_status/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
