<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $report->name ?> <?= get_full_name($this->Grantee_ent_model) ?></title>
    

    <link href="<?php echo base_url() ?>css/bootstrap.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-4-utilities.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet">
    <style>
        td, th {
            padding:5px;
            vertical-align: top;
        }

        .answer {
            height: 220px;
        }

        .table {
            border: 2px solid #ebebeb;
        }

        .table td {
            border-bottom: 2px solid #ebebeb;
            font-weight: bold;
        }
    </style>
</head>
<body>   
    <table width="100%" class="mb-5">
        <tr>
            <td><h4 style="font-weight:bold"><?= $report->name ?></h4></td>
            <td class="text-right"><img width=280 height=50 src="<?= base_url('img/logo_pdf.png')?>" alt=""></td>
        </tr>
    </table>

    <table width="100%" style="vertical-align: top;" class="mb-5">
        <tr>
            <td>
                <table class="table table-bordered" width="100%" style="background-color: #fff">
                    <tr>
                        <td width=10% style="background-color:#ebebeb">Name</td>
                        <td><?= get_full_name($this->Grantee_ent_model) ?></td>
                    </tr>
                    <tr>
                        <td style="background-color:#ebebeb">Grant</td>
                        <td><?= $report->grant_name?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br />
    <br />
    <br />
    
    <?php $no=1 ;foreach($custom_fields as $key => $row) { ?>
        <p><?= $no ?>. <?= $row->name ?></p>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
    <?php $no++; } ?>
    

    <script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
</body>

</html>