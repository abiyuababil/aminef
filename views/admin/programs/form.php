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
            				<label>Grant Name</label>
            				<input class="form-control" name="name" value="<?php echo (isset($this->Program_model->name)) ? $this->Program_model->name : '' ?>" placeholder="eg: MIT Scholarship 2015 S2">
            			</div>
            			<!-- <div class="form-group">
            				<label>Category Type</label>
            				<select class="form-control" name="category_grant">
            					<option value="">-- Select Category Type --</option>
            					<?php
								// if ($category_grant) {
								// 	foreach ($category_grant as $i => $cg) {
								// 		$selected = '';
								// 		if (isset($this->Program_model->category_grant) && $this->Program_model->category_grant == $i)
								// 			$selected = 'selected="selected"';
								?>
            							<option value="<?php //echo $i ?>" <?php //echo $selected ?>><?php //echo $cg ?></option>
            					<?php
									//}
								//}
								?>
            				</select>
            			</div> -->
            			<?php /*
						<div class="form-group">
							<label>Study Fields</label>
							<div class="row">
							<?php
							if($study_fields_id)
							{
								$divide_column = ceil(count($study_fields_id) / 6);
								
								foreach($study_fields_id as $key => $sf) {
									$selected 	= '';									
									$fildset 	= explode(',', $this->Program_model->study_field_id);
									foreach($fildset as $interest) {
										if ($interest == $sf->id)
										$selected = 'checked="checked"';
									}
									if ($key % $divide_column == 0)
									{
										if ($key != 0)
											echo '</div>';
										echo '<div class="col-lg-3">';
									}
							?>
								<div class="checkbox">
									<label><input type="checkbox" name="study_field_id[]" value="<?php echo $sf->id ?>" <?php echo $selected; ?> ><?php echo $sf->name ?></label>
								</div>
							<?php
								}
								echo '</div>';
							}
							?>
							</div>
						</div>
						*/ ?>

            			<!-- <div class="form-group">
            				<label>Specific Requirement</label>
            				<textarea class="form-control" <?php echo (isset($this->Program_model->spesific_requirement)) ? $this->Program_model->spesific_requirement : '' ?> name="spesific_requirement" id="" cols="30" rows="10"></textarea>
            			</div>
						<div class="form-group">
            				<label>General Requirement</label>
            				<textarea class="form-control" <?php echo (isset($this->Program_model->general_requirement)) ? $this->Program_model->general_requirement : '' ?> name="general_requirement" id="" cols="30" rows="10"></textarea>
            			</div>
						<div class="form-group">
            				<label>Submission Requirement</label>
            				<textarea class="form-control" <?php echo (isset($this->Program_model->submission_requirement)) ? $this->Program_model->submission_requirement : '' ?> name="submission_requirement" id="" cols="30" rows="10"></textarea>
            			</div>
						<div class="form-group">
            				<label>Deadline</label>
            				<textarea class="form-control" <?php echo (isset($this->Program_model->deadline_note)) ? $this->Program_model->deadline_note : '' ?> name="deadline_note" id="" cols="30" rows="10"></textarea>
            			</div>
						<div class="form-group">
            				<label>How to Apply</label>
            				<textarea class="form-control" <?php echo (isset($this->Program_model->how_to_apply)) ? $this->Program_model->how_to_apply : '' ?> name="how_to_apply" id="" cols="30" rows="10"></textarea>
            			</div>
						<div class="form-group">
            				<label>AMINEF</label>
            				<textarea class="form-control" <?php echo (isset($this->Program_model->aminef)) ? $this->Program_model->aminef : '' ?> name="aminef" id="" cols="30" rows="10"></textarea>
            			</div>
						<div class="form-group">
            				<label>contact informations</label>
            				<textarea class="form-control" <?php echo (isset($this->Program_model->contact_information)) ? $this->Program_model->contact_information : '' ?> name="contact_information" id="" cols="30" rows="10"></textarea>
            			</div> -->

            			<div class="form-group">
            				<label>Status</label>
            				<select class="form-control" name="status">
            					<?php
								if ($status) {
									foreach ($status as $ge) {
										$selected = '';
										if (isset($this->Program_model->status) && $this->Program_model->status == $ge)
											$selected = 'selected="selected"';

										if ($ge == 1) {
											$gel = "Disable";
										} else {
											$gel = "Enable";
										}
								?>
            							<option value="<?php echo $ge ?>" <?php echo $selected ?>><?php echo $gel ?></option>
            					<?php
									}
								}
								?>
            				</select>
            			</div>
            			<?php /*
						<div class="form-group">
							<label>Short Description</label>
							<textarea class="form-control" rows="3" name="short_desc"><?php echo (isset($this->Program_model->short_desc)) ? $this->Program_model->short_desc : '' ?></textarea>
						</div>
						<div class="form-group">
							<label>Full Description</label>
							<textarea class="form-control" rows="5" name="full_desc"><?php echo (isset($this->Program_model->full_desc)) ? $this->Program_model->full_desc : '' ?></textarea>
						</div>
						*/ ?>
            			<?php
						if (isset($this->Program_model->id)) {
						?>
            				<input type="hidden" name="id" value="<?php echo $this->Program_model->id ?>">
            			<?php } ?>
            			<div style="margin-bottom:10px">
            				<a href="<?php echo site_url('admin/programs/manage') ?>" class="btn btn-default">Back</a>
            				<button type="submit" class="btn btn-success">Submit</button>
            			</div>
            		</form>
            	</div>
            	<!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->