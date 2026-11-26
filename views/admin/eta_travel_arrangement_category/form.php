<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <form role="form" method="POST">
            <div class="form-group">
                <label>Category Name <span class="text-danger">*</span></label>
                <input class="form-control" name="name"
                    value="<?php echo (isset($this->Eta_travel_arrangement_category_model->name)) ? $this->Eta_travel_arrangement_category_model->name : '' ?>"
                    placeholder="eg: Roundtrip Ticket US Indonesia" required>
            </div>
            <div class="form-group">
                <label>Type <span class="text-danger">*</span></label>
                <select class="form-control" name="type" required>
                    <option value="">-- Select Type --</option>
                    <?php
                    $current_type = isset($this->Eta_travel_arrangement_category_model->type) ? $this->Eta_travel_arrangement_category_model->type : '';
                    ?>
                    <option value="international" <?php echo ($current_type === 'international') ? 'selected' : '' ?>>International</option>
                    <option value="domestic" <?php echo ($current_type === 'domestic') ? 'selected' : '' ?>>Domestic</option>
                    <option value="accommodation" <?php echo ($current_type === 'accommodation') ? 'selected' : '' ?>>Accommodation</option>
                </select>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="active" value="1"
                        <?php echo (!isset($this->Eta_travel_arrangement_category_model->id) || $this->Eta_travel_arrangement_category_model->active) ? 'checked' : '' ?>>
                    Active
                </label>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="need_upload" value="1"
                        <?php echo (!isset($this->Eta_travel_arrangement_category_model->id) || $this->Eta_travel_arrangement_category_model->need_upload) ? 'checked' : '' ?>>
                    Need Upload File for Ticket
                </label>
            </div>
            <!-- <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> 
                If fields below are set and filled in by the grantee, the travel arrangement data will appear.
            </div>
            <div class="form-group">
                <label>Grant Category</label>
                <select class="form-control" name="user_grantee_category_id" id="user_grantee_category_id">
                    <option value="">-- Select Category --</option>
                </select>
            </div>

            <div class="form-group">
                <label>Grant Step</label>
                <select class="form-control" name="user_grantee_step_id" id="user_grantee_step_id">
                    <option value="">-- Select Step --</option>
                </select>
            </div>

            <div class="form-group">
                <label>Custom Field</label>
                <select class="form-control" name="user_grantee_custom_fields_id" id="user_grantee_custom_fields_id">
                    <option value="">-- Select Submission --</option>
                </select>
            </div>
            <div class="form-group hide" id="user_grantee_custom_sub_fields_wrap">
                <label>Sub Custom Field</label>
                <select class="form-control" name="user_grantee_custom_sub_fields_id" id="user_grantee_custom_sub_fields_id">
                    <option value="">-- Select Sub Field --</option>
                </select>
            </div> -->
            <?php
            if (isset($this->Eta_travel_arrangement_category_model->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $this->Eta_travel_arrangement_category_model->id ?>">
            <?php } ?>
            <a href="<?php echo site_url('admin/eta_travel_arrangement_category/manage') ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>
 
