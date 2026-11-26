<div class="panel panel-default travelArrangement-item">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTravel<?= $travel->parent_id ?>" href="#collapseFourTravelInternational<?= $key ?>" aria-expanded="false" aria-controls="collapseFourTravelInternational<?= $key ?>" onclick="set_session('international_ticket_<?= $key ?>');">
        <div class="panel-heading text-left" role="tab" id="international_<?= $key ?>">
            <h4 class="panel-title">
                <span id="label_name_<?= $travel->id ?>"><?= $travel->name ?></span> 
                <?php if($is_admin) { ?>
                <span><i class="fa fa-pencil-square-o ml-3 btn-noaction edit_name" data-name="<?= $travel->name ?>" data-id ="<?= $travel->id ?>" title="Edit Name"></i></span>
                <?php } ?>
                <div class="btn-group pull-right">
                    <?php if($is_admin) { ?>
                    <button type="button" data-travel_id="<?= $travel->id ?>" class="btn btn-xs btn-danger btn-noaction pull-right removeApplicant"><i class="fa fa-trash fa-fw text-white"></i></button>
                    <?php } ?>
                    <input type="hidden" name="travel_arrangement[<?= $key ?>][name_travel]" value="<?= $travel->name ?>" id="name_travel_<?= $key ?>">
                    <input type="hidden" name="travel_arrangement[<?= $key ?>][category_travel]" value="<?= $travel->category ?>" id="category_travel_<?= $key ?>">
                    <input type="hidden" name="travel_arrangement[<?= $key ?>][travel_id]" value="<?= $travel->id ?>">
                </div>
            </h4>
        </div>
    </a>
    <div id="collapseFourTravelInternational<?= $key ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'international_ticket_'.$key ? 'in' : '' ?>" role="tabpanel" aria-labelledby="international_<?= $key ?>">
        <div class="panel-body">
            <div class="col-lg-12">
                <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                    <input id="show_international_ticket<?= $key ?>" onchange="change_show_international(this, <?= $key ?>)" class="select_show hidden" value="<?= $travel->show_international_ticket ?>">
                <?php } ?>
                <?php if($has_permission || !$is_admin) { ?>
                <div class="panel-body">
                    <?php if($is_admin) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Show International Ticket</label>
                            <select class="form-control select_show show_international_ticket" name="travel_arrangement[<?= $key ?>][show_international_ticket]" id="show_international_ticket<?= $key ?>" onchange="change_show_international(this, <?= $key ?>)">
                                <option value="">- Select -</option>
                                <option <?= $travel->show_international_ticket == 'No' ? 'selected' : '' ?> value="No">No</option>
                                <option <?= $travel->show_international_ticket == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                <option <?= $travel->show_international_ticket == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
    
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="form-group section-international-<?= $key ?>">
                    <?php if($is_admin) { ?>
                    <div class="row">
                        <div class="col-lg-12 my-5">
                            <div class="TriSea-technologies-Switch">
                                <span class="mr-2"> Enable International Ticket Grantee</span>
                                <input data-id="<?= $travel->id ?>" onchange="enable_toogle(this, 'enable_international_ticket')" id="enable_international_ticket_<?= $key ?>" name="travel_arrangement[<?= $key ?>][enable_international_ticket]" type="checkbox" <?= $travel->enable_international_ticket  ? 'checked' : '' ?>/>
                                <label for="enable_international_ticket_<?= $key ?>" class="label-primary"></label>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <a href="<?= base_url($grantee_grant->procedure_international) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->procedure_international ? '' : 'hide' ?>" style="color:#fff">
                        <i class="fa fa-download fa-fw text-white"></i> Procedure of International Ticket Purchase
                    </a>
                    <ul>
                        <div class="form-group mt-3">
                            <?php if($collage_placement->test_type) {  ?>
                            <?php 
                                if ($travel->is_updated_pre_academic) {
                                    $start_date_pre = $travel->start_date_pre_academic;
                                    $end_date_pre = $travel->end_date_pre_academic;
                                    $arrival_date_pre = $travel->arrival_date_pre_academic;
                                } else {
                                    $start_date_pre = $travel->start_date_pre_academic != '' ? $travel->start_date_pre_academic : $collage_placement->start_date_pre_academic; 
                                    $end_date_pre = $travel->end_date_pre_academic != '' ? $travel->end_date_pre_academic : $collage_placement->end_date_pre_academic; 
                                    if (!empty($start_date_pre)) {
                                        $arrival_date_pre = $grantee_grant->is_degree ? date('Y-m-d', strtotime($start_date_pre . ' -1 day')) : date('Y-m-d', strtotime($start_date_pre));
                                    } else {
                                        $arrival_date_pre = '';
                                    }
                                }

                                $disabled_date_pre_academic = $is_admin ? false : (!$is_admin && !$travel->enable_arrival_date_pre_academic);
                                $show_date_pre_academic = $is_admin ? true : !$is_admin && $travel->enable_arrival_date_pre_academic;
                            ?>
                            <label>Pre-Academic Program/ Long-Term English/ Gateway Orientation</label>
                            <?php if($is_admin) { ?>
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="TriSea-technologies-Switch">
                                            <span class="mr-2"> Enable Arrival Date</span>
                                            <input data-id="<?= $travel->id ?>" onchange="enable_toogle(this, 'enable_arrival_date_pre_academic')" id="enable_arrival_date_pre_academic_<?= $key ?>" name="travel_arrangement[<?= $key ?>][enable_arrival_date_pre_academic]" type="checkbox" <?= $travel->enable_arrival_date_pre_academic  ? 'checked' : '' ?>/>
                                            <label for="enable_arrival_date_pre_academic_<?= $key ?>" class="label-primary"></label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>University</label>
                                        <input type="hidden" id="id_univ_grantee_<?= $key ?>" value="<?= $collage_placement->university_id_pre_academic ?>">
                                        <input type="text" class="form-control" value="<?= $collage_placement->university_id_pre_academic ? get_university_by_id($collage_placement->university_id_pre_academic)->name : '' ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= (!$is_admin &&  $travel->save_grantee) || (!$is_admin && !$travel->enable_international_ticket) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="Start Date" name="travel_arrangement[<?= $key ?>][start_date_pre_academic]" value="<?= $start_date_pre ? date('d M Y', strtotime($start_date_pre)) : '' ?>">
                                        <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>  
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= (!$is_admin &&  $travel->save_grantee) || (!$is_admin && !$travel->enable_international_ticket) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="End Date" name="travel_arrangement[<?= $key ?>][end_date_pre_academic]" value="<?= $end_date_pre ? date('d M Y', strtotime($end_date_pre)) : '' ?>">
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
                                        " name="travel_arrangement[<?= $key ?>][arrival_date_pre_academic]" value="<?= $arrival_date_pre ? date('d M Y', strtotime($arrival_date_pre)) : '' ?>">
                                        <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || ($show_date_pre_academic)) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Departure City</label>
                                        <input id="departure_city_pre_academic" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" placeholder="Departure City" name="travel_arrangement[<?= $key ?>][departure_city_pre_academic]" value="<?= $travel ? $travel->departure_city_pre_academic : 'Jakarta' ?>" <?= $this->session->userdata('role') != 'travel-booking-assistant' ? '' : 'disabled';?>>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Arrival City</label>
                                        <input id="arrival_city_pre_academic" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" placeholder="Destination City" name="travel_arrangement[<?= $key ?>][arrival_city_pre_academic]" value="<?= $travel ? $travel->arrival_city_pre_academic : '' ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Arrival Airport</label>
                                        <input id="arrival_airport_pre_academic" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" placeholder="Destination City" name="travel_arrangement[<?= $key ?>][arrival_airport_pre_academic]" value="<?= $travel ? $travel->arrival_airport_pre_academic : '' ?>">
                                    </div>
                                </div>
                                <?php if (($travel && $travel->eticket_pre_academic != '') || $is_admin || (!$is_admin && $travel->show_international_ticket == 'Reimbursement')) { ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>E-Ticket</label>
                                        <?php if($is_admin || (!$is_admin && $travel->enable_international_ticket)) { ?>
                                        <input id="eticket_pre_academic" type="file" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" name="eticket_pre_academic_<?= $key ?>">
                                        <?php } ?>
                                        <?php if ($travel && $travel->eticket_pre_academic != '') { ?>
                                            <br>
                                            <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket_pre_academic_<?= $travel->id ?>">
                                                <a href="<?=base_url() ?><?=$travel->eticket_pre_academic ?>" class="lightbox" aria-haspopup="dialog">
                                                    <img id="preview_image_profile" data-old="<?php echo site_url($travel->eticket_pre_academic); ?>" src="<?php echo get_preview($travel->eticket_pre_academic); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                </a>
                                                <a href="<?=base_url() ?><?=$travel->eticket_pre_academic ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($travel->eticket_pre_academic) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                                <?php if($is_admin || (!$is_admin && $travel->enable_international_ticket)) { ?>
                                                <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                    <label class="btn btn-xs btn-danger" data-id="<?= $travel->id ?>" onclick="delete_file_visa(this, 'eticket_pre_academic', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
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
                            <?php } ?>


                            <label class="mt-3">Academic Program</label>
                            <?php if($is_admin) { ?>
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="TriSea-technologies-Switch">
                                            <span class="mr-2"> Enable Arrival/Departure Date</span>
                                            <input data-id="<?= $travel->id ?>" onchange="enable_toogle(this, 'enable_arrival_date_academic_program')" id="enable_arrival_date_academic_program_<?= $key ?>" name="travel_arrangement[<?= $key ?>][enable_arrival_date_academic_program]" type="checkbox" <?= $travel->enable_arrival_date_academic_program  ? 'checked' : '' ?>/>
                                            <label for="enable_arrival_date_academic_program_<?= $key ?>" class="label-primary"></label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>University</label>
                                        <?php 
                                        $univ_id = $collage_placement->university_id; 
                                        $is_first = true;
                                        if ($travel->is_updated_academic_program) {
                                            $start_date = $travel->start_date_academic_program; 
                                            $end_date = $travel->end_date_academic_program; 
                                            $arr_date = $travel->arrival_date_academic_program; 
                                            $dep_date = $travel->departure_date_academic_program; 
                                        } else {
                                            $start_date = $travel->start_date_academic_program != '' ? $travel->start_date_academic_program : $collage_placement->start_date; 
                                            $end_date = $travel->end_date_academic_program != '' ? $travel->end_date_academic_program : $collage_placement->end_date; 
                                            if($collage_placement->test_type){
                                                $dep_date = $arr_date = $end_date_pre;
                                            }else{
                                                if (!empty($start_date)) {
                                                    $dep_date = $arr_date = $grantee_grant->is_degree ? date('Y-m-d', strtotime($start_date . ' -1 day')) : date('Y-m-d', strtotime($start_date));
                                                } else {
                                                    $dep_date = $arr_date = '';
                                                }
                                            }
                                        }

                                        $disabled_date = $is_admin ? false : (!$is_admin && !$travel->enable_arrival_date_academic_program);
                                        $show_date = $is_admin ? true : !$is_admin && $travel->enable_arrival_date_academic_program;

                                        ?>
                                        <input type="hidden" id="id_univ_grantee" value="<?= $univ_id ?>">
                                        <input type="text" class="form-control" value="<?= $univ_id ? get_university_by_id($univ_id)->name : '' ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= !$is_admin || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="Start Date" name="travel_arrangement[<?= $key ?>][start_date_academic_program]" value="<?= $start_date ? date('d M Y', strtotime($start_date)) : '' ?>">
                                        <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>  
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= !$is_admin || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="End Date" name="travel_arrangement[<?= $key ?>][end_date_academic_program]" value="<?= $end_date ? date('d M Y', strtotime($end_date)) : '' ?>">
                                        <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>  
                                </div>

                            </div>
                            <div class="panel-body">
                                <?php if($collage_placement->test_type) {  ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Departure Date </label>
                                        <input id="departure_date_academic_program" type="text" class="form-control datepicker <?= $disabled_date ? '' : 'form-control-grantee' ?>" readonly style="background-color:<?= ($disabled_date) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" placeholder="Departure Date" name="travel_arrangement[<?= $key ?>][departure_date_academic_program]" value="<?= $dep_date ? date('d M Y', strtotime($dep_date)) : '' ?>">
                                        <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || $show_date) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php }else{ ?>
                                <div class="col-lg-4"> <!-- jika tidak ada pre-academic -->
                                    <div class="form-group">
                                        <label>Arrival Date</label>
                                        <input id="arrival_date_academic_program" type="text" class="form-control datepicker <?= $disabled_date ? '' : 'form-control-grantee' ?>" readonly style="background-color:<?= ($disabled_date) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" placeholder="Arrival Date" name="travel_arrangement[<?= $key ?>][arrival_date_academic_program]" value="<?= $arr_date ? date('d M Y', strtotime($arr_date)) : '' ?>">
                                        <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || $show_date) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Departure City</label>
                                        <input id="departure_city_academic_program" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" placeholder="Departure City" name="travel_arrangement[<?= $key ?>][departure_city_academic_program]" value="<?= $travel && $travel->departure_city_academic_program != '' ? $travel->departure_city_academic_program : 'Jakarta' ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Arrival City</label>
                                        <input id="arrival_city_academic_program" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" placeholder="Arrival City" name="travel_arrangement[<?= $key ?>][arrival_city_academic_program]" value="<?= $travel ? $travel->arrival_city_academic_program : '' ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Arrival Airport</label>
                                        <input id="arrival_airport_academic_program" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" placeholder="Arrival Airport" name="travel_arrangement[<?= $key ?>][arrival_airport_academic_program]" value="<?= $travel ? $travel->arrival_airport_academic_program : '' ?>">
                                    </div>
                                </div>
                                <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Travel Agent</label>
                                        <select name="travel_arrangement[<?= $key ?>][travel_agent_academic_program]" class="form-control selectpicker" data-live-search="true">
                                            <option value="">-- Select --</option>
                                            <?php foreach($travel_agents as $travel_agent) { 
                                                $selected = '';
                                                if ($travel->travel_agent_academic_program == $travel_agent->id) {
                                                    $selected = 'selected="selected"';
                                                }?>
                                                <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if (($travel && $travel->eticket_academic_program != '') || $is_admin || (!$is_admin && $travel->show_international_ticket == 'Reimbursement')) { ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>E-Ticket</label>
                                        <?php if($is_admin || (!$is_admin && $travel->enable_international_ticket)) { ?>
                                        <input id="eticket" type="file" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" name="eticket_<?= $key ?>">
                                        <?php } ?>
                                        <?php if ($travel && $travel->eticket_academic_program != '') { ?>
                                            <br>
                                            <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket_<?= $travel->id ?>">
                                                <a href="<?=base_url() ?><?=$travel->eticket_academic_program ?>" class="lightbox" aria-haspopup="dialog">
                                                    <img id="preview_image_profile" data-old="<?php echo site_url($travel->eticket_academic_program); ?>" src="<?php echo get_preview($travel->eticket_academic_program); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                </a>
                                                <a href="<?=base_url() ?><?=$travel->eticket_academic_program ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($travel->eticket_academic_program) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                                <?php if($is_admin || (!$is_admin && $travel->enable_international_ticket)) { ?>
                                                <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                    <label class="btn btn-xs btn-danger" data-id="<?= $travel->id ?>" onclick="delete_file_visa(this, 'eticket', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                </a>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if (($travel && $travel->receipt_academic_program != '') || $is_admin || (!$is_admin && $travel->show_international_ticket == 'Reimbursement')) { ?>
                                <div class="col-lg-4 section-receipt-academic-program_<?= $key ?>">
                                    <div class="form-group">
                                        <label>Receipt</label>
                                        <?php if($is_admin || (!$is_admin && $travel->show_international_ticket == 'Reimbursement' && $travel->enable_international_ticket)) { ?>
                                        <input id="receipt" type="file" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $travel->enable_international_ticket) ? 'form-control-grantee' : '' ?>" name="receipt_<?= $key ?>">
                                        <?php } ?>
                                        <?php if ($travel && $travel->receipt_academic_program != '') { ?>
                                            <br>
                                            <div style="margin-bottom:10px; position:relative; width:100px;" id="file_receipt_<?= $travel->id ?>">
                                                <a href="<?=base_url() ?><?=$travel->receipt_academic_program ?>" class="lightbox" aria-haspopup="dialog">
                                                    <img id="preview_image_profile" data-old="<?php echo site_url($travel->receipt_academic_program); ?>" src="<?php echo get_preview($travel->receipt_academic_program); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                </a>
                                                <a href="<?=base_url() ?><?=$travel->receipt_academic_program ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($travel->receipt_academic_program) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                    <i class="fa fa-download fa-fw"></i>
                                                </a>
                                                <?php if($is_admin || (!$is_admin && $travel->enable_international_ticket)) { ?>
                                                <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                    <label class="btn btn-xs btn-danger" data-id="<?= $travel->id ?>" onclick="delete_file_visa(this, 'receipt', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
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
                                            <label>Status Transportation</label>
                                            <select name="travel_arrangement[<?= $key ?>][status_transportation]" class="form-control">
                                                <option <?= $travel->status_transportation == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                                                <option <?= $travel->status_transportation == 'done' ? 'selected' : '' ?> value="done">Done</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($is_admin) { ?>
                            <div class="panel-body show-visa-passport"></div>
                            <?php } ?>
                        </div>
                    </ul>
                    <hr />
                </div>
                <?php } ?>
            </div>
            <?php if($travel->enable_transportation || $travel->enable_accommodation || $is_admin) { ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                        <button type="button" name="btn_and_send" value="<?= $key ?>" onclick="return showSwal('confirm_submit', 'Are you sure you want to save and send?', false, false, false, '#form', '<?= $key ?>', 1)" class="btn btn-primary">Save and Send</button>
                        <?php } ?>
                        <button type="button" name="btn" value="<?= $key ?>" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', '<?= $key ?>')" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>