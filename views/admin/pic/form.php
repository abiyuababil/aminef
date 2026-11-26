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
							<label>PIC Name</label>
							<input class="form-control" name="name" value="<?php echo (isset($this->Pics_model->name)) ? $this->Pics_model->name : '' ?>" placeholder="eg: John Doe">
						</div>
						<div class="form-group">
							<label>Staff</label>
							<select name="staff_id" id="staff_id" class="form-control selectpicker" data-live-search="true">
								<option value="">-- Select Staff --</option>
								<?php foreach (get_all_db('am_staffs', ['country_id' => INDONESIAN_DATABASE]) as $key => $value) { ?>
									<option value="<?= $value->id ?>" <?= (isset($this->Pics_model->staff_id) && $this->Pics_model->staff_id == $value->id) ? 'selected' : '' ?>><?= $value->full_name ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label> Is Active </label>
							<input type="checkbox" value="1" name="is_active" <?= $this->Pics_model->is_active == 1 ? "checked" : "" ?>>
						</div>
						<?php
						if (isset($this->Pics_model->id)) {
						?>
						<input type="hidden" name="id" value="<?php echo $this->Pics_model->id ?>">
						<?php } ?>
						<a href="<?php echo site_url('admin/pic/manage') ?>" class="btn btn-default">Back</a>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
