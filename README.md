# Backend CMS - B-Universe Newsletter

Sistem Backend CMS (Content Management System) yang dibangun menggunakan **CodeIgniter 3** untuk mengelola, membuat, dan mengirim newsletter untuk berbagai portal berita di bawah naungan B-Universe (BeritaSatu, Investor, dan Jakarta Globe).

---

## 🚀 Fitur Utama

- **Multi-Portal Newsletter Management**: Mendukung pembuatan newsletter untuk portal *BeritaSatu*, *Investor Daily*, dan *Jakarta Globe* dengan template visual yang berbeda.
- **Subscriber Management**: Mengelola daftar penerima newsletter secara dinamis.
- **Autosend & Mailer Integration**: Menggunakan SMTP untuk pengiriman email newsletter secara massal kepada subscriber.
- **Supabase Integration**: Media upload (gambar/banner newsletter) langsung terintegrasi dengan bucket penyimpanan Supabase.
- **Market & Financial Tickers**: Khusus untuk portal *Investor Daily*, tersedia integrasi data statistik pergerakan pasar (IHSG, nilai tukar mata uang, dll).
- **Authentication & Security**: Proteksi rute admin menggunakan JSON Web Token (JWT).
- **Activity & Send Logs**: Pencatatan riwayat pengiriman newsletter untuk monitoring performa.

---

## 🛠️ Prasyarat (Prerequisites)

Sebelum menjalankan aplikasi ini, pastikan Anda telah menginstal komponen berikut di lingkungan pengembangan Anda:

- **PHP** versi 7.2 s/d 7.4 (atau versi PHP 8.x yang kompatibel dengan CodeIgniter 3)
- **Composer** (untuk instalasi dependensi vendor PHP)
- **MySQL / MariaDB** (sebagai database utama)
- Web Server (**Apache** dengan mod_rewrite aktif atau **Nginx**)

---

## ⚙️ Panduan Instalasi & Konfigurasi

Ikuti langkah-langkah di bawah untuk memasang project ini secara lokal:

### 1. Salin Berkas Environment
Salin berkas `.env.example` menjadi `.env` di direktori utama `BackendCMS`:
```bash
cp .env.example .env
```

Sesuaikan konfigurasi di dalam berkas `.env` dengan kredensial database lokal, server SMTP, serta bucket API Supabase Anda.

> [!WARNING]
> Jangan pernah mem-push berkas `.env` asli ke repositori Git. Berkas `.env` telah secara otomatis ditambahkan ke dalam `.gitignore`.

### 2. Instal Dependensi Vendor
Jalankan composer install untuk mengunduh semua library yang tertera di `composer.json`:
```bash
composer install
```

### 3. Impor Database
1. Buat database baru di MySQL dengan nama `buniverse-newsletter` (atau sesuaikan dengan konfigurasi `.env` Anda).
2. Impor berkas SQL database yang terletak di folder utama project:
   - File: `db_buniverse-newsletter.sql`

### 4. Konfigurasi Web Server
Pastikan folder utama `BackendCMS` dapat diakses melalui web server lokal Anda (misalnya `http://localhost/BackendCMS/` atau melalui virtual host seperti `http://newsletter-cms.local/`).

---

## 📂 Struktur Direktori Penting

* **`application/config/`**: Tempat seluruh berkas konfigurasi berada (`database.php`, `config.php`, `supabase.php`, `email.php`).
* **`application/controllers/`**: Logika pengendali utama aplikasi (seperti `Newsletters.php`, `Subscribers.php`, `Send.php`, dll).
* **`application/models/`**: Query interaksi ke database (seperti `Newsletter_model.php`, `Subscriber_model.php`).
* **`application/views/`**: Template visual antarmuka CMS untuk admin (`admin/beritasatu_form.php`, `admin/investor_form.php`, dll).
* **`index.php`**: Berkas utama (bootstrap) CodeIgniter yang juga berisi modul pembaca `.env` kustom.
