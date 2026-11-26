<script type="text/template" id="applicant-template-us-departure">
    <div class="panel panel-default travelArrangement-item">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTravel0" href="#collapseFourTravelInternational{index}" aria-expanded="false" aria-controls="collapseFourTravelInternational{index}">
            <div class="panel-heading text-left" role="tab" id="international_{index}">
                <h4 class="panel-title">
                    <span id="label_name_{travel_id}">{label_name}</span> <span><i class="fa fa-pencil-square-o ml-3 btn-noaction edit_name" data-name="{label_name}" data-id ="{travel_id}" title="Edit Name"></i></span>
                    <div class="btn-group pull-right">
                        <button type="button" data-travel_id="{travel_id}" class="btn btn-xs btn-danger btn-noaction pull-right removeApplicant"><i class="fa fa-trash fa-fw text-white"></i></button>
                        <input type="hidden" name="travel_arrangement[{index}][name_travel]" value="{label_name}" id="name_travel_{index}">
                        <input type="hidden" name="travel_arrangement[{index}][category_travel]" value="{category_travel}" id="category_travel_{index}">
                        <input type="hidden" name="travel_arrangement[{index}][travel_id]" value="{travel_id}">
                    </div>
                </h4>
            </div>
        </a>
        <div id="collapseFourTravelInternational{index}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="international_{index}">
            <div class="panel-body">
                <div class="panel-body">
                    <div class=" section-transport-domestic-{index}">
                        <label>DOMESTIC TICKET</label>
                        <hr class="no-margin"/>
                    </div>
                    <div class="">
                        <label>Show Transportation</label>
                        <select class="form-control select_show" name="travel_arrangement[{index}][show_transportation]" id="show_transportation_{index}" onchange="show_hide_transportation(this, 'domestic', {index})">
                            <option value="">- Select -</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="Reimbursement">Reimbursement</option>
                            <option value="Departure Reimbursement">Departure Reimbursement</option>
                            <option value="Return Reimbursement">Return Reimbursement</option>

                        </select>
                    </div>
                    <div class="">
                        <label class="mt-3">Show Accommodation</label>
                        <select class="form-control select_show" name="travel_arrangement[{index}][show_accomodation]" id="show_accomodation_{index}" onchange="show_hide_accomodation(this, 'domestic', {index})">
                            <option value="">- Select -</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="Reimbursement">Reimbursement</option>
    
                        </select>
                    </div>
                </div>

                <div class="panel-body section-transportation-domestic-{index}">
                    <div class="row mt-5 section-transportation-domestic-{index}">
                        <div class="col-lg-12">
                            <div class="TriSea-technologies-Switch">
                                <span class="mr-2"> Enable Transportation Grantee</span>
                                <input data-id="{travel_id}" onchange="enable_toogle(this, 'enable_transportation')" id="enable_transportation_{index}" name="travel_arrangement[{index}][enable_transportation]" type="checkbox" checked/>
                                <label for="enable_transportation_{index}" class="label-primary"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Transportation</p>
                    </div>
                    
                    <div class="panel-body">
                        <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                            <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                        </a>
                    </div>

                    <div class="col-lg-12 label-transport-domestic-{index}">
                        <label>Departure Ticket</label>
                        <hr class="no-margin"/>
                    </div>
                    <div class="panel-body section-default">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Departure City</label>
                                <input type="text" class="form-control" placeholder="Departure City" name="travel_arrangement[{index}][origin_city]">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Destination City</label>
                                <input type="text" class="form-control" placeholder="Destination City" name="travel_arrangement[{index}][destination_city]">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Departure Date</label>
                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="travel_arrangement[{index}][departure_date]">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <!-- <div class="col-lg-4" id="returning_date_{index}">
                            <div class="form-group">
                                <label>Return Date</label>
                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="travel_arrangement[{index}][returning_date]">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div> -->
                        <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                        <div class="col-lg-4" id="travel_agen_general_domestic_{index}">
                            <div class="form-group">
                                <label>Travel Agent</label>
                                <select name="travel_arrangement[{index}][travel_agent]" class="form_control select2">
                                    <option value="">-- Select --</option>
                                    <?php foreach($travel_agents as $travel_agent) { 
                                        $selected = '';
                                        if ($travel_arrangement->travel_agent_id == $travel_agent->id) {
                                            $selected = 'selected="selected"';
                                        }?>
                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label id="label_eticket_domestic_{index}">E-Ticket</label>
                                <input type="file" class="form-control" name="eticket_{index}">
                            </div>
                        </div>
                    </div>

                    <!-- returning section -->
                    <div class="col-lg-12 label-transport-domestic-{index}">
                        <label>Returning Ticket</label>
                        <hr class="no-margin"/>
                    </div>
                    <div class="panel-body returing_section_domestic_{index}">
                        <div class="col-lg-4 returing_section_domestic_{index}">
                            <div class="form-group">
                                <label>Departure City</label>
                                <input type="text" class="form-control" placeholder="Departure City" name="travel_arrangement[{index}][returning_origin_city]">
                            </div>
                        </div>
                        <div class="col-lg-4 returing_section_domestic_{index}">
                            <div class="form-group">
                                <label>Destination City</label>
                                <input type="text" class="form-control" placeholder="Destination City" name="travel_arrangement[{index}][returning_destination_city]">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Return Date</label>
                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="travel_arrangement[{index}][returning_date_section]">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                        <div class="col-lg-4" id="travel_agen_returning_domestic_{index}">
                            <div class="form-group">
                                <label>Travel Agent</label>
                                <select name="travel_arrangement[{index}][travel_agent_returning]" class="form_control select2">
                                    <option value="">-- Select --</option>
                                    <?php foreach($travel_agents as $travel_agent) { 
                                        $selected = '';
                                        if ($travel_arrangement->travel_agent_id == $travel_agent->id) {
                                            $selected = 'selected="selected"';
                                        }?>
                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label id="label_eticket_returning_domestic_{index}">Returning E-Ticket</label>
                                <input type="file" class="form-control" name="eticket_returning_{index}">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel-body section-accomodation-domestic-{index}">
                    <div class="row mt-5 section-accomodation-domestic-{index}">
                        <div class="col-lg-12">
                            <div class="TriSea-technologies-Switch">
                                <span class="mr-2"> Enable Accommodation Grantee</span>
                                <input data-id="{travel_id}" onchange="enable_toogle(this, 'enable_accommodation')" id="enable_accommodation_{index}" name="travel_arrangement[{index}][enable_accommodation]" type="checkbox" checked/>
                                <label for="enable_accommodation_{index}" class="label-primary"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Accommodation</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Check-In Date</label>
                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="travel_arrangement[{index}][checkin_date]">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Check-Out Date</label>
                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="travel_arrangement[{index}][checkout_date]">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_voucher_hotel_domestic_{index}">Hotel Voucher</label>
                            <input type="file" class="form-control" name="voucher_hotel_{index}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <?php if($has_permission || !$is_admin) { ?>
                        <?php if($is_admin) { ?>
                        <label>INTERNATIONAL TICKET</label>
                        <hr class="no-margin"/>
                        <?php } ?>
                        <div class="panel-body">
                            <?php if($is_admin) { ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- <label>Show International Ticket</label>
                                    <select class="form-control select_show" name="travel_arrangement[{index}][show_international_ticket]" id="show_international_ticket_{index}" onchange="change_show_international(this, {index})">
                                        <option value="">- Select -</option>
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                        <option value="Reimbursement">Reimbursement</option>
                                    </select> -->
                                    <!-- Perubahan jadi di pisah Pre-Academic dan Academic Program -->
                                    <label>Show Pre-Academic Program/ Long-Term English/ Gateway Orientation Ticket</label>
                                    <select class="form-control select-departure-{index} select_show" name="travel_arrangement[{index}][show_pre_academic_ticket]" id="show_pre_academic_ticket{index}" onchange="change_show_international(this, {index}, 'preacademic')">
                                        <option value="">- Select -</option>
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                        <option value="Reimbursement">Reimbursement</option>

                                    </select>
                                    <label class="mt-3">Show Academic Program Ticket</label>
                                    <select class="form-control select-departure-{index} select_show" name="travel_arrangement[{index}][show_academic_ticket]" id="show_academic_ticket{index}" onchange="change_show_international(this, {index}, 'academic')">
                                        <option value="">- Select -</option>
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                        <option value="Reimbursement">Reimbursement</option>
                                        <option value="Third Party">Third Party</option>

                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <div class=" header-international-departure-{index}">
                                <a href="<?= base_url($grantee_grant->procedure_international) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->procedure_international ? '' : 'hide' ?>" style="color:#fff">
                                    <i class="fa fa-download fa-fw text-white"></i> Procedure of International Ticket Purchase
                                </a>
                            </div>
                            <?php if($is_admin) { ?>
                            <!-- <div class="row">
                                <div class="col-lg-12 my-5">
                                    <div class="TriSea-technologies-Switch">
                                        <span class="mr-2"> Enable International Ticket Grantee</span>
                                        <input data-id="{travel_id}" onchange="enable_toogle(this, 'enable_international_ticket')" id="enable_international_ticket_{index}" name="travel_arrangement[{index}][enable_international_ticket]" type="checkbox" checked/>
                                        <label for="enable_international_ticket_{index}" class="label-primary"></label>
                                    </div>
                                </div>
                            </div> -->
                            <?php } ?>
                            <ul>
                                <div class="form-group mt-3">
                                <?php if($collage_placement->test_type) {  ?>
                                <?php 
                                    $start_date_pre = $collage_placement->start_date_pre_academic; 
                                    $end_date_pre = $collage_placement->end_date_pre_academic; 
                                    if (!empty($start_date_pre)) {
                                        $arrival_date_pre = $grantee_grant->is_degree ? date('Y-m-d', strtotime($start_date_pre . ' -1 day')) : date('Y-m-d', strtotime($start_date_pre));
                                    } else {
                                        $arrival_date_pre = '';
                                    }

                                    $disabled_date_pre_academic = $is_admin ? false : (!$is_admin && !$travel->enable_arrival_date_pre_academic);
                                    $show_date_pre_academic = $is_admin ? true : !$is_admin && $travel->enable_arrival_date_pre_academic;
                                ?>
                                <div class="section-preacademic-{index}">
                                    <label>Pre-Academic Program/ Long-Term English/ Gateway Orientation</label>
                                    <?php if($is_admin) { ?>
                                        <div class="panel-body">
                                            <div class="col-lg-12">
                                                <div class="TriSea-technologies-Switch">
                                                    <span class="mr-2"> Enable Arrival Date</span>
                                                    <input data-id="{travel_id}" onchange="enable_toogle(this, 'enable_arrival_date_pre_academic')" id="enable_arrival_date_pre_academic_{index}" name="travel_arrangement[{index}][enable_arrival_date_pre_academic]" type="checkbox" checked/>
                                                    <label for="enable_arrival_date_pre_academic_{index}" class="label-primary"></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="panel-body">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>University</label>
                                                <input type="hidden" id="id_univ_grantee_{index}" value="<?= $collage_placement->university_id_pre_academic ?>">
                                                <input type="text" class="form-control" value="<?= $collage_placement->university_id_pre_academic ? get_university_by_id($collage_placement->university_id_pre_academic)->name : '' ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= (!$is_admin &&  $travel->save_grantee) || (!$is_admin && !$travel->enable_international_ticket) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="Start Date" name="travel_arrangement[{index}][start_date_pre_academic]" value="<?= $start_date_pre ? date('d M Y', strtotime($start_date_pre)) : '' ?>">
                                                <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                <?php } ?>
                                            </div>  
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= (!$is_admin &&  $travel->save_grantee) || (!$is_admin && !$travel->enable_international_ticket) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="End Date" name="travel_arrangement[{index}][end_date_pre_academic]" value="<?= $end_date_pre ? date('d M Y', strtotime($end_date_pre)) : '' ?>">
                                                <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                <?php } ?>
                                            </div>  
                                        </div>
    
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Arrival Date</label>
                                                <input id="arrival_date_pre_academic" type="text" readonly style="background-color:<?= ($disabled_date_pre_academic) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker <?= $disabled_date_pre_academic ? '' : 'form-control-grantee' ?>" placeholder="Arrival Date
                                                " name="travel_arrangement[{index}][arrival_date_pre_academic]" value="<?= $arrival_date_pre ? date('d M Y', strtotime($arrival_date_pre)) : '' ?>">
                                                <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || ($show_date_pre_academic)) { ?>
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Departure City</label>
                                                <input id="departure_city_pre_academic" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" placeholder="Departure City" name="travel_arrangement[{index}][departure_city_pre_academic]" value="Jakarta" <?= $this->session->userdata('role') != 'travel-booking-assistant' ? '' : 'disabled';?>>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Arrival City</label>
                                                <input id="arrival_city_pre_academic" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" placeholder="Destination City" name="travel_arrangement[{index}][arrival_city_pre_academic]">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Arrival Airport</label>
                                                <input id="arrival_airport_pre_academic" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" placeholder="Destination City" name="travel_arrangement[{index}][arrival_airport_pre_academic]">
                                            </div>
                                        </div>
                                        <?php if (($travel && $travel->eticket_pre_academic != '') || $is_admin || (!$is_admin && $travel->show_international_ticket == 'Reimbursement')) { ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>E-Ticket</label>
                                                <?php if($is_admin || (!$is_admin && $travel->enable_international_ticket)) { ?>
                                                <input id="eticket_pre_academic" type="file" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" name="eticket_pre_academic_{index}">
                                                <?php } ?>
                                                <?php if ($travel && $travel->eticket_pre_academic != '') { ?>
                                                    <br>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket_pre_academic_{travel_id}">
                                                        <a href="<?=base_url() ?><?=$travel->eticket_pre_academic ?>" class="lightbox" aria-haspopup="dialog">
                                                            <img id="preview_image_profile" data-old="<?php echo site_url($travel->eticket_pre_academic); ?>" src="<?php echo get_preview($travel->eticket_pre_academic); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                        </a>
                                                        <a href="<?=base_url() ?><?=$travel->eticket_pre_academic ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($travel->eticket_pre_academic) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                            <i class="fa fa-download fa-fw"></i>
                                                        </a>
                                                        <?php if($is_admin || (!$is_admin && $travel->enable_international_ticket)) { ?>
                                                        <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                            <label class="btn btn-xs btn-danger" data-id="{travel_id}" onclick="delete_file_visa(this, 'eticket_pre_academic', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                        </a>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php if($is_admin) { ?>
                                    <div class="panel-body show-visa-passport"></div>
                                    <?php } ?>
                                    <hr />
                                </div>
                                <?php } ?>


                                <div class="section-academic-{index}">
                                    <label class="mt-3"><?= $grantee_grant->academic_program != '' ? $grantee_grant->academic_program : 'Academic Program' ?></label>
                                    <?php if($is_admin) { ?>
                                        <div class="panel-body">
                                            <div class="col-lg-12">
                                                <div class="TriSea-technologies-Switch">
                                                    <span class="mr-2"> Enable Arrival/Departure Date</span>
                                                    <input data-id="{travel_id}" onchange="enable_toogle(this, 'enable_arrival_date_academic_program')" id="enable_arrival_date_academic_program_{index}" name="travel_arrangement[{index}][enable_arrival_date_academic_program]" type="checkbox" checked/>
                                                    <label for="enable_arrival_date_academic_program_{index}" class="label-primary"></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php 
                                    
                                        if($collage_placement->test_type){
                                            $dep_date = $arr_date = $end_date_pre;
                                        }
                                    ?>
                                    <div class="panel-body">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>University</label>
                                                <input type="hidden" id="id_univ_grantee_{index}" value="{university_id}">
                                                <input type="text" class="form-control" value="{university_name}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="text" readonly style="background-color:#fff" class="form-control datepicker" placeholder="Start Date" name="travel_arrangement[{index}][start_date_academic_program]" value="{start_date}">
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            </div>  
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="text" readonly style="background-color:#fff" class="form-control datepicker" placeholder="End Date" name="travel_arrangement[{index}][end_date_academic_program]" value="{end_date}">
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            </div>  
                                        </div>

                                    </div>
                                    <div class="panel-body">
                                </div>
                                        <?php if($collage_placement->test_type) {  ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Departure Date </label>
                                                <input id="departure_date_{index}" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="travel_arrangement[{index}][departure_date_academic_program]" value="<?= $dep_date ? date('d M Y', strtotime($dep_date)) : '' ?>">
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            </div>
                                        </div>
                                        <?php }else{ ?>
                                        <div class="col-lg-4"> <!-- jika tidak ada pre-academic -->
                                            <div class="form-group">
                                                <label>Arrival Date</label>
                                                <input id="arrival_date_{index}" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Arrival Date" name="travel_arrangement[{index}][arrival_date_academic_program]" value="<?= $dep_date ? date('d M Y', strtotime($dep_date)) : '' ?>">
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Departure City</label>
                                                <input id="departure_city_academic_program_{index}" type="text" class="form-control" placeholder="Departure City" name="travel_arrangement[{index}][departure_city_academic_program]" value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Arrival City</label>
                                                <input id="arrival_city_academic_program_{index}" type="text" class="form-control" placeholder="Arrival City" name="travel_arrangement[{index}][arrival_city_academic_program]">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Arrival Airport</label>
                                                <input id="arrival_airport_academic_program_{index}" type="text" class="form-control" placeholder="Arrival Airport" name="travel_arrangement[{index}][arrival_airport_academic_program]">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>E-Ticket</label>
                                                <input id="eticket_academic_program_{index}" type="file" class="form-control" name="eticket_academic_program_{index}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 section-receipt-academic-program">
                                            <div class="form-group">
                                                <label>Receipt</label>
                                                <input id="receipt_academic_program_{index}" type="file" class="form-control" name="receipt_academic_program_{index}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <hr />
                    <?php } ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <button type="button" name="btn" value="{index}" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', '{index}')" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>