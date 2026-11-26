        <div class="row">
            <div class="col-md-6 col-md-offset-3">
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
                        <!-- <h3 class="panel-title">AMINEF</h3> -->
                        <img src="<?php echo base_url('css/images/logo.png') ?>">
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus value="<?php echo (isset($email) ? $email : '') ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                
                                    <div class="row">
                                        <div class="col-md-6">
                                          &nbsp;
                                        </div>
                                        <div class="col-md-6 forgetpass">
                                          <a href="<?php echo site_url('user/forgot_password') ?>">Forget Password</a>
                                        </div>
                                    </div>
                                </div>


                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 nestedcolor">
                <div align="center" class="doublecolor">
                    Don't have an account? <a href="<?php echo site_url('user/sign_up') ?>">Register</a><br>
                    <br>
                    <a href="<?php echo site_url('alumny/directory/american') ?>">American Alumni Directory</a><br>
                    <a href="<?php echo site_url('alumny/directory/indonesian') ?>">Indonesian Alumni Directory</a>
                </div>
            </div>
        </div>