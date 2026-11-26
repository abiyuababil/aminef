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
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Prefix</label>
                            <select class="form-control" name="prefix">
                                <option value="">-- Select Prefix --</option>
                                <?php
                                if ($titles) {
                                    foreach ($titles as $tt) {
                                        $selected = '';
                                        if ($this->Panelist_eec_ent_model->prefix == $tt) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?php echo $tt ?>" <?php echo $selected ?>><?php echo $tt ?></option>
                                    <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name <small class="text-danger">*</small></label>
                            <input class="form-control" name="name" value="<?php echo (isset($this->Panelist_eec_ent_model->name)) ? $this->Panelist_eec_ent_model->name : '' ?>" <?php //echo (isset($this->Panelist_eec_ent_model->name) && !$is_panellist) ? 'readonly' : '' ?> placeholder="Name Panellist" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Email <small class="text-danger">*</small></label>
                            <input type="email" class="form-control" name="email" value="<?php echo (isset($this->Panelist_eec_ent_model->email)) ? $this->Panelist_eec_ent_model->email : '' ?>" placeholder="eg: example@aminef.com" required>
                        </div>
                    </div>
                    <?php if(!$is_panellist) { ?>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label> Is Active </label>
                            <input type="checkbox" value="1" name="status" <?= $this->Panelist_eec_ent_model->status == 1 ? "checked" : "" ?>>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-lg-12 mb-5">
                        <?php if(!$is_panellist) { ?>
                        <a href="<?php echo site_url('admin/panelist_eec/manage') ?>" class="btn btn-default">Back</a>
                        <?php } ?>
                        <button type="submit" class="btn btn-success">Save</button>
                        <?php
                        if (isset($this->Panelist_eec_ent_model->id)) {
                        ?>
                            <input type="hidden" name="id" value="<?php echo $this->Panelist_eec_ent_model->id ?>">
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>