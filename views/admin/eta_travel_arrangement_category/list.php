<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manage ETA Travel Categories</h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<form id="frm_manage" method="GET">
			<div class="data-header clearfix form-inline">
				<div class="pull-left">
					<div id="frm-action" class="btn-group" role="group">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							Action
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="javascript:;" data-action="delete">Delete</a></li>
						</ul>
						<input type="hidden" name="action" value="" disabled="disabled">
					</div>

					Show :
					<select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
						<?php
						foreach ($limit_options as $lo) {
							$selected = '';
							if ($lo == $paging['limit'])
								$selected = 'selected';
							?>
							<option value="<?php echo $lo ?>" <?php echo $selected ?>>
								<?php echo $lo ?>
							</option>
						<?php } ?>
					</select>
					entries
				</div>
				<div class="pull-right">
					Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>"
						placeholder="">
					<a href="<?php echo site_url('admin/eta_travel_arrangement_category/add') ?>" class="btn btn-success btn-sm">
						ADD NEW
					</a>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="30"><input type="checkbox" class="chk-all"></th>
							<th width="35" class="text-center">#</th>
							<th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>NAME</th>
							<th <?php echo sorting_attribute('type', $sort_by, $sort) ?>>TYPE</th>
							<th width="80" class="text-center">STATUS</th>
							<th width="150" class="text-center">ACTION</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($data) {
							$no = $paging['start_row'];
							foreach ($data as $row) {
								?>
								<tr>
									<td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
									<td><?php echo $no ?></td>
									<td><?php echo htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8') ?></td>
									<td>
										<span class="label label-<?php echo $row->type === 'international' ? 'primary' : ($row->type === 'domestic' ? 'info' : 'warning') ?>">
											<?php echo ucfirst($row->type) ?>
										</span>
									</td>
									<td class="text-center">
										<?php if ($row->active): ?>
											<span class="label label-success">Active</span>
										<?php else: ?>
											<span class="label label-default">Inactive</span>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<a href="<?php echo site_url('admin/eta_travel_arrangement_category/edit/' . $row->id) ?>"
											class="btn btn-primary btn-xs">
											<i class="fa fa-edit"></i> Edit
										</a>
										<a href="<?php echo site_url('admin/eta_travel_arrangement_category/delete/' . $row->id) ?>"
											class="btn btn-danger btn-xs confirm-del">
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
			<div class="pull-left">
				Showing
				<?php echo $paging['start_row'] ?> to
				<?php echo $paging['end_row'] ?> of
				<?php echo $paging['total_rows'] ?> entries
			</div>
			<?php echo $paging['html'] ?>
			<input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
			<input type="hidden" name="sort" value="<?php echo $sort ?>">
		</form>
	</div>
</div>
