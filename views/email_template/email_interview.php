<br>
Dear <?= $name ?>,<br><br>

This is an automatically generated message to acknowledge that we have send interview schedule information<br><br>


<table width="100%">
    <tr>
        <td width="13%">Grant Name</td>
        <td width="2%">:</td>
        <td><?= $grant ?></td>
    </tr>
    <tr>
        <td width="13%">Grantee Name</td>
        <td width="2%">:</td>
        <td><?= $name ?></td>
    </tr>
    <tr>
        <td width="13%">Fiscal Year</td>
        <td width="2%">:</td>
        <td><?= $fiscal_year ?></td>
    </tr>
    <tr>
        <td width="13%">Date</td>
        <td width="2%">:</td>
        <td><?= date('d M Y', strtotime($date)) ?></td>
    </tr>
    <tr>
        <td width="13%">Time</td>
        <td width="2%">:</td>
        <td><?= date('H:i', strtotime($date)) ?></td>
    </tr>
    <tr>
        <td width="13%">Location</td>
        <td width="2%">:</td>
        <td><?= $location ?></td>
    </tr>
    <tr>
        <td width="13%">Note</td>
        <td width="2%">:</td>
        <td><?= $note    ?></td>
    </tr>
</table>
<br>

If you have any questions or concerns please feel free to contact us.<br>
For more detailed information, click the following link <a href="<?php echo $url ?>" target="_blank">Click Here</a><br>. 