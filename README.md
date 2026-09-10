# 💘 Love Matcher - Laravel Serverless on Vercel

Aplikasi kalkulator kecocokan jodoh berbasis web yang dibangun menggunakan **Laravel** dan **Tailwind CSS**, serta telah dioptimalkan untuk di-*deploy* secara *serverless* di platform **Vercel**.

Perhitungan skor menggunakan algoritma deterministik hashing (SHA-256) berbasis nama dan tanggal lahir, sehingga hasilnya bersifat komutatif (hasil kecocokan `A + B` selalu sama persis dengan `B + A`).

---

## ✨ Fitur Utama

- **Deterministic & Commutative Matching:** Skor kecocokan stabil dan tidak berubah-ubah untuk pasangan nama dan tanggal lahir yang sama.
- **Clean Architecture:** Menggunakan pemisahan *Service Layer* dan *Form Request* untuk validasi dan logika bisnis.
- **Modern & Responsive UI:** Tampilan bersih, elegan, dan ramah pengguna di perangkat *mobile* maupun *desktop* menggunakan Tailwind CSS.
- **Serverless Ready:** Dilengkapi konfigurasi khusus (`vercel.json` dan `api/index.php`) agar Laravel dapat berjalan mulus di *runtime* Vercel tanpa kendala *read-only filesystem*.

---

## 🛠️ Tech Stack

- **Framework:** Laravel 11 / 12
- **Frontend:** Blade Templates, Tailwind CSS
- **Deployment:** Vercel (via `vercel-php` runtime)
- **Algorithm:** SHA-256 Hash Normalization

---

## 🚀 Panduan Menjalankan Lokal

Pastikan komputer kamu sudah terpasang **PHP >= 8.2** dan **Composer**.

1. **Clone repositori ini:**
   ```bash
   git clone [https://github.com/username-kamu/nama-repo-kamu.git](https://github.com/username-kamu/nama-repo-kamu.git)
   cd nama-repo-kamu
