<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-4">
        <form role="form" method="POST">
            <div class="form-group">
                <label>Country Code (2 Chars)</label>
                <input class="form-control" name="code"
                       value="<?php echo (isset($this->Country_list_model->code)) ? $this->Country_list_model->code: '' ?>"
                       placeholder="eg: AF" maxlength="2" required>
            </div>
            <div class="form-group">
                <label>Country Code (3 Chars)</label>
                <input class="form-control" name="code_athree"
                       value="<?php echo (isset($this->Country_list_model->code_athree)) ? $this->Country_list_model->code_athree: '' ?>"
                       placeholder="eg: AFG" maxlength="3" required>
            </div>
            <div class="form-group">
                <label>Country Name</label>
                <input class="form-control" name="name"
                       value="<?php echo (isset($this->Country_list_model->name)) ? $this->Country_list_model->name : '' ?>"
                       placeholder="eg: Afghanistan" required>
            </div>
            <div class="form-group">
                <label>Phone Kode</label>
                <input class="form-control" name="phone_code"
                       value="<?php echo (isset($this->Country_list_model->phone_code)) ? $this->Country_list_model->phone_code: '' ?>"
                       placeholder="eg: 93" required>
            </div>
            <?php
            if (isset($this->Country_list_model->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $this->Country_list_model->id ?>">
            <?php } ?>
            <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/country_list/manage') ?>"
               class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->
