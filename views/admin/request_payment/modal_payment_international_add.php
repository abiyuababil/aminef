
<!-- MODAL TRAVEL -->
<div class="modal fade" id="mdl_add_travel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Payment International Travel</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Entry Date <span style="color:red; font-size: 12pt;">*</span></label>
                    <div class="col-lg-9">
                        <input autocomplete="new-password" readonly type="text" class="payment-date-international-input form-control datepicker" name="add_travel[payment_date]" placeholder="Entry Date"  value="<?php echo date('d M Y'); ?>">
                        <div class="text-danger invalid-tooltip payment-date-international-travel hide" style="display: block;">Entry Date is Required</div>
                    </div>
                </div>
                <?php if (!is_null($memo_budget)) { ?>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                    <div class="col-lg-9">
                    <select class="form-control" name="add_travel[user_grantee_grant_memo_id]">
                        <option value="">Select Memo Budget</option>
                        <?php foreach($memo_budget as $memo) { ?>
                        <?php if ($memo->is_active == 'Yes') { ?>
                        <option data-grant-id="<?php echo $memo->user_grantee_grant_id ?>" value="<?php echo $memo->id; ?>" <?php echo (isset($selected_memo_budget_id) && $selected_memo_budget_id == $memo->id) ? 'selected' : ''; ?>><?php echo $memo->file_name; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <?php } ?>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Description</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="add_travel[description]" placeholder="Description">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Note From Admin</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" class="form-control" name="add_travel[admin_note]" placeholder="Note From Admin"></textarea>
                    </div>
                </div>
                
                <?php 
                    $hide_upload_transfer = 'hide';
                    if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                        $hide_upload_transfer = '';
                    }
                ?>
                <?php 
                    $hide_upload_expense = 'hide';
                    if (has_permission('payment_record', 'upload_proof_of_expense')) {
                        $hide_upload_expense = '';
                    }
                ?>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Proof of Expense</label>
                    <!-- <div class="col-lg-9">
                        <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_expense; ?>" type="button" onclick="remove_file(this, 'expense'); return false;"><i class="fa fa-times"></i></button>
                        <input type="file" id="proof_expense" name="add_proof_expense_travel">
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div> -->
                    <div class="col-md-9 p-0"><div class="additional-proof-of-expense"></div></div>
                    <div class="col-md-12 <?php echo $hide_upload_expense; ?>">
                        <div class="form-group">
                            <a class="btn btn-primary pull-right btn-xs btn-add-proof-expense" data-type="proof-of-expense" data-input_name="proof_of_expenses[]" onclick="add_more_attachment(this);"><i class="fa fa-plus"></i> Add More</a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">To be released on</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control datepicker" name="add_travel[deadline_date]" placeholder="To be released on" value="<?php echo date('d M Y', strtotime('+7 days')); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Priority</label>
                    <div class="col-lg-9">
                        <select class="form-control" name="add_travel[priority]">
                            <option value="">Select Priority</option>
                            <option value="1">Normal</option>
                            <option value="2">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank</label>
                    <div class="col-lg-9">
                        <select class="form-control" name="add_travel[bank_info_id]">
                            <option value="">Select Bank Account</option>
                            <?php foreach($bank_info as $bank) { ?>
                                <option value="<?php echo $bank->id; ?>"><?php echo $bank->bank_name . ' (' . $bank->currency . ')' . ' - ' . $bank->account_number; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php 
                    $hide_upload_conversion = 'hide';
                    if (has_permission('payment_record', 'upload_proof_of_conversion')) {
                        $hide_upload_conversion = '';
                    }
                ?>
                <div class="form-group row <?php echo $hide_upload_conversion; ?>">
                    <label class="col-lg-3 col-form-label text-right">Proof of Conversion</label>
                    <div class="col-lg-9">
                        <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_conversion; ?>" type="button" onclick="remove_file(this, 'conversion'); return false;"><i class="fa fa-times"></i></button>
                        <input type="file" data-modal="mdl_add_travel" id="proof" name="add_proof_of_conversion_travel">
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Status</label>
                    <div class="col-lg-9">
                        <select form="form" id="status" class="form-control status" name="add_travel[record_status]">
                            <?php
                            if ($record_status) {
                                foreach ($record_status as $ps) {
                                    if ($ps->name == 'New Payment') {
                                        continue;
                                    }
                            ?>
                                    <option value="<?= $ps->id ?>"><?= $ps->name ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right"></label>
                    <div class="col-lg-9">
                        <?php if ($this->session->userdata('role') == 'finance') { ?>
                            <div class="form-check">
                                <label class="form-check-label" for="notify_admin">
                                    <input class="form-check-input" checked type="checkbox" name="add_travel[notify_admin]" value="1" id="notify_admin"> Notify Admin via Email
                                </label>
                            </div>
                        <?php } else { ?>
                            <!-- <div class="form-check">
                                <label for="notify_finance">
                                    <input class="form-check-input" checked type="checkbox" name="add_travel[notify_finance]" value="1" id="notify_finance"> Notify Finance via Email
                                </label>
                            </div> -->
                        <?php } ?>
                        <div class="form-check">    
                            <label class="form-check-label" for="notify_grantee">
                                <input class="form-check-input" checked type="checkbox" name="add_travel[notify_grantee]" value="1" id="notify_grantee"> Notify Grantee upon Released
                            </label>
                        </div>
                    </div>
                </div>
                <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PAYMENT ITEMS</p>
                <div id="wrap-request-travel0">
                    <div id="request-item-travel-0" class="row mt-3 request-item-travel0" style="padding:0 15px 15px">
                        <div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">
                            <div class="col-lg-3">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Sub Category <span style="color:red; font-size: 12pt;">*</span></label>
                                    <select id="select_sub_category_travel_0" onchange="select_payment_item_travel('0')" class="travel-payment-sub-category form-control select2" style="width:100%" form="form" name="add_travel[items][0][sub_category]">
                                        <option value="">-- Select Sub Category --</option>
                                        <?php foreach ($payment_sub_travel as $kpst => $pst) { ?>
                                            <option value="<?= $pst->id ?>"><?= $pst->name ?></option>
                                        <?php } ?>
                                        <option value="__add_new__" data-category="International Travel" data-select="select_sub_category_travel_0" title="sub_category"> <span class="glyphicon glyphicon-plus"></span> Add Sub Category</option>
                                    </select>
                                    <div class="text-danger invalid-tooltip travel-payment-sub-category-validation hide" style="display: block;">Sub Category is Required</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Payment Item <span style="color:red; font-size: 12pt;">*</span></label>
                                    <select id="select_payment_item_travel_0" class="travel-payment-item form-control select2" style="width:100%" form="form" name="add_travel[items][0][item]">
                                        <option value="">-- Select Item --</option>
                                    </select>
                                    <div class="text-danger invalid-tooltip travel-payment-item-validation hide" style="display: block;">Payment Item is Required</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Nominal IDR </label>
                                    <input type="text" form="form" class="currency-idr travel-payment-nominal-idr form-control" name="add_travel[items][0][nominal_idr]">
                                    <div class="text-danger invalid-tooltip travel-payment-nominal-idr-validation hide" style="display: block;">Nominal is Required</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Nominal USD <!-- <span style="color:red; font-size: 12pt;">*</span> --></label>
                                    <input type="text" form="form" class="currency-usd travel-payment-nominal form-control" name="add_travel[items][0][nominal]">
                                    <div class="text-danger invalid-tooltip travel-payment-nominal-validation hide" style="display: block;">Nominal is Required</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <a href="javascript:;" onclick="add_item_travel(0)" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-travel" style="display:none;">
                </div>
                <div class="form-group mt-4">
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Note From Finance</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" class="form-control" name="add_travel[finance_note]" placeholder="Note From Finance"></textarea>
                    </div>
                </div>
                <div class="form-group row <?php echo $hide_upload_transfer; ?>">
                    <label class="col-lg-3 col-form-label text-right">Proof of Transfer</label>
                    <div class="col-lg-9">
                        <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this, 'transfer'); return false;"><i class="fa fa-times"></i></button>
                        <input type="file" onchange="update_to_release(this)" data-modal="mdl_add_travel" id="proof" name="add_proof_travel">
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Release Date</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control datepicker" name="add_travel[release_date]" placeholder="Release Date">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button disabled class="btn-submit-travel-disabled btn btn-success hide">Saving Data...</button>
                <button type="submit" id="btn-submit-travel" data-action="create" name="btn" value="save_travel" class="btn btn-success">Save</button>
                
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_travel">
            </div>
        </div>
    </div>
</div>
