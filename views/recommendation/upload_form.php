<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($page_title) ? $page_title : 'Letter of Reference Submission - AMINEF' ?></title>
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
            max-width: 760px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid #e1e8ed;
        }
        .rec-header {
            background: linear-gradient(135deg, #1b4965, #20639b);
            color: #fff;
            padding: 24px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .rec-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: -0.3px;
        }
        .rec-header p {
            margin: 4px 0 0;
            font-size: 13px;
            opacity: 0.85;
        }
        .rec-body {
            padding: 30px;
        }
        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }
        .info-card-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-label {
            width: 140px;
            color: #64748b;
            font-weight: 600;
            flex-shrink: 0;
        }
        .info-val {
            color: #1e293b;
            font-weight: 500;
        }
        .upload-section {
            border: 2px dashed #cbd5e1;
            border-radius: 6px;
            padding: 24px;
            text-align: center;
            background: #fcfdfe;
            margin-bottom: 20px;
            transition: border-color 0.2s;
        }
        .upload-section:hover {
            border-color: #20639b;
        }
        .upload-icon {
            font-size: 38px;
            color: #20639b;
            margin-bottom: 10px;
        }
        .btn-submit-rec {
            background-color: #20639b;
            border-color: #1b4965;
            color: #fff;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 5px;
            transition: background 0.2s;
        }
        .btn-submit-rec:hover {
            background-color: #16466e;
            color: #fff;
        }
        .rec-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 16px 30px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="rec-container">
        <!-- Header -->
        <div class="rec-header">
            <div>
                <h2>Letter of Reference / Recommendation</h2>
                <p>American Indonesian Exchange Foundation (AMINEF)</p>
            </div>
            <div style="text-align: right;">
                <span class="label label-primary" style="font-size: 11px; padding: 4px 8px;">Official Portal</span>
            </div>
        </div>

        <!-- Body -->
        <div class="rec-body">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" style="font-size: 13px;">
                    <i class="fa fa-exclamation-circle"></i> <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success" style="font-size: 13px;">
                    <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <!-- Applicant Information -->
            <div class="info-card">
                <div class="info-card-title">Applicant &amp; Program Information</div>
                <div class="info-row">
                    <div class="info-label">Applicant Name:</div>
                    <div class="info-val"><strong><?= htmlspecialchars($grantee_name) ?></strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Program:</div>
                    <div class="info-val"><?= htmlspecialchars($grantee->grant_name ?? '-') ?></div>
                </div>
                <?php if (!empty($grantee->fiscal_year) || !empty($grantee->period_name)): ?>
                <div class="info-row">
                    <div class="info-label">Academic Year:</div>
                    <div class="info-val"><?= htmlspecialchars($grantee->fiscal_year ?? $grantee->period_name) ?></div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Recommender Context -->
            <div class="info-card">
                <div class="info-card-title">Recommender Profile</div>
                <div class="info-row">
                    <div class="info-label">Recommender:</div>
                    <div class="info-val"><strong><?= htmlspecialchars($request->recommender_name ?: '-') ?></strong></div>
                </div>
                <?php if (!empty($request->institution)): ?>
                <div class="info-row">
                    <div class="info-label">Institution:</div>
                    <div class="info-val"><?= htmlspecialchars($request->institution) ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($request->position)): ?>
                <div class="info-row">
                    <div class="info-label">Position / Title:</div>
                    <div class="info-val"><?= htmlspecialchars($request->position) ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($request->relationship)): ?>
                <div class="info-row">
                    <div class="info-label">Relationship:</div>
                    <div class="info-val"><?= htmlspecialchars($request->relationship) ?></div>
                </div>
                <?php endif; ?>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-val"><?= htmlspecialchars($request->recommender_email) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Reference Token:</div>
                    <div class="info-val"><code><?= htmlspecialchars($request->token) ?></code></div>
                </div>
            </div>

            <!-- Upload Form -->
            <form action="<?= base_url('recommendation/upload') ?>" method="post" enctype="multipart/form-data" id="form-upload-rec">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <div class="form-group">
                    <label style="font-weight: 600; font-size: 13px;">Upload Recommendation Letter Document <span class="text-danger">*</span></label>
                    <div class="upload-section">
                        <div class="upload-icon">
                            <i class="fa fa-cloud-upload"></i>
                        </div>
                        <p style="font-size: 13px; color: #475569; margin-bottom: 8px;">
                            Select a letter file from your device. Allowed formats: <strong>PDF, DOC, DOCX</strong> (Max: 10MB)
                        </p>
                        <input type="file" name="recommendation_file" id="recommendation_file" class="form-control" accept=".pdf,.doc,.docx" required style="max-width: 380px; margin: 0 auto; display: inline-block;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes" style="font-weight: 600; font-size: 13px;">Additional Notes / Comments <span style="font-weight: 400; color: #64748b;">(Optional)</span></label>
                    <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Provide any additional context or remarks regarding this recommendation..." style="font-size: 13px;"></textarea>
                </div>

                <div class="checkbox" style="margin-bottom: 22px;">
                    <label style="font-size: 12px; color: #475569;">
                        <input type="checkbox" name="agreement" required> I certify that this letter represents my sincere and professional assessment of the applicant.
                    </label>
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn btn-submit-rec" id="btn-submit-rec">
                        <i class="fa fa-paper-plane"></i> Submit Letter of Recommendation
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="rec-footer">
            &copy; <?= date('Y') ?> American Indonesian Exchange Foundation (AMINEF). All rights reserved.
        </div>
    </div>
</div>

<script src="<?= base_url() ?>js/jquery.min.js"></script>
<script src="<?= base_url() ?>js/bootstrap.min.js"></script>
<script>
    $('#form-upload-rec').on('submit', function() {
        var fileInput = document.getElementById('recommendation_file');
        if (!fileInput.files.length) {
            alert('Please select a recommendation file to upload.');
            return false;
        }
        $('#btn-submit-rec').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Uploading...');
    });
</script>
</body>
</html>
