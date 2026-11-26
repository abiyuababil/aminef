<head>
<style>
    #executive {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    #executive td, #executive th {
    border: 1px solid #ddd;
    padding: 8px;
    }

    #executive tr:nth-child(even){background-color: #f2f2f2;}

    #executive tr:hover {background-color: #ddd;}

    #executive th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #ebebeb;
    color: #7da2bd;
    }
</style>
</head>

<body>
 
Executive Approval <?= format_date_time($data[0]->send_date) ?><br /><br />

<table id="executive">
    <thead>
        <tr>
            <th>Name</th>
            <th>Grant</th>
            <th>Fiscal Year</th>
            <th>Category</th>
            <?php if($country_id == 1) { ?>
            <th>Sub Category</th>
            <?php } ?>
            <th>Total Amount</th>
            <?php if($status == 'Approved') { ?>
            <th>Payment Status</th>
            <?php } ?>
            <th>Bank Name</th>
            <th>Beneficiary Name</th>
            <th>Payment Status</th>
            <th>To Be Released</th>
            <?php if($country_id == 1) { ?>
            <th>Memo Budget Number</th>
            <?php } ?>
            <th>Send Date</th>
        </tr>
    </thead>
    <?php foreach ($data as $key => $value) { 
        // echo '<pre>';print_r($data);die;
        $format = $country_id == 1 ? 'ID' : 'US';
    ?>
        <tbody>
            <tr>
                <td><?= $this->Grantee_ent_model->get_full_name($value, $format)?></td>
                <td><?= $value->program_name?></td>
                <td><?= $value->fiscal_year?></td>
                <td><?= $value->category?></td>
                <?php if($country_id == 1) { ?>
                <td><?= $value->sub_category?></td>
                <?php } ?>
                <td>$<?= number_format($value->total_payment)?></td>
                <?php if($status == 'Approved') { ?>
                <td><?= $value->status_name?></td>
                <?php } ?>
                <td><?= $value->bank_name ?></td>
                <td><?= $value->beneficiary_name ?></td>
                <td><?= $value->status_name ?></td>
                <td><?= $value->tobereleased == '-'  ?  "-" : format_date($value->tobereleased) ?></td>
                <?php if($country_id == 1) { ?>
                <td><?= $value->memo_budget_number?></td>
                <?php } ?>
                <td><?= format_date_time($value->send_date)?></td>
            </tr>
        </tbody>
    <?php } ?>
</table>
<br />


<script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
<script src="<?php echo base_url() ?>js/bootstrap-datetimepicker.js?v=<?=VERSION?>"></script>

    
</body>