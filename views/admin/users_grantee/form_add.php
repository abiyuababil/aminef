<?php

$active_country = $this->session->userdata('active_country');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
    td {
        height: 80px;
        vertical-align: top;
        padding:10px;
        font-weight:bold;
    }
    tr {
        margin-top:20px;
    }
</style>

<div class="modal"></div>

<div class="row">
    <div class="col-lg-12">
        <?php 
            $explode = explode('/', current_url());
            $url = end($explode);
            if($url != 'add'){
        ?>
        <a href="#" id="btn-deleted" class="btn btn-danger" style="float:right;margin: 20px 0;">Delete Grantee</a>
        <?php } ?>
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>

<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="row">

        <div class="tab-content">
            <div id="personal" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        
                        <div class="panel-body">
                            <div class="col-lg-5">
                                <div class="form-group">    
                                    <label>Choose Grants</label>
                                    <select class="form-control" name="grants">
                                        <option value="">-- Choose Grants --</option>
                                        <?php
                                        if ($program_available) {
                                            foreach ($program_available as $program) {
                                                $selected = '';
                                                if ($post['grants'] == $program->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option value="<?= $program->id ?>" <?= $selected ?>><?= $program->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-5">
                                <div class="form-group">    
                                    <label>Choose Period</label>
                                    <select class="form-control" name="period">
                                        <option value="">-- Choose Period --</option>
                                        <?php if ($post['grants']!= ''){
                                            foreach ($post['periods'] as $period) {
                                                $selected = '';
                                                if ($post['period'] == $period->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                            }
                                            ?>
                                            <option value="<?= $period->id ?>" <?= $selected ?>><?= $period->fiscal_year ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>First/Given Name</label>
                                    <input type="text" class="form-control" name="first_name" value="<?php echo $post['first_name'] ?>" placeholder="First/Given Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control" name="middle_name" value="<?php echo $post['middle_name'] ?>" placeholder="Middle Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Last/Family Name</label>
                                    <input type="text" class="form-control" name="last_name" value="<?php echo $post['last_name'] ?>" placeholder="Last/Family Name">
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="primary_email" class="form-control" placeholder="Email" name="primary_email" value="<?php echo $post['primary_email'] ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                    <!-- <i class="fa fa-eye password-show"></i> -->
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <a href="javascript:;" onclick="generate_pass()" class="btn btn-primary" style="margin-top:24px;">
                                        Generate
                                    </a>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" class="generate-load" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12" style="margin-bottom:10px;">
                <div style="margin-bottom:10px;">

                    <?php
                    if ($post->id) {
                        ?>
                        <input type="hidden" name="id" id="uid" value="<?php echo $post->id ?>">
                    <?php } ?>
                    <a href="<?= site_url('admin/users_grantee/manage') ?>" class="btn btn-primary" style="float:left;">Back</a>
                    <button id="btn-submit" class="btn btn-success" style="float:right;">Save</button>
                </div>
            </div>

        </div>
</form>


<!-- <div class="toolbar" style="position:fixed; bottom:20px; right:20px;">
    <button id="undo" type="button" class="btn btn-warning" disabled>
        <i class="fa fa-undo fa-fw"></i> Undo
    </button>
    <button id="redo" type="button" class="btn btn-warning" disabled>
        <i class="fa fa-undo fa-fw fa-flip-horizontal"></i> Redo
    </button>
    <button id="reset" type="button" class="btn btn-default" style="display:none">
        Reset
    </button>
    <span style="display:none">
        Action Count: <span id="cnt">0</span>
    </span>
</div> -->