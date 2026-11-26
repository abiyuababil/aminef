        <style>
			.password-show-c{
				cursor: pointer;
				color: #cacaca;
				width: 40px;
                float: right;
                left: 20px;
                margin-top: -25px;
                position: relative;
                z-index: 2;
			}
		</style>        
        <div class="row" style="margin-top:5%">
            <div class="col-md-4 col-md-offset-4">
				<div style="margin-top:10px">
					<?php if (isset($err_message)) { ?>
					<div class="alert alert-danger alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						<?php echo $err_message ?>
					</div>
					<?php } ?>
					<?php if (isset($success_message)) { ?>
					<div class="alert alert-success alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						<?php echo $success_message ?>
					</div>
					<?php } ?>
				</div>
                <div class="row">
                        <div class="col-md-6" style="margin-left:-15px;"><img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130"></div>
                        <div class="col-md-6"><img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200"></div>
                </div>
                <div class="login-panel panel panel-default" style="margin-top:15%;">
                    <div class="panel-body">
                        <div class="header mb-3" style="margin-bottom:20px">
                            <h3 class="panel-title text-center" style="color:#0089d1"><i class="fa fa-sign-in fa-3x"></i></h3>
                            <h3 class="panel-title text-center">Log In</h3>
                        </div>
						<form role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Email" name="email" type="text" autofocus value="<?php echo (isset($email) ? $email : '') ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    <i class="fa fa-eye password-show-c"></i>
                                </div>
                                <small class="text-decoration-none mb-3" style="float:right"><a href="<?= base_url() ?>host/auth/forgot_password">Forgot Password</a></small>
								<input type="submit" class="btn btn-lg btn-block" value="Log In" style="background-color:#0089d1;color:#ffff;">
                            </fieldset>
                        </form>
                    </div>
                </div>
                <p class="text-center" style="color:#ffff">Don't have an account yet? <a href="<?= base_url() ?>host/register" style="color:red;">Register</a></p>
            </div>
        </div>
