<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre Departure Orientation</title>
    

    <link href="<?php echo base_url() ?>css/bootstrap.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-4-utilities.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet">
    <style>
        #participant {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        #participant td, #participant th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #participant tr:nth-child(even){background-color: #f2f2f2;}

        #participant tr:hover {background-color: #ddd;}

        #participant th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #ebebeb;
        color: #7da2bd;
        }

        #info td {
        padding: 8px;
        }
    </style>
</head>

<body>
 
    <table width="100%" class="mb-5">
        <tr>
            <td><h4 style="font-weight:bold">Pre Departure Orientation</h4></td>
            <td class="text-right"><img width=280 src="img/logo_pdf2.jpg" alt=""></td>
        </tr>
    </table>

    <table width="100%" style="vertical-align: top;" id="info">
        <tr>
            <td>
                <table class="table table-bordered" width="100%" style="background-color: #fff">
                    <?php if($data['pdo_format'] == 'online' || $data['pdo_format'] == 'hybrid') { ?>
                    <tr>
                        <td width=30% style="background-color:#ebebeb">Date</td>
                        <td><?= $data['date'] ?></td>
                    </tr>
                    <tr>
                        <td style="background-color:#ebebeb">Location</td>
                        <td><?= $data['location'] ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($data['pdo_format'] == 'offline' || $data['pdo_format'] == 'hybrid') { ?>
                    <tr>
                        <td width=30% style="background-color:#ebebeb">Date Offline</td>
                        <td><?= $data['date_offline'] ?></td>
                    </tr>
                    <tr>
                        <td style="background-color:#ebebeb">Location Offline</td>
                        <td><?= $data['location_offline'] ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td style="background-color:#ebebeb">PDO Format</td>
                        <td><?= ucfirst($data['pdo_format']) ?></td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="table table-bordered" width="100%" style="background-color: #fff">
                    <tr>
                        <td width=30% style="background-color:#ebebeb">Panelllist</td>
                        <?php $panellist_name = []; foreach($data['panellist_pdo_id'] as $panellist) { 
                            $p = get_row_db('am_panellist', ['id' => $panellist]);
                            if($p){ array_push($panellist_name, $p->name); }
                        }?>
                        <td><?= implode(", ", $panellist_name) ?></td>
                    </tr>
                    <tr>
                        <td style="background-color:#ebebeb">Fiscal Year</td>
                        <td><?= $data['fiscal_year'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php foreach ($participant as $key => $list) { ?>
        <div class="pull-left mb-2">
        <h4><?= $key ?></h4>
        Participants : <?= count($list) ?> 
        </div>
        <table id="participant" style="page-break-inside: avoid;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Grantee Program</th>
                    <th>University</th>
                    <th>Period</th>
                </tr>
            </thead>
            <?php $no=1; foreach ($list as $kl => $row) { ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= get_full_name($row,"ID") ?></td>
                    <td><?= $row->grant_name ?></td>
                    <td><?= $row->university_name ?></td>
                    <td><?= $row->fiscal_year ?></td>
                </tr>
            <?php $no++; } ?>
        </table>
        <hr class="mb-4">
    <?php } ?>


    <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap-datetimepicker.js?v=<?=VERSION?>"></script>

    
</body>