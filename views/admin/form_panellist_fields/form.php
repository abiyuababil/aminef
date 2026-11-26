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
<div class="row">
	<div class="col-lg-12 mb-5">
		<form role="form" method="POST">

			<div class="form-group">
				<label>Question Label</label>
				<input class="form-control" name="name" value="<?php echo (isset($this->Form_list_panellists_model->name)) ? $this->Form_list_panellists_model->name : '' ?>" placeholder="eg: Consulate / Airport">
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
							if (isset($this->Form_list_panellists_model->type) && $this->Form_list_panellists_model->type == $pt)
								$selected = 'selected="selected"';
					?>
							<option value="<?php echo $pt ?>" <?php echo $selected ?>><?php echo $pt ?></option>
					<?php
						}
					}
					?>
				</select>
				<input type="hidden" name="sort" value="<?= $this->Form_list_panellists_model->sort ? $this->Form_list_panellists_model->sort : $max_sort; ?>">
			</div>
			
			<?php $this->load->view('admin/user_grantee_grant/submission/options'); ?>

			<?php //$this->load->view('admin/user_grantee_grant/submission/column_options'); ?>

			<div class="form-group">
				<label> Is Active </label>
				<input type="checkbox" value="1" name="is_active" <?= (!isset($this->Form_list_panellists_model->id)) || $this->Form_list_panellists_model->is_active == 1 ? "checked" : "" ?>>
			</div>
			<div class="form-group">
				<label>Required?</label>
				<input type="checkbox" value="1" name="is_required" <?= $this->Form_list_panellists_model->is_required == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group" id="mapping_to">
				<label>Mapping to</label>
				<select class="form-control property-from-validation" id="validation-for" name="mapping_to">
					<option value="">-- Select Field --</option>
					<option <?= $this->Form_list_panellists_model->mapping_to == "name" ? "selected"  : ""?> value="name">Name</option>
					<option <?= $this->Form_list_panellists_model->mapping_to == "telp" ? "selected"  : ""?> value="telp">Mobile Phone Number</option>
					<option <?= $this->Form_list_panellists_model->mapping_to == "home_institution" ? "selected"  : ""?> value="home_institution">Home Institution</option>
					<option <?= $this->Form_list_panellists_model->mapping_to == "origin_country" ? "selected"  : ""?> value="origin_country">Country of Origin</option>
					<option <?= $this->Form_list_panellists_model->mapping_to == "origin_state" ? "selected"  : ""?> value="origin_state">State of Origin</option>
					<option <?= $this->Form_list_panellists_model->mapping_to == "origin_city" ? "selected"  : ""?> value="origin_city">City of Origin</option>
					<option <?= $this->Form_list_panellists_model->mapping_to == "level_of_study" ? "selected"  : ""?> value="level_of_study">Level of Study</option>
					<option <?= $this->Form_list_panellists_model->mapping_to == "field_of_study_id" ? "selected"  : ""?> value="field_of_study_id">Field of Study</option>
					<option <?= $this->Form_list_panellists_model->mapping_to == "description" ? "selected"  : ""?> value="description">Biosketch</option>
				</select>
			</div>

			<?php
			if (isset($this->Form_list_panellists_model->id)) {
			?>
				<input type="hidden" name="id" value="<?php echo $this->Form_list_panellists_model->id ?>">
			<?php } ?>
			<a href="<?= base_url('admin/panelist/form/list_form/2'); ?>" class="btn btn-default">Back</a>
			<button type="submit" class="btn btn-success">Submit</button>
		</form>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->