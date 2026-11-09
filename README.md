# Balih Film

Aplikasi web pemesanan tiket bioskop online modern berbasis **Laravel 13** dan **Tailwind CSS v4**. Balih Film menyediakan alur pemesanan tiket lengkap mulai dari katalog film, pemilihan jadwal dan tipe studio, denah kursi interaktif, pemesanan makanan dan minuman (concessions), hingga penerbitan e-ticket digital lengkap dengan barcode.

---

## Fitur Utama

- **Katalog Film (Now Playing & Upcoming)**:
  - Daftar film yang sedang tayang dan segera tayang.
  - Halaman detail film dengan sinopsis, genre, durasi, batasan usia (rating), daftar pemeran, sutradara, dan tautan trailer.
- **Jadwal Tayang & Multi-Studio**:
  - Filter jadwal tayang berdasarkan tanggal.
  - Mendukung berbagai kategori studio bioskop: *Dolby Atmos*, *Regular Classic*, dan *VIP Premiere Lounge* dengan penyesuaian biaya studio.
- **Denah Kursi Interaktif (Interactive Seat Selection)**:
  - Visualisasi tata letak kursi per studio (misal baris A-F kolom 1-8).
  - Indikator status kursi: tersedia, terpilih, atau sudah terisi (booked).
  - Validasi ketat untuk mencegah *double booking* dan batas maksimal kursi per transaksi.
- **Pemesanan Makanan & Minuman (Concessions)**:
  - Pilihan makanan ringan (Popcorn Caramel, Butter, Nachos, French Fries) dan minuman dingin, serta paket combo hemat.
  - Perhitungan subtotal otomatis tergabung ke dalam rincian pembayaran.
- **Pembayaran & E-Ticket Digital**:
  - Pilihan metode pembayaran (QRIS, Transfer Bank / Virtual Account).
  - Pembuatan kode booking unik (contoh: `BF-202610-XXXX`) dan barcode tiket untuk verifikasi saat masuk studio.
- **Pencarian Tiket (Ticket Lookup)**:
  - Halaman cek tiket untuk memudahkan pengunjung melihat kembali detail pemesanan hanya dengan memasukkan kode booking.

---

## Teknologi yang Digunakan

| Komponen | Teknologi |
| --- | --- |
| **Framework Backend** | [Laravel 13](https://laravel.com/) (PHP 8.3+) |
| **Database** | SQLite (default untuk development) / MySQL |
| **Styling & UI** | [Tailwind CSS v4](https://tailwindcss.com/) |
| **Asset Bundler** | [Vite](https://vitejs.dev/) |
| **Testing** | [PHPUnit 12](https://phpunit.de/) |

---

## Prasyarat Sistem

Sebelum menjalankan proyek, pastikan perangkat Anda telah terinstal:
- PHP >= 8.3 (dengan ekstensi `pdo`, `sqlite3` atau `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) (versi LTS disarankan, minimal v18+) & NPM

---

## Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### 1. Kloning Repositori
```bash
git clone https://github.com/aldwrnnnnn/balihfilm.git
cd balihfilm
```

### 2. Instal Dependensi PHP
```bash
composer install
```

### 3. Konfigurasi Environment
Salin file konfigurasi `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
*(Pada sistem operasi Windows PowerShell, gunakan `copy .env.example .env`)*

Lalu buat kunci aplikasi (*application key*):
```bash
php artisan key:generate
```

### 4. Migrasi Database dan Seeder
Jalankan migrasi tabel dan isi data awal (film, studio, jadwal tayang, F&B, dan contoh transaksi):
```bash
php artisan migrate --seed
```

### 5. Instal Dependensi Frontend & Kompilasi Aset
```bash
npm install
npm run build
```
*(Untuk mode pengembangan dengan hot reload, jalankan `npm run dev`)*

### 6. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

---

## Pengujian (Testing)

Proyek ini telah dilengkapi automated test suite menggunakan PHPUnit untuk memastikan validasi alur pemesanan, ketersediaan kursi, dan keamanan transaksi berjalan dengan benar:

```bash
php artisan test
```

Cakupan pengujian meliputi:
- Pemuatan halaman katalog dan detail film.
- Tampilan denah kursi dan daftar menu F&B.
- Alur pemesanan tiket, validasi email/telepon, dan penerbitan barcode.
- Pencegahan pemesanan kursi yang sudah dipesan orang lain (*double-booking prevention*).
- Validasi format dan batas maksimal pemesanan kursi.
- Pencegahan pemesanan untuk jadwal tayang yang sudah lewat.
- Fitur pelacakan tiket berdasarkan kode pemesanan.

---

## Lisensi

Proyek ini dirilis di bawah lisensi [MIT License](LICENSE).
