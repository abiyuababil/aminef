<style>
  /* Accordion Wrapper */
  .accordion-wrapper {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .accordion-item {
    background: #ffffff;
    border: 1px solid #dcdfe6;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    overflow: hidden;
  }

  .accordion-header {
    background-color: #f8fafc;
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
    border-bottom: 1px solid transparent;
    transition: background-color 0.15s ease;
  }

  .accordion-item.active .accordion-header {
    border-bottom-color: #e2e8f0;
    background-color: #f1f5f9;
  }

  .accordion-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .accordion-chevron {
    width: 16px;
    height: 16px;
    color: #64748b;
    transition: transform 0.2s ease;
  }

  .accordion-item.active .accordion-chevron {
    transform: rotate(180deg);
  }

  .period-tag-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
  }

  .badge-period-count {
    font-size: 11px;
    font-weight: 700;
    background-color: #e0f2fe;
    color: #0369a1;
    padding: 2px 8px;
    border-radius: 12px;
  }

  .accordion-content {
    display: none;
    overflow-x: auto;
  }

  .accordion-item.active .accordion-content {
    display: block;
  }

  /* Data Table */
  .data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    text-align: left;
  }

  .data-table th {
    background-color: #f8fafc;
    color: #475569;
    font-weight: 600;
    padding: 10px 16px;
    border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
  }

  .data-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
  }

  .data-table tr:hover {
    background-color: #fafbfc;
  }

  .col-checkbox {
    width: 36px;
    text-align: center;
  }

  .col-no {
    width: 44px;
    color: #64748b;
  }

  .col-date {
    width: 150px;
    white-space: nowrap;
    color: #334155;
    font-weight: 500;
  }

  .grant-list-lines {
    line-height: 1.6;
    color: #1e293b;
    font-weight: 500;
  }

  /* Action Buttons Uniformity */
  .col-action {
    width: 140px;
    text-align: right;
  }

  .action-buttons-group {
    display: inline-flex;
    flex-direction: column;
    gap: 4px;
    align-items: flex-end;
  }

  .action-top-row {
    display: flex;
    gap: 4px;
  }

  .btn-tbl {
    display: inline-block;
    border: none;
    padding: 4px 9px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
    color: #ffffff !important;
    cursor: pointer;
    text-decoration: none !important;
    line-height: 1.42857143;
    text-align: center;
  }

  .btn-tbl-edit { background-color: #337ab7; }
  .btn-tbl-edit:hover, .btn-tbl-edit:focus { background-color: #286090; color: #ffffff !important; }

  .btn-tbl-delete { background-color: #d9534f; }
  .btn-tbl-delete:hover, .btn-tbl-delete:focus { background-color: #c9302c; color: #ffffff !important; }

  .btn-tbl-download {
    background-color: #f0ad4e;
    text-align: center;
    width: 100%;
  }
  .btn-tbl-download:hover, .btn-tbl-download:focus { background-color: #ec971f; color: #ffffff !important; }
</style>
<?php if ($this->session->flashdata('update_fosm')) { ?>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="alert alert-success"><?php echo $this->session->flashdata('update_fosm'); ?></div>
            <?php $this->session->set_flashdata('update_fosm', false); ?>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage Study Fields Mapping</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>

                    Period :
                    <select class="form-control input-sm" name="fiscal_year" onchange="document.forms.frm_manage.submit()">
                        <option value="0">Show All</option>
                        <?php
                            $fiscal_year = $this->input->get('fiscal_year');

                            foreach ($periods as $period) { 
                            
                        ?>
                            <option value="<?php echo $period->fiscal_year ?>" <?php echo $period->fiscal_year == $fiscal_year ? 'selected' : ''; ?>><?php echo $period->fiscal_year ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="pull-right">
                    <a href="<?= base_url('admin/study_field_mapping/add') ?>" class="btn btn-success">Add Mapping</a>
                </div>
            </div>

            <?php
            $grouped = [];
            if (!empty($data)) {
                foreach ($data as $row) {
                    $period_key = !empty($row->fiscal_year) ? $row->fiscal_year : 'No Period';
                    if (!isset($grouped[$period_key])) {
                        $grouped[$period_key] = [];
                    }
                    $grouped[$period_key][] = $row;
                }
            }
            if(!empty($grouped)) {
                krsort($grouped);
            }
            ?>

            <div class="accordion-wrapper mb-2" id="eecAccordionContainer">
                <?php if (!empty($grouped)): ?>
                    <?php foreach ($grouped as $period_key => $rows): 
                        $acc_id = 'acc-item-' . preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) $period_key);
                        $row_count = count($rows);
                    ?>
                        <div class="accordion-item" id="<?php echo $acc_id; ?>" data-period="<?php echo htmlspecialchars((string) $period_key); ?>">
                            <div class="accordion-header" onclick="toggleAccordion('<?php echo $acc_id; ?>')">
                                <div class="accordion-header-left">
                                    <svg class="accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                    <span class="period-tag-title"><?php echo ($period_key !== 'No Period' ? 'Period ' : '') . htmlspecialchars((string) $period_key); ?></span>
                                    <span class="badge-period-count"><?php echo $row_count; ?> <?php echo $row_count == 1 ? 'Grant' : 'Grants'; ?></span>
                                </div>
                            </div>
                            
                            <div class="accordion-content">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th class="col-checkbox"><input type="checkbox" class="chk-all"></th>
                                            <th class="col-no">#</th>
                                            <th>Grants</th>
                                            <th>Mapped FOS</th>
                                            <th class="col-action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        foreach ($rows as $row): 
                                            $data_grants = !empty($row->user_grantee_grant_id) ? array_filter(explode(',', $row->user_grantee_grant_id)) : [];
                                            $name_grants = [];
                                            if (!empty($data_grants)) {
                                                $grants_name = get_all_db('am_user_grantee_grant', [], $data_grants, 'id');
                                                $name_grants = array_column($grants_name, 'name');
                                            }
                                        ?>
                                        <?php 
                                            $grant_param = str_replace(',', '-', $row->user_grantee_grant_id);
                                        ?>
                                            <tr>
                                                <td class="col-checkbox">
                                                    <input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->period_id . '_' . $grant_param; ?>">
                                                </td>
                                                <td class="col-no"><?php echo $no++; ?></td>
                                                <td>
                                                    <div class="grant-list-lines">
                                                        <?php echo !empty($name_grants) ? implode('<br>', $name_grants) : '-'; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background-color: #2563eb; color: #fff; font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                                                        <?php echo isset($row->total_fos) ? $row->total_fos : 0; ?> Fields
                                                    </span>
                                                </td>
                                                <td class="col-action">
                                                    <div class="action-buttons-group">
                                                        <div class="action-top-row">
                                                            <a href="<?= base_url('admin/study_field_mapping/edit/' . $row->period_id . '/' . $grant_param); ?>" class="btn-tbl btn-tbl-edit">Edit</a>
                                                            <a href="<?= base_url('admin/study_field_mapping/delete/' . $row->period_id . '/' . $grant_param); ?>" onclick="return confirm('Are you sure you want to delete this mapping?')" class="btn-tbl btn-tbl-delete">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info">No data available</div>
                <?php endif; ?>
            </div>
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>

    </div>
</div>

<?php $this->load->view('admin/partials/form_filter') ?>
<script>

  function toggleAccordion(id) {
    const item = document.getElementById(id);
    item.classList.toggle('active');
  }
</script>