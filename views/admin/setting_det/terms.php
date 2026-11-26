<div class="row">
    <div class="col-lg-12">
        <h1>Terms</h1>
        <h3 class="page-header"><?= $data->year ?></h3>
    </div>
</div>

<div class="row">
    <form id="form" role="form" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <?php if ($this->session->flashdata('info_terms')) { ?>
                        <div class="col-md-12">
                            <div class="alert alert-success"><i class="fa fa-info-circle"></i> <?= $this->session->flashdata('info_terms'); ?> </div>
                            <?php $this->session->flashdata('info_terms', false); ?>
                        </div>
                        <?php } ?>
                        
                        <div class="col-md-12 text-right mb-3">
                            <a href="<?= base_url('admin/settings_det/manage')?>" class="btn btn-default">Back</a>
                            <a href="<?= site_url('admin/settings_det/add_terms/' . $data->id) ?>" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Terms
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" class="chk-all"></th>
                                    <th>Terms</th>
                                    <th>Agreement Template</th>
                                    <th class="text-right">Status</th>
                                    <th width="300" class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($terms) && $terms): ?>
                                    <?php $no = 1; foreach($terms as $term): ?>
                                    <tr>
                                        <td><input type="checkbox" form="frm_copy" class="chk-row" name="ids[]" value="<?= $term->id ?>"></td>
                                        <td><?= $term->name ?></td>
                                        <td>
                                            <a href="<?= base_url($term->agreement_template) ?>" class="lightbox <?= $term->agreement_template ? '' : 'hidden' ?>"><?= file_name($term->agreement_template) ?></a>
                                        </td>
                                        <td class="text-right">
                                            <span class="label label-<?= $term->is_active ? 'success' : 'danger' ?>">
                                                <?= $term->is_active ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="<?= site_url('admin/settings_det/periods/' . $fisacal_year_id .'/'.$term->id) ?>" class="btn btn-success btn-xs">
                                                Period
                                            </a>
                                            <a href="<?= site_url('admin/settings_det/edit_term/' . $fisacal_year_id .'/'.$term->id) ?>" class="btn btn-primary btn-xs">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= site_url('admin/settings_det/delete_term/' . $term->id) ?>" class="btn btn-danger btn-xs confirm-del" title="Delete">
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