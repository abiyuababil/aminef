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
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">In Progress
            <a href="javascript:;" onclick="show_download_modal('<?= http_build_query($_GET) ?>')"
                class="btn btn-primary btn-sm pull-right" title="Export Data In Progress dalam format file excel">
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
            <div class="row mb-4 program-filter-section">
                <div class="form-group select-program">
                    <label>Program</label>
                    <select class="form-control select2" id="filter-program" name="program_ids[]" multiple>
                        <?php
                        $program_ids = isset($_GET['program_ids']) ? (array) $_GET['program_ids'] : [];
                        ?>
                        <?php foreach ($program_available as $program) { ?>
                            <option value="<?php echo $program->id; ?>" <?= (!empty($program_ids) && is_array($program_ids) && in_array($program->id, $program_ids)) ? 'selected' : '' ?>><?php echo $program->name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Period</label>
                    <select class="form-control select2" name="period[]" onchange="document.forms.frm_manage.submit()"
                        multiple>
                        <option value="">&nbsp;</option>
                        <?php $_period = isset($_GET['period']) ? $_GET['period'] : ''; ?>
                        <?php foreach ($available_period as $period) { ?>
                            <?php if (empty($period->fiscal_year) || $period->fiscal_year <= 0)
                                continue; ?>
                            <option value="<?php echo $period->fiscal_year; ?>" <?php echo (!empty($_period) && is_array($_period) && in_array($period->fiscal_year, $_period)) ? 'selected' : ''; ?>>
                                <?php echo $period->fiscal_year; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
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
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>>
                                <?php echo $lo ?>
                            </option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <div class="pull-right">
                    <!-- <div class="form-group">
                        Grants :
                        <select class="form-control select2 select2-filter" name="grant" onchange="document.forms.frm_manage.submit()" style="width:250px">
                            <option value="">All</option>
                            <?php
                            foreach ($program_available as $pa) {
                                $selected = '';
                                if ($pa->id == $_GET['grant']) {
                                    $selected = 'selected="selected"';
                                }
                                ?>
                                <option value="<?= $pa->id ?>" <?= $selected ?>><?= $pa->name ?></option>
                            <?php } ?>
                        </select>
                    </div> -->
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
                                <option value="<?php echo $field ?>" <?php echo $selected; ?>>
                                    <?php echo $val ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Keyword : <input type="search" class="form-control input-sm" name="q[]"
                        value="<?php echo isset($q[0]) ? $q[0] : '' ?>" placeholder=""
                        onkeypress="return submitFilter(event)">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('grantee_name', $sort_by, $sort) ?>>Name</th>
                            <th <?php echo sorting_attribute('grants_name', $sort_by, $sort) ?>>Grants</th>
                            <th <?php echo sorting_attribute('fiscal_year', $sort_by, $sort) ?>>Period</th>
                            <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {

                            $no = $paging['start_row'];
                            // $no = $paging['start_row'];
                        
                            foreach ($data as $row) {

                                $format = 'ID';
                                if ($country_id == '2') {
                                    $format = 'US';
                                }
                                $fullname = $this->Grantee_ent_model->get_full_name($row, $format);
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $no++ ?>
                                    </td>
                                    <td><a target="_BLANK"
                                            href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id); ?>"
                                            class="<?= $row->blacklist ? 'text-danger font-weight-bold' : '' ?>">

                                            <?php echo $fullname ?>
                                        </a></td>
                                    <td>
                                        <?php echo $row->program_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->fiscal_year; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->status_name; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('admin/in_progress/verify/' . $row->grantee_grant_id) ?>"
                                            class="btn btn-primary btn-xs">Detail</a>
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
                <?php echo $paging['start_row'] ?> to
                <?php echo $paging['end_row'] ?> of
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

<div class="modal fade" id="mdl_note_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <textarea class="form-control" name="note_reject" id="note_reject" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn-save-note" class="btn btn-primary success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/form_filter') ?>
<!-- Modal Download -->
<?php $this->load->view('admin/partials/modal_download_excel') ?>