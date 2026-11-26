<div class="row">
    <div class="col-lg-12">
        <h1>Questions</h1>
        <h3 class="page-header"><?= $data->year ?></h3>
    </div>
</div>

<div class="row">
    <form id="form" role="form" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <?php if ($this->session->flashdata('info')) { ?>
                        <div class="col-md-12">
                            <div class="alert alert-success"><i class="fa fa-info-circle"></i> <?= $this->session->flashdata('info'); ?> </div>
                            <?php $this->session->flashdata('info', false); ?>
                        </div>
                        <?php } ?>
    
                        <div class="col-md-6" style="display: flex;">
                            <div class="form-group mr-2">
                                <div id="frm-action" class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:;" data-action="delete">Delete</a></li>
                                        <li><a href="javascript:;" data-action="copy_grant">Copy to Grant</a></li>
                                    </ul>
                                    <input type="hidden" name="action" value="" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="<?= site_url('admin/settings_det/sort_question/' . $data->id); ?>" class="btn btn-info btn-sm">
                                    <i class="fa fa-arrows"></i> SORTING
                                </a>
                                <a href="<?= site_url('det/preview/data/' . $data->id) ?>" class="btn btn-warning btn-sm" target="_blank">
                                    <i class="fa fa-eye"></i> PREVIEW
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/settings_det/manage')?>" class="btn btn-default">Back</a>
                            <a href="<?= site_url('admin/settings_det/add_question/' . $data->id) ?>" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Question
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" class="chk-all"></th>
                                    <th width="35" class="text-center">#</th>
                                    <th>Question</th>
                                    <th>Type</th>
                                    <th class="text-right">Status</th>
                                    <th width="300" class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($questions) && $questions): ?>
                                    <?php $no = 1; foreach($questions as $question): ?>
                                    <tr>
                                        <td><input type="checkbox" form="frm_copy" class="chk-row" name="ids[]" value="<?= $question->id ?>"></td>
                                        <td><?= $no ?></td>
                                        <td><?= $question->name ?></td>
                                        <td><?= $question->type ?></td>
                                        <td class="text-right">
                                            <span class="label label-<?= $question->is_active ? 'success' : 'danger' ?>">
                                                <?= $question->is_active ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="<?= site_url('admin/settings_det/edit_question/' . $fisacal_year_id .'/'.$question->id) ?>" class="btn btn-primary btn-xs" title="Edit Grant Page">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= site_url('admin/settings_det/delete_question/' . $question->id) ?>" class="btn btn-danger btn-xs confirm-del" title="Delete">
                                                <i class="fa fa-times-circle"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No data found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>