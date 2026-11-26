<style>
    #wrap-filter .select2 {
        border-radius: 0px !important;
        width: 250px !important;
        height: 35px !important;
        padding-top: 2px !important;
        /* border: 1px solid #ccc; */
    }

    #wrap-filter span.select2.select2-container {
        border-radius: 0px !important;
        width: 250px !important;
        height: 34px !important;
        padding-top: 2px !important;
        /* border: 1px solid #ccc; */
    }

    #wrap-filter .select2-selection.select2-selection--single {
        border-radius: 0px !important;
        width: 250px !important;
        height: 34px !important;
        padding-top: 2px !important;
        border: 1px solid #ccc;
    }

    #wrap-filter .select2-selection__arrow {
        margin-top: 5px !important;
    }
</style>
<style>
    .select2-container .select2-selection {
        max-height: 60px;
        overflow: auto;
    }

    .data-header {
        padding-top: 10px !important;
    }

    .program-filter-section {
        display: flex;
    }

    .program-filter-section>.form-group {
        width: 350px;
        margin-left: 12px;
    }

    .select2-container--bootstrap .select2-selection {
        border-radius: 0px !important;
    }

    .select2-selection--single>.select2-selection__rendered {
        margin-top: 5px !important;
    }

    .select2-selection--single {
        overflow: hidden !important;
    }

    label {
        font-weight: normal !important;
    }



    .modal-box {
      background: #ffffff;
      width: 650px;
      max-width: 95%;
      border-radius: 6px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.25);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }
    .modal-header-area {
      padding: 16px 22px 10px 22px;
      border-bottom: 1px solid #edf2f7;
    }

    .modal-main-title {
      font-size: 16px;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 2px;
    }

    .modal-subtitle {
      font-size: 12px;
      color: #64748b;
    }

    .modal-body-area {
      padding: 18px 22px;
    }

    .modal-card-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .info-card {
      border: 1px solid #dbeafe;
      border-radius: 6px;
      padding: 14px 16px;
      background: #ffffff;
    }

    .info-card-title {
      font-size: 11px;
      font-weight: 700;
      color: #0284c7;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 12px;
    }


    /* Form Fields di Modal Withdrawn */
    .form-group-custom {
      margin-bottom: 14px;
    }

    .form-group-custom label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: #475569;
      margin-bottom: 5px;
    }

    .form-group-custom textarea {
      width: 100%;
      height: 75px;
      padding: 8px 10px;
      border: 1px solid #cbd5e1;
      border-radius: 4px;
      font-size: 12px;
      box-sizing: border-box;
      resize: vertical;
    }

    /* Upload Box Modern & Rapi */
    .file-dropzone {
      border: 2px dashed #cbd5e1;
      border-radius: 6px;
      background-color: #f8fafc;
      padding: 14px;
      text-align: center;
      cursor: pointer;
      transition: border-color 0.2s, background-color 0.2s;
    }

    .file-dropzone:hover {
      border-color: #0284c7;
      background-color: #f0f7ff;
    }

    .file-dropzone i {
      font-size: 22px;
      color: #0284c7;
      margin-bottom: 4px;
    }

    .file-dropzone-text {
      font-size: 12px;
      color: #475569;
    }

    .file-dropzone-hint {
      font-size: 11px;
      color: #94a3b8;
      margin-top: 2px;
    }

    .file-selected-name {
      margin-top: 6px;
      font-size: 12px;
      font-weight: 600;
      color: #0284c7;
      display: none;
    }

    .modal-footer-area {
      padding: 12px 22px 16px 22px;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 8px;
      border-top: 1px solid #edf2f7;
    }

    .btn-close-modal {
      background-color: #ffffff;
      color: #334155;
      border: 1px solid #cbd5e1;
      padding: 6px 16px;
      font-size: 12px;
      font-weight: 600;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-approve-modal {
      background-color: #4CAF50;
      color: #ffffff;
      padding: 6px 16px;
      font-size: 12px;
      font-weight: bold;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-approve-modal:hover {
      background-color: #43a047;
    }

    .btn-submit-withdrawn {
      background-color: #d9534f;
      color: #ffffff;
      padding: 6px 16px;
      font-size: 12px;
      font-weight: bold;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-submit-withdrawn:hover {
      background-color: #c9302c;
    }

    .modal-body-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 13px;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
      font-size: 12px;
    }

    .info-row:last-child {
      margin-bottom: 0;
    }

    .info-label {
      color: #475569;
    }

    .info-val {
      font-weight: 600;
      color: #0f172a;
      text-align: right;
    }

    /* Action Buttons di Dalam Modal */
    .btn-view-doc {
      background-color: #2b7bb9;
      color: white;
      padding: 4px 14px;
      font-size: 11px;
      font-weight: bold;
      border-radius: 3px;
      text-decoration: none;
      display: inline-block;
    }

    .btn-view-doc:hover {
      background-color: #205e8d;
    }

    /* Modal Footer */
    .modal-footer-area {
      padding: 12px 24px 18px 24px;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 10px;
      border-top: 1px solid #edf2f7;
    }

    .btn-close-modal {
      background-color: #ffffff;
      color: #334155;
      border: 1px solid #cbd5e1;
      padding: 6px 18px;
      font-size: 12px;
      font-weight: 600;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-close-modal:hover {
      background-color: #f1f5f9;
    }

    .btn-approve-modal {
      background-color: #4CAF50;
      color: #ffffff;
      padding: 6px 18px;
      font-size: 12px;
      font-weight: bold;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-approve-modal:hover {
      background-color: #43a047;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?= $page_title ?>
            <a href="javascript:;" data-section="<?= $section ?>" onclick="show_download_modal(this)"
               class="btn btn-primary btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                DOWNLOAD EXCEL
            </a>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action-bulk" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="proceed">Proceed</a></li>
                            <li><a href="javascript:;" data-action="reject">Reject</a></li>
                        </ul>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>
                    <strong class="btn btn-info info-selected hide"><span id="selected-count">0</span> selected</strong>
                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit'])
                                $selected = 'selected';
                            ?>
                            <option value="<?= $lo ?>" <?= $selected ?>>
                                <?= $lo ?>
                            </option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <div class="pull-right">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Keyword : <input type="search" class="form-control input-sm" name="q[]"
                        value="<?= isset($q[0]) ? $q[0] : '' ?>" placeholder=""
                        onkeypress="return submitFilter(event)">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <?php if($page_title == 'Submitted') { ?>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <?php } ?>
                            <th width="35" class="text-center">#</th>
                            <th <?= sorting_attribute('grantee_name', $sort_by, $sort) ?>>Name</th>
                            <th <?= sorting_attribute('period_id', $sort_by, $sort) ?>>Fiscal Year</th>
                            <?php if($page_title != 'Participants') { ?>
                            <th <?= sorting_attribute(($page_title == 'Submitted' || $page_title == 'Testing' ? 'submitted_date' : 'create_date'), $sort_by, $sort) ?>><?= $page_title == 'Submitted' || $page_title == 'Testing' ? 'Submitted Date' : 'Join Date' ?></th>
                            <?php } ?>
                            <?php if($page_title == 'Testing') { ?>
                                <th>Deadline Date</th>
                                <th>Coupon Code</th>
                                <th>Test Period Schedule</th>
                                <th>Score</th>
                            <?php } ?>
                            <?php if($page_title != 'Participants') { ?>
                            <th <?= sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
                            <?php } ?>
                            <?php if($page_title == 'Participants') { ?>
                                <th>Terms</th>
                                <th>Period</th>
                            <?php } ?>
                            <th width="100" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {

                            $no = $paging['start_row'];
                        
                            foreach ($data as $row) {
                                ?>
                                <tr>
                                    <?php if($page_title == 'Submitted') { ?>
                                    <td>
                                        <input type="checkbox" class="chk-row" name="ids[]" value="<?= $row->id ?>">
                                    </td>
                                    <?php } ?>
                                    <td>
                                        <?= $no++ ?>
                                    </td>
                                    <td><a target="_BLANK"
                                            href="<?= base_url('admin/users_det/edit/' . $row->user_id); ?>"
                                            class="<?= $row->blacklist ? 'text-danger font-weight-bold' : '' ?>">

                                            <?= get_full_name($row) ?>
                                        </a></td>
                                    <td>
                                        <?= $row->year; ?>
                                    </td>
                                    <?php if($page_title != 'Participants') { ?>
                                    <td>
                                        <?= $page_title == 'Submitted' || $page_title == 'Testing' ? $row->submitted_date : $row->create_date ?>
                                    </td>
                                    <?php } ?>
                                    <?php if($page_title == 'Testing') { ?>
                                        <td>
                                            <input type="text" data-field="deadline_date_agreement" data-id="<?= $row->id ?>" class="datetime form-control input_coupon input_data" value="<?= $row->deadline_date_agreement ? date('m/d/Y H:i', strtotime($row->deadline_date_agreement)) : '' ?>">
                                        </td>
                                        <td>
                                            <input type="text" data-field="coupon" data-id="<?= $row->id ?>" class="form-control input_coupon input_data" value="<?= $row->coupon ?>">
                                        </td>
                                        <td>
                                            <input 
                                                type="text" 
                                                name="testing_date" 
                                                id="testing_date_det_<?= $row->id ?>" 
                                                class="form-control dateRangePicker testing_date_det input_data"
                                                data-field="schedule"
                                                data-id="<?= $row->id ?>"
                                                data-start-date="<?= $row->testing_date ?>"
                                                data-end-date="<?= $row->testing_date_end ?>"
                                            >
                                        </td>
                                        <td>
                                            <input type="number" data-field="score" data-id="<?= $row->id ?>" class="form-control input_coupon input_data" value="<?= $row->score ?>">
                                        </td>
                                        <!-- <td><?php //$row->coupon ?></td>
                                        <td><?php //formatDateRange($row->testing_date, $row->testing_date_end) ?></td> -->
                                    <?php } ?>

                                    <?php if($page_title == 'Participants') { ?>
                                        <td><?= $row->term_name ?></td>
                                        <td><?= $row->cycle ?></td>
                                    <?php } ?>
                                    <?php if($page_title != 'Participants') { ?>
                                    <td>
                                        <?= get_status_name_det($row->status); ?>
                                    </td>
                                    <?php } ?>
                                    <td  class="text-center" style="display: flex;justify-content: center;gap: 5px;flex-direction: column;">
                                        <?php //if($page_title == 'Testing' && $row->status == STATUS_DET_COMPLETE && $row->status_agreement == 'approve') { ?>
                                            <!-- <button 
                                                type="button" 
                                                class="btn btn-default btn-xs add_coupon" 
                                                data-coupon="<?= $row->coupon ?>" 
                                                data-testing="<?= $row->testing_date ? date('d M Y', strtotime($row->testing_date)) : '' ?>"
                                                data-testing-end="<?= $row->testing_date_end ? date('d M Y', strtotime($row->testing_date_end)) : '' ?>"
                                                data-application ="<?= $row->id ?>" 
                                                title="Coupon">
                                            <i class="fa fa-ticket"></i> Add Coupon Code
                                            </button> -->
                                        <?php //} ?>
                                        <?php if($page_title == 'Testing') { ?>
                                            <!-- <button 
                                                type="button" 
                                                class="btn btn-success btn-xs send_tnc" 
                                                data-coupon="<?= $row->coupon ?>" 
                                                data-application ="<?= $row->id ?>" 
                                                title="Send Agreement">
                                            <?= $row->send_email_tnc_date ? '<i class="fa fa-check-circle"></i> ' : '' ?>Send Agreement
                                            </button> -->
                                            
                                            <?php 
                                                if($row->status_agreement == 'approve'){
                                                    $classBtn = 'success';
                                                    $labelBtn = 'Approved';
                                                }else if($row->status_agreement == 'revise'){
                                                    $classBtn = 'warning';
                                                    $labelBtn = 'Revise';
                                                }else{
                                                    $classBtn = 'info';
                                                    $labelBtn = 'Review';
                                                }
                                            ?>
                                            <?php if($row->agreement) { ?>
                                            <button class="btn btn-<?= $classBtn ?> btn-review btn-xs"
                                                    type="button" 
                                                    data-application ="<?= $row->id ?>" 
                                                    data-agreement ="<?= $row->agreement ?>" 
                                                    data-status_agreement ="<?= $row->status_agreement ?>" 
                                                    data-note_agreement ="<?= $row->note_agreement ?>" 
                                                    data-agreement_upload_date ="<?= $row->agreement_upload_date ?>" 
                                                    data-fullname ="<?= get_full_name($row) ?>" 
                                                    data-toggle="modal"
                                                    data-target="#agreementModal">
                                                <?= $labelBtn ?>
                                            </button>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $url = $page_title == 'Submitted' || $page_title == 'Testing' ? site_url('admin/submitted_det/verify/' . $row->id) : site_url('admin/in_progress_det/edit/' . $row->id); ?>
                                        <?php if($page_title != 'Testing' && $page_title != 'Participants') { ?>
                                        <a href="<?= $url ?>"
                                            class="btn btn-primary btn-xs"><?= $page_title == 'Submitted' ? 'Verify' : 'Edit' ?>
                                        </a>
                                        <?php } ?>
                                        <?php if($page_title == 'Participants') { ?>
                                            <a href="javascript:;"
                                                class="btn btn-primary btn-xs" 
                                                onclick="openScoreModal({
                                                granteeName: '<?= get_full_name($row) ?>',
                                                submittedDate: '<?= $row->submitted_date ? date('d M Y, H:i', strtotime($row->submitted_date)) : '-'?>',
                                                deadlineDate: '<?= $row->deadline_date_agreement ? date('d M Y, H:i', strtotime($row->deadline_date_agreement)) : '-'?>',
                                                completionDate: '<?= $row->test_date_complete ? date('d M Y', strtotime($row->test_date_complete)) : '-'?>',
                                                couponCode: '<?= $row->coupon ?>',
                                                testSchedule: '<?= formatDateRange($row->testing_date, $row->testing_date_end) ?>',
                                                overallScore: '<?= $row->score ?>',
                                                fileUrl: '<?= base_url($row->score_file) ?>'
                                                })"><i class="fa fa-eye fa-fw"></i> Report 
                                            </a>
                                        <?php } ?>
                                        <?php if($page_title == 'Testing') { ?>
                                            <?php if($row->status == STATUS_DET_WITHDRAWN) : ?>
                                                <button type="button" data-attach="<?= $row->attach_withdrawn ?? '' ?>" data-note="<?= $row->note_withdrawn ?>" onclick="showReason(this)" class="btn btn-primary btn-xs">View</button>
                                            <?php endif; ?>
                                            <?php if($row->status != STATUS_DET_WITHDRAWN) : ?>
                                                <a href="javascript:;"
                                                    class="btn btn-danger btn-xs btn-withdrawn"
                                                    data-application="<?= $row->id ?>"
                                                    data-fullname="<?= get_full_name($row) ?>">Withdrawn
                                                </a>
                                            <?php endif; ?>
                                            <?php if($row->score_file) : ?>
                                                <a href="javascript:;"
                                                    class="btn <?= $row->score_approve ? 'btn-success' : 'btn-info' ?> btn-xs btn-score-report"
                                                    data-score="<?= $row->score ?>"
                                                    data-testdate="<?= $row->test_date_complete ? date('Y-m-d', strtotime($row->test_date_complete)) : '-' ?>"
                                                    data-application="<?= $row->id ?>"
                                                    data-filename="<?= base_url($row->score_file) ?>"
                                                    data-basename="<?= basename($row->score_file) ?>"
                                                    data-filename="<?= $row->score_file ?>"
                                                    data-fullname="<?= get_full_name($row) ?>"><i class="fa fa-eye fa-fw"></i> Report <?= $row->score_approve ? 'Approved' : '' ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }
                        } ?>

                    </tbody>
                </table>

            </div>
            <!-- /.table-responsive -->
            <div class="pull-left">
                Showing
                <?= $paging['start_row'] ?> to
                <?= $paging['end_row'] ?> of
                <?= $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?= $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?= $sort_by ?>">
            <input type="hidden" name="sort" value="<?= $sort ?>">
        </form>

    </div>
</div>


<div class="modal fade" id="mdl_add_coupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Coupon Code & Tesing Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('admin/testing_det/add_coupon')?>">
                    <div class="row">
                        <div class="col-lg-12"> 
                            <input type="hidden" name="application_id_coupon" id="application_id_coupon">
                            
                            <div class="form-group">
                                <label>Coupon Code</label>
                                <input type="text" name="coupon" id="coupon_det" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Test Period Schedule</label>
                                <input type="text" name="testing_date" id="testing_date_det" class="form-control dateRangePicker" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="btn" value="save" class="btn btn-primary success">Save</button>
                            <button type="submit" name="btn" value="save_send" class="btn btn-success success">Save & Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="agreementModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('admin/testing_det/update_status_agreement')?>" method="POST">
                <input type="hidden" name="application_id_agreement" id="application_id_agreement">
                <div class="modal-header">
                    <button class="close"
                            data-dismiss="modal">
                        &times;
                    </button>
                    <h3>
                        <!-- <i class="fa fa-search text-success"></i> -->
                        Agreement Review
                    </h3>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="preview-box" id="agreementPreview">
                                <!-- IMAGE -->
                                <img src="">

                                <!-- Kalau PDF tinggal ganti jadi: -->
                                <iframe
                                    src=""
                                    width="100%"
                                    height="470"
                                    style="border:none;">
                                </iframe>
                            
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card">
                                <h4>Agreement Information</h4>
                                <hr>
                                <table class="table table-modal">
                                    <tr>
                                        <td><strong>Name</strong></td>
                                        <td><span id="agreementName"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Uploaded</strong></td>
                                        <td><span id="agreementUploadDate"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>
                                            <span class="label label-warning" id="agreementStatus"></span>
                                        </td>
                                    </tr>
                                </table>
                                <a href=""
                                class="btn btn-default btn-block" id="btnDownloadAgreement" target="_blank">
                                    <i class="fa fa-download"></i>
                                    Download File
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4 style="margin-bottom:20px;">
                        Decision
                    </h4>
                    <div class="decision-card">
                        <label style="width:100%;margin:0;cursor:pointer;">
                            <input type="radio"
                                name="decision"
                                value="approve">
                            <strong class="text-success">
                                Approve Agreement
                            </strong>
                        </label>
                    </div>
                    <div class="decision-card">
                        <label style="width:100%;margin:0;cursor:pointer;">
                            <input type="radio"
                                name="decision"
                                value="revise">
                            <strong class="text-danger">
                                Request Revision
                            </strong>
                        </label>
                    </div>
                    <div id="revisionBox">
                        <label>
                            Revision Note
                        </label>
                        <textarea
                            class="form-control text-modal"
                            id="revisionNote"
                            name="note_agreement"
                            rows="5"
                            placeholder="Explain what should be revised..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default"
                            data-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-success">
                        <i class="fa fa-check"></i>
                        Submit Decision
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDownloadDET" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form-download-excel">
                <input type="hidden" id="section">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Download Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <center>
                                <b>Select Fiscal Year</b><br><br>
                            </center>
                            <center>
                                <div class="radio d-inline">
                                    <select name="period" id="select_period" class="form-control selectpicker">
                                        <option value="">-- Select Fiscal Year --</option>
                                        <?php foreach ($fiscal_years as $key => $fy) { ?>
                                            <option value="<?= $fy->id ?>"><?= $fy->year ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <small class="text-danger d-none text-validation-activegrant" id="text-validation-period">Choose Period</small>
                            </center>
                            <hr>
                        </div>
                        <div class="field_row hide">
                            <div class="col-md-12">
                                <ul class="list-style-none p-0">
                                    <li>
                                        <div class="form-check">
                                            <label><input id="sel-all" type="checkbox" checked> Select All </label> 
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <b>Personal Information</b>
                                </div>
                            </div>
                            <div class="row pr-4">
                            
                            <?php foreach (array_split($all_field, 4) as $key_a_f => $a_f) : ?>
                                <div class="col-md-3">
                                    <ul class="list-style-none pl-4">
                                        <?php foreach ($a_f as $key => $value) : ?>
                                            <?php
                                                $current_key = explode('_', $key);
                                                $field_property = '';
                                                if ($current_key[0] == 'emergency') {
                                                    $field_property = 'emergency_contact_field';
                                                }
                                            ?>
                                            <li>
                                                <div class="form-check">
                                                    <table>
                                                        <tr>
                                                            <td style="vertical-align: top !important;">
                                                                <input type="checkbox" name="field_alumni[]" class="form-check-input field-alumni mr-1" id="field_alumni_check<?= $key ?>" value="<?= "$key *-* $value" ?><?php echo !empty($field_property) ? " *-* " . $field_property : ""; ?>">
                                                            </td>
                                                            <td>
                                                                <label class="form-check-label font-weight-normal d-inline" for="field_alumni_check<?= $key ?>"><?= $value ?></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    
                                                    
                                                </div>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endforeach ?>
                            </div>
                            <div class="row add_fields pr-4"></div>
                            <div class="col-md-12 d-none text-center text-validation mb-4" id="text-validation-field">
                                <small class="text-danger">Select at least one field</small>
                            </div>
                        </div>
                        <div class="col-md-12 hide">
                            <div class="radio d-inline mr-4">
                                <label><input type="radio" class="grant-alumni" name="grant_option" style="margin-top:1px" value="single_grant" checked>Single Grant</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-success">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Detail Score Report -->
<div id="scoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-card">
        <div class="modal-content">

            <div class="modal-header">Score Report Details</div>
            <input type="hidden" id="application_id">

            <div class="modal-body">
                <div class="modal-body-row">
                    <span class="modal-label">Grantee Name:</span>
                    <span id="mGranteeName">-</span>
                </div>
                <div class="modal-body-row">
                    <span class="modal-label">Overall Score:</span>
                    <span id="mScore" style="font-weight: bold; color: #1e7e34; font-size: 15px;">-</span>
                </div>
                <div class="modal-body-row">
                    <span class="modal-label">Test Completion Date:</span>
                    <span id="mTestDate">-</span>
                </div>
                <div class="modal-body-row">
                    <span class="modal-label">Score Report:</span>
                    <a href="#" id="mFileLink" target="_blank" style="color: #007bff; text-decoration: none; font-weight: 500;">
                        <i class="fa fa-file-pdf" style="color: #d9534f; margin-right: 4px;"></i> Download PDF
                    </a>
                </div>
            </div>
            
    
            <div class="modal-footer">
                <button class="btn" style="background:#e2e8f0; color:#333;" data-dismiss="modal">Close</button>
                <!-- Wording Approve -->
                <button class="btn btn-success" onclick="approveScore()">Approve</button>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================
    MODAL WITHDRAWN CONFIRMATION
    ==================================================== -->
<div id="withdrawnModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formWithdrawn" method="POST" enctype="multipart/form-data" action="<?= base_url('admin/testing_det/withdrawn_application') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reason Withdraw</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="application_id" id="withdrawnApplicationId">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Attachment</label>
                            <label for="withdrawnFile" class="withdraw-attachment-area">
                                <input type="file" id="withdrawnFile" name="attach_withdrawn" accept=".pdf, .png, .jpg, .jpeg" style="display: none;" onchange="handleWithdrawnFileSelect(event)">
                                <i class="fa fa-cloud-upload"></i>
                            </label>
                            <div class="col-md-12 text-center">
                                <div id="withdrawnFileNameDisplay" class="file-selected-name"></div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label>Reason</label>
                            <textarea class="form-control" name="note_withdrawn" id="withdrawnNote" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="confirmWithdrawn()">Save</button>
                        </div>
                    </div>
                    
                    <!-- <div class="info-card">
                        <div class="info-card-title">WITHDRAWAL DETAILS</div>
                        
                        <div class="form-group-custom">
                            <label for="withdrawnNote">Withdrawal Reason / Note *</label>
                            <textarea id="withdrawnNote" name="note_withdrawn" placeholder="Enter reason for withdrawal..."></textarea>
                        </div>
            
                        <div class="form-group-custom" style="margin-bottom: 0;">
                            <label>Supporting Document (Optional, PDF / Image)</label>
                            <label class="file-dropzone" for="withdrawnFile">
                                <i class="fa fa-cloud-upload"></i>
                                <div class="file-dropzone-text">Click or drag file here to attach document</div>
                                <div class="file-dropzone-hint">Supports PDF, PNG, JPG (Max 5 MB)</div>
                                <div id="withdrawnFileNameDisplay" class="file-selected-name"></div>
                                <input type="file" id="withdrawnFile" name="attach_withdrawn" accept=".pdf, .png, .jpg, .jpeg" style="display: none;" onchange="handleWithdrawnFileSelect(event)">
                            </label>
                        </div>
                    </div> -->
                </div> 
                <!-- <div class="modal-footer-area">
                    <button type="button" class="btn-close-modal" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-submit-withdrawn" onclick="confirmWithdrawn()">Submit Withdrawn</button>
                </div> -->
            </div>

        </form>
    </div>
</div>



<div id="scoreModalParticipant" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-box">
        <!-- Header -->
        <div class="modal-header-area">
            <div class="modal-main-title">Duolingo English Test - Score Report Detail</div>
            <div class="modal-subtitle">
                Grantee: <span id="mGranteeTitle" style="font-weight: 600; color: #334155;">-</span>
            </div>
        </div>

        <!-- Content Cards Berdampingan -->
        <div class="modal-body-area">
            <div class="modal-card-grid">
                
                <!-- KARTU KIRI: TESTING & COUPON INFO -->
                <div class="info-card">
                    <div class="info-card-title">TESTING INFORMATION</div>
                    
                    <div class="info-row">
                        <span class="info-label">Submitted Date</span>
                        <span class="info-val" id="mSubmittedDate">-</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Deadline Agreement</span>
                        <span class="info-val" id="mDeadlineDate">-</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Coupon Code</span>
                        <span class="info-val" id="mCouponCode" style="font-family: monospace; color: #0284c7;">-</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Test Period Schedule</span>
                        <span class="info-val" id="mTestSchedule">-</span>
                    </div>
                </div>

                <!-- KARTU KANAN: SCORE & REPORT -->
                <div class="info-card">
                    <div class="info-card-title">SCORE & REPORT</div>
                    
                    <div class="info-row">
                        <span class="info-label">Overall Score</span>
                        <span class="info-val" id="mScoreP" style="color: #15803d; font-size: 14px;">-</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Test Completion Date</span>
                        <span class="info-val" id="mCompletionDate">-</span>
                    </div>
                    
                    <div class="info-row" style="margin-top: 14px;">
                        <span class="info-label">Score Report</span>
                        <a href="#" class="btn-view-doc" id="mReportDocLink" target="_blank">View</a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer Tombol Aksi -->
        <div class="modal-footer-area">
        <button type="button" class="btn-close-modal" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>