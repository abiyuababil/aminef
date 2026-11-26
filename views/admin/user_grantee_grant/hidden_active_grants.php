<div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">Manage Hidden Active Grants</h1>
					<?php 
						$error = $this->session->flashdata('cant_delete_grants');   
						$this->session->unset_userdata('cant_delete_grants');
					?>
					<?php if (isset($error)) : ?>
						<div class="alert alert-danger">Cant delete grants, cause there is active grantee using this grants!</div>
					<?php endif; ?>
					<?php if ($this->session->flashdata('info')) { ?>
						<div class="alert alert-success"><?php echo $this->session->flashdata('info'); ?></div>
					<?php } ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
				  <form id="frm_manage" method="GET">
					<div class="data-header clearfix form-inline">
						<div class="pull-left">
							<!-- <div id="frm-action" class="btn-group" role="group">
								<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="javascript:;" data-action="delete">Delete</a></li>
								</ul>
								<input type="hidden" name="action" value="" disabled="disabled">
							</div> -->
						
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
							Year : 
							<select class="form-control input-sm" name="year" onchange="document.forms.frm_manage.submit()">
								<option value="all">All</option>
							<?php for ($i = date('Y') + 5; $i > 1900; $i--) : ?>
								<?php
								$selected = '';
								$year = isset($paging['year']) ? $paging['year'] : date('Y');
								if ($i == $year) {
									$selected = 'selected';
								}
								?>
								<option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
							<?php endfor; ?>
							</select> 
							Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
							<a href="<?php echo site_url('admin/user_grantee_grant/add') ?>" class="btn btn-success btn-sm">
								Create New Grant
							</a>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<!-- <th width="30"><input type="checkbox" class="chk-all"></th> -->
									<th width="35" class="text-center">#</th>
									<th>Grant</th>
									<th>Category Type</th>
									<th>Year</th>
									<th width="50">Status</th>
									<th width="<?= get_active_country(true) == AMERICAN_DATABASE ? 600 : 300 ?>" class="text-right">Action</th>
								</tr>
							</thead>
							<tbody>
							  <?php
							  if ($data)
							  {
								$no = $paging['start_row'];
								foreach($data as $row) {
								?>
								<tr>
									<!-- <td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td> -->
									<td><?php echo $no ?></td>
									<td><?php echo $row->name ?></td>
									<td><?php echo label_category_type($row->category_grant) ?></td>
									<td><?php echo $row->year ?></td>
									<td>
                                        <?php 
                                            if($row->is_active == 1){
                                                echo '<span class="badge badge-success">Active</span>';
                                            }else if($row->is_active == 0){
                                                echo '<span class="badge">Inactive</span>';
                                            }
                                        ?>
                                    </td>

									<td class="text-right">
										<?php if (get_active_country(true) == INDONESIAN_DATABASE) : ?>
											<button type="button" class="btn btn-info btn-xs dropdown-toggle"
													data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="fa fa-gear fa-fw"></i> List
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-menu-right" <?= get_active_country(true) == INDONESIAN_DATABASE ? 'style="right: 145px;top: auto;left: auto;"' : '' ?>>
												<?php if($this->User_grantee_grants_model->active_cid == 1){ ?>
													<li>
														<a href="<?php echo site_url('admin/user_grantee_grant/period/'.$row->id) ?>">List Period</a>
													</li>
												<?php } ?>
												<li>
													<a href="<?php echo site_url('admin/user_grantee_grant/category/'.$row->id) ?>">List Category</a>
												</li>
												<?php if($this->User_grantee_grants_model->active_cid == 2){ ?>
													<li>
														<a href="<?php echo site_url('admin/user_grantee_grant/report_result/'.$row->id) ?>">List Report Result</a>
													</li>
												<?php } ?>
												<li>
													<a href="<?php echo site_url('admin/user_grantee_grant/category_report/'.$row->id) ?>">List Category Report</a>
												</li>
												
												<?php if(get_active_country(true) == INDONESIAN_DATABASE) { ?>
												<!-- <li>
													<a href="<?php echo site_url('admin/user_grantee_grant/payment_grant/'.$row->id) ?>">List Payment Record	</a>
												</li> -->
												<?php } ?>
												<li>
													<a href="<?php echo site_url('admin/user_grantee_grant/copy_grant/'.$row->id) ?>">Copy Active Grant</a>
												</li>
												<li>
													<a href="<?php echo site_url('admin/user_grantee_grant/submission_log/'.$row->id) ?>">Submission Log</a>
												</li>
												<li>
													<a href="<?php echo site_url('admin/user_grantee_grant/sorting_pdf_documents/'.$row->id) ?>">Sorting Documents (PDF)</a>
												</li>
											</ul>
											<a href="<?php echo site_url('admin/user_grantee_grant/report_payment/'.$row->id) ?>" class="btn btn-success btn-xs">
												<i class="fa fa-file-text"></i> Report
											</a>

											<a href="<?php echo site_url('admin/user_grantee_grant/edit/'.$row->id) ?>" class="btn btn-primary btn-xs">
												<i class="fa fa-edit"></i> Edit
											</a>

											<a href="<?php echo site_url('admin/user_grantee_grant/delete/'.$row->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs">
												<i class="fa fa-times-circle"></i> Delete
											</a>

										<?php else: ?>
											<a class="btn btn-info btn-xs" href="<?php echo site_url('admin/user_grantee_grant/category/'.$row->id) ?>"> <i class="fa fa-edit"></i> Manage Content</a>

											<?php if(has_permission('active_grants', 'edit')) { ?>
											<a href="<?php echo site_url('admin/user_grantee_grant/edit/'.$row->id) ?>" class="btn btn-primary btn-xs">
												<i class="fa fa-gear fa-fw"></i> Setting
											</a>
											<?php } ?>

											<button type="button" class="btn btn-others-dropdown btn-xs dropdown-toggle"
													data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Other
												<span class="caret"></span>
											</button>
											
											<ul class="dropdown-menu dropdown-menu-right dropdown-menu-custom" style="right: 20px;top: auto;left: auto;">	
												<?php if(has_permission('active_grants', 'payment_non_grantee')) { ?>										
												<li class="dropdown-header">Payment & Finance</li>
												<li>
													<a class="dropdown-item" href="<?php echo site_url('admin/user_grantee_grant/payment_grant/'.$row->id) ?>">
														<i class="fa fa-list"></i> List Payment
													</a>
												</li>
												<li>
													<a class="dropdown-item" href="<?php echo site_url('admin/user_grantee_grant/report_payment/'.$row->id) ?>">
														<i class="fa fa-money"></i> Payment Report
													</a>
												</li>
												<?php } ?>

												<li><hr class="dropdown-divider my-1"></li>
												<li class="dropdown-header">Tracking & Utilities</li>
												<li>
													<a class="dropdown-item" href="<?php echo site_url('admin/user_grantee_grant/submission_log/'.$row->id) ?>">
														<i class="fa fa-history"></i> Submission Log
													</a>
												</li>
												<?php if(has_permission('active_grants', 'copy_active_grant')) { ?>
												<li>
													<a class="dropdown-item" href="<?php echo site_url('admin/user_grantee_grant/copy_grant/'.$row->id) ?>">
														<i class="fa fa-copy"></i> Copy Active Grant
													</a>
												</li>
												<?php } ?>
												<?php if(has_permission('active_grants', 'hide_grant')) { ?>
												<li>
													<a class="dropdown-item" href="<?php echo site_url('admin/user_grantee_grant/change_visibility/' . $row->id); ?>/1" onclick="return confirm('Are you sure you want to unhide this grant?');">
														<i class="fa fa-eye"></i> Unhide
													</a>
												</li>
												<?php } ?>

												<?php if(has_permission('active_grants', 'delete')) { ?>
												<li><hr class="dropdown-divider my-1"></li>
												<li>
													<a class="dropdown-item text-danger" style="color:#a94442 !important;" href="<?php echo site_url('admin/user_grantee_grant/delete/'.$row->id) ?>" onclick="return confirm('Are you sure want to delete this data?')">
														<i class="fa fa-trash text-danger" style="color:#a94442 !important;"></i> Delete Grant
													</a>
												</li>
												<?php } ?>
											</ul>
										<?php endif; ?>
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
<?php $this->session->set_flashdata('info', false); ?>