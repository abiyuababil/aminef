<?php

$url_delete = base_url('admin/nominee/general_nominee/delete_file');
if($is_grantee){
    $url_delete = base_url('grantee/submission/delete_file_test');
}
?>
<!-- -------------- TOEFL SECTION ------------ -->
<?php if ($grantee_grant->show_toefl_section && ($show_toefl || $is_admin)){ ?>
<div id="toefls" class="tab-pane fade active in">
    <div class="panel panel-default">
        <!-- BUTTON ADD -->
        <?php if(has_permission('nominee', 'test_section_data') || $is_admin) { ?>
        <div class="panel-body">
            <div class="row form-group pull-right">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary btn-for-add" onclick="add_section('toefls')"><i class="fa fa-plus fa-fw"></i> Add New</button>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load-toefls" style="display:none;">
                </div>
            </div>
        </div>
        <?php } ?>

        <div id="wrap-toefls">
            <?php if($data_toefl_section) : ?>
                <?php foreach($data_toefl_section as $kdts => $toefl_section) : ?>
                <?php
                    $del_btn = ''; 
                    if($kdts > 0) : 
                    $del_btn = '
                    <img src="'.base_url('/img/loading.gif').'" class="delete-load-toefl" style="display:none;position:absolute; top:35px; right:75px;">
                    <a href="javascript:;" onclick="del_item(this, \'toefls-item\','.$toefl_section->id.', \'toefl\')" class="btn btn-danger btn-delete-nominee" style="position:absolute; top:-40px; right:15px;color: #fff;"><i class="fa fa-trash fa-fw"></i></a>';
                ?>
                    <hr>
                <?php endif; ?>
                <input 
                    type="hidden" 
                    value="<?= $toefl_section->id ?>" 
                    name="toefl_section[<?= $kdts ?>][toefl_selection_id]"
                >

                <?php if($kdts == 0 && $grantee_grant->guideline_test) { ?>
                <a href="<?= base_url($grantee_grant->guideline_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_test ? '' : 'hide' ?>" style="color:#fff">
                    <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Test
                </a>
                <?php } ?>

                <?php if($kdts == 0) { ?>
                <div class="panel-body">
                    <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Email</label>
                            </div>
                            <div class="col-lg-6">
                                <input 
                                    type="text" 
                                    class="form-control"
                                    name="toefl_section[<?= $kdts ?>][email]" 
                                    value="<?= $toefl_section->email ?>"
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
                                    name="toefl_section[<?= $kdts ?>][username]" 
                                    value="<?= $toefl_section->username ?>"
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
                                    name="toefl_section[<?= $kdts ?>][password]" 
                                    value="<?= $toefl_section->password ?>"
                                >
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>



                <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Toefl <?= $toefl_section->test_date ? 'test on ' . date('F j, Y', strtotime($toefl_section->test_date)) : '' ?></p> -->
                <div id="toefls-item-<?= $kdts ?>" class="toefls-item" style="position:relative;<?= ($kdts > 0) && $is_admin ? 'margin-top:50px;' : '' ?>">
                    <div class="panel-group" id="accordionToeflParent<?= $kdts ?>" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <?php echo $del_btn ?>
                            <a role="button" data-toggle="collapse" data-parent="#accordionToeflParent<?= $kdts ?>" href="#collapseToeflTestParent<?= $kdts ?>" aria-expanded="true" aria-controls="collapseToeflTestParent<?= $kdts ?>">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTestParent">
                                    <h4 class="panel-title panel-title-parent">
                                        TOEFL <?= $toefl_section->test_date ? 'test on ' . date('F j, Y', strtotime($toefl_section->test_date)) : '' ?>

                                    </h4>
                                </div>
                            </a>
                            <div id="collapseToeflTestParent<?= $kdts ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ToeflTestParent">
                                <div class="panel-group p-4" id="accordionToefl<?= $kdts ?>" role="tablist" aria-multiselectable="true">
                                    <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                    <div class="panel panel-default">
                                        <a role="button" data-toggle="collapse" data-parent="#accordionToefl<?= $kdts ?>" href="#collapseToeflTest<?= $kdts ?>" aria-expanded="true" aria-controls="collapseToeflTest<?= $kdts ?>">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTest">
                                                <h4 class="panel-title">
                                                    Test Information
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseToeflTest<?= $kdts ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTest">
                                            <div class="panel-body">
                                                <div class="panel-body">
                                                    <!-- <div class="row form-group <?= $toefl_section->format == 'home_edition' ? '' : 'file-for-testing'?>">
                                                        <div class="col-lg-3">
                                                            <label>Email</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="toefl_section[<?= $kdts ?>][email]" 
                                                                value="<?= $toefl_section->email ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group <?= $toefl_section->format == 'home_edition' ? '' : 'file-for-testing'?>">
                                                        <div class="col-lg-3">
                                                            <label>Username</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="toefl_section[<?= $kdts ?>][username]" 
                                                                value="<?= $toefl_section->username ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group <?= $toefl_section->format == 'home_edition' ? '' : 'file-for-testing'?>">
                                                        <div class="col-lg-3">
                                                            <label>Password</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="toefl_section[<?= $kdts ?>][password]" 
                                                                value="<?= $toefl_section->password ?>"
                                                            >
                                                        </div>
                                                    </div> -->
                                                    <div class="row form-group file-for-testing">
                                                        <div class="col-lg-3">
                                                            <label>Security Question</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="toefl_section[<?= $kdts ?>][security_question]" 
                                                                value="<?= $toefl_section->security_question ?>"
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
                                                                name="toefl_section[<?= $kdts ?>][test_date]" 
                                                                value="<?= $toefl_section->test_date ? date('d M Y', strtotime($toefl_section->test_date)) : '' ?>"
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
                                                                name="toefl_section[<?= $kdts ?>][time]" 
                                                                value="<?= $toefl_section->test_date ? (date('H:i:s', strtotime($toefl_section->test_date)) != '00:00:00' ? date('H:i', strtotime($toefl_section->test_date)) : '') : '' ?>"
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
                                                                name="toefl_section[<?= $kdts ?>][test_center]" 
                                                                value="<?= $toefl_section->test_center ?>"
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
                                                                        <?= $toefl_section->format == 'home_edition' ? 'checked' : ''?>
                                                                        name="toefl_section[<?= $kdts ?>][format]" 
                                                                        value="home_edition">
                                                                        Home Edition
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $toefl_section->format == 'in-person' ? 'checked' : ''?>
                                                                        name="toefl_section[<?= $kdts ?>][format]" 
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
                                                            <?php if($toefl_section->confirmation_registration) : ?>
                                                                <a 
                                                                    href="<?= base_url($toefl_section->confirmation_registration) ?>" 
                                                                    class="btn btn-primary"
                                                                    download
                                                                    style="color:#fff">
                                                                    Download
                                                                </a>
                                                                <a 
                                                                    href="<?= base_url($toefl_section->confirmation_registration) ?>" 
                                                                    class="btn btn-success lightbox"
                                                                    style="color:#fff">
                                                                    View
                                                                </a>
                                                                <?php if(!$is_grantee) { ?>
                                                                <a href=<?= $url_delete.'/test_section_confirmation/'.$grantee_grant->id.'/'.$toefl_section->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            <input 
                                                                type="file" 
                                                                class="form-control file-for-testing" 
                                                                name="confirmation_registration_toefl_section_<?= $kdts ?>" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Reading Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="toefl_section[<?= $kdts ?>][total_score_reading]" 
                                                                value="<?= format_decimal($toefl_section->total_score_reading) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Listening Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="toefl_section[<?= $kdts ?>][total_score_listening]" 
                                                                value="<?= format_decimal($toefl_section->total_score_listening) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Speaking Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="toefl_section[<?= $kdts ?>][total_score_speaking]" 
                                                                value="<?= format_decimal($toefl_section->total_score_speaking) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Writing Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="toefl_section[<?= $kdts ?>][total_score_writing]" 
                                                                value="<?= format_decimal($toefl_section->total_score_writing) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Total Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php 
                                                                $total_score_toefl = $toefl_section->total_score ? $toefl_section->total_score : $toefl_section->total_score_reading + $toefl_section->total_score_speaking + $toefl_section->total_score_listening + $toefl_section->total_score_writing;
                                                            ?>
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                name="toefl_section[<?= $kdts ?>][total_score]" 
                                                                value="<?= format_decimal($total_score_toefl) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group <?= ($grantee_grant->is_final_placement || $submission_plan) ? '' : 'file-for-testing' ?>">
                                                        <div class="col-lg-3">
                                                            <label>Upload Score Report</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($toefl_section->score_report) : ?>
                                                                <a 
                                                                    href="<?= base_url($toefl_section->score_report) ?>" 
                                                                    class="btn btn-success lightbox"
                                                                    style="color:#fff">
                                                                    View
                                                                </a>
                                                                <?php if(!$is_grantee) { ?>
                                                                <a href=<?= $url_delete.'/test_section/'.$grantee_grant->id.'/'.$toefl_section->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            <input 
                                                                type="file" 
                                                                class="form-control file-for-testing" 
                                                                name="score_report_toefl_section_<?= $kdts ?>" 
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
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionToefl<?= $kdts ?>" href="#collapseToeflTransport<?= $kdts ?>" aria-expanded="false" aria-controls="collapseToeflTransport<?= $kdts ?>" onclick="return set_session('interview_apointment')">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTransport">
                                                <h4 class="panel-title">
                                                    Travel Arrangement
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseToeflTransport<?= $kdts ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTransport">
                                            <div class="panel-body">
                                                <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                                                    <input id="show_transportation_<?= $kdts ?>" onchange="show_hide_transportation(this, 'toefl', <?= $kdts ?>)" class="select_show hidden" value="<?= $toefl_section->show_transportation ?>">
                                                    <input id="show_accomodation_<?= $kdts ?>" onchange="show_hide_accomodation(this, 'toefl', <?= $kdts ?>)" class="select_show hidden" value="<?= $toefl_section->show_accomodation ?>">
                                                <?php } ?>
                                                <?php if(has_permission('nominee', 'test_section_data')) { ?>
                                                <div class="panel-body">
                                                    <label>Show Transportation</label>
                                                    <select class="form-control select_show" name="toefl_section[<?= $kdts ?>][show_transportation]" id="show_transportation_<?= $kdts ?>" onchange="show_hide_transportation(this, 'toefl', <?= $kdts ?>)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $toefl_section->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $toefl_section->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $toefl_section->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                        <option <?= $toefl_section->show_transportation == 'Departure Reimbursement' ? 'selected' : '' ?> value="Departure Reimbursement">Departure Reimbursement</option>
                                                        <option <?= $toefl_section->show_transportation == 'Return Reimbursement' ? 'selected' : '' ?> value="Return Reimbursement">Return Reimbursement</option>

                                                    </select>
                                                    <label class="mt-3">Show Accommodation</label>
                                                    <select class="form-control select_show" name="toefl_section[<?= $kdts ?>][show_accomodation]" id="show_accomodation_<?= $kdts ?>" onchange="show_hide_accomodation(this, 'toefl', <?= $kdts ?>)">
                                                        <option value="">- Select -</option>
                                                        <option <?= $toefl_section->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $toefl_section->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $toefl_section->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                                                    </select>
                                                </div>
                                                <?php } ?>

                                                <?php if(has_permission('nominee', 'transportation_test_section') || $is_grantee) { ?>
                                                <div class="panel-body section-transportation-toefl-<?= $kdts ?>">
                                                    <?php if($is_admin) { ?>
                                                    <div class="row mt-5 section-transportation-toefl-<?= $kdts ?>">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Transportation Grantee</span>
                                                                <input id="enable_transportation_toefl<?= $kdts ?>" name="toefl_section[<?= $kdts ?>][enable_transportation_toefl]" type="checkbox" <?= $toefl_section->enable_transportation_toefl  ? 'checked' : '' ?>/>
                                                                <label for="enable_transportation_toefl<?= $kdts ?>" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                                    <?php 
                                                        $transport_status = evaluate_transportation($toefl_section, $is_admin, [], 'show_transportation', 'enable_transportation_toefl');
                                                    ?>
                                                    
                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="btn btn-primary <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                                                            <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-12 label-transport-toefl-<?= $kdts ?>">
                                                        <label>Departure Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>
                                                    
                                                    <div class="panel-body section-default">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="toefl_section[<?= $kdts ?>][origin_city]" value="<?= $toefl_section->origin_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" placeholder="Destination City" name="toefl_section[<?= $kdts ?>][destination_city]" value="<?= $toefl_section->destination_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure Date</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="toefl_section[<?= $kdts ?>][departure_date]" value="<?= $toefl_section->departure_date != '' ? date('d M Y', strtotime( $toefl_section->departure_date)) : '' ?>">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4" id="returning_date_toefl_<?= $kdts ?>">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="toefl_section[<?= $kdts ?>][returning_date]" value="<?= $toefl_section->returning_date != '' ? date('d M Y', strtotime( $toefl_section->returning_date)) : '' ?>">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_general_toefl_<?= $kdts ?>">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="toefl_section[<?= $kdts ?>][travel_agent]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($toefl_section->travel_agent_id == $travel_agent->id) {
                                                                            $selected = 'selected="selected"';
                                                                        }?>
                                                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <?php if($transport_status['show_transportation'] || $is_admin || $toefl_section->eticket != '') { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_eticket_toefl_<?= $kdts ?>">E-Ticket</label>
                                                                <?php if($is_admin || $transport_status['show_transportation']) { ?>
                                                                <input type="file" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="eticket_toefl_<?= $kdts ?>">
                                                                <?php } ?>
                                                                <?php if ($toefl_section->eticket != '') { ?>
                                                                    <br>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                        <a href="<?=base_url() ?><?= $toefl_section->eticket ?>" class="lightbox" aria-haspopup="dialog">
                                                                            <img id="preview_image_profile" data-old="<?php echo site_url( $toefl_section->eticket); ?>" src="<?php echo get_preview( $toefl_section->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                        </a>
                                                                        <a href="<?=base_url() ?><?= $toefl_section->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $toefl_section->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                            <i class="fa fa-download fa-fw"></i>
                                                                        </a>
                                                                        <?php if($transport_status['show_transportation'] || $is_admin) { ?>
                                                                        <a href="<?= $url_delete.'/test_section_eticket/'.$grantee_grant->id.'/'.$toefl_section->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
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
                                                    <div class="col-lg-12 label-transport-toefl-<?= $kdts ?>">
                                                        <label>Returning Ticket</label>
                                                        <hr class="no-margin"/>
                                                    </div>
                                                    <div class="panel-body returing_section_toefl_<?= $kdts ?>">
                                                        <div class="col-lg-4 returing_section_toefl_<?= $kdts ?>">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="toefl_section[<?= $kdts ?>][returning_origin_city]" value="<?= $toefl_section->returning_origin_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 returing_section_toefl_<?= $kdts ?>">
                                                            <div class="form-group">
                                                                <label>Destination City</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" placeholder="Destination City" name="toefl_section[<?= $kdts ?>][returning_destination_city]" value="<?= $toefl_section->returning_destination_city ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Return Date</label>
                                                                <input type="text" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="toefl_section[<?= $kdts ?>][returning_date_section]" value="<?= $toefl_section->returning_date != '' ? date('d M Y', strtotime( $toefl_section->returning_date)) : '' ?>">
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status['show_transportation_returning'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if(!$is_grantee) { ?>
                                                        <div class="col-lg-4" id="travel_agen_returning_toefl_<?= $kdts ?>">
                                                            <div class="form-group">
                                                                <label>Travel Agent</label>
                                                                <select name="toefl_section[<?= $kdts ?>][travel_agent_returning]" class="form_control select2">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach($travel_agents as $travel_agent) { 
                                                                        $selected = '';
                                                                        if ($toefl_section->travel_agent_id == $travel_agent->id) {
                                                                            $selected = 'selected="selected"';
                                                                        }?>
                                                                        <option value="<?php echo $travel_agent->id ?>" <?php echo $selected ?>><?php echo $travel_agent->name ?> - <?php echo $travel_agent->email ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <?php if($transport_status['show_transportation_returning'] || $is_admin || $toefl_section->eticket_returning != '') { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_eticket_toefl_returing<?= $kdts ?>">Returning E-Ticket</label>
                                                                <?php if($is_admin || $transport_status['show_transportation_returning']) { ?>
                                                                <input type="file" class="form-control <?= $transport_status['disable_transportation_returing'] ? '' : 'form-control-grantee' ?>" name="eticket_toefl_returning_<?= $kdts ?>">
                                                                <?php } ?>
                                                                <?php if ($toefl_section->eticket_returning != '') { ?>
                                                                    <br>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                        <a href="<?=base_url() ?><?= $toefl_section->eticket_returning ?>" class="lightbox" aria-haspopup="dialog">
                                                                            <img id="preview_image_profile" data-old="<?php echo site_url( $toefl_section->eticket_returning); ?>" src="<?php echo get_preview( $toefl_section->eticket_returning); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                        </a>
                                                                        <a href="<?=base_url() ?><?= $toefl_section->eticket_returning ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $toefl_section->eticket_returning) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                            <i class="fa fa-download fa-fw"></i>
                                                                        </a>
                                                                        <?php if($transport_status['show_transportation_returning'] || $is_admin) { ?>
                                                                        <a href="<?= $url_delete.'/test_section_eticket/'.$grantee_grant->id.'/'.$toefl_section->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
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
                                                <div class="panel-body section-accomodation-toefl-<?= $kdts ?>">
                                                    <?php if($is_admin) { ?>
                                                    <div class="row mt-5 section-accomodation-toefl-<?= $kdts ?>">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Accommodation Grantee</span>
                                                                <input id="enable_accommodation_toefl<?= $kdts ?>" name="toefl_section[<?= $kdts ?>][enable_accommodation_toefl]" type="checkbox" <?= $toefl_section->enable_accommodation_toefl  ? 'checked' : '' ?>/>
                                                                <label for="enable_accommodation_toefl<?= $kdts ?>" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php 
                                                        $accommodation_status = evaluate_transportation($toefl_section, $is_admin, [], 'show_accomodation', 'enable_accommodation_toefl');
                                                    ?>
                                                    <div class="col-lg-12">
                                                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-In Date</label>
                                                            <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="toefl_section[<?= $kdts ?>][checkin_date]" value="<?= $toefl_section->checkin_date != '' ? date('d M Y', strtotime( $toefl_section->checkin_date)) : '' ?>">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Check-Out Date</label>
                                                            <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="toefl_section[<?= $kdts ?>][checkout_date]" value="<?= $toefl_section->checkout_date != '' ? date('d M Y', strtotime( $toefl_section->checkout_date)) : '' ?>">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <?php if($accommodation_status['show_transportation'] || $is_admin || $toefl_section->voucher_hotel != '') { ?>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label id="label_voucher_hotel_toefl_<?= $kdts ?>">Hotel Voucher</label>
                                                            <?php if($is_admin || $accommodation_status['show_transportation']) { ?>
                                                            <input type="file" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="voucher_hotel_toefl_<?= $kdts ?>">
                                                            <?php } ?>
                                                            <?php if ( $toefl_section &&  $toefl_section->voucher_hotel != '') { ?>
                                                                <br>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                    <a href="<?=base_url() ?><?= $toefl_section->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                                                                        <img id="preview_image_profile" data-old="<?php echo site_url( $toefl_section->voucher_hotel); ?>" src="<?php echo get_preview( $toefl_section->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="<?=base_url() ?><?= $toefl_section->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $toefl_section->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                    <?php if($accommodation_status['show_transportation'] || $is_admin) { ?>
                                                                    <a href="<?= $url_delete.'/test_section_voucher_hotel/'.$grantee_grant->id.'/'.$toefl_section->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
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
                                                        <button type="submit" name="btn" value="save_send_tba_transport_toefl_<?= $kdts ?>" class="section-transportation-toefl-<?= $kdts ?> btn btn-primary mr-2">Save & Send Email Transportation</button>
                                                        <button type="submit" name="btn" value="save_send_tba_accommodation_toefl_<?= $kdts ?>" class="section-accomodation-toefl-<?= $kdts ?> btn btn-primary mr-2">Save & Send Email Accommodation</button>
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
                <a href="<?= base_url($grantee_grant->guideline_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_test ? '' : 'hide' ?>" style="color:#fff">
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
                                name="toefl_section[0][email]" 
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
                                name="toefl_section[0][username]" 
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
                                name="toefl_section[0][password]" 
                            >
                        </div>
                    </div>
                </div>
                <?php } ?>
                <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Toefl</p> -->
                <div id="toefls-item-0" class="toefls-item" style="position:relative">
                    <div class="panel-group" id="accordionToeflParent" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <a role="button" data-toggle="collapse" data-parent="#accordionToeflParent" href="#collapseToeflTestParent" aria-expanded="true" aria-controls="collapseToeflTestParent">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTestParent">
                                    <h4 class="panel-title panel-title-parent">
                                        TOEFL
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseToeflTestParent" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ToeflTestParent">
                                <div class="panel-group p-4" id="accordionToefl" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <a role="button" data-toggle="collapse" data-parent="#accordionToefl" href="#collapseToeflTest" aria-expanded="true" aria-controls="collapseToeflTest">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTest">
                                                <h4 class="panel-title">
                                                    Test Information
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseToeflTest" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTest">
                                            <div class="panel-body">
                                                <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                                <div class="panel-body">
                                                    <!-- <div class="row form-group file-for-testing">
                                                        <div class="col-lg-3">
                                                            <label>Email</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="toefl_section[0][email]" 
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
                                                                name="toefl_section[0][username]" 
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
                                                                name="toefl_section[0][password]" 
                                                            >
                                                        </div>
                                                    </div> -->
                                                    <div class="row form-group file-for-testing">
                                                        <div class="col-lg-3">
                                                            <label>Security Question</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control"
                                                                name="toefl_section[0][security_question]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" name="toefl_section[0][test_date]" value="">
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
                                                                name="toefl_section[0][time]"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Center</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_section[0][test_center]" value="">
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
                                                                        name="toefl_section[0][format]" 
                                                                        value="home_edition">
                                                                        Home Edition
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        name="toefl_section[0][format]" 
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
                                                            <input type="file" class="form-control file-for-testing" name="confirmation_registration_toefl_section_0" value="">
                                                            <small class="file-for-testing">File Size Max 5MB</small>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Reading Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_section[0][total_score_reading]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Speaking Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_section[0][total_score_speaking]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Listening Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_section[0][total_score_listening]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Writing Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_section[0][total_score_writing]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Total Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="toefl_section[0][total_score]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Upload Score Report</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control file-for-testing" name="score_report_toefl_section_0" value="">
                                                            <small class="file-for-testing">File Size Max 5MB</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default hide">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionToefl" href="#collapseToeflTransport" aria-expanded="false" aria-controls="collapseToeflTransport" onclick="return set_session('interview_apointment')">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTransport">
                                                <h4 class="panel-title">
                                                    Travel Arrangement
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseToeflTransport" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTransport">
                                        <div class="panel-body">
                                            <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                                                <input id="show_transportation_0" onchange="show_hide_transportation(this, 'toefl', 0)" class="select_show hidden">
                                                <input id="show_accomodation_0" onchange="show_hide_accomodation(this, 'toefl', 0)" class="select_show hidden">
                                            <?php } ?>
                                            <?php if(has_permission('nominee', 'test_section_data')) { ?>
                                            <div class="panel-body">
                                                <label>Show Transportation</label>
                                                <select class="form-control select_show" name="toefl_section[0][show_transportation]" id="show_transportation_0" onchange="show_hide_transportation(this, 'toefl', 0)">
                                                    <option value="">- Select -</option>
                                                    <option <?= $toefl_section->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                    <option <?= $toefl_section->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                    <option <?= $toefl_section->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                    <option <?= $toefl_section->show_transportation == 'Departure Reimbursement' ? 'selected' : '' ?> value="Departure Reimbursement">Departure Reimbursement</option>
                                                    <option <?= $toefl_section->show_transportation == 'Return Reimbursement' ? 'selected' : '' ?> value="Return Reimbursement">Return Reimbursement</option>

                                                </select>
                                                <label class="mt-3">Show Accommodation</label>
                                                <select class="form-control select_show" name="toefl_section[0][show_accomodation]" id="show_accomodation_0" onchange="show_hide_accomodation(this, 'toefl', 0)">
                                                    <option value="">- Select -</option>
                                                    <option <?= $toefl_section->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                    <option <?= $toefl_section->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                    <option <?= $toefl_section->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                                                </select>
                                            </div>
                                            <?php } ?>
                                            <?php if(has_permission('nominee', 'transportation_test_section') || $is_grantee) { ?>
                                            <div class="panel-body section-transportation-toefl-0">
                                                <?php if($is_admin) { ?>
                                                <div class="row mt-5 section-transportation-toefl-0">
                                                    <div class="col-lg-12">
                                                        <div class="TriSea-technologies-Switch">
                                                            <span class="mr-2"> Enable Transportation Grantee</span>
                                                            <input id="enable_transportation_toefl0" name="toefl_section[0][enable_transportation_toefl]" type="checkbox" checked/>
                                                            <label for="enable_transportation_toefl0" class="label-primary"></label>
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

                                                <div class="col-lg-12 label-transport-toefl-0">
                                                    <label>Departure Ticket</label>
                                                    <hr class="no-margin"/>
                                                </div>
                                                <div class="panel-body section-default">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Departure City</label>
                                                            <input type="text" class="form-control" placeholder="Departure City" name="toefl_section[0][origin_city]">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Destination City</label>
                                                            <input type="text" class="form-control" placeholder="Destination City" name="toefl_section[0][destination_city]">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Departure Date</label>
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="toefl_section[0][departure_date]">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4" id="returning_date_toefl_0">
                                                        <div class="form-group">
                                                            <label>Return Date</label>
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="toefl_section[0][returning_date]">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <?php if(!$is_grantee) { ?>
                                                    <div class="col-lg-4" id="travel_agen_general_toefl_0">
                                                        <div class="form-group">
                                                            <label>Travel Agent</label>
                                                            <select name="toefl_section[0][travel_agent]" class="form_control select2">
                                                                <option value="">-- Select --</option>
                                                                <?php foreach($travel_agents as $travel_agent) { 
                                                                    $selected = '';
                                                                    if ($toefl_section->travel_agent_id == $travel_agent->id) {
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
                                                            <label id="label_eticket_toefl_0">E-Ticket</label>
                                                            <input type="file" class="form-control" name="eticket_toefl_0">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- returning section -->
                                                <div class="col-lg-12 label-transport-toefl-0">
                                                    <label>Returning Ticket</label>
                                                    <hr class="no-margin"/>
                                                </div>
                                                <div class="panel-body returing_section_toefl_0">
                                                    <div class="col-lg-4 returing_section_toefl_0">
                                                        <div class="form-group">
                                                            <label>Departure City</label>
                                                            <input type="text" class="form-control" placeholder="Departure City" name="toefl_section[0][returning_origin_city]">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 returing_section_toefl_0">
                                                        <div class="form-group">
                                                            <label>Destination City</label>
                                                            <input type="text" class="form-control" placeholder="Destination City" name="toefl_section[0][returning_destination_city]">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Return Date</label>
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="toefl_section[0][returning_date_section]">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                        </div>
                                                    </div>
                                                    <?php if(!$is_grantee) { ?>
                                                    <div class="col-lg-4" id="travel_agen_returning_toefl_0">
                                                        <div class="form-group">
                                                            <label>Travel Agent</label>
                                                            <select name="toefl_section[0][travel_agent_returning]" class="form_control select2">
                                                                <option value="">-- Select --</option>
                                                                <?php foreach($travel_agents as $travel_agent) { 
                                                                    $selected = '';
                                                                    if ($toefl_section->travel_agent_id == $travel_agent->id) {
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
                                                            <label id="label_eticket_toefl_returing0">Returning E-Ticket</label>
                                                            <input type="file" class="form-control" name="eticket_toefl_returning_0">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if(has_permission('nominee', 'accomodation_test_section') || $is_grantee) { ?>
                                            <div class="panel-body section-accomodation-toefl-0" style="margin-top:-20px">
                                                <?php if($is_admin) { ?>
                                                <div class="row mt-5 section-accomodation-toefl-0">
                                                    <div class="col-lg-12">
                                                        <div class="TriSea-technologies-Switch">
                                                            <span class="mr-2"> Enable Accommodation Grantee</span>
                                                            <input id="enable_accommodation_toefl" name="toefl_section[0][enable_accommodation_toefl]" type="checkbox" checked/>
                                                            <label for="enable_accommodation_toefl" class="label-primary"></label>
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
                                                        <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="toefl_section[0][checkin_date]">
                                                        <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Check-Out Date</label>
                                                        <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="toefl_section[0][checkout_date]">
                                                        <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label id="label_voucher_hotel_toefl_0">Hotel Voucher</label>
                                                        <input type="file" class="form-control" name="voucher_hotel_toefl_0">
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
            <button type="submit" class="btn btn-success" name="btn" value="save-test-section-toefl">Save</button>
        </div>
        <?php //} ?>
    </div>
</div>
<?php } ?>
<!-- ------------- END SECTION TOEFL -------------- -->