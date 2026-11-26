<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Letter of Reference Submitted - AMINEF</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>favicon.png">
    <link href="<?= base_url() ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f9;
            color: #333;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .rec-container {
            max-width: 680px;
            margin: 60px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid #e1e8ed;
            text-align: center;
        }
        .rec-header {
            background: linear-gradient(135deg, #1b4965, #20639b);
            color: #fff;
            padding: 24px 30px;
        }
        .rec-body {
            padding: 40px 30px;
        }
        .success-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #e8f5e9;
            color: #2e7d32;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin-bottom: 20px;
            border: 2px solid #c8e6c9;
        }
        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px 20px;
            margin: 24px auto 0;
            text-align: left;
            max-width: 520px;
            font-size: 13px;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-label {
            width: 140px;
            color: #64748b;
            font-weight: 600;
        }
        .info-val {
            color: #1e293b;
        }
        .rec-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 16px 30px;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="rec-container">
        <div class="rec-header">
            <h3 style="margin:0; font-size:18px; font-weight:600;">Letter of Reference Submitted (AMINEF)</h3>
        </div>

        <div class="rec-body">
            <div class="success-icon">
                <i class="fa fa-check"></i>
            </div>

            <h3 style="margin: 0 0 10px; font-size: 22px; font-weight: 600; color: #1e293b;">
                Letter of Reference Submitted
            </h3>
            <p style="color: #64748b; font-size: 14px; max-width: 480px; margin: 0 auto 20px; line-height: 1.5;">
                Thank you, <strong><?= htmlspecialchars($request->recommender_name ?: 'Recommender') ?></strong>. Your recommendation letter for <strong><?= htmlspecialchars($grantee_name) ?></strong> has been successfully received and attached to the application record.
            </p>

            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">Applicant:</div>
                    <div class="info-val"><strong><?= htmlspecialchars($grantee_name) ?></strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Program:</div>
                    <div class="info-val"><?= htmlspecialchars($grantee->grant_name ?? '-') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">File Submitted:</div>
                    <div class="info-val"><i class="fa fa-file-text-o text-primary"></i> <?= htmlspecialchars($request->file_name ?: 'Uploaded Document') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Submission Date:</div>
                    <div class="info-val"><?= $request->submitted_at ? date('d M Y, H:i', strtotime($request->submitted_at)) : date('d M Y') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-val"><span class="label label-success">Completed</span></div>
                </div>
            </div>
        </div>

        <!-- <div class="rec-footer">
            &copy; <?= date('Y') ?> American Indonesian Exchange Foundation (AMINEF). All rights reserved.
        </div> -->
    </div>
</div>

</body>
</html>
