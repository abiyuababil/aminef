<div class="panel-body">
    <div class="row form-group file-for-testing">
        <div class="col-lg-3">
            <label>Security Question</label>
        </div>
        <div class="col-lg-6">
            <input type="text" class="form-control" disabled
                value="<?= $dt->security_question ?>">
        </div>
    </div>

    <div class="row form-group">
        <div class="col-lg-3">
            <label>Test Date</label>
        </div>
        <div class="col-lg-6">
            <input type="text" class="form-control datepicker" disabled readonly
                style="background-color:#eee"
                value="<?= $dt->test_date ? date('d M Y', strtotime($dt->test_date)) : '' ?>">
        </div>
    </div>

    <div class="row form-group">
        <div class="col-lg-3">
            <label>Test Time</label>
        </div>
        <div class="col-lg-6">
            <input type="time" class="form-control input_time" disabled
                style="background-color:#eee"
                value="<?= $dt->test_date ? (date('H:i:s', strtotime($dt->test_date)) != '00:00:00' ? date('H:i', strtotime($dt->test_date)) : '') : '' ?>"
                
            >
        </div>
    </div>

    <div class="row form-group">
        <div class="col-lg-3">
            <label>Test Center</label>
        </div>
        <div class="col-lg-6">
            <input type="text" class="form-control" disabled
                value="<?= $dt->test_center ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-lg-3">
            <label>Format</label>
        </div>
        <div class="col-lg-6">
            <label class="radio-inline">
                <input type="radio" 
                        class="radio-nominee" 
                        <?= $dt->format == 'home_edition' ? 'checked' : ''?>
                        disabled
                        value="home_edition">
                        Home Edition
            </label>
            <label class="radio-inline">
                <input type="radio" 
                        class="radio-nominee" 
                        <?= $dt->format == 'in-person' ? 'checked' : ''?>
                        disabled
                        value="in-person">
                        In-Person 
            </label>
        </div>
    </div>
</div>