<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>

<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <?php if(isset($uncomitted)) { ?>
        <input type="hidden" name="id" value="<?= $uncomitted->id ?>">
    <?php } ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Fiscal Year <small class="text-danger">*</small></label>
                <select class="form-control" name="fiscal_year" required>
                    <option value="">-- Select Year --</option>
                    <?php
                    $current_year = date('Y');
                    $limit_year = 1952;
                    for ($year = $current_year; $year >= $limit_year; $year--) {
                        $selected = '';
                        if ($uncomitted->fiscal_year == $year) {
                            $selected = 'selected="selected"';
                        }
                        ?>
                        <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                    <?php
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Name <small class="text-danger">*</small></label>
                <input type="text" class="form-control" name="name" value="<?= $uncomitted->name ?>" required>
            </div>
            <div class="form-group" style="margin-bottom:10px">
                <div style="margin-bottom:10px;">
                    <a href="<?php echo site_url('admin/uncomitted/manage') ?>" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Grants</label>
                <select class="form-control formselect2" name="user_grantee_grant">
                    <option value="">-- Select Grants --</option>
                    <?php foreach( $program_available as $program) { 
                        $selected = '';
                        if ($uncomitted->user_grantee_grant_id == $program->id) {
                            $selected = 'selected="selected"';
                        }
                    
                    ?>
                        <option <?= $selected ?> value="<?= $program->id?>"><?= $program->name ?> <?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? ' - ' . $program->year : '' ?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Total Balance <small class="text-danger">*</small></label>
                <input type="text" class="form-control" name="total_balance" value="<?= $uncomitted->total_balance ?>" required>
            </div>
        </div>
    </div>
</form>

