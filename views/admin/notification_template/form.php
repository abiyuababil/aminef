<style>
	.note-toolbar {
		background-color: #fff !important;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><?php echo $title ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row mb-5">
	<div class="col-lg-6">
		<form role="form" method="POST">
			<div class="form-group">
				<label>Template Name</label>
				<input class="form-control" readonly name="name" value="<?php echo (isset($template_notification->name)) ? $template_notification->name : '' ?>" placeholder="" required>
				<input type="hidden" name="id" value="<?= $template_notification->id ?>">
			</div>
			<div class="form-group">
				<label>Notification Content</label>
				<textarea name="content" cols="30" rows="10" class="form-control editor"><?php echo (isset($template_notification->content)) ? $template_notification->content : '' ?></textarea>
			</div>
			<a href="<?php echo site_url('admin/notification_template/manage') ?>" class="btn btn-default">Back</a>
			<button type="submit" class="btn btn-success">Save</button>
		</form>
	</div>
	
	<div class="col-lg-6">
		<h4 class="page-header"><b>Available merge fields</b></h4>
		<?= $available_field ?>
	</div>
</div>
<!-- /.row -->
