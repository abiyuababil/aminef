<div class="row" style="margin-top:5%">
    <div class="col-md-6 col-md-offset-3">
        <div class="row">
            <div class="col-md-6"><img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130"></div>
            <div class="col-md-6 text-right"><img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200"></div>
        </div>
        <div class="login-panel panel panel-default" style="margin-top:15%;">
            <div class="panel-body">
                <div class="header mb-3" style="margin-bottom:20px">
                    <h3 class="panel-title text-center" style="color:#0089d1;"><i class="fa fa-envelope fa-3x"></i></h3>
                    <h3 class="panel-title text-center">Verification Required</h3>
                </div>
                
                <div class="text-center">
                    <p>We have sent a confirmation email to you.</p>
                    <p>Please check your email inbox and click the confirmation link to verify your account.</p>
                    <p><strong>Note:</strong> The confirmation email may be in your spam folder.</p>
                    
                    <hr>
                    
                    <p>Didn't receive the email?</p>
                    <a href="<?= base_url() ?>host/auth/send_email_verification" class="btn btn-primary">Resend Verification Email</a>
                    
                    <hr>
                    
                    <p>Have you already verified your email?</p>
                    <a href="<?= base_url() ?>host/auth/login" class="btn btn-success">Go to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>