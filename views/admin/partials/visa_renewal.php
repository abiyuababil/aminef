<?php if($visa_renewals || $is_admin) { ?>
<div class="panel panel-default">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionParent" href="#collapseParenRenewal" aria-expanded="false" aria-controls="collapseParenRenewal" onclick="return set_session('visa_renewal')">
        <div class="panel-heading-visa text-left" role="tab" id="visa_renewal">
            <h4 class="panel-title">
                Visa Renewal
            </h4>
        </div>
    </a>
    <div id="collapseParenRenewal" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'visa_renewal' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="visa_renewal">
        <div class="panel-group mt-2" id="accordionVisaRenewalItem" role="tablist" aria-multiselectable="true">
            <div class="panel-body">
                <div id="visa-renewal-wrapper">
                    <?php foreach($visa_renewals as $kvr => $visa_renewal){ ?>
                        <?php $this->load->view('admin/partials/template_visa_renewal_current', [
                            'visa_renewal' => $visa_renewal,
                            'kvr' => $kvr
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
                        <button type="button" id="addVisaRenewal" data-dependent="0" class="btn btn-primary">+ Add Visa Renewal</button>
                        <?php } ?>
                        <button type="button" 
                                name="btn" 
                                value="save_visa_renewal" 
                                data-type="renewal"
                                onclick="
                                    if (!validateVisaRenewal('renewal')) return false;
                                    return showSwal(
                                        'confirm_submit',
                                        'Are you sure you want to save?',
                                        false,
                                        false,
                                        false,
                                        '#form',
                                        'save_visa_renewal'
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