<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$pid = $this->input->get('pid');
if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $data->year ?? 'Add Fiscal Year' ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <form id="form" role="form" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Fiscal Year</label>
                                <input type="text" class="form-control" name="year" value="<?= $data->year ?? '' ?>" required>
                                <?php if($data->id) { ?>
                                    <input type="hidden" name="id" value="<?= $data->id ?>">
                                <?php } ?>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label> Is Active </label>
                                    <input type="checkbox" value="1" name="is_active_fiscal_year" <?= (!isset($data->id)) || $data->is_active == 1 ? "checked" : "" ?>>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="<?= site_url('admin/settings_det/manage') ?>" class="btn btn-default">Back</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>