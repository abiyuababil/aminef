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
            <form role="form" method="POST">
                <div class="col-lg-8">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Title <small class="text-danger">*</small></label>
                            <input class="form-control" name="title" value="<?php echo (isset($this->Form_panellists_model->title)) ? $this->Form_panellists_model->title : '' ?>" placeholder="Title" required>
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                            <textarea class="form-control editor" name="description"><?= $this->Form_panellists_model->description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label> Is Active </label>
                            <input type="checkbox" value="1" name="is_active" <?= (!isset($this->Form_panellists_model->id)) || $this->Form_panellists_model->is_active == 1 ? "checked" : "" ?>>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-5">
                        <a href="<?php echo site_url('admin/panelist/form') ?>" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                        <?php
                        if (isset($this->Form_panellists_model->id)) {
                        ?>
                            <input type="hidden" name="id" value="<?php echo $this->Form_panellists_model->id ?>">
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
