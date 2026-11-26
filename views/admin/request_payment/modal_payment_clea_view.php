

<div class="modal fade" id="mdl_view_clea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">View clea Support</h2>
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
                        <input autocomplete="new-password" readonly type="text" id="payment_date_clea_view" class="form-control datepicker" placeholder="Entry Date" disabled>
                    </div>
                </div>
                <?php if (!is_null($memo_budget)) { ?>
                <div class="form-group memo-budget-payment-clea-view hide row">
                    <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
                    <div class="col-lg-9">
                        <?= generate_select($memo_budget, 'edit_clea[user_cleaee_clea_memo_id]', 'id', 'file_name', '', '', true); ?>
                    </div>
                </div>
                <?php } ?>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Description</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="description_clea_view" placeholder="Description" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Note From Admin</label>
                    <div class="col-lg-9">
                        <textarea type="text" form="form" id="admin_note_clea_view" class="form-control" placeholder="Note From Admin" disabled></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Proof of Expense</label>
                    <div class="col-md-9 p-0 mt-4">
                        <div class="additional-proof-of-expense"></div>
                        <div class="col-lg-12 uploaded-file">
                            <div id="preview-view-uploaded-expense" class="hide expense-file">
                                <a href="" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                            </div>
                            <div id="preview-view-not-uploaded-expense" class="hide">
                                <a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">To be released on</label>
                    <div class="col-lg-9">
                        <input type="text" form="form" class="form-control datepicker" id="view_clea_deadline_date" name="view_clea[deadline_date]" placeholder="To be released on" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Priority</label>
                    <div class="col-lg-9">
                        <select class="form-control" id="view_clea_priority" name="view_clea[priority]" disabled>
                            <option value="">Select Priority</option>
                            <option value="1">Normal</option>
                            <option value="2">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank</label>
                    <div class="col-lg-9">
                        <select class="form-control" id="view_clea_bank_info" name="view_clea[bank_info_id]" disabled>
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
                        <div id="preview-view-uploaded-conversion-clea" class="hide">
                            <a href="" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                        </div>
                        <div id="preview-view-not-uploaded-conversion-clea" class="hide">
                            <a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Status</label>
                    <div class="col-lg-9">
                        <select <?= is_admin() ? '' : '' ?> form="form" id="clea_status_clea_view" class="form-control" disabled>
                            <option value="">-- Select clea Status --</option>
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
                                    <input class="form-check-input" id="clea_view_notify_admin" type="checkbox" name="add_clea[notify_admin]" value="1" id="notify_admin"> Notify Admin via Email
                                </label>
                            </div>
                        <?php } else { ?>
                            <!-- <div class="form-check">
                                <label for="notify_finance">
                                    <input class="form-check-input" id="clea_view_notify_finance" type="checkbox" name="add_clea[notify_finance]" value="1" id="notify_finance"> Notify Finance via Email
                                </label>
                            </div> -->
                        <?php } ?>
                        <div class="form-check">    
                            <label class="form-check-label" for="notify_grantee">
                                <input class="form-check-input" id="clea_view_notify_grantee" type="checkbox" name="add_clea[notify_grantee]" value="1" id="notify_grantee"> Notify Grantee upon Released
                            </label>
                        </div>
                    </div>
                </div>
                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> BUDGET INFORMATION</p>
                <div id="wrap-request-clea-view0">
                </div>
                <div class="form-group">
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Proof of Transfer</label>
                    <div class="col-lg-9">
                        <div id="preview-view-uploaded-transfer-clea" class="hide">
                            <a href="" class="lightbox"><label class="label label-primary" style="cursor:pointer;"></i> View Proof</label></a>
                        </div>
                        <div id="preview-view-not-uploaded-transfer-clea" class="hide">
                            <a onclick="return false;" id="expense-preview-file"><label class="label label-default" style="cursor:pointer;"></i> File Not Uploaded yet</label></a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Note From Finance</label>
                    <div class="col-lg-9">
                        <textarea type="text" id="finance_note_clea_view" <?= is_admin() ? '' : '' ?> class="form-control" placeholder="Note From Finance" disabled></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Release Date</label>
                    <div class="col-lg-9">
                        <input id="release_date_clea_view" type="text" class="form-control datepicker" disabled ="Release Date">
                        <div class="text-danger invalid-tooltip payment-date-release-date hide" style="display: block;">Entry Date is Required</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL SUPPORT -->