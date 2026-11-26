          <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header">FILTER RESULT</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class="form-group"  style="float:left;width: 100%;margin-bottom:40px;">
			<?php 
			if (isset($filter_input)) { 
				//echo "<pre>";
				//print_r($filter_input);
								
				if (!is_numeric($filter_input)){
					foreach ($filter_input['field'] as $index => $filterinput) {
						
						if($filter_input['field'][$index]){
						
						$varfields = $filter_input['field'][$index];
						if (!is_numeric($varfields)){
							
						$varfield = explode('_', $varfields);
						?>
						<div class="form-group"  style="float:left;width: 100%;">
							<label class="col-xs-1 control-label">Field</label>
							<div class="col-xs-4">
								<select class="form-control" name="field[]" style=" ">
									<option value="1">Select Field</option>
										<?php
											$selected = '';
											if (isset($user_properties)) { 
												if ($user_fields) {
													foreach ($user_fields as $field => $label) {

														if($field == $varfield[1]){
															$selected = "selected";
														}
														else {
															$selected = "";
														}
														?>
															<option value="ud_<?php echo $field;?>" <?php echo $selected; ?>><?php echo $label; ?></option>
													<?php 
														
													} 
												} 
											}
												
											?>
											<?php 
											if (isset($user_properties)) { 
												if ($user_properties) {
													foreach ($user_properties as $property_id => $up) {
														if($up->field_slug == $varfield[1]){
															$selected = "selected";
														}
														else {
															$selected = "";
														}
												  ?>
													<option value="up_<?php echo $up->field_slug;?>" <?php echo $selected; ?>><?php echo $up->field_name; ?></option>
												  <?php
													}
												}
												
											} ?>
											
											<?php 
											//var_dump($program_properties_filter);
											if (isset($program_properties_filter)) { 
												if ($program_properties_filter) {
													foreach ($program_properties_filter as $property_id => $pp) {  
														if($pp->field_slug == $varfield[1]){
															$selected = "selected";
														}
														else {
															$selected = "";
														}
													?>
														<option value="pp_<?php echo $pp->field_slug;?>" <?php echo $selected; ?>><?php echo $pp->field_name; ?></option>
													<?php
														}
												}
											}
										?>
								</select> 
							</div>
							
						<?php }
						}
						if ($filter_input['kriteria'][$index]) { 
						
							$kriteria = $filter_input['kriteria'][$index];
						?>
						
							<div class="col-xs-4">
								<select class="form-control" name="kriteria[]" style="">
									<option value="0">Kriteria</option>
									<option value="=" <?php if ($kriteria == "=" ){ echo "selected";}?>>equal =</option>
									<option value=">" <?php if ($kriteria == ">" ){ echo "selected";}?>>greater than ></option>
									<option value=">=" <?php if ($kriteria == ">=" ){ echo "selected";}?>>greater than or equal to >=</option>
									<option value="<" <?php if ($kriteria == "<" ){ echo "selected";}?>>less than <</option>
									<option value="<=" <?php if ($kriteria == "<=" ){ echo "selected";}?>>less than or equal to <=</option>
									<option value="!=" <?php if ($kriteria == "!=" ){ echo "selected";}?>>not equal !=</option>
									<option value="containing" <?php if ($kriteria == "containing" ){ echo "selected";}?>>containing</option>
									<option value="not-containing" <?php if ($kriteria == "not-containing" ){ echo "selected";}?>>not containing</option>
								</select> 
							</div>
							
						<?php 						
						}
						if ($filter_input['valuefilter'][$index]){ ?>
							<div class="col-xs-3">
								<input type="text" class="form-control" name="valuefilter[]" value="<?php echo $filter_input['valuefilter'][$index]; ?>" />
							</div>
						</div>
						<?php 						
						}
						//echo $filter_input['field'][$index]."-".$filter_input['kriteria'][$index]."-".$filter_input['valuefilter'][$index]."<br>";
						//print_r($filterinput['kriteria']);
						
					}
				}
			}
			else { ?>	
			<div class="form-group"  style="float:left;width: 100%;">
				<label class="col-xs-1 control-label">Field</label>
				<div class="col-xs-4">
					<select class="form-control" name="field[]" style=" ">
						<option value="1">Select Field</option>
							<?php
								$selected = '';
								if (isset($user_properties)) { 
									if ($user_fields) {
										foreach ($user_fields as $field => $label) { 
											
											?>
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
										<option value="up_<?php echo $up->field_slug;?>" ><?php echo $up->field_name; ?></option>
									  <?php
										}
									}
									
								} ?>
								
								<?php 
								//var_dump($program_properties_filter);
								if (isset($program_properties_filter)) { 
									if ($program_properties_filter) {
										foreach ($program_properties_filter as $property_id => $pp) {  

										?>
											<option value="pp_<?php echo $pp->field_slug;?>" ><?php echo $pp->field_name; ?></option>
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
				</div>
			</div>
			<?php } ?>		
			<form id="bookForm" action="<?php echo base_url();?>admin/filtersearch/setfilter/" role="form" method="POST" name="fombortom"  class="fombortom" style="border:none;margin-bottom: 0px;">

			<?php
			if (isset($data_filter) && $data_filter != '') {
			?>
			<!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
	
						<div class="table-responsive" style="margin-top:20px;">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th width="30"><input type="checkbox" class="chk-all"></th>
										<th width="35" class="text-center">#</th>
										<th <?php echo sorting_attribute('name', $sort_by, $sort) ?>>Name</th>
										<th <?php echo sorting_attribute('gender', $sort_by, $sort) ?>>passport Number</th>
										<th <?php echo sorting_attribute('email', $sort_by, $sort) ?>>Email</th>
										<th <?php echo sorting_attribute('phone_mobile', $sort_by, $sort) ?>>Phone Mobile</th>
										<?php 
										if (isset($filter_input)) { 	
											if (!is_numeric($filter_input)){
												foreach ($filter_input['field'] as $index => $filterinput) {
													if($filter_input['field'][$index]){
														$varfields 	= $filter_input['field'][$index]; 
														$fo_val 	= explode('_', $varfields);
														if (!is_numeric($fo_val[0])){
														?>
															<th style="text-transform:capitalize;" class="text-center"><?php echo $fo_val[1];?></th>
													<?php
														}
													}
												}
											}
										}
										?>
									</tr>
								</thead>
								<tbody>
								<?php
								  if ($data_filter)
								  {
									$no = $paging['start_row'];
									foreach($data_filter as $row) {
									?>
									<tr>
										<td><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
										<td><?php echo $no ?></td>
										<td><?php echo $row->name ?></td>
										<td><?php echo $row->passport_number ?></td>
										<td><?php echo $row->email ?></td>
										
										<td><?php echo $row->phone_mobile ?></td>
										<?php 
										if (isset($filter_input)) { 		
											foreach ($filter_input['field'] as $index => $filterinput) {
												if($filter_input['field'][$index]){
													$varfields 	= $filter_input['field'][$index]; 
													$fo_val 	= explode('_', $varfields);
													
													
													if (isset($fo_val[0])) {
														if ($fo_val[0] == "ud") {
															if (isset($fo_val[1])) {?>
																<td><?php echo $row->$fo_val[1];?></td>	
															<?php
															}
														}
														if ($fo_val[0] == "up") {
															if (isset($fo_val[1])) {
																if ($fo_val[1] == $row->upv_fieldslug){ ?>
																	<td><?php echo $row->upv_value;?></td>
															<?php
																}
															}
														}
														if ($fo_val[0] == "pp") {
															if (isset($fo_val[1])) {
																if ($fo_val[1] == $row->upp_fieldslug){ ?>
																	<td><?php echo $row->upp_value;?></td>
															<?php
																}
															}
														}
													}
												}
											}
										}
										?>
									</tr>
									<input type="hidden" name="user_id[]" value="<?php echo $row->user_id ?>">
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
						<input type="hidden" class="form-control" name="program_id" Value="<?php echo $row->program_id; ?>" />
                </div>
                <!-- /.col-lg-12 -->
            </div>
		  <?php } else 
			{ ?>
			<div class="row">
                <div class="col-lg-12">
					<h3> DATA NOT FOUND 	</h3>
				</div>
			</div>
		   <?php } ?>
			<div class="row " style="margin-bottom:20px;margin-top:30px;">				
				<div class="form-group col-xs-12"  style="float:left;width: 100%;">
					<label class="col-xs-1 control-label">Field</label>
					<div class="col-xs-4">
						<select class="form-control" name="fieldsetfilter[]" style=" ">
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
						<input type="text" class="form-control" name="set_value" placeholder="Value" />
					</div>
					<div class="col-xs-1">
						<button type="submit" class="btn btn-success">SET VALUE</button>
					</div>
				</div>

				<!-- The template for adding new field -->

				</div>
				
			</form>