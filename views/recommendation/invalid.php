<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invalid Link - AMINEF</title>
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
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid #e1e8ed;
            text-align: center;
        }
        .rec-header {
            background: #64748b;
            color: #fff;
            padding: 20px 30px;
        }
        .rec-body {
            padding: 40px 30px;
        }
        .error-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #fef2f2;
            color: #dc2626;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 20px;
            border: 2px solid #fecaca;
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
            <h3 style="margin:0; font-size:16px; font-weight:600;">Letter of Reference Submitted (AMINEF)</h3>
        </div>

        <div class="rec-body">
            <div class="error-icon">
                <i class="fa fa-exclamation-triangle"></i>
            </div>

            <h3 style="margin: 0 0 10px; font-size: 20px; font-weight: 600; color: #1e293b;">
                Notice
            </h3>
            <p style="color: #64748b; font-size: 14px; max-width: 440px; margin: 0 auto 20px; line-height: 1.5;">
                <?= htmlspecialchars(isset($error_message) ? $error_message : 'The recommendation request link is invalid or has expired.') ?>
            </p>
            <p style="color: #94a3b8; font-size: 12px;">
                If you believe this is a mistake, please reach out to AMINEF Indonesia.
            </p>
        </div>

        <!-- <div class="rec-footer">
            &copy; <?= date('Y') ?> American Indonesian Exchange Foundation (AMINEF). All rights reserved.
        </div> -->
    </div>
</div>

</body>
</html>
