<section id="viewChoice" class="view-card">
    <div class="text-center mb-6">
        <h1 class="text-lg sm:text-xl font-medium text-slate-800 tracking-tight leading-snug">
        Selamat Datang di Portal Pendaftaran Host School ETA
        </h1>
    </div>

    <div class="space-y-3.5 pt-1">
        <a
        href="<?= base_url('eta/login') ?>"
        class="w-full group text-left p-4 rounded-xl border-2 border-slate-200 hover:border-[#008cd3] bg-white hover:bg-sky-50/40 transition-all duration-200 flex items-center justify-between shadow-sm hover:shadow-md">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-lg bg-sky-100 text-[#008cd3] flex items-center justify-center shrink-0 group-hover:bg-[#008cd3] group-hover:text-white transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                </div>
                <div>
                <h3 class="text-sm sm:text-base font-semibold text-slate-800 group-hover:text-[#008cd3] transition-colors">
                    Masuk
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Sudah memiliki akun sekolah? Silakan masuk untuk melanjutkan.
                </p>
                </div>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:text-[#008cd3] group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

        <a
        href="<?= base_url('eta/register') ?>"
        class="w-full group text-left p-4 rounded-xl border-2 border-slate-200 hover:border-[#008cd3] bg-white hover:bg-sky-50/40 transition-all duration-200 flex items-center justify-between shadow-sm hover:shadow-md">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-lg bg-blue-50 text-[#008cd3] flex items-center justify-center shrink-0 group-hover:bg-[#008cd3] group-hover:text-white transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                </div>
                <div>
                <h3 class="text-sm sm:text-base font-semibold text-slate-800 group-hover:text-[#008cd3] transition-colors">
                    Buat Akun Sekolah
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Belum memiliki akun sekolah? Daftarkan sekolah Anda sekarang.
                </p>
                </div>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:text-[#008cd3] group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
</section>