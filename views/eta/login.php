<style>
    .password-show-c {
        color: #cacaca;
        cursor: pointer;
        float: right;
        left: 20px;
        margin-top: -25px;
        position: relative;
        width: 40px;
        z-index: 2;
    }
</style>
<div class="grantee-login-branding">
    <div class="grantee-login-branding-inner">
        <img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130" alt="AMINEF">
        <img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200" alt="Fulbright Indonesia">
    </div>
</div>
<div class="row eta-auth-row grantee-login-row">
    <div class="col-md-6 col-md-offset-3 eta-auth">
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
                <div class="header mb-3" style="margin-bottom:20px; text-align: center;">
                    <h4>Selamat Datang di Pendaftaran ETA Host School</h4>
                    <p>Silahkan login menggunakan akun anda</p>
                </div>
                <form role="form" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Email Sekolah Anda" name="email" type="text"
                                autofocus value="<?php echo (isset($email) ? $email : '') ?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Kata Sandi" name="password" type="password"
                                value="">
                            <i class="fa fa-eye password-show-c"></i>
                        </div>
                        <small class="text-decoration-none mb-3" style="float:right"><a
                                href="<?= base_url() ?>eta/auth/forgot_password">Lupa Kata Sandi</a></small>
                        <input type="submit" class="btn btn-lg btn-block" value="Masuk"
                            style="background-color:#0089d1;color:#ffff;">
                    </fieldset>
                </form>
            </div>
        </div>
        <p class="text-center grantee-login-register" style="color:#ffff; margin-top: 20px;">
            Jika anda belum punya akun, silahkan
            <a href="<?= base_url() ?>eta/register/register" style="color:orangered; text-decoration:underline;">Daftar
                Disini</a>
        </p>
        <?php if (!empty($active_eta_app) && !empty($active_eta_app->guide_file)) { ?>
            <p class="text-center" style="color:#ffff;">
                Jika anda merasa kesulitan mendaftar <br>
                <a href="<?= base_url() ?><?= $active_eta_app->guide_file ?>" download style="text-decoration:underline; font-weight: bold; color:orangered;">Unduh Intruksi Pendaftaran</a>
            </p>
        <?php } ?>
    </div>
</div>