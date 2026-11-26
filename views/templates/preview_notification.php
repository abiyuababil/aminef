<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>favicon.png">

    <title>AMINEF Admin | Preview Email</title>

    <link href="<?php echo base_url() ?>css/bootstrap.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-4-utilities.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/metisMenu.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/sb-admin-2.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/morris.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/select2.min.css?v=<?=VERSION?>" rel="stylesheet" />
    <link href="<?php echo base_url() ?>css/aminef.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/topbox.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-datetimepicker.css" rel="stylesheet">    
    <link href="<?php echo base_url() ?>css/jquery-ui.min.css" rel="stylesheet">
    <?php echo isset($style) ? $style : '' ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php
        $email_content = $template_notification->content;
            
        // set variablee
        $email_content = safe_str_replace("{full_name_grantee}", 'William Halfbright', $email_content);
        $email_content = safe_str_replace("{program_name}", 'Fulbright Specialist Program' , $email_content);
        $email_content = safe_str_replace("{fiscal_year}", date('Y'), $email_content);
        $email_content = safe_str_replace("{category}", '2nd Disbursement', $email_content);
        $email_content = safe_str_replace("{submit_date}", date('d M Y H:i'), $email_content);
        $email_content = safe_str_replace("{release_date}", date('d M Y H:i'), $email_content);
        $email_content = safe_str_replace("{url}", base_url(), $email_content);
        $email_content = safe_str_replace("{status_document}", 'Documents Submitted', $email_content);
        $email_content = safe_str_replace("{payment_status}", 'Released', $email_content);
        $email_content = safe_str_replace("{email_grantee}", 'william@mail.com', $email_content);
        $email_content = safe_str_replace("{password_grantee}", '********', $email_content);
        $email_content = safe_str_replace("{link_login_grantee}", base_url('grantee'), $email_content);
        $email_content = safe_str_replace("{url_reset_password}", base_url('grantee'), $email_content);
        $email_content = safe_str_replace("{document_name}", 'Post-Arrival Documents', $email_content);
        $email_content = safe_str_replace("{note}", 'Lorem ipsum dolor sit amet.', $email_content);
        $email_content = safe_str_replace("{report_name}", 'Aminef Midterm Report', $email_content);
        $email_content = safe_str_replace("{payment_category}", '2nd Disbursement', $email_content);
        $email_content = safe_str_replace("{total_payment}", '123,000', $email_content);
        $email_content = safe_str_replace("{admin_name}", 'Etzel Barnaby', $email_content);
        $email_content = safe_str_replace("{admin_program_name}", 'Etzel Barnaby', $email_content);
        $email_content = safe_str_replace("{staff_finance_name}", 'Etzel Barnaby', $email_content);
        $email_content = safe_str_replace("{table}", $table, $email_content);
        $email_content = safe_str_replace("{end_date}", date('F d, Y'), $email_content);
    ?>
    
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-lg-12 text-center">
                <h1>Notification Preview - <?= $template_notification->name ?></h1>
            </div>
        </div>
        <div class="row d-flex align-items-center justify-content-center" style="border:1px solid black;padding:20px">
            <div class="col-lg-12">
                <?= $email_content ?>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/metisMenu.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/raphael-min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/morris.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/sb-admin-2.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/select2.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/aminef.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/ckeditor.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/topbox.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap-datetimepicker.js?v=<?=VERSION?>"></script>
    <?php echo isset($script) ? $script : '' ?>
    <script>
        $(document).ready(function() {
            $('.lightbox').topbox();
            $('input[type="text"], input[type="email"], input[type="password"]').attr('autocomplete','new-password');
        });
    </script>

</body>

</html>