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

    .source-info {
      font-size: 12.5px;
      color: #0c5460;
      background-color: #d1ecf1;
      border: 1px solid #bee5eb;
      padding: 10px 12px;
      border-radius: 4px;
    }
</style>
<style>
    .card { padding: 25px; }

    /* Action Bar Tabel */
    .table-header-action { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; margin-bottom: 10px; flex-wrap: wrap; gap: 8px; }
    .table-title { font-size: 14px; font-weight: bold; color: #333; }
    .btn-action-group { display: flex; gap: 8px; align-items: center; }

    /* Tabel FOS & Tree Structure */
    .table-responsive { border: 1px solid #dee2e6; border-radius: 4px; max-height: 480px; overflow-y: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; text-align: left; }
    thead th { position: sticky; top: 0; background: #eef2f7; border-bottom: 2px solid #dee2e6; padding: 10px 12px; font-weight: bold; color: #1e3a8a; z-index: 2; }
    
    /* Baris Parent */
    tr.parent-row { background-color: #edf2f7; border-top: 1px solid #cbd5e1; border-bottom: 1px solid #cbd5e1; }
    tr.parent-row td { padding: 9px 12px; font-weight: bold; color: #1e293b; }
    
    /* Baris Child (Sub FOS) */
    tr.child-row td { padding: 8px 12px; border-bottom: 1px solid #f1f5f9; }
    tr.child-row:hover { background-color: #f8fafc; }
    .tree-branch { color: #94a3b8; font-family: monospace; margin-right: 6px; font-weight: normal; }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if ($this->session->flashdata('update_fosm')) { ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('update_fosm'); ?></div>
    <?php $this->session->set_flashdata('update_fosm', false); ?>
<?php } ?>
<?php if ($this->session->flashdata('error_fosm')) { ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error_fosm'); ?></div>
    <?php $this->session->set_flashdata('error_fosm', false); ?>
<?php } ?>
<?php $this->session->unset_userdata('update_fosm');?>
<?php $this->session->unset_userdata('error_fosm');?>

<form id="form" role="form" method="POST" action="<?= base_url('admin/study_field_mapping/save') ?>">
    <input type="hidden" name="fos_ids_json" id="fos_ids_json">
    <?php if(isset($data) && $data){ ?>
        <input type="hidden" class="form-control" id="study_field_mapping_id" name="study_field_mapping_id" value="<?= $data->id ?>">
        <input type="hidden" id="period_id" name="period_id" value="<?= isset($data->period_id) ? $data->period_id : $data->id ?>">
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
                            <label>Period/Fiscal Year <span class="require">*</span></label>   
                            <select class="form-control select_multiselect" name="fiscal_year" id="fiscal_year" required>
                                <option value="">-- Select Year --</option>
                                <?php
                                $current_year = date('Y', strtotime('+2 years'));
                                $limit_year = 1952;
                                for ($year = $current_year; $year >= $limit_year; $year--) {
                                    $selected = '';
                                    if (isset($data) && $data && $data->fiscal_year == $year) {
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
                            <label>Grants <span class="require">*</span></label>
                            <img src="<?php echo base_url() ?>/img/loading.gif" id="load-grants" style="display:none;">
                            <select class="form-control select_multiselect_score" name="grants[]" multiple='multiple' id="grants" data-live-search="true" required>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-5">
                        <!-- Action Bar Tabel FOS -->
                        <div class="table-header-action">
                            <div class="table-title">List Field of Study (Master: <a href="<?= base_url('admin/study_field/manage') ?>" target="_blank">New Study Field</a>)</div>
                            <div class="btn-action-group">
                                <input type="text" id="searchFos" class="form-control input-sm" style="width: 220px;" placeholder="Search Field of Study...">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#mdlCopySof" id="btnCopy">Copy from Existing Mapping</button>
                                <button type="button" class="btn btn-default btn-sm" id="btnCheckAll">Check All</button>
                                <button type="button" class="btn btn-default btn-sm" id="btnUncheckAll">Uncheck All</button>
                            </div>
                        </div>

                        <!-- Tabel FOS Terstruktur -->
                        <div class="table-responsive">
                            <table>
                            <thead>
                                <tr>
                                <th style="width: 45px; text-align: center;">
                                    <input type="checkbox" id="headerToggle">
                                </th>
                                <th>Field of Study</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Dynamic Data Rendered via JS -->
                            </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3 mb-5" style="margin-top: 15px; margin-bottom: 30px;">
                        <a href="<?= base_url('admin/study_field_mapping/manage') ?>" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-success btn-submit">Save Mapping</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</form>
<!-- /.row -->



<div class="modal fade" id="mdlCopySof" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Copy FOS Configuration</h2>
                <div id="info-grantee" style="font-size: 12px; color: #64748b; margin-top: 2px;text-align:center"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-3">
                    <div class="form-group col-sm-12">
                        <label>Period/Fiscal Year</label>
                        <select name="copy_period_id" class="form-control" id="copy_period_id">
                            <option value="">--Select Period--</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Source Program / Grant</label>
                        <select name="copy_grant_id" class="form-control" id="copy_grant_id">
                            <option value="">--Select Grant--</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <div class="source-info" id="sourceInfoBox" style="display: none;">
                            Found <strong><span id="sourceFosCount">0</span> active FOS items</strong> in this source mapping (<span id="sourceGrantName">-</span> - <span id="sourcePeriodName">-</span>).
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label style="margin-bottom: 8px;">Copy Strategy</label>
                        <div style="display: flex; flex-direction: column; gap: 6px; font-size: 13px;">
                            <label style="font-weight: normal; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="copyStrategy" value="replace" checked>
                            <strong>Replace</strong> (Clear current selections and apply exactly from source)
                            </label>
                            <label style="font-weight: normal; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="copyStrategy" value="merge">
                            <strong>Merge</strong> (Keep current selections and add active FOS items from source)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnApplyCopy">Apply Mapping</button>
            </div>
        </div>
    </div>
</div>