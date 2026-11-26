<style>
    #success-alert{
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display:none;
    }
</style>
<?php if($message_approval != ''){ ?>
<div class="alert alert-success" id="success-alert" style="width:300px">
  <button type="button" class="close" data-dismiss="alert">x</button>
  <?= $message_approval ?>
</div>
<?php } ?>
<!-- /.row -->
<div class="row" style="padding-top:20px">
    <div class="col-lg-12">
        <form id="frm_manage" method="POST" action=""> 
					<div class="data-header clearfix form-inline">
						<div class="pull-left">Need Approval <?= format_date_time($data[0]->send_date)?></div>
						<div class="pull-right">
							<button name="btn" value="download" class="btn btn-default btn-sm"><i class="fa fa-file-pdf-o"></i> Download</button>
                            <?php if($executive->status == '' || $executive->status == 'onhold'){ ?>
							<a href="#" data-toggle="modal" data-target="#mdl_hold"class="btn btn-danger btn-sm" value="onhold"><i class="fa fa-times"></i> On Hold</a>
							<button class="btn btn-success btn-sm btn-action" name="btn" value="approve"><i class="fa fa-check"></i> Approve</button>
                            <?php } elseif($executive->status == 'approve') { ?>
							<button disabled class="btn btn-success btn-sm btn-action" name="btn" value="approve"><i class="fa fa-check"></i> Approve</button>
                            <?php } elseif($executive->status == 'decline') { ?>
							<button disabled class="btn btn-danger btn-sm btn-action" name="btn" value="onhold"><i class="fa fa-times"></i> On Hold</button>
                            <?php } ?>
                            <input type="hidden" name="id" value="<?= $executive->id ?>">
						</div>
					</div>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th>Grant</th>
                            <th>Payment to</th>
                            <th>Name of Bank</th>
                            <th>Address of Bank</th>
                            <th>Account Number</th>
                            <th>Routing Number</th>
                            <th>Swift Code</th>
                            <th>Note</th>
                            <th>Reference</th>
                            <th>Payment Status</th>
                            <th>Total Amount</th>
                            <!-- <th>Date</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                $format = $executive->country_id == 1 ? 'ID' : 'US';
                                $fullname = $this->Grantee_ent_model->get_full_name($row, $format);
                                ?>
                                <tr>
                                    <td>
                                        <?php if($executive->country_id == 1) { ?>
                                            <input type="checkbox" class="chk-row" name="ids[]" value="<?= $row->id ?>">
                                        <?php }else{ ?>
                                            <input type="checkbox" class="chk-row" name="<?= $row->category == 'Grant Cost' ? 'ids_cost[]' : 'ids[]' ?>" value="<?= $row->id ?>">
                                        <?php } ?>
                                    </td>
                                    <td class="text-left"><?= $row->program_name ?></td>
                                    <td class="text-left"><?= $fullname ?></td>
                                    <td class="text-left"><?= $row->bank_name ?></td>
                                    <td class="text-left"><?= $row->bank_address ?></td>
                                    <td class="text-left"><?= $row->account_number ?></td>
                                    <td class="text-left"><?= $row->routing_number ?></td>
                                    <td class="text-left"><?= $row->swift_code ?></td>
                                    <td class="text-left">
                                        <table width="100%">
                                            <?php $num = 1; foreach($row->items as $val){ ?>
                                                <tr>
                                                    <td style="vertical-align: top;" width="5%"><?= $num ?>.</td>
                                                    <td><?= $val['payment_item'] ?> ($<?= $val['nominal'] ?>)</td>
                                                </tr>
                                                <?php $num++; } ?>
                                        </table>
                                    </td>
                                    <td class="text-left">
                                        <?php if ($row->invoice != '') { ?>
                                        <a href="<?= site_url($row->invoice)?>" target="_blank"><span class="badge badge-primary">View Invoice</span></a><br />
                                        <?php } ?>
                                        <?php if ($row->memo_budget != '') { ?>
                                        <a href="<?= site_url($row->memo_budget)?>" target="_blank"><span class="badge badge-primary">View Memo Budget</span></a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left"><?= $row->items[0]['status_name'] ?></td>
                                    <td class="text-left">$<?= number_format($row->total_payment) ?></td>
                                    <!-- <td class="text-left"><?= $row->send_date ? format_date($row->send_date) : '-' ?></td> -->
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
            <div class="modal fade" id="mdl_hold" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title text-center" id="exampleModalLabel">Notes</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea type="text" class="form-control" name="notes" placeholder="Notes" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="btn" value="onhold" class="btn btn-success btn-action">Save</button>
                    <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
                </div>
                </div>
            </div>
            </div>
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
<?php if($message_approval != ''){ ?>
<script>
    var notifapprove = 1;
</script>
<?php }else{ ?>
<script>
    var notifapprove = 0;
</script>
<?php } ?>
