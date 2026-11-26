<style>
    .content-letter{
        background-color:#e9eef4;
        padding:10px 10px 0 10px;
        margin: 1em 0;
    }
</style>
<?php if(!$is_alumni_page) { ?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?= $page_title ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<?php } ?>
<!-- /.row -->
<div class="row mb-5 warp-alumni-page">
	<div class="col-lg-12">
		<form role="form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Medical Form</label>
                <?php if ($this->Other_documents_model->medical_form != '') { ?>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?php echo base_url() ?><?php echo $this->Other_documents_model->medical_form ?>" class="lightbox"><img height="100" src="<?php echo get_preview($this->Other_documents_model->medical_form); ?>"></a>
				<br/>
                <a href=<?= base_url('admin/nominee/other_documents/delete_file/medical_form/'.$this->Other_documents_model->id.'/'.$grantee_grant_id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
                    </div>
                <?php } ?>
                <input type="file" name="medical_form" id="" class="form-control">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
            <div class="form-group">
                <label>Passport</label>
                <?php if ($this->Other_documents_model->passport != '') { ?>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?php echo base_url() ?><?php echo $this->Other_documents_model->passport ?>" class="lightbox"><img height="100" src="<?php echo get_preview($this->Other_documents_model->passport); ?>"></a>
				<br/>
                <a href=<?= base_url('admin/nominee/other_documents/delete_file/passport/'.$this->Other_documents_model->id.'/'.$grantee_grant_id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
                    </div>
                <?php } ?>
                <input type="file" name="passport" id="" class="form-control">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>

            <!-- letter_for_supervisor -->
            <?php $this->load->view('admin/nominee/other_documents/letter_for_supervisor'); ?>


            <?php if(!$is_alumni_page) { ?>
			<a href="<?php echo $back_url ?>" class="btn btn-default">Back</a>
			<button type="submit" class="btn btn-success">Submit</button>
            <?php } ?>
		</form>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<?php $this->load->view('admin/nominee/other_documents/additional_letter_for_supervisor'); ?>