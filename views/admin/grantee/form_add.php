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
    .list-group {
        z-index:10;
        display:none; 
        /* position:absolute;  */
        color:red;
        top:400px;
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
                                    <select class="form-control select2" name="grants" id="select-grant">
                                        <option value="">-- Choose Grants --</option>
                                        <?php
                                        if ($current_program_available) {
                                            foreach ($current_program_available as $program) {
                                                $selected = '';
                                                if ($post['grants'] == $program->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option data-year="<?= $program->year ?>" value="<?= $program->id ?>" <?= $selected ?>><?= $program->name ?> - <?= $program->year ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">    
                                    <label>Status</label>
                                    <select class="form-control select2" name="status" id="select-grant">
                                        <?php
                                        if ($current_program_available) {
                                            foreach ($select_status as $status) {
                                                ?>
                                                <option value="<?= $status['id'] ?>" ><?= $status['name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
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
                                    <input type="text" id="primary_email" class="form-control" placeholder="Email" name="primary_email" value="<?php echo $post['primary_email'] ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                    <!-- <i class="fa fa-eye password-show"></i> -->
                                </div>
								<div class="form-group list-group" id="d1">
									<span id="d12"><i class="fa fa-times" aria-hidden="true"></i> One Upper Case Letter</span> <br>
									<span id="d15"><i class="fa fa-times" aria-hidden="true"></i> One Number</span> <br>
									<span id="d16"><i class="fa fa-times" aria-hidden="true"></i> Length 8 Char</span> <br>
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
            
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> INFORMATION</p>
                        <div class="row p-4">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Home Institution</label>
                                    <input type="text" class="form-control" name="setting[home_institution]" placeholder="Home Institution">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Period From</label> 
                                <input readonly style="background-color:#fff" type="text" id="start_date" class="form-control datepicker" name="setting[periode_from]" placeholder="Period From" value="<?= ($post['setting']['periode_from']) ? date('d M Y', strtotime($post['setting']['periode_from'])) : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Period To</label>
                                <input readonly style="background-color:#fff" type="text" id="end_date" class="form-control datepicker" name="setting[periode_to]" placeholder="Period To" value="<?= ($post['setting']['periode_to']) ? date('d M Y', strtotime($post['setting']['periode_to'])) : '' ?>">
                            </div>  
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Fiscal Year</label>
                                <input type="text" class="form-control" name="setting[fiscal_year]" id="fiscal_year" value="<?php echo $post['setting']['fiscal_year'] ?>" readonly>
                                <!-- <select class="form-control" name="setting[fiscal_year]">
                                    <option value="">-- Select Year --</option>
                                    <?php
                                    $current_year = date('Y', strtotime('+3 years'));
                                    //$limit_year = $current_year - 20;
                                    $limit_year = 1952;
                                    for ($year = $current_year; $year >= $limit_year; $year--) {
                                        $selected = '';
                                        if ($grantee_setting->fiscal_year == $year) {
                                            $selected = 'selected="selected"';
                                        }
                                        else if(date('Y') == $year){
                                            $selected = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                                    <?php
                                }
                                ?>
                                </select> -->
                            </div>  
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="grant_total">Grant Total</label>
                                <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input style="z-index: 0" type="text" class="form-control" id="grant_total" name="setting[grant_total]" placeholder="Grant Total" value="<?= $post['setting']['grant_total'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="international_travel">International Travel</label>
                                <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input style="z-index: 0" type="number" class="form-control" id="international_travel" name="setting[international_travel]" placeholder="International Travel" value="<?= $post['setting']['international_travel'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="international_travel">Critical Language Enhancement Award</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-addon">USD</div>
                                    <input style="z-index: 0" type="number" class="form-control" id="international_travel" name="setting[clea]" placeholder="International Travel" value="<?= $grantee_setting->clea ? $grantee_setting->clea : 0; ?>">
                                </div> 
                                <div class="form-group">
                                    <label for="is_clea"><input type="checkbox" id="is_clea" name="setting[is_clea]" value="1" <?= $post['setting']['is_clea'] ? 'checked' : '' ?>> Is CLEA?</label>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="grant_support">Grant Support</label>
                                <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input style="z-index: 0" type="number" class="form-control" id="grant_support" name="setting[grant_support]" placeholder="Grant Support" value="<?= $post['setting']['grant_support'] ?>">
                                </div>
                                <input type="checkbox" value="1" autocomplete="off" name="setting[is_unlimited_grant_support]" id="is_unlimited_grant_support" <?= $post['setting']['is_unlimited_grant_support'] == 1 ? "checked" : "" ?>>
                                <label class="is_unlimited_label" for="is_unlimited_grant_support">To be Proposed</label>
                            </div>
                        </div>
                        
                        <div class="col-lg-4" id="source_of_funding" style="display:none;">
                            <div class="form-group">
                                <label style="margin-right:20px">Source of funding</label><br />
                                <div class="radio d-inline mr-4">
                                    <label><input type="radio" class="grant-alumni" name="setting[sumber_dana]" style="margin-top:1px" value="aminef">AMINEF</label>
                                </div>
                                <div class="radio d-inline">
                                    <label><input type="radio" class="grant-alumni" name="setting[sumber_dana]" style="margin-top:1px" value="world_learning">ECA</label>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <?php if ($this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
                    <div class="panel-body">
                        <p style="font-weight:bold;margin-bottom:25px;">
                            <i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> 
                            BANK & PAYMENT INFORMATION
                        </p>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="setting[require_bank_info]" value="1" checked/>
                                    Require bank account information in grantee profile
                                </label>
                                <div class="alert alert-info text-muted">
                                    <i class="fa fa-info-circle"></i> When enabled, grantees must complete their bank information before submitting their profile.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="setting[show_payment_schedule]" value="1" checked/>
                                    Display Payment Schedule menu
                                </label>
                                <div class="alert alert-info text-muted">
                                    <i class="fa fa-info-circle"></i> When enabled, grantees can view their payment schedule and transaction history.
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="panel-body" style="display:block">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Report Setting</p>
                        <img src="<?php echo base_url() ?>/img/loading.gif" id="report-spinner" style="display:none;">
                    </div>
                    <div id="wrap-category-report"></div>
                </div>
            </div>

            <div class="col-lg-12" style="margin-bottom:10px;">
                <div style="margin-bottom:10px;">

                    <?php
                    if ($post->id) {
                        ?>
                        <input type="hidden" name="id" id="uid" value="<?php echo $post->id ?>">
                    <?php } ?>
                    <a href="<?= site_url('admin/grantee/manage') ?>" class="btn btn-primary" style="float:left;">Back</a>
                    <button id="btn-submit-add" disabled class="btn btn-success btn-subpas" style="float:right;">Save</button>
                </div>
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