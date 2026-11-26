
        <!-- online -->
        <div class="panel-body">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> Pre Departure Orientation</p>
        </div>
        <div class="panel-body">
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Start Date</label>
                    <?php $pdo_date = $dt->date != '' ? $dt->date : ($pre_depature_period->date != '' ? $pre_depature_period->date : $data_pre_depature->date) ?>
                    <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>End Date</label>
                    <?php $pdo_date = $dt->end_date != '' ? $dt->end_date : ($pre_depature_period->end_date != '' ? $pre_depature_period->end_date : $data_pre_depature->end_date) ?>
                    <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                </div>
            </div>

            <div class="col-lg-8">
                <div class="form-group">
                    <label>Location Online</label>
                    <?php $pdo_location_online = $dt->location != '' ? $dt->location : ($pre_depature_period->location != '' ? $pre_depature_period->location : $data_pre_depature->location) ?>
                    <textarea class="form-control editor_grantee"><?= $pdo_location_online ?></textarea>
                </div>
            </div>
        </div>

        <!-- offline -->
        <div class="panel-body">
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Start Date Offline</label>
                    <?php $pdo_date = $dt->date_offline != '' ? $dt->date_offline : ($pre_depature_period->date_offline != '' ? $pre_depature_period->date_offline : $data_pre_depature->date_offline) ?>
                    <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>End Date Offline</label>
                    <?php $pdo_date = $dt->end_date_offline != '' ? $dt->end_date_offline : ($pre_depature_period->date_offline != '' ? $pre_depature_period->date_offline : $data_pre_depature->date_offline) ?>
                    <input type="text" disabled style="<?= has_permission('selection', 'pre_departure_orientation') ? 'background-color:#fff' : ''?>" class="form-control datepicker" placeholder="Date" value="<?= $pdo_date ? date('d F Y H:i', strtotime($pdo_date)) : '' ?>">
                </div>
            </div>

            <div class="col-lg-8">
                <div class="form-group">
                    <label>Location Offline</label>
                    <?php $pdo_location_offline = $dt->location_offline != '' ? $dt->location_offline : ($pre_depature_period->location_offline != '' ? $pre_depature_period->location_offline : $data_pre_depature->location_offline) ?>
                    <textarea class="form-control editor_grantee"><?= $pdo_location_offline ?></textarea>
                </div>
            </div>
        </div>