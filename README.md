# AMINEF Grantee Portal

Portal interaktif untuk penerima beasiswa AMINEF (Fulbright Indonesia), mencakup modul Allowance, Pre-Departure Orientation (PDO), Visa Appointment, Travel, and Document Management.

## 🚀 Live Demo & Deployment (Cloudflare Pages)

Proyek ini siap di-deploy langsung ke **Cloudflare Pages** tanpa build step (zero-config static deployment).

### Struktur Berkas:
```
├── index.html                     # Entry point utama untuk Cloudflare Pages
├── aminef-portal-dashboard.html   # File halaman portal asli
├── assets/
│   ├── css/
│   │   └── portal.css             # Styling portal AMINEF & Fulbright Design System
│   └── js/
│       └── portal.js              # Interaktivitas UI & logic portal
└── README.md
```

### Cara Hubungkan ke Cloudflare Pages:
1. Buka dashboard [Cloudflare](https://dash.cloudflare.com/)
2. Buka menu **Workers & Pages** > Klik **Create application** > Tab **Pages**
3. Pilih **Connect to Git** dan hubungkan akun GitHub Anda (`abiyuababil`)
4. Pilih repositori `abiyuababil/aminef`
5. Konfigurasi build setting:
   - **Framework preset**: `None`
   - **Build command**: *(kosongkan)*
   - **Build output directory**: `/` (root)
6. Klik **Save and Deploy**. Website Anda akan langsung aktif dengan URL `https://aminef.pages.dev` (atau custom subdomain pilihan Anda).
