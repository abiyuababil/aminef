<div class="col-lg-6">
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
    <div class="form-group">
        <label>Degree Level <span class="text-danger">*</span></label>
        <input class="form-control" name="degree_level" id="degree_level">
    </div>
    <div class="form-group">
        <label>Major <span class="text-danger">*</span></label>
        <input class="form-control" name="major" id="major">
    </div>
    <div class="form-group">
        <label>Specialization <span class="text-danger">*</span></label>
        <input class="form-control" name="specialization" id="specialization">
    </div>
</div>

<div class="col-lg-6">
    <div class="form-group">
        <label>Department <span class="text-danger">*</span></label>
        <input class="form-control" name="department" id="department">
    </div>
    <div class="form-group">
        <label>Credits</label>
        <input class="form-control" name="credits">
    </div>
    <div class="form-group">
        <label>Program Duration</label>
        <input class="form-control" name="program_duration">
    </div>
    <div class="form-group">
        <label>University Website <span class="text-danger">*</span></label>
        <input class="form-control" name="link" id="link">
    </div>
</div>