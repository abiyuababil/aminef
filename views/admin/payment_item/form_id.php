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
					<option value="">-- Select Category --</option>
					<?php
					foreach ($category_type as $category) {
						echo "<option value='" . $category . "' " . ($this->Payment_items_model->category_type == $category ? 'selected' : '') . ">" . $category . "</option>";
					}
					?>
				</select>
			</div>

			<div class="form-group">
				<label>Sub Category</label>
				<select name="sub_category_id" id="sub_category_id" class="form-control" require>
					<option value="">-- Select Sub Category --</option>
					<?php 
						if(isset($sub_categories)){
						
							foreach ($sub_categories as $sub_category) {
								echo "<option value='" . $sub_category->id . "' " . ($this->Payment_items_model->payment_sub_category_id == $sub_category->id ? 'selected' : '') . ">" . $sub_category->name . "</option>";
							}
						}
					?>
				</select>
			</div>

			<div class="form-group">
				<label>Payment Item</label>
				<input class="form-control" name="payment_item" value="<?php echo (isset($this->Payment_items_model->payment_item)) ? $this->Payment_items_model->payment_item : '' ?>" placeholder="eg: Stipend" required>
			</div>

			<div class="form-group">
                <label for="is_active"> Is Active </label>
                <input id="is_active" type="checkbox" value="1" name="is_active" <?= (!isset($this->Payment_items_model->is_active) || ($this->Payment_items_model->is_active == 1)) ? "checked" : "" ?>>
            </div>
			<div class="form-group">
                <label for="show_on_grantee_page"> Show on Grantee Page </label>
                <input id="show_on_grantee_page" type="checkbox" value="1" name="show_on_grantee_page" <?= (isset($this->Payment_items_model->show_on_grantee_page) && $this->Payment_items_model->show_on_grantee_page == 1) ? "checked" : "" ?>>
            </div>

			<?php
			if (isset($this->Payment_items_model->id)) {
			?>
				<input type="hidden" name="id" value="<?php echo $this->Payment_items_model->id ?>">
			<?php } ?>
			<?php $back_url = $this->session->userdata('redirect_url') ?: site_url('admin/payment_item/manage'); ?>
			<a href="<?php echo $back_url ?>" class="btn btn-default">Back</a>
			<button type="submit" class="btn btn-success">Submit</button>
		</form>
	</div>
	<!-- /.col-lg-4 -->
</div>
<!-- /.row -->