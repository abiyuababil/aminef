<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$disable_form = !has_permission('nominee', 'test_preparation_section') ? 'disabled' : ''; 

$url_delete = base_url('admin/nominee/general_nominee/delete_file');
if($is_grantee){
    $url_delete = base_url('grantee/submission/delete_file_test');
}
?>

<style>
    .containt {
        margin: 0px auto 30px auto;
    }

    .progressbar {
        counter-reset: step;
        margin: 0px;
        padding: 0px;
    }

    .progressbar li {
        display: inline-block;
        list-style-type: none;
        width: 25%;
        /* float: left; */
        font-size: 12px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        color: #7d7d7d;
    }

    .progressbar li {
        width: 30px;
        height: 30px;
        line-height: 30px;
        background-color: #b5b5b5;
        /* display: block; */
        text-align: center;
        margin: auto 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .progressbar li a {
        color: white !important;
        text-decoration: none;
    }

    .progressbar li:after {
        width: 100%;
        height: 2px;
        content: '';
        position: absolute;
        background-color: #7d7d7d;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child:after {
        content: none;
    }

    .progressbar li.active {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.done {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.active+li:after {
        background-color: #55b776;
    }

    .btn_step {
        width: 150px;
    }

    .next {
        float: right;
    }

    #table-report td {
        height: 80px;
        vertical-align: top;
        padding: 10px;
        font-weight: bold;
    }

    #table-report tr {
        margin-top: 20px;
    }

    .invalid-tooltip {
        position: absolute;
        top: auto;
        z-index: 5;
        display: none;
        max-width: 100%;
        padding: 0.5rem;
        margin-top: 0.1rem;
        font-size: 12px;
        line-height: 1;
        color: #fff;
        background-color: rgba(220, 53, 69, .8);
        border-radius: 0.2rem;
    }

    #delete-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }

    #success-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }
    
    .selected-preparation-n {
        display:none;
    }
    
    .selected-preparation-b {
        display:block;
    }

    .d-none-testing {
        display: none !important;
    }
    .tab-content > .active {
    display: block !important;
    }
</style>
<div class="row <?= $is_grantee || $is_alumni_page ? 'd-none' : '' ?>">
    <div class="col-lg-12">
        <h1><?=$title ?></h1>
        <h3 class="page-header"><?=$grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '' && !$is_grantee) { ?>
    <div class="alert alert-success alert-dismissable mt-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable mt-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>
<div class="alert alert-success mt-3" id="success-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Delete <strong>Success! </strong>
</div>
<div class="alert alert-danger mt-3" id="delete-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Delete <strong>Failed! </strong>
</div>

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="section" value="test_preparation">
    <div class="row warp-alumni-page">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <?php if ($data_preparation->reason_decline != '') { ?>
                    <div class="panel-body">
                        <div class="alert alert-danger mt-3">
                            <b>Decline with Reason</b> : <br /> <?= $data_preparation->reason_decline ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="panel-body">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Test Preparation Section</p>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label>Test Date</label>
                        </div>
                        <div class="col-lg-6">
                            <?php
                                $display_preparation = $display_preparation_format = 'style="display:none"'; 
                                $display_preparation_tab = 'style="display:none"'; 
                                if($data_preparation) :
                                    if($data_preparation->status == 'selected')
                                    $display_preparation = 'style="display:block"'; 

                                    if($data_preparation->preparation_section != '')
                                    $display_preparation_tab = 'style="display:block"'; 

                            ?>
                                <input type="hidden" value="<?= $data_preparation->id ?>" name="preparation_id">
                            <?php endif;?>

                            <?php 
                                if($data_preparation){
                                    if($data_preparation->format_preparation == 'In-Person')
                                    $display_preparation_format = 'style="display:block"'; 
                                } 
                            ?>
                            <input <?= $disable_form ?> type="text" name="preparation[test_date]" class="form-control datepicker" readonly style="<?= has_permission('nominee', 'test_preparation_section') ? 'background-color:#fff;' : ''?>" value="<?= $data_preparation->test_date ? date('d M Y', strtotime($data_preparation->test_date)) : '' ?>">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary <?= $is_admin ? '' : 'hide' ?>" style="color:#000;position:absolute;top:0px;right:20px;">X</a>
                        </div>
                    </div>
                    <!-- <div class="row form-group">
                        <div class="col-lg-2">
                            <label>Test Time</label>
                        </div>
                        <div class="col-lg-6">
                            <input <?= $disabled_form ?> type="time" class="form-control input_time" name="preparation[time]" value="<?= $data_preparation  ? ($data_preparation->test_date != '' ? date('H:i', strtotime($data_preparation->test_date)) : '') : '' ?>" placeholder="Time">
                        </div>
                    </div> -->
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label>Reading Score</label>
                        </div>
                        <div class="col-lg-6">
                            <input <?= $disable_form ?> type="text" name="preparation[score]" class="form-control" value="<?= $data_preparation->score ? $data_preparation->score : '' ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label>Listening Score</label>
                        </div>
                        <div class="col-lg-6">
                            <input <?= $disable_form ?> type="text" name="preparation[listening_score]" class="form-control" value="<?= $data_preparation->listening_score ? $data_preparation->listening_score : '' ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label>Total Score</label>
                        </div>
                        <div class="col-lg-6">
                            <input <?= $disable_form ?> type="text" class="form-control" value="<?= $data_preparation->score + $data_preparation->listening_score ?>" disabled>
                        </div>
                    </div>
                    <?php if($is_admin) { ?>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label>Cost</label>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-group">
                                <div class="input-group-addon">USD</div>
                                <input <?= $disable_form ?> style="z-index: 0" type="text" name="preparation[cost]" class="form-control currency-usd" value="<?= $data_preparation->cost ? $data_preparation->cost : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-group">
                                <div class="input-group-addon">IDR</div>
                                <input <?= $disable_form ?> style="z-index: 0" type="text" name="preparation[cost_idr]" class="form-control currency-idr" value="<?= $data_preparation->cost_idr ? $data_preparation->cost_idr : '' ?>">
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row form-group">
                        <div class="col-lg-2">
                            <label style="margin-right:20px">Status </label><br />
                        </div>
                        <div class="col-lg-6">
                            <div class="radio d-inline mr-4">
                                <label>
                                    <input type="radio" 
                                            class="status_preparation radio-nominee"
                                            <?= $disable_form ?>
                                            <?= $data_preparation->status == 'selected' ? 'checked' : '' ?>
                                            name="preparation[status_preparation]" 
                                            style="margin-top:1px" 
                                            value="selected">
                                            Selected 
                                </label>
                            </div>
                            <div class="radio d-inline">
                                <label>
                                    <input type="radio" 
                                            class="status_preparation radio-nominee"
                                            <?= $disable_form ?>
                                            <?= $data_preparation->status == 'not_selected' ? 'checked' : '' ?>
                                            name="preparation[status_preparation]" 
                                            style="margin-top:1px" 
                                            value="not_selected">
                                            Not Selected 
                                </label>
                            </div>
                        </div>
                    </div> 
                    <div class="row form-group selected-preparation-section" <?= $display_preparation ?>>
                        <div class="col-lg-2">
                            <label style="margin-right:20px">Format </label><br />
                        </div>
                        <div class="col-lg-6">
                            <div class="radio d-inline mr-5">
                                <label>
                                    <input type="radio" 
                                            class="format_preparation radio-nominee"
                                            <?= $disable_form ?>
                                            <?= $data_preparation->format_preparation == 'Online' ? 'checked' : '' ?>
                                            name="preparation[format_preparation]" 
                                            style="margin-top:1px" 
                                            value="Online">
                                            Online 
                                </label>
                            </div>
                            <div class="radio d-inline">
                                <label>
                                    <input type="radio" 
                                            class="format_preparation radio-nominee"
                                            <?= $disable_form ?>
                                            <?= $data_preparation->format_preparation == 'In-Person' ? 'checked' : '' ?>
                                            name="preparation[format_preparation]" 
                                            style="margin-top:1px" 
                                            value="In-Person">
                                            In-Person 
                                </label>
                            </div>
                        </div>
                    </div> 
                    <div class="row form-group selected-preparation-section" <?= $display_preparation ?>>
                        <div class="col-lg-2">
                            <label>Preparation Section</label>
                        </div>
                        <div class="col-lg-6">
                            <select <?= $disable_form ?> name="preparation[preparation_section]" id="preparation_section" class="form-control">
                                <option value="">-- Select Preparation Section --</option>
                                <option <?= $data_preparation->preparation_section == 'toefl' ? 'selected' : '' ?> value="toefl">TOEFL Preparation Program Section</option>
                                <option <?= $data_preparation->preparation_section == 'gre' ? 'selected' : '' ?> value="gre">GRE Preparation Program Section</option>
                                <option <?= $data_preparation->preparation_section == 'toefl_gre' ? 'selected' : '' ?> value="toefl_gre">TOEFL & GRE Preparation Program Section</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="row form-group selected-preparation" <?= $display_preparation ?>>
                        <div class="col-lg-2">
                            <label>Employer Approval</label>
                        </div>
                        <div class="col-lg-6">
                            <input <?= $disable_form ?> type="file" name="employer_approval" class="form-control active-grantee">
                            <small>File Size Max 5MB </small>
                            <button type="submit" id="btn-submit" class="btn btn-primary btn-submit button-for-grantee" name="btn-submit" value="save" style='color:#fff;position:absolute; top:0; right:15px;display:none;'>Upload</button>
                            <?php if($data_preparation->employer_approval) : ?>
                                <br />
                                <a href="<?= base_url($data_preparation->employer_approval) ?>" class="btn btn-success lightbox" >View</a>
                                <?php if(!$is_grantee && has_permission('nominee', 'test_preparation_section')) { ?>
                                <a href=<?= base_url('admin/nominee/general_nominee/delete_file/test_preparation/'.$grantee_grant->id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
                                <?php } ?>
                            <?php endif; ?>
                        </div>
                    </div> -->
                </div>
                
                <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                    <input id="show_transportation_0" onchange="show_hide_transportation(this, 'preparation', 0)" class="select_show hide" value="<?= $data_preparation->show_transportation ?>">
                    <input id="show_accomodation_0" onchange="show_hide_accomodation(this, 'preparation', 0)" class="select_show hide" value="<?= $data_preparation->show_accomodation ?>">
                <?php } ?>
                <?php if(has_permission('nominee', 'test_preparation_section') && $data_preparation->show_transportation) { ?>
                <div class="panel-body">
                    <label>Show Transportation</label>
                    <select class="form-control select_show" name="preparation[show_transportation]" id="show_transportation_0" onchange="show_hide_transportation(this, 'preparation', 0)">
                        <option value="">- Select -</option>
                        <option <?= $data_preparation->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                        <option <?= $data_preparation->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                        <option <?= $data_preparation->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                    </select>
                    <label class="mt-3">Show Accommodation</label>
                    <select class="form-control select_show" name="preparation[show_accomodation]" id="show_accomodation_0" onchange="show_hide_accomodation(this, 'preparation', 0)">
                        <option value="">- Select -</option>
                        <option <?= $data_preparation->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                        <option <?= $data_preparation->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                        <option <?= $data_preparation->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                    </select>
                </div>
                <?php } ?>

                <!-- transportation -->
                <?php if((has_permission('nominee', 'transportation_test_preparation') || $is_grantee) && $data_preparation->show_transportation) { ?>
                <div class="panel-body selected-preparation-format section-transportation-preparation-0" <?= $display_preparation_format ?>>
                    <div class="col-lg-12">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                    </div>
                    <div class="panel-body">
                        <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                            <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure City</label>
                            <input id="origin_city_0" type="text" class="form-control <?= $data_preparation->show_transportation == 'Reimbursement' ? 'form-control-grantee' : '' ?>" placeholder="Departure City" name="preparation[origin_city]" value="<?= $data_preparation->origin_city ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Destination City</label>
                            <input id="destination_city_0" type="text" class="form-control  <?= $data_preparation->show_transportation == 'Reimbursement' ? 'form-control-grantee' : '' ?>" placeholder="Destination City" name="preparation[destination_city]" value="<?= $data_preparation->destination_city ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure Date</label>
                            <input id="departure_date_0" type="text" class="form-control  <?= $data_preparation->show_transportation == 'Reimbursement' ? 'form-control-grantee' : '' ?> datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="preparation[departure_date]" value="<?= !empty($data_preparation->departure_date) ? date('d M Y', strtotime($data_preparation->departure_date)) : '' ?>">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Returning Date</label>
                            <input id="returning_date_0" type="text" class="form-control  <?= $data_preparation->show_transportation == 'Reimbursement' ? 'form-control-grantee' : '' ?> datepicker" readonly style="background-color:#fff" placeholder="Returning Date" name="preparation[returning_date]" value="<?= !empty($data_preparation->returning_date) ? date('d M Y', strtotime($data_preparation->returning_date)) : '' ?>">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <?php if($data_preparation->show_transportation == 'Reimbursement' || $is_admin || $data_preparation->eticket != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_eticket_preparation_0">E-Ticket</label>
                            <?php if($is_admin || $data_preparation->show_transportation == 'Reimbursement') { ?>
                            <input id="eticket" type="file" class="form-control  <?= $data_preparation->show_transportation == 'Reimbursement' ? 'form-control-grantee' : '' ?>" name="eticket">
                            <?php } ?>
                            <?php if ($data_preparation->eticket != '') { ?>
                                <br />
                                <div style="margin-bottom:10px; position:relative; width:100px; display:inline;">
                                    <a href="<?=base_url() ?><?= $data_preparation->eticket ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url( $data_preparation->eticket); ?>" src="<?php echo get_preview( $data_preparation->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?= $data_preparation->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $data_preparation->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-70px; right:-28px;color:#fff;">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                    <?php if($data_preparation->show_transportation == 'Reimbursement' || $is_admin) { ?>
                                    <a 
                                        href="<?= $url_delete.'/eticket_test_preparation/'.$grantee_grant->id ?>" 
                                        style="position:absolute; top:-15px; right:-28px;cursor:pointer">
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
                <!-- Accommodation -->
                <?php if((has_permission('nominee', 'accomodation_test_preparation') || $is_grantee) && $data_preparation->show_accomodation) { ?>
                <div class="panel-body selected-preparation-format section-accomodation-preparation-0" <?= $display_preparation_format ?>>
                    <div class="col-lg-12">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Check In Date</label>
                            <input id="checkin_date_0" type="text" class="form-control <?= $data_preparation->show_accomodation == 'Reimbursement' ? 'form-control-grantee' : '' ?> datepicker" readonly style="background-color:#fff" placeholder="Check In Date" name="preparation[checkin_date]" value="<?= !empty($data_preparation->checkin_date) ? date('d M Y', strtotime($data_preparation->checkin_date)) : '' ?>">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Check Out Date</label>
                            <input id="checkout_date_0" type="text" class="form-control <?= $data_preparation->show_accomodation == 'Reimbursement' ? 'form-control-grantee' : '' ?> datepicker" readonly style="background-color:#fff" placeholder="heck Out Date" name="preparation[checkout_date]" value="<?= !empty($data_preparation->checkout_date) ? date('d M Y', strtotime($data_preparation->checkout_date)) : '' ?>">
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <?php if($data_preparation->show_accomodation == 'Reimbursement' || $is_admin || $data_preparation->voucher_hotel != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_voucher_hotel_preparation_0">Hotel Voucher</label>
                            <?php if($is_admin || $data_preparation->show_accomodation == 'Reimbursement') { ?>
                            <input id="voucher_hotel" type="file" class="form-control <?= $data_preparation->show_accomodation == 'Reimbursement' ? 'form-control-grantee' : '' ?>" name="voucher_hotel">
                            <?php } ?>
                            <?php if ($data_preparation->voucher_hotel != '') { ?>
                                <br />
                                <div style="margin-bottom:10px; position:relative; width:100px;; display:inline;">
                                    <a href="<?=base_url() ?><?= $data_preparation->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url( $data_preparation->voucher_hotel); ?>" src="<?php echo get_preview( $data_preparation->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?= $data_preparation->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $data_preparation->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-70px; right:-28px;color:#fff;">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                </div>
                                <?php if($data_preparation->show_accomodation == 'Reimbursement' || $is_admin) { ?>
                                <a href="<?= $url_delete.'/voucher_test_preparation/'.$grantee_grant->id ?>" style="position:absolute; top:100px;cursor:pointer">
                                    <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                                </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>

                <!-- if selected -->
                <div class="panel-body selected-preparation" <?= $display_preparation_tab ?>>
                    <div class="row">
                        <!-- <div class="col-lg-12" style="display:<?= $data_preparation->preparation_section == 'toefl' ? 'block' : 'none' ?>" id="tab-toefl-preparation">
                        <div class="tabs">
                            <ul>
                                <li>
                                    <a aria-expanded="true" data-toggle="tab" href="#toeft" aria-expanded="true">Toefl Preparation Program Section</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="col col-lg-12">
                                    <div class="tab-content">
                                        <div id="toeft" class="tab-pane fade active in">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Program Provider</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($data_toefl_preparation) : ?>
                                                            <input type="hidden" name="toefl_preparation_id" value="<?= $data_toefl_preparation->id ?>">
                                                            <?php endif;?>
                                                            <input type="text" class="form-control" name="toefl_preparation[program_provider]" value="<?= $data_toefl_preparation->program_provider ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Contact Person</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_preparation[contact_person]" value="<?= $data_toefl_preparation->contact_person ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Start Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff;" name="toefl_preparation[start_date]" value="<?= $data_toefl_preparation->start_date ? date('d M Y', strtotime($data_toefl_preparation->start_date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>End Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff;" name="toefl_preparation[end_date]" value="<?= $data_toefl_preparation->end_date ? date('d M Y', strtotime($data_toefl_preparation->end_date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Duration</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_preparation[duration]" value="<?= $data_toefl_preparation->duration ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Cost</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_preparation[cost]" value="<?= $data_toefl_preparation->cost ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Format</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $data_toefl_preparation->format == 'online' ? 'checked' : '' ?>
                                                                        name="toefl_preparation[format]" 
                                                                        value="online">
                                                                        Online
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $data_toefl_preparation->format == 'in-person' ? 'checked' : '' ?>
                                                                        name="toefl_preparation[format]" 
                                                                        value="in-person">
                                                                        In-Person 
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Meals Allowance</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_preparation[meals_allowance]" value="<?= $data_toefl_preparation->meals_allowance ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Airfare</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_preparation[airfare]" value="<?= $data_toefl_preparation->airfare ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Ground Transportation</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_preparation[ground_transportation]" value="<?= $data_toefl_preparation->ground_transportation ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Accommodation</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_preparation[accomodation]" value="<?= $data_toefl_preparation->accomodation ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Other Expenses</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_preparation[other_expenses]" value="<?= $data_toefl_preparation->other_expenses ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div> -->



                        <div class="col-lg-12">
                        <div class="tabs <?= $data_preparation->status == 'selected' ? '' : 'hide' ?>" id="tabs_preparation">
                            <ul>
                                <li id="li-toefl" class="<?= $data_preparation->preparation_section == 'toefl' ? 'ui-tabs-active ui-state-active' : '' ?>" >
                                    <a 
                                        aria-expanded="true" 
                                        data-toggle="tab" 
                                        href="#toeft" 
                                        aria-expanded="true" 
                                        class="<?= $data_preparation->preparation_section == 'gre' || $data_preparation->preparation_section == 'toefl_gre' ? 'hide ui-tabs-active ui-state-active' : '' ?>" 
                                        id="tab-toefl-preparation">TOEFL Preparation Program Section
                                    </a>
                                </li>
                                <li id="li-gre" class="<?= $data_preparation->preparation_section == 'gre' ? 'ui-tabs-active ui-state-active' : '' ?>" >
                                    <a 
                                        aria-expanded="true" 
                                        data-toggle="tab" 
                                        href="#gre" 
                                        aria-expanded="true" 
                                        class="<?= $data_preparation->preparation_section == 'toefl' || $data_preparation->preparation_section == 'toefl_gre' ? 'hide' : '' ?>" 
                                        id="tab-gre-preparation">GRE Preparation Program Section</a>
                                </li>
                                <li id="li-toefl-gre" class="<?= $data_preparation->preparation_section == 'toefl_gre' ? 'ui-tabs-active ui-state-active' : '' ?>" >
                                    <a 
                                        aria-expanded="true" 
                                        data-toggle="tab" 
                                        href="#toefl_gre" 
                                        aria-expanded="true" 
                                        class="<?= $data_preparation->preparation_section == 'toefl' || $data_preparation->preparation_section == 'gre' ? 'hide' : '' ?>" 
                                        id="tab-toefl-gre-preparation">TOEFL & GRE Preparation Program Section</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="col col-lg-12">
                                    <div class="tab-content">
                                        <div id="toeft" class="tab-pane fade <?= $data_preparation->preparation_section == 'toefl' ? 'active in' : '' ?>" style="display:<?= $data_preparation->preparation_section == 'toefl' ? 'block' : 'none' ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Program Provider</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($data_toefl_preparation) : ?>
                                                            <input type="hidden" name="toefl_preparation_id" value="<?= $data_toefl_preparation->id ?>">
                                                            <?php endif;?>
                                                            <input <?= $disable_form ?> type="text" class="form-control" name="toefl_preparation[program_provider]" value="<?= $data_toefl_preparation->program_provider ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Contact Person</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input <?= $disable_form ?> type="text" class="form-control" name="toefl_preparation[contact_person]" value="<?= $data_toefl_preparation->contact_person ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Start Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input <?= $disable_form ?> type="text" class="form-control datepicker" readonly style="<?= has_permission('nominee', 'test_preparation_section') ? 'background-color:#fff;' : ''?>" name="toefl_preparation[start_date]" value="<?= $data_toefl_preparation->start_date ? date('d M Y', strtotime($data_toefl_preparation->start_date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>End Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input <?= $disable_form ?> type="text" class="form-control datepicker" readonly style="<?= has_permission('nominee', 'test_preparation_section') ? 'background-color:#fff;' : ''?>" name="toefl_preparation[end_date]" value="<?= $data_toefl_preparation->end_date ? date('d M Y', strtotime($data_toefl_preparation->end_date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Duration</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input <?= $disable_form ?> type="text" class="form-control" name="toefl_preparation[duration]" value="<?= $data_toefl_preparation->duration ?>">
                                                        </div>
                                                    </div>
                                                    <?php if($is_admin) { ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Cost</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_preparation[cost]" value="<?= $data_toefl_preparation->cost ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_preparation[cost_idr]" value="<?= $data_toefl_preparation->cost_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Internet Allowance</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_preparation[meals_allowance]" value="<?= $data_toefl_preparation->meals_allowance ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_preparation[meals_allowance_idr]" value="<?= $data_toefl_preparation->meals_allowance_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($is_admin) { ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Airfare</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_preparation[airfare]" value="<?= $data_toefl_preparation->airfare ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_preparation[airfare_idr]" value="<?= $data_toefl_preparation->airfare_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Ground Transportation</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_preparation[ground_transportation]" value="<?= $data_toefl_preparation->ground_transportation ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_preparation[ground_transportation_idr]" value="<?= $data_toefl_preparation->ground_transportation_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Accommodation</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_preparation[accomodation]" value="<?= $data_toefl_preparation->accomodation ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_preparation[accomodation_idr]" value="<?= $data_toefl_preparation->accomodation_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Other Expenses</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_preparation[other_expenses]" value="<?= $data_toefl_preparation->other_expenses ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input <?= $disable_form ?> style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_preparation[other_expenses_idr]" value="<?= $data_toefl_preparation->other_expenses_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Agreement Form</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <input <?= $disable_form ?> id="toefl_tnc" type="file" class="form-control active-grantee" name="toefl_tnc">
                                                                <!-- <button type="submit" id="btn-submit" class="btn btn-primary btn-submit button-for-grantee" name="btn-submit" value="save" style='color:#fff;position:absolute; top:0; right:0;z-index:9;'>Upload</button> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <?php if($data_toefl_preparation->tnc) : ?>
                                                                    <a href="<?= base_url($data_toefl_preparation->tnc) ?>" class="btn btn-warning lightbox mr-2" style="color:#fff;">View</a>
                                                                    <?php if(!$is_grantee && has_permission('nominee', 'test_preparation_section')) { ?>
                                                                    <a href=<?= base_url('admin/nominee/general_nominee/delete_file/toefl_tnc/'.$grantee_grant->id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger mr-2" style="color:#fff;">Delete</a>
                                                                    <?php } ?>
                                                                <?php endif; ?>
                                                                <a class="btn btn-success lightbox <?= $user_grantee_grant_period->toefl_tnc != '' ? '' : 'd-none'?>" style="color:#fff;" href="<?= $user_grantee_grant_period->toefl_tnc != '' ? base_url($user_grantee_grant_period->toefl_tnc) : '#'?>">Download T&C</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Toefl Consent Letter</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <input <?= $disable_form ?> id="toefl_consent_letter" type="file" class="form-control active-grantee" name="toefl_consent_letter">
                                                                <button type="submit" id="btn-submit" class="btn btn-primary btn-submit button-for-grantee" name="btn-submit" value="save" style='color:#fff;position:absolute; top:0; right:0;z-index:9;'>Upload</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group">
                                                                <?php if($data_toefl_preparation->consent_letter) : ?>
                                                                    <a href="<?= base_url($data_toefl_preparation->consent_letter) ?>" class="btn btn-warning lightbox mr-2" style="color:#fff;">View</a>
                                                                    <?php if(!$is_grantee && has_permission('nominee', 'test_preparation_section')) { ?>
                                                                    <a href=<?= base_url('admin/nominee/general_nominee/delete_file/toefl_consent_letter/'.$grantee_grant->id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger mr-2" style="color:#fff;">Delete</a>
                                                                    <?php } ?>
                                                                <?php endif; ?>
                                                                <a class="btn btn-success lightbox <?= $user_grantee_grant_period->toefl_consent_letter != '' ? '' : 'd-none'?>" style="color:#fff;" href="<?= $user_grantee_grant_period->toefl_consent_letter != '' ? base_url($user_grantee_grant_period->toefl_consent_letter) : '#'?>">Download Consent Letter</a>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="row form-group">
                                                        <?php if($data_toefl_preparation->approve_tnc == 'approve') { ?>
                                                        <div class="col-lg-9">
                                                            <div class="alert alert-success">Status Agreement : <b>Approved</b></div>
                                                        </div>
                                                        <?php }else if($data_toefl_preparation->approve_tnc == 'revise') { ?>
                                                            <div class="alert alert-warning">
                                                                Status Agreement : <b>Revised</b>
                                                                <hr>
                                                                Note : <?= $data_toefl_preparation->notetnc ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if(!$is_alumni_page) { ?>
                                                        <?php if (!isset($is_grantee)) { ?>
                                                            <div class="col-lg-12">
                                                                <button type="submit" name="btn-submit" value="approve-toefl-tnc" onclick="return confirm('Are you sure?')" class="btn btn-success mr-2">Approve</button>
                                                                <!-- <button type="submit" name="btn-submit" value="revise-toefl-tnc" onclick="return confirm('Are you sure?')" class="btn btn-warning mr-2">Revise</button> -->
                                                                <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#mdl_note_reject" onclick="set_value_buton_revise('revise-toefl-tnc')">Revise</button>
                                                            </div>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="gre" class="tab-pane fade <?= $data_preparation->preparation_section == 'gre' ? 'active in' : '' ?>" style="display:<?= $data_preparation->preparation_section == 'gre' ? 'block' : 'none' ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Program Provider</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($data_gre_preparation) : ?>
                                                            <input type="hidden" name="gre_preparation_id" value="<?= $data_gre_preparation->id ?>">
                                                            <?php endif;?>
                                                            <input type="text" class="form-control" name="gre_preparation[program_provider]" value="<?= $data_gre_preparation->program_provider?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Contact Person</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_preparation[contact_person]" value="<?= $data_gre_preparation->contact_person?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Start Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff;" name="gre_preparation[start_date]" value="<?= $data_gre_preparation->start_date ? date('d M Y', strtotime($data_gre_preparation->start_date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>End Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff;" name="gre_preparation[end_date]" value="<?= $data_gre_preparation->end_date ? date('d M Y', strtotime($data_gre_preparation->end_date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Duration</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_preparation[duration]" value="<?= $data_gre_preparation->duration ?>">
                                                        </div>
                                                    </div>
                                                    <?php if($is_admin) { ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Cost</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="gre_preparation[cost]" value="<?= $data_gre_preparation->cost ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="gre_preparation[cost_idr]" value="<?= $data_gre_preparation->cost_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <!-- <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Format</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $data_gre_preparation->format == 'online' ? 'checked' : '' ?>
                                                                        name="gre_preparation[format]" 
                                                                        value="online">
                                                                        Online
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $data_gre_preparation->format == 'in-person' ? 'checked' : '' ?>
                                                                        name="gre_preparation[format]" 
                                                                        value="in-person">
                                                                        In-Person 
                                                            </label>
                                                        </div>
                                                    </div> -->
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Internet Allowance</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="gre_preparation[meals_allowance]" value="<?= $data_gre_preparation->meals_allowance ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="gre_preparation[meals_allowance_idr]" value="<?= $data_gre_preparation->meals_allowance_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($is_admin) { ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Airfare</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="gre_preparation[airfare]" value="<?= $data_gre_preparation->airfare ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="gre_preparation[airfare_idr]" value="<?= $data_gre_preparation->airfare_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Ground Transportation</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="gre_preparation[ground_transportation]" value="<?= $data_gre_preparation->ground_transportation ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="gre_preparation[ground_transportation_idr]" value="<?= $data_gre_preparation->ground_transportation_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Accommodation</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="gre_preparation[accomodation]" value="<?= $data_gre_preparation->accomodation ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="gre_preparation[accomodation_idr]" value="<?= $data_gre_preparation->accomodation_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Other Expenses</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="gre_preparation[other_expenses]" value="<?= $data_gre_preparation->other_expenses ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="gre_preparation[other_expenses_idr]" value="<?= $data_gre_preparation->other_expenses_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Agreement Form</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <input id="gre_tnc" type="file" class="form-control active-grantee" name="gre_tnc">
                                                                <!-- <button type="submit" id="btn-submit" class="btn btn-primary btn-submit button-for-grantee" name="btn-submit" value="save" style='color:#fff;position:absolute; top:0; right:0;z-index:9;'>Upload</button> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <?php if($data_gre_preparation->tnc) : ?>
                                                                    <a href="<?= base_url($data_gre_preparation->tnc) ?>" class="btn btn-warning lightbox mr-2" style="color:#fff;">View</a>
                                                                    <?php if(!$is_grantee) { ?>
                                                                    <a href=<?= base_url('admin/nominee/general_nominee/delete_file/gre_tnc/'.$grantee_grant->id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger mr-2" style="color:#fff;">Delete</a>
                                                                    <?php } ?>
                                                                <?php endif; ?>
                                                                <a class="btn btn-success lightbox <?= $user_grantee_grant_period->gre_tnc != '' ? '' : 'd-none'?>" style="color:#fff;" href="<?= $user_grantee_grant_period->gre_tnc != '' ? base_url($user_grantee_grant_period->gre_tnc) : '#'?>">Download T&C</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Gre Consent Letter</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <input id="gre_consent_letter" type="file" class="form-control active-grantee" name="gre_consent_letter">
                                                                <button type="submit" id="btn-submit" class="btn btn-primary btn-submit button-for-grantee" name="btn-submit" value="save" style='color:#fff;position:absolute; top:0; right:0;z-index:9;'>Upload</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group">
                                                                <?php if($data_gre_preparation->consent_letter) : ?>
                                                                    <a href="<?= base_url($data_gre_preparation->consent_letter) ?>" class="btn btn-warning lightbox mr-2" style="color:#fff;">View</a>
                                                                    <?php if(!$is_grantee) { ?>
                                                                    <a href=<?= base_url('admin/nominee/general_nominee/delete_file/gre_consent_letter/'.$grantee_grant->id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger mr-2" style="color:#fff;">Delete</a>
                                                                    <?php } ?>
                                                                <?php endif; ?>
                                                                <a class="btn btn-success lightbox <?= $user_grantee_grant_period->gre_consent_letter != '' ? '' : 'd-none'?>" style="color:#fff;" href="<?= $user_grantee_grant_period->gre_consent_letter != '' ? base_url($user_grantee_grant_period->gre_consent_letter) : '#'?>">Download Consent Letter</a>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="row form-group">
                                                        <?php if($data_gre_preparation->approve_tnc == 'approve') { ?>
                                                        <div class="col-lg-9">
                                                            <div class="alert alert-success">Status Agreement : <b>Approved</b></div>
                                                        </div>
                                                        <?php }else if($data_gre_preparation->approve_tnc == 'revise') { ?>
                                                            <div class="alert alert-warning">
                                                                Status Agreement : <b>Revised</b>
                                                                <hr>
                                                                Note : <?= $data_gre_preparation->notetnc ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if(!$is_alumni_page) { ?>
                                                        <?php if (!isset($is_grantee)) { ?>
                                                            <div class="col-lg-12">
                                                                <button type="submit" name="btn-submit" value="approve-gre-tnc" onclick="return confirm('Are you sure?')" class="btn btn-success mr-2">Approve</button>
                                                                <!-- <button type="submit" name="btn-submit" value="revise-gre-tnc" onclick="return confirm('Are you sure?')" class="btn btn-warning mr-2">Revise</button> -->
                                                                <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#mdl_note_reject" onclick="set_value_buton_revise('revise-gre-tnc')">Revise</button>
                                                            </div>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="toefl_gre" class="tab-pane fade <?= $data_preparation->preparation_section == 'toefl_gre' ? 'active in' : '' ?>" style="display:<?= $data_preparation->preparation_section == 'toefl_gre' ? 'block' : 'none' ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Program Provider</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($data_toefl_gre_preparation) : ?>
                                                            <input type="hidden" name="toefl_gre_preparation_id" value="<?= $data_toefl_gre_preparation->id ?>">
                                                            <?php endif;?>
                                                            <input type="text" class="form-control" name="toefl_gre_preparation[program_provider]" value="<?= $data_toefl_gre_preparation->program_provider?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Contact Person</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_gre_preparation[contact_person]" value="<?= $data_toefl_gre_preparation->contact_person?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Start Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff;" name="toefl_gre_preparation[start_date]" value="<?= $data_toefl_gre_preparation->start_date ? date('d M Y', strtotime($data_toefl_gre_preparation->start_date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>End Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff;" name="toefl_gre_preparation[end_date]" value="<?= $data_toefl_gre_preparation->end_date ? date('d M Y', strtotime($data_toefl_gre_preparation->end_date)) : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Duration</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_gre_preparation[duration]" value="<?= $data_toefl_gre_preparation->duration ?>">
                                                        </div>
                                                    </div>
                                                    <?php if($is_admin) { ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Cost</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_gre_preparation[cost]" value="<?= $data_toefl_gre_preparation->cost ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_gre_preparation[cost_idr]" value="<?= $data_toefl_gre_preparation->cost_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Internet Allowance</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_gre_preparation[meals_allowance]" value="<?= $data_toefl_gre_preparation->meals_allowance ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_gre_preparation[meals_allowance_idr]" value="<?= $data_toefl_gre_preparation->meals_allowance_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($is_admin) { ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Airfare</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_gre_preparation[airfare]" value="<?= $data_toefl_gre_preparation->airfare ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_gre_preparation[airfare_idr]" value="<?= $data_toefl_gre_preparation->airfare_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Ground Transportation</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_gre_preparation[ground_transportation]" value="<?= $data_toefl_gre_preparation->ground_transportation ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_gre_preparation[ground_transportation_idr]" value="<?= $data_toefl_gre_preparation->ground_transportation_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Accommodation</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_gre_preparation[accomodation]" value="<?= $data_toefl_gre_preparation->accomodation ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_gre_preparation[accomodation_idr]" value="<?= $data_toefl_gre_preparation->accomodation_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Other Expenses</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">USD</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-usd" name="toefl_gre_preparation[other_expenses]" value="<?= $data_toefl_gre_preparation->other_expenses ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">IDR</div>
                                                                <input style="z-index: 0" type="text" class="form-control currency-idr" name="toefl_gre_preparation[other_expenses_idr]" value="<?= $data_toefl_gre_preparation->other_expenses_idr ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Agreement Form</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <input id="toefl_gre_tnc" type="file" class="form-control active-grantee" name="toefl_gre_tnc">
                                                                <!-- <button type="submit" id="btn-submit" class="btn btn-primary btn-submit button-for-grantee" name="btn-submit" value="save" style='color:#fff;position:absolute; top:0; right:0;z-index:9;'>Upload</button> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <?php if($data_toefl_gre_preparation->tnc) : ?>
                                                                    <a href="<?= base_url($data_toefl_gre_preparation->tnc) ?>" class="btn btn-warning lightbox mr-2" style="color:#fff;">View</a>
                                                                    <?php if(!$is_grantee) { ?>
                                                                    <a href=<?= base_url('admin/nominee/general_nominee/delete_file/toefl_gre_tnc/'.$grantee_grant->id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger mr-2" style="color:#fff;">Delete</a>
                                                                    <?php } ?>
                                                                <?php endif; ?>
                                                                <a class="btn btn-success lightbox <?= $user_grantee_grant_period->toefl_gre_tnc != '' ? '' : 'd-none'?>" style="color:#fff;" href="<?= $user_grantee_grant_period->toefl_gre_tnc != '' ? base_url($user_grantee_grant_period->toefl_gre_tnc) : '#'?>">Download T&C</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Gre Consent Letter</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="input-group">
                                                                <input id="gre_consent_letter" type="file" class="form-control active-grantee" name="gre_consent_letter">
                                                                <button type="submit" id="btn-submit" class="btn btn-primary btn-submit button-for-grantee" name="btn-submit" value="save" style='color:#fff;position:absolute; top:0; right:0;z-index:9;'>Upload</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group">
                                                                <?php if($data_toefl_gre_preparation->consent_letter) : ?>
                                                                    <a href="<?= base_url($data_toefl_gre_preparation->consent_letter) ?>" class="btn btn-warning lightbox mr-2" style="color:#fff;">View</a>
                                                                    <?php if(!$is_grantee) { ?>
                                                                    <a href=<?= base_url('admin/nominee/general_nominee/delete_file/gre_consent_letter/'.$grantee_grant->id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger mr-2" style="color:#fff;">Delete</a>
                                                                    <?php } ?>
                                                                <?php endif; ?>
                                                                <a class="btn btn-success lightbox <?= $user_grantee_grant_period->gre_consent_letter != '' ? '' : 'd-none'?>" style="color:#fff;" href="<?= $user_grantee_grant_period->gre_consent_letter != '' ? base_url($user_grantee_grant_period->gre_consent_letter) : '#'?>">Download Consent Letter</a>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="row form-group">
                                                        <?php if($data_toefl_gre_preparation->approve_tnc == 'approve') { ?>
                                                        <div class="col-lg-9">
                                                            <div class="alert alert-success">Status Agreement : <b>Approved</b></div>
                                                        </div>
                                                        <?php }else if($data_toefl_gre_preparation->approve_tnc == 'revise') { ?>
                                                            <div class="alert alert-warning">
                                                                Status Agreement : <b>Revised</b>
                                                                <hr>
                                                                Note : <?= $data_toefl_gre_preparation->notetnc ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if(!$is_alumni_page) { ?>
                                                        <?php if (!isset($is_grantee)) { ?>
                                                            <div class="col-lg-12">
                                                                <button type="submit" name="btn-submit" value="approve-toefl-gre-tnc" onclick="return confirm('Are you sure?')" class="btn btn-success mr-2">Approve</button>
                                                                <!-- <button type="submit" name="btn-submit" value="revise-toefl-gre-tnc" onclick="return confirm('Are you sure?')" class="btn btn-warning mr-2">Revise</button> -->
                                                                <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#mdl_note_reject" onclick="set_value_buton_revise('revise-toefl-gre-tnc')">Revise</button>
                                                            </div>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body <?= $is_grantee ? '' : 'd-none' ?>">
                    <div class="row form-group">
                        <div class="col-lg-12">
                        <div class="input-group pull-right">
                            <button type="button" class="btn btn-danger mr-2 button-for-grantee" data-toggle="modal" data-target="#mdl_decline" style="display: inline-block !important;">Decline</button>
                            <button type="submit" id="btn-submit" class="btn btn-success btn-submit button-for-grantee mr-2" name="btn-submit" value="save" style="color:#fff;display: inline-block !important;">Save</button>
                        </div>
                        </div>

                    </div>
                </div>

                <?php if(!$is_alumni_page) { ?>
                    <div class="panel-body p-0">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <div class="input-group pull-right">
                                    <button type="button" class="btn btn-danger file-for-testing" data-toggle="modal" data-target="#mdl_decline">Decline</button>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php if(!$is_alumni_page) { ?>
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px;">
            <div style="margin-bottom:10px;" class="pull-right">
                <?php if (!isset($is_grantee)) { ?>
                    <a href="<?= $back_url ?>" class="btn btn-primary mr-2">Back</a>
                <?php } ?>
                <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-warning file-for-testing withdraw">Withdraw</a>
                <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-danger file-for-testing drop">Drop</a>
                <button type="submit" id="btn-submit" class="btn btn-success btn-submit file-for-testing" name="btn-submit" value="save">Save</button>
                <input type="hidden" id="data_section" value="preparation">
            </div>
        </div>
    </div>
    <?php } ?>
    <?php $this->load->view('admin/partials/modal_confirm') ?>
    <div class="modal fade" id="mdl_note_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <textarea class="form-control" name="note_tnc" id="note_reject" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="btn-save-note" name="btn-submit" class="btn btn-primary success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdl_decline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <textarea class="form-control active-grantee" name="preparation[reason_decline]" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="btn-save-decline" name="btn-submit" class="btn btn-primary success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
