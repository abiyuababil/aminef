<?php
// reusable table from shared admin/partials/payment_bulk_support.php, 7 columns.
$sort_field = isset($sort_by_support) ? $sort_by_support : (isset($sort_by) ? $sort_by : '');
$sort_order = isset($sort_support) ? $sort_support : (isset($sort) ? $sort : '');
$disable_edit = isset($disabled) ? $disabled : '';
$grant_labels = isset($grant_labels) ? $grant_labels : [];
?>
<form id="frm_payment_support" name="frm_payment_support" method="GET">
    <input type="hidden" name="fiscal_year" value="<?php echo html_escape($selected_fiscal_year); ?>">
    <input type="hidden" name="program_id" value="<?php echo html_escape($selected_program_id); ?>">
    <input type="hidden" name="tab" value="payment_support">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div id="content">
                <div class="panel-body">
                    <div class="data-header clearfix form-inline">
                        <div class="pull-left">
                            Search : <input type="search" class="form-control input-sm" name="search_support" value="<?= html_escape($this->input->get('search_support')) ?>" placeholder="Search grantee name..." onkeydown="if(event.key === 'Enter'){ event.preventDefault(); document.forms.frm_payment_support.submit(); }">
                        </div>
                        <div class="pull-right">
                            <?php if (has_permission('payments', 'create')) { ?>
                            <a href="#" data-toggle="modal" data-target="#mdl_add_record_support" data-mode="add" class="btn btn-success btn-sm" id="btn-add">
                                ADD NEW
                            </a>
                            <?php } ?>
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
                                    <th>Grant</th>
                                    <th>Category</th>
                                    <th data-form="frm_payment_support" <?php echo sorting_attribute('payment_date', $sort_by, $sort) ?>>Entry Date</th>
                                    <th>Grantee Name</th>
                                    <th>Total Payment (IDR)</th>
                                    <th>Total Payment (USD)</th>
                                    <th>Status</th>
                                    <th width="300" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($payment_support['payment_records'])) {
                                    $row_number = isset($payment_support['paging']['start_row']) ? $payment_support['paging']['start_row'] : 1;
                                    foreach ($payment_support['payment_records'] as $payment_row) {
                                        $row_grant_id = ($this->session->userdata('active_country') == AMERICAN_DATABASE && !empty($payment_row->period_id) && is_numeric($payment_row->period_id)) ? $payment_row->period_id : '';
                                        $grant_label = (!empty($row_grant_id) && isset($grant_labels[$row_grant_id])) ? $grant_labels[$row_grant_id] : '-';
                                        $name_list_html = '';
                                        $name_list_html .= '<ul style="margin:0px; padding:0px; list-style:none;">';
                                        if (!empty($payment_row->full_name)) {
                                            foreach ($payment_row->full_name as $name_index => $person_name) {
                                                $name_list_html .= '<li>'.$person_name.'</li>';
                                            }
                                        }
                                        $name_list_html .= '</ul>';
                                ?>
                                        <tr>
                                            <td><?= $row_number ?></td>
                                            <td><?= html_escape($grant_label) ?></td>
                                            <td><?= isset($payment_row->category) ? $payment_row->category : '' ?></td>
                                            <td><?= !empty($payment_row->payment_date) ? date('d-M-Y H:i:s', strtotime($payment_row->payment_date)) : '-' ?></td>
                                            <td style="white-space:nowrap;"><?= $name_list_html ?></td>
                                            <td>
                                                <?php
                                                    $nominal_values_idr = [];
                                                    if (!empty($payment_row->items) && is_array($payment_row->items)) {
                                                        foreach ($payment_row->items as $group_id => $items) {
                                                            $total_per_grantee = 0;
                                                            if (is_array($items)) {
                                                                foreach ($items as $group_item) {
                                                                    $total_per_grantee += (float) $group_item->nominal_idr;
                                                                }
                                                            } elseif (is_object($items)) {
                                                                $total_per_grantee += (float) $items->nominal_idr;
                                                            }
                                                            $nominal_values_idr[] = $total_per_grantee;
                                                ?>
                                                <div>
                                                    <?= format_money($total_per_grantee, 'IDR') ?>
                                                </div>
                                                <?php } } ?>
                                                <b><u><?= format_money(array_sum($nominal_values_idr), 'IDR')?></u></b>
                                            </td>
                                            <td>
                                                <?php
                                                    $nominal_values = [];
                                                    if (!empty($payment_row->items) && is_array($payment_row->items)) {
                                                        foreach ($payment_row->items as $group_id => $items) {
                                                            $total_per_grantee = 0;
                                                            if (is_array($items)) {
                                                                foreach ($items as $group_item) {
                                                                    $total_per_grantee += (float) $group_item->nominal;
                                                                }
                                                            } elseif (is_object($items)) {
                                                                $total_per_grantee += (float) $items->nominal;
                                                            }
                                                            $nominal_values[] = $total_per_grantee;
                                                ?>
                                                <div>
                                                    <?= format_money($total_per_grantee, 'USD') ?>
                                                </div>
                                                <?php } } ?>
                                                <b><u><?= format_money(array_sum($nominal_values), 'USD')?></u></b>
                                            </td>
                                            <td><?php echo isset($payment_row->status_name) ? $payment_row->status_name : ''; ?></td>
                                            <td class="text-center">
                                                <a href="#" data-toggle="modal" data-target="#mdl_add_record_support" data-mode="view" data-record_id="<?= $payment_row->id ?>" data-grant-id="<?= html_escape($row_grant_id) ?>" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                <?php if (has_permission('payments', 'update')) { ?>
                                                <a href="#" data-toggle="modal" data-target="#mdl_add_record_support" data-mode="edit" data-record_id="<?= $payment_row->id ?>" data-grant-id="<?= html_escape($row_grant_id) ?>" class="btn btn-primary btn-xs <?php echo $disable_edit; ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php } ?>
                                                <?php if (has_permission('payments', 'delete')) { ?>
                                                <a href="<?= site_url('admin/request_payment/delete_record_grantee/'.$payment_row->id.'?from_finance=1') ?>" class="btn btn-danger btn-xs confirm-del">
                                                    <i class="fa fa-times-circle"></i> Delete
                                                </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php
                                        $row_number++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-left">
                        Showing <?php echo isset($payment_support['paging']['start_row']) ? $payment_support['paging']['start_row'] : 0 ?> to <?php echo isset($payment_support['paging']['end_row']) ? $payment_support['paging']['end_row'] : 0 ?> of <?php echo isset($payment_support['paging']['total_rows']) ? $payment_support['paging']['total_rows'] : 0 ?> entries
                    </div>
                    <?php echo isset($payment_support['paging']['html']) ? $payment_support['paging']['html'] : '' ?>
                    <input type="hidden" name="sort_by" value="<?php echo html_escape($sort_field); ?>">
                    <input type="hidden" name="sort" value="<?php echo html_escape($sort_order); ?>">
                </div>
            </div>
        </div>
    </div>
</form>
