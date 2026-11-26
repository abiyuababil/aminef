<div id="wrap-interview" class="warp-alumni-page">
    <?php if(has_permission('selection', 'interview')) { ?>
    <div class="panel-body" <?= $is_alumni_page ? '' : 'style="margin-top:-30px"' ?>>
        <div class="col-lg-12 mb-3 <?= $is_alumni_page ? 'hide' : '' ?>">
            <label>Enable Biosketch</label>
            <label class="switch">
            <input  data-id="<?= $grantee_grant->id ?>" type="checkbox" id="enable_biosketch" class="enable_biosketch" name="enable_biosketch" <?= $grantee_grant->enable_biosketch  ? 'checked' : '' ?>>
            <span class="slider round"></span>
            </label>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Biosketch</label>
                <textarea <?= $disabled_form ?> class="form-control" name="biosketch" cols="30" rows="5" style="resize:none;"><?= $interviews ? $grantee_grant->short_bio_field : '' ?></textarea>
            </div>  
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Final Biosketch</label>
                <textarea <?= $disabled_form ?> class="form-control" name="final_biosketch" cols="30" rows="5" style="resize:none;"><?= $interviews ? $grantee_grant->final_biosketch : '' ?></textarea>
            </div>  
        </div>
    </div>
    <div class="panel-body" style="margin-top:-20px">
        <div class="col-lg-4">
            <div class="form-group">
                <label>Interview Date</label>
                <input <?= $disabled_form ?> id="date_0" class="form-control datepicker" readonly style="background-color:#fff" name="date" value="<?= $interviews  ? ($grantee_grant->date_interview != '' ? date('d M Y', strtotime($grantee_grant->date_interview)) : '') : '' ?>" placeholder="Date">
                <?php if(!$disabled_form) { ?>
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Interview Time</label>
                <input 
                    <?= $disabled_form ?> 
                    type="text" 
                    id="time_0" 
                    class="form-control input_time" 
                    name="time" 
                    value="<?= $interviews  ? ($grantee_grant->date_interview != '' ? (date('H:i', strtotime($grantee_grant->date_interview)) == '00:00' ? '' : date('h:i A', strtotime($grantee_grant->date_interview)) ) : '') : '' ?>" 
                    placeholder="Time">
                    <?php if(!$disabled_form) { ?>
                    <a href="javascript:;" onclick="emptyValueTime(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    <?php } ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label style="margin-right:20px">Interview Format</label><br />
                <select name="interview_format" class="form-control">
                    <option value="">- Select -</option>
                    <option <?= $interviews ? ($grantee_grant->interview_format == 'online' ? 'selected' : '') : '' ?> value="online">Online</option>
                    <option <?= $interviews ? ($grantee_grant->interview_format == 'offline' ? 'selected' : '') : '' ?> value="offline">Offline</option>
                </select>
                <!-- <div class="radio d-inline mr-4">
                    <label>
                        <input type="radio" 
                        <?= $disabled_form ?>
                        <?= $interviews ? ($grantee_grant->interview_format == 'online' ? 'checked' : '') : '' ?>
                        class="grant-alumni" 
                        name="interview_format" 
                        style="margin-top:1px" 
                        value="online">
                        Online
                    </label>
                </div>
                <div class="radio d-inline">
                    <label>
                        <input type="radio" 
                        <?= $disabled_form ?>
                        <?= $interviews ? ($grantee_grant->interview_format == 'offline' ? 'checked' : '') : '' ?>
                        class="grant-alumni" 
                        name="interview_format" 
                        style="margin-top:1px" 
                        value="offline">
                        Offline
                    </label>
                </div> -->
            </div>  
        </div>
    </div>
    <div class="panel-body" style="margin-top:-30px">
        <div class="col-lg-4">
            <div class="form-group">
                <label>PIC</label>
                <select name="pic" class="form-control <?= $is_alumni_page ? '' : 'select2'?>">
                    <option value="">-- Select --</option>
                    <?php foreach($pics as $pic) { 
                        $selected = '';
                        if ($grantee_grant->pic == $pic->id) {
                            $selected = 'selected="selected"';
                        }?>
                        <option value="<?php echo $pic->id ?>" <?php echo $selected ?>><?php echo $pic->name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Venue</label>
                <!-- <input <?= $disabled_form ?> type="text" class="form-control" placeholder="Venue" name="interview[0][location]" value="<?= $interviews ? $grantee_grant->location : '' ?>"> -->
                <textarea <?= $disabled_form ?> class="form-control" name="location" cols="30" rows="5"><?= $interviews ? $grantee_grant->location : '' ?></textarea>
            </div>  
        </div>
        <?php if($grant->voucher_duolingo){ ?>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Voucher Duolingo</label>
                <input <?= $disabled_form ?> type="text" class="form-control" placeholder="Voucher Duolingo" name="voucher_duolingo" value="<?= $interviews ? $grantee_grant->voucher_duolingo : '' ?>">
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
    <div class="panel-body">
        <div class="col-lg-12">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Grantee</p>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Email</label>
                <input type="text" disabled class="form-control" value="<?= $grantee->primary_email ?>">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>KTP</label>
                <input type="text" disabled class="form-control" value="<?= $grantee->number_identity ?>">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" disabled class="form-control" value="<?= $grantee->phone_number ?>">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Gender</label>
                <input type="text" disabled class="form-control" value="<?= $grantee->gender ?>">
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if(has_permission('selection', 'interview')) { ?>
    <div class="panel-body <?= $is_alumni_page ? 'hide' : '' ?>" style="margin-bottom:20px;">
        <label>Show Transportation</label>
        <select class="form-control select_show" name="show_transportation" id="show_transportation" onchange="show_hide_transportation(this, 'interview', 0)">
            <option value="">- Select -</option>
            <option <?= $grantee_grant->show_transportation_interview == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
            <option <?= $grantee_grant->show_transportation_interview == 'No' ? 'selected' : '' ?> value="No">No</option>
            <option <?= $grantee_grant->show_transportation_interview == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

        </select>
        <label class="mt-3">Show Accommodation</label>
        <select class="form-control select_show" name="show_accomodation" id="show_accomodation" onchange="show_hide_accomodation(this, 'interview', 0)">
            <option value="">- Select -</option>
            <option <?= $grantee_grant->show_accomodation_interview == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
            <option <?= $grantee_grant->show_accomodation_interview == 'No' ? 'selected' : '' ?> value="No">No</option>
            <option <?= $grantee_grant->show_accomodation_interview == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

        </select>
    </div>
    <?php } ?>
    <?php if(has_permission('selection', 'transportation_interview')) { ?>
    <div class="panel-body section-transportation-interview-0" style="margin-top:-20px;margin-bottom:-20px;">
        <div class="col-lg-12">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Departure City</label>
                <input id="origin_city_0" type="text" class="form-control" placeholder="Departure City" name="origin_city" value="<?= $interviews ? $grantee_grant->origin_city : '' ?>">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Destination City</label>
                <input id="destination_city_0" type="text" class="form-control" placeholder="Destination City" name="destination_city" value="<?= $interviews ? $grantee_grant->destination_city : '' ?>">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Departure Date</label>
                <input id="departure_date_0" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="departure_date" value="<?= $interviews  ? ($grantee_grant->departure_date != '' ? date('d M Y', strtotime($grantee_grant->departure_date)) : '') : '' ?>">
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Returning Date</label>
                <input id="returning_date_0" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Returning Date" name="returning_date" value="<?= $interviews  ? ($grantee_grant->returning_date != '' ? date('d M Y', strtotime($grantee_grant->returning_date)) : '') : '' ?>">
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Travel Agent</label>
                <select name="travel_agent" class="form-control <?= $is_alumni_page ? '' : 'select2' ?>">
                    <option value="">-- Select --</option>
                    <?php foreach($travel_agents as $travel_agent) { 
                        $selected = '';
                        if ($grantee_grant->travel_agent_id == $travel_agent->id) {
                            $selected = 'selected="selected"';
                        }?>
                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label id="label_eticket_interview_0">E-Ticket</label>
                <input id="eticket_0" type="file" class="form-control" name="eticket">
                <?php if ($interviews && $grantee_grant->eticket != '') { ?>
                    <br>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?=base_url() ?><?=$grantee_grant->eticket ?>" class="lightbox" aria-haspopup="dialog">
                            <img id="preview_image_profile" data-old="<?php echo site_url($grantee_grant->eticket); ?>" src="<?php echo get_preview($grantee_grant->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="<?=base_url() ?><?=$grantee_grant->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($grantee_grant->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                        <a href="<?=base_url('admin/set_interview/delete_file/'.$grantee_grant->id.'/eticket') ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                            <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                        </a>
                    </div>
                    <!-- <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?=base_url() ?><?=$grantee_grant->eticket ?>"  class="lightbox" target="_blank"><label class="btn btn-primary btn-sm" style="cursor:pointer">View</label></a>
                    </div> -->
                <?php } ?>
            </div>
        </div>
    </div>
    <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
    <div class="panel-body">
        <div class="col-lg-4">
            <div class="form-group ">
                <label>Status Transportation</label>
                <select name="status_tba" class="form-control">
                    <option <?= $grantee_grant->status_tba == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                    <option <?= $grantee_grant->status_tba == 'done' ? 'selected' : '' ?> value="done">Done</option>
                </select>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
    <!-- Accommodation -->
    <?php if(has_permission('selection', 'accomodation_interview')) { ?>
    <div class="panel-body section-accomodation-interview-0">
        <div class="col-lg-12">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Check In Date</label>
                <input id="checkin_date_0" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check In Date" name="checkin_date" value="<?= $interviews  ? ($grantee_grant->checkin_date != '' ? date('d M Y', strtotime($grantee_grant->checkin_date)) : '') : '' ?>">
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Check Out Date</label>
                <input id="checkout_date_0" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check Out Date" name="checkout_date" value="<?= $interviews  ? ($grantee_grant->checkout_date != '' ? date('d M Y', strtotime($grantee_grant->checkout_date)) : '') : '' ?>">
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label id="label_voucher_hotel_interview_0">Hotel Voucher</label>
                <input id="voucher_hotel_0" type="file" class="form-control" name="voucher_hotel">
                <?php if ($grantee_grant && $grantee_grant->voucher_hotel != '') { ?>
                    <br>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?=base_url() ?><?=$grantee_grant->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                            <img id="preview_image_profile" data-old="<?php echo site_url($grantee_grant->voucher_hotel); ?>" src="<?php echo get_preview($grantee_grant->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="<?=base_url() ?><?=$grantee_grant->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($grantee_grant->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                        <a href="<?=base_url('admin/set_interview/delete_file/'.$grantee_grant->id.'/voucher_hotel') ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                            <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                        </a>
                    </div>
                    <!-- <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?=base_url() ?><?=$grantee_grant->voucher_hotel ?>"  class="lightbox" target="_blank"><label class="btn btn-primary btn-sm" style="cursor:pointer">View</label></a>
                    </div> -->
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
    <div class="panel-body">
        <div class="col-lg-4">
            <div class="form-group ">
                <label>Status Accommodation</label>
                <select name="status_tba_accommodation" class="form-control">
                    <option <?= $grantee_grant->status_tba_accommodation == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                    <option <?= $grantee_grant->status_tba_accommodation == 'done' ? 'selected' : '' ?> value="done">Done</option>
                </select>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if(has_permission('selection', 'interview')) { ?>
    <?php if($interviews) { ?>
        <div id="w-interview" style="margin-top:-20px">
            <div class="panel-body" style="margin-top:-20px">
                <div class="col-lg-12">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> INTERVIEW SELECTION</p>
                </div>
            </div>
            <?php foreach($interviews as $key => $row) { ?>
            <?php 
                $del_btn = '';
                if ($key > 0 && has_permission('selection', 'interview')) {
                    $del_btn = $is_alumni_page ? '' : '<a href="javascript:;" onclick="del_item_interview(this, \'interview-item\','.$row->id.')" class="btn btn-danger" style="float:right"><i class="fa fa-trash fa-fw"></i></a>';
                } 
            ?>
                <div id="interview-item-<?= $key ?>" class="interview-item" style="position:relative;" style="margin-top:-20px">
                <?php if($key > 0) { ?> <hr style="border: 1px solid #eee;"> <?php } ?>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <?= $del_btn ?>
                        </div>
                    </div>
                    <div class="panel-body" style="margin-top:-20px">
                        <div class="col-lg-12 mb-3 <?= $is_alumni_page ? 'hide' : '' ?>">
                            <label>Allow Score Editing</label>
                            <label class="switch">
                            <input  data-id="<?= $row->id ?>" type="checkbox" id="lock_interview" class="lock_interview_check" name="lock_interview" <?= $row->lock_interview  ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                            </label>
                            <!-- <div class="TriSea-technologies-Switch">
                                <span class="mr-2"><b>Lock Interview Score</b></span>
                                <input data-id="<?= $row->id ?>" onchange="return alert(<?= $row->id ?>)" id="lock_interview" class="lock_interview_check" name="lock_interview" type="checkbox" <?= $row->lock_interview  ? 'checked' : '' ?>/>
                                <label for="lock_interview" class="label-primary"></label>
                            </div> -->
                            <?php if($row->submitted_at) { ?>
                            <u style="display:inline-block; margin-left:20px;">Submitted on <?= date('F j, Y H:i:s', strtotime($row->submitted_at)) ?></u>
                            <?php } ?>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Name of Panelist</label>
                                <input type="hidden" value="<?= $row->id?>" name="interview[<?= $key ?>][interview_id]">
                                <select <?= $disabled_form ?> id="panellis_<?= $key ?>" class="form-control select2" name="interview[<?= $key ?>][panellist]" style="width:100%;height: 34px !important;" onchange="get_panellist(<?= $key ?>)">
                                    <option value="0">-- Select Panelist Name --</option>
                                    <?php
                                    if ($panellist) {
                                        foreach ($panellist as $pl) {
                                            $selected = '';
                                            if ($row->panellist_id == $pl->id) {
                                                $selected = 'selected="selected"';
                                            }
                                            ?>
                                            <option value="<?=$pl->id ?>" <?=$selected ?>><?=$pl->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Field of Study</label>
                                <input id="field_of_study_<?= $key ?>" type="text" class="form-control" placeholder="Field of Study" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input id="email_<?= $key ?>" type="email" class="form-control" placeholder="eg: example@aminef.com" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Telp</label>
                                <input id="tel_<?= $key ?>" type="tel" class="form-control" placeholder="Telp" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">

                            <div class="form-group">
                                <label>Home Institution</label>
                                <input id="home_institution_<?= $key ?>" class="form-control" placeholder="Home Institution" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">

                            <div class="form-group">
                                <label>Bank Info</label>
                                <input id="bank_info_<?= $key ?>" class="form-control" placeholder="Bank Info" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Beneficiary Name</label>
                                <input id="beneficiary_name_<?= $key ?>" class="form-control" placeholder="Beneficiary Name" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input id="account_number_<?= $key ?>" class="form-control" placeholder="Account Number" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Status Panelist</label>
                                <input id="status_panellist_id_<?= $key ?>" class="form-control" placeholder="Status Panelist" readonly>
                            </div>
                        </div>
                        <!-- <div class="col-lg-4">
                            <div class="form-group">
                                <label>Interview Date</label>
                                <input id="date_<?= $key ?>" class="form-control datepicker" readonly style="background-color:#fff" name="interview[<?= $key ?>][date]" value="<?= $row->date ? date('d M Y', strtotime($row->date)) : '' ?>" placeholder="Date">
                                <?php if(has_permission('selection', 'interview')) { ?>
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Interview Time</label>
                                <input type="time" id="time_<?= $key ?>" class="form-control" name="interview[<?= $key ?>][time]" value="<?= $row->date ? date('H:i', strtotime($row->date)) : '' ?>" placeholder="Time">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Venue</label>
                                <input <?= $disabled_form ?> id="venue_<?= $key ?>" class="form-control" name="interview[<?= $key ?>][location]" value="<?= $row->location ?>" placeholder="Venue">
                            </div>
                        </div> -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Interview Score</label>
                                <input type="number" step="any" data-index="<?= $key ?>" id="score_<?= $key ?>" onkeyup="hideButtonProrate(this)" class="form-control element_score" name="interview[<?= $key ?>][score]" value="<?= $row->panelist_submited == 1 ? $row->score : '' ?>" placeholder="Score">
                                <?php 
                                    $scores = true; // get_all_db('am_grantee_interview_scores', ['grantee_interview_id' => $row->id]);
                                    if ($scores) {
                                ?>
                                    <a class="btn btn-primary btn-sm mt-2 detail-interview-score" data-interview_id="<?php echo $row->id; ?>" data-period_id="<?php echo $grantee_grant->period_id; ?>" data-toggle="modal" data-target="#modal-score">View detail score</a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Scoring sheet</label>
                                <input <?= $disabled_form ?> type="file" name="scoring_sheet_<?= $key ?>" id="scoring_sheet_0" class="form-control">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <?php if ($row->scoring_sheet != '') { ?>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?=base_url() ?><?=$row->scoring_sheet ?>" class="lightbox" target="_blank"><label class="btn btn-primary btn-sm" style="cursor:pointer">View</label></a>
                                        <a href="<?=base_url('admin/set_interview/delete_scoreing/'.$row->id.'/'.$grantee_grant->id) ?>"><label class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" style="cursor:pointer"><i class="fa fa-trash fa-fw"></i></label></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Participation Mode</label>
                                <select name="interview[<?= $key ?>][participation_mode]" id="participation_mode" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option <?= $row->participation_mode == "online" ? "selected" : "" ?> value="online">Online</option>
                                    <option <?= $row->participation_mode == "offline" ? "selected" : "" ?> value="offline">Offline</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-lg-4">
                            <div class="form-group">
                                <label style="margin-right:20px">Interview Format</label><br />
                                <div class="radio d-inline mr-4">
                                    <label>
                                        <input type="radio" 
                                        <?= $row->interview_format == 'online' ? 'checked' : '' ?>
                                        class="grant-alumni" 
                                        <?= $disabled_form ?>
                                        name="interview[<?= $key ?>][interview_format]" 
                                        style="margin-top:1px" 
                                        value="online">
                                        Online
                                    </label>
                                </div>
                                <div class="radio d-inline">
                                    <label>
                                        <input type="radio" 
                                        <?= $row->interview_format == 'offline' ? 'checked' : '' ?>
                                        class="grant-alumni" 
                                        <?= $disabled_form ?>
                                        name="interview[<?= $key ?>][interview_format]" 
                                        style="margin-top:1px" 
                                        value="offline">
                                        Offline
                                    </label>
                                </div>
                            </div>  
                        </div> -->
                    </div>
                    <div class="panel-body" style="margin-top:-30px">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Rank Recommendation</label>
                                <select name="interview[<?= $key ?>][rank_recommendation]" id="rank_recommendation" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option <?= $row->rank_recommendation == "2" ? "selected" : "" ?>  value="2">Highly Recommended</option>
                                    <option <?= $row->rank_recommendation == "1" ? "selected" : "" ?> value="1">Recommended</option>
                                    <option <?= $row->rank_recommendation == "0" ? "selected" : "" ?> value="0">Not Recommended</option>
                                </select>
                                <!-- <p>
                                    <div class="radio d-inline mr-4">
                                        <label>
                                            <input type="radio" 
                                                    <?= $row->rank_recommendation == "0" ? "checked" : "" ?>
                                                    class="grant-alumni" 
                                                    <?= $disabled_form ?>
                                                    name="interview[<?= $key ?>][rank_recommendation]" 
                                                    style="margin-top:1px" 
                                                    value="0">
                                                    Not Recommended
                                        </label>
                                    </div>
                                    <div class="radio d-inline mr-4">
                                        <label>
                                            <input type="radio" 
                                                    <?= $row->rank_recommendation == "1" ? "checked" : "" ?>
                                                    class="grant-alumni" 
                                                    <?= $disabled_form ?>
                                                    name="interview[<?= $key ?>][rank_recommendation]" 
                                                    style="margin-top:1px" 
                                                    value="1">
                                                    Recommended
                                        </label>
                                    </div>
                                    <div class="radio d-inline">
                                        <label>
                                            <input type="radio" 
                                                    <?= $row->rank_recommendation == "2" ? "checked" : "" ?>
                                                    class="grant-alumni" 
                                                    <?= $disabled_form ?>
                                                    name="interview[<?= $key ?>][rank_recommendation]" 
                                                    style="margin-top:1px" 
                                                    value="2">
                                                    Highly Recommended
                                        </label>
                                    </div>
                                </p> -->
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <button type="button" data-index="<?= $key ?>" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-id="<?= $row->id ?>" onclick="prorate_interview(this)" class="<?= $is_alumni_page ? 'hide' : '' ?> btn btn-primary btn-prorate-<?= $key ?>" style="margin-top: 25px;">Prorate <img src="<?=base_url() ?>/img/loading.gif" class="<?= $is_alumni_page ? 'hide' : '' ?> add-load-prorate-<?= $key ?>" style="display:none;"></button>
                                
                            </div>
                        </div>
                    </div>

                    <!-- darisini -->
                    <?php if(has_permission('selection', 'transportation_interview')) { ?>
                    <!-- <div class="panel-body" style="margin-top:-20px">
                        <div class="col-lg-12">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Departure City</label>
                                <input id="origin_city_<?= $key ?>" type="text" class="form-control" placeholder="Departure City" name="interview[<?= $key ?>][origin_city]" value="<?= $row->origin_city ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Destination City</label>
                                <input id="destination_city_<?= $key ?>" type="text" class="form-control" placeholder="Destination City" name="interview[<?= $key ?>][destination_city]" value="<?= $row->destination_city ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Departure Date</label>
                                <input id="departure_date_<?= $key ?>" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="interview[<?= $key ?>][departure_date]" value="<?= !empty($row->departure_date) ? date('d M Y', strtotime($row->departure_date)) : '' ?>">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Returning Date</label>
                                <input id="returning_date_<?= $key ?>" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Returning Date" name="interview[<?= $key ?>][returning_date]" value="<?= !empty($row->returning_date) ? date('d M Y', strtotime($row->returning_date)) : '' ?>">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>E-Ticket</label>
                                <input id="eticket_<?= $key ?>" type="file" class="form-control" name="eticket_<?= $key ?>">
                                <?php if ($row->eticket != '') { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?=base_url() ?><?=$row->eticket ?>"  class="lightbox" target="_blank"><label class="btn btn-primary" style="cursor:pointer">View</label></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> -->
                    <?php } ?>

                    <?php if(has_permission('selection', 'accomodation_interview')) { ?>
                    <!-- <div class="panel-body" style="margin-top:-20px">
                        <div class="col-lg-12">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Check In Date</label>
                                <input id="checkin_date_<?= $key ?>" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check In Date" name="interview[<?= $key ?>][checkin_date]" value="<?= !empty($row->checkin_date) ? date('d M Y', strtotime($row->checkin_date)) : '' ?>">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Check Out Date</label>
                                <input id="checkout_date_<?= $key ?>" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check Out Date" name="interview[<?= $key ?>][checkout_date]" value="<?= !empty($row->checkout_date) ? date('d M Y', strtotime($row->checkout_date)) : '' ?>">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Hotel Voucher</label>
                                <input id="voucher_hotel_<?= $key ?>" type="file" class="form-control" name="voucher_hotel_<?= $key ?>">
                                <?php if ($row->voucher_hotel != '') { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?=base_url() ?><?=$row->voucher_hotel ?>"  class="lightbox" target="_blank"><label class="btn btn-primary" style="cursor:pointer">View</label></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> -->
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="panel-body" style="margin-top:-20px">
            <div class="col-lg-12">
                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> INTERVIEW SELECTION</p>
            </div>
        </div>
        <div id="w-interview" style="margin-top:-20px">
            <div id="interview-item-0" class="interview-item" style="position:relative">
                <div class="panel-body" style="margin-top:-20px">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Name of Panelist</label>
                            <select id="panellis_0" class="form-control select2" name="interview[0][panellist]" style="width:100%;height: 34px !important;" onchange="get_panellist(0)" <?= $disabled_form ?>>
                                <option value="0">-- Select Panelist Name --</option>
                                <?php
                                if ($panellist) {
                                    foreach ($panellist as $pl) {
                                        $selected = '';
                                        if ($submission_plans->university_id == $pl->id) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?=$pl->id ?>" <?=$selected ?>><?=$pl->name ?></option>
                                    <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Field of Study</label>
                            <input id="field_of_study_0" type="text" class="form-control" placeholder="Field of Study" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input id="email_0" type="email" class="form-control" placeholder="eg: example@aminef.com" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Telp</label>
                            <input id="tel_0" type="tel" class="form-control" placeholder="Telp" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            <label>Home Institution</label>
                            <input id="home_institution_0" class="form-control" placeholder="Home Institution" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            <label>Bank Info</label>
                            <input id="bank_info_0" class="form-control" placeholder="Bank Info" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Beneficiary Name</label>
                            <input id="beneficiary_name_0" class="form-control" placeholder="Beneficiary Name" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Account Number</label>
                            <input id="account_number_0" class="form-control" placeholder="Account Number" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status Panelist</label>
                            <input id="status_panellist_id_0" class="form-control" placeholder="Status Panelist" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Interview Score</label>
                            <input <?= $disabled_form ?> type="number" step="any" data-index="0" id="score_0" onkeyup="hideButtonProrate(this)" class="form-control element_score" name="interview[0][score]" value="" placeholder="Score">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Scoring sheet</label>
                            <input <?= $disabled_form ?> type="file" name="scoring_sheet_0" id="scoring_sheet_0" class="form-control">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Participation Mode</label>
                            <select name="interview[0][participation_mode]" id="participation_mode" class="form-control">
                                <option value="">-- Select --</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="margin-top:-30px">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Rank Recommendation</label>
                            <select name="interview[0][rank_recommendation]" id="rank_recommendation" class="form-control">
                                <option value="">-- Select --</option>
                                <option <?= $row->rank_recommendation == "2" ? "selected" : "" ?>  value="2">Highly Recommended</option>
                                <option <?= $row->rank_recommendation == "1" ? "selected" : "" ?> value="1">Recommended</option>
                                <option <?= $row->rank_recommendation == "0" ? "selected" : "" ?> value="0">Not Recommended</option>
                            </select>
                            <!-- <p>
                                <div class="radio d-inline mr-4">
                                    <label>
                                        <input type="radio" 
                                                <?= $row->rank_recommendat0n == "NR" ? "checked" : "" ?>
                                                class="grant-alumni" 
                                                <?= $disabled_form ?>
                                                name="interview[0][rank_recommendation]" 
                                                style="margin-top:1px" 
                                                value="0">
                                                Not Recommended
                                    </label>
                                </div>
                                <div class="radio d-inline mr-4">
                                    <label>
                                        <input type="radio" 
                                                <?= $row->rank_recommendation == "1" ? "checked" : "" ?>
                                                class="grant-alumni" 
                                                <?= $disabled_form ?>
                                                name="interview[0][rank_recommendation]" 
                                                style="margin-top:1px" 
                                                value="1">
                                                Recommended
                                    </label>
                                </div>
                                <div class="radio d-inline">
                                    <label>
                                        <input type="radio" 
                                                <?= $row->rank_recommendation == "2" ? "checked" : "" ?>
                                                class="grant-alumni" 
                                                <?= $disabled_form ?>
                                                name="interview[0][rank_recommendation]" 
                                                style="margin-top:1px" 
                                                value="2">
                                                Highly Recommended
                                    </label>
                                </div>
                            </p> -->
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <button type="button" data-index="0" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-id="<?= $row->id ?>" onclick="prorate_interview(this)" class="<?= $is_alumni_page ? 'hide' : '' ?> btn btn-primary btn-prorate-0" style="margin-top: 25px;">Prorate <img src="<?=base_url() ?>/img/loading.gif" class="add-load-prorate-0" style="display:none;"></button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php } ?>
</div>



<!-- <div class="modal fade" id="modal-score" tabindex="-1" role="dialog" aria-labelledby="modal-score-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="modal-score-title">
            Detail Score Interview
            <a type="button" class="btn btn-default pull-right mb-4" data-dismiss="modal" aria-label="Close" style="margin-top: -5px;">
                <span aria-hidden="true"><i class="fa fa-times"></i></span>
            </a>
            <a href="" target="_blank" class="btn btn-success btn-download-score pull-right mb-4 mr-2" style="margin-top: -5px;">
                <span aria-hidden="true">Download</span>
            </a>
        </h5>
        
      </div>
      <div class="modal-body" id="detail-score">
      </div>
    </div>
  </div>
</div> -->