<div class="modal fade" id="mdl_bulk_grantee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="exampleModalLabelGrantee">Add Grant Payment Record</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo site_url('admin/request_payment/add_bulk'); ?>" method="POST" enctype="multipart/form-data" id="form-payment-grantee">
      <input type="hidden" id="delete_payment" name="delete_payment">
      <input type="hidden" id="delete_payment_item" name="delete_payment_item">
      <input type="hidden" id="bulk_id" name="bulk_id">
      <input type="hidden" value="<?= $grant_id ?>" name="add_record[grant_id]" id="grant_id_bulk">
      <div class="modal-body record-payment-add">
        <div class="form-group">
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Disbursment <span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <select class="form-control-view form-control select2 disbursment" id="disbursment" name="add_record[disbursment]">
                    <option value="">-- Select Disbursement --</option>
                    <?php
                    function ordinal($number) {
                        $ends = ['th','st','nd','rd','th','th','th','th','th','th'];
                        if ((($number % 100) >= 11) && (($number % 100) <= 13))
                            return $number. 'th';
                        else
                            return $number. $ends[$number % 10];
                    }

                    for ($i = 1; $i <= 10; $i++) {
                        echo "<option value='".ordinal($i)." Disbursement'>".ordinal($i)." Disbursement</option>";
                    }
                    ?>
                </select>
                <div class="text-danger invalid-tooltip disbursment-validation hide" style="display: block;">Disbursment is Required</div>
            </div>
        </div>
        <!-- <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Category <span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <select class="form-control-view form-control select2 payment-category-record payment_category" name="add_record[category]">
                    <option value="">-- Select Category --</option>
                    <option value="Grant Cost">Grant Cost</option>
                    <option value="Grant Supporting">Grant Supporting</option>
                    <option value="International Travel">International Travel</option>
                    <option value="Third Party">Third Party</option>
                </select>
                <div class="text-danger invalid-tooltip payment-category-record-validation hide" style="display: block;">Category is Required</div>
            </div>
        </div> -->
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Sub Category <span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <select id="sub_category_bulk" class="form-control-view form-control select2 payment_sub_category" style="width:100%" name="add_record[sub_category]">
                    <option value="">-- Select Sub Category --</option>
                    <?php
                    if ($sub_category_cost) {
                        foreach ($sub_category_cost as $scc) {
                            ?>
                            <option value="<?= $scc->id ?>"><?= $scc->name ?></option>
                        <?php
                            }
                        }
                        ?>
                </select>
                <div class="text-danger invalid-tooltip payment-sub-category-record-validation hide" style="display: block;">Sub Category is Required</div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Pay Period Starts <span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" class="form-control-view form-control datepicker" id="add_from_date" name="add_record[from_date]" placeholder="Pay Period Starts">
                <div class="text-danger invalid-tooltip from-date-validation hide" style="display: block;">Pay Period Starts is Required</div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Pay Period Ends <span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" class="form-control-view form-control datepicker" id="add_to_date" name="add_record[to_date]" placeholder="Pay Period Ends">
                <div class="text-danger invalid-tooltip to-date-validation hide" style="display: block;">Pay Period Ends is Required</div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Notification Date <span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" class="form-control-view form-control datepicker" id="add_notify_date" name="add_record[notify_date]" placeholder="Notification Date">
            <div class="text-danger invalid-tooltip notify-date-validation hide" style="display: block;">Notification Date is Required</div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">To be Released Note</label>
            <div class="col-lg-9">
                <textarea type="text" class="form-control-view form-control" id="release_note" name="add_record[release_note]" placeholder="To be Released Note"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Memo Budget</label>
            <div class="col-lg-9">
                <select class="form-control-view form-control" id="user_grantee_grant_memo_id" name="add_record[user_grantee_grant_memo_id]">
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
            <label class="col-lg-3 col-form-label text-right">To be released on</label>
            <div class="col-lg-9">
                <input type="text" class="form-control-view form-control datepicker" id="add_deadline_date" name="add_record[deadline_date]" placeholder="To be released on">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Priority</label>
            <div class="col-lg-9">
                <select class="form-control-view form-control" id="add_record_priority" name="add_record[priority]">
                    <option value="">Select Priority</option>
                    <option value="1">Normal</option>
                    <option value="2">Urgent</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Status <span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <select id="record_status_grantee" class="form-control-view form-control status" name="add_record[record_status]">
                    <option value="">-- Select Record Status --</option>
                    <?php
                    if ($select_status_payment) {
                        foreach ($select_status_payment as $ps) {
                            $selected = ($detail_grant->category_grant == ETA && $ps->id == 2) ? 'selected' : '';
                            ?>
                            <option value="<?= $ps->id ?>" <?= $selected ?>><?= $ps->name ?></option>
                        <?php
                            }
                        }
                        ?>
                </select>
                <div class="text-danger invalid-tooltip status-validation hide" style="display: block;">Status is Required</div>
            </div>
        </div>

        
        <div class="form-group mt-4">
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Finance Staff</div>
        </div>
        <div class="form-group row">
            <?php 
                $hide_upload_transfer = 'hide';
                if (has_permission('payment_record', 'upload_proof_of_transfer')) {
                    $hide_upload_transfer = '';
                }
            ?>
            <label class="col-lg-3 col-form-label text-right">Proof of Transfer</label>
            <div class="col-lg-6">
                <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this); return false;"><i class="fa fa-times"></i></button>
                <input type="file" onchange="update_to_release(this)" data-modal="mdl_add_record" id="proof-of-transfer" name="add_proof_record">
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label text-right">Release Date</label>
            <div class="col-lg-9">
                <input type="text" class="form-control-view form-control datepicker" id="add_release_date" name="add_record[release_date]" placeholder="Release Date">
            </div>
        </div>

        <div class="form-group">
            <button type="button" id="add-setup" class="btn btn-success">+ Add Setup Payment</button>
        </div>


        <div class="setup-wrapper" id="setup-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Set Payment Item</strong></div>
                        <div class="panel-body cart-setup">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="setup-payment-table">
                                    <thead>
                                    <tr>
                                        <th>Payment Item</th>
                                        <th>Nominal IDR</th>
                                        <th>Nominal USD</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control-view form-control select2 setup-payment-item" name="setup[0][payment_item]"></select>
                                        </td>
                                        <td><input type="text" class="form-control-view form-control setup-idr" name="setup[0][nominal_idr]"></td>
                                        <td><input type="text" class="form-control-view form-control setup-usd" name="setup[0][nominal_usd]"></td>
                                        <td class="text-center">
                                            <button class="hide-view btn btn-danger btn-sm remove-setup"><span class="glyphicon glyphicon-trash"></span></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="hide-view btn btn-primary btn-sm" id="add-setup-item" type="button">
                                <span class="glyphicon glyphicon-plus"></span> Add Payment Item
                            </button>
                            <div class="subtotal text-right" style="margin-top:10px;">
                                <strong>Subtotal IDR:</strong> Rp <span class="setup-subtotal-idr">0</span> |
                                <strong>Subtotal USD:</strong> $<span class="setup-subtotal-usd">0</span>
                            </div>
                        </div>
                        <div class="panel-heading"><strong>Select Grantee</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control-view form-control select-status" id="select-status" name="add_record[status_grantee]">
                                        <option value="">-- Select Status --</option>
                                        <option value="Finalist">Finalist</option>
                                        <option value="Incoming Grantee">Incoming Grantee</option>
                                        <option value="Visa Application">Visa Application</option>
                                        <option value="Current Grantee">Current Grantee</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control-view form-control select-grantee selectpicker" id="select-grantee" data-live-search="true">
                                        <option value="">-- Select Grantee --</option>
                                        <?php foreach ($user_grantee as $grantee) { ?>
                                            <option value="<?php echo $grantee->user_grantee_id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>" data-grantee_name="<?php echo get_full_name($grantee, 'US'); ?>"><?php echo get_full_name($grantee, 'US'); ?></option>
                                        <?php } ?>
                                    </select>
                                    <!-- <select id="select-grantee" class="form-control-view form-control">
                                        <option value="">-- Select Grantee --</option>
                                        <option value="Junaid, Saareen">Junaid, Saareen</option>
                                        <option value="John Doe">John Doe</option>
                                    </select> -->
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary btn-block" id="add-grantee" type="button">
                                        <span class="glyphicon glyphicon-plus"></span> Add Grantee
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Container for all grantees -->
                    <div id="grantee-container"></div>
                </div>
            </div>

            <!-- <div class="row hide">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Status Grantee</label>
                        <select class="form-control-view form-control select-status" id="select-status" name="add_record[status_grantee]">
                            <option value="">-- All --</option>
                            <option value="Finalist">Finalist</option>
                            <option value="Incoming Grantee">Incoming Grantee</option>
                            <option value="Visa Application">Visa Application</option>
                            <option value="Current Grantee">Current Grantee</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Grantee</label>
                        <select class="form-control-view form-control select-grantee selectpicker" id="select-grantee" data-live-search="true">
                            <option value="">Select Grantee</option>
                            <?php foreach ($user_grantee as $grantee) { ?>
                                <option value="<?php echo $grantee->id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>" data-grantee_name="<?php echo get_full_name($grantee, 'US'); ?>"><?php echo get_full_name($grantee, 'US'); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 p-0" style="margin-top:25px;">
                    <a class="btn btn-primary add-more-grantee"><i class="fa fa-plus"></i> Add Grantee</a>
                </div>
            </div> -->
            <!-- <div class="row mt-3" style="padding:0 15px 15px">
                <div class="col-lg-12 mb-0 list-grantee" style="background-color:#e9eef4;padding:10px;">
                <table class="table table-borderless table-list-grantee">
                    <thead></thead>
                    <tbody></tbody>
                </table>
                </div>
            </div> -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button class="btn-submit-record-disabled btn btn-success hide" disabled>Saving Data...</button>
        <button type="submit" name="btn" value="save_rec" class="btn btn-success">Save</button>
        <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
      </div>
      </form>
    </div>
  </div>
</div>