# E-Commerce Laravel

Platform e-commerce sederhana berbasis Laravel 12 dengan fitur belanja, checkout, pembayaran online, dan panel admin.

## Fitur

- **Katalog produk** — daftar produk per kategori, halaman detail produk
- **Keranjang belanja** — tambah, ubah jumlah, hapus item
- **Checkout & pemesanan** — riwayat pesanan, detail pesanan
- **Kode promo** — terapkan kode diskon saat checkout
- **Pembayaran online** — integrasi [Midtrans Snap](https://midtrans.com) beserta webhook notifikasi
- **Ulasan produk** — pelanggan dapat memberi ulasan pada produk yang dibeli
- **Notifikasi email** — konfirmasi pesanan dan update status pesanan
- **Panel admin** — kelola produk (dengan upload gambar), kategori, pesanan, pengguna, dan kode promo
- **Autentikasi** — login, registrasi, manajemen profil (Laravel Breeze)

## Teknologi

- [Laravel 12](https://laravel.com) (PHP ^8.2)
- MySQL
- Bootstrap 5
- Laravel Breeze (autentikasi)
- Midtrans PHP SDK (pembayaran)

## Instalasi

1. Clone repository dan install dependency
   ```bash
   composer install
   npm install
   ```

2. Salin file environment dan generate application key
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Konfigurasi koneksi database di `.env`
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=e_commerce
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. (Opsional) Isi kredensial Midtrans untuk fitur pembayaran
   ```env
   MIDTRANS_SERVER_KEY=
   MIDTRANS_CLIENT_KEY=
   MIDTRANS_IS_PRODUCTION=false
   ```

5. Jalankan migrasi database beserta seeder data demo
   ```bash
   php artisan migrate --seed
   ```

6. Build asset frontend
   ```bash
   npm run build
   ```

7. Jalankan server pengembangan
   ```bash
   php artisan serve
   ```

   Aplikasi dapat diakses di `http://localhost:8000`.

## Akun Demo

| Peran     | Email                  | Password |
|-----------|------------------------|----------|
| Admin     | admin@example.com      | password |
| Customer  | customer@example.com   | password |

## Struktur Proyek

- `app/Models` — User, Category, Product, CartItem, Order, OrderItem, Review, PromoCode
- `app/Http/Controllers` — controller publik/customer (Home, Product, Cart, Order, Review)
- `app/Http/Controllers/Admin` — controller panel admin (Dashboard, Product, Category, Order, User, PromoCode)
- `app/Mail` — notifikasi email (konfirmasi & update status pesanan)
- `resources/views` — tampilan Blade, terbagi menjadi layout publik dan admin

## Testing

```bash
php artisan test
```

## Deployment

Proyek ini menyertakan `Dockerfile` untuk deployment (mis. ke [Koyeb](https://www.koyeb.com)). Pastikan environment variable produksi (database, Midtrans, mail) sudah dikonfigurasi sebelum deploy.
