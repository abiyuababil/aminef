<?php
$query_base = $this->input->get();
unset($query_base['page']);
foreach (array_keys($query_base) as $tmp_key) {
    if (strpos((string) $tmp_key, 'page_') === 0) unset($query_base[$tmp_key]);
}
$search_value = '';
if (isset($paging['search'])) {
    $search_value = trim((string) $paging['search']);
} elseif (isset($search)) {
    $search_value = trim((string) $search);
}
$sections = isset($sections) ? $sections : [];
$grouped_rows = isset($grouped_rows) ? $grouped_rows : [];
$section_counts = isset($section_counts) ? $section_counts : [];
$section_ids = isset($section_ids) ? $section_ids : [];
$section_paging = isset($section_paging) ? $section_paging : [];
$limit_options = isset($limit_options) ? $limit_options : [10,25,50,100];
?>
<style>
    .eta-finance-page { color:inherit; }
    .eta-finance-page .page-title { font-size:24px; font-weight:600; color:#1e293b; margin-bottom:20px; }
    .eta-finance-page .filter-toolbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:16px; background:#fff; border:1px solid #e2e8f0; border-radius:6px; padding:12px 16px; }
    .eta-finance-page .filter-left { display:flex; align-items:center; gap:16px; font-size:13px; flex-wrap:wrap; }
    .eta-finance-page .form-select, .eta-finance-page .form-input { padding:6px 10px; border:1px solid #cbd5e1; border-radius:4px; font-size:13px; background:#fff; outline:none; }
    .eta-finance-page .form-select:focus, .eta-finance-page .form-input:focus { border-color:#0284c7; }
    .eta-finance-page .search-group { display:flex; gap:6px; }
    .eta-finance-page .btn-search { background:#0284c7; color:#fff; border:none; padding:6px 14px; border-radius:4px; font-size:13px; font-weight:600; cursor:pointer; }
    .eta-finance-page .btn-search:hover { background:#0369a1; }
    .eta-finance-page .accordion-wrapper { display:flex; flex-direction:column; gap:16px; }
    .eta-finance-page .accordion-item { background:#fff; border:1px solid #dcdfe6; border-radius:6px; box-shadow:0 1px 3px rgba(0,0,0,.02); overflow:hidden; }
    .eta-finance-page .accordion-header { background:#f8fafc; padding:14px 20px; display:flex; justify-content:space-between; align-items:center; cursor:pointer; user-select:none; border-bottom:1px solid transparent; }
    .eta-finance-page .accordion-item.active .accordion-header { border-bottom-color:#e2e8f0; background:#f1f5f9; }
    .eta-finance-page .accordion-title-group { display:flex; align-items:center; gap:12px; }
    .eta-finance-page .accordion-title { font-size:15px; font-weight:700; color:#1e293b; }
    .eta-finance-page .badge-counter { font-size:11px; background:#e0f2fe; color:#0369a1; padding:2px 8px; border-radius:12px; font-weight:700; }
    .eta-finance-page .accordion-actions { display:flex; align-items:center; gap:10px; }
    .eta-finance-page .btn-download-approval { background:#16a34a; color:#fff; border:none; padding:6px 14px; border-radius:4px; font-size:12px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:6px; }
    .eta-finance-page .btn-download-approval:hover { background:#15803d; }
    .eta-finance-page .btn-download-approval:disabled { opacity:.5; cursor:not-allowed; }
    .eta-finance-page .accordion-chevron { width:16px; height:16px; transition:transform .25s; color:#64748b; }
    .eta-finance-page .accordion-item.active .accordion-chevron { transform:rotate(180deg); }
    .eta-finance-page .accordion-content { display:none; padding:16px; overflow-x:auto; }
    .eta-finance-page .accordion-item.active .accordion-content { display:block; }
    .eta-finance-page .data-table { width:100%; border-collapse:collapse; font-size:13px; text-align:left; }
    .eta-finance-page .data-table th { background:#f8fafc; color:#475569; font-weight:600; padding:10px 12px; border-bottom:2px solid #e2e8f0; white-space:nowrap; }
    .eta-finance-page .data-table td { padding:12px; border-bottom:1px solid #e2e8f0; vertical-align:middle; }
    .eta-finance-page .data-table tr:hover { background:#f8fafc; }
    .eta-finance-page .status-badge-sent { background:#dcfce7; color:#15803d; padding:4px 8px; border-radius:4px; font-weight:700; font-size:11px; display:inline-block; white-space:nowrap; }
    .eta-finance-page .btn-action-uniform { display:inline-flex; align-items:center; justify-content:center; min-width:85px; height:30px; padding:0 10px; border:none; border-radius:4px; font-size:12px; font-weight:600; cursor:pointer; transition:all .15s; white-space:nowrap; text-decoration:none; }
    .eta-finance-page .btn-action-blue { background:#337ab7; color:#fff; }
    .eta-finance-page .btn-action-blue:hover { background:#286090; color:#fff; }
    .eta-finance-page .btn-action-payment { background:#2b72a4; color:#fff; min-width:105px; }
    .eta-finance-page .btn-action-payment:hover { background:#1e557b; color:#fff; }
    .eta-finance-page .btn-action-neutral { background:#fff; border:1px solid #cbd5e1; color:#334155; min-width:80px; height:26px; }
    .eta-finance-page .btn-action-neutral:hover { background:#f1f5f9; }
    .eta-finance-page .finance-file-actions{ display:inline-flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .eta-finance-page .modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,.6); z-index:2000; justify-content:center; align-items:center; padding:24px; }
    .eta-finance-page .modal-card { background:#fff; border-radius:8px; width:100%; max-width:880px; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 20px 25px -5px rgba(0,0,0,.2); overflow:hidden; }
    .eta-finance-page .modal-header { padding:16px 24px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; background:#f8fafc; }
    .eta-finance-page .modal-header h3 { font-size:17px; font-weight:700; color:#0f172a; margin:0; }
    .eta-finance-page .close-btn { background:none; border:none; font-size:22px; cursor:pointer; color:#64748b; }
    .eta-finance-page .modal-body { padding:24px; overflow-y:auto; display:flex; flex-direction:column; gap:20px; }
    .eta-finance-page .detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    @media(max-width:768px){ .eta-finance-page .detail-grid{ grid-template-columns:1fr; } }
    .eta-finance-page .detail-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:16px; }
    .eta-finance-page .detail-box-title { font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#0284c7; margin-bottom:10px; padding-bottom:6px; border-bottom:1px solid #e2e8f0; }
    .eta-finance-page .detail-row { display:flex; justify-content:space-between; align-items:center; padding:6px 0; font-size:13px; border-bottom:1px dashed #f1f5f9; }
    .eta-finance-page .detail-row-stacked { flex-direction:column; align-items:flex-start; gap:8px; }
    .eta-finance-page .ticket-list { margin:0; padding-left:18px; display:flex; flex-direction:column; gap:4px; }
    .eta-finance-page .ticket-link { color:#0284c7; font-size:13px; font-weight:500; word-break:break-all; text-decoration:none; }
    .eta-finance-page .ticket-link:hover { text-decoration:underline; }
    .eta-finance-page .detail-row:last-child{ border-bottom:none; }
    .eta-finance-page .detail-label{ font-weight:600; color:#64748b; }
    .eta-finance-page .detail-val{ font-weight:600; color:#0f172a; text-align:right; max-width:60%; word-break:break-word; }
    .eta-finance-page .flight-text-container{ border:1px solid #cbd5e1; border-radius:6px; overflow:hidden; background:#fff; }
    .eta-finance-page .flight-text-header{ background:#f1f5f9; padding:8px 14px; font-size:12px; font-weight:700; color:#334155; border-bottom:1px solid #cbd5e1; text-transform:uppercase; letter-spacing:.5px; }
    .eta-finance-page .flight-text-content{ padding:14px; font-family:inherit; font-size:12.5px; line-height:1.6; color:#1e293b; background:#fafbfc; white-space:pre-wrap; word-break:break-word; margin:0; max-height:220px; overflow:auto; }
    .eta-finance-page .note-callout{ background:#fffbeb; border-left:4px solid #f59e0b; padding:10px 14px; font-size:12.5px; color:#92400e; border-radius:0 4px 4px 0; }
    .eta-finance-page .meta-info-bar{ display:flex; justify-content:space-between; align-items:center; font-size:12px; color:#64748b; padding:0 4px; flex-wrap:wrap; gap:8px; }
    .eta-finance-page .modal-footer{ padding:14px 24px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; }
    .eta-finance-page .btn-modal-close{ background:#fff; border:1px solid #cbd5e1; padding:7px 18px; border-radius:4px; font-size:13px; font-weight:600; cursor:pointer; }
</style>

<div class="container-fluid eta-finance-page">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $page_title; ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form id="frm_manage" method="GET">
                <div id="wrap-filter" class="data-header clearfix form-inline">
                    <div class="pull-left">
                        Show :
                        <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                            <?php foreach ($limit_options as $limit_option): ?>
                                <option value="<?php echo (int) $limit_option; ?>" <?php echo (int) $limit_option === (int) $paging['limit'] ? 'selected' : ''; ?>><?php echo (int) $limit_option; ?></option>
                            <?php endforeach; ?>
                        </select>
                        entries &nbsp;&nbsp;&nbsp;&nbsp;
                        Period
                        <select class="form-control input-sm" name="period" onchange="document.forms.frm_manage.submit()">
                            <option value="0" <?php echo empty($period_id) || $period_id === 0 ? 'selected' : ''; ?>>-- Select Period --</option>
                            <?php foreach ($periods as $period): ?>
                                <?php if (empty($period->fiscal_year) && empty($period->period_name)) continue; ?>
                                <option value="<?php echo (int) $period->id; ?>" <?php echo (int) $period->id === (int) $period_id ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars((string) ($period->fiscal_year ?? $period->period_name ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="pull-right">
                        <input type="search" class="form-control input-sm" name="search" value="<?php echo htmlspecialchars((string) $search_value, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Search name, category, type, agent">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                        <?php if ($search_value !== ''): ?>
                            <a href="<?php echo site_url('admin/finance_eta_travel_arrangement?program=' . (int) $program_id . '&period=' . (int) $period_id . '&tab=' . urlencode($active_tab)); ?>" class="btn btn-danger btn-sm">Reset</a>
                        <?php endif; ?>
                    </div>
                </div>
                <input type="hidden" name="program" value="<?php echo (int) $program_id; ?>">
                <input type="hidden" name="tab" value="<?php echo htmlspecialchars((string) $active_tab, ENT_QUOTES, 'UTF-8'); ?>">
            </form>
        </div>
    </div>

    <div class="tabs-header">
        <?php foreach ($tab_options as $tab_key => $tab_label): ?>
            <?php $tab_query = $query_base; $tab_query['tab'] = $tab_key; ?>
            <a class="tab-btn <?php echo $active_tab === $tab_key ? 'active' : ''; ?>" href="<?php echo current_url() . '?' . http_build_query($tab_query); ?>"><?php echo htmlspecialchars((string) $tab_label, ENT_QUOTES, 'UTF-8'); ?></a>
        <?php endforeach; ?>
    </div>

    <div class="accordion-wrapper">
        <?php if (!empty($sections)): ?>
            <?php
                $has_visible_section = false;
                foreach ($sections as $section):
                    $sid = (int) $section->id;
                    $rows = isset($grouped_rows[$sid]) ? $grouped_rows[$sid] : [];
                    $cnt = count($rows);
                    if ($cnt === 0) continue;
                    $has_visible_section = true;
                    $cat_name = trim((string) ($section->category_name ?? ''));
                    $flight_type = trim((string) ($section->flight_type ?? ''));
                    $title = $cat_name;
                    if ($cat_name !== '' && $flight_type !== '') $title = $cat_name . ' - ' . $flight_type;
                    elseif ($flight_type !== '') $title = $flight_type;
                    elseif ($title === '') $title = 'Section #' . $sid;
                    $ids = isset($section_ids[$sid]) ? $section_ids[$sid] : array_map(function($r){ return (int)($r['id'] ?? 0); }, $rows);
                    $ids_str = implode(',', array_filter($ids));
                    $total_cnt = isset($section_counts[$sid]) ? (int) $section_counts[$sid] : $cnt;
                ?>
                <div class="accordion-item active" id="acc-<?php echo $sid; ?>">
                    <div class="accordion-header" onclick="toggleAccordion('acc-<?php echo $sid; ?>')">
                        <div class="accordion-title-group">
                            <span class="accordion-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="badge-counter"><?php echo $total_cnt; ?> Grantee<?php echo $total_cnt===1?'':'s'; ?></span>
                        </div>
                        <div class="accordion-actions" onclick="event.stopPropagation()">
                            <button type="button" class="btn-download-approval" onclick="downloadBatchApproval(<?php echo $sid; ?>, '<?php echo htmlspecialchars($ids_str, ENT_QUOTES, 'UTF-8'); ?>')">
                                Download Approval
                            </button>
                            <svg class="accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                    </div>
                    <div class="accordion-content">
                        <?php $this->load->view('admin/eta_travel_arrangement/finance_table', [
                            'active_tab' => $active_tab,
                            'finance_rows' => $rows,
                            'flight_counts' => $flight_counts,
                            'selected_flights' => $selected_flights,
                            'paging' => $paging,
                            'section' => $section,
                            'section_paging' => isset($section_paging[$sid]) ? $section_paging[$sid] : null,
                        ]); ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (!$has_visible_section): ?>
                <div class="accordion-item active">
                    <div class="accordion-content" style="display:block; text-align:center; color:#94a3b8; padding:30px;">
                        No finance data found for the selected period.
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php if (!empty($finance_rows)): ?>
                <?php
                    $fallback_groups = [];
                    foreach ($finance_rows as $r) {
                        $key = trim((string)($r['category_name'] ?? '')) . '|' . trim((string)($r['flight_type'] ?? ''));
                        if (!isset($fallback_groups[$key])) $fallback_groups[$key]=[];
                        $fallback_groups[$key][]=$r;
                    }
                    $idx=0;
                ?>
                <?php foreach ($fallback_groups as $key=>$rows): $idx++; list($cat,$ft)=explode('|',$key); $title=$cat; if($cat&&$ft) $title=$cat.' - '.$ft; elseif($ft) $title=$ft; elseif(!$title) $title='Section'; $cnt=count($rows); $ids_str=implode(',', array_map(function($r){return (int)$r['id'];},$rows)); $fb_total_cnt = $cnt; ?>
                <div class="accordion-item active" id="acc-fb-<?php echo $idx; ?>">
                    <div class="accordion-header" onclick="toggleAccordion('acc-fb-<?php echo $idx; ?>')">
                        <div class="accordion-title-group">
                            <span class="accordion-title"><?php echo htmlspecialchars($title, ENT_QUOTES,'UTF-8'); ?></span>
                            <span class="badge-counter"><?php echo $fb_total_cnt; ?> Grantee<?php echo $fb_total_cnt===1?'':'s'; ?></span>
                        </div>
                        <div class="accordion-actions" onclick="event.stopPropagation()">
                            <svg class="accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                    </div>
                    <div class="accordion-content">
                        <?php $this->load->view('admin/eta_travel_arrangement/finance_table', [
                            'active_tab' => $active_tab,
                            'finance_rows' => $rows,
                            'flight_counts' => $flight_counts,
                            'selected_flights' => $selected_flights,
                            'paging' => $paging,
                            'section' => null,
                            'section_paging' => null,
                        ]); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="accordion-item active">
                    <div class="accordion-content" style="display:block; text-align:center; color:#94a3b8; padding:30px;">
                        No finance data found for the selected period.
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<div class="eta-finance-page">
<div class="modal-overlay" id="detailModal">
    <div class="modal-card">
        <div class="modal-header">
            <div>
                <h3>Travel Arrangement Detail</h3>
                <span style="font-size:12px; color:#64748b;">Grantee: <strong id="modalGranteeHeading">—</strong> &bull; ETA (<span id="modalPeriodHeading">—</span>)</span>
            </div>
            <button type="button" class="close-btn" onclick="closeDetailModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-grid">
                <div class="detail-box">
                    <div class="detail-box-title">Trip Information</div>
                    <div class="detail-row"><span class="detail-label">Status</span><span class="status-badge-sent" id="modalStatusBadge">Ticket Sent</span></div>
                    <div class="detail-row"><span class="detail-label">Origin (US)</span><span class="detail-val" id="modalOrigin">—</span></div>
                    <div class="detail-row"><span class="detail-label">Destination (ID)</span><span class="detail-val" id="modalDestination">—</span></div>
                    <div class="detail-row"><span class="detail-label">Departure Date</span><span class="detail-val" id="modalDepDate">—</span></div>
                    <div class="detail-row" id="modalRetDateRow"><span class="detail-label">Return Date</span><span class="detail-val" id="modalRetDate">—</span></div>
                    <div class="detail-row"><span class="detail-label">Passport</span><span id="modalPassportCell">—</span></div>
                </div>
                <div class="detail-box">
                    <div class="detail-box-title">Finance & Documents</div>
                    <div class="detail-row"><span class="detail-label">Travel Agent</span><span class="detail-val" id="modalAgent">—</span></div>
                    <div class="detail-row"><span class="detail-label">Proposed Rate</span><span class="detail-val" id="modalProposedRate">—</span></div>
                    <div class="detail-row"><span class="detail-label">Final Rate</span><span class="detail-val" id="modalFinalRate" style="color:#0284c7; font-size:14px;">—</span></div>
                    <div class="detail-row" id="modalTicketRow"><span class="detail-label">E-Ticket</span><span id="modalTicketCell">—</span></div>
                    <div class="detail-row"><span class="detail-label">Invoice</span><span id="modalInvoiceCell">—</span></div>
                    <div class="detail-row"><span class="detail-label">Proof of Payment</span><span id="modalProofCell">—</span></div>
                    <div class="detail-row"><span class="detail-label">Approval Document</span><span id="modalApprovalCell">—</span></div>
                </div>
            </div>
            <div class="flight-text-container">
                <div class="flight-text-header">Approved Flights</div>
                <pre class="flight-text-content" id="modalApprovedFlightsText">-</pre>
            </div>
            <div class="note-callout"><strong>Note:</strong> <span id="modalNoteText">-</span></div>
            <div class="meta-info-bar">
                <span>Requested By: <strong id="modalRequestedBy">—</strong></span>
                <span>Approved By: <strong id="modalApprovedBy">—</strong></span>
                <span id="modalMemoCell"></span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-modal-close" onclick="closeDetailModal()">Close</button>
        </div>
    </div>
</div>
<input type="file" id="finance_invoice_upload" class="hide" style="display:none;">
<input type="file" id="finance_proof_upload" class="hide" style="display:none;">
</div>
