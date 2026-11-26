<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <span>Payment Schedule</span>
            <a href="<?= base_url() ?>grantee/payment/print/<?= $user->id ?>" target="_blank"
                class="btn btn-action-view"><i class="fa fa-download"></i> Download PDF</a>
        </h1>
    </div>
</div>
<!-- /.row -->

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" style="background-color: #fff">
                        <tr>
                            <td width=20% style="background-color:#ebebeb">Name</td>
                            <td><?= get_full_name($this->Grantee_ent_model) ?></td>
                        </tr>
                        <tr>
                            <td style="background-color:#ebebeb">Total Grant</td>
                            <td><?= !empty($grantee_grant->total_grant) ? 'USD ' . number_format($grantee_grant->total_grant) : '-' ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#ebebeb">Grant Period</td>
                            <td>

                                <?php
                                $start_date = !empty($grantee_grant->start_date) ? date_create($grantee_grant->start_date) : '';
                                $end_date = !empty($grantee_grant->end_date) ? date_create($grantee_grant->end_date) : '';
                                $date_diff = ($start_date && $end_date) ? date_diff($start_date, $end_date) : '';
                                $range = $date_diff ? floor($date_diff->days / 30) : '';

                                ?>
                                <?= !empty($grantee_grant->start_date) ? date('d M Y', strtotime($grantee_grant->start_date)) : '' ?>
                                -
                                <?= !empty($grantee_grant->end_date) ? date('d M Y', strtotime($grantee_grant->end_date)) : '' ?><br />
                                <?= !empty($date_diff) ? '(' . $range . ' Months)' : '' ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" style="background-color: #fff">

                        <tr>
                            <td width=20% style="background-color:#ebebeb">Grant</td>
                            <td><?= $grantee_grant->grant_name ?></td>
                        </tr>
                        <tr>
                            <td style="background-color:#ebebeb">Fiscal Year</td>
                            <td><?= !empty($grantee_grant->fiscal_year) ? $grantee_grant->fiscal_year : '-' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered" style="background-color: #fff">
                    <tr>
                        <td style="background-color:#ebebeb">Bank Name</td>
                        <td style="background-color:#ebebeb">Bank Address</td>
                        <td style="background-color:#ebebeb">Beneficiary Name</td>
                        <td style="background-color:#ebebeb">Account Number</td>
                        <td style="background-color:#ebebeb">Routing Number</td>
                        <td style="background-color:#ebebeb">Swift Code</td>
                    </tr>
                    <tr>
                        <td><?= $user->bank_name ?></td>
                        <td><?= $user->bank_address ?></td>
                        <td><?= $user->beneficiary_name ?></td>
                        <td><?= $user->account_number ?></td>
                        <td><?= $user->routing_number ?></td>
                        <td><?= $user->swift_code ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mt-5">
                <?php
                if ($grantee_payment) {
                    foreach ($grantee_payment as $keygp => $row) { ?>
                        <table class="table table-bordered" width="100%" style="background-color: #fff;margin-top:-20px;">
                            <thead>
                                <tr>
                                    <?php
                                    $total = [];
                                    foreach ($row['items'] as $key => $item) {
                                        array_push($total, $item['nominal']);
                                    }
                                    ?>
                                    <?php
                                    $prefix = 'th';
                                    if (($keygp + 1) == 1) {
                                        $prefix = 'st';
                                    } else if (($keygp + 1) == 2) {
                                        $prefix = 'nd';
                                    } else if (($keygp + 1) == 3) {
                                        $prefix = 'rd';
                                    }
                                    ?>
                                    <th><?= $row['method'] ?></th>
                                    <th><?= $keygp + 1 ?><?= $prefix ?> Disbursement</th>
                                    <th class="text-right"><b>$<?= number_format(array_sum($total)) ?></b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="15%"></td>
                                    <td width="60%" colspan=2><?= date('d M Y', strtotime($row['from_date'])) ?> - <?= date('d M Y', strtotime($row['to_date'])) ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan=2>
                                        <?php if ($row['payment_status'] != RELEASED_PAYMENT) { ?>
                                            To be released: <?= !empty($row['release_date']) ? date('d M Y', strtotime($row['release_date'])) : $row['release_note'] ?>
                                        <?php } else { ?>
                                            Note : <span class="badge badge-success">Released</span>
                                            <?php if ($row['proof'] != '') { ?>
                                                <a href="<?php echo base_url() ?><?php echo $row['proof'] ?>" target="_blank"><label
                                                        class="label label-primary" style="cursor:pointer;float:right;">View
                                                        Proof</label></a>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php if ($row['items']) { ?>
                                    <?php foreach ($row['items'] as $key => $item) { ?>
                                        <tr>
                                            <td></td>
                                            <td><?= $item['payment_item'] ?></td>
                                            <td class="text-right">$<?= number_format($item['nominal']) ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php }
                } ?>
            </div>
        </div>
    </div>