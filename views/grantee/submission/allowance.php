
<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Allowance</h2>
        <h1 class="page-header"><?php echo $title ?></h1>
        <!-- <h2><?= $grantee_grant->status_name ?></h2> -->
    </div>
</div>
<div class="row">
    <?php if ($success = $this->session->flashdata('success')) : ?>
        <?= show_alert('success', $success); ?>
    <?php endif; ?>
</div>
<?php 
    $this->session->unset_userdata('success');
    $status_visa = [
        STATUS_CANDIDATE_VERIFIED ,
        STATUS_RETURNING_SUCCESSFUL, 
        STATUS_NEW_RETURNING, 
        STATUS_RETURNING_REVISED,
        STATUS_SET_TO_ALUMNI
    ];
?>

<?php $this->load->view('admin/allowance/detail') ?>

<?php $this->session->unset_userdata('last_tab_visa'); ?>
<?php $this->session->unset_userdata('last_list'); ?>
