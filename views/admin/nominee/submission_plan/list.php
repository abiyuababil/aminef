<?php if(!$is_alumni_page) { ?>
<div class="row">
    <div class="col-lg-12">
        <?php //echo '<pre>';print_r($grantee_grant);die;?>
        <h1><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header">
            <?=$grantee_grant->grant_name ?> - <?= $grantee_grant->fiscal_year_period ?>
        </h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php } ?>
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
                    <a href="<?= site_url('admin/nominee/direct_application/manage/'.$grantee_grant_id)?>" class="btn btn-primary btn-sm">
                        Direct Application
                    </a>
                    <button type="button" data-toggle="modal" data-target="#modal-iie" class="btn btn-warning btn-sm">
                        Add IIE Comment
					</button>
                    <a href="<?= site_url('admin/nominee/submission_plan/manage_rank/'.$grantee_grant_id)?>" class="btn btn-primary btn-sm">
                        Manage Rank
					</a>
                    <a href="<?= site_url('admin/nominee/submission_plan/create/'.$grantee_grant_id)?>" class="btn btn-success btn-sm">
                        Create New Submission Plan
					</a>
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
                            <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
                            <th <?php echo sorting_attribute('rank', $sort_by, $sort) ?>>Rank</th>
                            <?php if(!$is_alumni_page) { ?>
                            <th width="200" class="text-center">Action</th>
                            <?PHP } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = 1;
                            foreach ($data as $row) { 
                        ?>
                            <tr>
                                <?php if(!$is_alumni_page) { ?>
                                <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
                                <?php } ?>
                                <td><?php  echo $no++ ?></td>
                                <td><?php echo $row->university_name ?></td>
                                <td><?php  echo badge_submission_plan($row->status); ?></td>
                                <td><?= $row->rank ?></td>
                                <?php if(!$is_alumni_page) { ?>
                                <td class="text-center" style="position:relative;">
                                    <a href="<?php echo site_url('admin/nominee/submission_plan/edit/'.$grantee_grant_id.'/'.$row->id) ?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>

                                    <a href="<?php echo site_url('admin/nominee/submission_plan/delete/'.$grantee_grant_id.'/'.$row->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-times-circle"></i> Delete
                                    </a>
                                    <input data-type="record" data-log="<?= $row->id ?>" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default payment-log" value="Open Log">
                                </td>
                                <?php } ?>
                            </tr>
                        <?php }
                        } ?>

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
<?php $this->load->view('admin/partials/modal_confirm') ?>

<div class="modal fade" id="modal-iie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">IIE Comment</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Comment <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="iie_comment" id="iie_comment" rows="10" required><?= $grantee_grant->iie_comment ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" id="submit-iie" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</div>