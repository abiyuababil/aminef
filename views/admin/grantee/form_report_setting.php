<div class="row">
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
                <?php
                    $has_defaults = false;
                    $all_defaults_present = true;
                    foreach ($category_report as $cr) {
                        $sd_ok = (isset($cr->start_date) && $cr->start_date && $cr->start_date != '0000-00-00');
                        $ed_ok = (isset($cr->end_date) && $cr->end_date && $cr->end_date != '0000-00-00');
                        $rd_ok = (isset($cr->remainder_date) && $cr->remainder_date && $cr->remainder_date != '0000-00-00');
                        if ($sd_ok || $ed_ok || $rd_ok) {
                            $has_defaults = true;
                        }

                        $val = isset($category_report_value[$cr->id]) ? $category_report_value[$cr->id] : null;
                        $sd_val = ($val && !empty($val->report_date));
                        $ed_val = ($val && !empty($val->report_end_date));
                        $rd_val = ($val && !empty($val->remainder_date));

                        if (!($sd_val && $ed_val && $rd_val)) {
                            $all_defaults_present = false;
                        }
                    }
                ?>
                <div class="panel-body" style="display:block">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> REPORT SETTING
                        <?php if ($has_defaults) { ?>
                            <button type="button" id="apply-default-reports" class="btn btn-sm btn-info" style="margin-left:20px;">Apply From Defaults</button>
                        <?php } ?>
                    </p>
                </div>
                <?php foreach ($category_report as $key => $cr) { ?>
                    <div class="panel_body" style="margin-top:-30px;">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?= $cr->name ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="margin-top:-30px;">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input readonly style="background-color:#fff" type="text" class="form-control datepicker start_date" data-cr_id="<?= $cr->id ?>" name="report_date[<?= $cr->id ?>][date]" placeholder="Start Date" value="<?= ($category_report_value[$cr->id]->report_date) ? date('d M Y', strtotime($category_report_value[$cr->id]->report_date)) : '' ?>">
                                <input type="hidden" name="report_date[<?= $cr->id ?>][user_id]" value="<?= $grantee_grant->user_grantee_id ?>">
                                <input type="hidden" name="report_date[<?= $cr->id ?>][grant_id]" value="<?= $grantee_grant->grant_id ?>">
                                <input type="hidden" name="report_date[<?= $cr->id ?>][grantee_grant_id]" value="<?= $grantee_grant->id ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>End Date</label>
                                <input readonly style="background-color:#fff" type="text" class="form-control datepicker" name="report_date[<?= $cr->id ?>][end_date]" placeholder="End Date" value="<?= ($category_report_value[$cr->id]->report_end_date) ? date('d M Y', strtotime($category_report_value[$cr->id]->report_end_date)) : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Reminder Date</label>
                                <input readonly style="background-color:#fff" type="text" class="form-control datepicker" name="report_date[<?= $cr->id ?>][remainder]" placeholder="Reminder Date" value="<?= ($category_report_value[$cr->id]->remainder_date) ? date('d M Y', strtotime($category_report_value[$cr->id]->remainder_date)) : '' ?>">
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($has_defaults) { 
                    $defaults = [];
                    foreach ($category_report as $cr) {
                        $sd = (isset($cr->start_date) && $cr->start_date && $cr->start_date != '0000-00-00') ? date('d M Y', strtotime($cr->start_date)) : '';
                        $ed = (isset($cr->end_date) && $cr->end_date && $cr->end_date != '0000-00-00') ? date('d M Y', strtotime($cr->end_date)) : '';
                        $rd = (isset($cr->remainder_date) && $cr->remainder_date && $cr->remainder_date != '0000-00-00') ? date('d M Y', strtotime($cr->remainder_date)) : '';
                        $defaults[$cr->id] = ['start' => $sd, 'end' => $ed, 'reminder' => $rd];
                    }
                    ?>
                    <script>
                        window.__reportDefaults = <?php echo json_encode($defaults); ?>;
                    </script>
                <?php } ?>

                <?php if (!empty($category_report) && !$all_defaults_present) { ?>
                    <div class="col-md-12"> 
                        <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Attention:</strong> Some report settings are still empty. Please fill them in and save.
                        </div>
                    </div>
                <?php } ?>
                <div class="col-lg-12 mt-3" style="margin-bottom:10px;">
                    <div style="margin-bottom:10px;">
                        <?php if (is_admin()) { ?>
                            <a href="<?= site_url('admin/grantee/grants/' . $grantee_grant->user_grantee_id) ?>" class="btn btn-primary" style="float:left;">Back</a>
                        <?php } ?>
                        <button id="btn-submit" class="btn btn-success btn-submit" name="btn-submit" value="save_setting" style="float:right;">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
