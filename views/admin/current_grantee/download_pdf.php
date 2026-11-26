<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pdf Data Current Grantee</title>
    

    <link href="<?php echo base_url() ?>css/bootstrap.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-4-utilities.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet">
    <style>
        td, th {
            padding:5px;
        }
    </style>
</head>
<body>   
    <table width="100%" class="mb-5">
        <tr>
            <td><h4 style="font-weight:bold">Current Grantee</h4></td>
            <td class="text-right"><img width=280 src="img/logo_pdf.png" alt=""></td>
        </tr>
    </table>
    <table class="table table-bordered" style="background-color: #fff">
        <tr>
            <td style="background-color:#ebebeb">Name</td>
            <td style="background-color:#ebebeb">Grant</td>
            <td style="background-color:#ebebeb">Fiscal Year</td>
            <td style="background-color:#ebebeb">Status</td>
            <td style="background-color:#ebebeb">Permit Papers Status</td>
            <td style="background-color:#ebebeb">Report Status</td>
            <td style="background-color:#ebebeb">Payment Status</td>
            <td style="background-color:#ebebeb">Completion Status</td>
        </tr>
        <?php foreach ($data as $key => $value) : ?>
        <tr>
            <td><?= $value->fullname; ?></td>
            <td><?= $value->program_name  ?></td>
            <td><?= $value->fiscal_year ?></td>
            <td><?= $value->status_name ?></td>
            <td><?= $value->permit_papers_status_name ? $value->permit_papers_status_name : '-' ?></td>
            <td><?= $value->report_status_name ? $value->report_status_name : '-' ?></td>
            <td><?= $value->payment[0] ? $value->payment[0]['payment_name'] : '-' ?> <span class="text-info" style="float:right"><?= $value->payment[0]['status_name'] ?></span></td>
            <td><?= $value->completion_status_name ? $value->completion_status_name : '-' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <table class="table table-bordered" width="100%" style="background-color: #fff;margin-top:-20px;">
        <?php
            if ($grantee_payment) {
                foreach ($grantee_payment as $i => $row) { ?>
                        <tr>
                            <?php 
                                $total = [];
                                foreach ($row['items'] as $key => $item) { 
                                array_push($total, $item['nominal']);
                                }
                            ?>
                            <?php 
                                $prefix = 'th';
                                if(($i+1) == 1){
                                    $prefix = 'st';
                                }else if(($i+1) == 2){
                                    $prefix = 'nd';
                                }else if(($i+1) == 3){
                                    $prefix = 'rd';
                                }
                            ?>
                            <th style="background-color:#ebebeb"><?= $row['method'] ?></th>
                            <th style="background-color:#ebebeb"><?= $row['payment_name'] ?></th>
                            <th class="text-right" style="background-color:#ebebeb"><b>$<?= number_format(array_sum($total)) ?></b></th>
                        </tr>
                        <tr>
                            <td width="15%"></td>
                            <td width="60%" colspan=2><?= date('d-M-Y', strtotime($row['from_date'])) ?> - <?= date('d-M-Y', strtotime($row['to_date'])) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan=2>
                                <?php if($row['payment_status'] == 1) { ?>
                                    To be released: <?= !empty($row['toberelease_date']) ? date('d-M-Y', strtotime($row['toberelease_date'])) : $row['release_note'] ?>
                                <?php } else { ?>
                                    Note : Realesed
                                <?php } ?>
                            </td>
                        </tr>
                        <?php if($row['items']) { ?>
                            <?php foreach ($row['items'] as $key => $item) { ?>
                                <tr>
                                    <td></td>
                                    <td><?= $item['payment_item'] ?></td>
                                    <td class="text-right">$<?= number_format($item['nominal']) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
        <?php } } ?>
    </table>
    

    <script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
</body>

</html>