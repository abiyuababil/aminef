            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">Manage Active Grants</h1>
					<?php $error = $this->session->flashdata('cant_delete_grants');  ?>
					<?php if (isset($error)) : ?>
						<div class="alert alert-danger">Cant delete grants, cause there is active grantee using this grants!</div>
					<?php endif; ?>
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
								<!-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action
									<span class="caret"></span>
								</button> -->
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
							<a href="<?php echo site_url('admin/user_grantee_grant/add') ?>" class="btn btn-success btn-sm">
								ADD NEW
							</a>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th width="35" class="text-center">#</th>
									<th>Fiscal Year</th>
									<th>Report Result</th>
								</tr>
							</thead>
							<tbody>
							  <?php
							  if ($data)
							  {
								$no = 1;
								foreach($data as $row) {
								?>
								<tr>
									<td><?php echo $no ?></td>
									<td><?php echo $row->fiscal_year ?></td>
                                    <td>
                                        <?php foreach($category_report as $cr ) { ?>
                                            <a href="<?= base_url('admin/user_grantee_grant/view_result_period/'.$cr->user_grantee_grant_id.'/'.$row->fiscal_year.'/'.$cr->id.'') ?>" target="_blank" class="btn btn-warning btn-xs"><?= $cr->name ?></a>
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
