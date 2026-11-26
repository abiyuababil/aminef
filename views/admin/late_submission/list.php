<?php 
$last_grant = end($data);
?>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-12">
        <h1 class="page-header">
            Late Submission
        </h1>
    </div>
</div>
<form id="form-submit" name="form-submit" action="" method="POST" style="background: #dfdfdf;padding: 20px 20px 5px 20px;border-radius: 10px;margin-bottom: 20px;">
    <div class="row">
        <div class="form-group col-sm-3">
            <label>Grant Name</label>
            <select name="program_id" class="form-control select2" id="program_id">
                <option value="">--Choose one--</option>
                <?php
                foreach ($available_programs as $key => $prgm) {
                    echo "<option value='{$prgm->id}'>{$prgm->name}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label>Academic Year</label>
            <input type="number" name="fiscal_year" class="form-control" id="fiscal_year" required>
        </div>
        <div class="form-group col-sm-3">
            <label>Deadline Submit </label>
            <input type="text" name="end_offline_date" class="form-control datetime" id="end_offline_date" required style="background-color:#fff">
        </div>
        <div class="form-group col-sm-2">
            <label>&nbsp;</label><br/>
            <input class="btn btn-primary" type="submit" value="Submit" id="btn-submit"/>
        </div>
    </div>
</form>

    <!-- <div id="wrap-filter" class="data-header clearfix form-inline"> -->
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-right">
                    Date : <input type="text" class="form-control input-sm datepicker mr-3" name="date" onchange="document.forms.frm_manage.submit()" value="<?= $date ?>" />
                    Search : <input type="text" class="form-control input-sm" name="search" onkeypress="handleKeyPress(event)" value="<?= $search ?>"/>
                </div>
            </div>
        </form>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="30"><input type="checkbox" class="chk-all"></th>
                <th width="35" class="text-center">#</th>
                <th>Name</th>
                <th>Email</th>
                <!-- <th>Offline Register Date</th> -->
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($data) {
                $no = 1;
                foreach ($data as $row) {
                    ?>
                    <tr>
                        <td><input type="checkbox" class="chk-row" name="ids[]" form="form-submit" value="<?= $row->id ?>"></td>
                        <td><?= $no ?></td>
                        <td><?= get_full_name($row) ?></td>
                        <td><?= $row->primary_email ?></td>
                        <td><?=  $row->date_insert ? date('d M Y H:i', strtotime($row->date_insert)) : '' ?></td>
                    <?php
                    $no++;
                }
            }
            ?>
        </tbody>
    </table>
</div>