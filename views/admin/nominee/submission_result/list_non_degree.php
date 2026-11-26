<style>
    .TriSea-technologies-Switch > input[type="checkbox"] {
        display: none;   
    }

    .TriSea-technologies-Switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .TriSea-technologies-Switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .TriSea-technologies-Switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }
</style>

<?php if(!$is_alumni_page) { ?>
<div class="row">
    <div class="col-lg-12">
        <h1><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header">
            <?=$grantee_grant->grant_name ?> - <?= $grantee_grant->fiscal_year_period ?>
        </h3>
    </div>
</div>
<?php } ?>

<?php if ($this->session->flashdata('success')) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?= $this->session->flashdata('success') ?>
</div>
<?php } ?>
<?php if ($this->session->flashdata('error')) { ?>
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?= $this->session->flashdata('error') ?>
</div>
<?php } ?>

<?php $this->session->set_flashdata('success', false); ?>
<?php $this->session->set_flashdata('error', false); ?>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <?php if(!$is_alumni_page) { ?>
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>

                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit']) $selected = 'selected';
                        ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="search" value="<?php echo $paging['search'] ?>" placeholder="">
                    <button type="button" class="btn btn-success btn-sm btn-add-non-degree">
                        <i class="fa fa-plus"></i> Add New
                    </button>
                </div>
            </div>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <?php if(!$is_alumni_page) { ?>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <?php } ?>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('university_name', $sort_by, $sort) ?>>University</th>
                            <th>Letter of Invitation</th>
                            <th>Institutional Report Form</th>
                            <th>Status</th>
                            <th>Enable Upload LOI</th>
                            <th width="200" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = 1 + $paging['start_row'] - 1;
                            foreach ($data as $row) { 
                        ?>
                            <tr>
                                <?php if(!$is_alumni_page) { ?>
                                <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
                                <?php } ?>
                                <td class="text-center"><?php echo $no++ ?></td>
                                <td><?php echo $row->university_name ? $row->university_name : '-' ?></td>
                                <td>
                                    <?php if ($row->loi_file) { ?>
                                        <a href="<?= base_url($row->loi_file) ?>" target="_blank" class="file-pill lightbox"><i class="fa fa-file-text-o"></i> <span class="text-ellipsis"><?= basename($row->loi_file) ?></span></a>
                                        <a href="<?= base_url($row->loi_file) ?>" download title="Download LOI" class="btn btn-primary btn-xs"><i class="fa fa-download"></i></a>
                                        <?php if(!$is_alumni_page) { ?>
                                        <button type="button" class="btn btn-danger btn-xs btn-delete-nd-file" data-id="<?= $row->id ?>" data-field="loi_file" title="Delete LOI File"><i class="fa fa-trash"></i></button>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <span class="text-muted">-</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($row->irf_file) { ?>
                                        <a href="<?= base_url($row->irf_file) ?>" target="_blank" class="file-pill lightbox"><i class="fa fa-file-text-o"></i> <span class="text-ellipsis"><?= basename($row->irf_file) ?></span></a>
                                        <a href="<?= base_url($row->irf_file) ?>" download title="Download IRF" class="btn btn-primary btn-xs"><i class="fa fa-download"></i></a>
                                        <?php if(!$is_alumni_page) { ?>
                                        <button type="button" class="btn btn-danger btn-xs btn-delete-nd-file" data-id="<?= $row->id ?>" data-field="irf_file" title="Delete IRF File"><i class="fa fa-trash"></i></button>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <span class="text-muted">-</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php 
                                        if ($row->status == 'Approved' || $row->status == 'Admitted') {
                                            echo "<span class='badge badge-success'>Approved by Grantee</span>";
                                        } else if ($row->status == 'Rejected') {
                                            echo "<span class='badge badge-danger'>Rejected by Grantee</span>";
                                        } else {
                                            echo "<span class='badge badge-warning'>Pending Review Grantee</span>";
                                        }
                                    ?>
                                    <?php if ($row->status == 'Rejected' && !empty($row->reject_note)) { ?>
                                        <div style="margin-top: 5px;">
                                            <small class="text-danger"><b>Note:</b> <?= nl2br(htmlspecialchars($row->reject_note)) ?></small>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="TriSea-technologies-Switch">
                                        <span class="mr-2"></span>
                                        <input data-id="<?= $row->id ?>" onchange="enable_toggle_upload_loi(this)" id="enable_upload_loi<?= $row->id ?>" name="enable_upload_loi" type="checkbox" <?= $row->enable_upload_loi  ? 'checked' : '' ?>/>
                                        <label for="enable_upload_loi<?= $row->id ?>" class="label-primary"></label>
                                    </div>
                                </td>
                                <?php if(!$is_alumni_page) { ?>
                                <td class="text-center" style="position:relative;">
                                    <button type="button" class="btn btn-primary btn-xs btn-edit-non-degree" data-id="<?= $row->id ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <a href="<?php echo site_url('admin/nominee/submission_result/delete_non_degree/'.$grantee_grant_id.'/'.$row->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-times-circle"></i> Delete
                                    </a>
                                    <input data-type="record" data-log="<?= $row->id ?>" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default payment-log" value="Open Log">
                                </td>
                                <?php } ?>
                            </tr>
                        <?php }
                        } else { ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No data found.</td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
                
            </div>
            <?php if(!$is_alumni_page) { ?>
            <!-- /.table-responsive -->
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
            <?php } ?>
        </form>

    </div>
    <div class="col-lg-12">
        <div class="pull-right">
            <a href="<?= $back_url ?>" class="btn btn-primary">Back</a>
            <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-warning withdraw">Withdraw</a>
            <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-danger drop">Drop</a>
            <input type="hidden" id="data_section" value="planning">
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/modal_log') ?>

<!-- Modal Add/Edit Non-Degree Submission Result -->
<div class="modal fade" id="modalNonDegree" tabindex="-1" role="dialog" aria-labelledby="modalNonDegreeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalNonDegreeLabel">Add Submission Result</h4>
            </div>
            <form id="submissionFormNonDegree" enctype="multipart/form-data">
                <input type="hidden" name="id" id="non_degree_id" value="">
                <input type="hidden" name="grantee_grant_id" value="<?= $grantee_grant_id ?>">
                
                <div class="modal-body">
                    <div id="modalAlertNonDegree" class="alert alert-danger hide"></div>
                    
                    <div class="form-group">
                        <label>University <span class="text-danger">*</span></label>
                        <select name="university_id" id="university_id_non_degree" class="form-control select2" style="width:100%" required>
                            <option value="">-- Select University --</option>
                            <?php if (!empty($universities)) { ?>
                                <?php foreach ($universities as $univ) { ?>
                                    <option value="<?= $univ->id ?>"><?= $univ->name ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Letter of Invitation</label>
                        <input type="file" name="loi_file" id="loiFile" class="form-control" accept=".pdf,.doc,.docx">
                        <span class="help-block" style="font-size:12px;">File size max 5MB (.pdf, .doc, .docx)</span>
                        <div style="display:flex;gap:10px;">
                            <div id="currentLoiFile" style="margin-top:5px;"></div>
                            <button type="button" class="btn btn-danger btn-xs btn-delete-nd-file-modal hide" id="btnDeleteLoiModal" data-field="loi_file" style="margin-top:4px;"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            Institutional Report Form 
                            <!-- <span id="irfRequiredStar" class="text-danger">*</span> -->
                        </label>
                        <input type="file" name="irf_file" id="irfFile" class="form-control" accept=".pdf,.doc,.docx">
                        <span class="help-block" style="font-size:12px;">File size max 5MB (.pdf, .doc, .docx)</span>
                        <div style="display:flex;gap:10px;">
                            <div id="currentIrfFile" style="margin-top:5px;"></div>
                            <button type="button" class="btn btn-danger btn-xs btn-delete-nd-file-modal hide" id="btnDeleteIrfModal" data-field="irf_file" style="margin-top:4px;"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="status_non_degree" class="form-control select2" style="width:100%">
                            <option value="Pending">Pending Review Grantee</option>
                            <option value="Approved">Approved by Grantee</option>
                            <option value="Rejected">Rejected by Grantee</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-modal-save" id="btnSubmitNonDegree">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>