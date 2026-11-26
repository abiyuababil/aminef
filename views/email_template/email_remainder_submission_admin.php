<br>
<?php if($from == 'admin'){ ?>
    Dear <?= $name ?>,<br>
    <br>
    This is an automatically generated message to state that we have changed your status.<br>
    <br>

    <table>
        <tr>
            <td>Grant Name</td>
            <td>:</td>
            <td><?= $grant_name ?></td>
        </tr>
        <tr>
            <td>Fiscal Year</td>
            <td>:</td>
            <td><?= $fiscal_year ?></td>
        </tr>
        <tr>
            <td>Grantee Name</td>
            <td>:</td>
            <td><?= $name ?></td>
        </tr>
        <tr>
            <td>Update At</td>
            <td>:</td>
            <td><?= date('d M Y H:i')?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td><?= $status ?></td>
        </tr>
    </table>
    <br>
    <br>
    If you have any question or concerns please feel free to contact us.<br>
    For more detailed information, click the following link. <a href="<?php echo $url ?>" target="_blank">Click Here</a>
    <br>
<?php }else{ ?>
    Dear Admin,<br>

    <table>
        <tr>
            <td>Grant Name</td>
            <td>:</td>
            <td><?= $grant_name ?></td>
        </tr>
        <tr>
            <td>Fiscal Year</td>
            <td>:</td>
            <td><?= $fiscal_year ?></td>
        </tr>
        <tr>
            <td>Grantee Name</td>
            <td>:</td>
            <td><?= $name ?></td>
        </tr>
        <tr>
            <td>Documents</td>
            <td>:</td>
            <td><?= $section_name ?></td>
        </tr>
        <tr>
            <td>Update At</td>
            <td>:</td>
            <td><?= date('d M Y H:i')?></td>
        </tr>
    </table>

    has made data changes.
    For more detailed information, click the following link. <a href="<?php echo $url ?>" target="_blank">Click Here</a>
<?php } ?>