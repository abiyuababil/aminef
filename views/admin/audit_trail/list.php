<?php
$filters = isset($filters) ? $filters : array();
$role = isset($filters['role']) ? (string) $filters['role'] : '';
$date_from = isset($filters['date_from']) ? (string) $filters['date_from'] : '';
$date_to = isset($filters['date_to']) ? (string) $filters['date_to'] : '';
$q = isset($filters['q']) ? (string) $filters['q'] : '';
$has_filter = $role !== '' || $q !== '' || $date_from !== '' || $date_to !== '';
?>
<style>
	.audit-json { white-space: pre-wrap; word-break: break-word; margin: 0; }
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Audit Trail</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<form id="frm_manage" method="GET">
			<div id="wrap-filter" class="data-header clearfix form-inline">
				<div class="pull-left">
					Show :
					<select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
						<?php foreach ($limit_options as $limit_option) : ?>
							<option value="<?= (int) $limit_option ?>" <?= (int) $paging['limit'] === (int) $limit_option ? 'selected' : '' ?>>
								<?= (int) $limit_option ?>
							</option>
						<?php endforeach; ?>
					</select>
					entries &nbsp;&nbsp;

					Role :
					<select class="form-control input-sm" name="role" onchange="document.forms.frm_manage.submit()">
						<option value="">All</option>
						<?php foreach ($role_options as $role_option) : ?>
							<option value="<?= html_escape($role_option) ?>" <?= $role === $role_option ? 'selected' : '' ?>>
								<?= html_escape(isset($role_labels[$role_option]) ? $role_labels[$role_option] : ucfirst($role_option)) ?>
							</option>
						<?php endforeach; ?>
					</select>
					&nbsp;&nbsp;

					Date From :
					<input type="date" class="form-control input-sm" name="date_from" value="<?= html_escape($date_from) ?>">
					&nbsp;&nbsp;
					Date To :
					<input type="date" class="form-control input-sm" name="date_to" value="<?= html_escape($date_to) ?>">
				</div>

				<div class="pull-right">
					Search :
					<input type="search" class="form-control input-sm" name="q" value="<?= html_escape($q) ?>" placeholder="" onkeypress="return submitFilter(event)">
					<button type="submit" class="btn btn-primary btn-sm">
						<i class="fa fa-search"></i> Search
					</button>
					<?php if ($has_filter) : ?>
						<a href="<?= site_url('admin/audit_trail/manage') ?>" class="btn btn-default btn-sm">
							Reset
						</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="35" class="text-center">#</th>
							<th width="150">Time</th>
							<th>User</th>
							<th width="90" class="text-center">Event</th>
							<th width="220">Table</th>
							<th>Source URL</th>
							<th width="130" class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($data) : ?>
							<?php $no = $paging['start_row']; ?>
							<?php foreach ($data as $row) : ?>
								<?php
								$country_id = (int) $row->user_country_id;
								if ($country_id === 1) {
									$country_class = 'label-primary';
								} elseif ($country_id === 2) {
									$country_class = 'label-info';
								} else {
									$country_class = 'label-default';
								}

								if ($row->event === 'insert') {
									$event_class = 'label-success';
								} elseif ($row->event === 'update') {
									$event_class = 'label-warning';
								} else {
									$event_class = 'label-danger';
								}

								$table_label = ucwords(str_replace('_', ' ', preg_replace('/^am_/', '', (string) $row->table_name)));
								?>
								<tr>
									<td class="text-center"><?= (int) $no ?></td>
									<td><?= $row->created_at ? date('d M Y H:i:s', strtotime($row->created_at)) : '-' ?></td>
									<td>
										<strong><?= html_escape($row->created_name ?: '-') ?></strong>
										<?php if ($row->country_label) : ?>
											<span class="label <?= $country_class ?>"><?= html_escape($row->country_label) ?></span>
										<?php endif; ?>
										<br>
										<small class="text-muted">
											<?= html_escape($row->role_label) ?>
											<?php if ($row->role === 'admin' && $row->staff_role_name) : ?>
												&middot; <?= html_escape($row->staff_role_name) ?>
											<?php endif; ?>
											<?php if ($row->user_email) : ?>
												&middot; <?= html_escape($row->user_email) ?>
											<?php endif; ?>
										</small>
									</td>
									<td class="text-center">
										<span class="label <?= $event_class ?>"><?= html_escape(ucfirst((string) $row->event)) ?></span>
									</td>
									<td>
										<?= html_escape($table_label) ?>
										<?php if ($row->table_id) : ?>
											<br><small class="text-muted">Record ID: <?= (int) $row->table_id ?></small>
										<?php endif; ?>
									</td>
									<td><small><?= html_escape((string) $row->url) ?></small></td>
									<td class="text-center">
										<button type="button" class="btn btn-primary btn-xs btn-audit-detail" data-id="<?= (int) $row->id ?>">
											<i class="fa fa-eye"></i> View Changes
										</button>
									</td>
								</tr>
								<?php $no++; ?>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="7" class="text-center text-muted">No audit trail found for the selected filters.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

			<div class="pull-left">
				Showing <?= (int) $paging['start_row'] ?> to <?= (int) $paging['end_row'] ?> of <?= (int) $paging['total_rows'] ?> entries
			</div>
			<?= $paging['html'] ?>
		</form>
	</div>
</div>

<div class="modal fade" id="auditDetailModal" tabindex="-1" role="dialog" aria-labelledby="auditDetailModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="auditDetailModalLabel">Audit Detail</h4>
			</div>
			<div class="modal-body">
				<div id="audit-detail-meta" class="small" style="margin-bottom: 12px;"></div>
				<div class="table-responsive">
					<table class="table table-bordered table-condensed" id="audit-detail-table">
						<thead>
							<tr>
								<th width="30%">Field</th>
								<th width="35%">Old Value</th>
								<th width="35%">New Value</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
