<br>
Dear Admin
<br>
<br>
<table>
    <tr>
        <td>Grant Name</td>
        <td>: <?= $grant_name ?></td>
    </tr>
    <tr>
        <td>Fiscal Year</td>
        <td>: <?= $fiscal_year ?></td>
    </tr>
    <tr>
        <td>Grantee Name</td>
        <td>: <?= $name ?></td>
    </tr>
    <tr>
        <td>Category</td>
        <td>: <?= $section_name ?></td>
    </tr>
    <tr>
        <td>Update At</td>
        <td>: <?= date('d M Y H:i') ?></td>
    </tr>
    <tr>
        <td>Status</td>
        <td>: <?= $status ?></td>
    </tr>
</table>
<br>
has made data changes.<br>
For more detailed information, click the following link. Click Here

<a href="<?php echo $url ?>" target="_blank"><?php echo $url ?></a><br>
<br>