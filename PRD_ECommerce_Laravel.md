# Product Requirements Document (PRD): E-Commerce Platform

## 1. Ringkasan Eksekutif
Membangun platform e-commerce yang scalable, aman, dan user-friendly menggunakan **Laravel** sebagai backend utama. Platform ini bertujuan untuk memfasilitasi transaksi jual-beli online dengan fitur manajemen produk, keranjang belanja, integrasi pembayaran, dan manajemen pesanan.

## 2. Tujuan & Sasaran
* **User:** Memudahkan pelanggan mencari, memilih, dan membeli produk.
* **Admin:** Menyediakan dashboard untuk mengelola inventaris, pesanan, dan pelanggan.
* **Teknis:** Menggunakan arsitektur yang modular dan efisien untuk mendukung pengembangan di masa depan.

## 3. User Stories
| User | Kebutuhan | Tujuan |
| :--- | :--- | :--- |
| **Pelanggan** | Mencari & memfilter produk | Menemukan barang dengan cepat |
| **Pelanggan** | Menambahkan item ke keranjang | Melakukan pembelian sekaligus |
| **Pelanggan** | Melakukan checkout & bayar | Menyelesaikan transaksi |
| **Admin** | CRUD Produk & Kategori | Mengelola katalog toko |
| **Admin** | Melihat laporan penjualan | Memantau performa toko |

## 4. Spesifikasi Teknis
* **Framework:** Laravel 11+
* **Database:** MySQL / PostgreSQL
* **Frontend:** Blade Templates (dengan Livewire untuk interaktivitas) atau API-based (dengan Vue/React).
* **Authentication:** Laravel Breeze atau Jetstream (Fortify).
* **Payment Gateway:** Integrasi Midtrans atau Xendit (Standar di Indonesia).
* **Storage:** AWS S3 atau Local Storage untuk gambar produk.

## 5. Fitur Utama (Functional Requirements)

### A. Sisi Pelanggan (Public)
* **Registrasi & Login:** Sistem autentikasi aman dengan verifikasi email.
* **Katalog Produk:** Tampilan daftar produk dengan pencarian (search) dan filter kategori.
* **Detail Produk:** Informasi spesifikasi, harga, stok, dan gambar produk.
* **Keranjang Belanja:** Menambah, mengubah kuantitas, dan menghapus item.
* **Checkout & Pembayaran:** Integrasi Payment Gateway (VA, E-Wallet, QRIS).
* **Riwayat Pesanan:** Melacak status pesanan (Pending, Paid, Shipped, Done).

### B. Sisi Admin (Dashboard)
* **Manajemen Produk:** Tambah/Edit/Hapus produk, kategori, dan stok.
* **Manajemen Pesanan:** Melihat daftar pesanan, update status pengiriman, dan validasi pembayaran.
* **Manajemen User:** Melihat daftar pelanggan terdaftar.
* **Dashboard Statistik:** Ringkasan pendapatan harian/bulanan.

## 6. Arsitektur Database (High-Level)
* **Users:** ID, Name, Email, Password, Role.
* **Products:** ID, Name, Slug, Description, Price, Stock, Category_ID.
* **Categories:** ID, Name.
* **Orders:** ID, User_ID, Total_Price, Status, Payment_Ref.
* **Order_Items:** ID, Order_ID, Product_ID, Quantity, Price.

## 7. Roadmap Pengembangan
1. **Fase 1 (MVP):** Autentikasi, Katalog Produk, dan Keranjang Belanja.
2. **Fase 2:** Integrasi Payment Gateway dan sistem Order.
3. **Fase 3:** Dashboard Admin, Fitur Promo/Diskon, dan Laporan.
4. **Fase 4:** Optimasi performa (Caching Redis) dan Deployment.

## 8. Kebutuhan Non-Fungsional
* **Keamanan:** Proteksi terhadap SQL Injection, XSS, dan CSRF (bawaan Laravel).
* **Responsivitas:** Tampilan harus Mobile-Friendly.
* **Kecepatan:** Waktu loading halaman maksimal < 2 detik.
