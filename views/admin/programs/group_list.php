            <div class="row" style="margin-top:20px">
                <div class="col-lg-12">
				  <form id="frm_manage" method="GET">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Group Name</th>
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
									<td><a href="<?php echo site_url('admin/programs/manage/'.$row->id) ?>"><?php echo $row->name ?></a></td>
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
				  </form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
