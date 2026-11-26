<style>
	.mrl {
		margin-left: 8px !important;
	}
	.label-check {
		cursor:pointer;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $title ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php 
	if($this->User_grantee_property_model->available_alumni == 'yes'){
		$display_available = 'block';
	}else{
		$display_available = 'none';
	}

	if($this->User_grantee_property_model->available_validation == 'yes'){
		$display_available_validation = 'block';
	}else{
		$display_available_validation = 'none';
	}

	if($this->User_grantee_property_model->type == 'file'){
		$display_description = 'block';
	}else{
		$display_description = 'none';
	}
?>
<div class="row">
	<div class="col-lg-12 mb-5">
		<form role="form" method="POST">

			<div class="form-group">
				<label>Question Label</label>
				<!-- <input class="form-control" name="name" value="<?php echo (isset($this->User_grantee_property_model->name)) ? $this->User_grantee_property_model->name : '' ?>" placeholder="eg: Consulate / Airport"> -->
				<textarea name="name" class="form-control editor"><?php echo (isset($this->User_grantee_property_model->name)) ? $this->User_grantee_property_model->name : '' ?></textarea>
			</div>
			<div class="form-group">
				<label>Question Type</label>
				<select class="form-control" id="property-type" name="type">
					<?php
					if ($property_types) {
						foreach ($property_types as $pt) {
							if (get_active_country() != 'Indonesian' && $pt == 'test type') {
								continue;
							}
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
				<input type="hidden" name="sort" value="<?= $this->User_grantee_property_model->sort ? $this->User_grantee_property_model->sort : $max_sort; ?>">
			</div>
			
			<?php $this->load->view('admin/user_grantee_grant/submission/options'); ?>

			<?php $this->load->view('admin/user_grantee_grant/submission/column_options'); ?>

			<?php $this->load->view('admin/user_grantee_grant/submission/radio_group_options'); ?>

			<?php $this->load->view('admin/user_grantee_grant/submission/group_element_options'); ?>

			<?php $this->load->view('admin/user_grantee_grant/submission/education_group_options'); ?>
			
			<?php if($this->session->userdata('active_country') == AMERICAN_DATABASE){ ?>
				<div class="form-group guide_file <?= !$this->User_grantee_property_model->file ? 'hide' : ''; ?>">
					<label>File</label><br>
					<div class="text-primary">
						<a href="<?php echo site_url() . $this->User_grantee_property_model->file; ?>" id="filename" class="<?= !$this->User_grantee_property_model->file ? 'hide' : ''; ?>" style="font-weight: bold;" target="_blank"><?php echo $this->User_grantee_property_model->file; ?></a>
					</div>
					<input type="file" class="custom-file-input hide" accept="<?php foreach(ALLOWED_PROFILE_FILETYPE as $filetype) { echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ","; } ?>.docx" id="file" onchange="show_preview(this, 'file', 'file');">
					<input type="hidden" name="file" value="<?= $this->User_grantee_property_model->file; ?>">
					<label class="btn btn-primary upload-button" for="file"> Choose file </label> 
					<a href="<?php echo site_url() . $this->User_grantee_property_model->file; ?>" id="preview-file" class="btn btn-success fileview lightbox <?= !$this->User_grantee_property_model->file ? 'hide' : ''; ?>">Preview</a>
					<a href="#" onclick="del_file()" id="remove-file" class="btn btn-warning fileview lightbox <?= !$this->User_grantee_property_model->file ? 'hide' : ''; ?>"><i class="fa fa-times"></i></a>
				</div>
			<?php } ?>
			<div class="form-group">
				<label>Note</label>
				<textarea class="form-control editor" name="description_file"><?= $this->User_grantee_property_model->description_file ?></textarea>
			</div>
			<div class="form-group hide property-underQuestion">
				<label>Note Below Label?</label>
				<input type="checkbox" value="1" name="under_question" <?= $this->User_grantee_property_model->under_question == 1 ? "checked" : "" ?> />
			</div>
			<?php if (get_active_country() == 'Indonesian') { ?>
				<div class="form-group hide is_number">
					<label>Is Number Only?</label>
					<input type="checkbox" value="1" name="is_number" <?= $this->User_grantee_property_model->is_number == 1 ? "checked" : "" ?> />
				</div>
			<?php } ?>
			<div class="form-group hide row-file">
				<label>Is Row?</label>
				<input type="checkbox" value="1" name="is_row" <?= $this->User_grantee_property_model->is_row == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group hide property-multiple">
				<label>Is Multiple?</label>
				<input type="checkbox" value="1" name="is_multiple" <?= $this->User_grantee_property_model->is_multiple == 1 ? "checked" : "" ?> />
                <div class="row">
                    <div class="col-lg-3">
                        <input type="input" class="form-control" name="max_multiple" placeholder="Input Maximal Multiple Fields" value="<?php echo $this->User_grantee_property_model->max_multiple ?>">
                    </div>
                </div>
			</div>
			<div class="form-group hide property-trigger-notify">
				<label>Trigger Notify Finance?</label>
				<input type="checkbox" value="1" name="trigger_notify_finance" <?= $this->User_grantee_property_model->trigger_notify_finance == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group hide property-trigger-ticket">
				<label>Trigger Ticket?</label>
				<input type="checkbox" value="1" id="trigger_notify_ticket" name="trigger_notify_ticket" <?= $this->User_grantee_property_model->trigger_notify_ticket == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group eta-category hide">
				<label class="label-category-eta">Select Category ETA Travel</label>
				<select class="form-control" name="eta_category" id="eta_category" style="width:30%">

					<option value="">- Select -</option>
					<?php if (!empty($categories_eta)): ?>
						<?php foreach ($categories_eta as $cat): ?>
							<option <?= $this->User_grantee_property_model->eta_category == $cat->id ? 'selected' : '' ?> value="<?= $cat->id ?>"><?= ucfirst(htmlspecialchars($cat->type ?? '', ENT_QUOTES, 'UTF-8')) ?> - <?= htmlspecialchars($cat->name ?? '', ENT_QUOTES, 'UTF-8') ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
			<div class="form-group hide property-passport-dependent">
				<label>Passport Dependent?</label>
				<input type="checkbox" value="1" id="passport_dependent" name="passport_dependent" <?= $this->User_grantee_property_model->passport_dependent == 1 ? "checked" : "" ?> />
			</div>
			<!-- <div class="form-group hide property-trigger-alumni">
				<label>Trigger Set to Alumni?</label>
				<input type="checkbox" value="1" name="trigger_set_to_alumni" <?= $this->User_grantee_property_model->trigger_set_to_alumni == 1 ? "checked" : "" ?> />
			</div> -->
			<div class="form-group">
				<label> Is Active </label>
				<input type="checkbox" value="1" name="is_active" <?= (!isset($this->User_grantee_property_model->id)) || $this->User_grantee_property_model->is_active == 1 ? "checked" : "" ?>>
			</div>
			<div class="form-group">
				<label>Required?</label>
				<input type="checkbox" value="1" name="is_required" <?= $this->User_grantee_property_model->is_required == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group">
				<label>Read Only</label>
				<input 
					type="checkbox" 
					id="read_only" 
					value="1" 
					name="read_only" 
					<?= $this->User_grantee_property_model->read_only == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group">
				<label>Not show on Grantee Page</label>
				<input 
					type="checkbox" 
					id="not_show_grantee" 
					value="1" 
					name="not_show_grantee" 
					<?= $this->User_grantee_property_model->not_show_grantee == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group hide property-limit">
				<label>Is Limit?</label>
				<input type="checkbox" value="1" id="is_limit" name="is_limit" <?= $this->User_grantee_property_model->is_limit == 1 ? "checked" : "" ?> />
				<br />
				<label class="label-limit">Select Type Limit</label>
				<select class="form-control hide" name="type_limit_char" id="type_limit_char" style="width:30%">
					<option value="Character" <?= $this->User_grantee_property_model->type_limit_char == 'Character' ? 'selected' : '' ?>>Character</option>
					<option value="Word" <?= $this->User_grantee_property_model->type_limit_char == 'Word' ? 'selected' : '' ?>>Word</option>
				</select><br />
				<input type="text" name="min_limit_char" id="min_limit_char" class="form-control hide" placeholder="Input Min Limit Characters" style="width:30%" value="<?= $this->User_grantee_property_model->min_limit_char ?>"><br />
				<input type="text" name="limit_char" id="limit_char" class="form-control hide" placeholder="Input Max Limit Characters" style="width:30%" value="<?= $this->User_grantee_property_model->limit_char ?>">
			</div>
			<div class="form-group hide property-sort_indicator">
				<label>Sort Indicator?</label>
				<input type="checkbox" value="1" id="sort_indicator" name="sort_indicator" <?= $this->User_grantee_property_model->sort_indicator == 1 ? "checked" : "" ?> />
			</div>
			<?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) : ?>
			<div class="form-group">
				<label style="margin-right:15px">Is the field available in Selection Validation ?</label>
				<input 
					class="form-check-input" 
					type="radio" 
					name="available_validation" 
					id="yes_available_validation" 
					value="yes" 
					<?= $this->User_grantee_property_model->available_validation == "yes" ? "checked" : "" ?>
				>
				<label class="form-check-label" for="yes_available_validation" style="margin-right:15px">Yes</label>
				<input 
					class="form-check-input" 
					type="radio" 
					name="available_validation" 
					id="no" 
					value="no" 
					<?= $this->User_grantee_property_model->available_validation == "no" || $this->User_grantee_property_model->available_validation == "" ? "checked" : "" ?>
				>
				<label class="form-check-label" for="no">No</label>
			</div>
			<?php endif; ?>
			<div class="form-group" id="validation_for" style="display:<?= $display_available_validation ?>">
				<label>Validation Field</label>
				<select class="form-control property-from-validation" id="validation-for" name="validation_for">
					<option value="">-- Select Field --</option>
					<option <?= $this->User_grantee_property_model->validation_for == "toefl" ? "selected"  : ""?> value="toefl">Academic Test</option>
					<option <?= $this->User_grantee_property_model->validation_for == "test_score" ? "selected"  : ""?> value="test_score">Score Test</option>
					<!-- <option <?= $this->User_grantee_property_model->validation_for == "essay" ? "selected"  : ""?> value="essay">Essay (SO – PS)</option> -->
					<!-- <option <?= $this->User_grantee_property_model->validation_for == "loa" ? "selected"  : ""?> value="loa">Letter of Invitation/ Acceptance</option> -->
					<option <?= $this->User_grantee_property_model->validation_for == "transcript" ? "selected"  : ""?> value="transcript">Transcript</option>
					<option <?= $this->User_grantee_property_model->validation_for == "diploma" ? "selected"  : ""?> value="diploma">Diploma</option>
					<option <?= $this->User_grantee_property_model->validation_for == "transcript_diploma_element" ? "selected"  : ""?> value="transcript_diploma_element">Transcript & Diploma in Element Group</option>
					<option <?= $this->User_grantee_property_model->validation_for == "domisili" ? "selected"  : ""?> value="domisili">Domicile</option>
					<option <?= $this->User_grantee_property_model->validation_for == "gpa" ? "selected"  : ""?> value="gpa">GPA</option>
					<option <?= $this->User_grantee_property_model->validation_for == "institution" ? "selected"  : ""?> value="institution">Home Institution</option>
					<option <?= $this->User_grantee_property_model->validation_for == "host_institution" ? "selected"  : ""?> value="host_institution">Host Institution</option>
					<option <?= $this->User_grantee_property_model->validation_for == "city" ? "selected"  : ""?> value="city">Office City</option>
					<option <?= $this->User_grantee_property_model->validation_for == "fos" ? "selected"  : ""?> value="fos">Field of Study</option>
					<option <?= $this->User_grantee_property_model->validation_for == "lor" ? "selected"  : ""?> value="lor">Letter of Reference</option>
					<option <?= $this->User_grantee_property_model->validation_for == "major" ? "selected"  : ""?> value="major">Major</option>
					<option <?= $this->User_grantee_property_model->validation_for == "project_title" ? "selected"  : ""?> value="project_title">Project Title</option>
					<option <?= $this->User_grantee_property_model->validation_for == "cv" ? "selected"  : ""?> value="cv">Curriculum Vitae</option>
					<option <?= $this->User_grantee_property_model->validation_for == "email_recommendation" ? "selected"  : ""?> value="email_recommendation">Email Recomendation</option>
					<option <?= in_array($this->User_grantee_property_model->validation_for, ["prefix", "recommendation_prefix"]) ? "selected"  : ""?> value="prefix">Prefix</option>
					<option <?= in_array($this->User_grantee_property_model->validation_for, ["full_name", "recommendation_full_name"]) ? "selected"  : ""?> value="full_name">Full Name</option>
					<option <?= in_array($this->User_grantee_property_model->validation_for, ["relationship", "recommendation_relationship"]) ? "selected"  : ""?> value="relationship">Relationship</option>
					<option <?= in_array($this->User_grantee_property_model->validation_for, ["position", "position_title", "recommendation_position"]) ? "selected"  : ""?> value="position">Position / Title</option>
					<option <?= in_array($this->User_grantee_property_model->validation_for, ["contact", "recommendation_contact"]) ? "selected"  : ""?> value="contact">Contact</option>
					<option <?= in_array($this->User_grantee_property_model->validation_for, ["institution_recommendation", "recommendation_institution"]) ? "selected"  : ""?> value="institution_recommendation">Institution Recommendation</option>
				</select>
			</div>
			<?php if ($category_type == 1 ) : ?>
				<?php if ($detail_grant->alumni_grant) : ?>
				<div class="form-group">
					<label style="margin-right:15px">Is the field available in alumni?</label>
					<input class="form-check-input" type="radio" name="available_alumni" id="yes_available_alumni" value="yes" <?= $this->User_grantee_property_model->available_alumni == "yes" || $this->User_grantee_property_model->available_alumni == "" ? "checked" : "" ?>>
					<label class="form-check-label" for="yes_available_alumni" style="margin-right:15px">Yes</label>

					<input class="form-check-input" type="radio" name="available_alumni" id="no" value="no" <?= $this->User_grantee_property_model->available_alumni == "no" ? "checked" : "" ?>>
					<label class="form-check-label" for="no">No</label>
				</div>
				<div class="form-group" id="is_basic_field" style="display:<?= $display_available ?>">
					<label>Is Basic Information</label>
					<input 
						type="checkbox" 
						id="is_basic" 
						value="1" 
						name="is_basic" 
						<?= (!isset($this->User_grantee_property_model->is_basic)) || $this->User_grantee_property_model->is_basic == 1 ? "checked" : "" ?> />
				</div>
				<?php 
					if($this->User_grantee_property_model->is_basic == 1){
						$display_available_basic = 'block';
					}else{
						if($this->User_grantee_property_model->available_alumni == 'yes' || $this->User_grantee_property_model->available_alumni == ''){
							if($this->User_grantee_property_model->is_basic == 1){
								$display_available_basic = 'block';
							}else{
								$display_available_basic = 'none';
							}
						}else{
							$display_available_basic = 'none';
						}

					}
				?>
				<div class="form-group" id="basic_field" style="display:<?= $display_available_basic ?>">
					<label>Property Alumni</label>
					<select class="form-control select2 property-basic-information" name="basic_fields">
						<?php foreach($basic_fields as $kbf => $vbf) : 	
							$selected = '';
							if (isset($this->User_grantee_property_model->basic_fields) && $this->User_grantee_property_model->basic_fields == $kbf)
								$selected = 'selected="selected"';
						?>
							
							<option value="<?= $kbf;?>" <?= $selected ?>><?= ucwords(str_replace("_", " ", $kbf)); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<?php 
					if((!isset($this->User_grantee_property_model->is_basic)) || $this->User_grantee_property_model->is_basic == 1){
						$display_property = 'none';
					}else{
						if($this->User_grantee_property_model->available_alumni == 'yes' || $this->User_grantee_property_model->available_alumni == ''){
							$display_property = 'block';
						}else{
							$display_property = 'none';
						}

					}
				?>
				<div class="form-group" id="property_field" style="display:<?= $display_property ?>">
					<label>Property Alumni</label>
					<select class="form-control select2 property-from-alumni" id="property-type" name="user_property_id">
						<?php 
						if ($program_properties) {
							foreach ($program_properties as $pp) {
								$selected = '';
								if (isset($this->User_grantee_property_model->user_property_id) && $this->User_grantee_property_model->user_property_id == $pp->id)
									$selected = 'selected="selected"';
						?>
								<option value="<?php echo $pp->id ?>" <?php echo $selected ?>><?php echo $pp->field_name ?></option>
						<?php
							}
						}
						?>
					</select>
				</div>
			<?php else: ?>
				<div class="form-group">
					<?= show_alert('danger', "You haven't select alumni grant yet at active grants!"); ?>
				</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php 
			$vendor_fields = isset($vendor_fields) && is_array($vendor_fields) && !empty($vendor_fields) ? $vendor_fields : [
				'name' => 'Vendor Name',
				'beneficiary_name' => 'Beneficiary Name',
				'address' => 'Address / Beneficiary Address',
				'bank_name' => 'Bank Name',
				'account_number' => 'Account Number',
				'bank_address' => 'Bank Address',
				'swift_code' => 'SWIFT Code',
				'routing_number' => 'Routing Number',
				'telp' => 'Telephone',
				'note' => 'Other Bank Details / Note'
			];
			?>
			<div class="form-group" id="vendor_mapping_group">
				<label style="margin-right:15px">Mapping to Master Data Vendor?</label>
				<input class="form-check-input" type="radio" name="available_vendor" id="yes_available_vendor" value="yes" <?= (isset($this->User_grantee_property_model->available_vendor) && $this->User_grantee_property_model->available_vendor == "yes") ? "checked" : "" ?>>
				<label class="form-check-label" for="yes_available_vendor" style="margin-right:15px">Yes</label>

				<input class="form-check-input" type="radio" name="available_vendor" id="no_available_vendor" value="no" <?= (!isset($this->User_grantee_property_model->available_vendor) || $this->User_grantee_property_model->available_vendor != "yes") ? "checked" : "" ?>>
				<label class="form-check-label" for="no_available_vendor">No</label>
			</div>
			<div class="form-group" id="vendor_field_container" style="display:<?= (isset($this->User_grantee_property_model->available_vendor) && $this->User_grantee_property_model->available_vendor == "yes") ? 'block' : 'none' ?>">
				<label>Target Vendor Field (Master Data)</label>
				<select class="form-control select2" name="vendor_field">
					<option value="">- Select Target Field -</option>
					<?php foreach ($vendor_fields as $kvf => $vvf) : 
						$selected_v = (isset($this->User_grantee_property_model->vendor_field) && $this->User_grantee_property_model->vendor_field == $kvf) ? 'selected="selected"' : '';
					?>
						<option value="<?= $kvf ?>" <?= $selected_v ?>><?= $vvf ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="alert alert-primary" id="advanced-checkbox" style="border: 1px solid #ddd;">
				<i class="fa fa-info-circle"></i> Advanced checkbox options
				<hr>
				<div class="form-group">
					<label for="is_advanced_checkbox">Use advanced checkbox?</label>
					<input type="checkbox" value="1" id="is_advanced_checkbox" name="is_advanced_checkbox" <?= $this->User_grantee_property_model->is_advanced_checkbox == 1 ? "checked" : "" ?> />
				</div>
				<div class="advanced-checkbox">
					<div class="form-group">
						<label for="hide_question_label">Hide Question Label</label>
						<input type="checkbox" value="1" id="hide_question_label" name="hide_question_label" <?= $this->User_grantee_property_model->hide_question_label == 1 ? "checked" : "" ?> />
					</div>
					<div class="form-group">
						<label for="is_parent">Parent Checkbox?</label>
						<input type="checkbox" value="1" id="is_parent" name="is_parent" <?= $this->User_grantee_property_model->is_parent == 1 ? "checked" : "" ?> />
					</div>
					<div class="form-group">
						<label for="have_additional_value_checkbox">Have additional value?</label>
						<input type="checkbox" value="1" id="have_additional_value_checkbox" name="have_additional_value_checkbox" <?= $this->User_grantee_property_model->have_additional_value_checkbox == 1 ? "checked" : "" ?> />
					</div>
					<div class="form-group">
						<label for="is_sub_checkbox">Placeholder additional value</label>
						<input type="text" class="form-control" name="placeholder_additional_value" value="<?= isset($this->User_grantee_property_model->placeholder_additional_value) ? $this->User_grantee_property_model->placeholder_additional_value : ''; ?>">
					</div>
					<div class="form-group">
						<label>Checkbox parent</label>
						<select class="form-control select2" name="parent_id">
							<option>Select Parent</option>
							<?php foreach($parent_custom_fields as $parent) { ?>
								<option value="<?php echo $parent->id; ?>" <?php echo $this->User_grantee_property_model->parent_id == $parent->id ? 'selected' : ''; ?>><?php echo $parent->name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Max sub-checkboxes that can be selected</label>
						<input type="number" step="any" value="<?php echo $this->User_grantee_property_model->sub_checkbox_limit ? $this->User_grantee_property_model->sub_checkbox_limit : 0; ?>" class="form-control" name="sub_checkbox_limit">
						<small><i class="fa fa-info-circle"></i> If 0, all can be selected</small>
					</div>
					<div class="form-group">
						<label>Section parent</label>
						<select class="form-control select2" name="parent_section_id">
							<option>Select Parent</option>
							<?php foreach($parent_sections as $parent) { ?>
								<option value="<?php echo $parent->id; ?>" <?php echo $this->User_grantee_property_model->parent_section_id == $parent->id ? 'selected' : ''; ?>><?php echo $parent->name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Max parent-checkboxes that can be selected</label>
						<input type="number" step="any" value="<?php echo $this->User_grantee_property_model->parent_checkbox_limit ? $this->User_grantee_property_model->parent_checkbox_limit : 0; ?>" class="form-control" name="parent_checkbox_limit">
						<small><i class="fa fa-info-circle"></i> If 0, all can be selected</small>
					</div>
				</div>
			</div>

			<!-- Conditional Visibility -->
			<div class="alert alert-warning" style="border: 1px solid #ddd;">
				<i class="fa fa-eye-slash"></i> <strong>Conditional Visibility</strong>
				<small class="text-muted"> — This field will only be displayed if the trigger field has a specific value.</small>
				<hr>
				<div class="form-group">
					<label for="conditional_parent_id">
						Trigger Field
						<small class="text-muted">(Select the field that triggers the display of this field)</small>
					</label>
					<select class="form-control" id="conditional_parent_id" name="conditional_parent_id" style="width: 60%;">
						<option value="">-- None (always visible) --</option>
						<?php if (!empty($step_custom_fields)): ?>
							<?php foreach ($step_custom_fields as $scf): ?>
								<?php
									if ($scf->id == $this->User_grantee_property_model->id) continue;
									$selected = ($this->User_grantee_property_model->conditional_parent_id == $scf->id) ? 'selected' : '';
								?>
								<option value="<?= $scf->id ?>" <?= $selected ?>>
									[<?= htmlspecialchars($scf->type) ?>] <?= htmlspecialchars(strip_tags($scf->name)) ?>
								</option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="conditional_parent_value">
						Trigger Value
						<small class="text-muted">(The ID value that triggers this field to be displayed, e.g., <code>230</code> for United States)</small>
					</label>
					<input
						type="text"
						class="form-control"
						id="conditional_parent_value"
						name="conditional_parent_value"
						placeholder="eg: 230"
						style="width: 50%;"
						value="<?= $this->User_grantee_property_model->conditional_parent_value ?? '' ?>"
					>
					<small class="text-muted">
						<i class="fa fa-info-circle"></i>
						Leave the Trigger Field empty if you do not want to use conditional visibility.
						For Country (type: country), the ID for United States is <code>230</code>.
					</small>
				</div>
			</div>
			<!-- End Conditional Visibility -->

			<?php
			if (isset($this->User_grantee_property_model->id)) {
			?>
				<input type="hidden" name="id" value="<?php echo $this->User_grantee_property_model->id ?>">
				<input type="hidden" id="temp_category_id" value="<?php echo $this->User_grantee_property_model->user_grantee_category_id ?>">
				<input type="hidden" id="temp_step_id" value="<?php echo $this->User_grantee_property_model->user_grantee_step_id ?>">
			<?php } ?>
			<a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
			<button type="submit" class="btn btn-success">Submit</button>
		</form>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->