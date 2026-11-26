
<link href="<?php echo base_url() ?>css/jquery-ui.min.css" rel="stylesheet">
<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Pre Departure Orientation</h2>
        <h1 class="page-header"><?= $grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" style="margin-bottom:10px">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissable text-justify">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php } ?>
        <?php $this->session->unset_userdata('success');?>
    </div>
</div>

<?php $this->load->view('admin/pre_depature/form') ?>