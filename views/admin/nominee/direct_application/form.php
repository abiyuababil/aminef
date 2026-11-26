<div class="row">
	<div class="col-lg-12">
		<h1><?= get_full_name($grantee_grant) ?></h1>
		<h3 class="page-header"><?= $page_title ?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row mb-5">
	<form role="form" method="POST" enctype="multipart/form-data">
		<div class="col-lg-6">
			<div class="form-group">
				<label>University</label>
				<select id="university_id" class="form-control select2" name="university_id" style="width:100%">
					<option value="">-- Select University --</option>
					<?php foreach ($universities as $university) : ?>
						<?php $selected = $this->Direct_application_model->university_id == $university->id ? 'selected' : ''; ?>
						<option value="<?= $university->id?>" <?= $selected ?>><?= $university->name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label>Address</label>
				<textarea name="address" rows="4" class="form-control"><?= (isset($this->Direct_application_model->address)) ? $this->Direct_application_model->address : '' ?></textarea>
			</div>
			<div class="form-group">
				<label>Degree Level</label>
				<input class="form-control" name="degree_level" value="<?php echo (isset($this->Direct_application_model->degree_level)) ? $this->Direct_application_model->degree_level : '' ?>" >
			</div>
			<div class="form-group">
				<label>Major</label>
				<input class="form-control" name="major" value="<?php echo (isset($this->Direct_application_model->major)) ? $this->Direct_application_model->major : '' ?>" >
			</div>
			<div class="form-group">
				<label>Department</label>
				<input class="form-control" name="department" value="<?php echo (isset($this->Direct_application_model->department)) ? $this->Direct_application_model->department : '' ?>" >
			</div>
			<div class="form-group">
				<label>Specialization</label>
				<input class="form-control" name="specialization" value="<?php echo (isset($this->Direct_application_model->specialization)) ? $this->Direct_application_model->specialization : '' ?>" >
			</div>
			<div class="form-group">
				<label>Credits</label>
				<input class="form-control" name="credits" value="<?php echo (isset($this->Direct_application_model->credits)) ? $this->Direct_application_model->credits : '' ?>" >
			</div>
			<!-- <div class="form-group">
				<label>Status</label>
				<select name="status" class="form-control">
					<option value="2">-- Select Status --</option>
					<option value="0" <?= $this->Direct_application_model->status == '0' ? 'selected' : '' ?>>Rejected</option>
					<option value="1" <?= $this->Direct_application_model->status == '1' ? 'selected' : '' ?>>Admitted</option>
				</select>
			</div> -->

			<?php
			if (isset($this->Direct_application_model->id)) {
			?>
				<input type="hidden" name="id" value="<?php echo $this->Direct_application_model->id ?>">
			<?php } ?>
		</div>

		<div class="col-lg-6">
			<div class="form-group">
				<label>Program Duration</label>
				<input class="form-control" name="program_duration" value="<?php echo (isset($this->Direct_application_model->program_duration)) ? $this->Direct_application_model->program_duration : '' ?>" >
			</div>
			<div class="form-group">
				<label>University Website</label>
				<input class="form-control" name="link" value="<?php echo (isset($this->Direct_application_model->link)) ? $this->Direct_application_model->link : '' ?>" >
			</div>
			<div class="form-group">
				<label>Reason</label>
				<textarea name="note" rows="4" class="form-control"><?= (isset($this->Direct_application_model->note)) ? $this->Direct_application_model->note : '' ?></textarea>
			</div>
			<div class="form-group">
				<label>Support Letter</label>
				<?php if($this->Direct_application_model->support_letter != ''){ ?>
				<br>
				<a href="<?= site_url($this->Direct_application_model->support_letter) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($this->Direct_application_model->support_letter); ?>"></a>
				<br/>
                <a href=<?= base_url('admin/nominee/direct_application/delete_file/support_letter/'.$this->Direct_application_model->id.'/'.$grantee_grant_id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
				<?php } ?>
				<input type="file" name="support_letter" id="" class="form-control">
                <small class="file-for-testing">File Size Max 5MB</small>
			</div>
			<!-- <div class="form-group">
				<label>LoA</label>
				<?php if($this->Direct_application_model->loa != ''){ ?>
				<br>
				<a href="<?= site_url($this->Direct_application_model->loa) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($this->Direct_application_model->loa); ?>"></a>
				<br/>
                <a href=<?= base_url('admin/nominee/direct_application/delete_file/loa/'.$this->Direct_application_model->id.'/'.$grantee_grant_id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
				<?php } ?>
				<input type="file" name="loa" id="" class="form-control">
                <small class="file-for-testing">File Size Max 5MB</small>
			</div> -->

		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="panel pull-right">
					<a href="<?php echo site_url('admin/nominee/direct_application/manage/' . $grantee_grant_id) ?>" class="btn btn-default">Back</a>
					<button type="submit" class="btn btn-success">Save</button>
				</div>
			</div>
		</div>
	</form>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->