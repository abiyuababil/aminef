<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title ?>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-4">
        <form role="form" method="POST">
            <div class="form-group">
                <label>Study Field</label>
                <input class="form-control" name="name"
                    value="<?php echo (isset($this->Study_field2_model->name)) ? $this->Study_field2_model->name : '' ?>"
                    placeholder="eg: Computer Science" required>
                
            </div>
            <!-- <div class="form-group">
                <label>Parent Study Field</label>
                <select class="form-control" name="parent_id">
                    <option value="">Set as Parent Study Field</option>
                    <?php foreach (get_all_db_2('am_study_fields_2', 'parent_id is null', [], '', [], 'name') as $key => $value) { ?>
                        <option <?= $value->id == $this->Study_field2_model->parent_id ? 'selected' : '' ?> value="<?= $value->id ?>"><?= $value->name ?></option>
                    <?php } ?>
                </select>
                
            </div> -->
            
            <?php
            if (isset($this->Study_field2_model->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $this->Study_field2_model->id ?>">
            <?php } ?>
            <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/study_fields/manage') ?>"
                class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->