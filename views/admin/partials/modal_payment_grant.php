

<div class="modal fade" id="mdl_add_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="exampleModalLabel">Add Panelist Payment</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body record-payment-add">
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Entry Date</label>
                <input type="text" class="payment-date-record form-control datepicker" form="form_payment" name="add_record[payment_date]" placeholder="Entry Date">
                <div class="text-danger invalid-tooltip payment-date-record-validation hide" style="display: block;">Entry Date is Required</div> 
            </div>
            <div class="col-lg-6">
                <label>Program Name</label>
                <input type="text" class="form-control" form="form_payment" name="add_record[description]" placeholder="Program Name">
            </div>
        </div>
        <div class="form-group row">
            <!-- <div class="col-lg-6">
                <label>Release Type</label>
                <select class="form-control" form="form_payment" name="add_record[release_type]">
                    <option value="">-- Select Release Type --</option>
                    <option value="Manual">Manual</option>
                    <option value="MRI">MRI</option>
                </select>
            </div> -->
            <div class="col-lg-6">
                <label>Details</label>
                <textarea type="text" form="form_payment" class="form-control" name="add_record[admin_note]" placeholder="Details"></textarea>
            </div>
            <div class="col-lg-6">
                <label>Priority</label>
                <select class="form-control" name="add_record[priority]" form="form_payment">
                    <option value="">Select Priority</option>
                    <option value="1" <?php echo $row['priority'] == 1 ? 'selected' : ''; ?>>Normal</option>
                    <option value="2" <?php echo $row['priority'] == 2 ? 'selected' : ''; ?>>Urgent</option>
                </select>
            </div>
        </div>
        <!-- <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">Approved Name</label>
                <input type="text" form="form_payment" class="form-control" name="add_record[approve_by]" placeholder="Approved Name"></input>
            </div>
        </div> -->
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Record Status</label>
                <select form="form_payment" class="form-control" name="add_record[record_status]" id="record_status_add">
                    <!-- <option value="">-- Select Record Status --</option> -->
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
                <textarea type="text" form="form_payment" class="form-control" name="add_record[finance_note]" placeholder="Finance Note"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <?php 
                $hide_upload_expense = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_expense')) {
                    $hide_upload_expense = '';
                }
            ?>
            <div class="col-lg-6 <?php echo $hide_upload_expense; ?>">
                <label>Proof of Expense</label>
                <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_expense; ?>" type="button" onclick="remove_file(this); return false;"><i class="fa fa-times"></i></button>
                <input type="file" form="form_payment" id="proof_expense" name="add_proof_expense_record">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
            <?php 
                $hide_upload_transfer = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                    $hide_upload_transfer = '';
                }
            ?>
            <div class="col-lg-6 <?php echo $hide_upload_transfer; ?>">
                <label>Proof of Transfer</label>
                <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this); return false;"><i class="fa fa-times"></i></button>
                <input type="file" onchange="update_to_release(this)" data-modal="mdl_add_record" id="proof" name="add_proof_record">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
        </div>
        <?php if (!is_null($memo_budget)) { ?>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Reference</label>
                <?= generate_select($memo_budget, 'add_record[user_grantee_grant_memo_id]', 'id', 'file_name'); ?>
            </div>
        </div>
        <?php } ?>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">3rd Party Payment</label>
                <select name="add_record[third_party_payment]" form="form_payment" data-hide-object="parent-vendor" class="form-control" id="third_party_payment_add_record" data-action="add_record">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="col-lg-6">
            <?php if ($this->session->userdata('role') == 'finance') { ?>    
                <label>Notify Admin via Email</label>
                <select class="form-control" form="form_payment" name="add_record[notify_admin]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            <?php } else { ?>
                <!-- <label>Notify Finance via Email</label>
                <select class="form-control" form="form_payment" name="add_record[notify_finance]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select> -->
            <?php } ?>
            </div>
            <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
            <div class="col-lg-6 category_payment">
                <label class="text-center">Category</label>
                <select name="add_record[category_id]" form="form_payment" class="form-control" id="select_category_add" data-action="add_record">
                    <option value="">-- Select Category --</option>
                    <option value="Grant Cost">Grant Cost</option>
                    <option value="Grant Supporting">Grant Supporting</option>
                    <option value="International Travel">International Travel</option>
                    <!-- <option value="GRE Subject">GRE Subject</option> -->
                </select>
                <div class="text-danger invalid-tooltip category-validation-add_record hide" style="display: block;">Category is Required</div>
            </div>
            <?php } ?>
        </div>

        <div class="row form-group">
            <div class="col-lg-6">
                <label class="text-center">Payment For</label><br/>
                <div class="radio d-inline mr-4">
                    <label>
                        <input type="radio" 
                                name="add_record[payment_for]" 
                                form="form_payment"
                                style="margin-top:1px" 
                                value="panellist">
                                Panelist
                    </label>
                </div>
                <div class="radio d-inline">
                    <label>
                        <input type="radio" 
                                name="add_record[payment_for]" 
                                form="form_payment"
                                style="margin-top:1px" 
                                value="vendor">
                                Vendor
                    </label>
                </div>
            </div>
        </div>
        
        <?php if($this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
        <div class="parent-vendor hide">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Vendor Name</label>
                    <select name="add_record[vendor_id]" data-mode="add" class="vendor form-control">
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
                            <select name="add_record[panellist_id]" id="panellist_id" form="form_payment" class="form-control select2" onchange="select_panellist(this, 'add')" style="width:100%">
                                <option value="">-- Select Panelist --</option>
                                <?php foreach ($panellist as $p) { ?>
                                <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Field of Study</label>
                            <input type="text" id="field_of_study_add" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Email</label>
                            <input type="text" id="panellist_email_add" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Telp</label>
                            <input type="text" id="panellist_telp_add" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Bank Info</label>
                            <input type="text" id="panellist_bank_info_add" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Beneficiary Name</label>
                            <input type="text" id="panellist_beneficiary_add" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Account</label>
                            <input type="text" id="panellist_account_add" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Status Panelist</label>
                            <input type="text" id="panellist_status_add" class="form-control" readonly>
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
                        <select name="add_record[vendor_id]" id="hotel_id" form="form_payment" class="form-control select2" onchange="select_hotel(this, 'add')" style="width:100%">
                            <option value="">-- Select Vendor --</option>
                            <?php foreach ($vendors as $h) { ?>
                            <option value="<?= $h->id ?>"><?= $h->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Telp</label>
                        <input type="text" id="hotel_telp_add" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Bank Name</label>
                        <input type="text" id="hotel_bank_info_name_add" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Beneficiary Name</label>
                        <input type="text" id="hotel_beneficiary_add" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="text-center">Account Number</label>
                        <input type="text" id="hotel_account_add" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-center">Address</label>
                        <textarea type="text" form="form_payment" class="form-control" id="hotel_address_add" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php } ?>

        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> Payment Information</p>
        <div id="wrap-request-record0">
            <div id="request-item-record-0" class="row mt-3 request-item-record0" style="padding:0 15px 15px">
                <div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">
                    <div class="col-lg-3">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Sub Category</label>
                            <select id="select_sub_category_record_0" onchange="select_payment_item_record('0')" class="record-payment-sub-category form-control select2" style="width:100%" form="form_payment" name="add_record[items][0][sub_category]">
                                <option value="">-- Select Sub Category --</option>
                            </select>
                            <div class="text-danger invalid-tooltip record-payment-sub-category-validation hide" style="display: block;">Sub Category</div>  
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Payment Item</label>
                            <select onchange="remove_error('record-payment-item-validation');" id="select_payment_item_record_0" class="record-payment-item form-control select2" style="width:100%" form="form_payment" name="add_record[items][0][item]">
                                <option value="">-- Select Item --</option>
                            </select>
                            <div class="text-danger invalid-tooltip record-payment-item-validation hide" style="display: block;">Payment Item is Required</div>  
                        </div>
                    </div>
                    <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                    <div class="col-lg-3">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Nominal IDR</label>
                            <input onchange="remove_error('record-payment-nominal-idr-validation');" type="text" form="form_payment" class="record-payment-nominal-idr form-control currency-idr" name="add_record[items][0][nominal_idr]">
                            <div class="text-danger invalid-tooltip record-payment-nominal-idr-validation hide" style="display: block;">Nominal IDR is Required</div>  
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-lg-3">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Nominal USD</label>
                            <input onchange="remove_error('record-payment-nominal-validation');" type="text" form="form_payment" class="record-payment-nominal form-control currency-usd" name="add_record[items][0][nominal]">
                            <div class="text-danger invalid-tooltip record-payment-nominal-validation hide" style="display: block;">Nominal is Required</div>  
                            <div class="text-danger invalid-tooltip record-payment-nominal-decimal-validation hide" style="display: block;">Please enter a valid value. The two nearest valid values are 0 and 1.</div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:0;">
            <a href="javascript:;" onclick="add_item_record(0)" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add Item</a>
            <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-record" style="display:none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button class="btn-submit-record-disabled btn btn-success hide" disabled>Saving Data...</button>
        <button type="submit" id="btn-submit-record" data-action="create" name="btn" value="save_rec" form="form_payment" class="btn btn-success">Save</button>
        <input id="hide-btn" type="hidden" disabled="disabled" name="btn" form="form_payment" value="save_rec">
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="mdl_edit_record" tabindex="-1" role="dialog" aria-labelledby="modalLabelEdit" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="modalLabelEdit">Edit Panelist Payment</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-6">
            <label class="text-center">Entry Date</label>
                <input type="text" form="form_payment" id="payment_date" class="payment-date-record form-control form-control-view datepicker" name="edit_record[payment_date]" placeholder="Entry Date">
                <input type="hidden" form="form_payment" id="payment_id" name="edit_record[payment_id]">
                <div class="text-danger invalid-tooltip payment-date-record-validation hide" style="display: block;">Entry Date is Required</div>        
            </div>
            <div class="col-lg-6">
                <label class="text-center">Program Name</label>
                <input type="text" class="form-control form-control-view" form="form_payment" id="description" name="edit_record[description]" placeholder="Program Name">
            </div>
        </div>
        <div class="form-group row">
            <!-- <div class="col-lg-6">
                <label class="text-center">Release Type</label>
                <select class="form-control form-control-view" form="form_payment" id="release_type" name="edit_record[release_type]">
                    <option value="">-- Select Release Type --</option>
                    <option value="Manual">Manual</option>
                    <option value="MRI">MRI</option>
                </select>
            </div> -->
            <div class="col-lg-6">
                <label class="text-center">Details</label>
                <textarea type="text" form="form_payment" id="admin_note" class="form-control form-control-view" name="edit_record[admin_note]" placeholder="Details"></textarea>
            </div>
            <div class="col-lg-6">
                <label>Priority</label>
                <select class="form-control form-control-view" name="edit_record[priority]" form="form_payment" id="edit_record_priority">
                    <option value="">Select Priority</option>
                    <option value="1" <?php echo $row['priority'] == 1 ? 'selected' : ''; ?>>Normal</option>
                    <option value="2" <?php echo $row['priority'] == 2 ? 'selected' : ''; ?>>Urgent</option>
                </select>
            </div>
        </div>
        <!-- <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">Approved Name</label>
                <input type="text" form="form_payment" id="approve_by" class="form-control form-control-view" name="edit_record[approve_by]" placeholder="Approved Name"></input>
            </div>
        </div> -->
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">Record Status</label>
                <select <?= is_admin() ? '' : '' ?> form="form_payment" id="record_status" class="form-control form-control-view status" name="edit_record[record_status]">
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
                <textarea type="text" form="form_payment" id="finance_note" <?= is_admin() ? '' : '' ?> class="form-control form-control-view" name="edit_record[finance_note]" placeholder="Finance Note"></textarea>
            </div>
        </div>
        
        <div class="form-group row">
            <?php 
                $hide_upload_expense = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_expense')) {
                    $hide_upload_expense = '';
                }
            ?>
            <div class="col-lg-6">
                <label class="text-center">Proof of Expense</label>
                <div class="<?php echo $hide_upload_expense; ?>">
                    <button class="btn btn-danger btn-xs pull-right hide-view <?php echo $hide_upload_expense; ?>" type="button" onclick="remove_file(this, 'expense', undefined, 'form_payment'); return false;"><i class="fa fa-times"></i></button>
                    <input type="file" id="proof_expense" form="form_payment" name="proof_expense" class="form-control-view">
                    <small class="file-for-testing">File Size Max 5MB</small>
                </div>
                <div class="expense-file">
                    <a href="" id="proof_expense_btn" class="lightbox">
                        <label class="label label-primary" style="cursor:pointer;">View Proof of Expense</label>
                    </a>
                 </div>
            </div>
            <?php 
                $hide_upload_transfer = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                    $hide_upload_transfer = '';
                }
            ?>
            <div class="col-lg-6">
                <label class="text-center">Proof of Transfer</label>
                <div class="<?php echo $hide_upload_transfer; ?>">
                    <button class="btn btn-danger btn-xs pull-right hide-view <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this, 'transfer', undefined, 'form_payment'); return false;"><i class="fa fa-times"></i></button>
                    <input type="file" form="form_payment" onchange="update_to_release(this)" data-modal="mdl_edit_record" id="proof" name="proof_record" class="form-control-view">
                    <small class="file-for-testing">File Size Max 5MB</small>
                </div>
                <div class="transfer-file">
                    <a href="" id="proof_btn" class="lightbox"><label class="label label-primary" style="cursor:pointer;">View Proof</label></a>
                </div>
            </div>
        </div>
        
        <?php if (!is_null($memo_budget)) { ?>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Reference</label>
                <?= generate_select($memo_budget, 'edit_record[user_grantee_grant_memo_id]', 'id', 'file_name'); ?>
            </div>
        </div>
        <?php } ?>
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-center">3rd Party Payment</label>
                <select name="edit_record[third_party_payment]" form="form_payment" data-hide-object="edit-parent-vendor" class="form-control form-control-view" id="third_party_payment_edit_record" data-action="edit_record">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="col-lg-6">
            <?php if ($this->session->userdata('role') == 'finance') { ?>    
                <label>Notify Admin</label>
                <select class="form-control form-control-view" id="edit_notify_admin" form="form_payment" name="edit_record[notify_admin]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            <?php } else { ?>
                <label>Notify Finance</label>
                <select class="form-control form-control-view" id="edit_notify_finance" form="form_payment" name="edit_record[notify_finance]">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            <?php } ?>
            </div>
            <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
            <div class="col-lg-6 category_payment" id="category_payment_edit">
                <label class="text-center">Category</label>
                <select name="edit_record[category_id]" form="form_payment" class="form-control form-control-view" id="select_category_edit" data-action="edit_record">
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
        <?php if($this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
        <div class="edit-parent-vendor hide">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="">Vendor Name</label>
                    <select name="edit_record[vendor_id]" id="vendor_id" data-mode="edit" class="vendor form-control form-control-view">
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
                    <textarea disabled rows="3" class="edit-vendor-address form-control form-control-view"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Beneficiary Name</label>
                    <input type="text" disabled class="edit-beneficiary-name form-control form-control-view">
                </div>
                <div class="col-lg-6">
                    <label>Bank Name</label>
                    <input type="text" disabled class="edit-bank-name form-control form-control-view">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Bank Address</label>
                    <textarea disabled rows="3" class="edit-bank-address form-control form-control-view"></textarea>
                </div>
                <div class="col-lg-6">
                    <label>Account Number</label>
                    <input type="text" disabled class="edit-account-number form-control form-control-view">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>SWIFT Code</label>
                    <input type="text" disabled class="edit-swift-code form-control form-control-view">
                </div>
                <div class="col-lg-6">
                    <label>Routing Number</label>
                    <input type="text" disabled class="edit-routing-number form-control form-control-view">
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
        <div class="row form-group">
            <div class="col-lg-6">
                <label class="text-center">Payment For</label><br/>
                <div class="radio d-inline mr-4">
                    <label>
                        <input type="radio" 
                                id="radio-panellist"
                                form="form_payment"
                                class="form-control-view"
                                name="edit_record[payment_for]" 
                                style="margin-top:1px" 
                                value="panellist">
                                Panelist
                    </label>
                </div>
                <div class="radio d-inline">
                    <label>
                        <input type="radio" 
                                form="form_payment"
                                class="form-control-view"
                                id="radio-vendor"
                                name="edit_record[payment_for]" 
                                style="margin-top:1px" 
                                value="vendor">
                                Vendor
                    </label>
                </div>
            </div>
        </div>
        <div class="sec-panellist hide">
            <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PANELIST</p>
            <div class="row mt-3" style="padding:0 15px 15px">
                <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Panelist</label>
                            <select name="edit_record[panellist_id]" id="panellist_id_edit" form="form_payment" class="form-control form-control-view select2" onchange="select_panellist(this, 'edit')" style="width:100%">
                                <option value="">-- Select Panelist --</option>
                                <?php foreach ($panellist as $p) { ?>
                                <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Field of Study</label>
                            <input type="text" id="field_of_study_edit" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Email</label>
                            <input type="text" id="panellist_email_edit" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Telp</label>
                            <input type="text" id="panellist_telp_edit" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Bank Info</label>
                            <input type="text" id="panellist_bank_info_edit" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Beneficiary Name</label>
                            <input type="text" id="panellist_beneficiary_edit" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="text-center">Account</label>
                            <input type="text" id="panellist_account_edit" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="text-center">Status Panelist</label>
                            <input type="text" id="panellist_status_edit" class="form-control" readonly>
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
                        <select name="edit_record[vendor_id]" id="hotel_id_edit" form="form_payment" class="form-control form-control-view select2" onchange="select_hotel(this, 'edit')" style="width:100%">
                            <option value="">-- Select Vendor --</option>
                            <?php foreach ($vendors as $h) { ?>
                            <option value="<?= $h->id ?>"><?= $h->name ?></option>
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
                        <textarea type="text" form="form_payment" class="form-control form-control" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php } ?>
        
        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Payment Information</p>
        <div id="wrap-request-record-edit0">
        </div>
        <div class="form-group hide-view">
            <a href="javascript:;" onclick="edit_item_record(0)" class="btn btn-primary" style="margin-top:24px;"><i class="fa fa-plus fa-fw"></i> Add Item</a>
            <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-record-edit" style="display:none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button class="btn-submit-record-disabled btn btn-success hide" disabled>Saving Data...</button>
        <button type="submit" id="btn-submit-record-edit" name="btn" value="edit_rec" form="form_payment" class="btn btn-success">Save</button>
        <input id="hide-btn-edit" type="hidden" disabled="disabled" form="form_payment" name="btn" value="edit_rec">
        <input id="hide-total-payment-record" type="hidden" name="total_paymen_record" form="form_payment" value="">
      </div>
    </div>
  </div>
</div>