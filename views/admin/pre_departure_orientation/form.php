<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$pid = $this->input->get('pid');
$is_check = $data ? explode(",", $data->grantee_grant_id) : [];
if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>
<style>
    .is_unlimited_label {
        font-size: 13px;
        font-weight: inherit;
        font-style: italic;
        cursor: pointer;
        user-select: none
    }

    .require{
        color: red;
    }

    #memo_revision th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #ebebeb;
    color: #7da2bd;
    }

    .select2-results__options[aria-multiselectable="true"] li {
        padding-left: 30px;
        position: relative
    }

    .select2-results__options[aria-multiselectable="true"] li:before {
        position: absolute;
        left: 8px;
        opacity: .6;
        top: 6px;
        font-family: "FontAwesome";
        content: "\f0c8";
    }

    .select2-results__options[aria-multiselectable="true"] li[aria-selected="true"]:before {
        content: "\f14a";
    }

    .program_section .select2-container--default .select2-selection--multiple {
        height: 100px;
        overflow-y: auto;
        padding-right: 5px; /* untuk memberi ruang scroll */
        box-sizing: border-box;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if($this->session->flashdata('success_period')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success_period') ?>
    </div>
<?php } ?>
<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="btn" id="btn">
    <div class="row">
        <?php if($is_edit){ ?>
        <!-- <div class="col-lg-12" style="margin-bottom:10px">  
            <ul class="nav nav-pills">
                <li id="li_info" <?php echo $default_tab_active ?>><a data-toggle="tab" href="#info" aria-expanded="true">Detail Period</a></li>
                <li id="li_pdo"><a data-toggle="tab" href="#pdo" aria-expanded="true">Pre Departure Orientation</a></li>
                <li <?= $pid == 'payment' ? 'class="active"' : '' ?> id="li_payment"><a data-toggle="tab" href="#payment" aria-expanded="true">Payment Grant</a></li>
            </ul>
        </div> -->
        <?php } ?>
        <div class="alert alert-danger hide" id="error-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <span id="label-alert"></span>
        </div>
        <div class="tab-content">
            <div id="pdo" class="tab-pane fade <?= $default_content_active ?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>PDO Format</label>
                                <select class="form-control" name="pdo_format" id="pdo_format">
                                    <option value="online" <?php echo $data->pdo_format == 'online' ? 'selected' : ''; ?>>Online</option>
                                    <option value="offline" <?php echo $data->pdo_format == 'offline' ? 'selected' : ''; ?>>Offline</option>
                                    <option value="hybrid" <?php echo $data->pdo_format == 'hybrid' ? 'selected' : ''; ?>>Hybrid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="section_online">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Start Date Online</label>
                                <input type="text" readonly style="background-color:#fff" class="form-control datetime" placeholder="Date" name="date" value="<?= $data->date ? date('Y-m-d H:i', strtotime($data->date)) : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>End Date Online</label>
                                <input type="text" readonly style="background-color:#fff" class="form-control datetime" placeholder="Date" name="end_date" value="<?= $data->end_date ? date('Y-m-d H:i', strtotime($data->end_date)) : '' ?>">
                            </div>
                        </div>
    
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Location Online</label>
                                <textarea class="form-control editor" name="location"><?= $data->location ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="section_offline">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Start Date Offline</label>
                                <input type="text" readonly style="background-color:#fff" class="form-control datetime" placeholder="Date" name="date_offline" value="<?= $data->date_offline ? date('Y-m-d H:i', strtotime($data->date_offline)) : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>End Date Offline</label>
                                <input type="text" readonly style="background-color:#fff" class="form-control datetime" placeholder="Date" name="end_date_offline" value="<?= $data->end_date_offline ? date('Y-m-d H:i', strtotime($data->end_date_offline)) : '' ?>">
                            </div>
                        </div>
    
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Location Offline</label>
                                <textarea class="form-control editor" name="location_offline"><?= $data->location_offline ?></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Agenda</label>
                                <input type="file" class="form-control" name="agenda">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <?php if($data->agenda != '') { ?>
                                <br />
                                <a href="<?= base_url($data->agenda)?>" class="btn btn-primary lightbox">View</a>
                                <a href="<?= base_url('admin/pre_departure_orientation/delete_file/agenda/'.$data->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger">Delete</a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Participant</label>
                                <?php //if(!$is_edit){?>
                                <input type="file" class="form-control" name="participant">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <?php //} ?>
                                <?php if($data->participant != '') { ?>
                                <br>
                                <a href="<?= base_url($data->participant)?>" class="btn btn-primary lightbox">View</a>
                                <a href="<?= base_url('admin/pre_departure_orientation/delete_file/participant/'.$data->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger">Delete</a>
                                <!-- <a href="<?= base_url($data->participant)?>" download class="btn btn-primary"><i class="fa fa-download fa-fw text-white"></i></a> -->
                                <!-- <a href="<?= base_url('admin/pre_departure_orientation/delete_file/participant/'.$data->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger">Delete</a> -->
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Final Biosketch of Speakers</label>
                                <input type="file" class="form-control" name="final_biosketch_of_speakers">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <?php if($data->final_biosketch_of_speakers != '') { ?>
                                <br>
                                <a href="<?= base_url($data->final_biosketch_of_speakers)?>" class="btn btn-primary lightbox">View</a>
                                <a href="<?= base_url('admin/pre_departure_orientation/delete_file/final_biosketch_of_speakers/'.$data->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger">Delete</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>PDO Materials from Speakers</label>
                                <input type="file" class="form-control" name="pdo_materials[]" multiple>
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <?php if($data->pdo_materials != '') { ?>
                                <!-- <br />
                                <a href="<?= base_url($data->pdo_materials)?>" class="btn btn-primary lightbox">View</a>
                                <a href="<?= base_url('admin/pre_departure_orientation/delete_file/pdo_materials/'.$data->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger">Delete</a> -->
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Panelist</label>
                                <select class="form-control select_multiselect" name="panellist_pdo_id[]" multiple='multiple' style="width:100%">
                                    <?php foreach ($panellist as $p) { ?>
                                        <?php $select = in_array($p->id, explode(",", $data->panellist_id))  ? 'selected' : ''; ?>
                                        <option value="<?php echo $p->id; ?>" <?= $select ?>><?php echo $p->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Period/Fiscal Year</label>   
                                <select class="form-control select_multiselect" name="fiscal_year" id="fiscal_year">
                                    <option value="">-- Select Year --</option>
                                    <?php
                                    $current_year = date('Y', strtotime('+2 years'));
                                    //$limit_year = $current_year - 20;
                                    $limit_year = 1952;
                                    for ($year = $current_year; $year >= $limit_year; $year--) {
                                        $selected = '';
                                        if ($data->fiscal_year == $year) {
                                            $selected = 'selected="selected"';
                                        }
                                    ?>
                                        <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="text-danger invalid-tooltip validation-error-fiscal" style="display:none;">Period/Fiscal Year is Required</div> 
                            </div>
                        </div>
                        

                        <?php if($pdo_material_files) { ?>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>PDO Materials from Speakers Files</label>
                                    <ul style="margin-left: -25px;">
                                        <?php foreach($pdo_material_files as $file) { ?>
                                        <li>
                                            <a href="<?= base_url($file->file) ?>" class="lightbox"><?= $file->file_name ?></a> <span onclick="delete_file_materials(this, <?= $file->id ?>)" class="ml-3 text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
    
                        <div class="col-lg-12 program_section">
                            <div class="form-group">
                                <label>Program</label>
                                <img src="<?php echo base_url() ?>/img/loading.gif" id="load-grants" style="display:none;">
                                <select class="form-control select_multiselect" name="grants[]" multiple='multiple' id="grants" data-live-search="true">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:50px;">
                    <div class="col-lg-12 mt-5">
                        <p style="font-weight:bold;margin-bottom:25px;">
                            <i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> List Participants 
                            <img src="<?php echo base_url() ?>/img/loading.gif" id="load-list" style="display:none;">
                        </p>
                        <div class="wrap-table-list">
                            <?php if($list_participant) { ?>

                                <?php foreach ($list_participant as $key => $list) { ?>
                                    <div class="pull-left mb-2">
                                    <h3><?= $key ?></h3>
                                    Participants : <?= count($list) ?> 
                                    </div>
                                    <table class="table table-striped table-hover mb-5">
                                        <thead>
                                            <tr>
                                                <th width="30"><input type="checkbox" class="chk-all"></th>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Grantee Program</th>
                                                <th>University</th>
                                                <th>Status</th>
                                                <th>Period</th>
                                            </tr>
                                        </thead>
                                        <?php $no=1; foreach ($list as $key => $row) { 
                                            $status_interview = '';
                                            if($row->status_interview == 'P') {
                                                $status_interview = 'Principle';
                                            }else if($row->status_interview == 'A'){
                                                $status_interview = 'Alternate';
                                            }
                                        
                                        ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="chk-row" <?= in_array($row->id, $is_check) ? 'checked' : '' ?> name="ids[]" value="<?= $row->id ?>">
                                                </td>
                                                <td><?= $no ?></td>
                                                <td><a href="<?= base_url('admin/pre_depature/form/'.$row->id) ?>"><?= get_full_name($row,"ID") ?></a></td>
                                                <td><?= $row->grant_name ?></td>
                                                <td><?= $row->university_name ?></td>
                                                <td><?= $status_interview ?></td>
                                                <td><?= $row->fiscal_year ?></td>
                                            </tr>
                                        <?php $no++; } ?>
                                    </table>
                                    <hr>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3 mb-5">
                        <a href="<?= base_url('admin/pre_departure_orientation/manage') ?>" class="btn btn-default">Back</a>
                        <?php if($data) { ?>
                            <button type="submit" data-value="edit" class="btn btn-success btn-s-pdo-edit">Save</button>
                            <button type="submit" data-value="editadnsend" class="btn btn-warning btn-s-pdo-edit">Save & Send</button>
                        <?php }else{?>
                            <button type="button" data-value="add" class="btn btn-success btn-s-pdo">Save</button>
                            <button type="submit" data-value="andsend" class="btn btn-warning btn-s-pdo">Save & Send</button>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div id="payment" class="tab-pane fade <?= $pid == 'payment' ? 'active in' : '' ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record" class="btn btn-success btn-sm" id="btn-add">
                                            ADD NEW
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th>Payment Date</th>
                                                <!-- <th>Description</th> -->
                                                <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <th>Total Payment (IDR)</th>
                                                <?php } ?>
                                                <th>Total Payment (USD)</th>
                                                <th>Proof</th>
                                                <th>Status</th>
                                                <th width="150" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($payment_record)
                                        {
                                            $no = $paging['start_row'];
                                            foreach($payment_record as $row) {
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                <!-- <td><?= $row->description ?></td> -->
                                                <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <td>
                                                <?php 
                                                    $total_payment_idr = [];
                                                    foreach ($row->items as $key => $item) {
                                                        array_push($total_payment_idr, $item->nominal_idr);
                                                    }
                                                ?>
                                                IDR <?= number_format(array_sum($total_payment_idr))?>
                                                </td>
                                                <?php } ?>
                                                <td>
                                                    <?php 
                                                        $total_payment = [];
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment, $item->nominal);
                                                        }
                                                    ?>
                                                    $<?= number_format(array_sum($total_payment))?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($row->proof)) { ?>
                                                    <a href="<?php echo base_url($row->proof) ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $row->payment_status ?></td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a href="<?= site_url('admin/user_grantee_grant/delete_record/'.$row->id) ?>" class="btn btn-danger btn-xs confirm-del">
                                                        <i class="fa fa-times-circle"></i> Delete
                                                    </a>
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
                                    Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
                                </div>
                                <!-- /.pagination info -->
                                <?php echo $paging['html'] ?>
                                <!-- /.pagination -->
                                <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
                                <input type="hidden" name="sort" value="<?php echo $sort ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="delete_detail_payment" name="delete_detail_payment">
                <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
                <input type="hidden" name="total_grant" value="<?= $grantee_setting->total_grant ?>">
                <input type="hidden" name="grantee_id" id="grantee_id" value="<?= $grantee_id ?>">
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</form>
<!-- /.row -->
<!-- Modal -->
<div class="modal fade" id="mdl_memo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Memo Budget Revision</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/memo_budget_revision') ?>">
            <div class="form-group">
                <label>Memo Budget Revision</label>
                <input type="file" id="memo_budget_revision" name="memo_budget_revision" required>
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="period_id" id="period_id" value="<?= $data->id ?>">
                <input type="hidden" name="grant_id" id="grant_id" value="<?= $data->user_grantee_grant_id ?>">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="form_memo">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Memo Period -->
<div class="modal fade" id="mdl_memo_budget_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Memo Budget</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form role="form" method="POST" id="form_memo_budget" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/memo_budget_period') ?>">
					<input type="hidden" name="save_memo_budget">
					<input type="hidden" name="period_id" value="<?php echo $data->id; ?>" >
					<div class="form-group">
						<label>Memo Budget</label>
						<input type="file" id="memo_budget" name="memo_budget" required>
                        <small class="file-for-testing">File Size Max 5MB</small>
					</div>
					<div class="form-group">
						<label for="">Active</label>
						<select name="is_active" id="" class="form-control">
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" form="form_memo_budget" id="btn-memo-budget">Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="mdl_memo_period" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Memo Budget</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form role="form" method="POST" id="form_memo_budget_edit" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/edit_memo_period/') ?>">
					<input type="hidden" name="save_memo_budget">
					<input type="hidden" name="memo_id" id="memo_id">
					<div class="form-group">
						<label>Memo Budget</label>
						<input type="file" id="memo_budget" name="memo_budget">
                        <small class="file-for-testing">File Size Max 5MB</small>
					</div>
					<div class="form-group">
						<label for="">Active</label>
						<select name="is_active" id="edit_memo_is_active" class="form-control">
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" form="form_memo_budget_edit">Save</button>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('admin/partials/modal_payment_grant') ?>

<?php 
if(!empty($payment_record)):
$final_record = [];
foreach($payment_record as $record){
    $final_record[$record->id] = $record;
}
?>
<script>
    var currentPaymentGrant = JSON.parse(`<?php echo safe_parse_json(json_encode($final_record)); ?>`);
</script>
<?php endif; ?>

<?php if(!empty($payment_item)): ?>
<script>
    var currentPaymentItemsGrant = JSON.parse(`<?php echo safe_parse_json(json_encode($payment_item)); ?>`);
</script>
<?php endif; ?>

<?php
if (!empty($payment_sub_support)) :
    $final_sub_record = [];
    foreach ($payment_sub_support as $row) {
        $final_sub_record[] = $row;
    }
?>
    <script>
        var currentSubCategoryRecord = JSON.parse(`<?php echo safe_parse_json(json_encode($final_sub_record)); ?>`);
    </script>
<?php endif; ?>




<?php
if (!empty($memo_budget_period)) :
    $final_record = [];
    foreach ($memo_budget_period as $memo) {
        $final_record[$memo->id] = $memo;
    }
?>
    <script>
        var currentMemoGrants = JSON.parse(`<?php echo safe_parse_json(json_encode($final_record)); ?>`);
    </script>
<?php endif; ?>