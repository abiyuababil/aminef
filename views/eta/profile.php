<style>
.password-show{
    position: absolute;
    right: 30px;
    cursor: pointer;
    color: #cacaca;
    width: 40px;
    line-height: 38px;
    text-align: center;
}

.containt {
    margin: 0px auto 30px auto;
}

.progressbar {
    counter-reset: step;
    margin: 0px;
    padding: 0px;
}

.progressbar li {
    display: inline-block;
    list-style-type: none;
    width: 25%;
    font-size: 12px;
    position: relative;
    text-align: center;
    text-transform: uppercase;
    color: #7d7d7d;
}

.progressbar li {
    width: 30px;
    height: 30px;
    line-height: 30px;
    background-color: #b5b5b5;
    text-align: center;
    margin: auto 10px;
    border-radius: 50%;
    cursor: pointer;
}

.progressbar li a {
    color: white !important;
    text-decoration: none;
}

.progressbar li:after {
    width: 100%;
    height: 2px;
    content: '';
    position: absolute;
    background-color: #7d7d7d;
    top: 15px;
    left: -50%;
    z-index: -1;
}

.progressbar li:first-child:after {
    content: none;
}

.progressbar li.active {
    color: white;
    background-color: #0089d1;
}

.progressbar li.active+li:after {
    background-color: #55b776;
}

.display {
    display: none;
}

.no-padding{
    padding: 0px !important;
}

.text-white {
    color: white;
}
</style>

<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Akun Sekolah</h1>
    </div>
</div>

<div style="margin-top:10px">
    <?php if (isset($notif_success) && $notif_success) { ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $notif_success ?>
    </div>
    <?php } ?>
    <?php if (isset($notif_error) && $notif_error) { ?>
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $notif_error ?>
    </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-lg-12" style="margin-bottom:10px">
        <ul class="nav nav-pills">
            <li id="li_personal" class="active"><a data-toggle="tab" href="#personal" aria-expanded="true">Akun Sekolah</a></li>
            <li id="li_contact"><a data-toggle="tab" href="#contact" aria-expanded="true">Autentikasi</a></li>
        </ul>
    </div>
</div>

<div class="tab-content">
    <div id="personal" class="tab-pane fade active in">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo form_open('', array('id' => 'form', 'method' => 'POST')); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input required class="form-control" placeholder="Email sekolah anda" name="email" type="email" value="<?php echo (isset($email) ? $email : '') ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Sekolah</label>
                                <input required class="form-control" placeholder="Nama Sekolah" name="school_name" type="text" value="<?php echo (isset($school_name) ? $school_name : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input required class="form-control" placeholder="Nomor Telepon" name="phone_number" type="text" value="<?php echo (isset($phone_number) ? $phone_number : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Provinsi</label>
                                <select required class="form-control" name="state" id="state">
                                    <option value="">Pilih Provinsi</option>
                                    <?php foreach($states as $key => $state_name): ?>
                                        <option value="<?php echo $key; ?>" <?php echo (isset($state) && $state == $key) ? 'selected' : ''; ?>><?php echo $state_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kota</label>
                                <select required class="form-control" name="city" id="city">
                                    <option value="">Pilih Kota</option>
                                    <?php foreach($cities as $key => $city_name): ?>
                                        <option value="<?php echo $key; ?>" <?php echo (isset($city) && $city == $key) ? 'selected' : ''; ?>><?php echo $city_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea required class="form-control" placeholder="Alamat" name="address" rows="3"><?php echo (isset($address) ? $address : '') ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" id="btn-submit" class="btn btn-primary">Perbarui Profil</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    
    <div id="contact" class="tab-pane fade">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo form_open('', array('id' => 'form-contact', 'method' => 'POST')); ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Biarkan kolom kata sandi kosong jika Anda tidak ingin mengubah kata sandi.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kata Sandi Baru</label>
                                <input class="form-control" placeholder="Kata Sandi Baru" name="password" type="password" value="">
                                <i class="fa fa-eye password-show"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Konfirmasi Kata Sandi Baru</label>
                                <input class="form-control" placeholder="Konfirmasi Kata Sandi Baru" name="confirm_password" type="password" value="">
                                <i class="fa fa-eye password-show"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Perbarui Kata Sandi</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>