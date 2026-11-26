Dear <?= $grantee_name ?>,<br><br>

AMINEF has prepared flight proposal options for your travel arrangement under the <strong><?= $program_name ?></strong> program for fiscal year <strong><?= $fiscal_year ?></strong>.<br><br>

Please review the details below:<br><br>

<table width="100%">
    <tr>
        <td width="24%">Program</td>
        <td width="2%">:</td>
        <td><?= $program_name ?></td>
    </tr>
    <tr>
        <td>Fiscal Year</td>
        <td>:</td>
        <td><?= $fiscal_year ?></td>
    </tr>
    <tr>
        <td>Travel Purpose</td>
        <td>:</td>
        <td><?= $travel_purposes ?></td>
    </tr>
    <tr>
        <td>Departure From</td>
        <td>:</td>
        <td><?= $departure_from ?></td>
    </tr>
    <tr>
        <td>Arrival To</td>
        <td>:</td>
        <td><?= $arrival_to ?></td>
    </tr>
    <tr>
        <td>Departure Date</td>
        <td>:</td>
        <td><?= $departure_date ?></td>
    </tr>
    <tr>
        <td>Roundtrip</td>
        <td>:</td>
        <td><?= $roundtrip ?></td>
    </tr>
    <tr>
        <td>Return Departure From</td>
        <td>:</td>
        <td><?= $return_departure_from ?></td>
    </tr>
    <tr>
        <td>Return Arrival</td>
        <td>:</td>
        <td><?= $return_arrival ?></td>
    </tr>
    <tr>
        <td>Return Departure Date</td>
        <td>:</td>
        <td><?= $return_departure_date ?></td>
    </tr>
    <tr>
        <td>Other Departure From</td>
        <td>:</td>
        <td><?= $other_departure_from ?></td>
    </tr>
    <tr>
        <td>Other Arrival</td>
        <td>:</td>
        <td><?= $other_arrival ?></td>
    </tr>
    <tr>
        <td>Other Departure Date</td>
        <td>:</td>
        <td><?= $other_departure_date ?></td>
    </tr>
    <tr>
        <td>Note</td>
        <td>:</td>
        <td><?= $note ?></td>
    </tr>
    <tr>
        <td>Notification Time</td>
        <td>:</td>
        <td><?= $submitted_at ?></td>
    </tr>
</table>

<br>
<strong>Flight Proposal Summary</strong><br>
<?= nl2br($flight_proposal_summary) ?>
<br><br>

You can review your travel arrangement here:<br>
<a href="<?= $application_link ?>" target="_blank"><?= $application_link ?></a><br><br>

Regards,<br>
AMINEF