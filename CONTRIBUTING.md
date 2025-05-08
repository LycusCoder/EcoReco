# Contributing

Terima kasih telah tertarik untuk berkontribusi ke proyek ini! 💖  
Setiap kontribusi sangat kami hargai, baik itu kode, dokumentasi, testing, atau bahkan hanya saran dan ide segar.

## Cara Berkontribusi

1. Fork repositori ini.

2. Buat branch baru:
   ```bash
   git checkout -b fitur-baru
   ```
3. Lakukan perubahan yang kamu inginkan.

4. Commit dengan pesan jelas:
   ```bash
   git commit -m "Tambah fitur X"
   ```
5. Push ke branch kamu:
   ```bash
   git push origin fitur-baru
   ```
6. Buat Pull Request (PR) ke branch `main` atau `develop`.

> Pastikan PR kamu sesuai dengan standar penulisan kode dan ada penjelasan singkat tentang perubahan yang kamu buat.

---

## Setup Lokal (Laravel)

Jika kamu menggunakan Laravel, ikuti langkah-langkah berikut untuk menjalankan proyek secara lokal:

```bash
# Install dependensi
composer install

# Salin file .env
cp .env.example .env

# Generate key
php artisan key:generate

# Jalankan migrasi dan seeder (jika ada)
php artisan migrate --seed

# Jalankan server
php artisan serve
```

Jika menggunakan NPM:
```bash
npm install
npm run dev
```

---

## Laporan Masalah / Bug

Jika kamu menemukan bug atau ingin mengusulkan fitur baru, silakan buka issue di tab [Issues](https://github.com/username/nama-repo/issues).  
Pastikan kamu gunakan template issue yang tersedia (jika ada).

---

## Style Guide & Coding Standard

- Ikuti standar PSR-12 (PHP).
- Gunakan `camelCase` untuk nama variabel dan fungsi.
- Komentar harus jelas dan relevan.
- Jika membuat fitur baru, pastikan disertai dokumentasi dan unit test jika memungkinkan.

---

## Testing

Pastikan semua test berhasil dijalankan sebelum submit PR:

```bash
# Menjalankan PHPUnit
php artisan test
```

Atau jika kamu menggunakan Pest:
```bash
php artisan test --parallel
```

---

## Proses Review & Merge

- Setiap PR akan ditinjau oleh maintainer.
- Minimal 1 approval diperlukan untuk merge.
- Semua test harus lulus.
- Dokumentasi juga harus diperbarui jika ada perubahan besar.

---

## Terima Kasih ❤️

Kami sangat senang dengan partisipasi kalian semua!  
Tanpa kontributor seperti kalian, proyek ini tidak akan berkembang.

Salam hangat,  
Tim Pengembang
