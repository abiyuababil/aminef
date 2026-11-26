
                        <div id="travel_arrangement" class="active in first_tab">
                            <?php if($is_admin) { ?>
                                <?php if(!$is_alumni_page) { ?>
                                <div class="row mb-5">
                                    <div class="col-lg-12">
                                        <div class="TriSea-technologies-Switch">
                                            <span class="mr-2"> Set to Travel Arrangement</span>
                                            <input id="set_to_travel_arrangement" name="set_to_travel_arrangement" type="checkbox" <?= $grantee_grant->set_to_travel_arrangement  ? 'checked' : '' ?>/>
                                            <label for="set_to_travel_arrangement" class="label-primary"></label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            <?php } ?>
                            <div class="panel-group" id="accordionThree" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default hide">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionThree" href="#collapseDs2019Visa" aria-expanded="false" aria-controls="collapseDs2019Visa" onclick="set_session('ds2019Visa'); return get_visa(this);">
                                        <div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                            DS2019 & Visa
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseDs2019Visa" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'ds2019Visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <?php if(has_permission('nominee', 'departure') || !$is_admin) { ?>
                                            <div class="form-group">
                                                <label>Access the following documents for requesting your travel arrangement to the U.S.:</label>
                                                <ul>

                                                    <!-- ds2019 & visa page  -->
                                                    <table class="table table-striped table-bordered table-responsive table-sign my-3">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Surename/Last Name</th>
                                                                <th>Given Name/First Name</th>
                                                                <th>DS2019 (Signed)</th>
                                                                <th>Visa Page</th>
                                                                <?php if($visa_interview->appointment_located == 'Surabaya' && $is_admin) { ?>
                                                                <th>Enable Upload</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="list_ds2019sign_visapage">
                                                            <?php 
                                                                foreach($data_ds2019_sign as $key => $data_sign){ 
                                                                $required_fields = ['ds2019_sign', 'visa_page'];
                                                                $complete = !array_filter($required_fields, fn($f) => empty($data_sign->$f));
                                                            ?>
                                                            <tr id="index-sign-<?= $key + 1 ?>">
                                                                <td><?= $key + 1 ?></td>
                                                                <td><?= $data_sign->last_name ?></td>
                                                                <td><?= $data_sign->first_name ?? 'FNU' ?></td>
                                                                <td>
                                                                    <?php if($data_sign->ds2019_sign) { ?>
                                                                        <a href="<?= base_url($data_sign->ds2019_sign) ?>" class="lightbox btn btn-warning btn-xs btn-xs btn-view-req-ds2019_sign" style="color:#fff">View</a>
                                                                    <?php } ?>
                                                                    <?php if(($visa_interview->appointment_located == 'Surabaya' && $data_sign->grantee_edit) || $is_admin) { ?>
                                                                    <a href="javascript:;" class="btn btn-primary <?= ($complete && !$is_admin && !$data_sign->grantee_edit) ? 'hide' : '' ?> hide-complete upload-button btn-xs btn-ds2019_sign-<?= $data_sign->id ?>" data-file-value="upload_require_doc_ds2019_sign_<?= $data_sign->id ?>" style="color:#fff;">Upload</a>
                                                                    <?php } ?>
                                                                    <input type="file" data-table_save="save_ds2019_sign" data-doc="ds2019_sign" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_sign->id ?>" class="upload_require_doc_ds2019_sign_<?= $data_sign->id ?> hide">
                                                                    <?php if($data_sign->ds2019_sign) { ?>
                                                                        <?php if(($visa_interview->appointment_located == 'Surabaya' && $data_sign->grantee_edit) || $is_admin) { ?>
                                                                        <a href="javascript:;" onclick="del_data_required(this, <?= $data_sign->id ?>, 'ds2019_sign', 'delete_save_ds2019_sign', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs <?= ($complete && !$is_admin && !$data_sign->grantee_edit) ? 'hide' : '' ?> hide-complete btn-del-req-ds2019_sign-<?= $data_sign->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                                        <?php } ?>
                                                                        <a href="<?= base_url($data_sign->visa_page) ?>" class="lightbox btn btn-warning btn-xs btn-view-req-visa_page" style="color:#fff">View</a>
                                                                    <?php } ?>
                                                                    <?php if(($visa_interview->appointment_located == 'Surabaya' && $data_sign->grantee_edit) || $is_admin) { ?>
                                                                    <a href="javascript:;" class="btn btn-primary <?= ($complete && !$is_admin && !$data_sign->grantee_edit) ? 'hide' : '' ?> hide-complete upload-button btn-xs btn-visa_page-<?= $data_sign->id ?>" data-file-value="upload_require_doc_visa_page_<?= $data_sign->id ?>" style="color:#fff;">Upload</a>
                                                                        <?php if(($visa_interview->appointment_located == 'Surabaya' && $data_sign->grantee_edit) || $is_admin) { ?>
                                                                        <a href="javascript:;" onclick="del_data_required(this, <?= $data_sign->id ?>, 'visa_page', 'delete_save_ds2019_sign', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs <?= ($complete && !$is_admin && !$data_sign->grantee_edit) ? 'hide' : '' ?> hide-complete btn-del-req-visa_page-<?= $data_sign->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                                        <?php if($visa_interview->appointment_located == 'Surabaya' || $is_admin) { ?>
                                                                        <?php if(!$is_alumni_page) { ?>
                                                                        <a href="javascript:;" onclick="del_data_required(this, <?= $data_sign->id ?>, 'visa_page', 'delete_save_ds2019_sign', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs btn-del-req-visa_page-<?= $data_sign->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                                        <?php } ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </td>
                                                                <?php if($visa_interview->appointment_located == 'Surabaya' && $is_admin) { ?>
                                                                <td>
                                                                    <div class="TriSea-technologies-Switch" style="margin-left:15px;">
                                                                        <input onchange="grantee_edit_required(this, 'ds2019_sign')" data-id="<?= $data_sign->id ?>" name="grantee_edit" id="grantee_edit_ds2019_<?= $data_sign->id ?>" type="checkbox" <?= $data_sign->grantee_edit  ? 'checked' : '' ?>/>
                                                                        <label for="grantee_edit_ds2019_<?= $data_sign->id ?>" class="label-primary"></label>
                                                                    </div>
                                                                </td>
                                                                <?php } ?>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <!-- <li>DS2019 (Signed)</li>
                                                    <div class="panel-body">
                                                        <div class="col-lg-4">
                                                            <?php if($visa_interview->appointment_located == 'Surabaya' || $is_admin) { ?>
                                                            <input id="ds2019_signed" type="file" class="form-control" name="ds2019_signed">
                                                            <?php } ?>
                                                            <?php if ($visa_interview && $visa_interview->ds2019_signed != '') { ?>
                                                                <br>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;" id="file_ds2019_signed">
                                                                    <a href="<?=base_url() ?><?=$visa_interview->ds2019_signed ?>" class="lightbox" aria-haspopup="dialog">
                                                                        <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->ds2019_signed); ?>" src="<?php echo get_preview($visa_interview->ds2019_signed); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="<?=base_url() ?><?=$visa_interview->ds2019_signed ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->ds2019_signed) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                    <?php if($is_admin) { ?>
                                                                    <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                        <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'ds2019_signed', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                                    </a>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <li>Visa Page</li>
                                                    <div class="panel-body">
                                                        <div class="col-lg-4">
                                                            <?php if($visa_interview->appointment_located == 'Surabaya' || $is_admin) { ?>
                                                            <input id="visa_page" type="file" class="form-control" name="visa_page">
                                                            <?php } ?>
                                                            <?php if ($visa_interview && $visa_interview->visa_page != '') { ?>
                                                                <br>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;" id="file_visa_page">
                                                                    <a href="<?=base_url() ?><?=$visa_interview->visa_page ?>" class="lightbox" aria-haspopup="dialog">
                                                                        <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->visa_page); ?>" src="<?php echo get_preview($visa_interview->visa_page); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="<?=base_url() ?><?=$visa_interview->visa_page ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->visa_page) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                    <?php if($is_admin) { ?>
                                                                    <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                        <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'visa_page', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                                    </a>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div> -->
                                                </ul>
                                            </div>
                                            <hr />
                                            <?php } ?>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionThree" href="#collapseFourTravelDomestic" aria-expanded="false" aria-controls="collapseFourTravelDomestic" onclick="set_session('travel_arrangement'); return get_visa(this);">
                                        <div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                            Domestic Ticket
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseFourTravelDomestic" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'travel_arrangement' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <?php if($has_permission || !$is_admin) { ?>
                                            <div class="form-group">
                                                <label>Travel Arrangement</label>
                                                <ul>
                                                    <?php if(!$is_admin) { ?>
                                                        <input id="show_transportation_domestic" class="select_show hide " value="<?= $visa_interview->show_transportation_domestic ?>">
                                                        <input id="show_accomodation_domestic" class="select_show hide " value="<?= $visa_interview->show_accomodation_domestic ?>">
                                                    <?php } ?>
                                                    <?php if($is_admin && has_permission('nominee', 'departure')) { ?>
                                                    <label class="mt-3">Show Domestic Transportation</label>
                                                    <select class="form-control select_show" name="show_transportation_domestic" id="show_transportation_domestic">
                                                        <option value="">- Select -</option>
                                                        <option <?= $visa_interview->show_transportation_domestic == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $visa_interview->show_transportation_domestic == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $visa_interview->show_transportation_domestic == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                    </select>

                                                    <label class="mt-3">Show Domestic Accommodation</label>
                                                    <select class="form-control select_show" name="show_accomodation_domestic" id="show_accomodation_domestic">
                                                        <option value="">- Select -</option>
                                                        <option <?= $visa_interview->show_accomodation_domestic == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $visa_interview->show_accomodation_domestic == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $visa_interview->show_accomodation_domestic == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                    </select>
                                                    <?php } ?>
                                                    
                                                    <!-- <li class="<?= $visa_interview->show_transportation_domestic == 'Yes' || $visa_interview->show_accomodation_domestic == 'Yes' || $visa_interview->show_transportation_domestic == 'Reimbursement' || $visa_interview->show_accomodation_domestic == 'Reimbursement' ? '' : 'hide' ?> section-domestic mt-4">Domestic Ticket</li> -->

                                                    <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn my-5 btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                                                        <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                                                    </a>

                                                    <?php if($is_admin) { ?>
                                                    <?php if(!$is_alumni_page) { ?>
                                                    <div class="row my-5 section-transportation-domestic">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Transportation Grantee</span>
                                                                <input id="enable_transportation_domestic" name="enable_transportation_domestic" type="checkbox" <?= $visa_interview->enable_transportation_domestic  ? 'checked' : '' ?>/>
                                                                <label for="enable_transportation_domestic" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <div class="panel-body <?= $visa_interview->show_transportation_domestic == 'Yes' ? '' : 'hide' ?> section-transportation-domestic" style="margin-top:-20px">
                                                        <div class="col-lg-12">
                                                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                                                            <?php 
                                                                $required_fields = [
                                                                    'departure_date_domestic',
                                                                    'departure_city_domestic',
                                                                    'arrival_city_domestic',
                                                                    'eticket_domestic'
                                                                ];
                                                                $transport_status = evaluate_transportation($visa_interview, $is_admin, $required_fields, 'show_transportation_domestic', 'enable_transportation_domestic');
                                                            ?>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure Date</label>
                                                                <input 
                                                                    id="departure_date_domestic" 
                                                                    type="text" 
                                                                    class="form-control datepicker" 
                                                                    readonly style="background-color:<?= $transport_status['style_transportation'] ?>" 
                                                                    placeholder="Departure Date" 
                                                                    name="departure_date_domestic" 
                                                                    <?= $transport_status['disable_transportation'] ?>
                                                                    value="<?= $visa_interview  ? ($visa_interview->departure_date_domestic != '' ? date('d M Y', strtotime($visa_interview->departure_date_domestic)) : '') : '' ?>">
                                                                    <?php if($transport_status['show_transportation']) { ?>
                                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                    <?php } ?>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Returning Date</label>
                                                                <input 
                                                                    id="returning_date_domestic" 
                                                                    type="text" 
                                                                    class="form-control datepicker" 
                                                                    readonly style="background-color:<?= !$is_admin || $this->session->userdata('role') == 'travel-booking-assistant' ? ($visa_interview->show_transportation_domestic == 'Reimbursement' ? '#fff' : '#eee') : '#fff' ?>" 
                                                                    placeholder="Returning Date" 
                                                                    name="returning_date_domestic" 
                                                                    value="<?= $visa_interview  ? ($visa_interview->returning_date_domestic != '' ? date('d M Y', strtotime($visa_interview->returning_date_domestic)) : '') : '' ?>"
                                                                    <?= (!$is_admin) || $this->session->userdata('role') == 'travel-booking-assistant' ? ($visa_interview->show_transportation_domestic == 'Reimbursement' ? '' : 'disabled') : '' ?>>
                                                                <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || (!$is_admin && $visa_interview->show_transportation_domestic == 'Reimbursement')) { ?>
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input id="departure_city_domestic" type="text" class="form-control" placeholder="Departure City" name="departure_city_domestic" value="<?= $visa_interview ? $visa_interview->departure_city_domestic : '' ?>" <?= $transport_status['disable_transportation'] ?>>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Arrival City</label>
                                                                <input id="arrival_city_domestic" type="text" class="form-control" placeholder="Destination City" name="arrival_city_domestic" value="<?= $visa_interview ? $visa_interview->arrival_city_domestic : '' ?>" <?= $transport_status['disable_transportation'] ?>>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>KTP</label>
                                                                <!-- <input readonly id="ktp" type="text" class="form-control" name="ktp" value="<?= $grantee_grant->number_identity ?>"> -->
                                                                <?php if ($grantee_grant->img_passport != '') { ?>
                                                                    <br>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket">
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
                                                        <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="travel_agent_domestic" class="form-control selectpicker" data-live-search="true">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($visa_interview->travel_agent_domestic == $travel_agent->id) {
                                                                            $selected = 'selected="selected"';
                                                                        }?>
                                                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <?php if (($visa_interview && $visa_interview->eticket_domestic != '') || $transport_status['show_transportation'] || $is_admin) { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_eticket_domestic">E-Ticket</label>
                                                                <?php if($is_admin || $transport_status['show_transportation']) { ?>
                                                                <input id="eticket_domestic" type="file" class="form-control" name="eticket_domestic">
                                                                <?php } ?>
                                                                <?php if ($visa_interview && $visa_interview->eticket_domestic != '') { ?>
                                                                    <br>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket_domestic">
                                                                        <a href="<?=base_url() ?><?=$visa_interview->eticket_domestic ?>" class="lightbox" aria-haspopup="dialog">
                                                                            <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->eticket_domestic); ?>" src="<?php echo get_preview($visa_interview->eticket_domestic); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                        </a>
                                                                        <a href="<?=base_url() ?><?=$visa_interview->eticket_domestic ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->eticket_domestic) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                                            <i class="fa fa-download fa-fw"></i>
                                                                        </a>
                                                                        <?php if($is_admin) { ?>
                                                                        <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                            <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'eticket_domestic', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                                        </a>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    
                                                    <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                                        <div class="panel-body <?= $visa_interview->show_transportation_domestic == 'Yes' ? '' : 'hide' ?> section-transportation-domestic">
                                                            <div class="col-lg-4">
                                                                <div class="form-group ">
                                                                    <label>Status Transportation</label>
                                                                    <select name="status_transportation_domestic" class="form-control">
                                                                        <option <?= $visa_interview->status_transportation_domestic == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                                                                        <option <?= $visa_interview->status_transportation_domestic == 'done' ? 'selected' : '' ?> value="done">Done</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>


                                                    <?php if($is_admin) { ?>
                                                    <div class="row mb-5 <?= $visa_interview->show_accomodation_domestic == 'Yes' ? '' : 'hide' ?> section-accomodation-domestic">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Accommodation Grantee</span>
                                                                <input id="enable_accommodation_domestic" name="enable_accommodation_domestic" type="checkbox" <?= $visa_interview->enable_accommodation_domestic  ? 'checked' : '' ?>/>
                                                                <label for="enable_accommodation_domestic" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <div class="panel-body <?= $visa_interview->show_accomodation_domestic == 'Yes' ? '' : 'hide' ?> section-accomodation-domestic" style="margin-top:-20px">
                                                        <div class="col-lg-12">
                                                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                                                            <?php 
                                                                $required_fields = [
                                                                    'checkin_date_domestic',
                                                                    'checkout_date_domestic',
                                                                    'voucher_hotel_domestic'
                                                                ];
                                                                $accommodation_status = evaluate_transportation($visa_interview, $is_admin, $required_fields, 'show_accomodation_domestic', 'enable_accommodation_domestic');
                                                            ?>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Check In Date</label>
                                                                <input 
                                                                    id="checkin_date_domestic" 
                                                                    type="text" 
                                                                    class="form-control datepicker" 
                                                                    readonly style="background-color:<?= $accommodation_status['style_transportation'] ?>" 
                                                                    placeholder="Check In Date" 
                                                                    name="checkin_date_domestic" 
                                                                    value="<?= $visa_interview  ? ($visa_interview->checkin_date_domestic != '' ? date('d M Y', strtotime($visa_interview->checkin_date_domestic)) : '') : '' ?>"
                                                                    <?= $accommodation_status['disable_transportation'] ?>>
                                                                <?php if($accommodation_status['show_transportation']) { ?>
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Check Out Date</label>
                                                                <input 
                                                                    id="checkout_date_domestic" 
                                                                    type="text" 
                                                                    class="form-control datepicker" 
                                                                    readonly style="background-color:<?= $accommodation_status['style_transportation'] ?>" 
                                                                    placeholder="Check Out Date" 
                                                                    name="checkout_date_domestic" 
                                                                    value="<?= $visa_interview  ? ($visa_interview->checkout_date_domestic != '' ? date('d M Y', strtotime($visa_interview->checkout_date_domestic)) : '') : '' ?>"
                                                                    <?= $accommodation_status['disable_transportation'] ?>>
                                                                <?php if($accommodation_status['show_transportation']) { ?>
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <?php if (($grantee_grant && $visa_interview->voucher_hotel_domestic != '') || $accommodation_status['show_transportation'] || $is_admin) { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_voucher_hotel_domestic">Hotel Voucher</label>
                                                                <?php if($accommodation_status['show_transportation'] || $is_admin) { ?>
                                                                <input id="voucher_hotel_domestic" type="file" class="form-control" name="voucher_hotel_domestic">
                                                                <?php } ?>
                                                                <?php if ($grantee_grant && $visa_interview->voucher_hotel_domestic != '') { ?>
                                                                <br>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;" id="file_voucher_hotel_domestic">
                                                                    <a href="<?=base_url() ?><?=$visa_interview->voucher_hotel_domestic ?>" class="lightbox" aria-haspopup="dialog">
                                                                        <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->voucher_hotel_domestic); ?>" src="<?php echo get_preview($visa_interview->voucher_hotel_domestic); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="<?=base_url() ?><?=$visa_interview->voucher_hotel_domestic ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->voucher_hotel_domestic) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                    <?php if($is_admin) { ?>
                                                                    <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                        <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'voucher_hotel_domestic', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                                    </a>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    
                                                    <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                                        <div class="panel-body <?= $visa_interview->show_accomodation_domestic == 'Yes' || $visa_interview->show_accomodation_domestic == 'Reimbursement' ? '' : 'hide' ?> section-accomodation-domestic">
                                                            <div class="col-lg-4">
                                                                <div class="form-group ">
                                                                    <label>Status Accommodation</label>
                                                                    <select name="status_accommodation_domestic" class="form-control">
                                                                        <option <?= $visa_interview->status_accommodation_domestic == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                                                                        <option <?= $visa_interview->status_accommodation_domestic == 'done' ? 'selected' : '' ?> value="done">Done</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                </ul>
                                            </div>
                                            <hr />
                                            <?php } ?>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionThree" href="#collapseFourTravelInternational" aria-expanded="false" aria-controls="collapseFourTravelInternational" onclick="set_session('international_ticket'); return get_visa(this);">
                                        <div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                            International Ticket
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseFourTravelInternational" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'international_ticket' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <?php if($has_permission || !$is_admin) { ?>
                                            <div class="panel-body">
                                                <a href="<?= base_url($grantee_grant->procedure_international) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->procedure_international ? '' : 'hide' ?>" style="color:#fff">
                                                    <i class="fa fa-download fa-fw text-white"></i> Procedure of International Ticket Purchase
                                                </a>
                                                <?php if($is_admin) { ?>
                                                    <div class="row mb-5">
                                                    <?php if(!$is_alumni_page) { ?>
                                                    <div class="col-lg-12">
                                                        <div class="TriSea-technologies-Switch">
                                                            <span class="mr-2"> Enable International Ticket Grantee</span>
                                                            <input id="enable_international_ticket" name="enable_international_ticket" type="checkbox" <?= $visa_interview->enable_international_ticket  ? 'checked' : '' ?>/>
                                                            <label for="enable_international_ticket" class="label-primary"></label>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                                    <div class="col-lg-12 mt-5">
                                                        <label>Show International Ticket</label>
                                                        <select class="form-control select_show" name="show_international_ticket" id="show_international_ticket">
                                                            <option <?= $visa_interview->show_international_ticket == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                            <option <?= $visa_interview->show_international_ticket == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group">
                                                <ul>
                                                    <!-- <li class="mt-4">International Ticket</li> -->
                                                    <div class="form-group mt-3">
                                                        <?php if($collage_placement->test_type) {  ?>
                                                        <?php 
                                                            if ($visa_interview->is_updated_pre_academic) {
                                                                $start_date_pre = $visa_interview->start_date_pre_academic;
                                                                $end_date_pre = $visa_interview->end_date_pre_academic;
                                                                $arrival_date_pre = $visa_interview->arrival_date_pre_academic;
                                                                // if (!empty($start_date_pre)) {
                                                                //     $arrival_date_pre = date('Y-m-d', strtotime($start_date_pre . ' -1 day'));
                                                                // } else {
                                                                // }
                                                            } else {
                                                                $start_date_pre = $visa_interview->start_date_pre_academic != '' ? $visa_interview->start_date_pre_academic : $collage_placement->start_date_pre_academic; 
                                                                $end_date_pre = $visa_interview->end_date_pre_academic != '' ? $visa_interview->end_date_pre_academic : $collage_placement->end_date_pre_academic; 
                                                                if (!empty($start_date_pre)) {
                                                                    $arrival_date_pre = $grantee_grant->is_degree ? date('Y-m-d', strtotime($start_date_pre . ' -1 day')) : date('Y-m-d', strtotime($start_date_pre));
                                                                } else {
                                                                    $arrival_date_pre = '';
                                                                }
                                                            }

                                                            $is_first_pre_academic = true;
                                                            if($visa_interview->save_grantee){
                                                                $is_first_pre_academic = false;
                                                            }

                                                            if($is_first_pre_academic){
                                                                $disabled_date_pre_academic = !$is_admin ? true : false;
                                                                $show_date_pre_academic = false;
                                                            }else{
                                                                $disabled_date_pre_academic = $is_admin ? false : !$is_admin && !$visa_interview->enable_arrival_date_pre_academic;
                                                                $show_date_pre_academic = $is_admin ? true : !$is_admin && $visa_interview->enable_arrival_date_pre_academic;
                                                            }
                                                        ?>
                                                        <label>Pre-Academic Program/ Long-Term English/ Gateway Orientation</label>
                                                        <?php if($is_admin) { ?>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <div class="panel-body">
                                                                <div class="col-lg-12">
                                                                    <div class="TriSea-technologies-Switch">
                                                                        <span class="mr-2"> Enable Arrival Date</span>
                                                                        <input id="enable_arrival_date_pre_academic" name="enable_arrival_date_pre_academic" type="checkbox" <?= $visa_interview->enable_arrival_date_pre_academic  ? 'checked' : '' ?>/>
                                                                        <label for="enable_arrival_date_pre_academic" class="label-primary"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <div class="panel-body">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>University</label>
                                                                    <input type="hidden" id="id_univ_grantee" value="<?= $collage_placement->university_id_pre_academic ?>">
                                                                    <input type="text" class="form-control" value="<?= $collage_placement->university_id_pre_academic ? get_university_by_id($collage_placement->university_id_pre_academic)->name : '' ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Start Date</label>
                                                                    <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= (!$is_admin &&  $visa_interview->save_grantee) || (!$is_admin && !$visa_interview->enable_international_ticket) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="Start Date" name="start_date_pre_academic" value="<?= $start_date_pre ? date('d M Y', strtotime($start_date_pre)) : '' ?>">
                                                                    <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                    <?php } ?>
                                                                </div>  
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>End Date</label>
                                                                    <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= (!$is_admin &&  $visa_interview->save_grantee) || (!$is_admin && !$visa_interview->enable_international_ticket) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="End Date" name="end_date_pre_academic" value="<?= $end_date_pre ? date('d M Y', strtotime($end_date_pre)) : '' ?>">
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
                                                                    <input <?= $disabled_date_pre_academic ? 'disabled' : ''?> id="arrival_date_pre_academic" type="text" readonly style="background-color:<?= ($disabled_date_pre_academic) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="Arrival Date
                                                                    " name="arrival_date_pre_academic" value="<?= $arrival_date_pre ? date('d M Y', strtotime($arrival_date_pre)) : '' ?>">
                                                                    <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || ($show_date_pre_academic)) { ?>
                                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Departure City</label>
                                                                    <input id="departure_city_pre_academic" <?= !$is_admin ? 'readonly' : '' ?> type="text" class="form-control" placeholder="Departure City" name="departure_city_pre_academic" value="<?= $visa_interview ? $visa_interview->departure_city_pre_academic : 'Jakarta' ?>" <?= $this->session->userdata('role') != 'travel-booking-assistant' ? '' : 'disabled';?>>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Arrival City</label>
                                                                    <input id="arrival_city_pre_academic" type="text" class="form-control" placeholder="Destination City" name="arrival_city_pre_academic" value="<?= $visa_interview ? $visa_interview->arrival_city_pre_academic : '' ?>" <?= !$is_admin && !$visa_interview->enable_international_ticket ? 'disabled' : ''?>>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Arrival Airport</label>
                                                                    <input id="arrival_airport_pre_academic" type="text" class="form-control" placeholder="Destination City" name="arrival_airport_pre_academic" value="<?= $visa_interview ? $visa_interview->arrival_airport_pre_academic : '' ?>" <?= !$is_admin && !$visa_interview->enable_international_ticket ? 'disabled' : ''?>>
                                                                </div>
                                                            </div>
                                                            <?php if (($visa_interview && $visa_interview->eticket_pre_academic != '') || $is_admin || (!$is_admin && $visa_interview->show_international_ticket == 'Reimbursement')) { ?>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>E-Ticket</label>
                                                                    <?php if($is_admin || (!$is_admin && $visa_interview->show_international_ticket == 'Reimbursement' && $visa_interview->enable_international_ticket)) { ?>
                                                                    <input id="eticket_pre_academic" type="file" class="form-control" name="eticket_pre_academic">
                                                                    <?php } ?>
                                                                    <?php if ($visa_interview && $visa_interview->eticket_pre_academic != '') { ?>
                                                                        <br>
                                                                        <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket_pre_academic">
                                                                            <a href="<?=base_url() ?><?=$visa_interview->eticket_pre_academic ?>" class="lightbox" aria-haspopup="dialog">
                                                                                <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->eticket_pre_academic); ?>" src="<?php echo get_preview($visa_interview->eticket_pre_academic); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                            </a>
                                                                            <a href="<?=base_url() ?><?=$visa_interview->eticket_pre_academic ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->eticket_pre_academic) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                                                <i class="fa fa-download fa-fw"></i>
                                                                            </a>
                                                                            <?php if($is_admin) { ?>
                                                                            <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                                <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'eticket_pre_academic', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
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
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <div class="panel-body">
                                                                <div class="col-lg-12">
                                                                    <div class="TriSea-technologies-Switch">
                                                                        <span class="mr-2"> Enable Arrival/Departure Date</span>
                                                                        <input id="enable_arrival_date_academic_program" name="enable_arrival_date_academic_program" type="checkbox" <?= $visa_interview->enable_arrival_date_academic_program  ? 'checked' : '' ?>/>
                                                                        <label for="enable_arrival_date_academic_program" class="label-primary"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <div class="panel-body">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>University</label>
                                                                    <?php 
                                                                    $univ_id = $collage_placement->university_id; 
                                                                    $is_first = true;
                                                                    if ($visa_interview->is_updated_academic) {
                                                                        $start_date = $visa_interview->start_date_academic_program; 
                                                                        $end_date = $visa_interview->end_date_academic_program; 
                                                                        $arr_date = $visa_interview->arrival_date_academic_program; 
                                                                        $dep_date = $visa_interview->departure_date_academic_program; 
                                                                        // if($collage_placement->test_type){
                                                                        //     $arr_date = $visa_interview->arrival_date_academic_program; 
                                                                        //     $dep_date = $visa_interview->departure_date_academic_program; 
                                                                        // }else{
                                                                        //     if (!empty($start_date)) {
                                                                        //         $dep_date = $arr_date = date('Y-m-d', strtotime($start_date . ' -1 day'));
                                                                        //     } else {
                                                                        //         $dep_date = $arr_date = '';
                                                                        //     }
                                                                        // }
                                                                    } else {
                                                                        $start_date = $visa_interview->start_date_academic_program != '' ? $visa_interview->start_date_academic_program : $collage_placement->start_date; 
                                                                        $end_date = $visa_interview->end_date_academic_program != '' ? $visa_interview->end_date_academic_program : $collage_placement->end_date; 
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

                                                                    $disabled_date = $is_admin ? false : !$is_admin && !$visa_interview->enable_arrival_date_academic_program;
                                                                    $show_date = $is_admin ? true : !$is_admin && $visa_interview->enable_arrival_date_academic_program;

                                                                    ?>
                                                                    <input type="hidden" id="id_univ_grantee" value="<?= $univ_id ?>">
                                                                    <input type="text" class="form-control" value="<?= $univ_id ? get_university_by_id($univ_id)->name : '' ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Start Date</label>
                                                                    <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= !$is_admin || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="Start Date" name="start_date_academic_program" value="<?= $start_date ? date('d M Y', strtotime($start_date)) : '' ?>">
                                                                    <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant')) { ?>
                                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                    <?php } ?>
                                                                </div>  
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>End Date</label>
                                                                    <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?> type="text" readonly style="background-color:<?= !$is_admin || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" class="form-control datepicker" placeholder="End Date" name="end_date_academic_program" value="<?= $end_date ? date('d M Y', strtotime($end_date)) : '' ?>">
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
                                                                    <input <?= $disabled_date ? 'disabled' : ''?> id="departure_date_academic_program" type="text" class="form-control datepicker" readonly style="background-color:<?= ($disabled_date) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" placeholder="Departure Date" name="departure_date_academic_program" value="<?= $dep_date ? date('d M Y', strtotime($dep_date)) : '' ?>">
                                                                    <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || $show_date) { ?>
                                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <?php }else{ ?>
                                                            <div class="col-lg-4"> <!-- jika tidak ada pre-academic -->
                                                                <div class="form-group">
                                                                    <label>Arrival Date</label>
                                                                    <input <?= $disabled_date ? 'disabled' : ''?> id="arrival_date_academic_program" type="text" class="form-control datepicker" readonly style="background-color:<?= ($disabled_date) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" placeholder="Arrival Date" name="arrival_date_academic_program" value="<?= $arr_date ? date('d M Y', strtotime($arr_date)) : '' ?>">
                                                                    <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || $show_date) { ?>
                                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Departure City</label>
                                                                    <input id="departure_city_academic_program" type="text" class="form-control" placeholder="Departure City" name="departure_city_academic_program" value="<?= $visa_interview && $visa_interview->departure_city_academic_program != '' ? $visa_interview->departure_city_academic_program : 'Jakarta' ?>" <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?>>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Arrival City</label>
                                                                    <input id="arrival_city_academic_program" type="text" class="form-control" placeholder="Arrival City" name="arrival_city_academic_program" value="<?= $visa_interview ? $visa_interview->arrival_city_academic_program : '' ?>" <?= !$is_admin && !$visa_interview->enable_international_ticket ? 'disabled' : ''?>>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Arrival Airport</label>
                                                                    <input id="arrival_airport_academic_program" type="text" class="form-control" placeholder="Arrival Airport" name="arrival_airport_academic_program" value="<?= $visa_interview ? $visa_interview->arrival_airport_academic_program : '' ?>" <?= !$is_admin && !$visa_interview->enable_international_ticket ? 'disabled' : ''?>>
                                                                </div>
                                                            </div>
                                                            <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Travel Agent</label>
                                                                    <select name="travel_agent_academic_program" class="form-control selectpicker" data-live-search="true">
                                                                        <option value="">-- Select --</option>
                                                                        <?php foreach($travel_agents as $travel_agent) { 
                                                                            $selected = '';
                                                                            if ($visa_interview->travel_agent_academic_program == $travel_agent->id) {
                                                                                $selected = 'selected="selected"';
                                                                            }?>
                                                                            <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                            <?php if (($visa_interview && $visa_interview->eticket_academic_program != '') || $is_admin || (!$is_admin && $visa_interview->show_international_ticket == 'Reimbursement')) { ?>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>E-Ticket</label>
                                                                    <?php if($is_admin || (!$is_admin && $visa_interview->show_international_ticket == 'Reimbursement' && $visa_interview->enable_international_ticket)) { ?>
                                                                    <input id="eticket_academic_program" type="file" class="form-control" name="eticket_academic_program">
                                                                    <?php } ?>
                                                                    <?php if ($visa_interview && $visa_interview->eticket_academic_program != '') { ?>
                                                                        <br>
                                                                        <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket_academic_program">
                                                                            <a href="<?=base_url() ?><?=$visa_interview->eticket_academic_program ?>" class="lightbox" aria-haspopup="dialog">
                                                                                <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->eticket_academic_program); ?>" src="<?php echo get_preview($visa_interview->eticket_academic_program); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                            </a>
                                                                            <a href="<?=base_url() ?><?=$visa_interview->eticket_academic_program ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->eticket_academic_program) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                                                <i class="fa fa-download fa-fw"></i>
                                                                            </a>
                                                                            <?php if($is_admin) { ?>
                                                                            <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                                <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'eticket_academic_program', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                                            </a>
                                                                            <?php } ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                            <?php if (($visa_interview && $visa_interview->receipt_academic_program != '') || $is_admin || (!$is_admin && $visa_interview->show_international_ticket == 'Reimbursement')) { ?>
                                                            <div class="col-lg-4 section-receipt-academic-program">
                                                                <div class="form-group">
                                                                    <label>Receipt</label>
                                                                    <?php if($is_admin || (!$is_admin && $visa_interview->show_international_ticket == 'Reimbursement' && $visa_interview->enable_international_ticket)) { ?>
                                                                    <input id="receipt_academic_program" type="file" class="form-control" name="receipt_academic_program">
                                                                    <?php } ?>
                                                                    <?php if ($visa_interview && $visa_interview->receipt_academic_program != '') { ?>
                                                                        <br>
                                                                        <div style="margin-bottom:10px; position:relative; width:100px;" id="file_receipt_academic_program">
                                                                            <a href="<?=base_url() ?><?=$visa_interview->receipt_academic_program ?>" class="lightbox" aria-haspopup="dialog">
                                                                                <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->receipt_academic_program); ?>" src="<?php echo get_preview($visa_interview->receipt_academic_program); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                            </a>
                                                                            <a href="<?=base_url() ?><?=$visa_interview->receipt_academic_program ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->receipt_academic_program) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                                                <i class="fa fa-download fa-fw"></i>
                                                                            </a>
                                                                            <?php if($is_admin) { ?>
                                                                            <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                                <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'receipt_academic_program', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
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
                                                                        <select name="status_transportation_academic_program" class="form-control">
                                                                            <option <?= $visa_interview->status_transportation_academic_program == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                                                                            <option <?= $visa_interview->status_transportation_academic_program == 'done' ? 'selected' : '' ?> value="done">Done</option>
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
                                            </div>
                                            <hr />
                                            <?php } ?>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(!$is_alumni_page) { ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="pull-right">
                                        <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                                            <button type="button" name="btn" value="save_domestic_transportation" onclick="return showSwal('confirm_submit', 'Are you sure you want to save and send email?', false, false, false, '#form', 'save_domestic_transportation')" class="btn btn-primary">Send Domestic Transportation</button>
                                            <button type="button" name="btn" value="save_domestic_accommodation" onclick="return showSwal('confirm_submit', 'Are you sure you want to save and send email?', false, false, false, '#form', 'save_domestic_accommodation')" class="btn btn-primary">Send Domestic Accommodation</button>
                                            <button type="button" name="btn" value="save_international_transportation" onclick="return showSwal('confirm_submit', 'Are you sure you want to save and send email?', false, false, false, '#form', 'save_international_transportation')" class="btn btn-primary">Send International Transportation</button>
                                        <?php } ?>
                                        <button type="button" name="btn" value="save_travel" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_travel')" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>