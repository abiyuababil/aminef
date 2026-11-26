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
		<h1 class="page-header"><?= isset($this->Eta_host_school_application_fields_model->id) ? 'Edit Field' : 'Add Field' ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12 mb-5">
		<form role="form" method="POST">

			<div class="form-group">
				<label>Question Label</label>
				<textarea class="form-control editor" name="name" rows="4"><?php echo (isset($this->Eta_host_school_application_fields_model->name)) ? $this->Eta_host_school_application_fields_model->name : '' ?></textarea>
			</div>
			<div class="form-group">
				<label>Hint</label>
				<textarea class="form-control" name="hint" rows="3"><?php echo (isset($this->Eta_host_school_application_fields_model->hint)) ? $this->Eta_host_school_application_fields_model->hint : '' ?></textarea>
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
							if (isset($this->Eta_host_school_application_fields_model->type) && $this->Eta_host_school_application_fields_model->type == $pt)
								$selected = 'selected="selected"';
					?>
							<option value="<?php echo $pt ?>" <?php echo $selected ?>><?php echo $pt ?></option>
					<?php
						}
					}
					?>
				</select>
				<input type="hidden" name="sort" value="<?= $this->Eta_host_school_application_fields_model->sort ? $this->Eta_host_school_application_fields_model->sort : $max_sort; ?>">
			</div>
			
			<?php $this->load->view('admin/user_grantee_grant/submission/options'); ?>

			<?php //$this->load->view('admin/user_grantee_grant/submission/column_options'); ?>

			<?php $this->load->view('admin/user_grantee_grant/submission/radio_group_options'); ?>
			<?php $this->load->view('admin/user_grantee_grant/submission/group_element_options'); ?>
			<?php $this->load->view('admin/user_grantee_grant/submission/declare_options'); ?>

			<div class="form-group guide_file <?= (isset($this->Eta_host_school_application_fields_model->type) && $this->Eta_host_school_application_fields_model->type == 'file') ? '' : 'hide'; ?>">
				<label>File</label><br>
				<div class="text-primary">
					<a href="<?php echo site_url() . ($this->Eta_host_school_application_fields_model->file ?? ''); ?>" id="filename" class="<?= empty($this->Eta_host_school_application_fields_model->file) ? 'hide' : ''; ?>" style="font-weight: bold;" target="_blank"><?php echo $this->Eta_host_school_application_fields_model->file ?? ''; ?></a>
				</div>
				<input type="file" class="custom-file-input hide" accept="<?php foreach(ALLOWED_PROFILE_FILETYPE as $filetype) { echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ","; } ?>.docx" id="file" onchange="show_preview(this, 'file', 'file');">
				<input type="hidden" name="file" value="<?= $this->Eta_host_school_application_fields_model->file ?? ''; ?>">
				<label class="btn btn-primary upload-button" for="file"> Choose file </label> 
				<a href="<?php echo site_url() . ($this->Eta_host_school_application_fields_model->file ?? ''); ?>" id="preview-file" class="btn btn-success fileview lightbox <?= empty($this->Eta_host_school_application_fields_model->file) ? 'hide' : ''; ?>">Preview</a>
				<a href="#" onclick="del_file()" id="remove-file" class="btn btn-warning fileview lightbox <?= empty($this->Eta_host_school_application_fields_model->file) ? 'hide' : ''; ?>"><i class="fa fa-times"></i></a>
			</div>

			<div class="form-group <?= (isset($this->Eta_host_school_application_fields_model->type) && $this->Eta_host_school_application_fields_model->type == 'element group') ? '' : 'hide'; ?> property-multiple">
				<label>Is Multiple?</label>
				<input type="checkbox" value="1" name="is_multiple" <?= $this->Eta_host_school_application_fields_model->is_multiple == 1 ? "checked" : "" ?> />
                <div class="row">
                    <div class="col-lg-3">
                        <input type="input" class="form-control" name="max_multiple" placeholder="Input Maximal Multiple Fields" value="<?php echo $this->Eta_host_school_application_fields_model->max_multiple ?>">
                    </div>
                </div>
			</div>

			<div class="form-group <?= (isset($this->Eta_host_school_application_fields_model->type) && $this->Eta_host_school_application_fields_model->type == 'input') ? '' : 'hide'; ?> is_number">
				<label>Is Number Only?</label>
				<input type="checkbox" value="1" name="is_number" <?= isset($this->Eta_host_school_application_fields_model->is_number) && $this->Eta_host_school_application_fields_model->is_number == 1 ? "checked" : "" ?> />
			</div>

			<div class="form-group">
				<label> Is Active </label>
				<input type="checkbox" value="1" name="is_active" <?= (!isset($this->Eta_host_school_application_fields_model->id)) || $this->Eta_host_school_application_fields_model->is_active == 1 ? "checked" : "" ?>>
			</div>
			<div class="form-group">
				<label>Required?</label>
				<input type="checkbox" value="1" name="is_required" <?= $this->Eta_host_school_application_fields_model->is_required == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group">
				<label>Show as Column?</label>
				<input type="checkbox" value="1" name="show_as_column" <?= $this->Eta_host_school_application_fields_model->show_as_column == 1 ? "checked" : "" ?> />
				<input type="number" class="form-control" name="sort_col" value="<?php echo (isset($this->Eta_host_school_application_fields_model->sort_col)) ? $this->Eta_host_school_application_fields_model->sort_col : '' ?>" placeholder="eg: 1">
			</div>

			<?php
			if (isset($this->Eta_host_school_application_fields_model->id)) {
			?>
				<input type="hidden" name="id" value="<?php echo $this->Eta_host_school_application_fields_model->id ?>">
			<?php } ?>
			<a href="<?= base_url('admin/eta_host_school_application/list_form/' . $form_id); ?>" class="btn btn-default">Back</a>
			<input type="hidden" name="delete_element_group_options" id="delete_element_group_options">
			<button type="submit" class="btn btn-success">Submit</button>
		</form>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->