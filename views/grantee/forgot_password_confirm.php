        <style>
			.list-group {
				z-index:10;
				display:none; 
				/* position:absolute;  */
				color:red;
				top:400px;
			}
			.password-show{
				cursor: pointer;
				color: #cacaca;
				width: 40px;
				float: right;
				left: 5px;
                margin-top: -60px;
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
                            <h3 class="panel-title text-center" style="color:#0089d1"><i class="fa fa-key fa-3x"></i></h3>
                            <h3 class="panel-title text-center">Reset Password</h3>
                        </div>
						<form role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="">
                                    <i class="fa fa-eye password-show"></i>
                                </div>
                                <div class="form-group">
									<input class="form-control" placeholder="Confirm Password" name="password_confirm" type="password" value="">
                                    <i class="fa fa-eye password-show"></i>
                                </div>
								<div class="form-group list-group" id="d1">
									<span id="d12"><i class="fa fa-times" aria-hidden="true"></i> One Upper Case Letter</span> <br>
									<span id="d15"><i class="fa fa-times" aria-hidden="true"></i> One Number</span> <br>
									<span id="d16"><i class="fa fa-times" aria-hidden="true"></i> Length 8 Char</span> <br>
								</div>
								<input type="submit" class="btn btn-lg btn-block btn-subpas" disabled value="Submit" style="background-color:#0089d1;color:#ffff;">
                            </fieldset>
                        </form>
                    </div>
                </div>
                <p class="text-center" style="color:#ffff">Please set your new password into above input box.</p>
				<div align="center">
					<a style="color:red;" href="<?php echo site_url('grantee/') ?>">Back to Login</a>
				</div>
            </div>
        </div>

