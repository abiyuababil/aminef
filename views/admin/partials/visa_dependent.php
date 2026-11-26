<?php if(($is_admin ? ($is_alumni_page ? $grantee_grant->show_visa_dependent : true) : false) || $grantee_grant->show_visa_dependent) { ?>
<?php //if($is_admin || $grantee_grant->show_visa_dependent) { ?>
<div class="panel panel-default">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionParent" href="#collapseParenDependent" aria-expanded="false" aria-controls="collapseParenDependent" onclick="return set_session('new_visa_dependent')">
        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
            <h4 class="panel-title">
                Visa for Dependent (New)
            </h4>
        </div>
    </a>
    <div id="collapseParenDependent" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'new_visa_dependent' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-group mt-2" id="accordionVisaDependentItem" role="tablist" aria-multiselectable="true">
            <?php if($is_admin) { ?>
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="TriSea-technologies-Switch">
                        <span class="mr-2"> Show Visa for Dependent</span>
                        <input onclick="show_hide_visa_dependent(this, <?= $grantee_grant->id ?>)" id="show_visa_dependent" name="show_visa_dependent" type="checkbox" <?= $grantee_grant->show_visa_dependent  ? 'checked' : '' ?>/>
                        <label for="show_visa_dependent" class="label-primary"></label>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="panel-body">
                <div id="visa-dependent-wrapper">
                    <?php foreach($visa_dependents as $kvb => $visa_dependent){ ?>
                        <?php $this->load->view('admin/partials/template_visa_dependent_current', [
                            'visa_dependent' => $visa_dependent,
                            'kvb' => $kvb
                        ]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <?php if($is_admin) { ?>
                        <button type="button" id="addVisaRenewal" data-dependent="1" class="btn btn-primary">+ Add Visa Dependent</button>
                        <?php } ?>
                        <button type="button" 
                                name="btn" 
                                value="save_visa_interview_dependent" 
                                data-type="dependent"
                                onclick="
                                    if (!validateVisaRenewal('dependent')) return false;
                                    return showSwal(
                                        'confirm_submit',
                                        'Are you sure you want to save?',
                                        false,
                                        false,
                                        false,
                                        '#form',
                                        'save_visa_interview_dependent'
                                    );
                                "
                                class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php } ?>