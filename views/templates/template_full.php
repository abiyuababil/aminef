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
					<li>
						<img src="<?php echo base_url('img/logo-fulbright-3070-new.png') ?>" style="margin-top:-15px; width:auto; height:80px;">
					</li>
                    <?php } ?>
				</ul>
			</div>
		</div>
	  </div>

        <div id="page-wrapper" style="margin-left:0;">
			<?php echo $content ?>
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
