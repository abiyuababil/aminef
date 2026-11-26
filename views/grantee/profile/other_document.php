<style>
    .content-letter{
        background-color:#e9eef4;
        padding:10px 10px 0 10px;
        margin: 1em 0;
    }
</style>
<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Other Document</h2>
        <h1 class="page-header"><?php echo $grantee_grant->grant_name ?></h1>
    </div>
</div>
<div class="row">
<!-- <div id="submission-plan" class="tab-pane fade"> -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <?php if($other_documents) { ?>
            <div class="panel-body">
                <div class="form-group">
                    <label>Medical Form</label><br />
                    <?php if ($other_documents->medical_form != '') { ?>
                        <div style="margin-bottom:10px; position:relative; width:100px;">
                            <a href="<?php echo base_url() ?><?php echo $other_documents->medical_form ?>" class="lightbox"><img height="100" src="<?php echo get_preview($other_documents->medical_form); ?>"></a>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label>Passport</label><br />
                    <?php if ($other_documents->passport != '') { ?>
                        <div style="margin-bottom:10px; position:relative; width:100px;">
                            <a href="<?php echo base_url() ?><?php echo $other_documents->passport ?>" class="lightbox"><img height="100" src="<?php echo get_preview($other_documents->passport); ?>"></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <?php if($other_documents_letter) { ?>
            <div class="panel-body" style="margin-top:-30px;">
                <h3>Letter for Supervisor</h3>
                <?php foreach ($other_documents_letter as $key => $value) { ?>
                    <div class="row content-letter">
                        <div class="form-group col-md-4">
                            <label>Field Supervisor Name</label>
                            <input type="text" value="<?= $value->supervisor_name; ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Institution Name</label>
                            <input type="text" value="<?= $value->institution_name; ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Position of Supervisor</label>
                            <input type="text" value="<?= $value->position_of_supervisor; ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Address</label>
                            <textarea class="form-control" readonly><?= $value->address; ?></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Position of Grantees</label>
                            <input type="text" value="<?= $value->institution_name; ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Approval Letter</label>
                            <input type="text" value="<?= $value->approval_letter; ?>" class="form-control" readonly>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>