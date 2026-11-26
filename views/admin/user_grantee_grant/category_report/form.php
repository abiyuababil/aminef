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
            <div class="form-group">
                <label> Category Name</label>
                <input class="form-control" name="name" value="<?php echo (isset($this->User_grantee_grant_category_report_model->name)) ? $this->User_grantee_grant_category_report_model->name : '' ?>" placeholder="eg: On Going">
            </div>
            <div class="form-group">
                <label> Information </label>
                <textarea name="information" id="" class="form-control editor"><?php echo (isset($this->User_grantee_grant_category_report_model->name)) ? $this->User_grantee_grant_category_report_model->information : '' ?></textarea>
            </div>
            <div class="alert alert-info">
                Update dates here will populate any empty Start, End, or Reminder dates in grantee Report Settings. Existing values will not be overwritten.
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label> Start Date </label>
                        <input type="text" id="start_date" class="form-control datepicker" name="start_date" placeholder="Start Date" value="<?php echo (isset($this->User_grantee_grant_category_report_model->start_date) && $this->User_grantee_grant_category_report_model->start_date != '0000-00-00') ? date('d M Y', strtotime($this->User_grantee_grant_category_report_model->start_date)) : '' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> End Date </label>
                        <input type="text" id="end_date" class="form-control datepicker" name="end_date" placeholder="End Date" value="<?php echo (isset($this->User_grantee_grant_category_report_model->end_date) && $this->User_grantee_grant_category_report_model->end_date != '0000-00-00') ? date('d M Y', strtotime($this->User_grantee_grant_category_report_model->end_date)) : '' ?>">
                    </div>
                </div>  
                <div class="col-md-4">
                    <div class="form-group">
                        <label> Reminder Date </label>
                        <input type="text" id="remainder_date" class="form-control datepicker" name="remainder_date" placeholder="Reminder Date" value="<?php echo (isset($this->User_grantee_grant_category_report_model->remainder_date) && $this->User_grantee_grant_category_report_model->remainder_date != '0000-00-00') ? date('d M Y', strtotime($this->User_grantee_grant_category_report_model->remainder_date)) : '' ?>">
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label> Apply Defaults to All Grantees? </label>
                <input type="checkbox" value="1" name="apply_defaults_replace" <?= isset($this->User_grantee_grant_category_report_model->id) && $this->User_grantee_grant_category_report_model->apply_defaults_replace == 1 ? "checked" : "" ?>><br>
                <small class="form-text text-muted">When checked, this will replace all existing report dates with the values above for all grantees. When unchecked, it will only fill in empty dates.</small>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label> Upload Report Template? </label>
                <input type="checkbox" value="1" name="is_template" <?= (!isset($this->User_grantee_grant_category_report_model->id)) || $this->User_grantee_grant_category_report_model->is_template == 1 ? "checked" : "" ?>>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label> Is Active </label>
                <input type="checkbox" value="1" name="is_active" <?= (!isset($this->User_grantee_grant_category_report_model->id)) || $this->User_grantee_grant_category_report_model->is_active == 1 ? "checked" : "" ?>>
            </div>
            <?php
                if (isset($this->User_grantee_grant_category_report_model->id)) {
                ?>
                    <input type="hidden" name="id" value="<?php echo $this->User_grantee_grant_category_report_model->id ?>">
                <?php } ?>
                <a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->