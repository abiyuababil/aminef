<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$pid = $this->input->get('pid');
if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- Toggle for using grant page for submission period -->
                <div class="row">
                    <?php if ($this->session->flashdata('info')) { ?>
                    <div class="col-md-12">
                        <div class="alert alert-success"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('info'); ?> </div>
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
                            <a href="<?php echo site_url('admin/user_grantee_grant/sort_period_category/' . $this->User_grantee_grant_model->id . '/' . $period_id); ?>" class="btn btn-info btn-sm">
                                <i class="fa fa-arrows"></i> SORTING
                            </a>
                            <?php
                                $url = site_url('grantee/preview/data/' . $grant_pages[0]->id . '?grants_id=' . $this->User_grantee_grant_model->id . '&period_id=' . $period_id);
                            ?>
                            <a href="<?php echo $url ?>" class="btn btn-warning btn-sm" target="_blank">
                                <i class="fa fa-eye"></i> PREVIEW
                            </a>
                        </div>
                    </div>
                     <div class="col-md-6 text-right">
                         <a href="<?= site_url('admin/user_grantee_grant/sorting_pdf_documents/' . $grant_id . '/' . $period_id) ?>" class="btn btn-default btn-sm">
                            Sorting Documents (PDF)
                         </a>
                         <a href="<?= site_url('admin/user_grantee_grant/add_period_category/' . $grant_id . '/' . $period_id) ?>" class="btn btn-success btn-sm">
                             <i class="fa fa-plus"></i> Add New Grant Page
                         </a>
                     </div>
                </div>
                <!-- Grant Pages List -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="30"><input type="checkbox" class="chk-all"></th>
                                <th width="35" class="text-center">#</th>
                                <th>Category Name</th>
                                <th class="text-right">Status</th>
                                <th width="300" class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($grant_pages) && $grant_pages): ?>
                                <?php $no = 1; foreach($grant_pages as $page): ?>
                                <tr>
                                    <td><input type="checkbox" form="frm_copy" class="chk-row" name="ids[]" value="<?php echo $page->id ?>"></td>
                                    <td><?= $no ?></td>
                                    <td><?= $page->category_name ?></td>
                                    <td class="text-right">
                                        <span class="label label-<?= $page->is_active ? 'success' : 'danger' ?>">
                                            <?= $page->is_active ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="<?= site_url('admin/user_grantee_grant/step_period/' . $grant_id . '/' . $page->id . '/' . $period_id) ?>" class="btn btn-info btn-xs" title="Add Content (Steps)" style="background:#4da6ff;">
                                            <i class="fa fa-cog"></i> Edit Content
                                        </a>
                                        <a href="<?= site_url('admin/user_grantee_grant/edit_period_category/' . $grant_id . '/' . $page->id . '/' . $period_id) ?>" class="btn btn-primary btn-xs" title="Edit Grant Page">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= site_url('admin/user_grantee_grant/delete_period_category/' . $grant_id . '/' . $page->id . '/' . $period_id) ?>" class="btn btn-danger btn-xs confirm-del" title="Delete">
                                            <i class="fa fa-times-circle"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php $no++; endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No grant pages found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_select_grant">
    <form id="frm_copy" method="GET"></form>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <input name="user_id" type="hidden" value="<?= $this->User_model->id; ?>"/>
                        <input name="country_id" type="hidden" value="<?= $country_id; ?>"/>
                        <input name="program_id" type="hidden" id="ex_program_id"/>

                        <label>Select Grant</label>
                        <select name="copy_grant_id" class="form-control select2" id="copy_grant_id" form="frm_copy">
                            <option value="">--Choose one--</option>
                            <?php foreach ($grants as $key => $prgm) { ?>
                                <option value='<?= $prgm->id ?>'><?= $prgm->name ?> <?= get_active_country(true) == AMERICAN_DATABASE ? '- '.$prgm->year : '' ?></option>";
                            <?php } ?>
                        </select>
                        <input type="hidden" name="action" form="frm_copy" value="copy_grant">
                    </div>
                    <div class="form-group col-sm-12 select-period-section hide">
                        <label>Select Period</label>
                        <select name="period_id" class="form-control select2" id="period_id" form="frm_copy">
                            <option value="">-- Select Period --</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" form="frm_copy" class="btn btn-primary">Copy</button>
            </div>
        </div>
    </div>
</div>
