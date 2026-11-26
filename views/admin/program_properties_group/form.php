<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-6">
        <form role="form" method="POST">
            <div class="form-group">
                <label>Category Name</label>
                <input class="form-control" name="name"
                       value="<?php echo (isset($this->Program_properties_group_model->name)) ? $this->Program_properties_group_model->name : '' ?>"
                       placeholder="eg: Initial Selection Process" required>
            </div>
            <div class="form-group">
                <label style="margin-right:20px">Category Type</label><br />
                <div class="radio d-inline mr-4">
                    <label>
                        <input type="radio" 
                                class="radio-type" 
                                <?= $this->Program_properties_group_model->category_type ==  RESEARCH ? 'checked' : '' ?>
                                name="category_type" 
                                style="margin-top:1px" 
                                value="<?= RESEARCH ?>">
                                Research
                    </label>
                </div>
                <div class="radio d-inline mr-4">
                    <label>
                        <input type="radio" 
                                class="radio-type" 
                                <?= $this->Program_properties_group_model->category_type ==  TEACHING ? 'checked' : '' ?>
                                name="category_type" 
                                style="margin-top:1px" 
                                value="<?= TEACHING ?>">
                                Teaching
                    </label>
                </div>
                <div class="radio d-inline mr-4">
                    <label>
                        <input type="radio" 
                                class="radio-type" 
                                <?= $this->Program_properties_group_model->category_type ==  ETA ? 'checked' : '' ?>
                                name="category_type" 
                                style="margin-top:1px" 
                                value="<?= ETA ?>">
                                ETA/English Teaching Assistant
                    </label>
                </div>
                <div class="radio d-inline">
                    <label>
                        <input type="radio" 
                                class="radio-type" 
                                <?= $this->Program_properties_group_model->category_type ==  SPECIALIST ? 'checked' : '' ?>
                                name="category_type" 
                                style="margin-top:1px" 
                                value="<?= SPECIALIST ?>">
                                Specialist
                    </label>
                </div>
            </div>  
            <?php
            if (isset($this->Program_properties_group_model->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $this->Program_properties_group_model->id ?>">
            <?php } ?>
            <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/program_property_group/manage') ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->
