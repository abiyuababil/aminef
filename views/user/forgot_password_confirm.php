        <div class="row">
            <div class="col-md-4 col-md-offset-4">
				<div style="margin-top:10px">
					<?php if (isset($err_message)) { ?>
					<div class="alert alert-danger alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						<?php echo $err_message ?>
					</div>
					<?php } ?>
				</div>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Reset Password</h3>
                    </div>
                    <div class="panel-body">
						<form role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
									<input class="form-control" placeholder="Confirm Password" name="password_confirm" type="password" value="">
                                </div>
								<input type="submit" class="btn btn-lg btn-success btn-block" value="Submit">
                            </fieldset>
                        </form>
                    </div>
                </div>
				<div class="whitetext">
					Please set your new password into above input box.<br>
					<br>
				</div>
				<div align="center">
					<a href="<?php echo site_url('user/login') ?>">Back to Login</a>
				</div>
            </div>
        </div>
