        <div class="row">
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
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Forgot Password</h3>
                    </div>
                    <div class="panel-body">
						<form role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus value="<?php echo (isset($email) ? $email : '') ?>">
                                </div>
								<input type="submit" class="btn btn-lg btn-success btn-block" value="Submit">
                            </fieldset>
                        </form>
                    </div>
                </div>
				<div class="blacktext">
					Please submit your email address into above input box,<br>
					and we will send you the link to your email.<br>
					follow the instruction in your email to reset your password<br>
					<br>
				</div>
				<div align="center" class="whitetext">
					<a href="<?php echo site_url('user/login') ?>">Back to Login</a>
				</div>
            </div>
        </div>
