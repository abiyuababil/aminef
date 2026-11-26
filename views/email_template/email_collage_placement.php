<br>
Dear <?= $name ?>,<br><br>

This is an automatically generated message to acknowledge that we have send college placement information.<br><br>


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
        <td width="13%">University</td>
        <td width="2%">:</td>
        <td><?= $university ?></td>
    </tr>
    <tr>
        <td width="13%">Department</td>
        <td width="2%">:</td>
        <td><?= $department ?></td>
    </tr>
    <tr>
        <td width="13%">Estimated Cost</td>
        <td width="2%">:</td>
        <td><?= $estimate_cost ?></td>
    </tr>
    <tr>
        <td width="13%">Time of Arrival (TOA)</td>
        <td width="2%">:</td>
        <td><?= date('d M Y', strtotime($toa)) ?></td>
    </tr>
    <tr>
        <td width="13%">Note</td>
        <td width="2%">:</td>
        <td><?= $note ? $note : '-' ?></td>
    </tr>
</table>
<br>

If you have any questions or concerns please feel free to contact us.<br>