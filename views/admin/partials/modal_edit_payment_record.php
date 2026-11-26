

<div class="modal fade" id="mdl_edit_record" tabindex="-1" role="dialog" aria-labelledby="modalLabelEdit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="modalLabelEdit">Edit Payment Record</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Payment Date</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" id="payment_date" class="form-control form-control-view datepicker" name="edit_record[payment_date]" placeholder="Payment Date" autocomplete="off">
                        <input type="hidden" form="form" id="payment_id" name="edit_record[payment_id]">
                        <input type="hidden" form="form" id="bulk_id" name="edit_record[bulk_id_edit]">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Description</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control form-control-view" name="edit_record[description]" id="description" placeholder="Description" autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Category</label>
                    <div class="col-lg-9">
                        <select class="form-control form-control-view select2 payment-category-record" form="form" id="category" name="edit_record[category]">
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
                        <select class="form-control form-control-view select2" form="form" id="sub_category" name="edit_record[sub_category]">
                            <option value="">-- Select Sub Category --</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                    <div class="col-lg-9">
                        <select class="form-control form-control-view" style="width:100%" form="form" name="edit_record[user_grantee_grant_memo_id]" id="memo_budget">
                            <option value="">-- Select Memo Budget --</option>
                            <?php foreach ($memo_budget as $kpsp => $mb) { ?>
                                <option <?= $mb->is_active == 'Yes' ? '' : 'class="memo-budget-inactive" disabled' ?> value="<?= $mb->id ?>" data-is-active="<?= $mb->is_active ?>"><?= $mb->file_name ?><?= $mb->is_active == 'Yes' ? '' : ' (Inactive)' ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank Info</label>
                    <div class="col-lg-9">
                        <select class="form-control form-control-view select2" form="form" name="edit_record[bank_info_id]" id="bank_info_id">
                            <?php foreach($bank_info as $kbank => $bi) { ?>
                                <option value="<?= $bi->id?>" <?= $bi->is_selected ? 'selected' : ''?>><?= $bi->beneficiary_name ?> (<?= $bi->account_number ?>  - <?= $bi->currency ?>) - <?= $bi->bank_name ?> <?= $bi->us_departure ? '(US Departure)' : '' ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Admin Note</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" id="admin_note" class="form-control form-control-view" name="edit_record[admin_note]" placeholder="Admin Note"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Status</label>
                    <div class="col-lg-9">
                        <select form="form" id="record_status" class="form-control form-control-view status select2" name="edit_record[record_status]">
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
                <div class="form-group row <?php echo $hide_upload_transfer; ?>">
                    <label class="col-lg-3 col-form-label text-right">Proof Of Transfer</label>
                    <div class="col-lg-9">
                        <div>
                            <button class="hide-view btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this, 'transfer', undefined, 'form'); return false;"><i class="fa fa-times"></i></button>
                            <input class="hide-view" type="file" id="proof" name="proof_record" form="form" style="display: inline;" onchange="change_status_paid()"><br>
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div>
                        <div class="transfer-file">
                            <a id="btn_proof" href="" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof Of Transfer</label></a>
                        </div>
                    </div>
                </div>
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
                        <textarea type="text" form="form" id="finance_note" class="form-control form-control-view" name="edit_record[finance_note]" placeholder="Finance Note"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Deadline Date</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control form-control-view datepicker" id="edit_record_deadline_date" name="edit_record[deadline_date]" placeholder="Deadline Date">
                    </div>
                </div>
                <div class="form-group row hide" id="departure_date_edit">
                    <label class="col-lg-3 col-form-label text-right">Start Date</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control datepicker" name="edit_record[departure_date]" id="edit_record_departure_date" placeholder="Start Date">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Priority</label>
                    <div class="col-lg-9">
                        <select class="form-control form-control-view" form="form" id="edit_record_priority" name="edit_record[priority]">
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
                                <input class="form-check-input" form="form" type="checkbox" name="edit_record[notify_admin]" value="1" id="edit_notify_admin">
                                <label class="form-check-label" for="edit_notify_admin">
                                    Notify Admin
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" form="form" type="checkbox" name="edit_record[notify_grantee]" value="1" id="edit_notify_grantee">
                                <label class="form-check-label" for="edit_notify_grantee">
                                    Notify Grantee
                                </label>
                            </div>
                        <?php } else { ?>
                            <div class="form-check">
                                <input class="form-check-input" form="form" type="checkbox" name="edit_record[notify_finance]" value="1" id="edit_notify_finance">
                                <label class="form-check-label" for="edit_notify_finance">
                                    Notify Finance
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div> -->

                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET INFORMATION</p>
                <div id="wrap-request-record-edit0">
                </div>
                <div class="form-group section-button-addnew-edit">
                    <a href="javascript:;" onclick="edit_item_record(0)" class="btn btn-primary" style="margin-top:24px;"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load-record-edit" style="display:none;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" id="btn-submit-record-edit" name="btn" value="edit_record" class="btn btn-success"  form="form">Save</button>
                <input id="hide-btn-edit" type="hidden" disabled="disabled" name="btn" value="edit_rec">
            </div>
        </div>
    </div>
</div>