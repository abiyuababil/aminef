
<style>
    .select2-container .select2-selection {
        max-height: 60px;
        overflow: auto;
    }

    .data-header {
        padding-top: 10px !important;
    }

    .program-filter-section {
        display: flex;
    }

    .program-filter-section > .form-group {
        width: 350px;
        margin-left: 12px;
    }

    .select2-container--bootstrap .select2-selection {
        border-radius: 0px !important;
    }

    .select2-selection--single > .select2-selection__rendered {
        margin-top: 5px !important;
    }

    .select2-selection--single {
        overflow: hidden !important;
    }

    label {
        font-weight: normal !important;
    }
</style>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manage Mentoring Types Essays</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<form id="frm_manage" method="GET">
            <div class="row mb-4 program-filter-section">
                <div class="form-group select-program">
                    <label>Program</label>
                    <select class="form-control select2" id="filter-program" name="program_ids[]" multiple>
                        <?php 
                            $program_ids = isset($_GET['program_ids']) ? (array) $_GET['program_ids'] : [];
                        ?>
						<option value="0">All</option>
                        <?php foreach($program_available as $program) { ?>
                            <option 
								value="<?php echo $program->id; ?>" 
								<?= (!empty($program_ids) && is_array($program_ids) && in_array($program->id, $program_ids)) ? 'selected' : '' ?>
							>
								<?php echo $program->name; ?>
							</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
			<div class="data-header clearfix form-inline">

				<div class="pull-left">
					<a href="<?= base_url('admin/mentoring_types/sort') ?>" class="btn btn-info btn-sm">
						<i class="fa fa-arrows"></i> SORTING
					</a> 
					<div id="frm-action" class="btn-group" role="group">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							Action
							<span class="caret"></span>
						</button>
						<?php if(has_permission('mentoring_type_essays', 'delete')) { ?>
						<ul class="dropdown-menu">
							<li><a href="javascript:;" data-action="delete">Delete</a></li>
						</ul>
						<?php } ?>
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
						placeholder="" onkeypress="return submitFilter(event)">
					<?php if(has_permission('mentoring_type_essays', 'add')) { ?>
					<a href="<?php echo site_url('admin/mentoring_types/add') ?>" class="btn btn-success btn-sm">
						ADD NEW
					</a>
					<?php } ?>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="30"><input type="checkbox" class="chk-all"></th>
							<th width="35" class="text-center">#</th>
							<th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>MENTORING TYPE</th>
							<th <?php echo sorting_attribute('grant_id', $sort_by, $sort) ?>>GRANT</th>
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
									<td>
										<?php echo $no ?>
									</td>
									<td>
										<?php echo $row->name ?>
									</td>
									<td>
										<?php echo $row->grant_name ?? 'All'  ?>
									</td>
									<td class="text-center">
										<?php if(has_permission('mentoring_type_essays', 'edit')) { ?>
										<a href="<?php echo site_url('admin/mentoring_types/edit/' . $row->id) ?>"
											class="btn btn-primary btn-xs">
											<i class="fa fa-edit"></i> Edit
										</a>
										<?php } ?>
										<?php if(has_permission('mentoring_type_essays', 'delete')) { ?>
										<a href="<?php echo site_url('admin/mentoring_types/delete/' . $row->id) ?>"
											class="btn btn-danger btn-xs confirm-del">
											<i class="fa fa-times-circle"></i> Delete
										</a>
										<?php } ?>
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
			<!-- /.table-responsive -->
			<div class="pull-left">
				Showing
				<?php echo $paging['start_row'] ?> to
				<?php echo $paging['end_row'] ?> of
				<?php echo $paging['total_rows'] ?> entries
			</div>
			<!-- /.pagination info -->
			<?php echo $paging['html'] ?>
			<!-- /.pagination -->
			<input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
			<input type="hidden" name="sort" value="<?php echo $sort ?>">
		</form>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<script>
	
	function submitFilter(e) {
		if (e.keyCode == 13) {
			$('#loading_data').css('display', 'block');
			$('#frm_manage').submit();
			return false;
		}
	}
</script>