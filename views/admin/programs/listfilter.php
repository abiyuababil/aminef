
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<form id="frm_manage" method="GET">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th width="30"><input type="checkbox" class="chk-all"></th>
										<th width="35" class="text-center">#</th>
										<th width="80" <?php echo sorting_attribute('gender', $sort_by, $sort) ?>>Gender</th>
										<th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Name</th>
										<th <?php echo sorting_attribute('birth_place', $sort_by, $sort) ?>>Place of Birth</th>
										<th <?php echo sorting_attribute('birth_date', $sort_by, $sort) ?>>Date of Birth</th>
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
										<td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->user_id ?>"></td>
										<td><?php echo $no ?></td>
										<td><?php echo $row->gender ?></td>
										<td><?php echo $row->name ?></td>
										<td><?php echo $row->birth_place ?></td>
										<td><?php echo date('d M Y', strtotime($row->birth_date)) ?></td>
										
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
						
						<input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
						<input type="hidden" name="sort" value="<?php echo $sort ?>">
				  </form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
