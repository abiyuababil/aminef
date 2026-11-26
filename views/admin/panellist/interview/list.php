<style>
    td {
        height: 40px;
    }

    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
    }

    .modal-content {
        width: 100%;
    }

    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: none;
    }

    #interview-pdf-modal .modal-dialog {
        width: 100%;
        margin: 0;
        max-width: 100%;
    }

    #interview-pdf-modal .modal-content {
        border-radius: 0;
    }

    #interview-pdf-modal .modal-body {
        padding: 0;
    }

    #pdf-iframe {
        width: 100%;
        height: 100vh;
        border: none;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Interview
            <!-- <a href="<?php echo site_url('admin/new_grantee/download_pdf?' . $params) ?>" class="btn btn-primary btn-sm pull-right" title="Export New Grantee dalam format file pdf">
                DOWNLOAD PDF
            </a>
            <a href="<?php echo site_url('admin/new_grantee/download_excel?' . $params) ?>" style="margin-right: 5px;" class="btn btn-primary btn-sm pull-right" title="Export New Grantee dalam format file pdf">
                DOWNLOAD EXCEL
            </a> -->
        </h1>

        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php $this->session->set_flashdata('success', false); ?>
        <?php } ?>

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
            <?php $this->session->set_flashdata('error', false); ?>
        <?php } ?>
    </div>
</div>

<?php if (isset($import_success) && $import_success === false) { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        File Excel tidak dapat di import, pastikan anda menggunakan template excel yang valid.
    </div>
<?php } ?>

<?php if (isset($import_success) && is_numeric($import_success)) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Sukses melakukan import sebanyak total <?= $import_success ?> data Alumni.
    </div>
<?php } ?>

<?php
if ($this->session->flashdata('error')) :
    echo show_alert('danger', $this->session->flashdata('error'));
endif;
?>

<div class="row">
    <?php
        $search = $this->input->get('q');

        $has_search = false;

        if ($search) {
            $has_search = array_filter($search, function($search) {
                return !empty($search);
            });
        }

    ?>
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <?php if ($has_search) { ?>
                <div class="pull-left">
                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit']) {
                                $selected = 'selected';
                            }
                        ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <?php } ?>
                <div class="pull-right">
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
                    Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?php echo isset($q[0]) ? $q[0] : '' ?>" placeholder="" onkeypress="return submitFilter(event)">
                    <a href="javascript:;" onclick="add_filter()" class="btn btn-success btn-sm"><i class="fa fa-plus fa-fw"></i></a>
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
                                        <option value="<?= $field ?>" <?= $selected; ?>><?= $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?= $q[$i] ?>" placeholder="" onkeypress="return submitFilter(event)">
                            <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-fw"></i></a>
                        </div>
                <?php
                    }
                }
                ?>

            </div>
    </div>

    <?php if ($has_search) { ?>

    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th width="35" class="text-center">#</th>
                        <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                        <th>Interview Date</th>
                        <th>Grants</th>
                        <th>Academic Year</th>
                        <th class="text-right">Score</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" width="10px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($data) {
                        $no = $paging['start_row'];
                        foreach ($data as $row) {
                    ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td class="text-left"><?= get_full_name($row); ?></td>
                                <td class="text-left"><?= $row->date ? date('d F, Y h:i A', strtotime($row->date)) : '' ?></td>
                                <td class="text-left"><?= $row->grant_name ?></td>
                                <td class="text-left"><?= $row->fiscal_year ?></td>
                                <td class="text-right"><?php echo $row->score; ?></td>
                                <td>
                                    <?php if ($row->rank_recommendation != '') { ?>
                                        <span class="<?= $row->rank_recommendation && in_array($row->rank_recommendation, [RECOMMENDED, HEIGHLY_RECOMMENDED]) ? 'badge badge-success' : 'badge badge-danger' ?>" data-toggle="tooltip" data-placement="right" title="<?= $row->panellist_name ?>" style="cursor:default;">
                                            <?= get_msg_status($row->rank_recommendation) ?>
                                        </span>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-primary select-view" data-pdfurl="<?php echo site_url('panelist/interview/pdf_application/' . $row->program_id . '/' . $row->id); ?>" data-applicationurl="<?php echo site_url('panelist/interview/form_application/' . $row->program_id . '/' . $row->id); ?>" data-toggle="modal" data-target="#interview-modal">View</a>
                                </td>
                            </tr>
                    <?php
                            $no++;
                        }
                    }
                    ?>
                </tbody>
            </table>

            <div class="pull-left">
                Showing <?= $paging['start_row'] ?> to <?= $paging['end_row'] ?>
                of <?= number_format($paging['total_rows']) ?> entries
            </div>
            <?= $paging['html'] ?>
            <input type="hidden" name="sort_by" value="<?= $sort_by ?>">
            <input type="hidden" name="sort" value="<?= $sort ?>">
        </div>

        </form>
    </div>
    <?php } else { ?>
    <div class="col-md-12">
        <div class="panel panel-default p-0">
            <div class="panel-body p-0">
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>Interview Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($interview_dates as $index => $interview) { ?>
                            <?php if ($interview->date != null) { ?>
                                <tr data-toggle="collapse" data-index="<?php echo $index; ?>" data-date="<?php echo date('Y-m-d', strtotime($interview->date)); ?>" data-target="#data-section-<?php echo $index; ?>" class="accordion-toggle" style="cursor: pointer;">
                                    <td><b class="text-primary"><i class="fa fa-calendar"></i> <?php echo date('j M Y', strtotime($interview->date)); ?></b></td>
                                </tr>

                                <tr id="table-row-<?php echo $index; ?>" class="table-content-row hide">
                                    <td colspan="12" class="hiddenRow p-0">
                                        <div class="accordian-body collapse" id="data-section-<?php echo $index; ?>">
                                            <table class="table table-striped m-0">
                                                <thead>
                                                    <tr>
                                                        <th width="10">#</th>
                                                        <th width="20">Name</th>
                                                        <th width="30">Grants</th>
                                                        <th width="10">Academic Year</th>
                                                        <th width="10">Interview Time</th>
                                                        <th width="10">Score</th>
                                                        <th width="10">Status</th>
                                                        <th width="10" class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="interview-data-rows-<?php echo $index; ?>">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<div id="template-filter" style="display:none">
    <div class="pull-right" style="margin-top:5px; clear:both;">
        <div class="form-group">
            <select class="form-control" name="cnj[]">
                <option value="AND">AND</option>
                <option value="OR">OR</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="search_by[]">
                <?php
                foreach ($filters as $field => $val) {
                ?>
                    <option value="<?= $field ?>"><?= $val ?></option>
                <?php } ?>
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        Keyword : <input type="search" class="form-control input-sm" name="q[]" value="" placeholder="" onkeypress="return submitFilter(event)">
        <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-fw"></i></a>
    </div>
</div>