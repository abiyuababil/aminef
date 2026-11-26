<div class="<?= $is_grantee ? 'col-lg-12' : 'col-lg-6' ?>">
    <div class="form-group">
        <label>University <span class="text-danger">*</span></label>
        <select id="university_id" class="form-control select2univ" name="university_id" style="width:100%">
            <option value="">-- Select University --</option>
            <?php foreach ($universities as $university) : ?>
                <?php $selected = $this->Submission_plan_model->university_id == $university->id ? 'selected' : ''; ?>
                <option value="<?= $university->id?>" <?= $selected ?>><?= $university->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label>Address</label>
        <textarea name="address" rows="4" class="form-control"><?= (isset($this->Submission_plan_model->address)) ? $this->Submission_plan_model->address : '' ?></textarea>
    </div> -->
    <div class="form-group">
        <label>Degree Level</label>
        <input class="form-control" name="degree_level" value="<?php echo (isset($this->Submission_plan_model->degree_level)) ? $this->Submission_plan_model->degree_level : '' ?>" >
    </div>
    <div class="form-group">
        <label>Major</label>
        <input class="form-control" name="major" value="<?php echo (isset($this->Submission_plan_model->major)) ? $this->Submission_plan_model->major : '' ?>" >
    </div>
    <div class="form-group">
        <label>Specialization</label>
        <input class="form-control" name="specialization" value="<?php echo (isset($this->Submission_plan_model->specialization)) ? $this->Submission_plan_model->specialization : '' ?>" >
    </div>
    <div class="form-group">
        <label>Department</label>
        <input class="form-control" name="department" value="<?php echo (isset($this->Submission_plan_model->department)) ? $this->Submission_plan_model->department : '' ?>" >
    </div>
    <div class="form-group">
        <label>Credits</label>
        <input class="form-control" name="credits" value="<?php echo (isset($this->Submission_plan_model->credits)) ? $this->Submission_plan_model->credits : '' ?>" >
    </div>
    <div class="form-group">
        <label>Program Duration</label>
        <input class="form-control" name="program_duration" value="<?php echo (isset($this->Submission_plan_model->program_duration)) ? $this->Submission_plan_model->program_duration : '' ?>" >
    </div>
    <div class="form-group">
        <label>University Website</label>
        <input class="form-control" name="link" value="<?php echo (isset($this->Submission_plan_model->link)) ? $this->Submission_plan_model->link : '' ?>" >
    </div>
    <?php if(!$is_grantee) { ?>
    <div class="form-group">
        <label>Note</label>
        <textarea name="note" rows="4" class="form-control"><?= (isset($this->Submission_plan_model->note)) ? $this->Submission_plan_model->note : '' ?></textarea>
    </div>
    <?php } ?>

    <?php
    if (isset($this->Submission_plan_model->id)) {
    ?>
        <input type="hidden" name="id" value="<?php echo $this->Submission_plan_model->id ?>">
    <?php } ?>
</div>

<?php if(!$is_grantee) { ?>
<div class="col-lg-6">
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="3">-- Select Status --</option>
            <option value="0" <?= $this->Submission_plan_model->status == '0' ? 'selected' : '' ?>>Rejected by IIE</option>
            <option value="1" <?= $this->Submission_plan_model->status == '1' ? 'selected' : '' ?>>Approved by IIE</option>
            <option value="7" <?= $this->Submission_plan_model->status == '7' ? 'selected' : '' ?>>Cancelled by IIE</option>
            <option value="2" <?= $this->Submission_plan_model->status == '2' ? 'selected' : '' ?>>Pending Review</option>
            <option value="4" <?= $this->Submission_plan_model->status == '4' ? 'selected' : '' ?>>Approved by Nominee</option>
            <option value="5" <?= $this->Submission_plan_model->status == '5' ? 'selected' : '' ?>>Rejected by Nominee</option>
            <option value="6" <?= $this->Submission_plan_model->status == '6' ? 'selected' : '' ?>>Reject</option>
        </select>
    </div>
    <div class="form-group">
        <label>Reply Deadline</label>
        <input class="form-control datepicker" name="reply_deadline" value="<?php echo (isset($this->Submission_plan_model->reply_deadline) && $this->Submission_plan_model->reply_deadline != '') ? date('d M Y', strtotime($this->Submission_plan_model->reply_deadline)) : '' ?>" >
    </div>
    <div class="form-group">
        <label>Recommendation</label>
        
        <input type="radio" name="recommendation" value="IIE" <?= $recommendation['IIE'] ?>> IIE 
        <input type="radio" name="recommendation" value="Grantee" <?= $recommendation['Grantee'] ?>> Grantee 
    </div>
    <div class="form-group">
        <label>Submission Plan</label>
        <?php if($this->Submission_plan_model->submission_plan != ''){ ?><br>
        <a href="<?= site_url($this->Submission_plan_model->submission_plan) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($this->Submission_plan_model->submission_plan); ?>"></a>
        <br/>
        <a href=<?= base_url('admin/nominee/submission_plan/delete_file/submission_plan/'.$this->Submission_plan_model->id.'/'.$grantee_grant_id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
        <?php } ?>
        <input type="file" name="submission_plan" id="" class="form-control" >
        <small class="file-for-testing">File Size Max 5MB</small>
    </div>
    <!-- <div class="form-group">
        <label>Support Letter</label>
        <?php if($this->Submission_plan_model->support_letter != ''){ ?><br>
        <a href="<?= site_url($this->Submission_plan_model->support_letter) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($this->Submission_plan_model->support_letter); ?>"></a>
        <br>
        <a href=<?= base_url('admin/nominee/submission_plan/delete_file/support_letter/'.$this->Submission_plan_model->id.'/'.$grantee_grant_id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
        <?php } ?>
        <input type="file" name="support_letter" id="" class="form-control" >
        <small class="file-for-testing">File Size Max 5MB</small>
    </div> -->
    <!-- <div class="form-group">
        <label>LoA</label>
        <?php if($this->Submission_plan_model->loa != ''){ ?><br>
        <a href="<?= site_url($this->Submission_plan_model->loa) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($this->Submission_plan_model->loa); ?>"></a>
        <br>
        <a href=<?= base_url('admin/nominee/submission_plan/delete_file/loa/'.$this->Submission_plan_model->id.'/'.$grantee_grant_id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
        <?php } ?>
        <input type="file" name="loa" id="" class="form-control" >
        <small class="file-for-testing">File Size Max 5MB</small>
    </div> -->
</div>
<?php } ?>



<?php if(!$is_grantee) { ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel pull-right">
                <a href="<?php echo site_url('admin/nominee/submission_plan/manage/' . $grantee_grant_id) ?>" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
<?php } ?>