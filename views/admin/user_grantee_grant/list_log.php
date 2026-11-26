            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">Submission Log</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
				  <form id="frm_manage" method="GET">
					<div class="data-header clearfix form-inline">
						<div class="pull-left">
							<div id="frm-action" class="btn-group" role="group">
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
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th width="35" class="text-center">#</th>
									<th>Update Date</th>
									<th>Before</th>
									<th>After</th>
									<th>Update By</th>
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
									<td><?= $no ?></td>
									<td><?= date('d M Y H:i:s', strtotime($row->update_date)) ?></td>
									<td>
                                        <table>
                                            <tr>
                                                <td>Name</td>
                                                <td width="5%">:</td>
                                                <td><?= $row->field_before ?></td>
                                            </tr>
                                            <tr>
                                                <td>Type</td>
                                                <td>:</td>
                                                <td><?= $row->type_before ?></td>
                                            </tr>
                                            <tr>
                                                <td>Option</td>
                                                <td>:</td>
                                                <td><?= implode(", ", json_decode($row->options_before)) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Column Option</td>
                                                <td>:</td>
                                                <td><?= implode(", ", json_decode($row->column_options_before)) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Is Require</td>
                                                <td>:</td>
                                                <td><?= $row->is_required_before == 0 ? 'FALSE' : 'TRUE' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Is Active</td>
                                                <td>:</td>
                                                <td><?= $row->is_active_before == 0 ? 'FALSE' : 'TRUE' ?></td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Property Id</td>
                                                <td>:</td>
                                                <td><?= $row->user_property_id_before ?></td>
                                            </tr> -->
                                            <tr>
                                                <td>Have Other</td>
                                                <td>:</td>
                                                <td><?= $row->have_other_before == 0 ? 'FALSE' : 'TRUE' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Basic Field</td>
                                                <td>:</td>
                                                <td><?= $row->basic_fields_before ?></td>
                                            </tr>
                                            <tr>
                                                <td>Available Alumni</td>
                                                <td>:</td>
                                                <td><?= $row->available_alumni_before ?></td>
                                            </tr>
                                            <tr>
                                                <td>Available Validation</td>
                                                <td>:</td>
                                                <td><?= $row->available_validation_before ?></td>
                                            </tr>
                                            <tr>
                                                <td>Validation for</td>
                                                <td>:</td>
                                                <td><?= $row->validation_for_before ?></td>
                                            </tr>
                                            <tr>
                                                <td>Note</td>
                                                <td>:</td>
                                                <td><?= $row->description_file_before ?></td>
                                            </tr>
                                            <tr>
                                                <td>Is Multiple</td>
                                                <td>:</td>
                                                <td><?= $row->is_multiple_before == 0 ? 'FALSE' : 'TRUE'?></td>
                                            </tr>
                                        </table>
                                    </td>
									<td>
                                        <table>
                                            <tr>
                                                <td>Name</td>
                                                <td width="5%">:</td>
                                                <td><?= $row->field_after ?></td>
                                            </tr>
                                            <tr>
                                                <td>Type</td>
                                                <td>:</td>
                                                <td><?= $row->type_after ?></td>
                                            </tr>
                                            <tr>
                                                <td>Option</td>
                                                <td>:</td>
                                                <td><?= implode(", ", json_decode($row->options_after)) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Column Option</td>
                                                <td>:</td>
                                                <td><?= implode(", ", json_decode($row->column_options_after)) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Is Require</td>
                                                <td>:</td>
                                                <td><?= $row->is_required_after == 0 ? 'FALSE' : 'TRUE' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Is Active</td>
                                                <td>:</td>
                                                <td><?= $row->is_active_after == 0 ? 'FALSE' : 'TRUE' ?></td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Property Id</td>
                                                <td>:</td>
                                                <td><?= $row->user_property_id_after ?></td>
                                            </tr> -->
                                            <tr>
                                                <td>Have Other</td>
                                                <td>:</td>
                                                <td><?= $row->have_other_after == 0 ? 'FALSE' : 'TRUE' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Basic Field</td>
                                                <td>:</td>
                                                <td><?= $row->basic_fields_after ?></td>
                                            </tr>
                                            <tr>
                                                <td>Available Alumni</td>
                                                <td>:</td>
                                                <td><?= $row->available_alumni_after ?></td>
                                            </tr>
                                            <tr>
                                                <td>Available Validation</td>
                                                <td>:</td>
                                                <td><?= $row->available_validation_after ?></td>
                                            </tr>
                                            <tr>
                                                <td>Validation for</td>
                                                <td>:</td>
                                                <td><?= $row->validation_for_after ?></td>
                                            </tr>
                                            <tr>
                                                <td>Note</td>
                                                <td>:</td>
                                                <td><?= $row->description_file_after ?></td>
                                            </tr>
                                            <tr>
                                                <td>Is Multiple</td>
                                                <td>:</td>
                                                <td><?= $row->is_multiple_after == 0 ? 'FALSE' : 'TRUE'?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td><?= $row->update_by ?></td>
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
