
<div class="modal fade" id="mdl_add_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Payment Record</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Payment Date</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control datepicker payment-date-record" id="add_payment_date" name="add_record[payment_date]" placeholder="Payment Date">
                        <div class="text-danger invalid-tooltip payment-date-record-validation hide" style="display: block;">Payment Date is Required</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Description</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="add_record[description]" placeholder="Description" autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Category</label>
                    <div class="col-lg-9">
                        <select class="form-control select2 payment-category-record" form="form" name="add_record[category]" >
                            <option value="">-- Select Category --</option>
                            <option value="Grant Cost">Grant Cost</option>
                            <option value="Grant Supporting">Grant Supporting</option>
                            <option value="International Travel">International Travel</option>
                            <!-- <option value="GRE Subject">GRE Subject</option> -->
                        </select>
                        <div class="text-danger invalid-tooltip payment-category-record-validation hide" style="display: block;">Category is Required</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Sub Category</label>
                    <div class="col-lg-9">
                        <select class="form-control select2 payment-sub-category-record" form="form" name="add_record[sub_category]">
                            <option value="">-- Select Sub Category --</option>
                        </select>
                        <div class="text-danger invalid-tooltip payment-sub-category-record-validation hide" style="display: block;">Sub Category is Required</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                    <div class="col-lg-9">
                        <?= generate_select($memo_budget, 'add_record[user_grantee_grant_memo_id]', 'id', 'file_name'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank Info</label>
                    <div class="col-lg-9">
                        <select class="form-control select2" form="form" name="add_record[bank_info_id]">
                            <?php foreach($bank_info as $kbank => $bi) { ?>
                                <option value="<?= $bi->id?>" <?= $bi->is_selected ? 'selected' : ''?>><?= $bi->beneficiary_name ?> (<?= $bi->account_number ?>) - <?= $bi->bank_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Release Type</label>
                    <div class="col-lg-9">
                        <select class="form-control select2" form="form" name="add_record[release_type]">
                            <option value="">-- Select Release Type --</option>
                            <option value="Manual">Manual</option>
                            <option value="MRI">MRI</option>
                        </select>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Admin Note</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" class="form-control" name="add_record[admin_note]" placeholder="Admin Note"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Status</label>
                    <div class="col-lg-9">
                        <select form="form" class="form-control select2" id="record_status_add" name="add_record[record_status]">
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
                </div>
                <div class="form-group row proof-of-transfer">
                    <label class="col-lg-3 col-form-label text-right">Proof Of Transfer</label>
                    <div class="col-lg-9">
                        <input type="file" id="proof" name="add_proof_record"><br>
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
                <div class="form-group row upload-invoice">
                    <label class="col-lg-3 col-form-label text-right">Invoice</label>
                    <div class="col-lg-9">
                        <input type="file" id="invoice" name="add_invoice"><br>
                        <small class="file-for-testing">File Size Max 5MB</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Finance Note</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" class="form-control" name="add_record[finance_note]" placeholder="Finance Note"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right"></label>
                    <div class="col-lg-9">
                        <?php if ($this->session->userdata('role') == 'finance') { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="add_record[notify_admin]" value="1" id="notify_admin">
                                <label class="form-check-label" for="notify_admin">
                                    Notify Admin
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="add_record[notify_grantee]" value="1" id="notify_grantee">
                                <label class="form-check-label" for="notify_grantee">
                                    Notify Grantee
                                </label>
                            </div>
                        <?php } else { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="add_record[notify_finance]" value="1" id="notify_finance">
                                <label class="form-check-label" for="notify_finance">
                                    Notify Finance
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PAYMENT ITEMS</p>
                <div id="wrap-request-record0">
                    <div id="request-item-record-0" class="row mt-3 request-item-record0" style="padding:0 15px 15px">
                        <div class="col-lg-12 payment-item-section" style="background-color:#e9eef4;padding:10px;">
                            <div class="col-lg-4">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Payment Item</label>
                                    <select class="form-control select2 record-payment-item" form="form" name="add_record[items][0][item]">
                                        <option value="">-- Select Item --</option>
                                    </select>
                                    <div class="text-danger invalid-tooltip record-payment-item-validation hide" style="display: block;">Payment Item is Required</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Nominal IDR</label>
                                    <input type="number" form="form" class="form-control record-payment-nominal-idr" name="add_record[items][0][nominal_idr]">
                                    <div class="text-danger invalid-tooltip record-payment-nominal-idr-validation hide" style="display: block;">Nominal IDR is Required</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Nominal USD</label>
                                    <input type="number" form="form" class="record-payment-nominal form-control" name="add_record[items][0][nominal]">
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
                <button disabled class="btn-submit-record-disabled btn btn-success hide">Saving Data...</button>
                <button type="submit" id="btn-submit-record" data-action="create" name="btn" value="save_rec" class="btn btn-success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
            </div>
        </div>
    </div>
</div> 


<div class="modal fade" id="mdl_edit_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Edit Payment Record</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Payment Date</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" id="payment_date" class="payment-date-record form-control datepicker" name="edit_record[payment_date]" placeholder="Payment Date" autocomplete="off">
                        <input type="hidden" id="payment_id" name="edit_record[payment_id]">
                        <div class="text-danger invalid-tooltip payment-date-record-validation hide" style="display: block;">Payment Date is Required</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Description</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="edit_record[description]" id="description" placeholder="Description" autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Category</label>
                    <div class="col-lg-9">
                        <select class="form-control select2 payment-category-record" form="form" id="category" name="edit_record[category]">
                            <option value="">-- Select Category --</option>
                            <option value="Grant Cost">Grant Cost</option>
                            <option value="Grant Supporting">Grant Supporting</option>
                            <option value="International Travel">International Travel</option>
                            <!-- <option value="GRE Subject">GRE Subject</option> -->
                        </select>
                        <div class="text-danger invalid-tooltip payment-category-record-validation hide" style="display: block;">Category is Required</div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Sub Category</label>
                    <div class="col-lg-9">
                        <select class="form-control select2 payment-sub-category-record" form="form" id="sub_category" name="edit_record[sub_category]">
                            <option value="">-- Select Sub Category --</option>
                        </select>
                        <div class="text-danger invalid-tooltip payment-sub-category-record-validation hide" style="display: block;">Sub Category is Required</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                    <div class="col-lg-9">
                        <?= generate_select($memo_budget, 'edit_record[user_grantee_grant_memo_id]', 'id', 'file_name', '', 'memo_budget'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank Info</label>
                    <div class="col-lg-9">
                        <select class="form-control select2" form="form" name="edit_record[bank_info_id]" id="bank_info_id">
                            <?php foreach($bank_info as $kbank => $bi) { ?>
                                <option value="<?= $bi->id?>" <?= $bi->is_selected ? 'selected' : ''?>><?= $bi->beneficiary_name ?> (<?= $bi->account_number ?>)</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Release Type</label>
                    <div class="col-lg-9">
                        <select class="form-control select2" form="form" id="release_type" name="edit_record[release_type]">
                            <option value="">-- Select Release Type --</option>
                            <option value="Manual">Manual</option>
                            <option value="MRI">MRI</option>
                        </select>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Admin Note</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" id="admin_note" class="form-control" name="edit_record[admin_note]" placeholder="Admin Note"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Status</label>
                    <div class="col-lg-9">
                        <select form="form" id="record_status" class="form-control select2 status" name="edit_record[record_status]">
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
                </div>
                <div class="form-group row proof-of-transfer">
                    <label class="col-lg-3 col-form-label text-right">Proof Of Transfer</label>
                    <div class="col-lg-9">
                        <input type="file"  id="proof" name="proof_record" style="display: inline;"><br>
                        <small class="file-for-testing">File Size Max 5MB</small>
                        <div>
                            <a id="btn_proof" href="" class="lightbox"><label class="label label-primary" style="cursor:pointer">View Proof Of Transfer</label></a>
                        </div>
                    </div>
                </div>
                <div class="form-group row upload-invoice">
                    <label class="col-lg-3 col-form-label text-right">Invoice</label>
                    <div class="col-lg-9">
                        <input type="file"  id="invoice" name="invoice" style="display: inline;"><br>
                        <small class="file-for-testing">File Size Max 5MB</small>
                        <div>
                            <a id="btn_invoice" href="" class="lightbox"><label class="label label-primary" style="cursor:pointer">View Invoice</label></a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Finance Note</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" id="finance_note" class="form-control" name="edit_record[finance_note]" placeholder="Finance Note"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right"></label>
                    <div class="col-lg-9">
                        <?php if ($this->session->userdata('role') == 'finance') { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="edit_record[notify_admin]" value="1" id="edit_notify_admin">
                                <label class="form-check-label" for="edit_notify_admin">
                                    Notify Admin
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="edit_record[notify_grantee]" value="1" id="edit_notify_grantee">
                                <label class="form-check-label" for="edit_notify_grantee">
                                    Notify Grantee
                                </label>
                            </div>
                        <?php } else { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="edit_record[notify_finance]" value="1" id="edit_notify_finance">
                                <label class="form-check-label" for="edit_notify_finance">
                                    Notify Finance
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET INFORMATION</p>
                <div id="wrap-request-record-edit0">
                </div>
                <div class="form-group">
                    <a href="javascript:;" onclick="edit_item_record(0)" class="btn btn-primary" style="margin-top:24px;"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-record-edit" style="display:none;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button disabled class="btn-submit-record-disabled btn btn-success hide">Saving Data...</button>
                <button type="submit" id="btn-submit-record-edit" data-action="edit" name="btn" value="edit_rec" class="btn btn-success">Save</button>
                <input id="hide-btn-edit" type="hidden" disabled="disabled" name="btn" value="edit_rec">
            </div>
        </div>
    </div>
</div>