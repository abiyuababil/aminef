<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REQUEST FOR PAYMENT</title>
    

    <link href="<?php echo base_url() ?>css/bootstrap.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-4-utilities.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet">
    <style>
        td, th {
            padding:5px;
        }

        table{
            margin-left:50px;
            vertical-align: top;
        }
    </style>
</head>
<body style="background: url(css/images/aminef-heading-vector.png) no-repeat right top; ">   

<?php if ($data) { ?>
    <table width="100%" class="mb-5">
        <tr>
            <td><img width=350 src="img/logo_pdf.png" alt=""></td>
        </tr>
    </table>

    <div class="text-center" style="font-size:18px;font-weight:bold;margin-top:90px;">REQUEST FOR PAYMENT</div>
    <table width="100%">
        <tr>
            <td width ="15%" style="font-weight:bold;">FROM</td>
            <td width ="5%">:</td>
            <!-- <td><?= isset($staff_created) ? $staff_created->full_name : $this->session->userdata('full_name') ?>, Senior Program Officer</td> -->
            <td><?= $data['country_id'] == AMERICAN_DATABASE ? 'American Program' : 'Indonesian Program'  ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">THRU</td>
            <td>:</td>
            <!-- <td><?= $staff_executive->full_name ?>, Executive Director</td> -->
            <!-- <td>Alan Feinstein, Executive Director</td> -->
            <td>Finance Officer</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">TO</td>
            <td>:</td>
            <!-- <td><?= $staff_finance->full_name ?>, Finance Officer</td> -->
            <!-- <td>Anthony Hananto, Finance Officer</td> -->
            <td>Executive Director</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">DATE</td>
            <td>:</td>
            <td><?= $data['payment_date'] ? date('F j, Y', strtotime($data['payment_date'])) : '-' ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">SUBJECT</td>
            <td>:</td>
            <td><?= $data['description'] ?></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width ="35%" style="font-weight:bold;">FULBRIGHT GRANT</td>
            <td width ="5%">:</td>
            <td><?= $data['program_name'] ?> <?= $data['fiscal_year'] ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">TYPE OF PAYMENT</td>
            <td>:</td>
            <td style="font-weight:bold;">TRANSFER</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">PLEASE MAKE PAYMENT TO</td>
            <td>:</td>
            <td><?= $data['payment_to']?></td>
        </tr>
        <?php if($data['country_id'] == 1) { ?>
        <!-- <tr>
            <td style="font-weight:bold;">MEMO BUDGET NUMBER</td>
            <td>:</td>
            <td><?= $data['memo_budget_number'] != '' ? $data['memo_budget_number'] : '-' ?></td>
        </tr> -->
        <?php } ?>
        <tr>
            <td style="font-weight:bold;">NAME OF BANK</td>
            <td>:</td>
            <td><?= $data['bank_name'] ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ADDRESS OF BANK</td>
            <td>:</td>
            
            <td><?= $data['bank_address'] ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ACCOUNT NUMBER</td>
            <td>:</td>
            
            <td><?= $data['account_number'] ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ROUTING NUMBER</td>
            <td>:</td>
            
            <td><?= $data['routing_number'] ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">SWIFT CODE</td>
            <td>:</td>
            
            <td><?= $data['swift_code'] ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">NOTE BANK INFO</td>
            <td>:</td>
            
            <td><?= $data['note_bank'] ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">NOTE</td>
            <td>:</td>
            
            <td><?= $data['notes']?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">TOTAL AMOUNT</td>
            <td>:</td>
            
            <td><?= $data['total_nominal']?></td>
        </tr>
        <!-- <tr>
            <td style="font-weight:bold;">REF. MEMO</td>
            <td>:</td>
            <td>-</td>
        </tr> -->
    </table>
    <table width="30%" style="margin-top:30px;">
        <tr>
            <td style="font-weight:bold;">TO BE EXECUTED ASAP</td>
        </tr>
        <tr>
            <td class="text-center" style="font-weight:bold;"><br /><br />Thank you </td>
        </tr>
    </table>
<?php } ?>
    

    <script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
</body>

</html>