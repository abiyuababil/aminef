
<div class="modal fade" id="mdl_edit_travel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Edit Payment International Travel</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Entry Date</label>
                    <div class="col-lg-9">
                        <input autocomplete="new-password" type="text" form="form" id="payment_date_travel" class="payment-date-international-input form-control datepicker" name="edit_travel[payment_date]" placeholder="Entry Date">
                        <input type="hidden" id="payment_id_travel" name="edit_travel[payment_id]">
                        <div class="text-danger invalid-tooltip payment-date-international-travel hide" style="display: block;">Entry Date is Required</div>
                    </div>
                </div>
                <?php if (!is_null($memo_budget)) { ?>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                    <div class="col-lg-9">
                    <select class="form-control" name="edit_travel[user_grantee_grant_memo_id]">
                        <option value="">Select Memo Budget</option>
                        <?php foreach($memo_budget as $memo) { ?>
                            <option data-grant-id="<?php echo $memo->user_grantee_grant_id ?>" <?= $memo->is_active == 'Yes' ? '' : 'class="memo-budget-inactive" disabled' ?> value="<?php echo $memo->id; ?>" data-is-active="<?= $memo->is_active ?>"><?php echo $memo->file_name; ?><?= $memo->is_active == 'Yes' ? '' : ' (Inactive)' ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <?php } ?>
                
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Description</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="description_travel" name="edit_travel[description]" placeholder="Description">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Note From Admin</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" id="admin_note_travel" class="form-control" name="edit_travel[admin_note]" placeholder="Note From Admin"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Status</label>
                    <div class="col-lg-9">
                        <select <?= is_admin() ? '' : '' ?> form="form" id="record_status_travel" class="form-control status" name="edit_travel[record_status]">
                            <option value="">-- Select Record Status --</option>
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
                    <label class="col-lg-3 col-form-label text-right">Proof of Expense</label>
                    <?php 
                        $hide_upload_expense = 'hide';
                        if (has_permission('payment_record', 'upload_proof_of_expense')) {
                            $hide_upload_expense = '';
                        }
                    ?>   
                    <div class="col-md-9 p-0 mt-4">
                        <div id="preview-edit-uploaded-expense" class="expense-file">
                            <div class="payment-attachment">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_expense; ?>" type="button" onclick="remove_file(this, 'expense'); return false;"><i class="fa fa-times"></i></button>
                                        <a href="" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="additional-proof-of-expense"></div>
                    </div>
                    <div class="col-md-12 <?php echo $hide_upload_expense; ?>">
                        <div class="form-group">
                            <a class="btn btn-primary pull-right btn-xs btn-add-proof-expense" data-type="proof-of-expense" data-input_name="proof_of_expenses[]" onclick="add_more_attachment(this);"><i class="fa fa-plus"></i> Add More</a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">To be released on</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control datepicker" id="edit_travel_deadline_date" name="edit_travel[deadline_date]" placeholder="To be released on">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Priority</label>
                    <div class="col-lg-9">
                        <select class="form-control" id="edit_travel_priority" name="edit_travel[priority]">
                            <option value="">Select Priority</option>
                            <option value="1">Normal</option>
                            <option value="2">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank</label>
                    <div class="col-lg-9">
                        <select class="form-control" id="edit_travel_bank_info" name="edit_travel[bank_info_id]">
                            <option value="">Select Bank Account</option>
                            <?php foreach($bank_info as $bank) { ?>
                                <option value="<?php echo $bank->id; ?>"><?php echo $bank->bank_name . ' (' . $bank->currency . ')' . ' - ' . $bank->account_number; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Proof of Conversion</label>
                    <div class="col-lg-9">
                         <?php 
                            $hide_upload_conversion = 'hide';
                            if (has_permission('payment_record', 'upload_proof_of_conversion')) {
                                $hide_upload_conversion = '';
                            }
                        ?>
                        <div class="<?php $hide_upload_conversion; ?>">
                            <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_conversion; ?>" type="button" onclick="remove_file(this, 'conversion'); return false;"><i class="fa fa-times"></i></button>
                            <input type="file"data-modal="mdl_add_travel" id="proof_of_conversion_travel" name="proof_of_conversion_travel">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div>
                        <div id="preview-edit-uploaded-conversion" class="conversion-file">
                            <a href="" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                        </div>
                        <div id="preview-edit-not-uploaded-conversion" class="conversion-no-file">
                            <a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right"></label>
                    <div class="col-lg-9">
                        <?php if ($this->session->userdata('role') == 'finance') { ?>
                            <div class="form-check">
                                <label class="form-check-label" for="notify_admin">
                                    <input class="form-check-input" id="edit_travel_notify_admin" type="checkbox" name="edit_travel[notify_admin]" value="1" id="notify_admin"> Notify Admin via Email
                                </label>
                            </div>
                        <?php } else { ?>
                            <!-- <div class="form-check">
                                <label for="notify_finance">
                                    <input class="form-check-input" id="edit_travel_notify_finance" type="checkbox" name="edit_travel[notify_finance]" value="1" id="notify_finance"> Notify Finance via Email
                                </label>
                            </div> -->
                        <?php } ?>
                        <div class="form-check">    
                            <label class="form-check-label" for="notify_grantee">
                                <input class="form-check-input" id="edit_travel_notify_grantee" type="checkbox" name="edit_travel[notify_grantee]" value="1" id="notify_grantee"> Notify Grantee upon Released
                            </label>
                        </div>
                    </div>
                </div>
                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET INFORMATION</p>
                <div id="wrap-request-travel-edit0">
                </div>
                <div class="form-group">
                    <a href="javascript:;" onclick="edit_item_travel(0)" class="btn btn-primary" style="margin-top:24px;"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-travel-edit" style="display:none;">
                </div>
                <div class="form-group">
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Note From Finance</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" id="finance_note_travel" <?= is_admin() ? '' : '' ?> class="form-control" name="edit_travel[finance_note]" placeholder="Note From Finance"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Proof of Transfer</label>
                    <div class="col-lg-9">
                        <?php 
                            $hide_upload_transfer = 'hide';
                            if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                                $hide_upload_transfer = '';
                            }
                        ?>
                        <div class="<?php $hide_upload_transfer; ?>">
                            <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this, 'transfer'); return false;"><i class="fa fa-times"></i></button>
                            <input type="file" data-modal="mdl_edit_travel" onchange="update_to_release(this)" id="proof_travel" name="proof_travel">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div>
                        <div id="preview-edit-uploaded-transfer" class="transfer-file hide">
                            <a href="" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                        </div>
                        <div id="preview-edit-not-uploaded-transfer" class="transfer-no-file hide">
                            <a onclick="return false;" id="transfer-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Release Date</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" id="edit_travel_release_date" class="form-control datepicker" name="edit_travel[release_date]" placeholder="Release Date">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button disabled class="btn-submit-travel-disabled btn btn-success hide">Saving Data...</button>
                <button type="submit" id="btn-submit-travel-edit" data-action="edit" name="btn" value="edit_travel" class="btn btn-success">Save</button>
                <input id="hide-btn-edit" type="hidden" disabled="disabled" name="btn" value="edit_travel">
                <input id="hide-total-payment-travel" type="hidden" name="total_paymen_travel" form="form" value="">
            </div>
        </div>
    </div>
</div>