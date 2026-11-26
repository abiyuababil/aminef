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
                <label>City Name</label>
                <input class="form-control" name="name"
                       value="<?php echo (isset($this->City_model->name)) ? $this->City_model->name: '' ?>"
                       placeholder="eg: Jakarta" required>
            </div>
            <?php
            if (isset($this->City_model->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $this->City_model->id ?>">
                <input type="hidden" name="country_id" value="<?php echo $this->City_model->country_id ?>">
                <input type="hidden" name="state_id" value="<?php echo $this->City_model->state_id ?>">
            <?php } ?>
            <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/city/manage/' . $country_id) ?>"
               class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->
