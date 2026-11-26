<?php
// Simple PDF template for approved grantee list
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Approved Grantees</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; color: #222; }
        h1 { font-size: 16pt; margin-bottom: 6px; }
        .meta { margin: 8px 0 12px 0; }
        .meta div { margin-bottom: 4px; }
        ol { margin-left: 18px; }
        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; }
        .header-left { display:flex; gap:10px; align-items:center; }
        .header-table { border-collapse: collapse; }
        .header-table td { vertical-align: middle; padding: 0; }
        .icon-cell { width:28px; padding-right:8px; }
        .text-cell { padding-left:8px; }
        .report-icon { width:28px; height:28px; border-radius:6px; display:flex; align-items:center; justify-content:center; font-weight:bold; color:#013473; overflow:hidden; }
        .report-icon img { width:14px; height:14px; object-fit:contain; display:block; }
        .header-left .header-text { display:flex; flex-direction:column; justify-content:center; }
        .report-meta { font-size:10pt; color:#555; }
        .status-badge { background:#d4f6dc; color:#155724; padding:5px; border-radius:4px; font-weight:bold; margin-top: 10px; width: 70px; }
        .main-title { font-size:15pt; font-weight:bold; margin:8px 0 6px 0; }
        .name-label { font-weight:600; }
        .list-table { width:100%;  margin-bottom: 12px; font-size: 10pt; }
        .list-table th, .list-table td { text-align:left; vertical-align: top; }
        .list-table th {  font-weight:700; }
        .table-itinerary {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        .table-itinerary th,
        .table-itinerary td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
            text-align: left;
        }

        .table-itinerary th {
            font-weight: bold;
            background: #f2f2f2;
        }
        .sign-table td { vertical-align: top; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table" role="presentation" aria-hidden="true">
            <tr>
                <td class="icon-cell">
                    <div class="report-icon">
                        <img style="width: 150px; margin-right: 10px;" src="<?php echo base_url('img/logo_aminef_color.jpg'); ?>" alt="Success" />
                    </div>
                </td>
                <td class="text-cell">
                    <div style="font-weight:bold; font-size: 14px;">Travel Arrangement Approvals</div>
                    <div class="report-meta">Report &bull; Printed on <?php echo date('F j, Y H:i:s'); ?></div>
                </td>
            </tr>
        </table>
        <div class="status-badge"><?php echo htmlspecialchars($status_label ?? 'Approved', ENT_QUOTES, 'UTF-8'); ?></div>
    </div>

    <div class="main-title">
        <?php
            $parts = [];
            if (!empty($period_label)) $parts[] = $period_label;
            if (!empty($program_name)) $parts[] = $program_name . ' (' . $fiscal_year .')';
            if (!empty($flight_type)) $parts[] = $flight_type;
            if (!empty($category_name)) $parts[] = $category_name;
            echo htmlspecialchars(strtoupper(trim(implode(' ', $parts))), ENT_QUOTES, 'UTF-8');
        ?>
    </div>

    <table class="list-table" role="presentation" aria-hidden="true">
        <thead>
            <tr>
                <th colspan="2">Name :</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($grantees as $g): ?>
                <tr>
                    <td width="10"><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($g['name'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="list-table" role="presentation" aria-hidden="true">
        <tr>
            <td class="label" width="100">Program</td>
            <td>: <?php echo htmlspecialchars($program_name ?? '-', ENT_QUOTES, 'UTF-8'); ?> <?= $fiscal_year ? ' (' . $fiscal_year .')' : '' ?></td>
        </tr>
        <tr>
            <td class="label">Activity</td>
            <td>: <?php echo htmlspecialchars($category_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td class="label">Memo</td>
            <td>: <?php echo htmlspecialchars($memo ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td class="label">Travel Agent</td>
            <td>: <?php echo htmlspecialchars($travel_agents ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </table>
    <br>
    <table class="list-table table-itinerary" role="presentation" aria-hidden="true">
        <tr>
            <th>Name</th>
            <th>Itinerary</th>
            <th>Price</th>
        </tr>
        <?php foreach ($grantees as $g_index => $g){ ?>
            <?php foreach ($g['selected_flights'] as $f){ ?>
                <tr>
                    <td><?php echo htmlspecialchars($g['name'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <?php
                            $ci = &get_instance();
                            $desc_html = isset($f['description']) ? $f['description'] : '';
                            $desc_html = html_entity_decode($desc_html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            $desc_html = $ci->security->xss_clean($desc_html);
                            echo $desc_html;
                        ?>
                    </td>
                    <td style="text-align:left; vertical-align:top;">
                        <table style="width:100%; border-collapse:collapse;">
                            <tr>
                                <td style="border:none; border-bottom:0.5px dashed #999; padding:0 0 8px 0;">Proposed : <?php echo format_money((float)($f['price'] ?? 0), $f['currency'] ?? 'USD'); ?></td>
                            </tr>
                            <tr>
                                <td style="border:none; padding:8px 0 0 0;"><strong>Final</strong> : <?php echo format_money((float)($g['final_rate'] ?? 0), $f['currency'] ?? 'USD'); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <!-- <tr>
                <td class="label">
                    <div class="report-meta" style="margin-top:6px;"><?php echo htmlspecialchars($g['name'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php
                        $ci = &get_instance();
                        $desc_html = isset($f['description']) ? $f['description'] : '';
                        $desc_html = html_entity_decode($desc_html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                        $desc_html = $ci->security->xss_clean($desc_html);
                        echo $desc_html;
                    ?>
                    <strong><?php echo format_money((float)($f['price'] ?? 0), $f['currency'] ?? 'USD'); ?></strong>
                </td>
            </tr>
            <tr>
                <td>
                    <?php 
                        for ($i = 0; $i < 50; $i++){ 
                            echo '='; 
                        } 
                    ?>
                </td>
            </tr> -->
            <?php } ?>
        <?php } ?>
    </table>
    
    <br>
    <table class="list-table" role="presentation" aria-hidden="true">
        <tr>
            <tr>
                <td class="label" width="100">Final Status</td>
                <td>: <?php echo htmlspecialchars($status_label ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        </tr>
    </table>
    <br>
    <table class="sign-table">
        <tr>
            <td colspan="2">
                Requested by
            </td>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($requested_by_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
            <td>&nbsp; &nbsp; &nbsp; <?php echo !empty($requested_at) ? date('F j, Y H:i:s', strtotime($requested_at)) : '-'; ?></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                Approved by
            </td>
        </tr>
        <tr>
            <td ><?php echo htmlspecialchars($approved_by_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
            <td>&nbsp; &nbsp; &nbsp; <?php echo !empty($approved_at) ? date('F j, Y H:i:s', strtotime($approved_at)) : '-'; ?></td>
        </tr>
    </table>
    

</body>
</html>
