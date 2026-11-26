<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Panelist Summary 
            <a href="<?php echo site_url('admin/panellist/download_summary_excel'); ?>" class="btn btn-success btn-sm pull-right mb-4" title="Download Excel">
                <i class="fa fa-file-excel-o"></i> Download Excel
            </a>
        </h1>
        <?php if ($this->session->flashdata('success_submitted')) : ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success_submitted') ?></div>
        <?php endif; ?>
        <?php $this->session->unset_userdata('success_submitted'); ?>
        
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div class="data-header clearfix form-inline">
                <div class="pull-left">

                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                    <option value="all" <?php echo 'all' == $paging['limit'] ? 'selected' : '' ?>>All</option>
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
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Name of Panelist</th>
                            <th <?php echo sorting_attribute('email', $sort_by, $sort) ?>>Email</th>
                            <th <?php echo sorting_attribute('review_count', $sort_by, $sort) ?>>Review</th>
                            <th <?php echo sorting_attribute('interview_count', $sort_by, $sort) ?>>Interview</th>
                            <th <?php echo sorting_attribute('mentoring_count', $sort_by, $sort) ?>>Mentoring</th>
                            <th <?php echo sorting_attribute('pdo_global_count', $sort_by, $sort) ?>>PDO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging ? $paging['start_row'] : 1;
                            foreach ($data as $row) {
                            $sof_name = $row->field_of_study_name ? strtolower($row->field_of_study_name) : '';
                        ?>
                                <tr><td><?php echo $no ?></td>
                                    <td><?php echo $row->prefix ?? '' ?> <?php echo $row->name ?></td>
                                    <td><?php echo $row->email ?></td>
                                    <td><a href="javascript:;" class="summary-count" data-id="<?php echo $row->id ?>" data-type="review"><?php echo $row->review_count; ?></a></td>
                                    <td><a href="javascript:;" class="summary-count" data-id="<?php echo $row->id ?>" data-type="interview"><?php echo $row->interview_count; ?></a></td>
                                    <td><a href="javascript:;" class="summary-count" data-id="<?php echo $row->id ?>" data-type="mentoring"><?php echo $row->mentoring_count; ?></a></td>
                                    <td><a href="javascript:;" class="summary-count" data-id="<?php echo $row->id ?>" data-type="pdo"><?php echo $row->pdo_global_count; ?></a></td>
                                </tr>
                        <?php
                                $no++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
             <?php if(isset($paging)){?>
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
            <?php } ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="modal fade" id="summaryDetailsModal" tabindex="-1" role="dialog" aria-labelledby="summaryDetailsModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="summaryDetailsModalLabel">Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="summary-filters" style="margin-bottom:10px; display:none;">
                    <div class="form-inline">
                        <label style="margin-right:8px;">Program:</label>
                        <select id="summary-filter-program" class="form-control input-sm" style="margin-right:16px;"></select>
                        <label style="margin-right:8px;">Period:</label>
                        <select id="summary-filter-period" class="form-control input-sm" style="margin-right:16px;"></select>
                        <button id="summary-filter-clear" class="btn btn-default btn-sm">Clear</button>
                    </div>
                </div>
                <div id="summary-details-content">Loading...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JS moved to application/views/admin/panellist/summary_js.php -->