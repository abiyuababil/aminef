<div class="row">
    <div class="col-lg-12">
        <h1><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header"><?= $grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?? $grantee_grant->fiscal_year; ?>)</h3>
    </div>
</div>

<form method="POST" autocomplete="new-password" enctype="multipart/form-data" id="form_leave">
<input type="hidden" name="grantee_grant_id" value="<?= $data->grantee_grant_id?>">
<input type="hidden" name="id" value="<?= $data->id?>">
<div class="row">
<div class="panel-body">
    <div class="col-lg-6">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Leave Category</label><span class="text-danger">*</span>
                <select onchange="remove_error('validation-error-leave-category');" name="leave_category" id="leave_category" class="form-control">
                    <option <?= $data->leave_category == PERSONAL_TRAVEL ? 'selected' : '' ?> value="<?= PERSONAL_TRAVEL ?>">Personal Travel</option>
                    <?php if($grantee_grant->category_grant == RESEARCH) { ?>
                    <option <?= $data->leave_category == RESEARCH_TRAVEL ? 'selected' : '' ?> value="<?= RESEARCH_TRAVEL ?>">International Research Travel</option>
                    <?php } ?>
                    <?php if($grantee_grant->category_grant == ETA) { ?>
                    <option <?= $data->leave_category == SICK_LEAVE ? 'selected' : '' ?> value="<?= SICK_LEAVE ?>">Sick Leave</option>
                    <?php } ?>
                    <?php if(in_array($grantee_grant->category_grant, [ETA, TEACHING, RESEARCH])) { ?>
                    <option <?= $data->leave_category ==  EMERGENCY_LEAVE ? 'selected' : '' ?> value="<?= EMERGENCY_LEAVE?>">Emergency Leave</option>
                    <?php } ?>
                </select>
                <div class="text-danger invalid-tooltip validation-error-leave-category hide" style="display: block;">Leave Category is Required</div>
            </div>
            <div class="form-group">
                <label id="total-request-label">Total Requested Travel Days</label><span class="text-danger">*</span>
                <input type="number" onchange="remove_error('validation-error-total-request');" name="total_request" id="total_request" class="form-control" value="<?= $data->total_request ?>">
                <div class="text-danger invalid-tooltip validation-error-total-request hide" style="display: block;">Total Requested Travel Days is Required</div>
            </div>
            <div class="form-group" id="section_destination">
                <label>Destination</label>
                <select name="destination" id="destination" class="form-control">
                    <option value="">-- Select Destination --</option>
                    <option <?= $data->destination == 'domestic' ? 'selected' : '' ?> value="domestic">Domestic</option>
                    <option <?= $data->destination == 'international' ? 'selected' : '' ?> value="international">International</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label id="label_start">Date of Departure from Site</label><span class="text-danger">*</span>
                <input value="<?= $data->start_date ? date('d M Y', strtotime($data->start_date)) : '' ?>" onchange="remove_error('validation-error-start-date');" type="text" name="start_date" id="start_date" class="form-control datepicker" readonly style="background-color:#fff">
                <div class="text-danger invalid-tooltip validation-error-start-date hide">Date of Departure from Site is Required</div>
            </div>
        </div>
        <div class="col-lg-6 hide" id="section_departure_indo_date">
            <div class="form-group">
                <label>Date of Departure from Indonesia</label><span class="text-danger">*</span>
                <input value="<?= $data->departure_indo_date ? date('d M Y', strtotime($data->departure_indo_date)) : '' ?>" onchange="remove_error('validation-error-departure-indo-date');" type="text" name="departure_indo_date" id="departure_indo_date" class="form-control datepickerDate" readonly style="background-color:#fff">
                <div class="text-danger invalid-tooltip validation-error-departure-indo-date hide" style="display: block;">Date of Departure from Indonesia is Required</div>
            </div>
        </div>
        <div class="col-lg-6 hide" id="section_arrival_indo_date">
            <div class="form-group">
                <label>Date of Arrival in Indonesia</label><span class="text-danger">*</span>
                <input value="<?= $data->arrival_indo_date ? date('d M Y', strtotime($data->arrival_indo_date)) : '' ?>"  onchange="remove_error('validation-error-arrival-indo-date');" type="text" name="arrival_indo_date" id="arrival_indo_date" class="form-control datepickerDate" readonly style="background-color:#fff">
                <div class="text-danger invalid-tooltip validation-error-arrival-indo-date hide" style="display: block;">Date of Arrival in Indonesia is Required</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label id="label_end">Date of Arrival at Site</label><span class="text-danger">*</span>
                <input value="<?= $data->end_date ? date('d M Y', strtotime($data->end_date)) : '' ?>" onchange="remove_error('validation-error-end-date');" type="text" name="end_date" id="end_date" class="form-control datepicker" readonly style="background-color:#fff">
                <div class="text-danger invalid-tooltip validation-error-end-date hide" style="display: block;">Date of Arrival at Site is Required</div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group hide" id="section_destination_purpose">
                <label>Destination and Purpose</label>
                <textarea class="form-control" rows="3" name="destination_purpose"><?= $data->destination_purpose ?></textarea>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <?php if($grantee_grant->form_leave) { ?>
        <div class="form-group" id="section_form_upload">
            <label>Form Upload</label>
            <input type="file" class="form-control" name="form_upload">
            <small class="file-for-testing">File Size Max 5MB</small>
            <?php if ($data->form_upload != '') { ?>
                <br>
                <div style="margin-bottom:10px; position:relative; width:100px;" id="file_form">
                    <a href="<?=base_url() ?><?=$data->form_upload ?>" class="lightbox" aria-haspopup="dialog">
                        <img id="preview_image_profile" data-old="<?php echo site_url($data->form_upload); ?>" src="<?php echo get_preview($data->form_upload); ?>" width="100" style="min-height:60px;object-fit:contain;">
                    </a>
                    <a href="<?=base_url() ?><?=$data->form_upload ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                        <i class="fa fa-download fa-fw"></i>
                    </a>
                    <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                        <label class="btn btn-xs btn-danger" onclick="delete_file_upload(this, <?= $data->id ?>)"><i class="fa fa-trash fa-fw"></i></label>
                    </a>
                </div>
            <?php } ?>

        </div>
        <?php } ?>
        <div class="form-group hide" id="research_travel">
            <label>International Research Travel Activities</label>
            <textarea class="editor" name="research_travel_activities"><?= $data->research_travel_activities ?></textarea>
        </div>
    
        <?php if($grantee_grant->show_departure_time) { ?>
            <div class="form-group">
                <label>Departure Time</label>
                <input type="time" class="form-control" name="departure_time" value="<?= $data->departure_time ?>">
            </div>
        <?php } ?>
    </div>
</div>
<div class="panel-body" style="margin-top:-30px;" id="section_contact">
<hr>
    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Contact address & telephone number during above period (in case of emergencies).</p>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Telephone</label>
            <input type="text" name="telephone" class="form-control" value="<?= $data->telephone ?>">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $data->email ?>">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Address</label>
            <textarea class="form-control" rows="3" name="address"><?= $data->address ?></textarea>
        </div>
    </div>
</div>
<div class="panel-body" style="margin-top:-30px;">
<hr>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Status</label>
            <select class="form-control" id="status" name="status">
                <option <?= $data->status == LEAVE_PENDING ? 'selected' : '' ?> value="<?= LEAVE_PENDING ?>">Pending</option>
                <option <?= $data->status == LEAVE_APPROVE ? 'selected' : '' ?> value="<?= LEAVE_APPROVE ?>">Approve</option>
                <option <?= $data->status == LEAVE_REJECT ? 'selected' : '' ?> value="<?= LEAVE_REJECT ?>">Reject</option>
            </select>

        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Note</label>
            <textarea class="form-control" name="note" id="note"><?= $data->note ?></textarea>
        </div>
    </div>
    <?php if($boarding_pass) { ?>
    <div class="col-lg-8">
        <label>Boarding Pass</label>
        <table id="data_table" class="table table-striped table-hover" width="100%">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Upload Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($boarding_pass as $row_b) { ?>
                <tr>
                    <td><a class="lightbox" href="<?= base_url($row_b->file) ?>"><?= file_name($row_b->file) ?></a></td>
                    <td><?= $row_b->insert_date ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
<div class="panel-body" style="margin-top:-30px;">
    <div class="col-lg-12">
        <a href="<?= base_url('admin/travel_request/manage') ?>" class="btn btn-default">Back</a>
        <button type="button" id="btn-submit" class="btn btn-primary">Save</button>
    </div>
</div>
</form>


<?php 
    $total_personal_travel = array_sum($personal_travel_day);
    $total_sick = array_sum($sick_leave_day);
    $total_emergency = array_sum($emergency_leave_day);
    $total_research = array_sum($research_leave_day);
    
?>
<script>
    var totalPersonalTravel = <?= $total_personal_travel ?>;
    var totalSick = <?= $total_sick ?>;
    var totalEmergency = <?= $total_emergency ?>;
    var totalResearch = <?= $total_research ?>;
    var granteeGrantPersonalTravel = <?= $grantee_grant->personal_travel != 0  ? $grantee_grant->personal_travel : $grantee_grant->personal_travel_grant ?>;
    var granteeGrantSick = <?= $grantee_grant->sick_leave != 0  ? $grantee_grant->sick_leave : $grantee_grant->sick_leave_grant ?>;
    var granteeGrantEmergency = <?= $grantee_grant->emergency_leave != 0  ? $grantee_grant->emergency_leave : $grantee_grant->emergency_leave_grant ?>;
    var granteeResearch = <?= $grantee_grant->research_leave != 0  ? $grantee_grant->research_leave : $grantee_grant->research_leave_grant ?>;
</script>