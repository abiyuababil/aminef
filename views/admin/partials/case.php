<div id="case" class="active in first_tab">
    <div class="panel-body">
        <div class="col-lg-12">
            <div class="form-group">
                <?php if($is_admin) { ?>
                <br />
                <button type="button" class="btn btn-primary add_case" data-toggle="modal" data-target="#add_case">Add New</button>
                <?php } ?>
                <table class="table table-striped table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Summary</th>
                            <th>File</th>
                            <th>Modified on</th>
                            <?php if($is_admin) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="list_case">
                        <?php foreach($data_cases as $index => $case) { ?>
                        <tr id="index-case-<?= $index + 1 ?>">
                            <td><?= $case->type ?></td>
                            <td><?= $case->summary ?></td>
                            <td>
                                <a href="<?= base_url($case->file) ?>" class="lightbox" style="color:#337ab7">
                                    <?= $case->filename ?>
                                </a>
                            </td>
                            <td><?= $case->created_date ?></td>
                            <?php if($is_admin) { ?>
                            <td>
                                <a onclick="edit_data_case(this, <?= $case->id ?>, <?= $index + 1 ?>)" class="btn btn-primary btn-xs edit-case" style="color:#fff">
                                    Edit
                                </a>
                                <a href="javascript:;" onclick="del_data_case(this, <?= $case->id ?>)" class="btn btn-danger btn-xs" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>