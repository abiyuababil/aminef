<style>
    .modal-xl { width: 1000px; }
</style>

<div class="modal fade" id="mdl_add_record_grantee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Bulk Grantee Payment</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo site_url('admin/payment_record/add_bulk'); ?>" method="POST" enctype="multipart/form-data" id="form-payment-grantee">
                <input type="hidden" name="add_record[period_id]" value="<?= $id ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Payment Date</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control datepicker" id="add_payment_date" name="add_record[payment_date]" placeholder="Payment Date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Description</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="add_record[description]" placeholder="Description" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Admin Note</label>
                        <div class="col-lg-9">
                            <textarea type="text" class="form-control" name="add_record[admin_note]" placeholder="Admin Note"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Category <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select class="form-control select2 payment-category-record payment_category" name="add_record[category]" required>
                                <option value="">-- Select Category --</option>
                                <option value="Grant Cost">Grant Cost</option>
                                <option value="Grant Supporting">Grant Supporting</option>
                                <option value="International Travel">International Travel</option>
                                <option value="Third Party">Third Party</option>
                                <!-- <option value="GRE Subject">GRE Subject</option> -->
                            </select>
                            <div class="text-danger invalid-tooltip payment-category-record-validation hide" style="display: block;">Category is Required</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Sub Category <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="select_sub_category_record_0" class="form-control select2 payment_sub_category" style="width:100%" name="add_record[sub_category]" required>
                                <option value="">-- Select Sub Category --</option>
                                <?php //foreach ($payment_sub_support as $kpsp => $psp) { 
                                ?>
                                <!-- <option value="<?= $psp->id ?>"><?= $psp->name ?></option> -->
                                <?php //} 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Payment Item <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="select_payment_item_record_grantee_0" class="form-control select2" style="width:100%" name="add_record[payment_items]" required>
                                <option value="">-- Select Item --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                        <div class="col-lg-9">
                            <select class="form-control" style="width:100%" name="add_record[user_grantee_grant_memo_id]">
                                <option value="">-- Select Memo Budget --</option>
                                <?php foreach ($memo_budget as $kpsp => $mb) { ?>
                                    <?php if ($mb->is_active == 'Yes') { ?>
                                    <option value="<?= $mb->id ?>"><?= $mb->file_name ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Status</label>
                        <div class="col-lg-9">
                            <select class="form-control select2" name="add_record[record_status]" style="width:100%">
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
                    <?php if($this->session->userdata('role') == 'finance') { ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" for="notify_grantee"></label>
                        <div class="col-lg-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="add_record[notify_grantee]" id="addNotify" value="yes" style="cursor: pointer;">
                                <label class="form-check-label mr-2" for="addNotify" style="cursor: pointer;">Notify Grantee </label>


                                <input class="form-check-input" type="radio" name="add_record[notify_grantee]" id="addDoNotNotify" value="no" style="cursor: pointer;">
                                <label class="form-check-label" for="addDoNotNotify" style="cursor: pointer;">Do Not Notify Grantee </label>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Finance Note</label>
                        <div class="col-lg-9">
                            <textarea type="text" class="form-control" name="add_record[finance_note]" placeholder="Finance Note"></textarea>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Deadline Date</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control datepicker" name="add_record[deadline_date]" placeholder="Deadline Date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Priority</label>
                        <div class="col-lg-9">
                            <select class="form-control" id="add_record_priority" name="add_record[priority]">
                                <option value="">Select Priority</option>
                                <option value="1">Normal</option>
                                <option value="2">Urgent</option>
                            </select>
                        </div>
                    </div>
                    <div class="sec-grantee-payment">
                        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> GRANTEE</p>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Status Grantee</label>
                                    <select class="form-control select-status" id="select-status" name="add_record[status_grantee]" data-period="<?= $this->User_grantee_grant_period_model->id ?>">
                                        <option value="">-- All --</option>
                                        <option value="Selection">Selection</option>
                                        <option value="Nominee">Nominee</option>
                                        <option value="On Going">On Going</option>
                                        <option value="Returning">Returning</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Grantee</label>
                                    <select class="form-control select-grantee selectpicker" id="select-grantee" data-live-search="true">
                                        <option value="">Select Grantee</option>
                                        <?php foreach ($users_grantee as $grantee) { ?>
                                            <option value="<?php echo $grantee->id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>" data-grantee_name="<?php echo get_full_name($grantee); ?>"><?php echo get_full_name($grantee); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 p-0" style="margin-top:25px;">
                                <a class="btn btn-primary add-more-grantee"><i class="fa fa-plus"></i> Add Grantee</a>
                            </div>
                        </div>
                        <div class="row mt-3" style="padding:0 15px 15px">
                            <div class="col-lg-12 mb-0 list-grantee" style="background-color:#e9eef4;padding:10px;">
                            <table class="table table-borderless table-list-grantee">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                                <!-- <div class="row row-grantee">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Grantee <span class="text-danger">*</span></label>
                                            <select class="form-control select2 select-grantee" name="add_record[grantee][0][user_grantee_id]" required>
                                                <option value="">Select Grantee</option>
                                                <?php foreach ($users_grantee as $grantee) { ?>
                                                    <option value="<?php echo $grantee->id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>"><?php echo get_full_name($grantee); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Bank</label>
                                            <select class="form-control select2 grantee-bank-info" name="add_record[grantee][0][grantee_bank_id]">
                                                <option></option>
                                            </select>
                                            <input type="hidden" class="grantee_grant_id" name="add_record[grantee][0][grantee_grant_id]" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label>Nominal IDR</label>
                                            <input type="text" class="form-control currency-idr" name="add_record[grantee][0][nominal_idr]">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label>Nominal USD</label>
                                            <input type="text" class="form-control currency-usd" name="add_record[grantee][0][nominal]">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label>Proof of Expense</label>
                                            <input type="file" name="proof_of_payment_0" class="form-control" style="display: inline;" onchange="change_status_paid()">
                                            <a class="btn btn-xs btn-danger mt-1" id="delete_proof_of_payment_0" onclick="remove_payment_item_proof(this, 0);return false;"><i class="fa fa-times"></i></a>'
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-danger remove-grantee"><i class="fa fa-times-circle"></i></button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PAYMENT ITEMS</p>
                    <div id="wrap-request-record-grantee-0">
                        <div id="request-item-record-0" class="row mt-3 request-item-record0" style="padding:0 15px 15px">
                            <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                                <div class="col-lg-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label>Payment Item</label>
                                        <select id="select_payment_item_record_grantee_0" class="form-control select2" style="width:100%" name="add_record[items][0][item]" required>
                                            <option value="">-- Select Item --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label>Nominal IDR</label>
                                        <input type="text" class="form-control currency-idr" name="add_record[items][0][nominal_idr]">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label>Nominal USD</label>
                                        <input type="text" class="form-control currency-usd" name="add_record[items][0][nominal]">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label>Proof of Expense</label>
                                        <input type="file" name="proof_of_payment_0" class="form-control" style="display: inline;" onchange="change_status_paid()">
                                        <a class="btn btn-xs btn-danger mt-1" id="delete_proof_of_payment_0" onclick="remove_payment_item_proof(this, 0);return false;"><i class="fa fa-times"></i></a>'
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <a href="javascript:;" onclick="add_item_record_grantee(0)" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                        <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-record" style="display:none;">
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-submit-payment-grantee">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="mdl_edit_record_grantee" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditGrantee" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="modalLabelEditGrantee">Edit Bulk Grantee Payment</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo site_url('admin/user_grantee_grant/udpate_payment_record_grantee'); ?>" name="form" enctype="multipart/form-data" method="POST" id="form_edit_bulk_grantee">
                <input type="hidden" id="delete_detail_payment_record_grantee" name="edit_record[delete_detail_payment_record]">
                <input type="hidden" id="delete_payment_record_grantee" name="edit_record[delete_payment_record]">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Payment Date</label>
                        <div class="col-lg-9">
                            <input type="text"  id="payment_date_record" class="form-control form-control-view datepicker" name="edit_record[payment_date]" placeholder="Payment Date" autocomplete="off">
                            <input type="hidden"  id="payment_id_record" name="edit_record[bulk_id]">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Description</label>
                        <div class="col-lg-9">
                            <input type="text"  class="form-control form-control-view" name="edit_record[description]" id="description_record" placeholder="Description" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Admin Note</label>
                        <div class="col-lg-9">
                            <textarea type="text"  id="admin_note_record" class="form-control form-control-view" name="edit_record[admin_note]" placeholder="Admin Note"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Category <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-view select2 payment-category-record payment_category_edit"  id="category" name="edit_record[category]" required>
                                <option value="">-- Select Category --</option>
                                <option value="Grant Cost">Grant Cost</option>
                                <option value="Grant Supporting">Grant Supporting</option>
                                <option value="International Travel">International Travel</option>
                                <option value="Third Party">Third Party</option>
                                <!-- <option value="GRE Subject">GRE Subject</option> -->
                            </select>
                            <div class="text-danger invalid-tooltip payment-category-record-validation hide" style="display: block;">Category is Required</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Sub Category <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-view select2 payment_sub_category_edit"  id="sub_category" name="edit_record[sub_category]" required>
                                <option value="">-- Select Sub Category --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right payment_item_edit">Payment Item <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="payment_item" class="form-control form-control-view select2" style="width:100%" name="edit_record[payment_items]" required>
                                <option value="">-- Select Item --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-view" style="width:100%"  name="edit_record[user_grantee_grant_memo_id]" id="memo_budget_payment_grantee">
                                <option value="">-- Select Memo Budget --</option>
                                <?php foreach ($memo_budget as $kpsp => $mb) { ?>
                                    <option <?= $mb->is_active == 'Yes' ? '' : 'class="memo-budget-inactive" disabled' ?> value="<?= $mb->id ?>" data-is-active="<?= $mb->is_active ?>"><?= $mb->file_name ?><?= $mb->is_active == 'Yes' ? '' : ' (Inactive)' ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Status</label>
                        <div class="col-lg-9">
                            <select  id="record_status_grantee" class="form-control form-control-view status select2" name="edit_record[record_status]">
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
                    <?php 
                        $hide_upload_transfer = 'hide';
                        if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                            $hide_upload_transfer = '';
                        }
                    ?>
                    <!-- <div class="form-group row <?php echo $hide_upload_transfer; ?>">
                        <label class="col-lg-3 col-form-label text-right">Proof Of Transfer</label>
                        <div class="col-lg-9">
                            <div>
                                <button class="hide-view btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this, 'transfer', undefined, 'form_edit_bulk_grantee'); return false;"><i class="fa fa-times"></i></button>
                                <input class="hide-view" type="file" id="proof" name="proof_record"  style="display: inline;" onchange="change_status_paid()"><br>
                                <small class="file-for-testing">File Size Max 5MB</small>
                            </div>
                            <div class="transfer-file">
                                <a id="btn_proof" href="" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof Of Transfer</label></a>
                            </div>
                        </div>
                    </div> -->
                    <?php if($this->session->userdata('role') == 'finance') { ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" for="notify_grantee"></label>
                        <div class="col-lg-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_record[notify_grantee]" id="notify" value="yes" style="cursor: pointer;">
                                <label class="form-check-label mr-2" for="notify" style="cursor: pointer;">Notify Grantee </label>


                                <input class="form-check-input" type="radio" name="edit_record[notify_grantee]" id="doNotNotify" value="no" style="cursor: pointer;">
                                <label class="form-check-label" for="doNotNotify" style="cursor: pointer;">Do Not Notify Grantee </label>
                            </div>

                            <!-- <div class="form-check">
                                <input class="form-check-input" form="form" type="checkbox" name="edit_record[notify_grantee]" value="1" id="notify_grantee">
                                <label class="form-check-label" for="notify_grantee" style="cursor: pointer;">
                                    Notify Email to Grantee
                                </label>
                            </div> -->
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Finance Note</label>
                        <div class="col-lg-9">
                            <textarea type="text"  id="finance_note_record" class="form-control form-control-view" name="edit_record[finance_note]" placeholder="Finance Note"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Deadline Date</label>
                        <div class="col-lg-9">
                            <input type="text"  class="form-control form-control-view datepicker" id="edit_record_deadline_date" name="edit_record[deadline_date]" placeholder="Deadline Date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Priority</label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-view"  id="edit_record_grantee_priority" name="edit_record[priority]">
                                <option value="">Select Priority</option>
                                <option value="1">Normal</option>
                                <option value="2">Urgent</option>
                            </select>
                        </div>
                    </div>
                    <div class="sec-grantee-payment">
                        <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> GRANTEE</p>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Status Grantee</label>
                                    <select class="form-control select-status" id="select-status-edit" data-is_edit="1" data-period="<?= $this->User_grantee_grant_period_model->id ?>">
                                        <option value="">-- All --</option>
                                        <option value="Selection">Selection</option>
                                        <option value="Nominee">Nominee</option>
                                        <option value="On Going">On Going</option>
                                        <option value="Returning">Returning</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Grantee</label>
                                    <select class="form-control select-grantee-edit selectpicker" id="select-grantee-edit" data-live-search="true">
                                        <option value="">Select Grantee</option>
                                        <?php foreach ($users_grantee as $grantee) { ?>
                                            <option value="<?php echo $grantee->id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>" data-grantee_name="<?php echo get_full_name($grantee); ?>"><?php echo get_full_name($grantee); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 p-0" style="margin-top:25px;">
                                <a class="btn btn-primary edit-add-more-grantee"><i class="fa fa-plus"></i> Add Grantee</a>
                            </div>
                        </div>
                        <div class="row mt-3" style="padding:0 15px 15px">
                            <div class="col-lg-12 mb-0 list-grantee-edit" style="background-color:#e9eef4;padding:10px;" id="wrap-request-record-edit-grantee-0">
                                <table class="table table-borderless table-list-grantee-edit">
                                    <thead></thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET INFORMATION</p>
                    <div id="wrap-request-record-edit-grantee-0">
                    </div>
                    <div class="form-group">
                        <a href="javascript:;" onclick="edit_item_record_grantee(0)" class="btn btn-primary" style="margin-top:24px;"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                        <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-record-edit" style="display:none;">
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                    <input id="hide-btn-edit" type="hidden" disabled="disabled" name="btn" value="edit_rec">
                </div>
            </form>
        </div>
    </div>
</div>