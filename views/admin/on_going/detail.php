<?php if(!$is_alumni_page) { ?>
<div class="row">
    <div class="col-lg-12">
        <h1><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header"><?= $grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>
<?php } ?>

<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>

<?php $this->load->view('admin/partials/tab_detail_ongoing') ?>