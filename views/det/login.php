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
    .grantee-login-branding {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .grantee-login-branding-inner {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }
</style>   
<div class="row grantee-login-row" style="margin-top: 15%;">
    <div class="col-md-4 col-md-offset-4">
        <div class="grantee-login-branding">
            <div class="grantee-login-branding-inner">
                <img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130" alt="AMINEF">
                <img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200" alt="Fulbright Indonesia">
            </div>
        </div>
        <div class="panel panel-default grantee-login-panel" style="margin-top:10%">     
            <div class="panel-body rounded">
                <div class="header my-3" style="margin-bottom:20px;margin-top:20px;">
                    <h2 class="panel-title text-center" style="font-size:20px;">Login</h2>
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
                        <small class="text-decoration-none mb-3" style="float:right;margin-bottom: 10px;padding: 10px;"><a href="<?= base_url() ?>det/auth/forgot_password">Forgot Password</a></small>
                        <button type="submit" class="btn btn-lg btn-block" value="Login" style="background-color:#0089d1;color:#ffff;">Login <i class="fa fa-sign-in"></i></button>
                    </fieldset>
                </form>
            </div>
        </div>
        <p class="text-center grantee-login-register" style="color:#ffff">Don't have an account yet? <a href="<?= base_url() ?>det/auth/register" style="color:red;">Register</a></p>
    </div>
</div>
