<div class="row">
    <div class="col-lg-12">
		<h1 class="page-header">Sorting Documents - <?php echo $grant->name; ?></h1>
		<?php if ($this->session->flashdata('info')) { ?>
			<div class="alert alert-info"><?php echo $this->session->flashdata('info'); ?></div>
			<?php echo $this->session->set_flashdata('info', false); ?>
		<?php } ?>
    </div>
</div>
<div class="row">
	<form action="<?php echo current_url(); ?>" method="POST">
		<div class="col-lg-6">
			<div class="list-group sortable ui-sortable">
				<?php foreach($custom_fields as $custom_field) { ?>
					<div class="list-group-item ui-sortable-handle" style="cursor:move">
						<i class="fa fa-arrows"></i> <?php echo $custom_field['name']; ?> <input type="hidden" name="field_order[]" value="<?php echo $custom_field['name']; ?>">
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="col-lg-12">
			<a href="<?php echo isset($period_id) ? site_url('admin/user_grantee_grant/edit_period/' . $grant->id . '/' . $period_id . '?pid=grant_pages') : site_url('admin/user_grantee_grant/manage'); ?>" class="btn btn-warning">Back</a>
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</form>
</div>