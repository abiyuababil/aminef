<?php
$tabs = [
    'non_grantee' => 'Non-Grantee Payments',
    'bulk_non_grantee' => 'Bulk Non-Grantee Payments',
    'payment_grantee' => 'Bulk Grantee Payments',
    'payment_support' => 'Bulk Grant Support &amp; Travel Payments',
];
$tab_partials = [
    'non_grantee' => 'admin/finance_payments/_tab_non_grantee',
    'bulk_non_grantee' => 'admin/finance_payments/_tab_bulk_non_grantee',
    'payment_grantee' => 'admin/finance_payments/_tab_payment_grantee',
    'payment_support' => 'admin/finance_payments/_tab_payment_support',
];
if (!isset($active_tab) || !isset($tabs[$active_tab])) $active_tab = 'non_grantee';
function build_tab_url($fiscal_year, $program_id, $tab) {
    return site_url('admin/finance_payments/manage')
        . '?' . http_build_query(['fiscal_year' => $fiscal_year, 'program_id' => $program_id, 'tab' => $tab]);
}
?>
<style>
    .finance-payments-wrap .selector-bar {
        display: flex;
        align-items: center;
        gap: 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        border-radius: 6px;
        float: right;
        margin-bottom: 16px;
    }
    .finance-payments-wrap .selector-item { display: flex; align-items: center; gap: 8px; }
    .finance-payments-wrap .selector-label { font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase; }
    .finance-payments-wrap .selector-input {
        padding: 6px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        font-size: 12.5px;
        background-color: #fff;
        color: #0f172a;
        font-weight: 600;
        outline: none;
    }
    .finance-payments-wrap .selector-input:disabled {
        background-color: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }
    /* tab style. pills markup comes from shared bootstrap theme. */
    .finance-payments-wrap ul.nav-pills {
        display: flex;
        border-bottom: 2px solid #e2e8f0;
        gap: 4px;
        margin-bottom: 20px;
        padding-left: 0;
        list-style: none;
    }
    .finance-payments-wrap ul.nav-pills > li { margin-bottom: 0; }
    .finance-payments-wrap ul.nav-pills > li > a {
        display: block;
        padding: 9px 18px;
        font-size: 14px !important;
        font-weight: 400 !important;
        color: #0284c7;
        border: 1px solid transparent;
        border-bottom: none;
        border-radius: 4px 4px 0 0;
        white-space: nowrap;
    }
    .finance-payments-wrap ul.nav-pills > li.active > a,
    .finance-payments-wrap ul.nav-pills > li.active > a:hover,
    .finance-payments-wrap ul.nav-pills > li.active > a:focus {
        background-color: #0284c7;
        color: #ffffff;
    }
</style>

<div class="finance-payments-wrap">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Payments</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form id="frm_finance_payments_filter" method="GET" action="<?php echo site_url('admin/finance_payments/manage'); ?>">
                <div class="selector-bar">
                    <div class="selector-item">
                        <span class="selector-label">Fiscal Year:</span>
                        <select class="selector-input" id="financeFiscalYear" name="fiscal_year" onchange="document.getElementById('financeProgram').value='';this.form.submit()">
                            <option value="" <?php echo ((string) $selected_fiscal_year === '') ? 'selected' : ''; ?>>All</option>
                            <?php foreach ($fiscal_years as $year) { ?>
                                <option value="<?php echo html_escape($year); ?>" <?php echo ((string) $year === (string) $selected_fiscal_year) ? 'selected' : ''; ?>><?php echo html_escape($year); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="selector-item">
                        <span class="selector-label">Program:</span>
                        <select class="selector-input" id="financeProgram" name="program_id" onchange="this.form.submit()" <?php echo ((string) $selected_fiscal_year === '') ? 'disabled' : ''; ?>>
                            <?php if ((string) $selected_fiscal_year === '') { ?>
                                <option value="">Select fiscal year first</option>
                            <?php } else { ?>
                                <option value="">All</option>
                                <?php foreach ($program_options as $program_option) { ?>
                                    <option value="<?php echo (int) $program_option->id; ?>" <?php echo ((string) $program_option->id === (string) $selected_program_id) ? 'selected' : ''; ?>><?php echo html_escape($program_option->name); ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="tab" value="<?php echo html_escape($active_tab); ?>">
                    <?php if (!empty($sort_by)) { ?>
                        <input type="hidden" name="sort_by" value="<?php echo html_escape($sort_by); ?>">
                        <input type="hidden" name="sort" value="<?php echo html_escape($sort); ?>">
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>

    <?php if (empty($grant_ids)) { ?>
        <div class="alert alert-warning">No active grants found for the selected Fiscal Year / Program.</div>
    <?php } else { ?>
        <!-- outer form for shared non-grantee add/edit modal submit. -->
        <form id="form" role="form" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="delete_detail_payment" name="delete_detail_payment">
            <input type="hidden" id="delete_detail_payment_record_non_grantee" name="edit_record[delete_detail_payment_record]">
            <input type="hidden" name="total_grant" value="<?= isset($grantee_setting->total_grant) ? html_escape($grantee_setting->total_grant) : '' ?>">
            <input type="hidden" name="grantee_id" id="grantee_id" value="<?= isset($grantee_id) ? html_escape($grantee_id) : '' ?>">
        </form>

        <div class="row">
            <div class="col-lg-12" style="margin-bottom:10px">
                <ul class="nav nav-pills">
                    <?php foreach ($tabs as $tab_key => $tab_label) { ?>
                        <li class="<?php echo $tab_key === $active_tab ? 'active' : ''; ?>">
                            <a href="<?php echo build_tab_url($selected_fiscal_year, $selected_program_id, $tab_key); ?>"><?php echo $tab_label; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tab-content">
                <?php foreach ($tabs as $tab_key => $tab_label) { ?>
                    <div id="tab_<?php echo $tab_key; ?>" class="tab-pane fade <?php echo $tab_key === $active_tab ? 'active in' : ''; ?>">
                        <?php if ($tab_key === $active_tab) $this->load->view($tab_partials[$tab_key]); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- reusable modals from shared payment_record/form.php. -->
        <?php echo isset($payment_modals_html) ? $payment_modals_html : ''; ?>
    <?php } ?>
</div>
