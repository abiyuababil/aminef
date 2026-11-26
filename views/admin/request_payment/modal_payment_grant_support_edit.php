
<div class="modal fade" id="mdl_edit_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Edit Grant Support</h2>
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
                        <input autocomplete="new-password" readonly type="text" form="form" id="payment_date" class="payment-date-record form-control datepicker" name="edit_record[payment_date]" placeholder="Entry Date">
                        <input type="hidden" id="payment_id" name="edit_record[payment_id]">
                        <div class="text-danger invalid-tooltip payment-date-record-validation hide" style="display: block;">Entry Date is Required</div>
                    </div>
                </div>
                <?php if (!is_null($memo_budget)) { ?>
                <div class="form-group memo-budget-payment-record-edit hide row">
                    <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                    <div class="col-lg-9">
                    <select class="form-control" name="edit_record[user_grantee_grant_memo_id]">
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
                        <input type="text" class="form-control" id="description" name="edit_record[description]" placeholder="Description">
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Release Type</label>
                    <div class="col-lg-9">
                        <select class="form-control" form="form" id="release_type" name="edit_record[release_type]">
                            <option value="">-- Select Release Type --</option>
                            <option value="Manual">Manual</option>
                            <option value="MRI">Automatic</option>
                        </select>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Note From Admin</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" id="admin_note" class="form-control" name="edit_record[admin_note]" placeholder="Note From Admin"></textarea>
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
                        <input type="text" form="form" class="form-control datepicker" id="edit_record_deadline_date" name="edit_record[deadline_date]" placeholder="To be released on">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Priority</label>
                    <div class="col-lg-9">
                        <select class="form-control" id="edit_record_priority" name="edit_record[priority]">
                            <option value="">Select Priority</option>
                            <option value="1">Normal</option>
                            <option value="2">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank</label>
                    <div class="col-lg-9">
                        <select class="form-control" id="edit_record_bank_info" name="edit_record[bank_info_id]">
                            <option value="">Select Bank Account</option>
                            <?php foreach($bank_info as $bank) { ?>
                                <option value="<?php echo $bank->id; ?>"><?php echo $bank->bank_name . ' (' . $bank->currency . ')' . ' - ' . $bank->account_number; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right"></label>
                    <div class="col-lg-9">
                        <?php if ($this->session->userdata('role') == 'finance') { ?>
                            <div class="form-check">
                                <label class="form-check-label" for="notify_admin">
                                    <input class="form-check-input" id="edit_record_notify_admin" type="checkbox" name="edit_record[notify_admin]" value="1" id="notify_admin"> Notify Admin via Email
                                </label>
                            </div>
                        <?php } else { ?>
                            <!-- <div class="form-check">
                                <label for="notify_finance">
                                    <input class="form-check-input" id="edit_record_notify_finance" type="checkbox" name="edit_record[notify_finance]" value="1" id="notify_finance"> Notify Finance via Email
                                </label>
                            </div> -->
                        <?php } ?>
                        <div class="form-check">    
                            <label class="form-check-label" for="notify_grantee">
                                <input class="form-check-input" id="edit_record_notify_grantee" type="checkbox" name="edit_record[notify_grantee]" value="1" id="notify_grantee"> Notify Grantee upon Released
                            </label>
                        </div>
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
                            <input type="file" id="proof" name="proof_of_conversion_grant_support">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div>
                        <div id="preview-edit-uploaded-conversion-grant" class="conversion-file hide">
                            <a href="" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                        </div>
                        <div id="preview-edit-not-uploaded-conversion-grant" class="conversion-no-file hide">
                            <a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Status</label>
                    <div class="col-lg-9">
                        <select <?= is_admin() ? '' : '' ?> form="form" id="record_status" class="form-control status" name="edit_record[record_status]">
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
                <?php //} 
                ?>
                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET INFORMATION</p>
                <div id="wrap-request-record-edit0">
                </div>
                <div class="form-group">
                    <a href="javascript:;" onclick="edit_item_record(0)" class="btn btn-primary" style="margin-top:24px;"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-record-edit" style="display:none;">
                </div>
                <div class="form-group">
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Note From Finance</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" id="finance_note" <?= is_admin() ? '' : '' ?> class="form-control" name="edit_record[finance_note]" placeholder="Note From Finance"></textarea>
                    </div>
                </div>
                <div class="form-group row proof-of-transfer">
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
                            <input type="file" onchange="update_to_release(this)" data-modal="mdl_edit_record" id="proof" name="proof_record">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div>
                        <div id="preview-edit-uploaded-transfer-grant" class="transfer-file hide">
                            <a href="" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                        </div>
                        <div id="preview-edit-not-uploaded-transfer-grant" class="transfer-no-file hide">
                            <a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Release Date</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" id="edit_record_release_date" class="form-control datepicker" name="edit_record[release_date]" placeholder="Release Date">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <!-- <button disabled class="btn-submit-record-disabled btn btn-success hide">Saving Data...</button> -->
                <button type="submit" id="btn-submit-record-edit" data-action="edit" name="btn" value="edit_rec" class="btn btn-success">Save</button>
                <input id="hide-btn-edit" type="hidden" disabled="disabled" name="btn" value="edit_rec">
                <input id="hide-total-payment-record" type="hidden" name="total_paymen_record" form="form" value="">
            </div>
        </div>
    </div>
</div>