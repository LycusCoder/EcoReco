# 🛍️ Sistem Rekomendasi Produk E-Commerce Berbasis Pola Pembelian Pengguna

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/username/repo/issues)
![GitHub last commit](https://img.shields.io/github/last-commit/username/repo)

Sistem rekomendasi produk berbasis pola pembelian pengguna menggunakan pendekatan modern dengan dua algoritma utama: **Collaborative Filtering** dan **Apriori Algorithm**. Proyek ini bertujuan untuk memberikan rekomendasi personalisasi kepada pelanggan berdasarkan riwayat pembelian mereka.

Dibangun dengan teknologi Laravel dan Blade Template Engine, sistem ini cocok digunakan dalam platform e-commerce yang ingin meningkatkan pengalaman belanja serta efisiensi pemasaran.

---

## 🎯 Tujuan Proyek

- Meningkatkan pengalaman belanja online dengan rekomendasi produk yang relevan.
- Memperkuat analisis data pembelian untuk strategi bisnis yang lebih baik.
- Mengimplementasikan algoritma Collaborative Filtering dan Apriori secara akurat dan efektif.

---

## 🔧 Teknologi yang Digunakan

| Komponen       | Teknologi                |
|----------------|--------------------------|
| **Backend**    | Laravel 10+              |
| **Frontend**   | Blade Template Engine    |
| **Database**   | MySQL (dapat disesuaikan)|
| **Algoritma**  | Collaborative Filtering, Apriori Algorithm |
| **Tools**      | Composer, NPM, Vite, PHP 8+ |

---

## 📦 Fitur Utama

- **Rekomendasi Personalisasi**: Menampilkan produk berdasarkan riwayat pembelian dan preferensi pengguna.
- **Analisis Pola Pembelian**: Menggunakan algoritma Apriori untuk menemukan itemset yang sering dibeli bersama.
- **Dashboard Admin**: Untuk melihat hasil analisis dan mengelola data.
- **Antarmuka Intuitif**: UI sederhana dan responsif untuk pengunjung dan admin.

---

## 📁 Struktur Direktori (Ringkasan)

Proyek ini mengikuti struktur standar Laravel dengan tambahan fitur analisis dan rekomendasi.  
Untuk detail struktur direktori lengkap, silakan lihat [di sini](#struktur-direktori-lengkap).

---

## 🚀 Cara Menjalankan Proyek

### 1. Clone Repositori
```bash
git clone https://github.com/LycusCoder/Sistem-Rekomendasi-Produk-E-Commerce.git
cd Sistem-Rekomendasi-Produk-E-Commerce
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi Database
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Lalu ubah konfigurasi database di file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_rekomendasi
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key
```bash
php artisan key:generate
```

### 5. Migrasi Database
```bash
php artisan migrate
```

### 6. Seed Data (Opsional)
```bash
php artisan db:seed
```

### 7. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: http://127.0.0.1:8000

---

## 📁 Struktur Direktori Lengkap

Struktur folder lengkap bisa kamu lihat di file `README.md` atau langsung dari repositori.

---

## 🤝 Kontribusi

Kami sangat senang menerima kontribusi dari komunitas! Jika kamu tertarik untuk membantu pengembangan proyek ini:

1. Fork repositori
2. Buat branch baru (`git checkout -b fitur-baru`)
3. Lakukan perubahan
4. Commit dan push
5. Buat Pull Request

Silakan baca file `CONTRIBUTING.md` untuk panduan lebih lanjut.

---

## 📞 Kontak Tim

Jika ada pertanyaan atau ingin berdiskusi lebih lanjut, jangan ragu untuk menghubungi kami:

- 👨‍💻 Muhammad Affif – affif@nourivex.tech
- 🌟 Yesa Anggit Prayugo – yesaprayugo4@gmail.com
- 📝 Siti Novia Desi Nurkhikmah – sitinoviadesi@gmail.com
- 🚀 Naufal Miftahul Arsyij – arsyinaufal12@gmail.com
- 🎉 Imzy Zulijar Setiawan – imzyzulijar01@gmail.com

---

## 📄 Lisensi

Proyek ini dibuat di bawah lisensi MIT License. Silakan lihat file [`LICENSE`](LICENSE) untuk detail selengkapnya.

---

## 🏆 Dukung Kami

Jika kamu menyukai proyek ini, jangan ragu untuk memberikan ⭐ pada repositorinya atau berkontribusi dalam pengembangan lebih lanjut!