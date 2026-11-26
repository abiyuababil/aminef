Dear <?= $name ?>,<br><br>

<table width="100%">
    <tr>
        <td width="13%">Grant Name</td>
        <td width="2%">:</td>
        <td><?= $grant ?></td>
    </tr>
    <tr>
        <td width="13%">Fiscal Year</td>
        <td width="2%">:</td>
        <td><?= $fiscal_year ?></td>
    </tr>
    <tr>
        <td width="13%">Grantee Name</td>
        <td width="2%">:</td>
        <td><?= $grantee_name ?></td>
    </tr>
    <tr>
        <td width="13%">Report Type</td>
        <td width="2%">:</td>
        <td><?= $report_type ?></td>
    </tr>
    <tr>
        <td width="13%">Update at</td>
        <td width="2%">:</td>
        <td><?= date('d M Y  H:i') ?></td>
    </tr>
</table>
<br>
has made data changes. For more detailed information, click the following link. <a href="<?= $url ?>">Click Here</a> 