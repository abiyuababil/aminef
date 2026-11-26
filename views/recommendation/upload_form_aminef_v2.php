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
        /* .intl-tel-input {
            display:block !important;
        } */


        /* Main Container */
        h2 {
            margin-top: 0 !important;
        }
        .container {
        max-width: 900px;
        /* margin: 32px auto; */
        padding: 0 20px;
        }

        .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        flex-wrap: wrap;
        }

        .page-title {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        }

        .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
        }

        .badge-portal {
        background-color: #0284c7;
        color: #ffffff;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
        }

        /* Info Cards */
        .card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .card-title {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #475569;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 8px;
        }

        .grid-info {
        display: grid;
        grid-template-columns: 180px 1fr;
        row-gap: 10px;
        font-size: 13px;
        }

        .info-label {
        color: #64748b;
        }

        .info-value {
        color: #0f172a;
        font-weight: 600;
        }

        /* Guidelines Section */
        .intro-paragraph {
        font-size: 13.5px;
        line-height: 1.6;
        color: #334155;
        margin-bottom: 16px;
        }

        .guidelines-box {
        background-color: #f8fafc;
        border-left: 4px solid #0284c7;
        padding: 16px 20px;
        margin-bottom: 20px;
        border-radius: 0 6px 6px 0;
        }

        .guidelines-title {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 10px;
        }

        .guidelines-list {
        padding-left: 20px;
        font-size: 13px;
        color: #334155;
        line-height: 1.6;
        }

        .guidelines-list ol {
        padding-left: 18px;
        margin-top: 6px;
        list-style-type: lower-alpha;
        }

        .guidelines-list li {
        margin-bottom: 6px;
        }

        /* Upload Area */
        .upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        padding: 28px;
        text-align: center;
        background-color: #fafbfc;
        margin-top: 14px;
        }

        .upload-icon {
        font-size: 32px;
        color: #0284c7;
        margin-bottom: 8px;
        }

        .upload-text {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 12px;
        }

        .file-input {
        display: inline-flex !important;
        font-size: 12px;
        color: #334155;
        }

        /* Signature & Certification */
        .certification-text {
        font-size: 13.5px;
        line-height: 1.6;
        color: #334155;
        margin-bottom: 14px;
        }

        .legal-clause {
        background-color: #f1f5f9;
        border-radius: 6px;
        padding: 14px 16px;
        font-size: 13px;
        font-weight: 500;
        color: #1e293b;
        font-style: italic;
        margin-bottom: 20px;
        }

        .form-group {
        margin-bottom: 16px;
        }

        .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
        }

        .form-input {
        width: 100%;
        max-width: 450px;
        padding: 8px 12px;
        font-size: 13px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        outline: none;
        background-color: #ffffff;
        }

        .form-input:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.15);
        }

        .warning-note {
        font-size: 12.5px;
        color: #b91c1c;
        margin-bottom: 8px;
        font-weight: 500;
        }

        .submit-prompt {
        font-size: 13px;
        color: #475569;
        margin-bottom: 24px;
        }

        /* Action Buttons */
        .action-row {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        }

        .btn {
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease-in-out;
        }

        .btn-submit {
        background-color: #1d5f8a;
        color: #ffffff;
        border: 1px solid #1d5f8a;
        }

        .btn-submit:hover {
        color: #ffffff;
        background-color: #164e72;
        border-color: #164e72;
        }

        .btn-preview {
        background-color: #0284c7;
        color: #ffffff;
        border: 1px solid #0284c7;
        }

        .btn-preview:hover {
        color: #ffffff;
        background-color: #0369a1;
        border-color: #0369a1;
        }

        .btn-save {
        background-color: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        }

        .btn-save:hover {
        background-color: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
        }

        /* Saved View Components */
        .session-saved-notice {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #047857;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 18px;
        }

        .session-saved-notice .icon-check {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        background-color: #d1fae5;
        color: #059669;
        border-radius: 50%;
        font-size: 13px;
        }

        .alert-banner {
        background-color: #fffbeb;
        border: 1px solid #fde68a;
        border-left: 4px solid #f59e0b;
        border-radius: 6px;
        padding: 16px;
        margin-bottom: 24px;
        }

        .alert-heading {
        font-size: 13px;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 4px;
        letter-spacing: 0.3px;
        }

        .alert-body {
        font-size: 13px;
        color: #78350f;
        line-height: 1.5;
        }

        /* Warning Banner: Expired State */
        .alert-expired {
        background-color: #fff1f2;
        border: 1px solid #fecdd3;
        border-left: 5px solid #e11d48;
        border-radius: 6px;
        padding: 18px 20px;
        margin-bottom: 24px;
        display: flex;
        gap: 16px;
        align-items: flex-start;
        }

        .alert-icon {
        font-size: 22px;
        line-height: 1;
        }

        .alert-content h4 {
        font-size: 15px;
        font-weight: 700;
        color: #9f1239;
        margin-bottom: 4px;
        margin-top: 0;
        }

        .alert-content p {
        font-size: 13px;
        line-height: 1.5;
        color: #881337;
        }


        /* Responsive Improvements for Mobile */
        @media (max-width: 768px) {
            #page-wrapper {
                padding: 10px !important;
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

            .logo3070 img {
                margin-top:-15px; 
                width:auto; 
                height:40px;
            }

            .btn {
            padding: 9px 12px;
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
            <main class="container">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Letter of Reference / Recommendation</h1>
                        <p class="page-subtitle">American Indonesian Exchange Foundation (AMINEF)</p>
                    </div>
                    <span class="badge-portal">Official Portal</span>
                </div>

                <!-- VIEW 1: Form View (Default) -->
                <div id="formView" style="display: <?= $request->status == 'draft' ? 'none' : 'block' ?>;">
                    <?php //if ($this->session->flashdata('error')): ?>
                        <!-- <div class="alert alert-danger" style="font-size: 13px;">
                            <i class="fa fa-exclamation-circle"></i> <?= $this->session->flashdata('error'); ?>
                        </div> -->
                    <?php //endif; ?>

                    <?php //if ($this->session->flashdata('success')): ?>
                        <!-- <div class="alert alert-success" style="font-size: 13px;">
                            <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success'); ?>
                        </div> -->
                    <?php //endif; ?>
                    <?php //$this->session->unset_userdata('success');?>
                    <?php //$this->session->unset_userdata('error');?>

                    <?php if($is_expired) : ?>
                    <!-- Alert / Banner Expired -->
                    <div class="alert-expired">
                        <div class="alert-icon">⚠️</div>
                        <div class="alert-content">
                            <h4>Submission Period Has Expired</h4>
                            <p>The deadline to submit a recommendation letter for this applicant has passed. The submission form has been closed, and no further entries or updates can be accepted at this stage.</p>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="card">
                        <p class="intro-paragraph">
                        Thank you for agreeing to provide a letter of recommendation for this <?= htmlspecialchars($grantee->grant_name ?? '-') ?>. You will be able to compose, review, and submit your recommendation online at your convenience. Once you submit your recommendation, you will be able to save a copy for your files.
                        </p>
                    </div>
                    <?php endif; ?>

                    <section class="card">
                        <h2 class="card-title">Applicant &amp; Program Information</h2>
                        <div class="grid-info">
                        <div class="info-label">Applicant Name:</div>
                        <div class="info-value"><?= htmlspecialchars($grantee_name) ?></div>

                        <div class="info-label">Program Name:</div>
                        <div class="info-value"><?= htmlspecialchars($grantee->grant_name ?? '-') ?></div>

                        <div class="info-label">Program Year:</div>
                        <div class="info-value"><?= htmlspecialchars($grantee->fiscal_year ?? $grantee->period_name) ?></div>

                        <div class="info-label">Submission Deadline:</div>
                        <div class="info-value" <?= $is_expired ? 'style="color:red !important;"' : '' ?>><?= htmlspecialchars($submission_end_date) ?> <?= $is_expired ? '(Closed)' : '' ?></div>
                        </div>

                        </div>
                    </section>

                    <section class="card">
                        <h2 class="card-title">Recommender Profile</h2>
                        <div class="grid-info">
                        <div class="info-label">Recommender:</div>
                        <div class="info-value"><?= htmlspecialchars($request->recommender_name ?: '-') ?></div>

                        <div class="info-label">Institution:</div>
                        <div class="info-value"><?= htmlspecialchars($request->institution ?: '-') ?></div>

                        <div class="info-label">Position / Title:</div>
                        <div class="info-value"><?= htmlspecialchars($request->position ?: '-') ?></div>

                        <div class="info-label">Relationship:</div>
                        <div class="info-value"><?= htmlspecialchars($request->relationship ?: '-') ?></div>

                        <div class="info-label">Email:</div>
                        <div class="info-value"><?= htmlspecialchars($request->recommender_email) ?></div>
                        </div>
                    </section>

                    <?php if(!$is_expired) : ?>
                    <form action="<?= base_url('recommendation/upload') ?>" method="post" enctype="multipart/form-data" id="form-upload-rec">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                        <input type="hidden" name="status" id="submission_status" value="submitted">
                        <section class="card">
                            <h2 class="card-title">Letter of Recommendation</h2>
                            <a href="<?= base_url($grantee->letter_of_reference) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee->letter_of_reference ? '' : 'hide' ?>" style="margin-bottom:10px;color:#fff">
                                <i class="fa fa-download fa-fw text-white"></i> Download Template Form
                            </a>
                            <div class="guidelines-box">
                                <p class="guidelines-title">Please address in your letter all the areas outlined below.</p>
                                <ol class="guidelines-list">
                                    <li>How long and in what capacity have you known the applicant?</li>
                                    <li>Please discuss the applicant's qualifications and the merits of the proposal by commenting on the following:
                                    <ol>
                                        <li>Applicant's credentials, potential and record of academic or professional accomplishments</li>
                                        <li>Significance of proposal to the field</li>
                                        <li>Importance of project to home country</li>
                                        <li>Relevance of applicant's previous research and training to proposed project</li>
                                    </ol>
                                    </li>
                                    <li>Please address the applicant's cross-cultural adaptability and flexibility.</li>
                                </ol>
                            </div>

                            <p class="intro-paragraph" style="margin-top: 14px;">
                                <?php if($grantee->letter_of_reference) : ?>
                                Please upload a signed letter of recommendation, indicating your name, title and institutional affiliation, in PDF format. File size should not exceed 5MB.
                                <?php else: ?>
                                Please upload a signed letter of recommendation, indicating your name, title and institutional affiliation, on your institution's letterhead, in PDF format. File size should not exceed 5MB.
                                <?php endif; ?>
                            </p>

                            <div class="upload-box">
                                <div class="upload-icon">☁</div>
                                <p class="upload-text">Select a letter file from your device. Allowed format: <strong>PDF (Max: 5MB)</strong></p>
                                <input type="file" class="file-input" name="recommendation_file" id="recommendation_file" accept="application/pdf" <?= $request->file_path ? '' : 'required' ?>>
                            </div>
                            <?php if($request->file_path) : ?>
                                <div style="margin-top:15px;">
                                    <div class="info-label">File:</div>
                                    <div class="info-value">
                                        <a href="<?= base_url($request->file_path) ?>" class="lightbox file-upload" target="_blank"><?= $request->file_name ?></a>
                                        <a href="javascript:;" onclick="del_file_upload(this)" class=" btn-del btn-danger btn-xs" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </section>

                        <section class="card">
                            <h2 class="card-title">Signature</h2>
                            <p class="certification-text">
                                <?= htmlspecialchars($grantee->grant_name ?? '-') ?> requires you certify your recommendation by submitting an electronic signature. To certify your recommendation, read the text below and provide your electronic signature.
                            </p>

                            <div class="legal-clause">
                                "I certify that all the information in my recommendation is accurate and true and that I am the person submitting the recommendation."
                            </div>

                            <h2 class="card-title" style="margin-top: 24px;">Submission</h2>
                            <div class="form-group">
                                <label class="form-label" for="legal_name">In place of your signature, please type your full legal name:</label>
                                <input type="text" id="legal_name" name="legal_name" required class="form-input" placeholder="Full name" value="<?= $request->legal_name ?>">
                            </div>

                            <p class="warning-note">Please note that you may not edit your recommendation after submission.</p>
                            <p class="submit-prompt">Do you want to submit your recommendation now? Click the "Submit" button below.</p>

                            <?php if(!$is_expired) : ?>
                            <div class="action-row">
                            <button type="submit" class="btn btn-submit">Submit</button>
                            <a href="<?= base_url('recommendation/preview/') . $token ?>" target="_blank" class="btn btn-preview">Preview</a>
                            <button type="button" class="btn btn-save" onclick="goToSavedView()">Save for Later</button>
                            </div>
                            <?php endif; ?>
                        </section>
                    </form>
                    <?php endif; ?>
                </div>

                <!-- VIEW 2: Saved for Later View (Hidden by default) -->
                <div id="savedView" style="display: <?= $request->status == 'draft' ? 'block' : 'none' ?>;">
                    <section class="card">
                        <h2 class="card-title">Applicant &amp; Program Information</h2>
                        <div class="grid-info">
                        <div class="info-label">Applicant Name:</div>
                        <div class="info-value"><?= htmlspecialchars($grantee_name) ?></div>

                        <div class="info-label">Program Name:</div>
                        <div class="info-value"><?= htmlspecialchars($grantee->grant_name ?? '-') ?></div>

                        <div class="info-label">Program Year:</div>
                        <div class="info-value"><?= htmlspecialchars($grantee->fiscal_year ?? $grantee->period_name) ?></div>

                        <div class="info-label">Recommender:</div>
                        <div class="info-value"><?= htmlspecialchars($request->recommender_name ?: '-') ?></div>
                        </div>
                    </section>

                    <div class="card">
                        <div class="session-saved-notice">
                            <span class="icon-check"><i class="fa fa-check"></i></span>
                            <span>Your session has been saved. You may return at any time using your secure link.</span>
                        </div>

                        <div class="alert-banner">
                            <div class="alert-heading">Your recommendation has NOT YET BEEN SUBMITTED.</div>
                            <div class="alert-body">
                                If your intent was to submit the recommendation now, click <strong>"Reopen"</strong> below and then click the <strong>"Submit"</strong> button at the bottom of the page.
                            </div>
                        </div>

                        <div style="display: flex;">
                            <button type="button" class="btn btn-submit" onclick="goToFormView()">
                                <i class="fa fa-history"></i> Reopen
                            </button>
                        </div>
                    </div>
                </div>
            </main>
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

    <script>
        function goToSavedView() {
            $('#submission_status').val('draft');
            // document.getElementById('form-upload-rec').requestSubmit();
            $('#form-upload-rec')[0].submit();
        }

        function goToFormView() {
            $('#savedView').css('display', 'none');
            $('#formView').css('display', 'block');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        function del_file_upload(file_id) {
            Swal.fire({
                icon: 'warning',
                title: 'Delete File?',
                text: 'Are you sure you want to delete this file?',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({
                    url: "<?= base_url('recommendation/delete_file') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        token: "<?= htmlspecialchars($token) ?>"
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Deleting...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'File deleted successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // Kalau mau reload
                                location.reload();

                                // Atau kalau cuma mau hapus element:
                                // $('#file-' + file_id).remove();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to delete file.'
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong while deleting the file.'
                        });

                        console.error(xhr.responseText);
                    }
                });
            });
        }
    </script>
    <?php echo isset($script) ? $script : '' ?>

</body>

</html>