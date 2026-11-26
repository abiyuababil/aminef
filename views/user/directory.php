            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Alumni Directory : <?php echo $nationality ?></h1>
	
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
									
            <div class="row" style="margin-bottom:30px;">
                <div class="col-lg-12">
				<form id="frm_manage" method="GET" class="form-inline">
				  <div class="panel panel-default">
				  <div class="panel-body" style="background: #e7e7e7;border-radius: 7px;">
					<div class="col-lg-12" style="margin-bottom:10px;padding-left:0px;">
						<div class="form-group">
							<label style="width:75px">Search By</label>
							<select class="form-control" name="search_by">
							<?php
							foreach ($filters as $field => $val) {
								$selected = '';
								if (isset($params['search_by']) && $params['search_by'] == $field)
									$selected = 'selected="selected"';
							?>
								<option value="<?php echo $field ?>" <?php echo $selected; ?>><?php echo $val ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="form-group m-no-margin" style="margin-left:20px">
							<label>Keyword</label>
							<input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
						</div>
					</div>
					<div class="col-lg-12" style="margin-bottom:10px;padding-left:0px;">
						<div class="form-group">
							<label style="width:75px">Grants</label>
							<select class="form-control" name="program_id">
								<option value="">-- All Grants --</option>
								<?php
								foreach($program_all as $name) {
								$selected = '';
								if ($program_id == $name->id)
									$selected = 'selected="selected"';
								?>
								  <option value="<?php echo $name->id; ?>" <?php echo $selected; ?>><?php echo $name->name; ?></option>
							  <?php
								} ?>
							</select>
						</div>
						<div class="form-group m-no-margin" style="margin-left:20px">
							<label>Year</label>
							<select class="form-control" name="year">
								<option value="">-- All Years --</option>
								<?php
								foreach($years as $yr) {
								$selected = '';
								if (!empty($year) && $year == $yr->year)
									$selected = 'selected="selected"';
								?>
								  <option value="<?php echo $yr->year; ?>" <?php echo $selected; ?>><?php echo $yr->year; ?></option>
							  <?php
								} ?>
							</select>
						</div>
					</div>
					<div class="col-lg-12" style="padding-left:0px;">
						<div class="form-group">
							<button type="submit" class="btn btn-success" style="background-color:#EE3424; border-color:#EE3424;">Search</button>
						</div>
					</div>
				  </div>
				  </div>
					
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
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
							  <?php
							  $home_ins_title = 'Institution the grantee was affiliated with';
							  $host_ins_title = 'Indonesian institution where the grantee held affiliation';
							  $year_title = 'fiscal year grantee receives his/her grant';
							  if ($nationality == 'Indonesian')
							  {
								  $home_ins_title = 'Institution the grantee was affiliated with';
								  $host_ins_title = 'U.S. institution where the grantee obtained their degree or held affiliation';
								  $year_title = 'fiscal year when grantee receives their grant';
							  }
							  ?>
								<tr>
									<th width="35" class="text-center">#</th>
									<th <?php echo sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
									<th <?php echo sorting_attribute('study_field', $sort_by, $sort) ?>>Field of Study</th>
									<th <?php echo sorting_attribute('home_institution', $sort_by, $sort) ?>>Home Institution <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $home_ins_title ?>"></i></th>
									<th <?php echo sorting_attribute('host_institution', $sort_by, $sort) ?>>Host Institution <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $host_ins_title ?>"></i></th>
									<th class="text-center">Grants <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $year_title ?>"></i></th>
									<?php /*
									<th <?php echo sorting_attribute('date_modified', $sort_by, $sort) ?>>Updated</th>
									*/ ?>
									<th <?php echo sorting_attribute('of_department', $sort_by, $sort) ?>>Current Institution</th>
								</tr>
							</thead>
							<tbody>
							  <?php
							  if ($data)
							  {
								$no = $paging['start_row'];
								foreach($data as $row) {
									$completion_success = false;
									
									$join_program = '';
									if (isset($user_programs[$row->user_id]))
									{
										$user_program_compose = [];
										foreach ($user_programs[$row->user_id] as $up) {
											$program_name = $programs[$up->program_id]->name;
											$year_departure = $up->year_departure;
											$host_institution = $up->host_institution;
											if($nationality == 'american'){
												$sf_name = get_fos($up->study_field_id, $row->source_user);
											}else{
												$sf_name = $up->study_field_id ? get_fos($up->study_field_id, $row->source_user) : '-';
											}
											// $sf_name = $up->is_final_placement
											// 		? (!empty($up->study_field_id) ? get_fos($up->study_field_id, $row->source_user) : '')
											// 		: $up->study_field_input;

											$user_program_compose[] = array('program_name' => $program_name, 'year_departure' => $year_departure);
											}
											uasort($user_program_compose, function ($a, $b) {
											if ($a['year_departure'] == $b['year_departure']) {
												return 0;
											}
											return ($a['year_departure'] < $b['year_departure']) ? 1 : -1;
										});

										$join_program .= '<ul>';
										foreach ($user_program_compose as $upc)
										{
										//echo'<pre>';var_dump($up);exit;
										$year_departure = '';
										if ($upc['year_departure'])
										$year_departure = " ({$upc['year_departure']})";
										
										if (isset($upc['program_name']))
											$join_program .= '<li>'.$upc['program_name'].$year_departure.'</li>';
										
										if ($up->completion == 'Successful')
											$completion_success = true;
										}
                    					$join_program .= '</ul>';
									}
									
									$format = 'ID';
									if ($nationality == 'American')
										$format = 'US';
									$fullname = $this->User_model->get_full_name($row, $format);
									
									$current_institution = '';
									if ($row->of_department)
									{
										$tmp = explode("\n", $row->of_department);
										$current_institution = trim($tmp[0]);
									}
								?>
								<tr>
									<td><?php echo $no ?></td>
									<td>
										<a href="<?php echo site_url('alumny/detail/'.$row->user_id.'/'.url_title($fullname)) ?>">
										<?php echo $fullname ?>
										</a>
									</td>
									<td><?php echo $row->source_user == 2 && $nationality == 'Indonesian' ? $row->sf_name2 : $row->sf_name ?></td>
									<td><?php echo $row->home_institution ?></td>
									<td><?php echo $row->host_institution ?></td>
									<td><?php echo $join_program ?></td>
									<?php /*
									<td><?php echo $row->date_modified ? date('m/d/Y', strtotime($row->date_modified)) : '' ?></td>
									*/ ?>
									<td><?php echo $current_institution ?></td>
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
						Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo number_format($paging['total_rows']) ?> entries
					</div>
					<!-- /.pagination info -->
					<div class="pagination-wrap">
					<?php echo $paging['html'] ?>
					</div>
					<!-- /.pagination -->
					<input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
					<input type="hidden" name="sort" value="<?php echo $sort ?>">
					<div class="row">
					  <div class="col-lg-12">
						<a href="https://www.aminef.or.id/" class="btn btn-warning" style="background-color:#EE3424; border-color:#EE3424;">Back to Home</a>
					  </div>
					</div>
				  </form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
