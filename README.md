# Sistem Rekomendasi Produk E-Commerce Berbasis Pola Pembelian Pengguna

## Tentang Proyek

Sistem ini dirancang untuk merekomendasikan produk kepada pelanggan berdasarkan riwayat pembelian dan preferensi pengguna. Proyek ini menggunakan dua algoritma utama:

-   **Collaborative Filtering**: Untuk menemukan kesamaan antar pengguna dan merekomendasikan produk yang relevan.
-   **Apriori Algorithm**: Untuk menemukan pola pembelian yang sering terjadi dalam transaksi e-commerce.

Aplikasi ini dibangun menggunakan framework **Laravel** dengan front-end menggunakan **Blade Template Engine**.

## Tujuan Proyek

-   Meningkatkan pengalaman belanja online dengan memberikan rekomendasi produk yang relevan.
-   Memperkuat analisis data pembelian untuk meningkatkan penjualan.
-   Mengimplementasikan algoritma Collaborative Filtering dan Apriori Algorithm secara efektif.

## Fitur Utama

-   Rekomendasi produk berdasarkan riwayat pembelian.
-   Analisis pola pembelian menggunakan Apriori Algorithm.
-   Antarmuka pengguna yang intuitif untuk melihat rekomendasi.

## Teknologi yang Digunakan

-   **Backend**: Laravel
-   **Frontend**: Blade Template Engine
-   **Database**: MySQL (atau database lain yang digunakan)
-   **Libraries**:
    -   PHP Libraries untuk Collaborative Filtering dan Apriori Algorithm
    -   Laravel Framework
-   **Dependencies**: Lihat file `composer.json`

## Struktur Direktori

```
.
|-- app
|   |-- Http
|   |   `-- Controllers
|   |       |-- AuthController.php
|   |       |-- Controller.php
|   |       |-- DashboardController.php
|   |       `-- LamanDepanController.php
|   |-- Models
|   |   |-- Category.php
|   |   |-- Order.php
|   |   |-- OrderItem.php
|   |   |-- Product.php
|   |   |-- Rating.php
|   |   |-- Recommendation.php
|   |   |-- Testimonial.php
|   |   `-- User.php
|   |-- Observers
|   |   `-- RatingObserver.php
|   `-- Providers
|       `-- AppServiceProvider.php
|-- bootstrap
|   |-- cache
|   |   |-- packages.php
|   |   `-- services.php
|   |-- app.php
|   `-- providers.php
|-- config
|   |-- app.php
|   |-- auth.php
|   |-- cache.php
|   |-- database.php
|   |-- filesystems.php
|   |-- logging.php
|   |-- mail.php
|   |-- queue.php
|   |-- services.php
|   `-- session.php
|-- database
|   |-- factories
|   |   `-- UserFactory.php
|   |-- migrations
|   |   |-- 0001_01_01_000000_create_users_table.php
|   |   |-- 0001_01_01_000001_create_cache_table.php
|   |   |-- 0001_01_01_000002_create_jobs_table.php
|   |   `-- 2025_04_14_101534_create_ecommerce_tables.php
|   |-- seeders
|   |   |-- data
|   |   |   |-- category.json
|   |   |   |-- deskripsi_template.json
|   |   |   |-- products.json
|   |   |   |-- testimonial.json
|   |   |   `-- users.json
|   |   |-- CategorySeeder.php
|   |   |-- DatabaseSeeder.php
|   |   |-- OrderItemSeeder.php
|   |   |-- OrderSeeder.php
|   |   |-- ProductSeeder.php
|   |   |-- RatingSeeder.php
|   |   |-- RecommendationSeeder.php
|   |   |-- TestimonialSeeder.php
|   |   `-- UserSeeder.php
|   `-- database.sqlite
|-- public
|   |-- default_avatar.png
|   |-- default_icon.png
|   |-- default_product.png
|   |-- favicon.ico
|   |-- hot
|   |-- index.php
|   `-- robots.txt
|-- resources
|   |-- css
|   |   `-- app.css
|   |-- js
|   |   |-- app.js
|   |   `-- bootstrap.js
|   `-- views
|       |-- auth
|       |   |-- passwords
|       |   |   |-- email.blade.php
|       |   |   `-- reset.blade.php
|       |   |-- login.blade.php
|       |   `-- register.blade.php
|       |-- components
|       |   `-- lamandepan
|       |       |-- category-modal.blade.php
|       |       |-- hero-banner.blade.php
|       |       |-- product-card.blade.php
|       |       `-- testimonial.blade.php
|       |-- dashboard
|       |   `-- index.blade.php
|       |-- lamandepan
|       |   `-- index.blade.php
|       |-- layouts
|       |   `-- app.blade.php
|       `-- welcome.blade.php
|-- routes
|   |-- console.php
|   `-- web.php
|-- tests
|   |-- Feature
|   |   `-- ExampleTest.php
|   |-- Unit
|   |   `-- ExampleTest.php
|   `-- TestCase.php
|-- README.md
|-- artisan
|-- composer.json
|-- composer.lock
|-- package-lock.json
|-- package.json
|-- phpunit.xml
`-- vite.config.js
```

## Cara Menjalankan Proyek

1. **Clone Repository**:

    ```bash
    git clone https://github.com/LycusCoder/Sistem-Rekomendasi-Produk-E-Commerce.git
    cd Sistem-Rekomendasi-Produk-E-Commerce
    ```

2. **Install Dependencies**:

    ```bash
    composer install
    npm install (Wajib Ingat)
    ```

3. **Konfigurasi Database**:

    - Salin file `.env.example` menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
    - Edit file `.env` untuk mengatur koneksi database:
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=sistem_rekomendasi
        DB_USERNAME=root
        DB_PASSWORD=
        ```

4. **Migrasi Database**:

    ```bash
    php artisan migrate
    ```

5. **Seed Data (Jika Ada)**:

    ```bash
    php artisan db:seed
    ```

6. **Jalankan Server Laravel**:

    ```bash
    php artisan serve
    ```

    - Aplikasi akan berjalan di `http://127.0.0.1:8000`.

7. **Hasil**:
    - Akses halaman rekomendasi produk dan analisis pola pembelian melalui antarmuka web.

## Kontribusi

Kami menerima kontribusi dari siapa pun! Jika Anda ingin berkontribusi, silakan buka issue atau pull request.

## Kontak

Jika ada pertanyaan atau masukan, silakan hubungi:

-   👨‍💻 [Muhammad Affif]: affif@nourivex.tech
-   🌟 [Yesa Anggit Prayugo]: yesaprayugo4@gmail.com
-   📝 [Siti Novia Desi Nurkhikmah]: sitinoviadesi@gmail.com
-   🚀 [Naufal Miftahul Arsyij]: arsyinaufal12@gmail.com
-   🎉 [Imzy Zulijar Setiawan]: imzyzulijar01@gmail.com

## Lisensi

Proyek ini dibuat di bawah lisensi [MIT License](LICENSE).
