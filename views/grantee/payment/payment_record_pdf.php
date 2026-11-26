<table class="table table-bordered" width="100%" style="background-color: #fff;margin-top:-20px;">
    <tr>
        <td style="background-color:#ebebeb">Entry Date</td>
        <td style="background-color:#ebebeb">Description</td>
        <td style="background-color:#ebebeb">Note from Admin</td>
        <td style="background-color:#ebebeb">Nominal (USD)</td>
    </tr>
    <?php
        if ($payment_record) {
            foreach ($payment_record as $i => $row) { ?>
            <tr>
                <td><?= date('d M Y', strtotime($row->payment_date)) ?></td>
                <td><?= $row->description ?></td>
                <td><?= $row->admin_note ?></td>
                <td><?= format_money($row->total_nominal, 'USD') ?></td>
            </tr>
    <?php } } ?>
</table>