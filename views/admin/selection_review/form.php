<div class="row">
    <div class="col-lg-12">
        <h1><?= $title ?></h1>
        <h3 class="page-header"><?= $active_grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<form id="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="section" value="selection_review_status">
    <input type="hidden" name="delete_selection_review" id="delete_selection_review">

    <?php $this->load->view('admin/selection_review/form_section_review') ?>

    <div class="row">
        <a href="<?= site_url('admin/review/manage')?>" type="button" class="btn btn-default">Back </a>
        <div class="panel pull-right">
            <button type="button" name="btn" data-id="<?= $grantee_grant_id ?>" data-section="selection_review" class="btn btn-danger reject">Reject</button>
            <button type="button" name="btn" value="save_selection_review" onclick="submit_form()" class="change btn btn-primary">Submit</button>
            <button type="submit" name="btn" value="submit_review" class="btn btn-success">Save</button>
            <!-- <button type="button" name="btn" value="not_recommended" onclick="notRecommended()" class="change btn btn-danger pull-right ml-1">Not Recommended</button>
            <button type="button" name="btn" value="recommended" onclick="recommended()" class="change btn btn-success pull-right ml-1">Recommended</button>
            <button type="button" name="btn" value="heighly_recommended" onclick="heighlyRecommended()" class="change btn btn-success pull-right">Highly Recommended</button> -->
        </div>
    </div>
</form>

<?php $this->load->view('admin/partials/modal_add_payment_record') ?>
<?php $this->load->view('admin/partials/modal_edit_payment_record') ?>
<?php $this->load->view('admin/partials/modal_reject_selection') ?>
<?php $this->load->view('admin/partials/modal_confirm') ?>


<?php
if (!empty($payment_record)) :
    $final_record = [];
    foreach ($payment_record as $record) {
        $final_record[$record->id] = $record;
    }
?>
    <script>
        var currentUserReviews = JSON.parse(`<?php echo safe_parse_json(json_encode($final_record)); ?>`);
    </script>
<?php endif; ?>

<div class="modal fade bd-example-modal-lg" id="view-detail-modal" tabindex="-1" role="dialog" aria-labelledby="interview-modal-pdf-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="interview-modal-pdf-label">
                    View Detail Score <a type="button" class="btn btn-warning pull-right" data-dismiss="modal" style="margin-top: -5px !important;">Close</a>
                    <a href="" target="_blank" class="btn btn-success btn-download-score pull-right mb-4 mr-2" style="margin-top: -5px !important;">
                        <span aria-hidden="true">Download</span>
                    </a>
                </h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-info text-center hide" id="loading-pdf"><i class="fa fa-spinner fa-spin"></i> Loading pdf, please wait.</div>
                <div class="row">
                    <div class="col-lg-12 render-view"></div>
                </div>
            </div>
        </div>
    </div>
</div>