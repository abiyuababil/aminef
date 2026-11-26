<div class="row" style="margin-top:5%">
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
        <div class="row">
            <div class="col-md-6"><img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130"></div>
            <div class="col-md-6 text-right"><img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200"></div>
        </div>
        <div class="login-panel panel panel-default" style="margin-top:15%;">
            <div class="panel-body">
                <div class="header mb-3" style="margin-bottom:20px">
                    <h3 class="panel-title text-center" style="color:#0089d1"><i class="fa fa-envelope fa-3x"></i></h3>
                    <h3 class="panel-title text-center">Send Email Verification</h3>
                </div>
                <form role="form" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" placeholder="Enter email address" name="email" type="email" autofocus value="<?php echo (isset($email) ? $email : '') ?>">
                            <small class="form-text text-muted">You can enter multiple emails separated by semicolon (;)</small>
                        </div>
                        <input type="submit" class="btn btn-lg btn-block" value="Send Verification Email" style="background-color:#0089d1;color:#ffff;">
                    </fieldset>
                </form>
            </div>
        </div>
        <p class="text-center" style="color:#ffff">Already verified? <a href="<?= base_url() ?>host/auth/login" style="color:red;">Login</a></p>
    </div>
</div>