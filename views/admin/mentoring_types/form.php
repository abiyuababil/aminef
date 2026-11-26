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
    <div class="col-lg-9">
        <form role="form" method="POST">
            <div class="form-group">
                <label>Mentoring Type</label>
                <input class="form-control" name="name"
                    value="<?php echo (isset($data->name)) ? $data->name : '' ?>"
                    placeholder="eg: Objectives and Motivations" required>
            </div>
            <div class="form-group">
                <label>Grant</label>
                <select class="form-control selectpicker" name="grant_id[]" data-live-search="true" multiple>
                    <option value="0">All</option>
                    <?php foreach ($program_available as $program) { ?>
                        <option value="<?php echo $program->id; ?>" <?php echo (in_array($program->id, (array)$data->grant_id)) ? 'selected="selected"' : '' ?>>
                            <?php echo $program->name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <?php
            if (isset($data->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $data->id ?>">
            <?php } ?>
            <a href="<?php echo site_url('admin/mentoring_types/manage') ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->