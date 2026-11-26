<style>
    .panel-default .panel-heading{
        background-color: rgb(236 240 244);
        color: #000;
        /* border-radius: 8px;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important; */
        padding: 20px;
    }

    .panel-collapse{
        border: 1px solid rgb(236 240 244);
    }
</style>

<link href="<?php echo base_url() ?>css/jquery-ui.min.css" rel="stylesheet">
<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Pre Departure Orientation</h2>
        <h1 class="page-header"><?= $grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" style="margin-bottom:10px">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissable text-justify">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php } ?>
        <?php $this->session->unset_userdata('success');?>
    </div>
</div>
<form method="POST" enctype="multipart/form-data">
    <?php if ($pre_depature->id) { ?>
        <input type="hidden" name="pre_depature_id" value="<?= $pre_depature->id ?>">
    <?php } ?>
    <div class="row">
        <div class="panel-body">
            <div class="col-lg-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePDO" aria-expanded="false" aria-controls="collapsePDO">
                            <div class="panel-heading text-left" role="tab" id="pdo">
                                <h4 class="panel-title">
                                    Pre Departure Orientation
                                </h4>
                            </div>
                        </a>
                        <div id="collapsePDO" class="panel-collapse collapse" role="tabpanel" aria-labelledby="pdo">
                            <!-- online -->
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>PDO Format</label>
                                        <?php $pdo_format = $pre_depature_global->pdo_format != '' ? $pre_depature_global->pdo_format : ($pre_depature_period->pdo_format != '' ? $pre_depature_period->pdo_format : $pre_depature->pdo_format) ?>
                                        <select class="form-control" disabled name="pdo_format">
                                            <option value="online" <?php echo $pdo_format == 'online' ? 'selected' : ''; ?>>Online</option>
                                            <option value="offline" <?php echo $pdo_format == 'offline' ? 'selected' : ''; ?>>Offline</option>
                                            <option value="hybrid" <?php echo $pdo_format == 'hybrid' ? 'selected' : ''; ?>>Hybrid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php if($pdo_format == 'online' || $pdo_format == 'hybrid'){ ?>
                            <div class="panel-body" style="margin-bottom:-25px;">
                                <div class="col-lg-8">
                                    <label>Online</label>
                                    <hr style="margin-top:5px;margin-bottom:10px;"/>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <?php $pdo_date = $pre_depature_global->date != '' ? $pre_depature_global->date : ($pre_depature_period->date != '' ? $pre_depature_period->date : $pre_depature->date) ?>
                                        <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" name="date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <?php $pdo_date = $pre_depature_global->end_date != '' ? $pre_depature_global->end_date : ($pre_depature_period->end_date != '' ? $pre_depature_period->end_date : $pre_depature->end_date) ?>
                                        <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" name="date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>Location Online</label>
                                        <?php $pdo_location_online = $pre_depature_global->location != '' ? $pre_depature_global->location : ($pre_depature_period->location != '' ? $pre_depature_period->location : $pre_depature->location) ?>
                                        <!-- <textarea class="form-control" name="location"><?= format_editor_html_for_email($pdo_location_online) ?></textarea> -->
                                        <div id="research_travel" class="form-control" style="resize: none; white-space: pre-wrap; word-wrap: break-word; min-height: 150px; overflow-y: auto;" readonly><?= format_editor_html_for_email($pdo_location_online) ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <!-- offline -->
                             <?php if($pdo_format == 'offline' || $pdo_format == 'hybrid'){ ?>
                            <div class="panel-body" style="margin-bottom:-25px;">
                                <div class="col-lg-8">
                                    <label>Offline</label>
                                    <hr style="margin-top:5px;margin-bottom:10px;"/>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <?php $pdo_date = $pre_depature_global->date_offline != '' ? $pre_depature_global->date_offline : ($pre_depature_period->date_offline != '' ? $pre_depature_period->date_offline : $pre_depature->date_offline) ?>
                                        <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" name="date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <?php $pdo_date = $pre_depature_global->end_date_offline != '' ? $pre_depature_global->end_date_offline : ($pre_depature_period->date_offline != '' ? $pre_depature_period->date_offline : $pre_depature->date_offline) ?>
                                        <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" name="date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <?php $pdo_location_offline = $pre_depature_global->location_offline != '' ? $pre_depature_global->location_offline : ($pre_depature_period->location_offline != '' ? $pre_depature_period->location_offline : $pre_depature->location_offline) ?>
                                        <!-- <textarea class="form-control" name="location"><?= $pdo_location_offline ?></textarea> -->
                                        <div id="research_travel" class="form-control" style="resize: none; white-space: pre-wrap; word-wrap: break-word; min-height: 150px; overflow-y: auto;" readonly><?= format_editor_html_for_email($pdo_location_offline) ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>


                            <div class="panel-body" style="margin-top:-30px">
                                <?php $pdo_agenda = $pre_depature_global->agenda != '' ? $pre_depature_global->agenda : ($pre_depature_period->agenda != '' ? $pre_depature_period->agenda : $pre_depature->agenda) ?>
                                <?php if($pdo_agenda != '') { ?>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Agenda</label><br>
                                        <!-- <input type="file" class="form-control" name="agenda"> -->
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?= base_url($pdo_agenda)?>" class="lightbox"><img width="100" src="<?php echo get_preview($pdo_agenda); ?>"></a>
                                        <a href="<?= base_url($pdo_agenda) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0px; right:-28px;">
                                            <i class="fa fa-download fa-fw text-white"></i>
                                        </a>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php $pdo_participant = $pre_depature_global->participant != '' ? $pre_depature_global->participant : ($pre_depature_period->participant != '' ? $pre_depature_period->participant : $pre_depature->participant) ?>
                                <?php if($pdo_participant != '') { ?>
                                <!-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Participant</label><br>
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?= base_url($pdo_participant)?>" class="lightbox"><img width="100" src="<?php echo get_preview($pdo_participant); ?>"></a>
                                        <a href="<?= base_url($pdo_participant) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0px; right:-28px;">
                                            <i class="fa fa-download fa-fw text-white"></i>
                                        </a>
                                        </div>
                                    </div>
                                </div> -->
                                <?php } ?>

                                <?php $pdo_final_biosketch_of_speakers = $pre_depature_global->final_biosketch_of_speakers != '' ? $pre_depature_global->final_biosketch_of_speakers : ($pre_depature_period->final_biosketch_of_speakers != '' ? $pre_depature_period->final_biosketch_of_speakers : $pre_depature->final_biosketch_of_speakers) ?>
                                <?php if($pdo_final_biosketch_of_speakers != '') { ?>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Final Biosketch of Facilitator</label><br>
                                        <!-- <input type="file" class="form-control" name="final_biosketch_of_speakers"> -->
                                        <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?= base_url($pdo_final_biosketch_of_speakers)?>" class="lightbox"><img width="100" src="<?php echo get_preview($pdo_final_biosketch_of_speakers); ?>"></a>
                                        <a href="<?= base_url($pdo_final_biosketch_of_speakers) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0px; right:-28px;">
                                            <i class="fa fa-download fa-fw text-white"></i>
                                        </a>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTravel" aria-expanded="false" aria-controls="collapseTravel">
                            <div class="panel-heading text-left" role="tab" id="travel">
                                <h4 class="panel-title">
                                    Travel Arrangement
                                </h4>
                            </div>
                        </a>
                        <div id="collapseTravel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="travel">

                            <div class="panel-body">
                                <?php if($this->session->userdata('role') == 'travel-booking-assistant' || !$is_admin) { ?>
                                    <input id="show_transportation" onchange="show_hide_transportation(this, 'pdo', 0)" class="select_show hidden" value="<?= $pre_depature->show_transportation ?>">
                                    <input id="show_accomodation" onchange="show_hide_accomodation(this, 'pdo', 0)" class="select_show hidden" value="<?= $pre_depature->show_accomodation ?>">
                                <?php } ?>
                                <?php if(has_permission('nominee', 'pre_departure_orientation')) { ?>
                                <div class="panel-body hide" style="margin-bottom:20px;">
                                    <label>Show Transportation</label>
                                    <select class="form-control select_show" name="show_transportation" id="show_transportation" onchange="show_hide_transportation(this, 'pdo', 0)">
                                        <option value="">- Select -</option>
                                        <option <?= $pre_depature->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                        <option <?= $pre_depature->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                        <option <?= $pre_depature->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                                    </select>
                                    <label class="mt-3">Show Accomodation</label>
                                    <select class="form-control select_show" name="show_accomodation" id="show_accomodation" onchange="show_hide_accomodation(this, 'pdo', 0)">
                                        <option value="">- Select -</option>
                                        <option <?= $pre_depature->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                        <option <?= $pre_depature->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                        <option <?= $pre_depature->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                                    </select>
                                </div>
                                <?php } ?>
                                <a href="<?= base_url($grantee_grant->domestic_ticket_purchase) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->domestic_ticket_purchase ? '' : 'hide' ?>" style="color:#fff">
                                    <i class="fa fa-download fa-fw text-white"></i> Guideline (Procedure of Domestic Ticket Purchase)
                                </a>
                                <?php if(has_permission('nominee', 'domestic_ticket') || !$is_admin) { ?>
                                <div class="col-lg-12 section-transportation-pdo-0">
                                    <div class="row">
                                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i>Transportation</p>
                                        <?php 
                                            $disable_transportation = '';
                                            $show_transportation = true;
                                            $style_transportation = '#fff';
                                            $complete_transport = false;
                                            if($pre_depature->domestic_ticket_city && $pre_depature->destination_city && $pre_depature->domestic_ticket_departure_date && $pre_depature->domestic_ticket_return_date && $pre_depature->eticket){
                                                $complete_transport = true;
                                            }

                                            if($pre_depature->show_transportation == 'Yes'){
                                                $disable_transportation = 'disabled';
                                                $style_transportation = '#eee';
                                                $show_transportation = false;
                                            }else if($is_admin || $pre_depature->show_transportation == 'Reimbursement'){
                                                if(!$pre_depature->grantee_submit && $complete_transport){
                                                    $disable_transportation = 'disabled';
                                                    $style_transportation = '#eee';
                                                    $show_transportation = false;
                                                }
                                            }
                                        ?>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Departure City</label>
                                                <input 
                                                    type="text" 
                                                    <?= $disable_transportation ?> 
                                                    class="form-control" 
                                                    placeholder="City" 
                                                    name="domestic_ticket_city" 
                                                    value="<?= $pre_depature->domestic_ticket_city ? $pre_depature->domestic_ticket_city : '' ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Destination City</label>
                                                <input 
                                                    type="text" 
                                                    <?= $disable_transportation ?>  
                                                    class="form-control" 
                                                    placeholder="City" 
                                                    name="destination_city" 
                                                    value="<?= $pre_depature->destination_city ? $pre_depature->destination_city : '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Departure Date</label>
                                                <input 
                                                    type="text" <?= $disable_transportation ?> 
                                                    readonly 
                                                    style="background-color:<?= $style_transportation ?>" 
                                                    class="form-control datepicker" 
                                                    placeholder="Departure Date" 
                                                    name="domestic_ticket_departure_date" 
                                                    value="<?= $pre_depature->domestic_ticket_departure_date ? date('d M Y', strtotime($pre_depature->domestic_ticket_departure_date)) : '' ?>"
                                                >
                                                <?php if($show_transportation) { ?>
                                                <a href="javascript:;" 
                                                onclick="emptyValue(this)" 
                                                class="btn btn-secondary" 
                                                style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Returning Date</label>
                                                <input 
                                                    type="text" 
                                                    style="background-color:<?= $style_transportation ?>" 
                                                    class="form-control datepicker" 
                                                    placeholder="Return Date" 
                                                    name="domestic_ticket_return_date" 
                                                    value="<?= $pre_depature->domestic_ticket_return_date ? date('d M Y', strtotime($pre_depature->domestic_ticket_return_date)) : '' ?>">
                                                <?php if($show_transportation) { ?>
                                                <a href="javascript:;" 
                                                onclick="emptyValue(this)" 
                                                class="btn btn-secondary" 
                                                style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php if($is_admin) { ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Travel Agent</label>
                                                <select name="travel_agent" class="form_control select2">
                                                    <option value="">-- Select --</option>
                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                        $selected = '';
                                                        if ($pre_depature->travel_agent_id == $travel_agent->id) {
                                                            $selected = 'selected="selected"';
                                                        }?>
                                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if($pre_depature->eticket != '' || $show_transportation) { ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label id="label_eticket_pdo_0">E-Ticket</label>
                                                <input id="eticket_pdo_0" type="file" class="form-control <?= $show_transportation ? '' : 'hide' ?>" name="eticket">
                                                <?php if ($pre_depature->eticket != '') { ?>
                                                    <br>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                        <a href="<?=base_url() ?><?=$pre_depature->eticket ?>" class="lightbox" aria-haspopup="dialog">
                                                            <img id="preview_image_profile" data-old="<?php echo site_url($pre_depature->eticket); ?>" src="<?php echo get_preview($pre_depature->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                        </a>
                                                        <a href="<?=base_url() ?><?=$pre_depature->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($pre_depature->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
                                                            <i class="fa fa-download fa-fw"></i>
                                                        </a>
                                                        <a 
                                                            href="<?=base_url($url_delete.$pre_depature->id.'/eticket') ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer" 
                                                            class="<?= $show_transportation ? '' : 'hide'  ?>">
                                                            <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php if(has_permission('nominee', 'accomodation_pdo') || !$is_admin) { ?>
                                <div class="col-lg-12 section-accomodation-pdo-0">
                                    <div class="row">
                                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i>Accommodation</p>
                                        <?php 
                                            $disable_accomodation = '';
                                            $show_accomodation = true;
                                            $style_accomodation = '#fff';
                                            $complete_accomodation = false;
                                            if($pre_depature->accomodation_check_in_date && $pre_depature->accomodation_check_out_date && $pre_depature->voucher_hotel){
                                                $complete_accomodation = true;
                                            }

                                            if($pre_depature->show_accomodation == 'Yes'){
                                                $disable_accomodation = 'disabled';
                                                $style_accomodation = '#eee';
                                                $show_accomodation = false;
                                            }else if($is_admin || $pre_depature->show_accomodation == 'Reimbursement'){
                                                if(!$pre_depature->grantee_submit && $complete_accomodation){
                                                    $disable_accomodation = 'disabled';
                                                    $style_accomodation = '#eee';
                                                    $show_accomodation = false;
                                                }
                                            }
                                        ?>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Check in Date</label>
                                                <input type="text" <?= $disable_accomodation ?> style="background-color:<?= $style_accomodation ?>" class="form-control datepicker" placeholder="Check in Date" value="<?= $pre_depature->accomodation_check_in_date ? date('d M Y', strtotime($pre_depature->accomodation_check_in_date)) : '' ?>">
                                                <?php if($show_accomodation) { ?>
                                                <a href="javascript:;" 
                                                onclick="emptyValue(this)" 
                                                class="btn btn-secondary" 
                                                style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Check out Date</label>
                                                <input type="text" <?= $disable_accomodation ?> style="background-color:<?= $style_accomodation ?>" class="form-control datepicker" placeholder="Check out Date" value="<?= $pre_depature->accomodation_check_out_date ? date('d M Y', strtotime($pre_depature->accomodation_check_out_date)) : '' ?>">
                                                <?php if($show_accomodation) { ?>
                                                <a href="javascript:;" 
                                                onclick="emptyValue(this)" 
                                                class="btn btn-secondary" 
                                                style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php if($pre_depature->voucher_hotel != '' || $show_accomodation) { ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label id="label_voucher_hotel_pdo_0">Hotel Voucher</label>
                                                <input id="voucher_hotel_pdo_0" type="file" class="form-control <?= $show_accomodation ? '' : 'hide' ?>" name="voucher_hotel">
                                                <?php if ($pre_depature->voucher_hotel != '') { ?>
                                                    <br>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                        <a href="<?=base_url() ?><?=$pre_depature->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                                                            <img id="preview_image_profile" data-old="<?php echo site_url($pre_depature->voucher_hotel); ?>" src="<?php echo get_preview($pre_depature->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                        </a>
                                                        <a href="<?=base_url() ?><?=$pre_depature->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($show_transportation) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
                                                            <i class="fa fa-download fa-fw"></i>
                                                        </a>
                                                        <a href="<?=base_url($url_delete.$pre_depature->id.'/voucher_hotel') ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer" class="<?= $is_admin || $pre_depature->show_accomodation == 'Reimbursement' ? '' : 'hide' ?>">
                                                            <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php if($show_transportation || $show_accomodation) { ?>
                                    <div class="col-md-12 my-5">
                                        <button type="submit" name="btn" value="edit" class="btn btn-success pull-right">Save</button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>












