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

    .program-filter-section > .form-group {
        width: 350px;
        margin-left: 12px;
    }

    .select2-container--bootstrap .select2-selection {
        border-radius: 0px !important;
    }

    .select2-selection--single > .select2-selection__rendered {
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
        <h1 class="page-header">DET Users</h1>
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
                        <!-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button> -->
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
                    Search : <input type="search" class="form-control input-sm" name="search" value="<?php echo $paging['search'] ?>" placeholder="" onkeypress="return submitFilter(event)">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('grantee_name', $sort_by, $sort) ?>>Name</th>
                            <th <?php echo sorting_attribute('created_at', $sort_by, $sort) ?>>Created Date</th>
                            <th <?php echo sorting_attribute('det_period', $sort_by, $sort) ?>>Fiscal Year</th>
                            <th <?php echo sorting_attribute('elt_period', $sort_by, $sort) ?>>ELT Period</th>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            
                            $no = 1;

                            foreach ($data as $row) {
                                $fullname = get_full_name($row);
                        ?>
                                <tr>
                                    <td><input type="checkbox" class="chk-row" name="ids[]" value=""></td>
                                    <td><?php  echo $no++ ?></td>
                                    <td><a target="_BLANK" href="<?php echo base_url('admin/users_det/edit/' . $row->id);?>"><?php  echo $fullname ?></a></td>
                                    <td><?php echo date('d/m/Y', strtotime($row->created_at)); ?></td>
                                    <td><?php echo $row->det_period; ?></td>
                                    <td><?php echo $row->elt_period; ?></td>
                                    <td class="text-center" style="position:relative;">
                                        <a class="btn btn-primary btn-xs" href="<?php  echo site_url('admin/users_det/edit/' . $row->id) ?>"><i class="fa fa-edit"></i> Edit</a> 
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