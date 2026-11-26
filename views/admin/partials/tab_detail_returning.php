<style>
    .ui-datepicker {
        z-index: 9999 !important;
    }
    ol.m {list-style-type: lower-latin;}
    .panel-default .panel-heading-returning{
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

    th {
        /* text-align: center; */
        vertical-align: top !important;
    }
    .table-appointment th {
        /* text-align: center; */
        vertical-align: top !important;
    }
    .table-required th {
        /* text-align: center; */
        vertical-align: top !important;
    }

    .span-note:hover {
        background-color: #df7401;
        cursor: pointer;
    }
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

    .sticky-col {
    position: sticky;
    background-color: #f9f9f9;
    z-index: 2;
    }

    .first-col {
        left: 2px;
        z-index: 3;
    }

    .second-col {
        left: 42px;
    }

    .third-col {
        left: 158px;
    }
</style>
<form id="form" method="POST" enctype="multipart/form-data">
<input type="hidden" name="btn" id="btn_value">
<input type="hidden" id="interview_appointment" value="<?= $returning->appointment_located ?>">
<input type="hidden" id="is_admin" value="<?= $is_admin ?>">
<div class="row warp-alumni-page">
    <div class="col-lg-12">
        <div class="tabs">
            <ul>
                <li onclick="navigate_tab('before_your_retuning')">
                    <a aria-expanded="true" data-toggle="tab" href="#before_your_retuning">Before Your Return</a>
                </li>
                <li onclick="navigate_tab('upon_your_return')">
                    <a aria-expanded="true" data-toggle="tab" href="#upon_your_return">Upon Your Return</a>
                </li>
                <!-- <li onclick="navigate_tab('transportation_accomodation')">
                    <a aria-expanded="true" data-toggle="tab" href="#transportation_accomodation">Transportation & Accomodation</a>
                </li> -->
                <!-- <li onclick="navigate_tab('after_you_return')">
                    <a aria-expanded="true" data-toggle="tab" href="#after_you_return">After Your Returning</a>
                </li> -->
            </ul>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content">
                        <div id="before_your_retuning" class="active in first_tab">
                            <div class="panel-group" id="accordionOne" role="tablist" aria-multiselectable="true">
                                <?php if($grantee_grant->is_degree) : ?>
                                <p>
                                    If you have not yet done so, please contact your AMINEF Program Office (PIC) to arrange your return ticket through this 
                                    <a href="<?= $url_travel_returning ?>" style="color:#337ab7" target="_blank">link</a>. 
                                </p>
                                <?php else : ?>
                                    <p>Submit the following documents: </p>

                                    <?php //$this->load->view('admin/partials/ds2019_returning') ?>
                                    <?php $this->load->view('admin/partials/ds2019_ongoing') ?>
                                    <?php $this->load->view('admin/partials/ongoing_detail_form') ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Upon yor return -->
                        <div id="upon_your_return" class="active in first_tab">
                            <div class="panel-group" id="accordionTwo" role="tablist" aria-multiselectable="true">
                                <p class="mt-4">Submit the following documents in .pdf format and participate in the required activities according to the specified deadline:</p>
                                <div class="panel panel-default">
                                    <a role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseArrivalReport" aria-expanded="true" aria-controls="collapseArrivalReport" onclick="return set_session('upon_your_return')">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Arrival Report Form
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseArrivalReport" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <p>
                                                    Complete and submit this form within 30 days of your arrival from the U.S.
                                                </p>

                                                <?php if($upon_return){ ?>
                                                <input type="hidden" name="upon_return_id" value="<?= $upon_return->id ?>">
                                                <?php } ?>
                                                <!-- <label class="my-4">Personal Information</label>
                                                <div class="row mb-3">
                                                    <label for="full_name" class="col-sm-2 col-form-label">Full Name</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="full_name" name="arrival_report_form[full_name]" value="<?= $arrival_report_form['full_name'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="gender" name="arrival_report_form[gender]" value="<?= $arrival_report_form['gender'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="place" class="col-sm-2 col-form-label">Place/DOB</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="place" name="arrival_report_form[place]" value="<?= $arrival_report_form['place'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="address" class="col-sm-2 col-form-label">U.S. Adderss</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="address" name="arrival_report_form[address]" value="<?= $arrival_report_form['address'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="phone_number" class="col-sm-2 col-form-label">U.S. Phone Number</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="phone_number" name="arrival_report_form[phone_number]" value="<?= $arrival_report_form['phone_number'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="email" name="arrival_report_form[email]" value="<?= $arrival_report_form['email'] ?>">
                                                    </div>
                                                </div>
                                                <hr /> -->



                                                <label class="my-4">University Information</label>
                                                <div class="row mb-3">
                                                    <label for="university" class="col-sm-2 col-form-label">U.S. University</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="university" disabled value="<?= $collage_placement->university_id ? get_university_by_id($collage_placement->university_id)->name : '' ?>">
                                                    </div>
                                                </div>
                                                <!-- <div class="row mb-3">
                                                    <label for="program" class="col-sm-2 col-form-label">Program</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="program" name="arrival_report_form[program]" value="<?= $arrival_report_form['program'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="department" class="col-sm-2 col-form-label">School/Department</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="department" name="arrival_report_form[department]" value="<?= $arrival_report_form['department'] ?>">
                                                    </div>
                                                </div> -->
                                                <div class="row mb-3">
                                                    <label for="major" class="col-sm-2 col-form-label">Field of Study</label>
                                                    <div class="col-sm-10">
                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        id="major" 
                                                        disabled 
                                                        value="<?= 
                                                            $grantee_grant->is_final_placement ? 
                                                                ($collage_placement->field_of_study_id ? format_value('field of study', $collage_placement->field_of_study_id) : $collage_placement->field_of_study_input) : 
                                                                $collage_placement->field_of_study_input?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="university_address" class="col-sm-2 col-form-label">University Address</label>
                                                    <div class="col-sm-10">
                                                    <input <?= !$is_admin ? 'required' : '' ?> type="text" class="form-control" id="university_address" name="arrival_report_form[university_address]" value="<?= $arrival_report_form['university_address'] ?>">
                                                    </div>
                                                </div>
                                                <!-- <div class="row mb-3">
                                                    <label for="university_email" class="col-sm-2 col-form-label">University Email</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="university_email" name="arrival_report_form[university_email]" value="<?= $arrival_report_form['university_email'] ?>">
                                                    </div>
                                                </div> -->
                                                <?php //if($grantee_grant->is_degree){ ?>
                                                <!-- <div class="row mb-3">
                                                    <label for="year" class="col-sm-2 col-form-label">Year</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="year" name="arrival_report_form[year]" value="<?= $arrival_report_form['year'] ?>">
                                                    </div>
                                                </div> -->
                                                <?php //} ?>
                                                <div class="row mb-3">
                                                    <label for="program_start_date" class="col-sm-2 col-form-label">Program Start Date</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="program_start_date" disabled value="<?= $collage_placement->start_date ? date('d M Y', strtotime($collage_placement->start_date)) : ''?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="program_end_date" class="col-sm-2 col-form-label">Program End Date</label>
                                                    <div class="col-sm-10">
                                                    <input <?= !$is_admin ? 'required' : '' ?> type="text" class="form-control datepicker" readonly style="background-color:#fff !important" id="program_end_date" name="arrival_report_form[program_end_date]" value="<?= $arrival_report_form['program_end_date'] ?>">
                                                    <a href="javascript:;" onclick="emptyValueRow(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:0; right:15px;">X</a>
                                                    </div>
                                                </div>
                                                <hr />


                                                <label class="my-4"><?= $grantee_grant->is_degree ? 'Proposed Itenerary' : 'Itenerary*' ?></label>
                                                <div class="row mb-3">
                                                    <label for="date_of_departure" class="col-sm-2 col-form-label">Date of Departure</label>
                                                    <div class="col-sm-10">
                                                    <input <?= !$is_admin ? 'required' : '' ?> type="text" class="form-control datepicker" readonly style="background-color:#fff !important" id="date_of_departure" name="arrival_report_form[date_of_departure]" value="<?= $arrival_report_form['date_of_departure'] ?>">
                                                    <a href="javascript:;" onclick="emptyValueRow(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:0; right:15px;">X</a>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="date_of_arrival" class="col-sm-2 col-form-label">Date of Arrival</label>
                                                    <div class="col-sm-10">
                                                    <input <?= !$is_admin ? 'required' : '' ?> type="text" class="form-control datepicker" readonly style="background-color:#fff !important" id="date_of_arrival" name="arrival_report_form[date_of_arrival]" value="<?= $arrival_report_form['date_of_arrival'] ?>">
                                                    <a href="javascript:;" onclick="emptyValueRow(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:0; right:15px;">X</a>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="departure_city" class="col-sm-2 col-form-label">Departure City</label>
                                                    <div class="col-sm-10">
                                                    <input <?= !$is_admin ? 'required' : '' ?> type="text" class="form-control" id="departure_city" name="arrival_report_form[departure_city]" value="<?= $arrival_report_form['departure_city'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="arrival_city" class="col-sm-2 col-form-label">Arrival City</label>
                                                    <div class="col-sm-10">
                                                    <input <?= !$is_admin ? 'required' : '' ?> type="text" class="form-control" id="arrival_city" name="arrival_report_form[arrival_city]" value="<?= $arrival_report_form['arrival_city'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="final_destination" class="col-sm-2 col-form-label">Final Destination</label>
                                                    <div class="col-sm-10">
                                                    <input <?= !$is_admin ? 'required' : '' ?> type="text" class="form-control" id="final_destination" name="arrival_report_form[final_destination]" value="<?= $arrival_report_form['final_destination'] ?>">
                                                    </div>
                                                </div>
                                                <!-- <div class="row mb-3">
                                                    <label for="home_address" class="col-sm-2 col-form-label">Home Address</label>
                                                    <div class="col-sm-10">
                                                    <textarea class="form-control" id="home_address" name="arrival_report_form[home_address]"><?= $arrival_report_form['home_address'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="phone_number_itenerary" class="col-sm-2 col-form-label">Phone Number</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="phone_number_itenerary" name="arrival_report_form[phone_number_itenerary]" value="<?= $arrival_report_form['phone_number_itenerary'] ?>">
                                                    </div>
                                                </div> -->
                                                <hr />


                                                
                                                <?php if(!$grantee_grant->is_degree){ ?>
                                                <p>* If it is different than the earlier issued ticket</p>
                                                <?php } ?>
                                                <p>** Please also select one option below:</p>
                                            
                                                <div class="form-group">
                                                    <label style="font-weight:100 !important;"Z>
                                                        <input <?= !$is_admin ? 'required' : '' ?> type="radio" class="radio-nominee"
                                                                name="arrival_report_form[plant_depart]"
                                                                <?= $arrival_report_form['plant_depart'] == 'I plan to depart (have departed) the US before the end date of my program as stated in the DS2019.' ? 'checked' : '' ?>
                                                                style="margin-top:1px" value="I plan to depart (have departed) the US before the end date of my program as stated in the DS2019.">
                                                                I plan to depart (have departed) the US before the end date of my program as stated in the DS2019.
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label style="font-weight:100 !important;"Z>
                                                        <input <?= !$is_admin ? 'required' : '' ?> type="radio" class="radio-nominee"
                                                                name="arrival_report_form[plant_depart]"
                                                                style="margin-top:1px" 
                                                                <?= $arrival_report_form['plant_depart'] == 'I plan to depart (have departed) the US during the grace period (30 days from the end date of your DS2019). *If you depart the US after the grace period end, you will not be able return to the US in the future.' ? 'checked' : '' ?>
                                                                value="I plan to depart (have departed) the US during the grace period (30 days from the end date of your DS2019). *If you depart the US after the grace period end, you will not be able return to the US in the future.">
                                                                I plan to depart (have departed) the US during the grace period (30 days from the end date of your DS2019). *If you depart the US after the grace period end, you will not be able return to the US in the future.
                                                    </label>
                                                </div>


                                                <label class="my-4">Other Information</label>
                                                <div class="row mb-3">
                                                    <label for="phone_number" class="col-sm-2 col-form-label"><?= $grantee_grant->label_returning ?? 'Have you completed your study?' ?></label>
                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <label style="font-weight:100 !important;">
                                                                <input <?= !$is_admin ? 'required' : '' ?> type="radio" class="radio-completed-study"
                                                                        <?= $arrival_report_form['have_completed_study'] == 'Yes' ? 'checked' : '' ?>
                                                                        name="arrival_report_form[have_completed_study]"
                                                                        style="margin-top:1px" 
                                                                        value="Yes">
                                                                        Yes
                                                            </label>
                                                            <label style="font-weight:100 !important;">
                                                                <input <?= !$is_admin ? 'required' : '' ?> type="radio" class="radio-completed-study"
                                                                        <?= $arrival_report_form['have_completed_study'] == 'No' ? 'checked' : '' ?>
                                                                        name="arrival_report_form[have_completed_study]"
                                                                        style="margin-top:1px" 
                                                                        value="No">
                                                                        No
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 hide section-yes">
                                                    <label for="complete_study_date" class="col-sm-2 col-form-label">Please provide the date</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control datepicker" readonly style="background-color:#fff !important" id="complete_study_date" name="arrival_report_form[complete_study_date]" value="<?= $arrival_report_form['complete_study_date'] ?>">
                                                    <a href="javascript:;" onclick="emptyValueRow(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:0; right:15px;">X</a>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 hide section-no">
                                                    <label for="complete_study_date" class="col-sm-2 col-form-label">Please check the appropriate reasons below</label>
                                                    <div class="col-sm-10">
                                                        <?php if($grantee_grant->is_degree){ ?>
                                                            <?php $this->load->view('admin/partials/returning_degree_form') ?>
                                                        <?php } else { ?>
                                                            <?php $this->load->view('admin/partials/returning_non_degree_form') ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 hide section-no">
                                                    <label for="not_finished_study" class="col-sm-2 col-form-label">If you have not finished your study, but will do so, please provide the estimate date of your study completion</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="not_finished_study" name="arrival_report_form[not_finished_study]" value="<?= $arrival_report_form['not_finished_study'] ?>">
                                                    </div>
                                                </div>

                                                <?php if($grantee_grant->is_degree){ ?>
                                                    <!-- DEGREE -->
                                                    <p>I understand that in order for me to change my flight from the issued ticket, I will cover all the expenses incurred from changing the ticket myself and I will comply with all program policies that require me to obtain a permission to extend my stay longer than the allocated period of stay, including financial statement and health insurance.</p>
                                                    <p>I certify that I have discussed my intended departure with my host institution and sponsor and I understand how my departure affects my SEVIS record and my ability to return to the U.S. in the future.</p>
                                                    <p>Please sign on the appropriate space below, electronic signature cannot be accepted. The signed form would need to be submitted to AMINEF staff to confirm that the information provided above are true and correct to the best of my knowledge. I understand that a false statement may disqualify me for applying to any AMINEF scholarship program in the future.</p>
                                                <?php } else { ?>
                                                    <!-- NON DEGREE -->
                                                    <p>I certify that I have discussed my intended departure with the IIE Student Advisor and I understand how my departure affects my SEVIS record and my ability to return to the U.S. in the future.</p>
                                                    <p>Please sign on the appropriate space below, electronic signature cannot be accepted. The signed form would need to be submitted to AMINEF staff to confirm that the information provided above are true and correct to the best of my knowledge. I understand that a false statement may disqualify me for the return ticket benefits.</p>
                                                <?php } ?>


                                                <div class="row mb-3">
                                                    <label for="full_name_signature" class="col-sm-2 col-form-label">Full Name</label>
                                                    <div class="col-sm-10">
                                                    <input <?= !$is_admin ? 'required' : '' ?> type="text" class="form-control" id="full_name_signature" name="arrival_report_form[full_name_signature]" value="<?= $arrival_report_form['full_name_signature'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="signature_date" class="col-sm-2 col-form-label">Date</label>
                                                    <div class="col-sm-10">
                                                    <input <?= !$is_admin ? 'required' : '' ?> type="text" class="form-control datepicker" readonly style="background-color:#fff !important" id="signature_date" name="arrival_report_form[signature_date]" value="<?= $arrival_report_form['signature_date'] ?>">
                                                    <a href="javascript:;" onclick="emptyValueRow(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:0; right:15px;">X</a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseUsedBordingPass" aria-expanded="false" aria-controls="collapseUsedBordingPass" onclick="return set_session('used_boarding_pass')">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Used Boarding Pass(es)
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseUsedBordingPass" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'used_boarding_pass' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <p>Submit a scanned copy of your used international boarding pass in .pdf format within 7 days of your arrival from the U.S.</p>
                                                <table class="table table-striped table-bordered table-responsive mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th width="30%">File Upload</th>
                                                            <th>Status</th>
                                                            <th>Upload Date</th>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="boarding_pass_returning_list">
                                                        <?php // FOR MULTIPLE DATA
                                                        // foreach($file_boarding_pass_returning as $ds2019) { 
                                                        //     $fileDs2019 = '';
                                                        //     if($ds2019->file_admin){
                                                        //         $ds2019_file = explode('/', $ds2019->file_admin);
                                                        //         $fileDs2019 = $ds2019_file ? end($ds2019_file) : '';
                                                        //         $detail_file = $ds2019_file ? explode('.', $fileDs2019) : '';
                                                        //     }
                                                        ?>
                                                        <tr>
                                                            <td><a href="<?= base_url($boarding_pass_returning->file) ?>" class="lightbox" style="color:#337ab7"><?= $boarding_pass_returning->filename ?></a></td>
                                                            <td>
                                                                <?= $boarding_pass_returning->status ?>
                                                                <?php if($boarding_pass_returning->status == 'Revise') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $boarding_pass_returning->note ?>" data-attach='<?= $boarding_pass_returning->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                                <?php if($boarding_pass_returning->status == 'Rejected') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $boarding_pass_returning->note_reject ?>" data-attach='<?= $boarding_pass_returning->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $boarding_pass_returning->created_date ?></td>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <td>
                                                                <input type="hidden" name="boarding_pass_returning_id" id="boarding_pass_returning_id" value="<?= $grantee_grant->id ?>">
                                                                <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_boarding_pass_returning_<?= $grantee_grant->id ?> hide">
                                                                <a 
                                                                    class="btn btn-primary btn-xs upload_departure_item show_in_alumni <?= (!$is_admin && $boarding_pass_returning->status == 'Revise') || $is_admin || $boarding_pass_returning->file == '' ? '' : 'hide' ?>" 
                                                                    data-id="<?= $grantee_grant->id ?>" 
                                                                    style="color:#fff" 
                                                                    data-document="boarding_pass_returning" 
                                                                    data-file-value="upload_boarding_pass_returning_<?= $grantee_grant->id ?>"
                                                                    data-has-file="<?= $boarding_pass_returning->file ? 1 : 0 ?>"
                                                                    data-doc-status="<?= $boarding_pass_returning->status ?>"
                                                                    >
                                                                    Upload
                                                                </a>

                                                                <?php if($is_admin) { ?>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'boarding_pass_returning')" class="btn btn-success <?= $boarding_pass_returning->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Approve
                                                                    </a>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'boarding_pass_returning')" class="btn btn-warning <?= $boarding_pass_returning->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Revise
                                                                    </a>
                                                                    <input data-log="<?= $boarding_pass_returning->id ?>" data-type="boarding_pass_returning" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $boarding_pass_returning->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                                                <?php } ?>
                                                                <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'boarding_pass_returning')" class="btn btn-danger show-button btn-xs btn-del-boarding_pass_returning <?= (!$is_admin && $boarding_pass_returning->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= $boarding_pass_returning->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                            </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php //} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseLatest_passport" aria-expanded="false" aria-controls="collapseLatest_passport" onclick="return set_session('latest_passport')">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title label-after-visa">
                                                5x5 cm Latest Passport Photo
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseLatest_passport" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'latest_passport' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <p>Submit a recent color passport photo (taken within this year) measuring 5x5 cm, with a blue background within 30 days of your arrival from the U.S. The file should be in .jpeg format and no larger than 2MB.</p>
                                                <table class="table table-striped table-bordered table-responsive mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th width="30%">File Upload</th>
                                                            <th>Status</th>
                                                            <th>Upload Date</th>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="latest_passport_list">
                                                        <?php // FOR MULTIPLE DATA
                                                        // foreach($file_latest_passport as $latest_passport) { 
                                                        //     $fileDs2019 = '';
                                                        //     if($latest_passport->file_admin){
                                                        //         $latest_passport_file = explode('/', $latest_passport->file_admin);
                                                        //         $fileDs2019 = $latest_passport_file ? end($latest_passport_file) : '';
                                                        //         $detail_file = $latest_passport_file ? explode('.', $fileDs2019) : '';
                                                        //     }
                                                        ?>
                                                        <tr>
                                                            <td><a href="<?= base_url($latest_passport->file) ?>" class="lightbox" style="color:#337ab7"><?= $latest_passport->filename ?></a></td>
                                                            <td>
                                                                <?= $latest_passport->status ?>
                                                                <?php if($latest_passport->status == 'Revise') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $latest_passport->note ?>" data-attach='<?= $latest_passport->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                                <?php if($latest_passport->status == 'Rejected') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $latest_passport->note_reject ?>" data-attach='<?= $latest_passport->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $latest_passport->created_date ?></td>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <td>
                                                                <input type="hidden" name="latest_passport_id" id="latest_passport_id" value="<?= $grantee_grant->id ?>">
                                                                <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_latest_passport_<?= $grantee_grant->id ?> hide">
                                                                <a class="btn btn-primary btn-xs upload_departure_item <?= (!$is_admin && $latest_passport->status == 'Revise') || $is_admin || $latest_passport->file == '' ? '' : 'hide' ?>" data-id="<?= $grantee_grant->id ?>" style="color:#fff" data-document="latest_passport" data-file-value="upload_latest_passport_<?= $grantee_grant->id ?>">Upload</a>
                                                                <?php if($is_admin) { ?>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'latest_passport')" class="btn btn-success <?= $latest_passport->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Approve
                                                                    </a>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'latest_passport')" class="btn btn-warning <?= $latest_passport->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Revise
                                                                    </a>
                                                                    <input data-log="<?= $latest_passport->id ?>" data-type="latest_passport" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $latest_passport->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                                                <?php } ?>
                                                                <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'latest_passport')" class="btn btn-danger show-button btn-xs btn-del-latest_passport <?= (!$is_admin && $latest_passport->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= $latest_passport->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                            </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php //} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <?php if($grantee_grant->is_degree) { ?>
                                <div class="panel panel-default">
                                    <a role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseTranscriptDiploma" aria-expanded="true" aria-controls="collapseTranscriptDiploma" onclick="return set_session('transcript_diploma')">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Final Academic Transcript and Diploma of the Award 
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseTranscriptDiploma" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'transcript_diploma' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <em>Submit your <strong>official final academic transcript</strong> and diploma in pdf. format as soon as they become available from your host university.</em>
                                                <br />
                                                <button type="button" class="btn btn-primary add_transcript_diploma show_in_alumni mt-3 <?= count($transcript_diplomas) < 2 ? '' : 'hide' ?>">Add New</button>
                                                <table class="table table-striped table-bordered table-responsive mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th width="30%">File Upload</th>
                                                            <th>Status</th>
                                                            <th>Upload Date</th>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="transcript_diploma_list">
                                                        <!-- single data -->
                                                        <!-- <tr>
                                                            <td><a href="<?= base_url($transcript_diploma->file) ?>" class="lightbox" style="color:#337ab7"><?= $transcript_diploma->filename ?></a></td>
                                                            <td>
                                                                <?= $transcript_diploma->status ?>
                                                                <?php if($transcript_diploma->status == 'Revise') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $transcript_diploma->note ?>" data-attach='<?= $transcript_diploma->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                                <?php if($transcript_diploma->status == 'Rejected') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $transcript_diploma->note_reject ?>" data-attach='<?= $transcript_diploma->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $transcript_diploma->created_date ?></td>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <td>
                                                                <input type="hidden" name="transcript_diploma_id" id="transcript_diploma_id" value="<?= $grantee_grant->id ?>">
                                                                <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_transcript_diploma_<?= $grantee_grant->id ?> hide">
                                                                <a class="btn btn-primary btn-xs upload_departure_item <?= (!$is_admin && $transcript_diploma->status == 'Revise') || $is_admin || $transcript_diploma->file == '' ? '' : 'hide' ?>" data-id="<?= $grantee_grant->id ?>" style="color:#fff" data-document="transcript_diploma" data-file-value="upload_transcript_diploma_<?= $grantee_grant->id ?>">Upload</a>

                                                                <?php if($is_admin) { ?>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'transcript_diploma')" class="btn btn-success <?= $transcript_diploma->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Approve
                                                                    </a>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'transcript_diploma')" class="btn btn-warning <?= $transcript_diploma->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Revise
                                                                    </a>
                                                                    <input data-log="<?= $transcript_diploma->id ?>" data-type="transcript_diploma" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $transcript_diploma->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                                                <?php } ?>
                                                                <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'transcript_diploma')" class="btn btn-danger show-button btn-xs btn-del-transcript_diploma <?= (!$is_admin && $transcript_diploma->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= $transcript_diploma->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                            </td>
                                                            <?php } ?>
                                                        </tr> -->

                                                        <!-- Data Multiple upload -->
                                                        <?php foreach($transcript_diplomas as $index => $transcript_diploma) { ?>
                                                        <tr id="index-transcript_diploma-<?= $index + 1 ?>">
                                                            <td><?= $transcript_diploma->type ?></td>
                                                            <td><?= $transcript_diploma->file ? '<a class="lightbox" style="color:#337ab7" href="'.base_url($transcript_diploma->file).'">'.$transcript_diploma->filename.'</a>' : '' ?></td>
                                                            <?php //if($is_admin) { ?>
                                                            <td>
                                                                <?= $transcript_diploma->status ? '<span class="badge badge-'.($transcript_diploma->status == 'Approve' ? 'success' : ($transcript_diploma->status == 'Revise' ? 'warning' : 'info')).'">'.ucfirst($transcript_diploma->status).'</span>' : '<span class="badge badge-info">Submitted</span>' ?>
                                                                <?php if($transcript_diploma->status == 'Revise') { ?>
                                                                    <span 
                                                                        class="label label-primary span-note" 
                                                                        style="width: 350px;" 
                                                                        data-toggle="modal" 
                                                                        style="cursor:pointer;" 
                                                                        data-target="#modal_note" 
                                                                        data-placement="top" 
                                                                        data-note="<?= $transcript_diploma->note ?>" 
                                                                        data-attach='<?= $transcript_diploma->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $transcript_diploma->created_date ?></td>
                                                            <?php if($is_admin || (!$is_admin && $transcript_diploma->status == 'Revise')){ ?>
                                                            <td>
                                                                <?php if($is_admin){ ?>
                                                                <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'transcript_diploma',  <?= $transcript_diploma->id ?>)" class="btn btn-success btn-xs" style="color:#fff">
                                                                    Approve
                                                                </a>
                                                                <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'transcript_diploma', <?= $transcript_diploma->id ?>)" class="btn btn-warning btn-xs" style="color:#fff">
                                                                    Revise
                                                                </a>
                                                                <?php } ?>
                                                                <a onclick="edit_data_transcript_diploma(this, <?= $transcript_diploma->id ?>, <?= $index + 1 ?>)" class="btn btn-primary btn-xs edit-transcript_diploma" style="color:#fff">
                                                                    Edit
                                                                </a>
                                                                <a href="javascript:;" onclick="del_data_transcript_diploma(this, <?= $transcript_diploma->id ?>)" class="btn btn-danger btn-xs" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                                <input data-log="<?= $transcript_diploma->id ?>" data-type="transcript_diploma" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $transcript_diploma->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                                            </td>
                                                            <?php } else { ?>
                                                                <td></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapFinalThesis" aria-expanded="false" aria-controls="collapFinalThesis" onclick="return set_session('final_thesis')">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title label-after-visa">
                                                Final Thesis or Dissertation
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapFinalThesis" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'final_thesis' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <p>Submit your approved final thesis or dissertation in .pdf format within 30 days of your arrival from the U.S.</p>
                                                <table class="table table-striped table-bordered table-responsive mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th width="30%">File Upload</th>
                                                            <th>Status</th>
                                                            <th>Upload Date</th>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="final_thesis_list">
                                                        <?php // FOR MULTIPLE DATA
                                                        // foreach($file_final_thesis as $final_thesis) { 
                                                        //     $filefinal_thesis = '';
                                                        //     if($final_thesis->file_admin){
                                                        //         $final_thesis_file = explode('/', $final_thesis->file_admin);
                                                        //         $filefinal_thesis = $final_thesis_file ? end($final_thesis_file) : '';
                                                        //         $detail_file = $final_thesis_file ? explode('.', $filefinal_thesis) : '';
                                                        //     }
                                                        ?>
                                                        <tr>
                                                            <td><a href="<?= base_url($final_thesis->file) ?>" class="lightbox" style="color:#337ab7"><?= $final_thesis->filename ?></a></td>
                                                            <td>
                                                                <?= $final_thesis->status ?>
                                                                <?php if($final_thesis->status == 'Revise') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $final_thesis->note ?>" data-attach='<?= $final_thesis->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                                <?php if($final_thesis->status == 'Rejected') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $final_thesis->note_reject ?>" data-attach='<?= $final_thesis->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $final_thesis->created_date ?></td>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <td>
                                                                <input type="hidden" name="final_thesis_id" id="final_thesis_id" value="<?= $grantee_grant->id ?>">
                                                                <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_final_thesis_<?= $grantee_grant->id ?> hide">
                                                                <a class="btn btn-primary btn-xs upload_departure_item <?= (!$is_admin && $final_thesis->status == 'Revise') || $is_admin || $final_thesis->file == '' ? '' : 'hide' ?>" data-id="<?= $grantee_grant->id ?>" style="color:#fff" data-document="final_thesis" data-file-value="upload_final_thesis_<?= $grantee_grant->id ?>">Upload</a>

                                                                <?php if($is_admin) { ?>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'final_thesis')" class="btn btn-success <?= $final_thesis->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Approve
                                                                    </a>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'final_thesis')" class="btn btn-warning <?= $final_thesis->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Revise
                                                                    </a>
                                                                    <input data-log="<?= $final_thesis->id ?>" data-type="final_thesis" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $final_thesis->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                                                <?php } ?>
                                                                <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'final_thesis')" class="btn btn-danger show-button btn-xs btn-del-final_thesis <?= (!$is_admin && $final_thesis->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= $final_thesis->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                            </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php //} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapParticipationVirtual" aria-expanded="false" aria-controls="collapParticipationVirtual" onclick="return set_session('participation_virtual')">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title label-after-visa">
                                                Participation in the Virtual Re-entry Briefing
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapParticipationVirtual" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'participation_virtual' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <p>Schedule your post-arrival briefing with AMINEF communications officers Ms. Miftahul Mardiyah (Mita) at mita@aminef.or.id and Ms. Anita Dewi at anita@aminef.or.id. Depending on availability, the briefing may be conducted virtually or in person. Please provide the details of your scheduled briefing below:</p>
                                                
                                                <div class="row mb-3">
                                                    <label for="participation_virtual_date" class="col-sm-2 col-form-label">Date</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control enable-alumni datepicker" readonly style="background-color:#fff !important" id="participation_virtual_date" name="participation_virtual_date" value="<?= $upon_return->virtual_reentry_briefing ? date('d M Y', strtotime($upon_return->virtual_reentry_briefing)) : '' ?>">
                                                    <a href="javascript:;" onclick="emptyValueRow(this)" class="btn btn-secondary btn-enable-alumni" style="color:#000;position:absolute; top:0; right:15px;">X</a>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="participation_virtual_time" class="col-sm-2 col-form-label">Time</label>
                                                    <div class="col-sm-10">
                                                    <input type="input" class="form-control enable-alumni flatpickrTime" id="participation_virtual_time" name="participation_virtual_time" value="<?= $upon_return->virtual_reentry_briefing ? date('H:i', strtotime($upon_return->virtual_reentry_briefing)) : '' ?>" style="background-color:#fff !important">
                                                    <a href="javascript:;" onclick="emptyTimeValueRow(this)" class="btn btn-secondary btn-enable-alumni" style="color:#000;position:absolute; top:0; right:15px;">X</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <?php if($grantee_grant->program_phd) { ?>
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapParticipationFulbright" aria-expanded="false" aria-controls="collapParticipationFulbright" onclick="return set_session('participation_fulbright')">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title label-after-visa">
                                                Participation in the Fulbright Research Presentation
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapParticipationFulbright" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'participation_fulbright' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <p>Coordinate your Fulbright Research Presentation with AMINEF communications officers Ms. Miftahul Mardiyah (Mita) at mita@aminef.or.id and Ms. Anita Dewi at anita@aminef.or.id. Review the Presentation Guideline provided below:</p>

                                                <a href="<?= base_url($grantee_grant->guideline_research_presentation) ?>" download title="Click to Download" class="btn btn-primary mb-2 <?= $grantee_grant->guideline_research_presentation ? '' : 'hide' ?>" style="color:#fff">
                                                    <i class="fa fa-download fa-fw text-white"></i> Guideline for Fulbright Research Presentation
                                                </a>
                                                <p>Submit your Fulbright Research Presentation Materials in pdf. format below:</p>

                                                <table class="table table-striped table-bordered table-responsive mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th width="30%">File Upload</th>
                                                            <th>Status</th>
                                                            <th>Upload Date</th>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="participation_fulbright_list">
                                                        <?php // FOR MULTIPLE DATA
                                                        // foreach($file_participation_fulbright as $participation_fulbright) { 
                                                        //     $fileparticipation_fulbright = '';
                                                        //     if($participation_fulbright->file_admin){
                                                        //         $participation_fulbright_file = explode('/', $participation_fulbright->file_admin);
                                                        //         $fileparticipation_fulbright = $participation_fulbright_file ? end($participation_fulbright_file) : '';
                                                        //         $detail_file = $participation_fulbright_file ? explode('.', $fileparticipation_fulbright) : '';
                                                        //     }
                                                        ?>
                                                        <tr>
                                                            <td><a href="<?= base_url($participation_fulbright->file) ?>" class="lightbox" style="color:#337ab7"><?= $participation_fulbright->filename ?></a></td>
                                                            <td>
                                                                <?= $participation_fulbright->status ?>
                                                                <?php if($participation_fulbright->status == 'Revise') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $participation_fulbright->note ?>" data-attach='<?= $participation_fulbright->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                                <?php if($participation_fulbright->status == 'Rejected') { ?>
                                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $participation_fulbright->note_reject ?>" data-attach='<?= $participation_fulbright->attachment_revise ?>'>i</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $participation_fulbright->created_date ?></td>
                                                            <?php if(!$is_alumni_page) { ?>
                                                            <td>
                                                                <input type="hidden" name="participation_fulbright_id" id="participation_fulbright_id" value="<?= $grantee_grant->id ?>">
                                                                <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_participation_fulbright_<?= $grantee_grant->id ?> hide">
                                                                <a 
                                                                    class="btn btn-primary btn-xs show_in_alumni upload_departure_item <?= (!$is_admin && $participation_fulbright->status == 'Revise') || $is_admin || $participation_fulbright->file == '' ? '' : 'hide' ?>" 
                                                                    data-id="<?= $grantee_grant->id ?>" 
                                                                    style="color:#fff" 
                                                                    data-document="participation_fulbright" 
                                                                    data-file-value="upload_participation_fulbright_<?= $grantee_grant->id ?>"
                                                                    data-has-file="<?= $participation_fulbright->file ? 1 : 0 ?>"
                                                                    data-doc-status="<?= $participation_fulbright->status ?>"
                                                                >
                                                                    Upload
                                                                </a>
                                                                <?php if($is_admin) { ?>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'participation_fulbright')" class="btn btn-success <?= $participation_fulbright->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Approve
                                                                    </a>
                                                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'participation_fulbright')" class="btn btn-warning <?= $participation_fulbright->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                        Revise
                                                                    </a>
                                                                    <input data-log="<?= $participation_fulbright->id ?>" data-type="participation_fulbright" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $participation_fulbright->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                                                <?php } ?>
                                                                <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'participation_fulbright')" class="btn btn-danger show-button btn-xs btn-del-participation_fulbright <?= (!$is_admin && $participation_fulbright->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= $participation_fulbright->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                            </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php //} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php //if($grantee_grant->is_degree) { ?>
                                <!-- <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseHotelAllowance" aria-expanded="false" aria-controls="collapseHotelAllowance" onclick="return set_session('hotel_allowance')">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title label-after-visa">
                                                Hotel Allowance, Excess Baggage and Travel Allowance
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseHotelAllowance" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'hotel_allowance' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="panel-body">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Hotel Allowance </label>
                                                            <input type="text" id="hotel_allowance" class="form-control currency-usd" name="hotel_allowance" <?= $is_admin ? '' : 'disabled' ?> value="<?= $upon_return->hotel_allowance ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Excess Baggage and Travel Allowance</label>
                                                            <input type="text" id="travel_allowance" class="form-control currency-usd" name="travel_allowance" <?= $is_admin ? '' : 'disabled' ?> value="<?= $upon_return->travel_allowance ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <p>AMINEF will transfer the allowances in US Dollar (USD) to your local account in Indonesia in a Rupiah (IDR) or US Dollar account (USD) account.
                                                    <br /><b><u>Note: AMINEF will NOT be held responsible for the exchange rate fluctuation upon receiving the fund in your account.</u></b></p>
                                                    <p>Please select the bank account that you want to use to transfer this allowance:</p>
                                                    <div class="panel-body">
                                                        <div class="col-lg-8">
                                                            <div class="form-group">
                                                                <label>Bank Info</label>
                                                                <select id="bank_info_id" class="form-control select2" style="width:100%" form="form" name="bank_info_id">
                                                                    <option value=''>-- Select --</option>
                                                                    <?php foreach ($bank_info as $kb => $bi) { ?>
                                                                        <option <?= $upon_return->bank_info_id == $bi->id ? 'selected' : '' ?> value="<?= $bi->id ?>"><?= $bi->beneficiary_name ?> (<?= $bi->account_number ?>) - <?= $bi->bank_name ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Bank Name</label>
                                                                <input type="text" class="form-control" name="bank_name" id="bank_name" readonly placeholder="Bank Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Bank Address</label>
                                                                <input type="text" class="form-control" name="bank_address" id="bank_address" readonly placeholder="Bank Address">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Beneficiary Name</label>
                                                                <input type="text" class="form-control" name="beneficiary_name" id="beneficiary_name" readonly placeholder="Beneficiary Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Account Number</label>
                                                                <input type="text" class="form-control" name="account_number" id="account_number" readonly placeholder="Account Number">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Routing Number</label>
                                                                <input type="text" class="form-control" name="routing_number" id="routing_number" readonly placeholder="Routing Number">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Swift Code</label>
                                                                <input type="text" class="form-control" name="swift_code" id="swift_code" readonly placeholder="Swift Code">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Currency</label>
                                                                <input type="text" class="form-control" name="currency" id="currency" readonly placeholder="Currency">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>First page of bank account information (buku tabungan halaman pertama)</label>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                                    <a href="" class="lightbox aimage hide" aria-haspopup="dialog">
                                                                        <img id="preview_image_account_book" src="" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="" id="button_download_account_book" download title="Click to download" class="btn btn-primary btn-xs mt-5 hide" style="position:absolute; top:-30px; right:-28px;color:#fff">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                </div>
                                                                <a href="" id="button_preview_account_book" class="btn btn-warning fileview lightbox preview-profile hide" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p><b>Note : </b><i>If the bank account information has not been listed in the bank info, you need to declare your bank account information in My Profile” page of the “Personal Information” section with “Bank Info” </i></p>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                    </div>
                                </div> -->
                                <?php //} ?>
                            </div>

                            <?php if(!$is_alumni_page) { ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="pull-right">
                                        <button type="button" name="btn" value="save_upon_return" id="submit_returning" class="btn btn-success btn-enable-alumni">Save</button>
                                        <!-- <button type="button" name="btn" value="save_upon_return" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_upon_return')" class="btn btn-success btn-enable-alumni">Save</button> -->
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- Transportation Accomodation -->
                        <div id="transportation_accomodation" class="active in first_tab hide">
                            <div class="panel-group" id="accordionThree" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionThree" href="#collapseFourTravelInternational" aria-expanded="false" aria-controls="collapseFourTravelInternational" onclick="set_session('travel_arrangement_international');">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                            International Ticket
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseFourTravelInternational" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'travel_arrangement_international' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                        <div class="panel-body">
                                            <div class="col-lg-12">
                                                <p class="mt-4">International Ticket</p>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>University</label>
                                                        <?php 
                                                        $univ_id = $collage_placement->university_id; 
                                                        ?>
                                                        <input type="hidden" id="id_univ_grantee" value="<?= $univ_id ?>">
                                                        <input type="text" class="form-control" value="<?= $univ_id ? get_university_by_id($univ_id)->name : '' ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"> <!-- jika tidak ada pre-academic -->
                                                    <div class="form-group">
                                                        <label>Arrival Date</label>
                                                        <input <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') ? 'disabled' : '' ?> id="arrival_date_international" type="text" class="form-control datepicker" readonly style="background-color:<?= (!$is_admin &&  $returning->save_grantee) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#eee' : '#fff' ?>" placeholder="Departure Date" name="arrival_date_international" value="<?= $returning->arrival_date_international ? date('d M Y', strtotime($returning->arrival_date_international)) : '' ?>">
                                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Departure City</label>
                                                        <input id="departure_city_international" type="text" class="form-control" placeholder="Departure City" name="departure_city_international" value="<?= $returning && $returning->departure_city_international != '' ? $returning->departure_city_international : 'Jakarta' ?>" <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || !$is_admin ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Arrival City</label>
                                                        <input id="arrival_city_international" type="text" class="form-control" placeholder="Arrival City" name="arrival_city_international" value="<?= $returning ? $returning->arrival_city_international : '' ?>" <?= $this->session->userdata('role') != 'travel-booking-assistant' ? '' : 'disabled';?>>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Arrival Airport</label>
                                                        <input id="arrival_airport_international" type="text" class="form-control" placeholder="Arrival Airport" name="arrival_airport_international" value="<?= $returning ? $returning->arrival_airport_international : '' ?>" <?= $this->session->userdata('role') != 'travel-booking-assistant' ? '' : 'disabled';?>>
                                                    </div>
                                                </div>
                                                <?php if (($returning && $returning->eticket_international != '') || $is_admin) { ?>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>E-Ticket</label>
                                                        <?php if($is_admin) { ?>
                                                        <input id="eticket_international" type="file" class="form-control" name="eticket_international">
                                                        <?php } ?>
                                                        <?php if ($returning && $returning->eticket_international != '') { ?>
                                                            <br>
                                                            <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket_international">
                                                                <a href="<?=base_url() ?><?=$returning->eticket_international ?>" class="lightbox" aria-haspopup="dialog">
                                                                    <img id="preview_image_profile" data-old="<?php echo site_url($returning->eticket_international); ?>" src="<?php echo get_preview($returning->eticket_international); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                </a>
                                                                <a href="<?=base_url() ?><?=$returning->eticket_international ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($returning->eticket_international) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                                    <i class="fa fa-download fa-fw"></i>
                                                                </a>
                                                                <?php if($is_admin) { ?>
                                                                <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                    <label class="btn btn-xs btn-danger" onclick="delete_file_returning(this, 'eticket_international', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                                </a>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionThree" href="#collapseFourTravelDomestic" aria-expanded="false" aria-controls="collapseFourTravelDomestic" onclick="set_session('travel_arrangement');">
                                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                            Domestic Ticket
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseFourTravelDomestic" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'travel_arrangement' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <p>Travel Arrangement</p>
                                            <?php if($returning) { ?>
                                            <input type="hidden" name="returning_id" value="<?= $returning->id ?>">
                                            <?php } ?>
                                            <?php if($has_permission || !$is_admin) { ?>
                                            <div class="form-group">
                                                <ul>
                                                    <?php if(!$is_admin) { ?>
                                                        <input id="show_transportation_domestic" class="select_show hide" value="<?= $returning->show_transportation_domestic ?>">
                                                        <input id="show_accommodation_domestic" class="select_show hide" value="<?= $returning->show_accommodation_domestic ?>">
                                                    <?php } ?>
                                                    <?php if($is_admin && has_permission('returning', 'detail')) { ?>
                                                    <label class="mt-3">Show Domestic Transportation</label>
                                                    <select class="form-control select_show" name="show_transportation_domestic" id="show_transportation_domestic">
                                                        <option value="">- Select -</option>
                                                        <option <?= $returning->show_transportation_domestic == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $returning->show_transportation_domestic == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $returning->show_transportation_domestic == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                    </select>
    
                                                    <label class="mt-3">Show Domestic Accommodation</label>
                                                    <select class="form-control select_show" name="show_accommodation_domestic" id="show_accommodation_domestic">
                                                        <option value="">- Select -</option>
                                                        <option <?= $returning->show_accommodation_domestic == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                                        <option <?= $returning->show_accommodation_domestic == 'No' ? 'selected' : '' ?> value="No">No</option>
                                                        <option <?= $returning->show_accommodation_domestic == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                                                    </select>

                                                    <?php if(!$is_alumni_page) { ?>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-12">
                                                            <div class="TriSea-technologies-Switch">
                                                                <span class="mr-2"> Enable Transportation Grantee</span>
                                                                <input id="grantee_submit" name="grantee_submit" type="checkbox" <?= $returning->grantee_submit  ? 'checked' : '' ?>/>
                                                                <label for="grantee_submit" class="label-primary"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php 
                                                        $disable_transportation = '';
                                                        $show_transportation = true;
                                                        $style_transportation = '#fff';
                                                        $complete_transport = false;

                                                        if(!$is_admin){
                                                            if($returning->departure_date_domestic && $returning->departure_city_domestic && $returning->arrival_city_domestic && $returning->eticket_domestic){
                                                                $complete_transport = true;
                                                            }
    
                                                            if($returning->show_transportation_domestic == 'Yes'){
                                                                $disable_transportation = 'disabled';
                                                                $style_transportation = '#eee';
                                                                $show_transportation = false;
                                                            }else if($returning->show_transportation_domestic == 'Reimbursement'){
                                                                if(!$returning->grantee_submit && $complete_transport){
                                                                    $disable_transportation = 'disabled';
                                                                    $style_transportation = '#eee';
                                                                    $show_transportation = false;
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    
                                                    <li class="<?= $returning->show_transportation_domestic == 'Yes' || $returning->show_accommodation_domestic == 'Yes' || $returning->show_transportation_domestic == 'Reimbursement' || $returning->show_accommodation_domestic == 'Reimbursement' ? '' : 'hide' ?> section-domestic mt-4">Domestic Ticket</li>
                                                    <div class="panel-body <?= $returning->show_transportation_domestic == 'Yes' || $returning->show_transportation_domestic == 'Reimbursement' ? '' : 'hide' ?> section-transportation-domestic" style="margin-top:-20px">
                                                        <div class="col-lg-12">
                                                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure Date</label>
                                                                <input 
                                                                    id="departure_date_domestic" 
                                                                    type="text" 
                                                                    <?= $disable_transportation ?> 
                                                                    class="form-control datepicker" 
                                                                    readonly style="background-color:<?= $style_transportation ?>" 
                                                                    placeholder="Departure Date" 
                                                                    name="departure_date_domestic" 
                                                                    value="<?= $returning  ? ($returning->departure_date_domestic != '' ? date('d M Y', strtotime($returning->departure_date_domestic)) : '') : '' ?>" 
                                                                    <?= (!$is_admin) || $this->session->userdata('role') == 'travel-booking-assistant' ? ($returning->show_transportation_domestic == 'Reimbursement' ? '' : '') : '' ?>>
                                                                    <?php if($show_transportation) { ?>
                                                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                                    <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Departure City</label>
                                                                <input <?= $disable_transportation ?> id="departure_city_domestic" type="text" class="form-control" placeholder="Departure City" name="departure_city_domestic" value="<?= $returning ? $returning->departure_city_domestic : '' ?>" <?= (!$is_admin) || $this->session->userdata('role') == 'travel-booking-assistant' ? ($returning->show_transportation_domestic == 'Reimbursement' ? '' : '') : '' ?>>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Arrival City</label>
                                                                <input <?= $disable_transportation ?> id="arrival_city_domestic" type="text" class="form-control" placeholder="Destination City" name="arrival_city_domestic" value="<?= $returning ? $returning->arrival_city_domestic : '' ?>" <?= (!$is_admin) || $this->session->userdata('role') == 'travel-booking-assistant' ? ($returning->show_transportation_domestic == 'Reimbursement' ? '' : '') : '' ?>>
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
                                                        <?php if (($returning && $returning->eticket_domestic != '') || $show_transportation) { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_eticket_domestic">E-Ticket</label>
                                                                <?php if($show_transportation) { ?>
                                                                <input id="eticket_domestic" type="file" class="form-control <?= $show_transportation ? '' : 'hide' ?>" name="eticket_domestic">
                                                                <?php } ?>
                                                                <?php if ($returning && $returning->eticket_domestic != '') { ?>
                                                                    <br>
                                                                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_eticket_domestic">
                                                                        <a href="<?=base_url() ?><?=$returning->eticket_domestic ?>" class="lightbox" aria-haspopup="dialog">
                                                                            <img id="preview_image_profile" data-old="<?php echo site_url($returning->eticket_domestic); ?>" src="<?php echo get_preview($returning->eticket_domestic); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                        </a>
                                                                        <a href="<?=base_url() ?><?=$returning->eticket_domestic ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($returning->eticket_domestic) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                                                            <i class="fa fa-download fa-fw"></i>
                                                                        </a>
                                                                        <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer" class="<?= $show_transportation ? '' : 'hide'  ?>">
                                                                            <label class="btn btn-xs btn-danger" onclick="delete_file_returning(this, 'eticket_domestic', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                                        </a>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
    
                                                    <div class="panel-body <?= $returning->show_accommodation_domestic == 'Yes' ? '' : 'hide' ?> section-accomodation-domestic" style="margin-top:-20px">
                                                        <div class="col-lg-12">
                                                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Check In Date</label>
                                                                <input 
                                                                    id="checkin_date_domestic" 
                                                                    type="text" 
                                                                    class="form-control datepicker" 
                                                                    readonly style="background-color:<?= !$is_admin || $this->session->userdata('role') == 'travel-booking-assistant' ? ($returning->show_accommodation_domestic == 'Reimbursement' ? '#fff' : '#fff') : '#fff' ?>" 
                                                                    placeholder="Check In Date" 
                                                                    name="checkin_date_domestic" 
                                                                    value="<?= $returning  ? ($returning->checkin_date_domestic != '' ? date('d M Y', strtotime($returning->checkin_date_domestic)) : '') : '' ?>"
                                                                    <?= (!$is_admin) || $this->session->userdata('role') == 'travel-booking-assistant' ? ($returning->show_accommodation_domestic == 'Reimbursement' ? '' : '') : '' ?>>
                                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Check Out Date</label>
                                                                <input 
                                                                    id="checkout_date_domestic" 
                                                                    type="text" 
                                                                    class="form-control datepicker" 
                                                                    readonly style="background-color:<?= !$is_admin || $this->session->userdata('role') == 'travel-booking-assistant' ? ($returning->show_accommodation_domestic == 'Reimbursement' ? '#fff' : '#fff') : '#fff' ?>" 
                                                                    placeholder="Check Out Date" 
                                                                    name="checkout_date_domestic" 
                                                                    value="<?= $returning  ? ($returning->checkout_date_domestic != '' ? date('d M Y', strtotime($returning->checkout_date_domestic)) : '') : '' ?>"
                                                                    <?= (!$is_admin) || $this->session->userdata('role') == 'travel-booking-assistant' ? ($returning->show_accommodation_domestic == 'Reimbursement' ? '' : '') : '' ?>>
                                                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                                            </div>
                                                        </div>
                                                        <?php if (($grantee_grant && $returning->voucher_hotel_domestic != '') || $is_admin || $returning->show_accommodation_domestic == 'Reimbursement') { ?>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label id="label_voucher_hotel_domestic">Hotel Voucher</label>
                                                                <?php if($is_admin || $returning->show_accommodation_domestic == 'Reimbursement') { ?>
                                                                <input id="voucher_hotel_domestic" type="file" class="form-control" name="voucher_hotel_domestic">
                                                                <?php } ?>
                                                                <?php if ($grantee_grant && $returning->voucher_hotel_domestic != '') { ?>
                                                                <br>
                                                                <div style="margin-bottom:10px; position:relative; width:100px;" id="file_voucher_hotel_domestic">
                                                                    <a href="<?=base_url() ?><?=$returning->voucher_hotel_domestic ?>" class="lightbox" aria-haspopup="dialog">
                                                                        <img id="preview_image_profile" data-old="<?php echo site_url($returning->voucher_hotel_domestic); ?>" src="<?php echo get_preview($returning->voucher_hotel_domestic); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                                    </a>
                                                                    <a href="<?=base_url() ?><?=$returning->voucher_hotel_domestic ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($returning->voucher_hotel_domestic) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                                                        <i class="fa fa-download fa-fw"></i>
                                                                    </a>
                                                                    <?php if($is_admin) { ?>
                                                                    <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                                                        <label class="btn btn-xs btn-danger" onclick="delete_file_returning(this, 'voucher_hotel_domestic', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                                                    </a>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
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
                                        <button type="button" name="btn" value="save_transport_accommodation" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_transport_accommodation')" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- After You return -->
                        <div id="after_you_return" class="active in first_tab hide">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <?php if($grantee_grant->is_degree) { ?>
                                        <table class="table table-striped table-bordered table-responsive mt-4">
                                            <thead>
                                                <tr>
                                                    <th width="30%">File</th>
                                                    <th width="30%">File Upload</th>
                                                    <th>Status</th>
                                                    <th>Upload Date</th>
                                                    <?php if(!$is_alumni_page) { ?>
                                                    <th>Action</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody id="transcript_list">
                                                <tr>
                                                    <td>Transcript</td>
                                                    <td><a href="<?= base_url($transcript->file) ?>" class="lightbox" style="color:#337ab7"><?= $transcript->filename ?></a></td>
                                                    <td>
                                                        <?= $transcript->status ?>
                                                        <?php if($transcript->status == 'Revise') { ?>
                                                            <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $transcript->note ?>" data-attach='<?= $transcript->attachment_revise ?>'>i</span>
                                                        <?php } ?>
                                                        <?php if($transcript->status == 'Rejected') { ?>
                                                            <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $transcript->note_reject ?>" data-attach='<?= $transcript->attachment_revise ?>'>i</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $transcript->created_date ?></td>
                                                    <?php if(!$is_alumni_page) { ?>
                                                    <td>
                                                        <input type="hidden" name="transcript_id" id="transcript_id" value="<?= $grantee_grant->id ?>">
                                                        <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_transcript_<?= $grantee_grant->id ?> hide">
                                                        <a class="btn btn-primary btn-xs upload_departure_item <?= !$is_admin && $transcript->status == 'Approve' ? 'hide' : '' ?>" data-id="<?= $grantee_grant->id ?>" style="color:#fff" data-document="transcript" data-file-value="upload_transcript_<?= $grantee_grant->id ?>">Upload</a>

                                                        <?php if($is_admin) { ?>
                                                            <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'transcript')" class="btn btn-success <?= $transcript->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                Approve
                                                            </a>
                                                            <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'transcript')" class="btn btn-warning <?= $transcript->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                Revise
                                                            </a>
                                                            <input data-log="<?= $transcript->id ?>" data-type="transcript" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $transcript->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                                        <?php } ?>
                                                        <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'transcript')" class="btn btn-danger show-button btn-xs btn-del-transcript <?= !$is_admin && $transcript->status == 'Approve' ? 'hide' : '' ?> <?= $transcript->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td>Diplomas</td>
                                                    <td><a href="<?= base_url($diploma->file) ?>" class="lightbox" style="color:#337ab7"><?= $diploma->filename ?></a></td>
                                                    <td>
                                                        <?= $diploma->status ?>
                                                        <?php if($diploma->status == 'Revise') { ?>
                                                            <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $diploma->note ?>" data-attach='<?= $diploma->attachment_revise ?>'>i</span>
                                                        <?php } ?>
                                                        <?php if($diploma->status == 'Rejected') { ?>
                                                            <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $diploma->note_reject ?>" data-attach='<?= $diploma->attachment_revise ?>'>i</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $diploma->created_date ?></td>
                                                    <?php if(!$is_alumni_page) { ?>
                                                    <td>
                                                        <input type="hidden" name="diploma_id" id="diploma_id" value="<?= $grantee_grant->id ?>">
                                                        <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_diploma_<?= $grantee_grant->id ?> hide">
                                                        <a class="btn btn-primary btn-xs upload_departure_item <?= !$is_admin && $diploma->status == 'Approve' ? 'hide' : '' ?>" data-id="<?= $grantee_grant->id ?>" style="color:#fff" data-document="diploma" data-file-value="upload_diploma_<?= $grantee_grant->id ?>">Upload</a>

                                                        <?php if($is_admin) { ?>
                                                            <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'diploma')" class="btn btn-success <?= $diploma->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                Approve
                                                            </a>
                                                            <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'diploma')" class="btn btn-warning <?= $diploma->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                                                Revise
                                                            </a>
                                                            <input data-log="<?= $diploma->id ?>" data-type="diploma" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $diploma->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                                        <?php } ?>
                                                        <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'diploma')" class="btn btn-danger show-button btn-xs btn-del-diploma <?= !$is_admin && $diploma->status == 'Approve' ? 'hide' : '' ?> <?= $diploma->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php } ?>
                                        <hr />
                                    </div>

                                    <?php //if($is_admin || (!$is_admin && $returning->certificate)) { ?>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label id="label-certificate">Certificate</label>
                                                <?php 
                                                    $certificate = user_grantee_file_url($returning, 'certificate');
                                                ?>
                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                    <a href="<?php echo $returning->certificate ? site_url($returning->certificate) : '#' ?>" class="lightbox link-image" aria-haspopup="dialog">
                                                        <img id="preview_certificate" data-old="<?php echo site_url($certificate); ?>" src="<?php echo get_preview($certificate); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                    </a>
                                                    <?php //if($is_admin) { ?>
                                                    <a href="javascript:;" onclick="delete_certificate(this, <?= $grantee_grant->id ?>)" id="button_delete_certificate" class="btn btn-danger btn-xs <?php echo empty($returning->certificate) ? 'hide' : ''; ?>" style="position:absolute; top:0; right:-28px;color:#fff;">
                                                        <i class="fa fa-trash fa-fw"></i>
                                                    </a>
                                                    <?php //} ?>
                                                </div>
                                                <?php //if($is_admin) { ?>
                                                    <?php if(!$is_alumni_page) { ?>
                                                    <input type="file" class="custom-file-input hide" accept="<?php foreach(ALLOWED_PROFILE_FILETYPE as $filetype) { echo ($filetype == "pdf" ? "application/" : "image/") . $filetype . ","; } ?>" id="certificate" onchange="show_preview_certificate(this);">
                                                    <label class="btn btn-primary upload-button" for="certificate"> Choose file </label> 
                                                    <?php } ?>
                                                <?php //} ?>
                                                <a download title="Click to download" href="<?php echo site_url($certificate) ?>" id="button_download_certificate" class="btn btn-primary <?php echo empty($returning->certificate) ? 'hide' : ''; ?>" style="color:#fff;display:inline-block"><i class="fa fa-download fa-fw"></i> Download Cerficate</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php //} ?>
                                    <!-- <div class="pull-right">
                                        <button type="button" name="btn" value="save_post_degree" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_post_degree')" class="btn btn-success">Save</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<?php $this->session->unset_userdata('last_tab'); ?>
<?php $this->session->unset_userdata('last_list'); ?>
<?php $this->load->view('admin/partials/form_appointment_ongoing') ?>
<?php $this->load->view('admin/partials/form_appointment_ongoing_dependent') ?>


<!-- MODALS -->
<?php $this->load->view('admin/partials/modal_log') ?>
<?php $this->load->view('admin/partials/modal_note') ?>
<?php $this->load->view('admin/partials/modal_upload_ds2019_ongoing') ?>

<div class="modal fade" id="mdl_note_revise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Note</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="submission_plan_id" id="submission_plan_id">
                <div class="row" id="section_reason_rejection">
                    <div class="col-md-12">
                        <label>Attachment</label>
                        <label for="temp_attachment_revise" class="withdraw-attachment-area">
                            <input type="file" id="temp_attachment_revise" name="temp_attachment_revise" class="hide" onchange="show_preview_attch(this, 'attachment_revise', 'attachment_revise');">
                            <input type="text" id="attachment_revise" name="attachment_revise" class="hide">
                            <i class="fa fa-cloud-upload"></i>
                        </label>
                        <div class="col-md-12 text-center">
                            <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
				            <label>Note</label>
                            <textarea class="form-control" name="note_revise" id="note_revise" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-save-note" name="btn-submit" value="decline" class="btn btn-primary success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="add_transcript_diploma" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitleDeadline">Add Final Academic Transcript and Diploma of the Award </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" id="form_transcript_diploma">
            <input type="hidden" class="fields_transcript_diploma enable-alumni transcript_diploma_id" name="transcript_diploma_id" id="transcript_diploma_id">
            <input type="hidden" class="fields_transcript_diploma enable-alumni index_transcript_diploma" name="index_transcript_diploma">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Type <?= label_required(true) ?></label>
                            <select name="type" id="type" class="form-control fields_transcript_diploma enable-alumni" required>
                                <option value="">-- Select --</option>
                                <option value="Transcript">Transcript</option>
                                <option value="Diploma">Diploma</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>File <?= label_required(true) ?></label>
                            <input type="file" class="form-control fields_transcript_diploma enable-alumni file_transcript_diploma" name="file_transcript_diploma" required>
                            <span id="file-name-transcript_diploma"></span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary show_in_alumni" data-dismiss="modal">Close</button>
            <button type="submit" form="form_transcript_diploma" class="btn btn-primary show_in_alumni" id="btn-add-transcript_diploma">Save</button>
        </div>
    </div>
  </div>
</div>

