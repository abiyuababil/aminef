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
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Date</label>
                    <input class="form-control datepickerCalendar" name="date" value="<?php echo (isset($this->Calendar_model->date)) ? date('d F', strtotime($this->Calendar_model->date)) : '' ?>" placeholder="Date" required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" id="" rows="4"><?php echo (isset($this->Calendar_model->description)) ? $this->Calendar_model->description : '' ?></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <?php
                if (isset($this->Calendar_model->id)) {
                ?>
                    <input type="hidden" name="id" value="<?php echo $this->Calendar_model->id ?>">
                <?php } ?>
                <a href="<?php echo site_url('admin/calendar/manage') ?>" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->