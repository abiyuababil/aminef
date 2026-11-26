<style>
    .select2-container .select2-selection {
        max-height: 60px;
        overflow: auto;
    } 
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Payment Released</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>
        <form id="frm_manage" method="GET">
            <div class="data-header clearfix form-inline">
                <div class="row">
                    <div class="col-lg-6">
                        <table width="100%" style="padding:5px">
                            <tr>
                                <td width="15%" height="40px">
                                    <label for="">Fiscal Year</label>
                                </td>
                                <td>
                                    <select name="start_year" class="form-control" onchange="document.forms.frm_manage.submit()">

                                        <option value="">All</option>

                                        <?php 
                                        $selected_year = !empty($paging['start_year']) 
                                            ? $paging['start_year'] 
                                            : '';
                                        ?>
                                        <?php for ($i=date('Y') + 10; $i > 1900; $i--) : ?>
                                            <option <?= $i == $selected_year ? 'selected' : '' ?> value="<?= $i; ?>"><?= $i;?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <!-- <td width="15%">
                                    <label for="">End Year</label></td>
                                <td>
                                    <select name="end_year" class="form-control" onchange="document.forms.frm_manage.submit()">
                                        <?php for ($i=date('Y') + 10; $i > 1900; $i--) : ?>
                                            <?php 
                                                $selected = '';
                                                if ($i == $paging['end_year']) {
                                                    $selected = 'selected';
                                                }    
                                            ?>
                                            <option <?= $selected ?> value="<?= $i; ?>"><?= $i;?></option>
                                        <?php endfor; ?>
                                    </select></td> -->
                            </tr>
                        </table>
                        <table width="100%" style="padding:5px">
                            <!-- <tr>
                                <td width="15%" height="65px"><label for="">Grant</label></td>
                                <td>
                                    <select name="grant[]" class="form-control select2" multiple="multiple" onchange="document.forms.frm_manage.submit()" style="width:100%;">
                                        <?php
                                        foreach ($program_available as $pa) {
                                            $selected = '';
                                            $filter_grants = isset($paging['grant']) ? $paging['grant'] : [];
                                            if ($pa->id == in_array($pa->id, $filter_grants)) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option value="<?= $pa->id ?>" <?= $selected ?>><?= $pa->name ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr> -->
                            <!-- <tr>
                                <td width="15%" height="65px"><label for="">Category</label></td>
                                <td>
                                    <select name="category[]" id="category" class="form-control select2" multiple="multiple" onchange="document.forms.frm_manage.submit()" style="width:100%;" >
                                        <option <?php if ($paging['category'] && in_array("Grant Cost",$paging['category'])) echo "selected"; ?> value="Grant Cost">Grant Cost</option>
                                        <option <?php if ($paging['category'] && in_array("Grant Supporting",$paging['category'])) echo "selected"; ?> value="Grant Supporting">Grant Supporting</option>
                                        <option <?php if ($paging['category'] && in_array("International Travel",$paging['category'])) echo "selected"; ?> value="International Travel">International Travel</option>
                                    </select>
                                </td>
                            </tr> -->
                            <tr>
                                <td width="15%" height="40px"><label for="">Search</label></td>
                                <td>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Name" onkeypress="return submitFilter(event)" value="<?= $paging['search'] ?>">
                                </td>
                            </tr>
                            <tr>
                                <td width="15%" height="40px"><label for="">Show</label></td>
                                <td>
                                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                                        <?php
                                        foreach($limit_options as $lo) {
                                            $selected = '';
                                            if ($lo == $paging['limit']) $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                                        <?php } ?>
                                        <option value="10000">All</option>
                                    </select> 
                                    entries
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
			</div>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                            <th>Total Payment (USD)</th>
                            <th>Total Payment (IDR)</th>
                            <th>Grants</th>
                            <th>Fiscal Year</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Created Date</th>
                            <th>Released Date</th>
                            <!-- <th <?= sorting_attribute('status_name', $sort_by, $sort) ?>>Payment Status</th> -->
                            <?php //if($this->active_cid == 1) { ?>
                            <!-- <th>Invoice</th> -->
                            <?php //} ?>
                            <!-- <th>Send Date</th>
                            <th>Approval Date</th> -->
                            <th class="text-center" width="150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                $join_program = '';
                                $join_program .= '<ul>';

                                $available_program = [];
                                foreach ($row->programs as $key => $value) {
                                    $year_departure = '';
                                    if ($value['year_departure']) {
                                        $year_departure = " ({$value['year_departure']})";
                                    }

                                    if (!isset($available_program[$value['user_program_id']])) {
                                        $available_program[$value['user_program_id']] = 'Avail';
                                        $join_program .= '<li>' . $value['program_name'] . $year_departure . '</li>';
                                    }
                                }
                                $join_program .= '</ul>';

                                $format = 'ID';
                                if ($country_id == '2') {
                                    $format = 'US';
                                }
                                $fullname = $this->Grantee_ent_model->get_full_name($row, $format);

                                $pid='';
                                if($row->category == 'International Travel'){
                                    $pid = '?pid=travel';
                                }elseif($row->category == 'Grant Supporting'){
                                    $pid = '?pid=support';
                                }
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td class="text-left"><?= $fullname ?></td>
                                    <td class="text-left"><?= format_money($row->total_payment, 'USD') ?></td>
                                    <td class="text-left"><?= format_money($row->total_payment_idr, 'IDR') ?></td>
                                    <td class="text-left"><?= $row->program_name ?></td>
                                    <td class="text-left"><?= $row->fiscal_year ?></td>
                                    <td class="text-left"><?= $row->category ?></td>
                                    <td class="text-left"><?= $row->sub_category ?></td>
                                    <td class="text-left"><?= $row->date_insert ? format_date_time($row->date_insert) : '-' ?></td>
                                    <td class="text-left"><?= $row->release_date ? format_date($row->release_date) : '-' ?></td>
                                    <?php 
                                        if($row->status_name == 'Released') { 
                                            $badge = 'success';
                                        }elseif($row->status_name == "Waiting for ED's Approval"){
                                            $badge = 'info';
                                        }elseif($row->status_name == 'On Hold'){
                                            $badge = 'danger';
                                        }else{
                                            $badge = 'success';
                                        }
                                        
                                    ?>
                                    <!-- <td class="text-left"><span class="badge badge-<?= $badge ?>"><?= $row->status_name ?></span></td> -->
                                    <?php //if($this->active_cid == 1) { ?>
                                    <!-- <td class="text-center"><?= $row->invoice != '' ? '<a href="' .site_url($row->invoice). '" target="_blank"><span class="badge badge-primary">View Invoice</span></a>' : '-'?></td> -->
                                    <?php //} ?>
                                    <!-- <td class="text-left"><?= $row->send_date ? format_date_time($row->send_date) : '-' ?></td>
                                    <td class="text-left"><?= $row->approval_date ? format_date_time($row->approval_date) : '-' ?></td> -->
                                    <td class="text-center">
                                        <?php 
                                            $status_selection     = [STATUS_NEW_SELECTION, STATUS_SELECTION_REVISED, STATUS_SELECTION_DECLINED, STATUS_SELECTION_VERIFIED, STATUS_WAITING_FOR_INTERVIEW, STATUS_INTERVIEW];
                                            $status_candidate     = [STATUS_SELECTION_SUCCESSFUL, STATUS_NEW_CANDIDATE, STATUS_CANDIDATE_REVISED, STATUS_CANDIDATE_DECLINED, STATUS_CANDIDATE_VERIFIED];
                                            $status_on_going     = [STATUS_CANDIDATE_SUCCESSFUL, STATUS_ON_GOING_RESIGN, STATUS_ON_GOING_REVISED];
                                            $status_returning     = [STATUS_RETURNING_SUCCESSFUL, STATUS_NEW_RETURNING, STATUS_RETURNING_REVISED, STATUS_SET_TO_ALUMNI];

                                            $id_grantee = 'admin/request_payment/edit/'.$row->user_grantee_id.$pid;
                                            if($this->active_cid == 1){
                                                if (in_array($row->status, $status_selection)) {
                                                    $section_name = 'selection';
                                                } else if (in_array($row->status, $status_candidate)) {
                                                    $section_name = 'candidate';
                                                } else if (in_array($row->status, $status_on_going)) {
                                                    $section_name = 'on_going';
                                                } else if (in_array($row->status, $status_returning)) {
                                                    $section_name = 'returning';
                                                }
                                                $id_grantee = 'admin/payment_record/payment/'.$section_name.'/'.$row->grantee_grant_id;
                                            }
                                        ?>
                                        <!-- <a href="<?= base_url($id_grantee) ?>" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a> -->
                                        <?php 
                                        // echo '<pre>';print_r($row);die;
                                        $category = $row->category == 'Grant Cost' ? 'cost' : 'record';
                                        ?>
                                        <a href=<?= site_url('admin/pending_task/download/'.$row->user_grantee_id.'?payment='.$row->id.'&category='.$category)?> target="_blank" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i> Download</a>
                                        <?php if($row->proof){ ?>
                                        <a href=<?= site_url(str_replace(' ', '%20', $row->proof))?> target="_blank" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i> Download Proof of Transfer</a>
                                        <?php } ?>
                                        <?php if($row->proof_expense){ ?>
                                        <a href=<?= site_url(str_replace(' ', '%20', $row->proof_expense))?> target="_blank" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i> Download Proof of Expense </a>
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
                Showing <?= $paging['start_row'] ?> to <?= $paging['end_row'] ?>
                of 
                <?= number_format($paging['total_rows']) ?> entries
            </div>
            <!-- /.pagination info -->
            <?= $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?= $sort_by ?>">
            <input type="hidden" name="sort" value="<?= $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div id="template-filter" style="display:none">
    <div class="pull-right" style="margin-top:5px; clear:both;">
        <div class="form-group">
            <select class="form-control" name="cnj[]">
                <option value="AND">AND</option>
                <option value="OR">OR</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="search_by[]">
                <?php
                foreach ($filters as $field => $val) {
                    ?>
                    <option value="<?= $field ?>"><?= $val ?></option>
                <?php } ?>
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        Keyword : <input type="search" class="form-control input-sm" name="q[]" value="" placeholder=""
                         onkeypress="return submitFilter(event)">
        <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i
                class="fa fa-minus fa-fw"></i></a>
    </div>
</div>

<!-- Modal Download -->
<div class="modal fade" id="modalDownload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form-download-excel">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Download Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="row">
					<div class="col-md-12">
						<center>
							<b>List of Fields</b> ( <label>Select All <input id="sel-all" type="checkbox" checked></label> )<br><br>
						</center>
					</div>
                    <?php foreach (array_split($all_field, 4) as $key_a_f => $a_f): ?>
                    <div class="col-md-3">
                        <ul class="list-style-none">
                        <?php foreach ($a_f as $key => $value): ?>
                            <li>
                                <div class="form-check">
                                    <input type="checkbox" name="field_alumni[]" class="form-check-input field-alumni" id="field_alumni_check<?=$key?>" value="<?= "$key *-* $value" ?>" checked>
                                    <label class="form-check-label font-weight-normal d-inline" for="field_alumni_check<?=$key?>"><?=$value?></label>
                                </div>
                            </li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                    <?php endforeach ?>
                    <div class="col-md-12 d-none text-center text-validation mb-4" id="text-validation-field">
                        <small class="text-danger">Select at least one field</small>
                    </div>					
                    <div class="col-md-12">
						<hr>
                        <center>
							<b>Show Grant</b><br><br>
                        </center>
                        <center>
                            <div class="radio d-inline mr-4">
                                <label><input type="radio" class="grant-alumni" name="grant_option" style="margin-top:1px" value="single_grant" checked>Single Grant</label>
                            </div>
                            <div class="radio d-inline">
                                <label><input type="radio" class="grant-alumni" name="grant_option" style="margin-top:1px" value="all_grant">All Grants</label>
                            </div>
                            <small class="text-danger d-none text-validation" id="text-validation-grant">Choose one between single grant or all grants</small>
                        </center>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="submit" class="btn btn-success">Download</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
</div>
