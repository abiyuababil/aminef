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
                <label>Category Type</label>
                <select name="category_type" id="category_type" class="form-control" require>
                    <option value="">-- SELECT CATEGORY--</option>
                    <?php
                    foreach ($category_type as $category) {
                        echo "<option value='" . $category . "' " . ($this->Payment_sub_category_model->category_type == $category ? 'selected' : '') . ">" . $category . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" name="name" value="<?php echo (isset($this->Payment_sub_category_model->name)) ? $this->Payment_sub_category_model->name : '' ?>" placeholder="eg: New Payment" required>
            </div>
            <div class="form-group">
                <label> Is Active </label>
                <input type="checkbox" value="1" name="is_active" <?= $this->Payment_sub_category_model->is_active == 1 ? "checked" : "" ?>>
            </div>
			<div class="form-group">
                <label for="show_on_grantee_page"> Show on Grantee Page </label>
                <input id="show_on_grantee_page" type="checkbox" value="1" name="show_on_grantee_page" <?= (isset($this->Payment_sub_category_model->show_on_grantee_page) && $this->Payment_sub_category_model->show_on_grantee_page == 1) ? "checked" : "" ?>>
            </div>
            <?php
            if (isset($this->Payment_sub_category_model->id)) {
            ?>
                <input type="hidden" name="id" value="<?php echo $this->Payment_sub_category_model->id ?>">
            <?php } ?>
            <?php $back_url = $this->session->userdata('redirect_url') ?: site_url('admin/payment_sub_category/manage'); ?>
            <a href="<?php echo $back_url ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->