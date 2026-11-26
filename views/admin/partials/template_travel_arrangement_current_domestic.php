<div class="panel panel-default travelArrangement-item">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTravel<?= $travel->parent_id ?>" href="#collapseToeflTransport<?= $travel->id ?><?= $key ?>" aria-expanded="false" aria-controls="collapseToeflTransport<?= $travel->id ?><?= $key ?>" onclick="return set_session('interview_apointment<?= $travel->id ?><?= $key ?>')">
        <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTransport">
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
    <div id="collapseToeflTransport<?= $travel->id ?><?= $key ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' . $travel->id . $key ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTransport">
        <div class="panel-body">
            <?php
            $key_index = substr($key, -1);

            /**
             * mapping jenis test ke data source
             */
            $data = $pre_departure_period = $pre_depature = null;
            $type = 'panel_test_section';
            if (stripos($travel->name, 'GRE Subject') !== false) {
                $data = $data_gre_subject[$key_index] ?? null;
            } elseif (stripos($travel->name, 'GRE') !== false) {
                $data = $data_gre[$key_index] ?? null;
            } elseif (stripos($travel->name, 'TOEFL') !== false) {
                $data = $data_toefl[$key_index] ?? null;
            } elseif (stripos($travel->name, 'GMAT') !== false) {
                $data = $data_gmat[$key_index] ?? null;
            } elseif (stripos($travel->name, 'Visa Interview') !== false) {
                $type = 'panel_visa_interview';
                $data = $data_visa_interview ?? null;
            } elseif (stripos($travel->name, 'Interview Selection') !== false) {
                $type = 'panel_interview_selection';
                $data = $grantee_grant ?? null;
            } elseif (stripos($travel->name, 'Pre Departure Orientation') !== false) {
                $type = 'panel_pdo';
                $pre_depature = $pre_depature ?? null;
                $pre_depature_period = $pre_depature_period ?? null;
                $data = $pre_depature_global ?? null;
            }

            if ($data && $this->session->userdata('role') == 'travel-booking-assistant'):
                $this->load->view('admin/partials/' . $type, ['dt' => $data, 'pre_depature_period' => $pre_depature_period, 'data_pre_depature' => $pre_depature]);
            endif;
            ?>


            <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                <input id="show_transportation_<?= $key ?>" onchange="show_hide_transportation(this, 'domestic', '<?= $key ?>')" class="select_show hidden" value="<?= $travel->show_transportation ?>">
                <input id="show_accomodation_<?= $key ?>" onchange="show_hide_accomodation(this, 'domestic', '<?= $key ?>')" class="select_show hidden" value="<?= $travel->show_accomodation ?>">
            <?php } ?>
            <?php if(has_permission('travel_arrangement', 'add')) { ?>
            <div class="panel-body">
                <label>Show Transportation</label>
                <select class="form-control select_show" name="travel_arrangement[<?= $key ?>][show_transportation]" id="show_transportation_<?= $key ?>" onchange="show_hide_transportation(this, 'domestic', '<?= $key ?>')">
                    <option value="">- Select -</option>
                    <option <?= $travel->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                    <option <?= $travel->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                    <option <?= $travel->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                    <option <?= $travel->show_transportation == 'Departure Reimbursement' ? 'selected' : '' ?> value="Departure Reimbursement">Departure Reimbursement</option>
                    <option <?= $travel->show_transportation == 'Return Reimbursement' ? 'selected' : '' ?> value="Return Reimbursement">Return Reimbursement</option>

                </select>
                <label class="mt-3">Show Accommodation</label>
                <select class="form-control select_show" name="travel_arrangement[<?= $key ?>][show_accomodation]" id="show_accomodation_<?= $key ?>" onchange="show_hide_accomodation(this, 'domestic', '<?= $key ?>')">
                    <option value="">- Select -</option>
                    <option <?= $travel->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                    <option <?= $travel->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                    <option <?= $travel->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                </select>
            </div>
            <?php } ?>
            <?php if(has_permission('travel_arrangement', 'add') || $is_grantee) { ?>
            <div class="panel-body section-transportation-domestic-<?= $key ?>">
                <?php if($is_admin) { ?>
                <div class="row mt-5 section-transportation-domestic-<?= $key ?>">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Transportation Grantee</span>
                            <input data-id="<?= $travel->id ?>" onchange="enable_toogle(this, 'enable_transportation')" id="enable_transportation_<?= $key ?>" name="travel_arrangement[<?= $key ?>][enable_transportation]" type="checkbox" <?= $travel->enable_transportation ? 'checked' : '' ?>/>
                            <label for="enable_transportation_<?= $key ?>" class="label-primary"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>


                <?php 
                    $transport_status = evaluate_transportation($travel, $is_admin, [], 'show_transportation', 'enable_transportation');
                    // echo '<pre>';print_r($transport_status);die;
                ?>

                <div class="col-lg-12">
                    <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                </div>
                
                <div class="panel-body">
                    <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                        <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                    </a>
                </div>

                <div class="col-lg-12 label-transport-domestic-<?= $key ?>">
                    <label>Departure Ticket</label>
                    <hr class="no-margin"/>
                </div>
                <div class="panel-body section-default">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure City</label>
                            <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="travel_arrangement[<?= $key ?>][origin_city]" value="<?= $travel->origin_city ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Destination City</label>
                            <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" placeholder="Destination City" name="travel_arrangement[<?= $key ?>][destination_city]" value="<?= $travel->destination_city ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure Date</label>
                            <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="travel_arrangement[<?= $key ?>][departure_date]" value="<?= $travel->departure_date != '' ? date('d M Y', strtotime($travel->departure_date)) : '' ?>">
                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4" id="returning_date_domestic_<?= $key ?>">
                        <div class="form-group">
                            <label>Return Date</label>
                            <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="travel_arrangement[<?= $key ?>][returning_date]" value="<?= $travel->returning_date != '' ? date('d M Y', strtotime($travel->returning_date)) : '' ?>">
                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <?php if(!$is_grantee) { ?>
                        <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                        <div class="col-lg-4" id="travel_agen_general_domestic_<?= $key ?>">
                            <div class="form-group">
                                <label>Travel Agent</label>
                                <select name="travel_arrangement[<?= $key ?>][travel_agent]" class="form_control select2">
                                    <option value="">-- Select --</option>
                                    <?php foreach($travel_agents as $travel_agent) { 
                                        $selected = '';
                                        if ($travel->travel_agent_id == $travel_agent->id) {
                                            $selected = 'selected="selected"';
                                        }?>
                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if($transport_status['show_upload'] || $is_admin || $travel->eticket != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_eticket_domestic_<?= $key ?>">E-Ticket</label>
                            <?php if($is_admin || $transport_status['show_upload']) { ?>
                            <input type="file" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="eticket_<?= $key ?>">
                            <?php } ?>
                            <?php if ($travel->eticket != '') { ?>
                                <br>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?=base_url() ?><?= $travel->eticket ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url( $travel->eticket); ?>" src="<?php echo get_preview( $travel->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?= $travel->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $travel->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                    <?php if($transport_status['show_transportation'] || $is_admin) { ?>
                                    <a href="<?= $url_delete.'/eticket/'.$grantee_grant->id.'/'.$travel->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                        <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                                    </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <!-- returning section -->
                <div class="col-lg-12 label-transport-domestic-<?= $key ?>">
                    <label>Returning Ticket</label>
                    <hr class="no-margin"/>
                </div>
                <div class="panel-body returing_section_domestic_<?= $key ?>">
                    <div class="col-lg-4 returing_section_domestic_<?= $key ?>">
                        <div class="form-group">
                            <label>Departure City</label>
                            <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="travel_arrangement[<?= $key ?>][returning_origin_city]" value="<?= $travel->returning_origin_city ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 returing_section_domestic_<?= $key ?>">
                        <div class="form-group">
                            <label>Destination City</label>
                            <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" placeholder="Destination City" name="travel_arrangement[<?= $key ?>][returning_destination_city]" value="<?= $travel->returning_destination_city ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Return Date</label>
                            <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="travel_arrangement[<?= $key ?>][returning_date_section]" value="<?= $travel->returning_date_section != '' ? date('d M Y', strtotime($travel->returning_date_section)) : '' ?>">
                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <?php if(!$is_grantee) { ?>
                    <div class="col-lg-4" id="travel_agen_returning_domestic_<?= $key ?>">
                        <div class="form-group">
                            <label>Travel Agent</label>
                            <select name="travel_arrangement[<?= $key ?>][travel_agent_returning]" class="form_control select2">
                                <option value="">-- Select --</option>
                                <?php foreach($travel_agents as $travel_agent) { 
                                    $selected = '';
                                    if ($travel->travel_agent_id == $travel_agent->id) {
                                        $selected = 'selected="selected"';
                                    }?>
                                    <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($transport_status['show_transportation_returning'] || $is_admin || $travel->eticket_returning != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_eticket_returning_domestic_<?= $key ?>">Returning E-Ticket</label>
                            <?php if($is_admin || $transport_status['show_transportation_returning']) { ?>
                            <input type="file" class="form-control  <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" name="eticket_returning_<?= $key ?>">
                            <?php } ?>
                            <?php if ($travel->eticket_returning != '') { ?>
                                <br>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?=base_url() ?><?= $travel->eticket_returning ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url( $travel->eticket_returning); ?>" src="<?php echo get_preview( $travel->eticket_returning); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?= $travel->eticket_returning ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $travel->eticket_returning) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                    <?php if($transport_status['show_transportation_returning'] || $is_admin) { ?>
                                    <a href="<?= $url_delete.'/eticket_returning/'.$grantee_grant->id.'/'.$travel->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                        <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
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
            </div>
            <?php } ?>
            <?php if(has_permission('travel_arrangement', 'add') || $is_grantee) { ?>
            <div class="panel-body section-accomodation-domestic-<?= $key ?>">
                <?php if($is_admin) { ?>
                <div class="row mt-5 section-accomodation-domestic-<?= $key ?>">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Accommodation Grantee</span>
                            <input data-id="<?= $travel->id ?>" onchange="enable_toogle(this, 'enable_accommodation')" id="enable_accommodation_<?= $key ?>" name="travel_arrangement[<?= $key ?>][enable_accommodation]" type="checkbox" <?= $travel->enable_accommodation ? 'checked' : '' ?>/>
                            <label for="enable_accommodation_<?= $key ?>" class="label-primary"></label>
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
                        <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="travel_arrangement[<?= $key ?>][checkin_date]" value="<?= $travel->checkin_date != '' ? date('d M Y', strtotime($travel->checkin_date)) : '' ?>">
                        <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Check-Out Date</label>
                        <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="travel_arrangement[<?= $key ?>][checkout_date]" value="<?= $travel->checkout_date != '' ? date('d M Y', strtotime($travel->checkout_date)) : '' ?>">
                        <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    </div>
                </div>
                <?php if($accommodation_status['show_upload'] || $is_admin || $travel->voucher_hotel != '') { ?>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label id="label_voucher_hotel_domestic_<?= $key ?>">Hotel Voucher</label>
                        <?php if($is_admin || $accommodation_status['show_upload']) { ?>
                        <input type="file" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="voucher_hotel_<?= $key ?>">
                        <?php } ?>
                        <?php if ( $travel &&  $travel->voucher_hotel != '') { ?>
                            <br>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                <a href="<?=base_url() ?><?= $travel->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                                    <img id="preview_image_profile" data-old="<?php echo site_url( $travel->voucher_hotel); ?>" src="<?php echo get_preview( $travel->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                </a>
                                <a href="<?=base_url() ?><?= $travel->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $travel->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                    <i class="fa fa-download fa-fw"></i>
                                </a>
                                <?php if($accommodation_status['show_transportation'] || $is_admin) { ?>
                                <a href="<?= $url_delete.'/voucher_hotel/'.$grantee_grant->id.'/'.$travel->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                    <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                                </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            
            <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
            <div class="panel-body">
                <div class="col-lg-4">
                    <div class="form-group ">
                        <label>Status Accommodation</label>
                        <select name="travel_arrangement[<?= $key ?>][status_accomodation]" class="form-control">
                            <option <?= $travel->status_accomodation == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                            <option <?= $travel->status_accomodation == 'done' ? 'selected' : '' ?> value="done">Done</option>
                        </select>
                    </div>
                </div>
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