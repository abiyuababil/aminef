<!DOCTYPE html>
<html lang="id">

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

    <!-- jQuery UI -->
    <link href="<?php echo base_url() ?>css/jquery-ui.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url() ?>css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Aminef CSS -->
    <link href="<?php echo base_url() ?>css/aminef.css?v=<?php echo VERSION; ?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="<?php echo isset($body_class) ? $body_class : 'bodyimage'; ?>">

    <div class="container">
		<?php echo $content ?>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url() ?>js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url() ?>js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url() ?>js/sb-admin-2.js"></script>
    
    <?php echo isset($script) ? $script : '' ?>

    <script>
      $( function() {
		$( ".datepicker" ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat: "dd M yy",
		  yearRange: "<?php echo date('Y') - 100 ?>:<?php echo date('Y') + 20 ?>"
		});
      } );
    
    // show hide password
    $(document).on('click', ".fa-eye", function() {
        $(this).removeClass('fa-eye');
        $(this).addClass('fa-eye-slash');
        $(this).siblings('input').attr('type', 'text');
    });

    $(document).on('click', ".fa-eye-slash", function() {
        $(this).removeClass('fa-eye-slash');
        $(this).addClass('fa-eye');
        $(this).siblings('input').attr('type', 'password');
    });
    
    $(document).on('change', '.dont_have_first_name', function() {
        let input = $(this).closest('.form-group').find('input[type="text"], input.form-control').first();

        if ($(this).is(':checked')) {
            input.val('FNU').prop('disabled', true);
        } else {
            input.val('').prop('disabled', false);
        }
    });

    $(document).ready(function() {
      $('.dont_have_first_name').trigger('change');
    });
    </script>
</body>

</html>
