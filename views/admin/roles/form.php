<style>
    .section_save {
        position: fixed;
        z-index: 26;
        background-color: #fff;
        bottom: 0
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $title ?></h1>
        <?php 
            $messagge = $this->session->flashdata('message_success');   
            $this->session->unset_userdata('message_success');
        ?>
        <?php if (isset($messagge)) : ?>
            <div class="alert alert-success"><?= $messagge ?></div>
        <?php endif; ?>
    </div>
    <!-- /.col-lg-12 -->
</div>


<form role="form" method="POST">
<div class="row">
    <div class="col-lg-6" style="margin-bottom: 150px;">
            <div class="form-group">
                <label>Role Name</label>
                <input class="form-control" name="name"
                       value="<?php echo (isset($this->Roles_model->name)) ? $this->Roles_model->name : '' ?>"
                       placeholder="eg: Admin" required>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Capabilities</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $feature => $permission) { 
                        if($permission['country_id'] == $this->session->userdata('active_country') || $permission['country_id'] == 999){ 
                    ?>
                    <tr>
                        <td><?= $permission['name'] ?></td>
                        <td>
                            <?php if(count($permission['capabilities']) > 1) { ?>
                            <div class="form-group">
                                <input type="checkbox" class="chk-all-role" id="ids_<?= $feature ?>" name="ids[]" data-feature="<?= $feature ?>" value="" style="cursor:pointer;">
                                <label for="ids_<?= $feature ?>" style="cursor:pointer;">Select All</label>
                            </div>
                            <?php } ?>
                            <?php 
                                foreach ($permission['capabilities'] as $capability => $name) { 
                                $arr = $role[$feature];
                                $checked = '';
                                if(!empty($arr)){
                                    $checked = in_array($capability, $arr) ? 'checked' : '';
                                }
                            
                            ?>
                            <div class="form-group">
                                <input class="chk-row-<?= $feature ?>" type="checkbox" value="<?= $capability ?>" name="permissions[<?= $feature; ?>][]" id="<?= $feature .'_'.$capability; ?>" style="cursor:pointer;" <?= $checked ?>>
                                <label for="<?= $feature .'_'.$capability; ?>" style="cursor:pointer;"> <?= $name ?> </label>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
    </div>
    <?php if(isset($staff_role)){ ?>
    <div class="col-lg-6">
		<h4 class="page-header"><b>Staff members which are using this role</b></h4>

        <table class="table table-striped">
            <?php foreach($staff_role as $staff) { ?>
            <tr>
                <td><a href="<?=base_url('admin/staffs/edit/'.$staff->id) ?>"><?= $staff->full_name ?></a></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <?php } ?>
</div>
<div class="row col-lg-12 section_save">
    <div class="panel-body">
        <div class="form-group">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </div>
</div>
</form>