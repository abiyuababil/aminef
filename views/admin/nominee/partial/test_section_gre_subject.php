<?php

$url_delete = base_url('admin/nominee/general_nominee/delete_file');
if($is_grantee){
    $url_delete = base_url('grantee/submission/delete_file_test');
}
?>
<!-- ------------ SECTION GRE SUBJECT ----------  -->
<?php if ($grantee_grant->show_gre_subject_section && ($show_gress || $is_admin)){ ?>
<div id="gress" class="tab-pane fade">
    <div class="panel panel-default">
        <?php if(has_permission('nominee', 'test_section_data') || $is_admin) { ?>
        <div class="panel-body">
            <div class="row form-group pull-right">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary btn-for-add" onclick="add_section('gress')"><i class="fa fa-plus fa-fw"></i> Add New</button>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load-gress" style="display:none;">
                </div>
            </div>
        </div>
        <?php } ?>
        <div id="wrap-gress">
            <?php if($data_gresubject_section) : ?>
                <?php foreach($data_gresubject_section as $kgres => $gre_subject_section) : ?>
                <?php
                    $del_btn = ''; 
                    if($kgres > 0) : 
                    $del_btn = '
                    <img src="'.base_url('/img/loading.gif').'" class="delete-load-gresubject" style="display:none;position:absolute; top:35px; right:75px;">
                    <a href="javascript:;" onclick="del_item(this, \'gress-item\','.$gre_subject_section->id.', \'gresubject\')" class="btn btn-danger btn-delete-nominee" style="position:absolute; top:-40px; right:15px;color: #fff;"><i class="fa fa-trash fa-fw"></i></a>';
                ?>
                    <hr>
                <?php endif; ?>
                <input type="hidden" name="gre_subject_section[<?= $kgres ?>][gre_subject_section_id]" value="<?= $gre_subject_section->id ?>">
                <div id="gress-item-<?= $kgres ?>" class="gress-item" style="position:relative;<?= ($kgres > 0) && $is_admin ? 'margin-top:50px;' : '' ?>">
                    <?php if($kgres == 0 && $grantee_grant->guideline_gres_test) { ?>
                    <a href="<?= base_url($grantee_grant->guideline_gres_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_gres_test ? '' : 'hide' ?>" style="color:#fff">
                        <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Test
                    </a>
                    <?php } ?>


                    <?php if($kgres == 0) { ?>
                        <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                            <div class="panel-body">
                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input 
                                            type="text" 
                                            class="form-control"
                                            name="gre_subject_section[<?= $kgres ?>][email]" 
                                            value="<?= $gre_subject_section->email ?>"
                                        >
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>Username</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input 
                                            type="text" 
                                            class="form-control"
                                            name="gre_subject_section[<?= $kgres ?>][username]" 
                                            value="<?= $gre_subject_section->username ?>"
                                        >
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>Password</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input 
                                            type="text" 
                                            class="form-control"
                                            name="gre_subject_section[<?= $kgres ?>][password]" 
                                            value="<?= $gre_subject_section->password ?>"
                                        >
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Gres Subject <?= $gre_subject_section->test_date ? 'test on ' . date('F j, Y', strtotime($gre_subject_section->test_date)) : '' ?></p> -->
                    <div class="panel-group" id="accordionGressParent<?= $kgres ?>" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                        <?php echo $del_btn ?>
                            <a role="button" data-toggle="collapse" data-parent="#accordionGressParent<?= $kgres ?>" href="#collapseGressTestParent<?= $kgres ?>" aria-expanded="true" aria-controls="collapseGressTestParent<?= $kgres ?>">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="GressTestParent">
                                    <h4 class="panel-title panel-title-parent">
                                        GRE Subject <?= $gre_subject_section->test_date ? 'test on ' . date('F j, Y', strtotime($gre_subject_section->test_date)) : '' ?>
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseGressTestParent<?= $kgres ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="GressTestParent">
                                <div class="panel-group p-4" id="accordionGress<?= $kgres ?>" role="tablist" aria-multiselectable="true">
                                    <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                    <div class="panel panel-default">
                                        <a role="button" data-toggle="collapse" data-parent="#accordionGress<?= $kgres ?>" href="#collapseGressTest<?= $kgres ?>" aria-expanded="true" aria-controls="collapseGressTest<?= $kgres ?>">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="GressTest">
                                                <h4 class="panel-title">
                                                    Test Information
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseGressTest<?= $kgres ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="GressTest">
                                            <div class="panel-body">
                                                <div class="panel-body">
                                                    <div class="row form-group file-for-testing">
                                                        <div class="col-lg-3">
                                                            <label>Security Question</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="gre_subject_section[<?= $kgres ?>][security_question]" 
                                                                value="<?= $gre_subject_section->security_question ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control datepicker" readonly style="background-color:#fff"
                                                                    name="gre_subject_section[<?= $kgres ?>][test_date]" 
                                                                    value="<?= $gre_subject_section->test_date ? date('d M Y', strtotime($gre_subject_section->test_date)) : '' ?>"
                                                                >
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary <?= $is_admin ? '' : 'hide' ?>" style="color:#000;position:absolute;top:0px;right:20px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Time</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="time" 
                                                                class="form-control input_time" style="background-color:#fff" 
                                                                name="gre_subject_section[<?= $kgres ?>][time]" 
                                                                value="<?= $gre_subject_section->test_date ? (date('H:i:s', strtotime($gre_subject_section->test_date)) != '00:00:00' ? date('H:i', strtotime($gre_subject_section->test_date)) : '') : '' ?>"
                                                                
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Center</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_subject_section[<?= $kgres ?>][test_center]" 
                                                                value="<?= $gre_subject_section->test_center ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Field of Study</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_subject_section[<?= $kgres ?>][field_study]" 
                                                                value="<?= $gre_subject_section->field_study ?>"
                                                            >
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
                                                                        <?= $gre_subject_section->format == 'home_edition' ? 'checked' : '' ?>
                                                                        name="gre_subject_section[<?= $kgres ?>][format]" 
                                                                        value="home_edition">
                                                                        Home Edition
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $gre_subject_section->format == 'in-person' ? 'checked' : '' ?>
                                                                        name="gre_subject_section[<?= $kgres ?>][format]" 
                                                                        value="in-person">
                                                                        In-Person 
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Confirmation Registration Form</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($gre_subject_section->confirmation_registration) : ?>
                                                                <a 
                                                                    href="<?= base_url($gre_subject_section->confirmation_registration) ?>" 
                                                                    class="btn btn-primary"
                                                                    download
                                                                    style="color:#fff">
                                                                    Download
                                                                </a>
                                                                <a 
                                                                    href="<?= base_url($gre_subject_section->confirmation_registration) ?>" 
                                                                    class="btn btn-success lightbox"
                                                                    style="color:#fff">
                                                                    View
                                                                </a>
                                                                <?php if(!$is_grantee) { ?>
                                                                <a href=<?= $url_delete.'/gre_subject_section_confirmation/'.$grantee_grant->id.'/'.$gre_subject_section->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            <input 
                                                                type="file" 
                                                                class="form-control file-for-testing" 
                                                                name="confirmation_registration_gre_subjec_section_<?= $kgres ?>" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Total Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_subject_section[<?= $kgres ?>][total_score]" 
                                                                value="<?= format_decimal($gre_subject_section->total_score) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group <?= ($grantee_grant->is_final_placement || $submission_plan) ? '' : 'file-for-testing' ?>">
                                                        <div class="col-lg-3">
                                                            <label>Upload Score Report</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($gre_subject_section->score_report) : ?>
                                                                <a 
                                                                    href="<?= base_url($gre_subject_section->score_report) ?>" 
                                                                    class="btn btn-success lightbox"
                                                                    style="color:#fff">
                                                                    View
                                                                </a>
                                                                <?php if(!$is_grantee) { ?>
                                                                <a href=<?= $url_delete.'/gre_subject_section/'.$grantee_grant->id.'/'.$gre_subject_section->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            <input 
                                                                type="file" 
                                                                class="form-control file-for-testing" 
                                                                name="score_report_gre_subjec_section_<?= $kgres ?>" 
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <?php if($show_travel_arrangement) { ?>
                                    <div class="panel panel-default">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionGress<?= $kgres ?>" href="#collapseGressTransport<?= $kgres ?>" aria-expanded="false" aria-controls="collapseGressTransport<?= $kgres ?>">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="GressTransport">
                                                <h4 class="panel-title">
                                                    Travel Arrangement
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseGressTransport<?= $kgres ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="GressTransport">
                                            <div class="panel-body">
                                                <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                                                    <input id="show_transportation_<?= $kgres ?>" onchange="show_hide_transportation(this, 'gresubject', <?= $kgres ?>)" class="select_show hidden" value="<?= $gre_subject_section->show_transportation ?>">
                                                    <input id="show_accomodation_<?= $kgres ?>" onchange="show_hide_accomodation(this, 'gresubject', <?= $kgres ?>)" class="select_show hidden" value="<?= $gre_subject_section->show_accomodation ?>">
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'test_section_data')) { ?>
                                                <div class="panel-body">
                                                    <label>Show Transportation</label>
                                                    <select class="form-control select_show" name="gre_subject_section[<?= $kgres ?>][show_transportation]" id="show_transportation_<?= $kgres ?>" onchange="show_hide_transportation(this, 'gresubject', <?= $kgres ?>)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'Departure Reimbursement' ? 'selected' : '' ?> value="Departure Reimbursement">Departure Reimbursement</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'Return Reimbursement' ? 'selected' : '' ?> value="Return Reimbursement">Return Reimbursement</option>

                                                    </select>
                                                    <label class="mt-3">Show Accommodation</label>
                                                    <select class="form-control select_show" name="gre_subject_section[<?= $kgres ?>][show_accomodation]" id="show_accomodation_<?= $kgres ?>" onchange="show_hide_accomodation(this, 'gresubject', <?= $kgres ?>)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $gre_subject_section->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $gre_subject_section->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $gre_subject_section->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                                                    </select>
                                                </div>
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'transportation_test_section') || $is_grantee) { ?>
                                                <div class="panel-body section-transportation-gresubject-<?= $kgres ?>">
                                                    <?php if($is_admin) { ?>
                                                    <div class="row mt-5 section-transportation-gresubject-<?= $kgres ?>">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Transportation Grantee</span>
                                                                <input id="enable_transportation_gress<?= $kgres ?>" name="gre_subject_section[<?= $kgres ?>][enable_transportation_gress]" type="checkbox" <?= $gre_subject_section->enable_transportation_gress  ? 'checked' : '' ?>/>
                                                                <label for="enable_transportation_gress<?= $kgres ?>" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                                    <?php 
                                                        $transport_status = evaluate_transportation($gre_subject_section, $is_admin, [], 'show_transportation', 'enable_transportation_gress');
                                                    ?>

                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                                                            <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-12 label-transport-gresubject-<?= $kgres ?>">
                                                        <label>Departure Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>

                                                    <div class="panel-body section-default">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="gre_subject_section[<?= $kgres ?>][origin_city]" value="<?= $gre_subject_section->origin_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" placeholder="Destination City" name="gre_subject_section[<?= $kgres ?>][destination_city]" value="<?= $gre_subject_section->destination_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure Date</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="gre_subject_section[<?= $kgres ?>][departure_date]" value="<?= $gre_subject_section->departure_date != '' ? date('d M Y', strtotime( $gre_subject_section->departure_date)) : '' ?>">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4" id="returning_date_gresubject_<?= $kgres ?>">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="gre_subject_section[<?= $kgres ?>][returning_date]" value="<?= $gre_subject_section->returning_date != '' ? date('d M Y', strtotime( $gre_subject_section->returning_date)) : '' ?>">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_general_gresubject_<?= $kgres ?>">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="gre_subject_section[<?= $kgres ?>][travel_agent]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($gre_subject_section->travel_agent_id == $travel_agent->id) {
                                                                            $selected = 'selected="selected"';
                                                                        }?>
                                                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <?php if($transport_status['show_transportation'] || $is_admin || $gre_subject_section->eticket != '') { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_eticket_gresubject_<?= $kgres ?>">E-Ticket</label>
                                                                <?php if($is_admin || $transport_status['show_transportation']) { ?>
                                                                <input type="file" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="eticket_gresubject_<?= $kgres ?>">
                                                                <?php } ?>
                                                                <?php if ($gre_subject_section->eticket != '') { ?>
                                                                    <br>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                        <a href="<?=base_url() ?><?= $gre_subject_section->eticket ?>" class="lightbox" aria-haspopup="dialog">
                                                                            <img id="preview_image_profile" data-old="<?php echo site_url( $gre_subject_section->eticket); ?>" src="<?php echo get_preview( $gre_subject_section->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                        </a>
                                                                        <a href="<?=base_url() ?><?= $gre_subject_section->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $gre_subject_section->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                            <i class="fa fa-download fa-fw"></i>
                                                                        </a>
                                                                        <?php if($transport_status['show_transportation'] || $is_admin) { ?>
                                                                        <a href="<?= $url_delete.'/gre_subject_section_eticket/'.$grantee_grant->id.'/'.$gre_subject_section->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
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
                                                    <div class="col-lg-12 label-transport-gresubject-<?= $kgres ?>">
                                                        <label>Returning Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>
                                                    <div class="panel-body returing_section_gresubject_<?= $kgres ?>">
                                                        <div class="col-lg-4 returing_section_gresubject_<?= $kgres ?>">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="gre_subject_section[<?= $kgres ?>][returning_origin_city]" value="<?= $gre_subject_section->returning_origin_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 returing_section_gresubject_<?= $kgres ?>">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" placeholder="Destination City" name="gre_subject_section[<?= $kgres ?>][returning_destination_city]" value="<?= $gre_subject_section->returning_destination_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="gre_subject_section[<?= $kgres ?>][returning_date_section]" value="<?= $gre_subject_section->returning_date != '' ? date('d M Y', strtotime( $gre_subject_section->returning_date)) : '' ?>">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation_returning'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_returning_gresubject_<?= $kgres ?>">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="gre_subject_section[<?= $kgres ?>][travel_agent_returning]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($gre_subject_section->travel_agent_id == $travel_agent->id) {
                                                                            $selected = 'selected="selected"';
                                                                        }?>
                                                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <?php if($transport_status['show_transportation_returning'] || $is_admin || $gre_subject_section->eticket_returning != '') { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_eticket_gresubject_returing<?= $kgres ?>">Returning E-Ticket</label>
                                                                <?php if($is_admin || $transport_status['show_transportation_returning']) { ?>
                                                                <input type="file" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" name="eticket_gresubject_returning_<?= $kgres ?>">
                                                                <?php } ?>
                                                                <?php if ($gre_subject_section->eticket_returning != '') { ?>
                                                                    <br>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                        <a href="<?=base_url() ?><?= $gre_subject_section->eticket_returning ?>" class="lightbox" aria-haspopup="dialog">
                                                                            <img id="preview_image_profile" data-old="<?php echo site_url( $gre_subject_section->eticket_returning); ?>" src="<?php echo get_preview( $gre_subject_section->eticket_returning); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                        </a>
                                                                        <a href="<?=base_url() ?><?= $gre_subject_section->eticket_returning ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $gre_subject_section->eticket_returning) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                            <i class="fa fa-download fa-fw"></i>
                                                                        </a>
                                                                        <?php if($transport_status['show_transportation_returning'] || $is_admin) { ?>
                                                                        <a href="<?= $url_delete.'/test_section_eticket/'.$grantee_grant->id.'/'.$gre_subject_section->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                            <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                                                                        </a>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php } ?>

                                                <?php if(has_permission('nominee', 'accomodation_test_section') || $is_grantee) { ?>
                                                <div class="panel-body section-accomodation-gresubject-<?= $kgres ?>">
                                                    <?php if($is_admin) { ?>
                                                    <div class="row mt-5 section-accomodation-gresubject-<?= $kgres ?>">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Accommodation Grantee</span>
                                                                <input id="enable_accommodation_gress<?= $kgres ?>" name="gre_subject_section[<?= $kgres ?>][enable_accommodation_gress]" type="checkbox" <?= $gre_subject_section->enable_accommodation_gress  ? 'checked' : '' ?>/>
                                                                <label for="enable_accommodation_gress<?= $kgres ?>" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php 
                                                        $accommodation_status = evaluate_transportation($gre_subject_section, $is_admin, [], 'show_accomodation', 'enable_accommodation_gress');
                                                    ?>
                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-In Date</label>
                                                            <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="gre_subject_section[<?= $kgres ?>][checkin_date]" value="<?= $gre_subject_section->checkin_date != '' ? date('d M Y', strtotime( $gre_subject_section->checkin_date)) : '' ?>">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-Out Date</label>
                                                            <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="gre_subject_section[<?= $kgres ?>][checkout_date]" value="<?= $gre_subject_section->checkout_date != '' ? date('d M Y', strtotime( $gre_subject_section->checkout_date)) : '' ?>">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <?php if($accommodation_status['show_transportation'] || $is_admin || $gre_subject_section->voucher_hotel != '') { ?>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label id="label_voucher_hotel_gresubject_<?= $kgres ?>">Hotel Voucher</label>
                                                            <?php if($is_admin || $accommodation_status['show_transportation']) { ?>
                                                            <input type="file" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="voucher_hotel_gresubject_<?= $kgres ?>">
                                                            <?php } ?>
                                                            <?php if ( $gre_subject_section &&  $gre_subject_section->voucher_hotel != '') { ?>
                                                                <br>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                    <a href="<?=base_url() ?><?= $gre_subject_section->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                                                                        <img id="preview_image_profile" data-old="<?php echo site_url( $gre_subject_section->voucher_hotel); ?>" src="<?php echo get_preview( $gre_subject_section->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="<?=base_url() ?><?= $gre_subject_section->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $gre_subject_section->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                    <?php if($accommodation_status['show_transportation'] || $is_admin) { ?>
                                                                    <a href="<?= $url_delete.'/gre_subject_section_voucher_hotel/'.$grantee_grant->id.'/'.$gre_subject_section->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
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
                                                    <div class="panel-body pull-right">
                                                        <button type="submit" name="btn" value="save_send_tba_transport_gress_<?= $kgres ?>" class="section-transportation-gress-<?= $kgres ?> btn btn-primary mr-2">Save & Send Email Transportation</button>
                                                        <button type="submit" name="btn" value="save_send_tba_accommodation_gress_<?= $kgres ?>" class="section-accomodation-gress-<?= $kgres ?> btn btn-primary mr-2">Save & Send Email Accommodation</button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div id="gress-item-0" class="gress-item" style="position:relative">
                    <a href="<?= base_url($grantee_grant->guideline_gres_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_gres_test ? '' : 'hide' ?>" style="color:#fff">
                        <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Test
                    </a>

                    <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                    <div class="panel-body">
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Email</label>
                            </div>
                            <div class="col-lg-6">
                                <input 
                                    type="text" 
                                    class="form-control"
                                    name="gre_subject_section[0][email]" 
                                >
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Username</label>
                            </div>
                            <div class="col-lg-6">
                                <input 
                                    type="text" 
                                    class="form-control"
                                    name="gre_subject_section[0][username]" 
                                >
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Password</label>
                            </div>
                            <div class="col-lg-6">
                                <input 
                                    type="text" 
                                    class="form-control"
                                    name="gre_subject_section[0][password]" 
                                >
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Gres Subject</p> -->
                    <div class="panel-group" id="accordionGressParent" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <a role="button" data-toggle="collapse" data-parent="#accordionGressParent" href="#collapseGressTestParent" aria-expanded="true" aria-controls="collapseGressTestParent">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="GressTestParent">
                                    <h4 class="panel-title panel-title-parent">
                                        GRE Subject
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseGressTestParent" class="panel-collapse collapse" role="tabpanel" aria-labelledby="GressTestParent">
                                <div class="panel-group p-4" id="accordionGress" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <a role="button" data-toggle="collapse" data-parent="#accordionGress" href="#collapseGressTest" aria-expanded="true" aria-controls="collapseGressTest">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="GressTest">
                                                <h4 class="panel-title">
                                                    Test Information
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseGressTest" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="GressTest">
                                            <div class="panel-body">
                                                <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                                <div class="panel-body">
                                                    <div class="row form-group file-for-testing">
                                                        <div class="col-lg-3">
                                                            <label>Security Question</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="gre_subject_section[0][security_question]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" name="gre_subject_section[0][test_date]" value="">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute;top:0px;right:20px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Time</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="time" 
                                                                class="form-control input_time" style="background-color:#fff" 
                                                                name="gre_subject_section[0][time]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Center</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_subject_section[0][test_center]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Field of Study</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_subject_section[0][field_study]" value="">
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
                                                                        name="gre_subject_section[0][format]" 
                                                                        value="home_edition">
                                                                        Home Edition
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        name="gre_subject_section[0][format]" 
                                                                        value="in-person">
                                                                        In-Person 
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Confirmation Registration Form</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control file-for-testing" name="confirmation_registration_gre_subjec_section_0" value="">
                                                            <small class="file-for-testing">File Size Max 5MB</small>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Total Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_subject_section[0][total_score]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Upload Score Report</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control file-for-testing" name="score_report_gre_subjec_section_0" value="">
                                                            <small class="file-for-testing">File Size Max 5MB</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default hide">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionGress" href="#collapseGressTransport" aria-expanded="false" aria-controls="collapseGressTransport">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="GressTransport">
                                                <h4 class="panel-title">
                                                    Travel Arrangement
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseGressTransport" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="GressTransport">
                                            <div class="panel-body">
                                                <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                                                    <input id="show_transportation_0" onchange="show_hide_transportation(this, 'gresubject', 0)" class="select_show hidden">
                                                    <input id="show_accomodation_0" onchange="show_hide_accomodation(this, 'gresubject', 0)" class="select_show hidden">
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'test_section_data')) { ?>
                                                <div class="panel-body">
                                                    <label>Show Transportation</label>
                                                    <select class="form-control select_show" name="gre_subject_section[0][show_transportation]" id="show_transportation_0" onchange="show_hide_transportation(this, 'gresubject', 0)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'Departure Reimbursement' ? 'selected' : '' ?> value="Departure Reimbursement">Departure Reimbursement</option>
                                                        <option <?= $gre_subject_section->show_transportation == 'Return Reimbursement' ? 'selected' : '' ?> value="Return Reimbursement">Return Reimbursement</option>

                                                    </select>
                                                    <label class="mt-3">Show Accommodation</label>
                                                    <select class="form-control select_show" name="gre_subject_section[0][show_accomodation]" id="show_accomodation_0" onchange="show_hide_accomodation(this, 'gresubject', 0)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $gre_subject_section->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $gre_subject_section->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $gre_subject_section->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                                                    </select>
                                                </div>
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'transportation_test_section') || $is_grantee) { ?>
                                                <div class="panel-body section-transportation-gresubject-0">
                                                    <div class="row mt-5 section-transportation-gresubject-0">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Transportation Grantee</span>
                                                                <input id="enable_transportation_gress0" name="gre_subject_section[0][enable_transportation_gress]" type="checkbox" checked/>
                                                                <label for="enable_transportation_gress0" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                                                            <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-12 label-transport-gresubject-0">
                                                        <label>Departure Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>
                                                    <div class="panel-body section-default">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control" placeholder="Departure City" name="gre_subject_section[0][origin_city]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control" placeholder="Destination City" name="gre_subject_section[0][destination_city]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure Date</label>
                                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="gre_subject_section[0][departure_date]">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4" id="returning_date_gresubject_0">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="gre_subject_section[0][returning_date]">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_general_gresubject_0">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="gre_subject_section[0][travel_agent]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($gre_subject_section->travel_agent_id == $travel_agent->id) {
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
                                                                <label id="label_eticket_gresubject_0">E-Ticket</label>
                                                                <input type="file" class="form-control" name="eticket_gresubject_0">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- returning section -->
                                                    <div class="col-lg-12 label-transport-gresubject-0">
                                                        <label>Returning Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>
                                                    <div class="panel-body returing_section_gresubject_0">
                                                        <div class="col-lg-4 returing_section_gresubject_0">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control" placeholder="Departure City" name="gre_subject_section[0][returning_origin_city]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 returing_section_gresubject_0">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control" placeholder="Destination City" name="gre_subject_section[0][returning_destination_city]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="gre_subject_section[0][returning_date_section]">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_returning_gresubject_0">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="gre_subject_section[0][travel_agent_returning]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($gre_subject_section->travel_agent_id == $travel_agent->id) {
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
                                                                <label id="label_eticket_gresubject_returing0">Returning E-Ticket</label>
                                                                <input type="file" class="form-control" name="eticket_gresubject_returning_0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'accomodation_test_section') || $is_grantee) { ?>
                                                <div class="panel-body section-accomodation-gresubject-0">
                                                    <div class="row mt-5 section-accomodation-gresubject-0">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Accommodation Grantee</span>
                                                                <input id="enable_accommodation_gress0" name="gre_subject_section[0][enable_accommodation_gress]" type="checkbox" checked/>
                                                                <label for="enable_accommodation_gress0" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-In Date</label>
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="gre_subject_section[0][checkin_date]">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-Out Date</label>
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="gre_subject_section[0][checkout_date]">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label id="label_voucher_hotel_gresubject_0">Hotel Voucher</label>
                                                            <input type="file" class="form-control" name="voucher_hotel_gresubject_0">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php // if($is_grantee) { ?>
        <div class="panel-body pull-right">
            <button type="submit" class="btn btn-success" name="btn" value="save-test-section-gre-subject">Save</button>
        </div>
        <?php // } ?>
    </div>
</div>
<?php } ?>
<!-- --------------- END SECTION GRESUBJECT ----------- -->