            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manage Users</h1>
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
								<ul class="dropdown-menu">
									<li><a href="javascript:;" data-action="delete">Delete</a></li>
								</ul>
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
							<a href="<?php echo site_url('admin/users/add') ?>" class="btn btn-success btn-sm">
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
									<th <?php echo sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
									<th <?php echo sorting_attribute('email', $sort_by, $sort) ?>>Email</th>
									<th <?php echo sorting_attribute('birth_place', $sort_by, $sort) ?>>Place of Birth</th>
									<th <?php echo sorting_attribute('birth_date', $sort_by, $sort) ?>>Date of Birth</th>
									<th <?php echo sorting_attribute('passport_number', $sort_by, $sort) ?>>P Number</th>
									<th class="text-center">Programs</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
							  <?php
							  if ($data)
							  {
								$no = $paging['start_row'];
								foreach($data as $row) {
									$join_program = '';
									if (isset($user_programs[$row->id]))
									{
										foreach ($user_programs[$row->id] as $up)
										{
											//echo'<pre>';var_dump($up);exit;
											if (isset($programs[$up->program_id]))
												$join_program .= '<a href="'.site_url('admin/programs/list_users/'.$row->id.'/'.$programs[$up->program_id]->id).'" target="_blank">'.$programs[$up->program_id]->name.'</a><br>';
										}
									}
									
									$full_name = $this->User_model->get_full_name($row);
								?>
								<tr>
									<td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
									<td><?php echo $no ?></td>
									<td><?php echo $full_name ?></td>
									<td><?php echo $row->email ?></td>
									<td><?php echo $row->birth_place ?></td>
									<td><?php echo $row->birth_date ? date('d M Y', strtotime($row->birth_date)) : '' ?></td>
									<td><?php echo $row->passport_number ?></td>
									<td><?php echo $join_program ?></td>
									<td class="text-center" style="position:relative;">
										<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-gear fa-fw"></i>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="<?php echo site_url('admin/users/edit/'.$row->id) ?>">Edit</a></li>
											<?php /*
											<li><a href="<?php echo site_url('admin/users/detail/'.$row->id) ?>">Detail</a></li>
											*/ ?>
											<li><a href="<?php echo site_url('admin/users/available_program/'.$row->id) ?>">Programs</a></li>
											<li><a href="<?php echo site_url('admin/users/delete/'.$row->id) ?>">Delete</a></li>
										</ul>
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
