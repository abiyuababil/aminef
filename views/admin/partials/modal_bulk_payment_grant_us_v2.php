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
        <div class="section_uss">
            <div class="form-group">
                <div class="alert alert-info"><i class="fa fa-info-circle"></i> Completed by Program Staff</div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Disbursment <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select data-live-search="true" class="form-control-view form-control selectpicker disbursment" id="disbursment" name="add_record[disbursment]" required>
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
                        <option value="Final Payment">Final Payment</option>
                    </select>
                    <div class="text-danger invalid-tooltip disbursment-validation hide" style="display: block;">Disbursment is Required</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Sub Category <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div style="display: flex; gap: 6px;">
                        <select id="sub_category_bulk" data-live-search="true" class="form-control-view form-control selectpicker payment_sub_category" style="width:100%" name="add_record[sub_category]" required>
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
                        <button type="button" class="btn btn-sm btn-success btn-cat-add" data-type="selectpicker" data-tab="grant_cost" data-select="sub_category_bulk" title="Add new sub category"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="text-danger invalid-tooltip payment-sub-category-record-validation hide" style="display: block;">Sub Category is Required</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Pay Period Starts <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control-view form-control datepicker" id="add_from_date" name="add_record[from_date]" placeholder="Pay Period Starts" required>
                    <div class="text-danger invalid-tooltip from-date-validation hide" style="display: block;">Pay Period Starts is Required</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Pay Period Ends <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control-view form-control datepicker" id="add_to_date" name="add_record[to_date]" placeholder="Pay Period Ends" required>
                    <div class="text-danger invalid-tooltip to-date-validation hide" style="display: block;">Pay Period Ends is Required</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Notification Date <span class="text-danger req-notify">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control-view form-control datepicker-notification" id="add_notify_date_cost" name="add_record[notify_date]" placeholder="Notification Date" required>
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
                    <select class="form-control-view form-control" id="add_record_priority_bulk" name="add_record[priority]">
                        <option value="">Select Priority</option>
                        <option value="1">Normal</option>
                        <option value="2">Urgent</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Status <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select id="record_status_grantee" class="form-control-view form-control status" name="add_record[record_status]" required>
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
                <!-- <label class="col-lg-3 col-form-label text-right">Proof of Transfer</label>
                <div class="col-lg-6">
                    <button class="btn btn-danger btn-xs pull-right <?php echo $hide_upload_transfer; ?>" type="button" onclick="remove_file(this); return false;"><i class="fa fa-times"></i></button>
                    <input type="file" data-modal="mdl_add_record" id="proof" name="proof">
                    <small class="file-for-testing">File Size Max 5MB</small>
                    <div style="margin-bottom:10px; position:relative;">
                        <a onclick="return false;" id="label-view-proof" class="lightbox"><label class="label label-default" disabled>Not Uploaded yet</label></a>
                    </div>
                </div> -->
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Release Date</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control-view form-control datepicker" id="add_release_date_bulk" name="add_record[release_date]" placeholder="Release Date">
                </div>
            </div>
    
            <div class="setup-wrapper" id="setup-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" id="add-setup" class="btn btn-success mb-3">
                            <span class="glyphicon glyphicon-plus"></span> Add Payment Section
                        </button>
    
                        <div class="panel-group" id="setup-accordion"></div>
    
    
                        <hr>
                        <h4>Total Payment</h4>
                        <p>
                            Total: <span id="global-idr">0</span> | <span id="global-usd">0</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer hide-view">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button class="btn-submit-record-disabled btn btn-success hide" disabled>Saving Data...</button>
        <button type="submit" name="btn" value="save_rec" class="btn btn-success">Save</button>
        <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
      </div>
      </form>
    </div>
  </div>
</div>