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
            						<option <?= $this->User_grantee_grant_category_model->user_grantee_grant_id == $value->id ? "selected": ""?> value="<?= $value->id; ?>"><?= $value->name; ?></option>
            					<?php endforeach; ?>
            				</select>
            			</div>
						<div class="form-group">
							<label> Category Name</label>
							<input class="form-control" name="name" value="<?php echo (isset($this->User_grantee_grant_category_model->name)) ? $this->User_grantee_grant_category_model->name : '' ?>" placeholder="eg: Fullbright Master">
						</div>
						
            			<div class="form-group">
            				<label>Sort</label>
            				<input type="number" name="sort" class="form-control" value="<?= $this->User_grantee_grant_category_model->sort; ?>">
            			</div>
						<div class="form-group">
							<label> Is Active </label>
							<input type="checkbox" value="1" name="is_active" <?= $this->User_grantee_grant_category_model->is_active == 1 ? "checked" : "" ?>	 >
						</div>
						<?php
						if (isset($this->User_grantee_grant_category_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->User_grantee_grant_category_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/user_grantee_grant_category/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->