            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header"><?php echo $this->Program_model->name ?>
					<?php /*
						<a href="<?php echo site_url('admin/programs/download_excel') ?>/<?=$program_id?>/<?=$_GET['q']?>" class="btn btn-primary btn-sm pull-right">
							DOWNLOAD EXCEL
						</a>
					*/ ?>
					</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<?php /*
			<div class="row" >
				<div class="col-lg-6">
					<label style=" float: left;margin-right: 20px;">Import Data: </label>
					<form action="<?php echo base_url();?>admin/Excel/upload/<?=$this->Program_model->id?>" role="form" method="POST" name="fombortom" enctype='multipart/form-data'  class="fombortom" style="border:none;margin-bottom: 0px;">
						<input type="file" name="file" style="float:left;" />
						<input type="submit" value="Upload file" class="btn btn-success btn-sm" id="uplodes"/>
					</form>
				</div>
				<div class="col-lg-6" style="text-align:right;">
					<a href="<?php echo site_url('admin/programs/filter/'.$this->Program_model->id) ?>" class="btn btn-success btn-xs" style="padding:5px 10px;">
						<i class="fa fa-search"></i> Advance Fillter
					</a>
					<a href="<?php echo site_url('admin/programs/download_csvpr/'.$this->Program_model->id) ?>" class="btn btn-success btn-xs" style="padding:5px 10px;">
						<i class="fa fa-download"></i> Export Data
					</a>
				</div>
				</hr>
            </div>
			*/ ?>
            <div class="row">
                <div class="col-lg-12">
				  <form id="frm_manage" method="GET">
					<div class="data-header clearfix form-inline" style="margin-bottom:20px;">
						<div class="pull-left">
							<div id="frm-action" class="btn-group" role="group">
								<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="javascript:;" data-action="delete">Delete</a></li>
									<?php
									/*
										foreach($isalumni as $ge) {	
										if($ge == 0){
											$gename ="Set Users as Grantee";
										}
										else{
											$gename ="Set Users as Alumny";
										}
										?>
										<li><a href="javascript:;" data-action="Set<?php echo $ge ?>"><?php echo $gename ?></a></li>
									<?php
										}
									*/
									?>
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
						<div class="col-lg-4" style="">
							<?php /* ?>
							<div class="form-group">
								<label>Set As</label>
								<select class="form-control" name="programs">
									<option value="">-- Select Set as --</option>
									<?php
										foreach($isalumni as $ge) {	
										if($ge == 0){
											$gename ="Set All Users as Grantee";
										}
										else{
											$gename ="Set All Users as Alumny";
										}
										?>
										<option value="<?php echo $ge ?>"><?php echo $gename ?></option>
									<?php
										}
									?>
								</select>
							</div>
							<?php */ ?>
							
							
						</div>
						
						<div class="pull-right">
							Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="">
							<?php /*
							<a href="<?php echo site_url('admin/programs/add_user/'.$this->Program_model->id) ?>" class="btn btn-success btn-sm">
								ADD NEW
							</a>
							*/ ?>
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
									<th <?php echo sorting_attribute('birth_place', $sort_by, $sort) ?>>POB</th>
									<th <?php echo sorting_attribute('birth_date', $sort_by, $sort) ?>>DOB</th>
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
									
									$format = 'ID';
									if ($country_id == '2')
										$format = 'US';
									$fullname = $this->User_model->get_full_name($row, $format);
								?>
								<tr>
									<td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
									<td><?php echo $no ?></td>
									<td><?php echo $fullname ?></td>
									<td><?php echo $row->email ?></td>
									<td><?php echo $row->birth_place ?></td>
									<td nowrap><?php echo $row->birth_date ? date('d M Y', strtotime($row->birth_date)) : '' ?></td>
									<td><?php echo $this->Program_model->name ?></td>
									<td class="text-center" style="position:relative;">
										<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-gear fa-fw"></i>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="<?php echo site_url('admin/alumni/edit/'.$row->id) ?>">Edit</a></li>
											<li><a href="<?php echo site_url('admin/alumni/available_program/'.$row->id) ?>">Grants</a></li>
											<li><a href="<?php echo site_url('admin/alumni/delete/'.$row->id) ?>">Delete</a></li>
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
						Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo number_format($paging['total_rows']) ?> entries
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
