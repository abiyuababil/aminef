<div class="modal fade" id="mdl_add_record_bulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?php echo site_url('admin/user_grantee_grant/add_bulk_non_grantee_us'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h2 class="modal-title text-center" id="exampleModalLabelVendor">Add Bulk Non-Grantee Payments</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body record-payment-add-non-grantee">
                    <input type="hidden" id="delete_payment_non_grantee" name="delete_payment">
                    <input type="hidden" id="delete_payment_item" name="delete_payment_item">
                    <input type="hidden" id="bulk_id_non_grantee" name="bulk_id">
                    <input type="hidden" value="<?= $grant_id ?>" name="add_record[grant_id]" id="grant_id_bulk_non">
                    <div class="section">
                        <div class="form-group">
                            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Entry Date</label>
                                <input id="payment_date_record_bulk" onchange="removeValidation('payment-date-record-bulk')" type="text" class="date-default payment-date-record form-control datepicker payment-date-record-bulk" name="add_record[payment_date]" placeholder="Entry Date" value="<?php echo date('d M Y'); ?>">
                                <div class="text-danger invalid-tooltip payment-date-record-bulk-validation hide" style="display: block;">Entry Date is Required</div>        
                            </div>
                            <div class="col-lg-6">
                                <label>Description</label>
                                <input id="description_record_bulk" type="text" class="form-control" name="add_record[description]" placeholder="Description">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Payment Deadline</label>
                                <input type="text" class="form-control datepicker date-default" id="deadline_date_record_bulk" name="add_record[deadline_date]" placeholder="Payment Deadline" value="<?php echo date('d M Y', strtotime('+7 days')); ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Priority</label>
                                <select class="form-control" id="priority_record_bulk" name="add_record[priority]">
                                    <option value="">Select Priority</option>
                                    <option value="1">Normal</option>
                                    <option value="2">Urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Note From Admin</label>
                                <textarea type="text" class="form-control" id="admin_note_record_bulk" name="add_record[admin_note]" placeholder="Note From Admin"></textarea>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Memo Budget</label>
                                <select class="form-control" id="memo_record_bulk" name="add_record[user_grantee_grant_memo_id]">
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
                            <div class="col-lg-6">
                                <label>Payment Category</label>
                                <select id="category_id_record_bulk" class="form-control select2 select-category-non-grantee" name="add_record[category_id]">
                                    <option value="">Select Payment Category</option>
                                    <?php foreach($payment_item_categories as $category) { ?>
                                        <option value="<?php echo $category->category_type; ?>"><?php echo $category->category_type; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Sub Category</label>
                                <div style="display:flex; gap:6px;">
                                    <select id="payment_sub_category_id_record_bulk" class="form-control select2 select-sub-category-non-grantee" name="add_record[sub_category_id]">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                    <button type="button" class="btn btn-sm btn-success btn-cat-add" data-type="select2" data-tab="category_id_record_bulk" data-select="payment_sub_category_id_record_bulk" title="Add new sub category"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Notification Date</label>
                                <input onchange="removeValidation('notification-date-record-bulk')" type="text" class="payment-date-record form-control datepicker-notification notification-date-record-bulk" name="add_record[notify_date]" id="notify_date_non" placeholder="Notification Date" value="">
                                <div class="text-danger invalid-tooltip notification-date-record-bulk-validation hide" style="display: block;">Entry Date is Required</div>        
                            </div>

                            <div class="col-lg-6">
                                <label>Status</label>
                                <select class="form-control status <?= $this->session->userdata('role') != 'finance' ? 'readonly-select' : '' ?>" id="status_record_bulk" name="add_record[record_status]">
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
                        </div>
                        <div class="form-group mt-4">
                            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>Note From Finance</label>
                                <textarea id="finance_note_record_bulk" type="text" class="form-control" name="add_record[finance_note]" placeholder="Note From Finance"></textarea>
                            </div>
                        </div>
            
                        <div class="setup-wrapper-non-grantee" id="setup-wrapper-non-grantee">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" id="add-setup-non-grantee" class="btn btn-success mb-3">
                                        <span class="glyphicon glyphicon-plus"></span> Add Payment Section
                                    </button>
            
                                    <div class="panel-group" id="setup-accordion-non-grantee"></div>
            
            
                                    <hr>
                                    <h4>Total Payment</h4>
                                    <p>
                                        Total: <span id="global-idr-non-grantee">0</span> | <span id="global-usd-non-grantee">0</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer hide-view">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button class="btn-submit-record-disabled btn btn-success hide" disabled>Saving Data...</button>
                    <button type="submit" name="btn" value="save_rec" class="btn btn-success" id="btn-submit-record-bulk">Save</button>
                    <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
                </div>
            </form>
        </div>
    </div>
</div>