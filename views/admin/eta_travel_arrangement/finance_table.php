<?php
if (!function_exists('eta_finance_section_paging_bar')) {
    function eta_finance_section_paging_bar(array $sp)
    {
        ?>
        <div class="eta-finance-paging" style="display:flex; justify-content:space-between; align-items:center; padding:10px 4px; flex-wrap:wrap; gap:10px;">
            <div style="font-size:12px; color:#64748b;">
                Showing <?php echo (int) $sp['start_row']; ?> to <?php echo (int) $sp['end_row']; ?> of <?php echo (int) $sp['total_rows']; ?> entries
            </div>
            <div style="clear:both;"><?php echo $sp['html']; ?></div>
        </div>
        <?php
    }
}
$format_date = static function ($value) {
    if (empty($value)) return '-';
    $ts = strtotime($value);
    if ($ts === false) return $value;
    return date('d M Y', $ts);
};
$format_currency = static function ($value, $currency = 'USD') {
    if ($value === null || $value === '' || !is_numeric($value)) return '-';
    $amt = (float) $value;
    if ($currency === 'IDR') return 'Rp. ' . number_format($amt, 0, '.', ',');
    if ($currency === 'USD') return '$' . number_format($amt, 2, '.', ',');
    return number_format($amt, 2, '.', ',') . ' ' . $currency;
};
$render_file_link = static function ($path, $label, $lightbox = false) {
    if (empty($path)) return '<span class="text-muted small">No file</span>';
    $cls = $lightbox ? 'btn btn-sm btn-primary lightbox' : 'btn btn-sm btn-primary';
    return '<a class="' . $cls . '" href="' . base_url($path) . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a>';
};
$format_period = static function (array $row) {
    $pn = isset($row['period_name']) ? trim((string)$row['period_name']) : '';
    $fy = isset($row['period_fiscal_year']) ? trim((string)$row['period_fiscal_year']) : '';
    $pid = isset($row['period_id']) ? (int)$row['period_id'] : 0;
    if ($pn !== '') return $pn;
    if ($fy !== '') return $fy;
    if ($pid>0) return $pid;
    return '-';
};
$format_category = static function(array $row){
    $cn = trim((string)($row['category_name'] ?? ''));
    $ft = trim((string)($row['flight_type'] ?? ''));
    if($cn!=='' && $ft!=='') return $cn.' - '.$ft;
    if($cn!=='') return $cn;
    if($ft!=='') return $ft;
    return '-';
};
?>

<?php if ($active_tab === 'accommodation'): ?>
<table class="data-table">
    <thead>
        <tr>
            <th style="width:80px;">Period</th>
            <th>Grantee Name</th>
            <th>Category</th>
            <th style="width:120px;">Check-in Date</th>
            <th style="width:120px;">Checkout Date</th>
            <th style="width:160px;">Proposed Accommodation</th>
            <th style="width:130px;">Approval Status</th>
            <th style="width:90px; text-align:center;">Detail</th>
            <th style="width:120px; text-align:center;">Invoice</th>
            <th style="width:130px; text-align:center;">Proof</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($finance_rows)): ?>
            <?php foreach ($finance_rows as $row): $travel_id=(int)($row['id']??0); ?>
            <tr>
                <td><?php echo htmlspecialchars($format_period($row), ENT_QUOTES,'UTF-8'); ?></td>
                <td><strong><?php echo htmlspecialchars(get_full_name($row,'US'), ENT_QUOTES,'UTF-8'); ?></strong></td>
                <td><?php echo htmlspecialchars($format_category($row), ENT_QUOTES,'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($format_date($row['checkin_date']??''), ENT_QUOTES,'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($format_date($row['checkout_date']??''), ENT_QUOTES,'UTF-8'); ?></td>
                <td><?php echo $render_file_link($row['accommodation_proposed_file']??'','View File'); ?></td>
                <td><?php echo htmlspecialchars($row['accommodation_approval_status']??'-', ENT_QUOTES,'UTF-8'); ?></td>
                <td style="text-align:center;">
                    <button type="button" class="btn-action-uniform btn-action-blue js-finance-detail" data-travel-id="<?php echo $travel_id; ?>" data-tab="accommodation" data-invoice-field="accommodation_invoice_file" data-proof-field="accommodation_proof_of_payment_file">Detail</button>
                </td>
                <td style="text-align:center;"><?php echo $render_file_link($row['accommodation_invoice_file']??'','View'); ?></td>
                <td style="text-align:center;"><?php echo $render_file_link($row['accommodation_proof_of_payment_file']??'','View'); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="10" style="text-align:center; color:#94a3b8; padding:20px; font-style:italic;">No records found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php if (!empty($section_paging) && is_array($section_paging)) eta_finance_section_paging_bar($section_paging); ?>
<?php else: ?>
<?php
$is_international = $active_tab === 'international';
$invoice_field = $is_international ? 'invoice_file' : 'domestic_invoice_file';
$proof_field = $is_international ? 'proof_of_payment_file' : 'domestic_proof_of_payment_file';
$hide_return = false;
if (isset($section) && is_object($section) && isset($section->flight_type) && trim((string)$section->flight_type) === 'One Way') $hide_return = true;
elseif (isset($section) && is_array($section) && isset($section['flight_type']) && trim((string)$section['flight_type']) === 'One Way') $hide_return = true;
?>
<table class="data-table">
    <thead>
        <tr>
            <th style="width:80px;">Period</th>
            <th>Grantee Name</th>
            <th style="width:100px; text-align:center;">Passport</th>
            <th style="width:130px;">Departure Date</th>
            <?php if (!$hide_return): ?><th style="width:130px;">Return Date</th><?php endif; ?>
            <th style="width:120px;">Final Rate</th>
            <th style="width:130px;">Status</th>
            <th style="width:100px; text-align:center;">Detail</th>
            <th style="width:130px; text-align:center;">Payment</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($finance_rows)): ?>
            <?php foreach ($finance_rows as $row): ?>
                <?php $travel_id=(int)($row['id']??0); $passport_path=!empty($row['passport_file'])?$row['passport_file']:($row['img_passport']??''); ?>
                <?php $selected_first_flight = (!empty($selected_flights[$travel_id]) ? $selected_flights[$travel_id][0] : null); $final_rate_currency = ($selected_first_flight && !empty($selected_first_flight['currency'])) ? $selected_first_flight['currency'] : ($row['grantee_currency'] ?? 'USD'); ?>
                <tr>
                    <td><?php echo htmlspecialchars($format_period($row), ENT_QUOTES,'UTF-8'); ?></td>
                    <td><strong><?php echo htmlspecialchars(get_full_name($row,'US'), ENT_QUOTES,'UTF-8'); ?></strong></td>
                    <td style="text-align:center;"><?php echo $render_file_link($passport_path,'View',true); ?></td>
                    <td><?php echo htmlspecialchars($format_date($row['departure_date']??''), ENT_QUOTES,'UTF-8'); ?></td>
                    <?php if (!$hide_return): ?><td><?php echo htmlspecialchars($format_date($row['returning_date']??''), ENT_QUOTES,'UTF-8'); ?></td><?php endif; ?>
                    <td><strong><?php echo htmlspecialchars($format_currency($row['final_rate']??null,$final_rate_currency), ENT_QUOTES,'UTF-8'); ?></strong></td>
                    <td><span class="status-badge-sent"><?php echo htmlspecialchars(eta_travel_status_label($row['status']??null, $active_tab), ENT_QUOTES,'UTF-8'); ?></span></td>
                    <td style="text-align:center;">
                        <button type="button" class="btn-action-uniform btn-action-blue js-finance-detail" data-travel-id="<?php echo $travel_id; ?>" data-tab="<?php echo htmlspecialchars($active_tab,ENT_QUOTES,'UTF-8'); ?>" data-invoice-field="<?php echo htmlspecialchars($invoice_field,ENT_QUOTES,'UTF-8'); ?>" data-proof-field="<?php echo htmlspecialchars($proof_field,ENT_QUOTES,'UTF-8'); ?>">View</button>
                    </td>
                    <td style="text-align:center;">
                        <?php
                            $user_id_value='';
                            if(!empty($row['user_grantee_id'])) $user_id_value=$row['user_grantee_id'];
                            elseif(!empty($row['grantee_grant_id'])){ $gg=get_row_db('am_grantee_grant',['id'=>(int)$row['grantee_grant_id']]); if($gg&&isset($gg->user_grantee_id)) $user_id_value=$gg->user_grantee_id; }
                            $payment_href=base_url('admin/request_payment/edit/'.$user_id_value.'/'.(isset($row['grantee_grant_id'])?$row['grantee_grant_id']:'').'?pid=travel&payment_id='.(isset($row['payment_record_id'])?$row['payment_record_id']:''));
                        ?>
                        <?php if(!empty($row['payment_record_id'])): ?>
                            <a class="btn-action-uniform btn-action-blue" style="background:#16a34a;" target="_blank" href="<?php echo htmlspecialchars($payment_href,ENT_QUOTES,'UTF-8'); ?>">View Payment</a>
                        <?php else: ?>
                            <button type="button" class="btn-action-uniform btn-action-payment js-finance-add-payment" data-user-id="<?php echo htmlspecialchars($user_id_value,ENT_QUOTES,'UTF-8'); ?>" data-grantee-grant-id="<?php echo htmlspecialchars($row['grantee_grant_id'],ENT_QUOTES,'UTF-8'); ?>" data-travel-id="<?php echo $travel_id; ?>">Add Payment</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="<?php echo $hide_return ? 8 : 9; ?>" style="text-align:center; color:#94a3b8; padding:20px; font-style:italic;">No records found for this section.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php if (!empty($section_paging) && is_array($section_paging)) eta_finance_section_paging_bar($section_paging); ?>
<?php endif; ?>
