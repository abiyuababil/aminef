<section id="viewLogin" class="view-card">
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

    <div class="text-center mb-5">
        <h2 class="text-lg sm:text-xl font-medium text-slate-800 tracking-tight">
            Selamat Datang di Portal Pendaftaran Host School ETA
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 mt-1 font-normal">
            Silahkan login menggunakan akun anda
        </p>
    </div>

    <form role="form" method="POST" class="space-y-3.5">
        <!-- Input Username -->
        <div>
            <label for="loginUsername" class="sr-only">Email</label>
            <input
                type="text"
                id="loginUsername"
                name="email"
                placeholder="Email"
                value="<?php echo (isset($email) ? $email : '') ?>"
                required
                class="eta-input w-full px-3.5 py-2.5 text-sm rounded-md placeholder-slate-400"
            />
        </div>

        <div class="relative">
        <label for="loginPassword" class="sr-only">Kata Sandi</label>
        <input
            type="password"
            name="password"
            id="loginPassword"
            placeholder="Kata Sandi"
            value=""
            required
            class="eta-input w-full px-3.5 py-2.5 pr-10 text-sm rounded-md placeholder-slate-400"
        />
        <button
            type="button"
            onclick="togglePasswordVisibility('loginPassword', 'loginEyeIcon')"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none p-1"
            aria-label="Tampilkan atau sembunyikan password">
            <svg id="loginEyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
        </div>

        <div class="flex justify-end pt-0.5">
        <a
            href="<?= base_url() ?>eta/auth/forgot_password"
            class="text-xs text-[#008cd3] hover:underline font-normal">
            Lupa Kata Sandi
        </a>
        </div>

        <div class="pt-1">
        <button
            type="submit"
            class="btn-eta-primary w-full py-2.5 text-white text-sm font-medium rounded-md">
            Masuk
        </button>
        </div>

        <div class="pt-2 text-center text-xs text-slate-500">
        Belum punya akun?
        <a
            href="<?= base_url('eta/register') ?>"
            class="text-[#008cd3] hover:underline font-medium ml-1">
            Daftar sekarang
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