<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Pengajuan Sekolah Penerima Manfaat Program Fulbright ETA</h1>
        <?php if ($this->session->flashdata('success_submitted')) : ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success_submitted') ?></div>
        <?php endif; ?>
        <?php $this->session->unset_userdata('success_submitted'); ?>
    </div>
</div>
<?php if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success'); ?>
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit']) $selected = 'selected';
                        ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="q" value="<?php echo $q ?>" placeholder="" onchange="document.forms.frm_manage.submit()">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th <?php echo sorting_attribute('title', $sort_by, $sort) ?>>Program</th>
                            <th <?php echo sorting_attribute('start_date', $sort_by, $sort) ?>>Tanggal Mulai</th>
                            <th <?php echo sorting_attribute('end_date', $sort_by, $sort) ?>>Tanggal Selesai</th>
                            <th>Status</th>
                            <th width="300" class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                $sof_name = $row->field_of_study_name ? strtolower($row->field_of_study_name) : '';
                        ?>
                                <tr>
                                    <td><?php echo $no ?></td>
                                    <td><?php echo $row->title ?></td>
                                    <td><?php echo $row->start_date ? date('F j, Y H:i', strtotime($row->start_date)) : '' ?></td>
                                    <td><?php echo $row->end_date ? date('F j, Y H:i', strtotime($row->end_date)) : '' ?></td>
                                    <td>
                                        <?php
                                        echo get_eta_application_status($row->id, $this->session->userdata('eta_user_id'));
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php if (is_eta_submitted($row->id, $this->session->userdata('eta_user_id'))) { ?>
                                            <?php 
                                                $submission_detail = get_eta_submission_detail($row->id, $this->session->userdata('eta_user_id'));
                                            ?>
                                            <a href="<?= base_url('eta/application/view/' . $submission_detail->id) ?>" class="btn btn-primary">
                                                <i class="fa fa-eye"></i> Lihat Pengajuan
                                            </a>
                                        <?php } else if (strtotime($row->end_date) < time()) { ?>
                                            <button class="btn btn-warning" disabled>
                                                <i class="fa fa-times-circle"></i> Pengajuan ditutup
                                            </button>
                                        <?php } else if (strtotime($row->start_date) > time()) { ?>
                                            <button class="btn btn-info" disabled>
                                                <i class="fa fa-clock-o"></i> Program belum dibuka
                                            </button>
                                        <?php } else { ?>
                                            <a href="<?= base_url('eta/application/form/' . $row->slug) ?>" class="btn btn-success">
                                                <i class="fa fa-send"></i> Kirim Pengajuan
                                            </a>
                                        <?php } ?>
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
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
            </div>
            <?php echo $paging['html'] ?>
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>
    </div>
</div>