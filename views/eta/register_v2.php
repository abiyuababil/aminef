<style>
    .list-group {
        z-index: 10;
        display: none;
        color: red;
        top: 400px;
    }
</style>
<section id="viewRegister" class="view-card">
    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a
            href="<?= base_url('eta') ?>"
            class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 hover:text-[#008cd3] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke pilihan
        </a>
    </div>

    <div class="text-center mb-6">
        <h2 class="text-xl sm:text-2xl font-normal text-slate-800 tracking-tight">
            Buat Akun Sekolah
        </h2>
        <p class="text-xs sm:text-sm text-slate-700 mt-1 font-normal">
            Silahkan lengkapi form di bawah ini untuk membuat akun sekolah
        </p>
    </div>

    <form role="form" method="POST" class="space-y-3">
        <!-- 1. Email Sekolah Anda (Full Width) -->
        <div>
            <label for="regSchoolEmail" class="sr-only">Email Sekolah Anda</label>
            <input
                type="email"
                id="regSchoolEmail"
                placeholder="Email Sekolah Anda"
                name="email"
                value="<?php echo (isset($email) ? $email : '') ?>"
                autofocus 
                required
                class="w-full px-3.5 py-2.5 text-sm rounded-sm border border-slate-300 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#4dafe6] focus:ring-1 focus:ring-[#4dafe6] transition-colors"
            />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="regSchoolName" class="sr-only">Nama Sekolah</label>
                <input
                    type="text"
                    id="regSchoolName"
                    placeholder="Nama Sekolah (Contoh: SMAN 200 Jakarta)"
                    name="school_name"
                    value="<?php echo (isset($school_name) ? $school_name : '') ?>"
                    required
                    class="w-full px-3.5 py-2.5 text-sm rounded-sm border border-slate-300 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#4dafe6] focus:ring-1 focus:ring-[#4dafe6] transition-colors"
                />
            </div>
            <div>
                <label for="regSchoolPhone" class="sr-only">Nomor Telepon</label>
                <input
                    type="tel"
                    id="regSchoolPhone"
                    placeholder="Nomor Telepon"
                    name="phone_number"
                    value="<?php echo (isset($phone_number) ? $phone_number : '') ?>"
                    required
                    class="w-full px-3.5 py-2.5 text-sm rounded-sm border border-slate-300 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#4dafe6] focus:ring-1 focus:ring-[#4dafe6] transition-colors"
                />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="relative">
                <label for="state" class="sr-only">Pilih Provinsi</label>
                <select
                    id="state"
                    name="state"
                    required
                    class="select2 w-full px-3.5 py-2.5 text-sm rounded-sm border border-slate-300 text-slate-600 bg-white focus:outline-none focus:border-[#4dafe6] focus:ring-1 focus:ring-[#4dafe6] appearance-none cursor-pointer pr-8 transition-colors">
                    <option value="" disabled selected>Pilih Provinsi</option>
                    <?php foreach ($states as $key => $state_name): ?>
                        <option value="<?php echo $key; ?>" <?php echo (isset($state) && $state == $key) ? 'selected' : ''; ?>><?php echo $state_name; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                </div>
            </div>

            <div class="relative">
                <label for="city" class="sr-only">Pilih Kota</label>
                <select
                    id="city"
                    name="city"
                    required
                    class="select2 w-full px-3.5 py-2.5 text-sm rounded-sm border border-slate-300 text-slate-600 bg-white focus:outline-none focus:border-[#4dafe6] focus:ring-1 focus:ring-[#4dafe6] appearance-none cursor-pointer pr-8 transition-colors">
                    <option value="" disabled selected>Pilih Kota</option>
                    <?php foreach ($cities as $key => $city_name): ?>
                        <option value="<?php echo $key; ?>" <?php echo (isset($city) && $city == $key) ? 'selected' : ''; ?>><?php echo $city_name; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="relative">
            <label for="password" class="sr-only">Kata Sandi</label>
            <input
                type="password"
                name="password"
                id="password"
                placeholder="Kata Sandi"
                required
                class="w-full px-3.5 py-2.5 pr-10 text-sm rounded-sm border border-slate-300 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#4dafe6] focus:ring-1 focus:ring-[#4dafe6] transition-colors"
            />
            <button
                type="button"
                onclick="togglePasswordVisibility('password', 'regEyeIcon')"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none p-1"
                aria-label="Tampilkan atau sembunyikan kata sandi">
                <svg id="regEyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>

        <div class="relative">
            <label for="regConfirmPassword" class="sr-only">Konfirmasi Kata Sandi</label>
            <input
                type="password"
                name="password_confirmation"
                id="regConfirmPassword"
                placeholder="Konfirmasi Kata Sandi"
                required
                class="w-full px-3.5 py-2.5 pr-10 text-sm rounded-sm border border-slate-300 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#4dafe6] focus:ring-1 focus:ring-[#4dafe6] transition-colors"
            />
            <button
                type="button"
                onclick="togglePasswordVisibility('regConfirmPassword', 'regConfirmEyeIcon')"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none p-1"
                aria-label="Tampilkan atau sembunyikan konfirmasi kata sandi">
                <svg id="regConfirmEyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>

        <div class="relative">
            <div class="form-group list-group" id="d1">
                <span id="d12"><i class="fa fa-times" aria-hidden="true"></i> Satu Huruf Kapital</span> <br>
                <span id="d15"><i class="fa fa-times" aria-hidden="true"></i> Satu Angka</span> <br>
                <span id="d16"><i class="fa fa-times" aria-hidden="true"></i> Panjang 8 Karakter</span> <br>
            </div>
        </div>

        <div class="bg-[#f0f1f3] rounded-sm p-3.5 flex items-center gap-2.5 mt-2">
            <input
                type="checkbox"
                id="agree"
                required
                class="w-4 h-4 text-[#4dafe6] border-slate-300 rounded focus:ring-0 focus:outline-none cursor-pointer shrink-0"
            />
            <label for="agree" class="text-xs sm:text-[13px] text-slate-800 cursor-pointer select-none">
                Saya menyetujui 
                <a onclick="openModal('exampleModal')" class="text-[#008cd3] hover:underline font-normal">Kebijakan Privasi</a> 
                AMINEF.
            </label>
            </div>

            <div class="pt-2">
            <button
                disabled
                type="submit"
                class="btn-subpas w-full py-2.5 bg-[#4dafe6] hover:bg-[#3d9ed4] active:bg-[#348dbf] disabled:bg-gray-400 disabled:hover:bg-gray-400 disabled:cursor-not-allowed disabled:opacity-70 text-white text-sm sm:text-base font-medium rounded-sm shadow-sm transition-colors duration-200">
                Daftar
            </button>
        </div>

        <div class="pt-2 text-center text-xs text-slate-500">
            Sudah memiliki akun?
            <a
                href="<?= base_url('eta/login') ?>"
                class="text-[#008cd3] hover:underline font-medium ml-1">
                Masuk di sini
            </a>
        </div>
    </form>
</section>
<?php if (isset($err_message)) { ?>
    <div id="inAppNotice" class="mt-4 p-3 rounded-md text-xs text-center font-medium border bg-red-50 text-red-800 border-red-200"><?= $err_message ?></div>
<?php } ?>
<?php if (isset($success_message)) { ?>
    <div id="inAppNoticeSuccess" class="mt-4 p-3 rounded-md text-xs text-center font-medium border bg-emerald-50 text-emerald-800 border-emerald-200"><?= $success_message ?></div>
<?php } ?>



<!-- Modal -->
<div id="exampleModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4"
    onclick="closeModal('exampleModal')">

    <!-- Modal Content -->
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden"
        onclick="event.stopPropagation()">

        <!-- Header -->
        <div class="flex-shrink-0 flex items-center justify-between px-6 py-4 border-b bg-white">
            <h3 class="text-lg font-semibold text-gray-800">
                Kebijakan Privasi AMINEF
            </h3>

            <button type="button"
                onclick="closeModal('exampleModal')"
                class="text-gray-400 hover:text-gray-700 text-2xl leading-none"
                aria-label="Tutup modal">
                &times;
            </button>
        </div>

        <!-- Body: Scrollable Content -->
        <div class="flex-1 min-h-0 overflow-y-auto overscroll-contain px-6 py-5 text-sm text-gray-700 leading-relaxed
            [&>p]:mb-4
            [&>h2]:text-lg
            [&>h2]:font-semibold
            [&>h2]:text-gray-900
            [&>h2]:mt-6
            [&>h2]:mb-3
            [&>ul]:list-disc
            [&>ul]:pl-6
            [&>ul]:mb-4
            [&>ul>li]:mb-2">

            <p>
                Di www.aminef.or.id, dapat diakses dari http://www.aminef.or.id,
                salah satu prioritas utama kami adalah privasi pengunjung kami.
                Dokumen Kebijakan Privasi ini berisi jenis informasi yang
                dikumpulkan dan dicatat oleh www.aminef.or.id dan bagaimana
                kami menggunakannya.
            </p>

            <p>
                Jika Anda memiliki pertanyaan tambahan atau memerlukan informasi
                lebih lanjut tentang Kebijakan Privasi kami, jangan ragu untuk
                menghubungi kami.
            </p>

            <p>
                Kebijakan Privasi ini hanya berlaku untuk aktivitas online kami
                dan berlaku untuk pengunjung situs web kami sehubungan dengan
                informasi yang mereka bagikan dan/atau kumpulkan di
                www.aminef.or.id. Kebijakan ini tidak berlaku untuk informasi
                apa pun yang dikumpulkan secara offline atau melalui saluran
                selain situs web ini.
            </p>

            <h2>Persetujuan</h2>

            <p>
                Dengan menggunakan situs web kami, Anda dengan ini menyetujui
                Kebijakan Privasi kami dan menyetujui persyaratannya.
            </p>

            <h2>Informasi yang kami kumpulkan</h2>

            <p>
                Informasi pribadi yang diminta untuk Anda berikan, dan alasan
                mengapa Anda diminta untuk memberikannya, akan dijelaskan kepada
                Anda pada saat kami meminta Anda untuk memberikan informasi
                pribadi Anda.
            </p>

            <p>
                Jika Anda menghubungi kami langsung, kami mungkin menerima
                informasi tambahan tentang Anda seperti nama, alamat email,
                nomor telepon, isi pesan dan/atau lampiran yang mungkin Anda
                kirimkan kepada kami, dan informasi lain yang mungkin Anda
                pilih untuk berikan.
            </p>

            <p>
                Saat Anda mendaftar untuk Akun, kami mungkin meminta informasi
                kontak Anda, termasuk item seperti nama, nama perusahaan,
                alamat, alamat email, dan nomor telepon.
            </p>

            <h2>Cara kami menggunakan informasi Anda</h2>

            <p>
                Kami menggunakan informasi yang kami kumpulkan dengan berbagai
                cara, termasuk untuk:
            </p>

            <ul>
                <li>
                    Menyediakan, mengoperasikan, dan memelihara situs web kami
                </li>
                <li>
                    Meningkatkan, mempersonalisasi, dan memperluas situs web kami
                </li>
                <li>
                    Memahami dan menganalisis cara Anda menggunakan situs web kami
                </li>
                <li>
                    Mengembangkan produk, layanan, fitur, dan fungsionalitas baru
                </li>
                <li>
                    Berkomunikasi dengan Anda, baik langsung atau melalui salah
                    satu mitra kami, termasuk untuk layanan pelanggan, untuk
                    memberi Anda pembaruan dan informasi lain yang berkaitan
                    dengan situs web, dan untuk tujuan pemasaran dan promosi
                </li>
                <li>Mengirim Anda email</li>
                <li>Menemukan dan mencegah penipuan</li>
            </ul>

        </div>

        <!-- Footer -->
        <div class="flex-shrink-0 flex justify-end gap-2 px-6 py-4 border-t bg-gray-50">
            <button type="button"
                onclick="closeModal('exampleModal')"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                Tutup
            </button>
        </div>

    </div>
</div>