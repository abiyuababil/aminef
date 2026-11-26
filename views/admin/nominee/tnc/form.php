<style>
    .content-letter{
        background-color:#e9eef4;
        padding:10px 10px 0 10px;
        margin: 1em 0;
    }
</style>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?= $page_title ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row mb-5">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <form id="form" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Upload AMINEF T&C</label> 
                            <?php if($grantee_grant->tnc != '') { ?>
                                <br>
                                <a href="<?= site_url($grantee_grant->tnc) ?>" class="lightbox">
                                <img 
                                    class="mt-4"
                                    height="100"
                                    src="<?php echo get_preview($grantee_grant->tnc); ?>"
                                >
                                </a>
                                <a href="<?= base_url($grantee_grant->tnc) ?>" download title="Click to Download" class="btn btn-primary btn-xs mt-4" style="position:absolute;">
                                    <i class="fa fa-download fa-fw text-white"></i>
                                </a>
                                <?php if(!$grantee_grant->tnc_approver) { ?>
                                <a href="<?= base_url('admin/nominee/tnc/delete/'.$grantee_grant->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')" style="position:absolute;top: 63px;">
                                    <i class="fa fa-trash fa-fw text-white"></i>
                                </a>
                                <?php } ?>
                                <br />
                                <small>This document was uploaded by <?= $grantee_grant->upload_tnc_by_admin ? 'Admin' : $grantee_grant->grantee_name ?> - <?= date('d M Y / H:i', strtotime($grantee_grant->tnc_upload_date))?></small>
                                <?php if($grantee_grant->tnc_approver) { ?>
                                <br />
                                <small class="badge badge-success">Approved</small>
                                <?php } ?>
                            <?php } else { ?>
                                <br />
                                <small>Nominee Have Not Upload The Terms & Condition Yet.</small>
                            <?php } ?>
                            <input type="file" class="form-control mt-5" name="tnc">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12" style="margin-bottom:10px;">
        <div style="margin-bottom:10px;">
            <a href="<?= site_url('admin/nominee/manage') ?>" class="btn btn-primary mr-2" style="float:left;">Back</a>
            <button type="submit" form="form" value="upload" name="btn" class="btn btn-warning">Submit</button>
            <?php if($grantee_grant->tnc != '') { ?>
            <button type="submit" form="form" class="btn btn-success" name="btn" value="approve" <?= $grantee_grant->tnc_approver ? 'disabled' : '' ?>>Approve AMINEF T&C</button>
            <?php } ?>
        </div>
    </div>
</div>