<?php
$query_base = $this->input->get();
unset($query_base['page']);
$search_value = '';
if (isset($paging['search'])) {
    $search_value = trim((string) $paging['search']);
} elseif (isset($search)) {
    $search_value = trim((string) $search);
}
?>

<div class="container-fluid">
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

                        Fiscal Year
                        <select class="form-control input-sm" name="period" onchange="document.forms.frm_manage.program.value='0'; document.forms.frm_manage.submit();">
                            <option value="" <?php echo empty($period) ? 'selected' : ''; ?>>All</option>
                            <?php foreach ($fiscal_years as $fy): ?>
                                <option value="<?php echo (int) $fy->fiscal_year; ?>" <?php echo (int) $fy->fiscal_year === (int) $period ? 'selected' : ''; ?>><?php echo htmlspecialchars((string) $fy->fiscal_year, ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                        &nbsp;&nbsp;&nbsp;&nbsp;

                        Program
                        <select class="form-control input-sm" name="program" onchange="document.forms.frm_manage.submit()" <?php echo empty($period) ? 'disabled' : ''; ?>>
                            <?php if (empty($period)) { ?>
                                <option value="0">Select fiscal year first</option>
                            <?php } else { ?>
                                <option value="0" <?php echo empty($program_id) || $program_id === 0 ? 'selected' : ''; ?>>-- Select Program --</option>
                                <?php foreach ($programs as $program): ?>
                                    <option value="<?php echo (int) $program->id; ?>" <?php echo (int) $program->id === (int) $program_id ? 'selected' : ''; ?>>
                                        <?php 
                                            $program_display = $program->name ?? '';
                                            if (!empty($program->fiscal_year)) {
                                                $program_display .= ' - ' . $program->fiscal_year;
                                            }
                                            echo htmlspecialchars((string) $program_display, ENT_QUOTES, 'UTF-8'); 
                                        ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="pull-right">
                        <input type="search" class="form-control input-sm" name="search" value="<?php echo htmlspecialchars((string) $search_value, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Search name, program">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                        <?php if ($search_value !== ''): ?>
                            <a href="<?php echo site_url('admin/finance_travel_arrangement_non_eta?program=' . (int) $program_id . '&period=' . (int) $period . '&tab=' . urlencode($active_tab)); ?>" class="btn btn-danger btn-sm">Reset</a>
                        <?php endif; ?>
                    </div>
                </div>
                <input type="hidden" name="tab" value="<?php echo htmlspecialchars((string) $active_tab, ENT_QUOTES, 'UTF-8'); ?>">
            </form>
        </div>
    </div>

    <ul class="nav nav-pills" style="border-bottom:1px solid #ddd; margin-top:15px;">
        <?php foreach ($tab_options as $tab_key => $tab_label): ?>
            <?php $tab_query = $query_base; $tab_query['tab'] = $tab_key; ?>
            <li class="<?php echo $active_tab === $tab_key ? 'active' : ''; ?>">
                <a href="<?php echo current_url() . '?' . http_build_query($tab_query); ?>"><?php echo htmlspecialchars((string) $tab_label, ENT_QUOTES, 'UTF-8'); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade active in">
            <?php $this->load->view('admin/travel_arrangement_non_eta/finance_table', [
                'active_tab' => $active_tab,
                'finance_rows' => $data ?? [],
                'paging' => $paging,
            ]); ?>
        </div>
    </div>
</div>
