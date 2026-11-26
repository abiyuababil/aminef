<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>favicon.png">

    <title><?php echo isset($page_title) ? $page_title : '' ?> - AMINEF</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url() ?>css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url() ?>css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Aminef CSS -->
    <link href="<?php echo base_url() ?>css/aminef.css?v=7" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/aminef_bg_white.css?v=8" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/select2.min.css?v=<?=VERSION?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url() ?>css/select2-bootstrap-theme.min.css?v=<?=VERSION?>"/>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/css/intlTelInput.css">
    
    <script src="<?php echo base_url() ?>js/sweet-alert.min.js?v=<?=VERSION?>"></script>

    <!-- google tag -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-46HSXP847S"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-46HSXP847S')
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .intl-tel-input {
            display:block !important;
        }
        .rec-container {
            /* max-width: 760px; */
            margin: 40px auto;
            /* background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid #e1e8ed; */
        }
        .rec-header {
            color: #040404;
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

        .logo3070 img {
            margin-top:-15px; 
            width:auto; 
            height:80px;
        }

        /* Responsive Improvements for Mobile */
        @media (max-width: 768px) {
            #page-wrapper {
                padding: 10px !important;
            }
            .container {
                padding-left: 5px;
                padding-right: 5px;
            }
            .header-upside ul {
                display: flex;
                flex-wrap: nowrap;
                justify-content: center;
                align-items: center;
                padding-left: 0;
            }
            .header-upside ul li {
                margin: 5px 10px !important;
            }
            .rec-container {
                margin: 15px auto !important;
                border-radius: 6px;
            }
            .rec-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 16px 20px;
            }
            .rec-header h2 {
                font-size: 18px;
            }
            .rec-body {
                padding: 16px 20px;
            }
            .info-card {
                padding: 12px 15px;
            }
            .info-row {
                flex-direction: column;
                margin-bottom: 10px;
            }
            .info-label {
                width: 100% !important;
                font-size: 12px;
                margin-bottom: 2px;
            }
            .info-val {
                width: 100%;
                font-size: 13px;
                word-break: break-word;
            }
            .upload-section {
                padding: 16px 12px;
            }
            #recommendation_file {
                width: 100% !important;
                max-width: 100% !important;
            }
            .btn-submit-rec {
                width: 100%;
                padding: 12px 16px;
            }

            .logo3070 img {
                margin-top:-15px; 
                width:auto; 
                height:40px;
            }
        }
    </style>

</head>

<body>

    <div id="wrapper" class="directory" style="background:#0089d1">

      <div class="<?= isset($hide_image) ? 'header-wrapper-alumny-application' : 'header-wrapper-alumny' ?>">
        <div class="header-container-upside">
            <div class="header-upside">
                <ul>
                    <li class="logoAminef">
                        <a href="https://www.aminef.or.id/"><img src="<?php echo base_url('img/logo-aminef-color.png') ?>"></a>
                    </li>
                    <li class="logoFullbright" style="margin-right: 2vw;">
                        <img src="<?php echo base_url('img/logo-fulbright-color.png') ?>">
                    </li>
                    <?php if(!isset($hide_image)){ ?>
                    <li class="logo3070">
                        <img src="<?php echo base_url('img/logo-fulbright-3070-new.png') ?>">
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
      </div>

        <div id="page-wrapper" style="margin-left:0;">
            
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
                        <?php $this->session->unset_userdata('success');?>
                        <?php $this->session->unset_userdata('error');?>

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
                                <div class="info-label">Program Year:</div>
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
                            <!-- <div class="info-row">
                                <div class="info-label">Reference Token:</div>
                                <div class="info-val"><code><?php //htmlspecialchars($request->token) ?></code></div>
                            </div> -->
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
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url() ?>js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url() ?>js/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url() ?>js/raphael-min.js"></script>
    <script src="<?php echo base_url() ?>js/morris.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url() ?>js/sb-admin-2.js"></script>

    <!-- Aminef JavaScript -->
    <script src="<?php echo base_url() ?>js/aminef.js?v=3"></script>
    <script src="<?php echo base_url() ?>js/select2.min.js?v=<?=VERSION?>"></script>
    <script src="<?= base_url() ?>js/intlTelInput.min.js"></script>
    <?php echo isset($script) ? $script : '' ?>

</body>

</html>