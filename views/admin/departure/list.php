<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Departure</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <!-- <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul> -->
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
                    <!-- <div class="form-group mr-5">
                        Status
                        <select class="form-control" name="status_section" onchange="document.forms.frm_manage.submit()">
                            <?php
                            $search_by = $_GET['status_section'];
                            foreach ($filter_status as $field => $val) {
                                $selected = '';
                                if (isset($search_by) && $search_by == $field) {
                                    $selected = 'selected="selected"';
                                }
                                ?>
                                <option
                                    value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val ?></option>
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
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('grantee_name', $sort_by, $sort) ?>>Name</th>
                            <th <?php echo sorting_attribute('grants_name', $sort_by, $sort) ?>>Grants</th>
                            <th <?php echo sorting_attribute('fiscal_year', $sort_by, $sort) ?>>Period</th>
                            <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            
                            $no = 1;
                            // $no = $paging['start_row'];

                            foreach ($data as $row) {

                                $format = 'ID';
                                if ($country_id == '2') {
                                    $format = 'US';
                                }
                                $fullname = $this->Grantee_ent_model->get_full_name($row, $format);
                        ?>
                                <tr>
                                    <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php // echo $row->staff_id ?>"></td>
                                    <td><?php  echo $no++ ?></td>
                                    <td><a target="_BLANK" href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id);?>" class="<?= $row->blacklist ? 'text-danger font-weight-bold' : '' ?>"><?php  echo $fullname ?></a></td>
                                    <td><?php echo $row->program_name; ?></td>
                                    <td><?php echo $row->fiscal_year; ?></td>
                                    <td><?php  echo $row->status_name; ?></td>
                                    <td class="text-center" style="position:relative;">
                                        <?php if(has_permission('departure', 'detail')) { ?>
                                            <a class="btn btn-primary btn-xs" href="<?php  echo site_url('admin/departure/detail/' . $row->grantee_grant_id) ?>">Detail</a> 
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

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
</div>

<div class="modal fade" id="mdl_note_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div class="modal fade" id="mdl_note_drop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <textarea class="form-control" name="note_drop" id="note_drop" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn-save-note-drop" class="btn btn-primary success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/form_filter') ?>