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
	if($question->available_alumni == 'yes'){
		$display_available = 'block';
	}else{
		$display_available = 'none';
	}

	if($question->available_validation == 'yes'){
		$display_available_validation = 'block';
	}else{
		$display_available_validation = 'none';
	}

	if($question->type == 'file'){
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
				<textarea name="name" class="form-control editor"><?php echo (isset($question->name)) ? $question->name : '' ?></textarea>
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
							if (isset($question->type) && $question->type == $pt)
								$selected = 'selected="selected"';
					?>
							<option value="<?php echo $pt ?>" <?php echo $selected ?>><?php echo $pt ?></option>
					<?php
						}
					}
					?>
				</select>
				<input type="hidden" name="sort" value="<?= $question->sort ? $question->sort : $max_sort; ?>">
			</div>
			
			<?php $this->load->view('admin/user_grantee_grant/submission/options'); ?>

			<?php $this->load->view('admin/user_grantee_grant/submission/column_options'); ?>

			<?php $this->load->view('admin/user_grantee_grant/submission/radio_group_options'); ?>

			<?php $this->load->view('admin/user_grantee_grant/submission/group_element_options'); ?>
			
			<div class="form-group">
				<label>Note</label>
				<textarea class="form-control editor" name="description_file"><?= $question->description_file ?></textarea>
			</div>
			<div class="form-group hide property-underQuestion">
				<label>Note Below Label?</label>
				<input type="checkbox" value="1" name="under_question" <?= $question->under_question == 1 ? "checked" : "" ?> />
			</div>
			<?php if (get_active_country() == 'Indonesian') { ?>
				<div class="form-group hide is_number">
					<label>Is Number Only?</label>
					<input type="checkbox" value="1" name="is_number" <?= $question->is_number == 1 ? "checked" : "" ?> />
				</div>
			<?php } ?>
			<div class="form-group hide row-file">
				<label>Is Row?</label>
				<input type="checkbox" value="1" name="is_row" <?= $question->is_row == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group hide property-multiple">
				<label>Is Multiple?</label>
				<input type="checkbox" value="1" name="is_multiple" <?= $question->is_multiple == 1 ? "checked" : "" ?> />
                <div class="row">
                    <div class="col-lg-3">
                        <input type="input" class="form-control" name="max_multiple" placeholder="Input Maximal Multiple Fields" value="<?php echo $question->max_multiple ?>">
                    </div>
                </div>
			</div>
			<div class="form-group">
				<label> Is Active </label>
				<input type="checkbox" value="1" name="is_active" <?= (!isset($question->id)) || $question->is_active == 1 ? "checked" : "" ?>>
			</div>
			<div class="form-group">
				<label>Required?</label>
				<input type="checkbox" value="1" name="is_required" <?= $question->is_required == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group">
				<label>Read Only</label>
				<input 
					type="checkbox" 
					id="read_only" 
					value="1" 
					name="read_only" 
					<?= $question->read_only == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group">
				<label>Not show on Grantee Page</label>
				<input 
					type="checkbox" 
					id="not_show_grantee" 
					value="1" 
					name="not_show_grantee" 
					<?= $question->not_show_grantee == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group hide property-limit">
				<label>Is Limit?</label>
				<input type="checkbox" value="1" id="is_limit" name="is_limit" <?= $question->is_limit == 1 ? "checked" : "" ?> />
				<br />
				<label class="label-limit">Select Type Limit</label>
				<select class="form-control hide" name="type_limit_char" id="type_limit_char" style="width:30%">
					<option value="Character" <?= $question->type_limit_char == 'Character' ? 'selected' : '' ?>>Character</option>
					<option value="Word" <?= $question->type_limit_char == 'Word' ? 'selected' : '' ?>>Word</option>
				</select><br />
				<input type="text" name="min_limit_char" id="min_limit_char" class="form-control hide" placeholder="Input Min Limit Characters" style="width:30%" value="<?= $question->min_limit_char ?>"><br />
				<input type="text" name="limit_char" id="limit_char" class="form-control hide" placeholder="Input Max Limit Characters" style="width:30%" value="<?= $question->limit_char ?>">
			</div>
			<div class="form-group hide property-sort_indicator">
				<label>Sort Indicator?</label>
				<input type="checkbox" value="1" id="sort_indicator" name="sort_indicator" <?= $question->sort_indicator == 1 ? "checked" : "" ?> />
			</div>

			<div class="alert alert-primary" id="advanced-checkbox" style="border: 1px solid #ddd;">
				<i class="fa fa-info-circle"></i> Advanced checkbox options
				<hr>
				<div class="form-group">
					<label for="is_advanced_checkbox">Use advanced checkbox?</label>
					<input type="checkbox" value="1" id="is_advanced_checkbox" name="is_advanced_checkbox" <?= $question->is_advanced_checkbox == 1 ? "checked" : "" ?> />
				</div>
				<div class="advanced-checkbox">
					<div class="form-group">
						<label for="hide_question_label">Hide Question Label</label>
						<input type="checkbox" value="1" id="hide_question_label" name="hide_question_label" <?= $question->hide_question_label == 1 ? "checked" : "" ?> />
					</div>
					<div class="form-group">
						<label for="is_parent">Parent Checkbox?</label>
						<input type="checkbox" value="1" id="is_parent" name="is_parent" <?= $question->is_parent == 1 ? "checked" : "" ?> />
					</div>
					<div class="form-group">
						<label for="have_additional_value_checkbox">Have additional value?</label>
						<input type="checkbox" value="1" id="have_additional_value_checkbox" name="have_additional_value_checkbox" <?= $question->have_additional_value_checkbox == 1 ? "checked" : "" ?> />
					</div>
					<div class="form-group">
						<label for="is_sub_checkbox">Placeholder additional value</label>
						<input type="text" class="form-control" name="placeholder_additional_value" value="<?= isset($question->placeholder_additional_value) ? $question->placeholder_additional_value : ''; ?>">
					</div>
					<div class="form-group">
						<label>Checkbox parent</label>
						<select class="form-control select2" name="parent_id">
							<option>Select Parent</option>
							<?php foreach($parent_custom_fields as $parent) { ?>
								<option value="<?php echo $parent->id; ?>" <?php echo $question->parent_id == $parent->id ? 'selected' : ''; ?>><?php echo $parent->name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Max sub-checkboxes that can be selected</label>
						<input type="number" step="any" value="<?php echo $question->sub_checkbox_limit ? $question->sub_checkbox_limit : 0; ?>" class="form-control" name="sub_checkbox_limit">
						<small><i class="fa fa-info-circle"></i> If 0, all can be selected</small>
					</div>
					<div class="form-group">
						<label>Section parent</label>
						<select class="form-control select2" name="parent_section_id">
							<option>Select Parent</option>
							<?php foreach($parent_sections as $parent) { ?>
								<option value="<?php echo $parent->id; ?>" <?php echo $question->parent_section_id == $parent->id ? 'selected' : ''; ?>><?php echo $parent->name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Max parent-checkboxes that can be selected</label>
						<input type="number" step="any" value="<?php echo $question->parent_checkbox_limit ? $question->parent_checkbox_limit : 0; ?>" class="form-control" name="parent_checkbox_limit">
						<small><i class="fa fa-info-circle"></i> If 0, all can be selected</small>
					</div>
				</div>
			</div>
			<?php
			if (isset($question->id)) {
			?>
				<input type="hidden" name="id" value="<?php echo $question->id ?>">
			<?php } ?>
			<a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
			<button type="submit" class="btn btn-success">Submit</button>
		</form>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->