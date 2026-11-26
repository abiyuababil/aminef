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
            <input type="hidden" id="temp_category_id" value="<?= $this->User_grantee_grant_step_model->user_grantee_category_id; ?>">
            <div class="form-group">
                <label> Label </label>
                <input class="form-control" name="label" value="<?php echo (isset($this->User_grantee_grant_step_model->label)) ? $this->User_grantee_grant_step_model->label : '' ?>" placeholder="eg: Academic Information Session">
                <input type="hidden" name="sort" value="<?php echo (isset($this->User_grantee_grant_step_model->sort)) ? $this->User_grantee_grant_step_model->sort : $max_sort ?>">
            </div>
            <div class="form-group">
                <label> Is Multiple Fields? </label>
                <input type="checkbox" value="1" name="is_multiple_fields" <?= (!isset($this->User_grantee_grant_step_model->id)) || $this->User_grantee_grant_step_model->is_multiple_fields == 1 ? "checked" : "" ?>>
                <div class="row">
                    <div class="col-lg-3">
                        <input type="input" class="form-control" name="max_multiple" placeholder="Input Maximal Multiple Fields" value="<?php echo $this->User_grantee_grant_step_model->max_multiple ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label> Is Active </label>
                <input type="checkbox" value="1" name="is_active" <?= (!isset($this->User_grantee_grant_step_model->id)) || $this->User_grantee_grant_step_model->is_active == 1 ? "checked" : "" ?>>
            </div>
            <div class="form-group">
                <label> View Admin Only </label>
                <input type="checkbox" value="1" name="is_independen" <?= $this->User_grantee_grant_step_model->is_independen == 1 ? "checked" : "" ?> /> 
				<span class="label label-primary" style="width: 350px;" data-toggle="tooltip" data-placement="top" title="If ticked, this field will not appear on grantee account and only shown on admin.">i</span>
            </div>
            <?php if ($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
                <div class="form-group">
                    <label> Is Letter of Reference </label>
                    <input type="checkbox" value="1" id="is_letter_of_reference" name="is_letter_of_reference" <?= $this->User_grantee_grant_step_model->is_letter_of_reference == 1 ? "checked" : "" ?> /> 
                </div>
                <div class="form-group">
                    <label> Not show on Grantee Site </label>
                    <input type="checkbox" value="1" id="not_show_grantee" name="not_show_grantee" <?= $this->User_grantee_grant_step_model->not_show_grantee == 1 ? "checked" : "" ?> /> 
                </div>
            <?php } ?>
            <div class="form-group">
                <label> Note </label>
				<textarea name="note_letter_of_reference" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_step_model->note_letter_of_reference ?></textarea>
            </div>
            <?php
            if (isset($this->User_grantee_grant_step_model->id)) {
            ?>
                <input type="hidden" name="id" value="<?php echo $this->User_grantee_grant_step_model->id ?>">
            <?php } ?>
            <a href="<?php echo $btn_back; ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->