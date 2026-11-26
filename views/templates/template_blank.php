<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>favicon.png">

    <title><?php echo isset($page_title) ? $page_title : 'AMINEF Admin' ?></title>

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
    <style>
        #page-wrapper-blank{
            position: inherit;
            padding: 0 30px;
            border-left: 1px solid #e7e7e7;
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top navbarheader" role="navigation" style="margin-bottom: 0">
            <?php echo $navbar ?>
        </nav>

        <div id="page-wrapper-blank">
            <?php echo $content ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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