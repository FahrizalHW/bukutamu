# Buku Tamu Digital SMKN 4 Tanjungpinang

Aplikasi buku tamu berbasis Laravel 10 untuk mencatat kunjungan melalui perangkat kios dan mengelola statistik serta rekap kunjungan sekolah.

## Fitur

- Beranda publik dengan akses menuju Form Tamu dan login.
- Form Tamu yang dilindungi autentikasi untuk akun `guest` dan `superadmin`.
- Pengambilan foto pengunjung melalui kamera perangkat.
- Dashboard statistik kunjungan harian, bulanan, total, dan tren tujuh hari.
- Rekap kunjungan menggunakan Yajra DataTables server-side.
- Filter rekap berdasarkan bulan atau rentang tanggal.
- Ekspor rekap ke Excel dan PDF.
- Pengelolaan profil superadmin.
- Aset tampilan disimpan lokal tanpa ketergantungan CDN.

## Persyaratan

- PHP 8.1 atau lebih baru dengan ekstensi yang dibutuhkan Laravel, GD, dan database.
- Composer.
- MySQL atau MariaDB.
- Browser modern dengan akses kamera.
- HTTPS pada server produksi agar akses kamera dapat digunakan dengan baik.
- Node.js hanya diperlukan jika aset frontend akan dikompilasi ulang.

## Instalasi

1. Pasang dependency PHP:

   ```bash
   composer install
   ```

2. Salin `.env.example` menjadi `.env`, kemudian isi konfigurasi aplikasi dan database.

3. Buat application key:

   ```bash
   php artisan key:generate
   ```

4. Atur kredensial superadmin dan akun tamu bersama pada `.env`:

   ```dotenv
   ADMIN_NAME="Administrator"
   ADMIN_USERNAME=admin
   ADMIN_PASSWORD="password-admin-yang-kuat"

   GUEST_NAME="Tamu"
   GUEST_USERNAME=tamu
   GUEST_PASSWORD="password-tamu"
   ```

   Gunakan password yang sesuai kebijakan keamanan pada environment produksi.

5. Jalankan migration dan seeder:

   ```bash
   php artisan migrate --seed
   ```

6. Jalankan aplikasi untuk pengembangan lokal:

   ```bash
   php artisan serve
   ```

Aplikasi dapat diakses melalui alamat yang ditampilkan oleh Artisan, biasanya `http://127.0.0.1:8000`.

## Akun dan Hak Akses

Aplikasi menggunakan guard web yang sama dengan pembatasan berdasarkan role:

| Role | Hak akses |
| --- | --- |
| Publik | Beranda dan halaman login |
| `guest` | Beranda, Form Tamu, dan logout |
| `superadmin` | Dashboard, Rekap, Profil, Form Tamu, dan logout |

Akun `guest` merupakan akun bersama yang proses loginnya dibantu operator. Setelah data kunjungan disimpan, sesi tetap aktif agar operator tidak perlu login ulang untuk setiap pengunjung.

`AdminSeeder` hanya membuat superadmin jika akun dengan role tersebut belum tersedia. `GuestSeeder` menggunakan `updateOrCreate`, sehingga menjalankan seeder kembali tidak membuat akun guest ganda dan akan menyelaraskan nama, role, serta password dengan konfigurasi `.env`.

## Route Utama

| Halaman | URL | Akses |
| --- | --- | --- |
| Beranda | `/home` | Publik |
| Login | `/auth/login` | Publik |
| Form Tamu | `/form-tamu` | Guest dan superadmin |
| Dashboard | `/dashboard` | Superadmin |
| Rekap | `/rekap` | Superadmin |
| Profil | `/profile` | Superadmin |

Setelah login, akun guest diarahkan ke Form Tamu dan superadmin diarahkan ke Dashboard. Route lama `/daftar-tamu` tetap dialihkan ke `/rekap`.

## Rekap dan Ekspor

Tabel Rekap menggunakan Yajra DataTables dengan pemrosesan server-side. Pencarian, pagination, dan pengurutan diproses oleh server. Filter bulan dan rentang tanggal bersifat saling eksklusif; jika keduanya dikirim, filter bulan diprioritaskan.

Ekspor Excel dan PDF tersedia hanya pada halaman Rekap serta mengikuti filter dan pencarian yang sedang aktif.

## Penyimpanan Foto

Foto pengunjung disimpan secara privat di `storage/app/visitor-photos` dan diberikan melalui route yang dilindungi autentikasi superadmin. Foto tidak dipublikasikan melalui symlink, sehingga `php artisan storage:link` tidak diperlukan untuk fitur ini.

Pastikan web server memiliki izin tulis ke direktori `storage` dan `bootstrap/cache`.

## Aset Frontend

Aset runtime, termasuk DataTables Bootstrap 5, ikon, font, CSS, dan JavaScript, tersedia di dalam direktori `public/assets`. Server produksi tidak membutuhkan `node_modules` atau akses CDN.

Jika sumber aset frontend diubah, pasang dependency dan kompilasi ulang:

```bash
npm ci
npm run build
```

Folder `node_modules` dapat dihapus setelah proses build selesai dan tidak perlu dikirim ke server produksi.

## Pengujian

Test menggunakan SQLite in-memory dan tidak menyentuh database pada `.env`:

```bash
php artisan test
```

Pemeriksaan tambahan:

```bash
php artisan route:list
php artisan migrate:status
```

## Deployment Produksi

Pastikan konfigurasi `APP_URL`, database, kredensial admin, dan kredensial guest telah diisi. Gunakan `APP_ENV=production` dan `APP_DEBUG=false`, lalu jalankan:

```bash
composer install --no-dev --optimize-autoloader
php artisan optimize:clear
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Untuk deployment lama yang hanya perlu menambahkan atau memperbarui akun guest, seeder dapat dijalankan secara khusus:

```bash
php artisan db:seed --class=GuestSeeder --force
```

Setiap perubahan route atau konfigurasi di production harus diikuti dengan pembersihan dan pembangunan ulang cache Laravel seperti langkah di atas.
