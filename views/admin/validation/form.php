<style>
    .file-for-testing {
        display: none;
    }

    .autosave {
        margin-top: 5px;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h1><?= $title ?></h1>
        <h3 class="page-header"><?= $active_grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>
<form id="form" method="POST" enctype="multipart/form-data">
    <?php if($data_validation) : ?>
    <input type="hidden" name="validation_id" value="<?= $data_validation->id ?>">
    <?php endif; ?>
    <div class="row">
        <?php $this->load->view('admin/validation/form_section_validation') ?>
    </div>

    <div class="row">
        <a href="<?= site_url('admin/review/manage')?>" type="button" class="btn btn-default">Back </a>
        <div class="panel pull-right">
            <button type="button" name="btn" value="save" class="change btn btn-success" onclick="saveButton()">Save</button>
        </div>
    </div>
</form>

<?php $this->load->view('admin/partials/modal_reject_selection') ?>
