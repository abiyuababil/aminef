
<?php if(!$is_admin) { ?>
    <input id="show_transportation" class="select_show hidden" value="<?= $visa_interview->show_transportation ?>">
    <input id="show_accomodation" class="select_show hidden" value="<?= $visa_interview->show_accomodation ?>">
<?php } ?>
<?php if($is_admin && has_permission('nominee', 'departure')){ ?>
<hr />
<label>Show Transportation</label>
<select class="form-control select_show" name="show_transportation" id="show_transportation">
    <option value="">- Select -</option>
    <option <?= $visa_interview->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
    <option <?= $visa_interview->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
    <option <?= $visa_interview->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

</select>
<label class="mt-3">Show Accommodation</label>
<select class="form-control select_show" name="show_accomodation" id="show_accomodation">
    <option value="">- Select -</option>
    <option <?= $visa_interview->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
    <option <?= $visa_interview->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
    <option <?= $visa_interview->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

</select>
<?php } ?>
<ul class="mt-3">
    <li class="<?= $visa_interview->show_transportation == 'Yes' || $visa_interview->show_accomodation == 'Yes' || $visa_interview->show_transportation == 'Reimbursement' || $visa_interview->show_accomodation == 'Reimbursement' ? '' : 'hide' ?> section-reminder"><b>Travel Arrangement</b></li>
    <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn my-5 btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
        <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
    </a>
    <div class="panel-body <?= $visa_interview->show_transportation == 'Yes' || $visa_interview->show_transportation == 'Reimbursement' ? '' : 'hide' ?> section-transportation" style="margin-top:-20px">
        <div class="col-lg-12">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Departure Date</label>
                <input 
                    id="departure_date" 
                    type="text" 
                    class="form-control datepicker" 
                    readonly style="background-color:<?= $visa_interview_appointment_status['style_transportation'] ?>" 
                    placeholder="Departure Date" 
                    name="departure_date" 
                    value="<?= $visa_interview  ? ($visa_interview->departure_date != '' ? date('d M Y', strtotime($visa_interview->departure_date)) : '') : '' ?>" 
                    <?= $visa_interview_appointment_status['disable_transportation'] ?>
                >
                <?php if(!$is_admin || ($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                    <?php if($visa_interview_appointment_status['show_transportation']){ ?>
                        <a href="javascript:;" 
                        onclick="emptyValue(this)" 
                        class="btn btn-secondary" 
                        style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Returning Date</label>
                <input 
                    id="returning_date" 
                    type="text" 
                    class="form-control datepicker" 
                    readonly style="background-color:<?= $visa_interview_appointment_status['style_transportation'] ?>" 
                    placeholder="Returning Date" 
                    name="returning_date" 
                    value="<?= $visa_interview  ? ($visa_interview->returning_date != '' ? date('d M Y', strtotime($visa_interview->returning_date)) : '') : '' ?>" 
                    <?= $visa_interview_appointment_status['disable_transportation'] ?>
                >
                <?php if(!$is_admin || ($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                    <?php if($visa_interview_appointment_status['show_transportation']){ ?>
                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Departure City</label>
                <input id="departure_city" type="text" class="form-control" placeholder="Departure City" name="departure_city" value="<?= $visa_interview ? $visa_interview->departure_city : '' ?>" <?= $visa_interview_appointment_status['disable_transportation'] ?>>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Arrival City</label>
                <input id="arrival_city" type="text" class="form-control" placeholder="Destination City" name="arrival_city" value="<?= $visa_interview ? $visa_interview->arrival_city : '' ?>" <?= $visa_interview_appointment_status['disable_transportation'] ?>>
            </div>
        </div>
        <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Travel Agent</label>
                <select name="travel_agent_visa_interview" class="form-control selectpicker" data-live-search="true">
                    <option value="">-- Select --</option>
                    <?php foreach($travel_agents as $travel_agent) { 
                        $selected = '';
                        if ($visa_interview->travel_agent_visa_interview == $travel_agent->id) {
                            $selected = 'selected="selected"';
                        }?>
                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php } ?>
        <?php if (($visa_interview && $visa_interview->eticket != '') || $is_admin || (!$is_admin && $visa_interview->show_transportation == 'Reimbursement')) { ?>
        <div class="col-lg-4">
            <div class="form-group">
                <label id="label_eticket"><?= $visa_interview->show_transportation == 'Reimbursement' ? 'Receipt' : 'E-Ticket' ?></label>
                <?php if($is_admin || $visa_interview_appointment_status['show_transportation']) { ?>
                <input id="eticket" type="file" class="form-control" name="eticket">
                <?php } ?>
                <?php if ($visa_interview && $visa_interview->eticket != '') { ?>
                    <br>
                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket">
                        <a href="<?=base_url() ?><?=$visa_interview->eticket ?>" class="lightbox" aria-haspopup="dialog">
                            <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->eticket); ?>" src="<?php echo get_preview($visa_interview->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="<?=base_url() ?><?=$visa_interview->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                        <?php if($visa_interview_appointment_status['show_transportation']) { ?>
                        <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                            <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'eticket', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                        </a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        <div class="col-lg-4">
            <div class="form-group">
                <label>KTP</label>
                <!-- <input readonly id="ktp" type="text" class="form-control" name="ktp" value="<?= $grantee_grant->img_passport ?>"> -->
                <?php if ($grantee_grant->img_passport != '') { ?>
                    <br>
                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_ktp">
                        <a href="<?=base_url() ?><?=$grantee_grant->img_passport ?>" class="lightbox" aria-haspopup="dialog">
                            <img id="preview_image_profile" data-old="<?php echo site_url($grantee_grant->img_passport); ?>" src="<?php echo get_preview($grantee_grant->img_passport); ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="<?=base_url() ?><?=$grantee_grant->img_passport ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($grantee_grant->img_passport) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
        <div class="panel-body">
            <div class="col-lg-4">
                <div class="form-group ">
                    <label>Status Transportation</label>
                    <select name="status_transportation_visa_interview" class="form-control">
                        <option <?= $visa_interview->status_transportation_visa_interview == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                        <option <?= $visa_interview->status_transportation_visa_interview == 'done' ? 'selected' : '' ?> value="done">Done</option>
                    </select>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <div class="panel-body <?= $visa_interview->show_accomodation == 'Yes' ? '' : 'hide' ?> section-accomodation" style="margin-top:-20px">
        <div class="col-lg-12">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Check In Date</label>
                <input id="checkin_date" type="text" class="form-control datepicker" readonly style="background-color:<?= $visa_interview_appointment_accomodation_status['style_transportation'] ?>" placeholder="Check In Date" name="checkin_date" value="<?= $visa_interview  ? ($visa_interview->checkin_date != '' ? date('d M Y', strtotime($visa_interview->checkin_date)) : '') : '' ?>" <?= $visa_interview_appointment_accomodation_status['disable_transportation'] ?>>
                <?php if(!$is_admin || ($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                    <?php if($visa_interview_appointment_accomodation_status['show_transportation']) { ?>
                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Check Out Date</label>
                <input id="checkout_date" type="text" class="form-control datepicker" readonly style="background-color:<?= $visa_interview_appointment_accomodation_status['style_transportation'] ?>" placeholder="Check Out Date" name="checkout_date" value="<?= $visa_interview  ? ($visa_interview->checkout_date != '' ? date('d M Y', strtotime($visa_interview->checkout_date)) : '') : '' ?>" <?= $visa_interview_appointment_accomodation_status['disable_transportation'] ?>>
                <?php if(!$is_admin || ($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                    <?php if($visa_interview_appointment_accomodation_status['show_transportation']) { ?>
                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php if (($grantee_grant && $visa_interview->voucher_hotel != '') || $is_admin || (!$is_admin && $visa_interview->show_accomodation == 'Reimbursement')) { ?>
        <div class="col-lg-4">
            <div class="form-group">
                <label id="label_voucher_hotel"><?= $visa_interview->show_accomodation == 'Reimbursement' ? 'Receipt' : 'Hotel Voucher' ?></label>
                <?php if($is_admin || $visa_interview_appointment_accomodation_status['show_transportation']) { ?>
                <input id="voucher_hotel" type="file" class="form-control" name="voucher_hotel">
                <?php } ?>
                <?php if ($grantee_grant && $visa_interview->voucher_hotel != '') { ?>
                <br>
                <div style="margin-bottom:10px; position:relative; width:100px;" id="file_voucher_hotel">
                    <a href="<?=base_url() ?><?=$visa_interview->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                        <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->voucher_hotel); ?>" src="<?php echo get_preview($visa_interview->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                    </a>
                    <a href="<?=base_url() ?><?=$visa_interview->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                        <i class="fa fa-download fa-fw"></i>
                    </a>
                    <?php if($is_admin || $visa_interview_appointment_accomodation_status['show_transportation']) { ?>
                    <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                        <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'voucher_hotel', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                    </a>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
        <div class="panel-body">
            <div class="col-lg-4">
                <div class="form-group ">
                    <label>Status Accommodation</label>
                    <select name="status_accommodation_visa_interview" class="form-control">
                        <option <?= $visa_interview->status_accommodation_visa_interview == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                        <option <?= $visa_interview->status_accommodation_visa_interview == 'done' ? 'selected' : '' ?> value="done">Done</option>
                    </select>
                </div>
            </div>
        </div>
    <?php } ?>
</ul>