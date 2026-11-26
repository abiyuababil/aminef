

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center"><?php echo $title; ?></h1>
    </div>
</div>

<div class="panel-body">
    <?php if($this->session->flashdata('success_leave')) { ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?= $this->session->flashdata('success_leave') ?>
        </div>
        <?php $this->session->unset_userdata('success_leave');?>
    <?php } ?>
    <div class="col-lg-12 mb-3">
        <a href="<?= base_url('grantee/leaves/form/'.$this->session->userdata('grantee_user_id')) ?>" class="btn btn-primary" style="float:right">New <?php echo $title; ?></a>
    </div>
    <div class="col-lg-12">
        <div class="alert alert-info">
            <?php 
                $personal_travel = 0;
                if (isset($personal_travel_day) && is_array($personal_travel_day)) {
                    $personal_travel = array_sum($personal_travel_day);
                }

                $grant_personal_travel = $grantee_grant->personal_travel;
                $program_personal_travel = $grantee_grant->personal_travel_grant;
                $remaining_personal_travel = 0;
                $total_personal_travel = 0;
                if ($grant_personal_travel > 0) {
                    $total_personal_travel = $grant_personal_travel;
                    $remaining_personal_travel = $grant_personal_travel - $personal_travel;
                } else {
                    $total_personal_travel = $program_personal_travel;
                    $remaining_personal_travel = $program_personal_travel - $personal_travel;
                }
            ?>
            <p style="<?php echo $remaining_personal_travel <= 0 ? 'color:orangered;' : ''; ?>"><i class="fa fa-calendar"></i> You have remaining <?php echo $remaining_personal_travel; ?> days out of <?php echo $total_personal_travel; ?> days of Personal Travel</p>
            
            <?php if($grantee_grant->category_grant == RESEARCH) { ?>
                <?php 
                    $research_travel = 0;
                    if (isset($research_leave_day) && is_array($research_leave_day)) {
                        $research_travel = array_sum($research_leave_day);
                    }

                    $grant_research_travel = $grantee_grant->research_leave;
                    $program_research_travel = $grantee_grant->research_travel_grant;
                    $remaining_research_travel = 0;
                    $total_research_travel = 0;
                    if ($grant_research_travel > 0) {
                        $total_research_travel = $grant_research_travel;
                        $remaining_research_travel = $grant_research_travel - $research_travel;
                    } else {
                        $total_research_travel = $program_research_travel;
                        $remaining_research_travel = $program_research_travel - $research_travel;
                    }
                ?>
                <p style="<?php echo $remaining_research_travel <= 0 ? 'color:orangered;' : ''; ?>"><i class="fa fa-calendar"></i> You have remaining <?php echo $remaining_research_travel; ?> days out of <?php echo $total_research_travel; ?> days of International Research Travel</p>
            <?php } ?>

            <?php if(in_array($grantee_grant->category_grant, [ETA, TEACHING, RESEARCH])) { ?>
                <?php
                    $emergency_leave = 0;
                    if (isset($emergency_leave_day) && is_array($emergency_leave_day)) {
                        $emergency_leave = array_sum($emergency_leave_day);
                    }

                    $grant_emergency_leave = $grantee_grant->emergency_leave;
                    $program_emergency_leave = $grantee_grant->emergency_leave_grant;
                    $remaining_emergency_leave = 0;
                    $total_emergency_leave = 0;
                    if ($grant_emergency_leave > 0) {
                        $total_emergency_leave = $grant_emergency_leave;
                        $remaining_emergency_leave = $grant_emergency_leave - $emergency_leave;
                    } else {
                        $total_emergency_leave = $program_emergency_leave;
                        $remaining_emergency_leave = $program_emergency_leave - $emergency_leave;
                    }
                ?>
                <p style="<?php echo $remaining_emergency_leave <= 0 ? 'color:orangered;' : ''; ?>"><i class="fa fa-calendar"></i> You have remaining <?php echo $remaining_emergency_leave; ?> days out of <?php echo $total_emergency_leave; ?> days of Emergency Leave</p>
            <?php } ?>
            <?php if($grantee_grant->category_grant == ETA) { ?>
                <?php 
                    $sick_leave = 0;
                    if (isset($sick_leave_day) && is_array($sick_leave_day)) {
                        $sick_leave = array_sum($sick_leave_day);
                    }

                    $grant_sick_leave = $grantee_grant->sick_leave;
                    $program_sick_leave = $grantee_grant->sick_leave_grant;
                    $remaining_sick_leave = 0;
                    $total_sick_leave = 0;
                    if ($grant_sick_leave > 0) {
                        $total_sick_leave = $grant_sick_leave;
                        $remaining_sick_leave = $grant_sick_leave - $sick_leave;
                    } else {
                        $total_sick_leave = $program_sick_leave;
                        $remaining_sick_leave = $program_sick_leave - $sick_leave;
                    }
                ?>
                <p style="<?php echo $remaining_sick_leave <= 0 ? 'color:orangered;' : ''; ?>"><i class="fa fa-calendar"></i> You have remaining <?php echo $remaining_sick_leave; ?> days out of <?php echo $total_sick_leave; ?> days of Sick Leave</p>
            <?php } ?>
        </div>
    </div>  
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="35" class="text-center">#</th>
                        <th>Leave Category</th>
                        <th>Leave (day)</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($data){ $no=$paging['start_row']; foreach($data as $row) { 
                        // echo '<pre>';print_r($row);die;
                        $now = strtotime($row->end_date);
                        $your_date = strtotime($row->start_date);
                        $datediff = $now - $your_date;
                        $leave_day = total_day_leave($row->start_date, $row->end_date);
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= get_label_leave_category($row->leave_category) ?></td>
                        <!-- <td><?= $leave_day ?> Day</td> -->
                        <td><?= $row->total_request . ($row->total_request ? ' Day' : '') ?></td>
                        <td><?= date('d M Y', strtotime($row->start_date)) ?></td>
                        <td><?= date('d M Y', strtotime($row->end_date)) ?></td>
                        <td><?= date('d M Y H:i:s', strtotime($row->date_insert)) ?></td>
                        <td>
                            <?= get_label_status_leave($row->status) ?>
                            <?php if (!empty($row->note)) { ?>
                                <a href="javascript:;" data-toggle="modal" data-target="#mdl_detail_leave" data-leave-id="<?= $row->id ?>" data-gratee-grant-id="<?= $row->grantee_grant_id ?>"><i class="fa fa-info-circle"></i></a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($row->status == LEAVE_PENDING && $grantee_grant->category_grant != ETA){ ?>
                                <a href="javascript:;" class="btn btn-danger btn-xs" onclick="update_status_leave(<?= $row->id ?>)">Cancel</a>
                            <?php } ?>
                            <?php if($row->leave_category == PERSONAL_TRAVEL && $row->status == LEAVE_APPROVE) { ?>
                                <!-- <a href="javascript:;" class="btn btn-primary btn-xs" onclick="update_status_leave($row->id)">Boarding Pass</a> -->
                                <a href="javascript:;" class="btn btn-primary btn-xs" onclick="show_boarding(<?= $row->id ?>)">Boarding Pass</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $no++; } } else { ?>
                    <tr>
                        <td colspan="8" class="text-center" style="padding-bottom: 50px;padding-top: 20px;">No entries found</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
        <div class="pull-left">
            Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?>
            of <?php echo number_format($paging['total_rows']) ?> entries
        </div>
        <!-- /.pagination info -->
        <?php echo $paging['html'] ?>
    </div>
</div>

<!-- Modal For Edit -->
<div class="modal fade" id="mdl_boarding" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Boarding Pass</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form role="form" method="POST" id="form_boarding" enctype="multipart/form-data">
					<input type="hidden" id="leave_id_modal">
					<div class="form-group">
						<label>Upload Boarding Pass</label>
						<div style="margin-bottom:10px; position:relative; width:100px;">
							<img id="preview_image_boarding_pass" src="<?php echo base_url('assets/images/icons/document-filetype.png') ?>" height="100" style="min-height:60px;object-fit:contain;">
						</div>					<div style="margin-bottom:10px; font-size:12px; color:#666;">
						<span id="boarding_pass_filename"></span>
					</div>						<input type="file" class="custom-file-input hide" accept=".jpg,.jpeg,.png,.pdf,.heic" id="boarding_pass" name="boarding_pass" onchange="show_boarding_preview(this);">
						<input type="hidden" name="boarding_pass" value="">
						<label class="btn btn-primary upload-button" for="boarding_pass"> Choose file </label>
						<small class="file-for-testing d-block mt-2">
							File Size Max 5MB | Supported File : JPG, JPEG, PNG, PDF, HEIC
						</small>
					</div>
					<div class="form-group">
			        <img src="<?php echo base_url() ?>/img/loading.gif" id="loading_borading" style="display:none;">
					</div>
				</form>
                
                <div id="tableContainer"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="mdl_detail_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Detail Leave</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form autocomplete="new-password" role="form" id="form_status_leave" method="POST" enctype="multipart/form-data" action="">
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label>Leave Category</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="leave_category" value="" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label>Leave (day)</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="leave_day" value="" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label id="label_start">Start Date</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="start_date" value="" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label id="label_end">End Date</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="end_date" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="section_departure_time">
                    <div class="col-lg-4">
                        <label>Departure Time</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="departure_time" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="destination_form">
                    <div class="col-lg-4">
                        <label>Destination</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="destination" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="destination_purpose_form">
                    <div class="col-lg-4">
                        <label>Destination Purpose</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="destination_purpose" value="" readonly>
                    </div>
                </div>
                <!-- <div class="row form-group" id="section_departure_site_date">
                    <div class="col-lg-4">
                        <label>Date of Departure from Site</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="departure_site_date" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="section_arrival_site_date">
                    <div class="col-lg-4">
                        <label>Date of Arrival from Site</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="arrival_site_date" value="" readonly>
                    </div>
                </div> -->
                <div class="row form-group" id="section_departure_indo_date">
                    <div class="col-lg-4">
                        <label>Date of Departure from Indonesia</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="departure_indo_date" value="" readonly>
                    </div>
                </div>
                <div class="row form-group" id="section_arrival_indo_date">
                    <div class="col-lg-4">
                        <label>Date of Arrival from Indonesia</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="arrival_indo_date" value="" readonly>
                    </div>
                </div>
                
                <div class="row form-group" id="form_upload">
                    <div class="col-lg-4">
                        <label>Form Upload</label>
                    </div>
                    <div class="col-lg-6">
                        <a href="" class="btn btn-primary lightbox" id="form_upload_file">Preview</a>
                    </div>
                </div>
                <!-- <div class="row form-group" id="boarding_pass_form">
                    <div class="col-lg-4">
                        <label>Borading Pass</label>
                    </div>
                    <div class="col-lg-6">
                        <a href="" class="btn btn-primary lightbox" id="borading_pass_file">Preview</a>
                    </div>
                </div> -->
                <div class="row form-group hide" id="telephone">
                    <div class="col-lg-4">
                        <label>Telephone</label>
                    </div>
                    <div class="col-lg-6">
                    <input type="text" class="form-control" id="telephone_val" value="" readonly>
                    </div>
                </div>
                <div class="row form-group hide" id="email">
                    <div class="col-lg-4">
                        <label>Email</label>
                    </div>
                    <div class="col-lg-6">
                    <input type="text" class="form-control" id="email_val" value="" readonly>
                    </div>
                </div>
                <div class="row form-group hide" id="address">
                    <div class="col-lg-4">
                        <label>Address</label>
                    </div>
                    <div class="col-lg-6">
                    <textarea class="form-control" id="address_val" readonly></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label>Status</label>
                    </div>
                    <div class="col-lg-6" id="status-ddown">
                        <select class="form-control" id="status" name="status" readonly>
                            <option value="<?= LEAVE_PENDING ?>">Pending</option>
                            <option value="<?= LEAVE_APPROVE ?>">Approve</option>
                            <option value="<?= LEAVE_REJECT ?>">Reject</option>
                        </select>
                        <input type="hidden" name="id" id="leave_id" value="">
                    </div>
                    <div class="col-lg-6 hide" id="status-cancel">
                        <input type="text" class="form-control" id="v_status" disabled>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label>Note</label>
                    </div>
                    <div class="col-lg-6">
                    <textarea class="form-control" name="note" id="note" readonly></textarea>
                    </div>
                </div>
                <div id="data_table"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (!empty($data)) :
    $final_leave = [];
    foreach ($data as $row) {
        $now = strtotime($row->end_date);
        $your_date = strtotime($row->start_date);
        $datediff = $now - $your_date;
        $leave_day = total_day_leave($row->start_date, $row->end_date);
        $row->leave_day = $leave_day;
        $row->category_name = get_label_leave_category($row->leave_category);
        $final_leave[$row->id] = $row;
    }
?>
    <script>
        var currentLeaveApps = JSON.parse(`<?php echo safe_parse_json(json_encode($final_leave)); ?>`);
    </script>
<?php endif; ?>