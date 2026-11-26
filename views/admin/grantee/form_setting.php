<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?= get_full_name($grantee_grant, $grantee_grant->country_id == INDONESIAN_DATABASE ? 'ID' : 'US') ?>
        </h1>
        <h4><?= $grantee_grant->grant_name ?></h4>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<form action="" method="POST" id="form">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> INFORMATION</p>
                    <div class="row pl-4" style="padding-right: 40px;">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Home Institution</label>
                                <input type="text" class="form-control" name="setting[home_institution]" placeholder="Home Institution" value="<?php echo $grantee_setting->home_institution; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row col-lg-12">
                        <?php //if($grantee_grant->country_id == INDONESIAN_DATABASE) { 
                        ?>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Fiscal Year</label>
                                <select class="form-control" name="setting[fiscal_year]">
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
                                    ?>
                                        <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php //} 
                        ?>
                        <?php if ($grantee_grant->country_id == AMERICAN_DATABASE) { ?>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Period From</label>
                                    <input readonly style="background-color:#fff" type="text" class="form-control datepickerperiod" id="start_date" name="setting[periode_from]" placeholder="Period From" value="<?= ($grantee_setting->start_date) ? date('d M Y', strtotime($grantee_setting->start_date)) : '' ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Period To</label>
                                    <input readonly style="background-color:#fff" type="text" class="form-control datepickerperiod" id="end_date" name="setting[periode_to]" placeholder="Period To" value="<?= ($grantee_setting->end_date) ? date('d M Y', strtotime($grantee_setting->end_date)) : '' ?>">
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row col-lg-12">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET SETTING</p>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="grant_total">Grant Allocation</label>
                                <div class="input-group">
                                    <div class="input-group-addon">USD</div>
                                    <input style="z-index: 0" type="text" class="form-control currency-usd" id="grant_total" name="setting[grant_total]" placeholder="Grant Total" value="<?= $grantee_setting->total_grant ?>" <?= $grantee_setting->is_unlimited_grant_total == 1 ? "readonly" : "" ?>>
                                </div>
                                <?php if ($grantee_grant->country_id == INDONESIAN_DATABASE) { ?>
                                    <input type="checkbox" value="1" autocomplete="off" name="setting[is_unlimited_grant_total]" id="is_unlimited_grant_total" <?= $grantee_setting->is_unlimited_grant_total == 1 ? "checked" : "" ?>>
                                    <label class="is_unlimited_label" for="is_unlimited_grant_total">To be Proposed</label>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="international_travel">International Travel Allocation</label>
                                <div class="input-group">
                                    <div class="input-group-addon">USD</div>
                                    <input style="z-index: 0" type="text" class="form-control currency-usd" id="international_travel" name="setting[international_travel]" placeholder="International Travel" value="<?= $grantee_setting->international_travel ?>" <?= $grantee_setting->is_unlimited_international_travel == 1 ? "readonly" : "" ?>>
                                </div>
                                <?php if ($grantee_grant->country_id == INDONESIAN_DATABASE) { ?>
                                    <input type="checkbox" value="1" autocomplete="off" name="setting[is_unlimited_international_travel]" id="is_unlimited_international_travel" <?= $grantee_setting->is_unlimited_international_travel == 1 ? "checked" : "" ?>>
                                    <label class="is_unlimited_label" for="is_unlimited_international_travel">To be Proposed</label>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($grantee_grant->country_id == AMERICAN_DATABASE) { ?>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="international_travel">Critical Language Enhancement Award</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-addon">USD</div>
                                        <input style="z-index: 0" type="text" class="form-control currency-usd" id="international_travel" name="setting[clea]" placeholder="International Travel" value="<?= $grantee_setting->clea ? $grantee_setting->clea : 0; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="is_clea"><input type="checkbox" id="is_clea" name="setting[is_clea]" value="1" <?= $grantee_setting->is_clea ? 'checked' : '' ?>> Is CLEA?</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="grant_support">Grant Supporting Allocation</label>
                                <div class="input-group">
                                    <div class="input-group-addon">USD</div>
                                    <input style="z-index: 0" type="text" data-value="<?= $grantee_setting->grant_support ?>" class="form-control currency-usd" id="grant_support" name="setting[grant_support]" placeholder="Grant Support" value="<?= $grantee_setting->grant_support ?>" <?= $grantee_setting->is_unlimited_grant_support == 1 ? "readonly" : "" ?>>
                                </div>
                                <input type="checkbox" value="1" autocomplete="off" name="setting[is_unlimited_grant_support]" id="is_unlimited_grant_support" <?= $grantee_setting->is_unlimited_grant_support == 1 ? "checked" : "" ?>>
                                <label class="is_unlimited_label" for="is_unlimited_grant_support">To be Proposed</label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($grantee_grant->country_id == AMERICAN_DATABASE) { ?>
                    <div class="panel-body hide" style="margin-top:-30px;">
                        <!-- <div class="col-lg-4">
                        <div class="form-group">
                            <label>Period From</label>
                            <input readonly style="background-color:#fff" type="text" class="form-control datepickerperiod" id="start_date" name="setting[periode_from]" placeholder="Period From" value="<?= ($grantee_setting->start_date) ? date('d M Y', strtotime($grantee_setting->start_date)) : '' ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Period To</label>
                            <input readonly style="background-color:#fff" type="text" class="form-control datepickerperiod" id="end_date" name="setting[periode_to]" placeholder="Period To" value="<?= ($grantee_setting->end_date) ? date('d M Y', strtotime($grantee_setting->end_date)) : '' ?>">
                        </div>  
                    </div> -->
                        <!-- <div class="col-lg-4"> -->
                        <!-- <div class="form-group"> -->
                        <!-- <label>Fiscal Year</label> -->
                        <!-- <input type="text" class="form-control" name="setting[fiscal_year]" value="<?= $grantee_setting->fiscal_year ?>" readonly> -->
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
                                ?>
                                    <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                                <?php
                                }
                                ?>
                            </select> -->
                        <!-- </div>   -->
                        <!-- </div> -->
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label style="margin-right:20px">Source of Funds</label><br />
                                <label style="margin-right: 10px;"><input type="radio" class="grant-alumni" name="setting[sumber_dana]" style="margin-top:1px;" value="aminef" <?= $grantee_setting->sumber_dana == 'aminef' ? 'checked' : '' ?>> Aminef</label>
                                <label><input type="radio" class="grant-alumni" name="setting[sumber_dana]" style="margin-top:1px" value="world_learning" <?= $grantee_setting->sumber_dana == 'world_learning' ? 'checked' : '' ?>> World Learning</label>
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
                                        <input type="checkbox" name="setting[require_bank_info]" value="1" <?= $grantee_setting->require_bank_info ? 'checked' : ''; ?>/>
                                        Require bank account information in grantee profile
                                    </label>
                                    <div class="alert alert-info text-muted">
                                        <i class="fa fa-info-circle"></i> When enabled, grantees must complete their bank information before submitting their profile.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="setting[show_payment_schedule]" value="1" <?= $grantee_setting->show_payment_schedule ? 'checked' : ''; ?>/>
                                        Display Payment Schedule menu
                                    </label>
                                    <div class="alert alert-info text-muted">
                                        <i class="fa fa-info-circle"></i> When enabled, grantees can view their payment schedule and transaction history.
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="col-lg-12 mt-3" style="margin-bottom:10px;">
                    <div style="margin-bottom:10px;">

                        <?php
                        if ($this->Grantee_ent_model->id) {
                        ?>
                            <input type="hidden" name="id" id="uid" value="<?php echo $this->Grantee_ent_model->id ?>">
                        <?php } ?>
                        <?php if (is_admin()) { ?>
                            <a href="<?= site_url('admin/grantee/grants/' . $grantee_grant->user_grantee_id) ?>" class="btn btn-primary" style="float:left;">Back</a>
                        <?php } ?>
                        <?php //if($grantee_grant->status != STATUS_SET_TO_ALUMNI) { 
                        ?>
                        <button id="btn-submit" class="btn btn-success btn-submit" name="btn-submit" value="save_setting" style="float:right;">Save</button>
                        <?php //} 
                        ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</form>