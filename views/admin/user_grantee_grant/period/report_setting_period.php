<div class="col-lg-12">
    <h1 class="page-header"><?php echo $title ?> (<?= $detail_grant->name; ?>)</h1>
</div>
<div class="col-md-12">
    <div class="panel-body" style="display:block">
        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Report Setting</p>
    </div>
    <form method="POST">
    <?php foreach ($category_report as $key => $cr) {  ?>
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
                    <input readonly style="background-color:#fff" type="text" data-cr_id="<?= $cr->id ?>" class="form-control datepicker" name="report_date[<?= $cr->id ?>][date]" placeholder="Start Date" value="<?= ($cr->start_date) ? date('d M Y', strtotime($cr->start_date)) : '' ?>">
                    <input type="hidden" name="report_date[<?= $cr->id ?>][report_id]" value="<?= $cr->id ?>">
                    <input type="hidden" name="report_date[<?= $cr->id ?>][period_id]" value="<?= $period_id ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>End Date</label>
                    <input readonly style="background-color:#fff" type="text" class="form-control datepicker" name="report_date[<?= $cr->id ?>][end_date]" placeholder="End Date" value="<?= ($cr->end_date) ? date('d M Y', strtotime($cr->end_date)) : '' ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Reminder Date</label>
                    <input readonly style="background-color:#fff" type="text" class="form-control datepicker" name="report_date[<?= $cr->id ?>][remainder]" placeholder="Reminder Date" value="<?= ($cr->remainder_date) ? date('d M Y', strtotime($cr->remainder_date)) : '' ?>">
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="panel-body">
        <a href="<?= $link_back; ?>" class="btn btn-primary">Back</a>
        <button type="submit" class="btn btn-success" style="float:right;">Save</button>
    </div>
    </form>
</div>