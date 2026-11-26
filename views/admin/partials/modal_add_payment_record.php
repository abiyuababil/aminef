<div class="modal fade" id="mdl_add_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <input type="text" form="form" class="form-control datepicker" id="add_payment_date" name="add_record[payment_date]" placeholder="Payment Date">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Description</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control" name="add_record[description]" placeholder="Description" autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Admin Note</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" class="form-control" name="add_record[admin_note]" placeholder="Admin Note"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Category</label>
                    <div class="col-lg-9">
                        <select class="form-control select2 payment-category-record" form="form" name="add_record[category]">
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
                    <label class="col-lg-3 col-form-label text-right">Sub Category</label>
                    <div class="col-lg-9">
                        <select id="select_sub_category_record_0" onchange="select_payment_item_record('0')" class="form-control select2" style="width:100%" form="form" name="add_record[sub_category]">
                            <option value="">-- Select Sub Category --</option>
                            <?php //foreach ($payment_sub_support as $kpsp => $psp) { ?>
                                <!-- <option value="<?= $psp->id ?>"><?= $psp->name ?></option> -->
                            <?php //} ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                    <div class="col-lg-9">
                        <select class="form-control" style="width:100%" form="form" name="add_record[user_grantee_grant_memo_id]">
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
                    <label class="col-lg-3 col-form-label text-right">Bank Info</label>
                    <div class="col-lg-9">
                        <select id="nbank_info_0" class="form-control select2" style="width:100%" form="form" name="add_record[bank_info_id]">
                            <?php foreach ($bank_info as $kb => $bi) { ?>
                                <option value="<?= $bi->id ?>" <?php echo $bi->is_selected ? 'selected' : ''; ?>><?= $bi->beneficiary_name ?> (<?= $bi->account_number ?> - <?= $bi->currency ?>) - <?= $bi->bank_name ?> <?= $bi->us_departure ? '(US Departure)' : '' ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Status</label>
                    <div class="col-lg-9">
                        <select form="form" class="form-control select2" name="add_record[record_status]" style="width:100%">
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
                <div class="form-group row <?php echo $hide_upload_transfer; ?>">
                    <label class="col-lg-3 col-form-label text-right">Proof Of Transfer</label>
                    <div class="col-lg-9">
                        <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this); return false;"><i class="fa fa-times"></i></button>
                        <input type="file" class="" form="form" id="proof" name="add_proof_record" style="display: inline;"><br>
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
                    <label class="col-lg-3 col-form-label text-right">Deadline Date</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control datepicker" name="add_record[deadline_date]" placeholder="Deadline Date">
                    </div>
                </div>
                <div class="form-group row hide" id="departure_date_add">
                    <label class="col-lg-3 col-form-label text-right">Start Date</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control datepicker" name="add_record[departure_date]" placeholder="Start Date">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Priority</label>
                    <div class="col-lg-9">
                        <select class="form-control" form="form" id="add_record_priority" name="add_record[priority]">
                            <option value="">Select Priority</option>
                            <option value="1">Normal</option>
                            <option value="2">Urgent</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right"></label>
                    <div class="col-lg-9">
                        <?php if ($this->session->userdata('role') == 'finance') { ?>
                            <div class="form-check">
                                <input class="form-check-input" form="form" type="checkbox" name="add_record[notify_admin]" value="1" id="notify_admin">
                                <label class="form-check-label" for="notify_admin">
                                    Notify Admin
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" form="form" type="checkbox" name="add_record[notify_grantee]" value="1" id="notify_grantee">
                                <label class="form-check-label" for="notify_grantee">
                                    Notify Grantee
                                </label>
                            </div>
                        <?php } else { ?>
                            <div class="form-check">
                                <input class="form-check-input" form="form" type="checkbox" name="add_record[notify_finance]" value="1" id="notify_finance">
                                <label class="form-check-label" for="notify_finance">
                                    Notify Finance
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div> -->

                <p style="font-weight:bold;"><i class="fa fa-circle mt-3" style="color:#4da6ff;margin-right:5px;"></i> PAYMENT ITEMS</p>
                <div id="wrap-request-record0">
                    <div id="request-item-record-0" class="row mt-3 request-item-record0" style="padding:0 15px 15px">
                        <div class="col-lg-12" style="background-color:#e9eef4;padding:10px;">
                            <div class="col-lg-3">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Payment Item</label>
                                    <select id="select_payment_item_record_0" class="form-control select2" style="width:100%" form="form" name="add_record[items][0][item]">
                                        <option value="">-- Select Item --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Nominal IDR</label>
                                    <input type="text" form="form" class="form-control currency-idr" name="add_record[items][0][nominal_idr]">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Nominal USD</label>
                                    <input type="text" form="form" class="form-control currency-usd" name="add_record[items][0][nominal]">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label>Proof of Expense</label>
                                    <input type="file" name="proof_of_payment_0" class="form-control" style="display: inline;" form="form" onchange="change_status_paid()">
                                    <a class="btn btn-xs btn-danger mt-1" id="delete_proof_of_payment_0" onclick="remove_payment_item_proof(this, 0);return false;"><i class="fa fa-times"></i></a>'
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
                <button type="submit" id="btn-submit-record" name="btn" value="save_record" form="form" class="btn btn-success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
            </div>
        </div>
    </div>
</div>