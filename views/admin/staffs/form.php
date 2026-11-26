<style>
	/* Sub Config Panel */
	.sub-config-panel {
		margin-top: 12px;
		background: #ffffff;
		border: 1px solid #bce8f1;
		border-radius: 4px;
		padding: 14px;
		display: block;
	}
	.sub-scope-radios {
		display: flex;
		gap: 20px;
		margin-bottom: 12px;
		padding-bottom: 10px;
		border-bottom: 1px solid #eef3f7;
	}
	.sub-scope-radios label {
		font-weight: 600;
		color: #444444;
		font-size: 13px;
	}

	/* Toolbar filter grant */
	.filter-toolbar {
		display: flex;
		gap: 10px;
		margin-bottom: 10px;
	}
	.filter-toolbar input {
		flex: 1;
	}
	.filter-toolbar select {
		width: 140px;
	}

	/* Active Grants Checklist Container */
	.grants-list-container {
		max-height: 240px;
		overflow-y: auto;
		border: 1px solid #e0e0e0;
		border-radius: 3px;
		background: #fafafa;
	}
	.grant-row {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 8px 12px;
		border-bottom: 1px solid #ededed;
		background: #ffffff;
		cursor: pointer;
		font-size: 13px;
		transition: background 0.15s;
	}
	.grant-row:hover {
		background-color: #f5f8fa;
	}
	.grant-row.selected {
		background-color: #f0f7fd;
	}
	.grant-left {
		display: flex;
		align-items: center;
		gap: 9px;
		flex: 1;
	}
	.grant-name {
		font-weight: 500;
		color: #2b3e50;
	}
	.grant-meta {
		display: flex;
		align-items: center;
		gap: 8px;
	}
	.grant-category {
		font-size: 11px;
		color: #777;
	}
	.year-badge {
		display: inline-block;
		padding: 2px 8px;
		font-size: 11px;
		font-weight: 600;
		background: #f1f3f5;
		color: #495057;
		border: 1px solid #ced4da;
		border-radius: 3px;
	}

	/* Action quick buttons */
	.quick-actions {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-top: 8px;
		font-size: 12px;
		color: #666;
	}
	.quick-actions a {
		color: #2878b5;
		text-decoration: none;
		margin-right: 12px;
		cursor: pointer;
		font-weight: 500;
	}
	.quick-actions a:hover {
		text-decoration: underline;
	}

	/* Selected Chips Area */
	.selected-summary {
		display: flex;
		flex-wrap: wrap;
		gap: 6px;
		margin-bottom: 10px;
		padding-bottom: 8px;
		border-bottom: 1px dashed #e2e8f0;
		min-height: 28px;
	}
	.grant-chip {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		background: #eaf3f9;
		color: #1e5a87;
		border: 1px solid #bfdbeb;
		padding: 3px 8px;
		border-radius: 3px;
		font-size: 11.5px;
		font-weight: 500;
	}
	.grant-chip button {
		border: none;
		background: transparent;
		color: #1e5a87;
		font-size: 13px;
		line-height: 1;
		padding: 0;
		cursor: pointer;
		font-weight: bold;
	}


	.form-section {
		margin-bottom: 24px;
	}
	.section-heading {
		font-size: 13px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		color: #666666;
		margin-bottom: 14px;
		padding-bottom: 4px;
		border-bottom: 1px dashed #e0e0e0;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $title ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
	<form role="form" method="POST">
		<div class="form-section col-lg-12">
			<div class="section-heading">Account & Contact</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Username</label>
					<input class="form-control" name="username" value="<?php echo (isset($this->Staff_model->username)) ? $this->Staff_model->username : '' ?>" placeholder="" required>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Full Name</label>
					<input class="form-control" name="full_name" value="<?php echo (isset($this->Staff_model->full_name)) ? $this->Staff_model->full_name : '' ?>" placeholder="" required>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" name="password" value="" placeholder="" <?php echo (isset($this->Staff_model->id)) ? '' : 'required' ?>>
					<?php
					if (isset($this->Staff_model->id)) {
					?>
					<small class="text-danger">Leave blank if you do not want to change.</small>
					<?php } ?>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Email</label>
					<input class="form-control" name="email" value="<?php echo (isset($this->Staff_model->email)) ? $this->Staff_model->email : '' ?>" placeholder="">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Telephone</label>
					<input class="form-control" name="telephone" value="<?php echo (isset($this->Staff_model->telephone)) ? $this->Staff_model->telephone : '' ?>" placeholder="">
				</div>
			</div>
		</div>

		
    	<div class="form-section col-lg-12">
			<div class="section-heading">Roles & Permissions</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Manage Grantee for</label>
					<select class="form-control" name="country_id" required>
						<option value="">-- Select Country --</option>
						<option <?= $this->Staff_model->country_id == 999 ? 'selected' : '' ?> value="999">All</option>
					<?php
					if($countries)
					{
						foreach($countries as $co) {
							$selected = '';
							if (isset($this->Staff_model->country_id) && $this->Staff_model->country_id == $co->id)
								$selected = 'selected="selected"';
					?>
						<option value="<?php echo $co->id ?>" <?php echo $selected ?>><?php echo $co->name ?></option>
					<?php
						}
					}
					?>
					</select>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Staff Role</label>
					<select class="form-control" id="role-select" name="role" onmousedown="return !this.readOnly" onkeydown="return !this.readOnly" <?php echo isset($this->Staff_model->is_administrator) && $this->Staff_model->is_administrator ? 'readonly' : '' ?> style="<?php echo isset($this->Staff_model->is_administrator) && $this->Staff_model->is_administrator ? 'opacity:0.6' : '' ?>" required>
						<option value="">-- Select Role --</option>
						<?php foreach($roles as $role){ ?>
							<option <?= $this->Staff_model->role == $role->slug ? 'selected' : '' ?> value="<?= $role->slug ?>"><?= $role->name ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="alert alert-info" style="padding: 12px 15px; margin-bottom: 15px;">
					<label style="font-weight: normal !important; margin-bottom: 0;">
						<input type="checkbox" id="admin-checkbox" name="is_administrator" value="1" onchange="var s=document.getElementById('role-select'); s.readOnly=this.checked; s.style.opacity=this.checked?'0.6':'1'" <?php echo isset($this->Staff_model->is_administrator) && $this->Staff_model->is_administrator ? 'checked' : '' ?>>
						<b>Administrator</b><br>
						Has full access to all features
					</label>
				</div>
				<div class="alert alert-info" style="padding: 12px 15px; margin-bottom: 15px;">
					<label style="font-weight: normal !important; margin-bottom: 0;">
						<input type="checkbox" id="admin-checkbox" name="access_detail_dashboard" value="1" <?php echo isset($this->Staff_model->access_detail_dashboard) && $this->Staff_model->access_detail_dashboard ? 'checked' : '' ?>>
						<b>Has access to detail dashboard</b><br>
						Has full access to detail dashboard
					</label>
				</div>
				<div class="alert alert-info" style="padding: 12px 15px; margin-bottom: 15px;">
					<label style="font-weight: normal !important; margin-bottom: 0;">
						<input type="checkbox" name="receives_notify_to_finance_email" value="1" <?php echo $this->Staff_model->receives_notify_to_finance_email ? 'checked' : '' ?>>
						<b>Notify to Finance</b><br>
						Receive email notification when the Payment status is set to Notify to Finance
					</label>
				</div>
				<?php if($this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
				<div class="alert alert-info" style="padding: 12px 15px; margin-bottom: 15px;">
					<label style="font-weight: normal !important; margin-bottom: 0;">
						<input type="checkbox" id="receives-notification-grantee-chk"
							name="receives_notification_grantee" value="1"
							<?php echo $this->Staff_model->receives_notification_grantee ? 'checked' : '' ?>
							onchange="toggleGranteeNotificationPanel(this.checked)">
						<b>Notification Grantee</b><br>
						Receive notification from the grantee when updating data.
					</label>

					<!-- Conditional Setting Panel -->
					<div class="sub-config-panel" id="granteeNotificationConfig"
						style="<?php echo $this->Staff_model->receives_notification_grantee ? '' : 'display:none;' ?>">

						<div class="sub-scope-radios">
							<label>
								<input type="radio" name="scopeNotification" id="scopeAll" value="all"
									<?php echo (isset($notification_scope) && $notification_scope === 'all') ? 'checked' : '' ?>
									onchange="toggleScope(this.value)">
								All Active Grants
							</label>
							<label>
								<input type="radio" name="scopeNotification" id="scopeSpecific" value="specific"
									<?php echo (!isset($notification_scope) || $notification_scope === 'specific') ? 'checked' : '' ?>
									onchange="toggleScope(this.value)">
								Specific Grants (Per Name &amp; Year)
							</label>
						</div>

						<!-- Specific Grants Picker -->
						<div id="specificGrantsPicker"
							style="<?php echo (!isset($notification_scope) || $notification_scope === 'specific') ? '' : 'display:none;' ?>">

							<div class="selected-summary" id="selectedSummary">
							<!-- Selected Chips rendered here -->
							</div>

							<!-- Toolbar Search & Filter -->
							<div class="filter-toolbar">
								<input type="text" id="grantSearch" class="form-control" placeholder="Search grant name..." oninput="renderGrantList()">
								<select id="yearFilter" class="form-control" onchange="renderGrantList()">
									<option value="all">All Years</option>
									<?php
									$_years = [];
									if (!empty($active_grants)) {
										foreach ($active_grants as $_g) {
											if ($_g->year && !in_array($_g->year, $_years)) $_years[] = $_g->year;
										}
									}
									rsort($_years);
									foreach ($_years as $_y) { ?>
									<option value="<?= $_y ?>"><?= $_y ?></option>
									<?php } ?>
								</select>
							</div>

							<!-- List checklist -->
							<div class="grants-list-container" id="grantsListContainer">
							<!-- Dynamically populated rows -->
							</div>

							<div class="quick-actions">
								<div>
									<a onclick="selectAllFiltered()">Select All (Filtered)</a>
									<a onclick="clearAllSelection()">Clear Selection</a>
								</div>
								<div id="selectionCounter">0 grants selected</div>
							</div>
						</div><!-- /#specificGrantsPicker -->

					</div><!-- /#granteeNotificationConfig -->
				</div><!-- /.alert -->
				<?php } ?>
				<?php
				if (isset($this->Staff_model->id)) {
				?>
				<input type="hidden" name="id" value="<?php echo $this->Staff_model->id ?>">
				<?php } ?>
				<?php if($this->session->userdata('active_country') == AMERICAN_DATABASE): ?>
				<!-- Hidden fields populated by JS before submit -->
				<input type="hidden" name="notification_scope" id="hidden_notification_scope" value="">
				<div id="hidden_grant_ids_container"></div>
				<?php endif; ?>
				<a href="<?php echo site_url('admin/staffs/manage') ?>" class="btn btn-default">Back</a>
				<button type="submit" class="btn btn-success">Save</button>
			</div>
		</div>
		
	</form>
	<!-- /.col-lg-4 -->
</div>
<!-- /.row -->

<?php if($this->session->userdata('active_country') == AMERICAN_DATABASE): ?>
<script>
// ─── Grant data from PHP ──────────────────────────────────────────────────
var GRANTS_DATA = <?php
	$grants_js = [];
	if (!empty($active_grants)) {
		foreach ($active_grants as $g) {
			$grants_js[] = [
				'id'       => (int) $g->id,
				'name'     => htmlspecialchars($g->name, ENT_QUOTES),
				'year'     => (int) ($g->year ?? 0),
				'category' => htmlspecialchars($g->category_grant ?? '', ENT_QUOTES),
			];
		}
	}
	echo json_encode($grants_js);
?>;

var SELECTED_GRANT_IDS = <?php echo json_encode(
	isset($notification_grant_ids) ? array_map('intval', $notification_grant_ids) : []
); ?>;

// ─── Toggle panel visibility when checkbox changes ────────────────────────
function toggleGranteeNotificationPanel(checked) {
	var panel = document.getElementById('granteeNotificationConfig');
	if (panel) panel.style.display = checked ? 'block' : 'none';
}

// ─── Toggle specific-grant picker ────────────────────────────────────────
function toggleScope(val) {
	var picker = document.getElementById('specificGrantsPicker');
	if (!picker) return;
	picker.style.display = (val === 'specific') ? 'block' : 'none';
}

// ─── Render grant checklist rows ─────────────────────────────────────────
function renderGrantList() {
	var q         = (document.getElementById('grantSearch')  || {value:''}).value.toLowerCase();
	var year      = (document.getElementById('yearFilter')   || {value:'all'}).value;
	var container = document.getElementById('grantsListContainer');
	if (!container) return;

	var filtered = GRANTS_DATA.filter(function(g) {
		var matchQ    = !q    || g.name.toLowerCase().indexOf(q) !== -1;
		var matchYear = year === 'all' || String(g.year) === year;
		return matchQ && matchYear;
	});

	if (filtered.length === 0) {
		container.innerHTML = '<div style="padding:10px 12px;color:#999;font-size:13px;">No grants found.</div>';
		updateCounter();
		return;
	}

	var html = '';
	filtered.forEach(function(g) {
		var checked  = SELECTED_GRANT_IDS.indexOf(g.id) !== -1 ? 'checked' : '';
		var selClass = checked ? ' selected' : '';
		html += '<div class="grant-row' + selClass + '" onclick="toggleGrantRow(this,' + g.id + ')">'
			+ '<div class="grant-left">'
			+ '<input type="checkbox" ' + checked + ' onclick="event.stopPropagation();toggleGrantRow(this.parentElement.parentElement,' + g.id + ')" style="margin-right:4px;">'
			+ '<span class="grant-name">' + escapeHtml(g.name) + '</span>'
			+ '</div>'
			+ '<div class="grant-meta">'
			+ (g.year ? '<span class="year-badge">' + g.year + '</span>' : '')
			+ '</div>'
			+ '</div>';
	});
	container.innerHTML = html;
	updateCounter();
	renderChips();
}

function toggleGrantRow(row, grantId) {
	var idx = SELECTED_GRANT_IDS.indexOf(grantId);
	if (idx === -1) {
		SELECTED_GRANT_IDS.push(grantId);
		row.classList.add('selected');
	} else {
		SELECTED_GRANT_IDS.splice(idx, 1);
		row.classList.remove('selected');
	}
	var cb = row.querySelector('input[type=checkbox]');
	if (cb) cb.checked = (SELECTED_GRANT_IDS.indexOf(grantId) !== -1);
	updateCounter();
	renderChips();
}

function selectAllFiltered() {
	var q    = (document.getElementById('grantSearch')  || {value:''}).value.toLowerCase();
	var year = (document.getElementById('yearFilter')   || {value:'all'}).value;
	GRANTS_DATA.forEach(function(g) {
		var matchQ    = !q    || g.name.toLowerCase().indexOf(q) !== -1;
		var matchYear = year === 'all' || String(g.year) === year;
		if (matchQ && matchYear && SELECTED_GRANT_IDS.indexOf(g.id) === -1) {
			SELECTED_GRANT_IDS.push(g.id);
		}
	});
	renderGrantList();
}

function clearAllSelection() {
	SELECTED_GRANT_IDS = [];
	renderGrantList();
}

function updateCounter() {
	var el = document.getElementById('selectionCounter');
	if (el) el.textContent = SELECTED_GRANT_IDS.length + ' grant' + (SELECTED_GRANT_IDS.length !== 1 ? 's' : '') + ' selected';
}

function renderChips() {
	var container = document.getElementById('selectedSummary');
	if (!container) return;
	if (SELECTED_GRANT_IDS.length === 0) {
		container.innerHTML = '<span style="color:#aaa;font-size:12px;">No grants selected.</span>';
		return;
	}
	var map = {};
	GRANTS_DATA.forEach(function(g){ map[g.id] = g; });
	var html = '';
	SELECTED_GRANT_IDS.forEach(function(id) {
		var g = map[id];
		if (!g) return;
		html += '<span class="grant-chip">'
			+ escapeHtml(g.name) + (g.year ? ' (' + g.year + ')' : '')
			+ '<button type="button" onclick="removeChip(' + id + ')" title="Remove">&times;</button>'
			+ '</span>';
	});
	container.innerHTML = html;
}

function removeChip(grantId) {
	var idx = SELECTED_GRANT_IDS.indexOf(grantId);
	if (idx !== -1) SELECTED_GRANT_IDS.splice(idx, 1);
	renderGrantList();
	renderChips();
	updateCounter();
}

function escapeHtml(s) {
	return String(s)
		.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
		.replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

// ─── Populate hidden inputs before form submit ────────────────────────────
function populateNotificationHiddens() {
	var scopeEl = document.querySelector('input[name="scopeNotification"]:checked');
	var scope   = scopeEl ? scopeEl.value : 'all';

	var hiddenScope = document.getElementById('hidden_notification_scope');
	if (hiddenScope) hiddenScope.value = scope;

	var container = document.getElementById('hidden_grant_ids_container');
	if (container) {
		container.innerHTML = '';
		if (scope === 'specific') {
			SELECTED_GRANT_IDS.forEach(function(id) {
				var inp = document.createElement('input');
				inp.type  = 'hidden';
				inp.name  = 'grant_ids[]';
				inp.value = id;
				container.appendChild(inp);
			});
		}
	}
}

// ─── Init on DOM ready ────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
	var scopeEl = document.querySelector('input[name="scopeNotification"]:checked');
	if (scopeEl) toggleScope(scopeEl.value);
	renderGrantList();

	// Hook into the form submit to populate hidden fields first
	var form = document.querySelector('form[role="form"]');
	if (form) {
		form.addEventListener('submit', function() {
			populateNotificationHiddens();
		});
	}
});
</script>
<?php endif; ?>
