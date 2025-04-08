# Rentify — Web App Sewa Barang Elektronik

![Laravel](https://img.shields.io/badge/Laravel-11-red?style=flat&logo=laravel)
![Filament](https://img.shields.io/badge/Filament-v3-blueviolet?style=flat&logo=laravel)
![MySQL](https://img.shields.io/badge/MySQL-Database-informational?style=flat&logo=mysql)

**Rentify** adalah aplikasi sewa barang elektronik berbasis web yang dibangun menggunakan **Laravel 11**, **Filament v3**, dan **MySQL**. Proyek ini merupakan bagian dari pembelajaran di kelas online:

> **Web Development Laravel 11, Filament, MySQL: Sewa Barang App**  

## 📚 Deskripsi Proyek

### 🎯 Fitur Aplikasi

- 🔑 **Autentikasi User:** Super Admin & Customer
- 📁 **Manajemen Data:** Super admin dapat mengelola:
  - Kategori barang
  - Brand
  - Produk
  - Transaksi penyewaan
- 🔍 **Pencarian & Filter:** Customer dapat melihat barang berdasarkan kategori dan brand
- 🛒 **Sewa Barang:** Customer dapat menyewa barang dengan memilih:
  - Jumlah hari
  - Tipe pengiriman
  - Metode pembayaran (Bank Transfer, dll)
- 🧾 **Booking & Checkout System**
- 📦 **Tracking Transaksi**

---

## 🧠 Hal yang Dipelajari

- ✅ Mendesain database berdasarkan **brief dan ERD**
- ✅ Membuat **relasi antar tabel** untuk UX terbaik
- ✅ Menggunakan **Laravel 11 dan Filament v3** untuk mempercepat dan mengamankan development
- ✅ Membangun fitur **sewa, booking, dan pembayaran**
- ✅ Membuat fitur **tracking transaksi**

---

## 👨‍💻 Teknologi yang Digunakan

| Tech        | Keterangan                            |
|-------------|----------------------------------------|
| Laravel 11  | PHP Framework untuk Back-End           |
| Filament v3 | Admin Dashboard & CRUD Generator       |
| MySQL       | Relational Database System             |
| Blade       | Templating engine Laravel              |
| TailwindCSS | Styling (default dari Filament)        |

---

## 🚀 Cara Menjalankan Proyek

```bash
# Clone repo ini
git clone https://github.com/Guruhg19/Rentify-Web-App-for-Renting-Electronic-Goods.git

# Masuk ke folder project
cd rentify

# Install dependency
composer install

# Copy file environment dan buat database
cp .env.example .env
php artisan key:generate

# Jalankan migration dan seeder (jika tersedia)
php artisan migrate --seed

# Jalankan server lokal
php artisan serve
