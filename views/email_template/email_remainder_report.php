<br>
Hi <?= $grantee_name ?>!<br>
Your <?= $report_name ?> is due on <?= date('d M Y', strtotime($report_date['end_date'])) ?>. Login and follow this link to complete the report. <a href="<?php echo $url ?>" target="_blank">Link</a> will only be available between <?= date('d M Y', strtotime($report_date['start_date'])) ?> and <?= date('d M Y', strtotime($report_date['end_date'])) ?><br>
<br>
AMINEF Team