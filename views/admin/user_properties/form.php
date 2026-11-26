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
							<label>Property Name</label>
							<input class="form-control" name="field_name" value="<?php echo (isset($this->User_property_model->field_name)) ? $this->User_property_model->field_name : '' ?>" placeholder="eg: Consulate / Airport">
						</div>
						<div class="form-group">
							<label>Property Type</label>
							<select class="form-control" name="field_type">
							<?php
							if($property_types)
							{
								foreach($property_types as $pt) {
									$selected = '';
									if (isset($this->User_property_model->field_type) && $this->User_property_model->field_type == $pt)
										$selected = 'selected="selected"';
									//if ($pt == 'file') $selected = 'selected="selected"';
							?>
								<option value="<?php echo $pt ?>" <?php echo $selected ?>><?php echo $pt ?></option>
							<?php
								}
							}
							?>
							</select>
						</div>
						<?php
						if (isset($this->User_property_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->User_property_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/user_properties/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
