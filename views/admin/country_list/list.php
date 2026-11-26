<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage Country</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <?php if(has_permission('countries', 'delete')) { ?>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul>
                        <?php } ?>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>

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
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>"
                                    placeholder="">
                    <?php if(has_permission('countries', 'add')) { ?>
                    <a href="<?php echo site_url('admin/country_list/add') ?>" class="btn btn-success btn-sm">
                        ADD NEW
                    </a>
                    <?php } ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('code', $sort_by, $sort) ?>>Code</th>
                            <th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Country</th>
                            <th <?php echo sorting_attribute('phone_code', $sort_by, $sort) ?>>Phone Code</th>
                            <th width="150" class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                $filter_link = site_url('admin/state/manage/' . $row->id);
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk-row" name="ids[]"
                                               value="<?php echo $row->id ?>">
                                    </td>
                                    <td>
                                        <?php echo $no ?>
                                    </td>
                                    <td>
                                        <?php echo $row->code ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo $filter_link ?>" title="Click to View List Of State">
                                            <?php echo $row->name ?>
                                        </a>
                                    </td>
                                    <td><?php echo $row->phone_code ?></td>
                                    <td class="text-center">
                                        <?php if(has_permission('countries', 'edit')) { ?>
                                        <a href="<?php echo site_url('admin/country_list/edit/' . $row->id) ?>"
                                           class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <?php } ?>
                                        <?php if(has_permission('countries', 'delete')) { ?>
                                        <a href="<?php echo site_url('admin/country_list/delete/' . $row->id) ?>"
                                           class="btn btn-danger btn-xs confirm-del">
                                            <i class="fa fa-times-circle"></i> Delete
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
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?>
                of <?php echo $paging['total_rows'] ?> entries
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
