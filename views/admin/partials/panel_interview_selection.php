<div class="panel-body">
    <div class="col-lg-4">
        <div class="form-group">
            <label>Interview Date</label>
            <input disabled id="date_0" class="form-control datepicker" readonly style="background-color:#eee" value="<?= ($grantee_grant->date_interview != '' ? date('d M Y', strtotime($grantee_grant->date_interview)) : '') ?>" placeholder="Date">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label>Interview Time</label>
            <input 
                disabled 
                type="text" 
                id="time_0" 
                class="form-control input_time" 
                value="<?= ($grantee_grant->date_interview != '' ? (date('H:i', strtotime($grantee_grant->date_interview)) == '00:00' ? '' : date('h:i A', strtotime($grantee_grant->date_interview)) ) : '') ?>" 
                placeholder="Time">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label>Venue</label>
            <textarea disabled class="form-control" cols="30" rows="5"><?= $grantee_grant->location ?></textarea>
        </div>  
    </div>
</div>