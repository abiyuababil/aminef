<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';

if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>
<div class="row">
    <div class="tab-content">
        <div id="info" class="tab-pane fade <?= $default_content_active ?>">
            <form role="form" method="POST" id="form_application" enctype="multipart/form-data">
                <div class="col-lg-8">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Title <small class="text-danger">*</small></label>
                            <input class="form-control" id="title" name="title" value="<?php echo (isset($this->Eta_host_school_applications_model->title)) ? $this->Eta_host_school_applications_model->title : '' ?>" placeholder="Title" required>
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                            <textarea class="form-control editor" name="description"><?= $this->Eta_host_school_applications_model->description ?></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>Start Date <small class="text-danger">*</small></label>
                        <input class="form-control flatpickrDateTime" name="start_date" value="<?php echo (isset($this->Eta_host_school_applications_model->start_date)) ? $this->Eta_host_school_applications_model->start_date : '' ?>" required>
                    </div>
                    <div class="col-lg-6">
                        <label>End Date <small class="text-danger">*</small></label>
                        <input class="form-control flatpickrDateTime" name="end_date" value="<?php echo (isset($this->Eta_host_school_applications_model->end_date)) ? $this->Eta_host_school_applications_model->end_date : '' ?>" required>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <div class="form-group">
                            <label> Notify to Email</label>
                            <input class="form-control" name="email" value="<?= (isset($this->Eta_host_school_applications_model->email)) ? $this->Eta_host_school_applications_model->email : '' ?>" placeholder="Email">
                            <small class="text-danger">for multiple email, separate email by semi colon (;)</small>
                        </div>
                        <div class="form-group">
                            <label>Guide File (PDF / Image / Doc)</label>
                            <?php if (!empty($this->Eta_host_school_applications_model->guide_file)) { ?>
                                <div style="margin-bottom:8px;">
                                    <a href="<?= base_url($this->Eta_host_school_applications_model->guide_file) ?>" target="_blank" class="btn btn-sm btn-outline-primary">View current guide</a>
                                </div>
                            <?php } ?>
                            <input type="file" name="guide_file" accept=".pdf,image/*,.doc,.docx" class="form-control">
                            <small class="text-muted">Optional. Upload a guide file for registrants.</small>
                        </div>
                        <div class="form-group">
                            <label> Is Active </label>
                            <input type="checkbox" value="1" name="is_active" <?= (!isset($this->Eta_host_school_applications_model->id)) || $this->Eta_host_school_applications_model->is_active == 1 ? "checked" : "" ?>>
                        </div>
                    </div>
                    <div class="col-lg-12 my-5">
                        <a href="<?php echo site_url('admin/eta_host_school_application/manage') ?>" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                        <?php
                        if (isset($this->Eta_host_school_applications_model->id)) {
                        ?>
                            <input type="hidden" id="id" name="id" value="<?php echo $this->Eta_host_school_applications_model->id ?>">
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
