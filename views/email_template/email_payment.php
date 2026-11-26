Dear <?= $name ?>,<br><br>

<?= $information ?><br><br>

<table width="100%">
    <tr>
        <td width="13%">Grantee Name</td>
        <td width="2%">:</td>
        <td><?= $grantee_name ?></td>
    </tr>
    <tr>
        <td width="13%">Grant Name</td>
        <td width="2%">:</td>
        <td><?= $grant ?></td>
    </tr>
    <tr>
        <td width="13%">Disbursement</td>
        <td width="2%">:</td>
        <td><?= $category ?></td>
    </tr>
    <tr>
        <td width="13%">Released Date</td>
        <td width="2%">:</td>
        <td><?= date('F j, Y', strtotime($toberelease)) ?></td>
    </tr>
    <tr>
        <td width="13%">Total Nominal</td>
        <td width="2%">:</td>
        <td>USD <?= number_format($total_nominal) ?></td>
    </tr>
    <tr>
        <td width="13%">Status </td>
        <td width="2%">:</td>
        <td><?= $status ?></td>
    </tr>
</table>
<br>
For more detailed information, click the following link. <a href="<?= $url ?>">Click Here</a> 