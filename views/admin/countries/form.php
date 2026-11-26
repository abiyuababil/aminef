            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header"><?php echo $title ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<form role="form" method="POST">
						<div class="form-group">
							<label>Country Name</label>
							<input class="form-control" name="name" value="<?php echo (isset($this->Country_model->name)) ? $this->Country_model->name : '' ?>" placeholder="eg: Indonesia">
						</div>
						<?php
						if (isset($this->Country_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->Country_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/countries/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
