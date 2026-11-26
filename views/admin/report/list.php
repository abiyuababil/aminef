<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage Reports</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php 
    if ($this->session->flashdata('success')) : 
        echo show_alert('success', $this->session->flashdata('success'));
    elseif($this->session->flashdata('danger')) :
        echo show_alert('danger', $this->session->flashdata('danger'));
    endif;
?>
<div class="row">
    <div class="col-lg-12">
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
                            <li><a href="javascript:;" data-action="copy_grant">Copy to Grant</a></li>
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
                    Period : 
                    <select class="form-control input-sm" name="year" onchange="document.forms.frm_manage.submit()">
                        <option value="0">Show All</option>
                        <?php
                            $year = $this->input->get('year');
                            if (!$year && $year != '0' && !$this->input->get('page')) {
                                $year = date('Y');
                            }

                            foreach ($periods as $period) { 
                            
                        ?>
                            <option value="<?php echo $period->year ?>" <?php echo $period->year == $year ? 'selected' : ''; ?>><?php echo $period->year ?></option>
                        <?php } ?>
                    </select> &nbsp;
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th>Grant</th>
                            <th>Reports</th>
                            <th>Period</th>
                            <th width="200" class="text-center">Action</th>
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
                                    <td><?= $no ?></td>
                                    <td><?= $row->name ?></td>
                                    <td>
                                        <?php 
                                            if (count($row->category_report) > 0) :
                                            foreach($row->category_report as $key => $value) :
                                        ?>
                                            <a href="<?= site_url('admin/manage_report/submission/'.$row->id.'/'.$value['id']) ?>" class="btn btn-primary btn-xs"><?= $value['name']?></a>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </td>
                                    <td><?php echo $row->year; ?></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#mdl_edit" data-id="<?= $row->id; ?>">
                                            Add Report
                                        </a>
                                        <a href="<?php echo site_url('admin/manage_report/category_report/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit Report
                                        </a>
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


<div class="modal fade" id="mdl_edit">
    <div class="modal-dialog">
        <form action="<?= base_url(); ?>admin/report/create_report" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Reports</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input type="hidden" name="user_grantee_grant_id" id="user_grantee_grant_id">
                        <div class="col-sm-3">
                            <label>Name</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-3">
                            <label>Upload Report Template?</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="checkbox" name="is_template" value="1">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-3">
                            <label>Is Active</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="checkbox" name="is_active" value="1">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="modal fade" id="mdl_select_grant">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input name="user_id" type="hidden" value="<?= $this->User_model->id; ?>"/>
                        <input name="country_id" type="hidden" value="<?= $country_id; ?>"/>
                        <input name="program_id" type="hidden" id="ex_program_id"/>

                        <label>Select Grant</label>
                        <select name="copy_grant_id" class="form-control select2" id="copy_grant_id" form="frm_manage" required>
                            <option value="">--Choose one--</option>
                            <?php
                            foreach ($grants as $key => $prgm) {
                                $period = ' - ' . $prgm->year;
                                if (empty($prgm->year)) {
                                    $period = '';
                                }

                                echo "<option value='{$prgm->id}'>{$prgm->name}</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" name="action" form="frm_manage" value="copy_grant">    
                    </div>
                    <div class="form-group col-sm-12 select-period-section">
                        <label>Select Period</label>
                        <select name="period_id" class="form-control select2" id="period_id" form="frm_manage" required>
                            <option value="">-- Select Period --</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" form="frm_manage" class="btn btn-primary">Copy</button>
            </div>
        </div>
    </div>
</div>