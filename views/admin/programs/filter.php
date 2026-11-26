            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">FILTER</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class="row" style="margin-bottom:20px;">
				<form id="bookForm" action="<?php echo base_url();?>admin/filtersearch/filtervalue/" role="form" method="POST" name="fombortom"  class="fombortom" style="border:none;margin-bottom: 0px;">
					<div class="form-group"  style="float:left;width: 100%;">
						<label class="col-xs-1 control-label">Field</label>
						<div class="col-xs-4">
							<select class="form-control" name="field[]" style=" ">
								<option value="1">Select Field</option>
									<?php
										
										if (isset($user_properties)) { 
											if ($user_fields) {
											foreach ($user_fields as $field => $label) { ?>
													<option value="ud_<?php echo $field;?>"><?php echo $label; ?></option>
											<?php 
												} 
											} 
										}
											
										?>
										<?php 
										if (isset($user_properties)) { 
											if ($user_properties) {
												foreach ($user_properties as $property_id => $up) {
											  ?>
												<option value="up_<?php echo $up->field_slug;?>"><?php echo $up->field_name; ?></option>
											  <?php
												}
											}
											
										} ?>
										
										<?php 
										//var_dump($program_properties_filter);
										if (isset($program_properties_filter)) { 
											if ($program_properties_filter) {
												foreach ($program_properties_filter as $property_id => $pp) {  ?>
													<option value="pp_<?php echo $pp->field_slug;?>"><?php echo $pp->field_name; ?></option>
												<?php
													}
											}
										}
									?>
							</select> 
						</div>
						<div class="col-xs-3">
							<select class="form-control" name="kriteria[]" style="">
								<option value="0">Kriteria</option>
								<option value="=">equal =</option>
								<option value=">">greater than ></option>
								<option value=">=">greater than or equal to >=</option>
								<option value="<">less than <</option>
								<option value="<=">less than or equal to <=</option>
								<option value="!=">not equal !=</option>
								<option value="containing">containing</option>
								<option value="not-containing">not containing</option>
								
								<?php /*<option value="equal">equal =</option>
								<option value="greater-than">greater than ></option>
								<option value="greater-than-or-equal">greater than or equal to >=</option>
								<option value="less-than">less than <</option>
								<option value="less-than-or-equal-to">less than or equal to <=</option>
								<option value="not-equal">not equal !=</option>
								<option value="containing">containing</option>
								<option value="not-containing">not containing</option>*/ ?>
							</select> 
						</div>
						<div class="col-xs-3">
							<input type="text" class="form-control" name="valuefilter[]" placeholder="Value" />
						</div>
						<div class="col-xs-1">
							<button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
						</div>
					</div>

					<!-- The template for adding new field -->
					<div class="form-group hide" id="bookTemplate"  style="float:left;width: 100%;">
						<div class="col-xs-4 col-xs-offset-1">
						
							<select class="form-control" name="field[]" style=" ">
								<option value="1">Select Field</option>
									<?php
										
										if (isset($user_properties)) { 
											if ($user_fields) {
											foreach ($user_fields as $field => $label) { ?>
													<option value="ud_<?php echo $field;?>"><?php echo $label; ?></option>
											<?php 
												} 
											} 
										}
											
										?>
							  
										<?php 
										if (isset($user_properties)) { 
											if ($user_properties) {
												foreach ($user_properties as $property_id => $up) {
											  ?>
												<option value="up_<?php echo $up->field_slug; ?>"><?php echo $up->field_name; ?></option>
											  <?php
												}
											}
											
										} ?>
										
										<?php 
										//var_dump($program_properties_filter);
										if (isset($program_properties_filter)) { 
											if ($program_properties_filter) {
												foreach ($program_properties_filter as $property_id => $pp) {  ?>
													<option value="pp_<?php echo $pp->field_slug;?>"><?php echo $pp->field_name; ?></option>
												<?php
													}
											}
										}
									?>
							</select> 
						</div>
						<div class="col-xs-3">
							<select class="form-control" name="kriteria[]" style="">
								<option value="0">Kriteria</option>
								<option value="=">equal =</option>
								<option value=">">greater than ></option>
								<option value=">=">greater than or equal to >=</option>
								<option value="<">less than <</option>
								<option value="<=">less than or equal to <=</option>
								<option value="!=">not equal !=</option>
								<option value="containing">containing</option>
								<option value="not-containing">not containing</option>
							</select> 
						</div>
						<div class="col-xs-3">
							<input type="text" class="form-control" name="valuefilter[]" placeholder="Value" />
						</div>
						<div class="col-xs-1">
							<button type="button" class="btn btn-danger removeButton"><i class="fa fa-minus"></i></button>
						</div>
					</div>

					<div class="form-group" style="padding-bottom:20px; width: 100%;">
						<div class="col-xs-5 col-xs-offset-1">
							<button type="submit" class="btn btn-success">Search</button>
						</div>
					</div>
		
					<input type="hidden" class="form-control" name="program_id" Value="<?php echo $program_id; ?>" />
				</form>
            </div>
			<?php /*
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
            </div> */ ?>
            <!-- /.row -->
			
			
            <!-- /.row -->
            <!-- /.row -->
