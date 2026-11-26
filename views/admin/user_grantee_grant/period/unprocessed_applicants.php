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

    .progress-info {
        margin-bottom: 15px;
    }

    .progress-info p {
        margin: 5px 0;
    }

    .progress {
        height: 25px;
        margin-bottom: 15px;
    }

    .progress-bar {
        font-size: 14px;
        line-height: 25px;
        min-width: 2em;
    }

    .status-info {
        text-align: center;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
    }

    #deleteProgressModal .modal-dialog {
        max-width: 500px;
    }

    #deleteProgressModal .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #deleteProgressModal .modal-header {
        background-color: #dc3545;
        color: white;
        border-radius: 8px 8px 0 0;
    }

    #deleteProgressModal .modal-header .modal-title {
        color: white;
    }

    #deleteProgressModal .progress-bar-animated {
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-size: 1rem 1rem;
        animation: progress-bar-stripes 1s linear infinite;
    }

    @keyframes progress-bar-stripes {
        0% {
            background-position-x: 1rem;
        }
    }

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
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Unprocessed Applicants - <?php echo $grant_name; ?> (<?php echo $fiscal_year; ?>)
            <a href="<?php echo site_url('/admin/user_grantee_grant/delete_all_files/' . $period_id); ?>"
                id="btn_delete_all" data-period-id="<?php echo $period_id; ?>"
                class="btn btn-danger btn-sm pull-right ml-2">
                <i class="fa fa-trash"></i> DELETE DOCUMENTS
            </a>
        </h1>
        <?php if (isset($total_files) || isset($total_size)) { ?>
            <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
                <div class="col-md-6">
                    <div style="background: #337ab7; border-radius: 4px; padding: 20px; box-shadow: 0 2px 8px rgba(51, 122, 183, 0.4); transition: all 0.3s ease; color: white;"
                        onmouseover="this.style.boxShadow='0 4px 12px rgba(51, 122, 183, 0.5)'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.boxShadow='0 2px 8px rgba(51, 122, 183, 0.4)'; this.style.transform='translateY(0)'">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div
                                    style="font-size: 12px; color: rgba(255,255,255,0.9); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500;">
                                    Total Files</div>
                                <div style="font-size: 28px; font-weight: 700; color: #ffffff; line-height: 1.2;">
                                    <?php echo isset($total_files) ? number_format($total_files) : 0; ?>
                                </div>
                            </div>
                            <div style="font-size: 40px; color: rgba(255,255,255,0.3);">
                                <i class="fa fa-file-text-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="background: #337ab7; border-radius: 4px; padding: 20px; box-shadow: 0 2px 8px rgba(51, 122, 183, 0.4); transition: all 0.3s ease; color: white;"
                        onmouseover="this.style.boxShadow='0 4px 12px rgba(51, 122, 183, 0.5)'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.boxShadow='0 2px 8px rgba(51, 122, 183, 0.4)'; this.style.transform='translateY(0)'">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div
                                    style="font-size: 12px; color: rgba(255,255,255,0.9); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500;">
                                    Total Size</div>
                                <div style="font-size: 28px; font-weight: 700; color: #ffffff; line-height: 1.2;">
                                    <?php echo isset($total_size) ? $total_size : '0 B'; ?>
                                </div>
                            </div>
                            <div style="font-size: 40px; color: rgba(255,255,255,0.3);">
                                <i class="fa fa-hdd-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit'])
                                $selected = 'selected';
                            ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <div class="pull-right">
                    <div class="form-group">
                        Status
                        <select class="form-control" name="status_section"
                            onchange="document.forms.frm_manage.submit()">
                            <option value="">All</option>
                            <?php
                            $search_by = $_GET['status_section'];
                            foreach ($filter_status as $field => $val) {
                                $selected = '';
                                if (isset($search_by) && $search_by == $field) {
                                    $selected = 'selected="selected"';
                                }
                                ?>
                                <option value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        Search By
                        <select class="form-control" name="search_by[]">
                            <?php
                            $search_by = $_GET['search_by'][0];
                            foreach ($filters as $field => $val) {
                                $selected = '';
                                if (isset($search_by) && $search_by == $field) {
                                    $selected = 'selected="selected"';
                                }
                                ?>
                                <option value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Keyword : <input type="search" class="form-control input-sm" name="q[]"
                        value="<?php echo isset($q[0]) ? $q[0] : '' ?>" placeholder=""
                        onkeypress="return submitFilter(event)">
                    <a href="javascript:;" onclick="add_filter()" class="btn btn-success btn-sm"><i
                            class="fa fa-plus fa-fw"></i></a>
                </div>
                <?php
                $total_filter = isset($_GET['search_by']) ? count($_GET['search_by']) : 0;
                if ($total_filter > 1) {
                    for ($i = 1; $i < $total_filter; $i++) {
                        ?>
                        <div class="pull-right" style="margin-top:5px; clear:both;">
                            <div class="form-group">
                                <select class="form-control" name="cnj[]">
                                    <option value="AND" <?= $_GET['cnj'][$i - 1] == 'AND' ? 'selected' : null ?>>AND</option>
                                    <option value="OR" <?= $_GET['cnj'][$i - 1] == 'OR' ? 'selected' : null ?>>OR</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="search_by[]">
                                    <?php
                                    $search_by = $_GET['search_by'][$i];
                                    foreach ($filters as $field => $val) {
                                        $selected = '';
                                        if (isset($search_by) && $search_by == $field) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?php echo $q[$i] ?>"
                                placeholder="" onkeypress="return submitFilter(event)">
                            <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i
                                    class="fa fa-minus fa-fw"></i></a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <!-- <th width="30"><input type="checkbox" class="chk-all"></th> -->
                            <th width="35" class="text-center">#</th>
                            <th>Name</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                            <th width="200">Note</th>
                            <th>
                                <?php
                                $current_sort_by = isset($sort_by) ? $sort_by : '';
                                $current_sort = isset($sort) ? $sort : 'desc';
                                $new_sort = ($current_sort_by == 'total_size' && $current_sort == 'desc') ? 'asc' : 'desc';

                                $sort_url = current_url() . '?' . http_build_query(array_merge($_GET, ['sort_by' => 'total_size', 'sort' => $new_sort, 'page' => 1]));
                                $sort_class = '';
                                if ($current_sort_by == 'total_size') {
                                    $sort_class = $current_sort == 'asc' ? 'sorting_asc' : 'sorting_desc';
                                } else {
                                    $sort_class = 'sorting';
                                }
                                ?>
                                <a href="<?php echo $sort_url; ?>" class="<?php echo $sort_class; ?>"
                                    style="text-decoration: none; color: inherit;">
                                    Usage Info
                                    <?php if ($current_sort_by == 'total_size') { ?>
                                        <i class="fa fa-sort-<?php echo $current_sort == 'asc' ? 'up' : 'down'; ?>"></i>
                                    <?php } else { ?>
                                        <i class="fa fa-sort"></i>
                                    <?php } ?>
                                </a>
                            </th>
                            <th width="200" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {

                                $format = 'ID';
                                if ($country_id == '2') {
                                    $format = 'US';
                                }
                                $fullname = $this->Grantee_ent_model->get_full_name($row, $format);
                                ?>
                                <tr style="<?= $row->blacklist ? 'background-color:#f59494' : '' ?>">
                                    <!-- <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php // echo $row->staff_id ?>"></td> -->
                                    <td><?php echo $no++ ?></td>
                                    <td><a target="_BLANK"
                                            href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id); ?>"
                                            class="<?= $row->blacklist ? 'text-danger font-weight-bold' : '' ?>"><?php echo $fullname ?></a>
                                    </td>
                                    <td><?php echo $row->submission_date ? format_date_time($row->submission_date) : ''; ?></td>
                                    <td><?php echo $row->status_name; ?></td>
                                    <td>
                                        <a target="_BLANK" class="text-danger"
                                            href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id); ?>">
                                            <?php
                                            if ($row->other_account) {
                                                if ($row->other_account->status == STATUS_SELECTION_DECLINED) {
                                                    echo strlen($row->other_account->note_selection) > 50 ? substr($row->other_account->note_selection, 0, 50) . '....' : $row->other_account->note_selection;
                                                } else if ($row->other_account->status == STATUS_CANDIDATE_DECLINED) {
                                                    echo strlen($row->other_account->note_candidate) > 50 ? substr($row->other_account->note_candidate, 0, 50) . '....' : $row->other_account->note_candidate;
                                                } else if ($row->other_account->status == STATUS_ON_GOING_DECLINED) {
                                                    echo strlen($row->other_account->note_ongoing) > 50 ? substr($row->other_account->note_ongoing, 0, 50) . '....' : $row->other_account->note_ongoing;
                                                }
                                            }
                                            ?>
                                        </a>
                                    </td>
                                    <td><?php echo $row->submission_files['total_files']; ?> file uploaded
                                        (<?php echo $row->submission_files['total_size']; ?>)</td>
                                    <td class="text-center" style="position:relative;">
                                        <a class="btn btn-primary btn-xs"
                                            href="<?php echo site_url('admin/user_grantee_grant/download_files/') . $row->user_grantee_id . '/' . $row->grant_id . '/' . $row->grantee_grant_id . '/' . $row->period_id ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-danger btn-xs btn-delete-files"
                                            data-url="<?php echo site_url('admin/user_grantee_grant/delete_files/') . $row->user_grantee_id . '/' . $row->grant_id . '/' . $row->grantee_grant_id . '/' . $row->period_id ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php }
                        } ?>

                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of
                <?php echo $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>

    </div>
</div>
<?php $this->load->view('admin/partials/modal_confirm') ?>
<?php $this->load->view('admin/partials/form_filter') ?>
<!-- Modal Download -->
<?php $this->load->view('admin/partials/modal_download_excel') ?>

<!-- Progress Modal for File Deletion -->
<div class="modal fade" id="deleteProgressModal" tabindex="-1" role="dialog" aria-labelledby="deleteProgressModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteProgressModalLabel">
                    <i class="fa fa-trash"></i> Deleting Files
                </h4>
            </div>
            <div class="modal-body">
                <div class="progress-info">
                    <p><strong>Processing:</strong> <span id="currentUser">-</span></p>
                    <p><strong>Progress:</strong> <span id="progressText">0</span> / <span id="totalUsers">0</span>
                        users</p>
                </div>
                <div class="progress">
                    <div id="deleteProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        0%
                    </div>
                </div>
                <div class="status-info mt-3">
                    <small class="text-muted">Please wait while we delete files from each user. This may take several
                        minutes...</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCancelDelete" class="btn btn-warning">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" id="btnCloseModal" class="btn btn-secondary" style="display: none;">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>