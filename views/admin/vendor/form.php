<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-9">
        <form role="form" method="POST">
            <?php if (!empty($this->Vendor_model->grantee_name)) : ?>
            <div class="col-lg-12">
                <div class="alert alert-info" style="margin-bottom: 20px;">
                    <i class="fa fa-user"></i> <strong>Source Grantee:</strong> <?php echo htmlspecialchars($this->Vendor_model->grantee_name); ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Grantee Name</label>
                    <input class="form-control" name="grantee_name" value="<?php echo (isset($this->Vendor_model->grantee_name)) ? htmlspecialchars($this->Vendor_model->grantee_name) : '' ?>" placeholder="Grantee Name" readonly>
                    <input type="hidden" name="user_grantee_id" value="<?php echo (isset($this->Vendor_model->user_grantee_id)) ? $this->Vendor_model->user_grantee_id : '' ?>">
                    <input type="hidden" name="grantee_grant_id" value="<?php echo (isset($this->Vendor_model->grantee_grant_id)) ? $this->Vendor_model->grantee_grant_id : '' ?>">
                    <input type="hidden" name="custom_fields_id" value="<?php echo (isset($this->Vendor_model->custom_fields_id)) ? $this->Vendor_model->custom_fields_id : '' ?>">
                    <input type="hidden" name="multiple_step_id" value="<?php echo (isset($this->Vendor_model->multiple_step_id)) ? $this->Vendor_model->multiple_step_id : '0' ?>">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" name="name" value="<?php echo (isset($this->Vendor_model->name)) ? $this->Vendor_model->name : '' ?>" placeholder="Vendor Name" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Beneficiary Name <?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? '(As listed on the bank account)' : '' ?></label>
                    <input class="form-control" name="beneficiary_name" value="<?php echo (isset($this->Vendor_model->beneficiary_name)) ? $this->Vendor_model->beneficiary_name : '' ?>" placeholder="Beneficiary Name" required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label><?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? 'Beneficiary Address: [Building/Street, City, State/Province + Postal Code, Country]' : 'Address' ?></label>
                    <textarea name="address" class="form-control" id="" rows="4"><?php echo (isset($this->Vendor_model->address)) ? $this->Vendor_model->address : '' ?></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Bank Name</label>
                    <input type="text" class="form-control" name="bank_name" value="<?php echo (isset($this->Vendor_model->bank_name)) ? $this->Vendor_model->bank_name : '' ?>" placeholder="The Bank Name" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" class="form-control" name="account_number" value="<?php echo (isset($this->Vendor_model->account_number)) ? $this->Vendor_model->account_number : '' ?>" placeholder="" required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label><?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? 'Bank Address: [Building/Street, City, State/Province + Postal Code, Country]' : 'Bank Address' ?></label>
                    <textarea name="bank_address" class="form-control" id="" rows="4"><?php echo (isset($this->Vendor_model->bank_address)) ? $this->Vendor_model->bank_address : '' ?></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>SWIFT Code</label>
                    <input class="form-control" name="swift_code" value="<?php echo (isset($this->Vendor_model->swift_code)) ? $this->Vendor_model->swift_code : '' ?>" placeholder="" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label><?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? 'Routing or ABA Number (for U.S. Banks)' : 'Routing Number' ?></label>
                    <input class="form-control" name="routing_number" value="<?php echo (isset($this->Vendor_model->routing_number)) ? $this->Vendor_model->routing_number : '' ?>" placeholder="" required>
                </div>
            </div>
            <?php if($this->session->userdata('active_country') == AMERICAN_DATABASE) : ?>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Other Bank Details (Intermediary Bank, etc.)</label>
                    <input type="text" class="form-control" name="note" value="<?php echo (isset($this->Vendor_model->note)) ? $this->Vendor_model->note : '' ?>" placeholder="" required>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Telp</label>
                    <input type="text" class="form-control" name="telp" value="<?php echo (isset($this->Vendor_model->telp)) ? $this->Vendor_model->telp : '' ?>" placeholder="" required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label> Is Active </label>
                    <input type="checkbox" value="1" name="is_active" <?= $this->Vendor_model->is_active == 1 ? "checked" : "" ?>>
                </div>
            </div>
            <div class="col-lg-12">
                <?php
                if (isset($this->Vendor_model->id)) {
                ?>
                    <input type="hidden" name="id" value="<?php echo $this->Vendor_model->id ?>">
                <?php } ?>
                <a href="<?php echo site_url('admin/vendor/manage') ?>" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->