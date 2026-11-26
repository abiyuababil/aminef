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
            				<label>Grant</label>
            				<select id="grant" name="user_grantee_grant_id" class="form-control">
								<option value="">Select Grant</option>
            					<?php foreach ($property_grant as $value) : ?>
            						<option <?= $this->User_grantee_property_model->user_grantee_grant_id == $value->id ? "selected": ""?> value="<?= $value->id; ?>"><?= $value->name; ?></option>
            					<?php endforeach; ?>
            				</select>
            			</div>
						<div class="category-type form-group">
							<label>Category Type</label>
            				<select id="category-type" name="user_grantee_category_type" class="form-control">
								<option value="">Select Category Type</option>
            					<option value="1" <?= $this->User_grantee_property_model->user_grantee_category_type == 1 ? "selected" : "";?>>Category</option>
            					<option value="2" <?= $this->User_grantee_property_model->user_grantee_category_type == 2 ? "selected" : "";?>>Category Report</option>
            				</select>
						</div>	

            			<div class="form-group category-wrap hide">
            				<label>Category</label>
            				<select id="category" name="user_grantee_category_id" class="form-control">
								<option value="">Select Category</option>
            				</select>
            			</div>
						<div class="form-group category-report-wrap hide">
            				<label>Category Report</label>
            				<select id="category-report" name="user_grantee_category_report_id" class="form-control">
								<option value="">Select Category Report</option>
            				</select>
            			</div>
            			<div class="form-group step-wrap hide">
            				<label>Step</label>
            				<select id="step" name="user_grantee_step_id" class="form-control">
								<option value="">Select Step</option>
            					<?php foreach ($property_step as $value) : ?>
            						<option selected="" value="<?= $value->id; ?>"><?= $value->name; ?></option>
            					<?php endforeach; ?>
            				</select>
            			</div>
            			<div class="form-group">
            				<label>Property Name</label>
            				<input class="form-control" name="name" value="<?php echo (isset($this->User_grantee_property_model->name)) ? $this->User_grantee_property_model->name : '' ?>" placeholder="eg: Consulate / Airport">
            			</div>
            			<div class="form-group">
            				<label>Property Type</label>
            				<select class="form-control" id="property-type" name="type">
            					<?php
								if ($property_types) {
									foreach ($property_types as $pt) {
										$selected = '';
										if (isset($this->User_grantee_property_model->type) && $this->User_grantee_property_model->type == $pt)
											$selected = 'selected="selected"';
								?>
            							<option value="<?php echo $pt ?>" <?php echo $selected ?>><?php echo $pt ?></option>
            					<?php
									}
								}
								?>
            				</select>
            			</div>
            			<div class="property-options hide">
            				<div class="form-group option-data">
            					<label>Option</label>
            					<input type="text" name="options[]" id="" class="form-control" value="<?= count($options) > 0 ? $options[0] : "" ?>">
            				</div>
							<?php if (count($options) > 1) { ?>
								<?php for ($i=1; $i<count($options); $i++) : ?>
									<div class="sample-option">
										<div class="form-group option-data">
											<label>Option</label>
											<input type="text" name="options[]" id="" class="form-control" value="<?= $options[$i]; ?>">
										</div>
									</div>

								<?php endfor; ?>
							<?php } ?>
            				<button type="button" class="btn-primary btn add-option">Add</button>
            			</div>

            			<div class="form-group">
            				<label>Sort</label>
            				<input type="number" name="sort" class="form-control" value="<?= $this->User_grantee_property_model->sort; ?>">
            			</div>
            			<div class="form-group">
            				<label>Required?</label>
            				<input type="checkbox" value="1" name="is_required" id="" <?= $this->User_grantee_property_model->is_required == 1 ? "checked" : "" ?> />
            			</div>
            			<?php
						if (isset($this->User_grantee_property_model->id)) {
						?>
            				<input type="hidden" name="id" value="<?php echo $this->User_grantee_property_model->id ?>">
            				<input type="hidden" id="temp_category_id" value="<?php echo $this->User_grantee_property_model->user_grantee_category_id ?>">
            				<input type="hidden" id="temp_category_report_id" value="<?php echo $this->User_grantee_property_model->user_grantee_category_report_id ?>">
            				<input type="hidden" id="temp_step_id" value="<?php echo $this->User_grantee_property_model->user_grantee_step_id ?>">
            			<?php } ?>
            			<a href="<?php echo site_url('admin/user_grantee_properties/manage') ?>" class="btn btn-default">Back</a>
            			<button type="submit" class="btn btn-success">Submit</button>
            		</form>
            	</div>
            	<!-- /.col-lg-12 -->
            </div>
            <div class="sample-option hide">
            	<div class="form-group">
            		<label>Option</label>
            		<input type="text" name="options[]" id="" class="form-control">
            	</div>
            </div>
            <!-- /.row -->