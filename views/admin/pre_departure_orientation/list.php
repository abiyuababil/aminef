<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">PDO Global</h1>
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
                <?php if(has_permission('pdo_global', 'add')) { ?>
                <div class="pull-right">
                    <a href="<?= base_url('admin/pre_departure_orientation/add') ?>" class="btn btn-success">Create New PDO</a>
                </div>
                <?php } ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="chk-all"></th>
                            <th class="text-center">#</th>
                            <th <?php echo sorting_attribute('period', $sort_by, $sort) ?>>Period</th>
                            <th>PDO Format</th>
                            <th width="20%">Date</th>
                            <th>Location</th>
                            <th>Grants</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = 1;
                            foreach ($data as $row) { 
                                $grants_name = get_all_db('am_user_grantee_grant', [], explode(",", $row->user_grantee_grant_id), 'id');
                                $name_grants = array_column($grants_name, 'name');

                                $date_print = $location_print = '';
                                if($row->pdo_format == 'online'){
                                    $date_print = $row->date != '' ? date('d F Y H:i', strtotime($row->date)) : '';
                                    $location_print = format_editor_html_for_email($row->location);
                                }else if($row->pdo_format == 'offline'){
                                    $date_print = $row->date_offline != '' ? date('d F Y H:i', strtotime($row->date_offline)) : '';
                                    $location_print = format_editor_html_for_email($row->location_offline);
                                }else if($row->pdo_format == 'hybrid'){
                                    $online = $row->date != '' ? date('d F Y H:i', strtotime($row->date)) : '';
                                    $offline = $row->date_offline != '' ? date('d F Y H:i', strtotime($row->date_offline)) : '';
                                    $date_print = 'Online : ' . $online . '<br />
                                                       Offline : '.$offline.'
                                                        ';
                                        
                                    $location_print = ' <table style="width:100%">
                                                            <tr>
                                                                <td style="vertical-align: top;width:15%;"><b>Online </b></td>
                                                                <td style="vertical-align: top;">: </td>
                                                                <td style="vertical-align: top;"> '.format_editor_html_for_email($row->location).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align: top;"><b>Offline </b></td>
                                                                <td style="vertical-align: top;">: </td>
                                                                <td style="vertical-align: top;"> '.format_editor_html_for_email($row->location_offline).'</td>
                                                            </tr>
                                                        </table>';

                                }
                        ?>
                                <tr>
                                    <td><input type="checkbox" class="chk-row" name="ids[]"></td>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $row->fiscal_year; ?></td>
                                    <td><?php echo ucfirst($row->pdo_format); ?></td>
                                    <td><?php echo $date_print; ?></td>
                                    <td><?php echo $location_print; ?></td>
                                    <td><?php echo implode("<br>", $name_grants); ?></td>
                                    <td class="text-center" style="position:relative;">
                                        <?php if(has_permission('pdo_global', 'edit')) { ?>
                                        <a href="<?= base_url('admin/pre_departure_orientation/edit/'.$row->id) ?>" class="btn btn-xs btn-primary">Edit</a>
                                        <?php } ?>
                                        <?php if(has_permission('pdo_global', 'delete')) { ?>
                                        <a href="<?= base_url('admin/pre_departure_orientation/delete/'.$row->id) ?>" onclick="return confirm('Are You Sure?')" class="btn btn-xs btn-danger">Delete</a>
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

<?php $this->load->view('admin/partials/form_filter') ?>