<div class="modal fade" id="mdl_add_record_bulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="exampleModalLabel">Add Bulk Panelist Payment</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body record-payment-add">
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Entry Date</label>
                <input type="text" class="payment-date-record-bulk form-control datepicker" form="form_payment_bulk" name="add_record_bulk[payment_date]" placeholder="Entry Date" onchange="remove_error('payment-date-record-bulk-validation')">
                <div class="text-danger invalid-tooltip payment-date-record-bulk-validation hide" style="display: block;">Entry Date is Required</div> 
            </div>
            <div class="col-lg-6">
                <label>Program Name</label>
                <input type="text" class="form-control" form="form_payment_bulk" name="add_record_bulk[description]" placeholder="Program Name">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Details</label>
                <textarea type="text" form="form_payment_bulk" class="form-control" name="add_record_bulk[admin_note]" placeholder="Details"></textarea>
            </div>
            <div class="col-lg-6">
                <label>Priority</label>
                <select class="form-control" name="add_record_bulk[priority]" form="form_payment_bulk">
                    <option value="">Select Priority</option>
                    <option value="1" <?php echo $row['priority'] == 1 ? 'selected' : ''; ?>>Normal</option>
                    <option value="2" <?php echo $row['priority'] == 2 ? 'selected' : ''; ?>>Urgent</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Record Status</label>
                <select form="form_payment_bulk" class="form-control" name="add_record_bulk[record_status]" id="record_status_add_bulk">
                    <?php
                    if ($record_status) {
                        foreach ($record_status as $ps) {
                            ?>
                            <option value="<?= $ps->id ?>"><?= $ps->name ?></option>
                        <?php
                            }
                        }
                        ?>
                </select>
            </div>
            <div class="col-lg-6">
                <label>Finance Note</label>
                <textarea type="text" form="form_payment_bulk" class="form-control" name="add_record_bulk[finance_note]" placeholder="Finance Note"></textarea>
            </div>
        </div>
        <?php if (!is_null($memo_budget)) { ?>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Reference</label>
                <?= generate_select($memo_budget, 'add_record_bulk[user_grantee_grant_memo_id]', 'id', 'file_name', '', '', false, 'form_payment_bulk'); ?>
                <div class="text-danger invalid-tooltip memo-bulk-validation hide" style="display: block;">Reference is Required</div> 
            </div>
        </div>
        <?php } ?>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">3rd Party Payment</label>
                <select name="add_record_bulk[third_party_payment]" form="form_payment_bulk" data-hide-object="parent-vendor-bulk" class="form-control" id="third_party_payment_add_record_bulk" data-action="add_record_bulk">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="col-lg-6">
            <?php if ($this->session->userdata('role') == 'finance') { ?>    
                <label>Notify Admin via Email</label>
                <select class="form-control" form="form_payment_bulk" name="add_record_bulk[notify_admin]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            <?php } else { ?>
                <!-- <label>Notify Finance via Email</label>
                <select class="form-control" form="form_payment_bulk" name="add_record_bulk[notify_finance]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select> -->
            <?php } ?>
            </div>
            <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
            <div class="col-lg-6 category_payment_bulk">
                <label class="text-center">Category</label>
                <select name="add_record_bulk[category_id]" form="form_payment_bulk" class="form-control" id="select_category_add_bulk" data-action="add_record_bulk" onchange="remove_error('category-validation-add_record_bulk');">
                    <option value="">-- Select Category --</option>
                    <option value="Grant Cost">Grant Cost</option>
                    <option value="Grant Supporting">Grant Supporting</option>
                    <option value="International Travel">International Travel</option>
                    <!-- <option value="GRE Subject">GRE Subject</option> -->
                </select>
                <div class="text-danger invalid-tooltip category-validation-add_record_bulk hide" style="display: block;">Category is Required</div>
            </div>
            <?php } ?>
        </div>

        <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Sub Category</label>
                <select id="select_sub_category_record_bulk_0" onchange="select_payment_item_record_bulk('0'); remove_error('sub-category-validation-add_record_bulk');" class="record-payment-sub-category-bulk form-control select2" form="form_payment_bulk" name="add_record_bulk[sub_category]">
                    <option value="">-- Select Sub Category --</option>
                </select>
                <div class="text-danger invalid-tooltip sub-category-validation-add_record_bulk hide" style="display: block;">Sub Category</div>  
            </div>
            <div class="col-lg-6">
                <label>Payment Item</label>
                <select onchange="remove_error('item-category-validation-add_record_bulk');" id="select_payment_item_record_bulk_0" class="record-payment-item-bulk form-control select2" form="form_payment_bulk" name="add_record_bulk[item]">
                    <option value="">-- Select Item --</option>
                </select>
                <div class="text-danger invalid-tooltip item-category-validation-add_record_bulk hide" style="display: block;">Payment Item is Required</div>  
            </div>
        </div>
        <?php } ?>

        <div class="row form-group">
            <div class="col-lg-12">
                <label class="text-center">Payment For</label><br/>
                <div class="radio d-inline mr-4">
                    <label>
                        <input type="radio" 
                                name="add_record_bulk[payment_for]" 
                                form="form_payment_bulk"
                                style="margin-top:1px" 
                                value="panellist">
                                Panelist
                    </label>
                </div>
                <div class="radio d-inline">
                    <label>
                        <input type="radio" 
                                name="add_record_bulk[payment_for]" 
                                form="form_payment_bulk"
                                style="margin-top:1px" 
                                value="vendor">
                                Vendor
                    </label>
                </div>
                <div class="text-danger invalid-tooltip paymentfor-validation-bulk hide" style="display: block;">Payment for is Required</div> 
            </div>
        </div>
        
        <?php if($this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
        <div class="parent-vendor-bulk hide">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Vendor Name</label>
                    <select name="add_record_bulk[vendor_id]" data-mode="add" class="vendor form-control">
                        <option value="">-- Select Vendor --</option>
                        <?php foreach($vendors as $vendor) { ?>
                            <option value="<?= $vendor->id; ?>"><?= $vendor->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Vendor Address</label>
                    <textarea disabled rows="3" class="edit-vendor-address form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Beneficiary Name</label>
                    <input type="text" disabled class="edit-beneficiary-name form-control">
                </div>
                <div class="col-lg-6">
                    <label>Bank Name</label>
                    <input type="text" disabled class="edit-bank-name form-control">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Bank Address</label>
                    <textarea disabled rows="3" class="edit-bank-address form-control"></textarea>
                </div>
                <div class="col-lg-6">
                    <label>Account Number</label>
                    <input type="text" disabled class="edit-account-number form-control">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>SWIFT Code</label>
                    <input type="text" disabled class="edit-swift-code form-control">
                </div>
                <div class="col-lg-6">
                    <label>Routing Number</label>
                    <input type="text" disabled class="edit-routing-number form-control">
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
        <div class="sec-panellist hide">
            <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PANELIST</p>
            <div class="row mt-3" style="padding:0 15px 15px">
                <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Panelist</label>
                            <select name="add_record_bulk[panellist_id]" id="panellist_id_bulk" form="form_payment_bulk" class="form-control selectpicker" data-live-search="true" onchange="select_panellist(this, 'add_bulk')" style="width:100%">
                                <option value="">-- Select Panelist --</option>
                                <?php foreach ($panellist as $p) { ?>
                                <option value="<?= $p->id ?>"  data-id="<?php echo $p->id; ?>" data-name="<?php echo $p->name; ?>"><?= $p->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Field of Study</label>
                            <input type="text" id="field_of_study_add_bulk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Email</label>
                            <input type="text" id="panellist_email_add_bulk" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Telp</label>
                            <input type="text" id="panellist_telp_add_bulk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Bank Info</label>
                            <input type="text" id="panellist_bank_info_add_bulk" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Beneficiary Name</label>
                            <input type="text" id="panellist_beneficiary_add_bulk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Account</label>
                            <input type="text" id="panellist_account_add_bulk" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Status Panelist</label>
                            <input type="text" id="panellist_status_add_bulk" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-vendor hide">
            <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> Vendor</p>
            <div class="row mt-3" style="padding:0 15px 15px">
                <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Vendor Name</label>
                            <select name="add_record_bulk[vendor_id]" id="hotel_id_bulk" form="form_payment_bulk" class="form-control select2" onchange="select_hotel(this, 'add_bulk')" style="width:100%">
                                <option value="">-- Select Vendor --</option>
                                <?php foreach ($vendors as $h) { ?>
                                <option value="<?= $h->id ?>"  data-id="<?php echo $h->id; ?>" data-name="<?php echo $h->name; ?>"><?= $h->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Telp</label>
                            <input type="text" id="hotel_telp_add_bulk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Bank Name</label>
                            <input type="text" id="hotel_bank_info_name_add_bulk" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Beneficiary Name</label>
                            <input type="text" id="hotel_beneficiary_add_bulk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Account Number</label>
                            <input type="text" id="hotel_account_add_bulk" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Address</label>
                            <textarea type="text" form="form_payment_bulk" class="form-control" id="hotel_address_add_bulk" readonly></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="row pull-right">
            <div class="col-lg-4">
                <a class="btn btn-primary add-more-data-payment"><i class="fa fa-plus"></i> Add Data</a>
            </div>
        </div>

        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> Payment Information</p>
        <div class="row mt-3" style="padding:0 15px 15px">
            <div class="col-lg-12 mb-0 list-data-payment-grant" style="background-color:#e9eef4;padding:10px;">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button class="btn-submit-record-disabled-bulk btn btn-success hide" disabled>Saving Data...</button>
        <button type="submit" id="btn-submit-record-bulk" data-action="create" name="btn" value="save_rec_bulk" form="form_payment_bulk" class="btn btn-success">Save</button>
        <input id="hide-btn" type="hidden" disabled="disabled" name="btn" form="form_payment_bulk" value="save_rec_bulk">
      </div>
    </div>
  </div>
</div>

<!-- ============================== EDIT MODAL ========================= -->
<div class="modal fade" id="mdl_edit_record_bulk" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditPanelist" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="modalLabelEditPanelist">Edit Bulk Panelist Payment</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <input type="hidden" form="form_payment_bulk" id="delete_detail_payment_record_bulk" name="edit_record_bulk[delete_detail_payment_record]">
        <input type="hidden" form="form_payment_bulk" id="delete_payment_record_bulk" name="edit_record_bulk[delete_payment_record]">
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-6">
            <label class="text-center">Entry Date</label>
                <input type="text" form="form_payment_bulk" id="payment_date_bulk" class="payment-date-record-bulk form-control form-control-view datepicker" name="edit_record_bulk[payment_date]" placeholder="Entry Date">
                <input type="hidden" form="form_payment_bulk" id="payment_id_bulk" name="edit_record_bulk[payment_id]">
                <div class="text-danger invalid-tooltip payment-date-record-bulk-validation hide" style="display: block;">Entry Date is Required</div>        
            </div>
            <div class="col-lg-6">
                <label class="text-center">Program Name</label>
                <input type="text" class="form-control form-control-view" form="form_payment_bulk" id="description_bulk" name="edit_record_bulk[description]" placeholder="Program Name">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">Details</label>
                <textarea type="text" form="form_payment_bulk" id="admin_note_bulk" class="form-control form-control-view" name="edit_record_bulk[admin_note]" placeholder="Details"></textarea>
            </div>
            <div class="col-lg-6">
                <label>Priority</label>
                <select class="form-control form-control-view" name="edit_record_bulk[priority]" form="form_payment_bulk" id="edit_record_priority_bulk">
                    <option value="">Select Priority</option>
                    <option value="1" <?php echo $row['priority'] == 1 ? 'selected' : ''; ?>>Normal</option>
                    <option value="2" <?php echo $row['priority'] == 2 ? 'selected' : ''; ?>>Urgent</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">Record Status</label>
                <select <?= is_admin() ? '' : '' ?> form="form_payment_bulk" id="record_status_bulk" class="form-control form-control-view status" name="edit_record_bulk[record_status]">
                    <option value="">-- Select Record Status --</option>
                    <?php
                    if ($record_status) {
                        foreach ($record_status as $ps) {
                            ?>
                            <option value="<?= $ps->id ?>"><?= $ps->name ?></option>
                        <?php
                            }
                        }
                        ?>
                </select>
            </div>
            <div class="col-lg-6">
                <label class="text-center">Finance Note</label>
                <textarea type="text" form="form_payment_bulk" id="finance_note_bulk" <?= is_admin() ? '' : '' ?> class="form-control form-control-view" name="edit_record_bulk[finance_note]" placeholder="Finance Note"></textarea>
            </div>
        </div>
        
        <?php if (!is_null($memo_budget)) { ?>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Reference</label>
                <?php //generate_select($memo_budget, 'edit_record_bulk[user_grantee_grant_memo_id]', 'id', 'file_name', '', 'user_grantee_grant_memo_id_bulk', false, 'form_payment_bulk'); ?>
                <select form="form_payment_bulk" class="form-control form-control-view" name="edit_record_bulk[user_grantee_grant_memo_id]" id="user_grantee_grant_memo_id_bulk">
                    <option value="">--Select Data--</option>
                    <?php foreach ($memo_budget as $mb) { ?>
                        <option <?= $mb->is_active == 'Yes' ? '' : 'class="memo-budget-inactive" disabled' ?> value="<?= $mb->id ?>" data-is-active="<?= $mb->is_active ?>"><?= $mb->file_name ?><?= $mb->is_active == 'Yes' ? '' : ' (Inactive)' ?></option>
                    <?php } ?>
                </select>
                <div class="text-danger invalid-tooltip memo-bulk-validation hide" style="display: block;">Reference is Required</div> 
            </div>
        </div>
        <?php } ?>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">3rd Party Payment</label>
                <select name="edit_record_bulk[third_party_payment]" form="form_payment_bulk" data-hide-object="edit-parent-vendor" class="form-control form-control-view" id="third_party_payment_edit_record_bulk" data-action="edit_record_bulk">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="col-lg-6">
            <?php if ($this->session->userdata('role') == 'finance') { ?>    
                <label>Notify Admin</label>
                <select class="form-control form-control-view" id="edit_notify_admin_bulk" form="form_payment_bulk" name="edit_record_bulk[notify_admin]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            <?php } else { ?>
                <!-- <label>Notify Finance</label>
                <select class="form-control form-control-view" id="edit_notify_finance_bulk" form="form_payment_bulk" name="edit_record_bulk[notify_finance]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select> -->
            <?php } ?>
            </div>
            <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
            <div class="col-lg-6 category_payment_bulk" id="category_payment_edit_bulk">
                <label class="text-center">Category</label>
                <select name="edit_record_bulk[category_id]" form="form_payment_bulk" class="form-control form-control-view" data-action="edit_record_bulk" id="select_category_edit_bulk" data-action="edit_record_bulk"> 
                    <option value="">-- Select Category --</option>
                    <option value="Grant Cost">Grant Cost</option>
                    <option value="Grant Supporting">Grant Supporting</option>
                    <option value="International Travel">International Travel</option>
                    <!-- <option value="GRE Subject">GRE Subject</option> -->
                </select>
                <div class="text-danger invalid-tooltip category-validation-edit_record hide" style="display: block;">Category is Required</div>
            </div>
            <?php } ?>

        </div>
        <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Sub Category</label>
                <select id="sub_category_bulk" onchange="select_payment_item_record_bulk_edit('0'); remove_error('sub-category-validation-edit_record_bulk');" class="record-payment-sub-category-bulk form-control form-control-view select2" form="form_payment_bulk" name="edit_record_bulk[sub_category]">
                    <option value="">-- Select Sub Category --</option>
                </select>
                <div class="text-danger invalid-tooltip sub-category-validation-edit_record_bulk hide" style="display: block;">Sub Category</div>  
            </div>
            <div class="col-lg-6">
                <label>Payment Item</label>
                <select onchange="remove_error('item-category-validation-edit_record_bulk');" id="payment_item_bulk" class="record-payment-item-bulk form-control form-control-view select2" form="form_payment_bulk" name="edit_record_bulk[item]">
                    <option value="">-- Select Item --</option>
                </select>
                <div class="text-danger invalid-tooltip item-category-validation-edit_record_bulk hide" style="display: block;">Payment Item is Required</div>  
            </div>
        </div>
        <?php } ?>
        <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
        <div class="row form-group">
            <div class="col-lg-12">
                <label class="text-center">Payment For</label><br/>
                <div class="radio d-inline mr-4">
                    <label>
                        <input type="radio" 
                                id="radio-panellist-bulk"
                                form="form_payment_bulk"
                                class="form-control-view radio-for"
                                name="edit_record_bulk[payment_for]" 
                                style="margin-top:1px" 
                                value="panellist">
                                Panelist
                    </label>
                </div>
                <div class="radio d-inline">
                    <label>
                        <input type="radio" 
                                form="form_payment_bulk"
                                class="form-control-view radio-for"
                                id="radio-vendor-bulk"
                                name="edit_record_bulk[payment_for]" 
                                style="margin-top:1px" 
                                value="vendor">
                                Vendor
                    </label>
                </div>
                <input type="hidden" form="form_payment_bulk" name="edit_record_bulk[payment_for]" class="paymentfor-input">
            </div>
        </div>
        <div class="sec-panellist hide">
            <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PANELIST</p>
            <div class="row mt-3" style="padding:0 15px 15px">
                <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Panelist</label>
                            <select name="edit_record_bulk[panellist_id]" id="panellist_id_bulk_edit" form="form_payment_bulk" class="form-control form-control-view selectpicker" data-live-search="true" onchange="select_panellist(this, 'edit_bulk')" style="width:100%">
                                <option value="">-- Select Panelist --</option>
                                <?php foreach ($panellist as $p) { ?>
                                <option value="<?= $p->id ?>" data-id="<?php echo $p->id; ?>" data-name="<?php echo $p->name; ?>"><?= $p->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Field of Study</label>
                            <input type="text" id="field_of_study_edit_bulk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Email</label>
                            <input type="text" id="panellist_email_edit_bulk" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Telp</label>
                            <input type="text" id="panellist_telp_edit_bulk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Bank Info</label>
                            <input type="text" id="panellist_bank_info_edit_bulk" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Beneficiary Name</label>
                            <input type="text" id="panellist_beneficiary_edit_bulk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Account</label>
                            <input type="text" id="panellist_account_edit_bulk" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Status Panelist</label>
                            <input type="text" id="panellist_status_edit_bulk" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-vendor hide">
        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> Vendor</p>
        <div class="row mt-3" style="padding:0 15px 15px">
            <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Vendor Name</label>
                        <select name="edit_record_bulk[vendor_id]" id="hotel_id_bulk_edit" form="form_payment_bulk" class="form-control form-control-view select2" onchange="select_hotel(this, 'edit')" style="width:100%">
                            <option value="">-- Select Vendor --</option>
                            <?php foreach ($vendors as $h) { ?>
                            <option value="<?= $h->id ?>" data-id="<?php echo $h->id; ?>" data-name="<?php echo $h->name; ?>"><?= $h->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Telp</label>
                        <input type="text" id="hotel_telp_edit" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Bank Name</label>
                        <input type="text" id="hotel_bank_info_name_edit" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Beneficiary Name</label>
                        <input type="text" id="hotel_beneficiary_edit" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Account Number</label>
                        <input type="text" id="hotel_account_edit" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Address</label>
                        <textarea type="text" form="form_payment_bulk" class="form-control form-control" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php } ?>

        <div class="row pull-right">
            <div class="col-lg-4">
                <a class="btn btn-primary edit-add-more-data-payment"><i class="fa fa-plus"></i> Add Data</a>
            </div>
        </div>
        
        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Payment Information</p>
        <div class="row mt-3" style="padding:0 15px 15px">
            <div class="col-lg-12 mb-0 list-data-payment-grant-edit" style="background-color:#e9eef4;padding:10px;" id="wrap-request-record-edit-bulk">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button class="btn-submit-record-disabled btn btn-success hide" disabled>Saving Data...</button>
        <button type="submit" id="btn-submit-record-edit-bulk" name="btn" value="edit_rec_bulk" form="form_payment_bulk" class="btn btn-success">Save</button>
        <input id="hide-btn-edit" type="hidden" disabled="disabled" form="form_payment_bulk" name="btn" value="edit_rec_bulk">
      </div>
    </div>
  </div>
</div>
<!-- ================================= END EDIT MODAL ======================== -->