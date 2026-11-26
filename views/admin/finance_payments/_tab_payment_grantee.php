<?php
// reusable table from shared admin/partials/payment_bulk_grantee_us.php, 7 columns.
$sort_field = isset($sort_by) ? $sort_by : '';
$sort_order = isset($sort) ? $sort : '';
$disable_edit = isset($disabled) ? $disabled : '';
$total_grant_value = isset($grantee_setting->total_grant) ? $grantee_setting->total_grant : '';
$grantee_id_value = isset($grantee_id) ? $grantee_id : '';
$grant_labels = isset($grant_labels) ? $grant_labels : [];
?>
<form id="filter_payment_grantee" method="GET">
    <input type="hidden" name="fiscal_year" value="<?php echo html_escape($selected_fiscal_year); ?>">
    <input type="hidden" name="program_id" value="<?php echo html_escape($selected_program_id); ?>">
    <input type="hidden" name="tab" value="payment_grantee">
    <input type="hidden" name="pid" value="payment_grantee">
</form>
<form id="form_payment_grantee" role="form" method="POST" enctype="multipart/form-data">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div id="content">

            <div class="panel-body">
                <div class="data-header clearfix form-inline">
                    <div class="pull-left">
                        Search : <input type="search" class="form-control input-sm" form="filter_payment_grantee" name="search_bulk_payment" value="<?= html_escape($this->input->get('search_bulk_payment')) ?>" placeholder="Search grantee name..." onkeydown="if(event.key === 'Enter'){ event.preventDefault(); document.forms.filter_payment_grantee.submit(); }">
                    </div>
                    <div class="pull-right">
                        <?php if (has_permission('payments', 'create')) { ?>
                        <a href="#" data-toggle="modal" data-target="#mdl_bulk_grantee" data-mode="add" class="btn btn-success btn-sm" id="btn-add">
                            ADD NEW
                        </a>
                        <?php } ?>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <?php if ($this->session->flashdata('success_message')) { ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('success_message'); ?>
                            </div>
                            <?php $this->session->set_flashdata('success_message', false); ?>
                        <?php } ?>

                        <?php if ($this->session->flashdata('failed_message')) { ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('failed_message'); ?>
                            </div>
                            <?php $this->session->set_flashdata('failed_message', false); ?>
                        <?php } ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="35" class="text-center">#</th>
                                <th>Grant</th>
                                <th>Sub Category</th>
                                <th>Pay Period</th>
                                <th>Grantee Name</th>
                                <th>Total Payment (IDR)</th>
                                <th>Total Payment (USD)</th>
                                <th>Status</th>
                                <th width="280" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($payment['payment_records']))
                        {
                            $row_number = isset($payment['paging']['start_row']) ? $payment['paging']['start_row'] : 1;
                            foreach($payment['payment_records'] as $payment_row) {
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
                                $nominal_values = [];
                                $nominal_values_idr = [];
                                $nominal_list_html = '';
                                $nominal_list_html .= '<ul style="margin:0px; padding:0px; list-style:none;">';
                                if (!empty($payment_row->grantee_totals)) {
                                    foreach ($payment_row->grantee_totals as $total_index => $grantee_total) {
                                        array_push($nominal_values, $grantee_total['nominal']);
                                        $nominal_list_html .= '<li>'.format_money($grantee_total['nominal'], 'USD').'</li>';
                                    }
                                }
                                $nominal_list_html .= '</ul>';
                                
                                $nominal_list_html_idr = '';
                                $nominal_list_html_idr .= '<ul style="margin:0px; padding:0px; list-style:none;">';
                                if (!empty($payment_row->grantee_totals)) {
                                    foreach ($payment_row->grantee_totals as $total_index => $grantee_total) {
                                        array_push($nominal_values_idr, $grantee_total['nominal_idr']);
                                        $nominal_list_html_idr .= '<li>'.format_money($grantee_total['nominal_idr'], 'IDR').'</li>';
                                    }
                                }
                                $nominal_list_html_idr .= '</ul>';
                                if (isset($payment_row->sub_category_name) && ($payment_row->sub_category_name == '1st Payment/Disbursement' || $payment_row->sub_category_name == 'Final Payment')) {
                                    $payment_status = '';
                                    $payment_status .= '<ul style="margin:0px; padding:0px; list-style:none;">';
                                    if (!empty($payment_row->grantee_totals)) {
                                        foreach ($payment_row->grantee_totals as $total_index => $grantee_total) {
                                            $payment_status .= '<li>'.$grantee_total['status_name'].'</li>';
                                        }
                                    }
                                    $payment_status .= '</ul>';
                                } else {
                                    $payment_status = isset($payment_row->status_name) ? $payment_row->status_name : '';
                                }
                                $pay_period = !empty($payment_row->from_date) ? date('d-M-Y', strtotime($payment_row->from_date)) : '';
                                if (!empty($payment_row->to_date)) $pay_period .= ($pay_period ? ' - ' : '') . date('d-M-Y', strtotime($payment_row->to_date));
                            ?>
                            <tr>
                                <td><?= $row_number ?></td>
                                <td><?= html_escape($grant_label) ?></td>
                                <td><?= isset($payment_row->sub_category_name) ? $payment_row->sub_category_name : '' ?></td>
                                <td><?= $pay_period ? $pay_period : '-' ?></td>
                                <td style="white-space:nowrap;"><?= $name_list_html ?></td>
                                <td>
                                    <?= $nominal_list_html_idr ?>
                                    <b><u><?= format_money(array_sum($nominal_values_idr), 'IDR')?></u></b>
                                </td>
                                <td>
                                    <?= $nominal_list_html ?>
                                    <b><u><?= format_money(array_sum($nominal_values), 'USD')?></u></b>
                                </td>
                                <td><?= $payment_status ?></td>
                                <td class="text-center">
                                    <a href="#" data-toggle="modal" data-target="#mdl_bulk_grantee" data-mode="view" data-record_id="<?= $payment_row->id ?>" data-grant-id="<?= html_escape($row_grant_id) ?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    <?php if (has_permission('payments', 'update')) { ?>
                                    <a href="#" data-toggle="modal" data-target="#mdl_bulk_grantee" data-mode="edit" data-record_id="<?= $payment_row->id ?>" data-grant-id="<?= html_escape($row_grant_id) ?>" class="btn btn-primary btn-xs <?php echo $disable_edit; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <?php } ?>
                                    <?php if (has_permission('payments', 'delete')) { ?>
                                    <a href="<?= site_url('admin/request_payment/delete_bulk_cost/'.$payment_row->id.'?from_finance=1') ?>" class="btn btn-danger btn-xs mb-2 confirm-del">
                                        <i class="fa fa-times-circle"></i> Delete
                                    </a>
                                    <?php } ?>
                                    <?php if (has_permission('payments', 'update')) { ?>
                                    <a href="<?= site_url('admin/request_payment/cancel_bulk_cost/'.$payment_row->id.'?from_finance=1') ?>" class="btn btn-danger btn-xs mb-2" onclick="return confirm('Are you sure want to Cancel this payment ?')">
                                        Cancel
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
                    Showing <?php echo isset($payment['paging']['start_row']) ? $payment['paging']['start_row'] : 0 ?> to <?php echo isset($payment['paging']['end_row']) ? $payment['paging']['end_row'] : 0 ?> of <?php echo isset($payment['paging']['total_rows']) ? $payment['paging']['total_rows'] : 0 ?> entries
                </div>
                <?php echo isset($payment['paging']['html']) ? $payment['paging']['html'] : '' ?>
                <input type="hidden" form="filter_payment_grantee" name="sort_by" value="<?php echo $sort_field ?>">
                <input type="hidden" form="filter_payment_grantee" name="sort" value="<?php echo $sort_order ?>">
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="delete_detail_payment" name="delete_detail_payment">
<input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
<input type="hidden" name="total_grant" value="<?= html_escape($total_grant_value) ?>">
<input type="hidden" name="grantee_id" id="grantee_id" value="<?= html_escape($grantee_id_value) ?>">
</form>
