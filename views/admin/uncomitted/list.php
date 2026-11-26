<style>
    .select2-container .select2-selection {
        max-height: 60px;
        overflow: auto;
    } 
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Uncommitted List
            <?php //if(has_permission('alumni', 'add')) { ?>
                <a href="<?php echo site_url('admin/uncomitted/add') ?>" class="btn btn-success btn-sm pull-right">
                    ADD NEW
                </a>
                <a href="<?php echo site_url('admin/uncomitted/download_excel' . ( $_SERVER['QUERY_STRING'] ? '?'. $_SERVER['QUERY_STRING'] : '')) ?>"
                class="btn btn-primary btn-sm pull-right mr-2" id="downloadExcel">
                    DOWNLOAD EXCEL
                </a>
                <!-- <a href="javascript:;" onclick="sync_data()" class="btn btn-warning btn-sm pull-right mr-2">
                    Sync Data <i class="fa fa-refresh fa-fw"></i>
                </a> -->
            <?php //} ?>
        </h1>
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
                                    <label for="">Start Year</label>
                                </td>
                                <td width="20%">
                                    <select name="start_year" class="form-control" onchange="return formSubmit(event)">
                                        <option value="">All</option>
                                        <?php for ($i = date('Y'); $i > 1900; $i--) : ?>
                                            <?php
                                            $selected = '';
                                            if ($i == $paging['start_year']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td width="15%">
                                    <label for="">End Year</label>
                                </td>
                                <td>
                                    <select name="end_year" class="form-control" onchange="return formSubmit(event)">
                                        <?php for ($i = date('Y'); $i > 1900; $i--) : ?>
                                            <?php
                                            $selected = '';
                                            if ($i == $paging['end_year']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
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
                                <td width="15%" height="65px"><label for="">Search</label></td>
                                <td><input type="text" name="search" id="search" class="form-control" placeholder="Search Name" onkeypress="return submitFilter(event)" value="<?= $paging['search'] ?>"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table width="100%" class="text-right">
                            <tr>
                                <td><label for="">Grant Total Balance (USD)</label></td>
                                <td>:</td>
                                <td><?= format_money((float)$grant_total_balance, 'USD') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
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
            <div class="col-md-12 mb-2 mt-2 p-0">
                <button class="btn btn-primary hide" type="button" id="bulk-action">Remove from Uncommited</button>
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
                            <th width="35" class="text-center">#</th>
                            <th>Fiscal Year</th>
                            <th>Grants</th>
                            <th>Name</th>
                            <th>Total Balance</th>
                            <th class="text-center" width="150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="bulk-checkbox" value="<?php echo $row->id; ?>">
                                    </td>
                                    <td><?= $no ?></td>
                                    <td class="text-left"><?= $row->fiscal_year ?></td>
                                    <td class="text-left"><?= $row->program_name ?></td>
                                    <td class="text-left"><?= $row->name ?></td>
                                    <td class="text-left"><?= $row->total_balance ? format_money($row->total_balance, 'USD') : 0 ?></td>
                                    <td class="text-center">
                                        <?php if($row->grantee_grant_id) { 
                                            $url = $row->country_id == AMERICAN_DATABASE ? base_url('admin/request_payment/view/'. $row->grantee_grant_id . '/' . $row->user_grantee_grant_id) : base_url('admin/payment_record/payment/alumni/'. $row->grantee_grant_id);
                                        ?>
                                            <a href="<?= $url ?>" class="btn btn-xs btn-primary">Payment</a>
                                        <?php }else { ?>
                                            <a href="<?= base_url('admin/uncomitted/edit/'.$row->id) ?>" class="btn btn-xs btn-primary">Edit</a>
                                            <a href="<?= base_url('admin/uncomitted/delete/'.$row->id) ?>" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger">Delete</a>
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


<div class="modal fade" style="width: 100%!important; height: 100% !important;" id="sync-dialog" tabindex="-1" role="dialog" aria-labelledby="sync-dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 100% !important; height: 100% !important;">
            <div class="modal-body text-center">
                <div class="col-md-12" style="margin-top: 15%;">
                    <center><div class="loading"></div></center>
                </div>
                <div class="col-md-12">
                    <center><b style="color: white;">Sync Data, please wait</b></center>
                </div>
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
        Proceeding with this action will remove the payment data from the uncommitted list.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirm-submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>