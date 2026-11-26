            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manage Staffs</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
				  <form id="frm_manage" method="GET">
					<div class="data-header clearfix form-inline">
						<div class="pull-left">
							<div id="frm-action" class="btn-group" role="group">
								<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action
									<span class="caret"></span>
								</button>
								<?php if(has_permission('staffs', 'delete')) { ?>
								<ul class="dropdown-menu">
									<li><a href="javascript:;" data-action="delete">Delete</a></li>
								</ul>
								<?php } ?>
								<input type="hidden" name="action" value="" disabled="disabled">
							</div>
						
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
						</div>
						<div class="pull-right">
							Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
							<?php if(has_permission('staffs', 'add')) { ?>
							<a href="<?php echo site_url('admin/staffs/add') ?>" class="btn btn-success btn-sm">
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
									<th <?php echo sorting_attribute('username', $sort_by, $sort) ?>>Username</th>
									<th <?php echo sorting_attribute('full_name', $sort_by, $sort) ?>>Full Name</th>
									<th <?php echo sorting_attribute('email', $sort_by, $sort) ?>>Email</th>
									<th <?php echo sorting_attribute('country_name', $sort_by, $sort) ?> class="text-center">Country</th>
									<th <?php echo sorting_attribute('role', $sort_by, $sort) ?> class="text-center">Role</th>
									<th <?php echo sorting_attribute('last_login', $sort_by, $sort) ?>>Last Login</th>
									<th width="150" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
							  <?php
							  if ($data)
							  {
								$no = $paging['start_row'];
								foreach($data as $row) {
									$country_name = $row->country_name;
									if ($country_name == '')
										$country_name = 'All';
								?>
								<tr>
									<td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->staff_id ?>"></td>
									<td><?php echo $no ?></td>
									<td><?php echo $row->username ?></td>
									<td><?php echo $row->full_name ?></td>
									<td><?php echo $row->email ?></td>
									<td><?php echo $country_name ?></td>
									<td><?php echo $row->role ? ucfirst($row->role) : '' ?></td>
									<td><?php echo $row->last_login ? date('d M Y H:i', strtotime($row->last_login)) : 'N/A' ?></td>
									<td class="text-center">
										<?php if(has_permission('staffs', 'edit')) { ?>
										<a href="<?php echo site_url('admin/staffs/edit/'.$row->staff_id) ?>" class="btn btn-primary btn-xs">
											<i class="fa fa-edit"></i> Edit
										</a>
										<?php } ?>
										<?php if(has_permission('staffs', 'delete')) { ?>
										<a href="<?php echo site_url('admin/staffs/delete/'.$row->staff_id) ?>" class="btn btn-danger btn-xs confirm-del">
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
						Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
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
