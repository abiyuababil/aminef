<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-12">
        <h1 class="page-header">
            <a href="<?php echo site_url('admin/alumni/edit/' . $this->User_model->id) ?>">
                <?php echo $this->User_model->full_name() ?>
            </a>
        </h1>
    </div>
</div>

<form action="<?= base_url() ?>admin/alumni/join_new_program" method="POST"
      style="background: #dfdfdf;padding: 20px 20px 5px 20px;border-radius: 10px;margin-bottom: 20px;">
    <div class="row">
        <input name="user_id" type="hidden" value="<?= $this->User_model->id ?>"/>
        <input name="country_id" type="hidden" value="<?= $country_id ?>"/>

        <div class="form-group col-sm-4">
            <label>Grant Name</label>
            <select name="program_id" class="form-control" required>
                <option value="">--Choose one--</option>
                <?php
                foreach ($available_programs as $key => $prgm) {
                    echo "<option value='{$prgm->id}'>{$prgm->name}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label><?= get_active_country() == 'Indonesian' ? 'Academic Year' : 'Fiscal Year' ?></label><br/>
            <input class="form-control" type="number" name="fiscal_year" required>
        </div>
        <div class="form-group col-sm-4">
            <label>&nbsp;</label><br/>
            <input class="btn btn-primary" type="submit" value="Add Grant"/>
        </div>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="35" class="text-center">#</th>
                <th>Grant Name</th>
                <th><?= get_active_country() == 'Indonesian' ? 'Academic Year' : 'Fiscal Year' ?></th>
                <th>Year Degree Obtained</th>
                <th width="250" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($data) {
                $no = 1;
                foreach ($data as $row) {
                    ?>
                    <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $row->name ?></td>
                        <td><?php echo $row->year_departure ?></td>
                        <td><?php echo $row->year ?></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-info btn-xs btn_change" data-toggle="modal" data-target="#mdl_edit" data-id="<?= $row->program_id; ?>">
                                <i class="fa fa-exchange"></i> Change
                            </a>
                            <a href="<?php echo site_url('admin/alumni/edit/' . $this->User_model->id . '?pid=' . $row->id) ?>"
                               class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> Edit Data
                            </a>
                            <a href="<?php echo site_url('admin/alumni/remove_program/' . $this->User_model->id . '/' . $row->id) ?>"
                               class="btn btn-danger btn-xs confirm-del" data-value="<?php echo $row->name ?>">
                                <i class="fa fa-times-circle"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php
                    $no++;
                }
            }
            ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="mdl_edit">
    <div class="modal-dialog">
        <form action="<?= base_url(); ?>admin/alumni/rejoin_program/<?= $this->User_model->id; ?>" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Grants</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input name="user_id" type="hidden" value="<?= $this->User_model->id; ?>"/>
                        <input name="country_id" type="hidden" value="<?= $country_id; ?>"/>
                        <input name="program_id" type="hidden" id="ex_program_id"/>

                        <label>Grant Name</label>
                        <select name="new_program_id" class="form-control" id="new_program_id" required>
                            <option value="">--Choose one--</option>
                            <?php
                            foreach ($available_programs as $key => $prgm) {
                                echo "<option value='{$prgm->id}'>{$prgm->name}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        </form>
    </div>
</div>