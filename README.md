# Buku Tamu SMKN 4 Tanjungpinang

Aplikasi buku tamu berbasis Laravel 10 untuk kios pencatatan kunjungan dan pengelolaan rekap oleh superadmin.

## Persyaratan

- PHP 8.1 atau lebih baru dengan ekstensi GD
- Composer
- MySQL atau MariaDB
- Node.js hanya diperlukan bila aset Vite dikembangkan kembali

## Instalasi

1. Pasang dependency:

   ```bash
   composer install
   ```

2. Salin `.env.example` menjadi `.env`, lalu isi konfigurasi aplikasi dan database.

3. Buat application key:

   ```bash
   php artisan key:generate
   ```

4. Isi kredensial superadmin di `.env`:

   ```dotenv
   ADMIN_NAME="Administrator"
   ADMIN_USERNAME=admin
   ADMIN_PASSWORD=password-yang-kuat
   ```

5. Jalankan migration dan seeder:

   ```bash
   php artisan migrate --seed
   ```

Seeder hanya membuat akun ketika superadmin belum tersedia. Menjalankan seeder kembali tidak menggandakan akun dan tidak mengembalikan password yang sudah diubah melalui menu Profil.

6. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

## Penggunaan

- Form kios: `/form-tamu`
- Login admin: `/auth/login`
- Dashboard dan rekap: `/rekap`
- Profil admin: `/profile`

Foto pengunjung disimpan secara privat di `storage/app/visitor-photos` dan hanya diberikan melalui route yang dilindungi autentikasi. `php artisan storage:link` tidak diperlukan untuk foto tamu dan tidak tersedia melalui route web.

## Profil Admin

Admin dapat mengubah nama lengkap, username, serta password. Password lama tidak diminta. Password baru bersifat opsional dan harus dikonfirmasi bila diisi.

## Pengujian

Test menggunakan SQLite in-memory dan tidak menyentuh database pada `.env`:

```bash
php artisan test
```

Untuk memeriksa sintaks dan route:

```bash
php artisan route:list
php artisan migrate:status
```

## Deployment Lokal

Seluruh CSS, JavaScript, ikon, font, kamera, dan aset tampilan dimuat dari server lokal. Aplikasi tidak memerlukan akses CDN atau internet, tetapi perangkat kios tetap harus dapat mengakses server sekolah.
