<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= isset($this->User_grantee_grant_model->name) ? $this->User_grantee_grant_model->name : ''; ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if (isset($notif_success) && $notif_success != '') { ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $notif_success ?>
</div>
<?php } ?>

<form role="form" method="POST">

<?php
$active_country = $this->session->userdata('active_country');
?>

<?php
$i = 0;
foreach ($data as $arr) {
    ?>
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="row">
                        <a class="col-md-12" data-toggle="collapse" href="#collapse<?= $user_program_id . '_' . $i ?>" style="color:#fff">
                            <?= $arr[0]->group_name; ?>
                        </a>
                    </div>
                </h4>
            </div>
            <div id="collapse<?= $user_program_id . '_' . $i ?>" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="list-group sortable">
                        <?php
                        foreach ($arr as $obj) { 
                            $fo_val = $obj->id;
                            $label = $obj->field_name;

                        ?>
                            <div class="list-group-item" style="cursor:move">
                                <i class="fa fa-arrows"></i> &nbsp; <?php echo $label ?>
                                <input type="hidden" name="field_order[]" value="<?php echo $fo_val ?>">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $i++;
}
?>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12">
        <a href="<?php echo site_url('admin/program_properties/manage/'.$program_id) ?>" class="btn btn-warning">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

</form>
			
