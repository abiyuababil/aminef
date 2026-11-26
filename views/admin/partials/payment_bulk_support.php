
    <form id="frm_manage_support" name="frm_manage_support" method="GET">
        <input type="hidden" name="sort_by" value="<?php echo html_escape(isset($sort_by) ? $sort_by : ''); ?>">
        <input type="hidden" name="sort" value="<?php echo html_escape(isset($sort) ? $sort : ''); ?>">
    </form>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div id="content">
                <div class="panel-body">
                    <div class="data-header clearfix form-inline">
                        <div class="pull-left">
                            <!-- <input type="hidden" name="pid_support" value="support" form="frm_manage_support"> -->
                            Search : <input type="search" class="form-control input-sm" form="frm_manage_support" name="search_support" value="<?= $payment_support['paging']['search_support'] ?>" placeholder="Search" onkeydown="if(event.key === 'Enter'){ event.preventDefault(); document.forms.frm_manage_support.submit(); }">

                            Status :
                            <select class="form-control input-sm" name="status_support" form="frm_manage_support" onchange="document.forms.frm_manage_support.submit()">
                                <option value="">-- Select Status --</option>
                                <?php
                                foreach ($record_status as $rs) {
                                    $selected = '';
                                    if ($rs->id == $payment_support['paging']['status']) $selected = 'selected';
                                ?>
                                    <option value="<?php echo $rs->id ?>" <?php echo $selected ?>><?php echo $rs->name ?></option>
                                <?php } ?>
                            </select>

                            Year :
                            <select class="form-control input-sm" name="year_support" form="frm_manage_support" onchange="document.forms.frm_manage_support.submit()">
                                <option value="">-- Select Year --</option>
                                <?php for ($i = date('Y', strtotime('+5 years')); $i > 1900; $i--) : ?>
                                    <?php
                                    $selected = '';
                                    if ($i == $payment_support['paging']['year_support']) {
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>

                            Show :
                            <select class="form-control input-sm" name="limit_support" form="frm_manage_support" onchange="document.forms.frm_manage_support.submit()">
                                <?php
                                foreach ($limit['limit_options'] as $lo) {
                                    $selected = '';
                                    if ($lo == $payment_support['paging']['limit_support']) $selected = 'selected';
                                ?>
                                    <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                                <?php } ?>
                            </select>
                            entries
                        </div>
                        <div class="pull-right">
                            <a href="#" data-toggle="modal" data-target="#mdl_add_record_support" data-mode="add" class="btn btn-success btn-sm" id="btn-add">
                                ADD NEW
                            </a>
                        </div>
                        <div class="col-md-12 p-0 mt-4">
                            <?php if ($this->session->flashdata('success_message_support')) { ?>
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('success_message_support'); ?>
                                </div>
                                <?php $this->session->set_flashdata('success_message_support', false); ?>    
                            <?php } ?>

                            <?php if ($this->session->flashdata('failed_message_support')) { ?>
                                <div class="alert alert-danger">
                                    <i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('failed_message_support'); ?>
                                </div>
                                <?php $this->session->set_flashdata('failed_message_support', false); ?>    
                            <?php } ?>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="35" class="text-center">#</th>
                                    <th>Category</th>
                                    <th data-form="frm_manage_support" <?php echo sorting_attribute('payment_date', isset($sort_by) ? $sort_by : '', isset($sort) ? $sort : '') ?>>Payment Date</th>
                                    <th>Status</th>
                                    <th>Grantee Name</th>
                                    <th>Total Payment (IDR)</th>
                                    <th>Total Payment (USD)</th>
                                    <th width="300" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($payment_support['payment_records']) {
                                    $no = $payment_support['paging']['start_row'];
                                    foreach ($payment_support['payment_records'] as $row) {
                                        $join_full_name = '';
                                        $join_full_name .= '<ul style="margin:0px; padding:0px; list-style:none;">';
        
                                        $available_program = [];
                                        foreach ($row->full_name as $key => $value) {
        
                                            $join_full_name .= '<li>'.$value.'</li>';
                                        }
                                        $join_full_name .= '</ul>';
                                ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $row->category ?></td>
                                            <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                            <td><?php echo $row->status_name; ?></td>
                                            <td style="white-space:nowrap;"><?= $join_full_name ?></td>
                                            <!-- <td><?= $row->description ?></td> -->
                                            <td>
                                                <?php 
                                                    $nominal_idr = '';
                                                    $total_payment_idr = [];
                                                    foreach ($row->items as $group_id => $items) {
                                                        $total_per_grantee = 0;
                                                        foreach ($items as $item) {
                                                            $total_per_grantee += (float) $item->nominal_idr;
                                                        }
                                                        $total_payment_idr[] = $total_per_grantee;
                                                ?>
                                                <div>
                                                    <?= format_money($total_per_grantee, 'IDR') ?>
                                                </div>
                                                <?php } ?>
                                                <b><u><?= format_money(array_sum($total_payment_idr), 'IDR')?></u></b>
                                            </td>
                                            <td>
                                                <?php 
                                                    $nominal = '';
                                                    $total_payment = [];
                                                    foreach ($row->items as $group_id => $items) {
                                                        $total_per_grantee = 0;
                                                        foreach ($items as $item) {
                                                            $total_per_grantee += (float) $item->nominal;
                                                        }
                                                        $total_payment[] = $total_per_grantee;
                                                ?>
                                                <div>
                                                    <?= format_money($total_per_grantee, 'USD') ?>
                                                </div>
                                                <?php } ?>
                                                <b><u><?= format_money(array_sum($total_payment), 'USD')?></u></b>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" data-toggle="modal" data-target="#mdl_add_record_support" data-mode="view" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                <a href="#" data-toggle="modal" data-target="#mdl_add_record_support" data-mode="edit" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs <?php echo $disabled; ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="<?= site_url('admin/request_payment/delete_record_grantee/'.$row->id) ?>" class="btn btn-danger btn-xs confirm-del">
                                                    <i class="fa fa-times-circle"></i> Delete
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
                        Showing <?php echo $payment_support['paging']['start_row'] ?> to <?php echo $payment_support['paging']['end_row'] ?> of <?php echo $payment_support['paging']['total_rows'] ?> entries
                    </div>
                    <!-- /.pagination info -->
                    <?php echo $payment_support['paging']['html'] ?>
                    <!-- /.pagination -->
                </div>
            </div>
        </div>
    </div>