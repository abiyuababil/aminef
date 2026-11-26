<style>
    .TriSea-technologies-Switch > input[type="checkbox"] {
            display: none;   
        }

        .TriSea-technologies-Switch > label {
            cursor: pointer;
            height: 0px;
            position: relative; 
            width: 40px;  
        }

        .TriSea-technologies-Switch > label::before {
            background: rgb(0, 0, 0);
            box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            content: '';
            height: 16px;
            margin-top: -8px;
            position:absolute;
            opacity: 0.3;
            transition: all 0.4s ease-in-out;
            width: 40px;
        }
        .TriSea-technologies-Switch > label::after {
            background: rgb(255, 255, 255);
            border-radius: 16px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            content: '';
            height: 24px;
            left: -4px;
            margin-top: -8px;
            position: absolute;
            top: -4px;
            transition: all 0.3s ease-in-out;
            width: 24px;
        }
        .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
            background: inherit;
            opacity: 0.5;
        }
        .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
            background: inherit;
            left: 20px;
        }
</style>
<?php if($is_admin) { ?>
<?php if(!$is_alumni_page) { ?>
<div class="row">
    <div class="col-lg-12">
        <h1><?php echo $title ?>
        <h3 class="page-header"><?=$grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php } ?>
<?php } ?>
<form method="POST" enctype="multipart/form-data">
    <div class="row warp-alumni-page">
        <div class="panel-body" <?= $is_admin ? 'style="margin-top:-30px"' : '' ?>>
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> GRANTEE INFORMATION</p>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" disabled="disabled" class="form-control" name="bank_name" value="<?= get_full_name($grantee_grant) ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Grant</label>
                    <input type="text" disabled="disabled" class="form-control" name="bank_address" value="<?= $grantee_grant->grant_name ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Period</label>
                    <input type="text" disabled="disabled" class="form-control" name="beneficiary_name" value="<?= $grantee_grant->fiscal_year_period ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" disabled="disabled" class="form-control" name="account_number" value="<?= $grantee_grant->primary_email ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" disabled="disabled" class="form-control" name="routing_number" value="<?= $grantee_grant->phone_number ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>KTP</label>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?php echo site_url($grantee_grant->img_passport); ?>" class="lightbox" aria-haspopup="dialog">
                            <img id="preview_image_passport_id" data-old="<?php echo site_url($grantee_grant->img_passport); ?>" src="<?php echo get_preview($grantee_grant->img_passport); ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="<?php echo base_url($grantee_grant->img_passport) ?>" id="button_download_img_passport_id" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($this->Grantee_ent_model->img_passport_id) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php if($this->session->userdata('role') != 'travel-booking-assistant' || !$is_admin) { ?>
        <div class="panel-body" style="margin-top:-30px">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Pre Departure Orientation</p>
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
            <!-- <div class="col-lg-4">
                <div class="form-group">
                    <label>Date</label>
                    <?php $pdo_date = $pre_depature_global->date != '' ? $pre_depature_global->date : ($pre_depature_period->date != '' ? $pre_depature_period->date : $pre_depature->date) ?>
                    <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" name="date" value="<?= $pdo_date ? date('d M Y', strtotime($pdo_date)) : '' ?>">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label>Location</label>
                    <?php $pdo_location = $pre_depature_global->location != '' ? $pre_depature_global->location : ($pre_depature_period->location != '' ? $pre_depature_period->location : $pre_depature->location) ?>
                    <input type="text" disabled class="form-control" name="location" placeholder="Location" value="<?= $pdo_location ?>">
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Panelist</label>
                    <select class="form-control select2" disabled name="panellist_id[]" multiple='multiple' style="width:100%">
                        <?php foreach ($panellists as $panellist) { ?>
                            <?php 
                                $pdo_panellist = $pre_depature_global->panellist_id != '' ? $pre_depature_global->panellist_id : ($pre_depature_period->panellist_id != '' ? $pre_depature_period->panellist_id : $pre_depature->panellist_id);
                                $select = in_array($panellist->id, explode(",", $pdo_panellist))  ? 'selected' : '';
                            ?>
                            <option value="<?php echo $panellist->id; ?>" <?= $select ?>><?php echo $panellist->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label>PDO Format</label>
                    <?php $pdo_format = $pre_depature_global->pdo_format != '' ? $pre_depature_global->pdo_format : ($pre_depature_period->pdo_format != '' ? $pre_depature_period->pdo_format : $pre_depature->pdo_format) ?>
                    <select class="form-control" disabled name="pdo_format">
                        <option value="online" <?php echo $pdo_format == 'online' ? 'selected' : ''; ?>>Online</option>
                        <option value="offline" <?php echo $pdo_format == 'offline' ? 'selected' : ''; ?>>Offline</option>
                    </select>
                </div>
            </div> -->

            <!-- <div class="col-lg-4">
                <div class="form-group">
                    <label>Note</label>
                    <textarea name="note" cols="10" rows="3" class="form-control" width="100%" placeholder="Note"><?= $pre_depature->note ?></textarea>
                </div>
            </div> -->
        </div>
        <!-- online -->
        <div class="panel-body">
        </div>
        <div class="panel-body">
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Start Date <?= $pdo_format == 'hybrid' ? 'Online' : ''; ?></label>
                    <?php $pdo_date = $pre_depature_global->date != '' ? $pre_depature_global->date : ($pre_depature_period->date != '' ? $pre_depature_period->date : $pre_depature->date) ?>
                    <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" name="date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>End Date <?= $pdo_format == 'hybrid' ? 'Online' : ''; ?></label>
                    <?php $pdo_date = $pre_depature_global->end_date != '' ? $pre_depature_global->end_date : ($pre_depature_period->end_date != '' ? $pre_depature_period->end_date : $pre_depature->end_date) ?>
                    <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" name="date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                </div>
            </div>

            <div class="col-lg-8">
                <div class="form-group">
                    <label>Location Online</label>
                    <?php $pdo_location_online = $pre_depature_global->location != '' ? $pre_depature_global->location : ($pre_depature_period->location != '' ? $pre_depature_period->location : $pre_depature->location) ?>
                    <textarea class="form-control editor_grantee" name="location"><?= $pdo_location_online ?></textarea>
                </div>
            </div>
        </div>

        <!-- offline -->
        <div class="panel-body">
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Start Date Offline</label>
                    <?php $pdo_date = $pre_depature_global->date_offline != '' ? $pre_depature_global->date_offline : ($pre_depature_period->date_offline != '' ? $pre_depature_period->date_offline : $pre_depature->date_offline) ?>
                    <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" name="date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>End Date Offline</label>
                    <?php $pdo_date = $pre_depature_global->end_date_offline != '' ? $pre_depature_global->end_date_offline : ($pre_depature_period->date_offline != '' ? $pre_depature_period->date_offline : $pre_depature->date_offline) ?>
                    <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" name="date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                </div>
            </div>

            <div class="col-lg-8">
                <div class="form-group">
                    <label>Location Offline</label>
                    <?php $pdo_location_offline = $pre_depature_global->location_offline != '' ? $pre_depature_global->location_offline : ($pre_depature_period->location_offline != '' ? $pre_depature_period->location_offline : $pre_depature->location_offline) ?>
                    <textarea class="form-control editor_grantee" name="location"><?= $pdo_location_offline ?></textarea>
                </div>
            </div>
        </div>

        <div class="panel-body" style="margin-top:-30px">
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Agenda</label><br>
                    <!-- <input type="file" class="form-control" name="agenda"> -->
                    <?php $pdo_agenda = $pre_depature_global->agenda != '' ? $pre_depature_global->agenda : ($pre_depature_period->agenda != '' ? $pre_depature_period->agenda : $pre_depature->agenda) ?>
                    <?php if($pdo_agenda != '') { ?>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                    <a href="<?= base_url($pdo_agenda)?>" class="lightbox"><img width="100" src="<?php echo get_preview($pdo_agenda); ?>"></a>
                    <a href="<?= base_url($pdo_agenda) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0px; right:-28px;">
                        <i class="fa fa-download fa-fw text-white"></i>
                    </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Participant</label><br>
                    <!-- <input type="file" class="form-control" name="participant"> -->
                    <?php $pdo_participant = $pre_depature_global->participant != '' ? $pre_depature_global->participant : ($pre_depature_period->participant != '' ? $pre_depature_period->participant : $pre_depature->participant) ?>
                    <?php if($pdo_participant != '') { ?>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                    <a href="<?= base_url($pdo_participant)?>" class="lightbox"><img width="100" src="<?php echo get_preview($pdo_participant); ?>"></a>
                    <a href="<?= base_url($pdo_participant) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0px; right:-28px;">
                        <i class="fa fa-download fa-fw text-white"></i>
                    </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Final Biosketch of Facilitator</label><br>
                    <!-- <input type="file" class="form-control" name="final_biosketch_of_speakers"> -->
                    <?php $pdo_final_biosketch_of_speakers = $pre_depature_global->final_biosketch_of_speakers != '' ? $pre_depature_global->final_biosketch_of_speakers : ($pre_depature_period->final_biosketch_of_speakers != '' ? $pre_depature_period->final_biosketch_of_speakers : $pre_depature->final_biosketch_of_speakers) ?>
                    <?php if($pdo_final_biosketch_of_speakers != '') { ?>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                    <a href="<?= base_url($pdo_final_biosketch_of_speakers)?>" class="lightbox"><img width="100" src="<?php echo get_preview($pdo_final_biosketch_of_speakers); ?>"></a>
                    <a href="<?= base_url($pdo_final_biosketch_of_speakers) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0px; right:-28px;">
                        <i class="fa fa-download fa-fw text-white"></i>
                    </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>PDO Materials from Speakers</label><br>
                        <?php if($pdo_material_files) { ?>
                            <ul style="margin-left: -25px;">
                                <?php foreach($pdo_material_files as $file) { ?>
                                <li>
                                    <a href="<?= base_url($file->file) ?>" class="lightbox"><?= $file->file_name ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    <?php // $pdo_materials = $pre_depature_global->pdo_materials != '' ? $pre_depature_global->pdo_materials : ($pre_depature_period->pdo_materials != '' ? $pre_depature_period->pdo_materials : $pre_depature->pdo_materials) ?>
                    <?php // if($pdo_materials != '') { ?>
                    <!-- <div style="margin-bottom:10px; position:relative; width:100px;">
                    <a href="<?= base_url($pdo_materials)?>" class="lightbox"><img width="100" src="<?php // echo get_preview($pdo_materials); ?>"></a>
                    <a href="<?= base_url($pdo_materials) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0px; right:-28px;">
                        <i class="fa fa-download fa-fw text-white"></i>
                    </a>
                    </div> -->
                    <?php // } ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if ($pre_depature->id) { ?>
            <input type="hidden" name="pre_depature_id" value="<?= $pre_depature->id ?>">
        <?php } ?>

        <?php if($pre_depature->show_transportation) { ?>
        <div class="panel-body" style="margin-top:-30px">
            <?php if($this->session->userdata('role') == 'travel-booking-assistant' || !$is_admin) { ?>
                <input id="show_transportation" onchange="show_hide_transportation(this, 'pdo', 0)" class="select_show hidden" value="<?= $pre_depature->show_transportation ?>">
                <input id="show_accomodation" onchange="show_hide_accomodation(this, 'pdo', 0)" class="select_show hidden" value="<?= $pre_depature->show_accomodation ?>">
            <?php } ?>
            <?php if(has_permission('nominee', 'pre_departure_orientation')) { ?>
            <div class="panel-body" style="margin-bottom:20px;">
                <label>Show Transportation</label>
                <select class="form-control select_show" name="show_transportation" id="show_transportation" onchange="show_hide_transportation(this, 'pdo', 0)">
                    <option value="">- Select -</option>
                    <option <?= $pre_depature->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                    <option <?= $pre_depature->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                    <option <?= $pre_depature->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                </select>
                <label class="mt-3">Show Accommodation</label>
                <select class="form-control select_show" name="show_accomodation" id="show_accomodation" onchange="show_hide_accomodation(this, 'pdo', 0)">
                    <option value="">- Select -</option>
                    <option <?= $pre_depature->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                    <option <?= $pre_depature->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                    <option <?= $pre_depature->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                </select>
            </div>
            <?php } ?>
            <?php if($is_admin) { ?>
            <?php if(!$is_alumni_page) { ?>
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="TriSea-technologies-Switch">
                        <span class="mr-2"> Enable Transportation Grantee</span>
                        <input id="grantee_submit" name="grantee_submit" type="checkbox" <?= $pre_depature->grantee_submit  ? 'checked' : '' ?>/>
                        <label for="grantee_submit" class="label-primary"></label>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php if(has_permission('nominee', 'domestic_ticket') || !$is_admin) { ?>
            <div class="col-lg-12 section-transportation-pdo-0">
                <div class="row">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i>Transportation</p>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure City</label>
                            <input type="text" <?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '' : 'disabled' ?> style="background-color:<?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '#fff' : '#eeee' ?>" class="form-control" placeholder="City" name="domestic_ticket_city" value="<?= $pre_depature->domestic_ticket_city ? $pre_depature->domestic_ticket_city : '' ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Destination City</label>
                            <input type="text" <?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '' : 'disabled' ?> style="background-color:<?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '#fff' : '#eeee' ?>" class="form-control" placeholder="City" name="destination_city" value="<?= $pre_depature->destination_city ? $pre_depature->destination_city : '' ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure Date</label>
                            <input type="text" <?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '' : 'disabled' ?> readonly style="background-color:<?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '#fff' : '#eeee' ?>" class="form-control datepicker" placeholder="Departure Date" name="domestic_ticket_departure_date" value="<?= $pre_depature->domestic_ticket_departure_date ? date('d M Y', strtotime($pre_depature->domestic_ticket_departure_date)) : '' ?>">
                            <a href="javascript:;" 
                            onclick="emptyValue(this)" 
                            class="btn btn-secondary" 
                            style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Returning Date</label>
                            <input type="text" <?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '' : 'disabled' ?> readonly style="background-color:<?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '#fff' : '#eeee' ?>" class="form-control datepicker" placeholder="Return Date" name="domestic_ticket_return_date" value="<?= $pre_depature->domestic_ticket_return_date ? date('d M Y', strtotime($pre_depature->domestic_ticket_return_date)) : '' ?>">
                            <a href="javascript:;" 
                            onclick="emptyValue(this)" 
                            class="btn btn-secondary" 
                            style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <?php if($is_admin) { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Travel Agent</label>
                            <select name="travel_agent" class="form-control <?= $is_alumni_page ? '' : 'select2' ?>">
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
                    <?php if($pre_depature->show_transportation == 'Reimbursement' || $is_admin || $pre_depature->eticket != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_eticket_pdo_0">E-Ticket</label>
                            <input id="eticket_pdo_0" type="file" class="form-control <?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '' : 'hide' ?>" name="eticket">
                            <?php if ($pre_depature->eticket != '') { ?>
                                <br>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?=base_url() ?><?=$pre_depature->eticket ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url($pre_depature->eticket); ?>" src="<?php echo get_preview($pre_depature->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?=$pre_depature->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($pre_depature->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                    <a href="<?=base_url($url_delete.$pre_depature->id.'/eticket') ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer" class="<?= $is_admin || $pre_depature->show_transportation == 'Reimbursement' ? '' : 'hide' ?>">
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
            
            <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
            <div class="panel-body">
                <div class="col-lg-4">
                    <div class="form-group ">
                        <label>Status</label>
                        <select name="status_tba" class="form-control">
                            <option <?= $grantee_grant->status_tba_pdo == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                            <option <?= $grantee_grant->status_tba_pdo == 'done' ? 'selected' : '' ?> value="done">Done</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if(has_permission('nominee', 'accomodation_pdo') || !$is_admin) { ?>
            <div class="col-lg-12 section-accomodation-pdo-0">
                <div class="row">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i>Accommodation</p>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Check in Date</label>
                            <input type="text" <?= $is_admin || $pre_depature->show_accomodation == 'Reimbursement' ? '' : 'disabled' ?> readonly style="background-color:<?= $is_admin || $pre_depature->show_accomodation == 'Reimbursement' ? '#fff' : '#eeee' ?>" class="form-control datepicker" placeholder="Check in Date" name="accomodation_check_in_date" value="<?= $pre_depature->accomodation_check_in_date ? date('d M Y', strtotime($pre_depature->accomodation_check_in_date)) : '' ?>">
                            <a href="javascript:;" 
                            onclick="emptyValue(this)" 
                            class="btn btn-secondary" 
                            style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Check out Date</label>
                            <input type="text" <?= $is_admin || $pre_depature->show_accomodation == 'Reimbursement' ? '' : 'disabled' ?> readonly style="background-color:<?= $is_admin || $pre_depature->show_accomodation == 'Reimbursement' ? '#fff' : '#eeee' ?>" class="form-control datepicker" placeholder="Check out Date" name="accomodation_check_out_date" value="<?= $pre_depature->accomodation_check_out_date ? date('d M Y', strtotime($pre_depature->accomodation_check_out_date)) : '' ?>">
                            <a href="javascript:;" 
                            onclick="emptyValue(this)" 
                            class="btn btn-secondary" 
                            style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <?php if($pre_depature->show_accomodation == 'Reimbursement' || $is_admin || $pre_depature->voucher_hotel != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_voucher_hotel_pdo_0">Hotel Voucher</label>
                            <input id="voucher_hotel_pdo_0" type="file" class="form-control <?= $is_admin || $pre_depature->show_accomodation == 'Reimbursement' ? '' : 'hide' ?>" name="voucher_hotel">
                            <?php if ($pre_depature->voucher_hotel != '') { ?>
                                <br>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?=base_url() ?><?=$pre_depature->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url($pre_depature->voucher_hotel); ?>" src="<?php echo get_preview($pre_depature->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?=$pre_depature->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($pre_depature->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
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

            <?php //if(has_permission('nominee', 'meal_allowance_pdo')) { ?>
            <!-- <div class="col-lg-12">
                <div class="row">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i>Meals Allowance</p>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Amount of Allowance</label>
                            <input type="number" style="background-color:#fff" class="form-control" placeholder="Amount" name="amount_of_allowance" value="<?= isset($pre_depature->amount_of_allowance) ? $pre_depature->amount_of_allowance : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bank Holder</label>
                            <input type="text" class="form-control" name="amount_allowance_bank_holder" value="<?php echo isset($pre_depature->amount_allowance_bank_holder) ? $pre_depature->amount_allowance_bank_holder : ''; ?>" placeholder="Bank Holder">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Name of Bank</label>
                            <input type="text" class="form-control" name="amount_allowance_name_of_bank" value="<?php echo isset($pre_depature->amount_allowance_name_of_bank) ? $pre_depature->amount_allowance_name_of_bank : ''; ?>" placeholder="Name of Bank">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" class="form-control" name="amount_allowance_account_number" value="<?php echo isset($pre_depature->amount_allowance_account_number) ? $pre_depature->amount_allowance_account_number : ''; ?>" placeholder="Account Number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Branch / Address</label>
                            <input type="text" class="form-control" name="amount_allowance_branch_address" value="<?php echo isset($pre_depature->amount_allowance_branch_address) ? $pre_depature->amount_allowance_branch_address : ''; ?>" placeholder="Branch / Address">
                        </div>
                    </div>
                </div>
            </div> -->
            <?php //} ?>
            <?php if(!$is_admin && ($pre_depature->show_transportation == 'Reimbursement' || $pre_depature->show_accomodation == 'Reimbursement')) { ?>
                <div class="col-md-12 my-5">
                    <button type="submit" name="btn" value="edit" class="btn btn-success">Submit</button>
                </div>
            <?php } ?>
        </div>
        <?php } ?>
            
        <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
        <div class="panel-body">
            <div class="col-lg-4">
                <div class="form-group ">
                    <label>Status</label>
                    <select name="status_tba_accomodation" class="form-control">
                        <option <?= $grantee_grant->status_accomodation_tba_pdo == 'not_done' ? 'selected' : '' ?> value="not_done">Not Done</option>
                        <option <?= $grantee_grant->status_accomodation_tba_pdo == 'done' ? 'selected' : '' ?> value="done">Done</option>
                    </select>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <?php if($is_admin) { ?>
    <?php if(!$is_alumni_page) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body pull-right">
                <a href="<?= $back_url ?>" type="button" class="btn btn-default">Back </a>
                <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                    <button type="submit" name="btn" value="save_interview_payment" class="btn btn-success">Save</button>
                    <button type="submit" name="btn" value="save_send_tba_accomodation" class="btn btn-primary mr-1">Save & Send Accommodation</button>
                    <button type="submit" name="btn" value="save_send_tba" class="btn btn-primary mr-1">Save & Send Transportation</button>
                <?php } ?>
                <?php if($this->session->userdata('role') != 'travel-booking-assistant') { ?>
                    <button type="submit" name="btn" value="sent_to_tba" class="btn btn-primary mr-1">Send Email to TBA</button>
                    <?php if ($pre_depature != null) { ?>
                        <button type="submit" name="btn" value="edit" class="btn btn-success mr-1">Save</button>
                    <?php } else { ?>
                        <button type="Save" name="btn" value="submit" class="btn btn-success mr-1">Save</button>
                    <?php } ?>
                    <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-warning withdraw mr-1">Withdraw</a>
                    <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-danger drop mr-1">Drop</a>
                    <input type="hidden" id="data_section" value="pdo">
                <?php } ?>
            </div>
            <!-- <button type="button" id="btn-present" class="btn btn-primary" style="float:right;">Present </button>
            <button type="button" id="btn-decline" class="btn btn-danger" style="float:right;margin-right:5px;">Decline</button> -->
        </div>
    </div>
    <?php } ?>
    <?php } ?>
</form>


<div class="modal fade text-center" id="mdl_info_decline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to Decline?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('admin/pre_depature/decline/' . $grantee_grant->user_grantee_id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade text-center" id="mdl_info_present" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to Present?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('admin/pre_depature/present/' . $grantee_grant->user_grantee_id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('admin/partials/modal_confirm') ?>