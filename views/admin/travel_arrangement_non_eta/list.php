<?php
$query_base = $this->input->get();
unset($query_base['page']);
$search_value = '';
if (isset($paging['search'])) {
    $search_value = trim((string) $paging['search']);
} elseif (isset($search)) {
    $search_value = trim((string) $search);
}
$can_manage_tba = has_permission('travel_arrangement', 'tba_eta_travel_arrangement');
$is_aminef_staff_permission = has_permission('travel_arrangement', 'internal_travel_arrangement');
?>

<style>
    /* Tabel FOS & Tree Structure */
    .table-travel-purpose { border: 1px solid #dee2e6; border-radius: 4px; max-height: 480px; overflow-y: auto; }
    .table-travel-purpose table { width: 100%; border-collapse: collapse; font-size: 13px; text-align: left; }
    .table-travel-purpose thead th { position: sticky; top: 0; background: #eef2f7; border-bottom: 2px solid #dee2e6; padding: 10px 12px; font-weight: bold; color: #1e3a8a; z-index: 2; }
    
    /* Baris Parent */
    .table-travel-purpose tr.parent-row { background-color: #edf2f7; border-top: 1px solid #cbd5e1; border-bottom: 1px solid #cbd5e1; }
    .table-travel-purpose tr.parent-row td { padding: 9px 12px; font-weight: bold; color: #1e293b; }
    
    /* Baris Child (Sub FOS) */
    .table-travel-purpose tr.child-row td { padding: 8px 12px; border-bottom: 1px solid #f1f5f9; }
    .table-travel-purpose tr.child-row:hover { background-color: #f8fafc; }
    .table-travel-purpose .tree-branch { color: #94a3b8; font-family: monospace; margin-right: 6px; font-weight: normal; }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Manage Travel Arrangement (Non-ETA)
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#mdl_guideline">Edit Guideline</button>
            <button type="button" class="btn btn-info pull-right mr-2" data-toggle="modal" data-target="#mdl_travel_purpose">Manage Travel Purpose</button>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <?php if ($this->session->flashdata('travel_arrangement_success')): ?>
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i> <?= html_escape($this->session->flashdata('travel_arrangement_success')) ?>
                </div>
            <?php endif; ?>
            <?php $this->session->unset_userdata('travel_arrangement_success'); ?>
            <?php if ($this->session->flashdata('travel_arrangement_error')): ?>
                <div class="alert alert-danger">
                    <i class="fa fa-times-circle"></i> <?= html_escape($this->session->flashdata('travel_arrangement_error')) ?>
                </div>
            <?php endif; ?>
            <?php $this->session->unset_userdata('travel_arrangement_error'); ?>
            <div class="modal fade" id="mdl_delete_payment_choice" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Delete Travel Arrangement</h4>
                        </div>
                        <div class="modal-body">
                            <p><span id="delete_payment_choice_text"></span></p>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="btn_with_payments" class="btn btn-danger" onclick="return confirm('Delete the travel arrangement together with all of its linked payments? This action cannot be undone.')">
                                <i class="fa fa-trash"></i> Delete with payments
                            </a>
                            <a href="#" id="btn_keep_payments" class="btn btn-warning" onclick="return confirm('Delete the travel arrangement only? The linked payment(s) will be kept and unlinked.')">
                                <i class="fa fa-times"></i> Delete travel arrangement only
                            </a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $fallback_blocked_id = (int) $this->session->flashdata('travel_arrangement_blocked_id');
                $fallback_blocked_count = (int) $this->session->flashdata('travel_arrangement_blocked_count');
                $fallback_with_url = $fallback_blocked_id > 0 ? site_url('admin/travel_arrangement_non_eta/delete/'.$fallback_blocked_id.'?'.http_build_query(array_merge($query_base, ['mode' => 'with_payments']))) : '#';
                $fallback_keep_url = $fallback_blocked_id > 0 ? site_url('admin/travel_arrangement_non_eta/delete/'.$fallback_blocked_id.'?'.http_build_query(array_merge($query_base, ['mode' => 'keep_payments']))) : '#';
            ?>
            <?php $this->session->unset_userdata('travel_arrangement_blocked_id'); ?>
            <?php $this->session->unset_userdata('travel_arrangement_blocked_count'); ?>
            <script>
            (function () {
                function showPaymentChoice(count, withUrl, keepUrl) {
                    document.getElementById('delete_payment_choice_text').textContent =
                        'This travel arrangement has ' + count + ' linked payment(s). Please choose how to proceed.';
                    document.getElementById('btn_with_payments').setAttribute('href', withUrl);
                    document.getElementById('btn_keep_payments').setAttribute('href', keepUrl);
                    var timer = setInterval(function () {
                        if (window.jQuery) {
                            clearInterval(timer);
                            jQuery('#mdl_delete_payment_choice').modal('show');
                        }
                    }, 50);
                    setTimeout(function () { clearInterval(timer); }, 5000);
                }
                document.addEventListener('click', function (e) {
                    var btn = e.target && e.target.closest ? e.target.closest('.btn-delete-travel') : null;
                    if (!btn) {
                        return;
                    }
                    var count = parseInt(btn.getAttribute('data-payments') || '0', 10);
                    if (count > 0) {
                        e.preventDefault();
                        showPaymentChoice(count, btn.getAttribute('data-with-url'), btn.getAttribute('data-keep-url'));
                    } else if (!confirm('Are you sure you want to delete this travel arrangement and all of its related data? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
                <?php if ($fallback_blocked_id > 0): ?>
                showPaymentChoice(<?= $fallback_blocked_count ?>, '<?= $fallback_with_url ?>', '<?= $fallback_keep_url ?>');
                <?php endif; ?>
            })();
            </script>




            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    Show : 
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                    <?php
                    foreach($limit_options as $lo) {
                        $selected = '';
                        if ($lo == $paging['limit']) $selected = 'selected';
                    ?>
                      <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                    <?php } ?>
                    </select> 
                    entries

                    Fiscal Year
                    <select class="form-control input-sm" name="period" onchange="document.forms.frm_manage.program.value='0'; document.forms.frm_manage.submit();">
                        <option value="" <?php echo empty($period) ? 'selected' : ''; ?>>All</option>
                        <?php foreach ($fiscal_years as $fy): ?>
                            <option value="<?php echo (int) $fy->fiscal_year; ?>" <?php echo (int) $fy->fiscal_year === (int) $period ? 'selected' : ''; ?>><?php echo htmlspecialchars((string) $fy->fiscal_year, ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select>

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
                        <a href="<?php echo site_url('admin/travel_arrangement_non_eta/manage?program=' . (int) $program_id . '&period=' . (int) $period . '&tab=' . urlencode($active_tab)); ?>" class="btn btn-danger btn-sm">Reset</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($is_aminef_staff_permission) : ?>
            <ul class="nav nav-pills" style="border-bottom:1px solid #ddd; margin-top:15px;">
                <?php foreach ($tab_options as $tab_key => $tab_label): ?>
                    <?php $tab_query = $query_base; $tab_query['tab'] = $tab_key; ?>
                    <li class="<?php echo $active_tab === $tab_key ? 'active' : ''; ?>">
                        <a href="<?php echo current_url() . '?' . http_build_query($tab_query); ?>"><?php echo htmlspecialchars((string) $tab_label, ENT_QUOTES, 'UTF-8'); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th>Grantee Name</th>
                            <th>Program Name</th>
                            <th>Fiscal Year</th>
                            <th>Travel Purpose</th>
                            <th <?php echo sorting_attribute('type', $sort_by, $sort) ?>>Type</th>
                            <th <?php echo sorting_attribute('status', $sort_by, $sort) ?>>Status</th>
                            <th <?php echo sorting_attribute('created_at', $sort_by, $sort) ?>>Created At</th>
                            <th width="285" class="text-right" style="white-space:nowrap;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($data)
                      {
                        $no = $paging['start_row'];
                        foreach($data as $row) {
                            $status_label = format_status_travel_arrangement_non_eta($row->status, $row->type);
                      ?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td><a href="<?php echo site_url('admin/grantee/edit/'.$row->user_grantee_id.'/'.$row->grant_id) ?>" class="text-primary"><?php echo get_full_name($row, 'US') ?></a></td>
                            <td><?php echo $row->program_name ? $row->program_name : 'N/A' ?></td>
                            <td><?php echo $row->period_fiscal_year ? $row->period_fiscal_year : 'N/A' ?></td>
                            <td><?php echo html_escape($row->travel_purposes) . (in_array(strtolower(trim((string)$row->travel_purposes)), ['other', 'others'], true) && !empty($row->travel_purposes_other) ? ' (' . html_escape($row->travel_purposes_other) . ')' : ''); ?></td>
                            <td><?php echo ucfirst(str_replace('_', ' ', $row->type)) ?></td>
                            <td><?php echo $status_label ?></td>
                            <td><?php echo $row->created_at ? date('d M Y H:i:s', strtotime($row->created_at)) : 'N/A' ?></td>
                            <td class="text-right" style="white-space:nowrap;">
                                <a href="<?php echo site_url('admin/travel_arrangement_non_eta/view/'.$row->id) ?>" class="btn btn-primary btn-xs">
                                    <i class="fa fa-eye"></i> View
                                </a>
                                <a 
                                    href="#" 
                                    data-grantname="<?php echo $row->program_name ?>" 
                                    data-period="<?php echo $row->period_fiscal_year ?>" 
                                    data-name="<?= get_full_name($row, 'US') ?>" 
                                    data-id="<?= $row->id ?>" 
                                    data-category="<?php echo ucfirst(str_replace('_', ' ', $row->type)) ?>"
                                    data-ajax_url="<?php echo site_url('admin/notes/get_list_ajax/non_eta_travel/' . $row->grantee_grant_id . '/'); ?><?= $row->id ?>"  
                                    class="open-offcanvas-note btn btn-xs btn-warning btn-chat">
                                        <i class="fa fa-comments"></i> Chat
                                        <span class="note-total-<?= $row->id ?> span-note-travel" data-total="<?= $row->total_notes ?>">
                                            <span class="badge"><?= $row->total_notes ?></span>
                                        </span>
                            </a>
                                <?php
                                    $delete_row_params = $query_base;
                                    $delete_with_url = site_url('admin/travel_arrangement_non_eta/delete/'.$row->id.'?'.http_build_query(array_merge($delete_row_params, ['mode' => 'with_payments'])));
                                    $delete_keep_url = site_url('admin/travel_arrangement_non_eta/delete/'.$row->id.'?'.http_build_query(array_merge($delete_row_params, ['mode' => 'keep_payments'])));
                                    $delete_plain_url = site_url('admin/travel_arrangement_non_eta/delete/'.$row->id.'?'.http_build_query($delete_row_params));
                                ?>
                                <a href="<?php echo $delete_plain_url ?>" class="btn btn-danger btn-xs btn-delete-travel" data-payments="<?php echo (int) $row->total_payments ?>" data-with-url="<?php echo $delete_with_url ?>" data-keep-url="<?php echo $delete_keep_url ?>">
                                    <i class="fa fa-trash"></i> Delete
                                </a>


                            </td>
                        </tr>
                        <?php
                            $no++;
                        }
                      }
                      else
                      {
                      ?>
                        <tr>
                            <td colspan="9" class="text-center">No data available</td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                </table>
            </div>

            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
            </div>

            <?php echo $paging['html'] ?>

            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>
    </div>
</div>

<div class="modal fade" id="mdl_guideline">
    <div class="modal-dialog modal-lg" style="width:95%;max-width:1200px;">
        <form action="<?= base_url(); ?>admin/grantee/add_guideline_non_eta" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Guideline</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <textarea cols="30" rows="10" name="guideline_non_eta" id="guideline_non_eta" class="form-control editor-full"><?= get_option('guideline_non_eta') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="modal fade" id="mdl_travel_purpose">
    <div class="modal-dialog modal-lg" style="width:95%;max-width:1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Manage Travel Purpose</h4>
            </div>

            <div class="modal-body" style="display:flex;flex-direction:column;">
                <div class="pull-right mb-3" style="display:inline-flex;flex-direction: row-reverse;">
                    <a href="<?php echo site_url('admin/travel_purpose/add') ?>" class="btn btn-success btn-sm">
                        ADD NEW
                    </a>
                </div>
                <div class="table-responsive table-travel-purpose">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th width="150" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach(get_all_db('am_travel_purpose') as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row->name ?></td>
                                <td><?php echo $row->is_active ? 'Active' : 'Inactive' ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('admin/travel_purpose/edit/'.$row->id) ?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?php echo site_url('admin/travel_purpose/delete/'.$row->id) ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-times-circle"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>