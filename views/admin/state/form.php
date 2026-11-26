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
                <label>State Name</label>
                <input class="form-control" name="name"
                       value="<?php echo (isset($this->State_model->name)) ? $this->State_model->name: '' ?>"
                       placeholder="eg: Jakarta" required>
            </div>
            <div class="form-group">
                <label>Is Java</label>
				<input type="checkbox" value="1" name="is_java" <?= $this->State_model->is_java == 1 ? "checked" : "" ?>>
            </div>
            <?php
            if (isset($this->State_model->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $this->State_model->id ?>">
                <input type="hidden" name="country_id" value="<?php echo $this->State_model->country_id ?>">
            <?php } ?>
            <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/state/manage/' . $country_id) ?>"
               class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->
