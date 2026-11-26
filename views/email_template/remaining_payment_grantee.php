Dear <?= $name ?>,<br><br>

<?= $information ?><br><br>

<table width="100%">
    <tr>
        <td width="13%">Grant Name</td>
        <td width="2%">:</td>
        <td><?= $grant ?></td>
    </tr>
    <tr>
        <td>Grantee Name</td>
        <td>:</td>
        <td><?= $grantee ?></td>
    </tr>
    <tr>
        <td>Disbursement</td>
        <td>:</td>
        <td><?= $category ?></td>
    </tr>
    <tr>
        <td>Total Nominal</td>
        <td>:</td>
        <td>USD <?= number_format($total_nominal) ?></td>
    </tr>
    <tr>
        <td>Released Date</td>
        <td>:</td>
        <td><?= date("F j, Y", strtotime($release_date)) ?></td>
    </tr>
    <tr>
        <td>Status</td>
        <td>:</td>
        <td><?= $status ?></td>
    </tr>
</table>
<br>
<br>
<?= $info ?>
<br>
