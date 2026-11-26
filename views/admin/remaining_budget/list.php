<?php 
    $params = $_SERVER['QUERY_STRING'];
?>
<style>
    .select2-container .select2-selection {
        max-height: 60px;
        overflow: auto;
    } 
</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Remaining Balance
            <a href="<?php echo site_url('admin/remaining_budget/download_excel?'.$params) ?>"
               class="btn btn-primary btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                DOWNLOAD EXCEL
            </a>
            <!-- <span class="pull-right">&nbsp;</span>
            <a href="javascript:;" onclick="import_excel()" class="btn btn-primary btn-sm pull-right"
               title="Import Alumni data dari file excel">
                IMPORT EXCEL
            </a> -->
            <!-- <span class="pull-right">&nbsp;</span>
            <a href="<?= base_url('uploads/Template-import-alumni-v1.xlsx') ?>"
               class="btn btn-primary btn-sm btn-circle pull-right" title="Download template excel untuk di import"
               style="border-radius:15px;">
                <i class="fa fa-file fa-fw"></i>
            </a> -->
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<?php if (isset($import_success) && $import_success === false) { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        File Excel tidak dapat di import, pastikan anda menggunakan template excel yang valid.
    </div>
<?php } ?>

<?php if (isset($import_success) && is_numeric($import_success)) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Sukses melakukan import sebanyak total <?= $import_success ?> data Alumni.
    </div>
<?php } ?>

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
                                    <label for="">Start Year</label>
                                </td>
                                <td width="20%">
                                    <select name="start_year" class="form-control" onchange="return formSubmit(event)">
                                        <?php for ($i=date('Y') + 10; $i > 1900; $i--) : ?>
                                            <?php 
                                                $selected = '';
                                                if ($i == $paging['start_year']) {
                                                    $selected = 'selected';
                                                }    
                                            ?>
                                            <option <?= $selected ?> value="<?= $i; ?>"><?= $i;?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td width="15%">
                                    <label for="">End Year</label></td>
                                <td>
                                    <select name="end_year" class="form-control" onchange="return formSubmit(event)">
                                        <?php for ($i=date('Y') + 10; $i > 1900; $i--) : ?>
                                            <?php 
                                                $selected = '';
                                                if ($i == $paging['end_year']) {
                                                    $selected = 'selected';
                                                }    
                                            ?>
                                            <option <?= $selected ?> value="<?= $i; ?>"><?= $i;?></option>
                                        <?php endfor; ?>
                                    </select></td>
                            </tr>
                        </table>
                        <table width="100%" style="padding:5px">
                            <tr>
                                <td width="15%" height="65px"><label for="">Grant</label></td>
                                <td>
                                    <select name="grant[]" class="form-control select2" multiple="multiple" onchange="return formSubmit(event)" style="width:100%;">
                                        <?php
                                        foreach ($program_available as $pa) { 
                                            $selected = '';
                                            $filter_grants = isset($paging['grant']) ? $paging['grant'] : [];
                                            if (in_array($pa->id, $filter_grants)) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option value="<?= $pa->id ?>" <?= $selected ?>><?= $pa->name ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="15%" height="65px"><label for="">Category</label></td>
                                <td>
                                    <?php $paggingCategory = $paging['category'] ? $paging['category'] : []; ?>
                                    <select name="category[]" id="category" class="form-control select2" multiple="multiple" onchange="return formSubmit(event)" style="width:100%;" >
                                        <option <?php if (in_array("Grant Cost",$paggingCategory)) echo "selected"; ?> value="Grant Cost">Grant Cost</option>
                                        <option <?php if (in_array("Grant Supporting",$paggingCategory)) echo "selected"; ?> value="Grant Supporting">Grant Supporting</option>
                                        <option <?php if (in_array("Critical Language Enhancement Award",$paggingCategory)) echo "selected"; ?> value="Critical Language Enhancement Award">Critical Language Enhancement Award</option>
                                        <option <?php if (in_array("International Travel",$paggingCategory)) echo "selected"; ?> value="International Travel">International Travel</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="">Search</label></td>
                                <td><input type="text" name="search" id="search" class="form-control" placeholder="Search Name" onkeypress="return submitFilter(event)" value="<?= $paging['search'] ?>"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table width="100%" class="text-right">
                            <tr>
                                <td><label for="">Grant Total Budget (USD)</label></td>
                                <td width="2%">:</td>
                                <td width="20%"><?= format_money($grant_total_budget, 'USD') ?></td>
                            </tr>
                            <tr>
                                <td><label for="">Grant Total Payment (USD)</label></td>
                                <td>:</td>
                                <td><?= format_money($grant_total_payment, 'USD') ?></td>
                            </tr>
                            <tr>
                                <td><label for="">Grant Total Balance (USD)</label></td>
                                <td>:</td>
                                <td><?= format_money($grant_total_balance, 'USD') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
			</div>
            <div class="col-md-12 mb-2 mt-2 p-0">
                <button class="btn btn-primary hide" type="button" id="bulk-action">Set to Uncommited</button>
            </div>
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
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
            </div>
            <?php if ($this->session->flashdata('info')) { ?>
            <div class="col-md-12 p-0">
                <div class="alert alert-success"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('info'); ?></div>
                <?php $this->session->set_flashdata('info', false); ?>
            </div>
            <?php } ?>
            <div class="text-center justify-content-center mb-3" style="display:none;" id="loading_data">
                Loading Data ... <img src="<?php echo base_url() ?>/img/loading.gif">
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>Fiscal Year</th>
                            <th>Grants</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th class="text-right">Total Budget (USD)</th>
                            <th class="text-right">Total Payment (USD)</th>
                            <th class="text-right">Total Balance (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                $grantee_grant_id = $row['grantee_grant_id'];
                                $user_grantee_id = $row['grantee_id'];
                                $has_clea = has_clea($user_grantee_id, $grantee_grant_id);
                                $pid = '';
                                $format = 'ID';
                                if ($row->country_id == '2') {
                                    $format = 'US';
                                }
                                ?>
                                <tr>
                                    <td rowspan="<?php echo count($row['parents']['name']) + 1; ?>" style="vertical-align:middle">
                                        <?php 
                                            $total_balance = (array_sum(str_replace(",","",$row['parents']['total_budget']))) - (array_sum(str_replace(",","",$row['parents']['total_payment'])));
                                        ?>
                                        <?php if ((float) $total_balance != 0) { ?>
                                            <input type="checkbox" class="bulk-checkbox" value="<?php echo $row['grantee_grant_id']; ?>">
                                        <?php } ?>
                                    </td>
                                    <td rowspan="<?php echo count($row['parents']['name']) + 1; ?>" style="vertical-align:middle"><?= $row['fiscal_year'] ?></td>
                                    <td rowspan="<?php echo count($row['parents']['name']) + 1; ?>" style="vertical-align:middle" class="text-left"><?= $row['program_name'] ?></td>
                                    <td rowspan="<?php echo count($row['parents']['name']) + 1; ?>" style="vertical-align:middle" class="text-left">
                                        <a href="<?= site_url('admin/grantee/edit/' . $row['grantee_id']) ?>">
                                            <?= $row['grantee_name'] ?>
                                        </a>
                                    </td>
                                    <td class="text-left"><?= $row['parents']['name'][0] ?></td>
                                    <td class="text-right"><?= $row['parents']['total_budget'][0] == 'Unlimited' ? 'To be Proposed' : (isset($row['parents']['total_budget'][0]) ? format_money($row['parents']['total_budget'][0], 'USD') : 0 )?></td>
                                    <td class="text-right">
                                        <a target="_blank" href="<?= site_url('admin/request_payment/edit/' . $row['grantee_id'] . '/' . $grantee_grant_id) ?>">
                                            <?= format_money($row['parents']['total_payment'][0], 'USD')?>
                                        </a>
                                    </td>
                                    <td class="text-right"><?= $row['parents']['total_balance'][0] == 'Unlimited' ? 'To be Proposed' : (isset($row['parents']['total_balance'][0]) ? format_money($row['parents']['total_balance'][0], 'USD') : 0)?></td>
                                </tr>
                                
                                <?php if (count($row['parents']['name']) > 1) {
                                     $payment_deduction = 0;
                                    for ($i = 1; $i < count($row['parents']['name']); $i++) {
                                        switch($row['parents']['name'][$i]) {
                                            case 'Grant Supporting' :
                                                $pid = '?pid=support';
                                                break;
                                            case 'Critical Language Enhancement Award' :
                                                $pid = '?pid=clea';
                                                break;
                                            case 'International Travel' :
                                                $pid = '?pid=travel';
                                                break;
                                        }
                                        if ($row['parents']['total_budget'][$i] == 'Unlimited') {
                                            $payment_deduction += $row['parents']['total_payment'][$i];
                                        }
                                        
                                ?>
                                    <tr>
                                        <?php 
                                            if ($row['parents']['name'][$i] == 'Critical Language Enhancement Award' && !$has_clea) {
                                                continue;
                                            }
                                        ?>
                                        <td class="text-left"><?= $row['parents']['name'][$i] ?></td>
                                        <td class="text-right"><?= $row['parents']['total_budget'][$i] == 'Unlimited' ? 'To be Proposed' : (isset($row['parents']['total_budget'][$i]) ? format_money($row['parents']['total_budget'][$i], 'USD') : 0) ?></td>
                                        <td class="text-right">
                                            <a target="_blank" href="<?= site_url('admin/request_payment/edit/' . $row['grantee_id'] . '/' . $grantee_grant_id . $pid) ?>">
                                                <?= format_money($row['parents']['total_payment'][$i], 'USD')?>
                                            </a>
                                        </td>
                                        <td class="text-right"><?= $row['parents']['total_balance'][$i] == 'Unlimited' ? 'To be Proposed' : (isset($row['parents']['total_balance'][$i]) ? format_money($row['parents']['total_balance'][$i], 'USD') : 0)?></td>
                                    </tr>
                                <?php }
                                } ?>
                                    <tr>
                                        <td class="text-left" style="font-weight:bolder;background-color: #bcbcbc;">Subtotal</td>
                                        <td class="text-right" style="background-color: #bcbcbc;"><?= format_money(array_sum($row['parents']['total_budget']), 'USD'); ;?></td>
                                        <td class="text-right" style="background-color: #bcbcbc;"><?= format_money(array_sum($row['parents']['total_payment']), 'USD'); ;?></td>
                                        <td class="text-right" style="background-color: #bcbcbc;"><?= format_money(array_sum($row['parents']['total_balance']), 'USD'); ;?></td>
                                        <?php
                                        $totalbalance = (array_sum(str_replace(",","",$row['parents']['total_budget']))) - (array_sum(str_replace(",","",$row['parents']['total_payment'])));
                                        ?>
                                        <!-- <td class="text-right" style="background-color: #bcbcbc;"><?php echo number_format($totalbalance); ;?></td> -->
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
                of <?= number_format($paging['total_rows']) ?> entries
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

<div class="modal fade" id="confirm-set-to-uncommited" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Set to Uncommited List?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Proceeding with this action will add the payment data to the uncommitted list.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirm-submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>