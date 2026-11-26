<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-8">
        <form role="form" method="POST">
            <div class="form-group">
                <label>Title</label>
                <input class="form-control" name="title" value="<?php echo (isset($this->Announcements_model->title)) ? $this->Announcements_model->title : '' ?>" placeholder="" required>
            </div>
            <div class="form-group">
                <label>Manage for</label>
                <select name="country_id" id="country_id" class="form-control">
					<option value="">-- Select Country --</option>
                    <option <?= $this->Announcements_model->country_id == 999 ? 'selected' : '' ?> value="999">All</option>
                    <?php 
                    if($countries)
                    {
                        foreach($countries as $co) {
                            $selected = '';
                            if (isset($this->Announcements_model->country_id) && $this->Announcements_model->country_id == $co->id || $this->session->userdata('active_country') == $co->id )
                                $selected = 'selected="selected"';
                    ?>
                        <option value="<?php echo $co->id ?>" <?php echo $selected ?>><?php echo $co->name ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
				<textarea class="form-control editor" name="description"><?= $this->Announcements_model->description ?></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="status" class="form-control">
					<option <?= $this->Announcements_model->status == 1 || $this->Announcements_model->status == '' ? 'selected' : '' ?> value="1">Active</option>
                    <option <?= $this->Announcements_model->status == 0 ? 'selected' : '' ?> value="0">Inactive</option>
                </select>
            </div>
            <?php
            if (isset($this->Announcements_model->id)) {
            ?>
            <input type="hidden" name="id" value="<?php echo $this->Announcements_model->id ?>">
            <?php } ?>
            <a href="<?php echo site_url('admin/announcement/manage') ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->
