<h3>
    Letter for Supervisor
    <?php if(!$is_alumni_page){ ?>
    <button class="btn btn-xs btn-primary btn-add-letter" type="button">
        <span class="fa fa-plus"></span> Add Letter
    </button>
    <?php } ?>
</h3>
<div class="letter">
    <?php if (count($other_documents_letter) > 0) : ?>
        <?php foreach ($other_documents_letter as $key => $value) { ?>
            <div class="row">
                <div class="col-sm-11">
                    <hr>
                </div>
                <div class="col-sm-1">
                    <a href="<?= base_url('admin/nominee/other_documents/delete_letter/'. $value->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger pull-right">
                        <span class="fa fa-trash"></span>
                    </a>
                </div>
            </div>
            <div class="row content-letter">
                <div class="form-group col-md-4">
                    <label>Field Supervisor Name</label>
                    <input type="hidden" name="doc_id[]" value="<?= $value->id ?>">
                    <input type="text" name="supervisor_name[]" value="<?= $value->supervisor_name; ?>" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Institution Name</label>
                    <input type="text" name="institution_name[]" value="<?= $value->institution_name; ?>" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Position of Supervisor</label>
                    <input type="text" name="position_of_supervisor[]" value="<?= $value->position_of_supervisor; ?>" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Address</label>
                    <textarea name="address[]" class="form-control"><?= $value->address; ?></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label>Position of Grantees</label>
                    <input type="text" name="position_of_grantees[]" value="<?= $value->institution_name; ?>" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Approval Letter</label>
                    <input type="text" name="approval_letter[]" value="<?= $value->approval_letter; ?>" class="form-control">
                </div>
            </div>
        <?php } ?>
    <?php else: ?>
        <div class="row content-letter">
            <div class="form-group col-md-4">
                <label>Field Supervisor Name</label>
                <input type="text" name="supervisor_name[]" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Institution Name</label>
                <input type="text" name="institution_name[]" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Position of Supervisor</label>
                <input type="text" name="position_of_supervisor[]" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Address</label>
                <textarea name="address[]" class="form-control"></textarea>
            </div>
            <div class="form-group col-md-4">
                <label>Position of Grantees</label>
                <input type="text" name="position_of_grantees[]" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Approval Letter</label>
                <input type="text" name="approval_letter[]" class="form-control">
            </div>
        </div>
    <?php endif; ?>
</div>
