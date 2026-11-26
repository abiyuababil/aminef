<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title ?>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-4">
        <form role="form" method="POST">
            <div class="form-group">
                <label>Test Types</label>
                <input class="form-control" name="name"
                    value="<?php echo (isset($this->Test_type_model->name)) ? $this->Test_type_model->name : '' ?>"
                    placeholder="eg: TOEFL Internet-based Test (iBT)" required>
            </div>
            <!-- <div class="form-group">
                <label>Min Score</label>
                <input class="form-control" name="min_score" type="number" step=".1"
                    value="<?php echo (isset($this->Test_type_model->min_score)) ? $this->Test_type_model->min_score + 0 : '' ?>"
                    placeholder="eg: 20" required>
            </div> -->
            <?php
            if (isset($this->Test_type_model->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $this->Test_type_model->id ?>">
            <?php } ?>
            <a href="<?php echo site_url('admin/test_types/manage') ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->