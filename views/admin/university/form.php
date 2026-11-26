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
                <label>Name</label>
                <input class="form-control" name="name"
                       value="<?php echo (isset($this->Universities->name)) ? $this->Universities->name : '' ?>"
                       placeholder="eg: Univesity of Oxford" required>
            </div>
            <div class="form-group">
                <label>Country</label>
                <select id="country" class="form-control select2" name="country" style="width:100%">
                    <option value="">-- Select Country --</option>
                    <?php
                    if ($country_list) {
                        foreach ($country_list as $cl) {
                            $selected = '';
                            if ($this->Universities->country == $cl->id) {
                                $selected = 'selected="selected"';
                            }
                            ?>
                            <option value="<?php echo $cl->id ?>" <?php echo $selected ?>><?php echo $cl->name ?></option>
                        <?php
                    }
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>State/Province</label>
                <img src="<?php echo base_url() ?>/img/loading.gif" id="load-state" style="display:none;">
                <select id="state" class="form-control select2" name="state" style="width:100%">
                    <option value="">-- Select State/Province --</option>
                    <?php
                    if ($state_list) {
                        foreach ($state_list as $sl) {
                            $selected = '';
                            if ($this->Universities->state == $sl->id) {
                                $selected = 'selected="selected"';
                            }
                            ?>
                            <option value="<?php echo $sl->id ?>" <?php echo $selected ?>><?php echo $sl->name ?></option>
                        <?php
                    }
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>City</label>
                <img src="<?php echo base_url() ?>/img/loading.gif" id="load-city" style="display:none;">
                <select id="city" class="form-control select2" name="city" style="width:100%">
                    <option value="">-- Select City --</option>
                    <?php
                    if ($city_list) {
                        foreach ($city_list as $cl) {
                            $selected = '';
                            if ($this->Universities->city == $cl->id) {
                                $selected = 'selected="selected"';
                            }
                            ?>
                            <option value="<?php echo $cl->id ?>" <?php echo $selected ?>><?php echo $cl->name ?></option>
                        <?php
                    }
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" cols="30" rows="10" class="form-control" width="100%"><?= $this->Universities->description ?></textarea>
            </div>
            <?php
            if (isset($this->Universities->id)) {
                ?>
                <input type="hidden" name="id" value="<?php echo $this->Universities->id ?>">
            <?php } ?>
            <a href="<?php echo $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/country_list/manage') ?>"
               class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->
