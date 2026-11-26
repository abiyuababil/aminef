
<?php
// Ambil paging dari data yang di-pass controller
$bulk_paging = isset($payment_non_grantee['paging']) ? $payment_non_grantee['paging'] : [];

// Nilai filter: prioritaskan dari paging (sudah di-proses controller), fallback ke GET
$bulk_search  = isset($bulk_paging['search'])  && $bulk_paging['search']  !== '' ? $bulk_paging['search']  : (isset($_GET['search_non_bulk'])  ? $_GET['search_non_bulk']  : '');
$bulk_status  = isset($bulk_paging['status'])  && $bulk_paging['status']  !== '' ? $bulk_paging['status']  : (isset($_GET['status_non_bulk'])  ? $_GET['status_non_bulk']  : '');
$bulk_year    = isset($bulk_paging['year'])    && $bulk_paging['year']    !== '' ? $bulk_paging['year']    : (isset($_GET['year_non_bulk'])    ? $_GET['year_non_bulk']    : '');
$bulk_limit   = isset($bulk_paging['limit'])                                     ? $bulk_paging['limit']   : (isset($_GET['limit'])            ? $_GET['limit']            : 10);

// Nilai sort: dari variabel yang di-pass controller (sudah diisolasi per-tab)
$sort_by_bulk = isset($sort_by_bulk) ? $sort_by_bulk : '';
$sort_bulk    = isset($sort_bulk)    ? $sort_bulk    : '';
?>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div id="content">
                <div class="panel-body">
                    <div class="data-header clearfix form-inline">
                        <div class="pull-left">
                            Search : <input type="search" class="form-control input-sm" form="frm_bulk_non_grantee_filter" name="search_non_bulk" value="<?= html_escape($bulk_search) ?>" placeholder="" onkeydown="if(event.key === 'Enter'){ event.preventDefault(); document.getElementById('frm_bulk_non_grantee_filter').submit(); }">
                        
                            Status : 
                            <select class="form-control input-sm" name="status_non_bulk" form="frm_bulk_non_grantee_filter" onchange="document.getElementById('frm_bulk_non_grantee_filter').submit()">
                                <option value="">-- Select Status --</option>
                            <?php
                            foreach($record_status as $rs) {
                                $selected = '';
                                if ($rs->id == $bulk_status) $selected = 'selected';
                            ?>
                            <option value="<?php echo $rs->id ?>" <?php echo $selected ?>><?php echo $rs->name ?></option>
                            <?php } ?>
                            </select> 
                        
                            Year : 
                            <select class="form-control input-sm" name="year_non_bulk" form="frm_bulk_non_grantee_filter" onchange="document.getElementById('frm_bulk_non_grantee_filter').submit()">
                                <option value="">-- Select Year --</option>
                                <?php for ($i=date('Y', strtotime('+5 years')); $i > 1900; $i--) : ?>
                                    <?php 
                                        $selected = '';
                                        if ($i == $bulk_year) {
                                            $selected = 'selected';
                                        }    
                                    ?>
                                    <option <?= $selected ?> value="<?= $i; ?>"><?= $i;?></option>
                                <?php endfor; ?>
                            </select> 
                            
                            Show : 
                            <select class="form-control input-sm" name="limit" form="frm_bulk_non_grantee_filter" onchange="document.getElementById('frm_bulk_non_grantee_filter').submit()">
                            <?php
                            foreach($limit['limit_options'] as $lo) {
                                $selected = '';
                                if ($lo == $bulk_limit) $selected = 'selected';
                            ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                            <?php } ?>
                            </select> 
                            entries
                        </div>
                        <div class="pull-right">
                            <a href="#" data-toggle="modal" data-target="#mdl_add_record_bulk" class="btn btn-success btn-sm" id="btn-add-bulk" data-mode="add">
                                ADD NEW
                            </a>
                            <a href="<?= base_url('admin/payment_bulk_non_grantee/add/' . $grant_id) ?>" class="hide btn btn-success btn-sm" id="btn-add-bulk">
                                ADD NEW
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-non-payment-bulk">
                            <thead>
                                <tr>
                                    <th width="35" class="text-center">#</th>
                                    <th>Entry Date</th>
                                    <th>Vendor Name</th>
                                    <th>Beneficiary name</th>
                                    <!-- <th>Description</th> -->
                                    <th>Total Payment (IDR)</th>
                                    <th>Total Payment (USD)</th>
                                    <th>Status</th>
                                    <th data-form="frm_bulk_non_grantee_filter" <?php echo sorting_attribute('created_at', $sort_by_bulk, $sort_bulk) ?>>Created At</th>
                                    <th width="150" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($payment_non_grantee)
                            {
                                $no = $payment_non_grantee['paging']['start_row'];
                                foreach($payment_non_grantee['payment_records'] as $row) {
                                    // echo '<pre>';print_r($row);die;
                                    $join_full_name = '';
                                    $join_full_name .= '<ul style="margin:0px; padding:0px; list-style:none;">';
    
                                    $available_program = [];
                                    foreach ($row->payment_name as $key => $value) {
    
                                        $join_full_name .= '<li>'.$value.'</li>';
                                    }
                                    $join_full_name .= '</ul>';

                                    $join_beneficiary = '';
                                    $join_beneficiary .= '<ul style="margin:0px; padding:0px; list-style:none;">';
    
                                    $available_program = [];
                                    foreach ($row->beneficiary_name_vendor as $key => $value) {
    
                                        $join_beneficiary .= '<li>'.$value.'</li>';
                                    }
                                    $join_beneficiary .= '</ul>';
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                    <td><?= $join_full_name ?></td>
                                    <td><?= $join_beneficiary ?></td>
                                    <!-- <td><?= $row->description ?></td> -->
                                    <td>
                                        <?php 
                                            $total_payment_idr = [];
                                            $nominal_idr = '';
                                            $nominal_idr .= '<ul style="margin:0px; padding:0px; list-style:none;">';
                                            foreach ($row->subtotal_idr as $key => $item) {
                                                array_push($total_payment_idr, $item);
                                                $nominal_idr .= '<li>'.format_money($item, 'IDR').'</li>';
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
                                            foreach ($row->subtotal as $key => $item) {
                                                array_push($total_payment, $item);
                                                $nominal .= '<li>'.format_money($item, 'USD').'</li>';
                                            }
                                            $nominal .= '</ul>';
                                        ?>
                                        <?= $nominal ?>
                                        <b><u><?= format_money(array_sum($total_payment), 'USD')?></u></b>
                                    </td>
                                    <!-- <td>
                                    <?php 
                                        $total_payment_idr = [];
                                        foreach ($row->items as $key => $item) {
                                            array_push($total_payment_idr, $item->nominal_idr);
                                        }
                                    ?>
                                    <?= format_money(array_sum($total_payment_idr), 'IDR')?>
                                    </td>
                                    <td>
                                        <?php 
                                            $total_payment = [];
                                            foreach ($row->items as $key => $item) {
                                                array_push($total_payment, $item->nominal);
                                            }
                                        ?>
                                        <?= format_money(array_sum($total_payment), 'USD')?>
                                    </td> -->
                                    <td><?= $row->status_name ?></td>
                                    <td><?= date('d M Y H:i:s', strtotime($row->insert_date)); ?></td>
                                    <td class="text-center">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record_bulk" data-mode="view" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record_bulk" data-mode="edit" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= site_url('admin/user_grantee_grant/delete_record_bulk/'.$row->id) ?>" class="btn btn-danger btn-xs confirm-del">
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
                        Showing <?php echo $payment_non_grantee['paging']['start_row'] ?> to <?php echo $payment_non_grantee['paging']['end_row'] ?> of <?php echo $payment_non_grantee['paging']['total_rows'] ?> entries
                    </div>
                    <!-- /.pagination info -->
                    <?php echo $payment_non_grantee['paging']['html'] ?>
                    <!-- /.pagination -->
                </div>
                <div class="panel-body">
                    
                <a href="<?= base_url('admin/user_grantee_grant/manage')?>" class="btn btn-info" > Back</a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="delete_detail_payment" name="delete_detail_payment">
    <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
    <input type="hidden" name="total_grant" value="<?= $grantee_setting->total_grant ?>">
    <input type="hidden" name="grantee_id" id="grantee_id" value="<?= $grantee_id ?>">