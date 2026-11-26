<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>favicon.png">

    <title>AMINEF</title>

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
    <link href="<?php echo base_url() ?>css/aminef.css" rel="stylesheet">
	<?php echo isset($style) ? $style : '' ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top navbarheader" role="navigation" style="margin-bottom: 0">
			<?php echo $navbar ?>
        </nav>

        <div id="page-wrapper">
			<?php echo $breadcrumb ?>
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
    <script src="<?php echo base_url() ?>js/aminef.js"></script>
	<?php echo isset($script) ? $script : '' ?>

</body>

</html>
