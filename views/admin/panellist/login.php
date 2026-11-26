
        <div class="grantee-login-branding">
            <div class="grantee-login-branding-inner">
                <img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130" alt="AMINEF">
                <img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200" alt="Fulbright Indonesia">
            </div>
        </div>
        <div class="row grantee-login-row">
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
                <div class="login-panel panel panel-default grantee-login-panel">
                    <div class="panel-body">
                        <div class="header mb-3" style="margin-bottom:20px;">
                            <h3 class="panel-title text-center" style="color:#0089d1"><i class="fa fa-sign-in fa-3x"></i></h3>
                            <h3 class="panel-title text-center">Login</h3>    
                        </div>
                        <form role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Email" name="email" type="text" autofocus value="<?php echo (isset($email) ? $email : '') ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <small class="text-decoration-none mb-3" style="float:right"><a href="<?= base_url() ?>panelist/forgot_password">Forgot Password</a></small>
								<input type="submit" class="btn btn-lg btn-block" value="Login" style="background-color:#0089d1;color:#ffff;">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
