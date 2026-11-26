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
                    <h3 class="panel-title text-center">Verifikasi Email Diperlukan</h3>
                </div>
                
                <div class="text-center">
                    <p>Kami telah mengirimkan email konfirmasi kepada Anda.</p>
                    <p>Silakan periksa kotak masuk email Anda dan klik tautan konfirmasi untuk memverifikasi akun Anda.</p>
                    <p><strong>Catatan:</strong> Email konfirmasi mungkin masuk ke folder spam Anda.</p>
                    
                    <hr>
                    
                    <p>Tidak menerima email?</p>
                    <a href="<?= base_url() ?>eta/auth/send_email_verification" class="btn btn-primary">Kirim Ulang Email Verifikasi</a>
                    
                    <hr>
                    
                    <p>Sudah memverifikasi email Anda?</p>
                    <a href="<?= base_url() ?>eta/auth/login" class="btn btn-success">Pergi ke Login</a>
                </div>
            </div>
        </div>
    </div>
</div>