<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    

    <link href="<?php echo base_url() ?>css/bootstrap.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-4-utilities.css?v=<?=VERSION?>" rel="stylesheet">
    <!-- <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet"> -->
    <style>
        td, th {
            padding:5px;
        }
    </style>
</head>
<body>   
    <table width="100%" class="mb-5">
        <tr>
            <td><h4 style="font-weight:bold"><?= $title ?></h4></td>
            <td class="text-right"><img width=280 src="img/logo_pdf.png" alt=""></td>
        </tr>
    </table>

    <table width="100%" style="vertical-align: top;">
        <tr>
            <td>
                <table class="table table-bordered" width="100%" style="background-color: #fff">
                    <tr>
                        <td width=30% style="background-color:#ebebeb">Name</td>
                        <td><?= get_full_name($this->Grantee_ent_model) ?></td>
                    </tr>
                    <tr>
                        <td style="background-color:#ebebeb">Total Grant</td>
                        <td><?= !empty($budget_payment) ? ($budget_payment == 'Unlimited' ? 'Unlimited' : format_money($budget_payment, 'USD')) : '-' ?></td>
                    </tr>
                    <tr>
                        <td style="background-color:#ebebeb">Grant Period</td>
                        <td>
                            <?php 
                                $start_date = !empty($grantee_grant->start_date) ? date_create($grantee_grant->start_date) : '';
                                $end_date = !empty($grantee_grant->end_date) ? date_create($grantee_grant->end_date) : '';
                                $date_diff = ($start_date != '' && $end_date != '') ? date_diff($start_date, $end_date) : '';
                                $range = $date_diff ? floor($date_diff->days/30) : '';

                            ?>
                            <?= !empty($grantee_grant->start_date) ? date('d-M-Y', strtotime($grantee_grant->start_date)) : '' ?> - <?= !empty($grantee_grant->end_date) ? date('d-M-Y', strtotime($grantee_grant->end_date)) : '' ?><br/> <?= !empty($date_diff) ? '(' . $range . ' Months)' : '' ?>
                    
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="table table-bordered" width="100%" style="background-color: #fff">
                    <tr>
                        <td width=30% style="background-color:#ebebeb">Grant</td>
                        <td><?= $grantee_grant->grant_name?></td>
                    </tr>
                    <tr>
                        <td style="background-color:#ebebeb">Fiscal Year</td>
                        <td><?= !empty($grantee_grant->fiscal_year) ? $grantee_grant->fiscal_year : '-' ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
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

    <?php if($category == 'cost') : ?>
        <?php $this->load->view('grantee/payment/payment_cost_pdf') ?>
    <?php else : ?>
            <?php $this->load->view('grantee/payment/payment_record_pdf') ?>
    <?php endif; ?>

    <table width="100%">
        <tr style="border: 2px solid #ebebeb;">
            <td width="50%" style="font-weight:bold">Total Balance</td>
            <!-- <td width="50%" style="text-align:right;font-weight:bold;"><?= format_money($balance_payment, 'USD') ?></td> -->
            <td width="50%" style="text-align:right;font-weight:bold;"><?= $is_unlimited ? 'Unlimited' : format_money($balance_payment, 'USD') ?></td>
        </tr>
    </table>
    

    <script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
</body>

</html>