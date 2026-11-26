<style>
	.select2 .selection {
		/* display:none; */
	}


</style>
			<div class="row">
                <div class="col-lg-12">
					<h1 class="page-header"><?php echo $title ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
					<form role="form" method="POST">
						<?php if(isset($is_bulk)){ ?>
						<div class="form-group">
							<label>Select Grant</label>
							<?php //echo '<pre>';print_r($available_programs);die;?>
                            <select class="form-control selectpicker" name="program_id[]" style="width:100%" multiple data-actions-box="true" required>
								<?php
								if ($available_programs) {
									foreach ($available_programs as $avp) {
										$selected = '';
										if (isset($avp->id) && $avp->id == $this->Program_property_model->properties_group_id) {
											$selected = 'selected="selected"';
										}
										?>
										<option value="<?php echo $avp->id ?>" <?php echo $selected ?>><?php echo $avp->name ?></option>
									<?php
								}
							}
							?>
							</select>
						</div>
						<?php } ?>
						<div class="form-group">
							<label>Category of Document</label>
							<select class="form-control select2" name="properties_group_id" style="width:100%">
								<option value="">-- Select Category --</option>
								<?php
								if ($cat_docs) {
									foreach ($cat_docs as $cd) {
										$selected = '';
										if (isset($cd->id) && $cd->id == $this->Program_property_model->properties_group_id) {
											$selected = 'selected="selected"';
										}
										?>
										<option value="<?php echo $cd->id ?>" <?php echo $selected ?>><?php echo $cd->name ?></option>
									<?php
								}
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Document Name</label>
							<input class="form-control" name="field_name" value="<?php echo (isset($this->Program_property_model->field_name)) ? $this->Program_property_model->field_name : '' ?>" placeholder="eg: Initial Application Form">
						</div>
						<?php
						if (!isset($this->Program_property_model->id)) {
						?>
						<?php /*
						<div class="form-group">
							<label>Type</label>
							<select class="form-control" name="field_type">
							<?php
							if($property_types)
							{
								foreach($property_types as $pt) {
									$selected = '';
									if (isset($this->Program_properties_model->field_type) && $this->Program_properties_model->field_type == $pt)
										$selected = 'selected="selected"';
							?>
								<option value="<?php echo $pt ?>" <?php echo $selected ?>><?php echo $pt ?></option>
							<?php
								}
							}
							?>
							</select>
						</div>
						*/ ?>
						<input type="hidden" name="field_type" value="file">
						<?php } ?>
						<?php
						if (isset($this->Program_property_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->Program_property_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/programs/manage/'.$this->Program_model->id) ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
