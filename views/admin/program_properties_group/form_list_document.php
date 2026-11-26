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
                <label>Document Name</label>
                <input class="form-control" name="field_name"
                       value="<?php echo (isset($this->Program_properties_group_list_documents_model->field_name)) ? $this->Program_properties_group_list_documents_model->field_name : '' ?>"
                       placeholder="eg: Initial Selection Process" required>
            </div> 
            <?php
            if (isset($this->Program_properties_group_list_documents_model->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $this->Program_properties_group_list_documents_model->id ?>">
            <?php } ?>
            <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/program_property_group/manage') ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->
