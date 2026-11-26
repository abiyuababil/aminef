<script type="text/template" id="applicant-template-domestic">
    <div class="panel panel-default travelArrangement-item">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTravel0" href="#collapseTravelArrangemet{index}" aria-expanded="false" aria-controls="collapseTravelArrangemet{index}" onclick="return set_session('interview_apointment')">
            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="travelArrangemet{index}">
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
        <div id="collapseTravelArrangemet{index}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="travelArrangemet{index}">
            <div class="panel-body">
                <div class="panel-body">
                    <label>Show Transportation</label>
                    <select class="form-control select_show" name="travel_arrangement[{index}][show_transportation]" id="show_transportation_{index}" onchange="show_hide_transportation(this, 'domestic', {index})">
                        <option value="">- Select -</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Reimbursement">Reimbursement</option>
                        <option value="Departure Reimbursement">Departure Reimbursement</option>
                        <option value="Return Reimbursement">Return Reimbursement</option>

                    </select>
                    <label class="mt-3">Show Accommodation</label>
                    <select class="form-control select_show" name="travel_arrangement[{index}][show_accomodation]" id="show_accomodation_{index}" onchange="show_hide_accomodation(this, 'domestic', {index})">
                        <option value="">- Select -</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Reimbursement">Reimbursement</option>

                    </select>
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
                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
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
                        <div class="col-lg-4" id="returning_date_{index}">
                            <div class="form-group">
                                <label>Return Date</label>
                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="travel_arrangement[{index}][returning_date]">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
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
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_voucher_hotel_domestic_{index}">Hotel Voucher</label>
                            <input type="file" class="form-control" name="voucher_hotel_{index}">
                        </div>
                    </div>
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