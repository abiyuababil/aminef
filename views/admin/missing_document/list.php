<div class="row">
    <div class="col-lg-12">
        <h1>Missing Document - <?= get_full_name($data_grantee) ?></h1> 
        <p><?= $data_grantee->grant_name ?></p>
        <hr />
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <!-- <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>
                </div> -->
                <div class="pull-right">
                    <a href="<?= site_url('admin/missing_document/add/' . $data_grantee->id) ?>" class="btn btn-success btn-sm">Add New</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th>Section</th>
                            <th>Required Field or Error</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = 1;
                            foreach ($data as $row) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->category_name . ' - ' . $row->step_name . ' - ' . $row->question_name?></td>
                                    <td><?= $row->note ?></td>
                                    <td>
                                        <?php 
                                            if($row->status == REVISE) {
                                                echo "Revise";
                                            }else if($row->status == SUBMIT){
                                                echo "Submit";
                                            }else{
                                                echo "Approve";
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center" style="position:relative;">
                                        <a href="<?= base_url('admin/missing_document/edit/' . $data_grantee->id . '/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                            Detail
                                        </a>
                                        <a href="<?= base_url('admin/missing_document/delete/' . $data_grantee->id . '/' . $row->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete selected items ?') ">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <div class="pull-left">
                Showing <?= $paging['start_row'] ?> to <?= $paging['end_row'] ?> of <?= $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?= $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?= $sort_by ?>">
            <input type="hidden" name="sort" value="<?= $sort ?>">
        </form>

    </div>
</div>