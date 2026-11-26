<?php

$active_country = $this->session->userdata('active_country');
$number_alfa = range('a', 'z');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
    .select2 {
        width:100% !important;
    }

    .agreement-page{
        margin-top:30px;
        margin-bottom:40px;
    }

    .agreement-status{
        border:none;
        border-radius:15px;
        background:#eefaf0;
        box-shadow:0 5px 20px rgba(0,0,0,.05);
    }

    .status-icon{
        width:50px;
        height:50px;
        border-radius:50%;
        background: #28a745;
        color:#fff;
        text-align:center;
        line-height:50px;
        font-size:30px;
    }

    .status-icon-warning{
        width:50px;
        height:50px;
        border-radius:50%;
        background: #f1c867ff;
        color:#fff;
        text-align:center;
        line-height:50px;
        font-size:30px;
    }

    .agreement-status h3{
        margin-top:5px;
        color:#28a745;
        font-weight:bold;
    }

    .agreement-card{
        border:0;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    }

    .agreement-card .panel-body{
        padding:35px;
    }

    .agreement-card h3{
        margin-top:0;
        font-weight:600;
    }

    .file-card{

        border:1px solid #eee;
        border-radius:15px;

        padding:15px;

        text-align:center;

        transition:.3s;
    }

    /* .file-card:hover{

        transform:translateY(-4px);

        box-shadow:0 8px 20px rgba(0,0,0,.1);
    } */

    .file-card img{

        border-radius:10px;

        margin:auto;

        max-height:180px;
    }

    /* .btn-success{

        border-radius:8px;

        padding:12px 24px;

        font-weight:600;
    } */

    @media(max-width:768px){

        .agreement-card .panel-body{
            padding:20px;
        }

        .status-icon{
            width:55px;
            height:55px;
            line-height:55px;
            font-size:22px;
        }

        .page-header h1{
            font-size:28px;
        }

        .btn-lg{
            width:100%;
        }

        .file-card{
            margin-bottom:20px;
        }

    }
    .upload-box{

    border:2px dashed #b8d8c5;

    border-radius:15px;

    background:#fafdfb;

    text-align:center;

    padding:40px 20px;

    transition:.3s;

    margin-top:20px;
}

.upload-box:hover{

    border-color:#28a745;

    background:#f2fcf5;
}

.upload-icon{

    font-size:60px;

    color:#28a745;

    margin-bottom:15px;
}

.btn-file{

    position:relative;

    overflow:hidden;

    border-radius:8px;
}

.btn-file input[type=file]{

    position:absolute;

    left:0;

    top:0;

    opacity:0;

    width:100%;

    height:100%;

    cursor:pointer;
}

.selected-file{

    margin-top:20px;

    background:#fff;

    border:1px solid #ddd;

    border-radius:10px;

    padding:12px 15px;

    text-align:left;

    box-shadow:0 2px 8px rgba(0,0,0,.05);
}

.selected-file .file-name{

    font-weight:600;

    margin-left:8px;
}

/* Container Card */
.card {
    background-color: #ffffff;
    border: 1px solid #dcdfe6;
    border-radius: 6px;
    max-width: 1100px;
    margin: 0 auto;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

/* Header Bar */
.card-header {
    background-color: #f1f4f8;
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e2e8f0;
}

.header-title {
    font-size: 15px;
    font-weight: 600;
    color: #2d3748;
}

.header-actions {
    display: flex;
    gap: 6px;
}

.btn {
    padding: 5px 14px;
    font-size: 12px;
    font-weight: bold;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: #fff;
}

.btn-approve {
    background-color: #4CAF50;
}
.btn-approve:hover {
    background-color: #43a047;
    color: #fff;
}

.btn-reject {
    background-color: #d9534f;
}
.btn-reject:hover {
    background-color: #c9302c;
    color: #fff;
}

.btn-cancel {
    background-color: #e2e8f0;
    color: #333;
}
.btn-cancel:hover {
    background-color: #cbd5e1;
}

/* Card Body */
.card-body {
    padding: 24px;
    transition: opacity 0.2s ease;
}

/* Initial Disabled State */
.is-disabled {
    opacity: 0.55;
    pointer-events: none;
    user-select: none;
}

/* Rejection Reason Banner */
.reject-note-box {
    /* display: none; */
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 10px 14px;
    border-radius: 4px;
    font-size: 13px;
    margin-bottom: 16px;
}

</style>

<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Duolingo English Test - Agreement</h2>
    </div>
</div>

<div class="agreement-page">

    <!-- Status -->
     <!-- <div class="row">
        <div class="col-lg-12"> -->
            <?php //if($application->status_agreement == 'revise') { ?>
            <!-- <div class="alert alert-warning">
                <div class="media-left">
                    <div class="status-icon-warning">
                        <i class="fa fa-exclamation"></i>
                    </div>
                </div>
        
                <div class="media-body">
                    <h4>Need to be revised with note: </h4>
                    <p><?php // $application->note_agreement ?></p>
                </div>
            </div> -->
            <?php //} ?>
        
            <?php //if($application->status_agreement == 'approve') { ?>
            <!-- <div class="alert alert-success">
                <div class="media-left">
                    <div class="status-icon">
                        <i class="fa fa-check"></i>
                    </div>
                </div>
        
                <div class="media-body">
                    <small>Status Agreement</small>
                    <h4>Accepted</h4>
                </div>
            </div> -->
            <?php //} ?>
        <!-- </div>
     </div> -->
    

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success alert-dismissable text-justify">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('success') ?>
                        </div>
                    <?php } ?>
                    <?php $this->session->unset_userdata('success');?>
                    <?php if(!in_array($application->approve_agreement, ['Approve', 'Rejected'])) { ?>
                    <div class="card-header">
                        <div class="header-title">Duolingo English Test - Agreement Requirement</div>
                        <div class="header-actions">
                        <button type="button" class="btn btn-approve" onclick="update_status_agreement(this, <?= $application->id ?>, 'Approve')">Approve</button>
                        <button type="button" class="btn btn-reject" onclick="update_status_agreement(this, <?= $application->id ?>, 'Reject')">Reject</button>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- Rejection Reason Banner -->
                    <div id="rejectNoteBanner" class="reject-note-box <?= $application->approve_agreement == 'Rejected' ? '' : 'd-none' ?>" style="margin: 20px 24px 0 24px;">
                        <strong>Rejection Reason:</strong> <span id="rejectNoteText"><?= $application->note_withdrawn?></span>
                    </div>

                    <!-- Table Section (Disabled initially) -->
                    <div id="contentSection" class="card-body <?= $application->approve_agreement == 'Rejected' || $application->approve_agreement == '' ? 'is-disabled' : '' ?>">
                        <div class="form-group p-3">
                            <label>
                                As the Duolingo English Test agreement is part of the official program requirement, please read all terms carefully.
                                Download, sign, and submit the completed Agreement Form in a single .pdf file and do not separate each page into different files (the maximum file size is 5 Mb).
                            </label>
                            <table class="table table-striped table-bordered table-responsive mt-4">
                                <thead>
                                    <tr>
                                        <th>Template File</th>
                                        <th>Extension</th>
                                        <th>Deadline Date</th>
                                        <th>File Upload</th>
                                        <th>Status</th>
                                        <th>Upload Date</th>
                                        <?php if(!$is_alumni_page) { ?>
                                        <th>Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody id="list">
                                    <tr>
                                        <td>
                                            <a href="<?= base_url($application->agreement_template) ?>" class="lightbox <?= $application->agreement_template ? '' : 'hide' ?>" style="color:#337ab7">
                                                Download Template Aggreement
                                            </a>
                                        </td>
                                        <?php 
                                            $detail_file = $application->agreement_template ? explode('.', $application->agreement_template) : '';
                                        ?>
                                        <td><?= $detail_file ? end($detail_file) : '' ?></td>
                                        <td class="text-danger"><?= $application->deadline_date_agreement ? date('Y-m-d H:i', strtotime($application->deadline_date_agreement)) : '' ?></td>
                                        <td>
                                            <?php if($application->agreement) { ?>
                                            <a href="<?= base_url($application->agreement) ?>" class="lightbox" style="color:#337ab7"><?= basename($application->agreement) ?></a>
                                            <a href="<?= base_url($application->agreement) ?>" class="btn btn-info btn-xs" style="color:#fff"><i class="fa fa-download fa-fw text-white"></i></a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?= $application->status_agreement ? ucfirst($application->status_agreement) : '' ?>
                                            <?php if($application->status_agreement == 'revise') { ?>
                                                <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" style="cursor:pointer;" data-target="#modal_note" data-placement="top" data-note="<?= $application->note_agreement ?>">i</span>
                                            <?php } ?>
                                        </td>
                                        <td><?= $application->agreement_upload_date ?></td>
                                        <?php if(!$is_alumni_page) { ?>
                                        <td>
                                            <?php if(!in_array($application->status_agreement, ['approve', 'submitted'])) { ?>
                                                <input type="file" class="form-control hide" name="tnc" id="tnc" accept=".pdf, .png, .jpg, .jpeg">
                                                <a class="btn btn-primary btn-xs upload_departure_item" data-id="<?= $application->id ?>" style="color:#fff" data-file-value="tnc">Upload</a>
                                            <?php } ?>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default hide">
                <form id="form" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if($application->agreement_template != '') { ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-justify"><?= $application->agreement_template_wording ?></div>
                                        </div>
                                    </div> 
                                    <div class="row mt-5">
                                        <div class="col-lg-6">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Upload Agreement</label>
                                                    <br />
                                                    <a download href="<?= base_url($application->agreement_template) ?>" class="btn btn-success" style="margin-bottom: 10px;" target="_blank"<?= $is_preview ? 'disabled="disabled"' : '' ?>>Download Agreement</a>
                                                    <?php if(!in_array($application->status_agreement, ['approve', 'submitted'])) { ?>
                                                    <input type="file" class="form-control" name="tnc" id="tnc">
                                                    <small class="file-for-testing">File Size Max 5MB</small>
                                                    <?php } ?>
                                                    <?php if($application->agreement != '') { ?>
                                                    <div style="margin-bottom:25px; position:relative; width:100px; margin-top: 25px;">
                                                        <a href="<?php echo base_url() ?><?php echo $application->agreement ?>" class="lightbox" aria-haspopup="dialog">
                                                            <img height="100" src="<?php echo get_preview($application->agreement); ?>">
                                                        </a>
                                                        <a href="<?= base_url($application->agreement) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute;top:0;">
                                                            <i class="fa fa-download fa-fw text-white"></i>
                                                        </a>
                                                        <?php if(!in_array($application->status_agreement, ['approve', 'submitted'])) { ?>
                                                        <a href="<?= base_url('det/application/delete_tnc/'.$application->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')" style="position:absolute;top:25px;">
                                                            <i class="fa fa-trash fa-fw text-white"></i>
                                                        </a>
                                                        <?php } ?>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php if($application->status_agreement == '' || $application->status_agreement == 'revise') { ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-success pull-right">Save</button>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_note" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <textarea class="form-control note-note" disabled rows="6" style="resize: none;"></textarea>
            </div>
            <div class="mt-2 text-center">
                <a target="_blank" class="btn btn-primary" id="attach_revise">Attachment</a>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mdl_note_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Note</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="section_reason_rejection">
                    <div class="col-lg-12">
                        <div class="form-group">
				                    <label>Note</label>
                            <textarea class="form-control" name="note_reject_argeement" id="note_reject_argeement" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-save-note-reject" name="btn-submit" value="decline" class="btn btn-primary success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
            </div>
        </div>
    </div>
</div>