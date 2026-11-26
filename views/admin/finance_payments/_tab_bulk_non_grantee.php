<?php
// reusable table from shared admin/partials/payment_bulk_non_grantee.php, 7 columns.
$sort_field = isset($sort_by) ? $sort_by : '';
$sort_order = isset($sort) ? $sort : '';
$disable_edit = isset($disabled) ? $disabled : '';
$grant_labels = isset($grant_labels) ? $grant_labels : [];
?>
<form id="frm_bulk_non_grantee" method="GET">
    <input type="hidden" name="fiscal_year" value="<?php echo html_escape($selected_fiscal_year); ?>">
    <input type="hidden" name="program_id" value="<?php echo html_escape($selected_program_id); ?>">
    <input type="hidden" name="tab" value="bulk_non_grantee">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div id="content">
                <div class="panel-body">
                    <div class="data-header clearfix form-inline">
                        <div class="pull-left">
                            Search : <input type="search" class="form-control input-sm" name="search_non_bulk" value="<?= html_escape($this->input->get('search_non_bulk')) ?>" placeholder="Search vendor, beneficiary..." onkeydown="if(event.key === 'Enter'){ event.preventDefault(); document.forms.frm_bulk_non_grantee.submit(); }">
                        </div>
                        <div class="pull-right">
                            <?php if (has_permission('payments', 'create')) { ?>
                            <a href="#" data-toggle="modal" data-target="#mdl_add_record_bulk" class="btn btn-success btn-sm" id="btn-add-bulk" data-mode="add">
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
                        <table class="table table-striped table-hover table-non-payment-bulk">
                            <thead>
                                <tr>
                                    <th width="35" class="text-center">#</th>
                                    <th>Grant</th>
                                    <th data-form="frm_bulk_non_grantee" <?php echo sorting_attribute('payment_date', $sort_by, $sort) ?>>Entry Date</th>
                                    <th>Vendor Name</th>
                                    <th>Description</th>
                                    <th>Total Payment (IDR)</th>
                                    <th>Total Payment (USD)</th>
                                    <th>Proof of Payment</th>
                                    <th width="180" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($payment_non_grantee['payment_records']))
                            {
                                $row_number = isset($payment_non_grantee['paging']['start_row']) ? $payment_non_grantee['paging']['start_row'] : 1;
                                foreach($payment_non_grantee['payment_records'] as $payment_row) {
                                    $row_grant_id = ($this->session->userdata('active_country') == AMERICAN_DATABASE && !empty($payment_row->period_id) && is_numeric($payment_row->period_id)) ? $payment_row->period_id : '';
                                    $grant_label = (!empty($row_grant_id) && isset($grant_labels[$row_grant_id])) ? $grant_labels[$row_grant_id] : '-';
                                    $description = (isset($payment_row->description) && $payment_row->description !== '')
                                        ? $payment_row->description
                                        : (isset($payment_row->payment_name) ? implode(', ', (array) $payment_row->payment_name) : '-');
                                    
                                    $beneficiary_names = isset($payment_row->beneficiary_name_vendor) ? array_filter((array) $payment_row->beneficiary_name_vendor) : [];
                                    $beneficiary_names = array_map(function ($beneficiary_item) { return html_escape($beneficiary_item); }, $beneficiary_names);
                                    $name_display = $beneficiary_names ? implode('<br>', $beneficiary_names) : '-';
                                    $nominal_values = isset($payment_row->subtotal) ? array_map('floatval', (array) $payment_row->subtotal) : [];
                                    $nominal_values_idr = isset($payment_row->subtotal_idr) ? array_map('floatval', (array) $payment_row->subtotal_idr) : [];

                                    $proofs = isset($payment_row->proofs) ? array_filter((array) $payment_row->proofs) : [];
                                    $proofs = array_map(function ($proof_item) { 
                                        $file_url  = base_url($proof_item);
                                        $file_name = basename($proof_item);

                                        return '<a href="' . html_escape($file_url) . '" target="_blank" rel="noopener noreferrer" class="lightbox text-ellipsis">
                                                    ' . html_escape($file_name) . '
                                                </a>';
                                    }, $proofs);
                                    $file_proof = $proofs ? implode('<br>', $proofs) : '-';
                                ?>
                                <tr>
                                    <td><?= $row_number ?></td>
                                    <td><?= html_escape($grant_label) ?></td>
                                    <td><?= !empty($payment_row->payment_date) ? date('d-M-Y H:i:s', strtotime($payment_row->payment_date)) : '-' ?></td>
                                    <td><?= $name_display ?></td>
                                    <td><?= html_escape($description) ?></td>
                                    <td><b><u><?= format_money(array_sum($nominal_values_idr), 'IDR')?></u></b></td>
                                    <td><b><u><?= format_money(array_sum($nominal_values), 'USD')?></u></b></td>
                                    <td><?= $file_proof ?></td>
                                    <!-- <td><?php //isset($payment_row->status_name) ? $payment_row->status_name : '' ?></td> -->
                                    <td class="text-center">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record_bulk" data-mode="view" data-record_id="<?= $payment_row->id ?>" data-grant-id="<?= html_escape($row_grant_id) ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <?php if (has_permission('payments', 'update')) { ?>
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record_bulk" data-mode="edit" data-record_id="<?= $payment_row->id ?>" data-grant-id="<?= html_escape($row_grant_id) ?>" class="btn btn-primary btn-xs <?php echo $disable_edit; ?>">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <?php } ?>
                                        <?php if (has_permission('payments', 'delete')) { ?>
                                        <a href="<?= site_url('admin/user_grantee_grant/delete_record_bulk/'.$payment_row->id.'?from_finance=1') ?>" class="btn btn-danger btn-xs confirm-del">
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
                        Showing <?php echo isset($payment_non_grantee['paging']['start_row']) ? $payment_non_grantee['paging']['start_row'] : 0 ?> to <?php echo isset($payment_non_grantee['paging']['end_row']) ? $payment_non_grantee['paging']['end_row'] : 0 ?> of <?php echo isset($payment_non_grantee['paging']['total_rows']) ? $payment_non_grantee['paging']['total_rows'] : 0 ?> entries
                    </div>
                    <?php echo isset($payment_non_grantee['paging']['html']) ? $payment_non_grantee['paging']['html'] : '' ?>
                    <input type="hidden" name="sort_by" value="<?php echo $sort_field ?>">
                    <input type="hidden" name="sort" value="<?php echo $sort_order ?>">
                </div>
            </div>
        </div>
    </div>
</form>
