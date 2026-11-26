<?php
  if ( ! function_exists('base_url')) {
    function base_url($link='')
    {
      $protocol = 'http';
      if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on')
        $protocol = 'https';
      $url = $protocol.'://'.$_SERVER["SERVER_NAME"].'/aminef-db/';
      return $url.$link;
    }
  }
?>
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

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>css/sb-admin-2.css" rel="stylesheet">
    
    <!-- Aminef CSS -->
    <link href="<?php echo base_url() ?>css/aminef.css?v=6" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper" class="directory"  style="background:#fff">
      <div class="header-wrapper-alumny-application">
        <div class="header-container-upside">
          <div class="header-upside">
            <ul>
              <li class="logoAminef">
                <a href="https://www.aminef.or.id/"><img src="<?php echo base_url('img/logo-aminef-color.png') ?>"></a>
              </li>
              <li class="logoFullbright" style="margin-right: 2vw;">
                <img src="<?php echo base_url('img/logo-fulbright-color.png') ?>">
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div id="page-wrapper" style="margin-left:0;">

		  <div class="row" style="padding:30px 0">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
	   
			  <div class="panel panel-info">
				<div class="panel-heading">
				  <h3 style="margin:0"><?= $message?></h3>
				</div>
			  </div>
			<!-- <a href="<?= base_url('admin') ?>" class="btn btn-warning" style="background-color:#EE3424; border-color:#EE3424;">Back to Home</a> -->
			</div>
		  </div>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>
