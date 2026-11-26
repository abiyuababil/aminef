<!-- MODAL SUPPORT -->
<div class="modal fade" id="mdl_add_record_support" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Bulk Grant Support & International Travel</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo site_url('admin/payment_record/add_bulk_support'); ?>" method="POST" enctype="multipart/form-data" id="form-payment-grantee">
            <input type="hidden" id="delete_payment_support" name="delete_payment_support">
            <input type="hidden" id="delete_payment_item_support" name="delete_payment_item_support">
            <input type="hidden" id="bulk_id_support" name="bulk_id_support">
            <input type="hidden" value="<?= $grant_id ?>" name="add_record[grant_id]" id="grant_id_bulk_support">
            <input type="hidden" value="<?= $detail_grant->year ?>" id="year">
            <div class="modal-body">
                <div class="section">
                    <div class="form-group">
                        <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Entry Date</label>
                        <div class="col-lg-9">
                            <input id="payment_date_support" autocomplete="new-password" readonly type="text" class="payment-date-record form-control datepicker date-default" name="add_record[payment_date]" placeholder="Entry Date"  style="background-color: #fff;" value="<?php echo date('d M Y'); ?>">
                            <div class="text-danger invalid-tooltip payment-date-record-validation hide" style="display: block;">Entry Date is Required</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Category <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select class="form-control select2 payment-category-record-support payment_category_support" id="payment_category_support" name="add_record[category]" required>
                                <option value="">-- Select Category --</option>
                                <option value="Grant Supporting">Grant Supporting</option>
                                <option value="International Travel">International Travel</option>
                            </select>
                            <div class="text-danger invalid-tooltip payment-category-record-support-validation hide" style="display: block;">Category is Required</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Sub Category <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <div style="display: flex; gap: 6px;">
                                <select id="select_sub_category_record_support" class="form-control select2 payment_sub_category_support" style="width:100%" name="add_record[sub_category]" required>
                                    <option value="">-- Select Sub Category --</option>
                                </select>
                                <button type="button" class="btn btn-sm btn-success btn-cat-add" data-type="select2" data-tab="payment_category_support" data-select="select_sub_category_record_support" title="Add new sub category"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php if (!is_null($memo_budget)) { ?>
                    <div class="memo-budget-payment form-group hide row">
                        <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                        <div class="col-lg-9">
                        <select class="form-control is_null" name="add_record[user_grantee_grant_memo_id]">
                            <option value="">Select Memo Budget</option>
                            <?php foreach($memo_budget as $memo) { ?>
                                <?php if ($memo->is_active == 'Yes') { ?>
                                    <option data-grant-id="<?php echo $memo->user_grantee_grant_id ?>" value="<?php echo $memo->id; ?>"><?php echo $memo->file_name; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Description</label>
                        <div class="col-lg-9">
                            <input id="description_support" type="text" class="form-control" name="add_record[description]" placeholder="Description">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Note From Admin</label>
                        <div class="col-lg-9">
                            <textarea id="admin_note_support" type="text" class="form-control" name="add_record[admin_note]" placeholder="Note From Admin"></textarea>
                        </div>
                    </div>
                    <?php 
                        $hide_upload_expense = 'hide';
                        if (has_permission('payment_record', 'upload_proof_of_expense')) {
                            $hide_upload_expense = '';
                        }
                    ?>
                    <?php 
                        $hide_upload_conversion = 'hide';
                        if (has_permission('payment_record', 'upload_proof_of_conversion')) {
                            $hide_upload_conversion = '';
                        }
                    ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">To be released on</label>
                        <div class="col-lg-9">
                            <input id="deadline_date_support" type="text" class="form-control datepicker" name="add_record[deadline_date]" placeholder="To be released on"  value="<?php echo date('d M Y', strtotime('+7 days')); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                        <div class="col-lg-9">
                            <select class="form-control-view form-control" id="user_grantee_grant_memo_id_support" name="add_record[user_grantee_grant_memo_id]">
                                <option value="">Select Memo Budget</option>
                                <?php foreach($memo_budget as $memo) { ?>
                                    <?php if ($memo->is_active == 'Yes') { ?>
                                        <option data-grant-id="<?php echo $memo->user_grantee_grant_id ?>" value="<?php echo $memo->id; ?>"><?php echo $memo->file_name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Priority</label>
                        <div class="col-lg-9">
                            <select id="priority_support" class="form-control" name="add_record[priority]">
                                <option value="">Select Priority</option>
                                <option value="1">Normal</option>
                                <option value="2">Urgent</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row <?php echo $hide_upload_conversion; ?>">
                        <label class="col-lg-3 col-form-label text-right">Proof of Conversion</label>
                        <div class="col-lg-9">
                            <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_conversion; ?>" type="button" onclick="remove_file(this); return false;"><i class="fa fa-times"></i></button>
                            <input type="file" data-modal="mdl_add_record" id="proof" name="add_proof_of_conversion_grant_support">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Status</label>
                        <div class="col-lg-9">
                            <select class="form-control status" id="status_support" name="add_record[record_status]">
                                <!-- <option value="">-- Select Record Status --</option> -->
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
                                    <label class="form-check-label" for="notify_admin_support">
                                        <input class="form-check-input" checked type="checkbox" name="add_record[notify_admin]" value="1" id="notify_admin_support"> Notify Admin via Email
                                    </label>
                                </div>
                            <?php } else { ?>
                                <!-- <div class="form-check">
                                    <label for="notify_finance">
                                        <input class="form-check-input" checked type="checkbox" name="add_record[notify_finance]" value="1" id="notify_finance"> Notify Finance via Email
                                    </label>
                                </div> -->
                            <?php } ?>
                            <div class="form-check">    
                                <label class="form-check-label" for="notify_grantee_support">
                                    <input class="form-check-input" checked type="checkbox" name="add_record[notify_grantee]" value="1" id="notify_grantee_support"> Notify Grantee upon Released
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Note From Finance</label>
                        <div class="col-lg-9">
                            <textarea type="text" class="form-control" name="add_record[finance_note]" placeholder="Note From Finance"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Release Date</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control datepicker" name="add_record[release_date]" placeholder="Release Date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Amount</label>
                        <div class="col-lg-9">
                            <label class="radio-inline">
                                <input type="radio" name="add_record[amount_type]" value="same" checked> Same Amount
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="add_record[amount_type]" value="different"> Different Amount
                            </label>
                        </div>
                    </div>

                    <div class="setup-wrapper-support" id="setup-wrapper-support">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" id="add-setup-support" class="btn btn-success mb-3">
                                    <span class="glyphicon glyphicon-plus"></span> Add Payment Section
                                </button>
            
                                <div class="panel-group" id="setup-accordion-support"></div>
            
            
                                <hr>
                                <h4>Total Payment</h4>
                                <p>
                                    Total: <span id="global-idr-support">0</span> | <span id="global-usd-support">0</span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="setup-wrapper-support-different" class="hide">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right">Select Grantee by Status:</label>
                                <div class="col-lg-9">
                                    <div style="display:flex; gap:6px;">
                                        <select class="form-control select-status-support-diff" id="select-status-support-diff" style="width:auto;flex:1;">
                                            <option value="">-- Select Status --</option>
                                            <option value="<?= STATUS_FINALIST ?>">Finalist</option>
                                            <option value="<?= STATUS_NEW_GRANTEE ?>">Incoming Grantee</option>
                                            <option value="<?= STATUS_VISA_APPLICATION ?>">Visa Application</option>
                                            <option value="<?= CURRENT_GRANTEE ?>">Current Grantee</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm add-grantee-support-diff" type="button">
                                            <span class="glyphicon glyphicon-plus"></span> Add Grantee
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="grantee-list-different" style="margin-top:15px;"></div>
                            <hr>
                            <h4>Total Payment</h4>
                            <p>
                                Total: <span id="global-idr-different">0</span> | <span id="global-usd-different">0</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button disabled class="btn-submit-record-support-disabled btn btn-success hide">Saving Data...</button>
                <button type="submit" id="btn-submit-record-support" data-action="create" name="btn" value="save_rec" class="btn btn-success">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
