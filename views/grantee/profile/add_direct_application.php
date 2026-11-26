<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Add Direct Application</h2>
        <h1 class="page-header"><?php echo $grantee_grant->grant_name ?></h1>
    </div>
</div>
<div class="row">
<!-- <div id="submission-plan" class="tab-pane fade"> -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <form role="form" method="POST" enctype="multipart/form-data">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>University <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="university_id" style="width:100%" required>
                                <option value="">-- Select University --</option>
                                <?php foreach ($universities as $university) : ?>
                                    <?php $selected = $direct_application->university_id == $university->id ? 'selected' : ''; ?>
                                    <option value="<?= $university->id?>" <?= $selected ?>><?= $university->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" rows="4" class="form-control"><?= $direct_application->address ? $direct_application->address : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Degree Level</label>
                            <input class="form-control" name="degree_level" value="<?= $direct_application->degree_level ? $direct_application->degree_level : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Major</label>
                            <input class="form-control" name="major" value="<?= $direct_application->major ? $direct_application->major : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Specialization</label>
                            <input class="form-control" name="specialization" value="<?= $direct_application->specialization ? $direct_application->specialization : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Department</label>
                            <input class="form-control" name="department" value="<?= $direct_application->department ? $direct_application->department : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Credits</label>
                            <input class="form-control" name="credits" value="<?= $direct_application->credits ? $direct_application->credits : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Program Duration</label>
                            <input class="form-control" name="program_duration" value="<?= $direct_application->program_duration ? $direct_application->program_duration : '' ?>">
                        </div>
                        <!-- <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="2">-- Select Status --</option>
                                <option value="0" <?= $direct_application->status == '0' ? 'selected' : '' ?>>Rejected</option>
                                <option value="1" <?= $direct_application->status == '1' ? 'selected' : '' ?>>Admitted</option>
                            </select>
                        </div> -->
                        <div class="pull-left">
                            <a href="<?php echo site_url('grantee/placement/list/' . $this->session->userdata('grantee_user_id')) ?>" class="btn btn-default">Back</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>University Website</label>
                            <input class="form-control" name="link" value="<?= $direct_application->link ? $direct_application->link : '' ?>">
                        </div>
                        <!-- <div class="form-group">
                            <label>Support Letter</label>
                            <?php if($direct_application->support_letter != ''){ ?>
                            <br>
                            <a href="<?= site_url($direct_application->support_letter) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($direct_application->support_letter); ?>"></a>
                            <br/>
                            <a href=<?= base_url('grantee/profile/delete_file/support_letter/'.$direct_application->id.'/'.$direct_application->grantee_grant_id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
				
                            <?php } ?>
                            <input type="file" name="support_letter" id="" class="form-control mt-2">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div> -->
                        <!-- <div class="form-group">
                            <label>LoA</label>
                            <?php if($direct_application->loa != ''){ ?>
                            <br>
                            <a href="<?= site_url($direct_application->loa) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($direct_application->loa); ?>"></a>
                            <br/>
                            <a href=<?= base_url('grantee/profile/delete_file/loa/'.$direct_application->id.'/'.$direct_application->grantee_grant_id) ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px">Delete</a>
                            <?php } ?>
                            <input type="file" name="loa" id="" class="form-control mt-2">
                            <small class="file-for-testing">File Size Max 5MB</small>
                        </div> -->
                        <div class="form-group">
                            <label>Reason</label>
                            <textarea name="note" rows="4" class="form-control"><?= $direct_application->note ? $direct_application->note : '' ?></textarea>
                        </div>
                        <?php
                        if (isset($direct_application->id)) {
                        ?>
                            <input type="hidden" name="id" value="<?php echo $direct_application->id ?>">
                        <?php } ?>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>