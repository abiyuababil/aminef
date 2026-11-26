<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$pid = $this->input->get('pid');
if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>
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

    .table-ds160 th {
        text-align: center;
    }

    .span-note:hover {
        background-color: #df7401;
        cursor: pointer;
    }
    .is_unlimited_label {
        font-size: 13px;
        font-weight: inherit;
        font-style: italic;
        cursor: pointer;
        user-select: none
    }

    .require{
        color: red;
    }

    #memo_revision th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #ebebeb;
    color: #7da2bd;
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

    .sortable-row {
        cursor:grab !important;
    }

    .table-list-grantee>thead>tr>th {
        background: none !important;
        border-bottom: 2px solid #e9eef4 !important;
    }
    .table-list-grantee-edit>thead>tr>th {
        background: none !important;
        border-bottom: 2px solid #e9eef4 !important;
    }

    .card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        font-size: 12px;
    }
</style>

<style>
    .select2-container .select2-selection {
        max-height: 100px;
        overflow: auto;
    }

    .data-header {
        padding-top: 10px !important;
    }

    .program-filter-section {
        display: flex;
    }

    .program-filter-section > .form-group {
        width: 50px;
        margin-left: 12px;
    }

    .select2-container--bootstrap .select2-selection {
        border-radius: 0px !important;
    }

    .select2-selection--single > .select2-selection__rendered {
        margin-top: 5px !important;
    }

    .select2-selection--single {
        overflow: hidden !important;
    }

    label {
        font-weight: normal !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1><?php echo $title ?></h1>
        <h3 class="page-header"><?= $sub_title ?></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if($this->session->flashdata('success_period')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success_period') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success_period');?>
<?php if($this->session->flashdata('failed_period')) { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('failed_period') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('failed_period');?>
    <div class="row">
        <?php if($is_edit){ ?>
        <div class="col-lg-12" style="margin-bottom:10px">  
            <ul class="nav nav-pills">
                <li id="li_info" <?php echo $default_tab_active ?>><a data-toggle="tab" href="#info" aria-expanded="true">Detail Period</a></li>
                <li <?= $pid == 'document' ? 'class="active"' : '' ?> id="li_doc"><a data-toggle="tab" href="#doc" aria-expanded="true">Documents</a></li>
                <li id="li_pdo"><a data-toggle="tab" href="#pdo" aria-expanded="true">Pre Departure Orientation</a></li>
                <!-- <li <?= $pid == 'payment' ? 'class="active"' : '' ?> id="li_payment"><a data-toggle="tab" href="#payment" aria-expanded="true">Panelist Payment</a></li> -->
                <li <?= $pid == 'payment_bulk' ? 'class="active"' : '' ?> id="li_payment"><a data-toggle="tab" href="#payment_bulk" aria-expanded="true">Bulk Panelist Payment</a></li>
                <li <?= $pid == 'payment_grantee' ? 'class="active"' : '' ?> id="li_payment"><a data-toggle="tab" href="#payment_grantee" aria-expanded="true">Bulk Grantee Payment</a></li>
                <li id="li_min_score"><a data-toggle="tab" href="#min_score" aria-expanded="true">Score</a></li>
                <li <?= $pid == 'english_test_score' ? 'class="active"' : '' ?> id="li_english_test_score"><a data-toggle="tab" href="#english_test_score" aria-expanded="true">English Test Score</a></li>
                <li <?= $pid == 'review' ? 'class="active"' : '' ?> id="li_review"><a data-toggle="tab" href="#review" aria-expanded="true">Review</a></li>
                <li <?= $pid == 'interview_evaluation' ? 'class="active"' : '' ?> id="li_interview_evaluation"><a data-toggle="tab" href="#interview_evaluation" aria-expanded="true">Interview</a></li>
                <li <?= $pid == 'email_template' ? 'class="active"' : '' ?> id="li_email_template"><a data-toggle="tab" href="#email_template" aria-expanded="true">Template Email</a></li>
                <li <?= $pid == 'submission_ongoing' ? 'class="active"' : '' ?> id="li_submission_ongoing"><a data-toggle="tab" href="#submission_ongoing" aria-expanded="true">Submission Ongoing</a></li>
                <li <?= $pid == 'grant_pages' ? 'class="active"' : '' ?> id="li_grant_pages"><a data-toggle="tab" href="#grant_pages" aria-expanded="true">Grant Pages</a></li>
            </ul>
        </div>
        <?php } ?>
        <div class="tab-content">
            <div id="info" class="tab-pane fade <?= $default_content_active ?>">
                <form id="form" role="form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="input_info">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label> Academic Year <span class="require">*</span></label>
                        <select class="form-control select2" name="fiscal_year" id="fiscal_year" required>
                            <option value="">-- Select Year --</option>
                            <?php
                            $current_year = date('Y', strtotime('+10 years'));
                            //$limit_year = $current_year - 20;
                            $limit_year = 1952;
                            for ($year = $current_year; $year >= $limit_year; $year--) {
                                $selected = '';
                                if ($this->User_grantee_grant_period_model->fiscal_year == $year) {
                                    $selected = 'selected="selected"';
                                }
                            ?>
                                <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label> Start Registration Date <?php // $this->User_grantee_grant_period_model->fiscal_year == date('Y') ? '<span class="require">*</span>' : '' ?></label>
                        <input 
                            class="form-control datepicker" 
                            autocomplete="off" 
                            name="start_date" 
                            value="<?php echo (isset($this->User_grantee_grant_period_model->start_date)) ? date('d M Y', strtotime($this->User_grantee_grant_period_model->start_date)) : '' ?>" 
                            <?php // $this->User_grantee_grant_period_model->fiscal_year == date('Y') ? 'required' : '' ?>
                        >
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label> Start Registration Time <?php // $this->User_grantee_grant_period_model->fiscal_year == date('Y') ? '<span class="require">*</span>' : '' ?></label>
                        <input 
                            type="time"
                            class="form-control" 
                            autocomplete="off" 
                            name="start_time" 
                            value="<?php echo (isset($this->User_grantee_grant_period_model->start_date)) ? date('H:i', strtotime($this->User_grantee_grant_period_model->start_date)) : '' ?>" 
                            <?php // $this->User_grantee_grant_period_model->fiscal_year == date('Y') ? 'required' : '' ?>
                        >
                    </div>
                </div>
                <div class="col-lg-12"></div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label> End Registration Date <?php // $this->User_grantee_grant_period_model->fiscal_year == date('Y') ? '<span class="require">*</span>' : '' ?></label>
                        <input 
                            class="form-control datepicker" 
                            autocomplete="off" 
                            name="end_date" 
                            id="end_date" 
                            value="<?php echo (isset($this->User_grantee_grant_period_model->end_date)) ? date('d M Y', strtotime($this->User_grantee_grant_period_model->end_date)) : '' ?>" 
                            <?php // $this->User_grantee_grant_period_model->fiscal_year == date('Y') ? 'required' : '' ?>
                            >
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label> End Registration Time <?php // $this->User_grantee_grant_period_model->fiscal_year == date('Y') ? '<span class="require">*</span>' : '' ?></label>
                        <input 
                            type="time"
                            class="form-control" 
                            autocomplete="off" 
                            name="end_time" 
                            id="end_time" 
                            value="<?php echo (isset($this->User_grantee_grant_period_model->end_date)) ? date('H:i', strtotime($this->User_grantee_grant_period_model->end_date)) : '' ?>" 
                            <?php // $this->User_grantee_grant_period_model->fiscal_year == date('Y') ? 'required' : '' ?>
                            >
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label> Recommendation Deadline Date</label>
                        <input 
                            class="form-control datetime" 
                            autocomplete="off" 
                            name="recommendation_deadline_date" 
                            id="recommendation_deadline_date" 
                            value="<?php echo (isset($this->User_grantee_grant_period_model->recommendation_deadline_date)) ? date('Y-m-d H:i', strtotime($this->User_grantee_grant_period_model->recommendation_deadline_date)) : '' ?>" 
                            >
                    </div>
                </div>
                <div class="col-lg-12"></div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label> Review Period Start Date</label>
                        <input 
                            class="form-control datetime" 
                            autocomplete="off" 
                            name="start_date_review" 
                            id="start_date_review" 
                            value="<?php echo (isset($this->User_grantee_grant_period_model->start_date_review)) ? date('Y-m-d H:i', strtotime($this->User_grantee_grant_period_model->start_date_review)) : '' ?>" 
                            >
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label> Review Period End Date</label>
                        <input 
                            class="form-control datetime" 
                            autocomplete="off" 
                            name="end_date_review" 
                            id="end_date_review" 
                            value="<?php echo (isset($this->User_grantee_grant_period_model->end_date_review)) ? date('Y-m-d H:i', strtotime($this->User_grantee_grant_period_model->end_date_review)) : '' ?>" 
                            >
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label> Departure Year</label>
                        <select class="form-control select2" name="departure_date" id="departure_date" required>
                            <option value="">-- Select Year --</option>
                            <?php
                            $current_year = date('Y', strtotime('+12 years'));
                            //$limit_year = $current_year - 20;
                            $limit_year = 1952;
                            for ($year = $current_year; $year >= $limit_year; $year--) {
                                $selected = '';
                                if ($this->User_grantee_grant_period_model->departure_date == $year) {
                                    $selected = 'selected="selected"';
                                }
                            ?>
                                <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <!-- <input 
                            class="form-control datepicker" 
                            autocomplete="off" 
                            name="departure_date" 
                            id="departure_date" 
                            value="<?php echo (isset($this->User_grantee_grant_period_model->departure_date)) ? date('d M Y', strtotime($this->User_grantee_grant_period_model->departure_date)) : '' ?>" 
                            > -->
                    </div>


                    <div class="form-group">
                        <label>Grant Award</label>
                        <input type="number" min="0" autocomplete="off" class="form-control" name="grant_award" id="grant_award" value="<?php echo $this->User_grantee_grant_period_model->grant_award ?>">
                    </div>
                    <div class="form-group">
                        <label> Grant Cost <span class="require">*</span></label>
                        <input type="number" min="0" autocomplete="off" class="form-control" name="grant_cost" id="grant_cost" <?= $this->User_grantee_grant_period_model->is_unlimited_grant_cost == 1 ? "readonly" : "" ?> value="<?php echo (isset($this->User_grantee_grant_period_model->grant_cost)) ? $this->User_grantee_grant_period_model->grant_cost : '' ?>" data-value="<?php echo (isset($this->User_grantee_grant_period_model->grant_cost)) ? $this->User_grantee_grant_period_model->grant_cost : '' ?>" required>
                        <input type="checkbox" value="1" autocomplete="off" name="is_unlimited_grant_cost" id="is_unlimited_grant_cost" <?= $this->User_grantee_grant_period_model->is_unlimited_grant_cost == 1 ? "checked" : "" ?>>
                        <label class="is_unlimited_label" for="is_unlimited_grant_cost">Unlimited</label>
                    </div>

                    <div class="form-group">
                        <label> Grant Supporting </label>
                        <input type="number" min="0" autocomplete="off" class="form-control" name="grant_supporting" <?= $this->User_grantee_grant_period_model->is_unlimited_grant_supporting == 1 ? "readonly" : "" ?> value="<?php echo (isset($this->User_grantee_grant_period_model->grant_supporting)) ? $this->User_grantee_grant_period_model->grant_supporting : '' ?>" data-value="<?php echo (isset($this->User_grantee_grant_period_model->grant_supporting)) ? $this->User_grantee_grant_period_model->grant_supporting : '' ?>">
                        <input type="checkbox" value="1" autocomplete="off" name="is_unlimited_grant_supporting" id="is_unlimited_grant_supporting" <?= $this->User_grantee_grant_period_model->is_unlimited_grant_supporting == 1 ? "checked" : "" ?>>
                        <label class="is_unlimited_label" for="is_unlimited_grant_supporting">Unlimited</label>
                    </div>

                    <div class="form-group">
                        <label> International Travel <span class="require">*</span></label>
                        <input type="number" min="0" autocomplete="off" class="form-control" name="international_travel" id="international_travel" <?= $this->User_grantee_grant_period_model->is_unlimited_international_travel == 1 ? "readonly" : "" ?> value="<?php echo (isset($this->User_grantee_grant_period_model->international_travel)) ? $this->User_grantee_grant_period_model->international_travel : '' ?>" data-value="<?php echo (isset($this->User_grantee_grant_period_model->international_travel)) ? $this->User_grantee_grant_period_model->international_travel : '' ?>" required>
                        <input type="checkbox" value="1" autocomplete="off" name="is_unlimited_international_travel" id="is_unlimited_international_travel" <?= $this->User_grantee_grant_period_model->is_unlimited_international_travel == 1 ? "checked" : "" ?>>
                        <label class="is_unlimited_label" for="is_unlimited_international_travel">Unlimited</label>
                    </div>

                    <!-- <div class="form-group">
                        <label>Memo Budget Number</label>
                        <input class="form-control" autocomplete="off" name="memo_budget_number" value="<?php echo (isset($this->User_grantee_grant_period_model->memo_budget_number)) ? $this->User_grantee_grant_period_model->memo_budget_number : '' ?>">
                    </div> -->
                    
                    <div class="form-group">
                        <label> ECA Deadline <?php //$this->User_grantee_grant_period_model->fiscal_year == date('Y') ? '<span class="require">*</span>' : '' ?></label>
                        <input 
                            class="form-control datepicker" 
                            autocomplete="off" 
                            name="eca_deadline" 
                            value="<?php echo (isset($this->User_grantee_grant_period_model->eca_deadline)) ? date('d M Y', strtotime($this->User_grantee_grant_period_model->eca_deadline)) : '' ?>" 
                            <?php //$this->User_grantee_grant_period_model->fiscal_year == date('Y') ? 'required' : '' ?>
                        >
                    </div>

                    <div class="form-group">
                        <label>Minimum University Submission Requirements</label>
                        <input type="number" min="0" autocomplete="off" class="form-control" name="minimum_university" id="minimum_university" value="<?php echo $this->User_grantee_grant_period_model->minimum_university ?>">
                    </div>
                    
                    <!-- <?php if(isset($this->User_grantee_grant_period_model->id)) { ?>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdl_memo">Add Memo Budget Revision</button>
                        </div>  
                    <?php } ?>
                    <?php if(isset($this->User_grantee_grant_period_model->id) && $memo_budget_revision != null) { ?>
                        <table id="memo_revision" class="table table-bordered" width="100%">
                            <tr>
                                <th>File Name</th>
                                <th>Uploaded Date</th>
                            </tr>
                            <?php foreach($memo_budget_revision as $key => $row){
                                    $file_name = explode('/', $row->file_name);
                                    $namefile = end($file_name);
                            ?>
                                <tr>
                                    <td width="50%"><a href="<?php echo base_url() ?><?= $row->file_name ?>" class="lightbox" aria-haspopup="dialog"><?= $namefile ?></a></td>
                                    <td><?= format_date_time($row->created_date) ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } ?> -->

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Settling in Allowance</label>
                                <input type="number" id="settling_allowance" class="form-control" name="settling_allowance" value="<?= $this->User_grantee_grant_period_model->settling_allowance ?>">
                                <input type="checkbox" value="1" autocomplete="off" name="visibility_settling_allowance" id="visibility_settling_allowance" <?= $this->User_grantee_grant_period_model->visibility_settling_allowance == 1 ? "checked" : "" ?>>
                                <label for="visibility_settling_allowance">Show</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Computer & Technology Allowance</label>
                                <input type="number" id="technology_allowance" class="form-control" name="technology_allowance" value="<?= $this->User_grantee_grant_period_model->technology_allowance ?>">
                                <input type="checkbox" value="1" autocomplete="off" name="visibility_technology_allowance" id="visibility_technology_allowance" <?= $this->User_grantee_grant_period_model->visibility_technology_allowance == 1 ? "checked" : "" ?>>
                                <label for="visibility_technology_allowance">Show</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Travel Allowance</label>
                                <input type="number" id="travel_allowance" class="form-control" name="travel_allowance" value="<?= $this->User_grantee_grant_period_model->travel_allowance ?>">
                                <input type="checkbox" value="1" autocomplete="off" name="visibility_travel_allowance" id="visibility_travel_allowance" <?= $this->User_grantee_grant_period_model->visibility_travel_allowance == 1 ? "checked" : "" ?>>
                                <label for="visibility_travel_allowance">Show</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label> Terms and Conditions</label>
                        <textarea class="form-control editor" id="tnc_wording" name="tnc_wording"><?= $this->User_grantee_grant_period_model->tnc_wording ?></textarea>
                    </div>

                    <div class="form-group">
                        <label> Is Active </label>
                        <input type="checkbox" value="1" autocomplete="off" name="is_active" <?= (!isset($this->User_grantee_grant_period_model->id)) || $this->User_grantee_grant_period_model->is_active == 1 ? "checked" : "" ?>>
                    </div>

                    <div class="form-group">
                        <label>Use the Grant Page in this period as the Submission Form</label>
                        <input type="checkbox" value="1" autocomplete="off" name="use_grant_page_for_submission" <?= isset($this->User_grantee_grant_period_model->use_grant_page_for_submission) ? ($this->User_grantee_grant_period_model->use_grant_page_for_submission == 1 ? "checked" : "") : "checked" ?>>
                    </div>
                    <div class="form-group">
                        <label>Use Period-Based Field of Study</label>
                        <input type="checkbox" value="1" autocomplete="off" name="use_field_of_study" <?= isset($this->User_grantee_grant_period_model->use_field_of_study) ? ($this->User_grantee_grant_period_model->use_field_of_study == 1 ? "checked" : "") : "checked" ?>>
                    </div>

                    <div class="row mt-3 mb-5">
                        <a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                    <?php
                    if (isset($this->User_grantee_grant_period_model->id)) {
                    ?>
                        <input type="hidden" name="id" value="<?php echo $this->User_grantee_grant_period_model->id ?>">
                    <?php } ?>
                </div>
                </form>
            </div>

            <div id="doc" class="tab-pane fade <?= $pid == 'document' ? 'active in' : '' ?>">
                <form id="form_doc" role="form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="input_file">
                <div class="col-lg-11">
                    <table class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th width="30%">Document Name</th>
                                <th width="30%">File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $documents = [
                            'eec_approval' => 'EEC Approval',
                            'fsb_approval' => 'FSB Approval',
                            'tnc' => 'Aminef T&C',
                            'consent_letter' => 'Consent Letter',
                            'letter_of_reference' => 'Letter of Reference',
                            'toefl_tnc' => 'TOEFL Preparation Program Section T&C',
                            'toefl_consent_letter' => 'TOEFL Preparation Program Section Consent Letter',
                            'gre_tnc' => 'GRE Preparation Program Section T&C',
                            'gre_consent_letter' => 'GRE Preparation Program Section Consent Letter',
                            'toefl_gre_tnc' => 'TOEFL & GRE Preparation Program Section T&C',
                            'toefl_gre_consent_letter' => 'TOEFL & GRE Preparation Program Section Consent Letter',
                            'medical_departure' => 'Medical Form',
                            'passport_departure' => 'Passport Departure',
                            'letter_for_supervisor' => 'Letter for Supervisor',
                            'guideline_ds2019' => 'Guideline DS2019',
                            'guideline_ds160' => 'Guideline DS160',
                            'dependent_guideline_ds160' => 'Dependent Guideline DS160',
                            'visa_photo' => 'Visa Photo',
                            'guideline_medical' => 'Guideline Medical Form',
                            'guideline_passport' => 'Guideline Passport',
                            'guideline_toa' => 'Guideline ToA',
                            'procedure_domestic' => 'Procedure of Domestic Ticket Purchase',
                            'procedure_international' => 'Procedure of International Ticket Purchase',
                            'domestic_ticket_purchase' => 'Procedure of Domestic Ticket Purchase (PDO)',
                            'guideline_mentee' => 'Guideline for Mentee',
                            'guideline_test' => 'Guideline for TOEFL Test',
                            'guideline_gre_test' => 'Guideline for GRE Test',
                            'guideline_gmat_test' => 'Guideline for GMAT Test',
                            'guideline_gres_test' => 'Guideline for GRE Subject Test',
                            'guideline_duolingo_test' => 'Guideline for Duolingo Test',
                            'guideline_itp_test' => 'Guideline for TOEFL ITP Test',
                            'guideline_research_presentation' => 'Guideline for Fulbright Research Presentation',
                            'visa_interview_procedure' => 'Nominee Visa Interview Procedure',
                            'ongoing_visa_interview_procedure' => 'Ongoing Visa Interview Procedure',
                            // 'template_form_recommendation' => 'Template Form Reccomendation',
                        ];

                        foreach ($documents as $field_name => $label) {
                            $file_path = $this->User_grantee_grant_period_model->$field_name;
                            $file_exists = !empty($file_path);
                            $file_name = $file_exists ? end(explode('/', $file_path)) : '';
                        ?>
                        <tr>
                            <td><?= $label ?></td>
                            <td>
                                <?php if ($file_exists) { ?>
                                    <a href="<?= base_url($file_path) ?>" class="lightbox" aria-haspopup="dialog"><?= substr($file_name, 0, 45) ?></a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($file_exists) { ?>
                                    <a href="<?= base_url("admin/user_grantee_grant/delete_file/{$field_name}/{$this->User_grantee_grant_period_model->user_grantee_grant_id}/{$this->User_grantee_grant_period_model->id}/document") ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs">Delete</a>
                                <?php } ?>
                                <input type="file" form="form_doc" name="<?= $field_name ?>" class="mt-1" style="display: inline-block;">

                                <button type="button" class="btn btn-primary btn-xs pull-right button-copy-file-document" data-document="<?= $field_name?>" data-period="<?= $this->User_grantee_grant_period_model->id ?>">Copy File</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                    
                    <div class="form-group">
                        <label>Memo Budget</label>
                        <!-- <input type="file" name="memo_budget"> -->
                        <?php if (isset($this->User_grantee_grant_period_model->id)) { ?>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdl_memo_budget_create">Add Memo Budget</button>
                            </div>
                            
                            <table id="memo_revision" class="table table-bordered" width="100%">
                                <tbody id="list_memo">
                                    <tr>
                                        <th>File name</th>
                                        <th>Active</th>
                                        <th>Uploaded Date</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php foreach ($memo_budget_period as $key => $value) { ?>
                                        <tr>
                                            <td><a target="_blank" class="lightbox" href="<?= site_url($value->memo_budget); ?>"><?= $value->file_name;?></a></td>
                                            <td><?= $value->is_active;?></td>
                                            <td><?= date("d M y h:i", strtotime($value->created_at));?></td>
                                            <td width="15%">
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mdl_memo_period" data-memo_id="<?= $value->id ?>" >Edit</button>
                                                <button type="button" class="btn btn-danger btn-xs" onclick="delete_memo_period(this, <?= $value->id ?>)" data-memo_id="<?= $value->id ?>" >Delete</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdl_memo_budget_create">Add Memo Budget</button>
                            </div>
                            <table id="memo_revision" class="table table-bordered" width="100%">
                                <tbody id="list_memo"> 
                                    <tr>
                                        <th>File name</th>
                                        <th>Active</th>
                                        <th>Uploaded Date</th>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        <?php  } ?>
                    </div>

                    <div class="row mt-3 mb-5">
                        <a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
                        <button type="submit" form="form_doc" class="btn btn-success">Save</button>
                    </div>
                </div>
                </form>
            </div>

            <div id="pdo" class="tab-pane fade">
                <form id="form" role="form" method="POST" enctype="multipart/form-data">
                <?php if($is_pdo_global) { ?>
                    <div class="col-lg-12 my-5">
                        <div class="col-lg-4">
                            <a href="<?= base_url('admin/pre_departure_orientation/edit/' . $pdo_global->id) ?>" class="btn btn-info" target="_blank">Go to Page PDO Global</a>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-lg-12">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>PDO Format</label>
                            <select class="form-control" <?= $is_pdo_global ? 'disabled' : '' ?> name="pdo_format" id="pdo_format">
                                <option value="online" <?php echo $this->User_grantee_grant_period_model->pdo_format == 'online' ? 'selected' : ''; ?>>Online</option>
                                <option value="offline" <?php echo $this->User_grantee_grant_period_model->pdo_format == 'offline' ? 'selected' : ''; ?>>Offline</option>
                                <option value="hybrid" <?php echo $this->User_grantee_grant_period_model->pdo_format == 'hybrid' ? 'selected' : ''; ?>>Hybrid</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12" id="section_online">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Start Date Online</label>
                            <input type="text" <?= $is_pdo_global ? 'disabled' : '' ?> style="background-color:#fff" class="form-control datepicker" placeholder="Date" name="date" value="<?= $this->User_grantee_grant_period_model->date ? date('Y-m-d H:i', strtotime($this->User_grantee_grant_period_model->date)) : '' ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>End Date Online</label>
                            <input type="text" <?= $is_pdo_global ? 'disabled' : '' ?> style="background-color:#fff" class="form-control datepicker" placeholder="Date" name="end_date_pdo" value="<?= $this->User_grantee_grant_period_model->end_date_pdo ? date('Y-m-d H:i', strtotime($this->User_grantee_grant_period_model->end_date_pdo)) : '' ?>">
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="form-group">
                            <label>Location Online</label>
                            <textarea <?= $is_pdo_global ? 'disabled' : '' ?> class="form-control editor_pdo" name="location" placeholder="Location"><?= $this->User_grantee_grant_period_model->location ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12" id="section_offline">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Start Date Offline</label>
                            <input type="text" <?= $is_pdo_global ? 'disabled' : '' ?> style="background-color:#fff" class="form-control datepicker" placeholder="Date" name="date_offline" value="<?= $this->User_grantee_grant_period_model->date_offline ? date('Y-m-d H:i', strtotime($this->User_grantee_grant_period_model->date_offline)) : '' ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>End Date Offline</label>
                            <input type="text" <?= $is_pdo_global ? 'disabled' : '' ?> style="background-color:#fff" class="form-control datepicker" placeholder="Date" name="end_date_offline" value="<?= $this->User_grantee_grant_period_model->end_date_offline ? date('Y-m-d H:i', strtotime($this->User_grantee_grant_period_model->end_date_offline)) : '' ?>">
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="form-group">
                            <label>Location Offline</label>
                            <textarea <?= $is_pdo_global ? 'disabled' : '' ?> class="form-control editor_pdo" name="location_offline" placeholder="Location"><?= $this->User_grantee_grant_period_model->location_offline ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Agenda</label><br>
                            <input type="file" class="form-control <?= $is_pdo_global ? 'hide' : '' ?>" name="agenda">
                            <small class="<?= $is_pdo_global ? 'hide' : '' ?>">File Size Max 5MB</small>
                            <?php if($this->User_grantee_grant_period_model->agenda != '') { ?>
                            <br />
                            <a href="<?= base_url($this->User_grantee_grant_period_model->agenda)?>" class="btn btn-primary lightbox">View</a>
                            <a href="<?= base_url('admin/user_grantee_grant/delete_file/agenda/'.$this->User_grantee_grant_period_model->user_grantee_grant_id .'/'. $this->User_grantee_grant_period_model->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger <?= $is_pdo_global ? 'hide' : '' ?>">Delete</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Participant</label><br>
                            <input type="file" class="form-control <?= $is_pdo_global ? 'hide' : '' ?>" name="participant">
                            <small class="<?= $is_pdo_global ? 'hide' : '' ?>">File Size Max 5MB</small>
                            <?php if($this->User_grantee_grant_period_model->participant != '') { ?>
                            <br />
                            <a href="<?= base_url($this->User_grantee_grant_period_model->participant)?>" class="btn btn-primary lightbox">View</a>
                            <a href="<?= base_url('admin/user_grantee_grant/delete_file/participant/'.$this->User_grantee_grant_period_model->user_grantee_grant_id .'/'. $this->User_grantee_grant_period_model->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger <?= $is_pdo_global ? 'hide' : '' ?>">Delete</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Final Biosketch of Speakers</label><br>
                            <input type="file" class="form-control <?= $is_pdo_global ? 'hide' : '' ?>" name="final_biosketch_of_speakers">
                            <small class="<?= $is_pdo_global ? 'hide' : '' ?>">File Size Max 5MB</small>
                            <?php if($this->User_grantee_grant_period_model->final_biosketch_of_speakers != '') { ?>
                            <br />
                            <a href="<?= base_url($this->User_grantee_grant_period_model->final_biosketch_of_speakers)?>" class="btn btn-primary lightbox">View</a>
                            <a href="<?= base_url('admin/user_grantee_grant/delete_file/final_biosketch_of_speakers/'.$this->User_grantee_grant_period_model->user_grantee_grant_id .'/'. $this->User_grantee_grant_period_model->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger <?= $is_pdo_global ? 'hide' : '' ?>">Delete</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-5">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Panelist</label>
                            <select class="form-control select2" <?= $is_pdo_global ? 'disabled' : '' ?> name="panellist_id[]" multiple='multiple' style="width:100%">
                                <?php foreach ($panellist as $p) { ?>
                                    <?php $select = in_array($p->id, explode(",", $this->User_grantee_grant_period_model->panellist_id))  ? 'selected' : ''; ?>
                                    <option value="<?php echo $p->id; ?>" <?= $select ?>><?php echo $p->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-5">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> List Participants</p>
                    <div class="pull-left mb-2">
                    <?php if($participant && count($participant) > 0) echo 'Participants :' . count($participant); ?>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" class="chk-all" <?= $is_pdo_global ? 'disabled' : '' ?>></th>
                                    <th width="35" class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Grantee Program</th>
                                    <th>University</th>
                                    <th>Period</th>
                                </tr>
                                <?php $no=1; foreach($participant as $par) { ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="chk-row" <?= in_array($par->id, $grantee_grant_global) || $par->status == STATUS_SET_TO_ALUMNI || in_array($par->id, explode(",", $this->User_grantee_grant_period_model->email_ids)) ? 'checked disabled' : ''?> <?= $is_pdo_global ? 'disabled' : '' ?> name="ids[]" value="<?= $par->id ?>">
                                        </td>
                                        <td><?= $no ?></td>
                                        <td><a href="<?= base_url('admin/pre_depature/form/'.$par->id) ?>"><?= get_full_name($par, 'ID') ?></a></td>
                                        <td><?= $par->grant_name ?></td>
                                        <td><?= isset($par->university_name) ? $par->university_name : '' ?></td>
                                        <td><?= $par->fiscal_year ?></td>
                                    </tr>
                                <?php $no++; } ?>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="col-lg-12 mt-3 mb-5">
                    <a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </form>
            </div>

            <div id="payment" class="hide tab-pane fade <?= $pid == 'payment' ? 'active in' : '' ?>">
                <form id="frm_payment_filter" method="GET"></form>
                <form id="form_payment" role="form" method="POST" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-left">
                                        Search : <input type="search" class="form-control input-sm" form="frm_payment_filter" onkeydown="return submitFilter(event, 'frm_payment_filter')" name="search" value="<?= $paging['search'] ?>" placeholder="Search">
                                        Show :
                                        <select class="form-control input-sm" form="frm_payment_filter" name="limit_payment" onchange="document.forms.frm_payment_filter.submit()">
                                            <?php
                                            foreach ($limit['limit_options'] as $lo) {
                                                $selected = '';
                                                if ($lo == $paging['limit']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                                            <?php } ?>
                                        </select>
                                        entries
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record" class="btn btn-success btn-sm" id="btn-add"> 
                                            ADD NEW
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th data-form="frm_payment_filter" <?php echo sorting_attribute('payment_for', $sort_by, $sort) ?>>Payment For</th>
                                                <th>Category</th>
                                                <th data-form="frm_payment_filter" <?php echo sorting_attribute('payment_date', $sort_by, $sort) ?>>Payment Date</th>
                                                <!-- <th>Description</th> -->
                                                <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <th>Total Payment (IDR)</th>
                                                <?php } ?>
                                                <th>Total Payment (USD)</th>
                                                <th>Proof</th>
                                                <th>Status</th>
                                                <th width="150" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($payment_record)
                                        {
                                            $no = $paging['start_row'];
                                            foreach($payment_record as $row) {
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $row->payment_name ?></td>
                                                <td><?= $row->category ?></td>
                                                <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                <!-- <td><?= $row->description ?></td> -->
                                                <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <td>
                                                <?php 
                                                    $total_payment_idr = [];
                                                    foreach ($row->items as $key => $item) {
                                                        array_push($total_payment_idr, $item->nominal_idr);
                                                    }
                                                ?>
                                                <?= format_money(array_sum($total_payment_idr), 'IDR')?>
                                                </td>
                                                <?php } ?>
                                                <td>
                                                    <?php 
                                                        $total_payment = [];
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment, $item->nominal);
                                                        }
                                                    ?>
                                                    <?= format_money(array_sum($total_payment), 'USD')?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($row->proof)) { ?>
                                                    <a href="<?php echo base_url($row->proof) ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof</label></a>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $row->payment_status ?></td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-mode="view" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                    <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-mode="edit" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <?php if(!$row->bulk_id) { ?>
                                                    <a href="<?= site_url('admin/user_grantee_grant/delete_record/'.$row->id) ?>" class="btn btn-danger btn-xs confirm-del">
                                                        <i class="fa fa-times-circle"></i> Delete
                                                    </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                                $no++;
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                <div class="pull-left">
                                    Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
                                </div>
                                <!-- /.pagination info -->
                                <?php echo $paging['html'] ?>
                                <!-- /.pagination -->
                                <input type="hidden" form="frm_payment_filter" name="sort_by" value="<?php echo $sort_by ?>">
                                <input type="hidden" form="frm_payment_filter" name="sort" value="<?php echo $sort ?>">
                                <input type="hidden" form="frm_payment_filter" name="pid" value="payment">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="delete_detail_payment" name="delete_detail_payment">
                <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
                <input type="hidden" name="total_grant" value="<?= $grantee_setting->total_grant ?>">
                <input type="hidden" name="grantee_id" id="grantee_id" value="<?= $grantee_id ?>">
                </form>
            </div>

            <div id="payment_bulk" class="tab-pane fade <?= $pid == 'payment_bulk' ? 'active in' : '' ?>">
                <form id="frm_payment_bulk_filter" method="GET"></form>
                <form id="form_payment_bulk" role="form" method="POST" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-left">
                                        Search : <input type="search" class="form-control input-sm" form="frm_payment_bulk_filter" onkeydown="return submitFilter(event, 'frm_payment_bulk_filter')" name="search" value="<?= $paging['search'] ?>" placeholder="Search">
                                        Show :
                                        <select class="form-control input-sm" form="frm_payment_bulk_filter" name="limit_payment_bulk" onchange="document.forms.frm_payment_bulk_filter.submit()">
                                            <?php
                                            foreach ($limit['limit_options'] as $lo) {
                                                $selected = '';
                                                if ($lo == $payment_bulk['paging']['limit']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                                            <?php } ?>
                                        </select>
                                        entries
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record_bulk" class="btn btn-success btn-sm" id="btn-add"> 
                                            ADD NEW
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th>Category</th>
                                                <th data-form="frm_payment_bulk_filter" <?php echo sorting_attribute('payment_date', $sort_by, $sort) ?>>Payment Date</th>
                                                <th>Status</th>
                                                <th data-form="frm_payment_bulk_filter">Payment For</th>
                                                <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <th>Total Payment (IDR)</th>
                                                <?php } ?>
                                                <th>Total Payment (USD)</th>
                                                <th width="150" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($payment_bulk)
                                        {
                                            $no = $payment_bulk['paging']['start_row'];
                                            foreach($payment_bulk['payment_records'] as $row) {
                                                $join_full_name = '';
                                                $join_full_name .= '<ul>';
                
                                                $available_program = [];
                                                foreach ($row->payment_name as $key => $value) {
                
                                                    $join_full_name .= '<li style="margin-bottom: 10px;">'.$value.'</li>';
                                                }
                                                $join_full_name .= '</ul>';
                                                
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $row->category ?></td>
                                                <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                <td><?php echo $row->status_name; ?></td>
                                                <td><?= $join_full_name ?></td>
                                                <!-- <td><?= $row->description ?></td> -->
                                                <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <td>
                                                    <?php 
                                                        $total_payment_idr = [];
                                                        $nominal_idr = '';
                                                        $nominal_idr .= '<ul style="margin-left: -25px;">';
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment_idr, $item->nominal_idr);
                                                            $nominal_idr .= '<li style="margin-bottom: 10px;">'.format_money($item->nominal_idr, 'IDR').'</li>';
                                                        }
                                                        $nominal_idr .= '</ul>';
                                                    ?>
                                                    <?= $nominal_idr ?>
                                                    <b><u>Total : <?= format_money(array_sum($total_payment_idr), 'IDR')?></u></b>
                                                </td>
                                                <?php } ?>
                                                <td>
                                                    <?php 
                                                        $total_payment = [];
                                                        $nominal = '';
                                                        $nominal .= '<ul style="margin-left: -25px;">';
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment, $item->nominal);
                                                            $nominal .= '<li style="margin-bottom: 10px;">'.format_money($item->nominal, 'USD').'</li>';
                                                        }
                                                        $nominal .= '</ul>';
                                                    ?>
                                                    <?= $nominal ?>
                                                    <b><u>Total : <?= format_money(array_sum($total_payment), 'USD')?></u></b>
                                                </td>
                                                <td class="text-right">
                                                    <a href="#" data-toggle="modal" data-target="#mdl_edit_record_bulk" data-mode="view" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                    <?php if($row->is_payment_bulk) { ?>
                                                    <a href="#" data-toggle="modal" data-target="#mdl_edit_record_bulk" data-mode="edit" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs <?php echo $disabled; ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a href="<?= site_url('admin/user_grantee_grant/delete_record_bulk/'.$row->id) ?>" class="btn btn-danger btn-xs mb-2 confirm-del">
                                                        <i class="fa fa-times-circle"></i> Delete
                                                    </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                                $no++;
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                <div class="pull-left">
                                    Showing <?php echo $payment_bulk['paging']['start_row'] ?> to <?php echo $payment_bulk['paging']['end_row'] ?> of <?php echo $payment_bulk['paging']['total_rows'] ?> entries
                                </div>
                                <!-- /.pagination info -->
                                <?php echo $payment_bulk['paging']['html'] ?>
                                <!-- /.pagination -->
                                <input type="hidden" form="frm_payment_bulk_filter" name="sort_by" value="<?php echo $sort_by ?>">
                                <input type="hidden" form="frm_payment_bulk_filter" name="sort" value="<?php echo $sort ?>">
                                <input type="hidden" form="frm_payment_bulk_filter" name="pid" value="payment_bulk">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="delete_detail_payment" name="delete_detail_payment">
                <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
                <input type="hidden" name="total_grant" value="<?= $grantee_setting->total_grant ?>">
                <input type="hidden" name="grantee_id" id="grantee_id" value="<?= $grantee_id ?>">
                </form>
            </div>

            <div id="payment_grantee" class="tab-pane fade <?= $pid == 'payment_grantee' ? 'active in' : '' ?>">
                <form id="form_filter_payment_grantee" method="GET"></form>
                <form id="form_payment_grantee" role="form" method="POST" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-left">
                                        Search : <input type="search" class="form-control input-sm" form="form_filter_payment_grantee" name="search" onkeydown="return submitFilter(event, 'form_filter_payment_grantee')" value="<?= $payment['paging']['search'] ?>" placeholder="Search">
                                        Show :
                                        <select class="form-control input-sm" form="form_filter_payment_grantee" name="limit_payment_grantee_bulk" onchange="document.forms.form_filter_payment_grantee.submit()">
                                            <?php
                                            foreach ($limit['limit_options'] as $lo) {
                                                $selected = '';
                                                if ($lo == $payment['paging']['limit']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                                            <?php } ?>
                                        </select>
                                        entries
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record_grantee" class="btn btn-success btn-sm" id="btn-add">
                                            ADD NEW
                                        </a>
                                    </div>
                                    <div class="col-md-12 p-0 mt-4">
                                        <?php if ($this->session->flashdata('success_message')) { ?>
                                            <div class="alert alert-info">
                                                <i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('success_message'); ?>
                                            </div>
                                            <?php $this->session->set_flashdata('success_message', false); ?>    
                                        <?php } ?>

                                        <?php if ($this->session->flashdata('failed_message')) { ?>
                                            <div class="alert alert-danger">
                                                <i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('failed_message'); ?>
                                            </div>
                                            <?php $this->session->set_flashdata('failed_message', false); ?>    
                                        <?php } ?>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th>Category</th>
                                                <th data-form="form_filter_payment_grantee" <?php echo sorting_attribute('payment_date', $sort_by, $sort) ?>>Payment Date</th>
                                                <th>Status</th>
                                                <th data-form="form_filter_payment_grantee">Grantee Name</th>
                                                <!-- <th>Description</th> -->
                                                <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <th>Total Payment (IDR)</th>
                                                <?php } ?>
                                                <th>Total Payment (USD)</th>
                                                <th width="150" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($payment['payment_records'])
                                        {
                                            $no = $payment['paging']['start_row'];
                                            foreach($payment['payment_records'] as $row) {
                                                $join_full_name = '';
                                                $join_full_name .= '<ul>';
                
                                                $available_program = [];
                                                foreach ($row->full_name as $key => $value) {
                
                                                    $join_full_name .= '<li style="margin-bottom: 10px;">'.$value.'</li>';
                                                }
                                                $join_full_name .= '</ul>';
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $row->category ?></td>
                                                <td><?= date('d-M-Y', strtotime($row->payment_date)) ?></td>
                                                <td><?php echo $row->status_name; ?></td>
                                                <td><?= $join_full_name ?></td>
                                                <!-- <td><?= $row->description ?></td> -->
                                                <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                                                <td>
                                                    <?php 
                                                        $total_payment_idr = [];
                                                        $nominal_idr = '';
                                                        $nominal_idr .= '<ul style="margin-left: -25px;">';
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment_idr, $item->nominal_idr);
                                                            $nominal_idr .= '<li style="margin-bottom: 10px;">'.format_money($item->nominal_idr, 'IDR').'</li>';
                                                        }
                                                        $nominal_idr .= '</ul>';
                                                    ?>
                                                    <?= $nominal_idr ?>
                                                    <b><u>Total : <?= format_money(array_sum($total_payment_idr), 'IDR')?></u></b>
                                                </td>
                                                <?php } ?>
                                                <td>
                                                    <?php 
                                                        $total_payment = [];
                                                        $nominal = '';
                                                        $nominal .= '<ul style="margin-left: -25px;">';
                                                        foreach ($row->items as $key => $item) {
                                                            array_push($total_payment, $item->nominal);
                                                            $nominal .= '<li style="margin-bottom: 10px;">'.format_money($item->nominal, 'USD').'</li>';
                                                        }
                                                        $nominal .= '</ul>';
                                                    ?>
                                                    <?= $nominal ?>
                                                    <b><u>Total : <?= format_money(array_sum($total_payment), 'USD')?></u></b>
                                                </td>
                                                <td class="text-right">
                                                    <a href="#" data-toggle="modal" data-target="#mdl_edit_record_grantee" data-mode="view" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                    <a href="#" data-toggle="modal" data-target="#mdl_edit_record_grantee" data-mode="edit" data-record_id="<?= $row->id ?>" class="btn-edit-payment btn btn-primary btn-xs <?php echo $disabled; ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a href="<?= site_url('admin/request_payment/delete_record_grantee/'.$row->id) ?>" class="btn btn-danger btn-xs mb-2 confirm-del">
                                                        <i class="fa fa-times-circle"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                                $no++;
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                <div class="pull-left">
                                    Showing <?php echo $payment['paging']['start_row'] ?> to <?php echo $payment['paging']['end_row'] ?> of <?php echo $payment['paging']['total_rows'] ?> entries
                                </div>
                                <!-- /.pagination info -->
                                <?php echo $payment['paging']['html'] ?>
                                <!-- /.pagination -->
                                <input type="hidden" form="form_filter_payment_grantee" name="sort_by" value="<?php echo $sort_by ?>">
                                <input type="hidden" form="form_filter_payment_grantee" name="sort" value="<?php echo $sort ?>">
                                <input type="hidden" form="form_filter_payment_grantee" name="pid" value="payment_grantee">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="delete_detail_payment" name="delete_detail_payment">
                <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
                <input type="hidden" name="total_grant" value="<?= $grantee_setting->total_grant ?>">
                <input type="hidden" name="grantee_id" id="grantee_id" value="<?= $grantee_id ?>">
                </form>
            </div>

            <div id="min_score" class="tab-pane fade">
                <form id="form" role="form" method="POST" enctype="multipart/form-data">
                <div class="col-lg-6">
                    <?php foreach ($list_type_score as $key => $value) { ?>
                        <div class="form-group">
                            <br><br>
                            <label><?= $value->name ?></label>
                            <input 
                                type="number"
                                step="any"
                                class="form-control col-sm-4" 
                                autocomplete="off" 
                                name="score[<?= $value->id ?>]" 
                                value="<?= count($value_type_score) && isset($value_type_score[$value->id]) ? $value_type_score[$value->id]->min_score : 0 ?>" 
                            >
                        </div>
                    <?php } ?>
                    <br>
                    <div class="mt-3 mb-5">
                        <a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
                </form>
            </div>
            
            <div id="english_test_score" class="tab-pane fade <?= $pid == 'english_test_score' ? 'active in' : '' ?>">
                <?php $this->load->view('admin/user_grantee_grant/period/list_english_test_score'); ?>
            </div>

            <div id="review" class="tab-pane fade <?= $pid == 'review' ? 'active in' : '' ?>">
                <?php $this->load->view('admin/user_grantee_grant/period/list_review_questions'); ?>
            </div>

            <div id="interview_evaluation" class="tab-pane fade <?= $pid == 'interview_evaluation' ? 'active in' : '' ?>">
                <?php $this->load->view('admin/user_grantee_grant/period/list_interview_questions'); ?>
            </div>

            <div id="email_template" class="tab-pane fade <?= $pid == 'email_template' ? 'active in' : '' ?>" style="padding-top:50px;">
                <form id="form_email" role="form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="input_email">
                    <div class="col-lg-12">
                        <div id="email_template" class="active in first_tab">
                            <div class="panel-group" id="accordionOne" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                        <div class="panel-heading text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Email Recommender Letter of Reference
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-xs btn-primary pull-right btn-noaction button-copy-template-email" data-template="email_recommender" data-period="<?= $this->User_grantee_grant_period_model->id ?>">Copy Template</button>
                                                </div>
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseZero" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'recommender' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-9">
                                            <div class="form-group">
                                                <label> Template Recommender Letter of Reference </label>
                                                <textarea name="email_recommender" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_period_model->email_recommender ?></textarea>
                                                <a target="_blank" href="<?= base_url('admin/user_grantee_grant/preview_email_recommender/'.$this->User_grantee_grant_period_model->id) ?>" class="btn btn-warning mt-2">Preview</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group card">
                                                <label> Available merge fields </label>
                                                <hr style="margin-top:0 !important;"/>
                                                <p>Grantee Name <span class="pull-right"><a href="#" class="add_merge_field">{grantee_name}</a></span></p>
                                                <p>Fullname <span class="pull-right"><a href="#" class="add_merge_field">{full_name}</a></span></p>
                                                <p>Fiscal Year <span class="pull-right"><a href="#" class="add_merge_field">{fiscal_year}</a></span></p>
                                                <p>Program Name <span class="pull-right"><a href="#" class="add_merge_field">{program_name}</a></span></p>
                                                <p>Form Link <span class="pull-right"><a href="#" class="add_merge_field">{form_link}</a></span></p>
                                                <p>Relationship <span class="pull-right"><a href="#" class="add_merge_field">{relationship}</a></span></p>
                                                <p>Token <span class="pull-right"><a href="#" class="add_merge_field">{token}</a></span></p>
                                                <p>Prefix Grantee <span class="pull-right"><a href="#" class="add_merge_field">{prefix}</a></span></p>
                                                <p>First Name Grantee <span class="pull-right"><a href="#" class="add_merge_field">{first_name}</a></span></p>
                                                <p>Last Name Grantee <span class="pull-right"><a href="#" class="add_merge_field">{last_name}</a></span></p>
                                                <p>Deadline Date <span class="pull-right"><a href="#" class="add_merge_field">{deadline_date}</a></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="panel-heading text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Email Template Interview
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-xs btn-primary pull-right btn-noaction button-copy-template-email" data-template="interview" data-period="<?= $this->User_grantee_grant_period_model->id ?>">Copy Template</button>
                                                </div>
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseOne" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'support_letter' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label> Template Email Interview </label>
                                                <textarea name="email_interview" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_period_model->email_interview ?></textarea>
                                                <a target="_blank" href="<?= base_url('admin/user_grantee_grant/preview/'.$this->User_grantee_grant_period_model->id) ?>" class="btn btn-warning mt-2">Preview</a>
                                            </div>
                                            <div class="form-group">
                                            <label> Attachment Email Interview </label>
                                                <?php 
                                                    $profile_photo = user_grantee_file_url($this->User_grantee_grant_period_model, 'template_interview');
                                                ?>
                                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                                    <a href="<?php echo site_url($profile_photo); ?>" class="lightbox" aria-haspopup="dialog">
                                                        <img id="preview_image_profile" data-old="<?php echo site_url($profile_photo); ?>" src="<?php echo get_preview($profile_photo); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                                    </a>
                                                    <?php if($this->User_grantee_grant_period_model->attch_email_interview) { ?>
                                                    <a href="<?= base_url('admin/user_grantee_grant/delete_file/attch_email_interview/'.$grant_id.'/'.$this->User_grantee_grant_period_model->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs" style="position:absolute; top:0; right:-28px;">
                                                        <i class="fa fa-trash fa-fw"></i>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                                <input type="file" class="custom-file-input hide" name="attch_email_interview" id="img_photo" onchange="show_preview(this, 'profile', 'img_photo');">
                                                <!-- <input type="hidden" name="img_photo" value="<?php echo $this->Grantee_ent_model->img_photo; ?>"> -->
                                                <p><?= $this->User_grantee_grant_period_model->attch_email_interview ? file_name($this->User_grantee_grant_period_model->attch_email_interview) : 'No file chosen' ?></p>
                                                <label class="btn btn-primary upload-button" for="img_photo"> Choose file </label> 
                                                <a href="<?php echo site_url($profile_photo) ?>" id="button_preview_img_photo" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label> Attchment Email Interview </label>
                                                <input type="file" class="form-control" name="attch_email_interview"> -->
                                                <?php //if($this->User_grantee_grant_period_model->attch_email_interview) { ?>
                                                    <!-- <a href="<?= base_url($this->User_grantee_grant_period_model->attch_email_interview) ?>" class="btn btn-warning mt-2 lightbox">Preview</a>
                                                    <a href="<?= base_url('admin/user_grantee_grant/delete_file/attch_email_interview/'.$grant_id.'/'.$this->User_grantee_grant_period_model->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger mt-2 ml-2" style="position:absolute;">
                                                        <i class="fa fa-trash fa-fw"></i>
                                                    </a> -->
                                                <?php //} ?>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <div class="panel-heading text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Email Template PDO Global
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-xs btn-primary pull-right btn-noaction button-copy-template-email" data-template="pdo" data-period="<?= $this->User_grantee_grant_period_model->id ?>">Copy Template</button>
                                                </div>
                                            </h4>

                                        </div>
                                    </a>
                                    <div id="collapseTwo" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'medical' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label> Subject Email PDO </label>
                                                <input type="text" class="form-control" name="subject_email_pdo" value="<?= $this->User_grantee_grant_period_model->subject_email_pdo ?>">
                                            </div>
                                            <div class="form-group">
                                                <label> Template Email PDO </label>
                                                <textarea name="email_pdo" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_period_model->email_pdo ?></textarea>
                                                <a target="_blank" href="<?= base_url('admin/user_grantee_grant/preview_email_pdo/'.$this->User_grantee_grant_period_model->id) ?>" class="btn btn-warning mt-2">Preview</a>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <div class="panel-heading text-left" role="tab" id="submission_result">
                                            <h4 class="panel-title">
                                                Email Template EEC
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-xs btn-primary pull-right btn-noaction button-copy-template-email" data-template="eec" data-period="<?= $this->User_grantee_grant_period_model->id ?>">Copy Template</button>
                                                </div>
                                            </h4>
                                        </div>
                                    </a>
                                    <div id="collapseThree" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'passport' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                                    <div class="panel-body">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label> Subject Email EEC (Principal) </label>
                                                <input type="text" class="form-control" name="subject_email_eec_principal" value="<?= $this->User_grantee_grant_period_model->subject_email_eec_principal ?>">
                                            </div>
                                            <div class="form-group">
                                                <label> Template Email EEC (Principal) </label>
                                                <textarea name="email_eec_principal" cols="30" rows="10" class="form-control editor_email"><?= $this->User_grantee_grant_period_model->email_eec_principal ?></textarea>
                                                <a target="_blank" href="<?= base_url('admin/user_grantee_grant/preview_eec_principal/'.$this->User_grantee_grant_period_model->id) ?>" class="btn btn-warning mt-2">Preview</a>
                                            </div>
                                            <div class="form-group">
                                                <label> Subject Email EEC (Alternate) </label>
                                                <input type="text" class="form-control" name="subject_email_eec_alternate" value="<?= $this->User_grantee_grant_period_model->subject_email_eec_alternate ?>">
                                            </div>
                                            <div class="form-group">
                                                <label> Template Email EEC (Alternate) </label>
                                                <textarea name="email_eec_alternate" cols="30" rows="10" class="form-control editor_email"><?= $this->User_grantee_grant_period_model->email_eec_alternate ?></textarea>
                                                <a target="_blank" href="<?= base_url('admin/user_grantee_grant/preview_eec_alternate/'.$this->User_grantee_grant_period_model->id) ?>" class="btn btn-warning mt-2">Preview</a>
                                            </div>
                                            <!-- <div class="form-group mt-3 mb-5">
                                                <a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div> -->
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div id="submission_ongoing" class="tab-pane fade <?= $pid == 'submission_ongoing' ? 'active in' : '' ?>" style="padding-top:50px;">
            <?php $this->load->view('admin/user_grantee_grant/period/list_submission_ongoing'); ?>
            </div>
            
            <div id="grant_pages" class="tab-pane fade <?= $pid == 'grant_pages' ? 'active in' : '' ?>" style="padding-top:50px;">
                <?php $this->load->view('admin/user_grantee_grant/period/grant_pages'); ?>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
<!-- /.row -->
<!-- Modal -->
<div class="modal fade" id="mdl_memo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Memo Budget Revision</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/memo_budget_revision') ?>">
            <div class="form-group">
                <label>Memo Budget Revision</label>
                <input type="file" id="memo_budget_revision" name="memo_budget_revision" required>
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="period_id" id="period_id" value="<?= $this->User_grantee_grant_period_model->id ?>">
                <input type="hidden" name="grant_id" id="grant_id" value="<?= $this->User_grantee_grant_period_model->user_grantee_grant_id ?>">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="form_memo">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Memo Period -->
<div class="modal fade" id="mdl_memo_budget_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Memo Budget</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form role="form" method="POST" id="form_memo_budget" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/memo_budget_period') ?>">
					<input type="hidden" name="save_memo_budget">
					<input type="hidden" name="period_id" value="<?php echo $this->User_grantee_grant_period_model->id; ?>" >
					<div class="form-group">
						<label>Memo Budget</label>
						<input type="file" id="memo_budget" name="memo_budget" required>
                        <small class="file-for-testing">File Size Max 5MB</small>
					</div>
					<div class="form-group">
						<label for="">Active</label>
						<select name="is_active" id="" class="form-control">
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" form="form_memo_budget" id="btn-memo-budget">Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="mdl_memo_period" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Memo Budget</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form role="form" method="POST" id="form_memo_budget_edit" enctype="multipart/form-data" action="<?= base_url('admin/user_grantee_grant/edit_memo_period/') ?>">
					<input type="hidden" name="save_memo_budget">
					<input type="hidden" name="memo_id" id="memo_id">
					<div class="form-group">
						<label>Memo Budget</label>
						<input type="file" id="memo_budget" name="memo_budget">
                        <small class="file-for-testing">File Size Max 5MB</small>
					</div>
					<div class="form-group">
						<label for="">Active</label>
						<select name="is_active" id="edit_memo_is_active" class="form-control">
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" form="form_memo_budget_edit">Save</button>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('admin/partials/modal_payment_grant') ?>
<?php $this->load->view('admin/partials/modal_payment_grant_bulk') ?>
<?php $this->load->view('admin/partials/modal_payment_grant_grantee') ?>



<div class="modal fade" id="mdl_select_period_copy">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/user_grantee_grant/copy_file_period')?>" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input name="period_id" type="hidden" value="<?= $this->User_grantee_grant_period_model->id; ?>"/>
                        <input name="document" type="hidden" id="document_copy_file"/>

                        <label>Select Period</label>
                        <select name="period_from" class="form-control selectpicker" id="period_from">
                            <option value="">--Choose one--</option>
                            <?php foreach ($periods as $key => $period) { ?>
                                <option value='<?= $period->id ?>'><?= $period->fiscal_year ?></option>";
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Copy</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_copy_template">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/user_grantee_grant/copy_template_email')?>" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input name="period_id" type="hidden" value="<?= $this->User_grantee_grant_period_model->id; ?>"/>
                        <input name="template" type="hidden" id="template_name"/>

                        <label>Select Period</label>
                        <select name="period_from_template" class="form-control select2" id="period_from_template" required>
                            <option value="">--Choose one--</option>
                            <?php foreach ($periods as $key => $period) { ?>
                                <option value='<?= $period->id ?>'><?= $period->fiscal_year ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Copy</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php 
if(!empty($payment_record)):
$final_record = [];
foreach($payment_record as $record){
    $final_record[$record->id] = $record;
}
?>
<script>
    var currentPaymentGrant = JSON.parse(`<?php echo safe_parse_json(json_encode($final_record)); ?>`);
</script>
<?php endif; ?>

<?php if(!empty($payment_item)): ?>
<script>
    var currentPaymentItemsGrant = JSON.parse(`<?php echo safe_parse_json(json_encode($payment_item)); ?>`);
</script>
<?php endif; ?>

<?php
if (!empty($payment_sub_support)) :
    $final_sub_record = [];
    foreach ($payment_sub_support as $row) {
        $final_sub_record[] = $row;
    }
?>
    <script>
        var currentSubCategoryRecord = JSON.parse(`<?php echo safe_parse_json(json_encode($final_sub_record)); ?>`);
    </script>
<?php endif; ?>




<?php
if (!empty($memo_budget_period)) :
    $final_record = [];
    foreach ($memo_budget_period as $memo) {
        $final_record[$memo->id] = $memo;
    }
?>
    <script>
        var currentMemoGrants = JSON.parse(`<?php echo safe_parse_json(json_encode($final_record)); ?>`);
    </script>
<?php endif; ?>


<?php
if (!empty($payment['payment_records'])) :
    $final_record_grantee = [];
    foreach ($payment['payment_records'] as $record) {
        $final_record_grantee[$record->id] = $record;
        // $final_record_grantee[$record->id]->grantee_grant_id = json_decode($record->grantee_grant_id);
    }
    // echo '<pre>';print_r($final_record_grantee);die;
    // echo '<pre>';print_r(safe_parse_json(json_encode($final_record_grantee)));die;
    // echo "<pre>"; var_dump($final_record_grantee);
?>
    <script>
        var currentUserReviews = JSON.parse(`<?php echo safe_parse_json(json_encode($final_record_grantee)); ?>`);
    </script>
<?php endif; ?>

<script>
    var currentPaymentProofOfExpenses = JSON.parse(`<?php echo safe_parse_json(json_encode([])); ?>`);
</script>

<?php
if (!empty($payment_item)) :
    $final_item = [];
    foreach ($payment_item as $row) {
        $final_item[] = $row;
    }
?>
    <script>
        var currentPaymentItems = JSON.parse(`<?php echo safe_parse_json(json_encode($final_item)); ?>`);
    </script>
<?php endif; ?>

<?php
if (!empty($payment_bulk['payment_records'])) :
    $final_record_bulk = [];
    foreach ($payment_bulk['payment_records'] as $record) {
        $final_record_bulk[$record->id] = $record;
    }
?>
    <script>
        var currentPaymentBulk = JSON.parse(`<?php echo safe_parse_json(json_encode($final_record_bulk)); ?>`);
    </script>
<?php endif; ?>