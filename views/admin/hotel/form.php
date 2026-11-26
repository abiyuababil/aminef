<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <form role="form" method="POST">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" name="name" value="<?php echo (isset($this->Hotel_model->name)) ? $this->Hotel_model->name : '' ?>" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo (isset($this->Hotel_model->email)) ? $this->Hotel_model->email : '' ?>" required>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Telp</label>
                    <input type="tel" class="form-control" name="telp" value="<?php echo (isset($this->Hotel_model->telp)) ? $this->Hotel_model->telp : '' ?>" placeholder="" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Bank Info</label>
                    <input class="form-control" name="bank_info" value="<?php echo (isset($this->Hotel_model->bank_info)) ? $this->Hotel_model->bank_info : '' ?>" placeholder="" required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control" id="" rows="4"><?php echo (isset($this->Hotel_model->address)) ? $this->Hotel_model->address : '' ?></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Beneficiary Name</label>
                    <input class="form-control" name="beneficiary_name" value="<?php echo (isset($this->Hotel_model->beneficiary_name)) ? $this->Hotel_model->beneficiary_name : '' ?>" placeholder="" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Account Number</label>
                    <input class="form-control" name="account_number" value="<?php echo (isset($this->Hotel_model->account_number)) ? $this->Hotel_model->account_number : '' ?>" placeholder="" required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label> Is Active </label>
                    <input type="checkbox" value="1" name="is_active" <?= $this->Hotel_model->is_active == 1 ? "checked" : "" ?>>
                </div>
            </div>
            <div class="col-lg-12">
                <?php
                if (isset($this->Hotel_model->id)) {
                ?>
                    <input type="hidden" name="id" value="<?php echo $this->Hotel_model->id ?>">
                <?php } ?>
                <a href="<?php echo site_url('admin/hotel/manage') ?>" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->