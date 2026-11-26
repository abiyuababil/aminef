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
            <div class="col-lg-12 mb-5">
                
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
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Participant</label><br>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                            <a href="<?= base_url($pdo_participant)?>" class="lightbox"><img width="100" src="<?php echo get_preview($pdo_participant); ?>"></a>
                            <a href="<?= base_url($pdo_participant) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0px; right:-28px;">
                                <i class="fa fa-download fa-fw text-white"></i>
                            </a>
                            </div>
                        </div>
                    </div>
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
                    
                    <?php if($pdo_material_files) { ?>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>PDO Materials from Speakers Files</label>
                                <ul style="margin-left: -25px;">
                                    <?php foreach($pdo_material_files as $file) { ?>
                                    <li>
                                        <a href="<?= base_url($file->file) ?>" class="lightbox"><?= $file->file_name ?></a> 
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</form>












