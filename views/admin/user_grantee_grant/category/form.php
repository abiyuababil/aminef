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
            <?php if($this->session->userdata('active_country') == 2){ ?>
                <div class="form-group">
                    <label style="margin-right:10px">Category Menu </label>
                    <div>
                        <div class="radio d-inline mr-4">
                            <label><input type="radio" class="grant-alumni" name="is_new_grantee" style="margin-top:3px" value="3" <?= $this->User_grantee_grant_category_model->is_new_grantee == 3 || !$this->User_grantee_grant_category_model->is_new_grantee ? 'checked' : '' ?>><?php echo get_category_grant_page_name(3); ?></label>
                        </div>
                        <div class="radio d-inline mr-4">
                            <label><input type="radio" class="grant-alumni" name="is_new_grantee" style="margin-top:3px" value="1" <?= $this->User_grantee_grant_category_model->is_new_grantee == 1 ? 'checked' : '' ?>><?php echo get_category_grant_page_name(1); ?></label>
                        </div>
                        <div class="radio d-inline mr-4">
                            <label><input type="radio" class="grant-alumni" name="is_new_grantee" style="margin-top:3px" value="4" <?= $this->User_grantee_grant_category_model->is_new_grantee == 4 ? 'checked' : '' ?>><?php echo get_category_grant_page_name(4); ?></label>
                        </div>
                        <div class="radio d-inline mr-4">
                            <label><input type="radio" class="grant-alumni" name="is_new_grantee" style="margin-top:3px" value="0" <?= $this->User_grantee_grant_category_model->is_new_grantee == '0' ? 'checked' : '' ?>><?php echo get_category_grant_page_name(0); ?></label>
                        </div>
                        <div class="radio d-inline mr-4">
                            <label><input type="radio" class="grant-alumni" name="is_new_grantee" style="margin-top:3px" value="2" <?= $this->User_grantee_grant_category_model->is_new_grantee == 2 ? 'checked' : '' ?>><?php echo get_category_grant_page_name(2); ?></label>
                        </div>
                        <div class="radio d-inline mr-4">
                            <label><input type="radio" class="grant-alumni" name="is_new_grantee" style="margin-top:3px" value="5" <?= $this->User_grantee_grant_category_model->is_new_grantee == 5 ? 'checked' : '' ?>><?php echo get_category_grant_page_name(5); ?></label>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label>Grant Page</label>
                <select class="form-control select2" name="name" id="name">
                    <option value="">-- Select Grant Page --</option>
                    <?php
                    if ($category_name) {
                        sort($category_name, SORT_STRING);
                        foreach ($category_name as $ge) {
                            $selected = '';
                            if ($this->User_grantee_grant_category_model->name == $ge) {
                                $selected = 'selected="selected"';
                            }
                            ?>
                            <option value="<?php echo $ge ?>" <?php echo $selected ?>><?php echo $ge ?></option>
                        <?php
                    }
                }
                ?>
                </select>
				<input type="hidden" name="sort" value="<?=  (isset($this->User_grantee_grant_category_model->sort)) ? $this->User_grantee_grant_category_model->sort : $max_sort; ?>">
            </div>
            <div class="form-group">
                <label> Is Active </label>
                <input type="checkbox" value="1" name="is_active" <?= (!isset($this->User_grantee_grant_category_model->id)) || $this->User_grantee_grant_category_model->is_active == 1 ? "checked" : "" ?>>
            </div>
            <div class="form-group">
                <label> Is Read-only </label>
                <input type="checkbox" value="1" name="is_readonly" <?= (!isset($this->User_grantee_grant_category_model->id)) || $this->User_grantee_grant_category_model->is_readonly == 1 ? "checked" : "" ?>>
            </div>
            <div class="form-group">
                <label> Always Accessible </label>
                <input type="checkbox" value="1" name="always_accessible" <?= (!isset($this->User_grantee_grant_category_model->id)) || $this->User_grantee_grant_category_model->always_accessible == 1 ? "checked" : "" ?>>
            </div>

            <?php if($this->session->userdata('active_country') == AMERICAN_DATABASE){ ?>
			<div class="form-group">
				<label>Trigger Set to Alumni?</label>
				<input type="checkbox" value="1" name="trigger_set_to_alumni" <?= $this->User_grantee_grant_category_model->trigger_set_to_alumni == 1 ? "checked" : "" ?> />
			</div>
			<div class="form-group">
				<label>Reveal only when all reports are submitted?</label>
				<input type="checkbox" value="1" name="view_report_submitted" <?= $this->User_grantee_grant_category_model->view_report_submitted == 1 ? "checked" : "" ?> />
			</div>
            <div class="form-group">
				<label>Show Notify Grantee</label>
				<input type="checkbox" value="1" name="show_notify_grantee" <?= $this->User_grantee_grant_category_model->show_notify_grantee == 1 ? "checked" : "" ?> />
			</div>
            <?php } ?>
            <?php
            if (isset($this->User_grantee_grant_category_model->id)) {
            ?>
                <input type="hidden" name="id" value="<?php echo $this->User_grantee_grant_category_model->id ?>">
            <?php } ?>
            <?php if (isset($period_id) && $period_id) { ?>
                <input type="hidden" name="period_id" value="<?php echo $period_id ?>">
            <?php } ?>
            <a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
            <button type="button" class="btn btn-success" onclick="validate_form()">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->