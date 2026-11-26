<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$pid = $this->input->get('pid');
if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>
<style>
    .is_unlimited_label {
        font-size: 13px;
        font-weight: inherit;
        font-style: italic;
        cursor: pointer;
        user-select: none
    }

    .require{
        color: red;
    }

    #memo_revision th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #ebebeb;
    color: #7da2bd;
    }

    .select2-results__options[aria-multiselectable="true"] li {
        padding-left: 30px;
        position: relative
    }

    .select2-results__options[aria-multiselectable="true"] li:before {
        position: absolute;
        left: 8px;
        opacity: .6;
        top: 6px;
        font-family: "FontAwesome";
        content: "\f0c8";
    }

    .select2-results__options[aria-multiselectable="true"] li[aria-selected="true"]:before {
        content: "\f14a";
    }
    .select2-container .select2-selection {
        max-height: 60px;
        overflow: auto;
    } 

    .modal-title {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
    }
    
    .admin-docs-grid {
        display: flex;
        /* grid-template-columns: 1fr 1fr; */
        justify-content: center;
        gap: 24px;
    }

    .admin-doc-item {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 16px;
        background: #fafbfc;
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 50%;
    }

    .admin-doc-header {
        font-size: 14px;
        font-weight: bold;
        color: #1e293b;
        padding-bottom: 6px;
        border-bottom: 1px solid #e2e8f0;
    }

    .admin-doc-preview-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .admin-doc-meta {
        font-size: 11px;
        color: #64748b;
    }

    .badge-status-pill {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
    }

    .badge-status-pill.accepted { background-color: #dcfce7; color: #15803d; }
    .badge-status-pill.revised { background-color: #fef08a; color: #854d0e; }
    .badge-status-pill.rejected { background-color: #fee2e2; color: #b91c1c; }
    .badge-status-pill.pending { background-color: #e0f2fe; color: #0369a1; }

    .admin-note-area {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 8px;
        font-size: 12px;
        resize: vertical;
        min-height: 60px;
        font-family: inherit;
    }

    .admin-action-btn-group {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-adm {
        padding: 5px 12px;
        border: none;
        border-radius: 3px;
        font-size: 11px;
        font-weight: bold;
        color: white;
        cursor: pointer;
    }

    .btn-adm.rejected { background-color: #d9534f; }
    .btn-adm.rejected:hover { background-color: #c9302c; }
    .btn-adm.revise { background-color: #f0ad4e; }
    .btn-adm.revise:hover { background-color: #ec971f; }
    .btn-adm.accept { background-color: #5cb85c; }
    .btn-adm.accept:hover { background-color: #449d44; }
    .btn-adm.release { background-color: #a2a2a2ff; }
    .btn-adm.release:hover { background-color: #858585ff; }

    .admin-modal-footer {
        padding: 12px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-close-modal {
        background: #fff;
        border: 1px solid #cbd5e1;
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-close-modal:hover {
        background-color: #f1f5f9;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if ($this->session->flashdata('update_tnc')) { ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('update_tnc'); ?></div>
    <?php $this->session->set_flashdata('update_tnc', false); ?>
<?php } ?>
<?php $this->session->unset_userdata('update_tnc');?>
<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <?php if($data){ ?>
            <input type="hidden" class="form-control" id="eec_id" name="eec_id" value="<?= $data->id ?>">
    <?php } ?>
    <div class="row">
        <div class="alert alert-danger hide" id="error-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <span id="label-alert"></span>
        </div>
        <div class="tab-content">
            <div id="pdo" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Deadline Date</label>
                            <input type="text" readonly style="background-color:#fff" class="form-control datepicker" placeholder="Deadline Date" name="date" value="<?= $data->date ? date('d M Y', strtotime($data->date)) : '' ?>">
                        </div> 
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Period/Fiscal Year</label>   
                            <select class="form-control select_multiselect" name="fiscal_year" id="fiscal_year">
                                <option value="">-- Select Year --</option>
                                <?php
                                $current_year = date('Y', strtotime('+2 years'));
                                //$limit_year = $current_year - 20;
                                $limit_year = 1952;
                                for ($year = $current_year; $year >= $limit_year; $year--) {
                                    $selected = '';
                                    if ($data->fiscal_year == $year) {
                                        $selected = 'selected="selected"';
                                    }
                                ?>
                                    <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="text-danger invalid-tooltip validation-error-fiscal" style="display:none;">Period/Fiscal Year is Required</div> 
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Program</label>
                            <img src="<?php echo base_url() ?>/img/loading.gif" id="load-grants" style="display:none;">
                            <select class="form-control select_multiselect_score" name="grants[]" multiple='multiple' id="grants" data-live-search="true">
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>EEC Member</label>
                            <img src="<?php echo base_url() ?>/img/loading.gif" id="load-panelist_eec" style="display:none;">
                            <select class="form-control select_multiselect_score" name="panelist_eec[]" multiple='multiple' id="panelist_eec" data-live-search="true">
                                <?php foreach($panelist_eec as $eec) { 
                                    $select = in_array($eec->id, explode(",", $data->panelist_eec_id))  ? 'selected' : '';
                                ?>
                                    <option value="<?php echo $eec->id ?>" <?php echo $select ?>><?php echo $eec->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label>Template Memo to EEC</label>
                            <textarea name="template_memo" id="template_memo" class="form-control editor"><?= $data->template_memo ?? template_memo_eec() ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <p style="font-weight:bold;margin-bottom:25px;">
                        <i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> List Grantee 
                        <img src="<?php echo base_url() ?>/img/loading.gif" id="load-list" style="display:none;">
                    </p>
                    <div class="wrap-table-list">
                        <?php if($list_participant) { ?>

                            <?php foreach ($list_participant as $key => $list) { 
                                    $active_grant_id = end(explode('|', $key));
                                    $active_grant_name = explode('|', $key);
                            ?>
                                <div class="pull-left mb-2">
                                <h3><?= $active_grant_name[0] ?></h3>
                                Total Grantee : <?= count($list) ?> 
                                </div>
                                <table class="table table-striped table-hover mb-5">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" class="chk-all"></th>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Interview Date</th>
                                            <th>Score Interview</th>
                                            <th>Rank</th>
                                            <th>Final Rank</th>
                                            <th>T&C</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                        $is_check = unserialize($data->grantee_grant_id);$no=1; foreach ($list as $key => $row) { 
                                        if(!$row->final_rank_interview_update){ continue; } // skip if final rank is empty
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="chk-row" <?= isset($is_check[$active_grant_id]) ? (in_array($row->id, $is_check[$active_grant_id]) ? 'checked' : '') : '' ?> name="ids[<?= $active_grant_id ?>][]" value="<?= $row->id ?>">
                                            </td>
                                            <td><?= $no ?></td>
                                            <!-- <td><a href="<?= base_url('admin/selection/interview/form/'.$row->id) ?>" target="_blank"><?= get_full_name($row,"ID") ?></a></td> -->
                                            <td><?= get_full_name($row,"ID") ?></td>
                                            <td><?= date('F d, Y H:i', strtotime($row->date_interview)) ?></td>
                                            <td><?= $row->score_interview ?></td>
                                            <td><?= $row->rank_interview_date_update ?></td>
                                            <td><?= $row->final_rank_interview_update ?></td>
                                            <td>
                                                <?php 
                                                    $field_tnc = $row->field_tnc ? explode(',', $row->field_tnc) : [];
                                                    $view_tnc = in_array('upload_tnc', $field_tnc) ? 1 : 0;
                                                    $view_consent = in_array('upload_consent_letter', $field_tnc) ? 1 : 0;
                                                ?>
                                                <?php if($row->tnc) { ?>
                                                <a href="#" 
                                                    data-toggle="modal" 
                                                    data-target="#mdl_view_tnc" 
                                                    data-granteegrantid="<?= $row->id ?>" 
                                                    data-tnc="<?= $row->tnc ?>" 
                                                    data-tncdate="<?= $row->tnc_upload_date ?>" 
                                                    data-tncstatus="<?= $row->tnc_approver ?>" 
                                                    data-tncnote="<?= $row->note_tnc ?>"
                                                    data-imagepreview="<?= get_preview($row->tnc) ?>"
                                                    data-imagepreviewconsent="<?= get_preview($row->consent_letter) ?>"
                                                    data-filedownload="<?= get_full_name($row) ?>_<?= $active_grant_name[0] ?>_"
                                                    data-grantee="<?= get_full_name($row) ?>"
                                                    data-grant="<?= $active_grant_name[0] ?>"
                                                    data-viewtnc="<?= $view_tnc ?>"
                                                    data-viewconsent="<?= $view_consent ?>"
                                                    data-consentletter="<?= $row->consent_letter ?>" 
                                                    data-consentdate="<?= $row->consent_upload_date ?>" 
                                                    data-consentstatus="<?= $row->consent_approver ?>" 
                                                    data-consentnote="<?= $row->note_consent ?>"
                                                    onclick="view_tnc(this)"
                                                    class="btn btn-primary btn-xs" id="btn_view_tnc">View</a>
                                                <?php } ?>
                                            </td>
                                            <td><?= $row->status_name ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-gear fa-fw"></i> <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" style="top:auto">
                                                    <li>
                                                        <a href="#" data-id="<?= $row->id ?>" data-section="eec" class="reject">Reject</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-id="<?= $row->id ?>" data-section="eec" class="withdraw">Withdraw</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php $no++; } ?>
                                </table>
                                <hr>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-lg-12 mt-3 mb-5">
                    <div class="pull-right">
                        <a href="<?= base_url('admin/eec/manage') ?>" class="btn btn-default">Back</a>
                        <?php if($data) { ?>
                            <button type="submit" value="edit" name="btn" class="btn btn-success btn-s-pdo-edit">Save</button>
                            <button type="submit" value="send_email" name="btn" class="btn btn-warning btn-send-email mr-2" onclick="return confirm('Are you sure?')">Send Email EEC Result</button>
                            <!-- <button type="submit" value="send_email_tnc" name="btn" class="btn btn-info btn-send-email" onclick="return confirm('Are you sure?')">Send Email T&C</button> -->
                        <?php }else{?>
                            <button type="button" class="btn btn-success btn-s-pdo">Save</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</form>
<!-- /.row -->



<?php $this->load->view('admin/partials/modal_confirm') ?>

<div class="modal fade" id="mdl_view_tnc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">View & Review T&C / Consent Letter</h2>
                <div id="info-grantee" style="font-size: 12px; color: #64748b; margin-top: 2px;text-align:center"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="grantee_grant_id" name="grantee_grant_id">

                    <div class="admin-docs-grid">
                        
                        <!-- CARD 1: REVIEW AMINEF T&C -->
                        <div class="admin-doc-item" id="view_tnc">
                            <div class="admin-doc-header">AMINEF T&C Document</div>
                            
                            <div class="admin-doc-preview-box">
                                <a href="" class="pdf-icon-card lightbox" aria-haspopup="dialog" id="url_tnc">
                                    <img height="100" src="" style="height:90px;" id="image_preview">
                                </a>
                                <div>
                                    <a id="btn-download-tnc" href="" download title="Click to Download" style="font-size: 13px; font-weight: bold; color: #0284c7; cursor: pointer;"></a>
                                    <div class="admin-doc-meta">Uploaded: <span id="tnc_date"></span></div>
                                    <div style="margin-top: 4px;">
                                        Status: <span id="status_tnc"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Note Input for T&C -->
                            <div>
                                <label style="font-size: 11px; font-weight: bold; color: #475569;">Admin Note for T&C:</label>
                                <textarea class="admin-note-area" name="note_tnc" id="note_tnc" placeholder="Enter reason if rejecting or requesting revision..."></textarea>
                            </div>

                            <!-- Action Buttons for T&C -->
                            <div class="admin-action-btn-group">
                                <button class="btn-adm rejected" name="btn-tnc" onclick="return confirm('Are you sure?')" value="reject">Reject</button>
                                <button class="btn-adm revise" name="btn-tnc" onclick="return confirm('Are you sure?')" value="revise">Revise</button>
                                <button class="btn-adm accept" name="btn-tnc" onclick="return confirm('Are you sure?')" value="approve">Accepted</button>
                                <button class="btn-adm release" name="btn-tnc" onclick="return confirm('Are you sure?')" value="release">Release</button>
                            </div>
                        </div>

                        <!-- CARD 2: REVIEW CONSENT LETTER -->
                        <div class="admin-doc-item" id="view_consent">
                            <div class="admin-doc-header">Consent Letter Document</div>
                            
                            <div class="admin-doc-preview-box">
                                <a href="" class="pdf-icon-card lightbox" aria-haspopup="dialog" id="url_consent">
                                    <img height="100" src="" style="height:90px;" id="image_preview_consent">
                                </a>
                                <div>
                                    <a id="btn-download-consent" href="" download title="Click to Download" style="font-size: 13px; font-weight: bold; color: #0284c7; cursor: pointer;"></a>
                                    <div class="admin-doc-meta">Uploaded: <span id="consent_date"></span></div>
                                    <div style="margin-top: 4px;">
                                        Status: <span id="status_consent"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Note Input for Consent Letter -->
                            <div>
                                <label style="font-size: 11px; font-weight: bold; color: #475569;">Admin Note for Consent Letter:</label>
                                <textarea class="admin-note-area" name="note_consent" id="note_consent" placeholder="Enter reason if rejecting or requesting revision..."></textarea>
                            </div>

                            <!-- Action Buttons for Consent Letter -->
                            <div class="admin-action-btn-group">
                                <button class="btn-adm rejected" name="btn-consent" onclick="return confirm('Are you sure?')" value="reject">Reject</button>
                                <button class="btn-adm revise" name="btn-consent" onclick="return confirm('Are you sure?')" value="revise">Revise</button>
                                <button class="btn-adm accept" name="btn-consent" onclick="return confirm('Are you sure?')" value="approve">Accepted</button>
                                <button class="btn-adm release" name="btn-consent" onclick="return confirm('Are you sure?')" value="release">Release</button>
                            </div>
                        </div>

                    </div>

                    <!-- <div class="row">
                        <div class="col-lg-6" id="view_tnc">
                            <label>Upload AMINEF T&C</label>
                            <div style="margin-bottom:25px; position:relative; width:100px; margin-top: 25px;">
                                <a href="" class="lightbox" aria-haspopup="dialog" id="url_tnc">
                                    <img height="100" src="" id="image_preview">
                                </a>
                                <a id="btn-download-tnc" href="" download download="<?= get_full_name($data_required) ?>_DS160 Complete Application" title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute;top:0;">
                                    <i class="fa fa-download fa-fw text-white"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6" id="view_consent">
                            <label>Consent Letter</label>
                            <div style="margin-bottom:25px; position:relative; width:100px; margin-top: 25px;">
                                <a href="" class="lightbox" aria-haspopup="dialog" id="url_consent">
                                    <img height="100" src="" id="image_preview_consent">
                                </a>
                                <a id="btn-download-consent" href="" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute;top:0;">
                                    <i class="fa fa-download fa-fw text-white"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-5">
                            <div class="form-group">
                                <label>Status</label>
                                <p><span id="status_tnc"></span></p>
                                <p>Upload date : <span id="tnc_date"></span></p>
                            </div>
                            <div class="form-group">
                                <label>Note</label>
                                <textarea name="note_tnc" id="note_tnc" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <button class="btn btn-danger btn-sm" name="btn-tnc" value="reject">Reject</button>
                            <button class="btn btn-warning btn-sm" name="btn-tnc" value="revise">Revise</button>
                            <button class="btn btn-success btn-sm" name="btn-tnc" value="approve">Accepted</button>
                        </div>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</div>