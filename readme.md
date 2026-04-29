# Cashier RS Delta Surya

Sistem Kasir untuk RS Delta Surya yang dibangun menggunakan Laravel. Proyek ini mencakup fitur manajemen transaksi dan pengiriman laporan otomatis via email.

## Prasyarat

Pastikan Anda telah menginstal perangkat lunak berikut di komputer Anda:
- PHP >= 8.2 (rekomendasi 8.5)
- Composer
- Node.js & NPM
- MySQL/MariaDB (atau Laragon)

## Langkah Instalasi

1. **Clone Repositori**
   ```bash
   git clone https://github.com/agungwahyu23/cashier-rs-delta-surya.git
   cd cashier-rs-delta-surya
   ```

2. **Instal Dependensi PHP**
   ```bash
   composer install
   ```

3. **Instal Dependensi Frontend**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan konfigurasi database serta mailer Anda:
   ```env
   DB_DATABASE=cashier_rs_delta_surya
   DB_USERNAME=root
   DB_PASSWORD=

   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=techaksara@gmail.com
   MAIL_PASSWORD='susa fkwn dskd fgdk'
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=techaksara@gmail.com
   MAIL_FROM_NAME="${APP_NAME}"

   AUTH_USERNAME="agungwahyu23699@gmail.com"
   AUTH_PASSWORD="087754314117"


   ```

5. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database & Seeding**
   Pastikan database sudah dibuat di MySQL, lalu jalankan:
   ```bash
   php artisan migrate --seed
   ```

7. **Link Storage**
   ```bash
   php artisan storage:link
   ```

## Menjalankan Aplikasi

1. **Menjalankan Server Laravel**
   ```bash
   php artisan serve
   ```
   Aplikasi akan tersedia di `http://127.0.0.1:8000`.

2. **Menjalankan Vite (Frontend)**
   Buka terminal baru dan jalankan:
   ```bash
   npm run dev
   ```

## Menjalankan Task Scheduler (Cron)

Proyek ini memiliki fitur laporan transaksi otomatis yang berjalan setiap hari pada jam 01:00 AM. Untuk menjalankannya secara lokal (testing):

```bash
php artisan schedule:work
```

Untuk menjalankan perintah laporan secara manual:
```bash
php artisan report:transactions
```

## Akun Demo

Setelah menjalankan seeder, Anda dapat login menggunakan akun berikut:

| Peran | Email | Password |
|-------|-------|----------|
| Super Admin | `superadmin@demo.com` | `12345678` |
| Kasir | `kasir@mailinator.com` | `12345678` |
| Marketing | `marketing@mailinator.com` | `12345678` |

## Fitur Utama
- **Dashboard Marketing**: Visualisasi statistik asuransi dan kunjungan.
- **Manajemen Transaksi**: Input transaksi dengan sistem draft dan validasi voucher.
- **Laporan Otomatis**: Pengiriman laporan transaksi harian dalam format Excel ke email.

## Lisensi
Proyek ini dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).
