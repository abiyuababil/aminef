<div class="row">
	<div class="col-lg-12">
		<form id="frm_manage" method="GET">
			<div class="data-header clearfix form-inline">

				<div class="pull-left">
					<div id="frm-action" class="btn-group" role="group">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							Action
							<span class="caret"></span>
						</button>

						<?php if (has_permission('english_test_score', 'delete')) { ?>
							<ul class="dropdown-menu">
								<li>
									<a href="javascript:;" data-action="delete_english_test">Delete</a>
								</li>
							</ul>
						<?php } ?>

						<input type="hidden" name="action" value="" disabled="disabled">
					</div>

					Search :
					<input type="search"
						class="form-control input-sm"
						name="q"
						value="<?php echo $q; ?>"
						placeholder="e.g: BUSINESS">


					Show :
					<select class="form-control input-sm" name="limit"
						onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit['limit_options'] as $lo) {
                            $selected = '';
							if ($lo == $english_test_scores['paging']['limit']) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>

					</select>
					entries
				</div>

				<div class="pull-right">

                    <a class="btn btn-warning btn-sm"
                        data-toggle="modal"
                        data-target="#mdlLoadSofGrantee"
                        id="btnLoadSof">
                        Load Default Data
                    </a>

                    <a class="btn btn-primary btn-sm" 
                        data-toggle="modal"     
                        data-target="#mdlCopySofGrantee" 
                        id="btnCopy">
                        Copy from Another Period
                    </a>

					<?php if (has_permission('english_test_score', 'add')) { ?>
						<a href="<?php echo site_url('admin/user_grantee_grant/add_english_test_score/'.$grant_id. '/' . $period_id); ?>"
							class="btn btn-success btn-sm">
							ADD NEW
						</a>
					<?php } ?>
				</div>

			</div>

			<div class="table-responsive">
				<table class="table table-striped table-hover">

					<thead>
						<tr?>
							<th width="30"><input type="checkbox" class="chk-all"></th>
							<th width="35" class="text-center">#</th>
							<th <?php echo sorting_attribute('field_of_study', $sort_by, $sort); ?>>FIELD OF STUDY</th>
							<!-- <th>TOEFL (IIE)</th> -->
							<th>TOEFL ITP</th>
							<th>TOEFL iBT</th>
							<th>TOEFL iBT 1–6</th>
							<th>IELTS</th>
							<th>DUOLINGO / DET</th>
							<!-- <th>GRE</th> -->
							<th width="150">ACTION</th>
                        </tr>
					</thead>

					<tbody>

						<?php if ($english_test_scores['data']) {

							$no = $english_test_scores['paging']['start_row'];

							foreach ($english_test_scores['data'] as $row) {
						?>

								<tr>

									<td>
										<input type="checkbox"
											class="chk-row"
											name="ids[]"value="<?php echo $row->id; ?>"></td>
									<td class="text-center"><?php echo $no; ?></td>
									<td><?php echo $row->field_of_study; ?></td>
									<!-- <td><?php //echo $row->toefl_iie ?: '-'; ?></td> -->
									<td><?php echo $row->toefl_itp ?: '-'; ?></td>
									<td><?php echo $row->toefl_ibt ?: '-'; ?></td>
									<td><?php echo $row->toefl_ibt_1_6 ?: '-'; ?></td>
									<td><?php echo $row->ielts ?: '-'; ?></td>
									<td><?php echo $row->duolingo_det ?: '-'; ?></td>
									<!-- <td><?php //echo $row->gre ?: '-'; ?></td> -->
									<td>

										<?php if (has_permission('english_test_score', 'edit')) { ?>

											<a href="<?php echo site_url('admin/user_grantee_grant/edit_english_test_score/' . $grant_id . '/' . $period_id . '/' . $row->id); ?>"
												class="btn btn-primary btn-xs">
												<i class="fa fa-edit"></i>
												Edit
											</a>

										<?php } ?>

										<?php if (has_permission('english_test_score', 'delete')) { ?>

											<a href="<?php echo site_url('admin/user_grantee_grant/delete_english_test_score/' . $row->id); ?>"
												class="btn btn-danger btn-xs confirm-del">
												<i class="fa fa-times-circle"></i>
												Delete
											</a>

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
				Showing
				<?php echo $english_test_scores['paging']['start_row']; ?>
				to
				<?php echo $english_test_scores['paging']['end_row']; ?>
				of
				<?php echo $english_test_scores['paging']['total_rows']; ?>
				entries
			</div>

			<!-- /.pagination info -->

			<?php echo $english_test_scores['paging']['html']; ?>

			<!-- /.pagination -->

			<input type="hidden"
				name="sort_by"
				value="<?php echo $sort_by; ?>">

			<input type="hidden"
				name="sort"
				value="<?php echo $sort; ?>">

		</form>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="modal fade" id="mdlCopySofGrantee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Copy Field of Study</h2>
                <div id="info-grantee" style="font-size: 12px; color: #64748b; margin-top: 2px;text-align:center"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-3">
                    <div class="form-group col-sm-12">
                        <label>Period/Fiscal Year</label>
                        <select name="copy_period_id_sof" class="form-control" id="copy_period_id_sof">
                            <option value="">--Select Period--</option>
                                <?php
                                $current_year = date('Y', strtotime('+5 years'));
                                $limit_year = 1952;
                                for ($year = $current_year; $year >= $limit_year; $year--) {
                                    $selected = '';
                                    if ($up->year_departure == $year) {
                                        $selected = 'selected="selected"';
                                    }
                                    ?>
                                    <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                                <?php
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Source Program / Grant</label>
                        <select name="copy_grant_id_sof" class="form-control" id="copy_grant_id_sof">
                            <option value="">--Select Grant--</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <div class="source-info" id="sourceInfoBox" style="display: none;">
                            Found <strong><span id="sourceFosCount">0</span> FOS items</strong> in this source (<span id="sourceGrantName">-</span> - <span id="sourcePeriodName">-</span>).
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label style="margin-bottom: 8px;">Copy Strategy</label>
                        <div style="display: flex; flex-direction: column; gap: 6px; font-size: 13px;">
                            <label style="font-weight: normal; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="copyStrategy" value="replace" checked>
                            <strong>Replace</strong> (Clear current selections and apply exactly from source)
                            </label>
                            <label style="font-weight: normal; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="copyStrategy" value="merge">
                            <strong>Merge</strong> (Keep current selections and add active FOS items from source)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnApplyCopy">Apply</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlLoadSofGrantee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Load Default English Test Scores</h2>
                <div id="info-grantee" style="font-size: 12px; color: #64748b; margin-top: 2px;text-align:center"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-3">
                    <div class="form-group col-sm-12">
                        <p>
                            Are you sure you want to load the default master data for this period? Standard AMINEF default data will be applied to this program.
                        </p>
                    </div>

                    <div class="form-group col-sm-12">
                        <label style="margin-bottom: 8px;">Copy Strategy</label>
                        <div style="display: flex; flex-direction: column; gap: 6px; font-size: 13px;">
                            <label style="font-weight: normal; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="loadStrategy" value="replace" checked>
                            <strong>Replace</strong> (Clear current selections and apply exactly from source)
                            </label>
                            <label style="font-weight: normal; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="loadStrategy" value="merge">
                            <strong>Merge</strong> (Keep current selections and add active FOS items from source)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnApplyLoad">Load Default</button>
            </div>
        </div>
    </div>
</div>