<?php
// reusable table from shared payment_record/form.php non_grantee tab, 7 columns.
$sort_field = isset($sort_by) ? $sort_by : '';
$sort_order = isset($sort) ? $sort : '';
$grant_labels = isset($grant_labels) ? $grant_labels : [];
?>
<form id="frm_non_grantee" method="GET">
    <input type="hidden" name="fiscal_year" value="<?php echo html_escape($selected_fiscal_year); ?>">
    <input type="hidden" name="program_id" value="<?php echo html_escape($selected_program_id); ?>">
    <input type="hidden" name="tab" value="non_grantee">
    <input type="hidden" name="sort_by" value="<?php echo html_escape($sort_field); ?>">
    <input type="hidden" name="sort" value="<?php echo html_escape($sort_order); ?>">
</form>
<form id="form_non_grantee" role="form" method="POST" enctype="multipart/form-data">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div id="content">
                <div class="panel-body">
                    <div class="data-header clearfix form-inline">
                        <div class="pull-left">
                            Search : <input type="search" class="form-control input-sm" form="frm_non_grantee" name="search" value="<?= isset($paging['search']) ? html_escape($paging['search']) : '' ?>" placeholder="Search description, vendor..." onkeydown="if(event.key === 'Enter'){ event.preventDefault(); document.forms.frm_non_grantee.submit(); }">
                        </div>
                        <div class="pull-right">
                            <?php if (has_permission('payments', 'create')) { ?>
                            <a href="#" data-toggle="modal" data-target="#mdl_add_record" data-mode="add" class="btn btn-success btn-sm" id="btn-add">
                                ADD NEW
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="35" class="text-center">#</th>
                                    <th>Grant</th>
                                    <th data-form="frm_non_grantee" <?php echo sorting_attribute('payment_date', $sort_by, $sort) ?>>Entry Date</th>
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
                            if (!empty($payment_record))
                            {
                                $row_number = isset($paging['start_row']) ? $paging['start_row'] : 1;
                                foreach($payment_record as $payment_row) {
                                    $row_grant_id = isset($payment_row->grant_id) ? $payment_row->grant_id : '';
                                    $grant_label = (!empty($row_grant_id) && isset($grant_labels[$row_grant_id])) ? $grant_labels[$row_grant_id] : '-';
                                    $vendor_row = get_row_db('am_vendor', ['id' => $payment_row->vendor_id]);
                                    
                                    $vendor_name = $vendor_row
                                        ? (string) $vendor_row->name
                                        : (string) $payment_row->third_party_vendor_name;
                                    $name_display = $vendor_row
                                        ? (string) $vendor_row->beneficiary_name
                                        : (string) $payment_row->third_party_beneficiary_name;
                                    $nominal_values = [];
                                    $nominal_values_idr = [];
                                    if (!empty($payment_row->items)) {
                                        foreach ($payment_row->items as $item_index => $payment_item) {
                                            array_push($nominal_values, $payment_item->nominal);
                                            array_push($nominal_values_idr, $payment_item->nominal_idr);
                                        }
                                    }
                                    $proof = $payment_row->proof ? file_name($payment_row->proof) : '-';
                                ?>
                                <tr>
                                    <td><?= $row_number ?></td>
                                    <td><?= html_escape($grant_label) ?></td>
                                    <td><?= !empty($payment_row->payment_date) ? date('d-M-Y H:i:s', strtotime($payment_row->payment_date)) : '-' ?></td>
                                    <td><?= $name_display ?></td>
                                    <td><?= $payment_row->description ?></td>
                                    <td><?= format_money(array_sum($nominal_values_idr), 'IDR')?></td>
                                    <td><?= format_money(array_sum($nominal_values), 'USD')?></td>
                                    <td>
                                        <?php if($payment_row->proof) : ?>
                                            <a href="<?= base_url($payment_row->proof) ?>" class="lightbox text-ellipsis" title="<?= $proof ?>"><?= $proof ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td><?php //html_escape($name_display) ?></td> -->
                                    <!-- <td><?php //$payment_row->payment_status ?></td> -->
                                    <td class="text-center">
                                        <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-mode="view" data-record_id="<?= $payment_row->id ?>" data-grant-id="<?= html_escape($row_grant_id) ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <?php if (has_permission('payments', 'update')) { ?>
                                        <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-mode="edit" data-record_id="<?= $payment_row->id ?>" data-grant-id="<?= html_escape($row_grant_id) ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <?php } ?>
                                        <?php if (has_permission('payments', 'delete')) { ?>
                                        <a href="<?= site_url('admin/user_grantee_grant/delete_record/'.$payment_row->id.'?from_finance=1') ?>" class="btn btn-danger btn-xs confirm-del">
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
                        Showing <?php echo isset($paging['start_row']) ? $paging['start_row'] : 0 ?> to <?php echo isset($paging['end_row']) ? $paging['end_row'] : 0 ?> of <?php echo isset($paging['total_rows']) ? $paging['total_rows'] : 0 ?> entries
                    </div>
                    <?php echo isset($paging['html']) ? $paging['html'] : '' ?>
                </div>
            </div>
        </div>
    </div>
</form>
