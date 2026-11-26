<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form role="form" method="POST">
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" name="name" value="<?php echo (isset($this->Travel_agents_model->name)) ? $this->Travel_agents_model->name : '' ?>" placeholder="eg: John Doe">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" value="<?php echo (isset($this->Travel_agents_model->email)) ? $this->Travel_agents_model->email : '' ?>" placeholder="eg: jhon@mail.com">
            </div>
            <div class="form-group">
                <label> Is Active </label>
                <input type="checkbox" value="1" name="is_active" <?= $this->Travel_agents_model->is_active == 1 ? "checked" : "" ?>>
            </div>
            <?php
            if (isset($this->Travel_agents_model->id)) {
            ?>
            <input type="hidden" name="id" value="<?php echo $this->Travel_agents_model->id ?>">
            <?php } ?>
            <a href="<?php echo site_url('admin/travel_agent/manage') ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
