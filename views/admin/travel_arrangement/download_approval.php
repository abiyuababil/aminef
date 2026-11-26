<?php
$query_base_non_eta = ['main_tab' => 'non_eta'];
$query_base_eta = ['main_tab' => 'eta'];
$current_main = isset($main_tab) ? $main_tab : 'non_eta';
$search_value = isset($search) ? trim((string) $search) : '';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Download Approval</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs" style="margin-bottom:15px;">
            <li class="<?php echo $current_main === 'non_eta' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/travel_arrangement/download_approval?main_tab=non_eta'); ?>">Non-ETA</a>
            </li>
            <li class="<?php echo $current_main === 'eta' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/travel_arrangement/download_approval?main_tab=eta'); ?>">ETA</a>
            </li>
        </ul>
    </div>
</div>

<?php if ($current_main === 'non_eta'): ?>
<?php
$fiscal_year_val = isset($fiscal_year) ? $fiscal_year : 'All';
$program_val = isset($program_id) ? (int) $program_id : 0;
$limit_val = isset($limit) ? (int) $limit : 10;
$limit_options_local = isset($limit_options) ? $limit_options : [10,25,50,100];
$rows_local = isset($data) ? $data : [];
$paging_local = isset($paging) ? $paging : ['start_row'=>0,'end_row'=>0,'total_rows'=>0,'html'=>'','limit'=>$limit_val];
$programs_local = isset($programs) ? $programs : [];
$fiscal_years_local = isset($fiscal_years) ? $fiscal_years : [];
?>
<div class="row">
    <div class="col-lg-12">
        <form id="frm_download_non_eta" method="GET" action="<?php echo site_url('admin/travel_arrangement/download_approval'); ?>">
            <input type="hidden" name="main_tab" value="non_eta">
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_download_non_eta.submit()">
                        <?php foreach ($limit_options_local as $lo): ?>
                            <option value="<?php echo (int) $lo; ?>" <?php echo (int) $lo === (int) $limit_val ? 'selected' : ''; ?>><?php echo (int) $lo; ?></option>
                        <?php endforeach; ?>
                    </select>
                    entries&nbsp;&nbsp;&nbsp;&nbsp;
                    Fiscal Year
                    <select class="form-control input-sm" name="fiscal_year" id="fiscal_year_select" onchange="handleFiscalChangeDownload(this)">
                        <option value="All" <?php echo $fiscal_year_val === 'All' ? 'selected' : ''; ?>>All</option>
                        <?php foreach ($fiscal_years_local as $fy): ?>
                            <option value="<?php echo htmlspecialchars((string) $fy, ENT_QUOTES, 'UTF-8'); ?>" <?php echo (string) $fy === (string) $fiscal_year_val ? 'selected' : ''; ?>><?php echo htmlspecialchars((string) $fy, ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select>
                    &nbsp;&nbsp;
                    Program
                    <select class="form-control input-sm" name="program" id="program_select" <?php echo $fiscal_year_val === 'All' ? 'disabled' : ''; ?> onchange="document.forms.frm_download_non_eta.submit()">
                        <?php if ($fiscal_year_val === 'All'): ?>
                            <option value="0">Select fiscal year first</option>
                        <?php else: ?>
                            <option value="0" <?php echo $program_val === 0 ? 'selected' : ''; ?>>-- Select Program --</option>
                            <?php foreach ($programs_local as $program): ?>
                                <?php
                                $pfy = trim((string) ($program->fiscal_year ?? ''));
                                if ($pfy !== (string) $fiscal_year_val) continue;
                                $program_display = $program->name ?? '';
                                ?>
                                <option value="<?php echo (int) $program->id; ?>" <?php echo (int) $program->id === (int) $program_val ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars((string) $program_display, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="pull-right">
                    <input type="search" class="form-control input-sm" name="search" value="<?php echo htmlspecialchars($search_value, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Search name, program">
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    <?php if ($search_value !== '' || $program_val !== 0 || $fiscal_year_val !== 'All'): ?>
                        <a href="<?php echo site_url('admin/travel_arrangement/download_approval?main_tab=non_eta'); ?>" class="btn btn-danger btn-sm">Reset</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row" style="margin-top:15px;">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="35" class="text-center">#</th>
                        <th>Periode</th>
                        <th>Program</th>
                        <th>Grantee Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th width="255" class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rows_local)): ?>
                        <?php $no = isset($paging_local['start_row']) ? (int) $paging_local['start_row'] : 1; ?>
                        <?php foreach ($rows_local as $row): ?>
                            <tr>
                                <td class="text-center"><?php echo $no; ?></td>
                                <td><?php echo htmlspecialchars((string) ($row->period_fiscal_year ?? '-'), ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars((string) ($row->program_name ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href="<?php echo site_url('admin/grantee/edit/' . $row->user_grantee_id . '/' . $row->grant_id); ?>" class="text-primary">
                                        <?php echo htmlspecialchars((string) get_full_name($row, 'US'), ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </td>
                                <td><?php echo format_status_travel_arrangement_non_eta($row->status, $row->type); ?></td>
                                <td><?php echo $row->created_at ? date('d M Y', strtotime($row->created_at)) : 'N/A'; ?></td>
                                <td class="text-right" style="white-space:nowrap;">
                                    <?php if ($row->type === 'arranged_by_aminef' && in_array((int) $row->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT], true)): ?>
                                        <a href="<?php echo site_url('admin/travel_arrangement/download_approval/non_eta/' . $row->id); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-success btn-xs">
                                            <i class="fa fa-download"></i> Download Approval
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo site_url('admin/travel_arrangement_non_eta/view/' . $row->id); ?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="clearfix">
            <div class="pull-left">
                <?php if (!empty($paging_local['total_rows'])): ?>
                    Showing <?php echo (int) $paging_local['start_row']; ?> to <?php echo (int) $paging_local['end_row']; ?> of <?php echo number_format((int) $paging_local['total_rows']); ?> entries
                <?php endif; ?>
            </div>
            <div class="pull-right"><?php echo isset($paging_local['html']) ? $paging_local['html'] : ''; ?></div>
        </div>
    </div>
</div>

<?php else: ?>
<?php
// ETA tab variables
$eta_periods = isset($periods) ? $periods : [];
$eta_period_id = isset($period_id) ? (int) $period_id : 0;
$eta_active_tab = isset($active_tab) ? $active_tab : 'international';
$eta_tab_options = isset($tab_options) ? $tab_options : ['international'=>'International Ticket','domestic'=>'Domestic Ticket','accommodation'=>'Accommodation / Venue'];
$eta_sections = isset($sections) ? $sections : [];
$eta_grouped = isset($grouped_rows) ? $grouped_rows : [];
$eta_counts = isset($section_counts) ? $section_counts : [];
$eta_ids = isset($section_ids) ? $section_ids : [];
$eta_paging_map = isset($section_paging) ? $section_paging : [];
$eta_limit = isset($limit) ? (int) $limit : 10;
$eta_limit_options = isset($limit_options) ? $limit_options : [10,25,50,100];
$eta_program_id = isset($program_id) ? (int) $program_id : 0;
$query_base_eta = $_GET;
unset($query_base_eta['page']);
foreach (array_keys($query_base_eta) as $tmp_key) {
    if (strpos((string) $tmp_key, 'page_') === 0) unset($query_base_eta[$tmp_key]);
}
$query_base_eta['main_tab'] = 'eta';
if (!isset($query_base_eta['program'])) $query_base_eta['program'] = $eta_program_id;
?>
<style>
.eta-download-page .accordion-wrapper{display:flex;flex-direction:column;gap:16px;margin-top:15px;}
.eta-download-page .accordion-item{background:#fff;border:1px solid #dcdfe6;border-radius:6px;overflow:hidden;}
.eta-download-page .accordion-header{background:#f8fafc;padding:12px 16px;display:flex;justify-content:space-between;align-items:center;cursor:pointer;}
.eta-download-page .accordion-item.active .accordion-header{background:#f1f5f9;border-bottom:1px solid #e2e8f0;}
.eta-download-page .accordion-title{font-size:14px;font-weight:700;color:#1e293b;}
.eta-download-page .badge-counter{font-size:11px;background:#e0f2fe;color:#0369a1;padding:2px 8px;border-radius:12px;font-weight:700;}
.eta-download-page .btn-download-approval{background:#16a34a;color:#fff;border:none;padding:6px 14px;border-radius:4px;font-size:12px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;text-decoration:none;}
.eta-download-page .btn-download-approval:hover{background:#15803d;color:#fff;}
.eta-download-page .accordion-content{display:none;padding:12px;overflow-x:auto;}
.eta-download-page .accordion-item.active .accordion-content{display:block;}
.eta-download-page .data-table{width:100%;border-collapse:collapse;font-size:13px;}
.eta-download-page .data-table th{background:#f8fafc;color:#475569;font-weight:600;padding:10px 12px;border-bottom:2px solid #e2e8f0;white-space:nowrap;text-align:left;}
.eta-download-page .data-table td{padding:10px 12px;border-bottom:1px solid #e2e8f0;vertical-align:middle;}
.eta-download-page .status-badge-sent{background:#dcfce7;color:#15803d;padding:4px 8px;border-radius:4px;font-weight:700;font-size:11px;display:inline-block;white-space:nowrap;}
.eta-download-page .btn-action-uniform{display:inline-flex;align-items:center;justify-content:center;min-width:85px;height:30px;padding:0 10px;border:none;border-radius:4px;font-size:12px;font-weight:600;cursor:pointer;white-space:nowrap;text-decoration:none;}
.eta-download-page .btn-action-blue{background:#337ab7;color:#fff;}
.eta-download-page .btn-action-blue:hover{background:#286090;color:#fff;}
.eta-download-page .btn-action-payment{background:#2b72a4;color:#fff;min-width:105px;}
.eta-download-page .finance-file-actions{display:inline-flex;align-items:center;gap:8px;flex-wrap:wrap;}
.eta-download-page .modal-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(15,23,42,.6);z-index:2000;justify-content:center;align-items:center;padding:24px;}
.eta-download-page .modal-card{background:#fff;border-radius:8px;width:100%;max-width:880px;max-height:90vh;display:flex;flex-direction:column;box-shadow:0 20px 25px -5px rgba(0,0,0,.2);overflow:hidden;}
.eta-download-page .modal-header{padding:16px 24px;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;background:#f8fafc;}
.eta-download-page .modal-header h3{font-size:17px;font-weight:700;color:#0f172a;margin:0;}
.eta-download-page .close-btn{background:none;border:none;font-size:22px;cursor:pointer;color:#64748b;}
.eta-download-page .modal-body{padding:24px;overflow-y:auto;display:flex;flex-direction:column;gap:20px;}
.eta-download-page .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;}
@media(max-width:768px){.eta-download-page .detail-grid{grid-template-columns:1fr;}}
.eta-download-page .detail-box{background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:16px;}
.eta-download-page .detail-box-title{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#0284c7;margin-bottom:10px;padding-bottom:6px;border-bottom:1px solid #e2e8f0;}
.eta-download-page .detail-row{display:flex;justify-content:space-between;align-items:center;padding:6px 0;font-size:13px;border-bottom:1px dashed #f1f5f9;}
.eta-download-page .detail-row-stacked{flex-direction:column;align-items:flex-start;gap:8px;}
.eta-download-page .ticket-list{margin:0;padding-left:18px;display:flex;flex-direction:column;gap:4px;}
.eta-download-page .ticket-link{color:#0284c7;font-size:13px;font-weight:500;word-break:break-all;text-decoration:none;}
.eta-download-page .ticket-link:hover{text-decoration:underline;}
.eta-download-page .detail-row:last-child{border-bottom:none;}
.eta-download-page .detail-label{font-weight:600;color:#64748b;}
.eta-download-page .detail-val{font-weight:600;color:#0f172a;text-align:right;max-width:60%;word-break:break-word;}
.eta-download-page .flight-text-container{border:1px solid #cbd5e1;border-radius:6px;overflow:hidden;background:#fff;}
.eta-download-page .flight-text-header{background:#f1f5f9;padding:8px 14px;font-size:12px;font-weight:700;color:#334155;border-bottom:1px solid #cbd5e1;text-transform:uppercase;letter-spacing:.5px;}
.eta-download-page .flight-text-content{padding:14px;font-family:inherit;font-size:12.5px;line-height:1.6;color:#1e293b;background:#fafbfc;white-space:pre-wrap;word-break:break-word;margin:0;max-height:220px;overflow:auto;}
.eta-download-page .note-callout{background:#fffbeb;border-left:4px solid #f59e0b;padding:10px 14px;font-size:12.5px;color:#92400e;border-radius:0 4px 4px 0;}
.eta-download-page .meta-info-bar{display:flex;justify-content:space-between;align-items:center;font-size:12px;color:#64748b;padding:0 4px;flex-wrap:wrap;gap:8px;}
.eta-download-page .modal-footer{padding:14px 24px;background:#f8fafc;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;}
.eta-download-page .btn-modal-close{background:#fff;border:1px solid #cbd5e1;padding:7px 18px;border-radius:4px;font-size:13px;font-weight:600;cursor:pointer;}
</style>
<div class="eta-download-page">
<div class="row">
    <div class="col-lg-12">
        <form id="frm_download_eta" method="GET" action="<?php echo site_url('admin/travel_arrangement/download_approval'); ?>">
            <input type="hidden" name="main_tab" value="eta">
            <input type="hidden" name="program" value="<?php echo (int) $eta_program_id; ?>">
            <input type="hidden" name="tab" value="<?php echo htmlspecialchars($eta_active_tab, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_download_eta.submit()">
                        <?php foreach ($eta_limit_options as $lo): ?>
                            <option value="<?php echo (int) $lo; ?>" <?php echo (int) $lo === (int) $eta_limit ? 'selected' : ''; ?>><?php echo (int) $lo; ?></option>
                        <?php endforeach; ?>
                    </select>
                    entries&nbsp;&nbsp;&nbsp;&nbsp;
                    Period
                    <select class="form-control input-sm" name="period" onchange="document.forms.frm_download_eta.submit()">
                        <option value="0" <?php echo empty($eta_period_id) ? 'selected' : ''; ?>>-- Select Period --</option>
                        <?php foreach ($eta_periods as $period): ?>
                            <?php if (empty($period->fiscal_year) && empty($period->period_name)) continue; ?>
                            <option value="<?php echo (int) $period->id; ?>" <?php echo (int) $period->id === (int) $eta_period_id ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars((string) ($period->fiscal_year ?? $period->period_name ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="pull-right">
                    <input type="search" class="form-control input-sm" name="search" value="<?php echo htmlspecialchars($search_value, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Search name, category, type">
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    <?php if ($search_value !== ''): ?>
                        <?php $reset_q = $query_base_eta; $reset_q['search'] = ''; ?>
                        <a href="<?php echo site_url('admin/travel_arrangement/download_approval') . '?' . http_build_query($reset_q); ?>" class="btn btn-danger btn-sm">Reset</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row" style="margin-top:15px;">
    <div class="col-lg-12">
        <ul class="nav nav-pills" style="border-bottom:1px solid #ddd;">
            <?php foreach ($eta_tab_options as $tab_key => $tab_label): ?>
                <?php $tab_q = $query_base_eta; $tab_q['tab'] = $tab_key; ?>
                <li class="<?php echo $eta_active_tab === $tab_key ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('admin/travel_arrangement/download_approval') . '?' . http_build_query($tab_q); ?>"><?php echo htmlspecialchars((string) $tab_label, ENT_QUOTES, 'UTF-8'); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="accordion-wrapper">
<?php if (!empty($eta_sections)): ?>
    <?php $has_visible = false; ?>
    <?php foreach ($eta_sections as $section):
        $sid = (int) $section->id;
        $rows = isset($eta_grouped[$sid]) ? $eta_grouped[$sid] : [];
        if (empty($rows)) continue;
        $has_visible = true;
        $cat_name = trim((string) ($section->category_name ?? ''));
        $flight_type = trim((string) ($section->flight_type ?? ''));
        $title = $cat_name;
        if ($cat_name !== '' && $flight_type !== '') $title = $cat_name . ' - ' . $flight_type;
        elseif ($flight_type !== '') $title = $flight_type;
        elseif ($title === '') $title = 'Section #' . $sid;
        $ids_arr = isset($eta_ids[$sid]) ? $eta_ids[$sid] : array_map(function($r){ return (int)($r['id'] ?? 0); }, $rows);
        $ids_str = implode(',', array_filter($ids_arr));
        $total_cnt = isset($eta_counts[$sid]) ? (int) $eta_counts[$sid] : count($rows);
    ?>
    <div class="accordion-item active" id="acc-<?php echo $sid; ?>">
        <div class="accordion-header" onclick="toggleDownloadAccordion('acc-<?php echo $sid; ?>')">
            <div style="display:flex;align-items:center;gap:12px;">
                <span class="accordion-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></span>
                <span class="badge-counter"><?php echo $total_cnt; ?> Grantee<?php echo $total_cnt===1?'':'s'; ?></span>
            </div>
            <div onclick="event.stopPropagation()" style="display:flex;align-items:center;gap:10px;">
                <a class="btn-download-approval" target="_blank" rel="noopener noreferrer" href="<?php echo site_url('admin/travel_arrangement/download_approval/eta?section_id=' . $sid . '&ids=' . urlencode($ids_str)); ?>">
                    <i class="fa fa-download"></i> Download Approval
                </a>
                <span style="color:#64748b;">&#9650;</span>
            </div>
        </div>
        <div class="accordion-content">
            <?php
            $this->load->view('admin/travel_arrangement/download_approval_table', [
                'active_tab' => $eta_active_tab,
                'finance_rows' => $rows,
                'flight_counts' => isset($flight_counts) ? $flight_counts : [],
                'selected_flights' => isset($selected_flights) ? $selected_flights : [],
                'paging' => ['limit'=>$eta_limit,'search'=>$search_value],
                'section' => $section,
                'section_paging' => isset($eta_paging_map[$sid]) ? $eta_paging_map[$sid] : null,
            ]);
            ?>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (!$has_visible): ?>
        <div class="alert alert-info" style="margin-top:10px;">No finance data found for the selected period.</div>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-info" style="margin-top:10px;">No finance data found for the selected period.</div>
<?php endif; ?>
</div>
</div>

<!-- Detail modal - sama dengan admin/finance_eta_travel_arrangement (international) -->
<div class="eta-download-page">
<div class="modal-overlay" id="detailModal">
    <div class="modal-card">
        <div class="modal-header">
            <div>
                <h3>Travel Arrangement Detail</h3>
                <span style="font-size:12px; color:#64748b;">Grantee: <strong id="modalGranteeHeading">—</strong> &bull; ETA (<span id="modalPeriodHeading">—</span>)</span>
            </div>
            <button type="button" class="close-btn" onclick="closeDownloadDetailModal()">&times;</button>
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
                    <div class="detail-row" id="modalProposedAccomRow" style="display:none;"><span class="detail-label">Proposed Accommodation</span><span id="modalProposedAccomCell">—</span></div>
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
            <button type="button" class="btn-modal-close" onclick="closeDownloadDetailModal()">Close</button>
        </div>
    </div>
</div>
<input type="file" id="finance_invoice_upload" class="hide" style="display:none;">
<input type="file" id="finance_proof_upload" class="hide" style="display:none;">
</div>
<?php endif; ?>
