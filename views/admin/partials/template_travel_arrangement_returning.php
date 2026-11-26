<script type="text/template" id="applicant-template-returning">
<div class="panel panel-default travelArrangement-item">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTravel0" href="#collapseToeflTransport{index}" aria-expanded="false" aria-controls="collapseToeflTransport{index}" onclick="return set_session('interview_apointment{index}')">
        <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTransport">
            <h4 class="panel-title">
                <span id="label_name_{travel_id}">{label_name}</span> 
                <?php if($is_admin) { ?>
                <span><i class="fa fa-pencil-square-o ml-3 btn-noaction edit_name" data-name="{label_name}" data-id ="{travel_id}" title="Edit Name"></i></span>
                <?php } ?>
                <div class="btn-group pull-right">
                    <?php if($is_admin) { ?>
                    <button type="button" data-travel_id="{travel_id}" class="btn btn-xs btn-danger btn-noaction pull-right removeApplicant"><i class="fa fa-trash fa-fw text-white"></i></button>
                    <?php } ?>
                    <input type="hidden" name="travel_arrangement[{index}][name_travel]" value="{label_name}" id="name_travel_{index}">
                    <input type="hidden" name="travel_arrangement[{index}][category_travel]" value="{category_travel}" id="category_travel_{index}">
                    <input type="hidden" name="travel_arrangement[{index}][travel_id]" value="{travel_id}">
                </div>
            </h4>
        </div>
    </a>
    <div id="collapseToeflTransport{index}" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment{index}' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTransport">
        <div class="panel-body">
            <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                <input id="show_transportation_{index}" onchange="show_hide_transportation(this, 'domestic', {index})" class="select_show hidden">
                <input id="show_accomodation_{index}" onchange="show_hide_accomodation(this, 'domestic', {index})" class="select_show hidden">
            <?php } ?>
            <?php if(has_permission('travel_arrangement', 'add')) { ?>
            <div class="panel-body">
                <label>Show Transportation International</label>
                <select class="form-control select-transport-returning-{index} select_show" name="travel_arrangement[{index}][show_transportation]" id="show_transportation_{index}" onchange="show_hide_transportation(this, 'domestic', {index})">
                    <option value="">- Select -</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="Reimbursement">Reimbursement</option>
                    <option value="Third Party">Third Party</option>

                </select>
                <label>Show Transportation Domestic</label>
                <select class="form-control select-transport-returning-{index} select_show" name="travel_arrangement[{index}][show_transportation_domestic]" id="show_transportation_domestic_{index}" data-isreturning="1" onchange="show_hide_transportation(this, 'domestic', '{index}')">
                    <option value="">- Select -</option>
                    <option <?= $travel->show_transportation_domestic == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                    <option <?= $travel->show_transportation_domestic == 'No' ? 'selected' : '' ?> value="No">No</option>
                    <option <?= $travel->show_transportation_domestic == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                </select>
                <label class="mt-3">Show Accommodation</label>
                <select class="form-control select_show" name="travel_arrangement[{index}][show_accomodation]" id="show_accomodation_{index}" onchange="show_hide_accomodation(this, 'domestic', {index})">
                    <option value="">- Select -</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="Reimbursement">Reimbursement</option>

                </select>
            </div>
            <?php } ?>
            <div class="panel-body header-transport-{index}">
                <div class="col-lg-12">
                    <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                                <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                            </a>
                            <p class="mt-5">You may request assistance for your return travel to Indonesia following the completion of your program.</p>
            
                            <ul>
                                <li>If you hold a round-trip international ticket, please contact your airline to confirm or update your return flight. You may request a domestic flight to your hometown (as stated in your initial application) and one night of transit accommodation in Jakarta, if needed.</li>
                                
                                <li>If you do not have a round-trip ticket, you may request a one-way international ticket from the U.S. to Indonesia. This request can include a domestic flight to your hometown (as stated in your initial application) and one night of transit accommodation in Jakarta, if needed.</li>
                            </ul>
            
                            <p>Please ensure all requests are submitted in a timely manner and contact your AMINEF PIC for further guidance and assistance.</p>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php if(has_permission('travel_arrangement', 'add') || $is_grantee) { ?>
            <div class="panel-body section-transportation-international-{index}">
                <?php if($is_admin) { ?>
                <div class="row mt-5 section-transportation-international-{index}">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Transportation Grantee</span>
                            <input data-id="{travel_id}" onchange="enable_toogle(this, 'enable_transportation')" id="enable_transportation_{index}" name="travel_arrangement[{index}][enable_transportation]" type="checkbox" checked/>
                            <label for="enable_transportation_{index}" class="label-primary"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if($grantee_grant->is_degree) { ?>
                <div class="col-lg-12">
                    <label>International</label>
                    <hr class="no-margin"/>
                </div>
                <div class="panel-body section-default">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>University</label>
                            <input type="text" class="form-control" value="<?= $collage_placement->university_id ? get_university_by_id($collage_placement->university_id)->name : '' ?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Arrival Date</label>
                            <input id="arrival_date" type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Arrival Date" name="travel_arrangement[{index}][arrival_date]">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure City</label>
                            <input id="departure_city" type="text" class="form-control placeholder="Departure City" name="travel_arrangement[{index}][departure_city]">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Arrival City</label>
                            <input id="arrival_city" type="text" class="form-control" placeholder="Arrival City" name="travel_arrangement[{index}][arrival_city]" value="Jakarta">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure Airport</label>
                            <input id="arrival_airport" type="text" class="form-control placeholder="Departure Airport" name="travel_arrangement[{index}][arrival_airport]">
                        </div>
                    </div>
                    <?php if($transport_status['show_transportation'] || $is_admin || $travel->eticket != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_eticket_domestic_{index}">E-Ticket</label>
                            <input type="file" class="form-control" name="eticket_{index}">
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            <div class="panel-body section-transportation-domestic-{index}">
                <!-- domestic section -->
                <?php if($is_admin) { ?>
                <div class="row mb-5 section-transportation-domestic-{index}">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Transportation Domestic Grantee</span>
                            <input data-id="{travel_id}" onchange="enable_toogle(this, 'enable_transportation_domestic')" id="enable_transportation_domestic_{index}" name="travel_arrangement[{index}][enable_transportation_domestic]" type="checkbox"/>
                            <label for="enable_transportation_domestic_{index}" class="label-primary"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-lg-12">
                    <label>Domestic Ticket</label>
                    <hr class="no-margin"/>
                </div>
                <div class="panel-body">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure City</label>
                            <input type="text" class="form-control" placeholder="Departure City" name="travel_arrangement[{index}][returning_origin_city]" value="Jakarta">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Arrival City</label>
                            <input type="text" class="form-control" placeholder="Arrival City" name="travel_arrangement[{index}][returning_destination_city]">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure Date</label>
                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="travel_arrangement[{index}][returning_date_section]">
                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <?php if($transport_status['show_transportation'] || $is_admin || $travel->eticket_returning != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_eticket_domestic_{index}">E-Ticket</label>
                            <input type="file" class="form-control " name="eticket_returning_{index}">
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <?php if(has_permission('travel_arrangement', 'add') || $is_grantee) { ?>
            <div class="panel-body section-accomodation-domestic-{index}">
                <?php if($is_admin) { ?>
                <div class="row mt-5 section-accomodation-domestic-{index}">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Accommodation Grantee</span>
                            <input data-id="{travel_id}" onchange="enable_toogle(this, 'enable_accommodation')" id="enable_accommodation_{index}" name="travel_arrangement[{index}][enable_accommodation]" type="checkbox" checked/>
                            <label for="enable_accommodation_{index}" class="label-primary"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php 
                    $accommodation_status = evaluate_transportation($travel, $is_admin, [], 'show_accomodation', 'enable_accommodation');
                ?>
                <div class="col-lg-12">
                    <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
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
                <?php if($accommodation_status['show_transportation'] || $is_admin || $travel->voucher_hotel != '') { ?>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label id="label_voucher_hotel_domestic_{index}">Hotel Voucher</label>
                        <input type="file" class="form-control" name="voucher_hotel_{index}">
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>

        <?php if($travel->enable_transportation || $travel->enable_accommodation || $is_admin) { ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="pull-right">
                    <button type="button" name="btn" value="{index}" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', '{index}')" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</script>