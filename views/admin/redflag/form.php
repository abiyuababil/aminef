<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-9">
        <form role="form" method="POST">
            <div class="form-group">
                <label>Name</label>
                <select name="user_id" id="user_id" class="form-control selectpicker" data-live-search="true" required>
                    <option value="">- Search Name -</option>
                    <?php if (isset($redflag->id)): ?>
                        <!-- inject option untuk data edit -->
                        <option value="<?= $redflag->user_id ?>" selected>
                            <?= get_full_name($redflag) ?>
                        </option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Program</label>
                <select name="program_id" id="program_id" class="form-control selectpicker" data-live-search="true" required>
                    <option value="">- Select -</option>
                    <?php if(isset($programs)) { ?>
                        <?php foreach($programs as $p) { ?>

                            <option value="<?= $p->id ?>" <?= $redflag->program_id ==  $p->id ? 'selected="selected"' : '' ?>>
                                <?= $p->name ?> (<?= $p->year_departure ?>)
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Comment</label>
                <textarea name="comment" id="comment" class="form-control" rows="5"><?php echo $redflag->comment ?></textarea>
            </div>
            <?php
            if (isset($redflag->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $redflag->id ?>">
            <?php } ?>
            <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/redflag/manage/' . $country_id) ?>"
               class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->