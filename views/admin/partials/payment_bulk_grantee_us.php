<?php
$sort_by_grantee = isset($sort_by_grantee) ? $sort_by_grantee : '';
$sort_grantee    = isset($sort_grantee) ? $sort_grantee : '';
$search_grantee  = isset($payment['paging']['search_bulk_payment']) ? $payment['paging']['search_bulk_payment'] : '';
$limit_grantee   = isset($payment['paging']['limit']) ? $payment['paging']['limit'] : 10;
?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div id="content">
            
            <div class="panel-body">
                <div class="data-header clearfix form-inline">
                    <div class="pull-left">
                        Search : <input type="search" class="form-control input-sm" form="form_filter_payment_grantee" name="search_bulk_payment" value="<?= html_escape($search_grantee) ?>" placeholder="Search" onkeydown="if(event.key === 'Enter'){ event.preventDefault(); document.getElementById('form_filter_payment_grantee').submit(); }" onsearch="if(this.value === ''){ document.getElementById('form_filter_payment_grantee').submit(); }">
                        Show :
                        <select class="form-control input-sm" form="form_filter_payment_grantee" name="limit_payment_grantee_bulk" onchange="document.getElementById('form_filter_payment_grantee').submit()">
                            <?php
                            foreach ($limit['limit_options'] as $lo) {
                                $selected = '';
                                if ($lo == $limit_grantee) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                            <?php } ?>
                        </select>
                        entries
                    </div>
                    <div class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#mdl_bulk_grantee" data-mode="add" class="btn btn-success btn-sm" id="btn-add">
                            ADD NEW
                        </a>
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
                                <th>Sub Category</th>
                                <th data-form="form_filter_payment_grantee" <?php echo sorting_attribute('from_date', $sort_by_grantee, $sort_grantee) ?>>Pay Period Start</th>
                                <th data-form="form_filter_payment_grantee" <?php echo sorting_attribute('to_date', $sort_by_grantee, $sort_grantee) ?>>Pay Period Ends</th>
                                <!-- <th data-form="form_filter_payment_grantee" <?php echo sorting_attribute('payment_date', $sort_by_grantee, $sort_grantee) ?>>Reminder_date</th>
                                <th data-form="form_filter_payment_grantee" <?php echo sorting_attribute('payment_date', $sort_by_grantee, $sort_grantee) ?>>To be Release on</th> -->
                                <th>Status</th>
                                <th>Grantee Name</th>
                                <!-- <th>Description</th> -->
                                <th>Total Payment (IDR)</th>
                                <th>Total Payment (USD)</th>
                                <th data-form="form_filter_payment_grantee" <?php echo sorting_attribute('created_at', $sort_by_grantee, $sort_grantee) ?>>Created At</th>
                                <th width="150" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($payment['payment_records'])
                        {
                            $no = $payment['paging']['start_row'];
                            foreach($payment['payment_records'] as $row) {
                                // echo '<pre>';print_r($row);die;
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
                                <td><?= $row->sub_category_name ?></td>
                                <td><?= $row->from_date ? date('d-M-Y', strtotime($row->from_date)) : '' ?></td>
                                <td><?= $row->to_date ? date('d-M-Y', strtotime($row->to_date)) : '' ?></td>
                                <!-- <td><?= $row->toberelease_date ? date('d-M-Y', strtotime($row->toberelease_date)) : '' ?></td>
                                <td><?= $row->deadline_date ? date('d-M-Y', strtotime($row->deadline_date)) : '' ?></td> -->
                                <td>
                                    <?php 
                                        if($row->sub_category_name == '1st Payment/Disbursement' || $row->sub_category_name == 'Final Payment') {
                                            $status = '';
                                            $status .= '<ul style="margin:0px; padding:0px; list-style:none;">';
                                            foreach ($row->grantee_totals as $key => $item) {
                                                $status .= '<li>'.$item['status_name'].'</li>';
                                            }
                                            $status .= '</ul>';

                                            echo $status;

                                        }else{
                                            echo $row->status_name; 
                                        }
                                    ?>
                                </td>
                                <td style="white-space:nowrap;"><?= $join_full_name ?></td>

                                <td>
                                    <?php 
                                        $total_payment_idr = [];
                                        $nominal_idr = '';
                                        $nominal_idr .= '<ul style="margin:0px; padding:0px; list-style:none;">';
                                        foreach ($row->grantee_totals as $key => $item) {
                                            array_push($total_payment_idr, $item['nominal_idr']);
                                            $nominal_idr .= '<li>'.format_money($item['nominal_idr'], 'IDR').'</li>';
                                        }
                                        $nominal_idr .= '</ul>';
                                    ?>
                                    <?= $nominal_idr ?>
                                    <b><u><?= format_money(array_sum($total_payment_idr), 'IDR')?></u></b>
                                </td>
                                <td>
                                    <?php 
                                        $total_payment = [];
                                        $nominal = '';
                                        $nominal .= '<ul style="margin:0px; padding:0px; list-style:none;">';
                                        foreach ($row->grantee_totals as $key => $item) {
                                            array_push($total_payment, $item['nominal']);
                                            $nominal .= '<li>'.format_money($item['nominal'], 'USD').'</li>';
                                        }
                                        $nominal .= '</ul>';
                                    ?>
                                    <?= $nominal ?>
                                    <b><u><?= format_money(array_sum($total_payment), 'USD')?></u></b>
                                </td>
                                <td><?= !empty($row->insert_date) ? date('d M Y H:i:s', strtotime($row->insert_date)) : '-' ?></td>
                                <td class="text-right">
                                    <a href="#" data-toggle="modal" data-target="#mdl_bulk_grantee" data-mode="view" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    <a href="#" data-toggle="modal" data-target="#mdl_bulk_grantee" data-mode="edit" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs <?php echo $disabled; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= site_url('admin/request_payment/delete_bulk_cost/'.$row->id) ?>" class="btn btn-danger btn-xs mb-2 confirm-del">
                                        <i class="fa fa-times-circle"></i> Delete
                                    </a>
                                    <a href="<?= site_url('admin/request_payment/cancel_bulk_cost/'.$row->id) ?>" class="btn btn-danger btn-xs mb-2" onclick="return confirm('Are you sure want to Cancel this payment ?')">
                                        Cancel
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
                    Showing <?php echo $payment['paging']['start_row'] ?> to <?php echo $payment['paging']['end_row'] ?> of <?php echo $payment['paging']['total_rows'] ?> entries
                </div>
                <!-- /.pagination info -->
                <?php echo $payment['paging']['html'] ?>
                <!-- /.pagination -->
            </div>
        </div>
    </div>
    <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
</div>