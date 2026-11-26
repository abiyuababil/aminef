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
            Lupa Kata Sandi
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 mt-1 font-normal">
            Silakan masukkan alamat email yang terdaftar untuk menerima tautan reset kata sandi
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

        <div class="pt-1">
        <button
            type="submit"
            class="btn-eta-primary w-full py-2.5 text-white text-sm font-medium rounded-md">
            Kirim Tautan Reset
        </button>
        </div>

        <div class="pt-2 text-center text-xs text-slate-500">
        Ingat kata sandi Anda? 
        <a
            href="<?= base_url('eta/login') ?>"
            class="text-[#008cd3] hover:underline font-medium ml-1">
            Masuk
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