<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= isset($this->User_grantee_grant_model->name) ? $this->User_grantee_grant_model->name : ''; ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
    <?php if($this->session->flashdata('success_copy_period')) { ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?= $this->session->flashdata('success_copy_period') ?>
        </div>
    <?php } ?>
    <?php $this->session->unset_userdata('success_copy_period');?>
        <form id="frm_manage" method="GET">
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
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
                    <a href="<?php echo $link_add; ?>" class="btn btn-success btn-sm">
                        ADD NEW
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th>Academic Year</th>
                            <th>Start Registration Date</th>
                            <th>End Registration Date</th>
                            <th>Departure Year</th>
                            <th>Memo Budget</th>
                            <th width="50">Status</th>
                            <?php //if (get_active_country(true) == INDONESIAN_DATABASE) :  ?>
                                <!-- <th width="50">Result</th>  -->
                            <?php //endif; ?>
                            <th width="150" class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                        ?>
                                <tr>
                                    <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
                                    <td><?php echo $no ?></td>
                                    <td><?php echo $row->fiscal_year ?></td>
                                    <td><?php echo $row->start_date ? date("d M Y H:i", strtotime($row->start_date)) : '' ?></td>
                                    <td><?php echo $row->end_date ? date("d M Y H:i", strtotime($row->end_date)) : '' ?></td>
                                    <td><?php echo $row->departure_date ? $row->departure_date : '' ?></td>
                                    <td>
                                        <?php if(!empty($row->memo_budget)){ ?>
                                            <?php foreach ($row->memo_budget as $key_memo => $memo) { ?>
                                                <a target="_blank" href="<?php echo site_url($memo->memo_budget) ?>"><?= $memo->file_name ?></a>
                                                <?php if(count($row->memo_budget) > 1) { echo '<br/>'; }?>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row->is_active == 1) {
                                            echo '<span class="badge badge-success">Active</span>';
                                        } else if ($row->is_active == 0) {
                                            echo '<span class="badge">Inactive</span>';
                                        }
                                        ?>
                                    </td>

                                    <?php //if (get_active_country(true) == INDONESIAN_DATABASE) : ?>
                                    <!-- <td>
                                        <?php foreach ($row->report as $key => $name_report) { ?>
                                        <a href="<?= $link_view_result . $row->id . '/' . $name_report->id; ?>" class="btn btn-warning btn-xs" target="_blank"><?= $name_report->name ?></a>
                                        <?php } ?>
                                    </td> -->
                                    <?php //endif; ?>

                                    <td class="text-right" width="20%">
                                        <?php //if(get_active_country(true) == INDONESIAN_DATABASE) { ?>
                                            <!-- <a href="<?= $link_report_setting . $row->id; ?>" class="btn btn-success btn-xs">
                                                <i class="fa fa-file-text"></i> Report Setting
                                            </a> -->
										<?php //} ?>
                                        <a href="<?= base_url('admin/user_grantee_grant/copy_period/') . $row->id ?>" class="btn btn-success btn-xs btn-copy-period">
                                            <i class="fa fa-copy"></i> Copy
                                        </a>
                                        <a href="<?php echo $link_edit . $row->id ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="<?php echo $link_delete . $row->id ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')">
                                            <i class="fa fa-times-circle"></i> Delete
                                        </a>
                                        <?php if (get_active_country(true) == INDONESIAN_DATABASE) { ?>
                                            <br>
                                            <a href="<?php echo site_url('admin/user_grantee_grant/unprocessed_applicants/') . $row->id . '/' . $row->user_grantee_grant_id ?>" class="btn btn-warning btn-xs mt-2">
                                                <i class="fa fa-times-circle"></i> Unprocessed Applicants 
                                                <?php if (isset($row->unprocessed_count) && $row->unprocessed_count > 0) { ?>
                                                    <span class="badge badge-light"><?php echo $row->unprocessed_count; ?></span>
                                                <?php } ?>
                                            </a>
                                        <?php } ?>
                                    </td>
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
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->