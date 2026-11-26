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
				<input class="form-control" readonly name="template_name" value="<?php echo (isset($template_email->template_name)) ? $template_email->template_name : '' ?>" placeholder="" required>
				<input type="hidden" name="id" value="<?= $template_email->id ?>">
			</div>
			<div class="form-group">
				<label>Subject</label>
				<input class="form-control" name="subject" value="<?php echo (isset($template_email->subject)) ? $template_email->subject : '' ?>">
			</div>
			<div class="form-group">
				<label>From Name</label>
				<input class="form-control" name="from_name" value="<?php echo (isset($template_email->from_name)) ? $template_email->from_name : '' ?>" placeholder="" required>
			</div>
			<div class="form-group">
				<label>Email Content</label>
				<textarea name="content" cols="30" rows="10" class="form-control editor"><?php echo (isset($template_email->content)) ? $template_email->content : '' ?></textarea>
			</div>
			<a href="<?php echo site_url('admin/email_template/manage') ?>" class="btn btn-default">Back</a>
			<button type="submit" class="btn btn-success">Save</button>
		</form>
	</div>
	
	<div class="col-lg-6">
		<h4 class="page-header"><b>Available merge fields</b></h4>
		<?= $available_field ?>
	</div>
</div>
<!-- /.row -->
