
<div class="col-lg-12 text-center">
    <h2 style="color:#0089d1">Missing Document</h2>
    <h1 class="page-header"><?php echo $title ?></h1>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="frm_manage" method="GET">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="35" class="text-center">#</th>
                                    <th>Section</th>
                                    <th>Required Field or Error</th>
                                    <th>Status</th>
                                    <th width="200" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($missing_documents) {
                                    $no = 1;
                                    foreach ($missing_documents as $row) {
                                ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row->category_name . ' - ' . $row->step_name . ' - ' . $row->question_name ?></td>
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
                                            <?php if($row->status != APPROVE) { ?>
                                                <a href="<?= base_url('grantee/missing_document/detail/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                                    Detail
                                                </a>
                                            <?php } ?>
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
    </div>
</div>