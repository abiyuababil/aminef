<style>
    .list-group {
        z-index: 10;
        display: none;
        color: red;
        top: 400px;
    }
</style>

<div class="row eta-auth-row">
    <div class="col-md-8 col-md-offset-2 eta-auth">
        <div class="row">
            <div class="col-md-6 text-left"><img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130"></div>
            <div class="col-md-6 text-right"><img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200">
            </div>
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
        <div class="login-panel panel panel-default">
            <div class="panel-body">
                <div class="header mb-3" style="margin-bottom:20px; text-align: center;">
                    <h4>Buat Akun Sekolah</h4>
                    <p>Silahkan Lengkapi Form di Bawah Ini Untuk Membuat Akun Sekolah</p>
                </div>
                <form role="form" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <input required class="form-control" placeholder="Email Sekolah Anda" name="email"
                                type="email" autofocus value="<?php echo (isset($email) ? $email : '') ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Nama Sekolah" name="school_name"
                                        type="text" value="<?php echo (isset($school_name) ? $school_name : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Nomor Telepon" name="phone_number"
                                        type="text" value="<?php echo (isset($phone_number) ? $phone_number : '') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select required class="form-control" name="state" id="state">
                                        <option value="">Pilih Provinsi</option>
                                        <?php foreach ($states as $key => $state_name): ?>
                                            <option value="<?php echo $key; ?>" <?php echo (isset($state) && $state == $key) ? 'selected' : ''; ?>><?php echo $state_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select required class="form-control" name="city" id="city">
                                        <option value="">Pilih Kota</option>
                                        <?php foreach ($cities as $key => $city_name): ?>
                                            <option value="<?php echo $key; ?>" <?php echo (isset($city) && $city == $key) ? 'selected' : ''; ?>><?php echo $city_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea required class="form-control" placeholder="Alamat Sekolah" name="address"
                                rows="3"><?php echo (isset($address) ? $address : '') ?></textarea>
                        </div>

                        <div class="form-group password-group">
                            <input required class="form-control" placeholder="Kata Sandi" name="password" id="password"
                                type="password" value="" autocomplete="new-password">
                            <i class="fa fa-eye password-show"></i>
                        </div>
                        <div class="form-group password-group">
                            <input required class="form-control" placeholder="Konfirmasi Kata Sandi"
                                name="password_confirmation" type="password" value="">
                            <i class="fa fa-eye password-show"></i>
                        </div>

                        <div class="form-group list-group" id="d1">
                            <span id="d12"><i class="fa fa-times" aria-hidden="true"></i> Satu Huruf Kapital</span> <br>
                            <span id="d15"><i class="fa fa-times" aria-hidden="true"></i> Satu Angka</span> <br>
                            <span id="d16"><i class="fa fa-times" aria-hidden="true"></i> Panjang 8 Karakter</span> <br>
                        </div>

                        <div class="text-center" style="background-color:#efefef;padding:20px; margin-bottom:15px;">
                            <p class="text-left" style="margin-bottom:0">
                                <input type="checkbox" class="form-check-input" id="agree" required> Saya menyetujui <a
                                    href="javascript:;" data-toggle="modal" data-target="#myModal">Kebijakan Privasi</a>
                                AMINEF. <br>

                            </p>
                        </div>

                        <input type="submit" disabled class="btn btn-lg btn-block btn-subpas" value="Daftar"
                            style="background-color:#0089d1;color:#ffff">
                    </fieldset>
                </form>
            </div>
        </div>
        <p class="text-center" style="color:#ffff; margin-top: 20px;">
            Sudah punya akun?
            <a href="<?= base_url() ?>eta/auth/login" style="color:red; text-decoration:underline;">Login Disini</a>
        </p>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Kebijakan Privasi AMINEF</h4>
            </div>
            <div class="modal-body">
                <p>Di www.aminef.or.id, dapat diakses dari http://www.aminef.or.id, salah satu prioritas utama kami
                    adalah privasi pengunjung kami. Dokumen Kebijakan Privasi ini berisi jenis informasi yang
                    dikumpulkan dan dicatat oleh www.aminef.or.id dan bagaimana kami menggunakannya.</p>
                <p>Jika Anda memiliki pertanyaan tambahan atau memerlukan informasi lebih lanjut tentang Kebijakan
                    Privasi kami, jangan ragu untuk menghubungi kami.</p>
                <p>Kebijakan Privasi ini hanya berlaku untuk aktivitas online kami dan berlaku untuk pengunjung situs
                    web kami sehubungan dengan informasi yang mereka bagikan dan/atau kumpulkan di www.aminef.or.id.
                    Kebijakan ini tidak berlaku untuk informasi apa pun yang dikumpulkan secara offline atau melalui
                    saluran selain situs web ini.</p>
                <h2>Persetujuan</h2>
                <p>Dengan menggunakan situs web kami, Anda dengan ini menyetujui Kebijakan Privasi kami dan menyetujui
                    persyaratannya.</p>
                <h2>Informasi yang kami kumpulkan</h2>
                <p>Informasi pribadi yang diminta untuk Anda berikan, dan alasan mengapa Anda diminta untuk
                    memberikannya, akan dijelaskan kepada Anda pada saat kami meminta Anda untuk memberikan informasi
                    pribadi Anda.</p>
                <p>Jika Anda menghubungi kami langsung, kami mungkin menerima informasi tambahan tentang Anda seperti
                    nama, alamat email, nomor telepon, isi pesan dan/atau lampiran yang mungkin Anda kirimkan kepada
                    kami, dan informasi lain yang mungkin Anda pilih untuk berikan.</p>
                <p>Saat Anda mendaftar untuk Akun, kami mungkin meminta informasi kontak Anda, termasuk item seperti
                    nama, nama perusahaan, alamat, alamat email, dan nomor telepon.</p>
                <h2>Cara kami menggunakan informasi Anda</h2>
                <p>Kami menggunakan informasi yang kami kumpulkan dengan berbagai cara, termasuk untuk:</p>
                <ul>
                    <li>Menyediakan, mengoperasikan, dan memelihara situs web kami</li>
                    <li>Meningkatkan, mempersonalisasi, dan memperluas situs web kami</li>
                    <li>Memahami dan menganalisis cara Anda menggunakan situs web kami</li>
                    <li>Mengembangkan produk, layanan, fitur, dan fungsionalitas baru</li>
                    <li>Berkomunikasi dengan Anda, baik langsung atau melalui salah satu mitra kami, termasuk untuk
                        layanan pelanggan, untuk memberi Anda pembaruan dan informasi lain yang berkaitan dengan situs
                        web, dan untuk tujuan pemasaran dan promosi</li>
                    <li>Mengirim Anda email</li>
                    <li>Menemukan dan mencegah penipuan</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>