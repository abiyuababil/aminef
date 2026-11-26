<?php

$url_delete = base_url('admin/nominee/general_nominee/delete_file');
if($is_grantee){
    $url_delete = base_url('grantee/submission/delete_file_test');
}
?>
<!-- --------- SECTION GRE ---------- -->
<?php if ($grantee_grant->show_gre_section && ($show_gre || $is_admin)){ ?>
<div id="gres" class="tab-pane fade">
    <div class="panel panel-default">
        <?php if(has_permission('nominee', 'test_section_data') || $is_admin) { ?>
        <div class="panel-body">
            <div class="row form-group pull-right">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary btn-for-add" onclick="add_section('gres')"><i class="fa fa-plus fa-fw"></i> Add New</button>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load-gres" style="display:none;">
                </div>
            </div>
        </div>
        <?php } ?>
        <div id="wrap-gres">
            <?php if($data_gre_section ) : ?>
                <?php foreach($data_gre_section as $kgs => $gre_section) : ?>
                <?php
                    $del_btn = ''; 
                    if($kgs > 0) : 
                    $del_btn = '
                    <img src="'.base_url('/img/loading.gif').'" class="delete-load-gre" style="display:none;position:absolute; top:35px; right:75px;">
                    <a href="javascript:;" onclick="del_item(this, \'gres-item\','.$gre_section->id.', \'gre\')" class="btn btn-danger btn-delete-nominee" style="position:absolute; top:-40px; right:15px;color: #fff;"><i class="fa fa-trash fa-fw"></i></a>';
                ?>
                    <hr>
                <?php endif; ?>
                <input type="hidden" name="gre_section[<?= $kgs ?>][gre_selection_id]" value="<?= $gre_section->id ?>">
                <?php if($kgs == 0 && $grantee_grant->guideline_gre_test) { ?>
                <a href="<?= base_url($grantee_grant->guideline_gre_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_gre_test ? '' : 'hide' ?>" style="color:#fff">
                    <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Test
                </a>
                <?php } ?>

                <?php if($kgs == 0) { ?>
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
                                    name="gre_section[<?= $kgs ?>][email]" 
                                    value="<?= $gre_section->email ?>"
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
                                    name="gre_section[<?= $kgs ?>][username]" 
                                    value="<?= $gre_section->username ?>"
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
                                    name="gre_section[<?= $kgs ?>][password]" 
                                    value="<?= $gre_section->password ?>"
                                >
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                <?php } ?>
                <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Gre <?= $gre_section->test_date ? 'test on ' . date('F j, Y', strtotime($gre_section->test_date)) : '' ?></p> -->
                <div id="gres-item-<?= $kgs ?>" class="gres-item" style="position:relative;<?= ($kgs > 0)  && $is_admin ? 'margin-top:50px;' : '' ?>">
                    <div class="panel-group" id="accordionGreParent<?= $kgs ?>" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <?php echo $del_btn ?>
                            <a role="button" data-toggle="collapse" data-parent="#accordionGreParent<?= $kgs ?>" href="#collapseGreTestParent<?= $kgs ?>" aria-expanded="true" aria-controls="collapseGreTestParent<?= $kgs ?>">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="GreTestParent">
                                    <h4 class="panel-title panel-title-parent">
                                        GRE <?= $gre_section->test_date ? 'test on ' . date('F j, Y', strtotime($gre_section->test_date)) : '' ?>
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseGreTestParent<?= $kgs ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="GreTestParent">
                                <div class="panel-group p-4" id="accordionGre<?= $kgs ?>" role="tablist" aria-multiselectable="true">
                                    <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                    <div class="panel panel-default">
                                        <a role="button" data-toggle="collapse" data-parent="#accordionGre<?= $kgs ?>" href="#collapseGreTest<?= $kgs ?>" aria-expanded="true" aria-controls="collapseGreTest<?= $kgs ?>">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="greTest">
                                                <h4 class="panel-title">
                                                    Test Information
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseGreTest<?= $kgs ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="greTest">
                                            <div class="panel-body">
                                                <div class="panel-body">
                                                    <div class="row form-group file-for-testing">
                                                        <div class="col-lg-4">
                                                            <label>Security Question</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="gre_section[<?= $kgs ?>][security_question]" 
                                                                value="<?= $gre_section->security_question ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Test Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control datepicker" readonly style="background-color:#fff" 
                                                                name="gre_section[<?= $kgs ?>][test_date]" 
                                                                value="<?= $gre_section->test_date ? date('d M Y', strtotime($gre_section->test_date)) : '' ?>"
                                                            >
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary <?= $is_admin ? '' : 'hide' ?>" style="color:#000;position:absolute;top:0px;right:20px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Test Time</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="time" 
                                                                class="form-control input_time" style="background-color:#fff" 
                                                                name="gre_section[<?= $kgs ?>][time]" 
                                                                value="<?= $gre_section->test_date ? (date('H:i:s', strtotime($gre_section->test_date)) != '00:00:00' ? date('H:i', strtotime($gre_section->test_date)) : '') : '' ?>"
                                                                
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Test Center</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_section[<?= $kgs ?>][test_center]" 
                                                                value="<?= $gre_section->test_center ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Format</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $gre_section->format == 'home_edition' ? 'checked' : '' ?>
                                                                        name="gre_section[<?= $kgs ?>][format]" 
                                                                        value="home_edition">
                                                                        Home Edition
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $gre_section->format == 'in-person' ? 'checked' : '' ?>
                                                                        name="gre_section[<?= $kgs ?>][format]" 
                                                                        value="in-person">
                                                                        In-Person 
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Confirmation Registration Form</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($gre_section->confirmation_registration) : ?>
                                                                <a 
                                                                    href="<?= base_url($gre_section->confirmation_registration) ?>" 
                                                                    class="btn btn-primary"
                                                                    download
                                                                    style="color:#fff">
                                                                    Download
                                                                </a>
                                                                <a 
                                                                    href="<?= base_url($gre_section->confirmation_registration) ?>" 
                                                                    class="btn btn-success lightbox"
                                                                    style="color:#fff">
                                                                    View
                                                                </a>
                                                                <?php if(!$is_grantee) { ?>
                                                                <a href=<?= $url_delete.'/gre_section_confirmation/'.$grantee_grant->id.'/'.$gre_section->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            <input 
                                                                type="file" 
                                                                class="form-control file-for-testing" 
                                                                name="confirmation_registration_gre_section_<?= $kgs ?>" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Verbal Reasoning Scaled Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_section[<?= $kgs ?>][total_score_verbal_reasoning_scaled_score]" 
                                                                value="<?= format_decimal($gre_section->total_score_verbal_reasoning_scaled_score) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Verbal Reasoning Percentile</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_section[<?= $kgs ?>][total_score_verbal_reasoning_percentile]" 
                                                                value="<?= format_decimal($gre_section->total_score_verbal_reasoning_percentile) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Quantitative Reasoning Scaled Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_section[<?= $kgs ?>][total_score_quantitive_reasoning_scaled_score]" 
                                                                value="<?= format_decimal($gre_section->total_score_quantitive_reasoning_scaled_score) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Quantitative Reasoning Percentile</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_section[<?= $kgs ?>][total_score_quantitive_reasoning_percentile]" 
                                                                value="<?= format_decimal($gre_section->total_score_quantitive_reasoning_percentile) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Analytical Writing Scaled Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_section[<?= $kgs ?>][total_score_analytical_writing_scaled_score]" 
                                                                value="<?= format_decimal($gre_section->total_score_analytical_writing_scaled_score) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Analytical Writing Percentile</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="gre_section[<?= $kgs ?>][total_score_analytical_writing_percentile]" 
                                                                value="<?= format_decimal($gre_section->total_score_analytical_writing_percentile) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group  <?= ($grantee_grant->is_final_placement || $submission_plan) ? '' : 'file-for-testing' ?>">
                                                        <div class="col-lg-4">
                                                            <label>Upload Score Report</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($gre_section->score_report) : ?>
                                                                <a 
                                                                    href="<?= base_url($gre_section->score_report) ?>" 
                                                                    class="btn btn-success lightbox"
                                                                    style="color:#fff">
                                                                    View
                                                                </a>
                                                                <?php if(!$is_grantee) { ?>
                                                                <a href=<?= $url_delete.'/gre_section/'.$grantee_grant->id.'/'.$gre_section->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            <input 
                                                                type="file" 
                                                                class="form-control file-for-testing" 
                                                                name="secore_report_gre_section_<?= $kgs ?>" 
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
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionGre<?= $kgs ?>" href="#collapseGreTransport<?= $kgs ?>" aria-expanded="false" aria-controls="collapseGreTransport<?= $kgs ?>" onclick="return set_session('interview_apointment')">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="greTransport">
                                                <h4 class="panel-title">
                                                    Travel Arrangement
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseGreTransport<?= $kgs ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="greTransport">
                                            <div class="panel-body">
                                                <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                                                    <input id="show_transportation_<?= $kgs ?>" onchange="show_hide_transportation(this, 'gre', <?= $kgs ?>)" class="select_show hidden" value="<?= $gre_section->show_transportation ?>">
                                                    <input id="show_accomodation_<?= $kgs ?>" onchange="show_hide_accomodation(this, 'gre', <?= $kgs ?>)" class="select_show hidden" value="<?= $gre_section->show_accomodation ?>">
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'test_section_data')) { ?>
                                                <div class="panel-body">
                                                    <label>Show Transportation</label>
                                                    <select class="form-control select_show" name="gre_section[<?= $kgs ?>][show_transportation]" id="show_transportation_<?= $kgs ?>" onchange="show_hide_transportation(this, 'gre', <?= $kgs ?>)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $gre_section->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $gre_section->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $gre_section->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                        <option <?= $gre_section->show_transportation == 'Departure Reimbursement' ? 'selected' : '' ?> value="Departure Reimbursement">Departure Reimbursement</option>
                                                        <option <?= $gre_section->show_transportation == 'Return Reimbursement' ? 'selected' : '' ?> value="Return Reimbursement">Return Reimbursement</option>

                                                    </select>
                                                    <label class="mt-3">Show Accommodation</label>
                                                    <select class="form-control select_show" name="gre_section[<?= $kgs ?>][show_accomodation]" id="show_accomodation_<?= $kgs ?>" onchange="show_hide_accomodation(this, 'gre', <?= $kgs ?>)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $gre_section->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $gre_section->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $gre_section->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                                                    </select>
                                                </div>
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'transportation_test_section') || $is_grantee) { ?>
                                                <div class="panel-body section-transportation-gre-<?= $kgs ?>">
                                                    <?php if($is_admin) { ?>
                                                    <div class="row mt-5 section-transportation-gre-<?= $kgs ?>">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Transportation Grantee</span>
                                                                <input id="enable_transportation_gre<?= $kgs ?>" name="gre_section[<?= $kgs ?>][enable_transportation_gre]" type="checkbox" <?= $gre_section->enable_transportation_gre  ? 'checked' : '' ?>/>
                                                                <label for="enable_transportation_gre<?= $kgs ?>" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                                    <?php 
                                                        $transport_status = evaluate_transportation($gre_section, $is_admin, [], 'show_transportation', 'enable_transportation_gre');
                                                    ?>
                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                                                            <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-12 label-transport-gre-<?= $kgs ?>">
                                                        <label>Departure Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>
                                                    <div class="panel-body section-default">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="gre_section[<?= $kgs ?>][origin_city]" value="<?= $gre_section->origin_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" placeholder="Destination City" name="gre_section[<?= $kgs ?>][destination_city]" value="<?= $gre_section->destination_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure Date</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="gre_section[<?= $kgs ?>][departure_date]" value="<?= $gre_section->departure_date != '' ? date('d M Y', strtotime( $gre_section->departure_date)) : '' ?>">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4" id="returning_date_gre_<?= $kgs ?>">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="gre_section[<?= $kgs ?>][returning_date]" value="<?= $gre_section->returning_date != '' ? date('d M Y', strtotime( $gre_section->returning_date)) : '' ?>">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_general_gre_<?= $kgs ?>">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="gre_section[<?= $kgs ?>][travel_agent]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($gre_section->travel_agent_id == $travel_agent->id) {
                                                                            $selected = 'selected="selected"';
                                                                        }?>
                                                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <?php if($transport_status['show_transportation'] || $is_admin || $gre_section->eticket != '') { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_eticket_gre_<?= $kgs ?>">E-Ticket</label>
                                                                <?php if($is_admin || $transport_status['show_transportation']) { ?>
                                                                <input type="file" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="eticket_gre_<?= $kgs ?>">
                                                                <?php } ?>
                                                                <?php if ($gre_section->eticket != '') { ?>
                                                                    <br>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                        <a href="<?=base_url() ?><?= $gre_section->eticket ?>" class="lightbox" aria-haspopup="dialog">
                                                                            <img id="preview_image_profile" data-old="<?php echo site_url( $gre_section->eticket); ?>" src="<?php echo get_preview( $gre_section->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                        </a>
                                                                        <a href="<?=base_url() ?><?= $gre_section->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $gre_section->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                            <i class="fa fa-download fa-fw"></i>
                                                                        </a>
                                                                        <?php if($transport_status['show_transportation'] || $is_admin) { ?>
                                                                        <a href="<?= $url_delete.'/gre_section_eticket/'.$grantee_grant->id.'/'.$gre_section->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
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
                                                    <div class="col-lg-12 label-transport-gre-<?= $kgs ?>">
                                                        <label>Returning Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>
                                                    <div class="panel-body returing_section_gre_<?= $kgs ?>">
                                                        <div class="col-lg-4 returing_section_gre_<?= $kgs ?>">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="gre_section[<?= $kgs ?>][returning_origin_city]" value="<?= $gre_section->returning_origin_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 returing_section_gre_<?= $kgs ?>">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" placeholder="Destination City" name="gre_section[<?= $kgs ?>][returning_destination_city]" value="<?= $gre_section->returning_destination_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="gre_section[<?= $kgs ?>][returning_date_section]" value="<?= $gre_section->returning_date != '' ? date('d M Y', strtotime( $gre_section->returning_date)) : '' ?>">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation_returning'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_returning_gre_<?= $kgs ?>">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="gre_section[<?= $kgs ?>][travel_agent_returning]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($gre_section->travel_agent_id == $travel_agent->id) {
                                                                            $selected = 'selected="selected"';
                                                                        }?>
                                                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <?php if($transport_status['show_transportation_returning'] || $is_admin || $gre_section->eticket_returning != '') { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_eticket_gre_returing<?= $kgs ?>">Returning E-Ticket</label>
                                                                <?php if($is_admin || $transport_status['show_transportation_returning']) { ?>
                                                                <input type="file" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" name="eticket_gre_returning_<?= $kgs ?>">
                                                                <?php } ?>
                                                                <?php if ($gre_section->eticket_returning != '') { ?>
                                                                    <br>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                        <a href="<?=base_url() ?><?= $gre_section->eticket_returning ?>" class="lightbox" aria-haspopup="dialog">
                                                                            <img id="preview_image_profile" data-old="<?php echo site_url( $gre_section->eticket_returning); ?>" src="<?php echo get_preview( $gre_section->eticket_returning); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                        </a>
                                                                        <a href="<?=base_url() ?><?= $gre_section->eticket_returning ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $gre_section->eticket_returning) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                            <i class="fa fa-download fa-fw"></i>
                                                                        </a>
                                                                        <?php if($transport_status['show_transportation_returning'] || $is_admin) { ?>
                                                                        <a href="<?= $url_delete.'/test_section_eticket/'.$grantee_grant->id.'/'.$gre_section->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
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
                                                <div class="panel-body section-accomodation-gre-<?= $kgs ?>">
                                                    <?php if($is_admin) { ?>
                                                    <div class="row mt-5 section-accomodation-gre-<?= $kgs ?>">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Accommodation Grantee</span>
                                                                <input id="enable_accommodation_gre<?= $kgs ?>" name="gre_section[<?= $kgs ?>][enable_accommodation_gre]" type="checkbox" <?= $gre_section->enable_accommodation_gre  ? 'checked' : '' ?>/>
                                                                <label for="enable_accommodation_gre<?= $kgs ?>" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php 
                                                        $accommodation_status = evaluate_transportation($gre_section, $is_admin, [], 'show_accomodation', 'enable_accommodation_gre');
                                                    ?>
                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-In Date</label>
                                                            <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="gre_section[<?= $kgs ?>][checkin_date]" value="<?= $gre_section->checkin_date != '' ? date('d M Y', strtotime( $gre_section->checkin_date)) : '' ?>">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-Out Date</label>
                                                            <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="gre_section[<?= $kgs ?>][checkout_date]" value="<?= $gre_section->checkout_date != '' ? date('d M Y', strtotime( $gre_section->checkout_date)) : '' ?>">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <?php if($accommodation_status['show_transportation'] || $is_admin || $gre_section->voucher_hotel != '') { ?>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label id="label_voucher_hotel_gre_<?= $kgs ?>">Hotel Voucher</label>
                                                            <?php if($is_admin || $accommodation_status['show_transportation']) { ?>
                                                            <input type="file" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="voucher_hotel_gre_<?= $kgs ?>">
                                                            <?php } ?>
                                                            <?php if ( $gre_section &&  $gre_section->voucher_hotel != '') { ?>
                                                                <br>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                    <a href="<?=base_url() ?><?= $gre_section->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                                                                        <img id="preview_image_profile" data-old="<?php echo site_url( $gre_section->voucher_hotel); ?>" src="<?php echo get_preview( $gre_section->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="<?=base_url() ?><?= $gre_section->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $gre_section->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                    <?php if($accommodation_status['show_transportation'] || $is_admin) { ?>
                                                                    <a href="<?= $url_delete.'/gre_section_voucher_hotel/'.$grantee_grant->id.'/'.$gre_section->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
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
                                                        <button type="submit" name="btn" value="save_send_tba_transport_gre_<?= $kgs ?>" class="section-transportation-gre-<?= $kgs ?> btn btn-primary mr-2">Save & Send Email Transportation</button>
                                                        <button type="submit" name="btn" value="save_send_tba_accommodation_gre_<?= $kgs ?>" class="section-accomodation-gre-<?= $kgs ?> btn btn-primary mr-2">Save & Send Email Accommodation</button>
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
                <div id="gres-item-0" class="gres-item" style="position:relative">
                    <a href="<?= base_url($grantee_grant->guideline_gre_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_gre_test ? '' : 'hide' ?>" style="color:#fff">
                        <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Test
                    </a>

                    <div class="panel-body">
                        <div class="row form-group file-for-testing">
                            <div class="col-lg-3">
                                <label>Email</label>
                            </div>
                            <div class="col-lg-6">
                                <input 
                                    type="text" 
                                    class="form-control"
                                    name="gre_section[0][email]" 
                                >
                            </div>
                        </div>
                        <div class="row form-group file-for-testing">
                            <div class="col-lg-3">
                                <label>Username</label>
                            </div>
                            <div class="col-lg-6">
                                <input 
                                    type="text" 
                                    class="form-control"
                                    name="gre_section[0][username]" 
                                >
                            </div>
                        </div>
                        <div class="row form-group file-for-testing">
                            <div class="col-lg-3">
                                <label>Password</label>
                            </div>
                            <div class="col-lg-6">
                                <input 
                                    type="text" 
                                    class="form-control"
                                    name="gre_section[0][password]" 
                                >
                            </div>
                        </div>
                    </div>
                    <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Gre</p> -->
                    <div class="panel-group" id="accordionGreParent" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <a role="button" data-toggle="collapse" data-parent="#accordionGreParent" href="#collapseGreTestParent" aria-expanded="true" aria-controls="collapseGreTestParent">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="GreTestParent">
                                    <h4 class="panel-title panel-title-parent">
                                        Gre
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseGreTestParent" class="panel-collapse collapse" role="tabpanel" aria-labelledby="GreTestParent">
                                <div class="panel-group p-4" id="accordionGre" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <a role="button" data-toggle="collapse" data-parent="#accordionGre" href="#collapseGreTest" aria-expanded="true" aria-controls="collapseGreTest">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="greTest">
                                                <h4 class="panel-title">
                                                    Test Information
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseGreTest" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="greTest">
                                            <div class="panel-body">
                                                <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                                <div class="panel-body">
                                                    <div class="row form-group file-for-testing">
                                                        <div class="col-lg-4">
                                                            <label>Security Question</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="gre_section[0][security_question]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Test Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" name="gre_section[0][test_date]" value="">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute;top:0px;right:20px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Test Time</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="time" 
                                                                class="form-control input_time" style="background-color:#fff" 
                                                                name="gre_section[0][time]"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Test Center</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_section[0][test_center]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Format</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        name="gre_section[0][format]" 
                                                                        value="home_edition">
                                                                        Home Edition
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        name="gre_section[0][format]" 
                                                                        value="in-person">
                                                                        In-Person 
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Confirmation Registration Form</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control file-for-testing" name="confirmation_registration_gre_section_0" value="">
                                                            <small class="file-for-testing">File Size Max 5MB</small>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Verbal Reasoning Scaled Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_section[0][total_score_verbal_reasoning_scaled_score]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Verbal Reasoning Percentile</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_section[0][total_score_verbal_reasoning_percentile]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Quantitative Reasoning Scaled Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_section[0][total_score_quantitive_reasoning_scaled_score]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Quantitative Reasoning Percentile</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_section[0][total_score_quantitive_reasoning_percentile]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Analytical Writing Scaled Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_section[0][total_score_analytical_writing_scaled_score]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Analytical Writing Percentile</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="gre_section[0][total_score_analytical_writing_percentile]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-4">
                                                            <label>Upload Score Report</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control file-for-testing" name="secore_report_gre_section_0" value="">
                                                            <small class="file-for-testing">File Size Max 5MB</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default hide">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionGre" href="#collapseGreTransport" aria-expanded="false" aria-controls="collapseGreTransport" onclick="return set_session('interview_apointment')">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="greTransport">
                                                <h4 class="panel-title">
                                                    Travel Arrangement
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseGreTransport" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="greTransport">
                                            <div class="panel-body">
                                                <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                                                    <input id="show_transportation_0" onchange="show_hide_transportation(this, 'gre', 0)" class="select_show hidden">
                                                    <input id="show_accomodation_0" onchange="show_hide_accomodation(this, 'gre', 0)" class="select_show hidden">
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'test_section_data')) { ?>
                                                <div class="panel-body">
                                                    <label>Show Transportation</label>
                                                    <select class="form-control select_show" name="gre_section[0][show_transportation]" id="show_transportation_0" onchange="show_hide_transportation(this, 'gre', 0)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $gre_section->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $gre_section->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $gre_section->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                        <option <?= $gre_section->show_transportation == 'Departure Reimbursement' ? 'selected' : '' ?> value="Departure Reimbursement">Departure Reimbursement</option>
                                                        <option <?= $gre_section->show_transportation == 'Return Reimbursement' ? 'selected' : '' ?> value="Return Reimbursement">Return Reimbursement</option>

                                                    </select>
                                                    <label class="mt-3">Show Accommodation</label>
                                                    <select class="form-control select_show" name="show_accomodation" id="show_accomodation_0" onchange="show_hide_accomodation(this, 'gre', 0)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $gre_section->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $gre_section->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $gre_section->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                                                    </select>
                                                </div>
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'transportation_test_section') || $is_grantee) { ?>
                                                <div class="panel-body section-transportation-gre-0">
                                                    <?php if($is_admin) { ?>
                                                    <div class="row mt-5 section-transportation-gre-0">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Transportation Grantee</span>
                                                                <input id="enable_transportation_gre0" name="gre_section[0][enable_transportation_gre]" type="checkbox" checked/>
                                                                <label for="enable_transportation_gre0" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                                                            <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-12 label-transport-gre-0">
                                                        <label>Departure Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>
                                                    <div class="panel-body section-default">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control" placeholder="Departure City" name="gre_section[0][origin_city]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control" placeholder="Destination City" name="gre_section[0][destination_city]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure Date</label>
                                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="gre_section[0][departure_date]">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4" id="returning_date_gre_0">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="gre_section[0][returning_date]">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_general_gre_0">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="gre_section[0][travel_agent]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($gre_section->travel_agent_id == $travel_agent->id) {
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
                                                                <label id="label_eticket_gre_0">E-Ticket</label>
                                                                <input type="file" class="form-control" name="eticket_gre_0">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- returning section -->
                                                    <div class="col-lg-12 label-transport-gre-0">
                                                        <label>Returning Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>
                                                    <div class="panel-body returing_section_gre_0">
                                                        <div class="col-lg-4 returing_section_gre_0">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control" placeholder="Departure City" name="gre_section[0][returning_origin_city]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 returing_section_gre_0">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control" placeholder="Destination City" name="gre_section[0][returning_destination_city]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="gre_section[0][returning_date_section]">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_returning_gre_0">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="gre_section[0][travel_agent_returning]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($gre_section->travel_agent_id == $travel_agent->id) {
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
                                                                <label id="label_eticket_gre_returing0">Returning E-Ticket</label>
                                                                <input type="file" class="form-control" name="eticket_gre_returning_0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'accomodation_test_section') || $is_grantee) { ?>
                                                <div class="panel-body section-accomodation-gre-0">
                                                    <?php if($is_admin) { ?>
                                                    <div class="row mt-5 section-accomodation-gre">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Accommodation Grantee</span>
                                                                <input id="enable_accommodation_gre" name="gre_section[0][enable_accommodation_gre]" type="checkbox" checked/>
                                                                <label for="enable_accommodation_gre" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-In Date</label>
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="gre_section[0][checkin_date]">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-Out Date</label>
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="gre_section[0][checkout_date]">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label id="label_voucher_hotel_gre_0">Hotel Voucher</label>
                                                            <input type="file" class="form-control" name="voucher_hotel_gre_0">
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
        <?php //if($is_grantee) { ?>
        <div class="panel-body pull-right">
            <button type="submit" class="btn btn-success" name="btn" value="save-test-section-gre-section">Save</button>
        </div>
        <?php //} ?>
    </div>
</div>
<?php } ?>
<!-- ----------- END SECTION GRE ------------ -->