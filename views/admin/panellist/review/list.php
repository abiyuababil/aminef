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

    #review-pdf-modal .modal-dialog {
        width: 100%;
        margin: 0;
        max-width: 100%;
    }

    #review-pdf-modal .modal-content {
        border-radius: 0;
    }

    #review-pdf-modal .modal-body {
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
        <h1 class="page-header">Review
        </h1>
    </div>
</div>

<?php
if ($this->session->flashdata('error')) :
    echo show_alert('danger', $this->session->flashdata('error'));
endif;
?>

<div class="row">
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                
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
                                <option
                                    value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?php echo isset($q[0]) ? $q[0] : '' ?>"
                                     placeholder="" onkeypress="return submitFilter(event)">
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
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th width="35" class="text-center">#</th>
                        <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                        <th>Grants</th>
                        <th>Academic Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
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
                                <td class="text-left"><?= $row->grant_name ?></td>
                                <td class="text-left"><?= $row->fiscal_year ?></td>
                                <td class="text-left"><?= $row->start_date_review ? date('d F Y', strtotime($row->start_date_review)) : '' ?></td>
                                <td class="text-left"><?= $row->end_date_review ? date('d F Y', strtotime($row->end_date_review)) : '' ?></td>
                                <td class="text-right"><?= $row->score ?></td>
                                <td>
                                    <?php if($row->rank_recommendation != ''){ ?>
                                    <span class="badge <?= $row->rank_recommendation ? get_badge_status($row->rank_recommendation) : '' ?>" data-toggle="tooltip" data-placement="right" title="<?= $row->panellist_name ?>" style="cursor:default;">
                                        <?= $row->rank_recommendation != '' ? $row->rank_recommendation : '-' ?>
                                    </span>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $categories = $this->User_grantee_grant_category_model->get_data([
                                            'user_grantee_grant_id' => $row->grant_id,
                                            'is_active'             => 1,
                                            'sort'                  => 1,
                                            'category_name'         => 'Application'
                                        ]);

                                        $params = [
                                            'category_id' => $categories[0]->id,
                                            'grants_id' => $row->grant_id,
                                            'country_id' => $row->country_id,
                                            'grantee_id' => $row->user_grantee_id,
                                            'grantee_grant_id' => $row->program_id,
                                        ];

                                        $query_params = http_build_query($params);
                                        
                                    ?>
                                    <?php 
                                        if(get_condition_rank($row->start_date_review, $row->end_date_review)) { ?>
                                            <a class="btn btn-primary btn-xs select-view" 
                                                data-pdfurlold="<?php echo site_url('document/pdf/' . $row->user_grantee_id . '/' . $row->grant_id . '?' . $query_params); ?>#toolbar=0&navpanes=0&scrollbar=0'); ?>" 
                                                data-pdfurl="<?php echo site_url('panelist/detail_review/' . $row->grantee_grant_id ); ?>?is_pdf=1" 
                                                data-applicationurl="<?php echo site_url('panelist/detail_review/' . $row->grantee_grant_id ); ?>" 
                                                data-toggle="modal" 
                                                data-target="#review-modal">Detail</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            </tr>
                        <?php
                            $no++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
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
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

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
<div class="modal fade" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="review-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="review-modal-label">Select view detail Applicant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-link btn-view-pdf">
                            <i class="fa fa-file-pdf-o" style="font-size: 50pt;"></i>
                            <br>
                            View PDF
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="" class="btn btn-link btn-view-form-application">
                            <i class="fa fa-file-text-o" style="font-size: 50pt;"></i> 
                            <br>
                            View Application
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="review-pdf-modal" tabindex="-1" role="dialog" aria-labelledby="review-modal-pdf-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="review-modal-pdf-label">
                    View PDF <a type="button" class="btn btn-warning pull-right" data-dismiss="modal" style="margin-top: -5px !important;">Close</a>
                </h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-info text-center hide" id="loading-pdf"><i class="fa fa-spinner fa-spin"></i> Loading pdf, please wait.</div>
                <iframe id="pdf-iframe" class="hide"></iframe>
            </div>
        </div>
    </div>
</div>
