<div class="row">
    <div class="col-lg-12">
        <h1>Period</h1>
        <h3 class="page-header"><?= $fiscal_years->year ?> - <?= $terms->name ?></h3>
    </div>
</div>
<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>

<div class="row">
    <form id="form" role="form" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <?php if ($this->session->flashdata('info_periods')) { ?>
                        <div class="col-md-12">
                            <div class="alert alert-success"><i class="fa fa-info-circle"></i> <?= $this->session->flashdata('info_periods'); ?> </div>
                            <?php $this->session->flashdata('info_periods', false); ?>
                        </div>
                        <?php } ?>
                        
                        <div class="col-md-12 text-right mb-3">
                            <a href="<?= base_url('admin/settings_det/terms/' . $fisacal_year_id )?>" class="btn btn-default">Back</a>
                            <a href="<?= site_url('admin/settings_det/add_period/' . $fisacal_year_id . '/' . $terms->id) ?>" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Period
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" class="chk-all"></th>
                                    <th>Period</th>
                                    <th>Start Date & Time</th>
                                    <th>End Date & Time</th>
                                    <th class="text-right">Status</th>
                                    <th width="300" class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($periods) && $periods): ?>
                                    <?php $no = 1; foreach($periods as $period): ?>
                                    <tr>
                                        <td><input type="checkbox" form="frm_copy" class="chk-row" name="ids[]" value="<?= $period->id ?>"></td>
                                        <td><?= $period->cycle ?></td>
                                        <td><?= $period->start_date ? date('d M Y  H:i:s', strtotime($period->start_date)) : '' ?></td>
                                        <td><?= $period->end_date ? date('d M Y  H:i:s', strtotime($period->end_date)) : '' ?></td>
                                        <td class="text-right">
                                            <span class="label label-<?= $period->is_active ? 'success' : 'danger' ?>">
                                                <?= $period->is_active ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="<?= site_url('admin/settings_det/edit_period/' . $fisacal_year_id .'/'.$term_id . '/' .$period->id) ?>" class="btn btn-primary btn-xs">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= site_url('admin/settings_det/delete_period/' . $period->id) ?>" class="btn btn-danger btn-xs confirm-del" title="Delete">
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