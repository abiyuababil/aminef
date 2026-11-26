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
            				<label>Grant</label>
            				<select id="grant" name="user_grantee_grant_id" class="form-control">
            					<option value="">Select Grant</option>
            					<?php foreach ($property_grant as $value) : ?>
            						<option <?= $this->User_grantee_grant_category_report_model->user_grantee_grant_id == $value->id ? "selected" : "" ?> value="<?= $value->id; ?>"><?= $value->name; ?></option>
            					<?php endforeach; ?>
            				</select>
            			</div>
            			<div class="form-group">
            				<label> Name </label>
            				<input class="form-control" name="name" value="<?php echo (isset($this->User_grantee_grant_category_report_model->name)) ? $this->User_grantee_grant_category_report_model->name : '' ?>" placeholder="eg: 1, 2 , 3 etc">
            			</div>
            			<div class="form-group">
            				<label> Information </label>
            				<textarea name="information" id="" class="form-control editor"><?php echo (isset($this->User_grantee_grant_category_report_model->name)) ? $this->User_grantee_grant_category_report_model->information : '' ?></textarea>
            			</div>
            			<div class="form-group">
            				<label> Is Active </label>
            				<input type="checkbox" value="1" name="is_active" <?= $this->User_grantee_grant_category_report_model->is_active == 1 ? "checked" : "" ?>>
            			</div>
            			<?php
						if (isset($this->User_grantee_grant_category_report_model->id)) {
						?>
            				<input type="hidden" name="id" value="<?php echo $this->User_grantee_grant_category_report_model->id ?>">
            			<?php } ?>
            			<a href="<?php echo site_url('admin/user_grantee_grant_category_report/manage') ?>" class="btn btn-default">Back</a>
            			<button type="submit" class="btn btn-success">Submit</button>
            		</form>
            	</div>
            	<!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->