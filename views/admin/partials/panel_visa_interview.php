<p>Pay attention to the following information before attending your visa interview:</p>
<ul>
    <li><b>Official Visa Interview Invitation</b></li>
    <div class="panel-body mt-3">
        <div class="col-lg-4">
            <div class="form-group">
                <label>Date</label>
                <input 
                    id="date" 
                    type="text" 
                    class="form-control datepicker" 
                    disabled
                    placeholder="Visa Interview Date" 
                    value="<?= $dt ? ($dt->date != '' ? date('d M Y', strtotime($dt->date)) : '') : '' ?>">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Time</label>
                <input 
                    disabled
                    type="text" 
                    id="time" 
                    class="form-control input_time" 
                    name="time" 
                    value="<?= $dt ? ($dt->date != '' ? (date('H:i', strtotime($dt->date)) == '00:00' ? '' : date('h:i A', strtotime($dt->date)) ) : '') : '' ?>" 
                    placeholder="Time">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Location</label>
                <select class="form-control" id="location" name="location" style="width:100%" disabled>
                    <option value="">-- Select --</option>
                    <option <?= $dt->location == 'Jakarta' ? 'selected' : '' ?> value="Jakarta">Jakarta</option>
                    <option <?= $dt->location == 'Surabaya' ? 'selected' : '' ?> value="Surabaya">Surabaya</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Appointment Confirmation Letter</label>
                <?php if ($dt->invitation_letter != '') { ?>
                    <br>
                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_invitation_letter">
                        <a href="<?=base_url() ?><?=$dt->invitation_letter ?>" class="lightbox" aria-haspopup="dialog">
                            <img id="preview_image_profile" data-old="<?php echo site_url($dt->invitation_letter); ?>" src="<?php echo get_preview($dt->invitation_letter); ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="<?=base_url() ?><?=$dt->invitation_letter ?>" id="button_download_img_photo" download="<?= get_full_name($grantee_grant) ?>_Appointment Confirmation Letter" title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($dt->invitation_letter) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if($grantee_grant->show_digital_grant_packet) { ?>
        <div class="col-lg-4">
            <div class="form-group">
                <?php if($is_admin || (!$is_admin && $dt->digital_grant_packet != '')) { ?>
                <label>Digital Grant Package</label>
                <?php } ?>
                <?php if ($dt->digital_grant_packet != '') { ?>
                    <br>
                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_digital_grant_packet">
                        <a href="<?=base_url() ?><?=$dt->digital_grant_packet ?>" class="lightbox" aria-haspopup="dialog">
                            <img id="preview_image_profile" data-old="<?php echo site_url($dt->digital_grant_packet); ?>" src="<?php echo get_preview($dt->digital_grant_packet); ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="<?=base_url() ?><?=$dt->digital_grant_packet ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($dt->digital_grant_packet) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</ul>