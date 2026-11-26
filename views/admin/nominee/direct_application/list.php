<style>
    .TriSea-technologies-Switch > input[type="checkbox"] {
        display: none;   
    }

    .TriSea-technologies-Switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        /* width: 40px;   */
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

            <div class="pull-right">
                <a href="<?= base_url('admin/nominee/submission_plan/manage/' . $grantee_grant_id) ?>" class="btn btn-primary">Back</a>
                <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-warning withdraw">Withdraw</a>
                <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-danger drop">Drop</a>
                <input type="hidden" id="data_section" value="planning">
            </div>
        </h3>
    </div>
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
                    <a href="<?= site_url('admin/nominee/direct_application/create/'.$grantee_grant_id)?>" class="btn btn-success btn-sm">
                        Create New Direct Application
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
                            <!-- <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th> -->
                            <?php if(!$is_alumni_page) { ?>
                            <th width="200">Enable to edit/delete?</th>
                            <th width="200" class="text-center">Action</th>
                            <?php } ?>
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
                                <?php if(!$is_alumni_page) { ?>
                                <td>
                                    <div class="TriSea-technologies-Switch mb-2">
                                        <!-- <span class="mr-2"> Grantee Delete</span> -->
                                        <input data-granteegrantid="<?= $grantee_grant_id ?>" data-id="<?= $row->id ?>" onchange="deleteable_grantee(this)" id="deleteable_grantee_<?= $row->id ?>" type="checkbox" <?= $row->deleteable_grantee  ? 'checked' : '' ?>/>
                                        <label for="deleteable_grantee_<?= $row->id ?>" class="label-primary"></label>
                                    </div>
                                </td>
                                <!-- <td><?php  echo badge_approved_declined($row->status); ?></td> -->
                                <td class="text-center" style="position:relative;">
                                    <a href="<?php echo site_url('admin/nominee/direct_application/edit/'.$grantee_grant_id.'/'.$row->id) ?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>

                                    <a href="<?php echo site_url('admin/nominee/direct_application/delete/'.$grantee_grant_id.'/'.$row->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs">
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
</div>


<?php $this->load->view('admin/partials/modal_log') ?>
<?php $this->load->view('admin/partials/modal_confirm') ?>