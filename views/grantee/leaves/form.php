<style>
    #success-alert {
        position: fixed;
        top: 165px;
        right: 40px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }
</style>
<style>
    input[type="time"] {
        position: relative;
    }

    input[type="time"]::-webkit-calendar-picker-indicator {
        display: block;
        top: 0;
        right: 0;
        height: 100%;
        width: 100%;
        position: absolute;
        background: transparent;
    }
</style>

<div class="alert alert-danger" id="success-alert" style="width:260px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <span id="label-for-date"></span>
</div>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center"><?php echo $title; ?></h1>
    </div>
</div>
<form method="POST" autocomplete="new-password" enctype="multipart/form-data" id="form_leave">
<div class="panel-body">
    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> New <?php echo $title; ?></p>
    <div class="col-lg-12">
        <div class="alert alert-info">
            <p style="<?php echo ($grantee_grant->personal_travel_grant - (!$personal_travel_day ? 0 : array_sum($personal_travel_day))) <= 0 ? 'color:orangered;' : ''; ?>"><i class="fa fa-calendar"></i> Your remaining leave <?= ($grantee_grant->personal_travel != 0  ? $grantee_grant->personal_travel : $grantee_grant->personal_travel_grant) - array_sum($personal_travel_day) ?> days out of <?= $grantee_grant->personal_travel != 0  ? $grantee_grant->personal_travel :  $grantee_grant->personal_travel_grant ?> days of Personal Travel</p>
            <?php if($grantee_grant->category_grant == RESEARCH) { ?>
                <p style="<?php echo ($grantee_grant->research_leave_grant - (!$research_leave_day ? 0 : array_sum($research_leave_day))) <= 0 ? 'color:orangered;' : ''; ?>"><i class="fa fa-calendar"></i> Your remaining leave <?= ($grantee_grant->research_leave != 0  ? $grantee_grant->research_leave : $grantee_grant->research_leave_grant) - array_sum($research_leave_day) ?> days out of <?= $grantee_grant->research_leave != 0  ? $grantee_grant->research_leave : $grantee_grant->research_leave_grant ?> days of International Research Travel</p>
            <?php } ?>
            <?php if(in_array($grantee_grant->category_grant, [ETA, TEACHING, RESEARCH])) { ?>
                <p style="<?php echo ($grantee_grant->emergency_leave_grant - (!$emergency_leave_day ? 0 : array_sum($emergency_leave_day))) <= 0 ? 'color:orangered;' : ''; ?>"><i class="fa fa-calendar"></i> Your remaining leave <?= ($grantee_grant->emergency_leave != 0  ? $grantee_grant->emergency_leave : $grantee_grant->emergency_leave_grant) - array_sum($emergency_leave_day) ?> days out of <?= $grantee_grant->emergency_leave != 0  ? $grantee_grant->emergency_leave : $grantee_grant->emergency_leave_grant ?> days of Emergency Leave</p>
            <?php } ?>
            <?php if($grantee_grant->category_grant == ETA) { ?>
            <p style="<?php echo ($grantee_grant->sick_leave_grant - (!$sick_leave_day ? 0 : array_sum($sick_leave_day))) <= 0 ? 'color:orangered;' : ''; ?>"><i class="fa fa-calendar"></i> Your remaining leave <?= ($grantee_grant->sick_leave != 0  ? $grantee_grant->sick_leave : $grantee_grant->sick_leave_grant) - array_sum($sick_leave_day) ?> days out of <?= $grantee_grant->sick_leave != 0  ? $grantee_grant->sick_leave : $grantee_grant->sick_leave_grant ?> days of Sick Leave</p>
            <?php } ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="alert alert-danger hide alert-total">You have exceeded your available leave days. Please adjust your request to match your remaining leave balance.</div>
    </div>
    <div class="col-lg-6">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Leave Category</label><span class="text-danger">*</span>
                <select onchange="remove_error('validation-error-leave-category');" name="leave_category" id="leave_category" class="form-control">
                    <option value="<?= PERSONAL_TRAVEL ?>">Personal Travel</option>
                    <?php if($grantee_grant->category_grant == RESEARCH) { ?>
                    <option value="<?= RESEARCH_TRAVEL ?>">International Research Travel</option>
                    <?php } ?>
                    <?php if($grantee_grant->category_grant == ETA) { ?>
                    <option value="<?= SICK_LEAVE ?>">Sick Leave</option>
                    <?php } ?>
                    <?php if(in_array($grantee_grant->category_grant, [ETA, TEACHING, RESEARCH])) { ?>
                    <option value="<?= EMERGENCY_LEAVE?>">Emergency Leave</option>
                    <?php } ?>
                </select>
                <div class="text-danger invalid-tooltip validation-error-leave-category hide" style="display: block;">Leave Category is Required</div>
            </div>
            <div class="form-group">
                <label id="total-request-label">Total Requested Travel Days</label><span class="text-danger">*</span>
                <input type="number" onchange="remove_error('validation-error-total-request');" name="total_request" id="total_request" class="form-control">
                <div class="text-danger invalid-tooltip validation-error-total-request hide" style="display: block;">Total Requested Travel Days is Required</div>
            </div>
            <div class="form-group" id="section_destination">
                <label>Destination</label>
                <?php if ($grantee_grant->category_grant == ETA) { ?>
                    <span class="text-danger">*</span>
                <?php } ?>
                <select name="destination" id="destination" class="form-control">
                    <option value="">-- Select Destination --</option>
                    <option value="domestic">Domestic</option>
                    <option value="international">International</option>
                </select>
                <div class="text-danger invalid-tooltip validation-error-destination hide">Destination is Required</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label id="label_start">Date of Departure from Site</label><span class="text-danger">*</span>
                <input onchange="remove_error('validation-error-start-date');" type="text" name="start_date" id="start_date" class="form-control datepicker" readonly style="background-color:#fff">
                <div class="text-danger invalid-tooltip validation-error-start-date hide">Date of Departure from Site is Required</div>
            </div>
        </div>
        <div class="col-lg-6 hide" id="section_departure_indo_date">
            <div class="form-group">
                <label>Date of Departure from Indonesia</label><span class="text-danger">*</span>
                <input onchange="remove_error('validation-error-departure-indo-date');" type="text" name="departure_indo_date" id="departure_indo_date" class="form-control datepickerDate" readonly style="background-color:#fff">
                <div class="text-danger invalid-tooltip validation-error-departure-indo-date hide" style="display: block;">Date of Departure from Indonesia is Required</div>
            </div>
        </div>
        <div class="col-lg-6 hide" id="section_arrival_indo_date">
            <div class="form-group">
                <label>Date of Arrival in Indonesia</label><span class="text-danger">*</span>
                <input onchange="remove_error('validation-error-arrival-indo-date');" type="text" name="arrival_indo_date" id="arrival_indo_date" class="form-control datepickerDate" readonly style="background-color:#fff">
                <div class="text-danger invalid-tooltip validation-error-arrival-indo-date hide" style="display: block;">Date of Arrival in Indonesia is Required</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label id="label_end">Date of Arrival at Site</label><span class="text-danger">*</span>
                <input onchange="remove_error('validation-error-end-date');" type="text" name="end_date" id="end_date" class="form-control datepicker" readonly style="background-color:#fff">
                <div class="text-danger invalid-tooltip validation-error-end-date hide" style="display: block;">Date of Arrival at Site is Required</div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group hide" id="section_destination_purpose">
                <label>Destination and Purpose</label>
                <?php if ($grantee_grant->category_grant == ETA) { ?>
                    <span class="text-danger">*</span>
                <?php } ?>
                <textarea class="form-control" rows="3" name="destination_purpose"></textarea>
                <div class="text-danger invalid-tooltip validation-error-destination-purpose hide">Destination and Purpose is Required</div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <?php if($grantee_grant->form_leave) { ?>
            <div class="form-group" id="section_form_upload">
                <label>Form Upload</label>
                <span id="required-form-upload" class="text-danger <?php echo $grantee_grant->category_grant == ETA ? '' : 'hide'; ?>">*</span>
                <span id="download-template-form" class="hide">
                    <a href="" download target="_blank">Download Template</a>
                </span>
                <input type="file" class="form-control" name="form_upload">
                <small class="file-for-testing">File Size Max 5MB</small>
                <div class="text-danger invalid-tooltip validation-error-form-upload hide">Form Upload is Required</div>
            </div>
        <?php } ?>
        <div class="form-group hide" id="research_travel">
            <label>International Research Travel Activities</label>
            <textarea class="editor" name="research_travel_activities"></textarea>
        </div>
    
        <?php if($grantee_grant->show_departure_time) { ?>
            <div class="form-group">
                <label>Departure Time</label>
                <input type="time" class="form-control" name="departure_time">
            </div>
        <?php } ?>
    </div>
    <!-- <div class="col-lg-3" id="section_departure_site_date">
        <div class="form-group">
            <label>Date of Departure from Site</label>
            <input onchange="remove_error('validation-error-departure-site-date');" type="text" name="departure_site_date" id="departure_site_date" class="form-control datepickerDate" readonly style="background-color:#fff">
            <div class="text-danger invalid-tooltip validation-error-departure-site-date hide" style="display: block;">Date of Departure from Site is Required</div>
        </div>
    </div>
    <div class="col-lg-3" id="section_arrival_site_date">
        <div class="form-group">
            <label>Date of Arrival at Your Site</label>
            <input onchange="remove_error('validation-error-arrival-site--date');" type="text" name="arrival_site_date" id="arrival_site_date" class="form-control datepickerDate" readonly style="background-color:#fff">
            <div class="text-danger invalid-tooltip validation-error-arrival-site--date hide" style="display: block;">Date of Arrival at Your Site is Required</div>
        </div>
    </div> -->
</div>

<div class="panel-body" style="margin-top:-30px;">
    <div class="col-lg-6">
        <div class="row">
        <!-- <div class="col-lg-6" id="section_boarding_pass">
            <div class="form-group">
                <label>Boarding Pass</label>
                <input type="file" class="form-control" name="boarding_pass">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
        </div> -->
        </div>
    </div>
</div>
<div class="panel-body" style="margin-top:-30px;" id="section_contact">
<hr>
    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Contact address & telephone number during above period (in case of emergencies).</p>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Telephone</label>
            <?php if ($grantee_grant->category_grant == ETA) { ?>
                <span class="international-travel-required text-danger hide">*</span>
            <?php } ?>
            <input type="text" name="telephone" class="form-control">
            <div class="text-danger invalid-tooltip validation-error-contact-phone international-travel-required hide">Destination and Purpose is Required</div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Email</label>
            <?php if ($grantee_grant->category_grant == ETA) { ?>
                <span class="international-travel-required text-danger hide">*</span>
            <?php } ?>    
            <input type="email" name="email" class="form-control">
            <div class="text-danger invalid-tooltip validation-error-email-contact international-travel-required hide">Destination and Purpose is Required</div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Address</label>
             <?php if ($grantee_grant->category_grant == ETA) { ?>
                <span class="international-travel-required text-danger hide">*</span>
            <?php } ?>   
            <textarea class="form-control" rows="3" name="address"></textarea>
            <div class="text-danger invalid-tooltip validation-error-contact-address international-travel-required hide">Destination and Purpose is Required</div>
        </div>
    </div>
</div>
<div class="panel-body" style="margin-top:-30px;">
    <div class="col-lg-12">
        <a href="<?= base_url('grantee/leaves/list/'.$this->session->userdata('grantee_user_id')) ?>" class="btn btn-default">Back</a>
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