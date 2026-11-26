<style>
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
</style>
<?php 
$status_returning = [
    STATUS_RETURNING_SUCCESSFUL, 
    STATUS_NEW_RETURNING, 
    STATUS_RETURNING_REVISED,
    STATUS_SET_TO_ALUMNI
];
?>
<?php if($is_admin){ ?>
<div class="row">
    <div class="col-lg-12">
        <h1><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header"><?= $grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>
<?php } ?>

<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>
<form id="form" method="POST" enctype="multipart/form-data">
<input type="hidden" name="btn" id="btn_value">

<div class="row warp-alumni-page">
    <div class="col-lg-12">
        <div class="panel panel-body">
            <div class="panel-group" id="accordionFive" role="tablist" aria-multiselectable="true">
                <!-- In country Allowance -->
                <div class="panel panel-default">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionFive" href="#collapseFiveICA" aria-expanded="false" aria-controls="collapseFiveICA" onclick="set_session('ic_allowance'); return get_visa(this);">
                        <div class="panel-heading-returning text-left" role="tab" id="submission_result">
                            <h4 class="panel-title">
                                In Country Allowance
                            </h4>
                        </div>
                    </a>
                    <div id="collapseFiveICA" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'ic_allowance' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                        <div class="panel-body">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Payment</p>
                            <div class="col-lg-9">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="40">#</th>
                                            <th>Description</th>
                                            <th>Amount (IDR)</th>
                                            <th>Amount (USD)</th>
                                            <th>Proof of Transfer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach($payment_items as $p_item) { ?>
                                            <?php if($p_item->proof) { ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $p_item->description ?></td>
                                                <td><?= $p_item->nominal_idr ? format_money($p_item->nominal_idr, 'IDR') : '' ?></td>
                                                <td><?= $p_item->nominal ? format_money($p_item->nominal, 'USD') : '' ?></td>
                                                <td>
                                                    <?php if($p_item->proof) { ?>
                                                    <a href="<?php echo site_url($p_item->proof); ?>" class="lightbox btn btn-primary btn-xs" aria-haspopup="dialog">
                                                        View
                                                    </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $no++; } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pre-Departure Allowance -->
                <?php if($is_admin || (!$is_admin && $grantee_grant->set_to_pre_departure_allowance)) { ?>
                <div class="panel panel-default">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionFive" href="#collapseFivePDA" aria-expanded="false" aria-controls="collapseFivePDA" onclick="set_session('pd_allowance'); return get_visa(this);">
                        <div class="panel-heading-returning text-left" role="tab" id="submission_result">
                            <h4 class="panel-title">
                                Pre-Departure Allowance
                            </h4>
                        </div>
                    </a>
                    <div id="collapseFivePDA" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'pd_allowance' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <?php if(has_permission('nominee', 'departure') || !$is_admin) { ?>
                                <?php if($is_admin) { ?>
                                <div class="row mb-5 toggle-pre-departure"> 
                                    <div class="col-lg-12">
                                        <div class="TriSea-technologies-Switch">
                                            <span class="mr-2"> Set to Pre-Departure Allowance</span>
                                            <input data-id="<?= $grantee_grant->id ?>" onchange="enable_toogle_allowance(this, 'set_to_pre_departure_allowance', 'grantee_grant')" id="set_to_pre_departure_allowance" name="set_to_pre_departure_allowance" type="checkbox" <?= $grantee_grant->set_to_pre_departure_allowance  ? 'checked' : '' ?>/>
                                            <label for="set_to_pre_departure_allowance" class="label-primary"></label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <p>Your pre-departure allowance consist of:</p>
                                    <div class="panel-body">
                                        <?php if($grantee_grant->visibility_travel_allowance) { ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Travel Allowance</label>
                                                <input type="text" id="travel_allowance" class="form-control" name="travel_allowance" disabled value="<?= $grantee_grant->travel_allowance ? number_format($grantee_grant->travel_allowance) : '' ?>">
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
    
                                    <?php if($grantee_grant->visibility_settling_allowance || $grantee_grant->visibility_technology_allowance) { ?>
                                    <div class="panel-body" style="margin-bottom:-30px;">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Settling-in and Equipment Allowances</label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
    
                                    <?php if($grantee_grant->visibility_settling_allowance || $grantee_grant->visibility_technology_allowance) { ?>
                                    <div class="panel-body">
                                    <?php } ?>
                                        <?php if($grantee_grant->visibility_settling_allowance) { ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Settling in Allowance</label>
                                                <input type="text" id="settling_allowance" class="form-control" name="settling_allowance" disabled value="<?= $grantee_grant->settling_allowance ? number_format($grantee_grant->settling_allowance) : '' ?>">
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if($grantee_grant->visibility_technology_allowance) { ?>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Equipment Allowance</label>
                                                <input type="text" id="technology_allowance" class="form-control" name="technology_allowance" disabled value="<?= $grantee_grant->technology_allowance ? number_format($grantee_grant->technology_allowance) : '' ?>">
                                            </div>
                                        </div>
                                        <?php } ?>
                                    <?php if($grantee_grant->visibility_settling_allowance || $grantee_grant->visibility_technology_allowance) { ?>
                                        </div>
                                    <?php } ?>
                                    <div class="panel-body">
                                        <p>AMINEF will transfer the allowances in US Dollar (USD) to your local account in Indonesia in a Rupiah (IDR) or US Dollar account (USD) account.
                                        <br /><b><u>Note: AMINEF will NOT be held responsible for the exchange rate fluctuation upon receiving the fund in your account.</u></b></p>
                                        <p>Please select of the available local bank account that you have included in your page at AMINEF Portal for us to transfer the allowances.</p>
    
                                        <?php if($is_admin){ ?>
                                        <div class="row my-5">
                                            <div class="col-lg-12">
                                                <div class="TriSea-technologies-Switch">
                                                    <span class="mr-2"> Enable Bank Info</span>
                                                    <input data-id="<?= $visa_interview->id ?>" onchange="enable_toogle_allowance(this, 'enable_bank_info', 'visa_interview')" id="enable_bank_info" name="enable_bank_info" type="checkbox" <?= $visa_interview->enable_bank_info  ? 'checked' : '' ?>/>
                                                    <label for="enable_bank_info" class="label-primary"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="panel-body">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label>Bank Info</label>
                                                    <select id="bank_info_id" class="form-control select2" style="width:100%" name="bank_info_id" <?= $is_admin || (!$is_admin && $visa_interview->enable_bank_info) ? '' : 'disabled' ?>>
                                                        <option value=''>-- Select --</option>
                                                        <?php foreach ($bank_info as $kb => $bi) { ?>
                                                            <option <?= $visa_interview->bank_info_id == $bi->id ? 'selected' : '' ?> value="<?= $bi->id ?>"><?= $bi->beneficiary_name ?> (<?= $bi->account_number ?>) - <?= $bi->bank_name ?></option>
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
                                        <p><b>Note : </b><i>If you prefer to use a new bank account to receive the allowances which is not available in your application, you should input this information in the system. Go the “My Profile” page, click the “Personal Information” section, and then complete the required information in the “bank info” sub-section. </i></p>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if($is_admin || (!$is_admin && $visa_interview->enable_bank_info)){ ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="pull-right">
                                    <button type="button" name="btn" value="save_visa_interview_allowance" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_visa_interview_allowance')" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

                <?php if (($is_admin || in_array($grantee_grant->status, $status_returning)) && $grantee_grant->is_degree) { ?>
                <div class="panel panel-default">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionFive" href="#collapseHotelAllowance" aria-expanded="false" aria-controls="collapseHotelAllowance" onclick="return set_session('hotel_allowance')">
                        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
                            <h4 class="panel-title label-after-visa">
                                Return Allowance
                            </h4>
                        </div>
                    </a>
                    <div id="collapseHotelAllowance" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'hotel_allowance' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="panel-body">
                                        <p>
                                            AMINEF will provide a USD$300 allowance to support your return baggage expenses. This allowance will be transferred after you submit your used international boarding pass in the portal and inform to your PIC within 7 days of your arrival.
                                        </p>
                                        <ul>
                                            <li>The transfer will be made in U.S. Dollars (USD) to the local bank account you have listed in your Portal profile (either an IDR or USD account).</li>
                                            <li>Please ensure your bank details are correct and up to date. If you prefer to use a new bank account to receive the allowance that is not yet listed, you must update this information in the Portal. Go to the “My Profile” page, click on “Personal Information,” and complete the required details in the “Bank Info” section.</li>
                                        </ul>
        
                                        <div class="panel-body">
                                            <input type="hidden" name="upon_return_id" value="<?= $upon_return->id ?>">
                                            <?php if($is_admin){ ?>
                                            <div class="row my-5">
                                                <div class="col-lg-12">
                                                    <div class="TriSea-technologies-Switch">
                                                        <span class="mr-2"> Enable Bank Info</span>
                                                        <input data-id="<?= $upon_return->id ?>" onchange="enable_toogle_allowance(this, 'enable_bank_info', 'upon_return')" id="enable_bank_info_returning" name="enable_bank_info_returning" type="checkbox" <?= $upon_return->enable_bank_info  ? 'checked' : '' ?>/>
                                                        <label for="enable_bank_info_returning" class="label-primary"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label>Bank Info</label>
                                                    <select id="bank_info_id_returning" class="form-control select2" style="width:100%" name="bank_info_id_returning" <?= $is_admin || (!$is_admin && $upon_return->enable_bank_info) ? '' : 'disabled' ?>>
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
                                                    <input type="text" class="form-control" name="bank_name" id="bank_name_returning" readonly placeholder="Bank Name">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Bank Address</label>
                                                    <input type="text" class="form-control" name="bank_address" id="bank_address_returning" readonly placeholder="Bank Address">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Beneficiary Name</label>
                                                    <input type="text" class="form-control" name="beneficiary_name" id="beneficiary_name_returning" readonly placeholder="Beneficiary Name">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Account Number</label>
                                                    <input type="text" class="form-control" name="account_number" id="account_number_returning" readonly placeholder="Account Number">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Routing Number</label>
                                                    <input type="text" class="form-control" name="routing_number" id="routing_number_returning" readonly placeholder="Routing Number">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Swift Code</label>
                                                    <input type="text" class="form-control" name="swift_code" id="swift_code_returning" readonly placeholder="Swift Code">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Currency</label>
                                                    <input type="text" class="form-control" name="currency" id="currency_returning" readonly placeholder="Currency">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>First page of bank account information (buku tabungan halaman pertama)</label>
                                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                                        <a href="" class="lightbox aimage_returning hide" aria-haspopup="dialog">
                                                            <img id="preview_image_account_book_returning" src="" width="100" style="min-height:60px;object-fit:contain;">
                                                        </a>
                                                        <a href="" id="button_download_account_book_returning" download title="Click to download" class="btn btn-primary btn-xs mt-5 hide" style="position:absolute; top:-30px; right:-28px;color:#fff">
                                                            <i class="fa fa-download fa-fw"></i>
                                                        </a>
                                                    </div>
                                                    <a href="" id="button_preview_account_book_returning" class="btn btn-warning fileview lightbox preview-profile hide" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                                                </div>
                                            </div>
                                        </div>
                                        <p><b>Note : </b><i>AMINEF is not responsible for any exchange rate fluctuations upon receipt of the funds in your account. </i></p>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="pull-right">
                                    <button type="button" name="btn" value="save_visa_interview_allowance_returning" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_visa_interview_allowance_returning')" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</form>

<?php $this->session->unset_userdata('last_tab'); ?>
<?php $this->session->unset_userdata('last_list'); ?>