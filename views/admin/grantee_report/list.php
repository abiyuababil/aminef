<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage Grantee Report
            <a href="<?= site_url('admin/grantee_report/add') ?>" class="btn btn-success btn-sm pull-right"
               title="Menambahkan data alumni baru">
                ADD NEW
            </a>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th class="text-left">Grants</th>
                            <th class="text-center">Mid Term Report</th>
                            <th class="text-center">Final Term Report</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td class="text-left"><?= $row->program_name ?></td>
                                    <td><?= $row->status_mid?></td>
                                    <td><?= $row->status_final?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url('admin/grantee_report/edit/' . $row->grant_id)?>" class="btn btn-warning btn-xs">Detail</a>
                                    </td>
                                </tr>
                                <?php
                                $no++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <div class="pull-left">
                Showing <?= $paging['start_row'] ?> to <?= $paging['end_row'] ?>
                of <?= number_format($paging['total_rows']) ?> entries
            </div>
            <!-- /.pagination info -->
            <?= $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?= $sort_by ?>">
            <input type="hidden" name="sort" value="<?= $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->